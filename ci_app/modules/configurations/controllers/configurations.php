<?php

class Configurations extends MX_Controller 
{
    function __construct() 
    {
        parent::__construct();
    }
    
    function get_configuration($options = array())
    {
        $config = $this->configurations_model->get_configuration($options);
        return $config;
    }
}

?>
