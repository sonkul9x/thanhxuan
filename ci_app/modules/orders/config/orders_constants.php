<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//trạng thái đơn hàng
define('NEW_ORDER_NEW',0); //đơn hàng chưa xử lý
define('NEW_ORDER',1); //đơn hàng chưa giao
define('ILLUSIVE_ORDER',2); //đơn hàng ảo
define('GCTT',4); //đơn hàng ảo
define('PAID_ORDER',3); //Đã thanh toán hàng ảo


define('ORDER_ADMIN_BASE_URL',       '/dashboard/orders');

// ỎDERS CONSTANTS
define('ORDERS_ADMIN_BASE_URL'        , '/dashboard/orders');
define('ORDERS_ADMIN_ADD_URL'         , '/dashboard/orders/add');
define('ORDERS_ADMIN_EDIT_URL'        , '/dashboard/orders/edit');
define('ORDERS_ADMIN_DELETE_URL'      , '/dashboard/orders/delete');
define('ORDERS_ADMIN_UP_URL'          , '/dashboard/orders/up');
define('ORDERS_ADMIN_EXPORT'          , '/dashboard/orders/export');