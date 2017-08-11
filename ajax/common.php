<?php

if(isset($_POST) && $_POST['method'] == 'availtickets')
{
    include_once '../include/dbconnect.php';

    $seldate = date("Y-m-d", strtotime($_POST['vdate']));
    $selslot = $_POST['vslot'];

    $sqltc = "SELECT SUM(a.adult) AS avail FROM invoice a LEFT JOIN booking b ON a.bookingid = b.id WHERE b.date = '$seldate' AND b.time = '$selslot'";
    if ($result = $mysqli->query($sqltc)) {
        $avail = $result->fetch_object()->avail;
        echo 500 - (!empty($avail) ? $avail : 0);
        mysqli_free_result($result);
    }else {
        printf("$sqltc Errormessage: %s\n", $mysqli->error); exit();
    }
}