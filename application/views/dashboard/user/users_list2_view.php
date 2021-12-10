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
                                <table class="table table-striped table-hover dataTable" id="users_list2">
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
                                    <tbody>
									<?php
                                        foreach ($usersList2 as $key) {
                                        ?>
                                    <tr>
                                        <td><a href="<?php echo base_url()."dashboard/User/show_user/$key->user_id"; ?>"><?php echo $key->user_id; ?></a></td>
                                        <td><a href="<?php echo base_url()."dashboard/User/show_user/$key->user_id"; ?>"><?php echo $key->user_username; ?></a></td>
                                        <td><?php echo $key->user_firstname; ?></td>
                                        <td><?php echo $key->user_lastname; ?></td>
                                        <td><?php echo $key->user_email; ?></td>
                                        <td><?php echo $key->device_type_title; ?></td>
                                        <td><?php echo $key->user_type_title; ?></td>
                                        <td><?php echo $key->user_role_title; ?></td>
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
            <!-- #END# Basic Examples -->
        </div>
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
        $('#users_list2').DataTable({
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : true,
            "order": [[0,'desc']],
            "columnDefs": [
                { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
                { "targets": 1, "name": "username", 'searchable':true, 'orderable':true},
                { "targets": 2, "name": "firstname", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "lastname", 'searchable':true, 'orderable':true},
                { "targets": 4, "name": "email", 'searchable':true, 'orderable':true},
                { "targets": 5, "name": "devicetype", 'searchable':true, 'orderable':true},
                { "targets": 6, "name": "usertype", 'searchable':true, 'orderable':true},
                { "targets": 7, "name": "userrol", 'searchable':true, 'orderable':true},
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