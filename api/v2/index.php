<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//exec("chmod -R 777 ../../data/MemberImage");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once '../include/DbHandler2.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

require_once ".././libs/PHPMailer-5.2.5/class.phpmailer.php";

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$user_id = NULL;

// $headers = apache_request_headers();
// $headers['Authorization'];
// exit();

/* ########################################################################### */
/* ########################### ฟังก์ชั่นที่ไม่มีการตรวจสอบ ########################### */
/* ########################################################################### */



/*** สมัครสมาชิก ***
 * url - /register
 * method - POST
 * params - name, email, password
 */

$app->post('/register', function() use ($app) {
            $arrayverify=array();
            array_push($arrayverify,'fname', 'lname', 'cid', 'address', 'country_id', 'postcode', 'phone', 'cellphone');
            if($app->request->post('country_id') == '162'){
              array_push($arrayverify,'prov_id');
            }
            if($app->request->post('type_member')){// 0 = คนธรรมดา , 1 = บริษัท
              array_push($arrayverify,'position', 'company_name', 'company_taxid' ,'member_business', 'company_address', 'company_country_id',
                                         'company_postcode', 'company_phone', 'company_type');
            }else{
              array_push($arrayverify,'occupation');
            }
            if($app->request->post('company_country_id') == '162'){
              array_push($arrayverify,'company_prov_id');
            }
            array_push($arrayverify,'email');
            if($app->request->post('facebook_type') == '0'){
              array_push($arrayverify,'password');
            }
            verifyRequiredParamsRegis($arrayverify);
            //htmlspecialchars(, ENT_QUOTES);
            $response = array();
            $type_member = htmlspecialchars($app->request->post('type_member'), ENT_QUOTES);
            $fname = htmlspecialchars($app->request->post('fname'), ENT_QUOTES);
            $lname = htmlspecialchars($app->request->post('lname'), ENT_QUOTES);
            $cid = htmlspecialchars($app->request->post('cid'), ENT_QUOTES);
            $occupation = htmlspecialchars($app->request->post('occupation'), ENT_QUOTES);
            $address = htmlspecialchars($app->request->post('address'), ENT_QUOTES);
            $prov_id = htmlspecialchars($app->request->post('prov_id'), ENT_QUOTES);
            $postcode = htmlspecialchars($app->request->post('postcode'), ENT_QUOTES);
            $country_id = htmlspecialchars($app->request->post('country_id'), ENT_QUOTES);
            $phone = htmlspecialchars($app->request->post('phone'), ENT_QUOTES);
            $fax = htmlspecialchars($app->request->post('cellphone'), ENT_QUOTES);
            $sex = htmlspecialchars($app->request->post('sex'), ENT_QUOTES);
            $position = htmlspecialchars($app->request->post('position'), ENT_QUOTES);
            $company_name = htmlspecialchars($app->request->post('company_name'), ENT_QUOTES);
            $company_branch = htmlspecialchars($app->request->post('company_branch'), ENT_QUOTES);
            $company_taxid = htmlspecialchars($app->request->post('company_taxid'), ENT_QUOTES);
            $company_address = htmlspecialchars($app->request->post('company_address'), ENT_QUOTES);
            $company_prov_id = htmlspecialchars($app->request->post('company_prov_id'), ENT_QUOTES);
            $company_postcode = htmlspecialchars($app->request->post('company_postcode'), ENT_QUOTES);
            $company_country_id = htmlspecialchars($app->request->post('company_country_id'), ENT_QUOTES);
            $company_phone = htmlspecialchars($app->request->post('company_phone'), ENT_QUOTES);
            $company_fax = htmlspecialchars($app->request->post('company_fax'), ENT_QUOTES);
            $company_type_member = htmlspecialchars($app->request->post('company_type'), ENT_QUOTES);
            $email = htmlspecialchars($app->request->post('email'), ENT_QUOTES);
            $password = htmlspecialchars($app->request->post('password'), ENT_QUOTES);
            $image = $app->request->post('image');
            $image_comp = $app->request->post('image_comp');
            $facebook_id = htmlspecialchars($app->request->post('facebook_id'), ENT_QUOTES);
            $facebook_type = htmlspecialchars($app->request->post('facebook_type'), ENT_QUOTES);
            $member_business = htmlspecialchars($app->request->post('member_business'), ENT_QUOTES);
            $member_lang = htmlspecialchars($app->request->post('member_lang'), ENT_QUOTES);
            validateEmail($email);
            $db = new DbHandler();
            $res = $db->createUser($type_member, $fname, $lname, $cid, $address, $prov_id
                                   ,$postcode, $country_id, $phone, $fax, $sex, $occupation, $position, $company_name, $company_branch
                                   ,$company_taxid, $company_address, $company_prov_id, $company_postcode
                                   ,$company_country_id, $company_phone, $company_fax, $company_type_member
                                   ,$email, $password, $image, $image_comp, $facebook_id, $facebook_type, $member_business,$member_lang);

            if ($res == USER_CREATED_SUCCESSFULLY) {

              if($facebook_type == '1'){
                $result = $db->getUserByEmail($email,'member_email');
                if ($result != NULL) {
                    $result['member_id'] = $result['member_id2'];
                    $result['member_img'] = BASE_URL.'data/img_member/'.$result['member_id'].'/'.$result['member_img'];
                    $result['member_comp_img'] = BASE_URL.'data/img_membercom/'.$result['member_comp_id'].'/'.$result['member_comp_img'];
                    $response["res_code"] = "00";
                    $response["res_text"] = "สมัครสมาชิกสำเร็จ";
                    $response["res_text_en"] = "Register successful";
                    $response["res_result"] = $result;
                }
              }else{
                $result2= $db->conf_reg($email);
                $response['res_code'] = "03";
                $response['res_text'] = "กรุณายืนยันการสมัครสมาชิกที่อีเมล";
                $response["Send_Email"] = $result2;
                $response["res_text_en"] = "Please confirm your email";
                $response["res_result"] = $email;
              }

            } else if ($res == USER_CREATE_FAILED) {
                $response["res_code"] = "01";
                $response["res_text"] = "สมัครสมาชิกไม่สำเร็จ";
                $response["res_text_en"] = "Register unsuccessful";
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["res_code"] = "02";
                $response["res_text"] = "อีเมลนี้มีอยู่ในระบบแล้ว";
                $response["res_text_en"] = "The email address you have entered is already registered.";
            }
            echoRespnse(200, $response);
        });


  $app->get('/confirmEmail2', function() use ($app) {
                    $email = $app->request->get('email');
                    $response = array();
                    $db = new DbHandler();
                    $result= $db->conf_reg($email);
                    if ($result != NULL) {
                        $response["res_code"] = "00";
                        $response['res_text'] = "ระบบได้ทำการส่งอีีเมลเพื่ือยืนยันการสมัครสมาชิก";
                        $response["res_text_en"] = "Sent e-mail to confirm register";
                        $response["res_result"] = $result;
                        echoRespnse(200, $response);
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "อีเมลไม่เคยลงทะเบียนในระบบ";
                        $response["res_text_en"] = "Not Found Email";
                        $response["res_result"] = $result;
                        echoRespnse(200, $response);
                    }
    });




/*** ล็อกอิน ***
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {

            verifyRequiredParamsRegis(array('email', 'password'));
            $email = htmlspecialchars($app->request->post('email'), ENT_QUOTES);
            $password = htmlspecialchars($app->request->post('password'), ENT_QUOTES);
            $response = array();
            $db = new DbHandler();
            if ($db->checkLogin($email, $password)) {
              if($password == 'facebook'){
                $result = $db->getUserByEmail($email,'member_facebook_id');
              }else{
                $result = $db->getUserByEmail($email,'member_email');
              }
                if ($result['member_status_confirm']==0 && $password !="facebook") {
                  $response['res_code'] = "03";
                  $response['res_text'] = "กรุณายืนยันการสมัครสมาชิกที่อีเมล";
                  $response["res_result"] = $result['member_email'];
                }else if ($result != NULL) {
                    $result['mkey'] = $result['mkey'];
                    $result['member_id'] = $result['member_id2'];
                    $result['member_img'] = BASE_URL.'data/img_member/'.$result['member_id'].'/'.$result['member_img'];
                    $result['member_comp_img'] = BASE_URL.'data/img_membercom/'.$result['member_comp_id'].'/'.$result['member_comp_img'];
                    $response["res_code"] = "00";
                    $response['res_text'] = "เข้าสู่ระบบสำเร็จ";
                    $response["res_result"] = $result;
                } else {
                    $response['res_code'] = "01";
                    $response['res_text'] = "เกิดข้อผิดพลาด กรุณาลองอีกครั้ง";
                }
            } else {
                $response['res_code'] = "02";
                $response['res_text'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง';
            }

            echoRespnse(200, $response);
        });

  /*** ล็อกอิน ***
   * url - /login with key
   * method - POST
   * params - email, password
   */
  $app->post('/loginWithKey', function() use ($app) {

              verifyRequiredParams(array('mkey'));
              $mkey = htmlspecialchars($app->request->post('mkey'), ENT_QUOTES);
              $response = array();
              $db = new DbHandler();
              if ($db->checkLoginWithKey($mkey)) {
                $result = $db->getUserByEmail($mkey,'member_api_key');
                  if ($result != NULL) {
                      $result['mkey'] = $result['mkey'];
                      $result['member_id'] = $result['member_id2'];
                      $result['member_img'] = BASE_URL.'data/img_member/'.$result['member_id'].'/'.$result['member_img'];
                      $result['member_comp_img'] = BASE_URL.'data/img_membercom/'.$result['member_comp_id'].'/'.$result['member_comp_img'];
                      $response["res_code"] = "00";
                      $response['res_text'] = "เข้าสู่ระบบสำเร็จ";
                      $response["res_result"] = $result;
                  } else {
                      $response['res_code'] = "01";
                      $response['res_text'] = "เกิดข้อผิดพลาด กรุณาลองอีกครั้ง";
                  }
              } else {
                  $response['res_code'] = "02";
                  $response['res_text'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองอีกครั้ง';
              }

              echoRespnse(200, $response);
          });


/*** ลืมรหัสผ่าน ***
 * url - /forgot
 * method - POST
 * params - email, password
 */
$app->post('/forgot', function() use ($app) {

          verifyRequiredParamsRegis(array('email'));
          $email = htmlspecialchars($app->request->post('email'), ENT_QUOTES);
          $response = array();
          $db = new DbHandler();
          $result = $db->sendForgotPass($email);
          if ($result == 0) {
              $response["res_code"] = "00";
              $response['res_text'] = "รีเซ็ตรหัสผ่านสำเร็จ";
          }else if ($result == 1) {
              $response["res_code"] = "01";
              $response['res_text'] = "เกิดข้อผิดพลาด กรุณาลองอีกครั้ง";
          } else if ($result == 3) {
             $response["res_code"] = "03";
            $response['res_text'] = "";
          }else {
              $response['res_code'] = "02";
              $response['res_text'] = "Email ผิดพลาดไม่สามารถส่ง Email ได้";
          }

          echoRespnse(200, $response);
          });


          /*** changepassword ***
           * url - /changepassword
           * method - POST
           * params - compType1, compType2, compType3
           */
          $app->post('/changepassword', 'authenticate',function() use ($app) {
                      global $user_id;
                      $passold = $app->request->post('passold');
                      $passnew = $app->request->post('passnew');
                      // $passconfirm = $app->request->post('passconfirm');
                      $response = array();
                      $db = new DbHandler();
                      $result = $db->changepass($passold, $passnew,$user_id);
                      if ($result != NULL ) {
                          $response["res_code"] = "00";
                          $response['res_text'] = "แสดงข้อมูลสำเร็จ";
                          $response["res_result"] = $result;
                      } else {
                          $response['res_code'] = "01";
                          $response['res_text'] = 'ไม่พบข้อมูล.';
                      }
                      echoRespnse(200, $response);
                  });




/*** checkformset ***
 * url - /checkformset
 * method - POST
 * params - compType1, compType2, compType3
 */
$app->post('/checkformset', function() use ($app) {

            $compType1 = $app->request->post('compType1');
            $compType2 = $app->request->post('compType2');
            $compType3 = $app->request->post('compType3');
            $response = array();
            $db = new DbHandler();
            $result = $db->getFormSet($compType1, $compType2, $compType3);
            if ($result != NULL ) {
                $response["res_code"] = "00";
                $response['res_text'] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = $result;
            } else {
                $response['res_code'] = "01";
                $response['res_text'] = 'ไม่พบข้อมูล.';
            }
            echoRespnse(200, $response);
        });

/*** checkformset 2***
 * url - /checkformset 2
 * method - POST
 * params - compType1, compType2, compType3
 * by pao
 */
$app->post('/checkformset2', function() use ($app) {

  $compType1 = $app->request->post('compType1');
  $compType2 = $app->request->post('compType2');
  $compType3 = $app->request->post('compType3');
  $response = array();
  $db = new DbHandler();
  $result = $db->getFormSet2($compType1, $compType2, $compType3);
  if ($result != NULL ) {
      $response["res_code"] = "00";
      $response['res_text'] = "แสดงข้อมูลสำเร็จ";
      $response["res_result"] = $result;
  } else {
      $response['res_code'] = "01";
      $response['res_text'] = 'ไม่พบข้อมูล.';
      $response["res_result"] = $result;
  }
  echoRespnse(200, $response);
});

/*** เช็คเวอร์ชั่นแอพ ***
 * url - /version
 * method - POST
 * params - version_build, password
 */
$app->post('/version', function() use ($app) {

            $build = $app->request->post('version_build');
            $type = $app->request->post('version_type');
            $response = array();
            $db = new DbHandler();
            $result = $db->checkVersionUpdate($build,$type);
            if ($result != NULL) {
                $response["res_code"] = "01";
                $response['res_text'] = "application มีการอัพเดตเวอร์ชั่น";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    $tmp = array();
                    $tmp["version_bundle"] = $res["version_bundle"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response['res_code'] = "00";
                $response['res_text'] = 'application ของคุณเป็นเวอร์ชั่นปัจจุบัน';
                echoRespnse(200, $response);
            }


        });

/*** ข้อความข้อกำหนดและเงื่อนไขการใช้งาน ***
 * url - /termsofuse
 * method - GET
 */
$app->get('/termsofuse', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getTermsOfUse();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                //while ($res = $result->fetch_assoc()) { // code real
                foreach ($result as $key=>$value) { // code mock
                    $res = (array)$value; // code mock
                    $tmp = array();
                    $tmp["termsOfUse_id"] = $res["termsOfUse_id"];
                    $tmp["termsOfUse_text"] = $res["termsOfUse_text"];
                    $tmp["termsOfUse_text_en"] = $res["termsOfUse_text_en"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });



/*** ชื่อประเทศ ***
 * url - /country
 * method - GET
 */
$app->get('/country', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getCountry();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    $tmp = array();
                    $tmp["country_id"] = $res["id"];
                    $tmp["country_name"] = $res["name"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });


/*** คำถาม ***
 * url - /feedback
 * method - GET
 */
$app->get('/feedback', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getFeedback();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                $response["res_result"] = $result;
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });


        /***  onetime token  */
        $app->post('/redirect', function() use ($app) {

                           $session_id = $app->request->post('session_id');
                              $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
                              $ret_str = substr( str_shuffle( $chars ), 0, 12 );

                           $response = array();
                           $db = new DbHandler();
                           $result = $db->redirectOnetime($session_id,$ret_str);
                           $onetime_token = $db->getOnetime($session_id);

                           if ($result) {
                               $response["res_code"] = "00";
                               $response['res_text'] = "สำเร็จ";
                               $response['res_onetime'] = $onetime_token;
                           } else {
                               $response['res_code'] = "01";
                               $response['res_text'] = "ไม่สำเร็จ";
                           }
                           echoRespnse(200, $response);
                       });

/*** ชื่อจังหวัด ***
 * url - /province
 * method - GET
 */
$app->get('/province', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getProvince();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    $tmp = array();
                    $tmp["province_id"] = $res["prov_id"];
                    $tmp["province_name"] = $res["prov_name"];
                    $tmp["province_name_en"] = $res["prov_name_eng"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });



/*** ประเภทเรื่องร้องเรียน ***
 * url - /typeComplaint
 * method - GET
 */
$app->get('/typeComplaint', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getTypeComplaint();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = $result;
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });



        /*** ค่าเงิน ***
         * url - /currency
         * method - GET
         */
        $app->get('/currency', function() use ($app) {
                    $response = array();
                    $db = new DbHandler();
                    $result = $db->getCurrency();
                    if ($result != NULL) {
                        $response["res_code"] = "00";
                        $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                        $response["res_result"] = array();
                        while ($res = $result->fetch_assoc()) {
                            $tmp = array();
                            $tmp["curren_idPrimary"] = $res["curren_id"];
                            $tmp["curren_name"] = $res["curren_name"];
                            $tmp["curren_rate"] = $res["curren_rate"];
                            array_push($response["res_result"], $tmp);
                        }
                        echoRespnse(200, $response);
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "ไม่พบข้อมูล";
                        echoRespnse(200, $response);
                    }
                });

                /*** ประเภทความผิด ***
                 * url - /IncorrectType
                 * method - GET
                 */
                $app->get('/IncorrectType', function() use ($app) {
                            $response = array();
                            $db = new DbHandler();
                            $result = $db->IncorrectType();
                            if ($result != NULL) {
                                $response["res_code"] = "00";
                                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                                $response["res_result"] = array();
                                while ($res = $result->fetch_assoc()) {
                                    $tmp = array();
                                    $tmp["incType_id"] = $res["incType_id"];
                                    $tmp["incType_name"] = $res["incType_name"];
                                    $tmp["incType_name_en"] = $res["incType_name_en"];
                                    $tmp["incType_other_flag"] = $res["incType_other_flag"];
                                    array_push($response["res_result"], $tmp);
                                }
                                echoRespnse(200, $response);
                            } else {
                                $response["res_code"] = "01";
                                $response["res_text"] = "ไม่พบข้อมูล";
                                echoRespnse(200, $response);
                            }
                        });


/*** Case ***
 * url - /typeProduct
 * method - GET
  */
   $app->get('/CaesUserAll', 'authenticate', function() use ($app) {
      global $user_id;
      $response = array();
      $db = new DbHandler();
      $result = $db->getCaseUser($user_id);
      if ($result != NULL) {
              $response["res_code"] = "00";
              $response["res_text"] = "แสดงข้อมูลสำเร็จ";
              $response["res_result"] = array();
              while ($res = $result->fetch_assoc()) {
                  $text="000";
                if (strlen($res["case_id"])==3) {
                  $text="00";
                }
                $tmp = array();
                $tmp["case_id"] = $res["case_id"];
                $tmp["caseDtl_title"] =$text.$res["case_id"]." ".$res["caseDtl_title"];
                array_push($response["res_result"], $tmp);
              }
              echoRespnse(200, $response);
        } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
        }
      });




/*** ประเภทสินค้า ***
 * url - /typeProduct
 * method - GET
 */
$app->get('/typeProduct', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getTypeProduct();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                // $response["res_result"] = array();
                $response["res_result"] = $result;
                // while ($res = $result->fetch_assoc()) {
                //     $tmp = array();
                //     $tmp["prodType_id"] = $res["prodType_id"];
                //     $tmp["prodType_name"] = $res["fullname_product"];
                //     $tmp["prodType_name_en"] = $res["fullname_product_en"];
                //     array_push($response["res_result"], $tmp);
                // }

                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });




/*** รายการองค์ความรู้ ***
 * url - /knowledge
 * method - GET
 */
$app->get('/knowledge', function() use ($app) {

            // ?filter={"%name_item%":"ม",">status_item":"1"}
            $filter = $app->request->get('filter');
            // ?offset=0&limit=2
            $limit = $app->request->get('limit');
            $offset = $app->request->get('offset');
            // ?sort=+status_item,-qty_item
            $sort = $app->request->get('sort');
            $response = array();
            $db = new DbHandler();
            $result = $db->getKnowledge($limit,$offset,$filter,$sort);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["offset"] =$offset;
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                // $response["result"] = $result;
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    $tmp = array();
                    $typename = $res["prodType_name"];
                    $typename_en = $res["prodType_name_en"];
                    if ($res["prodType_name"]==null) {
                        $typename = $res["incType_name"];
                        $typename_en = $res["incType_name_en"];
                    }
                    $tmp["knowledge_id"] = $res["case_id"];
                    $tmp["knowledge_name"] = $res["caseDtl_title"];
                    $tmp["knowledge_type"] = $res["compType_name"];
                    $tmp["knowledge_type_en"] = $res["compType_name_en"];
                    $tmp["knowledge_typeProduct"] = $typename;
                    $tmp["knowledge_typeProduct_en"] = $typename_en;
                    $tmp["knowledge_incType_id"] = $res["incType_id"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });


/*** องค์ความรู้ ***
 * url - /knowledge/:id
 * method - GET
 */
$app->get('/knowledge/:id', function($knowledge_id) use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getIdKnowledge($knowledge_id);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    $datespilt = split ("ร้องเรียน", $res["compTypeSub1_name"]);
                    $datespilt_en = split ("against", $res["compTypeSub1_name_en"]);
                    if($res["compTypeSub1_id"] == '3'){
                      $datespilt[0] = $res["compTypeSub1_name"];
                      $datespilt[1] = "-";
                      $datespilt_en[0] = $res["compTypeSub1_name_en"];
                      $datespilt_en[1] = "-";
                    }else if($res["compTypeSub1_id"] == '4'){
                      $datespilt[0] = "-";
                      $datespilt[1] = $res["compTypeSub1_name"];
                      $datespilt_en[0] = "-";
                      $datespilt_en[1] = $res["compTypeSub1_name_en"];
                    }
                    $tmp = array();
                    $typename = $res["prodType_name"];
                    $typename_en = $res["prodType_name_en"];
                    if ($res["prodType_name"]==null) {
                        $typename = $res["incType_name"];
                        $typename_en = $res["incType_name_en"];
                    }
                    $tmp["knowledge_id"] = $res["case_id"];
                    $tmp["knowledge_name"] = $res["caseDtl_title"];
                    $tmp["knowledge_type"] = $res["compType_name"];
                    $tmp["knowledge_type_en"] = $res["compType_name_en"];
                    $tmp["knowledge_complain1"] = $datespilt[0];
                    $tmp["knowledge_complain2"] = $datespilt[1];
                    $tmp["knowledge_complain1_en"] = $datespilt_en[0];
                    $tmp["knowledge_complain2_en"] = $datespilt_en[1];
                    $tmp["knowledge_typeProduct"] = $typename;
                    $tmp["knowledge_typeProduct_en"] = $typename_en;
                    $tmp["knowledge_history"] = strip_tags($res["caseDtl_derivation"]);
                    $tmp["knowledge_value"] = $res["caseDtl_damage_val"];
                    $tmp["knowledge_want"] = strip_tags($res["caseDtl_complnt_need"]);
                    $tmp["knowledge_result"] = $res["case_close_resultProcess"];
                    $tmp["knowledge_curren"] = $res["curren_name"];
                    $tmp["knowledge_incType_id"] = $res["incType_id"];

                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });

/* ============================================================================= */
/* ============================== ฟังก์ชั่นที่มีการตรวจสอบ ============================ */
/* ============================================================================= */


/*** บันทึกข้อแนะนำติชม ***
 * url - /feedback
 * method - post
 */
 $app->post('/feedback', 'authenticate', function() use ($app) {

             $feedback_q_id = $app->request->post('feedback_q_id');
             $feedback_a_result = $app->request->post('feedback_a_result');

             global $user_id;
             $response = array();
             $db = new DbHandler();
             if ($db->feedbackSave($feedback_q_id,$feedback_a_result,$user_id)) {
                 $response["res_code"] = "00";
                 $response['res_text'] = "แนะนำติชมสำเร็จ";
             } else {
                 $response['res_code'] = "01";
                 $response['res_text'] = "แนะนำติชมไม่สำเร็จ";
             }
             echoRespnse(200, $response);
         });


/*** อัพเดทเงื่อนไขการแจ้งข้อร้องเรียน , ผู้ใช้สามารถอัพเดทของตัวเองได้เท่านั้น ***
 * url - /complaint/:id
 * method - PUT
 */
$app->put('/complaint/:id'/*, 'authenticate'*/, function($member_id) use($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateUserCondition($member_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "ยอมรับเงื่อนไขสำเร็จ";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ยอมรับเงื่อนไขไม่สำเร็จ กรุณาลองอีกครั้ง";
            }
            echoRespnse(200, $response);
        });

        /**เดียวลบ**/
$app->put('/complaint2/:id'/*, 'authenticate'*/, function($member_id) use($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateUserCondition2($member_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "ยอมรับเงื่อนไขสำเร็จ";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ยอมรับเงื่อนไขไม่สำเร็จ กรุณาลองอีกครั้ง";
            }
            echoRespnse(200, $response);
        });
      /**เดียวลบ**/

/*** แสดง complaint ทั้งหมด , complaint ของผู้ใช้เท่านั้น ***
 * url /complaint
 * method GET
 */
$app->get('/complaint', 'authenticate', function() use ($app) {

            // ?filter={"%name_item%":"ม",">status_item":"1"}
            $filter = $app->request->get('filter');
            // ?offset=0&limit=2
            $limit = $app->request->get('limit');
            $offset = $app->request->get('offset');
            // ?sort=+status_item,-qty_item
            $sort = $app->request->get('sort');


            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getAllUserComplaint($user_id,$limit,$offset,$filter,$sort);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
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

                    if($res["case_status"] == "1"){
                      $status = 1;$percen = 25;
                    }else if($res["case_status"] == "2"){
                      $res_status = $db->checkPercen($res["case_id"]);
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
                    $tmp = array();
                    $datespilt = split (" ", $res["case_receivedoc_real_datetime"]);
                    $tmp["comp_id"] = $res["case_id"];
                    $tmp["comp_name"] = $res["caseDtl_title"];
                    $tmp["comp_date"] = $datespilt[0];
                    $tmp["comp_time"] = $datespilt[1];
                    $tmp["comp_status"] = $res["case_status"];
                    $tmp["comp_process"] = $status;
                    $tmp["comp_perces"] = $percen;
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล";
              echoRespnse(200, $response);
            }

        });



/*** แสดง complaint2 อย่างละ 2  , complaint ของผู้ใช้เท่านั้น ***
 * url /complaint2
 * method GET
 */
$app->get('/complaint2', 'authenticate', function() use ($app) {



            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getComplaintType2($user_id);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) {
                    if($res["case_status"] == "1"){
                      $status = 1;$percen = 25;
                    }else if($res["case_status"] == "2"){
                      $res_status = $db->checkPercen($res["case_id"]);
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
                    $tmp = array();
                    $datespilt = split (" ", $res["case_receivedoc_real_datetime"]);
                    $tmp["comp_id"] = $res["case_id"];
                    $tmp["comp_name"] = $res["caseDtl_title"];
                    $tmp["comp_date"] = $datespilt[0];
                    $tmp["comp_time"] = $datespilt[1];
                    $tmp["comp_status"] = $res["case_status"];
                    $tmp["comp_process"] = $status;
                    $tmp["comp_perces"] = $percen;
                    $tmp["test"] = $res_status;
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล";
              echoRespnse(200, $response);
            }

        });

/*** แสดง complaint id ที่เลือก , complaint ของผู้ใช้เท่านั้น ***
 * url /complaint/:id
 * method GET
 */
$app->get('/complaint/:id', 'authenticate', function($case_id) {
            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getComplaint($user_id,$case_id);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = $result;
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });

/*** Open noti page update all to open ***
 * url - /notification/:id
 * method - PUT
 */
// $app->put('/notificationUpdateall/'/*, 'authenticate'*/, function($memid) use($app) {
$app->put('/notificationUpdateall/:id', 'authenticate', function($memid) use($app) {

                    global $user_id;
                    $response = array();
                    $db = new DbHandler();
                    $result = $db->updateReadNotiAll($memid);
                    // $response["res_code"] = "00";
                    // $response["txt"] = $result;
                    if ($result) {
                        $response["res_code"] = "00";
                        $response["res_text"] = "อัพเดท Open noti page สำเร็จ";
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "อัพเดท Open noti page ไม่สำเร็จ";
                    }
                    echoRespnse(200, $response);
                });

    /*** Open Message update all to open ***
     * url - /notification
     * method - PUT
     */
  $app->put('/OpenMessageAll', 'authenticate', function() use($app) {
                      global $user_id;
                      $response = array();
                      $db = new DbHandler();
                      $result = $db->updateOpenMessage($user_id);
                      if ($result) {
                            $response["res_code"] = "00";
                            $response["res_text"] = "อัพเดท Open Message page สำเร็จ";
                      } else {
                            $response["res_code"] = "01";
                            $response["res_text"] = "อัพเดท Open Message page ไม่สำเร็จ";
                      }
                          echoRespnse(200, $response);
  });


/*** ลงทะเบียน noti ***
 * url /regisnoti
 * method POST
 */
 $app->post('/regisnoti', 'authenticate', function() use ($app) {

             $device_uuid = $app->request->post('device_uuid');
             $device_platform = $app->request->post('device_platform');
             global $user_id;
             $response = array();
             $db = new DbHandler();
             if ($db->RegisNoti($user_id,$device_uuid,$device_platform)) {
                 $response["res_code"] = "00";
                 $response['res_text'] = "ลงทะเบียน noti สำเร็จ";
                 $response["user_id"] = $user_id;
                 $response["device_uuid"] = $device_uuid;
                 $response["device_platform"] = $device_platform;
             } else {
                 $response['res_code'] = "01";
                 $response['res_text'] = "ลงทะเบียน noti ไม่สำเร็จ";
                 $response["user_id"] = $user_id;
                 $response["device_uuid"] = $device_uuid;
                 $response["device_platform"] = $device_platform;
             }
             echoRespnse(200, $response);
         });

         /*** ลงทะเบียน noti ***
          * url /regisnoti
          * method POST
          */
      $app->post('/logout', 'authenticate', function() use ($app) {

                      $device_uuid = $app->request->post('device_uuid');
                      $device_platform = $app->request->post('device_platform');
                      global $user_id;
                      $response = array();
                      $db = new DbHandler();
                      if ($db->logout($user_id,$device_uuid,$device_platform)) {
                          $response["res_code"] = "00";
                          $response['res_text'] = "ย้าย uuid สำเร็จ";

                      } else {
                          $response['res_code'] = "01";
                          $response['res_text'] = "ย้าย uuid ไม่สำเร็จ";

                      }
                      echoRespnse(200, $response);
                  });


/*** แสดง badge ทั้งหมด , badge ของผู้ใช้เท่านั้น ***
 * url /badge
 * method GET
 */
$app->get('/badge', 'authenticate', function() use ($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getAllBadge($user_id);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = $result;
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล";
              echoRespnse(200, $response);
            }
        });


/*** แสดง notification ทั้งหมด , notification ของผู้ใช้เท่านั้น ***
 * url /notification
 * method GET
 */
$app->get('/notification', 'authenticate', function() use ($app) {

            // ?filter={"%name_item%":"ม",">status_item":"1"}
            $filter = $app->request->get('filter');
            // ?offset=0&limit=2
            $limit = $app->request->get('limit');
            $offset = $app->request->get('offset');
            // ?sort=+status_item,-qty_item
            $sort = $app->request->get('sort');
            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getAllUserNoti($user_id,$limit,$offset,$filter,$sort);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                while ($res = $result->fetch_assoc()) { // code real
                  //  $datespilt = split (" ", $res["noti_datetime"]);
                  //  $tmp = array();
                  //  $tmp["noti_id"] = $res["noti_id"];
                  //  $tmp["noti_name"] = $res["caseDtl_title"]."....".(intval($res["noti_type"])*25)."%";
                  //  $tmp["noti_date"] = $datespilt[0];
                  //  $tmp["noti_time"] = $datespilt[1];
                  //  $tmp["noti_type"] = $res["noti_type"];
                  //  $tmp["noti_read"] = $res["noti_read"];
                  //  $tmp["comp_id"] = $res["case_id"];
                  //  array_push($response["res_result"], $tmp);

                  $datespilt = split (" ", $res["msgNotiApp_datetime"]);
                  $tmp = array();
                  $tmp["noti_id"] = $res["msgNotiApp_id"];
                  // $tmp["noti_name"] = $res["msgNotiApp_message"]."....".(intval($res["msgNotiApp_step"])*25)."%";
                  $tmp["noti_name"] = $res["msgNotiApp_message"];
                  $tmp["noti_name_en"] = $res["msgNotiApp_message_en"];
                  $tmp["noti_date"] = $datespilt[0];
                  $tmp["noti_time"] = $datespilt[1];
                  $tmp["noti_type"] = $res["msgNotiApp_step"];
                  $tmp["noti_read"] = $res["msgNotiApp_read_status"];
                  $tmp["comp_id"] = $res["case_id"];
                  $tmp["process_type_step"] = $res["process_type_step"];
                  array_push($response["res_result"], $tmp);

                }
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล";
              echoRespnse(200, $response);
            }
        });

/*** แก้ไข Read ให้กับ noti ***
 * url - /notification/:id
 * method - PUT
 */
$app->put('/notification/:id', 'authenticate', function($noti_id) use($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateReadNoti($noti_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "อัพเดท Read สำเร็จ"+$noti_id;
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "อัพเดท Read ไม่สำเร็จ" + $noti_id;
            }
            echoRespnse(200, $response);
        });

//เปิดจาก notifocation
$app->put('/notificationopen/:id', 'authenticate', function($noti_id) use($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateReadNotiopen($noti_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "อัพเดท Read สำเร็จ"+$noti_id;
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "อัพเดท Read ไม่สำเร็จ" + $noti_id;
            }
            echoRespnse(200, $response);
        });





/*** เปลี่ยนภาษา ***
 * url - /lang
 * method - PUT
 */
$app->put('/lang', 'authenticate', function($lang_id) use($app) {

            $OnOff = htmlspecialchars($app->request->post('OnOff'), ENT_QUOTES);
            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateLang($OnOff,$user_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "เปลี่ยนภาษาสำเร็จ";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "เปลี่ยนภาษาไม่สำเร็จ";
            }
            echoRespnse(200, $response);
        });



/*** เปิดปิด noti ***
 * url - /noti
 * method - PUT
 */
$app->put('/noti', 'authenticate', function($noti_id) use($app) {

            $OnOff = htmlspecialchars($app->request->post('OnOff'), ENT_QUOTES);
            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->updateNoti($OnOff,$user_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "เปิด/ปิด noti สำเร็จ";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "เปิด/ปิด noti ไม่สำเร็จ";
            }
            echoRespnse(200, $response);
        });


/*** ลบ Noti ***
 * url - /notification/:id
 * method - DELETE
 */
$app->delete('/notification/:id', 'authenticate', function($noti_id) use($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->DeleteNoti($noti_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "ลบ Noti สำเร็จ";
                $response["res_textx"] = "ล5555";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ลบ Noti ไม่สำเร็จ";
            }
            echoRespnse(200, $response);
        });


        /*** ลบ Noti ***
         * url - /notification/:id
         * method - DELETE
         */
        $app->delete('/messages/:id', 'authenticate', function($noti_id) use($app) {

                    global $user_id;
                    $response = array();
                    $db = new DbHandler();
                    $result = $db->Deletemessage($noti_id);
                    if ($result) {
                        $response["res_code"] = "00";
                        $response["res_text"] = "ลบ Noti สำเร็จ";
                        $response["res_textx"] = "ล5555";
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "ลบ Noti ไม่สำเร็จ";
                    }
                    echoRespnse(200, $response);
                });


/*** แสดง message ทั้งหมด , message ของผู้ใช้เท่านั้น ***
 * url /message
 * method GET
 */
$app->get('/message', 'authenticate', function() use ($app) {


          $filter = $app->request->get('filter');
          // ?offset=0&limit=2
          $limit = $app->request->get('limit');
          $offset = $app->request->get('offset');
          // ?sort=+status_item,-qty_item
          $sort = $app->request->get('sort');

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getAllUserMessage($user_id,$limit,$offset,$filter,$sort);
            $datespilt = array();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                //while ($res = $result->fetch_assoc()) { // code real
                foreach ($result as $key=>$value) { // code mock

                    $res = (array)$value; // code mock
                    $datespilt = explode (" ", $res["msgBox_datetime"]);
                    $tmp = array();
                    $tmp["message_id"] = $res["msgBox_id"];
                    $tmp["message_name"] = $res["msgBox_message"];
                    $tmp["message_name_en"] = $res["msgBox_message_en"];
                    $tmp["message_date"] = $datespilt[0];
                    $tmp["message_time"] = $datespilt[1];
                    $tmp['message_read'] = $res["readmsg"];
                    $tmp['msgBoxRef_id'] = $res['case_id'];

                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล...";
              echoRespnse(200, $response);
            }

        });


/*** แสดง message ที่เลือก , message ของผู้ใช้เท่านั้น ***
 * url /message/:id
 * method GET
 */
$app->get('/message/:id', 'authenticate', function($id) use ($app) {

            global $user_id;
            $response = array();
            $db = new DbHandler();
            $result = $db->getMessage($id);
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                //while ($res = $result->fetch_assoc()) { // code real
                foreach ($result as $key=>$value) { // code mock
                    $res = (array)$value; // code mock
                    $datespilt = explode (" ", $res["msgBox_datetime"]);
                    $tmp = array();
                    $tmp["message_id"] = $res["message_id"];
                    $tmp["message_name"] = $res["message_name"];
                    $tmp["message_date"] = $datespilt[0];
                    $tmp["message_time"] = $datespilt[1];
                    $tmp["message_caseid"] = $res["message_caseid"];
                    $tmp["message_from"] = $res["sendfrom"];
                    $tmp["message_text"] = $res["caseDtl_title"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else{
              $response["res_code"] = "01";
              $response["res_text"] = "ไม่พบข้อมูล///";
              echoRespnse(200, $response);
            }

        });

/*** เพิ่ม message ***
 * url - /message
 * method - POST
 * params - case_id , message_title , message_detail
 */
$app->post('/message', 'authenticate', function() use ($app) {

            $response = array();
            $case_id = $app->request->post('case_id');
            // $message_title = $app->request->post('message_title');
            $message_detail = $app->request->post('msgBox_message');
            $message_img = $app->request->post('complnt_file');
            global $user_id;
            $db = new DbHandler();
            $message_id = $db->createMessage($user_id,$case_id, $message_detail,$message_img);
            if ($message_id != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "สร้างข้อความใหม่สำเร็จ";
                $response["res_result"] = array();
                $tmp = array();
                $tmp["message_id"] = $message_id;
                array_push($response["res_result"], $tmp);
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "สร้างข้อความใหมไม่สำเร็จ กรุณาลองอีกครั้ง";

                echoRespnse(200, $response);
            }

        });

        /*** เพิ่ม message ***
         * url - /message
         * method - POST
         * params - case_id , message_title , message_detail
         */
        $app->post('/messageReply', 'authenticate', function() use ($app) {


                    $response = array();
                    $case_id = $app->request->post('case_id');
                    $message_id = $app->request->post('message_id');
                    $message_detail = $app->request->post('msgBox_message');
                    $message_img = $app->request->post('complnt_file');

                    global $user_id;
                    $db = new DbHandler();
                    $message_id = $db->MessageReply($user_id,$case_id, $message_detail,$message_img,$message_id);
                    if ($message_id != NULL) {
                        $response["res_code"] = "00";
                        $response["res_text"] = "สร้างข้อความใหม่สำเร็จ";
                        $response["res_result"] = array();
                        $tmp = array();
                        $tmp["message_id"] = $message_id;
                        array_push($response["res_result"], $tmp);
                        echoRespnse(200, $response);
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "สร้างข้อความใหม่ไม่สำเร็จ กรุณาลองอีกครั้ง";

                        echoRespnse(200, $response);
                    }

                });




        /*** แก้ไข Read ให้กับ message ***
         * url - /message/

         */
        //  $app->get('/message', 'authenticate', function() use ($app) {
        $app->GET('/Readmessage/:id', 'authenticate', function($id_msg) use($app) {
                    // $id_msg = $app->request->get('message_id');
                    global $user_id;
                    $response = array();
                    $db = new DbHandler();
                    $result = $db->updateReadMessage($user_id,$id_msg);
                    if ($result) {
                        $response["res_code"] = "00";
                        $response["res_text"] = "อัพเดท Read สำเร็จ".$id_msg;
                    } else {
                        $response["res_code"] = "01";
                        $response["res_text"] = "อัพเดท Read ไม่สำเร็จ".$id_msg;
                    }
                    echoRespnse(200, $response);
                });

/*** เช็ค compValidate ***
 * url - /compValidate
 * method - POST
 * params -
 */
$app->post('/compValidate', 'authenticate', function() use ($app) {
            global $user_id;
            $db = new DbHandler();
            verifyRequiredParams($db->validateComp($app->request->post('validate'),$user_id));
            $response["res_code"] = "00";
            $response["res_text"] = "สำเร็จ";
            echoRespnse(200, $response);

            });

/*** เพิ่ม complaint ***
 * url - /complaint
 * method - POST
 * params -
 */
$app->post('/complaint', 'authenticate', function() use ($app) {
            $compType_other = htmlspecialchars(trim($app->request->post('compType_other')), ENT_QUOTES);
            $incType_other = htmlspecialchars(trim($app->request->post('incType_other')), ENT_QUOTES);
            $prodType_other = htmlspecialchars(trim($app->request->post('prodType_other')), ENT_QUOTES);

            $compType_id = trim($app->request->post('compType_id'));
            $compTypeSub1_id = trim($app->request->post('compTypeSub1_id'));
            $compTypeSub2_id = trim($app->request->post('compTypeSub2_id'));
            $case_status = 0;
            $case_assign_status = 0;
            $caseCh_id = 1;
            $case_priority = 1;
            $case_receivedoc_real_datetime = trim($app->request->post('case_receivedoc_real_datetime'));
            $case_create_datetime = trim($app->request->post('case_create_datetime'));
            $case_disKPI_status = 0;
            $caseDtl_title = htmlspecialchars(trim($app->request->post('caseDtl_title')), ENT_QUOTES);
            $prodType_id = trim($app->request->post('prodType_id'));
            $caseDtl_derivation = htmlspecialchars(trim($app->request->post('caseDtl_derivation')), ENT_QUOTES);
            $caseDtl_damage_val = htmlspecialchars(trim($app->request->post('caseDtl_damage_val')), ENT_QUOTES);
            $curren_id = trim($app->request->post('curren_id'));
            $caseDtl_complnt_need = htmlspecialchars(trim($app->request->post('caseDtl_complnt_need')), ENT_QUOTES);
            $applnt_ident = htmlspecialchars(trim($app->request->post('applnt_ident')), ENT_QUOTES);
            $applntOrg_trade_number0 = htmlspecialchars(trim($app->request->post('applntOrg_trade_number')), ENT_QUOTES);
            $applntOrg_trade_number = htmlspecialchars(trim($app->request->post('applntOrg_trade_number2')), ENT_QUOTES);
            $applnt_firstname = htmlspecialchars(trim($app->request->post('applnt_firstname')), ENT_QUOTES);
            $applnt_type = trim($app->request->post('applnt_type'));
            $applnt_tel = trim($app->request->post('applnt_tel'));
            $applnt_mobile = trim($app->request->post('applnt_mobile'));
            $applnt_ident_valid = 0;
            $applnt_status = 0;
            $complnt_trade_number = htmlspecialchars(trim($app->request->post('complnt_trade_number')), ENT_QUOTES);
            $complnt_name = htmlspecialchars(trim($app->request->post('complnt_name')), ENT_QUOTES);
            $complnt_backlist = 0;
            $applnt_valid_dbd = 0;
            $applnt_valid_ditp = 0;
            $case_receivedoc_date = trim($app->request->post('case_receivedoc_date'));
            $case_createBy_id = trim($app->request->post('case_createBy_id'));
            $applnt_lastname = trim($app->request->post('applnt_lastname'));
            $applntOrg_name0 = trim($app->request->post('applntOrg_name'));
            $applntOrg_name = trim($app->request->post('applntOrg_name2'));
            $complnt_country_id = trim($app->request->post('complnt_country_id'));
            $complnt_file = $app->request->post('complnt_file');

            $incType_id = $app->request->post('incType_id');
            $applntOrg_country_id = $app->request->post('applntOrg_country_id');

            $complnt_import_export = $app->request->post('complnt_import_export');
            $applntOrg_branch = $app->request->post('applntOrg_branch');
            $applntOrg_tel = $app->request->post('applntOrg_tel');
            $applntOrg_fax = $app->request->post('applntOrg_fax');

            $applnt_gender = $app->request->post('applnt_gender');
            $applnt_career = $app->request->post('applnt_career');
            $applnt_mobile = $app->request->post('applnt_mobile');
            $applnt_email = $app->request->post('applnt_email');
            $applnt_address = $app->request->post('applnt_address');
            $applntOrg_prov_id = $app->request->post('applnt_prov_id');
            $applntOrg_zipcode = $app->request->post('applnt_zipcode');
            $applnt_country_id = $app->request->post('applnt_country_id');


            $complnt_branch = $app->request->post('complnt_branch');
            $complnt_contact_tel = $app->request->post('complnt_contact_tel');
            $complnt_contact_email = $app->request->post('complnt_contact_email');
            $complnt_contact_address = $app->request->post('complnt_contact_address');
            $complnt_contact_prov_id = $app->request->post('complnt_prov_id');
            $complnt_zipcode = $app->request->post('complnt_zipcode');
            $complnt_contact_name = $app->request->post('complnt_contact_name');


            $db = new DbHandler();
            $response = array();
            global $user_id;

            $caseid = $db->createComplaint($app->request->post(),$compType_id,$compTypeSub1_id,$compTypeSub2_id,$case_status,$case_assign_status,$caseCh_id,$case_priority,$case_receivedoc_real_datetime,
            $case_disKPI_status,$caseDtl_title,$prodType_id,$caseDtl_derivation,$caseDtl_damage_val,$curren_id,$caseDtl_complnt_need,
            $applnt_ident,$applntOrg_trade_number,$applnt_firstname,$applnt_type,$applnt_ident_valid,$applnt_status,$complnt_trade_number,
            $complnt_name,$complnt_backlist,$applnt_valid_dbd,$applnt_valid_ditp,$case_receivedoc_date,$case_createBy_id,$applnt_lastname,$applntOrg_name,
            $applnt_country_id,$complnt_country_id,$case_create_datetime,$complnt_file,$user_id,$incType_id,$applntOrg_country_id,$complnt_import_export,$applntOrg_branch,$applntOrg_tel,$applntOrg_fax,
            $applnt_gender,$applnt_career,$applnt_mobile,$applnt_email,$applnt_address,$applntOrg_prov_id,$applntOrg_zipcode,$complnt_branch,
            $complnt_contact_tel,$complnt_contact_email,$complnt_contact_address,$complnt_contact_prov_id,$complnt_zipcode,$complnt_contact_name,$applntOrg_name0,$applntOrg_trade_number0,$compType_other,
            $incType_other,$prodType_other);

            if ($caseid != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แจ้งเรื่องร้องเรียนสำเร็จ";
                $response["res_result"] = array();
                $tmp = array();
                $tmp["caseid"] = $caseid;
                array_push($response["res_result"], $tmp);
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "แจ้งเรื่องร้องเรียนไม่สำเร็จ กรุณาลองอีกครั้ง";
                echoRespnse(200, $response);
            }
        });



/*** ลบ task , ผู้ใช้สามารถลบ task ได้เท่านั้น ***
* url - /tasks/:id
* method DELETE
*/
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {

            global $user_id;
            $db = new DbHandler();
            $response = array();
            $result = $db->deleteTask($user_id, $task_id);
            if ($result) {
                $response["res_code"] = "00";
                $response["res_text"] = "ลบ task สำเร็จ";
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ลบ task ไม่สำเร็จ กรุณาลองอีกครั้ง";
            }
            echoRespnse(200, $response);
        });

/*** อัพเดท user , ผู้ใช้สามารถอัพเดท user ได้เท่านั้น ***
 * url - /user/:id
 * method - PUT
 * params - task, status
 */
$app->put('/user', 'authenticate', function($user_id) use($app) {

            $arrayverify=array();
            array_push($arrayverify,'fname', 'lname', 'cid', 'address', 'country_id', 'postcode', 'phone', 'cellphone','sex');
            if($app->request->post('country_id') == '162'){
              array_push($arrayverify,'prov_id');
            }
            if($app->request->post('type_member')){// 0 = คนธรรมดา , 1 = บริษัท
              array_push($arrayverify,'position', 'company_name', 'company_taxid' ,'member_business', 'company_address', 'company_country_id',
                                         'company_postcode', 'company_phone', 'company_type');
            }else{
              array_push($arrayverify,'occupation');
            }
            if($app->request->post('company_country_id') == '162'){
              array_push($arrayverify,'company_prov_id');
            }
            verifyRequiredParamsRegis($arrayverify);

            global $user_id;
            $response = array();
            $type_member = htmlspecialchars($app->request->post('type_member'), ENT_QUOTES);
            $fname = htmlspecialchars($app->request->post('fname'), ENT_QUOTES);
            $lname = htmlspecialchars($app->request->post('lname'), ENT_QUOTES);
            $cid = htmlspecialchars($app->request->post('cid'), ENT_QUOTES);
            $occupation = htmlspecialchars($app->request->post('occupation'), ENT_QUOTES);
            $address = htmlspecialchars($app->request->post('address'), ENT_QUOTES);
            $prov_id = htmlspecialchars($app->request->post('prov_id'), ENT_QUOTES);
            $postcode = htmlspecialchars($app->request->post('postcode'), ENT_QUOTES);
            $country_id = htmlspecialchars($app->request->post('country_id'), ENT_QUOTES);
            $phone = htmlspecialchars($app->request->post('phone'), ENT_QUOTES);
            $fax = htmlspecialchars($app->request->post('cellphone'), ENT_QUOTES);
            $sex = htmlspecialchars($app->request->post('sex'), ENT_QUOTES);
            $position = htmlspecialchars($app->request->post('position'), ENT_QUOTES);
            $email = htmlspecialchars($app->request->post('email'), ENT_QUOTES);
            $company_name = htmlspecialchars($app->request->post('company_name'), ENT_QUOTES);
            $company_branch = htmlspecialchars($app->request->post('company_branch'), ENT_QUOTES);
            $company_taxid = htmlspecialchars($app->request->post('company_taxid'), ENT_QUOTES);
            $company_address = htmlspecialchars($app->request->post('company_address'), ENT_QUOTES);
            $company_prov_id = htmlspecialchars($app->request->post('company_prov_id'), ENT_QUOTES);
            $company_postcode = htmlspecialchars($app->request->post('company_postcode'), ENT_QUOTES);
            $company_country_id = htmlspecialchars($app->request->post('company_country_id'), ENT_QUOTES);
            $company_phone = htmlspecialchars($app->request->post('company_phone'), ENT_QUOTES);
            $company_fax = htmlspecialchars($app->request->post('company_fax'), ENT_QUOTES);
            $company_type_member = htmlspecialchars($app->request->post('company_type'), ENT_QUOTES);
            $comp_img = $app->request->post('comp_img');
            $user_img = $app->request->post('user_img');
            $db = new DbHandler();

            $result = $db->updateUser($user_id,$type_member, $fname, $lname, $cid, $address, $prov_id
                                   ,$postcode, $country_id, $phone, $fax, $sex, $occupation, $position
                                   , $company_name, $company_branch,$company_taxid, $company_address
                                   , $company_prov_id, $company_postcode,$company_country_id, $company_phone
                                   , $company_fax, $comp_img, $user_img);

            if ($result) {
                $result = $db->getUserByEmail($email,'member_email');
                $result['member_id'] = $result['member_id2'];
                $result['member_img'] = BASE_URL.'data/img_member/'.$result['member_id'].'/'.$result['member_img'];
                $result['member_comp_img'] = BASE_URL.'data/img_membercom/'.$result['member_comp_id'].'/'.$result['member_comp_img'];
                $response["res_code"] = "00";
                $response["res_text"] = "อัพเดท User สำเร็จ";
                $response["res_text_en"] = "Update successful";
                $response["res_result"] = $result;
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "อัพเดท User ไม่สำเร็จ กรุณาลองอีกครั้ง";
                $response["res_text_en"] = "Update unsuccessful, please try again.";
            }
            echoRespnse(200, $response);
        });




/*** แสดง help ***
 * url - /help
 * method - GET
 */
$app->get('/help', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getHelp();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                //while ($res = $result->fetch_assoc()) { // code real
                foreach ($result as $key=>$value) { // code mock
                    $res = (array)$value; // code mock
                    $tmp = array();
                    $tmp["help_id"] = $res["help_id"];
                    $tmp["help_title"] = $res["help_title"];
                    $tmp["help_title_en"] = $res["help_title_en"];
                    $tmp["help_dis"] = $res["help_dis"];
                    $tmp["help_dis_en"] = $res["help_dis_en"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });

/*** แสดง about ***
 * url - /about
 * method - GET
 */
$app->get('/about', function() use ($app) {

            $response = array();
            $db = new DbHandler();
            $result = $db->getAbout();
            if ($result != NULL) {
                $response["res_code"] = "00";
                $response["res_text"] = "แสดงข้อมูลสำเร็จ";
                $response["res_result"] = array();
                //while ($res = $result->fetch_assoc()) { // code real
                foreach ($result as $key=>$value) { // code mock
                    $res = (array)$value; // code mock
                    $tmp = array();
                    $tmp["about_id"] = $res["about_id"];
                    $tmp["about_title"] = $res["about_title"];
                    $tmp["about_title_en"] = $res["about_title_en"];
                    $tmp["about_dis"] = $res["about_dis"];
                    $tmp["about_dis_en"] = $res["about_dis_en"];
                    $tmp["about_link"] = $res["about_link"];
                    array_push($response["res_result"], $tmp);
                }
                echoRespnse(200, $response);
            } else {
                $response["res_code"] = "01";
                $response["res_text"] = "ไม่พบข้อมูล";
                echoRespnse(200, $response);
            }
        });


/* ๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑ ฟังก์ชั่น ๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑๑ */

/*** เพิ่มการตรวจสอบการร้องขอข้อมูล ***/
function authenticate(\Slim\Route $route) {
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();
        $api_key = $headers['Authorization'];
        if (!$db->isValidApiKey($api_key)) {
            $response["res_code"] = "01";
            $response["res_text"] = "Api key ไม่ถูกต้อง ไม่มีสิทธิ์การเข้าถึงข้อมูล";
            $response["api_key"] = $api_key;
            $response["device_uuid"] = $device_uuid;
            $response["headers"] = $headers;
            echoRespnse(200, $response);
            $app->stop();
        } else {
            global $user_id;
            $user_id = $db->getUserId($api_key);
        }
    } else {
        $response["res_code"] = "02";
        $response["res_text"] = "ไม่พบ Api key";
        echoRespnse(200, $response);
        $app->stop();
    }
}

/*** ตรวจสอบรูปแบบอีเมล ***/
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $response["res_code"] = "01";
      $response["res_text"] = 'รูปแบบอีเมลไม่ถูกต้อง';
      echoRespnse(200, $response);
      $app->stop();
    }
}

/*** ตรวจสอบฟิลด์ที่ไม่ได้กรอก ***/
function verifyRequiredParams($required_fields) {
    $error = false;
    $db = new DbHandler();
    $error_fields = "";
    $error_fields_en = "";
    $request_params = array();
    $request_params = $_REQUEST;
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
      if($field!= 'complnt_prov_id'){
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            // $error = false;
            $error_fields .= $field . ', ';
            $iparr = split('_', $field);
            $error_fields_en .= $iparr[1].', ';
        }
      }
    }
    if ($error) {
        $response = array();

        $app = \Slim\Slim::getInstance();

        $resultx = $db->validateCompText(substr($error_fields, 0, -2));
        $iparr = split('-', $resultx);

        //$resultx = $db->isValidApiKey($api_key);
        $response["res_code"] = "01";
        $response["res_text"] = 'กรุณากรอกข้อมูล ' . $iparr[0] . ' ให้ครบถ้วน';
        $response["res_text_en"] = 'Please fill in the form : ' . $iparr[1];
        // $response["res_text"] = $error_fields;

        echoRespnse(200, $response);
        $app->stop();
    }
}


/*** ตรวจสอบฟิลด์ที่ไม่ได้กรอก สมัครสมาชิก ***/
function verifyRequiredParamsRegis($required_fields) {
    $error = false;
    $error_fields = "";
    $error_fields_en = "";
    $request_params = array();
    $request_params = $_REQUEST;
    $response = array();
    $response['position'] = "ตำแหน่ง";
    $response['company_name'] = "ชื่อบริษัท";
    $response['company_taxid'] = "หมายเลขทะเบียนการค้า";
    $response['company_address'] = "ที่อยู่ติดต่อ";
    $response['company_prov_id'] = "จังหวัด";
    $response['company_postcode'] = "รหัสไปรษณีย์";
    $response['company_country_id'] = "ประเทศ";
    $response['company_phone'] = "เบอร์โทรศัพท์";
    $response['company_type'] = "สมาชิกกรม";
    $response['fname'] = "ชื่อ";
    $response['lname'] = "นามสกุล";
    $response['cid'] = "เลขบัตรประชาชน";
    $response['occupation'] = "อาชีพ";
    $response['address'] = "ที่อยู่ติดต่อ";
    $response['prov_id'] = "จังหวัด";
    $response['postcode'] = "รหัสไปรษณีย์";
    $response['country_id'] = "ประเทศ";
    $response['phone'] = "เบอร์โทรศัพท์";
    $response['sex'] = "เพศ";
    $response['email'] = "อีเมล";
    $response['password'] = "รหัสผ่าน";
    $response['member_business'] = "ประเภทธุรกิจ";
    $response['cellphone'] = "เบอร์โทรศัพท์มือถือ";


    $response_en = array();
    $response_en['position'] = "Position";
    $response_en['company_name'] = "Company name";
    $response_en['company_taxid'] = "Business Registration Number";
    $response_en['company_address'] = "Address";
    $response_en['company_prov_id'] = "Province";
    $response_en['company_postcode'] = "Postcode";
    $response_en['company_country_id'] = "Country";
    $response_en['company_phone'] = "Telephone number";
    $response_en['company_type'] = "DITP membership";
    $response_en['fname'] = "First name";
    $response_en['lname'] = "Surname";
    $response_en['cid'] = "13-digit Population Identification Code";
    $response_en['occupation'] = "Occupation";
    $response_en['address'] = "Address";
    $response_en['prov_id'] = "Province";
    $response_en['postcode'] = "Postcode";
    $response_en['country_id'] = "Country";
    $response_en['phone'] = "Telephone number";
    $response_en['sex'] = "Gender";
    $response_en['email'] = "Email";
    $response_en['password'] = "Password";
    $response_en['member_business'] = "Type of business";
    $response_en['cellphone'] = "Mobile telephone number";



    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $response[$field] . ', ';
            $error_fields_en .= $response_en[$field] . ', ';
        }
    }
    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["res_code"] = "01";
        $response["res_text"] = 'กรุณากรอกข้อมูล ' . substr($error_fields, 0, -2) . ' ให้ครบถ้วน';
        $response["res_text_en"] = 'Please fill in the form : ' . substr($error_fields_en, 0, -2);
        echoRespnse(200, $response);
        $app->stop();
    }
}


/*** แสดงผล json ***/
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}





$app->run();
?>
