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
                                <span class="<?php echo $this->lang->line("pull-right"); ?>"><?php if ($userContent->user_referral == 0) echo $this->lang->line("Nobody"); else echo $userContent->user_referral; ?></span>
                            </li>
                        </ul>
                        <!-- <button class="btn btn-primary btn-lg waves-effect btn-block">FOLLOW</button>-->
                    </div>
                </div>

                <div class="card card-about-me">
                    <div class="header">
                        <h2><?php echo $this->lang->line("My Notes"); ?></h2>
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
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="material-icons">home</i> <?php echo $this->lang->line("Overview"); ?></a></li>
                                <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">contacts</i> <?php echo $this->lang->line("Personal Profile"); ?></a></li>
                                <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">lock</i> <?php echo $this->lang->line("Change Password"); ?></a></li>
                                <li role="presentation"><a href="#withdrawal_coin_settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">monetization_on</i> <?php echo $this->lang->line("Withdrawal Coin"); ?></a></li>
                                <li role="presentation"><a href="#activity" aria-controls="settings" role="tab" data-toggle="tab"><i class="material-icons">access_time</i> <?php echo $this->lang->line("Activity"); ?></a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <!-- Hover Expand Effect -->
                                    <div class="block-header">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="info-box hover-expand-effect">
                                                <div class="icon bg-amber">
                                                    <i class="material-icons">monetization_on</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text"><?php echo $this->lang->line("My Credit")." (".$this->lang->line("coin").")"; ?></div>
                                                    <div class="number"><?php echo $userContent->user_coin; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="info-box hover-expand-effect">
                                                <div class="icon bg-light-green">
                                                    <i class="material-icons">people</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text"><?php echo $this->lang->line("Total Referral"); ?></div>
                                                    <div class="number"><?php echo $totalUserReferral; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Content/content_list"; ?>';">
                                            <div class="info-box hover-expand-effect">
                                                <div class="icon bg-cyan">
                                                    <i class="material-icons">list</i>
                                                </div>
                                                <div class="content">
                                                    <div class="text"><?php echo $this->lang->line("My Content"); ?></div>
                                                    <div class="number"><?php echo $totalUserGames; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #END# Hover Expand Effect -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                                    <br>
                                    <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>" enctype="multipart/form-data">
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
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="profile_settings" required="required">
                                                <input type="hidden" readonly="readonly" name="old_user_image" value="<?php echo $userContent->user_image; ?>" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Edit Profile"); ?></button>
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
                                <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                    <br>
                                    <form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>">
                                        <div class="form-group">
                                            <label for="old_password" class="col-sm-2 control-label"><?php echo $this->lang->line("Old Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="old_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("Old Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password" class="col-sm-2 control-label"><?php echo $this->lang->line("New Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="new_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("New Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password_confirm" class="col-sm-2 control-label"><?php echo $this->lang->line("New Password"); ?></label>
                                            <div class="col-sm-10">
                                                <div class="form-line">
                                                    <input type="password" class="form-control" name="new_password_confirm" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("New Password"); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                                <input type="hidden" readonly="readonly" name="profile_section" value="change_password_settings" required="required">
                                                <button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
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
								<div role="tabpanel" class="tab-pane fade in" id="withdrawal_coin_settings">
									<br>
									<p><?php echo $this->lang->line("Your balance is"); ?> <?php echo $userContent->user_coin; ?> <?php echo $this->lang->line("Coin(s)"); ?> = <?php echo $this->lang->line("default-currency-prefix")." ".$userContent->user_coin*$rewardCoinContent->reward_coin_price_of_each_coin." ".$this->lang->line("default-currency-suffix"); ?></p>
									<p><?php echo $this->lang->line("Minimum coin required is:")." ".$rewardCoinContent->reward_coin_withdrawal_coin_minimum_req." ".$this->lang->line("Coin(s)"); ?></p><hr>
									<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/profile/" ?>">

										<div class="form-group">
											<label for="withdrawal_account_type" class="col-sm-2 control-label"><?php echo $this->lang->line("Account Type"); ?> *</label>
											<div class="col-sm-10">
												<div class="form-line">
													<select class="form-control show-tick" id="withdrawal_account_type" name="withdrawal_account_type" data-live-search="false" required>
														<?php
														foreach ($getWithdrawalAccountType as $key)
														{
														?>
															<option value="<?php echo $key->withdrawal_account_type_id; ?>"><?php echo $key->withdrawal_account_type_title; ?></option>
															<?php
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="withdrawal_account_name" class="col-sm-2 control-label"><?php echo $this->lang->line("Your Account"); ?> *</label>
											<div class="col-sm-10">
												<div class="form-line">
													<input type="text" class="form-control" name="withdrawal_account_name" minlength="5" maxlength="100" placeholder="<?php echo $this->lang->line("Your account or wallet"); ?>" required>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="withdrawal_user_comment" class="col-sm-2 control-label"><?php echo $this->lang->line("Description"); ?></label>
											<div class="col-sm-10">
												<div class="form-line">
													<textarea class="form-control" rows="3" name="withdrawal_user_comment" placeholder="<?php echo $this->lang->line("Description"); ?>"></textarea>
												</div>
											</div>
										</div>


										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
												<input type="hidden" readonly="readonly" name="withdrawal_user_id" value="<?php echo $_SESSION['user_id'] ?>" required="required">
												<input type="hidden" readonly="readonly" name="withdrawal_req_coin" value="<?php echo $userContent->user_coin; ?>" required="required">
												<input type="hidden" readonly="readonly" name="withdrawal_req_cash" value="<?php echo $userContent->user_coin*$rewardCoinContent->reward_coin_price_of_each_coin; ?>" required="required">
												<input type="hidden" readonly="readonly" name="profile_section" value="withdrawal_coin_settings" required="required">
												<button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Submit"); ?></button>
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
                                    <p class="text-center"><?php echo $this->lang->line("Your Last 15 Activities"); ?></p>
                                    <!-- Hover Rows -->
                                    <div class="row clearfix">
                                        <div class="">
                                            <div class="">
                                                <div class="body table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line("Time"); ?></th>
                                                            <th><?php echo $this->lang->line("Activity Description"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach($userActivity as $key) {
                                                        ?>
                                                        <tr>
                                                            <td><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago"); /*echo $this->Shared_model->ago_time($key->activity_time);*/ /*echo $this->jdf->jdate('Y/m/d G:i', $key->activity_time);*/ else echo timespan($key->activity_time, now(), 3);/*echo unix_to_human($key->activity_time);*/ /*echo timespan($key->activity_time, now(), 3);*/ /*echo $this->jdf->jdate('Y/m/d G:i', $key->activity_time);*/  ?></td>
                                                            <td><?php echo $key->activity_desc; ?></td>
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
$active_tab = $this->uri->segment(4);
?>
<script>
    $(document).ready(function() {
        $('.nav-tabs a[href="#<?php echo $active_tab; ?>"]').tab('show')
    });
</script>
