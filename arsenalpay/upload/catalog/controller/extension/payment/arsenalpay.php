<?php

class ControllerExtensionPaymentArsenalpay extends Controller { 

    public function index() {
        $this->load->language('extension/payment/arsenalpay');
        $this->load->model('checkout/order');

        $order_id = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($order_id);

        $amount = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
        $format_amount = number_format($amount, 2, '.', '');
        
        if (!$order_info['payment_address_2']) {
            $address= $order_info['payment_address_1'] . ', ' . $order_info['payment_city'] . ', ' . $order_info['payment_zone'];
        } else {
            $address = $order_info['payment_address_1'] . ', ' . $order_info['payment_address_2'] . ', ' . $order_info['payment_city'] . ', ' . $order_info['payment_zone'];
        }

        $url_params = array(
            'src' => $this->config->get('arsenalpay_src'),
            't' => $this->config->get('arsenalpay_merchant'),
            'n' => $order_id,
            'a' => $format_amount,
            'msisdn'=> $order_info['telephone'],
            'css' => $this->config->get('arsenalpay_css'),
            'frame' => $this->config->get('arsenalpay_frame_mode'),
            'description' => $order_info['store_name'],
            'full_name' => $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'],
            'phone' => $order_info['telephone'],
            'email' => $order_info['email'],
            'address' => $address,
            'other' => '',
        );
        $data['iframe_url'] = $this->config->get('arsenalpay_frame_url') . '?' . http_build_query($url_params, '', '&');
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['iframe_params'] = $this->config->get('arsenalpay_frame_params');

        return $this->load->view('extension/payment/arsenalpay_iframe', $data);
    }
        
    public function ap_callback() {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/arsenalpay');
        $REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
        $IP_ALLOW = $this->config->get('arsenalpay_ip');
        if( strlen( $IP_ALLOW ) > 0 && $IP_ALLOW != $REMOTE_ADDR ) {
            $this->exitf( 'ERR_IP' );
        }

        $keyArray = array
        (
            'ID',           /* Идентификатор ТСП/ merchant identifier */
            'FUNCTION',     /* Тип запроса/ type of request to which the response is received*/
            'RRN',          /* Идентификатор транзакции/ transaction identifier */
            'PAYER',        /* Идентификатор плательщика/ payer(customer) identifier */
            'AMOUNT',       /* Сумма платежа/ payment amount */
            'ACCOUNT',      /* Номер получателя платежа (номер заказа, номер ЛС) на стороне ТСП/ order number */
            'STATUS',       /* Статус платежа - check - запрос на проверку номера получателя : payment - запрос на передачу статуса платежа
            /* Payment status. When 'check' - response for the order number checking, when 'payment' - response for status change.*/
            'DATETIME',     /* Дата и время в формате ISO-8601 (YYYY-MM-DDThh:mm:ss±hh:mm), УРЛ-кодированное */
            /* Date and time in ISO-8601 format, urlencoded.*/
            'SIGN',         /* Подпись запроса/ response sign.
             //* = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(AMOUNT).md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */  
        ); 
        /**
        * Checking the absence of each parameter in the post request.
        * Проверка на присутствие каждого из параметров и их значений в передаваемом запросе. 
        */ 
        $post_msg = "";
        foreach( $keyArray as $key ) {
            if( empty( $this->request->post[$key] ) || !array_key_exists( $key, $this->request->post ) )
            {
                $this->exitf( 'ERR_'.$key );
            }
            else 
            {
                $post_msg .= "{$key}={$this->request->post[$key]}&"; 
            }
           
        }
        $this->log($post_msg);
        $ap_order_id = $this->request->post['ACCOUNT'];
        
        $order_info = $this->model_checkout_order->getOrder($ap_order_id);

        if( $order_info === false || $order_info['order_id'] != $ap_order_id ) {
            if( $this->request->post['FUNCTION']=="check" ) {
                $comment = "Payment failed";
                $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);
                $this->exitf( 'NO' );
            }
            $comment = "Payment failed";
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);
            $this->exitf( "ERR_ACCOUNT" );
        }
        $KEY = $this->config->get('arsenalpay_key');
        //======================================
        /**
        * Checking validness of the request sign.
        */
        if( !( $this->_checkSign( $this->request->post, $KEY) ) ) {
            $this->exitf( 'ERR_INVALID_SIGN' );
        }

        /**
         * Checking validness of the amount
         */

        $lessAmount = false;
        if( $this->request->post['MERCH_TYPE'] == 0 && $order_info['total'] == $this->request->post['AMOUNT'] ) {
            $lessAmount = false;
        }
        elseif( $this->request->post['MERCH_TYPE'] == 1 &&
                    $order_info['total'] >= $this->request->post['AMOUNT'] && 
                    $order_info['total'] == $this->request->post['AMOUNT_FULL'] ) {
            $lessAmount = true;
        }
        else {
            $comment = "Payment failed";
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);
            $this->exitf( "ERR_AMOUNT" );
        }
               
        if( $this->request->post['FUNCTION'] == "check" && $this->request->post['STATUS'] == "check" ) {
            // Check account
            /*
                Here is account check procedure
                Result:
                YES - account exists
                NO - account not exists
            */
            $comment = "Payment waiting";
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_waiting_status_id'), $comment, true);
            $this->exitf( 'YES' );
        } 
        elseif( ( $this->request->post['FUNCTION']=="payment" ) && ( $this->request->post['STATUS'] === "payment" ) ) {
            // Payment callback
            /*
                Here is callback payment saving procedure
                Result:
                OK - success saving
                ERR - error saving*/
            if ($lessAmount) {
                $comment = "Payment completed with less amount = {$this->request->post['AMOUNT']}";
            }
            else {
               $comment = "Payment completed"; 
            }
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_completed_status_id'), $comment, true);
            $this->exitf('OK');  
        }
        elseif( ( $this->request->post['FUNCTION']=="payment" ) && ( $this->request->post['STATUS'] === "cancelinit" ) ) {
            $comment = "Payment canceled";
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_canceled_status_id'), $comment, true);
            $this->exitf('ERR');   
        }
        else {   
            $comment = "Payment failed";
            $this->model_checkout_order->addOrderHistory($ap_order_id, $this->config->get('arsenalpay_failed_status_id'), $comment, true);
            $this->exitf('ERR');
        }
    }

    private function _checkSign( $ars_callback, $pass) {
        $validSign = ( $ars_callback['SIGN'] === md5(md5($ars_callback['ID']).
                md5($ars_callback['FUNCTION']).md5($ars_callback['RRN']).
                md5($ars_callback['PAYER']).md5($ars_callback['AMOUNT']).md5($ars_callback['ACCOUNT']).
                md5($ars_callback['STATUS']).md5($pass) ) )? true : false;
        return $validSign; 
    }
        
    public function exitf($msg) { 
        $this->log($msg); 
        echo $msg;
        die;
    }

    public function log($message) {
        if ($this->config->get('arsenalpay_debug')) {
            $log = new Log('arsenalpay.log');
            $log->write($message);
        }
    }
}
?>
           

