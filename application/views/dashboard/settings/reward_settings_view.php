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
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
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
                                <?php echo $this->lang->line("Reward Coin Configuration"); ?>
                            </h2>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/Settings/reward_settings/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Setting/email_settings/" ?>" enctype="multipart/form-data">-->
                            <p class="col-grey"><?php echo $this->lang->line("Expiration Time 3600 = 1 Hour"); ?></p>
                                <div class="form-group">
                                    <label for="reward_coin_banner_ad_exp" class="col-sm-4 control-label"><?php echo $this->lang->line("Banner Ads Expiration"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_banner_ad_exp" placeholder="<?php echo $this->lang->line("Banner Ads Expiration"); ?>" value="<?php echo $rewardSettingContent->reward_coin_banner_ad_exp; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reward_coin_interstitial_ad_exp" class="col-sm-4 control-label"><?php echo $this->lang->line("Interstitial Ads Expiration"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_interstitial_ad_exp" placeholder="<?php echo $this->lang->line("Interstitial Ads Expiration"); ?>" value="<?php echo $rewardSettingContent->reward_coin_interstitial_ad_exp; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reward_coin_watching_video_exp" class="col-sm-4 control-label"><?php echo $this->lang->line("Watching Video Expiration"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_watching_video_exp" placeholder="<?php echo $this->lang->line("Watching Video Expiration"); ?>" value="<?php echo $rewardSettingContent->reward_coin_watching_video_exp; ?>">
                                        </div>
                                    </div>
                                </div>

                            <hr>
                            <p class="col-grey"><?php echo $this->lang->line("Coin Requirements For Account Upgrade"); ?></p>

                                <div class="form-group">
                                    <label for="reward_coin_banner_ad_coin_req" class="col-sm-4 control-label"><?php echo $this->lang->line("Banner Ads Coin Requirements"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_banner_ad_coin_req" placeholder="<?php echo $this->lang->line("Banner Ads Coin Requirements"); ?>" value="<?php echo $rewardSettingContent->reward_coin_banner_ad_coin_req; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reward_coin_interstitial_ad_coin_req" class="col-sm-4 control-label"><?php echo $this->lang->line("Interstitial Ads Coin Requirements"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_interstitial_ad_coin_req" placeholder="<?php echo $this->lang->line("Interstitial Ads Coin Requirements"); ?>" value="<?php echo $rewardSettingContent->reward_coin_interstitial_ad_coin_req; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="reward_coin_vip_user_coin_req" class="col-sm-4 control-label"><?php echo $this->lang->line("VIP User Coin Requirements"); ?> *</label>
                                    <div class="col-sm-8">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="reward_coin_vip_user_coin_req" placeholder="<?php echo $this->lang->line("VIP User Coin Requirements"); ?>" value="<?php echo $rewardSettingContent->reward_coin_vip_user_coin_req; ?>">
                                        </div>
                                    </div>
                                </div>

                            <hr>
                            <p class="col-grey"><?php echo $this->lang->line("Reward Coin"); ?></p>

                            <div class="form-group">
                                <label for="reward_coin_banner_ad_click" class="col-sm-4 control-label"><?php echo $this->lang->line("Banner Ads Reward Coin Per Click"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_banner_ad_click" placeholder="<?php echo $this->lang->line("Banner Ads Reward Coin Per Click"); ?>" value="<?php echo $rewardSettingContent->reward_coin_banner_ad_click; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_interstitial_ad_click" class="col-sm-4 control-label"><?php echo $this->lang->line("Interstitial Ads Reward Coin Per Click"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_interstitial_ad_click" placeholder="<?php echo $this->lang->line("Interstitial Ads Reward Coin Per Click"); ?>" value="<?php echo $rewardSettingContent->reward_coin_interstitial_ad_click; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_write_review" class="col-sm-4 control-label"><?php echo $this->lang->line("Write a Review"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_write_review" placeholder="<?php echo $this->lang->line("Write a Review"); ?>" value="<?php echo $rewardSettingContent->reward_coin_write_review; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_watching_video" class="col-sm-4 control-label"><?php echo $this->lang->line("Watching Video"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_watching_video" placeholder="<?php echo $this->lang->line("Watching Video"); ?>" value="<?php echo $rewardSettingContent->reward_coin_watching_video; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_referral_user" class="col-sm-4 control-label"><?php echo $this->lang->line("Referral User"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_referral_user" placeholder="<?php echo $this->lang->line("Referral User"); ?>" value="<?php echo $rewardSettingContent->reward_coin_referral_user; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_referral_friend" class="col-sm-4 control-label"><?php echo $this->lang->line("Referral Friend"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_referral_friend" placeholder="<?php echo $this->lang->line("Referral Friend"); ?>" value="<?php echo $rewardSettingContent->reward_coin_referral_friend; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <label for="reward_coin_publish_game" class="col-sm-4 control-label"><?php echo $this->lang->line("Publish New Game"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_publish_game" placeholder="<?php echo $this->lang->line("Publish New Game"); ?>" value="<?php echo $rewardSettingContent->reward_coin_publish_game; ?>">
                                    </div>
                                </div>
                            </div> -->

                            <hr>
                            <p class="col-grey"><?php echo $this->lang->line("Withdrawal Coin"); ?></p>

                            <div class="form-group">
                                <label for="reward_coin_withdrawal_coin_minimum_req" class="col-sm-4 control-label"><?php echo $this->lang->line("Minimum Coins To Be Withdrawal"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_withdrawal_coin_minimum_req" placeholder="<?php echo $this->lang->line("Banner Ads Reward Coin Per Click"); ?>" value="<?php echo $rewardSettingContent->reward_coin_withdrawal_coin_minimum_req; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reward_coin_price_of_each_coin" class="col-sm-4 control-label"><?php echo $this->lang->line("Coin To Cash Rate"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" required class="form-control" name="reward_coin_price_of_each_coin" placeholder="<?php echo $this->lang->line("Banner Ads Reward Coin Per Click"); ?>" value="<?php echo $rewardSettingContent->reward_coin_price_of_each_coin; ?>">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Example: 1000 * 0.01 = $ 10 USD"); ?></small>
                                </div>
                            </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <input type="hidden" readonly required name="reward_coin_publish_game" value="50">
                                        <input type="hidden" readonly required name="reward_coin_rewarded_ad_exp" value="21600">
                                        <input type="hidden" readonly required name="reward_coin_native_ad_exp" value="21600">
                                        <input type="hidden" readonly required name="reward_coin_rewarded_ad_coin_req" value="1000">
                                        <input type="hidden" readonly required name="reward_coin_native_ad_coin_req" value="1000">
                                        <input type="hidden" readonly required name="reward_coin_rewarded_ad_click" value="2">
                                        <input type="hidden" readonly required name="reward_coin_native_ad_click" value="2">

                                        <button <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>
                                        <?php if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
                                            <br><br>
                                            <div class="alert alert-warning alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
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
                            <?php echo $this->lang->line("Nothing Found..."); ?><br><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

<?php
$this->load->view('dashboard/common/footer_view');
?>