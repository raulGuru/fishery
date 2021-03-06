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
                                        <th>Count</th>
                                        <th>Amount ( ₹ )</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $bookingid = $_REQUEST['bookingid'];
                                        $sqlV = "SELECT a.category, b.name, a.adult, a.totalamount 
                                                          FROM visitor a 
                                                          INNER JOIN category b 
                                                          ON a.category = b.type 
                                                          AND a.bookingid = $bookingid";

                                        if ($result = $mysqli->query($sqlV)) {
                                            while ($obj = $result->fetch_object()) {
                                                echo "<tr><td>".$obj->name."</td>";
                                                echo "<td>".$obj->adult."</td>";
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
                                        <td><?php echo $totalR->visitoramount; ?></td>
                                    </tr>
                                    <?php if($totalR->photographyamount != 0) { ?>
                                        <tr>
                                            <td>Photography</td>
                                            <td colspan="1"><?php echo $totalR->name  ?></p></td>
                                            <td><?php echo $totalR->photographyamount; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="1">Sub-Total</td>
                                            <td><?php echo ($totalR->visitoramount + $totalR->photographyamount); ?></td>
                                        </tr>
                                    <?php } ?>
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
                                    <button name="print_ticket" type="submit" value="print_ticket" id="print_ticket" class="btn btn-block btn-info btn-rounded" style="margin: auto; display: block;width: 200px;">Print</button>
                                    <input type="hidden" name="print_booking_id" id="print_booking_id" value="<?php echo $bookingid;  ?>">
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

<script>
    $("#print_ticket").click(function () {
        var bookingid = $("#print_booking_id").val();
        $.ajax({
            url: 'ajax/printticket.php',
            type: 'POST',
            data: { bookingid: bookingid },
            success: function (response)
            {
                console.log(response);
            }
        });
        return false;
    });
</script>
