<?php
class Utility_Model extends CI_Model
{
    function  __construct()
    {
        parent::__construct();
    }

    public function get_product_units_combo($options = array())
    {
        // Default name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'unit';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options               = array();
        $data_options[ONE_THOUSAND] = 'Nghìn đồng';
        $data_options[ONE_MILLION]  = 'Triệu đồng';
        $data_options[ONE_BILLION]  = 'Tỷ đồng';
        if (!isset($options[$options['combo_name']]) || $options[$options['combo_name']] == '')
        {
            $options[$options['combo_name']] = ONE_THOUSAND;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }
    
    public function get_special_product_combo($options = array())
    {
        // Default name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'special';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options                           = array();
        $data_options[PRODUCTS_IS_SPECIAL_PRODUCT]       = 'Có';
        $data_options[PRODUCTS_IS_NOT_SPECIAL_PRODUCT]   = 'Không';
        if (!isset($options[$options['combo_name']]) || $options[$options['combo_name']] == '')
        {
            $options[$options['combo_name']] = PRODUCTS_IS_NOT_SPECIAL_PRODUCT;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }
    
    public function get_tax_combo($options = array())
    {
        // Default name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'tax';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options                           = array();
        $data_options[PRODUCTS_IS_TAX]       = 'Có';
        $data_options[PRODUCTS_IS_NOT_TAX]   = 'Không';
        if (!isset($options[$options['combo_name']]) || $options[$options['combo_name']] == '')
        {
            $options[$options['combo_name']] = PRODUCTS_IS_TAX;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }
    function get_years_combo($options = array())
    {
        // Default categories name
        if (!isset($options['combo_name']))
        {
            $options['combo_name'] = 'year';
        }
        $class = '';
        if (isset($options['class']))
        {
            $class = 'class="' . $options['class'] . '"';
        }
//        if ( ! isset($options['extra']))
//        {
//            $options['extra'] = '';
//        }

        $data_options = array();
        $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';
        for ($i = $options['from_year']; $i <= $options['to_year']; $i++)
        {
            $data_options[$i] = $i;
        }

        if (!isset($options['year']))
        {
            $options['year'] = $options['to_year'];
        }

        return form_dropdown($options['combo_name'], $data_options, $options['year'], $class);
    }

    function get_months_combo($options = array())
    {
        // Default categories name
        if (!isset($options['combo_name']))
        {
            $options['combo_name'] = 'month';
        }
        $class = '';
        if (isset($options['class']))
        {
            $class = 'class="' . $options['class'] . '"';
        }
//        if ( ! isset($options['extra']))
//        {
//            $options['extra'] = '';
//        }

        $data_options = array();
        $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';
        for ($i = 1; $i <= 12; $i++)
        {
            $data_options[$i] = $i;
        }

        return form_dropdown($options['combo_name'], $data_options, $options['month'], $class);
    }

    function get_days_combo($options = array())
    {
        // Default categories name
        if (!isset($options['combo_name'])) {
            $options['combo_name'] = 'day';
        }
        $class = '';
        if (isset($options['class'])) {
            $class = 'class="' . $options['class'] . '"';
        }

        $data_options = array();
        $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';
        for ($i = 1; $i <= 31; $i++) {
            $data_options[$i] = $i;
        }

        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $class);
    }
       
    function get_lang_combo($options = array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'lang';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }
        
        $data_options       = array();
        if( isset($options['all']) ){
            $data_options['']   = '-- Tất cả --';
        }
        $langs              = language_array();
        foreach($langs as $lang)
        {
            $data_options[$lang['short_lang']] = $lang['lang'];
        }
        if (!isset($options[$options['combo_name']]) || $options[$options['combo_name']] == '')
        {
            if( ! isset($options['all']) )
                $options[$options['combo_name']] = 'vi';
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }
}
?>