<?php

class Supports extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function get_supports($options = array())
    {
        $options['status'] = STATUS_ACTIVE;
        $options['lang'] = $this->_lang;
        if(isset($options['tel'])){
            $options['type'] = TELEPHONE;
            $supports = $this->supports_model->get_supports($options);
            return $supports;
        }elseif(isset($options['data'])){
            $supports = $this->supports_model->get_supports($options);
            return $supports;
        }else{
            $view_data['supports'] = $this->supports_model->get_supports($options);
            return $this->load->view('common/side_supports', $view_data, TRUE);
        }
    }
}
?>