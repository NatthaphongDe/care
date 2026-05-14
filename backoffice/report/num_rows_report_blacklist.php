<?php

include("../../config/config.php");
switch ($_POST['method']) {
  case "report_blacklist":
    echo report_blacklist();
  break;
}
switch ($_GET['method']) {
  case "search_text_blacklist":
  $txt_search = $_GET['txt_search'];
    echo search_text_blacklist($txt_search);
  break;
}
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
  global $conn;
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

function report_blacklist(){

  global $conn;
  
   $text = $_POST['text'];
   $blacklist_year_th = $_POST['blacklist_year_th'];
   $quarter = $_POST['quarter'];
   $month_blacklist_th = $_POST['month_blacklist_th'];
   $reliable = $_POST['reliable'];

  if($month_blacklist_th == ""){
    if($quarter == ""){
      if($blacklist_year_th == ""){
        $where_date = "";
      }else {
        $year = $blacklist_year_th;
        $year_start = $year."-01-01";
        $year_end = $year."-12-31";
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
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
  } else {
    $year = $blacklist_year_th;
    $month = $month_blacklist_th;
    $year_start = $year."-".$month."-01";
    $year_end = date("Y-m-d", strtotime("last day of $year-$month"));
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
   //echo $sql;
  
  $query = $conn->query($sql);

  $over_list = array();
  while ($li = $query->fetch_assoc()) {

    if($li['case_close_datetime'] == "" || $li['case_close_datetime'] == NULL){
      $case_close_datetime = date('Y-m-d 00:00:00',time());
    }else {
      $case_close_datetime = date("Y-m-d 00:00:00",strtotime($li['case_close_datetime']));
    }
    $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($li['case_opened_datetime'])),$case_close_datetime);
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
  
  $query_case = $conn->query($sql_caseCh);
  $num = $query_case->num_rows;
  $query_edit_pass = $conn->query($sql_caseCh);
  $co_id = 0 ;
  $i_padding = 0;
  $waiting = 0;
  $new = 0;
  $pending = 0;
  $overduemain = 0;
  $overduesub = 0;
  $closesuccess = 0;
  $closecontinue = 0;
  $closereject = 0;
  $close = 0;
  $Closeoverdue = 0;

  $num_row = 0;
  while ($re = $query_edit_pass->fetch_assoc()) {

    if($re['case_status'] == 3){
      $end_date_close = $re['case_close_datetime'];
      $start_date_close = $re['case_opened_datetime'];
    }else if($re['case_status'] == 2){
      $end_date_close = date("Y-m-d H:i:s");
      $start_date_close = $re['case_opened_datetime'];
    }else {
      $end_date_close = date("Y-m-d H:i:s");
      $start_date_close = date("Y-m-d H:i:s");
    }

    $set_time = getDateTimeData($start_date_close,$end_date_close);

    $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
    if($day_subholiday>0){
    $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
    }else{
    $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
    }


    $num_process = 0;
    $txt_over = "";
    $txt_timeover = "";

    if($re['case_status'] == "0"){
      $status = "Waiting";
      $waiting++;
    } elseif ($re['case_status'] == "1") {
      $status = "New";
      $new++;
    } elseif ($re['case_status'] == "2") {

      if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
        $case_close_datetime = date('Y-m-d 00:00:00',time());
      }else {
        $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
      }
      $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

      if($chk_time_close['days'] > $re['case_compType_duration']){
        $status = "Overdue Main process";
        if(in_array($re['case_id'],$allS)){
          $Closeoverdue++;
        }else{
          $overduemain++;
        }
      } else {

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
        WHERE p.case_id = '".$re['case_id']."'";

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
             $over_time = getDateDiff($time_over,$time_compare);
            $i++;
          }else{
            $i = 0;
          }
          $num_process++;
        }

        if($i == "0"){
          $status = "Pending";
          $pending++;
        }else {
          $status = "Overdue Sub process";
          $overduesub++;
        }


      }

    } elseif ($re['case_status'] == "3") {
      if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
        $case_close_datetime = date('Y-m-d 00:00:00',time());
      }else {
        $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
      }
      $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

      if($chk_time_close['days'] > $re['case_compType_duration']){
        $status = "Overdue Main process";
        if(in_array($re['case_id'],$allS)){
          $Closeoverdue++;
        } else{
          $overduemain++;
        }
      } else {

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
        WHERE p.case_id = '".$re['case_id']."'";

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
            $over_time = getDateDiff($time_over,$time_compare);
            $i++;
          }else{
            $i = 0;
          }
          $num_process++;
        }

        if($i == "0"){

          if($_SESSION['admin']['empSection'] == "1"){
            if($re['caseClose_id'] == "1"){
              $status = "Close ตกลงกันได้";
              $closesuccess++;
            }elseif ($re['caseClose_id'] == "2") {
              $status = "Close ผู้ร้องดำเนินการต่อ";
              $closecontinue++;
            }elseif ($re['caseClose_id'] == "3") {
              $status = "Close ไม่สามารถดำเนินการได้ ";
              $closereject++;
            }elseif ($re['caseClose_id'] == "11") {
              $status = "Close";
              $close++;
            }
          }else {
            if($re['caseClose_id'] == "4"){
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "5") {
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "6") {
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "7") {
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "8") {
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "9") {
              $status = "Close";
              $close++;
            }elseif ($re['caseClose_id'] == "10") {
              $status = "Close";
              $close++;
            }
          }

        } else {
          $status = "Overdue Sub process";
          $overduesub++;
        }


      }
    }
    $num_row++;
   $num = $num_row;

   if($status_complaint == "2" || $status_complaint == "3" || $status_complaint == "4"){
            if($i_padding == "0"){

              if($re['case_status'] == 3){
                $end_date_close = $re['case_close_datetime'];
                $start_date_close = $re['case_opened_datetime'];
              }else if($re['case_status'] == 2){
                $end_date_close = date("Y-m-d H:i:s");
                $start_date_close = $re['case_opened_datetime'];
              }else {
                $end_date_close = date("Y-m-d H:i:s");
                $start_date_close = date("Y-m-d H:i:s");
              }

              $set_time = getDateTimeData($start_date_close,$end_date_close);

              $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
               if($day_subholiday>0){
                $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
               }else{
                $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
               }

              $co_id++ ;
              $num_page = $offset;
              $page = $co_id + $num_page;


               $num_process = 0;
               $txt_over = "";
               $txt_timeover = "";

              if($re['case_status'] == "0"){
                $status = "Waiting";
                $waiting++;
                $num_row++;
              }elseif ($re['case_status'] == "1") {
                $status = "New";
                $new++;
                $num_row++;
              }elseif ($re['case_status'] == "2") {
                if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
                  $case_close_datetime = date('Y-m-d 00:00:00',time());
                }else {
                  $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
                }
                $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

                if($chk_time_close['days'] > $re['case_compType_duration']){
                  $status = "Overdue Main process";
                  if(in_array($re['case_id'],$allS)){
                    $Closeoverdue++;
                  }else{
                    $overduemain++;
                  }
                  $num_row++;
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
                  WHERE p.case_id = '".$re['case_id']."'";

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
                      $over_time = getDateDiff($time_over,$time_compare);
                      $i++;
                    }else{
                      $i = 0;
                    }
                    $num_process++;
                  }

                  if($i == "0"){
                    $status = "Pending";
                    $num_row++;
                    $pending++;
                  }else {
                    $status = "Overdue Sub process";
                    $overduesub++;
                    $num_row++;
                  }


                }

              }elseif ($re['case_status'] == "3") {

                if($re['case_close_datetime'] == "" || $re['case_close_datetime'] == NULL){
                  $case_close_datetime = date('Y-m-d 00:00:00',time());
                }else {
                  $case_close_datetime = date("Y-m-d 00:00:00",strtotime($re['case_close_datetime']));
                }
                $chk_time_close = getDateTimeData(date("Y-m-d 00:00:00",strtotime($re['case_opened_datetime'])),$case_close_datetime);

                if($chk_time_close['days'] > $re['case_compType_duration']){
                  $status = "Overdue Main process";
                  if(in_array($re['case_id'],$allS)){
                    $Closeoverdue++;
                  }else{
                    $overduemain++;
                  }
                  $num_row++;
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
                  WHERE p.case_id = '".$re['case_id']."'";

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
                      $over_time = getDateDiff($time_over,$time_compare);
                      $i++;
                    }else{
                        $i = 0;
                    }
                    $num_process++;
                  }

                  if($i == "0"){
                    if($_SESSION['admin']['empSection'] == "1"){
                      if($re['caseClose_id'] == "1"){
                        $status = "Close ตกลงกันได้";
                        $closesuccess++;
                      }elseif ($re['caseClose_id'] == "2") {
                        $status = "Close ผู้ร้องดำเนินการต่อ";
                        $closecontinue++;
                      }elseif ($re['caseClose_id'] == "3") {
                        $status = "Close ไม่สามารถดำเนินการได้ ";
                        $closereject++;
                      }elseif ($re['caseClose_id'] == "11") {
                        $status = "Close";
                        $close++;
                      }
                    }else {
                      if($re['caseClose_id'] == "4"){
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "5") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "6") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "7") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "8") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "9") {
                        $status = "Close";
                        $close++;
                      }elseif ($re['caseClose_id'] == "10") {
                        $status = "Close";
                        $close++;
                      }
                    }
                  }else {
                    $status = "Overdue Sub process";
                    $overduesub++;
                  }
                }
              }

            }
                    $num_row++;
        }
        $num = $num_row;
      }

      $output['total'] = $num;
      $output['waiting'] = $waiting;
      $output['new'] = $new;
      $output['pending'] = $pending;
      $output['overduemain'] = $overduemain;
      $output['overduesub'] = $overduesub;
      $output['closesuccess'] = $closesuccess;
      $output['closecontinue'] = $closecontinue;
      $output['closereject'] = $closereject;
      $output['close'] = $close;
      $output['Closeoverdue'] = $Closeoverdue;
     header("content-type:application/json;charset=utf-8");
     echo json_encode( $output );
}


function search_text_blacklist($txt_search){


  global $conn;

  $sql = "SELECT * FROM `Case` WHERE applnt_firstname LIKE '%$txt_search%' OR applnt_lastname LIKE '%$txt_search%' OR complnt_name LIKE '%$txt_search%'";
  $query = $conn->query($sql);
  if($query->num_rows > 0){
    $output = array();
    while ($rs = $query->fetch_assoc()) {
     $case = array();
     $case['name'] = $rs['applnt_firstname'];
     array_push($output,$case);
    }
    echo json_encode($output);
  }
  exit();
}
?>
