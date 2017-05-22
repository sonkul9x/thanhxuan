<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FRONT-END
//$route['^([\w\d-]+)-v(\d+)$'] = 'videos/get_list_videos_by_cat/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-v(\d+)$'] = 'videos/get_list_videos_by_cat/$3/1/$1';
//
//$route['^([\w\d-]+)-v(\d+)/(\d+)$'] = 'videos/get_list_videos_by_cat/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-v(\d+)/(\d+)$'] = 'videos/get_list_videos_by_cat/$3/$4/$1';
//
//$route['^([\w\d-]+)-vs(\d+)$'] = 'videos/get_videos_detail/$2/vi';
//$route['^(\w{2})/([\w\d-]+)-vs(\d+)$'] = 'videos/get_videos_detail/$3/$1';

//BACKEND
$route['^add_videos_items$']                = 'videos/videos_admin/add_videos_item';
$route['^get_videos_items$']               = 'videos/videos_admin/get_videos_item';
$route['^sort_videos_items$']              = 'videos/videos_admin/sort_videos_item';
$route['^delete_videos_items$']            = 'videos/videos_admin/delete_videos_item';
$route['^videos_categories/sort']          = 'videos/videos_cat_admin/sort_categories';
$route['^get_videos_categories_by_lang']   = 'videos/videos_cat_admin/get_videos_categories_by_lang';
$route['^add_caption_videos_items$']        = 'videos/videos_admin/add_caption_videos_item';
