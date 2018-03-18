<?php

class ControllerExtensionPaymentArsenalpay extends Controller {
	private $callback;

	public function index() {
		$this->load->language('extension/payment/arsenalpay');
		$this->load->model('checkout/order');

		$order_id = $this->session->data['order_id'];
		$order    = $this->model_checkout_order->getOrder($order_id);
		$total    = $this->get_total($order);

		$user_id = '';
		if ($this->customer->isLogged()) {
			$user_id = $this->customer->getId();
		}

		$widget_id   = $this->config->get('arsenalpay_widget_id');
		$widget_key  = $this->config->get('arsenalpay_widget_key');
		$nonce       = md5(microtime(true) . mt_rand(100000, 999999));
		$sign_data   = "$user_id;$order_id;$total;$widget_id;$nonce";
		$widget_sign = hash_hmac('sha256', $sign_data, $widget_key);

		$data = array(
			'order_id'    => $order_id,
			'widget_id'   => $widget_id,
			'total'       => $total,
			'user_id'     => $user_id,
			'nonce'       => $nonce,
			'widget_sign' => $widget_sign
		);
		$this->cart->clear();

		return $this->load->view('extension/payment/arsenalpay_widget', $data);
	}

	public function ap_callback() {
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/arsenalpay');
		$this->load->language('extension/payment/arsenalpay');
		$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
		$this->log('Remote IP: ' . $REMOTE_ADDR . " params: " . json_encode($this->request->post));

		$IP_ALLOW = trim($this->config->get('arsenalpay_ip'));
		if (strlen($IP_ALLOW) > 0 && $IP_ALLOW != $REMOTE_ADDR) {
			$this->log("Denied IP");
			$this->exitf('ERR');
		}

		$this->callback = $this->request->post;
		if (!$this->check_params($this->callback)) {
			$this->exitf('ERR');
		}
		$ap_order_id = $this->callback['ACCOUNT'];

		$order    = $this->model_checkout_order->getOrder($ap_order_id);
		$function = $this->callback['FUNCTION'];

		if ($order === false || $order['order_id'] != $ap_order_id) {
			$comment = "Payment failed";
			$this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);

			if ($function == "check") {
				$this->exitf('NO');
			}
			$this->exitf("ERR");
		}

		$KEY = $this->config->get('arsenalpay_callback_key');
		if (!($this->check_sign($this->callback, $KEY))) {
			$this->exitf('ERR');
		}

		switch ($function) {
			case 'check':
				$this->callback_check($order);
				break;

			case 'payment':
				$this->callback_payment($order);
				break;

			case 'cancel':
				$this->callback_cancel($order);
				break;

			case 'cancelinit':
				$this->callback_cancel($order);
				break;

			case 'refund':
				$this->callback_refund($order);
				break;

			case 'reverse':
				$this->callback_reverse($order);
				break;

			case 'reversal':
				$this->callback_reverse($order);
				break;

			case 'hold':
				$this->callback_hold($order);
				break;

			default: {
				$comment = $this->language->get('callback_fail');
				$this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);
				$this->log('Error in callback');
				$this->exitf('ERR');
			}
		}
	}

	private function callback_cancel($order) {
		$required_statuses = array(
			$this->config->get('arsenalpay_holden_status_id'),
			$this->config->get('arsenalpay_checked_status_id'),
		);
		if (!in_array($order['order_status_id'], $required_statuses)) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has not been checked.');
			$this->exitf('ERR');
		}

		$comment = $this->language->get('callback_cancel');
		$this->log($comment);
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_canceled_status_id'), $comment, true);
		$this->exitf('OK');
	}

	private function callback_check($order) {
		$rejected_statuses = array(
			$this->config->get('arsenalpay_canceled_status_id'),
			$this->config->get('arsenalpay_reversed_status_id'),
			$this->config->get('arsenalpay_refunded_status_id'),
			$this->config->get('arsenalpay_completed_status_id'),
		);
		if (in_array($order['order_status_id'], $rejected_statuses)) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has rejected status(' . $order['order_status'] . ')');
			$this->exitf('ERR');
		}
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $this->get_total($order) == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $this->get_total($order) >= $this->callback['AMOUNT'] && $this->get_total($order) == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$this->log('Check error: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $this->get_total($order) . ')');
			$this->exitf("ERR");
		}

		$fiscal = array();
		if (isset($this->callback['OFD']) && $this->callback['OFD'] == 1) {
			$fiscal = $this->prepare_fiscal($order);
			if (!$fiscal) {
				$this->log("Check error: Fiscal document is empty");
				$this->exitf("ERR");
			}
		}

		$comment = $this->language->get('callback_check');
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_checked_status_id'), $comment, true);
		$this->exitf('YES', $fiscal);
	}


	private function prepare_phone($phone) {
		$phone = preg_replace('/[^0-9]/', '', $phone);
		if (strlen($phone) < 10) {
			return false;
		}
		if (strlen($phone) == 10) {
			return $phone;
		}
		if (strlen($phone) == 11) {
			return substr($phone, 1);
		}

		return false;

	}

	private function prepare_fiscal($order) {
		$this->load->model('account/order');
		$this->load->model('checkout/order');
		$this->load->model('catalog/product');
		$order_data = $this->model_checkout_order->getOrder($order['order_id']);
		$RUB        = $this->config->get('arsenalpay_currency_code');

		$fiscal = array(
			"id"      => $this->callback['ID'],
			"type"    => "sell",
			"receipt" => array(
				"attributes" => array(
					"email" => $order['email']
				),
				"items"      => array(),
			),
		);

		if ($phone = $this->prepare_phone($order['telephone'])) {
			$fiscal['receipt']['attributes']['phone'] = $phone;
		}

		$products = $this->model_account_order->getOrderProducts($order['order_id']);
		$totals   = $this->model_account_order->getOrderTotals($order['order_id']);
		/**
		 * Необходимо учитывать значения от бонусов, налогов и т.п.
		 * У бонусов отрицательное value
		 */
		$total_tax     = 0;
		$voucher       = 0;
		$shipping      = 0;
		$subtotal      = 0;
		$coupon        = 0;
		$reward        = 0;
		$credit        = 0;
		$low_order_fee = 0;
		$handling      = 0;

		$shipping_tax_class_id = null;

		foreach ($totals as $total) {
			switch ($total['code']) {
				case 'tax':
					$total_tax += $total['value'];
					break;
				case 'shipping':
					$shipping              += $total['value'];
					$shipping_tax_class_id = isset($total['tax_class_id']) ? $total['tax_class_id'] : null;
					break;
				case 'sub_total':
					$subtotal += $total['value'];
					break;
				case 'coupon':
					$coupon += $total['value'];
					break;
				case 'voucher':
					$voucher += $total['value'];
					break;
				case 'reward':
					$reward += $total['value'];
					break;
				case 'credit':
					$credit += $total['value'];
					break;
				case 'handling':
					$handling += $total['value'];
					break;
				case 'low_order_fee':
					$low_order_fee += $total['value'];
					break;
			} //end switch
		} // end foreach $totals

		/**
		 * Бонусы размазываются по ценам всех товаров, включая доставку
		 */
		$additional = ($coupon + $voucher + $reward + $credit + $handling + $low_order_fee) / $subtotal;

		$total_sum = 0;
		/**
		 * for(;;) использовать опасно
		 */
		$iterator = 0;
		foreach ($products as $product) {
			$product_tax = round($product['tax'] * (1 + $additional), 2);
			$total_tax   -= $product_tax * $product['quantity'];
			$iterator ++;
			/**
			 * Последний элемент нормализует сумму
			 */
			if ($iterator == count($products)) {
				$subtotal = round($order_data['total'], 2) - round($shipping * (1 + $additional), 2) - $total_sum - $total_tax;
				$final    = round($subtotal / $product['quantity'], 2);
			}
			else {
				$final    = round($product['price'] * (1 + $additional) + $product_tax, 2);
				$subtotal = $final * $product['quantity'];
			}
			$total_sum += $subtotal;

			$item = array(
				'name'     => $product['name'],
				'quantity' => floatval($product['quantity']),
				'price'    => round($this->currency->convert($final, null, $RUB), 2),
				'total'    => round($this->currency->convert($subtotal, null, $RUB), 2),
			);

			$product_info = $this->model_catalog_product->getProduct($product["product_id"]);
			$tax_name     = $this->get_arsenalpay_tax_by_shop_tax_id($product_info['tax_class_id']);
			if (isset($tax_name) && strlen($tax_name) > 0) {
				$item['tax'] = $tax_name;
			}

			$fiscal['receipt']['items'][] = $item;
		} //end foreach $products

		if ($shipping > 0) {

			$value         = round($shipping * (1 + $additional) + $total_tax, 2);
			$shipping_item = array(
				'name'     => $order_data['shipping_method'],
				'quantity' => 1,
				'price'    => round($this->currency->convert($value, null, $RUB), 2),
				'total'    => round($this->currency->convert($value, null, $RUB), 2),
			);

			$tax_name = $this->get_arsenalpay_tax_by_shop_tax_id($shipping_tax_class_id);
			if (isset($tax_name) && strlen($tax_name) > 0) {
				$shipping_item['tax'] = $tax_name;
			}

			$fiscal['receipt']['items'][] = $shipping_item;
		} //end if

		return $fiscal;
	}


	private function get_arsenalpay_tax_by_shop_tax_id($shop_tax_id) {
		$default_tax   = $this->config->get("arsenalpay_default_tax_rate");
		$tax_rates_map = $this->config->get("arsenalpay_tax_rates_map");
		$tax           = $default_tax;
		if (isset($tax_rates_map[$shop_tax_id]) && strlen($tax_rates_map[$shop_tax_id]) > 0) {
			$tax = $tax_rates_map[$shop_tax_id];
		}

		return $tax;

	}

	private function callback_payment($order) {
		$required_statuses = array(
			$this->config->get('arsenalpay_holden_status_id'),
			$this->config->get('arsenalpay_checked_status_id'),
		);

		if (!in_array($order['order_status_id'], $required_statuses)) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has not been checked.');
			$this->exitf('ERR');
		}
		$comment = '';
		if ($this->callback['MERCH_TYPE'] == 0 && $this->get_total($order) == $this->callback['AMOUNT']) {
			$comment = $this->language->get('callback_complete');
		}
		elseif ($this->callback['MERCH_TYPE'] == 1 && $this->get_total($order) >= $this->callback['AMOUNT'] && $this->get_total($order) == $this->callback['AMOUNT_FULL']) {
			$currency_code = $this->config->get('arsenalpay_currency_code');
			$comment       = $this->language->get('callback_complete_p') . " " . $this->callback['AMOUNT'] . " " . $currency_code;
		}
		else {
			$this->log('Payment error: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $this->get_total($order) . ')');
			$this->exitf("ERR");
		}

		$this->log($comment);
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_completed_status_id'), $comment, true);
		$this->exitf('OK');
	}

	private function callback_hold($order) {
		$required_statuses = array(
			$this->config->get('arsenalpay_holden_status_id'),
			$this->config->get('arsenalpay_checked_status_id'),
		);
		if (!in_array($order['order_status_id'], $required_statuses)) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has not been checked. Order has status (' . $order['order_status'] . ')');
			$this->exitf('ERR');
		}
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $this->get_total($order) == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $this->get_total($order) >= $this->callback['AMOUNT'] && $this->get_total($order) == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$this->log('Hold error: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $this->get_total($order) . ')');
			$this->exitf("ERR");
		}
		$comment = $this->language->get('callback_hold');
		$this->log($comment);
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_holden_status_id'), $comment, true);
		$this->exitf('OK');
	}

	private function callback_refund($order) {
		$required_statuses = array(
			$this->config->get('arsenalpay_refunded_status_id'),
			$this->config->get('arsenalpay_completed_status_id'),
		);
		if (!in_array($order['order_status_id'], $required_statuses)) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has not been paid or refunded. Order has status (' . $order['order_status'] . ')');
			$this->exitf('ERR');
		}

		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $this->get_total($order) >= $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $this->get_total($order) >= $this->callback['AMOUNT'] && $this->get_total($order) >= $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$this->log("Refund error: Paid amount({$this->get_total($order)}) < refund amount({$this->callback['AMOUNT']})");
			$this->exitf('ERR');
		}
		$currency_code = $this->config->get('arsenalpay_currency_code');
		$comment       = $this->language->get('callback_refund') . " " . $this->callback['AMOUNT'] . " " . $currency_code;
		$this->log($comment);
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_refunded_status_id'), $comment, true);
		$this->exitf('OK');
	}

	private function callback_reverse($order) {
		if ($order['order_status_id'] != $this->config->get('arsenalpay_completed_status_id')) {
			$this->log('Aborting, Order #' . $order['order_id'] . ' has not been paid. Order has status (' . $order['order_status'] . ')');
			$this->exitf('ERR');
		}
		$isCorrectAmount = ($this->callback['MERCH_TYPE'] == 0 && $this->get_total($order) == $this->callback['AMOUNT']) ||
		                   ($this->callback['MERCH_TYPE'] == 1 && $this->get_total($order) >= $this->callback['AMOUNT'] && $this->get_total($order) == $this->callback['AMOUNT_FULL']);

		if (!$isCorrectAmount) {
			$this->log('Reverse error: Amounts do not match (request amount ' . $this->callback['AMOUNT'] . ' and ' . $this->get_total($order) . ')');
			$this->exitf('ERR');
		}

		$comment = $this->language->get('callback_reverse');
		$this->log($comment);
		$this->model_checkout_order->addOrderHistory($order['order_id'], $this->config->get('arsenalpay_reversed_status_id'), $comment, true);
		$this->exitf('OK');
	}

	private function check_params($callback_params) {
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
		foreach ($required_keys as $key) {
			if (empty($callback_params[$key]) || !array_key_exists($key, $callback_params)) {
				$this->log('Error in callback parameters ERR' . $key);

				return false;
			}
			else {
				$this->log(" $key=$callback_params[$key]");

			}
		}

		if ($callback_params['FUNCTION'] != $callback_params['STATUS']) {
			$this->log("Error: FUNCTION ({$callback_params['FUNCTION']} not equal STATUS ({$callback_params['STATUS']})");

			return false;
		}

		return true;
	}

	/**
	 * Общая сумма заказа с учетем валюты (переводит в валюту, указанную в настройках Arsenalpay)
	 *
	 * @param $order
	 *
	 * @return string total price
	 */
	private function get_total($order) {
//		$from = $order['currency_code'];
		$to = $this->config->get('arsenalpay_currency_code');

		$amount = $order['total'];
//		$amount = $this->currency->format( $amount, $order['currency_code'], false, false );
		$amount = $this->currency->convert($amount, null, $to);
		$total  = number_format($amount, 2, '.', '');

		return $total;
	}

	private function check_sign($callback_params, $pass) {
		$validSign = ($callback_params['SIGN'] === md5(md5($callback_params['ID']) .
		                                               md5($callback_params['FUNCTION']) . md5($callback_params['RRN']) .
		                                               md5($callback_params['PAYER']) . md5($callback_params['AMOUNT']) . md5($callback_params['ACCOUNT']) .
		                                               md5($callback_params['STATUS']) . md5($pass))) ? true : false;

		return $validSign;
	}

	private function exitf($msg, $fiscal = array()) {
		if (isset($this->callback['FORMAT']) && $this->callback['FORMAT'] == 'json') {
			$msg = array("response" => $msg);
			if ($fiscal && isset($this->callback['OFD']) && $this->callback['OFD'] == 1) {
				$msg['ofd'] = $fiscal;
			}
			$msg = json_encode($msg);
		}

		$this->log($msg);
		echo $msg;
		die;
	}

	private function log($message) {
		if ($this->config->get('arsenalpay_debug')) {
			$log = new Log('arsenalpay.log');
			$log->write($message);
		}
	}
}
           

