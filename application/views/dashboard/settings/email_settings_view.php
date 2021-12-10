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
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Email Settings"); ?>
                            </h2>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/Settings/email_settings/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Setting/email_settings/" ?>" enctype="multipart/form-data">-->

                                <div class="form-group">
                                    <label for="email_setting_mailtype" class="col-sm-3 control-label"><?php echo $this->lang->line("Protocol"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <?php
                                            $mail_checked = $sendmail_checked = $smtp_checked = "";
                                            if ($emailSettingContent->email_setting_mailtype == "mail")
                                                $mail_checked = "selected";
                                            if ($emailSettingContent->email_setting_mailtype == "sendmail")
                                                $sendmail_checked = "selected";
                                            if ($emailSettingContent->email_setting_mailtype == "smtp")
                                                $smtp_checked = "selected";
                                            ?>
                                            <select class="form-control show-tick" id="email_setting_mailtype" name="email_setting_mailtype" required>
                                                <option value="mail" <?php echo $mail_checked; ?>>Mail</option>
                                                <option value="sendmail" <?php echo $sendmail_checked; ?>>Sendmail</option>
                                                <option value="smtp" <?php echo $smtp_checked; ?>>SMTP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><hr>

                                <div class="form-group">
                                    <label for="email_setting_smtphost" class="col-sm-3 control-label"><?php echo $this->lang->line("SMTP Host"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email_setting_smtphost" value="<?php echo $emailSettingContent->email_setting_smtphost; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_smtpuser" class="col-sm-3 control-label"><?php echo $this->lang->line("SMTP Username"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email_setting_smtpuser" value="<?php echo $emailSettingContent->email_setting_smtpuser; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_smtppass" class="col-sm-3 control-label"><?php echo $this->lang->line("SMTP Password"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="email_setting_smtppass" value="<?php echo $this->encrypt->decode($emailSettingContent->email_setting_smtppass); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_smtpport" class="col-sm-3 control-label"><?php echo $this->lang->line("SMTP Port"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email_setting_smtpport" value="<?php echo $emailSettingContent->email_setting_smtpport; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_crypto" class="col-sm-3 control-label"><?php echo $this->lang->line("SMTP Crypto"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <?php
                                            $none_checked = $tls_checked = $ssl_checked = "";
                                            if ($emailSettingContent->email_setting_crypto == "none")
                                                $none_checked = "selected";
                                            if ($emailSettingContent->email_setting_crypto == "tls")
                                                $tls_checked = "selected";
                                            if ($emailSettingContent->email_setting_crypto == "ssl")
                                                $ssl_checked = "selected";
                                            ?>
                                            <select class="form-control show-tick" id="email_setting_crypto" name="email_setting_crypto">
                                                <option value="none" <?php echo $none_checked; ?>>None</option>
                                                <option value="tls" <?php echo $tls_checked; ?>>TLS</option>
                                                <option value="ssl" <?php echo $ssl_checked; ?>>SSL</option>
                                            </select>
                                            <!--<input name="email_setting_crypto" type="radio" value="none" class="with-gap <?php echo $this->lang->line("radio-col-x"); ?>" />
                                            <label for="email_setting_crypto">None</label>
                                            <input name="email_setting_crypto" type="radio" value="tls" class="with-gap <?php echo $this->lang->line("radio-col-x"); ?>" />
                                            <label for="email_setting_crypto">TLS</label>
                                            <input name="email_setting_crypto" type="radio" value="ssl" class="with-gap <?php echo $this->lang->line("radio-col-x"); ?>" />
                                            <label for="email_setting_crypto">SSL</label>-->
                                        </div>
                                    </div>
                                </div><hr>

                                <div class="form-group">
                                    <label for="email_setting_fromname" class="col-sm-3 control-label"><?php echo $this->lang->line("From Name"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email_setting_fromname" value="<?php echo $emailSettingContent->email_setting_fromname; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_fromemail" class="col-sm-3 control-label"><?php echo $this->lang->line("From Email"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="email_setting_fromemail" value="<?php echo $emailSettingContent->email_setting_fromemail; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_cc" class="col-sm-3 control-label"><?php echo $this->lang->line("CC Email"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="email_setting_cc" value="<?php echo $emailSettingContent->email_setting_cc; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_setting_signature" class="col-sm-3 control-label"><?php echo $this->lang->line("Signature"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <textarea class="form-control" name="email_setting_signature" rows="3"><?php echo $emailSettingContent->email_setting_signature; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            $email_setting_status_checked = "";
                            if ($emailSettingContent->email_setting_status == 1)
                                $email_setting_status_checked = "checked";
                            ?>
                                <div class="form-group">
                                    <label for="email_setting_status " class="col-sm-3 control-label"><?php echo $this->lang->line("Send Email"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="email_setting_status" name="email_setting_status" <?php echo $email_setting_status_checked; ?>>
                                            <label for="email_setting_status"><?php echo $this->lang->line("Enable send email?"); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
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

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Guide"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Settings/general_settings"; ?>"><?php echo $this->lang->line("General Settings"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <p><?php echo $this->lang->line("Mail / Sendmail Protocol"); ?></p>
                            <p class="font-light align-justify"><?php echo $this->lang->line("mail_protocol_guide_text"); ?></p><hr>
                            <p><?php echo $this->lang->line("SMTP Protocol"); ?></p>
                            <p class="font-light align-justify"><?php echo $this->lang->line("smtp_protocol_guide_text"); ?></p>
                            <hr><p><?php echo $this->lang->line("Default GMail Settings"); ?></p>
                            <p class="font-light" style="direction: ltr">SMTP Host: smtp.googlemail.com<br>
                                SMTP User: YourEmail@gmail.com<br>
                                SMTP Pass: Your Gmail Password<br>
                                SMTP Port: 465<br>
                                SMTP Crypto: ssl</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>

<?php
$this->load->view('dashboard/common/footer_view');
?>