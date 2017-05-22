<?php
class Menus_Admin extends MY_Controller 
{
    function __construct()
    {
        parent::__construct();
        modules::run('auth/auth/validate_login',$this->router->fetch_module());
        $this->_layout = 'admin_ui/layout/main';
        $this->_view_data['url'] = MENUS_ADMIN_BASE_URL;
    }

    function browse($para1=DEFAULT_LANGUAGE) {
        $options = array('lang'=>switch_language($para1));
        $options = array_merge($options, $this->_get_data_from_filter());
        $this->phpsession->save('menus_lang', $options['lang']);
        
        $this->output->link_js('/powercms/scripts/menu_admin.js');

        $options['menus_categories'] = $this->menus_categories_model->get_menus_categories_combo(
            array('menus_categories' => $options['cat_id'], 'lang' => $options['lang'], 'extra' => 'class="btn"')
        );
        
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'onchange="javascript:change_lang();" class="btn"'));
                
        $options['parent_id'] = ROOT_CATEGORY_ID;
        
        $options['menus'] = $this->menus_model->get_menus_object_array_by_parent_id($options);
        
        if($this->input->get('save_cache') == 'success')
            $options['succeed'] = 'Lưu thành công';
        else if($this->input->get('save_cache') == 'error')
            $options['error'] = 'Lưu không thành công';
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;

        $options['total_rows'] = count($options['menus']);
                
        $options['header'] = 'Danh sách menu';
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/list_menu',$options, TRUE);
        
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Quản lý menu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_data_from_filter()
    {
        $options = array();

        if ( $this->is_postback())
        {
            $options['search']                  = $this->input->post('search', TRUE);
            $options['cat_id']                  = $this->input->post('menus_categories');
            $this->phpsession->save('menus_search_options', $options);
            //search with lang
            $options['lang'] = $this->input->post('lang');
        }
        else
        {
            $temp_options = $this->phpsession->get('menus_search_options');
            if (is_array($temp_options))
            {
                $options['search']              = $temp_options['search'];
                $options['cat_id']              = $temp_options['cat_id'];
            }
            else
            {
                $options['search']              = '';
                $options['cat_id']              = DEFAULT_COMBO_VALUE;
            }
        }
        $options['offset'] = $this->uri->segment(3);
        return $options;
    }

    function add() {
        $options = array();
        $options['lang'] = $this->phpsession->get('menus_lang') ;
        
        // khi submit
        if ($this->is_postback()) {
            if (!$this->_do_add_menu($options))
                $options['error'] = validation_errors();
        }
        $options = $this->_get_form_add_menu($options);
        
//        $options['cat_id']        = $this->phpsession->get('cat_id');

        $options['submit_uri']    = MENUS_ADMIN_ADD_URL;
        $options['button_name']   = 'Lưu dữ liệu';
        $options['language'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'class="btn"'));
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
            $options['options'] = $options;
        
        $options['header'] = 'Thêm menu';
        
        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_menu_form',$options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Thêm menu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }

    private function _get_form_add_menu($options = array()) {
        $options['menu_name'] = $this->input->post('menu_name');
        $options['url_path'] = $this->input->post('url_path');
        $options['cat_id'] = $this->input->post('menus_categories');
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'class="btn"'));
        $options['lang'] = $this->input->post('lang') ? $this->input->post('lang') :$options['lang'] ;
        $options['css'] = $this->input->post('css');
        $options['thumb'] = $this->input->post('thumb');
        /// menu phan loai , onchange -> thay doi combo navigation
        $options['menus_categories'] = $this->menus_categories_model->get_menus_categories_combo(array(
//            'menus_categories' => $options['cat_id'],
            'is_add_edit_menu' => TRUE,
            'lang' => $options['lang'], 
            'extra' => 'onchange="javascript:change_menus();" class="btn"'
            ));
        $options['navigation_menu'] = $this->menus_model->get_menus_combo(array(
//            'parent_id' => $this->phpsession->get('menu_type'),
            'cat_id' => FRONT_END_MENU_TOP_CAT_ID,
            'combo_name' => 'navigation',
            'navigation' => $this->input->post('navigation'),
            'lang' => $options['lang'],
            'extra' => 'class="btn"',
                ));
        $options['scripts'] = $this->_get_scripts();
        return $options;
    }

    private function _do_add_menu($options = array()) {
        //validate
        $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|xss_clean');
        $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|required|xss_clean');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|xss_clean');
        $parent_id = $this->input->post('navigation') == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('navigation');
        
        //check level cua parent category -> update +1 level 
        $parent_level = $this->menus_model->get_level_menus_category(array('parent_id'=>$parent_id));
        
        $data = array(
            'caption' => strip_tags($this->input->post('menu_name')),
            'url_path' => my_trim($this->input->post('url_path')),
            'lang' => $this->input->post('lang'),
            'css' => my_trim($this->input->post('css')),
            'thumbnail' => cut_domain_from_url($this->input->post('thumb')),
            'parent_id' => $parent_id,
            'level' => $parent_level + 1,
            'cat_id' => $this->input->post('menus_categories'),
            'creator' => $this->phpsession->get('user_id'),
            'editor' => $this->phpsession->get('user_id'),
        );

        if ($this->form_validation->run()) {
            $position_add = $this->menus_model->position_to_add(array('lang'=>$data['lang'],'parent_id'=>$parent_id,'cat_id'=>$this->input->post('menus_categories')));
            $data['position'] = $position_add;
            $insert_id = $this->menus_model->add_menu($data);

//            redirect(MENUS_ADMIN_BASE_URL . '/' . $data['lang']);
            $this->save_cache_menu();
        }
        return FALSE;
    }

    function edit($options = array()) {        
        $options['lang'] = $this->phpsession->get('menus_lang');
        
        if ($this->is_postback() && !$this->input->post('IS_FROM_LIST')) {
            if (!$this->_do_edit_menu($options))
                $options['error'] = validation_errors();
        }
        $options = $this->_get_form_edit_menu($options);
        
        if(isset($options['error']) || isset($options['succeed']) || isset($options['warning'])) 
                $options['options'] = $options;
        
        $options['lang_combobox'] = $this->utility_model->get_lang_combo(array('lang' => $options['lang'], 'extra' => 'class="btn"'));
        
        $options['submit_uri'] = MENUS_ADMIN_EDIT_URL;
        
        $options['button_name'] = 'Lưu dữ liệu';
        
        $options['header'] = 'Sửa Menu';

        // Chuan bi du lieu chinh de hien thi
        $this->_view_data['main_content'] = $this->load->view('admin/add_menu_form',$options, TRUE);
        // Chuan bi cac the META
        $this->_view_data['title'] = 'Sửa Menu' . DEFAULT_TITLE_SUFFIX;
        // Tra lai view du lieu cho nguoi su dung
        $this->load->view($this->_layout, $this->_view_data);
    }
    
    private function _get_form_edit_menu($options = array()) {
        $menu_id = $this->input->post('id');

        if ($this->input->post('from_list')) {
            $menu = $this->menus_model->get_menus(array('id' => $menu_id),$all = TRUE);
            $caption    = $menu->caption;
            $url_path   = $menu->url_path;
            $lang       = $menu->lang;
            $css        = $menu->css;
            $thumb      = $menu->thumbnail;
            $parent_id  = $menu->parent_id;
            $cat_id     = $menu->cat_id;
        } else {
            $caption        = $this->input->post('menu_name', TRUE);
            $url_path       = $this->input->post('url_path', TRUE);
            $lang           = $this->input->post('lang', TRUE);
            $css            = $this->input->post('css', TRUE);
            $thumb          = my_trim($this->input->post('thumb', TRUE));
            $parent_id      = $this->input->post('navigation', TRUE);
            $cat_id         = $this->input->post('menus_categories', TRUE);
        }
        $view_data = array();

        $view_data['menu_id'] = $menu_id;
        $view_data['menu_name'] = $caption;
        $view_data['css'] = $css;
        $view_data['thumb'] = $thumb;
        $view_data['lang'] = $lang;
        $view_data['url_path'] = $url_path;
        /// menu phan loai , onchange -> thay doi combo navigation
        $view_data['menus_categories'] = $this->menus_categories_model->get_menus_categories_combo(array(
            'menus_categories' => $cat_id,
            'is_add_edit_menu' => TRUE,
            'lang' => $options['lang'], 
            'extra' => 'onchange="javascript:change_menus();" class="btn"'
            ));
        $view_data['navigation_menu'] = $this->menus_model->get_menus_combo(array(
//            'parent_id' => $this->phpsession->get('menu_type'),
            'cat_id' => $cat_id,
            'combo_name' => 'navigation',
            'navigation' => $parent_id,
            'current_id' => $menu_id,
            'lang' => $lang,
            'extra' => 'class="btn"',
                ));
        $view_data['parent_id'] = $parent_id;
        $view_data['scripts'] = $this->_get_scripts();
        return $view_data;
    }

    private function _do_edit_menu($options = array()) {
        //validate
        $this->form_validation->set_rules('menu_name', 'Tên menu', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('url_path', 'Đường dẫn', 'trim|required|xss_clean|max_length[512]');
        $this->form_validation->set_rules('thumb', 'Hình minh họa', 'trim|xss_clean');
        $parent_id = $this->input->post('navigation', TRUE) == DEFAULT_COMBO_VALUE ? ROOT_CATEGORY_ID : $this->input->post('navigation', TRUE);
        //check level cua parent category -> update +1 level 
        $parent_level = $this->menus_model->get_level_menus_category(array('parent_id'=>$parent_id));
        if ($this->form_validation->run()) {
            $data = array(
                'id'        => $this->input->post('id'),
                'caption'   => strip_tags($this->input->post('menu_name', TRUE)),
                'url_path'  => my_trim($this->input->post('url_path', TRUE)),
                'lang'      => $this->input->post('lang', TRUE),
                'css'       => my_trim($this->input->post('css', TRUE)),
                'thumbnail' => cut_domain_from_url($this->input->post('thumb')),
                'parent_id' => $parent_id,
                'level'     => $parent_level + 1,
                'cat_id'    => $this->input->post('menus_categories', TRUE),
                'editor'    => $this->phpsession->get('user_id'),
            );

            if ($this->form_validation->run()) {
                $position_edit = $this->menus_model->position_to_edit(array(
                    'id'=>$this->input->post('id'),
                    'parent_id'=>$parent_id,
                    'lang'=>$data['lang'],
                    'cat_id'=>$this->input->post('menus_categories')));
                $data['position'] = $position_edit;
                
                $this->menus_model->update_menu($data);
                
//                redirect(MENUS_ADMIN_BASE_URL . '/' . $data['lang']);
                $this->save_cache_menu();
                
            }
        }
        return FALSE;
    }

    public function delete($options = array()) {
        if ($this->is_postback()) {
            $menu_id = $this->input->post('id');
            $menu = $this->menus_model->get_menus(array('parent_id' => $menu_id));
            
            if (count($menu) == 0) {
                $this->menus_model->delete_menu($menu_id);
            } else {
                $options['error'] = 'Không thể xóa menu này vì vẫn còn các menu con';
            }
        }
        $options['lang'] = $this->phpsession->get('menus_lang');
        if(isset($options['parent_id'])) unset($options['parent_id']);
//        redirect(MENUS_ADMIN_BASE_URL . '/' . $options['lang']);
        $this->save_cache_menu();
    }

    public function sort_menus() {
        $arr = $this->input->post('id');
        $category = $this->menus_model->get_menus(array('id' => $arr[0]));
        $i = 1;
        foreach ($arr as $recordidval) {
            $array = array('position' => $i);
            $this->db->where('id', $recordidval)
                    ->where('parent_id', $category[0]->parent_id)
                    ->update('menus', $array);
            $i = $i + 1;
        }
    }
    
    function change_status()
    {
        $id = $this->input->post('id');
        $menu = $this->menus_model->get_menus(array('id' => $id),TRUE);
        $status = $menu->active == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->menus_model->update_menu(array('id'=>$id,'active'=>$status));
        $this->save_cache_menu();
    }
    
    function change_private()
    {
        $id = $this->input->post('id');
        $menu = $this->menus_model->get_menus(array('id' => $id),TRUE);
        $private = $menu->private == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
        $this->menus_model->update_menu(array('id'=>$id,'private'=>$private));
        $this->save_cache_menu();
    }
    
    // ajax
    function get_combo_menu(){
        if($this->is_postback() && $this->input->post('is-ajax') == 1){
            echo $this->menus_model->get_menus_combo(array(
                'combo_name' => 'navigation',
                'parent_id' => $this->input->post('parent'),
                'lang' => $this->input->post('lang'),
                'current_id' => $this->input->post('current_id')
            ));
            die;
        }
    }
    
    function change_menus()
    {
        $cat_id = $this->input->post('cat_id');
//        $this->phpsession->save('cat_id', $cat_id);
        $navigation = $this->menus_model->get_menus_combo(array(
            'cat_id' => $cat_id,
            'combo_name' => 'navigation',
//            'navigation' => $this->input->post('navigation'),
//            'lang' => $options['lang'],
            'extra' => 'class="btn"',
        ));
        echo $navigation;
    }
    
    function save_cache_menu()
    {
        $lang = $this->phpsession->get('menus_lang');
        if(save_cache('menus'))
            redirect(MENUS_ADMIN_BASE_URL . '/' . $lang . '?save_cache=success');
        else
            redirect(MENUS_ADMIN_BASE_URL . '/' . $lang . '?save_cache=error');
    }
    
    function up()
    {
        $id = $this->input->post('id');
        $lang = $this->phpsession->get('menus_lang');
        $this->menus_model->item_to_sort(array('id' => $id));
        $this->save_cache_menu();
    }
    
    private function _get_scripts()
    {
        $scripts = '<script type="text/javascript" src="/plugins/tinymce/tinymce.min.js?v=4.1.7"></script>';
        $scripts .= '<link rel="stylesheet" type="text/css" href="/plugins/fancybox/source/jquery.fancybox.css" media="screen" />';
        $scripts .= '<script type="text/javascript" src="/plugins/fancybox/source/jquery.fancybox.pack.js"></script>';
        $scripts .= '<script type="text/javascript">$(".iframe-btn").fancybox({"width":900,"height":500,"type":"iframe","autoScale":false});</script>';
        $scripts .= '<style type=text/css>.fancybox-inner {height:500px !important;}</style>';
        $scripts .= '<script type="text/javascript">enable_tiny_mce();</script>';
        return $scripts;
    }
    
}

?>