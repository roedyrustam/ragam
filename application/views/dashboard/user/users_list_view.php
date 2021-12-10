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
                    <?php echo $this->lang->line("User's List"); ?>
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
                                <?php echo $this->lang->line("Users List"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/User/add_user"; ?>"><?php echo $this->lang->line("Add New User"); ?></a></li>
                                        <li><a href="<?php echo base_url()."dashboard/User/users_role"; ?>"><?php echo $this->lang->line("Users Roles"); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover dataTable" id="ajax_users_list">
                                    <thead>
                                    <tr>
                                        <td scope="row">#</td>
                                        <th><?php echo $this->lang->line("Username"); ?></th>
                                        <th><?php echo $this->lang->line("First Name"); ?></th>
                                        <th><?php echo $this->lang->line("Last Name"); ?></th>
                                        <th><?php echo $this->lang->line("Email"); ?></th>
                                        <th><?php echo $this->lang->line("Device"); ?></th>
                                        <th><?php echo $this->lang->line("Type"); ?></th>
                                        <th><?php echo $this->lang->line("Role"); ?></th>
                                    </tr>
                                    </thead>
                                    <!--<tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>-->
                                </table>
                            </div>
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

    var user_id;
    $(document).ready(function () {
        $('#ajax_users_list').DataTable({
            "processing": true,
            "serverSide": true,
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : true,
            "order": [[0,'desc']],
            "columnDefs": [
                { "targets": 0, "name": "user_id", 'searchable':false, 'orderable':true, "data": "HyperLink", "render": function (data_user_id, type, row, meta ) {
                    user_idd = data_user_id;
                    return '<a href="<?php echo base_url()."dashboard/User/show_user"; ?>/' + data_user_id + '">' + data_user_id + '</a>';}},
                { "targets": 1, "name": "user_username", 'searchable':true, 'orderable':true, "data": "HyperLink", "render": function (data_user_username, type, row, meta ) {
                    return '<a href="<?php echo base_url()."dashboard/User/show_user"; ?>/' + user_idd + '">' + data_user_username + '</a>';}},
                { "targets": 2, "name": "user_firstname", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "user_lastname", 'searchable':true, 'orderable':true},
                { "targets": 4, "name": "user_email", 'searchable':true, 'orderable':true},
                { "targets": 5, "name": "device_type_title", 'searchable':true, 'orderable':true},
                { "targets": 6, "name": "user_type_title", 'searchable':true, 'orderable':true,'width':'60px'},
                { "targets": 7, "name": "user_role_title", 'searchable':true, 'orderable':true,'width':'90px'},
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
            },
            "ajax":{
                "url": "<?php echo base_url('dashboard/User/ajax_users_list') ?>",
                "dataType": "json",
                "type": "POST",
                "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
            },
            "columns": [
                { "data": "user_id" },
                { "data": "user_username" },
                { "data": "user_firstname" },
                { "data": "user_lastname" },
                { "data": "user_email" },
                { "data": "device_type_title" },
                { "data": "user_type_title" },
                { "data": "user_role_title" },
            ],
        });

    });
</script>