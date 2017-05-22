<?php
class Supports_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_supports($options = array())
    {
        if(isset($options['lang']))
            $this->db->where('lang', $options['lang']);
        if(isset($options['status']))
            $this->db->where('status', $options['status']);
        if(isset($options['type']))
            $this->db->where('type', $options['type']);
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        $this->db->order_by('type desc, position, update_time DESC');
        $query = $this->db->get('supports');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit']))
                return $query->row(0);
            if(isset($options['last_row']))
                return $query->last_row();
            return $query->result();
        }else{
            return NULL;
        }
        
    }
    
    public function item_to_sort_supports($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_support = $this->get_supports(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_support = $this->db
                    ->select('id,position')
                    ->where('type',$this_support->type)
                    ->where('position <',$this_support->position)
                    ->where('lang',$this_support->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('supports');
        if($pre_support->num_rows() > 0){
            $pre_support = $pre_support->row(0);
            // Cap nhat lai position (doi position cho nhau)
            $this->update(array('id'=>$this_support->id,'position'=>$pre_support->position));
            $this->update(array('id'=>$pre_support->id,'position'=>$this_support->position));
        }else{
            $this->update(array('id'=>$this_support->id,'position'=>1));
        }
        return TRUE;
    }

    public function position_to_add_supports($options=array())
    {
        if (!isset($options['type'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $support = $this->db
                ->select('id,position')
                ->where('type',$options['type'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('supports');
        if($support->num_rows() > 0){
            $support = $support->row(0);
            $position_add = $support->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_supports($options=array())
    {
        if (!isset($options['id']) || !isset($options['type'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $support = $this->db
                ->select('id,position')
                ->where('type',$options['type'])
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('supports');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($support->num_rows() > 0){
            $support = $support->result();
            $position_max = $support[0]->position;
            foreach($support as $key => $m){
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