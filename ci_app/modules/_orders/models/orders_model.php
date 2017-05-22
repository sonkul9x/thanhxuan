<?php
class Orders_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_orders($options = array())
    {
   
        $this->db->select(' orders.*,
                        
                    ');

//        $this->db->join('orders_categories', 'orders_categories.id = orders.cat_id', 'left');

        // lọc ngôn ngữ
        if(isset($options['lang']))
        {
            $this->db->where('orders.lang', $options['lang']);
        }
        
        //loc don hang nao cua user nao
        if(isset($options['user_id']))
        {
            $this->db->where('orders.user_id', $options['user_id']);
        }
        
        if(isset($options['start_date_m'])  ){
          
            $this->db->where('orders.update_time >=', $options['start_date_m']);
        }
        if( isset($options['end_date_m']) ){
            $this->db->where('orders.update_time <=', $options['end_date_m']);
           
        }
        
        if(isset($options['status']))
        {
            $this->db->where('orders.status', $options['status']);
        }
        
        if(isset($options['order_status']) && $options['order_status']!= '-1')
        {
            $this->db->where('orders.order_status', $options['order_status']);
        }
        
        if(isset($options['fullname']))
        {
            $this->db->where('orders.fullname', $options['fullname']);
        }
        
        if (isset($options['search']))
            $this->db->like('orders.fullname', $options['search']);
        
        if(isset($options['email']))
        {
            $this->db->where('orders.email', $options['email']);
        }

     
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('orders.viewed desc, orders.updated_date desc, orders.created_date desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }else{
            $this->db->order_by('orders.update_time desc, orders.create_time desc');
        }
       
        $query = $this->db->get('orders');
       
        if($query->num_rows() > 0){
            if (isset($options['id'])) {
                if (!isset($options['flag'])) {
                    return $query->row(0);
                }
            }
            if(isset($options['onehit']) && $options['onehit'] == TRUE){
                return $query->row(0);
            }
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_orders_count($options = array())
    {
        return count($this->get_orders($options));
    }

    public function update_orders_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('orders');
    }
    
}
?>