<?php include('report.php'); ?>
<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


<form method="post" action="index.php?page=report/report_compare_detail" id="issue_filter" enctype="multipart/form-data">
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default panel-report">
    <div class="panel-body">
      <div class="hr_report">รายงานผลการดำเนินงาน</div>
      <div class="row">
        <div class="col-md-10 no-padding" style="margin-left:20px;">

        <div class="panel panel-default" style="background-color: #eceff1;">
            <div class="panel-body">
              <div class="row row-margin">
                <div class="col-md-2 col-sm-4 col-xs-12" style="font-weight: bold;">การแสดงผล</div>
                <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                  <input type="radio" value="1" name="year_set_1" id="year_set1_1" onclick="chk_radio_issue_year();" checked>
                  <label class="txt_report" for="year_set1_1">พ.ศ.</label>
                </div>
                <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                  <input type="radio" value="2" name="year_set_1" id="year_set1_2" onclick="chk_radio_issue_year();">
                  <label class="txt_report" for="year_set1_2">ค.ศ.</label>
                </div>
                <div class="col-md-4"></div>
              </div>
            </div>
          </div>

        <div class="panel panel-default" style="background-color: #eceff1;">
            <div class="panel-body">
              <div class="row row-margin">
                <div class="col-md-2 col-sm-4 col-xs-12" style="font-weight: bold;">ประเภทปี</div>
                <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                  <input type="radio" value="1" name="year_set_2" id="year_set2_1" onclick="chk_radio_issue();" checked>
                  <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                </div>
                <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                  <input type="radio" value="2" name="year_set_2" id="year_set2_2" onclick="chk_radio_issue();">
                  <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                </div>
                <div class="col-md-4"></div>
              </div>
            </div>
          </div>

    
          <div class="panel panel-default" style="background-color: #eceff1;">
            <div class="panel-body">
              <div class="row div_report date_issue row-margin">
                <div class="col-md-2" style="font-weight: bold;">ปีที่ต้องการเปรียบเทียบ</div>
                <div class="col-md-3 col-xs-12">
                  <span class="txt_report">ปี</span>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="issue_year1">
                  <select class="selectpicker form-control" name="year_com_1_1" id="year_com_1_1" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      $year_sum = $year+543;
                    ?>
                    <option value="<?=$year;?>"><?=$year_sum;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="issue_year2">
                  <select class="selectpicker form-control" name="year_com_2_1" id="year_com_2_1" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    $selected = '';
                    $ii = 0;
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      if($ii == 0){
                        $selected = 'selected';
                      }
                      $ii++;
                    ?>
                    <option value="<?=$year;?>"   ><?=$year;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <input type="hidden" class="year_start" value="<?=$date_year-5;?>">
                <input type="hidden" class="year_stop" value="<?=$date_year+1;?>">
                
                </div>
                
                <div class="col-md-5"></div>
              </div>
              <div class="row div_report date_issue ">
                <div class="col-md-2"></div>
                <div class="col-md-3 col-xs-12">
                  <span class="txt_report">เปรียบเทียบปี</span>
                </div>
                <div class="col-md-4 col-xs-12" id="quarter_txt">
                  
                <div class="issue_year1">
                  <select class="selectpicker form-control" name="year_com_1_2" id="year_com_1_2" onchange="select_month_issue();">
                  <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    $ii = 0;
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                      $year_sum = $year+543;
                      if($ii == 1){
                        $selected = 'selected';
                      }
                      $ii++;
                    ?>
                    <option value="<?=$year;?>" ><?=$year_sum;?></option>
                    <?php  } ?>
                  </select>
                </div>
                <div class="issue_year2">
                  <select class="selectpicker form-control" name="year_com_2_2" id="year_com_2_2" onchange="select_month_issue();">
                    <option value="">- เลือกปี -</option>
                    <?php
                    $date_year = date("Y");
                    for($year = $date_year+1; $year>=$date_year-5; $year--){
                    ?>
                    <option value="<?=$year;?>"><?=$year;?></option>
                    <?php  } ?>
                  </select>
                </div>
                </div>
                <div class="col-md-5"></div>
              </div>
            </div>
          </div>


    </div>
    </div>
    <hr style="margin-left:10px;margin-right:10px;">
    <div class="btn-report-issue">
      <button type="button" class="btn btn-success submit_report_issue_com">ตกลง</button>
    </div>
  </div>
  </div>

</form>


</div>
<script>
$(document).delegate(".submit_report_issue_com","click",function(){
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
  console.log($('#year_com_1_1').val(), $('#year_com_1_2').val());
  if(chk_radio == "1"){
    if($('#year_com_1_1').val() == "" || $('#year_com_1_2').val() == ""){
        alert("กรุณาเลือกปีที่ต้องการเปรียบเทียบ");
    } else if($('#year_com_1_1').val() == $('#year_com_1_2').val() ){
        alert("ปีที่ต้องการเปรียบเทียบซ้ำกัน");
    }else {
      $( "#issue_filter" ).submit();
    }
  } else{
    if($('#year_com_2_1').val() == "" || $('#year_com_2_2').val() == ""){
        alert("กรุณาเลือกปีที่ต้องการเปรียบเทียบ");
    } else if($('#year_com_2_1').val() == $('#year_com_2_2').val() ){
        alert("ปีที่ต้องการเปรียบเทียบซ้ำกัน");
    }else {
      $( "#issue_filter" ).submit();
    }
  }
    
});

function chk_select_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
    }else {
      var set_year = $('#issue_year2').val();
    }

    if(set_year == ""){
        $('#select_quarter_chk').attr('disabled', true);
        $('#month_issue_1').attr('disabled', true);
        $('#month_issue_2').attr('disabled', true);
        // $('#startDate').prop('disabled', 'disabled');
        $('#stopDate').prop('disabled', 'disabled');
        $('#startDate').attr('disabled', false);
        $('#select_quarter_chk').val('');
        $('#month_issue_1').val('');
        $('#month_issue_2').val('');
    }else {
      $('#select_quarter_chk').attr('disabled', false);
      $('#month_issue_1').attr('disabled', false);
      $('#month_issue_2').attr('disabled', false);
      // $('#startDate').prop('disabled', false);
      $('#startDate').prop('disabled', 'disabled');
      $('#stopDate').prop('disabled', 'disabled');

      // $('.selectpicker').selectpicker('refresh');
    }
}
chk_select_year();

$( "#issue_year1" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});
$( "#issue_year2" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});


function select_month_issue(){
var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
if(chk_radio == "1"){
  var lang = 'th';
  var th = true;
}else {
  var lang = 'en';
  var th = false;
}
var startDate = $('#startDate').val();


}
select_month_issue();

$( "#select_quarter_chk" ).change(function() {
  select_month_issue();
});
function set_date_select(){
  $('#issue_year1').attr('disabled', true);
  $('#issue_year2').attr('disabled', true);
  $('#stopDate').prop('disabled', false);
  $('.selectpicker').selectpicker('refresh');
  select_month_issue();
}


function getStartDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
      var set_month = $('#month_issue_1').val();
    }else {
      var set_year = $('#issue_year2').val();
      var set_month = $('#month_issue_2').val();
    }

if(select_quarter == ""){
  if(set_month == ""){
    set_month = "01";
  }
}else if (select_quarter == "1") {
  if(set_month == ""){
    set_month = "01";
  }
}else if (select_quarter == "2") {
  if(set_month == ""){
    set_month = "04";
  }
}else if (select_quarter == "3") {
  if(set_month == ""){
    set_month = "07";
  }
}else if (select_quarter == "4") {
  if(set_month == ""){
    set_month = "10";
  }
}


if(set_year == ""){
  set_year = year_start;
}
    d= "01-01-"+set_year;

    return d;
}

function getEndDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#issue_filter').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
      var set_month = $('#month_issue_1').val();
    }else {
      var set_year = $('#issue_year2').val();
      var set_month = $('#month_issue_2').val();
    }
    if(set_year == ""){
      set_year = year_stop;
    }

    if(select_quarter == ""){
      if(set_month == ""){
        set_month = "12";
      }
    }else if (select_quarter == "1") {
      if(set_month == ""){
        set_month = "03";
      }
    }else if (select_quarter == "2") {
      if(set_month == ""){
        set_month = "06";
      }
    }else if (select_quarter == "3") {
      if(set_month == ""){
        set_month = "09";
      }
    }else if (select_quarter == "4") {
      if(set_month == ""){
        set_month = "12";
      }
    }

    var set_date = new Date(new Date(set_year, parseInt(set_month),1)-1).getDate();


    return "31-12-"+set_year;
}

$(function(){
      $(".input-mask").inputmask();
    });

</script>
<style>
.icon-ico-ditp-43{
  display: inline-block;
  position: relative;
  top: -2px;
}
span .txt{
  margin-left: 0px !important;
  top: 1px;
  color: #388E3C !important;
  font-size: 14px !important;
  padding-left: 5px !important;
}
span .label{
  margin-left: 0px !important;
  top: 1px;
  color: #388E3C !important;
  font-size: 14px !important;
  padding-left: 5px !important;
}

.bootstrap-select.btn-group .dropdown-toggle .filter-option .icon-ico-ditp-43{
  display: none;
}
.bootstrap-select.btn-group .dropdown-menu li a.opt{
  padding-left: 5px;
}
</style>
