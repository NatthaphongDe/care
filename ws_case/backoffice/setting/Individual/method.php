<?php
include("../../../config/config.php");

$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];
$emp_section = $_SESSION["admin"]["empSection"];

if(isset($_GET["method"]) && $_GET["method"]=="get_contact_thai"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = get_contact_thai($post);
    echo $response;
exit();
}

function get_contact_thai($post){
    global $emp_id;
    global $emp_section;
   include("../../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT * ";
   $sql_caseCh .= " FROM  Contact_thai  left join Province on  Province.prov_id =  Contact_thai.prov_id WHERE ct_status = '0' AND ct_type = '1' AND ct_section='$emp_section' ";

  if($post->sort=="id"){
     $sort_col = "ct_id";
  }
  if($post->sort=="name"){
    $sort_col = "ct_firstname";
  }
  if($post->sort=="id_care"){
    $sort_col = "ct_card";
  }
  if($post->sort=="numbertrade"){
    $sort_col = "ct_numbertrade";
  }
  if($post->sort=="name"){
    $sort_col = "ct_firstname";
  }
  if($post->sort=="business_type"){
    $sort_col = "ct_business_type";
  }
  if($post->sort=="career"){
    $sort_col = "ct_career";
  }
  if($post->sort=="cell"){
    $sort_col = "ct_homephone";
  }
  if($post->sort=="cellphone"){
    $sort_col = "ct_cellphone";
  }
  if($post->sort=="email"){
    $sort_col = "ct_email";
  }
  if($post->sort=="address"){
    $sort_col = "ct_address";
  }
  if($post->sort=="province"){
    $sort_col = "prov_name";
  }
  if($post->sort=="code"){
    $sort_col = "ct_postcode";
  }
  if($post->type_section != ""){
      $sql_caseCh .= " AND ct_department = '$post->type_section' ";
  }
  if($post->text != ""){
    $sql_caseCh .= "  AND ( ct_firstname LIKE '%".$post->text."%'
                            or ct_lastname LIKE '%".$post->text."%'
                            or ct_lastname LIKE '%".$post->text."%'
                            or ct_card LIKE '%".$post->text."%'
                            or ct_email LIKE '%".$post->text."%'
                            or ct_address LIKE '%".$post->text."%'
                            or ct_career LIKE '%".$post->text."%'
                            or ct_homephone LIKE '%".$post->text."%'
                            or ct_cellphone LIKE '%".$post->text."%'
                          )";
                        }
  $sql_caseCh .= " GROUP BY ct_card ";
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  // echo $sql_caseCh;
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$re['ct_id'].'</span>';
       if($re['ct_card']==0){
         $care_ch = '<span class="txt_nol">-</span>';
       }else{
         $ct_card = preg_replace('/[^0-9]/', '', $re['ct_card']);
         $care_ch = '<span class="txt_nol">'.$ct_card.'</span>';
       }
       $caseCh_col_arr["id_care"] =$care_ch;
       $caseCh_col_arr["name"] =  '<span class="txt_nol cursor" onclick="edit_contact_thai('.$re['ct_id'].',1,0);">'.$re['ct_firstname'].'  '.$re['ct_lastname'].'</span>';



       if($re['ct_birthday']== '0000-00-00'){
         $birthday_ch = '<span class="txt_nol">-</span>';
       }else{
         $date = date("d/m/Y" , strtotime($re['ct_birthday']));
         $birthday_ch = '<span class="txt_nol">'.$date.'</span>';
       }

       if($re['ct_numbertrade'] != '') {
        $numbertrade= $re['ct_numbertrade'];
      } else {
        $numbertrade = '-';
      }

      $caseCh_col_arr["numbertrade"] =  '<span class="txt_nol">'.$numbertrade.'</span>';

       if($re['ct_business_type'] == '1'){
         $business_type = '<span class="txt_nol">นำเข้า</span>';
       }else if($re['ct_business_type'] == '2'){
         $business_type = '<span class="txt_nol">ส่งออก</span>';
       }else{
         $business_type = '<span class="txt_nol">อื่น ๆ</span>';
       }
      $caseCh_col_arr["business_type"] = $business_type;


      if($re['ct_career']== ''){
        $career_ch = '<span class="txt_nol">-</span>';
      }else{
        $career_ch = '<span class="txt_nol">'.$re['ct_career'].'</span>';
      }

      $caseCh_col_arr["career"] = $career_ch;
      $ct_homephone = preg_replace('/[^0-9]/', '', $re['ct_homephone']);
      $caseCh_col_arr["cell"] = '<span class="txt_nol">'.$ct_homephone.'</span>';
      if($re['ct_cellphone']== ''){
        $cellphone_ch = '<span class="txt_nol">-</span>';
      }else{
        $ct_cellphone = preg_replace('/[^0-9]/', '', $re['ct_cellphone']);
        $cellphone_ch = '<span class="txt_nol">'.$ct_cellphone.'</span>';
      }
      $caseCh_col_arr["cellphone"] = $cellphone_ch;
      $caseCh_col_arr["email"] = '<span class="txt_nol">'.$re['ct_email'].'</span>';
      $caseCh_col_arr["address"] = '<span class="txt_nol">'.$re['ct_address'].'</span>';
      if($re['prov_id']== ''){
        $province_ch = '<span class="txt_nol">-</span>';
      }else{
        $province_ch = '<span class="txt_nol">'.$re['prov_name'].'</span>';
      }

      $caseCh_col_arr["province"] = $province_ch;
      if($re['ct_postcode']==0){
        $code_ch = '<span class="txt_nol">-</span>';
      }else{
        $code_ch = '<span class="txt_nol">'.$re['ct_postcode'].'</span>';
      }
      $caseCh_col_arr["code"] = $code_ch;
      $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_contact_thai('.$re['ct_id'].',1);"></span>
              <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_contact_thai('.$re['ct_id'].');"></span></div>';
      $caseCh_col_arr["del"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}



if(isset($_GET["method"]) && $_GET["method"]=="add_contact_thai"){
  include("../config/config.php");

  $ct_department = data_filter(trim($_POST['ct_department']));
  $ct_card = data_filter(trim($_POST['ct_card']));
  $ct_card = str_replace("-","",$ct_card);
  $ct_card = str_replace("_","",$ct_card);

  $ct_firstname = data_filter(trim($_POST['ct_firstname']));
  $ct_lastname = data_filter(trim($_POST['ct_lastname']));
  if($_POST['ct_birthday']!=''){
    $ct_birthday = DateTime::createFromFormat('d/m/Y', data_filter($_POST['ct_birthday']))->format('Y-m-d');
  }
  $ct_business_type = data_filter(trim($_POST['ct_business_type']));
  $ct_career = data_filter(trim($_POST['ct_career']));
  $ct_homephone = data_filter(trim($_POST['ct_homephone']));
  $ct_cellphone = data_filter(trim($_POST['ct_cellphone']));
  $ct_email = data_filter(trim($_POST['ct_email']));
  $ct_address = data_filter(trim($_POST['ct_address']));
  $prov_id = data_filter(trim($_POST['prov_id']));
  $ct_postcode = data_filter(trim($_POST['ct_postcode']));
  $ct_postcode = str_replace("_","",$ct_postcode);

  $id_ch = data_filter(trim($_POST['id_ch']));


              if (strlen($ct_card) != '13' && $ct_card !='' ){
                ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกรหัสบัตรประฃาชนให้ครบ 13 หลัก');</script><?php
                exit();
              }else if(strlen($ct_card) == '13'){
                if($id_ch == ''){
                    $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_card = '".$ct_card."' AND ct_status = '0' AND ct_type ='1' ";
                    $query_select = $conn->query($sql_select);
                    $array_row = array();
                    if ($query_select->num_rows >0) {
                      ?><script type="text/javascript">parent.iziToast_func.alert('รหัสบัตรประชาชนมีอยู่ในระบบแล้ว กรุณากรอกรหัสบัตรประชาชนใหม่');</script><?php
                      exit();
                    }
                }else{
                  $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_card = '".$ct_card."' AND ct_status = '0' AND ct_type ='1'  AND ct_id != $id_ch ";
                  $query_select = $conn->query($sql_select);
                  $array_row = array();
                  if ($query_select->num_rows >0) {
                    ?><script type="text/javascript">parent.iziToast_func.alert('รหัสบัตรประชาชนมีอยู่ในระบบแล้ว กรุณากรอกรหัสบัตรประชาชนใหม่');</script><?php
                    exit();
                  }
                }
              }

          if ($ct_firstname == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อ');</script><?php
            exit();
          }
          if ($ct_lastname == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกนามสกุล');</script><?php
            exit();
          }
          if($ct_card == ''){
            if($id_ch == ''){
                $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_firstname = '$ct_firstname' AND ct_lastname = '$ct_lastname' AND ct_status = '0' AND ct_type ='1' ";
                $query_select = $conn->query($sql_select);
                $array_row = array();
                if ($query_select->num_rows >0) {
                  ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อ-นามสกุล มีอยู่ในระบบแล้ว กรุณากรอกชื่อใหม่');</script><?php
                  exit();
                }
            }else{
              $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_firstname = '$ct_firstname' AND ct_lastname = '$ct_lastname' AND ct_firstname = ''
                              AND ct_status = '0' AND ct_type ='1' AND ct_id != $id_ch";
              $query_select = $conn->query($sql_select);
              $array_row = array();
              if ($query_select->num_rows >0) {
                ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อ-นามสกุล มีอยู่ในระบบแล้ว กรุณากรอกชื่อใหม่');</script><?php
                exit();
              }
            }
          }
          if ($ct_homephone == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกเบอร์โทรศัพท์');</script><?php
            exit();
          }
          if ($ct_email == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอก email');</script><?php
            exit();
          }
          if ($ct_address == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกที่อยู่');</script><?php
            exit();
          }


          if($id_ch == ''){

              $sql_add = "INSERT INTO Contact_thai (ct_section,ct_type,ct_department,ct_card,ct_firstname,ct_lastname,ct_birthday,ct_business_type,ct_career,ct_homephone,ct_cellphone,ct_email,ct_address,prov_id,ct_postcode,ct_create_datetime,ct_createBy_id)
              VALUES ('$emp_section','1','$ct_department','$ct_card','$ct_firstname','$ct_lastname','$ct_birthday','$ct_business_type','$ct_career','$ct_homephone','$ct_cellphone','$ct_email','$ct_address','$prov_id','$ct_postcode','$date_setting','$emp_id')";

              $query_add = $conn->query($sql_add);
          }else{
            $sql_edit = "UPDATE  Contact_thai SET
                          ct_department = '$ct_department'
                          ,ct_firstname   = '$ct_firstname'
                          ,ct_lastname = '$ct_lastname'
                          ,ct_birthday = '$ct_birthday'
                          ,ct_business_type = '$ct_business_type'
                          ,ct_career = '$ct_career'
                          ,ct_homephone = '$ct_homephone'
                          ,ct_cellphone = '$ct_cellphone'
                          ,ct_email = '$ct_email'
                          ,ct_address = '$ct_address'
                          ,prov_id = '$prov_id'
                          ,ct_postcode = '$ct_postcode'
                          ,ct_import = '0'
                          ,ct_update_datetime =  '$date_setting'
                          ,ct_updateBy_id = '$emp_id'
                          where  ct_id = '$id_ch'";
   $query_edit = $conn->query($sql_edit);
}
      if($query_add || $query_edit){
        if($query_add){
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        }else{
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        }
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



if ($_POST['method']=="edit_contact_thai"){
  $ty = data_filter(trim($_POST['ty']));
  $id = data_filter(trim($_POST['id']));

    $sql_select = " SELECT  *  FROM Contact_thai where ct_id = '$id' AND ct_type = '$ty' AND ct_section='$emp_section' ";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['ct_department']=$result_select['ct_department'];
          $array_row['ct_card']=$result_select['ct_card'];
          $array_row['ct_firstname']=$result_select['ct_firstname'];
          $array_row['ct_lastname']=$result_select['ct_lastname'];
          $array_row['ct_birthday']=$result_select['ct_birthday'];
          $array_row['ct_business_type']=$result_select['ct_business_type'];
          $array_row['ct_career']=$result_select['ct_career'];
          $array_row['ct_homephone']=$result_select['ct_homephone'];
          $array_row['ct_cellphone']=$result_select['ct_cellphone'];
          $array_row['ct_email']=$result_select['ct_email'];
          $array_row['ct_address']=$result_select['ct_address'];
          $array_row['prov_id']=$result_select['prov_id'];
          $array_row['ct_postcode']=$result_select['ct_postcode'];
          $array_row['Country_id']=$result_select['Country_id'];
        }
      }
      echo json_encode($array_row);
      exit();
 }


 if(isset($_GET["method"]) && $_GET["method"]=="import_people_th"){

   if (!is_dir("../../../data/setting")){
         mkdir("../../../data/setting", 0775, true);
   }
   if (!is_dir("../../../data/setting/import_peoplethailand")){
       mkdir("../../../data/setting/import_peoplethailand", 0775, true);
   }

     if($_FILES["userimport"]["size"]) {
       $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
       move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../../data/setting/import_peoplethailand/".$new_excel);
       $inputFileName = "../../../data/setting/import_peoplethailand/".$new_excel;

       ?><script type="text/javascript">top.import_peoplethailand('<?= $inputFileName ?>');</script><?php
     }
     else {
        ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
       exit();
     }
 }


 if ($_POST['method']=="del_contact_thai"){
    $sql_del = "UPDATE   Contact_thai SET ct_status = '1' WHERE  ct_id = '".$_POST['ct_id']."'";
     $query_del = $conn->query($sql_del);
     if ($query_del){
         echo '1';
     }else {
         echo "0";
     }
     exit();
 }



 if(isset($_GET["method"]) && $_GET["method"]=="get_contact_inter"){
     $post = array();
     $request_body = file_get_contents('php://input');
     $post = json_decode($request_body);
     $response = get_contact_inter($post);
     echo $response;
 exit();
 }

 function get_contact_inter($post){

     global $emp_id;
     global $emp_section;

    include("../../../config/config.php");

    $caseCh_arr = array();
    $sql_caseCh = "SELECT * ";
    $sql_caseCh .= " FROM  Contact_thai  left join Country on  Country.id =  Contact_thai.Country_id WHERE ct_status = '0' AND ct_type = '2' AND ct_section='$emp_section' ";
  if($post->sort=="id"){
    $sort_col = "ct_id";
  }
  if($post->sort=="id_care"){
    $sort_col = "ct_card";
  }
  if($post->sort=="numbertrade"){
    $sort_col = "ct_numbertrade";
  }
  if($post->sort=="name"){
    $sort_col = "ct_firstname";
  }
  if($post->sort=="business_type"){
    $sort_col = "ct_business_type";
  }
  if($post->sort=="career"){
    $sort_col = "ct_career";
  }
  if($post->sort=="cell"){
    $sort_col = "ct_homephone";
  }
  if($post->sort=="cellphone"){
    $sort_col = "ct_cellphone";
  }
  if($post->sort=="email"){
    $sort_col = "ct_email";
  }
  if($post->sort=="address"){
    $sort_col = "ct_address";
  }
  if($post->sort=="province"){
    $sort_col = "name";
  }

  if($post->text != ""){
    $sql_caseCh .= "  AND ( ct_firstname LIKE '%".$post->text."%'
                            or ct_lastname LIKE '%".$post->text."%'
                            or ct_card LIKE '%".$post->text."%'
                            or ct_email LIKE '%".$post->text."%'
                            or ct_address LIKE '%".$post->text."%'
                            or ct_career LIKE '%".$post->text."%'
                            or ct_homephone LIKE '%".$post->text."%'
                            or ct_homephone LIKE '%".$post->text."%'
                          )";
                        }

   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
  //  echo $sql_caseCh;
      $query_edit_pass = $conn->query($sql_caseCh);
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$re['ct_id'].'</span>';
        if($re['ct_card']==''){
          $care_ch = '<span class="txt_nol">-</span>';
        }else{
          $ct_card = preg_replace('/[^0-9]/', '', $re['ct_card']);
          $care_ch = '<span class="txt_nol">'.$ct_card.'</span>';
        }
        $caseCh_col_arr["id_care"] = $care_ch;
        $caseCh_col_arr["name"] =  '<span class="txt_nol cursor"  onclick="edit_contact_thai('.$re['ct_id'].',2,0);">'.$re['ct_firstname'].'  '.$re['ct_lastname'].'</span>';
        if($re['ct_birthday']=='0000-00-00'){
          $date = '-';
        }else{
              $date = date("d/m/Y" , strtotime($re['ct_birthday']));
        }

        if($re['ct_numbertrade'] != '') {
          $numbertrade= $re['ct_numbertrade'];
        } else {
          $numbertrade = '-';
        }

        $caseCh_col_arr["numbertrade"] =  '<span class="txt_nol">'.$numbertrade.'</span>';
        if($re['ct_business_type'] == '1'){
          $business_type = '<span class="txt_nol">นำเข้า</span>';
        }else if($re['ct_business_type'] == '2'){
          $business_type = '<span class="txt_nol">ส่งออก</span>';
        }else{
          $business_type = '<span class="txt_nol">อื่น ๆ</span>';
        }
       $caseCh_col_arr["business_type"] = $business_type;
       
       if($re['ct_career']==''){
         $career_ch = '<span class="txt_nol">-</span>';
       }else{
         $career_ch = '<span class="txt_nol">'.$re['ct_career'].'</span>';
       }


       if ($re['flag_32']!="" && $re['flag_128']!="" ) {
         $pic_link  = "../img/flags/".$re['flag_32']."";

       }else{
         if($re['img_path']==''){
           $pic_link = "";

         }else{
           $pic_link = "../../".$re['img_path'];
         }
       }
       if(!file_exists('../'.$pic_link) || $pic_link =='' ) {
         if($pic_link==''){
           $pic ='';
         }else{
           $pic = '<i class="ico-flag-ct " style="background-image: url(img/default_country.png);"></i>';
         }
       }else{
         $pic = '<i class="ico-flag-ct" style="background-image: url(../setting/'.$pic_link.');"></i>';
       }


       $caseCh_col_arr["career"] = $career_ch;
        $ct_homephone = preg_replace('/[^0-9]/', '', $re['ct_homephone']);
        $caseCh_col_arr["cell"] = '<span class="txt_nol">'.$ct_homephone.'</span>';
       if($re['ct_cellphone']==''){
         $cellphone = '<span class="txt_nol">-</span>';
       }else{
        $ct_cellphone = preg_replace('/[^0-9]/', '', $re['ct_cellphone']);
        $cellphone = '<span class="txt_nol">'.$ct_cellphone.'</span>';
       }
       $caseCh_col_arr["cellphone"] = $cellphone;
       $caseCh_col_arr["email"] = '<span class="txt_nol">'.$re['ct_email'].'</span>';
       $caseCh_col_arr["address"] = '<span class="txt_nol">'.$re['ct_address'].'</span>';

       if($re['Country_id']=='0'){
         $province = '<span class="txt_nol">-</span>';
       }else{
         $province = '<div><span class="txt_nol">'.$pic.''.$re['name'].'</span></div>';
       }
       $caseCh_col_arr["province"] = $province;
       $caseCh_col_arr["code"] = '<span class="txt_nol">'.$re['ct_postcode'].'</span>';
       $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_contact_thai('.$re['ct_id'].',2);"></span>
               <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_contact_thai('.$re['ct_id'].');"></span></div>';
       $caseCh_col_arr["del"] = $del;
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }


 if(isset($_GET["method"]) && $_GET["method"]=="save_contact_inter"){
  //  include("../config/config.php");

   $ct_department = data_filter(trim($_POST['ct_department']));
   $ct_card = data_filter(trim($_POST['ct_card']));
   $ct_firstname = data_filter(trim($_POST['ct_firstname']));
   $ct_lastname = data_filter(trim($_POST['ct_lastname']));
   if($_POST['ct_birthday']==''){
     $ct_birthday ='';
   }else{
     $ct_birthday = DateTime::createFromFormat('d/m/Y', data_filter($_POST['ct_birthday']))->format('Y-m-d');
   }
   $ct_business_type = data_filter(trim($_POST['ct_business_type']));
   $ct_career = data_filter(trim($_POST['ct_career']));
   $ct_homephone = data_filter(trim($_POST['ct_homephone']));
   $ct_cellphone = data_filter(trim($_POST['ct_cellphone']));
   $ct_email = data_filter(trim($_POST['ct_email']));
   $ct_address = data_filter(trim($_POST['ct_address']));
   $Country_id = data_filter(trim($_POST['Country_id']));
   $id_ch = data_filter(trim($_POST['id_ch']));


           if($id_ch == ''){
               if ($ct_card != '' ){
                 $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_card = '".$ct_card."' AND ct_status = '0' AND ct_type ='2' ";
                 $query_select = $conn->query($sql_select);
                 $array_row = array();
                 if ($query_select->num_rows >0) {
                   ?><script type="text/javascript">parent.iziToast_func.alert('Passport No. มีอยู่ในระบบแล้ว กรุณากรอก Passport No.ใหม่');</script><?php
                   exit();
                 }
               }
           }


           if ($ct_firstname == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อ');</script><?php
             exit();
           }
           if ($ct_lastname == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกนามสกุล');</script><?php
             exit();
           }



           if($ct_card == ''){
             if($id_ch == ''){
                 $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_firstname = '$ct_firstname' AND ct_lastname = '$ct_lastname' AND ct_status = '0' AND ct_type ='2' ";
                 $query_select = $conn->query($sql_select);
                 $array_row = array();
                 if ($query_select->num_rows >0) {
                   ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อ-นามสกุล มีอยู่ในระบบแล้ว กรุณากรอกชื่อใหม่');</script><?php
                   exit();
                 }
             }else{
               $sql_select = "SELECT ct_card  FROM  Contact_thai where ct_firstname = '$ct_firstname' AND ct_lastname = '$ct_lastname' AND ct_firstname = ''
                              AND ct_status = '0' AND ct_type ='2' AND ct_id != $id_ch";
               $query_select = $conn->query($sql_select);
               $array_row = array();
               if ($query_select->num_rows >0) {
                 ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อ-นามสกุล มีอยู่ในระบบแล้ว กรุณากรอกชื่อใหม่');</script><?php
                 exit();
               }
             }
           }


           if ($ct_homephone == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกเบอร์โทรศัพท์');</script><?php
             exit();
           }
           if ($ct_email == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอก email');</script><?php
             exit();
           }
           if ($ct_address == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกที่อยู่');</script><?php
             exit();
           }


           if($id_ch == ''){
               $sql_add = "INSERT INTO Contact_thai (`ct_section`,ct_type,ct_department,ct_card,ct_firstname,ct_lastname,ct_birthday,ct_business_type,ct_career,ct_homephone,ct_cellphone,ct_email,ct_address,Country_id,ct_create_datetime,ct_createBy_id)
               VALUES ('$emp_section','2','$ct_department','$ct_card','$ct_firstname','$ct_lastname','$ct_birthday','$ct_business_type','$ct_career','$ct_homephone','$ct_cellphone','$ct_email','$ct_address','$Country_id','$date_setting','$emp_id')";
               $query_add = $conn->query($sql_add);
           }else{
             $sql_edit = "UPDATE  Contact_thai SET
                           ct_department = '$ct_department'
                           ,ct_firstname   = '$ct_firstname'
                           ,ct_lastname = '$ct_lastname'
                           ,ct_birthday = '$ct_birthday'
                           ,ct_business_type = '$ct_business_type'
                           ,ct_career = '$ct_career'
                           ,ct_homephone = '$ct_homephone'
                           ,ct_cellphone = '$ct_cellphone'
                           ,ct_email = '$ct_email'
                           ,ct_address = '$ct_address'
                           ,Country_id = '$Country_id'
                           ,ct_import = '0'
                           ,ct_update_datetime =  '$date_setting'
                           ,ct_updateBy_id = '$emp_id'
                           where  ct_id = '$id_ch'";
    $query_edit = $conn->query($sql_edit);
 }
       if($query_add || $query_edit){     //  setting/Individual/contact_thai.php
         if($query_add){
           ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
         }else{
           ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
         }
       }else{
         ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }
       exit();
 }



 if(isset($_GET["method"]) && $_GET["method"]=="import_people_inter"){
   if (!is_dir("../../../data/setting")){
         mkdir("../../../data/setting", 0775, true);
   }
   if (!is_dir("../../../data/setting/import_peopleinter")){
       mkdir("../../../data/setting/import_peopleinter", 0775, true);
   }
     if($_FILES["userimport"]["size"]) {
       $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
       move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../../data/setting/import_peopleinter/". $new_excel);
       $inputFileName = "../../../data/setting/import_peopleinter/".$new_excel;
       ?><script type="text/javascript">top.import_peopleinter('<?= $inputFileName ?>');</script><?php
     }else{
        ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
       exit();
     }
 }



?>
