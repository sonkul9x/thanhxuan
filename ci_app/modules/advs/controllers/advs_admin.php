<?php 
class Advs_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = ADVS_ADMIN_BASE_URL;
    }

    function browse($para1=DEFAULT_LANGUAGE)
    {
        $options            = array('lang'=>switch_language($para1));
        $options            = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('advs_lang', $options['lang']);
                        
        $options['advs'] = $this->advs_model->get_advs($options);
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        $options['categories_combobox']   = $this->advs_categories_model->get_advs_categories_combo(array('categories_combobox' => $options['type'], 'extra' => 'class="btn"'));
        
        $options['total_rows'] = count($options['advs']);

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content']   = $this->load->view('admin/advs_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý Banners quảng cáo' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    /**
     * Lấy dữ liệu từ filter
     * @return string
     */
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['type'] = $this->input->post('categories_combobox', TRUE);
            $this->phpsession->save('advs_search_options', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('advs_search_options');
            if (is_array($temp_options))
            {
                $options['type'] = $temp_options['type'];
            }
            else
            {
                $options['type'] = DEFAULT_COMBO_VALUE;
            }
        }
//        $options['offset'] = $this->uri->segment(3);
        return $options;
    }
    
    function add()
    {
        $options = array();
        $view_data  = array();
        if($this->is_postback())
        {
            if (!$this->_do_add())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options += $this->_get_add_form_data();
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/advs_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm quảng cáo' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_add()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('summary', 'Mô tả ngắn', 'trim|xss_clean|max_length[500]');
        $this->form_validation->set_rules('url_path', 'Đường dẫn khi click vào', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('categories_combobox', 'Phân loại banner', 'is_not_default_combo');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['created_date'] = date('Y-m-d H:i:s');
            $post_data['creator'] = $this->phpsession->get('user_id');
            $post_data['editor'] = $this->phpsession->get('user_id');
            $position_add = $this->advs_model->position_to_add_advs(
                        array(
                            'type'=>$post_data['type'],
                            'lang'=>$post_data['lang'],
                        )
                    );
            $post_data['position'] = $position_add;
            $this->advs_model->insert($post_data);
            redirect(ADVS_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }
    
    private function _get_add_form_data()
    {
        $options                  = array();
        //$options['image_name']    = $this->input->post('image_name');
        $options['url_path']      = $this->input->post('url_path');
        $options['title'] = $this->input->post('title', TRUE);
        $options['summary'] = $this->input->post('summary', TRUE);
        $options['start_time'] = $this->input->post('start_time', TRUE);
        $options['end_time'] = $this->input->post('end_time', TRUE);
        if($options['start_time'] || $options['end_time'])
            $options['timelimited'] = STATUS_ACTIVE;
        else $options['timelimited'] = STATUS_INACTIVE;

        if($this->is_postback())
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->input->post('lang', TRUE), 'extra' => 'class="btn"'));
            $options['categories_combobox']   = $this->advs_categories_model->get_advs_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'  => $this->phpsession->get('advs_lang')
                                                                                                        , 'extra' => ' class="btn"'
                                                                                                        ));
        }
        else
        {
            $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $this->phpsession->get('advs_lang'), 'extra' => 'class="btn"'));
            $options['categories_combobox']   = $this->advs_categories_model->get_advs_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
                                                                                                        , 'lang'  => $this->phpsession->get('advs_lang')
                                                                                                        , 'extra' => ' class="btn"'
                                                                                                        ));
        }

        $options['header']        = 'Thêm banner quảng cáo';
        $options['action']        = 'add';
        $options['button_name']   = 'Lưu dữ liệu';
        $options['submit_uri']    = ADVS_ADMIN_BASE_URL.'/add';

        return $options;
    }
    
    private function _get_posted_data()
    {
        $id = $this->input->post('id', TRUE);
        $timelimited = $this->input->post('timelimited', TRUE);
        $start_time = $this->input->post('start_time', TRUE);
        $end_time = $this->input->post('end_time', TRUE);

        if($timelimited == '' || $timelimited == 0 || $start_time == '' || $end_time == ''){
            $start_mktime = ADVS_ZERO_TIME;
            $end_mktime = ADVS_ZERO_TIME;
            $time_limited = STATUS_INACTIVE;
        }else{
            //doi string datetime sang so int(11)
            $start_time = datetimepicker_array($start_time);
            $start_mktime = mktime($start_time['hour'],$start_time['minute'],$start_time['second'],$start_time['month'],$start_time['day'],$start_time['year']);
            //doi string datetime sang so int(11)
            $end_time = datetimepicker_array($end_time);
            $end_mktime = mktime($end_time['hour'],$end_time['minute'],$end_time['second'],$end_time['month'],$end_time['day'],$end_time['year']);
            $time_limited = STATUS_ACTIVE;
        }

//        kieu datetime
//        $post_data['start_time']  = date('Y-m-d H:i:s', $start_mktime);
//        $post_data['end_time'] = date('Y-m-d H:i:s', $end_mktime);
        
        $rs = $this->upload_images($id);
        
        if($rs == FALSE || !isset($rs['image_name']) || !isset($rs['image_dimension'])){
            $post_data = array(
                'type'                => $this->input->post('categories_combobox', TRUE),
                //'image_name'        => my_trim($this->input->post('image_name', TRUE)),
                //'image_name'          => $rs['image_name'],
                //'image_dimension'     => $rs['image_dimension'],
                'url_path'            => my_trim($this->input->post('url_path', TRUE)),
                'title'               => my_trim($this->input->post('title', TRUE)),
                'summary'             => my_trim($this->input->post('summary', TRUE)),
                'lang'                => $this->input->post('lang', TRUE),
                'status'              => STATUS_ACTIVE,
//                'created_date'        => date('Y-m-d H:i:s'),
                'updated_date'        => date('Y-m-d H:i:s'),
                'start_time'          => $start_mktime,
                'end_time'            => $end_mktime,
                'time_limited'        => $time_limited,
            );
        }else{
            $post_data = array(
                'type'                => $this->input->post('categories_combobox', TRUE),
                //'image_name'        => my_trim($this->input->post('image_name', TRUE)),
                'image_name'          => $rs['image_name'],
                'image_dimension'     => $rs['image_dimension'],
                'url_path'            => my_trim($this->input->post('url_path', TRUE)),
                'title'               => my_trim($this->input->post('title', TRUE)),
                'summary'             => my_trim($this->input->post('summary', TRUE)),
                'lang'                => $this->input->post('lang', TRUE),
                'status'              => STATUS_ACTIVE,
//                'created_date'        => date('Y-m-d H:i:s'),
                'updated_date'        => date('Y-m-d H:i:s'),
                'start_time'          => $start_mktime,
                'end_time'            => $end_mktime,
                'time_limited'        => $time_limited,
            );
        }
        return $post_data;
    }
    
    private function upload_images($id = 0)
    {
        if(isset($_FILES)){
            $image_path = './images/img/';
            $rs = $this->advs_images_model->upload_image_advs($image_path,$id);
            return $rs;
        }else return FALSE;
    }
   
    function edit()
    {
        $options = array();
        
        if(!$this->is_postback()) redirect(SUPPORTS_ADMIN_BASE_URL);

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options']   = $options;
        }

        $options += $this->_get_edit_form_data();

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/advs_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa banner quảng cáo' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _do_edit()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('summary', 'Mô tả ngắn', 'trim|xss_clean|max_length[500]');
        $this->form_validation->set_rules('url_path', 'Đường dẫn khi click vào', 'trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('categories_combobox', 'Phân loại banner', 'is_not_default_combo');

        if ($this->form_validation->run())
        {
            $post_data = $this->_get_posted_data();
            $post_data['id'] = $this->input->post('id');
            $post_data['editor'] = $this->phpsession->get('user_id');
            //$position_edit = $this->advs_model->position_to_edit_advs(
                        //array(
                        //'id'=>$post_data['id'],
                        //'lang'=>$post_data['lang'],
                        //'type'=>$post_data['type'],
                        //)
                    //);
            //$post_data['position'] = $position_edit;
            $this->advs_model->update($post_data);

            redirect(ADVS_ADMIN_BASE_URL . '/' . $post_data['lang']);
        }
        return FALSE;
    }
    
    private function _get_edit_form_data()
    {
        $id        = $this->input->post('id');

        // khi vừa vào trang sửa
        if($this->input->post('from_list'))
        {
            $advs           = $this->advs_model->get_advs(array('id' => $id));
            $id             = $advs->id;
            $image_name     = $advs->image_name;
            $type           = $advs->type;
            $url_path       = $advs->url_path;
            $title          = $advs->title;
            $summary        = $advs->summary;
            $lang           = $advs->lang;
            $start_time     = $advs->start_time;
            $end_time       = $advs->end_time;
        }

        // khi submit
        else
        {
            $id             = $id;
//            $image_name     = my_trim($this->input->post('image_name', TRUE));
            $url_path       = my_trim($this->input->post('url_path', TRUE));
            $title          = my_trim($this->input->post('title', TRUE));
            $summary        = my_trim($this->input->post('summary', TRUE));
            $type           = $this->input->post('categories_combobox');
            $lang           = $this->input->post('lang', TRUE);
            $start_time     = $this->input->post('start_time', TRUE);
            $end_time       = $this->input->post('end_time', TRUE);
        }

        $options                  = array();
        $options['id']            = $id;
        $options['image_name']    = isset($image_name)?$image_name:'';
        $options['url_path']      = $url_path;
        $options['title']         = $title;
        $options['summary']       = $summary;
        $options['type']          = $type;
        $options['lang']          = $lang;

        if($start_time > ADVS_ZERO_TIME)
            $options['start_time']    = date('m/d/Y H:i', $start_time);
        else $options['start_time']   = '';
        
        if($end_time > ADVS_ZERO_TIME)
            $options['end_time']      = date('m/d/Y H:i', $end_time);
        else $options['end_time']     = '';
        
        if($options['start_time'] || $options['end_time'])
            $options['timelimited'] = STATUS_ACTIVE;
        else $options['timelimited'] = STATUS_INACTIVE;
        
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $lang, 'extra' => 'class="btn"'));
        $options['header']        = 'Sửa banner quảng cáo';
        $options['button_name']   = 'Lưu thay đổi';
        $options['action']        = 'edit';
        $options['submit_uri']    = ADVS_ADMIN_BASE_URL.'/edit';
        $options['categories_combobox']   = $this->advs_categories_model->get_advs_categories_combo(array('categories_combobox' => $type, 'lang' => $lang, 'extra' => 'class="btn"'));

        return $options;
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $advs = $this->advs_model->get_advs(array('id' => $id));
        $status = $advs->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->advs_model->update(array('id'=>$id,'status'=>$status));
    }
    
    /**
     * Xóa 
     */
    public function delete()
    {
        $options = array();
        if($this->is_postback())
        {
            $id = $this->input->post('id');
            //xoa file
            $image_path = './images/img/';
            $this->advs_images_model->delete_image_advs($id,$image_path);
            //xoa trong db
            $this->advs_model->delete($id);
            $options['warning'] = 'Đã xóa thành công';
        }
        $lang = $this->phpsession->get('advs_lang');
        redirect(ADVS_ADMIN_BASE_URL . '/' . $lang);
    }

    public function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('advs_lang');
        $this->advs_model->item_to_sort_advs(array('id' => $id));
        redirect(ADVS_ADMIN_BASE_URL . '/' . $lang);
    }
}
?>
