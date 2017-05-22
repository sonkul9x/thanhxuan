<?php
class Contact_Admin extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = CONTACT_ADMIN_BASE_URL;
    }

    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
        $options = array('page'=>$para2);

        $total_row      = $this->contact_model->get_contact_count($options);
        $total_pages    = (int) ($total_row / CONTACT_ADMIN_POST_PER_PAGE);

        if ($total_pages * CONTACT_ADMIN_POST_PER_PAGE < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * CONTACT_ADMIN_POST_PER_PAGE;
        $options['limit'] = CONTACT_ADMIN_POST_PER_PAGE;

        $config = prepare_pagination(
                array(
                    'total_rows'    => $total_row,
                    'per_page'      => $options['limit'],
                    'offset'        => $options['offset'],
                    'js_function'   => 'change_page_admin'
                )
        );
        
        $this->pagination->initialize($config);
//        $options['is_admin'] = TRUE;
        
        $options['contacts'] = $this->contact_model->get_contact($options);
//        $options['search'] = $options['search'];
        $options['post_uri'] = 'contact';
        $options['e_page'] = $options['page'];
        $options['total_rows'] = $total_row;
        $options['total_pages'] = $total_pages;
        $options['page_links'] = $this->pagination->create_ajax_links();

        $options['uri'] = CONTACT_ADMIN_BASE_URL;
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/contact_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý liên hệ' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    /**
     * Xóa tin
     */
    function delete() 
    {
        $options = array();
        if ($this->is_postback()) {
            $id = $this->input->post('id');
            $this->contact_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
//        return $this->browse($options);
        redirect(CONTACT_ADMIN_BASE_URL);
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $contact = $this->contact_model->get_contact(array('id' => $id));
        $status = $contact->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->contact_model->update(array('id'=>$id,'status'=>$status,'editor'=>$this->phpsession->get('user_id')));
    }
    
}

?>
