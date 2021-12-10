<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Slider_model");
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


    //============================ Images slider
    public function sliders()
    {
        if(isset($_POST['slider_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/slider/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;



            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('slider_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_slider_image = "slider.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'GD2';
				$config['source_image'] = 'assets/upload/slider/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/slider/'.$this->upload->data()['file_name'];
				$config['quality'] = 50;
				$config['maintain_ratio'] = FALSE;
                $config['width'] = 1920;
                $config['height'] = 800;
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_slider_image =  $this->upload->data()['file_name'];
            }


            $this->form_validation->set_rules('slider_title', $this->lang->line("Slider Title"), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('slider_content_id', 'slider_content_id', 'trim|xss_clean');
            $this->form_validation->set_rules('slider_content_type_id', 'slider_content_type_id', 'trim|xss_clean');
            $this->form_validation->set_rules('slider_description', $this->lang->line("Slider Description"), 'trim|xss_clean|required');
            $this->form_validation->set_rules('slider_image', $this->lang->line("Image"), 'trim|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required"),));
            $this->form_validation->set_rules('slider_status', $this->lang->line("Enable this slider."), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Slider/sliders');

            } else {
                if ($this->input->post('slider_status') == "on") $slider_status = 1; else $slider_status = 0;
				$slider_title = $this->input->post('slider_title');
				$slider_slug = $this->Shared_model->url_slug($slider_title, array('transliterate' => true));

                $dataArray = array(
                    "slider_title" => $this->input->post('slider_title'),
                    "slider_slug" => $slider_slug,
                    "slider_content_id" => $this->input->post('slider_content_id'),
                    "slider_content_type_id" => $this->input->post('slider_content_type_id'),
                    "slider_description" => $this->input->post('slider_description'),
                    "slider_image" => $new_slider_image,
                    "slider_status" => $slider_status,
                );

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("slider_table",$dataArray);
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data added successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Slider/sliders');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Slider/sliders');
                }
            }
        }
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $this->load->model("dashboard/Content_model");
        $data["getContentTypeTitle"] = $this->Content_model->get_content_type_title('content_type_table', 1)->result();
        $data["getGameListTitle"] = $this->Content_model->get_game_list_title('content_table', 1)->result();
        $data["slidersList"] = $this->Slider_model->get_sliders('slider_table')->result();
        $data["pageTitle"] = $this->lang->line("Images Slider");
        $this->load->view('dashboard/slider/sliders_view', $data);
    }


    //============================ Delete slider
    public function delete_slider(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['slider_id'])) {
            $this->form_validation->set_rules('slider_id', 'slider_id', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Slider/sliders');

            } else {
                $slider_id = $this->input->post('slider_id');
                if($slider_id <= 1) //Prevent to delete slider 1
                {
                    $msg = $this->lang->line("You can not delete this item.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Slider/sliders');
                    $this->db->close();
                    die();
                }

                //Remove slider image from disk
                $q = $this->Slider_model->get_slider_image("slider_table",$slider_id);
                if ($q->slider_image != 'slider.png')
                {
                    $slider_image = "assets/upload/slider/".$q->slider_image;
                    unlink($slider_image);
                }

                $result = $this->Common_model->data_remove("slider_table",array("slider_id"=>$slider_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Slider/sliders');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Slider/sliders');
                }
            }


        }


    }


    //============================ Edit slider
    public function edit_slider()
    {
        if(isset($_POST['slider_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/slider/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('slider_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_slider_image = "slider.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/slider/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/slider/'.$this->upload->data()['file_name'];
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 1920;
				$config['height'] = 800;
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_slider_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('slider_title', $this->lang->line("Slider Title"), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('slider_content_id', 'slider_content_id', 'trim|xss_clean');
            $this->form_validation->set_rules('slider_content_type_id', 'slider_content_type_id', 'trim|xss_clean');
            $this->form_validation->set_rules('slider_description', $this->lang->line("Slider Description"), 'trim|xss_clean|required');
            $this->form_validation->set_rules('slider_image', $this->lang->line("Image"), 'trim|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required"),));
            $this->form_validation->set_rules('slider_status', $this->lang->line("Enable this slider."), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Slider/sliders');

            } else {
                if ($this->input->post('slider_status') == "on") $slider_status = 1; else $slider_status = 0;
				$slider_title = $this->input->post('slider_title');
				$slider_slug = $this->Shared_model->url_slug($slider_title, array('transliterate' => true));

                //Check if slider_image submit or not
                if ($new_slider_image == "slider.png")
                {
                    $dataArray = array(
                        "slider_title" => $this->input->post('slider_title'),
                        "slider_slug" => $slider_slug,
						"slider_content_id" => $this->input->post('slider_content_id'),
						"slider_content_type_id" => $this->input->post('slider_content_type_id'),
                        "slider_description" => $this->input->post('slider_description'),
                        //"slider_image" => $new_slider_image,
                        "slider_status" => $slider_status,
                    );

                }else{
                    //Remove old slider_image from disk
                    if($this->input->post('old_slider_image') != "slider.png")
                    {
                        $old_slider_image = "assets/upload/slider/".$this->input->post('old_slider_image');
                        unlink($old_slider_image);
                    }

                    $dataArray = array(
                        "slider_title" => $this->input->post('slider_title'),
                        "slider_content_id" => $this->input->post('slider_content_id'),
                        "slider_content_type_id" => $this->input->post('slider_content_type_id'),
                        "slider_description" => $this->input->post('slider_description'),
                        "slider_image" => $new_slider_image,
                        "slider_status" => $slider_status,
                    );
                }

                //Update $dataArray to DB
                $result = $this->Common_model->data_update("slider_table",$dataArray,array("slider_id"=>$this->input->post('slider_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Slider/sliders');

                }else {
                    redirect(base_url().'dashboard/Slider/sliders');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $slider_id = $this->uri->segment(4);
        $this->load->model("dashboard/Content_model");
        $data["getContentTypeTitle"] = $this->Content_model->get_content_type_title('content_type_table', 1)->result();
		$data["getGameListTitle"] = $this->Content_model->get_game_list_title('content_table', 1)->result();
        @$data["sliderContent"] = $this->Slider_model->get_slider_content('slider_table', $slider_id)->result()[0];
        $data["pageTitle"] = $this->lang->line("Edit Slider");
        $this->load->view('dashboard/slider/edit_slider_view', $data);
    }

}
