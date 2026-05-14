                <?php
                /**
                 *   Care api
                 * 
                 */
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                include("../config/config.php");

                // $sql = "SELECT * FROM `Member` WHERE  ssoid = '1201000000397'";
                // $result = $conn->query($sql);
                // //echo "ssoid = ".print_r($ssoid);
   
                // $read = $result->fetch_assoc();
                // print_r($read);
                // exit;

                    
                $code = $_GET['code'];
                $client = $_GET['clientid'];
                $password = $_GET['xx'];
                $api_key = md5(uniqid(rand(), true));

                if (isset($code)) {
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
                            "client_id:". $client,
                            "code: Bearer " . $code,
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $data = json_decode($response, true);
                        //  echo '<pre>';
                        //  print_r($response);
                        //  echo '</pre>';
                        //  exit();
                        if ($data['res_code'] == "00") {
                            $data = $data['res_result'];
                            if ($data['naturalId'] != null) {
                                $sql = "SELECT * FROM `Member` WHERE member_cid = '$data[naturalId]'";
                                $result_sql = $conn->query($sql);
                                while ($row = $result_sql->fetch_assoc()) {
                                    $sso_update = "UPDATE `Member` SET ssoid = '$data[ssoid]' WHERE member_id = '$row[member_id]'";
                                    $conn->query($sso_update);
                                    /* if ($row["member_fname"] == null) {
                                        $delete = "DELETE FROM `Member` WHERE member_id = '$row[member_id]'";
                                        $conn->query($delete);
                                    } */
                                }
                            }
                            $ch_ssoid = check_ssoid($conn, $data['naturalId'], $data['ssoid']);
                            if ($ch_ssoid == 0) { // have
                                $ck = 0; // insert                           
                            } else {
                                $sql_token = "SELECT * FROM `Member` WHERE  ssoid = '$data[ssoid]'";
                                $result_token = $conn->query($sql_token);
                                $read_token = $result_token->fetch_assoc();
                                if($read_token['member_api_key'] == ""){
                                    $sql_update = "UPDATE `Member` SET member_api_key = '$api_key' WHERE member_id = '$read_token[member_id]'";
                                    $result_update = $conn->query($sql_update);
                                    update_token($data['ssoid'], $api_key, $read_token['member_id']);
                                }else{
                                    update_token($data['ssoid'], $read_token['member_api_key'], $read_token['member_id']);
                                }
                                
                                echo json_encode("SSOID already use");
                                exit(); // exit
                            }
                            //check_id($conn, $data['naturalId'], $data['ssoid']);
                            if ($ck != 0) {
                                
                                // $sql = "UPDATE Member SET ssoid='$data[ssoid]' WHERE member_id = $ck";
                                // if ($conn->query($sql) === TRUE) {
                                //     $_SESSION["member"]["member_id"] = $data;
                                //     $_SESSION["member"]["member_type"] = $data['type'];
                                //     $_SESSION["member_id"] = $ck;
                                //     $_SESSION["member_type"] = $data['type'] == 1 || $data['type'] == 2 ? 1 : 0;
                                //     // header( "location: https://caredev.ditp.go.th/frontend/index.php?page=home&lang=1" );
                                //     exit();
                                // } else {
                                //     echo ("Error updating record: " . $conn->error);
                                // }
                            } else {
                                $type = $data['type'];
                                $fname = "";
                                $lname = "";
                                $member_cid = "";
                                $member_address = "";
                                $member_email = "";
                                $member_password = hash_password($password);
                                $member_phone = "";
                                $insertType = "";
                                $postcode = "";
                                $ssoid = "";
                                $member_id = "";
                                $member_comp_name = "";
                                $member_comp_taxid = "";
                                $member_comp_phone = "";
                                $member_comp_address = "";
                                $postcode_co = "";
                                if ($type == 1) {
                                    //นิติไทย
                                    $fname = $data['sub_member']['nameTh'];
                                    $lname =  $data['sub_member']['lastnameTh'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['contact']['address'] . " " . $data['contact']['subdistrict'] . " " . $data['contact']['district'] . " " . $data['contact']['province'];
                                    $member_email = $data['sub_member']['email'];
                                    $member_phone = $data['sub_member']['tel'];
                                    $postcode = $data['contact']['postcode'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 1; //0 คนทั่วไป 1 นิติ
                                    $member_id = "";
                                    $member_comp_name =  $data['company']['nameTh'];
                                    $member_comp_taxid = $data['naturalId'];
                                    $member_comp_phone =  $data['tel'];
                                    $member_comp_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province'] . " " . $data['addressTh']['postcode'];
                                    $postcode_co = $data['addressTh']['postcode'];
                                } else
                                if ($type == 2) {
                                    //นิติต่างชาติ
                                    $fname = $data['sub_member']['nameEn'];
                                    $lname =  $data['sub_member']['lastnameEn'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['contact']['address'] . " " . $data['contact']['subdistrict'] . " " . $data['contact']['district'] . " " . $data['contact']['province'] . " " . $data['contact']['postcode'];
                                    $postcode = $data['contact']['postcode'];
                                    $member_email = $data['sub_member']['email'];
                                    $member_phone = $data['sub_member']['tel'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 1; //0 คนทั่วไป 1 นิติ
                                    $member_id = "";
                                    $member_comp_name =  $data['company']['nameEn'];
                                    $member_comp_taxid = $data['naturalId'];
                                    $member_comp_phone =  $data['sub_member']['tel'];
                                    $member_comp_address = $data['addressEn']['address'] . " " . $data['addressEn']['subdistrict'] . " " . $data['addressEn']['district'] . " " . $data['addressEn']['province'] . " " . $data['addressEn']['postcode'];
                                    $postcode_co = $data['addressEn']['postcode'];
                                } else
                                if ($type == 3) {
                                    //ธรรมดาไทย
                                    $fname = $data['member']['nameTh'];
                                    $lname =  $data['member']['lastnameTh'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province'] . " " . $data['addressTh']['postcode'];
                                    $member_email = $data['member']['email'];
                                    $member_phone = $data['member']['tel'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressTh']['postcode'];
                                } else
                                if ($type == 4) {
                                    //ธรรมดาต่างชาติ
                                    $fname = $data['member']['nameEn'];
                                    $lname =  $data['member']['lastnameEn'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['address']['address'] . " " . $data['country'];
                                    $member_email = $data['member']['email'];
                                    $member_phone = $data['member']['tel'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressEn']['postcode'];
                                } else {
                                    //อื่นๆ
                                    $fname = $data['member']['nameTh'];
                                    $lname =  $data['member']['lastnameTh'];
                                    $member_cid =  $data['naturalId'];
                                    $member_address = $data['addressTh']['address'] . " " . $data['addressTh']['subdistrict'] . " " . $data['addressTh']['district'] . " " . $data['addressTh']['province'] . " " . $data['addressTh']['postcode'];
                                    $member_email = $data['email'];
                                    $member_phone = $data['tel'];
                                    $ssoid = $data['ssoid'];
                                    $insertType = 0; //0 คนทั่วไป 1 นิติ
                                    $postcode = $data['addressTh']['postcode'];
                                }
                                $sql = "INSERT INTO Member (member_fname,member_lname,member_cid,member_address,member_email,member_password,member_phone,member_type,member_status,member_condition,member_creDate,ssoid,member_postcode,member_status_confirm,member_api_key) VALUES ('$fname','$lname','$member_cid','$member_address','$member_email','$member_password','$member_phone','$insertType',1,1, NOW(),'$ssoid','$postcode', 1, '$api_key') ";

                                // echo '<pre>';
                                // print_r($sql);
                                // echo '</pre>';
                                // exit();
                                
                                if ($conn->query($sql) === TRUE) {
                                    echo "Success";
                                    $last_id = $conn->insert_id;
                                    auto_reg($ssoid, $last_id, $code);
                                    update_token($data['ssoid'], $api_key, $last_id);

                                    if ($data['type'] == 1 || $data['type'] == 2) {

                                        $sql_com = "INSERT INTO Member_comp (member_id,member_comp_name,member_comp_taxid,member_comp_address,member_comp_postcode,member_comp_phone,member_comp_type) VALUES ('$last_id','$member_comp_name','$member_comp_taxid','$member_comp_address','$postcode_co','$member_comp_phone','0') ";

                                        if ($conn->query($sql_com) != TRUE) {
                                            echo ("Error: " . $sql_com . "<br>" . $conn->error);
                                            exit();
                                        }
                                    }
                                    $_SESSION["member"]["member_id"] = $last_id;
                                    $_SESSION["member"]["member_type"] = $insertType;

                                    $_SESSION["member_id"] = $last_id;
                                    $_SESSION["member_type"] = $insertType;

                                     header( "location: https://care.ditp.go.th/frontend/index.php?page=home&lang=1" );
                                    // print_r($sql);
                                    // exit();
                                } else {
                                    echo ("Error: " . $sql . "<br>" . $conn->error);
                                }
                            }
                        } else {
                            echo $data['res_text'] . $data['res_result'];
                        }
                    }
                } else {
                    echo "Undefind Code?";
                }

                function unique_salt()
                {
                    return substr(sha1(mt_rand()), 0, 22);
                }

                function hash_password($password)
                {
                    $algo = '$2a';
                    $cost = '$10';
                    return crypt($password, $algo . $cost . '$' . unique_salt());
                }

                function auto_reg($ssoid, $member_id, $code)
                {
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

                function update_token($ssoid, $api_key, $member_id)
                {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://sso.ditp.go.th/sso/auth/update_token",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{\n    \"ssoid\" : \"$ssoid\",\n    \"user_id\" : \"$member_id\",\n    \"token\":\"$api_key\"\n}",
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

                function check_id($conn, $cid, $ssoid)
                {
                    // include ("../config/config.php");
                    $sql = "SELECT member_id,member_cid,ssoid FROM `Member` WHERE  member_cid = '$cid'";
                    // echo $sql ;
                    // exit();
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            return $row['member_id'];
                        }
                    } else {
                        return 0;
                    }
                    $conn->close();
                }

                function check_ssoid($conn, $cid, $ssoid)
                {
                    //$sql = "SELECT * FROM `Member` WHERE  member_email = '$ssoid'";

                    // include ("../config/config.php");
                    $sql = "SELECT * FROM `Member` WHERE  ssoid = '$ssoid'";
                    $result = $conn->query($sql);
                    // echo "ssoid = ".print_r($ssoid);
                    // $read = $result->fetch_assoc();
                    // print_r($read);
                    // exit;

                    if ($result->num_rows > 0) {
                        
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            return $row['member_id'];
                        }
                        
                    } else {
                        
                        return 0;
                    }
                    $conn->close();
                }
                ?>

