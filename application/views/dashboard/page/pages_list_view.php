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
                    <?php echo $this->lang->line("Pages List"); ?>
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
                                <?php echo $this->lang->line("Pages List"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/Page/add_page"; ?>"><?php echo $this->lang->line("Add New Page"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="table-responsive">
                                    <table id="pagesList" class="table table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line("Page Title"); ?></th>
                                            <th><?php echo $this->lang->line("Type"); ?></th>
                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($pagesList as $key) {
                                        if ($key->page_type == 1) $page_type = "<span class='label bg-purple'>".$this->lang->line("News")."</span>";
                                        if ($key->page_type == 2) $page_type = "<span class='label bg-orange'>".$this->lang->line("Annunciation")."</span>";
                                        if ($key->page_type == 3) $page_type = "<span class='label bg-light-blue'>".$this->lang->line("Page")."</span>";
                                        if ($key->page_type == 4) $page_type = "<span class='label bg-pink'>".$this->lang->line("Version")."</span>";
                                        if ($key->page_status == 1) $page_status = "<span class='label label-success'>".$this->lang->line("Active")."</span>";
                                        if ($key->page_status == 0) $page_status = "<span class='label label-danger'>".$this->lang->line("Inactive")."</span>";
                                        ?>
                                        <tr>
                                            <td><?php echo $key->page_id; ?></td>
                                            <td style="min-width: 200px;"><a title="<?php echo $key->page_title; ?>" href="<?php echo base_url()."dashboard/Page/edit_page/$key->page_id"; ?>"><?php echo $key->page_title; ?></a></td>
                                            <td><?php echo $page_type; ?></td>
                                            <td><?php echo $page_status; ?></td>
                                            <td style="min-width: 110px; width: 110px;">
                                                <div class="demo-button-toolbar clearfix">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group" role="group" aria-label="First group">
                                                            <a href="<?php echo base_url()."dashboard/Page/edit_page/$key->page_id"; ?>" type="button" class="btn btn-xs btn-primary waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">mode_edit</i>&nbsp;</a>
                                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $key->page_id; ?>" type="button" class="identifyingClass btn btn-xs btn-danger waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">cancel</i>&nbsp;</a>
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
                                </div>
                            </div>
                        </div>
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
                        echo form_open(base_url()."dashboard/Page/delete_page/", $attributes);
                        ?>
                        <input type="hidden" readonly="readonly" name="page_id" id="page_id" value="" required/>
                        <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn btn-danger waves-effect"><?php echo $this->lang->line("Yes"); ?></button>&nbsp;&nbsp;
                        <button type="button" class="btn bg-grey waves-effect col-white" data-dismiss="modal"><?php echo $this->lang->line("Cancel"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Small deleteModal Size -->
    </section>


<?php
$this->load->view('dashboard/common/footer_view');
?>
<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<!--<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('#pagesList').DataTable({
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : true,
            "order": [[0,'desc']],
            "pageLength":25,
            "columnDefs": [
                { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
                { "targets": 1, "name": "title", 'searchable':true, 'orderable':true},
                { "targets": 2, "name": "type", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "status", 'searchable':true, 'orderable':true},
                { "targets": 4, "name": "action", 'searchable':false, 'orderable':false,'width':'110px'},
            ],
            "language": {
                paginate: {
                    next: '<?php echo $this->lang->line("Next"); ?>', // or '→' '&#8594;'
                    previous: '<?php echo $this->lang->line("Previous"); ?>', // or '←' ' &#8592;'
                    first:      '<?php echo $this->lang->line("First"); ?>',
                    last:       '<?php echo $this->lang->line("Last"); ?>',
                },
                "aria": {
                    sortAscending:  ': activate to sort column ascending',
                    sortDescending: ': activate to sort column descendin',
                },
                "zeroRecords": '<?php echo $this->lang->line("No Data Found"); ?>',
                "sLengthMenu": '<?php echo $this->lang->line("Display"); ?> _MENU_ <?php echo $this->lang->line("records"); ?>',
                "search": '<?php echo $this->lang->line("Search"); ?>',
                "infoFiltered": '(<?php echo $this->lang->line("filtered from"); ?> _MAX_ <?php echo $this->lang->line("total records"); ?>)',
                "info": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "infoEmpty": '<?php echo $this->lang->line("Showing"); ?> _START_ <?php echo $this->lang->line("to"); ?> _END_ <?php echo $this->lang->line("of"); ?> _TOTAL_ <?php echo $this->lang->line("entries"); ?>',
                "loadingRecords": '<?php echo $this->lang->line("Loading..."); ?>',
                "processing":     '<?php echo $this->lang->line("Processing..."); ?>',
                "emptyTable":     '<?php echo $this->lang->line("No data available in table"); ?>',
            }
        });
    });
</script>

<!-- Pass user_role_id into the deleteModal -->
<script type="text/javascript">
    $(function () {
        $(".identifyingClass").click(function () {
            var my_id_value = $(this).data('id');
            $(".modal-footer #page_id").val(my_id_value);
        })
    });
</script>