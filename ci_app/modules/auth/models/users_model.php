<?php
class Users_Model extends MY_Model
{
    function  __construct()
    {
        parent::__construct();
    }

    private function _set_where_conditions($params = array())
    {
        if (isset($params['roles_id']))
            $this->db->where('users.roles_id', $params['roles_id']);

        if (isset($params['user_id']))
            $this->db->where('users.id', $params['user_id']);
        
        if (isset($params['id']))
            $this->db->where('users.id', $params['id']);

        if (isset($params['username']))
            $this->db->where('users.username', $params['username']);

        if (isset($params['email']))
            $this->db->where('users.email', $params['email']);
        
        if (isset($params['tel']))
            $this->db->where('users.tel', $params['tel']);

        if (isset($params['active']) && $params['active'] != '')
            $this->db->where('users.active', $params['active']);
        
        if (isset($params['status']) && $params['status'] != '')
            $this->db->where('roles.status', $params['status']);
        
        if (isset($params['search']))
        {
            $where  = "(    fullname    like'%" . $params['search'] . "%'";
            $where .= " or  email       like'%" . $params['search'] . "%'";
            $where .= " or  address     like'%" . $params['search'] . "%'";
            $where .= " or  tel         like'%" . $params['search'] . "%'";
            $where .= " or  username    like'%" . $params['search'] . "%')";
            $this->db->where($where);
        }
    }

    function get_users($params = array())
    {
        $this->db->select('users.*,
                        roles.name roles_name,
                        roles.roles roles_roles,
                        roles.publisher roles_publisher,
                    ');
            $this->db->join('roles', 'roles.id = users.role_id', 'left');
        
        $this->_set_where_conditions($params);

        if (isset($params['order']))
            $this->db->order_by($params['order']);
        else
            $this->db->order_by('id');

        if (isset($params['limit']) && isset($params['offset']))
            $this->db->limit($params['limit'], $params['offset']);
        else if (isset($params['limit']))
            $this->db->limit($params['limit']);

        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            if (isset($params['id']) || isset($params['user_id']) || isset($params['onehit']))
                return $query->row(0);
            return $query->result();
        }else{
            return NULL;
        }
 
    }
    
    public function get_users_count($options = array())
    {
        return count($this->get_users($options));
    }
    
    public function get_level_combo($options=array())
    {
        // Default categories name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'level_combobox';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $categories = array(
            DEFAULT_COMBO_VALUE => ' - Chọn',
            AUTH_LEVEL_ADMIN => AUTH_LEVEL_ADMIN_LABEL,
            AUTH_LEVEL_USER => AUTH_LEVEL_USER_LABEL,
//            AUTH_LEVEL_GUEST => AUTH_LEVEL_GUEST_LABEL,
        );

        return form_dropdown($options['combo_name'], $categories, $options[$options['combo_name']], $options['extra']);
    }
    
    /**
     * @author: Nguyen Tuan Anh
     * @date: 2014.02.20
     * 
     * Kiem tra neu user da ton tai
     * 
     * @param type $params
     *  - id
     *  - hoac username
     * @return Boolean
     */
    function is_user_existed($params = array())
    {
        if (isset($params['user_id']))
            $this->db->where('users.id', $params['user_id']);
        else if (isset($params['username']))
            $this->db->where('users.username', $params['username']);

        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) 
            return $query->row();
        return FALSE;
    }

    /**
     * Lấy một mảng các users với các chỉ số chính là user_id
     * 
     * @author Tuấn Anh
     * @date   2011-04-29
     * @param type $params
     * @return type 
     */
    function get_users_array($params = array())
    {
        $users = $this->get_users($params);
        if(isset($users)){
            $output = array();
            foreach($users as $user)
            {
                $output[$user->id] = $user->fullname;
            }
            return $output;
        }else{
            return array();
        }
        
    }

    /**
     * Lấy một combobox users
     * 
     * @author Tuấn Anh
     * @date   2011-04-29
     * @param type $params
     * @return type 
     */
    function get_users_combo($params = array())
    {
        // Default categories name
        if ( ! isset($params['combo_name']))
        {
            $params['combo_name'] = 'users';
        }

        if ( ! isset($params['extra']))
        {
            $params['extra'] = '';
        }

        $users = $this->get_users($params); // added options 2011-03-11

        if(!isset($users)) return NULL;
        else{
            $data_options = array();

            if (isset($params['ALL']))
                $data_options[DEFAULT_COMBO_VALUE] = 'Tất cả';

            foreach($users as $user)
            {
                $data_options[$user->id] = $user->alias_name;
            }

            if ( ! isset($params[$params['combo_name']]))
            {
                $params[$params['combo_name']] = DEFAULT_COMBO_VALUE;
            }
            return form_dropdown($params['combo_name'], $data_options, $params[$params['combo_name']], $params['extra']);
        }
        
    }

    /**
     * Lấy danh sách các roles có trong hệ thống
     * 
     * @author Tuấn Anh
     * @date   2011-04-29
     * @param type $params
     * @return type 
     */
    function get_roles($params = array())
    {
        return $this->db->get('role')->result();
    }

    function update_user($data = array())
    {
        if(isset ($data['id'])){
            $this->db->where('id', $data['id']);
            $this->db->update('users', $data);
        }
    }

    function is_available($params = array())
    {
        $this->db->where('username', $params['username']);
        $this->db->or_where('email', $params['email']);

        $query = $this->db->get('users');

        if (count($query->row()) > 0)
        {
            $this->_last_message = '<p>Username <strong>'. $params['username'] . '</strong> hoặc email <strong>'. $params['email'] . '</strong> đã tồn tại trong hệ thống.</p>';
            return FALSE;
        }
        return TRUE;
    }

    // check username khi đăng ký = open id
    function is_available_username($params = array())
    {
        $this->db->where('username', $params['username']);

        $query = $this->db->get('users');

        if (count($query->row()) > 0)
        {
            $this->_last_message = '<p>Username <strong>'. $params['username'] . '</strong> đã tồn tại trong hệ thống.</p>';
            return FALSE;
        }
        return TRUE;
    }

    function get_last_message()
    {
        return $this->_last_message;
    }

    function add_new_contact($data = array())
    {
        $contact_data               = array();
        $contact_data['username']   = isset($data['username']) ? $data['username'] : '';
        $contact_data['password']   = isset($data['password']) ? $data['password'] : '';
        $contact_data['active']     = isset($data['active']) ? $data['active'] : 0;

        $contact_data['fullname']       = isset($data['fullname']) ? $data['fullname'] : '';
        $contact_data['address']        = isset($data['address']) ? $data['address'] : '';
        $contact_data['email']          = isset($data['email']) ? $data['email'] : '';
        $contact_data['phone1']         = isset($data['phone1']) ? $data['phone1'] : '';
        $contact_data['phone2']         = isset($data['phone2']) ? $data['phone2'] : '';
        $contact_data['DOB']            = isset($data['DOB']) ? $data['DOB'] : '';
        $contact_data['cities_id']      = isset($data['cities_id']) ? $data['cities_id'] : 1;
        $contact_data['joined_date']    = isset($data['joined_date']) ? $data['joined_date'] : '';
        $contact_data['roles_id']       = isset($data['roles_id']) ? $data['roles_id'] : '';
        $this->db->insert('users', $contact_data);
        return $this->db->insert_id();
    }

    function get_users_activites_array($params = array())
    {
        if(isset ($params['activities']) && $params['activities'] != NULL)
        {

            $user_id = '';
            foreach($params['activities'] as $activity)
            {
                $match = get_user_id_product_id_from_message($activity->message);
                if(isset ($match[1]))
                {
                    $u_id = $match[1];
                    if($user_id == '')
                        $user_id .= $u_id;
                    else
                        $user_id .= ', '. $u_id;
                }
            }
            $this->db->where('id in ('.$user_id.')');
        }

        $query = $this->db->get('users');
        if($query->num_rows() > 0){
            $users = $query->result();
            $output = array();
            foreach($users as $user)
            {
                $output[$user->id] = $user;
            }
            return $output;
        }else{
            return array();
        }

    }

    function upload_avatar($user_id = 0, $image_path = '')
    {
            $image_type = '';
            $thumb_size = 40;
            $config['upload_path']  = './images/uploads/';

            $config['allowed_types']= 'gif|jpg|png';
            $config['max_size']     = '1024';
            $config['encrypt_name'] = TRUE;
            $image_file_name        = $user_id . dechex((int)date('His'));

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload() )
            {
                $error = $this->upload->display_errors();
                $this->_last_message = $error;
                return NULL;
            }
            else
            {
                $image = $this->upload->data();

                $image_file_name .= $image['file_ext'];
                
                // Thay đổi avatar trong session
                $this->phpsession->save('avatar'        , $image_file_name);

                $this->load->library('image_lib');

                // Start processing the uploaded image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './images/uploads/' . $image['file_name'];
                $config['maintain_ratio'] = TRUE;

                // 1. Create the thumbnail image
                //
                // setup the appropriate width & height
                $scale = (float)($image['image_width'] / $image['image_height']);
                $config['width'] = 180;
                $config['height'] = (int)(180 / $scale);
                $config['new_image'] =  $image_path . 'thumbnails/' . $image_file_name;
                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                $this->image_lib->clear();

                // 2. Create the small image
                //
                // setup the appropriate width & height
                $_width = $image['image_width'];
                $_height= $image['image_height'];
                if ($_width > $_height)
                {
                    // wide image
                    $config['width'] = intval(($_width / $_height) * $thumb_size);
                    if ($config['width'] % 2 != 0)
                    {
                        $config['width']++;
                    }
                    $config['height'] = $thumb_size;
                    $img_type = 'landscape';
                }
                else if ($_width < $_height)
                {
                    // landscape image
                    $config['width'] = $thumb_size;
                    $config['height'] = intval(($_height / $_width) * $thumb_size);
                    if ($config['height'] % 2 != 0)
                    {
                        $config['height']++;
                    }
                    $img_type = 'portrait';
                }
                else
                {
                    // square image
                    $config['width'] = $thumb_size;
                    $config['height'] = $thumb_size;
                    $img_type = 'square';
                }
                $config['new_image'] = $image_path . 'smalls/' . $image_file_name;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();


                $conf_new = array(
                'image_library' => 'gd2',
                'source_image' => $config['new_image'],
                'create_thumb' => FALSE,
                'maintain_ratio' => FALSE,
                'width' => $thumb_size,
                'height' => $thumb_size
                );

                if ($img_type == 'landscape')
                {
                    $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2 ;
                    $conf_new['y_axis'] = 0;
                }
                else if($img_type == 'portrait')
                {
                    $conf_new['x_axis'] = 0;
                    $conf_new['y_axis'] = 0;
                }
                else
                {
                    $conf_new['x_axis'] = 0;
                    $conf_new['y_axis'] = 0;
                }

                $this->image_lib->initialize($conf_new);

                if ( ! $this->image_lib->crop())
                {
                    echo $this->image_lib->display_errors();
                }

                $this->image_lib->clear();

                // physically delete image file
                if (file_exists('./images/uploads/' . $image['file_name']))
                    unlink('./images/uploads/' . $image['file_name']);

                // Save to database
                $data = array(
                    'id'   => $user_id,
                    'avatar'=> $image_file_name
                );
                $this->update_avatar($data);
                $this->_last_message = '';
        }
    }
    
    function update_avatar($data = array())
    {
        // update the current avatar to 0
        $this->db->where('id', $data['id']);
        $this->db->update('users', $data);
    }
}
