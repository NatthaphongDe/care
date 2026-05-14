<?php
// session_start();
include("../../../config/config.php");

$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];

if(isset($_GET["method"]) && $_GET["method"]=="get_knowledge"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = get_knowledge($post);
    echo $response;
exit();
}

function get_knowledge($post){
   include("../../../config/config.php");


   $id=$post->product;
   $arr_pt = array();
   $lv = 5;



     $sql_pt = " SELECT * FROM `Product_Type` WHERE prodType_status = 0 AND prodType_enable = 1 ";
     $sql_pt .= " AND prodType_level = '1' ";
     $sql_pt .= " AND prodType_id = '$id'  ";
     $query_pt  = $conn->query($sql_pt);
     if($query_pt->num_rows>0 ){
       while ($re  = $query_pt ->fetch_assoc()) {
         if (!in_array($re['prodType_id'], $arr_pt)) {
           array_push($arr_pt,$re['prodType_id']);
         }
       }
     }


     $sql_pt="";
     if(join(',',$arr_pt)==''){
       $arr_sql = "''";
     }else{
       $arr_sql = join(',',$arr_pt);
     }
     $sql_pt = " SELECT * FROM `Product_Type` WHERE prodType_status = 0 AND prodType_enable = 1 ";
     $sql_pt .= " AND prodType_level = '2' $AND ";
     if(count($arr_pt)!=''){
         $sql_pt .=" AND prodType_ref_id in (".$arr_sql.") " ;
     }else {
       $sql_pt .= " AND prodType_id = '$id' ";
     }
     $query_pt  = $conn->query($sql_pt);
     if($query_pt->num_rows>0 ){
       while ($re  = $query_pt ->fetch_assoc()) {
         if (!in_array($re['prodType_id'], $arr_pt)) {
           array_push($arr_pt,$re['prodType_id']);
         }
       }
     }


     $sql_pt="";
     if(join(',',$arr_pt)==''){
       $arr_sql_v3 = "''";
     }else{
       $arr_sql_v3 = join(',',$arr_pt);
     }
     $sql_pt = " SELECT * FROM `Product_Type` WHERE prodType_status = 0 AND prodType_enable = 1 ";
     $sql_pt .= " AND prodType_level = '3' ";
     if(count($arr_pt)!=''){
       $sql_pt .=" AND prodType_ref_id in (".$arr_sql_v3.") " ;
     }else {
       $sql_pt .= " AND prodType_id = '$id' ";
     }
     $query_pt  = $conn->query($sql_pt);
     if($query_pt->num_rows>0 ){
       while ($re  = $query_pt ->fetch_assoc()) {
         if (!in_array($re['prodType_id'], $arr_pt)) {
           array_push($arr_pt,$re['prodType_id']);
         }
       }
     }


     $sql_pt="";
     if(join(',',$arr_pt)==''){
       $arr_sql_v4 = "''";
     }else{
       $arr_sql_v4 = join(',',$arr_pt);
     }
     $sql_pt = " SELECT * FROM `Product_Type` WHERE prodType_status = 0 AND prodType_enable = 1 ";
     $sql_pt .= " AND prodType_level = '4' ";
     if(count($arr_pt)!=''){
       $sql_pt .=" AND prodType_ref_id in (".$arr_sql_v4.") " ;
     }else {
       $sql_pt .= " AND prodType_id = '$id' ";
     }
     $query_pt  = $conn->query($sql_pt);
     if($query_pt->num_rows>0 ){
       while ($re  = $query_pt ->fetch_assoc()) {
         if (!in_array($re['prodType_id'], $arr_pt)) {
           array_push($arr_pt,$re['prodType_id']);
         }
       }
     }


     $sql_pt="";
     if(join(',',$arr_pt)==''){
       $arr_sql_v5 = "''";
     }else{
       $arr_sql_v5 = join(',',$arr_pt);
     }
     $sql_pt = " SELECT * FROM `Product_Type` WHERE prodType_status = 0 AND prodType_enable = 1 ";
     $sql_pt .= " AND prodType_level = '5' ";
     if($arr_sql_v5!=''){
       $sql_pt .=" AND prodType_ref_id in (".$arr_sql_v5.") " ;
     }else {
       $sql_pt .= " AND prodType_id = '$id' ";
     }
     $query_pt  = $conn->query($sql_pt);
     if($query_pt->num_rows>0 ){
       while ($re  = $query_pt ->fetch_assoc()) {
         if (!in_array($re['prodType_id'], $arr_pt)) {
           array_push($arr_pt,$re['prodType_id']);
         }
       }
     }
     

   $caseCh_arr = array();
   $sql_caseCh =  " SELECT ck.caseKnlg_id,ck.case_id,ck.caseDtl_title,ck.caseKnlg_enable,ck.caseKnlg_status,ck.case_create_datetime,pt.prodType_level,ck.prodType_id";
   $sql_caseCh .= " FROM  Case_Knowledge as ck ";
   $sql_caseCh .= " LEFT JOIN `Case` AS ca on ca.case_id=ck.case_id ";
   $sql_caseCh .= " LEFT JOIN Complaint_Type as ct on  ct.compType_id = ca.compType_id ";
   $sql_caseCh .= " LEFT JOIN Product_Type as pt on  ck.prodType_id = pt.prodType_id ";
   $sql_caseCh .= " WHERE ck.caseKnlg_status != 3  ";
   $sql_caseCh .= " AND  ct.compType_section = '".$_SESSION["admin"]["empSection"]."' ";

// echo $sql_caseCh;

   if($post->text != ""){
     $sql_caseCh .= " AND (ck.caseDtl_title LIKE '%".$post->text."%' OR ck.case_id LIKE '%".$post->text."%')  ";
   }
   if($post->sort=="case_id"){
     $sort_col = "ck.caseKnlg_id";
   }
  if($post->sort=="title"){
    $sort_col = "ck.caseDtl_title";
  }
  if($post->sort=="ststus"){
    $sort_col = "ck.caseKnlg_status";
  }
  if($post->sort=="id" || $post->sort=="date"){
    $sort_col = "ck.case_create_datetime";
  }

  if($post->status_m != ""){
   $sql_caseCh .= "AND ck.caseKnlg_status = '$post->status_m' ";
  }
  if($_SESSION["admin"]["empSection"]==1){
    if($post->product != ""){
      $arr_sql = join(',',$arr_pt);
     $sql_caseCh .= " AND ck.prodType_id in (".$arr_sql.") ";
    }
  }else if($_SESSION["admin"]["empSection"]==2) {
    if($post->mistake != ""){
      $sql_caseCh .= " AND ck.incType_id = '$post->mistake' ";
    }
  }


  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";

// echo $sql_caseCh;


  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
        $case = sprintf("%05s",$re['case_id']);
       $caseCh_col_arr["case_id"] = '<span class="txt_nol">'.$case.'</span>';
       $caseCh_col_arr["title"] = '<span class="txt_nol cursor" onclick="edit_knowledge('.$re['caseKnlg_id'].',0);">'.$re['caseDtl_title'].'</span>';
       if($re['member_facebook_type'] == '0'){
         $type='<span class="lbl_manal">Manual Login</span>';
       }else{
         $type ='<span class="lbl_face">Facebook Login</span>';
       }
       $caseCh_col_arr["member"] = $member;

       $date_start  = date("d/m/Y" , strtotime($re['case_create_datetime']));

       $caseCh_col_arr["date"] = '<span class="txt_nol">'.$date_start.'</span>';

      $caseCh_col_arr["type"] = $type;
      $caseCh_col_arr["view"] = '<span class="lbl_view cursor"  data-toggle="modal" onclick="view_applactions('.$re['member_id'].',1);">View</span>';

      if($re['caseKnlg_status'] == '0'){
        $st = '<span class="txt_wai">Waiting</span>';
      }else if($re['caseKnlg_status'] == '1'){
        $st = '<span class="txt_pub">Published</span>';
      }else if($re['caseKnlg_status'] == '2'){
        $st = '<span class="txt_hid">Hide</span>';
      }else if($re['caseKnlg_status'] == '3'){
        $st = '<span class="txt_pub">Published</span>';
      }
      $caseCh_col_arr["ststus"] = $st;
      $del = '<div class="th_user_edit_2"><span class="fa fa-files-o cursor txt_no_edit_non"  data-toggle="modal" onclick="Confirm_duplicate() && copy_knowledge('.$re['caseKnlg_id'].');"></span>
              <span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_knowledge('.$re['caseKnlg_id'].');"></span>
             <span class="icon-ico-ditp-28 cursor txt_no_del_kl"  onclick="ConfirmDelete() && del_knowledge('.$re['caseKnlg_id'].');"></span></div>';

      $caseCh_col_arr["del"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}


if ($_POST['method']=="edit_knowledge"){
  include("../config/config.php");
     $sql_select = " SELECT  *  FROM Case_Knowledge
                    left join  Complaint_Type on Case_Knowledge.compType_id  = Complaint_Type.compType_id
                    left join  Case_Close on Case_Close.caseClose_id  = Case_Knowledge.compType_id
                    where Case_Knowledge.caseKnlg_id = '".$_POST['id']."'  ";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['caseKnlg_enable']=$result_select['caseKnlg_enable'];
          $array_row['compType_name']=$result_select['compType_name'];
          $array_row['applnt_name']=$result_select['applnt_name'];
          $array_row['complnt_name']=$result_select['complnt_name'];
          $array_row['caseDtl_title']=$result_select['caseDtl_title'];
          $array_row['prodType_id']=$result_select['prodType_id'];
          $array_row['caseDtl_derivation']=$result_select['caseDtl_derivation'];
          $array_row['caseDtl_damage_val']=$result_select['caseDtl_damage_val'];
          $array_row['caseDtl_complnt_need']=$result_select['caseDtl_complnt_need'];
          $array_row['case_close_resultProcess']=$result_select['case_close_resultProcess'];
          $array_row['caseClose_title']=$result_select['caseClose_title'];
          $array_row['caseKnlg_status']=$result_select['caseKnlg_status'];
          $array_row['incType_id']=$result_select['incType_id'];


        }
      }
      echo json_encode($array_row);
      exit();
 }




  if(isset($_GET["method"]) && $_GET["method"]=="save_knowledge"){

    $radio_status = data_filter(trim($_POST['radio_status']));
    $applnt_name = data_filter(trim($_POST['applnt_name']));
    $complnt_name = data_filter(trim($_POST['complnt_name']));
    $caseDtl_title = data_filter(trim($_POST['caseDtl_title']));
    $prodType_id = data_filter(trim($_POST['prodType_id']));
    $caseDtl_derivation = $_POST['caseDtl_derivation'];
    $caseDtl_damage_val = data_filter(trim($_POST['caseDtl_damage_val']));
    $caseDtl_complnt_need = $_POST['caseDtl_complnt_need'];
    $case_close_resultProcess = data_filter(trim($_POST['case_close_resultProcess']));
    $mistake = data_filter(trim($_POST['mistake_up']));
    $id = data_filter(trim($_POST['id']));


            if ($caseDtl_title == '' ){
              ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูลหัวข้อเรื่อง');</script><?php
              exit();
            }
            if($_SESSION["admin"]["empSection"]==1){
              if ($prodType_id == '' ){
                ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเภทสินค้า');</script><?php
                exit();
              }
              $up_ka = " ,prodType_id = '$prodType_id' ";
            }else{
              if ($mistake == '' ){
                ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเภทความผิด');</script><?php
                exit();
              }
                $up_ka = " ,incType_id = '$mistake' ";
            }

            if ($caseDtl_derivation == '' ){
              ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูลความเป็นมาของประเด็นเรื่องร้องเรียน');</script><?php
              exit();
            }
            if ($case_close_resultProcess == '' ){
              ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูลผลการดำเนินงาน');</script><?php
              exit();
            }



              $sql_edit = "UPDATE  Case_Knowledge SET
                            caseKnlg_status = '$radio_status'
                            ,applnt_name   = '$applnt_name'
                            ,complnt_name = '$complnt_name'
                            ,caseDtl_title = '$caseDtl_title'
                            ,caseDtl_derivation = '$caseDtl_derivation'
                            ,caseDtl_damage_val = '$caseDtl_damage_val'
                            ,caseDtl_complnt_need = '$caseDtl_complnt_need'
                            ,case_close_resultProcess = '$case_close_resultProcess'
                            ,case_update_datetime = '$date_setting'
                            ,case_updateBy_id = '$emp_id'
                            $up_ka
                            where  caseKnlg_id = '$id'";
     $query_edit = $conn->query($sql_edit);

        if( $query_edit){     //  setting/Individual/contact_thai.php
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        }else {
          ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
        }
        exit();
  }

function data_filter($value) {
    global $conn;
    $newVal = trim($value);
    $newVal = htmlspecialchars($newVal);
    $newVal = mysqli_real_escape_string($conn,$newVal);
    return $newVal;
}


if ($_POST['method']=="del_knowledge"){
   $id = data_filter(trim($_POST['id']));
   $sql_del = "UPDATE   Case_Knowledge SET caseKnlg_status = '3' WHERE  caseKnlg_id =  '$id' ";
    $query_del = $conn->query($sql_del);
    if ($query_del){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}

  if ($_POST['method']=="copy_knowledge"){
     $id = data_filter(trim($_POST['id']));
    $sql_insert =" INSERT INTO `Case_Knowledge`(  `case_id`, `compType_id`, `caseKnlg_status`, `caseKnlg_enable`, `caseDtl_title`,
                                `prodType_id`, `caseDtl_derivation`,`caseDtl_damage_val`, `curren_id`, `caseDtl_complnt_need`,
                                `applnt_name`, `complnt_name`,`case_close_resultProcess`, `case_create_datetime`, `case_createBy_id` )
                         SELECT `case_id`, `compType_id`, `caseKnlg_status`, `caseKnlg_enable`, `caseDtl_title`, `prodType_id`, `caseDtl_derivation`,
                                `caseDtl_damage_val`, `curren_id`, `caseDtl_complnt_need`,`applnt_name`, `complnt_name`, `case_close_resultProcess`, now(),
                                `case_createBy_id` FROM `Case_Knowledge` WHERE `caseKnlg_id` =  '$id' ";
    $query = $conn->query($sql_insert);
    $last_id_priority = $conn->insert_id;
    $sql_up = "UPDATE `Case_Knowledge` SET `caseKnlg_status` = 0 WHERE `caseKnlg_id` =  '$last_id_priority' ";
    $query_up = $conn->query($sql_up);


      if ($query){
          echo '1';
      }else {
          echo "0";
      }
      exit();
  }



?>
