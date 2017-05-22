<?php
class Contact extends MY_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
            'is_one_col' => TRUE,
            'module_name' => 'contact',
        );
    }
    
    public function feedback()
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'limit' => 3,
        );
        $feedbacks = $this->contact_model->get_contact($options);
        return $feedbacks;
    }
    
    function contact_us($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => __('IP_contact_title'),
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $uri,
        );
        
        $ok_contact_message = $this->phpsession->get('ok_contact_message');
        
        if($ok_contact_message == 'ok'){
            $view_data['succeed'] = __('IP_contact_message');
        }
        
        //lien he dat hang
        $product_id = $this->input->post('id',TRUE);
        
        if ($this->is_postback() && empty($product_id)) {
            $list_contact_array = $this->contact_model->get_list_contact_array();
            if(isset($list_contact_array) && in_array($_SERVER['REMOTE_ADDR'],$list_contact_array)){
                $view_data['succeed'] = __('IP_contact_sent');
            }else{
                if (!$this->_do_add_contact())
                $view_data['error'] = validation_errors();
            }
        }elseif(!empty($product_id)){
            $view_data['message'] = __('IP_contact_reserve').$_SERVER["HTTP_REFERER"];
        }
        
        if(isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning']))
                $view_data['options'] = $view_data;
        
        $this->phpsession->save('ok_contact_message', '');
        
        $view_data += $this->_get_add_contact_form_data();
        
        $this->_view_data['main_content'] = $this->load->view('contact',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }

    /**
     * Chuẩn bị dữ liệu cho form add
     * @return type
     */
    private function _get_add_contact_form_data() 
    {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'company' => $this->input->post('company'),
            'email' => $this->input->post('email'),
            'tel' => $this->input->post('tel'),
            'fax' => $this->input->post('fax'),
            'address' => $this->input->post('address'),
            'message' => $this->input->post('message'),
            'created_date' => date('d-m-Y H:i:s'),
            'create_time' => now(),
            'submit_uri' => get_form_submit_by_lang(get_language(),'contact_form'),
        );
        return $options;
    }

    private function _do_add_contact($uri=0) {
        $this->form_validation->set_rules('fullname', __('IP_fullname'), 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('company', __('IP_company'), 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', __('IP_email'), 'trim|required|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('tel', __('IP_tel'), 'trim|required|xss_clean|max_length[20]');
        $this->form_validation->set_rules('fax', __('IP_fax'), 'trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('address', __('IP_address'), 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('message', __('IP_message'), 'trim|xss_clean|max_length[255]');

        if ($this->form_validation->run()) {
            $post_data = $this->_get_posted_contact_data();
            $this->contact_model->insert($post_data);

            $this->phpsession->save('ok_contact_message', 'ok');
            
            // gửi mail cho nguoi nhan email lien he cua khach
            $this->_send_email_contact($post_data);
            
            if($uri==1){
                redirect(base_url().'dang-ky');
            }elseif($uri==2){
                return TRUE;
            }else{
                redirect(get_form_submit_by_lang(get_language(),'contact_form'));
            }
            
        }else{
            return FALSE;
        }
    }

    private function _get_posted_contact_data() {
        $post_data = array(
            'fullname' => my_trim($this->input->post('fullname', TRUE)),
            'company' => my_trim($this->input->post('company', TRUE)),
            'email' => my_trim($this->input->post('email', TRUE)),
            'tel' => my_trim($this->input->post('tel', TRUE)),
            'fax' => my_trim($this->input->post('fax', TRUE)),
            'address' => my_trim($this->input->post('address', TRUE)),
            'message' => my_trim($this->input->post('message', TRUE)),
            'current_ip' => $_SERVER['REMOTE_ADDR'],
            'created_date' => date('Y-m-d H:i:s'),
            'create_time' => now(),
            'status' => STATUS_INACTIVE,
        );
        return $post_data;
    }
    
    private function _send_email_contact($data = array())
    {
        $config = modules::run('configurations/get_configuration', array('array' => TRUE));
        $contact_table = '<table style="border:0" width="100%" cellspacing="0" >
            <caption style="font-weight:bold;text-transform:uppercase;margin:10px 0px;text-align:left;">'.__('IP_contact_info').'</caption>
            <thead>
                <tr style="background-color:#f1f1f1">
                    <th style="width: 25%;border:0;padding:5px;text-align:left;">'.__('IP_info').'</th>
                    <th style="width: 75%;border:0;padding:5px;text-align:left;">'.__('IP_content').'</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border:0;padding:5px;text-align:left;">'.__('IP_fullname').'</td>
                    <td style="border:0;padding:5px;text-align:left;">'.$data['fullname'].'</td>
                </tr>
                <tr>
                    <td style="border:0;padding:5px;text-align:left;">'.__('IP_email').'</td>
                    <td style="border:0;padding:5px;text-align:left;">'.$data['email'].'</td>
                </tr>
                <tr>
                    <td style="border:0;padding:5px;text-align:left;">'.__('IP_tel').'</td>
                    <td style="border:0;padding:5px;text-align:left;">'.$data['tel'].'</td>
                </tr>
                <tr>
                    <td style="border:0;padding:5px;text-align:left;">'.__('IP_message').'</td>
                    <td style="border:0;padding:5px;text-align:left;;word-wrap:break-word;">'.$data['message'].'</td>
                </tr>
            </tbody>
        </table>';
        
        $email_content = $contact_table . '<hr />' . $config['contact_infomation'];

        $data['email_content']  = $email_content;
        $title                  = __('IP_default_contact_title');
        $message                = $this->load->view('email', $data, TRUE);
        
        $contact_email = ($config['contact_email'] != '' && $config['contact_email'] != NULL) ? $config['contact_email'] : CONTACT_EMAIL;
        
        $this->email->from(CONTACT_EMAIL, __('IP_default_contact_title'));
        $this->email->subject($title);
        $this->email->message($message);
        $this->email->to($data['email']);
        $this->email->cc($contact_email);
        //$this->email->bcc('them@their-example.com');
        $this->email->send();
    }

    public function register($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => 'Đăng ký đặt trước',
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $uri,
        );
        
        $ok_contact_message = $this->phpsession->get('ok_contact_message');
        
        if($ok_contact_message == 'ok'){
            $view_data['succeed'] = "Cảm ơn bạn đã đăng ký. Chúng tôi sẽ liên lạc lại với bạn trong thời gian sớm nhất.";
        }
                
        if ($this->is_postback()) {
            $list_contact_array = $this->contact_model->get_list_contact_array();
            if(isset($list_contact_array) && in_array($_SERVER['REMOTE_ADDR'],$list_contact_array)){
                $view_data['succeed'] = "Bạn đã gửi thông tin đăng ký. Xin mời quay lại sau ít phút.";
            }else{
                if (!$this->_do_add_contact(1))
                $view_data['error'] = validation_errors();
            }
        }
        
        if(isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning']))
                $view_data['options'] = $view_data;
        
        $this->phpsession->save('ok_contact_message', '');
        
        $view_data += $this->_get_add_contact_form_data();
        
        $view_data['submit_uri'] = 'dang-ky';
        
        $this->_view_data['main_content'] = $this->load->view('register',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function contact_quick()
    {
        if ($this->is_postback()) {
            $list_contact_array = $this->contact_model->get_list_contact_array();
            if(isset($list_contact_array) && in_array($_SERVER['REMOTE_ADDR'],$list_contact_array)){
                echo 2;
            }else{
                if($this->_do_add_contact(2)){
                    echo 1;
                }else{
                    echo 0;
                }
            }
        }else{
            echo 0;
        }
    }
    
}

?>
