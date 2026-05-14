<?php
include("../../config/config.php");
$prodType = array();
if(isset($_GET["method"]) && $_GET["method"]=="report_blacklist"){
  $post = array();
  $request_body = file_get_contents('php://input');
  $post = json_decode($request_body);
  $response = report_blacklist($post);
  echo $response;
  exit();
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

function prodTypeListMutiLv($lv,$ref_id,$pro_id){
  global $conn;
  $prodTypeArrObj = array();
  $sql = "SELECT *
  FROM Product_Type
          WHERE prodType_level = '$lv'
          AND prodType_status = '0'
          AND prodType_enable = '1' ";
  if($ref_id!=""){
    $sql .= "AND prodType_ref_id = '$ref_id' ";
  }else {
    $sql .= "AND prodType_id = '$pro_id' ";
  }
  $query = $conn->query($sql);
  $prod_num = $query->num_rows;
  $lv++;
    while($result = $query->fetch_assoc()){
      $prodArr["prodType_id"] = $result["prodType_id"];
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

function getProdType($lv,$ref_id,$pro_id){
  global $prodType;
  global $conn;
$i=0;
foreach(prodTypeListMutiLv($lv,$ref_id,$pro_id) as $prod_type){
  // echo $prod_type["prodType_id"];
  if($prod_type["prodType_sublist"]>0){
    $n_lv = $lv+1;
    $option .= getProdType($n_lv,$prod_type["prodType_id"],$prod_type["prodType_id"]);
  }
  array_push($prodType,$prod_type["prodType_id"]);
  $i++;
}

return $prodType;
}

function report_blacklist($post){
  global $conn; 
  
  
  if($post->year_set_1 =="1"){
    
    if($post->date_start == ""){
      if($post->month_blacklist_th == ""){
        if($post->quarter == ""){
          if($post->blacklist_year_th == ""){
            $where_date = "";
          }else {
            if($post->year_set_2 == "2"){
              $year = $post->blacklist_year_th;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $post->blacklist_year_th;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }
          }
        }else {
          $year = $post->blacklist_year_th;
          if($post->quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "3") {
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
        $year = $post->blacklist_year_th;
        $month = $post->month_blacklist_th;
        $year_start = $year."-".$month."-01";
        $year_end = date("Y-m-d", strtotime("last day of $year-$month"));
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($post->date_stop == ""){
        $year = $post->blacklist_year_th;
        $month = $post->month_blacklist_th;
        $date_start = $post->date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_rx_year = $date_ex[2]-543;
        $date_start_ex= $date_rx_year."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $post->blacklist_year_th;
        $month = $post->month_blacklist_th;
        $date_start = $post->date_start;
        $date_stop = $post->date_stop;

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
    if($post->date_start == ""){
      if($post->month_blacklist_en == ""){
        if($post->quarter == ""){
          if($post->blacklist_year_en == ""){
            $where_date = "";
          }else {
            if($post->year_set_2 == "2"){
              $year = $post->blacklist_year_en;
              $year_start = ($year-1)."-10-01";
              $year_end = $year."-09-30";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }else {
              $year = $post->blacklist_year_en;
              $year_start = $year."-01-01";
              $year_end = $year."-12-31";
              $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
            }

          }
        }else {
          $year = $post->blacklist_year_en;
          if($post->quarter == "1"){
            $year_start = $year."-01-01";
            $year_end = $year."-03-31";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "2") {
            $year_start = $year."-04-01";
            $year_end = $year."-06-30";
            $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
          }elseif ($post->quarter == "3") {
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
        $year = $post->blacklist_year_en;
        $month = $post->month_blacklist_en;
        $year_start = $year."-".$month."-01";
        $year_end = date("Y-m-d", strtotime("last day of $year-$month"));
        $where_date = " AND (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
    }else {
      if($post->date_stop == ""){
        $year = $post->blacklist_year_en;
        $month = $post->month_blacklist_en;
        $date_start = $post->date_start;

        $date_time = $date_start;
        $date_time_ex = explode(" ",$date_time);
        $date_re = $date_time_ex[0];
        $date_ex = explode("/",$date_re);
        $date_start_ex= $date_ex[2]."-".$date_ex[1]."-".$date_ex[0];

        $year_start = $date_start_ex;
        $where_date = " AND (c.case_create_datetime >= '".$year_start."')";
      }else {
        $year = $post->blacklist_year_en;
        $month = $post->month_blacklist_en;
        $date_start = $post->date_start;
        $date_stop = $post->date_stop;

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
  

  if($post->reliable == ""){
    $where_reliable = " AND reliable in (1, 2)";
  } else {
    $where_reliable = " AND reliable = $post->reliable";
  }
  
  if($post->text == ""){
    $whereSearch = "";
  }else {
    $whereSearch = " AND (c.caseDtl_title LIKE '%".$post->text."%' OR c.case_id LIKE '%".$post->text."%' OR p.prodType_name LIKE '%".$post->text."%' OR c.prodType_other LIKE '%".$post->text."%' OR c.complnt_name LIKE '%".$post->text."%')";
  }
  
  $sqlomplaint = "  SELECT  case_id ,case_opened_datetime ,case_close_datetime,case_compType_duration FROM `Case`  WHERE   `case_status` = 3 and case_close_datetime != '0000-00-00 00:00:00'";
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
  
  //  echo $sql;
  /* print_r($sql);
    exit(); */
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

  $caseCh_arr = array();
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

  if($post->sort=="id"){
    $sort_col = "c.case_create_datetime";
  }
  if($post->sort=="case_id"){
    $sort_col = "c.case_id";
  }
  if($post->sort=="case_receivedoc_date"){
    $sort_col = "c.case_lastSave_datetime";
  }
  if($post->sort=="company_name"){
    $sort_col = "c.complnt_name";
  }
  if($post->sort=="product"){
    $sort_col = "product_name";
  }
  if($post->sort=="close"){
    $sort_col = "c.case_close_datetime";
  }
  // echo $sql_caseCh;
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";

  $query_case = $conn->query($sql_caseCh);
  $num = $query_case->num_rows;


  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";


     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0 ;
     $i_padding = 0;
     $txt_time_subover = "";
     while ($re = $query_edit_pass->fetch_assoc()) {
      $txt_time_subover = "";
      if($i_padding == "0"){
        $end_date_close = $re['case_close_datetime'];
        $start_date_close = $re['case_opened_datetime'];

        $set_time = getDateTimeData($start_date_close,$end_date_close);
        if($set_time['days'] < 1){
          $date = "";
        }else {
          $date = $set_time['days'].' วัน ';
        }
        if($set_time['hours'] < 1){
          $hours = "";
        }else {
          $hours = $set_time['hours'].' ชั่วโมง ';
        }

        $day_subholiday = (int)getHoliday(date('Y-m-d', strtotime($start_date_close)),$end_date_close);
         if($day_subholiday>0){
          $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime('+'.$day_subholiday.' day', strtotime($start_date_close))))->format('Y/m/d H:i:s');
         }else{
          $case_processInit_idx = DateTime::createFromFormat('Y-m-d H:i:s', $start_date_close)->format('Y/m/d H:i:s');
         }

        $caseCh_col_arr = array();
        $co_id++ ;
        $num_page = $post->offset;
        $page = $co_id + $num_page;
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$page.'</span>';

        $date_time = $re['case_lastSave_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $date_ex = explode("-",$date_waitting);
        if($post->year_set_1 =="1"){
          $date_year = $date_ex[0]+543;
        }else {
          $date_year = $date_ex[0];
        }
        $date_receivedoc= $date_ex[2]."/".$date_ex[1]."/".$date_year;

        $date_time_close = $re['case_close_datetime'];
        $date_time_ex_close = explode(" ",$date_time_close);
        $date_waitting_close = $date_time_ex_close[0];
        $date_ex_close = explode("-",$date_waitting_close);
        if($post->year_set_1 =="1"){
          $date_close_year = $date_ex_close[0]+543;
        }else {
          $date_close_year = $date_ex_close[0];
        }
        $date_close= $date_ex_close[2]."/".$date_ex_close[1]."/".$date_close_year;
        if($date_close == "//543" || $date_close == "//"){
          $date_close_ex = "-";
        }else {
          $date_close_ex = $date_close;
        }
        if($date_receivedoc == "//543" || $date_receivedoc == "//"){
          $date_receivedoc_ex = "-";
        }else {
          $date_receivedoc_ex = $date_receivedoc;
        }
         $receivedoc_date = DateTime::createFromFormat('Y-m-d', $re['case_receivedoc_date'])->format('d/m/Y');
        $caseCh_col_arr["case_id"] = '<span class="txt_nol">'.$re['case_id'].'</span>';
        $caseCh_col_arr["case_receivedoc_date"] = '<span class="txt_nol">'.$receivedoc_date.'</span>';
        $caseCh_col_arr["close"] = '<span class="txt_nol">'.$date_close_ex.'</span>';
        if($re['caseDtl_title'] == ""){
          $caseDtl_title = "-";
        }else {
          $caseDtl_title = $re['caseDtl_title'];
        }
        $caseCh_col_arr["caseDtl_title"] = '<div class="caseDtl_title_report"><span class="txt_nol">'.$caseDtl_title.'</span></div>';

        if($re['complnt_name'] == ""){
          $complnt_name = "-";
        }else {
          $complnt_name = $re['complnt_name'];
        }
        $caseCh_col_arr["company_name"] = '<div class="product_report"><span class="txt_nol">'.$complnt_name.'</span></div>';

        if($re['product_name'] == ""){
          $product = "-";
        }else {
          $product = $re['product_name'];
        }
        $caseCh_col_arr["product"] = '<div class="product_report"><span class="txt_nol">'.$product.'</span></div>';

        if($re['country_name'] == ""){
          $country = "-";
        }else {
          $country = $re['country_name'];
        }
        $caseCh_col_arr["country"] = '<div class="product_report"><span class="txt_nol">'.$country.'</span></div>';

        $reliable = '';
        if($re['reliable'] == 1){
         $reliable = 'Watchlist';
        } elseif($re['reliable'] == 2){
         $reliable = 'Blacklist';
        } else{
         $reliable = 'ไม่มีสถานะ';
        }

        $caseCh_col_arr["reliable"] = '<span class="txt_nol">'.$reliable.'</span>';


        array_push($caseCh_arr,$caseCh_col_arr);
      }
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr,'sql'=>$where_date);
     return json_encode($data_array);
}



?>
