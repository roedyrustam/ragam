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
                                <?php echo $this->lang->line("AdMob Configuration"); ?>
                            </h2>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/Settings/admob_settings/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Setting/email_settings/" ?>" enctype="multipart/form-data">-->
                                <div class="form-group">
                                    <label for="admob_setting_app_id" class="col-sm-3 control-label"><?php echo $this->lang->line("App ID"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="admob_setting_app_id" placeholder="<?php echo $this->lang->line("AdMob App ID"); ?>" value="<?php echo $admobSettingContent->admob_setting_app_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label for="admob_setting_banner_unit_id" class="col-sm-3 control-label"><?php echo $this->lang->line("Banner ID"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="admob_setting_banner_unit_id" placeholder="<?php echo $this->lang->line("AdMob Banner Unit ID"); ?>" value="<?php echo $admobSettingContent->admob_setting_banner_unit_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admob_setting_banner_size" class="col-sm-3 control-label"><?php echo $this->lang->line("Banner Size"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <?php
                                            $banner_checked = $large_banner_checked = $medium_banner_checked = $full_banner_checked = $leaderboard_banner_checked = $smart_banner_checked ="";
                                            if ($admobSettingContent->admob_setting_banner_size == "BANNER")
                                                $banner_checked = "selected";
                                            if ($admobSettingContent->admob_setting_banner_size == "LARGE_BANNER")
                                                $large_banner_checked = "selected";
                                            if ($admobSettingContent->admob_setting_banner_size == "MEDIUM_RECTANGLE")
                                                $medium_banner_checked = "selected";
                                            if ($admobSettingContent->admob_setting_banner_size == "FULL_BANNER")
                                                $full_banner_checked = "selected";
                                            if ($admobSettingContent->admob_setting_banner_size == "LEADERBOARD")
                                                $leaderboard_banner_checked = "selected";
                                            if ($admobSettingContent->admob_setting_banner_size == "SMART_BANNER")
                                                $smart_banner_checked = "selected";
                                            ?>
                                            <select class="form-control show-tick" id="admob_setting_banner_size" name="admob_setting_banner_size" required>
                                                <option value="BANNER" data-subtext="(320x50)" <?php echo $banner_checked; ?>>BANNER</option>
                                                <option value="LARGE_BANNER" data-subtext="(320x100)" <?php echo $large_banner_checked; ?>>LARGE_BANNER</option>
                                                <option value="MEDIUM_RECTANGLE" data-subtext="(300x250)" <?php echo $medium_banner_checked; ?>>MEDIUM_RECTANGLE</option>
                                                <option value="FULL_BANNER" data-subtext="(468x60)" <?php echo $full_banner_checked; ?>>FULL_BANNER</option>
                                                <option value="LEADERBOARD" data-subtext="(728x90)" <?php echo $leaderboard_banner_checked; ?>>LEADERBOARD</option>
                                                <option value="SMART_BANNER" data-subtext="(Screen width x 32|50|90)" <?php echo $smart_banner_checked; ?>>SMART_BANNER</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $admob_setting_banner_status_checked = "";
                                if ($admobSettingContent->admob_setting_banner_status == 1)
                                    $admob_setting_banner_status_checked = "checked";
                                ?>
                                <div class="form-group">
                                    <label for="admob_setting_banner_status " class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="admob_setting_banner_status" name="admob_setting_banner_status" <?php echo $admob_setting_banner_status_checked; ?>>
                                            <label for="admob_setting_banner_status"><?php echo $this->lang->line("Enable banner ad."); ?></label>
                                        </div>
                                    </div>
                                </div>

                            <hr>

                                <div class="form-group">
                                    <label for="admob_setting_interstitial_unit_id" class="col-sm-3 control-label"><?php echo $this->lang->line("Interstitial ID"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" required class="form-control" name="admob_setting_interstitial_unit_id" placeholder="<?php echo $this->lang->line("AdMob Interstitial Unit ID"); ?>" value="<?php echo $admobSettingContent->admob_setting_interstitial_unit_id; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admob_setting_interstitial_clicks" class="col-sm-3 control-label"><?php echo $this->lang->line("Interstitial Clicks"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="number" required class="form-control" name="admob_setting_interstitial_clicks" placeholder="<?php echo $this->lang->line("Interstitial Clicks"); ?>" value="<?php echo $admobSettingContent->admob_setting_interstitial_clicks; ?>">
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $admob_setting_interstitial_status_checked = "";
                                if ($admobSettingContent->admob_setting_interstitial_status == 1)
                                    $admob_setting_interstitial_status_checked = "checked";
                                ?>
                                <div class="form-group">
                                    <label for="admob_setting_interstitial_status " class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="admob_setting_interstitial_status" name="admob_setting_interstitial_status" <?php echo $admob_setting_interstitial_status_checked; ?>>
                                            <label for="admob_setting_interstitial_status"><?php echo $this->lang->line("Enable interstitial ad."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
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
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("AdMob Account"); ?>
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
                            <?php echo $this->lang->line("Login to your AdMob account and create an app and generate your ad unit id."); ?> <a href="https://apps.admob.com/"><?php echo $this->lang->line("AdMob Account"); ?></a><br><br>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Banner Size"); ?>
                            </h2>
                        </div>
                        <div class="body">
                            <table style="width:100%;">
                                <tr style="height: 32px;">
                                    <th>Size in dp (WxH)</th>
                                    <th>Description</th>
                                    <th>Availability</th>
                                    <th>AdSize constant</th>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>320x50</td>
                                    <td>Banner</td>
                                    <td>Phones and Tablets</td>
                                    <td><code style="font-weight: bold">BANNER</code></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>320x100</td>
                                    <td>Large Banner</td>
                                    <td>Phones and Tablets</td>
                                    <td><code style="font-weight: bold">LARGE_BANNER</code></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>300x250</td>
                                    <td>IAB Medium Rectangle</td>
                                    <td>Phones and Tablets</td>
                                    <td><code style="font-weight: bold">MEDIUM_RECTANGLE</code></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>468x60</td>
                                    <td>IAB Full-Size Banner</td>
                                    <td>Tablets</td>
                                    <td><code style="font-weight: bold">FULL_BANNER</code></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>728x90</td>
                                    <td>IAB Leaderboard</td>
                                    <td>Tablets</td>
                                    <td><code style="font-weight: bold">LEADERBOARD</code></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td><i>Screen width</i> x 32|50|90</td>
                                    <td>Smart Banner</td>
                                    <td>Phones and Tablets</td>
                                    <td><code style="font-weight: bold">SMART_BANNER</code></td>
                                </tr>
                            </table>

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