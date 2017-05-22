<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FRONT-END
//$route['^([\w\d-]+)-q(\d+)$'] = 'faq/get_list_faq_by_cat/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-q(\d+)$'] = 'faq/get_list_faq_by_cat/$3/1/$1';
//
//$route['^([\w\d-]+)-q(\d+)/(\d+)$'] = 'faq/get_list_faq_by_cat/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-q(\d+)/(\d+)$'] = 'faq/get_list_faq_by_cat/$3/$4/$1';
//
////$route['^([\w\d-]+)/([\w\d-]+)-qs(\d+)-(\d+)$'] = 'faq/get_faq_detail/$4/vi';
////$route['^(\w{2})/([\w\d-]+)/([\w\d-]+)-qs(\d+)-(\d+)$'] = 'faq/get_faq_detail/$5/$1';
//
//$route['^([\w\d-]+)-qs(\d+)$'] = 'faq/get_faq_detail/$2/vi';
//$route['^(\w{2})/([\w\d-]+)-qs(\d+)$'] = 'faq/get_faq_detail/$3/$1';

$route['^tim-kiem-hoi-dap'] = 'faq/faq_search/1';
$route['^(\w{2})/faq-search'] = 'faq/faq_search/1/$1';

$route['^tim-kiem-hoi-dap/(\d+)$'] = 'faq/faq_search/$1';
$route['^(\w{2})/faq-search/(\d+)$'] = 'faq/faq_search/$2/$1';

$route['^faq-tags/([\w\d-]+)$'] = 'faq/faq_tags/1/vi/$1';
$route['^(\w{2})/faq-tags/([\w\d-]+)$'] = 'faq/faq_tags/1/$1/$2';

$route['^faq-tags/([\w\d-]+)/(\d+)$'] = 'faq/faq_tags/$2/vi/$1';
$route['^(\w{2})/faq-tags/([\w\d-]+)/(\d+)$'] = 'faq/faq_tags/$3/$1/$2';

$route['^gui-cau-hoi$'] = 'faq/faq_send';
$route['^(\w{2})/send-question$'] = 'faq/faq_send/$1';

// BACK-END
$route['^get_faq_categories_by_lang'] = 'faq/faq_cat_admin/get_faq_categories_by_lang';

$route['^do_sort_faq_list'] = 'faq/faq_admin/do_sort_faq_list';