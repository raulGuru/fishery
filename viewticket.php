<?php

    if(!empty($_REQUEST['bookingid'])) {

        include_once 'include/header.php'
        ?>

        <div id="page-wrapper" style="min-height: 125px;">
            <div class="container-fluid">
                <div class="row bg-title"></div>
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
                                        $bookingid = $_REQUEST['bookingid'];
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
                                            printf("sqlV Errormessage: %s\n", $mysqli->error); exit();
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
                                            printf("sqlTl Errormessage: %s\n", $mysqli->error); exit();
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
            </div>
        </div>
    <?php
        include_once 'include/footer.php';
    }
    else{
        echo 'Direct access to script not allowed';
    }
    ?>