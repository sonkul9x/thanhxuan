<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// front end tieng viet|tieng anh
$route['(dat-ban|reserve)'] = 'reserve/reserve_now';
$route['(\w{2})/(dat-ban|reserve)'] = 'reserve/reserve_now/$1';
