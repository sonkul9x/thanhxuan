<?php
//nmd
class Products_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    private function _set_where_conditions($options = array())
    {
        // return the only one menu if id is specified
        if (isset($options['id']))
            $this->db->where('products.id', $options['id']);
        
        if (isset($options['lang']))
            $this->db->where('products.lang', $options['lang']);
        
        if (isset($options['home']))
            $this->db->where('products.home', $options['home']);
        
        if (isset($options['typical']))
            $this->db->where('products.typical', $options['typical']);
        
        if (isset($options['status']))
            $this->db->where('products.status', $options['status']);

        if (isset($options['product_name']))
            $this->db->like('products.product_name', $options['product_name']);

        if (isset($options['users_id']))
            $this->db->where('products.users_id', $options['users_id']);
        
        if (isset($options['cat_array'])){
            $this->db->where_in('products.categories_id',$options['cat_array']);
        }
        
        if (!isset($options['cat_array']) && isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '')
            $this->db->where('(' . $this->db->dbprefix . 'products.categories_id = ' . $options['cat_id'] . ' OR ' . $this->db->dbprefix . 'products_categories.parent_id = ' . $options['cat_id'] . ')');

        if(isset($options['cats_id']))
        {
            $this->db->where_in('products.categories_id', $options['cats_id']);
        }
        
        if (isset($options['origin_id']))
            $this->db->where('products.origin_id', $options['origin_id']);
        
        if (isset($options['trademark_id']))
            $this->db->where('products.trademark_id', $options['trademark_id']);
        
        if (isset($options['colors']))
            $this->db->where($this->db->dbprefix."products.colors like '%,".$options['colors'].",%'");
        
        if (isset($options['state_id']))
            $this->db->where('products.state_id', $options['state_id']);
        
        if (isset($options['material_id']))
            $this->db->where('products.material_id', $options['material_id']);
        
        if (isset($options['style_id']))
            $this->db->where('products.style_id', $options['style_id']);
        
        if (isset($options['size']))
            $this->db->where($this->db->dbprefix."products.size like '%,".$options['size'].",%'");
        
        //tim kiem theo tu khoa
//        if(isset($options['keyword']) && $options['keyword'] != '')
//        {
//            //$where  = $this->db->dbprefix."products.product_name like'%" . $this->db->escape_str($options['keyword']) . "%'";
//            $where  = $this->db->dbprefix."products.product_name like'%" . $options['keyword'] . "%'";
//            $this->db->where($where);
//        }
        if (isset($options['keyword']) && $options['keyword'] != '')
        {
            $where  = "(".$this->db->dbprefix."products.product_name like'%" . $this->db->escape_str($options['keyword']) . "%'";
			$where .= " or ".$this->db->dbprefix."products.code like'%" . $this->db->escape_str($options['keyword']) . "%'";
            $where .= " or ".$this->db->dbprefix."products.description like'%" . $this->db->escape_str($options['keyword']) . "%'";
            $where .= " or ".$this->db->dbprefix."products.summary like'%" . $this->db->escape_str($options['keyword']) . "%')";
            $this->db->where($where);
        }
        
        // Tim kiem theo tags
        if (isset($options['tags']))
        {
            $tags = str_replace('-',' ', $options['tags']);
            $where  = $this->db->dbprefix."products.tags like'%" . $tags . "%'"; //"(".
//            $where .= " or ".$this->db->dbprefix."products.product_name like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."products.description like'%" . $tags . "%'";
//            $where .= " or ".$this->db->dbprefix."products.summary like'%" . $tags . "%')";
            $this->db->where($where);
        }
        
        if(!isset($options['is_admin']))
        {
            $this->db->where('products.status', STATUS_ACTIVE);
            $pi_condition = '(('.$this->db->dbprefix.'product_images.position=1) OR ('.$this->db->dbprefix.'product_images.image_name <> NULL))';
            $this->db->where($pi_condition);
        }
        else{
            $pi_condition = '(('.$this->db->dbprefix.'product_images.position=1) OR ISNULL('.$this->db->dbprefix.'product_images.image_name))';
            $this->db->where($pi_condition);
        }
        
        //lay san pham cung loai, tru san pham hien tai
        if(isset($options['current_id'])) {
            $this->db->where('products.id != ',$options['current_id']);
        }
        
        //sames
        if(isset($options['sort_by_id_high']) && isset($options['current_id'])){
            $this->db->where('products.id > ', $options['current_id']);
        }
        if(isset($options['sort_by_id_low']) && isset($options['current_id'])){
            $this->db->where('products.id < ', $options['current_id']);
        }
        
        if(isset($options['topbuy']) && $options['topbuy'] == TRUE){
            $this->db->where('products.top_seller', PRODUCTS_TOP_SELLER);
        }

        if (isset($options['top_seller']) && $options['top_seller'] == TRUE) {
            $this->db->where('products.top_seller', PRODUCTS_TOP_SELLER);
        }
        
        if (isset($options['new'])) {
            $this->db->where('products.new', $options['new']);
        }

        if (isset($options['saleoff']) && $options['saleoff'] == TRUE) {
            $this->db->where('products.price_old >', 0);
        }
        
        if(isset($options['price_start']) && isset($options['price_end'])){
            if($options['price_start'] < $options['price_end']){
                $this->db->where('products.price >= ',$options['price_start']);
                $this->db->where('products.price <= ',$options['price_end']);
            }else{
                $this->db->where('products.price >= ',$options['price_start']);
            }
        }
        
    }
    
    /**
     * Trả lại tổng số sản phầm dựa trên các điều kiện lọc
     * 
     * @param <type> $options
     */
    function get_products_count($options = array())
    {
        $this->db->join('products_categories', 'products.categories_id = products_categories.id', 'left');
        $this->db->join('product_images', 'products.id = product_images.products_id', 'left');
        // where
        $this->_set_where_conditions($options);
        // get
        return $this->db->count_all_results('products');
    }

    /**
     * Trả lại danh sách các sản phẩm dựa trên điệu kiện lọc
     * @param <type> $options
     */
    function get_products($options = array())
    {
        // select
        if(SLUG_ACTIVE==0){
            $this->db->select(' products.*,
                                products_categories.id cat_id,
                                products_categories.category,
                                products_categories.parent_id,
                                products_categories.meta_title cat_meta_title,
                                products_categories.meta_keywords cat_meta_keywords,
                                products_categories.meta_description cat_meta_title,
                                product_images.id image_id,
                                product_images.image_name,
                                units.name as unit,
                                products_origin.name origin_name,
                                products_trademark.name trademark_name,
                                products_style.name style_name,
                                products_material.name material_name,
                                products_state.name state_name,
                            ');
            $this->db->join('product_images', 'products.id = product_images.products_id', 'left');
            $this->db->join('units', 'products.unit_id = units.id', 'LEFT OUTER');
    //        $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');
            $this->db->join('products_categories', 'products.categories_id = products_categories.id', 'left');
            $this->db->join('products_origin', 'products.origin_id = products_origin.id', 'left');
            $this->db->join('products_trademark', 'products.trademark_id = products_trademark.id', 'left');
            $this->db->join('products_style', 'products.style_id = products_style.id', 'left');
            $this->db->join('products_material', 'products.material_id = products_material.id', 'left');
            $this->db->join('products_state', 'products.state_id = products_state.id', 'left');
        }else{
            $this->db->select(' products.*,
                                products_categories.id cat_id,
                                products_categories.category,
                                products_categories.parent_id,
                                products_categories.meta_title cat_meta_title,
                                products_categories.meta_keywords cat_meta_keywords,
                                products_categories.meta_description cat_meta_title,
                                product_images.id image_id,
                                product_images.image_name,
                                units.name as unit,
                                products_origin.name origin_name,
                                products_trademark.name trademark_name,
                                products_style.name style_name,
                                products_material.name material_name,
                                products_state.name state_name,
                                slug.slug,
                                slug.id slug_id,
                            ');
            $this->db->join('product_images', 'products.id = product_images.products_id', 'left');
            $this->db->join('units', 'products.unit_id = units.id', 'LEFT OUTER');
    //        $this->db->where('((product_images.position=1) OR ISNULL(product_images.image_name))');
            $this->db->join('products_categories', 'products.categories_id = products_categories.id', 'left');
            $this->db->join('products_origin', 'products.origin_id = products_origin.id', 'left');
            $this->db->join('products_trademark', 'products.trademark_id = products_trademark.id', 'left');
            $this->db->join('products_style', 'products.style_id = products_style.id', 'left');
            $this->db->join('products_material', 'products.material_id = products_material.id', 'left');
            $this->db->join('products_state', 'products.state_id = products_state.id', 'left');
            $this->db->join('slug', 'slug.type_id = products.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_PRODUCTS, 'left');
        }
        
        // where
        $this->_set_where_conditions($options);
        // limit / offset
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);
        // order
        if(isset($options['topview']) && $options['topview'] == TRUE){
            $this->db->order_by('viewed desc');
        }elseif(isset($options['products_sort_type']) && $options['products_sort_type'] == 'sort_by_viewed_asc'){
            $this->db->order_by('products.viewed asc');
        }elseif(isset($options['products_sort_type']) && $options['products_sort_type'] == 'sort_by_viewed_desc'){
            $this->db->order_by('products.viewed desc');
        }elseif(isset($options['products_sort_type']) && $options['products_sort_type'] == 'sort_by_home_desc'){
            $this->db->order_by('products.home desc');
        }elseif(isset($options['products_sort_type']) && $options['products_sort_type'] == 'sort_by_price_asc'){
            $this->db->order_by('products.price asc, products.price_old asc');
        }elseif(isset($options['products_sort_type']) && $options['products_sort_type'] == 'sort_by_price_desc'){
            $this->db->order_by('products.price desc, products.price_old desc');
        }elseif(isset($options['random']) && $options['random'] == TRUE){
            $this->db->order_by('RAND()');
        }elseif(isset($options['sort_by_id_high']) || isset($options['sort_by_id_low'])){
            $this->db->order_by('products.id desc');
        }else{
            $this->db->order_by('products.position desc, products.updated_date desc');
        }
        
        // get
        $query = $this->db->get('products');
        
        if($query->num_rows() > 0){
            if(isset ($options['id']) || isset ($options['onehit']))
                return $query->row(0);
            if(isset ($options['array']))
                return $query->result_array();
            return $query->result();
        }else{
            return NULL;
        }

    }

    function up_product($id = 0, $updated_date = NULL)
    {
        $data = array();
        if (is_null($updated_date))
            $data['updated_date'] = date('Y-m-d H:i:s');
        else
            $data['updated_date'] = $updated_date;

        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    public function update_products_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('products');
    }
    
    public function item_to_sort_products($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        // Lay ban ghi can up len
        $this_products = $this->get_products(array('id'=>$options['id']));
        // Lay ban ghi co thu tu truoc ban ghi can up len
        $top_products = $this->db
                    ->select('id,position')
                    ->where('lang',$this_products->lang)
                    ->order_by('position desc')
                    ->limit(1)
                    ->get('products');
        if($top_products->num_rows() > 0){
            $top_products = $top_products->row(0);
            $this->update(array('id'=>$this_products->id,'position'=>$top_products->position+1));
        }else{
            $this->update(array('id'=>$this_products->id,'position'=>1));
        }
        return TRUE;
    }
    
    public function position_to_edit_products($options=array())
    {
        if (!isset($options['id'])) {
            return NULL;
        }
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $products = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
//                ->limit(1)
                ->get('products');
        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1
        if($products->num_rows() > 0){
            $products = $products->result();
            $position_max = $products[0]->position;
            foreach($products as $key => $m){
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
    
    public function position_to_add_products($options=array())
    {
        if (!isset($options['lang'])) {
            $options['lang'] = DEFAULT_LANGUAGE;
        }
        $products = $this->db
                ->select('id,position')
                ->where('lang',  $options['lang'])
                ->order_by('position desc')
                ->limit(1)
                ->get('products');
        if($products->num_rows() > 0){
            $products = $products->row(0);
            $position_add = $products->position + 1;
        }else{
            $position_add = 1;
        }
        return $position_add;
    }
    
    public function get_products_sort_combobox($options = array())
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
//            'sort_by_home_desc' => 'Sản phẩm trên trang chủ',
        );

        if (!isset($options[$options['combo_name']])) 
            $options[$options['combo_name']] = '';

        return form_dropdown($options['combo_name'], $data, $options[$options['combo_name']], $options['extra']);
    }
    
    public function products_filter_group($options=array())
    {
        $this->db->select('products.'.$options['group_by'].', products_'.$options['attr'].'.name as '.$options['attr'].'_name, COUNT('.$options['group_by'].') as total');
        $this->db->join('products_categories', 'products.categories_id = products_categories.id', 'left');
        $this->db->join('products_'.$options['attr'].'', 'products.'.$options['group_by'].' = products_'.$options['attr'].'.id', 'left');
        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE && $options['cat_id'] != ROOT_CATEGORY_ID && $options['cat_id'] != '') {
            $this->db->where('(' . $this->db->dbprefix . 'products.categories_id = ' . $options['cat_id'] . ' OR ' . $this->db->dbprefix . 'products_categories.parent_id = ' . $options['cat_id'] . ')');
        }
        if (isset($options['origin_id'])) {
            $this->db->where('products.origin_id', $options['origin_id']);
        }
        if (isset($options['trademark_id'])) {
            $this->db->where('products.trademark_id', $options['trademark_id']);
        }
        if (isset($options['colors'])) {
            $this->db->where($this->db->dbprefix . "products.colors like '%," . $options['colors'] . ",%'");
        }
        if (isset($options['state_id'])) {
            $this->db->where('products.state_id', $options['state_id']);
        }
        if (isset($options['material_id'])) {
            $this->db->where('products.material_id', $options['material_id']);
        }
        if (isset($options['style_id'])) {
            $this->db->where('products.style_id', $options['style_id']);
        }
        if (isset($options['size'])) {
            $this->db->where($this->db->dbprefix . "products.size like '%," . $options['size'] . ",%'");
        }
        if(isset($options['price_start']) && isset($options['price_end'])){
            if($options['price_start'] < $options['price_end']){
                $this->db->where('products.price >= ',$options['price_start']);
                $this->db->where('products.price <= ',$options['price_end']);
            }else{
                $this->db->where('products.price >= ',$options['price_start']);
            }
        }
        
        $this->db->group_by($options['group_by']);
        $this->db->order_by('products_'.$options['attr'].'.name', 'asc');
        $query = $this->db->get('products');
        if($query->num_rows() > 0){
            if(!empty($options['is_string_color'])){
                $data = $query->result();
                if(!empty($data)){
                    $result = array();
                    $colors_string = '';
                    foreach($data as $key => $value){
                        $colors_string .= $value->colors;
                    }
                    $colors_string = @str_replace(',,', ',', $colors_string);
                    $colors_array = @explode(',', $colors_string);
                    $colors_array = @array_filter($colors_array);
                    $colors_array = @array_unique($colors_array);
                    if(!empty($colors_array)){
                        @sort($colors_array);
                        foreach($colors_array as $key => $value){
                            $color = $this->products_color_model->get_products_color(array('id'=>$value));
                            $result[$color->id] = $color->name;
                        }
                    }
                    return $result;
                }else{
                    return NULL;
                }
            }elseif(!empty($options['is_string_size'])){
                $data = $query->result();
                if(!empty($data)){
                    $result = array();
                    $size_string = '';
                    foreach($data as $key => $value){
                        $size_string .= $value->size;
                    }
                    $size_string = @str_replace(',,', ',', $size_string);
                    $size_array = @explode(',', $size_string);
                    $size_array = @array_filter($size_array);
                    $size_array = @array_unique($size_array);
                    if(!empty($size_array)){
                        @sort($size_array);
                        foreach($size_array as $key => $value){
                            $size = $this->products_size_model->get_products_size(array('id'=>$value));
                            $result[$size->id] = $size->name;
                        }
                    }
                    return $result;
                }else{
                    return NULL;
                }
            }else{
                return $query->result();
            }
        }else{
            return NULL;
        }
    }

    public function sql_get_by_cat($cat_id=0)
    {
        $cat = '';
        $data = $this->products_categories_model->get_categories(array('parent_id'=>$cat_id));
        if(!empty($data)){
            foreach($data as $key => $value){
                $cat .= $value->id . ',';
                $cat .= $this->sql_get_by_cat($value->id);
            }
            return $cat;
        }else{
            return NULL;
        }
    }
    
}
?>