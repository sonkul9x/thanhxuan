<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('url_title'))
{
    function url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        $separator = ($separator == 'dash') ? '-' : '_';
        $str = strip_tags($str);
        $from = array(      '—', 'À', 'Á', 'Ả', 'Ã', 'Ạ', 'Â', 'Ầ', 'Ấ', 'Ẩ', 'Ẫ', 'Ậ', 'Ă', 'Ằ', 'Ắ', 'Ẳ', 'Ẵ', 'Ặ', 'à', 'á', 'ả', 'ã', 'ạ', 'â', 'ầ', 'ấ', 'ẩ', 'ẫ', 'ậ', 'ă', 'ằ', 'ắ', 'ẳ', 'ẵ', 'ặ'
                            , 'È', 'É', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ề', 'Ế', 'Ể', 'Ễ', 'Ệ', 'è', 'é', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ'
                            , 'Ì', 'Í', 'Ỉ', 'Ĩ', 'Ị', 'ì', 'í', 'ỉ', 'ĩ', 'ị'
                            , 'Ò', 'Ó', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ồ', 'Ố', 'Ổ', 'Ỗ', 'Ộ', 'ò', 'ó', 'ỏ', 'õ', 'ọ', 'ô', 'ồ', 'ố', 'ổ', 'ỗ', 'ộ'
                            , 'Ơ', 'Ờ', 'Ớ', 'Ở', 'Ỡ', 'Ợ', 'ơ', 'ờ', 'ớ', 'ở', 'ỡ', 'ợ'
                            , 'Ù', 'Ú', 'Ủ', 'Ũ', 'Ụ', 'ù', 'ú', 'ủ', 'ũ', 'ụ'
                            , 'Ư', 'Ừ', 'Ứ', 'Ử', 'Ữ', 'Ự', 'ư', 'ừ', 'ứ', 'ử', 'ữ', 'ự'
                            , 'Ỳ', 'Ý', 'Ỷ', 'Ỹ', 'Ỵ', 'ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ'
                            , 'Đ', 'đ'
                            , '(', ')', '[', ']', '{', '}', '~', '`', '!', '@'
                            , '#', '$', '%', '^', '&', '*', '-', '_', '+', '='
                            , '|', '\\', ':', ';', '"', '\'', '<', '>', ',', '.'
                            , '/', '?', '“', '”'
                            , '     ', '    ', '   ', '  ', ' '
                    );
        $to =   array(      ' ', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'
                            , 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e'
                            , 'I', 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i', 'i'
                            , 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o'
                            , 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o'
                            , 'U', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'u'
                            , 'U', 'U', 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'u', 'u'
                            , 'Y', 'Y', 'Y', 'Y', 'Y', 'y', 'y', 'y', 'y', 'y'
                            , 'D', 'd'
                            , '', '', '', '', '', '', '', '', '', ''
                            , '', '', '', '', '', '', '', '', '', ''
                            , ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '
                            , ' ', ' ', ' ', ' '
                            , ' ', ' ', ' ', ' ', $separator
                    );
        $str            = trim(str_replace($from, $to, $str));

        // remove disallowed characters
        $pattern        = '/[^A-Za-z 0-9~%.:_\-]/i';
        $replacement    = '';
        $str            = preg_replace($pattern, $replacement, $str);
        
        if ($lowercase === TRUE)
          $str = strtolower($str);
        return $str;
    }
}

if(!function_exists('current_full_url'))
{
    function current_full_url()
    {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}

/* End of file PIXELPLANT_url_helper.php */
/* Location: ./application/helpers/PIXELPLANT_url_helper.php */ 