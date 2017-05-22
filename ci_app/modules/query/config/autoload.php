<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['libraries']  = array();
$autoload['helper']     = array();
$autoload['plugin']     = array();
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array(
                            'products/products_model',
                            'products/products_categories_model',
                            'menus/menus_model',
                            'news/news_model',
                            'news/news_categories_model',
                            'slug/slug_model'
                            );