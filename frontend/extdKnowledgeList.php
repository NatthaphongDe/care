<?php
include('../config/config.php');

$Knlg_id_arr = array();
$sql = "SELECT * FROM `Case_Knowledge` WHERE caseKnlg_enable = 1 AND caseKnlg_status = 1";
$query = $conn->query($sql);
if($query->num_rows > 0){
  while ($res = $query->fetch_assoc()) {
    $caseKnlg_id = $res['caseKnlg_id'];
    $Knlg_id = array("Knlg_id"=>$caseKnlg_id);
    array_push($Knlg_id_arr,$Knlg_id);
  }
  $Knlg_id = json_encode($Knlg_id_arr);
}else {
  echo "ไม่พบข้อมูล";
}
print_r($Knlg_id);
return $Knlg_id;
?>
