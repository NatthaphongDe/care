<?php

// error_reporting(0);
// ini_set('display_errors', -1);

//$base_url="http://backend.hfc.co.th"; //url base of site

date_default_timezone_set("Asia/Bangkok");

//$udb = 'root';
//$pdb = '1234';
//$db_name = 'DITP';

$udb = 'ditpcare';
$pdb = 'ibizcare';
$db_name = 'ditpcare';

$db_host = '10.8.99.39';
$db_type = 'mysql';
$prefix = "";
$key = 'ibusiness2ditp';
$key_str = "&key=".$key;


//ldap
$ldap_uri = "ldap://10.8.99.17";

//conection:
//$con= mysql_connect($db_host,$udb,$pdb,$db_name) or die("Error: " . mysql_error());

//mysql_query($con, "SET NAME UTF8");
//mysql_set_charset($con, "utf8");
//mysql_query("USE $db_name");
//mysql_query("SET NAMES UTF8");

$conn = new mysqli($db_host,$udb,$pdb,$db_name);
$conn->set_charset('utf8');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$expire=time()+60*60*24;
?>
