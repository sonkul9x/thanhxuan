<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output
{
    private $js_files = array();
    private $js_tags = '';

    private $css_files = array();
    private $css_tags = '';
    
    private $javascripts = '';
    private $script_tag = '';

    private $breadcrumbs = '';


        //Hàm impport file javascript vào header.
    public function link_js($file_path = null)
    {
        if($file_path && !in_array($file_path ,$this->js_files))
        {
            $this->js_files[] = $file_path;
        }
    }

    //Hàm impport file style vào header.
    public function link_css($file_path = null)
    {
        if($file_path && !in_array($file_path ,$this->css_files))
        {
            $this->css_files[] = $file_path;
        }
    }
    
    public function meta_tag($content, $type){
        $this->metas[] = array(
                                'content' => $content, 
                                'type' => $type
                             );
    }
    public function javascripts($content = ''){
        $this->javascripts .= $content;
    }

    private function buildtags()
    {
        if(!empty($this->js_files))
        {
            foreach($this->js_files as $file_path ) {
                //if( file_exists( $file_path ) )
                    $this->js_tags .= '<script type="text/javascript" src="'.$file_path.'"></script>';
            }
        }
        if(!empty($this->css_files))
        {
            foreach($this->css_files as $file_path) {
                //if( file_exists( $file_path ) )
                $this->css_tags .= '<link type="text/css" href="'.$file_path.'" rel="stylesheet" />';
            }
        }
        
        if(!empty($this->javascripts) && $this->javascripts != '')
        {
            $this->script_tag = '<script type="text/javascript">'.$this->javascripts.'</script>';
        }
    }
    
    public function page_breadcrumbs( $bkc_str = '' ){
        $this->breadcrumbs = $bkc_str;
    }

        //Override the main output function that sends content to the browser
    //and slap in the javascript and css where we need it.
    function _display($output = '')
    {
        $this->buildtags();
        $this->final_output = str_replace('{IMPORT_JS}', $this->js_tags, $this->final_output);
        $this->final_output = str_replace('{IMPORT_CSS}', $this->css_tags, $this->final_output);
        $this->final_output = str_replace('{BREADCRUMBS}', $this->breadcrumbs, $this->final_output);
        $this->final_output = str_replace('{JAVASCRIPTS}', $this->script_tag, $this->final_output);
        parent::_display($output);
    }
}
