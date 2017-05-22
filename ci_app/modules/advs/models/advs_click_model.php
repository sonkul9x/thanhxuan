<?php 
/**
 * Dungnm 04/2014
 */
class Advs_Click_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }
    
    public function get_advs_click($options=array())
    {
        $this->db->select(' advs_click.*,
                            advs.image_name,
                            advs_categories.id as cat_id,
                            advs_categories.title as cat_title,
                        ');
        $this->db->join('advs', 'advs.id = advs_click.advs_id', 'left');
        $this->db->join('advs_categories', 'advs_categories.id = advs.type', 'left');
        
        if(isset($options['id']))
            $this->db->where('id', $options['id']);
        
        if(isset($options['advs_id']))
            $this->db->where('advs_id', $options['advs_id']);
        
        if(isset($options['backlink']))
            $this->db->where('backlink', $options['backlink']);
        
        if(isset($options['browser']))
            $this->db->where('browser', $options['browser']);
        
        if(isset($options['current_ip']))
            $this->db->where('current_ip', $options['current_ip']);
        
        $this->db->order_by('id DESC');
        
        $query = $this->db->get('advs_click');
        if($query->num_rows() > 0){
            if(isset($options['id']))
                return $query->row(0);
            return $query->result();
        }else{
            return NULL;
        }
        
    }
    
    public function count_by_advs_id($advs_id)
    {
        $condition = array(
            'advs_id'=>$advs_id,
        );
        return $this->count($condition);
    }
    
}