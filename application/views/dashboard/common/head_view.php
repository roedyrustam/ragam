<?php defined('BASEPATH') OR exit('No direct script access allowed');
//Renew user session
if (isset($_SESSION['user_id']))
{
    $expired_time = $_SESSION['expired_time'];
    $session_data = array(
        'user_id' => $_SESSION['user_id'],
        'user_username' => $_SESSION['user_username'],
        'user_email' => $_SESSION['user_email'],
        'user_mobile' => $_SESSION['user_mobile'],
        'user_role_id' => $_SESSION['user_role_id'],
        'user_type' => $_SESSION['user_type'],
        'expired_time' => $_SESSION['expired_time']
    );
    $this->session->set_userdata($session_data);
    $this->session->mark_as_temp(array('user_id'  => $expired_time, 'user_username' => $expired_time, 'user_email' => $expired_time, 'user_mobile' => $expired_time,
        'user_role_id' => $expired_time, 'user_type' => $expired_time, 'expired_time' => $expired_time));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $pageTitle; ?></title>
    <!-- Meta Tags -->
    <meta name="description" content="Multi Content APP">
    <meta name="keywords" content="Multi Content APP">
    <meta name="author" content="inw24.com">
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Gogle reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <?php if ($this->lang->line("app_direction") == "ltr") { ?>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <?php } ?>

    <?php if ($this->lang->line("app_direction") == "ltr") { ?>
    <!-- Bootstrap Core LTR Css -->
    <link href="<?php echo base_url()."assets/dashboard/plugins/bootstrap/css/bootstrap.css"; ?>" rel="stylesheet">
    <?php }else if ($this->lang->line("app_direction") == "rtl") { ?>
    <!-- Bootstrap Core RTL Css -->
    <link href="<?php echo base_url()."assets/dashboard/plugins/bootstrap/css/bootstrap-rtl.min.css"; ?>" rel="stylesheet">
    <?php } ?>

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url()."assets/dashboard/plugins/node-waves/waves.css"; ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url()."assets/dashboard/plugins/animate-css/animate.css"; ?>" rel="stylesheet" />

    <!-- jQuery Plugin Js -->
    <script src="<?php echo base_url()."assets/dashboard/plugins/jquery/jquery.min.js"; ?>"></script>

    <!-- Morris Chart Css -->
    <link href="<?php echo base_url()."assets/dashboard/plugins/morrisjs/morris.css"; ?>" rel="stylesheet" />
    <script src="<?php echo base_url()."assets/dashboard/plugins/raphael/raphael.min.js"; ?>"></script>
    <script src="<?php echo base_url()."assets/dashboard/plugins/morrisjs/morris.min.js"; ?>"></script>

    <?php if ($this->lang->line("app_direction") == "rtl") { ?>
        <!-- Bootstrap Select Css -->
        <link href="<?php echo base_url()."assets/dashboard/"; ?>plugins/bootstrap-select/css/bootstrap-select-rtl.css" rel="stylesheet" />
    <?php }else{
        ?>
        <!-- Bootstrap Select Css -->
        <link href="<?php echo base_url()."assets/dashboard/"; ?>plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <?php
    } ?>

    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url()."assets/dashboard/"; ?>plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="<?php echo base_url()."assets/dashboard/css/style.css"; ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes
    <link href="<?php echo base_url()."assets/dashboard/css/themes/all-themes.min.css"; ?>" rel="stylesheet" />-->
    <link href="<?php echo base_url()."assets/dashboard/css/themes/theme-blue2.css"; ?>" rel="stylesheet" />

    <?php if ($this->lang->line("app_direction") == "rtl") { ?>
        <!--<link href="<?php echo base_url()."assets/dashboard/css/style-rtl3.css"; ?>" rel="stylesheet">-->
        <link href="<?php echo base_url()."assets/dashboard/css/style-rtl.css"; ?>" rel="stylesheet">
    <?php } ?>
    <link rel="shortcut icon" href="<?php echo base_url()."assets/dashboard/images/favicon.ico"; ?>" type="image/x-icon">
</head>
