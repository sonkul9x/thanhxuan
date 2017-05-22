<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/*
 * Added 1/4/2014 by Dungnm
 */
class MY_Model extends CI_Model
{
    protected $table_name;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        if (!isset($this->table_name) || $this->table_name = '') {
            $this->table_name = get_Class($this);
        }
        //$this->table_name .= $this->db->dbprefix;
        $this->open();
    }
    
    public function insert($data)
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }
    
    public function update($data, $condition = array())
    {
        //update theo array $condition
        if (!empty($condition) && is_array($condition)){
            foreach ($condition as $key => $value)
                if (is_numeric($key))
                    $this->db->where($value);
                else
                    $this->db->where($key, $value);
        }else{
            //neu khong khai bao $condition thi trong $data phai co id//update theo id
            $this->db->where('id',$data['id']);
        }

        $this->db->update($this->table_name, $data);
    }

    public function delete($condition)
    {
        //delete theo array $condition
        if (!empty($condition) && is_array($condition)){
            foreach ($condition as $key => $value)
                if (is_numeric($key))
                    $this->db->where($value);
                else
                    $this->db->where($key, $value);
        }elseif(is_numeric($condition)){
            //delete theo id neu $condition = $id//number
            $this->db->where('id',$condition);
        }

        $this->db->delete($this->table_name);
    }
    
    public function count($condition=NULL)
    {
        if (!empty($condition) && is_array($condition)){
            foreach($condition as $key => $value)
                if(is_numeric($key))
                    $this->db->where($value);
                else
                    $this->db->where($key, $value);
        }else{
            //neu khong khai bao $condition: dem tat ca
            return $this->db->count_all($this->table_name);
        }
        return $this->db->count_all_results($this->table_name);
    }
    
    public function excuteQuery($sql)
    {
        $r = $this->db->query($sql);
        if (empty($r) || !is_object($r))
        {
            return NULL;
        }
        return $r->result_array();
    }
    
    private $isConnected = false;

    public function open()
    {
        if ($this->isConnected)
        {
            if (empty($this->db))
            {
                $CI = & get_instance();
                $CI->load->database();
                $this->db = $CI->db;
            }
            return;
        }
        
        $this->isConnected = true;
        $CI = & get_instance();
        if (empty($CI->db))
        {
            $CI->load->database();
            $this->db = $CI->db;
        }
        
        //class model to table name:
        $s = '_Model';
        if(strpos($this->table_name, $s)){
            //ten class model co cau truc: Tentable_Model, Ten_Table_Model
            $this->table_name = str_replace($s, '', $this->table_name);
            //ten table khong viet hoa
            $this->table_name = strtolower($this->table_name);
        }
        //$this->table_name = $this->dbprefix($this->table_name);
    }

    public function close()
    {
        if (!empty($this->db))
            $this->db->close();
        $this->isConnected = false;
    }

    public function dbprefix($table) {
        if (!$this->isConnected)
            $this->open();
        if (empty($this->db->dbprefix) || startsWith($table, $this->db->dbprefix))
            return $table;
        return $this->db->dbprefix($table);
    }

    public function beginTransaction()
    {
        $this->db->trans_begin();
    }
    
    public function finishTransaction()
    {
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
        }        
    }
    
    public function commit()
    {
        $this->db->trans_commit(); 
    }
    
    public function rollback()
    {
        $this->db->trans_rollback();
    }
    
}