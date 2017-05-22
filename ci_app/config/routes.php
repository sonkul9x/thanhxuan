<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['^security_code$']       = 'auth/auth/captcha';

$route['^sitemap.xml$'] = 'homepage/get_sitemap_xml';
$route['^sitemaps.xml$'] = 'homepage/get_sitemap_xml';

$handle = opendir(APPPATH.'modules');
if ($handle)
{
    while ( false !== ($module = readdir($handle)) )
    {
        // make sure we don't map silly dirs like .svn, or . or ..
        if (substr($module, 0, 1) != ".")
        {
            // load route
            if ( file_exists(APPPATH.'modules/'.$module.'/config/'.$module.'_routes.php') && $module <> 'slug')
            {
                include(APPPATH.'modules/'.$module.'/config/'.$module.'_routes.php');
            }
            // load constants
            if ( file_exists(APPPATH.'modules/'.$module.'/config/'.$module.'_constants.php') )
            {
                include(APPPATH.'modules/'.$module.'/config/'.$module.'_constants.php');
            }
        }
    }
    if ( file_exists(APPPATH.'modules/slug/config/slug_routes.php') )
    {
        include(APPPATH.'modules/slug/config/slug_routes.php');
    }
}

//$route['default_controller'] = "main";
$route['default_controller'] = "homepage/index";
$route['404_override'] = '';

/**
 * @author: Nguyen Tuan Anh
 * @date: 2014-02-06
 * 
 * Thiet lap routing tu dong de quan ly toan bo cac request den phan quan tri 
 * cua tung module cu the.
 * 
 * VD: 
 * - dashboard/welcome          --> welcome/welcome_admin
 * - dashboard/welcome/hello    --> welcome/welcome_admin/hello
 */
// Chuyen het toan bo cac routing trong phan admin khi goi qua dashboard
// fixed by nmd

$route['^dashboard/([\w]+)']                        = '$1/$1_admin/browse';
$route['^dashboard/([\w]+)/(vi|en)']                = '$1/$1_admin/browse/$2'; //multi language

//$route['^dashboard/([\w]+)/page-(\d+)']             = '$1/$1_admin/browse/$2';
$route['^dashboard/([\w]+)/page-(\d+)']             = '$1/$1_admin/browse/vi/$2';
$route['^dashboard/([\w]+)/(\w{2})/page-(\d+)']     = '$1/$1_admin/browse/$2/$3'; //multi language

$route['^dashboard/([\w]+)/add']                    = '$1/$1_admin/add';
$route['^dashboard/([\w]+)/edit']                   = '$1/$1_admin/edit';
$route['^dashboard/([\w]+)/delete']                 = '$1/$1_admin/delete';
$route['^dashboard/([\w]+)/change_status']          = '$1/$1_admin/change_status';
$route['^dashboard/([\w]+)/change_home']            = '$1/$1_admin/change_home';
$route['^dashboard/([\w]+)/change_private']         = '$1/$1_admin/change_private';
$route['^dashboard/([\w]+)/up']                     = '$1/$1_admin/up';
$route['^dashboard/([\w]+)/export']                 = '$1/$1_admin/export';
$route['^dashboard/([\w]+)/import']                 = '$1/$1_admin/import';
//---
// Cho phep cac admin controller khác cung co the duoc goi tu dong
$route['^dashboard/([\w]+)/([\w]+)']                = '$1/$1_$2_admin/browse';
$route['^dashboard/([\w]+)/([\w]+)/(vi|en)']        = '$1/$1_$2_admin/browse/$3'; //multi language

//$route['^dashboard/([\w]+)/([\w]+)/page-(\d+)']             = '$1/$1_$2_admin/browse/$3';
$route['^dashboard/([\w]+)/([\w]+)/page-(\d+)']             = '$1/$1_$2_admin/browse/vi/$3';
$route['^dashboard/([\w]+)/([\w]+)/(\w{2})/page-(\d+)']     = '$1/$1_$2_admin/browse/$3/$4'; //multi language

$route['^dashboard/([\w]+)/([\w]+)/add']            = '$1/$1_$2_admin/add';
$route['^dashboard/([\w]+)/([\w]+)/edit']           = '$1/$1_$2_admin/edit';
$route['^dashboard/([\w]+)/([\w]+)/delete']         = '$1/$1_$2_admin/delete';
$route['^dashboard/([\w]+)/([\w]+)/change_status']  = '$1/$1_$2_admin/change_status';
$route['^dashboard/([\w]+)/([\w]+)/change_home']    = '$1/$1_$2_admin/change_home';
$route['^dashboard/([\w]+)/([\w]+)/change_private'] = '$1/$1_$2_admin/change_private';
$route['^dashboard/([\w]+)/([\w]+)/up']             = '$1/$1_$2_admin/up';

$route['^dashboard/([\w]+)/([\w]+)/change_grid'] = '$1/$1_$2_admin/change_grid';

// End.

/* End of file routes.php */
/* Location: ./application/config/routes.php */