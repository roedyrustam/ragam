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
                            <?php echo $this->lang->line("Show Withdrawal Coin"); ?>
                        </h2>
                    </div>
                    <div class="body">

                        <?php
                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                        echo form_open_multipart(base_url()."dashboard/", $attributes);
                        ?>
                        <?php echo $this->lang->line("You must manually deposit the money into the user account and then enter the transaction number here."); ?>
                        <br><br>
                        <div class="form-group">
                            <label for="withdrawal_user_username" class="col-sm-3 control-label"><?php echo $this->lang->line("Username"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_user_username" placeholder="<?php echo $this->lang->line("Username"); ?>" value="<?php echo $withdrawalCoinContent->user_username; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_account_type" class="col-sm-3 control-label"><?php echo $this->lang->line("Account Type"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_account_type" placeholder="<?php echo $this->lang->line("Account Type"); ?>" value="<?php echo $withdrawalCoinContent->withdrawal_account_type_title; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_account_name" class="col-sm-3 control-label"><?php echo $this->lang->line("Account Name"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" class="form-control" name="withdrawal_account_name" placeholder="<?php echo $this->lang->line("Account Name"); ?>" value="<?php echo $withdrawalCoinContent->withdrawal_account_name; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_req_coin" class="col-sm-3 control-label"><?php echo $this->lang->line("Coin(s)"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_req_coin" placeholder="<?php echo $this->lang->line("Coin(s)"); ?>" value="<?php echo $withdrawalCoinContent->withdrawal_req_coin; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_req_cash" class="col-sm-3 control-label"><?php echo $this->lang->line("Cash"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_req_cash" placeholder="<?php echo $this->lang->line("Cash"); ?>" value="<?php echo $withdrawalCoinContent->withdrawal_req_cash; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_req_date" class="col-sm-3 control-label"><?php echo $this->lang->line("Time"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_req_date" placeholder="<?php echo $this->lang->line("Time"); ?>" value="<?php if ($this->lang->line("date-format-ago") == "default") echo timespan($withdrawalCoinContent->withdrawal_req_date, now(), 2)." ".$this->lang->line("ago")." (".unix_to_human($withdrawalCoinContent->withdrawal_req_date).")";
                                    elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($withdrawalCoinContent->withdrawal_req_date, now(), 2)." ".$this->lang->line("ago")." (".$this->jdf->jdate('Y/m/d G:i', $withdrawalCoinContent->withdrawal_req_date).")";
                                    else echo timespan($withdrawalCoinContent->withdrawal_req_date, now(), 2)." ".$this->lang->line("ago"); ?>" required>
                                </div>
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="withdrawal_date_paid" class="col-sm-3 control-label"><?php echo $this->lang->line("Update Time"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line">
                                    <input type="text" readonly="readonly" class="form-control" name="withdrawal_date_paid" placeholder="<?php echo $this->lang->line("Update Time"); ?>" value="<?php if ($this->lang->line("date-format-ago") == "default") echo timespan($withdrawalCoinContent->withdrawal_date_paid, now(), 2)." ".$this->lang->line("ago")." (".unix_to_human($withdrawalCoinContent->withdrawal_date_paid).")";
                                    elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($withdrawalCoinContent->withdrawal_date_paid, now(), 2)." ".$this->lang->line("ago")." (".$this->jdf->jdate('Y/m/d G:i', $withdrawalCoinContent->withdrawal_date_paid).")";
                                    else echo timespan($withdrawalCoinContent->withdrawal_date_paid, now(), 2)." ".$this->lang->line("ago"); ?>" required>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label for="withdrawal_user_comment" class="col-sm-3 control-label"><?php echo $this->lang->line("User Comment"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #e5e5e5">
                                    <textarea readonly="readonly" disabled class="form-control" name="withdrawal_user_comment" id="withdrawal_user_comment" required><?php echo $withdrawalCoinContent->withdrawal_user_comment; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_transaction" class="col-sm-3 control-label"><?php echo $this->lang->line("Transaction"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #98ddff">
                                    <input type="text" readonly="readonly" disabled class="form-control" name="withdrawal_transaction" placeholder="<?php echo $this->lang->line("Transaction"); ?>" value="<?php echo $withdrawalCoinContent->withdrawal_transaction; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_admin_comment" class="col-sm-3 control-label"><?php echo $this->lang->line("Admin Comment"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #98ddff">
                                    <textarea class="form-control" readonly="readonly" rows="4" disabled name="withdrawal_admin_comment" id="withdrawal_admin_comment"><?php echo $withdrawalCoinContent->withdrawal_admin_comment; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="withdrawal_status" class="col-sm-3 control-label"><?php echo $this->lang->line("Status"); ?></label>
                            <div class="col-sm-9">
                                <div class="form-line" style="background-color: #98ddff">
                                    <?php
                                    $category_id_selected1 = "";
                                    if ($withdrawalCoinContent->withdrawal_status == 1) $withdrawal_status1 = "selected='selected'"; else $withdrawal_status1 = "";
                                    if ($withdrawalCoinContent->withdrawal_status == 2) $withdrawal_status2 = "selected='selected'"; else $withdrawal_status2 = "";
                                    if ($withdrawalCoinContent->withdrawal_status == 3) $withdrawal_status3 = "selected='selected'"; else $withdrawal_status3 = "";
                                    ?>
                                    <select name="withdrawal_status" class="form-control" required disabled>
                                        <option <?php echo $withdrawal_status1 ?> value="1"><?php echo $this->lang->line("Withdrawal Pending"); ?></option>
                                        <option <?php echo $withdrawal_status2 ?> value="2"><?php echo $this->lang->line("Withdrawal Paid"); ?></option>
                                        <option <?php echo $withdrawal_status3 ?> value="3"><?php echo $this->lang->line("Withdrawal Cancel"); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <!--<input type="hidden" readonly="readonly" name="withdrawal_id" value="<?php echo $withdrawalCoinContent->withdrawal_id; ?>" required>
                                <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Update"); ?></button>-->

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
