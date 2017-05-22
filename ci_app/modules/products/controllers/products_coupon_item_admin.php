<?php
class Products_Coupon_Item_Admin extends MY_Controller {
    function __construct() {
        parent::__construct();
        modules::run('auth/auth/validate_login');
        $this->_layout = 'admin_ui/layout/main';
    }

    function browse($para1=DEFAULT_LANGUAGE, $para2=1) {
        $options = array('lang'=>switch_language($para1),'page'=>$para2);
        $options = array_merge($options, $this->_get_data_from_filter());
        $total_row = $this->products_coupon_item_model->get_products_coupon_item_count($options);
        $total_pages = (int)($total_row / PRODUCTS_ADMIN_PRODUCT_PER_PAGE);
        if ($total_pages * PRODUCTS_ADMIN_PRODUCT_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * PRODUCTS_ADMIN_PRODUCT_PER_PAGE;
        $options['limit'] = PRODUCTS_ADMIN_PRODUCT_PER_PAGE;
        
        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);
        $options['page_links']    = $this->pagination->create_ajax_links();
        $options['products_coupon_item'] = $this->products_coupon_item_model->get_products_coupon_item($options);
        $options['total_rows']    = $total_row;
        $options['total_pages']   = $total_pages;
        $options['page']          = $options['page'];
        
        if($options['lang'] <> DEFAULT_LANGUAGE){
            $options['uri'] = PRODUCTS_COUPON_ITEM_ADMIN_BASE_URL . '/' . $options['lang'];
        }else{
            $options['uri'] = PRODUCTS_COUPON_ITEM_ADMIN_BASE_URL;
        }
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        $this->_view_data['main_content'] = $this->load->view('admin/products_coupon_item/list', $options, TRUE);
        $this->_view_data['title'] = 'Coupon code' . DEFAULT_TITLE_SUFFIX;
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search'] = $this->db->escape_str($this->input->post('search', TRUE));
            $this->phpsession->save('products_coupon_item_search_options', $options);
        }
        else
        {
            $temp_options = $this->phpsession->get('products_coupon_item_search_options');
            if (is_array($temp_options))
            {
                $options['search'] = $temp_options['search'];
            }
            else
            {
                $options['search'] = '';
            }
        }
        return $options;
    }

    function delete() {
        if ($this->is_postback() && $this->input->post('from_list')) {
            $id = $this->input->post('id');
            $this->products_coupon_item_item_model->delete(array('coupon_id'=>$id));
            redirect(PRODUCTS_COUPON_ITEM_ADMIN_BASE_URL);
        }
    }

    function change_status()
    {
        $id = $this->input->post('id');
        $data = $this->products_coupon_item_model->get_products_coupon_item(array('id' => $id));
        $status = $data->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->products_coupon_item_model->update(array('id'=>$id,'status'=>$status));
    }

}