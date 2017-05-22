<?php
class Supports_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = SUPPORTS_ADMIN_BASE_URL;
    }

    function browse($para1=DEFAULT_LANGUAGE)
    {
        $options = array('lang'=>switch_language($para1));
        $this->phpsession->save('support_lang', $options['lang']);
        
        $options['supports']     = $this->supports_model->get_supports(array('parent_id' => ROOT_CATEGORY_ID, 'lang' => $options['lang']));
        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        $options['uri'] = SUPPORTS_ADMIN_BASE_URL;
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('admin/list_supports', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Danh sách hỗ trợ trực tuyến' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    /*
     * Them moi nick ho tro
     */
    function add()
    {
        $options = array();

        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_support_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm hỗ trợ' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_form_data()
    {
        $options                  = array();
        $options['title']         = $this->input->post('title');
        $options['type']          = $this->input->post('type');
        $options['content']       = $this->input->post('content');
        $options['header']        = 'Thêm hỗ trợ trực tuyến';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = SUPPORTS_ADMIN_BASE_URL.'/add';
        
        if($this->is_postback())
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'class="btn"'));
        }
        else
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('support_lang'), 'extra' => 'class="btn"'));
        }
        
        return $options;
    }

    private function _do_add()
    {
        $this->form_validation->set_rules('content', 'Tài khoản hỗ trợ', 'trim|required|xss_clean');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
            $position_add = $this->supports_model->position_to_add_supports(
                        array(
                            'type'=>$post_data['type'],
                            'lang'=>$post_data['lang'],
                        )
                    );
            $post_data['position'] = $position_add;
            $post_data['create_time'] = now();
            $this->supports_model->insert($post_data);

            redirect(SUPPORTS_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }

    private function _get_posted_data()
    {
        $post_data = array(
            'title'             => my_trim($this->input->post('title', TRUE)),
            'type'              => $this->input->post('type', TRUE),
            'content'           => my_trim($this->input->post('content', TRUE)),
            'lang'              => my_trim($this->input->post('language', TRUE)),
            'update_time'       => now(),
            'status'            => STATUS_ACTIVE,
            'lang'              => $this->input->post('lang', TRUE),
            'editor'            => $this->phpsession->get('user_id'),
        );
        return $post_data;
    }
    
    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(SUPPORTS_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_support_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa tài khoản hỗ trợ trực tuyến' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_edit_form_data()
    {
        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $id      = $this->input->post('id');
            $support = $this->supports_model->get_supports(array('id' => $id));
            $title   = $support->title;
            $type    = $support->type;
            $content = $support->content;
            $lang    = $support->lang;
        }

        else
        {
            $id      = $this->input->post('id');
            $title   = my_trim($this->input->post('title', TRUE));
            $type    = $this->input->post('type');
            $content = my_trim($this->input->post('content', TRUE));
            $lang    = my_trim($this->input->post('lang', TRUE));
        }

        $options                = array();
        $options['id']          = $id;
        $options['title']       = $title;
        $options['type']        = $type;
        $options['content']     = $content;
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'class="btn"'));        
        $options['header']      = 'Sửa hỗ trợ trực tuyến';
        $options['button_name'] = 'Lưu dữ liệu';
        $options['submit_uri']  = SUPPORTS_ADMIN_BASE_URL.'/edit';
        return $options;
    }
    /**
     *  sửa trong DB nếu Validate OK
     * @return type
     */
    private function _do_edit()
    {
        $this->form_validation->set_rules('content', 'Tài khoản hỗ trợ', 'trim|required|xss_clean');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['id'] = $this->input->post('id');
            $position_edit = $this->supports_model->position_to_edit_supports(
                        array(
                        'id'=>$this->input->post('id'),
                        'type'=>$post_data['type'],
                        'lang'=>$post_data['lang'],
                        )
                    );
            $post_data['position'] = $position_edit;
            $this->supports_model->update($post_data);

            redirect(SUPPORTS_ADMIN_BASE_URL.'/' . $post_data['lang']);
        }
        return FALSE;
    }

    /**
     * Xóa 
     */
    public function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            $this->supports_model->delete($id);            
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('support_lang');
        redirect(SUPPORTS_ADMIN_BASE_URL . '/' . $lang);
    }

    public function up()
    {
        $id = $this->input->post('id');
        $this->supports_model->item_to_sort_supports(
                    array(
                        'id' => $id,
                    )
                );
        $lang = $this->phpsession->get('support_lang');
        redirect(SUPPORTS_ADMIN_BASE_URL . '/' . $lang);
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $support = $this->supports_model->get_supports(array('id' => $id));
        $status = $support->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->supports_model->update(array('id'=>$id,'status'=>$status));
    }
    
    
}
?>
