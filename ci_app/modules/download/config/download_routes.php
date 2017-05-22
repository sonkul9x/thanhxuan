<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// FRONT-END

$route['^download$'] = 'download/download_list/0/1/vi';
$route['^(\w{2})/download$'] = 'download/download_list/0/1/$1';

//$route['^download/(\d+)$'] = 'download/download_list/0/$1/vi';
//$route['^(\w{2})/download/(\d+)$'] = 'download/download_list/0/$2/$1';

//$route['^([\w\d-]+)-d(\d+)$'] = 'download/download_list/$2/1/vi';
//$route['^(\w{2})/([\w\d-]+)-d(\d+)$'] = 'download/download_list/$3/1/$1';
//
//$route['^([\w\d-]+)-d(\d+)/(\d+)$'] = 'download/download_list/$2/$3/vi';
//$route['^(\w{2})/([\w\d-]+)-d(\d+)/(\d+)$'] = 'download/download_list/$3/$4/$1';

$route['^download-attachments/(\d+)$'] = 'download/download_file/$1';

/*******************************************************************************/
// backend
/*******************************************************************************/

$route['^dashboard/downloadfile/(\d+)$'] = 'download/download_admin/admin_download_file/$1';

// Ajax
$route['^upload_file_download$'] = 'download/download_admin/ajax_upload_file_download';

$route['^get_file_download$'] = 'download/download_admin/get_file_download';
$route['^delete_file_download$'] = 'download/download_admin/delete_file_download';

$route['^get_download_categories_by_lang'] = 'download/download_cat_admin/get_download_categories_by_lang';

/*******************************************************************************/
// Kết thúc phần backend-routing
/*******************************************************************************/