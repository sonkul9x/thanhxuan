<?php
class Orders_Details_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }

    function get_orders_details($options = array())
    {

        if(isset($options['id']))
            $this->db->where('order_id', $options['id']);
        $this->db->select(
                'orders_details.*,
                 products.product_name
                '
                );
        $this->db->join('orders', 'orders_details.order_id = orders.id');
        $this->db->join('products', 'orders_details.product_id = products.id');
        $query = $this->db->get('orders_details');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return NULL;
        }
        
    }

}
?>
