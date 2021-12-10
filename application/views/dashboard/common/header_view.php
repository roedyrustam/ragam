<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Get app name
$this->db->select('setting_app_name');
$q = $this->db->get_where('setting_table', array('setting_id' => 1));
$setting_app_name = $q->result()[0]->setting_app_name;
?>
<body class="theme-red">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p style="direction: <?php echo $this->lang->line("app_direction"); ?>"><?php echo $this->lang->line("Please wait..."); ?></p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <?php
    $attributes = array('method' => 'get');
    echo form_open(base_url()."dashboard/User/users_list/", $attributes);
    ?>
    <input type="text" id="s" name="s" class="<?php echo $this->lang->line("text-left"); ?>" style="direction: <?php echo $this->lang->line("app_direction"); ?>" placeholder="<?php echo $this->lang->line("search..."); ?>">
    </form>
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header <?php echo $this->lang->line("navbar-left"); ?>">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?php echo base_url()."dashboard/Dashboard" ?>"><?php echo $this->lang->line("app_name"); ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="<?php echo $this->lang->line("pull-right"); ?> nav navbar-nav navbar-right" style="<?php if($this->lang->line("app_direction") == "rtl") echo "margin-left: -55px;"; else echo "margin-left: 40px;"; ?>">

				<li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line("Visit Website");; ?></a></li>

                <!-- Switch Language -->
                <li class="dropdown <?php echo $this->lang->line("pull-left"); ?>">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">language</i>
                        <span class="label-count"><?php echo $this->lang->line("language_code"); ?></span>
                    </a>
                    <ul class="dropdown-menu <?php echo $this->lang->line("pull-left"); ?>" style="max-height: 115px;">
                        <li class="header"><?php echo $this->lang->line("select_default_language"); ?></li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="<?php echo base_url()."LangSwitch/switchDashboardLanguage/english"; ?>">
                                        <img width="26px" height="26px" src="<?php echo base_url()."assets/dashboard/images/language-flag/us.png" ?>">
                                        <div class="menu-info">
                                            <h4><?php echo $this->lang->line("language_english"); ?></h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()."LangSwitch/switchDashboardLanguage/arabic"; ?>">
                                        <img width="26px" height="26px" src="<?php echo base_url()."assets/dashboard/images/language-flag/uae.png" ?>">
                                        <div class="menu-info">
                                            <h4><?php echo $this->lang->line("language_arabic"); ?></h4>
                                        </div>
                                    </a>
                                </li>


                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- #END# Switch Language -->

                <!-- Notifications -->
                <!-- <li class="dropdown <?php echo $this->lang->line("pull-left"); ?>">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count">7</span>
                    </a>
                    <ul class="dropdown-menu <?php echo $this->lang->line("pull-left"); ?>">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>12 new members joined</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 14 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-cyan">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>4 sales made</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 22 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-red">
                                            <i class="material-icons">delete_forever</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy Doe</b> deleted account</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">mode_edit</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy</b> changed name</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 2 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-blue-grey">
                                            <i class="material-icons">comment</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> commented your post</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 4 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">cached</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> updated status</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-purple">
                                            <i class="material-icons">settings</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>Settings updated</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> Yesterday
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Notifications</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Notifications -->

                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->

                <!-- Setting slide -->
                <!--<li class="<?php echo $this->lang->line("pull_right"); ?>"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>-->



            </ul>
        </div>
    </div>
</nav>

