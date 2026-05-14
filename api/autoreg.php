<?php
   include ("../config/config.php");
   header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"),1);
if(empty($post )){
  echo  json_encode('ข้อมูลไม่ถูกต้อง');
exit();
}else {
  
    $ck = check_id($conn,$post['member_cid'],$post['ssoid']);
    if($ck != false){
            $sql = "UPDATE Member SET ssoid='$post[ssoid]' WHERE member_id=$ck";
            if ($conn->query($sql) === TRUE) {
                $return =[
                    
                    "res_code"=> "00", "res_result"=> [
                    "ssoid"=> $post['ssoid'],
                    "member_id"=> $ck]
                    
            ];
            echo  json_encode($return);
            exit();
              } else {
                echo json_encode("Error updating record: " . $conn->error);
              }
    }else{
     
            $sql = "INSERT INTO Member (member_fname,member_lname,member_cid,member_email,member_phone,member_type,member_status,member_condition,member_creDate,ssoid) VALUES ('$post[member_fname]','$post[member_lname]','$post[member_cid]','$post[member_email]','$post[member_tel]','$post[member_type]',1,1,NOW(),'$post[ssoid]') ";
                // echo $sql;
                // exit()
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
               
                $return =[
                        "res_code"=> "00", "res_result"=> [
                        "ssoid"=> $post['ssoid'],
                        "member_id"=> $last_id]               
                ];
                echo  json_encode($return);
                exit();
              } else {
                echo json_encode("Error: " . $sql . "<br>" . $conn->error);
              }
    }


}

function check_id($conn,$cid,$ssoid){
    // include ("../config/config.php");
    $sql = "SELECT member_id,member_cid,ssoid FROM `Member` WHERE member_cid = '$cid'";
    // echo $sql ;
    // exit();
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        return $row['member_id'];
      }
    } else {
      return false;
    }
    $conn->close();
}
