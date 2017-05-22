<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FRONT-END
$route['^thong-tin-ca-nhan$']                       = 'customers/get_infomation_customers';
$route['^quan-ly-don-hang$']                        = 'customers/manager_order/1';
$route['^quan-ly-don-hang/trang-(\d+)$']            = 'customers/manager_order/$1';
$route['^quan-ly-don-hang/chi-tiet-don-hang$']      = 'customers/detail_order_ajax';

$route['^tao-tai-khoan|sign-up$']                   = 'customers/customers_sign_up';
$route['^dang-nhap-thanh-vien|customers-login$']    = 'customers/login_customers';
$route['^dang-xuat$']                               = 'customers/logout';

// BACK-END