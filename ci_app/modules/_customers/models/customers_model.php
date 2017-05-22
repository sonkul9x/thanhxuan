<?php
class Customers_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_customers($options = array())
    {
    
        $this->db->select(' customers.*,
                        (select count(*) from icms2_orders where user_id = icms2_customers.id) as count_order
                    ');

//        $this->db->join('customers_categories', 'customers_categories.id = customers.cat_id', 'left');

        if(isset($options['status']))
        { 
            $this->db->where('customers.status', $options['status']);
        }
        
        if (isset($options['user_id']))
            $this->db->where('customers.id', $options['user_id']);
     
        if(isset($options['fullname']))
        {
            $this->db->where('customers.fullname', $options['fullname']);
        }
        
        if (isset($options['search']) && $options['search'] !='')
            $this->db->like('customers.fullname', $options['search']);
        
        if(isset($options['email']))
        {
            $this->db->where('customers.email', $options['email']);
        }
        
        if(isset($options['password']))
        {
            $this->db->where('customers.password', $options['password']);
        }

     
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('customers.viewed desc, customers.updated_date desc, customers.created_date desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }else{
            $this->db->order_by('customers.updated_date desc, customers.created_date desc');
        }
       
        $query = $this->db->get('customers');

        if(isset ($options['last_row']))
            return $query->row(0);
        
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

    public function get_customers_count($options = array())
    {
        return count($this->get_customers($options));
    }

    public function update_customers_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('customers');
    }
    
    // check username khi đăng ký đã tồn tại chưa
    function is_available_username_customers($params = array())
    {
        $this->db->where('email', $params['email']);

        $query = $this->db->get('customers');

        if (count($query->row()) > 0)
        {
            $this->_last_message = '<p>Email: <strong>'. $params['email'] . '</strong> đã tồn tại trong hệ thống.</p>';
            return FALSE;
        }
        return TRUE;
    }
    
    function get_last_message()
    {
        return $this->_last_message;
    }
    
}
?>