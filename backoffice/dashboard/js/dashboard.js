function chk_radio_issue() {
    var chk_radio = $('input[name=year_type_case]:checked').val();
    if (chk_radio == 1) {
        $('.box_costom').show();
        $('.gp_month').show();
        $('.box_Quarterly').show();
        $('#startDate').prop('disabled', false);
    } else {
        $('.box_costom').hide();
        $('.gp_month').hide();
        $('.box_Quarterly').hide();
        $('#startDate').prop('disabled', 'disabled');
    }
    $("#select_quarter_chk").val('default');
    $("#month_issue_1").val('default');
    $("#month_issue_2").val('default');
    $("#issue_year1").val('default');
    $("#issue_year2").val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_issue_1').attr('disabled', true);
    $('#month_issue_2').attr('disabled', true);
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
}

function chk_radio_issue_year() {
    var chk_radio = $('input[name=display_case]:checked').val();
    if (chk_radio == 1) {
        $('.issue_year1').show();
        $('.issue_year2').hide();
        $('.months_issue1').show();
        $('.months_issue2').hide();
    } else {
        $('.issue_year2').show();
        $('.issue_year1').hide();
        $('.months_issue2').show();
        $('.months_issue1').hide();
    }
    $('#startDate').val('');
    $('#stopDate').val('');
    $("#select_quarter_chk").val('default');
    $("#month_issue_1").val('default');
    $("#month_issue_2").val('default');
    $("#issue_year1").val('default');
    $("#issue_year2").val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_issue_1').attr('disabled', true);
    $('#month_issue_2').attr('disabled', true);
    $('#startDate').prop('disabled', false);
    $('#stopDate').prop('disabled', 'disabled');
    select_month_issue();
    $('.selectpicker').selectpicker('refresh');

}

function chk_radio_issue_year_all() {
    var chk_radio = $('input[name=display_case_all]:checked').val();
    if (chk_radio == 1) {
        $('.issue_year1_all').show();
        $('.issue_year2_all').hide();
        $('.months_issue1_all').show();
        $('.months_issue2_all').hide();
    } else {
        $('.issue_year2_all').show();
        $('.issue_year1_all').hide();
        $('.months_issue2_all').show();
        $('.months_issue1_all').hide();
    }
    $('#startDate_all').val('');
    $('#stopDate_all').val('');
    $("#select_quarter_chk_all").val('default');
    $("#month_issue_1_all").val('default');
    $("#month_issue_2_all").val('default');
    $("#issue_year1_all").val('default');
    $("#issue_year2_all").val('default');
    $('#select_quarter_chk_all').attr('disabled', true);
    $('#month_issue_1_all').attr('disabled', true);
    $('#month_issue_2_all').attr('disabled', true);
    $('#startDate_all').prop('disabled', false);
    $('#stopDate_all').prop('disabled', 'disabled');
    select_month_issue();
    $('.selectpicker').selectpicker('refresh');

}
$(document).ready(function() {
    $('.issue_year2').hide();
    $('.months_issue2').hide();
});

function select_quarter(id) {
    var chk_radio = $('input[name=display_case]:checked').val();
    if (chk_radio == 1) {

        $('.months_issue1 select option').remove();
        if (id == "1") {
            $('.months_issue1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_issue1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_issue1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_issue1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {
            $('.months_issue1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_issue1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        }

    } else {

        $('.months_issue2 select option').remove();
        if (id == "1") {
            $('.months_issue2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_issue2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_issue2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_issue2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {
            $('.months_issue2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_issue2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');
        }
    }

}
// end issue


// cost

function chk_radio_cost() {
    var chk_radio = $('input[name=year_type_case]:checked').val();
    if (chk_radio == 1) {
        $('.date_cost_panel').show();

    } else {
        $('.date_cost_panel').hide();

    }
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_cost_1').attr('disabled', true);
    $('#month_cost_2').attr('disabled', true);
    $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
}

function chk_radio_cost_year() {
    var chk_radio = $('input[name=display_case]:checked').val();
    if (chk_radio == 1) {
        $('.cost_year1').show();
        $('.cost_year2').hide();
        $('.months_cost1').show();
        $('.months_cost2').hide();
    } else {
        $('.cost_year2').show();
        $('.cost_year1').hide();
        $('.months_cost2').show();
        $('.months_cost1').hide();
    }
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_cost_1').attr('disabled', true);
    $('#month_cost_2').attr('disabled', true);
    $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
}
$(document).ready(function() {
    $('.cost_year2').hide();
    $('.months_cost2').hide();
});

function select_quarter_cost(id) {
    var chk_radio = $('input[name=display_case]:checked').val();
    if (chk_radio == 1) {

        $('.months_cost1 select option').remove();
        if (id == "1") {
            $('.months_cost1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {
            $('.months_cost1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        }

    } else {

        $('.months_cost2 select option').remove();
        if (id == "1") {
            $('.months_cost2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {
            $('.months_cost2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');
        }
    }

}

// end issue
////////////////////////////////////////////////////////////////////////////////////////////////////  cat   ////////////////////////////////////////////////////////////////////////////////////
function chk_radio_cat_year() { // เช็คปี
    var chk_radio = $('input[name=year_type_cat]:checked').val();
    if (chk_radio == 1) {
        $('.box_case_Quarterly').show();
        $('.box_cat_monthly').show();
        $('.box_cat_costom').show();
        $('.issue_year_cat1').hide();
        $('.issue_year_cat2').show();


    } else {
        $('.issue_year_cat1').show();
        $('.issue_year_cat2').hide();
        $('.box_case_Quarterly').hide();
        $('.box_cat_monthly').hide();
        $('.box_cat_costom').hide();
    }
    var chk_radio_disp = $('input[name=display_cat]:checked').val();
    if (chk_radio_disp == 1) {
        $('.issue_year_cat1').show();
        $('.issue_year_cat2').hide();
        $('.months_cost_cat1').show();
        $('.months_cost_cat2').hide();
    } else {
        $('.issue_year_cat1').hide();
        $('.issue_year_cat2').show();
        $('.months_cost_cat2').show();
        $('.months_cost_cat1').hide();
    }
    //  default
    $('#issue_year_cat1').val('default');
    $('#issue_year_cat2').val('default');
    $('#startDate_cat').val('');
    $('#stopDate_cat').val('');
    $('#select_quarter_chk_cat').val('default');
    $('#month_issue_cat1').val('default');
    $('#month_issue_cat2').val('default');

    $('#select_quarter_chk_cat').attr('disabled', true);
    $('#month_issue_cat1').attr('disabled', true);
    $('#month_issue_cat2').attr('disabled', true);
    $('#stopDate_cat').attr('disabled', true);
    $('#startDate_cat').attr('disabled', false);
    select_month_cat();
    $('.selectpicker').selectpicker('refresh');
}


function chk_radio_cat_type() {
    var chk_radio = $('input[name=year_type_cat]:checked').val();
    if (chk_radio == 1) {
        $('.box_case_Quarterly').show();
        $('.box_cat_monthly').show();
        $('.box_cat_costom').show();



    } else {
        $('.box_case_Quarterly').hide();
        $('.box_cat_monthly').hide();
        $('.box_cat_costom').hide();


    }

    $('#issue_year_cat1').val('default');
    $('#issue_year_cat2').val('default');
    $('#startDate_cat').val('');
    $('#stopDate_cat').val('');
    $('#select_quarter_chk_cat').val('default');
    $('#month_issue_cat1').val('default');
    $('#month_issue_cat2').val('default');

    $('#select_quarter_chk_cat').attr('disabled', true);
    $('#month_issue_cat1').attr('disabled', true);
    $('#month_issue_cat2').attr('disabled', true);
    $('#stopDate_cat').attr('disabled', true);
    $('#startDate_cat').attr('disabled', false);


    $('.selectpicker').selectpicker('refresh');
}

function select_quarter_cat(id) {
    $('#month_issue_1').val('default');
    $('#month_issue_2').val('default');


    var chk_radio = $('input[name=display_cat]:checked').val();
    //  console.log('-----');
    //  console.log(chk_radio);
    //  console.log('-----');
    if (chk_radio == 1) {

        $('.months_cost_cat1 select option').remove();
        if (id == "1") {
            $('.months_cost_cat1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_cat1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_cat1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_cat1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_cat1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_cat1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        }

    } else {

        $('.months_cost_cat2 select option').remove();
        if (id == "1") {
            $('.months_cost_cat2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_cat2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_cat2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_cat2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_cat2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_cat2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');
        }
    }
}
// end cost

///////////////////////////////////////   all ativate  /////////////////////////////////////

function chk_radio_activity_year() { // เช็คปี
    var chk_radio = $('input[name=year_type_activity]:checked').val();
    if (chk_radio == 1) {
        $('.box_activity_Quarterly').show();
        $('.box_activity_monthly').show();
        $('.box_activity_costom').show();
        $('.issue_year_activity1').hide();
        $('.issue_year_activity2').show();


    } else {
        $('.issue_year_activity1').show();
        $('.issue_year_activity2').hide();
        $('.box_case_Quarterly').hide();
        $('.box_activity_monthly').hide();
        $('.box_activity_costom').hide();
    }
    var chk_radio_disp = $('input[name=display_activity]:checked').val();
    if (chk_radio_disp == 1) {
        $('.issue_year_activity1').show();
        $('.issue_year_activity2').hide();
        $('.months_cost_activity1').show();
        $('.months_cost_activity2').hide();
    } else {
        $('.issue_year_activity1').hide();
        $('.issue_year_activity2').show();
        $('.months_cost_activity2').show();
        $('.months_cost_activity1').hide();
    }
    //  default
    $('#issue_year_activity1').val('default');
    $('#issue_year_activity2').val('default');
    $('#startDate_activity').val('');
    $('#stopDate_activity').val('');
    $('#select_quarter_chk_activity').val('default');
    $('#month_issue_activity1').val('default');
    $('#month_issue_activity2').val('default');

    $('#select_quarter_chk_activity').attr('disabled', true);
    $('#month_issue_activity1').attr('disabled', true);
    $('#month_issue_activity2').attr('disabled', true);
    $('#stopDate_activity').attr('disabled', true);

    select_month_activity();
    $('#startDate_activity').attr('disabled', false);
    $('.selectpicker').selectpicker('refresh');
}


function chk_radio_activity_type() {
    var chk_radio = $('input[name=year_type_activity]:checked').val();
    if (chk_radio == 1) {
        $('.box_activity_Quarterly').show();
        $('.box_box_activity_Quarterly_monthly').show();
        $('.box_activity_costom').show();



    } else {
        $('.box_activity_Quarterly').hide();
        $('.box_box_activity_Quarterly_monthly').hide();
        $('.box_activity_costom').hide();


    }

    $('#issue_year_activity1').val('default');
    $('#issue_year_activity2').val('default');
    $('#startDate_activity').val('');
    $('#stopDate_activity').val('');
    $('#select_quarter_chk_activity').val('default');
    $('#month_issue_activity1').val('default');
    $('#month_issue_activity2').val('default');

    $('#select_quarter_chk_activity').attr('disabled', true);
    $('#month_issue_activity1').attr('disabled', true);
    $('#month_issue_activity2').attr('disabled', true);
    $('#stopDate_activity').attr('disabled', true);
    $('#startDate_activity').attr('disabled', false);


    $('.selectpicker').selectpicker('refresh');
}




function select_quarter_activity(id) {
    $('#month_issue_1').val('default');
    $('#month_issue_2').val('default');


    var chk_radio = $('input[name=display_activity]:checked').val();
    //  console.log('-----');
    //  console.log(chk_radio);
    //  console.log('-----');
    if (chk_radio == 1) {

        $('.months_cost_activity1 select option').remove();
        if (id == "1") {
            $('.months_cost_activity1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_activity1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_activity1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_activity1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_activity1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_activity1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        }

    } else {

        $('.months_cost_activity2 select option').remove();
        if (id == "1") {
            $('.months_cost_activity2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_activity2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_activity2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_activity2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_activity2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_activity2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');
        }
    }
}



///////////////////////////////////////   kpi  ///////////////////////////////////////////////////////////////

function chk_radio_kpi_year() { // เช็คปี
    var chk_radio = $('input[name=year_type_kpi]:checked').val();
    if (chk_radio == 1) {
        $('.box_kpi_Quarterly').show();
        $('.box_kpi_monthly').show();
        $('.box_kpi_costom').show();
        $('.issue_year_kpi1').hide();
        $('.issue_year_kpi2').show();


    } else {
        $('.issue_year_kpi1').show();
        $('.issue_year_kpi2').hide();
        $('.box_case_Quarterly').hide();
        $('.box_kpi_monthly').hide();
        $('.box_kpi_costom').hide();
    }
    var chk_radio_disp = $('input[name=display_kpi]:checked').val();
    if (chk_radio_disp == 1) {
        $('.issue_year_kpi1').show();
        $('.issue_year_kpi2').hide();
        $('.months_cost_kpi1').show();
        $('.months_cost_kpi2').hide();
    } else {
        $('.issue_year_kpi1').hide();
        $('.issue_year_kpi2').show();
        $('.months_cost_kpi2').show();
        $('.months_cost_kpi1').hide();
    }
    //  default
    $('#issue_year_kpi1').val('default');
    $('#issue_year_kpi2').val('default');
    $('#startDate_kpi').val('');
    $('#stopDate_kpi').val('');
    $('#select_quarter_chk_kpi').val('default');
    $('#month_issue_kpi1').val('default');
    $('#month_issue_kpi2').val('default');

    $('#select_quarter_chk_kpi').attr('disabled', true);
    $('#month_issue_kpi1').attr('disabled', true);
    $('#month_issue_kpi2').attr('disabled', true);
    $('#stopDate_kpi').attr('disabled', true);
    select_month_kpi();
    $('#startDate_kpi').attr('disabled', false);

    $('.selectpicker').selectpicker('refresh');
}


function chk_radio_kpi_type() {
    var chk_radio = $('input[name=year_type_kpi]:checked').val();
    if (chk_radio == 1) {
        $('.box_kpi_Quarterly').show();
        $('.box_kpi_monthly').show();
        $('.box_kpi_costom').show();



    } else {
        $('.box_kpi_Quarterly').hide();
        $('.box_kpi_monthly').hide();
        $('.box_kpi_costom').hide();


    }

    $('#issue_year_kpi1').val('default');
    $('#issue_year_kpi2').val('default');
    $('#startDate_kpi').val('');
    $('#stopDate_kpi').val('');
    $('#select_quarter_chk_kpi').val('default');
    $('#month_issue_kpi1').val('default');
    $('#month_issue_kpi2').val('default');

    $('#select_quarter_chk_kpi').attr('disabled', true);
    $('#month_issue_kpi1').attr('disabled', true);
    $('#month_issue_kpi2').attr('disabled', true);
    $('#stopDate_kpi').attr('disabled', true);
    $('#startDate_kpi').attr('disabled', false);


    $('.selectpicker').selectpicker('refresh');
}




function select_quarter_kpi(id) {
    $('#month_issue_1').val('default');
    $('#month_issue_2').val('default');


    var chk_radio = $('input[name=display_kpi]:checked').val();
    //  console.log('-----');
    //  console.log(chk_radio);
    //  console.log('-----');
    if (chk_radio == 1) {

        $('.months_cost_kpi1 select option').remove();
        if (id == "1") {
            $('.months_cost_kpi1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_kpi1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_kpi1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_kpi1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_kpi1 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 01,
                text: 'มกราคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 02,
                text: 'กุมภาพันธ์'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 03,
                text: 'มีนาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 04,
                text: 'เมษายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 05,
                text: 'พฤษภาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 06,
                text: 'มิถุนายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 07,
                text: 'กรกฎาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 08,
                text: 'สิงหาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 09,
                text: 'กันยายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 10,
                text: 'ตุลาคม'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 11,
                text: 'พฤศจิกายน'
            }));
            $('.months_cost_kpi1 select').append($('<option>', {
                value: 12,
                text: 'ธันวาคม'
            }));
            $('.selectpicker').selectpicker('refresh');
        }

    } else {

        $('.months_cost_kpi2 select option').remove();
        if (id == "1") {
            $('.months_cost_kpi2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.selectpicker').selectpicker('refresh');
        } else if (id == "2") {
            $('.months_cost_kpi2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "3") {
            $('.months_cost_kpi2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else if (id == "4") {
            $('.months_cost_kpi2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');

        } else {

            $('.months_cost_kpi2 select').append($('<option>', {
                value: '',
                text: '- เลือกเดือน -'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 01,
                text: 'January'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 02,
                text: 'February'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 03,
                text: 'March'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 04,
                text: 'April'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 05,
                text: 'May'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 06,
                text: 'June'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 07,
                text: 'July'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 08,
                text: 'August'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 09,
                text: 'September'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 10,
                text: 'October'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 11,
                text: 'November'
            }));
            $('.months_cost_kpi2 select').append($('<option>', {
                value: 12,
                text: 'December'
            }));
            $('.selectpicker').selectpicker('refresh');
        }
    }
}