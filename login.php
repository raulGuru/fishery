<?php
session_start();
if (isset($_SESSION['session_id']) && $_SESSION['session_id'] != '') {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
        <title>Department of Fisheries</title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <!--<link href="assets/css/animate.css" rel="stylesheet">-->
        <!-- Custom CSS -->
        <link href="assets/css/style.css" rel="stylesheet">
        <!-- color CSS -->
        <!--<link href="css/colors/default.css" id="theme"  rel="stylesheet">-->
    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel">
                <div class="inner-panel">

                </div>
            </div>
            <div class="new-login-box">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sign In to Dept. of Fisheries</h3>
                    <small>Enter your details below</small>
                    <div class="alert alert-danger alert-dismissable" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span id="errormsg"></span></div>

                    <form class="form-horizontal new-lg-form" id="loginform" action="index.html">

                        <div class="form-group  m-t-20">
                            <div class="col-xs-12">
                                <label>Username</label>
                                <input class="form-control" type="text" required="true" placeholder="Username" id="useridlog" name="useridlog">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>Password</label>
                                <input class="form-control" type="password" required="true" placeholder="Password" id="passlog" name="passlog">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit" id="btn_log">Log In</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <!--<script src="assets/js/jq../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>-->

        <!-- Custom Theme JavaScript -->
        <script src="assets/js/custom.min.js"></script>
        <!--Style Switcher -->
        <!--<script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>-->

        <script type="text/javascript">
            $(document).ready(function () {
                $('.alert-danger').hide();
                $("#btn_log").click(function () {
                    var userid = $("#useridlog").val();
                    var pass = $("#passlog").val();
                    var datastring = 'userid=' + userid + '&pass=' + pass;
                    $.ajax({
                        url: 'ajax/loginCheck.php',
                        type: 'POST',
                        data: datastring,
                        success: function (response)
                        {
                            if (response == 'true')
                            {
                                window.location = 'index.php';
                            } else
                            {
                                $("#errormsg").html(response);
                                $(".alert-danger").show();
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
    </body>
</html>
