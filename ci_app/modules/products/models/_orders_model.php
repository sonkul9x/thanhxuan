<?php
class Orders_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_orders($options = array())
    {
        if(isset($options['order_id']))
            $this->db->where('id', $options['order_id']);
        if(isset($options['user_id']))
            $this->db->where('user_id', $options['user_id']);

        if(isset($options['year']) && $options['year'] != DEFAULT_COMBO_VALUE)
            $this->db->where('year(sale_date)', $options['year']);

        if(isset($options['month']) && $options['month'] != DEFAULT_COMBO_VALUE)
            $this->db->where('month(sale_date)', $options['month']);

        if(isset($options['day']) && $options['day'] != DEFAULT_COMBO_VALUE)
            $this->db->where('day(sale_date)', $options['day']);
        
        if (isset($options['keyword']) && $options['keyword'] != '')
        {
            $this->db->like('fullname', $options['keyword']);
            $this->db->or_like('receiver', $options['keyword']);
        }

        if(isset($options['status']) && $options['status']!= '' && $options['status'] != DEFAULT_COMBO_VALUE)
            $this->db->where('order_status', $options['status']);

        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $query = $this->db->get('orders');
        
        if($query->num_rows() > 0){
            if(isset($options['order_id']))
                return $query->row(0);
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_orders_count($options = array())
    {
        return count($this->get_orders($options));
    }

    function delete_order($id = 0)
    {
        $this->db->delete('orders_details', array('order_id' => $id));
        $this->db->delete('orders', array('id' => $id));
    }
}
?>
