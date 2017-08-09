<?php

include_once '../include/dbconnect.php';

ob_start();
session_start();

$session_id = session_id();
$session = md5(session_id());
$user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
$curr_pwd = base64_encode(mysqli_real_escape_string($mysqli, ('deptf_'.$_POST['curr_pwd'])));
$new_pwd = base64_encode(mysqli_real_escape_string($mysqli, ('deptf_'.$_POST['new_pwd'])));
$cnf_pwd = base64_encode(mysqli_real_escape_string($mysqli, ('deptf_'.$_POST['cnf_pwd'])));

$query = "SELECT password FROM user WHERE username='$user_name' AND status='active'";

$result = mysqli_query($mysqli, $query)or die('Username or password wrong...');
$old_password = mysqli_fetch_assoc($result);

if ($old_password['password'] == $curr_pwd) {
    if ($_POST['new_pwd'] == $_POST['cnf_pwd']) {

        $update_qry = "UPDATE user SET password = '$new_pwd' WHERE username = '$user_name'";
        mysqli_query($mysqli, $update_qry);
        echo "true";
    } else {
        echo 'New Password and Confirm Password do not match.';
    }
} else {
    echo 'Current Password is incorrect.';
}
?>