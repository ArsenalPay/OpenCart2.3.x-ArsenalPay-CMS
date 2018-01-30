<?php

class ControllerExtensionPaymentArsenalpay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language( 'extension/payment/arsenalpay' );

		$this->document->setTitle( $this->language->get( 'heading_title' ) );

		$this->load->model( 'setting/setting' );

		if ( ( $this->request->server['REQUEST_METHOD'] == 'POST' ) && $this->validate() ) {
			$this->model_setting_setting->editSetting( 'arsenalpay', $this->request->post );
			$this->session->data['success'] = $this->language->get( 'text_success' );
			$this->response->redirect( $this->url->link( 'extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true ) );
		}

		$data = array();

		$lang_params = array(
			'heading_title',
			'text_edit',
			'text_enabled',
			'text_disabled',
			'text_all_zones',

			'entry_widget_id',
			'entry_widget_key',
			'entry_callback_key',
			'entry_callback_url',
			'entry_total',
			'entry_debug',
			'entry_geo_zone',
			'entry_status',
			'entry_sort_order',
			'entry_currency_code',
			'entry_ip',

			'button_save',
			'button_cancel',

			'entry_completed_status',
			'entry_failed_status',
			'entry_canceled_status',
			'entry_holden_status',
			'entry_reversed_status',
			'entry_refunded_status',
			'entry_checked_status',

			'help_widget_id',
			'help_widget_key',
			'help_callback_key',
			'help_callback_url',
			'help_debug',
			'help_total',
			'help_currency_code',
			'help_checked_status',
			'help_ip',
		);

		foreach ( $lang_params as $param ) {
			$data[ $param ] = $this->language->get( $param );
		}

		$errors_keys = array(
			'warning',
			'widget_id',
			'widget_key',
			'callback_key'
		);
		foreach ( $errors_keys as $e_key ) {
			if ( isset( $this->error[ $e_key ] ) ) {
				$data[ 'error_' . $e_key ] = $this->error[ $e_key ];
			} else {
				$data[ 'error_' . $e_key ] = '';
			}
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get( 'text_home' ),
			'href' => $this->url->link( 'common/dashboard', 'token=' . $this->session->data['token'], true )
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get( 'text_extensions' ),
			'href' => $this->url->link( 'extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true )
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get( 'heading_title' ),
			'href' => $this->url->link( 'extension/payment/arsenalpay', 'token=' . $this->session->data['token'], true )
		);

		$data['action'] = $this->url->link( 'extension/payment/arsenalpay', 'token=' . $this->session->data['token'], 'SSL' );
		$data['cancel'] = $this->url->link( 'extension/extension', 'token=' . $this->session->data['token'], 'SSL' );


		$this->load->model( 'localisation/geo_zone' );
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model( 'localisation/order_status' );
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model( 'localisation/currency' );
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$post_params = array(
			'arsenalpay_callback_key',
			'arsenalpay_widget_key',
			'arsenalpay_widget_id',
			'arsenalpay_total',
			'arsenalpay_geo_zone_id',
			'arsenalpay_status',
			'arsenalpay_checked_status_id',
			'arsenalpay_completed_status_id',
			'arsenalpay_failed_status_id',
			'arsenalpay_canceled_status_id',
			'arsenalpay_holden_status_id',
			'arsenalpay_reversed_status_id',
			'arsenalpay_refunded_status_id',
			'arsenalpay_debug',
			'arsenalpay_currency_code',
			'arsenalpay_ip',
		);
		foreach ( $post_params as $param ) {
			$data[ $param ] = $this->get_param_value( $param );
		}
		$data['arsenalpay_sort_order'] = $this->get_param_value( 'arsenalpay_sort_order', 0 );

		$data['callback_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/arsenalpay/ap_callback';

		$data['header']      = $this->load->controller( 'common/header' );
		$data['column_left'] = $this->load->controller( 'common/column_left' );
		$data['footer']      = $this->load->controller( 'common/footer' );

		$this->response->setOutput( $this->load->view( 'extension/payment/arsenalpay', $data ) );
	}

	protected function validate() {
		if ( ! $this->user->hasPermission( 'modify', 'extension/payment/arsenalpay' ) ) {
			$this->error['warning'] = $this->language->get( 'error_permission' );
		}
		$required_params = array(
			'widget_id',
			'widget_key',
			'callback_key',
		);
		foreach ( $required_params as $param ) {
			if ( ! $this->request->post[ 'arsenalpay_' . $param ] ) {
				$this->error[ $param ] = $this->language->get( 'error_' . $param );
			}
		}

		if ( ! $this->error ) {
			return true;
		}

		return false;
	}

	protected function get_param_value( $key, $default_val = null ) {
		if ( isset( $this->request->post[ $key ] ) ) {
			return $this->request->post[ $key ];
		}
		$config_val = $this->config->get( $key );

		if ( ! $config_val && ! is_null( $default_val ) ) {
			return $default_val;
		}

		return $config_val;

	}

}



