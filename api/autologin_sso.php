
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
    body{
        
        background: rgb(5,113,96);
background: linear-gradient(90deg, rgba(5,113,96,1) 0%, rgba(50,144,107,1) 50%, rgba(127,172,106,1) 100%);
    }
    .wp{
        background: #ffffff0d;
    width: 50%;
    height: 50%;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    /* padding: 100px;; */
    }
    .text-al{
        /* background: #FFF; */
        width: 90%;
        height: auto;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        /* margin: 20px; */
        text-align: center;
    }
    .sub_wp{
        width: 100%;
        height: 100%;
    }
 
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.btn-warning {
    color: #fff;
    background-color: #f0ad4e;
    border-color: #eea236;
    padding-left: 20px;padding-right: 20px;
}
    </style>
    		<a class="btn btn-warning "href="https://sso.ditp.go.th/sso/index.php/auth?
        response_type=token&
        client_id=ssocareid&redirect_uri=<?=htmlentities(urlencode('https://care.ditp.go.th/api/autologin_sso.php'))?>&state=ugfjdfksg1">
        เข้าสู่ระบบ
        </a>
    <div class="wp">
        
    <!-- <a class="btn btn-warning "href="https://sso.ditp.go.th/sso/index.php/auth?
        response_type=token&
        client_id=ssocareid&redirect_uri=<?=htmlentities(urlencode('https://care.ditp.go.th/api/autologin_sso.php'))?>&state=ugfjdfksg1">
        เข้าสู่ระบบ
        </a> -->
<div class="sub_wp">
<div class="text-al">

<?php
   include ("../config/config.php");
    //    header('Content-Type: application/json');
        $code = $_GET['code'];
        if(isset($code)){

   
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://sso.ditp.go.th/sso/api/getinfo",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "client_id: ssocareid",
            "code: Bearer $code",
            "Authorization: c3NvY2FyZWlkLWUyYWY2OGdiZzEtMTcwODA1NTU4Nw=="
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        $data = json_decode($response,true);
        //print_r($data);
        $post = $data['res_result'];
        $ck = check_id($conn,$data['res_result']['naturalId'],$data['res_result']['ssoid']);
        if($ck != 0){
            $sql = "UPDATE Member SET ssoid='$post[ssoid]' WHERE member_id=$ck";
            if ($conn->query($sql) === TRUE) {
            $_SESSION["member"]["member_id"] = $ck;
            $_SESSION["member"]["member_type"] = $post['type'];
            $_SESSION["member_id"] = $ck;
            $_SESSION["member_type"] = $post['type'];
             header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
            exit();
              } else {
                echo ("Error updating record: " . $conn->error);
              }
        }else{
            // $post['type'];
        
        
            if($post['type'] == 1 || $post['type'] == 2){
            $sql = "INSERT INTO Member (member_fname,member_lname,member_cid,member_email,member_phone,member_type,member_status,member_condition,member_creDate,ssoid,member_address,member_postcode) VALUES ('".$post['member']['name']."','','".$post['naturalId']."','".$post['sub_member'][0]['email']."','".$post['sub_member'][0]['tel']."','".$post['type']."',1,1,NOW(),'".$post['ssoid']."','".$post['address']['address']." ".$post['address']['subdistrict']." ".$post['address']['district']." ".$post['address']['province']." ".$post['address']['postcode']."','".$post['address']['postcode']."') ";

             }else{
                $sql = "INSERT INTO Member (member_fname,member_lname,member_cid,member_email,member_phone,member_type,member_status,member_condition,member_creDate,ssoid) VALUES ('".$post['member']['name']."','".$post['member']['lastname']."','".$post['naturalId']."','".$post['member']['email']."','".$post['member']['tel']."','".$post['type']."',1,1, NOW(),'".$post['ssoid']."') ";
               
            }
        
            
            // var_dump($post[address][address]);
            // print_r($sql);
            //     exit();
            if ($conn->query($sql) === TRUE) {
                $last_id = $conn->insert_id;
                if($post['type'] == 1 || $post['type'] == 2){
      
                    $sql_com = "INSERT INTO Member_comp (member_id,member_comp_name,member_comp_branch,member_comp_taxid,member_comp_address,member_comp_postcode,member_comp_phone,member_comp_type) VALUES ('$last_id','".$post['member']['name']."','','".$post['naturalId']."','".$post['address']['address']." ".$post['address']['subdistrict']." ".$post['address']['district']." ".$post['address']['province']." ".$post['address']['postcode']."','".$post['address']['postcode']."','".$post['sub_member'][0]['tel']."','0',) ";   
                    $conn->query($sql);
                }
                $_SESSION["member"]["member_id"] = $ck;
                $_SESSION["member"]["member_type"] = $post['type'];

                $_SESSION["member_id"] = $ck;
                $_SESSION["member_type"] = $post['type'];
            
               header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
                exit();
              } else {
                echo ("Error: " . $sql . "<br>" . $conn->error);
              }
        };
        }



    }
    function check_id($conn,$cid,$ssoid){
        // include ("../config/config.php");
        $sql = "SELECT member_id,member_cid,ssoid FROM `Member` WHERE  member_cid = '$cid'";
        // echo $sql ;
        // exit();
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            return $row['member_id'];
          }
        } else {
          return 0;
        }
        $conn->close();
    }
?>

</div>
</div>


    </div>
  
</body>
</html>

