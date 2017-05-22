<?php
class Videos_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
//        modules::run('auth/auth/validate_permission', array('operation' => OPERATION_MANAGE));
        modules::run('auth/auth/validate_login');
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = VIDEOS_ADMIN_BASE_URL;
    }
    
    function browse($para1='vi', $para2=1)
    {
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_prepare_search($options));
        $this->phpsession->save('videos_lang', $options['lang']);
        
        $options['is_admin']    = TRUE;

        $total_row              = $this->videos_model->get_videos_count($options);
        $total_pages            = (int)($total_row / VIDEOS_ADMIN_PER_PAGE);
        if ($total_pages * VIDEOS_ADMIN_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * VIDEOS_ADMIN_PER_PAGE;
        $options['limit']   = VIDEOS_ADMIN_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $options['page_links']    = $this->pagination->create_ajax_links();
        $options['videos']     = $this->videos_model->get_videos($options);
        $options['total_rows']    = $total_row;
        $options['total_pages']   = $total_pages;
        $options['page']          = $options['page'];
        $options['title']  = isset($options['title']) ? $options['title'] : FALSE;
        
        $options['filter']        = $options['filter'];
        
        if($options['lang'] <> 'vi'){
            $options['uri'] = VIDEOS_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = VIDEOS_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/videos_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý videos' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _prepare_search($options = array())
    {
        $view_data = array();
        // nếu submit
        if($this->is_postback())
        {
            $this->phpsession->save('title_search', $this->db->escape_str($this->input->post('title')));
            $view_data['search'] = $this->phpsession->get('title_search');
            $this->phpsession->save('categories_search_id', $this->input->post('categories_id'));
            $view_data['categories_combo'] = $this->videos_categories_model->get_videos_categories_combo(array('combo_name' => 'categories_id', 'categories_id' =>$this->input->post('categories_id'), 'lang' => $options['lang'], 'extra' => 'class="btn" style="max-width: 25%;"'));
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $view_data['search'] = $this->phpsession->get('title_search');
            if(!($this->phpsession->get('categories_search_id'))) $this->phpsession->save('categories_search_id', DEFAULT_COMBO_VALUE);
            $view_data['categories_combo'] = $this->videos_categories_model->get_videos_categories_combo(array('combo_name' => 'categories_id', 'categories_id' => $this->phpsession->get('categories_search_id'), 'lang' => $options['lang'], 'extra' => 'class="btn" style="max-width: 25%;"'));

        }
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        $options['keyword']                 = $this->phpsession->get('title_search');
        $options['cat_id']                  = $this->phpsession->get('categories_search_id');
        $options['filter']                  = $this->load->view('admin/search_videos_form', $view_data, TRUE);
        return $options;
    }
    
    function add()
    {
        $options = array();
        $this->form_validation->set_rules('title', 'Tên videos', 'trim|required|xss_clean|max_length[255]');
        if ($this->form_validation->run())
        {
            $data = array(
                'title'  => $this->input->post('title'),
                'status'        => STATUS_ACTIVE,
                'create_time'   => now(),
                'update_time'   => now(),
                'lang'          => $this->phpsession->get("videos_lang"),
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
                );
            $position_add = $this->videos_model->position_to_add_videos(array('lang'=>$data['lang']));
            $data['position'] = $position_add;
            $video_id = $this->videos_model->insert($data);
            return $this->edit(array('id'=>$video_id));
        } else {
            $options['error'] = validation_errors();
            $options['header'] = 'Thêm videos';
            
            if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
                $options['options'] = $options;
            
            // Chuan bi du lieu chinh de hien thi
            $this->_view_data['main_content'] = $this->load->view('admin/add_videos_form', $options, TRUE);
            // Chuan bi cac the META
            $this->_view_data['title'] = 'Thêm videos' . DEFAULT_TITLE_SUFFIX;
            // Tra lai view du lieu cho nguoi su dung
            $this->load->view($this->_layout, $this->_view_data);
        }
        return FALSE;
    }
    
    function edit($options = array())
    {
        $this->output->link_js('/powercms/scripts/uploadify/jquery.uploadify-3.1.min.js');
        $this->output->link_js('/powercms/scripts/jquery/ui.sortable.js');
        $this->output->javascripts('uploadify();');
        $this->output->javascripts('setup_moveable();');
        $this->output->javascripts('set_hover_img();');
                
        if(!$this->is_postback()) redirect(VIDEOS_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        
        if(!isset($options['id'])){
            $options['id'] = NULL;
        }

        $options += $this->_get_edit_form_data(array('id'=>$options['id']));

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/edit_videos_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa videos' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_edit_form_data($options = array())
    {   
        if(isset($options['id']))
            $video_id = $options['id'];
        else $video_id = $this->input->post('id');
        
        $view_data = array();

        // Get from DB
        if($this->input->post('from_list'))
        {
            $videos                       = $this->videos_model->get_videos(array('id' => $video_id, 'is_admin' => TRUE));
            if(!is_object($videos)) show_404();
            $view_data['title']      = $videos->title;
            if(SLUG_ACTIVE>0){
                $view_data['slug'] = slug_character_remove($videos->slug);
            }
            $view_data['summary']           = $videos->summary;
            $view_data['categories']        = $this->videos_categories_model->get_videos_categories_combo(array('categories_combobox' => $videos->cat_id, 'lang' => $videos->lang, 'extra' => 'class="btn"'));
            $view_data['meta_title']        = $videos->meta_title;
            $view_data['meta_keywords']     = $videos->meta_keywords;
            $view_data['meta_description']  = $videos->meta_description;
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $videos->lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));

        }
        // Get from submit
        else
        {
            $view_data['title']      = $this->input->post('title', TRUE);
            if(SLUG_ACTIVE>0){
                $view_data['slug'] = my_trim($this->input->post('slug', TRUE));
            }
            $view_data['summary']           = '';
            $view_data['categories']        = $this->videos_categories_model->get_videos_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox'), 'lang' => $this->input->post('lang'), 'extra' => 'class="btn"'));
            $view_data['meta_title']        = $this->input->post('meta_title', TRUE);
            $view_data['meta_keywords']     = $this->input->post('meta_keywords', TRUE);
            $view_data['meta_description']  = $this->input->post('meta_description', TRUE);
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        }
        $view_data['video_id']            = $video_id;
        $this->phpsession->save('video_id', $video_id);
        //$view_data['uri']           = VIDEOS_ADMIN_EDIT_URL;
        $view_data['submit_uri']    = VIDEOS_ADMIN_EDIT_URL;
        $view_data['header']        = 'Sửa videos';
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['items']        = $this->get_videos_item();
//        $view_data['scripts']       = $this->_get_scripts();
        return $view_data;
    }
    
    private function _do_edit()
    {
        $this->form_validation->set_rules('title', 'Tên videos', 'trim|required|max_length[255]|xss_clean');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('categories_combobox', 'Phân loại videos', 'required|is_not_default_combo');
        $this->form_validation->set_rules('summary', 'Mô tả ngắn', 'trim|xss_clean|min_length[10]|max_length[500]');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim|xss_clean');

        if ($this->form_validation->run($this))
        {
            $videos_data       = array(
                'id'            => $this->input->post('id'),
                'title'         => strip_tags($this->input->post('title', TRUE)),
                'update_time'   => now(),
                'summary'       => $this->input->post('summary', TRUE),
                'cat_id'        => $this->input->post('categories_combobox', TRUE),
                'meta_title'    => $this->input->post('meta_title', TRUE),
                'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                'meta_description'=> $this->input->post('meta_description', TRUE),
                'lang'          => $this->input->post('lang', TRUE),
                'editor'        => $this->phpsession->get('user_id'),
            );
            $position_edit = $this->videos_model->position_to_edit_videos(array('lang'=>$videos_data['lang'],'id'=>$this->input->post('id')));
            $videos_data['position'] = $position_edit;
            $this->videos_model->update($videos_data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_VIDEOS,'type_id'=>$videos_data['id']));
            }
            redirect(VIDEOS_ADMIN_BASE_URL);
        }
        $this->_last_message = validation_errors();
        return FALSE;        
    }
    
    public function get_videos_item()
    {
        $options['video_id'] = $this->phpsession->get('video_id');
        $items = $this->videos_items_model->get_videos_items($options);
        $view_data = array();
        $view_data['items'] = $items;
        if($this->input->post('is-ajax'))
            echo $this->load->view('admin/videos_items', $view_data, TRUE);
        else
            return $this->load->view('admin/videos_items', $view_data, TRUE);
    }
    
    public function add_videos_item()
    {
        $url = my_trim($this->input->post('url'));
        $video_id = my_trim($this->phpsession->get('video_id'));
        $youtube_id = my_trim($this->input->post('youtube_id'));
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/0.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/1.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/2.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/3.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/default.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/hqdefault.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/mqdefault.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/sddefault.jpg
//        http://img.youtube.com/vi/<insert-youtube-video-id-here>/maxresdefault.jpg
//        
//        http://i.ytimg.com/vi/<insert-youtube-video-id-here>/mqdefault.jpg";
        
        $item = $this->videos_items_model->get_videos_items(array('video_id' => $video_id, 'last_row' => TRUE));
        $position = (isset($item->position)) ? $item->position + 1 : 1;
        
        $data = array(
            'url' => $url,
            'image_name' => 'http://img.youtube.com/vi/' . $youtube_id . '/0.jpg',
            'youtube_video_id' => $youtube_id,
            'summary' => '',
            'content' => '',
            'position' => $position,
            'video_id' => $video_id,
            'caption' => '',
            'create_time' => now(),
            'update_time' => now(),
            'status' => STATUS_ACTIVE,
        );
        $this->videos_items_model->insert($data);
        return $this->get_videos_item();
    }
 
    public function sort_videos_item()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->where('video_id', $this->phpsession->get('video_id'));
            $this->db->update('videos_items', $array);
            $i = $i + 1;
        }
    }

    public function delete_videos_item()
    {
        if($this->input->post('is-ajax')){
            $id = $this->input->post('id');
            $this->videos_items_model->delete($id);
            echo $this->get_videos_item();
        }else{
            echo $this->get_videos_item();
        }
    }
    
    function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $video_id = $this->input->post('id');
            if(SLUG_ACTIVE>0){
                $check_slug = $this->slug_model->get_slug(array('type_id'=>$video_id,'type'=>SLUG_TYPE_VIDEOS,'onehit'=>TRUE));
                if(!empty($check_slug)){
                    $this->slug_model->delete($check_slug->id);
                }
            }
            $this->videos_items_model->delete(array('video_id'=>$video_id));
            $this->videos_model->delete($video_id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get("videos_lang");
        redirect(VIDEOS_ADMIN_BASE_URL . '/' . $lang);
    }
    
//    public function up()
//    {
//        $video_id = $this->input->post('id');
//        $this->videos_model->update(array('id'=>$video_id,'update_time'=>now()));
//        $lang = $this->phpsession->get("videos_lang");
//        redirect(VIDEOS_ADMIN_BASE_URL . '/' . $lang);
//    }
    
    public function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('videos_lang');
        $this->videos_model->item_to_sort_videos(array('id' => $id));
        redirect(VIDEOS_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $videos = $this->videos_model->get_videos(array('id' => $id, 'is_admin' => TRUE));
        $status = $videos->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->videos_model->update(array('id'=>$id,'status'=>$status));
    }
    
    function add_caption_videos_item()
    {
        $id = $this->input->post('id', TRUE);
        $caption = $this->input->post('caption', TRUE);
        $this->videos_items_model->update(array('id'=>$id,'caption'=>$caption,'update_time'=>now()));
    }

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