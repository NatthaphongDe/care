<?php
class webservice_base extends main{
  var $db;
  var $dbConn;
  var $type_ditp;
  var $status_ditp;
  var $status_dbd;
  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->status_ditp = "01";
    $this->status_dbd = "01";
    //  require_once "class/nusoap-0.9.5/lib/nusoap.php";
    //  $client = new nusoap_client("http://backoff.ditp.go.th/webservice/index/member", true);
    //  $error  = $client->getError();
  }

  public function check_webservice_people($textId){
    $people_info = array(
      "status"=>"00",
      "id"=>"3-21312-3131-322",
      "firstname"=>"นางวิภา",
      "lastname"=>"ทองนิ่ม",
      "lastname"=>"เหล่าประภัสสร",
      "gender"=>"หญิง",
      "bday"=>"12 มกราคม 2520",
      "address"=>"2 ซ.ธนาคารกรุงเทพ ถ.เสือป่า แขวงป้อมปราบ เขตป้อมปราบ กรุงเทพฯ 10122"
    );

    if($people_info["gender"]=="หญิง"){
      $people_info["gender_i"] = "f";
    }else{
      $people_info["gender_i"] = "m";
    }

    $people_info_res = $this->showBfWebservicePeople($people_info);
    return $people_info_res;
  }

  public function check_webservice_blacklist($text){
    include("class/case.class.php");
    $caseDtl_cls = new case_detail();

    $blacklist_info_res = $caseDtl_cls->blacklistInfo($text);

    // print_r($blacklist_info_res);

    if($text != '') {
      if($blacklist_info_res) {
        $blacklist_info = array(
          // "complnt_trade_number"=>$blacklist_info_res["cpr_numbertrade"],
          // "complnt_name"=>$blacklist_info_res["cpr_companyname"],
          // "complnt_contact_name"=>$blacklist_info_res["cpr_contact_person"],
          // "complnt_contact_address"=>$blacklist_info_res["cpr_address"],
          // "reliable"=>$blacklist_info_res["reliable"],
          "status"=>"00"
        );

        $blacklist_info['result'] = $blacklist_info_res;

        $this->status_blacklist = "00";
      } else {
        $blacklist_info = array(
          "status"=>"01"
        );
        $this->status_blacklist = "01";
      }
    } else {
      $blacklist_info = array(
        "status"=>"02"
      );
      $this->status_blacklist = "02";
    }
    

    // print_r($blacklist_info);
    
    $blacklist_info_res = array(
      'show' => $this->showBfWebserviceBlacklist($blacklist_info),
      'data' => $blacklist_info,
    );
    return $blacklist_info_res;
  }

  public function check_webservice_dbd($textId){ //Ex: 0125550046368
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    if($textId!=""){
      $textId = str_replace("-","",$textId);
      $textId = $this->data_filter($textId);

      $keyFile = "ditp.key";
    $caFile = "ditp.ca";
    $certFile = "ditp.crt";
    // $textId = '0125550046368';
    
    $xml_data = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.wsdata.dbd.gov/">
                  <soapenv:Header/>
                  <soapenv:Body>
                    <ser:getData>
                        <!--Optional:-->
                        <subscriberId>6211005</subscriberId>
                        <!--Optional:-->
                        <subscriberPwd>$PSk3754</subscriberPwd>
                        <!--Optional:-->
                        <serviceId>0001</serviceId>
                        <!--Zero or more repetitions:-->
                        <params>
                          <!--Optional:-->
                          <name>JURISDICTION_ID</name>
                          <!--Optional:-->
                          <value>'.$textId.'</value>
                        </params>
                    </ser:getData>
                  </soapenv:Body>
                  </soapenv:Envelope>';


    $contentlength = strlen($xml_data);
    $URL = "https://ssodev.ditp.go.th/dbdws/";

    //$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService";
    // $URL = "https://dbdwsgwuatssl.dbd.go.th/dbdwsservice/GeneralService";
    $ch = curl_init($URL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    // this with CURLOPT_SSLKEYPASSWD
    curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);
    // // The --cacert option
    curl_setopt($ch, CURLOPT_CAINFO, $caFile);
    curl_setopt($ch, CURLOPT_CAPATH, '');
    // // The --cert option
    curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: text/xml'
      )
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    
    //  print_r($output);
    //  exit();
    $return = [];
    if ($output === false) {
      $content = curl_exec($ch);
      $err     = curl_errno($ch);
      $errmsg  = curl_error($ch);
      $header  = curl_getinfo($ch);
      curl_close($ch);

      $header['errno']   = $err;
      $header['errmsg']  = $errmsg;
      $header['content'] = $content;
    } else {
        $this->status_dbd = "00";
        curl_close($ch);
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//SBody')[0];
        $array = json_decode(json_encode((array) $body), TRUE);

        if (!empty($array['ns0getDataResponse']['return'])) {
          $data = $array['ns0getDataResponse']['return']['arrayRRow']['childTables'];
          $com = $array['ns0getDataResponse']['return']['arrayRRow']['columns'];
          
          if (!empty($com) && count($com)) {
            $com_arr = [];
            foreach($com as $item){
              $key = '';
              $val = '';
              foreach($item as $index => $val){
                if($index == 'columnName'){
                  $key = $val;
                }  else if($index == 'columnValue'){
                  $val = $val;
                }
              }
              $com_arr[$key] = $val;
            }

            $dbd_info = array(
              "status"=>"00",
              "id"=>$textId,
              "company_name"=>$com_arr["JURISTICNAME"],
              "regisday"=>substr($com_arr["REGISTERDATE"], 6, 2).'/'.substr($com_arr["REGISTERDATE"], 4, 2).'/'.substr($com_arr["REGISTERDATE"], 0, 4),
              "opening_status"=>$com_arr["JURISTICSTATUS"],
              "address"=>'',
              "province"=>''
            );
          }

          if (!empty($data[2]) && count($data[2]) & !empty($data[2]['rows'])) {
            $address = $data[2]['rows']['columns'];
            
            $address_arr = [];
            foreach($address as $item){
              $key = '';
              $val = '';
              foreach($item as $index => $val){
                if($index == 'columnName'){
                  $key = $val;
                }  else if($index == 'columnValue'){
                  $val = $val;
                }
              }
              $address_arr[$key] = $val;
            }
            $dbd_info['address'] = $address_arr['FULLADDRESS'].' '.$address_arr['JURISTICTUMBOL'].' '.$address_arr['JURISTICAMPUR'].' '.$address_arr['JURISTICPROVINCE'];
            $dbd_info['province'] = $address_arr['JURISTICPROVINCE'];
          }

        }

        // echo "<pre>" ;
        // print_r($dbd_info);
        // echo "</pre>" ;
        // exit;
    }

      // $dbd_info_res = getDBDReg($textId);
      // $date_regis = explode("+",$dbd_info_res[3]);
      // $date_regis = $dbd_info_res["registerDate"]." 00:00:00";
      // $date_regis = date("d / m / Y", strtotime('+543'.' year',strtotime($date_regis)));
      // if($dbd_info_res["res_code"]=="00"){
      //   $dbd_info = array(
      //     "status"=>"00",
      //     "id"=>$textId,
      //     "company_name"=>$dbd_info_res["juristicNameTh"],
      //     "regisday"=>$date_regis,
      //     "opening_status"=>$dbd_info_res["juristicStatus"],
      //     "address"=>$dbd_info_res["address"],
      //     "province"=>$dbd_info_res["juristicProvince"]
      //   );
      //   $this->status_dbd = "00";
      // }
      
    }else{
      $dbd_info = array(
        "status"=>"01"
      );
      $this->status_dbd = "01";
    }
    $dbd_info_res = array(
      'show' => $this->showBfWebserviceDBD($dbd_info),
      'data' => $dbd_info,
    );
    return $dbd_info_res;
  }

  public function check_webservice_ditp($textId){
    $textId = str_replace("-","",$textId);
    $textId = $this->data_filter($textId);
    if($textId!="" && $textId!="1111111111111"){

      $ditp_info_res = getDITPMember($textId);
      // print_r($ditp_info_res);
      if($ditp_info_res["res_code"]=="00"){
        $ditp_info = array(
          "status"=>"00",
          "id"=>$textId,
          "company_name"=>$ditp_info_res["juristicTypeNameTh"],
          "email"=>$ditp_info_res["email"],
          "address"=>$ditp_info_res["addressTh"],
          "province"=>$ditp_info_res["provinceName"],
          "postcode"=>$ditp_info_res["postCode"],
          "telephone"=>join("-",explode(" ",trim($ditp_info_res["telephone"]))),
          "fax"=>join("-",explode(" ",trim($ditp_info_res["fax"]))),
          "ditp_type"=>$ditp_info_res["memberType"],
          "memberNo"=>$ditp_info_res["MemberNo"]
        );
        $this->status_ditp = "00";
      }else{
        $ditp_info = array(
          "status"=>"01"
        );
        $this->status_ditp = "01";
      }
    }else{
      $ditp_info = array(
        "status"=>"01"
      );
      $this->status_ditp = "01";
    }
    // print_r($ditp_info);
    $ditp_info_res = $this->showBfWebserviceDITP($ditp_info);
    return $ditp_info_res;
  }

  public function showBfWebservicePeople($people_info){
    $html_res = "";
    if($people_info["status"]=="00"){
      $html_res = '<div class="col-md-12">
        <label class="col-sm-4 control-label">ชื่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_firstname">'.$people_info["firstname"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">นามสกุล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_lastname">'.$people_info["lastname"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">เพศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$people_info["gender"].'</label>
          <label id="res_gender" id="res_gender" style="display:none">'.$people_info["gender_i"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_bday">'.$people_info["bday"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_address">'.$people_info["address"].'</label>
        </div>
      </div>';
    }else{
      $html_res = '<div class="col-md-12">
        <div class="col-sm-12">
          <label class="text-data text-data-green">ไม่มีข้อมูลจากเลขบัตรประชาชนที่ท่านตรวจสอบ</label>
        </div>
      </div>';
    }
    return $html_res;
  }

  public function showBfWebserviceDITP($ditp_info){

    // <div class="col-md-12">
    //   <label class="col-sm-4 control-label">วันที่จดทะเบียน</label>
    //   <div class="col-sm-8">
    //     <label class="text-data text-data-green" id="res_regisday">'.$ditp_info["regisday"].'</label>
    //   </div>
    // </div>
    /*     <div class="col-md-12">
    <label class="col-sm-4 control-label">เบอร์แฟกซ์</label>
    <div class="col-sm-8">
      <label class="text-data text-data-green" id="res_fax">'.$ditp_info["fax"].'</label>
    </div>
    </div> */
    include("class/case.class.php");
    $caseDtl_cls = new case_detail();
    $html_res = "";
    if($ditp_info["status"]=="00"){
      $html_res = '<div class="col-md-12">
        <label class="col-sm-4 control-label">ชื่อบริษัทหรือองค์กร</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_company_name">'.$ditp_info["company_name"].'</label>
        </div>
      </div>
      
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_address">'.$ditp_info["address"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_province">'.$ditp_info["province"].'</label>
          <input type="hidden"  id="res_province_id" value="'.$caseDtl_cls->provinceSearchByData($ditp_info["province"],'prov_name')["prov_id"].'" />
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">รหัสไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_postcode">'.$ditp_info["postcode"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_telephone">'.$ditp_info["telephone"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ประเภทสมาชิกกรม</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_ditp_type">'.$ditp_info["ditp_type"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">เลขที่สมาชิกกรม</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_memberNo">'.($ditp_info["memberNo"]!=""?$ditp_info["memberNo"]:"-").'</label>
        </div>
      </div>
      <input type="hidden" id="ditp_type" value="'.strtolower($ditp_info["ditp_type"]).'" />
      <input type="hidden" id="ditp_memberNo" value="'.$ditp_info["memberNo"].'" />';
    }else{
      $html_res = '<div class="col-md-12">
        <div class="col-sm-12">
          <label class="text-data text-data-green">ไม่มีข้อมูลจากฐานข้อมูล DITP ที่ท่านตรวจสอบ</label>
        </div>
      </div>';
    }
    return $html_res;
  }

  public function showBfWebserviceDBD($dbd_info){
    include("class/case.class.php");
    $caseDtl_cls = new case_detail();
    $html_res = "";
    if($dbd_info["status"]=="00"){
      $html_res = '<div class="col-md-12">
        <label class="col-sm-4 control-label">ชื่อบริษัทหรือองค์กร</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_company_name">'.$dbd_info["company_name"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">วันที่จดทะเบียน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_regisday">'.$dbd_info["regisday"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_address">'.$dbd_info["address"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_province">'.$dbd_info["province"].'</label>
          <input type="hidden"  id="res_province_id" value="'.$caseDtl_cls->provinceSearchByData($dbd_info["province"],'prov_name')["prov_id"].'" />
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">สถานะการดำเนินการ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_opening_status">'.$dbd_info["opening_status"].'</label>
        </div>
      </div>';
    }else{
      $html_res = '<div class="col-md-12">
        <div class="col-sm-12">
          <label class="text-data text-data-green">ไม่มีข้อมูลจากฐานข้อมูล DBD ที่ท่านตรวจสอบ</label>
        </div>
      </div>';
    }
    return $html_res;
  }


  public function showBfWebserviceBlacklist($blacklist_info){
    include("class/case.class.php");
    $caseDtl_cls = new case_detail();
    // print_r($blacklist_info);
    // print_r($blacklist_case);
    $html_res = "";
    if($blacklist_info["status"]=="00"){

      foreach($blacklist_info["result"] AS $blacklist) {
        
        $html_res .= '<div class="col-md-12 panel-body-bg2 no-gutter">
        <div class="col-md-1"><input type="radio" id="comp'.$blacklist["cpr_id"].'" name="complnt_checked[]" value="'.$blacklist["cpr_id"].'"></div>
        <label class="col-md-11" for="comp'.$blacklist["cpr_id"].'">
        <div class="blacklist_info_inner no-gutter"><div class="col-md-12">
        <label class="col-sm-4 control-label">ชื่อบริษัทหรือองค์กร</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_company_name">'.$blacklist["complnt_name"].'</label>
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_reliable">'.($blacklist["complnt_trade_number"]!=""?$blacklist["complnt_trade_number"]:"-").'</label> 
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ชื่อที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_reliable">'.($blacklist["complnt_contact_name"]!=""?$blacklist["complnt_contact_name"]:"-").'</label> 
        </div>
      </div>
      <div class="col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_reliable">'.$blacklist["complnt_contact_address"].'</label> 
        </div>
      </div>';

      $blacklist_rel = $caseDtl_cls->blacklistReliable($blacklist["complnt_trade_number"], $blacklist["complnt_name"]);
      // print_r($blacklist_rel);
      if($blacklist_rel["reliable"] == 1) {
        $reliable = 'Watchlist';
      } else if($blacklist_rel["reliable"] == 2) {
        $reliable = 'Blacklist';
      } else {
        $reliable = 'ไม่มีสถานะ';
      }
      $html_res .= '<div class="col-md-12">
        <label class="col-sm-4 control-label">สถานะบริษัท</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green" id="res_reliable">'.$reliable.'</label> 
        </div>
      </div>
      <input type="hidden" class="reliable" id="reliable'.$blacklist["cpr_id"].'" value="'.$reliable.'" />';


      $blacklist_case = $caseDtl_cls->blacklistCase($blacklist["complnt_trade_number"], $blacklist["complnt_name"]);
      if($blacklist_case != '') {
        $html_res .= '<div class="col-md-12" style="margin-top: 20px;">
        <table class="tableCase">
          <tr>
            <th style="width:25%; text-align:center;">เลขที่เคส</th>
            <th style="width:50%">หัวข้อเรื่อง</th>
            <th style="width:25%">สถานะบริษัท</th>
          </tr>';
        foreach($blacklist_case as $case) {
          // print_r($case['case_id']);
          $reliable = '';
          if($case["reliable"] == 1) {
            $reliable = 'Watchlist';
          } else if($case["reliable"] == 2) {
            $reliable = 'Blacklist';
          } else {
            $reliable = 'ไม่มีสถานะ';
          }
          $html_res .= '<tr>
            <td style="width:25%; text-align:center;">'.$case['case_id'].'</td>
            <td style="width:50%">'.$case['caseDtl_title'].'</td>
            <td style="width:25%; text-align:center;"> '.$reliable.'</td>
          </tr>';
        }
        $html_res .= '</table></div>';
      }

      $html_res .= '</div></label></div>';

      
      }
    }else if($blacklist_info["status"]=="01") {
      $html_res = '<div class="col-md-12">
        <div class="col-sm-12">
          <label class="text-data text-data-green">ไม่มีข้อมูลจากฐานข้อมูล Blacklist ที่ท่านตรวจสอบ</label>
        </div>
      </div>';
    }
    return $html_res;
  }
}
?>
