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
                    <?php echo $this->lang->line("Withdrawal Coins List"); ?>
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
                                <?php echo $this->lang->line("Withdrawal Coins List"); ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
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
                                            <th><?php echo $this->lang->line("Account Type"); ?></th>
                                            <th><?php echo $this->lang->line("Coin(s)"); ?></th>
                                            <th><?php echo $this->lang->line("Cash"); ?></th>
                                            <th><?php echo $this->lang->line("Time"); ?></th>
                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($withdrawalCoinsList as $key) {
                                        if ($key->withdrawal_status == 1) $withdrawal_status = "<span class='label bg-grey'>".$this->lang->line("Withdrawal Pending")."</span>";
                                        if ($key->withdrawal_status == 2) $withdrawal_status = "<span class='label bg-green'>".$this->lang->line("Withdrawal Paid")."</span>";
                                        if ($key->withdrawal_status == 3) $withdrawal_status = "<span class='label bg-red'>".$this->lang->line("Withdrawal Cancel")."</span>";
                                        ?>
                                        <tr>
                                            <td><?php echo $key->withdrawal_id; ?></td>
                                            <td><?php echo $key->withdrawal_account_type_title; ?></td>
                                            <td><?php echo $key->withdrawal_req_coin; ?></td>
                                            <td>$ <?php echo $key->withdrawal_req_cash; ?></td>
                                            <td class="font-light"><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($key->withdrawal_req_date, now(), 2)." ".$this->lang->line("ago");
                                                elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($key->withdrawal_req_date, now(), 2)." ".$this->lang->line("ago");
                                                else echo timespan($key->withdrawal_req_date, now(), 2); ?></td>
                                            <td><?php echo $withdrawal_status; ?></td>
                                            <td style="min-width: 110px; width: 110px;">
                                                <div class="demo-button-toolbar clearfix">
                                                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group" role="group" aria-label="First group">
                                                            <a href="<?php echo base_url()."dashboard/Withdrawal/show_withdrawal_coin/$key->withdrawal_id"; ?>" type="button" class="btn btn-xs btn-primary waves-effect">&nbsp;<i class="material-icons" style="font-size: 18px">remove_red_eye</i>&nbsp;</a>
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
                { "targets": 1, "name": "account_type", 'searchable':true, 'orderable':true},
                { "targets": 2, "name": "coin", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "cash", 'searchable':true, 'orderable':true},
                { "targets": 4, "name": "time", 'searchable':true, 'orderable':true},
                { "targets": 5, "name": "status", 'searchable':true, 'orderable':true},
                { "targets": 6, "name": "action", 'searchable':false, 'orderable':false,'width':'110px'},
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
