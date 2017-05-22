<?php
class Videos extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    public function get_list_videos($options=array())
    {
        $options['status'] = STATUS_ACTIVE;
        $options['limit'] = 10;
        $video = $this->videos_model->get_videos($options);
        return $video;
    }
    
    public function get_lastest_video()
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'limit' => 1,
            'onehit' => TRUE,
        );
        $video = $this->videos_model->get_videos($options);
        return $video;
    }
    
    public function get_list_videos_by_cat($para1=NULL, $para2=NULL, $para3=NULL)
    {
        $options = array('cat_id'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $videos_per_page   = (isset($config['videos_per_page']) && $config['videos_per_page'] <> 0) ? $config['videos_per_page'] : VIDEOS_PER_PAGE;
        
        $total_row          = $this->videos_model->get_videos_count($options);
        $total_pages        = (int)($total_row / $videos_per_page);

        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
            $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);
            $uri_segment = 3;
            if($options['cat_id'] > 0){
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
            'per_page'          => $videos_per_page,
            'uri_segment'       => $uri_segment,
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];

        $videos = $this->videos_model->get_videos($options);

        if($options['cat_id'] <> 0){
            $category = $this->videos_categories_model->get_videos_categories(array('id'=>$options['cat_id']));
            $title = ($category->meta_title <> '')?$category->meta_title:$category->category;
            $keywords = ($category->meta_keywords <> '')?$category->meta_keywords:$category->category;
            $description = ($category->meta_description <> '')?$category->meta_description:$category->category;
        }else{
            $title = 'Videos';
            $keywords = 'Videos';
            $description = 'Videos';
        }

        $view_data = array(
            'videos'        => $videos,
            'category'      => (!empty($category->category))?$category->category:'Videos',
            'category_id'   => (!empty($category->category))?$category->id:0,
            'title'         => $title,
            'keywords'      => $keywords,
            'description'   => $description,
            'current_menu'  => $current_menu,
            'lang'          => $options['lang'],
            'scripts'       => $this->scripts_for_videos(),
        );

        $this->_view_data['main_content'] = $this->load->view('videos',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_videos_detail($para1=NULL, $para2=NULL)
    {
        $options = array('id'=>$para1);
        
        $lang = switch_language($para2);
        
        $this->videos_model->update_videos_view($options['id']);
        
        $videos = $this->videos_model->get_videos($options);

        $videos_same = $this->get_videos_same(array('cat_id'=>$videos->cat_id,'current_id'=>$options['id'],'limit'=>VIDEOS_PER_LIST));
        
        $videos_items = $this->videos_items_model->get_videos_items(array('video_id'=>$options['id']));

        $videos_category = $this->videos_categories_model->get_videos_categories(array('id'=>$videos->cat_id));
        if(!empty($videos_category)){
            $category_slug = isset($videos_category->slug)?$videos_category->slug:'';
        }
        
        $view_data = array(
            'videos'        => $videos,
            'videos_items'  => $videos_items,
            'category'      => $videos->category,
            'category_slug' => $category_slug,
            'category_id'   => $videos->cat_id,
            'title'         => ($videos->meta_title <> '')?$videos->meta_title:$videos->title,
            'keywords'      => ($videos->meta_keywords <> '')?$videos->meta_keywords:$videos->title,
            'description'   => ($videos->meta_description <> '')?$videos->meta_description:$videos->title,
            'current_menu'  => '/'.url_title($videos->title, 'dash', TRUE) . '-vs' .$videos->id,
            'videos_same'   => $videos_same,
            'active_menu'   => '/'.url_title($videos->category, 'dash', TRUE) . '-v' .$videos->cat_id,
            'lang'          => $lang,
        );

        $this->_view_data['main_content'] = $this->load->view('videos_detail',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function list_videos_items($video_id)
    {
        $videos_items = $this->videos_items_model->get_videos_items(array('video_id'=>$video_id));
        return $videos_items;
    }
    
    public function get_videos_same($options=array()){
        $options['status'] = STATUS_ACTIVE;
        $options['lang'] = $this->_lang;
        $videos = $this->videos_model->get_videos($options);

        $view_data = array(
            'videos'  => $videos,
            'category' => 'Videos khác',
        );

        return $this->_view_data['main_content'] = $this->load->view('videos_same',$view_data, TRUE);
    }
    
    private function scripts_for_videos()
    {
        $scripts = '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.1.5"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.1.5" media="screen" />';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.1.5"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.1.5" media="screen" />';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-media.js?v=2.1.5"></script>';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/lib/jquery.mousewheel-3.0.6.pack"></script>';
        
        return $scripts;
    }
    
}