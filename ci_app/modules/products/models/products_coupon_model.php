<?php
class Products_Coupon_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_products_coupon($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        if (isset($options['name']))
            $this->db->where($this->db->dbprefix."products_coupon.name like '%".$options['name']."%'");
        
        if (isset($options['status']))
            $this->db->where('status', $options['status']);
        
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
        
        $this->db->order_by('id');

        $query = $this->db->get('products_coupon');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit'])) return $query->row(0);

            if(isset ($options['last_row']))
                return $query->last_row();

            return $query->result();
        }else{
            return NULL;
        }
    }

    public function get_products_coupon_count($options = array())
    {
        return count($this->get_products_coupon($options));
    }

    public function get_products_coupon_combo($options = array())
    {
        // Default categories name
        if ( ! isset($options['combo_name'])) {
            $options['combo_name'] = 'products_coupon';
        }
        if ( ! isset($options['extra'])){
            $options['extra'] = '';
        }
        if(! isset($options['is_add_edit_menu'])){
            if(isset($options['is_add_edit_cat']))
                $categories[ROOT_CATEGORY_ID] = 'Tất cả';
            else
                $categories[ROOT_CATEGORY_ID] = ' - Chọn';
        }
        
//        $categories = array();
        
        $this->db->where('status',STATUS_ACTIVE);
        $data = $this->db->get('products_coupon');
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