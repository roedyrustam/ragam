<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Page_model");
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


    //============================ Pages list
    public function pages()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["pagesList"] = $this->Page_model->get_pages('page_table')->result();
        $data["pageTitle"] = $this->lang->line("Pages List");
        $this->load->view('dashboard/page/pages_list_view', $data);
    }


    //============================ Add page
    public function add_page()
    {
        if(isset($_POST['page_title']))
        {
            $this->form_validation->set_rules('page_title', $this->lang->line("Page Title"), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('page_content', $this->lang->line("Write Something..."), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('page_type', 'page_type', 'trim|xss_clean|required');
            $this->form_validation->set_rules('page_status', 'page_status', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Page/pages');

            } else {
                if ($this->input->post('page_status') == "on") $page_status = 1; else $page_status = 0;
                //Create Slug function
                function convert_bad_characters($str){
                    $search = array('Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', 'Â', 'Ă', 'ë', 'Ë', 'ی');
                    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E', 'ي');
                    return str_replace($search, $replace, $str);
                }

                $dataArray = array(
                    "page_title" => $this->input->post('page_title'),
                    "page_slug" => url_title(convert_bad_characters($this->input->post('page_title')), 'dash', TRUE),
                    "page_content" => $this->input->post('page_content'),
                    "page_type" => $this->input->post('page_type'),
                    "page_status" => $page_status,
                    "page_publish_time" => now(),
                );

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("page_table",$dataArray);
                if ($result == TRUE) {
                    $msg = $this->lang->line("Content successfully published.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Page/pages');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Page/pages');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["pageTitle"] = $this->lang->line("Add New Page");
        $this->load->view('dashboard/page/add_page_view', $data);
    }


    //============================ Delete page
    public function delete_page(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['page_id'])) {
            $this->form_validation->set_rules('page_id', 'page_id', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Page/pages');

            } else {
                $page_id = $this->input->post('page_id');
                if($page_id <= 4) //Prevent to delete page 1, 2, 3, 4
                {
                    $msg = $this->lang->line("You can not delete this item.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/Page/pages');
                    $this->db->close();
                    die();
                }

                $result = $this->Common_model->data_remove("page_table",array("page_id"=>$page_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Page/pages');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Page/pages');
                }
            }


        }


    }


    //============================ Edit page
    public function edit_page()
    {
        if(isset($_POST['page_title']))
        {
            $this->form_validation->set_rules('page_title', $this->lang->line("Page Title"), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('page_content', $this->lang->line("Write Something..."), 'trim|required|xss_clean|min_length[1]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('page_type', 'page_type', 'trim|xss_clean|required');
            $this->form_validation->set_rules('page_status', 'page_status', 'trim|xss_clean');
            $this->form_validation->set_rules('page_id', 'page_id', 'trim|xss_clean|required');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Page/pages');

            } else {
                if ($this->input->post('page_status') == "on") $page_status = 1; else $page_status = 0;
                //Create Slug function
                function convert_bad_characters($str){
                    $search = array('Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', 'Â', 'Ă', 'ë', 'Ë', 'ی');
                    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E', 'ي');
                    return str_replace($search, $replace, $str);
                }

                $dataArray = array(
                    "page_title" => $this->input->post('page_title'),
                    "page_slug" => url_title(convert_bad_characters($this->input->post('page_title')), 'dash', TRUE),
                    "page_content" => $this->input->post('page_content'),
                    "page_type" => $this->input->post('page_type'),
                    "page_status" => $page_status,
                );
                //Update $dataArray to DB
                $result = $this->Common_model->data_update("page_table",$dataArray,array("page_id"=>$this->input->post('page_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Page/pages');

                }else {
                    redirect(base_url().'dashboard/Page/pages');
                }
            }

        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $page_id = $this->uri->segment(4);
        @$data["pageContent"] = $this->Page_model->get_page_content('page_table', $page_id)->result()[0];
        $data["pageTitle"] = $this->lang->line("Edit Page");
        $this->load->view('dashboard/page/edit_page_view', $data);
    }

}