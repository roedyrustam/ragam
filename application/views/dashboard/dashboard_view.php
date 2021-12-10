<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//$this->load->view('dashboard/common/settings_sidebar_view');

if(isset($this->session->userdata['user_username'])){
    if($this->session->userdata['user_type'] == 1)
    {
        $this->load->view('dashboard/common/sidebar_view');
        $this->load->view('dashboard/dashboard_admin_view');

    } else if($this->session->userdata['user_type'] == 2) {
        $this->load->view('dashboard/common/sidebar_user_view');
        $this->load->view('dashboard/dashboard_user_view');

    } else {
        redirect(base_url().'dashboard/Auth');
        die();
    }

} else {
    redirect(base_url().'dashboard/Auth');
    die();
}


$this->load->view('dashboard/common/footer_view');
?>
