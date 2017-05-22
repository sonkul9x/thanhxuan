<?php

class Advs_Click extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

    }
    
    public function add_click($advs_id)
    {
        if(empty($advs_id) || $advs_id <= 0 || !is_numeric($advs_id)) redirect('#');
        $ua=getBrowser();
        $browser = $ua['name'] . " " . $ua['version'] . " " .$ua['platform'];
        $options = array(
            'advs_id' => $advs_id,
            'click_time' => now(),
//            'browser' => $_SERVER['HTTP_USER_AGENT'],
            'browser' => $browser,
            'backlink' => $_SERVER["HTTP_REFERER"],
            'current_ip' => $_SERVER['REMOTE_ADDR'],
        );
        $this->advs_click_model->insert($options);
        $advs = $this->advs_model->get_advs(array('id'=>$advs_id));
        redirect($advs->url_path);
    }
    
    public function count_click($options=array())
    {
        if(isset($options['advs_id']))
        {
            return $this->advs_click_model->count_by_advs_id($options['advs_id']);
        }else{
            return 0;
        }
    }
}
?>