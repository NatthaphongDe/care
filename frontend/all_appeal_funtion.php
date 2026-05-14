<?php
if(isset($_GET["method"]) && $_GET["method"]=="all_appeal"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = all_appeal($post);
    echo $response;
exit();

}
function all_appeal($post){
  include('config/config.php');
  if($post->lang == "2"){
    $hr_appeal_detail_ex = "Complaint topic";
    $hr_appeal_detail_ec = "Petitioner company";
  }else {
    $hr_appeal_detail_ex = "หัวข้อเรื่องร้องเรียน";
    $hr_appeal_detail_ec = "บริษัทที่ร้องเรียน";
  }
  $caseCh_arr = array();
  if($post->text == ""){
  $whereSearch = "";
}else {
  $whereSearch = " AND (nt.msgNotiApp_message LIKE '%".$post->text."%')";
}

if($post->status == 1){
      $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_status = '0' AND case_createBy_id = '".$_SESSION['member_id']."'";
      if($post->sort=="id"){
      $sort_col = "case_id";
      }
      $sql_waitting .= " ORDER BY $sort_col  $post->order ";
      $query_sum = $conn->query($sql_waitting);
      $num = $query_sum->num_rows;
      $sql_waitting .= " LIMIT $post->offset , $post->limit ";

      $query_waitting = $conn->query($sql_waitting);
      if($query_waitting->num_rows > 0){
        while ($re = $query_waitting->fetch_assoc()) {
          $date_time = $re['case_create_datetime'];
          $date_time_ex = explode(" ",$date_time);
          $date_waitting = $date_time_ex[0];
          $time_waitting = $date_time_ex[1];
          $date_ex = explode("-",$date_waitting);
          $time_ex = explode(":",$time_waitting);
          $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
          $time = $time_ex[0].".".$time_ex[1];

    $caseCh_col_arr["id"] = '<div class="panel-body">
        <div class="panel panel-default panel_waiting_appeal">
          <div class="list_waiting">
            <div class="row">
              <div class="col-md-1 col-sm-2 col-xs-3 list_waiting_icon">
                <img src="images/icon_zero.png" class="icon_zero_appeal">
              </div>
              <div class="col-md-10 col-sm-8 col-xs-9 list_waiting_detail">
                <span class="txt_app hr_appeal_detail_ex">'.$hr_appeal_detail_ex.' : <br></span><span class="txt_app hr_appeal_detail_er">'.$re['caseDtl_title'].'<br></span><span class="txt_app slot_appeal"> | </span>
                <span class="txt_app hr_appeal_detail_ec">'.$hr_appeal_detail_ec.' : <br></span><span class="txt_app">'.$re['complnt_name'].'</span></p>
                <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="waiting_date">'.$date.'</span>
                <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="waiting_time">'.$time.'</span>
              </div>
              <div class="col-md-1 col-sm-2 list_waiting_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id='.$re['case_id'].'"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
            </div>
        </div>
        </div>
    </div>';
    array_push($caseCh_arr,$caseCh_col_arr);
      }
    }
  }elseif ($post->status == 2) {
      $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_status in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."'";
      if($post->sort=="id"){
      $sort_col = "case_id";
      }
      $sql_waitting .= " ORDER BY $sort_col  $post->order ";
      $query_sum = $conn->query($sql_waitting);
      $num = $query_sum->num_rows;
      $sql_waitting .= " LIMIT $post->offset , $post->limit ";
      $query_waitting = $conn->query($sql_waitting);
      if($query_waitting->num_rows > 0){
        while ($re = $query_waitting->fetch_assoc()) {
          $date_time = $re['case_create_datetime'];
          $date_time_ex = explode(" ",$date_time);
          $date_waitting = $date_time_ex[0];
          $time_waitting = $date_time_ex[1];
          $date_ex = explode("-",$date_waitting);
          $time_ex = explode(":",$time_waitting);
          $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
          $time = $time_ex[0].".".$time_ex[1];

      $caseCh_col_arr["id"] = '<div class="panel-body">
        <div class="panel panel-default panel_pending_appeal">
          <div class="list_pending">
            <div class="row">
              <div class="col-md-1 col-sm-2 col-xs-3 list_pending_icon">';
                $sql_process = "SELECT
                p.process_type_id,
                pt.process_type_step
                FROM `Process` AS p
                LEFT JOIN `Process_Type` AS pt ON p.process_type_id=pt.process_type_id
                WHERE p.case_id = '".$re['case_id']."' ORDER BY p.process_id DESC";
                $query_process = $conn->query($sql_process);
                if($query_process->num_rows > 0){
                  $rs = $query_process->fetch_assoc();
                  if($rs['process_type_step'] == 1){
                    $caseCh_col_arr["id"] .= '<img src="images/icon_twf.png" class="icon_twf_appeal">';
                  }elseif ($rs['process_type_step'] == 2) {
                    $caseCh_col_arr["id"] .= '<img src="images/icon_ft.png" class="icon_twf_appeal">';
                  }elseif ($rs['process_type_step'] == 3) {
                    $caseCh_col_arr["id"] .= '<img src="images/icon_stf.png" class="icon_twf_appeal">';
                  }
                }else {
                  $caseCh_col_arr["id"] .= '<img src="images/icon_twf.png" class="icon_twf_appeal">';
                }
              $caseCh_col_arr["id"] .= '</div>
              <div class="col-md-10 col-sm-8 col-xs-9 list_pending_detail">
                <span class="txt_app hr_appeal_detail_ex">'.$hr_appeal_detail_ex.' : <br></span><span class="txt_app hr_appeal_detail_er">'.$re['caseDtl_title'].'<br></span><span class="txt_app slot_appeal"> | </span>
                <span class="txt_app hr_appeal_detail_ec">'.$hr_appeal_detail_ec.' : <br></span><span class="txt_app">'.$re['complnt_name'].'</span></p>
                <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="pending_date">'.$date.'</span>
                <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="pending_time">'.$time.'</span>
              </div>
              <div class="col-md-1 col-sm-2 list_pending_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id='.$re['case_id'].'"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
            </div>
        </div>
        </div>
    </div>';
    array_push($caseCh_arr,$caseCh_col_arr);
      }
    }

}elseif ($post->status == 3) {
      $sql_waitting = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_status = '3' AND case_createBy_id = '".$_SESSION['member_id']."'";
      if($post->sort=="id"){
      $sort_col = "case_id";
      }
      $sql_waitting .= " ORDER BY $sort_col  $post->order ";
      $query_sum = $conn->query($sql_waitting);
      $num = $query_sum->num_rows;
      $sql_waitting .= " LIMIT $post->offset , $post->limit ";

      $query_waitting = $conn->query($sql_waitting);
      if($query_waitting->num_rows > 0){
        while ($re = $query_waitting->fetch_assoc()) {
          $date_time = $re['case_create_datetime'];
          $date_time_ex = explode(" ",$date_time);
          $date_waitting = $date_time_ex[0];
          $time_waitting = $date_time_ex[1];
          $date_ex = explode("-",$date_waitting);
          $time_ex = explode(":",$time_waitting);
          $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
          $time = $time_ex[0].".".$time_ex[1];

      $caseCh_col_arr["id"] ='<div class="panel-body">
        <div class="panel panel-default panel_complete_appeal">
          <div class="list_complete">
            <div class="row">
              <div class="col-md-1 col-sm-2 col-xs-3 list_complete_icon">
                <img src="images/icon_oneh.png" class="icon_oneh_appeal">
              </div>
              <div class="col-md-10 col-sm-8 col-xs-9 list_complete_detail">
                <span class="txt_app hr_appeal_detail_ex">'.$hr_appeal_detail_ex.' : <br></span><span class="txt_app hr_appeal_detail_er">'.$re['caseDtl_title'].'<br></span><span class="txt_app slot_appeal"> | </span>
                <span class="txt_app hr_appeal_detail_ec">'.$hr_appeal_detail_ec.' : <br></span><span class="txt_app">'.$re['complnt_name'].'</span></p>
                <span class="icon_date"><img src="images/all_icon_DITP/icon_19.svg" style="width:15px;"></span><span class="complete_date">'.$date.'</span>
                <span class="icon_time"><img src="images/all_icon_DITP/icon_21.svg" style="width:20px;"></span><span class="complete_time">'.$time.'</span>
              </div>
              <div class="col-md-1 col-sm-2 list_complete_search"><span class="icon_search_detail"><a href="?page=appeal_detail&case_id='.$re['case_id'].'"><img src="images/all_icon_DITP/icon_26.svg" style="width:40px;"></a></span></div>
            </div>
        </div>
        </div>
    </div>';
    array_push($caseCh_arr,$caseCh_col_arr);
      }
    }
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}
 ?>
