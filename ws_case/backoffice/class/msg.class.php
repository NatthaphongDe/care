<?php
class msg_base extends main{
  var $db;
  var $dbConn;
  var $admin_id;
  var $admin_firstname;
  var $admin_lastname;
  var $admin_position;
  var $admin_section;
  var $file_accept;

  public function __construct(){
    global $db,$conn;
    $this->db = $db;
    $this->dbConn = $conn;
    $this->admin_id = $_SESSION["admin"]["empId"];
    $this->admin_firstname = $_SESSION["admin"]["empFirstname"];
    $this->admin_lastname = $_SESSION["admin"]["empLastname"];
    $this->admin_position = $_SESSION["admin"]["empPosition"];
    $this->admin_section = $_SESSION["admin"]["empSection"];
    $this->file_accept = array("jpg","jpeg","png","doc","docx","xls","xlsx","ppt","pptx","pdf","zip","rar");
  }

  // --ฟังก์ชั่นเรียกรายการประเภทดารร้องเรียน --//
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

  public function getNotiList($post){

    $noti_arr = array();

    $sql_noti = "SELECT *  ";
    $sql_noti .= "FROM `Message_Noti_Employee` ";
    $sql_noti .= "WHERE `emp_id` = '$this->admin_id' ";
    $sort = $post->sort;
    $order = $post->order;
    $offset = $post->offset;
    $limit = $post->limit;
    $sql_noti_condition .= "ORDER BY `msgNotiEmp_id` DESC LIMIT $offset, $limit";


    $sql_noti = $sql_noti.$sql_noti_condition;
    $query_noti = $this->dbConn->query($sql_noti);
    $count_noti = $query_noti->num_rows;
    while($rs_noti_list = $query_noti->fetch_assoc()){
      $noti_col_arr =array();
      if($rs_noti_list["case_id"] == 0) {
        $msgNotiEmp_message = '<a href="index.php?page=frontend_questionAW&refpage=update_read" class="txt-green">'.$rs_noti_list["msgNotiEmp_message"].'</a>';
      } else {
        $msgNotiEmp_message_tmp = explode("&spt;",$rs_noti_list["msgNotiEmp_message"]);
        $msgNotiEmp_message = $msgNotiEmp_message_tmp[0].'<a href="index.php?page=case_detail&refpage=update_read&caseId='.$rs_noti_list["case_id"].'" class="txt-green">'.$msgNotiEmp_message_tmp[1].'</a>'.$msgNotiEmp_message_tmp[2];
      }
      
      $noti_col_arr["notiList"] = '<div class="col-xs-12 noti-list-item">
      <span class="col-xs-9 msg">'.$msgNotiEmp_message.'</span>
      <span class="col-xs-3 txt-date">1 ชั่วโมง</span>
    </div>';
      array_push($noti_arr,$noti_col_arr);
    }

    $data_array = array('total' => $count_noti,'rows' => $noti_arr);
    mysqli_close($this->dbConn);
    return json_encode($data_array);
  }

  public function total_noti_unread(){
    

    $sql_noti = "SELECT *  ";
    $sql_noti .= "FROM `Message_Noti_Employee` ";
    $sql_noti .= "WHERE `emp_id` = '$this->admin_id' AND msgNotiEmp_noti_status = '0' ";
    $query_noti = $this->dbConn->query($sql_noti);
    $total = $query_noti->num_rows;
    if($total>99){
      $total= "99+";
    }else if($total==0){
      $total= "";
    }
    return $total;
  }

  public function getNotiList_popup(){

    

    $noti_arr = array();

    $sql_noti = "SELECT *  ";
    $sql_noti .= "FROM `Message_Noti_Employee` ";
    $sql_noti .= "WHERE `emp_id` = '$this->admin_id' ";
    $sql_noti_condition .= "ORDER BY `msgNotiEmp_id` DESC LIMIT 10 ";
    $sql_noti = $sql_noti.$sql_noti_condition;
    $query_noti = $this->dbConn->query($sql_noti);
    while($rs_noti_list = $query_noti->fetch_assoc()){
      if($rs_noti_list["case_id"] == 0) {
        $msgNotiEmp_message = '<a href="index.php?page=frontend_questionAW&refpage=update_read" class="txt-green">'.$rs_noti_list["msgNotiEmp_message"].'</a>';
      } else {
        $msgNotiEmp_message_tmp = explode("&spt;",$rs_noti_list["msgNotiEmp_message"]);
        $msgNotiEmp_message = $msgNotiEmp_message_tmp[0].'<a href="index.php?page=case_detail&refpage=update_read&caseId='.$rs_noti_list["case_id"].'" class="txt-green">'.$msgNotiEmp_message_tmp[1].'</a>'.$msgNotiEmp_message_tmp[2];
      }
      $rs_noti_list["msgNotiEmp_message"] = $msgNotiEmp_message;
      array_push($noti_arr,$rs_noti_list);
    }

    return $noti_arr;
  }

  public function total_msg_unread(){

    $sql_msg = "SELECT *  ";
    $sql_msg .= "FROM `Message_Box_Log` ";
    $sql_msg .= "WHERE recipient_type = '2' AND recipient_id='$this->admin_id' AND msgBox_noti_status = '0' ";

    $query_msg = $this->dbConn->query($sql_msg);
    $total = $query_msg->num_rows;
    if($total>99){
      $total= "99+";
    }else if($total==0){
      $total= "";
    }
    return $total;
  }

  public function getMsgBoxList($post){

    $msg_arr = array();
    $caseId_arr = array();

    $caseLst_cls = new case_list();
    $case_ass = $caseLst_cls->get_case_assign_data("emp_id");
    foreach($case_ass["case_assign"] as $case_assign){
      array_push($caseId_arr,$case_assign["case_id"]);
    }

    $sql_msg = "SELECT *  ";
    $sql_msg .= "FROM `Message_Box` msg ";
    $sql_msg .= "LEFT JOIN `Case` c ON (msg.case_id=c.case_id) ";
    $sql_msg .= "WHERE msg.msgBox_status = '0' ";
    $sql_msg .= "AND msg.msgBox_type = 1 ";
    $sql_msg .= "AND ( ";
    $sql_msg .= "(msg.sender_type='2' AND (msg.sender_id = '$this->admin_id' OR msg.case_id IN (".join(',',$caseId_arr)."))) ";
    $sql_msg .= "OR (msg.sender_type='1' AND msg.case_id IN (".join(',',$caseId_arr).") ) ";
    $sql_msg .= ") ";
    $offset = $post->offset;
    $limit = $post->limit;
    $sql_msg_condition .= "ORDER BY msg.msgBox_id DESC LIMIT $offset, $limit";


    $sql_msg = $sql_msg.$sql_msg_condition;
    $query_msg = $this->dbConn->query($sql_msg);
    $count_msg = $query_msg->num_rows;
    while($rs_msg_list = $query_msg->fetch_assoc()){
      $msg_col_arr =array();

      $sql_msg_log = "SELECT *  ";
      $sql_msg_log .= "FROM `Message_Box_Log` ";
      $sql_msg_log .= "WHERE recipient_type = 2 AND recipient_id='$this->admin_id' AND msgBox_id='".$rs_msg_list["msgBox_id"]."' ";
      $query_msg_log = $this->dbConn->query($sql_msg_log);
      $count_msg_log = $query_msg_log->num_rows;
      $msgBox_read_status = 0;
      while($rs_msg_log = $query_msg_log->fetch_assoc()){
        if($rs_msg_log["msgBox_read_status"]==0){
          $msgBox_read_status = 1;
        }
      }

      $ico_unread = '<i class="col-xs-1 glyph-icon icon-circle icon-notread  no-gutter" style="visibility:hidden"></i>';
      if($count_msg_log>0 && $msgBox_read_status==1){
        $ico_unread = '<i class="col-xs-1 glyph-icon icon-circle icon-notread  no-gutter"></i>';
      }
      $msg_col_arr["msgList"] = '<ul class="list-file col-sm-12" id="msgId_'.$rs_msg_list["msgBox_id"].'" >
                                    <li class="no-gutter">
                                      <div class="col-xs-12 col-sm-6 list_file_name no-gutter">
                                        '.$ico_unread.'
                                        <div class="col-xs-11 col-text  no-gutter">
                                          <p class="title-msg">Case ID '.sprintf("%05d",$rs_msg_list["case_id"]).' - '.$rs_msg_list["caseDtl_title"].'</p>
                                          <p class="des-msg">'.$rs_msg_list["msgBox_message"].'</p>
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-3">
                                        <p class="text_small txt-datetime">
                                        <i class="ditp-icon  icon-ico-ditp-11"></i> '.date("d/m/Y",strtotime($rs_msg_list["msgBox_datetime"])).'
                                        </p>
                                        <p class="text_small txt-datetime">
                                        <i class="ditp-icon  icon-ico-ditp-33"></i> '.date("H:i",strtotime($rs_msg_list["msgBox_datetime"])).'
                                        </p>
                                      </div>
                                      <div class="col-xs-12 col-sm-2 col-btn-file">
                                        <button type="button" class="btn btn-round btn-bg22 btn-edit-file" onclick="window.location.href=\'index.php?page=message_box_detail&msgId='.$rs_msg_list["msgBox_id"].'\'">
                                          <i class="my-icon icon-ico-ditp-22"></i>
                                        </button>
                                        <button type="button" class="btn btn-round btn-danger btn-del-file" onclick="remove_msg(\'msgId_'.$rs_msg_list["msgBox_id"].'\',\''.$rs_msg_list["msgBox_id"].'\');">
                                          <i class="my-icon icon-ico-ditp-28"></i>
                                        </button>
                                      </div>
                                    </li>
                                  </ul>';
      array_push($msg_arr,$msg_col_arr);
    }

    $data_array = array('total' => $count_msg,'rows' => $msg_arr);
    mysqli_close($this->dbConn);
    return json_encode($data_array);
  }

  //-- ฟังก์ชั่นดึงข้อมูลจาก Case Table --//
  public function get_msg_data($msgId){
    global $rs_msg;

    $rs_msg["msg"] = array();
    $sql_msg = "SELECT * ";
    $sql_msg .= "FROM `Message_Box` msg ";
    $sql_msg .= "LEFT JOIN `Case` c ON (msg.case_id=c.case_id) ";
    $sql_msg .= "WHERE msg.msgBox_status = '0' ";
    $sql_msg .= "AND msg.msgBox_id = '$msgId' ";
    $sql_msg .= "AND msg.msgBox_type = '1' ";
    $query = $this->dbConn->query($sql_msg);
    $rs_msg["msg"] = $query->fetch_assoc();
    if($rs_msg["msg"]["sender_type"]=="2"){

      $sql_sender_ref = "SELECT * ";
      $sql_sender_ref .= "FROM `Employee` ";
      $sql_sender_ref .= "WHERE emp_id = '".$rs_msg["msg"]["sender_id"]."' ";
      $query_sender = $this->dbConn->query($sql_sender_ref);
      $sender = $query_sender->fetch_assoc();
      if($sender["emp_img_path"]!=""){
        $rs_msg["msg"]["img_sender"] = "../".$sender["emp_img_path"];
      }else{
        $rs_msg["msg"]["img_sender"] = "";
      }
      $rs_msg["msg"]["msgBox_sender"] = $sender["emp_firstname"]." ".$sender["emp_lastname"];

    }else{


      $sql_sender_ref = "SELECT * ";
      $sql_sender_ref .= "FROM `Member` ";
      $sql_sender_ref .= "WHERE member_id = '".$rs_msg["msg"]["sender_id"]."' ";
      $query_sender = $this->dbConn->query($sql_sender_ref);
      $sender = $query_sender->fetch_assoc();
      if($sender["member_type"]==0){

        $rs_msg["msg"]["img_sender"] = "../data/img_member/".$sender["member_id"]."/".$sender["member_img"];
        $rs_msg["msg"]["msgBox_sender"] = $sender["member_fname"]." ".$sender["member_lname"];

      }else if($sender["member_type"]==1){

        $sql_sender_ref_comp = "SELECT * ";
        $sql_sender_ref_comp .= "FROM `Member_comp` ";
        $sql_sender_ref_comp .= "WHERE member_id = '".$sender["member_id"]."' ";
        $query_sender_comp = $this->dbConn->query($sql_sender_ref_comp);
        $sender_comp = $query_sender_comp->fetch_assoc();
        if($sender_comp["member_comp_img"]!=""){
          $rs_msg["msg"]["img_sender"] = "../data/img_membercom/".$sender_comp["member_id"]."/".$sender_comp["member_comp_img"];
        }else{
          $rs_msg["msg"]["img_sender"] = "";
        }
        $rs_msg["msg"]["msgBox_sender"] = $sender_comp["member_comp_name"];

      }

    }
    $rs_msg["msg_Attachfile"] = array();
    $sql_msg_file = "SELECT * ";
    $sql_msg_file .= "FROM `Message_Box_Attachfile` ";
    $sql_msg_file .= "WHERE msgBox_id = '$msgId' ";
    $sql_msg_file .= "AND msgBoxAttach_status = '0' ";
    $query_msg_file = $this->dbConn->query($sql_msg_file);
    while($rs_msg_file = $query_msg_file->fetch_assoc()){
      array_push($rs_msg["msg_Attachfile"],$rs_msg_file);
    }
    //-------------------------------------//

    $rs_msg["msg_reply"] = array();
    $sql_msg_ref = "SELECT * ";
    $sql_msg_ref .= "FROM `Message_Box` msg ";
    $sql_msg_ref .= "LEFT JOIN `Case` c ON (msg.case_id=c.case_id) ";
    $sql_msg_ref .= "WHERE msg.msgBox_status = '0' ";
    $sql_msg_ref .= "AND msg.msgBoxRef_id = '$msgId' ";
    $sql_msg_ref .= "AND msg.msgBox_type = '2' ";
    $query_ref = $this->dbConn->query($sql_msg_ref);
    while($rs_msg_ref = $query_ref->fetch_assoc()){

      if($rs_msg_ref["sender_type"]=="2"){
        $sql_sender_ref = "SELECT * ";
        $sql_sender_ref .= "FROM `Employee` ";
        $sql_sender_ref .= "WHERE emp_id = '".$rs_msg_ref["sender_id"]."' ";
        $query_sender = $this->dbConn->query($sql_sender_ref);
        $sender = $query_sender->fetch_assoc();
        if($sender["emp_img_path"]!=""){
          $rs_msg_ref["img_sender"] = "../".$sender["emp_img_path"];
        }else{
          $rs_msg_ref["img_sender"] = "";
        }
        $rs_msg_ref["msgBox_sender"] = $sender["emp_firstname"]." ".$sender["emp_lastname"];

      }else{

        $sql_sender_ref = "SELECT * ";
        $sql_sender_ref .= "FROM `Member` ";
        $sql_sender_ref .= "WHERE member_id = '".$rs_msg_ref["sender_id"]."' ";
        $query_sender = $this->dbConn->query($sql_sender_ref);
        $sender = $query_sender->fetch_assoc();
        if($sender["member_type"]==0){

          if($sender["member_img"]!=""){
            $rs_msg_ref["img_sender"] = "../data/img_member/".$sender["member_id"]."/".$sender["member_img"];
          }else{
            $rs_msg_ref["img_sender"] = "";
          }
          $rs_feild_msg["msgBox_sender"] = $sender["member_fname"]." ".$sender["member_lname"];

        }else if($sender["member_type"]==1){


          $sql_sender_ref_comp = "SELECT * ";
          $sql_sender_ref_comp .= "FROM `Member_comp` ";
          $sql_sender_ref_comp .= "WHERE member_id = '".$rs_msg_ref["sender_id"]."' ";
          $query_sender_comp = $this->dbConn->query($sql_sender_ref_comp);
          $sender_comp = $query_sender_comp->fetch_assoc();
          if($sender_comp["member_comp_img"]!=""){
            $rs_msg_ref["img_sender"] = "../data/img_membercom/".$sender_comp["member_comp_id"]."/".$sender_comp["member_comp_img"];
          }else{
            $rs_msg_ref["img_sender"] = "";
          }

          $rs_feild_msg["msgBox_sender"] = $sender_comp["member_comp_name"];

        }
        $rs_msg_ref["msgBox_sender"] = $rs_feild_msg["msgBox_sender"];
      }

      $rs_msg_ref["msg_Attachfile"] = array();
      $sql_msg_file = "SELECT * ";
      $sql_msg_file .= "FROM `Message_Box_Attachfile` ";
      $sql_msg_file .= "WHERE msgBox_id = '".$rs_msg_ref["msgBox_id"]."' ";
      $sql_msg_file .= "AND msgBoxAttach_status = '0' ";
      $query_msg_file = $this->dbConn->query($sql_msg_file);
      while($rs_msg_file = $query_msg_file->fetch_assoc()){
        array_push($rs_msg_ref["msg_Attachfile"],$rs_msg_file);
      }

      array_push($rs_msg["msg_reply"],$rs_msg_ref);

    }



    return $rs_msg;
  }

  public function getCaseList_msg(){

    /* mysqli_begin_transaction */
    $this->dbConn->begin_transaction();

    $case_arr = array();
    $sql_case = "SELECT *  ";
    $sql_case .= "FROM `Case` c ";
    $sql_case .= "RIGHT JOIN  `Case_Assign` c_as ON (c.case_id=c_as.case_id) ";
    $sql_case .= "WHERE c_as.emp_id = '$this->admin_id' ";
    $sql_case .= "GROUP BY c.case_id ";
    $sql_case .= "ORDER BY c.case_id DESC ";
    $query_case = $this->dbConn->query($sql_case);
    $option = "";
    while($rs_case_list = $query_case->fetch_assoc()){
      $option .= '<option value="'.$rs_case_list["case_id"].'">
                    Case ID '.sprintf("%05d",$rs_case_list["case_id"]).' - '.$rs_case_list["caseDtl_title"].'
                  </option>';
    }
    return $option;
  }

  public function create_msg($post,$file){

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

    if($_POST["msgBox_type"]==2){
  		$msgBoxRef_id = $post["msgBox_id"];
  	}else{
  		$msgBoxRef_id = "0";
  	}

    $case_id = $post["msg_to"];
    $sql_msg = "INSERT
                  INTO
                    `Message_Box`(
                      `msgBoxRef_id`,
                      `msgBox_type`,
                      `case_id`,
                      `sender_id`,
                      `sender_type`,
                      `msgBox_message`,
                      `msgBox_datetime`,
                      `msgBox_status`
                    )
                  VALUES(
                    '$msgBoxRef_id',
                    '".$post["msgBox_type"]."',
                    '$case_id',
                    '$this->admin_id',
                    '2',
                    '".$post["msg_message"]."',
                    NOW(),
                    0
                  )";
    $query_ins_msg = $this->dbConn->query($sql_msg);
    if(!$query_ins_msg){
      $status_response = "01";
      $status_response_text = "Error SQL!";
    }else{
      $last_msg_id = $this->dbConn->insert_id;
      $msgBoxRef_id = $last_msg_id;
      $caseLst_cls = new case_list();
      $caseLst_cls->case_id = $case_id;
      $case_ass = $caseLst_cls->get_case_assign_data();

      $rs_case_ref = $caseLst_cls->get_case_data();
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
                              '$msgBoxRef_id',
                              '".$rs_case_ref["case"]["case_createBy_id"]."',
                              '1',
                              NOW(),
                              0,
                              0
                            )";
        $qr_ins_msg_log = $this->dbConn->query($sql_ins_msg_log);
      }

      foreach($case_ass["case_assign"] as $case_assign){
        if($case_assign["emp_id"]!=$this->admin_id){
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
                                '$msgBoxRef_id',
                                '".$case_assign["emp_id"]."',
                                '2',
                                NOW(),
                                0,
                                0
                              )";
          $qr_ins_msg_log = $this->dbConn->query($sql_ins_msg_log);
        }
      }


      if($_POST["msgBox_type"]==2){
        $msgBox_id_return = $post["msgBox_id"];
      }else{
        $msgBox_id_return = $last_msg_id;
      }
      //-- บันทึกเอกสารประกอบการร้องเรียน --//
      $total_fileAttach = count($file['caseAttach_file']["name"]);
      if($total_fileAttach>0){

        $path_group = "msg_attach";

        $sql_del_msgAttach = "DELETE FROM `Message_Box_Attachfile` WHERE `msgBox_id`='$last_msg_id' ";
        $qr_del_msgAttach = $this->dbConn->query($sql_del_msgAttach);

        if($qr_del_msgAttach){

          $this->deleteDirectory("../data/$path_group/$last_msg_id");

          $removeIdx = explode(",",$post["removeFileAttachNewId"]);

          // Loop through each file
          for($i=0; $i<$total_fileAttach; $i++) {
            if(count($removeIdx)==1 || count($removeIdx)>1 && !in_array($i,$removeIdx)){

              if($file["caseAttach_file"]["name"][$i]!=""){
                if($post["caseAttach_file_name"][$i]!=""){
                    $ext = pathinfo($file["caseAttach_file"]["name"][$i], PATHINFO_EXTENSION);
                    $new_filename = "caseAttach_file_".$last_msg_id."_".time().$i.".".$ext;
                    $new_filepath = "data/$path_group/$last_msg_id/$new_filename";

                    if(!in_array($ext,$this->file_accept)){
                        $status_response = "02";
                        $status_response_text = "รูปแบบไฟล์แนบไม่ถูกต้อง !";
                    }else{


                     if(!is_dir("../data/$path_group")){
                       mkdir("../data/$path_group", 0775, true);
                     }
                     if(!is_dir("../data/$path_group/$last_msg_id")){
                       mkdir("../data/$path_group/$last_msg_id", 0775, true);
                     }

                     if(!(move_uploaded_file($file["caseAttach_file"]["tmp_name"][$i],"../".$new_filepath))){
                         $status_response = "02";
                         $status_response_text = "การอัพโหลดไฟล์แนบผิดพลาด";
                     }else{
                       $sql_ins_msgBoxAttach = "INSERT INTO `Message_Box_Attachfile`( `msgBox_id`, `msgBoxAttach_title`, `msgBoxAttach_file_path`, `msgBoxAttach_file_oldname`, `msgBoxAttach_file_name`, `msgBoxAttach_file_ext`, `msgBoxAttach_status`, `msgBoxAttach_create_datetime`, `msgBoxAttach_createBy_id`)
                       VALUE ('$last_msg_id','".$post["caseAttach_file_name"][$i]."','$new_filepath','".$file["caseAttach_file"]["name"][$i]."','$new_filename','$ext',0,NOW(),'".$this->admin_id."')";
                       $qr_ins_msgAttach = $this->dbConn->query($sql_ins_msgBoxAttach);


                       if(!$qr_ins_msgAttach){
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

    }
    if($status_response=="00"){
      /* commit insert */
      $this->dbConn->commit();

    }else{
      /* Rollback */
      $this->dbConn->rollback();
    }
    mysqli_close($this->dbConn);
    return array('status_response' => $status_response,'status_response_text' => $status_response_text,'last_msg_id'=>$msgBox_id_return);
  }


  public function update_open_noti(){
    
    $sql_noti = "UPDATE `Message_Noti_Employee` ";
    $sql_noti .= "SET msgNotiEmp_noti_status = '1' ";
    $sql_noti .= ", msgNotiEmp_noti_datetime = NOW() ";
    $sql_noti .= "WHERE emp_id = '$this->admin_id' ";
    $query_noti = $this->dbConn->query($sql_noti);
    if(!$query_noti){
      return "01";
    }else{
      return "00";
    }
  }

  public function update_read_noti($get){
    

    foreach($post as $key => $value) {
      if(is_array($value)){
        foreach($value as $key1 => $value1) {
          $post[$key][$key1] = $this->data_filter($value1);
        }
      }else{
        $post[$key] = $this->data_filter($value);
      }
    }
    $case_id = $get["caseId"];

    $sql_noti = "UPDATE `Message_Noti_Employee` ";
    $sql_noti .= "SET msgNotiEmp_read_status = '1' ";
    $sql_noti .= ", msgNotiEmp_read_datetime = NOW() ";
    $sql_noti .= "WHERE emp_id = '$this->admin_id' ";
    $sql_noti .= "AND case_id = '$case_id' ";
    $query_noti = $this->dbConn->query($sql_noti);
    if(!$query_noti){
      return "01";
    }else{
      return "00";
    }
  }

  public function update_open_msg(){
    $sql_msg_log = "UPDATE `Message_Box_Log` ";
    $sql_msg_log .= "SET msgBox_noti_status = '1' ";
    $sql_msg_log .= ", msgBox_noti_datetime = NOW() ";
    $sql_msg_log .= "WHERE recipient_type = 2 AND recipient_id='$this->admin_id' ";
    $query_msg_log = $this->dbConn->query($sql_msg_log);
    if(!$query_msg_log){
      return "01";
    }else{
      return "00";
    }
  }

  public function update_read_msg($msgId){

    $msg_id = $this->data_filter($msgId);

    $sql_msg_log = "UPDATE `Message_Box_Log` ";
    $sql_msg_log .= "SET msgBox_read_status = '1' ";
    $sql_msg_log .= ", msgBox_read_datetime = NOW() ";
    $sql_msg_log .= "WHERE recipient_type = 2 AND recipient_id='$this->admin_id' AND msgBox_id='$msg_id' ";
    $query_msg_log = $this->dbConn->query($sql_msg_log);
    if(!$query_msg_log){
      return "01";
    }else{
      return "00";
    }
  }

  public function remove_msg($msgId){

    $msg_id = $this->data_filter($msgId);

    $sql_msg = "UPDATE `Message_Box` ";
    $sql_msg .= "SET msgBox_status = '1' ";
    $sql_msg .= "WHERE msgBox_id='$msg_id' ";
    $query_msg = $this->dbConn->query($sql_msg);
    if(!$query_msg){
      return "01";
    }else{
      return "00";
    }
  }

  public function send_noti_app($msgNotiApp_id){
    include("class/send_noti_app.php");

    $sql="select member_id,case_id ,msgNotiApp_message, msgNotiApp_id from Message_Noti_App where msgNotiApp_id = '$msgNotiApp_id'  ";
    $exec=$this->dbConn->query($sql);
    if($exec->num_rows>0){
      $data=$exec->fetch_assoc();

      $sqlx="select device_uuid, member_id, device_platform from Device_regis where member_id = '$data[member_id]' ";
      $execx=$this->dbConn->query($sqlx);
      if($execx->num_rows>0){
        while ($datax=$execx->fetch_assoc()) {
          if($datax['device_platform'] == 2){
            $result = sendnoti($datax['device_uuid'],$data['case_id'],"DITP MSG",$data['msgNotiApp_message'],$datax['device_platform'],$data['msgNotiApp_id']);

            $ss = json_decode($result, true);
            // echo $ss[multicast_id];
            if($ss[success] == 1){
              $sended = "success";
              $status = 1;
            }else{
              $sended = "fail";
              $status = 2;
            }
            $sqll = "insert into ditp_apps_lognoti (case_id, multicast_id, log_status, log_txt, log_msg, log_date) values ('$case_id','$ss[multicast_id]','$status', '$sended', '', now()) ";
            $execll=$this->dbConn->query($sqll);
            // echo "1";
          }else{
            $result = sendnotiAndroid($datax['device_uuid'],$data['case_id'],"DITP MSG",$data['msgNotiApp_message'],$data['msgNotiApp_id']);
            $ss = json_decode($result, true);
            if($ss[success] == 1){
              $sended = "success";
              $status = 1;
            }else{
              $sended = "fail";
              $status = 2;
            }
            $sqll = "insert into ditp_apps_lognoti (case_id, multicast_id, log_status, log_txt, log_msg, log_date) values ('$case_id','$ss[multicast_id]','$status', '$sended', '', now()) ";
            $execll=$this->dbConn->query($sqll);
          }


        }
      }
    }
    return $result;
  }

  public function send_sms($case_id,$tel_number,$message){
    $headers = array(
      //'POST/HTTP/1.0'
      'Host:203.146.250.86'
      ,'User-Agent:CHMConnect'
      ,'Pragma:nocache'
      ,'Content-Type:application/x-www-form-urlencoded'
    );
    $datetime = date("Y-m-d H:i:s",strtotime('+1 minutes',time()));
    $ch = curl_init();
    $tel_number = str_replace("-","",$tel_number);
    $message_encode = iconv('UTF-8','TIS-620',$message);
    $url = 'http://smsapi.cheesemobile.com:4000/';
    $params = array('resultmode' => 'xml'
                    ,'passwd' => 'ditp59'
                    ,'username' => 'ditp'
                    ,'from' => 'DITP'
                    ,'to' => $tel_number
                    ,'text' => $message_encode
                    ,'datacoding' => 'U'
                    ,'datetime' => $datetime
                  );
    $params = http_build_query($params);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
    curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 0); //Timeout after 7 seconds
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //curl_setopt($ch, CURLOPT_HEADER, 0);

    $output = curl_exec($ch);

    $doc = new DOMDocument();
    $doc->loadXML($output);

    $response_status = $doc->getElementsByTagName('status')->item(0)->nodeValue;
    $response_detail = $doc->getElementsByTagName('detail')->item(0)->nodeValue;
    $response_tranid = $doc->getElementsByTagName('tranid')->item(0)->nodeValue;
    if($case_id!=""){
      $sql_msg = "INSERT
                  INTO
                    `Log_sms`(
                      `case_id`,
                      `mobile_number`,
                      `message`,
                      `response_status`,
                      `response_tranid`,
                      `response_detail`,
                      `send_datetime`
                    )
                  VALUES(
                    '$case_id'
                    ,'$tel_number'
                    ,'$message'
                    ,'$response_status'
                    ,'$response_tranid'
                    ,'$response_detail'
                    ,'$datetime'
                  )";
      $query_msg = $this->dbConn->query($sql_msg);
    }
    curl_close($ch);
    return "00";
  }

  public function send_sms_test($case_id,$tel_number,$message){
    $headers = array(
      //'POST/HTTP/1.0'
      'Host:203.146.250.86'
      ,'User-Agent:CHMConnect'
      ,'Pragma:nocache'
      ,'Content-Type:application/x-www-form-urlencoded'
    );
    $datetime = date("Y-m-d H:i:s",strtotime('+1 minutes',time()));
    $ch = curl_init();
    $tel_number = str_replace("-","",$tel_number);
    $message = iconv('UTF-8','TIS-620',$message);
    $url = 'http://smsapi.cheesemobile.com:4000/';
    $params = array('resultmode' => 'xml'
                    ,'passwd' => 'ditp59'
                    ,'username' => 'ditp'
                    ,'from' => 'DITP'
                    ,'to' => $tel_number
                    ,'text' => $message
                    ,'datacoding' => 'U'
                    ,'datetime' => $datetime
                  );
    $params = http_build_query($params);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
    curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 0); //Timeout after 7 seconds
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //curl_setopt($ch, CURLOPT_HEADER, 0);

    $output = curl_exec($ch);

    $doc = new DOMDocument();
    $doc->loadXML($output);

    $response_status = $doc->getElementsByTagName('status')->item(0)->nodeValue;
    $response_detail = $doc->getElementsByTagName('detail')->item(0)->nodeValue;
    $response_tranid = $doc->getElementsByTagName('tranid')->item(0)->nodeValue;

    if($case_id!=""){
      $sql_msg = "INSERT
                  INTO
                    `Log_sms`(
                      `case_id`,
                      `mobile_number`,
                      `message`,
                      `response_status`,
                      `response_tranid`,
                      `response_detail`,
                      `send_datetime`
                    )
                  VALUES(
                    '$case_id'
                    ,'$tel_number'
                    ,'$message'
                    ,'$response_status'
                    ,'$response_tranid'
                    ,'$response_detail'
                    ,'$datetime'
                  )";
      $query_msg = $this->dbConn->query($sql_msg);
    }
    curl_close($ch);
    return json_encode(array('URL'=>$url."?".join(",",$params),'response_status'=>$response_status,'response_detail'=>$response_detail,'response_tranid'=>$response_tranid));
  }
}


?>
