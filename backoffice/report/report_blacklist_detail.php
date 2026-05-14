<?php include('report.php'); ?>

<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


  <div class="row">
    <div class="col-md-12" style="padding-right:0px;">
      <div class="panel panel-default panel-report">
      <div class="panel-body">
          <div class="hr_report" style="display:inline-block;">รายงานสถานะการเฝ้าระวัง
            <span class="txt_date_time">
            ( <?php
            if($_POST['year_set_1'] == "1"){
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_blacklist_th'] != ""){
                  if($_POST['month_blacklist_th'] == "01"){
                    $month = "มกราคม";
                  }elseif ($_POST['month_blacklist_th'] == "02") {
                    $month = "กุมภาพันธ์";
                  }elseif ($_POST['month_blacklist_th'] == "03") {
                    $month = "มีนาคม";
                  }elseif ($_POST['month_blacklist_th'] == "04") {
                    $month = "เมษายน";
                  }elseif ($_POST['month_blacklist_th'] == "05") {
                    $month = "พฤษภาคม";
                  }elseif ($_POST['month_blacklist_th'] == "06") {
                    $month = "มิถุนายน";
                  }elseif ($_POST['month_blacklist_th'] == "07") {
                    $month = "กรกฎาคม";
                  }elseif ($_POST['month_blacklist_th'] == "08") {
                    $month = "สิงหาคม";
                  }elseif ($_POST['month_blacklist_th'] == "09") {
                    $month = "กันยายน";
                  }elseif ($_POST['month_blacklist_th'] == "10") {
                    $month = "ตุลาคม";
                  }elseif ($_POST['month_blacklist_th'] == "11") {
                    $month = "พฤศจิกายน";
                  }elseif ($_POST['month_blacklist_th'] == "12") {
                    $month = "ธันวาคม";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".((int)$_POST['blacklist_year_th']+543).$type_year;
                }else {
                  if($_POST['quarter'] != ""){
                    if($_POST['quarter'] == "1"){
                      $quarter = "ไตรมาสที่ 1 ";
                    }elseif ($_POST['quarter'] == "2") {
                      $quarter = "ไตรมาสที่ 2 ";
                    }elseif ($_POST['quarter'] == "3") {
                      $quarter = "ไตรมาสที่ 3 ";
                    }elseif ($_POST['quarter'] == "4") {
                      $quarter = "ไตรมาสที่ 4 ";
                    }
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo $quarter."ปี : ".((int)$_POST['blacklist_year_th']+543).$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".((int)$_POST['blacklist_year_th']+543).$type_year;
                  }
                }
              }
            }else {
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_blacklist_en'] != ""){
                  if($_POST['month_blacklist_en'] == "01"){
                    $month = "January";
                  }elseif ($_POST['month_blacklist_en'] == "02") {
                    $month = "February";
                  }elseif ($_POST['month_blacklist_en'] == "03") {
                    $month = "March";
                  }elseif ($_POST['month_blacklist_en'] == "04") {
                    $month = "April";
                  }elseif ($_POST['month_blacklist_en'] == "05") {
                    $month = "May";
                  }elseif ($_POST['month_blacklist_en'] == "06") {
                    $month = "June";
                  }elseif ($_POST['month_blacklist_en'] == "07") {
                    $month = "July";
                  }elseif ($_POST['month_blacklist_en'] == "08") {
                    $month = "August";
                  }elseif ($_POST['month_blacklist_en'] == "09") {
                    $month = "September";
                  }elseif ($_POST['month_blacklist_en'] == "10") {
                    $month = "October";
                  }elseif ($_POST['month_blacklist_en'] == "11") {
                    $month = "November";
                  }elseif ($_POST['month_blacklist_en'] == "12") {
                    $month = "December";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".$_POST['blacklist_year_en'].$type_year;
                }else {
                  if($_POST['quarter'] != ""){
                    if($_POST['quarter'] == "1"){
                      $quarter = "ไตรมาสที่ 1 ";
                    }elseif ($_POST['quarter'] == "2") {
                      $quarter = "ไตรมาสที่ 2 ";
                    }elseif ($_POST['quarter'] == "3") {
                      $quarter = "ไตรมาสที่ 3 ";
                    }elseif ($_POST['quarter'] == "4") {
                      $quarter = "ไตรมาสที่ 4 ";
                    }
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo $quarter."ปี : ".$_POST['blacklist_year_en'].$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".$_POST['blacklist_year_en'].$type_year;
                  }
                }
              }
            }
          ?> )
        </span></div>
        <div class="total-report" style="position:absolute;">
          <span class="total-case-blacklist_txt">Total case : </span>
          <span class="total-case-blacklist"></span>
          <span class="open-blacklist">(</span>
          <span class="total-waiting-blacklist"></span>
          <span class="total-new-blacklist"></span>
          <span class="total-pending-blacklist"></span>
          <span class="total-overduemain-blacklist"></span>
          <span class="total-overduesub-blacklist"></span>
          <span class="total-closesuccess-blacklist"></span>
          <span class="total-closecontinue-blacklist"></span>
          <span class="total-closereject-blacklist"></span>
          <span class="total-close-blacklist"></span>
          <span class="Closeoverdue"></span>
          <span class="end-blacklist">)</span>
        </div>
          <div class="filter_report" style="margin-left:10px;">

          <button class="btn btn-filter" onclick="modal_chk_blacklist();"><i class="fa fa-filter" aria-hidden="true" style="margin-right:5px;"></i>Filter</button>

        <form method="post" action="report/export_blacklist.php" enctype="multipart/form-data" style="display: inline-block;margin-right: 10px;">
          <input type="hidden" class="year_set_1" name="year_set_1" value="<?=$_POST['year_set_1']?>">
          <input type="hidden" class="year_set_2" name="year_set_2" value="<?=$_POST['year_set_2']?>">
          <input type="hidden" class="blacklist_year_th" name="blacklist_year_th" value="<?=$_POST['blacklist_year_th']?>">
          <input type="hidden" class="blacklist_year_en" name="blacklist_year_en" value="<?=$_POST['blacklist_year_en']?>">
          <input type="hidden" class="quarter" name="quarter" value="<?=$_POST['quarter']?>">
          <input type="hidden" class="month_blacklist_th" name="month_blacklist_th" value="<?=$_POST['month_blacklist_th']?>">
          <input type="hidden" class="month_blacklist_en" name="month_blacklist_en" value="<?=$_POST['month_blacklist_en']?>">
          <input type="hidden" class="date_start" name="date_start" value="<?=$_POST['date_start']?>">
          <input type="hidden" class="date_stop" name="date_stop" value="<?=$_POST['date_stop']?>">
          <input type="hidden" name="reliable" value="<?=$_POST['reliable']?>">
          <input type="hidden" name="export-order" value="">
          <input type="hidden" name="export-sort" value="">
          <input type="hidden" name="export-text" value="">
          <input type="hidden" name="export-limit" value="">
          <input type="hidden" name="export-offset" value="">


          <input type="hidden" class="export-case-blacklist" name="case">
          <input type="hidden" class="export-waiting-blacklist" name="waiting">
          <input type="hidden" class="export-new-blacklist" name="new">
          <input type="hidden" class="export-pending-blacklist" name="pending">
          <input type="hidden" class="export-overduemain-blacklist" name="overduemain">
          <input type="hidden" class="export-overduesub-blacklist" name="overduesub">
          <input type="hidden" class="export-closesuccess-blacklist" name="closesuccess">
          <input type="hidden" class="export-closecontinue-blacklist" name="closecontinue">
          <input type="hidden" class="export-closereject-blacklist" name="closereject">
          <input type="hidden" class="export-close-blacklist" name="close">
          <input type="hidden" class="export-Closeoverdue" name="Closeoverdue">

          <button class="btn btn-success">Export</button>
        </form>

        </div>
          <div class="filter_report">
            <div class="input-group report_search">
             <input type="text" class="form-control search_text" name="search_text" id="search_text_auto">
             <span class="input-group-addon bg-black btn-click-search">
               <i class="glyphicon glyphicon-search"></i>
             </span>
            </div>
          </div>

          <div style="margin-top:10px;">

            <div class="tabla_data">
              <table data-toggle="table" class="table-caseCh-list"
              data-sort-name="id"
              data-sort-status="status"
              data-sort-order="DESC"
              data-side-pagination="server"
              data-pagination="true"
              data-page-size="10"
              data-page-list="[10, 50, 100, 200, ALL]"
              data-url="report/report_table_blacklist.php?method=report_blacklist"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="center">
                      ลำดับที่
                    </th>
                    <th data-field="case_id" data-sortable="true" data-align="center">
                      เลขที่เคส
                    </th>
                    <th data-field="case_receivedoc_date" data-sortable="true" data-align="center">
                      วันที่รับเรื่อง
                    </th>
                    <th data-field="close" data-sortable="true" data-align="center">
                      วันที่ยุติ
                    </th>
                    <th data-field="caseDtl_title" data-sortable="false">
                      หัวข้อ
                    </th>
                    <th data-field="company_name" data-sortable="true">
                      ชื่อบริษัท
                    </th>
                    <th data-field="product" data-sortable="true">
                      สินค้า
                    </th>
                    <th data-field="country" data-sortable="false">
                      ประเทศ
                    </th>
                    <th data-field="reliable" data-sortable="false">
                      สถานะบริษัท
                    </th>
                  </tr>
                </thead>
              </table>
            </div>


          </div>
      </div>
      </div>
    </div>
  </div>


<form method="post" action="#" id="modal_filter_blacklist" enctype="multipart/form-data">
  <div class="modal fade" id="modal_chk_blacklist" tabindex="-1" role="dialog" aria-labelledby="modal_chk_blacklist" style="padding:0px;">
    <div class="modal-dialog modal_chk_blacklist" role="document" style="width:1200px;">
      <div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
        <div class="modal-body">

          <div class="row" style="margin-top:30px;">
            <div class="col-md-1"></div>
            <div class="col-md-10" style="padding-right:0px;">
              <div class="panel panel-default" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">การแสดงผล</div>
                    <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                      <input type="radio" value="1" name="year_set_1" id="year_set1_1" onclick="chk_radio_blacklist_year_modal();" <?php if($_POST['year_set_1'] == "1"){ echo "checked";}?>>
                      <label class="txt_report" for="year_set1_1">พ.ศ.</label>
                    </div>
                    <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                      <input type="radio" value="2" name="year_set_1" id="year_set1_2" onclick="chk_radio_blacklist_year_modal();" <?php if($_POST['year_set_1'] == "2"){ echo "checked";}?>>
                      <label class="txt_report" for="year_set1_2">ค.ศ.</label>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </div>
              </div>

              <div class="panel panel-default" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">ประเภทปี</div>
                    <div class="radio radio-success col-md-2 col-sm-4 col-xs-6">
                      <input type="radio" value="1" name="year_set_2" id="year_set2_1" onclick="chk_radio_blacklist_modal();" <?php if($_POST['year_set_2'] == "1"){ echo "checked";}?>>
                      <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                    </div>
                    <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                      <input type="radio" value="2" name="year_set_2" id="year_set2_2" onclick="chk_radio_blacklist_modal();" <?php if($_POST['year_set_2'] == "2"){ echo "checked";}?>>
                      <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </div>
              </div>

              <div class="panel panel-default" style="background-color: #eceff1;">
                <div class="panel-body">
                  <div class="row div_report date_blacklist">
                    <div class="col-md-2 col-xs-12">ช่วงเวลา</div>
                    <div class="col-md-1 col-xs-12">
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
                        <option value="<?=$year;?>" <?php if($_POST['blacklist_year_th'] == $year){ echo "selected";}?>><?=$year_sum;?></option>
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
                        <option value="<?=$year;?>" <?php if($_POST['blacklist_year_en'] == $year){ echo "selected";}?>><?=$year;?></option>
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
                    <div class="col-md-1 col-xs-12">
                      <span class="txt_report">รายไตรมาส</span>
                    </div>
                    <div class="col-md-4 col-xs-12" id="quarter_txt">
                      <select class="selectpicker form-control" name="quarter" id="select_quarter_chk" onchange="select_quarter_blacklist_modal(this.value);">
                        <option value="">- เลือกไตรมาส -</option>
                        <option value="1" <?php if($_POST['quarter'] == "1"){ echo "selected";}?>>ไตรมาส ที่ 1</option>
                        <option value="2" <?php if($_POST['quarter'] == "2"){ echo "selected";}?>>ไตรมาส ที่ 2</option>
                        <option value="3" <?php if($_POST['quarter'] == "3"){ echo "selected";}?>>ไตรมาส ที่ 3</option>
                        <option value="4" <?php if($_POST['quarter'] == "4"){ echo "selected";}?>>ไตรมาส ที่ 4</option>
                      </select>
                    </div>
                    <div class="col-md-5"></div>
                  </div>
                  <div class="row div_report date_blacklist date_blacklist_panel">
                    <div class="col-md-2"></div>
                    <div class="col-md-1 col-xs-12">
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
                        <option value="<?=$key?>" <?php if($_POST['month_blacklist_th'] == $key){ echo "selected";}?>><?=$value?></option>
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
                        <option value="<?=$key?>" <?php if($_POST['month_blacklist_en'] == $key){ echo "selected";}?>><?=$value?></option>
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
                  <div class="row date_blacklist">
                    <input type="hidden" class="chk_date_select" value="0">
                    <div class="col-md-2 col-xs-12">
                      <span class="txt_report">กำหนดเอง</span>
                    </div>
                    <div class="col-md-1 col-sm-6 col-xs-12"><span>Start Date : </span></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <div class="input-group date" id="datetimepicker" onchange="set_date_select()">
                          <?php
                          if($_POST['date_start'] != ""){
                          if($_POST['year_set_1'] == "1"){
                            $date_st = $_POST['date_start'];
                            $date_ex = explode("/",$date_st);
                            $date_start = $date_ex[0]."/".$date_ex[1]."/".($date_ex[2]-543);
                          }else {
                            $date_start = $_POST['date_start'];
                          }
                        }
                        ?>
                          <input type="text" class="form-control" name="date_start" id="startDate" value="<?=$_POST['date_start']?>" readonly />
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1 col-sm-6 col-xs-12"><span>Stop Date : </span></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <div class="input-group date" id="datetimepicker2">
                          <?php
                          if($_POST['date_stop'] != ""){
                          if($_POST['year_set_1'] == "1"){
                            $date_sto = $_POST['date_stop'];
                            $date_exo = explode("/",$date_sto);
                            $date_stop = $date_exo[0]."/".$date_exo[1]."/".($date_exo[2]-543);
                          }else {
                            $date_stop = $_POST['date_stop'];
                          }
                        }
                        ?>
                          <input type="text" class="form-control" name="date_stop" id="stopDate" value="<?=$_POST['date_stop']?>" readonly />
                          <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row div_report">
                <div class="col-md-4">สถานะบริษัท</div>
                <div class="col-md-8">
                  <select class="selectpicker form-control" name="reliable">
                    <option value="">- สถานะบริษัททั้งหมด -</option>
                    <option value="1" <?php if($_POST['reliable'] == "1"){ echo "selected";}?>>Watchlist</option>
                    <option value="2" <?php if($_POST['reliable'] == "2"){ echo "selected";}?>>Blacklist</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>
          </div>
        </div>
        <hr style="margin-left:10px;margin-right:10px;">
        <div class="btn-report-blacklist">
          <button type="button" class="btn btn-success submit_report_blacklist_modal">ตกลง</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>

	</div>
</form>

<script>



$(document).ready(function() {
  $('.table-caseCh-list').on('load-success.bs.table', function (e, name, args) {
    auto_resize_menu();
    /* jQuery UI นับเวลา */
      $('.clock').each(function(){
        var elm_click = "#"+$(this).attr('id');
        var datetime = $(this).text();
        $(elm_click).countdown(datetime, {elapse:true}).on('update.countdown', function(event) {
          var format = '';

          if(event.offset.days == 0 && event.offset.hours == 0 && event.offset.minutes == 0 && event.offset.seconds < 60) {
            format = '0 วัน' + format;
          }else{
            if(event.offset.minutes > 0){
              format = '%M นาที' + format;
              //var format = '%M นาที';
            }
            if(event.offset.hours   > 0){
              format = '%H ชั่วโมง ' + format;
            }
            if(event.offset.totalDays > 0) {
              format = '%D วัน ' + format;
            }
          }
          /*if(event.offset.weeks > 0) {
            format = '%-w week%!w ' + format;
          }*/
          $(this).html(event.strftime(format));

        })
        .on('finish.countdown', function(event) {
          $(this).html('This offer has expired!')
            .parent().addClass('disabled');

        });
      });
    });



  if($('#startDate').val() == ""){
    $('#stopDate').prop('disabled', 'disabled');
  }

  if($('.blacklist_year_th').val() == ""){
    $('#blacklist_year1').attr('disabled', true);
  }else {
    $('#blacklist_year1').attr('disabled', false);
  }
  select_quarter_modal($('.quarter').val(),$('.month_blacklist_th').val());

  var month = $('.month_blacklist_th').val();

  $('#month_blacklist_1 option[value="'+month+'"]').attr("selected","selected");
  $('.selectpicker').selectpicker('refresh');

  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
    // $('[data-toggle="tooltip"]').tooltip();
    auto_resize_menu();
  });

  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
      num_rows_blacklist()
    }
  });
});


// ส่งค่าเข้า datatable
function searchQueryParams(params) {

  params.text = $("input[name='search_text']").val();
  params.year_set_1 = $("input[name='year_set_1']").val();
  params.year_set_2 = $("input[name='year_set_2']").val();
  params.blacklist_year_th = $("input[name='blacklist_year_th']").val();
  params.blacklist_year_en = $("input[name='blacklist_year_en']").val();
  params.quarter = $("input[name='quarter']").val();
  params.month_blacklist_th = $("input[name='month_blacklist_th']").val();
  params.month_blacklist_en = $("input[name='month_blacklist_en']").val();
  params.date_start = $("input[name='date_start']").val();
  params.date_stop = $("input[name='date_stop']").val();
  params.reliable = $("input[name='reliable']").val();

  $("input[name='export-text']").val(params.text);
  $("input[name='export-limit']").val(params.limit);
  $("input[name='export-offset']").val(params.offset);
  $("input[name='export-sort']").val(params.sort);
  $("input[name='export-order']").val(params.order);

  return params; // body data
}
//////////

function num_rows_blacklist(){
  var text = $("input[name='search_text']").val();
  var blacklist_year_th = $("input[name='blacklist_year_th']").val();
  var quarter = $("input[name='quarter']").val();
  var month_blacklist_th = $("input[name='month_blacklist_th']").val();
  var reliable = $("input[name='reliable']").val();
  
  $.ajax({
      url: 'report/num_rows_report_blacklist.php',
      type: 'POST',
      async: false,
      responseType: "json",
      data: {
        'text':text,
        'blacklist_year_th':blacklist_year_th,
        'quarter':quarter,
        'month_blacklist_th':month_blacklist_th,
        'reliable':reliable,
        "method":"report_blacklist"
      },
    success: function(res) {
      $('.total-case-blacklist').text(res.total);

      $('.total-waiting-blacklist').text("Waiting "+res.waiting+",");
      $('.total-new-blacklist').text("New "+res.new+",");
      $('.total-pending-blacklist').text("In Process "+res.pending+",");
      $('.total-overduemain-blacklist').text("Overdue Main Process "+res.overduemain+",");
      $('.total-overduesub-blacklist').text("Overdue Sub Process "+res.overduesub+",");
      $('.total-closesuccess-blacklist').text("Close Success "+res.closesuccess+",");
      $('.total-closecontinue-blacklist').text("Close Continue "+res.closecontinue+",");
      $('.total-closereject-blacklist').text("Close Reject "+res.closereject+",");
      $('.total-close-blacklist').text("Close "+res.close+',');
      $('.Closeoverdue').text("Close(overdue) "+res.Closeoverdue);

      $('.export-case-blacklist').val(res.total);

      $('.export-waiting-blacklist').val("Waiting "+res.waiting+",");
      $('.export-new-blacklist').val("New "+res.new+",");
      $('.export-pending-blacklist').val("In Process "+res.pending+",");
      $('.export-overduemain-blacklist').val("Overdue Main Process "+res.overduemain+",");
      $('.export-overduesub-blacklist').val("Overdue Sub Process "+res.overduesub+",");
      $('.export-closesuccess-blacklist').val("Close Success "+res.closesuccess+",");
      $('.export-closecontinue-blacklist').val("Close Continue "+res.closecontinue+",");
      $('.export-closereject-blacklist').val("Close Reject "+res.closereject+",");
      $('.export-close-blacklist').val("Close "+res.close+',');
      $('.export-Closeoverdue').val("Close(overdue) "+res.Closeoverdue);


    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR, textStatus, errorThrown);

    }
  });
}
num_rows_blacklist();

function modal_chk_blacklist(){
  $('#modal_chk_blacklist').modal('show');
}

$(document).on('click','.btn-click-search',function() {
  $('.table-caseCh-list').bootstrapTable('refresh');
});


function chk_select_year(){
  var set_year = $('#blacklist_year1').val();


  if(set_year == ""){
    $('#select_quarter_chk').attr('disabled', true);
    $('#month_blacklist_1').attr('disabled', true);
    $('#startDate').prop('disabled', false);
    $('#select_quarter_chk').val('');
    $('#month_blacklist_1').val('');
  }else {
    $('#select_quarter_chk').attr('disabled', false);
    $('#month_blacklist_1').attr('disabled', false);
    $('#startDate').prop('disabled', 'disabled');
    $('#stopDate').prop('disabled', 'disabled');
  }
}

chk_select_year();

$( "#blacklist_year1" ).change(function() {
  chk_select_year();
  $('.selectpicker').selectpicker('refresh');
});

function select_month_blacklist(){
  var lang = 'th';
  var th = true;
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
  } else {
    start = getStartDate();
    end = getEndDate();
  }
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
  $('#stopDate').prop('disabled', false);
  // select_month_blacklist();
}


function getStartDate() {
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
  var set_year = $('#blacklist_year1').val();
  var set_month = $('#month_blacklist_1').val();

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
  var year_start = $('.year_start').val();
  var year_stop = $('.year_stop').val();
  var select_quarter = $('#select_quarter_chk').val();
  var set_year = $('#blacklist_year1').val();
  var set_month = $('#month_blacklist_1').val();
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
