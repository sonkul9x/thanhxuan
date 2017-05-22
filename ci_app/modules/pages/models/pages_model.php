<?php
class Pages_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_pages($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select('pages.*,
                            uc.username creator_username,
                            uc.fullname creator_fullname,
                            ue.username editor_username,
                            ue.fullname editor_fullname');
            $this->db->join('users uc', 'uc.id = pages.creator', 'left');
            $this->db->join('users ue', 'ue.id = pages.editor', 'left');
        }else{
            $this->db->select('pages.*,
                            slug.slug,
                            slug.id slug_id,
                            uc.username creator_username,
                            uc.fullname creator_fullname,
                            ue.username editor_username,
                            ue.fullname editor_fullname
                        ');
            $this->db->join('slug', 'slug.type_id = pages.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_PAGES, 'left');
            $this->db->join('users uc', 'uc.id = pages.creator', 'left');
            $this->db->join('users ue', 'ue.id = pages.editor', 'left');
        }
        
        if (isset($options['id']))
            $this->db->where('pages.id', $options['id']);
        if (isset($options['uri']))
            $this->db->where('pages.uri', $options['uri']);
        
        if(SLUG_ACTIVE>0){
            if (isset($options['slug']))
                $this->db->where('slug.slug', $options['slug']);
        }
        
        // Tim kiem
        if (isset($options['search']))
        {
            $where  = "(title like'%" . $options['search'] . "%'";
            $where .= " or content like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        if(isset($options['lang']) && !empty($options['lang'])){
            //$this->db->where("uri REGEXP '^(([/]".$options['lang']."[/])|(".$options['lang']."[/]))'");
            $this->db->where('pages.lang', $options['lang']);
        }
        
        if(isset($options['status']))
            $this->db->where('pages.status',$options['status']);
        
//        if(!isset($options['is_admin']))
//            $this->db->where('status', STATUS_ACTIVE);
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('pages.created_date desc');

        $query = $this->db->get('pages');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit']))
                return $query->row(0);

            if(isset($options['uri']) && isset($options['array'])) {
                $rs = $query->result_array();
                return $rs[0];
            }
            if(!isset($options['uri']) && isset($options['array']))
                return $query->result_array();
            if($query)
                return $query->result();
            else return FALSE;
        }else{
            return NULL;
        }
        
    }

    public function get_pages_count($options = array())
    {
        return count($this->get_pages($options));
    }
    
    public function update_page_view($id = 0)
    {
        $page = $this->get_pages(array('id'=>$id));
        if(!empty($page)){
            $this->update(array('viewed'=>$page->viewed+1), array('id'=>$id));
        }
    }
    
}
?>