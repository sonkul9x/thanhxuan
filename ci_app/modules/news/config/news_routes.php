<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$route['^([\w\d-]+)-n(\d+)$'] = 'news/get_list_news_by_cat/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-n(\d+)$'] = 'news/get_list_news_by_cat/$3/1/$1';
//
//$route['^([\w\d-]+)-n(\d+)/(\d+)$'] = 'news/get_list_news_by_cat/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-n(\d+)/(\d+)$'] = 'news/get_list_news_by_cat/$3/$4/$1';
//
//$route['^([\w\d-]+)-ns(\d+)$'] = 'news/get_news_detail/$2/vi';
//$route['^(\w{2})/([\w\d-]+)-ns(\d+)$'] = 'news/get_news_detail/$3/$1';

$route['^tim-kiem'] = 'news/news_search/1';
$route['^(\w{2})/search'] = 'news/news_search/1/$1';

$route['^tim-kiem/(\d+)$'] = 'news/news_search/$1';
$route['^(\w{2})/search/(\d+)$'] = 'news/news_search/$2/$1';

$route['^tag/([\w\d-]+)$'] = 'news/news_tags/1/vi/$1';
$route['^(\w{2})/tag/([\w\d-]+)$'] = 'news/news_tags/1/$1/$2';

$route['^tag/([\w\d-]+)/(\d+)$'] = 'news/news_tags/$2/vi/$1';
$route['^(\w{2})/tag/([\w\d-]+)/(\d+)$'] = 'news/news_tags/$3/$1/$2';

// BACK-END
$route['^get_news_categories_by_lang'] = 'news/news_cat_admin/get_news_categories_by_lang';

$route['^dashboard/([\w]+)/change_startups']          = '$1/$1_admin/change_startups';
$route['^dashboard/([\w]+)/([\w]+)/change_startups']  = '$1/$1_$2_admin/change_startups';

$route['^do_sort_news_list'] = 'news/news_admin/do_sort_news_list';