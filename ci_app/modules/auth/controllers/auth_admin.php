<?php
class Auth_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login');
        // Khoi tao cac bien
        $this->_layout = 'admin_ui/layout/main';
    }
    
    public function permission_denied()
    {
        $this->_view_data['title'] = 'Permission denied!';
        $this->_view_data['main_content'] = $this->load->view('auth/permission_denied', array(), TRUE);
        $this->load->view($this->_layout, $this->_view_data);
    }

    public function change_password()
    {
        $options = array();
        // Chuan bi thong bao loi neu co        
        if ($this->is_postback())
            if ($this->_do_change_password())
                $options['succeed'] = $this->_last_message;
            else
                $options['error'] = $this->_last_message;
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thay đổi mật khẩu';
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('auth/admin/change_password_form', array('options' => $options), TRUE);
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _do_change_password()
    {
        $params = array();
        $this->form_validation->set_rules('password', 'Mật khẩu cũ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('new_password', 'Mật khẩu mới', 'trim|required|min_length[5]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('new_password2', 'Xác nhận mật khẩu mới', 'trim|required|min_length[5]|max_length[50]|matches[new_password]|xss_clean');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run())
        {
            $params['user_id']         = $this->phpsession->get('user_id');
            $params['password']        = md5($this->input->post('password'));
            $params['new_password']    = md5($this->input->post('new_password'));
            $params['new_password2']   = md5($this->input->post('new_password2'));

            // Neu nguoi dung ton tai thi moi thuc hien viec thay doi mat khau
            $contact = $this->users_model->is_user_existed(array('user_id' => $params['user_id']));
            if (is_object($contact))
            {
                if ($contact->password===$params['password'])
                {
                    $this->users_model->update_user(array('id' => $params['user_id'], 'password' => $params['new_password']));
                    $this->_last_message = '<p>Bạn đã thay đổi mật khẩu thành công.</p>';
                    return TRUE;
                }
                else
                {
                    $this->_last_message = '<p>Mật khẩu cũ không chính xác.</p>';
                    return FALSE;
                }
            }

            $this->_last_message = $this->contact_model->get_last_message();
            return FALSE;
        }

        $this->_last_message = validation_errors();
        return FALSE;
    }
    
    public function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        modules::run('auth/auth/check_permission',$this->router->fetch_module());
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('users_lang', $options['lang']);

        $total_row          = $this->users_model->get_users_count($options);
        $total_pages        = (int)($total_row / AUTH_USERS_ADMIN_POST_PER_PAGE);
        if ($total_pages * AUTH_USERS_ADMIN_POST_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * AUTH_USERS_ADMIN_POST_PER_PAGE;
        $options['limit']   = AUTH_USERS_ADMIN_POST_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $options['users']                 = $this->users_model->get_users($options);
        $options['total_rows']            = $total_row;
        $options['total_pages']           = $total_pages;
        $options['page_links']            = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = AUTH_USERS_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = AUTH_USERS_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/list',$options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý người dùng' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
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
            $this->phpsession->save('users_search_options', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('users_search_options');
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

    function add()
    {
        modules::run('auth/auth/check_permission',$this->router->fetch_module());
        $options = array();
        
        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options += $this->_get_add_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm người dùng' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_add_form_data()
    {
        $options['username'] = my_trim($this->input->post('username'));
        $options['passworđ'] = my_trim($this->input->post('password'));
        $options['fullname'] = my_trim($this->input->post('fullname'));
        $options['email'] = my_trim($this->input->post('email'));
        $options['tel'] = my_trim($this->input->post('tel'));
        $options['roles_combobox'] = $this->roles_model->get_roles_combo(array('roles_combobox' => $this->input->post('roles_combobox'), 'extra' => ' class="btn"'));
        $options['header']        = 'Thêm người dùng';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = AUTH_USERS_ADMIN_BASE_URL.'/add';
        return $options;
    }
    
    private function _do_add()
    {
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|xss_clean|max_length[30]');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|xss_clean|max_length[50]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|xss_clean|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('tel', 'Điện thoại', 'trim|xss_clean|max_length[25]');
        $this->form_validation->set_rules('roles_combobox', 'Quyền hạn', 'required|is_not_default_combo');
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['password'] = md5($this->input->post('password', TRUE));
            $post_data['creator'] = $this->phpsession->get('user_id');
            $post_data['level'] = AUTH_LEVEL_ADMIN;
            $this->users_model->insert($post_data);
            $lang = $this->phpsession->get('users_lang');
            redirect(AUTH_USERS_ADMIN_BASE_URL . '/' . $lang);
        }
        return FALSE;
    }

    private function _get_posted_data()
    {
        $post_data = array(
            'username' => my_trim($this->input->post('username', TRUE)),
//            'password' => my_trim($this->input->post('password', TRUE)),
            'fullname' => my_trim($this->input->post('fullname', TRUE)),
            'email' => my_trim($this->input->post('email', TRUE)),
            'tel' => my_trim($this->input->post('tel', TRUE)),
            'role_id' => my_trim($this->input->post('roles_combobox', TRUE)),
            'active' => STATUS_ACTIVE,
            'joined_date' => date('Y-m-d H:i:s', now()),
            'editor' => $this->phpsession->get('user_id'),
        );
        return $post_data;
    }
    
    
    function edit()
    {
        modules::run('auth/auth/check_permission',$this->router->fetch_module());
        $options = array();
        
        if(!$this->is_postback()) redirect(AUTH_USERS_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa người dùng' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
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
            $user = $this->users_model->get_users(array('id' => $id));
            $username = $user->username;
//            $password = $user->password;
            $password = '';
            $fullname = $user->fullname;
            $email = $user->email;
            $tel = $user->tel;
            $role_id = $user->role_id;
        }else{
            $username = my_trim($this->input->post('username', TRUE));
            $password = my_trim($this->input->post('password', TRUE));
            $fullname = my_trim($this->input->post('fullname', TRUE));
            $email = my_trim($this->input->post('email', TRUE));
            $tel = my_trim($this->input->post('tel', TRUE));
            $role_id = my_trim($this->input->post('roles_combobox', TRUE));
        }

        $options                  = array();
        $options['id']            = $id;
        $options['username']      = $username;
        $options['password']      = $password;
        $options['fullname']      = $fullname;
        $options['email']         = $email;
        $options['tel']           = $tel;
        $options['roles_combobox'] = $this->roles_model->get_roles_combo(array('roles_combobox' => $role_id, 'extra' => ' class="btn"'));
        $options['header']        = 'Sửa người dùng';
        $options['button_name']   = 'Sửa người dùng';
        $options['submit_uri']    = AUTH_USERS_ADMIN_BASE_URL.'/edit';
        $options['is_edit'] = TRUE;
        return $options;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit()
    {
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|xss_clean|max_length[30]');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|xss_clean|max_length[50]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|xss_clean|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('tel', 'Điện thoại', 'trim|xss_clean|max_length[25]');
        $this->form_validation->set_rules('roles_combobox', 'Quyền hạn', 'required|is_not_default_combo');
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['id'] = $this->input->post('id');
            $password = $this->input->post('password', TRUE);
            if(!empty($password) && $password <> ''){
                $post_data['password'] = md5($password);
            }
            $this->users_model->update($post_data);
            $lang = $this->phpsession->get('users_lang');
            redirect(AUTH_USERS_ADMIN_BASE_URL . '/' . $lang);
        }
        return FALSE;
    }

    public function delete()
    {
        modules::run('auth/auth/check_permission',$this->router->fetch_module());
        $options = array();
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            $this->users_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('users_lang');
        redirect(AUTH_USERS_ADMIN_BASE_URL . '/' . $lang);
    }

    function change_status()
    {
        modules::run('auth/auth/check_permission',$this->router->fetch_module());
        $id = $this->input->post('id');
        $user = $this->users_model->get_users(array('id' => $id));
        $status = $user->active == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->users_model->update(array('id'=>$id,'active'=>$status));
    }
    
}
?>