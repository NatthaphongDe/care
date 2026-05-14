<?php
if(isset($_GET["method"]) && $_GET["method"]=="msg_list"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = msg_list($post);
    echo $response;
exit();

}
function msg_list($post){
  include('config/config.php');
  $caseCh_arr = array();
  if($post->text == ""){
  $whereSearch = "";
  }else {
    $whereSearch = " AND (msgBox_message LIKE '%".$post->text."%')";
  }
  $case_id_arr = array();
  $sql = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_createBy_id = '".$_SESSION['member_id']."'";
  $query = $conn->query($sql);
  while ($re = $query->fetch_assoc()) {
    $case_id_arr['case_id'] = $re['case_id'];
    array_push($case_id_arr,$case_id_arr['case_id']);
  }
  $case = "";
  $i =0;
  foreach ($case_id_arr as $value) {
    if($i == 0){
      $case =  $value;
    }else {
      $case .=  ",".$value;
    }
    $i++;
  }
  if($case == ""){
    $case = "''";
  }

  $sql_box = "SELECT * FROM `Message_Box`
  WHERE 1 $whereSearch AND ((case_id IN ($case) AND sender_type = 2)
  OR (sender_type = 1 AND sender_id = '".$_SESSION['member_id']."')
  OR (sender_type = 0 AND sender_id = '".$_SESSION['member_id']."')) AND msgBox_status = 0 AND msgBoxRef_id = 0";
  if($post->sort=="id"){
  $sort_col = "msgBox_id";
  }
  $sql_box .= " ORDER BY $sort_col  $post->order ";
  $query_sum = $conn->query($sql_box);
  $num = $query_sum->num_rows;
  $sql_box .= " LIMIT $post->offset , $post->limit ";
  $query = $conn->query($sql_box);
  if($query->num_rows > 0){
    while ($rs = $query->fetch_assoc()) {
      $date_time = $rs['msgBox_datetime'];
      $date_time_ex = explode(" ",$date_time);
      $date_waitting = $date_time_ex[0];
      $time_waitting = $date_time_ex[1];
      $date_ex = explode("-",$date_waitting);
      $time_ex = explode(":",$time_waitting);
      $date = $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
      $time = $time_ex[0].".".$time_ex[1];

      $caseCh_col_arr["id"] = '
      <div class="loop_bell">
      <div class="row div_letter_detail">
        <div class="col-md-1 col-sm-1 col-xs-1" style="width:4%;padding-left: 0px;padding-right: 0px;">';

          $sql_circle = "SELECT * FROM `Message_Box_Log` WHERE msgBox_id = '".$rs['msgBox_id']."' AND msgBox_read_status = 0 AND recipient_type = 1";
          $query_circle = $conn->query($sql_circle);
          if($query_circle->num_rows > 0){
            if($rs['sender_type'] != 0){
          $caseCh_col_arr["id"] .='<i class="fa fa-circle" id="fa_circle_'.$rs['msgBox_id'].'" aria-hidden="true" style="float:right; color:#F44336;"></i>';
          }
        }
        $caseCh_col_arr["id"] .='</div>
        <div class="col-md-9 col-sm-9 col-xs-11 div_detail_letter">';
          if($rs['sender_type'] != 0){
        $caseCh_col_arr["id"] .='<a href="?page=reply_letter&msgBox_id='.$rs['msgBox_id'].'" onclick="read_mesBox('.$rs['msgBox_id'].')">
          <div class="txt_letter">'.$rs['msgBox_message'].'</div>
            </a>';
          }else {
            if($post->lang == "2"){
              $msgBox_message = $rs['msgBox_message_en'];
            }else {
              $msgBox_message = $rs['msgBox_message'];
            }
            $caseCh_col_arr["id"] .='<div class="txt_letter">'.$msgBox_message.'</div>';
          }
        $caseCh_col_arr["id"] .='<div class="date_time_letter">
            <span class="icon_date"><img src="images/icon_date.png"></span><span class="waiting_date">'.$date.'</span>
            <span class="icon_time"><img src="images/icon_time.png"></span><span class="waiting_time">'.$time.'</span>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 div_icon_letter">';
          if($rs['sender_type'] != 0){
        $caseCh_col_arr["id"] .='<a href="?page=reply_letter&msgBox_id='.$rs['msgBox_id'].'" onclick="read_mesBox('.$rs['msgBox_id'].');"><span class="search_detail_letter"><img src="images/icon_search_detail.png"></span></a>';
           }
        $caseCh_col_arr["id"] .='<span class="del_detail_letter"><img src="images/icon_delete.png" onclick="del_msgBox('.$rs['msgBox_id'].')"></span>
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
