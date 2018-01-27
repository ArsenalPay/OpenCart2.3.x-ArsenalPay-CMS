<?php

class ControllerExtensionPaymentArsenalpay extends Controller {

	public function index() {
		$this->load->language( 'extension/payment/arsenalpay' );
		$this->load->model( 'checkout/order' );

		$order_id = $this->session->data['order_id'];
		$order    = $this->model_checkout_order->getOrder( $order_id );
		$total    = $this->get_total( $order );

		$user_id = '';
		if ( $this->customer->isLogged() ) {
			$user_id = $this->customer->getId();
		}

		$widget_id   = $this->config->get( 'arsenalpay_widget_id' );
		$widget_key  = $this->config->get( 'arsenalpay_widget_key' );
		$nonce       = md5( microtime( true ) . mt_rand( 100000, 999999 ) );
		$sign_data   = "$user_id;$order_id;$total;$widget_id;$nonce";
		$widget_sign = hash_hmac( 'sha256', $sign_data, $widget_key );

		$data = array(
			'order_id'    => $order_id,
			'widget_id'   => $widget_id,
			'total'       => $total,
			'user_id'     => $user_id,
			'nonce'       => $nonce,
			'widget_sign' => $widget_sign
		);
		$this->cart->clear();

		return $this->load->view( 'extension/payment/arsenalpay_widget', $data );
	}

	public function ap_callback() {
		$this->load->model( 'checkout/order' );
		$this->load->model( 'extension/payment/arsenalpay' );
		$this->load->language( 'extension/payment/arsenalpay' );
		$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
		$this->log( 'Remote IP: ' . $REMOTE_ADDR );

		$IP_ALLOW = trim($this->config->get('arsenalpay_ip'));
		if (strlen($IP_ALLOW) > 0 && $IP_ALLOW != $REMOTE_ADDR) {
			$this->log("Denied IP");
			$this->exitf('ERR');
		}

		$callback_params = $this->request->post;
		if ( ! $this->check_params( $callback_params ) ) {
			$this->exitf( 'ERR' );
		}
		$ap_order_id = $callback_params['ACCOUNT'];

		$order    = $this->model_checkout_order->getOrder( $ap_order_id );
		$function = $callback_params['FUNCTION'];

		if ( $order === false || $order['order_id'] != $ap_order_id ) {
			$comment = "Payment failed";
			$this->model_checkout_order->addOrderHistory( $ap_order_id, $this->config->get( 'arsenalpay_failed_status_id' ), $comment, true );

			if ( $function == "check" ) {
				$this->exitf( 'NO' );
			}
			$this->exitf( "ERR" );
		}

		$KEY = $this->config->get( 'arsenalpay_callback_key' );
		if ( ! ( $this->check_sign( $callback_params, $KEY ) ) ) {
			$this->exitf( 'ERR' );
		}

		switch ( $function ) {
			case 'check':
				$this->callback_check( $callback_params, $order );
				break;

			case 'payment':
				$this->callback_payment( $callback_params, $order );
				break;

			case 'cancel':
				$this->callback_cancel( $callback_params, $order );
				break;

			case 'cancelinit':
				$this->callback_cancel( $callback_params, $order );
				break;

			case 'refund':
				$this->callback_refund( $callback_params, $order );
				break;

			case 'reverse':
				$this->callback_reverse( $callback_params, $order );
				break;

			case 'reversal':
				$this->callback_reverse( $callback_params, $order );
				break;

			case 'hold':
				$this->callback_hold( $callback_params, $order );
				break;

			default: {
				$comment = $this->language->get( 'callback_fail' );
				$this->model_checkout_order->addOrderHistory( $ap_order_id, $this->config->get( 'arsenalpay_failed_status_id' ), $comment, true );
				$this->log( 'Error in callback' );
				$this->exitf( 'ERR' );
			}
		}
	}

	private function callback_cancel( $callback_params, $order ) {
		$required_statuses = array(
			$this->config->get( 'arsenalpay_holden_status_id' ),
			$this->config->get( 'arsenalpay_checked_status_id' ),
		);
		if ( ! in_array( $order['order_status_id'], $required_statuses ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has not been checked.' );
			$this->exitf( 'ERR' );
		}

		$comment = $this->language->get( 'callback_cancel' );
		$this->log( $comment );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_canceled_status_id' ), $comment, true );
		$this->exitf( 'OK' );
	}

	private function callback_check( $callback_params, $order ) {
		$rejected_statuses = array(
			$this->config->get( 'arsenalpay_canceled_status_id' ),
			$this->config->get( 'arsenalpay_reversed_status_id' ),
			$this->config->get( 'arsenalpay_refunded_status_id' ),
			$this->config->get( 'arsenalpay_completed_status_id' ),
		);
		if ( in_array( $order['order_status_id'], $rejected_statuses ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has rejected status(' . $order['order_status'] . ')' );
			$this->exitf( 'NO' );
		}
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $this->get_total( $order ) == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $this->get_total( $order ) >= $callback_params['AMOUNT'] && $this->get_total( $order ) == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$this->log( 'Check error: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $this->get_total( $order ) . ')' );
			$this->exitf( "NO" );
		}
		$comment = $this->language->get( 'callback_check' );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_checked_status_id' ), $comment, true );
		$this->exitf( 'YES' );
	}

	private function callback_payment( $callback_params, $order ) {
		$required_statuses = array(
			$this->config->get( 'arsenalpay_holden_status_id' ),
			$this->config->get( 'arsenalpay_checked_status_id' ),
		);

		if ( ! in_array( $order['order_status_id'], $required_statuses ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has not been checked.' );
			$this->exitf( 'ERR' );
		}
		$comment = '';
		if ( $callback_params['MERCH_TYPE'] == 0 && $this->get_total( $order ) == $callback_params['AMOUNT'] ) {
			$comment = $this->language->get( 'callback_complete' );
		}
		elseif ( $callback_params['MERCH_TYPE'] == 1 && $this->get_total( $order ) >= $callback_params['AMOUNT'] && $this->get_total( $order ) == $callback_params['AMOUNT_FULL'] ) {
			$currency_code = $this->config->get( 'arsenalpay_currency_code' );
			$comment       = $this->language->get( 'callback_complete_p' ) . " " . $callback_params['AMOUNT'] . " " . $currency_code;
		}
		else {
			$this->log( 'Payment error: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $this->get_total( $order ) . ')' );
			$this->exitf( "ERR" );
		}

		$this->log( $comment );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_completed_status_id' ), $comment, true );
		$this->exitf( 'OK' );
	}

	private function callback_hold( $callback_params, $order ) {
		$required_statuses = array(
			$this->config->get( 'arsenalpay_holden_status_id' ),
			$this->config->get( 'arsenalpay_checked_status_id' ),
		);
		if ( ! in_array( $order['order_status_id'], $required_statuses ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has not been checked. Order has status (' . $order['order_status'] . ')' );
			$this->exitf( 'ERR' );
		}
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $this->get_total( $order ) == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $this->get_total( $order ) >= $callback_params['AMOUNT'] && $this->get_total( $order ) == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$this->log( 'Hold error: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $this->get_total( $order ) . ')' );
			$this->exitf( "ERR" );
		}
		$comment = $this->language->get( 'callback_hold' );
		$this->log( $comment );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_holden_status_id' ), $comment, true );
		$this->exitf( 'OK' );
	}

	private function callback_refund( $callback_params, $order ) {
		$required_statuses = array(
			$this->config->get( 'arsenalpay_refunded_status_id' ),
			$this->config->get( 'arsenalpay_completed_status_id' ),
		);
		if ( ! in_array( $order['order_status_id'], $required_statuses ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has not been paid or refunded. Order has status (' . $order['order_status'] . ')' );
			$this->exitf( 'ERR' );
		}

		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $this->get_total( $order ) >= $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $this->get_total( $order ) >= $callback_params['AMOUNT'] && $this->get_total( $order ) >= $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$this->log( "Refund error: Paid amount({$this->get_total($order)}) < refund amount({$callback_params['AMOUNT']})" );
			$this->exitf( 'ERR' );
		}
		$currency_code = $this->config->get( 'arsenalpay_currency_code' );
		$comment       = $this->language->get( 'callback_refund' ) . " " . $callback_params['AMOUNT'] . " " . $currency_code;
		$this->log( $comment );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_refunded_status_id' ), $comment, true );
		$this->exitf( 'OK' );
	}

	private function callback_reverse( $callback_params, $order ) {
		if ( $order['order_status_id'] != $this->config->get( 'arsenalpay_completed_status_id' ) ) {
			$this->log( 'Aborting, Order #' . $order['order_id'] . ' has not been paid. Order has status (' . $order['order_status'] . ')' );
			$this->exitf( 'ERR' );
		}
		$isCorrectAmount = ( $callback_params['MERCH_TYPE'] == 0 && $this->get_total( $order ) == $callback_params['AMOUNT'] ) ||
		                   ( $callback_params['MERCH_TYPE'] == 1 && $this->get_total( $order ) >= $callback_params['AMOUNT'] && $this->get_total( $order ) == $callback_params['AMOUNT_FULL'] );

		if ( ! $isCorrectAmount ) {
			$this->log( 'Reverse error: Amounts do not match (request amount ' . $callback_params['AMOUNT'] . ' and ' . $this->get_total( $order ) . ')' );
			$this->exitf( 'ERR' );
		}

		$comment = $this->language->get( 'callback_reverse' );
		$this->log( $comment );
		$this->model_checkout_order->addOrderHistory( $order['order_id'], $this->config->get( 'arsenalpay_reversed_status_id' ), $comment, true );
		$this->exitf( 'OK' );
	}

	private function check_params( $callback_params ) {
		$required_keys = array
		(
			'ID',           /* Merchant identifier */
			'FUNCTION',     /* Type of request to which the response is received*/
			'RRN',          /* Transaction identifier */
			'PAYER',        /* Payer(customer) identifier */
			'AMOUNT',       /* Payment amount */
			'ACCOUNT',      /* Order number */
			'STATUS',       /* When /check/ - response for the order number checking, when
									// payment/ - response for status change.*/
			'DATETIME',     /* Date and time in ISO-8601 format, urlencoded.*/
			'SIGN',         /* Response sign  = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(request amount).
									// md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */
		);

		/**
		 * Checking the absence of each parameter in the post request.
		 */
		foreach ( $required_keys as $key ) {
			if ( empty( $callback_params[$key] ) || ! array_key_exists( $key, $callback_params ) ) {
				$this->log( 'Error in callback parameters ERR' . $key );

				return false;
			} else {
				$this->log( " $key=$callback_params[$key]" );

			}
		}

		if ( $callback_params['FUNCTION'] != $callback_params['STATUS'] ) {
			$this->log( "Error: FUNCTION ({$callback_params['FUNCTION']} not equal STATUS ({$callback_params['STATUS']})" );

			return false;
		}

		return true;
	}

	/**
	 * Return total price taking into account the currency
	 *
	 * @param $order
	 *
	 * @return string total price
	 */
	private function get_total( $order ) {
		$from = $order['currency_code'];
		$to   = $this->config->get( 'arsenalpay_currency_code' );

		$amount = $this->currency->format( $order['total'], $order['currency_code'], false, false );
		$amount = $this->currency->convert( $amount, $from, $to );
		$total  = number_format( $amount, 2, '.', '' );

		return $total;
	}

	private function check_sign( $ars_callback, $pass ) {
		$validSign = ( $ars_callback['SIGN'] === md5( md5( $ars_callback['ID'] ) .
		                                              md5( $ars_callback['FUNCTION'] ) . md5( $ars_callback['RRN'] ) .
		                                              md5( $ars_callback['PAYER'] ) . md5( $ars_callback['AMOUNT'] ) . md5( $ars_callback['ACCOUNT'] ) .
		                                              md5( $ars_callback['STATUS'] ) . md5( $pass ) ) ) ? true : false;

		return $validSign;
	}

	private function exitf( $msg ) {
		$this->log( $msg );
		echo $msg;
		die;
	}

	private function log( $message ) {
		if ( $this->config->get( 'arsenalpay_debug' ) ) {
			$log = new Log( 'arsenalpay.log' );
			$log->write( $message );
		}
	}
}
           

