<?php

class DbHandler {

    private $conn,$func;
    function __construct() {
      
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
        require_once dirname(__FILE__) . '/DbFunction2.php';
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
            $member_facebook_name = "";
            if($facebook_type == '1'){
              $password_hash = '';
              $member_facebook_name = $fname." ".$lname;
            }

            $stmt = $this->conn->prepare("INSERT INTO Member(member_fname, member_lname, member_cid,
              member_address, prov_id, member_postcode, country_id, member_phone,
              member_cellphone, member_sex, member_occupation, member_position, member_email,
              member_password, member_api_key, member_type, member_status, member_noti,
              member_condition, member_creDate, member_facebook_id, member_facebook_type, member_business, member_lang,member_facebook_name
            ) values('$fname', '$lname', '$cid',
              '$address', '$prov_id', '$postcode',
              '$country_id', '$phone', '$fax',
              '$sex', '$occupation', '$position', '$email',
              '$password_hash', '$api_key', '$type_member',
              '$status', '$member_noti', '$member_condition', '$member_creDate', '$facebook_id', '$facebook_type',
              '$member_business', '$member_lang','$member_facebook_name'
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
          if ($res['member_status_confirm']==0) {
            return 3;
          }else{
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
                คุณสามารถใช้ Email และ Password นี้เข้าใช้งานได้ที่ App DITP Care
                 </td>
                </tr>
                <tr>
                 <td style=\" font-size:15px; \">
                Team http://www.ditp.go.th/
                 </td>
                </tr>
               </table>";
               $result = $this->func->sendEmail("ditp.noreply@gmail.com","Noreply DITP",$mailsent,$namesent,"รีเซ็ตรหัสผ่านของคุณ",$message,$newpassword,$emp_email,"1");
              //  if($result=="Success"){
                 $password_hash = PassHash::hash($newpassword);
                 $stmt = $this->conn->prepare("UPDATE Member SET member_password = '".$password_hash."' WHERE member_email = '$email' ");
                 $stmt->execute();
              //  }
            return $result;
          }

        }else{
          $stmt->close();
          return 2;
        }
    }

    /*** ดึง userid จาก apikey ***/
    public function getUserId($api_key) {
      $stmt = $this->conn->prepare("SELECT member_id FROM Member WHERE ssoid = '$api_key' ");
      if ($stmt->execute()) {
          $stmt->bind_result($user_id);
          $stmt->fetch();
          $stmt->close();
          // echo $user_id;
          return $user_id;
      } else {
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
      if($compType2 > 0){
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
              "frmset_name" => $res['frmset_name'],
              "frmset_name_en"=>$res['frmset_name_en']
  					);
  					$output[]=$response;
  					$id[]= $res['frmset_id'];

            // print_r($response);
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
                "fieldset_description" => $res2['fieldset_description'],
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

    public function getFormSet1($compType1, $compType2, $compType3) {
      if($compType2 > 0){
        $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type1 WHERE compType_id = ? AND compTypeSub1_id = ? ");
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

        $stmt = $this->conn->prepare("SELECT * FROM Form_Link_Complaint_Type1 WHERE compType_id = ?  ");
        $stmt->bind_param("s", $compType1);
      }


        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"frmset_id" => $res['frmset_id'],
              "frmset_name" => $res['frmset_name'],
              "frmset_name_en"=>$res['frmset_name_en']
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
                  "termsOfUse_text":"1. กรมส่งเสริมการค้าระหว่างประเทศ ให้บริการตรวจสอบคู่ค้าในต่างประเทศในเบื้องต้น และให้คำปรึกษาด้านข้อพิพาททางการค้าระหว่างประเทศ ทั้งนี้ ข้อมูลและคำแนะนำของกรมไม่สามารถนำไปอ้างอิงในการดำเนินการทางกฎหมาย  <br><br>2.  หลังจากยื่นเรื่องภายใน 3 วันทำการ หากยังไม่ได้รับการติดต่อจากเจ้าหน้าที่ โปรดติดต่อ DITP Call Center 1169 <br><br>3. หากเรื่องร้องเรียนของท่านเป็นกรณีเร่งด่วน โปรดติดต่อ DITP Call Center 1169 <br><br>5.  การยืนยันตัวตนการใช้งานของผู้ร้องเรียน จะต้องกรอกข้อมูลรายละเอียดต่างๆ ตามจริงให้ครบถ้วน ทั้งนี้ เพื่อประโยชน์แก่ตัวผู้ร้องเรียน หากตรวจพบว่าข้อมูลไม่เป็นความจริง กรมส่งเสริมการค้าระหว่างประเทศ จะทำการระงับการใช้งานของผู้ร้องเรียนโดยไม่ต้องแจ้งให้ทราบล่วงหน้า <br><br>6. การยื่นเรื่องร้องเรียน ผู้ร้องเรียนจะต้องให้ข้อมูลที่เป็นความจริงทุกประการ หากพบว่าข้อมูลไม่เป็นความจริง ท่านอาจถูกดำเนินคดีตามกฏหมาย",
                  "termsOfUse_text_en":"1. The Department of International Trade (DITP) provides services related to verification of Thai Trading Partner and consultation with regard to international trade disputes. <br><br>2. In case DITP finds the complainant\'s information to be untrue. DITP reserves the rights to terminate the service and suspend the account without prior notice."
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
                  "about_dis":"กรมส่งเสริมการค้าระหว่างประเทศ ได้มอบหมายให้สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ ดำเนินการให้บริการข้อมูล/คำปรึกษาด้านการค้าระหว่างประเทศ รวมถึงเป็นศูนย์กลางในการรับเรื่องร้องเรียน ข้อคิดเห็น/ข้อเสนอแนะ และข้อพิพาททางการค้าระหว่างประเทศ เพื่อช่วยเหลือผู้ประกอบการไทยและชาวต่างชาติ",
                  "about_dis_en":"Department of International Trade Promotion has assigned Office of Information and International Trade Service to provide information, advice on international trade, and to be the centre of complaints/suggestions/international trade conflicts, as an assistance to Thai and foreign entrepreneurs.",
                  "about_link":""
                },
                {
                  "about_id":2,
                  "about_title":"กรมส่งเสริมการค้าระหว่างประเทศ (บางกระสอ)",
                  "about_title_en":"Department of International Trade Promotion (Bangkrasor)",
                  "about_dis":"563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมือง จังหวัดนนทบุรี 11000 <br>โทรศัพท์ : 02-507-8173, 02-507-7999 <br>โทรสาร : 02-547-4297 <br>อีเมล : Marks@ditp.go.th, Ditpservicecenter@gmail.com <br>สายด่วน : 1169",
                  "about_dis_en":"563 Nonthaburi road, Tambon Bangkrasor, Muang, Nonthaburi 11000. <br>Tel: 02-507-8173, 02-507-7999 <br>Fax: 02-547-4297 <br>Email: Marks@ditp.go.th, Ditpservicecenter@gmail.com <br>Hotline: 1169 ",
                  "about_link":"https://www.google.com/maps/d/u/0/viewer?ll=13.885037300929957%2C100.48700800000006&spn=0.023622%2C0.042272&msa=0&iwloc=0004e1d66cce09b33bc93&mid=1Urvxq7GWYWsmkhMnjkFy4vNBKLY&z=15"

                },
                {
                  "about_id":3,
                  "about_title":"กรมส่งเสริมการค้าระหว่างประเทศ (ถนนรัชดาภิเษก)",
                  "about_title_en":"DITP Office at Ratchadaphisek road",
                  "about_dis":"22/77 ถนนรัชดาภิเษก เขตจตุจักร กรุงเทพ 10900 <br>โทรศัพท์ : 0 2513 1909 <br>โทรสาร : 0 2511 5200 <br>อีเมล : tiditp@ditp.go.th <br>สายด่วน : 1169",
                  "about_dis_en":"22/77 Ratchadaphisek rd, Chatuchak, Bangkok 10900 <br>Tel: 0 2513 1909 <br>Fax: 0 2511 5200 <br>Email: tiditp@ditp.go.th <br>Hotline: 1169",
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
                  "help_dis":"<div class=\"panel-body\"><div class=\"txt_item\">ขั้นตอนที่ 1 แจ้งเรื่องร้องเรียนผ่านทาง Website DITP หรือช่องทางอื่นๆโดยพสามารถกรอกรายละเอียดข้อมูลเรื่องร้องเรียนและแนบเอกสารข้อเท็จจริง ได้ในระบบ        </div><div class=\"txt_item\">ขั้นตอนที่ 2 เจ้าหน้าที่ได้รับเรื่องร้องเรียนของท่านแล้ว และทำการประสานไปยังผู้ที่เกี่ยวข้อง        </div><div class=\"txt_item\">ขั้นตอนที่ 3 เจ้าหน้าที่ดำเนินการตรวจสอบข้อเท็จจริง และแจ้งความคืบหน้าให้แก่ผู้ร้องเรียนทราบต่อไป        </div><div class=\"txt_item\">ขั้นตอนที่ 4 ยุติเรื่องร้องเรียน        </div></div>",
                  "help_dis_en":"<div class=\"panel-body\"><div class=\"txt_item\">1) Create petition on DITP Care Web Site or other petition channels and attach documentation for petition into the system        </div><div class=\"txt_item\">2) The system receives your petition and forward it to appropriate channel        </div><div class=\"txt_item\">3) DITP validates your information and updates the processes to petitioner        </div><div class=\"txt_item\">4) Stop your petition your petition        </div></div>"
                },
                {
                  "help_id":3,
                  "help_title":"ช่องทางการรับเรื่องร้องเรียน",
                  "help_title_en":"Petition channels",
                  "help_dis":"<div class=\"panel-body\"><div class=\"txt_item\">1.ผู้ประกอบการร้องเรียนด้วยตนเอง      </div><div class=\"txt_item_sup\">1.1 ร้องเรียนผ่านเคาน์เตอร์ให้บริการการค้าระหว่างประเทศ ทั้ง 2 แห่ง (Walk-in)      </div><div class=\"txt_item_supersup\">- กรมส่งเสริมการค้าระหว่างประเทศ (ถนนรัชดาภิเษก)      </div><div class=\"txt_item_supersup\">- กรมส่งเสริมการค้าระหว่างประเทศ (นนทบุรี)      </div><div class=\"txt_item_sup\">1.2 ร้องเรียนผ่านสายตรงการค้าระหว่างประเทศ 1169      </div><div class=\"txt_item_sup\">1.3 ร้องเรียนผ่านเว็บไซต์กรมส่งเสริมการค้าระหว่างประเทศ www.ditp.go.th      </div><div class=\"txt_item_sup\">1.4 ร้องเรียนผ่าน E-mail : ditpservicecenter@gmail.com      </div><div class=\"txt_item\">2.สำนักตลาด 2 สำนัก โดยการประสานจากสำนักงานส่งเสริมการค้าในต่างประเทศ (สคต)      </div><div class=\"txt_item_sup\">2.1 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.1)      </div><div class=\"txt_item_sup\">2.2 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item\">3.สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item_sup\">3.1 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.1)      </div><div class=\"txt_item_sup\">3.2 สำนักพัฒนาตลาดและธุรกิจไทยในต่างประเทศ (สพต.2)      </div><div class=\"txt_item_sup\">3.3 สำนักส่งเสริมการค้าสินค้าไลฟ์สไตล์ (สลต.)      </div><div class=\"txt_item_sup\">3.4 สำนักส่งเสริมการค้าสินค้าเกษตรและอุตสาหกรรม (สกอ.)      </div><div class=\"txt_item_sup\">3.5 สำนักธุรกิจบริการและโลจิสติกส์การค้า (สบล.)      </div><div class=\"txt_item\">4.สำนักงานส่งเสริมการค้าในต่างประเทศ ของกรม จำนวน 58 สำนักงาน      </div><div class=\"txt_item_sup\">4.1 สำนักปลัดกระทรวงพาณิชย์      </div><div class=\"txt_item_sup\">4.2 สำนักนายกรัฐมนตรี (GCC 1111)      </div><div class=\"txt_item_sup\">4.3 กล่องรับฟังความคิดเห็นและเรื่องร้องเรียน/การทุจริตภาครัฐ      </div><div class=\"txt_item_sup\">4.4 ไปรษณีย์ไทย      </div></div>",

                  "help_dis_en":"<div class=\"panel-body\"><div class=\"txt_item\">1.Create petition by yourself      </div><div class=\"txt_item_sup\">1.1 Submit petition through 2 DITP counters (walk-in) at      </div><div class=\"txt_item_supersup\">- DITP Office at Ratchadaphisek road      </div><div class=\"txt_item_supersup\">- DITP Office at Ministry of Commerce, Nonthaburi      </div><div class=\"txt_item_sup\">1.2 DITP Call Center 1169      </div><div class=\"txt_item_sup\">1.3 DITP Web Site at www.ditp.go.th       </div><div class=\"txt_item_sup\">1.4 DITP E-mail at ditpservicecenter@gmail.com      </div><div class=\"txt_item\">2.DITP Service Center at ThaiTrade Foreign Offices      </div><div class=\"txt_item_sup\">2.1 Office of Overseas Markets Development and Promotion 1      </div><div class=\"txt_item_sup\">2.2 Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item\">3.Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item_sup\">3.1 Office of Overseas Markets Development and Promotion 1      </div><div class=\"txt_item_sup\">3.2 Office of Overseas Markets Development and Promotion 2      </div><div class=\"txt_item_sup\">3.3 Office of Fashion and Lifestyle Business Development      </div><div class=\"txt_item_sup\">3.4 Office of Agricultural and Industrial Business Development      </div><div class=\"txt_item_sup\">3.5 Office of Service Trade and Trade Logistics      </div><div class=\"txt_item\">4.58 ThaiTrade Center Foreign Offices      </div><div class=\"txt_item_sup\">4.1 Office of Permanent Secretary for Commerce      </div><div class=\"txt_item_sup\">4.2 The Prime Minister’s Office Call Centre (GCC 1111)      </div><div class=\"txt_item_sup\">4.3 The Royal Thai Government’s Complaint Post Box      </div><div class=\"txt_item_sup\">4.4 ThaiPost      </div></div>"
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

    /*** คำถาม ***/
    // public function getFeedback() {
    //     $stmt = $this->conn->prepare("SELECT * FROM Feedback_App_Question ORDER BY feedback_q_id ASC");
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     if($result->num_rows > 0){
    //       $stmt->close();
    //       return $result;
    //     }else{
    //       $stmt->close();
    //       return NULL;
    //     }
    // }

    public function getFeedback() {

        $stmt = $this->conn->prepare("SELECT * FROM Feedback_App_Question ORDER BY feedback_q_id ASC");
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){

          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"feedback_q_id" => $res['feedback_q_id'],
              "feedback_q_title" => $res['feedback_q_title'],
              "feedback_q_title_en"=>$res['feedback_q_title_en'],
              "feedback_q_type"=>$res['feedback_q_type'],
              "feedback_q_chk"=>$res['feedback_q_chk']
  					);
  					$output[]=$response;
  					$id[]= $res['feedback_q_id'];
  				}
          foreach ($output as $key => $product) {
            $stmt = $this->conn->prepare("SELECT * FROM Feedback_App_Choice WHERE feedback_q_id ='$id[$key]' ORDER BY feedback_c_id ASC");
            $stmt->execute();
            $result2 = $stmt->get_result();
  					while($res2 = $result2->fetch_assoc())
  					{
    					$response = array(
    						"feedback_c_id" => $res2['feedback_c_id'],
                "feedback_c_text" => $res2['feedback_c_text'],
                "feedback_c_text_en" => $res2['feedback_c_text_en'],
                "feedback_c_other_flag" => $res2['feedback_c_other_flag']
    					);
    					$output3[]=$response;
    					$output[$key]['Choice'] = $output3 ;
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
    /* onetime */
      public function redirectOnetime($session_id,$ret_str) {

        $stmt = $this->conn->prepare("UPDATE Member SET member_onetime = '$ret_str' WHERE member_api_key = '$session_id' ");
        $result = $stmt->execute();
        $stmt->close();

        $stmt = $this->conn->prepare("SELECT member_onetime FROM Member WHERE member_api_key = '$session_id' ");
        if ($stmt->execute()) {
            $stmt->bind_result($onetime_token);
            $stmt->fetch();
            $stmt->close();
            return $onetime_token;
        } else {
            return NULL;
        }
      }
      public function getOnetime($session_id) {
          $stmt = $this->conn->prepare("SELECT member_onetime FROM Member WHERE member_api_key = '$session_id' ");
          if ($stmt->execute()) {
              $stmt->bind_result($onetime_token);
              $stmt->fetch();
              $stmt->close();
              return $onetime_token;
          } else {
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

    function dataproduct($res){
        $response=array(
                                    'prodType_id' =>$res['prodType_id'],
                                    'prodType_level'=>$res['prodType_level'],
                                    'prodType_name'=>$res['prodType_name'],
                                    'prodType_name_en'=>$res['prodType_name_en']
                                  );
      return $response;
    }

    /*** ประเภทสินค้า ***/
    public function getTypeProduct() {

      $stmt = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 1");
      $stmt->execute();
      $result = $stmt->get_result();
      $response=array();
      if($result->num_rows > 0){
         while($res = $result->fetch_assoc()){
            // array_push($response,$this->dataproduct($res));
            ////////// 2 //////////
            $stmt1 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 2 and prodType_ref_id=".$res['prodType_id']);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            if($result1->num_rows > 0){
               while($res1 = $result1->fetch_assoc()){
                //  array_push($response,$this->dataproduct($res1));
                 ///////////////// 3 //////////////////////////
                 $stmt2 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 3 and prodType_ref_id=".$res1['prodType_id']);
                 $stmt2->execute();
                 $result2 = $stmt2->get_result();
                 if($result2->num_rows > 0){
                    while($res2 = $result2->fetch_assoc()){
                      // array_push($response,$this->dataproduct($res2));
                      ///////////////// 4 //////////////////////////
                      $stmt3 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 4 and prodType_ref_id=".$res2['prodType_id']);
                      $stmt3->execute();
                      $result3 = $stmt3->get_result();
                      if($result3->num_rows > 0){
                         while($res3 = $result3->fetch_assoc()){
                          //  array_push($response,$this->dataproduct($res3));
                           ///////////////// 5 //////////////////////////
                           $stmt4 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 5 and prodType_ref_id=".$res3['prodType_id']);
                           $stmt4->execute();
                           $result4 = $stmt4->get_result();
                           if($result4->num_rows > 0){
                              while($res4 = $result4->fetch_assoc()){
                                array_push($response,$this->dataproduct($res4));
                              }
                           }
                           /////////// end 5 ///////////////
                         }
                      }
                      /////////// end 4///////////////
                    }
                 }
                 /////////// end 3///////////////
               }
            }
            ///////////// end 2 //////////////
         }
      }
      return $response;
  }

  public function changeProduct() {
    /*
    1 = 2,276,336,427
    2 = 182,225,358
    3 = 
    4 = 246,315,348,364,386,403,418,424,409
    5 = 383,389,421
    6 = 1012
    7 = 1260,1261,1262,476
    8 = 431,882,1036
    9 = 813,840
    10 = 1042,1039,992
    11 = 891,906
    12 = 810,980,977
    13 = 1171,927
    14 = 1114,1117,1135
    15 = 674
    16 = 706,733,855
    17 = 757
    18 = 1199,1203,1206,1209,1212,1215,1218,1221,1224,1227,1230,1248,1180
    19 = 502,589,986,1003,1051
    20 = 1048,1093
    21 = 1174,968,959
    22 = 1292
    23 = 1271,1272
    24 = 1273,1274,1275,1276,1277,1278,1279,1280,1281,1282,1283,1284,1285,1286,1287,1288,1289,1290,1291
    25 = 635
    26 = 650,694,703,1045,1090
    27 = 1054,1111,1066
    28 = 828,1195,1177
    */
    $data = [
      '2,276,336,427', // 1
      '182,225,358', // 2
      '', // 3
      '246, 315, 348, 364, 386, 403, 418, 424, 409,284', // 4
      '383, 389, 421', // 5
      '1012', // 6
      '1260, 1261, 1262, 476,1257', // 7
      '431, 882, 1036', // 8
      '813, 840', // 9
      '1042, 1039, 992', // 10
      '891, 906', // 11
      '810, 980, 977', // 12
      '1171, 927', // 13
      '1114, 1117, 1135', // 14
      '674', // 15
      '706, 733, 855', // 16
      '757', // 17
      '1199, 1203, 1206, 1209, 1212, 1215, 1218, 1221, 1224, 1227, 1230, 1248, 1180', // 18
      '502, 589, 986, 1003, 1051', // 19
      '1048, 1093', // 20
      '1174, 968, 959', // 21
      '1292', // 22
      '1271, 1272', // 23
      '1273, 1274, 1275, 1276, 1277, 1278, 1279, 1280, 1281, 1282, 1283, 1284, 1285, 1286, 1287, 1288, 1289, 1290, 1291', // 24
      '635', // 25
      '650, 694, 703, 1045, 1090', // 26
      '1054, 1111, 1066', // 27
      '828, 1195, 1177,1251' // 28
    ];
    $indexes = range(1, 28); 
    for ($i=0; $i < count($data); $i++) { 
      $id_level_2 = $data[$i];
      $id_new = $indexes[$i];
      /* print_r($id_new );
      print_r(' : ');
      print_r($id_level_2);
      print_r('<pre>'); */
      /* 1251 เป็น level 1 */
      if ($id_new != 3) {
        $stmt = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 2 and prodType_id in ($id_level_2)");
        $stmt->execute();
        $result = $stmt->get_result();
        $response=array();
        if($result->num_rows > 0){
          while($res = $result->fetch_assoc()){
            $this->check_product_in_case($res['prodType_id'],$id_new);
            $stmt_level3 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 3 and prodType_ref_id in (".$res['prodType_id'].")");
            $stmt_level3->execute();
            $result_level3 = $stmt_level3->get_result();
            while($res_3 = $result_level3->fetch_assoc()){
              $this->check_product_in_case($res_3['prodType_id'],$id_new);
              $stmt_level4 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 4 and prodType_ref_id in (".$res_3['prodType_id'].")");
              $stmt_level4->execute();
              $result_level4 = $stmt_level4->get_result();
              while($res_4 = $result_level4->fetch_assoc()){
                $this->check_product_in_case($res_4['prodType_id'],$id_new);
                $stmt_level5 = $this->conn->prepare("SELECT * FROM `Product_Type` WHERE prodType_level = 5 and prodType_ref_id in (".$res_4['prodType_id'].")");
                $stmt_level5->execute();
                $result_level5 = $stmt_level5->get_result();
                while($res_5 = $result_level5->fetch_assoc()){
                  $this->check_product_in_case($res_5['prodType_id'],$id_new);
                }
              }
            }
          }
        }
      }
    }
    print_r('success');
    exit();
  }

  public function check_product_in_case($pro_id,$id_new) {
      /* print_r($pro_id); */
      $stmt = $this->conn->prepare("SELECT * FROM `Case` WHERE prodType_id = '$pro_id' and prodType_id_old = 0");
      if (!$stmt) {
        $errorInfo = $this->conn->errorInfo();
        die("SQL Error: " . $errorInfo[2]);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        while($res= $result->fetch_assoc()){
          $stmt_update = $this->conn->prepare("UPDATE `Case` set prodType_id = $id_new , prodType_id_old = $pro_id where case_id = '$res[case_id]'");
          $stmt_update->execute();
        }
      }
  }

  public function updateProduct() {
    /* print_r($pro_id); */
    $stmt = $this->conn->prepare("SELECT * FROM `Case` where prodType_id != ''");
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      while($res= $result->fetch_assoc()){
        if (!empty($res['prodType_id'])) {
          $stmt_update = $this->conn->prepare("UPDATE `Field_Values` set fieldset_value = '$res[prodType_id]' where fieldset_id IN (45,196) and case_id = '$res[case_id]'");
          $stmt_update->execute();
        }
      }
    }
    print_r('success');
    exit();
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

  /*** สำนัก ***/
  public function getOfficeType() {
    $stmt = $this->conn->prepare("SELECT * FROM office_type");
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      $response = array();

      while($res = $result->fetch_assoc()) {
        $sub_array = array();
        $sub_array["office_id"] = $res['office_id'];
        $sub_array["office_name"] = $res['office_name'];
        $sub_array["office_name_short"] = $res['office_name_short'];
        $response[] = $sub_array;
      }

      $stmt->close();
      return $response;
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
    public function checkVersionUpdate($build,$type) {


        $stmt1 = $this->conn->prepare("SELECT * FROM version_app WHERE version_type = '$type'");
        $stmt1->execute();
        $result1 = $stmt1->get_result();


        $stmt2 = $this->conn->prepare("SELECT * FROM version_app WHERE version_number = '$build'");
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if($result2->num_rows > 0){
          $stmt1->close();
          $stmt2->close();
          return NULL;
        }else{
          $stmt1->close();
          $stmt2->close();
          return $result1;
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

    /*** บันทึกข้อแนะนำติชม ***/
    public function feedbackSave($feedback_q_id,$feedback_a_result,$user_id) {

      $stmt = $this->conn->prepare("INSERT Feedback_App_List(feedback_list_datetime,feedback_list_by)
      VALUES( NOW(),'$user_id') ");
      $stmt->execute();
      $lastid = $this->conn->insert_id;

        foreach( $feedback_q_id as $index => $id ) {
          if($feedback_a_result[$index] != '' && $feedback_a_result[$index] != 'null'){
            $stmt = $this->conn->prepare("INSERT Feedback_App_Answers(feedback_list_id,feedback_q_id,feedback_a_result)
            VALUES('$lastid','$id','$feedback_a_result[$index]') ");
            $objQuery1 = $stmt->execute();
          }
        }

        if($objQuery1){
          $stmt->close();
          return TRUE;
        }else{
          $stmt->close();
          return FALSE;
        }
    }




    /*** รายการองค์ความรู้ ***/
    public function getKnowledge($limit,$offset,$filter,$sort) {
        // หา ID ของแต่ละเลเวล
        $res_filter = json_decode($filter,true);
        foreach($res_filter as $key=>$val)
        {
            if ($key=="a.prodType_id" && $val !="") {
                unset($res_filter["a.prodType_id"]);
                $id = $val;
                $stmt2 = $this->conn->prepare("select prodType_id,prodType_level from Product_Type where prodType_id =".$val);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
      					$res2 = $result2->fetch_assoc();
                for ($i=$res['prodType_level']; $i <=5 ; $i++) {
                          $stmt1 =$this->conn->prepare("select prodType_id from Product_Type where prodType_ref_id in($id) and prodType_level='".$i."'");
                          $stmt1->execute();
                          $result1 = $stmt1->get_result();
                          while ($res1 = $result1->fetch_assoc()) {
                               $id.=",".$res1['prodType_id'];
                          }
                }
                $res_filter["(a.prodType_id)"]=$id;
            }
        }

        $filter=json_encode($res_filter);
        $filtersql = $this->func->filter_sql($filter);
        $limitsql  = $this->func->limit_sql($limit,$offset);
        $sortsql   = $this->func->sort_sql($sort);
        $stmt = $this->conn->prepare("select case_id,caseDtl_title,b.prodType_id,b.prodType_name,b.prodType_name_en,compType_name,compType_name_en,d.incType_id,d.incType_name,d.incType_name_en
        from Case_Knowledge a
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
          return null;
          // return $filtersql;
          // return $test;
        }
    }



    /*** องค์ความรู้ ***/
    public function getIdKnowledge($knowledge_id) {
        $stmt = $this->conn->prepare("SELECT case_id,caseDtl_title,prodType_name,prodType_name_en,compType_name,compType_name_en,curren_name,caseDtl_derivation,caseDtl_damage_val,caseDtl_complnt_need,
          case_close_resultProcess,a.compTypeSub1_id,compTypeSub1_name,compTypeSub1_name_en,f.incType_id,f.incType_name,f.incType_name_en FROM `Case` a
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


    /*** รายละเอียดเคส ***/
    public function getCaseDetail($id) {
      $stmt = $this->conn->prepare("SELECT case_id, IF((IF(applntOrg_trade_number = '$id' || applnt_ident = '$id', 1, 0)) = 0, 2, 1) AS company_type, ca.compTypeSub2_id, compTypeSub2_name, reliable,case_create_datetime ,case_close_datetime
      FROM `Case` AS ca
      LEFT JOIN Complaint_Type_Sub2 AS cp2
      ON ca.compTypeSub2_id = cp2.compTypeSub2_id
      WHERE applntOrg_trade_number = '$id' OR applnt_ident = '$id' OR complnt_trade_number = '$id' ");
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
    /*** รายละเอียดเคสทั้งหมดในปีที่ส่งมา***/ 
    public function getCaseAllYear($year) {
      $year_set_2 = "1";
      if($year_set_2 == "2"){
        $year_start = ($year-1)."-10-01";
        $year_end = $year."-09-30";
        $where_date = "  (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }else {
        $year_start = $year."-01-01";
        $year_end = $year."-12-31";
        $where_date = "  (DATE(c.case_create_datetime) >= '".$year_start."' AND DATE(c.case_create_datetime) <= '".$year_end."')";
      }
      $sql ="SELECT c.case_id, c.case_status , c.complnt_trade_number, c.complnt_valid_ditp , c.complnt_valid_ditp_org , c.case_create_datetime,c.caseDtl_title FROM `Case` c WHERE $where_date ORDER BY c.case_id DESC";
      $stmt = $this->conn->prepare($sql);
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

    public function data_filter($value) {
      $newVal = trim($value);
      $newVal = htmlspecialchars($newVal);
      $newVal = mysqli_real_escape_string($this->conn,$newVal);
      return $newVal;
    }
    /*** รายละเอียดสถานะบริษัท ***/
    public function getCompanyStatusDetail($id) {
      $stmt = $this->conn->prepare("SELECT case_id, caseDtl_title, reliable, complnt_trade_number, complnt_name,complnt_contact_email,complnt_contact_tel, case_create_datetime, case_close_datetime, IF(c.prodType_id = 1251, c.prodType_other, p.prodType_name) AS product_name
      FROM `Case` AS c 
      LEFT JOIN `Product_Type` AS p ON c.prodType_id = p.prodType_id 
      WHERE reliable = '$id' ");
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
    public function getTypeComplaint($type) {
      $stmt = $this->conn->prepare("SELECT * FROM Complaint_Type WHERE compType_status = '0' ORDER BY compType_order_sort ASC ");
      $stmt->execute();
      $result = $stmt->get_result();

      if($result->num_rows > 0){
        $response = array();
        $Complaint_Type = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub1 WHERE `compTypeSub1_id` = $type");
        $Complaint_Type->execute();
        $Result_ComplaintType = $Complaint_Type->get_result();
        while($res = $Result_ComplaintType->fetch_assoc()){
          $sub_array = array();
          $sub_array["compTypeSub_id"] = $res['compTypeSub1_id'];
          $sub_array["compType_id"] = $res['compType_id'];
          $sub_array["compTypeSub_name"] = $res['compTypeSub1_name'];
          $sub_array["compTypeSub_name_en"] = $res['compTypeSub1_name_en'];
          $sub_array["compTypeSub_status"] = $res['compTypeSub1_status'];
          $sub_array["form_id"] = $res['form_id'];
          $sub_array["compTypeSub_create_datetime"] = $res['compTypeSub1_create_datetime'];
          $sub_array["compTypeSub_createBy_id"] = $res['compTypeSub1_createBy_id'];
          $sub_array["compTypeSub_update_datetime"] = $res['compTypeSub1_update_datetime'];
          $sub_array["compTypeSub_updateBy_id"] = $res['compTypeSub1_updateBy_id'];
          $sub_array["levelmenu"] = 1;
          $response[] = $sub_array;
          
          foreach($response as $key => $value){
            $response_sub1 = array();
            $Complaint_Type1 = $this->conn->prepare("SELECT * FROM Complaint_Type WHERE compType_id = 4 OR compType_id = 6 OR compType_id = 1");
            $Complaint_Type1->execute();
            $Result_ComplaintType1 = $Complaint_Type1->get_result();

            $Complaint_Type2 = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub2_id = 9");
            $Complaint_Type2->execute();
            $Result_ComplaintType2 = $Complaint_Type2->get_result();

            while($res = $Result_ComplaintType2->fetch_assoc()){
              $sub_array = array();
              $sub_array["compType1_id"] = $res['compTypeSub2_id'];
              $sub_array["compType1_name"] = $res['compTypeSub2_name'];
              $sub_array["compType1_name_en"] = $res['compTypeSub2_name_en'];
              $sub_array["compType1_status"] = $res['compTypeSub2_status'];
              $sub_array["form_id"] = $res['form_id'];
              $sub_array["compType1_create_datetime"] = $res['compTypeSub2_create_datetime'];
              $sub_array["compType1_createBy_id"] = $res['compTypeSub2_createBy_id'];
              $sub_array["compType1_update_datetime"] = $res['compTypeSub2_update_datetime'];
              $sub_array["compType1_updateBy_id"] = $res['compTypeSub2_updateBy_id'];
              $sub_array["levelmenu"] = 2;
              $response_sub1[] = $sub_array;
            }

            while($res = $Result_ComplaintType1->fetch_assoc()){
              $sub_array = array();
              $sub_array["compType1_id"] = $res['compType_id'];
              $sub_array["compType1_name"] = $res['compType_name'];
              $sub_array["compType1_name_en"] = $res['compType_name_en'];
              $sub_array["compType1_other_flag"] = $res['compType_other_flag'];
              $sub_array["compTypeScompType1_order_sortub_status"] = $res['compType_order_sort'];
              $sub_array["compType1_status"] = $res['compType_status'];
              $sub_array["compType1_section"] = $res['compType_section'];
              $sub_array["compType1_duration"] = $res['compType_duration'];
              $sub_array["form_id"] = $res['form_id'];
              $sub_array["compType1_create_datetime"] = $res['compType_create_datetime'];
              $sub_array["compType1_createBy_id"] = $res['compType_createBy_id'];
              $sub_array["compType1_update_datetime"] = $res['compType_update_datetime'];
              $sub_array["compType1_updateBy_id"] = $res['compType_updateBy_id'];
              $sub_array["levelmenu"] = 2;


              if($res['compType_id'] == 1){
                $Complaint_Type2 = $this->conn->prepare("SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub2_id = 7 OR compTypeSub2_id = 8 OR compTypeSub2_id = 12");
                $Complaint_Type2->execute();
                $Result_ComplaintType2 = $Complaint_Type2->get_result();
                while($res = $Result_ComplaintType2->fetch_assoc()){
                  $sub_array1 = array();
                  $sub_array1["compTypeSub2_id"] = $res['compTypeSub2_id'];
                  $sub_array1["compTypeSub1_id"] = $res['compTypeSub1_id'];
                  $sub_array1["compTypeSub2_name"] = $res['compTypeSub2_name'];
                  $sub_array1["compTypeSub2_name_en"] = $res['compTypeSub2_name_en'];
                  $sub_array1["compTypeSub2_status"] = $res['compTypeSub2_status'];
                  $sub_array1["form_id"] = $res['form_id'];
                  $sub_array1["compTypeSub2_create_datetime"] = $res['compTypeSub2_create_datetime'];
                  $sub_array1["compTypeSub2_createBy_id"] = $res['compTypeSub2_createBy_id'];
                  $sub_array1["compTypeSub2_update_datetime"] = $res['compTypeSub2_update_datetime'];
                  $sub_array1["compTypeSub2_updateBy_id"] = $res['compTypeSub2_updateBy_id'];
                  $sub_array1["levelmenu"] = 3;
                  $sub_array['compTypeSub2'][] = $sub_array1;
                }
              }
              $response_sub1[] = $sub_array;
            }
            $response[$key]['compTypeSub1'] = $response_sub1;
          }
        }
        return $response;
        
      }else{
        $stmt->close();
        return NULL;
      }
  }

  public function total_per($t1, $t2) {
    $pp_per = ($t1/$t2)*100;
    return $pp_per;
  }

  /*** dashboardChart ***/
  public function getDashboardChart($startDate, $stopDate) {

    // echo ($startDate.' - '.$stopDate);

    $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
    $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
    $startDateY = $startDateY-543;
    $stopDateY = $stopDateY-543;
    $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
    $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
    $startDateY =  $startDateY."/".$startDate;
    $stopDateY=  $stopDateY."/".$stopDate;

    $where_year = " AND DATE(case_create_datetime) >= '$startDateY'  AND DATE(case_create_datetime) <= '$stopDateY' ";

    // echo $where_year ;


    $sql_countt1 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id != 162 AND compType_id IN (1, 6, 4) $where_year");
    $sql_countt1->execute();
    $query_countt1 = $sql_countt1->get_result();
    $re_total1 = $query_countt1->fetch_assoc();


    $sql_countt2 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id = 162 AND compType_id IN (1, 6, 4) $where_year");
    $sql_countt2->execute();
    $query_countt2 = $sql_countt2->get_result();
    $re_total2 = $query_countt2->fetch_assoc();

    // echo $re_total1['case_id'];

    
    $re_total = $re_total1['case_id']+$re_total2['case_id'];

    $sql_countt3 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 1 $where_year");
    $sql_countt3->execute();
    $query_countt3 = $sql_countt3->get_result();
    $case_total1 = $query_countt3->fetch_assoc();


    $sql_countt4 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 6 $where_year");
    $sql_countt4->execute();
    $query_countt4 = $sql_countt4->get_result();
    $case_total2 = $query_countt4->fetch_assoc();

    $sql_countt5 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 4 $where_year");
    $sql_countt5->execute();
    $query_countt5 = $sql_countt5->get_result();
    $case_total3 = $query_countt5->fetch_assoc();

    $case_total = $case_total1['case_id'] + $case_total2['case_id'] + $case_total3['case_id'];

    $response = array();

    $subject = ['ผู้ร้องเรียน', 'เรื่องร้องเรียน'];

    //ผู้ร้องเรียน
    $sub_array = array();
    $sub_array["subject"] = 'ผู้ร้องเรียน';
    $sub_array["value"] = $re_total;
    $sub_array["graph_type"] = 'pie';

    $complainant = ['ไทย', 'ต่างประเทศ'];

    $isThai = ['!= 162', '= 162'];

    $i = 0;
    foreach($complainant as $key => $complnt) {
      $j= $i+1;
      $sub_array1 = array();
      $sub_array1['name'] = $complnt;
      $sub_array1['value'] = ${"re_total$j"}['case_id'];
      $sub_array1['unit'] = 'ราย';

      $case_per = $this->total_per(${"re_total$j"}['case_id'], $re_total);
      $sub_array1['percent'] = round($case_per);

        $comp_id = $this->conn->prepare("SELECT * FROM `Complaint_Type` WHERE `compType_status` = 0 AND compType_id IN(1,6,4) ORDER BY compType_order_sort ASC");
        $comp_id->execute();
        $res_comp_id = $comp_id->get_result();
        if($res_comp_id->num_rows > 0) {
          while($res = $res_comp_id->fetch_assoc()) {
            $sub_array2 = array();
            $sub_array2['name'] = $res['compType_name'];

            $comp_case = $this->conn->prepare("SELECT count(c.compType_id) as compType_id FROM `Case` as c left join Complaint_Type as ct on c.compType_id = ct.compType_id WHERE c.compType_id = '".$res['compType_id']."' AND c.complnt_country_id ".$isThai[$i]." $where_year ");
            $comp_case->execute();
            $res_comp_case = $comp_case->get_result();
            while($res_case = $res_comp_case->fetch_assoc()) {
              $sub_array2['value'] = $res_case['compType_id'];
              $sub_array2['unit'] = 'ราย';

              $case_per = $this->total_per($res_case['compType_id'], ${"re_total$j"}['case_id']);
              $sub_array2['percent'] = round($case_per);
            }
            $sub_array1['answer_detail'][] = $sub_array2;
            
          }
        }

        $i = $i + 1;

        $sub_array['answer'][] = $sub_array1;
    }
    $response[] = $sub_array;


    //เรื่องร้องเรียน
    $sub_array = array();
    $sub_array["subject"] = 'เรื่องร้องเรียน';
    $sub_array["value"] = $case_total;
    $sub_array["graph_type"] = 'pie';

    $comp_id = $this->conn->prepare("SELECT * FROM `Complaint_Type` WHERE `compType_status` = 0 AND compType_id IN(1,6,4) ORDER BY compType_order_sort ASC");
    $comp_id->execute();
    $res_comp_id = $comp_id->get_result();
    if($res_comp_id->num_rows > 0) {
      $i = 0;
      while($res = $res_comp_id->fetch_assoc()) {
        $j= $i+1;
        $sub_array1 = array();
        $sub_array1['name'] = $res['compType_name'];
        $sub_array1['value'] = ${"case_total$j"}['case_id'];
        $sub_array1['unit'] = 'ราย';

        $case_per = $this->total_per(${"case_total$j"}['case_id'], $case_total);
        $sub_array1['percent'] = round($case_per);

        $i = $i + 1;

        $k = 0;
        foreach($complainant as $key => $complnt) {
          $sub_array2 = array();
          $sub_array2['name'] = $complnt;
          
          $comp_case = $this->conn->prepare("SELECT count(c.compType_id) as compType_id FROM `Case` as c left join Complaint_Type as ct on c.compType_id = ct.compType_id WHERE c.compType_id = '".$res['compType_id']."' AND c.complnt_country_id ".$isThai[$k]." $where_year ");
          $comp_case->execute();
          $res_comp_case = $comp_case->get_result();
          while($res_case = $res_comp_case->fetch_assoc()) {
            $sub_array2['value'] = $res_case['compType_id'];
            $sub_array2['unit'] = 'ราย';

            $case_per = $this->total_per($res_case['compType_id'], ${"case_total$j"}['case_id']);
            $sub_array2['percent'] = round($case_per);
          }
          $sub_array1['answer_detail'][] = $sub_array2;
          $k = $k + 1;
        }

        $sub_array['answer'][] = $sub_array1;


      }

    }


    $response[] = $sub_array;


    return $response;
    exit();
  }


  /*** dashboardCase ***/
  public function getDashboardCase($startDate, $stopDate) {

    // echo ($startDate.' - '.$stopDate);

    $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
    $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
    $startDateY = $startDateY-543;
    $stopDateY = $stopDateY-543;
    $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
    $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
    $startDateY =  $startDateY."/".$startDate;
    $stopDateY=  $stopDateY."/".$stopDate;

    $where_year = " AND DATE(case_create_datetime) >= '$startDateY'  AND DATE(case_create_datetime) <= '$stopDateY' ";

    $sql_countt1 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id != 162 AND compType_id IN (1, 6, 4) $where_year");
    $sql_countt1->execute();
    $query_countt1 = $sql_countt1->get_result();
    $re_total1 = $query_countt1->fetch_assoc();

    $sql_countt2 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE complnt_country_id = 162 AND compType_id IN (1, 6, 4) $where_year");
    $sql_countt2->execute();
    $query_countt2 = $sql_countt2->get_result();
    $re_total2 = $query_countt2->fetch_assoc();

    $re_total = $re_total1['case_id']+$re_total2['case_id'];

    $sql_countt3 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 1 $where_year");
    $sql_countt3->execute();
    $query_countt3 = $sql_countt3->get_result();
    $case_total1 = $query_countt3->fetch_assoc();


    $sql_countt4 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 6 $where_year");
    $sql_countt4->execute();
    $query_countt4 = $sql_countt4->get_result();
    $case_total2 = $query_countt4->fetch_assoc();

    $sql_countt5 = $this->conn->prepare("SELECT count(case_id) as case_id FROM `Case` WHERE compType_id = 4 $where_year");
    $sql_countt5->execute();
    $query_countt5 = $sql_countt5->get_result();
    $case_total3 = $query_countt5->fetch_assoc();

    $case_total = $case_total1['case_id'] + $case_total2['case_id'] + $case_total3['case_id'];

    $response = array();

    //ผู้ประกอบการในไทยร้องเรียน
    $sub_array = array();

    $isThai = ['!= 162', '= 162'];

    $complainant = ['ผู้ประกอบการในไทยร้องเรียน', 'ผู้ประกอบการในต่างประเทศร้องเรียน'];

    $i = 0;
    foreach($complainant as $key => $complnt) {
      $j= $i+1;
      $sub_array = array();
      $sub_array['name'] = $complnt;
      $sub_array['case'] = ${"re_total$j"}['case_id'];

      $case_per = $this->total_per(${"re_total$j"}['case_id'], $re_total);
      $sub_array['percent'] = round($case_per);

        $comp_id = $this->conn->prepare("SELECT * FROM `Complaint_Type` WHERE `compType_status` = 0 AND compType_id IN(1,6,4) ORDER BY compType_order_sort ASC");
        $comp_id->execute();
        $res_comp_id = $comp_id->get_result();
        if($res_comp_id->num_rows > 0) {
          $s = 1;
          while($res = $res_comp_id->fetch_assoc()) {
            $sub_array1 = array();
            $sub_array1['name'] = $res['compType_name'];

            $comp_case = $this->conn->prepare("SELECT count(c.compType_id) as compType_id FROM `Case` as c left join Complaint_Type as ct on c.compType_id = ct.compType_id WHERE c.compType_id = '".$res['compType_id']."' AND c.complnt_country_id ".$isThai[$i]." $where_year ");
            $comp_case->execute();
            $res_comp_case = $comp_case->get_result();
            while($res_case = $res_comp_case->fetch_assoc()) {
              $sub_array1['case'] = $res_case['compType_id'];

              $case_per = $this->total_per($res_case['compType_id'], ${"re_total$j"}['case_id']);
              $sub_array1['percent'] = round($case_per);
            }

            if($s == 1) {
              $comp2_id = $this->conn->prepare("SELECT * FROM `Complaint_Type_Sub2` WHERE  compTypeSub2_id IN(1, 2, 3, 7, 8, 9, 11, 12) GROUP BY `compTypeSub2_name`");
              $comp2_id->execute();
              $res_comp2_id = $comp2_id->get_result();
              if($res_comp2_id->num_rows > 0) {
                while($res2 = $res_comp2_id->fetch_assoc()) {
                  $sub_array2 = array();
                  $text = '';

                  if($complnt == 'ผู้ประกอบการในไทยร้องเรียน') {
                    if($res2['compTypeSub2_id'] == 2) {
                      $text = "(IM)";
                    } else if($res2['compTypeSub2_id'] == 1) {
                      $text = "(EX)";
                    }
                  } else {
                    if($res2['compTypeSub2_id'] == 1) {
                      $text = "(IM)";
                    } else if($res2['compTypeSub2_id'] == 2) {
                      $text = "(EX)";
                    }
                  }
                  
                  $sub_array2['name'] = $res2['compTypeSub2_name'] . ' ' . $text;

                  $compTypeSub2_id = '';
                  if($res2['compTypeSub2_id'] == 1) {
                    $compTypeSub2_id = '(1, 7)';
                  } else if($res2['compTypeSub2_id'] == 2) {
                    $compTypeSub2_id = '(2, 8)';
                  } else if($res2['compTypeSub2_id'] == 3) {
                    $compTypeSub2_id = '(3, 9)';
                  } else if($res2['compTypeSub2_id'] == 11) {
                    $compTypeSub2_id = '(11, 12)';
                  }

                  $comp2_case = $this->conn->prepare("SELECT count(c.compType_id) as compType_id
                                                      FROM `Case` as c
                                                      left join Complaint_Type as ct
                                                      on c.compType_id = ct.compType_id
                                                      WHERE c.compTypeSub2_id IN $compTypeSub2_id
                                                      AND c.complnt_country_id ".$isThai[$i]." AND c.compType_id = 1 $where_year ");
                  $comp2_case->execute();
                  $res_comp2_case = $comp2_case->get_result();
                  while($res2_case = $res_comp2_case->fetch_assoc()) {
                    $sub_array2['case'] = $res2_case['compType_id'];
      
                    $case_per = $this->total_per($res2_case['compType_id'], ${"re_total$j"}['case_id']);
                    $sub_array2['percent'] = round($case_per);
                  }

                  $sub_array1['answer_detail'][] = $sub_array2;
                }
              }
            }
            
            $s = $s + 1;
            $sub_array['answer'][] = $sub_array1;
          }
        }

        $i = $i + 1;

      $response[] = $sub_array;
    }

    return $response;
    exit();

  }


  /*** dashboardCaseStatus ***/
  public function getDashboardCaseStatus($request_post, $startDate, $stopDate, $status_complaint, $applnt_country, $office_id, $text) {

    // echo ($startDate.' - '.$stopDate);

    $where_year = '';
    if($startDate != '' && $stopDate != '') {
      $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
      $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
      $startDateY = $startDateY-543;
      $stopDateY = $stopDateY-543;
      $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
      $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
      $startDateY =  $startDateY."/".$startDate;
      $stopDateY=  $stopDateY."/".$stopDate;

      $where_year = " AND DATE(case_create_datetime) >= '$startDateY'  AND DATE(case_create_datetime) <= '$stopDateY' ";

    }

    $where_text = '';
    if($text != '') {
      $where_text = " AND (c.caseDtl_title LIKE '%".$text."%' OR c.case_id LIKE '%".$text."%' OR cy.name LIKE '%".$text."%' OR pt.prodType_name LIKE '%".$text."%' OR ot.office_name LIKE '%".$text."%' OR ot.office_name_short LIKE '%".$text."%')";
    }

    $where_status = '';
    if($status_complaint != '') {
      if($status_complaint == 1) {
        $status_c = '1, 2';
      } else if($status_complaint == 2) {
        $status_c = '3';
      } else {
        $status_c = '0';
      }
      $where_status = 'AND c.case_status IN ('.$status_c.') ';

    }

    $where_applnt_country = '';
    if($applnt_country != '') {
      $where_applnt_country = " AND c.applnt_country_id = ".$applnt_country;
    }

    $where_office = '';
    if($office_id != '') {
      $where_office = " AND c.office_id = ".$office_id;
    }

    $response = array();
    $sub_array = array();
    $sub1_array = array();
    $sub2_array = array();

    for($i = 0; $i<3; $i++) {

      // $where_status = '';
      $k = $i;
      if($status_complaint == '') {
        if($i == 1) {
          $k = '1, 2';
        } else if($i == 2) {
          $k = 3;
        }
        $where_status = 'AND c.case_status IN ('.$k.') ';
      }
      
      $sql = "SELECT count(c.case_status) AS countCaseStatus 
              FROM `Case` AS c
              LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
              LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
              LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
              LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
              LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
              LEFT JOIN `office_type` AS ot ON c.office_id = ot.office_id
              LEFT JOIN `Country` AS cy ON c.applnt_country_id = cy.id
              LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id 
              WHERE 1 $where_year $where_status $where_text $where_applnt_country $where_office";

      // print_r($sql);
      // die();

      $sql_casestatus = $this->conn->prepare($sql);
      $sql_casestatus->execute();
      $res_casestatus = $sql_casestatus->get_result();
      $res = $res_casestatus->fetch_assoc();

      $case_status = ''; 
      if($i == 0) {
        $case_status = 'รอดำเนินการ'; 
      } else if($i == 1) {
        $case_status = 'กำลังดำเนินการ'; 
      } else if($i == 2) {
        $case_status = 'เสร็จสิ้น'; 
      }

      // print_r($status_complaint);


      if($status_complaint != '') {
        if($status_complaint != $i) {
          $res['countCaseStatus'] = 0;
        }
      }

      $sub2_array['status'] = $case_status;
      $sub2_array['value'] = $res['countCaseStatus'];
      
      $sub1_array[] = $sub2_array;

    }

    $sub_array['countCaseStatus'] = $sub1_array;
    $response[] = $sub_array;


    // return $response;

    // die();
    $where_status = '';
    if($status_complaint != '') {
      if($status_complaint == 1) {
        $status_complaint = '1, 2';
      } else if($status_complaint == 2) {
        $status_complaint = '3';
      }
      $where_status = 'AND case_status IN ('.$status_complaint.') ';

    }

    $sub_array = array();
    $sub1_array = array();

    $sql = "SELECT * FROM (
      (SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.case_id,
    ot.office_name,
    ot.office_name_short,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
    c.compType_id,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    c.case_compType_duration,
    c.reliable,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    c.applnt_valid_ditp,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    cy.name,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `office_type` AS ot ON c.office_id = ot.office_id
    LEFT JOIN `Country` AS cy ON c.applnt_country_id = cy.id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id WHERE 1 AND c.case_status IN(0) $where_year $where_applnt_country $where_office $where_text  ORDER BY c.case_id DESC ) UNION ALL
    (SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.case_id,
    ot.office_name,
    ot.office_name_short,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
    c.compType_id,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    c.case_compType_duration,
    c.reliable,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    c.applnt_valid_ditp,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    cy.name,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `office_type` AS ot ON c.office_id = ot.office_id
    LEFT JOIN `Country` AS cy ON c.applnt_country_id = cy.id 
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id WHERE 1 AND c.case_status IN(1, 2) $where_year $where_applnt_country $where_office $where_text  ORDER BY c.case_id DESC ) UNION ALL
    (SELECT
    c.case_create_datetime,
    c.case_receivedoc_date,
    c.office_id,
    c.case_id,
    ot.office_name,
    ot.office_name_short,
    c.prodType_other,
    c.caseDtl_title,
    c.case_status,
    c.compType_id,
    c.compTypeSub1_id,
    c.compTypeSub2_id,
    ct.compType_name,
    c.case_compType_duration,
    c.reliable,
    ct1.compTypeSub1_name,
    ct2.compTypeSub2_name,
    c.prodType_id,
    pt.prodType_name,
    c.applnt_firstname,
    c.applnt_lastname,
    c.complnt_name,
    c.case_close_datetime,
    c.caseCh_id,
    c.applnt_country_id,
    c.complnt_country_id,
    ch.caseCh_name,
    c.case_opened_datetime,
    c.case_close_resultProcess,
    c.applnt_valid_ditp,
    c.caseClose_id,
    c.incType_id,
    it.incType_name,
    ch.caseCh_section,
    cy.name,
    c.case_lastSave_datetime
    FROM `Case` AS c
    LEFT JOIN `Complaint_Type` AS ct ON c.compType_id = ct.compType_id
    LEFT JOIN `Complaint_Type_Sub1` AS ct1 ON c.compTypeSub1_id = ct1.compTypeSub1_id
    LEFT JOIN `Complaint_Type_Sub2` AS ct2 ON c.compTypeSub2_id = ct2.compTypeSub2_id
    LEFT JOIN `Product_Type` AS pt ON c.prodType_id = pt.prodType_id
    LEFT JOIN `Case_Channel` AS ch ON c.caseCh_id = ch.caseCh_id
    LEFT JOIN `office_type` AS ot ON c.office_id = ot.office_id
    LEFT JOIN `Country` AS cy ON c.applnt_country_id = cy.id
    LEFT JOIN `Incorrect_Type` AS it ON c.incType_id = it.incType_id WHERE 1 AND c.case_status IN(3) $where_year $where_applnt_country $where_office $where_text  ORDER BY c.case_id DESC ) ) t1";
    $sql .= " WHERE 1 $where_status ORDER BY case_status ASC, case_id DESC";


    // if($request_post['sort']=="case_id"){
    //   $sort_col = "c.case_id";
    // }

    // $sql .= " ORDER BY $sort_col  ".$request_post['order']." ";

    $sql .= " LIMIT ".$request_post['offset']." , ".$request_post['limit']." ";

    // print_r($sql);
    // die();

    $sql_casestatus = $this->conn->prepare($sql);
    $sql_casestatus->execute();
    $res_casestatus = $sql_casestatus->get_result();

    if($res_casestatus->num_rows > 0) {
      while($res = $res_casestatus->fetch_assoc()) {
        // print_r($res);
        $sub2_array = array();

        $month_names_short = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];

        $date_time = $res['case_create_datetime'];
        $date_time_ex = explode(" ",$date_time);
        $date_waitting = $date_time_ex[0];
        $date_ex = explode("-",$date_waitting);
        $date_year = $date_ex[0]+543;
        $date_month = (int)(number_format($date_ex[1]));

        $case_create_datetime = $date_ex[2]." ".$month_names_short[$date_month]." ".$date_year;

        $sub2_array['case_id'] = $res['case_id'];
        $sub2_array['date'] = $case_create_datetime;
        $sub2_array['title'] = $res['caseDtl_title'];
        $sub2_array['product_id'] = $res['prodType_id'];
        $sub2_array['product_name'] = $res['prodType_name'];

        $sub2_array['applnt_country'] = $res['name'];
        $sub2_array['office_id'] = $res['office_id'];
        $sub2_array['office_name_short'] = $res['office_name_short'];

        $case_status = ''; 
        if($res['case_status'] == 0) {
          $case_status = 'รอดำเนินการ'; 
        } else if($res['case_status'] == 1 || $res['case_status'] == 2) {
          $case_status = 'กำลังดำเนินการ'; 
        } else if($res['case_status'] == 3) {
          $case_status = 'เสร็จสิ้น'; 
        }
        $sub2_array['case_status'] = $case_status;

        $sub1_array[] = $sub2_array;
      }
    }

    $sub_array['caseDetail'] = $sub1_array;
    $response[] = $sub_array;


    return $response;
    exit();

  }


    /*** เช็ค user จาก apikey ***/
    public function isValidApiKey($api_key) {
      $stmt = $this->conn->prepare("SELECT member_id from Member WHERE ssoid = '$api_key' GROUP BY ssoid ");
      // echo $api_key;
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
                      $sqlAss=$this->conn->prepare("INSERT INTO Message_Box_Log(msgBox_id,recipient_id,recipient_type,msgBoxLog_datetime,msgBox_noti_status,msgBox_noti_datetime,msgBox_read_status,msgBox_read_datetime) VALUES(".$new_message_id.",".$data['emp_id'].",'2',now(),'1',now(),'1',now())");
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
    public function createComplaint($request_post, $compType_id,$compTypeSub1_id,$compTypeSub2_id,$case_status,$case_assign_status,$caseCh_id,$case_priority,$case_receivedoc_real_datetime, $case_disKPI_status,$caseDtl_title,$prodType_id,$caseDtl_derivation,$caseDtl_damage_val,$curren_id,$caseDtl_complnt_need,
      $applnt_ident, $applnt_firstname, $applnt_lastname, $applnt_tel, $applnt_email, $applnt_address, $applnt_import_export, $applnt_prov_id, $applnt_zipcode, $applnt_country_id, $applnt_type, $applnt_mobile_code, $applnt_mobile_country,
      $applntOrg_trade_number,$applntOrg_name, $applntOrg_import_export, $applntOrg_branch, $applntOrg_position, $applntOrg_tel, $applntOrg_web, $applntOrg_country_id, $applntOrg_address, $applntOrg_prov_id, $applntOrg_zipcode, $applntOrg_mobile_code, $applntOrg_mobile_country, 
      $complnt_trade_number, $complnt_name, $complnt_import_export, $complnt_branch, $complnt_contact_name, $complnt_contact_tel, $complnt_contact_email, $complnt_web, $complnt_contact_address, $complnt_prov_id, $complnt_country_id, $complnt_zipcode, $complnt_mobile_code, $complnt_mobile_country, 
      $case_receivedoc_date, $case_create_datetime, $case_createBy_id, $complnt_file, $incType_id, $compType_other, $incType_other,$prodType_other, $isStaff, $case_createBy_staff_id, $totalFiles) {

        // mysqli_begin_transaction($this->conn);

        $stmt = $this->conn->prepare("SELECT office_id FROM Product_Type WHERE prodType_id = '$prodType_id' ");
        $stmt->execute();
        $result = $stmt->get_result();
        $res2 = $result->fetch_assoc();
        if($compType_id=="6"){
          $res2["office_id"] = 0;
        }

        $stmt = $this->conn->prepare("SELECT compType_duration FROM `Complaint_Type` WHERE compType_id = '$compType_id'");
        $stmt->execute();
        $result = $stmt->get_result();
        $resDu = $result->fetch_assoc();
        $case_compType_duration = $resDu['compType_duration'];

        $sql = "INSERT INTO `Case`(compType_id,compTypeSub1_id,compTypeSub2_id,case_status,case_assign_status,caseCh_id,case_priority,case_receivedoc_real_datetime,
        case_disKPI_status,caseDtl_title,prodType_id,caseDtl_derivation,caseDtl_damage_val,curren_id,caseDtl_complnt_need,
        applnt_ident,applntOrg_trade_number,applnt_firstname,applnt_type,complnt_trade_number,
        complnt_name,case_receivedoc_date,case_createBy_id,applnt_lastname,applntOrg_name, isStaff, case_createBy_staff_id,
        applnt_country_id,complnt_country_id,case_create_datetime,incType_id,applntOrg_country_id, case_compType_duration,compType_other,incType_other,prodType_other,office_id)
        VALUES('$compType_id','$compTypeSub1_id','$compTypeSub2_id','$case_status','$case_assign_status','$caseCh_id','$case_priority','$case_receivedoc_real_datetime','
        $case_disKPI_status','$caseDtl_title','$prodType_id','$caseDtl_derivation','$caseDtl_damage_val','$curren_id','$caseDtl_complnt_need','
        $applnt_ident','$applntOrg_trade_number','$applnt_firstname','$applnt_type','$complnt_trade_number','
        $complnt_name','$case_receivedoc_date','$case_createBy_id','$applnt_lastname','$applntOrg_name', '$isStaff', '$case_createBy_staff_id',
        '$applnt_country_id','$complnt_country_id','$case_create_datetime','$incType_id','$applntOrg_country_id', '$case_compType_duration','$compType_other',
        '$incType_other','$prodType_other','0')";

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();

        $mailsent = array();
        $namesent = array();


        if ($result) {

          $caseid = $this->conn->insert_id;
          


          $stmt4 = $this->conn->prepare("SELECT * from Complaint_Type WHERE compType_id = '$compType_id' ");
          $stmt4->execute();
          $result4 = $stmt4->get_result();
          $res4 = $result4->fetch_assoc();

          if($res4['compType_section']==1){
              $stmt3 = $this->conn->prepare("SELECT * from Employee a
              LEFT JOIN Employee_Group b ON (a.empGroup_id=b.empGroup_id)
              WHERE office_id = '$res2[office_id]' AND emp_status = '0' AND empGroup_level = '2' ");
          }else if($res4['compType_section']==2){
              $stmt3 = $this->conn->prepare("SELECT * from Employee a
              LEFT JOIN Employee_Group b ON (a.empGroup_id=b.empGroup_id)
              WHERE empGroup_section = '2' AND emp_status = '0' AND empGroup_level = '2' ");
          }

          $stmt3->execute();
          $result3 = $stmt3->get_result();
          while($res3 = $result3->fetch_assoc())
          {
            array_push($mailsent,$res3["emp_email"]);
            array_push($namesent,$res3["emp_firstname"]." ".$res3["emp_lastname"]);
          }

          $subject = "ท่านได้รับเรื่องร้องเรียน CASE ID: ".$caseid." จากผู้ประกอบการผ่านแอปพลิเคชัน DITP Care ";
          $message =  "ท่านได้รับเรื่องร้องเรียน <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$caseid."\">Case ID: ".$caseid."</a> จากผู้ประกอบการผ่านแอปพลิเคชัน DITP Care ท่านสามารถดำเนินการรับเรื่องร้องเรียนได้ที่ <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$caseid."\">http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$caseid."</a> ค่ะ";
          $html_message = '<div class="wrapper" style="width:860px; background: #f8f8f8;">
            <div class="header" style="width:auto">
              <img src="http://'.$_SERVER["HTTP_HOST"].'/img/header_email_2.png" style="max-width: 860px;"  srtlw="width:100%; height:auto;" />
            <div>
            <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
              <!-- ข้อความ -->
              '.$message.'
            </div>
            <hr style="border-color:#fefefe; margin:0px;" />
            <div class="footer" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
              ขอบคุณ.<br />
              ทีมงาน <a href="http://'.$_SERVER["HTTP_HOST"].'" target="blank">'.$_SERVER["HTTP_HOST"].'</a>
            </div>
          </div>';
          $result = $this->func->sendEmail("ditp.noreply@gmail.com","Noreply DITP",$mailsent,$namesent,$subject,$html_message,"","","2");


            foreach ($request_post as $key => $value) {
              $res = $this->createComplaintField($key, $value, $caseid, $request_post['formSetId_P']);
            }

            $n = 0;

            
            if ($totalFiles != 0) {
              for($i = 0; $i < $totalFiles; $i++) {
                $name = $complnt_file['complnt_file']['name'];
                $tmp_name = $complnt_file['complnt_file']['tmp_name'];
                $complnt_file_title = $request_post['complnt_file_title'];
                
                $nameiamge = time();
                $nameiamge=$nameiamge.$n++;
                $textreturn = explode(".",$name[$i]);
                // $textreturn = $this->func->check_baseimg_ext($value);
                $namefile = 'caseAttach_file_'.$caseid.'_'.$nameiamge.'.'.$textreturn[1];
                // $uploadFileNew = $this->func->create_folder('case_attach',$caseid,'/',$namefile,"2"); //caseAttach_file_6_1492771842
  
                if (!is_dir('../../data')){
                    mkdir('../../data', 0777, true);
                }
                if (!is_dir('../../data/case_attach')){
                    mkdir('../../data/case_attach', 0777, true);
                }
                if (!is_dir('../../data/case_attach/'.$caseid.'/')){
                    mkdir('../../data/case_attach/'.$caseid.'/', 0777, true);
                }
  
                $uploadFileNew = "../../data/case_attach/".$caseid."/".$namefile;
  
                // $success = file_put_contents($uploadFileNew, $namefile);
                
                if(copy($tmp_name[$i],$uploadFileNew)){
                    $stmt = $this->conn->prepare("INSERT INTO Case_Attachfile(
                      case_id,caseAttach_title,caseAttach_file_path,caseAttach_file_oldname,
                      caseAttach_file_name,caseAttach_file_ext,caseAttach_status,
                      caseAttach_create_datetime,caseAttach_createBy_id)
                    VALUES('$caseid','$complnt_file_title[$i]','data/case_attach/$caseid/$namefile','$name[$i]',
                    '$namefile','$textreturn[1]','0',NOW(),'$case_createBy_id')");
                    $result3 = $stmt->execute();
                    if($result3){
                      mysqli_commit($this->conn);
                    }
                }
              }
            }
  

            //   หากคนที่สร้าง case เป็นนิติบุคคลหรือคนทั่วไป

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

            

            /******/
            $cpr_contactfname = $applnt_firstname;
            $cpr_contactlname = $applnt_lastname;
            $cpr_department = $applnt_type;
            $cpr_contact_person = $applnt_firstname." ".$applnt_lastname;
            $cpr_email = $request_post['applnt_email'];
            $prov_id = '';
            $cpr_import = 0;
            $cpr_create_datetime = date("Y-m-d H:i:s");
            $cpr_createBy_id = $case_createBy_id;
            $cpr_update_datetime = date("Y-m-d H:i:s");
            $cpr_updateBy_id = $case_createBy_id;
            $cpr_status = "0";

            /*****/

            //ถ้าเป็น ผู้ประกอบการในไทยร้องเรียนผู้ประกอบการในต่างประเทศ
            // if($compTypeSub1_id == 6 || ($compTypeSub1_id == 1 && $applnt_country_id == '162') || ( $compTypeSub1_id == 2 && $applnt_country_id != '162' )){
            //if($compTypeSub1_id != 1){
            if($compTypeSub1_id == 1 || $applnt_country_id == '162' || $applntOrg_country_id == '162'){
              // END หาคนที่สร้าง case เป็นนิติบุคคลหรือคนทั่วไป
              // 0=คนทั่วไป,1=ตัวแทนบริษัท
              if($applnt_type == 1){
                $cpr_address = $request_post['applntOrg_address'];
                
                $cpr_numbertrade = $applntOrg_trade_number;
                $cpr_companyname = $applntOrg_name;
                $cpr_type_import_export = $applntOrg_import_export;

                $cpr_branch = $applntOrg_branch;
                $cpr_telephone = $applntOrg_tel;
                $cpr_web = $applntOrg_web;
                $cpr_zipcode = $request_post['applntOrg_zipcode'];
                $Country_id = $applntOrg_country_id;

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
                
                // echo "ตัวแทนบริษัท";
                if($resultCorporateCheck->num_rows == 0){
                   ////// insert //////
                   $resultInsertCorlv1 = $this->insertCorporate($Valuecpr_section,$cpr_type,$cpr_comp_type,
                   $cpr_numbertrade,$cpr_companyname,$cpr_type_import_export,
                   $cpr_branch,$cpr_telephone,$cpr_web,
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
                  $cpr_web,$cpr_email,$cpr_address,
                  $prov_id,$cpr_zipcode,$cpr_department,
                  $cpr_contactfname,$cpr_contactlname,$Country_id,
                  $cpr_contact_person,$cpr_import,$cpr_update_datetime,$cpr_updateBy_id,$cpr_status,$resultcpr_id);

                }

              }else if($applnt_type == 0){
                // echo "คนทั่วไป";

                $applnt_career = $request_post['applnt_career'];
                $applnt_mobile = $request_post['applnt_mobile'];

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
                   $applnt_ident,$applnt_firstname,$applnt_lastname, $applnt_import_export, $applnt_career, $applnt_tel,$applnt_mobile,
                   $applnt_email,$applnt_address,$applnt_prov_id,$applnt_zipcode,$applnt_country_id,$case_createBy_id);

                }else{
                   /////// UPDATE ///////
                  $resultCorporateCheck = $resultCorporateCheck->fetch_assoc();
                  $resultcpr_id = $resultCorporateCheck['ct_id'];

                  $sql = "UPDATE `Contact_thai` SET
                  ct_section='$Valuecpr_section',
                  ct_type='$cpr_type',
                  ct_comp_type='$cpr_comp_type',
                  ct_card='$applnt_ident',
                  ct_firstname='$applnt_firstname',
                  ct_lastname='$applnt_lastname',
                  ct_business_type='$applnt_import_export',
                  ct_career='$applnt_career',
                  ct_homephone='$applnt_tel',
                  ct_cellphone='$applnt_mobile',
                  ct_email='$applnt_email',
                  ct_address='$applnt_address',
                  prov_id='$applnt_prov_id',
                  ct_postcode='$applnt_zipcode',
                  Country_id='$applnt_country_id',
                  ct_update_datetime=NOW(),
                  ct_updateBy_id='$case_createBy_id'
                  WHERE ct_id= '$resultcpr_id'";
                  $stmt = $this->conn->prepare($sql);
                  $stmt->execute();
                }
              }
            } else {
              $cpr_type = '2';
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
                 $cpr_branch,$cpr_telephone,$cpr_web,$cpr_email,$cpr_address,$value_prov_id,
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
                $cpr_web,$cpr_email,$cpr_address,$value_prov_id,$cpr_zipcode,$cpr_department,
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
            $Ccpr_web = $complnt_web;///*
            $Ccpr_email = $complnt_contact_email;
            $Ccpr_address = $complnt_contact_address;
            $Cprov_id = $complnt_prov_id;

            $Ccpr_zipcode = $complnt_zipcode;
            $Ccpr_department = "1";///*
            $Ccpr_contactfname = '';
            $Ccpr_contactlname = "";///*
            $CCountry_id = $complnt_country_id;///*
            $Ccpr_contact_person = $complnt_contact_name;
            $Ccpr_import = 0;
            $Ccpr_create_datetime = date("Y-m-d H:i:s");
            $Ccpr_createBy_id = $case_createBy_id;
            $Ccpr_update_datetime = date("Y-m-d H:i:s");
            $Ccpr_updateBy_id = $case_createBy_id;
            $Ccpr_status = "0";

            if($compTypeSub1_id == 1 || $complnt_country_id != '162'){
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
               $Ccpr_branch,$Ccpr_telephone,$Ccpr_web,
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
              $Ccpr_web,$Ccpr_email,$Ccpr_address,
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
    public function createComplaintField($key, $value, $caseid, $formSetId_P) {
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

    $stmt = $this->conn->prepare("SELECT * from `Case` a left JOIN `Incorrect_Type` b
           on a.incType_id=b.incType_id WHERE a.case_id = '$case_id'
           AND a.case_createBy_id = '$user_id'  ");

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $res = $result->fetch_assoc();
        $datespilt2 = explode (" ", $res["case_create_datetime"]);
        // if($res["case_status"] == "1"){
        //   $status = 1;$percen = 25;
        // }else if($res["case_status"] == "2"){
        //   $status = 2;$percen = 50;
        // }else if($res["case_status"] == "3"){
        //   $status = 4;$percen = 100;
        // }else{
        //   $status = 0;$percen = 0;
        // }

        if($res["case_status"] == "1" || $res["case_status"] == "2"){
          $res_status = $this->checkPercen($res["case_id"]);
          if($res_status == '1'){
            $status = 2;$percen = 25; $process = 1;
          }else if($res_status == '2'){
            $status = 2;$percen = 50; $process = 2;
          }else{
            $status = 2;$percen = 75; $process = 3;
          }
        }else if($res["case_status"] == "3"){
          $status = 3;$percen = 100; $process = 4;
        }else{
          $status = 1;$percen = 0; $process = 0;
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
          "comp_status" => $status,
          "comp_process" => $process,
          "comp_percen" => $percen,
          "compType_id" => $res["compType_id"],
          "incType_name" => $res["incType_name"],

        );
        $output[]=$response;
      foreach ($output as $key => $product) {
        $stmt = $this->conn->prepare("SELECT * from Field_Values a LEFT JOIN Field_Set b ON a.fieldset_id = b.fieldset_id LEFT JOIN Form_Set c ON b.frmset_id = c.frmset_id WHERE case_id = '$case_id' ");
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
              "fieldset_description" => $res2['fieldset_description']
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
          }else if($res2['fieldset_name'] == 'applntOrg_import_export' || $res2['fieldset_name'] == 'complnt_import_export'){
            if($res2['fieldset_value'] == 0) {
              $fieldValue = 'อื่นๆ';
            } else if($res2['fieldset_value'] == 1) {
              $fieldValue = 'นำเข้า';
            } else if($res2['fieldset_value'] == 2) {
              $fieldValue = 'ส่งออก';
            }

          }else if($res2['fieldset_name'] == 'caseDtl_complnt_need') {
            $fieldValue = strip_tags($res2['fieldset_value']);
          }else if($res2['fieldset_name'] == 'caseDtl_derivation') {
            $fieldValue = strip_tags($res2['fieldset_value']);
          }else{
            $fieldValue = $res2['fieldset_value'];
          }
          $response = array(
            "fieldset_id" => $res2['fieldset_id'],
            "fieldset_name" => $res2['fieldset_name'],
            "fieldset_value" => $fieldValue,
            "fieldset_description" => $res2['fieldset_description']
          );

          // $frmset_id[1][$res2['frmset_id']] = $output3;

          // $frmset_id1[] = $frmset_id[1][$res2['frmset_id']];
          $frmset_name = '';
          if($res2['frmset_type'] == 1) {
            $frmset_name = 'ผู้ร้องเรียน';
            $response1 = array(
              "fieldset_id" => $res2['fieldset_id'],
              "fieldset_name" => $res2['fieldset_name'],
              "fieldset_value" => $fieldValue,
              "fieldset_description" => $res2['fieldset_description']
            );
            $output1[]=$response1;
            $output[$key]['comp_chos'][$frmset_name] = $output1 ;

          } else if($res2['frmset_type'] == 2) {  
            $frmset_name = 'ผู้ถูกร้องเรียน';
            $response2 = array(
              "fieldset_id" => $res2['fieldset_id'],
              "fieldset_name" => $res2['fieldset_name'],
              "fieldset_value" => $fieldValue,
              "fieldset_description" => $res2['fieldset_description']
            );
            $output2[]=$response2;
            $output[$key]['comp_chos'][$frmset_name] = $output2 ;
          } else if($res2['frmset_type'] == 3) {  
            $frmset_name = 'รายละเอียดเรื่องร้องเรียน';
            $response3 = array(
              "fieldset_id" => $res2['fieldset_id'],
              "fieldset_name" => $res2['fieldset_name'],
              "fieldset_value" => $fieldValue,
              "fieldset_description" => $res2['fieldset_description']
            );
            $output3[]=$response3;
            $output[$key]['comp_chos'][$frmset_name] = $output3 ;
          }


        }
        $output3 = array();

        $stmt = $this->conn->prepare("SELECT * from Case_Attachfile WHERE case_id = '$case_id' ");
        $stmt->execute();
        $result3 = $stmt->get_result();
        if ($result3->num_rows > 0) {
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
        }else{
          $response = array(
            "caseAttach_id" => '-',
            "caseAttach_file_path" => '-',
            "caseAttach_title" => '-',
            "caseAttach_file_name" => '-'
          );
          $output4[] = $response;
          $output[$key]['comp_attach'] = $output4;
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


/*** แสดง complaint id ที่เลือก , complaint ของผู้ใช้เท่านั้น ***/
public function getComplaintByCaseId($user_id, $case_id, $type) {

if($type != 0 && $type != 1) {
  return NULL;
  exit();
}

$where_user = '';
if($type == 0) {
  $where_user = "AND a.case_createBy_id = '$user_id'";
}

$stmt = $this->conn->prepare("SELECT * from `Case` a left JOIN `Incorrect_Type` b
       on a.incType_id=b.incType_id WHERE a.case_id = '$case_id' AND compType_id != 0
       $where_user");

$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $res = $result->fetch_assoc();
    $datespilt2 = explode (" ", $res["case_create_datetime"]);

    if($type == 0) {
      if($res["case_status"] == "1" || $res["case_status"] == "2"){
        $res_status = $this->checkPercen($res["case_id"]);
        if($res_status == '1'){
          $status = 2;$percen = 25; $process = 1;
        }else if($res_status == '2'){
          $status = 2;$percen = 50; $process = 2;
        }else{
          $status = 2;$percen = 75; $process = 3;
        }
      }else if($res["case_status"] == "3"){
        $status = 3;$percen = 100; $process = 4;
      }else{
        $status = 1;$percen = 0; $process = 0;
      }
    } else if($type == 1) {
      if($res["case_status"] == "1"){
        $status = 1;$percen = 0;$process = 1;
      }else if($res["case_status"] == "2"){
          $status = 2;$percen = 50;$process = 2;
      }else if($res["case_status"] == "3"){
          $status = 3;$percen = 100;$process = 4;
      }else{
          $status = 0;$percen = 0;$process = 0;
      }
    }

    $response = array(
      "comp_id" => $res['case_id'],
      "comp_date" => $datespilt2[0],
      "comp_time" => $datespilt2[1],
      "comp_caseId" => $res["case_id"],
      "comp_resultProcess" => $res["case_close_resultProcess"],
      "comp_status" => $status,
      "comp_process" => $process,
      "comp_percen" => $percen,
      "compType_id" => $res["compType_id"],
      "incType_name" => $res["incType_name"],

    );
    $output[]=$response;
  foreach ($output as $key => $product) {
    $stmt = $this->conn->prepare("SELECT * from Field_Values a LEFT JOIN Field_Set b ON a.fieldset_id = b.fieldset_id LEFT JOIN Form_Set c ON b.frmset_id = c.frmset_id WHERE case_id = '$case_id' ");
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
      }else if($res2['fieldset_name'] == 'applntOrg_import_export' || $res2['fieldset_name'] == 'complnt_import_export'){
        if($res2['fieldset_value'] == 0) {
          $fieldValue = 'อื่นๆ';
        } else if($res2['fieldset_value'] == 1) {
          $fieldValue = 'นำเข้า';
        } else if($res2['fieldset_value'] == 2) {
          $fieldValue = 'ส่งออก';
        }

      }else if($res2['fieldset_name'] == 'caseDtl_complnt_need') {
        $fieldValue = strip_tags($res2['fieldset_value']);
      }else if($res2['fieldset_name'] == 'caseDtl_derivation') {
        $fieldValue = strip_tags($res2['fieldset_value']);
      }else{
        $fieldValue = $res2['fieldset_value'];
      }
      $response = array(
        "fieldset_id" => $res2['fieldset_id'],
        "fieldset_name" => $res2['fieldset_name'],
        "fieldset_value" => $fieldValue,
        "fieldset_description" => $res2['fieldset_description']
      );

      // $frmset_id[1][$res2['frmset_id']] = $output3;

      // $frmset_id1[] = $frmset_id[1][$res2['frmset_id']];
      $frmset_name = '';
      if($res2['frmset_type'] == 1) {
        $frmset_name = 'ผู้ร้องเรียน';
        $response1 = array(
          "fieldset_id" => $res2['fieldset_id'],
          "fieldset_name" => $res2['fieldset_name'],
          "fieldset_value" => $fieldValue,
          "fieldset_description" => $res2['fieldset_description']
        );
        $output1[]=$response1;
        $output[$key]['comp_chos'][$frmset_name] = $output1 ;

      } else if($res2['frmset_type'] == 2) {  
        $frmset_name = 'ผู้ถูกร้องเรียน';
        $response2 = array(
          "fieldset_id" => $res2['fieldset_id'],
          "fieldset_name" => $res2['fieldset_name'],
          "fieldset_value" => $fieldValue,
          "fieldset_description" => $res2['fieldset_description']
        );
        $output2[]=$response2;
        $output[$key]['comp_chos'][$frmset_name] = $output2 ;
      } else if($res2['frmset_type'] == 3) {  
        $frmset_name = 'รายละเอียดเรื่องร้องเรียน';
        $response3 = array(
          "fieldset_id" => $res2['fieldset_id'],
          "fieldset_name" => $res2['fieldset_name'],
          "fieldset_value" => $fieldValue,
          "fieldset_description" => $res2['fieldset_description']
        );
        $output3[]=$response3;
        $output[$key]['comp_chos'][$frmset_name] = $output3 ;
      }


    }
    $output3 = array();

    $stmt = $this->conn->prepare("SELECT * from Case_Attachfile WHERE case_id = '$case_id' ");
    $stmt->execute();
    $result3 = $stmt->get_result();
    if ($result3->num_rows > 0) {
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
    }else{
      $response = array(
        "caseAttach_id" => '-',
        "caseAttach_file_path" => '-',
        "caseAttach_title" => '-',
        "caseAttach_file_name" => '-'
      );
      $output4[] = $response;
      $output[$key]['comp_attach'] = $output4;
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
    public function getAllUserComplaint($user_id) {

      // $filtersql = $this->func->filter_sql($filter);
      // $limitsql  = $this->func->limit_sql($limit,$offset);
      // $sortsql   = $this->func->sort_sql($sort);

      $stmt = $this->conn->prepare("SELECT a.case_id, a.case_status , a.case_create_datetime,a.caseDtl_title FROM `Case` a WHERE  a.case_createBy_id = '$user_id' ORDER BY a.case_id DESC");

      $stmt->execute();
      $result = $stmt->get_result();
      // array_push($result,$sql);
      // $response = array();
      if($result->num_rows > 0){
        while ($res = $result->fetch_assoc()) {
          // if($res["case_status"] == "1"){
          //   $status = 1;$percen = 25;
          // }else if($res["case_status"] == "2"){
          //   $status = 2;$percen = 50;
          // }else if($res["case_status"] == "3"){
          //   $status = 4;$percen = 100;
          // }else{
          //   $status = 0;$percen = 0;
          // }

          $stmt1 = $this->conn->prepare("SELECT isStaff, case_createBy_staff_id FROM `Case` WHERE  case_id = $res[case_id]");
          $stmt1->execute();
          $result1 = $stmt1->get_result();
          $staff_email = '';
          $isStaff = 0;
          if($result1->num_rows > 0) {
            $res1 = $result1->fetch_assoc();
            // print_r($res1);
            $isStaff = $res1['isStaff'];
            $staff_email = $res1['case_createBy_staff_id'];
          }

          if($res["case_status"] == "1"){
              $status = 2;$percen = 25;
          }else if($res["case_status"] == "2"){
              $res_status = $this->checkPercen($res["case_id"]);
              if($res_status == '1'){
              $status = 2;$percen = 25;
              }else if($res_status == '3'){
              $status = 2;$percen = 75;
              }else{
              $status = 2;$percen = 50;
              }
          }else if($res["case_status"] == "3"){
              $status = 3;$percen = 100;
          }else{
              $status = 1;$percen = 0;
          }
          // $tmp = array();
          $datespilt = explode (" ", $res["case_create_datetime"]);
          // $datespilt = split(" ", $res["case_receivedoc_real_datetime"]);
          $response = array(
            "comp_id" => $res['case_id']
            ,"comp_name" => $res['caseDtl_title']
            ,"comp_date" => $datespilt[0]
            ,"comp_time" => $datespilt[1]
            ,"comp_status" => $status
            // ,"comp_process" => $status
            ,"comp_percen" => $percen
            ,"isStaff" => $isStaff
            ,"staff_email" => $staff_email
          );

          $output[]=$response;
        }
         $stmt->close();
         return $output;
       }else{
         $stmt->close();
         return NULL;
       }
    }

    /*** แสดง  complaint ทั้งหมด ของ staff ***/
    public function getAllComplaintForStaff($request_post) {

      $type = $request_post['type'];

      $where_email = '';
      if($type == 2) {
        $staff_email = $request_post['staff_email'];
        $email_str = '';
        foreach($staff_email as $i => $item){
          if($i != 0){
            $email_str .= ",";
          }
          $email_str .= "'".$item."'";
        }

        $where_email = '';
        if($email_str != ''){
          $where_email = " AND isStaff = 1 AND a.case_createBy_staff_id IN (".$email_str.") ";
        }
      } else if($type != 1 && $type != 2) {
        return NULL;
      }

      // print_r($where_email);

      $stmt = $this->conn->prepare("SELECT a.case_id, a.case_status , a.case_create_datetime,a.caseDtl_title FROM `Case` a WHERE 1 AND compType_id != 0 $where_email ORDER BY a.case_id DESC");

      $stmt->execute();
      $result = $stmt->get_result();
      // array_push($result,$sql);
      // $response = array();
      if($result->num_rows > 0){
        while ($res = $result->fetch_assoc()) {
          // if($res["case_status"] == "1"){
          //   $status = 1;$percen = 25;
          // }else if($res["case_status"] == "2"){
          //   $status = 2;$percen = 50;
          // }else if($res["case_status"] == "3"){
          //   $status = 4;$percen = 100;
          // }else{
          //   $status = 0;$percen = 0;
          // }

          $stmt1 = $this->conn->prepare("SELECT isStaff, case_createBy_staff_id FROM `Case` WHERE  case_id = $res[case_id]");
          $stmt1->execute();
          $result1 = $stmt1->get_result();
          $staff_email = '';
          $isStaff = 0;
          if($result1->num_rows > 0) {
            $res1 = $result1->fetch_assoc();
            // print_r($res1);
            $isStaff = $res1['isStaff'];
            $staff_email = $res1['case_createBy_staff_id'];
          }

          if($res["case_status"] == "1"){
              $status = 1;$percen = 0;
          }else if($res["case_status"] == "2"){
              $status = 2;$percen = 50;
          }else if($res["case_status"] == "3"){
              $status = 3;$percen = 100;
          }else{
              $status = 0;$percen = 0;
          }
          // $tmp = array();
          $datespilt = explode (" ", $res["case_create_datetime"]);
          // $datespilt = split(" ", $res["case_receivedoc_real_datetime"]);
          $response = array(
            "comp_id" => $res['case_id']
            ,"comp_name" => $res['caseDtl_title']
            ,"comp_date" => $datespilt[0]
            ,"comp_time" => $datespilt[1]
            ,"comp_status" => $status
            // ,"comp_process" => $status
            ,"comp_percen" => $percen
            ,"isStaff" => $isStaff
            ,"staff_email" => $staff_email
          );

          $output[]=$response;
        }
        $stmt->close();
        return $output;
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

     /*** memberDetail ***/
     public function getMemberDetail($user_id) {
      $stmt = $this->conn->prepare("SELECT 
                                      m.member_fname,
                                      m.member_lname,
                                      m.member_cid,
                                      m.member_occupation,
                                      m.member_position,
                                      m.member_address,
                                      m.prov_id,
                                      m.member_postcode,
                                      m.country_id,
                                      m.member_phone,
                                      m.member_sex,
                                      m.member_type,
                                      m.member_email,
                                      m.member_cellphone,
                                      m.member_business,
                                      m.tel_code,
                                      m.tel_country_code,
                                      mc.member_comp_name,
                                      mc.member_comp_branch,
                                      mc.member_comp_taxid,
                                      mc.member_comp_address,
                                      mc.prov_id AS member_comp_prov_id,
                                      mc.member_comp_postcode,
                                      mc.country_id AS member_comp_country_id,
                                      mc.member_comp_phone,
                                      mc.member_comp_fax,
                                      mc.member_comp_type
                                    FROM Member AS m
                                    LEFT JOIN Member_comp AS mc ON m.member_id = mc.member_id 
                                    WHERE m.member_id = '" .$user_id. "'");
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
          while($res = $result->fetch_assoc())
  				{
            $response = array(
  						"member_fname" => $res['member_fname']
              ,"member_lname" => $res['member_lname']
              ,"member_cid"=>$res['member_cid']
              ,"member_occupation"=>$res['member_occupation']
              ,"member_position"=>$res['member_position']
              ,"member_address"=>$res['member_address']
              ,"prov_id"=>$res['prov_id']
              ,"member_postcode"=>$res['member_postcode']
              ,"country_id"=>$res['country_id']
              ,"member_phone"=>$res['member_phone']
              ,"member_sex"=>$res['member_sex']
              ,"member_type"=>$res['member_type']
              ,"member_email"=>$res['member_email']
              ,"member_cellphone"=>$res['member_cellphone']
              ,"member_business"=>$res['member_business']
              ,"tel_code"=>$res['tel_code']
              ,"tel_country_code"=>$res['tel_country_code']
              ,"member_comp_name"=>$res['member_comp_name']
              ,"member_comp_branch"=>$res['member_comp_branch']
              ,"member_comp_taxid"=>$res['member_comp_taxid']
              ,"member_comp_address"=>$res['member_comp_address']
              ,"member_comp_prov_id"=>$res['member_comp_prov_id']
              ,"member_comp_postcode"=>$res['member_comp_postcode']
              ,"member_comp_country_id"=>$res['member_comp_country_id']
              ,"member_comp_phone"=>$res['member_comp_phone']
              ,"member_comp_fax"=>$res['member_comp_fax']
              ,"member_comp_type"=>$res['member_comp_type']
  					);
  					$output[]=$response;
  				}
          $stmt->close();
          return $output;
        }else{
          $stmt->close();
          return NULL;
        }
    }


    /*** แสดง badge ทั้งหมด , badge ของผู้ใช้เท่านั้น ***/
    public function getAllBadge($user_id) {
        $num = Null;
      // $stmt = $this->conn->prepare("SELECT noti_id FROM `Case` a INNER JOIN Log_Notification b ON a.case_id = b.case_id WHERE case_createBy_id = '$user_id' AND caseCh_id = '1' AND noti_status = '0' AND noti_read = '0' ");
        $stmt = $this->conn->prepare("SELECT case_id FROM `Message_Noti_App` where msgNotiApp_noti_status = '0' and msgNoti_status='0' and member_id='$user_id' ");
        $stmt->execute();
        $result = $stmt->get_result();
        $num = intval($result->num_rows);

        $stmt1 = $this->conn->prepare("SELECT * FROM `Message_Box` a left join Message_Box_Log b on a. msgBox_id = b.msgBox_id
                                      where b.recipient_id = ".$user_id." and b.msgBox_noti_status=0 GROUP by case_id");
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $num =$num+ intval($result1->num_rows);



      //  if($num> 0){
      //    $stmt->close();
      //    return $num;
      //  }else{
      //    $stmt->close();
      //    return NULL;
      //  }
        return $num;
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

        $sql_box = "SELECT c.msgBox_id,c.msgBox_message,c.msgBox_datetime,c.sender_type,c.msgBox_message_en,case_id,msgBox_read_status,
        (SELECT b.msgBox_read_status FROM `Message_Box` a INNER JOIN Message_Box_Log b on a.msgBox_id = b.msgBox_id
        where   b.msgBox_id = c.msgBox_id  LIMIT 1) as readmsg
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
                  -- em.emp_firstname,
                  -- em.emp_lastname,
                  -- em.emp_img_path,
                  mb.msgBox_message,
                  mb.msgBox_id,
                  mb.sender_type,
                  mb.sender_id,
                  -- m.member_fname,
                  -- m.member_lname,
                  -- m.member_img,
                  -- m.member_type,
                  mb.msgBoxRef_id,
                  mb.msgBox_datetime
                  -- mc.member_comp_id,
                  -- mc.member_comp_img,
                  -- mc.member_comp_name
                  FROM `Case` AS c
                  LEFT JOIN `Message_Box` AS mb ON c.case_id = mb.case_id
                  -- LEFT JOIN `Employee` AS em ON mb.sender_id = em.emp_id
                  -- LEFT JOIN `Member` AS m ON mb.sender_id = m.member_id
                  -- LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id
                  WHERE mb.msgBox_id = '".$id."' OR mb.msgBoxRef_id = '".$id."' ";

                  $stmt = $this->conn->prepare($sql_bm);
                  $stmt->execute();
                  $datadatail = array();
                  $dataAttachfile = array();

                  $result = $stmt->get_result();
                  // $test = $result->fetch_assoc();

                  if($result->num_rows > 0){
                    while($res = $result->fetch_assoc()){
                      $datespilt = explode (" ", $res["msgBox_datetime"]);
                      $message_to="";

                      if ($res["sender_type"]==1) {
                          $sqlsendfrom = "SELECT * FROM Member a left join Member_comp b on a.member_id= b.member_id where a.member_id= ".$res["sender_id"];
                      }else{
                          $sqlsendfrom = "SELECT * FROM `Employee` where emp_id = ".$res["sender_id"];
                      }
                      $stmt4 = $this->conn->prepare($sqlsendfrom);
                      $stmt4->execute();
                      $result4= $stmt4->get_result();
                      $row= $result4->num_rows ;
                      if($row > 0){
                          while($datesend= $result4->fetch_assoc()){
                            if ($res["sender_type"]==1) {
                                  $message_to = $datesend['member_comp_name'];
                                if ($datesend['member_comp_name']==Null) {
                                  $message_to = $datesend['member_fname']." ".$datesend['member_lname'];
                                 }
                            }else{
                                $message_to=$datesend['emp_firstname']." ".$datesend['emp_lastname'];
                            }
                          }
                      }


                      //
                      // if ($res['member_comp_name']==Null) {
                      //   $message_to = $res['emp_firstname']." ".$res['emp_lastname'];
                      // }


                          //// Attachfile////
                          $dataAttachfile = array();
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
                          //////////////////////

                        array_push($datadatail,array(
                                  'msgBox_message'=>$res['msgBox_message'],
                                  'message_date' => $datespilt[0],
                                  'message_time' =>$datespilt[1],
                                  'case_create_datetime'=>$res['case_create_datetime'],
                                  'message_from' => "ผู้ส่ง",
                                  'message_fulltime' => $res["msgBox_datetime"],
                                  'message_to'=>$message_to,
                                  'Attachfile'=>$dataAttachfile,
                                  'sql'=>$sqlsendfrom,
                                  'num'=>$res["sender_id"]
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
      // $stmt = $this->conn->prepare("SELECT * From  Member WHERE member_id = ?");
      // $stmt->bind_param("s",$member_id);
      // $stmt->execute();
      // $result2 = $stmt->get_result();
      // $res2 = $result2->fetch_assoc();
      // return $res2;
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
        $stmt->execute();
        $stmt1 = $this->conn->prepare("UPDATE Message_Box_Log set
            msgBox_noti_status = '1',msgBox_noti_datetime = now()
            WHERE recipient_id = '$memid' and msgBox_noti_status = '0' ");
        $stmt1->execute();
        // $txt[] = "UPDATE Message_Noti_App set
        //     msgNotiApp_noti_status = '1',msgNotiApp_noti_datetime = now()
        //     WHERE member_id = '$memid' ";
        $stmt->close();
        return $result;
    }

    // /*** update OpenMessage all ***/
    // public function updateOpenMessage($memid) {
    //     $stmt = $this->conn->prepare("UPDATE Message_Box_Log set
    //         msgBox_noti_status = '1',msgBox_noti_datetime = now()
    //         WHERE recipient_id = '$memid' and msgBox_noti_status = '0' ");
    //     $result = $stmt->execute();
    //     $stmt->close();
    //     return $result;
    // }


    /*** update Read **/
    public function updateReadMessage($userid,$memid) {
      $sql = "SELECT a.msgBox_id FROM `Message_Box` a INNER JOIN Message_Box_Log b on a.msgBox_id = b.msgBox_id
      where  a.msgBoxRef_id = '".$memid."' and b.msgBox_read_status = 0 or a.msgBox_id = '".$memid."' and b.msgBox_read_status = 0";
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
    $cpr_branch,$cpr_telephone,$cpr_web,
    $cpr_email,$cpr_address,$prov_id,
    $cpr_zipcode,$cpr_department,$cpr_contactfname,
    $cpr_contactlname,$Country_id,$cpr_contact_person,
    $cpr_import,$cpr_create_datetime,$cpr_createBy_id,$cpr_status){

      $stmt = $this->conn->prepare("INSERT INTO Corporate (cpr_section,cpr_type,cpr_comp_type,
      cpr_numbertrade,cpr_companyname,cpr_type_import_export,
      cpr_branch,cpr_telephone,cpr_web,
      cpr_email,cpr_address,prov_id,
      cpr_zipcode,cpr_department,cpr_contactfname,
      cpr_contactlname,Country_id,cpr_contact_person,
      cpr_import,cpr_create_datetime,cpr_createBy_id,cpr_status) values(
        '$cpr_section','$cpr_type','$cpr_comp_type',
        '$cpr_numbertrade','$cpr_companyname','$cpr_type_import_export',
        '$cpr_branch','$cpr_telephone','$cpr_web',
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
    $cpr_web,$cpr_email,$cpr_address,
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
      cpr_web='$cpr_web',
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
    $ct_card,$ct_firstname,$ct_lastname,$ct_business_type,$ct_career, $ct_homephone,$ct_cellphone,$ct_email,$ct_address,
    $prov_id,$ct_postcode,$Country_id,$case_createBy_id){

      $stmt = $this->conn->prepare("INSERT INTO Contact_thai (ct_section,ct_type,ct_department,
      ct_comp_type,ct_card,ct_firstname,ct_lastname,ct_business_type,ct_career,ct_homephone,ct_cellphone,ct_email,ct_address,prov_id,
      ct_postcode,Country_id,ct_import,ct_create_datetime,ct_createBy_id,ct_status) values(
        '$ct_section', '$ct_type', '$ct_department', '$ct_comp_type', '$ct_card', '$ct_firstname', '$ct_lastname',
        '$ct_business_type', '$ct_career', '$ct_homephone', '$ct_cellphone', '$ct_email', '$ct_address', '$prov_id', '$ct_postcode',
        '$Country_id', '0', NOW(), '$case_createBy_id', '0')");
      $result = $stmt->execute();
      if (false === $result) {
          die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $stmt->close();
      return $result;

    }



  public function conf_reg($mail){
        $sql = "SELECT m.member_fname,m.member_lname,mc.member_comp_name,m.member_type
        FROM `Member` AS m LEFT JOIN `Member_comp` AS mc ON m.member_id = mc.member_id WHERE m.member_email = '".$mail."'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $re = $result->fetch_assoc();
        $output= "" ;
        //

        if($result->num_rows > 0){
          if($re['member_type'] == "0"){
            $namesent = "เรียน คุณ ".$re['member_fname']."  ".$re['member_lname'];
          }else {
            $namesent = "เรียน บริษัท ".$re['member_comp_name'];
          }
          $to_email = $mail;
          $passwors = $this->random_password();
          $to_name = "เจ้าหน้าที่ของ DITP Care";
          $from_email = "noreply.ditp@gmail.com";
          $from_name = "Noreply DITP";
          $subject = "กรุณายืนยันการสมัครสมาชิก DITP Care";
          $password_hash = PassHash::hash($passwors);
          $url = BASE_URL."frontend/conf_reg.php?conf=$password_hash";
          $message = " <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                        <div class=\"header\" style=\"width:auto\">
                        <img src=\"".BASE_URL."img/header_email_2.png\" style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                        <div>
                        <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                        <div style=\"padding: 20px;color:#000;\">
                        ".$namesent."
                        <br>
                        <br>
                        ".BASE_URL." ได้รับคำขอร้องจากเว็บไซต์ หากคุณต้องการยืนยันการสมัครสมาชิก
                        <br>
                        คลิกที่ลิงค์ด้านล่างนี้ เพื่อยืนยันการสมัครสมาชิกของคุณ :
                        <br>
                        <br>
                        <br>
                        <br>
                        <div style=\"text-align:center;color:#000;\">
                        <a href=\"".$url."\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ยืนยันสมัครสมาชิก</a>
                        </div>
                        <br>
                        <br>
                        <br>
                        หากคุณไม่ได้ดำเนินการร้องขอนี้ โปรดอย่าสนใจอีเมลฉบับนี้ มั่นใจได้ว่าบัญชีสมาชิกของคุณจะปลอดภัยได้กับเรา
                        <br>
                        </div>
                        <hr style=\"border-color:#fefefe; margin:0px;\" />
                           <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                             ขอบคุณ.<br />
                             ทีมงาน <a href=\"".BASE_URL."\" target=\"blank\">".BASE_URL."</a>
                           </div>
                         </div>";
              $mail1 =   $this->func->sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message,"","","1");
              $upd = "UPDATE Member SET member_token_confirm = '".$password_hash."' ,member_status_confirm = '0' WHERE member_email = '".$mail."' ";
              $stmt = $this->conn->prepare($upd);
              $stmt->execute();
              $output = $mail1;
        }else {
              $output = null ;
        }
          // header("content-type:application/json;charset=utf-8");
          return $output;
              // echo json_encode( $output );
        }

        function random_password( $length = 8 ) {
          $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
          $password = substr( str_shuffle( $chars ), 0, $length );
          return $password;
        }


        public function logRequest($requestData = '') {
          try {
              $stmt = $this->conn->prepare("
                  INSERT INTO log_api (
                      ip_address,
                      method,
                      url,
                      referer,
                      user_agent,
                      host,
                      request_data
                  ) VALUES (
                      ?, ?, ?, ?, ?, ?, ?
                  )
              ");
              
               $ip = $this->getClientIP();
              $method = $_SERVER['REQUEST_METHOD'];
              $url = $_SERVER['REQUEST_URI'];
              $referer = json_encode($_SERVER); //isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
              $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
              $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
              /* $requestData = json_encode($this->getRequestData()); */
              $data_server = json_encode($requestData);

              $stmt->bind_param(
                  "sssssss",
                  $ip,
                  $method,
                  $url,
                  $referer,
                  $userAgent,
                  $host,
                  /* $requestData */
                  $data_server
              );
  
              $result = $stmt->execute();
              $stmt->close();
  
              return $result;
          } catch (Exception $e) {
              error_log("API Log Error: " . $e->getMessage());
              return false;
          }

      }


      function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
      }

      function getRequestData() {
          $method = $_SERVER['REQUEST_METHOD'];
          switch ($method) {
              case 'GET':
                  return $_GET;
              case 'POST':
                  return $_POST;
              default:
                  return json_decode(file_get_contents('php://input'), true) ? json_decode(file_get_contents('php://input'), true) : '';
          }
      }

      function testgetTypeComplaint( ) {
        $body = "";
        
        try {
          $mail = new PHPMailer(true);
          $mail->CharSet = "utf-8";
          $mail->IsSMTP();
          $mail->SMTPDebug = 2;
          $mail->SMTPAuth = true;
          //$mail->SMTPSecure = "ssl";	// sets the prefix to the servier
          $mail->Host = "smtp-relay.workd.go.th"; // SMTP server 203.150.62.22
          // $mail->Host = "outgoin.mail.go.th"; // SMTP server
    
          $mail->Port = 587; // พอร์ท
          $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
          $mail->Password = '7w4KHh-K(e*2~vRgQq(&&sh(WMzVT~B5BD3nRdPqT2m1s1#aT3geRq9jt6ugW(^8'; // รหัสผ่าน SMTP
    
          $mail->IsHTML(true);
          $mail->SetFrom('ditpcare@ditp.go.th', 'test');
          $mail->AddReplyTo('ditpcare@ditp.go.th', 'test');
          $mail->Subject = 'ทดสอบ';
          $body ='<div class="wrapper" style="width:860px; background: #f8f8f8;">

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
        <!-- ข้อความ -->
        สวัสดีค่ะ คุณ ทดสอบ ทดสอบ <br /> <br />
        &nbsp;&nbsp; ตามที่ท่านได้ยื่นเรื่องร้องเรียนในระบบบริการตรวจสอบคู่ค้าเบื้องต้น และ ให้คำปรึกษาด้านข้อพิพาททางการค้าระหว่างประเทศ (DITP CARE) หมายเลขเคส (2056) นั้น ทีม DITP Care ได้รับเรื่องของท่านเรียบร้อยแล้ว <br /> <br />
        ทั้งนี้ ท่านสามารถติดตามความคืบหน้าได้จากระบบ <a href="http://'.$_SERVER["HTTP_HOST"].'/frontend/index.php?page=appeal_detail&case_id=2056&user_id=44" target="blank"> DITP Care</a>   หรือ ติดต่อหมายเลข 02-507-8247 ตามวันและเวลาราชการ <br /> <br />
        
        อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติ กรุณาอย่าตอบกลับ หากท่านมีข้อสงสัยหรือต้องการสอบถามรายละเอียดเพิ่มเติม กรุณาติดต่อตามเบอร์โทรศัพท์ที่ได้ให้ไว้ด้านล่าง  <br /> <br />
      </div>

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; color: #999999">
        <!-- ข้อความ -->
        DITP Service Center 1169 & DITP Care Team <br />
        สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ <br />
        กรมส่งเสริมการค้าระหว่างประเทศ (DITP) <br />
        Tel. (+66) 2507 - 8247 / 8257 <br />
        <a href="https://bit.ly/3kiXy7K" target="blank">Facebook</a> | <a href="https://line.me/ti/p/@fom5198h" target="blank">LINE</a> | <a href="https://ditp.go.th/" target="blank">Website</a>  <br />
      </div>


      <hr style="border-color:#fefefe; margin:0px;" />

      <div class="footer" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; text-align: center;">
        <img src="http://care.ditp.go.th/img/footer_email.png" srtlw="width:100%; height:auto;" />
      </div>
    </div>';
          $mail->MsgHTML($body);
          $mail->AddAddress('guloveguteam@gmail.com', 'Recipient Name');
          $mail->AddAddress('ditpservicenter@gmail.com', 'ditpservicenter');
          if(!$mail->Send()) {
            $dh = 2;
            $status_response = "02";
            $status_response_text = "Mailer Error!: " . $mail->ErrorInfo;
            print_r($status_response_text );
          } else {
            $dh = 1;
            $status_response = "00";
            $status_response_text="Message sent ;)";
            //$status_response_text = $file_name[$i];
            print_r($status_response_text );
          }
        } catch (phpmailerException $e) {
          echo $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
          echo $e->getMessage(); //Boring error messages from anything else!
        }
       exit();
        return $password;
        $html_message = '<div class="wrapper" style="width:860px; background: #f8f8f8;">

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;">
        <!-- ข้อความ -->
        สวัสดีค่ะ คุณ '.$post["applnt_firstname"].' '.$post["applnt_lastname"].' <br /> <br />
        &nbsp;&nbsp; ตามที่ท่านได้ยื่นเรื่องร้องเรียนในระบบบริการตรวจสอบคู่ค้าเบื้องต้น และ ให้คำปรึกษาด้านข้อพิพาททางการค้าระหว่างประเทศ (DITP CARE) หมายเลขเคส ('.$case_id.') นั้น ทีม DITP Care ได้รับเรื่องของท่านเรียบร้อยแล้ว <br /> <br />
        ทั้งนี้ ท่านสามารถติดตามความคืบหน้าได้จากระบบ <a href="http://'.$_SERVER["HTTP_HOST"].'/frontend/index.php?page=appeal_detail&case_id='.$case_id.'&user_id='.$member_id.'" target="blank"> DITP Care</a>   หรือ ติดต่อหมายเลข 02-507-8247 ตามวันและเวลาราชการ <br /> <br />
        
        อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติ กรุณาอย่าตอบกลับ หากท่านมีข้อสงสัยหรือต้องการสอบถามรายละเอียดเพิ่มเติม กรุณาติดต่อตามเบอร์โทรศัพท์ที่ได้ให้ไว้ด้านล่าง  <br /> <br />
      </div>

      <div class="content" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; color: #999999">
        <!-- ข้อความ -->
        DITP Service Center 1169 & DITP Care Team <br />
        สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ <br />
        กรมส่งเสริมการค้าระหว่างประเทศ (DITP) <br />
        Tel. (+66) 2507 - 8247 / 8257 <br />
        <a href="https://bit.ly/3kiXy7K" target="blank">Facebook</a> | <a href="https://line.me/ti/p/@fom5198h" target="blank">LINE</a> | <a href="https://ditp.go.th/" target="blank">Website</a>  <br />
      </div>


      <hr style="border-color:#fefefe; margin:0px;" />

      <div class="footer" style="width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px; text-align: center;">
        <img src="http://care.ditp.go.th/img/footer_email.png" srtlw="width:100%; height:auto;" />
      </div>
    </div>';
      }

}

?>
