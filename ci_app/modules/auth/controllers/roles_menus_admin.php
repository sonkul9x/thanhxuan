<?php
class Roles_Menus_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
    }
    
    public function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options            = array('lang'=>switch_language($para1),'page'=>$para2);
        $options            = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('roles_menus_lang', $options['lang']);

        $total_row          = $this->roles_menus_model->get_roles_menus_count($options);
        $total_pages        = (int)($total_row / AUTH_ROLES_MENUS_ADMIN_POST_PER_PAGE);
        if ($total_pages * AUTH_ROLES_MENUS_ADMIN_POST_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * AUTH_ROLES_MENUS_ADMIN_POST_PER_PAGE;
        $options['limit']   = AUTH_ROLES_MENUS_ADMIN_POST_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $options['roles_menus']           = $this->roles_menus_model->get_roles_menus($options);
        $options['total_rows']            = $total_row;
        $options['total_pages']           = $total_pages;
        $options['page_links']            = $this->pagination->create_ajax_links();
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = AUTH_ROLES_MENUS_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = AUTH_ROLES_MENUS_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('roles_menus/list',$options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý vai trò' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search'] = $this->db->escape_str($this->input->post('search', TRUE));
            $this->phpsession->save('roles_menus_search_options', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('roles_menus_search_options');
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
        $options = array();
        
        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options += $this->_get_add_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('roles_menus/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm vai trò' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_add_form_data()
    {
        $options['label'] = my_trim($this->input->post('label'));
        $options['module'] = my_trim($this->input->post('module'));
        $options['url_path'] = my_trim($this->input->post('url_path'));
        $options['header']        = 'Thêm vai trò';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = AUTH_ROLES_MENUS_ADMIN_BASE_URL.'/add';
        return $options;
    }
    
    private function _do_add()
    {
        $this->form_validation->set_rules('label', 'Tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('module', 'Module', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|xss_clean|max_length[500]');
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['status'] = STATUS_ACTIVE;
            $this->roles_menus_model->insert($post_data);
            $lang = $this->phpsession->get('roles_menus_lang');
            redirect(AUTH_ROLES_MENUS_ADMIN_BASE_URL . '/' . $lang);
        }
        return FALSE;
    }

    private function _get_posted_data()
    {
        $post_data = array(
            'label' => my_trim($this->input->post('label', TRUE)),
            'module' => my_trim($this->input->post('module', TRUE)),
            'url_path' => my_trim($this->input->post('url_path', TRUE)),
        );
        return $post_data;
    }
    
    
    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(AUTH_ROLES_MENUS_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('roles_menus/form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa vai trò' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_form_data()
    {
        $id = $this->input->post('id');
        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $role = $this->roles_menus_model->get_roles_menus(array('id' => $id));
            $label = $role->label;
            $module = $role->module;
            $url_path = $role->url_path;
        }else{
            $label = my_trim($this->input->post('label', TRUE));
            $module = my_trim($this->input->post('module', TRUE));
            $url_path = my_trim($this->input->post('url_path', TRUE));
        }

        $options                  = array();
        $options['id']            = $id;
        $options['label']         = $label;
        $options['module']        = $module;
        $options['url_path']      = $url_path;
        $options['header']        = 'Sửa vai trò';
        $options['button_name']   = 'Sửa vai trò';
        $options['submit_uri']    = AUTH_ROLES_MENUS_ADMIN_BASE_URL.'/edit';
        $options['is_edit'] = TRUE;
        return $options;
    }

    private function _do_edit()
    {
        $this->form_validation->set_rules('label', 'Tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('module', 'Module', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|xss_clean|max_length[500]');
        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['id'] = $this->input->post('id');
            $this->roles_menus_model->update($post_data);
            $lang = $this->phpsession->get('roles_menus_lang');
            redirect(AUTH_ROLES_MENUS_ADMIN_BASE_URL . '/' . $lang);
        }
        return FALSE;
    }

    public function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            $this->roles_menus_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('roles_menus_lang');
        redirect(AUTH_ROLES_MENUS_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $role_menus = $this->roles_menus_model->get_roles_menus(array('id' => $id));
        $status = $role_menus->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->roles_menus_model->update(array('id'=>$id,'status'=>$status));
    }
    
}