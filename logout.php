<?php

include_once 'include/dbconnect.php';

session_start();

session_unset();
session_destroy();

header("location:login.php");
//header('cache-control: no-cache,no-store,must-revalidate'); // HTTP 1.1.
//header('pragma: no-cache'); // HTTP 1.0.
//header('expires: 0'); //
//exit();
?>