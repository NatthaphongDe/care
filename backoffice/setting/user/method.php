<?php
include("../../../config/config.php");
require_once "../../class/PHPMailer-5.2.5/class.phpmailer.php";

include("../../../config/config.php");
include("../../../api/ditp_extapi.php");
include("../../class/main.class.php");
include("../../class/employee.class_ldap.php");

$member_idap = new member_base();

$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];

if(isset($_GET["method"]) && $_GET["method"]=="getform_admin"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getform_admin($post);
    echo $response;
exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="login_as"){
  $emp_id = $_POST['emp_id'];
  
  $sql = "SELECT *, emp.office_id AS office_id_1
  FROM Employee emp
  INNER JOIN Employee_Group empGp ON (emp.empGroup_id=empGp.empGroup_id)
  LEFT JOIN Department AS Dep ON ( emp.dept_id = Dep.dept_id )
  WHERE emp.emp_id='$emp_id'
  AND emp.emp_status='0'
  AND empGp.empGroup_status='0'
  AND empGp.empGroup_enable='1'";

  $query = $conn->query($sql);
  $rows_mem = $query->num_rows;
  if($rows_mem>0){
    unset($_SESSION["admin"]);
    $_SESSION["admin"]["login_as"] = 1;

    

    $rs_mem = $query->fetch_assoc();
    // echo $rs_mem["office_id_1"];
    // exit();
    if($rs_mem['empGroup_id']==6 && $rs_mem['login_ldap']==0 ){
      // $this->saveLogLogin(1,$username,$password);
      $_SESSION["admin"]["empId"]         = $rs_mem["emp_id"];
      $_SESSION["admin"]["empFirstname"]  = $rs_mem["emp_firstname"];
      $_SESSION["admin"]["empLastname"]   = $rs_mem["emp_lastname"];
      $_SESSION["admin"]["empPosition"]   = $rs_mem["empGroup_id"];
      $_SESSION["admin"]["empSection"]    = $rs_mem["empGroup_section"];
      $_SESSION["admin"]["empLv"]         = $rs_mem["empGroup_level"];
      $_SESSION["admin"]["office"]        = $rs_mem["office_id_1"];
      $_SESSION["admin"]["dept"]          = $rs_mem["dept_id"];
      $_SESSION["admin"]["country"]    = $rs_mem["country_id"];

      // return true;
    }else if($rs_mem["emp_enable_sys_login"]==0){
      $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
      $_SESSION["admin"]["empFirstname"] = $rs_mem["emp_firstname"];
      $_SESSION["admin"]["empLastname"] = $rs_mem["emp_lastname"];
      $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
      $_SESSION["admin"]["empSection"] = $rs_mem["empGroup_section"];
      $_SESSION["admin"]["empLv"] = $rs_mem["empGroup_level"];
      $_SESSION["admin"]["office"] = $rs_mem["office_id_1"];

    }else{
      $_SESSION["admin"]["empId"] = $rs_mem["emp_id"];
      $_SESSION["admin"]["empFirstname"] = $rs_mem["emp_firstname"];
      $_SESSION["admin"]["empLastname"] = $rs_mem["emp_lastname"];
      $_SESSION["admin"]["empPosition"] = $rs_mem["empGroup_id"];
      $_SESSION["admin"]["empSection"] = $rs_mem["empGroup_section"];
      $_SESSION["admin"]["empLv"] = $rs_mem["empGroup_level"];
      $_SESSION["admin"]["office"] = $rs_mem["office_id_1"];
    }
  }
  //echo "<meta http-equiv='refresh' content='0; url=../index.php?page=user/application'>"; 
  echo "<meta http-equiv='refresh' content='0; url=http://care.ditp.go.th/backoffice/index.php'>";
  exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="confirmMember"){
  $mem_id = mysqli_real_escape_string($conn,$_POST["mem_id"]);
  $sql_update = "UPDATE `Member` SET
                 member_status_confirm = '1',
                 member_date_confirm = NOW()
                 WHERE `member_id` = '$mem_id' ";
  $query_update_udp = $conn->query($sql_update);
  if($query_update_udp){
    echo "00";
  }else{
    echo "01";
  }
  exit();
}

function getform_admin($post){
   include("../../../config/config.php");
   $arr_ofic = array();
   $sql_office .= " SELECT * FROM `office_type` ";
   $qr_office = $conn->query($sql_office);
   while ($rs_ofic = $qr_office->fetch_assoc()) {
     $arr_ofic[$rs_ofic[office_id]] = $rs_ofic[office_name_short];
   }

   $caseCh_arr = array();
   $sql_caseCh = "SELECT emp_id,emp_real_id,emp_firstname,emp_lastname,emp_status,emp_email,emp_tel,empGroup_name,empGroup_section,emp_img_path_s,office_id  ";
   $sql_caseCh .= "FROM  Employee left join Employee_Group on Employee_Group.empGroup_id = Employee.empGroup_id
                  WHERE emp_status = '0' AND Employee_Group.empGroup_id !='1' ";

   if($post->text != ""){
     $sql_caseCh .= "  AND (   Employee.emp_real_id LIKE '%".$post->text."%'
                             or  Employee.emp_firstname LIKE '%".$post->text."%'
                             or Employee.emp_lastname LIKE '%".$post->text."%'
                             or Employee.emp_email LIKE '%".$post->text."%'
                           )";
                         }
   if($post->sort=="id"){
     $sort_col = "Employee.emp_id";
   }
  if($post->sort=="name"){
    $sort_col = "Employee.emp_firstname";
  }
  if($post->sort=="emp_real_id"){
    $sort_col = "Employee.emp_real_id";
  }
  if($post->sort=="empGroup"){
    $sort_col = "Employee_Group.empGroup_name";
  }
  if($post->sort=="type"){
    $sort_col = "Employee.office_id";
  }
  if($post->sort=="tel"){
    $sort_col = "Employee.emp_tel";
  }

  if( $post->group_id != ""){
     $sql_caseCh .= "AND Employee_Group.empGroup_id = '$post->group_id' ";
  }
  if( $post->type_section != ""){
     $sql_caseCh .= "AND Employee_Group.empGroup_section = '$post->type_section' ";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0;
    //  echo $sql_caseCh;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;

       if(!file_exists('../../../'.$re['emp_img_path_s']) || $re['emp_img_path_s'] == '') {

         $pic = '<div class="user_image_admin"><img src="img/user.png" style=" '.getPositionImage("img/user.png",40).'"></div>
                <span class="txt_nol">'.$re['emp_real_id'].'</span>';
       }else{
         $pic = '<div class="user_image_admin"><img src="../../../'.$re['emp_img_path_s'].'" style=" '.getPositionImage("../../../".$re['emp_img_path_s'],40).'"></div>
                  <span class="txt_nol">'.$re['emp_real_id'].'</span>';
       }
       $caseCh_col_arr["emp_real_id"] = $pic;
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_emp('.$re['emp_id'].',0);">'.$re['emp_firstname'].'  '.$re['emp_lastname'].'</span>';
         if($re['empGroup_section'] == '1'){
           //$type='<span class="type_general">สสบ.</span>';
           $type='<span class="type_general">'.$arr_ofic[$re[office_id]].'</span>';
         }else{
           $type ='<span class="type_law">นิติการ</span>';
         }
      $caseCh_col_arr["type"] = $type;
      $caseCh_col_arr["empGroup"] = '<span class="txt_nol">'.$re['empGroup_name'].'</span>';

      if($re['emp_tel']!=''){
         $emp_tel  = '<span class="txt_nol">Tel: '.$re['emp_tel'].'</span><br />';
      }
      if($re['emp_email']!=''){
        $emp_email = '<span class="txt_address">Email: '.$re['emp_email'].'</span>';
      }
      $caseCh_col_arr["tel"] = $emp_tel.$emp_email;

      $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_emp('.$re['emp_id'].',1);"></span>
              <span class="icon-ico-ditp-28 cursor txt_no_del" onclick="ConfirmDelete() && del_emp('.$re['emp_id'].');"></span></div>';
      $caseCh_col_arr["del"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}

if(isset($_GET["method"]) && $_GET["method"]=="getform_application"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getform_application($post);
    echo $response;
exit();
}

function getform_application($post){
   include("../../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT Member.member_id,member_fname,member_lname,member_email,member_facebook_type,member_status,member_comp_name,member_comp_type,member_type,Member.member_status_confirm as comf";
   $sql_caseCh .= " FROM  Member left join Member_comp on  Member.member_id = Member_comp.member_id WHERE 1 ";

   if($post->text != ""){
     $sql_caseCh .= "  AND (   member_fname LIKE '%".$post->text."%'
                             or  member_lname LIKE '%".$post->text."%'
                             or member_email LIKE '%".$post->text."%'
                           )";
                         }
   if($post->sort=="id"){
     $sort_col = "member_id";
   }
  if($post->sort=="name"){
    $sort_col = "member_fname";
  }
  if($post->sort=="email"){
    $sort_col = "member_email";
  }
  if($post->sort=="type"){
    $sort_col = "member_facebook_type";
  }
  if($post->sort=="member"){
    $sort_col = "member_comp_type";
  }
  if($post->status_m != ""){
   $sql_caseCh .= "AND member_status = '$post->status_m' ";
 }
  if($post->status_t != ""){
   $sql_caseCh .= "AND member_type = '$post->status_t' ";
  }
  if($post->fonfrim != ""){
      if($post->fonfrim == "0"){
        $sql_caseCh .= " AND member_status_confirm = '$post->fonfrim' AND member_facebook_type = '0'";
      }else{
        $sql_caseCh .= " AND (member_status_confirm = '$post->fonfrim' or   member_facebook_type = '1') ";
      }
  }


  if($post->Department_members != ""){
    if($post->Department_members==0){
      $sql_caseCh .= "AND member_type = '0' ";
    }else{
      $sql_caseCh .= "AND member_comp_type = '$post->Department_members' ";
    }
  }
  if($post->login_f_m != ""){
   $sql_caseCh .= "AND member_facebook_type = '$post->login_f_m' ";
  }

  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  // echo $sql_caseCh;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="view_applactions('.$re['member_id'].',0);">'.$re['member_fname'].'  '.$re['member_lname'].'</span>';
       $caseCh_col_arr["email"] = '<span class="txt_nol">'.$re['member_email'].'</span>';
       if($re['member_facebook_type'] == '0'){
         $type='<div class="lbl_manal">Manual Login</div>';
       }else{
         $type ='<div class="lbl_face">Facebook Login</div>';
       }
       if($re['member_comp_type'] == '1'){
         $member='<span class="type_member">เป็นสมาชิกกรม</span>';
       }else if($re['member_comp_type'] == '2'){
         $member ='<span class="type_member_1">ไม่เป็นสมาชิกกรม</span>';
       }else{
          $member ='<span class="txt_nol">ไม่ระบุ</span>';
       }

      if($re['member_type'] == '0'){
        $member_t='<span class="type_general">บุคคลธรรดา</span>';
      }else{
           $member_t ='<span class="type_law">นิติบุคคล</span>';
      }
      if($re['comf'] == '1' || $re['member_facebook_type'] != '0'){
        $confirm = '<span class="type_green">ยืนยัน</span>';
      }
      else{
        $confirm = '<div class="comfirm-member-'.$re['member_id'].'" style="text-align:center;">
                      <a href="javascript:;" onclick="if(confirm(\'ท่านต้องยืนยันการเป็นสมาชิกของสมาชิกท่านนี้ใช่หรือไม่?\')){confirmMember(\''.$re['member_id'].'\');}" data-toggle="tooltip" data-placement="bottom" data-html="true" data-original-title="กรุณากดที่นี้หากต้องการยืนยันให้สมาชิก">
                        <span class="type_general">ไม่ยืนยัน</span>
                      </a>
                    </div>';
      }

      $caseCh_col_arr["confirm"] = $confirm;
      $caseCh_col_arr["type_mem"] = $member_t;
      $caseCh_col_arr["member"] = $member;


      $caseCh_col_arr["type"] = $type;
      $caseCh_col_arr["view"] = '<span class="lbl_view cursor"  data-toggle="modal" onclick="view_applactions('.$re['member_id'].',1);">View</span>';
      if($re['member_status'] == '1'){
        $view ='<span class=" dis_true icon-ico-ditp-12 view_1 cursor" onclick="Confirmststus(function(){dis_member(0,'.$re['member_id'].')})">';
      }else{
        $view ='<span class=" dis_false icon-ico-ditp-13  view_2 cursor" onclick="Confirmststus(function(){dis_member(1,'.$re['member_id'].')})">';
      }
      $caseCh_col_arr["ststus"] = $view;
      $caseCh_col_arr["del"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}

function data_filter($value) {
    global $conn;
    $newVal = trim($value);
    $newVal = htmlspecialchars($newVal);
    $newVal = mysqli_real_escape_string($conn,$newVal);
    return $newVal;
}

if($_POST['method']=='user_section'){
  include("../../../config/config.php");
	?>
  <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id_emp"  id="group_id_emp" data-width="100%">
    <option value="">--- เลือกตำแหน่ง ---</option>
    <?php
    $sql_select = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_section = '".$_POST['id']."' ";
    $query_select = $conn->query($sql_select);
      while ( $re =   $query_select->fetch_assoc()) {
          ?><option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option><?php
      }
    ?>
  </select>
	<?php
	exit();
}


if($_POST['method']=='user_section_edit'){
  include("../../../config/config.php");
	?>
  <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id_emp_edit"  id="group_id_emp_edit" data-width="100%">
    <option value="">--- เลือกตำแหน่ง ---</option>
    <?php
    $sql_select = "SELECT empGroup_name,empGroup_id  FROM Employee_Group where empGroup_status = 0 AND empGroup_section = '".$_POST['id']."' ";
    $query_select = $conn->query($sql_select);
      while ( $re =   $query_select->fetch_assoc()) {
          ?><option value="<?=$re['empGroup_id']?>"><?=$re['empGroup_name']?></option><?php
      }
    ?>
  </select>
	<?php
	exit();
}




if(isset($_GET["method"]) && $_GET["method"]=="add_user"){

         // chech_edit

         if (trim($_POST['office_name']) == ''){
           ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเภท');</script><?php
           exit();
         }

         if (trim($_POST['id_edit']) != '' ){
           if (trim($_POST['radio1']) == '1' ){
             if (trim($_POST['group_id_emp_edit']) == ''){
               ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกตำแหน่ง');</script><?php
               exit();
             }else{
             $group_id_emp_edit =  trim($_POST['group_id_emp_edit']);
             }
           }else{
             if($_POST['office_name']==''){
               if (trim($_POST['group_id_emp_edit_1']) == '' ){
                 ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกตำแหน่ง');</script><?php
                 exit();
               }else{
                 $group_id_emp_edit =  trim($_POST['group_id_emp_edit_1']);
               }
             }else{
                 if (trim($_POST['group_id_emp_edit']) == '' ){
                   ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกตำแหน่ง');</script><?php
                   exit();
               }else{
                 $group_id_emp_edit =  trim($_POST['group_id_emp_edit']);

               }
             }
           }
         }else {
           // echo "9999";
           // echo $_POST['group_id_emp'];
           if (trim($_POST['group_id_emp']) == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกตำแหน่ง');</script><?php
             exit();
           }
         }
         $group_id = '';
         if (trim($_POST['group_id_emp']) == '6'  && trim($_POST['dept_id']) == ''){
           $group_id =1;
         }

         if (trim($_POST['group_id_emp_edit']) == '6'  && trim($_POST['dept_id']) == ''){
           $group_id =1;
         }

         if($group_id == 1){
           ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกสำนักงานส่งเสริมการค้าในต่างประเทศ (สคต.)');</script><?php
           exit();
         }
         if($_POST['group_id_emp']==6 || $_POST['group_id_emp_edit']==6){
           if($_POST['dept_id']==''){
             $dept_id = 0;
           }else{
             $dept_id = $_POST['dept_id'];
           }
           if($_POST['Ldap']==''){
             $login_ldap = 0;
           }else{
             $login_ldap = 1;
           }
         }else{
           $dept_id = 0;
           $login_ldap = 0;
         }





             if (trim($_POST['id_edit']) != '' ){
               $where_edit = " and emp_id != '".$_POST['id_edit']."' ";
             }
             if (trim($_POST['name']) == '' ){
               ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อ');</script><?php
               exit();
             }
             if (trim($_POST['lastname']) == '' ){
               ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกนามสกุล');</script><?php
               exit();
             }

             if (trim($_POST['email']) == '' ){
               ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกอีเมล');</script><?php
               exit();
             }
             $sql_select = "SELECT emp_email  FROM Employee where emp_email = '".trim($_POST['email'])."' AND emp_status = '0' $where_edit ";
             $query_select = $conn->query($sql_select);
             $array_row = array();
             if ($query_select->num_rows >0){
               ?><script type="text/javascript">parent.iziToast_func.alert('Email มีอยู่ในระบบแล้ว กรุณากรอก Email ใหม่');</script><?php
               exit();
             }
             if (trim($_POST['view_dashboard']) == '' ){
               ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกการแสดงผล Dashboard');</script><?php
               exit();
             }


              $group_id_emp = data_filter(trim($_POST['group_id_emp']));
              $name = data_filter(trim($_POST['name']));
              $lastname = data_filter(trim($_POST['lastname']));
              $tel = data_filter(trim($_POST['tel']));
              $email = data_filter(trim($_POST['email']));
              $user = data_filter(trim($_POST['user']));
              $view_dashboard = data_filter(trim($_POST['view_dashboard']));
              if($_POST['office_name']=='s1' || $_POST['office_name']=='s2'){
               $office = 0;
              }else {
               $office = $_POST['office_name'];
              }


           if (trim($_POST['id_edit']) == '' ){
               // if($_POST['group_id_emp']==6){
                 $newpassword = random_password();
               // }else{
                 // $newpassword = '1234';
               // }
                $password_hash = hash('sha256', $newpassword);

              $sql = " INSERT INTO  Employee  (empGroup_id,emp_firstname,emp_lastname,emp_tel,emp_email,emp_create_datetime,emp_status,password,emp_available_dashboard,office_id,dept_id,login_ldap)
                        VALUES ('$group_id_emp','$name','$lastname','$tel','$email','$date_setting','0','$password_hash','$view_dashboard','$office','$dept_id','$login_ldap') ";
              $query = $conn->query($sql);
              $last_id = $conn->insert_id;

              $sql_update_id = "UPDATE `Employee` SET emp_real_id = '$last_id' WHERE `emp_id` = '$last_id'";
              $query_update_ins = $conn->query($sql_update_id);
              if($query_update_ins){
                $url = $_SERVER['HTTP_HOST']."/backoffice";
                $namesent = $name.' '.$lastname;
                $title_name = "เรียน คุณ ".$namesent;
                if($_POST['group_id_emp']==6){
                  if($_POST['Ldap']==1){
                    $text = 'เราได้รับคำขอจากคุณให้สร้างชื่อผู้ใช้งานบนระบบ '.$_SERVER["HTTP_HOST"]." โดยใช้ E-Mail ของกรม (xxx@ditp.go.th) และ Password ของท่าน เพื่อเข้าระบบ";
                  }else{
                    $text = 'เราได้รับคำขอจากคุณให้สร้างชื่อผู้ใช้งานบนระบบ '.$_SERVER["HTTP_HOST"]." โดยใช้ <br> Username : ".$email." <br> Password : ".$newpassword."<br>เพื่อเข้าสูระบบ";
                  }
                }else{
                  $text = 'เราได้รับคำขอจากคุณให้สร้างชื่อผู้ใช้งานบนระบบ '.$_SERVER["HTTP_HOST"]." โดยใช้ E-Mail ของกรม (xxx@ditp.go.th) และ Password ของท่าน เพื่อเข้าระบบ";
                }

                $message ="
                              <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                                <div class=\"header\" style=\"width:auto\">
                                  <img src=\"https://".$_SERVER["HTTP_HOST"]."/img/header_email_2.png\" style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                                  <div>
                                  <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                    <div style=\"padding: 20px;color:#000;\">
                                    ".$title_name."
                                    <br>
                                    <br>
                                    ".$text."
                                    <br>
                                    โดยสามารถคลิ๊กที่ ลิงค์ด้านล่างนี้ เพื่อเข้าสู่ระบบ :
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div style=\"text-align:center;color:#000;\">
                                    <a href=\"https://".$url."\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >เข้าสู่ระบบ</a>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    </div>
                                  <hr style=\"border-color:#fefefe; margin:0px;\" />
                                     <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                       ขอบคุณ.<br />
                                       ทีมงาน <a href=\"https://".$_SERVER["HTTP_HOST"]."\" target=\"blank\">".$_SERVER["HTTP_HOST"]."</a>
                                     </div>
                                 </div>

                          ";
                          $form_emil = "ditpcare@ditp.go.th";

                          $send_email_fnc = sendEmail($form_emil,"DITP Care",$email,$namesent,"แจ้ง Username และ Password สำหรับเข้าใช้งานระบบ DITP Care",$message);
                          /* if($send_email_fnc){
                            echo "1";
                        
                          }else{
                            echo '0';
                          }
                          exit(); */

              }

           }else{

              $sql_update = "UPDATE `Employee` SET
                             empGroup_id = '$group_id_emp_edit',
                             emp_firstname = '$name' ,
                             emp_lastname = '$lastname',
                             emp_tel = '$tel',
                             emp_email = '$email',
                             username = '$user',
                             emp_update_datetime = '$date_setting',
                             emp_available_dashboard = '$view_dashboard',
                             office_id = '$office',
                             dept_id = '$dept_id',
                             login_ldap = '$login_ldap'
                           WHERE `emp_id` = '".$_POST['id_edit']."'";
              $query_update_udp = $conn->query($sql_update);
              $last_id = $_POST['id_edit'];
            }


        if ($_FILES['img_user']['name']){
          $images = $_FILES["img_user"]["tmp_name"];
          $image_type = $_FILES['img_user']['type'];
          if ($image_type=="image/jpeg"){
               $image_set_type = "jpeg";
          }
          if ($image_type=="image/png"){
            $image_set_type = "png";

          }
          if ($image_type=="image/jpg"){
            $image_set_type = "jpg";

          }
          $size=getimagesize($images);

         if ($size[0]<800 && $size[1]<800)
          {
            ?><script type="text/javascript">parent.iziToast_func.alert("ขนาดรูปภาพ ความสูงและความกว้าง 800 Pixels ขึ้นไปเท่านั้น");</script><?php
            exit();
          }
        }


     if($_FILES['img_user']['name'] != ''){
       if($image_set_type != ''){
         $folder = 'emp';
         create_case_direatory($folder,$last_id);
         $new_images =  uniqid().'.'.$image_set_type;
         $file_size_s = "../../../data/emp_images/".$last_id."/s/";
         $file_size_l = "../../../data/emp_images/".$last_id."/l/";
         copy($_FILES["img_user"]["tmp_name"],"../../../data/emp_images/".$last_id."/".$new_images);
         $images = "../../../data/emp_images/".$last_id."/".$new_images;
         $images_l = "data/emp_images/".$last_id."/l/".$new_images;
         $images_s = "data/emp_images/".$last_id."/s/".$new_images;

         $sql_update = "UPDATE `Employee` SET `emp_img_name` = '".$new_images."', emp_img_path = '$images_l' , emp_img_path_s = '$images_s' ,  emp_img_ext = '$image_set_type'  WHERE `emp_id` = '".$last_id."'";
         $query_update = $conn->query($sql_update);

         resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images);
             // copy($_FILES["img_user"]["tmp_name"],"../../../data/emp_images/".$last_id."/l/".$new_images);
             // copy($_FILES["img_user"]["tmp_name"],"../../../data/emp_images/".$last_id."/s/".$new_images);

         if(!$query_update){

             ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
         }
     }
   }
       if(isset($query_update_ins) && $query_update_ins){
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
       }else if(isset($query_update_ins) && !$query_update_ins) {
         ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }
       if(isset($query_update_udp) && $query_update_udp){
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
       }else if(isset($query_update_udp) && !$query_update_udp) {
         ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }
     exit();
}



 function create_case_direatory($folder,$last_id){

   deleteDirectory("../../../data/emp_images/".$last_id);

   if (!is_dir("../../../data/emp_images")){
         mkdir("../../../data/emp_images", 0775, true);
   }
   if (!is_dir("../../../data/emp_images/".$last_id)){
       mkdir("../../../data/emp_images/".$last_id, 0775, true);
   }
   if (!is_dir("../../../data/emp_images/".$last_id)){
       mkdir("../../../data/emp_images/".$last_id, 0775, true);
   }
   if (!is_dir("../../../data/emp_images/".$last_id."/l")){
       mkdir("../../../data/emp_images/".$last_id."/l", 0775, true);
   }

   if (!is_dir("../../../data/emp_images/".$last_id."/s")){
       mkdir("../../../data/emp_images/".$last_id."/s", 0775, true);
   }
 }

 function resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images){
       $image_l_size=800;
       $image_s_size=320;

        //$size = GetimageSize($images);
        list($w, $h) = GetimageSize($images);
        $extension = $image_set_type;
        if($extension=="jpg" || $extension=="jpeg"){
          $images_orig = imagecreatefromjpeg($images);
          $images_origs = imagecreatefromjpeg($images);
        }

        if($extension=="png"){

          $images_orig = imagecreatefrompng($images);
          $images_origs = imagecreatefrompng($images);
        }
        if ($extension=="gif"){
          $images_orig = imagecreatefromgif($images);
          $images_origs = imagecreatefromgif($images);
        }


        //---- l size -- //


          // $height=round($image_l_size*$h/$w);
          if($w > $h){
              $height=round($image_l_size);
              $width=round($image_l_size*$w/$h);
            }else {
              $height=round($image_l_size*$h/$w);
              $width=round($image_l_size);
            }

          $photoX = ImagesX($images_orig);
          $photoY = ImagesY($images_orig);
          $images_fin = ImageCreateTrueColor($width, $height);



        // แก้พื้นหลังสีดำ
        imagealphablending($images_fin, false);
        imagesavealpha($images_fin, true);
        // แก้พื้นหลังสีดำ

          ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);

        if($extension=="jpeg" || $extension=="jpg" )
        {
           ImageJPEG($images_fin,$file_size_l.$new_images);
        }
        if($extension=="png")
        {
          ImagePNG($images_fin,$file_size_l.$new_images);
        }
        if($extension=="gif")
        {
          ImageGIF($images_fin,$file_size_l.$new_images);
        }
        ImageDestroy($images_orig);
        ImageDestroy($images_fin);

        //---- s size -- //
        // $heights=round($image_s_size*$h/$w);

        if($w > $h){
            $heights=round($image_s_size);
            $widths=round($image_s_size*$w/$h);
          }else {
            $heights=round($image_s_size*$h/$w);
            $widths=round($image_s_size);
          }


        $photoXs = ImagesX($images_origs);
        $photoYs = ImagesY($images_origs);
        $images_fins = ImageCreateTrueColor($widths, $heights);
        // แก้พื้นหลังสีดำ
        imagealphablending($images_fins, false);
        imagesavealpha($images_fins, true);
        // แก้พื้นหลังสีดำ
        ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $widths+1, $heights+1, $photoXs, $photoYs);
        if($extension=="jpeg" || $extension=="jpg" )
        {
          ImageJPEG($images_fins,$file_size_s.$new_images);
        }
        if($extension=="png")
        {
          ImagePNG($images_fins,$file_size_s.$new_images);
        }
        if($extension=="gif")
        {
          ImageGIF($images_fins,$file_size_s.$new_images);
        }
        ImageDestroy($images_origs);
        ImageDestroy($images_fins);
 }



if ($_POST['method']=="get_data_emp"){
  include("../../../config/config.php");
    $sql_select = " SELECT  *  FROM Employee
                    left join Employee_Group on Employee_Group.empGroup_id = Employee.empGroup_id where Employee.emp_id = '".$_POST['id']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['empGroup_id']=$result_select['empGroup_id'];
          $array_row['emp_firstname']=$result_select['emp_firstname'];
          $array_row['emp_lastname']=$result_select['emp_lastname'];
          $array_row['emp_tel']=$result_select['emp_tel'];
          $array_row['emp_email']=$result_select['emp_email'];
          $array_row['emp_real_id']=$result_select['emp_real_id'];
          $array_row['username']=$result_select['username'];
          $array_row['empGroup_section']=$result_select['empGroup_section'];
          $array_row['emp_img_path']=$result_select['emp_img_path_s'];
          $array_row['emp_available_dashboard']=$result_select['emp_available_dashboard'];
          $array_row['office_id']=$result_select['office_id'];
          $array_row['dept_id']=$result_select['dept_id'];
          $array_row['login_ldap']=$result_select['login_ldap'];


        if(!file_exists('../../../'.$result_select['emp_img_path']) || $result_select['emp_img_path'] =='' ) {
          $pic_link = "";
        }else{
          $pic_link = "../../../".$result_select['emp_img_path'];
        }
          $array_row['img_view']=$pic_link;
          $array_row['path_view']= "../../../".$result_select['emp_img_path'];
        }
      }
      echo json_encode($array_row);
      exit();
 }

 if ($_POST['method']=="view_applactions"){
   include("../config/config.php");
     $sql_select = " SELECT  * ,Member.member_id as member_id_id  FROM Member left join Member_comp on  Member.member_id = Member_comp.member_id where Member.member_id = '".$_POST['id']."'  ";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {

           $array_row['emp_id']=$result_select['emp_id'];
           $array_row['member_fname']=$result_select['member_fname'];
           $array_row['member_lname']=$result_select['member_lname'];
           $array_row['member_position']=$result_select['member_position'];
           $array_row['member_address']=$result_select['member_address'];
           $array_row['member_phone']=$result_select['member_phone'];
           $array_row['member_cellphone']=$result_select['member_cellphone'];
           $array_row['member_facebook_type']=$result_select['member_facebook_type'];
           $array_row['member_email']=$result_select['member_email'];
           $array_row['member_comp_name']=$result_select['member_comp_name'];
           $array_row['member_comp_type']=$result_select['member_comp_type'];
           $array_row['member_type']=$result_select['member_type'];
           $array_row['member_img']=$result_select['member_img'];
           $array_row['member_comp_img']=$result_select['member_comp_img'];
           $array_row['member_comp_id']=$result_select['member_comp_id'];
           $array_row['member_id_id']=$result_select['member_id_id'];
           $array_row['member_status_confirm']=$result_select['member_status_confirm'];


          // รูป
          if($result_select['member_type']==0){
            if($result_select['member_facebook_type']==1){    //facebook
              if(!file_exists('../../../data/img_member/'.$result_select['member_id_id']."/".$result_select['member_img']) || $result_select['member_img'] =='' ) {
                $pic_link = "";
              }else{
                $pic_link = '../../../data/img_member/'.$result_select['member_id_id']."/".$result_select['member_img'];
              }
            }else{
              if(!file_exists('../../../data/img_member/'.$result_select['member_id_id']."/s/".$result_select['member_img']) || $result_select['member_img'] =='' ) {
                $pic_link = "";
              }else{
                $pic_link = '../../../data/img_member/'.$result_select['member_id_id']."/s/".$result_select['member_img'];
              }
            }
          }else{
            if(!file_exists('../../../data/img_membercom/'.$result_select['member_comp_id']."/s/".$result_select['member_comp_img']) || $result_select['member_comp_img'] =='' ) {
              $pic_link = "";
            }else{
              $pic_link = '../../../data/img_membercom/'.$result_select['member_comp_id']."/s/".$result_select['member_comp_img'];
            }
          }
           $array_row['img_view']= $pic_link;
         }
       }
       echo json_encode($array_row);
       exit();
  }
  if(isset($_GET["method"]) && $_GET["method"]=="add_group"){
    include("../../../config/config.php");

                  if (trim($_POST['gp_name']) == '' ){
                    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อกลุ่ม');</script><?php
                    exit();
                  }
                  if (trim($_POST['id_ch']) != '' ){
                    $andname = " AND empGroup_name !=  '".trim($_POST['gp_name'])."' ";
                  }

                  $sql_select = "SELECT empGroup_name  FROM Employee_Group where empGroup_name = '".trim($_POST['gp_name'])."' AND empGroup_status = '0' $andname ";
                  $query_select = $conn->query($sql_select);
                  $array_row = array();
                  if ($query_select->num_rows >0) {
                    ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อกลุ่มมีอยู่ในระบบแล้ว กรุณากรอกชื่อกลุ่มใหม่');</script><?php
                    exit();
                  }

   $gp_name = data_filter(trim($_POST['gp_name']));
   $radio_status = data_filter(trim($_POST['radio_status']));
   $radio_sections = data_filter(trim($_POST['radio_sections']));
   $radio_gp = data_filter(trim($_POST['radio_gp']));


      if (trim($_POST['id_ch']) == '' ){

        $sql_add_group = "INSERT INTO Employee_Group (empGroup_name,empGroup_status,empGroup_enable,empGroup_section,empGroup_create_datetime,empGroup_createBy_id,empGroup_level)
        VALUES ('$gp_name','0','$radio_status','$radio_sections','$date_setting','$emp_id','$radio_gp')";
        $query_add_group = $conn->query($sql_add_group);
        $group_id = $conn->insert_id;

      }else{

        $sql_update = "UPDATE `Employee_Group` SET
                              `empGroup_name` = '$gp_name',
                               empGroup_enable = '$radio_status' ,
                               empGroup_section = '$radio_sections',
                               empGroup_level = '$radio_gp'
                        WHERE `empGroup_id` = '".trim($_POST['id_ch'])."' ";
        $query_add_group = $conn->query($sql_update);
        $group_id = $_POST['id_ch'] ;

        $sql_delete_permission = "DELETE FROM Employee_Group_Permission WHERE empGroup_id = '$group_id' ";
        $query_delete_permission = $conn->query($sql_delete_permission);

      }

        if($query_add_group){
          for($i = 0; $i < count($_POST['permission']); $i++){
            $sql_add_permission = "INSERT INTO Employee_Group_Permission (empGroup_id, page_id, permission_create_date)
            VALUES ('".$group_id."', '".$_POST['permission'][$i]."', '".date('Y-m-d H:i:s')."')
            ";
            $query_add_permission = $conn->query($sql_add_permission);
          }
        }

        if($sql_add_group || $sql_update || $query_add_permission){
           if (trim($_POST['id_ch']) != '' ){
            ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.location.href='../?page=user/group';</script><?php
           }else{
            ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.location.href='../?page=user/group';</script><?php
           }
        }else {
          ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
        }
        exit();
}

if ($_POST['method']=="del_group"){

   include("../../../config/config.php");
    $sql_edit_pass = "UPDATE  Employee_Group SET empGroup_status= '1' WHERE  empGroup_id = '".$_POST['del_id']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);


    $sql_del_user = "UPDATE `Employee` SET `emp_status` = '1' WHERE empGroup_id ='".$_POST['del_id']."'";
    $query_del_user = $conn->query($sql_del_user);

    if ($query_edit_pass && $query_del_user){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}


class PassHash {
    private static $algo = '$2a';
    private static $cost = '$10';
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }
    public static function hash($password) {
        return crypt($password, self::$algo .
                self::$cost .
                '$' . self::unique_salt());
    }
    public static function check_password($hash, $password) {
        $full_salt = substr($hash, 0, 29);
        $new_hash = crypt($password, $full_salt);
        return ($hash == $new_hash);
    }
}



if ($_POST['method']=="reset_password_office"){


  $sql_select = "SELECT * FROM Employee WHERE  emp_id = '".$_POST['repass_id']."' ";
  $query_select = $conn->query($sql_select);
  if($query_select->num_rows > 0 ){
    $row=$query_select->fetch_assoc();
    $name     = $row['emp_firstname'];
    $lastname = $row['emp_lastname'];
    $email    = $row['emp_email'];
    $newpassword = random_password();
    $password_hash = hash('sha256', $newpassword);
    $upd = "UPDATE Employee SET password = '".$password_hash."'  WHERE emp_id = '".$_POST['repass_id']."' ";
    $query_select = $conn->query($upd);


  }

    $url = $_SERVER['HTTP_HOST']."/backoffice";
    $namesent = $name.' '.$lastname;
    $title_name = "เรียน คุณ ".$namesent;
    $text = 'เราได้รับคำขอจากคุณให้สร้างชื่อผู้ใช้งานบนระบบ '.$_SERVER["HTTP_HOST"]." โดยใช้ <br> Username : ".$email." <br> Password : ".$newpassword."<br>เพื่อเข้าสูระบบ";

    $message ="
                  <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                    <div class=\"header\" style=\"width:auto\">
                      <img src=\"https://".$_SERVER["HTTP_HOST"]."/img/header_email_2.png\" style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                      <div>
                      <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                        <div style=\"padding: 20px;color:#000;\">
                        ".$title_name."
                        <br>
                        <br>
                        ".$text."
                        <br>
                        โดยสามารถคลิ๊กที่ ลิงค์ด้านล่างนี้ เพื่อเข้าสู่ระบบ :
                        <br>
                        <br>
                        <br>
                        <br>
                        <div style=\"text-align:center;color:#000;\">
                        <a href=\"https://".$url."\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >เข้าสู่ระบบ</a>
                        </div>
                        <br>
                        <br>
                        <br>
                        </div>
                      <hr style=\"border-color:#fefefe; margin:0px;\" />
                         <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                           ขอบคุณ.<br />
                           ทีมงาน <a href=\"https://".$_SERVER["HTTP_HOST"]."\" target=\"blank\">".$_SERVER["HTTP_HOST"]."</a>
                         </div>
                     </div>

              ";
          $form_emil = "ditpcare@ditp.go.th";

          $send_email_fnc = sendEmail($form_emil,"DITP Care",$email,$namesent,"แจ้ง Username และ Password สำหรับเข้าใช้งานระบบ DITP Care",$message);

  if($send_email_fnc){
    echo "1";

  }else{
    echo '0';
  }
  exit();
}


if ($_POST['method']=="reset_password"){

  $emp_email = $_POST['repass_id'];
  $id_member = $_POST['repass_id'];

  $sql_select = "SELECT * FROM Member WHERE  member_id = '".$_POST['repass_id']."' ";
  $query_select = $conn->query($sql_select);
  if($query_select->num_rows > 0 ){
    $row=$query_select->fetch_assoc();
    $mailsent = $row['member_email'];
    $emp_email = $mailsent;
    $form_emil = "ditpcare@ditp.go.th";
    $namesent = $row['member_fname']." ".$row['member_lname'];
    $newpassword = random_password();
    $password_hash = PassHash::hash($newpassword);

    $url = $_SERVER['HTTP_HOST']."/frontend/reset_password.php?id=$password_hash";

  if($row['member_type']==0){
    $title_name = "เรียน คุณ,";
  }else{
    $title_name = "เรียน บริษัท,";
  }

$message ="
                <div class=\"wrapper\" style=\"width:860px;background: #f8f8f8;\">
                                  <div class=\"header\" style=\"width:auto\">
                                  <img src=\"https://".$_SERVER["HTTP_HOST"]."/img/header_email_2.png\" style=\"max-width: 860px;\" srtlw=\"width:100%; height:auto;\" />
                                  <div>
                                  <div class=\"content\" style=\"width:auto; height:auto; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                  <div style=\"padding: 20px;color:#000;\">
                                  ".$title_name."
                                  ".$namesent."
                                  <br>
                                  <br>
                                  ".$_SERVER['HTTP_HOST']." ได้รับคำขอร้องจากเว็บไซต์ ถ้าคุณต้องการเปลี่ยนรหัสผ่าน
                                  <br>
                                  คลิกที่ลิงค์ด้านล่างนี้ เพื่อรีเซ็ตรหัสผ่านของคุณ :
                                  <br>
                                  <br>
                                  <br>
                                  <br>
                                  <div style=\"text-align:center;color:#000;\">
                                  <a href=\"https://".$url."\" style=\"background:#22A180;color:#fff;padding: 15px 50px;text-align:center;text-decoration: none;border-radius:25px\" target=\"_blank\" >ขอรหัสผ่านใหม่</a>
                                  </div>
                                  <br>
                                  <br>
                                  <br>
                                  หากคุณไม่ได้ดำเนินการร้องขอนี้ โปรดอย่าสนใจอีเมลฉบับนี้ มั่นใจได้ว่าบัญชีสมาชิกของคุณจะปลอดภัยได้กับเรา
                                  <br>
                                  </div>
                                  <hr style=\"border-color:#fefefe; margin:0px;\" />
                                     <div class=\"footer\" style=\"width:auto; height:auto; padding:20px; font-family: Tahoma, Verdana, Segoe, sans-serif; font-size:16px;\">
                                       ขอบคุณ.<br />
                                       ทีมงาน <a href=\"https://".$_SERVER["HTTP_HOST"]."\" target=\"blank\">".$_SERVER["HTTP_HOST"]."</a>
                                     </div>
                                   </div>

          ";

    $send_email_fnc = sendEmail($form_emil,"DITP Care",$emp_email,$namesent,"คุณได้ขอตั้งค่ารหัสผ่านใหม่ DITP Care",$message,$newpassword,$emp_email);

  if($send_email_fnc=='1'){
    $upd = "UPDATE Member SET member_tokin = '".$password_hash."' ,member_reset_pass = '1' WHERE member_id = '".$id_member."' ";
    $query_upd = $conn->query($upd);

    $headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
    $postfields = array("id" => $id_member, "type" => 'care');
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => "http://ditpall.ibusiness.co.th/v5/update_status_sso",
        CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $postfields,
        CURLOPT_INFILESIZE => $filesize,
        CURLOPT_RETURNTRANSFER => true
    ); // cURL options
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);

    echo "1";
  }
}else{
    echo '0';
  }
    exit();


}

function random_password( $length = 8 ) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
  $password = substr( str_shuffle( $chars ), 0, $length );
  return $password;
 }


  function sendEmail($from_email,$from_name,$to_email,$to_name,$subject,$message,$newpassword2,$mail_check){
    global $dbConnection;
   $body = $message;
   try {
    $mail = new PHPMailer(true);
    $mail->CharSet = "utf-8";
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";	// sets the prefix to the servier
    $mail->Host = "mailrelay.uc-workd.com"; // SMTP server203.150.62.22
    $mail->Port = 465; // พอร์ท 25
    $mail->Username = "ditpcare@ditp.go.th"; // account SMTP
    $mail->Password = 'NzMxQzVFMjANzQ3MSRUE0UIxN0MNUQwMTBCNENDQzkw'; // รหัสผ่าน SMTP
    $mail->SetFrom($from_email, $from_name);
    $mail->AddReplyTo($from_email, $from_name);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $toEmail= $to_email;
    $toName = $to_name;
    $i=0;
     $mail->AddAddress($toEmail,$toName);
     $i++;
    if(!$mail->Send()) {
     $json = '0';
    } else {
       $json = '1';
    }
   } catch (phpmailerException $e) {
       $json = '0';
   } catch (Exception $e) {
       $json = '0';
   }
   return $json;
  }


  if ($_POST['method']=="del_emp"){
     include("../../../config/config.php");
     $sql_edit_pass = "UPDATE  Employee SET emp_status = '1' WHERE  emp_id = '".$_POST['id_p']."'";
      $query_edit_pass = $conn->query($sql_edit_pass);
      if ($query_edit_pass){
          echo '1';
      }else {
          echo "0";
      }
      exit();
  }


  function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
      $objects = scandir($dirPath);
      foreach ($objects as $object) {
        if ($object != "." && $object !="..") {
          if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
            deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
          } else {
            unlink($dirPath . DIRECTORY_SEPARATOR . $object);
          }
        }
      }
    reset($objects);
    rmdir($dirPath);
    }
  }

  function getPositionImage($emp_img_path,$size){
  list($width, $height) = getimagesize($emp_img_path);
  $ratio = $width/$height; // width/height

  if( $ratio > 1) {
      $width = $size*$ratio;
      $height = $size;
      $css = " width:auto; height:40px; margin-left:-".(($width/2)-($size/2))."px";
  }
  else {
  $width = $size;
  $height = $size/$ratio;
        $css = "height:auto; width:40px; top:0;";
  }
  return $css;
  }


  if ($_POST['method']=="dis_member"){

      $sql_edit_pass = "UPDATE  Member SET member_status= '".$_POST['ty']."' WHERE  member_id = '".$_POST['id_me']."'";
      $query_edit_pass = $conn->query($sql_edit_pass);

      if ($query_edit_pass ){
          echo '1';
      }else {
          echo "0";
      }
      exit();
  }


?>
