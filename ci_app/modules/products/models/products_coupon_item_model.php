<?php
class Products_Coupon_Item_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_products_coupon_item($options = array())
    {
        $this->db->select('products_coupon_item.*,
                                products_coupon.name,
                                products_coupon.discount_type,
                                products_coupon.discount,
                                products_coupon.price_min,
                                products_coupon.end_date,
                                products_coupon.status as coupon_status,
                            ');
        $this->db->join('products_coupon', 'products_coupon_item.coupon_id = products_coupon.id', 'left');

        if (isset($options['code']))
            $this->db->where('products_coupon_item.code', $options['code']);

        if (isset($options['coupon_id']))
            $this->db->where('products_coupon_item.coupon_id', $options['coupon_id']);
        
//        if(isset($options['search']) && $options['search'] != '')
//        {
//            $where = $this->db->dbprefix."products_coupon_item.code like'%" . $options['search'] . "%'";
//            $this->db->where($where);
//        }

        if (isset($options['search']))
        {
            $where  = "(".$this->db->dbprefix."products_coupon_item.code like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."products_coupon.name like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        if (isset($options['status']))
            $this->db->where('products_coupon_item.status', $options['status']);
        
        if (isset($options['coupon_status']))
            $this->db->where('products_coupon.status', $options['coupon_status']);
        
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
               
        $this->db->order_by('products_coupon.name, products_coupon_item.code');

        $query = $this->db->get('products_coupon_item');
        if($query->num_rows() > 0){
            if (isset($options['code']) || isset($options['onehit'])) return $query->row(0);

            if(isset ($options['last_row']))
                return $query->last_row();

            return $query->result();
        }else{
            return NULL;
        }
    }

    public function get_products_coupon_item_count($options = array())
    {
        return count($this->get_products_coupon_item($options));
    }

}