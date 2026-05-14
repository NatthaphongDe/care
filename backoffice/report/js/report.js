// issue
function chk_radio_issue(){
  var chk_radio = $('input[name=year_set_2]:checked', '#issue_filter').val();
  if(chk_radio == 1){
    $('.date_issue_panel').show();
    $('#startDate').prop('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#issue_year1').prop('disabled', false);
    $('#issue_year2').prop('disabled', false);

  }else {
    $('.date_issue_panel').hide();
    $('#startDate').prop('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#issue_year1').prop('disabled', false);
    $('#issue_year2').prop('disabled', false);

  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_issue_1').attr('disabled', true);
  $('#month_issue_2').attr('disabled', true);
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}

function chk_radio_issue_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
//   console.log(chk_radio);
  if(chk_radio == 1){
    $('.issue_year1').show();
    $('.issue_year2').hide();
    $('.months_issue1').show();
    $('.months_issue2').hide();

    $('#startDate').prop('disabled', false);
  }else {
    $('.issue_year2').show();
    $('.issue_year1').hide();
    $('.months_issue2').show();
    $('.months_issue1').hide();
    $('#startDate').prop('disabled', false);
  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_issue_1').attr('disabled', true);
  $('#month_issue_2').attr('disabled', true);
  $('#startDate').val('');
  $('#stopDate').val('');
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  select_month_issue();
  $('.selectpicker').selectpicker('refresh');
}
$(document).ready(function() {
  $('.issue_year2').hide();
  $('.months_issue2').hide();
});

function select_quarter(id){
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
  if(chk_radio == 1){

    $('.months_issue1 select option').remove();
    if(id == "1"){
      $('.months_issue1 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else if(id == "3"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else if(id == "4"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else {
      $('.months_issue1 select').append($('<option>', {
          value:'',
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

  }else {

    $('.months_issue2 select option').remove();
    if(id == "1"){
      $('.months_issue2 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

        }else if(id == "3"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

        }else if(id == "4"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

    }else {
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

$(document).delegate(".submit_report_issue","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
    }else {
      var set_year = $('#issue_year2').val();
    }
    if(set_year == ""){
      if($('#startDate').val() == "" || $('#stopDate').val() == ""){
        alert("กรุณาเลือกช่วงเวลา");
      }else {
        $( "#issue_filter" ).submit();
      }
    }else {
      $( "#issue_filter" ).submit();
    }
});

$(document).delegate(".submit_report_issue_modal","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
    }else {
      var set_year = $('#issue_year2').val();
    }
    if(set_year == ""){
      if($('#startDate').val() == "" || $('#stopDate').val() == ""){
        alert("กรุณาเลือกช่วงเวลา");
      }else {
        $( "#modal_filter_issue" ).submit();
      }
    }else {
      $( "#modal_filter_issue" ).submit();
    }
});
// end issue


// cost

function chk_radio_cost(){
  var chk_radio = $('input[name=year_set_2]:checked', '#cost_filter').val();
  if(chk_radio == 1){
    $('.date_cost_panel').show();
    $('#startDate').prop('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#cost_year1').prop('disabled', false);
    $('#cost_year2').prop('disabled', false);

  }else {
    $('.date_cost_panel').hide();
    $('#startDate').prop('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#cost_year1').prop('disabled', false);
    $('#cost_year2').prop('disabled', false);

  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_cost_1').attr('disabled', true);
  $('#month_cost_2').attr('disabled', true);
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}

function chk_radio_cost_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#cost_filter').val();
  if(chk_radio == 1){
    $('.cost_year1').show();
    $('.cost_year2').hide();
    $('.months_cost1').show();
    $('.months_cost2').hide();
    $('#startDate').prop('disabled', false);
  }else {
    $('.cost_year2').show();
    $('.cost_year1').hide();
    $('.months_cost2').show();
    $('.months_cost1').hide();
    $('#startDate').prop('disabled', false);
  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_cost_1').attr('disabled', true);
  $('#month_cost_2').attr('disabled', true);
  $('#startDate').val('');
  $('#stopDate').val('');
  select_month_cost();
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}
$(document).ready(function() {
  $('.cost_year2').hide();
  $('.months_cost2').hide();
});

function select_quarter_cost(id){
  var chk_radio = $('input[name=year_set_1]:checked', '#cost_filter').val();
  if(chk_radio == 1){

    $('.months_cost1 select option').remove();
    if(id == "1"){
      $('.months_cost1 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else if(id == "3"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else if(id == "4"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else {
      $('.months_cost1 select').append($('<option>', {
          value:'',
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

  }else {

    $('.months_cost2 select option').remove();
    if(id == "1"){
      $('.months_cost2 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

        }else if(id == "3"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

        }else if(id == "4"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

    }else {
        $('.months_cost2 select').append($('<option>', {
            value:'',
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
$(document).delegate(".submit_report_cost","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#cost_filter').val();
    if(chk_radio == "1"){
      var set_year = $('#cost_year1').val();
    }else {
      var set_year = $('#cost_year2').val();
    }
    if(set_year == ""){
      if($('#startDate').val() == "" || $('#stopDate').val() == ""){
        alert("กรุณาเลือกช่วงเวลา");
      }else {
        $( "#cost_filter" ).submit();
      }
    }else {
      $( "#cost_filter" ).submit();
    }
});

$(document).delegate(".submit_report_cost_modal","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_cost').val();
    if(chk_radio == "1"){
      var set_year = $('#cost_year1').val();
    }else {
      var set_year = $('#cost_year2').val();
    }
    if(set_year == ""){
      if($('#startDate').val() == "" || $('#stopDate').val() == ""){
        alert("กรุณาเลือกช่วงเวลา");
      }else {
        $( "#modal_filter_cost" ).submit();
      }
    }else {
      $( "#modal_filter_cost" ).submit();
    }
});
// end cost


// blacklist
function chk_radio_blacklist(){
    var chk_radio = $('input[name=year_set_2]:checked', '#blacklist_filter').val();
    if(chk_radio == 1){
        $('.date_blacklist_panel').show();
        $('#startDate').prop('disabled', false);
        $('#startDate').val('');
        $('#stopDate').val('');
        $('#blacklist_year1').prop('disabled', false);
        $('#blacklist_year2').prop('disabled', false);

    }else {
        $('.date_blacklist_panel').hide();
        $('#startDate').prop('disabled', false);
        $('#startDate').val('');
        $('#stopDate').val('');
        $('#blacklist_year1').prop('disabled', false);
        $('#blacklist_year2').prop('disabled', false);

    }
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_blacklist_1').attr('disabled', true);
    $('#month_blacklist_2').attr('disabled', true);
    // $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
}

function chk_radio_blacklist_year(){
    var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
    //   console.log(chk_radio);
    if(chk_radio == 1){
        $('.blacklist_year1').show();
        $('.blacklist_year2').hide();
        $('.months_blacklist1').show();
        $('.months_blacklist2').hide();

        $('#startDate').prop('disabled', false);
    }else {
        $('.blacklist_year2').show();
        $('.blacklist_year1').hide();
        $('.months_blacklist2').show();
        $('.months_blacklist1').hide();
        $('#startDate').prop('disabled', false);
    }               
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_blacklist_1').attr('disabled', true);
    $('#month_blacklist_2').attr('disabled', true);
    $('#startDate').val('');
    $('#stopDate').val('');
    // $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
select_month_blacklist();
    $('.selectpicker').selectpicker('refresh');
}
$(document).ready(function() {
    $('.blacklist_year2').hide();
    $('.months_blacklist2').hide();
});

function select_quarter_blacklist(id){
    console.log(id);
  $('.months_blacklist1 select option').remove();
  if(id == "1"){
    $('.months_blacklist1 select').append($('<option>', {
        value:'',
        text: '- เลือกเดือน -'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 01,
        text: 'มกราคม'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 02,
        text: 'กุมภาพันธ์'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 03,
        text: 'มีนาคม'
    }));
    $('.selectpicker').selectpicker('refresh');
  }else if(id == "2"){
      $('.months_blacklist1 select').append($('<option>', {
          value:'',
          text: '- เลือกเดือน -'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 04,
          text: 'เมษายน'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 05,
          text: 'พฤษภาคม'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 06,
          text: 'มิถุนายน'
      }));
      $('.selectpicker').selectpicker('refresh');

  }else if(id == "3"){
      $('.months_blacklist1 select').append($('<option>', {
          value:'',
          text: '- เลือกเดือน -'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 07,
          text: 'กรกฎาคม'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 08,
          text: 'สิงหาคม'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 09,
          text: 'กันยายน'
      }));
      $('.selectpicker').selectpicker('refresh');

  }else if(id == "4"){
      $('.months_blacklist1 select').append($('<option>', {
          value:'',
          text: '- เลือกเดือน -'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 10,
          text: 'ตุลาคม'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 11,
          text: 'พฤศจิกายน'
      }));
      $('.months_blacklist1 select').append($('<option>', {
          value: 12,
          text: 'ธันวาคม'
      }));
      $('.selectpicker').selectpicker('refresh');

  }else {
    $('.months_blacklist1 select').append($('<option>', {
        value:'',
        text: '- เลือกเดือน -'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 01,
        text: 'มกราคม'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 02,
        text: 'กุมภาพันธ์'
    }));
    $('.months_blacklist1 select').append($('<option>', {
        value: 03,
        text: 'มีนาคม'
    }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 04,
          text: 'เมษายน'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 05,
          text: 'พฤษภาคม'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 06,
          text: 'มิถุนายน'
    }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 07,
          text: 'กรกฎาคม'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 08,
          text: 'สิงหาคม'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 09,
          text: 'กันยายน'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 10,
          text: 'ตุลาคม'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 11,
          text: 'พฤศจิกายน'
      }));
    $('.months_blacklist1 select').append($('<option>', {
          value: 12,
          text: 'ธันวาคม'
      }));
    $('.selectpicker').selectpicker('refresh');
  }
}

$(document).delegate(".submit_report_blacklist","click",function(){
    var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
    if(chk_radio == "1"){
    var set_year = $('#blacklist_year1').val();
    }else {
    var set_year = $('#blacklist_year2').val();
    }
    if(set_year == ""){
    if($('#startDate').val() == "" || $('#stopDate').val() == ""){
        alert("กรุณาเลือกช่วงเวลา");
    }else {
        $( "#blacklist_filter" ).submit();
    }
    }else {
    $( "#blacklist_filter" ).submit();
    }
});

$(document).delegate(".submit_report_blacklist_modal","click",function(){
    var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_blacklist').val();
    if(chk_radio == "1"){
        var set_year = $('#blacklist_year1').val();
    }else {
        var set_year = $('#blacklist_year2').val();
    }
    if(set_year == ""){
        if($('#startDate').val() == "" || $('#stopDate').val() == ""){
            alert("กรุณาเลือกช่วงเวลา");
        }else {
            $( "#modal_filter_blacklist" ).submit();
        }
    }else {
        $( "#modal_filter_blacklist" ).submit();
    }
});

// $(document).delegate(".submit_report_blacklist","click",function(){
//   var set_year = $('#blacklist_year1').val();
//     console.log(set_year);
//     if(set_year == ""){
//     alert("กรุณาเลือกช่วงเวลา");
//   }else {
//     $("#blacklist_filter" ).submit();
//   }
// });

// $(document).delegate(".submit_report_blacklist_modal","click",function(){
//   var set_year = $('#blacklist_year1').val();
//   if(set_year == ""){
//     alert("กรุณาเลือกช่วงเวลา");

//   }else {
//     $( "#modal_filter_blacklist" ).submit();
//   }
// });
// end blacklist



//modal

// issue
function chk_radio_issue_modal(){
  var chk_radio = $('input[name=year_set_2]:checked', '#modal_filter_issue').val();
  if(chk_radio == 1){
    $('.date_issue_panel').show();
    $('#startDate').prop('disabled', false);
    $('#issue_year1').attr('disabled', false);
    $('#issue_year2').attr('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
  }else {
    $('.date_issue_panel').hide();
    $('#startDate').prop('disabled', false);
    $('#issue_year1').attr('disabled', false);
    $('#issue_year2').attr('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_issue_1').attr('disabled', true);
  $('#month_issue_2').attr('disabled', true);
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}

function chk_radio_issue_year_modal(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
  if(chk_radio == 1){
    $('.issue_year1').show();
    $('.issue_year2').hide();
    $('.months_issue1').show();
    $('.months_issue2').hide();
    $('#issue_year1').attr('disabled', false);
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#startDate').prop('disabled', false);
    select_month_issue();
  }else {
    $('.issue_year2').show();
    $('.issue_year1').hide();
    $('.months_issue2').show();
    $('.months_issue1').hide();
    $('#startDate').val('');
    $('#stopDate').val('');
    $('#startDate').prop('disabled', false);
    select_month_issue();
  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_issue_1').attr('disabled', true);
  $('#month_issue_2').attr('disabled', true);
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}


function select_quarter_modal(id){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
  if(chk_radio == 1){

    $('.months_issue1 select option').remove();
    if(id == "1"){
      $('.months_issue1 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else if(id == "3"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else if(id == "4"){
        $('.months_issue1 select').append($('<option>', {
            value:'',
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

    }else {
      $('.months_issue1 select').append($('<option>', {
          value:'',
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

  }else {

    $('.months_issue2 select option').remove();
    if(id == "1"){
      $('.months_issue2 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

        }else if(id == "3"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

        }else if(id == "4"){
        $('.months_issue2 select').append($('<option>', {
            value:'',
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

    }else {
        $('.months_issue2 select').append($('<option>', {
            value:'',
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
// cellback();
}

// end issue


// cost

function chk_radio_cost_modal(){
  var chk_radio = $('input[name=year_set_2]:checked', '#modal_filter_cost').val();
  if(chk_radio == 1){
    $('.date_cost_panel').show();
    $('#startDate').prop('disabled', false);

  }else {
    $('.date_cost_panel').hide();
    $('#startDate').prop('disabled', false);

  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk_cost').attr('disabled', true);
  $('#month_cost_1').attr('disabled', true);
  $('#month_cost_2').attr('disabled', true);
  // $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}

function chk_radio_cost_year_modal(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_cost').val();
  if(chk_radio == 1){
    $('.cost_year1').show();
    $('.cost_year2').hide();
    $('.months_cost1').show();
    $('.months_cost2').hide();
  }else {
    $('.cost_year2').show();
    $('.cost_year1').hide();
    $('.months_cost2').show();
    $('.months_cost1').hide();
  }
  $('.selectpicker').val('default');
  $('#select_quarter_chk').attr('disabled', true);
  $('#month_cost_1').attr('disabled', true);
  $('#month_cost_2').attr('disabled', true);
  $('#startDate').val('');
  $('#stopDate').val('');
  $('#startDate').prop('disabled', 'disabled');
  $('#stopDate').prop('disabled', 'disabled');
  $('.selectpicker').selectpicker('refresh');
}


function select_quarter_cost_modal(id){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_cost').val();
  if(chk_radio == 1){

    $('.months_cost1 select option').remove();
    if(id == "1"){
      $('.months_cost1 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else if(id == "3"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else if(id == "4"){
        $('.months_cost1 select').append($('<option>', {
            value:'',
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

    }else {
      $('.months_cost1 select').append($('<option>', {
          value:'',
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

  }else {

    $('.months_cost2 select option').remove();
    if(id == "1"){
      $('.months_cost2 select').append($('<option>', {
          value:'',
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
    }else if(id == "2"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

        }else if(id == "3"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

        }else if(id == "4"){
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

    }else {
        $('.months_cost2 select').append($('<option>', {
            value:'',
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

// end cost

// blacklist
function chk_radio_issue_modal(){
    var chk_radio = $('input[name=year_set_2]:checked', '#modal_filter_blacklist').val();
    if(chk_radio == 1){
      $('.date_blacklist_panel').show();
      $('#startDate').prop('disabled', false);
      $('#blacklist_year1').attr('disabled', false);
      $('#blacklist_year2').attr('disabled', false);
      $('#startDate').val('');
      $('#stopDate').val('');
    }else {
      $('.date_blacklist_panel').hide();
      $('#startDate').prop('disabled', false);
      $('#blacklist_year1').attr('disabled', false);
      $('#blacklist_year2').attr('disabled', false);
      $('#startDate').val('');
      $('#stopDate').val('');
    }
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_blacklist_1').attr('disabled', true);
    $('#month_blacklist_2').attr('disabled', true);
    // $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
  }
  
  function chk_radio_blacklist_year_modal(){
    var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_blacklist').val();
    if(chk_radio == 1){
      $('.blacklist_year1').show();
      $('.blacklist_year2').hide();
      $('.months_blacklist1').show();
      $('.months_blacklist2').hide();
      $('#blacklist_year1').attr('disabled', false);
      $('#startDate').val('');
      $('#stopDate').val('');
      $('#startDate').prop('disabled', false);
      select_month_blacklist();
    }else {
      $('.blacklist_year2').show();
      $('.blacklist_year1').hide();
      $('.months_blacklist2').show();
      $('.months_blacklist1').hide();
      $('#startDate').val('');
      $('#stopDate').val('');
      $('#startDate').prop('disabled', false);
      select_month_blacklist();
    }
    $('.selectpicker').val('default');
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_blacklist_1').attr('disabled', true);
    $('#month_blacklist_2').attr('disabled', true);
    // $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
    $('.selectpicker').selectpicker('refresh');
  }
  
  
  function select_quarter_blacklist_modal(id){
    var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_blacklist').val();
    if(chk_radio == 1){
  
      $('.months_blacklist1 select option').remove();
      if(id == "1"){
        $('.months_blacklist1 select').append($('<option>', {
            value:'',
            text: '- เลือกเดือน -'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 01,
            text: 'มกราคม'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 02,
            text: 'กุมภาพันธ์'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 03,
            text: 'มีนาคม'
        }));
  
        $('.selectpicker').selectpicker('refresh');
      }else if(id == "2"){
          $('.months_blacklist1 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 04,
              text: 'เมษายน'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 05,
              text: 'พฤษภาคม'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 06,
              text: 'มิถุนายน'
          }));
          $('.selectpicker').selectpicker('refresh');
  
      }else if(id == "3"){
          $('.months_blacklist1 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 07,
              text: 'กรกฎาคม'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 08,
              text: 'สิงหาคม'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 09,
              text: 'กันยายน'
          }));
          $('.selectpicker').selectpicker('refresh');
  
      }else if(id == "4"){
          $('.months_blacklist1 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 10,
              text: 'ตุลาคม'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 11,
              text: 'พฤศจิกายน'
          }));
          $('.months_blacklist1 select').append($('<option>', {
              value: 12,
              text: 'ธันวาคม'
          }));
          $('.selectpicker').selectpicker('refresh');
  
      }else {
        $('.months_blacklist1 select').append($('<option>', {
            value:'',
            text: '- เลือกเดือน -'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 01,
            text: 'มกราคม'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 02,
            text: 'กุมภาพันธ์'
        }));
        $('.months_blacklist1 select').append($('<option>', {
            value: 03,
            text: 'มีนาคม'
        }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 04,
              text: 'เมษายน'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 05,
              text: 'พฤษภาคม'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 06,
              text: 'มิถุนายน'
        }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 07,
              text: 'กรกฎาคม'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 08,
              text: 'สิงหาคม'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 09,
              text: 'กันยายน'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 10,
              text: 'ตุลาคม'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 11,
              text: 'พฤศจิกายน'
          }));
        $('.months_blacklist1 select').append($('<option>', {
              value: 12,
              text: 'ธันวาคม'
          }));
        $('.selectpicker').selectpicker('refresh');
      }
  
    }else {
  
      $('.months_blacklist2 select option').remove();
      if(id == "1"){
        $('.months_blacklist2 select').append($('<option>', {
            value:'',
            text: '- เลือกเดือน -'
        }));
        $('.months_blacklist2 select').append($('<option>', {
            value: 01,
            text: 'January'
        }));
        $('.months_blacklist2 select').append($('<option>', {
            value: 02,
            text: 'February'
        }));
        $('.months_blacklist2 select').append($('<option>', {
            value: 03,
            text: 'March'
        }));
        $('.selectpicker').selectpicker('refresh');
      }else if(id == "2"){
          $('.months_blacklist2 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 04,
              text: 'April'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 05,
              text: 'May'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 06,
              text: 'June'
          }));
          $('.selectpicker').selectpicker('refresh');
  
          }else if(id == "3"){
          $('.months_blacklist2 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 07,
              text: 'July'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 08,
              text: 'August'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 09,
              text: 'September'
          }));
          $('.selectpicker').selectpicker('refresh');
  
          }else if(id == "4"){
          $('.months_blacklist2 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 10,
              text: 'October'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 11,
              text: 'November'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 12,
              text: 'December'
          }));
          $('.selectpicker').selectpicker('refresh');
  
      }else {
          $('.months_blacklist2 select').append($('<option>', {
              value:'',
              text: '- เลือกเดือน -'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 01,
              text: 'January'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 02,
              text: 'February'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 03,
              text: 'March'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 04,
              text: 'April'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 05,
              text: 'May'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 06,
              text: 'June'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 07,
              text: 'July'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 08,
              text: 'August'
          }));
          $('.months_blacklist2 select').append($('<option>', {
              value: 09,
              text: 'September'
          }));
          $('.months_blacklist2 select').append($('<option>', {
            value: 10,
            text: 'October'
          }));
          $('.months_blacklist2 select').append($('<option>', {
            value: 11,
            text: 'November'
          }));
          $('.months_blacklist2 select').append($('<option>', {
            value: 12,
            text: 'December'
          }));
        $('.selectpicker').selectpicker('refresh');
      }
    }
  // cellback();
  }
  
  // end blacklist
