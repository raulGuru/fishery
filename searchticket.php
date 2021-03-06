<?php include_once 'include/header.php' ?>

<div id="page-wrapper" style="min-height: 125px;">
    <div class="container-fluid">
        <form class="form-horizontal" id="" method="post" action="">
            <div class="row bg-title"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row">
                        <h3 class="box-title">Search ticket</h3>
                            <div class="row m-t-20" style="margin-left: 10px">
                            <div class="col-md-9">
                                <div class="col-md-2">
                                    <h5 class="m-b-30">Transaction ID</h5>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <input class="form-control" type="text"  size="35" placeholder="" required="required" name="transactionid" value="<?php echo ((isset($_POST['transactionid']) && !empty(trim($_POST['transactionid']))) ? $_POST['transactionid'] : '') ?>">
                                    </fieldset>
                                    <button type="submit" class="btn btn-custom" name="search_ticket" value="search" id="" style="margin-left: -14px; margin-top: -10px">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <?php
        if (isset($_POST['transactionid']) && !empty(trim($_POST['transactionid']))) {

            $bookingid = '';
            $transId = $mysqli->real_escape_string((trim($_POST['transactionid'])));
            $sqlB = "SELECT bookingid FROM `invoice` WHERE transactionid = '$transId'";
            if ($result = $mysqli->query($sqlB)) {
                if ($result->num_rows == 1) {
                    $bookingid = $result->fetch_object()->bookingid;
                }
            } else {
                printf("$sqlB Errormessage: %s\n", $mysqli->error);
                exit();
            }

            if (!empty($bookingid)) {
                ?>

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
                                        $sqlV = "SELECT a.category, b.name, a.adult, a.totalamount
                                                          FROM visitor a
                                                          INNER JOIN category b
                                                          ON a.category = b.type
                                                          AND a.bookingid = $bookingid";

                                        if ($result = $mysqli->query($sqlV)) {
                                            while ($obj = $result->fetch_object()) {
                                                echo "<tr><td>" . $obj->name . "</td>";
                                                echo "<td>" . $obj->adult . "</td>";
                                                echo "<td>" . $obj->totalamount . "</td></tr>";
                                            }
                                            $result->close();
                                        } else {
                                            printf("$sqlV Errormessage: %s\n", $mysqli->error);
                                            exit();
                                        }

                                        $sqlTl = "SELECT a.*, b.name
                                                  FROM invoice a
                                                  LEFT JOIN photography b
                                                  ON a.photography = b.type
                                                  WHERE a.bookingid= $bookingid";
                                        if ($result = $mysqli->query($sqlTl)) {
                                            $totalR = $result->fetch_object();
                                            mysqli_free_result($result);
                                        } else {
                                            printf("$sqlTl Errormessage: %s\n", $mysqli->error);
                                            exit();
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
                                                <td colspan="1"><?php echo $totalR->name ?></p></td>
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
                                    <input type="hidden" name="print_booking_id" id="print_booking_id" value="<?php echo $bookingid; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <?php } else { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">No Results Found !!</h3>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
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

<?php include_once 'include/footer.php' ?>
