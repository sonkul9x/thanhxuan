<?php

class Customers extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }

    public function get_side_customers() {
        $config = get_cache('configurations_' . get_language());
        $page_param = $config['number_customers_per_side'] != 0 ? $config['number_customers_per_side'] : FAQ_PER_SIDE;
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => $page_param,
        );

        $customers = $this->customers_model->get_customers($options);
        return $customers;
    }

    public function get_home_customers() {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 1,
            'onehit' => TRUE,
        );

        $customers = $this->customers_model->get_customers($options);
        return $customers;
    }

    public function get_bottom_customers() {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 2,
            'random' => TRUE,
        );

        $customers = $this->customers_model->get_customers($options);
        return $customers;
    }

    /**
     * 
     * @param type $para1
     * @param type $para2
     */
    public function customers_search($para1 = NULL, $para2 = 'vi') {
        $keyword = $this->db->escape_str($this->input->post('keyword'));

        if (isset($keyword) && !empty($keyword)) {
            $this->phpsession->save('customers_search', $keyword);
        } else {
            $keyword = $this->phpsession->get('customers_search');
        }

        $options = array('keyword' => $keyword, 'lang' => switch_language($para2), 'page' => $para1, 'status' => STATUS_ACTIVE);
        $config = get_cache('configurations_' . $options['lang']);
        $customers_per_page = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row = $this->customers_model->get_customers_count($options);
        $total_pages = (int) ($total_row / $customers_per_page);

        if ((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi') {
            $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);
            $uri_segment = 3;
        } else {
            $base_url = site_url() . $this->uri->segment(1);
            $uri_segment = 2;
        }

        $paging_config = array(
            'base_url' => $base_url,
            'total_rows' => $total_row,
            'per_page' => $customers_per_page,
            'uri_segment' => $uri_segment,
            'use_page_numbers' => TRUE,
            'first_link' => __('IP_paging_first'),
            'last_link' => __('IP_paging_last'),
            'num_links' => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page'] > 0) ? ($options['page'] - 1) * $paging_config['per_page'] : 0;
        $options['limit'] = $paging_config['per_page'];

        $customerss = $this->customers_model->get_customers($options);

        $view_data = array(
            'customerss' => $customerss,
            'category' => __('IP_search_result'),
            'total_row' => $total_row,
            'keyword' => $keyword,
        );

        $this->_view_data['main_content'] = $this->load->view('customers_search', $view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    public function customers_tags($para1 = NULL, $para2 = 'vi', $para3 = NULL) {
        $options = array('lang' => switch_language($para2), 'page' => $para1, 'tags' => $para3, 'status' => STATUS_ACTIVE);
        $config = get_cache('configurations_' . $options['lang']);
        $customers_per_page = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row = $this->customers_model->get_customers_count($options);
        $total_pages = (int) ($total_row / $customers_per_page);

        if ((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi') {
            $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2) . '/' . $options['tags'];
            $uri_segment = 4;
        } else {
            $base_url = site_url() . $this->uri->segment(1) . '/' . $options['tags'];
            $uri_segment = 3;
        }

        $paging_config = array(
            'base_url' => $base_url,
            'total_rows' => $total_row,
            'per_page' => $customers_per_page,
            'uri_segment' => $uri_segment,
            'use_page_numbers' => TRUE,
            'first_link' => __('IP_paging_first'),
            'last_link' => __('IP_paging_last'),
            'num_links' => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page'] > 0) ? ($options['page'] - 1) * $paging_config['per_page'] : 0;
        $options['limit'] = $paging_config['per_page'];

        $customerss = $this->customers_model->get_customers($options);
        $tags = str_replace('-', ' ', $options['tags']);
        $view_data = array(
            'customerss' => $customerss,
            'category' => $tags,
            'total_row' => $total_row,
        );

        $this->_view_data['main_content'] = $this->load->view('customers_tags', $view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    public function get_list_customers_by_cat($para1 = NULL, $para2 = NULL, $para3 = NULL) {
        $options = array('cat_id' => $para1, 'page' => $para2, 'lang' => switch_language($para3), 'status' => STATUS_ACTIVE);
        $config = get_cache('configurations_' . $options['lang']);
        $customers_per_page = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row = $this->customers_model->get_customers_count($options);
        $total_pages = (int) ($total_row / $customers_per_page);

        if ((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi') {
            $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);
            $uri_segment = 3;
        } else {
            $base_url = site_url() . $this->uri->segment(1);
            $uri_segment = 2;
        }

        $paging_config = array(
            'base_url' => $base_url,
            'total_rows' => $total_row,
            'per_page' => $customers_per_page,
            'uri_segment' => $uri_segment,
            'use_page_numbers' => TRUE,
            'first_link' => __('IP_paging_first'),
            'last_link' => __('IP_paging_last'),
            'num_links' => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page'] > 0) ? ($options['page'] - 1) * $paging_config['per_page'] : 0;
        $options['limit'] = $paging_config['per_page'];

        //lay tu vi tri so 2, offset+=1
//        $options['offset'] = $options['offset']+1;

        $customerss = $this->customers_model->get_customers($options);
        $category = $this->customers_categories_model->get_customers_categories(array('id' => $options['cat_id']));

        //current menu
        $check_id = $category->parent_id;

        if ($check_id <> 0) {
            while ($check_id <> 0) {
                $parent_category = $this->customers_categories_model->get_customers_categories(array('id' => $check_id));
                if ($parent_category->parent_id == 0) {
//                    $active_menu = '/dich-vu';
                    $active_menu = '/' . url_title($parent_category->category, 'dash', TRUE) . '-q' . $parent_category->id;
                    break;
                } else {
                    $check_id = $parent_category->parent_id;
                }
            }
        } else {
            $active_menu = NULL;
        }

        $title = ($category->meta_title <> '') ? $category->meta_title : $category->category;
        $keywords = ($category->meta_keywords <> '') ? $category->meta_keywords : $category->category;
        $description = ($category->meta_description <> '') ? $category->meta_description : $category->category;

        if ((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi') {
            $current_menu = '/' . $this->uri->segment(2);
        } else {
            $current_menu = '/' . $this->uri->segment(1);
        }

        $view_data = array(
            'customerss' => $customerss,
            'category' => $category->category,
            'category_id' => $category->id,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'current_menu' => $current_menu,
            'active_menu' => $active_menu,
        );

        $this->_view_data['main_content'] = $this->load->view('customers', $view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    public function get_customers_detail($para1 = NULL, $para2 = NULL) {
        $options = array('id' => $para1);

        $lang = switch_language($para2);

        $this->customers_model->update_customers_view($options['id']);

        $customers = $this->customers_model->get_customers($options);

        $customers_same = $this->get_list_customers_same(array('cat_id' => $customers->cat_id, 'current_id' => $options['id'], 'limit' => NEWS_PER_LIST));

        //current menu
        $category = $this->customers_categories_model->get_customers_categories(array('id' => $customers->cat_id));

        $check_id = $category->parent_id;
        if ($check_id <> 0) {
            while ($check_id <> 0) {
                $parent_category = $this->customers_categories_model->get_customers_categories(array('id' => $check_id));
                if ($parent_category->parent_id == 0) {
//                    $active_menu = '/dich-vu';
                    $active_menu = '/' . url_title($parent_category->category, 'dash', TRUE) . '-q' . $parent_category->id;
                    break;
                } else {
                    $check_id = $parent_category->parent_id;
                }
            }
        } else {
            $active_menu = NULL;
        }

        $current_menu = '/' . url_title($category->category, 'dash', TRUE) . '-q' . $category->id;

        if (!empty($lang) && $lang <> 'vi') {
            $current_menu = '/' . $lang . $current_menu;
        } else {
            $current_menu = $current_menu;
        }

        $view_data = array(
            'customers' => $customers,
            'category' => $customers->category,
            'title' => ($customers->meta_title <> '') ? $customers->meta_title : $customers->title,
            'keywords' => ($customers->meta_keywords <> '') ? $customers->meta_keywords : $customers->title,
            'description' => ($customers->meta_description <> '') ? $customers->meta_description : $customers->title,
            'current_menu' => $current_menu,
            'active_menu' => $active_menu,
            'customers_same' => $customers_same,
            'tags' => convert_tags_to_array($customers->tags),
        );

        $this->_view_data['main_content'] = $this->load->view('customers_detail', $view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    /**
     * tin lien quan / cung loai
     * @param type $options
     * @return type
     */
    public function get_list_customers_same($options = array()) {
        $options['status'] = STATUS_ACTIVE;
        $options['random'] = TRUE;
        $options['lang'] = $this->_lang;

        $customers = $this->customers_model->get_customers($options);
        $view_data = array(
            'category' => __('IP_customers_same'),
            'customers' => $customers,
        );
        return $this->load->view('customers_same', $view_data, TRUE);
    }

    public function get_top_customers($cat_id) {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 1,
            'onehit' => TRUE,
            'type' => $cat_id,
        );
        $customers = $this->customers_model->get_customers($options);
        $view_data = array(
            'customers' => $customers,
        );
        return $this->load->view('customers_grid_top', $view_data, TRUE);
    }

    public function customers_sign_up($para1 = 'vi') {
        $lang = switch_language($para1);
        if ((!empty($lang) && $lang <> 'vi') || $this->uri->segment(1) == 'vi') {
            $uri = '/' . $lang . '/' . $this->uri->segment(2);
        } else {
            $uri = '/' . $this->uri->segment(1);
        }

        $view_data = array(
            'title' => __('IP_customers_sign_up'),
            'keywords' => __('IP_default_company'),
            'description' => __('IP_default_company'),
            'current_menu' => $uri,
        );

        $ok_customers_message = $this->phpsession->get('ok_customers_message');

        if ($ok_customers_message == 'ok') {
            $view_data['succeed'] = "Bạn đã đăng ký thành công.";
        }
        if ($this->is_postback()) {
            if (!$this->_add_customers()) {
                $view_data['error'] = $this->_last_message;
            }
        }

        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_customers_message', '');

        $view_data += $this->_get_add_form_data();

        $this->_view_data['main_content'] = $this->load->view('customers_send_question', $view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    private function _get_add_form_data() {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'btn_submit' => 'IP_customers_sign_up',
            'submit_uri' => get_url_by_lang(get_language(), 'customers-sign-up'),
        );
        return $options;
    }

    private function _get_posted_data() {
        $post_data = array(
            'email' => my_trim($this->input->post('email', TRUE)),
            'password' => md5(my_trim($this->input->post('password', TRUE))),
            //'re_password'  => my_trim($this->input->post('re_password', TRUE)),
            'fullname' => my_trim($this->input->post('fullname', TRUE)),
            'address' => $this->input->post('address', TRUE),
            'phone' => my_trim($this->input->post('phone', TRUE)),
            'status' => STATUS_INACTIVE,
        );
        $post_data['created_date'] = date('Y-m-d H:i:s');
        $post_data['updated_date'] = date('Y-m-d H:i:s');

        return $post_data;
    }

    private function _add_customers() {
        $this->_last_message = '';

        $this->form_validation->set_rules('email', 'Địa chỉ email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|xss_clean|min_length[3]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'trim|required|xss_clean|min_length[3]|matches[password]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        //$this->form_validation->set_rules('address', 'Địa chỉ', 'trim|required|xss_clean|max_length[1000]');
        //$this->form_validation->set_rules('phone', 'Số điện thoại', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');
        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_data();

            if ($this->customers_model->is_available_username_customers($post_data)) {
                // save to database
                $this->customers_model->insert($post_data);
                $this->phpsession->save('ok_customers_message', 'ok');
                redirect(get_url_by_lang(get_language(), 'customers-sign-up'));
            }
            $this->_last_message = $this->customers_model->get_last_message();
            return FALSE;
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }

    function login_customers() {
        $view_data = array(
            'title' => __('IP_log_in'),
            'keywords' => __('IP_default_company'),
            'description' => __('IP_default_company'),
            'current_menu' => $uri,
        );

        $ok_customers_message = $this->phpsession->get('ok_customers_message_login');
        if ($ok_customers_message == 'ok') {
            $view_data['succeed'] = "Bạn đã đăng nhập thành công.";
        }
        if ($this->is_postback()) {
            if (!$this->check_login()) {
                $view_data['error'] = $this->_last_message;
            }
        }
//        if ($this->is_postback()) {
//            $options = array();
//            $options['email'] = $this->input->post('email_login');
//            $options['password'] = md5($this->input->post('password'));
//            $options['current_uri'] = $this->input->post('current_uri');
//            $options['type'] = USER_ACC;
//            $options['last_row'] = TRUE;
//            $users = $this->customers_model->get_customers($options);
//         
//            if (!is_object($users)) {
//                $view_data['error'] = $this->_last_message;
//            } else {
//                $options['user'] = $users;
//                $this->set_login($options);
//                redirect($options['current_uri'], 'refresh');
//            }
//            
//        }

        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_customers_message_login', '');
      
        $view_data += $this->_get_add_form_data_customers_login();
        
        $this->_view_data['main_content'] = $this->load->view('customers_login', $view_data, TRUE);
        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    private function check_login() {
        $this->_last_message = '';

        $this->form_validation->set_rules('email', 'Địa chỉ email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|xss_clean|min_length[3]');
      
        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_data_login();
           
            if ($users = $this->customers_model->get_customers($post_data)) {
                // save to database
                $options['user'] = $users;
                $this->set_login($options);
                //$this->phpsession->save('ok_customers_message', 'ok');
                redirect($options['current_uri'], 'refresh');
              
            }else{
                $this->_last_message .='Email hoặc mật khẩu bạn nhập không đúng. Vui lòng nhập lại';
                return FALSE;
            }
            $this->_last_message = $this->customers_model->get_last_message();
            return FALSE;
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }
    
    private function _get_posted_data_login() {
        $post_data = array(
            'email' => my_trim($this->input->post('email', TRUE)),
            'password' => md5(my_trim($this->input->post('password', TRUE))),
            'current_uri' => $this->input->post('current_uri'),
            'last_row' => TRUE,
        );
        return $post_data;
    }
    
    private function _get_add_form_data_customers_login() {
        $options = array(
            'email' => $this->input->post('email'),
            //'password' => md5($this->input->post('password')),
            'submit_uri' => get_url_by_lang(get_language(), 'customers-login'),
        );
        return $options;
    }

    public function set_login($options) {
        $user = $options['user'];
        $this->phpsession->clear('openid_email');
        $this->phpsession->save('is_logged_in', TRUE);
        $this->phpsession->save('user_id', $user->id);
        $this->phpsession->save('fullname', $user->fullname);
        $this->phpsession->save('email', $user->email); //địa chỉ email
        $this->phpsession->save('address', $user->address); //thành phố
        $this->phpsession->save('phone', $user->phone); //tầng lầu
       
    }

    /**
     * Kiểm tra xem đã đăng nhập chưa từ session
     *
     */
    function is_logged_in() {
        if ($this->phpsession->get('is_logged_in'))
            return TRUE;
        else {
            $this->phpsession->save('roles_id', ROLE_GUESS);
            return FALSE;
        }
    }

    /**
     * Thoát khỏi hệ thống và xóa toàn bộ session
     */
    function logout() {
        $this->phpsession->clear();
        $this->cart->destroy();
        $this->phpsession->save('roles_id', ROLE_GUESS);
//        if($this->phpsession->get('logout_url') != ''){
//            redirect($this->phpsession->get('logout_url'));
//        }
        redirect(get_base_url());
    }

    // Thông tin cá nhân của khách

    public function get_infomation_customers($options = array()) {
        if ($this->is_logged_in()):
            $user = $this->customers_model->get_customers(array('user_id' => $this->phpsession->get('user_id'), 'last_row' => TRUE));
            
            $view_data = array();

            $view_data = $this->get_data_form_register(array('user_islogin_openid' => $user));
            if ($this->is_postback()) {
                $this->process_update_info();
                $view_data['error'] = $this->_last_message;
            }
            
            $ok_customers_message = $this->phpsession->get('ok_customers_message');
            
              if ($ok_customers_message == 'ok') {
                $view_data['succeed'] = "Bạn đã thay đổi thành công.";
                
            }
            if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
                $view_data['options'] = $view_data;
            }
            
            $this->phpsession->save('ok_customers_message', '');
            
            
            $view_data['h1_title'] = 'Thông tin cá nhân';
            $view_data['btn_submit'] = 'IP_updated_information';
            //$view_data['options'] = $options;
            $view_data['submit_uri'] = '/thong-tin-ca-nhan#content_general';
            //return $this->load->view('customers/customers_send_question', $view_data, TRUE);
            
            $this->_view_data['main_content'] = $this->load->view('customers_send_question', $view_data, TRUE);
            $this->load->view($this->_layout, $this->_view_data, FALSE);

        else:
            redirect('/', 'refresh');
        endif;
    }

    function get_data_form_register($options = array()) {
        $view_data = array();
        if ($this->is_postback()) {

            $view_data['email'] = $this->input->post('email');
            $view_data['fullname'] = $this->input->post('fullname');
            $view_data['address'] = $this->input->post('address');
            $view_data['phone'] = my_trim($this->input->post('phone'), TRUE);
        } else {
            if (!isset($options['user_islogin_openid'])):
                $view_data['email'] = '';
                $view_data['password'] = '';
                $view_data['fullname'] = '';
                $view_data['address'] = '';
                $view_data['phone'] = '';

            else:
                $user = $options['user_islogin_openid'];
                $view_data['email'] = $user->email;
                $view_data['password'] = ''; //$user->password;
                $view_data['fullname'] = $user->fullname;
                $view_data['address'] = $user->address;

                $view_data['phone'] = $user->phone;

                if ($user->password == '' || $user->password == null)
                    $view_data['messeage_password'] = 'Bạn cần cập nhật Mật khẩu';
                else
                    $view_data['messeage_password'] = 'Để trống mật khẩu nếu không cập nhật';
            endif;
        }
        return $view_data;
    }

    private function process_update_info() {
        $this->_last_message = '';
        $options = array();
        $this->form_validation->set_rules('email', 'Địa chỉ email', 'trim|required|xss_clean|valid_email');
        $password = trim($this->input->post('password'));
        if ($password != '' && $password != null):
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|xss_clean|min_length[5]');
            $this->form_validation->set_rules('password2', 'Xác nhận mật khẩu', 'trim|required|xss_clean|min_length[5]|matches[password]');
        endif;
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');
        if ($this->form_validation->run()) {
            $options['email'] = $this->input->post('email');
            if ($password != '' && $password != null)
                $options['password'] = md5($password);

            $options['fullname'] = $this->input->post('fullname');
            $options['phone'] = my_trim($this->input->post('phone'), TRUE);
            $options['address'] = $this->input->post('address'); // so nha, ngo ngach
            $options['id'] = $this->phpsession->get('user_id');

            $this->customers_model->update($options);
            $this->phpsession->save('ok_customers_message', 'ok');
            $user = $this->customers_model->get_customers(array('last_row' => TRUE, 'user_id' => $this->phpsession->get('user_id')));
            $this->set_login(array('user' => $user));
            return TRUE;
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }
    
    // quan ly don hang
    function manager_order($para1=NULL){
        $options = array();
        $this->load->model('orders/orders_model');
        $this->load->model('orders/orders_details_model');
        $this->load->helper('orders/orders');
        $view_data = array();
        $user_id = $this->phpsession->get('user_id');
        $options['page'] = $para1;
        $options['user_id'] = $user_id;
        //phan trang
        $order_per_page = ORDER_PER_PAGE; 
        $total_row = $this->orders_model->get_orders_count($options);
        $total_pages = (int) ($total_row / $order_per_page);

        if ($total_pages * $order_per_page < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * $order_per_page;
        $options['limit'] = $order_per_page;
        
         $config_paging = prepare_pagination(
                    array(
                        'total_rows' => $total_row,
                        'per_page' => $options['limit'],
                        'offset' => $options['offset'],
                        'js_function' => 'change_page'
                    )
            );
         $this->pagination->initialize($config_paging);
         $view_data['pagination'] =  $this->pagination->create_ajax_links();
        //phan trang
 
        $orders = $this->orders_model->get_orders($options);
        
        foreach($orders as $order):
            $order->order_details = $this->orders_details_model->get_orders_details(array('id'=>$order->id));
        endforeach;
        $view_data['orders'] = $orders;
        $this->_title = 'Đơn hàng '.DEFAULT_TITLE_SUFFIX;
        $this->_description = 'Đơn hàng | '.DEFAULT_TITLE_SUFFIX;
        $this->_keywords = 'Đơn hàng'.__('IP_DEFAULT_KEYWORDS');
        //return $this->load->view('customers/guest/guest_order_manager',$view_data, TRUE);
        $this->_view_data['main_content'] = $this->load->view('customers/guest/guest_order_manager', $view_data, TRUE);
        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    function detail_order_ajax(){
        $this->load->model('orders/orders_model');
        $this->load->model('orders/orders_details_model');
        $this->load->helper('orders/orders');
        
        $id = $this->input->post('order_detail_id');
        $user_id = $this->phpsession->get('user_id');
        if($user_id == null || $user_id == '')
            return show_404();
        
        if ($this->is_postback()){
            $orders = $this->orders_model->get_orders(array('user_id'=>$user_id,'id'=>$id));
            $order_detals = $this->orders_details_model->get_orders_details(array('id'=>$id));
            $view_data = array();
            $view_data['order'] = $orders;
            
            $view_data['order_detals'] = $order_detals;
             $this->_title = 'Chi tiết Đơn hàng '.DEFAULT_TITLE_SUFFIX;
            $this->_description = 'Chi tiết Đơn hàng | '.DEFAULT_TITLE_SUFFIX;
            $this->_keywords = 'Chi tiết Đơn hàng'.__('IP_DEFAULT_KEYWORDS');
            //return $this->load->view('customers/guest/guest_order_detail',$view_data, TRUE);
            $this->_view_data['main_content'] = $this->load->view('customers/guest/guest_order_detail', $view_data, TRUE);
            $this->load->view($this->_layout, $this->_view_data, FALSE);
        }else{
            return show_404();
        }
    }
    
}
