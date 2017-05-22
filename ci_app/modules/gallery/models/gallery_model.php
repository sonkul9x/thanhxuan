<?php
class Gallery_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    private function _set_where_conditions($options = array())
    {
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('gallery.id', $options['id']);
        
        if (isset($options['lang']))
            $this->db->where('gallery.lang', $options['lang']);

        if (isset($options['gallery_name']))
            $this->db->like('gallery.gallery_name', $options['gallery_name']);

        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
            $this->db->where('(cat_id = ' . $options['cat_id'] . ' OR parent_id = ' . $options['cat_id'] . ')');

//        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
//            $this->db->where('gallery.cat_id', $options['cat_id']);
        
        //tim kiem theo tu khoa
        if (isset($options['keyword']) && $options['keyword'] != '')
        {
            $where  = "(".$this->db->dbprefix."gallery.gallery_name like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."gallery.content like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."gallery.summary like'%" . $options['keyword'] . "%')";
            $this->db->where($where);
        }

        if(!isset($options['is_admin']))
        {
            $this->db->where('gallery.status', STATUS_ACTIVE);
            $pi_condition = '(('.$this->db->dbprefix.'gallery_images.position=1) OR ('.$this->db->dbprefix.'gallery_images.image_name <> NULL))';
            $this->db->where($pi_condition);
        }
        else{
            $pi_condition = '(('.$this->db->dbprefix.'gallery_images.position=1) OR ISNULL('.$this->db->dbprefix.'gallery_images.image_name))';
            $this->db->where($pi_condition);
        }
        
        //lay cung loai, tru  hien tai
        if(isset($options['current_id'])) {
            $this->db->where('gallery.id != ',$options['current_id']);
        }
        
    }
    
    function get_gallery_count($options = array())
    {
        $this->db->join('gallery_categories', 'gallery.cat_id = gallery_categories.id', 'left');
        $this->db->join('gallery_images', 'gallery.id = gallery_images.gallery_id', 'left');
        // where
        $this->_set_where_conditions($options);
        // get
        return $this->db->count_all_results('gallery');
    }
    
    function get_gallery($options = array())
    {
        // select
        if(SLUG_ACTIVE==0){
            $this->db->select(' gallery.*,
                                gallery_categories.id category_id,
                                gallery_categories.category,
                                gallery_categories.meta_title cat_meta_title,
                                gallery_categories.meta_keywords cat_meta_keywords,
                                gallery_categories.meta_description cat_meta_title,
                                gallery_images.id image_id,
                                gallery_images.image_name,
                            ');
            //join users
            // join images
            $this->db->join('gallery_images', 'gallery.id = gallery_images.gallery_id', 'left');
    //        $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');
            // join categories
            $this->db->join('gallery_categories', 'gallery.cat_id = gallery_categories.id', 'left');
        }else{
            $this->db->select(' gallery.*,
                                gallery_categories.id category_id,
                                gallery_categories.category,
                                gallery_categories.meta_title cat_meta_title,
                                gallery_categories.meta_keywords cat_meta_keywords,
                                gallery_categories.meta_description cat_meta_title,
                                gallery_images.id image_id,
                                gallery_images.image_name,
                                slug.slug,
                                slug.id slug_id,
                            ');
            //join users
            // join images
            $this->db->join('gallery_images', 'gallery.id = gallery_images.gallery_id', 'left');
    //        $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');
            // join categories
            $this->db->join('gallery_categories', 'gallery.cat_id = gallery_categories.id', 'left');
            $this->db->join('slug', 'slug.type_id = gallery.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_GALLERY, 'left');
        }
        
        // where
        $this->_set_where_conditions($options);
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('gallery.viewed desc, gallery.update_time desc, gallery.create_time desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }else{
            $this->db->order_by('gallery.position desc, gallery.update_time desc, gallery.create_time desc');
        }
        
        // get
        $query = $this->db->get('gallery');
        
        if($query->num_rows() > 0){
            if (isset($options['id'])) {
                return $query->row(0);
            }
            if(isset($options['onehit']) && $options['onehit'] == TRUE){
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
    
    public function update_gallery_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('gallery');
    }
    
    
    public function item_to_sort_gallery($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_gallery = $this->get_gallery(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $top_gallery = $this->db
                    ->select('id,position')
                    ->where('lang',$this_gallery->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('gallery');
        if($top_gallery->num_rows() > 0){
            $top_gallery = $top_gallery->row(0);
            $this->update(array('id'=>$this_gallery->id,'position'=>$top_gallery->position+1));
        }else{
            $this->update(array('id'=>$this_gallery->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_edit_gallery($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $gallery = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('gallery');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($gallery->num_rows() > 0){
            $gallery = $gallery->result();
            $position_max = $gallery[0]->position;
            foreach($gallery as $key => $m){
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
    
    public function position_to_add_gallery($options=array())
    {
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $gallery = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('gallery');
        if($gallery->num_rows() > 0){
            $gallery = $gallery->row(0);
            $position_add = $gallery->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }

    
}