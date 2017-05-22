<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FRONT-END

//$route['^([\w\d-]+)-p(\d+)$'] = 'products/get_list_products_by_cat/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-p(\d+)$'] = 'products/get_list_products_by_cat/$3/1/$1';
//
//$route['^([\w\d-]+)-p(\d+)/(\d+)$'] = 'products/get_list_products_by_cat/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-p(\d+)/(\d+)$'] = 'products/get_list_products_by_cat/$3/$4/$1';
//
//$route['^([\w\d-]+)-ps(\d+)$'] = 'products/get_products_detail/$2/vi';
//$route['^(\w{2})/([\w\d-]+)-ps(\d+)$'] = 'products/get_products_detail/$3/$1';

$route['^(san-pham|products)$'] = 'products/get_list_products_by_cat/0/1';
$route['^(\w{2})/(san-pham|products)$'] = 'products/get_list_products_by_cat/0/1/$1';

$route['^(san-pham|products)/(\d+)$'] = 'products/get_list_products_by_cat/0/$2';
$route['^(\w{2})/(san-pham|products)/(\d+)$'] = 'products/get_list_products_by_cat/0/$3/$1';

$route['^hang-moi-ve$'] = 'products/get_list_products_by_cat/0/1/vi/1';
$route['^hang-moi-ve/(\d+)$'] = 'products/get_list_products_by_cat/0/$1/vi/1';
$route['^san-pham-ban-chay$'] = 'products/get_list_products_by_cat/0/1/vi/2';
$route['^san-pham-ban-chay/(\d+)$'] = 'products/get_list_products_by_cat/0/$1/vi/2';
$route['^san-pham-giam-gia$'] = 'products/get_list_products_by_cat/0/1/vi/3';
$route['^san-pham-giam-gia/(\d+)$'] = 'products/get_list_products_by_cat/0/$1/vi/3';

$route['^timkiem'] = 'products/products_search/1';
$route['^(\w{2})/searches'] = 'products/products_search/1/$1';

$route['^timkiem/(\d+)$'] = 'products/products_search/$1';
$route['^(\w{2})/searches/(\d+)$'] = 'products/products_search/$2/$1';

$route['^tagss/([\w\d-]+)$'] = 'products/products_tags/1/vi/$1';
$route['^(\w{2})/tagss/([\w\d-]+)'] = 'products/products_tags/1/$1/$2';

$route['^tagss/([\w\d-]+)/(\d+)$'] = 'products/products_tags/$2/vi/$1';
$route['^(\w{2})/tagss/([\w\d-]+)/(\d+)$'] = 'products/products_tags/$3/$1/$2';

$route['^gio-hang$'] = 'products/orders/cart';
$route['^(\w{2})/shopping-cart$'] = 'products/orders/cart/$1';

$route['^info-payment$'] = 'products/orders/info_pay';
$route['^thong-tin-khach-hang$'] = 'products/orders/info_pay';
$route['^thank-you$']    = 'products/orders/thank';

$route['(xac-nhan-dang-ky|xac-nhan-dang-ky.html|xac-nhan-dang-ky.htm)'] = 'products/orders/register_confirm';
$route['(dang-ky-thanh-cong|dang-ky-thanh-cong.html|dang-ky-thanh-cong.htm)'] = 'products/orders/register_success';
$route['(\w{2})/(dang-ky-thanh-cong|dang-ky-thanh-cong.html|dang-ky-thanh-cong.htm)'] = 'products/orders/register_success/$1';


$route['^xem-demo/([\w\d-]+)$'] = 'products/get_products_demo/$1';
$route['^(\w{2})/watch-demo/([\w\d-]+)$'] = 'products/get_products_demo/$2/$1';

$route['^addtocart'] = 'products/orders/add_to_cart';
$route['^removecart'] = 'products/orders/remove_cart';
$route['^updatecart'] = 'products/orders/update_cart';
$route['^products_sort_by'] = 'products/products_sort_by';
$route['^products_filter'] = 'products/products_filter';
$route['^products_filter_clear'] = 'products/products_filter_clear';


/*******************************************************************************/
// backend
/*******************************************************************************/

// Ajax kéo, thả, xóa hình ảnh khi đăng sản phẩm
$route['^upload_products_images$']            = 'products/products_admin/ajax_upload_products_image';

$route['^get_products_images$']               = 'products/products_admin/get_products_images';
$route['^sort_products_images$']              = 'products/products_admin/sort_products_image';
$route['^delete_products_images$']            = 'products/products_admin/delete_products_image';
$route['^products_categories/sort']           = 'products/cat_admin/sort_categories';

$route['^do_sort_products_list'] = 'products/products_admin/do_sort_products_list';

$route['^get_products_categories_by_lang'] = 'products/products_cat_admin/get_products_categories_by_lang';
/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/