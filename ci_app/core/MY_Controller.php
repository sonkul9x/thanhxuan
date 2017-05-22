<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";

class MY_Controller extends MX_Controller 
{
    // Luu giu cac thong bao loi/thanh cong
    protected $_last_message = '';
    // Dat layout mac dinh, neu co thay doi thi se thay trong method tuong ung
    protected $_layout = '';
    // Chua du lieu de chuan bi cho giao dien
    protected $_view_data = array();
    
    protected $_options = array();
    
    function is_postback()
    {
        if (!empty($_POST)) return TRUE;
        return FALSE;
    }
    
    /**
     * @author: dzung.tt
     * @date-create : 7-5-2012
     */
    function link_js( $param )
    {
        if(is_array($param) && sizeof($param) > 0){
            foreach ($param as $key => $value) {
                $this->output->link_js($value);
            }
        } else {
            if(is_string($param)) $this->output->link_js($param);
        }
    }
    
    /**
     * @author: dzung.tt
     * @date-create : 7-5-2012
     */
    function link_css(){
        if(is_array($param) && sizeof($param) > 0){
            foreach ($param as $key => $value) {
                $this->output->link_css($value);
            }
        } else {
            if(is_string($param)) $this->output->link_css($param);
        }
    }
    
}