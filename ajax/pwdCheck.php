<?php

include_once '../include/dbconnect.php';

ob_start();
session_start();

$session_id = session_id();
$session = md5(session_id());
$user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
$curr_pwd = mysqli_real_escape_string($mysqli, $_POST['curr_pwd']);
$new_pwd = mysqli_real_escape_string($mysqli, $_POST['new_pwd']);
$cnf_pwd = md5(mysqli_real_escape_string($mysqli, $_POST['cnf_pwd']));
//$password = mysqli_real_escape_string($mysqli, $_POST['pass']);

$query = "SELECT pwd FROM user WHERE user_name='$user_name' AND status='enable'";

$result = mysqli_query($mysqli, $query)or die('Username or password wrong...');
$old_password = mysqli_fetch_assoc($result);

if ($old_password['pwd'] == $curr_pwd) {
    if ($_POST['new_pwd'] == $_POST['cnf_pwd']) {

        $update_qry = "Update user Set pwd = '$new_pwd', encd_pwd = '$cnf_pwd' Where user_name = '$user_name'";
        mysqli_query($mysqli, $update_qry);
        echo "true";
    } else {
        echo 'New Password and Confirm Password do not match.';
    }
} else {
    echo 'Current Password is incorrect.';
}
?>