<?


function getDBDReg($id_val){

$xml_data = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Juristic xmlns="http://appselect.ditp.go.th/soap/juristicDBD">
            <JuristicId>'.$id_val.'</JuristicId>
            <User>ditp_dbd_1</User>
            <Password>dbd724</Password>
        </Juristic>
    </Body>
</Envelope>';


$contentlength = strlen($xml_data);
// return $xml_data;
$URL = "http://appselect.ditp.go.th/Webservice/WebServiceDBD.php?wsdl";
$ch = curl_init($URL);
// curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,
array(
  'POST HTTP/1.0',
  'Content-Type: text/xml',
  'Content-length: '.$contentlength,
  'Content-transfer-encoding: text; charset=UTF-8'
));
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data."");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);


  $output = curl_exec($ch);
  
  curl_close($ch);

  // print_r($output);
  // exit;
  // return $output;

  $doc = new DOMDocument();
  $doc->loadXML($output);
 
  $ret=$doc->getElementsByTagName('ResCode')->item(0)->nodeValue;
  if ($ret=="0"){
    $address = $doc->getElementsByTagName('juristicAddressNo')->item(0)->nodeValue ;
    $address .= " หมู่".$doc->getElementsByTagName('juristicMoo')->item(0)->nodeValue;
    $address .= " ".$doc->getElementsByTagName('juristicTumbol')->item(0)->nodeValue;
    $address .= " ".$doc->getElementsByTagName('juristicAmpur')->item(0)->nodeValue;
    $retarr=array("res_code"=>"00",
                  "juristicStatus"=>$doc->getElementsByTagName('juristicStatus')->item(0)->nodeValue,
                  "juristicNameTh"=>$doc->getElementsByTagName('juristicNameTh')->item(0)->nodeValue,
                  "registerDate"=>$doc->getElementsByTagName('registerDate')->item(0)->nodeValue,
                  "address"=>$address,
                  "juristicProvince"=>$doc->getElementsByTagName('juristicProvince')->item(0)->nodeValue
                );
    return $retarr;
  }else{
    $retarr=array("01","NOT FOUND");
    return $retarr;
  }
}





function getDITPMember($id_val){
  $userId="ditp@mobile";
  $xml_data = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                <Body>
                    <MemberInfoByTaxID xmlns="http://backoff.ditp.go.th/webservice/index/member">
                        <userId>'.$userId.'</userId>
                        <taxId>'.$id_val.'</taxId>
                    </MemberInfoByTaxID>
                </Body>
            </Envelope>';

  // $contentlength = strlen($xml_data);
  // // $URL = "http://backoff.ditp.go.th/webservice/index/member";
  // $URL = "http://driveapi.ditp.go.th/api/UserProfile?token=46c6f9c9-b624-4ce4-969b-8c56e136314c&userid=".$id_val;
  // $ch = curl_init($URL);
  // // curl_setopt($ch, CURLOPT_MUTE, 1);
  // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  // curl_setopt($ch, CURLOPT_POST, 1);
  // curl_setopt($ch, CURLOPT_HTTPHEADER,
  // array('POST HTTP/1.0',
  // 'Content-Type: text/xml','Content-length: '.strlen($xml_data),'Content-transfer-encoding: text; charset=UTF-8'
  // ));
  // curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // $output = curl_exec($ch);
  // curl_close($ch);

  // $doc = new DOMDocument();
  // $doc->loadXML($output);

  // $url = "http://driveapi.ditp.go.th/api/UserProfile?token=46c6f9c9-b624-4ce4-969b-8c56e136314c&userid=0125550046368";
  $url = "https://driveapi.ditp.go.th/api/UserProfile?token=46c6f9c9-b624-4ce4-969b-8c56e136314c&userid=".$id_val;

  $curl = curl_init($url);
  // curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  //for debug only!
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  $resp = curl_exec($curl);
  curl_close($curl);

  $resp = json_decode($resp);

  // echo '<pre>';
  // print_r($resp);
  // echo '</pre>';
  // exit;
  if($resp->code == 200){
    $retarr=array(
      "res_code"=>"00",
      "memberCode"=>$resp->TaxID,
      "juristicTypeNameTh"=>$resp->CorporateNameTH,
      "email"=>$resp->Mail,
      "memberType"=>$resp->MemberType,
      "addressTh"=>$resp->User_Address->AddressTH.' '.$resp->User_Address->SubDistrict->name.' '.$resp->User_Address->District->name.' '.$resp->User_Address->Province->name,
      "provinceName"=>$resp->User_Address->Province->name,
      "postCode"=>$resp->User_Address->PostCode,
      "telephone"=>$resp->Tel,
      "fax"=>$resp->Fax,
      "MemberNo"=>$resp->MemberNo,
    );
    return $retarr;
  } else{
    $retarr=array("01","NOT FOUND");
    return $retarr;
  }

  $ret=$doc->getElementsByTagName('memberCode')->item(0)->nodeValue;
  
  if ($ret>0){
    $retarr=array(
      "res_code"=>"00",
      "memberCode"=>$doc->getElementsByTagName('memberCode')->item(0)->nodeValue,
      "juristicTypeNameTh"=>$doc->getElementsByTagName('juristicTypeNameTh')->item(0)->nodeValue." ".$doc->getElementsByTagName('juristicNameTh')->item(0)->nodeValue,
      "email"=>$doc->getElementsByTagName('email')->item(0)->nodeValue,
      "memberType"=>$doc->getElementsByTagName('memberType')->item(0)->nodeValue,
      "addressTh"=>$doc->getElementsByTagName('addressTh')->item(0)->nodeValue." ".$doc->getElementsByTagName('districtNmae')->item(0)->nodeValue,
      "provinceName"=>$doc->getElementsByTagName('provinceName')->item(0)->nodeValue,
      "postCode"=>$doc->getElementsByTagName('postCode')->item(0)->nodeValue,
      "telephone"=>$doc->getElementsByTagName('telephone')->item(0)->nodeValue,
      "fax"=>$doc->getElementsByTagName('fax')->item(0)->nodeValue,

    );
    return $retarr;
  }else{
    $retarr=array("01","NOT FOUND");
    return $retarr;
  }

}

function authLdapDitp($username,$password){

  global $ldap_uri;

  $ds = ldap_connect($ldap_uri) or die('Could not connect to LDAP server.');

  $r=ldap_bind($ds);    // this is an "anonymous" bind, typically
                          // read-only access
  $sr=ldap_search($ds, "ou=mail,dc=linux,dc=co,dc=th", "mail=".$username);
  $info = ldap_get_entries($ds, $sr);

     if ($info["count"]>0){
       $dn=$info[0]["dn"];
       $cn=$info[0]["cn"][0];
       $sn=$info[0]["sn"][0];

       $ldapbind = ldap_bind($ds, $dn, $password);

       // verify binding
       if ($ldapbind) {
          // echo "LDAP bind successful...";
          $ret=array("00",$cn." ".$sn);
       } else {
           //echo "LDAP bind failed...";
           $ret=array("01","Login Fail");
       }

     }
     ldap_close($ds);
     return $ret;
}




// api1
// ค้นหาว่า บริษัทนี้ มีอยู่ในไทย หรือไม่ และ ยังดำเนินการอยู่หรือป่าว
// array[0]=00 คือเจอ
// array[1]=ยังดำเนินกิจการอยู่      <== หาแค่นี้พอ
//print_r( getDBDReg("0125550046368"));



// api2
// authen user / pass ของ พนักงาน ditp
// array[0]=00 <== กรณีผ่าน ถ้าไม่ผ่านจะ 01
// array[1]=ชื่อ นามสกุล
//print_r(authLdapDitp("ibusiness@ditp.go.th","Subsange123"));



?>
