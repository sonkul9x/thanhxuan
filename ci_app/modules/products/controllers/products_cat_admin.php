<?php

class Products_Cat_Admin extends MY_Controller 
{

    function __construct() {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
    }

    /**
     * @desc: Hien thi danh sach cac phan loai san pham
     * 
     * @param type $para1 
     */
    function browse($para1=DEFAULT_LANGUAGE) {
        $options = array('lang'=>switch_language($para1));
        $this->phpsession->save('products_cat_lang', $options['lang']);
        
        $options['categories'] = $this->products_categories_model->get_categories_object_array_by_parent_id(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        if (isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) {
            $options['options'] = $options;
        }

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_cat/cat_list', $options, TRUE);

        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại sản phẩm' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    function add() {
        $options = array();

        if ($this->is_postback()) {
            if (!$this->_do_add_cat()) {
                $options['error'] = validation_errors();
            }
            if (isset($options['error'])) {
                $options['options'] = $options;
            }
        }
        $options += $this->_get_add_cat_form_data();
        $options['header'] = 'Thêm phân loại sản phẩm';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri'] = PRODUCTS_CAT_ADMIN_ADD_URL;
        $options['scripts']     = $this->_get_scripts();
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại sản phẩm' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_add_cat_form_data() {
        $options = array();

        $options['category'] = $this->input->post('category');
        if(SLUG_ACTIVE>0){
            $options['slug'] = $this->input->post('slug');
        }
        $options['summary']       = my_trim($this->input->post('summary'));
        $options['thumb']         = $this->input->post('thumb');
		$options['avatar']        = $this->input->post('avatar');
        $options['content']       = $this->input->post('content');
        $options['meta_title'] = $this->input->post('meta_title');
        $options['meta_keywords'] = $this->input->post('meta_keywords');
        $options['meta_description'] = $this->input->post('meta_description');
        if ($this->is_postback()) {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox'] = $this->products_categories_model->
                    get_categories_combo(array('categories_combobox' =>
                        $this->input->post('categories_combobox')
                        , 'is_add_edit_cat' => TRUE
                        , 'lang' => $this->input->post('lang', TRUE)
                        , 'extra' => 'class="btn"'
                    ));
        } else {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('products_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox'] = $this->products_categories_model->
                    get_categories_combo(array('categories_combobox' =>
                        $this->input->post('categories_combobox')
                        , 'is_add_edit_cat' => TRUE
                        , 'lang' => $this->phpsession->get('products_cat_lang')
                        , 'extra' => 'class="btn"'
                    ));
        }
        return $options;
    }

    private function _do_add_cat() {
        $this->form_validation->set_rules('category', 'Tên phân loại', 'trim|required|xss_clean|max_length[256]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|xss_clean');
		$this->form_validation->set_rules('avatar', 'Hình đại diện', 'trim|xss_clean');
        $this->form_validation->set_rules('summary', 'Mô tả ngắn', 'trim|xss_clean|max_length[512]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|xss_clean');
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->products_categories_model->get_level_products_category(array('parent_id'=>$parent_id));
        //neu dang them parent cat thi home = 1, con lai home = 0. check neu trang chu hien thi theo danh muc san pham
        if($parent_level == -1){
            $home = STATUS_ACTIVE;
        }else{
            $home = STATUS_INACTIVE;
        }
        if ($this->form_validation->run()) {
            $content = str_replace('&lt;', '<', $this->input->post('content'));
            $content = str_replace('&gt;', '>', $content);
            $data = array(
                'category' => strip_tags($this->input->post('category')),
                'parent_id' => $parent_id,
                'level' => $parent_level + 1,
                'summary' => my_trim($this->input->post('summary', TRUE)),
                'content' => $content,
                'thumbnail' => cut_domain_from_url($this->input->post('thumb')),
				'avatar' => cut_domain_from_url($this->input->post('avatar')),
                'meta_title' => $this->input->post('meta_title', TRUE),
                'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'lang' => $this->input->post('lang', TRUE),
                'status' => STATUS_ACTIVE,
                'home' => $home,
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
            );
            $position_add = $this->products_categories_model->position_to_add_product_cat(array('parent_id'=>$parent_id,'lang'=>$data['lang']));
            $data['position'] = $position_add;
            $insert_id = $this->products_categories_model->insert($data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_PRODUCTS_CATEGORIES,'type_id'=>$insert_id));
                }
            }
            redirect(PRODUCTS_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;
    }

    function edit() {
        $options = array();

        if ($this->is_postback() && !$this->input->post('from_list')) {
            if (!$this->_do_edit_cat()) {
                $options['error'] = validation_errors();
            }
            if (isset($options['error'])) {
                $options['options'] = $options;
            }
        }
        $options += $this->_get_edit_cat_form_data();

        $options['header'] = 'Sửa phân loại sản phẩm';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri'] = PRODUCTS_CAT_ADMIN_EDIT_URL;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại sản phẩm' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_cat_form_data() {
        $id = $this->input->post('id');

        if ($this->input->post('from_list')) {
            $categories = $this->products_categories_model->get_categories(array('id' => $id));
            $category = $categories->category;
            $parent_id = $categories->parent_id;
            $summary    = $categories->summary;
            $content    = $categories->content;
            $thumb      = $categories->thumbnail;
			$avatar      = $categories->avatar;
            $meta_title = $categories->meta_title;
            $meta_keywords = $categories->meta_keywords;
            $meta_description = $categories->meta_description;
            $lang = $categories->lang;
            if(SLUG_ACTIVE>0){
                $slug = $categories->slug;
            }
        } else {
            $category = $this->input->post('category', TRUE);
            $parent_id = $this->input->post('categories_combobox', TRUE);
            $summary = my_trim($this->input->post('summary', TRUE));
            $content = '';
            $thumb = my_trim($this->input->post('thumb', TRUE));
			$avatar = my_trim($this->input->post('avatar', TRUE));
            $meta_title = $this->input->post('meta_title', TRUE);
            $meta_keywords = $this->input->post('meta_keywords', TRUE);
            $meta_description = $this->input->post('meta_description', TRUE);
            $lang = $this->input->post('lang', TRUE);
            if(SLUG_ACTIVE>0){
                $slug = $this->input->post('slug', TRUE);
            }
        }
        $options = array();

        $options['id'] = $id;
        $options['category'] = $category;
        if(SLUG_ACTIVE>0){
            $options['slug'] = $slug;
        }
        $options['categories_combobox'] = $this->products_categories_model->get_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"', 'notid' => $id));
        $options['summary']       = $summary;
        $options['content']       = $content;
        $options['thumb']         = $thumb;
		$options['avatar']         = $avatar;
        $options['meta_title'] = $meta_title;
        $options['meta_keywords'] = $meta_keywords;
        $options['meta_description'] = $meta_description;
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        $options['scripts']       = $this->_get_scripts();
        return $options;
    }

    private function _do_edit_cat() {
        $this->form_validation->set_rules('category', 'Tên phân loại', 'trim|required|xss_clean|max_length[256]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|xss_clean');
		$this->form_validation->set_rules('avatar', 'Hình đại diện', 'trim|xss_clean');
        $this->form_validation->set_rules('summary', 'Tóm tắt', 'trim|xss_clean|max_length[512]');
        $this->form_validation->set_rules('content', 'Nội dung', 'trim|xss_clean');
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->products_categories_model->get_level_products_category(array('parent_id'=>$parent_id));
        if ($this->form_validation->run()) {
            $content = str_replace('&lt;', '<', $this->input->post('content'));
            $content = str_replace('&gt;', '>', $content);
            $data = array(
                'id' => $this->input->post('id'),
                'category' => $this->input->post('category', TRUE),
                'parent_id' => $parent_id,
                'level' => $parent_level + 1,
                'summary' => my_trim($this->input->post('summary', TRUE)),
                'content' => $content,
                'thumbnail' => cut_domain_from_url($this->input->post('thumb')),
				'avatar' => cut_domain_from_url($this->input->post('avatar')),
                'meta_title' => $this->input->post('meta_title', TRUE),
                'meta_keywords' => $this->input->post('meta_keywords', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'lang' => $this->input->post('lang', TRUE),
                'status' => STATUS_ACTIVE,
                'editor' => $this->phpsession->get('user_id'),
            );
            $position_edit = $this->products_categories_model->position_to_edit_product_cat(array(
                'id'=>$data['id'],
                'parent_id'=>$parent_id,
                'lang'=>$data['lang'],
            ));
            $data['position'] = $position_edit;
            $this->products_categories_model->update($data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_PRODUCTS_CATEGORIES,'type_id'=>$data['id']));
            }
            redirect(PRODUCTS_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;
    }

    function delete() {
        if ($this->is_postback()) {
            $id = $this->input->post('id');
            $categories = $this->products_categories_model->get_categories(array('parent_id' => $id));
            if (count($categories) == 0) {
                if(SLUG_ACTIVE>0){
                    $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_PRODUCTS_CATEGORIES,'onehit'=>TRUE));
                    if(!empty($check_slug)){
                        $this->slug_model->delete($check_slug->id);
                    }
                }
                $this->products_categories_model->delete_category($id);
            } else {
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các mục con';
            }
        }
        $lang = $this->phpsession->get('products_cat_lang');
        redirect(PRODUCTS_CAT_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('products_cat_lang');
        $this->products_categories_model->item_to_sort_product_cat(array('id' => $id, 'lang' => $lang));
        redirect(PRODUCTS_CAT_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function change_home()
    {
        $id = $this->input->post('id');
        $product_cat = $this->products_categories_model->get_categories(array('id' => $id));
        $home = $product_cat->home == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->products_categories_model->update(array('id'=>$id,'home'=>$home));
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $_cat = $this->products_categories_model->get_categories(array('id' => $id));
        $status = $_cat->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->products_categories_model->update(array('id'=>$id,'status'=>$status));
    }

    function get_products_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        $id = $this->input->post('id', TRUE);
        if (!$this->input->post('is_add_edit')) {
            echo $this->products_categories_model->get_categories_combo(array('lang' => $lang, 'notid' => $id, 'extra' => 'class="btn"'));
        } else {
            echo $this->products_categories_model->get_categories_combo(array('lang' => $lang, 'notid' => $id, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        }
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