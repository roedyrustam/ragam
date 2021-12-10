<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/Settings_model");
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


    //============================ Show dashboard
    public function index()
    {
        $data["pageTitle"] = $this->lang->line("app_name");
        $this->load->view('dashboard/dashboard_view', $data);
    }


    //============================ General Settings
    public function general_settings()
    {
        if(isset($_POST['setting_section']))
        {
            switch ($_POST['setting_section']) {
                case "configuration":
                    //For uploading
                    $config['upload_path']          = 'assets/upload/';
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['remove_spaces'] = TRUE;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('setting_logo'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        $new_setting_logo = "logo.png";

                    } else {
                        // [ Resize avatar image ]
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'assets/upload/'.$this->upload->data()['file_name'];
                        $config['new_image'] = 'assets/upload/'.$this->upload->data()['file_name'];
                        $config['maintain_ratio'] = TRUE;
                        /*$config['width'] = 128;
                        $config['height'] = 128;*/
                        $config['overwrite'] = TRUE;
                        $this->load->library('image_lib',$config);
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $data = array('upload_data' => $this->upload->data());
                        $new_setting_logo =  $this->upload->data()['file_name'];
                    }

                    $this->form_validation->set_rules('setting_app_name', $this->lang->line("App Name"), 'trim|required|xss_clean|min_length[3]|max_length[50]',
                        array(
                            'required' => $this->lang->line("field_is_required"),
                            'min_length' => $this->lang->line("must_be_minimum_characters"),
                            'max_length' => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('setting_app_desc', $this->lang->line("App Description"), 'trim|required|xss_clean|min_length[3]|max_length[100]',
                        array(
                            'required' => $this->lang->line("field_is_required"),
                            'min_length' => $this->lang->line("must_be_minimum_characters"),
                            'max_length' => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('setting_website', $this->lang->line("Website URL"), 'trim|required|xss_clean|min_length[3]|max_length[50]',
                        array(
                            'required' => $this->lang->line("field_is_required"),
                            'min_length' => $this->lang->line("must_be_minimum_characters"),
                            'max_length' => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('setting_email', $this->lang->line("Email"), 'trim|required|xss_clean|valid_email|min_length[3]|max_length[50]',
                        array(
                            'required' => $this->lang->line("field_is_required"),
                            'min_length' => $this->lang->line("must_be_minimum_characters"),
                            'max_length' => $this->lang->line("must_be_maximum_characters"),
                            'valid_email' => $this->lang->line("is_not_valid_an_email_address")));
                    $this->form_validation->set_rules('setting_phone1', $this->lang->line("Phone 1"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_phone2', $this->lang->line("Phone 2"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_phone3', $this->lang->line("Phone 3"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_sms_no', $this->lang->line("SMS Number"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_address', $this->lang->line("Address"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_version_code', $this->lang->line("Version Code"), 'trim|xss_clean|required');
                    $this->form_validation->set_rules('setting_version_string', $this->lang->line("Version String"), 'trim|xss_clean|required');
                    $this->form_validation->set_rules('setting_section', 'setting_section', 'trim|xss_clean');
                    $this->form_validation->set_rules('old_setting_logo', 'old_setting_logo', 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_logo', 'setting_logo', 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_email_verification', 'setting_email_verification', 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_disable_registration', 'setting_disable_registration', 'trim|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/general_settings");

                    } else {
                        if($this->input->post('setting_email_verification') == "on") $setting_email_verification = "1"; else $setting_email_verification = "0";
                        if($this->input->post('setting_disable_registration') == "on") $setting_disable_registration = "1"; else $setting_disable_registration = "0";

                        if ($new_setting_logo == "logo.png") {
                            $dataArray = array(
                                "setting_app_name" => $this->input->post('setting_app_name'),
                                "setting_app_desc" => $this->input->post('setting_app_desc'),
                                "setting_website" => $this->input->post('setting_website'),
                                "setting_email" => $this->input->post('setting_email'),
                                "setting_phone1" => $this->input->post('setting_phone1'),
                                "setting_phone2" => $this->input->post('setting_phone2'),
                                "setting_phone3" => $this->input->post('setting_phone3'),
                                "setting_sms_no" => $this->input->post('setting_sms_no'),
                                "setting_address" => $this->input->post('setting_address'),
                                "setting_version_code" => $this->input->post('setting_version_code'),
                                "setting_version_string" => $this->input->post('setting_version_string'),
                                //"setting_logo" => $new_setting_logo,
                                "setting_email_verification" => $setting_email_verification,
                                "setting_disable_registration" => $setting_disable_registration,
                            );

                        }else{
                            //Remove old category_image from disk
                            if($this->input->post('old_setting_logo') != "logo.png")
                            {
                                $old_setting_logo = "assets/upload/".$this->input->post('old_setting_logo');
                                unlink($old_setting_logo);
                            }

                            $dataArray = array(
                                "setting_app_name" => $this->input->post('setting_app_name'),
                                "setting_app_desc" => $this->input->post('setting_app_desc'),
                                "setting_website" => $this->input->post('setting_website'),
                                "setting_email" => $this->input->post('setting_email'),
                                "setting_phone1" => $this->input->post('setting_phone1'),
                                "setting_phone2" => $this->input->post('setting_phone2'),
                                "setting_phone3" => $this->input->post('setting_phone3'),
                                "setting_sms_no" => $this->input->post('setting_sms_no'),
                                "setting_address" => $this->input->post('setting_address'),
                                "setting_version_code" => $this->input->post('setting_version_code'),
                                "setting_version_string" => $this->input->post('setting_version_string'),
                                "setting_logo" => $new_setting_logo,
                                "setting_email_verification" => $setting_email_verification,
                                "setting_disable_registration" => $setting_disable_registration,
                            );
                        }

                        //Update from $dataArray
                        $this->Common_model->data_update("setting_table",$dataArray,array("setting_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/configuration");
                    }


                    break;


                case "social_media":
                    $this->form_validation->set_rules('setting_skype', $this->lang->line("Skype"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_telegram', $this->lang->line("Telegram"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_whatsapp', $this->lang->line("WhatsApp"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_instagram', $this->lang->line("Instagram"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_facebook', $this->lang->line("Facebook"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_twiiter', $this->lang->line("Twiiter"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_custom1', $this->lang->line("Custom 1"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_custom2', $this->lang->line("Custom 2"), 'trim|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/social_media");

                    } else {
                        $dataArray = array(
                            "setting_skype" => $this->input->post('setting_skype'),
                            "setting_telegram" => $this->input->post('setting_telegram'),
                            "setting_whatsapp" => $this->input->post('setting_whatsapp'),
                            "setting_instagram" => $this->input->post('setting_instagram'),
                            "setting_facebook" => $this->input->post('setting_facebook'),
                            "setting_twiiter" => $this->input->post('setting_twiiter'),
                            "setting_custom1" => $this->input->post('setting_custom1'),
                            "setting_custom2" => $this->input->post('setting_custom2'),
                        );
                        //Update from $dataArray
                        $this->Common_model->data_update("setting_table",$dataArray,array("setting_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/social_media");
                    }
                    break;

                case "seo":
                    $this->form_validation->set_rules('seo_description', $this->lang->line("SEO Description"), 'trim|required|xss_clean');
                    $this->form_validation->set_rules('seo_keywords', $this->lang->line("SEO Keywords"), 'trim|required|xss_clean');
                    $this->form_validation->set_rules('seo_author', $this->lang->line("SEO Author"), 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/general_settings/seo");

                    } else {
                        $dataArray = array(
                            "seo_description" => $this->input->post('seo_description'),
                            "seo_keywords" => $this->input->post('seo_keywords'),
                            "seo_author" => $this->input->post('seo_author'),
                        );
                        //Update from $dataArray
                        $this->Common_model->data_update("seo_table",$dataArray,array("seo_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/seo");
                    }
                    break;

                case "push_notification":
                    $this->form_validation->set_rules('setting_one_signal_app_id', 'setting_one_signal_app_id', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('setting_one_signal_rest_api_key', 'setting_one_signal_rest_api_key', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/general_settings/push_notification");

                    } else {
                        $dataArray = array(
                            "setting_one_signal_app_id" => $this->encrypt->encode($this->input->post('setting_one_signal_app_id')),
                            "setting_one_signal_rest_api_key" => $this->encrypt->encode($this->input->post('setting_one_signal_rest_api_key'))
                        );
                        //Update from $dataArray
                        $this->Common_model->data_update("setting_table",$dataArray,array("setting_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/push_notification");
                    }
                    break;

                case "youtube":
                    $this->form_validation->set_rules('setting_youtube_api_key', 'setting_youtube_api_key', 'trim|required|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/general_settings/youtube");

                    } else {
                        $dataArray = array(
                            "setting_youtube_api_key" => $this->input->post('setting_youtube_api_key'),
                        );
                        //Update from $dataArray
                        $this->Common_model->data_update("setting_table",$dataArray,array("setting_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/youtube");
                    }
                    break;

                case "maintenance":
                    $this->form_validation->set_rules('setting_site_maintenance', $this->lang->line("Website"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_android_maintenance', $this->lang->line("Android"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_ios_maintenance', $this->lang->line("iOS"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_other_maintenance', $this->lang->line("Other"), 'trim|xss_clean');
                    $this->form_validation->set_rules('setting_text_maintenance', $this->lang->line("Alarm Text"), 'trim|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/Settings/maintenance");

                    } else {
                        if ($this->input->post('setting_site_maintenance') == 'on') $setting_site_maintenance = 1; else $setting_site_maintenance = 0;
                        if ($this->input->post('setting_android_maintenance') == 'on') $setting_android_maintenance = 1; else $setting_android_maintenance = 0;
                        if ($this->input->post('setting_ios_maintenance') == 'on') $setting_ios_maintenance = 1; else $setting_ios_maintenance = 0;
                        if ($this->input->post('setting_other_maintenance') == 'on') $setting_other_maintenance = 1; else $setting_other_maintenance = 0;

                        $dataArray = array(
                            "setting_site_maintenance" => $setting_site_maintenance,
                            "setting_android_maintenance" => $setting_android_maintenance,
                            "setting_ios_maintenance" => $setting_ios_maintenance,
                            "setting_other_maintenance" => $setting_other_maintenance,
                            "setting_text_maintenance" => $this->input->post('setting_text_maintenance'),
                        );
                        //Update from $dataArray
                        $this->Common_model->data_update("setting_table",$dataArray,array("setting_id"=>1));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/Settings/general_settings/maintenance");
                    }
                    break;

                default:
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["settingContent"] = $this->Settings_model->get_setting_content('setting_table', 1)->result()[0];
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["seoContent"] = $this->Settings_model->get_seo_content('seo_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("General Settings");
        $this->load->view('dashboard/settings/general_settings_view', $data);
    }


    //============================ AdMob Settings
    public function admob_settings()
    {
        if(isset($_POST['admob_setting_app_id']))
        {
            $this->form_validation->set_rules('admob_setting_app_id', 'admob_setting_app_id', 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('admob_setting_banner_unit_id', 'admob_setting_banner_unit_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('admob_setting_banner_size', 'admob_setting_banner_size', 'trim|required|xss_clean');
            $this->form_validation->set_rules('admob_setting_banner_status', 'admob_setting_banner_status', 'trim|xss_clean');
            $this->form_validation->set_rules('admob_setting_interstitial_unit_id', 'admob_setting_interstitial_unit_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('admob_setting_interstitial_clicks', 'admob_setting_interstitial_clicks', 'trim|required|xss_clean');
            $this->form_validation->set_rules('admob_setting_interstitial_status', 'admob_setting_interstitial_status', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Settings/admob_settings");

            }else{
                if ($this->input->post('admob_setting_banner_status') == 'on') $admob_setting_banner_status = 1; else $admob_setting_banner_status = 0;
                if ($this->input->post('admob_setting_interstitial_status') == 'on') $admob_setting_interstitial_status = 1; else $admob_setting_interstitial_status = 0;
                //Encrypted password
                $encode_email_setting_smtppass = $this->encrypt->encode($this->input->post('email_setting_smtppass'));

                $dataArray = array(
                    "admob_setting_app_id" => $this->input->post('admob_setting_app_id'),
                    "admob_setting_banner_unit_id" => $this->input->post('admob_setting_banner_unit_id'),
                    "admob_setting_banner_size" => $this->input->post('admob_setting_banner_size'),
                    "admob_setting_banner_status" => $admob_setting_banner_status,
                    "admob_setting_interstitial_unit_id" => $this->input->post('admob_setting_interstitial_unit_id'),
                    "admob_setting_interstitial_clicks" => $this->input->post('admob_setting_interstitial_clicks'),
                    "admob_setting_interstitial_status" => $admob_setting_interstitial_status,
                );
                //Update from $dataArray
                if($this->Common_model->data_update("admob_setting_table",$dataArray,array("admob_setting_id"=>1)))
                {
                    $msg = $this->lang->line("Data successfully updated.");
                    $this->session->set_flashdata('msgType', 'success');

                }else{
                    $msg = $this->lang->line("You are not allowed to do this.");
                    $this->session->set_flashdata('msgType', 'danger');
                }

                $this->session->set_flashdata('msg', $msg);
                redirect(base_url() . "dashboard/Settings/admob_settings");

            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["admobSettingContent"] = $this->Settings_model->get_admob_setting_content('admob_setting_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("AdMob Configuration");
        $this->load->view('dashboard/settings/admob_settings_view', $data);
    }


    //============================ Reward Coin Settings
    public function reward_settings()
    {
        if(isset($_POST['reward_coin_banner_ad_exp']))
        {
            $this->form_validation->set_rules('reward_coin_banner_ad_exp', 'reward_coin_banner_ad_exp', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_interstitial_ad_exp', 'reward_coin_interstitial_ad_exp', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_rewarded_ad_exp', 'reward_coin_rewarded_ad_exp', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_native_ad_exp', 'reward_coin_native_ad_exp', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('reward_coin_play_game_exp', 'reward_coin_play_game_exp', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_watching_video_exp', 'reward_coin_watching_video_exp', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_banner_ad_coin_req', 'reward_coin_banner_ad_coin_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_interstitial_ad_coin_req', 'reward_coin_interstitial_ad_coin_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_rewarded_ad_coin_req', 'reward_coin_rewarded_ad_coin_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_native_ad_coin_req', 'reward_coin_native_ad_coin_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_vip_user_coin_req', 'reward_coin_vip_user_coin_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_banner_ad_click', 'reward_coin_banner_ad_click', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_interstitial_ad_click', 'reward_coin_interstitial_ad_click', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_rewarded_ad_click', 'reward_coin_rewarded_ad_click', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_native_ad_click', 'reward_coin_native_ad_click', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_write_review', 'reward_coin_write_review', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('reward_coin_play_game', 'reward_coin_play_game', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_watching_video', 'reward_coin_watching_video', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_referral_user', 'reward_coin_referral_user', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_referral_friend', 'reward_coin_referral_friend', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_publish_game', 'reward_coin_publish_game', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_withdrawal_coin_minimum_req', 'reward_coin_withdrawal_coin_minimum_req', 'trim|required|xss_clean');
            $this->form_validation->set_rules('reward_coin_price_of_each_coin', 'reward_coin_price_of_each_coin', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Settings/reward_settings");

            }else{
                $dataArray = array(
                    "reward_coin_banner_ad_exp" => $this->input->post('reward_coin_banner_ad_exp'),
                    "reward_coin_interstitial_ad_exp" => $this->input->post('reward_coin_interstitial_ad_exp'),
                    "reward_coin_rewarded_ad_exp" => $this->input->post('reward_coin_rewarded_ad_exp'),
                    "reward_coin_native_ad_exp" => $this->input->post('reward_coin_native_ad_exp'),
                    //"reward_coin_play_game_exp" => $this->input->post('reward_coin_play_game_exp'),
                    "reward_coin_watching_video_exp" => $this->input->post('reward_coin_watching_video_exp'),
                    "reward_coin_banner_ad_coin_req" => $this->input->post('reward_coin_banner_ad_coin_req'),
                    "reward_coin_interstitial_ad_coin_req" => $this->input->post('reward_coin_interstitial_ad_coin_req'),
                    "reward_coin_rewarded_ad_coin_req" => $this->input->post('reward_coin_rewarded_ad_coin_req'),
                    "reward_coin_native_ad_coin_req" => $this->input->post('reward_coin_native_ad_coin_req'),
                    "reward_coin_vip_user_coin_req" => $this->input->post('reward_coin_vip_user_coin_req'),
                    "reward_coin_banner_ad_click" => $this->input->post('reward_coin_banner_ad_click'),
                    "reward_coin_interstitial_ad_click" => $this->input->post('reward_coin_interstitial_ad_click'),
                    "reward_coin_rewarded_ad_click" => $this->input->post('reward_coin_rewarded_ad_click'),
                    "reward_coin_native_ad_click" => $this->input->post('reward_coin_native_ad_click'),
                    "reward_coin_write_review" => $this->input->post('reward_coin_write_review'),
                    //"reward_coin_play_game" => $this->input->post('reward_coin_play_game'),
                    "reward_coin_watching_video" => $this->input->post('reward_coin_watching_video'),
                    "reward_coin_referral_user" => $this->input->post('reward_coin_referral_user'),
                    "reward_coin_referral_friend" => $this->input->post('reward_coin_referral_friend'),
                    "reward_coin_publish_game" => $this->input->post('reward_coin_publish_game'),
                    "reward_coin_withdrawal_coin_minimum_req" => $this->input->post('reward_coin_withdrawal_coin_minimum_req'),
                    "reward_coin_price_of_each_coin" => $this->input->post('reward_coin_price_of_each_coin'),
                );
                //Update from $dataArray
                if($this->Common_model->data_update("reward_coin_table",$dataArray,array("reward_coin_id"=>1)))
                {
                    $msg = $this->lang->line("Data successfully updated.");
                    $this->session->set_flashdata('msgType', 'success');

                }else{
                    $msg = $this->lang->line("You are not allowed to do this.");
                    $this->session->set_flashdata('msgType', 'danger');
                }

                $this->session->set_flashdata('msg', $msg);
                redirect(base_url() . "dashboard/Settings/reward_settings");
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["rewardSettingContent"] = $this->Settings_model->get_reward_setting_content('reward_coin_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("Reward Configuration");
        $this->load->view('dashboard/settings/reward_settings_view', $data);
    }


    //============================ Email Settings
    public function email_settings()
    {
        if(isset($_POST['email_setting_mailtype']))
        {
            $this->form_validation->set_rules('email_setting_mailtype', $this->lang->line("Mail Protocol"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('email_setting_smtphost', $this->lang->line("SMTP Host"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_smtpuser', $this->lang->line("SMTP Username"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_smtppass', $this->lang->line("SMTP Password"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_smtpport', $this->lang->line("SMTP Port"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_crypto', $this->lang->line("SMTP Crypto"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_fromname', $this->lang->line("From Name"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_fromemail', $this->lang->line("From Email"), 'trim|xss_clean|valid_email',
                array(
                    'valid_email'     => $this->lang->line("is_not_valid_an_email_address")));
            $this->form_validation->set_rules('email_setting_cc', $this->lang->line("CC Email"), 'trim|xss_clean|valid_email',
                array(
                    'valid_email'     => $this->lang->line("is_not_valid_an_email_address")));
            $this->form_validation->set_rules('email_setting_signature', $this->lang->line("Signature"), 'trim|xss_clean');
            $this->form_validation->set_rules('email_setting_status', $this->lang->line("Send Email"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Settings/email_settings");

            }else{
                if ($this->input->post('email_setting_status') == 'on') $email_setting_status = 1; else $email_setting_status = 0;
                //Encrypted password
                $encode_email_setting_smtppass = $this->encrypt->encode($this->input->post('email_setting_smtppass'));

                $dataArray = array(
                    "email_setting_mailtype" => $this->input->post('email_setting_mailtype'),
                    "email_setting_smtphost" => $this->input->post('email_setting_smtphost'),
                    "email_setting_smtpuser" => $this->input->post('email_setting_smtpuser'),
                    "email_setting_smtppass" => $encode_email_setting_smtppass,
                    "email_setting_smtpport" => $this->input->post('email_setting_smtpport'),
                    "email_setting_crypto" => $this->input->post('email_setting_crypto'),
                    "email_setting_fromname" => $this->input->post('email_setting_fromname'),
                    "email_setting_fromemail" => $this->input->post('email_setting_fromemail'),
                    "email_setting_cc" => $this->input->post('email_setting_cc'),
                    "email_setting_signature" => $this->input->post('email_setting_signature'),
                    "email_setting_status" => $email_setting_status,
                );
                //Update from $dataArray
                $this->Common_model->data_update("email_setting_table",$dataArray,array("email_setting_id"=>1));
                $msg = $this->lang->line("Data successfully updated.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'info');
                redirect(base_url() . "dashboard/Settings/email_settings");
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["emailSettingContent"] = $this->Settings_model->get_email_setting_content('email_setting_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("General Settings");
        $this->load->view('dashboard/settings/email_settings_view', $data);
    }


    //============================ API Key
    public function api_key()
    {
        if(isset($_POST['api_key']))
        {
            $this->form_validation->set_rules('api_key', $this->lang->line("API Key"), 'trim|required|xss_clean');
            $this->form_validation->set_rules('api_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Settings/api_key");

            }else{
                if ($this->input->post('api_status') == 'on') $api_status = 1; else $api_status = 0;
                //Encrypted API Key
                //$encode_api_key = $this->encrypt->encode($this->input->post('api_key'));
                $encode_api_key = $this->input->post('api_key');
                $dataArray = array(
                    "api_key" => $encode_api_key,
                    "api_status" => $api_status,
                );
                //Update from $dataArray
                $this->Common_model->data_update("api_table",$dataArray,array("api_id"=>1));
                $msg = $this->lang->line("Data successfully updated.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'success');
                redirect(base_url() . "dashboard/Settings/api_key");
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["apiKeyContent"] = $this->Settings_model->get_api_key_content('api_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("API Key");
        $this->load->view('dashboard/settings/api_key_view', $data);
    }


	//============================ Push Notification
    public function push_notification()
    {
        if(isset($_POST['push_notification_title']))
        {
			//For uploading
			$config['upload_path']          = 'assets/upload/notification/';
			$config['allowed_types']        = 'jpg|jpeg|png';
			$config['remove_spaces'] = TRUE;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('push_notification_image'))
			{
				$error = array('error' => $this->upload->display_errors());
				//print_r($error);
				$new_notification_image = "";

			} else {
				// [ Resize avatar image ]
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/upload/notification/'.$this->upload->data()['file_name'];
				$config['new_image'] = 'assets/upload/notification/'.$this->upload->data()['file_name'];
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 500;
				$config['height'] = 250;
				$config['overwrite'] = TRUE;
				$this->load->library('image_lib',$config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				$data = array('upload_data' => $this->upload->data());
				$new_notification_image =  $this->upload->data()['file_name'];
			}


            $this->form_validation->set_rules('push_notification_title', 'push_notification_title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('push_notification_message', 'push_notification_message', 'trim|required|xss_clean');
			$this->form_validation->set_rules('push_notification_image', 'push_notification_image', 'trim|xss_clean');
            $this->form_validation->set_rules('push_notification_external_link', 'push_notification_external_link', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'danger');
                redirect(base_url() . "dashboard/Settings/push_notification");

            }else{
                //OneSignal Notification
                $this->load->model("Shared_model");

                $push_notification_title = $this->input->post('push_notification_title');
                $push_notification_message = $this->input->post('push_notification_message');
				$push_notification_image = $new_notification_image;
                $push_notification_external_link = $this->input->post('push_notification_external_link');

                $response = $this->Shared_model->send_push_notification_one_signal($push_notification_title, $push_notification_message, $push_notification_image, $push_notification_external_link);

                $return["allresponses"] = $response;
                $return = json_encode($return);

                $data = json_decode($response, true);
                //print_r($data);
                //$id = $data['id'];
                //print_r($id);

                //print("\n\nJSON received:\n");
                //print($return);
                //print("\n");
                //Total user that receive notification
                $recipients = $data['recipients'];
                if(empty($recipients))
                    $recipients = 0;
                $msg = $this->lang->line("Notification sent successfully to")." ".$recipients." ".$this->lang->line("user(s).");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'success');
                redirect(base_url() . "dashboard/Settings/push_notification");
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["pushNotificationUserList"] = $this->Settings_model->get_push_notification_user_list('user_table')->result();
        $data["pageTitle"] = $this->lang->line("Push Notification");
        $this->load->view('dashboard/settings/push_notification_view', $data);
    }

}
