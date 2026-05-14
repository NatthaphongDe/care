<?php include('report.php'); ?>
<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


<form method="post" action="index.php?page=report/report_blacklist_detail" id="blacklist_filter" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default panel-report">
        <div class="panel-body">
          <div class="hr_report">รายงานสถานะการเฝ้าระวัง</div>
          <div class="row" style="padding:0 20px;">
            <div class="col-md-12 no-padding">
              <div class="panel panel-default" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row row-margin">
                    <div class="col-md-2 col-sm-4 col-xs-12" style="font-weight: bold;">การแสดงผล</div>
                    <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                      <input type="radio" value="1" name="year_set_1" id="year_set1_1" onclick="chk_radio_blacklist_year();" checked>
                      <label class="txt_report" for="year_set1_1">พ.ศ.</label>
                    </div>
                    <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                      <input type="radio" value="2" name="year_set_1" id="year_set1_2" onclick="chk_radio_blacklist_year();">
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
                      <input type="radio" value="1" name="year_set_2" id="year_set2_1" onclick="chk_radio_blacklist();" checked>
                      <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                    </div>
                    <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                      <input type="radio" value="2" name="year_set_2" id="year_set2_2" onclick="chk_radio_blacklist();">
                      <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-default" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row div_report date_blacklist row-margin">
                    <div class="col-md-2" style="font-weight: bold;">ช่วงเวลา</div>
                    <div class="col-md-3 col-xs-12">
                      <span class="txt_report">รายปี</span>
                    </div>
                    <div class="col-md-4 col-xs-12">
                      <div class="blacklist_year1">
                      <select class="selectpicker form-control" name="blacklist_year_th" id="blacklist_year1" onchange="select_month_blacklist();">
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
                    <div class="blacklist_year2">
                      <select class="selectpicker form-control" name="blacklist_year_en" id="blacklist_year2" onchange="select_month_blacklist();">
                        <option value="">- เลือกปี -</option>
                        <?php
                        $date_year = date("Y");
                        for($year = $date_year+1; $year>=$date_year-5; $year--){
                        ?>
                        <option value="<?=$year;?>"><?=$year;?></option>
                        <?php  } ?>
                      </select>
                    </div>
                    <input type="hidden" class="year_start" value="<?=$date_year-5;?>">
                    <input type="hidden" class="year_stop" value="<?=$date_year+1;?>">
                    </div>
                    <div class="col-md-5"></div>
                  </div>
                  <div class="row div_report date_blacklist date_blacklist_panel">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 col-xs-12">
                      <span class="txt_report">รายไตรมาส</span>
                    </div>
                    <div class="col-md-4 col-xs-12" id="quarter_txt">
                      <select class="selectpicker form-control" name="quarter" id="select_quarter_chk" onchange="select_quarter_blacklist(this.value);">
                        <option value="">- เลือกไตรมาส -</option>
                        <option value="1">ไตรมาส ที่ 1</option>
                        <option value="2">ไตรมาส ที่ 2</option>
                        <option value="3">ไตรมาส ที่ 3</option>
                        <option value="4">ไตรมาส ที่ 4</option>
                      </select>
                    </div>
                    <div class="col-md-5"></div>
                  </div>
                  <div class="row div_report date_blacklist date_blacklist_panel">
                    <div class="col-md-2"></div>
                    <div class="col-md-3 col-xs-12">
                      <span class="txt_report">รายเดือน</span>
                    </div>
                    <div class="col-md-4 col-xs-12">
                      <div class="months_blacklist1">
                      <select class="selectpicker form-control" name="month_blacklist_th" id="month_blacklist_1" onchange="select_month_blacklist();">
                        <option value="">- เลือกเดือน -</option>
                        <?php
                        $months = array(
                                  "01"=>'มกราคม',
                                  "02"=>'กุมภาพันธ์',
                                  "03"=>'มีนาคม',
                                  "04"=>'เมษายน',
                                  "05"=>'พฤษภาคม',
                                  "06"=>'มิถุนายน',
                                  "07"=>'กรกฎาคม ',
                                  "08"=>'สิงหาคม',
                                  "09"=>'กันยายน',
                                  "10"=>'ตุลาคม',
                                  "11"=>'พฤศจิกายน',
                                  "12"=>'ธันวาคม',
                              );
                              foreach ($months as $key => $value) {
                        ?>
                        <option value="<?=$key?>"><?=$value?></option>
                        <?php } ?>
                      </select>
                    </div>

                      <div class="months_blacklist2">
                      <select class="selectpicker form-control" name="month_blacklist_en" id="month_blacklist_2" onchange="select_month_blacklist();">
                        <option value="">- เลือกเดือน -</option>
                        <?php
                        $months = array(
                                  "01"=>'January',
                                  "02"=>'February',
                                  "03"=>'March',
                                  "04"=>'April',
                                  "05"=>'May',
                                  "06"=>'June',
                                  "07"=>'July ',
                                  "08"=>'August',
                                  "09"=>'September',
                                  "10"=>'October',
                                  "11"=>'November',
                                  "12"=>'December',
                              );
                              foreach ($months as $key => $value) {
                        ?>
                        <option value="<?=$key?>"><?=$value?></option>
                        <?php } ?>
                      </select>
                    </div>
                    </div>
                    <div class="col-md-5"></div>
                  </div>
                </div>
              </div>

              <div class="panel panel-default date_blacklist_panel" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row date_blacklist row-margin">
                    <input type="hidden" class="chk_date_select" value="0">
                    <div class="col-md-2 col-sm-12 col-xs-12" style=" padding-bottom:10px;">
                      <span style="font-weight: bold;">กำหนดเอง</span>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12"><span>Start Date : </span></div>
                    <div class="col-md-7 col-sm-9 col-xs-12">
                      <div class="form-group">
                        <div class="input-group date" id="datetimepicker" onchange="set_date_select()">
                          <input type="text" class="form-control input-mask" name="date_start" id="startDate" data-inputmask="'mask':'99/99/9999'" readonly />
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3 col-sm-3 col-xs-12"><span>Stop Date : </span></div>
                    <div class="col-md-7 col-sm-9 col-xs-12">
                      <div class="form-group">
                        <div class="input-group date" id="datetimepicker2">
                          <input type="text" class="form-control input-mask" name="date_stop" id="stopDate" data-inputmask="'mask':'99/99/9999'" readonly />
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="margin-left:10px;margin-right:10px;">
            </div>
            <div class="col-md-12 no-padding">
              <div class="row div_report">
                <div class="col-md-4">สถานะบริษัท</div>
                <div class="col-md-8">
                  <select class="selectpicker form-control" name="reliable">
                    <option value="">- สถานะบริษัททั้งหมด -</option>
                    <option value="1">Watchlist</option>
                    <option value="2">Blacklist</option>
                  </select>
                </div>
              </div>
              <hr style="margin-left:10px;margin-right:10px;">
            </div>
          </div>
        </div>
        <div class="btn-report-blacklist">
          <button type="button" class="btn btn-success submit_report_blacklist">ตกลง</button>
        </div>
      </div>
    </div>
  </div>
</form>


<script>

function chk_select_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
    if(chk_radio == "1"){
      var set_year = $('#blacklist_year1').val();
    }else {
      var set_year = $('#blacklist_year2').val();
    }

    if(set_year == ""){
        $('#select_quarter_chk').attr('disabled', true);
        $('#month_blacklist_1').attr('disabled', true);
        $('#month_blacklist_2').attr('disabled', true);
        // $('#startDate').prop('disabled', 'disabled');
        $('#stopDate').prop('disabled', 'disabled');
        $('#startDate').attr('disabled', false);
        $('#select_quarter_chk').val('');
        $('#month_blacklist_1').val('');
        $('#month_blacklist_2').val('');
    }else {
      $('#select_quarter_chk').attr('disabled', false);
      $('#month_blacklist_1').attr('disabled', false);
      $('#month_blacklist_2').attr('disabled', false);
      // $('#startDate').prop('disabled', false);
      $('#startDate').prop('disabled', 'disabled');
      $('#stopDate').prop('disabled', 'disabled');

      // $('.selectpicker').selectpicker('refresh');
    }
}
chk_select_year();

$( "#blacklist_year1" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});
$( "#blacklist_year2" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});


function select_month_blacklist(){
var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
if(chk_radio == "1"){
  var lang = 'th';
  var th = true;
}else {
  var lang = 'en';
  var th = false;
}
var startDate = $('#startDate').val();
if (startDate != ""){
  var date_split = startDate.split("/");
  if(chk_radio == "1"){
    var year_set = parseInt(date_split[2]);
    var split_date = date_split[0]+"-"+date_split[1]+"-"+(year_set-543);
  }else {
    var split_date = date_split[0]+"-"+date_split[1]+"-"+date_split[2];
  }
  start = split_date;
  end = getEndDate();
  }else {
    start = getStartDate();
    end = getEndDate();
  }
  // console.log(getStartDate());
  // console.log(getEndDate());
     $('#datetimepicker').datepicker("remove");
     $('#datetimepicker2').datepicker("remove");

     $('#datetimepicker').datepicker({
             'format': 'dd/mm/yyyy',
             'startDate': getStartDate(),
             'endDate': getEndDate(),
             'language': lang,
             'thaiyear': th,
             'autoclose': true
         });
     $('#datetimepicker2').datepicker({
             'format': 'dd/mm/yyyy',
             'startDate': start,
             'endDate': end,
             'language': lang,
             'thaiyear': th,
             'autoclose': true
         });

}
select_month_blacklist();

$( "#select_quarter_chk" ).change(function() {
  select_month_blacklist();
});
function set_date_select(){
  $('#blacklist_year1').attr('disabled', true);
  $('#blacklist_year2').attr('disabled', true);
  $('#stopDate').prop('disabled', false);
  $('.selectpicker').selectpicker('refresh');
  select_month_blacklist();
}


function getStartDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#blacklist_year1').val();
      var set_month = $('#month_blacklist_1').val();
    }else {
      var set_year = $('#blacklist_year2').val();
      var set_month = $('#month_blacklist_2').val();
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
  var chk_radio = $('input[name=year_set_1]:checked', '#blacklist_filter').val();
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
    if(chk_radio == "1"){
      var set_year = $('#blacklist_year1').val();
      var set_month = $('#month_blacklist_1').val();
    }else {
      var set_year = $('#blacklist_year2').val();
      var set_month = $('#month_blacklist_2').val();
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
