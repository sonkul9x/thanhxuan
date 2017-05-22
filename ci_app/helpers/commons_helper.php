<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Format giá tiền theo định dạng của VN
 *
 * @author Tuấn Anh
 * @date   2011-05-02
 * @param type $number
 * @param type $currency
 * @param type $show_zero
 * @return type
 */
function get_vndate_string($input) {
    if (empty($input))
        return $input;

    $today = strtotime(date('Ymd H:i:s'));
    if (!is_numeric($input))
        $input = strtotime($input);
    // Nếu tin được đăng trong 3 ngày gần nhất thì hiện màu đỏ
    if (date("Ymd", $input) >= date("Ymd", $today - 60 * 60 * 24 * 2)) {
        if (date("Ymd", $input) == date("Ymd", $today))
            return '<span class="red">' . date("H:i", $input) . '</span>';
        else if (date("Ymd", $input) == date("Ymd", $today - 60 * 60 * 24))
            return '<span class="green">'. __('IP_yesterday') . ' ' . date('H:i', $input) .'</span>';
        else if (date("Ymd", $input) < date("Ymd", $today - 60 * 60 * 24))
            return '<span class="blue">'. __('IP_2_days_ago') . ' ' . date('H:i', $input) .'</span>';
        else
            return '<span style="color:magenta;">' . date("d/m H:i", $input) .'</span>';
    }
    // Nếu tin đăng trong năm hiện tại thì hiện tháng và ngày
    if (date("Y", $input) == date("Y", $today)) {
        return date("d/m H:i", $input);
    }
    // Các năm khác thì hiện đầy đủ
    else {
        return date("d/m/y H:i", $input);
    }
}

function convert_date_to_format_sql($date) {
    $date = str_replace('/', '-', $date);
    $day = date('d', strtotime($date));
    $month = date('m', strtotime($date));
    $year = date('Y', strtotime($date));
    return $year . '-' . $month . '-' . $day;
}

function create_security_captcha($options = array()) {
    if (!isset($options['length']))
        $options['length'] = 3;
    if (!isset($options['width']))
        $options['width'] = 60;
    if (!isset($options['height']))
        $options['height'] = 25;
    if (!isset($options['fontsize']))
        $options['fontsize'] = 15;

    $code = '';
    $charset = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';

    for ($i = 1, $cslen = strlen($charset); $i <= $options['length']; $i++) {
        $code .= $charset{rand(0, $cslen - 1)};
    }

    $img = ImageCreate($options['width'], $options['height']);

    $bg_color = ImageColorAllocate($img, 168, 140, 100);
    $text_color = ImageColorAllocate($img, 0, 0, 0);
    $grid_color = ImageColorAllocate($img, 168, 119, 0);
    // fill the background
    ImageFilledRectangle($img, 0, 0, $options['width'], $options['height'], $bg_color);

    $angle = ($options['length'] >= 6) ? rand(-($options['length'] - 6), ($options['length'] - 6)) : 0;
    $x_axis = rand(6, (360 / $options['length']) - 16);
    $y_axis = ($angle >= 0 ) ? rand($options['height'], $options['width']) : rand(6, $options['height']);
    // create the spiral background
    $theta = 1;
    $thetac = 7;
    $radius = 16;
    $circles = 20;
    $points = 32;

    for ($i = 0; $i < ($circles * $points) - 1; $i++) {
        $theta = $theta + $thetac;
        $rad = $radius * ($i / $points );
        $x = ($rad * cos($theta)) + $x_axis;
        $y = ($rad * sin($theta)) + $y_axis;
        $theta = $theta + $thetac;
        $rad1 = $radius * (($i + 1) / $points);
        $x1 = ($rad1 * cos($theta)) + $x_axis;
        $y1 = ($rad1 * sin($theta)) + $y_axis;
        imageline($img, $x, $y, $x1, $y1, $grid_color);
        $theta = $theta - $thetac;
    }
    // print the text
    $x = 10;
    $y = $options['fontsize'] + 2;

    for ($i = 0; $i < strlen($code); $i++) {
        $y = $options['height'] / 5;
        imagestring($img, $options['fontsize'], $x, $y, substr($code, $i, 1), $text_color);
        $x += ($options['fontsize']);
    }

    $options['context']->phpsession->save('captcha', $code);

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Content-Type: image/jpeg");
    imagejpeg($img, null, 100);
}

function my_trim($string, $trim_all = false) {
    $str = '';
    $str = str_replace('&nbsp;', ' ', $string);

    if ($trim_all) {
        $str = str_replace(' ', '', $str);
        $str = str_replace(')', ') ', $str);
    } else {
        $str = trim($str);
        $str = preg_replace('/(\n+) /', '\1', $str);
        $str = preg_replace('/( )+/', ' ', $str);
    }
    return $str;
}

function remove_new_line($string) {
    $str = str_replace("\n", "&nbsp;", $string);

    return $str;
}

function prepare_pagination($options = array()) {
    $config = array();

    $config['total_rows'] = $options['total_rows'];
    $config['per_page'] = $options['per_page'];
    $config['offset'] = $options['offset'];
    $config['num_links'] = PAGINATION_NUM_LINKS;
    $config['first_link'] = '««';
    $config['prev_link'] = '«';
    $config['next_link'] = '»';
    $config['last_link'] = '»»';
    $config['js_function'] = $options['js_function'];

    return $config;
}

function get_uri_product($product_name = '', $id = 0) {
    $title = $product_name;
//    $today = dechex((int)date('His'));
//    $title .= ' ' . $today . 'i' . $id;
    $title .= ' ' . 'i' . $id;
    $title = url_title($title, 'dash', TRUE);
    return $title;
}


function shorten_str($str, $len, $suffix = '..') {
    if (mb_strlen(trim($str)) > $len)
        $str = mb_substr(trim($str), 0, $len) . $suffix;
    return $str;
}

function genarate_tags($tags = '', $key = '') {
    $str = '';
    $tags = explode(',', $tags);
    foreach ($tags as $tag) {
        $tag_url = str_replace(' ', '+', trim($tag));
        $str .='<a href="/tim-kiem/' . $key . '?q=' . $tag_url . '">' . $tag . '</a>';
    }
    return $str;
}

function get_short_description($input, $postion) {
    if (strlen($input) <= $postion)
        return $input;
    $output = substr($input, 0, $postion);
//    $output = substr($output,0,strrpos($output,' '));
    return $output . '...';
}

function get_date($date = '') {
    $date = str_replace('/', '-', $date);
    if ($date != '' && $date != NULL)
        return date('d/m/Y', strtotime($date));
    else
        return '';
}

function get_unit_from_price($price, $currency = UNIT_VND)
{
    $price_text = '';
    $unit       = '';

    if ($currency==UNIT_VND)
    {
        if ($price >= ONE_BILLION)
        {
            $price_text = number_format($price / ONE_BILLION, 2, ".", "");
            $unit = ONE_BILLION;
        }
        else if ($price >= ONE_MILLION)
        {
            $price_text = number_format($price / ONE_MILLION, 2, ".", "");
            $unit = ONE_MILLION;
        }
        else if ($price >= ONE_THOUSAND)
        {
            $price_text = number_format($price / ONE_THOUSAND, 2, ".", "");
            $unit = ONE_THOUSAND;
        }
        else
        {
            $price_text = 0;
            $unit = ONE_THOUSAND;
        }
    }
    return array('price' => $price_text, 'unit' => $unit);
}

function get_price_in_vnd($number, $currency = UNIT_VND, $show_zero = NOT_SHOW_ZERO)
{
    if ($number > 0)
        $text = number_format($number, 0, ",", ".");
    else
        $text = "Liên hệ";

    if ($currency==UNIT_USD)
    {
        if ($text != "")
            $text = "$" . $text;
    }

    if ($text == "")
        $text = $show_zero ? "0" : "";

    return $text;
}

function get_full_price_in_vnd($number)
{
    if ($number > 0)
        $text = number_format($number, 0, ",", ".");
    else
        $text = 0;

    return $text;
}

if ( ! function_exists('get_language'))
{
    function language_array()
    {
        $lang_array = array(
            array('short_lang' => 'vi', 'full_lang' => 'vietnamese', 'lang' => 'Tiếng Việt'),
            array('short_lang' => 'en', 'full_lang' => 'english', 'lang' => 'Tiếng Anh'),
//            array('short_lang' => 'cn', 'full_lang' => 'chinese', 'lang' => 'Tiếng Trung'),
            );
        return $lang_array;
    }
    
}

function switch_language($param = '')
{
    $langs = language_array();
    foreach($langs as $lang)
    {
        if($lang['short_lang'] == $param)
            return $param;
    }
    return DEFAULT_LANGUAGE;
}

if ( ! function_exists('get_language'))
{
    function get_language($lg = FALSE)
    {
        $CI     = & get_instance();
        $lang   = switch_language($CI->uri->segment(1));
        
        $langs = language_array();
        $lang_array = array();
        foreach($langs as $_lang)
        {
            $lang_array[$_lang['short_lang']] = $_lang['full_lang'];
        }
        $CI->config->set_item('language', $lang_array[$lang]);
        $CI->lang->load('ip', $lang_array[$lang]);
        return $lang;
    }
}

// this function for get text by key in currently language
if ( ! function_exists('__'))
{
    function __($line, $id = '')
    {
            $CI =& get_instance();
            $line = $CI->lang->line($line);
            if ($id != '')
            {
                    $line = '<label for="'.$id.'">'.$line."</label>";
            }
            return $line;
    }
}

// this function for get base url in currently language
if ( ! function_exists('get_base_url'))
{
    function get_base_url($lang = '')
    {
        if($lang == '')
        {
            $CI         = & get_instance();
            $lang       = switch_language($CI->uri->segment(1));
            $base_url   = $lang == DEFAULT_LANGUAGE ? base_url() : base_url() . $lang . '/';
            return $base_url;
        }
        else
        {
            $base_url   = $lang == DEFAULT_LANGUAGE ? base_url() : base_url() . $lang . '/';
            return $base_url;
        }
    }
}


if ( ! function_exists('get_form_submit_by_lang'))
{
    function get_form_submit_by_lang($lang=DEFAULT_LANGUAGE, $form='')
    {
        $array_from     = array(
            'contact_form'          => array('vi' => 'lien-he', 'en' => 'contact', 'cn' => 'contact'),
            'reserve_form'          => array('vi' => 'dat-cho', 'en' => 'reserve', 'cn' => 'reserve'),
            'search_form'           => array('vi' => 'tim-kiem', 'en' => 'search', 'cn' => 'search'),
            'searchform'            => array('vi' => 'timkiem', 'en' => 'searches', 'cn' => 'searches'),
            'login_form'            => array('vi' => 'login', 'en' => 'login', 'cn' => 'login'),
            'forget_password_form'  => array('vi' => 'quen-mat-khau', 'en' => 'forget-password', 'cn' => 'forget-password'),
            );
        $output = get_base_url() . $array_from[$form][$lang];
        return $output;
    }
}

if(!function_exists('get_url_by_lang'))
{
    function get_url_by_lang($lang=DEFAULT_LANGUAGE, $url='')
    {
        $array_from = array(
            'contact'         => array('vi' => 'lien-he', 'en' => 'contact', 'cn' => 'contact'),
            'reserve'         => array('vi' => 'dat-cho', 'en' => 'reserve', 'cn' => 'reserve'),
            'services'        => array('vi' => 'dich-vu', 'en' => 'services', 'cn' => 'services'),
            'download'        => array('vi' => 'download', 'en' => 'download', 'cn' => 'download'),
            'cart'            => array('vi' => 'gio-hang', 'en' => 'shopping-cart', 'cn' => 'shopping-cart'),
            'info-payment'    => array('vi' => 'thong-tin-khach-hang', 'en' => 'info-payment', 'cn' => 'info-payment'),
            'about'           => array('vi' => 'gioi-thieu.html', 'en' => 'about.html'),
            'products'        => array('vi' => 'san-pham', 'en' => 'products', 'cn' => 'products'),
            'products_tags'   => array('vi' => 'tags', 'en' => 'tags', 'cn' => 'tags'),
            'products_hot'    => array('vi' => 'san-pham-tieu-bieu', 'en' => 'hotproducts', 'cn' => 'hotproducts'),
            'projects'        => array('vi' => 'du-an-dien-hinh', 'en' => 'projects', 'cn' => 'projects'),
            'news'            => array('vi' => 'tin-tuc', 'en' => 'news', 'cn' => 'news' ),
            'news_tags'       => array('vi' => 'tag', 'en' => 'tag', 'cn' => 'tag'),
            'faq'             => array('vi' => 'hoi-dap', 'en' => 'faq', 'cn' => 'faq'),
            'faq-tags'        => array('vi' => 'faq-tags', 'en' => 'faq-tags', 'cn' => 'faq-tags'),
            'faq-search'      => array('vi' => 'tim-kiem-hoi-dap', 'en' => 'faq-search', 'cn' => 'faq-search'),
            'faq-send-question' => array('vi' => 'gui-cau-hoi', 'en' => 'send-question', 'cn' => 'send-question'),
            'customers'       => array('vi' => 'khach-hang', 'en' => 'customers', 'cn' => 'customers' ),
            'introduction'    => array('vi' => 'gioi-thieu.htm', 'en' => 'introduction.htm', 'cn' => 'introduction.htm' ),
            'about-us'        => array('vi' => 've-chung-toi.htm', 'en' => 'about-us.htm', 'cn' => 'about-us.htm' ),
            'customers-sign-up' => array('vi' => 'tao-tai-khoan', 'en' => 'sign-up', 'cn' => 'sign-up'),
            'customers-login' => array('vi' => 'dang-nhap-thanh-vien', 'en' => 'customers-login', 'cn' => 'customers-login'),
            'forget-password' => array('vi' => 'quen-mat-khau', 'en' => 'forget-password', 'cn' => 'forget-password'),
            );
        $output = get_base_url() . $array_from[$url][$lang];
        return $output;
    }
}
if(!function_exists('add_tags'))
{
    function add_tags($string = '')
    {
        $CI =& get_instance();
        $CI->load->model('realseo/realseo_model');
        $keywords = $CI->realseo_model->get_array_keywords();

        foreach($keywords as $index => $keyword)
        {
            $string = preg_replace('/'. $keyword[0] .'/i', '{#' . $index . '}', $string);
        }

        foreach($keywords as $index => $keyword)
        {
            $title = $keyword[2] != '' ? $keyword[2] : $keyword[0];
            $string = str_replace('{#' . $index . '}', anchor($keyword[1], $keyword[0], array('title' => $title)), $string);

        }
        return $string;
    }
    
    /*
     * Dungnm
     * lay ten anh tu url (tenanh.jpg)...
     */
    function get_image_name_from_url($url)
    {
        $arr = explode('/', $url);
        return $arr[count($arr)-1];
    }
    
    function cut_domain_from_url($url){
        $dm = get_base_url();
        $output = str_replace($dm, '/', $url);
        return $output;
    }
    
    /*
     * Dungnm
     * $dimension: 800x600
     * $widthorheight: 'w', 'h'
     */
    function get_dimension($dimension, $widthorheight){
        if(isset($dimension) && isset($widthorheight)){
            $arr = explode('x',$dimension);
            if($widthorheight = 'w'){
                return $arr[0];
            }else{
                return $arr[count($arr)-1];
            }
        }else{
            return FALSE;
        }
    }
    
    /*
     * Dungnm
     * limit text no error fonts
     */
    function limit_text($text, $len) {
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out = null;


        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {

                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out.=" " . $word;
        }
        return $out;
    }
    
    /**
     * Dungnm
     * date time picker mm/dd/yyyy hh:mm to array
     * @param type $str
     * @return type
     */
    function datetimepicker_array($str){
        $arr = explode('/', $str);
        $arr2 = explode(' ', $arr[2]);
        //neu khong nhap gio:phut
        if(empty($arr2[1])) $arr2[1] = '00:00';
        $arr3 = explode(':', $arr2[1]);
        $result = array(
            'day' => $arr[1],
            'month' => $arr[0],
            'year' => $arr2[0],
            'hour' => $arr3[0],
            'minute' => $arr3[1],
            'second' => '00',
        );
        return $result;
    }
    
    function convert_time_vn($datetime=array())
    {
        $result = 'Ngày: ' . $datetime['day'] . '/' . $datetime['month'] . '/' . $datetime['year'] . ' - Giờ: ' . $datetime['hour'] . ':' . $datetime['minute'];
        return $result;
    }
    
    /**
     * Dungnm
     * @return type
     */
    function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
    
    /**
     * add dungnm
     */
    if(!function_exists('get_uri_by_lang')) {
    function get_uri_by_lang($lang=DEFAULT_LANGUAGE, $url='') {
        $array_from     = array(
            'cart' => array('vi' => 'gio-hang', 'en' => 'shopping-cart', 'cn' => 'shopping-cart'),
            'products' => array('vi' => 'san-pham', 'en' => 'products', 'cn' => 'products'),
        );
        if($lang <> DEFAULT_LANGUAGE){
            $output = '/' . $lang . '/' . $array_from[$url][$lang];
        }else{
            $output = '/' . $array_from[$url][$lang];
        }
        return $output;
    }
    }
    
    function get_date_by_lang($lang=DEFAULT_LANGUAGE, $date='') {
        $array = array(
            'vi' => date('d-m-Y',strtotime($date)),
            'en' => date('m-d-Y',strtotime($date)),
        );
        return $array[$lang];
    }
    
    function convert_string_vi_to_en($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }
    
    function convert_tags_to_array($tags)
    {
        if(!empty($tags))
        {
            return explode(',', $tags);
        }else{
            return NULL;
        }
    }
    
    /**
     * nmd : Thứ tư, 28/05/2014 - 03:37 Chiều 
     * @return type
     */
    function show_date_vn()
    {
        $day_array = array(
            'Monday' => 'Thứ hai',
            'Tuesday' => 'Thứ ba',
            'Wednesday' => 'Thứ tư',
            'Thursday' => 'Thứ năm',
            'Friday' => 'Thứ sáu',
            'Saturday' => 'Thứ bảy',
            'Sunday' => 'Chủ nhật',
        );
        $day = $day_array[date('l')];

        $hour = date('G');
        if(in_array($hour, array('0','1','2')))
        {
            $apm = 'Khuya';
        }elseif(in_array($hour, array('3','4','5','6','7','8','9','10')))
        {
            $apm = 'Sáng';
        }elseif(in_array($hour, array('11','12','13')))
        {
            $apm = 'Trưa';
        }elseif(in_array($hour, array('14','15','16','17','18')))
        {
            $apm = 'Chiều';
        }elseif(in_array($hour, array('19','20','21','22','23')))
        {
            $apm = 'Tối';
        }else{
            $apm = '';
        }
        //echo string
        echo $day . ', ' . date('d/m/Y - h:i') . ' ' . $apm . ' (GMT +7)';
    }
    
    function slug_character_remove($str='')
    {
        $arr = explode(SLUG_CHARACTER_URL, $str);
        if(!empty($arr)){
            return $arr[0];
        }else{
            return $str;
        }
    }
       
    function auth_users_level_label($int=0)
    {
        $arr = array(
            AUTH_LEVEL_ADMIN => AUTH_LEVEL_ADMIN_LABEL,
            AUTH_LEVEL_USER => AUTH_LEVEL_USER_LABEL,
            AUTH_LEVEL_GUEST => AUTH_LEVEL_GUEST_LABEL,
            0 => 'Chưa phân quyền',
        );
        if($arr[$int]){
            return $arr[$int];
        }else{
            return $arr[0];
        }
    }
    
    function status_show_label($status=0,$status_active_label='Hiển thị',$status_inactive_label='Chờ duyệt')
    {
        $arr = array(
            STATUS_ACTIVE => '<b style="font-size: 11px; color: #52A158">'.$status_active_label.'</b>',
            STATUS_INACTIVE => '<b style="font-size: 11px; color: #E37940">'.$status_inactive_label.'</b>',
        );
        if($arr[$status]){
            return $arr[$status];
        }else{
            return $arr[STATUS_INACTIVE];
        }
    }
    
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
    
    function datetimepicker_array2($str){
        $arr = explode('-', $str);
        $arr2 = explode(' ', $arr[2]);
        //neu khong nhap gio:phut
        if(empty($arr2[1])) $arr2[1] = '00:00';
        $arr3 = explode(':', $arr2[1]);
        $result = array(
            'day' => $arr[0],
            'month' => $arr[1],
            'year' => $arr2[0],
            'hour' => $arr3[0],
            'minute' => $arr3[1],
            'second' => '00',
        );
        return $result;
    }
    
    function fb_comment_box_count($uri)
    {
        $url1=$uri;
        $addr="http://api.facebook.com/restserver.php?method=links.getStats&urls=".$url1;
        $page_source=file_get_contents($addr);
        $page = htmlentities($page_source);
        $like="<commentsbox_count>";
        $like1="</commentsbox_count>";
        $lik=strpos($page,htmlentities($like));
        $lik1=strpos($page,htmlentities($like1));
        $fullcount=strlen($page);
        $a=$fullcount-$lik1;
        $aaa=substr($page,$lik+25,-$a);
        $aaa1=substr($page,605,610);
        return $aaa;
    }
    
//    couponcode
    function createRandomString($string_length, $character_set) {
        $random_string = array();
        for ($i = 1; $i <= $string_length; $i++) {
          $rand_character = $character_set[rand(0, strlen($character_set) - 1)];
          $random_string[] = $rand_character;
        }
        shuffle($random_string);
        return implode('', $random_string);
      }

      function validUniqueString($string_collection, $new_string, $existing_strings='') {
        if (!strlen($string_collection) && !strlen($existing_strings))
          return true;
        $combined_strings = $string_collection . ", " . $existing_strings;
        return (strlen(strpos($combined_strings, $new_string))) ? false : true;
      }

      function createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings = '') {
        $string_collection = '';
        for ($i = 1; $i <= $number_of_strings; $i++) {
          $random_string = createRandomString($string_length, $character_set);
          while (!validUniqueString($string_collection, $random_string, $existing_strings)) {
            $random_string = createRandomString($string_length, $character_set);
          }
          $string_collection .= ( !strlen($string_collection)) ? $random_string : ", " . $random_string;
        }
        return $string_collection;
      }
//      end coupon code
      
}

?>
