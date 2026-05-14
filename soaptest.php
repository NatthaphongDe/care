<?php

// echo file_get_contents('../ssl/www.ca');
// exit;
 
$keyFile = realpath("../ssl/www.key");
$caFile = realpath("../ssl/www.ca");
$certFile = realpath("../ssl/www.crt");
// echo "<pre>" ;
// print_r(file_get_contents($keyFile));
// echo "</pre>" ;
// exit();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$id_val = '';
$xml_data = '<soapenv:Envelope   xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
<soapenv:Header/>
   <soapenv:Body>
    <ser:gerData>
     <subscriberId>6211005</subscriberId>
     <subscriberPwd>$PSk3754</subscriberPwd>
     <serviceId>0001</serviceId>
     <params>
     <name>JURISDICTION_ID</name>
     <value>0125550046368</value>
     </params>
    </ser:gerData>
   </soapenv:Body>
   </soapenv:Envelope>';


$contentlength = strlen($xml_data);
$URL = "https://dbdwsgw.dbd.go.th/dbdwsservice/GeneralService?wsdl";
$ch = curl_init($URL);

// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_VERBOSE, true);
// this with CURLOPT_SSLKEYPASSWD
curl_setopt($ch, CURLOPT_SSLKEY, $keyFile);

// The --cacert option
curl_setopt($ch, CURLOPT_CAINFO, $caFile);

// The --cert option
curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'POST HTTP/1.0',
        'Content-Type: text/xml', 'Content-length: ' . strlen($xml_data), 'Content-transfer-encoding: text; charset=UTF-8'
    )
);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);

if ($output === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Operation completed without any errors';
}
curl_close($ch);


echo "<pre>";
print_r($output);
echo "</pre>";
exit();
