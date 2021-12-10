<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Get version
$this->db->select('setting_version_string');
$q = $this->db->get_where('setting_table', array('setting_id' => 1));
$setting_version_string = $q->result()[0]->setting_version_string;
?>

<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">

            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user_username']; ?></div>
                <div class="email font-light"><?php echo $_SESSION['user_email']; ?></div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo base_url()."dashboard/User/profile"; ?>"><i class="material-icons">person</i><?php echo $this->lang->line("Profile"); ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url()."dashboard/User/profile/profile_settings"; ?>"><i class="material-icons">contacts</i><?php echo $this->lang->line("Personal Profile"); ?></a></li>
                        <li><a href="<?php echo base_url()."dashboard/User/profile/change_password_settings"; ?>"><i class="material-icons">lock</i><?php echo $this->lang->line("Change Password"); ?></a></li>
                        <li><a href="<?php echo base_url()."dashboard/User/profile/activity"; ?>"><i class="material-icons">access_time</i><?php echo $this->lang->line("Activity"); ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url()."dashboard/Auth/user_logout_process"; ?>"><i class="material-icons">input</i><?php echo $this->lang->line("Sign Out"); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
<!-- Menu -->
<?php
$last_segment = $this->uri->segment(3);
$active_menu = "active";
?>
<div class="menu">
    <ul class="list">
        <!--<li class="header">MAIN NAVIGATION</li>-->
        <!-- Dashboard -->
        <li class="<?php if ($last_segment == "") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/Dashboard"; ?>">
                <i class="material-icons">home</i>
                <span><?php echo $this->lang->line("Dashboard"); ?></span>
            </a>
        </li>

        <!-- User Profile -->
        <li class="<?php if ($last_segment == "profile") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/User/profile/"; ?>">
                <i class="material-icons">person</i>
                <span><?php echo $this->lang->line("My Profile"); ?></span>
            </a>
        </li>

        <!-- Categories -->
        <li class="<?php if ($last_segment == "categories") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/Category/categories"; ?>">
                <i class="material-icons">apps</i>
                <span><?php echo $this->lang->line("Categories"); ?></span>
            </a>
        </li>

        <!-- Content Management -->
        <?php
        $content_status = 100;
        if(isset($_GET['content_status']))
            $content_status = $_GET['content_status'];
        ?>
        <li class="<?php if ($last_segment == "content_list" or $last_segment == "add_content" or $last_segment == "edit_content" or $last_segment == "show_content") echo $active_menu;  ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">view_list</i>
                <span><?php echo $this->lang->line("Content Management"); ?></span>
            </a>
            <ul class="ml-menu font-regular">
                <li class="<?php if ($content_status == 1) echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Content/content_list/?content_status=1"; ?>"><?php echo $this->lang->line("Active Content List"); ?></a>
                </li>
                <li class="<?php if ($content_status == 0) echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Content/content_list?content_status=0"; ?>"><?php echo $this->lang->line("Inactive Content List"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "add_content") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Content/add_content"; ?>"><?php echo $this->lang->line("Add Content"); ?></a>
                </li>
            </ul>
        </li>

        <!-- Users Management -->
        <li class="<?php if ($last_segment == "users_list" or $last_segment == "add_user" or $last_segment == "users_role" or $last_segment == "show_user" or $last_segment == "edit_role" or $last_segment == "users_activity") echo $active_menu; ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">people</i>
                <span><?php echo $this->lang->line("Users Management"); ?></span>
            </a>
            <ul class="ml-menu font-regular">
                <li class="<?php if ($last_segment == "users_list") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/users_list"; ?>"><?php echo $this->lang->line("Users List"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "add_user") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/add_user"; ?>"><?php echo $this->lang->line("Add New User"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "users_role") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/users_role" ?>"><?php echo $this->lang->line("Users Roles"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "users_activity") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/users_activity" ?>"><?php echo $this->lang->line("Users Activity"); ?></a>
                </li>
            </ul>
        </li>

        <!-- User Reviews -->
        <li class="<?php if ($last_segment == "users_comments" or $last_segment == "comments_list" or $last_segment == "show_comment") echo $active_menu; ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">chat</i>
                <span><?php echo $this->lang->line("Users Comments"); ?></span>
            </a>
            <ul class="ml-menu font-regular">
                <?php
                $comment_status = 0;
                if(isset($_GET['comment_status']))
                    $comment_status = $_GET['comment_status'];
                ?>
                <li class="<?php if ($last_segment == "comments_list" AND $comment_status == 0) echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/comments_list/?comment_status=0"; ?>"><?php echo $this->lang->line("Not Approved Comments"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "comments_list" AND $comment_status == 1) echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/comments_list/?comment_status=1"; ?>"><?php echo $this->lang->line("Approved Comments"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "comments_list" AND $comment_status == 2) echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/User/comments_list/?comment_status=2"; ?>"><?php echo $this->lang->line("Removed Comments"); ?></a>
                </li>
            </ul>
        </li>

        <!-- Withdrawal Coin -->
        <li class="<?php if ($last_segment == "withdrawal_coins" or $last_segment == "show_withdrawal_coin") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/Withdrawal/withdrawal_coins"; ?>">
                <i class="material-icons">monetization_on</i>
                <span><?php echo $this->lang->line("Withdrawal Coin"); ?></span>
            </a>
        </li>


        <!-- Pages Management -->
        <li class="<?php if ($last_segment == "pages" or $last_segment == "add_page" or $last_segment == "edit_page") echo $active_menu; ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">insert_drive_file</i>
                <span><?php echo $this->lang->line("Pages Management"); ?></span>
            </a>
            <ul class="ml-menu font-regular">
                <li class="<?php if (isset($_GET['s'])) { if ($_GET['s'] == $this->lang->line("Version")) echo $active_menu; } ?>">
                    <a href="<?php echo base_url()."dashboard/Page/pages/?s=".$this->lang->line("Version"); ?>"><?php echo $this->lang->line("Versions List"); ?></a>
                </li>
                <li class="<?php if (isset($_GET['s'])) { if ($_GET['s'] == $this->lang->line("Page")) echo $active_menu; } ?>">
                    <a href="<?php echo base_url()."dashboard/Page/pages/?s=".$this->lang->line("Page"); ?>"><?php echo $this->lang->line("Pages List"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "add_page") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Page/add_page"; ?>"><?php echo $this->lang->line("Add New Page"); ?></a>
                </li>
            </ul>
        </li>

        <!-- Images Slider -->
        <li class="<?php if ($last_segment == "sliders") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/Slider/sliders"; ?>">
                <i class="material-icons">photo_library</i>
                <span><?php echo $this->lang->line("Images Slider"); ?></span>
            </a>
        </li>
		
		<!-- Sending Push Notification -->
        <li class="<?php if ($last_segment == "push_notification") echo $active_menu; ?>">
            <a href="<?php echo base_url()."dashboard/Settings/push_notification"; ?>">
                <i class="material-icons">notifications</i>
                <span><?php echo $this->lang->line("Sending Push Notification"); ?></span>
            </a>
        </li>

        <!-- Settings -->
        <li class="<?php if ($last_segment == "general_settings" or $last_segment == "api_key" or $last_segment == "admob_settings" or $last_segment == "reward_settings" or $last_segment == "email_settings" or $last_segment == "sms_settings" or $last_segment == "bank_gateways") echo $active_menu; ?>">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">settings</i>
                <span><?php echo $this->lang->line("Settings"); ?></span>
            </a>
            <ul class="ml-menu font-regular">
                <li class="<?php if ($last_segment == "general_settings") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Settings/general_settings"; ?>"><?php echo $this->lang->line("General Settings"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "reward_settings") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Settings/reward_settings" ?>"><?php echo $this->lang->line("Reward Configuration"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "admob_settings") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Settings/admob_settings" ?>"><?php echo $this->lang->line("AdMob Configuration"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "email_settings") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Settings/email_settings" ?>"><?php echo $this->lang->line("Send Email"); ?></a>
                </li>
                <li class="<?php if ($last_segment == "api_key") echo $active_menu; ?>">
                    <a href="<?php echo base_url()."dashboard/Settings/api_key" ?>"><?php echo $this->lang->line("API Address"); ?></a>
                </li>
            </ul>
        </li>

        <!-- User Manual -->
        <li class="">
            <a target="_blank" href="http://www.inw24.com/user_manual/multi_purpose/">
                <i class="material-icons">live_help</i>
                <span>Online User Manual</span>
            </a>
        </li>

    </ul>
</div>
<!-- #Menu -->
<!-- Footer -->
<div class="legal" style="direction: <?php echo $this->lang->line("app_direction"); ?>">
    <div class="copyright">
        &copy; <?php if ($this->lang->line("date-format") == "default") echo mdate('%Y'); elseif($this->lang->line("date-format") == "jdf") echo $this->jdf->jdate('Y'); else echo mdate('%Y'); ?> <a target="_blank" href="<?php echo "http://www.inw24.com" ?>"><?php echo $this->lang->line("Footer Copyright"); ?></a>.
    </div>
    <div class="version">
        <b><?php echo $this->lang->line("CodeIgniter"); ?>: </b><span class="font-light"><?php echo CI_VERSION ?></span>
        <b>&nbsp;&nbsp;<?php echo $this->lang->line("App Version"); ?>: </b><span class="font-light"><?php echo $setting_version_string ?></span>
    </div>
</div>
<!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->