<link href="assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src = "assets/js/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.flash.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js/pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>
<script>
var table = $('#myTable').DataTable({
           "order": [[2, 'asc']],
           "displayLength": 25,
           dom: 'Bfrtip',
           // Configure the drop down options.
           lengthMenu: [
               [10, 25, 50, -1],
               ['10 rows', '25 rows', '50 rows', 'Show all']
           ],
           // Add to buttons the pageLength option.
           buttons: [
               'pageLength', 'copy', 'csv', 'excel', 'pdf', 'print',
			   {
					extend: 'pdfHtml5',
					orientation: 'landscape'
			   },
			    {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        // .prepend(
                            // '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        // );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
           ]
       });
</script>

<?php
include_once '../include/dbconnect.php';
session_start();

$fromDate = implode('-', array_reverse(explode('/', $_POST['from_date'])));
$toDate = implode('-', array_reverse(explode('/', ($_POST['to_date']))));

if (strtotime($toDate) < strtotime($fromDate)) {
    echo 'To Date should be greater than From Date.';
} elseif ($fromDate != '' && $toDate != '') {
    ?>

    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th>Transaction No.</th>
                <th>Visit Date</th>
                <th>Visit Time</th>
                <th>Differently Abled (Adult)</th>
                <th>Differently Abled (Child)</th>
                <th>Educational Institute Visitor (Adult)</th>
                <th>Educational Institute Visitor (Child)</th>
                <th>General Visitor (Adult)</th>
                <th>General Visitor (Child)</th>
                <th>Govt. Employees (Adult)</th>
                <th>Govt. Employees (Child)</th>
                <th>International Visitor (Adult)</th>
                <th>International Visitor (Child)</th>
                <th>Retired Person (Adult)</th>
                <th>Retired Person (Child)</th>
                <th>Phototype</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = array();

            $book_query = "SELECT * FROM booking WHERE date >= '$fromDate' AND date <= '$toDate'";
            $bookings = mysqli_query($mysqli, $book_query)or die('Username or password wrong...');
            while ($bookingrow = mysqli_fetch_assoc($bookings)) {
                $booking_id = $bookingrow['id'];

                $data['id'] = $booking_id;
                $data['visit_date'] = $bookingrow['date'];
                switch ($bookingrow['time']) {
                    case '10':
                        $data['visit_time'] = '10:00 AM - 11:00 AM';
                        break;
                    case '11':
                        $data['visit_time'] = '11:00 AM - 12:00 PM';
                        break;
                    case '12':
                        $data['visit_time'] = '12:00 PM - 1:00 PM';
                        break;
                    case '13':
                        $data['visit_time'] = '1:00 PM - 2:00 PM';
                        break;
                    case '14':
                        $data['visit_time'] = '2:00 PM - 3:00 PM';
                        break;
                    case '15':
                        $data['visit_time'] = '3:00 PM - 4:00 PM';
                        break;
                    case '16':
                        $data['visit_time'] = '4:00 PM - 5:00 PM';
                        break;
                    case '17':
                        $data['visit_time'] = '5:00 PM - 6:00 PM';
                        break;
                    case '18':
                        $data['visit_time'] = '6:00 PM - 7:00 PM';
                        break;
                    case '19':
                        $data['visit_time'] = '7:00 PM - 8:00 PM';
                        break;
                }

                $data['visit_time'] = '7:00 PM - 8:00 PM';
                $inv_query = mysqli_query($mysqli, "SELECT * FROM invoice WHERE bookingid=$booking_id")or die('Username or password wrong...');
                $invoice = mysqli_fetch_assoc($inv_query);

                $data['transactionid'] = $invoice['transactionid'];
                $data['total_adult'] = $invoice['adult'];
                $data['total_child'] = $invoice['child'];
                $data['visitoramount'] = $invoice['visitoramount'];
                $data['photography'] = $invoice['photography'];
                $data['photographyamount'] = $invoice['photographyamount'];

                $visitor_query = "SELECT * FROM visitor WHERE bookingid=$booking_id";
                $visitor = mysqli_query($mysqli, $visitor_query)or die('Username or password wrong...');

                while ($visitorrow = mysqli_fetch_assoc($visitor)) {
                    $data[$visitorrow['category'].'_category'] = $visitorrow['category'];
                    $data[$visitorrow['category'].'_adult'] = $visitorrow['adult'];
                    $data[$visitorrow['category'].'_adultrate'] = $visitorrow['adultrate'];
                    $data[$visitorrow['category'].'_child'] = $visitorrow['child'];
                    $data[$visitorrow['category'].'_childrate'] = $visitorrow['childrate'];
                    $data[$visitorrow['category'].'_totalamount'] = $visitorrow['totalamount'];
                }
                $data['total_amount'] = $data['visitoramount'] + $data['photographyamount'];
            }
            ?>
            <tr class="results">
                <td><?php echo $data['transactionid']; ?></td>
                <td><?php echo $data['visit_date']; ?></td>
                <td><?php echo $data['visit_time']; ?></td>
                
				<td><?php echo (isset($data['PH_category']) && $data['PH_category'] != '') ? ($data['PH_adult']) : '0'; ?></td>
				<td><?php echo (isset($data['PH_category']) && $data['PH_category'] != '') ? ($data['PH_child']) : '0';  ?></td>
				<td><?php echo (isset($data['EI_category']) && $data['EI_category'] != '') ? ($data['EI_adult']) : '0';  ?></td>
				<td><?php echo (isset($data['EI_category']) && $data['EI_category'] != '') ? ($data['EI_child']) : '0';  ?></td>
				<td><?php echo (isset($data['GV_category']) && $data['GV_category'] != '') ? ($data['GV_adult']) : '0';  ?></td>
				<td><?php echo (isset($data['GV_category']) && $data['GV_category'] != '') ? ($data['GV_child']) : '0'; ?></td>
				<td><?php echo (isset($data['GE_category']) && $data['GE_category'] != '') ? ($data['GE_adult']) : '0';  ?></td>
				<td><?php echo (isset($data['GE_category']) && $data['GE_category'] != '') ? ($data['GE_child']) : '0';  ?></td>
				<td><?php echo (isset($data['IV_category']) && $data['IV_category'] != '') ? ($data['IV_adult']) : '0';  ?></td>
				<td><?php echo (isset($data['IV_category']) && $data['IV_category'] != '') ? ($data['IV_child']) : '0';  ?></td>
				<td><?php echo (isset($data['RP_category']) && $data['RP_category'] != '') ? ($data['RP_adult']) : '0';  ?></td>
				<td><?php echo (isset($data['RP_category']) && $data['RP_category'] != '') ? ($data['RP_child']) : '0';  ?></td>

                <td>
                    <?php
                    switch ($data['photography']) {
                        case 1:
                            echo 'No Camera';
                            break;
                        case 2:
                            echo 'Mobile Photography';
                            break;
                        case 3:
                            echo 'Video/Digital Camera';
                            break;
                        case 4:
                            echo 'Commercial Still Photography';
                            break;
                        case 5:
                            echo 'Commercial Videography';
                            break;
                    }
                    ?>
                </td>
                <td><?php echo $data['total_amount']; ?></td>
            </tr>

            <?php
        } else {
            echo 'false';
        }
        ?>
    </tbody>
</table>