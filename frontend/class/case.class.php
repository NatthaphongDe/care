<?php
class case_base extends main{
  var $db;
  var $dbConn;
  var $admin_id;
  var $admin_position;
  var $admin_section;
  var $prod_type; //ประเภทสินค้า
  var $comp_type; //ประเภทเรื่องร้องเรียน
  var $priority_selct; //Priority
  var $case_status; //Status Case
  var $case_channal; //Channal Case
  var $case_country; //Country
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

    $this->admin_id = $_SESSION["member_id"];
    $this->admin_position = "1";
    $this->admin_section = "1";
    $this->prod_type = array();
    $this->comp_type = array();
    $this->priority_selct = array();
    $this->case_status = array();
    $this->case_currency = array();
    $this->processType = array();
    $this->closeType = array();
    $this->file_accept = array("jpg","jpeg","png","doc","docx","xls","xlsx","ppt","pptx","pdf","zip","rar");
    $this->typeForm = array('a','b','c');
    $this->day_overdue_case = 60;
    $this->gender = array("f"=>"หญิง","m"=>"ชาย");

  }

  // --ฟังก์ชั่นเรียกรายการประเภทสินค้า --//
  public function prodTypeListMutiLv($lv,$ref_id){
    $prodTypeArrObj = array();
    $sql = "SELECT *
    FROM Product_Type
            WHERE prodType_level = '$lv'
            AND prodType_status = '0'
            AND prodType_enable = '1' ";
    if($ref_id!=""){
      $sql .= "AND prodType_ref_id = '$ref_id' ";
    }
    $query = $this->dbConn->query($sql);
    $prod_num = $query->num_rows;
    $lv++;
      while($result = $query->fetch_assoc()){
        //$prodArr[$result["prodType_id"]] = $result["prodType_name"];
        $prodArr["prodType_id"] = $result["prodType_id"];
        $prodArr["prodType_name"] = $result["prodType_name"];
        $prodArr["prodType_name_en"] = $result["prodType_name_en"];
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

  // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน --//
  public function compTypeList(){

    // --Complaint_Type -- //
    $compArrObj = array();
    $sql = "SELECT * FROM Complaint_Type WHERE compType_status='0' ORDER BY compType_order_sort ASC  ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $compArr_list = array();
      $compType_id = $result["compType_id"];
      $compArr_list['compType_id'] = $compType_id;
      $compArr_list['compType_name'] = $result["compType_name"];
      $compArr_list['compType_name_en'] = $result["compType_name_en"];
      $compArr_list['compType_other_flag'] = $result["compType_other_flag"];

      // --Complaint_Type_Sub1 -- //
      $sql_sub1 = "SELECT * FROM Complaint_Type_Sub1 WHERE compType_id='$compType_id' AND compTypeSub1_status = '0' ";
      $query_sub1 = $this->dbConn->query($sql_sub1);
      $num_sub1 = $query_sub1->num_rows;
      if($num_sub1>0){
        $compArr_list['compTypeSub1_list'] = array();
        while($result_sub1 = $query_sub1->fetch_assoc()){
          $compArrSub1_list = array();
          $compTypeSub1_id = $result_sub1["compTypeSub1_id"];
          $compArrSub1_list['compTypeSub1_id'] = $compTypeSub1_id;
          $compArrSub1_list['compTypeSub1_name'] = $result_sub1["compTypeSub1_name"];
          $compArrSub1_list['compTypeSub1_name_en'] = $result_sub1["compTypeSub1_name_en"];

          // --Complaint_Type_Sub2 -- //
          $sql_sub2 = "SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub1_id='$compTypeSub1_id' AND compTypeSub2_status = '0' ";
          $query_sub2 = $this->dbConn->query($sql_sub2);
          $num_sub2 = $query_sub2->num_rows;
          if($num_sub2>0){
            $compArrSub1_list['compTypeSub2_list'] = array();
            while($result_sub2 = $query_sub2->fetch_assoc()){
              $compArrSub2_list = array();
              $compTypeSub2_id = $result_sub2["compTypeSub2_id"];
              $compArrSub2_list['compTypeSub2_id'] = $compTypeSub2_id;
              $compArrSub2_list['compTypeSub2_name'] = $result_sub2["compTypeSub2_name"];
              $compArrSub2_list['compTypeSub2_name_en'] = $result_sub2["compTypeSub2_name_en"];
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
  // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน ใหม่แยก ต่างประเทศกับกรม 10-6-53 --//
  public function compTypeList_2($type){

    // --Complaint_Type -- //
    $compArrObj = array();
    $sql = "SELECT * FROM Complaint_Type WHERE compType_status='0' AND compType_section = '$type' ORDER BY compType_order_sort ASC  ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $compArr_list = array();
      $compType_id = $result["compType_id"];
      $compArr_list['compType_id'] = $compType_id;
      $compArr_list['compType_name'] = $result["compType_name"];
      $compArr_list['compType_name_en'] = $result["compType_name_en"];
      $compArr_list['compType_other_flag'] = $result["compType_other_flag"];

      // --Complaint_Type_Sub1 -- //
      $sql_sub1 = "SELECT * FROM Complaint_Type_Sub1 WHERE compType_id='$compType_id' AND compTypeSub1_status = '0' ";
      $query_sub1 = $this->dbConn->query($sql_sub1);
      $num_sub1 = $query_sub1->num_rows;
      if($num_sub1>0){
        $compArr_list['compTypeSub1_list'] = array();
        while($result_sub1 = $query_sub1->fetch_assoc()){
          $compArrSub1_list = array();
          $compTypeSub1_id = $result_sub1["compTypeSub1_id"];
          $compArrSub1_list['compTypeSub1_id'] = $compTypeSub1_id;
          $compArrSub1_list['compTypeSub1_name'] = $result_sub1["compTypeSub1_name"];
          $compArrSub1_list['compTypeSub1_name_en'] = $result_sub1["compTypeSub1_name_en"];

          // --Complaint_Type_Sub2 -- //
          $sql_sub2 = "SELECT * FROM Complaint_Type_Sub2 WHERE compTypeSub1_id='$compTypeSub1_id' AND compTypeSub2_status = '0' ";
          $query_sub2 = $this->dbConn->query($sql_sub2);
          $num_sub2 = $query_sub2->num_rows;
          if($num_sub2>0){
            $compArrSub1_list['compTypeSub2_list'] = array();
            while($result_sub2 = $query_sub2->fetch_assoc()){
              $compArrSub2_list = array();
              $compTypeSub2_id = $result_sub2["compTypeSub2_id"];
              $compArrSub2_list['compTypeSub2_id'] = $compTypeSub2_id;
              $compArrSub2_list['compTypeSub2_name'] = $result_sub2["compTypeSub2_name"];
              $compArrSub2_list['compTypeSub2_name_en'] = $result_sub2["compTypeSub2_name_en"];
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
  // --ฟังก์ชั่นเรียกรายการความสำคัญ --//
  public function prioritySelectList(){
    $case_priority_arr = array();
    $sql = "SELECT * FROM Case_Priority WHERE casePrt_status='0' AND casePrt_section='$this->admin_section' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $case_priority_arr[$result["casePrt_id"]] = $result["casePrt_name"];
    }
    return $case_priority_arr;
  }

  // --ฟังก์ชั่นเรียกรายการความสำคัญ --//
  public function caseStatusList(){
    $caseStatusArrObj = array();
    $case_status_main = array('0'=>'Waiting', '1'=>'New', '2'=>'Pending', '4'=>'Overdue', '3'=>'Close');
    $case_status_overdue = array('1'=>'Sub process', '2'=>'Main process');
    $case_status_close = array('1'=>'ตกลงกันได้', '2'=>'ผู้ร้องดำเนินการต่อ', '3'=>'ไม่สามารถดำเนินการได้ ');

    $caseStatusArrObj["case_status_main"] = $case_status_main;
    $caseStatusArrObj["case_status_main"] = $case_status_overdue;
    $caseStatusArrObj["case_status_main"] = $case_status_close;

    //$this->case_status = $caseStatusArrObj;
    return $caseStatusArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน-- //
  public function caseChannelList(){
    $caseChArr = array();
    $sql = "SELECT * FROM Case_Channel WHERE caseCh_status='0' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $caseChArr[$result["caseCh_id"]] = $result["caseCh_name"];
    }
    return $caseChArr;
  }

  // --ฟังก์ชั่นเรียกรายการช่อองทางการ้องเรียน-- //
  public function caseProcessTypeList($type){
    if($type=="all"){
      $sql_notin = "";
    }else{
        $sql_notin = "NOT IN (1,2)";
    }
    $caseProcArr = array();
    $sql = "SELECT * FROM Process_Type WHERE process_type_status='0' AND process_type_id $sql_notin AND process_type_section='$this->admin_section' ";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $caseProcArr[$result["process_type_id"]] = $result["process_type_name"];
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

  // --ฟังก์ชั่นเรียกรายการประเทศ --//
  public function countryList(){
    $countryArrObj = array();
    $sql = "SELECT * FROM Country ORDER BY name";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $countryArr["id"] = $result["id"];
      $countryArr["name"] = $result["name"];
      $countryArr["name_th"] = $result["name_th"];
      $countryArr["flag_32"] = $result["flag_32"];
      $countryArr["flag_128"] = $result["flag_128"];
      array_push($countryArrObj,$countryArr);
    }
    return $countryArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการจังหวัด --//
  public function provinceList(){
    $provArrObj = array();
    $sql = "SELECT * FROM Province";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $provArr["prov_id"] = $result["prov_id"];
      $provArr["prov_name"] = $result["prov_name"];
      $provArr["prov_name_eng"] = $result["prov_name_eng"];
      array_push($provArrObj,$provArr);
    }
    return $provArrObj;
  }

  // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน --//
  public function currencyList(){
    $currencyArrObj = array();
    $sql = "SELECT * FROM Currency";
    $query = $this->dbConn->query($sql);
    while($result = $query->fetch_assoc()){
      $currenArr["curren_id"] = $result["curren_id"];
      $currenArr["curren_name"] = $result["curren_name"];
      array_push($currencyArrObj,$currenArr);
    }
    return $currencyArrObj;
  }



    //-- ฟังก์ชั่นกำหนดรูปแบบฟอร์ม จาก ประเภทข้อร้องเรียน --//
    public function genFromSetForCompType(){
      $sqlFrom = "SELECT * FROM Form_Link_Complaint_Type ";
      $sqlFrom .= "WHERE compType_id='$this->compType_id' ";
      $sqlFrom .= "AND compTypeSub1_id='$this->compTypeSub1' ";
      $sqlForm2 = $sqlFrom."AND compTypeSub2_id='$this->compTypeSub2' ";
      $queryForm2 = $this->dbConn->query($sqlForm2);
      $numForm2 = $queryForm2->num_rows;
      if($numForm2>0){
        while($resultForm2 = $queryForm2->fetch_assoc()){
          $arr_formSetList_type =array();
          $arr_formSetList_type["frmset_id"] = $resultForm2["frmset_id"];
          $arr_formSetList_type["frmset_name"] = $resultForm2["frmset_name"];
          array_push($this->arr_formSetList,$arr_formSetList_type);
        }
      }else{
        $sqlForm = $sqlFrom."AND compTypeSub2_id='0'";
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
      // return $sqlForm2;
      return $this->arr_formSetList;
    }

    // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน --//
    public function genfileIcon($ext){
      $ext = strtolower($ext);
      if($ext=="pdf"){
        $icon_img = "pdf";
      }else if($ext=="jpg" || $ext=="jpge" || $ext=="png"){
        $icon_img = "image";
      }else if($ext=="doc" || $ext=="docx"){
        $icon_img = "word";
      }else if($ext=="xls" || $ext=="dxlsx"){
        $icon_img = "excel";
      }else if($ext=="ppt" || $ext=="pptx"){
        $icon_img = "powerpoint";
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
    public function get_case_data(){
      global $rs_case;

      $rs_case["case"]["my_case_owner"] = 0;
      $rs_case["case"]["my_case_assign"] = 0;

      $sql = "SELECT * FROM `Case` WHERE `case_id`='$this->case_id' ";
      $query = $this->dbConn->query($sql);
      $rs_case["case"] = $query->fetch_assoc();
      if(!($rs_case["case"]["caseCh_id"] == 1 || $rs_case["case"]["caseCh_id"] == 2)  && $rs_case["case"]["case_createBy_id"]==$this->admin_id){
        $rs_case["case"]["my_case_owner"] = 1;
      }
      return $rs_case;
    }
    //-- ฟังก์ชั่นดึงข้อมูลจาก Field_Values Table --//
    public function get_case_field_data(){
      global $rs_case;
      $rs_case["case_feild"] = array();
      $sql = "SELECT * FROM `Field_Values` a
              LEFT JOIN `Field_Set` b ON (a.fieldset_id=b.fieldset_id)
              WHERE `case_id`='$this->case_id' ";
      $query = $this->dbConn->query($sql);
      while($rs_feild = $query->fetch_assoc()){
        $rs_case["case_feild"][$rs_feild["fieldset_name"]] = $rs_feild["fieldset_value"];
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
         array_push($rs_case["case_Attachfile"],$rs_feild);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Reference Table --//
    public function get_case_ref_data(){
      global $rs_case;
      $rs_case["case_ref"] = array();
      $sql = "SELECT * FROM `Case_Ref` WHERE `case_id`='$this->case_id' ";
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
              WHERE cs.case_id='$this->case_id'
              ORDER BY logCase_id DESC";
      $query = $this->dbConn->query($sql);
      while($rs_logCase = $query->fetch_assoc()){
        array_push($rs_case["case_log"],$rs_logCase);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Assign Table --//
    public function get_case_assign_data(){
      global $rs_case;
      $rs_case["case_assign"] = array();
      $sql = "SELECT * FROM `Case_Assign` cs
              LEFT JOIN `Employee` e ON (cs.emp_id=e.emp_id)
              WHERE cs.case_id='$this->case_id'
              AND cs.caseAsign_status='0' ";
      $query = $this->dbConn->query($sql);
      while($rs_assignCase = $query->fetch_assoc()){
        if($rs_assignCase["emp_id"]==$this->admin_id){
          $rs_case["case"]["my_case_assign"] = 1;
        }
        array_push($rs_case["case_assign"],$rs_assignCase);
      }
      return $rs_case;
    }

    //-- ฟังก์ชั่นดึงข้อมูลจาก Case Process Table --//
    public function get_case_process_data(){
      global $rs_case;
      $rs_case["case_process"] = array();
      $sql = "SELECT * FROM `Process` WHERE `case_id`='$this->case_id' ";
      $query = $this->dbConn->query($sql);
      while($rs_processCase = $query->fetch_assoc()){
         array_push($rs_case["case_process"],$rs_processCase);
          $process_id = $rs_processCase["process_id"];

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
          $sql_proc = "SELECT * FROM `procPropEmail` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procEmail = $query_proc->fetch_assoc()){
             array_push($rs_case["process_email"][$rs_procEmail["procPropEmail_type"]][$process_id],$rs_procEmail);
          }

          $rs_case["process_mail"][1][$process_id] = array();
          $rs_case["process_mail"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropMail` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procMail = $query_proc->fetch_assoc()){
             array_push($rs_case["process_mail"][$rs_procMail["procPropMail_type"]][$process_id],$rs_procMail);
          }

          $rs_case["process_offcletter"][1][$process_id] = array();
          $rs_case["process_offcletter"][2][$process_id] = array();
          $sql_proc = "SELECT * FROM `procPropOffcLetter` WHERE `process_id`='$process_id' ";
          $query_proc = $this->dbConn->query($sql_proc);
          while($rs_procOffcLetter = $query_proc->fetch_assoc()){
             array_push($rs_case["process_offcletter"][$rs_procOffcLetter["procPropOffcLetter_type"]][$process_id],$rs_procOffcLetter);
          }
        }
        return $rs_case;
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

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();

    // foreach($post as $key => $value) {
    //   if(is_array($value)){
    //     foreach($value as $key1 => $value1) {
    //       $post[$key][$key1] = $this->data_filter($value1);
    //     }
    //   }else{
    //     $post[$key] = $this->data_filter($value);
    //   }
    // }

    $priorityTitle =  $this->prioritySelectList();

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

    $arr_sort = array("caseId"=>"case_id","subject"=>"caseDtl_title","date"=>"case_create_datetime");
    $arr_sort2 = array("applnt","complnt","status");
    $case_arr = array();
    $sql_case = "SELECT *  ";
    $sql_case .= "FROM `Case` c ";

    $sql_case_condition = "WHERE 1 ";
    if($post->prod_type!=""){
      $sql_case_condition .= "AND c.prodType_id = '$post->prod_type' ";
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
    if($post->status!=""){
      $sql_case_condition .= "AND c.case_status = '$post->status' ";

      // if($post->status=="sub_over"){
      //   $sql_case_join = "LEFT JOIN Process p ON (c.case_id = p.case_id) ";
      //   $sql_case_condition .= "AND c.case_status = '$post->status' ";
      //
      //   // $datatime_diff = $this->getDateTimeData($case_process["process_save_datetime"],$case_process["process_complete_datetime"]);
      //   // $time_over = strtotime($case_process["process_save_datetime"]) - strtotime($case_process["process_over_datetime"],' - '.$datatime_diff["days"].' days'  );
      //   // if($case_process["process_complete_datetime"]!=""){
      //   //   $time_compare = strtotime($case_process["process_save_datetime"]) - strtotime($case_process["process_complete_datetime"],' - '.$datatime_diff["days"].' days');
      //   // }else{
      //   //   $time_compare = time();
      //   // }
      //
      //   $sql_case_condition .= "AND (
      //     p.process_complete_datetime = NULL AND c.case_status = '".time()>$case_process["process_over_datetime"]."'
      //     OR p.process_complete_datetime != NULL AND c.case_status = '".time()>$case_process["process_over_datetime"]."'
      //   )";
      // }
    }
    if($post->close_id!=""){
      $sql_case_condition .= "AND c.caseClose_id = '".$post->close_id."' ";
    }
    if($post->channel!=""){
      $sql_case_condition .= "AND c.caseCh_id = '$post->channel' ";
    }
    if($post->country!=""){
      $sql_case_condition .= "AND (c.applnt_country_id = '$post->country' ";
      $sql_case_condition .= "OR c.complnt_country_id = '$post->country') ";
    }
    if($post->date!=""){
      $dateSplit = explode(" - ",$post->date);
      $dateStart = DateTime::createFromFormat('d/m/Y', $dateSplit[0])->format('Y-m-d');
      $dateEnd = DateTime::createFromFormat('d/m/Y', $dateSplit[1])->format('Y-m-d');
      $sql_case_condition .= "AND DATE(c.case_create_datetime) >= '$dateStart' AND DATE(c.case_create_datetime) <= '$dateEnd' ";
    }
    if($post->valid_dbd=="1"){
      $sql_case_condition .= "AND (applnt_valid_dbd='1' OR complnt_valid_dbd='1') ";
    }
    if($post->valid_ditp!=""){
      if($post->valid_ditp=="2"){
        $sql_case_condition .= "AND (applnt_valid_dbd='2') ";
      }else{
        $sql_case_condition .= "AND ((applnt_valid_dbd='1' AND applnt_valid_ditp_org='$post->valid_ditp') OR (complnt_valid_dbd='1' AND complnt_valid_ditp_org='$post->valid_ditp')) ";
      }
    }

    if($post->text!=""){
      $sql_case_condition .= "
        AND ( c.case_id like '%".(int)$post->text."%'
              OR c.case_id like '%$post->text%'
              OR c.caseDtl_title like '%$post->text%' ";
      $sql_case_condition .= "
              OR (
                (c.applnt_type!=0 AND c.applntOrg_name like '%$post->text%')
                OR (c.applnt_type=0 AND (c.applnt_firstname like '%$post->text%' OR c.applnt_lastname like '%$post->text%'))
              )";
      $sql_case_condition .= "
              OR (
                 (c.complnt_type!=0 AND c.complntOrg_name like '%$post->text%')
                 OR (c.complnt_type=0 AND (c.complnt_firstname like '%$post->text%' OR c.complnt_lastname like '%$post->text%'))
              )
            ) ";
    }
    $sort = $post->sort;
    $order = $post->order;
    if(array_key_exists($sort,$arr_sort)){
      $sql_case_condition .= "ORDER BY `".$arr_sort[$sort]."` ".$order." ";
    }else{
      if(in_array($sort,$arr_sort2)){
        if($sort=="applnt" || $sort=="complnt"){
          $sql_case_condition .= "ORDER BY `".$sort."Org_name` ".$order.",`".$sort."_name` ".$order.",`".$sort."_firstname` ".$order.",`".$sort."_lastname` ".$order." ";
        }else{
          $sql_case_condition .= "ORDER BY `case_status` ".$order." ";;
        }
      }
    }

    $sql_case = $sql_case.$sql_case_condition;

    //return $sql_case;
    $query_case = $this->dbConn->query($sql_case);
    $count_case = $query_case->num_rows;
    while($rs_case_list = $query_case->fetch_assoc()){


      $show_status = 1;
      if($post->status=="2"){
        $datatime_diff = $this->getDateTimeData($rs_case["case"]["case_opened_datetime"],date('Y-m-d H:i:s'));
        if($rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["day"]>$this->day_overdue_case){
          $show_status==0;
        }
      }else if($post->status=="main_over"){
        $datatime_diff = $this->getDateTimeData($rs_case["case"]["case_opened_datetime"],date('Y-m-d H:i:s'));
        if($rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["day"]<$this->day_overdue_case){
          $show_status==0;
        }
      }


      if($show_status==1){
        $case_col_arr =array();
        $rs_case = array();
        $this->case_id = $rs_case_list["case_id"];
        $rs_case = $this->get_case_data();
        $rs_case = $this->get_case_process_data();

        $case_col_arr["caseId"] = sprintf("%05d",$rs_case["case"]["case_id"]);
        $case_col_arr["caseId"] = '<a href="index.php?page=case_detail&caseId='.$rs_case["case"]["case_id"].'">'.$case_col_arr["caseId"].'</a>';

        $case_col_arr["subject"] = $rs_case["case"]["caseDtl_title"]." <i class=\"ico-priority ico-priority-".$rs_case["case"]["case_priority"]."\" title=\"".$priorityTitle[$rs_case["case"]["case_priority"]]."\"></i>";

        $case_col_arr["subject"] = '<a href="index.php?page=case_detail&caseId='.$rs_case["case"]["case_id"].'">'.$case_col_arr["subject"].'</a>';


        if($rs_case["case"]["applnt_type"]!=0){
          if($rs_case["case"]["applntOrg_name"]==""){
            $case_col_arr["applnt"] = '';
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
        if($rs_case["case"]["applnt_country_id"]!=0){
          $case_col_arr["applnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(img/flags/".$countryList[$rs_case["case"]["applnt_country_id"]]["flag_32"]."\");\"></i>";
        }
        if($rs_case["case"]["applnt_valid_ditp"]==1){
          $case_col_arr["applnt"] .= '<i class="ico-ditp ico-ditp-1"></i>';
        }
        if($rs_case["case"]["applnt_valid_dbd"]==1){
          $case_col_arr["applnt"] .= '<i class="ico-dbd ico-dbd-1"></i>';
        }
        if($rs_case["case"]["applnt_backlist"]==2){
          $case_col_arr["applnt"] .= '<i class="ico-backlist ico-backlist-2"></i>';
        }

        //if($rs_case["case"]["complnt_type"]!=0){
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
        //}

        if($rs_case["case"]["complnt_country_id"]!=0){
          $case_col_arr["complnt"] .= "<i class=\"ico-flag\" style=\"background-image: url(img/flags/".$countryList[$rs_case["case"]["complnt_country_id"]]["flag_32"]."\");\"></i>";
        }
        if($rs_case["case"]["complnt_valid_ditp"]==1){
          $case_col_arr["complnt"] .= '<i class="ico-ditp ico-ditp-1"></i>';
        }
        if($rs_case["case"]["complnt_valid_dbd"]==1){
          $case_col_arr["complnt"] .= '<i class="ico-dbd ico-dbd-1"></i>';
        }
        if($rs_case["case"]["complnt_backlist"]==2){
          $case_col_arr["complnt"] .= '<i class="ico-backlist ico-backlist-2"></i>';
        }

        $case_col_arr["date"] = date("d/m/Y",strtotime($rs_case["case"]["case_create_datetime"]));

        $statusCaseClose_type = "";
        if($rs_case["case"]["case_status"]==0 || $rs_case["case"]["case_status"]==1){ //สถานะ Waiting, New
          $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
        }else if($rs_case["case"]["case_status"]==2){ //สถานะ Pending
          //หาจำนวนวันทำการที่ใช้ไป
          $datatime_diff = $this->getDateTimeData($rs_case["case"]["case_opened_datetime"],date('Y-m-d H:i:s'));
          if($rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $this->day_overdue_case){ //ถ้าเกิน $this->day_overdue_case วัน
            $statusCase = '<img src="img/ico_case_status_4.png" class="img-status" />';
          }else{ //ถ้าไม่เกิน $this->day_overdue_case วัน
            $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
          }
        }else if($rs_case["case"]["case_status"]==3){ //สถานะ Close
          //หาจำนวนวันทำการที่ใช้ไป
          $datatime_diff = $this->getDateTimeData($rs_case["case"]["case_opened_datetime"],$rs_case["case"]["case_close_datetime"]);
          if($rs_case["case"]["case_opened_datetime"]!="" && $datatime_diff["days"] > $this->day_overdue_case){ //ถ้าเกิน $this->day_overdue_case วัน
            if($rs_case["case"]["case_disKPI_status"]==1){ //ถ้ามีการ Dis KPI
              $statusCase = '<img src="img/ico_case_status_5-2.png" class="img-status" />';
            }else{ //ถ้าไม่มีการ Dis KPI
              $statusCase = '<img src="img/ico_case_status_5-1.png" class="img-status" />';
            }
          }else{ //ถ้าไม่เกิน $this->day_overdue_case วัน
            $statusCase = '<img src="img/ico_case_status_'.$rs_case["case"]["case_status"].'.png" class="img-status" />';
            $statusCaseClose_type = '<img src="img/ico_caseClose_'.$rs_case["case"]["caseClose_id"].'.png" class="img-status-close" />';

          }
          $statusCase = $statusCase.$statusCaseClose_type;
        }
        if($rs_case["case"]["case_status"]!=0){

        	$processTypeName = $this->caseProcessTypeList("all");

          $processOverDue = "";
          $w_prc = 0;
          foreach ($rs_case["case_process"] as $case_process) {

            $datatime_diff = $this->getDateTimeData($case_process["process_save_datetime"],$case_process["process_complete_datetime"]);
            $time_over = $case_process["process_over_datetime"];
            if($case_process["process_complete_datetime"]!=""){
              $time_compare = strtotime($case_process["process_save_datetime"]) - strtotime($case_process["process_complete_datetime"],' - '.$datatime_diff["days"].' days');
            }else{
              $time_compare = time();
            }

            if($time_compare>$time_over){
              $processOverDue_text = $case_process["process_over_note"];
              $processOverDue .= '<img  src="img/ico_process_overdue.png" class="img-status-process-overdue" style="margin-left:5px;" data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$processOverDue_text.'" />';
              $w_prc+=21;
    				}
            // else{
            //   // $processOverDue_text = "test test test test";
            //   // $processOverDue .= '<img  src="img/ico_process_overdue.png" class="img-status-process-overdue" style="margin-left:5px;" data-toggle="tooltip" data-placement="bottom" data-html="true" title="'.$processOverDue_text.'" />';
            //   // $w_prc+=21;
            // }
          }
          $statusCase = $statusCase.$processOverDue;
        }


        $html_statusCase = '<div class="" style="float:left; height:64px; width:'.(178+$w_prc).'px;">'.$statusCase.'</div>';

        $case_col_arr["status"] = $html_statusCase;
        array_push($case_arr,$case_col_arr);
      }



      //}
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
    global $lang;
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

    $countryList = "";
    if(count($this->case_country==0)){
      $this->case_country = $this->countryList();
    }
    foreach($this->case_country as $case_country_list){
      global $lang;
      if($lang == "1"){
        $name = $case_country_list["name"];
      }elseif ($lang == "2") {
        $name = $case_country_list["name"];
      }else {
        $name = $case_country_list["name"];
      }
      if($case_country_list["id"] == 162){
        $countryList .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["complnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$name.'
                        </option>';
      }
    }

    foreach($this->case_country as $case_country_list){
      global $lang;
      if($lang == "1"){
        $name = $case_country_list["name"];
      }elseif ($lang == "2") {
        $name = $case_country_list["name"];
      }else {
        $name = $case_country_list["name"];
      }
      if($case_country_list["id"] != 162){
        $countryList2 .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["complnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$name.'
                        </option>';
      }
    }

    foreach($this->case_country as $case_country_list){
      global $lang;
      if($lang == "1"){
        $name = $case_country_list["name"];
      }elseif ($lang == "2") {
        $name = $case_country_list["name"];
      }else {
        $name = $case_country_list["name"];
      }
        $countryList3 .= '<option value="'.$case_country_list["id"].'" '.($rs_case["case_feild"]["complnt_country_id"]==$case_country_list["id"]?'selected':'').'>
                          '.$name.'
                        </option>';
    }


    if(count($this->case_province==0)){
      $this->case_province = $this->provinceList();
    }

    $provinceList_pers = "";
    foreach($this->case_province as $case_province_list){
      global $lang;
      if($lang == "1"){
        $prov_name = $case_province_list["prov_name"];
      }elseif ($lang == "2") {
        $prov_name = $case_province_list["prov_name_eng"];
      }else {
        $prov_name = $case_province_list["prov_name"];
      }
      $provinceList_pers .= '<option value="'.$case_province_list["prov_id"].'" '.($rs_case["case_feild"]["applnt_prov_id"]==$case_province_list["prov_id"]?'selected':'').'>
                        '.$prov_name.'</option>';
    }

    $provinceList_compn = "";
    foreach($this->case_province as $case_province_list){
      $provinceList_compn .= '<option value="'.$case_province_list["prov_id"].'" '.($rs_case["case_feild"]["applntOrg_prov_id"]==$case_province_list["prov_id"]?'selected':'').'>
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

    $provinceList_pers = array();
    foreach($this->case_province as $case_province_list){
      $provinceList_pers[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
    }

    $provinceList_compn = "";
    foreach($this->case_province as $case_province_list){
      $provinceList_compn[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
    }


    $typeformset = "case_open_detail";

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

    return $rs_case;
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

   $provinceList_pers = array();
   foreach($this->case_province as $case_province_list){
     $provinceList_pers[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
   }

   $provinceList_compn = "";
   foreach($this->case_province as $case_province_list){
     $provinceList_compn[$case_province_list["prov_id"]] = $case_province_list["prov_name"];
   }


  $typeformset = "case_detail";

  include("formset/formset_".$formSetId.".php");

   return $formSet_html;
 }
 
}

?>
