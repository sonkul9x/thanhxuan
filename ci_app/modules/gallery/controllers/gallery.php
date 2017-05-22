<?php
class Gallery extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    public function get_projects($options=array())
    {
        $options['status'] = STATUS_ACTIVE;
        $options['limit'] = 12;
        $options['lang'] = $this->_lang;
        $data = $this->gallery_model->get_gallery($options);
        return $data;
    }
    
    public function get_list_gallery_by_cat($para1=NULL, $para2=NULL, $para3=NULL)
    {
        $options = array('cat_id'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);
        $config = get_cache('configurations_' .  $options['lang']);
        $gallery_per_page   = (isset($config['gallery_per_page']) && $config['gallery_per_page'] <> 0) ? $config['gallery_per_page'] : GALLERY_PER_PAGE;
        
        $total_row          = $this->gallery_model->get_gallery_count($options);
        $total_pages        = (int)($total_row / $gallery_per_page);

        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
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
            'per_page'          => $gallery_per_page,
            'uri_segment'       => $uri_segment,
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];

        $galleries = $this->gallery_model->get_gallery($options);

        if($options['cat_id'] <> 0){
            $category = $this->gallery_categories_model->get_gallery_categories(array('id'=>$options['cat_id']));
            $title = ($category->meta_title <> '')?$category->meta_title:$category->category;
            $keywords = ($category->meta_keywords <> '')?$category->meta_keywords:$category->category;
            $description = ($category->meta_description <> '')?$category->meta_description:$category->category;
        }else{
            $title = __('IP_gallery');
            $keywords = __('IP_gallery');
            $description = __('IP_gallery');
        }

        $view_data = array(
            'galleries'      => $galleries,
            'category'      => (!empty($category->category))?$category->category:__('IP_gallery'),
            'category_id'   => (!empty($category->category))?$category->id:0,
            'title'         => $title,
            'keywords'      => $keywords,
            'description'   => $description,
            'current_menu'  => $current_menu,
//            'active_menu'   => PROJECT_URL,
            'lang'          => $options['lang'],
            'scripts'       => $this->scripts_for_gallery(),
        );

        $this->_view_data['main_content'] = $this->load->view('gallery',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_gallery_detail($para1=NULL, $para2=NULL)
    {
        $options = array('id'=>$para1);
        
        $lang = switch_language($para2);
        
        $this->gallery_model->update_gallery_view($options['id']);
        
        $gallery = $this->gallery_model->get_gallery($options);

        $gallery_same = $this->get_gallery_same(array('cat_id'=>$gallery->cat_id,'current_id'=>$options['id'],'limit'=>GALLERY_PER_LIST));
        
        $gallery_images = $this->gallery_images_model->get_gallery_images(array('gallery_id'=>$options['id']));
        
        $gallery_category = $this->gallery_categories_model->get_gallery_categories(array('id'=>$gallery->cat_id));
        if(!empty($gallery_category)){
            $category_slug = isset($gallery_category->slug)?$gallery_category->slug:'';
        }
        
        $view_data = array(
            'gallery'       => $gallery,
            'gallery_images'=> $gallery_images,
            'category'      => $gallery->category,
            'category_slug' => $category_slug,
            'category_id'   => $gallery->cat_id,
            'title'         => ($gallery->meta_title <> '')?$gallery->meta_title:$gallery->gallery_name,
            'keywords'      => ($gallery->meta_keywords <> '')?$gallery->meta_keywords:$gallery->gallery_name,
            'description'   => ($gallery->meta_description <> '')?$gallery->meta_description:$gallery->gallery_name,
            'current_menu'  => '/'.url_title($gallery->gallery_name, 'dash', TRUE) . '-gs' .$gallery->id,
            'scripts'       => $this->scripts_for_gallery_detail(),
            'gallery_same'  => $gallery_same,
            'active_menu'   => '/'.url_title($gallery->category, 'dash', TRUE) . '-g' .$gallery->cat_id,
            'lang'          => $lang,
        );

        $this->_view_data['main_content'] = $this->load->view('gallery_detail',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function list_gallery_images($gallery_id)
    {
        $gallery_images = $this->gallery_images_model->get_gallery_images(array('gallery_id'=>$gallery_id));
        return $gallery_images;
    }
    
    public function get_gallery_same($options=array()){
        $options['status'] = STATUS_ACTIVE;
        $options['random'] = TRUE;
        $options['lang'] = $this->_lang;

        $galleries = $this->gallery_model->get_gallery($options);

        $view_data = array(
            'galleries'  => $galleries,
            'category' => __('IP_projects_other'),
        );

        return $this->_view_data['main_content'] = $this->load->view('gallery_same',$view_data, TRUE);
    }
    
    private function scripts_for_gallery()
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
    
    private function scripts_for_gallery_detail()
    {
        $scripts = '<script type="text/javascript" src="'.base_url().'plugins/html5gallery/html5gallery.js"></script>';
        return $scripts;
    }
    
}