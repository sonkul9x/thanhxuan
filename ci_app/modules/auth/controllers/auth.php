<?php
class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_login_layout = 'layout/signin_layout';
        $this->_options['base_url'] = base_url();
        $this->_options['uri'] = base_url() . $this->uri->uri_string();
    }

    function validate_login($module=NULL)
    {
        if (!$this->is_logged_in()) {
            redirect(base_url());
        }else{
            if($module==NULL){
                return TRUE;
            }else{
                return $this->check_permission($module);
            }
        }
    }

    function is_logged_in()
    {
        if ($this->phpsession->get('is_logged_in')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }    

    function logout()
    {
        $this->phpsession->clear();
//        $this->cart->destroy(); // Xoa cac items trong gio hang

        redirect(base_url());
    }

    public function captcha()
    {
        create_security_captcha(array('context' => $this));
    }

    function login($options = array())
    {   
        // Kiem tra neu da dang nhap vao he thong roi thi tu dong chuyen den dashboard
        if ($this->is_logged_in()) redirect('/dashboard');
        
        if ($this->is_postback())
            if (!$this->_do_login())
                $this->_options['error']    = $this->_last_message;
        
        if(isset($this->_options['error'])) $this->_view_data['options'] = $this->_options;
        
        $this->_view_data['submit_uri']     = get_form_submit_by_lang($this->_lang, 'login_form');
        
        // Chuan bi cac the META
        $this->_view_data['title']          = __("IP_log_in") . DEFAULT_TITLE_SUFFIX;
        $this->_view_data['keywords']       = $this->_title . ' ' . $this->_keywords;
        $this->_view_data['description']    = $this->_description;
        $this->_view_data['main_content']   = $this->load->view('auth/login_form', $this->_options, TRUE);
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_login_layout, $this->_view_data);
    }

    private function _do_login()
    {
        $this->_last_message  = '';
        $options = array();

        $this->form_validation->set_rules('username', __("IP_user_name"), 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', __("IP_password"), 'trim|required|xss_clean');

        if ($this->form_validation->run())
        {
            $options['username']    = $this->input->post('username', TRUE);
            $options['password']    = $this->input->post('password', TRUE);
            $options['active']      = STATUS_ACTIVE;
            $options['status']      = STATUS_ACTIVE;
            
            $users = $this->users_model->get_users($options);

            $login = TRUE;
            if (count($users)==1)
            {
                $user = $users[0];

                if ((trim($options['username']) === trim($user->username))
                 && (md5(trim($options['password'])) === trim($user->password))
                 && ($user->active == 1))
                {
                    $this->phpsession->save('is_logged_in'  , TRUE);
                    $this->phpsession->save('username'      , $user->username);
                    $this->phpsession->save('fullname'      , $user->fullname);
                    $this->phpsession->save('email'         , $user->email);
                    $this->phpsession->save('user_id'       , $user->id);
                    $this->phpsession->save('level'         , $user->level);
                    $this->phpsession->save('role_id'       , $user->role_id);
                    $this->phpsession->save('roles_name'    , $user->roles_name);
                    $this->phpsession->save('roles_roles'   , $user->roles_roles);
                    $this->phpsession->save('roles_publisher' , $user->roles_publisher);
                    redirect('/dashboard');
                }
                else
                {
                    $login = FALSE;
                }
            }
            else
            {
                $login = FALSE;
            }

            if ( !$login)
            {
                $this->_last_message = '<p>' . __('IP_login_failed') . '</p>';
                return FALSE;
            }
        }
        $this->_last_message = validation_errors();
        return FALSE;
    }
    
    public function check_permission($module=NULL)
    {
        if($module==NULL){return TRUE;}
        $roles_session = $this->phpsession->get('roles_roles');
        if(!empty($roles_session)){
            if($roles_session == AUTH_ROLES_ALL){
                $roles = AUTH_ROLES_ALL;
                return TRUE;
            }else{
                $roles = json_decode($roles_session);
                $roles_list = array();
                foreach($roles as $key => $value){
                    $roles_menus = $this->roles_menus_model->get_roles_menus(array('id'=>$value,'status'=>STATUS_ACTIVE));
                    if(!empty($roles_menus)){
                        $roles_list[] = $roles_menus->module;
                    }
                }
                if(!in_array($module, $roles_list)){
                    return $this->permission_denied();
                }else{
                    return TRUE;
                }
            }
        }else{
            redirect(base_url());
        }
    }
    
    public function get_roles_menus()
    {
        $roles_session = $this->phpsession->get('roles_roles');
        if(!empty($roles_session)){
            if($roles_session == AUTH_ROLES_ALL){
                $roles = AUTH_ROLES_ALL;
                return TRUE;
            }else{
                $roles = json_decode($roles_session);
                $roles_list = array();
                foreach($roles as $key => $value){
                    $roles_menus = $this->roles_menus_model->get_roles_menus(array('id'=>$value,'status'=>STATUS_ACTIVE));
                    if(!empty($roles_menus)){
                        $roles_list[$roles_menus->id] = convert_tags_to_array($roles_menus->url_path);
                    }
                }
                return $roles_list;
            }
        }else{
            return FALSE;
        }
    }
    
    public function get_roles_menus_disabled()
    {
        $roles_menus = $this->get_roles_menus();
        if(!is_array($roles_menus) && $roles_menus == TRUE){
            return array();
        }elseif(is_array($roles_menus)){
            $roles_menus_key_enabled = array_keys($roles_menus);
            $all_roles_menus = $this->roles_menus_model->get_roles_menus(array('status'=>STATUS_ACTIVE));
            $roles_menus_key_disabled = array();
            if(!empty($all_roles_menus)){
                foreach($all_roles_menus as $key => $value){
                    $roles_menus_key_disabled[] = $value->id;
                }
            }
            $list_menus_key = array_diff($roles_menus_key_disabled,$roles_menus_key_enabled);
            $list_menus = array();
            if(!empty($list_menus_key)){
                foreach($list_menus_key as $key => $value){
                    $list_menu = $this->roles_menus_model->get_roles_menus(array('id'=>$value));
                    $list_menu_array[$list_menu->id] = convert_tags_to_array($list_menu->url_path);
                }
            }
            return $list_menu_array;
        }else{
            return array();
        }
    }
    
    public function permission_denied()
    {
//        echo "<pre>";
//        print_r('You do not have permission to access this page! <a href="javascript:window.history.back();">Click to Back</a>');
//        echo "</pre>";
//        exit();

        redirect('/dashboard/permission_denied');
    }
}
?>
