<?php include_once 'include/header.php'; ?>
<script type="text/javascript">
    function myDateFormatter(dateObject) {
        if(dateObject == ""){
            return "";
        }
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "/" + month + "/" + year;
        return date;
    }

    $(document).ready(function () {
        $(".results").hide();
        $("#btn_getReport").click(function () {
            var fromDate = $("#from_date").val();
            frmDate = myDateFormatter(fromDate);
            var toDate = $("#to_date").val();
            toDt = myDateFormatter(toDate);
            if (frmDate != '' && toDt != '') {
                var datastring = 'from_date=' + frmDate + '&to_date=' + toDt;
                $.ajax({
                    url: 'ajax/getReport.php',
                    type: 'POST',
                    data: datastring,
                    success: function (response)
                    {
                        if (response != '')
                        {
                            $(".no_result").hide();
                            $(".results").show();
                            $(".results").html(response);
                        } else
                        {
                            $(".results").hide();
                            $("#errormsg").html(response);
                            $(".alert-danger").show();
                        }
                    }
                });
            }
            return false;
        });
   });
</script>
<div id="page-wrapper" style="min-height: 125px;">
    <div class="container-fluid">
        <div class="row bg-title"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Reports</h3>
                    <div class="row">
                        <form class="form-horizontal" id="frm_get_report" method="post">
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
                                        <input type="text" redonly class="btn btn-info" name="btn_getReport" value="Get Report"style="margin-top: 26px;" id="btn_getReport">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title">Results</h3>
                    <div class="row">
                        <div class="table-responsive" style="text-align: center">
                            <div class="no_result">
                                No records to display
                            </div>
                            <div class="results">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#from_date, #to_date').datepicker({ dateFormat: "DD, d MM, yy" });
</script>

<?php include_once 'include/footer.php'; ?>
