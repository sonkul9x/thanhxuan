<?php
class Reserve extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    function reserve_now($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => __('IP_reserve_title'),
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $uri,
            'scripts'       => $this->_scripts(),
        );
        
        $ok_reserve_message = $this->phpsession->get('ok_reserve_message');
        
        if($ok_reserve_message == 'ok'){
            $view_data['succeed'] = "Cảm ơn bạn đã đặt bàn trước. Chúng tôi sẽ liên lạc lại với bạn trong thời gian sớm nhất.";
        }
        
        if ($this->is_postback()) {
            if (!$this->_send_email_reserve()) {
                $view_data['error'] = validation_errors();
            }
        }
        
        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_reserve_message', '');
        
        $view_data += $this->_get_add_reserve_form_data();

        $this->_view_data['main_content'] = $this->load->view('reserve',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_reserve_form_data() 
    {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'tel' => $this->input->post('tel'),
            'number' => $this->input->post('number'),
            'time' => $this->input->post('time'),
            'message' => $this->input->post('message'),
            'created_date' => date('d-m-Y H:i:s'),
            'create_time' => now(),
            'submit_uri' => get_form_submit_by_lang(get_language(),'reserve_form'),
        );
        return $options;
    }

    private function _send_email_reserve() {
        $this->form_validation->set_rules('fullname', __('IP_fullname'), 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', __('IP_email'), 'trim|required|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('tel', __('IP_tel'), 'trim|required|xss_clean|max_length[20]');
        $this->form_validation->set_rules('number', __('IP_number'), 'trim|required|is_numeric|xss_clean|max_length[3]');
        $this->form_validation->set_rules('time', __('IP_time'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', __('IP_address'), 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('message', __('IP_message'), 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('security_code', __('IP_capcha'), 'trim|required|matches_value[' . $this->phpsession->get('captcha') . ']|xss_clean');

        if ($this->form_validation->run()) {
            $config = modules::run('configurations/get_configuration', array('array' => TRUE));
            
            $post_data = $this->_get_posted_reserve_data();
            $time = datetimepicker_array($post_data['time']);
            $post_data['time'] = convert_time_vn($time);
            
            $title     = __('IP_default_contact_title');
            $message   = $this->load->view('email', $post_data, TRUE);

            $reserve_email = ($config['contact_email'] != '' && $config['contact_email'] != NULL) ? $config['contact_email'] : CONTACT_EMAIL;
            
            $this->email->from(CONTACT_EMAIL, $title);
            $this->email->subject($title);
            $this->email->message($message);
            $this->email->to($post_data['email']);
            $this->email->cc($reserve_email);
            //$this->email->bcc('them@their-example.com');
            $this->email->send();
            
            $this->phpsession->save('ok_reserve_message', 'ok');
            
            redirect(get_form_submit_by_lang(get_language(),'reserve_form'));
        }
        return FALSE;
    }

    private function _get_posted_reserve_data() {
        $post_data = array(
            'fullname' => my_trim($this->input->post('fullname', TRUE)),
            'email' => my_trim($this->input->post('email', TRUE)),
            'tel' => my_trim($this->input->post('tel', TRUE)),
            'number' => my_trim($this->input->post('number', TRUE)),
            'time' => my_trim($this->input->post('time', TRUE)),
            'message' => my_trim($this->input->post('message', TRUE)),
            'current_ip' => $_SERVER['REMOTE_ADDR'],
            'created_date' => date('Y-m-d H:i:s'),
            'create_time' => now(),
//            'status' => STATUS_INACTIVE,
        );
        return $post_data;
    }
    
    private function _scripts()
    {
        $scripts = '<script type="text/javascript" src="'.base_url().'plugins/datetimepicker/jquery-ui-timepicker-addon.min.js"></script>';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/datetimepicker/jquery-ui-sliderAccess.js"></script>';
        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/datetimepicker/i18n/jquery-ui-timepicker-vi.js"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/datetimepicker/jquery-ui.css" />';
        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/datetimepicker/jquery-ui-timepicker-addon.min.css" />';
        
        return $scripts;
    }
    
}

?>
