<?php
class Web_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //========================================================
    function get_featured_content($table, $limit){
        $content_status = 1;
        $q = $this->db->query("Select $table.content_id, content_table.content_title, content_table.content_slug, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM $table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_featured = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");

		return $q;
    }


    //========================================================
    function get_latest_content($table, $limit){
        $content_status = 1;
        $q = $this->db->query("Select $table.content_id, content_table.content_title, content_table.content_slug, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM $table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status)
								ORDER BY content_id DESC
								LIMIT $limit;");

		return $q;
    }


	//========================================================
	function get_special_content($table, $limit){
		$content_status = 1;
		$q = $this->db->query("Select $table.content_id, content_table.content_title, content_table.content_slug, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM $table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_special = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");
		return $q;

		/*if ($q->num_rows() == 0)
			//echo $this->lang->line("Nothing Found...");
		else
			return $q;*/
	}


    //========================================================
    function get_setting($table){
        $q = $this->db->query("Select $table.*
                                FROM $table
								WHERE (setting_id = 1)");

        if ($q->num_rows() == 0)
            echo $this->lang->line("Nothing Found...");
        else
            return $q;
    }


	//========================================================
	function get_seo($table, $seo_id){
		$q = $this->db->query("Select $table.*
                                FROM $table
								WHERE (seo_id = $seo_id)");

		if ($q->num_rows() == 0)
			echo $this->lang->line("Nothing Found...");
		else
			return $q;
	}


    //========================================================
    function get_content($table, $keyword, $category, $content_type, $content_status, $bookmarks, $limit, $start)
    {
		$user_id = "";
		if(isset($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];
		$content_status = 1;
		$inner_join = "";
        $where = "";
        $select_append = "";
        if($category != "")
            $where = "WHERE (content_category_id = '$category') AND (content_status = $content_status)";
        if($keyword != "")
            $where = "WHERE (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%') AND (content_status = $content_status)";
        if($keyword == "" AND $category == "")
            $where = "WHERE content_status = $content_status";
		if($bookmarks == "yes") {
			$select_append = ", bookmark_table.*";
			$inner_join = "INNER JOIN bookmark_table ON $table.content_id = bookmark_table.bookmark_content_id";
			$where = "WHERE content_status = $content_status AND bookmark_user_id = $user_id";
		}



        $q = $this->db->query("Select $table.*, category_table.category_title, content_type_table.content_type_title, user_table.user_username, user_table.user_id, player_type_table.* $select_append
                            FROM $table
                            INNER JOIN category_table
                            ON $table.content_category_id = category_table.category_id 
                            INNER JOIN content_type_table
                            ON $table.content_type_id = content_type_table.content_type_id 
                            INNER JOIN user_table
                            ON $table.content_user_id = user_table.user_id 
                            INNER JOIN player_type_table
                            ON $table.content_player_type_id = player_type_table.player_type_id 
                            $inner_join
                            $where
                            ORDER BY content_id DESC
                            LIMIT $limit OFFSET $start;");
        return $q;
    }


    //========================================================
    function get_content_type($table)
    {
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE content_type_status = 1
								ORDER BY content_type_id ASC;");
        return $q;
    }


    //========================================================
    public function get_total_content_count($table, $keyword, $category, $content_type, $content_status, $bookmarks) {
		$user_id = "";
    	if(isset($_SESSION['user_id']))
    		$user_id = $_SESSION['user_id'];
		$content_status = 1;
		$inner_join = "";
        $where = "";
		$select_append = "";
        if($category != "")
            $where = "WHERE (content_category_id = '$category') AND (content_status = $content_status)";
        if($keyword != "")
            $where = "WHERE (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%') AND (content_status = $content_status)";
        if($keyword == "" AND $category == "")
            $where = "WHERE content_status = $content_status";
		if($bookmarks == "yes") {
			$select_append = ", bookmark_table.*";
			$inner_join = "INNER JOIN bookmark_table ON $table.content_id = bookmark_table.bookmark_content_id";
			$where = "WHERE content_status = $content_status AND bookmark_user_id = $user_id";
		}

        $q = $this->db->query("Select $table.* $select_append
								FROM $table
								$inner_join
								$where
								;");

        return $q->num_rows();
    }


    //========================================================
    function get_one_content($table, $content_id)
    {
        $q = $this->db->query("Select $table.*,
                                      category_table.category_title
								FROM $table
								INNER JOIN category_table
                                ON $table.content_category_id = category_table.category_id
								WHERE content_id = $content_id AND content_status = 1
								;");
        if ($q->num_rows() != 0)
            return $q;
        else
            redirect(base_url());
    }


    //========================================================
    function get_reviews($table, $content_id, $limit)
    {
        $comment_status = 1;
        $q = $this->db->query("Select $table.comment_id, comment_table.comment_user_id, comment_table.comment_text, comment_table.comment_rate, comment_table.comment_time, device_type_table.device_type_title, user_table.user_username, user_table.user_image
                                FROM comment_table
                                INNER JOIN device_type_table
                                ON comment_table.comment_device_type_id = device_type_table.device_type_id
                                INNER JOIN user_table
                                ON comment_table.comment_user_id = user_table.user_id
								WHERE (comment_status = $comment_status) AND (comment_content_id = '$content_id')
								ORDER BY comment_id DESC
								LIMIT $limit;");

            return $q;
    }


    //========================================================
    function all_reviews_content_count($table, $content_id)
    {
        $query = $this->db->query("Select comment_id
                                        FROM $table
                                        WHERE comment_content_id = $content_id AND comment_status = 1;");
        return $query->num_rows();
    }


    //========================================================
    public function get_rating_average($table, $content_id)
    {
        $queryTotalRate = $this->db->query("SELECT SUM(comment_rate) AS comment_rate
                                FROM $table
                                WHERE (comment_content_id = '$content_id' AND comment_status = 1);");
        $total_rate = $queryTotalRate->row()->comment_rate;

        if($total_rate != "")
        {
            $queryRowRate = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1);");
            $row_rate = $queryRowRate->num_rows();

            $queryFiveStar = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1 AND comment_rate = 5);");
            $five_star = $queryFiveStar->num_rows();
            $five_star_average = ($five_star / $row_rate) * 100;

            $queryFourStar = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1 AND comment_rate = 4);");
            $four_star = $queryFourStar->num_rows();
            $four_star_average = ($four_star / $row_rate) * 100;

            $queryThreeStar = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1 AND comment_rate = 3);");
            $three_star = $queryThreeStar->num_rows();
            $three_star_average = ($three_star / $row_rate) * 100;

            $queryTwoStar = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1 AND comment_rate = 2);");
            $two_star = $queryTwoStar->num_rows();
            $two_star_average = ($two_star / $row_rate) * 100;

            $queryOneStar = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE (comment_content_id = '$content_id' AND comment_status = 1 AND comment_rate = 1);");
            $one_star = $queryOneStar->num_rows();
            $one_star_average = ($one_star / $row_rate) * 100;

            $rate_average = $total_rate / $row_rate;
            //echo(round($rate_average,2));

            //Update Rating Average and Rating Count into the content table
            $this->db->query("UPDATE content_table SET content_rating_average = round($rate_average,2), content_rating_count = $row_rate WHERE content_id = '$content_id'");

            $output = array("total_rate" => $total_rate, "row_rate" => $row_rate, "rate_average" => round($rate_average, 2), "one_star" => $one_star, "one_star_average" => round($one_star_average, 0), "two_star" => $two_star,
                "two_star_average" => round($two_star_average, 0), "three_star" => $three_star, "three_star_average" => round($three_star_average, 0), "four_star" => $four_star, "four_star_average" => round($four_star_average, 0),
                "five_star" => $five_star, "five_star_average" => round($five_star_average, 0));
            //echo "[";
            //echo json_encode($output, JSON_UNESCAPED_UNICODE);
            //echo "]";

            return round($rate_average,2);
        }
    }


    //========================================================
    public function update_content_viewed($table, $content_id)
    {
        $this->db->query("UPDATE $table SET content_viewed = content_viewed + 1 WHERE content_id = '$content_id'");
    }

}
