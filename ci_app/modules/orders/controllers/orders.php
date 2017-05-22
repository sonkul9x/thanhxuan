<?php 
class Orders_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    public function orders_send($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => __('IP_orders_question_send'),
            'keywords'      => DEFAULT_COMPANY,
            'description'   => DEFAULT_COMPANY,
            'current_menu'  => $uri,
        );
        
        $ok_orders_message = $this->phpsession->get('ok_orders_message');
        
        if($ok_orders_message == 'ok'){
            $view_data['succeed'] = "Cảm ơn bạn đã gửi câu hỏi.";
        }
        if ($this->is_postback()) {
            if (!$this->_add_orders()) {
                $view_data['error'] = validation_errors();
            }
        }
        
        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_orders_message', '');
        
        $view_data += $this->_get_add_form_data();

        $this->_view_data['main_content'] = $this->load->view('orders_send_question',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    private function _get_add_form_data() 
    {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'orders_title' => $this->input->post('orders_title'),
            'summary' => $this->input->post('summary'),
            'categories_combobox' => $this->orders_categories_model->get_orders_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox'), 'lang'  => get_language(), 'none' => TRUE , 'extra' => 'class="form-control"')),
            'submit_uri' => get_url_by_lang(get_language(), 'orders-send-question'),
        );
        return $options;
    }
    
    private function _get_posted_data()
    {
        $post_data = array(
            'title'     => my_trim($this->input->post('orders_title', TRUE)),
            'summary'   => my_trim($this->input->post('summary', TRUE)),
            'fullname'  => my_trim($this->input->post('fullname', TRUE)),
            'email'     => my_trim($this->input->post('email', TRUE)),
            'cat_id'    => $this->input->post('categories_combobox', TRUE),
            'lang'      => get_language(),
            'status'    => STATUS_INACTIVE,
        );
        $post_data['created_date']  = date('Y-m-d H:i:s');
        $post_data['updated_date']  = date('Y-m-d H:i:s');
        return $post_data;
    }

    private function _add_orders()
    {
        $this->form_validation->set_rules('orders_title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('categories_combobox', 'Lĩnh vực', 'is_not_default_combo');
        $this->form_validation->set_rules('summary', 'Nội dung câu hỏi', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $this->orders_model->insert($post_data);
            $this->phpsession->save('ok_orders_message', 'ok');
            redirect(get_url_by_lang(get_language(), 'orders-send-question'));
        }
        return FALSE;
    }
}
