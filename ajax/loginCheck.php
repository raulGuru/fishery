<?php

include_once '../include/dbconnect.php';

ob_start();
session_start();

$session_id = session_id();
$session = md5(session_id());
$userid = mysqli_real_escape_string($mysqli, $_POST['userid']);
$password = md5(mysqli_real_escape_string($mysqli, $_POST['pass']));
//$password = mysqli_real_escape_string($mysqli, $_POST['pass']);

$query = "SELECT * FROM user WHERE user_name='$userid' AND encd_pwd='$password' AND status='enable'";

$result = mysqli_query($mysqli, $query)or die('Username or password wrong...');
while ($row = mysqli_fetch_array($result)) {
    $username = $row['user_name'];
    $uid = $row['id'];
    $name = $row['first_name'];
}

$num_row = mysqli_num_rows($result);

if ($num_row >= 1) {
    $_SESSION['username'] = $username;
    $_SESSION['first_name'] = $name;
    $_SESSION['user_id'] = $uid;
    $_SESSION['session'] = $session;
    $_SESSION['session_id'] = $session_id;
    $_SESSION['pwd_changed'] = '';
    echo "true";
} else {
    echo 'Username or password wrong...';
}
?>