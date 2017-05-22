<?php

class Configurations_Admin extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = CONFIGURATIONS_ADMIN_BASE_URL;
    }
    
    public function config($para1=DEFAULT_LANGUAGE)
    {
        $options = array('lang'=>switch_language($para1));
        
        $this->phpsession->save('config_lang', $options['lang']);
        
        if ($this->is_postback())
        {
            if($this->_do_config())
                $options['succeed'] = $this->_last_message; //'<p>Lưu lại thành công</p>'; //
            else
                $options['error'] = $this->_last_message; //'<p>Lưu lại thất bại</p>'; //
        }
        
        $view_data  = array();
        
        $view_data  = $this->_get_form_config($options);
        
        $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu không thành công';
        
        if (isset($options['error']) || isset($options['succeed']))
            $view_data['options'] = $options;

        $this->_view_data['main_content'] = $this->load->view('admin/configurations_form',$view_data, TRUE);
        
        $this->_view_data['title'] = 'Thiết lập hệ thống' . DEFAULT_TITLE_SUFFIX;

        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_form_config($options=array())
    {
        $config = $this->configurations_model->get_configuration($options);
        if(!$this->is_postback())
        {
            $contact_email            = $config->contact_email;
            $order_email              = $config->order_email;
            $meta_title               = $config->meta_title;
            $meta_description         = $config->meta_description;
            $meta_keywords            = $config->meta_keywords;
            $news_per_page            = $config->news_per_page;
            $products_per_page        = $config->products_per_page;
            $products_side_per_page   = $config->products_side_per_page;
            $number_products_per_home = $config->number_products_per_home;
            $number_news_per_side     = $config->number_news_per_side;
            $number_news_per_home     = $config->number_news_per_home;
            $google_tracker           = $config->google_tracker;
            $webmaster_tracker        = $config->webmaster_tracker;
            $order_email_content      = $config->order_email_content;
            $footer_contact           = $config->footer_contact;
            $pay_bank                 = $config->pay_bank;
            $pay_people               = $config->pay_people;
            $pay_info                 = $config->pay_info;
            $success_order            = $config->success_order;
            $company_infomation       = $config->company_infomation;
            $contact_infomation       = $config->contact_infomation;
            $google_map_code          = $config->google_map_code;
            $telephone                = $config->telephone;
            $logo                     = $config->logo;
            $favicon                  = $config->favicon;
            $facebook_id              = $config->facebook_id;
            $livechat                 = $config->livechat;
            $number_products_per_side = $config->number_products_per_side;
            $slogan                   = $config->slogan;
        }
        else
        {
            $contact_email          = $this->input->post('contact_email', TRUE);
            $order_email            = $this->input->post('order_email', TRUE);
            $meta_title             = $this->input->post('meta_title', TRUE);
            $meta_description       = $this->input->post('meta_description', TRUE);
            $meta_keywords          = $this->input->post('meta_keywords', TRUE);
            $news_per_page          = $this->input->post('news_per_page', TRUE);
            $products_per_page      = $this->input->post('products_per_page', TRUE);
            $products_side_per_page = $this->input->post('products_side_per_page', TRUE);
            $number_products_per_home = $this->input->post('number_products_per_home', TRUE);
            $number_news_per_side   = $this->input->post('number_news_per_side', TRUE);
            $number_news_per_home   = $this->input->post('number_news_per_home', TRUE);
            $google_tracker         = $this->input->post('google_tracker');
            $webmaster_tracker      = $this->input->post('webmaster_tracker');
            $order_email_content    = $this->input->post('order_email_content');
            $footer_contact         = $this->input->post('footer_contact');
            $pay_bank               = $this->input->post('pay_bank');
            $pay_people             = $this->input->post('pay_people');
            $pay_info               = $this->input->post('pay_info');
            $success_order          = $this->input->post('success_order');
            $company_infomation     = $this->input->post('company_infomation');
            $contact_infomation     = $this->input->post('contact_infomation');
            $google_map_code        = $this->input->post('google_map_code');
            $telephone              = $this->input->post('telephone');
            $logo                   = $this->input->post('logo');
            $favicon                = $this->input->post('favicon');
            $facebook_id            = $this->input->post('facebook_id');
            $livechat               = $this->input->post('livechat');
            $number_products_per_side = $this->input->post('number_products_per_side');
            $slogan                   = $this->input->post('slogan');
        }
        $view_data = array(
            'contact_email' => $contact_email,
            'order_email' => $order_email,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'news_per_page' => $news_per_page,
            'products_per_page' => $products_per_page,
            'products_side_per_page' => $products_side_per_page,
            'number_products_per_home' => $number_products_per_home,
            'number_news_per_side' => $number_news_per_side,
            'number_news_per_home' => $number_news_per_home,
            'google_tracker' => $google_tracker,
            'webmaster_tracker' => $webmaster_tracker,
            'order_email_content' => $order_email_content,
            'footer_contact' => $footer_contact,
            'pay_bank'               => $pay_bank,
            'pay_people'             => $pay_people,
            'pay_info'               => $pay_info,
            'success_order'          => $success_order,
            'company_infomation' => $company_infomation,
            'contact_infomation' => $contact_infomation,
            'google_map_code' => $google_map_code,
            'telephone' => $telephone,
            'logo' => $logo,
            'favicon' => $favicon,
            'facebook_id' => $facebook_id,
            'livechat' => $livechat,
            'number_products_per_side' => $number_products_per_side,
            'slogan' => $slogan,
            'scripts' => $this->_get_scripts(),
            'submit_uri' => CONFIGURATIONS_ADMIN_BASE_URL . '/' . $options['lang'],
        );
        return $view_data;
    }
    
    private function _do_config()
    {
        $lang = $this->phpsession->get("config_lang");
        if (empty($lang)) {
            $lang = DEFAULT_LANGUAGE;
        }
        //LOGO
        $rs = $this->upload_images_logo($lang);
        if($rs == FALSE || !isset($rs['image_name']) || !isset($rs['image_dimension'])){
            $image_name_logo = '';
        }else{
            $image_name_logo = $rs['image_name'];
        }
        //BACKGROUND
        $rs2 = $this->upload_images_favicon($lang);
        if($rs2 == FALSE || !isset($rs2['image_name']) || !isset($rs2['image_dimension'])){
            $image_name_favicon = '';
        }else{
            $image_name_favicon = $rs2['image_name'];
        }

        $data = array(
//            'id'                        => 1,
            'contact_email'             => $this->input->post('contact_email', TRUE),
            'order_email'               => $this->input->post('order_email', TRUE),
            'meta_title'                => my_trim($this->input->post('meta_title', TRUE)),
            'meta_description'          => my_trim($this->input->post('meta_description', TRUE)),
            'meta_keywords'             => my_trim($this->input->post('meta_keywords', TRUE)),
            'products_per_page'         => my_trim($this->input->post('products_per_page', TRUE)),
            'products_side_per_page'    => my_trim($this->input->post('products_side_per_page', TRUE)),
            'number_products_per_home'  => my_trim($this->input->post('number_products_per_home', TRUE)),
            'number_news_per_side'      => my_trim($this->input->post('number_news_per_side', TRUE)),
            'news_per_page'             => my_trim($this->input->post('news_per_page', TRUE)),
            'number_news_per_home'      => my_trim($this->input->post('number_news_per_home', TRUE)),
            'google_tracker'            => $this->input->post('google_tracker'),
            'webmaster_tracker'         => $this->input->post('webmaster_tracker'),
            'order_email_content'       => $this->input->post('order_email_content'),
            'footer_contact'            => $this->input->post('footer_contact'),
            'pay_bank'               => $this->input->post('pay_bank'),
            'pay_people'             => $this->input->post('pay_people'),
            'pay_info'               => $this->input->post('pay_info'),
            'success_order'               => $this->input->post('success_order'),
            'company_infomation'        => $this->input->post('company_infomation'),
            'contact_infomation'        => $this->input->post('contact_infomation'),
            'google_map_code'           => my_trim($this->input->post('google_map_code')),
            'telephone'                 => my_trim($this->input->post('telephone')),
            'facebook_id'               => my_trim($this->input->post('facebook_id')),
            'livechat'                  => my_trim($this->input->post('livechat')),
            'number_products_per_side'  => $this->input->post('number_products_per_side'),
            'slogan'                    => my_trim($this->input->post('slogan')),
            'editor'                    => $this->phpsession->get('user_id'),
            );
        
        if($image_name_logo <> ''){
            $data['logo'] = $image_name_logo;
        }
        if($image_name_favicon <> ''){
            $data['favicon'] = $image_name_favicon;
        }
        
        $this->configurations_model->update($data,array('lang'=>$lang));
        $this->_last_message = '<p>Lưu lại thành công</p>';
        
        $this->save_cache();

    }

    private function upload_images_logo($lang = DEFAULT_LANGUAGE)
    {
        if(isset($_FILES['userfile'])){
            $image_path = UPLOAD_PATH_LOGO;
            $rs = $this->configurations_model->upload_logo($image_path,$lang);
            return $rs;
        }else return FALSE;
    }
    
    public function delete_images_logo($lang = DEFAULT_LANGUAGE)
    {
        if($lang<>''){
            $image_path = UPLOAD_PATH_LOGO;
            $this->configurations_model->delete_logo($lang, $image_path);
            $this->configurations_model->update(array('logo'=>''),array('lang'=>$lang));
        }
        return $this->save_cache();
    }

    private function upload_images_favicon($lang = DEFAULT_LANGUAGE)
    {
        if(isset($_FILES['userfile2'])){
            $image_path = UPLOAD_PATH_FAVICON;
            $rs = $this->configurations_model->upload_favicon($image_path,$lang);
            return $rs;
        }else return FALSE;
    }
    
    public function delete_images_favicon($lang = DEFAULT_LANGUAGE)
    {
        if($lang<>''){
            $image_path = UPLOAD_PATH_FAVICON;
            $this->configurations_model->delete_favicon($lang, $image_path);
            $this->configurations_model->update(array('favicon'=>''),array('lang'=>$lang));
        }
        return $this->save_cache();
    }
    
    function save_cache($options = array())
    {
        $lang = $this->phpsession->get("config_lang");
        if(empty($lang)) $cache_lang = '';
        elseif($lang == 'vi') $cache_lang = '_vi';
        else $cache_lang = '_' . $lang;
        
        if(empty($lang) || $lang == 'vi'){
            $redirect_lang = '';
        }else{
            $redirect_lang = '/'.$lang.'/';
        }
        
        if(save_cache('configurations' . $cache_lang))
            redirect('/dashboard/system_config'.$redirect_lang.'?save_cache=success');
        else
            redirect('/dashboard/system_config'.$redirect_lang.'?save_cache=error');
    }
    
//    private function _get_tiny_mce_scripts()
//    {
//        $scripts                     = '<script type="text/javascript" src="/plugins/tiny_mce/tiny_mce.js?v=20111006"></script>';
//        $scripts                    .= '<script language="javascript" type="text/javascript" src="/plugins/tiny_mce/plugins/imagemanager/js/mcimagemanager.js?v=20111006"></script>';
//        $scripts                    .= '<script type="text/javascript">enable_advanced_wysiwyg("wysiwyg");</script>';
//        return $scripts;
//    }
    
    private function _get_scripts()
    {
        $scripts = '<script type="text/javascript" src="/plugins/tinymce/tinymce.min.js?v=4.1.7"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="/plugins/fancybox/source/jquery.fancybox.css" media="screen" />';
        $scripts .= '<script type="text/javascript" src="/plugins/fancybox/source/jquery.fancybox.pack.js"></script>';
        $scripts .= '<script type="text/javascript">$(".iframe-btn").fancybox({"width":900,"height":500,"type":"iframe","autoScale":false});</script>';
        $scripts .= '<style type=text/css>.fancybox-inner {height:500px !important;}</style>';
        $scripts .= '<script type="text/javascript">enable_tiny_mce();</script>';
        return $scripts;
    }
}

?>
