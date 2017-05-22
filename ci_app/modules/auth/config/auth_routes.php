<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$route['^logout|thoat$'] = 'auth/logout';
$route['^login|dang-nhap$'] = 'auth/login';

$route['^dashboard/auth/change_password'] = 'auth/auth_admin/change_password';

$route['^dashboard/auth/roles'] = 'auth/roles_admin/browse';
$route['^dashboard/auth/roles/(vi|en)'] = 'auth/roles_admin/browse/$1'; //multi language
$route['^dashboard/auth/roles/page-(\d+)'] = 'auth/roles_admin/browse/vi/$1';
$route['^dashboard/auth/roles/(\w{2})/page-(\d+)'] = 'auth/roles_admin/browse/$1/$2'; //multi language
$route['^dashboard/auth/roles/add'] = 'auth/roles_admin/add';
$route['^dashboard/auth/roles/edit'] = 'auth/roles_admin/edit';
$route['^dashboard/auth/roles/delete'] = 'auth/roles_admin/delete';
$route['^dashboard/auth/roles/change_status'] = 'auth/roles_admin/change_status';

$route['^dashboard/auth/roles_menus'] = 'auth/roles_menus_admin/browse';
$route['^dashboard/auth/roles_menus/(vi|en)'] = 'auth/roles_menus_admin/browse/$1'; //multi language
$route['^dashboard/auth/roles_menus/page-(\d+)'] = 'auth/roles_menus_admin/browse/vi/$1';
$route['^dashboard/auth/roles_menus/(\w{2})/page-(\d+)'] = 'auth/roles_menus_admin/browse/$1/$2'; //multi language
$route['^dashboard/auth/roles_menus/add'] = 'auth/roles_menus_admin/add';
$route['^dashboard/auth/roles_menus/edit'] = 'auth/roles_menus_admin/edit';
$route['^dashboard/auth/roles_menus/delete'] = 'auth/roles_menus_admin/delete';
$route['^dashboard/auth/roles_menus/change_status'] = 'auth/roles_menus_admin/change_status';

$route['^(dashboard/auth/permission_denied|dashboard/permission_denied)'] = 'auth/auth_admin/permission_denied';
