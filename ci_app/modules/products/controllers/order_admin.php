<?php
class Order_Admin extends MX_Controller
{
    function  __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->load->model('orders_model');
        $this->load->helper('orders');
        $this->output->enable_profiler(TRUE);
    }
    
    function dispatcher($method='', $para1=NULL, $para2=NULL)
    {
        $layout             = 'powercms/admin_layout';
        $current_url        = '';

        switch ($method)
        {
            // PRODUCTS
            case 'list_products':
            case 'dashboard':
                $lang = switch_language($para1);
                $this->phpsession->save('product_lang', $lang);
                $main_content           = $this->list_products(array('lang' => $lang, 'page' => $para2));
                $current_url            = PRODUCTS_ADMIN_BASE_URL;
                break;
            case 'add_product':
                $main_content           = $this->add_product();
                break;
            case 'edit_product':
                $main_content           = $this->edit_product(array('product_id' => $para1));
                break;
            case 'delete_product':
                $main_content           = $this->delete_product(array('product_id' => $para1));
                break;
            case 'up_product':
                $main_content           = $this->up_product(array('product_id' => $para1));
                break;
            case 'list_orders':
                $main_content           = $this->list_orders(array('page' => $para1));
                $current_url            = '/dashboard/orders';
                break;
            case 'edit_order' :
                $main_content           = $this->edit_order(array('id' => $para1));
                break;
        }

        $view_data                  = array();
        $view_data['url']           = isset($current_url) ? $current_url : '';
//        $view_data['admin_menu']    = modules::run('menus/menus/get_dashboard_menus');
        $view_data['main_content']  = $main_content;
        // META data
        $view_data['title']         = $this->_title;
        $this->load->view($layout, $view_data);
    }
    
    function list_orders($options = array())
    {
        $options            = array_merge($options, $this->_prepare_search());
        $total_row          = $this->orders_model->get_orders_count($options);
        $total_pages        = (int)($total_row / PRODUCTS_ORDER_PER_PAGE);
        if ($total_pages * PRODUCTS_ORDER_PER_PAGE < $total_row) $total_pages++;
        if ((int)$options['page'] > $total_pages) $options['page'] = $total_pages;

        $options['offset']  = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int)$options['page'] - 1) * PRODUCTS_ORDER_PER_PAGE;
        $options['limit']   = PRODUCTS_ORDER_PER_PAGE;

        $config = prepare_pagination(
            array(
                'total_rows'    => $total_row,
                'per_page'      => $options['limit'],
                'offset'        => $options['offset'],
                'js_function'   => 'change_page_admin'
            )
        );
        $this->pagination->initialize($config);

        $view_data = array();
        $view_data['orders']                = $this->orders_model->get_orders($options);
        $view_data['search']                = $options['keyword'];
//        $view_data['post_uri']              = 'pages';
        $view_data['page']                  = $options['page'];
        $view_data['total_rows']            = $total_row;
        $view_data['total_pages']           = $total_pages;
        $view_data['page_links']            = $this->pagination->create_ajax_links();
        $view_data['filter']                 = $options['filter'];
        return $this->load->view('admin/orders/list_order', $view_data, TRUE);
    }

    private function _prepare_search()
    {
        $view_data = array();
        $options = array();
        // nếu submit
        if($this->is_postback())
        {
            $this->phpsession->save('customer_name_search', $this->db->escape_str($this->input->post('search')));
            $options['year']    = $this->input->post('year');
            $options['month']   = $this->input->post('month');
            $options['day']     = $this->input->post('day');
            $this->phpsession->save('date_filter',$options);
            
        }
        else
        {
            $date_filter = $this->phpsession->get('date_filter');
            // kiểm tra xem biến vừa rồi có phải là một mảng ko
            //nếu đúng thì gán các lựa chọn = biến vừa rồi
            if(is_array($date_filter ))
            {
                $options = $date_filter;
            }
            else
            {
                // lay gia tri combo mac dinh la ngay thang nam hien tai
                $options['year']    = date('Y');
                $options['month']   = date('m');
                $options['day']     = date('d');
            }
        }
//        echo '<pre>';
//        print_r ($date_filter);
//        echo '</pre>';die;
        $view_data['year']              = $this->utility_model->get_years_combo(array('combo_name' => 'year', 'from_year' => 2012,
                                                                 'to_year' => date('Y'), 'year' => $options['year']));
        $view_data['month']             = $this->utility_model->get_months_combo(array('combo_name' => 'month', 'month' => $options['month']));
        $view_data['day']               = $this->utility_model->get_days_combo(array('combo_name' => 'day', 'day' => $options['day']));

        $view_data['search']            = $this->phpsession->get('customer_name_search');
        $view_data['status']            = $this->utility_model->get_order_status_combo(array('status'=>$this->input->post('status'), 'ALL'=>TRUE));;
        $options['status']              = $this->input->post('status');
        $options['keyword']             = $this->phpsession->get('customer_name_search');
        $options['filter']              = $this->load->view('admin/orders/filter_form', $view_data, TRUE);
        return $options;
    }

    function edit_order($options = array())
    {
        if ($this->is_postback())
        {
            if (!$this->_do_edit_order($options))
                $options['error'] = validation_errors();
        }
        $view_data  = array();
        $view_data  = $this->_get_form_edit_order($options);
        if (isset($options['error'])) $view_data['options']   = $options;
        $view_data['submit_uri']    = '/dashboard/orders/edit/'. $options['id'];
        $view_data['button_name']   = 'Lưu dữ liệu';
        $view_data['header']        = 'Sửa đơn hàng';

        //heading
        $this->_title       = 'Sửa hóa đơn' . DEFAULT_TITLE_SUFFIX;
        $this->_keywords    = $this->_title . ' ' . $this->_keywords;
        $content            = $this->_description;
        $this->_description = my_trim(remove_new_line($content));

        return $this->load->view('admin/orders/edit_order_form', $view_data, TRUE);
    }

    /*
     * @author Thế Cường
     */
    private function _get_form_edit_order($options = array())
    {
        $order = $this->orders_model->get_orders(array('order_id' => $options['id']));
        if(!is_object($order)) show_404();
        if(!$this->is_postback())
        {
            $status       = $order->order_status;
        }
        else
        {
            $status   = $this->input->post('status');
        }
        $view_data = array();

        $view_data['order_id']      = $options['id'];
        $view_data['status']        = $this->utility_model->get_order_status_combo(array('status' => $status));
        return $view_data;
    }

    /*
     * @author Thế Cường
     */
    private function _do_edit_order($options = array())
    {
        //validate
        if($this->input->post('submit') === 'Sửa')
        {
            $data = array(
                'id'        => $options['id'],
                'order_status'      => $this->input->post('status'),
            );
            $this->orders_model->update_order($data);
            redirect('/dashboard/orders', 'refresh');
        }
    }

    /*
     * @author Thế Cường
     */
    public function delete_order($id = 0)
    {
        $this->orders_model->delete_order($id);
        redirect('/dashboard/orders', 'refresh');
    }
}
?>
