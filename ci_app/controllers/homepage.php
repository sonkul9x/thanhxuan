<?php
class Homepage extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $current_menu = '/' . $this->uri->uri_string();
        $layout = 'layout/home_layout';
        //load cache
        $this->load->helper('cache');
        $config = get_cache('configurations_' .  get_language());
        $view_data = array(
            'current_menu' => $current_menu,
            'is_home' => TRUE,
            'title' => $config['meta_title'] . DEFAULT_TITLE_SUFFIX,
            'keywords' => $config['meta_keywords'],
            'description' => $config['meta_description'],
            'scripts' => $this->_scripts(),
        );
        $this->load->view($layout, $view_data, FALSE);
    }
    
    private function _scripts()
    {
        $scripts = ' ';     
        return $scripts;
    }

    function get_sitemap_xml()
    {
        $this->load->model('sitemap_model');
        header("Content-Type: text/xml;charset=iso-8859-1");
        echo $this->sitemap_model->generate_sitemap();
    }

}

?>



    