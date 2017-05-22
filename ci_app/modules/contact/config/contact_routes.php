<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// BACK-END
$route['^dashboard/contact/save-cache'] = 'contact/contact_admin/save_cache';

// END BACK-END.

// front end của page tieng viet|tieng anh
$route['(lien-he|lien-he.html|lien-he.htm|contact|contact.html|contact.htm)'] = 'contact/contact_us';
$route['(\w{2})/(lien-he|lien-he.html|lien-he.htm|contact|contact.html|contact.htm)'] = 'contact/contact_us/$1';

$route['(dang-ky|dang-ky.html|dang-ky.htm|register|register.html|register.htm)'] = 'contact/register';
$route['(\w{2})/(dang-ky|dang-ky.html|dang-ky.htm|register|register.html|register.htm)'] = 'contact/register/$1';

$route['lien-he-nhanh'] = 'contact/contact_quick';
