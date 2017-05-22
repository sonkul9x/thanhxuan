<?php
class Contact_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_contact($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        
        if (isset($options['status']))
            $this->db->where('status', $options['status']);
        
        if (isset($options['today']) && $options['today'] == TRUE)
            $this->db->where('DATE(created_date) = CURDATE()');
        
        if (isset($options['yesterday']) && $options['yesterday'] == TRUE)
            $this->db->where('DATE(created_date) = CURDATE() - INTERVAL 1 DAY');
        
        if (isset($options['lca']) && $options['lca'] == TRUE) {
            $current_time = now();
            $time = $current_time - 1*60; //phut
            $this->db->where('create_time >='.$time);
        }
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('created_date desc');

        $query = $this->db->get('contact');
        if($query->num_rows() > 0){
            if (isset($options['id']))
                return $query->row(0);
            if(isset($options['array']))
                return $query->result_array();
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_contact_count($options = array())
    {
        return count($this->get_contact($options));
    }
    
    function get_list_contact_array($options=array())
    {
        $options['lca'] = TRUE;
        $list_contact = $this->get_contact($options);
        if(isset($list_contact)){
            foreach($list_contact as $list){
                $list_current_ip_arr[] = $list->current_ip;
            }
            return $list_current_ip_arr;
        }else{
            return array();
        }
        
    }
}
?>