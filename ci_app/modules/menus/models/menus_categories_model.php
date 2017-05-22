<?php
class Menus_Categories_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_menus_categories($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        $this->db->where('status',STATUS_ACTIVE);
        
        $this->db->order_by('id');

        $query = $this->db->get('menus_categories');
        if($query->num_rows() > 0){
            if (isset($options['id'])) return $query->row(0);

            if(isset ($options['last_row']))
                return $query->last_row();

            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_menus_categories_count($options = array())
    {
        return count($this->get_menus_categories($options));
    }

    public function add_menus_category($data = array())
    {
        $this->db->insert('menus_categories', $data);
        return $this->db->insert_id();
    }
    
    public function update_menus_category($data = array())
    {
        $this->db->where('id', $data['id']);
        $this->db->update('menus_categories', $data);
    }
    
    public function delete_menus_category($id = 0)
    {
        $this->db->delete('menus_categories', array('id' => $id));
    }
    
    public function get_menus_categories_combo($options = array())
    {
        // Default categories name
        if ( ! isset($options['combo_name'])) {
            $options['combo_name'] = 'menus_categories';
        }
        if ( ! isset($options['extra'])){
            $options['extra'] = '';
        }
        if(! isset($options['is_add_edit_menu'])){
            if(isset($options['is_add_edit_cat']))
                $categories[ROOT_CATEGORY_ID] = 'Tất cả';
            else
                $categories[DEFAULT_COMBO_VALUE] = 'Tất cả';
        }
        
        $this->db->where('status',STATUS_ACTIVE);
        if(HIDE_ADMIN_MENU > 0){
            $this->db->where('id <>',BACK_END_MENU_CAT_ID);
        }
        $cats = $this->db->get('menus_categories');
        if($cats->num_rows() > 0){
            $cats = $cats->result_array();
            foreach($cats as $id => $cat){
                $id = $cat['id'];
                $categories[$id] = $cat['name'];
            }                                   
            if (!isset($options[$options['combo_name']])) 
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULL;
        }
        
    }

}