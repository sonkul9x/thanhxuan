<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['libraries']  = array('email');
$autoload['helper']     = array('date','orders');
$autoload['plugin']     = array();
$autoload['config']     = array();
$autoload['language']   = array();
$autoload['model']      = array(
                            'products_model',
                            'products_images_model',
                            'products_categories_model',
                            'products_units_model',
                            'products_origin_model',
                            'products_trademark_model',
                            'products_color_model',
                            'products_state_model',
                            'products_size_model',
                            'products_style_model',
                            'products_material_model',
                            'products_coupon_model',
                            'products_coupon_item_model',
                            'orders_model',
                            'orders_details_model',
                            'slug/slug_model'
                        );