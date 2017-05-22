<?php
class Download extends MY_Controller 
{

    function __construct() 
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(

        );
    }
    
    function download_list($para1=NULL, $para2=NULL, $para3=DEFAULT_LANGUAGE)
    {
//        $lang = switch_language($para3);
//        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
//            $uri = '/'.$lang.'/'.$this->uri->segment(2);
//        }else{
//            $uri = '/' . $this->uri->segment(1);
//        }
        
        $options = array('type'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);
        
        $download_per_page = DOWNLOAD_PER_PAGE;
        
        $total_row          = $this->download_model->get_download_count($options);
        $total_pages        = (int)($total_row / $download_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);
            $uri_segment = 3;
            if($options['type'] > 0){
                $current_menu = '/' . $this->uri->segment(2);
            }else{
                $current_menu = '/' . $options['lang'] . '/' . $this->uri->segment(2);
            }
        }else{
            $base_url = site_url().$this->uri->segment(1);
            $uri_segment = 2;
            $current_menu = '/' . $this->uri->segment(1);
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $download_per_page,
            'uri_segment'       => $uri_segment,
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        $downloads = $this->download_model->get_download($options);

        if($options['type'] <> 0){
            $_category = $this->download_categories_model->get_download_categories(array('id'=>$options['type']));
            $category = $_category->title;
            if(SLUG_ACTIVE==0){
                $categories_combobox_uri = '/'.url_title($category, 'dash', TRUE) . '-d' .$options['type'];
            }else{
                $categories_combobox_uri = '/'.$_category->slug;
            }
        }else{
            $category = __('IP_download_title');
            $categories_combobox_uri = '/download';
        }
        
        $categories_combobox = $this->download_categories_model->get_download_categories_combo_url(array('categories_combobox' => $categories_combobox_uri, 'lang' => $options['lang'], 'extra' => 'class="btn" onchange="change_download();"'));

        $view_data = array(
            'downloads'     => $downloads,
            'category'      => $category,
            'title'         => __('IP_download_title'),
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $current_menu,
            'active_menu'   => __('IP_download_title'),
            'type'          => $options['type'],
            'categories_combobox' => $categories_combobox,
        );
        
//        if(isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning']))
//                $view_data['options'] = $view_data;
   
        $this->_view_data['main_content'] = $this->load->view('download',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function download_file($id=NULL)
    {
        if(empty($id)) return FALSE;
        $file = $this->download_model->get_download(array('id'=>$id));
        if(isset($file) && !empty($file))
        {
            $data = file_get_contents($file->url);
            $name = $file->name;
            //use this function to force the session/browser to download the file uploaded by the user 
            force_download($name, $data);
        }else
        {
            return FALSE;
        }
    }

}
