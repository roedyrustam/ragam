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
                <div class="card">
                    <div class="header">
                        <h2>
                            <?php echo $this->lang->line("Edit Role"); ?>
                        </h2>
                    </div>
                    <div class="body">

                        <?php
                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                        echo form_open(base_url()."dashboard/user/edit_role/", $attributes);
                        ?>
                        <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Setting/email_settings/" ?>" enctype="multipart/form-data">-->
                        <div class="form-group">
                            <label for="email_setting_mailtype" class="col-sm-3 control-label"><?php echo $this->lang->line("Account Type"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="user_type_id" name="user_type_id" required>
                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                        <?php
                                        foreach ($userType as $key) {
                                            $user_type_selected = "";
                                            if($key->user_type_id == $userRoleContent->user_type_id)
                                            $user_type_selected = "selected='selected'";
                                            ?>
                                            <option <?php echo $user_type_selected ?> value="<?php echo $key->user_type_id ?>"><?php echo $key->user_type_title ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_role_title" class="col-sm-3 control-label"><?php echo $this->lang->line("Role Title"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="user_role_title" placeholder="<?php echo $this->lang->line("Role Title"); ?>" value="<?php echo $userRoleContent->user_role_title; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_role_price" class="col-sm-3 control-label"><?php echo $this->lang->line("Price")." (".$currencyContent->currency_suffix.")"; ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="user_role_price" value="<?php echo $userRoleContent->user_role_price; ?>" required>
                                </div>
                                <small class="col-grey"><?php echo $this->lang->line("Free role price is: 0")." ".$currencyContent->currency_suffix; ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_role_permission" class="col-sm-3 control-label"><?php echo $this->lang->line("Permission"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <textarea class="form-control" name="user_role_permission" rows="8" style="direction: ltr" required><?php echo $userRoleContent->user_role_permission; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_role_status" class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <?php
                                    $user_role_status_checked = "";
                                    if($userRoleContent->user_role_status == 1)
                                        $user_role_status_checked = "checked";
                                    ?>
                                    <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_role_status" name="user_role_status" <?php echo $user_role_status_checked; ?>>
                                    <label for="user_role_status"><?php echo $this->lang->line("Enable this role"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="hidden" readonly name="user_role_id" value="<?php echo $userRoleContent->user_role_id; ?>" required>
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
                </div>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
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
                            <?php echo $this->lang->line("Guide"); ?>
                        </h2>
                    </div>
                    <div class="body">
                        <p class="text-justify"><?php echo $this->lang->line("how-to-set-permission-text"); ?></p>
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
<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #user_role_id").val(my_id_value);
        })
    });
</script>
