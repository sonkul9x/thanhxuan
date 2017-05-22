<?php
class News_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_news($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select(' news.*,
                        news_categories.meta_title cat_meta_title,
                        news_categories.meta_keywords cat_meta_keywords,
                        news_categories.meta_description cat_meta_description,
                        news_categories.parent_id,
                        news_categories.category,
                        news_categories.private,
                        uc.id creator_id,
                        uc.username creator_username,
                        uc.fullname creator_fullname,
                        ue.id editor_id,
                        ue.username editor_username,
                        ue.fullname editor_fullname,
                    ');
            $this->db->join('news_categories', 'news_categories.id = news.cat_id', 'left');
            $this->db->join('users uc', 'uc.id = news.creator', 'left');
            $this->db->join('users ue', 'ue.id = news.editor', 'left');
        }else{
            $this->db->select(' news.*,
                        news_categories.meta_title cat_meta_title,
                        news_categories.meta_keywords cat_meta_keywords,
                        news_categories.meta_description cat_meta_description,
                        news_categories.parent_id,
                        news_categories.category,
                        news_categories.private,
                        slug.slug,
                        slug.id slug_id,
                        uc.id creator_id,
                        uc.username creator_username,
                        uc.fullname creator_fullname,
                        ue.id editor_id,
                        ue.username editor_username,
                        ue.fullname editor_fullname,
                    ');
            $this->db->join('news_categories', 'news_categories.id = news.cat_id', 'left');
            $this->db->join('users uc', 'uc.id = news.creator', 'left');
            $this->db->join('users ue', 'ue.id = news.editor', 'left');
            $this->db->join('slug', 'slug.type_id = news.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_NEWS, 'left');
        }
        
        //hen gio dang bai
        if (empty($options['is_show'])) {
            $this->db->where('news.created_date <= ', date('Y-m-d H:i:s'));
        }
        
        // lọc ngôn ngữ
        if(isset($options['lang']))
        {
            $this->db->where('news.lang', $options['lang']);
        }
        
        if(isset($options['status']))
        {
            $this->db->where('news.status', $options['status']);
        }
        
        if(isset($options['startups']) && $options['startups'] == TRUE)
        {
            $this->db->where('news.startups', $options['startups']);
        }
        
        if(isset($options['home']))
        {
            $this->db->where('news.home', $options['home']);
        }

        $is_logged_in = modules::run('auth/auth/is_logged_in');
        if (!$is_logged_in) {
            $this->db->where('news_categories.private', STATUS_INACTIVE);
        }

        // chi lay nhung news moi nhat
        if (isset($options['flag']) && $options['flag']==NEWS_LATEST_NEWS)
        {
            $this->db->where('news.created_date >\'' . $options['created_date'] . '\'');
            unset($options['news.id']); // loai bo id
        }

        if (isset($options['id']))
            if (isset($options['flag']) && $options['flag']==NEWS_OLDER_NEWS)
                $this->db->where('news.created_date <\'' . $options['created_date'] . '\'');
            else
                $this->db->where('news.id', $options['id']);

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
            $this->db->where('news.id != ',$options['current_id']);
        }
        
        // Tim kiem theo tu khoa
        if (isset($options['search']))
        {
            $where  = "(".$this->db->dbprefix."news.title like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."news.content like'%" . $options['search'] . "%'";
            $where .= " or ".$this->db->dbprefix."news.summary like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        
        // Tim kiem theo tu khoa
        if (isset($options['keyword']))
        {
            $where  = "(".$this->db->dbprefix."news.title like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."news.content like'%" . $options['keyword'] . "%'";
            $where .= " or ".$this->db->dbprefix."news.summary like'%" . $options['keyword'] . "%')";
            $this->db->where($where);
        }
        
        // Tim kiem theo tags
        if (isset($options['tags']))
        {
            $tags = str_replace('-',' ', $options['tags']);
            $where  = $this->db->dbprefix."news.tags like'%" . $tags . "%'"; //"(".
//            $where .= " or ".$this->db->dbprefix."news.title like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."news.content like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."news.summary like'%" . $tags . "%')";
            $this->db->where($where);
        }
        
        if(isset($options['except_id']))
            $this->db->where('news.id !=', $options['except_id']);
        
        //        samenews
        if(isset($options['sort_by_id_high']) && isset($options['current_id'])){
            $this->db->where('news.id > ', $options['current_id']);
        }
        if(isset($options['sort_by_id_low']) && isset($options['current_id'])){
            $this->db->where('news.id < ', $options['current_id']);
        }
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        if(isset($options['sort_by_viewed'])){
            $this->db->order_by('news.viewed desc, news.updated_date desc, news.created_date desc');
        }elseif(isset($options['news_sort_type']) && $options['news_sort_type'] == 'sort_by_viewed_asc'){
            $this->db->order_by('news.viewed asc');
        }elseif(isset($options['news_sort_type']) && $options['news_sort_type'] == 'sort_by_viewed_desc'){
            $this->db->order_by('news.viewed desc');
        }
//        elseif(isset($options['news_sort_type']) && $options['news_sort_type'] == 'sort_by_home_desc'){
//            $this->db->order_by('news.home desc');
//        }
        elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }elseif(isset($options['sort_by_id_high']) || isset($options['sort_by_id_low'])){
            $this->db->order_by('news.id desc');
        }else{
            $this->db->order_by('news.position desc, news.updated_date desc, news.created_date desc');
        }
        
        $query = $this->db->get('news');
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

    public function get_news_count($options = array())
    {
        return count($this->get_news($options));
    }

    public function update_news_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news');
    }
    
    public function item_to_sort_news($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_news = $this->get_news(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $top_news = $this->db
                    ->select('id,position')
                    ->where('lang',$this_news->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('news');
        if($top_news->num_rows() > 0){
            $top_news = $top_news->row(0);
            $this->update(array('id'=>$this_news->id,'position'=>$top_news->position+1));
        }else{
            $this->update(array('id'=>$this_news->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_edit_news($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $news = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('news');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($news->num_rows() > 0){
            $news = $news->result();
            $position_max = $news[0]->position;
            foreach($news as $key => $m){
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
    
    public function position_to_add_news($options=array())
    {
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $news = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('news');
        if($news->num_rows() > 0){
            $news = $news->row(0);
            $position_add = $news->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }

    public function get_news_sort_combobox($options = array())
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
//            'sort_by_home_desc' => 'Hiện trên trang chủ',
        );

        if (!isset($options[$options['combo_name']])) 
            $options[$options['combo_name']] = '';

        return form_dropdown($options['combo_name'], $data, $options[$options['combo_name']], $options['extra']);

    }
    
}
?>