<?php
include_once 'include/header.php';

$fdate = date("Y-m-d");
$tdate = date("Y-m-d");

if (isset($_POST['get_reports'])) {
    $fdate = date("Y-m-d", strtotime($_POST['from_date']));
    $tdate = date("Y-m-d", strtotime($_POST['to_date']));
}

    $tslot = array(
        "10" => "10:00 AM - 11:00 AM",
        "11" => "11:00 AM - 12:00 PM",
        "12" => "12:00 PM - 1:00 PM",
        "13" => "1:00 PM - 2:00 PM",
        "14" => "2:00 PM - 3:00 PM",
        "15" => "3:00 PM - 4:00 PM",
        "16" => "4:00 PM - 5:00 PM",
        "17" => "5:00 PM - 6:00 PM",
        "18" => "6:00 PM - 7:00 PM",
        "19" => "7:00 PM - 8:00 PM",
        "20" => "8:00 PM - 9:00 PM"
    );

    $result = array();
    $book_query = "SELECT * FROM booking WHERE date >= '$fdate' AND date <= '$tdate'";
    $bookings = mysqli_query($mysqli, $book_query)or die('Username or password wrong...');
    while ($bookingrow = mysqli_fetch_assoc($bookings)) {
        $data = array();

        $booking_id = $bookingrow['id'];
        $data['id'] = $booking_id;
        $data['visit_date'] = $bookingrow['date'];
        $data['visit_time'] = $tslot[$bookingrow['time']];

        $inv_query = mysqli_query($mysqli, "SELECT * FROM invoice WHERE bookingid=$booking_id")or die('Username or password wrong...');
        $invoice = mysqli_fetch_assoc($inv_query);

        $data['transactionid'] = $invoice['transactionid'];
        $data['total_adult'] = $invoice['adult'];
        $data['visitoramount'] = $invoice['visitoramount'];
        $data['photography'] = $invoice['photography'];
        $data['photographyamount'] = $invoice['photographyamount'];

        $visitor_query = "SELECT * FROM visitor WHERE bookingid=$booking_id";
        $visitor = mysqli_query($mysqli, $visitor_query)or die('Username or password wrong...');

        while ($visitorrow = mysqli_fetch_assoc($visitor)) {
            $data[$visitorrow['category'] . '_category'] = $visitorrow['category'];
            $data[$visitorrow['category'] . '_adult'] = $visitorrow['adult'];
            $data[$visitorrow['category'] . '_totalamount'] = $visitorrow['totalamount'];
        }
        $data['total_amount'] = $data['visitoramount'] + $data['photographyamount'];
        $result[] = $data;
    }
?>

<div id="page-wrapper" style="min-height: 125px;">
    <div class="container-fluid">
        <div class="row bg-title"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Reports</h3>
                    <div class="row">
                        <form class="form-horizontal" id="" method="post" action="">
                            <div class="table-responsive" style="margin-top: -20px">
                                <div class="col-md-4">
                                    <h5 class="m-t-30 m-b-10">From Date</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="from_date" placeholder="mm/dd/yyyy" required="required" name="from_date">
                                        <span class="input-group-addon">
                                            <i class="icon-calender"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="m-t-30 m-b-10">To Date</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="to_date" placeholder="mm/dd/yyyy" required="required" name="to_date">
                                        <span class="input-group-addon">
                                            <i class="icon-calender"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="m-t-30 m-b-10"> </h5>
                                    <div class="input-group">
                                        <button name="get_reports" type="submit" value="get_reports" id="get_reports" class="btn btn-block btn-info btn-rounded" style="margin-top: 25px; display: block;width: 200px;">Get Reports</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($result)) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Results</h3>
                        <div class="row">
                            <div class="table-responsive" style="text-align: center">
                                <?php
                                if (!empty($result)) {
                                    ?>
                                    <div class="results">
                                        <table id="myTable" class="table color-bordered-table info-bordered-table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Transaction ID.</th>
                                                    <th>Visit Date</th>
                                                    <th>Visit Time</th>
                                                    <th>General Visitor</th>
                                                    <th>General Visitor Child</th>
                                                    <th>Educational Institute Visitor</th>
                                                    <th>Retired Person</th>
                                                    <th>Govt Employess</th>
                                                    <th>International Visitor</th>
                                                    <th>International Visitor Child</th>
                                                    <th>Differently Abled</th>
                                                    <th>Photography</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $data) {
                                                    ?>
                                                    <tr class="results">
                                                        <td><?php echo $data['transactionid']; ?></td>
                                                        <td><?php echo $data['visit_date']; ?></td>
                                                        <td><?php echo $data['visit_time']; ?></td>
                                                        <td><?php echo (isset($data['GV_category']) && $data['GV_category'] != '') ? ($data['GV_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['GVC_category']) && $data['GVC_category'] != '') ? ($data['GVC_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['EI_category']) && $data['EI_category'] != '') ? ($data['EI_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['RP_category']) && $data['RP_category'] != '') ? ($data['RP_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['GE_category']) && $data['GE_category'] != '') ? ($data['GE_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['IV_category']) && $data['IV_category'] != '') ? ($data['IV_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['IVC_category']) && $data['IVC_category'] != '') ? ($data['IVC_adult']) : '0'; ?></td>
                                                        <td><?php echo (isset($data['PH_category']) && $data['PH_category'] != '') ? ($data['PH_adult']) : '0'; ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($data['photography']) {
                                                                case 0:
                                                                    echo 'No Camera';
                                                                    break;
                                                                case 1:
                                                                    echo 'Mobile';
                                                                    break;
                                                                case 2:
                                                                    echo 'Video/Digital Camera';
                                                                    break;
                                                                case 3:
                                                                    echo 'Commercial Still';
                                                                    break;
                                                                case 4:
                                                                    echo 'Commercial Videography';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $data['total_amount']; ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="no_result">
                                        No records to display
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    $('#from_date, #to_date').datepicker({dateFormat: "DD, d MM, yy"});

    var fdate = '<?php echo date("l, d F, Y", strtotime($fdate)); ?>';
    var tdate = '<?php echo date("l, d F, Y", strtotime($tdate)); ?>';

    $("#from_date").datepicker().datepicker("setDate", fdate);
    $("#to_date").datepicker().datepicker("setDate", tdate);

</script>

<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src = "assets/js/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script>
    if ($(".results").length != 0)
    {
        $('#myTable').DataTable({
            "order": [[2, 'asc']],
            "displayLength": 25,
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'copy',
                    footer: true
                },
                {
                    extend: 'csv',
                    footer: true
                },
                {
                    extend: 'excel',
                    footer: true
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    footer: true
                }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                var colNumber = [3, 4, 5, 6, 7, 8, 9, 10, 12];
                var intVal = function ( i ) {
                    return typeof i === 'string' ? i * 1 : typeof i === 'number' ? i : 0;
                };
                for (i = 0; i < colNumber.length; i++) {
                    var colNo = colNumber[i];
                    var sum = api
                            .column(colNo)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            },0 );
                    $(api.column(colNo).footer()).html(sum);
                }
            }
        });
    }
</script>
<?php include_once 'include/footer.php'; ?>
