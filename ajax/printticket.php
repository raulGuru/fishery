<?php
    include_once ('../include/dbconnect.php');
    include_once ('../include/printclass.php');

    if(!empty($_POST['bookingid']))
    {
        $printobj = array();
        $bookingid = $_POST['bookingid'];
        $sqlB = "SELECT * FROM `booking` WHERE id = '$bookingid'";
        if ($result = $mysqli->query($sqlB)) {
            if($result->num_rows == 1)
            {
                $printobj['booking'] = $result->fetch_object();
                $result->close();
            }
        }else {
            printf("$sqlB Errormessage: %s\n", $mysqli->error); exit();
        }

        $sqlV = "SELECT a.category, b.name, a.adult, a.totalamount 
                  FROM visitor a 
                  INNER JOIN category b 
                  ON a.category = b.type 
                  AND a.bookingid = $bookingid";

        if ($result = $mysqli->query($sqlV)) {
            $printobj['visitor'] = $result->fetch_all(MYSQLI_ASSOC);
            $result->close();
        }else {
            printf("$sqlV Errormessage: %s\n", $mysqli->error); exit();
        }

        $sqlTl = "SELECT a.*, b.name 
                  FROM invoice a 
                  LEFT JOIN photography b 
                  ON a.photography = b.type  
                  WHERE a.bookingid= $bookingid";
        if ($result = $mysqli->query($sqlTl)) {
            $printobj['invoice'] = $result->fetch_object();
            $result->close();
        }else {
            printf("$sqlTl Errormessage: %s\n", $mysqli->error); exit();
        }
        if(!empty($printobj))
            echo execprint($printobj);

        exit();
    }

