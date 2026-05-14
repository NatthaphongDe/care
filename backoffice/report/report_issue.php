<?php include('report.php'); ?>
<i class="ditp-icon icon-ico-ditp-06"></i>
<span class="txt_hr_report">Report</span>


<form method="post" action="index.php?page=report/report_issue_detail" id="issue_filter" enctype="multipart/form-data">
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
            <div class="col-md-2" style="font-weight: bold;">ช่วงเวลา</div>
            <div class="col-md-3 col-xs-12">
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
                <option value="<?=$year;?>"><?=$year_sum;?></option>
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
                <option value="<?=$year;?>"><?=$year;?></option>
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
            <div class="col-md-3 col-xs-12">
              <span class="txt_report">รายไตรมาส</span>
            </div>
            <div class="col-md-4 col-xs-12" id="quarter_txt">
              <select class="selectpicker form-control" name="quarter" id="select_quarter_chk" onchange="select_quarter(this.value);">
                <option value="">- เลือกไตรมาส -</option>
                <option value="1">ไตรมาส ที่ 1</option>
                <option value="2">ไตรมาส ที่ 2</option>
                <option value="3">ไตรมาส ที่ 3</option>
                <option value="4">ไตรมาส ที่ 4</option>
              </select>
            </div>
            <div class="col-md-5"></div>
          </div>
          <div class="row div_report date_issue date_issue_panel">
            <div class="col-md-2"></div>
            <div class="col-md-3 col-xs-12">
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
                <option value="<?=$key?>"><?=$value?></option>
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
                <option value="<?=$key?>"><?=$value?></option>
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
      <div class="row date_issue row-margin">
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

          <div class="row div_report">
            <div class="col-md-4"><option value="">ประเภทเรื่องร้องเรียน</div>
            <div class="col-md-8">
              <select class="selectpicker form-control" data-live-search="true" name="compType_id">
                <option value="">- ประเภทเรื่องร้องเรียนทั้งหมด -</option>
                <?php
                $sql = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0 AND compType_section = '".$_SESSION['admin']['empSection']."'";
                $query = $conn->query($sql);
                while ($re = $query->fetch_assoc()) {
                 ?>
                <option value="<?=$re['compType_id']?>"><?=$re['compType_name']?></option>
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
                        /* $disabled = "disabled"; */
                      }else{
                        $disabled = '';
                      }
                      if($lv > 1){
                        $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
                      }else {
                        $arrow = '';
                      }
                      $ref_name_real = $ref_name."/".$prod_type["prodType_name"];
                      $option .= '<option '.$disabled.' value="'.$prod_type["prodType_id"].'" rel="'.$prod_type["prodType_level"].'" data-content="<span class=\'txt\' style=\'padding-left:'.(20*($lv)).'px\'>'.$arrow.'<h style=\'display:none;\'>'.$ref_name_real.'</h>'.$prod_type["prodType_name"].'</span>" >
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
              <select class="selectpicker form-control" data-live-search="true" name="caseCh_id" >
                <option value="">- ช่องทางการรับเรื่องร้องเรียนทั้งหมด -</option>
                <?php
                $sql = "SELECT * FROM `Case_Channel` WHERE caseCh_level = 1 AND caseCh_status = 0 AND
                caseCh_enable = 1 AND (caseCh_section = '".$_SESSION['admin']['empSection']."' OR caseCh_section = 0)";
                $query = $conn->query($sql);
                while ($li = $query->fetch_assoc()) {
                ?>
                <optgroup>
                  <option value="<?=$li['caseCh_id']?>" data-content="<span class='label' style='color:#000;font-family:kanit;font-weight:lighter;font-size: 16px;'><?=$li['caseCh_name']?></span>">
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
                    <option value="<?=$result_sub['caseCh_id']?>"
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
                <option value="<?=$ls['id']?>"><?=$ls['name']?></option>
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
                <option value="<?=$lr['id']?>"><?=$lr['name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row div_report">
            <div class="col-md-4">การเป็นสมาชิกของกรม (ผู้ร้องเรียน)</div>
            <div class="col-md-8">
              <select class="selectpicker form-control" name="member_comp_type">
                <option value="">- ทั้งหมด -</option>
                <option value="0">ไม่ระบุ</option>
                <option value="1">เป็นสมาชิกกรม</option>
                <option value="2">ไม่เป็นสมาชิกกรม</option>
              </select>
            </div>
          </div>
          <div class="row div_report">
            <div class="col-md-4">การเป็นสมาชิกของกรม (ผู้ถูกร้องเรียน)</div>
            <div class="col-md-8">
              <select class="selectpicker form-control" name="member_comp_type_ditp">
                <option value="">- ทั้งหมด -</option>
                <option value="0">ไม่ระบุ</option>
                <option value="1">เป็นสมาชิกกรม</option>
                <option value="2">ไม่เป็นสมาชิกกรม</option>
              </select>
            </div>
          </div>
          <div class="row div_report">
            <div class="col-md-4">สถานะเรื่องร้องเรียน</div>
            <div class="col-md-8">
              <select class="selectpicker form-control" name="status_complaint">
                <option value="">- ทั้งหมด -</option>
                <option value="0">Waiting</option>
                <option value="1">New</option>
                <option value="2">In Process</option>
                <option value="3">Close</option>
                <option value="4">Overdue</option>
                <option value="5">Close(overdue)</option>
              </select>
            </div>
          </div>
          <div class="row div_report">
            <div class="col-md-4">ผู้รับผิดชอบ</div>
            <div class="col-md-8">
              <select class="selectpicker form-control" data-live-search="true" name="respon">
                <option value="">- ทั้งหมด -</option>
                <?php
                if($_SESSION['admin']['office'] != 0){
                  $office = " AND office_id = ".$_SESSION['admin']['office'];
                }
                $sql = "SELECT * FROM `Employee` AS e
                LEFT JOIN `Employee_Group` AS eg ON e.empGroup_id = eg.empGroup_id
                WHERE e.emp_status = 0 AND eg.empGroup_level = 0 AND eg.empGroup_section='".$_SESSION['admin']['empSection']."' AND eg.empGroup_status = 0 AND eg.empGroup_enable = 1 $office";
                $query = $conn->query($sql);
                while ($rc = $query->fetch_assoc()) {
                ?>
                <option value="<?=$rc['emp_id']?>"><?=$rc['emp_firstname'];?>&nbsp;<?=$rc['emp_lastname'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>
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
        </div>
        <div class="col-md-2"></div>
    </div>
    </div>
    <hr style="margin-left:10px;margin-right:10px;">
    <div class="btn-report-issue">
      <button type="button" class="btn btn-success submit_report_issue">ตกลง</button>
    </div>
  </div>
  </div>

</form>


</div>
<script>

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
