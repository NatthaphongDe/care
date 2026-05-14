<?php
  include("../../config/config.php");
  ob_start();

  $date = date("Y-m-d");

  $file_name = "รายงานมูลค่าความเสียหาย "."(".$date.")";
  $strExcelFileName=" $file_name.xls";

  header("Content-type: text/html; charset=utf-8");
  header('Content-type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename=\"$strExcelFileName\"");
  header("Pragma: no-cache");
  header("Expires: 0");


  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> DITP </title>

  </head>

  <body style="font-size:12px; color:#333; font-family:Tahoma; margin:0; padding:0;">
  <table border="0">
    <tr>
      <td colspan="14">
        รายงานมูลค่าความเสียหาย
          <span>
            ( <?php
            if($_POST['year_set_1'] == "1"){
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_cost_th'] != ""){
                  if($_POST['month_cost_th'] == "01"){
                    $month = "มกราคม";
                  }elseif ($_POST['month_cost_th'] == "02") {
                    $month = "กุมภาพันธ์";
                  }elseif ($_POST['month_cost_th'] == "03") {
                    $month = "มีนาคม";
                  }elseif ($_POST['month_cost_th'] == "04") {
                    $month = "เมษายน";
                  }elseif ($_POST['month_cost_th'] == "05") {
                    $month = "พฤษภาคม";
                  }elseif ($_POST['month_cost_th'] == "06") {
                    $month = "มิถุนายน";
                  }elseif ($_POST['month_cost_th'] == "07") {
                    $month = "กรกฎาคม";
                  }elseif ($_POST['month_cost_th'] == "08") {
                    $month = "สิงหาคม";
                  }elseif ($_POST['month_cost_th'] == "09") {
                    $month = "กันยายน";
                  }elseif ($_POST['month_cost_th'] == "10") {
                    $month = "ตุลาคม";
                  }elseif ($_POST['month_cost_th'] == "11") {
                    $month = "พฤศจิกายน";
                  }elseif ($_POST['month_cost_th'] == "12") {
                    $month = "ธันวาคม";
                  }
                  if($_POST['year_set_2'] == "1"){
                          $type_year = " (ปีปฎิทิน)";
                        }else {
                          $type_year = " (ปีงบประมาณ)";
                        }
                  echo $month." ปี ".((int)$_POST['cost_year_th']+543).$type_year;
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
                    echo $quarter."ปี : ".((int)$_POST['cost_year_th']+543).$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".((int)$_POST['cost_year_th']+543).$type_year;
                  }
                }
              }
            }else {
              if($_POST['date_start'] != "" && $_POST['date_stop'] != ""){
                echo "Date : ".$_POST['date_start']." - ".$_POST['date_stop'];
              }else {
                if($_POST['month_cost_en'] != ""){
                  if($_POST['month_cost_en'] == "01"){
                    $month = "January";
                  }elseif ($_POST['month_cost_en'] == "02") {
                    $month = "February";
                  }elseif ($_POST['month_cost_en'] == "03") {
                    $month = "March";
                  }elseif ($_POST['month_cost_en'] == "04") {
                    $month = "April";
                  }elseif ($_POST['month_cost_en'] == "05") {
                    $month = "May";
                  }elseif ($_POST['month_cost_en'] == "06") {
                    $month = "June";
                  }elseif ($_POST['month_cost_en'] == "07") {
                    $month = "July";
                  }elseif ($_POST['month_cost_en'] == "08") {
                    $month = "August";
                  }elseif ($_POST['month_cost_en'] == "09") {
                    $month = "September";
                  }elseif ($_POST['month_cost_en'] == "10") {
                    $month = "October";
                  }elseif ($_POST['month_cost_en'] == "11") {
                    $month = "November";
                  }elseif ($_POST['month_cost_en'] == "12") {
                    $month = "December";
                  }
                  if($_POST['year_set_2'] == "1"){
                    $type_year = " (ปีปฎิทิน)";
                  }else {
                    $type_year = " (ปีงบประมาณ)";
                  }
                  echo $month." ปี ".$_POST['cost_year_en'].$type_year;
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
                    echo $quarter."ปี : ".$_POST['cost_year_en'].$type_year;
                  }else {
                    if($_POST['year_set_2'] == "1"){
                      $type_year = " (ปีปฎิทิน)";
                    }else {
                      $type_year = " (ปีงบประมาณ)";
                    }
                    echo "ปี : ".$_POST['cost_year_en'].$type_year;
                  }
                }
              }
            }
          ?> )
      </span>
      </td>
    </tr>
    <tr>
      <td colspan="14">
        <span class="total-case-cost_txt">Total case : </span>
              <span class="total-case-cost"><?=$_POST['case']?></span>
              <span class="open-cost">(</span>
              <span class="total-waiting-cost"><?=$_POST['waiting']?></span>
              <span class="total-new-cost"><?=$_POST['new']?></span>
              <span class="total-pending-cost"><?=$_POST['pending']?></span>
              <span class="total-overduemain-cost"><?=$_POST['overduemain']?></span>
              <span class="total-overduesub-cost"><?=$_POST['overduesub']?></span>
              <span class="total-closesuccess-cost"><?=$_POST['closesuccess']?></span>
              <span class="total-closecontinue-cost"><?=$_POST['closecontinue']?></span>
              <span class="total-closereject-cost"><?=$_POST['closereject']?></span>
              <span class="total-close-cost"><?=$_POST['close']?></span>
              <span class="end-cost">)</span>
      </td>
    </tr>
    <tr>
      <td colspan="14">
        <span>เลือกประเภทเรื่องร้องเรียน : </span>
        <span>
          <?php
          if($_POST['compType_id'] == ""){
            echo "ประเภทเรื่องร้องเรียนทั้งหมด";
          }else {
              $sql = "SELECT *
              FROM `Complaint_Type`
              WHERE compType_section = '".$_SESSION['admin']['empSection']."' AND compType_id = '".$_POST['compType_id']."'";
              $query = $conn->query($sql);
              if($query->num_rows > 0){
                while ($res = $query->fetch_assoc()) {
                  echo $res['compType_name'];
                }
              }
          }
          ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <?php if($_SESSION['admin']['empSection'] == "2"){?>
        <span>เลือกประเภทความผิด : </span>
        <span>
          <?php
          if($_POST['prodType_id'] == ""){
            echo "ประเภทความผิดทั้งหมด";
          }else {
            $sql = "SELECT *
            FROM `Incorrect_Type`
            WHERE incType_id = '".$_POST['prodType_id']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              while ($res = $query->fetch_assoc()) {
                echo $res['compType_name'];
              }
            }
          }
           ?>
        </span>
        <?php }else { ?>
          <span>เลือกประเภทสินค้า : </span>
          <span>
            <?php
            if($_POST['prodType_id'] == ""){
              echo "ประเภทสินค้าทั้งหมด";
            }else {
              $sql = "SELECT *
              FROM Product_Type
              WHERE prodType_id = '".$_POST["prodType_id"]."'
              AND prodType_status = 0
              AND prodType_enable = 1";
              $query = $conn->query($sql);
              $prod_num = $query->num_rows;
              if($prod_num > 0){
              while($result = $query->fetch_assoc()){
                    echo $result['prodType_name'];

                }
              }
            }
            ?>
          </span>
        <?php } ?>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>ประเทศผู้ร้องเรียน : </span>
        <span>
          <?php
          if($_POST['Country_applnt'] == ""){
            echo "ประเทศผู้ร้องเรียนทั้งหมด";
          }else {
            $sql = "SELECT * FROM `Country` WHERE id = '".$_POST['Country_applnt']."' AND country_enable = 1 AND country_status = 0";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              while ($ls = $query->fetch_assoc()) {
                echo $ls['name'];
              }
            }

          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>ประเทศผู้ถูกร้องเรียน : </span>
        <span>
          <?php
          if($_POST['Country_complnt'] == ""){
            echo "ประเทศผู้ถูกร้องเรียนทั้งหมด";
          }else {
            $sql = "SELECT * FROM `Country` WHERE id = '".$_POST['Country_complnt']."' AND country_enable = 1 AND country_status = 0";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              while ($lr = $query->fetch_assoc()) {
                echo $lr['name'];
              }
            }
          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>การเป็นสมาชิกของกรม : </span>
        <span>
          <?php
          if($_POST['member_comp_type'] == ""){
            echo "การเป็นสมาชิกของกรมทั้งหมด";
          }else {
            if($_POST['member_comp_type'] == "0"){
              echo "ไม่ระบุ";
            }elseif ($_POST['member_comp_type'] == "1") {
              echo "เป็นสมาชิกกรม";
            }elseif ($_POST['member_comp_type'] == "2") {
              echo "ไม่เป็นสมาชิกกรม";
            }
          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>สถานะเรื่องร้องเรียน : </span>
        <span>
          <?php
          if($_POST['status_complaint'] == ""){
            echo "สถานะเรื่องร้องเรียนทั้งหมด";
          }else {
            if($_POST['status_complaint'] == "0"){
              echo "Waiting";
            }elseif ($_POST['status_complaint'] == "1") {
              echo "New";
            }elseif ($_POST['status_complaint'] == "2") {
              echo "In Process";
            }elseif ($_POST['status_complaint'] == "3") {
              echo "Close";
            }elseif ($_POST['status_complaint'] == "4") {
              echo "Overdue";
            }

          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>ผู้รับผิดชอบ : </span>
        <span>
          <?php
          if($_POST['respon'] == ""){
            echo "ผู้รับผิดชอบทั้งหมด";
          }else {
            $sql = "SELECT * FROM `Employee` WHERE emp_status = 0 AND emp_id = '".$_POST['respon']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              while ($rc = $query->fetch_assoc()) {
                echo $rc['emp_firstname']."  ".$rc['emp_lastname'];
              }
            }
          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>มูลค่าความเสียหาย : </span>
        <span>
          <?php
          if($_POST['damage_start'] == "" && $_POST['damage_end'] == ""){
            echo "มูลค่าความเสียหายทั้งหมด";
          }elseif ($_POST['damage_start'] == "" && $_POST['damage_end'] != "") {
            echo "มูลค่าความเสียหาย ตั้งแต่ ".$_POST['damage_end']." ลงไป";
          }elseif ($_POST['damage_start'] != "" && $_POST['damage_end'] == "") {
            echo "มูลค่าความเสียหาย ตั้งแต่ ".$_POST['damage_start']." เป็นต้นไป";
          }else {
            echo "มูลค่าความเสียหาย ตั้งแต่ ".$_POST['damage_start']." ถึง ".$_POST['damage_end'];
          }
           ?>
        </span>
      </td>
      </tr>
        <tr>
          <td colspan="14">
        <span>หน่วย : </span>
        <span>
          <?php

            $sql = "SELECT * FROM `Currency` WHERE curren_id = '".$_POST['Currency']."'";
            $query = $conn->query($sql);
            if($query->num_rows > 0){
              while ($rxs = $query->fetch_assoc()) {
                echo $rxs['curren_name'];
              }
            }else {
              echo "ทั้งหมด";
            }

           ?>
        </span>

      </td>
    </tr>
    <tr>
      <td colspan="14"></td>
    </tr>
  </table>
  <table border="1" cellspacing="0" cellpadding="0">
    <tr height="30" bgcolor="#e7e7e7">
      <td width="50" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">#</td>
      <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">วันที่รับเรื่อง</td>
      <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">วันที่ยุติ</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเภทเรื่องร้องเรียน</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเภทเรื่องร้องเรียนย่อย</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเภทกรณีเรื่องร้องเรียน</td>
      <?php if($_SESSION['admin']['empSection'] == "1"){ ?>
        <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเภทสินค้า</td>
      <?php }else { ?>
        <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเภทความผิด</td>
      <?php }?>
      <td width="200" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">มูลค่าความเสียหาย</td>
      <td width="150" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ผู้ร้องเรียน</td>
      <td width="150" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ผู้ถูกร้องเรียน</td>
      <td width="200" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">สถานะเรื่องร้องเรียน</td>
      <td width="150" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ผู้รับผิดชอบ</td>
      <td width="150" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">เวลา</td>
      <td width="200" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">การเป็นสมาชิกของกรม</td>
    </tr>
  <?php
  //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
  function getHoliday($st_date,$en_date){
    $start = new DateTime($st_date);
    $end = new DateTime($en_date);
    $days = $start->diff($end, true)->days;
    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
    $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
    $holiday = (int)$sundays+(int)$saturdays+(int)getHoliday_public(date('Y-m-d',strtotime($st_date)),date('Y-m-d',strtotime($en_date)));
    if($holiday>0){
      /*if($type!="full"){
        $holiday = $holiday-1;
      }*/
    }

    return $holiday;
  }

  //-- ฟังกชั่นหาจำนวนวันหยุดจากระบบ-//
  function getHoliday_public($start, $end){
    include("../../config/config.php");
    $sql = "SELECT * FROM `PublicHoliday` WHERE `holiday_status` = '0' AND holiday_date_start<='$start' AND holiday_date_end>='$end' ";
    $query = $conn->query($sql);
    $num_holiday_= $query->num_rows;
    while($result = $query->fetch_assoc()){

      $start = new DateTime($result['holiday_date_start']." 00:00:00");
      $end = new DateTime($result['holiday_date_end']." 00:00:00");
      $days = $start->diff($end, true)->days;
      $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
      $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
      $num_holiday_= $result["holiday_date_amount"]-($sundays+$saturdays);

    }
    return $num_holiday_public;
  }
    //-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
  function getDateTimeData($st_datetime,$end_datetime){
    $data = array();
    $startDate = date('Y-m-d H:i:s',strtotime($st_datetime));
    $endDate = date('Y-m-d H:i:s',strtotime($end_datetime));
    $getHoliday = getHoliday($startDate,$endDate);
    $startDatetime = $st_datetime;
    $endDatetime = $end_datetime;
    if($getHoliday>0){
      $endDatetime_subholoday = date('Y-m-d H:i:s', strtotime('-'.$getHoliday.' day', strtotime($endDate)));
    }else{
      $endDatetime_subholoday = $end_datetime;
    }
    $seconds = strtotime($endDatetime_subholoday) - strtotime($startDatetime);
    $days    = floor($seconds / 86400);
    $hours   = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

    $data["startDate"] = $startDate;
    $data["endDate"] = $endDate;
    $data["getHoliday"] = $getHoliday;
    $data["startDatetime"] = $startDatetime;
    $data["endDatetime"] = $endDatetime;
    $data["endDatetime_subholoday"] = $endDatetime_subholoday;

    $data["seconds"] = $seconds;
    $data["days"]    = $days;
    $data["hours"]   = $hours;
    $data["minutes"] = $minutes;
    return $data;

  }

  function getDateDiff($st_datetime,$end_datetime){
    $data = array();
    $startDate = date('Y-m-d H:i:s',$st_datetime);
    $endDate = date('Y-m-d H:i:s',$end_datetime);
    $startDatetime = $startDate;
    $endDatetime = $endDate;

    $seconds = strtotime($endDatetime) - strtotime($startDatetime);
    $days    = floor($seconds / 86400);
    $hours   = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

    $data["seconds"] = $seconds;
    $data["days"]    = $days;
    $data["hours"]   = $hours;
    $data["minutes"] = $minutes;
    return $data;

  }

  $year_set_1 = $_POST['year_set_1'];
  $year_set_2 = $_POST['year_set_2'];
  $cost_year_th = $_POST['cost_year_th'];
  $cost_year_en = $_POST['cost_year_en'];
  $quarter = $_POST['quarter'];
  $month_cost_th = $_POST['month_cost_th'];
  $month_cost_en = $_POST['month_cost_en'];
  $date_start = $_POST['date_start'];
  $date_stop = $_POST['date_stop'];
  $compType_id = $_POST['compType_id'];
  $prodType_id = $_POST['prodType_id'];
  $Country_applnt = $_POST['Country_applnt'];
  $Country_complnt = $_POST['Country_complnt'];
  $member_comp_type = $_POST['member_comp_type'];
  $status_complaint = $_POST['status_complaint'];
  $respon = $_POST['respon'];
  $damage_start = $_POST['damage_start'];
  $damage_end = $_POST['damage_end'];
  $Currency = $_POST['Currency'];
  $office_id = $_POST['office_id'];

  $i_num = 1;
  if($year_set_1 =="1"){
    if($date_start == ""){
      if($month_cost_th == ""){
        if($quarter == ""){
          if($cost_year_th == ""){
            $where_date = "";
          }else {
            if($year_set_2 == "2"){
              $year = $cost_year_th;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $cost_year_th;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }
          }
        }else {
          $year = $cost_year_th;
          if($quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($quarter == "3") {
            $year_start = $year."-07-01";
            $year_end = $year."-09-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }else {
            $year_start = $year."-10-01";
            $year_end = $year."-12-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }
        }
      }else {
        $year = $cost_year_th;
        $month = $month_cost_th;
        $year_start = $year."-".$month."-01";
        $year_end = $year."-".$month."-31";
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($date_stop == ""){
        $year = $cost_year_th;
        $month = $month_cost_th;
        $date_start = $date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_rx_year = $date_ex[2]-543;
        $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $cost_year_th;
        $month = $month_cost_th;
        $date_start = $date_start;
        $date_stop = $date_stop;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_rx_year = $date_ex[2]-543;
        $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

        $date_time_rx = $date_stop;
        $date_time_rx = explode(" ",$date_time_rx);
        $date_rx = $date_time_rx[0];
        $date_rx = explode("/",$date_rx);
        $date_ex_year = $date_rx[2]-543;
        $date_stop_rx= $date_ex_year."-".$date_rx[1]."-".$date_rx[0];

        $year_start = $date_start_ex;
        $year_end = $date_stop_rx;
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }

  }else {
    if($date_start == ""){
      if($month_cost_en == ""){
        if($quarter == ""){
          if($cost_year_en == ""){
            $where_date = "";
          }else {
            if($year_set_2 == "2"){
              $year = $cost_year_en;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $cost_year_en;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }
          }
        }else {
          $year = $cost_year_en;
          if($quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($quarter == "3") {
            $year_start = $year."-07-01";
            $year_end = $year."-09-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }else {
            $year_start = $year."-10-01";
            $year_end = $year."-12-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }
        }
      }else {
        $year = $cost_year_en;
        $month = $month_cost_en;
        $year_start = $year."-".$month."-01";
        $year_end = $year."-".$month."-31";
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($date_stop == ""){
        $year = $cost_year_en;
        $month = $month_cost_en;
        $date_start = $date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $cost_year_en;
        $month = $month_cost_en;
        $date_start = $date_start;
        $date_stop = $date_stop;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

        $date_time_rx = $date_stop;
        $date_time_rx = explode(" ",$date_time_rx);
        $date_rx = $date_time_rx[0];
        $date_rx = explode("/",$date_rx);
        $date_stop_rx= $date_rx[2]."-".$date_rx[1]."-".$date_rx[0];

        $year_start = $date_start_ex;
        $year_end = $date_stop_rx;
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }
  }


 if($compType_id == ""){
   $where_comp = "";
 }else {
   $where_comp = " AND c.compType_id = $compType_id";
 }

 if($_SESSION['admin']['empSection'] == "1"){
   if($prodType_id == ""){
     $where_prod = "";
   }else {
     $where_prod = " AND (c.prodType_id = $prodType_id OR pt.prodType_ref_id = $prodType_id)";
   }
 }else {
   if($prodType_id == ""){
     $where_prod = "";
   }else {
     $where_prod = " AND c.incType_id = $prodType_id";
   }
 }


 if($Country_applnt == ""){
   $whereCountry_applnt = "";
 }else {
   $whereCountry_applnt = " AND c.applnt_country_id = $Country_applnt";
 }

 if($Country_complnt == ""){
   $whereCountry_complnt = "";
 }else {
   $whereCountry_complnt = " AND c.complnt_country_id = $Country_complnt";
 }

 if($member_comp_type == ""){
   $wheremembe = "";
 }else {
   $wheremembe = " AND c.applnt_valid_ditp = $member_comp_type";
 }


 if($damage_start == "" && $damage_end == "" ){
   $wheredamage = "";
 }else if($damage_start == ""){
     $wheredamage = "  AND c.caseDtl_damage_val <= '".$damage_end."'";
 }else if($damage_end == ""){
     $wheredamage = "  AND c.caseDtl_damage_val >= '".$damage_start."'";
 }else {
   $wheredamage = "  AND c.caseDtl_damage_val >= '".$damage_start."' AND c.caseDtl_damage_val <= '".$damage_end."'";
 }

 if($Currency == ""){
   $whereCurrency = "";
 }else {
   $whereCurrency = " AND c.curren_id = $Currency";
 }

 if($text == ""){
   $whereSearch = "";
 }else {
   $whereSearch = " AND (ch.caseCh_name LIKE '%".$text."%' OR ct.compType_name LIKE '%".$text."%' OR pt.prodType_name LIKE '%".$text."%')";
 }

 if($status_complaint == ""){
   $whereStatus = "";
 }else {
   if($status_complaint == "0"){
       $whereStatus = " AND c.case_status = $status_complaint";
   }elseif ($status_complaint == "1") {
       $whereStatus = " AND c.case_status = $status_complaint";
   }elseif ($status_complaint == "2") {
       $whereStatus = " AND c.case_status = $status_complaint";
   }elseif ($status_complaint == "3") {
       $whereStatus = " AND c.case_status = $status_complaint";
   }elseif ($status_complaint == "4") {
       $whereStatus = " AND c.case_status IN (2,3)";
   }

 }

 if($office_id == ""){
   $where_office = "";
 }else {
   $where_office = " AND c.office_id = $office_id";
 }

 if($respon == ""){
   $sql = "SELECT
   c.case_create_datetime,
   c.prodType_other,
   c.office_id,
   c.caseDtl_title,
   c.case_status,
   c.compType_id,
   c.compTypeSub1_id,
   c.compTypeSub2_id,
   ct.compType_name,
   c.case_compType_duration,
   ct1.compTypeSub1_name,
   ct2.compTypeSub2_name,
   c.prodType_id,
   pt.prodType_name,
   c.applnt_firstname,
   c.applnt_lastname,
   c.complnt_name,
   c.case_close_datetime,
   c.caseCh_id,
   c.case_id,
   c.applnt_country_id,
   c.complnt_country_id,
   ch.caseCh_name,
   c.case_opened_datetime,
   c.case_close_resultProcess,
   c.applnt_valid_ditp,
   c.caseDtl_damage_val,
   c.curren_id,
   c.caseClose_id,
   c.incType_id,
   it.incType_name,
   cu.curren_name,
   c.case_lastSave_datetime
   FROM `Case` AS c
   LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
   LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
   LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
   LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
   LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
   LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id
   LEFT JOIN `Currency` AS cu ON c.curren_id = cu.curren_id";
   $sql .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' $whereSearch $where_date $where_comp $where_prod  $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $wheredamage $whereCurrency $where_office ";
 }else {
   $whererespon = " AND a.emp_id = $respon";
   $sql = "SELECT
   c.case_create_datetime,
   c.prodType_other,
   c.office_id,
   c.caseDtl_title,
   c.case_status,
   c.compType_id,
   c.compTypeSub1_id,
   c.compTypeSub2_id,
   ct.compType_name,
   c.case_compType_duration,
   ct1.compTypeSub1_name,
   ct2.compTypeSub2_name,
   c.prodType_id,
   pt.prodType_name,
   c.applnt_firstname,
   c.applnt_lastname,
   c.complnt_name,
   c.case_close_datetime,
   c.caseCh_id,
   c.case_id,
   c.applnt_country_id,
   c.complnt_country_id,
   ch.caseCh_name,
   c.case_opened_datetime,
   c.case_close_resultProcess,
   a.emp_id,
   c.applnt_valid_ditp,
   c.caseDtl_damage_val,
   c.curren_id,
   c.caseClose_id,
   c.incType_id,
   it.incType_name,
   cu.curren_name,
   c.case_lastSave_datetime
   FROM `Case` AS c
   LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
   LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
   LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
   LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
   LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
   LEFT JOIN `Case_Assign`  AS a ON c.case_id = a.case_id
   LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id
   LEFT JOIN `Currency` AS cu ON c.curren_id = cu.curren_id";
   $sql .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' AND a.caseAsign_status = 0 $whereSearch $where_date $where_comp $where_prod  $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $wheredamage $whereCurrency $where_office ";
 }
 $query = $conn->query($sql);
 $over_list = array();
 while ($li = $query->fetch_assoc()) {

   if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
     $case_close_datetime = date('Y-m-d 00:00:00',time());
   }else {
     $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
   }
   $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);
   if($chk_time_close['days'] > $li['case_compType_duration']){
     $status = "Overdue Main process";
     array_push($over_list,$li['case_id']);

   }else {
     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$li['case_id']."'";

     $query_process = $conn->query($sql_process);


     while ($res = $query_process->fetch_assoc()) {

       $time_over_x = $res["process_over_datetime"];
       if($res["process_status"]=="1"){
         $time_compare_x = strtotime($res["process_complete_datetime"]);
       }else{
         $time_compare_x = time();
       }

       if($time_compare_x > $time_over_x){
         array_push($over_list,$res['case_id']);
       }
     }
   }
 }

 if($status_complaint == "0" || $status_complaint == "1" || $status_complaint == ""){
   $whereincase = "";
 }elseif ($status_complaint == "2" || $status_complaint == "3") {
   if(join(',',$over_list) == ""){
     $incase = "''";
   }else {
     $incase = join(',',$over_list);
   }
   $whereincase = " AND c.case_id NOT IN (".$incase.")";
 }elseif ($status_complaint == "4") {
   if(join(',',$over_list) == ""){
     $incase = "''";
   }else {
     $incase = join(',',$over_list);
   }
   $whereincase = " AND c.case_id IN (".$incase.")";
 }


 if($respon == ""){
   $caseCh_arr = array();
   $sql_caseCh = "SELECT
   c.case_create_datetime,
   c.prodType_other,
   c.office_id,
   c.caseDtl_title,
   c.case_status,
   c.compType_id,
   c.compTypeSub1_id,
   c.compTypeSub2_id,
   ct.compType_name,
   c.case_compType_duration,
   ct1.compTypeSub1_name,
   ct2.compTypeSub2_name,
   c.prodType_id,
   pt.prodType_name,
   c.applnt_firstname,
   c.applnt_lastname,
   c.complnt_name,
   c.case_close_datetime,
   c.caseCh_id,
   c.case_id,
   c.applnt_country_id,
   c.complnt_country_id,
   ch.caseCh_name,
   c.case_opened_datetime,
   c.case_close_resultProcess,
   c.applnt_valid_ditp,
   c.caseDtl_damage_val,
   c.curren_id,
   c.caseClose_id,
   c.incType_id,
   it.incType_name,
   cu.curren_name,
   c.case_lastSave_datetime
   FROM `Case` AS c
   LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
   LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
   LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
   LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
   LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
   LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id
   LEFT JOIN `Currency` AS cu ON c.curren_id = cu.curren_id";
   $sql_caseCh .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' $whereincase $whereSearch $where_date $where_comp $where_prod  $whereCountry_applnt $whereCountry_complnt $whereStatus $wheremembe $wheredamage $whereCurrency $where_office ";
 }else {
   $whererespon = " AND a.emp_id = $respon";
   $caseCh_arr = array();
   $sql_caseCh = "SELECT
   c.case_create_datetime,
   c.prodType_other,
   c.office_id,
   c.caseDtl_title,
   c.case_status,
   c.compType_id,
   c.compTypeSub1_id,
   c.compTypeSub2_id,
   ct.compType_name,
   c.case_compType_duration,
   ct1.compTypeSub1_name,
   ct2.compTypeSub2_name,
   c.prodType_id,
   pt.prodType_name,
   c.applnt_firstname,
   c.applnt_lastname,
   c.complnt_name,
   c.case_close_datetime,
   c.caseCh_id,
   c.case_id,
   c.applnt_country_id,
   c.complnt_country_id,
   ch.caseCh_name,
   c.case_opened_datetime,
   c.case_close_resultProcess,
   a.emp_id,
   c.applnt_valid_ditp,
   c.caseDtl_damage_val,
   c.curren_id,
   c.caseClose_id,
   c.incType_id,
   it.incType_name,
   cu.curren_name,
   c.case_lastSave_datetime
   FROM `Case` AS c
   LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
   LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
   LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
   LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
   LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
   LEFT JOIN `Case_Assign` AS a ON c.case_id = a.case_id
   LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id
   LEFT JOIN `Currency` AS cu ON c.curren_id = cu.curren_id";
   $sql_caseCh .= " WHERE 1 AND ct.compType_section = '".$_SESSION['admin']['empSection']."' AND a.caseAsign_status = 0 $whereincase $whereSearch $where_date $where_comp $where_prod  $whereCountry_applnt $whereCountry_complnt $whereStatus $whererespon $wheremembe $wheredamage $whereCurrency $where_office ";
 }

  $query_case = $conn->query($sql_caseCh);

  $page = 1;
  $i_padding = 0;
  $txt_time_subover = "";
  while ($li = $query_case->fetch_assoc()) {

if($status_complaint == "2"){
  $sql_process = "SELECT
  p.process_id,
  p.process_type_id,
  p.case_id,
  p.process_type_duration,
  p.process_save_datetime,
  p.process_complete_datetime,
  p.process_status,
  p.process_over_datetime,
  pt.process_type_name
  FROM `Process` AS p
  LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
  WHERE p.case_id = '".$li['case_id']."'";
  $query_process = $conn->query($sql_process);


  while ($res = $query_process->fetch_assoc()) {

    $time_over_x = $res["process_over_datetime"];
    if($res["process_status"]==1){
      $time_compare_x = strtotime($res["process_complete_datetime"]);
    }else{
      $time_compare_x = time();
    }

    if($time_compare_x > $time_over_x){
      $i_padding++;
    }else{

      $i_padding = 0;
    }

  }

}elseif ($status_complaint == "3") {
  $sql_process = "SELECT
  p.process_id,
  p.process_type_id,
  p.case_id,
  p.process_type_duration,
  p.process_save_datetime,
  p.process_complete_datetime,
  p.process_status,
  p.process_over_datetime,
  pt.process_type_name
  FROM `Process` AS p
  LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
  WHERE p.case_id = '".$li['case_id']."'";
  $query_process = $conn->query($sql_process);


  while ($res = $query_process->fetch_assoc()) {

    $time_over_x = $res["process_over_datetime"];
    if($res["process_status"]==1){
      $time_compare_x = strtotime($res["process_complete_datetime"]);
    }else{
      $time_compare_x = time();
    }

    if($time_compare_x > $time_over_x){
      $i_padding++;
    }else{

      $i_padding = 0;
    }

  }

}elseif ($status_complaint == "4") {

  if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
    $case_close_datetime = date('Y-m-d 00:00:00',time());
  }else {
    $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
  }
  $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);
  if($chk_time_close['days'] > $li['case_compType_duration']){
    $status = "Overdue Main process";
    $i_padding = 0;

  }else {
    $sql_process = "SELECT
    p.process_id,
    p.process_type_id,
    p.case_id,
    p.process_type_duration,
    p.process_save_datetime,
    p.process_complete_datetime,
    p.process_status,
    p.process_over_datetime,
    pt.process_type_name
    FROM `Process` AS p
    LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
    WHERE p.case_id = '".$li['case_id']."'";

    $query_process = $conn->query($sql_process);


    while ($res = $query_process->fetch_assoc()) {

      $time_over_x = $res["process_over_datetime"];
      if($res["process_status"]=="1"){
        $time_compare_x = strtotime($res["process_complete_datetime"]);
      }else{
        $time_compare_x = time();
      }

      if($time_compare_x > $time_over_x){
        $i_padding = 0;
      }
    }
  }

}else {
  if($li['case_status'] == "3"){
    $end_date_close = $li['case_close_datetime'];
    $start_date_close = $li['case_opened_datetime'];
  }else if($li['case_status'] == "2"){
    $end_date_close = date("Y-m-d H:i:s");
    $start_date_close = $li['case_opened_datetime'];
  }else {
    $end_date_close = date("Y-m-d H:i:s");
    $start_date_close = date("Y-m-d H:i:s");
  }

  $time_set = getDateTimeData($start_date_close,$end_date_close);
  if($time_set['days'] < 1){
    $date = "";
  }else {
    $date = $time_set['days'].' วัน ';
  }
  if($time_set['hours'] < 1){
    $hours = "";
  }else {
    $hours = $time_set['hours'].' ชั่วโมง ';
  }

  $date_time = $li['case_lastSave_datetime'];
  $date_time_ex = explode(" ",$date_time);
  $date_waitting = $date_time_ex[0];
  $date_ex = explode("-",$date_waitting);
  if($year_set_1 =="1"){
    $date_year = $date_ex[0]+543;
  }else {
    $date_year = $date_ex[0];
  }
  $date_receivedoc= $date_ex[2]."/".$date_ex[1]."/".$date_year;
  if($date_receivedoc == "//543" || $date_receivedoc == "//"){
    $date_receivedoc_ex = "-";
  }else {
    $date_receivedoc_ex = $date_receivedoc;
  }
  $date_time2 = $li['case_close_datetime'];
  $date_time_ex2 = explode(" ",$date_time2);
  $date_waitting2 = $date_time_ex2[0];
  $date_ex2 = explode("-",$date_waitting2);
  if($year_set_1 =="1"){
    $date_close_year = $date_ex2[0]+543;
  }else {
    $date_close_year = $date_ex2[0];
  }
  $case_close= $date_ex2[2]."/".$date_ex2[1]."/".$date_close_year;

  if($case_close == "//543" || $case_close == "//"){
    $case_close = "-";
  }

  $num_process = 0;
  $txt_over = "";
  $txt_timeover = "";

 if($li['case_status'] == "0"){
   $status = "Waiting";
   $id = "Waiting".$li['case_status'];
 }elseif ($li['case_status'] == "1") {
   $status = "New";
   $id = "Waiting".$li['case_status'];
 }elseif ($li['case_status'] == "2") {

   if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
     $case_close_datetime = date('Y-m-d 00:00:00',time());
   }else {
     $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
   }
   $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);
   if($chk_time_close['days'] > $li['case_compType_duration']){
     $status = "Overdue Main";
     $id = "overdue_main";
   }else {

     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$li['case_id']."'";
     $query_process = $conn->query($sql_process);
     $i = 0;
     while ($rx = $query_process->fetch_assoc()) {

       $time_over = $rx["process_over_datetime"];
       if($rx["process_status"]==1){
         $time_compare = strtotime($rx["process_complete_datetime"]);
       }else{
         $time_compare = time();
       }

       if($time_compare>$time_over){
         $txt_over = "กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
         $over_time = getDateDiff($time_over,$time_compare);
         if($over_time['days'] < 1){
           $over_days = "";
         }else {
           $over_days = $over_time['days'].' วัน ';
         }

         if($over_time['hours'] < 1){
           $over_hours = "";
         }else {
           $over_hours = $over_time['hours'].' ชั่วโมง ';
         }
         $txt_timeover = "( ".$over_days.$over_hours.$over_time['minutes']." นาที )";
         $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
         $i++;
       }else{
         $i = 0;
       }
       $num_process++;
     }

     if($i == "0"){
       $status = "In Process";
       $id = "Pending";
     }else {
       $status = "Overdue Sub process";
       $id = "overdue_sub_process";
     }


   }

 }elseif ($li['case_status'] == "3") {

   if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
     $case_close_datetime = date('Y-m-d 00:00:00',time());
   }else {
     $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
   }
   $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);

   if($chk_time_close['days'] > $li['case_compType_duration']){
     $status = "Overdue Main";
     $id = "overdue_main";
   }else {

     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$li['case_id']."'";
     $query_process = $conn->query($sql_process);
     $i = 0;

     while ($rx = $query_process->fetch_assoc()) {

       $time_over = $rx["process_over_datetime"];
       if($rx["process_status"]==1){
         $time_compare = strtotime($rx["process_complete_datetime"]);
       }else{
         $time_compare = time();
       }

       if($time_compare>$time_over){
         $txt_over = "กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
         $over_time = getDateDiff($time_over,$time_compare);

         if($over_time['days'] < 1){
           $over_days = "";
         }else {
           $over_days = $over_time['days'].' วัน ';
         }

         if($over_time['hours'] < 1){
           $over_hours = "";
         }else {
           $over_hours = $over_time['hours'].' ชั่วโมง ';
         }
         $txt_timeover = "( ".$over_days.$over_hours.$over_time['minutes']." นาที )";
         $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
         $i++;
       }else{
           $i = 0;
       }
       $num_process++;
     }

     if($i == "0"){
       if($_SESSION['admin']['empSection'] == "1"){
         if($li['caseClose_id'] == "1"){
           $status = "Close Success : คู่กรณีสามารถตกลงกันได้";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "2") {
           $status = "Close Continue : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "3") {
           $status = "Close Reject : ไม่สามารถดำเนินการได้";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "11") {
           $status = "Close : ตรวจสอบความน่าเชื่อถือของบริษัท";
           $id = "Close".$li['caseClose_id'];
         }
       }else {
         if($li['caseClose_id'] == "4"){
           $status = "Close : ไม่พบมูลความผิด";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "5") {
           $status = "Close : ภาคทัณฑ์";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "6") {
           $status = "Close : ตัดเงินเดือน";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "7") {
           $status = "Close : ลดขั้นเงินเดือน";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "8") {
           $status = "Close : ปลดออก";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "9") {
           $status = "Close : ไล่ออก";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "10") {
           $status = "Close : อื่นๆ";
           $id = "Close".$li['caseClose_id'];
         }
       }
     }else {
       $status = "Overdue Sub process";
       $id = "overdue_sub_process";
     }


   }




 }
?>
    <td align="center" valign="middle"><?=$i_num?></td>
    <td align="left" valign="middle"><?=$date_receivedoc_ex?></td>
    <td align="left" valign="middle"><?=$case_close?></td>
    <?php
    if($li['compTypeSub1_name'] == ""){
      $compTypeSub1 = "-";
    }else {
      $compTypeSub1 = $li['compTypeSub1_name'];
    }
    if($li['compTypeSub2_name'] == ""){
      $compTypeSub2 = "-";
    }else {
      $compTypeSub2 = $li['compTypeSub2_name'];
    }
    ?>
    <td align="left" valign="middle"><?=$li['compType_name']?></td>
    <td align="left" valign="middle"><?=$compTypeSub1?></td>
    <td align="left" valign="middle"><?=$compTypeSub2?></td>
    <?php if($_SESSION['admin']['empSection'] == "1"){
      if($li['prodType_name'] == 'อื่นๆ'){
        $prodType = $li['prodType_other'];
      }else {
        $prodType = $li['prodType_name'];
      }
    }else {
      $prodType = $li['incType_name'];
    }?>
    <td align="left" valign="middle"><?=$prodType?></td>
    <td align="left" valign="middle"><?=$li['caseDtl_damage_val']?> <?=$li['curren_name']?></td>
    <td align="left" valign="middle"><?=$li['applnt_firstname'].'&nbsp;'.$li['applnt_lastname']?></td>
    <td align="left" valign="middle"><?=$li['complnt_name']?></td>
    <td align="center" valign="middle"><?=$status?></td>



    <?php
    if($_SESSION['admin']['office'] == 0){
      $sql_ass = "SELECT *
      FROM `office_type`
      WHERE office_id = '".$li['office_id']."' ";
      $query_ass = $conn->query($sql_ass);
      $counsel = "";
      while ($rs = $query_ass->fetch_assoc()) {
      $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['office_name'].'</span></div><br>';
       }
    }else {
      $sql_ass = "SELECT a.emp_id,a.case_id,e.emp_firstname,e.emp_lastname,a.caseAsign_status
      FROM `Case_Assign` AS a LEFT JOIN `Employee` AS e ON a.emp_id = e.emp_id
      WHERE a.case_id = '".$li['case_id']."' AND a.caseAsign_status = 0";
      $query_ass = $conn->query($sql_ass);
      $counsel = "";
      while ($rs = $query_ass->fetch_assoc()) {
      $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['emp_firstname'].' '.$rs['emp_lastname'].'</span></div><br>';
       }
    }
     if($li['applnt_valid_ditp'] == "1"){
       $member_comp_type = "เป็นสมาชิกกรม";
     }elseif ($li['applnt_valid_ditp'] == "2") {
       $member_comp_type = "ไม่เป็นสมาชิกกรม";
     }else {
       $member_comp_type = "ไม่ระบุ";
     }
     ?>
    <td align="left" valign="middle"><?=$counsel?></td>

    <td align="left" valign="middle"><?=$date?><?=$hours?><?=$time_set['minutes']?> นาที <br>
      <?=$txt_time_subover?>
    </td>
    <td align="center" valign="middle"><?=$member_comp_type?></td>
  </tr>

  <?php
}
$txt_time_subover = "";
if($status_complaint == "2" || $status_complaint == "3" || $status_complaint == "4"){
if($i_padding == "0"){
  if($li['case_status'] == "3"){
    $end_date_close = $li['case_close_datetime'];
    $start_date_close = $li['case_opened_datetime'];
  }else if($li['case_status'] == "2"){
    $end_date_close = date("Y-m-d H:i:s");
    $start_date_close = $li['case_opened_datetime'];
  }else {
    $end_date_close = date("Y-m-d H:i:s");
    $start_date_close = date("Y-m-d H:i:s");
  }

  $time_set = getDateTimeData($start_date_close,$end_date_close);
  if($time_set['days'] < 1){
    $date = "";
  }else {
    $date = $time_set['days'].' วัน ';
  }
  if($time_set['hours'] < 1){
    $hours = "";
  }else {
    $hours = $time_set['hours'].' ชั่วโมง ';
  }


  $date_time = $li['case_lastSave_datetime'];
  $date_time_ex = explode(" ",$date_time);
  $date_waitting = $date_time_ex[0];
  $date_ex = explode("-",$date_waitting);
  if($year_set_1 =="1"){
    $date_year = $date_ex[0]+543;
  }else {
    $date_year = $date_ex[0];
  }
  $date_receivedoc= $date_ex[2]."/".$date_ex[1]."/".$date_year;
  if($date_receivedoc == "//543" || $date_receivedoc == "//"){
    $date_receivedoc_ex = "-";
  }else {
    $date_receivedoc_ex = $date_receivedoc;
  }
  $date_time2 = $li['case_close_datetime'];
  $date_time_ex2 = explode(" ",$date_time2);
  $date_waitting2 = $date_time_ex2[0];
  $date_ex2 = explode("-",$date_waitting2);
  if($year_set_1 =="1"){
    $date_close_year = $date_ex2[0]+543;
  }else {
    $date_close_year = $date_ex2[0];
  }
  $case_close= $date_ex2[2]."/".$date_ex2[1]."/".$date_close_year;

  if($case_close == "//543" || $case_close == "//"){
    $case_close = "-";
  }

  $num_process = 0;
  $txt_over = "";
  $txt_timeover = "";

 if($li['case_status'] == "0"){
   $status = "Waiting";
   $id = "Waiting".$li['case_status'];
 }elseif ($li['case_status'] == "1") {
   $status = "New";
   $id = "Waiting".$li['case_status'];
 }elseif ($li['case_status'] == "2") {

   if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
     $case_close_datetime = date('Y-m-d 00:00:00',time());
   }else {
     $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
   }
   $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);

   if($chk_time_close['days'] > $li['case_compType_duration']){
     $status = "Overdue Main";
     $id = "overdue_main";
   }else {

     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$li['case_id']."'";
     $query_process = $conn->query($sql_process);
     $i = 0;
     while ($rx = $query_process->fetch_assoc()) {

       $time_over = $rx["process_over_datetime"];
       if($rx["process_status"]==1){
         $time_compare = strtotime($rx["process_complete_datetime"]);
       }else{
         $time_compare = time();
       }

       if($time_compare>$time_over){
         $txt_over = "กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
         $over_time = getDateDiff($time_over,$time_compare);
         if($over_time['days'] < 1){
           $over_days = "";
         }else {
           $over_days = $over_time['days'].' วัน ';
         }

         if($over_time['hours'] < 1){
           $over_hours = "";
         }else {
           $over_hours = $over_time['hours'].' ชั่วโมง ';
         }
         $txt_timeover = "( ".$over_days.$over_hours.$over_time['minutes']." นาที )";
         $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
         $i++;
       }else{
         $i = 0;
       }
       $num_process++;
     }

     if($i == "0"){
       $status = "In Process";
       $id = "Pending";
     }else {
       $status = "Overdue Sub process";
       $id = "overdue_sub_process";
     }


   }

 }elseif ($li['case_status'] == "3") {

   if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
     $case_close_datetime = date('Y-m-d 00:00:00',time());
   }else {
     $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
   }
   $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);

   if($chk_time_close['days'] > $li['case_compType_duration']){
     $status = "Overdue Main";
     $id = "overdue_main";
   }else {

     $sql_process = "SELECT
     p.process_id,
     p.process_type_id,
     p.case_id,
     p.process_type_duration,
     p.process_save_datetime,
     p.process_complete_datetime,
     p.process_status,
     p.process_over_datetime,
     pt.process_type_name
     FROM `Process` AS p
     LEFT JOIN `Process_Type` AS pt ON p.process_type_id = pt.process_type_id
     WHERE p.case_id = '".$li['case_id']."'";
     $query_process = $conn->query($sql_process);
     $i = 0;

     while ($rx = $query_process->fetch_assoc()) {

       $time_over = $rx["process_over_datetime"];
       if($rx["process_status"]==1){
         $time_compare = strtotime($rx["process_complete_datetime"]);
       }else{
         $time_compare = time();
       }

       if($time_compare>$time_over){
         $txt_over = "กระบวนการที่ ".$num_process." - ".$rx['process_type_name'];
         $over_time = getDateDiff($time_over,$time_compare);

         if($over_time['days'] < 1){
           $over_days = "";
         }else {
           $over_days = $over_time['days'].' วัน ';
         }

         if($over_time['hours'] < 1){
           $over_hours = "";
         }else {
           $over_hours = $over_time['hours'].' ชั่วโมง ';
         }
         $txt_timeover = "( ".$over_days.$over_hours.$over_time['minutes']." นาที )";
         $txt_time_subover .= $txt_over."<br>".$txt_timeover."<br>";
         $i++;
       }else{
           $i = 0;
       }
       $num_process++;
     }

     if($i == "0"){
       if($_SESSION['admin']['empSection'] == "1"){
         if($li['caseClose_id'] == "1"){
           $status = "Close Success : คู่กรณีสามารถตกลงกันได้";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "2") {
           $status = "Close Continue : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "3") {
           $status = "Close Reject : ไม่สามารถดำเนินการได้";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "11") {
           $status = "Close : ตรวจสอบความน่าเชื่อถือของบริษัท";
           $id = "Close".$li['caseClose_id'];
         }
       }else {
         if($li['caseClose_id'] == "4"){
           $status = "Close : ไม่พบมูลความผิด";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "5") {
           $status = "Close : ภาคทัณฑ์";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "6") {
           $status = "Close : ตัดเงินเดือน";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "7") {
           $status = "Close : ลดขั้นเงินเดือน";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "8") {
           $status = "Close : ปลดออก";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "9") {
           $status = "Close : ไล่ออก";
           $id = "Close".$li['caseClose_id'];
         }elseif ($li['caseClose_id'] == "10") {
           $status = "Close : อื่นๆ";
           $id = "Close".$li['caseClose_id'];
         }
       }
     }else {
       $status = "Overdue Sub process";
       $id = "overdue_sub_process";
     }


   }
 }
?>
    <td align="center" valign="middle"><?=$page?></td>
    <td align="left" valign="middle"><?=$date_receivedoc_ex?></td>
    <td align="left" valign="middle"><?=$case_close?></td>
    <?php
    if($li['compTypeSub1_name'] == ""){
      $compTypeSub1 = "-";
    }else {
      $compTypeSub1 = $li['compTypeSub1_name'];
    }
    if($li['compTypeSub2_name'] == ""){
      $compTypeSub2 = "-";
    }else {
      $compTypeSub2 = $li['compTypeSub2_name'];
    }
    ?>
    <td align="left" valign="middle"><?=$li['compType_name']?></td>
    <td align="left" valign="middle"><?=$compTypeSub1?></td>
    <td align="left" valign="middle"><?=$compTypeSub2?></td>
    <?php if($_SESSION['admin']['empSection'] == "1"){
      if($li['prodType_name'] == 'อื่นๆ'){
        $prodType = $li['prodType_other'];
      }else {
        $prodType = $li['prodType_name'];
      }
    }else {
      $prodType = $li['incType_name'];
    }?>
    <td align="left" valign="middle"><?=$prodType?></td>
    <td align="left" valign="middle"><?=$li['caseDtl_damage_val']?> <?=$li['curren_name']?></td>
    <td align="left" valign="middle"><?=$li['applnt_firstname'].'&nbsp;'.$li['applnt_lastname']?></td>
    <td align="left" valign="middle"><?=$li['complnt_name']?></td>
    <td align="center" valign="middle"><?=$status?></td>



    <?php
    if($_SESSION['admin']['office'] == 0){
      $sql_ass = "SELECT *
      FROM `office_type`
      WHERE office_id = '".$li['office_id']."' ";
      $query_ass = $conn->query($sql_ass);
      $counsel = "";
      while ($rs = $query_ass->fetch_assoc()) {
      $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['office_name'].'</span></div><br>';
       }
    }else {
      $sql_ass = "SELECT a.emp_id,a.case_id,e.emp_firstname,e.emp_lastname,a.caseAsign_status
      FROM `Case_Assign` AS a LEFT JOIN `Employee` AS e ON a.emp_id = e.emp_id
      WHERE a.case_id = '".$li['case_id']."' AND a.caseAsign_status = 0";
      $query_ass = $conn->query($sql_ass);
      $counsel = "";
      while ($rs = $query_ass->fetch_assoc()) {
      $counsel .= '<div class="name_report"><span class="txt_nol">'.$rs['emp_firstname'].' '.$rs['emp_lastname'].'</span></div><br>';
       }
    }


     if($li['applnt_valid_ditp'] == "1"){
       $member_comp_type = "เป็นสมาชิกกรม";
     }elseif ($li['applnt_valid_ditp'] == "2") {
       $member_comp_type = "ไม่เป็นสมาชิกกรม";
     }else {
       $member_comp_type = "ไม่ระบุ";
     }
     ?>
    <td align="left" valign="middle"><?=$counsel?></td>

    <td align="left" valign="middle"><?=$date?><?=$hours?><?=$time_set['minutes']?> นาที <br>
      <?=$txt_time_subover?>
    </td>
    <td align="center" valign="middle"><?=$member_comp_type?></td>
  </tr>

  <?php
   $page++;
}
}

  $i_num++;
  }
  ?>
  </table>
  </body>
  </html>
