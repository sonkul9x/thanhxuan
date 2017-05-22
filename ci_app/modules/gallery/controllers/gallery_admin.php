<?php
class Gallery_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = GALLERY_ADMIN_BASE_URL;
    }
    
    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_prepare_search($options));
        $this->phpsession->save('gallery_lang', $options['lang']);
        
        $options['is_admin']    = TRUE;

        $total_row              = $this->gallery_model->get_gallery_count($options);
        $total_pages            = (int)($total_row / GALLERY_ADMIN_PER_PAGE);
        if ($total_pages * GALLERY_ADMIN_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * GALLERY_ADMIN_PER_PAGE;
        $options['limit']   = GALLERY_ADMIN_PER_PAGE;

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
        $options['galleries']     = $this->gallery_model->get_gallery($options);
        $options['total_rows']    = $total_row;
        $options['total_pages']   = $total_pages;
        $options['page']          = $options['page'];
        $options['gallery_name']  = isset($options['gallery_name']) ? $options['gallery_name'] : FALSE;

        $options['filter']        = $options['filter'];
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = GALLERY_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = GALLERY_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/gallery_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý bộ sưu tập ảnh' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _prepare_search($options = array())
    {
        $view_data = array();
        // nếu submit
        if($this->is_postback())
        {
            $this->phpsession->save('gallery_name_search', $this->db->escape_str($this->input->post('gallery_name')));
            $view_data['search'] = $this->phpsession->get('gallery_name_search');
            $this->phpsession->save('categories_search_id', $this->input->post('categories_id'));
            $view_data['categories_combo'] = $this->gallery_categories_model->get_gallery_categories_combo(array('combo_name' => 'categories_id', 'categories_id' =>$this->input->post('categories_id'), 'lang' => $options['lang'], 'extra' => 'class="btn" style="max-width: 25%;"'));
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $view_data['search'] = $this->phpsession->get('gallery_name_search');
            if(!($this->phpsession->get('categories_search_id'))) $this->phpsession->save('categories_search_id', DEFAULT_COMBO_VALUE);
            $view_data['categories_combo'] = $this->gallery_categories_model->get_gallery_categories_combo(array('combo_name' => 'categories_id', 'categories_id' => $this->phpsession->get('categories_search_id'), 'lang' => $options['lang'], 'extra' => 'class="btn" style="max-width: 25%;"'));

        }
        $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        $options['keyword']                 = $this->phpsession->get('gallery_name_search');
        $options['cat_id']                  = $this->phpsession->get('categories_search_id');
        $options['filter']                  = $this->load->view('admin/search_gallery_form', $view_data, TRUE);
        return $options;
    }
    
    function add()
    {
        $options = array();
        $this->form_validation->set_rules('gallery_name', 'Tên bộ sưu tập ảnh', 'trim|required|xss_clean|max_length[255]');
        if ($this->form_validation->run())
        {
            $data = array(
                'gallery_name'  => $this->input->post('gallery_name'),
                'status'        => STATUS_ACTIVE,
                'summary'       => '',
                'content'       => '',
                'create_time'   => now(),
                'update_time'   => now(),
                'lang'          => $this->phpsession->get("gallery_lang"),
                'creator'       => $this->phpsession->get('user_id'),
                'editor'        => $this->phpsession->get('user_id'),
                );
            $position_add = $this->gallery_model->position_to_add_gallery(array('lang'=>$data['lang']));
            $data['position'] = $position_add;
            $gallery_id = $this->gallery_model->insert($data);
            return $this->edit(array('id'=>$gallery_id));
        } else {
            $options['error'] = validation_errors();
            $options['header'] = 'Thêm bộ sưu tập ảnh';
            
            if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
                $options['options'] = $options;
            
            // Chuan bi du lieu chinh de hien thi
            $this->_view_data['main_content'] = $this->load->view('admin/add_gallery_form', $options, TRUE);
            // Chuan bi cac the META
            $this->_view_data['title'] = 'Thêm bộ sưu tập ảnh' . DEFAULT_TITLE_SUFFIX;
            // Tra lai view du lieu cho nguoi su dung
            $this->load->view($this->_layout, $this->_view_data);
        }
        return FALSE;
    }
    
    function edit($options = array())
    {
        if(!$this->is_postback()) redirect(GALLERY_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_gallery())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        
        if(!isset($options['id'])){
            $options['id'] = NULL;
        }

        $options += $this->_get_edit_gallery_form_data(array('id'=>$options['id']));

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/edit_gallery_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa bộ sưu tập ảnh' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_edit_gallery_form_data($options = array())
    {   
        if(isset($options['id']))
            $gallery_id = $options['id'];
        else $gallery_id = $this->input->post('id');
        
        $view_data = array();

        // Get from DB
        if($this->input->post('from_list'))
        {
            $gallery                       = $this->gallery_model->get_gallery(array('id' => $gallery_id, 'is_admin' => TRUE));
            if(!is_object($gallery)) show_404();
            $view_data['gallery_name']      = $gallery->gallery_name;
            if(SLUG_ACTIVE>0){
                $view_data['slug'] = slug_character_remove($gallery->slug);
            }
            $lang = !empty($gallery->lang)?$gallery->lang:DEFAULT_LANGUAGE;
            $view_data['summary']           = $gallery->summary;
            $view_data['content']           = $gallery->content;
            $view_data['categories']        = $this->gallery_categories_model->get_gallery_categories_combo(array('categories_combobox' => $gallery->cat_id, 'lang' => $lang, 'extra' => 'class="btn"'));
            $view_data['meta_title']        = $gallery->meta_title;
            $view_data['meta_keywords']     = $gallery->meta_keywords;
            $view_data['meta_description']  = $gallery->meta_description;
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));

        }
        // Get from submit
        else
        {
            $view_data['gallery_name']      = $this->input->post('gallery_name', TRUE);
            if(SLUG_ACTIVE>0){
                $view_data['slug'] = my_trim($this->input->post('slug', TRUE));
            }
            $view_data['summary']           = $this->input->post('summary', TRUE);
            $view_data['content']           = '';
            $view_data['categories']        = $this->gallery_categories_model->get_gallery_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox'), 'lang' => $this->input->post('lang'), 'extra' => 'class="btn"'));
            $view_data['meta_title']        = $this->input->post('meta_title', TRUE);
            $view_data['meta_keywords']     = $this->input->post('meta_keywords', TRUE);
            $view_data['meta_description']  = $this->input->post('meta_description', TRUE);
            $view_data['lang_combobox']     = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        }
        $view_data['gallery_id']            = $gallery_id;
        $this->phpsession->save('gallery_id', $gallery_id);
        //$view_data['uri']           = GALLERY_ADMIN_EDIT_URL;
        $view_data['submit_uri']    = GALLERY_ADMIN_EDIT_URL;
        $view_data['header']        = 'Sửa bộ sưu tập ảnh';
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['images']        = $this->get_gallery_image();
        $view_data['scripts']       = $this->_get_scripts();
        return $view_data;
    }
    
    private function _do_edit_gallery()
    {
        if($this->input->post('btnSubmit') === 'Lưu dữ liệu')
        {
            $this->form_validation->set_rules('gallery_name', 'Tên bộ sưu tập ảnh', 'trim|required|max_length[255]|xss_clean');
            if(SLUG_ACTIVE>0){
                $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
            }
            $this->form_validation->set_rules('categories_combobox', 'Phân loại bộ sưu tập ảnh', 'required|is_not_default_combo');
            $this->form_validation->set_rules('summary', 'Mô tả ngắn', 'trim|xss_clean|min_length[10]|max_length[500]');
            $this->form_validation->set_rules('content', 'Nội dung', 'trim|xss_clean');
            $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('meta_description', 'Meta description', 'trim|xss_clean');
        
            if ($this->form_validation->run($this))
            {
                $content = str_replace('&lt;', '<', $this->input->post('content'));
                $content = str_replace('&gt;', '>', $content);
                $gallery_data       = array(
                    'id'            => $this->input->post('id'),
                    'gallery_name'  => strip_tags($this->input->post('gallery_name', TRUE)),
                    'update_time'   => now(),
                    'summary'       => $this->input->post('summary', TRUE),
                    'content'       => $content,
                    'cat_id'        => $this->input->post('categories_combobox', TRUE),
                    'meta_title'    => $this->input->post('meta_title', TRUE),
                    'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                    'meta_description'=> $this->input->post('meta_description', TRUE),
                    'lang'          => $this->input->post('lang', TRUE),
                    'editor'        => $this->phpsession->get('user_id'),
                );
                $position_edit = $this->gallery_model->position_to_edit_gallery(array('lang'=>$gallery_data['lang'],'id'=>$this->input->post('id')));
                $gallery_data['position'] = $position_edit;
                $this->gallery_model->update($gallery_data);
                if(SLUG_ACTIVE>0){
                    $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_GALLERY,'type_id'=>$gallery_data['id']));
                }
                redirect(GALLERY_ADMIN_BASE_URL . '/' . $gallery_data['lang']);
            }
            $this->_last_message = validation_errors();
            return FALSE;
        }
        else if($this->input->post('btnSubmit') == 'Upload')
        {
            $this->upload_gallery_image();
            $this->_last_message = $this->gallery_images_model->get_last_message();
        }
    }
    
    function get_gallery_image()
    {
        $options['gallery_id'] = $this->phpsession->get('gallery_id');
        $images = $this->gallery_images_model->get_gallery_images($options);
        $view_data = array();
        $view_data['images'] = $images;
        if($this->input->post('is-ajax'))
            echo $this->load->view('admin/gallery_images', $view_data, TRUE);
        else
            return $this->load->view('admin/gallery_images', $view_data, TRUE);
    }
    
    public function ajax_upload_gallery_image()
    {
        if (!empty($_FILES))
        {
            $image_path = './images/gallery/';
            $gallery_id = $this->phpsession->get('gallery_id');
            $gallery   = $this->gallery_model->get_gallery(array('id' => $gallery_id, 'is_admin' => TRUE)); 
            $gallery_name = url_title($gallery->gallery_name, 'dash', TRUE);
            $this->gallery_images_model->upload_gallery_images($gallery_id, $gallery_name, $image_path);
        }
    }
    
    function upload_gallery_image()
    {
            $image_path = './images/gallery/';
            $gallery_id = $this->phpsession->get('gallery_id');
            $gallery   = $this->gallery_model->get_gallery(array('id' => $gallery_id, 'is_admin' => TRUE)); 
            $gallery_name = url_title($gallery->gallery_name, 'dash', TRUE);
            $this->gallery_images_model->upload_gallery_images($gallery_id, $gallery_name, $image_path);
    }
    
    public function sort_gallery_image()
    {
        $arr = $this->input->post('id');
        $i = 1;
        foreach ($arr as $recordidval)
        {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval);
            $this->db->where('gallery_id', $this->phpsession->get('gallery_id'));
            $this->db->update('gallery_images', $array);
            $i = $i + 1;
        }
    }

    public function delete_gallery_image()
    {
        $image_id = $this->input->post('id');
        $image_path = './images/gallery/';
        $this->gallery_images_model->delete_gallery_images($image_id, $image_path);
        echo $this->get_gallery_image();
    }
    
    function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $gallery_id = $this->input->post('id');
            if(SLUG_ACTIVE>0){
                $check_slug = $this->slug_model->get_slug(array('type_id'=>$gallery_id,'type'=>SLUG_TYPE_GALLERY,'onehit'=>TRUE));
                if(!empty($check_slug)){
                    $this->slug_model->delete($check_slug->id);
                }
            }
            $this->gallery_images_model->delete_all_gallery_images($gallery_id, './images/gallery/');
            $this->gallery_model->delete($gallery_id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get("gallery_lang");
        //return $this->browse($options);
//        redirect(GALLERY_ADMIN_BASE_URL . '/' . $lang);
        redirect(GALLERY_ADMIN_BASE_URL);
    }
    
    public function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('gallery_lang');
        $this->gallery_model->item_to_sort_gallery(array('id' => $id));
        redirect(GALLERY_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $gallery = $this->gallery_model->get_gallery(array('id' => $id, 'is_admin' => TRUE));
        $status = $gallery->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->gallery_model->update(array('id'=>$id,'status'=>$status));
    }
    
    function add_caption_image_gallery()
    {
        $id = $this->input->post('id', TRUE);
        $caption = $this->input->post('caption', TRUE);
        $this->gallery_images_model->update(array('id'=>$id,'caption'=>$caption));
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