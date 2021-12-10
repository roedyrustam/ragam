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

            <div class="col-xs-12 col-sm-3">
                <div class="card profile-card">
                    <div class="profile-header">&nbsp;</div>
                    <div class="profile-body">
                        <div class="image-area">
                            <img width="110" height="110" src="<?php echo base_url()."assets/upload/user/profile_img/".$userContent->user_image; ?>" alt="<?php echo $this->lang->line("Profile"); ?>" />
                        </div>
                        <div class="content-area">
                            <h3><?php echo $userContent->user_username; ?></h3>
                            <p><?php echo "$userContent->user_firstname $userContent->user_lastname"; ?></p>
                        </div>
                    </div>
                    <div class="profile-footer">
                        <ul>
                            <li>
                                <span><?php echo $this->lang->line("Account Type"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php echo $userContent->user_type_title; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("User Role"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php echo $userContent->user_role_title; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Register From"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php echo $userContent->device_type_title; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Join Date"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($this->lang->line("date-format-ago") == "default") echo mdate('%Y/%m/%d', $userContent->user_reg_date); elseif($this->lang->line("date-format-ago") == "jdf") echo $this->jdf->jdate('Y/m/d', $userContent->user_reg_date); else echo mdate('%Y/%m/%d', $userContent->user_reg_date); ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Referral ID"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($userContent->user_referral == 0) echo $this->lang->line("Nobody"); else echo "<a href='".base_url().'dashboard/User/show_user/'.$userContent->user_referral."'># $userContent->user_referral</a>"; ?></span>
                            </li>
                            <li>
                                <span><?php echo $this->lang->line("Status"); ?></span>
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($userContent->user_status == 1) echo "<span class='badge bg-green'>".$this->lang->line("Active")."</span>"; else echo "<span class='badge bg-grey'>".$this->lang->line("Inactive")."</span>"; ?></span>
                            </li>
                        </ul>
                        <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> class="btn btn-danger btn-lg waves-effect btn-block identifyingClass" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $userContent->user_id; ?>"><?php echo $this->lang->line("Delete This User"); ?></button>
                    </div>
                </div>

                <!-- Small deleteModal Size -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="smallModalLabel"><?php echo $this->lang->line("Delete confirmation!"); ?></h4>
                            </div>
                            <div class="modal-body">
                                <?php echo $this->lang->line("Are you sure to delete this item?"); ?>
                            </div>
                            <div class="modal-footer" style="text-align: center">
                                <?php
                                $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                echo form_open(base_url()."dashboard/User/delete_user/", $attributes);
                                ?>
                                <input type="hidden" readonly="readonly" name="user_id" id="user_id" value="" required/>
                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn btn-danger waves-effect"><?php echo $this->lang->line("Yes"); ?></button>&nbsp;&nbsp;
                                <button type="button" class="btn bg-grey waves-effect col-white" data-dismiss="modal"><?php echo $this->lang->line("Cancel"); ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Small deleteModal Size -->

                <div class="card card-about-me">
                    <div class="header">
                        <h2><?php echo $this->lang->line("User Notes"); ?></h2>
                    </div>
                    <div class="body">
                        <?php if (empty($userContent->user_note)) echo $this->lang->line("Nothing Found..."); else echo $userContent->user_note; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
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
                    <div class="body">
                        <div>
                            <ul class="nav nav-tabs <?php echo $this->lang->line("tab-col-x"); ?>" role="tablist">
                                <li role="presentation" class="active"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">contacts</i> <?php echo $this->lang->line("Personal Profile"); ?></a></li>
                                <li role="presentation"><a href="#profile_ads" aria-controls="profile_ads" role="tab" data-toggle="tab"><i class="material-icons">visibility_off</i> <?php echo $this->lang->line("Hide Ads"); ?></a></li>
                                <li role="presentation"><a href="#profile_verification" aria-controls="profile_verification" role="tab" data-toggle="tab"><i class="material-icons">verified_user</i> <?php echo $this->lang->line("Verification"); ?></a></li>
                                <?php
                                if($userContent->user_onesignal_player_id != "Not set yet.") {
                                    ?>
                                    <li role="presentation"><a href="#profile_push_notification"
                                                               aria-controls="profile_push_notification" role="tab"
                                                               data-toggle="tab"><i
                                                    class="material-icons">notifications</i> <?php echo $this->lang->line("Push Notification"); ?>
                                        </a></li>
                                    <?php
                                }
                                ?>
                                <li role="presentation"><a href="#activity" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">access_time</i> <?php echo $this->lang->line("Activity"); ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                    <br>
                                    <?php
                                    $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                    echo form_open_multipart(base_url()."dashboard/User/show_user/", $attributes);
                                    ?>
                                    <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">-->
                                        <div class="form-group">
                                            <label for="user_firstname" class="col-sm-2 control-label"><?php echo $this->lang->line("First Name"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_firstname" minlength="1" maxlength="30" placeholder="<?php echo $this->lang->line("First Name"); ?>" value="<?php echo $userContent->user_firstname; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_lastname" class="col-sm-2 control-label"><?php echo $this->lang->line("Last Name"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_lastname" minlength="1" maxlength="30" placeholder="<?php echo $this->lang->line("Last Name"); ?>" value="<?php echo $userContent->user_lastname; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="user_email" minlength="5" maxlength="60" placeholder="<?php echo $this->lang->line("Email"); ?>" value="<?php echo $userContent->user_email; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_mobile" class="col-sm-2 control-label"><?php echo $this->lang->line("Mobile"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_mobile" minlength="3" maxlength="15" placeholder="<?php echo $this->lang->line("Mobile"); ?>" value="<?php echo $userContent->user_mobile; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_phone" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="user_phone" minlength="3" maxlength="15" placeholder="<?php echo $this->lang->line("Phone"); ?>" value="<?php echo $userContent->user_phone; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_coin" class="col-sm-2 control-label"><?php echo $this->lang->line("Coin(s)"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="number" class="form-control" name="user_coin" placeholder="<?php echo $this->lang->line("Coin"); ?>" value="<?php echo $userContent->user_coin; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_password" class="col-sm-2 control-label"><?php echo $this->lang->line("Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="user_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("Password"); ?>">
                                                </div>
                                                <small class="col-pink"><?php echo $this->lang->line("Insert the new password if you want to change it."); ?></small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_type_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Account Type"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <select disabled="disabled" class="form-control show-tick" id="user_type_id" name="user_type_id" required>
                                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                        <?php
                                                        foreach ($userType as $key) {
                                                            $user_type_selected = $user_type_disabled = "";
                                                            if($key->user_type_id == $userContent->user_type) $user_type_selected = "selected='selected'";
                                                            if($_SESSION['user_role_id'] != 1)
                                                            {
                                                                if($key->user_type_id != $userContent->user_type) $user_type_disabled = "disabled";
                                                            }
                                                            ?>
                                                            <option <?php echo $user_type_selected." ".$user_type_disabled; ?> value="<?php echo $key->user_type_id ?>"><?php echo $key->user_type_title ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_role_id" class="col-sm-2 control-label"><?php echo $this->lang->line("User Role"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <select class="form-control show-tick" id="user_role_id" name="user_role_id" required>
                                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                        <?php
                                                        foreach ($userRole as $key) {
                                                            $user_role_selected = $user_role_disabled = "";
                                                            if($key->user_role_id == $userContent->user_role_id) $user_role_selected = "selected='selected'";
                                                            if($_SESSION['user_role_id'] != 1)
                                                            {
                                                                if($key->user_role_id != $userContent->user_role_id) $user_role_disabled = "disabled";
                                                            }
                                                            ?>
                                                            ?>
                                                            <option <?php echo $user_role_selected." ".$user_role_disabled; ?> value="<?php echo $key->user_role_id ?>"><?php echo $key->user_role_title ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_note" class="col-sm-2 control-label"><?php echo $this->lang->line("Notes"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="user_note" rows="3" minlength="3" maxlength="1000" placeholder="<?php echo $this->lang->line("Notes"); ?>"><?php echo $userContent->user_note; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_image" class="col-sm-2 control-label"><?php echo $this->lang->line("User's Image"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="file" name="user_image" multiple>
                                                </div>
                                                <small class="col-pink"><?php echo $this->lang->line("Best image ratio is 150 * 150 pixel."); ?></small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_status" class="col-sm-2 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <?php
                                                    $user_status_checked = "";
                                                    if($userContent->user_status == 1) $user_status_checked = "checked";
                                                    ?>
                                                    <input type="checkbox" <?php echo $user_status_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_status" name="user_status">
                                                    <label class="" for="user_status"><?php echo $this->lang->line("Active/Inactive this user."); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" readonly="readonly" name="user_type_id" value="<?php echo $userContent->user_type; ?>">
                                                <input type="hidden" readonly="readonly" name="old_user_email" value="<?php echo $userContent->user_email; ?>">
                                                <input type="hidden" readonly="readonly" name="old_user_mobile" value="<?php echo $userContent->user_mobile; ?>">
                                                <input type="hidden" readonly="readonly" name="user_id" value="<?php echo $this->uri->segment(4) ?>" required="required">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_settings" required="required">
                                                <input type="hidden" readonly="readonly" name="old_user_image" value="<?php echo $userContent->user_image; ?>" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Edit Profile"); ?></button>
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
                                <div role="tabpanel" class="tab-pane fade in" id="profile_ads">
                                    <p><?php echo $this->lang->line("You can hide ads for a specific user."); ?></p><br>
                                    <?php
                                    $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                    echo form_open_multipart(base_url()."dashboard/User/show_user/", $attributes);
                                    ?>
                                    <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">-->
                                        <div class="form-group">
                                            <label for="user_hide_banner_ad" class="col-sm-2 control-label"><?php echo $this->lang->line("Banner Ads"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <?php
                                                    $user_hide_banner_ad_checked = "";
                                                    if($userContent->user_hide_banner_ad == 1) $user_hide_banner_ad_checked = "checked";
                                                    ?>
                                                    <input type="checkbox" <?php echo $user_hide_banner_ad_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_hide_banner_ad" name="user_hide_banner_ad">
                                                    <label class="" for="user_hide_banner_ad"><?php echo $this->lang->line("Hide banner ads for this user."); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_hide_interstitial_ad" class="col-sm-2 control-label"><?php echo $this->lang->line("Interstitial Ads"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <?php
                                                    $user_hide_interstitial_ad_checked = "";
                                                    if($userContent->user_hide_interstitial_ad == 1) $user_hide_interstitial_ad_checked = "checked";
                                                    ?>
                                                    <input type="checkbox" <?php echo $user_hide_interstitial_ad_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_hide_interstitial_ad" name="user_hide_interstitial_ad">
                                                    <label class="" for="user_hide_interstitial_ad"><?php echo $this->lang->line("Hide interstitial ads for this user."); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" readonly="readonly" name="user_id" value="<?php echo $this->uri->segment(4) ?>" required="required">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_ads" required="required">
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
                                <div role="tabpanel" class="tab-pane fade in" id="profile_verification">
                                    <p><?php echo $this->lang->line("You can manually verify the user."); ?></p><br>
                                    <?php
                                    $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                    echo form_open_multipart(base_url()."dashboard/User/show_user/", $attributes);
                                    ?>
                                    <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">-->
                                        <div class="form-group">
                                            <label for="user_email_verified" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <?php
                                                    $user_email_verified_checked = "";
                                                    if($userContent->user_email_verified == 1) $user_email_verified_checked = "checked";
                                                    ?>
                                                    <input type="checkbox" <?php echo $user_email_verified_checked; ?> class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_email_verified" name="user_email_verified">
                                                    <label class="" for="user_email_verified"><?php echo $this->lang->line("User email has been verified."); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" readonly="readonly" name="user_id" value="<?php echo $this->uri->segment(4) ?>" required="required">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_verification" required="required">
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
                                <div role="tabpanel" class="tab-pane fade in" id="profile_push_notification">
                                    <p><?php echo $this->lang->line("You can send push notification to this user."); ?></p><br>
                                    <?php
                                    $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                    echo form_open_multipart(base_url()."dashboard/User/show_user/", $attributes);
                                    ?>
                                    <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">-->
                                        <div class="form-group">
                                            <label for="push_notification_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="push_notification_title" minlength="2" maxlength="50" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="push_notification_message" class="col-sm-2 control-label"><?php echo $this->lang->line("Message"); ?> *</label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="push_notification_message" rows="3" required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="push_notification_external_link" class="col-sm-2 control-label"><?php echo $this->lang->line("URL")." ".$this->lang->line("(optional)"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="url" class="form-control" name="push_notification_external_link" placeholder="http://www.Google.com">
                                                </div>
                                                <small class="col-pink">Enter this field only if you want to open a specific website URL.</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" readonly="readonly" name="user_id" value="<?php echo $this->uri->segment(4) ?>" required="required">
                                                <input type="hidden" readonly="readonly" name="user_onesignal_player_id" value="<?php echo $userContent->user_onesignal_player_id; ?>" required="required">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_push_notification" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Submit"); ?></button>
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
                                <div role="tabpanel" class="tab-pane fade in" id="activity">
                                    <!-- Hover Rows -->
                                    <div class="row clearfix">
                                        <div class="">
                                            <div class="">
                                                <div class="table-responsive">
                                                    <table id="userActivities" class="table table-striped dataTable">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("Time"); ?></th>
                                                            <th><?php echo $this->lang->line("IP"); ?></th>
                                                            <th><?php echo $this->lang->line("User Agent"); ?></th>
                                                            <th><?php echo $this->lang->line("Activity Description"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach($userActivity as $key) {
                                                        ?>
                                                        <tr>
                                                            <td><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); else echo timespan($key->activity_time, now(), 2);/*echo unix_to_human($key->activity_time);*/ /*echo timespan($key->activity_time, now(), 3);*/ /*echo $this->jdf->jdate('Y/m/d G:i', $key->activity_time);*/  ?></td>
                                                            <td><?php if($_SESSION['user_role_id'] == 4) echo $this->lang->line("Hidden"); else echo $key->activity_ip; ?></td>
                                                            <td class="font-light"><?php echo $key->activity_agent; ?></td>
                                                            <td class="font-light"><?php echo $key->activity_desc; ?></td>
                                                        </tr>
                                                         <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #END# Hover Rows -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php
$this->load->view('dashboard/common/footer_view');
$active_tab = $this->uri->segment(5);
?>
<script>
    $(document).ready(function() {
        $('.nav-tabs a[href="#<?php echo $active_tab; ?>"]').tab('show')
    });
</script>
<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<!--<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('#userActivities').DataTable({
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : false,
            "order": [[0,'desc']],
            "language": {
                paginate: {
                    next: '<?php echo $this->lang->line("Next"); ?>', // or '→' '&#8594;'
                    previous: '<?php echo $this->lang->line("Previous"); ?>', // or '←' ' &#8592;'
                    first:      '<?php echo $this->lang->line("First"); ?>',
                    last:       '<?php echo $this->lang->line("Last"); ?>',
                },
                "aria": {
                    sortAscending:  ': activate to sort column ascending',
                    sortDescending: ': activate to sort column descendin',
                },
                "zeroRecords": '<?php echo $this->lang->line("No Data Found"); ?>',
                "sLengthMenu": '<?php echo $this->lang->line("Display"); ?> _MENU_ <?php echo $this->lang->line("records"); ?>',
                "search": '<?php echo $this->lang->line("Search"); ?>',
                "infoFiltered": '(<?php echo $this->lang->line("filtered from"); ?> _MAX_ <?php echo $this->lang->line("total records"); ?>)',
                "info": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "infoEmpty": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "loadingRecords": '<?php echo $this->lang->line("Loading..."); ?>',
                "processing":     '<?php echo $this->lang->line("Processing..."); ?>',
                "emptyTable":     '<?php echo $this->lang->line("No data available in table"); ?>',
            }
        });
    });
</script>
<!-- Pass user_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #user_id").val(my_id_value);
        })
    });
</script>

