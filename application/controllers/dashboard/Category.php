<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
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


    //============================ Categories
    public function categories()
    {
        if(isset($_POST['category_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/category/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('category_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_category_image = "slider.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/category/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/category/'.$this->upload->data()['file_name'];
				/*$config['maintain_ratio'] = false;
				$config['width'] = 256;
				$config['height'] = 256;
                $config['overwrite'] = TRUE;*/
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_category_image =  $this->upload->data()['file_name'];
            }


            $this->form_validation->set_rules('category_title', $this->lang->line("Category Title"), 'trim|required|xss_clean|min_length[1]');
            $this->form_validation->set_rules('category_parent_id', $this->lang->line("Category Parent"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_order', $this->lang->line("Category Order"), 'trim|xss_clean|required');
            $this->form_validation->set_rules('category_image', $this->lang->line("Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('category_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Category/categories');

            } else {
                if ($this->input->post('category_status') == "on") $category_status = 1; else $category_status = 0;
				$category_title = $this->input->post('category_title');
				$category_slug = $this->Shared_model->url_slug($category_title, array('transliterate' => true));

                $dataArray = array(
                    "category_title" => $this->input->post('category_title'),
                    "category_slug" => $category_slug,
                    "category_parent_id" => $this->input->post('category_parent_id'),
                    "category_order" => $this->input->post('category_order'),
                    "category_image" => $new_category_image,
                    "category_status" => $category_status,
                );

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("category_table",$dataArray);
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data added successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Category/categories');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Category/categories');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["categoriesList"] = $this->Category_model->get_categories('category_table')->result();
        $data["fetchCategories"] = $this->Category_model->fetch_categories('category_table', 0)->result();
        $data["pageTitle"] = $this->lang->line("Categories");
        $this->load->view('dashboard/category/categories_view', $data);
    }


    //============================ Delete category
    public function delete_category(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['category_id'])) {
            $this->form_validation->set_rules('category_id', 'category_id', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Category/categories');

            } else {
                $category_id = $this->input->post('category_id');
                //Check if there are any content in this category
                $hasContent = $this->db->get_where('content_table', array('content_category_id' => $category_id));
                if ($hasContent->num_rows() > 0)
                {
                    $msg = $this->lang->line("This category has data. You must first delete all data.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Category/categories');
                    $this->db->close();
                    die();
                }

                //Check if there are any sub categories in the main category that you want delete
                $isParent = $this->db->get_where('category_table', array('category_parent_id' => $category_id));
                if ($isParent->num_rows()>0)
                {
                    $msg = $this->lang->line("This category has sub categorise. You must first delete all sub categories.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Category/categories');
                    $this->db->close();
                    die();
                }

                //Remove category image from disk
                $q = $this->Category_model->get_category_image("category_table",$category_id);
                if ($q->category_image != 'category.png')
                {
                    $category_image = "assets/upload/category/".$q->category_image;
                    unlink($category_image);
                }

                $result = $this->Common_model->data_remove("category_table",array("category_id"=>$category_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Category/categories');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Category/categories');
                }
            }


        }


    }


    //============================ Edit category
    public function edit_category()
    {
        if(isset($_POST['category_title']))
        {
            //For uploading
            $config['upload_path']          = 'assets/upload/category/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('category_image'))
            {
                $error = array('error' => $this->upload->display_errors());
                //print_r($error);
                $new_category_image = "category.png";

            } else {
                // [ Resize avatar image ]
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/upload/category/'.$this->upload->data()['file_name'];
                $config['new_image'] = 'assets/upload/category/'.$this->upload->data()['file_name'];
                /*$config['maintain_ratio'] = false;
                $config['width'] = 256;
                $config['height'] = 256;*/
                $config['overwrite'] = TRUE;
                $this->load->library('image_lib',$config);
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $data = array('upload_data' => $this->upload->data());
                $new_category_image =  $this->upload->data()['file_name'];
            }

            $this->form_validation->set_rules('category_title', $this->lang->line("Category Title"), 'trim|required|xss_clean|min_length[1]');
            $this->form_validation->set_rules('category_parent_id', $this->lang->line("Category Parent"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_order', $this->lang->line("Category Order"), 'trim|xss_clean|required');
            $this->form_validation->set_rules('category_image', $this->lang->line("Image"), 'trim|xss_clean');
            $this->form_validation->set_rules('category_status', $this->lang->line("Status"), 'trim|xss_clean');
            $this->form_validation->set_rules('category_id', 'category_id', 'trim|xss_clean|required');
            $this->form_validation->set_rules('old_category_image', 'old_category_image', 'trim|xss_clean|required');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Category/categories');

            } else {
                if ($this->input->post('category_status') == "on") $category_status = 1; else $category_status = 0;
				$category_title = $this->input->post('category_title');
				$category_slug = $this->Shared_model->url_slug($category_title, array('transliterate' => true));

                //Check if category_image submit or not
                if ($new_category_image == "category.png")
                {
                    $dataArray = array(
                        "category_title" => $this->input->post('category_title'),
                        "category_slug" => $category_slug,
                        "category_parent_id" => $this->input->post('category_parent_id'),
                        "category_order" => $this->input->post('category_order'),
                        //"category_image" => $new_category_image,
                        "category_status" => $category_status,
                    );

                }else{
                    //Remove old category_image from disk
                    if($this->input->post('old_category_image') != "category.png")
                    {
                        $old_category_image = "assets/upload/category/".$this->input->post('old_category_image');
                        unlink($old_category_image);
                    }

                    $dataArray = array(
                        "category_title" => $this->input->post('category_title'),
						"category_slug" => $category_slug,
                        "category_parent_id" => $this->input->post('category_parent_id'),
                        "category_order" => $this->input->post('category_order'),
                        "category_image" => $new_category_image,
                        "category_status" => $category_status,
                    );
                }

                //Update $dataArray to DB
                $result = $this->Common_model->data_update("category_table",$dataArray,array("category_id"=>$this->input->post('category_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Category/categories');

                }else {
                    redirect(base_url().'dashboard/Category/categories');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["fetchCategories"] = $this->Category_model->fetch_categories('category_table', 0)->result();
        $category_id = $this->uri->segment(4);
        @$data["categoryContent"] = $this->Category_model->get_category_content('category_table', $category_id)->result()[0];
        $data["pageTitle"] = $this->lang->line("Edit Category");
        $this->load->view('dashboard/category/edit_category_view', $data);
    }

}
