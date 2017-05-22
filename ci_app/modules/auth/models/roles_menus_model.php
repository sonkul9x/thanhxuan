<?php
class Roles_Menus_Model extends MY_Model
{
    function  __construct()
    {
        parent::__construct();
    }
    
    function get_roles_menus($options = array())
    {
        if (isset($options['id'])) {
            $this->db->where('roles_menus.id', $options['id']);
        }
        if (isset($options['label'])) {
            $this->db->where('roles_menus.label', $options['label']);
        }
        if (isset($options['module'])) {
            $this->db->where('roles_menus.module', $options['module']);
        }
        if (isset($options['status'])) {
            $this->db->where('roles_menus.status', $options['status']);
        }
        if (isset($options['search']))
        {
            $where = "(label like'%" . $options['search'] . "%'";
            $where .= " or module like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('module');
        
        $query = $this->db->get('roles_menus');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit']))
                return $query->row(0);
            return $query->result();
        }else{
            return NULL;
        }
    }
    
    public function get_roles_menus_count($options = array())
    {
        return count($this->get_roles_menus($options));
    }
    
}