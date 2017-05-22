<?php
class Advs_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }

    public function get_advs($options = array())
    {
        $this->db->select(' advs.*,
                    advs_categories.id as cat_id,
                    advs_categories.title as cat_title,
                    advs_categories.dimension as cat_dimension,
                    advs_categories.lang as cat_lang,
                ');

        $this->db->join('advs_categories', 'advs_categories.id = advs.type', 'left');
        
        if (isset($options['id'])) {
            $this->db->where('advs.id', $options['id']);
        }

        // loai banner front-end phai co.
        if(isset($options['type']) && $options['type'] <> DEFAULT_COMBO_VALUE){
            $this->db->where('advs.type', $options['type']);
            
            //neu co gioi han thoi gian hien thi banner
            if(isset($options['timelimited']) && $options['timelimited'] == TRUE){
                $current_time = now();          
                $cond = array(
                    'advs.start_time <= ' => $current_time,
                    'advs.end_time >= ' => $current_time,
                    'advs.type' => $options['type'],
                    'advs.status' => STATUS_ACTIVE,
                );
                $this->db->where($cond);
                $cond2 = "time_limited = ".STATUS_INACTIVE." AND type = ".$options['type'] . " AND status = ".STATUS_ACTIVE;
                $this->db->or_where($cond2);
            }
        }
        
        if (isset($options['lang'])) {
            $this->db->where('advs.lang', $options['lang']);
        }

        if (isset($options['status'])) {
            $this->db->where('advs.status', $options['status']);
        }

        if (isset($options['limit']) && isset($options['offset'])) {
            $this->db->limit($options['limit'], $options['offset']);
        } else if (isset($options['limit'])) {
            $this->db->limit($options['limit']);
        }

        $this->db->order_by('type, position, updated_date DESC, position');
        
        $query = $this->db->get('advs');
        if($query->num_rows() > 0){
            //lay 1 ban ghi duy nhat
            if (isset($options['onehit']) && $options['onehit'] == TRUE) {
                return $query->row(0);
            }
            if (isset($options['id'])) {
                return $query->row(0);
            }
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function count_advs($options = array())
    {
        return count($this->get_advs($options));
    }
    
    public function item_to_sort_advs($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_adv = $this->get_advs(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_adv = $this->db
                    ->select('id,position')
                    ->where('type',$this_adv->type)
                    ->where('position <',$this_adv->position)
                    ->where('lang',$this_adv->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('advs');
        if($pre_adv->num_rows() > 0){
            $pre_adv = $pre_adv->row(0);
            // Cap nhat lai position (doi position cho nhau)
            $this->update(array('id'=>$this_adv->id,'position'=>$pre_adv->position));
            $this->update(array('id'=>$pre_adv->id,'position'=>$this_adv->position));
        }else{
            $this->update(array('id'=>$this_adv->id,'position'=>1));
        }
        return TRUE;
    }

    public function position_to_add_advs($options=array())
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
                ->get('advs');
        if($support->num_rows() > 0){
            $support = $support->row(0);
            $position_add = $support->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function position_to_edit_advs($options=array())
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
                ->get('advs');
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