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
                    <?php echo $this->lang->line("System Message!"); ?>
                </h2>
            </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <?php echo $this->lang->line("System Message!"); ?>
                        </h2>
                    </div>
                    <div class="body">
                        <br>
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
                        <br><br>
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