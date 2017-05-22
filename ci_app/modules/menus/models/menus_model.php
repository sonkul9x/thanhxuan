<?php

class Menus_Model extends CI_Model

{

    function __construct()

    {

        parent::__construct();

    }



    private function _set_where_conditions($options = array(), $all = FALSE)

    {

        // only get the active menu items

        if ( ! $all ) { $this->db->where('menus.active', 1);}

        

        $is_logged_in = modules::run('auth/auth/is_logged_in');

        if(!$is_logged_in)

            $this->db->where('menus.private', STATUS_INACTIVE);

        

        // get all child menus if specified

        if (isset($options['parent_id']))

            $this->db->where('menus.parent_id', $options['parent_id']);

        

        if(isset($options['footer_menu']))

        {

            $this->db->where('(menus.id in(' . $options['footer_menu'] . ') OR menus.parent_id in(' . $options['footer_menu'] . '))' );

        }

        

        if(HIDE_ADMIN_MENU > 0 && empty($options['is_cache'])){

            $this->db->where('menus.cat_id <>',BACK_END_MENU_CAT_ID);

        }

        

        if(isset($options['cat_id']) && $options['cat_id'] <> DEFAULT_COMBO_VALUE)

            $this->db->where('menus.cat_id', $options['cat_id']);

        

        if( isset($options['lang']) && !empty($options['lang']))

            $this->db->where('menus.lang', $options['lang']);

        

        if (isset($options['id']))

            $this->db->where('menus.id', $options['id']);



        if (isset($options['url_path']))

            $this->db->where('menus.url_path', $options['url_path']);

    }



    function get_menus($options = array(), $all = FALSE)

    {

        $this->db->select('menus.*

                            , menus_categories.name

                        ');

        $this->db->join('menus_categories', 'menus.cat_id = menus_categories.id', 'left');

        $this->_set_where_conditions($options, $all);



        $this->db->order_by('cat_id, parent_id, position');

        // get the result

        $query = $this->db->get('menus');

        if($query->num_rows() > 0){

            if(isset ($options['id']) || isset($options['url_path']))

                return $query->row(0);



            // return the menus records

            if(isset($options['last_row']))

                return $query->last_row();



            if(isset($options['array']))

                return $query->result_array();



            return $query->result();

        }else{

            return NULL;

        }

        

    }



    function get_menus_object_array_by_parent_id($options = array()) {

        // Nếu không truyền vào tham số của danh mục cha, thì trả về null

        if (!isset($options['parent_id']))

            return null;

        // Lấy ra tất cả các danh mục

        $menus = $this->get_menus(array('lang'=>$options['lang'],'cat_id'=>$options['cat_id']), $all = TRUE);

        $ordered_menus = array();

        $ordered_menus = $this->_visit1($menus, $options['parent_id']);

        return $ordered_menus;

    }



    function get_menus_array_by_parent_id1($options = array())

    {

        // Nếu không truyền vào tham số của danh mục cha, thì trả về null

        if (!isset($options['parent_id'])) return null;



        // Lấy ra tất cả các danh mục

        $menus = $this->get_menus();



        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...

        $ordered_menus = array();

        $ordered_menus = $this->_visit1($menus, $options['parent_id'], '');

        return $ordered_menus;

    }

    

    function get_menus_array_by_parent_id($options = array())

    {

        $cond = array();

        // Nếu không truyền vào tham số của danh mục cha, thì trả về null

        if (!isset($options['parent_id'])) return null;

        if (isset($options['lang']))

            $cond['lang'] = $options['lang'];

        else $cond['lang'] = DEFAULT_LANGUAGE;

        if (isset($options['cat_id']))

            $cond['cat_id'] = $options['cat_id'];

        else $cond['cat_id'] = FRONT_END_MENU_CAT_ID;

        // Lấy ra tất cả các danh mục

        $menus = $this->get_menus($cond);



        // Duyệt qua mảng và trả lại danh mục có thứ tự Danh mục cha > Danh mục con...

        $ordered_menus = array();

        $ordered_menus = $this->_visit($menus, $options['parent_id'], '');

        return $ordered_menus;

    }

//    

//    private function _visit1($menus = array(), $parent_id = null, $prefix = '')

//    {

//        $output         = array();

//

//        $current_menu    = $this->_get_current_menus($menus, $parent_id);

//        $sub_menus       = $this->_get_sub_menus($menus, $parent_id);

//

//        // Thăm nút hiện tại

//        if (is_object($current_menu))

//        {

////            if($parent_id == 1)

//                $output[$parent_id] = $current_menu;

//                $prefix             .= ' » ';

//

//        }

//        // Thăm tất cả các nút con

//        foreach($sub_menus as $menu)

//        {

//            $o = $this->_visit1($menus, $menu->id, $prefix);

//            foreach($o as $i => $a)

//            {

//                    $output[$i]     = $a;

//            }

//        }

//        return $output;

//    }

    

    private function _visit1($menus = array(), $parent_id = null) {

        $output = array();



        $current_menu = $this->_get_current_menus($menus, $parent_id);

        $sub_menus = $this->_get_sub_menus($menus, $parent_id);



        if (is_object($current_menu)) {

            $output[$current_menu->id] = $current_menu;

        }



        if (count($sub_menus) > 0) {

            foreach ($sub_menus as $menu) {

                $o = $this->_visit1($menus, $menu->id);

                foreach ($o as $i => $a) {

                    $output[$i] = $a;

                }

            }

        }

        return $output;

    }

    

    private function _visit($menus = array(), $parent_id = null, $prefix = '')

    {

        $output         = array();



        $current_menu    = $this->_get_current_menus($menus, $parent_id);

        $sub_menus       = $this->_get_sub_menus($menus, $parent_id);



        // Thăm nút hiện tại

        if (is_object($current_menu))

        {

//            if($parent_id == 1)

                $output[$parent_id] = $prefix . $current_menu->caption;

                $prefix             .= ' » ';



        }

        if (count($sub_menus) > 0) {

            // Thăm tất cả các nút con

            foreach($sub_menus as $menu)

            {

                $o = $this->_visit($menus, $menu->id, $prefix);

                foreach($o as $i => $a)

                {

                        $output[$i]     = $a;

                }

            }

        }

        return $output;

    }

    

    private function _get_current_menus($menus = array(), $parent_id = null)

    {

        if(isset($menus)){

            foreach($menus as $menu)

            {

                if ($menu->id == $parent_id) return $menu;

            }

        }

        return FALSE;

    }



    private function _get_sub_menus($menus = array(), $parent_id = null)

    {

        $sub_menus = array();

        if(isset($menus)){

            foreach($menus as $index => $menu)

            {

                if ($menu->parent_id == $parent_id)

                    $sub_menus[$index] = $menu;

            }

        }

        

        return $sub_menus;

    }





    public function get_menus_combo($options = array())

    {

        // Nếu không truyền vào tham số của danh mục cha, thì trả về null

        if (!isset($options['parent_id'])) $options['parent_id'] = ROOT_CATEGORY_ID;



        // Default categories name

        if ( ! isset($options['combo_name']))

        {

            $options['combo_name'] = 'navigation';

        }



        if ( ! isset($options['extra']))

        {

            $options['extra'] = '';

        }



        $menus_categories = $this->menus_categories_model->get_menus_categories();

        if(isset($menus_categories)){

            foreach($menus_categories as $mc){

                if($options['cat_id'] == $mc->id){

                    $menus[ROOT_CATEGORY_ID] = '-- '.$mc->name;

                }

            }

        }else{

            return NULL;

        }

        

        $mnus = array();

        $mnus = $this->get_menus_array_by_parent_id($options);

        if(isset($mnus)){

            foreach($mnus as $id => $mn) {

                if(isset($options['current_id']) && $options['current_id'] != '') {



                    if($id != $options['current_id'])

                        $menus[$id] = $mn;

                } else {

                    $menus[$id] = $mn;

                }

            }

            

            if (!isset($options[$options['combo_name']])) $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;



            return form_dropdown($options['combo_name'], $menus, $options[$options['combo_name']], $options['extra']);

        }else{

            return NULL;

        }

        

        

    }



    public function add_menu($data = array())

    {

        $this->db->insert('menus', $data);

        return $this->db->insert_id();

    }



    public function update_menu($data = array())

    {

        if(isset ($data['id']))

            $this->db->update('menus', $data, array('id' => $data['id']));

    }



    public function delete_menu($menu_id)

    {

        $this->db->delete('menus', array('id' => $menu_id));

    }

    

    function update_menu_active($menu_id){

        if($menu_id){

            $result = $this->db->get_where('menus', array('id' => $menu_id));

            

            if($menu = $result->row_array())

            {    

                $active = $menu['active'] == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;

                $this->db->update('menus', array('active' => $active), array('id' => $menu_id));

                $this->db->update('menus', array('active' => $active), array('parent_id' => $menu_id));

                return $active;

            }

            

            return false;

        }

        return false;

    }

    

    function get_menus_array($options = array(), $all = FALSE)

    {

        $this->db->select('menus.*');

        $this->_set_where_conditions($options, $all);

        // order by position

        $this->db->order_by('parent_id asc, position asc');

        // get the result

        $query = $this->db->get('menus');

        if($query->num_rows() > 0){

            return $query->result_array();

        }else{

            return array();

        }

        

    }

    

    public function count_menus($options = array())

    {

        if(isset($options['cat_id']))

            $this->db->where('cat_id', $options['cat_id']);

        //$rs = $this->db->get('menus');

        $rs = $this->get_menus($options);

        if(isset($rs)){

            return count($rs);

        }else{

            return 0;

        }

        

    }

    

    public function get_level_menus_category($options=array('parent_id'=>0))

    {

        $this->db->select('level');

        

        if (isset($options['parent_id']))

            $this->db->where('id', $options['parent_id']);



        $query = $this->db->get('menus');

        if($query->num_rows() > 0){

            $rs = $query->row(0);

            return $rs->level;

        } else return -1;

    }

    

    /**

     * sort

     * @param type $options

     * @return boolean|null

     */

    public function item_to_sort($options=array())

    {

        if (!isset($options['id'])) {

            return NULL;

        }

        // Lay ban ghi can up len //, 'lang'=>$options['lang']

        $this_menu = $this->get_menus(array('id'=>$options['id']), $all = TRUE); 

        // Lay ban ghi co thu tu truoc ban ghi can up len

        $pre_menu = $this->db

                    ->select('id,parent_id,level,cat_id,position,lang')

                    ->where('parent_id',$this_menu->parent_id)

                    ->where('cat_id',$this_menu->cat_id)

                    ->where('position <',$this_menu->position)

                    ->where('lang',$this_menu->lang)

                    ->order_by('position desc')

                    ->limit(1)

                    ->get('menus');

        if($pre_menu->num_rows() > 0){

            $pre_menu = $pre_menu->row(0);

            // Cap nhat lai position (doi position cho nhau)

            $this->update_menu(array('id'=>$this_menu->id,'position'=>$pre_menu->position));

            $this->update_menu(array('id'=>$pre_menu->id,'position'=>$this_menu->position));

        }else{

            $this->update_menu(array('id'=>$this_menu->id,'position'=>1));

        }

        return TRUE;

    }

    

    /*

     * lay position lon nhat trong menu, cung parent_id,cat_id

     */

    public function position_to_add($options=array())

    {

        if (!isset($options['parent_id']) || !isset($options['cat_id'])) {

            return NULL;

        }

        if (!isset($options['lang'])) {

            $options['lang'] = DEFAULT_LANGUAGE;

        }

        $menu = $this->db

                ->select('id,parent_id,level,cat_id,position')

                ->where('parent_id',$options['parent_id'])

                ->where('cat_id',$options['cat_id'])

                ->where('lang',  $options['lang'])

                ->order_by('position desc')

                ->limit(1)

                ->get('menus');

        if($menu->num_rows() > 0){

            $menu = $menu->row(0);

            $position_add = $menu->position + 1;

        }else{

            $position_add = 1;

        }

        return $position_add;

    }

    

    public function position_to_edit($options=array())

    {

        if (!isset($options['id']) || !isset($options['parent_id']) || !isset($options['cat_id'])) {

            return NULL;

        }

        if (!isset($options['lang'])) {

            $options['lang'] = DEFAULT_LANGUAGE;

        }

        $menu = $this->db

                ->select('id,parent_id,level,cat_id,position')

                ->where('parent_id',$options['parent_id'])

                ->where('cat_id',$options['cat_id'])

                ->where('lang',$options['lang'])

                ->order_by('position desc')

//                ->limit(1)

                ->get('menus');

        //Neu da ton tai id trong list thi giu nguyen position, neu chua co thi position lon nhat + 1

        if($menu->num_rows() > 0){

            $menu = $menu->result();

            $position_max = $menu[0]->position;

            foreach($menu as $key => $m){

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