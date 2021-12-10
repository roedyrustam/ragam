<?php
class Page_model extends CI_Model
{

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Pages List
    function get_pages($table)
    {
        $q = $this->db->query("Select $table.*
								FROM $table
								ORDER BY page_id DESC;");
        return $q;
    }


    //============================ Get page content with page_id
    function get_page_content($table, $page_id)
    {
        $query = $this->db->query("Select $table.*
								FROM $table
								WHERE page_id = $page_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

}