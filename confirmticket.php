<?php
include_once 'include/header.php';
$_SESSION['confirmticket'] = $_POST;

//echo '<pre>',print_r($_POST),'</pre>'; exit();
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
                                $sqlc = "SELECT * FROM category";
                                if ($result = $mysqli->query($sqlc)) {
                                    while ($obj = $result->fetch_object()) {
                                        $categories[$obj->type] = $obj->name;
                                    }
                                    $result->close();
                                } else {
                                    printf("$sqlc Errormessage: %s\n", $mysqli->error);
                                    exit();
                                }
                                $visitor = $_POST['visitor'];
                                foreach ($visitor as $k => $v) {
                                    echo "<tr><td>" . $categories[$k] . "</td>";
                                    echo "<td>" . $v['adlt'] . "</td>";
                                    echo "<td>" . $v['amnt'] . "</td></tr>";
                                }

                                $sqlp = "SELECT * FROM photography";
                                if ($result = $mysqli->query($sqlp)) {
                                    while ($obj = $result->fetch_object()) {
                                        $photography[$obj->type]['name'] = $obj->name;
                                        $photography[$obj->type]['rate'] = $obj->rate;
                                    }
                                    $result->close();
                                } else {
                                    printf("$sqlp Errormessage: %s\n", $mysqli->error);
                                    exit();
                                }
                                $total = $_POST['total'];

                                $photopost = $_POST['photography'];
                                if ($photopost['is'] == 'YES') {
                                    $indx = $photography[$photopost['type']];
                                } else {
                                    $indx = $photography[0];
                                }
                                $pname = $indx['name'];
                                $prate = $indx['rate'];
                                ?>
                                <tr><td></td><td></td><td></td></tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php echo $total['adlt']; ?></td>
                                    <td><?php echo $total['amnt']; ?></td>
                                </tr>
                                <tr>
                                    <td>Photography</td>
                                    <td colspan="1"><?php echo $pname ?></p></td>
                                    <td><?php echo $prate; ?></td>
                                </tr>
                                <tr><td></td><td></td><td></td></tr>
                                <tr>
                                    <td></td>
                                    <td colspan="1">Sub-Total</td>
                                    <td><?php echo ($total['amnt'] + $prate); ?></td>
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
                        <div style="max-width: 450px;margin:0 auto;">
                            <form action="book.php" method="post">
                                <button name="confirm_pay" type="submit" value="yes" id="confirm_pay" class="btn btn-block btn-info btn-rounded" style="margin: auto; display: block;width: 200px;float: left">Pay</button>
                            </form>
                            <form action="index.php" method="post">
                                <button name="edit_ticket" type="submit" value="yes" id="edit_ticket" class="btn btn-block btn-info btn-rounded" style="margin: auto; display: block;width: 200px; float: right">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//    $("#confirm_pay").on("submit", function (event) {
//        $.post("book.php");
//    });
</script>
<?php
include_once 'include/footer.php';
