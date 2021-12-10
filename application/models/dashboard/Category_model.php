<?php
class Category_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Categories List
    function get_categories($table){
        $q = $this->db->query("Select $table.*
								FROM $table
								ORDER BY category_order ASC;");
        return $q;
    }


    //============================ Main Categories List
    function get_main_categories($table){
        $active = 1;
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE category_parent_id = '0' AND category_status = $active
								ORDER BY category_order ASC;");
        return $q;
    }


	//============================ Main Categories Limit
	function get_main_categories_limit($table, $limit){
		$active = 1;
		$q = $this->db->query("Select $table.*
								FROM $table
								WHERE category_parent_id = '0' AND category_status = $active
								ORDER BY category_order ASC
								LIMIT $limit;");
		return $q;
	}


    //============================ Sub Categories List
    function get_sub_categories($table, $category_parent_id){
        $active = 1;
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE category_parent_id = $category_parent_id AND category_status = $active
								ORDER BY category_order ASC;");
        return $q;
    }


    //============================ Fetch categories
    function fetch_categories($table, $category_parent_id){
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE (category_parent_id = $category_parent_id)
								ORDER BY category_id DESC;");
        return $q;
    }


    //============================ Get category image with slider_id
    function get_category_image($table, $category_id){
        $this->db->select('category_image');
        $query = $this->db->get_where($table, array('category_id'=>$category_id));
        return $query->result()[0];
    }


    //============================ Get category content with category_id
    function get_category_content($table, $category_id){
        $query = $this->db->query("Select $table.*
								FROM $table
								WHERE category_id = $category_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

}
