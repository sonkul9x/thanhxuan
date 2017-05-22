<?php
class Faq_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
    }
    
    /**
     * @desc: Hien thi danh sach cac phan loai tin tuc
     * 
     * @param type $options 
     */
    function browse($para1=DEFAULT_LANGUAGE)
    {
        $options = array('lang'=>switch_language($para1));
        $this->phpsession->save('faq_cat_lang', $options['lang']);

        $options['categories']     = $this->faq_categories_model->get_faq_categories_object_array_by_parent_id(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
        $options['lang_combobox']  = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('cat/list_cat', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại hỏi đáp' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    function add()
    {
        $options    = array();

        if($this->is_postback())
        {
            if (!$this->_do_add_cat())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options                += $this->_get_add_cat_form_data();
        $options['header']      = 'Thêm phân loại hỏi đáp';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = FAQ_CAT_ADMIN_BASE_URL.'/add';

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại hỏi đáp' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_add_cat_form_data()
    {
        $options = array();
        
        $options['category'] = $this->input->post('category');
        if(SLUG_ACTIVE>0){
            $options['slug'] = $this->input->post('slug');
        }
        $options['meta_title']            = $this->input->post('meta_title');
        $options['meta_keywords']         = $this->input->post('meta_keywords');
        $options['meta_description']      = $this->input->post('meta_description');
        if($this->is_postback())
        {
            $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->faq_categories_model->
                                                    get_faq_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->input->post('lang', TRUE)
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        else
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('faq_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->faq_categories_model->
                                                    get_faq_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->phpsession->get('faq_cat_lang')
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        return $options;
    }
    
    private function _do_add_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[255]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->faq_categories_model->get_level_faq_category(array('parent_id'=>$parent_id));
        if($this->form_validation->run())
        {
            $data = array(
                'category'          => strip_tags($this->input->post('category')),
                'parent_id'         => $parent_id,
                'level'             => $parent_level + 1,
                'meta_title'        => $this->input->post('meta_title', TRUE),
                'meta_keywords'     => $this->input->post('meta_keywords', TRUE),
                'meta_description'  => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang', TRUE),
                'creator'           => $this->phpsession->get('user_id'),
                'editor'            => $this->phpsession->get('user_id'),
            );
            $position_add = $this->faq_categories_model->position_to_add_faq_cat(array('lang'=>$data['lang'],'parent_id'=>$parent_id));
            $data['position'] = $position_add;
            $insert_id = $this->faq_categories_model->insert($data);
            if(SLUG_ACTIVE>0){
                if(isset($insert_id)){
                    $this->slug_model->insert_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_FAQ_CATEGORIES,'type_id'=>$insert_id));
                }
            }
            redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;
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

        $options['header']        = 'Sửa phân loại hỏi đáp';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = FAQ_CAT_ADMIN_BASE_URL.'/edit';

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại hỏi đáp' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_cat_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $categories = $this->faq_categories_model->get_faq_categories(array('id' => $id));
            $category   = $categories->category;
            $parent_id  = $categories->parent_id;
            $meta_title             = $categories->meta_title;
            $meta_keywords          = $categories->meta_keywords;
            $meta_description       = $categories->meta_description;
            $lang                   = $categories->lang;
            if(SLUG_ACTIVE>0){
                $slug = $categories->slug;
            }
        }
        else
        {
            $category           = $this->input->post('category', TRUE);
            $parent_id          = $this->input->post('categories_combobox', TRUE);
            $meta_title         = $this->input->post('meta_title', TRUE);
            $meta_keywords      = $this->input->post('meta_keywords', TRUE);
            $meta_description   = $this->input->post('meta_description', TRUE);
            $lang               = $this->input->post('lang', TRUE);
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
        $options['categories_combobox']   = $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'notid' => $id, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        $options['meta_title']            = $meta_title;
        $options['meta_keywords']         = $meta_keywords;
        $options['meta_description']      = $meta_description;
        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        return $options;
    }

    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[256]');
        if(SLUG_ACTIVE>0){
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
        }
        $parent_id = $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->faq_categories_model->get_level_faq_category(array('parent_id'=>$parent_id));
        if($this->form_validation->run())
        {
            $data = array(
                'id'                => $this->input->post('id'),
                'category'          => $this->input->post('category', TRUE),
                'parent_id'         => $parent_id,
                'level'             => $parent_level + 1,
                'meta_title'        => $this->input->post('meta_title', TRUE),
                'meta_keywords'     => $this->input->post('meta_keywords', TRUE),
                'meta_description'  => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang', TRUE),
                'editor'            => $this->phpsession->get('user_id'),
            );
            $position_edit = $this->faq_categories_model->position_to_edit_faq_cat(array(
                'id'=>$data['id'],
                'lang'=>$data['lang'],
                'parent_id'=>$parent_id,
            ));
            $data['position'] = $position_edit;
            $this->faq_categories_model->update($data);
            if(SLUG_ACTIVE>0){
                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug'), TRUE),'type'=>SLUG_TYPE_FAQ_CATEGORIES,'type_id'=>$data['id']));
            }
            redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;

    }

    function delete()
    {
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            //khong the xoa neu co chuyen muc con
            $check1 = $this->faq_categories_model->get_faq_categories_count(array('parent_id' => $id));
            //khong the xoa neu co bai viet su dung chuyen muc nay
            $check2 = $this->faq_model->get_faq_count(array('cat_id' => $id));
            if($check1 > 0) {
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các mục con';
            } else if($check2 > 0){
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các hỏi đáp trong phân loại';
            } else {
                if(SLUG_ACTIVE>0){
                    $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_FAQ_CATEGORIES,'onehit'=>TRUE));
                    if(!empty($check_slug)){
                        $this->slug_model->delete($check_slug->id);
                    }
                }
                $this->faq_categories_model->delete($id);
                $options['waring'] = 'Đã xóa thành công';
            }
        }
        $lang = $this->phpsession->get('faq_cat_lang');
        redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function get_faq_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        $id = $this->input->post('id', TRUE);
        if (!$this->input->post('is_add_edit')) {
            echo $this->faq_categories_model->get_faq_categories_combo(array('lang' => $lang, 'notid' => $id,'extra' => 'class="btn"'));
        } else {
            echo $this->faq_categories_model->get_faq_categories_combo(array('lang' => $lang, 'notid' => $id,'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        }
    }
    
    function up()
    {
        $id = $this->input->post('id', TRUE);
        $lang = $this->phpsession->get('faq_cat_lang');
        $this->faq_categories_model->item_to_sort_faq_cat(array('id' => $id));
        redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $lang);
    }

}