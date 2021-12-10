<?php
class LangSwitch extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    function switchDashboardLanguage($language = "") {
        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
        //redirect(base_url()."dashboard/Dashboard");
		@header('location:'.$_SERVER['HTTP_REFERER']);
    }
}
