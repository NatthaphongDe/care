<?php

$post = json_decode(file_get_contents("php://input"),1);
if(empty($post )){
  
echo  json_encode('ข้อมูลไม่ถูกต้อง');
exit();
}else {




}

function check_id($cid,$ssoid){
    $sql = "";
}

?>