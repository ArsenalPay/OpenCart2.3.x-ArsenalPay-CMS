<?php
// Heading
$_['heading_title'] = 'ArsenalPay';

// Text
$_['text_edit']       = 'Редактировать ArsenalPay';
$_['text_payment']    = 'Оплата';
$_['text_extensions'] = 'Расширения';
$_['text_arsenalpay'] = '<a href="https://arsenalpay.ru/#register" target="_blank"><img src="view/image/payment/arsenalpay.png" alt="Skrill" title="ArsenalPay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success']    = 'Настройки Arsenal Pay успешно обновлены!';

// Entry
$_['entry_callback_key']  = 'Callback key';
$_['entry_widget_id']     = 'Widget ID';
$_['entry_widget_key']    = 'Widget key';
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
