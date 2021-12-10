<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends Public_Controller
{
    //==============================================================//
    function __construct()
    {
        parent::__construct();
        //$this->is_login();
		$this->load->helper('text');
        $this->load->model("dashboard/Settings_model");
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Category_model");
        $this->load->model("dashboard/Slider_model");
        $this->load->model("frontend/Web_model");
        $this->load->model("Shared_model");
    }


    //==============================================================//
    private function is_login()
    {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type'])) {
            redirect(base_url() . "dashboard/Auth");
            die();
        }
    }


    //==============================================================//
    public function index()
    {
        $data["pageTitle"] = $this->lang->line("app_name")." | ".$this->lang->line("app_description");
		$data["seo"] = $this->Web_model->get_seo('seo_table', 1)->row();
        $data["categoriesList"] = $this->Category_model->get_main_categories('category_table')->result();
        $data["categoriesLimit"] = $this->Category_model->get_main_categories_limit('category_table', 6)->result();
        $data["slidersList"] = $this->Slider_model->get_sliders('slider_table')->result();
        $api = $this->Settings_model->get_api_key_content('api_table', 1)->row();
        $data["apiKey"] = $api->api_key;
        $limit = 8;
        $data["featuredContent"] = $this->Web_model->get_featured_content('content_table', $limit)->result();
        $data["latestContent"] = $this->Web_model->get_latest_content('content_table', $limit)->result();
        $data["specialContent"] = $this->Web_model->get_special_content('content_table', $limit)->result();
        $data["setting"] = $this->Web_model->get_setting('setting_table')->row();
        $this->load->view('frontend/home_view', $data);
    }


    //==============================================================//
    public function content_list()
    {
		if(isset($_GET['bookmarks']))
		{
			$bookmarks = $_GET['bookmarks'];
			if($_GET['bookmarks'] == "yes" AND empty($_SESSION['user_id']))
				redirect(base_url());
		}

        $content_status = 1;
        $keyword = $content_type = $category = $bookmarks = "";
        if (isset($_GET['keyword'])) $keyword = $_GET['keyword'];
        if (isset($_GET['category'])) $category = $_GET['category'];
        if (isset($_GET['content_type'])) $content_type = $_GET['content_type'];
        if (isset($_GET['content_status'])) $content_status = $_GET['content_status'];
        if (isset($_GET['bookmarks'])) $bookmarks = $_GET['bookmarks'];

        //Start Pagination
        //Load For Pagination
        $this->load->library("pagination");

        $config = array();
        $config['base_url'] = base_url() . "Web/content_list";
        $config['total_rows'] = $this->Web_model->get_total_content_count('content_table', $keyword, $category, $content_type, $content_status, $bookmarks);
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;
        $config['num_links'] = 3;
        $config['display_pages'] = TRUE;

        $config['full_tag_open'] = '<div style="text-align: center"><ul class="pagination no-margin">';
        $config['full_tag_close'] = '</ul></div>';

        //$config['prev_link'] = '<i class="material-icons">chevron_left</i>';
        $config['prev_link'] = '';
        /*$config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';*/

        //$config['next_link'] = '<i class="material-icons">chevron_right</i>';
        $config['next_link'] = '';
        /*$config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';*/

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        //$config['first_link'] = '<i class="material-icons">first_page</i>';
        $config['first_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        //$config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        //$config['last_link'] = '<i class="material-icons">last_page</i>';
        $config['last_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        //$config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        //To pass GET parametrs (keywords)
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        //$config["num_links"] = round( $config["total_rows"] / $config["per_page"] );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["Links"] = $this->pagination->create_links();
        // .End Pagination

        $data["pageTitle"] = $this->lang->line("Content List");
        $data["seoDescription"] = $this->lang->line("app_name").", ";
        $data["categoriesList"] = $this->Category_model->get_main_categories('category_table')->result();
        if(isset($_GET['category']))
        {
            $category_parent_id = $_GET['category'];
            $data["subCategoriesList"] = $this->Category_model->get_sub_categories('category_table', $category_parent_id)->result();
        }
		
        $api = $this->Settings_model->get_api_key_content('api_table', 1)->row();
		$data["apiKey"] = $api->api_key;
        $data["setting"] = $this->Web_model->get_setting('setting_table')->row();
		$data["seo"] = $this->Web_model->get_seo('seo_table', 1)->row();
		$data["categoriesList"] = $this->Category_model->get_main_categories('category_table')->result();
		$data["categoriesLimit"] = $this->Category_model->get_main_categories_limit('category_table', 6)->result();
        $data["contentList"] = $this->Web_model->get_content('content_table', $keyword, $category, $content_type, $content_status, $bookmarks, $config["per_page"], $page)->result();
        $data["contentType"] = $this->Web_model->get_content_type('content_type_table')->result();
        if(isset($_GET['bookmarks'])) $page_title = $this->lang->line("Bookmarks")." | ";
        else $page_title = $this->lang->line("Content List")." | ";
		$data["pageTitle"] = $page_title.$this->lang->line("app_name");

        $this->load->view('frontend/content_list_view', $data);
    }


    //==============================================================//
    public function content()
    {
        $limit = 40;
        $content_id = $this->uri->segment(3);
        if (empty($content_id)) $content_id = 1;

        $data["reviews"] = $this->Web_model->get_reviews('comment_table', $content_id, $limit)->result();
        $data["reviewsCount"] = $this->Web_model->all_reviews_content_count('comment_table', $content_id);
        $data["ratingAverage"] = $this->Web_model->get_rating_average('comment_table', $content_id);
        $api = $this->Settings_model->get_api_key_content('api_table', 1)->row();
		$data["apiKey"] = $api->api_key;
		$data["seo"] = $this->Web_model->get_seo('seo_table', 1)->row();
        $data["setting"] = $this->Web_model->get_setting('setting_table')->row();
        $data["contentDetail"] = $this->Web_model->get_one_content('content_table', $content_id)->row();
        $content_title = $this->Web_model->get_one_content('content_table', $content_id)->row()->content_title;
		$data["pageTitle"] =$content_title." | ".$this->lang->line("app_name");
        $data["categoriesList"] = $this->Category_model->get_main_categories('category_table')->result();
		$data["categoriesLimit"] = $this->Category_model->get_main_categories_limit('category_table', 6)->result();
        $this->Web_model->update_content_viewed('content_table', $content_id);
        $this->load->view('frontend/content_view', $data);
    }


    //==============================================================//
    public function add_comment()
    {
        $this->form_validation->set_rules('comment_user_id', 'comment_user_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('comment_content_id', 'comment_content_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('comment_device_type_id', 'comment_device_type_id', 'trim|required|xss_clean');
        $this->form_validation->set_rules('comment_text', 'comment_text', 'trim|xss_clean');
        $this->form_validation->set_rules('comment_rate', 'comment_text', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            //error
            echo "FormValidationError";

        } else {
            $comment_status = "0";
            $comment_text = $this->input->post('comment_text');
            if ($comment_text == "") {
                $comment_status = "1"; //Only Rated. No need to check comment.
                $comment_text = $this->lang->line("Only rated.");
            }

            $comment_user_id = $this->input->post('comment_user_id');
            $comment_content_id = $this->input->post('comment_content_id');
            $comment_device_type_id = $this->input->post('comment_device_type_id');
            $comment_text = $comment_text;
            $comment_rate = $this->input->post('comment_rate');
            $comment_user_ip = $this->input->ip_address();
            $comment_user_agent = $_SERVER['HTTP_USER_AGENT'];
            $comment_time = now();

            //Check if user sent review before or not
            $query = $this->db->query("Select * FROM comment_table WHERE (comment_user_id = '$comment_user_id') AND (comment_content_id = '$comment_content_id');");

            if ($query->num_rows() > 0) {
                $msg = $this->lang->line("You sent review recently.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'warning');
                redirect(base_url() . 'Web/content/' . $this->input->post('comment_content_id'));

            } else {
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
                if ($this->Common_model->data_insert("comment_table", $dataArray)) {
                    //Update user coin
                    $q = $this->db->get_where('reward_coin_table', array('reward_coin_id' => 1));
                    $user_coin = $q->row()->reward_coin_write_review; //Number of coin that user reward

                    $this->db->query("UPDATE user_table SET user_coin = user_coin + '$user_coin' WHERE user_id = '$comment_user_id'");

                    $dataArrayUser = array(
                        "activity_user_id" => $comment_user_id,
                        "activity_time" => now(),
                        "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                        "activity_ip" => $this->input->ip_address(),
                        "activity_desc" => $this->lang->line("User earned coin from write a review") . ": " . $user_coin . " " . $this->lang->line("Coin(s)"),
                    );
                    if ($user_coin != "0") $this->Common_model->data_insert("activity_table", $dataArrayUser);

                    $msg = $this->lang->line("Your review has been sent successfully.");
                    $this->session->set_flashdata('msg', $msg);
                    $this->session->set_flashdata('msgType', 'success');
                    redirect(base_url() . 'Web/content/' . $this->input->post('comment_content_id'));
                }

            }
        }
    }


	//==============================================================//
	public function add_to_bookmark()
	{
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

			if ($this->db->insert('bookmark_table', $data)) {
				redirect(base_url() . 'Web/content/' . $content_id);

			} else {
				redirect(base_url() . 'Web/content/' . $content_id);
			}
		}
	}


	//==============================================================//
	public function remove_from_bookmark()
	{
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

			redirect(base_url() . 'Web/content/' . $content_id);
		}
	}
}



