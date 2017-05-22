<?php
class Orders_Categories_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_orders_categories($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        if(isset($options['notid']))
            $this->db->where('id <> ', $options['notid']);
        // lọc ngôn ngữ
        if(isset($options['lang']))
            $this->db->where('orders_categories.lang', $options['lang']);
        
        if (isset($options['parent_id']) && $options['parent_id'] != DEFAULT_COMBO_VALUE)
            $this->db->where('parent_id', $options['parent_id']);
        if (isset($options['keyword']))
            $this->db->like('category', $options['keyword']);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->orders_by('parent_id, position');

        $query = $this->db->get('orders_categories');
        if($query->num_rows() > 0){
            if (isset($options['id'])) return $query->row(0);
            if(isset ($options['last_row']))
                return $query->last_row();
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_orders_categories_count($options = array())
    {
        return count($this->get_orders_categories($options));
    }

    function get_orders_categories_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;
        if (!isset($options['notid'])) $options['notid'] = FALSE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_orders_categories(array('lang' => $options['lang'],'notid' => $options['notid']));
        $ordersed_categories = array();
        $ordersed_categories = $this->_visit($categories, $options['parent_id']);
//        print_r($ordersed_categories);die;
        return $ordersed_categories;
    }
    
    public function get_orders_categories_combo($options = array())
    {
        if (!isset($options['parent_id'])) $options['parent_id'] = 0;
        if (!isset($options['notid'])) $options['notid'] = FALSE;
        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'categories_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        if (isset($options['is_add_edit_cat'])) {
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        } elseif (isset($options['none'])) {
            $categories = NULL;
        } else {
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';
        }

        $cats = $this->get_orders_categories_array_by_parent_id($options);
        if(isset($cats)){
            foreach($cats as $id => $cat)
            {
                $categories[$id] = $cat;
            }
            if (!isset($options[$options['combo_name']])) 
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;

            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULl;
        }
        
    }
    
    // Duyet theo chieu sau
    private function _visit($categories = array(), $parent_id = null, $prefix = '')
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat))
        {
            $output[$current_cat->id] = $prefix . $current_cat->category;
            $prefix .= '-- ';
        }

        if (count($sub_cats) > 0)
        {
            foreach($sub_cats as $cat)
            {
                $o = $this->_visit($categories, $cat->id, $prefix);
                foreach($o as $i => $a)
                {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }

    /**
     * Lấy ra danh mục sản phẩm hiện tại
     * @author Thế Cường
     * @date   01-07-2011
     */
    private function _get_current_category($categories = array(), $parent_id = null)
    {
        if(isset($categories)){
            foreach($categories as $cat)
            {
                if ($cat->id == $parent_id) return $cat;
            }
        }
        
        return FALSE;
    }

    /**
     * Lấy ra các danh mục sản phẩm con của danh mục sản phẩm hiện tại
     * @author Thế Cường
     * @date   01-07-2011
     */
    private function _get_sub_categories($categories = array(), $parent_id = null)
    {
        $sub_categories = array();
        if(isset($categories)){
            foreach($categories as $index => $cat)
            {
                if ($cat->parent_id == $parent_id)
                    $sub_categories[$index] = $cat;
            }
        }
        return $sub_categories;
    }

    function get_orders_categories_object_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_orders_categories(array('lang' => $options['lang']));
        $ordersed_categories = array();
        $ordersed_categories = $this->_visit1($categories, $options['parent_id']);
        return $ordersed_categories;
    }

    private function _visit1($categories = array(), $parent_id = null)
    {
        $output         = array();

        $current_cat    = $this->_get_current_category($categories, $parent_id);
        $sub_cats       = $this->_get_sub_categories($categories, $parent_id);

        if (is_object($current_cat))
        {
            $output[$current_cat->id] = $current_cat;
        }

        if (count($sub_cats) > 0)
        {
            foreach($sub_cats as $cat)
            {
                $o = $this->_visit1($categories, $cat->id);
                foreach($o as $i => $a)
                {
                    $output[$i] = $a;
                }
            }
        }
        return $output;
    }
    
    public function get_level_orders_category($options=array('parent_id'=>0))
    {
        $this->db->select('level');
        
        if (isset($options['parent_id']))
            $this->db->where('id', $options['parent_id']);

        $query = $this->db->get('orders_categories');
        if($query->num_rows() <> 0){
            $rs = $query->row(0);
            return $rs->level;
        } else return -1;
    }
    
    /*
     * list category for side layout
     */
    public function get_list_cat($options=array()){
        $categories = array();
        $cats = $this->get_orders_categories($options);
        if($cats){
            foreach($cats as $key => $cat){
                $id = $cat->id;
                $count = $this->orders_model->get_orders_count(array('status'=>STATUS_ACTIVE,'cat_id'=>$id));
                if($count > 0){
                    $categories2[] = array(
                        'id' => $id,
                        'title' => $cat->category,
                        'category' => $cat->category,
                        'count' => $count,
                    );
                }
            }
            if(isset($options['isall']) && $options['isall']==TRUE){
                $cat = $this->get_orders_categories(array('id'=>$options['parent_id']));
                $categories1[] = array(
                    'id' => $options['parent_id'],
                    'title' => 'Tất cả',
                    'category' => $cat->category,
                    'count' => '',
                );
                $categories = @array_merge($categories1,$categories2);
            }else{
                $categories = $categories2;
            }
            
        }else{
            $cats2 = $this->get_orders_categories(array('id'=>$options['parent_id']));
            $parent_id = $cats2->parent_id;
            if($parent_id <> 0)
                return $this->get_list_cat(array('parent_id'=>$parent_id,'isall'=>$options['isall']));
        }

        return $categories;
    }
    
    /*
     * array id categories + parent_id
     */
    public function get_cat_ids_array($parent_id){
        if(!$parent_id) return false;
        $list_ids = $this->get_orders_categories(array('parent_id'=>$parent_id));
        if(isset($list_ids)){
            foreach($list_ids as $key => $ids){
                $ids_array[$key] = $ids->id;
            }
            $result = array($parent_id);
            $result = @array_merge($result, $ids_array);
            return $result;
        }else{
            return array();
        }
        
    }
}