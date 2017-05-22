<?php
class City_Model extends CI_Model
{
    function  __construct() {
        parent::__construct();
    }



    public function get_city($options = array())
    {
        if (isset($options['id']))
            $this->db->where('id', $options['id']);
        if(isset($options['parent_id']))
            $this->db->where('parent_id', $options['parent_id']);

        if (isset($options['order']))
            $this->db->order_by($options['order']);
        else
            $this->db->order_by('id');
        $query = $this->db->get('cities');

        if (isset($options['id']))
            return $query->row(0);

        return $query->result();
    }

    /**
     * Lay 1 model rieng biet dua tren id duoc cung cap
     *
     * @param <type> $options
     * @return <type>
     */
    public function get_city_by_id($options = array())
    {
        if (!isset($options['id'])) return NULL;

        return $this->get_city($options);
    }

    public function get_city_name_by_id($options = array())
    {
        $city = $this->get_city_by_id($options);

        if ($city != NULL) return $city->city;

        return '';
    }


    public function get_city_combo($options = array())
    {

        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'city';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $cities = $this->get_city($options);
        $data_options   = array();

        $data_options[DEFAULT_COMBO_VALUE] = '-Thành phố-';
        foreach($cities as $city)
        {
            $data_options[$city->id] = $city->city;
        }

        if ( ! isset($options[$options['combo_name']]))
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }

    public function get_district_combo($options = array())
    {
        // Default name
        if ( ! isset($options['combo_name']))
        {
            $options['combo_name'] = 'district';
        }

        if ( ! isset($options['extra']))
        {
            $options['extra'] = '';
        }

        $data_options   = array();

        $data_options[DEFAULT_COMBO_VALUE] = '-Quận Huyện-';
        if (isset($options['parent_id']) && $options['parent_id'] != DEFAULT_COMBO_VALUE && $options['parent_id'] != '')
        {
            $districts      = $this->get_city($options);
            foreach($districts as $district)
            {
                $data_options[$district->id] = $district->city;
            }
            $data_options[940] = 'Khác';
        }
        if ( ! isset($options[$options['combo_name']]))
        {
            $options[$options['combo_name']] = DEFAULT_COMBO_VALUE;
        }
        return form_dropdown($options['combo_name'], $data_options, $options[$options['combo_name']], $options['extra']);
    }

    /**
     * Trả lại một mảng chứa tên các thành phố với index là mã thành phố
     *
     * @date    2011-04-15
     * @param type $paras
     * @return type
     */
    function get_cities_array($paras = array())
    {
        $cities = $this->get_city($paras);
        $output = array();
        $output[DEFAULT_COMBO_VALUE] = '';
        foreach($cities as $city)
        {
            $output[$city->id] = $city->city;
        }
        return $output;
    }
}
?>