<?php
// Heading
$_['heading_title']      = 'ArsenalPay';

// Text 
$_['text_edit']			 = 'Edit ArsenalPay';
$_['text_payment']       = 'Payment';
$_['text_arsenalpay']	 = '<a href="https://arsenalpay.ru/en/#register" target="_blank"><img src="view/image/payment/arsenalpay.png" alt="Skrill" title="ArsenalPay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success']       = 'Settings of ArsenalPay have been successfully updated!';
$_['text_mk']            = 'Mobile balance';
$_['text_card']          = 'Bank cards';
$_['text_in_frame']      = 'in frame';
$_['text_out_of_frame']  = 'out of frame';

// Entry
$_['entry_merchant'] = 'Unique token';
$_['entry_key'] = 'Key';
$_['entry_ip'] = 'Allowed IP-address';
$_['entry_callback'] = 'Callback URL';
$_['entry_frame_url'] = 'Frame address';
$_['entry_frame_mode'] = 'Frame mode';
$_['entry_src'] = 'Payment type';
$_['entry_css'] = 'css file';
$_['entry_frame_params'] = 'iframe display attributes';
$_['entry_total'] = 'Total';
$_['entry_debug'] = 'Logs';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_status'] = 'Status';
$_['entry_sort_order'] = 'Sort Order';

$_['entry_completed_status'] = 'Order Status for Confirmed transactions';
$_['entry_canceled_status'] = 'Order Status for Canceled transactions';
$_['entry_failed_status'] = 'Order Status for Failed transactions';
$_['entry_waiting_status']='Order Status for Pending transactions';

// Help
$_['help_merchant'] = 'Assigned to merchant for access to ArsenalPay payment frame.';
$_['help_key'] = 'With this key you check a validity of sign that comes with callback payment data.';
$_['help_ip'] = 'It will be allowed to receive ArsenalPay payment confirmation callback requests only from the IP address pointed out here.';
$_['help_callback'] = 'To check an order number before payment processing and for payment confirmation.';
$_['help_frame_url'] = 'URL-address of ArsenalPay payment frame.';
$_['help_frame_mode'] = '<b>1</b> will mean that payment page will be displayed in a frame inside your site,</br><b>0</b> - payer will be redirected to payment page.';
$_['help_css'] = 'URL of CSS file if exists.';
$_['help_frame_params'] = 'Seperate attribute-value pair by space';
$_['help_total'] = 'The checkout total the order must reach before this payment method becomes active.';
$_['help_debug'] = '';


// Error
$_['error_permission'] = 'Error! You have no rightts to edit these settings!';
$_['error_merchant'] = 'Field <b>Unique token</b> required to be filled out!';
$_['error_key'] = 'Field <b>Key</b> required to be filled out!';
$_['error_frame_url'] = 'Field <b>Frame address</b> can\'t be empty!';
$_['error_frame_params'] = "Error in specified iframe attributes!";
