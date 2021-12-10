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
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $this->lang->line("Categories List"); ?>
                            </h2>
                        </div>
                        <div class="body">

                            <!-- Striped Rows -->
                            <div class="row clearfix">
                                <div class="table-responsive">
                                    <table id="slidersList" class="table table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line("ID"); ?></th>
                                            <th><?php echo $this->lang->line("Category Order"); ?></th>
                                            <th><?php echo $this->lang->line("Title"); ?></th>
                                            <th><?php echo $this->lang->line("Category Parent"); ?></th>
                                            <th><?php echo $this->lang->line("Image"); ?></th>
                                            <th><?php echo $this->lang->line("Status"); ?></th>
                                            <th><?php echo $this->lang->line("Action"); ?></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($categoriesList as $key) {
                                            if ($key->category_status == 1) $category_status = "<span class='label label-success'>".$this->lang->line("Active")."</span>";
                                            if ($key->category_status == 0) $category_status = "<span class='label label-danger'>".$this->lang->line("Inactive")."</span>";
                                            ?>
                                            <tr>
                                                <td><?php echo $key->category_id; ?></td>
                                                <td><?php echo $key->category_order; ?></td>
                                                <td><?php echo $key->category_title; ?></td>
                                                <td class="font-light"><?php
                                                    //Get Parent Category Title
                                                    @$categoryTitle = $this->db->get_where('category_table', array('category_id' => $key->category_parent_id))->result()[0];
                                                    echo @$categoryTitle->category_title;
                                                    if(empty($categoryTitle->category_title)) echo "<small class='col-grey'>".$this->lang->line("No Parent")."</small>";
                                                ?></td>
                                                <td><img class="" alt="Category" width="36px" height="36px" src="<?php echo base_url()."assets/upload/category/$key->category_image" ?>"></td>
                                                <td><?php echo $category_status; ?></td>
                                                <td style="width: 80px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <?php echo $this->lang->line("Action"); ?> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="<?php echo base_url()."dashboard/Category/edit_category/$key->category_id"; ?>"><i class="material-icons">mode_edit</i> <?php echo $this->lang->line("Edit"); ?></a></li>
                                                            <li><a href="#" class="identifyingClass waves-effect" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $key->category_id; ?>"><i class="material-icons">cancel</i> <?php echo $this->lang->line("Delete"); ?></a></li>
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
                                            echo form_open(base_url()."dashboard/Category/delete_category/", $attributes);
                                            ?>
                                            <input type="hidden" readonly="readonly" name="category_id" id="category_id" value="" required/>
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

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                <?php echo $this->lang->line("Add New Category"); ?>
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
                            <?php
                            $attributes = array('method' => 'post');
                            echo form_open_multipart(base_url()."dashboard/Category/categories/", $attributes);
                            ?>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="category_title" class="form-control" required>
                                    <label class="form-label"><?php echo $this->lang->line("Category Title"); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="category_parent_id" name="category_parent_id" data-live-search="true" data-show-subtext="true" required>
                                        <option selected="selected" value="0"><?php echo $this->lang->line("No Parent Category"); ?></option>
                                        <?php
                                        foreach ($fetchCategories as $key) {
                                            ?>
                                            <option data-divider="true"></option>
                                            <option value="<?php echo $key->category_id ?>">◼ <?php echo $key->category_title; ?></option>
                                            <?php
                                            //To get sub category
                                            $subCategory = $this->db->get_where('category_table', array('category_parent_id' => $key->category_id))->result();
                                            foreach($subCategory as $sKey)
                                            {
                                                echo "<option data-subtext='($key->category_title)' value='$sKey->category_id'>&nbsp;&nbsp;&nbsp;&nbsp;◾&nbsp;$sKey->category_title</option>";
                                                //To get sub sub category
                                                $subSubCategory = $this->db->get_where('category_table', array('category_parent_id' => $sKey->category_id))->result();
                                                foreach($subSubCategory as $ssKey)
                                                {
                                                    echo "<option data-subtext='($sKey->category_title)' class='subSubCategoryDropDown' value='$ssKey->category_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;◽&nbsp;$ssKey->category_title</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="category_order" class="form-control" value="1" required>
                                    <label class="form-label"><?php echo $this->lang->line("Category Order"); ?></label>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" name="category_image" required multiple>
                                </div>
								<small class="col-pink"><?php echo $this->lang->line("Best image ratio for category."); ?></small>
                            </div>

                            <div class="form-group">
                                <div class="form-line">
                                    <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="category_status" name="category_status" checked>
                                    <label for="category_status"><?php echo $this->lang->line("Enable this category."); ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Add New Category"); ?></button>
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
<!--<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?php echo base_url()."assets/dashboard/" ?>plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>-->
<script>
    $(document).ready(function () {
        $('#slidersList').DataTable({
            "oSearch"     : {'sSearch': '<?php if (isset($_GET['s'])) echo $_GET['s']; else echo ""; ?>'},
            "ordering"    : true,
            "order": [[0,'desc']],
            "pageLength":100,
            "columnDefs": [
                { "targets": 0, "name": "id", 'searchable':false, 'orderable':true},
                { "targets": 1, "name": "order", 'searchable':false, 'orderable':true},
                { "targets": 2, "name": "title", 'searchable':true, 'orderable':true},
                { "targets": 3, "name": "parent", 'searchable':true, 'orderable':true},
                { "targets": 4, "name": "image", 'searchable':false, 'orderable':false},
                { "targets": 5, "name": "status", 'searchable':false, 'orderable':false},
                { "targets": 6, "name": "action", 'searchable':false, 'orderable':false},
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
            $(".modal-footer #category_id").val(my_id_value);
        })
    });
</script>
