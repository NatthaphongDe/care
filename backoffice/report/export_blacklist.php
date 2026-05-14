<?php
  include("../../config/config.php");
  ob_start();

  $date = date("Y-m-d");

  $file_name = "รายงานสถานะการเฝ้าระวัง "."(".$date.")";
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
  <table border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td colspan="16">
        รายงานสถานะการเฝ้าระวัง
          <span>
            ( <?php
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
          ?> )
      </span>
      </td>
    </tr>
    <tr>
      <td colspan="16">
        <span class="total-case-blacklist_txt">Total case : </span>
              <span class="total-case-blacklist"><?=$_POST['case']?></span>
              <span class="open-blacklist">(</span>
              <span class="total-waiting-blacklist"><?=$_POST['waiting']?></span>
              <span class="total-new-blacklist"><?=$_POST['new']?></span>
              <span class="total-pending-blacklist"><?=$_POST['pending']?></span>
              <span class="total-overduemain-blacklist"><?=$_POST['overduemain']?></span>
              <span class="total-overduesub-blacklist"><?=$_POST['overduesub']?></span>
              <span class="total-closesuccess-blacklist"><?=$_POST['closesuccess']?></span>
              <span class="total-closecontinue-blacklist"><?=$_POST['closecontinue']?></span>
              <span class="total-closereject-blacklist"><?=$_POST['closereject']?></span>
              <span class="total-close-blacklist"><?=$_POST['close']?></span>
              <span class="total-close-blacklistc"><?=$_POST['Closeoverdue']?></span>
              <span class="end-blacklist">)</span>
      </td>
    </tr>
    <tr>
      <td colspan="16">
        <span>สถานะบริษัท : </span>
        <span>
          <?php
          if($_POST['reliable'] == ""){
            echo "สถานะบริษัททั้งหมด";
          }else {
            if($_POST['reliable'] == "1"){
              echo "Watchlist";
            }elseif ($_POST['reliable'] == "2") {
              echo "Blacklist";
            }
          }
           ?>
        </span>
      </td>
    </tr>
    <tr>
      <td colspan="16"></td>
    </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="0">
    <tr height="30" bgcolor="#e7e7e7">
      <td width="50" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ลำดับที่</td>
      <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">เลขที่เคส</td>
      <td width="100" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">วันที่รับเรื่อง</td>
      <td width="230" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">วันที่ยุติ</td>
      <td width="150" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">หัวข้อ</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ชื่อบริษัท</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">สินค้า</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">ประเทศ</td>
      <td width="250" align="center" style="font-weight:bold;vertical-align: middle;white-space:nowrap">สถานะบริษัท</td>
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

  $text = $_POST['export-text'];
  $blacklist_year_th = $_POST['blacklist_year_th'];
  $quarter = $_POST['quarter'];
  $month_blacklist_th = $_POST['month_blacklist_th'];
  $reliable = $_POST['reliable'];
  $limit = $_POST['export-limit'];
  $offset = $_POST['export-offset'];
  $sort = $_POST['export-sort'];
  $order = $_POST['export-order'];

$i_num = 1;
  if($month_blacklist_th == ""){
    if($quarter == ""){
      if($blacklist_year_th == ""){
        $where_date = "";
      }else {
        if($year_set_2 == "2"){
          $year = $blacklist_year_th;
          $year_start = ($year-1)."-10-01";
          $year_end = $year."-09-30";
          $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
        }else {
          $year = $blacklist_year_th;
          $year_start = $year."-01-01";
          $year_end = $year."-12-31";
          $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
        }
      }
    }else {
      $year = $blacklist_year_th;
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
    $year = $blacklist_year_th;
    $month = $month_blacklist_th;
    $year_start = $year."-".$month."-01";
    $year_end = $year."-".$month."-31";
    $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
  }

  if($reliable == ""){
    $where_reliable = " AND reliable in (1, 2)";
  } else {
    $where_reliable = " AND reliable = $reliable";
  }

  if($text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (c.caseDtl_title LIKE '%".$text."%' OR c.case_id LIKE '%".$text."%' OR p.prodType_name LIKE '%".$text."%' OR c.prodType_other LIKE '%".$text."%' OR c.complnt_name LIKE '%".$text."%')";
  }
  

  $sqlomplaint = "  SELECT  case_id ,case_opened_datetime ,case_close_datetime,case_compType_duration FROM `Case`  WHERE   `case_status` = 3 ";
  // exit();
  $queryomplaint = $conn->query($sqlomplaint);
  $allS = array();
    while($results = $queryomplaint->fetch_assoc()){
      $all_work = getDateTimeData($results["case_opened_datetime"],date("Y-m-d 00:00:00",strtotime($results["case_close_datetime"])));
      if($all_work['days']>$results['case_compType_duration']){
        $results['days']  = $all_work['days'];
        array_push($allS,$results['case_id']);
      }
    }

 
  $sql = "SELECT 
  c.case_id, 
  c.case_create_datetime, 
  c.case_receivedoc_date, 
  c.case_close_datetime, 
  c.case_opened_datetime, 
  c.caseDtl_title, 
  c.complnt_name, 
  c.complnt_country_id,
  IF(c.prodType_id = 1251, c.prodType_other, p.prodType_name) AS product_name, 
  c.prodType_other,
  c.reliable, 
  c.case_status,
  c.case_compType_duration,
  c.caseClose_id,
  c.case_lastSave_datetime,
  p.prodType_id, 
  p.prodType_name, 
  p.prodType_name_en,
  ct.name_th as country_name_th,
  ct.name as country_name
  FROM `Case` AS c 
  LEFT JOIN `Product_Type` AS p ON c.prodType_id = p.prodType_id 
  LEFT JOIN `Country` AS ct ON c.complnt_country_id = ct.id";
  $sql .= " WHERE 1 $whereSearch $where_date $where_reliable ";

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


  $output = "";
  $sql_caseCh = "SELECT
  c.case_id, 
  c.case_create_datetime, 
  c.case_receivedoc_date, 
  c.case_close_datetime, 
  c.case_opened_datetime, 
  c.caseDtl_title, 
  c.complnt_name, 
  c.complnt_country_id,
  IF(c.prodType_id = 1251, c.prodType_other, p.prodType_name) AS product_name, 
  c.prodType_other,
  c.reliable, 
  c.case_status,
  c.case_compType_duration,
  c.caseClose_id,
  c.case_lastSave_datetime,
  p.prodType_id, 
  p.prodType_name, 
  p.prodType_name_en,
  ct.name_th as country_name_th,
  ct.name as country_name
  FROM `Case` AS c 
  LEFT JOIN `Product_Type` AS p ON c.prodType_id = p.prodType_id 
  LEFT JOIN `Country` AS ct ON c.complnt_country_id = ct.id";
  $sql_caseCh .= " WHERE 1 $whereSearch $where_date $where_reliable ";

  if($sort=="id"){
    $sort_col = "c.case_create_datetime";
  }
  if($sort=="case_id"){
    $sort_col = "c.case_id";
  }
  if($sort=="case_receivedoc_date"){
    $sort_col = "c.case_lastSave_datetime";
  }
  if($sort=="company_name"){
    $sort_col = "c.complnt_name";
  }
  if($sort=="product"){
    $sort_col = "product_name";
  }
  if($sort=="close"){
    $sort_col = "c.case_close_datetime";
  }
  // echo $sql_caseCh;
  $sql_caseCh .= " ORDER BY $sort_col  $order ";

  $query_case = $conn->query($sql_caseCh);
  $i_padding = 0;
  $page = 1;
  $txt_time_subover = "";
  while ($li = $query_case->fetch_assoc()) {

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


    $arrd = array( '1'   => 'Close(overdue) : คู่กรณีสามารถตกลงกันได้'
                    ,'2'  => 'Close(overdue) : คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป'
                    ,'3'  => 'Close(overdue) : ไม่สามารถดำเนินการได้'
                    ,'4'  => 'Close(overdue) : ไม่พบมูลความผิด'
                    ,'5'  => 'Close(overdue) : ภาคทัณฑ์'
                    ,'6'  => 'Close(overdue) : ตัดเงินเดือน'
                    ,'7'  => 'Close(overdue) : ลดขั้นเงินเดือน'
                    ,'8'  => 'Close(overdue) : ปลดออก'
                    ,'9'  => 'Close(overdue) : ไล่ออก'
                    ,'10' => 'Close(overdue) : อื่นๆ'
                    ,'11' => 'Close(overdue) : ตรวจสอบความน่าเชื่อถือของบริษัท' );

    if(in_array($li['case_id'],$allS)){
        $status = $arrd[$li['caseClose_id']];
        $id = "Close".$li['caseClose_id'];
    }

    $reliable = '';
    if($li['reliable'] == 1){
      $reliable = 'Watchlist';
    } elseif($li['reliable'] == 2){
      $reliable = 'Blacklist';
    } else{
      $reliable = 'ไม่มีสถานะ';
    }
    ?>

    <td align="center" valign="middle"><?=$i_num?></td>
    <td align="left" valign="middle"><?=$li['case_id']?></td>
    <td align="left" valign="middle"><?=$date_receivedoc_ex?></td>
    <td align="left" valign="middle"><?=$case_close?></td>
    <td align="left" valign="middle"><?=$li['caseDtl_title']?></td>
    <td align="left" valign="middle"><?=$li['complnt_name']?></td>
    <td align="left" valign="middle"><?=$li['product_name']?></td>
    <td align="left" valign="middle"><?=$li['country_name']?></td>
    <td align="center" valign="middle"><?=$reliable?></td>
  </tr>

  <?php
  $txt_time_subover = "";

  $i_num++;
  }
  ?>
  </table>
  </body>
  </html>
