<?php
class Customers_Admin extends MY_Controller
{
    /**
     * Chuan bi cac bien co ban
     */
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        // Khoi tao cac bien
        $this->_layout = 'admin_ui/layout/main';
        // Chuan bi link cho viec phan trang
        $this->_view_data['url'] = CUSTOM_ADMIN_BASE_URL;
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * @desc: Hien thi danh sach cac khach hang dang ky fondend
     * 
     * @param type $options 
     */
    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options            = array('lang'=>$para1,'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('customers_lang', $options['lang']);
        $total_row          = $this->customers_model->get_customers_count($options);
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

        $options['customerss']            = $this->customers_model->get_customers($options);
        $options['post_uri']              = 'customers_admin';
        $options['total_rows']            = $total_row;
        $options['total_pages']           = $total_pages;
        $options['page_links']            = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = CUSTOM_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = CUSTOM_ADMIN_BASE_URL;
        }

        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        $this->_view_data['main_content'] = $this->load->view('admin/customers_list',$options, TRUE);
        $this->_view_data['title'] = 'Quản lý khách hàng' . DEFAULT_TITLE_SUFFIX;
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
            $this->phpsession->save('customers_search_options', $options);
        }
        else
        {
            $temp_options = $this->phpsession->get('customers_search_options');
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

    private function _get_posted_customers_data()
    {
        $post_data = array(
            'fullname' => my_trim($this->input->post('fullname', TRUE)),
            'phone' => my_trim($this->input->post('phone', TRUE)),
            'email' => my_trim($this->input->post('email', TRUE)),
            'address' => my_trim($this->input->post('address', TRUE)),            
        );
        return $post_data;
    }

    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(CUSTOM_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_customers())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        $this->_view_data['main_content'] = $this->load->view('admin/add_customers_form', $options, TRUE);
        $this->_view_data['title'] = 'Xem đơn hàng của khách' . DEFAULT_TITLE_SUFFIX;
        $this->load->view($this->_layout, $this->_view_data);
    }
    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data()
    {
        $id = $this->input->post('id');
        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $customers      = $this->customers_model->get_customers(array('id' => $id));
            $id             = $customers->id;
            $phone          = $customers->phone;
            $address        = $customers->address;
            $fullname       = $customers->fullname;
            $email          = $customers->email;
            $created_date   = $customers->created_date;
           
        }
        // khi submit
        else
        {
            $id             = $id;
            $phone          = my_trim($this->input->post('phone', TRUE));
            $address        = my_trim($this->input->post('address', TRUE));
            $fullname       = my_trim($this->input->post('fullname', TRUE));
            $email          = my_trim($this->input->post('email', TRUE));
            $created_date   = my_trim($this->input->post('created_date', TRUE));
        }
        $options                  = array();
        $options['id']            = $id;
        $options['phone']         = $phone;
        $options['address']       = $address;
        $options['fullname']      = $fullname;
        $options['email']         = $email;
        $options['created_date']  = $created_date;
        $options['header']        = 'Xem chi tiết khách hàng';
        $options['button_name']   = 'Sửa Khách hàng';
        $options['submit_uri']    = CUSTOM_ADMIN_BASE_URL.'/edit';
        $options['scripts']       = $this->_get_scripts();
        return $options;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_customers()
    {      
        $post_data = $this->_get_posted_customers_data();
        $post_data['id'] = $this->input->post('id');
        $this->customers_model->update($post_data);
        $lang = $this->phpsession->get('customers_lang');
        redirect(CUSTOM_ADMIN_BASE_URL . '/' . $lang);
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
            $this->customers_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('customers_lang');
        redirect(CUSTOM_ADMIN_BASE_URL . '/' . $lang);
    }

    private function _get_scripts()
    {
        $scripts = '<script type="text/javascript" src="/plugins/tiny_mce/tiny_mce.js?v=20111006"></script>';
        $scripts .= '<script language="javascript" type="text/javascript" src="/plugins/tiny_mce/plugins/imagemanager/js/mcimagemanager.js?v=20111006"></script>';
        $scripts .= '<script type="text/javascript">enable_advanced_wysiwyg("wysiwyg");</script>';
        return $scripts;
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $customers = $this->customers_model->get_customers(array('id' => $id));
        $status = $customers->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->customers_model->update(array('id'=>$id,'status'=>$status));
    }
    
    public function up()
    {
        $customers_id = $this->input->post('id');
        $this->customers_model->update(array('id'=>$customers_id,'updated_time'=>date('Y-m-d H:i:s')));
        $lang = $this->phpsession->get('customers_lang');
        redirect(CUSTOM_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function export($options = array()) {
        $options = array();
//        if($this->phpsession->get('customer_name_search') != '')
//            $options['keyword'] = $this->phpsession->get('customer_name_search');
//        if(is_array($this->phpsession->get('date_filter'))){
//            $options = array_merge($options, $this->phpsession->get('date_filter'));
//        }
        $options            = array_merge($options, $this->_get_data_from_filter());
        $customers = $this->customers_model->get_customers($options);
        
        if (count($customers) > 0) {

            //load our new PHPExcel library
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Order excel');
            //set cell A1 content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', 'STT');
            $this->excel->getActiveSheet()->setCellValue('B1', 'MÃ KHÁCH HÀNG');
            $this->excel->getActiveSheet()->setCellValue('C1', 'HỌ VÀ TÊN');        
            $this->excel->getActiveSheet()->setCellValue('D1', 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('E1', 'ĐIỆN THOẠI');
            $this->excel->getActiveSheet()->setCellValue('F1', 'ĐỊA CHỈ');
            
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
         
            //set aligment to center for that merged cell (A1 to D1)
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $stt = 1;
            $row = 3;
            $total_m = 0;
            
            foreach ($customers as $order):

                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $stt);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $order->id);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $order->fullname);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $order->email);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $order->phone);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $order->address);

                $stt++;
                $row++;
            endforeach;
            $row++;
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('B' . $row . ':Z' . $row);
      
            $filename = 'dang_sach_khach_hang.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
            // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
            
        }else {
            //hoa don khong co san pham
            return $this->list_customers(array('error' => 'Mục bạn đã chọn hiện thời không có khách hàng nào!'));
        }
    }
    
}