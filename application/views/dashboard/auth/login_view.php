<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
?>

    <body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $this->lang->line("app_name"); ?></a>
            <small><?php echo $this->lang->line("app_description"); ?></small>
            <br>
            <!--<p style="color: #b5b5b5;">
                <strong>Admin Demo</strong><br> Username: demoadmin<br>Password: 123456789
                <br><br>
                <strong>User Demo</strong><br> Username: demouser<br>Password: 123456789
            </p>-->
        </div>
        <div class="card">
            <div class="body">
                <?php
                $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                echo form_open(base_url()."dashboard/Auth/user_login_process/", $attributes);
                //form_open_multipart//For Upload
                ?>
                <!--<form id="sign_in" method="POST" action="<?php echo base_url()."dashboard/Auth/user_login_process" ?>">-->
                    <div class="msg"><?php echo $this->lang->line("Please sign in with your information"); ?><hr>
                        <small><?php echo validation_errors(); ?></small>
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
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="user_username" minlength="5" maxlength="30" placeholder="<?php echo $this->lang->line("Username"); ?>" value="<?php echo set_value('user_username'); ?>" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="user_password" minlength="6" maxlength="30" placeholder="<?php echo $this->lang->line("Password"); ?>" required>
                        </div>
                    </div>
                <?php
                @include "google_recaptcha.php";
                ?>
                <div class="g-recaptcha" data-sitekey="<?php echo $google_recaptcha_site_key; ?>"></div><br>


                <!--<div class="col-md-7">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="captcha" class="form-control" minlength="5" maxlength="10" placeholder="<?php echo $this->lang->line("Security Captcha"); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="form-group">
                        <?php
                        echo $showCaptcha;
                        ?>
                    </div>
                </div>-->

                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>">
                            <label for="rememberme"><?php echo $this->lang->line("Remember Me"); ?></label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block <?php echo $this->lang->line("bg-x"); ?> waves-effect" type="submit"><?php echo $this->lang->line("sign_in"); ?></button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="<?php echo base_url()."dashboard/Auth/register"; ?>"><?php echo $this->lang->line("Register Now!"); ?></a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="<?php echo base_url()."dashboard/Auth/forgot_password"; ?>"><?php echo $this->lang->line("Forgot Password?"); ?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
$this->load->view('dashboard/common/footer_view');
?>
