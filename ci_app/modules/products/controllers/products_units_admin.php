<?php
class Products_Units_Admin extends MY_Controller 
{
    function __construct() {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
    }

    /**
     * Liệt kê danh sách các đề mục
     */
    function browse() {
        $options = array();

        $options['units'] = $this->products_units_model->get_units();
        //$options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/units/list', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Đơn vị' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    /**
     * Xử lý việc thêm đơn vị
     */
    function add() {
        $options = array();
        // Xu ly viec them vao db
        if ($this->is_postback()) {
            if (!$this->_do_add_unit()) {
                $options['error'] = validation_errors();
                $options['options'] = $options;
            }
        }
        $this->_get_form_data($options);

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/units/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm đơn vị' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     *
     * @return type 
     */
    private function _get_form_data(&$options = array()) {
        
        $options['unit']        = $this->input->post('unit');
        $options['header']      = 'Thêm đơn vị';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_UNITS_ADMIN_ADD_URL;
    }

    private function _do_add_unit() {
        $this->form_validation->set_rules('unit', 'Tên đơn vị', 'trim|required|xss_clean|max_length[15]');
        if ($this->form_validation->run()) {
            $data = array(
                'name' => strip_tags($this->input->post('unit')),
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->products_units_model->add_unit($data);

            redirect(PRODUCTS_UNITS_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    /**
     * Xu ly viec sua du lieu
     */
    function edit() {
        $options = array();
        if ($this->is_postback()) {
            if (!$this->input->post('from_list')) {
                if (!$this->_do_edit_unit()) {
                    $options['error'] = validation_errors();
                    $options['options'] = $options;
                }
            }
        }
        $this->_get_edit_unit_form_data($options);
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('admin/units/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title']          = 'Sửa đơn vị' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_unit_form_data(&$options = array()) {
        $id = $this->input->post('id');
        if ($this->input->post('from_list')) {
            $units              = $this->products_units_model->get_units(array('id' => $this->input->post('id')));
            $options['unit']    = $units->name;
        } 
        else
            $options['unit']    = $this->input->post('unit');
        
        $options['id']    = $id;
        $options['header']      = 'Sửa đơn vị';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_UNITS_ADMIN_EDIT_URL;
    }

    private function _do_edit_unit() {
        $this->form_validation->set_rules('unit', 'Tên đơn vị', 'trim|required|xss_clean|max_length[15]');
        if ($this->form_validation->run()) {
            $data = array(
                'id' => $this->input->post('id'),
                'name' => $this->input->post('unit', TRUE),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->products_units_model->update_unit($data);

            redirect(PRODUCTS_UNITS_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    function delete() {
        if ($this->is_postback() && $this->input->post('from_list')) {
            $unit_id = $this->input->post('id');
            $this->products_units_model->delete_unit($unit_id);
            redirect(PRODUCTS_UNITS_ADMIN_BASE_URL);
        }
    }

}