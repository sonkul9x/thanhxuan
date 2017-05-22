<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// FRONT-END
//$route['^([\w\d-]+)-g(\d+)$'] = 'gallery/get_list_gallery_by_cat/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-g(\d+)$'] = 'gallery/get_list_gallery_by_cat/$3/1/$1';
//
//$route['^([\w\d-]+)-g(\d+)/(\d+)$'] = 'gallery/get_list_gallery_by_cat/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-g(\d+)/(\d+)$'] = 'gallery/get_list_gallery_by_cat/$3/$4/$1';
//
//$route['^([\w\d-]+)-gs(\d+)$'] = 'gallery/get_gallery_detail/$2/vi';
//$route['^(\w{2})/([\w\d-]+)-gs(\d+)$'] = 'gallery/get_gallery_detail/$3/$1';

//BACKEND
$route['^upload_gallery_images$']            = 'gallery/gallery_admin/ajax_upload_gallery_image';
$route['^get_gallery_images$']               = 'gallery/gallery_admin/get_gallery_image';
$route['^sort_gallery_images$']              = 'gallery/gallery_admin/sort_gallery_image';
$route['^delete_gallery_images$']            = 'gallery/gallery_admin/delete_gallery_image';
$route['^gallery_categories/sort']           = 'gallery/cat_admin/sort_categories';
$route['^get_gallery_categories_by_lang']    = 'gallery/gallery_cat_admin/get_gallery_categories_by_lang';
$route['^add_caption_image_gallery$']        = 'gallery/gallery_admin/add_caption_image_gallery';
