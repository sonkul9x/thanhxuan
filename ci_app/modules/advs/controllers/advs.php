<?php

class Advs extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
  
    public function get_advs_slide_show($options=array())
    {
        $view_data = array();
        if(!isset($options['type'])){
            $this->load->library('Mobile_Detect');
            $detect = new Mobile_Detect();
            if($detect->isMobile() && !$detect->isTablet()){
                $options['type'] = 2;
            }
            else {
                $options['type'] = 1;
            }
        }
        $options['status'] = STATUS_ACTIVE;
        $options['lang'] = $this->_lang;
        $options['timelimited'] = TRUE;
        
        $view_data['advs'] = $this->advs_model->get_advs($options);
        
        if(count($view_data['advs']) == 0)
        {
            $options['lang'] = 'vi';
            $view_data['advs'] = $this->advs_model->get_advs($options);
        }
        
        if($options['type'] > 2){
            return $view_data['advs'];
        }else{
            return $this->load->view('slideshow', $view_data, TRUE);
        }
    }
    
    public function get_services()
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'type' => 3,
            'timelimited' => TRUE,
//            'limit' => 12,
        );
        $services = $this->advs_model->get_advs($options);
        if(count($services) == 0)
        {
            $options['lang'] = 'vi';
            $services = $this->advs_model->get_advs($options);
        }
        return $services;
    }
    
    public function get_services_page($para1=NULL,$para2=NULL)
    {
        $options = array(
            'type' => 3,
            'page' => $para1,
            'lang' => switch_language($para2),
            'status' => STATUS_ACTIVE,
        );
        
        $services_per_page = 12;
        $total_row         = $this->advs_model->count_advs($options);
        $total_pages       = (int)($total_row / $services_per_page);

        $base_url = site_url().$this->uri->segment(1);
        $uri_segment = 2;
        $current_menu = '/' . $this->uri->segment(1);
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $services_per_page,
            'uri_segment'       => $uri_segment,
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];

        $services = $this->advs_model->get_advs($options);
        
        $view_data = array(
            'services'      => $services,
            'category'      => __('IP_home_services'),
            'title'         => __('IP_home_services'),
            'keywords'      => __('IP_home_services'),
            'description'   => __('IP_home_services'),
            'current_menu'  => $current_menu,
            'active_menu'   => NULL,
            'lang'          => $options['lang'],
        );
        
        $this->_view_data['main_content'] = $this->load->view('services',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
        
    }
    
    public function get_advs_by_type($type)
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'type' => $type,
            'timelimited' => TRUE,
            'onehit' => TRUE,
        );
        $advs = $this->advs_model->get_advs($options);
        if(count($advs) == 0)
        {
            $options['lang'] = 'vi';
            $advs = $this->advs_model->get_advs($options);
        }
        return $advs;
    }
}
?>