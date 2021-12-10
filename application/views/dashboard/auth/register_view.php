<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
?>
    <body class="signup-page" xmlns="http://www.w3.org/1999/html">
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $this->lang->line("app_name"); ?></a>
            <small><?php echo $this->lang->line("app_description"); ?></small>
        </div>
        <div class="card">
            <div class="body">
                <?php
                $attributes = array('method' => 'post');
                echo form_open(base_url()."dashboard/Auth/new_user_registration/", $attributes);
                //form_open_multipart//For Upload
                ?>
                <!--<form id="sign_up" method="POST" action="<?php echo base_url()."dashboard/Auth/new_user_registration" ?>">-->
                    <div class="msg"><?php echo $this->lang->line("register_a_new_membership"); ?><hr>
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
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="user_email" minlength="5" maxlength="60" placeholder="<?php echo $this->lang->line("Email"); ?>" value="<?php echo set_value('user_email'); ?>">
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
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="user_confirm_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("Confirm Password"); ?>" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person_outline</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" name="user_referral" maxlength="30" placeholder="<?php echo $this->lang->line("Referral ID"); ?>">
                        </div>
                    </div>

                    <div class="col-md-7">
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
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>">
                        <label for="terms"><?php echo $this->lang->line("i_read_and_agree_to_the"); ?> <a data-toggle="modal" data-target="#termsModal" href="#"><?php echo $this->lang->line("terms_of_usage"); ?></a>.</label>
                    </div>
                <?php
                $disable_btn = "";
                if($settingContent->setting_disable_registration == 0) $disable_btn = "disabled";
                ?>
                    <button <?php echo $disable_btn; ?> class="btn btn-block btn-lg <?php echo $this->lang->line("bg-x"); ?> waves-effect" type="submit"><?php echo $this->lang->line("sign_up"); ?></button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="<?php echo base_url()."dashboard/Auth"; ?>"><?php echo $this->lang->line("you_already_have_a_membership?"); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- termsModal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel"><?php echo $this->lang->line("terms_of_usage"); ?></h4>
                </div>
                <div class="modal-body">
                    <div style="max-height: 350px; overflow-y: auto; overflow-x: hidden">
                        <?php
                        echo "<p class='text-justify'>$pageContent->page_content</p>"
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect <?php echo $this->lang->line("pull-right"); ?>" data-dismiss="modal"><?php echo $this->lang->line("Close"); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view('dashboard/common/footer_view');
?>
