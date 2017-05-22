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

    

    private function coupon($coupon_code=NULL)

    {

   //  $coupon_code = $this->input->post('coupon_code', TRUE);

        if(!empty($coupon_code)){

            $coupon_data = $this->products_coupon_item_model->get_products_coupon_item(array('code'=>$coupon_code));

            if(!empty($coupon_data)){

                $total = $this->cart->total();

                if($coupon_data->coupon_status == STATUS_ACTIVE && $coupon_data->status == STATUS_ACTIVE){

                    $check1 = 1;

                }

                $end_date = strtotime($coupon_data->end_date);

                if($end_date >= now()){

                    $check2 = 2;

                }

                if($coupon_data->price_min <= $total){

                    $check3 = 3;

                }

                if($check1 == 1 && $check2 == 2 && $check3 == 3){

                    if($coupon_data->discount_type == 1){

                        $discount = ($coupon_data->discount/100)*$total;

                        $total = $total - round($discount,0);

                    }elseif($coupon_data->discount_type == 2){

                        $total = $total - $coupon_data->discount;          

                    }

                    return $total;

                }

                return 0;

                

            }else{

                return 0;

            }

        }else{

            return 0;

        }

        

    }



    public function add_to_cart()

    {

//        $this->cart->destroy();die;

        $product_id = $this->input->post('id', TRUE);

        $product_size = $this->input->post('size', TRUE);

        $quantity = $this->input->post('qty', TRUE);

        $product = $this->products_model->get_products(array('id' => $product_id));

        

        $flag = FALSE;

        $carts = $this->cart->contents();



        foreach($carts as $cart)

        {

            if($cart['id'] == $product_id)

            {

                $rowid      = $cart['rowid'];

                $quantity   = $cart['qty'];

                $size       = $product_size;
                
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

                'images'    => $product->image_name,

                'size'      => $product_size,

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

        $view_data = array();

        

        $coupon_code = $this->input->post('coupon_code', TRUE);

        

        if ($this->is_postback()) {

            if(empty($coupon_code)){

                $options['error'] = "Mã giảm giá chưa chính xác.";

            }else{

                $total_discount = $this->coupon($coupon_code);

                if($total_discount==0){

                    $options['error'] = "Mã giảm giá chưa chính xác.";

                }else{

                    $options['succeed'] = "Mã giảm giá chính xác.";

                }

                

                $this->phpsession->save('total_discount', '0');

                $this->phpsession->save('total_discount', $total_discount);

                $this->phpsession->save('coupon_code', '');

                $this->phpsession->save('coupon_code', $coupon_code);

                

                $view_data['total_discount'] = $total_discount;

                $view_data['coupon_code'] = $coupon_code;

            }

        }else{

            $this->phpsession->save('total_discount', '0');

            $this->phpsession->save('coupon_code', '');

            $view_data['total_discount'] = 0;

            $view_data['coupon_code'] = '';

        }



        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){

            $uri = get_uri_by_lang($options['lang'],'cart');

        }else{

            $uri = '/' . $this->uri->segment(1);

        }

  

        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning']))

            $view_data['options'] = $options;



        $view_data['current_menu'] = $uri;

        

        $view_data['is_one_col'] = true;

        

        $view_data['title'] = __('IP_cart_shopping_title');



        $this->_view_data['main_content'] = $this->load->view('cart',$view_data, TRUE);



        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }



    private function _send_email_invoice($data = array())

    {

        $carts = $this->cart->contents();

        $data['discount'] = $data['total'] - $data['total_discount'];

        //$this->load->library('email');

//        $data['order_id']       = $order_id;

        $config                 = modules::run('configurations/get_configuration', array('array' => TRUE));

        $email_content          = str_replace('{cong_ty}', DEFAULT_COMPANY, $config['order_email_content']);

        $email_content          = str_replace('{ten_nguoi_dat}', $data['fullname'], $email_content);

        $email_content          = str_replace('{ma_don_hang}', $data['order_id'], $email_content);

        $email_content          = str_replace('{gio_dat}', date('H:i:s', strtotime($data['sale_date'])), $email_content);

        $email_content          = str_replace('{ngay_dat}', date('d/m/Y', strtotime($data['sale_date'])), $email_content);

        $email_content          = str_replace('{dia_chi}', $data['address'], $email_content);

        $email_content          = str_replace('{dien_thoai}', $data['tel'], $email_content);

        $email_content          = str_replace('{email}', $data['email'], $email_content);

        $email_content          = str_replace('{message}', $data['message'], $email_content);

        $all_product = '';

        foreach ($carts as $cart)

        {

            $all_product .= '<tr>

                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">MS'. $cart['id'] .'</td>

                <td style="border:solid 1px #CCCCCC;padding:5px" >' . $cart['name'] . '</td>

                <td style="border:solid 1px #CCCCCC;padding:5px" >' . $cart['size'] . '</td>

                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . $cart['qty'] .'</td>

                <td style="border:solid 1px #CCCCCC;padding:5px" align="right">' . get_price_in_vnd($cart['price']) .'</td>

                <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>' . get_price_in_vnd($cart['price'] * $cart['qty']) . 'VNĐ</b></td>

            </tr>';

        }

        if($data['total_discount'] > 0 && $data['discount'] > 0 && $data['coupon_code'] <> ''){

            $product_discount = '<tr>

                                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right" colspan="5"><b>Giảm giá:</b><br>Mã giảm giá: <b>'.$data['coupon_code'].'</b></td>

                                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b><font color="#000088">-' . get_price_in_vnd($data['discount']) .'VNĐ</font></b></td>

                                </tr>

                                <tr>

                                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right" colspan="5"><b>Tổng tiền cần thanh toán:</b></td>

                                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b><font color="#000088">' . get_price_in_vnd($data['total_discount']) .'VNĐ</font></b>

                                    <br><i style="font-size:10px;">(Chưa bao gồm chi phí vận chuyển)</i></td>

                                </tr>';

        }else{

            $product_discount = '';

        }

        $product_table = '<table style="border:solid 1px #CCCCCC" width="100%" cellspacing="0" >

            <tbody>

                <tr style="background-color:#f1f1f1">

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Mã số</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px"><b>Tên</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px"><b>Kích cỡ</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Số lượng</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Đơn giá</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b>Thành tiền</b></td>

                </tr>' . $all_product . '

                <tr>

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right" colspan="5"><b>Tổng tiền hàng:</b></td>

                    <td style="border:solid 1px #CCCCCC;padding:5px" align="right"><b><font color="#000088">' . get_price_in_vnd($data['total']) .'VNĐ</font></b></td>

                </tr>'.$product_discount.'

            </tbody>

        </table>';

        

        $email_content          = str_replace('{danh_sach_san_pham}', $product_table, $email_content);

        $data['email_content']  = $email_content;

        $title                  = ' Đơn đặt hàng từ ' . DEFAULT_COMPANY;

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

    

    

    public function info_pay($para1 = 'vi') {

        $options = array('lang' => switch_language($para1));



        if ((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi') {

//            $uri = '/'.$options['lang'].'/'.$this->uri->segment(2);

            $uri = get_uri_by_lang($options['lang'], 'cart');

        } else {

            $uri = '/' . $this->uri->segment(1);

        }



        $view_data = array();

        

        $total_discount = $this->phpsession->get('total_discount');

        $coupon_code = $this->phpsession->get('coupon_code');

        

        if ($this->is_postback()) {

            if (!$this->_do_add_order(array('total_discount'=>$total_discount,'coupon_code'=>$coupon_code)))

                $options['error'] = validation_errors();

            else

                $options['succeed'] = $this->phpsession->get('ok_order_message');

        }



        $view_data = $this->get_add_order_form();



        if (isset($options['error']) || isset($options['succeed']) || isset($options['warning']))

            $view_data['options'] = $options;



        $this->phpsession->clear('ok_order_message');



        $view_data['kind_pay'] = array(

            '1' => 'Thanh toán khi nhận hàng',

            '2' => 'Thanh toán chuyển khoản ngân hàng',

            '3' => 'Thanh toán tại cửa hàng',

        );

 

        $view_data['current_menu'] = $uri;

        

        $view_data['total_discount'] = $total_discount;



        $view_data['title'] = __('IP_info_people_payment');

        $view_data['is_one_col'] = true;

        $this->_view_data['main_content'] = $this->load->view('info_pay', $view_data, TRUE);



        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }



    private function get_add_order_form() {

//        $user_id = $this->phpsession->get('user_id');

//        if ($this->is_logged_in())

//            $user = $this->customers_model->get_customers(array('user_id' => $this->phpsession->get('user_id'), 'last_row' => TRUE));

        if (!$this->is_postback()) {

            $view_data = array(

                'user_id' => $this->phpsession->get('user_id_cus'),

                'fullname' => $this->phpsession->get('fullname_cus'),

                'tel' => $this->phpsession->get('phone'),

                'email' => $this->phpsession->get('email_cus'),

                'address' => $this->phpsession->get('address'),

                'message' => $this->phpsession->get('message'),

                'submit_uri' => get_url_by_lang(get_language(), 'info-payment'),

                'scripts' => $this->_scripts(),

            );

            

        } else {

            $view_data = array(

                'fullname' => $this->input->post('fullname', TRUE),

                'tel' => $this->input->post('tel', TRUE),

                'email' => $this->input->post('email', TRUE),

                'address' => $this->input->post('address', TRUE),

                'message' => $this->input->post('message', TRUE),

                'submit_uri' => get_url_by_lang(get_language(), 'info-payment'),

                'scripts' => $this->_scripts(),

            );

        }

        

        return $view_data;

    }



    private function _do_add_order($options = array()) {

        $this->form_validation->set_rules('fullname', __('IP_fullname'), 'trim|required|max_length[255]|xss_clean');

        $this->form_validation->set_rules('tel', __('IP_tel'), 'trim|required|max_length[20]|xss_clean');

        $this->form_validation->set_rules('email', __('IP_email'), 'trim|required|max_length[255]|xss_clean|valid_email');

        $this->form_validation->set_rules('address', __('IP_address'), 'trim|required|max_length[255]|xss_clean');

        $this->form_validation->set_rules('message', __('IP_message'), 'trim|max_length[255]|xss_clean');

//        $this->form_validation->set_rules('reserve_time', __('IP_cart_time'), 'required|max_length[255]|xss_clean');

        $this->form_validation->set_rules('kind_pay', __('IP_cart_kind'), 'trim|required|max_length[255]|xss_clean');

        if ($this->form_validation->run($this)) {

            $sale_date_1 = date('Y-m-d');

            $order_data = array(

                'sale_date' => date('Y-m-d H:i:s'),

                'total' => $this->cart->total(),

                'total_discount' => $options['total_discount'],

                'coupon_code' => $options['coupon_code'],

                'order_status' => PRODUCTS_NEW_ORDER,

                'fullname' => $this->input->post('fullname', TRUE),

                'address' => $this->input->post('address', TRUE),

                'tel' => $this->input->post('tel', TRUE),

                'email' => $this->input->post('email', TRUE),

                'message' => $this->input->post('message', TRUE),

                'create_time' => now(),

                'update_time' => now(),

                'str_created_order' => 1000 * strtotime($sale_date_1),

                'current_ip' => $_SERVER['REMOTE_ADDR'],

//                'reserve_time' => $this->input->post('reserve_time'),

                'kind_pay' => $this->input->post('kind_pay', TRUE),

                'user_id' => $this->input->post('user_id', TRUE),

            );



            $order_id = $this->orders_model->insert($order_data);

            

            if($order_id && $options['coupon_code'] <> ''){

                $this->products_coupon_item_model->update(array('status'=>STATUS_INACTIVE),array('code'=>$options['coupon_code']));

            }

            

            $this->phpsession->clear('total_discount');

            $this->phpsession->clear('coupon_code');

            

            $order_data['order_id'] = $order_id;

            $carts = $this->cart->contents();



            foreach ($carts as $cart) {

                $order_details_data = array(

                    'order_id' => $order_id,

                    'product_id' => $cart['id'],

                    'quantity' => $cart['qty'],

                    'price' => $cart['price'],

                    'size' => $cart['size'],

                );

                $this->orders_details_model->insert($order_details_data);

            }

            //chuyen sang xac nhan dang ky

            $this->phpsession->save('reg_data', '');

            $this->phpsession->save('reg_data', $order_data);

            redirect(base_url().'xac-nhan-dang-ky');

            // chuan bi thong tin gui cho ngan luong

//            $price = $this->cart->total();

//            $id_pro = $order_id;

//            $message = $this->input->post('message', TRUE);

            // gửi mail cho khách hàng

//            $this->_send_email_invoice($order_data, $order_id);

//            $this->cart->destroy();



//            $kind_pay = $this->input->post('kind_pay', TRUE);

//            if(!empty($kind_pay) && $kind_pay = 1){

//            $complete_msg = $this->load->view('info_kind_pay',null, TRUE);}

//             else {

//            $complete_msg = $this->load->view('info_kind_pay',null, TRUE);}

 

//                $complete_msg = 'CẢM ƠN BẠN ĐÃ ĐẶT HÀNG CỦA CHÚNG TÔI <BR><br> 

//                Chúng tôi đã gửi thông tin chi tiết về đơn hàng vào email của bạn. 

//                Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. <br><br>

//                Chúc bạn một ngày vui.';

//                $this->phpsession->save('ok_order_message', $complete_msg);

           

//            } else {

//                $form_pay = '<form action="https://www.nganluong.vn/advance_payment.php" method="post">

//                <input type="hidden" name="receiver" value="hoatoancau@yahoo.com">

//                <input type="hidden" name="product" value="' . $id_pro . '">

//                <input type="hidden" name="price" value=' . $price . '>

//                <input type="hidden" name="return_url" value="http://hoa.vn">

//                <input type="hidden" name="comments" value=' . $message . '>

//                <input type="image" src="https://www.nganluong.vn/data/images/buttons/11.gif" id="nganluong-submit">

//                </form>';

//                $this->phpsession->save('ok_order_message', $form_pay);

//            }

            //redirect(PRODUCTS_CART_URL);

            return TRUE;

        }

        $this->_last_message = validation_errors();

        return FALSE;

    }

    

    public function register_confirm()

    {

        $reg = $this->phpsession->get('reg_data');

        if(empty($reg)){

            redirect(base_url());

        }

       

        

        if($reg['kind_pay'] == 1){

            $billing = 'Thanh toán khi nhận hàng';

        }elseif($reg['kind_pay'] == 2){

            $billing = 'Thanh toán chuyển khoản ngân hàng';

        }elseif($reg['kind_pay'] == 3){

            $billing = 'Thanh toán tại cửa hàng';

        }else{

            $billing = '';

        }

        

        $view_data = array(

            'title'         => 'Xác nhận thông tin thanh toán',

            'keywords'      => 'Xác nhận thông tin thanh toán',

            'description'   => 'Xác nhận thông tin thanh toán',

            'current_menu'  => '/dang-ky',

        );

        

        $view_data += $reg;

        

        $view_data['billing_name'] = $billing;

        

        $view_data['submit_uri'] = 'xac-nhan-dang-ky';

        $view_data['is_one_col'] = true;

        

        

        $this->_view_data['main_content'] = $this->load->view('register_confirm',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }

    

    public function register_success()

    {

        $reg = $this->phpsession->get('reg_data');

        if(!empty($reg)){

            $this->_send_email_invoice($reg);

            $this->cart->destroy();

//            $this->_send_email_contact($reg);

            $this->phpsession->save('reg_data', '');

        }else{

            redirect(base_url());

        }

        

        $view_data = array(

            'title'         => 'Chúc mừng bạn đã đặt hàng thành công',

            'keywords'      => 'Chúc mừng bạn đã đặt hàng thành công',

            'description'   => 'Chúc mừng bạn đã đặt hàng thành công',

            'current_menu'  => '/dang-ky',

        );

        

        $view_data['is_one_col'] = true;

        

        $this->_view_data['main_content'] = $this->load->view('register_success',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }

    

    private function _scripts() {

  

        $scripts = '<script type="text/javascript" src="' . base_url() . 'home/js/jquery-ui-1.10.4.min.js"></script>';

        $scripts .= '<script type="text/javascript" src="' . base_url() . 'plugins/datetimepicker/jquery-ui-timepicker-addon.min.js"></script>';

        $scripts .= '<script type="text/javascript" src="' . base_url() . 'plugins/datetimepicker/jquery-ui-sliderAccess.js"></script>';

        $scripts .= '<script type="text/javascript" src="' . base_url() . 'plugins/datetimepicker/i18n/jquery-ui-timepicker-vi.js"></script>';

        $scripts .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'plugins/datetimepicker/jquery-ui.css" />';

        $scripts .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'plugins/datetimepicker/jquery-ui-timepicker-addon.min.css" />';

	$scripts .= '<script>$("#reserve_time").datetimepicker({addSliderAccess: true,sliderAccessArgs: { touchonly: false },minDate: 0,});</script>';

        return $scripts;

    }

    

}



?>

