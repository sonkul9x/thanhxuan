<?php
class Products_Coupon_Admin extends MY_Controller {
    function __construct() {
        parent::__construct();
        modules::run('auth/auth/validate_login');
        $this->_layout = 'admin_ui/layout/main';
    }

    function browse($para1=DEFAULT_LANGUAGE, $para2=1) {
        $options = array('lang'=>switch_language($para1),'page'=>$para2);
        $options = array_merge($options, $this->_get_data_from_filter());
        $total_row = $this->products_coupon_model->get_products_coupon_count($options);
        $total_pages = (int)($total_row / PRODUCTS_ADMIN_PRODUCT_PER_PAGE);
        if ($total_pages * PRODUCTS_ADMIN_PRODUCT_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * PRODUCTS_ADMIN_PRODUCT_PER_PAGE;
        $options['limit'] = PRODUCTS_ADMIN_PRODUCT_PER_PAGE;
        
        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);
        $options['page_links']    = $this->pagination->create_ajax_links();
        $options['products_coupon'] = $this->products_coupon_model->get_products_coupon($options);
        $options['total_rows']    = $total_row;
        $options['total_pages']   = $total_pages;
        $options['page']          = $options['page'];
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = PRODUCTS_COUPON_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = PRODUCTS_COUPON_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/products_coupon/list', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Mã coupon' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search'] = $this->db->escape_str($this->input->post('search', TRUE));
            $this->phpsession->save('products_coupon_search_options', $options);
        }
        else
        {
            $temp_options = $this->phpsession->get('products_coupon_search_options');
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
        $this->_view_data['main_content'] = $this->load->view('admin/products_coupon/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm Mã coupon' . DEFAULT_TITLE_SUFFIX;

        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     *
     * @return type 
     */
    private function _get_add_form_data(&$options = array()) {
        $options['name'] = $this->input->post('name');
        $options['discount_type'] = $this->input->post('discount_type');
        $options['discount'] = $this->input->post('discount');
        $options['price_min'] = $this->input->post('price_min');
//        $options['number'] = $this->input->post('number');
        $options['count'] = $this->input->post('count');
        if($this->is_postback())
        {
            $end_date = datetimepicker_array2($this->input->post('end_date', TRUE));
            $options['end_date'] = date('d-m-Y H:i',mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']));
        }else{
            $options['end_date'] = date('d-m-Y H:i');
        }
        $options['header']      = 'Thêm Mã coupon';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_COUPON_ADMIN_ADD_URL;
    }

    private function _do_add() {
        $this->form_validation->set_rules('name', 'Tên coupon', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount', 'Giảm giá', 'trim|required|xss_clean|is_numeric');
        $this->form_validation->set_rules('discount_type', 'Hình thức giảm giá', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price_min', 'Số tiền tối thiểu của đơn hàng', 'trim|xss_clean|is_numeric');
        $this->form_validation->set_rules('end_date', 'Ngày hết hạn', 'trim|required|xss_clean');
//        $this->form_validation->set_rules('number', 'Số lần sử dụng', 'trim|xss_clean|is_numeric');
        $this->form_validation->set_rules('count', 'Số lượng mã', 'trim|xss_clean|is_numeric');
        if ($this->form_validation->run()) {
            $data = array(
                'name' => my_trim($this->input->post('name')),
                'discount' => my_trim($this->input->post('discount')),
                'discount_type' => my_trim($this->input->post('discount_type')),
                'price_min' => my_trim($this->input->post('price_min')),
//                'number' => my_trim($this->input->post('number')),
                'number' => 1,
                'count' => my_trim($this->input->post('count')),
                'status' => STATUS_ACTIVE,
                'creator' => $this->phpsession->get('user_id'),
                'editor' => $this->phpsession->get('user_id'),
            );
            $end_date = datetimepicker_array2($this->input->post('end_date', TRUE));
            $data['end_date'] = date('Y-m-d H:i:s',mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']));

            $insert_id = $this->products_coupon_model->insert($data);
            if($insert_id){
                $character_set = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $existing_strings = $this->get_string_all_coupon();
                $string_length = 10;
                $number_of_strings = $data['count'];
                $random_string = createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings);
                $random_array = @explode(', ', $random_string);
                if(!empty($random_array)){
                    foreach($random_array as $key => $value){
                        $this->products_coupon_item_model->insert(array('code'=>$value,'coupon_id'=>$insert_id));
                    }
                }
            }
            redirect(PRODUCTS_COUPON_ADMIN_BASE_URL);
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
        $this->_view_data['main_content']   = $this->load->view('admin/products_coupon/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title']          = 'Sửa Mã coupon' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_form_data(&$options = array()) {
        $id = $this->input->post('id');
        if ($this->input->post('from_list')) {
            $coupon = $this->products_coupon_model->get_products_coupon(array('id' => $id));
            $options['name'] = $coupon->name;
            $options['discount_type'] = $coupon->discount_type;
            $options['discount'] = $coupon->discount;
            $options['price_min'] = $coupon->price_min;
            $options['end_date'] = date('d-m-Y H:i', strtotime($coupon->end_date));
//            $options['number'] = $coupon->number;
            $options['count'] = $coupon->count;
        } else {
            $options['name'] = $this->input->post('name');
            $options['discount_type'] = $this->input->post('discount_type');
            $options['discount'] = $this->input->post('discount');
            $options['price_min'] = $this->input->post('price_min');
            $end_date = datetimepicker_array2($this->input->post('end_date', TRUE));
            $options['end_date'] = date('Y-m-d H:i',mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']));
//            $options['number'] = $this->input->post('number');
            $options['count'] = $this->input->post('count');
        }
        $options['id']          = $id;
        $options['header']      = 'Sửa Mã coupon';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = PRODUCTS_COUPON_ADMIN_EDIT_URL;
        $options['is_edit'] = TRUE;
    }

    private function _do_edit() {
        $this->form_validation->set_rules('name', 'Tên coupon', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount', 'Giảm giá', 'trim|required|xss_clean|is_numeric');
        $this->form_validation->set_rules('discount_type', 'Hình thức giảm giá', 'trim|required|xss_clean');
        $this->form_validation->set_rules('price_min', 'Số tiền tối thiểu của đơn hàng', 'trim|xss_clean|is_numeric');
        $this->form_validation->set_rules('end_date', 'Ngày hết hạn', 'trim|required|xss_clean');
//        $this->form_validation->set_rules('number', 'Số lần sử dụng', 'trim|xss_clean|is_numeric');
        $this->form_validation->set_rules('count', 'Số lượng mã', 'trim|xss_clean|is_numeric');
        if ($this->form_validation->run()) {
            $data = array(
                'id' => $this->input->post('id'),
                'name' => my_trim($this->input->post('name', TRUE)),
                'discount' => my_trim($this->input->post('discount', TRUE)),
                'discount_type' => my_trim($this->input->post('discount_type', TRUE)),
                'price_min' => my_trim($this->input->post('price_min', TRUE)),
//                'number' => my_trim($this->input->post('number', TRUE)),
                'number' => 1,
                'count' => my_trim($this->input->post('count', TRUE)),
                'editor' => $this->phpsession->get('user_id'),
            );
            $end_date = datetimepicker_array2($this->input->post('end_date', TRUE));
            $data['end_date'] = date('Y-m-d H:i:s',mktime($end_date['hour'],$end_date['minute'],$end_date['second'],$end_date['month'],$end_date['day'],$end_date['year']));

            $this->products_coupon_model->update($data);
            redirect(PRODUCTS_COUPON_ADMIN_BASE_URL);
        }
        return FALSE;
    }

    function delete() {
        if ($this->is_postback() && $this->input->post('from_list')) {
            $id = $this->input->post('id');
            $this->products_coupon_model->delete($id);
            $this->products_coupon_item_model->delete(array('coupon_id'=>$id));
            redirect(PRODUCTS_COUPON_ADMIN_BASE_URL);
        }
    }

    function change_status()
    {
        $id = $this->input->post('id');
        $data = $this->products_coupon_model->get_products_coupon(array('id' => $id));
        $status = $data->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->products_coupon_model->update(array('id'=>$id,'status'=>$status));
    }
    
    function get_string_all_coupon()
    {
        $all_coupon = $this->products_coupon_item_model->get_products_coupon_item(array('status'=>STATUS_ACTIVE));
        if(!empty($all_coupon)){
            $all_string = '';
            foreach($all_coupon as $key => $value){
                $all_string .= $value->code . ', ';
            }
        }else{
            $all_string = '';
        }
        return rtrim($all_string, ", ");
    }

}