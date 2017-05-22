<?php
class News_Categories_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_news_categories($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select('news_categories.*');
        }else{
            $this->db->select('news_categories.*,
                        slug.slug,
                        slug.id slug_id,
                    ');
            $this->db->join('slug', 'slug.type_id = news_categories.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_NEWS_CATEGORIES, 'left');
        }
               
        if (isset($options['id']))
            $this->db->where('news_categories.id', $options['id']);
        if(isset($options['notid']))
            $this->db->where('news_categories.id <> ', $options['notid']);
        // lọc ngôn ngữ
        if(isset($options['lang']))
            $this->db->where('news_categories.lang', $options['lang']);
        
        if (isset($options['status']))
            $this->db->where('news_categories.status', $options['status']);
        
        if (isset($options['home']))
            $this->db->where('news_categories.home', $options['home']);
        
        $is_logged_in = modules::run('auth/auth/is_logged_in');
        if(!$is_logged_in)
            $this->db->where('news_categories.private', STATUS_INACTIVE);
        
        if (isset($options['parent_id']) && $options['parent_id'] != DEFAULT_COMBO_VALUE)
            $this->db->where('news_categories.parent_id', $options['parent_id']);
        if (isset($options['keyword']))
            $this->db->like('news_categories.category', $options['keyword']);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('news_categories.parent_id, news_categories.position');

        $query = $this->db->get('news_categories');
        
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

    public function get_news_categories_count($options = array())
    {
        return count($this->get_news_categories($options));
    }

    function get_news_categories_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;
        if (!isset($options['notid'])) $options['notid'] = FALSE;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_news_categories(array('lang' => $options['lang'],'notid' => $options['notid']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
    }
    
    public function get_news_categories_combo($options = array())
    {
        if (!isset($options['parent_id'])) $options['parent_id'] = 0;
        if (!isset($options['notid'])) $options['notid'] = FALSE;
        if (!isset($options['lang'])) $options['lang'] = DEFAULT_LANGUAGE;
        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'categories_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        if(isset($options['is_add_edit_cat']))
            $categories[ROOT_CATEGORY_ID] = 'Tất cả';
        else
            $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';

        $cats = $this->get_news_categories_array_by_parent_id($options);
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

    function get_news_categories_object_array_by_parent_id($options = array())
    {
        // Nếu không truyền vào tham số của danh mục cha, thì trả về null
        if (!isset($options['parent_id'])) return null;

        // Lấy ra tất cả các danh mục
        $categories = $this->get_news_categories(array('lang' => $options['lang']));
        $ordered_categories = array();
        $ordered_categories = $this->_visit1($categories, $options['parent_id']);
//        print_r($ordered_categories);die;
        return $ordered_categories;
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
    
    public function get_level_news_category($options=array('parent_id'=>0))
    {
        $this->db->select('level');
        
        if (isset($options['parent_id']))
            $this->db->where('id', $options['parent_id']);

        $query = $this->db->get('news_categories');
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
        $cats = $this->get_news_categories($options);
        if($cats){
            foreach($cats as $key => $cat){
                $id = $cat->id;
                $count = $this->news_model->get_news_count(array('status'=>STATUS_ACTIVE,'cat_id'=>$id));
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
                $cat = $this->get_news_categories(array('id'=>$options['parent_id']));
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
            $cats2 = $this->get_news_categories(array('id'=>$options['parent_id']));
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
        $list_ids = $this->get_news_categories(array('parent_id'=>$parent_id));
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
    
    public function item_to_sort_news_cat($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len //, 'lang'=>$options['lang']
        $this_cat = $this->get_news_categories(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_cat = $this->db
                    ->select('id,parent_id,level,position')
                    ->where('parent_id',$this_cat->parent_id)
                    ->where('position <',$this_cat->position)
                    ->where('lang',$this_cat->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('news_categories');
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
    
    public function position_to_add_news_cat($options=array())
    {
        if (!isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $news_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('news_categories');
        if($news_cat->num_rows() > 0){
            $news_cat = $news_cat->row(0);
            $position_add = $news_cat->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_news_cat($options=array())
    {
        if (!isset($options['id']) || !isset($options['parent_id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $news_cat = $this->db
                ->select('id,parent_id,level,position')
                ->where('parent_id',$options['parent_id'])
                ->where('lang',$options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('news_categories');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($news_cat->num_rows() > 0){
            $news_cat = $news_cat->result();
            $position_max = $news_cat[0]->position;
            foreach($news_cat as $key => $m){
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