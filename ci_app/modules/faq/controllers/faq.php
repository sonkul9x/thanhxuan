<?php 
class Faq extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->_layout = 'layout/content_layout';
        $this->_view_data = array(
        );
    }
    
    public function get_data_faq($options=array())
    {
        if(!isset($options['status'])){
            $options['status'] = STATUS_ACTIVE;
        }
        if(!isset($options['lang'])){
            $options['lang'] = $this->_lang;
        }
        $faq = $this->faq_model->get_faq($options);
        return $faq;
    }
    
    public function get_faq_pro($options=array()) {
        $options['status'] = STATUS_ACTIVE;
        $data = $this->faq_professionals_model->get_faq_professionals($options);
        return $data;
    }
    
    /**
     * 
     * @param type $para1
     * @param type $para2
     */
    
    public function faq_search($para1=NULL, $para2=DEFAULT_LANGUAGE)
    {
        $keyword = $this->db->escape_str($this->input->post('keyword'));
        
        if (isset($keyword) && !empty($keyword)) {
            $this->phpsession->save('faq_search', $keyword);
        } else {
            $keyword = $this->phpsession->get('faq_search');
        }

        $options = array('keyword'=>$keyword,'lang'=>switch_language($para2),'page'=>$para1,'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $faq_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->faq_model->get_faq_count($options);
        $total_pages        = (int)($total_row / $faq_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2);
            $uri_segment = 3;
        }else{
            $base_url = site_url().$this->uri->segment(1);
            $uri_segment = 2;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $faq_per_page,
            'uri_segment'       => $uri_segment,   
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        $faqs = $this->faq_model->get_faq($options);        

        $view_data = array(
            'faqs'          => $faqs,
            'category'      => __('IP_search_result'),
            'total_row'     => $total_row,
            'keyword'       => $keyword,
        );

        $this->_view_data['main_content'] = $this->load->view('faq_search',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function faq_tags($para1=NULL, $para2=DEFAULT_LANGUAGE, $para3=NULL)
    {
        $options = array('lang'=>switch_language($para2),'page'=>$para1,'tags'=>$para3,'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $faq_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->faq_model->get_faq_count($options);
        $total_pages        = (int)($total_row / $faq_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2).'/'.$options['tags'];
            $uri_segment = 4;
        }else{
            $base_url = site_url().$this->uri->segment(1).'/'.$options['tags'];
            $uri_segment = 3;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $faq_per_page,
            'uri_segment'       => $uri_segment,   
            'use_page_numbers'  => TRUE,
            'first_link'        => __('IP_paging_first'),
            'last_link'         => __('IP_paging_last'),
            'num_links'         => 1,
        );
        $this->pagination->initialize($paging_config);
        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;
        $options['limit']   = $paging_config['per_page'];
        
        $faqs = $this->faq_model->get_faq($options);        
        $tags = str_replace('-',' ', $options['tags']);
        $view_data = array(
            'faqs'          => $faqs,
            'category'      => $tags,
            'total_row'     => $total_row,
        );

        $this->_view_data['main_content'] = $this->load->view('faq_tags',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_list_faq_by_cat($para1=NULL, $para2=NULL, $para3=NULL)
    {
        $options = array('cat_id'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);
        $config         = get_cache('configurations_' .  $options['lang']);
        $faq_per_page   = $config['news_per_page'] <> 0 ? $config['news_per_page'] : FAQ_PER_PAGE;

        $total_row          = $this->faq_model->get_faq_count($options);
        $total_pages        = (int)($total_row / $faq_per_page);
        
        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2);
            $uri_segment = 3;
        }else{
            $base_url = site_url().$this->uri->segment(1);
            $uri_segment = 2;
        }
        
        $paging_config = array(
            'base_url'          => $base_url,
            'total_rows'        => $total_row,
            'per_page'          => $faq_per_page,
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
        
        $faqs = $this->faq_model->get_faq($options);
        $category = $this->faq_categories_model->get_faq_categories(array('id'=>$options['cat_id']));
        
        //current menu
        $check_id = $category->parent_id;

        if($check_id <> 0){
            while ($check_id <> 0){
                $parent_category = $this->faq_categories_model->get_faq_categories(array('id'=>$check_id));
                if($parent_category->parent_id == 0){
                    if(SLUG_ACTIVE==0){
                        $active_menu = '/'.url_title($parent_category->category, 'dash', TRUE) . '-q' .$parent_category->id;
                    }else{
                        $active_menu = '/'.$parent_category->slug;
                    }
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
        
        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $current_menu = '/' . $this->uri->segment(2);
        }else{
            $current_menu = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'faqs'          => $faqs,
            'category'      => $category->category,
            'category_id'   => $category->id,
            'title'         => $title,
            'keywords'      => $keywords,
            'description'   => $description,
            'current_menu'  => $current_menu,
            'active_menu'   => $active_menu,
        );

        $this->_view_data['main_content'] = $this->load->view('faq',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    public function get_faq_detail($para1=NULL, $para2=NULL)
    {
        $options = array('id'=>$para1);
        
        $lang = switch_language($para2);
        
        $this->faq_model->update_faq_view($options['id']);
        
        $faq = $this->faq_model->get_faq($options);
        
        $faq_same = $this->get_list_faq_same(array('cat_id'=>$faq->cat_id,'current_id'=>$options['id'],'limit'=>FAQ_PER_LIST));
        
        //current menu
        $category = $this->faq_categories_model->get_faq_categories(array('id'=>$faq->cat_id));
        if(!empty($category)){
            if(SLUG_ACTIVE==0){
                $category_slug = '';
            }else{
                $category_slug = $category->slug;
            }
            $check_id = $category->parent_id;
        }else{
            $category_slug = '';
            $check_id = 0;
        }
        
        if($check_id <> 0){
            while ($check_id <> 0){
                $parent_category = $this->faq_categories_model->get_faq_categories(array('id'=>$check_id));
                if($parent_category->parent_id == 0){
                    if(SLUG_ACTIVE==0){
                        $active_menu = '/'.url_title($parent_category->category, 'dash', TRUE) . '-q' .$parent_category->id;
                    }else{
                        $active_menu = '/'.$parent_category->slug;
                    }
                    break;
                }else{
                    $check_id = $parent_category->parent_id;
                }
            }
        }else{
            $active_menu = NULL;
        }
        if(SLUG_ACTIVE==0){
            $current_menu = '/'.url_title($category->category, 'dash', TRUE) . '-q' .$category->id;
        }else{
            $current_menu = '/'.$category_slug;
        }        
        if(!empty($lang) && $lang <> DEFAULT_LANGUAGE){
            $current_menu = '/'.$lang.$current_menu;
        }else{
            $current_menu = $current_menu;
        }
        
        $view_data = array(
            'faq'          => $faq,
            'category'      => $faq->category,
            'category_slug' => $category_slug,
            'title'         => ($faq->meta_title <> '')?$faq->meta_title:$faq->title,
            'keywords'      => ($faq->meta_keywords <> '')?$faq->meta_keywords:$faq->title,
            'description'   => ($faq->meta_description <> '')?$faq->meta_description:$faq->title,
            'current_menu'  => $current_menu,
            'active_menu'   => $active_menu,
            'faq_same'     => $faq_same,
            'tags'          => convert_tags_to_array($faq->tags),
        );
        
        $this->_view_data['main_content'] = $this->load->view('faq_detail',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
        
    }
    
    /**
     * tin lien quan / cung loai
     * @param type $options
     * @return type
     */
    public function get_list_faq_same($options=array())
    {
        $options['status'] = STATUS_ACTIVE;
        $options['lang'] = $this->_lang;
        $faq1 = $this->faq_model->get_faq(array('sort_by_id_high'=>TRUE,'cat_id'=>$options['cat_id'],'current_id'=>$options['current_id'],'limit'=>FAQ_PER_LIST,'lang'=>$options['lang'],'status'=>$options['status']));
        $faq2 = $this->faq_model->get_faq(array('sort_by_id_low'=>TRUE,'cat_id'=>$options['cat_id'],'current_id'=>$options['current_id'],'limit'=>FAQ_PER_LIST,'lang'=>$options['lang'],'status'=>$options['status']));
        if (!empty($faq1) && !empty($faq2)) {
            $faqs = array_merge($faq1, $faq2);
        } elseif (!empty($faq1) && empty($faq2)) {
            $faqs = $faq1;
        } elseif (empty($faq1) && !empty($faq2)) {
            $faqs = $faq2;
        } else {
            $faqs = NULL;
        }
        $view_data = array(
            'category' => __('IP_news_same'),
            'faqs' => $faqs,
        );
        return $this->load->view('faq_same', $view_data, TRUE);
    }
    
    public function faq_send($para1=DEFAULT_LANGUAGE)
    {
        $lang = switch_language($para1);
        if((!empty($lang) && $lang <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){
            $uri = '/'.$lang.'/'.$this->uri->segment(2);
        }else{
            $uri = '/' . $this->uri->segment(1);
        }
        
        $view_data = array(
            'title'         => __('IP_faq_question_send'),
            'keywords'      => __('IP_default_company'),
            'description'   => __('IP_default_company'),
            'current_menu'  => $uri,
        );
        
        $ok_faq_message = $this->phpsession->get('ok_faq_message');
        
        if($ok_faq_message == 'ok'){
            $view_data['succeed'] = "Cảm ơn bạn đã gửi câu hỏi.";
        }
        if ($this->is_postback()) {
            if (!$this->_add_faq()) {
                $view_data['error'] = validation_errors();
            }
        }
        
        if (isset($view_data['error']) || isset($view_data['succeed']) || isset($view_data['warning'])) {
            $view_data['options'] = $view_data;
        }

        $this->phpsession->save('ok_faq_message', '');
        
        $view_data += $this->_get_add_form_data();

        $this->_view_data['main_content'] = $this->load->view('faq_send_question',$view_data, TRUE);

        $this->load->view($this->_layout, $this->_view_data, FALSE);
    }
    
    private function _get_add_form_data() 
    {
        $options = array(
            'fullname' => $this->input->post('fullname'),
            'email' => $this->input->post('email'),
            'tel' => $this->input->post('tel'),
            'faq_title' => $this->input->post('faq_title'),
            'summary' => $this->input->post('summary'),
            'categories_combobox' => $this->faq_categories_model->get_faq_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox'), 'lang'  => get_language(), 'none' => TRUE , 'extra' => 'class="form-control"')),
            'submit_uri' => get_url_by_lang(get_language(), 'faq-send-question'),
        );
        return $options;
    }
    
    private function _get_posted_data()
    {
        $post_data = array(
            'title'     => my_trim($this->input->post('faq_title', TRUE)),
            'summary'   => my_trim($this->input->post('summary', TRUE)),
            'fullname'  => my_trim($this->input->post('fullname', TRUE)),
            'email'     => my_trim($this->input->post('email', TRUE)),
            'tel'       => my_trim($this->input->post('tel', TRUE)),
            'cat_id'    => $this->input->post('categories_combobox', TRUE),
            'lang'      => get_language(),
            'status'    => STATUS_INACTIVE,
        );
        $post_data['created_date']  = date('Y-m-d H:i:s');
        $post_data['updated_date']  = date('Y-m-d H:i:s');
        return $post_data;
    }

    private function _add_faq()
    {
        $this->form_validation->set_rules('faq_title', 'Tiêu đề', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('categories_combobox', 'Lĩnh vực', 'is_not_default_combo');
        $this->form_validation->set_rules('summary', 'Nội dung câu hỏi', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('fullname', 'Họ tên', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('tel', 'Điện thoại', 'trim|xss_clean|max_length[20]');
        $this->form_validation->set_rules('security_code', 'Mã an toàn', 'trim|required|xss_clean|matches_value[' . $this->phpsession->get('captcha') . ']');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $this->faq_model->insert($post_data);
            $this->phpsession->save('ok_faq_message', 'ok');
            redirect(get_url_by_lang(get_language(), 'faq-send-question'));
        }
        return FALSE;
    }
}
