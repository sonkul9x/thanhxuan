<?php
class Videos_Items_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function _set_where_conditions($options = array())
    {
        // WHERE
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        if (isset($options['video_id']))
            $this->db->where('video_id', $options['video_id']);
        if (isset($options['position']))
            $this->db->where('position', $options['position']);
    }

    function get_videos_items($options = array())
    {
        $this->_set_where_conditions($options);
        
        // ORDER
        if (isset($options['order']))
            $this->db->order_by($options['order']);
        else
            $this->db->order_by('position');

        // GET
        $query = $this->db->get('videos_items');

        if($query->num_rows() > 0){
            
            // RETURN
            if (isset($options['id']))
            {
                return $query->row(0);
            }
            if(isset($options['last_row']))
            {
                return $query->last_row();
            }
            return $query->result();
        }else{
            return NULL;
        }
        
    }

}
?>