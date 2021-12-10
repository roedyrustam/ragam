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
            <!--<div class="block-header">
                <h2>
                    <?php echo $this->lang->line("Sending Push Notification"); ?>
                </h2>
            </div>-->
            <!-- Basic Examples -->
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
                                <?php echo $this->lang->line("Sending Push Notification To All User"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard/"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open_multipart(base_url()."dashboard/Settings/push_notification/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/add_user/" ?>" enctype="multipart/form-data">-->
                                <div class="form-group">
                                    <label for="push_notification_title" class="col-sm-3 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="push_notification_title" minlength="2" maxlength="50" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="push_notification_message" class="col-sm-3 control-label"><?php echo $this->lang->line("Message"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <textarea class="form-control" name="push_notification_message" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="push_notification_external_link" class="col-sm-3 control-label"><?php echo $this->lang->line("URL")." ".$this->lang->line("(optional)"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="url" class="form-control" name="push_notification_external_link" placeholder="http://www.Google.com">
                                        </div>
                                        <small class="col-pink"><?php echo $this->lang->line("Enter this field only if you want to open a specific website URL."); ?></small>
                                    </div>
                                </div>

								<div class="form-group">
									<label for="push_notification_image" class="col-sm-3 control-label"><?php echo $this->lang->line("Image")." ".$this->lang->line("(optional)"); ?></label>
									<div class="col-sm-9">
										<div class="form-line">
											<input type="file" name="push_notification_image" multiple>
										</div>
										<small class="col-pink"><?php echo $this->lang->line("Best image ratio for push notification"); ?></small>
									</div>
								</div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
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
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hidden">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Sending Push Notification To Specific User"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard/"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/Settings/push_notification/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/add_user/" ?>" enctype="multipart/form-data">-->
                                <div class="form-group">
                                    <label for="push_notification_player_id" class="col-sm-3 control-label"><?php echo $this->lang->line("User"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="push_notification_player_id" name="push_notification_player_id" data-live-search="true" data-show-subtext="true" required>
                                                <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                <?php
                                                foreach ($pushNotificationUserList as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->user_onesignal_player_id ?>"><?php echo $key->user_username ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="push_notification_title" class="col-sm-3 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="push_notification_title" minlength="2" maxlength="50" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="push_notification_message" class="col-sm-3 control-label"><?php echo $this->lang->line("Message"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <textarea class="form-control" name="push_notification_message" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="push_notification_external_link" class="col-sm-3 control-label"><?php echo $this->lang->line("URL")." ".$this->lang->line("(optional)"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="url" class="form-control" name="push_notification_external_link" placeholder="http://www.Google.com">
                                        </div>
                                        <small class="col-pink">Enter this field only if you want to open a specific website URL.</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
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
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>


<?php
$this->load->view('dashboard/common/footer_view');
?>
<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    } );
</script>
