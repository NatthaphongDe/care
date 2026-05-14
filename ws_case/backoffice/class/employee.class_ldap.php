<?php
class member_base extends main{
  var $db;
  var $dbConn;
  var $member;
  var $pageId;
  var $file_accept_img;

  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->member = "";
    $this->file_accept_img = array("jpg","jpeg","png");

    $this->pageId = $this->page_list();
  }
  public function page_list(){
    $sql = "SELECT *
            FROM `Page` ";
    $query = $this->dbConn->query($sql);
    $page_read = array();
    $page_write = array();
    $page_enable = array();
    while($rs_page  =$query->fetch_assoc()){
      if($rs_page["page_permission"]==1){
        $page_read[$rs_page["page_id"]] = $rs_page["page_param_read"];
      }else if($rs_page["page_permission"]==2){
        $page_write[$rs_page["page_id"]] = $rs_page["page_param_write"];
      }else if($rs_page["page_permission"]==3){
        $page_enable[$rs_page["page_id"]] = $rs_page["page_param_enable"];
      }
    }
    $page_all = array("page_read"=>$page_read, "page_write"=>$page_write, "page_enable"=>$page_enable);
    return $page_all;
  }


  public function login($username,$password){
    $username = trim($username);
    $password = $_POST["password"];
    $password_hash = hash("sha256",$password);
    $sql = "SELECT *, emp.office_id AS office_id_1
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    LEFT JOIN Department AS Dep ON ( emp.dept_id = Dep.dept_id )
    WHERE emp.emp_email='$username'
    AND emp.emp_status='0'
    AND empGp.empGroup_status='0'
    AND empGp.empGroup_enable='1'";

    $query = $this->dbConn->query($sql);
    $rows_mem = $query->num_rows;
    if($rows_mem>0){
      $rs_mem = $query->fetch_assoc();

      if($rs_mem['empGroup_id']==6 && $rs_mem['login_ldap']==0 ){

      if($rs_mem["password"]!=$password_hash){
        $this->saveLogLogin(2,$username,$password);
        return false;
      }else{
        $this->saveLogLogin(1,$username,$password);
        $_SESSION["admin"]["empId"]         = $rs_mem["emp_id"];
        $_SESSION["admin"]["empFirstname"]  = $rs_mem["emp_firstname"];
        $_SESSION["admin"]["empLastname"]   = $rs_mem["emp_lastname"];
        $_SESSION["admin"]["empPosition"]   = $rs_mem["empGroup_id"];
        $_SESSION["admin"]["empSection"]    = $rs_mem["empGroup_section"];
        $_SESSION["admin"]["empLv"]         = $rs_mem["empGroup_level"];
        $_SESSION["admin"]["office"]        = $rs_mem["office_id_1"];
        $_SESSION["admin"]["dept"]          = $rs_mem["dept_id"];
        $_SESSION["admin"]["country"]    = $rs_mem["country_id"];
        return true;
      }


    }else if($rs_mem["emp_enable_sys_login"]==0){
        if($this->checkLoginByWebService($username,$password)[0]=="00"){
          $this->saveLogLogin(1,$username,$password);
          $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
          $_SESSION["admin"]["empFirstname"] = $rs_mem["emp_firstname"];
          $_SESSION["admin"]["empLastname"] = $rs_mem["emp_lastname"];
          $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
          $_SESSION["admin"]["empSection"] = $rs_mem["empGroup_section"];
          $_SESSION["admin"]["empLv"] = $rs_mem["empGroup_level"];
          $_SESSION["admin"]["office"] = $rs_mem["office_id_1"];

          return true;
        }else{
          $this->saveLogLogin(2,$username,$password);
          return false;
        }
      }else{
        if($rs_mem["password"]!=$password_hash){
          $this->saveLogLogin(2,$username,$password);
          return false;
        }else{
          $this->saveLogLogin(1,$username,$password);
          $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
          $_SESSION["admin"]["empFirstname"] = $rs_mem["emp_firstname"];
          $_SESSION["admin"]["empLastname"] = $rs_mem["emp_lastname"];
          $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
          $_SESSION["admin"]["empSection"] = $rs_mem["empGroup_section"];
          $_SESSION["admin"]["empLv"] = $rs_mem["empGroup_level"];
          $_SESSION["admin"]["office"] = $rs_mem["office_id_1"];

          return true;
        }
      }
    }else{
      $this->saveLogLogin(2,$username,$password);
      return false;
    }

  }
  public function saveLogLogin($status,$username,$password){
    $username = $this->data_filter($username);
    $password = $this->data_filter($password);
    $status = $this->data_filter($status);
    $sql = "INSERT
              INTO
                `Log_Login_Employee`(
                  `log_username`,
                  `log_password`,
                  `log_status`,
                  `log_datetime`
                )
              VALUES(
                '$username',
                '$password',
                '$status',
                NOW()
              )";
    $query = $this->dbConn->query($sql);
  }

  public function checkLoginByWebService($username,$password){
    //include('../api/ditp_extapi.php');
    //-- เรียกผ่าน LDAP --//
    //"ibusiness@ditp.go.th","Subsange123"
     $auth = authLdapDitp($username,$password);
     return $auth;
    //-- ใช้ชั่วคราว --//
    //return "00";

  }
  public function checkPrivilege($sectionGroup,$page){
    $pageId = null;
    foreach ($this->pageId["page_read"] as $key => $value) {
      $page_list = explode(",",$value);
      if(in_array($page,$page_list)){
        $pageId = $key;
      }
    }
    if($pageId==null){
      foreach ($this->pageId["page_write"] as $key => $value) {
        $page_list = explode(",",$value);
        if(in_array($page,$page_list)){
          $pageId = $key;
        }
      }
    }
    if($pageId==null){
      foreach ($this->pageId["page_enable"] as $key => $value) {
        $page_list = explode(",",$value);
        if(in_array($page,$page_list)){
          $pageId = $key;
        }
      }
    }

    $sql = "SELECT *
            FROM `Employee_Group_Permission` gp
            LEFT JOIN `Page` p ON (gp.page_id=p.page_id)
            WHERE gp.page_id='$pageId'
            AND gp.empGroup_id='$sectionGroup' ";
    $query = $this->dbConn->query($sql);
    $num_rows = $query->num_rows;
    $privilege = array();
    if($num_rows>0){
      while($rs_access = $query->fetch_assoc()){
        $privilege[$rs_access["page_permission"]] = 1;
      }
    }else{

    }
    return $privilege;
  }
  public function checkLoginSession(){
    if($_SESSION["admin"]!=""){
        return true;
    }else{
      return false;
    }
  }

  public function login_ws($username,$password){
    $username = trim($username);
    $password = $_POST["password"];
    $password_hash = hash("sha256",$_POST["password"]);
    $sql = "SELECT *
    FROM Employee emp
    INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
    WHERE emp.emp_email='$username'
    AND emp.emp_status='0'
    AND empGp.empGroup_status='0'
    AND empGp.empGroup_enable='1'";

    $query = $this->dbConn->query($sql);
    $rows_mem = $query->num_rows;
    if($rows_mem>0){
      $rs_mem = $query->fetch_assoc();
      if($rs_mem["emp_enable_sys_login"]==0){
        if($this->checkLoginByWebService($username,$password)[0]=="00"){
          return true;
        }else{
          return false;
        }
      }else{
        if($rs_mem["password"]!=$password_hash){
          return false;
        }else{
          return true;
        }
      }
    }else{
      return false;
    }

  }

}
?>
