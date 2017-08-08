<?php
session_start();
include_once 'dbconnect.php';

if ($_SESSION['session'] == '') {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="16x16" href="">
        <title>Department of Fisheries</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <!--    <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />-->
        <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/megna-dark.css" rel="stylesheet">
        <link href="assets/css/switchery.min.css" rel="stylesheet">
        <!--<link href="assets/css/bootstrap-select.min.css" rel="stylesheet">-->

        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <!--<script src="assets/js/waves.js"></script>-->
        <script src="assets/js/bootstrap.min.js"></script>
        <!--<script src="assets/js/bootstrap-select.min.js"></script>-->
        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/switchery.min.js"></script>
        <script src="assets/js/jquery.numeric-min.js"></script>
    <!--    <script src="assets/js/validator.min.js"></script>-->
    </head>
    <body class="fix-header">

        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top m-b-0" style="min-height: 60px !important;">
                <div class="navbar-header">
                </div>
            </nav>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav">
                    <ul class="nav in" id="side-menu">
                        <li>
                            <a href="/book" class="waves-effect active">
                                <i class="mdi mdi-ticket-account fa-fw"></i>
                                <span class="hide-menu">Book Ticket
                                    <span class="fa arrow"></span>
                                    <span class="label label-rouded label-warning pull-right">30</span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="report.php" class="waves-effect">
                                <i class="mdi mdi-chart-areaspline fa-fw"></i>
                                <span class="hide-menu">Report
                                    <span class="fa arrow"></span>
                                    <span class="label label-rouded label-warning pull-right">30</span>
                                </span>
                            </a>
                        </li>
                        <li class="dropdown logout">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">

                                <b class="hidden-xs">
                                    <i class="mdi mdi-account fa-fw"></i><span class="hide-menu"><?php echo ucfirst($_SESSION['first_name']); ?></span>
                                </b>
                                <span class="caret"></span>
                            </a>
                            <ul class="logout dropdown-menu dropdown-user animated flipInY">
                                <li><a href="change_password.php" style="width: auto !important"><i class="ti-pencil"></i> Change Password</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php" style="width: auto !important"><i class="ti-power-off"></i>  Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>