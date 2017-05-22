<?php
class Videos_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    private function _set_where_conditions($options = array())
    {
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('videos.id', $options['id']);
        
        if (isset($options['lang']))
            $this->db->where('videos.lang', $options['lang']);

        if (isset($options['title']))
            $this->db->like('videos.title', $options['title']);

//        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
//            $this->db->where('(cat_id = ' . $options['cat_id'] . ' OR parent_id = ' . $options['cat_id'] . ')');

        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
            $this->db->where('videos.cat_id', $options['cat_id']);
        
        //tim kiem theo tu khoa
        if (isset($options['keyword']) && $options['keyword'] != '')
        {
            $where  = "(".$this->db->dbprefix."videos.title like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."videos.summary like'%" . $options['keyword'] . "%')";
            $this->db->where($where);
        }

        if(!isset($options['is_admin']))
        {
            $this->db->where('videos.status', STATUS_ACTIVE);
            $pi_condition = '(('.$this->db->dbprefix.'videos_items.position=1) OR ('.$this->db->dbprefix.'videos_items.image_name <> NULL))';
            $this->db->where($pi_condition);
        }
        else{
            $pi_condition = '(('.$this->db->dbprefix.'videos_items.position=1) OR ISNULL('.$this->db->dbprefix.'videos_items.image_name))';
            $this->db->where($pi_condition);
        }
        
        //lay cung loai, tru  hien tai
        if(isset($options['current_id'])) {
            $this->db->where('videos.id != ',$options['current_id']);
        }
        
    }
    
    function get_videos_count($options = array())
    {
        $this->db->join('videos_categories', 'videos.cat_id = videos_categories.id', 'left');
        $this->db->join('videos_items', 'videos.id = videos_items.video_id', 'left');
        // where
        $this->_set_where_conditions($options);
        // get
        return $this->db->count_all_results('videos');
    }
    
    function get_videos($options = array())
    {
        // select
        if(SLUG_ACTIVE==0){
            $this->db->select(' videos.*,
                                videos_categories.id category_id,
                                videos_categories.category,
                                videos_categories.meta_title cat_meta_title,
                                videos_categories.meta_keywords cat_meta_keywords,
                                videos_categories.meta_description cat_meta_title,
                                videos_items.id item_id,
                                videos_items.image_name,
                                videos_items.url,
                                videos_items.youtube_video_id,
                            ');
            // join images
            $this->db->join('videos_items', 'videos.id = videos_items.video_id', 'left');
            // join categories
            $this->db->join('videos_categories', 'videos.cat_id = videos_categories.id', 'left');
        }else{
            $this->db->select(' videos.*,
                                videos_categories.id category_id,
                                videos_categories.category,
                                videos_categories.meta_title cat_meta_title,
                                videos_categories.meta_keywords cat_meta_keywords,
                                videos_categories.meta_description cat_meta_title,
                                videos_items.id item_id,
                                videos_items.image_name,
                                videos_items.url,
                                videos_items.youtube_video_id,
                                slug.slug,
                                slug.id slug_id,
                            ');
            // join images
            $this->db->join('videos_items', 'videos.id = videos_items.video_id', 'left');
            // join categories
            $this->db->join('videos_categories', 'videos.cat_id = videos_categories.id', 'left');
            $this->db->join('slug', 'slug.type_id = videos.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_VIDEOS, 'left');
        }
        
        // where
        $this->_set_where_conditions($options);
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
        
        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('videos.viewed desc, videos.update_time desc, videos.create_time desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }else{
            $this->db->order_by('videos.position desc, videos.update_time desc, videos.create_time desc');
        }
        
        // get
        $query = $this->db->get('videos');
        
        if($query->num_rows() > 0){
            if (isset($options['id'])) {
                return $query->row(0);
            }
            if (isset($options['onehit']) && $options['onehit'] == TRUE) {
                return $query->row(0);
            }
            if (isset($options['array'])) {
                return $query->result_array();
            }
            return $query->result();
        }else{
            return NULL;
        }

    }
    
    public function update_videos_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('videos');
    }
    
    
    public function item_to_sort_videos($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_videos = $this->get_videos(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $top_videos = $this->db
                    ->select('id,position')
                    ->where('lang',$this_videos->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('videos');
        if($top_videos->num_rows() > 0){
            $top_videos = $top_videos->row(0);
            $this->update(array('id'=>$this_videos->id,'position'=>$top_videos->position+1));
        }else{
            $this->update(array('id'=>$this_videos->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_edit_videos($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $videos = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('videos');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($videos->num_rows() > 0){
            $videos = $videos->result();
            $position_max = $videos[0]->position;
            foreach($videos as $key => $m){
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
    
    public function position_to_add_videos($options=array())
    {
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $videos = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('videos');
        if($videos->num_rows() > 0){
            $videos = $videos->row(0);
            $position_add = $videos->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }

    
}