<?php 
class Orders_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    public function get_side_orders()
    {
        $config = get_cache('configurations_' .  get_language());
        $page_param = $config['number_orders_per_side'] != 0 ? $config['number_orders_per_side'] : FAQ_PER_SIDE;
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => $page_param,
        );
        
        $orders = $this->orders_model->get_orders($options);
        return $orders;
    }
    
    public function get_home_orders()
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 1,
            'onehit' => TRUE,
        );
        
        $orders = $this->orders_model->get_orders($options);
        return $orders;
    }
    
    public function get_bottom_orders()
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 2,
            'random' => TRUE,
        );
        
        $orders = $this->orders_model->get_orders($options);
        return $orders;
    }
    
    /**
     * 
     * @param type $para1
     * @param type $para2
     */
    
    public function orders_search($para1=NULL, $para2='vi')
    {
        $keyword = $this->db->escape_str($this->input->post('keyword'));
        
        if (isset($keyword) && !empty($keyword)) {
            $this->phpsession->save('orders_search', $keyword);
        } else {
            $keyword = $this->phpsession->get('orders_search');
        }

        $options = array('keyword'=>$keyword,'lang'=>switch_language($para2),'page'=>$para1,'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $orders_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->orders_model->get_orders_count($options);
        $total_pages        = (int)($total_row / $orders_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2);
            $uri_segment = 3;
        }else{
            $base_url = site_url().$this->uri->segment(1);
            $uri_segment = 2;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $orders_per_page,
            'uri_segment'       => $uri_segment,   
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        $orderss = $this->orders_model->get_orders($options);        

        $view_data = array(
            'orderss'          => $orderss,
            'category'      => __('IP_search_result'),
            'total_row'     => $total_row,
            'keyword'       => $keyword,
        );

        $this->_view_data['main_content'] = $this->load->view('orders_search',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function orders_tags($para1=NULL, $para2='vi', $para3=NULL)
    {
        $options = array('lang'=>switch_language($para2),'page'=>$para1,'tags'=>$para3,'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $orders_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->orders_model->get_orders_count($options);
        $total_pages        = (int)($total_row / $orders_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2).'/'.$options['tags'];
            $uri_segment = 4;
        }else{
            $base_url = site_url().$this->uri->segment(1).'/'.$options['tags'];
            $uri_segment = 3;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $orders_per_page,
            'uri_segment'       => $uri_segment,   
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        $orderss = $this->orders_model->get_orders($options);        
        $tags = str_replace('-',' ', $options['tags']);
        $view_data = array(
            'orderss'          => $orderss,
            'category'      => $tags,
            'total_row'     => $total_row,
        );

        $this->_view_data['main_content'] = $this->load->view('orders_tags',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_list_orders_by_cat($para1=NULL, $para2=NULL, $para3=NULL)
    {
        $options = array('cat_id'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $orders_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->orders_model->get_orders_count($options);
        $total_pages        = (int)($total_row / $orders_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2);
            $uri_segment = 3;
        }else{
            $base_url = site_url().$this->uri->segment(1);
            $uri_segment = 2;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $orders_per_page,
            'uri_segment'       => $uri_segment,   
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        //lay tu vi tri so 2, offset+=1
//        $options['offset'] = $options['offset']+1;
        
        $orderss = $this->orders_model->get_orders($options);
        $category = $this->orders_categories_model->get_orders_categories(array('id'=>$options['cat_id']));
        
        //current menu
        $check_id = $category->parent_id;

        if($check_id <> 0){
            while ($check_id <> 0){
                $parent_category = $this->orders_categories_model->get_orders_categories(array('id'=>$check_id));
                if($parent_category->parent_id == 0){
//                    $active_menu = '/dich-vu';
                    $active_menu = '/'.url_title($parent_category->category, 'dash', TRUE) . '-q' .$parent_category->id;
                    break;
                }else{
                    $check_id = $parent_category->parent_id;
                }
            }
        }else{
            $active_menu = NULL;
        }
        
        $title = ($category->meta_title <> '')?$category->meta_title:$category->category;
        $keywords = ($category->meta_keywords <> '')?$category->meta_keywords:$category->category;
        $description = ($category->meta_description <> '')?$category->meta_description:$category->category;
        
        if((!empty($options['lang']) && $options['lang'] <> 'vi') || $this->uri->segment(1) == 'vi'){
            $current_menu = '/' . $this->uri->segment(2);
        }else{
            $current_menu = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'orderss'          => $orderss,
            'category'      => $category->category,
            'category_id'   => $category->id,
            'title'         => $title,
            'keywords'      => $keywords,
            'description'   => $description,
            'current_menu'  => $current_menu,
            'active_menu'   => $active_menu,
        );

        $this->_view_data['main_content'] = $this->load->view('orders',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_orders_detail($para1=NULL, $para2=NULL)
    {
        $options = array('id'=>$para1);
        
        $lang = switch_language($para2);
        
        $this->orders_model->update_orders_view($options['id']);
        
        $orders = $this->orders_model->get_orders($options);
        
        $orders_same = $this->get_list_orders_same(array('cat_id'=>$orders->cat_id,'current_id'=>$options['id'],'limit'=>NEWS_PER_LIST));
        
        //current menu
        $category = $this->orders_categories_model->get_orders_categories(array('id'=>$orders->cat_id));

        $check_id = $category->parent_id;
        if($check_id <> 0){
            while ($check_id <> 0){
                $parent_category = $this->orders_categories_model->get_orders_categories(array('id'=>$check_id));
                if($parent_category->parent_id == 0){
//                    $active_menu = '/dich-vu';
                    $active_menu = '/'.url_title($parent_category->category, 'dash', TRUE) . '-q' .$parent_category->id;
                    break;
                }else{
                    $check_id = $parent_category->parent_id;
                }
            }
        }else{
            $active_menu = NULL;
        }
        
        $current_menu = '/'.url_title($category->category, 'dash', TRUE) . '-q' .$category->id;
        
        if(!empty($lang) && $lang <> 'vi'){
            $current_menu = '/'.$lang.$current_menu;
        }else{
            $current_menu = $current_menu;
        }
        
        $view_data = array(
            'orders'          => $orders,
            'category'      => $orders->category,
            'title'         => ($orders->meta_title <> '')?$orders->meta_title:$orders->title,
            'keywords'      => ($orders->meta_keywords <> '')?$orders->meta_keywords:$orders->title,
            'description'   => ($orders->meta_description <> '')?$orders->meta_description:$orders->title,
            'current_menu'  => $current_menu,
            'active_menu'   => $active_menu,
            'orders_same'     => $orders_same,
            'tags'          => convert_tags_to_array($orders->tags),
        );
        
        $this->_view_data['main_content'] = $this->load->view('orders_detail',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
        
    }
    
    /**
     * tin lien quan / cung loai
     * @param type $options
     * @return type
     */
    public function get_list_orders_same($options=array())
    {
        $options['status'] = STATUS_ACTIVE;
        $options['random'] = TRUE;
        $options['lang'] = $this->_lang;
        
        $orders = $this->orders_model->get_orders($options);
        $view_data = array(
            'category' => __('IP_orders_same'),
            'orders' => $orders,
        );
        return $this->load->view('orders_same', $view_data, TRUE);
    }
    
    public function get_top_orders($cat_id)
    {
        $options = array(
            'status' => STATUS_ACTIVE,
            'lang' => $this->_lang,
            'limit' => 1,
            'onehit' => TRUE,
            'type' => $cat_id,
        );
        $orders = $this->orders_model->get_orders($options);
        $view_data = array(
            'orders' => $orders,
        );
        return $this->load->view('orders_grid_top', $view_data, TRUE);
    }

    public function orders_send($para1='vi')
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> 'vi') || $this->uri->segment(1) == 'vi'){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => __('IP_orders_question_send'),
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $uri,
        );
        
        $ok_orders_message = $this->phpsession->get('ok_orders_message');
        
        if($ok_orders_message == 'ok'){
            $view_data['succeed'] = "Cảm ơn bạn đã gửi câu hỏi.";
        }
        if ($this->is_postback()) {
            if (!$this->_add_orders()) {
                $view_data['error'] = validation_errors();
            }
        }
        
        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_orders_message', '');
        
        $view_data += $this->_get_add_form_data();

        $this->_view_data['main_content'] = $this->load->view('orders_send_question',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    private function _get_add_form_data() 
    {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'orders_title' => $this->input->post('orders_title'),
            'summary' => $this->input->post('summary'),
            'categories_combobox' => $this->orders_categories_model->get_orders_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox'), 'lang'  => get_language(), 'none' => TRUE , 'extra' => 'class="form-control"')),
            'submit_uri' => get_url_by_lang(get_language(), 'orders-send-question'),
        );
        return $options;
    }
    
    private function _get_posted_data()
    {
        $post_data = array(
            'title'     => my_trim($this->input->post('orders_title', TRUE)),
            'summary'   => my_trim($this->input->post('summary', TRUE)),
            'fullname'  => my_trim($this->input->post('fullname', TRUE)),
            'email'     => my_trim($this->input->post('email', TRUE)),
            'cat_id'    => $this->input->post('categories_combobox', TRUE),
            'lang'      => get_language(),
            'status'    => STATUS_INACTIVE,
        );
        $post_data['created_date']  = date('Y-m-d H:i:s');
        $post_data['updated_date']  = date('Y-m-d H:i:s');
        return $post_data;
    }

    private function _add_orders()
    {
        $this->form_validation->set_rules('orders_title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('categories_combobox', 'Lĩnh vực', 'is_not_default_combo');
        $this->form_validation->set_rules('summary', 'Nội dung câu hỏi', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $this->orders_model->insert($post_data);
            $this->phpsession->save('ok_orders_message', 'ok');
            redirect(get_url_by_lang(get_language(), 'orders-send-question'));
        }
        return FALSE;
    }
}
