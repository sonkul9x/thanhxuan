<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['^$'] = 'homepage/index';
$route['^(vi|en)$'] = 'homepage/index';

//list non paging
$route['^([\w\d-]+)$'] = 'slug/get_slug/$1/vi/1';
$route['^(\w{2})/([\w\d-]+)$'] = 'slug/get_slug/$2/$1/1';

//list paging
$route['^([\w\d-]+)/(\d+)$'] = 'slug/get_slug/$1/vi/$2';
$route['^(\w{2})/([\w\d-]+)/(\d+)$'] = 'slug/get_slug/$2/$1/$3';

//DETAIL
$route['^([\w\d-]+)\.(html|htm)$'] = 'slug/get_slug/$1/vi/1/1';
$route['^(\w{2})/([\w\d-]+)\.(html|htm)$'] = 'slug/get_slug/$2/$1/1/1';
