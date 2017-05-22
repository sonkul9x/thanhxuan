<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['libraries']  = array('pagination');
$autoload['helper']     = array('text','orders');
$autoload['plugin']     = array();
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array('orders_model', 'orders_categories_model', 'orders_details_model');