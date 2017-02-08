<?php
// Heading
$_['heading_title']      = 'ArsenalPay';

// Text
$_['text_edit'] 		 = 'Редактировать ArsenalPay';
$_['text_payment']       = 'Оплата';
$_['text_arsenalpay']	 = '<a href="https://arsenalpay.ru/#register" target="_blank"><img src="view/image/payment/arsenalpay.png" alt="Skrill" title="ArsenalPay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_success']       = 'Настройки Arsenal Pay успешно обновлены!';
$_['text_mk']            = 'Баланс мобильного';
$_['text_card']          = 'Банковские карты';
$_['text_in_frame']      = 'во фрейме';
$_['text_out_of_frame']  = 'вне фрейма';

// Entry
$_['entry_merchant'] = 'Уникальный токен';
$_['entry_key'] = 'Ключ';
$_['entry_ip'] = 'Разрешенный IP-адрес';
$_['entry_callback'] = 'URL для обратного запроса';
$_['entry_frame_url'] = 'Адрес фрейма';
$_['entry_frame_mode'] = 'Режим отображения платежной страницы';
$_['entry_src'] = 'Тип оплаты';
$_['entry_css'] = 'Файл css';
$_['entry_frame_params'] = 'Атрибуты отображения iframe';
$_['entry_total'] = 'Итого';
$_['entry_debug'] = 'Логирование';
$_['entry_geo_zone'] = 'Географическая зона';
$_['entry_status'] = 'Статус';
$_['entry_sort_order'] = 'Порядок сортировки';

$_['entry_completed_status'] = 'Статус заказа после подтверждения платежа';
$_['entry_canceled_status'] = 'Статус заказа после отказа от платежа';
$_['entry_failed_status'] = 'Статус заказа после неудавшегося платежа';
$_['entry_waiting_status']='Статус заказа на время ожидания оплаты';

// Help
$_['help_merchant'] = 'Присваивается предприятию для доступа к платежному фрейму.';
$_['help_key'] = 'Для проверки подписи обратных запросов.';
$_['help_ip'] = 'Только с которого будут разрешены обратные запросы о подтверждении платежей от ArsenalPay.';
$_['help_callback'] = 'На проверку номера заказа и подтверждение платежа.';
$_['help_frame_url'] = 'URL-адрес фрейма';
$_['help_css'] = 'Адрес (URL) CSS файла.';
$_['help_frame_params'] = 'Пары атрибут-значение разделяйте пробелом';
$_['help_total'] = 'Итоговая сумма заказа, начиная с которой данный метод оплаты становится доступным.';
$_['help_debug'] = '';

// Error
$_['error_permission'] = 'Ошибка! У вас нет прав редактировать эти настройки!';
$_['error_merchant'] = 'Поле <b>Уникальный токен</b> обязательно для заполнения!';
$_['error_key'] = 'Поле <b>Ключ</b> обязательно для заполнения!';
$_['error_frame_url'] = 'Поле <b>Адрес фрейма</b> не может быть пусто!';
$_['error_frame_params'] = "Ошибка в заданных атрибутах iframe!";
