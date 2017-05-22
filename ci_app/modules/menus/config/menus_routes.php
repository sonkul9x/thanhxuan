<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
$route['^dashboard/menus/save-cache$']  = 'menus/menus_admin/save_cache_menu';
$route['^dashboard/menus/change_menus']  = 'menus/menus_admin/change_menus';

$route['^menus/sort$']                  = 'menus/menus_admin/sort_menus';
$route['^menus/active$']                = 'menus/menus_admin/update_menu_active';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/
