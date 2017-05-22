<?php
class Products_Trademark_Admin extends MY_Controller {
    function __construct() {
        parent::__construct();
        modules::run('auth/auth/validate_login');
        $this->_layout = 'admin_ui/layout/main';
    }

    function browse() {
        $options = array();

        $options['products_trademark'] = $this->products_trademark_model->get_products_trademark();

        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_trademark/list', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thương hiệu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
 
    function add() {
        $options = array();
        // Xu ly viec them vao db
        if ($this->is_postback()) {
            if (!$this->_do_add()) {
                $options['error'] = validation_errors();
                $options['options'] = $options;
            }
        }
        $this->_get_add_form_data($options);

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_trademark/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm Thương hiệu' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     *
     * @return type 
     */
    private function _get_add_form_data(&$options = array()) {
        
        $options['name']        = $this->input->post('name');
        $options['header']      = 'Thêm Thương hiệu';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_TRADEMARK_ADMIN_ADD_URL;
    }

    private function _do_add() {
        $this->form_validation->set_rules('name', 'Thương hiệu', 'trim|required|xss_clean|max_length[255]');
        if ($this->form_validation->run()) {
            $data = array(
                'name' => my_trim($this->input->post('name')),
                'status' => STATUS_ACTIVE,
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->products_trademark_model->insert($data);

            redirect(PRODUCTS_TRADEMARK_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    function edit() {
        $options = array();
        if ($this->is_postback()) {
            if (!$this->input->post('from_list')) {
                if (!$this->_do_edit()) {
                    $options['error'] = validation_errors();
                    $options['options'] = $options;
                }
            }
        }
        $this->_get_edit_form_data($options);
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('admin/products_trademark/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title']          = 'Sửa Thương hiệu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_form_data(&$options = array()) {
        $id = $this->input->post('id');
        if ($this->input->post('from_list')) {
            $trademark = $this->products_trademark_model->get_products_trademark(array('id' => $id));
            $options['name'] = $trademark->name;
        } else {
            $options['name'] = $this->input->post('name');
        }
        $options['id']          = $id;
        $options['header']      = 'Sửa Thương hiệu';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_TRADEMARK_ADMIN_EDIT_URL;
    }

    private function _do_edit() {
        $this->form_validation->set_rules('name', 'Thương hiệu', 'trim|required|xss_clean|max_length[255]');
        if ($this->form_validation->run()) {
            $data = array(
                'id' => $this->input->post('id'),
                'name' => my_trim($this->input->post('name', TRUE)),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->products_trademark_model->update($data);
            redirect(PRODUCTS_TRADEMARK_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    function delete() {
        if ($this->is_postback() && $this->input->post('from_list')) {
            $id = $this->input->post('id');
            $check1 = $this->products_model->get_products_count(array('trademark_id'=>$id));
            if(empty($check1)){
                $this->products_trademark_model->delete($id);
            }
            redirect(PRODUCTS_TRADEMARK_ADMIN_BASE_URL);
        }
    }

}