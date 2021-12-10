<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
        $last_segment2 = $this->uri->segment(4);
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
                    <a href="<?php echo base_url()."dashboard/User/profile"; ?>">
                        <i class="material-icons">person</i>
                        <span><?php echo $this->lang->line("My Profile"); ?></span>
                    </a>
                </li>

                <!-- Content Management -->
                <li class="<?php if ($last_segment == "content_list" or $last_segment == "add_content" or $last_segment == "edit_content" or $last_segment == "show_content") echo $active_menu;  ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">view_list</i>
                        <span><?php echo $this->lang->line("Content Management"); ?></span>
                    </a>
                    <ul class="ml-menu font-regular">
                        <li class="<?php if ($last_segment == "content_list") echo $active_menu; ?>">
                            <a href="<?php echo base_url()."dashboard/Content/content_list"; ?>"><?php echo $this->lang->line("Content List"); ?></a>
                        </li>
                        <li class="<?php if ($last_segment == "add_content") echo $active_menu; ?>">
                            <a href="<?php echo base_url()."dashboard/Content/add_content"; ?>"><?php echo $this->lang->line("Add Content"); ?></a>
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
                <b>&nbsp;&nbsp;<?php echo $this->lang->line("App Version"); ?>: </b><span class="font-light">1.0.0</span>
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->