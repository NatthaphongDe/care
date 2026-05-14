<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $keyFile = "ditp.key";
    $caFile = "ditp.ca";
    $certFile = "ditp.crt";
    $textId = '0125550046368';
    
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
              "opening_status"=>substr($com_arr["REGISTERDATE"], 6, 2).'/'.substr($com_arr["REGISTERDATE"], 4, 2).'/'.substr($com_arr["REGISTERDATE"], 0, 4),
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

        echo "<pre>" ;
        print_r($dbd_info);
        echo "</pre>" ;
        exit;
    }

        // echo "<pre>";
        // print_r($array['ns0getDataResponse']['return']['arrayRRow']);
        // echo "</pre>";
        // exit();
    // }