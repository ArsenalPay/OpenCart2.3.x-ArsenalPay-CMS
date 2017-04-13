<?php
class ControllerExtensionPaymentArsenalpay extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/payment/arsenalpay');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST' ) && $this->validate()) {
            $this->model_setting_setting->editSetting( 'arsenalpay', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link( 'extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_mk'] = $this->language->get('text_mk');
        $data['text_card'] = $this->language->get('text_card');
        //$data['text_yes'] = $this->language->get('text_yes');
        //$data['text_no'] = $this->language->get('text_no');
        $data['text_in_frame'] = $this->language->get('text_in_frame');
        $data['text_out_of_frame'] = $this->language->get('text_out_of_frame');

        
        $data['entry_merchant'] = $this->language->get('entry_merchant');
        $data['entry_key'] = $this->language->get('entry_key');
        $data['entry_ip'] = $this->language->get('entry_ip');
        $data['entry_callback'] = $this->language->get('entry_callback');
        $data['entry_frame_url'] = $this->language->get('entry_frame_url');
        $data['entry_src'] = $this->language->get('entry_src');
        $data['entry_frame_mode'] = $this->language->get('entry_frame_mode');
        $data['entry_frame_params'] = $this->language->get('entry_frame_params');
        $data['entry_css'] = $this->language->get('entry_css');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_debug'] = $this->language->get('entry_debug');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        
        $data['entry_completed_status'] = $this->language->get('entry_completed_status');
        $data['entry_failed_status'] = $this->language->get('entry_failed_status');
        $data['entry_canceled_status'] = $this->language->get('entry_canceled_status');
        $data['entry_waiting_status'] = $this->language->get('entry_waiting_status');
        
        $data['help_merchant'] = $this->language->get('help_merchant');
        $data['help_key'] = $this->language->get('help_key');
        $data['help_ip'] = $this->language->get('help_ip');
        $data['help_callback'] = $this->language->get('help_callback_url');
        $data['help_frame_url'] = $this->language->get('help_frame_url');
        $data['help_src'] = $this->language->get('help_src');
        $data['help_frame_mode'] = $this->language->get('help_frame_mode');
        $data['help_css'] = $this->language->get('help_css');
        $data['help_frame_params'] = $this->language->get('help_frame_params');
        $data['help_debug'] = $this->language->get('help_debug');
        $data['help_total'] = $this->language->get('help_total');
        
        if (isset($this->error['warning'])) {
                $data['error_warning'] = $this->error['warning'];
        } else {
                $data['error_warning'] = '';
        }
        
         if (isset($this->error['merchant'])) {
                $data['error_merchant'] = $this->error['merchant'];
        } else {
                $data['error_merchant'] = '';
        }
        
         if (isset($this->error['key'])) {
                $data['error_key'] = $this->error['key'];
        } else {
                $data['error_key'] = '';
        }
        
        if (isset($this->error['frame_url'])) {
                $data['error_frame_url'] = $this->error['frame_url'];
        } else {
                $data['error_frame_url'] = '';
        }
        
        if (isset($this->error['frame_params'])) {
                $data['error_frame_params'] = $this->error['frame_params'];
        } else {
                $data['error_frame_params'] = '';
        }
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_home'),
                'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_payment'),
                'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
                'text'      => $this->language->get('heading_title'),
                'href'      => $this->url->link('extension/payment/arsenalpay', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['action'] = $this->url->link('extension/payment/arsenalpay', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->request->post['arsenalpay_merchant'])) {
                $data['arsenalpay_merchant'] = $this->request->post['arsenalpay_merchant'];
        } else {
                $data['arsenalpay_merchant'] = $this->config->get('arsenalpay_merchant');
        }
        
        if (isset($this->request->post['arsenalpay_key'])) {
                $data['arsenalpay_key'] = $this->request->post['arsenalpay_key'];
        } else {
                $data['arsenalpay_key'] = $this->config->get('arsenalpay_key');
        }
        
        if (isset($this->request->post['arsenalpay_css'])) {
                $data['arsenalpay_css'] = $this->request->post['arsenalpay_css'];
        } else {
                $data['arsenalpay_css'] = $this->config->get('arsenalpay_css');
        }
        
        if (isset($this->request->post['arsenalpay_ip'])) {
                $data['arsenalpay_ip'] = $this->request->post['arsenalpay_ip'];
        } else {
                $data['arsenalpay_ip'] = $this->config->get('arsenalpay_ip');
        }
        
        if (isset($this->request->post['arsenalpay_check_url'])) {
                $data['arsenalpay_check_url'] = $this->request->post['arsenalpay_check_url'];
        } else {
                $data['arsenalpay_check_url'] = $this->config->get('arsenalpay_check_url');
        }
        
        if (isset($this->request->post['arsenalpay_src'])) {
                $data['arsenalpay_src'] = $this->request->post['arsenalpay_src'];
        } else {
                $data['arsenalpay_src'] = $this->config->get('arsenalpay_src');
        }
        
        if (isset($this->request->post['firstdata_live_url'])) {
            $data['arsenalpay_frame_url'] = $this->request->post['arsenalpay_frame_url'];
        } else {
            $data['arsenalpay_frame_url'] = $this->config->get('arsenalpay_frame_url');
        }
        
        if (empty($data['arsenalpay_frame_url'])) {
            $data['arsenalpay_frame_url'] = 'https://arsenalpay.ru/payframe/pay.php';
        }

        if (isset($this->request->post['arsenalpay_frame_mode'])) {
                $data['arsenalpay_frame_mode'] = $this->request->post['arsenalpay_frame_mode'];
        } elseif ($this->config->get('arsenalpay_frame_mode')) {
                $data['arsenalpay_frame_mode'] = $this->config->get('arsenalpay_frame_mode');
        }
        
        if (isset($this->request->post['arsenalpay_frame_params'])) {
                $data['arsenalpay_frame_params'] = $this->request->post['arsenalpay_frame_params'];
        } elseif ($this->config->get('arsenalpay_frame_params')) {
                $data['arsenalpay_frame_params'] = $this->config->get('arsenalpay_frame_params');
        } else {
                $data['arsenalpay_frame_params'] = "width='750' height='750' frameborder='0' scrolling='auto'";
        }
        
        if (isset($this->request->post['arsenalpay_total'])) {
            $data['arsenalpay_total'] = $this->request->post['arsenalpay_total'];
        } else {
            $data['arsenalpay_total'] = $this->config->get('arsenalpay_total');
        }
        
        if (isset($this->request->post['arsenalpay_geo_zone_id'])) {
                $data['arsenalpay_geo_zone_id'] = $this->request->post['arsenalpay_geo_zone_id'];
        } else {
                $data['arsenalpay_geo_zone_id'] = $this->config->get('arsenalpay_geo_zone_id'); 
        } 

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['arsenalpay_status'])) {
                $data['arsenalpay_status'] = $this->request->post['arsenalpay_status'];
        } else {
                $data['arsenalpay_status'] = $this->config->get('arsenalpay_status');
        }

        if (isset($this->request->post['arsenalpay_sort_order'])) {
                $data['arsenalpay_sort_order'] = $this->request->post['arsenalpay_sort_order'];
        } elseif ($this->config->get('arsenalpay_sort_order')) {
                $data['arsenalpay_sort_order'] = $this->config->get('arsenalpay_sort_order');
        } else {
                $data['arsenalpay_sort_order'] = '0';
        }
        
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['arsenalpay_completed_status_id'])) {
                $data['arsenalpay_completed_status_id'] = $this->request->post['arsenalpay_completed_status_id'];
        } else {
                $data['arsenalpay_completed_status_id'] = $this->config->get('arsenalpay_completed_status_id');
        }
        
        if (isset($this->request->post['arsenalpay_failed_status_id'])) {
                $data['arsenalpay_failed_status_id'] = $this->request->post['arsenalpay_failed_status_id'];
        } else {
                $data['arsenalpay_failed_status_id'] = $this->config->get('arsenalpay_failed_status_id');
        }
        
        if (isset($this->request->post['arsenalpay_waiting_status_id'])) {
                $data['arsenalpay_waiting_status_id'] = $this->request->post['arsenalpay_waiting_status_id'];
        } else {
                $data['arsenalpay_waiting_status_id'] = $this->config->get('arsenalpay_waiting_status_id');
        }

        if (isset($this->request->post['arsenalpay_canceled_status_id'])) {
                $data['arsenalpay_canceled_status_id'] = $this->request->post['arsenalpay_waiting_status_id'];
        } else {
                $data['arsenalpay_canceled_status_id'] = $this->config->get('arsenalpay_waiting_status_id');
        }
        
        if (isset($this->request->post['arsenalpay_debug'])) {
                $data['arsenalpay_debug'] = $this->request->post['arsenalpay_debug'];
        } else {
                $data['arsenalpay_debug'] = $this->config->get('arsenalpay_debug');
        }
       // $data['cancel_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/arsenalpay/ap_cancel';
       // $data['error_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/arsenalpay/ap_error';
       // $data['return_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/arsenalpay/ap_return';
        $data['callback_url'] = HTTPS_CATALOG . 'index.php?route=extension/payment/arsenalpay/ap_callback';
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
    
        $this->response->setOutput($this->load->view('extension/payment/arsenalpay', $data));
        
    }
    
    protected function validate() 
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/arsenalpay')) {
                $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->request->post['arsenalpay_merchant']) {
                $this->error['merchant'] = $this->language->get('error_merchant');
        }
        if (!$this->request->post['arsenalpay_key']) {
                $this->error['key'] = $this->language->get('error_key');
        }
        if (!$this->request->post['arsenalpay_frame_url']) {
                $this->error['frame_url'] = $this->language->get('error_frame_url');
        }
        
         if (isset($this->request->post['arsenalpay_frame_params'])) {
             $frame_params = htmlspecialchars($this->request->post['arsenalpay_frame_params'], ENT_QUOTES);
             $pattern = '/[\s]+/';
             $iframe_attributes = preg_split($pattern, trim($frame_params));
             foreach ( $iframe_attributes as $pair ) {
                $attribute = explode("=", $pair);
                $available_attributes = ["width", "height", "scrolling", 
                    "frameborder", "allign", "marginheight", "marginwidth"];
                if (!in_array($attribute[0], $available_attributes)) {
                    $this->error['frame_params'] = $this->language->get('error_frame_params');
                    return false;
                }
             }
        }
        if (!$this->error) {
                return true;
        } else {
        return false;
        }
        
    }
}



