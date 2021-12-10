<?php
class Slider_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Sliders List
    function get_sliders($table){
        $q = $this->db->query("Select $table.*, content_table.content_title
								FROM $table
								INNER JOIN content_table
                                ON $table.slider_content_id = content_table.content_id
								ORDER BY slider_id DESC;");
        return $q;
    }


    //============================ Get slider image with slider_id
    function get_slider_image($table, $slider_id){
        $this->db->select('slider_image');
        $query = $this->db->get_where($table, array('slider_id'=>$slider_id));
        return $query->result()[0];
    }


    //============================ Get slider content with slider_id
    function get_slider_content($table, $slider_id)
    {
        $query = $this->db->query("Select $table.*
								FROM $table
								WHERE slider_id = $slider_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
}