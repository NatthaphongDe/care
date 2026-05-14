<!DOCTYPE html>
<html lang="en">

<head>
    <?php header('Access-Control-Allow-Origin: *', 'Access-Control-Allow-Headers:*', 'Access-Control-Allow-Methods:*'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSO LOGIN</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <style>
        body {

            background: rgb(5, 113, 96);
            background: linear-gradient(90deg, rgba(5, 113, 96, 1) 0%, rgba(50, 144, 107, 1) 50%, rgba(127, 172, 106, 1) 100%);
        }

        .wp {
            background: #ffffff0d;
            width: 50%;
            height: 50%;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            /* padding: 100px;; */
        }

        .text-al {
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

        .sub_wp {
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
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>

    <div class="wp">

        <div class="sub_wp">
            <div class="text-al">

                <?php
                include("../config/config.php");
                include('../frontend/lib/PHPMailer-5.2.5/class.phpmailer.php');

                // include("../php-jwt-master/src/JWT.php");
                // use \Firebase\JWT\JWT;
                // $token = JWT::decode($_GET['code'], 'ssocareid', array('HS256'));
                // echo $token;
                // exit();
                $code = $_GET['code'];
                
                $_SESSION['code'] = $code;
                $api_key = md5(uniqid(rand(), true));
                
                if (isset($code)) 
                {
                    $curl = curl_init();


                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://sso.ditp.go.th/sso/api/getinfo",
                        //   CURLOPT_SSL_VERIFYHOST => 0,
                        //   CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "client_id: ssocareid",
                            "code: Bearer " . $code,
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);



                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $data = json_decode($response, true);
                        // echo '<pre>';
                        // print_r($data);
                        // echo '</pre>';
                        // exit();
                        $country_id = '';
                        $title = '';
                        $title_en = '';
                        $fname = "";
                        $fname_en = "";
                        $lname = "";
                        $lname_en = "";
                        $member_cid = "";
                        $member_address = "";
                        $member_email = "";
                        $member_phone = "";
                        $insertType = "";
                        $postcode = "";
                        $ssoid = "";
                        $member_id = "";
                        $member_comp_name = "";
                        $member_comp_name_en = "";
                        $member_comp_taxid = "";
                        $member_comp_phone = "";
                        $member_comp_address = "";
                        $postcode_co = "";
                        $prov_name = '';
                        $prov_name_en = '';
                        $member_sex = '';
                        $url_href = '';
                        $tel_code = '';
                        $tel_country_code = '';
                        $tel_icon_country = '';
                        if ($data['res_code'] == "00") {
                            $data = $data['res_result'];
                            
                            
                                // echo $data['type'];
                                // exit();
                                if ($data['type'] == 1 || $data['type'] == 6) {
                                    //นิติไทย
                                    $title = $data['sub_member']['titleTh'];
                                    $title_en = $data['sub_member']['titleEn'];
                                    $fname = $data['sub_member']['nameTh'];
                                    $fname_en = $data['sub_member']['nameEn'];
                                    $lname =  $data['sub_member']['lastnameTh'];
                                    $lname_en =  $data['sub_member']['lastnameEn'];
                                    $sub_member_cid =  $data['sub_member']['cid'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['contact']['address'] . " " . $data['contact']['subdistrict'] . " " . $data['contact']['district'] . " " . $data['contact']['province'];
                                    $member_email = $data['sub_member']['email'];
                                    $member_phone = $data['sub_member']['tel'];
                                    $tel_code = $data['sub_member']['tel_code'];
                                    $tel_country_code = $data['sub_member']['tel_country_code'];
                                    $tel_icon_country = $data['sub_member']['tel_icon_country'];
                                    $postcode = $data['contact']['postcode'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 1; //0 คนทั่วไป 1 นิติ
                                    $member_id = "";
                                    $member_comp_name =  $data['company']['nameTh'];
                                    $member_comp_name_en =  $data['company']['nameEn'];
                                    $member_comp_taxid = $data['naturalId'];
                                    $member_comp_phone =  $data['tel'];
                                    $member_comp_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province']. " " . $data['addressTh']['postcode'];
                                    $postcode_co = $data['addressTh']['postcode'];
                                    $country_id = '162';
                                    $prov_name = $data['addressTh']['province'];
                                    $prov_name_en = $data['addressEn']['province'];

                                    $naturalId = '';
                                } else
                                if ($data['type'] == 2) {
                                    //นิติต่างชาติ
                                    $title_en = $data['sub_member']['titleEn'];
                                    $fname = $data['sub_member']['nameEn'];
                                    $lname =  $data['sub_member']['lastnameEn'];
                                    $sub_member_cid =  $data['naturalId'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['contact']['address'] . " " . $data['contact']['subdistrict'] . " " . $data['contact']['district'] . " " . $data['contact']['province']. " " . $data['contact']['postcode'];
                                    $postcode = $data['contact']['postcode'];
                                    $member_email = $data['sub_member']['email'];
                                    $member_phone = $data['sub_member']['tel'];
                                    $tel_code = $data['sub_member']['tel_code'];
                                    $tel_country_code = $data['sub_member']['tel_country_code'];
                                    $tel_icon_country = $data['sub_member']['tel_icon_country'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 1; //0 คนทั่วไป 1 นิติ
                                    $member_id = "";
                                    $member_comp_name =  $data['company']['nameEn'];
                                    $member_comp_taxid = $data['naturalId'];
                                    $member_comp_phone =  $data['sub_member']['tel'];
                                    $member_comp_address = $data['addressEn']['address'] . " " . $data['addressEn']['subdistrict'] . " " . $data['addressEn']['district'] . " " . $data['addressEn']['province']. " " . $data['addressEn']['postcode'];
                                    $postcode_co = $data['addressEn']['postcode'];
                                } else
                                if ($data['type'] == 3) {
                                    //ธรรมดาไทย
                                    $title = $data['member']['titleTh'];
                                    $title_en = $data['member']['titleEn'];
                                    $fname = $data['member']['nameTh'];
                                    $fname_en = $data['member']['nameEn'];
                                    $lname =  $data['member']['lastnameTh'];
                                    $lname_en =  $data['member']['lastnameEn'];
                                    $sub_member_cid =  $data['naturalId'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province']. " " . $data['addressTh']['postcode'];
                                    $member_email = $data['member']['email'];
                                    $member_phone = $data['member']['tel'];
                                    $tel_code = $data['member']['tel_code'];
                                    $tel_country_code = $data['member']['tel_country_code'];
                                    $tel_icon_country = $data['member']['tel_icon_country'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressTh']['postcode'];
                                    $country_id = '162';

                                } else
                                if ($data['type'] == 4) {
                                    //ธรรมดาต่างชาติ
                                    $title_en = $data['sub_member']['titleEn'];
                                    $fname = $data['member']['nameEn'];
                                    $lname =  $data['member']['lastnameEn'];
                                    $sub_member_cid =  $data['naturalId'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['address']['address'] . " " . $data['country'];
                                    $member_email = $data['member']['email'];
                                    $member_phone = $data['member']['tel'];
                                    $tel_code = $data['member']['tel_code'];
                                    $tel_country_code = $data['member']['tel_country_code'];
                                    $tel_icon_country = $data['member']['tel_icon_country'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressEn']['postcode'];

                                } else {
                                    //อื่นๆ
                                    $title = $data['member']['titleTh'];
                                    $fname = $data['member']['nameTh'];
                                    $lname =  $data['member']['lastnameTh'];
                                    $sub_member_cid =  $data['naturalId'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province']." ".$data['addressTh']['postcode'];
                                    $member_email = $data['email'];
                                    $member_phone = $data['tel'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressTh']['postcode'];
                                    // echo  $data['email'];
                                }

                                // echo $member_email;
                                // exit;
                                // $member_cid = '0575558002722';
                                // $data['type'] = 1;
                                $ck = check_id_member($conn, $member_cid, $data['type']);
                                // echo $ck['member_id'];
                                // exit;
                                // echo $code;
                                // exit;
                                if ($ck['member_id'] != 0)  
                                {
                                    if($ck['status_update_sso'] == 1){

                                        $sql_update_tel = "UPDATE Member SET 
                                        tel_code='$tel_code',
                                        tel_country_code='$tel_country_code',
                                        tel_icon_country='$tel_icon_country'
                                        WHERE member_id='".$ck['member_id']."' "; 
                                        $conn->query($sql_update_tel);
                                        // echo 'dd';
                                        // exit;
                                        $_SESSION["member"]["member_id"] = $data;
                                        $_SESSION["member"]["member_type"] = $data['type'];
                                        $_SESSION["member_id"] = $ck['member_id'];
                                        $_SESSION["member_type"] = $data['type']==1||$data['type']==2?1:0;
                                        $ip = get_client_ip();
                                        $sql_log = "INSERT INTO Log_Login_Member (member_id,ssoid,ip) VALUES ('".$ck['member_id']."','$data[ssoid]','$ip') ";
                                        $conn->query($sql_log);

                                        // if($data['type'] ==1 || $data['type'] == 2){
                                        //     // echo check_data_comp($conn, $ck['member_id']);
                                        //     // exit();
                                        //     if( check_data_comp($conn, $ck['member_id']) == 1){
                                        //         $url_href = 'edit';
                                        //         // echo 'dd';
                                        //         // exit;
                                        //     }
                                        // }
                                        if( check_data_member($conn, $ck['member_id'], $data['type']) == 1){
                                            $url_href = 'edit';
                                            // echo 'xx';
                                            // exit;
                                        }
                                        // echo $url_href;
                                        // exit();
                                        if(isset($_SESSION["appeal_detail"])) {
                                            $url_href = 'appeal_detail';
                                            $case_id = $_SESSION["case_id"];
                                            $case_user_id = $_SESSION["case_user_id"];
                                            // $case_member_id = md5($_SESSION["member_id"]);
                                        }
                                        // print_r($_SESSION);
                                        // echo $url_href;
                                        // exit();
                                        if($url_href == 'edit'){
                                            header( "location: https://care.ditp.go.th/frontend/index.php?page=profile&lang=1&edit=true" );
                                        } else if($url_href == 'appeal_detail') {
                                            session_start();
                                            unset($_SESSION['appeal_detail']);
                                            unset($_SESSION['case_id']);
                                            unset($_SESSION['case_user_id']);
                                            if($case_user_id == md5($_SESSION["member_id"])) {
                                                $_SESSION["check_user_id"] = 'true';
                                            } else {
                                                $_SESSION["check_user_id"] = 'false';
                                            }
                                            header( "location: https://care.ditp.go.th/frontend/index.php?page=appeal_detail&case_id=".$case_id."&user_id=".$case_user_id );
                                        }else{
                                            header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
                                        }
                                        exit();
                                    }
                                    if($title == 'นาย' || $title_en == 'Mr.'){
                                        $member_sex = 1;
                                    }else{
                                        $member_sex = 2;
                                    }
                                    $sql = "UPDATE Member SET 
                                    title='$title' ,
                                    title_en='$title_en' ,
                                    member_fname='$fname' ,
                                    member_fname_en='$fname_en' ,
                                    member_lname='$lname' ,
                                    member_lname_en='$lname_en' ,
                                    member_cid= '$sub_member_cid' ,
                                    member_address= '$member_address' ,
                                    member_email= '$member_email' ,
                                    member_phone= '$member_phone' ,
                                    member_postcode= '$postcode' ,
                                    country_id= '$country_id' ,
                                    member_sex= '$member_sex',
                                    member_type= '$insertType',
                                    ssoid= '$ssoid',
                                    status_update_sso= 1,
                                    tel_code='$tel_code',
                                    tel_country_code='$tel_country_code',
                                    tel_icon_country='$tel_icon_country'
                                    WHERE member_id='".$ck['member_id']."' ";

                                    if ($conn->query($sql) === TRUE) {
                                        if($data['type'] ==1 || $data['type'] == 2){
                                            $chk_comp = check_comp($conn, $ck['member_id']);
                                            if($chk_comp == 1){
                                                $sql_update_com = "UPDATE Member_comp SET 
                                                member_comp_name='$member_comp_name',
                                                member_comp_name_en='$member_comp_name_en',
                                                member_comp_taxid='$member_comp_taxid',
                                                member_comp_address='$member_comp_address',
                                                member_comp_postcode='$postcode_co',
                                                member_comp_phone='$member_comp_phone',
                                                prov_name='$prov_name',
                                                prov_name_en='$prov_name_en'
                                                WHERE member_id='".$ck['member_id']."' "; 
                                                $conn->query($sql_update_com);
                                            }else{
                                                $sql_com = "INSERT INTO Member_comp 
                                                (member_id,member_comp_name,member_comp_taxid,member_comp_address,member_comp_postcode,member_comp_phone,member_comp_type,country_id,prov_name,prov_name_en,member_comp_name_en)
                                                VALUES 
                                                ('".$ck['member_id']."','$member_comp_name','$member_comp_taxid','$member_comp_address','$postcode_co','$member_comp_phone','1','$country_id', '$prov_name', '$prov_name_en','$member_comp_name_en') ";
                                                $conn->query($sql_com);
                                            }
                                        }
                                        
                                        $_SESSION["member"]["member_id"] = $data;
                                        $_SESSION["member"]["member_type"] = $data['type'];
                                        $_SESSION["member_id"] = $ck['member_id'];
                                        $_SESSION["member_type"] = $data['type']==1||$data['type']==2?1:0;
                                        $ip = get_client_ip();
                                        $sql_log = "INSERT INTO Log_Login_Member (member_id,ssoid,ip) VALUES ('".$ck['member_id']."','$data[ssoid]','$ip') ";
                                        $conn->query($sql_log);
                                        
                                        if($data['type'] ==1 || $data['type'] == 2 || $data['type'] == 6){
                                            if( check_data_comp($conn, $ck['member_id']) == 1){
                                                $url_href = 'edit';
                                            }
                                        }
                                        if( check_data_member($conn, $ck['member_id'], $data['type']) == 1){
                                            $url_href = 'edit';
                                        }
                                        if($url_href == 'edit'){
                                            header( "location: https://care.ditp.go.th/frontend/index.php?page=profile&lang=1&edit=true" );
                                        }else{
                                            header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
                                        }
                                        exit();

                                        exit();
                                    } else {
                                        echo ("Error updating record: " . $conn->error);
                                    }
                                } else{
                                   
                                $sql = "INSERT INTO Member 
                                (
                                    title,
                                    title_en,
                                    member_fname,
                                    member_fname_en,
                                    member_lname,
                                    member_lname_en,
                                    member_cid,
                                    member_address,
                                    member_email,
                                    member_phone,
                                    member_type,
                                    member_status,
                                    member_condition,
                                    member_creDate,
                                    ssoid,
                                    member_postcode,
                                    country_id,
                                    member_sex,
                                    status_update_sso,
                                    tel_code,
                                    tel_country_code,
                                    tel_icon_country
                                ) 
                                VALUES 
                                (
                                    '$title',
                                    '$title_en',
                                    '$fname',
                                    '$fname_en',
                                    '$lname',
                                    '$lname_en',
                                    '$sub_member_cid',
                                    '$member_address',
                                    '$member_email',
                                    '$member_phone',
                                    '$insertType',
                                    1,
                                    1,
                                    NOW(),
                                    '$ssoid',
                                    '$postcode',
                                    '$country_id',
                                    '$member_sex', 
                                    1,
                                    '$tel_code',
                                    '$tel_country_code',
                                    '$tel_icon_country'
                                ) ";
                                    
                                
                               
                                
                                $to_email = $member_email;
                                $to_name = "เจ้าหน้าที่ของ DITP Care";
                                $from_email = "ditpcare@ditp.go.th";
                                $from_name = "DITP Care";
                                $subject = "การสมัครสมาชิก DITP Care เสร็จสิ้น";
                                $message = " <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                                            <div class=\"header\" style=\"width:auto\">
                                            <img src=\"http://" . $_SERVER["HTTP_HOST"] . "/img/header_email.png\" srtlw=\"width:100%; height:auto;\" />
                                            <div>
                                            <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                            <div style=\"padding: 20px;color:#000;\">
                                            <br>
                                            <br>
                                            " . $_SERVER['HTTP_HOST'] . " ได้รับคำขอร้องจากเว็บไซต์ที่คุณสมัครสมาชิก
                                            <br>
                                            คุณได้สมัครสมาชิก DITP Care เรียบร้อยแล้ว
                                            <br>
                                            <br>
                                            <br>
                                            หากคุณไม่ได้ดำเนินการร้องขอนี้ โปรดอย่าสนใจอีเมลฉบับนี้ มั่นใจได้ว่าบัญชีสมาชิกของคุณจะปลอดภัยได้กับเรา
                                            <br>
                                            </div>
                                            <hr style=\"border-color:#fefefe; margin:0px;\" />
                                                <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                                ขอบคุณ.<br />
                                                ทีมงาน <a href=\"http://" . $_SERVER["HTTP_HOST"] . "\" target=\"blank\">" . $_SERVER["HTTP_HOST"] . "</a>
                                                </div>
                                            </div>";

                                $output = "";
                                $body = $message;
                                
                                try {
                                    $mail = new PHPMailer(true);
                                    $mail->CharSet = "utf-8";
                                    $mail->IsSMTP();
                                    $mail->SMTPDebug = 0;
                                    $mail->SMTPAuth = true;
                                    //$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
                                    $mail->Host = "203.150.62.22"; // SMTP server
                                    $mail->Port = 25; // พอร์ท
                                    $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
                                    $mail->Password = 'Ditp2017'; // รหัสผ่าน SMTP

                                    $mail->IsHTML(true);
                                    $mail->SetFrom($from_email, $from_name);
                                    $mail->AddReplyTo($from_email, $from_name);
                                    $mail->Subject = $subject;
                                    $mail->MsgHTML($body);
                                    $mail->AddAddress($to_email, $to_name);

                                    if (!$mail->Send()) {
                                    $status_response = "02";
                                    $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
                                    } else {
                                    $output = "00";
                                    $status_response_text = "Message sent ;)";
                                    }
                                } catch (phpmailerException $e) {

                                } catch (Exception $e) {
                                    
                                }
                                // return $output;
                                
                                if ($conn->query($sql) === TRUE) {
                                    $last_id = $conn->insert_id;
                                    auto_reg($ssoid, $last_id,$code);

                                    if ($data['type'] == 1 || $data['type'] == 2 || $data['type'] == 6) {

                                        $sql_com = "INSERT INTO Member_comp 
                                        (member_id,member_comp_name,member_comp_taxid,member_comp_address,member_comp_postcode,member_comp_phone,member_comp_type,country_id,prov_name,prov_name_en,member_comp_name_en)
                                         VALUES 
                                         ('$last_id','$member_comp_name','$member_comp_taxid','$member_comp_address','$postcode_co','$member_comp_phone','1','$country_id', '$prov_name', '$prov_name_en','$member_comp_name_en') ";
                              
                                        if ($conn->query($sql_com) != TRUE){
                                            echo ("Error: " . $sql_com . "<br>" . $conn->error);
                                            exit();
                                        }
                                        
                                    }
                                    $_SESSION["member"]["member_id"] = $last_id ;
                                    $_SESSION["member"]["member_type"] = $insertType;

                                    $_SESSION["member_id"] = $last_id ;
                                    $_SESSION["member_type"] = $insertType;
                                    $ip = get_client_ip();
                                    $sql_log = "INSERT INTO Log_Login_Member (member_id,ssoid,ip) VALUES ('$last_id','$ssoid','$ip') ";
                                    $conn->query($sql_log);
                                    // echo $sql_log;
                                    
                                    if($data['type'] ==1 || $data['type'] == 2 || $data['type'] == 6){
                                        if( check_data_comp($conn, $ck['member_id']) == 1){
                                            $url_href = 'edit';
                                        }
                                    }
                                    // echo $data['type'];
                                    // echo check_data_member($conn, $ck['member_id'], $data['type']);
                                    // exit();
                                    if( check_data_member($conn, $last_id, $data['type']) == 1){
                                        $url_href = 'edit';
                                    }
                                    if($url_href == 'edit'){
                                        header( "location: https://care.ditp.go.th/frontend/index.php?page=profile&lang=1&edit=true" );
                                    }else{
                                        header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
                                    }
                                    exit();

                                    exit();
                                } else {
                                    echo ("Error: " . $sql . "<br>" . $conn->error);
                                }
                            }
                            
                        } else {
                            echo $data['res_text'] . $data['res_result'];
                        }
                    }
                }

                function get_client_ip() {
                    $ipaddress = '';
                    if (getenv('HTTP_CLIENT_IP'))
                        $ipaddress = getenv('HTTP_CLIENT_IP');
                    else if(getenv('HTTP_X_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                    else if(getenv('HTTP_X_FORWARDED'))
                        $ipaddress = getenv('HTTP_X_FORWARDED');
                    else if(getenv('HTTP_FORWARDED_FOR'))
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    else if(getenv('HTTP_FORWARDED'))
                       $ipaddress = getenv('HTTP_FORWARDED');
                    else if(getenv('REMOTE_ADDR'))
                        $ipaddress = getenv('REMOTE_ADDR');
                    else
                        $ipaddress = 'UNKNOWN';
                    return $ipaddress;
                }

                function auto_reg($ssoid,$member_id,$code){
                    $curl = curl_init();

                            curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://sso.ditp.go.th/sso/auth/update_member",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "{\n    \"client_id\" : \"ssocareid\",\n    \"user_id\" : \"$member_id\",\n    \"code\":\"Bearer $code\"\n}",
                            CURLOPT_HTTPHEADER => array(
                                "cache-control: no-cache",
                                "content-type: application/json",
                            ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            if ($err) {
                          return "cURL Error #:" . $err;
                            } else {
                            return true;
                            }
                }

                function check_id_member($conn, $cid, $type)
                {
                    if($type == "1" || $type == "2" || $type == "6"){
                        $sql = "SELECT * FROM `Member_comp` WHERE  member_comp_taxid = '$cid' ORDER BY member_comp_id ASC LIMIT 1 ";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $sql_member = "SELECT * FROM `Member` WHERE  member_id = '".$row['member_id']."' AND member_type = '1' ORDER BY member_id ASC LIMIT 1 ";
                                $result_member = $conn->query($sql_member);
                                if ($result_member->num_rows > 0) {
                                    while ($row_member = $result_member->fetch_assoc()) {


                                        return [
                                            'member_id' => $row_member['member_id'],
                                            'status_update_sso' => $row_member['status_update_sso'],
                                        ];
                                    }
                                }else{
                                    return [
                                        'member_id' => 0,
                                        'status_update_sso' => '',
                                    ];
                                }
                            }
                        } else {
                            return [
                                'member_id' => 0,
                                'status_update_sso' => '',
                            ];
                        }
                        $conn->close();
                    } else{
                        $sql = "SELECT member_id,member_cid,ssoid,status_update_sso FROM `Member` WHERE  member_cid = '$cid' AND member_type = '0' ORDER BY member_id ASC LIMIT 1 ";
                        // echo $sql ;
                        // exit();
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {


                                return [
                                    'member_id' => $row['member_id'],
                                    'status_update_sso' => $row['status_update_sso'],
                                ];
                            }
                        } else {
                            return [
                                'member_id' => 0,
                                'status_update_sso' => '',
                            ];
                        }
                        $conn->close();
                    }
                    
                }


                function check_comp($conn, $member_id)
                {
                    // include ("../config/config.php");
                    $sql = "SELECT * FROM `Member_comp` WHERE  member_id = '$member_id'";
                    // echo $sql ;
                    // exit();
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        return 1;
                    } else {
                        return 0;
                    }
                    $conn->close();
                }

                function check_data_member($conn, $member_id, $type)
                {
                    // include ("../config/config.php");
                    $sql = "SELECT * FROM `Member` 
                    WHERE  member_id = '$member_id' 
                    AND ( member_cellphone = '' ";
                    // echo $sql ;

                    if($type == 1 || $type == 2 || $type == 6){
                        $sql .= ' OR member_position = "" ';
                    }
                    if($type == 3 || $type == 4){
                        $sql .= ' OR member_occupation = "" ';
                    }

                    $sql .= '  )  ';

                    // echo $sql;
                    // exit();
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                    $conn->close();
                }

                function check_data_comp($conn, $member_id)
                {
                    // include ("../config/config.php");
                    $sql = "SELECT * FROM `Member_comp` 
                    WHERE  member_id = '$member_id' 
                    AND ( member_comp_branch = '' 
                    OR member_comp_phone = '' ) ";
                    // echo $sql ;
                    // exit();
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        return 1;
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