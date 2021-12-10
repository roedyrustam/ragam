<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        //Load language files in whole script (Admin/User/Public)
        //$this->lang->load("admin","english");
    }
}

class Admin_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        //Load 'dashboard' Languages to whole 'Admin_Controller'
        $this->lang->load("dashboard","english");
    }
}

class User_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
}

class Public_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
}