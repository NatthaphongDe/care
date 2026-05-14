<?php
include("../../../config/config.php");

$date_setting = date("Y-m-d h:i:sa");
$emp_id = $_SESSION["admin"]["empId"];
$emp_section = $_SESSION["admin"]["empSection"];

if(isset($_GET["method"]) && $_GET["method"]=="get_corporate_thai"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = get_corporate_thai($post);
    echo $response;
exit();
}

function get_corporate_thai($post){
  global $emp_id;
  global $emp_section;
  include("../../../config/config.php");

  $caseCh_arr = array();
  $sql_caseCh = "SELECT `cpr_id`, `cpr_section`, `cpr_type`, `cpr_comp_type`, `cpr_numbertrade`, `cpr_companyname`, `cpr_type_import_export`
                  , `cpr_branch`, `cpr_telephone`, `cpr_web`, `cpr_email`, `cpr_address`, cp.prov_id , `cpr_zipcode`, `cpr_department`
                  , `cpr_contactfname`, `cpr_contactlname`, `Country_id`, `cpr_contact_person`, `cpr_import`, `cpr_create_datetime`
                  , `cpr_createBy_id`, `cpr_update_datetime`, `cpr_updateBy_id`, `cpr_status` ,pv.prov_name 
                  , IF(reliable!=0, reliable, cpr_reliable) AS reliable, c.complnt_name ";
  $sql_caseCh .= " FROM Corporate AS cp
                    LEFT JOIN `Case` AS c on cp.cpr_companyname = c.complnt_name
                    LEFT JOIN Province AS pv on  cp.prov_id = pv.prov_id  
                    WHERE cpr_status = '0' AND cpr_type = '1' AND cpr_section='$emp_section' ";
   if($post->sort=="id"){
     $sort_col = "cpr_id";
   }
  if($post->sort=="number"){
    $sort_col = "cpr_numbertrade";
  }
  if($post->sort == "name"){
      $sort_col = "cpr_companyname";
  }
  if($post->sort == "offset"){
      $sort_col = "cpr_branch";
  }
  if($post->sort == "tel"){
      $sort_col = "cpr_telephone";
  }
  if($post->sort == "web"){
      $sort_col = "cpr_web";
  }
  if($post->sort == "address"){
      $sort_col = "cpr_address";
  }
  if($post->sort == "prov"){
      $sort_col = "pv.prov_name";
  }
  if($post->sort == "code"){
      $sort_col = "cpr_zipcode";
  }
  if($post->sort == "depart"){
      $sort_col = "cpr_department";
  }
  if($post->sort == "contact"){
      $sort_col = "cpr_contact_person";
  }
  if($post->sort == "cpr_type"){
      $sort_col = "cpr_type_import_export";
  }

  if($post->text != ""){
    $sql_caseCh .= "  AND ( cpr_numbertrade LIKE '%".$post->text."%'
                            or cpr_companyname LIKE '%".$post->text."%'
                            or cpr_branch LIKE '%".$post->text."%'
                            or cpr_telephone LIKE '%".$post->text."%'
                            or cpr_web LIKE '%".$post->text."%'
                            or cpr_address LIKE '%".$post->text."%'
                            or pv.prov_name LIKE '%".$post->text."%'
                            or cpr_zipcode LIKE '%".$post->text."%'
                            or cpr_department LIKE '%".$post->text."%'
                            or cpr_contact_person LIKE '%".$post->text."%'
                          )";
                        }
                        
  $sql_caseCh .= " GROUP BY cp.cpr_companyname ";
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
    //  echo $sql_caseCh;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $cpr_numbertrade = preg_replace('/[^0-9]/', '', $re['cpr_numbertrade']);
       $cpr_numbertrade = ($re["cpr_numbertrade"]==""?'-':$cpr_numbertrade);

       $caseCh_col_arr["number"] = '<span class="txt_nol">'.$cpr_numbertrade.'</span>';

       if($re['cpr_companyname']==''){
         $cpr_companyname = '-';
       }else{
         $cpr_companyname = $re['cpr_companyname'];
       }
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_corporate('.$re['cpr_id'].',1,0);">'.$cpr_companyname.'</span>';
       $cpr_branch= ($re["cpr_branch"]==""?'-':$re['cpr_branch']);
       $caseCh_col_arr["offset"] = '<span class="txt_nol">'.$cpr_branch.'</span>';
       $cpr_telephone = preg_replace('/[^0-9]/', '', $re['cpr_telephone']);
       $caseCh_col_arr["tel"] = '<span class="txt_nol">'.$cpr_telephone.'</span>';
       $cpr_web = ($re["cpr_web"]==""?'-':$re['cpr_web']);
       $cpr_web = ($re["cpr_web"]==""?'-':$re['cpr_web']);
       $caseCh_col_arr["web"] = '<span class="txt_nol">'.$cpr_web.'</span>';
       $caseCh_col_arr["address"] = '<span class="txt_nol">'.$re['cpr_address'].'</span>';
       $prov_name = ($re["prov_id"]=="0"?'-':$re['prov_name']);
       $caseCh_col_arr["prov"] = '<span class="txt_nol">'.$prov_name.'</span>';
       $cpr_zipcode = ($re["cpr_zipcode"]==""?'-':$re['cpr_zipcode']);

       $caseCh_col_arr["code"] = '<span class="txt_nol">'.$cpr_zipcode.'</span>';
       if($re['cpr_department'] == '1'){
         $cpr_department = '<span class="txt_nol">เป็นสมาชิกกรม</span>';
       }else{
         $cpr_department = '<span class="txt_nol">ไม่เป็นสมาชิกกรม</span>';
       }
       $caseCh_col_arr["depart"] = $cpr_department;
       $cpr_contact_person = ($re["cpr_contact_person"]==""?'-':$re['cpr_contact_person']);
       $caseCh_col_arr["contact"] =  '<span class="txt_nol">'.$cpr_contact_person.'</span>';
       if($re['cpr_type_import_export'] == '1'){
         $cpr_type = "นำเข้า";
       }else if($re['cpr_type_import_export'] == '2'){
         $cpr_type = "ส่งออก";
       }else{
         $cpr_type =  "อื่นๆ";
       }
      $caseCh_col_arr["cpr_type"] =  '<span class="txt_nol">'.$cpr_type.'</span>';
      $reliable = '';
       if($re['reliable'] == 1){
        $reliable = 'Watchlist';
       } elseif($re['reliable'] == 2){
        $reliable = 'Blacklist';
       } else{
        $reliable = 'ไม่มีสถานะ';
       }

       $caseCh_col_arr["reliable"] =  '<span class="txt_nol">'.$reliable.'</span>';
      $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_corporate('.$re['cpr_id'].',1,1);"></span>
              <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_corporate('.$re['cpr_id'].');"></span></div>';
      $caseCh_col_arr["del"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}



if(isset($_GET["method"]) && $_GET["method"]=="save_corporate_thai"){

  $numbertrade = data_filter(trim($_POST['numbertrade']));
  $companyname = data_filter(trim($_POST['companyname']));
  $branch = data_filter(trim($_POST['branch']));
  $telephone = data_filter(trim($_POST['telephone']));
  $web = data_filter(trim($_POST['web']));
  $email = data_filter(trim($_POST['email']));
  $address = data_filter(trim($_POST['address']));
  $prov = data_filter(trim($_POST['prov']));
  $zipcode = data_filter(trim($_POST['zipcode']));
  $department = data_filter(trim($_POST['department']));
  $contactfname = data_filter(trim($_POST['contactfname']));
  $business_type = data_filter(trim($_POST['business_type']));
  $type_section = data_filter(trim($_POST['type_section']));

  //$contactlname = data_filter(trim($_POST['contactlname']));
  $id_ch = data_filter(trim($_POST['id_ch']));



            if($id_ch == ''){
                $sql_select = "SELECT cpr_numbertrade  FROM  Corporate where cpr_numbertrade = '".$numbertrade."' AND cpr_status = '0' AND cpr_type ='1' AND cpr_numbertrade !='' ";
                $query_select = $conn->query($sql_select);
                $array_row = array();
                if ($query_select->num_rows >0) {
                  ?><script type="text/javascript">parent.iziToast_func.alert('หมายเลขทะเบียนการค้ามีอยู่ในระบบแล้ว กรุณากรอกหมายเลขทะเบียนการค้าใหม่');</script><?php
                  exit();
                }
            }else{
              $sql_select = "SELECT cpr_numbertrade  FROM  Corporate where cpr_numbertrade = '".$numbertrade."' AND cpr_status = '0' AND cpr_type ='1'  AND cpr_id != $id_ch AND cpr_numbertrade !=''";
              $query_select = $conn->query($sql_select);
              $array_row = array();
              if ($query_select->num_rows >0) {
                ?><script type="text/javascript">parent.iziToast_func.alert('หมายเลขทะเบียนการค้ามีอยู่ในระบบแล้ว กรุณากรอกหมายเลขทะเบียนการค้าใหม่');</script><?php
                exit();
              }
            }

          if ($companyname == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อบริษัทที่จดทะเบียน');</script><?php
            exit();
          }
          if($id_ch == ''){
              $sql_select = " SELECT cpr_companyname  FROM  Corporate where cpr_companyname = '$companyname' AND cpr_status = '0' AND cpr_type ='1' AND cpr_numbertrade = '' ";
              $query_select = $conn->query($sql_select);
              $array_row = array();
              if ($query_select->num_rows >0) {
                ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อบริษัทที่จดทะเบียน มีอยู่ในระบบแล้ว กรุณากรอกชื่อบริษัทใหม่');</script><?php
                exit();
              }
          }else{
            $sql_select = " SELECT cpr_companyname  FROM  Corporate where ct_firstname = '$companyname' AND cpr_numbertrade = ''
                            AND cpr_status = '0' AND cpr_type ='1' AND cpr_id != $id_ch";
            $query_select = $conn->query($sql_select);
            $array_row = array();
            if ($query_select->num_rows >0) {
              ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อบริษัทที่จดทะเบียน มีอยู่ในระบบแล้ว กรุณากรอกชื่อบริษัทใหม่');</script><?php
              exit();
            }
          }

          if ($telephone== '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกเบอร์โทรศัพท์');</script><?php
            exit();
          }
          if ($email == '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกอีเมล');</script><?php
            exit();
          }
          if ($address== '' ){
            ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกที่อยู่');</script><?php
            exit();
          }
          if($id_ch == ''){
              $sql_add = "INSERT INTO Corporate (`cpr_section`, `cpr_type`, `cpr_numbertrade`, `cpr_companyname`, `cpr_branch`, `cpr_telephone`, `cpr_web`, `cpr_email`, `cpr_address`,
                                                `prov_id`, `cpr_zipcode`, `cpr_department`, `cpr_contact_person`,cpr_create_datetime,cpr_createBy_id,cpr_type_import_export)
              VALUES ('$emp_section','1','$numbertrade','$companyname','$branch','$telephone','$web','$email','$address','$prov','$zipcode','$department','$contactfname','$date_setting','$emp_id','$business_type')";
              $query_add = $conn->query($sql_add);
          }else{
            $sql_edit = "    UPDATE `Corporate` SET
                                    `cpr_companyname`='$companyname'
                                    ,`cpr_branch`= '$branch'
                                    ,`cpr_telephone`= '$telephone'
                                    ,`cpr_web`= '$web'
                                    ,`cpr_email`= '$email'
                                    ,`cpr_address`= '$address'
                                    ,`prov_id`= '$prov'
                                    ,`cpr_zipcode`= '$zipcode'
                                    ,`cpr_department`= '$department'
                                    ,`cpr_contact_person`= '$contactfname'
                                    ,cpr_update_datetime =  '$date_setting'
                                    ,cpr_updateBy_id = '$emp_id'
                                    ,cpr_import = '0'
                                    ,cpr_type_import_export = '$business_type'
                          where  cpr_id = '$id_ch'";
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



if ($_POST['method']=="corporate"){
  include("../../../config/config.php");
    $id = data_filter(trim($_POST['id']));
  $sql_select = " SELECT  *  FROM Corporate where cpr_id = '$id' ";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['cpr_type']=$result_select['cpr_type'];
          $array_row['cpr_numbertrade']=$result_select['cpr_numbertrade'];
          $array_row['cpr_companyname']=$result_select['cpr_companyname'];
          $array_row['cpr_telephone']=$result_select['cpr_telephone'];
          $array_row['cpr_branch']=$result_select['cpr_branch'];
          $array_row['cpr_web']=$result_select['cpr_web'];
          $array_row['cpr_email']=$result_select['cpr_email'];
          $array_row['cpr_address']=$result_select['cpr_address'];
          $array_row['prov_id']=$result_select['prov_id'];
          $array_row['cpr_zipcode']=$result_select['cpr_zipcode'];
          $array_row['cpr_department']=$result_select['cpr_department'];
          $array_row['cpr_contactfname']=$result_select['cpr_contactfname'];
          $array_row['Country_id']=$result_select['Country_id'];
          $array_row['cpr_contact_person']=$result_select['cpr_contact_person'];
          $array_row['cpr_type_import_export']=$result_select['cpr_type_import_export'];

        }
      }
      echo json_encode($array_row);
      exit();
 }


 if ($_POST['method']=="del_corporate"){
   $cpr = data_filter(trim($_POST['cpr_id']));
    $sql_del = "UPDATE   Corporate SET cpr_status = '1' WHERE  cpr_id = '$cpr'";
     $query_del = $conn->query($sql_del);
     if ($query_del){
         echo '1';
     }else {
         echo "0";
     }
     exit();
 }



 if(isset($_GET["method"]) && $_GET["method"]=="import_corporate_thai"){

 // exit();

 //   if (!is_dir("../../../data/setting")){
 //         mkdir("../../../data/setting", 0775, true);
 //   }
 //   if (!is_dir("../../../data/setting/template")){
 //       mkdir("../../../data/setting/template", 0775, true);
 //   }
 //   $AA = 'Template_People_thailand.xlsx';
 //   move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../../data/setting/template/". $AA);
 //
 //
 // exit();

   if (!is_dir("../../../data/setting")){
         mkdir("../../../data/setting", 0775, true);
   }
   if (!is_dir("../../../data/setting/import_corporate")){
       mkdir("../../../data/setting/import_corporate", 0775, true);
   }

     if($_FILES["userimport"]["size"]) {
       $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
       move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../../data/setting/import_corporate/".$new_excel);
       $inputFileName = "../../../data/setting/import_corporate/".$new_excel;

       ?><script type="text/javascript">top.import_corporate_thai('<?= $inputFileName ?>');</script><?php
     }
     else {
        ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
       exit();
     }
 }



 if(isset($_GET["method"]) && $_GET["method"]=="get_corporate_inter"){
     $post = array();
     $request_body = file_get_contents('php://input');
     $post = json_decode($request_body);
     $response = get_corporate_inter($post);
     echo $response;
 exit();
 }

 function get_corporate_inter($post){

   global $emp_id;
   global $emp_section;

    include("../../../config/config.php");

    $caseCh_arr = array();
    $sql_caseCh = "SELECT cpr_id, cpr_section, cpr_type, cpr_comp_type, cpr_numbertrade, cpr_companyname, cpr_type_import_export, cpr_branch, cpr_telephone, 
    cpr_email, cpr_address, prov_id, cpr_zipcode, cpr_department, cpr_contactfname, cpr_contactlname, Country_id, cpr_contact_person, cpr_import, 
    cpr_create_datetime, cpr_createBy_id, cpr_update_datetime, cpr_updateBy_id, cpr_status, cpr_web, IF(reliable!=0, reliable, cpr_reliable) AS reliable
    , c.complnt_name, ct.id, ct.continent_code, ct.name_th, ct.name, ct.img_name, ct.img_path, ct.country_enable, ct.country_status, ct.flag_32, ct.flag_128";
    $sql_caseCh .= " FROM Corporate AS cp
    LEFT JOIN `Case` AS c on c.complnt_name = cp.cpr_companyname
    LEFT JOIN Country AS ct on ct.id = cp.Country_id WHERE cpr_status = '0' AND cpr_type = '2'  AND cpr_section='$emp_section' ";
  if($post->sort=="id"){
    $sort_col = "cpr_id";
  }
   if($post->sort=="number"){
     $sort_col = "cpr_numbertrade";
   }
   if($post->sort == "name"){
       $sort_col = "cpr_companyname";
   }
   if($post->sort == "offset"){
       $sort_col = "cpr_branch";
   }
   if($post->sort == "tel"){
       $sort_col = "cpr_telephone";
   }
   if($post->sort == "web"){
       $sort_col = "cpr_web";
   }
   if($post->sort == "address"){
       $sort_col = "cpr_address";
   }
   if($post->sort == "prov"){
       $sort_col = "name";
   }
   if($post->sort == "code"){
       $sort_col = "cpr_zipcode";
   }
   if($post->sort == "depart"){
       $sort_col = "cpr_department";
   }
   if($post->sort == "contact"){
       $sort_col = "cpr_contact_person";
   }
   if($post->sort == "cpr_type"){
       $sort_col = "cpr_type_import_export";
   }

   if($post->text != ""){
     $sql_caseCh .= "  AND ( cpr_numbertrade LIKE '%".$post->text."%'
                             or cpr_companyname LIKE '%".$post->text."%'
                             or cpr_branch LIKE '%".$post->text."%'
                             or cpr_telephone LIKE '%".$post->text."%'
                             or cpr_web LIKE '%".$post->text."%'
                             or cpr_address LIKE '%".$post->text."%'
                             or cpr_zipcode LIKE '%".$post->text."%'
                             or cpr_department LIKE '%".$post->text."%'
                             or cpr_contactfname LIKE '%".$post->text."%'
                           )";
                         }

  $sql_caseCh .= " GROUP BY cp.cpr_companyname ";
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      // echo $sql_caseCh;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $cpr_numbertrade = preg_replace('/[^0-9]/', '', $re['cpr_numbertrade']);
        $cpr_numbertrade = ($re["cpr_numbertrade"]==""?'-':$cpr_numbertrade);
        $cpr_branch = ($re["cpr_branch"]==""?'-':$re['cpr_branch']);
        $caseCh_col_arr["offset"] = '<span class="txt_nol">'.$cpr_branch.'</span>';
        $cpr_telephone = preg_replace('/[^0-9]/', '', $re['cpr_telephone']);
        $caseCh_col_arr["tel"] = '<span class="txt_nol">'.$cpr_telephone.'</span>';
        $cpr_web = ($re["cpr_web"]==""?'-':$re['cpr_web']);
        $caseCh_col_arr["web"] = '<span class="txt_nol">'.$cpr_web.'</span>';
        $caseCh_col_arr["address"] = '<span class="txt_nol">'.$re['cpr_address'].'</span>';



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



        $name = ($re["name"]==""?'-':$re['name']);
        $caseCh_col_arr["prov"] = '<div>'.$pic.'<span class="txt_nol">'.$name.'</span></div>';
        $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_corporate('.$re['cpr_id'].',2,0);">'.$re['cpr_companyname'].'</span>';
        $caseCh_col_arr["code"] = '<span class="txt_nol">'.$re['cpr_zipcode'].'</span>';
        if($re['cpr_department'] == '1'){
          $cpr_department = '<span class="txt_nol">เป็นสมาชิกกรม</span>';
        }else{
          $cpr_department = '<span class="txt_nol">ไม่เป็นสมาชิกกรม</span>';
        }
        $caseCh_col_arr["depart"] = $cpr_department;
        $cpr_contact_person = ($re["cpr_contact_person"]==""?'-':$re['cpr_contact_person']);

        $caseCh_col_arr["contact"] =  '<span class="txt_nol">'.$cpr_contact_person.'</span>';
        if($re['cpr_type_import_export'] == '1'){
          $cpr_type = "นำเข้า";
        }else if($re['cpr_type_import_export'] == '2'){
          $cpr_type = "ส่งออก";
        }else{
          $cpr_type =  "อื่นๆ";
        }
       $caseCh_col_arr["cpr_type"] =  '<span class="txt_nol">'.$cpr_type.'</span>';

       $reliable = '';
       if($re['reliable'] == 1){
        $reliable = 'Watchlist';
       } elseif($re['reliable'] == 2){
        $reliable = 'Blacklist';
       } else{
        $reliable = 'ไม่มีสถานะ';
       }

       $caseCh_col_arr["reliable"] =  '<span class="txt_nol">'.$reliable.'</span>';
       $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_corporate('.$re['cpr_id'].',2,1);"></span>
               <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_corporate('.$re['cpr_id'].');"></span></div>';
       $caseCh_col_arr["del"] = $del;
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }



 if(isset($_GET["method"]) && $_GET["method"]=="save_corporate_inter"){

   $numbertrade = data_filter(trim($_POST['numbertrade']));
   $companyname = data_filter(trim($_POST['companyname']));
   $branch = data_filter(trim($_POST['branch']));
   $contact_person = data_filter(trim($_POST['contact_person']));
   $telephone = data_filter(trim($_POST['telephone']));
   $web = data_filter(trim($_POST['web']));
   $email = data_filter(trim($_POST['email']));
   $address = data_filter(trim($_POST['address']));
   $Country = data_filter(trim($_POST['Country_id']));
   $contactfname = data_filter(trim($_POST['contactfname']));
   $contactlname = data_filter(trim($_POST['contactlname']));
   $business_type = data_filter(trim($_POST['business_type']));
   $id_ch = data_filter(trim($_POST['id_ch']));


           if($id_ch == ''){
               $sql_select = "SELECT cpr_numbertrade  FROM  Corporate where cpr_numbertrade = '".$numbertrade."' AND cpr_status = '0' AND cpr_type ='2' AND cpr_numbertrade !='' ";
               $query_select = $conn->query($sql_select);
               $array_row = array();
               if ($query_select->num_rows >0) {
                 ?><script type="text/javascript">parent.iziToast_func.alert('หมายเลขทะเบียนการค้ามีอยู่ในระบบแล้ว กรุณากรอกหมายเลขทะเบียนการค้าใหม่');</script><?php
                 exit();
               }
           }else{
             $sql_select = "SELECT cpr_numbertrade  FROM  Corporate where cpr_numbertrade = '".$numbertrade."' AND cpr_status = '0' AND cpr_type ='2'  AND cpr_id != $id_ch AND cpr_numbertrade !=''";
             $query_select = $conn->query($sql_select);
             $array_row = array();
             if ($query_select->num_rows >0) {
               ?><script type="text/javascript">parent.iziToast_func.alert('หมายเลขทะเบียนการค้ามีอยู่ในระบบแล้ว กรุณากรอกหมายเลขทะเบียนการค้าใหม่');</script><?php
               exit();
             }
           }

            if($id_ch == ''){
              if ($companyname== '' ){
                ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อบริษัท');</script><?php
                exit();
              }
            }

            if($id_ch == ''){
                $sql_select = " SELECT cpr_companyname  FROM  Corporate where cpr_companyname = '$companyname' AND cpr_status = '0' AND cpr_type ='2' AND cpr_numbertrade = '' ";
                $query_select = $conn->query($sql_select);
                $array_row = array();
                if ($query_select->num_rows >0) {
                  ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อบริษัทที่จดทะเบียน มีอยู่ในระบบแล้ว กรุณากรอกชื่อบริษัทใหม่');</script><?php
                  exit();
                }
            }else{
              $sql_select = " SELECT cpr_companyname  FROM  Corporate where ct_firstname = '$companyname' AND cpr_numbertrade = ''
                              AND cpr_status = '0' AND cpr_type ='2' AND cpr_id != $id_ch";
              $query_select = $conn->query($sql_select);
              $array_row = array();
              if ($query_select->num_rows >0) {
                ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อบริษัทที่จดทะเบียน มีอยู่ในระบบแล้ว กรุณากรอกชื่อบริษัทใหม่');</script><?php
                exit();
              }
            }


           if ($telephone== '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกเบอร์โทรศัพท์');</script><?php
             exit();
           }
           if ($email == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกอีเมล');</script><?php
             exit();
           }
           if ($address == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกที่อยู่');</script><?php
             exit();
           }
           if ($Country == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเทศ');</script><?php
             exit();
           }
           if ($business_type == '' ){
             ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเภทธุรกิจ');</script><?php
             exit();
           }

           if($id_ch == ''){

               $sql_add = "INSERT INTO Corporate (`cpr_type`, `cpr_numbertrade`, `cpr_companyname`, `cpr_branch`, `cpr_telephone`, `cpr_email`, `cpr_address`,
                                                 `Country_id`, cpr_contact_person,cpr_web,cpr_create_datetime,cpr_createBy_id,cpr_type_import_export,cpr_section)
               VALUES ('2','$numbertrade','$companyname','$branch','$telephone','$email','$address','$Country','$contact_person','$web','$date_setting','$emp_id','$business_type','$emp_section')";
               $query_add = $conn->query($sql_add);
           }else{

             $sql_edit = "    UPDATE `Corporate` SET
                                     `cpr_numbertrade`='$numbertrade'
                                     ,`cpr_branch`= '$branch'
                                     ,`cpr_telephone`= '$telephone'
                                     ,`cpr_email`= '$email'
                                     , cpr_address = '$address'
                                     ,`Country_id`= '$Country'
                                     ,`cpr_contactfname`= '$contactfname'
                                     ,cpr_contact_person = '$contact_person'
                                     ,cpr_web = '$web'
                                     ,cpr_update_datetime =  '$date_setting'
                                     ,cpr_updateBy_id = '$emp_id'
                                     ,cpr_import = '0'
                                     ,cpr_type_import_export= '$business_type'
                           where  cpr_id = '$id_ch'";
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

  if(isset($_GET["method"]) && $_GET["method"]=="import_corporate_inter"){

    if (!is_dir("../../../data/setting")){
          mkdir("../../../data/setting", 0775, true);
    }
    if (!is_dir("../../../data/setting/import_corporate")){
        mkdir("../../../data/setting/import_corporate", 0775, true);
    }
      if($_FILES["userimport"]["size"]) {
        $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
        move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../../data/setting/import_corporate/".$new_excel);
        $inputFileName = "../../../data/setting/import_corporate/".$new_excel;
        ?><script type="text/javascript">top.import_corporate_inter('<?= $inputFileName ?>');</script><?php
      }else{
         ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
        exit();
      }
  }



?>
