<?php
class Menus_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = MENUS_CAT_ADMIN_BASE_URL;
    }
    
    /**
     * @desc: Hien thi danh sach cac phan loai
     * 
     * @param type $options 
     */
    function browse($options = array())
    {
        $options['categories']     = $this->menus_categories_model->get_menus_categories();
        
        if (isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) {
            $options['options'] = $options;
        }

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('cat/list_cat', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại menu' . DEFAULT_TITLE_SUFFIX;
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
        $options['header']      = 'Thêm phân loại menu';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = MENUS_CAT_ADMIN_ADD_URL;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại menu' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_add_cat_form_data()
    {
        $options = array();
        
        $options['name'] = $this->input->post('name');
        
        return $options;
    }
    
    private function _do_add_cat()
    {
        $this->form_validation->set_rules('name', 'Tên phân loại', 'trim|required|xss_clean|max_length[256]');
        if($this->form_validation->run())
        {
            $data = array(
                'name' => my_trim($this->input->post('name', TRUE)),
                'status' => STATUS_ACTIVE,
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->menus_categories_model->add_menus_category($data);

            redirect(MENUS_CAT_ADMIN_BASE_URL);
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

        $options['header']        = 'Sửa phân loại menu';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = MENUS_CAT_ADMIN_EDIT_URL;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/add_cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại menu' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_cat_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $categories = $this->menus_categories_model->get_menus_categories(array('id' => $id));
            $name       = $categories->name;
        }
        else
        {
            $name = $this->input->post('name');

        }
        $options = array();

        $options['id']   = $id;
        $options['name']     = $name;
        return $options;
    }

    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('name', 'Tên phân loại menu', 'trim|required|xss_clean|max_length[255]');
        if($this->form_validation->run())
        {
            $data = array(
                'id'            => $this->input->post('id'),
                'name'          => $this->input->post('name', TRUE),
                'editor'        => $this->phpsession->get('user_id'),
            );
            $this->menus_categories_model->update_menus_category($data);

            redirect(MENUS_CAT_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    function delete()
    {
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            //khong the xoa neu co menus trong phan loai
            $check = $this->menus_model->count_menus(array('cat_id' => $id));
            if($check > 0) {
                $options['error'] = 'Không thể xóa phân loại này vì vẫn còn các menus trong phân loại';
            } else {
                $this->menus_categories_model->delete_menus_category($id);
                $options['waring'] = 'Đã xóa thành công';
            }
        }
        //return $this->browse($options);
        redirect(MENUS_CAT_ADMIN_BASE_URL);
    }

}