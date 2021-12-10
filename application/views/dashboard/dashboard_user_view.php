<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 style="padding-bottom: 7px;"><?php echo $this->lang->line("app_description"); ?></h2>
            <?php
            //Complete Your Profile Alert
            if(empty($userContent->user_firstname))
            {
                ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo $this->lang->line("System Message!"); ?><br></strong><?php echo $this->lang->line("Please update your information (Name & Mobile) to dismiss this warning."); ?>
                    <a style="color: white; text-decoration: none; font-size: 14px; font-weight: 500; border-bottom: 1px #000000 dashed;" href="<?php echo base_url()."dashboard/User/profile/profile_settings"; ?>"><?php echo $this->lang->line("Click Here!"); ?></a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        //Demo alert
        if($_SESSION['user_role_id'] == 4 OR $_SESSION['user_role_id'] == 7) { ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo $this->lang->line("Add / Edit / Remove are disable on demo."); ?>
            </div>
        <?php } ?>

        <!-- 4 Col Hover Expand Effect -->
        <div class="row clearfix">

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Content/add_content"; ?>';">
                <div class="info-box bg-blue hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">view_list</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Add Content"); ?></div>
                        <div class="number">...</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Content/content_list/?content_status=1"; ?>';">
                <div class="info-box bg-purple hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">view_list</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Active Content"); ?></div>
                        <div class="number"><?php echo $activeUserContentCount; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" onclick="window.location.href='<?php echo base_url()."dashboard/Content/content_list/?content_status=0"; ?>';">
                <div class="info-box bg-green hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">view_list</i>
                    </div>
                    <div class="content">
                        <div class="text"><?php echo $this->lang->line("Inactive Content"); ?></div>
                        <div class="number"><?php echo $inactiveUserContentCount; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# 4 Col Hover Expand Effect -->

        <div class="row clearfix">
            <!-- Latest Activity -->
            <div class="col-xs-12 col-sm-12 col-md12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><?php echo $this->lang->line("Latest Activities"); ?></h2>

                    </div>
                    <div class="body">
                        <div style="height: 219px; overflow-y: scroll; overflow-x: hidden">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
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
                                    foreach ($usersUserActivity as $key) {
                                        ?>
                                        <tr>
                                            <td class="font-light"><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->activity_time, now(), 2)." (".unix_to_human($key->activity_time).")";
                                                elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->activity_time, now(), 2)." ".$this->lang->line("ago")." (".$this->jdf->jdate('Y/m/d G:i', $key->activity_time).")";
                                                else echo timespan($key->activity_time, now(), 2); ?></td>
                                            <td class="font-light"><?php if($_SESSION['user_role_id'] == 4) echo $this->lang->line("Hidden"); else echo $key->activity_ip; ?></td>
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
            </div>
            <!-- #END# Latest Orders -->
        </div>

    </div>
</section>

