<?php
class Faq_Professionals_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_faq_professionals($options = array())
    {
        $this->db->select('faq_professionals.*');

        if(isset($options['id']))
        {
            $this->db->where('faq_professionals.id', $options['id']);
        }
        
        if(isset($options['lang']))
        {
            $this->db->where('faq_professionals.lang', $options['lang']);
        }
        
        if(isset($options['status']))
        {
            $this->db->where('faq_professionals.status', $options['status']);
        }
        
        if(isset($options['title']))
        {
            $this->db->where('faq_professionals.title', $options['title']);
        }
        
        // Tim kiem theo tu khoa
        if (isset($options['search']))
        {
            $where  = "(".$this->db->dbprefix."faq_professionals.title like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq_professionals.content like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq_professionals.summary like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('faq_professionals.position, faq_professionals.updated_date desc, faq_professionals.created_date desc');
        
        $query = $this->db->get('faq_professionals');
        if($query->num_rows() > 0){
            if (isset($options['id'])) {
                return $query->row(0);
            }
            if(isset($options['onehit']) && $options['onehit'] == TRUE){
                return $query->row(0);
            }
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_faq_professionals_count($options = array())
    {
        return count($this->get_faq_professionals($options));
    }
    
    
    public function item_to_sort_faq_pro($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_ = $this->get_faq_professionals(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_ = $this->db
                    ->select('id,position')
                    ->where('position <',$this_->position)
                    ->where('lang',$this_->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('faq_professionals');
        if($pre_->num_rows() > 0){
            $pre_ = $pre_->row(0);
            // Cap nhat lai position (doi position cho nhau)
            $this->update(array('id'=>$this_->id,'position'=>$pre_->position));
            $this->update(array('id'=>$pre_->id,'position'=>$this_->position));
        }else{
            $this->update(array('id'=>$this_->id,'position'=>1));
        }
        return TRUE;
    }

    public function position_to_add_faq_pro($options=array())
    {
        $data = $this->db
                ->select('id,position')
                ->where('lang',  DEFAULT_LANGUAGE)
                ->order_by('position desc')
                ->limit(1)
                ->get('faq_professionals');
        if($data->num_rows() > 0){
            $data = $data->row(0);
            $position_add = $data->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_faq_pro($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        $data = $this->db
                ->select('id,position')
                ->where('lang',  DEFAULT_LANGUAGE)
                ->order_by('position desc')
//                ->limit(1)
                ->get('faq_professionals');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($data->num_rows() > 0){
            $data = $data->result();
            $position_max = $data[0]->position;
            foreach($data as $key => $m){
                if($m->id === $options['id']){
                    $position_edit = $m->position;
                    break;
                }else{
                    $position_edit = $position_max + 1;
                }
            }
        }else{
            $position_edit = 1;
        }
        return $position_edit;
    }
}
?>