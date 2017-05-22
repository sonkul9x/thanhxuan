<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Mặc định của PowerCMS */
define('DEFAULT_ADMIN_KEYWORDS',      'PowerCMS');
define('DEFAULT_ADMIN_DESCRIPTION',   'Hệ quản trị thông tin PowerCMS do công ty INFOPOWERS.,JSC cung cấp');
define('DEFAULT_ADMIN_TITLE',         'Quản trị hệ thống');
define('DEFAULT_ADMIN_TITLE_SUFFIX',  ' | PowerCMS');

define('DOMAIN_NAME', 'thanhxuanduoc.com');
define('DOMAIN_URL', 'http://thanhxuanduoc.com'); //not / at end

define('DEFAULT_TITLE_SUFFIX',  '');
define('DEFAULT_CACHE_PREFIX',  'ip_');

define('DEFAULT_FOOTER', 'Copyright © 2015 <a href="http://thanhxuanduoc.com" title="">thanhxuanduoc.com</a>');

//default email nhan don dat hang
define('ORDER_EMAIL' , 'thanhxuanduocmail@gmail.com');
define('EMAIL_NO_REPLY' , 'thanhxuanduocmail@gmail.com');
//default email nhan tin nhan lien he
define('CONTACT_EMAIL' , 'thanhxuanduocmail@gmail.com');

define('DEFAULT_COMPANY', 'thanhxuanduoc.com');

//Status active
define('STATUS_ACTIVE', 1);
define('STATUS_INACTIVE', 0);

//url friendly active, 1:active (url khong id), 0:inactive (url co id)
define('SLUG_ACTIVE', 1);

//default language - cai dat cho da ngon ngu vi,en,cn,fr... (can sua lai ca routes)
define('DEFAULT_LANGUAGE','vi');

//ẩn danh sách menu admin trong danh sách menu (1:ẩn, 0:hiện)
define('HIDE_ADMIN_MENU', 1);

define('CITY_ID',        1);

// operations permission
define('OPERATION_MANAGE',      2);
define('OPERATION_NEWS_MANAGE_CAT',  20);

define('OPERATION_ADMIN',  21);


define('ROLE_GUESS'     ,        -1);
define('ROLE_ADMINISTRATOR',      0);
define('ROLE_MANAGER',            2);

define('DEFAULT_COMBO_VALUE',   -1);
define('DEFAULT_PAGE',          1);
define('DEFAULT_OFFSET',        0);
define('PAGINATION_NUM_LINKS',  2);
define('ROOT_CATEGORY_ID'     , 0);

define('ONE_BILLION',           1000000000);
define('ONE_MILLION',           1000000);
define('ONE_THOUSAND',          1000);
define('ONE_USD',               1);
define('UNIT_VND',              0);
define('UNIT_USD',              1);
define('SHOW_ZERO',             TRUE);
define('NOT_SHOW_ZERO',         FALSE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */