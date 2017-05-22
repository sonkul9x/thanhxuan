<?php
class Download_Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = DOWNLOAD_ADMIN_BASE_URL;
    }
    
    function browse($para1=DEFAULT_LANGUAGE, $para2=1)
    {
//        $options = array('lang'=>switch_language($para1),'page'=>$para2);
        $options = array('page'=>$para2);
        $options = array_merge($options, $this->_get_data_from_filter());
//        $this->phpsession->save('download_lang', $options['lang']);

        $total_row      = $this->download_model->get_download_count($options);
        $total_pages    = (int) ($total_row / DOWNLOAD_ADMIN_POST_PER_PAGE);

        if ($total_pages * DOWNLOAD_ADMIN_POST_PER_PAGE < $total_row)
            $total_pages++;
        if ((int) $options['page'] > $total_pages)
            $options['page'] = $total_pages;

        $options['offset'] = $options['page'] <= DEFAULT_PAGE ? DEFAULT_OFFSET : ((int) $options['page'] - 1) * DOWNLOAD_ADMIN_POST_PER_PAGE;
        $options['limit'] = DOWNLOAD_ADMIN_POST_PER_PAGE;

        $config = prepare_pagination(
                array(
                    'total_rows'    => $total_row,
                    'per_page'      => $options['limit'],
                    'offset'        => $options['offset'],
                    'js_function'   => 'change_page_admin'
                )
        );
        
        $this->pagination->initialize($config);
//        $options['is_admin'] = TRUE;
        
        $options['downloads'] = $this->download_model->get_download($options);
        $options['categories_combobox']   = $this->download_categories_model->get_download_categories_combo(array('categories_combobox' => $options['type'], 'not_lang' => TRUE, 'extra' => 'class="btn"'));
//        $options['lang_combobox']         = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
        $options['post_uri'] = 'download';
        $options['e_page'] = $options['page'];
        $options['total_rows'] = $total_row;
        $options['total_pages'] = $total_pages;
        $options['page_links'] = $this->pagination->create_ajax_links();

        $options['uri'] = DOWNLOAD_ADMIN_BASE_URL;
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/download_list', $options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý Files' . DEFAULT_TITLE_SUFFIX;
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
//            $options['search'] = $this->db->escape_str($this->input->post('search', TRUE));
            $options['type'] = $this->input->post('categories_combobox');
            $this->phpsession->save('download_search_options', $options);
//            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('download_search_options');
            if (is_array($temp_options))
            {
//                $options['search'] = $temp_options['search'];
                $options['type'] = $temp_options['type'];
            }
            else
            {
//                $options['search'] = '';
                $options['type'] = DEFAULT_COMBO_VALUE;
            }
        }
//        $options['offset'] = $this->uri->segment(3);
        return $options;
    }
    
    function add($options = array())
    {
        $options['header'] = "Thêm Files";
//        $options['files'] = $this->get_file_download();
        
//        $options['categories_combobox'] = $this->download_categories_model->get_download_categories_combo(array('categories_combobox' => $this->input->post('categories_combobox')
//                                                                                                        , 'is_add_edit_cat' => TRUE
//                                                                                                        , 'not_lang' => TRUE
//                                                                                                        , 'extra' => 'class="btn"'
//                                                                                                        ));

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_download_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm Files' . DEFAULT_TITLE_SUFFIX;
        
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    function edit()
    {
        $options    = array();

        if ($this->is_postback() && !$this->input->post('from_list'))
        {
            if (!$this->_do_edit_download())
                $options['error'] = validation_errors();
            if (isset($options['error'])) $options['options'] = $options;
        }
        $options  += $this->_get_edit_download_form_data();

        $options['header']        = 'Sửa tiêu đề Files';
        $options['button_name']   = 'Lưu lại';
        $options['submit_uri']    = DOWNLOAD_ADMIN_EDIT_URL;

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/edit_download_form', $options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa tiêu đề Files' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_edit_download_form_data()
    {
        $id = $this->input->post('id');

        if($this->input->post('from_list'))
        {
            $download = $this->download_model->get_download(array('id' => $id));
            $title = $download->title;
            $type = $download->type;
            if(SLUG_ACTIVE>0){
                $slug = slug_character_remove($download->slug);
            }
        }
        else
        {
            $title = $this->input->post('title', TRUE);
            $type = $this->input->post('categories_combobox', TRUE);
            if(SLUG_ACTIVE>0){
                $slug = my_trim($this->input->post('slug', TRUE));
            }
        }
        $options = array();
        $options['categories_combobox'] = $this->download_categories_model->get_download_categories_combo(array('categories_combobox' => $type
                                                                                                        , 'is_add_edit_cat' => TRUE
                                                                                                        , 'not_lang' => TRUE
                                                                                                        , 'extra' => 'class="btn"'
                                                                                                        ));
        $options['id'] = $id;
        $options['title'] = $title;
        if(SLUG_ACTIVE>0){
            $options['slug'] = $slug;
        }
        return $options;
    }

    private function _do_edit_download()
    {
        $this->form_validation->set_rules('title', 'Tiêu đề file', 'trim|required|xss_clean|max_length[255]');
//        if(SLUG_ACTIVE>0){
//            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|max_length[1000]');
//        }
        if($this->form_validation->run())
        {
            $data = array(
                'id'     => $this->input->post('id'),
                'title'  => $this->input->post('title', TRUE),
                'type'   => $this->input->post('categories_combobox', TRUE),
                'editor' => $this->phpsession->get('user_id'),
            );
            $this->download_model->update($data);
//            if(SLUG_ACTIVE>0){
//                $this->slug_model->update_slug(array('slug'=>  my_trim($this->input->post('slug', TRUE)).SLUG_CHARACTER_URL,'type'=>SLUG_TYPE_DOWNLOAD,'type_id'=>$data['id']));
//            }
            redirect(DOWNLOAD_ADMIN_BASE_URL);
        }
        return FALSE;
    }
    
    /**
     * Xóa
     */
    function delete() 
    {
        $options = array();
        if ($this->is_postback()) {
            $id = $this->input->post('id');
            if(SLUG_ACTIVE>0){
                $check_slug = $this->slug_model->get_slug(array('type_id'=>$id,'type'=>SLUG_TYPE_DOWNLOAD,'onehit'=>TRUE));
                if(!empty($check_slug)){
                    $this->slug_model->delete($check_slug->id);
                }
            }
            $path = UPLOAD_PATH_FILES;
            $this->download_model->download_delete_file($id, $path);
        }
        redirect(DOWNLOAD_ADMIN_BASE_URL);
    }
    
    public function ajax_upload_file_download()
    {
        if (!empty($_FILES))
        {
            $file_path = UPLOAD_PATH_FILES;
            $this->download_model->upload_download_file($file_path);
        }
    }
    
    function get_file_download($options=array())
    {
        $options['status'] = STATUS_INACTIVE;
        $files = $this->download_model->get_download($options);
        $this->download_model->update(array('status'=>STATUS_ACTIVE),array('status'=>STATUS_INACTIVE));
        $view_data = array();
        $view_data['files'] = $files;
        if($this->input->post('is-ajax'))
            echo $this->load->view('admin/download_files', $view_data, TRUE);
        else
            return $this->load->view('admin/download_files', $view_data, TRUE);
    }
    
    public function delete_file_download()
    {
        $id = $this->input->post('id');
        $path = UPLOAD_PATH_FILES;
        $this->download_model->download_delete_file($id, $path);
        echo $this->get_file_download();
    }
    
    public function admin_download_file($id=NULL)
    {
        if(empty($id)) return FALSE;
        $file = $this->download_model->get_download(array('id'=>$id));
        if(isset($file) && !empty($file))
        {
            $data = file_get_contents($file->url);
            $name = $file->name;
            //use this function to force the session/browser to download the file uploaded by the user 
            force_download($name, $data);
        }else
        {
            return FALSE;
        }
    }

}