<?php include('report.php'); ?>

<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


  <div class="row">
    <div class="col-md-12" style="padding-right:0px;">
      <div class="panel panel-default panel-report">
      <div class="panel-body">
          <div class="hr_report" style="display:inline-block;">รายงานผลการดำเนินงาน
            <span class="txt_date_time">
            ( <?php
            if($_POST['year_set_1'] == "1"){
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_issue_th'] != ""){
                  if($_POST['month_issue_th'] == "01"){
                    $month = "มกราคม";
                  }elseif ($_POST['month_issue_th'] == "02") {
                    $month = "กุมภาพันธ์";
                  }elseif ($_POST['month_issue_th'] == "03") {
                    $month = "มีนาคม";
                  }elseif ($_POST['month_issue_th'] == "04") {
                    $month = "เมษายน";
                  }elseif ($_POST['month_issue_th'] == "05") {
                    $month = "พฤษภาคม";
                  }elseif ($_POST['month_issue_th'] == "06") {
                    $month = "มิถุนายน";
                  }elseif ($_POST['month_issue_th'] == "07") {
                    $month = "กรกฎาคม";
                  }elseif ($_POST['month_issue_th'] == "08") {
                    $month = "สิงหาคม";
                  }elseif ($_POST['month_issue_th'] == "09") {
                    $month = "กันยายน";
                  }elseif ($_POST['month_issue_th'] == "10") {
                    $month = "ตุลาคม";
                  }elseif ($_POST['month_issue_th'] == "11") {
                    $month = "พฤศจิกายน";
                  }elseif ($_POST['month_issue_th'] == "12") {
                    $month = "ธันวาคม";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".((int)$_POST['issue_year_th']+543).$type_year;
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
                    echo $quarter."ปี : ".((int)$_POST['issue_year_th']+543).$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".((int)$_POST['issue_year_th']+543).$type_year;
                  }
                }
              }
            }else {
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_issue_en'] != ""){
                  if($_POST['month_issue_en'] == "01"){
                    $month = "January";
                  }elseif ($_POST['month_issue_en'] == "02") {
                    $month = "February";
                  }elseif ($_POST['month_issue_en'] == "03") {
                    $month = "March";
                  }elseif ($_POST['month_issue_en'] == "04") {
                    $month = "April";
                  }elseif ($_POST['month_issue_en'] == "05") {
                    $month = "May";
                  }elseif ($_POST['month_issue_en'] == "06") {
                    $month = "June";
                  }elseif ($_POST['month_issue_en'] == "07") {
                    $month = "July";
                  }elseif ($_POST['month_issue_en'] == "08") {
                    $month = "August";
                  }elseif ($_POST['month_issue_en'] == "09") {
                    $month = "September";
                  }elseif ($_POST['month_issue_en'] == "10") {
                    $month = "October";
                  }elseif ($_POST['month_issue_en'] == "11") {
                    $month = "November";
                  }elseif ($_POST['month_issue_en'] == "12") {
                    $month = "December";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".$_POST['issue_year_en'].$type_year;
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
                    echo $quarter."ปี : ".$_POST['issue_year_en'].$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".$_POST['issue_year_en'].$type_year;
                  }
                }
              }
            }
          ?> )
        </span></div>
        <div class="total-report" style="position:absolute;">
          <span class="total-case-issue_txt">Total case : </span>
          <span class="total-case-issue"></span>
          <span class="open-issue">(</span>
          <span class="total-waiting-issue"></span>
          <span class="total-new-issue"></span>
          <span class="total-pending-issue"></span>
          <span class="total-overduemain-issue"></span>
          <span class="total-overduesub-issue"></span>
          <span class="total-closesuccess-issue"></span>
          <span class="total-closecontinue-issue"></span>
          <span class="total-closereject-issue"></span>
          <span class="end-issue">)</span>
        </div>
          <div class="filter_report" style="margin-left:10px;">

          <button class="btn btn-filter" onclick="modal_chk_issue();"><i class="fa fa-filter" aria-hidden="true" style="margin-right:5px;"></i>Filter</button>

        <form method="post" action="report/export_issue.php" enctype="multipart/form-data" style="display: inline-block;margin-right: 10px;">
          <input type="hidden" class="year_set_1" name="year_set_1" value="<?=$_POST['year_set_1']?>">
          <input type="hidden" class="year_set_2" name="year_set_2" value="<?=$_POST['year_set_2']?>">
          <input type="hidden" class="issue_year_th" name="issue_year_th" value="<?=$_POST['issue_year_th']?>">
          <input type="hidden" class="issue_year_en" name="issue_year_en" value="<?=$_POST['issue_year_en']?>">
          <input type="hidden" class="quarter" name="quarter" value="<?=$_POST['quarter']?>">
          <input type="hidden" class="month_issue_th" name="month_issue_th" value="<?=$_POST['month_issue_th']?>">
          <input type="hidden" class="month_issue_en" name="month_issue_en" value="<?=$_POST['month_issue_en']?>">
          <input type="hidden" class="date_start" name="date_start" value="<?=$_POST['date_start']?>">
          <input type="hidden" class="date_stop" name="date_stop" value="<?=$_POST['date_stop']?>">
          <input type="hidden" name="compType_id" value="<?=$_POST['compType_id']?>">
          <input type="hidden" name="prodType_id" value="<?=$_POST['prodType_id']?>">
          <input type="hidden" name="caseCh_id" value="<?=$_POST['caseCh_id']?>">
          <input type="hidden" name="Country_applnt" value="<?=$_POST['Country_applnt']?>">
          <input type="hidden" name="Country_complnt" value="<?=$_POST['Country_complnt']?>">
          <input type="hidden" name="member_comp_type" value="<?=$_POST['member_comp_type']?>">
          <input type="hidden" name="status_complaint" value="<?=$_POST['status_complaint']?>">
          <input type="hidden" name="respon" value="<?=$_POST['respon']?>">
          <input type="hidden" name="office_id" value="<?=$_POST['office_id']?>">


          <input type="hidden" class="export-case-issue" name="case">
          <input type="hidden" class="export-waiting-issue" name="waiting">
          <input type="hidden" class="export-new-issue" name="new">
          <input type="hidden" class="export-pending-issue" name="pending">
          <input type="hidden" class="export-overduemain-issue" name="overduemain">
          <input type="hidden" class="export-overduesub-issue" name="overduesub">
          <input type="hidden" class="export-closesuccess-issue" name="closesuccess">
          <input type="hidden" class="export-closecontinue-issue" name="closecontinue">
          <input type="hidden" class="export-closereject-issue" name="closereject">

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
              data-url="report/report_table.php?method=report_issue"
              data-query-params="searchQueryParams"
              data-method="post">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="false" data-align="center">
                      ลำดับที่
                    </th>
                    <th data-field="case_receivedoc_date" data-sortable="true">
                      วันที่รับเรื่อง
                    </th>
                    <th data-field="close" data-sortable="true" data-align="center">
                      วันที่ยุติ
                    </th>
                    <th data-field="caseDtl_title" data-sortable="false">
                      เรื่อง
                    </th>
                    <th data-field="mail" data-sortable="true" data-align="center">
                      ช่องทางการรับเรื่อง
                    </th>
                    <th data-field="complaint" data-sortable="true">
                      ประเภทเรื่องร้องเรียน
                    </th>
                    <th data-field="product" data-sortable="true">
                      <?php
                      if($_SESSION['admin']['empSection'] == "1"){
                        echo "ประเภทสินค้า";
                      }else {
                        echo "ประเภทความผิด";
                      }
                      ?>

                    </th>
                    <th data-field="applnt" data-sortable="false" data-align="center">
                      ผู้ร้องเรียน
                    </th>
                    <th data-field="complnt" data-sortable="false" data-align="center">
                      ผู้ถูกร้องเรียน
                    </th>
                    <th data-field="process" data-sortable="false" data-align="center">
                      ผลการดำเนินการ
                    </th>
                    <th data-field="counsel" data-sortable="false" data-align="center">
                      ผู้รับผิดชอบ
                    </th>
                    <th data-field="status" data-sortable="false" data-align="center">
                      สถานะเรื่องร้องเรียน
                    </th>
                    <th data-field="case_close" data-sortable="false" data-align="center">
                      เวลา
                    </th>
                    <th data-field="member_comp_type" data-sortable="false" data-align="center">
                      การเป็นสมาชิกของกรม
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


<form method="post" action="#" id="modal_filter_issue" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_issue" tabindex="-1" role="dialog" aria-labelledby="modal_chk_issue" style="padding:0px;">
			<div class="modal-dialog modal_chk_issue" role="document" style="width:1200px;">
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
                            <input type="radio" value="1" name="year_set_1" id="year_set1_1" onclick="chk_radio_issue_year_modal();" <?php if($_POST['year_set_1'] == "1"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set1_1">พ.ศ.</label>
                          </div>
                          <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                            <input type="radio" value="2" name="year_set_1" id="year_set1_2" onclick="chk_radio_issue_year_modal();" <?php if($_POST['year_set_1'] == "2"){ echo "checked";}?>>
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
                            <input type="radio" value="1" name="year_set_2" id="year_set2_1" onclick="chk_radio_issue_modal();" <?php if($_POST['year_set_2'] == "1"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set2_1">ปีปฏิทิน</label>
                          </div>
                          <div class="radio radio-success col-md-4 col-sm-4 col-xs-6">
                            <input type="radio" value="2" name="year_set_2" id="year_set2_2" onclick="chk_radio_issue_modal();" <?php if($_POST['year_set_2'] == "2"){ echo "checked";}?>>
                            <label class="txt_report" for="year_set2_2">ปีงบประมาณ</label>
                          </div>
                          <div class="col-md-4"></div>
                        </div>
                      </div>
                    </div>

                <div class="panel panel-default" style="background-color: #eceff1;">
                  <div class="panel-body">
                    <div class="row div_report date_issue">
                      <div class="col-md-2 col-xs-12">ช่วงเวลา</div>
                      <div class="col-md-1 col-xs-12">
                        <span class="txt_report">รายปี</span>
                      </div>
                      <div class="col-md-4 col-xs-12">
                        <div class="issue_year1">
                        <select class="selectpicker form-control" name="issue_year_th" id="issue_year1" onchange="select_month_issue();">
                          <option value="">- เลือกปี -</option>
                          <?php
                          $date_year = date("Y");
                          for($year = $date_year+1; $year>=$date_year-5; $year--){
                            $year_sum = $year+543;
                          ?>
                          <option value="<?=$year;?>" <?php if($_POST['issue_year_th'] == $year){ echo "selected";}?>><?=$year_sum;?></option>
                          <?php  } ?>
                        </select>
                      </div>
                      <div class="issue_year2">
                        <select class="selectpicker form-control" name="issue_year_en" id="issue_year2" onchange="select_month_issue();">
                          <option value="">- เลือกปี -</option>
                          <?php
                          $date_year = date("Y");
                          for($year = $date_year+1; $year>=$date_year-5; $year--){
                          ?>
                          <option value="<?=$year;?>" <?php if($_POST['issue_year_en'] == $year){ echo "selected";}?>><?=$year;?></option>
                          <?php  } ?>
                        </select>
                      </div>
                      <input type="hidden" class="year_start" value="<?=$date_year-5;?>">
                      <input type="hidden" class="year_stop" value="<?=$date_year+1;?>">
                      </div>
                      <div class="col-md-5"></div>
                    </div>
                    <div class="row div_report date_issue date_issue_panel">
                      <div class="col-md-2"></div>
                      <div class="col-md-1 col-xs-12">
                        <span class="txt_report">รายไตรมาส</span>
                      </div>
                      <div class="col-md-4 col-xs-12" id="quarter_txt">
                        <select class="selectpicker form-control" name="quarter" id="select_quarter_chk" onchange="select_quarter_modal(this.value);">
                          <option value="">- เลือกไตรมาส -</option>
                          <option value="1" <?php if($_POST['quarter'] == "1"){ echo "selected";}?>>ไตรมาส ที่ 1</option>
                          <option value="2" <?php if($_POST['quarter'] == "2"){ echo "selected";}?>>ไตรมาส ที่ 2</option>
                          <option value="3" <?php if($_POST['quarter'] == "3"){ echo "selected";}?>>ไตรมาส ที่ 3</option>
                          <option value="4" <?php if($_POST['quarter'] == "4"){ echo "selected";}?>>ไตรมาส ที่ 4</option>
                        </select>
                      </div>
                      <div class="col-md-5"></div>
                    </div>
                    <div class="row div_report date_issue date_issue_panel">
                      <div class="col-md-2"></div>
                      <div class="col-md-1 col-xs-12">
                        <span class="txt_report">รายเดือน</span>
                      </div>
                      <div class="col-md-4 col-xs-12">
                        <div class="months_issue1">
                        <select class="selectpicker form-control" name="month_issue_th" id="month_issue_1" onchange="select_month_issue();">
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
                          <option value="<?=$key?>" <?php if($_POST['month_issue_th'] == $key){ echo "selected";}?>><?=$value?></option>
                          <?php } ?>
                        </select>
                      </div>

                        <div class="months_issue2">
                        <select class="selectpicker form-control" name="month_issue_en" id="month_issue_2" onchange="select_month_issue();">
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
                          <option value="<?=$key?>" <?php if($_POST['month_issue_en'] == $key){ echo "selected";}?>><?=$value?></option>
                          <?php } ?>
                        </select>
                      </div>
                      </div>
                      <div class="col-md-5"></div>
                    </div>
                  </div>
                </div>

            <div class="panel panel-default date_issue_panel" style="background-color: #eceff1;">
              <div class="panel-body">
                <div class="row date_issue">
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
                      <div class="col-md-4">ประเภทเรื่องร้องเรียน</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" data-live-search="true" name="compType_id">
                          <option value="">- ประเภทเรื่องร้องเรียนทั้งหมด -</option>
                          <?php
                          $sql = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0 AND compType_section = '".$_SESSION['admin']['empSection']."'";
                          $query = $conn->query($sql);
                          while ($re = $query->fetch_assoc()) {
                           ?>
                          <option value="<?=$re['compType_id']?>" <?php if($_POST['compType_id'] == $re['compType_id']){ echo "selected";}?>><?=$re['compType_name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="row div_report">
                      <?php if($_SESSION['admin']['empSection'] == "1"){ ?>
                        <div class="col-md-4">ประเภทสินค้า</div>
                        <div class="col-md-8 elm_prodType">
                          <select class="selectpicker form-control select-product-type" data-live-search="true" name="prodType_id"  onchange="set_officeType_ofReport(this);">
                            <option value="">- ประเภทสินค้าทั้งหมด -</option>
                            <?php
                            function prodTypeListMutiLv($lv,$ref_id){
                              global $conn;
                              $prodTypeArrObj = array();

                              if($_SESSION['admin']['office'] != 0 ){
                                $office = " AND office_id = '".$_SESSION['admin']['office']."' ";
                              }

                              if($_POST['office_id']!=""){
                                $office = " AND office_id = '".$_POST['office_id']."' ";
                              }

                              $sql = "SELECT *
                              FROM Product_Type
                                      WHERE prodType_level = '$lv'
                                      AND prodType_status = '0'
                                      AND prodType_enable = '1' ";
                              if($lv == 2){
                                $sql .= $office ;
                              }
                              if($ref_id!=""){
                                $sql .= "AND prodType_ref_id = '$ref_id' ";
                              }
                              $query = $conn->query($sql);
                              $prod_num = $query->num_rows;
                              $lv++;
                                while($result = $query->fetch_assoc()){
                                  $prodArr["prodType_id"] = $result["prodType_id"];
                                  $prodArr["prodType_name"] = $result["prodType_name"];

                                  $sql_sub = "SELECT *
                                              FROM Product_Type
                                              WHERE prodType_ref_id = '".$result["prodType_id"]."'
                                              AND prodType_level = '$lv'
                                              AND prodType_status = '0'
                                              AND prodType_enable = '1' ";
                                  $query_sub = $conn->query($sql_sub);
                                  $num_sub = $query_sub->num_rows;
                                  $prodArr["prodType_sublist"] = $num_sub;
                                  array_push($prodTypeArrObj,$prodArr);
                                }
                              return $prodTypeArrObj;
                            }

                            function getProdType($lv,$ref_id,$ref_name){
                              global $conn;
                              $i=0;
                              foreach(prodTypeListMutiLv($lv,$ref_id) as $prod_type){
                                if($lv==1){
                                  $option .= '<optgroup>';
                                }
                                if($prod_type["prodType_sublist"]>0){
                                  $disabled = '';
                                }else{
                                  $disabled = '';
                                }
                                if($lv==1 && $prod_type['prodType_other_flag']==0){
                                  $disabled = "disabled";
                                }else{
                                  $disabled = '';
                                }
                                if($lv > 1){
                                  $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
                                }else {
                                  $arrow = '';
                                }
                                if($_POST['prodType_id']!="" && $_POST['prodType_id']==$prod_type["prodType_id"]){
                                  $selected = "selected";
                                }
                                $ref_name_real = $ref_name."/".$prod_type["prodType_name"];
                                $option .= '<option '.$disabled.' '.$selected.' value="'.$prod_type["prodType_id"].'" rel="'.$prod_type["prodType_level"].'" data-content="<span class=\'txt\' style=\'padding-left:'.(20*($lv)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$prod_type["prodType_name"].'</span>" >
                                            '.$prod_type["prodType_name"].'
                                          </option>';
                                if($prod_type["prodType_sublist"]>0){
                                  $n_lv = $lv+1;
                                  $option .= getProdType($n_lv,$prod_type["prodType_id"],$ref_name_real);
                                }
                                if($lv==1){
                                  $option .= '</optgroup>';
                                }
                                $i++;

                              }
                              return $option;
                            }
                          echo getProdType(1,null);
                          ?>
                          </select>
                        </div>
                      <?php }else { ?>
                        <div class="col-md-4">ประเภทความผิด</div>
                        <div class="col-md-8">
                          <select class="selectpicker form-control" data-live-search="true" name="prodType_id">
                            <option value="">- ประเภทความผิดทั้งหมด -</option>
                            <?php
                            $sql = "SELECT * FROM `Incorrect_Type` WHERE incType_status = 0 AND incType_enable = 1";
                            $query = $conn->query($sql);
                            while ($rl = $query->fetch_assoc()) {
                            ?>
                            <option value="<?=$rl['incType_id']?>"><?=$rl['incType_name']?></option>
                            <?php } ?>
                          </select>
                        </div>
                      <?php }?>
                    </div>

                    <?php if($_SESSION['admin']['empSection'] == "1"){ ?>
                    <div class="row div_report office_type_elm">
                    <div class="col-md-4">สำนัก</div>
                    <div class="col-md-8">
                      <select class="selectpicker form-control" data-live-search="true" name="office_id"  onchange="set_prodType_ofReport(this);">
                        <?php
                        if($_SESSION['admin']['office'] == "0"){
                          $office_type = " ";
                          ?>
                          <option value="">- สำนักทั้งหมด -</option>
                          <option value="0">สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ</option>
                          <?php
                        }else {
                          $office_type = " AND office_id = ".$_SESSION['admin']['office'];
                        }
                        $sql = "SELECT * FROM `office_type` WHERE `office_status` = 1 AND office_id != 0 $office_type ";
                        $query = $conn->query($sql);
                        while ($rl = $query->fetch_assoc()) {
                        ?>
                        <option value="<?=$rl['office_id']?>" <?php if($_POST['office_id'] == $rl['office_id']){ echo "selected"; }?>><?=$rl['office_name']?></option>
                        <?php } ?>
                      </select>
                    </div>
                    </div>
                    <?php } ?>


                    <div class="row div_report">
                      <div class="col-md-4">ช่องทางการรับเรื่องร้องเรียน</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" data-live-search="true" name="caseCh_id">
                          <option value="">- ช่องทางการรับเรื่องร้องเรียนทั้งหมด -</option>
                          <?php
                          $sql = "SELECT * FROM `Case_Channel` WHERE caseCh_level = 1 AND caseCh_status = 0 AND
                          caseCh_enable = 1 AND (caseCh_section = '".$_SESSION['admin']['empSection']."' OR caseCh_section = 0)";
                          $query = $conn->query($sql);
                          while ($li = $query->fetch_assoc()) {
                          ?>
                          <optgroup>
                            <option value="<?=$li['caseCh_id']?>" <?php if($_POST['caseCh_id'] == $li['caseCh_id']){ echo "selected";}?>
                              data-content="<span class='label' style='color:#000;font-family:kanit;font-weight:lighter;font-size: 16px;'><?=$li['caseCh_name']?></span>">
                              <?=$li['caseCh_name']?></option>
                            <?php
                            $sql_sub = "SELECT *
                            FROM `Case_Channel`
                            WHERE caseCh_ref_id = '".$li["caseCh_id"]."'
                            AND caseCh_level = 2
                            AND caseCh_status = 0
                            AND caseCh_enable = 1 ";
                            $query_sub = $conn->query($sql_sub);
                            while($result_sub = $query_sub->fetch_assoc()){ ?>
                              <option value="<?=$result_sub['caseCh_id']?>" <?php if($_POST['caseCh_id'] == $result_sub['caseCh_id']){ echo "selected";}?>
                                data-content="<span class='label' style='color:#000;font-family:kanit;font-weight:lighter;font-size: 16px;margin-left: 20px;'><i class='ditp-icon icon-ico-ditp-43'></i><?=$result_sub['caseCh_name']?></span>">
                                <?=$result_sub['caseCh_name']?></option>
                                  <?php
                                  $sql_sub2 = "SELECT *
                                  FROM `Case_Channel`
                                  WHERE caseCh_ref_id = '".$result_sub["caseCh_id"]."'
                                  AND caseCh_level = 3
                                  AND caseCh_status = 0
                                  AND caseCh_enable = 1 ";
                                  $query_sub2 = $conn->query($sql_sub2);
                                  if($query_sub2->num_rows > 0){
                                  while($result_sub2 = $query_sub2->fetch_assoc()){ ?>
                                    <option value="<?=$result_sub2['caseCh_id']?>"
                                       data-content="<span class='label' style='color:#000;font-family:kanit;font-weight:lighter;font-size: 16px;margin-left: 40px;'><i class='ditp-icon icon-ico-ditp-43'></i><?=$result_sub2['caseCh_name']?></span>">
                                      <?=$result_sub2['caseCh_name']?></option>
                                  <?php }
                                     }
                                   }
                                 ?>
                          </optgroup>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="row div_report">
                      <div class="col-md-4">ประเทศผู้ร้องเรียน</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" data-live-search="true" name="Country_applnt">
                          <option value="">- All Country -</option>
                          <?php
                          $sql = "SELECT * FROM `Country` WHERE country_enable = 1 AND country_status = 0 ORDER BY FIELD(id, '162') DESC";
                          $query = $conn->query($sql);
                          while ($ls = $query->fetch_assoc()) {
                          ?>
                          <option value="<?=$ls['id']?>" <?php if($_POST['Country_applnt'] == $ls['id']){ echo "selected";}?>><?=$ls['name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="row div_report">
                      <div class="col-md-4">ประเทศผู้ถูกร้องเรียน</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" data-live-search="true" name="Country_complnt">
                          <option value="">- All Country -</option>
                          <?php
                          $sql = "SELECT * FROM `Country` WHERE country_enable = 1 AND country_status = 0 ORDER BY FIELD(id, '162') DESC";
                          $query = $conn->query($sql);
                          while ($lr = $query->fetch_assoc()) {
                          ?>
                          <option value="<?=$lr['id']?>" <?php if($_POST['Country_complnt'] == $lr['id']){ echo "selected";}?>><?=$lr['name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="row div_report">
                      <div class="col-md-4">การเป็นสมาชิกของกรม</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" name="member_comp_type">
                          <option value="">- ทั้งหมด -</option>
                          <option value="0" <?php if($_POST['member_comp_type'] == "0"){ echo "selected";}?>>ไม่ระบุ</option>
                          <option value="1" <?php if($_POST['member_comp_type'] == "1"){ echo "selected";}?>>เป็นสมาชิกกรม</option>
                          <option value="2" <?php if($_POST['member_comp_type'] == "2"){ echo "selected";}?>>ไม่เป็นสมาชิกกรม</option>
                        </select>
                      </div>
                    </div>
                    <div class="row div_report">
                      <div class="col-md-4">สถานะเรื่องร้องเรียน</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" name="status_complaint">
                          <option value="">- ทั้งหมด -</option>
                          <option value="0" <?php if($_POST['status_complaint'] == "0"){ echo "selected";}?>>Waiting</option>
                          <option value="1" <?php if($_POST['status_complaint'] == "1"){ echo "selected";}?>>New</option>
                          <option value="2" <?php if($_POST['status_complaint'] == "2"){ echo "selected";}?>>In Process</option>
                          <option value="3" <?php if($_POST['status_complaint'] == "3"){ echo "selected";}?>>Close</option>
                          <option value="4" <?php if($_POST['status_complaint'] == "4"){ echo "selected";}?>>Overdue</option>
                        </select>
                      </div>
                    </div>
                    <div class="row div_report">
                      <div class="col-md-4">ผู้รับผิดชอบ</div>
                      <div class="col-md-8">
                        <select class="selectpicker form-control" data-live-search="true" name="respon">
                          <option value="">- ทั้งหมด -</option>
                          <?php
                          $sql = "SELECT * FROM `Employee` AS e
                          LEFT JOIN `Employee_Group` AS eg ON e.empGroup_id = eg.empGroup_id
                          WHERE e.emp_status = 0 AND eg.empGroup_level IN (0,2) AND eg.empGroup_section='".$_SESSION['admin']['empSection']."' AND eg.empGroup_status = 0 AND eg.empGroup_enable = 1";
                          $query = $conn->query($sql);
                          while ($rc = $query->fetch_assoc()) {
                          ?>
                          <option value="<?=$rc['emp_id']?>" <?php if($_POST['respon'] == $rc['emp_id']){ echo "selected";}?>><?=$rc['emp_firstname'];?>&nbsp;<?=$rc['emp_lastname'];?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            </div>
            <hr style="margin-left:10px;margin-right:10px;">
            <div class="btn-report-issue">
              <button type="button" class="btn btn-success submit_report_issue_modal">ตกลง</button>
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


if($('.year_set_1').val() == "1"){
  if($('.issue_year_th').val() == ""){
    $('#issue_year1').attr('disabled', true);
  }else {
    $('#issue_year1').attr('disabled', false);
  }
  select_quarter_modal($('.quarter').val(),$('.month_issue_th').val());

  var month = $('.month_issue_th').val();

    $('#month_issue_1 option[value="'+month+'"]').attr("selected","selected");
    $('.selectpicker').selectpicker('refresh');
}else {

  if($('.issue_year_en').val() == ""){
    $('#issue_year2').attr('disabled', true);
  }else {
    $('#issue_year2').attr('disabled', false);
  }
  select_quarter_modal($('.quarter').val());

  var month = $('.month_issue_en').val();
  $('#month_issue_2 option[value="'+month+'"]').attr("selected","selected");
  $('.selectpicker').selectpicker('refresh');
}

if($('.year_set_2').val() == "1"){
  $('.date_issue_panel').show();
}else {
  $('.date_issue_panel').hide();
}

  $('.table-caseCh-list').on('load-success.bs.table', function (e) {
    // $('[data-toggle="tooltip"]').tooltip();
    auto_resize_menu();
  });

  $("input[name='search_text']").keypress(function(e) {
    if(e.which == 13) {
      $('.table-caseCh-list').bootstrapTable('refresh');
    }
  });

// var options = {
//
// url: "report/num_rows_report_issue.php?txt_search="+$("#search_text_auto").val()+"&method=search_text_issue",
//
// getValue: "name",
//
// list: {
//   match: {
//     enabled: true
//   }
// }
// };
//
// $("#search_text_auto").easyAutocomplete(options);
// $('.table-caseCh-list').bootstrapTable('refresh');
});

// ส่งค่าเข้า datatable
function searchQueryParams(params) {

  params.text = $("input[name='search_text']").val();
  params.year_set_1 = $("input[name='year_set_1']").val();
  params.year_set_2 = $("input[name='year_set_2']").val();
  params.issue_year_th = $("input[name='issue_year_th']").val();
  params.issue_year_en = $("input[name='issue_year_en']").val();
  params.quarter = $("input[name='quarter']").val();
  params.month_issue_th = $("input[name='month_issue_th']").val();
  params.month_issue_en = $("input[name='month_issue_en']").val();
  params.date_start = $("input[name='date_start']").val();
  params.date_stop = $("input[name='date_stop']").val();
  params.compType_id = $("input[name='compType_id']").val();
  params.prodType_id = $("input[name='prodType_id']").val();
  params.caseCh_id = $("input[name='caseCh_id']").val();
  params.Country_applnt = $("input[name='Country_applnt']").val();
  params.Country_complnt = $("input[name='Country_complnt']").val();
  params.member_comp_type = $("input[name='member_comp_type']").val();
  params.status_complaint = $("input[name='status_complaint']").val();
  params.respon = $("input[name='respon']").val();

  return params; // body data
}
//////////

function num_rows_issue(){
  var text = $("input[name='search_text']").val();
  var year_set_1 = $("input[name='year_set_1']").val();
  var year_set_2 = $("input[name='year_set_2']").val();
  var issue_year_th = $("input[name='issue_year_th']").val();
  var issue_year_en = $("input[name='issue_year_en']").val();
  var quarter = $("input[name='quarter']").val();
  var month_issue_th = $("input[name='month_issue_th']").val();
  var month_issue_en = $("input[name='month_issue_en']").val();
  var date_start = $("input[name='date_start']").val();
  var date_stop = $("input[name='date_stop']").val();
  var compType_id = $("input[name='compType_id']").val();
  var prodType_id = $("input[name='prodType_id']").val();
  var caseCh_id = $("input[name='caseCh_id']").val();
  var Country_applnt = $("input[name='Country_applnt']").val();
  var Country_complnt = $("input[name='Country_complnt']").val();
  var member_comp_type = $("input[name='member_comp_type']").val();
  var status_complaint = $("input[name='status_complaint']").val();
  var respon = $("input[name='respon']").val();

  $.ajax({
      url: 'report/num_rows_report_issue.php',
      type: 'POST',
      async: false,
      responseType: "json",
      data: {
        'text':text,
        'year_set_1':year_set_1,
        'year_set_2':year_set_2,
        'issue_year_th':issue_year_th,
        'issue_year_en':issue_year_en,
        'quarter':quarter,
        'month_issue_th':month_issue_th,
        'month_issue_en':month_issue_en,
        'date_start':date_start,
        'date_stop':date_stop,
        'compType_id':compType_id,
        'prodType_id':prodType_id,
        'caseCh_id':caseCh_id,
        'Country_applnt':Country_applnt,
        'Country_complnt':Country_complnt,
        'member_comp_type':member_comp_type,
        'status_complaint':status_complaint,
        'respon':respon,
        "method":"report_issue"
      },
    success: function(res) {
      $('.total-case-issue').text(res.total);

      $('.total-waiting-issue').text("Waiting "+res.waiting+",");
      $('.total-new-issue').text("New "+res.new+",");
      $('.total-pending-issue').text("In Process "+res.pending+",");
      $('.total-overduemain-issue').text("Overdue Main Process "+res.overduemain+",");
      $('.total-overduesub-issue').text("Overdue Sub Process "+res.overduesub+",");
      $('.total-closesuccess-issue').text("Close Success "+res.closesuccess+",");
      $('.total-closecontinue-issue').text("Close Continue "+res.closecontinue+",");
      $('.total-closereject-issue').text("Close Reject "+res.closereject);

      $('.export-case-issue').val(res.total);

      $('.export-waiting-issue').val("Waiting "+res.waiting+",");
      $('.export-new-issue').val("New "+res.new+",");
      $('.export-pending-issue').val("In Process "+res.pending+",");
      $('.export-overduemain-issue').val("Overdue Main Process "+res.overduemain+",");
      $('.export-overduesub-issue').val("Overdue Sub Process "+res.overduesub+",");
      $('.export-closesuccess-issue').val("Close Success "+res.closesuccess+",");
      $('.export-closecontinue-issue').val("Close Continue "+res.closecontinue+",");
      $('.export-closereject-issue').val("Close Reject "+res.closereject);

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR, textStatus, errorThrown);

    }
  });
}
num_rows_issue();

function modal_chk_issue(){
  $('#modal_chk_issue').modal('show');
}




function chk_select_year(){
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
    if(chk_radio == "1"){
      var set_year = $('#issue_year1').val();
    }else {
      var set_year = $('#issue_year2').val();
    }

    if(set_year == ""){
        $('#select_quarter_chk').attr('disabled', true);
        $('#month_issue_1').attr('disabled', true);
        $('#month_issue_2').attr('disabled', true);
        $('#startDate').prop('disabled', false);
        $('#select_quarter_chk').val('');
        $('#month_issue_1').val('');
        $('#month_issue_2').val('');

    }else {
      $('#select_quarter_chk').attr('disabled', false);
      $('#month_issue_1').attr('disabled', false);
      $('#month_issue_2').attr('disabled', false);
      $('#startDate').prop('disabled', 'disabled');
      $('#stopDate').prop('disabled', 'disabled');
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
var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
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
select_month_issue();

$( "#select_quarter_chk" ).change(function() {
  select_month_issue();
});
function set_date_select(){
  $('#stopDate').prop('disabled', false);
  // select_month_issue();
}


function getStartDate() {
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
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
  var chk_radio = $('input[name=year_set_1]:checked', '#modal_filter_issue').val();
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
