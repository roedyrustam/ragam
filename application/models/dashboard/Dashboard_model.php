<?php
class Dashboard_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Categories count
    function all_categories_count()
    {
        $query = $this->db->get('category_table');
        return $query->num_rows();
    }


    //============================ Users count
    function all_users_count()
    {
        $query = $this->db->get('user_table');
        return $query->num_rows();
    }



    //============================ Content count
    function all_content_count()
    {
        $query = $this->db->get('content_table');
        return $query->num_rows();
    }


    //============================ Active Content count
    function all_active_content_count()
    {
        $query = $this->db->query("Select content_id
                                        FROM content_table
                                        WHERE content_status = 1;");
        return $query->num_rows();
    }


    //============================  Inactive Content count
    function all_inactive_content_count()
    {
        $query = $this->db->query("Select content_id
                                        FROM content_table
                                        WHERE content_status = 0;");
        return $query->num_rows();
    }


    //============================ Active Content count
    function all_active_user_content_count()
    {
        $user_id = $_SESSION['user_id'];
        $query = $this->db->query("Select content_id
                                        FROM content_table
                                        WHERE content_status = 1 AND content_user_id = $user_id;");
        return $query->num_rows();
    }


    //============================  Inactive Content count
    function all_inactive_user_content_count()
    {
        $user_id = $_SESSION['user_id'];
        $query = $this->db->query("Select content_id
                                        FROM content_table
                                        WHERE content_status = 0 AND content_user_id = $user_id;");
        return $query->num_rows();
    }


    //============================ Roles count
    function all_roles_count()
    {
        $query = $this->db->get('user_role_table');
        return $query->num_rows();
    }


    //============================ Sliders count
    function all_sliders_count()
    {
        $query = $this->db->query("Select slider_id
                                        FROM slider_table
                                        WHERE slider_status = 1;");
        return $query->num_rows();
    }


    //============================ Income today
    function get_income_today($table)
    {
        $query = $this->db->query("SELECT SUM(transaction_amount) AS transaction_amount, transaction_date
                                FROM $table
                                WHERE (transaction_status = 1) AND (transaction_type = 1) AND (DAY(FROM_UNIXTIME(transaction_date))= DAY(CURDATE())) 
                                ;");
        return $query->row()->transaction_amount;

    }


    //============================ Income this week
    function get_income_week($table)
    {
        $query = $this->db->query("SELECT SUM(transaction_amount) AS transaction_amount, transaction_date
                                FROM $table
                                WHERE (transaction_status = 1) AND (transaction_type = 1) AND (WEEK(FROM_UNIXTIME(transaction_date))= WEEK(CURDATE())) 
                                ;");
        return $query->row()->transaction_amount;

    }


    //============================ Income this month
    function get_income_this_month($table)
    {
        $query = $this->db->query("SELECT SUM(transaction_amount) AS transaction_amount, transaction_date
                                FROM $table
                                WHERE (transaction_status = 1) AND (transaction_type = 1) AND (MONTH(FROM_UNIXTIME(transaction_date))= MONTH(CURDATE())) 
                                ;");
        return $query->row()->transaction_amount;

    }


    //============================ Income this year
    function get_income_this_year($table)
    {
        $query = $this->db->query("SELECT SUM(transaction_amount) AS transaction_amount, transaction_date
                                FROM $table
                                WHERE (transaction_status = 1) AND (transaction_type = 1) AND (YEAR(FROM_UNIXTIME(transaction_date))= YEAR(CURDATE())) 
                                ;");
        return $query->row()->transaction_amount;

    }


    //============================ Income total
    function get_income_total($table)
    {
        $query = $this->db->query("SELECT SUM(transaction_amount) AS transaction_amount, transaction_date
                                FROM $table
                                WHERE (transaction_status = 1) AND (transaction_type = 1)
                                ;");
        return $query->row()->transaction_amount;
    }


    //============================ Comment count
    function all_comments_count($comment_status)
    {
        $query = $this->db->query("Select comment_id
                                        FROM comment_table
                                        WHERE comment_status = '$comment_status';");
        return $query->num_rows();
    }


    //============================ User Joined count
    function all_user_joined_count($user_device_type_id)
    {
        $query = $this->db->query("Select user_id
                                        FROM user_table
                                        WHERE user_device_type_id = '$user_device_type_id';");
        return $query->num_rows();
    }

}