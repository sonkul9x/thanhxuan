<?php
class Roles_Model extends MY_Model
{
    function  __construct()
    {
        parent::__construct();
    }
    
    function get_roles($options = array())
    {
        if (isset($options['id'])) {
            $this->db->where('roles.id', $options['id']);
        }
        
        if (isset($options['name'])) {
            $this->db->where('roles.name', $options['name']);
        }
        
        if (isset($options['publisher'])) {
            $this->db->where('roles.publisher', $options['publisher']);
        }
        
        if (isset($options['status'])) {
            $this->db->where('roles.status', $options['status']);
        }
        
        if (isset($options['search']))
        {
            $where = "(name like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $query = $this->db->get('roles');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit']))
                return $query->row(0);
            return $query->result();
        }else{
            return NULL;
        }
    }
    
    public function get_roles_count($options = array())
    {
        return count($this->get_roles($options));
    }
    
    public function get_roles_combo($options=array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'roles_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }
        
        if (!isset($options['status'])){
            $options['status'] = STATUS_ACTIVE;
        }

        $roles = $this->get_roles($options);
        if (empty($roles)) {
            return NULL;
        } else {
            $data_options = array();
            $data_options[DEFAULT_COMBO_VALUE] = ' - Chọn';
            foreach ($roles as $key => $value) {
                $data_options[$value->id] = $value->name;
            }
            if (!isset($options[$options['combo_name']])) {
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
            }
            return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
        }
    }
}