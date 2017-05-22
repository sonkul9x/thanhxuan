<?php
class Videos_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
//        modules::run('auth/auth/validate_permission', array('operation' => OPERATION_MANAGE));
        modules::run('auth/auth/validate_login');
        // Khoi tao cac bien
        $this->_layout = 'admin_ui/layout/main';
    }
    
    /**
     * @desc: Hien thi danh sach 
     * 
     * @param type $options 
     */
    function browse($para1=DEFAULT_LANGUAGE)
    {
        $options = array('lang'=>switch_language($para1));
        $this->phpsession->save('videos_cat_lang', $options['lang']);
        
        $options['categories'] = $this->videos_categories_model->get_videos_categories_object(array('parent_id' => ROOT_CATEGORY_ID,'lang'=>$options['lang']));
        $options['lang_combobox']  = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));        
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('cat/list_cat', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại videos' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    function add()
    {
        $options = array();
        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại videos' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_add()
    {
        $this->form_validation->set_rules('category', 'Tên phân loại', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
            $position_add = $this->videos_categories_model->position_to_add_videos_cat(array('lang'=>$post_data['lang'],'parent_id'=>$post_data['parent_id']));
            $post_data['position'] = $position_add;
            $insert_id = $this->videos_categories_model->insert($post_data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_VIDEOS_CATEGORIES,'type_id'=>$insert_id));
                }
            }
            redirect(VIDEOS_CAT_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }
    
    private function _get_posted_data()
    {
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->videos_categories_model->get_level_videos_category(array('parent_id'=>$parent_id));

        $post_data = array(
            'category' => my_trim($this->input->post('category', TRUE)),
            'parent_id' => $parent_id,
            'level' => $parent_level + 1,
            'meta_title' => my_trim($this->input->post('meta_title', TRUE)),
            'meta_keywords' => my_trim($this->input->post('meta_keywords', TRUE)),
            'meta_description' => my_trim($this->input->post('meta_description', TRUE)),
            'status' => STATUS_ACTIVE,
            'lang' => $this->input->post('lang', TRUE),
            'editor' => $this->phpsession->get('user_id'),
        );
        return $post_data;
    }
    
    private function _get_add_form_data()
    {
        $view_data = array();
        $view_data['category'] = $this->input->post('category', TRUE);
        if(SLUG_ACTIVE>0){
            $view_data['slug'] = $this->input->post('slug', TRUE);
        }
        $view_data['meta_title'] = $this->input->post('meta_title', TRUE);
        $view_data['meta_keywords'] = $this->input->post('meta_keywords', TRUE);
        $view_data['meta_description'] = $this->input->post('meta_description', TRUE);
        
        if($this->is_postback())
        {
            $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $view_data['categories_combobox']   = $this->videos_categories_model->
                                                    get_videos_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->input->post('lang', TRUE)
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        else
        {
            $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('videos_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $view_data['categories_combobox']   = $this->videos_categories_model->
                                                    get_videos_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->phpsession->get('videos_cat_lang')
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        $view_data['header']        = 'Thêm phân loại videos';
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['submit_uri']    = VIDEOS_CAT_ADMIN_ADD_URL;
        return $view_data;
    }
    
    function edit()
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options  += $this->_get_edit_form_data();

        $options['header']        = 'Sửa phân loại videos';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = VIDEOS_CAT_ADMIN_EDIT_URL;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại videos' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_edit()
    {
        $this->form_validation->set_rules('category', 'Tên phân loại', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        if($this->form_validation->run())
        {
            $data = $this->_get_posted_data();
            $data['id'] = $this->input->post('id');
            $this->videos_categories_model->update($data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_VIDEOS_CATEGORIES,'type_id'=>$data['id']));
            }
            redirect(VIDEOS_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;
    }
    
    private function _get_edit_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $categories = $this->videos_categories_model->get_videos_categories(array('id' => $id));
            $category = $categories->category;
            $parent_id = $categories->parent_id;
            $meta_title = $categories->meta_title;
            $meta_keywords = $categories->meta_keywords;
            $meta_description = $categories->meta_description;
            $lang = $categories->lang;
            if(SLUG_ACTIVE>0){
                $slug = $categories->slug;
            }
        }
        else
        {
            $category = my_trim($this->input->post('category', TRUE));
            $parent_id = $this->input->post('categories_combobox', TRUE);
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
        if(SLUG_ACTIVE>0){
            $options['slug'] = $slug;
        }
        $options['categories_combobox'] = $this->videos_categories_model->get_videos_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"', 'notid' => $id));
        $options['category'] = $category;
        $options['meta_title'] = $meta_title;
        $options['meta_keywords'] = $meta_keywords;
        $options['meta_description'] = $meta_description;
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        return $options;
    }
    
    function delete()
    {
        $options = array();
        if($this->is_postback()){
            $id = $this->input->post('id');
            $check_videos = $this->videos_model->get_videos_count(array('cat_id'=>$id));
            $categories = $this->videos_categories_model->get_videos_categories_count(array('parent_id' => $id));
            if($check_videos > 0 || $categories > 0){
                $options['error'] = 'Không thể xóa phân loại này vì vẫn tồn tại videos hoặc phân loại con';
            }
            else{
                if(SLUG_ACTIVE>0){
                    $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_VIDEOS_CATEGORIES,'onehit'=>TRUE));
                    if(!empty($check_slug)){
                        $this->slug_model->delete($check_slug->id);
                    }
                }
                $this->videos_categories_model->delete($id);
                $options['warning'] = 'Đã xóa thành công';
            }
        }
        $lang = $this->phpsession->get('videos_cat_lang');
        redirect(VIDEOS_CAT_ADMIN_BASE_URL . '/' . $lang);
    }

    function get_videos_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        $id = $this->input->post('id', TRUE);
        if (!$this->input->post('is_add_edit')) {
            echo $this->videos_categories_model->get_videos_categories_combo(array('lang' => $lang, 'notid' => $id, 'extra' => 'class="btn"'));
        } else {
            echo $this->videos_categories_model->get_videos_categories_combo(array('lang' => $lang, 'notid' => $id, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        }
    }
    
    function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('videos_cat_lang');
        $this->videos_categories_model->item_to_sort_videos_cat(array('id' => $id));
        redirect(VIDEOS_CAT_ADMIN_BASE_URL . '/' . $lang);
    }
    
}