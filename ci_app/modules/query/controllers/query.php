<?php

class Query extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function runquery()
    {
//        $i = strtotime("14-06-20");
//        $j = strtotime("13-06-20");
//        $k = $i - $j;
//        $d = $k/3600/24;
//        echo "<pre>";
//        print_r($d);
//        echo "</pre>";
//        exit();
//        $sql = "ALTER TABLE `isws_products` ADD `code` VARCHAR(255) NULL DEFAULT NULL AFTER `description`; ";
//        $query = $this->db->query($sql);
//        if($query) echo "ok";
//        else echo "error";
        exit();
    }
    
    function reloaddate()
    {
        return show_date_vn();
    }
    
    function runconvert()
    {
        exit();
        $prefix = 'ivap_';
        $cat_id = 3;
        $status = STATUS_ACTIVE;
        $sql = '';
        $sql_ = array();
        $sql__ = array();
        $last_menu_id = $this->get_last_id('menus');
        $products_categories = $this->products_categories_model->get_categories();
        if(!empty($products_categories)){
            foreach ($products_categories as $key => $value){
                if($value->level == 0){
                    $last_menu_id += 1;
                    $position = $key + 1;
                    if(SLUG_ACTIVE==0){
                        $url_path = '/' . url_title(trim($value->category), 'dash', TRUE) . '-p' . $value->id;
                    }else{
                        $url_path = '/' . $value->slug;
                    } 
                    $sql_[] = "INSERT INTO `".$prefix."menus` (id,caption,url_path,parent_id,level,cat_id,position,active) VALUES ($last_menu_id,\"$value->category\",\"$url_path\",$value->parent_id,$value->level,$cat_id,$position,$status);";
                    $products_categories_ = $this->products_categories_model->get_categories(array('parent_id'=>$value->id));
                    if(!empty($products_categories_)){
                        foreach($products_categories_ as $k => $v){
                            $position_ = $k + 1;
                            if(SLUG_ACTIVE==0){
                                $url_path_ = '/' . url_title(trim($v->category), 'dash', TRUE) . '-p' . $v->id;
                            }else{
                                $url_path_ = '/' . $v->slug;
                            } 
                            $sql__[] = "INSERT INTO `".$prefix."menus` (caption,url_path,parent_id,level,cat_id,position,active) VALUES (\"$v->category\",\"$url_path_\",$last_menu_id,$v->level,$cat_id,$position_,$status);";
                        }
                    }
                }
            }
        }
        $sql_array = array_merge($sql_, $sql__);
        foreach($sql_array as $sql){
            $query = $this->db->query($sql);
            if($query) echo "ok<br />";
            else echo "error<br />";
        }
//        echo "<pre>";
//        print_r($sql);
//        echo "</pre>";
//        exit();
//        $query = $this->db->query($sql);
//        if($query) echo "ok";
//            else echo "error";
        exit();
    }
    
    private function get_last_id($table='menus')
    {
        $this->db->order_by("id", "desc"); 
        $last_menu = $this->db->get($table, 1, 0);
        return $last_menu->row(0)->id;
    }
    
    public function runconvert_slug()
    {
//        exit();
        $modules = 'products';
        $result = 0;
        switch($modules){
            case 'news' :
                $list = $this->news_model->get_news();
                if(!empty($list)){
                    foreach($list as $key => $value){
                        $data = array(
                            'slug' => url_title(trim($value->title), 'dash', TRUE).SLUG_CHARACTER_URL,
                            'type' => SLUG_TYPE_NEWS,
                            'type_id' => $value->id,
                        );
                        $insert_id = $this->slug_model->insert($data);
                        if($insert_id){
                            $result += 0;
                        }else{
                            $result += 1;
                        }
                    }
                }
                break;
            case 'products' :
                $list = $this->products_model->get_products();
                
                if(!empty($list)){
                    foreach($list as $key => $value){
                        $data = array(
                            'slug' => url_title(trim($value->product_name), 'dash', TRUE).SLUG_CHARACTER_URL,
                            'type' => SLUG_TYPE_PRODUCTS,
                            'type_id' => $value->id,
                        );
                        $insert_id = $this->slug_model->insert($data);
                        if($insert_id){
                            $result += 0;
                        }else{
                            $result += 1;
                        }
                    }
                }
                break;
            default :
                break;
        }
        echo $result;
    }

}
?>