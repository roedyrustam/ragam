<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends Admin_Controller
{
    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Content_model");
        $this->load->model("dashboard/Category_model");
        $this->load->model("Shared_model");
    }


    //============================ Check user is login or not
    private function is_login() {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Auth");
            die();
        }
    }


    //============================ Content list
    public function content_list()
    {
        $keyword = $content_type = $content_status = "";
        if(isset($_GET['keyword'])) $keyword = $_GET['keyword'];
        if(isset($_GET['content_type'])) $content_type = $_GET['content_type'];
        if(isset($_GET['content_status'])) $content_status = $_GET['content_status'];

        //Start Pagination
        //Load For Pagination
        //$this->load->helper("url");
        $this->load->library("pagination");

        $config = array();
        $config['base_url'] = base_url() . "dashboard/Content/content_list/";
        $config['total_rows'] = $this->Content_model->get_total_content_count('content_table', $keyword, $content_type, $content_status);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 3;
        $config['display_pages'] = TRUE;

        $config['full_tag_open'] = '<div style="text-align: center"><ul class="pagination pagination no-margin">';
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

        $config['first_link'] = '<i class="material-icons">first_page</i>';
        //$config['first_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        //$config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="material-icons">last_page</i>';
        //$config['last_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        //$config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        //To pass GET parametrs (keywords)
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        //$config["num_links"] = round( $config["total_rows"] / $config["per_page"] );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["Links"] = $this->pagination->create_links();
        // .End Pagination

        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["contentList"] = $this->Content_model->get_content('content_table', $keyword, $content_type, $content_status, $config["per_page"], $page)->result();
        $data["contentType"] = $this->Content_model->get_content_type('content_type_table')->result();
        $data["pageTitle"] = $this->lang->line("Content List");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/content_list_view', $data);
        else
            $this->load->view('dashboard/content/content_list_user_view', $data);
    }


    //============================ Add content
    public function add_content()
    {
        if(isset($_POST['content_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/content/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('content_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_content_image = "content.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/content/thumbnail/'.$this->upload->data()['file_name'];
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 385;
                $config['height'] = 250;
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_content_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('content_title', $this->lang->line("Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_user_id', 'content_user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_description', $this->lang->line("Description"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_category_id', $this->lang->line("Category"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_orientation', $this->lang->line("Orientation"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_type_id', $this->lang->line("Content Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_access', $this->lang->line("Access to content"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_user_role_id', $this->lang->line("User Role"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_type_id', $this->lang->line("Content Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_player_type_id', $this->lang->line("Video Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_open_url_inside_app', $this->lang->line("App or Browser"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_price', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_phone', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_email', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_latitude', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_longitude', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_duration', $this->lang->line("Duration"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_order', $this->lang->line("Category Order"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_image', $this->lang->line("Main Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_featured', $this->lang->line("Featured"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_special', $this->lang->line("Special"), 'trim|xss_clean');
			$this->form_validation->set_rules('send_push_notification', $this->lang->line("Push Notification"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/add_content');

            } else {
                if ($this->input->post('content_open_url_inside_app') == 'on') $content_open_url_inside_app = 1; else $content_open_url_inside_app = 0;
                if ($this->input->post('content_featured') == 'on') $content_featured = 1; else $content_featured = 0;
                if ($this->input->post('content_special') == 'on') $content_special = 1; else $content_special = 0;
                if ($this->input->post('content_cached') == 'on') $content_cached = 1; else $content_cached = 0;
				if ($this->input->post('send_push_notification') == 'on') $send_push_notification = 1; else $send_push_notification = 0;
                if ($this->input->post('content_status') == 'on') $content_status = 1; else $content_status = 0;
                $content_title = $this->input->post('content_title');
				$content_slug = $this->Shared_model->url_slug($content_title, array('transliterate' => true));
                $content_property1 = "p1";
                $content_property2 = "p2";
                $content_viewed = 0;
                $content_liked = 0;
                $content_publish_date = now();
                $content_expired_date = time() + (86400 * 365) * 25; //Lifetime (25 Years)

                $dataArray = array(
                    "content_title" => $this->input->post('content_title'),
                    "content_slug" => $content_slug,
                    "content_user_id" => $this->input->post('content_user_id'),
                    "content_description" => $this->input->post('content_description'),
                    "content_category_id" => $this->input->post('content_category_id'),
                    "content_orientation" => $this->input->post('content_orientation'),
                    "content_type_id" => $this->input->post('content_type_id'),
                    "content_access" => $this->input->post('content_access'),
                    "content_user_role_id" => $this->input->post('content_user_role_id'),
                    "content_type_id" => $this->input->post('content_type_id'),
                    "content_player_type_id" => $this->input->post('content_player_type_id'),
                    "content_url" => $this->input->post('content_url'),
                    "content_open_url_inside_app" => $content_open_url_inside_app,
                    "content_price" => $this->input->post('content_price'),
                    "content_phone" => $this->input->post('content_phone'),
                    "content_email" => $this->input->post('content_email'),
                    "content_latitude" => $this->input->post('content_latitude'),
                    "content_longitude" => $this->input->post('content_longitude'),
                    "content_duration" => $this->input->post('content_duration'),
                    "content_order" => $this->input->post('content_order'),
                    "content_image" => $new_content_image,
                    "content_featured" => $content_featured,
                    "content_special" => $content_special,
                    "content_cached" => $content_cached,
                    "content_property1" => $content_property1,
                    "content_property2" => $content_property2,
                    "content_viewed" => $content_viewed,
                    "content_liked" => $content_liked,
                    "content_publish_date" => $content_publish_date,
                    "content_expired_date" => $content_expired_date,
                    "content_status" => $content_status,
                );

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("content_table",$dataArray);
                if ($result == TRUE) {
                    //Send Push Notification
                    if ($send_push_notification == 1)
                    {
                        //OneSignal Notification
                        $push_notification_title = $this->lang->line("New Game Released !");
                        $push_notification_message = $this->input->post('content_title').", ".$this->lang->line("added successfully.");
                        $push_notification_external_link = "";
						$push_notification_image = "";

                        $response = $this->Shared_model->send_push_notification_one_signal($push_notification_title, $push_notification_message, $push_notification_image, $push_notification_external_link);
                        $return["allresponses"] = $response;
                        $return = json_encode($return);

                        $data = json_decode($response, true);

                        $recipients = $data['recipients'];
                        if(empty($recipients))
                            $recipients = 0;
                        $msg_notification = $this->lang->line("Notification sent successfully to")." ".$recipients." ".$this->lang->line("user(s).");

                        $msg = $this->lang->line("Data added successfully.");
                        $this->session->set_flashdata('msg',$msg." ".$msg_notification);
                        $this->session->set_flashdata('msgType','success');
                        redirect(base_url().'dashboard/Content/content_list');

                    }else{
                        $msg = $this->lang->line("Data added successfully.");
                        $this->session->set_flashdata('msg',$msg);
                        $this->session->set_flashdata('msgType','success');
                        redirect(base_url().'dashboard/Content/content_list');
                    }

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["fetchCategories"] = $this->Category_model->fetch_categories('category_table', 0)->result();
        $data["playerType"] = $this->Content_model->get_player_type('player_type_table')->result();
        $data["userRole"] = $this->Content_model->get_user_role('user_role_table')->result();
        $data["contentType"] = $this->Content_model->get_content_type('content_type_table')->result();
        $data["pageTitle"] = $this->lang->line("Add Content");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/add_content_view', $data);
        else
            $this->load->view('dashboard/content/add_content_user_view', $data);
    }


    //============================ Delete content
    public function delete_content(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['content_id'])) {
            $this->form_validation->set_rules('content_id', 'content_id', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/content_list');

            } else {
                $content_id = $this->input->post('content_id');

                //Check if any sliders assign to this content
                $check_slider_exist = $this->Content_model->check_slider_exist('slider_table', $content_id);
                if ($check_slider_exist == TRUE) {
                    $msg = $this->lang->line("A image slider is assign to this content. Delete or edit the image slider first.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/Content/content_list');
                    $this->db->close();
                    die();
                }

                //Remove content image from disk
                $q = $this->Content_model->get_content_image("content_table",$content_id);
                if ($q->content_image != 'content.png')
                {
                    $content_image = "assets/upload/content/".$q->content_image;
                    $content_image_thumbnail = "assets/upload/content/thumbnail/".$q->content_image;
                    unlink($content_image);
                    unlink($content_image_thumbnail);
                }

                $result = $this->Common_model->data_remove("content_table",array("content_id"=>$content_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Content/content_list');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }


        }


    }


    //============================ Edit content
    public function edit_content()
    {
        if(isset($_POST['content_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/content/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('content_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_content_image = "content.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/content/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/content/thumbnail/'.$this->upload->data()['file_name'];
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 385;
				$config['height'] = 250;
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_content_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('content_title', $this->lang->line("Title"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_user_id', 'content_user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_description', $this->lang->line("Description"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_category_id', $this->lang->line("Category"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_orientation', $this->lang->line("Orientation"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_type_id', $this->lang->line("Content Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_access', $this->lang->line("Access to content"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_user_role_id', $this->lang->line("User Role"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_url', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_open_url_inside_app', $this->lang->line("App or Browser"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_price', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_phone', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_email', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_latitude', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_longitude', $this->lang->line("URL"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_duration', $this->lang->line("Duration"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_type_id', $this->lang->line("Content Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_player_type_id', $this->lang->line("Video Type"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_duration', $this->lang->line("Duration"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_order', $this->lang->line("Category Order"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_image', $this->lang->line("Main Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_featured', $this->lang->line("Featured"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_special', $this->lang->line("Special"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_status', $this->lang->line("Status"), 'trim|xss_clean');
            $this->form_validation->set_rules('content_id', $this->lang->line("ID"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('content_old_image', $this->lang->line("Image"), 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Content/content_list');

            } else {
                if ($this->input->post('content_open_url_inside_app') == 'on') $content_open_url_inside_app = 1; else $content_open_url_inside_app = 0;
                if ($this->input->post('content_featured') == 'on') $content_featured = 1; else $content_featured = 0;
                if ($this->input->post('content_special') == 'on') $content_special = 1; else $content_special = 0;
                if ($this->input->post('content_cached') == 'on') $content_cached = 1; else $content_cached = 0;
                if ($this->input->post('content_status') == 'on') $content_status = 1; else $content_status = 0;
				$content_title = $this->input->post('content_title');
				$content_slug = $this->Shared_model->url_slug($content_title, array('transliterate' => true));

                //Check if content_image submit or not
                if ($new_content_image == "content.png")
                {
                    $dataArray = array(
                        "content_title" => $this->input->post('content_title'),
                        "content_slug" => $content_slug,
                        "content_user_id" => $this->input->post('content_user_id'),
                        "content_description" => $this->input->post('content_description'),
                        "content_category_id" => $this->input->post('content_category_id'),
                        "content_orientation" => $this->input->post('content_orientation'),
                        "content_type_id" => $this->input->post('content_type_id'),
                        "content_access" => $this->input->post('content_access'),
                        "content_user_role_id" => $this->input->post('content_user_role_id'),
                        "content_url" => $this->input->post('content_url'),
                        "content_open_url_inside_app" => $content_open_url_inside_app,
                        "content_price" => $this->input->post('content_price'),
                        "content_phone" => $this->input->post('content_phone'),
                        "content_email" => $this->input->post('content_email'),
                        "content_latitude" => $this->input->post('content_latitude'),
                        "content_longitude" => $this->input->post('content_longitude'),
                        "content_duration" => $this->input->post('content_duration'),
                        "content_type_id" => $this->input->post('content_type_id'),
                        "content_player_type_id" => $this->input->post('content_player_type_id'),
                        "content_duration" => $this->input->post('content_duration'),
                        "content_order" => $this->input->post('content_order'),
                        //"content_image" => $new_content_image,
                        "content_featured" => $content_featured,
                        "content_special" => $content_special,
                        "content_cached" => $content_cached,
                        "content_status" => $content_status,
                    );
                }else{
                    //Remove old category_image from disk
                    if($this->input->post('content_old_image') != "content.png")
                    {
                        $content_old_image = "assets/upload/content/".$this->input->post('content_old_image');
                        $content_old_image_thumbnail = "assets/upload/content/thumbnail/".$this->input->post('content_old_image');
                        unlink($content_old_image);
                        unlink($content_old_image_thumbnail);
                    }
                    $dataArray = array(
                        "content_title" => $this->input->post('content_title'),
						"content_slug" => $content_slug,
                        "content_user_id" => $this->input->post('content_user_id'),
                        "content_description" => $this->input->post('content_description'),
                        "content_category_id" => $this->input->post('content_category_id'),
                        "content_orientation" => $this->input->post('content_orientation'),
                        "content_type_id" => $this->input->post('content_type_id'),
                        "content_access" => $this->input->post('content_access'),
                        "content_user_role_id" => $this->input->post('content_user_role_id'),
                        "content_url" => $this->input->post('content_url'),
                        "content_open_url_inside_app" => $content_open_url_inside_app,
                        "content_price" => $this->input->post('content_price'),
                        "content_phone" => $this->input->post('content_phone'),
                        "content_email" => $this->input->post('content_email'),
                        "content_latitude" => $this->input->post('content_latitude'),
                        "content_longitude" => $this->input->post('content_longitude'),
                        "content_duration" => $this->input->post('content_duration'),
                        "content_type_id" => $this->input->post('content_type_id'),
                        "content_player_type_id" => $this->input->post('content_player_type_id'),
                        "content_duration" => $this->input->post('content_duration'),
                        "content_order" => $this->input->post('content_order'),
                        "content_image" => $new_content_image,
                        "content_featured" => $content_featured,
                        "content_special" => $content_special,
                        "content_cached" => $content_cached,
                        "content_status" => $content_status,
                    );
                }

                //Update $dataArray to DB
                $result = $this->Common_model->data_update("content_table",$dataArray,array("content_id"=>$this->input->post('content_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Content/content_list');

                }else {
                    redirect(base_url().'dashboard/Content/content_list');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $content_id = $this->uri->segment(4);
        @$data["contentContent"] = $this->Content_model->get_content_content('content_table', $content_id)->result()[0];
        $data["fetchCategories"] = $this->Category_model->fetch_categories('category_table', 0)->result();
        $data["playerType"] = $this->Content_model->get_player_type('player_type_table')->result();
        $data["userRole"] = $this->Content_model->get_user_role('user_role_table')->result();
        $data["contentType"] = $this->Content_model->get_content_type('content_type_table')->result();
        $data["pageTitle"] = $this->lang->line("Edit Content");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/content/edit_content_view', $data);
        else
            $this->load->view('dashboard/content/edit_content_user_view', $data);
    }
}
