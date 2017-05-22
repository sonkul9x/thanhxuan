<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*******************************************************************************/
// Phần backend-routing, không cần thay đổi cho các dự án của khách hàng
// chỉ thay đổi trong những trường hợp thực sự cần thiết
/*******************************************************************************/
// back end

$route['^dashboard/system_config']              = 'configurations/configurations_admin/config';
$route['^dashboard/system_config/(vi|en)']     = 'configurations/configurations_admin/config/$1';

$route['^dashboard/system_config/save-cache']   = 'configurations/configurations_admin/save_cache';
$route['^dashboard/delete-images-logo/(vi|en)'] = 'configurations/configurations_admin/delete_images_logo/$1';
$route['^dashboard/delete-images-favicon/(vi|en)'] = 'configurations/configurations_admin/delete_images_favicon/$1';

/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/