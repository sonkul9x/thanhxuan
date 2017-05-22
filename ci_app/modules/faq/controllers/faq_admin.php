<?php
class Faq_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = FAQ_ADMIN_BASE_URL;
    }

    /**
     * @desc: Hien thi danh sach cac bai viet
     * 
     * @param type $options 
     */
    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        $options['faq_sort_type'] = $this->phpsession->get('faq_sort_type');
        $this->phpsession->save('faq_lang', $options['lang']);

        $total_row          = $this->faq_model->get_faq_count($options);
        $total_pages        = (int)($total_row / FAQ_ADMIN_POST_PER_PAGE);
        if ($total_pages * FAQ_ADMIN_POST_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * FAQ_ADMIN_POST_PER_PAGE;
        $options['limit']   = FAQ_ADMIN_POST_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $options['faqs']                  = $this->faq_model->get_faq($options);
        $options['categories_combobox']   = $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $options['cat_id'], 'lang' => $options['lang'], 'extra' => 'class="btn"'));
        $options['sort_combobox']         = $this->faq_model->get_faq_sort_combobox(array('sort_combobox'=>$options['faq_sort_type'], 'extra' => 'onchange="javascript:change_sort();" class="btn"'));
        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        $options['post_uri']              = 'faq_admin';
        $options['total_rows']            = $total_row;
        $options['total_pages']           = $total_pages;
        $options['page_links']            = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = FAQ_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = FAQ_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/faq_list',$options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý hỏi đáp' . DEFAULT_TITLE_SUFFIX;
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
            $options['cat_id'] = $this->input->post('categories_combobox');
            $this->phpsession->save('faq_search_options', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('faq_search_options');
            if (is_array($temp_options))
            {
                $options['search'] = $temp_options['search'];
                $options['cat_id'] = $temp_options['cat_id'];
            }
            else
            {
                $options['search'] = '';
                $options['cat_id'] = DEFAULT_COMBO_VALUE;
            }
        }
//        $options['offset'] = $this->uri->segment(3);
        return $options;
    }

    public function do_sort_faq_list()
    {
        if ( $this->is_postback())
        {
            $this->phpsession->save('faq_sort_type', $this->input->post('sort_combobox'));
        }
        else
        {
            $this->phpsession->save('faq_sort_type', '');
        }
    }
    
    function add()
    {
        $options = array();
        
        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options += $this->_get_add_faq_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_faq_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm hỏi đáp' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_faq_form_data()
    {
        $options                  = array();
        $options['title']         = my_trim($this->input->post('title'));
        if(SLUG_ACTIVE>0){
            $options['slug'] = $this->input->post('slug');
        }
        $options['summary']       = my_trim($this->input->post('summary'));
        $options['thumb']         = $this->input->post('thumb');
        $options['content']       = $this->input->post('content');
        $options['fullname']      = $this->input->post('fullname');
        $options['email']         = $this->input->post('email');
        $options['tel']           = $this->input->post('tel');
        $options['address']           = $this->input->post('address');
        $options['meta_title']            = my_trim($this->input->post('meta_title'));
        $options['meta_keywords']         = my_trim($this->input->post('meta_keywords'));
        $options['meta_description']      = my_trim($this->input->post('meta_description'));
        $options['tags']                  = my_trim($this->input->post('tags'));
        if($this->is_postback())
        {
            $options['created_date']  = $this->input->post('created_date');
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'                => $this->input->post('lang', TRUE)
                                                                                                        , 'extra' => 'class="btn"'
                                                                                                        ));
        }
        else
        {
            $options['created_date']  = date('d-m-Y');
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('faq_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'                => $this->phpsession->get('faq_lang')
                                                                                                        , 'extra' => ' class="btn"'
                                                                                                        ));
        }

        $options['scripts']       = $this->_get_scripts();
        $options['header']        = 'Thêm hỏi đáp';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = FAQ_ADMIN_BASE_URL.'/add';

        return $options;
    }

    private function _do_add()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('categories_combobox', 'Phân loại', 'is_not_default_combo');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Nội dung câu hỏi', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('content', 'Nội dung trả lời', 'required');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('tel', 'Điện thoại', 'trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|xss_clean|max_length[500]');
        $this->form_validation->set_rules('created_date', 'Ngày đăng', 'trim|required|xss_clean|is_date');
//        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
            $position_add = $this->faq_model->position_to_add_faq(array('lang'=>$post_data['lang']));
            $post_data['position'] = $position_add;
            $insert_id = $this->faq_model->insert($post_data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_FAQ,'type_id'=>$insert_id));
                }
            }
            redirect(FAQ_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }

    private function _get_posted_data()
    {
        $content = str_replace('&lt;', '<', $this->input->post('content'));
        $content = str_replace('&gt;', '>', $content);
        $post_data = array(
            'title'               => my_trim($this->input->post('title', TRUE)),
            'summary'             => my_trim($this->input->post('summary', TRUE)),
            'content'             => $content,
            'fullname'            => my_trim($this->input->post('fullname', TRUE)),
            'email'               => my_trim($this->input->post('email', TRUE)),
            'tel'               => my_trim($this->input->post('tel', TRUE)),
            'thumbnail'           => cut_domain_from_url($this->input->post('thumb')),
            'cat_id'              => $this->input->post('categories_combobox', TRUE),
            'meta_title'          => my_trim($this->input->post('meta_title', TRUE)),
            'meta_keywords'       => my_trim($this->input->post('meta_keywords', TRUE)),
            'meta_description'    => my_trim($this->input->post('meta_description', TRUE)),
            'tags'                => my_trim($this->input->post('tags', TRUE)),
            'lang'                => $this->input->post('lang', TRUE),
            'status'              => STATUS_ACTIVE,
        );

        $created_date = explode('-', $this->input->post('created_date', TRUE));
        $post_data['created_date']  = date('Y-m-d', mktime(0, 0, 0, $created_date[1], $created_date[0], $created_date[2]));
        $post_data['created_date']  .= date(' H:i:s');
        
        $post_data['updated_date']  = date('Y-m-d H:i:s');

        $post_data['editor'] = $this->phpsession->get('user_id');
        return $post_data;
    }

    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(FAQ_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_faq_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa hỏi đáp' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data()
    {
        $id        = $this->input->post('id');

        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $faq           = $this->faq_model->get_faq(array('id' => $id));
            $id             = $faq->id;
            $title          = $faq->title;
            if(SLUG_ACTIVE>0){
                $slug = slug_character_remove($faq->slug);
            }
            $summary        = $faq->summary;
            $content        = $faq->content;
            $fullname       = $faq->fullname;
            $email          = $faq->email;
            $tel            = $faq->tel;
            $address            = $faq->address;
            $created_date   = date('d-m-Y', strtotime($faq->created_date));
            $cat_id         = $faq->cat_id;
            $thumb          = $faq->thumbnail;
            $meta_title     = $faq->meta_title;
            $meta_keywords  = $faq->meta_keywords;
            $meta_description = $faq->meta_description;
            $tags           = $faq->tags;
            $lang           = $faq->lang;
        }

        // khi submit
        else
        {
            $id             = $id;
            $title          = my_trim($this->input->post('title', TRUE));
            if(SLUG_ACTIVE>0){
                $slug = my_trim($this->input->post('slug', TRUE));
            }
            $summary        = my_trim($this->input->post('summary', TRUE));
            $content        = '';
            $fullname       = my_trim($this->input->post('fullname', TRUE));
            $email          = my_trim($this->input->post('email', TRUE));
            $tel            = my_trim($this->input->post('tel', TRUE));
            $address        = my_trim($this->input->post('address', TRUE));
            $created_date   = my_trim($this->input->post('created_date', TRUE));
            $cat_id         = $this->input->post('categories_combobox');
            $thumb          = $this->input->post('thumb');
            $meta_title     = $this->input->post('meta_title', TRUE);
            $meta_keywords  = $this->input->post('meta_keywords', TRUE);
            $meta_description = $this->input->post('meta_description', TRUE);
            $tags           = $this->input->post('tags', TRUE);
            $lang           = $this->input->post('lang', TRUE);
        }

        $options                  = array();
        $options['id']            = $id;
        $options['title']         = $title;
        if(SLUG_ACTIVE>0){
            $options['slug'] = $slug;
        }
        $options['summary']       = $summary;
        $options['thumb']         = $thumb;
        $options['content']       = $content;
        $options['fullname']      = $fullname;
        $options['email']         = $email;
        $options['tel']           = $tel;
        $options['address']           = $address;
        $options['created_date']  = $created_date;
        $options['meta_title']            = $meta_title;
        $options['meta_keywords']         = $meta_keywords;
        $options['meta_description']      = $meta_description;
        $options['tags']                  = $tags;
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        $options['header']        = 'Sửa hỏi đáp';
        $options['button_name']   = 'Sửa hỏi đáp';
        $options['submit_uri']    = FAQ_ADMIN_BASE_URL.'/edit';
        $options['categories_combobox']   = $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $cat_id, 'lang' => $lang, 'extra' => 'class="btn"'));
        $options['scripts']               = $this->_get_scripts();

        return $options;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('categories_combobox', 'Phân loại', 'is_not_default_combo');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|required|xss_clean');
        $this->form_validation->set_rules('summary', 'Nội dung câu hỏi', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('content', 'Nội dung trả lời', 'required');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('tel', 'Điện thoại', 'trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'trim|xss_clean|max_length[500]');
        $this->form_validation->set_rules('created_date', 'Ngày đăng', 'trim|required|xss_clean|is_date');
        $this->form_validation->set_rules('meta_title', 'Meta title', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('meta_description', 'Meta description', 'trim|xss_clean');
        $this->form_validation->set_rules('tags', 'Tags', 'trim|xss_clean');
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['id'] = $this->input->post('id');
            $position_edit = $this->faq_model->position_to_edit_faq(array('lang'=>$post_data['lang'],'id'=>$this->input->post('id')));
            $post_data['position'] = $position_edit;
            $this->faq_model->update($post_data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_FAQ,'type_id'=>$post_data['id']));
            }
            redirect(FAQ_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }

    /**
     * Xóa tin
     */
    public function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            if(SLUG_ACTIVE>0){
                $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_FAQ,'onehit'=>TRUE));
                if(!empty($check_slug)){
                    $this->slug_model->delete($check_slug->id);
                }
            }
            $this->faq_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('faq_lang');
        redirect(FAQ_ADMIN_BASE_URL . '/' . $lang);
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
        $faq = $this->faq_model->get_faq(array('id' => $id));
        $status = $faq->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->faq_model->update(array('id'=>$id,'status'=>$status));
    }
    
    public function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('faq_lang');
        $this->faq_model->item_to_sort_faq(array('id' => $id));
        redirect(FAQ_ADMIN_BASE_URL . '/' . $lang);
    }
    
}