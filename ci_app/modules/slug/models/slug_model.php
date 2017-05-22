<?php
class Slug_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function get_slug($options = array())
    {
        if (isset($options['id'])) {
            $this->db->where('id', $options['id']);
        }
        if (isset($options['notid'])) {
            $this->db->where('id <> ', $options['notid']);
        }
        if (isset($options['nottypeid'])) {
            $this->db->where('type_id <> ', $options['nottypeid']);
        }
        if (isset($options['nottype'])) {
            $this->db->where('type <> ', $options['nottype']);
        }
        if (isset($options['slug'])) {
            $this->db->where('slug', $options['slug']);
        }
        if (isset($options['type'])) {
            $this->db->where('type', $options['type']);
        }
        if (isset($options['type_id'])) {
            $this->db->where('type_id', $options['type_id']);
        }
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset'])) {
            $this->db->limit($options['limit'], $options['offset']);
        } else if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }
        
        $query = $this->db->get('slug');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit'])) {
                return $query->row(0);
            }
            if (isset($options['last_row'])) {
                return $query->last_row();
            }
            return $query->result();
        }else{
            return NULL;
        }
    }
    
    public function get_slug_count($options = array())
    {
        return count($this->get_slug($options));
    }
    
    public function insert_slug($options=array(),$html=NULL)
    {
        $check_slug = $this->check_slug($options);
        
        if($check_slug == TRUE){
            if(strpos($options['slug'],SLUG_CHARACTER_URL)){
                $slug = slug_character_remove($options['slug']).SLUG_CHARACTER_INSERT.SLUG_CHARACTER_URL;
            }else{
                $slug = $options['slug'].SLUG_CHARACTER_INSERT;
            }
            $data = array(
                'slug' => $slug,
                'type' => $options['type'],
                'type_id' => $options['type_id'],
            );
            return $this->slug_model->insert($data);
        }else{
            return $this->slug_model->insert($options);
        }
    }
    
    public function update_slug($options=array(),$html=NULL)
    {
        $check_type_id = $this->check_type_id($options);
        if($check_type_id == TRUE){
            $check_slug = $this->check_slug($options,TRUE);
            if($check_slug == TRUE){
                if(strpos($options['slug'],SLUG_CHARACTER_URL)){
                    $slug = slug_character_remove($options['slug']).SLUG_CHARACTER_INSERT.SLUG_CHARACTER_URL;
                }else{
                    $slug = $options['slug'].SLUG_CHARACTER_INSERT;
                }
                $data = array(
                    'slug' => $slug,
                    'type' => $options['type'],
                    'type_id' => $options['type_id'],
                );
                $this->slug_model->update($data,array('type_id'=>$options['type_id'],'type'=>$options['type']));
            }else{
                $this->slug_model->update($options,array('type_id'=>$options['type_id'],'type'=>$options['type']));
            }
        }else{
            $check_slug = $this->check_slug($options);
            if($check_slug == TRUE){
                if(strpos($options['slug'],SLUG_CHARACTER_URL)){
                    $slug = slug_character_remove($options['slug']).SLUG_CHARACTER_INSERT.SLUG_CHARACTER_URL;
                }else{
                    $slug = $options['slug'].SLUG_CHARACTER_INSERT;
                }
                $data = array(
                    'slug' => $slug,
                    'type' => $options['type'],
                    'type_id' => $options['type_id'],
                );
                return $this->slug_model->insert($data);
            }else{
                return $this->slug_model->insert($options);
            }
        }
        
    }
    
    public function check_slug($options=array(),$is_update=NULL)
    {
        if(isset($options['slug']) && isset($options['type']) && isset($options['type_id']) && isset($is_update)){
            $slug = $this->get_slug(array('slug'=>$options['slug'],'nottypeid'=>$options['type_id'],'type'=>$options['type']));
        }else{
            $slug = $this->get_slug(array('slug'=>$options['slug']));
        }
        if(!empty($slug)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function check_type_id($options=array())
    {
        if(isset($options['type_id']) && isset($options['type']))
        {
            $slug = $this->get_slug(array('type_id'=>$options['type_id'],'type'=>$options['type']));
        }
        if(!empty($slug)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}