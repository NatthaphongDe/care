<?php
// required headers
header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include("../config/config_ws.php");
include("../backoffice/class/main.class.php");
include("../backoffice/class/case.class.php");

$post = json_decode(file_get_contents('php://input'),true);
$post = (object)$post;

$user_data = array();
include("jwt_decode.php");

function remove_lines($string){
  $string = str_replace(array("\r\n", "\r", "\n"), "", $string);
  $string = htmlspecialchars($string);
  return $string;
}

if(time()>$user_data["exp"]){
  $data_array = array('res_code'=>'01', 'message'=>'Token Expired !');
  echo json_encode($data_array);
  exit();
}
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
if($user_data!=""){
  $_case = new case_list();
  $_case_detail = new case_detail();
  $sql = "SELECT *
  FROM User_WebService
  WHERE userws_id='".$user_data["urw"]."'
  AND userws_status_lock = 0";

  $query = $_case->dbConn->query($sql);
  $rows_uws = $query->num_rows;
  if($rows_uws>0){
    $rs_uws = $query->fetch_assoc();
    $login_res = "00";
  }else{
    $login_res = "01";
  }
}else{
  $login_res = "01";
}

if($login_res=="01" || count($user_data)==0){
  $data_array = array('res_code'=>'01', 'message'=>'Token Failed !');
  echo json_encode($data_array);
  exit();
}

//section_id
$_case->admin_section = 1;

//$office_id
$office = " ";

//Status Text
$statusCase_txt = array(
  0 => "Waiting",
  1 => "New",
  2 => "Pending",
  3 => "Close",
  4 => "Overdue",
);

$caseClose_txt = array(
  1 => "คู่กรณีสามารถตกลงกันได้",
  2 => "คู่กรณีดำเนินการในส่วนที่เกี่ยวข้องต่อไป",
  3 => "ไม่สามารถดำเนินการได้",
);

//province
$provinceList_temp = $_case->provinceList();
$provinceList = array();
foreach($provinceList_temp as $case_province_list){
  $provinceList[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
}

// //country list
// $countryList_temp =  $_case->countryList();
// $countryList = array();
// foreach($countryList_temp as $case_province_list){
//   $countryList[$case_country_list["id"]] = $case_country_list["name"];
// }


$arr_sort = array("caseId"=>"case_id","subject"=>"caseDtl_title","date"=>"case_create_datetime","assign"=>"emp_id");
$arr_sort2 = array("applnt","complnt","status");
$case_arr = array();
$sql_case = "SELECT * ";
$sql_case .= "FROM `Case` c ";
$sql_case .= "LEFT JOIN  `Complaint_Type` cmp_t ON (c.compType_id=cmp_t.compType_id) ";
$sql_case .= "LEFT JOIN  `Complaint_Type_Sub1` cmp_ts_1 ON (c.compTypeSub1_id=cmp_ts_1.compTypeSub1_id) ";
$sql_case .= "LEFT JOIN  `Complaint_Type_Sub2` cmp_ts_2 ON (c.compTypeSub2_id=cmp_ts_2.compTypeSub2_id) ";
$sql_case_condition = "WHERE cmp_t.compType_section='$_case->admin_section' $office ";

//Search from product type
$sql_case .= "LEFT JOIN  `Product_Type` prod_t ON (c.prodType_id=prod_t.prodType_id) ";

if($post->prod_type!=""){
  $sql_case_condition .= "AND (prod_t.prodType_id = '$post->prod_type' OR prod_t.prodType_ref_id = '$post->prod_type')  ";
}

//Search from Employee Assigned
if($post->search_assign!=""){
    $sql_case .= "LEFT JOIN `Case_Assign` asign ON (c.case_id=asign.case_id) ";
    $sql_case_condition .= "AND c.case_status>=2 AND asign.emp_id = '".$post->search_assign."' AND asign.caseAsign_status = '0' ";
}


//Search from case type
if($post->case_type!=""){
  $sql_case_condition .= "AND c.compType_id = '$post->case_type' ";
}

//Search from case sub type 1
if($post->case_type_sub1!=""){
  $sql_case_condition .= "AND c.compTypeSub1_id = '$post->case_type_sub1' ";
}

//Search from case sub type 2
if($post->case_type_sub2!=""){
  $sql_case_condition .= "AND c.compTypeSub2_id = '$post->case_type_sub2' ";
}

//Search from priority
$sql_case .= "LEFT JOIN `Case_Priority` pri ON (c.case_priority=pri.casePrt_id) ";
// if($post->priority!=""){
//   $sql_case_condition .= "AND c.case_priority = '$post->priority' ";
// }

//Search from status
if($post->status!=""){
  $sql_case_condition .= "AND c.case_status = '$post->status' ";
}


//Search from channel
$sql_case .= "LEFT JOIN `Case_Channel` chan ON (c.caseCh_id=chan.caseCh_id) ";
if($post->channel!=""){
  $sql_case .= "LEFT JOIN  `Case_Channel` ch ON (c.caseCh_id=ch.caseCh_id) ";
  $sql_case_condition .= "AND (ch.caseCh_id = '$post->channel' OR ch.caseCh_ref_id = '$post->channel')  ";
}

//Search from country
if($post->appellant_country!=""){
  $sql_case_condition .= "AND c.applnt_country_id = '$post->appellant_country') ";
}

//Search from country
if($post->complainant_country!=""){
  $sql_case_condition .= "AND c.complnt_country_id = '$post->complainant_country') ";
}

if($post->department!=""){
  $sql_case_condition .= "AND c.office_id = '$post->department' ";
}


if($post->complainant_corporate_identity!=""){
  $sql_case_condition .= "AND c.complnt_trade_number = '$post->complainant_corporate_identity' ";
}

if($post->open_date!=""){
  $post->open_date = DateTime::createFromFormat('d/m/Y', $post->open_date)->format('Y-m-d');
  $sql_case_condition .= "AND c.case_open_date LIKE '$post->open_date%' ";
}

if($post->last_update_date!=""){
  $post->last_update_date = DateTime::createFromFormat('d/m/Y', $post->last_update_date)->format('Y-m-d');
  $sql_case_condition .= "AND c.last_update_datetime LIKE '$post->last_update_date%' ";
}

$sql_case_condition_search = $sql_case_condition."GROUP BY c.case_id ".$limit;

$sql_case_search = $sql_case.$sql_case_condition_search;
$query_case_search = $_case->dbConn->query($sql_case_search);

$case_overdue_main = array();
$case_overdue_sub = array();

while($rs_case_list = $query_case_search->fetch_assoc()){
  $_case->case_id = $rs_case_list["case_id"];
  $rs_case = $_case->get_case_process_data();


  if($rs_case_list["case_status"]=="2" || $rs_case_list["case_status"]=="3"){

    $datatime_diff = array();
    if($rs_case_list["case_status"]=="2"){
      $datatime_diff = $_case->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case_list["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
    }else if($rs_case_list["case_status"]=="3"){
      $datatime_diff = $_case->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case_list["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($rs_case_list["case_close_datetime"])));
    }
    if($datatime_diff["days"]<0){
      $datatime_diff["days"] = 0;
    }
    if($datatime_diff["days"]>0 && $rs_case_list["case_opened_datetime"]!="" && $datatime_diff["days"]>$rs_case_list["case_compType_duration"]){
      array_push($case_overdue_main,$rs_case_list["case_id"]);
    }
    foreach ($rs_case["case_process"] as $case_process) {


      $time_over = $case_process["process_over_datetime"];
      if($case_process["process_complete_datetime"]!=""){
        $time_compare = strtotime($case_process["process_complete_datetime"]);
      }else{
        $time_compare = time();
      }

      if($time_compare>$time_over){
        if(!in_array($case_overdue_sub,$rs_case_list["case_id"])){
          array_push($case_overdue_sub,$rs_case_list["case_id"]);
        }
      }
    }
  }
}

//----------------------------------------------------------------------------------------------------------------//
if($post->status=="2"){
  $sql_case_condition .= "AND c.case_status='2' ";
  if(count($case_overdue_main)>0){
    $sql_case_condition .= "AND c.case_id NOT IN (".join(",",$case_overdue_main).")";
  }
}else if($post->status=="3"){
  $sql_case_condition .= "AND c.case_status='3' ";
  if(count($case_overdue_main)>0){
    $sql_case_condition .= "AND c.case_id NOT IN (".join(",",$case_overdue_main).")";
  }
}else if($post->status=="main_over"){
  $sql_case_condition .= "AND (c.case_status='2' OR c.case_status='3') ";
  if(count($case_overdue_main)>0){
    $sql_case_condition .= "AND c.case_id IN (".join(",",$case_overdue_main).")";
  }else{
    $sql_case_condition .= "AND c.case_id IN ('')";
  }
}else if($post->status=="sub_over"){
  $sql_case_condition .= "AND (c.case_status='2' OR c.case_status='3') ";
  if(count($case_overdue_sub)>0){
    $sql_case_condition .= "AND c.case_id IN (".join(",",$case_overdue_sub).")";
  }
}

if($post->text!=""){
  $sql_case_condition .= "
    AND ( c.case_id = '".(int)$post->text."'
          OR c.caseDtl_title like '%$post->text%'
          OR (
            (c.applnt_type!=0 AND c.applntOrg_name like '%$post->text%')
            OR (c.applnt_type=0 AND (c.applnt_firstname like '%$post->text%' OR c.applnt_lastname like '%$post->text%'))
          )
          OR (
             (c.complnt_type!=0 AND c.complntOrg_name like '%$post->text%')
             OR (c.complnt_type=0 AND (c.complnt_firstname like '%$post->text%' OR c.complnt_lastname like '%$post->text%'))
          )
        ) ";
}


$offset = $post->offset;
$limit = $post->limit;
//$limit = " LIMIT 10 ";
//$limit = "";

$sql_case_condition .= " GROUP BY c.case_id ";


$sql_case_condition .= "ORDER BY c.case_id DESC ";

$sql_count_case = $sql_case.$sql_case_condition;
//exit();
$query_count_case = $_case->dbConn->query($sql_count_case);

$sql_case = $sql_case.$sql_case_condition.$limit;
$query_case = $_case->dbConn->query($sql_case);
while($rs_case_list = $query_case->fetch_assoc()){

  $rs_case = array();
  $_case->case_id = $rs_case_list["case_id"];
  $rs_case = $_case->get_case_data();
  $rs_case = $_case->get_case_field_data();
  $rs_case = $_case->get_case_process_data();
  $rs_case = $_case->get_case_assign_data();
  $rs_case = $_case->get_case_transfer();
  $comp_type_data = $_case->compTypeDetail($rs_case["case"]["compType_id"]);

  $case_col_arr =array();

  $case_col_arr["case_id"] = sprintf("%05d",$rs_case["case"]["case_id"]);

  $case_col_arr["subject"] = htmlspecialchars($rs_case["case"]["caseDtl_title"]);

  $case_col_arr["date_open_case"] = date("d/m/Y",strtotime($rs_case["case"]["case_opened_datetime"]));

  $case_col_arr["product_type"] = $rs_case_list["prodType_name"];

  $case_col_arr["case_type"] = $rs_case_list["compType_name"];
  $case_col_arr["case_type"] .= ($rs_case_list["compTypeSub1_name"]!="")?" > ".$rs_case_list["compTypeSub1_name"]:"";
  $case_col_arr["case_type"] .= ($rs_case_list["compTypeSub2_name"]!="")?" > ".$rs_case_list["compTypeSub2_name"]:"";
  $case_col_arr["case_type"] .= ($rs_case_list["compType_other"]!="")?" ".$rs_case_list["compType_other"]:"";

  $case_col_arr["priority"] = $rs_case_list["casePrt_name"];
  $case_col_arr["channel"] = $rs_case_list["caseCh_name"];

  $case_col_arr["last_update"] = ($rs_case_list["last_update_datetime"]!="")?date("d/m/Y",strtotime($rs_case_list["last_update_datetime"])):date("d/m/Y",strtotime($rs_case_list["case_create_datetime"]));

  if($rs_case["case"]["applnt_status"]==1){
    $case_col_arr["applnt_name"] = 'ไม่ต้องการเปิดเผยรายชื่อ';
  }else{
    if($rs_case["case"]["applnt_type"]!=0){
      if($rs_case["case"]["applntOrg_name"]==""){
        $case_col_arr["applnt_name"] = 'ไม่ระบุบริษัทหรือองค์กร';
      }else{
        $case_col_arr["applnt_name"] = $rs_case["case"]["applntOrg_name"];
      }
    }else{
      if($rs_case["case"]["applnt_firstname"]=="" && $rs_case["case"]["applnt_lastname"]==""){
        $case_col_arr["applnt_name"] = '';
      }else{
        $case_col_arr["applnt_name"] = $rs_case["case"]["applnt_firstname"]." ".$rs_case["case"]["applnt_lastname"];
      }
    }

  }
  $case_col_arr["applnt_name"] = remove_lines(filter_var(trim($case_col_arr["complnt"]), FILTER_SANITIZE_STRING));
  $case_col_arr["applnt_address"] = trim($rs_case["case_feild"]["applnt_address"]);
  $case_col_arr["applnt_province"] = trim($provinceList[$rs_case["case_feild"]["applnt_prov_id"]]);
  $case_col_arr["applnt_zipcode"] = trim($rs_case["case_feild"]["applnt_zipcode"]);
  if($rs_case["case"]["applntOrg_country_id"]!=0){
    $case_col_arr["applnt_country"] = $_case->countryData($rs_case["case"]["applntOrg_country_id"],"name");
  }else{
    if($rs_case["case"]["applnt_country_id"]!=0){
      $case_col_arr["applnt_country"] = $_case->countryData($rs_case["case"]["applnt_country_id"],"name");
    }
  }
  $case_col_arr["applnt_contact_name"] = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
  $case_col_arr["applnt_contact_tel"] = $rs_case["case_feild"]["applnt_tel"];
  $case_col_arr["applnt_contact_mobile"] = $rs_case["case_feild"]["applnt_mobile"];
  $case_col_arr["applnt_contact_email"] = $rs_case["case_feild"]["applnt_email"];



  if($rs_case["case"]["complntOrg_name"]==""){
    if($rs_case["case"]["complnt_name"]==""){
      if($rs_case["case"]["complnt_firstname"]=="" && $rs_case["case"]["complnt_lastname"]==""){
        $case_col_arr["complnt"] = '';
      }else{
        $case_col_arr["complnt"] = $rs_case["case"]["complnt_firstname"]." ".$rs_case["case"]["complnt_lastname"];
      }
    }else{
      $case_col_arr["complnt"] = $rs_case["case"]["complnt_name"];
    }
  }else{
    $case_col_arr["complnt"] = $rs_case["case"]["complntOrg_name"];
  }

  $case_col_arr["complnt"] = remove_lines(trim(filter_var($case_col_arr["complnt"]), FILTER_SANITIZE_STRING));
  $case_col_arr["complnt_trade_number"] = $case_col_arr["complnt_trade_number"];

  if($rs_case["case"]["complnt_country_id"]!=0){
    $case_col_arr["complnt"] .= $_case->countryData($rs_case["case"]["complnt_country_id"],"name_th")!=""?$_case->countryData($rs_case["case"]["complnt_country_id"],"name_th"):$_case->countryData($rs_case["case"]["complnt_country_id"],"name");
  }else{
    if($rs_case["case"]["complntOrg_country_id"]!=0){
      $case_col_arr["complnt"] .= $_case->countryData($rs_case["case"]["complntOrg_country_id"],"name_th")!=""?$_case->countryData($rs_case["case"]["complntOrg_country_id"],"name_th"):$_case->countryData($rs_case["case"]["complntOrg_country_id"],"name");
    }
  }
  $case_col_arr["complnt_contact_name"] = $rs_case["case_feild"]["complnt_contact_name"];
  $case_col_arr["complnt_contact_tel"] = $rs_case["case_feild"]["complnt_contact_tel"];
  $case_col_arr["complnt_contact_email"] = $rs_case["case_feild"]["complnt_contact_email"];

  $statusCaseClose_type = "";
  $resultCaseClose = "";
  if($rs_case["case"]["case_status"]==0 || $rs_case["case"]["case_status"]==1){ //สถานะ Waiting, New
    $statusCase = $statusCase_txt[$rs_case["case"]["case_status"]];
  }else if($rs_case["case"]["case_status"]==2){ //สถานะ Pending
    //หาจำนวนวันทำการที่ใช้ไป

    $datatime_diff = $_case->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
    if($datatime_diff["days"]<0){
      $datatime_diff["days"] = 0;
    }
    if($datatime_diff["days"]>0 && $rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $rs_case["case"]["case_compType_duration"]){ //ถ้าเกิน $_case->day_overdue_case วัน
      $statusCase = $statusCase_txt[4];
    }else{ //ถ้าไม่เกิน $_case->day_overdue_case วัน
      $statusCase = $statusCase_txt[$rs_case["case"]["case_status"]];
    }
  }else if($rs_case["case"]["case_status"]==3){ //สถานะ Close
    //หาจำนวนวันทำการที่ใช้ไป
    $datatime_diff = $_case->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_close_datetime"])));

    if($datatime_diff["days"]<0){
      $datatime_diff["days"] = 0;
    }
    if($datatime_diff["days"]>0 && $rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $rs_case["case"]["case_compType_duration"]){ //ถ้าเกิน $_case->day_overdue_case วัน
      if($rs_case["case"]["case_disKPI_status"]==1){ //ถ้ามีการ Dis KPI
        $statusCase = $statusCase_txt[3].' ('.$statusCase_txt[4].')';
      }else{ //ถ้าไม่มีการ Dis KPI
        $statusCase = $statusCase_txt[3].' ('.$statusCase_txt[4].')';
      }
    }else{ //ถ้าไม่เกิน $_case->day_overdue_case วัน
      $statusCase = $statusCase_txt[$rs_case["case"]["case_status"]];
    }
  }
  $assign = "";
  $iasgn = 0;
  foreach($rs_case["case_assign"] as $case_assign){
    $assign .= $case_assign["emp_firstname"]." ".$case_assign["emp_lastname"];

    $iasgn++;
  }

  $case_col_arr["assign"] = $assign;

  $case_col_arr["office"] = $_case->office_data($rs_case["case"]["office_id"])["office_name_short"];

  if($rs_case["case"]["case_status"]!=0){

    $processTypeName = $_case->caseProcessTypeList("all",$_case->admin_section);

    $processOverDue = "";
    $w_prc = 0;
    foreach ($rs_case["case_process"] as $case_process) {

      $time_over = $case_process["process_over_datetime"];
      if($case_process["process_status"]==1){
        $time_compare = strtotime($case_process["process_complete_datetime"]);
      }else{
        $time_compare = time();
      }

      if($datatime_diff["days"]>0 && $time_compare>$time_over){
        $processOverDue_text = $case_process["process_over_note"];
        $processOverDue .= $processOverDue_text;
        $w_prc+=21;
      }
    }
    $statusCase = $statusCase.$processOverDue;
  }


  $case_col_arr["status"] = $statusCase;
  $case_col_arr["result_close_case"] = $rs_case["case"]["caseClose_title"];
  $case_col_arr["result_close_case"] .= ($rs_case["case"]["case_close_resultProcess"]!="")?" ".$rs_case["case"]["case_close_resultProcess"]:"";

  $case_col_arr["result_close_case"] = remove_lines(filter_var($case_col_arr["result_close_case"], FILTER_SANITIZE_STRING));

  if($_SESSION["admin"]["empSection"]==2){
    $case_col_arr["office"] = "นิติการ";
  }else{
    $case_col_arr["office"] = $_case->office_data($rs_case["case"]["office_id"])["office_name_short"];
  }


  array_push($case_arr,$case_col_arr);

}
$data_array = array('res_code'=>'00', 'case' => $case_arr);
mysqli_close($_case->dbConn);
echo json_encode($data_array);

?>
