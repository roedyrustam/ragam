<?php
class Content_model extends CI_Model
{

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ User role
    function get_player_type($table){
        $active = 1;
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE (player_type_status = $active)
								ORDER BY player_type_id ASC;");
        return $q;
    }


    //============================ User role
    function get_user_role($table){
        $active = 1;
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE (user_type_id = 2) AND (user_role_status = $active)
								ORDER BY user_role_id ASC;");
        return $q;
    }


    //============================ Content List
    function get_content($table, $keyword, $content_type, $content_status, $limit, $start)
    {
        $user_id = $_SESSION['user_id'];
        $where = "";
        if($keyword != "")
            $where = "WHERE content_title LIKE '%$keyword%'";
        /*if($keyword != "" AND $content_type == "")
            $where = "WHERE content_title LIKE '%$keyword%' AND $table.content_status = '$content_status'";*/
        if($keyword == "" AND $content_type != "")
            $where = "WHERE $table.content_type_id = '$content_type' AND $table.content_status = '$content_status'";
        if($content_status != "")
            $where = "WHERE $table.content_status = '$content_status'";

        if($_SESSION['user_type'] == 1)
        {
            $q = $this->db->query("Select $table.*, category_table.category_title, content_type_table.content_type_title, user_table.user_username, user_table.user_id, player_type_table.*
								FROM $table
								INNER JOIN category_table
								ON $table.content_category_id = category_table.category_id 
								INNER JOIN content_type_table
								ON $table.content_type_id = content_type_table.content_type_id 
								INNER JOIN user_table
								ON $table.content_user_id = user_table.user_id 
								INNER JOIN player_type_table
								ON $table.content_player_type_id = player_type_table.player_type_id 
								$where
								ORDER BY content_id DESC
								LIMIT $limit OFFSET $start;");

        }else{
            $q = $this->db->query("Select $table.*, category_table.category_title, content_type_table.content_type_title, user_table.user_username, user_table.user_id, player_type_table.*
								FROM $table
								INNER JOIN category_table
								ON $table.content_category_id = category_table.category_id 
								INNER JOIN content_type_table
								ON $table.content_type_id = content_type_table.content_type_id 
								INNER JOIN user_table
								ON $table.content_user_id = user_table.user_id 
								INNER JOIN player_type_table
								ON $table.content_player_type_id = player_type_table.player_type_id 
								$where AND content_user_id = $user_id
								ORDER BY content_id DESC
								LIMIT $limit OFFSET $start;");
        }

        return $q;
    }


    //============================ Content type
    function get_content_type($table)
    {
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE content_type_status = 1
								ORDER BY content_type_id ASC;");
        return $q;
    }


    //============================ Content count
    public function get_total_content_count($table, $keyword, $content_type, $content_status) {
        $user_id = $_SESSION['user_id'];
        $where = "";
        if($keyword != "" AND $content_type != "")
            $where = "WHERE content_title LIKE '%$keyword%' AND $table.content_type_id = '$content_type' AND $table.content_status = '$content_status'";
        if($keyword != "" AND $content_type == "")
            $where = "WHERE content_title LIKE '%$keyword%' AND $table.content_status = '$content_status'";
        if($keyword == "" AND $content_type != "")
            $where = "WHERE $table.content_type_id = '$content_type' AND $table.content_status = '$content_status'";
        if($content_status != "")
            $where = "WHERE $table.content_status = '$content_status'";

        if($_SESSION['user_type'] == 1)
        {
            $q = $this->db->query("Select $table.*
								FROM $table
								$where
								;");
        }else{
            $q = $this->db->query("Select $table.*
								FROM $table
								WHERE content_user_id = $user_id
								;");
        }

        return $q->num_rows();
    }


    //============================ Get content, content with content_id
    function get_content_content($table, $content_id)
    {
        $query = $this->db->query("Select $table.* FROM $table
								WHERE content_id = $content_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get content image with content_id
    function get_content_image($table, $content_id){
        $this->db->select('content_image');
        $query = $this->db->get_where($table, array('content_id'=>$content_id));
        return $query->result()[0];
    }
	
	
	//============================ 
    function get_content_type_title($table, $content_type_status){
        $q = $this->db->query("Select *
								FROM $table
								WHERE content_type_status = '$content_type_status'
								ORDER BY content_type_id ASC;");
        return $q;
    }


    //============================ 
    function get_game_list_title($table, $content_status){
        $q = $this->db->query("Select *
								FROM $table
								INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE content_status = '$content_status'
								ORDER BY content_title ASC;");
        return $q;
    }


    //============================ Check if any slider exist in content
    function check_slider_exist($table, $content_id){
        $q = $this->db->get_where($table, array('slider_content_id' => $content_id));
        if ($q->num_rows() > 0)
            return TRUE;
        return FALSE;
    }

}