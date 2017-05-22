<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['libraries']  = array();
$autoload['helper']     = array();
$autoload['plugin']     = array();
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array(
    'auth/users_model',
    'contact/contact_model',
    'pages/pages_model',
    'products/orders_model',
    'products/orders_details_model',
    'products/products_model',
    'products/products_categories_model',
    'news/news_model',
    'news/news_categories_model',
    'faq/faq_model',
    'faq/faq_categories_model',
    'faq/faq_professionals_model',
    'slug/slug_model'
    );