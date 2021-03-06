<?php
include_once 'include/header.php';

if (isset($_POST['edit_ticket'])) {
    $eticket = $_SESSION['confirmticket'];
} else {
    $eticket = '';
}
?>
<div id="page-wrapper" style="min-height: 125px;">
    <div class="container-fluid">
        <form class="form-horizontal" id="frm_book_ticket" method="post" action="confirmticket.php">
            <div class="row bg-title"></div>
            <div class="row">
                <div class="col-md-12">
                    <?php if ($_SESSION['pwd_changed'] != '') { ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="clearPwdSession();">×</button><?php echo ($_SESSION['pwd_changed'] != '') ? $_SESSION['pwd_changed'] : '' ?></div>
                    <?php } ?>
                    <div class="white-box">
                        <div class="row">
                            <h3 class="box-title">Select Date & Time of Visit</h3>

                            <div class="table-responsive" style="margin-top: -20px">
                                <div class="col-md-4" style="padding-left: 0px !important;padding-right: 0px !important;">
                                    <h5 class="m-t-30 m-b-10">Visit Date</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker" placeholder="mm/dd/yyyy" required="required" name="book[visit_date]">
                                        <span class="input-group-addon">
                                            <i class="icon-calender"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4" >
                                    <h5 class="m-t-30 m-b-10">Available Slots</h5>
                                    <select class="bs-select-hidden form-control dropdown" data-style="form-control" id="selectSlot" required="required" name="book[visit_time]" >
                                        <option value="">Select Time Slot</option>
                                        <option value="10">10:00 AM - 11:00 AM</option>
                                        <option value="11">11:00 AM - 12:00 PM</option>
                                        <option value="12">12:00 PM - 1:00 PM</option>
                                        <option value="13">1:00 PM - 2:00 PM</option>
                                        <option value="14">2:00 PM - 3:00 PM</option>
                                        <option value="15">3:00 PM - 4:00 PM</option>
                                        <option value="16">4:00 PM - 5:00 PM</option>
                                        <option value="17">5:00 PM - 6:00 PM</option>
                                        <option value="18">6:00 PM - 7:00 PM</option>
                                        <option value="19">7:00 PM - 8:00 PM</option>
                                        <option value="20">8:00 PM - 9:00 PM</option>
                                    </select>
                                </div>
                                <div class="col-md-4" style="padding-left: 0px !important;padding-right: 0px !important;">
                                    <h5 class="m-t-30">Tickets Available</h5>
                                    <input type="text" class="form-control" placeholder="500" required="required" name="book[tickets_available]" disabled="disabled" id="tickets_available">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row">
                            <h3 class="box-title" style="margin-left: 40px !important;">Visitor Details</h3>
                            <div class="table-responsive">
                                <table class="table color-bordered-table info-bordered-table js-visitor-add-tbl">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Category Type</th>
                                            <th>Count</th>
                                            <th>Amount ( ₹ )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[GV][chk]">
                                                </div>
                                            </td>
                                            <td>General Visitor (Adult)</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="60" name="visitor[GV][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[GV][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[GVC][chk]">
                                                </div>
                                            </td>
                                            <td>Child</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="30" name="visitor[GVC][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[GVC][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[EI][chk]">
                                                </div>
                                            </td>
                                            <td>Educational Institute Visitor</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="30" name="visitor[EI][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[EI][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[RP][chk]">
                                                </div>
                                            </td>
                                            <td>Retired Person</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="40" name="visitor[RP][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[RP][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[GE][chk]">
                                                </div>
                                            </td>
                                            <td>Govt Employess</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="30" name="visitor[GE][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[GE][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[IV][chk]">
                                                </div>
                                            </td>
                                            <td>International Visitor (Adult)</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="200" name="visitor[IV][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[IV][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[IVC][chk]">
                                                </div>
                                            </td>
                                            <td>International Visitor (Child)</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="100" name="visitor[IVC][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[IVC][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="m-b-30">
                                                    <input type="checkbox" class="js-switch" name="visitor[PH][chk]">
                                                </div>
<!--                                                <div class="checkbox checkbox-success">-->
<!--                                                    <input id="checkbox33" type="checkbox"><label for="checkbox33"></label>-->
<!--                                                </div>-->

                                            </td>
                                            <td>Differently Abled</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control numbersOnly js-row-adlt" id="" placeholder="0" maxlength="3" data-rate="30" name="visitor[PH][adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-row-amnt" id="" placeholder="0" readonly name="visitor[PH][amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom: 50px !important"></td>
                                            <td>Total</td>
                                            <td>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control js-tt-adlt" id="" placeholder="0" readonly name="total[adlt]">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control js-tt-amnt" id="" placeholder="0" readonly name="total[amnt]">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title" style="margin-left: 40px !important;">Photography</h3>
                        <div class="row" style="margin-left: 0px !important;">
                            <div class="table-responsive">
                                <div class="radio radio-success col-md-2">
                                    <input type="radio" class="js-rdo-photo" name="photography[is]" id="phtYes" value="YES">
                                    <label for="phtYes"> Yes </label>
                                </div>
                                <div class="radio radio-success col-md-2">
                                    <input type="radio" class="js-rdo-photo" name="photography[is]" id="phtNo" value="NO" checked>
                                    <label for="phtNo"> No </label>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="col-sm-5" style="text-align: right;">Type of Photography</h5>
                                    <div class="col-sm-7">
                                        <select class="bs-select-hidden form-control" data-style="form-control" id="select_photo" name="photography[type]" disabled>
                                            <option value="0">Select Type</option>
                                            <option value="1">Mobile Photography (500₹)</option>
                                            <option value="2">Video/Digital Camera (1000₹)</option>
                                            <option value="3">Commercial Still Photography (5000₹)</option>
                                            <option value="4">Commercial Videography (10000₹)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <div class="row">
                            <div style="align-items: center">
                                <button name="book_ticket" type="submit" value="book_ticket" id="book_ticket" class="btn btn-block btn-info btn-rounded" style="margin: auto; display: block;width: 200px;">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#datepicker').datepicker({
        dateFormat: "DD, d MM, yy",
        minDate: 0,
        beforeShowDay: function (date) {
            var day = date.getDay();
            return [(day != 1), ''];
        },
        onSelect: function (dateText, inst) {
            //$('#selectSlot').attr("disabled", false);
            $("#selectSlot").val(new Date().getHours());
            getAvailableTicketsCount();
        }
    });
    $("#datepicker").datepicker().datepicker("setDate", new Date());

    /* #selectSlot onchange="getAvailableTicketsCount(this);" */
    function getAvailableTicketsCount() {
        var pdata = {
            method: 'availtickets',
            vdate: $('#datepicker').val(),
            vslot: $('#selectSlot').val()
        };
        $.ajax({
            url: 'ajax/common.php',
            type: 'POST',
            data: pdata,
            success: function (response)
            {
                $('#tickets_available').val(response);
                if(response < 0) {
                    $('#selectSlot').val('');
                    alert('No tickets available for selected slot !!');
                    return false;
                }
            }
        });
    }

    $('#selectSlot').change(function () {
        getAvailableTicketsCount();
    });

    $('.numbersOnly').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });

    $('.js-switch').change(function () {
        var $inpts = $(this).closest('tr').find('input:text').prop('disabled', !this.checked).prop('required', this.checked);
        if (!this.checked) {
            $inpts.val('')
        }
        $('.js-row-adlt').trigger('change');
    });

    $('.js-switch').each(function () {
        $(this).trigger('change');
    });

    $('.js-row-adlt').change(function () {

        var $this = $(this);
        var rAdltVl = parseInt(($this.val() == '') ? 0 : $this.val());
        var rAdltRt = parseInt($this.data('rate'));
        var rAdltTt = rAdltVl * rAdltRt;

        var $rAmnt = $this.closest('tr').find('.js-row-amnt');
        $rAmnt.val(rAdltTt);

        var ttAdltVl = 0;
        $('.js-visitor-add-tbl .js-row-adlt').each(function () {
            var tval = parseInt($(this).val() == '' ? 0 : $(this).val());
            ttAdltVl = ttAdltVl + tval;
        });
        $('.js-tt-adlt').val(ttAdltVl);

        sumTtAmnt();

    });

    function sumTtAmnt() {
        var ttAmtVl = 0;
        $('.js-visitor-add-tbl .js-row-amnt').each(function () {
            var rAmtVl = parseInt($(this).val() == '' ? 0 : $(this).val());
            ttAmtVl = ttAmtVl + rAmtVl;
        });
        $('.js-tt-amnt').val(ttAmtVl);
    }

    $('.js-rdo-photo').change(function () {
        if ($(this).val() == 'YES')
        {
            $('#select_photo').removeAttr('disabled').attr("required", true);
        } else
        {
            $('#select_photo').removeAttr('required').attr("disabled", true);
        }
    });

</script>
<script>
    $("#frm_book_ticket").on("submit", function (event) {
        //event.preventDefault();
        if ($('.js-tt-amnt').val() == '' || $('.js-tt-amnt').val() == '0')
        {
            $('body').animate({
                scrollTop: ($(".table-responsive").offset().top - 200)
            }, 1000, function () {
                alert('Please enter Visitor details !!');
            });
            return false;
        }
        $sphot = $('#select_photo');
        if($sphot.prop('required') && $sphot.val() == '0') {
            alert('Please select Type of Photography');
            return false;
        }
    });
</script>
<script>
    var editTicket = <?php echo json_encode($eticket); ?>;
    if (editTicket !== "")
    {
        var book = editTicket.book;
        $("#datepicker").datepicker().datepicker("setDate", book.visit_date);
        $("#selectSlot").val(book.visit_time).trigger('change');

        var visitor = editTicket.visitor;
        $.each(visitor, function (index, value) {
            $('input[name="visitor[' + index + '][adlt]"]').val(value.adlt);
            $('input[name="visitor[' + index + '][chk]"]').trigger('click');
        });

        var photography = editTicket.photography;
        $('input[name="photography[is]"][value=' + photography.is + ']').prop("checked", true);
        if (typeof photography.type !== 'undefined') {
            $('#select_photo').val(photography.type);
            $('#select_photo').removeAttr('disabled').attr("required", true);
        }
        else
        {
            $('#select_photo').val('0');
            $('#select_photo').removeAttr('required').attr("disabled", true)
        }
    }
</script>
<script>
    function clearPwdSession() {
<?php $_SESSION['pwd_changed'] = ''; ?>
        return true;
    }
</script>
<?php include_once 'include/footer.php' ?>