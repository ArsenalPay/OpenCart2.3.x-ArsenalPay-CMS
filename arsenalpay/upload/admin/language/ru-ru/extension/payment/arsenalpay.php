<?php
// Heading
$_['heading_title'] = 'ArsenalPay';

// Text
$_['text_payment_edit']       = 'Редактировать настройки оплаты ArsenalPay';
$_['text_tax_edit']           = 'Редактировать настройки для интеграции ArsenalPay с онлайн кассой';
$_['text_payment']            = 'Оплата';
$_['text_extensions']         = 'Расширения';
$_['text_arsenalpay']         = '<a href="https://arsenalpay.ru/#register" target="_blank"><img src="view/image/payment/arsenalpay.png" alt="Skrill" title="ArsenalPay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_arsenalpay_tax']     = 'Данные настройки необходимы для <a href="https://arsenalpay.ru/documentation.html#54-fz-integraciya-s-onlajn-kassoj"> интеграции с онлайн кассой.</a>';
$_['text_success']            = 'Настройки Arsenal Pay успешно обновлены!';
$_['text_tax_tab_header']     = 'Настройки для интеграции с онлайн кассой';
$_['text_payment_tab_header'] = 'Настройки оплаты';

// Entry (payment tab)
$_['entry_callback_key']  = 'callbackKey';
$_['entry_widget_id']     = 'widget';
$_['entry_widget_key']    = 'widgetKey';
$_['entry_callback_url']  = 'URL для обратного запроса';
$_['entry_total']         = 'Итого';
$_['entry_debug']         = 'Логирование';
$_['entry_geo_zone']      = 'Географическая зона';
$_['entry_status']        = 'Статус';
$_['entry_sort_order']    = 'Порядок сортировки';
$_['entry_currency_code'] = 'Код валюты';
$_['entry_ip']            = 'Разрешенный IP-адрес';

$_['entry_completed_status'] = 'Статус заказа после подтверждения платежа';
$_['entry_canceled_status']  = 'Статус заказа после отмены платежа';
$_['entry_failed_status']    = 'Статус заказа после неудавшегося платежа';
$_['entry_checked_status']   = 'Статус заказа после проверки платежа со стороны Arsenalpay ';
$_['entry_holden_status']    = 'Статус заказа, когда средства на карте были заморожены, но еще не списаны';
$_['entry_refunded_status']  = 'Статус заказа после частичного возврата платежа';
$_['entry_reversed_status']  = 'Статус заказа после полного возврата платежа';

// Help
$_['help_callback_key']   = 'Для проверки подписи обратных запросов.';
$_['help_widget_id']      = 'Присваивается предприятию для доступа к платежному виджету.';
$_['help_widget_key']     = 'Присваивается предприятию для доступа к платежному виджету.';
$_['help_callback_url']   = 'На проверку номера заказа и подтверждение платежа.';
$_['help_total']          = 'Итоговая сумма заказа, начиная с которой данный метод оплаты становится доступным.';
$_['help_debug']          = '';
$_['help_currency_code']  = 'Валюта платежа (необходимо выбрать RUB)';
$_['help_checked_status'] = 'Проверка происходит перед осуществлением транзакции платежа';
$_['help_ip']             = 'Только с которого будут разрешены обратные запросы о подтверждении платежей от ArsenalPay.';


// Error
$_['error_permission']   = 'Ошибка! У вас нет прав редактировать эти настройки!';
$_['error_callback_key'] = 'Поле <b>Callback key</b> обязательно для заполнения!';
$_['error_widget_id']    = 'Поле <b>Widget ID</b> обязательно для заполнения!';
$_['error_widget_key']   = 'Поле <b>Widget key</b> обязательно для заполнения!';

//entry(tax tab)
$_['entry_tax_table']         = 'Слева - налоговый класс в вашем магазине, справа НДС в ФНС. Пожалуйста, сопоставьте их.';
$_['entry_default_tax_rate']  = 'Налоговая ставка по умолчанию';
$_['entry_shipment_tax_rate'] = 'Налоговая ставка для доставки';
$_['entry_none_tax_rate']     = 'Без НДС';
$_['entry_vat0_tax_rate']     = 'НДС по ставке 0%';
$_['entry_vat10_tax_rate']    = 'НДС по ставке  10%';
$_['entry_vat18_tax_rate']    = 'НДС по ставке 18%';
$_['entry_vat110_tax_rate']   = 'НДС по расчетной ставке 10/110';
$_['entry_vat118_tax_rate']   = 'НДС по расчетной ставке 18/118';

//Help
$_['help_header_shop_tax_classes'] = 'Налоговый класс в вашем магазине';
$_['help_header_ap_tax_rates']     = 'Налоговая ставка в ФНС';
$_['help_default_tax_rate']        = 'Ставка по умолчанию будет в чеке, если в карточке товара не указана другая ставка.';
