# ArsenalPay Module for OpenCart 2.3.x CMS
OpenCart 2.3.x ArsenalPay CMS is software development kit for fast simple and seamless integration of your OpenCart 2.3.x web site with processing server of ArsenalPay.

*Arsenal Media LLC*  
[*Arsenal Pay processing server*]( https://arsenalpay.ru/)

*Has been tested on OpenCart 2.3.0.0 till 2.3.0.2*  
*Required php >= 5.4.0*
##### Basic feature list:  
 * Allows seamlessly integrate unified payment frame into your site.
 * New payment method ArsenalPay will appear to pay for your products and services.
 * Allows to pay using mobile commerce and bank acquiring. More methods are about to become available. Please check for updates.
 * Supports two languages (Russian, English).  
 
### How to install
1. Upload all folders and files to your server from the **upload** folder, place them in the web root of your website.
2. Login to the OpenCart admin section and go to **Extensions > Extensions**.
3. Choose the extension type **Payments** in the dropdown menu.
4. Find **ArsenalPay** in the list of payment methods.
5. Click on **Install** and then on **Edit** to make payment module settings.

### Settings
 - Fill out **Unique token**, **Key** fields with your received unique token and key. If you don't have them yet, register through the form https://arsenalpay.ru/#register and ArsenalPay manager will contact you or ask for your token and key by sending us an email on pay@arsenalpay.ru
 - Choose **Payment type** as `Bank cards` to activate payments with bank cards or `Mobile balance` to activate payments from mobile phone accounts.
 - Your online shop will be receiving callback requests about processed payments for automatically order status change. The callbacks will being received onto the address assigned in **Callback URL** field. Callback is set to address: `http(s)://yourWebSiteAddress/index.php?route=extension/payment/arsenalpay/ap_callback`
 - You can specify IP address only from which it will be allowed to receive callback requests about payments from ArsenalPay onto your site in **Allowed IP address** field.
 - Check **Frame address** to be as `https://arsenalpay.ru/payframe/pay.php` 
 - Set **Frame mode** as `in frame` to display payment frame inside your site. When the value is `out of frame` a payer will be redirected directly to the payment frame url. 
 - **iframe display attributes**. You can adjust **width**, **height**, **frameborder** and **scrolling** of ArsenalPay payment frame by setting iframe parameters. For instance, you can insert string in format: `width='100%' height='500' frameborder='0' scrolling='no'`. Go to html standard reference for more details about iframe attributes.
 - **css file**. You can specify CSS file to apply it to the view of payment frame by inserting css-file url.
 - Set order statuses for pending, confirmed, failed, canceled transactions.
 - You can set **Total** amount which must be reached in checkout total to make payment method active.
 - You can set **Geo Zone** where ArsenalPay payment method will be available.
 - You can enable/disable **Logs**.
 - Set **Status** as **Enabled**.
 - Set **Sort Order**: the order number of ArsenalPay in the list of enabled payment methods.
 - Finally, save settings by clicking on **Save**.

### How to uninstall
1. Login to the Open Cart admin section and go to **Extensions > Extensions**.
3. Choose the extension type **Payments** in the dropdown menu.
2. Find **Arsenal Pay** in the list of payment methods.
3. Click on **Uninstall**.
4. Delete files associated with ArsenalPay payment method from your web server.

### Usage
After successful installation and proper settings new choice of payment method with ArsenalPay will appear on your website. To make payment for an order a payer will need to:  

1. Choose goods from the shop catalog.
2. Go into the order page.
3. Choose the ArsenalPay payment method.
4. Check the order detailes and confirm the order.
5. After filling out the information depending on the payment type he will receive SMS about payment confirmation or will be redirected to the page with the result of his payment.

------------------

#### О МОДУЛЕ
* Модуль платежной системы ArsenalPay для OpenCart позволяет легко встроить платежную страницу на Ваш сайт.
* После установки модуля у Вас появится новый вариант оплаты товаров и услуг через платежную систему ArsenalPay.
* Платежная система ArsenalPay позволяет совершать оплату с различных источников списания средств: мобильных номеров (МТС/Мегафон/Билайн/TELE2), пластиковых карт (VISA/MasterCard/Maestro). Перечень доступных источников средств постоянно пополняется. Следите за обновлениями.
* Модуль поддерживает русский и английский языки.  

За более подробной информацией о платежной системе ArsenalPay обращайтесь по адресу https://www.arsenalpay.ru

#### УСТАНОВКА
1. Скопируйте файлы из папки **upload** в корень Вашего сайта, сохраняя структуру вложенности папок;
2. Зайдите в администрирование OpenCart и пройдите к **Модули / Расширения > Модули / Расширения**;
3. Выберите тип расширения **Оплата** в ниспадающем меню;
4. Найдите **ArsenalPay** в списке способов оплат;
5. Нажмите на **Активировать** и затем **Редактировать**, чтобы провести настройки платежного модуля.

#### НАСТРОЙКА
 - Заполните поля **Уникальный токен** и **Ключ**, присвоенными Вам токеном и ключом для подписи. Если у Вас еще нет токена и ключа, то оставьте свою заявку на подключение через форму https://arsenalpay.ru/#register и менеджер ArsenalPay свяжется с Вами, либо отправьте запрос на получение токена и ключа письмом на pay@arsenalpay.ru. 
 - Установите **Тип оплаты** как `Банковские карты` для активации платежей с пластиковых карт или  как `Баланс мобильного` — платежей с аккаунтов мобильных телефонов.
 - Ваш интернет-магазин будет получать уведомления о совершенных платежах. На адрес, указанный в поле **URL для обратного запроса** на подтверждение платежа, от ArsenalPay будет поступать запрос с результатом платежа для фиксирования статусов заказа в системе интернет-магазина. Обратный запрос настроен на адрес: `http(s)://адресВашегоСайта/index.php?route=extension/payment/arsenalpay/ap_callback`
 - Вы можете задать IP-адрес, только с которого будут разрешены обратные запросы о совершаемых платежах, в поле **Разрешенный IP-адрес**.
 - Проверьте: **Адрес фрейма** должен быть установлен как `https://arsenalpay.ru/payframe/pay.php`
 - Вы можете устанавливать **Режим отображения платежной страницы**. Значение `во фрейме` соответствует отображению фрейма внутри Вашего сайта. При значении `вне фрейма` пользователь будет перенаправляться напрямую на адрес платежной страницы.
 - **Атрибуты отображения iframe**. Вы можете подгонять ширину, высоту, границу и прокрутку платежного фрейма, задавая соответствующие значения аттрибутов iframe в формате `width='100%' height'500' frameborder='0' scrolling='no'`. За более подробной информацией о параметрах iframe обращайтесь к стандарту html.
 - Вы можете задать **Файл css** для применения к отображению платежного фрейма, указав url css-файла.
 - Установите статусы заказов на время ожидания оплаты, после подтверждения платежа, неудавшегося платежа и отказа от платежа.
 - Вы можете задать **Итого**, итоговую сумму заказа, при которой данный метод оплаты становится доступным.
 - Вы можете задать географическую зону, где будет доступен метод оплаты ArsenalPay. 
 - Вы можете включать/выключать **Логирование**.
 - Включите модуль, установив **Статус** на **Включено**.
 - Задайте **Порядок сортировки**: укажите порядковый номер ArsenalPay в списке включенных методов оплаты.
 - Закончив, сохраните настройки нажатием на **Сохранить**.

#### УДАЛЕНИЕ
1. Зайдите в администрирование OpenCart и пройдите к **Модули / Расширения > Модули / Расширения**;
2. Выберите тип расширения **Оплата** в ниспадающем меню;
3. Найдите **ArsenalPay** в списке методов оплаты;
4. Нажмите на **Удалить**.
5. Удалите файлы, относящиеся к методу оплаты ArsenalPay с сервера.

#### ИСПОЛЬЗОВАНИЕ
После успешной установки и настройки модуля на сайте появится возможность выбора платежной системы ArsenalPay.
Для оплаты заказа с помощью платежной системы ArsenalPay нужно:

1. Выбрать из каталога товар, который нужно купить.
2. Перейти на страницу оформления заказа (покупки).
3. В разделе "Платежные системы" выбрать платежную систему ArsenalPay.
4. Перейти на страницу подтверждения введенных данных и ввода источника списания средств (мобильный номер, пластиковая карта и т.д.).
5. После ввода данных об источнике платежа, в зависимости от его типа, либо придет СМС о подтверждении платежа, либо покупатель будет перенаправлен на страницу с результатом платежа.

------------------

### ОПИСАНИЕ РЕШЕНИЯ
ArsenalPay – удобный и надежный платежный сервис для бизнеса любого размера. 

Используя платежный модуль от ArsenalPay, вы сможете принимать онлайн-платежи от клиентов по всему миру с помощью: 
пластиковых карт международных платёжных систем Visa и MasterCard, эмитированных в любом банке
баланса мобильного телефона операторов МТС, Мегафон, Билайн, Ростелеком и ТЕЛЕ2
различных электронных кошельков 

#### Преимущества сервиса: 
 - [Самые низкие тарифы](https://arsenalpay.ru/tariffs.html)
 - Бесплатное подключение и обслуживание
 - Легкая интеграция
 - [Агентская схема: ежемесячные выплаты разработчикам](https://arsenalpay.ru/partnership.html)
 - Вывод средств на расчетный счет без комиссии
 - Сервис смс оповещений
 - Персональный личный кабинет
 - Круглосуточная сервисная поддержка клиентов 

А ещё мы можем взять на техническую поддержку ваш сайт и создать для вас мобильные приложения для Android и iOS. 

ArsenalPay – увеличить прибыль просто! 
Мы работаем 7 дней в неделю и 24 часа в сутки. А вместе с нами множество российских и зарубежных компаний. 

#### Как подключиться: 
1. Вы скачали модуль и установили его у себя на сайте;
2. Отправьте нам письмом ссылку на Ваш сайт на pay@arsenalpay.ru либо оставьте заявку на [сайте](https://arsenalpay.ru/#register) через кнопку "Подключиться";
3. Мы Вам вышлем коммерческие условия и технические настройки;
4. После Вашего согласия мы отправим Вам проект договора на рассмотрение.
5. Подписываем договор и приступаем к работе.

Всегда с радостью ждем ваших писем с предложениями. 

pay@arsenalpay.ru  
[arsenalpay.ru](https://arsenalpay.ru)
