<?php
class case_base extends main{
  var $db;
  var $dbConn;
  var $admin_id;
  var $admin_firstname;
  var $admin_lastname;
  var $admin_position;
  var $admin_section;
  var $prod_type; //ประเภทสินค้า
  var $comp_type; //ประเภทเรื่องร้องเรียน
  var $priority_selct; //Priority
  var $case_status; //Status Case
  var $case_channal; //Channal Case
  var $case_country; //Country
  var $office; //office
  var $case_province; //Province
  var $case_currency; //Current
  var $file_accept;
  var $typeForm;
  var $processType;
  var $closeType;
  var $day_overdue_case;
  var $gender;


  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->admin_id = $_SESSION["admin"]["empId"];
    $this->admin_firstname = $_SESSION["admin"]["empFirstname"];
    $this->admin_lastname = $_SESSION["admin"]["empLastname"];
    $this->admin_position = $_SESSION["admin"]["empPosition"];
    $this->admin_section = $_SESSION["admin"]["empSection"];
    $this->admin_dept = $_SESSION["admin"]["dept"];
    $this->admin_country = $_SESSION["admin"]["country"];
    $this->prod_type = array();
    $this->comp_type = array();
    $this->priority_selct = array();
    $this->case_status = array();
    $this->case_currency = array();
    $this->processType = array();
    $this->closeType = array();
    $this->office = array();
    $this->file_accept = array("jpg","jpeg","png","doc","docx","xls","xlsx","ppt","pptx","pdf","zip","rar","txt");
    $this->typeForm = array('a','b','c');
    $this->day_overdue_case = 60;
    $this->gender = array("f"=>"หญิง","m"=>"ชาย");

  }

  // --ฟังก์ชั่นเรียกรายการประเภทสินค้า --//
  public function prodTypeList(){
    $prodTypeArrObj = array();
    $sql = "SELECT *
    FROM Product_Type
            WHERE prodType_level = 1
            AND prodType_status = 0
            AND prodType_enable = 1 ";
    $query = $this->dbConn->query($sql);
    $prod_num = $query->num_rows;
      while($result = $query->fetch_assoc()){
        //$prodArr[$result["prodType_id"]] = $result["prodType_name"];
        $prodArr["prodType_id"] = $result["prodType_id"];
        $prodArr["prodType_name"] = $result["prodType_name"];
        $prodArr["prodType_sublist"] = array();

        $sql_sub = "SELECT *
                    FROM Product_Type
                    WHERE prodType_ref_id = '".$result["prodType_id"]."'
                    AND prodType_level = 2
                    AND prodType_status = 0
                    AND prodType_enable = 1 ";
        $query_sub = $this->dbConn->query($sql_sub);
        while($result_sub = $query_sub->fetch_assoc()){
          $prodArr_sub = array();
          $prodArr_sub["prodType_id"] = $result_sub["prodType_id"];
          $prodArr_sub["prodType_name"] = $result_sub["prodType_name"];
          array_push($prodArr["prodType_sublist"],$prodArr_sub);
        }
        array_push($prodTypeArrObj,$prodArr);
      }
    return $prodTypeArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการประเภทสินค้า --//
  public function prodTypeListMutiLv($lv,$ref_id){
    $prodTypeArrObj = array();
    $office = "";
    if($_SESSION['admin']['office'] != 0){
      $office = " AND office_id = ".$_SESSION['admin']['office'];
    }
    $sql = "SELECT *
    FROM Product_Type
            WHERE prodType_level = '$lv'
            AND prodType_status = '0'
            AND prodType_enable = '1' ";
    if($lv == '2'){
      $sql .= $office ;
            }
    if($ref_id!=""){
      $sql .= " AND prodType_ref_id = '$ref_id' ";
    }
    $query = $this->dbConn->query($sql);
    $prod_num = $query->num_rows;
    $lv++;
      while($result = $query->fetch_assoc()){
        //$prodArr[$result["prodType_id"]] = $result["prodType_name"];
        $prodArr["prodType_id"] = $result["prodType_id"];
        $prodArr["prodType_name"] = $result["prodType_name"];
        $prodArr["prodType_other_flag"] = $result["prodType_other_flag"];

        $sql_sub = "SELECT *
                    FROM Product_Type
                    WHERE prodType_ref_id = '".$result["prodType_id"]."'
                    AND prodType_level = '$lv'
                    AND prodType_status = '0'
                    AND prodType_enable = '1' ";
        $query_sub = $this->dbConn->query($sql_sub);
        $num_sub = $query_sub->num_rows;
        $prodArr["prodType_sublist"] = $num_sub;
        array_push($prodTypeArrObj,$prodArr);
      }
    return $prodTypeArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการประเภทสินค้า --//
  public function prodTypeList_getData(){
    $prodTypeArrObj = array();
    $sql = "SELECT *
    FROM Product_Type
            WHERE prodType_status = 0
            AND prodType_enable = 1 ";
    $query = $this->dbConn->query($sql);
      while($result = $query->fetch_assoc()){
        //$prodArr[$result["prodType_id"]] = $result["prodType_name"];
        $prodArr["prodType_id"] = $result["prodType_id"];
        $prodArr["prodType_name"] = $result["prodType_name"];
        $prodArr["prodType_other_flag"] = $result["prodType_other_flag"];

        array_push($prodTypeArrObj,$prodArr);
      }
    return $prodTypeArrObj;
  }


  // --ฟังก์ชั่นเรียกรายการประเภทความผิด--//
  public function incorrectTypeList(){
    $incorrectTypeArrObj = array();
    $sql = "SELECT * FROM Incorrect_Type WHERE incType_status=0 AND incType_enable=1";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      //$prodArr[$result["incType_id"]] = $result["incType_name"];
      $incorrectArr["incType_id"] = $result["incType_id"];
      $incorrectArr["incType_name"] = $result["incType_name"];
      $incorrectArr["incType_other_flag"] = $result["incType_other_flag"];
      array_push($incorrectTypeArrObj,$incorrectArr);
    }
    return $incorrectTypeArrObj;
  }


  // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน --//
  public function compTypeList($type,$section){
    if($type!="all"){
      if($section!=0){
        $sql_extend = " AND compType_section='$section'";
      }
    }
    // --Complaint_Type -- //
    $compArrObj = array();
    $sql = "SELECT * FROM Complaint_Type WHERE compType_status='0' $sql_extend ORDER BY compType_order_sort ASC ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $compArr_list = array();
      $compType_id = $result["compType_id"];
      $compArr_list['compType_id'] = $compType_id;
      $compArr_list['compType_name'] = $result["compType_name"];
      $compArr_list['compType_other_flag'] = $result["compType_other_flag"];

      // --Complaint_Type_Sub1 -- //
      $sql_sub1 = "SELECT * FROM Complaint_Type_Sub1 WHERE compTypeSub1_status='0' AND compType_id='$compType_id' ";
      $query_sub1 = $this->dbConn->query($sql_sub1);
      $num_sub1 = $query_sub1->num_rows;
      if($num_sub1>0){
        $compArr_list['compTypeSub1_list'] = array();
        while($result_sub1 = $query_sub1->fetch_assoc()){
          $compArrSub1_list = array();
          $compTypeSub1_id = $result_sub1["compTypeSub1_id"];
          $compArrSub1_list['compTypeSub1_id'] = $compTypeSub1_id;
          $compArrSub1_list['compTypeSub1_name'] = $result_sub1["compTypeSub1_name"];

          // --Complaint_Type_Sub2 -- //
          $sql_sub2 = "SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub2_status='0' AND compTypeSub1_id='$compTypeSub1_id' ";
          $query_sub2 = $this->dbConn->query($sql_sub2);
          $num_sub2 = $query_sub2->num_rows;
          if($num_sub2>0){
            $compArrSub1_list['compTypeSub2_list'] = array();
            while($result_sub2 = $query_sub2->fetch_assoc()){
              $compArrSub2_list = array();
              $compTypeSub2_id = $result_sub2["compTypeSub2_id"];
              $compArrSub2_list['compTypeSub2_id'] = $compTypeSub2_id;
              $compArrSub2_list['compTypeSub2_name'] = $result_sub2["compTypeSub2_name"];
              array_push($compArrSub1_list['compTypeSub2_list'],$compArrSub2_list);
            }
          }
          array_push($compArr_list['compTypeSub1_list'],$compArrSub1_list);
        }
      }
      array_push($compArrObj,$compArr_list);
    }
    //$compArrObj = json_encode($compArrObj);
    return $compArrObj;
  }

  // --ฟังก์ชั่นเรียกรายละเอียดประเภทดารร้องเรียน --//
  public function compTypeDetail($compType_id){
    $comp_type = array();
    $sql = "SELECT * FROM Complaint_Type WHERE compType_id='$compType_id' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $comp_type = $result;
    }
    return $comp_type;
  }

  // --ฟังก์ชั่นเรียกรายการความสำคัญ --//
  public function prioritySelectList($type,$section){
    $sql_extend="";
    if($type!="all"){
      $sql_extend = " AND casePrt_section='$section'";
    }else{

    }
    $case_priority_arr = array();
    $sql = "SELECT * FROM Case_Priority WHERE casePrt_status='0' AND casePrt_enable='1' $sql_extend ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $case_priority_arr[$result["casePrt_id"]] = $result["casePrt_name"];
    }
    return $case_priority_arr;
  }


  // --ฟังก์ชั่นเรียกรายการความสำคัญ --//
  public function priorityData($priority_id,$type_data){

    $sql = "SELECT * FROM Case_Priority WHERE casePrt_id='$priority_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    return $result[$type_data];
  }


  public function priorityDetail($priID){
    $case_priority_arr = array();
    $sql = "SELECT * FROM Case_Priority WHERE casePrt_id='$priID' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $case_priority_arr["name"] = $result["casePrt_name"];
      $case_priority_arr["color"] = $result["casePrt_color"];
    }
    return $case_priority_arr;
  }

  // --ฟังก์ชั่นเรียกรายการความสำคัญ --//
  public function caseStatusList($type){

    $caseStatusArrObj = array();
    $case_status_main = array('0'=>'Waiting', '1'=>'New', '2'=>'In Process', '4'=>'Overdue', '3'=>'Close');
    $case_status_overdue = array('1'=>'Sub process', '2'=>'Main process');
    $case_status_close = array('1'=>'Success', '2'=>'Continue', '3'=>'Reject');

    $caseStatusArrObj["case_status_main"] = $case_status_main;
    $caseStatusArrObj["case_status_main"] = $case_status_overdue;
    $caseStatusArrObj["case_status_main"] = $case_status_close;

    return $caseStatusArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน-- //
  public function caseChannelList(){
    $caseChArr = array();
    $sql = "SELECT * FROM Case_Channel WHERE caseCh_status='0' AND caseCh_enable='1' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $caseChArr[$result["caseCh_id"]] = $result["caseCh_name"];
    }
    return $caseChArr;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน 2 LV-- //
  public function caseChannelList2(){
    $caseChArrObj = array();
    $sql = "SELECT *
    FROM Case_Channel
            WHERE caseCh_level = 1
            AND caseCh_status = 0
            AND caseCh_enable = 1 ";
    $query = $this->dbConn->query($sql);
    $caseCh_num = $query->num_rows;
      while($result = $query->fetch_assoc()){
        $caseChArr["caseCh_id"] = $result["caseCh_id"];
        $caseChArr["caseCh_ref_id"] = $result["caseCh_ref_id"];
        $caseChArr["caseCh_level"] = $result["caseCh_level"];
        $caseChArr["caseCh_name"] = $result["caseCh_name"];
        $caseChArr["caseCh_type"] = $result["caseCh_type"];
        $caseChArr["caseCh_sublist"] = array();

        $sql_sub = "SELECT *
                    FROM Case_Channel
                    WHERE caseCh_ref_id = '".$result["caseCh_id"]."'
                    AND caseCh_level = 2
                    AND caseCh_status = 0
                    AND caseCh_enable = 1 ";
        $query_sub = $this->dbConn->query($sql_sub);
        while($result_sub = $query_sub->fetch_assoc()){
          $caseChArr_sub = array();
          $caseChArr_sub["caseCh_id"] = $result_sub["caseCh_id"];
          $caseChArr_sub["caseCh_ref_id"] = $result_sub["caseCh_ref_id"];
          $caseChArr_sub["caseCh_level"] = $result_sub["caseCh_level"];
          $caseChArr_sub["caseCh_name"] = $result_sub["caseCh_name"];
          $caseChArr_sub["caseCh_type"] = $result_sub["caseCh_type"];

          array_push($caseChArr["caseCh_sublist"],$caseChArr_sub);
        }
        array_push($caseChArrObj,$caseChArr);
      }
    return $caseChArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน หลาย LV-- //
  public function caseChannelListMutiLv($lv,$ref_id){
    $caseChArrObj = array();
    $sql = "SELECT *
    FROM Case_Channel
            WHERE caseCh_level = '$lv'
            AND caseCh_status = 0
            AND caseCh_enable = 1 ";
    if($ref_id!=""){
      $sql .= "AND caseCh_ref_id = '$ref_id' ";
    }
    $query = $this->dbConn->query($sql);
    $caseCh_num = $query->num_rows;
    $lv++;
      while($result = $query->fetch_assoc()){
        $caseChArr["caseCh_id"] = $result["caseCh_id"];
        $caseChArr["caseCh_ref_id"] = $result["caseCh_ref_id"];
        $caseChArr["caseCh_level"] = $result["caseCh_level"];
        $caseChArr["caseCh_name"] = $result["caseCh_name"];
        $caseChArr["caseCh_type"] = $result["caseCh_type"];
        $caseChArr["caseCh_sublist"] = array();

        $sql_sub = "SELECT *
                    FROM Case_Channel
                    WHERE caseCh_ref_id = '".$result["caseCh_id"]."'
                    AND caseCh_level = '$lv'
                    AND caseCh_status = 0
                    AND caseCh_enable = 1 ";
        $query_sub = $this->dbConn->query($sql_sub);
        $num_sub = $query_sub->num_rows;
        $caseChArr["num_sub"] = $num_sub;
        while($result_sub = $query_sub->fetch_assoc()){
          $caseChArr_sub = array();
          $caseChArr_sub["caseCh_id"] = $result_sub["caseCh_id"];
          $caseChArr_sub["caseCh_ref_id"] = $result_sub["caseCh_ref_id"];
          $caseChArr_sub["caseCh_level"] = $result_sub["caseCh_level"];
          $caseChArr_sub["caseCh_name"] = $result_sub["caseCh_name"];
          $caseChArr_sub["caseCh_type"] = $result_sub["caseCh_type"];
          array_push($caseChArr["caseCh_sublist"],$caseChArr_sub);
        }
        array_push($caseChArrObj,$caseChArr);
      }
    return $caseChArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน-- //
  public function caseProcessTypeList($type,$section,$col){
    if($type=="all"){
      $sql_notin = "";
    }else{
      $sql_notin = " AND process_type_id NOT IN (1,2)";
    }
    $sql_notin .= "AND (process_type_section='$section' OR process_type_section='0') ";

    $caseProcArr = array();
    $sql = "SELECT * FROM Process_Type WHERE process_type_status='0' AND process_type_enable='1' $sql_notin ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      if($col=="process_type_duration"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_duration"];
      }else if($col=="process_type_step"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_step"];
      }else if($col=="dept_type"){
        $caseProcArr[$result["process_type_id"]] = $result["dept_type"];
      }else if($col=="process_type_id"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_id"];
      }else if($col=="process_type_message_in"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_in"];
      }else if($col=="process_type_message_out"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_out"];
      }else if($col=="process_type_message_noti"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_noti"];
      }else if($col=="process_type_message_in_en"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_in_en"];
      }else if($col=="process_type_message_out_en"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_out_en"];
      }else if($col=="process_type_message_noti_en"){
        $caseProcArr[$result["process_type_id"]] = $result["process_type_message_noti_en"];
      }else{
        $caseProcArr[$result["process_type_id"]] = $result["process_type_name"];
      }
    }
    return $caseProcArr;
  }

  // --ฟังก์ชั่นเรียกรายการประเภทการยุติกระบวนการ-- //
  public function caseCloseList(){
    $caseCloseArr = array();
    $sql = "SELECT * FROM Case_Close WHERE caseClose_status='0' AND caseClose_section='$this->admin_section' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $caseCloseArr[$result["caseClose_id"]] = $result["caseClose_title"];
    }
    return $caseCloseArr;
  }

  // --ฟังก์ชั่นเรียกรายการทวีป --//
  public function continentsList(){
    $countryArrObj = array();
    $sql = "SELECT * FROM Continents ORDER BY name ASC ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){

      $countryArr["code"] = $result["code"];
      $countryArr["name"] = $result["name"];
      $countryArr["name_th"] = $result["name_th"];
      array_push($countryArrObj,$countryArr);
    }
    return $countryArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการประเทศ --//
  public function countryList(){
    $countryArrObj = array();
    $sql = "SELECT * FROM Country WHERE country_status=0 ORDER BY id=162 DESC, name ASC ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $result["flag_32"] = $result["img_path"];
      $result["flag_128"] = $result["img_path"];
      $countryArr["id"] = $result["id"];
      $countryArr["name"] = $result["name"];
      $countryArr["flag_32"] = $result["flag_32"];
      $countryArr["flag_128"] = $result["flag_128"];
      array_push($countryArrObj,$countryArr);
    }
    return $countryArrObj;
  }

  // --ฟังก์ชั่นเรียกรายละเอียดประเทศ --//
  public function countryData($country_id,$type_data){
    $countryArrObj = array();
    $sql = "SELECT * FROM Country WHERE id='$country_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    return $result[$type_data];
  }

  // --ฟังก์ชั่นเรียกรายการจังหวัด --//
  public function provinceList(){
    $provArrObj = array();
    $sql = "SELECT * FROM Province";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $provArr["prov_id"] = $result["prov_id"];
      $provArr["prov_name"] = $result["prov_name"];
      array_push($provArrObj,$provArr);
    }
    return $provArrObj;
  }

  // --ฟังก์ชั่นเรียกข้อมูลจังหวัด --//
  public function provinceSearchByData($txt,$type){
    $provArrObj = array();
    $sql = "SELECT * FROM Province WHERE $type='$txt' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $provArrObj = $result;
    }
    return $provArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการประเภทสกุลเงิน --//
  public function currencyList(){
    $currencyArrObj = array();
    $sql = "SELECT * FROM Currency ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $currenArr["curren_id"] = $result["curren_id"];
      $currenArr["curren_name"] = $result["curren_name"];
      array_push($currencyArrObj,$currenArr);
    }
    return $currencyArrObj;
  }

  // --ฟังก์ชั่นเรียกข้อมูลหน่วยงาน- //
  public function departmentData($type,$val,$res){
    $sql = "SELECT * FROM Department
            WHERE $type='$val' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    return $result[$res];
  }
    // --ฟังก์ชั่นเรียกรายการหน่วยงาน- //
    public function departmentList($type){

      $deptArr = array();

      if($type!=""){
         $extention = " AND dp.dept_type='$type'";
      }

      $sql_ctn = "SELECT ctn.code, ctn.name, dp.dept_type FROM Department dp
              LEFT JOIN Country ct ON (dp.country_id=ct.id)
              LEFT JOIN Continents ctn ON (ct.continent_code=ctn.code)
              WHERE dp.dept_status='0' AND dp.dept_enable='1' AND dp.country_id!='0' AND dept_type='3'
              $extention
              GROUP BY ct.continent_code
              ORDER BY ctn.name ASC ";
      $query_ctn = $this->dbConn->query($sql_ctn);
      $deptArr["ctn"] = array();
      while($result_ctn = $query_ctn->fetch_assoc()){
        //if(!in_array($result_ctn["name"],$deptArr["ctn"])){
          array_push($deptArr["ctn"],$result_ctn);
        //}
      }

      $sql_ct = "SELECT ct.id, ct.name, ct.continent_code, dp.dept_type FROM Department dp
              LEFT JOIN Country ct ON (dp.country_id=ct.id)
              LEFT JOIN Continents ctn ON (ct.continent_code=ctn.code)
              WHERE dp.dept_status='0' AND dp.dept_enable='1' AND dp.country_id!='0' AND dept_type='3'
              $extention
              GROUP BY dp.country_id
              ORDER BY dp.country_id='162' DESC, ct.name ASC ";
      $query_ct = $this->dbConn->query($sql_ct);
      $deptArr["ct"] = array();
      while($result_ct = $query_ct->fetch_assoc()){
        //if(!in_array($result_ct["name"],$deptArr["ct"])){
          array_push($deptArr["ct"],$result_ct);
        //}
      }

      $sql = "SELECT * FROM Department dp
              WHERE dp.dept_status='0'
              AND dp.dept_enable='1'
              $extention ";
      $query = $this->dbConn->query($sql);
      $deptArr["dept"] = array();
      while($result = $query->fetch_assoc()){
        array_push($deptArr["dept"],$result);
      }
      return $deptArr;
    }

  // --ฟังก์ชั่นเรียกข้อมูลสมาชิก-- //
  public function memberData($mem_id){
    $memArr = array();
    $sql = "SELECT * FROM `Member`
            WHERE member_id = '$mem_id' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      array_push($memArr,$result);
    }
    return $memArr;
  }

  //-- ฟังก์ชั่นตรวจสอบประเภทเรื่องร้องเรียน--//
  public function chkCompType(){
    $status_response = "00";
    $status_response_text = "success";
    if($this->compType_id!="" && $this->compTypeSub1!="" && $this->compTypeSub2==""){

      $sqlForm = "SELECT * FROM Complaint_Type_Sub2 ";
      $sqlForm .= "WHERE compTypeSub1_id='".$this->compTypeSub1."' ";
      $queryForm = $this->dbConn->query($sqlForm);
      $numForm = $queryForm->num_rows;
      if($numForm>0){
        $status_response = "02";
        $status_response_text = "กรุณาเลือกกรณีเรื่องร้องเรียน !";
      }

    }else if($this->compType_id!="" && $this->compTypeSub1=="" && $this->compTypeSub2==""){
      if($this->compType_other_flag == "1"){
        if($this->compType_other == ""){
          $status_response = "02";
          $status_response_text = "กรุณาระบุเรื่องร้องเรียน !";
        }
      }else{
        $sqlForm = "SELECT * FROM Complaint_Type_Sub1 ";
        $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
        $queryForm = $this->dbConn->query($sqlForm);
        $numForm = $queryForm->num_rows;
        if($numForm>0){
          $status_response = "02";
          $status_response_text = "กรุณาเลือกประเภทเรื่องร้องเรียนย่อย !";
        }
      }
    }else if($this->compType_id=="" && $this->compTypeSub1=="" && $this->compTypeSub2==""){
        $status_response = "02";
        $status_response_text = "กรุณาเลือกประเภทเรื่องร้องเรียน !";
    }
    return array('status_response' => $status_response,'status_response_text' => $status_response_text);
  }

  //-- ฟังก์ชั่นกำหนดรูปแบบฟอร์ม จาก ประเภทข้อร้องเรียน --//
  public function genFromSetForCompType(){
    if($this->compType_id!="" && $this->compTypeSub1!="" && $this->compTypeSub2!=""){
      $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
      $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
      $sqlForm .= "AND compTypeSub1_id='".$this->compTypeSub1."' ";
      $sqlForm .= "AND compTypeSub2_id='".$this->compTypeSub2."' ";
      $queryForm = $this->dbConn->query($sqlForm);
      $numForm2 = $queryForm->num_rows;
      if($numForm2>0){
        while($resultForm2 = $queryForm->fetch_assoc()){
          $arr_formSetList_type =array();
          $arr_formSetList_type["frmset_id"] = $resultForm2["frmset_id"];
          $arr_formSetList_type["frmset_name"] = $resultForm2["frmset_name"];
          array_push($this->arr_formSetList,$arr_formSetList_type);
        }
      }else{
        $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
        $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
        $sqlForm .= "AND compTypeSub1_id='".$this->compTypeSub1."' ";
        $sqlForm .= "AND  compTypeSub2_id='0' ";
        $queryForm = $this->dbConn->query($sqlForm);
        $numForm = $queryForm->num_rows;
        if($numForm>0){
          while($resultForm = $queryForm->fetch_assoc()){
            $arr_formSetList_type =array();
            $arr_formSetList_type["frmset_id"] = $resultForm["frmset_id"];
            $arr_formSetList_type["frmset_name"] = $resultForm["frmset_name"];
            array_push($this->arr_formSetList,$arr_formSetList_type);
          }
        }
      }
    }else if($this->compType_id!="" && $this->compTypeSub1!="" && $this->compTypeSub2==""){

      $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
      $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
      $sqlForm .= "AND compTypeSub1_id='".$this->compTypeSub1."' ";
      $sqlForm .= "AND compTypeSub2_id='0' ";
      $queryForm = $this->dbConn->query($sqlForm);
      $numForm = $queryForm->num_rows;
      if($numForm>0){
        while($resultForm = $queryForm->fetch_assoc()){
          $arr_formSetList_type =array();
          $arr_formSetList_type["frmset_id"] = $resultForm["frmset_id"];
          $arr_formSetList_type["frmset_name"] = $resultForm["frmset_name"];
          array_push($this->arr_formSetList,$arr_formSetList_type);
        }
      }else{
        $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
        $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
        $sqlForm .= "AND compTypeSub1_id='0' ";
        $sqlForm .= "AND compTypeSub2_id='0' ";
        $queryForm = $this->dbConn->query($sqlForm);
        $numForm = $queryForm->num_rows;
        if($numForm>0){
          while($resultForm = $queryForm->fetch_assoc()){
            $arr_formSetList_type =array();
            $arr_formSetList_type["frmset_id"] = $resultForm["frmset_id"];
            $arr_formSetList_type["frmset_name"] = $resultForm["frmset_name"];
            array_push($this->arr_formSetList,$arr_formSetList_type);
          }
        }
      }

    }else if($this->compType_id!="" && $this->compTypeSub1=="" && $this->compTypeSub2==""){
      if($this->compType_other_flag == "0"){
        $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
        $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
        $sqlForm .= "AND compTypeSub1_id='0' ";
        $sqlForm .= "AND compTypeSub2_id='0' ";
        $queryForm = $this->dbConn->query($sqlForm);
        $numForm = $queryForm->num_rows;
        if($numForm>0){
          while($resultForm = $queryForm->fetch_assoc()){
            $arr_formSetList_type =array();
            $arr_formSetList_type["frmset_id"] = $resultForm["frmset_id"];
            $arr_formSetList_type["frmset_name"] = $resultForm["frmset_name"];
            array_push($this->arr_formSetList,$arr_formSetList_type);
          }
        }
      }else if($this->compType_other_flag == "1"){
        $sqlForm = "SELECT * FROM Form_Link_Complaint_Type ";
        $sqlForm .= "WHERE compType_id='".$this->compType_id."' ";
        $queryForm = $this->dbConn->query($sqlForm);
        $numForm = $queryForm->num_rows;
        if($numForm>0){
          while($resultForm = $queryForm->fetch_assoc()){
            $arr_formSetList_type =array();
            $arr_formSetList_type["frmset_id"] = $resultForm["frmset_id"];
            $arr_formSetList_type["frmset_name"] = $resultForm["frmset_name"];
            array_push($this->arr_formSetList,$arr_formSetList_type);
          }
        }

      }
    }
    return $this->arr_formSetList;
  }

    // --ฟังก์ชั่นเรียกรายการประเภทไฟล์ --//
    public function genfileIcon($ext){
      $ext = strtolower($ext);
      if($ext=="pdf"){
        $icon_img = "file-pdf";
      }else if($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
        $icon_img = "file-image";
      }else if($ext=="doc" || $ext=="docx"){
        $icon_img = "file-word";
      }else if($ext=="xls" || $ext=="dxlsx"){
        $icon_img = "file-excel";
      }else if($ext=="ppt" || $ext=="pptx"){
        $icon_img = "file-powerpoint";
      }else if($ext=="zip" || $ext=="rar"){
        $icon_img = "file-archive";
      }else if($ext=="txt"){
        $icon_img = "file-text";
      }else{
        $icon_img = "file";
      }
      return $icon_img;
    }

    //-- ฟังก์ชั่นหาชื่อประเภทเรื่องร้องเรียต่างๆ --//
    public function getCaseToRef($type,$filterId){
      $rs_caseRef_list=array();
      if($type=="applnt"){
        $sql_caseRef_extend = "AND applnt_ident='$filterId' ";
      }
      else if($type=="applnt_org"){
        $sql_caseRef_extend = "AND applntOrg_trade_number='$filterId' ";
      }
      else if($type=="complnt"){
        $sql_caseRef_extend = "AND complnt_trade_number='$filterId' ";
      }
      $sql_caseRef = "SELECT * FROM `Case`
                      WHERE `case_id` != '".$this->case_id."'
                      $sql_caseRef_extend ";
      $qr_caseRef = $this->dbConn->query($sql_caseRef);
      $rs_caseRef = array();
      while($res_caseRef = $qr_caseRef->fetch_assoc()){
        $rs_caseRef["case"] = $res_caseRef;
        $sql = "SELECT * FROM `Field_Values` a
                LEFT JOIN `Field_Set` b ON (a.fieldset_id=b.fieldset_id)
                WHERE a.`case_id` = '".$res_caseRef["case_id"]."' ";
        $query = $this->dbConn->query($sql);
        while($rs_feild = $query->fetch_assoc()){
          $rs_caseRef["case_feild"][$rs_feild["fieldset_name"]] = $rs_feild["fieldset_value"];
        }
        array_push($rs_caseRef_list,$rs_caseRef);
      }
      return $rs_caseRef_list;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Table --//
    /*
    public function get_case_data(){
      global $method_case;
      global $rs_case;

      $rs_case["case"]["my_case_owner"] = 0;
      $rs_case["case"]["my_case_assign"] = 0;

      $sql = "SELECT *
              FROM `Case` c
              LEFT JOIN `Complaint_Type` cmp_t ON (c.compType_id=cmp_t.compType_id)
              LEFT JOIN `Case_Close` cc ON (c.caseClose_id=cc.caseClose_id)
              WHERE c.case_id='$this->case_id'
              AND cmp_t.compType_section='$this->admin_section'  ";
      $query = $this->dbConn->query($sql);
      $rs_case["case"] = $query->fetch_assoc();
      if(!($rs_case["case"]["caseCh_id"] == 1 || $rs_case["case"]["caseCh_id"] == 2)  && $rs_case["case"]["case_createBy_id"]==$this->admin_id){
        $rs_case["case"]["my_case_owner"] = 1;
      }

      return $rs_case;
    }
    */
    public function get_case_data(){
      global $method_case;
      global $rs_case;

      $rs_case["case"]["my_case_owner"] = 0;
      $rs_case["case"]["my_case_assign"] = 0;
      // echo
      if($this->admin_section == 1){
        // $and = " AND cmp_t.compType_section='$this->admin_section' OR (c.check_transfer = 1 ) " ;
      }else{
        $and = " AND cmp_t.compType_section='$this->admin_section'  AND c.check_transfer = 0 " ;
      }
      // $and = " AND cmp_t.compType_section='$this->admin_section' " ;

      // echo
      $sql = "SELECT *
              FROM `Case` c
              LEFT JOIN `Complaint_Type` cmp_t ON (c.compType_id=cmp_t.compType_id)
              LEFT JOIN `Case_Close` cc ON (c.caseClose_id=cc.caseClose_id)
              WHERE c.case_id='$this->case_id' $and ";
      $query = $this->dbConn->query($sql);
      // exit();
      $rs_case["case"] = $query->fetch_assoc();
      if(!($rs_case["case"]["caseCh_id"] == 1 || $rs_case["case"]["caseCh_id"] == 2)  && $rs_case["case"]["case_createBy_id"]==$this->admin_id){
        $rs_case["case"]["my_case_owner"] = 1;
      }

      return $rs_case;
    }
    //-- ฟังก์ชั่นดึงข้อมูลจาก Field_Values Table --//
    public function get_case_field_data(){
      global $method_case;
      global $rs_case;
      $field = array();

      $rs_case["case_feild"] = array();
      $sql = "SELECT * FROM `Field_Values` a
              LEFT JOIN `Field_Set` b ON (a.fieldset_id=b.fieldset_id)
              WHERE `case_id`='$this->case_id' ";
          
      $query = $this->dbConn->query($sql);
      while($rs_feild = $query->fetch_assoc()){
        $rs_case["case_feild"][$rs_feild["fieldset_name"]] = $rs_feild["fieldset_value"];
      }

      if($method_case=="editcase"){
        $sqlCase = "SELECT office_id FROM `Case` WHERE `case_id` = '$this->case_id' ";
        $queryCase = $this->dbConn->query($sqlCase);
        if($queryCase->num_rows > 0){
          while ($res_case = $queryCase->fetch_assoc()) {
            $rs_case["case_feild"]["office_id"] = $res_case["office_id"];
          }
        }
      }

      return $rs_case;
    }
    //-- ฟังก์ชั่นดึงข้อมูลจาก Case File Attach Table --//
    public function get_case_attach_data(){
      global $rs_case;
      $rs_case["case_Attachfile"] = array();
      $sql = "SELECT * FROM `Case_Attachfile` WHERE `case_id`='$this->case_id' AND `caseAttach_status`='0' ";
      $query = $this->dbConn->query($sql);
      while($rs_feild = $query->fetch_assoc()){
        if($rs_feild["caseAttach_create_type"]=="1"){


          $sql_sender_ref = "SELECT member_fname, member_lname ";
          $sql_sender_ref .= "FROM `Member` ";
          $sql_sender_ref .= "WHERE member_id = '".$rs_feild["caseAttach_createBy_id"]."' ";
          $query_sender = $this->dbConn->query($sql_sender_ref);
          $sender = $query_sender->fetch_assoc();
          if($sender["member_type"]==0){

            $rs_feild["caseAttach_createBy_name"] = $sender["member_fname"]." ".$sender["member_lname"];

          }else if($sender["member_type"]=="1"){

            $sql_sender_ref_comp = "SELECT member_comp_name ";
            $sql_sender_ref_comp .= "FROM `Member_comp` ";
            $sql_sender_ref_comp .= "WHERE member_id = '".$sender["member_id"]."' ";
            $query_sender_comp = $this->dbConn->query($sql_sender_ref_comp);
            $sender_comp = $query_sender_comp->fetch_assoc();
            $rs_feild["caseAttach_createBy_name"] = $sender_comp["member_comp_name"];

          }

        }else if($rs_feild["caseAttach_create_type"]=="2"){
          $sql_sender_ref = "SELECT * ";
          $sql_sender_ref .= "FROM `Employee` ";
          $sql_sender_ref .= "WHERE emp_id = '".$rs_feild["caseAttach_createBy_id"]."' ";
          $query_sender = $this->dbConn->query($sql_sender_ref);
          $sender = $query_sender->fetch_assoc();
          $rs_feild["caseAttach_createBy_name"] = $sender["emp_firstname"]." ".$sender["emp_lastname"];
        }

         array_push($rs_case["case_Attachfile"],$rs_feild);
      }

      $rs_case["msg_Attachfile"] = array();
      $sql_msg = "SELECT * FROM `Message_Box_Attachfile` msg ";
      $sql_msg .= "LEFT JOIN `Message_Box` msg_b ON (msg.msgBox_id=msg_b.msgBox_id) ";
      $sql_msg .= "WHERE msg_b.case_id='$this->case_id' AND msg.msgBoxAttach_status='0' ";
      $query_msg = $this->dbConn->query($sql_msg);
      while($rs_feild_msg = $query_msg->fetch_assoc()){

         if($rs_msg_ref["sender_type"]=="2"){
           $sql_sender_ref = "SELECT * ";
           $sql_sender_ref .= "FROM `Employee` ";
           $sql_sender_ref .= "WHERE emp_id = '".$rs_msg_ref["sender_id"]."' ";
           $query_sender = $this->dbConn->query($sql_sender_ref);
           $sender = $query_sender->fetch_assoc();
           $rs_msg_ref["img_sender"] = $sender["emp_img_path_s"];
           $rs_msg_ref["msgBox_sender"] = $sender["emp_firstname"]." ".$sender["emp_lastname"];

         }else{

           $sql_sender_ref = "SELECT member_fname, member_lname ";
           $sql_sender_ref .= "FROM `Member` ";
           $sql_sender_ref .= "WHERE member_id = '".$rs_msg_ref["sender_id"]."' ";
           $query_sender = $this->dbConn->query($sql_sender_ref);
           $sender = $query_sender->fetch_assoc();
           if($sender["member_type"]==0){

             $rs_feild_msg["msgBox_sender"] = $sender["member_fname"]." ".$sender["member_lname"];

           }else if($sender["member_type"]==1){

             $sql_sender_ref_comp = "SELECT member_comp_name ";
             $sql_sender_ref_comp .= "FROM `Member_comp` ";
             $sql_sender_ref_comp .= "WHERE member_id = '".$sender["member_id"]."' ";
             $query_sender_comp = $this->dbConn->query($sql_sender_ref_comp);
             $sender_comp = $query_sender_comp->fetch_assoc();
             $rs_feild_msg["msgBox_sender"] = $sender_comp["member_comp_name"];

           }
         }

         array_push($rs_case["msg_Attachfile"],$rs_feild_msg);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Reference Table --//
    public function get_case_ref_data(){
      global $rs_case;
      $rs_case["case_ref"] = array();
      $sql = "SELECT * FROM `Case_Ref` c ";
      $sql .= "LEFT JOIN  `Case` cs ON (c.case_id=cs.case_id) ";
      $sql .= "LEFT JOIN  `Complaint_Type` cmp_t ON (cs.compType_id=cmp_t.compType_id) ";
      $sql .= "WHERE c.case_id = '$this->case_id' ";
      $sql .= "AND cmp_t.compType_section = '$this->admin_section' ";

      $query = $this->dbConn->query($sql);
      while($rs_feild = $query->fetch_assoc()){
         array_push($rs_case["case_ref"],$rs_feild);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Log Table --//
    public function get_case_log_data(){
      global $rs_case;
      $rs_case["case_log"] = array();
      $sql = "SELECT * FROM `Log_Case` cs
              LEFT JOIN `Employee` e ON (cs.emp_id=e.emp_id)
              LEFT JOIN `office_type` ofic ON (e.office_id=ofic.office_id)
              WHERE cs.case_id='$this->case_id'
              ORDER BY logCase_id DESC";
      $query = $this->dbConn->query($sql);
      while($rs_logCase = $query->fetch_assoc()){
        if(count(glob("../".$rs_logCase["emp_img_path_s"]))==0 || $rs_logCase["emp_img_path_s"] == '') {
          $rs_logCase["emp_img_path_s"] = "setting/img/profile_emp-01.svg";
        }else{
          $rs_logCase["emp_img_path_s"] = "../".$rs_logCase["emp_img_path_s"];
        }
        array_push($rs_case["case_log"],$rs_logCase);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Assign Table --//
    public function get_case_assign_data($col){
      global $rs_case;
      $rs_case["case_assign"] = array();
      $sql = "SELECT * FROM `Case_Assign` cs
              INNER JOIN `Employee` e ON (cs.emp_id=e.emp_id)";
      if($col=="emp_id"){
        $sql .= "WHERE cs.emp_id='$this->admin_id' ";
      }else{
        $sql .= "WHERE cs.case_id='$this->case_id' ";
      }

      $sql .= "AND cs.caseAsign_status='0' ";
      $query = $this->dbConn->query($sql);
      while($rs_assignCase = $query->fetch_assoc()){
        if($rs_assignCase["emp_id"]==$this->admin_id){
          $rs_case["case"]["my_case_assign"] = 1;
        }
        if(count(glob("../".$rs_assignCase["emp_img_path_s"]))==0 || $rs_assignCase["emp_img_path_s"] == '') {
          $rs_assignCase["emp_img_path_s"] = "setting/img/profile_emp-01.svg";
        }else{
          $rs_assignCase["emp_img_path_s"] = "../".$rs_assignCase["emp_img_path_s"];
        }
        array_push($rs_case["case_assign"],$rs_assignCase);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Process Table --//
    public function get_case_process_data(){
      global $rs_case;
      $rs_case["case_process"] = array();
      $sql = "SELECT * FROM `Process` p  ";
      $sql .= "INNER JOIN `Process_Type` pt ON (p.process_type_id=pt.process_type_id) ";
      $sql .= " WHERE p.case_id='$this->case_id' ORDER BY process_create_datetime ASC ";
      $query = $this->dbConn->query($sql);
      while($rs_processCase = $query->fetch_assoc()){
         array_push($rs_case["case_process"],$rs_processCase);
          $process_id = $rs_processCase["process_id"];

          $rs_case["process_app"][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropApp` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procApp= $query_proc->fetch_assoc()){
             array_push($rs_case["process_app"][$process_id],$rs_procApp);
          }

          $rs_case["process_tel"][1][$process_id] = array();
          $rs_case["process_tel"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropTel` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procTel= $query_proc->fetch_assoc()){
             array_push($rs_case["process_tel"][$rs_procTel["procPropTel_type"]][$process_id],$rs_procTel);
          }

          $rs_case["process_fax"][1][$process_id] = array();
          $rs_case["process_fax"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropFax` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procFax = $query_proc->fetch_assoc()){
             array_push($rs_case["process_fax"][$rs_procFax["procPropFax_type"]][$process_id],$rs_procFax);
          }

          $rs_case["process_email"][1][$process_id] = array();
          $rs_case["process_email"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropEmail` ppMail
                        WHERE ppMail.process_id='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procEmail = $query_proc->fetch_assoc()){
            $rs_procEmail["email_attach"] = array();
             $sql_proc_attach = "SELECT * FROM `Mail_Attachfile`  WHERE `procPropEmail_id`='".$rs_procEmail["procPropEmail_id"]."' ";
             $query_proc_attach = $this->dbConn->query($sql_proc_attach);
             while($rs_procEmail_attach = $query_proc_attach->fetch_assoc()){
                array_push($rs_procEmail["email_attach"],$rs_procEmail_attach);
             }
             array_push($rs_case["process_email"][$rs_procEmail["procPropEmail_type"]][$process_id],$rs_procEmail);
          }



          $rs_case["process_offcletter"][1][$process_id] = array();
          $rs_case["process_offcletter"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropOffcLetter` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procOffcLetter = $query_proc->fetch_assoc()){
             array_push($rs_case["process_offcletter"][$rs_procOffcLetter["procPropOffcLetter_type"]][$process_id],$rs_procOffcLetter);
          }

          $rs_case["process_mail"][1][$process_id] = array();
          $rs_case["process_mail"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropMail` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procMail = $query_proc->fetch_assoc()){
             array_push($rs_case["process_mail"][$rs_procMail["procPropMail_type"]][$process_id],$rs_procMail);
          }
        }
        return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก การโอนเคส --//
    public function get_case_transfer(){
      global $rs_case;
      $rs_case["case_transfer"] = array();
      $sql = "SELECT * FROM `case_transfer_log` a
              LEFT JOIN `Employee` b ON (a.transfer_empID=b.emp_id)
              LEFT JOIN `office_type` c ON (b.office_id=c.office_id)
              WHERE a.transfer_caseID = '$this->case_id'
              ORDER BY a.transfer_id DESC";
      $query = $this->dbConn->query($sql);
      while($rs_case_trans = $query->fetch_assoc()){
        if(count(glob("../".$rs_case_trans["emp_img_path_s"]))==0 || $rs_case_trans["emp_img_path_s"] == '') {
          $rs_case_trans["emp_img_path_s"] = "setting/img/profile_emp-01.svg";
        }else{
          $rs_case_trans["emp_img_path_s"] = "../".$rs_case_trans["emp_img_path_s"];
        }
        array_push($rs_case["case_transfer"],$rs_case_trans);
      }
      return $rs_case;
    }
    public function office_data($office_id){
      $sql = "SELECT * FROM `office_type`
              WHERE office_id='$office_id' ";
      $query = $this->dbConn->query($sql);
      return $query->fetch_assoc();
    }

    //-- ฟังก์ชั่นหาเก็บ log ต่างๆ --//
    public function save_log($type_log,$case_id,$process_id,$text){
      $sql = "INSERT
              INTO
                `Log_Case`(
                  `case_id`,
                  `process_id`,
                  `emp_id`,
                  `logCase_type`,
                  `logCase_text`,
                  `logCase_datetime`
                )
              VALUES(
                '$case_id',
                '$process_id',
                '".$this->admin_id."',
                '$type_log',
                '$text',
                NOW()
              ) ";
      $query = $this->dbConn->query($sql);
      if($query){
        return "00";
      }
      mysqli_close($this->dbConn);
    }
}
 //-- คลาส ใช้กับ Case List --//
class case_list extends case_base{

  public function __construct(){
    parent::__construct();
  }

  public function getCaseList($post){

    if($_SESSION['admin']['office'] != 0){
      $office = " AND c.office_id = ".$_SESSION['admin']['office'];
    }else {
      $office = " ";
    }
    $priorityTitle =  $this->prioritySelectList(null,$this->admin_section);

    $countryList_arr =  $this->countryList();
    $countryList = array();
    foreach($countryList_arr as $countryList_arr_inner){
      foreach($countryList_arr_inner as $key=>$value){
        if($key=="id"){
          $idflag = $value;
        }
        if($key=="flag_32"){
          $countryList[$idflag]["flag_32"] = $value;
        }

      }
    }
    $this->setting_info();

    $arr_sort = array("caseId"=>"case_id","subject"=>"caseDtl_title","date"=>"case_create_datetime","assign"=>"emp_id");
    $arr_sort2 = array("applnt","complnt","status");
    $case_arr = array();
    $sql_case = "SELECT * ";
    $sql_case .= "FROM `Case` c ";
    $sql_case .= "LEFT JOIN  `Complaint_Type` cmp_t ON (c.compType_id=cmp_t.compType_id) ";
    $sql_case_condition = "WHERE cmp_t.compType_section='$this->admin_section' $office ";
    $sql_case_condition_check = "WHERE cmp_t.compType_section='$this->admin_section' $office ";

    if($this->admin_section == 2 ){
      $sql_case_condition .= " AND c.check_transfer = 0 ";
    }else{
      // $sql_case_condition .= " OR (c.check_transfer = 1) ";
    }

    if($this->admin_section=="1"){
      if($post->prod_type!=""){
        $sql_case .= "LEFT JOIN  `Product_Type` prod_t ON (c.prodType_id=prod_t.prodType_id) ";
        $sql_case_condition .= "AND prod_t.prodType_level >= '$post->prod_type_lv' AND (prod_t.prodType_id = '$post->prod_type' OR prod_t.prodType_ref_id = '$post->prod_type')  ";
      }
    }else if($this->admin_section=="2"){
      if($post->incorrect_type!=""){
        $sql_case .= "LEFT JOIN `Incorrect_Type` incr_t ON (c.incType_id=incr_t.incType_id) ";
        $sql_case_condition .= "AND incr_t.incType_id='$post->incorrect_type' ";
      }
    }

    if($post->search_assign!=""){
        $sql_case .= "LEFT JOIN `Case_Assign` asign ON (c.case_id=asign.case_id) ";
        $sql_case_condition .= "AND c.case_status>=2 AND asign.emp_id = '".$post->search_assign."' AND asign.caseAsign_status = '0' ";
    }


    if($post->case_type!=""){
      $sql_case_condition .= "AND c.compType_id = '$post->case_type' ";
    }
    if($post->case_type_sub1!=""){
      $sql_case_condition .= "AND c.compTypeSub1_id = '$post->case_type_sub1' ";
    }
    if($post->case_type_sub2!=""){
      $sql_case_condition .= "AND c.compTypeSub2_id = '$post->case_type_sub2' ";
    }
    if($post->priority!=""){
      $sql_case_condition .= "AND c.case_priority = '$post->priority' ";
    }
    if($post->status=="0" || $post->status=="1"){
      $sql_case_condition .= "AND c.case_status = '$post->status' ";
    }
    if($post->channel!=""){
      $sql_case .= "LEFT JOIN  `Case_Channel` ch ON (c.caseCh_id=ch.caseCh_id) ";
      $sql_case_condition .= "AND ch.caseCh_level >= '$post->channel_lv' AND (ch.caseCh_id = '$post->channel' OR ch.caseCh_ref_id = '$post->channel')  ";
    }

    if($this->admin_position==6){
      if($post->country==$this->admin_country || $post->country==''){
        $sql_case_condition .= "AND (c.applnt_country_id = '$this->admin_country' ";
        $sql_case_condition .= "OR c.complnt_country_id = '$this->admin_country') ";
      }else{
        $sql_case_condition .= "AND (c.applnt_country_id = '9999' ";
        $sql_case_condition .= "OR c.complnt_country_id = '9999') ";
      }
    }else{
      if($post->country!=""){
        $sql_case_condition .= "AND (c.applnt_country_id = '$post->country' ";
        $sql_case_condition .= "OR c.complnt_country_id = '$post->country') ";
      }
    }

    if($post->assign_emp_id==""){
      if($post->date!=""){
        $dateSplit = explode(" - ",$post->date);
        $dateStart = DateTime::createFromFormat('d/m/Y', $dateSplit[0])->format('Y-m-d');
        $dateEnd = DateTime::createFromFormat('d/m/Y', $dateSplit[1])->format('Y-m-d');
        $sql_case_condition .= "AND DATE(c.case_create_datetime) >= '$dateStart' AND DATE(c.case_create_datetime) <= '$dateEnd' ";
      }
    }else{
      $search_kpi = $post->search_kpi;
      $year_kpi = $post->year_kpi;
      $month_kpi = $post->month_kpi;


       if($search_kpi==0){
         if($month_kpi !='' ){
           if($month_kpi=='1'){$mon = '-01-';}
           if($month_kpi=='2'){$mon = '-02-';}
           if($month_kpi=='3'){$mon = '-03-';}
           if($month_kpi=='4'){$mon = '-04-';}
           if($month_kpi=='5'){$mon = '-05-';}
           if($month_kpi=='6'){$mon = '-06-';}
           if($month_kpi=='7'){$mon = '-07-';}
           if($month_kpi=='8'){$mon = '-08-';}
           if($month_kpi=='9'){$mon = '-09-';}
           if($month_kpi=='10'){$mon = '-10-';}
           if($month_kpi=='11'){$mon = '-11-';}
           if($month_kpi=='12'){ $mon = '-12-';}
         }
         if($mon != ''){
           $case_d = " AND c.case_create_datetime  like '%".$mon."%' ";
         }
         if($year_kpi !='' ){
           $case_y .= " AND c.case_create_datetime  like '%".$year_kpi."%' ";
         }
       }else{
         $startDate = $post->startDate_kpi;
         $stopDate = $post->stopDate_kpi;
         $display_kpi = $post->display_kpi;
         $year_type_kpi = $post->year_type_kpi;
         $month_issue = $post->month;
         $select_quarter_chk = $post->select_quarter_chk_kpi;
         $issue_year = $post->issue_year;

         if($year_type_kpi==1){
           if($startDate!='' && $stopDate !='' ){
             if($display_kpi==1){
               $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y');
               $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y');
               $startDateY = $startDateY-543;
               $stopDateY = $stopDateY-543;
               $startDate = DateTime::createFromFormat('d/m/Y',($startDate))->format('m/d');
               $stopDate = DateTime::createFromFormat('d/m/Y',($stopDate))->format('m/d');
               $startDateY =  $startDateY."/".$startDate;
               $stopDateY=  $stopDateY."/".$stopDate;
             }else {
               $startDateY = DateTime::createFromFormat('d/m/Y',($startDate))->format('Y/m/d');
               $stopDateY = DateTime::createFromFormat('d/m/Y',($stopDate))->format('Y/m/d');
             }
             $sql_se = " AND c.case_create_datetime >= '$startDateY'  AND c.case_create_datetime <= '$stopDateY' ";
           }else if($month_issue!=''){
             if($month_issue=='1'){$mon = '-01-';}
             if($month_issue=='2'){$mon = '-02-';}
             if($month_issue=='3'){$mon = '-03-';}
             if($month_issue=='4'){$mon = '-04-';}
             if($month_issue=='5'){$mon = '-05-';}
             if($month_issue=='6'){$mon = '-06-';}
             if($month_issue=='7'){$mon = '-07-';}
             if($month_issue=='8'){$mon = '-08-';}
             if($month_issue=='9'){$mon = '-09-';}
             if($month_issue=='10'){$mon = '-10-';}
             if($month_issue=='11'){$mon = '-11-';}
             if($month_issue=='12'){ $mon = '-12-';}
             $sql_se = "AND c.case_create_datetime like '%".$mon."%'  ";
           }else if($select_quarter_chk !='' ){
             if($select_quarter_chk==1){
               $st = $issue_year."-01-01";
               $sp = $issue_year."-04-01";
             }else if($select_quarter_chk==2){
               $st = $issue_year."-04-01";
               $sp = $issue_year."-07-01";
             }else if($select_quarter_chk==3){
               $st = $issue_year."-07-01";
               $sp = $issue_year."-10-01";
             }else if($select_quarter_chk==4){
               $st = $issue_year."-10-01";
               $sp = $issue_year."-12-31";
             }
             $sql_se = " AND c.case_create_datetime >= '$st'  AND c.case_create_datetime < '$sp' ";
           }else if($issue_year != ''){
             $sql_se = "AND c.case_create_datetime like '%".$issue_year."%'  ";
           }
         }else{    // ปีงบประมาณ
           $st = ($issue_year-1)."-10-01";
           $issue_year = $issue_year;
           $sp = $issue_year."-09-30";
           $sql_se = " AND c.case_create_datetime >= '$st'  AND c.case_create_datetime <= '$sp' ";
         }
       }
     }

     if($post->close_id!="" && $post->search_kpi!=1){
       $sql_case_condition .= "AND c.caseClose_id = '".$post->close_id."' ";
     }

     $sql_case_condition .= $sql_se.$case_d.$case_y;



    if($post->valid_dbd=="1"){
      $sql_case_condition .= "AND (applnt_valid_dbd='1' OR complnt_valid_dbd='1') ";
    }
    if($post->valid_ditp!=""){
      if($post->valid_ditp=="2"){
        $sql_case_condition .= "AND (applnt_valid_ditp='1' OR complnt_valid_ditp='1') ";
      }else{
        $sql_case_condition .= "AND ((applnt_valid_ditp='1' AND applnt_valid_ditp_org='$post->valid_ditp') OR (complnt_valid_ditp='1' AND complnt_valid_ditp_org='$post->valid_ditp')) ";
      }
    }



    $sql_case_condition_search = $sql_case_condition."GROUP BY c.case_id ";

    $sql_case_search = $sql_case.$sql_case_condition_search;
    $query_case_search = $this->dbConn->query($sql_case_search);

    $case_overdue_main = array();
    $case_overdue_sub = array();

    while($rs_case_list = $query_case_search->fetch_assoc()){
      $this->case_id = $rs_case_list["case_id"];
      $rs_case = $this->get_case_process_data();


      if($rs_case_list["case_status"]=="2" || $rs_case_list["case_status"]=="3"){

        $datatime_diff = array();
        if($rs_case_list["case_status"]=="2"){
          $datatime_diff = $this->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case_list["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
        }else if($rs_case_list["case_status"]=="3"){
          $datatime_diff = $this->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case_list["case_opened_datetime"])),date("Y-m-d 00:00:00",strtotime($rs_case_list["case_close_datetime"])));
        }
        if($datatime_diff["days"]<0){
          $datatime_diff["days"] = 0;
        }
        if($datatime_diff["days"]>0 && $rs_case_list["case_opened_datetime"]!="" && $datatime_diff["days"]>$rs_case_list["case_compType_duration"]){
          array_push($case_overdue_main,$rs_case_list["case_id"]);
        }
        foreach ($rs_case["case_process"] as $case_process) {


          $time_over = $case_process["process_over_datetime"];
          if($case_process["process_complete_datetime"]!=""){
            $time_compare = strtotime($case_process["process_complete_datetime"]);
          }else{
            $time_compare = time();
          }

          if($time_compare>$time_over){
            if(!in_array($case_overdue_sub,$rs_case_list["case_id"])){
              array_push($case_overdue_sub,$rs_case_list["case_id"]);
            }
          }
        }
      }
    }

    //----------------------------------------------------------------------------------------------------------------//
    if($post->status=="2"){
      $sql_case_condition .= "AND c.case_status='2' ";
      if(count($case_overdue_main)>0){
        $sql_case_condition .= "AND c.case_id NOT IN (".join(",",$case_overdue_main).")";
      }
    }else if($post->status=="3"){
      $sql_case_condition .= "AND c.case_status='3' ";
      if(count($case_overdue_main)>0){
        $sql_case_condition .= "AND c.case_id NOT IN (".join(",",$case_overdue_main).")";
      }
    }else if($post->status=="main_over"){
      $sql_case_condition .= "AND (c.case_status='2' OR c.case_status='3') ";
      if(count($case_overdue_main)>0){
        $sql_case_condition .= "AND c.case_id IN (".join(",",$case_overdue_main).")";
      }else{
        $sql_case_condition .= "AND c.case_id IN ('')";
      }
    }else if($post->status=="sub_over"){
      $sql_case_condition .= "AND (c.case_status='2' OR c.case_status='3') ";
      if(count($case_overdue_sub)>0){
        $sql_case_condition .= "AND c.case_id IN (".join(",",$case_overdue_sub).")";
      }
    }

    if($post->text!=""){
      $sql_case_condition .= "
        AND ( c.case_id = '".(int)$post->text."'
              OR c.caseDtl_title like '%$post->text%'
              OR (
                (c.applnt_type!=0 AND c.applntOrg_name like '%$post->text%')
                OR (c.applnt_type=0 AND (c.applnt_firstname like '%$post->text%' OR c.applnt_lastname like '%$post->text%'))
              )
              OR (
                 (c.complnt_type!=0 AND c.complntOrg_name like '%$post->text%')
                 OR (c.complnt_type=0 AND (c.complnt_firstname like '%$post->text%' OR c.complnt_lastname like '%$post->text%'))
              )
            ) ";
    }


    $sort = $post->sort;
    $order = $post->order;
    $offset = $post->offset;
    $limit = $post->limit;
    $sql_case_condition .= " GROUP BY c.case_id ";

    if(array_key_exists($sort,$arr_sort)){
      if($sort=="assign"){
          $sql_case_condition .= "ORDER BY asign.".$arr_sort[$sort]." ".$order.", c.case_id DESC  ";
      }else{
          $sql_case_condition .= "ORDER BY c.".$arr_sort[$sort]." ".$order.", c.case_id DESC ";
      }
    }else{
      if(in_array($sort,$arr_sort2)){
        if($sort=="applnt" || $sort=="complnt"){
          $sql_case_condition .= "ORDER BY `".$sort."Org_name` ".$order.",`".$sort."_name` ".$order.",`".$sort."_firstname` ".$order.",`".$sort."_lastname` ".$order." ";
        }else{
          $sql_case_condition .= "ORDER BY `case_status` ".$order." ";;
        }
      }
    }
    if($this->admin_section != 2 ){
      if($sql_case_condition_check==$sql_case_condition){
        $sql_case_condition .= " OR (c.check_transfer = 1) ";
      }
    }

    $sql_count_case = $sql_case.$sql_case_condition;
    //exit();
    $query_count_case = $this->dbConn->query($sql_count_case);
    $count_case = $query_count_case->num_rows;

    $sql_case = $sql_case.$sql_case_condition." LIMIT $offset, $limit";
    $query_case = $this->dbConn->query($sql_case);
    while($rs_case_list = $query_case->fetch_assoc()){

      $rs_case = array();
      $this->case_id = $rs_case_list["case_id"];
      $rs_case = $this->get_case_data();
      $rs_case = $this->get_case_process_data();
      $rs_case = $this->get_case_assign_data();
      $rs_case = $this->get_case_transfer();


      $comp_type_data = $this->compTypeDetail($rs_case["case"]["compType_id"]);

      $page_redirect="index.php?page=case_detail&caseId=".$rs_case["case"]["case_id"];
      if($rs_case["case"]["case_status"]!="2" && $rs_case["case"]["case_status"]!="3"){ //กรณีสถานะ ไม่ใช่ In Process และ Close
          if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_step_detail"]=="0"){
            $page_redirect_ext = "case_open_detail";
          }else{
            $page_redirect_ext = "case_detail";
          }
          // if($rs_case["case"]["case_status"]=="0" && ($rs_case["case"]["caseCh_id"]=="1" || $rs_case["case"]["caseCh_id"]=="2")){
          //   $page_redirect_ext = "case_open&method=editcase";
          // }
          $page_redirect = "index.php?page=".$page_redirect_ext."&caseId=".$rs_case["case"]["case_id"];
  		}

      $case_col_arr =array();
      $case_col_arr["caseId"] = sprintf("%05d",$rs_case["case"]["case_id"]);
      $case_col_arr["caseId"] = '<a href="'.$page_redirect.'">'.$case_col_arr["caseId"].'</a>';

      $case_col_arr["subject"] = $rs_case["case"]["caseDtl_title"]." <img class=\"ico-priority title=\"".$this->priorityData($rs_case["case"]["case_priority"],'casePrt_name')."\" src=\"../".$this->priorityData($rs_case["case"]["case_priority"],'casePrt_img_path')."\">";

      $case_col_arr["subject"] = '<a href="'.$page_redirect.'">'.$case_col_arr["subject"].'</a>';

      if($rs_case["case"]["applnt_status"]==1){
        $case_col_arr["applnt"] = '<label class="label-width-full label-bg-gray">ไม่ต้องการเปิดเผยรายชื่อ</label>';
      }else{
        if($rs_case["case"]["applnt_type"]!=0){
          if($rs_case["case"]["applntOrg_name"]==""){
            $case_col_arr["applnt"] = '<label class="label-width-full label-bg-gray">ไม่ระบุบริษัทหรือองค์กร</label>';
          }else{
            $case_col_arr["applnt"] = '<label class="label-width-full label-bg-gray">'.$rs_case["case"]["applntOrg_name"].'</label>';
          }
        }else{
          if($rs_case["case"]["applnt_firstname"]=="" && $rs_case["case"]["applnt_lastname"]==""){
            $case_col_arr["applnt"] = '';
          }else{
            $case_col_arr["applnt"] = '<label class="label-width-full label-bg-gray">'.$rs_case["case"]["applnt_firstname"]." ".$rs_case["case"]["applnt_lastname"].'</label>';
          }
        }

      }
      if($rs_case["case"]["applntOrg_country_id"]!=0){
        $case_col_arr["complnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(".$countryList[$rs_case["case"]["applntOrg_country_id"]]["flag_32"]."\");\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-html=\"true\" title=\"".($this->countryData($rs_case["case"]["applntOrg_country_id"],"name_th")!=""?$this->countryData($rs_case["case"]["applntOrg_country_id"],"name_th"):$this->countryData($rs_case["case"]["applntOrg_country_id"],"name"))."\"></i>";
      }else{
        if($rs_case["case"]["applnt_country_id"]!=0){
          $case_col_arr["applnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(".$countryList[$rs_case["case"]["applnt_country_id"]]["flag_32"]."\");\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-html=\"true\" title=\"".($this->countryData($rs_case["case"]["applnt_country_id"],"name_th")!=""?$this->countryData($rs_case["case"]["applnt_country_id"],"name_th"):$this->countryData($rs_case["case"]["applnt_country_id"],"name"))."\"></i>";
        }
      }
      if($rs_case["case"]["applnt_valid_ditp"]==1 && $rs_case["case"]["complnt_valid_ditp_org"]!=""){
        $case_col_arr["applnt"] .= '<i class="ico-ditp ico-ditp-'.$rs_case["case"]["applnt_valid_ditp_org"].'"></i>';
      }
      if($rs_case["case"]["applnt_valid_dbd"]==1){
        $case_col_arr["applnt"] .= '<i class="ico-dbd ico-dbd-1"></i>';
      }
      if($rs_case["case"]["applnt_backlist"]==2){
        $case_col_arr["applnt"] .= '<i class="ico-backlist ico-backlist-2"></i>';
      }

      if($rs_case["case"]["complntOrg_name"]==""){
        if($rs_case["case"]["complnt_name"]==""){
          if($rs_case["case"]["complnt_firstname"]=="" && $rs_case["case"]["complnt_lastname"]==""){
            $case_col_arr["complnt"] = '';
          }else{
            $case_col_arr["complnt"] = '<label class="label-width-full label-bg-gray">'.$rs_case["case"]["complnt_firstname"]." ".$rs_case["case"]["complnt_lastname"].'</label>';
          }
        }else{
          $case_col_arr["complnt"] = '<label class="label-width-full label-bg-gray">'.$rs_case["case"]["complnt_name"].'</label>';
        }
      }else{
        $case_col_arr["complnt"] = '<label class="label-width-full label-bg-gray">'.$rs_case["case"]["complntOrg_name"].'</label>';
      }

      if($rs_case["case"]["complnt_country_id"]!=0){
        $case_col_arr["complnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(".$countryList[$rs_case["case"]["complnt_country_id"]]["flag_32"].");\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-html=\"true\" title=\"".($this->countryData($rs_case["case"]["complnt_country_id"],"name_th")!=""?$this->countryData($rs_case["case"]["complnt_country_id"],"name_th"):$this->countryData($rs_case["case"]["complnt_country_id"],"name"))."\"></i>";
      }else{
        if($rs_case["case"]["complntOrg_country_id"]!=0){
          $case_col_arr["complnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(".$countryList[$rs_case["case"]["complntOrg_country_id"]]["flag_32"].");\"  data-toggle=\"tooltip\" data-placement=\"bottom\" data-html=\"true\" title=\"".($this->countryData($rs_case["case"]["complntOrg_country_id"],"name_th")!=""?$this->countryData($rs_case["case"]["complntOrg_country_id"],"name_th"):$this->countryData($rs_case["case"]["complntOrg_country_id"],"name"))."\"></i>";
        }
      }
      if($rs_case["case"]["complnt_valid_ditp"]==1 && $rs_case["case"]["complnt_valid_ditp_org"]!=""){
        $case_col_arr["complnt"] .= '<i class="ico-ditp ico-ditp-'.$rs_case["case"]["complnt_valid_ditp_org"].'"></i>';
      }
      if($rs_case["case"]["complnt_valid_dbd"]==1){
        $case_col_arr["complnt"] .= '<i class="ico-dbd ico-dbd-1"></i>';
      }
      if($rs_case["case"]["complnt_backlist"]==1){
        $case_col_arr["complnt"] .= '<i class="ico-backlist ico-backlist-1"></i>';
      }

      $case_col_arr["date"] = date("d/m/Y",strtotime($rs_case["case"]["case_create_datetime"]));

      $statusCaseClose_type = "";

      if($rs_case["case"]["case_status"]==0 || $rs_case["case"]["case_status"]==1){ //สถานะ Waiting, New
        $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
      }else if($rs_case["case"]["case_status"]==2){ //สถานะ Pending
        //หาจำนวนวันทำการที่ใช้ไป

        $datatime_diff = $this->getDateTimeData(date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_opened_datetime"])),date('Y-m-d 00:00:00',time()));
        if($datatime_diff["days"]<0){
          $datatime_diff["days"] = 0;
        }
        if($datatime_diff["days"]>0 && $rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $rs_case["case"]["case_compType_duration"]){ //ถ้าเกิน $this->day_overdue_case วัน
          $statusCase = '<img src="img/ico_case_status_4.png" class="img-status" />';
        }else{ //ถ้าไม่เกิน $this->day_overdue_case วัน
          $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
        }
      }else if($rs_case["case"]["case_status"]==3){ //สถานะ Close
        //หาจำนวนวันทำการที่ใช้ไป
        $datatime_diff = $this->getDateTimeData($rs_case["case"]["case_opened_datetime"],date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_close_datetime"])));

        if($datatime_diff["days"]<0){
          $datatime_diff["days"] = 0;
        }
        if($datatime_diff["days"]>0 && $rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $rs_case["case"]["case_compType_duration"]){ //ถ้าเกิน $this->day_overdue_case วัน
          if($rs_case["case"]["case_disKPI_status"]==1){ //ถ้ามีการ Dis KPI
            $statusCase = '<img src="img/ico_case_status_5-2.png" class="img-status" />';
          }else{ //ถ้าไม่มีการ Dis KPI
            // $statusCase = '<img src="img/ico_case_status_5-1.png" class="img-status" />';
            if($datatime_diff["days"] > $rs_case["case"]["case_compType_duration"]){
              $statusCase = '<img src="img/ico_case_status_5-1.png" class="img-status" />';
            }else{
              $statusCase = '<img src="img/ico_case_status_3.png" class="img-status" />';
            }
          }
        }else{ //ถ้าไม่เกิน $this->day_overdue_case วัน
          $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
          if($rs_case["case"]["caseClose_section"]=="2"){
            $statusCaseClose_type = '<img src="img/ico_caseClose_1.png" class="img-status-close" data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$rs_case["case"]["caseClose_title"].'" />';
          }else{
            $statusCaseClose_type = '<img src="img/ico_caseClose_'.($rs_case["case"]["caseClose_id"]!=""?$rs_case["case"]["caseClose_id"]:1).'.png" class="img-status-close" data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$rs_case["case"]["caseClose_title"].'" />';
          }

        }
        $statusCase = $statusCase.$statusCaseClose_type;
      }
      $assign = "";
      $iasgn = 0;
      foreach($rs_case["case_assign"] as $case_assign){
        $assign .= "<span class=\"assign_text\">".$case_assign["emp_firstname"]." ".$case_assign["emp_lastname"]."</span>";
          $assign.= "<hr style=\"margin:10px 0;\" />";
        $iasgn++;
      }

      $case_col_arr["assign"] = $assign;

      $case_col_arr["office"] = $this->office_data($rs_case["case"]["office_id"])["office_name_short"];

      if($rs_case["case"]["case_status"]!=0){

      	$processTypeName = $this->caseProcessTypeList("all",$this->admin_section);

        $processOverDue = "";
        $w_prc = 0;
        foreach ($rs_case["case_process"] as $case_process) {

          $time_over = $case_process["process_over_datetime"];
          if($case_process["process_status"]==1){
            $time_compare = strtotime($case_process["process_complete_datetime"]);
          }else{
            $time_compare = time();
          }

          if($datatime_diff["days"]>0 && $time_compare>$time_over){
            $processOverDue_text = $case_process["process_over_note"];
            $processOverDue .= '<img  src="../'.$this->setting_info["overdueSub_alert_img_path"].'" class="img-status-process-overdue" style="margin-left:5px;" data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$processOverDue_text.'" />';
            $w_prc+=21;
  				}
        }
        $statusCase = $statusCase.$processOverDue;
      }


      $html_statusCase = '<div class="" style="float:left; height:64px; width:'.(178+$w_prc).'px;">'.$statusCase.'</div>';

      $case_col_arr["status"] = $html_statusCase;

      if($_SESSION["admin"]["empSection"]==2){
        $case_col_arr["office"] = "นิติการ";
      }else{
        $case_col_arr["office"] = $this->office_data($rs_case["case"]["office_id"])["office_name_short"];
      }


      array_push($case_arr,$case_col_arr);

    }
    $data_array = array('total' => $count_case,'rows' => $case_arr);
    mysqli_close($this->dbConn);
    return json_encode($data_array);
  }


}


 //-- คลาส ใช้กับ Case Open --//
class case_open extends case_base{
  var $case_id; //รหัสข้อร้องเรียน
  var $compType_id; //ประเภทข้อร้องเรียน
  var $compTypeSub1; //ประเภทข้อร้องเรียนย่อยชั่นที่1
  var $compTypeSub2; //ประเภทข้อร้องเรียนย่อยชั่นที่2
  var $compType_other; //ข้อร้องเรียนอื่นๆ
  var $compType_other_flag; //ข้อร้องเรียนอื่นๆ
  var $arr_formSetList;

  var $case_channal_selct; //ช่องทางการร้องเรียน

  public function __construct(){
    parent::__construct();
    $this->arr_formSetList = array();
  }


  //-- ฟังก์ชั่นหาชื่อประเภทเรื่องร้องเรียต่างๆ --//
  public function getTitleCreateCase($compType_id,$compTypeSub1,$compTypeSub2){
    $arr_compType_name = array();
    $sql = "SELECT * FROM Complaint_Type ";
    $sql .= "WHERE compType_id='$compType_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    $arr_compType_name["compType_name"] = $result["compType_name"];
    $arr_compType_name["compType_other_flag"] = $result["compType_other_flag"];

    $sql = "SELECT * FROM Complaint_Type_Sub1 ";
    $sql .= "WHERE compTypeSub1_id='$compTypeSub1' AND compType_id='$compType_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    $arr_compType_name["compTypeSub1_name"] = $result["compTypeSub1_name"];

    $sql = "SELECT * FROM Complaint_Type_Sub2 ";
    $sql .= "WHERE compTypeSub2_id='$compTypeSub2' AND compTypeSub1_id='$compTypeSub1' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    $arr_compType_name["compTypeSub2_name"] = $result["compTypeSub2_name"];

    return $arr_compType_name;

  }

  //-- ฟังก์ชั่นกำหนดรูปแบบฟอร์ม แบบต่างๆรอไว้ --//
  public function setFromList($formSetId,$formSetName,$formSetNo){
    global $rs_case;

    if($rs_case["case"]["applnt_status"]==1){
      $selected_applnt_status = "checked";
    }else{
      $selected_applnt_status = "";
    }

    if($rs_case["case_feild"]["applnt_birthday"]!=""){
      $applnt_birthday = date('d/m/Y',strtotime($rs_case["case_feild"]["applnt_birthday"]));
    }else{
      $applnt_birthday="";
    }

    if($rs_case["case_feild"]["complnt_birthday"]!=""){
      $complnt_birthday = date('d/m/Y',strtotime($rs_case["case_feild"]["complnt_birthday"]));
    }else{
      $complnt_birthday="";
    }

    $countryList_complnt = "";
    $countryList_complnt_with_th = "";
    if(count($this->case_country==0)){
      $this->case_country = $this->countryList();
    }
    $country_list_complnt = array();
    foreach($this->case_country as $case_country_list){
      $country_list_complnt[$case_country_list["id"]] = $case_country_list["name"];
      if($case_country_list["id"]!=162){
        $countryList_complnt .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["complnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$case_country_list["name"].'
                        </option>';
      }
      $countryList_complnt_with_th .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["complnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                        '.$case_country_list["name"].'
                      </option>';
    }

    $countryList_applnt = "";
    if(count($this->case_country==0)){
      $this->case_country = $this->countryList();
    }
    $country_list_applnt = array();
    foreach($this->case_country as $case_country_list){
      $country_list_applnt[$case_country_list["id"]] = $case_country_list["name"];
        $countryList_applnt .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["applnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$case_country_list["name"].'
                        </option>';
    }

    $countryList_applntOrg = "";
    if(count($this->case_country==0)){
      $this->case_country = $this->countryList();
    }
    $country_list_applnt = array();
    foreach($this->case_country as $case_country_list){
      $country_list_applnt[$case_country_list["id"]] = $case_country_list["name"];
      if($case_country_list["id"]!=162){
        $countryList_applntOrg .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["applntOrg_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$case_country_list["name"].'
                        </option>';
      }
    }


    if(count($this->case_province==0)){
      $this->case_province = $this->provinceList();
    }

    $provinceList_pers = "";
    foreach($this->case_province as $case_province_list){
      $provinceList_pers .= '<option value="'.$case_province_list["prov_id"].'" '.($rs_case["case_feild"]["applnt_prov_id"]==$case_province_list["prov_id"]?'selected':'').'>
                        '.$case_province_list["prov_name"].'
                      </option>';
    }
    $provinceList_org = "";
    foreach($this->case_province as $case_province_list){
      $provinceList_org .= '<option value="'.$case_province_list["prov_id"].'" '.($rs_case["case_feild"]["applntOrg_prov_id"]==$case_province_list["prov_id"]?'selected':'').'>
                        '.$case_province_list["prov_name"].'
                      </option>';
    }

    $provinceList_compn = "";
    foreach($this->case_province as $case_province_list){
      $provinceList_compn .= '<option value="'.$case_province_list["prov_id"].'" '.($rs_case["case_feild"]["complnt_prov_id"]==$case_province_list["prov_id"]?'selected':'').'>
                        '.$case_province_list["prov_name"].'
                      </option>';
    }
    $typeformset = "case_open";

    include("formset/formset_".$formSetId.".php");

    return $formSet_html;
  }

  //-- ฟังก์ชั่นกำหนดรูปแบบฟอร์ม แบบต่างๆรอไว้ --//
  public function setFromList_openDetailCase($formSetId,$formSetName,$formSetNo){
    global $rs_case;


    if(count($this->case_country==0)){
      $this->case_country = $this->countryList();
    }
    $countryList = array();
    foreach($this->case_country as $case_country_list){
      $countryList[$case_country_list["id"]] = $case_country_list["name"];
    }

    if(count($this->case_province==0)){
      $this->case_province = $this->provinceList();
    }

    $provinceList = array();
    foreach($this->case_province as $case_province_list){
      $provinceList[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
    }


    $typeformset = "case_open_detail";

    if($rs_case["case_feild"]["applntOrg_import_export"]==1){
      $applntOrg_import_export = "บริษัทนำเข้า";
    }else if($rs_case["case_feild"]["applntOrg_import_export"]==2){
      $applntOrg_import_export = "บริษัทส่งออก";
    }else{
      $applntOrg_import_export = "ไม่ระบุ";
    }

    if($rs_case["case_feild"]["complnt_import_export"]==1){
      $complnt_import_export = "บริษัทนำเข้า";
    }else if($rs_case["case_feild"]["complnt_import_export"]==2){
      $complnt_import_export = "บริษัทส่งออก";
    }else{
      $complnt_import_export = "ไม่ระบุ";
    }

    include("formset/formset_".$formSetId.".php");

    return $formSet_html;
  }

  //-- ฟังก์ชั่นบันทึกค่าประเภทเรื่องร้องเรียนจาก Case ID --//
  public function genFromSetForCompType_editcase(){
    $arr_formSetList = array();
    $sql = "SELECT `compType_id`, `compTypeSub1_id`, `compTypeSub2_id`  FROM `Case` WHERE `case_id`='$this->case_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    $this->compType_id = $result["compType_id"];
    $this->compTypeSub1 = $result["compTypeSub1_id"];
    $this->compTypeSub2 = $result["compTypeSub2_id"];
    $arr_formSetList["fromSet"] = $this->genFromSetForCompType();

    $arr_formSetList["compType_id"] = $result["compType_id"];
    $arr_formSetList["compTypeSub1_id"] = $result["compTypeSub1_id"];
    $arr_formSetList["compTypeSub2_id"] = $result["compTypeSub2_id"];

    return $arr_formSetList;
  }

  //-- ฟังก์ชั่นดึงข้อมูลจาก Case ID --//
  public function getData_editcase(){

    $rs_case = array();
    $rs_case = $this->get_case_data();
    $rs_case = $this->get_case_field_data();
    $rs_case = $this->get_case_attach_data();
    $rs_case = $this->get_case_ref_data();
    $rs_case = $this->get_case_log_data();
    $rs_case = $this->get_case_assign_data();
    $rs_case = $this->get_case_process_data();
    $rs_case = $this->get_case_transfer();

    return $rs_case;
  }


  // --ฟังก์ชั่นเรียกข้อความตาม step --//
  public function notiTxt_byStep(){
    $notiTxtByStep = array();
    $sql = "SELECT * FROM Setting_Info ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $notiTxtByStep = array($result["noti_status"],$result["noti_process25"],$result["noti_process50"],$result["noti_process75"],$result["noti_process100"]);
      $notiTxtByStep_en = array($result["noti_status"],$result["noti_process25_en"],$result["noti_process50_en"],$result["noti_process75_en"],$result["noti_process100_en"]);
    }
    $notiTxt_obj = array($notiTxtByStep,$notiTxtByStep_en);
    return $notiTxt_obj;
  }

  // --ฟังก์ชั่นเช็คว่าสมาชิกให้ส่ง noti หรือไม่ --//
  public function chk_member_on_noti($member_id){
    $sql = "SELECT member_noti FROM Member WHERE member_id='$member_id' ";
    $query = $this->dbConn->query($sql);
    $result = $query->fetch_assoc();
    if($result["member_noti"]==1){
      $status = true;
    }else{
      $status = false;
    }
    return $status;
  }

  public function send_notification($step,$case_id,$method,$old_emp_assign,$process_type_id,$process_type_message,$dept_id,$process_type_message_en){

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();
    $qr_upd_case = true;
    $result_send = true;
    $status_can_send = false;
    $this->case_id = $case_id;
    $rs_case_noti = $this->get_case_data();
    $case_ass = $this->get_case_assign_data();
    $rs_case = $this->get_case_transfer();

    if($method=="assign"){
      $status_can_send = true;
      $text_noti = "ได้มีการ Assign - &spt;Case ID ".sprintf("%05d",$case_id)." &spt; ให้คุณ";
      if(count($case_ass["case_assign"])>0){
        $to_email = array();
        $to_name = array();
        foreach($case_ass["case_assign"] as $case_assign){
          if($case_assign["emp_id"]!=$this->admin_id && !in_array($case_assign["emp_id"],$old_emp_assign)){
            $sql = "INSERT
                      INTO
                        `Message_Noti_Employee`(
                          `case_id`,
                          `emp_id`,
                          `msgNotiEmp_message`,
                          `msgNotiEmp_datetime`,
                          `msgNotiEmp_status`,
                          `msgNotiEmp_noti_status`,
                          `msgNotiEmp_read_status`
                        )
                      VALUES(
                        '$case_id',
                        '".$case_assign["emp_id"]."',
                        '$text_noti',
                        NOW(),
                        0,
                        0,
                        0
                      )";
            $query = $this->dbConn->query($sql);

            array_push($to_email,$case_assign["emp_email"]);
      			array_push($to_name,$case_assign["emp_firstname"]." ".$case_assign["emp_lastname"]);
            $form_office = $this->office_data($case_assign["office_id"])["office_name"];
          }
        }

        //-- ส่งอีเมลล์ให้เจ้าหน้าที่ หลังจากเจ้าหน้าที่คนนั้นถูก Assign --//
        $mail = new email();
      	$status_can_send = true;
        $sendMail = array();
        $mail->to_email = $to_email;
  			$mail->to_name = $to_name;
        $mail->subject = "ท่านได้รับมอบหมายงานให้ดูแลเรื่องร้องเรียน Case ID: ".sprintf("%05d",$case_id)." ในระบบ DITP Care จาก ผู้จัดการสำนัก".$form_office." ";
        $mail->message =  "ท่านได้รับมอบหมายงานให้ดูแลเรื่องร้องเรียน <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."\">Case ID: ".sprintf("%05d",$case_id)."</a> ในระบบ DITP Care จากผู้จัดการสำนัก".$form_office." ท่านสามารถดำเนินการเรื่องร้องเรียนที่ท่านได้รับมอบหมายได้ที่ <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."\">http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."</a>";
        $sendMail = $mail->send_email();

      }

    }else{


      // --------------------DITP ALL-------------------------------
      if($step!=4){
        if($process_type_message==""){
          $process_type_message_txt = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_noti");
        }else{
          $process_type_message_txt = $this->caseProcessTypeList("all",$this->admin_section,$process_type_message);
        }
        if($process_type_message_en==""){
          $process_type_message_txt_en = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_noti_en");
        }else{
          $process_type_message_txt_en = $this->caseProcessTypeList("all",$this->admin_section,$process_type_message_en);
        }
        $text_noti_sms = $process_type_message_txt[$process_type_id];
        $text_noti_sms_en = $process_type_message_txt_en[$process_type_id];
        if($dept_id!=""){
          $text_noti_sms .= " ".$this->departmentData("dept_id",$dept_id,"dept_message_noti");
          $text_noti_sms_en .= " ".$this->departmentData("dept_id",$dept_id,"dept_message_noti_en");
        }
      }else{
        $notiTxtByStep = $this->notiTxt_byStep();
        $text_noti_sms = $notiTxtByStep[0][$step];
        $text_noti_sms_en = $notiTxtByStep[1][$step];
      }

        $curl = curl_init();
        $post = [
            'noti_token' => $rs_case_noti["case"]["applnt_ident"],
            'noti_subject' => 'DITP Care',
            'noti_message' => $text_noti_sms,
            'method'   => 'save',
            'noti_type'   => 4,
        ];
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://ditpall.ibusiness.co.th/noti.php",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $post,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
      // --------------------DITP ALL-------------------------------


      $caseCh_id = $rs_case_noti["case"]["caseCh_id"];
      $case_step_noti = $rs_case_noti["case"]["case_step_noti"];
        $status_can_send = true;
          $member_id = $rs_case_noti["case"]["case_opened_createBy_id"];
          $status_enable = $this->chk_member_on_noti($member_id);
          if($status_enable && $member_id!=""){

            if($step!=4){
              if($process_type_message==""){
                $process_type_message_txt = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_noti");
              }else{
                $process_type_message_txt = $this->caseProcessTypeList("all",$this->admin_section,$process_type_message);
              }
              if($process_type_message_en==""){
                $process_type_message_txt_en = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_noti_en");
              }else{
                $process_type_message_txt_en = $this->caseProcessTypeList("all",$this->admin_section,$process_type_message_en);
              }
              $text_noti_sms = $process_type_message_txt[$process_type_id];
              $text_noti_sms_en = $process_type_message_txt_en[$process_type_id];
              if($dept_id!=""){
                $text_noti_sms .= " ".$this->departmentData("dept_id",$dept_id,"dept_message_noti");
                $text_noti_sms_en .= " ".$this->departmentData("dept_id",$dept_id,"dept_message_noti_en");
              }
            }else{
              $notiTxtByStep = $this->notiTxt_byStep();

              $text_noti_sms = $notiTxtByStep[0][$step];
              $text_noti_sms_en = $notiTxtByStep[1][$step];
            }

              $sql = "INSERT
                        INTO
                          `Message_Noti_App`(
                            `case_id`,
                            `member_id`,
                            `msgNotiApp_step`,
                            `msgNotiApp_message`,
                            `msgNotiApp_message_en`,
                            `msgNotiApp_datetime`,
                            `msgNoti_status`,
                            `msgNotiApp_noti_status`,
                            `msgNotiApp_read_status`
                          )
                        VALUES(
                          '$case_id',
                          '$member_id',
                          '$step',
                          '".$text_noti_sms."',
                          '".$text_noti_sms_en."',
                          NOW(),
                          0,
                          0,
                          0
                        )";
              $query = $this->dbConn->query($sql);


              //-- ส่งอีเมลล์ให้ ผปก. หลังจากมีกิจกรรมเกิดขึ้น --//
              $mail = new email();
              $status_can_send = true;
              $sendMail = array();
              $mail->to_email = array($this->memberData($member_id)["member_email"]);
              $mail->to_name = array($this->memberData($member_id)["member_fname"]." ".$this->memberData($member_id)["member_lname"]);
              if($this->memberData($member_id)["country_id"]=="162"){
                $mail_subject = $text_noti_sms;
                $mail_message = $text_noti_sms;
                if($step==4){
                  $mail_message .= "<br /><br />เพื่อความพึงพอใจต่อการใช้งานของผู้ใช้ และการปรับปรุงระบบให้ดีขึ้นในเวอร์ชั่นต่อไป ท่านสามารถทำแบบสำรวจความพึงพอใจในการรับบริการ / DITP CARE ในระบบ Web Application ได้ที่ <a href=\"http://".$_SERVER["HTTP_HOST"]."/frontend/index.php?page=question\">http://".$_SERVER["HTTP_HOST"]."/frontend/index.php?page=question</a>";
                }
              }else{
                $mail_subject = $text_noti_sms_en;
                $mail_message = $text_noti_sms_en;
              }
              $mail->subject = "Case ID: ".sprintf("%05d",$case_id)." - ".$mail_subject;
              $mail->message =  "Case ID: ".sprintf("%05d",$case_id)." - ".$mail_message;
              $sendMail = $mail->send_email();

              //-- ส่งอีเมลล์ให้ ผปก. หลังปิดเคส --//
              // if($step==4){}

              if(count($case_ass["case_assign"])>0){
                $to_email = array();
                $to_name = array();
                foreach($case_ass["case_assign"] as $case_assign){
                  if($case_assign["emp_id"]!=$this->admin_id){
                    $sql = "INSERT
                              INTO
                                `Message_Noti_Employee`(
                                  `case_id`,
                                  `emp_id`,
                                  `msgNotiEmp_message`,
                                  `msgNotiEmp_datetime`,
                                  `msgNotiEmp_status`,
                                  `msgNotiEmp_noti_status`,
                                  `msgNotiEmp_read_status`
                                )
                              VALUES(
                                '$case_id',
                                '".$case_assign["emp_id"]."',
                                '&spt; Case ID ".sprintf("%05d",$case_id)." &spt; - $text_noti_sms',
                                NOW(),
                                0,
                                0,
                                0
                              )";
                    $query = $this->dbConn->query($sql);

                    array_push($to_email,$case_assign["emp_email"]);
              			array_push($to_name,$case_assign["emp_firstname"]." ".$case_assign["emp_lastname"]);
                    $form_office = $this->office_data($case_assign["office_id"])["office_name"];
                  }
                }

                //-- ส่งอีเมลล์ให้เจ้าหน้าที่ผู้อื่นที่รับผิดชอบด้วย หลังจากมีกิจกรรมเกิดขึ้น --//
                $mail = new email();
              	$status_can_send = true;
                $sendMail = array();
                $mail->to_email = $to_email;
          			$mail->to_name = $to_name;
                $mail->subject = "Case ID: ".sprintf("%05d",$case_id)." - ".$text_noti_sms;
                $mail->message =  "<a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."\">Case ID: ".sprintf("%05d",$case_id)."</a> - $text_noti_sms  ท่านสามารถดำเนินการเรื่องร้องเรียนที่ท่านได้รับมอบหมายได้ที่ <a href=\"http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."\">http://".$_SERVER["HTTP_HOST"]."/backoffice/index.php?page=case_detail&caseId=".$case_id."</a>";
                $sendMail = $mail->send_email();
              }
              $msgNotiApp_id = $this->dbConn->insert_id;
              $sql_upd_case = "UPDATE
                                `Case` SET
                                  case_step_noti = '$step'
                                  WHERE case_id = '$case_id'
                                  ";
              $qr_upd_case = $this->dbConn->query($sql_upd_case);

          }
    }

    if(!($query && $qr_upd_case)){
      /* Rollback */
      $this->dbConn->rollback();
      $result_send = false;
    }else{
      /* Commit */
      $this->dbConn->commit();

      $msg_noti = new msg_base();
      $this->setting_info();

      $rs_case_sms = $this->get_case_field_data();
      if($method!="assign" && $rs_case_sms["case_feild"]["applnt_mobile"]!=""){
        if(trim($text_noti_sms)!=""){
          $msg_noti->send_sms($case_id,$rs_case_sms["case_feild"]["applnt_mobile"],$text_noti_sms);
        }
      }
      if($this->setting_info["noti_status"]=="1"){
        $msg_noti->send_noti_app($msgNotiApp_id);
      }
    }

    return $result_send;
  }
  public function save_contact($post,$fId_a,$fId_b){

    $status_res = true;
    $qr_contact = true;
    $qr_contact_org = true;

    $comp_type_data = $this->compTypeDetail($post["compType_id"]);

    $type_contact =array($fId_a,$fId_b);
    $idx_fId = 0;
    foreach ($type_contact as $fId) {
      if($idx_fId==0){
        $comp_type = 1;
      }else if($idx_fId==1){
        $comp_type = 2;
      }
      if($comp_type_data["compType_section"]==1){
        if($post["applnt_country_id_IdxFs_".$fId]=="162"){
          $ct_type = 1; //ในประเทส
        }else{
          $ct_type = 2; //ต่างประเทส
        }
      }else if($comp_type_data["compType_section"]==2){
        $ct_type = 1; //ในประเทส
      }
      if($post["applnt_ident_IdxFs_".$fId]!='' || $post["applnt_firstname_IdxFs_".$fId]!='' || $post["applnt_lastname_IdxFs_".$fId]!=''){
        if($post["applnt_ident_IdxFs_".$fId]!=''){
          $sql_contact_chk = "SELECT * FROM `Contact_thai`
                                  WHERE ct_card='".$post["applnt_ident_IdxFs_".$fId]."'
                                  AND ct_section = '$this->admin_section'
                                  AND ct_type = '$ct_type'
                                  AND ct_comp_type = '$ct_comp_type' ";
        }else{
          $sql_contact_chk = "SELECT * FROM `Contact_thai`
                                  WHERE ct_firstname='".$post["applnt_firstname_IdxFs_".$fId]."'
                                  AND ct_lastname = '".$post["applnt_lastname_IdxFs_".$fId]."'
                                  AND ct_section = '$this->admin_section'
                                  AND ct_type = '$ct_type'
                                  AND ct_comp_type = '$comp_type' ";
        }

        $qr_contact_chk = $this->dbConn->query($sql_contact_chk);
        $count_contact_chk = $qr_contact_chk->num_rows;
        $sql_contact = true;
        if($count_contact_chk==0){
          $sql_contact = "INSERT
                              INTO
                                `Contact_thai`(
                                  `ct_section`,
                                  `ct_type`,
                                  `ct_department`,
                                  `ct_comp_type`,
                                  `ct_card`,
                                  `ct_firstname`,
                                  `ct_lastname`,
                                  `ct_birthday`,
                                  `ct_sex`,
                                  `ct_career`,
                                  `ct_homephone`,
                                  `ct_cellphone`,
                                  `ct_email`,
                                  `ct_address`,
                                  `prov_id`,
                                  `ct_postcode`,
                                  `Country_id`,
                                  `ct_import`,
                                  `ct_create_datetime`,
                                  `ct_createBy_id`,
                                  `ct_status`
                                )
                              VALUES(
                                '$this->admin_section',
                                '$ct_type',
                                '1',
                                '$comp_type',
                                '".$post["applnt_ident_IdxFs_".$fId]."',
                                '".$post["applnt_firstname_IdxFs_".$fId]."',
                                '".$post["applnt_lastname_IdxFs_".$fId]."',
                                '".$post["applnt_birthday_IdxFs_".$fId]."',
                                '".$post["applnt_gender_IdxFs_".$fId]."',
                                '".$post["applnt_career_IdxFs_".$fId]."',
                                '".$post["applnt_tel_IdxFs_".$fId]."',
                                '".$post["applnt_mobile_IdxFs_".$fId]."',
                                '".$post["applnt_email_IdxFs_".$fId]."',
                                '".$post["applnt_address_IdxFs_".$fId]."',
                                '".$post["applnt_prov_id_IdxFs_".$fId]."',
                                '".$post["applnt_zipcode_IdxFs_".$fId]."',
                                '".$post["applnt_country_id_IdxFs_".$fId]."',
                                '0',
                                NOW(),
                                '".$this->admin_id."',
                                '0'
                              )";
          if($idx_fId==0 && ($post["applnt_chkType_IdxFs_".$fId]=='')){
            $qr_contact = $this->dbConn->query($sql_contact);
          }
        }else{
          $sql_contact = "UPDATE
                                `Contact_thai`
                              SET
                                `ct_department` = '1',
                                `ct_card` = '".$post["applnt_ident_IdxFs_".$fId]."',
                                `ct_firstname` = '".$post["applnt_firstname_IdxFs_".$fId]."',
                                `ct_lastname` = '".$post["applnt_lastname_IdxFs_".$fId]."',
                                `ct_birthday` = '".$post["applnt_birthday_IdxFs_".$fId]."',
                                `ct_sex` = '".$post["applnt_gender_IdxFs_".$fId]."',
                                `ct_career` = '".$post["applnt_career_IdxFs_".$fId]."',
                                `ct_homephone` = '".$post["applnt_tel_IdxFs_".$fId]."',
                                `ct_cellphone` = '".$post["applnt_mobile_IdxFs_".$fId]."',
                                `ct_email` = '".$post["applnt_address_IdxFs_".$fId]."',
                                `ct_address` = '".$post["applnt_address_IdxFs_".$fId]."',
                                `prov_id` = '".$post["applnt_prov_id_IdxFs_".$fId]."',
                                `ct_postcode` = '".$post["applnt_zipcode_IdxFs_".$fId]."',
                                `Country_id` = '".$post["applnt_country_id_IdxFs_".$fId]."',
                                `ct_update_datetime` = NOW(),
                                `ct_updateBy_id` = '".$this->admin_id."'
                              WHERE `ct_card` = '".$post["applnt_ident_IdxFs_".$fId]."'
                              AND ct_section = '$this->admin_section'
                              AND ct_type = '$ct_type'
                              AND ct_comp_type = '$ct_comp_type' ";

          if($idx_fId==0 && ($post["applnt_chkType_IdxFs_".$fId]=='')){
            $qr_contact = $this->dbConn->query($sql_contact);
          }
        }

      }


      if($idx_fId==0){
        $post["applntOrg_contact_name_IdxFs_".$fId] = $post["applnt_firstname_IdxFs_".$fId]." ".$post["applnt_lastname_IdxFs_".$fId];

      }else if($idx_fId==1){
        $post["applntOrg_trade_number_IdxFs_".$fId] = $post["complnt_trade_number_IdxFs_".$fId];
        $post["applntOrg_name_IdxFs_".$fId] = $post["complnt_name_IdxFs_".$fId];
        $post["applntOrg_import_export_IdxFs_".$fId] = $post["complnt_import_export_IdxFs_".$fId];
        $post["applntOrg_branch_IdxFs_".$fId] = $post["complnt_branch_IdxFs_".$fId];
        $post["applntOrg_tel_IdxFs_".$fId] = $post["complnt_contact_tel_IdxFs_".$fId];
        $post["applntOrg_fax_IdxFs_".$fId] = $post["complnt_contact_email_IdxFs_".$fId];
        $post["applntOrg_email_IdxFs_".$fId] = $post["complnt_contact_email_IdxFs_".$fId];
        $post["applntOrg_address_IdxFs_1".$fId] = $post["complnt_contact_address_IdxFs_".$fId];
        $post["applntOrg_prov_id_IdxFs_".$fId] = $post["complnt_prov_id_IdxFs_".$fId];
        $post["applntOrg_zipcode_IdxFs_".$fId] = $post["complnt_zipcode_IdxFs_".$fId];
        $post["applnt_valid_dbd_IdxFs_".$fId] = '';
        $post["applntOrg_country_id_IdxFs_".$fId] = $post["complnt_country_id_IdxFs_".$fId];
        $post["applntOrg_contact_name_IdxFs_".$fId] = $post["complnt_contact_name_IdxFs_".$fId];
      }

      if($comp_type_data["compType_section"]==1){
        if($post["applntOrg_country_id_IdxFs_".$fId]=="162"){
          $cpr_type = 1; //ในประเทส
        }else{
          $cpr_type = 2; //ต่างประเทส
        }
      }else if($comp_type_data["compType_section"]==2){
        $cpr_type = 1; //ในประเทส
      }


      if(($idx_fId==0 && ($post["applnt_chkType_IdxFs_".$fId]!='')) || ($idx_fId==1) ){
        /*if($fId==3 || $fId==4){
          $condition_contact_chk = "cpr_companyname = '".$post["applnt_ident_IdxFs_".$fId]."'";
        }else{*/
        //}

        if($post["applntOrg_trade_number_IdxFs_".$fId]!=''){
          $sql_contact_chk = "SELECT * FROM `Corporate`
                                  WHERE cpr_numbertrade = '".$post["applntOrg_trade_number_IdxFs_".$fId]."'
                                  AND cpr_section = '$this->admin_section'
                                  AND cpr_type = '$cpr_type'
                                  AND cpr_comp_type = '$comp_type'
                                  ";
        }else{
          $sql_contact_chk = "SELECT * FROM `Corporate`
                                  WHERE cpr_companyname = '".$post["applntOrg_name_IdxFs_".$fId]."'
                                  AND cpr_section = '$this->admin_section'
                                  AND cpr_type = '$cpr_type'
                                  AND cpr_comp_type = '$comp_type'
                                  ";
        }
        $qr_contact_chk = $this->dbConn->query($sql_contact_chk);
        $count_contact_chk = $qr_contact_chk->num_rows;
        if($count_contact_chk==0){
          $sql_contact_org = "INSERT
                                INTO
                                  `Corporate`(
                                    `cpr_section`,
                                    `cpr_type`,
                                    `cpr_comp_type`,
                                    `cpr_numbertrade`,
                                    `cpr_companyname`,
                                    `cpr_type_import_export`,
                                    `cpr_branch`,
                                    `cpr_telephone`,
                                    `cpr_fax`,
                                    `cpr_email`,
                                    `cpr_address`,
                                    `prov_id`,
                                    `cpr_zipcode`,
                                    `cpr_department`,
                                    `Country_id`,
                                    `cpr_contact_person`,
                                    `cpr_import`,
                                    `cpr_create_datetime`,
                                    `cpr_createBy_id`,
                                    `cpr_ststus`
                                  )
                                VALUES(
                                  '$this->admin_section',
                                  '$cpr_type',
                                  '$comp_type',
                                  '".$post["applntOrg_trade_number_IdxFs_".$fId]."',
                                  '".$post["applntOrg_name_IdxFs_".$fId]."',
                                  '".$post["applntOrg_import_export_IdxFs_".$fId]."',
                                  '".$post["applntOrg_branch_IdxFs_".$fId]."',
                                  '".$post["applntOrg_tel_IdxFs_".$fId]."',
                                  '".$post["applntOrg_fax_IdxFs_".$fId]."',
                                  '".$post["applntOrg_email_IdxFs_".$fId]."',
                                  '".$post["applntOrg_address_IdxFs_1".$fId]."',
                                  '".$post["applntOrg_prov_id_IdxFs_".$fId]."',
                                  '".$post["applntOrg_zipcode_IdxFs_".$fId]."',
                                  '".$post["applnt_valid_dbd_IdxFs_".$fId]."',
                                  '".$post["complnt_country_id_IdxFs_".$fId]."',
                                  '".$post["complnt_contact_name_IdxFs_".$fId]."',
                                  '0',
                                  NOW(),
                                  '".$this->admin_id."',
                                  '0'
                                )";
          $qr_contact_org = $this->dbConn->query($sql_contact_org);
        }else{
          $sql_contact_org = "UPDATE
                                `Corporate`
                              SET
                              cpr_numbertrade = '".$post["applntOrg_trade_number_IdxFs_".$fId]."',
                              cpr_companyname = '".$post["applntOrg_name_IdxFs_".$fId]."',
                              cpr_type_import_export = '".$post["applntOrg_import_export_IdxFs_".$fId]."',
                              cpr_branch = '".$post["applntOrg_branch_IdxFs_".$fId]."',
                              cpr_telephone = '".$post["applntOrg_tel_IdxFs_".$fId]."',
                              cpr_fax = '".$post["applntOrg_fax_IdxFs_".$fId]."',
                              cpr_email = '".$post["applntOrg_email_IdxFs_".$fId]."',
                              cpr_address = '".$post["applntOrg_address_IdxFs_1".$fId]."',
                              prov_id = '".$post["applntOrg_prov_id_IdxFs_".$fId]."',
                              cpr_zipcode = '".$post["applntOrg_zipcode_IdxFs_".$fId]."',
                              cpr_department = '".$post["applnt_valid_dbd_IdxFs_".$fId]."',
                              Country_id = '".$post["complnt_country_id_IdxFs_".$fId]."',
                              cpr_contact_person = '".$post["complnt_contact_name_IdxFs_".$fId]."',
                              cpr_update_datetime = NOW(),
                              cpr_updateBy_id = '".$this->admin_id."'
                              WHERE `cpr_numbertrade` = '".$post["applntOrg_trade_number_IdxFs_".$fId]."'
                              AND cpr_section = '$this->admin_section'
                              AND cpr_type = '$cpr_type'
                              AND cpr_comp_type = '$cpr_comp_type' ";
          $qr_contact_org = $this->dbConn->query($sql_contact_org);
        }

      }

      $idx_fId++;
    }
    return $status_res;
  }
  //-- ฟังก์ชั่นบันทึก Case --//
  public function save_case($post,$file){

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();

    $fId_a = $post["formSetId_a"];
    $fId_b = $post["formSetId_b"];
    $fId_c = $post["formSetId_c"];

    foreach($post as $key => $value) {
      if(is_array($value)){
        foreach($value as $key1 => $value1) {
          $post[$key][$key1] = $this->data_filter($value1);
        }
      }else{
        if(!($key=="caseDtl_derivation_IdxFs_".$fId_c || $key=="caseDtl_complnt_need_IdxFs_".$fId_c)){
          $post[$key] = $this->data_filter($value);
        }
      }
    }

    $status_response = "00";
    $status_response_text = "success";


    if($post["caseCh_id"]==""){
      $status_response = "02";
      $status_response_text = "กรุณาเลือกช่องทางการรับเรื่องร้องเรียน";
    }

    $post["case_open_date"] =  DateTime::createFromFormat('d/m/Y', $post["case_open_date"])->format('Y-m-d');
    $post["case_receivedoc_date"] = DateTime::createFromFormat('d/m/Y', $post["case_receivedoc_date"])->format('Y-m-d');

    if($post["caseCh_type"]==2){
        $post["case_status"] = '1';
        $post["case_open_date"] = date('Y-m-d');
    }else{
        $post["case_status"] = '0';
    }

    $comp_type_data = $this->compTypeDetail($post["compType_id"]);

    $sql_frm = "SELECT * FROM `Form_Link_Complaint_Type` WHERE `frmset_id`='$fId_a' ";
    $qr_frm = $this->dbConn->query($sql_frm);
    $rs_frm = $qr_frm->fetch_assoc();
    $frm_name[$fId_a] = $rs_frm["frmset_name"];

    $sql_frm = "SELECT * FROM `Form_Link_Complaint_Type` WHERE `frmset_id`='$fId_b' ";
    $qr_frm = $this->dbConn->query($sql_frm);
    $rs_frm = $qr_frm->fetch_assoc();
    $frm_name[$fId_b] = $rs_frm["frmset_name"];

    $sql_frm = "SELECT * FROM `Form_Link_Complaint_Type` WHERE `frmset_id`='$fId_c' ";
    $qr_frm = $this->dbConn->query($sql_frm);
    $rs_frm = $qr_frm->fetch_assoc();
    $frm_name[$fId_c] = $rs_frm["frmset_name"];

    // $sql_frm = "SELECT * FROM `Product_Type` WHERE `prodType_id`= '".$post['prodType_id_IdxFs_'.$fId_c]."' ";
    // $qr_frm = $this->dbConn->query($sql_frm);
    // echo $post['office_type_IdxFs_'.$fId_c];
    // exit();
    if($post['office_type_IdxFs_'.$fId_c] != ""){
      $office = $post['office_type_IdxFs_'.$fId_c];
    }else {
      $office = '0';
    }
    if($post["compType_id"]==6){
      $office = '0';
    }


    if($post["applnt_birthday_IdxFs_".$fId_a]!=""){
      $post["applnt_birthday_IdxFs_".$fId_a] = DateTime::createFromFormat('d/m/Y', $post["applnt_birthday_IdxFs_".$fId_a])->format('Y-m-d');
    }
    if($post["applnt_birthday_IdxFs_".$fId_b]!=""){
      $post["applnt_birthday_IdxFs_".$fId_b] = DateTime::createFromFormat('d/m/Y', $post["applnt_birthday_IdxFs_".$fId_b])->format('Y-m-d');
    }

    $removeIdx = explode(",",$post["removeFileAttachId"]);

    //-- ถ้าติ๊กไม่มีข้อมูลผู้ร้องเรียน --//
    if(!isset($post["applnt_status_IdxFs_".$fId_a])){
      $post["applnt_status_IdxFs_".$fId_a] = "";
    }

    if(!isset($post["applnt_chkType_IdxFs_".$fId_a])){
      $post["applnt_type_IdxFs_".$fId_a] = "";
    }

    $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
    $qr_field = $this->dbConn->query($sql_field);

    $col_case = "";
    $value_case = "";
    $sql_field_case = "SELECT * FROM `Case` ";
    $qr_field_case = $this->dbConn->query($sql_field_case);
    $fieldinfo_case=mysqli_fetch_fields($qr_field_case);
    while($rs_field = $qr_field->fetch_assoc()){
      foreach ($post as $key => $value) {
        $keySplit = explode('_IdxFs_',$key);
        if($rs_field["fieldset_name"]==$keySplit[0]){
          foreach ($fieldinfo_case as $fieldCase){
            if($fieldCase->name==$rs_field["fieldset_name"]){
              $col_case  .= ", `".$rs_field["fieldset_name"]."` ";
              $value_case  .= ", '$value' ";
            }
          }
        }
      }
    }

    $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
    $qr_field = $this->dbConn->query($sql_field);
    while($rs_field = $qr_field->fetch_assoc()){
      foreach ($post as $key => $value) {
        $keySplit = explode('_IdxFs_',$key);
        if($rs_field["fieldset_name"]==$keySplit[0]){
          if($rs_field["fieldset_require"]=="1"){
            if($post[$key]==""){
              $desTextAlert = $rs_field["fieldset_description"];
              $text_n = array(1,2,5,6);
              $select_n = array(3,4,7,8,9);
              $desType = $rs_field["fieldset_type"];
              if(in_array($desType,$text_n)){
                $initTextAlert = "กรุณาระบุ";
                $typeInput = "input";
              }
              if(in_array($desType,$select_n)){
                $initTextAlert = "กรุณาเลือก";
                $typeInput = "select";
              }
              $status_response = "02";
              if($status_response_text=="success"){
                if($rs_field["frmset_id"]==$fId_a){
                  $frmTextAlert = $frm_name[$fId_a];
                }else if($rs_field["frmset_id"]==$fId_b){
                  $frmTextAlert = $frm_name[$fId_b];
                }else if($rs_field["frmset_id"]==$fId_c){
                  $frmTextAlert = $frm_name[$fId_c];
                }
                $field_focus = $key;
                //$field_focus = 'window.parent.document.getElementByTagName("'.$typeInput.'").getAttribute("'.$typeInput.'").focus();';
                $status_response_text = $initTextAlert.$desTextAlert." ของ".$frmTextAlert;
              }
            }
          }

          if($rs_field["fieldset_type"]=="10"){
            /*if(!$this->validateDate($post[$key])){
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบวันที่ ".$desTextAlert."ไม่ถูกต้อง !";
              }
            }*/
          }else if($rs_field["fieldset_type"]=="3"){
            /*if(!$this->validateFormat($post[$key],'/^\d+(:?[.]\d{2})$/')){
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง !";
              }
            }*/
          }else if($rs_field["fieldset_type"]=="7"){
            if(!($post[$key]=="" || $post[$key]==1)){
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง !";
              }
            }
          }else if($rs_field["fieldset_type"]=="11"){
            if (!(filter_var($post[$key], FILTER_VALIDATE_EMAIL)) && $post[$key]!="") {
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง กรุณาระบุ ".$desTextAlert." ในรูปแบบที่ถูกต้องเช่น example@gmail.com";
              }
            }
          }

        }
      }

    }

    if($status_response=="00"){

      //-- บันทึก ข้อมูล Case --//
      $sql_ins_case = "INSERT
                        INTO
                        `Case`(
                          `compType_id`,
                          `compTypeSub1_id`,
                          `compTypeSub2_id`,
                          `compType_other`,
                          `case_status`,
                          `caseCh_id`,
                          `case_priority`,
                          `case_compType_duration`,
                          `case_open_date`,
                          `case_receivedoc_date`,
                          `case_receivedoc_number`
                          $col_case
                          ,`case_create_datetime`
                          ,`case_createBy_id`
                          ,`office_id`
                        )
                        VALUES ('".$post["compType_id"]."',
                        '".$post["compTypeSub1_id"]."',
                        '".$post["compTypeSub2_id"]."',
                        '".$post["compType_other"]."',
                        '".$post["case_status"]."',
                        '".$post["caseCh_id"]."',
                        '".$post["case_priority"]."',
                        '".$comp_type_data["compType_duration"]."',
                        '".$post["case_open_date"]."',
                        '".$post["case_receivedoc_date"]."',
                        '".$post["case_receivedoc_number"]."'
                        $value_case
                        ,NOW()
                        ,'".$this->admin_id."'
                        ,'".$office."' )";

      $qr_ins_case = $this->dbConn->query($sql_ins_case);
      if($qr_ins_case){

        $last_case_id = $this->dbConn->insert_id;

        $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
        $qr_field = $this->dbConn->query($sql_field);
        while($rs_field = $qr_field->fetch_assoc()){
          foreach ($post as $key => $value) {
            $keySplit = explode('_IdxFs_',$key);
            if($rs_field["fieldset_name"]==$keySplit[0]){
              $sql_ins_field = "INSERT INTO `Field_Values`(`case_id`, `fieldset_id`, `fieldset_value`)
                                VALUE (
                                  '$last_case_id', '".$rs_field["fieldset_id"]."', '$value'
                                )";
              $qr_ins_field = $this->dbConn->query($sql_ins_field);
              if(!$qr_ins_field){
                $status_response = "01";
                $status_response_text = "Error SQL!";
              }
            }
          }
        }


        $this->save_contact($post,$fId_a,$fId_b);

          //-- บันทึก เอกสารรับเรื่อง --//
          if($file["case_receivedoc_file"]["name"]!=""){

            $ext = pathinfo($file["case_receivedoc_file"]["name"], PATHINFO_EXTENSION);
            $new_filename = "case_receivedoc_".$last_case_id."_".time().".".$ext;
            $new_filepath = "data/case_receive/$last_case_id/$new_filename";

             if(!in_array($ext,$this->file_accept)){
                 $status_response = "02";
                 $status_response_text = "รูปแบบไฟล์เอกสารรับเรื่องไม่ถูกต้อง !";
             }else{

              $this->deleteDirectory("../data/case_receive/$last_case_id");

              if(!is_dir("../data/case_receive")){
                mkdir("../data/case_receive", 0775, true);
              }
              if(!is_dir("../data/case_receive/$last_case_id")){
                mkdir("../data/case_receive/$last_case_id", 0775, true);
              }

              if(!(move_uploaded_file($file["case_receivedoc_file"]["tmp_name"],"../".$new_filepath))){
                  $status_response = "02";
                  $status_response_text = "การอัพโหลดเอกสารรับเรื่องผิดพลาด";
              }else{
                $sql_upd_fileRecivecase = "UPDATE `Case` SET `case_receivedoc_file_path`='$new_filepath',`case_receivedoc_file_oldname`='".$file["case_receivedoc_file"]["name"]."', `case_receivedoc_file_name`='$new_filename', `case_receivedoc_file_ext`='$ext'
                                 WHERE `case_id`='$last_case_id' ";
                $qr_upd_fileRecivecase= $this->dbConn->query($sql_upd_fileRecivecase);

                if(!$qr_upd_fileRecivecase){
                  $status_response = "01";
                  $status_response_text = "Error SQL!";
                }
              }
            }
          }

          //-- บันทึกเอกสารประกอบการร้องเรียน --//
          $total_fileAttach = count($file['caseAttach_file']["name"]);
          if($total_fileAttach>0){

            $sql_del_caseAttach = "DELETE FROM `Case_Attachfile` WHERE `case_id`='$last_case_id' ";
            $qr_del_caseAttach = $this->dbConn->query($sql_del_caseAttach);

            if($qr_del_caseAttach){

              $this->deleteDirectory("../data/case_attach/$last_case_id");

              $removeIdx = explode(",",$post["removeFileAttachNewId"]);

              // Loop through each file
              for($i=0; $i<$total_fileAttach; $i++) {
                if(count($removeIdx)==1 || count($removeIdx)>1 && !in_array($i,$removeIdx)){
                  if($file["caseAttach_file"]["name"][$i]!=""){
                    if($post["caseAttach_file_name"][$i]!=""){

                        $ext = pathinfo($file["caseAttach_file"]["name"][$i], PATHINFO_EXTENSION);
                        $new_filename = "caseAttach_file_".$last_case_id."_".time().$i.".".$ext;
                        $new_filepath = "data/case_attach/$last_case_id/$new_filename";
                        $size_filename = filesize($file["caseAttach_file"]["tmp_name"][$i]);

                        if(!in_array($ext,$this->file_accept)){
                            $status_response = "02";
                            $status_response_text = "รูปแบบไฟล์เอกสารประกอบเรื่องร้องเรียนไม่ถูกต้อง !";
                        }else{


                         if(!is_dir("../data/case_attach")){
                           mkdir("../data/case_attach", 0775, true);
                         }
                         if(!is_dir("../data/case_attach/$last_case_id")){
                           mkdir("../data/case_attach/$last_case_id", 0775, true);
                         }

                         if(!(move_uploaded_file($file["caseAttach_file"]["tmp_name"][$i],"../".$new_filepath))){
                             $status_response = "02";
                             $status_response_text = "การอัพโหลดเอกสารประกอบเรื่องร้องเรียนผิดพลาด";
                         }else{
                           $sql_ins_caseAttach = "INSERT INTO `Case_Attachfile`( `case_id`, `caseAttach_title`, `caseAttach_file_path`, `caseAttach_file_oldname`, `caseAttach_file_name`, `caseAttach_file_ext`, `caseAttach_status`, `caseAttach_create_datetime`, `caseAttach_createBy_id`)
                           VALUE ('$last_case_id','".$post["caseAttach_file_name"][$i]."','$new_filepath','".$file["caseAttach_file"]["name"][$i]."','$new_filename','$ext',0,NOW(),'".$this->admin_id."')";
                           $qr_ins_caseAttach = $this->dbConn->query($sql_ins_caseAttach);

                           if(!$qr_ins_caseAttach){
                             $status_response = "01";
                             $status_response_text = "Error SQL!";
                           }
                         }
                       }
                    }else{
                       $status_response = "02";
                       $status_response_text = "กรุณาระบุหัวข้อของไฟล์แนบให้ครบถ้วน!";
                    }
                  }
                }
             }
             }else{
                 $status_response = "01";
                 $status_response_text = "Error SQL!";
             }

           }
      }else{
          $status_response = "01";
          $status_response_text = "Error SQL!";
      }
    }

    if($status_response=="00"){
      /* commit insert */
      $this->dbConn->commit();

      /* Log insert */
      $type_log = "00";
      $case_id = $last_case_id;
      $text = "สร้างเรื่องร้องเรียน";
      $this->save_log($type_log,$case_id,null,$text);
    }else{
      /* Rollback */
      $this->dbConn->rollback();

    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'field_focus' => $field_focus,'last_case_id'=>$last_case_id);

  }

  //-- ฟังก์ชั่นบันทึกแก้ไข Case --//
  public function update_case($post,$file){

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();


    $fId_a = $post["formSetId_a"];
    $fId_b = $post["formSetId_b"];
    $fId_c = $post["formSetId_c"];

    foreach($post as $key => $value) {
      if(is_array($value)){
        foreach($value as $key1 => $value1) {
          $post[$key][$key1] = $this->data_filter($value1);
        }
      }else{
        if(!($key=="caseDtl_derivation_IdxFs_".$fId_c || $key=="caseDtl_complnt_need_IdxFs_".$fId_c)){
          $post[$key] = $this->data_filter($value);
        }
      }
    }


    $status_response = "00";
    $status_response_text = "success";

    $post["case_open_date"] =  DateTime::createFromFormat('d/m/Y', $post["case_open_date"])->format('Y-m-d');
    $post["case_receivedoc_date"] = DateTime::createFromFormat('d/m/Y', $post["case_receivedoc_date"])->format('Y-m-d');

    if($post["caseCh_type"]==2){
        $post["case_status"] = '1';
    }
    $comp_type_data = $this->compTypeDetail($post["compType_id"]);

    if($post["applnt_birthday_IdxFs_".$fId_a]!=""){
      $post["applnt_birthday_IdxFs_".$fId_a] = DateTime::createFromFormat('d/m/Y', $post["applnt_birthday_IdxFs_".$fId_a])->format('Y-m-d');
    }
    if($post["applnt_birthday_IdxFs_".$fId_b]!=""){
      $post["applnt_birthday_IdxFs_".$fId_b] = DateTime::createFromFormat('d/m/Y', $post["applnt_birthday_IdxFs_".$fId_b])->format('Y-m-d');
    }


    $post["case_id"] = (int)$post["case_id"];

    //-- ถ้าติ๊กไม่มีข้อมูลผู้ร้องเรียน --//
    if(!isset($post["applnt_status_IdxFs_".$fId_a])){
      $post["applnt_status_IdxFs_".$fId_a] = "";
    }

    if(!isset($post["applnt_chkType_IdxFs_".$fId_a])){
      $post["applnt_type_IdxFs_".$fId_a] = "";
    }

    $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
    $qr_field = $this->dbConn->query($sql_field);


    $sql_field_case = "SELECT * FROM `Case` ";
    $qr_field_case = $this->dbConn->query($sql_field_case);
    $fieldinfo_case=mysqli_fetch_fields($qr_field_case);
    while($rs_field = $qr_field->fetch_assoc()){
      foreach ($post as $key => $value) {
        $keySplit = explode('_IdxFs_',$key);
        if($rs_field["fieldset_name"]==$keySplit[0]){
          foreach ($fieldinfo_case as $fieldCase){
            if($fieldCase->name==$rs_field["fieldset_name"]){
              $set_case  .= ", `".$rs_field["fieldset_name"]."` = '$value' ";
            }
          }
        }
      }
    }

    $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
    $qr_field = $this->dbConn->query($sql_field);
    while($rs_field = $qr_field->fetch_assoc()){
      foreach ($post as $key => $value) {
        $keySplit = explode('_IdxFs_',$key);

        if($rs_field["fieldset_name"]==$keySplit[0]){

          if($rs_field["fieldset_require"]=="1"){
            if($post[$key]==""){
              $desTextAlert = $rs_field["fieldset_description"];
              $text_n = array(1,2,3,5,6,10);
              $select_n = array(4,7,8,9);
              $desType = $rs_field["fieldset_type"];
              if(in_array($desType,$text_n)){
                $initTextAlert = "กรุณาระบุ ";
              }
              if(in_array($desType,$select_n)){
                $initTextAlert = "กรุณาเลือก ";
              }
              $status_response = "02";
              if($status_response == "02"){
                $status_response_text = $initTextAlert.$desTextAlert;
              }
            }
          }

          if($rs_field["fieldset_type"]=="10"){
            /*if(!$this->validateDate($post[$key]/*)){
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบวันที่ ".$desTextAlert."ไม่ถูกต้อง !";
              }
            }*/
          }else if($rs_field["fieldset_type"]=="3"){
            /*if(!$this->validateFormat($post[$key],'/^\d+(:?[.]\d{2})$/')){
              $status_response = "02";
              if($status_response_text=="success"){
              $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง  กรุณาระบุ ".$desTextAlert." ในรูปแบบที่ถูกต้องเช่น 01/01/2017";
              }
            }*/
          }else if($rs_field["fieldset_type"]=="7"){
            if(!($post[$key]=="" || $post[$key]==1)){
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง !";
              }
            }
          }else if($rs_field["fieldset_type"]=="11"){
            if (!(filter_var($post[$key], FILTER_VALIDATE_EMAIL)) && $post[$key]!="") {
              $status_response = "02";
              if($status_response_text=="success"){
                $desTextAlert = $rs_field["fieldset_description"];
                $status_response_text = "รูปแบบ ".$desTextAlert." ไม่ถูกต้อง กรุณาระบุ ".$desTextAlert." ในรูปแบบที่ถูกต้องเช่น example@gmail.com";
              }
            }
          }

        }
      }

    }
    if($status_response=="00"){
      //-- บันทึก ข้อมูล Case --//
      $sql_upd_case = "UPDATE
                        `Case` SET
                          `compType_id`='".$post["compType_id"]."',
                          `compTypeSub1_id`='".$post["compTypeSub1_id"]."',
                          `compTypeSub2_id`='".$post["compTypeSub2_id"]."',
                          `caseCh_id`='".$post["caseCh_id"]."',
                          `case_priority`='".$post["case_priority"]."',
                          `case_compType_duration`='".$comp_type_data["compType_duration"]."',
                          `case_open_date`='".$post["case_open_date"]."',
                          `case_receivedoc_date`='".$post["case_receivedoc_date"]."',
                          `case_receivedoc_number`='".$post["case_receivedoc_number"]."'
                          $set_case
                          ,`case_update_datetime`=NOW()
                          ,`case_updateBy_id`='".$this->admin_id."' ";


      $sql_upd_case  .= "WHERE case_id='".$post["case_id"]."' ";
      $qr_upd_case = $this->dbConn->query($sql_upd_case);
      if($qr_upd_case){
        $last_case_id = $post["case_id"];
        $sql_field = "SELECT * FROM `Field_Set` WHERE `frmset_id`='$fId_a' OR `frmset_id`='$fId_b' OR `frmset_id`='$fId_c' ";
        $qr_field = $this->dbConn->query($sql_field);
        while($rs_field = $qr_field->fetch_assoc()){
          foreach ($post as $key => $value) {
            $keySplit = explode('_IdxFs_',$key);

            if($rs_field["fieldset_name"]==$keySplit[0]){

              $sql_chk_field = "SELECT *  FROM `Field_Values`
                                WHERE `case_id` = '$last_case_id'
                                AND `fieldset_id` = '".$rs_field["fieldset_id"]."' ";
              $qr_chk_field = $this->dbConn->query($sql_chk_field);
              $num_chk_field = $qr_chk_field->num_rows;
              $sql_upd_field="";
              if($num_chk_field>0){
              $sql_upd_field = "UPDATE `Field_Values`
                                SET `fieldset_value` = '$value'
                                WHERE `case_id` = '$last_case_id'
                                AND `fieldset_id` = '".$rs_field["fieldset_id"]."' ";
              }else{
                $sql_upd_field = "INSERT INTO
                                  `Field_Values`(
                                    `fieldset_value`,
                                    `case_id`,
                                    `fieldset_id`
                                  )
                                  VALUES
                                  (
                                    '$value',
                                    '$last_case_id',
                                    '".$rs_field["fieldset_id"]."'
                                  ) ";
              }
              $qr_upd_field = $this->dbConn->query($sql_upd_field);
              if(!$qr_upd_field){
                $status_response = "01";
                $status_response_text = "Error Field SQL!";
              }
            }
          }

        }

        $this->save_contact($post,$fId_a,$fId_b);

        //-- บันทึก เอกสารรับเรื่อง --//
        if($file["case_receivedoc_file"]["name"]!=""){

          $ext = pathinfo($file["case_receivedoc_file"]["name"], PATHINFO_EXTENSION);
          $new_filename = "case_receivedoc_".$last_case_id."_".time().".".$ext;
          $new_filepath = "data/case_receive/$last_case_id/$new_filename";

           if(!in_array($ext,$this->file_accept)){
               $status_response = "02";
               $status_response_text = "รูปแบบไฟล์เอกสารรับเรื่องไม่ถูกต้อง !";
           }else{

            $this->deleteDirectory("../data/case_receive/$last_case_id");

            if(!is_dir("../data/case_receive")){
              mkdir("../data/case_receive", 0775, true);
            }
            if(!is_dir("../data/case_receive/$last_case_id")){
              mkdir("../data/case_receive/$last_case_id", 0775, true);
            }

            if(!(move_uploaded_file($file["case_receivedoc_file"]["tmp_name"],"../".$new_filepath))){
                $status_response = "02";
                $status_response_text = "การอัพโหลดเอกสารรับเรื่องผิดพลาด";
            }else{
              $sql_upd_fileRecivecase = "UPDATE `Case`
                                        SET
                                        `case_receivedoc_file_path`='$new_filepath',
                                        `case_receivedoc_file_oldname`='".$file["case_receivedoc_file"]["name"]."',
                                        `case_receivedoc_file_name`='$new_filename',
                                        `case_receivedoc_file_ext`='$ext'
                                         WHERE `case_id`='$last_case_id'
                                         ";
              $qr_upd_fileRecivecase= $this->dbConn->query($sql_upd_fileRecivecase);

              if(!$qr_upd_fileRecivecase){
                $status_response = "01";
                $status_response_text = "Error File Recive SQL!";
              }
            }
          }
        }
        ///-- บันทึก เอกสารประกอบเรื่องร้องรียน --//
        $total_fileAttach = count($file['caseAttach_file']["name"]);

          // $status_response = "02";
          // $status_response_text = $total_fileAttach;
          if($total_fileAttach>0){
            $removeIdx = explode(",",$post["removeFileAttachNewId"]);

            // Loop through each file
            for($i=0; $i<$total_fileAttach; $i++) {
              if(count($removeIdx)==1 || count($removeIdx)>1 && !in_array($i,$removeIdx)){
                if($file["caseAttach_file"]["name"][$i]!=""){
                  if($post["caseAttach_file_name"][$i]!=""){
                    $ext = pathinfo($file["caseAttach_file"]["name"][$i], PATHINFO_EXTENSION);
                    $new_filename = "caseAttach_file_".$last_case_id."_".time().$i.".".$ext;
                    $new_filepath = "data/case_attach/$last_case_id/$new_filename";

                    if(!in_array($ext,$this->file_accept)){
                        $status_response = "02";
                        $status_response_text = "รูปแบบไฟล์เอกสารประกอบเรื่องร้องเรียนไม่ถูกต้อง !";
                    }else{


                     if(!is_dir("../data/case_attach")){
                       mkdir("../data/case_attach", 0775, true);
                     }
                     if(!is_dir("../data/case_attach/$last_case_id")){
                       mkdir("../data/case_attach/$last_case_id", 0775, true);
                     }

                     if(!(move_uploaded_file($file["caseAttach_file"]["tmp_name"][$i],"../".$new_filepath))){
                         $status_response = "02";
                         $status_response_text = "การอัพโหลดเอกสารประกอบเรื่องร้องเรียนผิดพลาด";
                     }else{
                       $sql_ins_caseAttach = "INSERT
                       INTO `Case_Attachfile`
                       ( `case_id`, `caseAttach_title`, `caseAttach_file_path`, `caseAttach_file_oldname`, `caseAttach_file_name`, `caseAttach_file_ext`, `caseAttach_status`,`caseAttach_create_datetime`,`caseAttach_createBy_id`)
                       VALUE ('$last_case_id','".$post["caseAttach_file_name"][$i]."','$new_filepath','".$file["caseAttach_file"]["name"][$i]."','$new_filename','$ext',0,NOW(),'".$this->admin_id."')";
                       $qr_ins_caseAttach = $this->dbConn->query($sql_ins_caseAttach);

                       if(!$qr_ins_caseAttach){
                         $status_response = "01";
                         $status_response_text = "Error File Attach SQL!";
                       }
                     }
                   }
                 }else{
                   $status_response = "02";
                   $status_response_text = "กรุณาระบุหัวข้อของไฟล์แนบให้ครบถ้วน!";
                 }
               }
             }
           }
          }

       // Loop through title file
       for($i=0; $i<count($post["caseAttach_file_name_old"]); $i++) {
         if($post["caseAttach_file_id"][$i]!=""){
           if($post["caseAttach_file_name_old"][$i]!=""){
             $sql_upd_caseAttach = "UPDATE `Case_Attachfile`
                                    SET
                                    `caseAttach_title`='".$post["caseAttach_file_name_old"][$i]."'
                                    WHERE caseAttach_id = '".$post["caseAttach_file_id"][$i]."' ";
             $qr_upd_caseAttach = $this->dbConn->query($sql_upd_caseAttach);
             if(!$qr_upd_caseAttach){
               $status_response = "01";
               $status_response_text = "Error File Attach Change Title SQL!";
             }
           }else{
             $status_response = "02";
             $status_response_text = "กรุณาระบุหัวข้อของไฟล์แนบให้ครบถ้วน!";
           }
         }
       }

       //-- ลบ เอกสารประกอบเรื่องร้องรียน (ถ้ามี)--//
       if($post["removeFileAttachId"]!=""){
         $sql_upd_caseAttach = "UPDATE `Case_Attachfile`
                                SET
                                `caseAttach_status`='1'
                                WHERE caseAttach_id IN (".$post["removeFileAttachId"].") ";
         $qr_upd_caseAttach = $this->dbConn->query($sql_upd_caseAttach);
         if(!$qr_upd_caseAttach){
           $status_response = "01";
           $status_response_text = "Error File Attach Delete SQL!";
         }
       }

      }else{
          $status_response = "01";
          $status_response_text = "Error Case SQL!";
      }
    }

    if($status_response=="00"){
      /* commit insert */
      $this->dbConn->commit();

      /* Log insert */
      $type_log = "01";
      $case_id = $last_case_id;
      $text = "แก้ไขเรื่องร้องเรียน";
      $this->save_log($type_log,$case_id,null,$text);

    }else{
      /* Rollback */
      $this->dbConn->rollback();

    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_case_id'=>$last_case_id);

  }

  //-- ฟังก์ชั่นบันทึกค่าประเภทเรื่องร้องเรียนจาก Case ID --//
  public function save_open_case($post){

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();

    $status_response = "00";
    $status_response_text = "success";

    $case_id = $post["case_id"];
    $case_channal = $post["case_channal"];
    $typeOfSave = $post["typeOfSave"];

    $this->case_id = $case_id;

    if($typeOfSave=="open_case"){
      $sql_open_case = ",case_step_detail = '1' ";
      $status_response = "03";
    }

    if($case_channal==1 || $case_channal==2){
        $sql_status_case = ",case_status = '1'
                            ,case_notice_applnt_datetime = NOW()
                            ,case_notice_applnt_createBy_id = '".$this->admin_id."'";
    }else{
          $sql_status_case = ",case_status = '1' ";
    }
    $sql_upd_case = "UPDATE
                      `Case` SET
                        case_lastSave_datetime = NOW()
                        ,case_lastSave_id = '".$this->admin_id."'
                        $sql_open_case
                        $sql_status_case
                        WHERE case_id = '".$case_id."'
                        ";
    $qr_upd_case = $this->dbConn->query($sql_upd_case);
    if(!$qr_upd_case){
      $status_response="01";
      $status_response_text = "$sql_upd_case";

    }else{
      $rs_case = $this->get_case_data();
      if($rs_case["case"]["caseCh_id"]==1 || $rs_case["case"]["caseCh_id"]==2){
        $this->sendMsgToApplnt($case_id);
      }
    }

    //-- บันทึก Reference Case --//
    $sql_del_ref = "DELETE FROM `Case_Ref` WHERE case_id='$case_id' ";
    $qr_del_ref = $this->dbConn->query($sql_del_ref);
    if($qr_del_ref){
      foreach($post["case_ref"] as $case_ref_id) {
        $sql_ins_ref = "INSERT INTO `Case_Ref`(`case_id`, `case_ref_id`)
                          VALUE (
                            '$case_id', '$case_ref_id'
                          )";
        $qr_ins_ref = $this->dbConn->query($sql_ins_ref);
        if(!$qr_ins_ref){
          $status_response = "01";
          $status_response_text = "Error Case Ref SQL!";
        }
      }
    }else{
      $status_response = "01";
      $status_response_text = "Error SQL!";
    }


    if($status_response=="00" || $status_response=="03"){
      /* commit insert */
      $this->dbConn->commit();

      /* Log insert */
      $type_log = "02";
      $text = "รับเรื่องร้องเรียน";
      $this->save_log($type_log,$case_id,null,$text);

    }else{
      /* Rollback */
      $this->dbConn->rollback();

    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'case_id'=>$case_id);
  }

  //-- ฟังก์ชั่น Re-Open Case --//
  public function re_open_case($post){

  }

  public function sendMsgToApplnt($case_id){

      $process_type_data = $this->caseProcessTypeList("all",$this->admin_section,"process_type_step");
      $process_type_step = $process_type_data[1];
      $process_type_dt = $this->caseProcessTypeList("all",$this->admin_section,"process_type_duration");
      $process_type_duration = $process_type_dt[1]; //ระยะเวลา
      $date_over_init = date('Y-m-d', strtotime('+'.$process_type_duration.' day', time()));
      $day_over_subholiday = (int)$this->getHoliday(date('Y-m-d'),$date_over_init);
      $date_over_result = date('Y-m-d H:i:s', strtotime('+'.($process_type_duration+$day_over_subholiday).' day', time()));


      $sql_upd_case = "UPDATE
                        `Case` SET
                          case_lastSave_datetime = NOW()
                          ,case_lastSave_id = '".$this->admin_id."'
                          ,case_step_detail = '1'
                          ,case_status = '1'
                          ,case_notice_applnt_datetime = NOW()
                          ,case_notice_applnt_createBy_id = '".$this->admin_id."'
                          WHERE case_id = '".$case_id."'
                          ";
      $qr_upd_case = $this->dbConn->query($sql_upd_case);

      $sql_ins_process = "INSERT
              INTO
                `Process`(
                  `case_id`,
                  `process_status`,
                  `process_type_id`,
                  `process_save_datetime`,
                  `process_over_datetime`,
                  `process_complete_datetime`,
                  `procPropApp_status`,
                  `process_create_datetime`,
                  `process_createBy_id`
                )
              VALUES(
                '$case_id',
                '1',
                '1',
                NOW(),
                UNIX_TIMESTAMP('$date_over_result'),
                NOW(),
                '1',
                NOW(),
                '".$this->admin_id."'
              )";
    $qr_ins_process = $this->dbConn->query($sql_ins_process);
    if($qr_ins_process){
      $last_process_id = $this->dbConn->insert_id;
      $this->case_id = $case_id;
      $rs_case_ref = $this->get_case_data();

      $sql_ins_process_app = "INSERT
                          INTO
                            `procPropApp`(
                              `process_id`,
                              `procPropApp_member_id`,
                              `procPropApp_message`,
                              `procPropApp_datetime`
                            )
                          VALUES(
                            '$last_process_id',
                            '".$rs_case_ref["case"]["case_createBy_id"]."',
                            'แจ้งผู้ร้องเรียนว่าได้รับเรื่องร้องเรียนเรียบร้อยแล้ว',
                            NOW()
                          )";
      $qr_ins_process_app = $this->dbConn->query($sql_ins_process_app);
      if($qr_ins_process_app){
        $last_ins_process_app = $this->dbConn->insert_id;
        $result_noti = $this->send_notification($process_type_step,$case_id,null,null,1);

        $type_log = "20";
        $text = "สร้างกระบวนการ - แจ้งผู้ร้องเรียนว่าได้รับเรื่องเรียบร้อยแล้ว ";
        $this->save_log($type_log,$case_id,$last_process_id,$text);

      }
    }
  }

  public function checkBacklist($complnt_trade_number, $complnt_name){
    $sql_chk_blacklist = "SELECT backlist_id FROM `Backlist_Complnt` ";
    if($complnt_trade_number!=""){
      $sql_chk_blacklist .= "WHERE complnt_trade_number='$complnt_trade_number' ";
    }else{
      $sql_chk_blacklist .= "WHERE complnt_name='$complnt_name' ";
    }
    $query_chk_blacklist = $this->dbConn->query($sql_chk_blacklist);
    $num_chk_blacklist = $query_chk_blacklist->num_rows;

    return $num_chk_blacklist;

  }
  public function office($wth_out){
   $office = array();
   if($_SESSION['admin']['office'] == "0"){
     $office_type = " AND office_id != '$wth_out' ";
   }else {
     $office_type = " AND office_id != ".$_SESSION['admin']['office'];
     if($wth_out!=""){
       $office_type_wth = " AND office_id != '$wth_out' ";
     }else{
       $office_type_wth = "";
     }
   }
   $sql = "SELECT * FROM `office_type` WHERE `office_status` = '1' $office_type $office_type_wth ";
    $query = $this->dbConn->query($sql);
    if($query->num_rows > 0){
      while ($res = $query->fetch_assoc()) {
        $office_key = array();
        $office_key["office_id"] = $res["office_id"];
        $office_key["office_name"] = $res["office_name"];
        array_push($office,$office_key);
      }
    }
    return $office;
  }
}


//-- คลาส ใช้กับ Case Open --//
class case_detail extends case_open{

  var $case_id; //รหัสข้อร้องเรียน


 public function __construct(){
   parent::__construct();
 }

 //-- ฟังก์ชั่นดึงข้อมูลจาก Case ID --//
 public function getData_detailcase(){

  $rs_case = array();
  $rs_case = $this->get_case_data();
  $rs_case = $this->get_case_field_data();
  $rs_case = $this->get_case_attach_data();
  $rs_case = $this->get_case_ref_data();
  $rs_case = $this->get_case_log_data();
  $rs_case = $this->get_case_assign_data();
  $rs_case = $this->get_case_process_data();
  $rs_case = $this->get_case_transfer();


   return $rs_case;
 }

 //-- ฟังก์ชั่นบันทึกค่าประเภทเรื่องร้องเรียนจาก Case ID --//
 public function genFromSetForCompType_detailCase(){
   $arr_formSetList = array();
   $sql = "SELECT `compType_id`, `compTypeSub1_id`, `compTypeSub2_id`  FROM `Case` WHERE `case_id`='$this->case_id' ";
   $query = $this->dbConn->query($sql);
   $result = $query->fetch_assoc();
   $this->compType_id = $result["compType_id"];
   $this->compTypeSub1 = $result["compTypeSub1_id"];
   $this->compTypeSub2 = $result["compTypeSub2_id"];
   $arr_formSetList["fromSet"] = $this->genFromSetForCompType();

   $arr_formSetList["compType_id"] = $result["compType_id"];
   $arr_formSetList["compTypeSub1_id"] = $result["compTypeSub1_id"];
   $arr_formSetList["compTypeSub2_id"] = $result["compTypeSub2_id"];

   return $arr_formSetList;
 }

 //-- ฟังก์ชั่นกำหนดรูปแบบฟอร์ม แบบต่างๆรอไว้ --//
 public function setFromList_detailCase($formSetId,$formSetName,$formSetNo){
   global $rs_case;


   if(count($this->case_country==0)){
     $this->case_country = $this->countryList();
   }
   $countryList = array();
   foreach($this->case_country as $case_country_list){
     $countryList[$case_country_list["id"]] = $case_country_list["name"];
   }

   if(count($this->case_province==0)){
     $this->case_province = $this->provinceList();
   }

   $provinceList = array();
   foreach($this->case_province as $case_province_list){
     $provinceList[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
   }


  $typeformset = "case_detail";

  if($rs_case["case_feild"]["applntOrg_import_export"]==1){
    $applntOrg_import_export = "บริษัทนำเข้า";
  }else if($rs_case["case_feild"]["applntOrg_import_export"]==2){
    $applntOrg_import_export = "บริษัทส่งออก";
  }else{
    $applntOrg_import_export = "ไม่ระบุ";
  }

  if($rs_case["case_feild"]["complnt_import_export"]==1){
    $complnt_import_export = "บริษัทนำเข้า";
  }else if($rs_case["case_feild"]["complnt_import_export"]==2){
    $complnt_import_export = "บริษัทส่งออก";
  }else{
    $complnt_import_export = "ไม่ระบุ";
  }

  include("formset/formset_".$formSetId.".php");

   return $formSet_html;
 }

 //-- ฟังก์ชั่นบันทึกกระบวนการ --//
 public function save_process($post,$file){

   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();

   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $status_response = "00";
   $status_response_text = "success";

   if($post["process_type_id"]==""){
      $status_response = "02";
      $status_response_text = "กรุณาเลือกประเภทประบวนการ !";
   }

   $case_id = $post["case_id"];
   $process_id = $post["process_id"];
   $process_type_id = $post["process_type_id"];
   $process_type_id_old = $post["process_type_id_old"];
   $process_annotation = $post["process_annotation"];
   $process_dept_id = $post["process_dept_id"];



   $process_type_data = $this->caseProcessTypeList("all",$this->admin_section,"process_type_step");
   $process_type_step = $process_type_data[$process_type_id];

   $process_dept_type = $this->caseProcessTypeList("all",$this->admin_section,"dept_type");
   if($process_type_id==""){
     $status_response = "02";
     $status_response_text = "กรุณาระบุประเภทประบวนการ !";
   }
   if($process_dept_type[$process_type_id]=='1' && $process_dept_id==""){
       $status_response = "02";
       $status_response_text = "กรุณาเลือกหน่วยงานผู้ติดต่อ !";
   }

   if($status_response=="00"){
     $procPropApp_status = $post["procPropApp"];
     for($itx=1;$itx<=2;$itx++){
       $process_to[$itx] = $post["process_to_".$itx];
       $process_title[$itx] = $post["process_title_".$itx];
       $procPropTel_status[$itx] = $post["procPropTel".$itx];
       $procPropFax_status[$itx] = $post["procPropFax".$itx];
       $procPropEmail_status[$itx] = $post["procPropEmail".$itx];
       $procPropMail_status[$itx] = $post["procPropMail".$itx];
       $procPropOffcLetter_status[$itx] = $post["procPropOffcLetter".$itx];
     }

     $process_note = $post["process_note"];

     if($process_id!="0"){
       $sql_process_id = "AND process_id = '$process_id' ";
     }
     if($process_type_id==1){
       $type_process = "กระบวนการ - แจ้งผู้ร้องเรียนว่าได้รับเรื่องเรียบร้อยแล้ว ";
     }else if($process_type_id==2){
       $type_process = "กระบวนการ - ตั้งเรื่อง ";
     }

    if($process_type_id!=1 && $process_type_id!=2){

       $sql_chk_process = "SELECT * FROM Process
                           WHERE case_id = '$case_id'
                           AND process_type_id NOT IN (1,2)
                            ";
       $qr_chk_processByCase = $this->dbConn->query($sql_chk_process);
       $num_chk_processByCase = $qr_chk_processByCase->num_rows;


       $processType_name = $this->caseProcessTypeList(null,$this->admin_section);
       if($process_id=="0"){
         $num_chk_processByCase= $num_chk_processByCase+1;
       }

       if($num_chk_processByCase==0){
         $num_chk_processByCase = 1;
       }
       $type_process = "กระบวนการที่ ".($num_chk_processByCase)." - ".$processType_name[$process_type_id];
    }
    if($status_response=="00"){
       $sql_chk_process = "SELECT * FROM Process
                           WHERE case_id = '$case_id'
                           $sql_process_id
                            ";
       $qr_chk_process = $this->dbConn->query($sql_chk_process);
       $num_chk_process = $qr_chk_process->num_rows;
       if($process_id=="0" || $num_chk_process==0){
         $type_process = "สร้าง".$type_process;
         $process_type_dt = $this->caseProcessTypeList("all",$this->admin_section,"process_type_duration");
         $process_type_duration = $process_type_dt[$process_type_id]; //ระยะเวลา
         $date_over_init = date('Y-m-d', strtotime('+'.$process_type_duration.' day', time()));
         $day_over_subholiday = (int)$this->getHoliday(date('Y-m-d'),$date_over_init);
         $date_over_result = date('Y-m-d H:i:s', strtotime('+'.($process_type_duration+$day_over_subholiday).' day', time()));
         $sql_ins_process1 = "INSERT
                 INTO
                   `Process`(
                     `case_id`,
                     `process_status`,
                     `process_type_id`,
                     `dept_id`,
                     `process_to1`,
                     `process_title1`,
                     `process_to2`,
                     `process_title2`,
                     `process_annotation`,
                     `process_type_duration`,
                     `process_save_datetime`,
                     `process_over_datetime`,
                     `procPropApp_status`,
                     `procPropTel1_status`,
                     `procPropFax1_status`,
                     `procPropEmail1_status`,
                     `procPropOffcLetter1_status`,
                     `procPropMail1_status`,
                     `procPropTel2_status`,
                     `procPropFax2_status`,
                     `procPropEmail2_status`,
                     `procPropMail2_status`,
                     `procPropOffcLetter2_status`,
                     `process_note`,
                     `process_create_datetime`,
                     `process_createBy_id`
                   )
                 VALUES(
                   '$case_id',
                   '0',
                   '$process_type_id',
                   '$process_dept_id',
                   '$process_to[1]',
                   '$process_title[1]',
                   '$process_to[2]',
                   '$process_title[2]',
                   '$process_annotation',
                   '$process_type_duration',
                   NOW(),
                   UNIX_TIMESTAMP('$date_over_result'),
                   '$procPropApp_status',
                   '$procPropMail_status[1]',
                   '$procPropFax_status[1]',
                   '$procPropEmail_status[1]',
                   '$procPropMail_status[1]',
                   '$procPropOffcLetter_status[1]',
                   '$procPropTel_status[2]',
                   '$procPropFax_status[2]',
                   '$procPropEmail_status[2]',
                   '$procPropMail_status[2]',
                   '$procPropOffcLetter_status[2]',
                   '$process_note',
                   NOW(),
                   '".$this->admin_id."'
                 )";
                 $type_process_status = 1;
         }else{
           $type_process = "แก้ไข".$type_process;
           $sql_ins_process1 = "UPDATE `Process`
                   SET
                       `process_annotation`='$process_annotation',
                       `process_type_id`='$process_type_id',
                       `dept_id`='$process_dept_id',
                       `process_to1`='$process_to[1]',
                       `process_title1`='$process_title[1]',
                       `process_to2`='$process_to[2]',
                       `process_title2`='$process_title[2]',
                       `procPropApp_status`='$procPropApp_status',
                       `procPropTel1_status`='$procPropTel_status[1]',
                       `procPropFax1_status`='$procPropFax_status[1]',
                       `procPropEmail1_status`='$procPropEmail_status[1]',
                       `procPropMail1_status`='$procPropMail_status[1]',
                       `procPropOffcLetter1_status`='$procPropOffcLetter_status[1]',
                       `procPropTel2_status`='$procPropTel_status[2]',
                       `procPropFax2_status`='$procPropFax_status[2]',
                       `procPropEmail2_status`='$procPropEmail_status[2]',
                       `procPropMail2_status`='$procPropMail_status[2]',
                       `procPropOffcLetter2_status`='$procPropOffcLetter_status[2]',
                       `process_update_datetime`=NOW(),
                       `process_updateBy_id`='".$this->admin_id."',
                       `process_note`='$process_note'
                       WHERE case_id = '$case_id'
                       AND process_status = '0'
                       $sql_process_id
                       ";//AND process_type_id = '$process_type_id'

                       $type_process_status = 0;
       }
       $qr_ins_process = $this->dbConn->query($sql_ins_process1);
     }
     if(!$qr_ins_process){
       $status_response = "01";
       $status_response_text = "Error Process SQL!";
     }else{
       if($process_id=="0" || $num_chk_process==0){
         $last_process_id = $this->dbConn->insert_id;
       }else{
         $last_process_id = $process_id;

       }
       if($post["removeProcessTelId"]!=""){
         $sql_del_process_tel = "DELETE FROM `procPropTel` WHERE procPropTel_id IN (".$post["removeProcessTelId"].") ";
         $qr_del_process_tel = $this->dbConn->query($sql_del_process_tel);
       }
       if($post["removeProcessFaxId"]!=""){
         $sql_del_process_fax = "DELETE FROM `procPropFax_` WHERE procPropFax_id IN (".$post["removeProcessFaxId"].") ";
         $qr_del_process_fax = $this->dbConn->query($sql_del_process_fax);
        }

       if($post["removeProcessMailId"]!=""){
         $sql_del_process_mail = "DELETE FROM `procPropMail` WHERE procPropMail_id IN (".$post["removeProcessMailId"].") AND  ";
         $qr_del_process_mail = $this->dbConn->query($sql_del_process_mail);
       }


       if($post["removeProcessOffcLetterId"]!=""){
         $sql_del_process_offcl = "DELETE FROM `procPropOffcLetter` WHERE procPropOffcLetter_id IN (".$post["removeProcessOffcLetterId"].") ";
         $qr_del_process_offcl = $this->dbConn->query($sql_del_process_offcl);
       }


       $count_chk_channel = 0;
      if($procPropApp_status==1){
          for ($i=0;$i<count($post["procPropApp_id"]);$i++) {
            if($post["procPropApp_member_id"][$i]=="" || $post["procPropApp_message"][$i]==""){
               $status_response = "02";
               $status_response_text = "กรุณาระบุข้อความให้ครบถ้วน !";
            }
            $sql_chk_process = "SELECT * FROM `procPropApp` WHERE procPropApp_id = '".$post["procPropApp_id"][$i]."' ";
            $qr_chk_process = $this->dbConn->query($sql_chk_process);
            if($process_id=="0" || $qr_chk_process->num_rows==0){
              $sql_ins_process = "INSERT
                                  INTO
                                    `procPropApp`(
                                      `process_id`,
                                      `procPropApp_member_id`,
                                      `procPropApp_message`,
                                      `procPropApp_datetime`
                                    )
                                  VALUES(
                                    '$last_process_id',
                                    '".$post["procPropApp_member_id"][$i]."',
                                    '".$post["procPropApp_message"][$i]."',
                                    NOW()
                                  )";
              $qr_ins_process = $this->dbConn->query($sql_ins_process);
              if(!$qr_ins_process){
                  $status_response = "01";
                  $status_response_text = "Error Process App SQL!";
              }else{
                $last_ins_process_app = $this->dbConn->insert_id;
                $sql_ins_msg = "INSERT
                                    INTO
                                      `Message_Box`(
                                        `case_id`,
                                        `msgBox_type`,
                                        `sender_id`,
                                        `sender_type`,
                                        `msgBox_message`,
                                        `msgBox_datetime`
                                      )
                                    VALUE (
                                      '$case_id',
                                      '1',
                                      '".$this->admin_id."',
                                      '2',
                                      '".$post["procPropApp_message"][$i]."',
                                      NOW()
                                    )";
                $qr_ins_msg = $this->dbConn->query($sql_ins_msg);
                $last_ins_msg = $this->dbConn->insert_id;

                $qr_ins_msg_log = true;
                $this->case_id = $case_id;
                $rs_case_ref = $this->get_case_data();
                if($rs_case_ref["case"]["caseCh_id"]==1 || $rs_case_ref["case"]["caseCh_id"]==2){

                  $sql_ins_msg_log = "INSERT
                                      INTO
                                        `Message_Box_Log`(
                                          `msgBox_id`,
                                          `recipient_id`,
                                          `recipient_type`,
                                          `msgBoxLog_datetime`,
                                          `msgBox_noti_status`,
                                          `msgBox_read_status`
                                        )
                                      VALUE (
                                        '$last_ins_msg',
                                        '".$rs_case_ref["case"]["case_createBy_id"]."',
                                        '1',
                                        NOW(),
                                        0,
                                        0
                                      )";
                  $qr_ins_msg_log = $this->dbConn->query($sql_ins_msg_log);
                }

                if((!$qr_ins_msg && $qr_ins_msg_log)){
                    $status_response = "01";
                    $status_response_text = "Error Process App Copy SQL!";
                }
              }
            }
          }
        $channel_text = "แอพลิแคขั่น";
        $count_chk_channel++;
      }

       for($itx=1;$itx<=2;$itx++){
         if($procPropTel_status[$itx]==1){
             for ($i=0;$i<count($post["procPropTel_id_".$itx]);$i++) {
               if($post["procPropTel_date_".$itx][$i]=="" || $post["procPropTel_time_".$itx][$i]==""){
                    $status_response = "02";
                    $status_response_text = "กรุณาระบุวันเวลาโทรศัพท์ !";
               }else{
                 $post["procPropTel_date_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropTel_date_".$itx][$i])));
               }
               if($post["procPropTel_number_".$itx][$i]!=""){
                 $sql_chk_process = "SELECT *  FROM `procPropTel` WHERE procPropTel_id = '".$post["procPropTel_id_".$itx][$i]."' ";
                 $qr_chk_process = $this->dbConn->query($sql_chk_process);
                 $sql_ins_process = "";
                 if($process_id=="0" || $qr_chk_process->num_rows==0){
                   $sql_ins_process = "INSERT
                                       INTO
                                         `procPropTel`(
                                           `process_id`,
                                           `procPropTel_type`,
                                           `procPropTel_number`,
                                           `procPropTel_datetime`
                                         )
                                       VALUES(
                                         '$last_process_id',
                                         '$itx',
                                         '".$post["procPropTel_number_".$itx][$i]."',
                                         '".$post["procPropTel_date_".$itx][$i]." ".$post["procPropTel_time_".$itx][$i]."'
                                       )";
                    $qr_ins_process = $this->dbConn->query($sql_ins_process);
                 }else{
                   $sql_ins_process = "UPDATE `procPropTel`
                                       SET
                                           `procPropTel_number`='".$post["procPropTel_number_".$itx][$i]."',
                                           `procPropTel_datetime`='".$post["procPropTel_date_".$itx][$i]." ".$post["procPropTel_time_".$itx][$i]."'
                                      WHERE `procPropTel_id`='".$post["procPropTel_id_".$itx][$i]."' ";

                   $qr_ins_process = $this->dbConn->query($sql_ins_process);
                 }

                 if(!$qr_ins_process){
                     $status_response = "01";
                     $status_response_text = "Error Process Tel SQL!";
                 }

               }else{
                  $status_response = "02";
                  $status_response_text = "กรุณาระบุเบอร์โทรศัพท์ !";
               }
             }
           $channel_text = "โทรศัพท์";

           $count_chk_channel++;
         }

         if($procPropFax_status[$itx]==1){
             for ($i=0;$i<count($post["procPropFax_id_".$itx]);$i++) {
               if($post["procPropFax_number_".$itx][$i]!=""){
                 if($post["procPropFax_date_".$itx][$i]=="" || $post["procPropFax_time_".$itx][$i]==""){
                      $status_response = "02";
                      $status_response_text = "กรุณาระบุวันเวลาส่งแฟกซ์ !";
                 }else{
                   $post["procPropFax_date_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropFax_date_".$itx][$i])));

                   $sql_chk_process = "SELECT * FROM `procPropFax` WHERE procPropFax_id = '".$post["procPropFax_id_".$itx][$i]."' ";
                   $qr_chk_process = $this->dbConn->query($sql_chk_process);
                   $sql_ins_process = "";
                   if($process_id=="0" || $qr_chk_process->num_rows==0){
                     $sql_ins_process = "INSERT
                                         INTO
                                           `procPropFax`(
                                             `process_id`,
                                             `procPropFax_type`,
                                             `procPropFax_number`,
                                             `procPropFax_datetime`
                                           )
                                         VALUES(
                                           '$last_process_id',
                                           '$itx',
                                           '".$post["procPropFax_number_".$itx][$i]."',
                                           '".$post["procPropFax_date_".$itx][$i]." ".$post["procPropFax_time_".$itx][$i]."'
                                         )";
                    $qr_ins_process = $this->dbConn->query($sql_ins_process);

                   }else{
                     $sql_ins_process = "UPDATE `procPropFax`
                                         SET
                                             `procPropFax_number`='".$post["procPropFax_number_".$itx][$i]."',
                                             `procPropFax_datetime`='".$post["procPropFax_date_".$itx][$i]." ".$post["procPropFax_time_".$itx][$i]."'
                                         WHERE `procPropFax_id`='".$post["procPropFax_id_".$itx][$i]."' ";
                    $qr_ins_process = $this->dbConn->query($sql_ins_process);
                   }
                   if(!$qr_ins_process){
                       $status_response = "01";
                       $status_response_text = "Error Process Fax SQL!";
                   }else{
                      $channel_text = "แฟกซ์";
                   }
                 }
               }else{
                  $status_response = "02";
                  $status_response_text = "กรุณาระบุเบอร์แฟกซ์ !";
               }
             }

             $count_chk_channel++;
         }

         if($procPropEmail_status[$itx]==1){
           if($itx==2){
             for ($i=0;$i<count($post["procPropEmail_id_".$itx]);$i++) {
               if($post["procPropEmail_datetime_".$itx][$i]!=""){
                   $sql_chk_process = "SELECT * FROM `procPropEmail` WHERE procPropEmail_id = '".$post["procPropEmail_id_".$itx][$i]."' ";
                   $qr_chk_process = $this->dbConn->query($sql_chk_process);
                   $sql_ins_process = "";
                   if($process_id=="0" || $qr_chk_process->num_rows==0){
                     $sql_ins_process = "INSERT
                                         INTO
                                           `procPropEmail`(
                                             `process_id`,
                                             `procPropEmail_type`,
                                             `procPropEmail_address`,
                                             `procPropEmail_subject`,
                                             `procPropEmail_message`,
                                             `procPropEmail_datetime`
                                           )
                                         VALUES(
                                           '$last_process_id',
                                           '$itx',
                                           '".$post["procPropEmail_address_".$itx][$i]."',
                                           '".$post["procPropEmail_subject_".$itx][$i]."',
                                           '".$post["procPropEmail_message_".$itx][$i]."',
                                           '".$post["procPropEmail_datetime_".$itx][$i]."'
                                         )";
                     $qr_ins_process = $this->dbConn->query($sql_ins_process);
                     if(!$qr_ins_process){
                         $status_response = "01";
                         $status_response_text = "Error Process Email SQL!";
                     }else{
                       $last_processEmail_id = $this->dbConn->insert_id;
                       $path_group = "mail_attach";

                       $this->deleteDirectory("../data/$path_group/$last_processEmail_id");

                       for ($i=0; $i <= count($post["mailFile"]); $i++) {
                         $tmp_filepath = "data/$path_group/tmp/".$_SESSION["admin"]["empId"]."/".$post["mailFile"][$i];
                         if($post["mailFile"][$i]!=""){
                           $ext = pathinfo("../".$tmp_filepath, PATHINFO_EXTENSION);
                           $new_filename = "procPropEmail_file_".$last_processEmail_id."_".time().$i.".".$ext;
                           $new_filepath = "data/$path_group/$last_processEmail_id/".$new_filename;

                          if(!is_dir("../data/$path_group")){
                            mkdir("../data/$path_group", 0775, true);
                          }
                          if(!is_dir("../data/$path_group/$last_processEmail_id")){
                            mkdir("../data/$path_group/$last_processEmail_id", 0775, true);
                          }
                          if(copy("../".$tmp_filepath,"../".$new_filepath)){
                            unlink("../".$tmp_filepath);
                            $sql_ins_mailAttach = "INSERT INTO `Mail_Attachfile`(
                              `procPropEmail_id`,
                              `mailAttach_file_path`,
                              `mailAttach_file_oldname`,
                              `mailAttach_file_name`,
                              `mailAttach_file_ext`,
                              `mailAttach_status`,
                              `mailAttach_create_datetime`,
                              `mailAttach_createBy_id`)
                              VALUE (
                                '$last_processEmail_id'
                                ,'$new_filepath'
                                ,'".$post["mailFile"][$i]."'
                                ,'$new_filename'
                                ,'$ext'
                                ,0
                                ,NOW()
                                ,'".$this->admin_id."'
                              )";
                            $qr_ins_mailAttach = $this->dbConn->query($sql_ins_mailAttach);
                            if(!$qr_ins_mailAttach){
                              $status_response = "01";
                              $status_response_text = "Error Mail File SQL!";
                            }
                          }
                         }
                       }
                     }
                   }
               }
             }
           }else{
             for ($i=0;$i<count($post["procPropEmail_id_".$itx]);$i++) {
                 if($post["procPropEmail_number_".$itx][$i]==""){
                    $status_response = "02";
                    $status_response_text = "กรุณาระบุรายละเอียด Email ให้ครบถ้วน !";
                 }else{
                   $post["procPropEmail_date_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropEmail_date_".$itx][$i])));

                   $sql_chk_process = "SELECT * FROM `procPropEmail` WHERE procPropEmail_id = '".$post["procPropEmail_id_".$itx][$i]."' ";
                   $qr_chk_process = $this->dbConn->query($sql_chk_process);
                   $sql_ins_process = "";
                   if($process_id=="0" || $qr_chk_process->num_rows==0){
                     $sql_ins_process = "INSERT
                                         INTO
                                           `procPropEmail`(
                                             `process_id`,
                                             `procPropEmail_type`,
                                             `procPropEmail_number`,
                                             `procPropEmail_datetime`
                                           )
                                         VALUES(
                                           '$last_process_id',
                                           '$itx',
                                           '".$post["procPropEmail_number_".$itx][$i]."',
                                           '".$post["procPropEmail_date_".$itx][$i]." ".$post["procPropEmail_time_".$itx][$i]."'
                                         )";
                     $qr_ins_process = $this->dbConn->query($sql_ins_process);
                     if(!$qr_ins_process){
                         $status_response = "01";
                         $status_response_text = "Error Process Email SQL!";
                     }
                   }
                 }
             }
           }
           $channel_text = "อีเมล";

           $count_chk_channel++;
         }

         if($procPropOffcLetter_status[$itx]==1){


             for ($i=0;$i<count($post["procPropOffcLetter_id_".$itx]);$i++) {
               if($post["procPropOffcLetter_number_".$itx][$i]!=""){

                 if($post["procPropOffcLetter_date_".$itx][$i]=="" || $post["procPropOffcLetter_time_".$itx][$i]==""){
                      $status_response = "02";
                      $status_response_text = "กรุณาระบุวันเวลาส่งหนังสือราชการ !";
                 }else{
                   $post["procPropOffcLetter_date_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropOffcLetter_date_".$itx][$i])));
                 }
                 $sql_chk_process = "SELECT * FROM `procPropOffcLetter` WHERE `procPropOffcLetter_id` = '".$post["procPropOffcLetter_id_".$itx][$i]."' ";
                 $qr_chk_process = $this->dbConn->query($sql_chk_process);
                 $sql_ins_process = "";
                 if($process_id=="0" || $qr_chk_process->num_rows==0){
                   $sql_ins_process = "INSERT
                                       INTO
                                         `procPropOffcLetter`(
                                           `process_id`,
                                           `procPropOffcLetter_type`,
                                           `procPropOffcLetter_number`,
                                           `procPropOffcLetter_datetime`
                                         )
                                       VALUES(
                                         '$last_process_id',
                                         '$itx',
                                         '".$post["procPropOffcLetter_number_".$itx][$i]."',
                                         '".$post["procPropOffcLetter_date_".$itx][$i]." ".$post["procPropOffcLetter_time_".$itx][$i]."'
                                       )";
                    $qr_ins_process = $this->dbConn->query($sql_ins_process);
                 }else{
                   $sql_ins_process = "UPDATE `procPropOffcLetter`
                                       SET
                                           `procPropOffcLetter_number`='".$post["procPropOffcLetter_number_".$itx][$i]."',
                                           `procPropOffcLetter_datetime`='".$post["procPropOffcLetter_date_".$itx][$i]." ".$post["procPropOffcLetter_time_".$itx][$i]."'
                                       WHERE `procPropOffcLetter_id` = '".$post["procPropOffcLetter_id_".$itx][$i]."' ";
                    $qr_ins_process = $this->dbConn->query($sql_ins_process);
                 }

                 if(!$qr_ins_process){
                     $status_response = "01";
                     $status_response_text = "Error Process OffcLetter SQL!";
                 }
               }else{
                 $status_response = "02";
                 $status_response_text = "กรุณาระบุหนังสือราชการ !";
               }
             }
           $channel_text = "หนังสือราชการ";

           $count_chk_channel++;
         }


         //if($procPropMail_status[$itx]==1){
             if($process_type_id==2 && !($post["procPropMail_number_2"][0]!="" && $post["procPropMail_time_2"][0]!="" && $post["procPropMail_time_2"][0]!="")){
                $status_response = "02";
                 $status_response_text = "กรุณากรอกข้อมูลตั้งเรื่องให้ครบถ้วน ตั้งแต่ช่อง \"หมายเลขเอกสารออก\" ไปจนถึงวันที่-เวลา !";
             }else{
               for ($i=0;$i<count($post["procPropMail_id_".$itx]);$i++) {
                 $channel_text = "จดหมาย";
                 $sql_chk_process = "SELECT *  FROM `procPropMail` WHERE `procPropMail_id` = '".$post["procPropMail_id_".$itx][$i]."' ";
                 $qr_chk_process = $this->dbConn->query($sql_chk_process);
                   $post["procPropMail_date_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropMail_date_".$itx][$i])));
                   $post["procPropMail_date_tracking_".$itx][$i] = implode("-", array_reverse(explode("/", $post["procPropMail_date_tracking_".$itx][$i])));
                   if(($process_type_id==2 && $post["procPropMail_number_".$itx][$i]!="") || ($process_type_id!=2 && ($post["procPropMail_number_".$itx][$i]!="" || $post["procPropMail_tracking_".$itx][$i]!=""))){

                     $sql_ins_process = "";
                     if($process_id=="0" || $qr_chk_process->num_rows==0 ){

                      $sql_ins_process = "INSERT
                                           INTO
                                             `procPropMail`(
                                               `process_id`,
                                               `procPropMail_number`,
                                               `procPropMail_type`,
                                               `procPropMail_tracking`,
                                               `procPropMail_datetime`,
                                               `procPropMail_tracking_datetime`
                                             )
                                           VALUES(
                                             '$last_process_id',
                                             '".$post["procPropMail_number_".$itx][$i]."',
                                             '".$post["procPropMail_type_".$itx][$i]."',
                                             '".$post["procPropMail_tracking_".$itx][$i]."',
                                             '".$post["procPropMail_date_".$itx][$i]." ".$post["procPropMail_time_".$itx][$i]."',
                                             '".$post["procPropMail_date_tracking_".$itx][$i]." ".$post["procPropMail_time_tracking_".$itx][$i]."'
                                           )";
                        $qr_ins_process = $this->dbConn->query($sql_ins_process);
                     }else{
                       $sql_ins_process = "UPDATE `procPropMail`
                                           SET
                                               `procPropMail_number`='".$post["procPropMail_number_".$itx][$i]."',
                                               `procPropMail_tracking`='".$post["procPropMail_tracking_".$itx][$i]."',
                                               `procPropMail_datetime`='".$post["procPropMail_date_".$itx][$i]." ".$post["procPropMail_time_".$itx][$i]."',
                                               `procPropMail_tracking_datetime`='".$post["procPropMail_date_tracking_".$itx][$i]." ".$post["procPropMail_time_tracking_".$itx][$i]."'
                                           WHERE `procPropMail_id` = '".$post["procPropMail_id_".$itx][$i]."' ";
                       $qr_ins_process = $this->dbConn->query($sql_ins_process);
                     }
                     if($qr_ins_process){
                      $count_chk_channel++;
                     }
                   }


                   if($process_id=="0" || $qr_chk_process->num_rows==0){
                     $last_processMail_id = $this->dbConn->insert_id;
                   }else{
                     $rs_chk_process = $qr_chk_process->fetch_assoc();
                     $last_processMail_id = $rs_chk_process["procPropMail_id"];
                   }

                 //-- บันทึก เอกสารรับเรื่อง --//
                 if($file["procPropMail_file_".$itx]["name"][$i]!=""){

                   $ext = pathinfo($file["procPropMail_file_".$itx]["name"][$i], PATHINFO_EXTENSION);
                   $new_filename = "procPropMail_file_".$last_processMail_id."_".time().$i.".".$ext;
                   $new_filepath = "data/case_process_mail/$last_processMail_id/$new_filename";

                    if(!in_array($ext,$this->file_accept)){
                        $status_response = "02";
                        $status_response_text = "รูปแบบไฟล์เอกสารรับเรื่องไม่ถูกต้อง !";
                    }else{

                     $this->deleteDirectory("../data/case_process_mail/$last_processMail_id");

                     if(!is_dir("../data/case_process_mail")){
                       mkdir("../data/case_process_mail", 0775, true);
                     }
                     if(!is_dir("../data/case_process_mail/$last_processMail_id")){
                       mkdir("../data/case_process_mail/$last_processMail_id", 0775, true);
                     }

                     if(!(move_uploaded_file($file["procPropMail_file_".$itx]["tmp_name"][$i],"../".$new_filepath))){
                         $status_response = "02";
                         $status_response_text = "การอัพโหลดเอกสารรับเรื่องผิดพลาด";
                     }else{
                       $sql_upd_fileProcMail = "UPDATE `procPropMail`
                                                SET `procPropMail_file_path`='$new_filepath',
                                                `procPropMail_file_oldname`='".$file["procPropMail_file_".$itx]["name"][$i]."',
                                                `procPropMail_file_name`='$new_filename',
                                                `procPropMail_file_ext`='$ext'
                                                WHERE `procPropMail_id`='$last_processMail_id' ";
                       $qr_upd_fileProcMail= $this->dbConn->query($sql_upd_fileProcMail);

                       if(!$qr_upd_fileProcMail){
                         $status_response = "01";
                         $status_response_text = "Error Mail File SQL!";
                       }else{
                         if(!($process_id=="0" || $num_chk_process==0)){
                          //  $this->case_id = $case_id;
                          //  $rs_case_sms = $this->get_case_field_data();
                           if($itx==1){
                             $process_type_message_in = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_in");
                             $result_noti = $this->send_notification($process_type_step,$case_id,null,null,$process_type_id,"process_type_message_in",null,"process_type_message_in_en");
                           }else if($itx==2){
                             $process_type_message_out = $this->caseProcessTypeList("all",$this->admin_section,"process_type_message_out");
                             $result_noti = $this->send_notification($process_type_step,$case_id,null,null,$process_type_id,"process_type_message_out",null,"process_type_message_out_en");
                           }
                         }
                       }
                     }
                   }
                 }
               }
             }
         //}
       }

     }
     if($process_type_id!=2 && $count_chk_channel==0){
        $status_response = "02";
        $status_response_text = "กรุณาเลือกช่องทางอย่างน้อย 1 ช่องทาง !";
     }
   }

   if($status_response=="00"){
    if($process_id=="0" || $num_chk_process==0){
      $result_noti = $this->send_notification($process_type_step,$case_id,null,null,$process_type_id,null,$process_dept_id);
    }

     /* commit insert */
     $this->dbConn->commit();
       /* Log insert */
       $type_log = "20";
       if($channel_text!=""){
         $channel_text_init = " - ผ่านช่องทาง";
          $channel_text_comma = "";
       }else{
         $channel_text_init = "";
         $channel_text_comma = ", ";
       }
       $text = $type_process;
       $this->save_log($type_log,$case_id,$last_process_id,$text);


   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }

   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_process_id'=>$last_process_id,'last_case_id'=>$case_id);
 }

 //-- ฟังก์ชั่นส่งอีเมลของกระบวนการ --//
 public function send_email_process($post){

 }

  //-- ฟังก์ชั่นระบุสาเหตุกระกวนการเกินกำหนดเวลา  --//
  public function note_process_overdue($post){
    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();

    foreach($post as $key => $value) {
      if(is_array($value)){
        foreach($value as $key1 => $value1) {
          $post[$key][$key1] = $this->data_filter($value1);
        }
      }else{
        $post[$key] = $this->data_filter($value);
      }
    }

    $status_response = "00";
    $status_response_text = "success";

    $process_id = $post["process_id"];

    if($post["note_overdue"]==""){
      $status_response = "02";
      $status_response_text = "กรุณาระบุสาเหตุการเกินกำหนดเวลาที่กำหนด";
    }

    $sql_udp_process = "UPDATE `Process`
                        SET `process_over_note` = '".$post["note_overdue"]."',
                            `process_over_note_create_datetime` = NOW()
                        WHERE `process_id` = '$process_id'
                         ";//AND `process_status` = '0'

    $qr_udp_process = $this->dbConn->query($sql_udp_process);

    if(!$qr_udp_process){
      $status_response = "01";
      $status_response_text = "Error Process Close SQL!";
    }
    if($status_response=="00"){
      /* commit insert */
      $this->dbConn->commit();
    }else{
      /* Rollback */
      $this->dbConn->rollback();
    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'process_id'=>$process_id);


  }

public function check_close_process($case_id){

  $case_id = $this->data_filter($case_id);

  $sql_chk_process = "SELECT * FROM `Process` WHERE `case_id` = '$case_id' AND `process_status` = '0' ";
  $qr_chk_process = $this->dbConn->query($sql_chk_process);
  $num_chk_process = $qr_chk_process->num_rows;
  if($num_chk_process>0){
     $status_response = "01";
  }else{
    $status_response = "00";
  }
  return $status_response;
}

 //-- ฟังก์ชั่นปิดกระบวนการ --//
 public function close_process($post){

   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();


   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $status_response = "00";
   $status_response_text = "success";

   $case_id = $post["case_id"];
   $process_id = $post["process_id"];
   $process_type_id = $post["process_type_id"];

   $sql_chk_process = "SELECT * `Process` WHERE `case_id` = '$case_id' AND `process_status` = '0' ";
   $qr_chk_process = $this->dbConn->query($sql_chk_process);
   $num_chk_process = $qr_chk_process->num_rows;
   if($num_chk_process>0){
      $status_response = "02";
      $status_response_text = "ขออภัย...กรุณาปิดกระบวนการทั้งหมด ก่อนยุติข้อร้องเรียน !";
   }
   if($status_response=="00"){
     $sql_udp_process = "UPDATE `Process`
                         SET `process_status` = '1',
                             `process_complete_datetime` = NOW()
                         WHERE `case_id` = '$case_id'
                         AND `process_type_id` = '$process_type_id'
                         AND `process_id` = '$process_id'
                         AND `process_status` = '0'
                          ";
     $qr_udp_process = $this->dbConn->query($sql_udp_process);

     if($process_type_id==1 || $process_type_id==2){
       if($process_type_id==1){
         $sql_udp_case_type = " SET `case_notice_applnt_datetime` = NOW(),";
         $sql_udp_case_type .= "  `case_notice_applnt_createBy_id` = '".$this->admin_id."' ";
       }else if($process_type_id==2){
         $sql_udp_case_type = " SET `case_setsubject_datetime` = NOW(),";
         $sql_udp_case_type .= "  `case_setsubject_createBy_id` = '".$this->admin_id."' ";
       }
       $sql_udp_case = "UPDATE`Case`
                           $sql_udp_case_type
                           WHERE `case_id` = '$case_id'
                            ";
       $qr_udp_cess = $this->dbConn->query($sql_udp_case);
     }else{
       $qr_udp_cess =true;
     }

     if(!($qr_udp_process && $qr_udp_cess)){
       $status_response = "01";
       $status_response_text = "Error Close Case SQL!";
     }
   }
   if($status_response=="00"){
     /* commit insert */
     $this->dbConn->commit();

     /* Log insert */
     $type_log = "21";
     $processType_name = $this->caseProcessTypeList("all",$this->admin_section);
     $text = "ปิดกระบวนการ - ".$processType_name[$process_type_id];
     $this->save_log($type_log,$case_id,$process_id,$text);

   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }
   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_process_id'=>$process_id,'last_case_id'=>$case_id);

 }

 //-- ฟังก์ชั่นตรวจสอบ Assign Case --//
 public function check_assign_case($post){
     $sql_chk_assign = "SELECT *
                         FROM `Case`
                         WHERE `case_id` = '".$post["case_id"]."' ";
                         //AND case_setsubject_datetime != ''
                         //AND case_notice_applnt_datetime != ''
     $qr_chk_assign = $this->dbConn->query($sql_chk_assign);
     $num_chk_assign = $qr_chk_assign->num_rows;
     if($num_chk_assign>0){
       $rs_chk_assign = $qr_chk_assign->fetch_assoc();
       $res = "00";

       if($rs_chk_assign["case_status"]=="3"){
           $res = "03";
       }
     }
     else{
       $res = "01";
     }
   return $res;
 }


 //-- ฟังก์ชั่นบันทึกแก้ไข Assign Case --//
 public function assign_case($post){
   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();

   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $case_id = $post["case_id"];

   $status_response = "00";
   $status_response_text = "success";

   if(!(count($post["emp_id_assign"])>0 && $post["emp_id_assign"][0]!="")){
     $status_response = "02";
     $status_response_text = "กรุณาเลือกผู้รับผิดชอบ";
   }else{

     $sql_chk_assign = "SELECT *
                         FROM `Case_Assign`
                         WHERE `case_id` = '$case_id' AND `caseAsign_status` != 1 ";
     $qr_chk_assign = $this->dbConn->query($sql_chk_assign);
     $num_chk_assign = $qr_chk_assign->num_rows;

     if($num_chk_assign==0){
       $type_log = "10";
       $sql_udp_case = "UPDATE `Case`
                         SET
                           `case_status` = '2',
                           `case_assign_status` = '1',
                           `case_opened_datetime` = NOW(),
                           `case_opened_createBy_id` = '".$this->admin_id."'
                         WHERE `case_id` = '$case_id' ";
       $qr_udp_case = $this->dbConn->query($sql_udp_case);
       if(!$qr_udp_case){
         $status_response = "01";
         $status_response_text = "Error Open Case 1 SQL!";
       }
     }else{
       $type_log = "11";
       $sql_udp_case = "UPDATE `Case`
                         SET
                           `case_opened_note` = '".$post["assign_note"]."'
                         WHERE `case_id` = '$case_id' ";
       $qr_udp_case = $this->dbConn->query($sql_udp_case);
       if(!$qr_udp_case){
         $status_response = "01";
         $status_response_text = "Error Open Case 2 SQL!";
       }
     }
     //-- ลบผู้ที่ได้รับ Assign (ถ้ามี)--//
     if($post["removeAssignId"]!=""){
       $sql_upd_caseAssign = "UPDATE `Case_Assign`
                              SET
                              `caseAsign_status`='1'
                              WHERE caseAsign_id IN (".$post["removeAssignId"].") ";
       $qr_upd_caseAssign = $this->dbConn->query($sql_upd_caseAssign);
       if(!$qr_upd_caseAssign){
         $status_response = "01";
         $status_response_text = "Error Assign Remove SQL!";
       }
     }

     //-- เพิ่มผู้ที่ได้รับ Assign--//
     $text_assign_emp = "";
     for ($i=0; $i < count($post["emp_id_assign"]); $i++) {
       if($i>0){
         $text_assign_emp .= ", ";
       }
       $sql_chk_assign_emp = $sql_chk_assign."AND `caseAsign_status` = '0'
                           AND `emp_id` = '".$post["emp_id_assign"][$i]."' ";
       $qr_chk_assign_emp = $this->dbConn->query($sql_chk_assign_emp);
       $num_chk_assign_emp = $qr_chk_assign_emp->num_rows;
       $old_emp_assign = array();
       if($num_chk_assign_emp==0){
         //-- บันทึก ข้อมูล Assign Case --//
         $sql_ins_assign = "INSERT
                             INTO
                               `Case_Assign`(
                                 `case_id`,
                                 `caseAsign_status`,
                                 `emp_id`,
                                 `caseAsign_disKPI`,
                                 `caseAsign_create_datetime`,
                                 `caseAsign_createBy_id`
                               )
                             VALUES(
                               '$case_id',
                               '0',
                               '".$post["emp_id_assign"][$i]."',
                               '0',
                               NOW(),
                               '".$this->admin_id."'
                             ) ";

         $qr_ins_assign = $this->dbConn->query($sql_ins_assign);
         if(!$qr_ins_assign){
           $status_response = "01";
           $status_response_text = "Error Assign SQL!";
         }
       }else{
         array_push($old_emp_assign,$post["emp_id_assign"][$i]);
       }

       $sql_emp = "SELECT emp_real_id, emp_firstname, emp_lastname
                    FROM `Employee`
                    WHERE emp_id = '".$post["emp_id_assign"][$i]."' ";
       $qr_emp = $this->dbConn->query($sql_emp);
       $rs_emp = $qr_emp->fetch_assoc();
       $text_assign_emp .= " ID:".sprintf("%07d",$rs_emp["emp_real_id"])." ".$rs_emp["emp_firstname"]." ".$rs_emp["emp_lastname"];
     }
   }


   if($status_response=="00"){
     /* commit insert */
     $this->dbConn->commit();

     $result_noti = $this->send_notification(NULL,$case_id,"assign",$old_emp_assign);

     /* Log insert */
     if($type_log=="10"){
         $text = "Assign to";
     }else{
        $text = "Re-Assign to";
     }
     $text = $text.$text_assign_emp;
     $this->save_log($type_log,$case_id,NULL,$text);

   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }
   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_case_id'=>$case_id);


 }

 //-- ฟังก์ชั่นบันทึกแก้ไข Assign Case --//
 public function close_case($post){
   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();

   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $case_id = $post["case_id"];
   $caseClose_id = $post["caseClose_id"];
   $case_close_resultProcess = $post["case_close_resultProcess"];

   $status_response = "00";
   $status_response_text = "success";

   if($caseClose_id=="" || $case_close_resultProcess==""){
      $status_response = "02";
      $status_response_text = "กรุณาเลือกสถานะการยุติข้อร้องเรียน และระบุผลการดำเนินงาน ให้ครบถ้วน";
   }else{
     $sql_udp_case = "UPDATE `Case`
                       SET
                         `case_status` = '3',
                         `caseClose_id` = '".$post["caseClose_id"]."',
                         `case_close_resultProcess` = '".$post["case_close_resultProcess"]."',
                         `case_close_datetime` = NOW(),
                         `case_close_createBy_id` = '".$this->admin_id."'
                       WHERE `case_id` = '$case_id' ";
     $qr_udp_case = $this->dbConn->query($sql_udp_case);
     if(!$qr_udp_case){
       $status_response = "01";
       $status_response_text = "Error Open Case 1 SQL!";
     }
   }

   if($status_response=="00"){
     /* commit insert */
     $this->dbConn->commit();

     $result_noti = $this->send_notification(4,$case_id);

     /* Log insert */
     $type_log = "30";

     $caseCloseList = $this->caseCloseList();
     $text = "ยุติข้อร้องเรียน - ".$caseCloseList[$post["caseClose_id"]];
     $this->save_log($type_log,$case_id,NULL,$text);
   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }
   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_case_id'=>$case_id);

 }

 //-- ฟังก์ชั่นบันทึกแก้ไข Assign Case --//
 public function dis_kpi_case($post){
   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();
   /* disable autocommit */
   //$this->dbConn->autocommit(FALSE);

   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $case_id = $post["case_id"];

   $status_response = "00";
   $status_response_text = "success";

   if($post["emp_id_assign"]==""){
     $status_response = "02";
     $status_response_text = "กรุณา...เลือกผู้ได้รับ KPI ติดลบ";
   }else{

     $sql_udp_case = "UPDATE `Case`
                       SET
                         `case_disKPI_status` = '1',
                         `case_disKPI_datetime` = NOW(),
                         `case_disKPI_createBy_id` = '".$this->admin_id."'
                       WHERE `case_id` = '$case_id' ";
     $qr_udp_case = $this->dbConn->query($sql_udp_case);
     if(!$qr_udp_case){
       $status_response = "01";
       $status_response_text = "Error Dis KPI for Case table 1 SQL!";
     }else{
       $sql_ins_assign = "UPDATE `Case_Assign`
                            SET
                               `caseAsign_disKPI` = '1'
                            WHERE `case_id`='$case_id'
                            AND `emp_id`='".$post["emp_id_assign"]."' ";

       $qr_ins_assign = $this->dbConn->query($sql_ins_assign);
       if(!$qr_ins_assign){
         $status_response = "01";
         $status_response_text = "Error Dis KPI for Assign table SQL!";
       }
     }
   }

   if($status_response=="00"){
     /* commit insert */
     $this->dbConn->commit();
   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }
   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_case_id'=>$case_id);
 }

 //-- ฟังก์ชั่นบันทึกแก้ไข Assign Case --//
 public function save_to_knowledge($post){
   /* mysqli_begin_transaction */
   $this->dbConn->begin_transaction();
   /* disable autocommit */
   //$this->dbConn->autocommit(FALSE);
   foreach($post as $key => $value) {
     if(is_array($value)){
       foreach($value as $key1 => $value1) {
         $post[$key][$key1] = $this->data_filter($value1);
       }
     }else{
       $post[$key] = $this->data_filter($value);
     }
   }

   $case_id = $post["case_id"];

   $status_response = "00";
   $status_response_text = "success";



   $sql_ins_knowledge = "INSERT
                        INTO
                          `Case_Knowledge`(
                            `case_id`,
                            `compType_id`,
                            `caseKnlg_status`,
                            `caseKnlg_enable`,
                            `caseDtl_title`,
                            `prodType_id`,
                            `caseDtl_derivation`,
                            `caseDtl_damage_val`,
                            `curren_id`,
                            `caseDtl_complnt_need`,
                            `caseClose_id`,
                            `case_close_resultProcess`,
                            `applnt_name`,
                            `complnt_name`,
                            `case_create_datetime`,
                            `case_createBy_id`
                          )
                          ";
   $sql_ins_knowledge .= "SELECT
                           `case_id`,
                           `compType_id`,
                           '0',
                           '1',
                           `caseDtl_title`,
                           `prodType_id`,
                           `caseDtl_derivation`,
                           `caseDtl_damage_val`,
                           `curren_id`,
                           `caseDtl_complnt_need`,
                           `caseClose_id`,
                           `case_close_resultProcess`,
                           `applnt_name`,
                           `complnt_name`,
                           NOW(),
                           '".$this->admin_id."'
                          ";
  $sql_ins_knowledge .= "FROM `Case` ";
	$sql_ins_knowledge .= "WHERE `case_id` = '$case_id' ";
   $qr_ins_knowledge = $this->dbConn->query($sql_ins_knowledge);
   if(!$qr_ins_knowledge){
     $status_response = "01";
     $status_response_text = "Error send to knowledge SQL!";
   }else{
     $sql_udp_case .= "UPDATE `Case` SET `case_knowledge_type` = '1' WHERE `case_id` = '$case_id' ";
     $qr_udp_case = $this->dbConn->query($sql_udp_case);
     if(!$qr_ins_knowledge){
       $status_response = "01";
       $status_response_text = "Error update case to knowledge SQL!";
     }
   }

   if($status_response=="00"){
     /* commit insert */
     $this->dbConn->commit();
   }else{
     /* Rollback */
     $this->dbConn->rollback();

   }
   mysqli_close($this->dbConn);
   return array('status_response' => $status_response,'status_response_text' => $status_response_text,'case_id'=>$case_id);


 }


}

?>
