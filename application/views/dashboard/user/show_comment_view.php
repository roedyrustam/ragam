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
                            <?php echo $this->lang->line("Show Comment"); ?>
                        </h2>
                    </div>
                    <div class="body">
                        <?php
                        if ($oneComment->comment_status == 0) $comment_status = "<span class='label bg-grey'>".$this->lang->line("Not Approved")."</span>";
                        if ($oneComment->comment_status == 1) $comment_status = "<span class='label label-success'>".$this->lang->line("Approved")."</span>";
                        if ($oneComment->comment_status == 2) $comment_status = "<span class='label label-danger'>".$this->lang->line("Removed")."</span>";
                        ?>
                        <table style="width:100%;">
                            <tr style="height: 32px;">
                                <th style="width: 105px;"><?php echo $this->lang->line("Sender"); ?></th>
                                <td><a href="<?php echo base_url()."dashboard/User/show_user/$oneComment->user_id"; ?>"><?php echo $oneComment->user_username; ?></a></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("Game"); ?></th>
                                <td><a href="<?php echo base_url()."dashboard/Content/edit_content/$oneComment->content_id"; ?>"><?php echo $oneComment->content_title; ?></a></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("Device"); ?></th>
                                <td><?php echo $oneComment->device_type_title; ?></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("IP"); ?></th>
                                <td><?php if($_SESSION['user_role_id'] == 4) echo $this->lang->line("Hidden"); else echo $oneComment->comment_user_ip; ?></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("User Agent"); ?></th>
                                <td><?php if($_SESSION['user_role_id'] == 4) echo $this->lang->line("Hidden"); else echo $oneComment->comment_user_agent; ?></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("Publish Date"); ?></th>
                                <td><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($oneComment->comment_time, now(), 2)." ".$this->lang->line("ago")." (".unix_to_human($oneComment->comment_time).")";
                                    elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($oneComment->comment_time, now(), 2)." ".$this->lang->line("ago")." (".$this->jdf->jdate('Y/m/d G:i', $oneComment->comment_time).")";
                                    else echo timespan($oneComment->activity_time, now(), 2)." ".$this->lang->line("ago"); ?></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <td><?php echo $comment_status; ?></td>
                            <tr style="height: 32px;">
                                <th><?php echo $this->lang->line("Comment"); ?></th>
                                <td><?php echo $oneComment->comment_text; ?></td>
                            </tr>
                            <tr style="height: 32px;">
                                <th></th>
                                <td><br>
                                    <div class="demo-button-toolbar clearfix">
                                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <!--<a href="#<?php echo base_url()."dashboard/User/show_content/$oneComment->comment_id"; ?>" type="button" class="btn btn-xs bg-indigo waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">remove_red_eye</i>&nbsp;</a>-->
                                                <?php
                                                if ($oneComment->comment_status == 0 OR $oneComment->comment_status == 2) {
                                                    ?>
                                                    <a href="<?php echo base_url() . "dashboard/User/edit_comment_status/$oneComment->comment_id/1"; ?>" type="button" class="btn btn-xs btn-success waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">check</i>&nbsp;</a>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($oneComment->comment_status == 1) {
                                                    ?>
                                                    <a href="#" type="button" disabled class="btn btn-xs btn-success waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">check</i>&nbsp;</a>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($oneComment->comment_status != 2) {
                                                    ?>
                                                    <a href="<?php echo base_url() . "dashboard/User/edit_comment_status/$oneComment->comment_id/2"; ?>" type="button" class="btn btn-xs bg-red waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">cancel</i>&nbsp;</a>
                                                    <?php
                                                }
                                                if ($oneComment->comment_status == 2) {
                                                    ?>
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $oneComment->comment_id; ?>" type="button" class="identifyingClass btn btn-xs btn-danger waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">delete_forever</i>&nbsp;</a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                </td>
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
<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #user_role_id").val(my_id_value);
        })
    });
</script>
