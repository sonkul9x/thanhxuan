<?php 
/**
 * dungnm
 */

class Products_Categories_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_categories($options = array()) 
    {
        if(SLUG_ACTIVE==0){
            $this->db->select('products_categories.*');
        }else{
            $this->db->select('products_categories.*,
                        slug.slug,
                        slug.id slug_id,
                    ');
            $this->db->join('slug', 'slug.type_id = products_categories.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_PRODUCTS_CATEGORIES, 'left');
        }
        
        if (isset($options['id']))
            $this->db->where('products_categories.id', $options['id']);
        
        if (isset($options['notid']))
            $this->db->where('products_categories.id !=', $options['notid']);

        if (isset($options['status']))
            $this->db->where('products_categories.status', $options['status']);
        
        if (isset($options['level']))
            $this->db->where('products_categories.level', $options['level']);
        
         if (isset($options['home']))
            $this->db->where('products_categories.home', $options['home']);
         
        // lọc ngôn ngữ
        if (isset($options['lang']))
            $this->db->where('products_categories.lang', $options['lang']);

        if (isset($options['parent_id']) && $options['parent_id'] != DEFAULT_COMBO_VALUE)
            $this->db->where('products_categories.parent_id', $options['parent_id']);
        
        if (isset($options['keyword']))
            $this->db->like('products_categories.category', $options['keyword']);
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('products_categories.parent_id, products_categories.position');

        $query = $this->db->get('products_categories');

        if($query->num_rows() > 0){
            if (isset($options['id']))
                return $query->row(0);
            if (isset($options['last_row']))
                return $query->last_row();
            return $query->result();
        }else{
            return NULL;
        }

    }

    public function get_categories_count($options = array()) {
        return count($this->get_categories($options));
    }

    function get_categories_array_by_parent_id($options = array()) {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id']))
            return null;
        if (!isset($options['notid']))
            $options['notid'] = null;
        if (!isset($options['lang']))
            $options['lang'] = DEFAULT_LANGUAGE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang'],'notid'=>$options['notid']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }

    public function get_categories_combo($options = array()) {
        if (!isset($options['parent_id'])) {
            $options['parent_id'] = 0;
        }
        // Default categories name
        if (!isset($options['combo_name'])) {
            $options['combo_name'] = 'categories_combobox';
        }

        if (!isset($options['extra'])) {
            $options['extra'] = '';
        }

        if (isset($options['is_add_edit_cat'])) {
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        }elseif(isset($options['is_none'])){ 
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        }else {
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';
        }

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
    }

    // Duyet theo chieu sau
    private function _visit($categories = array(), $parent_id = null, $prefix = '') {
        $output = array();

        $current_cat = $this->_get_current_category($categories, $parent_id);
        $sub_cats = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat)) {
            $output[$current_cat->id] = $prefix . $current_cat->category;
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

    function delete_category($id = 0) {
//        $this->db->delete('products', array('cat_id' => $id));
        $this->db->delete('products_categories', array('id' => $id));
        $this->db->delete('products_categories', array('parent_id' => $id));
    }
    
    function get_home_left_categories($options = array()) {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id']))
            return null;
        if (!isset($options['status']))
            $options['status'] = STATUS_ACTIVE;
        if (!isset($options['lang']))
            $options['lang'] = DEFAULT_LANGUAGE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang'],'status'=>$options['status']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit1($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }

    function get_categories_object_array_by_parent_id($options = array()) {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id']))
            return null;
        if (!isset($options['lang']))
            $options['lang'] = DEFAULT_LANGUAGE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_categories(array('lang' => $options['lang']));
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
    
    public function get_level_products_category($options=array('parent_id'=>0))
    {
        $this->db->select('level');
        
        if (isset($options['parent_id']))
            $this->db->where('id', $options['parent_id']);

        $query = $this->db->get('products_categories');
        if($query->num_rows() <> 0){
            $rs = $query->row(0);
            return $rs->level;
        } else return -1;
    }
    
    /**
     * sort thu cong
     * @param type $options
     * @return boolean|null
     */
    public function item_to_sort_product_cat($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len //, 'lang'=>$options['lang']
        $this_cat = $this->get_categories(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_cat = $this->db
                    ->select('id,parent_id,level,position')
                    ->where('parent_id',$this_cat->parent_id)
                    ->where('position <',$this_cat->position)
                    ->where('lang',$this_cat->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('products_categories');
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
    
    public function position_to_add_product_cat($options=array())
    {
        if (!isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $product_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('products_categories');
        if($product_cat->num_rows() > 0){
            $product_cat = $product_cat->row(0);
            $position_add = $product_cat->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_product_cat($options=array())
    {
        if (!isset($options['id']) || !isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $product_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('products_categories');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($product_cat->num_rows() > 0){
            $product_cat = $product_cat->result();
            $position_max = $product_cat[0]->position;
            foreach($product_cat as $key => $m){
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
    
    /***
     * left products categories for front-end
     * nmd
     */
    public function get_left_categories($options=array()) {
        if (!isset($options['parent_id'])) {
            $options['parent_id'] = ROOT_CATEGORY_ID;
        }
        if (!isset($options['status'])) {
            $options['status'] = STATUS_ACTIVE;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }

        $categories = $this->get_categories(array('lang' => $options['lang'],'status'=>$options['status']));
        if(isset($categories)){
            $options['menus']       = $categories;
            $options['parent_id']   = ROOT_CATEGORY_ID;
            $side_menus              = '<ul id="menuside">';
            $side_menus              .= $this->_visit_side_menus($options);
            $side_menus              .= '</ul>';
            $side_menus              = str_replace('<ul class="navsub"></ul>', '', $side_menus);
            return $side_menus;
        }else{
            return NULL;
        }
        
    }
    
    private function _visit_side_menus($params=array()){
        $output                 = '';
        $sub_menus              = $this->_get_sub_menus($params);
        if(isset($sub_menus)){
            foreach($sub_menus as $menu)
            {
                $params['parent_id']    = $menu->id;
                if(SLUG_ACTIVE==0){
                    $short_uri = '/' . url_title(trim($menu->category), 'dash', TRUE) . '-p' .$menu->id;
                    $uri = get_base_url() . url_title(trim($menu->category), 'dash', TRUE) . '-p' . $menu->id;
                }else{
                    $short_uri = '/' . $menu->slug;
                    $uri = get_base_url() . $menu->slug;
                }
                $style = ($short_uri===$params['current_menu']) ? ' class="active"' : '';
//                if($menu->parent_id == 0){
//                    $image = is_null($menu->avatar) ? base_url().'images/no-image.png' : $menu->avatar;
//                    $output .= '<li' . $style . '>
//                                <a href="'.$uri.'" title="'.$menu->category.'">
//                                    <img src="'.$image.'" title="'.$menu->category.'" />
//                                </a>';
//                }else{
//                    $output .= '<li' . $style . '><a href="' . $uri . '"' . $style . ' title="' . $menu->category . '"><span>' . $menu->category . '</span></a>';
//                }
                $output .= '<li' . $style . '><a href="' . $uri . '"' . $style . ' title="' . $menu->category . '"><i class="fa fa-caret-right"></i><span>' . $menu->category . '</span></a>';
                $output                 .= '<ul class="navsub">';
                $output                 .= $this->_visit_side_menus($params);
                $output                 .= '</ul></li>';
            }
            return $output;
        }else{
            return NULL;
        }
    }
    
    private function _get_sub_menus($params = array())
    {
        $menus      = $params['menus'];
        $sub_menus  = array();
        if(isset($menus)){
            foreach($menus as $index => $menu)
            {
                if ($menu->parent_id == $params['parent_id'])
                    $sub_menus[$index] = $menu;
            }
            return $sub_menus;
        }else{
            return NULL;
        }
        
    }

}