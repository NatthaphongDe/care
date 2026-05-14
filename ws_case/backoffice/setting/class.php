<?php


class ClassBackofficce
{
  public function __construct()
  {
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
  }
  public function getofficetype(){
    $office_type_array = array();
    $sql = "SELECT * FROM `office_type` WHERE `office_status` = 1 AND office_id != 0 ORDER BY `office_id`  ASC";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){

      $office["office_id"] = $result["office_id"];
      $office["office_name"] = $result["office_name"];
      $office["office_status"] = $result["office_status"];
      array_push($office_type_array,$office);
    }
    return $office_type_array;
  }
}

?>
