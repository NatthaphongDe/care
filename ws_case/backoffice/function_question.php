<?php
session_start();
switch ($_GET['method']) {
  case "question":
    echo question();
  break;
}

function question(){
include('../config/config.php');
$date_time = date("Y-m-d H:i:s");
$i = 1;
foreach ($_POST['hid_questionID'] as $questionID) {
  $sql_chk = "SELECT * FROM `Feedback_Backend_Question` WHERE feedback_q_id = '".$questionID."' ";
  $query_chk = $conn->query($sql_chk);
  $res = $query_chk->fetch_assoc();
  if($res['feedback_q_chk'] == '1'){
    if($_POST['answers_question_'.$questionID] == ""){
      ?>
      <script>
      parent.iziToast_func.alert('กรุณาแสดงความพึงพอใจในข้อที่ <?=$i?>. <?=$res['feedback_q_title']?>');
      </script>
      <?php
      exit();
    }
  }
  $i++;
}
$sql_list = "INSERT INTO `Feedback_Backend_List`(`feedback_list_datetime`, `feedback_list_by`) VALUES ('".$date_time."','".$_SESSION["admin"]["empId"]."')";
$query_list = $conn->query($sql_list);
$last = $conn->insert_id;

  foreach ($_POST['hid_questionID'] as $questionID) {
    if($_POST['answers_question_'.$questionID] != ""){
      $sql = "INSERT INTO `Feedback_Backend_Answers`(`feedback_q_id`, `feedback_a_result`,`feedback_list_id`) VALUES ('".$questionID."','".$_POST['answers_question_'.$questionID]."','".$last."')";
      $query = $conn->query($sql);
    }
  }
  ?>
  <script>
  parent.iziToast_func.success('ขอบคุณสำหรับการแสดงการแบบสอบถาม',function(){
    top.window.location.reload();
  });
  </script>
  <?php
exit();
}
?>
