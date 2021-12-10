<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Withdrawal extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Withdrawal_model");
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


    //============================ Withdrawal list
    public function withdrawal_coins()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $limit = 10000;
        $data["withdrawalCoinsList"] = $this->Withdrawal_model->get_withdrawal_coins('withdrawal_table', $limit)->result();
        $data["pageTitle"] = $this->lang->line("Withdrawal Coins List");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/withdrawal/withdrawal_coin_list_view', $data);
        else
            $this->load->view('dashboard/withdrawal/withdrawal_coin_list_user_view', $data);
    }


    //============================
    public function delete_withdrawal_coin(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['withdrawal_id'])) {
            $this->form_validation->set_rules('withdrawal_id', 'withdrawal_id', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');

            } else {
                $withdrawal_id = $this->input->post('withdrawal_id');

                $result = $this->Common_model->data_remove("withdrawal_table",array("withdrawal_id"=>$withdrawal_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');
                }
            }
        }
    }


    //============================
    public function show_withdrawal_coin()
    {
        if(isset($_POST['withdrawal_id']))
        {
            $this->form_validation->set_rules('withdrawal_id', 'withdrawal_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('withdrawal_transaction', 'withdrawal_transaction', 'trim|xss_clean');
            $this->form_validation->set_rules('withdrawal_admin_comment', 'withdrawal_admin_comment', 'trim|xss_clean');
            $this->form_validation->set_rules('withdrawal_status', 'withdrawal_status', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');

            } else {
                $dataArray = array(
                    "withdrawal_transaction" => $this->input->post('withdrawal_transaction'),
                    "withdrawal_admin_comment" => $this->input->post('withdrawal_admin_comment'),
                    "withdrawal_status" => $this->input->post('withdrawal_status'),
                    "withdrawal_date_paid" => now(),
                );
                //Update $dataArray to DB
                $result = $this->Common_model->data_update("withdrawal_table",$dataArray,array("withdrawal_id"=>$this->input->post('withdrawal_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');

                }else {
                    redirect(base_url().'dashboard/Withdrawal/withdrawal_coins');
                }
            }

        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $withdrawal_id = $this->uri->segment(4);
        $data["withdrawalCoinContent"] = $this->Withdrawal_model->get_withdrawal_coin_content('withdrawal_table', $withdrawal_id)->row();
        $data["pageTitle"] = $this->lang->line("Show Withdrawal Coin");
        if($_SESSION['user_type'] == 1)
            $this->load->view('dashboard/withdrawal/show_withdrawal_coin_view', $data);
        else
            $this->load->view('dashboard/withdrawal/show_withdrawal_coin_user_view', $data);

    }
}