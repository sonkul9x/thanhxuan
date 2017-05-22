<?php
class Products_Origin_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_products_origin($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        if (isset($options['name']))
            $this->db->where('name', $options['name']);
        
        if (isset($options['status']))
            $this->db->where('status', $options['status']);
        
        $this->db->order_by('id');

        $query = $this->db->get('products_origin');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit'])) return $query->row(0);

            if(isset ($options['last_row']))
                return $query->last_row();

            return $query->result();
        }else{
            return NULL;
        }
    }

    public function get_products_origin_count($options = array())
    {
        return count($this->get_products_origin($options));
    }

    public function get_products_origin_combo($options = array())
    {
        // Default categories name
        if ( ! isset($options['combo_name'])) {
            $options['combo_name'] = 'products_origin';
        }
        if ( ! isset($options['extra'])){
            $options['extra'] = '';
        }
        if(! isset($options['is_add_edit_menu'])){
            if(isset($options['is_add_edit_cat']))
                $categories[ROOT_CATEGORY_ID] = 'Tất cả';
            else
                $categories[DEFAULT_COMBO_VALUE] = ' - Chọn';
        }
        
        $this->db->where('status',STATUS_ACTIVE);
        $data = $this->db->get('products_origin');
        if($data->num_rows() > 0){
            $data = $data->result_array();
            foreach($data as $id => $value){
                $id = $value['id'];
                $categories[$id] = $value['name'];
            }                                   
            if (!isset($options[$options['combo_name']])) 
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
            return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
        }else{
            return NULL;
        }
        
    }

}