<?php
include('../config/config.php');

$sql = "SELECT
ck.caseDtl_title,
ck.compType_id,
ck.complnt_name,
ck.applnt_name,
ck.caseDtl_derivation,
ck.caseDtl_damage_val,
ck.curren_id,
ck.case_id,
ck.caseDtl_complnt_need,
ck.case_close_resultProcess,
cr.curren_name,
ct.compType_name,
c.caseClose_id,
cs.caseClose_title,
ck.caseKnlg_id,
pt.prodType_name
FROM `Case_Knowledge` AS ck
LEFT JOIN `Complaint_Type` AS ct ON ck.compType_id = ct.compType_id
LEFT JOIN `Currency` AS cr ON ck.curren_id = ck.curren_id
LEFT JOIN `Product_Type` AS pt ON ck.prodType_id = pt.prodType_id
LEFT JOIN `Case` AS c ON ck.case_id = c.case_id
LEFT JOIN `Case_Close` AS cs ON c.caseClose_id = cs.caseClose_id
WHERE ck.caseKnlg_id = '".$_GET['Knlg_id']."' AND ck.caseKnlg_enable = 1 AND ck.caseKnlg_status = 1";
$query = $conn->query($sql);
if($query->num_rows > 0){
  while ($res = $query->fetch_assoc()) {
    $Knlg_id = array(
      "Knlg_id"=>$res['caseKnlg_id'],
      "compType_name"=>$res['compType_name'],
      "complnt_name"=>$res['complnt_name'],
      "applnt_name"=>$res['applnt_name'],
      "prodType_name"=>$res['prodType_name'],
      "caseDtl_derivation"=>$res['caseDtl_derivation'],
      "caseDtl_damage_val"=>$res['caseDtl_damage_val'],
      "caseDtl_complnt_need"=>$res['caseDtl_complnt_need']
    );
  }
   $Knlg_id = json_encode($Knlg_id);
}else {
  print "ไม่พบข้อมูล";
}
print_r($Knlg_id);
return $Knlg_id;
?>
