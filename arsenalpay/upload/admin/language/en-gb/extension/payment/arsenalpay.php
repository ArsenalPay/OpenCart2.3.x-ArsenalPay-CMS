<?php
// Heading
$_['heading_title'] = 'ArsenalPay';

// Text 
$_['text_payment_edit']       = 'Edit ArsenalPay payment settings';
$_['text_tax_edit']           = 'Edit ArsenalPay online checkout settings';
$_['text_payment']            = 'Payment';
$_['text_extensions']         = 'Extensions';
$_['text_arsenalpay']         = '<a href="https://arsenalpay.ru/en/#register" target="_blank"><img src="view/image/payment/arsenalpay.png" alt="Skrill" title="ArsenalPay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_arsenalpay_tax']     = 'These parameters are needed for <a href="https://arsenalpay.ru/documentation.html#54-fz-integraciya-s-onlajn-kassoj">integration with the online checkout</a>';
$_['text_success']            = 'Settings of ArsenalPay have been successfully updated!';
$_['text_tax_tab_header']     = 'Online checkout settings';
$_['text_payment_tab_header'] = 'Payment settings';

// Entry (payment tab)
$_['entry_callback_key']  = 'callbackKey';
$_['entry_widget_id']     = 'widget';
$_['entry_widget_key']    = 'widgetKey';
$_['entry_callback_url']  = 'Callback URL';
$_['entry_total']         = 'Total';
$_['entry_debug']         = 'Logs';
$_['entry_geo_zone']      = 'Geo Zone';
$_['entry_status']        = 'Status';
$_['entry_sort_order']    = 'Sort Order';
$_['entry_currency_code'] = 'Currency Code';
$_['entry_ip']            = 'Allowed IP-address';

$_['entry_completed_status'] = 'Order Status for Confirmed transactions';
$_['entry_canceled_status']  = 'Order Status for Canceled transactions';
$_['entry_failed_status']    = 'Order Status for Failed transactions';
$_['entry_checked_status']   = 'Order Status for Checking transactions';
$_['entry_holden_status']    = 'Order Status for Holding transactions';
$_['entry_refunded_status']  = 'Order Status for partition Refunded transactions';
$_['entry_reversed_status']  = 'Order Status for Reversed transactions';

// Help
$_['help_callback_key']   = 'With this key you check a validity of sign that comes with callback payment data.';
$_['help_widget_id']      = 'Assigned to merchant for access to ArsenalPay payment widget.';
$_['help_widget_key']     = 'Assigned to merchant for access to ArsenalPay payment wiget.';
$_['help_callback_url']   = 'To check an order number before payment processing and for payment confirmation.';
$_['help_total']          = 'The checkout total the order must reach before this payment method becomes active.';
$_['help_debug']          = '';
$_['help_currency_code']  = 'Currency to pay order (please, choose RUB)';
$_['help_checked_status'] = 'Checking occurs before payment transaction';
$_['help_ip']             = 'It will be allowed to receive ArsenalPay payment confirmation callback requests only from the IP address pointed out here.';


// Error
$_['error_permission']   = 'Error! You have no rightts to edit these settings!';
$_['error_callback_key'] = 'Field <b>Callback key</b> required to be filled out!';
$_['error_widget_id']    = 'Field <b>Widget ID</b> required to be filled out!';
$_['error_widget_key']   = 'Field <b>Widget key</b> required to be filled out!';

//entry(tax tab)
$_['entry_tax_table']         = 'On the left is the tax class in your store, on the right is the tax rate in the Federal Tax Service. Match them';
$_['entry_default_tax_rate']  = 'Default tax rate';
$_['entry_shipment_tax_rate'] = 'Shipment tax rate';
$_['entry_none_tax_rate']     = 'None';
$_['entry_vat0_tax_rate']     = 'VAT 0%';
$_['entry_vat10_tax_rate']    = 'VAT 10%';
$_['entry_vat18_tax_rate']    = 'VAT 18%';
$_['entry_vat110_tax_rate']   = 'VAT 10/110';
$_['entry_vat118_tax_rate']   = 'VAT 18/118';

//Help
$_['help_header_shop_tax_classes'] = 'Tax classes in shops';
$_['help_header_ap_tax_rates']     = 'Tax rates in the Federal Tax Service';
$_['help_default_tax_rate']        = 'The rate will default in the check, if the product does not have different rate.';
