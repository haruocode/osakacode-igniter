<?php
$route['settings'] = 'SettingsController/account';
$route['settings/account'] = 'SettingsController/account';
$route['settings/subscription/(:any)'] = 'SubscriptionController/$1';
$route['settings/card/(:any)'] = 'CardController/$1';
$route['login'] = 'UserController';
$route['logout'] = 'UserController/logout';
$route['signup/none']['post'] = 'UserController/postSignupfree/';
$route['signup/(:any)'] = 'UserController/signup/$1';

$route['join'] = 'UserController/join';
$route['settings/subscription/invoices/(:any)'] = 'SubscriptionController/invoice_detail/$1';
$route['settings/card/(:any)'] = 'CardController/$1';