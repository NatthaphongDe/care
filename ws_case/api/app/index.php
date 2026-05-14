<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//exec("chmod -R 777 ../../data/MemberImage");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, authorization');
require_once '../include/DbHandlerApp.php';
require_once '../include/PassHash.php';
require '../libs/Slim/Slim.php';


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



$app->post('/country', function() use ($app) {
    $db = new DbHandler();
    $result = $db->country();
    echoRespnse(200, $result);
});

$app->post('/product', function() use ($app) {
    $db = new DbHandler();
    $result = $db->product();
    echoRespnse(200, $result);
});

$app->post('/case_type', function() use ($app) {
    $db = new DbHandler();
    $result = $db->case_type();
    echoRespnse(200, $result);
});

$app->post('/case_list', function() use ($app) {
    $db = new DbHandler();
    $result = $db->case_list();
    echoRespnse(200, $result);
});

$app->post('/num_case', function() use ($app) {
    $db = new DbHandler();
    $result = $db->num_case();
    echoRespnse(200, $result);
});

$app->post('/case_close', function() use ($app) {
    $db = new DbHandler();
    $result = $db->case_close();
    echoRespnse(200, $result);
});

$app->post('/complnt_country', function() use ($app) {
    $db = new DbHandler();
    $result = $db->complnt_country();
    echoRespnse(200, $result);
});

/*** แสดงผล json ***/
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

$app->run();