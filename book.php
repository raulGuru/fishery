<?php
    if(isset($_POST['confirm_pay']))
    {
        session_start();

        $sessticket = $_SESSION['confirmticket'];
        if(!empty($sessticket['book']))
    {
        require_once 'include/dbconnect.php';

        $book = $sessticket['book'];
        $date = date("Y-m-d", strtotime($book['visit_date']));
        $time = $book['visit_time'];
        $userid = '1';

        $sqlBook = "INSERT INTO `booking` (`date`, `time`, `userid`) VALUES ('$date', $time, $userid)";
        $resBook = $mysqli->query($sqlBook);
        if (!$resBook) {
            printf("$sqlBook Errormessage: %s\n", $mysqli->error); exit();
        }
        $bookingid = $mysqli->insert_id;
        if(!empty($bookingid)) {

            if ($result = $mysqli->query("SELECT * FROM category")) {
                $category = array();
                while ($obj = $result->fetch_object()) {
                    $category[$obj->type] = [];
                    $category[$obj->type]['type'] = $obj->type;
                    $category[$obj->type]['adult'] = $obj->adult;
                    $category[$obj->type]['child'] = $obj->child;
                }
                /* free result set */
                $result->close();
            }else {
                printf("category Errormessage: %s\n", $mysqli->error); exit();
            }

            $visitor = $sessticket['visitor'];
            foreach ($visitor as $k => $v) {
                $adult = (!empty($v['adlt']) ? $v['adlt'] : 0);
                $child= (!empty($v['chld']) ? $v['chld'] : 0);
                $adultrate = (!empty($v['adlt']) ? $category[$k]['adult'] : 0);
                $childrate = (!empty($v['chld']) ? $category[$k]['child'] : 0);
                $totalamount = $v['amnt'];

                $sqlV = "INSERT INTO `visitor` (`bookingid`, `category`, `adult`, `child`, `adultrate`, `childrate`, `totalamount`) VALUES ($bookingid, '$k', $adult, $child, $adultrate, $childrate, $totalamount)";
                $resV = $mysqli->query($sqlV);
                if (!$resV) {
                    printf("$sqlV Errormessage: %s\n", $mysqli->error); exit();
                }
            }

            $total = $sessticket['total'];
            $tladult = $total['adlt'];
                $tlchild = 0;
            $visitoramount = $total['amnt'];

                $photography = $sessticket['photography'];
            $ptype = (!empty($photography['type']) ? $photography['type'] : NULL);
            $pamount = 0;
            if( !is_null($ptype) ) {
                if ($result = $mysqli->query("SELECT * FROM photography")) {
                    $pgraphy = array();
                    while ($obj = $result->fetch_object()) {
                        $pgraphy[$obj->type] = [];
                        $pgraphy[$obj->type]['type'] = $obj->type;
                        $pgraphy[$obj->type]['rate'] = $obj->rate;
                    }
                    /* free result set */
                    $result->close();

                    $pamount = $pgraphy[$ptype]['rate'];
                }else {
                    printf("pgraphy Errormessage: %s\n", $mysqli->error); exit();
                }
            }
            if ($result = $mysqli->query("SELECT count(id) AS count FROM booking WHERE `date`= '$date'")) {
                $count = $result->fetch_object()->count;
                $transId = "TA".date("ymd", strtotime($book['visit_date'])).MACHINE_NAME."00".$count;
                $result->close();
            }else {
                printf("booking Errormessage: %s\n", $mysqli->error); exit();
            }

            $sqlIn = "INSERT INTO `invoice` (`bookingid`, `transactionid`, `adult`, `child`, `visitoramount`, `photography`, `photographyamount`) VALUES ($bookingid, '$transId', $tladult, $tlchild, $visitoramount, '$ptype', $pamount)";
            $resIn = $mysqli->query($sqlIn);
            if (!$resIn) {
                printf("$sqlIn Errormessage: %s\n", $mysqli->error);
            }
        }
        /* close connection */
        $mysqli->close();
        ?>
        <form id="myform" action="viewticket.php" method="post">
            <input type="hidden" name="bookingid" value="<?php echo $bookingid; ?>" />
        </form>
        <script type="text/javascript">
            document.getElementById('myform').submit();
        </script>
        <?php
    }
    else
    {
        echo 'something went wrong with book post';
    }
    }else
    {
        echo 'Direct access to script not allowed';
    }