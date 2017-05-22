<?php
class Pages_Admin extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = PAGES_ADMIN_BASE_URL;
    }

    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('page_lang', $options['lang']);
        
        $total_row      = $this->pages_model->get_pages_count($options);
        $total_pages    = (int) ($total_row / PAGES_PER_PAGE);

        if ($total_pages * PAGES_PER_PAGE < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * PAGES_PER_PAGE;
        $options['limit'] = PAGES_PER_PAGE;

        $config = prepare_pagination(
                array(
                    'total_rows'    => $total_row,
                    'per_page'      => $options['limit'],
                    'offset'        => $options['offset'],
                    'js_function'   => 'change_page_admin'
                )
        );
        
        $this->pagination->initialize($config);
//        $options['is_admin'] = TRUE;
        
        $options['pages'] = $this->pages_model->get_pages($options);
//        $options['search'] = $options['search'];
        $options['post_uri'] = 'pages';
        $options['e_page'] = $options['page'];
        $options['total_rows'] = $total_row;
        $options['total_pages'] = $total_pages;
        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        $options['page_links'] = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri']                   = PAGES_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri']                   = PAGES_ADMIN_BASE_URL;
        }

        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu không thành công';
        
        $options['lang'] = $options['lang'] != DEFAULT_LANGUAGE ? '/' . $options['lang'] : '';
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/pages_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý Trang' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    /**
     * Lấy dữ liệu từ filter
     * @return string
     */
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search'] = $this->db->escape_str($this->input->post('search', TRUE));
            $this->phpsession->save('page_search', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('page_search');
            if (is_array($temp_options))
            {
                $options['search'] = $temp_options['search'];
            }
            else
            {
                $options['search'] = '';
            }
        }
//        $options['offset'] = $this->uri->segment(3);
        return $options;
    }

    function add() 
    {
        $options = array();
        
        if ($this->is_postback()) {
            if (!$this->_do_add_page())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_page_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_page_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm trang' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_page_form_data() 
    {
        $options = array();
        
        $options['title'] = $this->input->post('title');
        if(SLUG_ACTIVE==0){
            $options['uri'] = $this->input->post('uri');
        }else{
            $options['slug'] = $this->input->post('slug');
        }
        $options['summary'] = $this->input->post('summary');
        $options['content'] = '';
        $options['meta_title'] = $this->input->post('meta_title');
        $options['meta_keywords'] = $this->input->post('meta_keywords');
        $options['meta_description'] = $this->input->post('meta_description');
        $options['tags'] = $this->input->post('tags');
        
        if ($this->is_postback()){
            $options['created_date'] = $this->input->post('created_date');
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'class="btn"'));
        }else{
            $options['created_date'] = date('d-m-Y');
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('page_lang'), 'extra' => 'class="btn"'));
        }

        $options['scripts'] = $this->_get_scripts();
        $options['header'] = 'Thêm trang';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri'] = PAGES_ADMIN_BASE_URL.'/add';
        return $options;
    }

    private function _do_add_page() {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE==0){
            $this->form_validation->set_rules('uri', 'Đường dẫn', 'trim|required|xss_clean|max_length[255]');
        }else{
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim|xss_clean');
        $this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_pages_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
            $insert_id = $this->pages_model->insert($post_data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $slug_insert_id = $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_PAGES,'type_id'=>$insert_id));
                    $slug_ = $this->slug_model->get_slug(array('id'=>$slug_insert_id));
                    if(!empty($slug_)){
                        $this->pages_model->update(array('id'=>$insert_id,'uri'=>'/'.$slug_->slug));
                    }
                }
            }
//            redirect(PAGES_ADMIN_BASE_URL . '/' . $post_data['lang']);
            $this->save_cache();
        }
        return FALSE;
    }

    private function _get_posted_pages_data() {
        $content = str_replace('&lt;', '<', $this->input->post('content'));
        $content = str_replace('&gt;', '>', $content);
        $post_data = array(
            'title' => my_trim($this->input->post('title', TRUE)),
//            'uri' => my_trim($this->input->post('uri', TRUE)),
            'content' => $content,
            'summary' => my_trim($this->input->post('summary', TRUE)),
            'meta_title' => my_trim($this->input->post('meta_title', TRUE)),
            'meta_keywords' => my_trim($this->input->post('meta_keywords', TRUE)),
            'meta_description' => my_trim($this->input->post('meta_description', TRUE)),
            'tags' => my_trim($this->input->post('tags', TRUE)),
            'status' => STATUS_ACTIVE,
            'lang' => $this->input->post('lang', TRUE),
            'editor' => $this->phpsession->get('user_id'),
        );
        if(SLUG_ACTIVE==0){
            $post_data['uri'] = my_trim($this->input->post('uri', TRUE));
        }
        $created_date = explode('-', $this->input->post('created_date', TRUE));
        $post_data['created_date'] = date('Y-m-d', mktime(0, 0, 0, $created_date[1], $created_date[0], $created_date[2]));
        $post_data['created_date'] .= date(' H:i:s');
        return $post_data;
    }

    function edit() 
    {
        $options = array();
        
        if (!$this->is_postback()) redirect(PAGES_ADMIN_BASE_URL);
        
        if ($this->is_postback() && !$this->input->post('from_list')) 
        {
            if (!$this->_do_edit_page())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_page_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa trang' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data() {
        $id = $this->input->post('id');

        // khi vừa vào trang sửa
        if ($this->input->post('from_list')) {
            $page = $this->pages_model->get_pages(array('id' => $id, 'is_admin' => TRUE));
            $id = $page->id;
            $title = $page->title;
            if(SLUG_ACTIVE==0){
                $uri = $page->uri;
            }else{
                $slug = slug_character_remove($page->slug);
            }
            $summary = $page->summary;
            $content = $page->content;
            $created_date = date('d-m-Y', strtotime($page->created_date));
            $meta_title = $page->meta_title;
            $meta_keywords = $page->meta_keywords;
            $meta_description = $page->meta_description;
            $tags = $page->tags;
            $lang = $page->lang;
        }

        // khi submit
        else {
            $id = $id;
            $title = my_trim($this->input->post('title', TRUE));
            if(SLUG_ACTIVE==0){
                $uri = $this->input->post('uri');
            }else{
                $slug = my_trim($this->input->post('slug', TRUE));
            }
            $summary = $this->input->post('summary');
            $content = '';
            $created_date = my_trim($this->input->post('created_date', TRUE));
            $meta_title = $this->input->post('meta_title', TRUE);
            $meta_keywords = $this->input->post('meta_keywords', TRUE);
            $meta_description = $this->input->post('meta_description', TRUE);
            $tags = $this->input->post('tags', TRUE);
            $lang = $this->input->post('lang', TRUE);
        }

        $view_data = array();
        $view_data['id'] = $id;
        $view_data['title'] = $title;
        if(SLUG_ACTIVE==0){
            $view_data['uri'] = $uri;
        }else{
            $view_data['slug'] = $slug;
        }
        $view_data['summary'] = $summary;
        $view_data['content'] = $content;
        $view_data['created_date'] = $created_date;
        $view_data['meta_title'] = $meta_title;
        $view_data['meta_keywords'] = $meta_keywords;
        $view_data['meta_description'] = $meta_description;
        $view_data['tags'] = $tags;
//        $view_data['status'] = $status;
        $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'class="btn"'));
        $view_data['header'] = 'Sửa trang';
        $view_data['button_name'] = 'Lưu dữ liệu';
        $view_data['submit_uri'] = PAGES_ADMIN_BASE_URL.'/edit';
        $view_data['scripts'] = $this->_get_scripts();

        return $view_data;
    }

    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_page() {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE==0){
            $this->form_validation->set_rules('uri', 'Đường dẫn', 'trim|required|xss_clean|max_length[255]');
        }else{
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|required');
        $this->form_validation->set_rules('created_date', 'Ngày đăng tin', 'trim|required|xss_clean|is_date');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim|xss_clean');
        $this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_pages_data();
            $post_data['id'] = $this->input->post('id');
            $this->pages_model->update($post_data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_PAGES,'type_id'=>$post_data['id']));
                $slug_ = $this->slug_model->get_slug(array('type'=>SLUG_TYPE_PAGES,'type_id'=>$post_data['id'],'onehit'=>TRUE));
                if(!empty($slug_)){
                    $this->pages_model->update(array('id'=>$post_data['id'],'uri'=>'/'.$slug_->slug));
                }
            }
//            redirect(PAGES_ADMIN_BASE_URL . '/' . $post_data['lang']);
            $this->save_cache();
        }
        return FALSE;
    }

    /**
     * Xóa tin
     */
    function delete() 
    {
        $options = array();
        if ($this->is_postback()) {
            $id = $this->input->post('id');
            if(SLUG_ACTIVE>0){
                $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_PAGES,'onehit'=>TRUE));
                if(!empty($check_slug)){
                    $this->slug_model->delete($check_slug->id);
                }
            }
            $this->pages_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('page_lang');
//        redirect(PAGES_ADMIN_BASE_URL . '/' . $lang);
        $this->save_cache();
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
    
    function change_status()
    {
        $id = $this->input->post('id');
        $page = $this->pages_model->get_pages(array('id' => $id));
        $status = $page->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->pages_model->update(array('id'=>$id,'status'=>$status));
        $this->save_cache();
    }
    
    function save_cache()
    {
        $lang = $this->phpsession->get('page_lang');
        if (save_cache('pages')) {
            redirect(PAGES_ADMIN_BASE_URL . '/' . $lang . '?save_cache=success');
        } else {
            redirect(PAGES_ADMIN_BASE_URL . '/' . $lang . '?save_cache=error');
        }
    }

}

?>
