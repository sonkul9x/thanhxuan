<?php
class Advs_Categories_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_advs_categories($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        // lọc ngôn ngữ
//        if(isset($options['lang']))
//            $this->db->where('lang', $options['lang']);
        
        $query = $this->db->get('advs_categories');
        if($query->num_rows() > 0){
            if (isset($options['id'])) return $query->row(0);
            if(isset ($options['last_row']))
                return $query->last_row();
            return $query->result();
        }else{
            return NULL;
        }
        
    }
    
    public function count_advs_categories($options = array())
    {
        return count($this->get_advs_categories($options));
    }
    
    public function get_advs_categories_combo($options = array())
    {
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
        
        $cats = $this->db->get('advs_categories');
        if($cats->num_rows() > 0){
            $cats = $cats->result_array();
            foreach($cats as $id => $cat){
                $id = $cat['id'];
                $categories[$id] = $cat['title'];
            }                                   
            if (!isset($options[$options['combo_name']])) 
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULL;
        }
        
    }
    
}