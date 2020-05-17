<?php
$route['admin/login']['get'] = 'admin/LoginController/login';
$route['admin/login']['post'] = 'admin/LoginController/postLogin';
$route['admin/migrate'] = 'admin/MigrateController';

$route['adm'] = 'AdminController/index';
$route['adm/series'] = 'AdminController/series';
$route['adm/add_series'] = 'AdminController/add_series';
$route['adm/edit_series/(:num)'] = 'AdminController/edit_series/$1';
$route['adm/delete_series/(:num)'] = 'AdminController/delete_series/$1';
$route['adm/lessons/(:num)'] = 'AdminController/lessons/$1';
$route['adm/add_lesson/(:num)'] = 'AdminController/add_lesson/$1';
$route['adm/edit_lesson/(:num)'] = 'AdminController/edit_lesson/$1';
$route['adm/delete_lesson/(:num)'] = 'AdminController/delete_lesson/$1';
