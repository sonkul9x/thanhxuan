<?php
class Breadcrumbs_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_all_news_categories(){
        $result = array();
        $arr =  $this->db->select('*,category as name')
                        ->get('news_categories')
                        ->result_array();
        if($arr){
            foreach ($arr as $key => $value) {
                $result[$value['id']] = $value;
            }
        }
        return $result;
    }
    
    function get_all_product_categories(){
        $result = array();
        $arr =  $this->db->select('*,category as name')
                        ->get('products_categories')
                        ->result_array();
        if($arr){
            foreach ($arr as $key => $value) {
                $result[$value['id']] = $value;
            }
        }
        return $result;
    }
    
    function get_all_menus($options = array()){
        $result = array();
        $arr =  $this->db->select('*,caption as name')
                        ->get('menus')
                        ->result_array();
        if($arr){
            foreach ($arr as $key => $value) {
                $result[$value['id']] = $value;
            }
        }
        return $result;
    }
}
?>