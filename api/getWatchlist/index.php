<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once 'DbHandler.php';
require_once 'PassHash.php';
require '.././libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$user_id = NULL;



/***  ***
 * url - /watchlist
 * method - post
 */
$app->post('/data2', function() use ($app) {

    // ?offset=0&limit=2
    $limit = $app->request->post('limit');
    $offset = $app->request->post('offset');

    $response = array();
   
     $db = new DbHandler();
    // print_r( $db);
    // die();
    $result = $db->getWatchlist2($limit,$offset);


    if ($result != NULL) {
        $response["res_code"] = "00";
        $response["numrow"] =$result->num_rows;
        $response["res_text"] = "แสดงข้อมูลสำเร็จ";
        $response["res_result"] = array();

        $tmp = array();
        $feild = array();
        $i = 1;
        // print_r($i);
        // die();
        while ($res = $result->fetch_assoc()) {
            if($res['case_id'] == $i){
          
                // $feild[$res['fieldset_name']] = array();
                   $feild[$res['fieldset_name']] = $res['fieldset_value'];
             
            }else{
                $tmp[$res['case_id']] = array();
                 array_push($tmp[$res['case_id']], $feild);
                $i++;
            }
            // array_push($tmp, $i);
        
          
        }
    //     print_r( $tmp);
    //    die();
        array_push($response["res_result"],$tmp);  
        echoRespnse(200, $response);
    } else {
        $response["res_code"] = "01";
        $response["res_text"] = "ไม่พบข้อมูล";
        echoRespnse(200, $response);
    }
    // echoRespnse(200, $response);
});

$app->post('/dataid', function() use ($app) {

    // ?offset=0&limit=2
    $id = $app->request->post('id');
    // $offset = $app->request->post('offset');
    $response = array();
   
    if($id != NULL || !isset($id) || $id != ''){


   
     $db = new DbHandler();
    // print_r( $db);
    // die();
    $result = $db->getWatchlistByID($id);


    if ($result != NULL) {
        $response["res_code"] = "00";
        $response["numrow"] =$result->num_rows;
        $response["res_text"] = "แสดงข้อมูลสำเร็จ";
        $response["res_result"] = array();

        $tmp = array();
        $feild = array();
        $i = 1;
        // print_r($i);
        // die();
        while ($res = $result->fetch_assoc()) {
   
      
                 array_push($tmp, $res);
     
    
        
          
        }
    //     print_r( $tmp);
    //    die();
        array_push($response["res_result"],$tmp);  
        echoRespnse(200, $response);
    } else {
        $response["res_code"] = "01";
        $response["res_text"] = "ไม่พบข้อมูล";
        echoRespnse(200, $response);
    }
}else{
    $response["res_code"] = "02";
    $response["res_text"] = "กรุณาระบุเลขนิติบุคคล";
    echoRespnse(200, $response);
}
    // echoRespnse(200, $response);
});

$app->post('/data', function() use ($app) {

    // ?offset=0&limit=2
    $limit = $app->request->post('limit');
    $offset = $app->request->post('offset');

    $response = array();
   
     $db = new DbHandler();
    // print_r( $db);
    // die();
    $result = $db->getWatchlist($limit,$offset);


    if ($result != NULL) {
        $response["res_code"] = "00";
        $response["numrow"] =$result->num_rows;
        $response["res_text"] = "แสดงข้อมูลสำเร็จ";
        $response["res_result"] = array();

        $tmp = array();
        $feild = array();
        $i = 1;
        // print_r($i);
        // die();
        while ($res = $result->fetch_assoc()) {
   
      
                 array_push($tmp, $res);
     
    
        
          
        }
    //     print_r( $tmp);
    //    die();
        array_push($response["res_result"],$tmp);  
        echoRespnse(200, $response);
    } else {
        $response["res_code"] = "01";
        $response["res_text"] = "ไม่พบข้อมูล";
        echoRespnse(200, $response);
    }
    // echoRespnse(200, $response);
});



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



/*** แสดงผล json ***/
function echoRespnse($status_code, $response) {
$app = \Slim\Slim::getInstance();
$app->status($status_code);
$app->contentType('application/json');
echo json_encode($response);
}

$app->run();

?>