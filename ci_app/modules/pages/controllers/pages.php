<?php
class Pages extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    function page_detail($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        
        if(SLUG_ACTIVE==0){
            if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
                $uri = '/'.$lang.'/'.$this->uri->segment(2);
            }else{
                $uri = '/' . $this->uri->segment(1);
            }
            $options = array(
                'uri' => $uri,
                'array' => TRUE,
            );
            $pages = get_cache('pages');

            if(!isset($pages) || empty($pages[$options['uri']])) {
                $page = $this->pages_model->get_pages($options);
            }else{
                $page = $pages[$options['uri']];
            }
        }else{
            if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
                $slug = $this->uri->segment(2);
                $uri = '/' . $slug;
            }else{
                $slug = $this->uri->segment(1);
                $uri = '/' . $slug;
            }
            $options = array(
                'slug' => $slug,
                'array' => TRUE,
            );
            $pages = get_cache('pages');

            if(!isset($pages) || empty($pages['/'.$options['slug']])) {
                $page = $this->pages_model->get_pages($options);
            }else{
                $page = $pages['/'.$options['slug']];
            }
        }
        
        $this->pages_model->update_page_view($page['id']);
        save_cache('pages');
        
        $view_data = array(
            'page' => $page,
            'title' => ($page['meta_title'] <> '')?$page['meta_title']:$page['title'],
            'keywords' => ($page['meta_keywords'] <> '')?$page['meta_keywords']:$page['title'],
            'description' => ($page['meta_description'] <> '')?$page['meta_description']:$page['summary'],
            'current_menu' => $uri,
        );

        $this->_view_data['main_content'] = $this->load->view('page_detail',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    function get_page_data($options = array())
    {
        $output = array();
        $pages = $this->pages_model->get_pages($options);
        if(isset($pages)){
            foreach ($pages as $page) {
                if(SLUG_ACTIVE==0){
                    $output[$page['uri']] = $page;
                }else{
                    $output['/'.$page['slug']] = $page;
                }
            }
        }
        return $output;
    }

    function get_about_page()
    {
        if(SLUG_ACTIVE==0){
            $options = array(
                'uri' => '/gioi-thieu.html',
                'array' => TRUE,
            );
            $pages = get_cache('pages');
            if(!isset($pages) || empty($pages[$options['uri']])) {
                $page = $this->pages_model->get_pages($options);
            }else{
                $page = $pages[$options['uri']];
            }
        }else{
            $options = array(
                'slug' => 'gioi-thieu.html',
                'array' => TRUE,
            );
            $pages = get_cache('pages');
            if(!isset($pages) || empty($pages[$options['slug']])) {
                $page = $this->pages_model->get_pages($options);
            }else{
                $page = $pages['/'.$options['slug']];
            }
        }
        return $page;
    }
    
    public function get_page($uri=NULL){
        if (empty($uri)) {
            return NULL;
        }
        $pages = get_cache('pages');
        if(!isset($pages) || empty($pages[$uri])) {
            $page = $this->pages_model->get_pages(array('uri'=>$uri));
        }else{
            $page = $pages[$uri];
        }
        return $page;
    }
    
}

?>
