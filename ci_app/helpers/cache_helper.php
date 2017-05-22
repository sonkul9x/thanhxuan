<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if(!function_exists('get_cache'))
{
    function get_cache($cache_file = '')
    {
        $cache_path = './cache/' . $cache_file . '.php';
//        $CI =& get_instance();
//        $CI->load->model('config');
        $config = array();
        if(file_exists($cache_path))
        {
            include $cache_path;
            $cache_name = DEFAULT_CACHE_PREFIX . $cache_file;
            if(isset($$cache_name) && !empty($$cache_name))
            {
                $config = $$cache_name;
            }
            else
            {
                $config = set_cache($cache_file);
            }
        }
        else
        {
            $config = set_cache($cache_file);
        }
        return $config;
    }
}

if(!function_exists('set_cache'))
{
    function set_cache($cache_file = '')
    {
//        $cache_path = './cache/' . $cache_file . '.php';
        $data = array();
        switch ($cache_file) {
            case 'configurations':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE)); 
                break;
            case 'configurations_vi':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE, 'lang' => 'vi')); 
                break;
            case 'configurations_en':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE, 'lang' => 'en')); 
                break;
            case 'pages':
                $data     = modules::run('pages/get_page_data', array('array' => TRUE)); 
                break;
            case 'menus':
                $data     = modules::run('menus/get_menu_data', array('array' => TRUE)); 
                break;
            default:
                break;
        }
        return $data;
    }
}

if(!function_exists('save_cache'))
{
    function save_cache($cache_file = '')
    {
        $cache_path = './cache/' . $cache_file . '.php';
        $data = array();
        switch ($cache_file) {
            case 'configurations':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE)); 
                break;
            case 'configurations_vi':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE, 'lang' => 'vi')); 
                break;
            case 'configurations_en':
                $data     = modules::run('configurations/get_configuration', array('array' => TRUE, 'lang' => 'en')); 
                break;
            case 'pages':
                $data     = modules::run('pages/get_page_data', array('array' => TRUE)); 
                break;
            case 'menus':
                $data     = modules::run('menus/get_menu_data', array('array' => TRUE)); 
                break;
            case 'calendar':
                $data     = modules::run('calendar/get_calendar_data', array('array' => TRUE)); 
                break;
            default:
                break;
        }
        @chmod($cache_path, 0777);
        $cache_data = '<?php $' . DEFAULT_CACHE_PREFIX . $cache_file . ' = ' . var_export($data, TRUE) . '?>';
        $CI =& get_instance();
        $CI->load->helper('file');
        if (!write_file($cache_path, $cache_data))
        {
             return FALSE;
        }
        else {return TRUE;}
    }
}


?>
