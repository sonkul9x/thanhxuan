<?php
class Dashboard_Admin extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login');
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = DASHBOARD_ADMIN_BASE_URL;
    }
    
    function browse($para1=DEFAULT_LANGUAGE) {
        $options = array('lang'=>switch_language($para1));

        if (isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) {
            $options['options'] = $options;
        }
        
        //pages
//        $options['pages_count'] = $this->pages_model->get_pages_count();
        
        //contact
        $options['contact_count_total'] = $this->contact_model->get_contact_count();
        $options['contact_count_today'] = $this->contact_model->get_contact_count(array('today'=>TRUE));
        $options['contact_count_yesterday'] = $this->contact_model->get_contact_count(array('yesterday'=>TRUE));
        
        //news
        $options['news_count_total'] = $this->news_model->get_news_count();
        $options['news_count_active'] = $this->news_model->get_news_count(array('status'=>STATUS_ACTIVE));
        $options['news_count_inactive'] = $this->news_model->get_news_count(array('status'=>STATUS_INACTIVE));
        $options['news_list_view'] = $this->news_model->get_news(array('sort_by_viewed'=>TRUE,'limit'=>DASHBOARD_LIST_NUMBER));

        //products
        $options['products_count_total'] = $this->products_model->get_products_count();
        $options['products_count_active'] = $this->products_model->get_products_count(array('status'=>STATUS_ACTIVE));
        $options['products_count_inactive'] = $this->products_model->get_products_count(array('status'=>STATUS_INACTIVE));
        $options['products_list_view'] = $this->products_model->get_products(array('topview'=>TRUE,'limit'=>DASHBOARD_LIST_NUMBER));

        //order
        //$this->load->model('orders/orders_model');
        $options['order_count'] = $this->orders_model->get_orders_count();
        $options['order_count_0'] = $this->orders_model->get_orders_count(array('order_status'=>NEW_ORDER_NEW));
        $options['order_count_1'] = $this->orders_model->get_orders_count(array('order_status'=>NEW_ORDER));
        $options['order_count_2'] = $this->orders_model->get_orders_count(array('order_status'=>ILLUSIVE_ORDER));
        $options['order_count_3'] = $this->orders_model->get_orders_count(array('order_status'=>PAID_ORDER));
        $options['order_count_4'] = $this->orders_model->get_orders_count(array('order_status'=>GCTT));
        
        $options['chart'] = $this->chart_order();
        
        //faq
//        $options['faq_count_total'] = $this->faq_model->get_faq_count();
//        $options['faq_count_active'] = $this->faq_model->get_faq_count(array('status'=>STATUS_ACTIVE));
//        $options['faq_count_inactive'] = $this->faq_model->get_faq_count(array('status'=>STATUS_INACTIVE));
//        $options['faq_list_view'] = $this->faq_model->get_faq(array('topview'=>TRUE,'limit'=>DASHBOARD_LIST_NUMBER));

        $options['header'] = DASHBOARD_ADMIN_TITLE;
        $options['scripts'] = $this->scripts_for_detail();
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/list',$options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = DASHBOARD_ADMIN_TITLE . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    public function chart_order()
    {
       $data_order = $this->orders_model->get_orders_date();
       foreach ($data_order as $key  => $value){
           $json_order_item = array($value->str_created_order + 86400000,$value->total);
           $json_order[] = $json_order_item;
       }
       $json_data_order = json_encode($json_order);
       $json_data_order = str_replace('"','',$json_data_order);

        return $json_data_order;
    }
    
    
    private function scripts_for_detail()
    {
        $scripts  = '<script type="text/javascript" src="'.base_url().'powercms/scripts/highstock.js"></script>';
        $scripts .= '<script type="text/javascript" src="'.base_url().'powercms/scripts/exporting.js"></script>';
//        $scripts .= '<script type="text/javascript">call_colorbox("");</script>';
        return $scripts;
    }
    
}