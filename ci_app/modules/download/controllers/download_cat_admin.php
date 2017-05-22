<?php
class Download_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
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
        $this->phpsession->save('download_cat_lang', $options['lang']);
        
        $options['categories'] = $this->download_categories_model->get_download_categories_object(array('parent_id' => ROOT_CATEGORY_ID,'lang' => $options['lang']));
        $options['lang_combobox']  = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
           
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('cat/list_cat', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại tài liệu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    function add()
    {
        $options = array();
        if($this->is_postback())
        {
            if (!$this->_do_add_cat())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_cat_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại tài liệu' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_add_cat()
    {
        $this->form_validation->set_rules('title', 'Tên phân loại', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_cat_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
            $position_add = $this->download_categories_model->position_to_add_download_cat(array('lang'=>$post_data['lang'],'parent_id'=>$post_data['parent_id']));
            $post_data['position'] = $position_add;
            $insert_id = $this->download_categories_model->insert($post_data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_DOWNLOAD_CATEGORIES,'type_id'=>$insert_id));
                }
            }
            redirect(DOWNLOAD_CAT_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }
    
    private function _get_posted_cat_data()
    {
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->download_categories_model->get_level_download_category(array('parent_id'=>$parent_id));

        $post_data = array(
            'title' => my_trim($this->input->post('title', TRUE)),
            'parent_id' => $parent_id,
            'level' => $parent_level + 1,
            'lang' => $this->input->post('lang', TRUE),
            'status' => STATUS_ACTIVE,
        );
        $post_data['editor'] = $this->phpsession->get('user_id');
        return $post_data;
    }
    
    private function _get_add_cat_form_data()
    {
        $view_data                  = array();
        $view_data['title']         = $this->input->post('title', TRUE);
        if(SLUG_ACTIVE>0){
            $view_data['slug'] = $this->input->post('slug', TRUE);
        }
        if($this->is_postback())
        {
            $view_data['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $view_data['categories_combobox']   = $this->download_categories_model->
                                                    get_download_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->input->post('lang', TRUE)
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        else
        {
            $view_data['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('download_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $view_data['categories_combobox']   = $this->download_categories_model->
                                                    get_download_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->phpsession->get('download_cat_lang')
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        $view_data['header']        = 'Thêm phân loại tài liệu';
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['submit_uri']    = DOWNLOAD_CAT_ADMIN_BASE_URL.'/add';
        return $view_data;
    }
    
    function edit()
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_cat())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options  += $this->_get_edit_cat_form_data();

        $options['header']        = 'Sửa phân loại tài liệus';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = DOWNLOAD_CAT_ADMIN_BASE_URL.'/edit';

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại tài liệu' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('title', 'Tên phân loại', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        if($this->form_validation->run())
        {
            $post_data = $this->_get_posted_cat_data();
            $post_data['id'] = $this->input->post('id');
            $position_edit = $this->download_categories_model->position_to_edit_download_cat(array(
                'id'=>$post_data['id'],
                'lang'=>$post_data['lang'],
                'parent_id'=>$post_data['parent_id'],
            ));
            $post_data['position'] = $position_edit;
            $this->download_categories_model->update($post_data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_DOWNLOAD_CATEGORIES,'type_id'=>$post_data['id']));
            }
            redirect(DOWNLOAD_CAT_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }
    
    private function _get_edit_cat_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $categories = $this->download_categories_model->get_download_categories(array('id' => $id));
            $title      = $categories->title;
            $parent_id = $categories->parent_id;
            $lang = $categories->lang;
            if(SLUG_ACTIVE>0){
                $slug = $categories->slug;
            }
        }
        else
        {
            $title      = my_trim($this->input->post('title', TRUE));
            $parent_id = $this->input->post('categories_combobox', TRUE);
            $lang = $this->input->post('lang', TRUE);
            if(SLUG_ACTIVE>0){
                $slug = $this->input->post('slug', TRUE);
            }
        }
        $options = array();
        $options['id'] = $id;
        $options['title'] = $title;
        if(SLUG_ACTIVE>0){
            $options['slug'] = $slug;
        }
        $options['categories_combobox'] = $this->download_categories_model->get_download_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"', 'notid' => $id));
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        return $options;
    }
    
    function delete()
    {
        $options = array();
        if($this->is_postback()){
            // download.type = download_categories.id (id)
            $id = $this->input->post('id');
            $check_download = $this->download_model->get_download_count(array('type'=>$id));
            $categories = $this->download_categories_model->count_download_categories(array('parent_id' => $id));
            if($check_download > 0 || $categories > 0){
                $options['error'] = 'Không thể xóa phân loại này vì vẫn tồn tại tài liệu hoặc phân loại con';
            }
            else{
                if(SLUG_ACTIVE>0){
                    $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_DOWNLOAD_CATEGORIES,'onehit'=>TRUE));
                    if(!empty($check_slug)){
                        $this->slug_model->delete($check_slug->id);
                    }
                }
                $this->download_categories_model->delete($id);
                $options['warning'] = 'Đã xóa thành công';
            }
        }
        $lang = $this->phpsession->get('download_cat_lang');
        redirect(DOWNLOAD_CAT_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function get_download_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        if (!$this->input->post('is_add_edit')) {
            echo $this->download_categories_model->get_download_categories_combo(array('lang' => $lang, 'extra' => 'class="btn"'));
        } else {
            echo $this->download_categories_model->get_download_categories_combo(array('lang' => $lang, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        }
    }

    function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('download_cat_lang');
        $this->download_categories_model->item_to_sort_download_cat(array('id' => $id));
        redirect(DOWNLOAD_CAT_ADMIN_BASE_URL . '/' . $lang);
    }

}