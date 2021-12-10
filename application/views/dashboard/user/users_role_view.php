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
                                <?php echo $this->lang->line("Users Roles"); ?>
                            </h2>
                        </div>
                        <div class="body">

                            <!-- Striped Rows -->
                            <div class="row clearfix">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line("Role Title"); ?></th>
                                            <th><?php echo $this->lang->line("Price")." (".$currencyContent->currency_suffix.")"; ?></th>
                                            <th><?php echo $this->lang->line("Type"); ?></th>
                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($userRole as $key) {
                                            if ($key->user_type_id == 1) $user_type = "<span class='label bg-orange'>$key->user_type_title</span>";
                                            if ($key->user_type_id == 2) $user_type = "<span class='label bg-grey'>$key->user_type_title</span>";
                                            if ($key->user_role_status == 1) $role_status = "<span class='label label-success'>".$this->lang->line("Active")."</span>";
                                            if ($key->user_role_status == 2) $role_status = "<span class='label label-danger'>".$this->lang->line("Inactive")."</span>";
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $key->user_role_id; ?></th>
                                                <td><?php echo $key->user_role_title; ?></td>
                                                <td><?php echo number_format($key->user_role_price, $currencyContent->currency_decimals); ?></td>
                                                <td><?php echo $user_type; ?></td>
                                                <td><?php echo $role_status; ?></td>
                                                <td style="width: 80px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <?php echo $this->lang->line("Action"); ?> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo base_url()."dashboard/User/edit_role/$key->user_role_id"; ?>"><i class="material-icons">mode_edit</i> <?php echo $this->lang->line("Edit"); ?></a></li>
                                                            <li><a href="#" class="identifyingClass waves-effect" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $key->user_role_id; ?>"><i class="material-icons">cancel</i> <?php echo $this->lang->line("Delete"); ?></a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- #END# Striped Rows -->

                            <!-- Small deleteModal Size -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="smallModalLabel"><?php echo $this->lang->line("Delete confirmation!"); ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo $this->lang->line("Are you sure to delete this item?"); ?>
                                        </div>
                                        <div class="modal-footer" style="text-align: center">
                                            <?php
                                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                            echo form_open(base_url()."dashboard/User/delete_role/", $attributes);
                                            ?>
                                            <input type="hidden" readonly="readonly" name="user_role_id" id="user_role_id" value="" required/>
                                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn btn-danger waves-effect"><?php echo $this->lang->line("Yes"); ?></button>&nbsp;&nbsp;
                                            <button type="button" class="btn bg-grey waves-effect col-white" data-dismiss="modal"><?php echo $this->lang->line("Cancel"); ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# Small deleteModal Size -->

                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Add New Role"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/User/add_user"; ?>"><?php echo $this->lang->line("Add New User"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/User/users_list"; ?>"><?php echo $this->lang->line("Users List"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">

                            <?php
                            $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                            echo form_open(base_url()."dashboard/user/users_role/", $attributes);
                            ?>
                            <!--<form class="form-horizontal" method="post" action="<?php echo base_url()."dashboard/Setting/email_settings/" ?>" enctype="multipart/form-data">-->
                            <div class="form-group">
                                <label for="email_setting_mailtype" class="col-sm-4 control-label"><?php echo $this->lang->line("Account Type"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="user_type_id" name="user_type_id" required>
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

                            <div class="form-group">
                                <label for="user_role_title" class="col-sm-4 control-label"><?php echo $this->lang->line("Role Title"); ?> *</label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="user_role_title" placeholder="<?php echo $this->lang->line("Role Title"); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_role_price" class="col-sm-4 control-label"><?php echo $this->lang->line("Price")." (".$currencyContent->currency_suffix.")"; ?></label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="user_role_price" value="0">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Free role price is: 0 coin"); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_role_status" class="col-sm-4 control-label"><?php echo $this->lang->line("Status"); ?></label>
                                <div class="col-sm-8">
                                    <div class="form-line">
                                        <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="user_role_status" name="user_role_status" checked>
                                        <label for="user_role_status"><?php echo $this->lang->line("Enable this role"); ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
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
<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #user_role_id").val(my_id_value);
        })
    });
</script>
