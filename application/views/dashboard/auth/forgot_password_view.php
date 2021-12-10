<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
?>

    <body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php echo $this->lang->line("app_name"); ?></a>
            <small><?php echo $this->lang->line("app_description"); ?></small>
        </div>
        <div class="card">
            <div class="body">
                <?php
                $attributes = array('class' => 'form-horizontal', 'method' => 'post', 'id' => 'forgot_password');
                echo form_open(base_url()."dashboard/Auth/forgot_password/", $attributes);
                //form_open_multipart//For Upload
                ?>
                    <div class="msg">
                        <?php echo $this->lang->line("Enter your email address that you used to register. We'll send you an email with your username and a link to reset your password."); ?>
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
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="user_email" placeholder="<?php echo $this->lang->line("Email"); ?>" required autofocus>
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

                    <button class="btn btn-block btn-lg <?php echo $this->lang->line("bg-x"); ?> waves-effect" type="submit"><?php echo $this->lang->line("Reset My Password"); ?></button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="<?php echo base_url()."dashboard/Auth"; ?>"><?php echo $this->lang->line("Sign In !"); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
$this->load->view('dashboard/common/footer_view');
?>