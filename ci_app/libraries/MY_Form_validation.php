<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Form_validation
 * Form Validation Callback
 * @author duongbq
 */
class MY_Form_validation extends CI_Form_validation
{

    function run($module = '', $group = '') {
        (is_object($module)) AND $this->CI = & $module;
        return parent::run($group);
    }
    /**
     * Match one field to value
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    function matches_value($str, $value)
    {
        return (strtolower($str) !== strtolower($value)) ? FALSE : TRUE;
    }
    // matches_pattern()
    // Ensures a string matches a basic pattern
    // # numeric, ? alphabetical, ~ any character
    function matches_pattern($str, $pattern)
    {
        $characters = array(
            '#', '?', '~', '@' // Our additional characters
            , '$'
            , '%'
        );

        $regex_characters = array(
            '[0-9]', '[a-zA-Z]', '.', '[a-zA-Z0-9\-\_]' // Our additional characters
            , '[\`\!\@\%\^\&\*\#\?\~\&\*\(\)\_\-\+\=\<\>\,\.\'\"\:\;]'
            , '\d+(.\d+){0, 1}'
        );
        $pattern = str_replace($characters, $regex_characters, $pattern);
        if (preg_match('/^' . $pattern . '$/', $str)) return TRUE;
        return FALSE;
    }

    /**
     * Checks date if matches given format and validity of the date.
     * Examples:
     * <code>
     * is_date('22.22.2222', 'mm.dd.yyyy'); // returns FALSE
     * is_date('11/30/2008', 'mm/dd/yyyy'); // returns TRUE
     * is_date('30-01-2008', 'dd-mm-yyyy'); // returns TRUE
     * is_date('2008 01 30', 'yyyy mm dd'); // returns TRUE
     * </code>
     * @param string $value the variable being evaluated.
     * @param string $format Format of the date. Any combination of <i>mm<i>, <i>dd<i>, <i>yyyy<i>
     * with single character separator between.
     */
    function is_date($str)
    {
        if ( !$this->matches_pattern($str, '#{2}-#{2}-#{4}')) return FALSE;

        $arr    = explode('-', $str);
        $day    = $arr[0];
        $month  = $arr[1];
        $year   = $arr[2];

        if(checkdate($month, $day, $year)) return TRUE;

        return FALSE;
    }
    
    function is_not_default_combo($value)
    {
        if($value != DEFAULT_COMBO_VALUE) return TRUE;

        return FALSE;
    }

}

