<?php

/**
 * @author : dzung.tt
 * @date : 15-5-2012
 */
class Breadcrumbs extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    /*
     * Tạo breadcrumbs cho news detail
     */

    function breadcrumbs_news_detail($options = array()) {

        $news = $this->db->select('id,cat_id, title as name ')
                ->get_where('news', array('id' => $options['id']))
                ->row_array();
        
        $category_id = isset($news['cat_id']) ? $news['cat_id'] : NEWS_CATEGORIES_PARENT_ID;
		
		//$this->db->where(array('id' => 1))->update('news_categories',array('parent_id' => '0'));

        // array  đã chuẩn hóa có index là id của row
        $categories = $this->breadcrumbs_model->get_all_news_categories();
		
		//echo '<pre>';
		//print_r($categories);
		//echo '</pre>'; die;
		
        $arr = $this->_get_parent_categories($category_id, $categories);
        $arr[] = array('uri' => get_base_url(), 'name' => __('IP_home_page'));
        //$arr = array_merge(array($news), $arr) ;
        $breadcrumbs_links = _print_breadcrumbs_links($arr);
        $this->output->page_breadcrumbs($breadcrumbs_links);
        return $this->load->view('breadcrumbs', false, true);
    }

    /*
     * Tạo breadcrumbs cho danh muc tin tức
     */

    function breadcrumbs_categories($options = array()) {

        $category = $this->db->select('id,category as name')
                ->get_where('news_categories', array('id' => $options['cat_id']))
                ->row_array();

        $category_id = isset($category['id']) ? $category['id'] : NEWS_CATEGORIES_PARENT_ID;

        // array  đã chuẩn hóa có index là id của row
        $categories = $this->breadcrumbs_model->get_all_news_categories();
        $arr = $this->_get_parent_categories($category_id, $categories);
		
        $breadcrumbs_links = _print_breadcrumbs_links($arr);
        $this->output->page_breadcrumbs($breadcrumbs_links);
        return $this->load->view('breadcrumbs', false, true);
    }
    
    function breadcrumbs_product_categories($options = array()) {

        $category = $this->db->select('id,category as name')
                ->get_where('products_categories', array('id' => $options['cat_id']))
                ->row_array();

        $category_id = isset($category['id']) ? $category['id'] : 0;

        // array  đã chuẩn hóa có index là id của row
        $categories = $this->breadcrumbs_model->get_all_product_categories();
        $arr = $this->_get_parent_product_categories($category_id, $categories);
        $arr[] = array('uri' => get_url_by_lang(switch_language($this->uri->segment(1)),'products'), 'name' => __('IP_Products'));
        $arr[] = array('uri' => get_base_url(), 'name' => __('IP_home_page'));
        $breadcrumbs_links = _print_breadcrumbs_links($arr);
        $this->output->page_breadcrumbs($breadcrumbs_links);
        return $this->load->view('breadcrumbs', false, true);
    }

    function breadcrumbs_with_param($options = array()) {
        $breadcrumbs_links = _print_breadcrumbs_links($options);
        $this->output->page_breadcrumbs($breadcrumbs_links);
        return $this->load->view('breadcrumbs', false, true);
    }

    /*
     * Tạo breadcrumbs theo menu
     */

    function breadcrumbs_by_menus($options = array()) {
        $menu = $this->db->select('id,caption as name')
                ->get_where('menus', array('url_path' => $options['uri']))
                ->row_array();

        $menu_id = isset($menu['id']) ? $menu['id'] : FRONT_END_MENU;

        // array  đã chuẩn hóa có index là id của row
        $menus = $this->breadcrumbs_model->get_all_menus(array('parent_id' => FRONT_END_MENU));
        $arr = $this->_get_parent_menus($menu_id, $menus);
        $arr[] = array('uri' => get_base_url(), 'name' => __('IP_home_page'));
        $breadcrumbs_links = _print_breadcrumbs_links($arr);
        $this->output->page_breadcrumbs($breadcrumbs_links);
        return $this->load->view('breadcrumbs', false, true);
    }

    private function _get_parent_menus($menu_id, $menus, $count = 0) {
        $arr = array();
        if (isset($menus[$menu_id])) {
            $current = $menus[$menu_id];
            $current['uri'] = $current['url_path'];
            $arr[$count] = $current;
            $count++;
            if ($current['parent_id'] != FRONT_END_MENU) {
                $temp = $this->_get_parent_menus($current['parent_id'], $menus, $count);
                $arr += $temp;
            }
            return $arr;
        }
        return false;
    }

    private function _get_parent_categories($category_id, $categories, $count = 0) {
        $arr = array();
        if (isset($categories[$category_id])) 
        {
            $current = $categories[$category_id];
            $current['uri'] = get_base_url(). url_title($current['category'], 'dash', TRUE) . "-n" . $current['id'];
            $arr[$count] = $current;
            $count++;
            if ($current['parent_id'] != NEWS_CATEGORIES_PARENT_ID) 
            {
                $temp = $this->_get_parent_categories($current['parent_id'], $categories, $count);
                $arr += $temp;
            }
            return $arr;
        }
        return false;
    }
    
    private function _get_parent_product_categories($category_id, $categories, $count = 0) {
        $arr = array();
        if (isset($categories[$category_id])) {
            $current = $categories[$category_id];
            $current['uri'] = get_base_url(). url_title($current['category'], 'dash', TRUE) . "-c" . $current['id'];
            $arr[$count] = $current;
            $count++;
            if ($current['parent_id'] != NEWS_CATEGORIES_PARENT_ID) {
                $temp = $this->_get_parent_product_categories($current['parent_id'], $categories, $count);
                $arr += $temp;
            }
            return $arr;
        }
        return false;
    }

}

?>