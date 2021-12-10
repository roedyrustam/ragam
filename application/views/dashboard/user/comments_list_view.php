<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Data Table Server Side: https://shareurcodes.com/blog/dataTables%20server-side%20processing%20in%20codeigniter
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
                    <?php echo $this->lang->line("Approved Comments"); ?>
                </h2>
            </div>-->
            <!-- Basic Examples -->
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
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php
                                $comment_status = 3;
                                if(isset($_GET['comment_status']))
                                    $comment_status = $_GET['comment_status'];

                                if($comment_status == 0)
                                    echo $this->lang->line("Not Approved Comments");
                                else if($comment_status == 1)
                                    echo $this->lang->line("Approved Comments");
                                else if($comment_status == 2)
                                    echo $this->lang->line("Removed Comments");
                                else
                                    echo $this->lang->line("Users Comments");
                                ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a data-toggle="modal" data-target="#contentSearchModal" href="#<?php echo base_url()."dashboard/Content/content_list"; ?>"><?php echo $this->lang->line("Comment Search"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="table-responsive">
                                    <table id="pagesList" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 110px;"><?php echo $this->lang->line("Sender"); ?></th>
                                            <th style="width: 180px;"><?php echo $this->lang->line("Game"); ?></th>
                                            <th style="width: 90px;"><?php echo $this->lang->line("Device"); ?></th>
                                            <th><?php echo $this->lang->line("Comment"); ?></th>
                                            <th style="width: 130px;"><?php echo $this->lang->line("Rating"); ?></th>
                                            <th style="width: 180px;"><?php echo $this->lang->line("Publish Date"); ?></th>
                                            <th style="width: 105px;"><?php echo $this->lang->line("Status"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($commentList as $key) {
                                            if ($key->comment_status == 0) $comment_status = "<span class='label bg-grey'>".$this->lang->line("Not Approved")."</span>";
                                            if ($key->comment_status == 1) $comment_status = "<span class='label label-success'>".$this->lang->line("Approved")."</span>";
                                            if ($key->comment_status == 2) $comment_status = "<span class='label label-danger'>".$this->lang->line("Removed")."</span>";

                                            if ($key->comment_rate == 0.5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_half</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 1) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 1.5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_half</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 2) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 2.5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_half</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 3) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 3.5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_half</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 4) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_border</i>";
                                            if ($key->comment_rate == 4.5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star_half</i>";
                                            if ($key->comment_rate == 5) $comment_rate = "<i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i><i class='material-icons' style='font-size: 21px; color: #ff8800;'>star</i>";
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo base_url()."dashboard/User/show_user/$key->user_id"; ?>"><?php echo $key->user_username; ?></a></td>
                                            <td><a href="<?php echo base_url()."dashboard/Content/edit_content/$key->content_id"; ?>"><?php echo $key->content_title; ?></a></td>
                                            <td><?php echo $key->device_type_title; ?></td>
                                            <td><?php echo $key->comment_text ; ?></td>
                                            <td><?php echo $comment_rate ; ?></td>
                                            <td class="font-light"><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->comment_time, now(), 2)." ".$this->lang->line("ago");
                                                elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->comment_time, now(), 2)." ".$this->lang->line("ago");
                                                else echo timespan($key->comment_time, now(), 2); ?></td>
                                            <td><?php echo $comment_status; ?></td>
                                            <td style="min-width: 160px; width: 160px;">
                                                <div class="demo-button-toolbar clearfix">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group" role="group" aria-label="First group">
                                                            <!--<a href="#<?php echo base_url()."dashboard/User/show_content/$key->comment_id"; ?>" type="button" class="btn btn-xs bg-indigo waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">remove_red_eye</i>&nbsp;</a>-->
                                                            <?php
                                                            if ($key->comment_status == 0 OR $key->comment_status == 2) {
                                                            ?>
                                                                <a href="<?php echo base_url() . "dashboard/User/edit_comment_status/$key->comment_id/1"; ?>" type="button" class="btn btn-xs btn-success waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">check</i>&nbsp;</a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($key->comment_status == 1) {
                                                                ?>
                                                                <a href="#" type="button" disabled class="btn btn-xs btn-success waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">check</i>&nbsp;</a>
                                                                <?php
                                                            }
                                                            ?>
                                                            <a href="<?php echo base_url()."dashboard/User/show_comment/$key->comment_id"; ?>" type="button" class="btn btn-xs btn-info waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">remove_red_eye</i>&nbsp;</a>
                                                            <?php
                                                            if ($key->comment_status != 2) {
                                                                ?>
                                                                <a href="<?php echo base_url() . "dashboard/User/edit_comment_status/$key->comment_id/2"; ?>" type="button" class="btn btn-xs bg-red waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">cancel</i>&nbsp;</a>
                                                                <?php
                                                            }
                                                            if ($key->comment_status == 2) {
                                                            ?>
                                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $key->comment_id; ?>" type="button" class="identifyingClass btn btn-xs btn-danger waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">delete_forever</i>&nbsp;</a>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    if(empty($commentList)) {
                                        $msg = $this->lang->line("Nothing Found...");
                                        echo "<br><p class='text-center'>$msg</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        {
                            //Show Pagination
                            echo $Links;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>

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
                        echo form_open(base_url()."dashboard/User/delete_comment/", $attributes);
                        ?>
                        <input type="hidden" readonly="readonly" name="comment_id" id="comment_id" value="" required/>
                        <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn btn-danger waves-effect"><?php echo $this->lang->line("Yes"); ?></button>&nbsp;&nbsp;
                        <button type="button" class="btn bg-grey waves-effect col-white" data-dismiss="modal"><?php echo $this->lang->line("Cancel"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Small deleteModal Size -->
    </section>

<!-- Content Search Modal -->
<div class="modal fade" id="contentSearchModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"><?php echo $this->lang->line("Content Search"); ?></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="get">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                            <label for="email_address_2"><?php echo $this->lang->line("Keyword"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="<?php echo $this->lang->line("search..."); ?>">
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <!--<div class="row clearfix">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                            <label for="content_type"><?php echo $this->lang->line("Content Type"); ?></label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="content_type" name="content_type">
                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                        <?php
                                        foreach ($contentType as $key) {
                                            ?>
                                            <option value="<?php echo $key->content_type_id; ?>"><?php echo $key->content_type_title; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <br>
                    <div class="row clearfix">
                        <div class="col-lg-offset-3 col-md-offset-3 col-sm-offset-4 col-xs-offset-5">
                            <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect" style="color: white;"><?php echo $this->lang->line("Search"); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('dashboard/common/footer_view');
?>

<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #comment_id").val(my_id_value);
        })
    });
</script>