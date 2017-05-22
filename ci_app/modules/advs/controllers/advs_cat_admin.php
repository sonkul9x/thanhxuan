<?php
class Advs_Cat_Admin extends MY_Controller
{
   function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
    }
    
    /**
     * @desc: Hien thi danh sach 
     * 
     * @param type $options 
     */
    function browse($options = array())
    {
        $options['categories'] = $this->advs_categories_model->get_advs_categories();
                
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('cat/list_cat', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Phân loại banner' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    function add()
    {
        $options = array();
        $view_data  = array();
        if($this->is_postback())
        {
            if (!$this->_do_add_advs_cat())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_advs_cat_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm phân loại banners quảng cáo' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_add_advs_cat()
    {
        $this->form_validation->set_rules('title', 'Tên phân loại', 'trim|required|xss_clean');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_advs_cat_data();
            $post_data['creator'] = $this->phpsession->get('user_id');
//            $supports = $this->supports_model->get_supports(array('last_row' => TRUE, 'lang' => $this->phpsession->get('current_support_lang')));
//            $post_data['position'] = is_object($supports) ? $supports->position + 1 : 1;
            $this->advs_categories_model->insert($post_data);

            redirect(ADVS_CAT_ADMIN_BASE_URL. $this->phpsession->get('current_advs_cat_lang'));
        }
        return FALSE;
    }
    
    private function _get_posted_advs_cat_data()
    {
        $post_data = array(
            'title'             => my_trim($this->input->post('title', TRUE)),
            'dimension'         => my_trim($this->input->post('dimension', TRUE)),
        );
        return $post_data;
    }
    
    private function _get_add_advs_cat_form_data()
    {
        $view_data                  = array();
        $view_data['title']         = $this->input->post('title', TRUE);
        $view_data['dimension']     = $this->input->post('dimension', TRUE);
        $view_data['header']        = 'Thêm phân loại banners';
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['submit_uri']    = ADVS_CAT_ADMIN_BASE_URL.'/add';
        return $view_data;
    }
    
    function edit()
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_cat())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }
        $options  += $this->_get_edit_cat_form_data();

        $options['header']        = 'Sửa phân loại quảng cáo';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = ADVS_CAT_ADMIN_BASE_URL.'/edit';

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('cat/cat_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa phân loại quảng cáo' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_edit_cat()
    {
        $this->form_validation->set_rules('title', 'Tên phân loại', 'trim|required|xss_clean|max_length[255]');
        if($this->form_validation->run())
        {
            $data = array(
                'id'        => $this->input->post('id'),
                'title'     => $this->input->post('title', TRUE),
                'dimension' => $this->input->post('dimension', TRUE),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->advs_categories_model->update($data);

            redirect(ADVS_CAT_ADMIN_BASE_URL);
        }
        return FALSE;
    }
    
    private function _get_edit_cat_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $categories = $this->advs_categories_model->get_advs_categories(array('id' => $id));
            $title      = $categories->title;
            $dimension  = $categories->dimension;
        }
        else
        {
            $title      = my_trim($this->input->post('title', TRUE));
            $dimension  = my_trim($this->input->post('dimension', TRUE));
        }
        $options = array();
        $options['id']           = $id;
        $options['title']            = $title;
        $options['dimension']        = $dimension;
        
        return $options;
    }
    
    function delete()
    {
        $options = array();
        if($this->is_postback()){
            // advs.type = advs_categories.id (id)
            $id = $this->input->post('id');
            $check_advs = $this->advs_model->count_advs(array('type'=>$id));
            
            if($check_advs > 0){
                $options['error'] = 'Không thể xóa phân loại này vì vẫn tồn tại quảng cáo';
            }
            else{
                $this->advs_categories_model->delete($id);
                $options['warning'] = 'Đã xóa thành công';
            }
        }
        return $this->browse($options);
    }

}