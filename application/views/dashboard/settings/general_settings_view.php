<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//Show relevant sidebar
if ($_SESSION['user_type'] == 1)
    $this->load->view('dashboard/common/sidebar_view');
elseif ($_SESSION['user_type'] == 2)
    $this->load->view('dashboard/common/sidebar_user_view');
?>

    <section class="content">
        <div class="container-fluid">
            <!--<div class="block-header">
                <h2><?php echo $this->lang->line("General Settings"); ?></h2>
            </div>-->
            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("General Settings"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Settings/email_settings"; ?>"><?php echo $this->lang->line("Send Email"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <!-- Alert after process start -->
                            <?php
                            $msg = $this->session->flashdata('msg');
                            $msgType = $this->session->flashdata('msgType');
                            if (isset($msg))
                            {
                                ?>
                                <div class="alert alert-<?php echo $msgType; ?> alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $msg; ?>
                                </div>
                                <?php
                            }
                            ?>
                            <!-- ./Alert after process end -->
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs <?php echo $this->lang->line("tab-col-x"); ?>" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#configuration" data-toggle="tab">
                                        <i class="material-icons">settings</i> <?php echo $this->lang->line("Configuration"); ?>
                                    </a>
                                </li>
								<li role="presentation">
                                    <a href="#push_notification" data-toggle="tab">
                                        <i class="material-icons">notifications</i> <?php echo $this->lang->line("Push Notification"); ?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#youtube" data-toggle="tab">
                                        <i class="material-icons">play_circle_filled</i> <?php echo $this->lang->line("YouTube"); ?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#social_media" data-toggle="tab">
                                        <i class="material-icons">chat</i> <?php echo $this->lang->line("Social Media"); ?>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#seo" data-toggle="tab">
                                        <i class="material-icons">assessment</i> <?php echo $this->lang->line("SEO Tools"); ?>
                                    </a>
                                </li>

                                <li role="presentation">
                                    <a href="#maintenance" data-toggle="tab">
                                        <i class="material-icons">build</i> <?php echo $this->lang->line("Maintenance"); ?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#languages" data-toggle="tab">
                                        <i class="material-icons">g_translate</i> <?php echo $this->lang->line("Languages"); ?>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane fade in active" id="configuration">
                                    <!-- Vertical Layout | With Floating Label -->
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">

                                                    <div class="form-group">
                                                        <label for="setting_app_name" class="col-sm-2 control-label"><?php echo $this->lang->line("App Name"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_app_name" placeholder="<?php echo $this->lang->line("App Name"); ?>" value="<?php echo $settingContent->setting_app_name; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_app_desc" class="col-sm-2 control-label"><?php echo $this->lang->line("Description"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_app_desc" placeholder="<?php echo $this->lang->line("Description"); ?>" value="<?php echo $settingContent->setting_app_desc; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_website" class="col-sm-2 control-label"><?php echo $this->lang->line("Website URL"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_website" placeholder="<?php echo $this->lang->line("Website URL"); ?>" value="<?php echo $settingContent->setting_website; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_email" placeholder="<?php echo $this->lang->line("Email"); ?>" value="<?php echo $settingContent->setting_email; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_phone1" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone 1"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_phone1" placeholder="<?php echo $this->lang->line("Phone 1"); ?>" value="<?php echo $settingContent->setting_phone1; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_phone2" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone 2"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_phone2" placeholder="<?php echo $this->lang->line("Phone 2"); ?>" value="<?php echo $settingContent->setting_phone2; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_phone3" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone 3"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_phone3" placeholder="<?php echo $this->lang->line("Phone 3"); ?>" value="<?php echo $settingContent->setting_phone3; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_sms_no" class="col-sm-2 control-label"><?php echo $this->lang->line("SMS Number"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_sms_no" placeholder="<?php echo $this->lang->line("SMS Number"); ?>" value="<?php echo $settingContent->setting_sms_no; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_address" class="col-sm-2 control-label"><?php echo $this->lang->line("Address"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_address" placeholder="<?php echo $this->lang->line("Address"); ?>" value="<?php echo $settingContent->setting_address; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label for="setting_version_code" class="col-sm-2 control-label"><?php echo $this->lang->line("Version Code"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="number" class="form-control" name="setting_version_code" placeholder="<?php echo $this->lang->line("Version Code"); ?>" value="<?php echo $settingContent->setting_version_code; ?>" required>
                                                            </div>
                                                            <small class="col-pink"><?php echo $this->lang->line("Version code must be an integer number."); ?></small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_version_string" class="col-sm-2 control-label"><?php echo $this->lang->line("Version String"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" name="setting_version_string" placeholder="<?php echo $this->lang->line("Version String"); ?>" value="<?php echo $settingContent->setting_version_string; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <?php
                                                    $setting_email_verification_checked = "";
                                                    if ($settingContent->setting_email_verification == 1)
                                                        $setting_email_verification_checked = "checked";
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="setting_email_verification" class="col-sm-2 control-label"><?php echo $this->lang->line("Email Verification"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" <?php echo $setting_email_verification_checked; ?> id="setting_email_verification" name="setting_email_verification">
                                                                <label for="setting_email_verification"><?php echo $this->lang->line("Force to verification email address to permit login."); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $setting_disable_registration_checked = "";
                                                    if ($settingContent->setting_disable_registration == 1)
                                                        $setting_disable_registration_checked = "checked";
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="setting_disable_registration" class="col-sm-2 control-label"><?php echo $this->lang->line("Registration"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" <?php echo $setting_disable_registration_checked; ?> id="setting_disable_registration" name="setting_disable_registration">
                                                                <label for="setting_disable_registration"><?php echo $this->lang->line("Enable user registration from web version."); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="setting_logo" class="col-sm-2 control-label"><?php echo $this->lang->line("Logo"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="file" name="setting_logo" multiple>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="old_setting_logo" value="<?php echo $settingContent->setting_logo; ?>" readonly="readonly" required>
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                            <input type="hidden" name="setting_section" value="configuration" readonly="readonly" required>
                                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //Demo alert
                                                    if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Vertical Layout | With Floating Label -->
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="push_notification">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="setting_one_signal_app_id" class="col-sm-2 control-label"><?php echo $this->lang->line("OneSignal APP ID"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="password" class="form-control" name="setting_one_signal_app_id" required placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" value="<?php echo $this->encrypt->decode($settingContent->setting_one_signal_app_id); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="setting_one_signal_rest_api_key" class="col-sm-2 control-label"><?php echo $this->lang->line("OneSignal REST API Key"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="password" class="form-control" name="setting_one_signal_rest_api_key" required placeholder="NzxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxTp" value="<?php echo $this->encrypt->decode($settingContent->setting_one_signal_rest_api_key); ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                            <input type="hidden" name="setting_section" value="push_notification" readonly="readonly" required>
                                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //Demo alert
                                                    if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="youtube">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="setting_youtube_api_key" class="col-sm-2 control-label"><?php echo $this->lang->line("YouTube API Key"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="password" class="form-control" name="setting_youtube_api_key" required placeholder="xxxxxxxxx_xxxxxxxxxxxxxxxxxxxxxxxxxxxxx" value="<?php echo $settingContent->setting_youtube_api_key; ?>">
                                                            </div>
                                                            <small class="col-pink"><?php echo $this->lang->line("How to Get API Key for YouTube?"); ?> <a target="_blank" title="YouTube API" href="https://www.viacoders.com/how-to-get-api-key-for-youtube/">Click Here!</a></small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                            <input type="hidden" name="setting_section" value="youtube" readonly="readonly" required>
                                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    //Demo alert
                                                    if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div role="tabpanel" class="tab-pane fade" id="social_media">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="setting_skype" class="col-sm-2 control-label"><?php echo $this->lang->line("Skype"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_skype" placeholder="<?php echo $this->lang->line("Skype"); ?>" value="<?php echo $settingContent->setting_skype; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_telegram" class="col-sm-2 control-label"><?php echo $this->lang->line("Telegram"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_telegram" placeholder="<?php echo $this->lang->line("Telegram"); ?>" value="<?php echo $settingContent->setting_telegram; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_whatsapp" class="col-sm-2 control-label"><?php echo $this->lang->line("WhatsApp"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_whatsapp" placeholder="<?php echo $this->lang->line("WhatsApp"); ?>" value="<?php echo $settingContent->setting_whatsapp; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_instagram" class="col-sm-2 control-label"><?php echo $this->lang->line("Instagram"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_instagram" placeholder="<?php echo $this->lang->line("Instagram"); ?>" value="<?php echo $settingContent->setting_instagram; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_facebook" class="col-sm-2 control-label"><?php echo $this->lang->line("Facebook"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_facebook" placeholder="<?php echo $this->lang->line("Facebook"); ?>" value="<?php echo $settingContent->setting_facebook; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_twiiter" class="col-sm-2 control-label"><?php echo $this->lang->line("Twiiter"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_twiiter" placeholder="<?php echo $this->lang->line("Twiiter"); ?>" value="<?php echo $settingContent->setting_twiiter; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_custom1" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom 1"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_custom1" placeholder="<?php echo $this->lang->line("Custom 1"); ?>" value="<?php echo $settingContent->setting_custom1 ; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="setting_custom2" class="col-sm-2 control-label"><?php echo $this->lang->line("Custom 2"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="setting_custom2" placeholder="<?php echo $this->lang->line("Custom 2"); ?>" value="<?php echo $settingContent->setting_custom2; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                <input type="hidden" name="setting_section" value="social_media" readonly="readonly" required>
                                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                            </div>
                                        </div>
                                        <?php
                                        //Demo alert
                                        if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
                                            </div>
                                        <?php } ?>
                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="seo">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="seo_description" class="col-sm-2 control-label"><?php echo $this->lang->line("SEO Description"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <textarea rows="3" required name="seo_description" class="form-control no-resize" placeholder="<?php echo $this->lang->line("Description 2-3 sentences and do not use line breaks and at least 70 characters"); ?>"><?php echo $seoContent->seo_description; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="seo_keywords" required class="col-sm-2 control-label"><?php echo $this->lang->line("SEO Keywords"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <textarea rows="3" required name="seo_keywords" class="form-control no-resize" placeholder="<?php echo $this->lang->line("Keywords separated by commas, up to 255 characters"); ?>"><?php echo $seoContent->seo_keywords; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="seo_author" class="col-sm-2 control-label"><?php echo $this->lang->line("SEO Author"); ?> *</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="text" required class="form-control" name="seo_author" placeholder="<?php echo $this->lang->line("Author for page"); ?>" value="<?php echo $seoContent->seo_author; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                            <input type="hidden" name="setting_section" value="seo" readonly="readonly" required>
                                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="maintenance">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Settings/general_settings/" ?>" enctype="multipart/form-data">

                                                    <?php
                                                    $setting_site_maintenance_checked = $setting_android_maintenance_checked = $setting_ios_maintenance_checked = $setting_other_maintenance_checked = "";
                                                    if ($settingContent->setting_site_maintenance == 1)
                                                        $setting_site_maintenance_checked = "checked";
                                                    if ($settingContent->setting_android_maintenance == 1)
                                                        $setting_android_maintenance_checked = "checked";
                                                    if ($settingContent->setting_ios_maintenance == 1)
                                                        $setting_ios_maintenance_checked = "checked";
                                                    if ($settingContent->setting_other_maintenance == 1)
                                                        $setting_other_maintenance_checked = "checked";
                                                    ?>
                                                    <div class="form-group">
                                                        <label for="setting_site_maintenance" class="col-sm-2 control-label"><?php echo $this->lang->line("Website"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="setting_site_maintenance" name="setting_site_maintenance" <?php echo $setting_site_maintenance_checked; ?>>
                                                                <label class="" for="setting_site_maintenance"><?php echo $this->lang->line("Enable maintenance mode on Website"); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="setting_android_maintenance" class="col-sm-2 control-label"><?php echo $this->lang->line("Android"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="setting_android_maintenance" name="setting_android_maintenance" <?php echo $setting_android_maintenance_checked; ?>>
                                                                <label for="setting_android_maintenance"><?php echo $this->lang->line("Enable maintenance mode on Android"); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="setting_ios_maintenance" class="col-sm-2 control-label"><?php echo $this->lang->line("iOS"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="setting_ios_maintenance" name="setting_ios_maintenance" <?php echo $setting_ios_maintenance_checked; ?>>
                                                                <label for="setting_ios_maintenance"><?php echo $this->lang->line("Enable maintenance mode on iOS"); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="setting_other_maintenance" class="col-sm-2 control-label"><?php echo $this->lang->line("Other"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="setting_other_maintenance" name="setting_other_maintenance" <?php echo $setting_other_maintenance_checked; ?>>
                                                                <label for="setting_other_maintenance"><?php echo $this->lang->line("Enable maintenance mode on Other"); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="setting_text_maintenance" class="col-sm-2 control-label"><?php echo $this->lang->line("Alarm Text"); ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="form-line">
                                                                <textarea class="form-control" name="setting_text_maintenance" rows="3" placeholder="<?php echo $this->lang->line("Alarm Text"); ?>"><?php echo $settingContent->setting_text_maintenance; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                            <input type="hidden" name="setting_section" value="maintenance" readonly="readonly" required>
                                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="languages">
                                    <b><?php echo $this->lang->line("How to changes language text?"); ?></b>
                                    <p><br>
                                        <?php echo $this->lang->line("Language Description..."); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Tabs With Icon Title -->
        </div>
    </section>

<?php
$this->load->view('dashboard/common/footer_view');
$active_tab = $this->uri->segment(4);
?>
<script>
    $(document).ready(function() {
        $('.nav-tabs a[href="#<?php echo $active_tab; ?>"]').tab('show')
    });
</script>