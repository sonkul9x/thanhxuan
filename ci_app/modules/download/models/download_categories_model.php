<?php
class Download_Categories_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_download_categories($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select('download_categories.*');
        }else{
            $this->db->select('download_categories.*,
                        slug.slug,
                        slug.id slug_id,
                    ');
            $this->db->join('slug', 'slug.type_id = download_categories.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_DOWNLOAD_CATEGORIES, 'left');
        }
        
        if (isset($options['id']))
            $this->db->where('download_categories.id', $options['id']);
        
        if (isset($options['notid']))
            $this->db->where('download_categories.id !=', $options['notid']);

        if (isset($options['parent_id']))
            $this->db->where('download_categories.parent_id', $options['parent_id']);

        if(isset($options['lang']) && !isset($options['not_lang']))
            $this->db->where('download_categories.lang', $options['lang']);
        
        $this->db->order_by('download_categories.parent_id, download_categories.position');
        
        $query = $this->db->get('download_categories');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit'])) 
                return $query->row(0);
            if(isset ($options['last_row']))
                return $query->last_row();
            return $query->result();
        }else{
            return NULL;
        }
        
    }
    
    public function count_download_categories($options = array())
    {
        return count($this->get_download_categories($options));
    }
    
    function get_categories_array_by_parent_id($options = array()) {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id']))
            return null;
        if (!isset($options['notid']))
            $options['notid'] = null;
        if (!isset($options['lang']) && !isset($options['not_lang']))
            $options['lang'] = DEFAULT_LANGUAGE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_download_categories(array('notid'=>$options['notid'],'lang'=>$options['lang'],'not_lang'=>$options['not_lang']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit($categories, $options['parent_id']);
        return $ordered_categories;
    }
    
    public function get_download_categories_combo($options = array())
    {
        if (!isset($options['parent_id'])) $options['parent_id'] = 0;
        if (!isset($options['notid'])) $options['notid'] = FALSE;
        if (!isset($options['lang']) && !isset($options['not_lang'])) $options['lang'] = DEFAULT_LANGUAGE;
        
        // Default categories name
        if ( ! isset($options['combo_name'])) {
            $options['combo_name'] = 'categories_combobox';
        }
        if ( ! isset($options['extra'])){
            $options['extra'] = '';
        }
        
        if(isset($options['is_add_edit_cat']))
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        else
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';
        
        $cats = $this->get_categories_array_by_parent_id($options);
        if(isset($cats)){
            foreach ($cats as $id => $cat) {
                $categories[$id] = $cat;
            }
            if (!isset($options[$options['combo_name']]))
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;

            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULL;
        }
        
//        $cats = $this->db->get('download_categories');
//        if($cats->num_rows() > 0){
//            $cats = $cats->result_array();
//            foreach($cats as $id => $cat){
//                $id = $cat['id'];
//                $categories[$id] = $cat['title'];
//            }
//            if (!isset($options[$options['combo_name']])) 
//                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
//            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
//        }else{
//            return NULL;
//        }
        
    }
    
    // Duyet theo chieu sau
    private function _visit($categories = array(), $parent_id = null, $prefix = '') {
        $output = array();

        $current_cat = $this->_get_current_category($categories, $parent_id);
        $sub_cats = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat)) {
            $output[$current_cat->id] = $prefix . $current_cat->title;
            $prefix .= '-- ';
        }

        if (count($sub_cats) > 0) {
            foreach ($sub_cats as $cat) {
                $o = $this->_visit($categories, $cat->id, $prefix);
                foreach ($o as $i => $a) {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }
    
    private function _get_current_category($categories = array(), $parent_id = null) {
        if(isset($categories)){
           foreach ($categories as $cat) {
                if ($cat->id == $parent_id)
                    return $cat;
            } 
        }
        
        return FALSE;
    }
    
    private function _get_sub_categories($categories = array(), $parent_id = null) {
        $sub_categories = array();
        if(isset($categories)){
            foreach ($categories as $index => $cat) {
                if ($cat->parent_id == $parent_id)
                    $sub_categories[$index] = $cat;
            }
        }
        return $sub_categories;
    }
    
    public function get_level_download_category($options=array('parent_id'=>0))
    {
        $this->db->select('level');
        
        if (isset($options['parent_id']))
            $this->db->where('id', $options['parent_id']);

        $query = $this->db->get('download_categories');
        if($query->num_rows() <> 0){
            $rs = $query->row(0);
            return $rs->level;
        } else return -1;
    }
    
    function get_download_categories_object($options = array()) {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id']))
            return null;
        if (!isset($options['lang']) && !isset($options['not_lang'])) $options['lang'] = DEFAULT_LANGUAGE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_download_categories(array('lang'=>$options['lang']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit1($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }

    private function _visit1($categories = array(), $parent_id = null) {
        $output = array();

        $current_cat = $this->_get_current_category($categories, $parent_id);
        $sub_cats = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat)) {
            $output[$current_cat->id] = $current_cat;
        }

        if (count($sub_cats) > 0) {
            foreach ($sub_cats as $cat) {
                $o = $this->_visit1($categories, $cat->id);
                foreach ($o as $i => $a) {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }
    
    public function get_download_categories_combo_url($options = array())
    {
        if (!isset($options['parent_id']))
            $options['parent_id'] = 0;
        if (!isset($options['lang']) && !isset($options['not_lang'])) $options['lang'] = DEFAULT_LANGUAGE;
        // Default categories name
        if ( ! isset($options['combo_name'])) {
            $options['combo_name'] = 'categories_combobox';
        }
        if ( ! isset($options['extra'])){
            $options['extra'] = '';
        }
        
        
        $categories = array();
        //$categories['/download'] = 'Tất cả'; //DEFAULT_COMBO_VALUE
        
        $cats = $this->get_categories_array_by_parent_id($options);
        
        if(isset($cats)){
            foreach ($cats as $id => $cat) {
                $d_cat = $this->get_download_categories(array('id'=>$id));
                if(SLUG_ACTIVE==0){
                    $uri = '/'.url_title($d_cat->title, 'dash', TRUE) . '-d' .$d_cat->id;
                }else{
                    $uri = '/'.$d_cat->slug;
                }
                $categories[$uri] = $cat;
            }
            if (!isset($options[$options['combo_name']]))
                $options[$options['combo_name']] = '/download'; //DEFAULT_COMBO_VALUE

            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULL;
        }
    }
    
    
    public function item_to_sort_download_cat($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len //, 'lang'=>$options['lang']
        $this_cat = $this->get_download_categories(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_cat = $this->db
                    ->select('id,parent_id,level,position')
                    ->where('parent_id',$this_cat->parent_id)
                    ->where('position <',$this_cat->position)
                    ->where('lang',$this_cat->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('download_categories');
        if($pre_cat->num_rows() > 0){
            $pre_cat = $pre_cat->row(0);
            // Cap nhat lai position (doi position cho nhau)
            $this->update(array('id'=>$this_cat->id,'position'=>$pre_cat->position));
            $this->update(array('id'=>$pre_cat->id,'position'=>$this_cat->position));
        }else{
            $this->update(array('id'=>$this_cat->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_add_download_cat($options=array())
    {
        if (!isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $download_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('download_categories');
        if($download_cat->num_rows() > 0){
            $download_cat = $download_cat->row(0);
            $position_add = $download_cat->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_download_cat($options=array())
    {
        if (!isset($options['id']) || !isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $download_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',$options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('download_categories');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($download_cat->num_rows() > 0){
            $download_cat = $download_cat->result();
            $position_max = $download_cat[0]->position;
            foreach($download_cat as $key => $m){
                if($m->id === $options['id']){
                    $position_edit = $m->position;
                    break;
                }else{
                    $position_edit = $position_max + 1;
                }
            }
        }else{
            $position_edit = 1;
        }
        return $position_edit;
    }
    
}