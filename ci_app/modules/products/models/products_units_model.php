<?php
class Products_Units_Model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        //table name khac class model
        $this->table_name = 'units';
    }

    private function _set_where_conditions( $options = array() )
    {
        if( isset( $options['id'] ) )
            $this->db->where( array( 'id' => $options['id'] ) );
    }
    
    function get_units( $options = array() )
    {

        $this->_set_where_conditions( $options );

        if( isset( $options['order_by'] ) ) {
            $this->db->order_by( $options['order_by'] );
        } else {
            $this->db->order_by( 'name');
        }
        
        $query = $this->db->get( 'units' );
        
        if($query->num_rows() > 0){
            if( isset( $options['id'] ) )
                return $query->row(0);

            if( isset( $options['array'] ) )
                return $query->result_array();

            return $query->result();
        }else{
            return NULL;
        }
        
    }
    
    function get_max_unit_position()
    {
        $this->db->select_max("position");
        $query = $this->db->get('units');
        
        $result = $query->row();
        
        if (is_object($result))
            return $result->position + 1;
        else
            return 1;
    }
    
    function add_unit( $data = array() )
    {
        $data['position'] = $this->get_max_unit_position();
        $this->db->insert( 'units', $data);
        return $this->db->insert_id();
    }
      
    function update_unit( $data = array() )
    {
        if ( isset( $data['id'] ) )
        {
            $this->db->where( 'id', $data['id'] );
            $this->db->update( 'units', $data );
        }
    }
    
    function delete_unit( $id = 0)
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'units' );
    }
    
    public function get_units_combo( $options = array() )
    {
        // Default categories name
        if ( ! isset( $options['combo_name'] ) )
        {
            $options['combo_name'] = 'units';
        }

        if ( ! isset( $options['extra'] ) )
        {
            $options['extra'] = '';
        }

        if ( isset( $options['ALL'] ) )
            $units[DEFAULT_COMBO_VALUE] = 'Tất cả';
        else
            $units[DEFAULT_COMBO_VALUE] = 'Chọn đơn vị';
        $data = array();
        $data = $this->get_units( $options + array( 'array' => TRUE ) );
        if(isset($data)){
            foreach($data as $key => $unit)
            {
                $units[$unit['id']] = $unit['name'];
            }

            if ( ! isset( $options[$options['combo_name']] ) ) 
                $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;

            return form_dropdown( $options['combo_name'], $units, $options[$options['combo_name']], $options['extra'] );
        }else{
            return NULL;
        }
        
    }
}
?>