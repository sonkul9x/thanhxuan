<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// BACK-END
$route['^dashboard/pages/save-cache'] = 'pages/pages_admin/save_cache';
//ajax
$route['^dashboard/([\w]+)/change_status'] = '$1/$1_admin/change_status';
// END BACK-END.

//$route['^([\w\d-]+)\.(html|htm)$'] = 'pages/page_detail';
//$route['^(\w{2})/([\w\d-]+)\.(html|htm)$'] = 'pages/page_detail/$1';
