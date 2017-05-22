<?php
class Download_Model extends MY_Model
{
    function __construct()
    {
            parent::__construct();
    }
    
    public function get_download($options = array())
    {
        if(SLUG_ACTIVE==0){
            $this->db->select('download.*,
                                download_categories.title as category,
                                download_categories.parent_id as parent_id,
                         ');
             $this->db->join('download_categories', 'download_categories.id = download.type', 'left');
        }else{
            $this->db->select('download.*,
                                download_categories.title as category,
                                download_categories.parent_id as parent_id,
                                slug.slug,
                                slug.id slug_id,
                         ');
             $this->db->join('download_categories', 'download_categories.id = download.type', 'left');
             $this->db->join('slug', 'slug.type_id = download.id AND ' . $this->db->dbprefix . 'slug.type ='.SLUG_TYPE_DOWNLOAD, 'left');
        }
        
        if (isset($options['id']))
            $this->db->where('download.id', $options['id']);
        
        if (isset($options['status']))
            $this->db->where('download.status', $options['status']);
        
        if (isset($options['type']) && $options['type'] != DEFAULT_COMBO_VALUE && $options['type'] != ROOT_CATEGORY_ID && $options['type'] != '')
            $this->db->where('('.$this->db->dbprefix.'download.type = ' . $options['type'] . ' OR parent_id = ' . $options['type'] . ')');
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('download.date desc');

        $query = $this->db->get('download');
        if($query->num_rows() > 0){
            if (isset($options['id']) || isset($options['onehit']))
                return $query->row(0);
            if(isset($options['array']))
                return $query->result_array();
            return $query->result();
        }else{
            return NULL;
        }
        
    }

    public function get_download_count($options = array())
    {
        return count($this->get_download($options));
    }
    
    public function upload_download_file($file_path = '')
    {
        if(!empty($file_path))
        {
            $config['upload_path'] = $file_path;
        }else
        {
            $config['upload_path'] = UPLOAD_PATH_FILES;
        }

        $config['allowed_types'] = '*';
        $config['max_size'] = '51200'; //50MB
        $config['encrypt_name'] = FALSE;
        $config['overwrite'] = FALSE;

        $this->load->library('upload', $config);
        $files = array();
        foreach ($_FILES as $key => $value) 
        {
            if ($this->upload->do_upload($key)) 
            {
                $files[] = $this->upload->data();
            }
            else
            {
                $error = $this->upload->display_errors();
                $this->_last_message = $error;
            }
        }
        
        foreach ($files as $a => $data_upload) 
        {
//            Array
//            (
//                [file_name]    => mypic.jpg
//                [file_type]    => image/jpeg
//                [file_path]    => /path/to/your/upload/
//                [full_path]    => /path/to/your/upload/jpg.jpg
//                [raw_name]     => mypic
//                [orig_name]    => mypic.jpg
//                [client_name]  => mypic.jpg
//                [file_ext]     => .jpg
//                [file_size]    => 22.2
//                [is_image]     => 1
//                [image_width]  => 800
//                [image_height] => 600
//                [image_type]   => jpeg
//                [image_size_str] => width="800" height="200"
//            )
            
            
            // Save to database
            $data = array(
                'title' => $data_upload['raw_name'],
                'size' => byte_format($data_upload['file_size']*1024),
                'ext' => $data_upload['file_ext'],
                'name' => $data_upload['file_name'],
                'url' => $config['upload_path'] . $data_upload['file_name'],
                'date' => now(),
//                'type' => 1,
                'status' => STATUS_INACTIVE,
                'creator' => $this->phpsession->get('user_id'),
            );
            $this->insert($data);
        }
        
        sleep(1);
    }
    
    public function download_delete_file($id = 0, $path = '')
    {
        $file = $this->get_download(array('id' => $id));
        if (is_object($file))
        {
            if (file_exists($path . $file->name))
                unlink($path . $file->name);

            // xoa trong db
            $this->delete(array('id'=>$id));
        }
        return NULL;
    }
    
}