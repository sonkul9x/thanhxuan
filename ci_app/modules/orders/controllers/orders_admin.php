<?php
class Orders_Admin extends MY_Controller
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
        $this->_view_data['url'] = ORDER_ADMIN_BASE_URL;
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * @desc: Hien thi danh sach cac bai viet
     * 
     * @param type $options 
     */
    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        
        $this->phpsession->save('orders_lang', $options['lang']);

        $total_row          = $this->orders_model->get_orders_count($options);
        
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
        
        $options['orderss']                  = $this->orders_model->get_orders($options);
        
        $options['post_uri']              = 'orders_admin';
        $options['total_rows']            = $total_row;
        $options['total_pages']           = $total_pages;
        $options['page_links']            = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = ORDER_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = ORDER_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        $options['combo_order']    = $this->utility_model->get_order_status_combo(array('combo_name' => 'order_status', 'order_status'=>$options['order_status'], 'extra' => 'class="btn"'));

        $this->_view_data['main_content'] = $this->load->view('admin/orders_list',$options, TRUE);
        $this->_view_data['title'] = 'Quản lý đơn hàng' . DEFAULT_TITLE_SUFFIX;
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
            $options['email'] = $this->db->escape_str($this->input->post('email', TRUE));
            $options['order_status'] = $this->input->post('order_status');
            $options['start_date'] = $this->input->post('start_date');
            $options['end_date'] = $this->input->post('end_date');
            if(isset($options['start_date']) && $options['start_date']!=''){
                $options['start_date_m'] = strtotime($options['start_date']);
            }
            if(isset($options['end_date']) && $options['end_date']!=''){
                $options['end_date_m'] = strtotime($options['end_date']);
            }
            //search with lang
            $options['lang'] = $this->input->post('lang');
            $this->phpsession->save('orders_search_options', $options);
            
        }
        else
        {
            $temp_options = $this->phpsession->get('orders_search_options');
            if (is_array($temp_options))
            {
                $options['search'] = $temp_options['search'];
                $options['order_status'] = $temp_options['order_status'];
                $options['start_date'] = $temp_options['start_date'];
                $options['end_date'] = $temp_options['end_date'];
            }
            else
            {
                $options['search'] = '';
                $options['order_status'] = DEFAULT_COMBO_VALUE;
                $options['start_date'] = '';
                $options['end_date'] = '';
                $options['email'] = $this->db->escape_str($this->input->get('email', TRUE));
            }
        }
//        $options['offset'] = $this->uri->segment(3);
        return $options;
    }

    private function _get_posted_orders_data()
    {
        $post_data = array(
            'order_status' => my_trim($this->input->post('order_status', TRUE)),
        );
        return $post_data;
    }

    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(ORDER_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_orders())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_orders_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Xem order cua khach' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    /**
     * Chuẩn bị dữ liệu cho form sửa
     * @return type
     */
    private function _get_edit_form_data()
    {
        $id        = $this->input->post('id');

        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $orders         = $this->orders_model->get_orders(array('id' => $id,'one_cod'=>true));
            $orders_detail  = $this->orders_details_model->get_orders_details(array('id' => $id));
            $id             = $orders->id;
            $tel            = $orders->tel;
            $kind_pay       = $orders->kind_pay;
            $message        = $orders->message;
            $order_status   = $orders->order_status;
            $address        = $orders->address;
            $fullname       = $orders->fullname;
            $email          = $orders->email;
            $created_date   = date('m/d/Y', $orders->create_time);
            $reserve_time   = $orders->reserve_time;
            $lang           = $orders->lang;
            $combo_order    = $this->utility_model->get_order_status_combo(array('combo_name' => 'order_status', 'order_status'=> $orders->order_status, 'extra' => 'class="btn"'));
        }
        // khi submit
        else
        {
            $id             = $id;
            $tel            = my_trim($this->input->post('tel', TRUE));
            $order_status   = my_trim($this->input->post('order_status', TRUE));
            $kind_pay       = my_trim($this->input->post('kind_pay', TRUE));
            $message        = my_trim($this->input->post('message', TRUE));
            $address        = $this->input->post('address', TRUE);
            $fullname       = my_trim($this->input->post('fullname', TRUE));
            $email          = my_trim($this->input->post('email', TRUE));
            $created_date   = my_trim($this->input->post('create_time', TRUE));
            $reserve_time   = $this->input->post('reserve_time');
            $combo_order    = $this->utility_model->get_order_status_combo(array('combo_name' => 'order_status', 'order_status'=> $this->input->post('order_status'), 'extra' => 'class="btn"'));
            $lang           = $this->input->post('lang', TRUE);
        }
        $options                  = array();
        $options['id']            = $id;
        $options['tel']           = $tel;
        $options['order_status']  = $order_status;
        $options['kind_pay']      = $kind_pay;
        $options['message']       = $message;
        $options['reserve_time']  = $reserve_time;
        $options['address']       = $address;
        $options['fullname']      = $fullname;
        $options['email']         = $email;
        $options['created_date']  = $created_date;
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'onchange="javascript:get_categories_by_lang();" class="btn"'));
        $options['order_detail']  = $orders_detail;
        $options['combo_order']   = $combo_order;
        $options['header']        = 'Sửa order';
        $options['button_name']   = 'Sửa order';
        $options['submit_uri']    = ORDER_ADMIN_BASE_URL.'/edit';
        $options['scripts']       = $this->_get_scripts();
        return $options;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit_orders()
    {
            $post_data = $this->_get_posted_orders_data();
            $post_data['id'] = $this->input->post('id');
            $this->orders_model->update($post_data);
            $lang = $this->phpsession->get('orders_lang');
            redirect(ORDER_ADMIN_BASE_URL . '/' . $lang);
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
            $this->orders_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('orders_lang');
        redirect(ORDER_ADMIN_BASE_URL . '/' . $lang);
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
        $orders = $this->orders_model->get_orders(array('id' => $id));
        $status = $orders->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->orders_model->update(array('id'=>$id,'status'=>$status));
    }
    
    public function up()
    {
        $orders_id = $this->input->post('id');
        $this->orders_model->update(array('id'=>$orders_id,'updated_time'=>date('Y-m-d H:i:s')));
        $lang = $this->phpsession->get('orders_lang');
        redirect(ORDER_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function export($options = array()) {
        $options = array();
//        if($this->phpsession->get('customer_name_search') != '')
//            $options['keyword'] = $this->phpsession->get('customer_name_search');
//        if(is_array($this->phpsession->get('date_filter'))){
//            $options = array_merge($options, $this->phpsession->get('date_filter'));
//        }
        $options            = array_merge($options, $this->_get_data_from_filter());
        $options['id']        = $this->input->post('id');
   
        $orders = $this->orders_model->get_orders($options);
     
        if (count($orders) > 0) {

            //load our new PHPExcel library
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Order excel');
            //set cell A1 content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', 'STT');
            $this->excel->getActiveSheet()->setCellValue('B1', 'MÃ ĐƠN HÀNG');
            $this->excel->getActiveSheet()->setCellValue('C1', 'NGÀY MUA HÀNG');
            $this->excel->getActiveSheet()->setCellValue('D2', 'HỌ VÀ TÊN');
            $this->excel->getActiveSheet()->setCellValue('D1', 'THÔNG TIN KHÁCH HÀNG');
            $this->excel->getActiveSheet()->setCellValue('E2', 'ĐỊA CHỈ GIAO HÀNG');
            $this->excel->getActiveSheet()->setCellValue('F2', 'SỐ ĐIỆN THOẠI');
            $this->excel->getActiveSheet()->setCellValue('G2', 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('H2', 'NGÀY GIỜ YÊU CẦU GIAO HÀNG');
            $this->excel->getActiveSheet()->setCellValue('I2', 'GHI CHÚ');
            $this->excel->getActiveSheet()->setCellValue('J1', 'CÁC MẶT HÀNG/SỐ LƯỢNG');
            $this->excel->getActiveSheet()->setCellValue('K1', 'THÀNH TIỀN');
            $this->excel->getActiveSheet()->setCellValue('L1', 'HÌNH THỨC THANH TOÁN');
            $this->excel->getActiveSheet()->setCellValue('M1', 'TÌNH TRẠNG ĐƠN HÀNG');

            $this->excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
            //merge cell A1 until D1
            $this->excel->getActiveSheet()->mergeCells('D1:I1');
            //set aligment to center for that merged cell (A1 to D1)
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $stt = 1;
            $row = 3;
            $total_m = 0;
            
            foreach ($orders as $order):
                //các mặt hàng
                
                $order_details = $this->orders_details_model->get_orders_details(array('id' => $order->id));
            
                $order_detail_product = '';
                foreach ($order_details as $product):
                    $order_detail_product.= '[' . $product->product_name;
                    $order_detail_product.= '/' . $product->quantity . '] ';

                endforeach;
                $sale_date = date('d/m/Y', strtotime($order->sale_date));

                $delivery_form = '';
                if ($order->kind_pay == 1){
                $delivery_form = 'Thanh toán khi giao hàng';}
                elseif ($order->kind_pay == 2) 
                    {$delivery_form = 'Thanh toán chuyển khoản ngân hàng';}
                else {$delivery_form = 'Thanh toán tại cửa hàng';}
               
                $total_m+=$order->total;
                $total = get_price_in_vnd($order->total);

                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $stt);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $order->id);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $sale_date);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $order->fullname);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $order->address);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $order->tel);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $order->email);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $order->reserve_time);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $order->message);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $order_detail_product);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $total);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $delivery_form);

                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $order->order_status);

                $stt++;
                $row++;
            endforeach;
            $row++;
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('B' . $row . ':Z' . $row);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "TỔNG TIỀN:");
            
            if ($total_m > 0)
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, get_price_in_vnd($total_m) . ' VNĐ');
            else
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, '0 VNĐ');
            
            $filename = 'dang_sach_hoa_don.xls'; //save our workbook as this file name
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
            return $this->browse(array('error' => 'Mục bạn đã chọn hiện thời không có hóa đơn!'));
        }
    }
    
    function import($options = array()) {
        //load our new PHPExcel library
        $this->load->library('excel');
            
        $path = "test.xlsx";

        $objPHPExcel = PHPExcel_IOFactory::load($path);
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;
            echo "<br>The worksheet ".$worksheetTitle." has ";
            echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
            echo ' and ' . $highestRow . ' row.';
            echo '<br>Data: <table border="1"><tr>';
            for ($row = 1; $row <= $highestRow; ++ $row) {
                echo '<tr>';
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                    echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }

        for ($row = 2; $row <= $highestRow; ++ $row) {
            $val=array();
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
           $cell = $worksheet->getCellByColumnAndRow($col, $row);
           $val[] = $cell->getValue();
        }

         $Connection="INSERT INTO ".$this->db->dbprefix."customers (fullname, email, phone) VALUES ('".$val[1] . "','" . $val[2] . "','" . $val[3]. "')";

        }
    }
    
}
