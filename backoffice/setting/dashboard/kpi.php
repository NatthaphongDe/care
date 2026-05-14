<?php
session_start();
include("../config/config.php");

//-- ฟังกชั่นหาวันหยุดระหว่างวันที่กำหนด--//
function getHoliday($st_date,$en_date){
  $start = new DateTime($st_date);
  $end = new DateTime($en_date);
  $days = $start->diff($end, true)->days;
  $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
  $saturdays = intval($days / 6) + ($start->format('N') + $days % 6 >= 6);
  $holiday = $sundays+$saturdays;
  if($holiday>0){
  }

  return $holiday;
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

$search_kpi = $_POST['search_kpi'];
$year_kpi = $_POST['year_kpi'];
$month_kpi = $_POST['month_kpi'];

 if($search_kpi==0){
   if($month_kpi !='' ){
     if($month_kpi=='1'){$mon = '-01-';}
     if($month_kpi=='2'){$mon = '-02-';}
     if($month_kpi=='3'){$mon = '-03-';}
     if($month_kpi=='4'){$mon = '-04-';}
     if($month_kpi=='5'){$mon = '-05-';}
     if($month_kpi=='6'){$mon = '-06-';}
     if($month_kpi=='7'){$mon = '-07-';}
     if($month_kpi=='8'){$mon = '-08-';}
     if($month_kpi=='9'){$mon = '-09-';}
     if($month_kpi=='10'){$mon = '-10-';}
     if($month_kpi=='11'){$mon = '-11-';}
     if($month_kpi=='12'){ $mon = '-12-';}
   }
   if($mon != ''){
     $case_d = " AND case_receivedoc_date  like '%".$mon."%' ";
   }
   if($year_kpi !='' ){
     $case_y .= " AND case_receivedoc_date  like '%".$year_kpi."%' ";
   }
 }else{
   $startDate = $_POST['startDate_kpi'];
   $stopDate = $_POST['stopDate_kpi'];
   $display_kpi = $_POST['display_kpi'];
   $year_type_kpi = $_POST['year_type_kpi'];
   $month_issue = $_POST['month'];
   $select_quarter_chk = $_POST['select_quarter_chk_kpi'];
   $issue_year = $_POST['issue_year'];


   if($year_type_kpi==1){
     if($startDate!='' && $stopDate !='' ){
       if($display_kpi==1){
         $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
         $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
         $startDateY = $startDateY-543;
         $stopDateY = $stopDateY-543;
         $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
         $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
         $startDateY =  $startDateY."/".$startDate;
         $stopDateY=  $stopDateY."/".$stopDate;
         // echo "11";
       }else {
         // echo "22";
         $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
         $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
       }
       $sql_se = " AND case_receivedoc_date >= '$startDateY'  AND case_receivedoc_date <= '$stopDateY' ";
       $sql_se_2 = " AND a.caseAsign_create_datetime >= '$startDateY'  AND a.caseAsign_create_datetime <= '$stopDateY' ";
     }else if($month_issue!=''){
       if($month_issue=='1'){$mon = '-01-';}
       if($month_issue=='2'){$mon = '-02-';}
       if($month_issue=='3'){$mon = '-03-';}
       if($month_issue=='4'){$mon = '-04-';}
       if($month_issue=='5'){$mon = '-05-';}
       if($month_issue=='6'){$mon = '-06-';}
       if($month_issue=='7'){$mon = '-07-';}
       if($month_issue=='8'){$mon = '-08-';}
       if($month_issue=='9'){$mon = '-09-';}
       if($month_issue=='10'){$mon = '-10-';}
       if($month_issue=='11'){$mon = '-11-';}
       if($month_issue=='12'){ $mon = '-12-';}
       $sql_se = "AND case_receivedoc_date like '%".$mon."%'  ";
       $sql_se_2 = "AND a.caseAsign_create_datetime like '%".$mon."%'  ";
     }else if($select_quarter_chk !='' ){
       if($select_quarter_chk==1){
         $st = $issue_year."-01-01";
         $sp = $issue_year."-04-01";
       }else if($select_quarter_chk==2){
         $st = $issue_year."-04-01";
         $sp = $issue_year."-07-01";
       }else if($select_quarter_chk==3){
         $st = $issue_year."-07-01";
         $sp = $issue_year."-10-01";
       }else if($select_quarter_chk==4){
         $st = $issue_year."-10-01";
         $sp = $issue_year."-12-31";
       }
       $sql_se = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date < '$sp' ";
       $sql_se_2 = " AND a.caseAsign_create_datetime >= '$st'  AND a.caseAsign_create_datetime < '$sp' ";
     }else if($issue_year != ''){
       $sql_se = "AND case_receivedoc_date like '%".$issue_year."%'  ";
       $sql_se_2 = "AND a.caseAsign_create_datetime like '%".$issue_year."%'  ";
     }
   }else{    // ปีงบประมาณ
     $st = $issue_year."-10-01";
     $issue_year = $issue_year +1;
     $sp = $issue_year."-09-30";
     $sql_se = " AND case_receivedoc_date >= '$st'  AND case_receivedoc_date <= '$sp' ";
     $sql_se_2 = " AND caseAsign_create_datetime >= '$st'  AND a.caseAsign_create_datetime <= '$sp' ";
   }
 }
$sql_kpi = "SELECT * FROM Employee AS emp left join Employee_Group as emp_g on emp_g.empGroup_id = emp.empGroup_id where emp_g.empGroup_section = '".$_SESSION["admin"]["empSection"]."'

              ";
// echo
// $sql_kpi = "SELECT COUNT(caseAsign_id) AS count_kpi , emp.emp_firstname , emp.emp_lastname,emp.emp_real_id,emp.emp_id
//             FROM Case_Assign AS a
//             LEFT JOIN `Case` AS b ON (a.case_id = b.case_id)
//             LEFT JOIN Employee AS emp on emp.emp_id = a.emp_id
//             left join  Complaint_Type on Complaint_Type.compType_id = b.compType_id
//             WHERE case_status = 3
//             AND caseAsign_status = 0
//             AND b.case_assign_status = 1
//             AND a.caseAsign_disKPI =0
//             AND  Complaint_Type.compType_section = '".$_SESSION["admin"]["empSection"]."'
//             AND a.caseAsign_create_datetime like '%".$mon."%'
//             AND a.caseAsign_create_datetime  like '%".$year_kpi."%'
//             $sql_se_2
//             group by a.emp_id
//             ORDER BY `count_kpi` DESC
//             limit 10
//               ";
$query_kpi = $conn->query($sql_kpi);

if($query_kpi->num_rows>0){
while ($re_kpi = $query_kpi->fetch_assoc()) {

    $array_case = array();
    $sql_case = "SELECT * FROM `Case_Assign` as a left join `Case` as b on a.case_id = b.case_id
                WHERE a.emp_id  = '".$re_kpi['emp_id']."'
                AND a.caseAsign_status = 0
                $case_d
                $case_y
                $sql_se
                GROUP by a.case_id
                ORDER by a.caseAsign_id DESC";
  $query_case = $conn->query($sql_case);
  $case = $query_case->num_rows;
  while ($re_case = $query_case->fetch_assoc()) {
    array_push($array_case,$re_case['case_id']);

  }
  // echo "<pre>";
  // print_r($array_case);
  // echo "<pre>";

  // new
  $sql_edit = "SELECT  case_id FROM  `Case` WHERE case_status = 1 AND case_id in  (".join(',',$array_case).")  $sql_se  $case_d $case_y";
  $query_edit = $conn->query($sql_edit);
  // echo $new= $query_edit->num_rows;
  $new = 0;
  if($query_edit->num_rows>0){
    while ( $re_edit =   $query_edit->fetch_assoc()) {
      $new++;
    }
  }




  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  for ($i=0; $i < 3 ; $i++) {
    $array_padd = array();
        if($i==0){
          // echo
          $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,ct.compType_duration FROM  `Case` as c
          LEFT JOIN Complaint_Type as ct on  c.compType_id = ct.compType_id
          WHERE case_status = 2  $sql_se  $case_d $case_y ";
        }else if($i==1){

          $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,ct.compType_duration FROM  `Case` as c
          LEFT JOIN Complaint_Type as ct on  c.compType_id = ct.compType_id
          WHERE case_status in (2,3)  $sql_se  $case_d $case_y ";
        }else if($i==2){
          $sql_Pending = "SELECT c.case_id,c.case_opened_datetime,c.case_close_datetime,ct.compType_duration FROM  `Case` as c
          LEFT JOIN Complaint_Type as ct on  c.compType_id = ct.compType_id
          WHERE case_status = 3  $sql_se  $case_d $case_y ";
        }

    $query_Pending = $conn->query($sql_Pending);
    $i_padding_num = 0;
    while ( $re_Pending =   $query_Pending->fetch_assoc()) {

      $chk_time_close = getDateTimeData($re_Pending['case_opened_datetime'],$re_Pending['case_close_datetime']);
      if($chk_time_close['days'] > $re_Pending['compType_duration']){
        $status = "Overdue Main process";
        array_push($array_padd,$re_Pending['case_id']);

      }else {

        $sql_process = "SELECT
        p.case_id,
        p.process_type_id,
        pt.process_type_duration,
        p.process_over_datetime,
        p.process_complete_datetime,
        p.process_status
        FROM  `Process` as p
        left join Process_Type as pt on p.process_type_id =  pt.process_type_id
        WHERE  p.case_id =  '".$re_Pending['case_id']."'";
        $query_process = $conn->query($sql_process);
        $i_padding = 0;

        while ( $re_process =   $query_process->fetch_assoc()) {
          $time_over_x = $re_process["process_over_datetime"];
          if($re_process["process_status"]==1){
            $time_compare_x = strtotime($re_process["process_complete_datetime"]);
          }else{
            $time_compare_x = time();
          }
          if($time_compare_x > $time_over_x){
            $i_padding++;

            array_push($array_padd,$re_process['case_id']);

          }else {
            $i_padding = 0;
          }
        }
      }
    }

        if($i==0){
          if(join(',',$array_padd)==''){
            $array_check = "''";
          }else{
            $array_check = join(',',$array_padd);
          }
        $sql_Pending_1 = "SELECT * FROM  `Case` WHERE case_status = 2  AND case_id in (".join(',',$array_case).")  AND case_id not in (".$array_check.")  $case_d $case_y $sql_se";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_pad = $query_Pending_1->num_rows;
        if($num_pad == ""){
          $num_pedding = "0";
        }else {
          $num_pedding = $num_pad;
        }
      }else if($i==1){

        if(join(',',$array_padd)==''){
          $array_check1 = "''";
        }else{
          $array_check1 = join(',',$array_padd);
        }
        $sql_Pending_1 = "SELECT * FROM  `Case` WHERE case_status in (2,3) AND case_id in (".join(',',$array_case).")  AND case_id in (".$array_check1.") $case_d $case_y $sql_se";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_overdue = $query_Pending_1->num_rows;
        if($num_overdue == ""){
          $num_overdue = "0";
        }else {
          $num_overdue = $num_overdue;
        }


      }else if ($i==2){
        if(join(',',$array_padd)==''){
          $array_check2 = "''";
        }else{
          $array_check2 = join(',',$array_padd);
        }
        $sql_Pending_1 = "SELECT * FROM  `Case` WHERE case_status = 3  AND case_id in (".join(',',$array_case).")  AND case_id not in ('".$array_check2."') $case_d $case_y $sql_se ";
        $query_Pending_1 = $conn->query($sql_Pending_1);
        $num_close = $query_Pending_1->num_rows;
        // echo $sql_Pending_1;
        if($num_close == ""){
          $num_close = "0";
        }else {
          $num_close = $num_close;
        }
      }
    }



$new_bar =  ($new *100) /$case;
  // echo "<br>";
$num_pedding_bar =  ($num_pedding *100) /$case;
  // echo "<br>";
$num_overdue_bar =  ($num_overdue *100) /$case;
  // echo "<br>";
$num_close_bar =  ($num_close *100) /$case;
  // echo "<br>";


// echo $re_kpi['emp_img_path'];
?>
  <div class="col-md-6">
    <div class="in_block box_pki" style="">
      <?php if(!file_exists('../../'.$re_kpi['emp_img_path']) || $re_kpi['emp_img_path']=='' ) { ?>
        <div class="img_activ" style="background:url('setting/img/profile_emp-01.svg') no-repeat center; background-size:cover; margin-top: 5px;"></div>

      <?php }else{ ?>
        <div class="img_activ" style="background:url(../<?=$re_kpi['emp_img_path'];?>) no-repeat center; background-size:cover; margin-top: 5px;"></div>

      <?php }  ?>
      <div class="col-md-3" style="">
        <div class="kpi_txtname over_txt" style="top: 5px;position: relative;">
          <?php echo $re_kpi['emp_firstname']; ?>
        </div><br>
        <div class="kpi_txtid">
          ID : <?php echo $re_kpi['emp_real_id']; ?>
        </div>
      </div>

      <div class=" col-md-5">
        <div class="progress">
          <div class="progress-bar bar_new_1" style="width: <?=$new_bar?>%">
            <?=$new?> case
          </div>
          <div class="progress-bar bar_pending_1" style="width: <?=$num_pedding_bar?>%" >
            <?=$num_pedding?> case
          </div>
          <div class="progress-bar bar_overdue_1" style="width: <?=$num_overdue_bar?>%">
            <?=$num_overdue?> case
          </div>
          <div class="progress-bar bar_close_1" style="width: <?=$num_close_bar?>%">
            <?=$num_close?> case
          </div>
          <?php if($num_close==0){ ?>
          <div class="progress-bar bar_none_1" style="width: 100%">
            <?=$num_close?> case
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="float_right sum_kpi_box">
        <div class="kpi_txttotal">
          Total Case
        </div><br>
        <div class="kpi_txtsum">
          <?php echo $case; ?>
        </div>
      </div>
    </div>
  </div>

  <?php }
}else{
  ?>
  <div class="no_data_kpi">
    ไม่พบรายการที่ค้นหา !
  </div>
  <?
} ?>
