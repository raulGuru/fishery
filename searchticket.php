<?php include_once 'include/header.php'?>

<div id="page-wrapper" style="min-height: 125px;">
    <div class="container-fluid">
        <form class="form-horizontal" id="" method="post" action="">
            <div class="row bg-title"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Search ticket</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="m-t-30 m-b-10">Transaction ID</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="" required="required" name="transactionid" value="<?php echo ((isset($_POST['transactionid']) && !empty(trim($_POST['transactionid']))) ? $_POST['transactionid'] : '')  ?>">
                                        <button name="book_ticket" type="submit" value="search" id="" class="btn btn-default btn-rounded">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        if(isset($_POST['transactionid']) && !empty(trim($_POST['transactionid']))) {

            $bookingid = '';
            $transId = $mysqli->real_escape_string((trim($_POST['transactionid'])));
            $sqlB = "SELECT bookingid FROM `invoice` WHERE transactionid = '$transId'";
            if ($result = $mysqli->query($sqlB)) {
                if($result->num_rows == 1)
                {
                    $bookingid = $result->fetch_object()->bookingid;
                }
            }else {
                printf("$sqlB Errormessage: %s\n", $mysqli->error); exit();
            }

            if(!empty($bookingid)) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Tickets Details</h3>
                            <div class="table-responsive">
                                <table class="table color-table info-table">
                                    <thead>
                                    <tr>
                                        <th>Category Type</th>
                                        <th>Adult</th>
                                        <th>Child</th>
                                        <th>Amount ( ₹ )</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sqlV = "SELECT a.category, b.name, a.adult, a.child, a.totalamount 
                                                          FROM visitor a 
                                                          INNER JOIN category b 
                                                          ON a.category = b.type 
                                                          AND a.bookingid = $bookingid";

                                    if ($result = $mysqli->query($sqlV)) {
                                        while ($obj = $result->fetch_object()) {
                                            echo "<tr><td>".$obj->name."</td>";
                                            echo "<td>".$obj->adult."</td>";
                                            echo "<td>".$obj->child."</td>";
                                            echo "<td>".$obj->totalamount ."</td></tr>";
                                        }
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
                                        $totalR = $result->fetch_object();
                                        mysqli_free_result($result);
                                    }else {
                                        printf("$sqlTl Errormessage: %s\n", $mysqli->error); exit();
                                    }
                                    ?>
                                    <tr>
                                        <td>Total</td>
                                        <td><?php echo $totalR->adult; ?></td>
                                        <td><?php echo $totalR->child; ?></td>
                                        <td><?php echo $totalR->visitoramount; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Photography</td>
                                        <td colspan="2"><?php echo $totalR->name  ?></p></td>
                                        <td><?php echo $totalR->photographyamount; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">Sub-Total</td>
                                        <td><?php echo ($totalR->visitoramount + $totalR->photographyamount); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <div class="row">
                                <div style="align-items: center">
                                    <button name="book_ticket" type="submit" value="book_ticket" id="book_ticket" class="btn btn-block btn-info btn-rounded" style="margin: auto; display: block;width: 200px;">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }else { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">No Results Found !!</h3>
                        </div>
                    </div>
                </div>
                <?php }
        }
        ?>
    </div>
</div>

<?php include_once 'include/footer.php' ?>
