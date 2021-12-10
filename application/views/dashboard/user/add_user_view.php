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
                    <?php echo $this->lang->line("User's List"); ?>
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
                                <?php echo $this->lang->line("Add New User"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/User/users_list"; ?>"><?php echo $this->lang->line("Users List"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/User/users_role"; ?>"><?php echo $this->lang->line("Users Roles"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/User/add_user/", $attributes);
                            //form_open_multipart//For Upload
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/User/add_user/" ?>" enctype="multipart/form-data">-->

                                <div class="form-group">
                                    <label for="user_username" class="col-sm-3 control-label"><?php echo $this->lang->line("Username"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="user_username" minlength="5" maxlength="30" placeholder="<?php echo $this->lang->line("Username"); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_email" class="col-sm-3 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="user_email" minlength="5" maxlength="60" placeholder="<?php echo $this->lang->line("Email"); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_password" class="col-sm-3 control-label"><?php echo $this->lang->line("Password"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="user_password" minlength="8" maxlength="30" placeholder="<?php echo $this->lang->line("Password"); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_referral" class="col-sm-3 control-label"><?php echo $this->lang->line("Referral ID"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="user_referral" maxlength="30" placeholder="<?php echo $this->lang->line("Referral ID"); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_type_id" class="col-sm-3 control-label"><?php echo $this->lang->line("Account Type"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="user_type_id" name="user_type_id" onChange="getUserRole(this.value);" required>
                                                <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                <?php
                                                foreach ($userType as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->user_type_id ?>"><?php echo $key->user_type_title ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function getUserRole(val) {
                                        $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url() . "dashboard/User/get_role_from_type"; ?>",
                                            data:"user_type_id="+val,
                                            success: function(data){
                                                //$("#user_role_id").html(data);//
                                                $("#user_role_id").html(data).selectpicker('refresh');//After AJAX is done, you need to reload the plugin: bootstrap-select
                                            }
                                        });
                                    }
                                </script>

                                <div class="form-group">
                                    <label for="user_role_id" class="col-sm-3 control-label"><?php echo $this->lang->line("User Role"); ?> *</label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="user_role_id" name="user_role_id" required>
                                                <option selected="selected" disabled><?php echo $this->lang->line("--- First Select Account Type ---"); ?></option>
                                                <?php
                                                /*foreach ($userRole as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->user_role_id ?>"><?php echo $key->user_role_title ?></option>
                                                    <?php
                                                }*/
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="send_email" class="col-sm-3 control-label"><?php echo $this->lang->line("Send Email"); ?></label>
                                    <div class="col-sm-9">
                                        <div class="form-line">
                                            <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="send_email" name="send_email">
                                            <label class="" for="send_email"><?php echo $this->lang->line("Send registration information to user."); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input type="hidden" name="user_reg_from" value="1" readonly="readonly" required>
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