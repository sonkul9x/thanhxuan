<?php
class Orders extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }

    public function add_to_cart()
    {
//        $this->cart->destroy();die;
        $product_id = $this->input->post('id', TRUE);
        $product = $this->products_model->get_products(array('id' => $product_id));
        
        $flag = FALSE;
        $carts = $this->cart->contents();

        foreach($carts as $cart)
        {
            if($cart['id'] == $product_id)
            {
                $rowid      = $cart['rowid'];
                $quantity   = $cart['qty'];
                $flag       = TRUE;
                break;
            }
        }
        if(!$flag)
        {
            $data = array(
                'id'        => $product_id,
                'qty'       => 1,
                'price'     => $product->price,
                'name'      => $product->product_name,
                'cat_name'  => $product->category,
                'cat_id'    => $product->categories_id,
                'images'    => $product->image_name
            );
            if(SLUG_ACTIVE>0){
                $data['slug'] = $product->slug;
            }
            $this->cart->insert($data);
        }
        else
        {
            $data = array(
              'rowid' => $rowid,
               'qty'   => $quantity + 1
            );
            $this->cart->update($data);
        }
            //redirect(PRODUCTS_CART_URL, 'refresh');
    }
    
    public function remove_cart()
    {
        $id = $this->input->post('id');
        $data = array(
          'rowid' => $id,
           'qty'   => 0
        );
        $this->cart->update($data);
    }
    
    public function update_cart()
    {
        $id         = $this->input->post('id');
        $quantity   = $this->input->post('quantity');
        $data = array(
          'rowid' => $id,
           'qty'   => $quantity,
        );
        $this->cart->update($data);
    }
    
    
    public function cart($para1='vi')
    {
        $options = array('lang'=>switch_language($para1));

        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
//            $uri = '/'.$options['lang'].'/'.$this->uri->segment(2);
            $uri = get_uri_by_lang($options['lang'],'cart');
        }else{
            $uri = '/' . $this->uri->segment(1);
        }

        $view_data = array();

//        if(!empty($ok_message)){
//            $view_data['succeed'] = $this->phpsession->get('ok_order_message');
//        }
        
        if($this->is_postback())
        {
             if (!$this->_do_add_order())
                $options['error'] = validation_errors();
             else
                $options['succeed'] = $this->phpsession->get('ok_order_message');
        }

        $view_data = $this->get_add_order_form();
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning']))
            $view_data['options'] = $options;
        
        $this->phpsession->clear('ok_order_message');
        
        $view_data['current_menu'] = $uri;
        
        $view_data['title'] = __('IP_cart_shopping_title');

        $this->_view_data['main_content'] = $this->load->view('cart',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    private function get_add_order_form()
    {
        $view_data = array(
            'fullname' => $this->input->post('fullname', TRUE),
            'tel' => $this->input->post('tel', TRUE),
            'email' => $this->input->post('email', TRUE),
            'address' => $this->input->post('address', TRUE),
            'message' => $this->input->post('address', TRUE),
            'submit_uri' => get_url_by_lang(get_language(),'cart'),
        );

        return $view_data;

    }
    private function _do_add_order($options = array())
    {
        $this->form_validation->set_rules('fullname', __('IP_fullname'), 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('tel', __('IP_tel'), 'trim|required|max_length[20]|xss_clean');
        $this->form_validation->set_rules('email', __('IP_email'), 'trim|required|max_length[255]|xss_clean|valid_email');
        $this->form_validation->set_rules('address', __('IP_address'), 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('message', __('IP_message'), 'trim|max_length[255]|xss_clean');

        if ($this->form_validation->run($this))
        {
            $order_data = array(
                'sale_date' => date('Y-m-d H:i:s'),
                'total'     => $this->cart->total(),
                'order_status'  => PRODUCTS_NEW_ORDER,
                'fullname'  => $this->input->post('fullname', TRUE),
                'address'   => $this->input->post('address', TRUE),
                'tel'     => $this->input->post('tel', TRUE),
                'email'     => $this->input->post('email', TRUE),
                'message'     => $this->input->post('message', TRUE),
                'create_time'   => now(),
                'update_time' => now(),
                'current_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $order_id = $this->orders_model->insert($order_data);

            $carts = $this->cart->contents();

            foreach($carts as $cart)
            {
                $order_details_data = array(
                    'order_id'      => $order_id,
                    'product_id'    => $cart['id'],
                    'quantity'      => $cart['qty'],
                    'price'      => $cart['price'],
                );
                $this->orders_details_model->insert($order_details_data);
            }

            // gửi mail cho khách hàng
            $this->_send_email_invoice($order_data, $order_id);
            $this->cart->destroy();
            
            $complete_msg = 'ĐƠN HÀNG CỦA QUÝ KHÁCH ĐÃ ĐƯỢC GỬI CHO CHÚNG TÔI. 
                Chúng tôi sẽ liên hệ với quý khách trong thời gian sớm nhất. 
                Chi tiết đơn hàng đã được chúng tôi gửi đến email của bạn.';
            $this->phpsession->save('ok_order_message', $complete_msg);

            //redirect(PRODUCTS_CART_URL);
            return TRUE;
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }

    private function _send_email_invoice($data = array(), $order_id = 0)
    {
        $carts = $this->cart->contents();
        //$this->load->library('email');
        $data['order_id']       = $order_id;
        $config                 = modules::run('configurations/get_configuration', array('array' => TRUE));
        $email_content          = str_replace('{cong_ty}', DEFAULT_COMPANY, $config['order_email_content']);
        $email_content          = str_replace('{ten_nguoi_dat}', $data['fullname'], $email_content);
        $email_content          = str_replace('{ma_don_hang}', $data['order_id'], $email_content);
        $email_content          = str_replace('{gio_dat}', date('H:i:s', strtotime($data['sale_date'])), $email_content);
        $email_content          = str_replace('{ngay_dat}', date('d/m/Y', strtotime($data['sale_date'])), $email_content);
        $email_content          = str_replace('{dia_chi}', $data['address'], $email_content);
        $email_content          = str_replace('{dien_thoai}', $data['tel'], $email_content);
        $email_content          = str_replace('{email}', $data['email'], $email_content);
        $all_product = '';
        foreach ($carts as $cart)
        {
            $all_product .= '<tr>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">MS'. $cart['id'] .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" >' . $cart['name'] . '</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . $cart['qty'] .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . get_price_in_vnd($cart['price']) .'</td>
                <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>' . get_price_in_vnd($cart['price'] * $cart['qty']) . 'VNĐ</b></td>
            </tr>';
        }
        $product_table = '<table style="border:solid 1px #CCCCCC" width="100%" cellspacing="0" >
            <tbody>
                <tr style="background-color:#f1f1f1">
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Mã số</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px"><b>Tên</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Số lượng</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Đơn giá</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Thành tiền</b></td>
                </tr>' . $all_product . '
                <tr>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right" colspan="4"><b>Tổng tiền hàng:</b></td>
                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b><font color="#000088">' . get_price_in_vnd($data['total']) .'VNĐ</font></b>
                        <br>Chưa bao gồm chi phí vận chuyển</td>
                </tr>
            </tbody>
        </table>';
        
        $email_content          = str_replace('{danh_sach_san_pham}', $product_table, $email_content);
        $data['email_content']  = $email_content;
        $title                  = DOMAIN_NAME . ' Đơn đặt hàng số ' . $order_id;
        $message                = $this->load->view('email', $data, TRUE);
        
        $order_email = ($config['order_email'] != '' && $config['order_email'] != NULL) ? $config['order_email'] : ORDER_EMAIL;
        
        $this->email->from(ORDER_EMAIL, DEFAULT_COMPANY);
        $this->email->subject($title);
        $this->email->message($message);
        $this->email->to($data['email']);
        $this->email->cc($order_email);
        //$this->email->bcc('them@their-example.com');
        $this->email->send();
    }

    //yet change nmd
    public function show_invoice($options = array())
    {
        $orders_details                 = $this->orders_model->get_orders_details($options);
        $orders                         = $this->orders_model->get_orders($options);
        if(!is_object($orders)) show_404();
        if($this->phpsession->get('user_id') != $orders->user_id && !modules::run('auth/auth/has_permission', array('operation' => OPERATION_MANAGE))) redirect('/');
        $view_data                      = array();
        $view_data['orders']            = $orders;
        $view_data['orders_details']    = $orders_details;
        $view_data['cities_array']      = $this->city_model->get_cities_array();
        $this->_title = 'Hóa đơn của bạn  ' . DEFAULT_COMPANY_SUFFIX;
        return $this->load->view('/order/invoice', $view_data, TRUE);
    }
    
}

?>
