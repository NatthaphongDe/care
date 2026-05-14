<?php

class DbHandler {

    private $conn,$func;
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
        require_once dirname(__FILE__) . '/DbFunction.php';
        $this->func = new DbFunction();
        require_once 'PassHash.php';
    }


    /*** สมัครสมาชิก ***/
    public function createUser($type_member, $fname, $lname, $cid, $address, $prov_id,$postcode, $country_id, $phone, $fax, $sex, $occupation, $position, $company_name, $company_branch,$company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax,$company_type_member,$email, $password, $image, $image_comp, $facebook_id, $facebook_type, $member_business,$member_lang) {
        $response = array();
        if (!$this->isUserExists($email)) {
            $password_hash = PassHash::hash($password);
            $api_key = $this->func->generateApiKey();
            $status = "1";
            $member_noti = "1";
            $member_condition = "1";
            $member_creDate = date("Y-m-d H:i:s");
            if($facebook_type == '1'){
              $password_hash = '';
            }

            $stmt = $this->conn->prepare("INSERT INTO Member(member_fname, member_lname, member_cid,
              member_address, prov_id, member_postcode, country_id, member_phone,
              member_cellphone, member_sex, member_occupation, member_position, member_email,
              member_password, member_api_key, member_type, member_status, member_noti,
              member_condition, member_creDate, member_facebook_id, member_facebook_type, member_business, member_lang
            ) values('$fname', '$lname', '$cid',
              '$address', '$prov_id', '$postcode',
              '$country_id', '$phone', '$fax',
              '$sex', '$occupation', '$position', '$email',
              '$password_hash', '$api_key', '$type_member',
              '$status', '$member_noti', '$member_condition', '$member_creDate', '$facebook_id', '$facebook_type',
              '$member_business', '$member_lang'
            )");
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $lastid = $this->conn->insert_id;
                if($type_member == '0'){
                  $text_name_member = "คุณ ".$fname." ".$lname;
                }else{
                  $text_name_member = "บริษัท ".$company_name;
                }
                $text_send_mess = 'ยินดีต้อนรับ '.$text_name_member.' สู่บริการ DITP Care ของเรา';
                $text_send_mess_en = 'Welcome '.$text_name_member.' to our DITP Care service.';

                $stmt2 = $this->conn->prepare("INSERT INTO Message_Box(msgBoxRef_id, msgBox_type, case_id, sender_id, sender_type,
                  msgBox_message, msgBox_message_en, msgBox_datetime, msgBox_status, msgBox_noti_status
                ) values('0', '1', '0', '$lastid', '0','$text_send_mess', '$text_send_mess_en',
                  NOW(), '0', '0'
                )");
                $stmt2->execute();

                if($image != ""){
                  $success = $this->func->uploadImageBase64($image, "img_member" , $lastid);
                  if($success!=''){
                    $stmt = $this->conn->prepare("UPDATE Member set member_img = '$success' WHERE member_id = '$lastid' ");
                    $stmt->execute();
                  }
                }
                if($type_member){
                  $res = $this->createMember_comp($lastid,$company_name,$company_branch,$company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax, $company_type_member, $image_comp);
                }
                if ($res) {
                    return USER_CREATED_SUCCESSFULLY;
                } else {
                    return NULL;
                }
            } else {
                return USER_CREATE_FAILED;
            }
        } else {
            return USER_ALREADY_EXISTED;
        }
        return $response;
      }

      /*** เพิ่ม company ให้กับ user ***/
      public function createMember_comp($lastid, $company_name, $company_branch, $company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax, $company_type_member, $image_comp) {
          $stmt = $this->conn->prepare("INSERT INTO Member_comp(member_id, member_comp_name, member_comp_branch, member_comp_taxid, member_comp_address, prov_id, member_comp_postcode, country_id, member_comp_phone, member_comp_fax, member_comp_type) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->bind_param("sssssssssss", $lastid, $company_name, $company_branch,$company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax, $company_type_member);
          $result = $stmt->execute();
          $stmt->close();
          if ($result) {
              $lastid2 = $this->conn->insert_id;
              if($image_comp != ""){
                $success2 = $this->func->uploadImageBase64($image_comp, "img_membercom" , $lastid2);
                if($success2!=''){
                  $stmt = $this->conn->prepare("UPDATE Member_comp set member_comp_img = '$success2' WHERE member_comp_id = '$lastid2' ");
                  $stmt->execute();
                }
              }
          }
          return $result;
      }


      /*** เช็คอีเมล์ซ้ำ ***/
      private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT member_id from Member WHERE member_email = '$email'");
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
      }

      /*** เช็คล็อกอิน ***/
      public function checkLogin($email, $password) {

        if($password == "facebook"){
            $stmt = $this->conn->prepare("SELECT member_password FROM Member WHERE member_facebook_id = '$email' AND member_facebook_type = '1' ");
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
              $stmt->close();
              return TRUE;
            }else{
              $stmt->close();
              return FALSE;
            }
        }else{
            $stmt = $this->conn->prepare("SELECT member_password FROM Member WHERE member_email = '$email' AND member_facebook_type = '0' ");
            $stmt->execute();
            $stmt->bind_result($password_hash);
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->fetch();
                $stmt->close();
                if (PassHash::check_password($password_hash, $password)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                $stmt->close();
                return FALSE;
            }
        }
    }

    /*** เช็คล็อกอิน ***/
    public function checkLoginWithKey($email) {

      $stmt = $this->conn->prepare("SELECT member_id FROM Member WHERE member_api_key = '$email' AND member_status = '1' ");
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->close();
        return TRUE;
      }else{
        $stmt->close();
        return FALSE;
      }
  }


    /*** ดึงข้อมูล user จากอีเมล์ ***/
    public function getUserByEmail($email,$fieldName) {
        $stmt = $this->conn->prepare("SELECT *,a.prov_id AS prov2_id,a.country_id AS country2_id,
          b.prov_name AS prov2_name,c.name AS country2_name ,a.member_id AS member_id2, a.member_api_key as mkey FROM Member a
          LEFT JOIN Member_comp d ON a.member_id=d.member_id
          LEFT JOIN Province b ON a.prov_id=b.prov_id
          LEFT JOIN Province e ON e.prov_id=d.prov_id
          LEFT JOIN Country c ON a.country_id=c.id
          LEFT JOIN Country f ON d.country_id=f.id
          WHERE $fieldName = '$email' AND member_status = '1' ");
          // echo "SELECT *,a.prov_id AS prov2_id,a.country_id AS country2_id,
          //   b.prov_name AS prov2_name,c.name AS country2_name ,a.member_id AS member_id2, a.member_api_key as mkey FROM Member a
          //   LEFT JOIN Member_comp d ON a.member_id=d.member_id
          //   LEFT JOIN Province b ON a.prov_id=b.prov_id
          //   LEFT JOIN Province e ON e.prov_id=d.prov_id
          //   LEFT JOIN Country c ON a.country_id=c.id
          //   LEFT JOIN Country f ON d.country_id=f.id
          //   WHERE $fieldName = '$email' AND member_status = '1' ";
          //   exit();
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          $to_remove = array("member_password", "member_status", "prov_code","enabled", "code3l", "code2l","name_official", "flag_32", "flag_128","latitude", "longitude", "zoom","id");
          $result = array_diff_key($result->fetch_assoc(), array_flip($to_remove));
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }

    /*** ลืมรหัสผ่าน ***/
    public function sendForgotPass($email) {

        $stmt = $this->conn->prepare("SELECT * FROM Member WHERE member_email = '$email' ");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          $res = $result->fetch_assoc();
          $mailsent = $email;
          $namesent = $res['member_fname']." ".$res['member_lname'];
          $newpassword = $result = $this->func->random_password();

             $message = "<table cellpadding=\"5\" cellspacing=\"0\">
              <tr >
                <td>
                </td>
              </tr>
               <td style=\" color:#000;font-size:16px; \">
              สวัสดี ".$namesent."
               </td>
              </tr>
              <tr>
               <td style=\" color:#707070;font-size:15px; \">
              เราได้รับคำขอให้รีเซ็ตรหัสผ่าน App DITP ของคุณ
               </td>
              </tr>
              <tr ><td></td></tr>
              <tr>
               <td style=\" color:#707070;font-size:15px; \">
              Email : ".$mailsent."
               </td>
              </tr>
              <tr>
               <td style=\" color:#707070;font-size:15px; \">
              Password : ".$newpassword."
               </td>
              </tr>
              <tr ><td></td></tr><tr ><td></td></tr>
              <tr>
               <td style=\" color:#707070;font-size:15px; \">
              คุณสามารถใช้ Email และ Password นี้เข้าใช้งานได้ที่ App DITP
               </td>
              </tr>
              <tr>
               <td style=\" font-size:15px; \">
              Team http://www.ditp.go.th/
               </td>
              </tr>
             </table>";
             $result = $this->func->sendEmail("ditp.noreply@gmail.com","Noreply DITP",array($mailsent),array($namesent),"รีเซ็ตรหัสผ่านของคุณ",$message,$newpassword,$emp_email);
             if(!$result){
               $password_hash = PassHash::hash($newpassword);
               $stmt = $this->conn->prepare("UPDATE Member SET member_password = '".$password_hash."' WHERE member_email = '$email' ");
               $stmt->execute();
             }
          return $result;
        }else{
          $stmt->close();
          return 2;
        }
    }

    /*** ดึง userid จาก apikey ***/
    public function getUserId($api_key) {
        $stmt = $this->conn->prepare("SELECT member_id FROM Member WHERE member_api_key = '$api_key' ");
        if ($stmt->execute()) {
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }

    /*** ดึงเปอร์เซ็น ***/
    public function checkPercen($case_id) {
        // $stmt = $this->conn->prepare("SELECT MAX(process_type_step) as countStatus FROM Process a LEFT JOIN Process_Type b ON a.process_type_id=b.process_type_id WHERE case_id = '$case_id' ");

        $stmt = $this->conn->prepare("SELECT process_type_step as countStatus FROM Process a LEFT JOIN Process_Type b ON a.process_type_id=b.process_type_id WHERE case_id = '$case_id' order by a.process_id desc limit 1 ");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $res = $result->fetch_assoc();
          $stmt->close();
          return $res['countStatus'];
        }else{
          $stmt->close();
          return NULL;
        }
    }


    public function changepass($passold, $passnew,$user_id) {
      // $passold = PassHash::hash($passold);
      $passnew = PassHash::hash($passnew);
      // SELECT member_password FROM Member WHERE member_email = '$email'
      $Tsql = "SELECT * FROM `Member` where member_id = '".$user_id."' ";
      $stmt = $this->conn->prepare($Tsql);
      $stmt->execute();
      $result = $stmt->get_result();

      if($result->num_rows > 0){
        $res = $result->fetch_assoc();
        if (PassHash::check_password($res['member_password'], $passold)) {
          if ($res['member_facebook_type'] == '0') {
              if ($res['member_status']=='1') {
                  $sql = "update `Member` set member_password = '".$passnew."' where member_id='".$user_id."'";
                  $stmt1 = $this->conn->prepare($sql);
                  $objQuery1=$stmt1->execute();
                  // $result1= $stmt1->get_result();
                  if($objQuery1){
                    return "change password successfully";
                  }else{
                    return "Error sql";
                  }
              }
              return "No active";
          }
          return "login facebook";
        }
        return "Passwod is incorrect";
      }else{
        $stmt->close();
        return "not found user";
      }


    }

    /*** checkformset ***/
    public function getFormSet($compType1, $compType2, $compType3) {
      if($compType2>0){
        $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = ? AND compTypeSub1_id = ? ");
        $stmt->bind_param("ss", $compType1,$compType2);
      }else{
        $stmt = $this->conn->prepare("SELECT form_id FROM Complaint_Type WHERE compType_id = '$compType1'  ");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $res = $result->fetch_assoc();
          $keyform=$res['form_id'];
        }

        // $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = ? AND form_id = ? ");
        // $stmt->bind_param("ss", $compType1, $keyform);

        $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = ?  ");
        $stmt->bind_param("s", $compType1);
      }


        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"frmset_id" => $res['frmset_id'],
              "frmset_name" => $res['frmset_name']
  					);
  					$output[]=$response;
  					$id[]= $res['frmset_id'];
  				}
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * FROM Field_Set WHERE frmset_id ='$id[$key]' ");
            $stmt->execute();
            $result2 = $stmt->get_result();
  					while($res2 = $result2->fetch_assoc())
  					{
    					$response = array(
    						"fieldset_id" => $res2['fieldset_id'],
                "fieldset_name" => $res2['fieldset_name'],
                "fieldset_require" => $res2['fieldset_require'],
    					);
    					$output3[]=$response;
    					$output[$key]['frmset_field'] = $output3 ;
  					}
  					$output3 = array();
  				}
          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
    }
    /*** ดึง userid จาก apikey ***/
    public function FormIdWithTable($compType1) {
      $stmt = $this->conn->prepare("SELECT form_id FROM Complaint_Type WHERE compType_id = '$compType1' ");
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        $stmt->close();
        return $result;
      }else{
        $stmt->close();
        return NULL;
      }
    }
    /*** checkformset ***/
    public function getFormSet2($compType1, $compType2, $compType3) {
      $stmt2 = $this->conn->prepare("SELECT * FROM Complaint_Type WHERE compType_id = '$compType1' ");
      $stmt2->execute();
      $result2 = $stmt2->get_result();
      if($result2->num_rows > 0){

        $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '$compType1' and form_id = '51' ");
        // $stmt->bind_param($compType1);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
          {
            $response = array(
              "frmset_id" => $res['frmset_id'],
              "frmset_name" => $res['frmset_name']
            );
            $output[]=$response;
            $id[]= $res['frmset_id'];
          }
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * FROM Field_Set WHERE frmset_id ='$id[$key]' ");
            $stmt->execute();
            $result2 = $stmt->get_result();
            while($res2 = $result2->fetch_assoc())
            {
              $response = array(
                "fieldset_id" => $res2['fieldset_id'],
                "fieldset_name" => $res2['fieldset_name'],
                "fieldset_require" => $res2['fieldset_require'],
              );
              $output3[]=$response;
              $output[$key]['frmset_field'] = $output3 ;
            }
            $output3 = array();
          }
          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
      }else{
        $stmt->close();
        return NULL;
      }
    }


    /*** validate complaint ***/
    public function validateComp($v1,$userid) {
      $stmt = $this->conn->prepare("SELECT country_id,member_type from Member WHERE member_id = '$userid' ");
      $stmt->execute();
      $result = $stmt->get_result();
      $country= $result->fetch_assoc();
              $sql = "SELECT * from Field_Set WHERE fieldset_require = '1' and frmset_id IN($v1)  ";
              // if ($country['country_id']!='162' || $country['member_type'] == '0' ) {
              if ($country['member_type'] == '0' ) {
                $sql.=" and  fieldset_name != 'applntOrg_name' and  fieldset_name != 'applntOrg_address' and  fieldset_name != 'applntOrg_tel' and  fieldset_name != 'applntOrg_prov_id' and  fieldset_name != 'applntOrg_country_id'";
              }
              $stmt = $this->conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $response=array();
              if($result->num_rows > 0){
                while($res = $result->fetch_assoc())
                {

                  array_push($response,$res['fieldset_name']);
                }

                return $response;
              }
    }
    /*** validate complaint ***/
    public function validateCompText($v1) {
      $array = explode(',', $v1);
      $ss = "";
      foreach ($array as $key => $value) {
        $ss .= "'".trim($value)."',";
      }
      $ss = substr($ss, 0, -1);

      $stmt = $this->conn->prepare("SELECT * from Field_Set WHERE  fieldset_name IN($ss) group by fieldset_name ");
      // echo "SELECT fieldset_description from Field_Set WHERE  fieldset_name IN($ss) group by fieldset_name ";
      // exit();
      $stmt->execute();
      $result = $stmt->get_result();
      // $response=array();
      $response="";
      $response_en="";

      if($result->num_rows > 0){
        while($res = $result->fetch_assoc())
        {
          $response .= $res['fieldset_description'].", ";
          $response_en .= $res['fieldset_description_en'].", ";
          // $dd = "[".$res['fieldset_description'],$res['fieldset_description_en']."]";
          // array_push($response,array(
          //   'fieldset_description' => $res['fieldset_description'],
          //   'fieldset_description_en' => $res['fieldset_description_en']
          // ));

        }
      }
      // $resultx = array('result'=>$response);
      return ($response."-".$response_en);
    }

    /*** ข้อความข้อกำหนดและเงื่อนไขการใช้งาน ***/
    public function getTermsOfUse() {
        /*********** start real ************/
        //$stmt = $this->conn->prepare("SELECT * FROM terms_of_use");
        //$stmt->execute();
        //$result = $stmt->get_result();
        /*********** end real ************/

        /*********** start mock ************/
        $result = '{
            "current_field":0,
            "field_count":2,
            "lengths":[
                {
                  "termsOfUse_id":1,
                  "termsOfUse_text":"1.กรมส่งเสริมการค้าระหว่างประเทศเป็นผู้ประสานไกล่เกลี่ยข้อพิพาททางการค้าระหว่างประเทศ โดยไม่เป็นการตัดสิทธิของผู้ร้องเรียนที่จะนำเรื่องร้องเรียนไปดำเนินคดีตามกฎหมายด้วยตนเอง <br><br> 2.กรณีที่ผู้ร้องเรียนได้ไปใช้สิทธิดำเนินคดีในชั้นศาลด้วยตนเองแล้ว ขอให้ท่านทำหนังสือแจ้งยุติเรื่องร้องเรียนต่อกรมส่งเสริมการค้าระหว่างประเทศ  หรือ DITP Care <br><br> 3. หลังจากการส่งเรื่องร้องเรียนภายใน 3 วันทำการ หากผู้ร้องเรียนยังไม่ได้รับการติดต่อจากเจ้าหน้าที่ โปรดติดต่อ DITP Call Center 1169 <br><br> 4.หากเรื่องร้องเรียนของท่านเป็นกรณีเร่งด่วนโปรดติดต่อ DITP Call Center 1169 <br><br> 5. การยืนยันตัวตนการใช้งานของผู้ร้องเรียน ผู้ร้องเรียนจะต้องกรอกข้อมูลรายละเอียดต่างๆ ตามจริงให้ครบถ้วน ทั้งนี้เพื่อประโยชน์แก่ตัวผู้ร้องเรียน หากตรวจพบว่าข้อมูลของผู้ร้องเรียนไม่เป็นความจริง ทางกรมส่งเสริมการค้าระหว่างประเทศ จะทำการระงับการใช้งานของผู้ร้องเรียนโดยไม่ต้องแจ้งให้ทราบล่วงหน้า <br><br> 6. การยืนยันเรื่องร้องเรียนและข้อพิพาททางการค้าระหว่างประเทศต้องเป็นความจริงทุกประการ หากพบว่าเรื่องร้องเรียนและข้อพิพาททางการค้าระหว่างประเทศของท่านไม่เป็นความจริง ท่านจะถูกดำเนินคดีตามกฏหมาย",
                  "termsOfUse_text_en":"1. The Department of International Trade is the mediator of international trade disputes. Without disqualifying the complainant to bring the complaint to law-suit themselves.<br><br>2. In case the complainant has the right to take legal action in court, Would you like to make a letter of complaint to the Department of International Trade or DITP Care<br><br>3. After submitting a complaint within 3 working days, if the complainant has not been contacted by the officer, please contact DITP Call Center 1169.<br><br>4. If your complaint is urgent, please contact DITP Call Center 1169.<br><br>5. Verification of the use of the complainant. Complainant will need to fill in the details. True to full For the benefit of the complainant. If it detects that the complainant\'s information is not true. The Department of International Trade. It will suspend the use of the complainant without prior notice.<br><br>6. Confirmation of complaints and international trade disputes must be true in all respects. If your international trade dispute and complaint is found to be untrue. You will be prosecuted by law."
                }
              ],
            "num_rows":1,
            "type":0
         }';
         $result = json_decode($result);
         /*********** end mock ************/
        if($result->num_rows > 0){
          //$stmt->close(); // code real
          $result = (array)$result->lengths; // code mock
          return $result;
        }else{
          //$stmt->close(); // code real
          return NULL;
        }
    }

    /*** แสดง about ***/
    public function getAbout() {

        /*********** start mock ************/
        $result = '{
            "current_field":0,
            "field_count":2,
            "lengths":[
                {
                  "about_id":1,
                  "about_title":"เกี่ยวกับ DITP Care",
                  "about_title_en":"About DITP Care",
                  "about_dis":"กรมการส่งเสริมการค้าระหว่างประเทศ ได้มอบหมายให้สำนักงานสารสนเทศ และการบริการการค้าระหว่างประเทศดำเนินการให้ บริการข้อมูลและคำปรึกษาด้านการค้า ระหว่างประเทศ รวมถึงเป็นศูนย์กลางในการรับเรื่องร้องเรียน ข้อคิดเห็น/ข้อเสนอแนะ และข้อพิพาท    ทางการค้าระหว่างประเทศ เพื่อช่วยเหลือผู้ประกอบการไทยและชาวต่างชาติ",
                  "about_dis_en":"Department of International Trade Promotion has assigned Office of Information and International Trade Service to provide information, advice on international trade, and to be the centre of complaints/suggestions/international trade conflicts, as an assistance to Thai and foreign entrepreneurs.",
                  "about_link":""
                },
                {
                  "about_id":2,
                  "about_title":"กรมส่งเสริมการค้าระหว่างประเทศ (บางกระสอ)",
                  "about_title_en":"Department of International Trade Promotion (Bangkrasor)",
                  "about_dis":"563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 โทรศัพท์ : 0 2507 7999 โทรสาร : 0 2547 5657 อีเมล : tiditp@ditp.go.th สายด่วน : 1169",
                  "about_dis_en":"563 Nonthaburi road, Tambon Bangkrasor, Muang, Nonthaburi 11000. Tel: 0 2507 7999 Fax: 0 2547 5657 Email: tiditp@ditp.go.th Hotline: 1169 ",
                  "about_link":"https://www.google.com/maps/d/u/0/viewer?ll=13.885037300929957%2C100.48700800000006&spn=0.023622%2C0.042272&msa=0&iwloc=0004e1d66cce09b33bc93&mid=1Urvxq7GWYWsmkhMnjkFy4vNBKLY&z=15"

                },
                {
                  "about_id":3,
                  "about_title":"กรมส่งเสริมการค้าระหว่างประเทศ (ถนนรัชดาภิเษก)",
                  "about_title_en":"DITP Office at Ratchadaphisek road",
                  "about_dis":"22/77 ถนนรัชดาภิเษก เขตจตุจักร กรุงเทพ 10900 โทรศัพท์ : 0 2513 1909 โทรสาร : 0 2511 5200 อีเมล : tiditp@ditp.go.th สายด่วน : 1169",
                  "about_dis_en":"22/77 Ratchadaphisek rd, Chatuchak, Bangkok 10900 Tel: 0 2513 1909 Fax: 0 2511 5200 Email: tiditp@ditp.go.th Hotline: 1169",
                  "about_link":"https://www.google.com/maps/d/u/0/viewer?ll=13.82612029975422%2C100.57412599999998&spn=0.023628%2C0.042272&msa=0&iwloc=0004e68ff289bca436eac&mid=1WcmTok743h6ZfAq-PW91257bJBo&z=15"
                }
              ],
            "num_rows":1,
            "type":0
         }';

         $result = json_decode($result);
         /*********** end mock ************/
        if($result->num_rows > 0){
          $result = (array)$result->lengths; // code mock
          return $result;
        }else{
          return NULL;
        }
    }



    /*** แสดง help ***/
    public function getHelp() {

        /*********** start mock ************/
        $result = '{
            "current_field":0,
            "field_count":2,
            "lengths":[
                {
                  "help_id":1,
                  "help_title":"DITP CARE  ให้คำปรึกษาและช่วยเหลือ ด้านการค้าระหว่างประเทศได้อย่างไร",
                  "help_title_en":"How does DITP Care assist you in international trade?",
                  "help_dis":"<div class=\"\"><span class=\"txt_hr_help\">ให้บริการข้อมูลและคำปรึกษาด้านการค้าระหว่างเทศ รวมถึงเป็นศูนย์กลางในการรับเรื่องร้องเรียนต่างๆ</span><div class=\"txt_type_help\">ประเภทของเรื่องร้องเรียน</div><div class=\"txt_item\">1. ข้อพิพาททางการค้าระหว่างประเทศ</div><div class=\"txt_item_sup\">- ผู้ประกอบการต่างประเทศร้องเรียนผู้ประกอบการไทย</div><div class=\"txt_item_sup\">- ผู้ประกอบการไทยร้องเรียนผู้ประกอบการต่างประเทศ</div><div class=\"txt_item\">2. เรื่องร้องเรียนการให้บริการกรม</div><div class=\"txt_item\">3. เรื่องร้องเรียนการทุจริตในภาครัฐ และวินัยข้าราชกรม</div><div class=\"txt_item_sup\">- เรื่องร้องทุกข์ ขอความเป็นธรรม</div><div class=\"txt_item_sup\">- เรื่องร้องเรียน ข้าราชการ/เจ้าหน้าที่</div><div class=\"txt_item\">4. อื่นๆ (กิจกรรม /โครงการของกรม)</div></div>",
                  "help_dis_en":"<div class=\"\"><span class=\"txt_hr_help\">Assistance in information and consultation about international trade and a complaint centre</span><div class=\"txt_type_help\">Type of petition</div><div class=\"txt_item\">1. International trade conflict</div><div class=\"txt_item_sup\">- Complaining against company in Thailand</div><div class=\"txt_item_sup\">- Complaining against company in overseas</div><div class=\"txt_item\">2. Complaint about DITP service</div><div class=\"txt_item\">3. Complaint about corruption in government agency/official</div><div class=\"txt_item_sup\">- Complaint about impartiality or file an appeal</div><div class=\"txt_item_sup\">- Complaint against government official/staff/organization</div><div class=\"txt_item\">4. Others (DITP activities/projects)</div></div>"
                },
                {
                  "help_id":2,
                  "help_title":"ขั้นตอนการร้องเรียน",
                  "help_title_en":"How to petition",
                  "help_dis":"<div class=\"panel-body\"><div class=\"txt_item\">ขั้นตอนที่ 1 แจ้งเรื่องร้องเรียนผ่านทาง Website DITP CareApp DITP Care หรือช่องทางอื่นๆโดยพสามารถกรอกรายละเอียดข้อมูลเรื่องร้องเรียนและแนบเอกสารข้อเท็จจริง ได้ในระบบ        </div><div class=\"txt_item\">ขั้นตอนที่ 2 เจ้าหน้าที่ได้รับเรื่องร้องเรียนของท่านแล้ว และทำการประสานไปยังผู้ที่เกี่ยวข้อง        </div><div class=\"txt_item\">ขั้นตอนที่ 3 เจ้าหน้าที่ดำเนินการตรวจสอบข้อเท็จจริง และแจ้งความคืบหน้าให้แก่ผู้ร้องเรียนทราบต่อไป        </div><div class=\"txt_item\">ขั้นตอนที่ 4 ยุติเรื่องร้องเรียน        </div></div>",
                  "help_dis_en":"<div class=\"panel-body\"><div class=\"txt_item\">1) Create petition on DITP Care Web Site or other petition channels and attach documentation for petition into the system        </div><div class=\"txt_item\">2) The system receives your petition and forward it to appropriate channel        </div><div class=\"txt_item\">3) DITP validates your information and updates the processes to petitioner        </div><div class=\"txt_item\">4) Stop your petition your petition        </div></div>"
                },
                {
                  "help_id":3,
                  "help_title":"ช่องทางการรับเรื่องร้องเรียน",
                  "help_title_en":"Petition channels",
                  "help_dis":"<div class=\"panel-body\"><div class=\"txt_item\">1.ผู้ประกอบการร้องเรียนด้วยตนเอง      </div><div class=\"txt_item_sup\">1.1 ร้องเรียนผ่านเคาน์เตอร์ให้บริการการค้าระหว่างประเทศ ทั้ง 2 แห่ง (Walk-in)      </div><div class=\"txt_item_supersup\">-กรมส่งเสริมการค้าระหว่างประเทศ (ถนนรัชดาภิเษก)      </div><div class=\"txt_item_supersup\">-กรมส่งเสริมการค้าระหว่างประเทศ (นนทบุรี)      </div><div class=\"txt_item_sup\">1.2 ร้องเรียนผ่านสายตรงการค้าระหว่างประเทศ 1169      </div><div class=\"txt_item_sup\">1.3 ร้องเรียนผ่านเว็บไซต์กรมส่งเสริมการค้าระหว่างประเทศ www.ditp.go.th      </div><div class=\"txt_item_sup\">1.4 ร้องเรียนผ่าน E-mail : ditpservicecenter@gmail.com      </div><div class=\"txt_item\">2.สำนักตลาด 2 สำนัก โดยการประสานจากสำนักงานส่งเสริมการค้าในต่างประเทศ (สคต)      </div><div class=\"txt_item_sup\">2.1 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.1)      </div><div class=\"txt_item_sup\">2.2 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item\">3.สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item_sup\">3.1 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.1)      </div><div class=\"txt_item_sup\">3.2 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item_sup\">3.3 สำนักส่งเสริมการค้าสินค้าไลฟ์สไตล์ (สลต.)      </div><div class=\"txt_item_sup\">3.4 สำนักส่งเสริมการค้าสินค้าเกษตรและอุตสาหกรรม (สกอ.)      </div><div class=\"txt_item_sup\">3.5 สำนักธุรกิจบริการและโลจิสติกส์การค้า (สบล.)      </div><div class=\"txt_item\">4.สำนักงานส่งเสริมการค้าในต่างประเทศ ของกรม จำนวน 58 สำนักงาน      </div><div class=\"txt_item_sup\">4.1 สำนักปลัดกระทรวงพาณิชย์      </div><div class=\"txt_item_sup\">4.2 สำนักนายกรัฐมนตรี (GCC 1111)      </div><div class=\"txt_item_sup\">4.3 กล่องรับฟังความคิดเห็นและเรื่องร้องเรียน/การทุจริตภาครัฐ      </div><div class=\"txt_item_sup\">4.4 ไปรษณีย์ไทย      </div></div>",

                  "help_dis_en":"<div class=\"panel-body\"><div class=\"txt_item\">1.Create petition by yourself      </div><div class=\"txt_item_sup\">1.1 Submit petition through 2 DITP counters (walk-in) at      </div><div class=\"txt_item_supersup\">-DITP Office at Ratchadaphisek road      </div><div class=\"txt_item_supersup\">-DITP Office at Ministry of Commerce, Nonthaburi      </div><div class=\"txt_item_sup\">1.2 DITP Call Center 1169      </div><div class=\"txt_item_sup\">1.3 DITP Web Site at www.ditp.go.th       </div><div class=\"txt_item_sup\">1.4 DITP E-mail at ditpservicecenter@gmail.com      </div><div class=\"txt_item\">2.DITP Service Center at ThaiTrade Foreign Offices      </div><div class=\"txt_item_sup\">2.1 Office of Overseas Markets Development and Promotion 1      </div><div class=\"txt_item_sup\">2.2 Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item\">3.Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item_sup\">3.1 Office of Overseas Markets Development and Promotion 1      </div><div class=\"txt_item_sup\">3.2 Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item_sup\">3.3 Office of Fashion and Lifestyle Business Development      </div><div class=\"txt_item_sup\">3.4 Office of Agricultural and Industrial Business Development      </div><div class=\"txt_item_sup\">3.5 Office of Service Trade and Trade Logistics      </div><div class=\"txt_item\">4.58 ThaiTrade Center Foreign Offices      </div><div class=\"txt_item_sup\">4.1 Office of Permanent Secretary for Commerce      </div><div class=\"txt_item_sup\">4.2 The Prime Minister’s Office Call Centre (GCC 1111)      </div><div class=\"txt_item_sup\">4.3 The Royal Thai Government’s Complaint Post Box      </div><div class=\"txt_item_sup\">4.4 ThaiPost      </div></div>"
                },
                {
                  "help_id":4,
                  "help_title":"สนใจเข้าร่วมเป็นสมาชิกกรม",
                  "help_title_en":"Sign up for DITP membership",
                  "help_dis":"ผู้ประกอบการสามารถลงทะเบียนเป็นสมาชิกกรมสมัครสมาชิกกรมส่งเสริมการค้าระหว่างประเทศ ได้ที่ http://application.ditp.go.th/register และสำหรับผู้ประกอบการที่เป็นสมาชิกของกรมฯ สามารถเข้าเข้าร่วมเป็นส่วนหนึ่งของกิจกรรมต่างๆ เพื่อสร้างโอกาสต่อยอดทางธุรกิจ ขยายตลาด และหาคู่ค้าในต่างประเทศได้เพิ่มขึ้น โดยการเข้าร่วมกิจกรรมงานแสดงสินค้าทั้งในประเทศและต่างประเทศทั่วโลก โดยผู้ประกอบการสามารถเลือกดูกิจกรรมที่เหมาะสมได้จาก ปฏิทินกิจกรรม http://application.ditp.go.th/activity/index/list และ ลงทะเบียนเข้าร่วมกิจกรรมได้ที่ http://application.ditp.go.th/auth/login",
                  "help_dis_en":"Thai entrepreneurs can sign up for DITP membership at http://application.ditp.go.th/register . DITP members can participate in DITP-organised activities to develop their businesses, expand their markets, find trade partners, and join in DITP trade fairs both in Thailand and abroad. Entrepreneurs can choose their activities of preference at DITP activity calendar at http://application.ditp.go.th/activity/index/list and sign up for activities at http://application.ditp.go.th/auth/login ."
                }
              ],
            "num_rows":1,
            "type":0
         }';
         $result = json_decode($result);
         /*********** end mock ************/
        if($result->num_rows > 0){
          $result = (array)$result->lengths; // code mock
          return $result;
        }else{
          return NULL;
        }
    }

    /*** ชื่อประเทศ ***/
    public function getCountry() {
        $stmt = $this->conn->prepare("SELECT * FROM Country ORDER BY name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }


    /*** ชื่อจังหวัด***/
    public function getProvince() {
        $stmt = $this->conn->prepare("SELECT * FROM Province");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }

    public function getCaseUser($idcase) {
        // echo "SELECT * FROM `Case`  where case_createBy_id ='".$idcase."' and case_assign_status = '1'  ORDER BY `case_id` desc";
        // exit();
        $stmt = $this->conn->prepare("SELECT * FROM `Case`  where case_createBy_id ='".$idcase."' and caseCh_id in(1,2) and  case_assign_status = '1'  ORDER BY `case_id` " );
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
      }



    /*** ประเภทสินค้า ***/
    public function getTypeProduct() {
        $stmt = $this->conn->prepare("SELECT *,b.prodType_id as prodType_id_rename, concat(a.prodType_name,' -> ',b.prodType_name) as fullname_product,concat(a.prodType_name_en,' -> ',b.prodType_name_en) as fullname_product_en from Product_Type a LEFT join Product_Type b on a.prodType_id=b.prodType_ref_id  WHERE a.prodType_enable = '1' and a.prodType_level = '1'" );
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }

        // $stmt = $this->conn->prepare("SELECT * from Product_Type WHERE prodType_enable = '1' and prodType_level = '1' ");
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $response=array();
        // if($result->num_rows > 0){
        //   while($res = $result->fetch_assoc()){
        //     $stmt_sub = $this->conn->prepare("SELECT * FROM Product_Type WHERE prodType_enable = '2' and prodType_level = '1' and prodType_ref_id = '$res[prodType_id]' ");
        //     $stmt_sub->execute();
        //     $result_sub = $stmt_sub->get_result();
        //     if($result_sub->num_rows > 0){
        //       while($res_sub = $result_sub->fetch_assoc()){
        //         array_push($response,$res['prodType_name'] ." -> ". $res_sub['prodType_name']);
        //       }
        //     }
        //   }
        // }
        // return $response;
    }

    /*** ค่าเงิน ***/
    public function getCurrency() {
        $stmt = $this->conn->prepare("SELECT * FROM Currency");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }
    /*** ประเภทความผิด ***/
    public function IncorrectType() {
        $stmt = $this->conn->prepare("SELECT * FROM Incorrect_Type where incType_enable = '1' ");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }

    /*** logout ***/
    public function logout($user_id,$device_uuid,$device_platform) {
        if ($device_uuid == "") {
          return true;
        }
        $stmt = $this->conn->prepare("UPDATE Device_regis set device_uuid_logout = '$device_uuid',device_uuid ='' WHERE device_uuid = '$device_uuid' ");
        $result=$stmt->execute();
        if ($result) {
          return true;
        }else{
          return null;
        }

        // $stmt = $this->conn->prepare("SELECT * FROM version_app WHERE version_build = ?");
        // $stmt->bind_param("s", $build);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // if($result->num_rows > 0){
        //   $stmt->close();
        //   return $result;
        // }else{
        //   $stmt->close();
        //   return NULL;
        // }
    }

    /*** เช็คเวอร์ชั่นแอพ ***/
    public function checkVersionUpdate($build) {
        $stmt = $this->conn->prepare("SELECT * FROM version_app WHERE version_build = ?");
        $stmt->bind_param("s", $build);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }


    /*** ลงทะเบียน noti ***/
    public function RegisNoti($user_id,$device_uuid,$device_platform) {

        // $stmt = $this->conn->prepare("SELECT count(device_uuid) AS num_deviceId FROM Device_regis WHERE device_uuid='$device_uuid' AND member_id = '$user_id' ");
        $stmt = $this->conn->prepare("SELECT count(device_uuid) AS num_deviceId FROM Device_regis WHERE device_uuid='$device_uuid' ");
        $stmt->execute();
        $result = $stmt->get_result();
				$res    = $result->fetch_assoc();
        $num_deviceId = $res["num_deviceId"];

        $stmt = $this->conn->prepare("UPDATE Device_regis SET device_login_status = '0' WHERE member_id='$user_id'");
        $stmt->execute();
    		if($num_deviceId==0){
          $stmt = $this->conn->prepare("INSERT Device_regis(device_uuid,member_id,device_platform,device_registerDt,device_visitedDt,device_login_status)
          VALUES('$device_uuid','$user_id','$device_platform',NOW(),NOW(),'1') ");
          $objQuery1 = $stmt->execute();
    		}else{
          $stmt = $this->conn->prepare("UPDATE Device_regis SET device_visitedDt=NOW() , device_login_status='1', member_id = '$user_id' WHERE device_uuid='$device_uuid' ");
          $objQuery1 = $stmt->execute();
    		}


        ///   ไม่มี user ให้ insert
        // $stmt = $this->conn->prepare("SELECT count(device_uuid) AS num_deviceId FROM Device_regis WHERE device_uuid='$device_uuid' ");
        // $stmt->execute();
        // $result = $stmt->get_result();
				// $res    = $result->fetch_assoc();
        // $num_deviceId = $res["num_deviceId"];
        // if($num_deviceId==0){
        //   $stmt = $this->conn->prepare("INSERT Device_regis(device_uuid,member_id,device_platform,device_registerDt,device_visitedDt,device_login_status)
        //   VALUES('$device_uuid','','$device_platform',NOW(),NOW(),'1') ");
        //   $objQuery1 = $stmt->execute();
        // }else {
        //   # code...
        //   $objQuery1 = true;
        // }



        if($objQuery1){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }




    /*** รายการองค์ความรู้ ***/
    public function getKnowledge($limit,$offset,$filter,$sort) {

        $filtersql = $this->func->filter_sql($filter);
        $limitsql  = $this->func->limit_sql($limit,$offset);
        $sortsql   = $this->func->sort_sql($sort);

        // $stmt = $this->conn->prepare("SELECT case_id,caseDtl_title,prodType_name,compType_name FROM `Case` a
        //   LEFT JOIN Product_Type b ON a.prodType_id = b.prodType_id
        //   LEFT JOIN Complaint_Type c ON a.compType_id = c.compType_id
        //   WHERE case_knowledge_type = '1' and ".$filtersql.$sortsql.$limitsql);

        $stmt = $this->conn->prepare("select case_id,caseDtl_title,b.prodType_name,compType_name,d.incType_id,d.incType_name,d.incType_name_en from Case_Knowledge a
        left JOIN Product_Type b on a.prodType_id=b.prodType_id
        left JOIN Complaint_Type c on a.compType_id = c.compType_id
        left JOIN Incorrect_Type d on a.incType_id = d.incType_id
        where caseKnlg_status = '1' and caseKnlg_enable='1' ".$filtersql.$sortsql.$limitsql);

        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }



    /*** องค์ความรู้ ***/
    public function getIdKnowledge($knowledge_id) {
        $stmt = $this->conn->prepare("SELECT case_id,caseDtl_title,prodType_name,compType_name,curren_name,caseDtl_derivation,caseDtl_damage_val,caseDtl_complnt_need,
          case_close_resultProcess,compTypeSub1_name,f.incType_id,f.incType_name,f.incType_name_en FROM `Case` a
          LEFT JOIN Product_Type b ON a.prodType_id = b.prodType_id
          LEFT JOIN Complaint_Type c ON a.compType_id = c.compType_id
          LEFT JOIN Currency d ON a.curren_id = d.curren_id
          LEFT JOIN Complaint_Type_Sub1 e ON a.compTypeSub1_id = e.compTypeSub1_id
          LEFT JOIN Incorrect_Type f on a.incType_id = f.incType_id
           WHERE case_knowledge_type = '1' AND case_id = '$knowledge_id' ");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $stmt->close();
          return $result;
        }else{
          $stmt->close();
          return NULL;
        }
    }

    /*** ประเภทเรื่องร้องเรียน ***/
    public function getTypeComplaint() {
        $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type WHERE compType_status = '0' ");
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"compType_id" => $res['compType_id'],
              "compType_name" => $res['compType_name'],
              "compType_name_en" => $res['compType_name_en'],
              "levelmenu" => 1
  					);
  					$output[]=$response;
  					$id[]= $res['compType_id'];
  				}
          $response = array();
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub1 WHERE compType_id ='$id[$key]' and compTypeSub1_status = '0' ");
            $stmt->execute();
            $result2 = $stmt->get_result();
  					while($res2 = $result2->fetch_assoc())
  					{
    					$response = array(
    						"compTypeSub1_id" => $res2['compTypeSub1_id'],
                "compTypeSub1_name" => $res2['compTypeSub1_name'],
                "compTypeSub1_name_en" => $res2['compTypeSub1_name_en'],
    					);
    					$output3[]=$response;
              $id2[]= $res2['compTypeSub1_id'];
    					$output[$key]['compType_Sub1'] = $output3 ;
              $output[$key]['levelmenu']=2;
  					}
  					$output3 = array();
            $response = array();
            foreach ($output[$key]['compType_Sub1'] as $key2 => $product) {
              $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub1_id ='$id[$key]' and compTypeSub2_status = '0' ");
              $stmt->execute();
              $result3 = $stmt->get_result();
    					while($res3 = $result3->fetch_assoc())
    					{
      					$response = array(
      						"compTypeSub2_id" => $res3['compTypeSub2_id'],
                  "compTypeSub2_name" => $res3['compTypeSub2_name'],
                  "compTypeSub2_name_en" => $res3['compTypeSub2_name_en'],
      					);
      					$output4[]=$response;
      					$output[$key]['compType_Sub1'][$key2]['compType_Sub2'] = $output4 ;
                $output[$key]['levelmenu']=3;
    					}
    					$output4 = array();
    				}

  				}
          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
    }


    /*** เช็ค user จาก apikey ***/
    public function isValidApiKey($api_key) {
        $stmt = $this->conn->prepare("SELECT member_id from Member WHERE member_api_key = '$api_key' ");
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    /*** สร้าง Message ***/
    public function createMessage($user_id,$case_id, $message_detail,$message_img) {
        //Message_Box
        $stmt = $this->conn->prepare("INSERT INTO Message_Box (msgBoxRef_id,msgBox_type,case_id,sender_id,sender_type,msgBox_message,msgBox_datetime,msgBox_status)
        VALUES('0','1','".$case_id."','".$user_id."','1','".$message_detail."',now(),'0')");
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            $new_message_id = $this->conn->insert_id;
            // message_log
            $sqlAssign = $this->conn->prepare("SELECT * FROM Case_Assign WHERE  caseAsign_status = '0' and case_id = '".$case_id."'");
            $sqlAssign->execute();
            $resultAssign = $sqlAssign->get_result();
            if($resultAssign->num_rows > 0){
              while($data= $resultAssign->fetch_assoc()){
                      $sqlAss=$this->conn->prepare("INSERT INTO Message_Box_Log(msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime) VALUES(".$new_message_id.",".$data['emp_id'].",'2',now())");
                      $resAssign= $sqlAss->execute();
                      $sqlAss->close();
               }
                if ($resAssign) {
                  if (sizeof($message_img)>0) {
                    # code...
                      for ($i=0; $i < sizeof($message_img); $i++) {
                        $textreturn = $this->func->check_baseimg_ext($message_img[$i]['base64']);
                               $today = date("Y-m-d-H-i-s").rand(11111,99999);
                               $msgBoxAttach_file_name = "caseAttach_file_".$new_message_id."_".$today.".".$textreturn['ext'];
                               $path = "data/msg_attach/".$new_message_id."/".$msgBoxAttach_file_name;
                               $success = $this->func->uploadfilemessage($message_img[$i]['base64'], "msg_attach" , $new_message_id,$msgBoxAttach_file_name);
                               $stmt = $this->conn->prepare("INSERT INTO Message_Box_Attachfile (msgBox_id,msgBoxAttach_title,msgBoxAttach_file_path,msgBoxAttach_file_oldname,msgBoxAttach_file_name,msgBoxAttach_file_ext,msgBoxAttach_status,msgBoxAttach_create_datetime,msgBoxAttach_createBy_id) VALUES(".$new_message_id.",'".$message_img[$i]['name_file_change']."','".$path."','".$message_img[$i]['name_file_ori']."','".$msgBoxAttach_file_name."','".$textreturn['ext']."','0',now(),'".$user_id."')");
                               $res = $stmt->execute();
                               $stmt->close();
                      }
                      if ($res) {
                        return $res;
                      }else{return null;}

                    }else{
                      return truel;
                    }

                }else{
                   return null;
                }
            }




            //   while($data= $resultAssign->fetch_assoc()){
            //          $sql=$this->conn->prepare("INSERT INTO Message_Box_Log (msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime)
            //          VALUES($new_message_id,$data['emp_id'],'2',now())");
            //          $resAssign= $sql->execute();
            //   }
            //   if ($resAssign) {
            //       // Message_Box_Attachfile
            //     for ($i=0; $i < sizeof($message_img); $i++) {
            //         $textreturn = $this->func->check_baseimg_ext($message_img[$i]['base64']);
            //         $today = date("Y-m-d-H-i-s").rand(11111,99999);
            //         $msgBoxAttach_file_name = "caseAttach_file_".$new_message_id."_".$today.".".$textreturn['ext'];
            //         $path = "data/msg_attach/".$new_message_id."/".$msgBoxAttach_file_name;
            //         $success = $this->func->uploadfilemessage($message_img[$i]['base64'], "msg_attach" , $new_message_id,$msgBoxAttach_file_name);
            //         $stmt = $this->conn->prepare("INSERT INTO Message_Box_Attachfile (msgBox_id,msgBoxAttach_title,msgBoxAttach_file_path,msgBoxAttach_file_oldname,msgBoxAttach_file_name,msgBoxAttach_file_ext,msgBoxAttach_status,msgBoxAttach_create_datetime,msgBoxAttach_createBy_id) VALUES(".$new_message_id.",'".$message_img[$i]['name_file_change']."','".$path."','".$message_img[$i]['name_file_ori']."','".$msgBoxAttach_file_name."','".$textreturn."','0',now(),'".$user_id."')");
            //         $res = $stmt->execute();
            //         $stmt->close();
            //     }
            //
            //     if ($res) {
            //         return $success;
            //     } else {
            //         return NULL;
            //     }
            //   }else{
            //     return NULL;
            //   }
            // }else{
            //   return NULL;
            // }
            // //$res = $this->createUserTask($user_id, $new_task_id);
            // return $result;
        } else {
            return NULL;
        }
    }


    /***  MessageReply ***/
    public function MessageReply($user_id,$case_id, $message_detail,$message_img,$message_id) {
        //Message_Box
        $stmt = $this->conn->prepare("INSERT INTO Message_Box (msgBoxRef_id,msgBox_type,case_id,sender_id,sender_type,msgBox_message,msgBox_datetime,msgBox_status)
        VALUES(".$message_id.",'2','".$case_id."','".$user_id."','1','".$message_detail."',now(),'0')");
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {

            $new_message_id = $this->conn->insert_id;
            // message_log
            $sqlAssign = $this->conn->prepare("SELECT * FROM Case_Assign WHERE  caseAsign_status = '0' and case_id = '".$case_id."'");
            $sqlAssign->execute();
            $resultAssign = $sqlAssign->get_result();
            if($resultAssign->num_rows > 0){
              while($data= $resultAssign->fetch_assoc()){
                      $sqlAss=$this->conn->prepare("INSERT INTO Message_Box_Log(msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime) VALUES(".$new_message_id.",".$data['emp_id'].",'2',now())");
                      $resAssign= $sqlAss->execute();
                      $sqlAss->close();
               }
                if ($resAssign) {
                  if (sizeof($message_img)>0) {
                    # code...
                      for ($i=0; $i < sizeof($message_img); $i++) {
                        $textreturn = $this->func->check_baseimg_ext($message_img[$i]['base64']);
                               $today = date("Y-m-d-H-i-s").rand(11111,99999);
                               $msgBoxAttach_file_name = "caseAttach_file_".$new_message_id."_".$today.".".$textreturn['ext'];
                               $path = "data/msg_attach/".$new_message_id."/".$msgBoxAttach_file_name;
                               $success = $this->func->uploadfilemessage($message_img[$i]['base64'], "msg_attach" , $new_message_id,$msgBoxAttach_file_name);
                               $stmt = $this->conn->prepare("INSERT INTO Message_Box_Attachfile (msgBox_id,msgBoxAttach_title,msgBoxAttach_file_path,msgBoxAttach_file_oldname,msgBoxAttach_file_name,msgBoxAttach_file_ext,msgBoxAttach_status,msgBoxAttach_create_datetime,msgBoxAttach_createBy_id) VALUES(".$new_message_id.",'".$message_img[$i]['name_file_change']."','".$path."','".$message_img[$i]['name_file_ori']."','".$msgBoxAttach_file_name."','".$textreturn['ext']."','0',now(),'".$user_id."')");
                               $res = $stmt->execute();
                               $stmt->close();
                      }
                      if ($res) {
                        return $res;
                      }else{return null;}

                    }else{
                      return truel;
                    }

                }else{
                   return null;
                }
            }

        } else {
            return NULL;
        }
    }


    /*** สร้าง Complaint ***/
    public function createComplaint($request_post,$compType_id,$compTypeSub1_id,$compTypeSub2_id,$case_status,$case_assign_status,$caseCh_id,$case_priority,$case_receivedoc_real_datetime,
    $case_disKPI_status,$caseDtl_title,$prodType_id,$caseDtl_derivation,$caseDtl_damage_val,$curren_id,$caseDtl_complnt_need,
    $applnt_ident,$applntOrg_trade_number,$applnt_firstname,$applnt_type,$applnt_ident_valid,$applnt_status,$complnt_trade_number,
    $complnt_name,$complnt_backlist,$applnt_valid_dbd,$applnt_valid_ditp,$case_receivedoc_date,$case_createBy_id,$applnt_lastname,$applntOrg_name,
    $applnt_country_id,$complnt_country_id,$case_create_datetime,$complnt_file,$user_id,$incType_id,$applntOrg_country_id,$complnt_import_export,$applntOrg_branch,$applntOrg_tel,$applntOrg_fax,
    $applnt_gender,$applnt_career,$applnt_mobile,$applnt_email,$applnt_address,$applntOrg_prov_id,$applntOrg_zipcode,$complnt_branch,
    $complnt_contact_tel,$complnt_contact_email,$complnt_contact_address,$complnt_contact_prov_id,$complnt_zipcode,$complnt_contact_name,$applntOrg_name0,$applntOrg_trade_number0) {

        mysqli_begin_transaction($this->conn);

        $stmt = $this->conn->prepare("INSERT INTO `Case`(compType_id,compTypeSub1_id,compTypeSub2_id,case_status,case_assign_status,caseCh_id,case_priority,case_receivedoc_real_datetime,
        case_disKPI_status,caseDtl_title,prodType_id,caseDtl_derivation,caseDtl_damage_val,curren_id,caseDtl_complnt_need,
        applnt_ident,applntOrg_trade_number,applnt_firstname,applnt_type,applnt_ident_valid,applnt_status,complnt_trade_number,
        complnt_name,complnt_backlist,applnt_valid_dbd,applnt_valid_ditp,case_receivedoc_date,case_createBy_id,applnt_lastname,applntOrg_name,
        applnt_country_id,complnt_country_id,case_create_datetime,incType_id,applntOrg_country_id, case_compType_duration) VALUES('$compType_id','$compTypeSub1_id','$compTypeSub2_id','$case_status','$case_assign_status','$caseCh_id','$case_priority','$case_receivedoc_real_datetime','
        $case_disKPI_status','$caseDtl_title','$prodType_id','$caseDtl_derivation','$caseDtl_damage_val','$curren_id','$caseDtl_complnt_need','
        $applnt_ident','$applntOrg_trade_number','$applnt_firstname','$applnt_type','$applnt_ident_valid','$applnt_status','$complnt_trade_number','
        $complnt_name','$complnt_backlist','$applnt_valid_dbd','$applnt_valid_ditp','$case_receivedoc_date','$case_createBy_id','$applnt_lastname','$applntOrg_name',
        '$applnt_country_id','$complnt_country_id','$case_create_datetime','$incType_id','$applntOrg_country_id', (select compType_duration from `Complaint_Type` where compType_id = '$compType_id'))");
        $result = $stmt->execute();
        //$stmt->close();
        if ($result) {
            $caseid = $this->conn->insert_id;
            foreach ($request_post as $key => $value) {
              $res = $this->createComplaintField($key, $value, $caseid,$request_post['formSetId_P']);
            }

            $n = 0;
            foreach ($complnt_file as $key => $value) {
              $nameiamge = time();
              $nameiamge=$nameiamge.$n++;
              $textreturn = $this->func->check_baseimg_ext($value['base64']);
              $namefile = 'caseAttach_file_'.$caseid.'_'.$nameiamge.'.'.$textreturn['ext'];
        			$uploadFileNew = $this->func->create_folder('case_attach',$caseid,'/',$namefile,"2"); //caseAttach_file_6_1492771842
              $success = file_put_contents($uploadFileNew, $textreturn['url']);
              if($success){
                  $stmt = $this->conn->prepare("INSERT INTO Case_Attachfile(
                    case_id,caseAttach_title,caseAttach_file_path,caseAttach_file_oldname,
                    caseAttach_file_name,caseAttach_file_ext,caseAttach_status,
                    caseAttach_create_datetime,caseAttach_createBy_id)
                  VALUES('$caseid','$value[name_file_change]','data/case_attach/$caseid/$namefile','$value[name_file_ori]',
                  '$namefile','$textreturn[ext]','0',NOW(),'$user_id')");
                  $result3 = $stmt->execute();
                  if($result3){
                    mysqli_commit($this->conn);
                  }
              }
            }

            //   หาคนที่สร้าง case เป็นนิติบุคคลหรือคนทั่วไป

            $stmtMemberType = $this->conn->prepare("SELECT a.member_type, a.member_business, b.member_comp_type from Member a left join Member_comp b on a.member_id=b.member_id WHERE a.member_id = '$case_createBy_id' ");
            $stmtMemberType->execute();
            $resMemberType = $stmtMemberType->get_result()->fetch_assoc();
            $ValueMemberType = $resMemberType['member_type'];

            /*if($applntOrg_country_id == "" && isset($complnt_country_id)){
              $cpr_type = 2;
            }else{
              $cpr_type = 1;
            }*/
            $cpr_type = 1;
            $cpr_comp_type = 1;

            $cpr_section = $this->conn->prepare("SELECT compType_section from Complaint_Type  WHERE compType_id = $compType_id");
            $cpr_section->execute();
            $resultcpr_section = $cpr_section->get_result()->fetch_assoc();
            $Valuecpr_section = $resultcpr_section['compType_section'];
            $cpr_contactfname = $applnt_firstname;
            $cpr_contactlname = $applnt_lastname;

            /******/

            $cpr_numbertrade = $applntOrg_trade_number;
            $cpr_companyname = $applntOrg_name;
            $cpr_type_import_export = $resMemberType['member_business'];

            $cpr_branch = $applntOrg_branch;
            $cpr_telephone = $applntOrg_tel;
            $cpr_fax = $request_post['applntOrg_fax'];
            $cpr_email = $request_post['applnt_email'];
            $cpr_address = $request_post['applntOrg_address'];
            $prov_id = $request_post['prov_id'];
            $cpr_zipcode = $request_post['applntOrg_zipcode'];
            $cpr_department = $resMemberType['member_type'];

            $Country_id = $applnt_country_id;
            $cpr_contact_person = $applnt_firstname." ".$applnt_lastname;
            $cpr_import = 0;
            $cpr_create_datetime = date("Y-m-d H:i:s");
            $cpr_createBy_id = $case_createBy_id;
            $cpr_update_datetime = date("Y-m-d H:i:s");
            $cpr_updateBy_id = $case_createBy_id;
            $cpr_status = "0";


            if($applntOrg_trade_number == "" && isset($applntOrg_trade_number)){
              $sqltem = "and cpr_companyname = '$cpr_companyname' ";
            }else{
              $sqltem = "and cpr_numbertrade = '$applntOrg_trade_number' ";
            }

            $stmtCorporateCheck = $this->conn->prepare("SELECT cpr_id from Corporate WHERE
              cpr_section = ".$Valuecpr_section." and
              cpr_type = '$cpr_type' and
              cpr_comp_type	= '$cpr_comp_type'  ".$sqltem);

            $stmtCorporateCheck->execute();
            $resultCorporateCheck = $stmtCorporateCheck->get_result();

            /*****/
            //$applnt_ident = $applntOrg_trade_number;

            //ถ้าเป็น ผู้ประกอบการในต่างประเทศร้องเรียนผู้ประกอบการในไทย
            if($compTypeSub1_id == 6 || ($compTypeSub1_id == 1 && $applnt_country_id == '162') || ( $compTypeSub1_id == 2 && $applnt_country_id != '162' )){
            //if($compTypeSub1_id != 1){
              // END หาคนที่สร้าง case เป็นนิติบุคคลหรือคนทั่วไป
              // 0=คนทั่วไป,1=ตัวแทนบริษัท
              if($ValueMemberType == 1){
                // echo "ตัวแทนบริษัท";
                if($resultCorporateCheck->num_rows == 0){
                   ////// insert //////
                   $resultInsertCorlv1 = $this->insertCorporate($Valuecpr_section,$cpr_type,$cpr_comp_type,
                   $cpr_numbertrade,$cpr_companyname,$cpr_type_import_export,
                   $cpr_branch,$cpr_telephone,$cpr_fax,
                   $cpr_email,$cpr_address,$prov_id,
                   $cpr_zipcode,$cpr_department,$cpr_contactfname,
                   $cpr_contactlname,$Country_id,$cpr_contact_person,
                   $cpr_import,$cpr_create_datetime,$cpr_createBy_id,$cpr_status);

                }else{
                   /////// UPDATE ///////
                  $resultCorporateCheck = $resultCorporateCheck->fetch_assoc();
                  $resultcpr_id = $resultCorporateCheck['cpr_id'];
                  $resultInsertCorlv2 = $this->updateCorporate($Valuecpr_section,$cpr_type,
                  $cpr_comp_type,$cpr_numbertrade,$cpr_companyname,
                  $cpr_type_import_export,$cpr_branch,$cpr_telephone,
                  $cpr_fax,$cpr_email,$cpr_address,
                  $prov_id,$cpr_zipcode,$cpr_department,
                  $cpr_contactfname,$cpr_contactlname,$Country_id,
                  $cpr_contact_person,$cpr_import,$cpr_update_datetime,$cpr_updateBy_id,$cpr_status,$resultcpr_id);

                }

              }else if($ValueMemberType == 0){
                // echo "คนทั่วไป";

                if($applnt_ident == "" && isset($applnt_ident)){
                  $sqltem = "and ct_firstname = '$cpr_contactfname' and ct_lastname = '$cpr_contactlname' ";
                }else{
                  $sqltem = "and ct_card = '$applnt_ident' ";
                }

                $stmtCorporateCheck = $this->conn->prepare("SELECT ct_id from Contact_thai WHERE
                  ct_section = ".$Valuecpr_section." and
                  ct_type = '$cpr_type' and
                  ct_department = '1' and
                  ct_comp_type	= '$cpr_comp_type'  ".$sqltem);

                $stmtCorporateCheck->execute();
                $resultCorporateCheck = $stmtCorporateCheck->get_result();

                if($resultCorporateCheck->num_rows == 0){
                   ////// insert //////
                   $resultInsertCorlv1 = $this->insertContact_thai($Valuecpr_section,$cpr_type,'1',$cpr_comp_type,
                   $applnt_ident,$cpr_contactfname,$cpr_contactlname,$applnt_gender,$applnt_career,$applnt_mobile,
                   $applnt_email,$applnt_address,$applntOrg_prov_id,$applntOrg_zipcode,$applnt_country_id,$case_createBy_id);

                }else{
                   /////// UPDATE ///////
                  $resultCorporateCheck = $resultCorporateCheck->fetch_assoc();
                  $resultcpr_id = $resultCorporateCheck['ct_id'];

                  $sql = "UPDATE `Contact_thai` SET
                  ct_section='$Valuecpr_section',
                  ct_type='$cpr_type',
                  ct_comp_type='$cpr_comp_type',
                  ct_card='$applnt_ident',
                  ct_firstname='$cpr_contactfname',
                  ct_lastname='$cpr_contactlname',
                  ct_sex='$applnt_gender',
                  ct_career='$applnt_career',
                  ct_cellphone='$applnt_mobile',
                  ct_email='$applnt_email',
                  ct_address='$applnt_address',
                  prov_id='$applntOrg_prov_id',
                  ct_postcode='$applntOrg_zipcode',
                  Country_id='$applnt_country_id',
                  ct_update_datetime=NOW(),
                  ct_updateBy_id='$case_createBy_id'
                  WHERE ct_id= '$resultcpr_id'";
                  $stmt = $this->conn->prepare($sql);
                  $stmt->execute();
                }
              }
            }else{
              $cpr_type = '2';
              $cpr_contactfname = '';
              $cpr_contactlname = '';
              $cpr_contact_person = '';
              $cpr_email = '';
              $cpr_numbertrade = $applntOrg_trade_number0;
              $cpr_companyname = $applntOrg_name0;
              $Country_id = $applntOrg_country_id;
              $cpr_department = 0;
              $cpr_type_import_export = 0;
              $my_array_data = json_decode($complnt_contact_prov_id, TRUE);
              $value_prov_id = $my_array_data['province_id'];

              if($cpr_numbertrade == "" && isset($cpr_numbertrade)){
                $sqltem = "and cpr_companyname = '$cpr_companyname' ";
              }else{
                $sqltem = "and cpr_numbertrade = '$cpr_numbertrade' ";
              }

              $stmtCorporateCheck = $this->conn->prepare("SELECT cpr_id from Corporate WHERE
                cpr_section = ".$Valuecpr_section." and
                cpr_type = '$cpr_type' and
                cpr_comp_type	= '$cpr_comp_type'  ".$sqltem);

              $stmtCorporateCheck->execute();
              $resultCorporateCheck = $stmtCorporateCheck->get_result();

              if($resultCorporateCheck->num_rows == 0){
                 ////// insert //////
                 $resultInsertCorlv1 = $this->insertCorporate($Valuecpr_section,$cpr_type,$cpr_comp_type,
                 $cpr_numbertrade,$cpr_companyname,$cpr_type_import_export,
                 $cpr_branch,$cpr_telephone,$cpr_fax,$cpr_email,$cpr_address,$value_prov_id,
                 $cpr_zipcode,$cpr_department,$cpr_contactfname,
                 $cpr_contactlname,$Country_id,$cpr_contact_person,
                 $cpr_import,$cpr_create_datetime,$cpr_createBy_id,$cpr_status);

              }else{
                 /////// UPDATE ///////
                $resultCorporateCheck = $resultCorporateCheck->fetch_assoc();
                $resultcpr_id = $resultCorporateCheck['cpr_id'];
                $resultInsertCorlv2 = $this->updateCorporate($Valuecpr_section,$cpr_type,
                $cpr_comp_type,$cpr_numbertrade,$cpr_companyname,
                $cpr_type_import_export,$cpr_branch,$cpr_telephone,
                $cpr_fax,$cpr_email,$cpr_address,$value_prov_id,$cpr_zipcode,$cpr_department,
                $cpr_contactfname,$cpr_contactlname,$Country_id,
                $cpr_contact_person,$cpr_import,$cpr_update_datetime,$cpr_updateBy_id,$cpr_status,$resultcpr_id);

              }

            }

            // /*-----------------------      คนที่ถูกร้องเรียน      -----------------------*/
            // *

            $Ccpr_numbertrade = $complnt_trade_number;
            $Ccpr_companyname = $complnt_name;
            $Ccpr_type_import_export = $complnt_import_export;///*

            $Ccpr_branch = $complnt_branch;
            $Ccpr_telephone = $complnt_contact_tel;
            $Ccpr_fax = "";///*
            $Ccpr_email = $complnt_contact_email;
            $Ccpr_address = $complnt_contact_address;
            $Cprov_id = $complnt_contact_prov_id;

            $Ccpr_zipcode = $complnt_zipcode;
            $Ccpr_department = "";///*
            $Ccpr_contactfname = $complnt_contact_name;
            $Ccpr_contactlname = "";///*
            $CCountry_id = $complnt_country_id;///*
            $Ccpr_contact_person = $complnt_contact_name;
            $Ccpr_import = 0;
            $Ccpr_create_datetime = date("Y-m-d H:i:s");
            $Ccpr_createBy_id = $case_createBy_id;
            $Ccpr_update_datetime = date("Y-m-d H:i:s");
            $Ccpr_updateBy_id = $case_createBy_id;
            $Ccpr_status = "0";

            if($applntOrg_country_id == "" && isset($complnt_country_id)){
              $Ccpr_type = 2;
            }else{
              $Ccpr_type = 1;
            }
            $Ccpr_comp_type = 2;

            if($Valuecpr_section == 2){
              $Ccpr_type = 1;
            }
            //$Capplnt_ident = $applntOrg_trade_number;
            //$Ccpr_section = "SELECT compType_section from Complaint_Type  WHERE compType_id = '$compType_id'";

            if($Ccpr_numbertrade == "" && isset($Ccpr_numbertrade)){
              $sqltem = "and cpr_companyname = '$Ccpr_companyname' ";
            }else{
              $sqltem = "and cpr_numbertrade = '$Ccpr_numbertrade' ";
            }

            $stmtCorporateCheck = $this->conn->prepare("SELECT cpr_id from Corporate WHERE
              cpr_section = ".$Valuecpr_section." and
              cpr_type = '$Ccpr_type' and
              cpr_comp_type	= '$Ccpr_comp_type'  ".$sqltem);

            $stmtCorporateCheck->execute();
            $resultCorporateCheck = $stmtCorporateCheck->get_result();

            if($resultCorporateCheck->num_rows == 0){
               ////// insert //////
               $resultInsertCorlv2 = $this->insertCorporate($Valuecpr_section,$Ccpr_type,$Ccpr_comp_type,
               $Ccpr_numbertrade,$Ccpr_companyname,$Ccpr_type_import_export,
               $Ccpr_branch,$Ccpr_telephone,$Ccpr_fax,
               $Ccpr_email,$Ccpr_address,$Cprov_id,
               $Ccpr_zipcode,$Ccpr_department,$Ccpr_contactfname,
               $Ccpr_contactlname,$CCountry_id,$Ccpr_contact_person,
               $Ccpr_import,$Ccpr_create_datetime,$Ccpr_createBy_id,$Ccpr_status);

            }else{
               /////// UPDATE ///////
              $resultCorporateCheck = $resultCorporateCheck->fetch_assoc();
              $resultcpr_id = $resultCorporateCheck['cpr_id'];
              $resultInsertCorlv2 = $this->updateCorporate($Valuecpr_section,$Ccpr_type,
              $Ccpr_comp_type,$Ccpr_numbertrade,$Ccpr_companyname,
              $Ccpr_type_import_export,$Ccpr_branch,$Ccpr_telephone,
              $Ccpr_fax,$Ccpr_email,$Ccpr_address,
              $Cprov_id,$Ccpr_zipcode,$Ccpr_department,
              $Ccpr_contactfname,$Ccpr_contactlname,$CCountry_id,
              $Ccpr_contact_person,$Ccpr_import,$Ccpr_update_datetime,$Ccpr_updateBy_id,$Ccpr_status,$resultcpr_id);

            }



            // *
            // /*-----------------------      End คนที่ถูกร้องเรียน      ------------------*/


            if(count($complnt_file) < 1){
              mysqli_commit($this->conn);
            }

            if ($res) {
                return $caseid;
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }

    /*** เพิ่ม field ให้กับ case ***/
    public function createComplaintField($key, $value, $caseid,$formSetId_P) {
        $stmt = $this->conn->prepare("SELECT fieldset_id FROM Field_Set WHERE fieldset_name = '$key' and  frmset_id IN ($formSetId_P)");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
          $res2 = $result->fetch_assoc();
          if($key == "complnt_prov_id" && $value != ''){
            // $valuex = json_encode($value);
            // $b = json_decode( $valuex );
            // $value = $b->province_id;
            $my_array_data = json_decode($value, TRUE);
            $value = $my_array_data['province_id'];
          }
          $stmt = $this->conn->prepare("INSERT INTO Field_Values(case_id,fieldset_id,fieldset_value) VALUES('$caseid','$res2[fieldset_id]','$value')");
          $result = $stmt->execute();
          if (false === $result) {
              die('execute() failed: ' . htmlspecialchars($stmt->error));
          }
        }
        $stmt->close();
        return $result;
    }



    /*** แสดง complaint id ที่เลือก , complaint ของผู้ใช้เท่านั้น ***/
  public function getComplaint($user_id,$case_id) {

        // $stmt = $this->conn->prepare("SELECT * from `Case`  WHERE case_id = '$case_id' AND case_createBy_id = '$user_id' AND case_knowledge_type = '0' ");

        // $stmt = $this->conn->prepare("SELECT * from `Case` a INNER join `Incorrect_Type` b on a.incType_id=b.incType_id WHERE a.case_id = '$case_id' AND a.case_createBy_id = '$user_id' AND a.case_knowledge_type = '0'  ");

        $stmt = $this->conn->prepare("SELECT * from `Case` a left JOIN `Incorrect_Type` b
               on a.incType_id=b.incType_id WHERE a.case_id = '$case_id'
               AND a.case_createBy_id = '$user_id'  ");

        // echo "SELECT * from `Case` a left JOIN `Incorrect_Type` b
        //        on a.incType_id=b.incType_id WHERE a.case_id = '$case_id'
        //        AND a.case_createBy_id = '$user_id' AND a.case_knowledge_type = '0' ";
        //        exit();
        // $stmt = $this->conn->prepare("SELECT  * FROM `Case` a INNER JOIN Message_Noti_App b ON a.case_id = b.case_id where a.case_createBy_id = '$user_id' and a.case_id ='$case_id'  ");

        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $res = $result->fetch_assoc();
            $datespilt2 = explode (" ", $res["case_receivedoc_real_datetime"]);
            // if($res["case_status"] == "1"){
            //   $status = 1;$percen = 25;
            // }else if($res["case_status"] == "2"){
            //   $status = 2;$percen = 50;
            // }else if($res["case_status"] == "3"){
            //   $status = 4;$percen = 100;
            // }else{
            //   $status = 0;$percen = 0;
            // }

            if($res["case_status"] == "1"){
              $status = 1;$percen = 25;
            }else if($res["case_status"] == "2"){
              $res_status = $this->checkPercen($res["case_id"]);
              if($res_status == '1'){
                $status = 1;$percen = 25;
              }else if($res_status == '3'){
                $status = 3;$percen = 75;
              }else{
                $status = 2;$percen = 50;
              }
            }else if($res["case_status"] == "3"){
              $status = 4;$percen = 100;
            }else{
              $status = 0;$percen = 0;
            }

            // if($res["process_type_step"] == "1"){
            //   $status = 1;$percen = 25;
            // }else if($res["process_type_step"] == "2"){
            //   $status = 2;$percen = 50;
            // }else if($res["process_type_step"] == "3"){
            //   $status = 3;$percen = 75;
            // }else if($res["process_type_step"] == "4"){
            //   $status = 4;$percen = 100;
            // }else{
            //   $status = 0;$percen = 0;
            // }
            $response = array(
              "comp_id" => $res['case_id'],
              "comp_date" => $datespilt2[0],
              "comp_time" => $datespilt2[1],
              "comp_caseId" => $res["case_id"],
              "comp_resultProcess" => $res["case_close_resultProcess"],
              // "comp_status" => $res["process_type_step"],
              "comp_process" => $status,
              "comp_perces" => $percen,
              "compType_id" => $res["compType_id"],
              "incType_name" => $res["incType_name"],

            );
            $output[]=$response;
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * from Field_Values a LEFT JOIN Field_Set b ON a.fieldset_id = b.fieldset_id WHERE case_id = '$case_id' ");
            $stmt->execute();
            $result2 = $stmt->get_result();
            while($res2 = $result2->fetch_assoc())
            {
              if($res2['fieldset_name'] == 'complnt_country_id'){
                $stmt = $this->conn->prepare("SELECT name from Country  WHERE id = '$res2[fieldset_value]' ");
                // $res2['fieldset_name']='complnt_country_name';
                $stmt->execute();
                $res3 = $stmt->get_result()->fetch_assoc();
                $fieldValue = $res3['name'];
                $response = array(
                  "fieldset_id" => "",
                  "fieldset_name" => 'complnt_country_name',
                  "fieldset_value" => $fieldValue,
                );
                $output3[]=$response;
              }else if($res2['fieldset_name'] == 'prodType_id'){
                // prodType_id = 46
                $stmt = $this->conn->prepare("SELECT prodType_name from Product_Type  WHERE prodType_id = '$res2[fieldset_value]' ");
                $stmt->execute();
                $res3 = $stmt->get_result()->fetch_assoc();
                $fieldValue = $res3['prodType_name'];
              }else if($res2['fieldset_name'] == 'curren_id'){
                $stmt = $this->conn->prepare("SELECT curren_name from Currency  WHERE curren_id = '$res2[fieldset_value]' ");
                $stmt->execute();
                $res3 = $stmt->get_result()->fetch_assoc();
                $fieldValue = $res3['curren_name'];
              }else{
                $fieldValue = $res2['fieldset_value'];
              }
            $response = array(
              "fieldset_id" => $res2['fieldset_id'],
              "fieldset_name" => $res2['fieldset_name'],
              "fieldset_value" => $fieldValue,
            );
            $output3[]=$response;
  					$output[$key]['comp_chos'] = $output3 ;
  					}
  					$output3 = array();

            $stmt = $this->conn->prepare("SELECT * from Case_Attachfile WHERE case_id = '$case_id' ");
            $stmt->execute();
            $result3 = $stmt->get_result();
            while($res3 = $result3->fetch_assoc())
            {
              $response = array(
                "caseAttach_id" => $res3['caseAttach_id'],
                "caseAttach_file_path" => BASE_URL.$res3['caseAttach_file_path'],
                "caseAttach_title" => $res3['caseAttach_title'],
                "caseAttach_file_name" => $res3['caseAttach_file_name']
              );
              $output4[]=$response;
    					$output[$key]['comp_attach'] = $output4 ;
  					}
  					$output4 = array();

          }

          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
  }




    /*** แสดง complaint ทั้งหมด , complaint ของผู้ใช้เท่านั้น ***/
    public function getAllUserComplaint($user_id,$limit,$offset,$filter,$sort) {

      $filtersql = $this->func->filter_sql($filter);
      $limitsql  = $this->func->limit_sql($limit,$offset);
      $sortsql   = $this->func->sort_sql($sort);

      $stmt = $this->conn->prepare("SELECT a.case_id, a.case_status , a.case_receivedoc_real_datetime,a.caseDtl_title FROM `Case` a WHERE  a.case_createBy_id = '$user_id' AND (a.caseCh_id = '1' or a.caseCh_id = '2') ".$filtersql.$sortsql.$limitsql);

        $stmt->execute();
        $result = $stmt->get_result();
        // array_push($result,$sql);
       if($result->num_rows > 0){
         $stmt->close();
         return $result;
       }else{
         $stmt->close();
         return NULL;
       }
    }

    /*** แสดง complaint อย่างละ 2  , complaint ของผู้ใช้เท่านั้น ***/
    public function getComplaintType2($user_id) {

        //
        $stmt = $this->conn->prepare("
        (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
         WHERE  case_createBy_id = '$user_id'  AND case_status = '0' and (caseCh_id ='1' or caseCh_id='2')
         ORDER BY case_id DESC LIMIT 2)
         UNION
         (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
         WHERE  case_createBy_id = '$user_id'  AND (case_status = '1' OR case_status = '2') and (caseCh_id ='1' or caseCh_id='2')
         ORDER BY `Case`.case_id DESC LIMIT 2)
         UNION
         (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
         WHERE  case_createBy_id = '$user_id'  AND case_status = '3' and (caseCh_id ='1' or caseCh_id='2')
         ORDER BY case_id DESC LIMIT 2)");
        //
        // $stmt = $this->conn->prepare("
        // (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
        // WHERE  case_createBy_id = '$user_id' AND  case_status = '0'
        // ORDER BY case_id DESC LIMIT 2)
        // UNION
        // (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
        // WHERE  case_createBy_id = '$user_id' AND  (case_status = '1' OR case_status = '2')
        // ORDER BY case_id DESC LIMIT 2)
        // UNION
        // (SELECT case_id,case_status,case_receivedoc_real_datetime,caseDtl_title FROM `Case`
        // WHERE  case_createBy_id = '$user_id' AND  AND case_status = '3'
        // ORDER BY case_id DESC LIMIT 2)");

        $stmt->execute();
        $result = $stmt->get_result();

       if($result->num_rows > 0){
         $stmt->close();
         return $result;

       }else{
         $stmt->close();
         return NULL;
       }
    }


    /*** แสดง badge ทั้งหมด , badge ของผู้ใช้เท่านั้น ***/
    public function getAllBadge($user_id) {

      // $stmt = $this->conn->prepare("SELECT noti_id FROM `Case` a INNER JOIN Log_Notification b ON a.case_id = b.case_id WHERE case_createBy_id = '$user_id' AND caseCh_id = '1' AND noti_status = '0' AND noti_read = '0' ");
        $stmt = $this->conn->prepare("SELECT case_id FROM `Message_Noti_App` where msgNotiApp_noti_status = '0' and msgNoti_status='0' and member_id='$user_id' ");
        $stmt->execute();
        $result = $stmt->get_result();
       if($result->num_rows > 0){
         $stmt->close();
         return $result->num_rows;
       }else{
         $stmt->close();
         return NULL;
       }
    }

    /*** แสดง notification ทั้งหมด , notification ของผู้ใช้เท่านั้น ***/
    public function getAllUserNoti($user_id,$limit,$offset,$filter,$sort) {

        $filtersql = $this->func->filter_sql($filter);
        $limitsql  = $this->func->limit_sql($limit,$offset);
        $sortsql   = $this->func->sort_sql($sort);


        // $stmt = $this->conn->prepare("SELECT noti_id,a.case_id,caseDtl_title,noti_datetime,noti_type,noti_read FROM `Case` a INNER JOIN Log_Notification b ON a.case_id = b.case_id WHERE case_createBy_id = '$user_id' AND caseCh_id = '1' AND noti_status = '0' ".$filtersql.$sortsql.$limitsql);
        // $stmt = $this->conn->prepare("SELECT noti_id,a.case_id,caseDtl_title,noti_datetime,noti_type,noti_read FROM `Case` a  WHERE case_createBy_id = '$user_id' AND caseCh_id = '1' AND noti_status = '0' ".$filtersql.$sortsql.$limitsql);


        // $stmt = $this->conn->prepare("SELECT * FROM `Case` a INNER JOIN Message_Noti_App b ON a.case_id = b.case_id WHERE a.case_createBy_id = '$user_id' AND a.caseCh_id = '1' ".$filtersql.$sortsql.$limitsql);

        $stmt = $this->conn->prepare("SELECT  *,(select process_type_step FROM
              Process c INNER JOIN Process_Type d on c.process_type_id=d.process_type_id
              where c.case_id = a.case_id
              order by c.process_id desc
              limit 1) as process_type_step FROM `Case` a
              INNER JOIN Message_Noti_App b ON a.case_id = b.case_id
              where a.case_createBy_id = '$user_id' ".$filtersql." and msgNoti_status='0'
              order by msgNotiApp_datetime desc ".$limitsql);



        $stmt->execute();
        $result = $stmt->get_result();

        //
        // $stmt = $this->conn->prepare("SELECT process_type_step as countStatus FROM Process a LEFT JOIN Process_Type b ON a.process_type_id=b.process_type_id WHERE case_id = '$case_id' order by a.process_id desc limit 1 ");

        //
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $tmp = array();
        // $tmp2 = array();
        // if($result->num_rows > 0){
        // while($res = $result->fetch_assoc()){
        //     $stmt1 = $this->conn->prepare("
        //       select process_type_step FROM
        //       Process c INNER JOIN Process_Type d on c.process_type_id=d.process_type_id
        //       where c.case_id = '$res[case_id]'
        //       order by c.process_id desc
        //       limit 1
        //     ");
        //     $stmt1->execute();
        //     // $tmp2 = $stmt1->get_result();
        //     $tmp2 = $stmt1->get_result()->fetch_assoc();
        //     //
        //     // $tmp["msgNotiApp_id"] = $res["msgNotiApp_id"];
        //     // $tmp["msgNotiApp_datetime"] = $res['msgNotiApp_datetime'];
        //     // $tmp["msgNotiApp_step"] = $res["msgNotiApp_step"];
        //     // $tmp["msgNotiApp_read_status"] = $res["msgNotiApp_read_status"];
        //     // $tmp["case_id"] = $res["case_id"];
        //     // $tmp["process_type_step"]=$tmp2;
        //
        //     $tmp[] = array(
        //       "msgNotiApp_id" => $res["msgNotiApp_id"],
        //       "msgNotiApp_datetime" => $res['msgNotiApp_datetime'],
        //       "msgNotiApp_step" => $res["msgNotiApp_step"],
        //       "msgNotiApp_read_status" => $res["msgNotiApp_read_status"],
        //       "case_id" => $res["case_id"],
        //       "process_type_step" => $tmp2["process_type_step"],
        //       "sql" => "SELECT * FROM `Case` a INNER JOIN Message_Noti_App b ON a.case_id = b.case_id WHERE a.case_createBy_id = '$user_id' AND a.caseCh_id = '1' ".$filtersql.$sortsql.$limitsql
        //
        //     );
        //
        //
        //     array_push($result, $tmp);
        //   }
        // }


       if($result->num_rows > 0){
         $stmt->close();
         return $result;
       }else{
         $stmt->close();
         return NULL;
       }
    }



    /*** แสดง message ทั้งหมด , message ของผู้ใช้เท่านั้น ***/
    public function getAllUserMessage($user_id,$limit,$offset,$filter,$sort){
      /*********** start real ************/
        //$stmt = $this->conn->prepare("SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ?".$filtersql.$sortsql.$limitsql);
        //$stmt->bind_param("i", $user_id);
        //$stmt->execute();
        //$tasks = $stmt->get_result();
        //
        $filtersql = $this->func->filter_sql($filter);
        $limitsql  = $this->func->limit_sql($limit,$offset);
        $sortsql   = $this->func->sort_sql($sort);
        //
        // $stmt = $this->conn->prepare("SELECT * FROM `Message_Box_Log` a INNER JOIN Message_Box b on  a.msgBox_id = b.msgBox_id where b.msgBox_type = '1' and msgBox_status = '0' and recipient_id = '".$user_id."' order by msgBoxLog_id desc".$limitsql);
        //
        //
        // $stmt->execute();
        // $result = $stmt->get_result();
        $case_id_arr = array();
        $sql_box = "SELECT * FROM `Case` WHERE caseCh_id in (1,2) AND case_createBy_id = '".$user_id."'";
        $stmt1 = $this->conn->prepare($sql_box);
        $stmt1->execute();
        $query = $stmt1->get_result();
        //if($query->num_rows > 0){
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
        // $sql_box = "SELECT * FROM `Message_Box`
        // WHERE ((case_id IN ($case) AND sender_type = 2)
        // OR (sender_type = 1 AND sender_id = '".$user_id."')
        // OR (sender_type = 0 AND sender_id = '".$user_id."')) AND msgBox_status = 0 AND msgBoxRef_id = 0 ORDER BY msgBox_id DESC ".$limitsql;

        $sql_box = "SELECT c.msgBox_id,c.msgBox_message,c.msgBox_datetime,c.sender_type,c.msgBox_message_en,
        (SELECT b.msgBox_read_status FROM `Message_Box` a INNER JOIN Message_Box_Log b on a.msgBox_id = b.msgBox_id
        where `b`.`recipient_id` = '".$user_id."' and msgBoxRef_id = c.msgBox_id and b.msgBox_read_status = 0  LIMIT 1) as readmsg
		    FROM `Message_Box` c
        WHERE ((case_id IN ($case) AND sender_type = 2)
        OR (sender_type = 1 AND sender_id = '".$user_id."')
        OR (sender_type = 0 AND sender_id = '".$user_id."')) AND msgBox_status = 0 AND msgBoxRef_id = 0 ".$filtersql." ORDER BY msgBox_id DESC".$limitsql;
        $stmt = $this->conn->prepare($sql_box);
        // $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        //}

        if($result->num_rows == 0){
          $result=null;
        }

        // var_dump($result);
        // exit();

      /*********** end real ************/

      /*********** start mock ************/
      // $result = '{
      //     "current_field":0,
      //     "field_count":2,
      //     "lengths":[
      //         { "message_id":1,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 1 ปี ส่งต่อไปยัง....50%","message_date":"13/03/2560","message_time":"09.30"},
      //         { "message_id":2,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 2 ปี ส่งต่อไปยัง....75%","message_date":"13/03/2560","message_time":"09.30"},
      //         { "message_id":3,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 3 ปี ส่งต่อไปยัง....100%","message_date":"13/03/2560","message_time":"09.30"},
      //         { "message_id":4,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 4 ปี ส่งต่อไปยัง....100%","message_date":"13/03/2560","message_time":"09.30"},
      //         { "message_id":5,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 5 ปี ส่งต่อไปยัง....100%","message_date":"13/03/2560","message_time":"09.30"},
      //         { "message_id":6,"message_name":"ข้อพิพาทของคุณ เรื่องลูกค้าไม่ยอมชำระเงินเป็นเวลา 6 ปี ส่งต่อไปยัง....100%","message_date":"13/03/2560","message_time":"09.30"}
      //       ]
      //     ,
      //     "num_rows":3,
      //     "type":0
      //  }';
      //  $result = json_decode($result);
       /*********** end mock ************/
       if($result->num_rows > 0){
        //  $stmt->close();
         return $result;
       }else{
        //  $stmt->close();s
         return NULL;
       }
    }

    /*** แสดง message ที่เลือก , message ของผู้ใช้เท่านั้น ***/
    public function getMessage($id) {
      /*********** start real ************/
        // $stmt = $this->conn->prepare("SELECT * ,
        // (select concat(member_fname,' ',member_lname ) FROM Member where member_id = sender_id) as sendfrom,
        // (select concat(member_fname,' ',member_lname ) FROM Member where member_id = recipient_id) as sendto ,
        // (select caseDtl_title from `Case` where case_id = a.case_id ) as message_name
        // FROM Message_Box a INNER join Message_Box_Log b on a.msgBox_id = b.msgBox_id where a.msgBox_id = '".$id."'");
        // // $stmt->bind_param("i", $user_id);
        // $stmt->execute();
        // $result = $stmt->get_result();
        $data =array();
        $sql = "SELECT a.case_id as caseid ,caseDtl_title,case_create_datetime FROM `Case`a
                inner join Message_Box b on a.case_id = b.case_id
                where msgBox_id = '".$id."'";
                $stmt1 = $this->conn->prepare($sql);
                $stmt1->execute();
                $result2 = $stmt1->get_result()->fetch_assoc();

        $sql_bm = "SELECT
                  c.case_id,
                  c.caseDtl_title,
                  em.emp_firstname,
                  em.emp_lastname,
                  em.emp_img_path,
                  mb.msgBox_message,
                  mb.msgBox_id,
                  mb.sender_type,
                  mb.sender_id,
                  m.member_fname,
                  m.member_lname,
                  m.member_img,
                  m.member_type,
                  mb.msgBoxRef_id,
                  mb.msgBox_datetime,
                  mc.member_comp_id,
                  mc.member_comp_img,
                  mc.member_comp_name
                  FROM `Case` AS c
                  LEFT JOIN `Message_Box` AS mb ON c.case_id = mb.case_id
                  LEFT JOIN `Employee` AS em ON mb.sender_id = em.emp_id
                  LEFT JOIN `Member` AS m ON mb.sender_id = m.member_id
                  LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id
                  WHERE mb.msgBox_id = '".$id."' OR mb.msgBoxRef_id = '".$id."' ";

                  $stmt = $this->conn->prepare($sql_bm);
                  $stmt->execute();
                  $datadatail = array();
                  $dataAttachfile = array();

                  $result = $stmt->get_result();
                  // $test = $result->fetch_assoc();

                  if($result->num_rows > 0){
                    while($res = $result->fetch_assoc()){
                      $dataAttachfile = array();

                      $datespilt = explode (" ", $res["msgBox_datetime"]);
                      $message_to = $res['member_comp_name'];
                      if ($res['member_comp_name']==Null) {
                        $message_to = $res['emp_firstname']." ".$res['emp_lastname'];
                      }
                          $Attachfile="SELECT * FROM `Message_Box_Attachfile` where msgBox_id = '".$res['msgBox_id']."'";
                          $stmt3 = $this->conn->prepare($Attachfile);
                          $stmt3->execute();
                          $result3= $stmt3->get_result();
                            if($result3->num_rows > 0){
                              while ($dataattac = $result3->fetch_assoc()) {
                                $msgBoxAttach_title=$dataattac['msgBoxAttach_title'];
                                if ($msgBoxAttach_title=="") {
                                  $msgBoxAttach_title=$dataattac['msgBoxAttach_file_name'];
                                }
                                  array_push($dataAttachfile,array(
                                    'msgBoxAttach_title'=>$msgBoxAttach_title,
                                    'msgBoxAttach_file_path'=>BASE_URL.$dataattac['msgBoxAttach_file_path']
                                  ));
                              }
                            }
                        array_push($datadatail,array(
                                  'msgBox_message'=>$res['msgBox_message'],
                                  'message_date' => $datespilt[0],
                                  'message_time' =>$datespilt[1],
                                  'case_create_datetime'=>$res['case_create_datetime'],
                                  'message_from' => "ผู้ส่ง",
                                  'message_fulltime' => $res["msgBox_datetime"],
                                  'message_to'=>$message_to,
                                  'Attachfile'=>$dataAttachfile
                                ));
                      }
                  }
                  array_push($data,array(
                    'message_id' => $id ,
                    'message_name'=>$datadatail,
                    'caseDtl_title'=>$result2['caseDtl_title'],
                    'msgBox_datetime'=>$result2['case_create_datetime'],
                    'message_caseid' => $result2['caseid']
                  ));
                  // array_push($result["message_name"], $test);


      /*********** end real ************/

      /*********** start mock ************/
      // $result = '{
      //     "current_field":0,
      //     "field_count":2,
      //     "lengths":[
      //         { "message_id":1,"message_name":"ลูกค้าไม่ยอมชำระเงินเป็นเวลา 1 ปี","message_date":"13/03/2560","message_time":"09.30","message_caseid":"23456","message_from":"วิภา เหล่าประภัสสร","message_text":"ทางเราขะขอข้อมูลเพิ่มเติมเกี่ยวกับเรื่องร้องเรียน กรณีลูกค้าไม่ยอมชำระเงินเป็นเวลา 1 ปี ในส่วนของข้อมูล รายละเอียด สินค้าที่ได้มีการสั่งซื้อจาก บริษัทคู่กรณีเพิ่มเติม","message_to":"อรพิน โชติภา"}
      //       ]
      //     ,
      //     "num_rows":3,
      //     "type":0
      //  }';
      //  $result = json_decode($result);
      //  /*********** end mock ************/
       if($result2->num_rows > 0){
        //  $stmt->close(); // code real
        //  $result = (array)$result->lengths; // code mock
            // return $result;
         return $data;
       }else{
         $stmt->close(); // code real
         return $data;
       }
    }

    /*** อัพเดทเงื่อนไขการแจ้งข้อร้องเรียน , ผู้ใช้สามารถอัพเดทของตัวเองได้เท่านั้น ***/
    public function updateUserCondition($member_id) {
      //$stmt = $this->conn->prepare("UPDATE Member set member_condition = '1' WHERE member_id = ?");
      $stmt = $this->conn->prepare("UPDATE Member set member_condition = '2' WHERE member_id = ?");

      $stmt->bind_param("s",$member_id);
      $stmt->execute();

      $stmt = $this->conn->prepare("UPDATE Member set member_condition = '1' WHERE member_id = ?");

      $stmt->bind_param("s",$member_id);
      $stmt->execute();
      $num_affected_rows = $stmt->affected_rows;
      $stmt->close();
      return $num_affected_rows > 0;
    }

    /*เดียวลบ*/
    public function updateUserCondition2($member_id) {
      //$stmt = $this->conn->prepare("UPDATE Member set member_condition = '1' WHERE member_id = ?");
      $stmt = $this->conn->prepare("UPDATE Member set member_condition = '2' WHERE member_id = ?");

      $stmt->bind_param("s",$member_id);
      $stmt->execute();

      // $stmt = $this->conn->prepare("UPDATE Member set member_condition = '1' WHERE member_id = ?");
      //
      // $stmt->bind_param("s",$member_id);
      // $stmt->execute();
      $num_affected_rows = $stmt->affected_rows;
      $stmt->close();
      return $num_affected_rows > 0;
    }
    /*เดียวลบ*/


    /*** อัพเดท User , ผู้ใช้สามารถอัพเดท User ได้เท่านั้น ***/
  public function updateUser($user_id,$type_member, $fname, $lname, $cid, $address,
  $prov_id, $postcode, $country_id, $phone, $fax, $sex, $occupation, $position,
  $company_name, $company_branch,$company_taxid, $company_address, $company_prov_id,
  $company_postcode,$company_country_id, $company_phone, $company_fax, $comp_img, $user_img) {

        $stmt = $this->conn->prepare("UPDATE Member set
          member_fname = '$fname',
          member_lname = '$lname',
          member_cid = '$cid',
          member_address = '$address',
          prov_id = '$prov_id',
          member_postcode = '$postcode',
          country_id = '$country_id',
          member_phone = '$phone',
          member_cellphone = '$fax',
          member_sex = '$sex',
          member_occupation = '$occupation',
          member_position = '$position'
          WHERE member_id = '$user_id' ");
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
          if($user_img != ""){
            $success = $this->func->uploadImageBase64($user_img, "img_member" , $user_id);
            if($success!=''){
              $stmt = $this->conn->prepare("UPDATE Member set member_img = '$success' WHERE member_id = '$user_id' ");
              $stmt->execute();
            }
          }
          if($type_member == "1"){
            $res = $this->upDataUserComp($user_id,$company_name,$company_branch,$company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax, $comp_img);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
          }else{
            return 1;
          }
        }else{
          return 0;
        }
        //$num_affected_rows = $stmt->affected_rows;
        //$stmt->close();
        //return $num_affected_rows > 0;
    }

    /*** แก้ไขบริษัท ให้กับ user ***/
    public function upDataUserComp($user_id, $company_name, $company_branch, $company_taxid, $company_address, $company_prov_id, $company_postcode,$company_country_id, $company_phone, $company_fax, $comp_img) {
        $stmt = $this->conn->prepare("UPDATE Member_comp set
          member_comp_name = '$company_name',
          member_comp_branch = '$company_branch',
          member_comp_taxid = '$company_taxid',
          member_comp_address = '$company_address',
          prov_id = '$company_prov_id',
          member_comp_postcode = '$company_postcode',
          country_id = '$company_country_id',
          member_comp_phone = '$company_phone',
          member_comp_fax = '$company_fax'
          WHERE member_id = '$user_id' ");
          $result = $stmt->execute();
          $stmt->close();
          if ($result) {
              if($comp_img != ""){
                $stmt = $this->conn->prepare("SELECT * from Member_comp WHERE member_id = '$user_id' ");
                $stmt->execute();$result2 = $stmt->get_result();
                $res2 = $result2->fetch_assoc();
                $success2 = $this->func->uploadImageBase64($comp_img, "img_membercom" , $res2['member_comp_id']);
                if($success2!=''){
                  $stmt = $this->conn->prepare("UPDATE Member_comp set member_comp_img = '$success2' WHERE member_comp_id = '$res2[member_comp_id]' ");
                  $stmt->execute();
                }
              }
          }
          return $result;
    }

    /*** แก้ไข Read ให้กับ noti ***/
    public function updateReadNoti($noti_id) {
        // $stmt = $this->conn->prepare("UPDATE Log_Notification set
        //   noti_read = '1'
        //   WHERE noti_id = '$noti_id' ");

        $stmt = $this->conn->prepare("UPDATE Message_Noti_App set
            msgNotiApp_read_status = '1',msgNotiApp_read_datetime = now()
            WHERE msgNotiApp_id = '$noti_id' ");
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /*** แก้ไข Read ให้กับ notiopen ***/
    public function updateReadNotiopen($noti_id) {

        $stmt = $this->conn->prepare("UPDATE Message_Noti_App set
            msgNotiApp_read_status = '1',msgNotiApp_read_datetime = now(),msgNotiApp_noti_status='1',msgNotiApp_noti_datetime=now()
            WHERE msgNotiApp_id = '$noti_id' ");
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    /*** update noti all of noti page ***/
    public function updateReadNotiAll($memid) {
        $stmt = $this->conn->prepare("UPDATE Message_Noti_App set
            msgNotiApp_noti_status = '1',msgNotiApp_noti_datetime = now()
            WHERE member_id = '$memid' and msgNotiApp_noti_status = '0' ");
        $result = $stmt->execute();
        // $txt[] = "UPDATE Message_Noti_App set
        //     msgNotiApp_noti_status = '1',msgNotiApp_noti_datetime = now()
        //     WHERE member_id = '$memid' ";
        $stmt->close();
        return $result;
    }

    public function updateReadMessage($userid,$memid) {
      $sql = "SELECT a.msgBox_id FROM `Message_Box` a INNER JOIN Message_Box_Log b on a.msgBox_id = b.msgBox_id
      where `b`.`recipient_id` = '".$userid."' and a.msgBoxRef_id = '".$memid."' and b.msgBox_read_status = 0";
              $stmt1 = $this->conn->prepare($sql);
              $stmt1->execute();
              $result2 = $stmt1->get_result();
              // $result2 = $stmt1->get_result()->fetch_assoc();
                while ($data = $result2->fetch_assoc()) {
                  $stmt = $this->conn->prepare("UPDATE Message_Box_Log set
                      msgBox_read_status = '1',msgBox_read_datetime = now()
                      WHERE msgBox_id = ".$data['msgBox_id']);

                  $result = $stmt->execute();
                }


        // $stmt = $this->conn->prepare("UPDATE Message_Noti_App set
        //     msgNotiApp_noti_status = '1',msgNotiApp_noti_datetime = now()
        //     WHERE member_id = '$memid' and msgNotiApp_noti_status = '0' ");
        // $result = $stmt->execute();
        // $txt[] = "UPDATE Message_Noti_App set
        //     msgNotiApp_noti_status = '1',msgNotiApp_noti_datetime = now()
        //     WHERE member_id = '$memid' ";
        // $stmt->close();
        return $result;
    }


    /*** ลบ Noti ***/
    public function DeleteNoti($noti_id) {
        // $stmt = $this->conn->prepare("UPDATE Log_Notification set
        //   noti_status = '1'
        //   WHERE noti_id = '$noti_id' ");
        // $result = $stmt->execute();
        // $stmt->close();
        // return $result;

        $stmt = $this->conn->prepare("UPDATE Message_Noti_App set
          msgNoti_status = '1'
          WHERE msgNotiApp_id = '$noti_id' ");


        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    /*** ลบ Messages ***/
    public function Deletemessage($noti_id) {
        // $stmt = $this->conn->prepare("UPDATE Log_Notification set
        //   noti_status = '1'
        //   WHERE noti_id = '$noti_id' ");
        // $result = $stmt->execute();
        // $stmt->close();
        // return $result;

        $stmt = $this->conn->prepare("UPDATE Message_Box set
          msgBox_status = '1'
          WHERE msgBox_id = '$noti_id' ");
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }



    /*** เปลี่ยนภาษา ***/
    public function updateLang($OnOff,$user_id) {
        $stmt = $this->conn->prepare("UPDATE Member set
          member_lang = '$OnOff'
          WHERE member_id = '$user_id' ");
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /*** เปิดปิด noti ***/
    public function updateNoti($OnOff,$user_id) {
        $stmt = $this->conn->prepare("UPDATE Member set
          member_noti = '$OnOff'
          WHERE member_id = '$user_id' ");
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }



    /*** ลบ task , ผู้ใช้สามารถลบ task ได้เท่านั้น ***/
    public function deleteTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("DELETE t FROM tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }

    /*** เพิ่ม task ให้กับ user ***/
    public function createUserTask($user_id, $task_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_tasks(user_id, task_id) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $task_id);
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }

    /*****   insert Corporate    ******/
    public function insertCorporate($cpr_section,$cpr_type,$cpr_comp_type,
    $cpr_numbertrade,$cpr_companyname,$cpr_type_import_export,
    $cpr_branch,$cpr_telephone,$cpr_fax,
    $cpr_email,$cpr_address,$prov_id,
    $cpr_zipcode,$cpr_department,$cpr_contactfname,
    $cpr_contactlname,$Country_id,$cpr_contact_person,
    $cpr_import,$cpr_create_datetime,$cpr_createBy_id,$cpr_status){

      $stmt = $this->conn->prepare("INSERT INTO Corporate (cpr_section,cpr_type,cpr_comp_type,
      cpr_numbertrade,cpr_companyname,cpr_type_import_export,
      cpr_branch,cpr_telephone,cpr_fax,
      cpr_email,cpr_address,prov_id,
      cpr_zipcode,cpr_department,cpr_contactfname,
      cpr_contactlname,Country_id,cpr_contact_person,
      cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status) values(
        '$cpr_section','$cpr_type','$cpr_comp_type',
        '$cpr_numbertrade','$cpr_companyname','$cpr_type_import_export',
        '$cpr_branch','$cpr_telephone','$cpr_fax',
        '$cpr_email','$cpr_address','$prov_id',
        '$cpr_zipcode','$cpr_department','$cpr_contactfname',
        '$cpr_contactlname','$Country_id','$cpr_contact_person',
        '$cpr_import','$cpr_create_datetime','$cpr_createBy_id','$cpr_status')");
      $result = $stmt->execute();
      if (false === $result) {
          die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $stmt->close();
      return $result;

    }

    /*****   Update Corporate    ******/
    public function updateCorporate($Valuecpr_section,$cpr_type,
    $cpr_comp_type,$cpr_numbertrade,$cpr_companyname,
    $cpr_type_import_export,$cpr_branch,$cpr_telephone,
    $cpr_fax,$cpr_email,$cpr_address,
    $prov_id,$cpr_zipcode,$cpr_department,
    $cpr_contactfname,$cpr_contactlname,$Country_id,
    $cpr_contact_person,$cpr_import,$cpr_update_datetime,$cpr_updateBy_id,$cpr_status,$resultcpr_id){

      $sql = "UPDATE `Corporate` SET
      cpr_section='$Valuecpr_section',
      cpr_type='$cpr_type',
      cpr_comp_type='$cpr_comp_type',
      cpr_numbertrade='$cpr_numbertrade',
      cpr_companyname='$cpr_companyname',
      cpr_type_import_export='$cpr_type_import_export',
      cpr_branch='$cpr_branch',
      cpr_telephone='$cpr_telephone',
      cpr_fax='$cpr_fax',
      cpr_email='$cpr_email',
      cpr_address='$cpr_address',
      prov_id='$prov_id',
      cpr_zipcode='$cpr_zipcode',
      cpr_department='$cpr_department',
      cpr_contactfname='$cpr_contactfname',
      cpr_contactlname='$cpr_contactlname',
      Country_id='$Country_id',
      cpr_contact_person='$cpr_contact_person',
      cpr_import='$cpr_import',
      cpr_update_datetime='$cpr_update_datetime',
      cpr_updateBy_id='$cpr_updateBy_id',
      cpr_status='$cpr_status'
      WHERE cpr_id='$resultcpr_id'";
      $stmt = $this->conn->prepare($sql);
      $result = $stmt->execute();
      if (false === $result) {
          die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $stmt->close();
      return $result;

    }

    /*****   insert Contact_thai    ******/
    public function insertContact_thai($ct_section,$ct_type,$ct_department,$ct_comp_type,
    $ct_card,$ct_firstname,$ct_lastname,$ct_sex,$ct_career,$ct_cellphone,$ct_email,$ct_address,
    $prov_id,$ct_postcode,$Country_id,$case_createBy_id){

      $stmt = $this->conn->prepare("INSERT INTO Contact_thai (ct_section,ct_type,ct_department,
      ct_comp_type,ct_card,ct_firstname,ct_lastname,ct_sex,ct_career,ct_cellphone,ct_email,ct_address,prov_id,
      ct_postcode,Country_id,ct_import,ct_create_datetime,ct_createBy_id,ct_status) values(
        '$ct_section', '$ct_type', '$ct_department', '$ct_comp_type', '$ct_card', '$ct_firstname', '$ct_lastname',
        '$ct_sex', '$ct_career', '$ct_cellphone', '$ct_email', '$ct_address', '$prov_id', '$ct_postcode',
        '$Country_id', '0', NOW(), '$case_createBy_id', '0')");
      $result = $stmt->execute();
      if (false === $result) {
          die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $stmt->close();
      return $result;

    }

}

?>
