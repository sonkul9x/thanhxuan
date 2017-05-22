<?php
class Orders_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_permission', array('operation' => OPERATION_MANAGE));
        // Khoi tao cac bien
        $this->_layout = 'admin_ui/layout/main';
    }
    
    /**
     * @desc: Hien thi danh sach cac phan loai tin tuc
     * 
     * @param type $options 
     */
    function browse($para1='vi')
    {
        $options = array('lang'=>switch_language($para1));
        $this->phpsession->save('orders_cat_lang', $options['lang']);

        $options['categories']     = $this->orders_categories_model->get_orders_categories_object_array_by_parent_id(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
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
        $options['meta_title']            = $this->input->post('meta_title');
        $options['meta_keywords']         = $this->input->post('meta_keywords');
        $options['meta_description']      = $this->input->post('meta_description');
        if($this->is_postback())
        {
            $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->orders_categories_model->
                                                    get_orders_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->input->post('lang', TRUE)
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        else
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('orders_cat_lang'), 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
            $options['categories_combobox']   = $this->orders_categories_model->
                                                    get_orders_categories_combo(array('categories_combobox' => 
                                                                                $this->input->post('categories_combobox')
                                                                                , 'is_add_edit_cat' => TRUE
                                                                                , 'lang' => $this->phpsession->get('orders_cat_lang')
                                                                                , 'extra' => 'class="btn"'
                                                                                ));
        }
        return $options;
    }
    
    private function _do_add_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[255]');
        $parent_id = $this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->orders_categories_model->get_level_orders_category(array('parent_id'=>$parent_id));
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
            );
            if($this->input->post('categories_combobox') == DEFAULT_COMBO_VALUE)
            {
               $categories = $this->orders_categories_model->get_orders_categories(array('parent_id' => ROOT_CATEGORY_ID,
                                                                           'last_row' => TRUE));
            }
            else
            {
                $categories = $this->orders_categories_model->get_orders_categories(array('parent_id' => $this->input->post('categories_combobox'),
                                                                            'last_row' => TRUE));
            }
            $data['position'] = is_object($categories) ? $categories->position + 1 : 1;
            $this->orders_categories_model->insert($data);

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
        $cat_id = $this->input->post('cat_id');

        if($this->input->post('from_list'))
        {
            $categories = $this->orders_categories_model->get_orders_categories(array('id' => $cat_id));
            $category   = $categories->category;
            $parent_id  = $categories->parent_id;
            $meta_title             = $categories->meta_title;
            $meta_keywords          = $categories->meta_keywords;
            $meta_description       = $categories->meta_description;
            $lang                   = $categories->lang;
        }
        else
        {
            $category           = $this->input->post('category', TRUE);
            $parent_id          = $this->input->post('categories_combobox', TRUE);
            $meta_title         = $this->input->post('meta_title', TRUE);
            $meta_keywords      = $this->input->post('meta_keywords', TRUE);
            $meta_description   = $this->input->post('meta_description', TRUE);
            $lang               = $this->input->post('lang', TRUE);

        }
        $options = array();

        $options['cat_id'] = $cat_id;
        $options['category'] = $category;
        $options['categories_combobox']   = $this->orders_categories_model->get_orders_categories_combo(array('categories_combobox' => $parent_id, 'lang' => $lang, 'notid' => $cat_id, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
        $options['meta_title']            = $meta_title;
        $options['meta_keywords']         = $meta_keywords;
        $options['meta_description']      = $meta_description;
        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        return $options;
    }

    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('category', 'Tên loại', 'trim|required|xss_clean|max_length[256]');
        $parent_id = $this->input->post('categories_combobox');
        //check level cua parent category -> update +1 level 
        $parent_level = $this->orders_categories_model->get_level_orders_category(array('parent_id'=>$parent_id));
        if($this->form_validation->run())
        {
            $data = array(
                'id'                => $this->input->post('cat_id'),
                'category'          => $this->input->post('category', TRUE),
                'parent_id'         => $parent_id,
                'level'             => $parent_level + 1,
                'meta_title'        => $this->input->post('meta_title', TRUE),
                'meta_keywords'     => $this->input->post('meta_keywords', TRUE),
                'meta_description'  => $this->input->post('meta_description', TRUE),
                'lang'              => $this->input->post('lang', TRUE)
            );
            
            
            $this->orders_categories_model->update($data);

            redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $data['lang']);
        }
        return FALSE;

    }

    function delete()
    {
        if($this->is_postback())
        {
            $cat_id = $this->input->post('cat_id');
            //khong the xoa neu co chuyen muc con
            $check1 = $this->orders_categories_model->get_orders_categories_count(array('parent_id' => $cat_id));
            //khong the xoa neu co bai viet su dung chuyen muc nay
            $check2 = $this->orders_model->get_orders_count(array('cat_id' => $cat_id));
            if($check1 > 0) {
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các mục con';
            } else if($check2 > 0){
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các hỏi đáp trong phân loại';
            } else {
                $this->orders_categories_model->delete($cat_id);
                $options['waring'] = 'Đã xóa thành công';
            }
        }
        $options['lang'] = $this->phpsession->get('orders_cat_lang');
        redirect(FAQ_CAT_ADMIN_BASE_URL . '/' . $options['lang']);
//        return $this->browse($options);
    }
    
    function get_orders_categories_by_lang()
    {
        $lang = $this->input->post('lang', TRUE);
        if(!$this->input->post('is_add_edit'))
            echo $this->orders_categories_model->get_orders_categories_combo(array('lang' => $lang, 'extra' => 'class="btn"'));
        else
            echo $this->orders_categories_model->get_orders_categories_combo(array('lang' => $lang, 'is_add_edit_cat' => TRUE, 'extra' => 'class="btn"'));
    }

}