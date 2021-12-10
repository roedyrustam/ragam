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
                            <?php echo $this->lang->line("Edit Category"); ?>
                        </h2>
                    </div>
                    <div class="body">

                        <?php
                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                        echo form_open_multipart(base_url()."dashboard/category/edit_category/", $attributes);
                        ?>
                        <div class="form-group">
                            <label for="category_title" class="col-sm-3 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="category_title" placeholder="<?php echo $this->lang->line("Category Title"); ?>" value="<?php echo $categoryContent->category_title; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_description" class="col-sm-3 control-label"><?php echo $this->lang->line("Category Parent"); ?> *</label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <?php
                                    $category_id_selected1 = "";
                                    if ($categoryContent->category_parent_id == 0) $category_id_selected1 = "selected='selected'";
                                    ?>
                                    <select name="category_parent_id" class="form-control" data-live-search="true" data-show-subtext="true" required>
                                        <option <?php echo $category_id_selected1 ?> value="0"><?php echo $this->lang->line("No Parent Category"); ?></option>
                                        <?php
                                        foreach($fetchCategories as $key)
                                        {
                                            $category_id_selected2 = "";
                                            if ($categoryContent->category_parent_id == $key->category_id) $category_id_selected2 = "selected='selected'";
                                            echo "<option data-divider='true'></option>";
                                            echo "<option value='$key->category_id' $category_id_selected2>◼ $key->category_title</option>";
                                            //To get sub category
                                            $subCategory = $this->db->get_where('category_table', array('category_parent_id' => $key->category_id))->result();
                                            foreach($subCategory as $sKey)
                                            {
                                                $category_id_selected3 = "";
                                                if ($categoryContent->category_parent_id == $sKey->category_id) $category_id_selected3 = "selected='selected'";
                                                echo "<option data-subtext='($key->category_title)' value='$sKey->category_id' $category_id_selected3>&nbsp;&nbsp;&nbsp;&nbsp;◾&nbsp;$sKey->category_title</option>";
                                                //To get sub sub category
                                                $subSubCategory = $this->db->get_where('category_table', array('category_parent_id' => $sKey->category_id))->result();
                                                foreach($subSubCategory as $ssKey)
                                                {
                                                    $category_id_selected4 = "";
                                                    if ($categoryContent->category_parent_id == $ssKey->category_id) $category_id_selected4 = "selected='selected'";
                                                    echo "<option data-subtext='($sKey->category_title)'  value='$ssKey->category_id' $category_id_selected4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;◽&nbsp;$ssKey->category_title</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_order" class="col-sm-3 control-label"><?php echo $this->lang->line("Category Order"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="category_order" placeholder="<?php echo $this->lang->line("Category Order"); ?>" value="<?php echo $categoryContent->category_order; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_image" class="col-sm-3 control-label"><?php echo $this->lang->line("Image"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="file" name="category_image" multiple>
                                </div>
								<small class="col-pink"><?php echo $this->lang->line("Best image ratio for category."); ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="slider_status" class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <?php
                                    $category_status_checked = "";
                                    if($categoryContent->category_status == 1)
                                        $category_status_checked = "checked";
                                    ?>
                                    <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="category_status" name="category_status" <?php echo $category_status_checked; ?>>
                                    <label for="category_status"><?php echo $this->lang->line("Enable this category."); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="hidden" readonly="readonly" name="category_id" value="<?php echo $categoryContent->category_id; ?>" required>
                                <input type="hidden" readonly="readonly" name="old_category_image" value="<?php echo $categoryContent->category_image; ?>" required>
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
