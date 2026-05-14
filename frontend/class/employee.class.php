<?php
class member_base extends main{
  var $db;
  var $dbConn;
  var $member;

  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->member = "";
  }


  public function login($username,$password){
    $username = trim($username);
    $sql = "SELECT emp.emp_id,emp.emp_real_id,emp.empGroup_id,empGp.empGroup_section
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    WHERE emp.emp_email='$username'
    AND emp.password='$password'
    AND emp.emp_status='0'
    AND empGp.empGroup_section!='0' ";
    $query = $this->dbConn->query($sql);
    $rows_mem = $query->num_rows;
    if($rows_mem>0){
      if($this->checkLoginByWebService($username)==true){
        $rs_mem = $query->fetch_assoc();
        $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
        $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
        $_SESSION["admin"]["empSection"] = $rs_mem["empGroup_section"];
        /*$datetime_login = date('Y-m-d H:i:s');
        $pin_login = sprintf("%04d",rand(1000,9999));
        $empRId = hash("sha256",$rs_mem["emp_real_id"]."-".strtotime($datetime_login).$pin_login);
        setcookie('empRId', $empRId, time() + 86400, "/backoffice"); // 86400 = 1 day
        $sql_udp = "UPDATE Employee SET emp_last_login_datetime='$datetime_login' ,emp_login_pin='$pin_login' ,emp_login_token='$empRId'  WHERE emp_id='".$rs_mem["emp_id"]."' ";
        $query_udp = $this->dbConn->query($sql_udp);*/

        return true;
      }
    }else{
      return false;
    }

  }

  public function checkLoginByWebService($username){
    return true;
  }

  public function checkLoginSession(){
    if($_SESSION["admin"]!=""){
        // $sql = "SELECT emp_id,emp_real_id,empGroup_id FROM Employee WHERE emp_login_token='".$_COOKIE["empRId"]."' AND emp_status='0' ";
        // $query = $this->dbConn->query($sql);
        // $rows_mem = $query->num_rows;
        // if($rows_mem>0){
        //   $rs_mem = $query->fetch_assoc();
        //   if($this->checkLoginByWebService($rs_mem["username"])==true){
        //     $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
        //     $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
        //
        //     return true;
        //   }
        // }else{
        //     return false;
        // }
        return true;
    }else{
      return false;
    }
  }


  public function emp_list_assign(){
    $emp_list_arr = array();
    $sql = "SELECT *
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    WHERE emp.emp_status='0' AND empGp.empGroup_level!='1' AND empGp.empGroup_section='".$_SESSION["admin"]["empSection"]."' AND emp.emp_id!='".$_SESSION["admin"]["empId"]."' ";
    $query = $this->dbConn->query($sql);
    while($rs_mem = $query->fetch_assoc()){
      $rs_mem_arr = array();
      $rs_mem_arr["data"] = $rs_mem["emp_id"];
      $rs_mem_arr["value"] = $rs_mem["emp_real_id"]." - ".$rs_mem["emp_firstname"]." ".$rs_mem["emp_lastname"];
      array_push($emp_list_arr,$rs_mem_arr);
      //array_push($emp_list_arr,$rs_mem["emp_real_id"]);
    }
    return $emp_list_arr;
  }


    public function emp_get_detail($empId){
      $emp_list_arr = array();
      $sql = "SELECT * FROM Employee WHERE emp_id='$empId' AND emp_status='0' ";
      $query = $this->dbConn->query($sql);
      $rs_mem = $query->fetch_assoc();
      $emp_list_arr = $rs_mem;
      return $emp_list_arr;
    }
}



/*class login extends member_base{

  public function __construct(){
      parent::__construct();

  }


}*/
?>
