<?php
if(isset($_GET["method"]) && $_GET["method"]=="noti_bell"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = noti_bell($post);
    echo $response;
exit();

}
function noti_bell($post){
  include('config/config.php');
  $caseCh_arr = array();
  if($post->text == ""){
  $whereSearch = "";
}else {
  $whereSearch = " AND (nt.msgNotiApp_message LIKE '%".$post->text."%' OR nt.msgNotiApp_message_en LIKE '%".$post->text."%')";
}
  $sql = "SELECT nt.msgNotiApp_datetime,
  nt.case_id,
  c.case_status,
  nt.msgNotiApp_id,
  c.caseDtl_title,
  nt.msgNoti_status,
  nt.member_id,
  nt.msgNotiApp_message,
  nt.msgNotiApp_message_en,
  nt.msgNotiApp_read_status,
  nt.msgNotiApp_step
  FROM `Message_Noti_App` AS nt
  LEFT JOIN `Case` AS c ON nt.case_id = c.case_id
  WHERE 1 $whereSearch AND nt.msgNoti_status = 0 AND nt.member_id = '".$_SESSION['member_id']."'";
  if($post->sort=="id"){
  $sort_col = "nt.msgNotiApp_id";
  }
  $sql .= " ORDER BY $sort_col  $post->order ";
  $query_sum = $conn->query($sql);
  $num = $query_sum->num_rows;
  $sql .= " LIMIT $post->offset , $post->limit ";
  $query = $conn->query($sql);
  if($query->num_rows > 0){
    while ($re = $query->fetch_assoc()) {
      $date_time = $re['msgNotiApp_datetime'];
      $date_time_ex = explode(" ",$date_time);
      $date_ = $date_time_ex[0];
      $time_ = $date_time_ex[1];
      $date_ex = explode("-",$date_);
      $time_ex = explode(":",$time_);
      $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
      $time = $time_ex[0].".".$time_ex[1];
      
      if($post->lang == "2"){
        $msgNotiApp_message = $re['msgNotiApp_message_en'];
      }else {
        $msgNotiApp_message = $re['msgNotiApp_message'];
      }

      $caseCh_col_arr["id"] = '
      <div class="loop_bell">
      <div class="row div_bell_detail">
        <div class="col-md-1 col-sm-1 col-xs-1" style="width:4%;padding-left: 0px;padding-right: 0px;">';
          if($re['msgNotiApp_read_status'] == 0){
          $caseCh_col_arr["id"] .='<i class="fa fa-circle" id="fa_circle_'.$re['msgNotiApp_id'].'" aria-hidden="true" style="float:right; color:#F44336;"></i>';
        }
        $caseCh_col_arr["id"] .='</div>
        <div class="col-md-9 col-sm-9 col-xs-11 div_detail_letter">
          <a href="?page=appeal_detail&case_id='.$re['case_id'].'" onclick="hide_icon('.$re['msgNotiApp_id'].');">
          <div class="txt_bell">'.$msgNotiApp_message.'</div>
          </a>
          <div class="date_time_bell">
            <span class="icon_date"><img src="images/icon_date.png"></span><span class="bell_date">'.$date.'</span>
            <span class="icon_time"><img src="images/icon_time.png"></span><span class="bell_time">'.$time.'</span>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 div_icon_bell">
          <a href="?page=appeal_detail&case_id='.$re['case_id'].'" onclick="hide_icon('.$re['msgNotiApp_id'].')"><span class="search_detail_letter"><img src="images/icon_search_detail.png"></span></a>
          <span class="del_detail_letter"><img src="images/icon_delete.png" onclick="del_msgnoti('.$re['msgNotiApp_id'].')"></span>
        </div>
      </div>
    </div>';
    array_push($caseCh_arr,$caseCh_col_arr);
    }
  }
  $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  return json_encode($data_array);
}
 ?>
