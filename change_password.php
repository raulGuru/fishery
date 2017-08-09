<?php
session_start();
error_reporting(0);
include_once 'include/dbconnect.php';

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
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
        <title>Department of Fisheries</title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="login-register">
            <div class="login-box">
                <h3 style="text-align: center">Change Password</h3>
                <!--<div class="white-box">-->
                <form class="form-horizontal form-material" id="loginform">
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <div class="user-thumb text-center">
                                <img alt="thumbnail" class="img-circle" width="100" src="assets/images/user.png" style="height: 50px;width: 50px"><h3><?php echo ucfirst($_SESSION['username']); ?></h3>
                                <!--<div class="mdi mdi-account img-circle"></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-danger alert-dismissable" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span id="errormsg"></span></div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="current password" id="curr_pwd" name="curr_pwd" required="true">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="new password" id="new_pwd" name="new_pwd" required="true">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="confirm password" id="cnf_pwd" id="cnf_pwd" required="true">
                        </div>
                    </div>
                    <input class="form-control" type="hidden" required="" placeholder="" id="user_name" id="user_name" value="<?php echo ($_SESSION['username'] != '') ? ($_SESSION['username']) : '' ?>">
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="btn_log">Confirm</button>
                        </div>
                    </div>
                </form>
                <!--</div>-->
            </div>
        </section>
        <!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="assets/js/custom.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.alert-danger').hide();
                $("#btn_log").click(function () {
                    var user_name = $("#user_name").val();
                    var curr_pwd = $("#curr_pwd").val();
                    var new_pwd = $("#new_pwd").val();
                    var cnf_pwd = $("#cnf_pwd").val();
                    if (curr_pwd == '') {
                        alert('Current Password cannot be blank.');
                        $("#curr_pwd").focus();
                    } else if (new_pwd == '') {
                        alert('New Password cannot be blank.');
                        $("#new_pwd").focus();
                    } else if (cnf_pwd == '') {
                        alert('Confirm Password cannot be blank.');
                        $("#cnf_pwd").focus();
                    } else if (new_pwd != cnf_pwd) {
                        alert('New Password and Confirm Password do not match.');
                        $("#cnf_pwd").focus();
                    } else {
                        if (user_name == '') {
                            window.location = 'login.php';
                        } else {
                            var datastring = 'curr_pwd=' + curr_pwd + '&new_pwd=' + new_pwd + '&cnf_pwd=' + cnf_pwd + '&user_name=' + user_name;
                            $.ajax({
                                url: 'ajax/pwdCheck.php',
                                type: 'POST',
                                data: datastring,
                                success: function (response)
                                {
                                    if (response == 'true')
                                    {
<?php $_SESSION['pwd_changed'] = 'Password changed successfully.'; ?>
                                        window.location = 'index.php';
                                    } else
                                    {
                                        $("#errormsg").html(response);
                                        $(".alert-danger").show();
                                    }
                                }
                            });
                        }
                    }
                    return false;
                });
            });
        </script>
    </body>
</html>
