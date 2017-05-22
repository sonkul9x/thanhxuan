<?php
class Faq_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_faq($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select(' faq.*,
                            faq_categories.meta_title cat_meta_title,
                            faq_categories.meta_keywords cat_meta_keywords,
                            faq_categories.meta_description cat_meta_description,
                            faq_categories.parent_id,
                            faq_categories.category,
                        ');

            $this->db->join('faq_categories', 'faq_categories.id = faq.cat_id', 'left');
        }else{
            $this->db->select(' faq.*,
                            faq_categories.meta_title cat_meta_title,
                            faq_categories.meta_keywords cat_meta_keywords,
                            faq_categories.meta_description cat_meta_description,
                            faq_categories.parent_id,
                            faq_categories.category,
                            slug.slug,
                            slug.id slug_id,
                        ');
            $this->db->join('faq_categories', 'faq_categories.id = faq.cat_id', 'left');
            $this->db->join('slug', 'slug.type_id = faq.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_FAQ, 'left');
        }

        // lọc ngôn ngữ
        if(isset($options['lang']))
        {
            $this->db->where('faq.lang', $options['lang']);
        }
        
        if(isset($options['status']))
        {
            $this->db->where('faq.status', $options['status']);
        }
        
        if(isset($options['fullname']))
        {
            $this->db->where('faq.fullname', $options['fullname']);
        }
        
        if(isset($options['email']))
        {
            $this->db->where('faq.email', $options['email']);
        }

        // chi lay nhung faq moi nhat
        if (isset($options['flag']) && $options['flag']==NEWS_LATEST_NEWS)
        {
            $this->db->where('faq.created_date >\'' . $options['created_date'] . '\'');
            unset($options['id']); // loai bo id
        }

        if (isset($options['id']))
            if (isset($options['flag']) && $options['flag']==NEWS_OLDER_NEWS)
                $this->db->where('faq.created_date <\'' . $options['created_date'] . '\'');
            else
                $this->db->where('faq.id', $options['id']);

        // neu chon parent category thi se hien tat
        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
            $this->db->where('(cat_id = ' . $options['cat_id'] . ' OR parent_id = ' . $options['cat_id'] . ')');
        
        // lay tin  co cat_id xac dinh
        if(isset($options['type']))
        {
            $this->db->where('cat_id', $options['type']);
        }
        
        //lay tin tuc cung loai, tru tin tuc hien tai
        if(isset($options['current_id'])) {
            $this->db->where('faq.id != ',$options['current_id']);
        }
        
        // Tim kiem theo tu khoa
        if (isset($options['search']))
        {
            $where  = "(".$this->db->dbprefix."faq.title like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq.content like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq.summary like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        // Tim kiem theo tu khoa
        if (isset($options['keyword']))
        {
            $where  = "(".$this->db->dbprefix."faq.title like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq.content like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."faq.summary like'%" . $options['keyword'] . "%')";
            $this->db->where($where);
        }
        
        // Tim kiem theo tags
        if (isset($options['tags']))
        {
            $tags = str_replace('-',' ', $options['tags']);
            $where  = $this->db->dbprefix."faq.tags like'%" . $tags . "%'"; //"(".
//            $where .= " or ".$this->db->dbprefix."faq.title like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."faq.content like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."faq.summary like'%" . $tags . "%')";
            $this->db->where($where);
        }
        
        if(isset($options['except_id']))
            $this->db->where('faq.id !=', $options['except_id']);
        
        //        same
        if(isset($options['sort_by_id_high']) && isset($options['current_id'])){
            $this->db->where('faq.id > ', $options['current_id']);
        }
        if(isset($options['sort_by_id_low']) && isset($options['current_id'])){
            $this->db->where('faq.id < ', $options['current_id']);
        }
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('faq.viewed desc, faq.updated_date desc, faq.created_date desc');
        }elseif(isset($options['faq_sort_type']) && $options['faq_sort_type'] == 'sort_by_viewed_asc'){
            $this->db->order_by('faq.viewed asc');
        }elseif(isset($options['faq_sort_type']) && $options['faq_sort_type'] == 'sort_by_viewed_desc'){
            $this->db->order_by('faq.viewed desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }elseif(isset($options['sort_by_id_high']) || isset($options['sort_by_id_low'])){
            $this->db->order_by('faq.id desc');
        }else{
            $this->db->order_by('faq.position desc, faq.updated_date desc, faq.created_date desc');
        }
        
        $query = $this->db->get('faq');
        if($query->num_rows() > 0){
            if (isset($options['id'])) {
                if (!isset($options['flag'])) {
                    return $query->row(0);
                }
            }
            if(isset($options['onehit']) && $options['onehit'] == TRUE){
                return $query->row(0);
            }
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_faq_count($options = array())
    {
        return count($this->get_faq($options));
    }

    public function update_faq_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('faq');
    }

    public function item_to_sort_faq($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_faq = $this->get_faq(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $pre_faq = $this->db
                    ->select('id,position')
                    ->where('lang',$this_faq->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('faq');
        if($pre_faq->num_rows() > 0){
            $pre_faq = $pre_faq->row(0);
            $this->update(array('id'=>$this_faq->id,'position'=>$pre_faq->position+1));
        }else{
            $this->update(array('id'=>$this_faq->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_edit_faq($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $faq = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('faq');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($faq->num_rows() > 0){
            $faq = $faq->result();
            $position_max = $faq[0]->position;
            foreach($faq as $key => $m){
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
    
    public function position_to_add_faq($options=array())
    {
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $faq = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('faq');
        if($faq->num_rows() > 0){
            $faq = $faq->row(0);
            $position_add = $faq->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }

    public function get_faq_sort_combobox($options = array())
    {
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'sort_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data = array(
            '' => 'Mặc định',
            'sort_by_viewed_desc' => 'Lượt xem giảm dần',
            'sort_by_viewed_asc' => 'Lượt xem tăng dần',
        );

        if (!isset($options[$options['combo_name']])) 
            $options[$options['combo_name']] = '';

        return form_dropdown($options['combo_name'], $data, $options[$options['combo_name']], $options['extra']);

    }
    
    
}
?>