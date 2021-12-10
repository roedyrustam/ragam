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
                    <?php echo $this->lang->line("Content List"); ?>
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
                                <?php echo $this->lang->line("Content List"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Content/add_content"; ?>"><?php echo $this->lang->line("Add Content"); ?></a></li>
                                        <li><a data-toggle="modal" data-target="#contentSearchModal" href="#<?php echo base_url()."dashboard/Content/content_list"; ?>"><?php echo $this->lang->line("Content Search"); ?></a></li>
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
                                            <th>#</th>
                                            <th><?php echo $this->lang->line("Title"); ?></th>
                                            <th><?php echo $this->lang->line("Category"); ?></th>
                                            <th><?php echo $this->lang->line("Image"); ?></th>
                                            <th><?php echo $this->lang->line("View"); ?></th>
                                            <th><?php echo $this->lang->line("Publish Date"); ?></th>
                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($contentList as $key) {
                                        if ($key->content_status == 0) $content_status = "<span class='label label-danger'>".$this->lang->line("Inactive")."</span>";
                                        if ($key->content_status == 1) $content_status = "<span class='label label-success'>".$this->lang->line("Active")."</span>";
                                        if ($key->content_status == 2) $content_status = "<span class='label bg-grey'>".$this->lang->line("Expired")."</span>";
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo base_url()."dashboard/Content/edit_content/".$key->content_id; ?>"><?php echo $key->content_id; ?></a></td>
                                            <td><?php echo $key->content_title; ?></td>
                                            <td><?php echo $key->category_title; ?></td>
                                            <td><img class="img-rounded" alt="Category" width="80px" height="52" src="<?php echo base_url()."assets/upload/content/thumbnail/$key->content_image" ?>"></td>
                                            <td><?php echo $key->content_viewed; ?></td>
                                            <td>
                                                <?php
                                                if ($this->lang->line("date-format") == "default") echo mdate('%Y/%m/%d - %H:%i', $key->content_publish_date);
                                                elseif($this->lang->line("date-format") == "jdf") echo $this->jdf->jdate('Y/m/d - H:i', $key->content_publish_date);
                                                else echo mdate('%Y/%m/%d - %H:%i', $key->content_publish_date);
                                                ?>
                                            </td>
                                            <td><?php echo $content_status; ?></td>
                                            <td style="min-width: 160px; width: 160px;">
                                                <div class="demo-button-toolbar clearfix">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group" role="group" aria-label="First group">
															<a target="_blank" href="<?php echo base_url()."Web/content/$key->content_id/$key->content_slug/"; ?>" type="button" class="btn btn-xs bg-indigo waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">remove_red_eye</i>&nbsp;</a>
                                                            <a href="<?php echo base_url()."dashboard/Content/edit_content/$key->content_id"; ?>" type="button" class="btn btn-xs btn-primary waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">mode_edit</i>&nbsp;</a>
                                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $key->content_id; ?>" type="button" class="identifyingClass btn btn-xs btn-danger waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">cancel</i>&nbsp;</a>
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
                                    if(empty($contentList)) {
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
                        echo form_open(base_url()."dashboard/Content/delete_content/", $attributes);
                        ?>
                        <input type="hidden" readonly="readonly" name="content_id" id="content_id" value="" required/>
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
            $(".modal-footer #content_id").val(my_id_value);
        })
    });
</script>
