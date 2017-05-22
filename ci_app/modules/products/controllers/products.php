<?php

class Products extends MY_Controller

{

    function __construct()

    {

        parent::__construct();

        $this->_layout = 'layout/content_layout';

        $this->_view_data = array(

            'module_name' => 'products',

        );

    }



    public function products_by_cond($options=array())

    {

        $options['status'] = STATUS_ACTIVE;

        $data = $this->products_model->get_products($options);

        return $data;

    }

    

    public function products_search($para1=NULL, $para2=DEFAULT_LANGUAGE){

        $keyword = $this->db->escape_str($this->input->post('keyword'));

        

        if (isset($keyword) && !empty($keyword)) {

            $this->phpsession->save('products_search_keyword', $keyword);

        } else {

            $keyword = $this->phpsession->get('products_search_keyword');

        }



        $options = array('keyword'=>$keyword,'page'=>$para1,'lang'=>switch_language($para2),'status'=>STATUS_ACTIVE);

        $config = get_cache('configurations_' .  $options['lang']);

        $products_per_page = $config['products_per_page'] <> 0 ? $config['products_per_page'] : PRODUCTS_PER_PAGE;



//        $products_per_page = PRODUCTS_PER_PAGE;

                

        $total_row = $this->products_model->get_products_count($options);

        $total_pages = (int)($total_row / $products_per_page);

        

        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){

            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2);

            $uri_segment = 3;

        }else{

            $base_url = site_url().$this->uri->segment(1);

            $uri_segment = 2;

        }

        

        $paging_config = array(

            'base_url'          => $base_url,

            'total_rows'        => $total_row,

            'per_page'          => $products_per_page,

            'uri_segment'       => $uri_segment,   

            'use_page_numbers'  => TRUE,

            'first_link'        => __('IP_paging_first'),

            'last_link'         => __('IP_paging_last'),

            'num_links'         => 1,

        );

        $this->pagination->initialize($paging_config);

        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;

        $options['limit']   = $paging_config['per_page'];

        

        $products = $this->products_model->get_products($options);

            

        $view_data = array(

            'products'      => $products,

            'category'      => __('IP_search_result'),

            'total_row'     => $total_row,

            'keyword'       => $keyword,

            'title'         => __('IP_search_result'),

            'lang'          => $options['lang'],

        );



        $this->_view_data['main_content'] = $this->load->view('products_search',$view_data, TRUE);



        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }

    

    public function products_tags($para1=NULL, $para2=DEFAULT_LANGUAGE, $para3=NULL){        

        $options = array('tags'=>$para3,'page'=>$para1,'lang'=>switch_language($para2),'status'=>STATUS_ACTIVE);

        

        $config = get_cache('configurations_' .  $options['lang']);

        $products_per_page = $config['products_per_page'] <> 0 ? $config['products_per_page'] : PRODUCTS_PER_PAGE;



//        $products_per_page = PRODUCTS_PER_PAGE;

                

        $total_row = $this->products_model->get_products_count($options);

        $total_pages = (int)($total_row / $products_per_page);

        

        if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){

            $base_url = site_url().$options['lang'].'/'.$this->uri->segment(2).'/'.$options['tags'];

            $uri_segment = 4;

        }else{

            $base_url = site_url().$this->uri->segment(1).'/'.$options['tags'];

            $uri_segment = 3;

        }

        

        $paging_config = array(

            'base_url'          => $base_url,

            'total_rows'        => $total_row,

            'per_page'          => $products_per_page,

            'uri_segment'       => $uri_segment,   

            'use_page_numbers'  => TRUE,

            'first_link'        => __('IP_paging_first'),

            'last_link'         => __('IP_paging_last'),

            'num_links'         => 1,

        );

        $this->pagination->initialize($paging_config);

        $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;

        $options['limit']   = $paging_config['per_page'];

        

        $products = $this->products_model->get_products($options);

        $tags = str_replace('-',' ', $options['tags']);

        $view_data = array(

            'products'      => $products,

            'category'      => $tags,

            'total_row'     => $total_row,

            'tags'          => $tags,

            'title'         => __('IP_tags'),

            'lang'          => $options['lang'],

        );



        $this->_view_data['main_content'] = $this->load->view('products_tags',$view_data, TRUE);



        $this->load->view($this->_layout, $this->_view_data, FALSE);

    }

    

    public function get_products_home($options=array())

    {

        $config = get_cache('configurations');

        $products_per_page = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_HOME;

        $options['limit']=$products_per_page;

        $options['status']=STATUS_ACTIVE;

        //$options['random']=TRUE;

        $cats = $this->products_categories_model->get_categories(array('parent_id'=>0,'home'=>STATUS_ACTIVE,'status'=>STATUS_ACTIVE));

		$arr = array();

        if(!empty($cats)){

            foreach($cats as $key => $value){

                $options['cat_id']=$value->id;

                $cat_array = $this->products_model->sql_get_by_cat($options['cat_id']);

                $cat_array .= $options['cat_id'];

                $options['cat_array'] = @explode(',', $cat_array);

                $arr[] = array(

                    'id'=>$value->id,

                    'category'=>$value->category,

                    'category_slug' => isset($value->slug)?$value->slug:'',

                    'products'=>$this->products_model->get_products($options),

                );

            }

        }

        return $arr;

//        $view_data = array(

//            'results' => $arr,

//        );

//        return $this->_view_data['main_content'] = $this->load->view('products_main',$view_data, TRUE);

    }

    

    public function get_list_products_by_cat($para1=NULL, $para2=NULL, $para3=NULL, $para4=NULL)

    {

        $options = array('cat_id'=>$para1,'page'=>$para2,'lang'=>switch_language($para3),'status'=>STATUS_ACTIVE);

        

        $cat_array = $this->products_model->sql_get_by_cat($options['cat_id']);

        $cat_array .= $options['cat_id'];

        $options['cat_array'] = @explode(',', $cat_array);

        

        if($para4 == 1){

            $options['new'] = STATUS_ACTIVE;

        }

        if($para4 == 2){

            $options['top_seller'] = STATUS_ACTIVE;

        }

        if($para4 == 3){

            $options['saleoff'] = STATUS_ACTIVE;

        }

        

        $sortby = $this->phpsession->get('sortby');

        

        if($sortby == 'price_asc'){

            $options['products_sort_type'] = 'sort_by_price_asc';

        }elseif($sortby == 'price_desc'){

            $options['products_sort_type'] = 'sort_by_price_desc';

        }

        

        $price = $this->phpsession->get('price');

        $size = $this->phpsession->get('size');

        $color = $this->phpsession->get('color');

        $trademark = $this->phpsession->get('trademark');

        $material = $this->phpsession->get('material');

        $origin = $this->phpsession->get('origin');

        $style = $this->phpsession->get('style');

        

        if(empty($price)){

            $price = $this->db->escape_str($this->input->get('price', TRUE));

            $this->phpsession->save('price', $price);

        }

        if($size){

            $size_data = $this->products_size_model->get_products_size(array('id'=>$size));

            if(!empty($size_data)){

                $size_name = $size_data->name;

            }

            $options['size'] = $size;

        }else{

            $size = $this->db->escape_str($this->input->get('size', TRUE));

            $this->phpsession->save('size', $size);

        }

        if($color){

            $color_data = $this->products_color_model->get_products_color(array('id'=>$color));

            if(!empty($color_data)){

                $color_name = $color_data->name;

            }

            $options['colors'] = $color;

        }else{

            $color = $this->db->escape_str($this->input->get('color', TRUE));

            $this->phpsession->save('color', $color);

        }

        if($trademark){

            $trademark_data = $this->products_trademark_model->get_products_trademark(array('id'=>$trademark));

            if(!empty($trademark_data)){

                $trademark_name = $trademark_data->name;

            }

            $options['trademark_id'] = $trademark;

        }else{

            $trademark = $this->db->escape_str($this->input->get('trademark', TRUE));

            $this->phpsession->save('trademark', $trademark);

        }

        if($material){

            $material_data = $this->products_material_model->get_products_material(array('id'=>$material));

            if(!empty($material_data)){

                $material_name = $material_data->name;

            }

            $options['material_id'] = $material;

        }else{

            $material = $this->db->escape_str($this->input->get('material', TRUE));

            $this->phpsession->save('material', $material);

        }

        if($origin){

            $origin_data = $this->products_origin_model->get_products_origin(array('id'=>$origin));

            if(!empty($origin_data)){

                $origin_name = $origin_data->name;

            }

            $options['origin_id'] = $origin;

        }else{

            $origin = $this->db->escape_str($this->input->get('origin', TRUE));

            $this->phpsession->save('origin', $origin);

        }

        if($style){

            $style_data = $this->products_style_model->get_products_style(array('id'=>$style));

            if(!empty($style_data)){

                $style_name = $style_data->name;

            }

            $options['style_id'] = $style;

        }else{

            $style = $this->db->escape_str($this->input->get('style', TRUE));

            $this->phpsession->save('style', $style);

        }

        

        $price_arr = explode('-', $price);

        if (empty($price_arr[0])) {

            $options['price_start'] = 0;

        } else {

            $options['price_start'] = $price_arr[0];

        }

        if (empty($price_arr[1])) {

            $options['price_end'] = 0;

        } else {

            $options['price_end'] = $price_arr[1];

        }



        // exist $cats or not

        //$cats = $this->products_categories_model->get_categories(array('parent_id'=>$options['cat_id'],'status'=>$options['status']));



        $config = get_cache('configurations_' .  $options['lang']);

        

        $cats = NULL;

        if(empty($cats)){

            $products_per_page   = $config['products_per_page'] <> 0 ? $config['products_per_page'] : PRODUCTS_PER_PAGE;



            $total_row          = $this->products_model->get_products_count($options);

            $total_pages        = (int)($total_row / $products_per_page);



            if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){

                $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);

                $uri_segment = 3;

                if($options['cat_id'] > 0){

                    $current_menu = '/' . $this->uri->segment(2);

                }else{

                    $current_menu = '/' . $options['lang'] . '/' . $this->uri->segment(2);

                }

            }else{

                $base_url = site_url().$this->uri->segment(1);

                $uri_segment = 2;

                $current_menu = '/' . $this->uri->segment(1);

            }



            $paging_config = array(

                'base_url'          => $base_url,

                'total_rows'        => $total_row,

                'per_page'          => $products_per_page,

                'uri_segment'       => $uri_segment,

                'use_page_numbers'  => TRUE,

                'first_link'        => __('IP_paging_first'),

                'last_link'         => __('IP_paging_last'),

                'num_links'         => 1,

            );



            $this->pagination->initialize($paging_config);

            $options['offset'] = ($options['page']>0)?($options['page']-1) * $paging_config['per_page']:0;

            $options['limit']   = $paging_config['per_page'];



            $products = $this->products_model->get_products($options);



            if($options['cat_id'] <> 0){

                $category = $this->products_categories_model->get_categories(array('id'=>$options['cat_id']));

                $category_slug = isset($category->slug)?$category->slug:'';

                $title = (isset($category->meta_title) && $category->meta_title <> '')?$category->meta_title:$category->category;

                $keywords = (isset($category->meta_keywords) && $category->meta_keywords <> '')?$category->meta_keywords:$category->category;

                $description = (isset($category->meta_description) && $category->meta_description <> '')?$category->meta_description:$category->summary;

                $_category = (isset($category->category) && $category->category <> '')?$category->category:__('IP_products');

                $_category_id = (isset($category->id) && $category->id <> '')?$category->id:0;

                

                $parent_category = $this->products_categories_model->get_categories(array('id'=>$category->parent_id));

                $_parent_category_slug = isset($parent_category->slug)?$parent_category->slug:'';

                $_parent_category = (isset($parent_category->category) && $parent_category->category <> '')?$parent_category->category:__('IP_products');

                $_parent_category_id = (isset($parent_category->id) && $parent_category->id <> '')?$parent_category->id:0;

            }elseif($options['new'] == STATUS_ACTIVE){

                $title = "Sản phẩm mới";

                $keywords = "Sản phẩm mới";

                $description = "Sản phẩm mới";

                $_category = "Sản phẩm mới";

                $_category_id = 0;

                $_parent_category_slug = 'san-pham-moi';

            }elseif($options['top_seller'] == STATUS_ACTIVE){

                $title = "Sản phẩm bán chạy";

                $keywords = "Sản phẩm bán chạy";

                $description = "Sản phẩm bán chạy";

                $_category = "Sản phẩm bán chạy";

                $_category_id = 0;

                $_parent_category_slug = 'san-pham-ban-chay';

            }elseif($options['saleoff'] == STATUS_ACTIVE){

                $title = "Sản phẩm giảm giá";

                $keywords = "Sản phẩm giảm giá";

                $description = "Sản phẩm giảm giá";

                $_category = "Sản phẩm giảm giá";

                $_category_id = 0;

                $_parent_category_slug = 'san-pham-giam-gia';

            }else{

                $title = __('IP_products');

                $keywords = __('IP_products');

                $description = __('IP_products');

                $_category = __('IP_products');

                $_category_id = 0;

                $_parent_category_slug = 'san-pham';

            }



            $view_data = array(

                'products'      => $products,

                'category'      => $_category,

                'category_slug' => isset($category_slug)?$category_slug:'',

                'category_id'   => $_category_id,

                'parent_category_slug' => isset($_parent_category_slug)?$_parent_category_slug:'',

                'parent_category' => isset($_parent_category)?$_parent_category:__('IP_products'),

                'parent_category_id' => isset($_parent_category_id)?$_parent_category_id:0,

                'title'         => $title,

                'keywords'      => $keywords,

                'description'   => $description,

                'current_menu'  => $current_menu,

                'active_menu'   => get_uri_by_lang(DEFAULT_LANGUAGE,'products'),

                'lang'          => $options['lang'],

//                'is_one_col'    => TRUE,

                'filter'        => TRUE,

                'sortby'        => TRUE,

                'sortby_value'  => $sortby,

                'price'         => $price,

                'price_start'   => $options['price_start'],

                'price_end'     => $options['price_end'],

                'size'          => $size,

                'size_name'     => $size_name,

                'color'         => $color,

                'color_name'    => $color_name,

                'trademark'     => $trademark,

                'trademark_name'=> $trademark_name,

                'origin'        => $origin,

                'origin_name'   => $origin_name,

                'material'      => $material,

                'material_name' => $material_name,

                'style'         => $style,

                'style_name'    => $style_name,

                'total_row'     => $total_row,

            );

            

            $this->_view_data['main_content'] = $this->load->view('products',$view_data, TRUE);



            $this->load->view($this->_layout, $this->_view_data, FALSE);

        }else{

                        

            $cats = $this->products_categories_model->get_categories(array('parent_id'=>$options['cat_id'],'status'=>$options['status']));



            if($options['cat_id'] <> 0){

                $category = $this->products_categories_model->get_categories(array('id'=>$options['cat_id']));

                $title = ($category->meta_title <> '')?$category->meta_title:$category->category;

                $keywords = ($category->meta_keywords <> '')?$category->meta_keywords:$category->category;

                $description = ($category->meta_description <> '')?$category->meta_description:$category->summary;

                if(SLUG_ACTIVE==0){

                    $active_menu = get_base_url() . url_title(trim($category->category), 'dash', TRUE) . '-p' . $category->id;

                }else{

                    $active_menu = get_base_url() . $category->slug;

                }

                        

            }else{

                $title = __('IP_products');

                $keywords = __('IP_products');

                $description = __('IP_products');

                $active_menu = get_uri_by_lang(DEFAULT_LANGUAGE,'products');

            }

            

            if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){

                $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);

                if($options['cat_id'] > 0){

                    $current_menu = '/' . $this->uri->segment(2);

                }else{

                    $current_menu = '/' . $options['lang'] . '/' . $this->uri->segment(2);

                }

            }else{

                $base_url = site_url().$this->uri->segment(1);

                $current_menu = '/' . $this->uri->segment(1);

                $view_data = array(

                    'cats'          => $cats,

                    'title'         => $title,

                    'keywords'      => $keywords,

                    'description'   => $description,

                    'current_menu'  => $current_menu,

                    'active_menu'   => $active_menu,

                    'lang'          => $options['lang'],

                );

                

                $this->_view_data['main_content'] = $this->load->view('products_cats',$view_data, TRUE);



                $this->load->view($this->_layout, $this->_view_data, FALSE);

            }

            

//            $products_per_page = $config['products_side_per_page'] <> 0 ? $config['products_side_per_page'] : PRODUCTS_PER_INDEX;

//            

//            $cats = $this->products_categories_model->get_categories(array('parent_id'=>$options['cat_id']));

//            

//            foreach($cats as $key => $value){

//                $arr[] = array(

//                    'id'=>$value->id,

//                    'category'=>$value->category,

//                    'category_slug' => isset($value->slug)?$value->slug:'',

//                    'thumbnail' => $value->thumbnail,

//                    'summary' => $value->summary,

//                    'content' => $value->content,

//                    'products'=>$this->products_model->get_products(array('cat_id'=>$value->id,'lang'=>$options['lang'],'limit'=>$products_per_page,'status'=>STATUS_ACTIVE,'random'=>TRUE)),

//                );

//            }

//

//            if($options['cat_id'] <> 0){

//                $category = $this->products_categories_model->get_categories(array('id'=>$options['cat_id']));

//                $title = ($category->meta_title <> '')?$category->meta_title:$category->category;

//                $keywords = ($category->meta_keywords <> '')?$category->meta_keywords:$category->category;

//                $description = ($category->meta_description <> '')?$category->meta_description:$category->summary;

//            }else{

//                $title = __('IP_products');

//                $keywords = __('IP_products');

//                $description = __('IP_products');

//            }

//            

//            if((!empty($options['lang']) && $options['lang'] <> DEFAULT_LANGUAGE) || $this->uri->segment(1) == DEFAULT_LANGUAGE){

//                $base_url = site_url() . $options['lang'] . '/' . $this->uri->segment(2);

////                $uri_segment = 3;

//                if($options['cat_id'] > 0){

//                    $current_menu = '/' . $this->uri->segment(2);

//                }else{

//                    $current_menu = '/' . $options['lang'] . '/' . $this->uri->segment(2);

//                }

//            }else{

//                $base_url = site_url().$this->uri->segment(1);

////                $uri_segment = 2;

//                $current_menu = '/' . $this->uri->segment(1);

//            

//            

//                $view_data = array(

//                    'results'       => $arr,

//                    'category'      => (!empty($category->category))?$category->category:__('IP_products'),

//                    'category_slug' => (!empty($category->slug))?$category->slug:'',

//                    'category_id'   => (!empty($category->category))?$category->id:0,

//                    'title'         => $title,

//                    'keywords'      => $keywords,

//                    'description'   => $description,

//                    'current_menu'  => $current_menu,

//                    'active_menu'   => get_uri_by_lang(DEFAULT_LANGUAGE,'products'),

//                    'lang'          => $options['lang'],

//                );

//                

//                $this->_view_data['main_content'] = $this->load->view('products_main',$view_data, TRUE);

//

//                $this->load->view($this->_layout, $this->_view_data, FALSE);

//            }

        }

    }

    

    public function get_products_detail($para1=NULL, $para2=NULL)

    {

        $options = array('id'=>$para1);

        

        $lang = switch_language($para2);

        

        $this->products_model->update_products_view($options['id']);

        

        $product = $this->products_model->get_products($options);



        if(!empty($product)){

            $products_same = $this->get_list_products_same(array('cat_id'=>$product->cat_id,'current_id'=>$options['id']));

            $products_images = $this->products_images_model->get_images(array('product_id'=>$options['id']));

            $category = $this->products_categories_model->get_categories(array('id'=>$product->cat_id));

            if(!empty($category)){

                $category_slug = isset($category->slug)?$category->slug:'';

                $parent_category = $this->products_categories_model->get_categories(array('id'=>$category->parent_id));

                $_parent_category = (isset($parent_category->category) && $parent_category->category <> '')?$parent_category->category:__('IP_products');

                $_parent_category_id = (isset($parent_category->id) && $parent_category->id <> '')?$parent_category->id:0;

                $_parent_category_slug = (isset($parent_category->slug) && $parent_category->slug <> '')?$parent_category->slug:'';

            }else{

                $category_slug = '';

                $_parent_category = NULL;

                $_parent_category_id = NULL;

                $_parent_category_slug = NULL;

            }



            $view_data = array(

                'product'       => $product,

                'category'      => $product->category,

                'category_slug' => $category_slug,

                'category_id'   => $product->cat_id,

                'parent_category' => $_parent_category,

                'parent_category_id' => $_parent_category_id,

                'parent_category_slug' => $_parent_category_slug,

                'title'         => ($product->meta_title <> '')?$product->meta_title:$product->product_name,

                'keywords'      => ($product->meta_keywords <> '')?$product->meta_keywords:$product->product_name,

                'description'   => ($product->meta_description <> '')?$product->meta_description:$product->summary,

                'current_menu'  => '/'.url_title($product->category, 'dash', TRUE) . '-p' .$product->categories_id,

                'scripts'       => $this->scripts_for_detail(),

                'tags'          => convert_tags_to_array($product->tags),

                'products_same' => $products_same,

                'products_images' => $products_images,

                'active_menu'   => get_uri_by_lang(DEFAULT_LANGUAGE,'products'),

                'lang'          => $lang,

                // 'is_full_col'   => TRUE,

            );

        }else{

            $view_data = NULL;

        }



        $this->_view_data['main_content'] = $this->load->view('products_detail',$view_data, TRUE);



        $this->load->view($this->_layout, $this->_view_data, FALSE);

        

    }

    

    public function get_products_demo($para1=NULL, $para2=DEFAULT_LANGUAGE)

    {

        $options = array('id'=>$para1,'lang'=>switch_language($para2));

        $product = $this->products_model->get_products($options);

        if(!empty($product)){

            $view_data = array(

                'product' => $product,

            );

        }else{

            $view_data = NULL;

        }

        $this->_view_data['main_content'] = $this->load->view('products_demo',$view_data, TRUE);

        $this->load->view('layout/demo_layout', $this->_view_data, FALSE);

    }

    

    public function get_list_products_topview(){

        $config         = get_cache('configurations_' .  get_language());

        $products_per_page   = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_PAGE;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'lang'=>$this->_lang,'topview'=>TRUE);

        

        $products = $this->products_model->get_products($options);



        $view_data = array(

            'products'      => $products,

            'category' => __('IP_products_topview'),

        );



        return $this->_view_data['main_content'] = $this->load->view('products_list_home',$view_data, TRUE);



    }

    

    public function get_list_products_topbuy(){

        $config         = get_cache('configurations_' .  get_language());

        $products_per_page   = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_PAGE;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'lang'=>$this->_lang,'topbuy'=>TRUE);



        $products = $this->products_model->get_products($options);



        $view_data = array(

            'products'      => $products,

            'category' => __('IP_products_topbuy'),

        );



        return $this->_view_data['main_content'] = $this->load->view('products_list_home',$view_data, TRUE);



    }

    

    public function get_list_products_lastest(){

        $config         = get_cache('configurations_' .  get_language());

        $products_per_page   = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_PAGE;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'lang'=>$this->_lang);

        $products = $this->products_model->get_products($options);

        $view_data = array(

            'products'      => $products,

            'category' => __('IP_products_last'),

        );

        return $this->load->view('products_home',$view_data, TRUE);

    }

    

    public function get_list_products_top(){

        $config         = get_cache('configurations_' .  get_language());

        $products_per_page   = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_PAGE;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'lang'=>$this->_lang,'home'=>TRUE);

        $products = $this->products_model->get_products($options);

        $view_data = array(

            'products'      => $products,

            'category' => __('IP_products_top'),

        );

        return $this->load->view('products_home',$view_data, TRUE);

    }

    

    

    public function get_list_products_side(){

        $config = get_cache('configurations_' .  get_language());

        $products_per_page = $config['number_products_per_side'] <> 0 ? $config['number_products_per_side'] : PRODUCTS_PER_SIDE;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'lang'=>$this->_lang,'random'=>TRUE);

        $products = $this->products_model->get_products($options);

        return $products;

    }

    

    /**

     * san pham hien tren trang chu

     * @return type

     */

    public function get_list_products_home($options=array()){

        $config = get_cache('configurations_' .  get_language());

        $products_per_page = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_HOME;

        $options['status'] = STATUS_ACTIVE;

        $options['limit'] = $products_per_page;

        $options['lang'] = $this->_lang;

        $products = $this->products_model->get_products($options);

        return $products;

    }

    public function get_list_products_typical(){

        $config = get_cache('configurations_' .  get_language());

        $products_per_page = $config['number_products_per_home'] <> 0 ? $config['number_products_per_home'] : PRODUCTS_PER_TYPICAL;

        $options = array('status'=>STATUS_ACTIVE,'limit'=>$products_per_page,'home'=>STATUS_ACTIVE,'lang'=>$this->_lang);

        $products = $this->products_model->get_products($options);

        return $products;

    }

    public function get_list_products_same($options=array())

    {

        $options['status'] = STATUS_ACTIVE;

        $options['lang'] = $this->_lang;

        

        $cat_array = $this->products_model->sql_get_by_cat($options['cat_id']);

        $cat_array .= $options['cat_id'];

        $options['cat_array'] = @explode(',', $cat_array);

        

        $products1 = $this->products_model->get_products(array('sort_by_id_high'=>TRUE,'cat_array'=>$options['cat_array'],'current_id'=>$options['current_id'],'limit'=>PRODUCTS_PER_RELATED,'lang'=>$options['lang'],'status'=>$options['status']));

        $products2 = $this->products_model->get_products(array('sort_by_id_low'=>TRUE,'cat_array'=>$options['cat_array'],'current_id'=>$options['current_id'],'limit'=>PRODUCTS_PER_RELATED,'lang'=>$options['lang'],'status'=>$options['status']));

        if (!empty($products1) && !empty($products2)) {

            $products = array_merge($products1, $products2);

        } elseif (!empty($products1) && empty($products2)) {

            $products = $products1;

        } elseif (empty($products1) && !empty($products2)) {

            $products = $products2;

        } else {

            $products = NULL;

        }

        $view_data = array(

            'products' => $products,

            'category' => __('IP_products_similar'),

        );

        return $this->load->view('products_same', $view_data, TRUE);

    }

    

    public function get_side_products()

    {

        $config = get_cache('configurations_' .  get_language());

        $page_param = $config['number_products_per_side'] != 0 ? $config['number_products_per_side'] : PRODUCTS_PER_SIDE;

        $options = array(

            'status' => STATUS_ACTIVE,

            'lang' => $this->_lang,

            'limit' => $page_param,

        );

        $products = $this->products_model->get_products($options);

        return $products;

    }

    

    private function scripts_for_detail()

    {

        $scripts = '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';

        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';

        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-buttons?v=2.1.5"></script>';

        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-buttons?v=2.1.5" media="screen" />';

        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-media?v=2.1.5"></script>';

        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-thumbs?v=2.1.5"></script>';

        $scripts .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/fancybox/source/helpers/jquery.fancybox-thumbs?v=2.1.5" media="screen" />';

        $scripts .= '<script type="text/javascript" src="'.base_url().'plugins/html5gallery/html5gallery.js"></script>';

        return $scripts;

    }



    public function get_categories_combo()

    {

        $categories_combo = $this->products_categories_model->get_categories_combo(array('combo_name' => 'categories_id', 'is_none' => TRUE, 'extra' => 'class="selectpicker show-menu-arrow" data-style="btn-inverse"'));

        return $categories_combo;

    }

    

    public function get_categories_home()

    {

        $data = $this->products_categories_model->get_categories(array('home'=>TRUE));

        return $data;

    }

    

    public function get_products_categories($options=array())

    {

        $options['lang'] = $this->_lang;

        $data = $this->products_categories_model->get_left_categories($options);

        return $data;

    }

    

    public function get_trademark_combo()

    {

        $trademark_combo = $this->products_trademark_model->get_products_trademark_combo(array('combo_name'=>'trademark','is_search'=>TRUE,'extra'=>'style="display:none;"'));

        return $trademark_combo; 

    }

    

    public function get_colors($data=array())

    {

        $colors = array();

        if(!empty($data)){

            foreach($data as $key => $value){

                if(!empty($value)){

                    $products_color = $this->products_color_model->get_products_color(array('id'=>$value));

                    $colors[$products_color->code] = $products_color->name;

                }

            }

        }

        return $colors;

    }

    

    public function get_size($data=array())

    {

        $size = array();

        if(!empty($data)){

            foreach($data as $key => $value){

                if(!empty($value)){

                    $products_size = $this->products_size_model->get_products_size(array('id'=>$value));

                    $size[] = $products_size->name;

                }

            }

        }

        return $size;

    }

    

    public function products_sort_by()

    {

        if($this->is_postback()){

            $sortby = $this->db->escape_str($this->input->post('sortby', TRUE));

            $this->phpsession->save('sortby', $sortby);

        }else{

            $this->phpsession->save('sortby', '');

        }

    }

    

    public function products_filter_clear()

    {

        $filter_attr = $this->db->escape_str($this->input->post('filter_attr', TRUE));

        $this->phpsession->save($filter_attr, '');

    }

    

    public function products_filter()

    {

        if($this->is_postback()){

            $filter_attr = $this->db->escape_str($this->input->post('filter_attr', TRUE));

            $filter_val = $this->db->escape_str($this->input->post('filter_val', TRUE));

            $this->phpsession->save($filter_attr, $filter_val);

        }else{

            $this->phpsession->save($filter_attr, '');

        }

    }

    

    public function get_products_filter($options=array())

    {

        $price = $this->phpsession->get('price');

        $size = $this->phpsession->get('size');

        $color = $this->phpsession->get('color');

        $trademark = $this->phpsession->get('trademark');

        $material = $this->phpsession->get('material');

        $origin = $this->phpsession->get('origin');

        $style = $this->phpsession->get('style');

        

        if(empty($price)){

            $price = $this->db->escape_str($this->input->get('price', TRUE));

            $this->phpsession->save('price', $price);

        }

        if($size){

            $options['size'] = $size;

        }else{

            $size = $this->db->escape_str($this->input->get('size', TRUE));

            $this->phpsession->save('size', $size);

        }

        if($color){

            $options['colors'] = $color;

        }else{

            $color = $this->db->escape_str($this->input->get('color', TRUE));

            $this->phpsession->save('color', $color);

        }

        if($trademark){

            $options['trademark_id'] = $trademark;

        }else{

            $trademark = $this->db->escape_str($this->input->get('trademark', TRUE));

            $this->phpsession->save('trademark', $trademark);

        }

        if($material){

            $options['material_id'] = $material;

        }else{

            $material = $this->db->escape_str($this->input->get('material', TRUE));

            $this->phpsession->save('material', $material);

        }

        if($origin){

            $options['origin_id'] = $origin;

        }else{

            $origin = $this->db->escape_str($this->input->get('origin', TRUE));

            $this->phpsession->save('origin', $origin);

        }

        if($style){

            $options['style_id'] = $style;

        }else{

            $style = $this->db->escape_str($this->input->get('style', TRUE));

            $this->phpsession->save('style', $style);

        }

        

        $price_arr = explode('-', $price);

        if (empty($price_arr[0])) {

            $options['price_start'] = 0;

        } else {

            $options['price_start'] = $price_arr[0];

        }

        if (empty($price_arr[1])) {

            $options['price_end'] = NULL;

        } else {

            $options['price_end'] = $price_arr[1];

        }



        $data = $this->products_model->products_filter_group($options);

        return $data;

    }

    

    

}



?>

