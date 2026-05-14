<?php
include("../../config/config.php");
include("../class/main.class.php");
include("../class/employee.class.php");

$member_cls = new member_base();

 $date_setting = date("Y-m-d h:i:sa");
 $emp_id = $_SESSION["admin"]["empId"];

if(isset($_GET["method"]) && $_GET["method"]=="add_channel"){
 	 include("../../config/config.php");

    $add_name = data_filter(trim($_POST['add_name']));
    $radio_ststus = data_filter(trim($_POST['radio_ststus']));
    $id_edit = data_filter(trim($_POST['id_edit']));
    $radio_section = data_filter(trim($_POST['radio_section']));


   if($add_name == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อ');</script><?php
     exit();
   }
   if($id_edit==''){

     if($_POST['id_channel']==''){
       $level = '0';
       $caseCh_level = 1;

     }else{
       $level = $_POST['id_channel'];
       $caseCh_level = 2 ;
     }

     $sql_add_pass = " INSERT INTO Case_Channel  (caseCh_name,caseCh_enable,caseCh_create_datetime,caseCh_createBy_id,caseCh_section,caseCh_type,caseCh_ref_id,caseCh_level)
                        VALUES ('$add_name', '$radio_ststus','$date_setting','$emp_id','$radio_section','2','$level','$caseCh_level') ";
      $query_add_pass = $conn->query($sql_add_pass);
   }else{
    $sql_edit_pass = "UPDATE  Case_Channel SET
                             caseCh_name = '$add_name'
                             ,caseCh_enable   = '$radio_ststus'
                             ,caseCh_update_datetime = '$date_setting'
                             ,caseCh_updateBy_id = '$emp_id'
                             ,caseCh_section = '$radio_section'
                             where  caseCh_id = '$id_edit' ";
      $query_edit_pass = $conn->query($sql_edit_pass);
   }
    if($query_add_pass || $query_edit_pass){
      if($query_add_pass){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        exit();
      }else{
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        exit();
      }
    }
    if (trim($_POST['form_set']) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
        exit();
    }
 }


 if ($_POST['method']=="get_data_channel"){
    include("../../config/config.php");

    		$sql_select = "SELECT * FROM Case_Channel where caseCh_id = '".$_POST['id']."'";
    		$query_select = $conn->query($sql_select);
    		$array_row = array();
    		if ($query_select->num_rows >0)
    		{
    			while($result_select = $query_select->fetch_assoc())
    			{
    				$array_row['caseCh_name']=$result_select['caseCh_name'];
            $array_row['caseCh_enable']=$result_select['caseCh_enable'];
    				$array_row['caseCh_section']=$result_select['caseCh_section'];
          }
        }
        echo json_encode($array_row);
        exit();
 }

 if ($_POST['method']=="changestatus_chanel"){
  include("../../config/config.php");
  $sql_ch_pass = "UPDATE  Case_Channel SET caseCh_enable  = '".$_POST['change_val']."' WHERE  caseCh_id = '".$_POST['change_id']."'";
   $query_ch_pass = $conn->query($sql_ch_pass);
   if ($query_ch_pass){
       echo '11';
   }else {
       echo "01";
   }
   exit();
}


if ($_POST['method']=="del_channel"){
   include("../../config/config.php");
   $sql_edit_pass = "UPDATE  Case_Channel SET caseCh_status = '1' WHERE  caseCh_id = '".$_POST['del_id']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
        echo '11';
    }else {
        echo "01";
    }
    exit();
}


if(isset($_GET["method"]) && $_GET["method"]=="getchannel"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getchannel($post);
    echo $response;
exit();

}


function getchannel($post){
   include("../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT *  ";
   $sql_caseCh .= "FROM Case_Channel WHERE caseCh_status = '0'  AND caseCh_section !=0 ";


   if($post->id_channel != ""){
     $sql_caseCh .= "AND caseCh_ref_id = ".$post->id_channel." AND caseCh_ref_id != '0' AND  caseCh_level = '2' ";
   }else {
     $sql_caseCh .= " AND caseCh_ref_id = '0' AND caseCh_level = '1' ";
   }
   if($post->text != ""){
     $sql_caseCh .= "AND caseCh_name LIKE '%".$post->text."%' ";
   }
   if($post->status_m != ""){
     $sql_caseCh .= " AND caseCh_section  = '$post->status_m' ";
   }
   if($post->sort=="id"){
     $sort_col = "caseCh_id";
   }
   if($post->sort=="type"){
     $sort_col = "caseCh_section";
   }
   if($post->sort=="view"){
     $sort_col = "caseCh_enable";
   }

  if($post->sort=="name"){
    $sort_col = "caseCh_name";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0 + $post->offset ;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';

       if($post->id_channel == ""){
          $sql_ch = "  SELECT caseCh_ref_id FROM `Case_Channel`  WHERE `caseCh_ref_id` =  '".$re['caseCh_id']."' AND caseCh_status =  0 ";
        }else{
           $sql_ch = "  SELECT caseCh_id FROM `Case`  WHERE `caseCh_id` =  '".$re['caseCh_id']."'  ";
        }

       $query_ch = $conn->query($sql_ch);
       if($query_ch->num_rows > 0){
         $edit = '0';
         $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_channel('.$re['caseCh_id'].',1);"></span>
                  <span class="icon-ico-ditp-28 txt_no_edit"></span>';

       }else{
          // if($post->id_channel == ""){
          //    $sql_ch = "  SELECT caseCh_id FROM `Case`  WHERE `caseCh_id` =  '".$re['caseCh_id']."' ";
          //    $query_ch = $conn->query($sql_ch);
          //    if($query_ch->num_rows > 0){
          //      $edit = '0';
          //      $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_channel('.$re['caseCh_id'].',1);"></span>
          //               <span class="icon-ico-ditp-28 txt_no_edit"></span>';
          //     }else{
          //       $edit = '1';
          //       $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_channel('.$re['caseCh_id'].',2);"></span>
          //              <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_channel('.$re['caseCh_id'].');"></span>';
          //
          //     }
          // }else{
            $edit = '1';
            $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_channel('.$re['caseCh_id'].',2);"></span>
                   <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_channel('.$re['caseCh_id'].');"></span>';

          // }

        }

        if($post->id_channel == ""){
          $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_channel('.$re['caseCh_id'].',0);">'.$re['caseCh_name'].'</span>';
        }else {
          $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_channel('.$re['caseCh_id'].',0);">'.$re['caseCh_name'].'</span>';
        }

         if($re['caseCh_enable'] == '1'){
           $view ='<span onclick="changestatus_chanel(0,'.$re['caseCh_id'].')" class="icon-ico-ditp-12 view_1 cursor">';
         }else{
           $view ='<span onclick="changestatus_chanel(1,'.$re['caseCh_id'].')" class="icon-ico-ditp-13  view_2 cursor">';
         }
       if($re['caseCh_section'] == '1'){
         $type='<span class="type_general">สสบ.</span>';
       }else{
         $type ='<span class="type_law">นิติการ</span>';
       }

      $caseCh_col_arr["detail_view"] = '<a href="?page=channel_detail&id_channel='.$re['caseCh_id'].'"><i class="fa fa-list txt_no_edit_non"></i></a>';
      $caseCh_col_arr["type"] = $type;
      $caseCh_col_arr["view"] = $view;
      $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}


if(isset($_GET["method"]) && $_GET["method"]=="getproduct"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getproduct($post);
    echo $response;
exit();
}

function getproduct($post){
   include("../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT *  ";
   $sql_caseCh .= "FROM Product_Type WHERE prodType_status = '0' AND prodType_level = 1  ";

   if($post->text != ""){
     $sql_caseCh .= " AND (
                           prodType_name LIKE '%".$post->text."%'
                           or prodType_name_en LIKE '%".$post->text."%'
                           ) ";
   }
   if($post->sort=="id"){
     $sort_col = "prodType_id";
   }
  if($post->sort=="name"){
    $sort_col = "prodType_name";
  }
  if($post->sort=="name_en"){
    $sort_col = "prodType_name_en";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0+$post->offset ;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name'].'</span>';
       if($re['prodType_name_en']!=''){
         $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name_en'].'</span>';
       }else{
         $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">-</span>';
       }
         if($re['prodType_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }
           $caseCh_col_arr["view"] = $view;

      if($re['prodType_other_flag']==0){
        $caseCh_col_arr["detail_view"] = '<a href="?page=product_detail&id_product='.$re['prodType_id'].'&lv_product=2"><i class="fa fa-list txt_no_edit_non"></i></a>';
      }
       $sql_sub = " SELECT * FROM Product_Type  WHERE prodType_ref_id = '".$re['prodType_id']."'
                    AND prodType_level = 2 AND prodType_status = 0 ";
       $query_sub = $conn->query($sql_sub);
       if($query_sub->num_rows > 0){
         $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product('.$re['prodType_id'].',1);">
                  </span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
       }else{
         $del = ' <span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product('.$re['prodType_id'].',2);"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_product('.$re['prodType_id'].');"></span>';
       }

       $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}

if(isset($_GET["method"]) && $_GET["method"]=="add_product"){
    include("../../config/config.php");

  if (trim($_POST['add_name']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (ไทย)');</script><?php
    exit();
  }

  if (trim($_POST['add_name_en']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (Eng)');</script><?php
    exit();
  }


  $sql_ch = " SELECT * FROM `Product_Type`
              WHERE `office_id` = '0'
                    AND `prodType_name` = '".trim($_POST['add_name'])."'
                    AND `prodType_level` = 1
                    AND `prodType_status` = 0";
  $query_ch = $conn->query($sql_ch);
  if ($query_ch->num_rows >0)
  {
    ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อสินค้ามีอยู่ในระบบแล้วกรุณากรอกชื่ออื่น');</script><?php
    exit();
  }

  if ($_POST['radio_url_cms'] == 1){
      $prodType_enable = '1';
  }else{
      $prodType_enable = '0';
  }

    $sql_edit_pass = "  INSERT INTO Product_Type  (prodType_name,prodType_name_en,prodType_level,prodType_enable,prodType_create_datetime,prodType_createBy_id,prodType_other_flag,office_id)
                        VALUES ('".trim($_POST['add_name'])."','".trim($_POST['add_name_en'])."', 1, '$prodType_enable','$date_setting','$emp_id','".$_POST['ra_other']."','".$_POST['office_name']."') ";
   $query_edit_pass = $conn->query($sql_edit_pass);
   if ($query_edit_pass){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else {
     ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();

}

if ($_POST['method']=="get_data_prouuct"){
   include("../../config/config.php");

       $sql_select = "SELECT prodType_name , prodType_name_en , prodType_enable,prodType_other_flag,office_id  FROM Product_Type where prodType_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['name']=$result_select['prodType_name'];
           $array_row['name_en']=$result_select['prodType_name_en'];
           $array_row['enable']=$result_select['prodType_enable'];
           $array_row['office_id']=$result_select['office_id'];
           $array_row['prodType_other_flag']=$result_select['prodType_other_flag'];
         }
       }
       echo json_encode($array_row);
       exit();
}

if ($_GET['method']=="save_product"){
   include("../../config/config.php");
   if (trim($_POST['edit_name']) == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (ไทย)');</script><?php
     exit();
   }
   if (trim($_POST['edit_name_en']) == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (Eng)');</script><?php
     exit();
   }

   if($_POST['id_edit']!=''){
     $ch_name  =   "  AND prodType_id != '".$_POST['id_edit']."' ";
   }

   $sql_ch = "  SELECT * FROM `Product_Type`
                WHERE `prodType_name` = '".trim($_POST['edit_name'])."'
                AND `prodType_level` = 1
                AND `prodType_status` = 0  $ch_name ";
   $query_ch = $conn->query($sql_ch);
   if ($query_ch->num_rows >0)
   {
     ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อสินค้ามีอยู่ในระบบแล้วกรุณากรอกชื่ออื่น');</script><?php
     exit();
   }


   if ($_POST['radio_url_cms'] == 1){
       $prodType_status = '1';
   }else{
       $prodType_status = '0';
   }
       $sql_edit_pass = "UPDATE  Product_Type SET
                                prodType_name = '".trim($_POST['edit_name'])."'
                                ,prodType_name_en = '".trim($_POST['edit_name_en'])."'
                                ,prodType_level   = '1'
                                ,prodType_enable   = '$prodType_status'
                                ,prodType_update_datetime = '$date_setting'
                                ,prodType_updateBy_idateBy_id = '$emp_id'
                                ,prodType_other_flag = '".$_POST['ra_edit_other']."'
                                ,office_id = '".$_POST['office_name']."'
                               where  prodType_id = '".$_POST['id_edit']."'";
        $query_edit_pass = $conn->query($sql_edit_pass);




        if ($query_edit_pass){
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        }else {
          ?><script type="text/javascript">parent.iziToast_func.alert('แก้ไขข้อมูลผิดพลาด');</script><?php
        }
        exit();
}


if ($_POST['method']=="del_product"){
   include("../../config/config.php");

  $sql_edit_prod= "UPDATE  Product_Type SET prodType_status = '1' where  prodType_id = '".$_POST['id_p']."'";
  $query_edit_prod= $conn->query($sql_edit_prod);
  if ($query_edit_prod){
        echo '11';
  }else{
      echo "01";
  }
  exit();
}




 if(isset($_GET["method"]) && $_GET["method"]=="getproduct_detail"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getproduct_detail($post);
    echo $response;
 exit();
 }

 function getproduct_detail($post){
    include("../../config/config.php");
    $lv_product ='';
    $caseCh_arr = array();

    $sql_caseCh = " SELECT * FROM Product_Type as a
                    LEFT JOIN office_type as b on (a.office_id = b.office_id)
                    WHERE  prodType_ref_id =  '".$post->id_product."'
                    AND prodType_status = '0'
                    AND prodType_level = '$post->lv_product' ";

    if($post->text != ""){
      $sql_caseCh .= " AND (
                            prodType_name LIKE '%".$post->text."%'
                            or prodType_name_en LIKE '%".$post->text."%'
                            ) ";
    }
    if($post->sort=="id"){
      $sort_col = "prodType_id";
    }
   if($post->sort=="name"){
     $sort_col = "prodType_name";
   }
   if($post->sort=="name_en"){
     $sort_col = "prodType_name_en";
   }
  //  echo $sql_caseCh;
   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0+$post->offset;
      $lv_product = $post->lv_product+1;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
        $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_product_detail('.$re['prodType_id'].',0);">'.$re['prodType_name'].'</span>';
        if($re['prodType_name_en']!=''){
          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product_detail('.$re['prodType_id'].',0);">'.$re['prodType_name_en'].'</span>';
        }else{
          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product_detail('.$re['prodType_id'].',0);">-</span>';
        }

        if($re['prodType_enable'] == '1'){
          $view ='<span class="icon-ico-ditp-12 view_1">';
        }else{
          $view ='<span class="icon-ico-ditp-13  view_2">';
        }
        if($post->lv_product!=5){
          $caseCh_col_arr["detail_view"] = '<a href="?page=product_detail&id_product='.$re['prodType_id'].'&lv_product='.$lv_product.'&office='.$re['office_id'].'">
                                            <i class="fa fa-list txt_no_edit_non"></i></a>';
        }
        $caseCh_col_arr["view"] = $view;
        // echo
        $sql_sub = " SELECT * FROM Product_Type  WHERE prodType_ref_id = '".$re['prodType_id']."'
                     AND prodType_level = $lv_product AND prodType_status = 0 ";
        $query_sub = $conn->query($sql_sub);
        if($query_sub->num_rows > 0){
          // $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',2);"></span>
          //         <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';
                  $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',1);"></span>
                          <span class="icon-ico-ditp-28 txt_no_edit"></span>';
        }else{
          // echo
          $sql_prodType = " SELECT * FROM `Case`  WHERE prodType_id = '".$re['prodType_id']."' ";
          $query_prodType = $conn->query($sql_prodType);
          if($query_prodType->num_rows > 0){
            $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',1);"></span>
                    <span class="icon-ico-ditp-28 txt_no_edit"></span>';
          }else {
            $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',2);"></span>
                    <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';
          }
        }
        $caseCh_col_arr["office"] = '<span class="txt_nol cursor" >'.$re['office_name'].'</span>';
        $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }



  // if(isset($_GET["method"]) && $_GET["method"]=="getproduct_detail_lv3"){
  //    $post = array();
  //    $request_body = file_get_contents('php://input');
  //    $post = json_decode($request_body);
  //    $response = getproduct_detail_lv3($post);
  //    echo $response;
  // exit();
  // }

  // function getproduct_detail_lv3($post){
  //    include("../../config/config.php");
  //
  //    $caseCh_arr = array();
  //     $sql_caseCh = "SELECT *  ";
  //     $sql_caseCh .= "FROM Product_Type WHERE  prodType_ref_id =  '".$post->id_product."' AND prodType_status = '0' AND prodType_level = 3 ";
  //
  //    if($post->text != ""){
  //      $sql_caseCh .= " AND (
  //                            prodType_name LIKE '%".$post->text."%'
  //                            or prodType_name_en LIKE '%".$post->text."%'
  //                            ) ";
  //   }
  //    if($post->sort=="id"){
  //      $sort_col = "prodType_id";
  //    }
  //   if($post->sort=="name"){
  //     $sort_col = "prodType_name";
  //   }
  //   if($post->sort=="name_en"){
  //     $sort_col = "prodType_name_en";
  //   }
  //   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  //   $query_edit_pass_all = $conn->query($sql_caseCh);
  //   $num = $query_edit_pass_all->num_rows;
  //   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
  //      $query_edit_pass = $conn->query($sql_caseCh);
  //      $co_id = 0+$post->offset;
  //     //  echo $sql_caseCh;
  //      while ($re = $query_edit_pass->fetch_assoc()) {
  //        $caseCh_col_arr = array();
  //        $co_id++ ;
  //        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
  //        $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name'].'</span>';
  //        if($re['prodType_name_en']!=''){
  //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name_en'].'</span>';
  //        }else{
  //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">-</span>';
  //        }
  //        $caseCh_col_arr["detail_view"] = '<a href="?page=product_detail_lv4&id_product='.$re['prodType_id'].'"><i class="fa fa-list txt_no_edit_non"></i></a>';
  //
  //          if($re['prodType_enable'] == '1'){
  //            $view ='<span class="icon-ico-ditp-12 view_1">';
  //          }else{
  //            $view ='<span class="icon-ico-ditp-13  view_2">';
  //          }
  //
  //        $caseCh_col_arr["view"] = $view;
  //        $sql_sub = " SELECT * FROM Product_Type  WHERE prodType_ref_id = '".$re['prodType_id']."'
  //                     AND prodType_level = 4 AND prodType_status = 0 ";
  //        $query_sub = $conn->query($sql_sub);
  //        if($query_sub->num_rows > 0){
  //          $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_product_detail('.$re['prodType_id'].',1);"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
  //        }else{
  //          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_product_detail('.$re['prodType_id'].',2);"></span>
  //          <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';
  //        }
  //        $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
  //        array_push($caseCh_arr,$caseCh_col_arr);
  //      }
  //      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
  //      return json_encode($data_array);
  // }


    // if(isset($_GET["method"]) && $_GET["method"]=="getproduct_detail_lv4"){
    //    $post = array();
    //    $request_body = file_get_contents('php://input');
    //    $post = json_decode($request_body);
    //    $response = getproduct_detail_lv4($post);
    //    echo $response;
    // exit();
    // }

    // function getproduct_detail_lv4($post){
    //    include("../../config/config.php");
    //
    //    $caseCh_arr = array();
    //     $sql_caseCh = "SELECT *  ";
    //     $sql_caseCh .= "FROM Product_Type WHERE  prodType_ref_id =  '".$post->id_product."' AND prodType_status = '0' AND prodType_level = 4 ";
    //
    //    if($post->text != ""){
    //      $sql_caseCh .= " AND (
    //                            prodType_name LIKE '%".$post->text."%'
    //                            or prodType_name_en LIKE '%".$post->text."%'
    //                            ) ";
    //     }
    //    if($post->sort=="id"){
    //      $sort_col = "prodType_id";
    //    }
    //   if($post->sort=="name"){
    //     $sort_col = "prodType_name";
    //   }
    //   if($post->sort=="name_en"){
    //     $sort_col = "prodType_name_en";
    //   }
    //   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
    //   $query_edit_pass_all = $conn->query($sql_caseCh);
    //   $num = $query_edit_pass_all->num_rows;
    //   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
    //      $query_edit_pass = $conn->query($sql_caseCh);
    //      $co_id = 0+$post->offset;
    //     //  echo $sql_caseCh;
    //      while ($re = $query_edit_pass->fetch_assoc()) {
    //        $caseCh_col_arr = array();
    //        $co_id++ ;
    //        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
    //        $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_product_detail('.$re['prodType_id'].',0);">'.$re['prodType_name'].'</span>';
    //        if($re['prodType_name_en']!=''){
    //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name_en'].'</span>';
    //        }else{
    //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">-</span>';
    //        }
    //        $caseCh_col_arr["detail_view"] = '<a href="?page=product_detail_lv5&id_product='.$re['prodType_id'].'"><i class="fa fa-list txt_no_edit_non"></i></a>';
    //
    //          if($re['prodType_enable'] == '1'){
    //            $view ='<span class="icon-ico-ditp-12 view_1">';
    //          }else{
    //            $view ='<span class="icon-ico-ditp-13  view_2">';
    //          }
    //
    //        $caseCh_col_arr["view"] = $view;
    //        $sql_sub = " SELECT * FROM Product_Type  WHERE prodType_ref_id = '".$re['prodType_id']."'
    //                     AND prodType_level = 5 AND prodType_status = 0 ";
    //        $query_sub = $conn->query($sql_sub);
    //        if($query_sub->num_rows > 0){
    //
    //          $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',1);"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
    //        }else{
    //          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',2);"></span>
    //          <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';
    //        }
    //        $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
    //        array_push($caseCh_arr,$caseCh_col_arr);
    //      }
    //      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
    //      return json_encode($data_array);
    // }



      // if(isset($_GET["method"]) && $_GET["method"]=="getproduct_detail_lv5"){
      //    $post = array();
      //    $request_body = file_get_contents('php://input');
      //    $post = json_decode($request_body);
      //    $response = getproduct_detail_lv5($post);
      //    echo $response;
      // exit();
      // }

      // function getproduct_detail_lv5($post){
      //    include("../../config/config.php");
      //
      //    $caseCh_arr = array();
      //     $sql_caseCh = "SELECT *  ";
      //     $sql_caseCh .= "FROM Product_Type WHERE  prodType_ref_id =  '".$post->id_product."' AND prodType_status = '0' AND prodType_level = 5 ";
      //
      //    if($post->text != ""){
      //      $sql_caseCh .= " AND (
      //                            prodType_name LIKE '%".$post->text."%'
      //                            or prodType_name_en LIKE '%".$post->text."%'
      //                            ) ";
      //    }
      //    if($post->sort=="id"){
      //      $sort_col = "prodType_id";
      //    }
      //   if($post->sort=="name"){
      //     $sort_col = "prodType_name";
      //   }
      //   if($post->sort=="name_en"){
      //     $sort_col = "prodType_name_en";
      //   }
      //   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
      //   $query_edit_pass_all = $conn->query($sql_caseCh);
      //   $num = $query_edit_pass_all->num_rows;
      //   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      //      $query_edit_pass = $conn->query($sql_caseCh);
      //      $co_id = 0+$post->offset;
      //      while ($re = $query_edit_pass->fetch_assoc()) {
      //        $caseCh_col_arr = array();
      //        $co_id++ ;
      //        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
      //
      //        $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_product_detail('.$re['prodType_id'].',0);">'.$re['prodType_name'].'</span>';
      //        if($re['prodType_name_en']!=''){
      //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">'.$re['prodType_name_en'].'</span>';
      //        }else{
      //          $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor"  onclick="edit_product('.$re['prodType_id'].',0);">-</span>';
      //        }
      //
      //          if($re['prodType_enable'] == '1'){
      //            $view ='<span class="icon-ico-ditp-12 view_1">';
      //          }else{
      //            $view ='<span class="icon-ico-ditp-13  view_2">';
      //          }
      //        $caseCh_col_arr["view"] = $view;
      //
      //        $sql_ch = "  SELECT prodType_id FROM `Case` WHERE `prodType_id` =  '".$re['prodType_id']."'  ";
      //        $query_ch = $conn->query($sql_ch);
      //        if($query_ch->num_rows > 0){
      //
      //          $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',1);"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
      //        }else{
      //          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" onclick="edit_product_detail('.$re['prodType_id'].',2);"></span>
      //          <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';
      //        }
      //        $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
      //        array_push($caseCh_arr,$caseCh_col_arr);
      //      }
      //      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      //      return json_encode($data_array);
      // }
      //



 if(isset($_GET["method"]) && $_GET["method"]=="add_product_detail"){
     include("../../config/config.php");

  $input_lv = data_filter(trim($_POST['input_lv']));

   if (trim($_POST['add_name']) == '' ){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (ไทย)');</script><?php
     exit();
   }
   if (trim($_POST['add_name_en']) == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (Eng)');</script><?php
     exit();
   }
   if ($_REQUEST['input_lv'] == '2' || $_REQUEST['input_lv'] == '3' ){
     if (trim($_POST['office_name']) == '' ){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกสำนัก');</script><?php
       exit();
     }
     $office_id  = $_POST['office_name'];
   }else {
     $office_id  = $_POST['office'];
   }
   $sql_ch = "  SELECT * FROM `Product_Type`
                WHERE `prodType_name` = '".trim($_POST['add_name'])."'
                AND `prodType_ref_id` = '".trim($_POST['type_p'])."'
                AND `prodType_status` = 0 ";
   $query_ch = $conn->query($sql_ch);
   if ($query_ch->num_rows >0)
   {
     ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อสินค้ามีอยู่ในระบบแล้วกรุณากรอกชื่ออื่น');</script><?php
     exit();
   }

   if ($_POST['radio_url_cms'] == 1){
       $prodType_status = '1';
   }else{
       $prodType_status = '0';
   }

   $sql_edit_pass = " INSERT INTO Product_Type  (prodType_name,prodType_name_en,prodType_enable,prodType_level,prodType_ref_id,prodType_create_datetime,prodType_createBy_id,office_id)
                      VALUES ('".trim($_POST['add_name'])."','".trim($_POST['add_name_en'])."', '$prodType_status','$input_lv','".$_POST['type_p']."','$date_setting','$emp_id','$office_id') ";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
      ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
    }else {
      ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
    }
    exit();
 }

 if ($_POST['method']=="get_data_prouuct_detail"){
    // include("../../config/config.php");
        $sql_select = "SELECT prodType_name,prodType_name_en,prodType_enable,office_id,prodType_level  FROM Product_Type where prodType_id = '".$_POST['id']."'";
        $query_select = $conn->query($sql_select);
        $array_row = array();
        if ($query_select->num_rows >0)
        {
          while($result_select = $query_select->fetch_assoc())
          {
            $array_row['name']=$result_select['prodType_name'];
            $array_row['name_en']=$result_select['prodType_name_en'];
            $array_row['enable']=$result_select['prodType_enable'];
            $array_row['office_id']=$result_select['office_id'];
            $array_row['level']=$result_select['prodType_level'];
          }
        }
        echo json_encode($array_row);
        exit();
 }



  if ($_GET['method']=="edit_product"){
     include("../../config/config.php");
     if (trim($_POST['edit_name']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['edit_name_en']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อประเภทสินค้า (Eng)');</script><?php
       exit();
     }

     if ($_REQUEST['office'] == '' ){
       if (trim($_POST['office_name']) == '' ){
         ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกสำนัก');</script><?php
         exit();
       }
       $office_id  = $_POST['office_name'];
     }else {
       $office_id  = $_POST['office'];
     }
     $ch_of = $_POST['office_name'];

     $sql_ch = "  SELECT * FROM `Product_Type`
                  WHERE `prodType_name` = '".trim($_POST['edit_name'])."'
                  AND prodType_id != '".$_POST['id_edit']."'
                  AND `prodType_status` = 0
                  AND prodType_ref_id = '".$_POST['id_product']."' ";
     $query_ch = $conn->query($sql_ch);

     if ($query_ch->num_rows > 0)
     {
       ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อสินค้ามีอยู่ในระบบแล้วกรุณากรอกชื่ออื่น');</script><?php
       exit();
     }


     if ($_POST['radio_url_cms'] == 1){
         $prodType_status = '1';
     }else{
         $prodType_status = '0';
     }
         $sql_edit_pass = "UPDATE  Product_Type SET
                                    prodType_name = '".trim($_POST['edit_name'])."'
                                   ,prodType_name_en = '".trim($_POST['edit_name_en'])."'
                                   ,office_id = '$office_id'
                                   ,prodType_enable   = '$prodType_status'
                                   ,prodType_update_datetime  = '$date_setting'
                                   ,prodType_updateBy_idateBy_id = '$emp_id'
                                 where  prodType_id = '".$_POST['id_edit']."'";
          $query_edit_pass = $conn->query($sql_edit_pass);
          // exit();
          // office update

          $office =  $_POST['office_name'];
          $sql_office = "SELECT * FROM `Product_Type` WHERE `prodType_ref_id` =   '".$_POST['id_edit']."' AND prodType_status = '0' ";
          $query_office = $conn->query($sql_office);
          if ($query_office->num_rows >0){
            while ($re = $query_office->fetch_assoc()) {
              $update_office = "UPDATE  Product_Type SET office_id = '$office' where  prodType_id = '".$re['prodType_id']."'";
              $queryupdate_office = $conn->query($update_office);

              $sql_office_lv3 = "SELECT * FROM `Product_Type` WHERE `prodType_ref_id` =  '".$re['prodType_id']."' AND prodType_status = '0' ";
              $query_office_lv3 = $conn->query($sql_office_lv3);
              if ($query_office_lv3->num_rows >0){
                while ($re_lv3 = $query_office_lv3->fetch_assoc()) {
                  $update_office_lv3 = "UPDATE  Product_Type SET office_id = '$office' where  prodType_id = '".$re_lv3['prodType_id']."'";
                  $queryupdate_office_lv3 = $conn->query($update_office_lv3);

                  $sql_office_lv4 = "SELECT * FROM `Product_Type` WHERE `prodType_ref_id` =  '".$re_lv3['prodType_id']."' AND prodType_status = '0' ";
                  $query_office_lv4 = $conn->query($sql_office_lv4);
                  if ($query_office_lv4->num_rows >0){
                    while ($re_lv4 = $query_office_lv4->fetch_assoc()) {
                      $update_office_lv4 = "UPDATE  Product_Type SET office_id = '$office' where  prodType_id = '".$re_lv4['prodType_id']."' ";
                      $queryupdate_office_lv4 = $conn->query($update_office_lv4);

                      // $sql_office_lv5 = "SELECT * FROM `Product_Type` WHERE `prodType_ref_id` =  '".$re_lv4['prodType_id']."' AND prodType_status = '0' ";
                      // $query_office_lv5 = $conn->query($sql_office_lv5);
                      // if ($query_office_lv5->num_rows >0){
                      //   while ($re_lv5 = $query_office_lv5->fetch_assoc()) {
                      //     $update_office_lv5 = "UPDATE  Product_Type SET office_id = '$office' where  prodType_id = '".$re_lv5['prodType_id']."'";
                      //     $queryupdate_office_lv5 = $conn->query($update_office_lv5);
                      //   }
                      // }
                    }
                  }
                }
              }
            }
          }

          //  exit();
          if ($query_edit_pass){
            ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
          }else {
            ?><script type="text/javascript">parent.iziToast_func.alert('แก้ไขข้อมูลผิดพลาด');</script><?php
          }
          exit();
  }

  if ($_POST['method']=="del_product_detail"){
     include("../../config/config.php");


     $sql_edit_pass = "UPDATE  Product_Type SET
                               prodType_status = '1'
                             where  prodType_id = '".$_POST['id_p']."'";
      $query_edit_pass = $conn->query($sql_edit_pass);
      if ($query_edit_pass){
          echo '11';
      }else {
          echo "01";
      }
      exit();
  }

  if(isset($_GET["method"]) && $_GET["method"]=="add_complaint"){

      if (trim($_POST['add_name']) == '' ){
        ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อเรื่องร้องเรียน (ไทย)');</script><?php
        exit();
      }
      if (trim($_POST['add_name_en']) == '' ){
        ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อเรื่องร้องเรียน (Eng)');</script><?php
        exit();
      }
        if($_POST['radio_add'] == '1'){
          $radio_add = '1';
        }else{
          $radio_add = '2';
        }

      if($_POST['Complaint_Type']==0){
        if (trim($_POST['add_day']) == '' ){
          ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกระยะเวลาในการดำเนินการ');</script><?php
          exit();
        }

         $sql_insert = " INSERT INTO Complaint_Type (compType_section,compType_name,compType_duration,compType_create_datetime,compType_createBy_id,compType_name_en,compType_other_flag)
                        VALUES ('$radio_add','".trim($_POST['add_name'])."','".trim($_POST['add_day'])."','$date_setting','$emp_id','".trim($_POST['add_name_en'])."','".$_POST['ra_other']."') ";
         $query_insert = $conn->query($sql_insert);
           if ($query_insert){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else {
             ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
           }


      }else if($_POST['Complaint_Type_1']==0){



        $sql_insert = " INSERT INTO Complaint_Type_Sub1 (compType_id,compTypeSub1_name,compTypeSub1_create_datetime,compTypeSub1_createBy_id,compTypeSub1_name_en)
                        VALUES ('".$_POST['Complaint_Type']."','".trim($_POST['add_name'])."','$date_setting','$emp_id','".trim($_POST['add_name_en'])."') ";
         $query_insert = $conn->query($sql_insert);


         $sql = "UPDATE  Complaint_Type SET form_id = '0' where  compType_id = '".$_POST['Complaint_Type']."'";
         $query = $conn->query($sql);

         $sql_del = "DELETE FROM `Form_Link_Complaint_Type` WHERE  compType_id = '".$_POST['Complaint_Type']."' AND compTypeSub1_id = 0 AND compTypeSub2_id = 0";
         $query_del = $conn->query($sql_del);

           if ($query_insert && $query && $query_del){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else {
             ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
           }


      }else if($_POST['Complaint_Type_1']!=0 && $_POST['Complaint_Type_1']!='' ){

        $sql_insert = " INSERT INTO Complaint_Type_Sub2 (compTypeSub1_id,compTypeSub2_name,compTypeSub2_create_datetime,compTypeSub2_createBy_id,compTypeSub2_name_en)
                        VALUES ('".$_POST['Complaint_Type_1']."','".trim($_POST['add_name'])."','$date_setting','$emp_id','".trim($_POST['add_name_en'])."') ";
        $query_insert = $conn->query($sql_insert);


         $sql = " UPDATE Complaint_Type_Sub1 SET form_id = '0' where  compTypeSub1_id = '".$_POST['Complaint_Type_1']."'";
         $query = $conn->query($sql);

         $sql_select = "SELECT * FROM `Complaint_Type_Sub1` WHERE  compTypeSub1_id = '".$_POST['Complaint_Type_1']."'";
         $query_select = $conn->query($sql_select);
         $row_lv2=$query_select->fetch_assoc();

         $sql_del = "DELETE FROM `Form_Link_Complaint_Type` WHERE  compType_id = '".$row_lv2['compType_id']."' AND compTypeSub1_id = '".$_POST['Complaint_Type_1']."' AND compTypeSub2_id = 0 ";
         $query_del = $conn->query($sql_del);




         if ($query_insert && $query && $query_del){
           ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
         }else {
           ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
         }
      }
exit();

  }


  if($_POST['method']=='sub_type_complaint'){
    include("../../config/config.php");

  	?>
    <div class="row form-group">
      <div class="col-md-4 ">
        <label for="recipient-name" class="control-label">ประเภทเรื่องร้องเรียนย่อย<label class="txt_no_del">*</label></label>
      </div>
      <div class="col-md-8 ">
        <select class="selectpicker Complaint_Type_1"  data-width="100%" name="Complaint_Type_1"  id="Complaint_Type_1" onchange="sub_type_complaint_sub();">
          <?php
          $sql_select = "SELECT compTypeSub1_id,compTypeSub1_name FROM Complaint_Type_Sub1 where compType_id = '".$_POST['id_type']."' AND compTypeSub1_status = 0 ";
          $query_select = $conn->query($sql_select);
          if($query_select->num_rows > 0){
            ?>  <option value="0">--- เลือกประเภทเรื่องร้องเรียนย่อย ---</option><?php
          while ( $re =   $query_select->fetch_assoc()) {
            ?><option value="<?=$re['compTypeSub1_id']?>"><?=$re['compTypeSub1_name']?></option><?php
          }
        }else{
          ?><option value="">ไม่พบข้อมูล</option><?php
        }
          ?>
        </select>
      </div>
    </div>

  	<?php
  	exit();
  }

  if(isset($_GET["method"]) && $_GET["method"]=="getprocess"){
      $post = array();
      $request_body = file_get_contents('php://input');
      $post = json_decode($request_body);
      $response = getprocess($post);
      echo $response;
  exit();
  }

  function getprocess($post){
     include("../../config/config.php");

     $caseCh_arr = array();
     $sql_caseCh = "SELECT process_type_id,process_type_name,process_type_step,process_type_duration,process_type_enable,process_type_section  ";
     $sql_caseCh .= "FROM  Process_Type WHERE process_type_status = '0' ";

     if($post->text != ""){
       $sql_caseCh .= "AND process_type_name LIKE '%".$post->text."%' ";
     }
     if($post->type_section != ""){
       $sql_caseCh .= "AND process_type_section = '".$post->type_section."' ";
     }
     if($post->sort=="id"){
       $sort_col = "process_type_id";
     }
    if($post->sort=="name"){
      $sort_col = "process_type_name";
    }
    if($post->sort=="type"){
      $sort_col = "process_type_section";
    }
    if($post->sort=="step"){
      $sort_col = "process_type_step";
    }
    $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
    $query_edit_pass_all = $conn->query($sql_caseCh);
    $num = $query_edit_pass_all->num_rows;
    $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
       $query_edit_pass = $conn->query($sql_caseCh);
       $co_id = 0+$post->offset;
       while ($re = $query_edit_pass->fetch_assoc()) {
         $caseCh_col_arr = array();
         $co_id++ ;


           if($re['process_type_section'] == '1'){
             $type='<span class="type_general">สสบ.</span>';
           }else if($re['process_type_section'] == '2'){
             $type ='<span class="type_law">นิติการ</span>';
           }else{
             $type ='<span class="txt_nol">สสบ. และ นิติการ</span>';

           }

          if($re['process_type_step'] == '1'){
              $step = '1 / (25%)';
          }else if($re['process_type_step'] == '2'){
              $step = '2 / (50%)';
          }else if($re['process_type_step'] == '3'){
              $step = '3 / (75%)';
          }else if($re['process_type_step'] == '4'){
              $step = '4 / (100%)';
          }
          if($re['process_type_enable'] == '1'){
            $view ='<span class="icon-ico-ditp-12 view_1">';
          }else{
            $view ='<span class="icon-ico-ditp-13  view_2">';
          }
        $caseCh_col_arr["view"] = $view;

        $sql_ch = "   SELECT p.process_type_id FROM `Case` AS c
                      LEFT JOIN `Process` AS p ON c.case_id = p.case_id
                      LEFT JOIN `Process_Type` AS pt ON pt.process_type_id = p.process_type_id
                      where p.process_type_id = '".$re['process_type_id']."'  ";
        $query_ch = $conn->query($sql_ch);
        if($query_ch->num_rows > 0){
          $none_edit = 0;
          $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_process('.$re['process_type_id'].',2);"></span>
                  <span class="icon-ico-ditp-28 txt_no_edit"></span>';
        }else{
          $none_edit = 1;

          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_process('.$re['process_type_id'].','.$none_edit.');"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del" onclick="ConfirmDelete()&&del_process('.$re['process_type_id'].');"></span>';
       }

       if($re['process_type_id'] == 1 || $re['process_type_id'] == 2){
         $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_process('.$re['process_type_id'].',2);"></span>
                 <span class="icon-ico-ditp-28 txt_no_edit"></span>';
       }
         $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
         $caseCh_col_arr["name"] = '<span class="txt_nol cursor"  onclick="edit_process('.$re['process_type_id'].',0);">'.$re['process_type_name'].'</span>';
         $caseCh_col_arr["type"] = $type;
         $caseCh_col_arr["step"] = '<span class="txt_nol">'.$step.'</span>';
         $caseCh_col_arr["duration"] = '<span class="txt_nol">'.$re['process_type_duration'].'</span>';
         $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
         array_push($caseCh_arr,$caseCh_col_arr);
       }
       $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
       return json_encode($data_array);
  }


  if(isset($_GET["method"]) && $_GET["method"]=="add_process"){
      include("../../config/config.php");

    $_POST['add_name'] = data_filter(trim($_POST['add_name']));
    $_POST['add_day'] = data_filter(trim($_POST['add_day']));
    $_POST['send_back'] = data_filter(trim($_POST['send_back']));
    $_POST['send_to'] = data_filter(trim($_POST['send_to']));
    $_POST['radio_section'] = data_filter(trim($_POST['radio_section']));
    $_POST['radio_step'] = data_filter(trim($_POST['radio_step']));
    $_POST['radio_enable'] = data_filter(trim($_POST['radio_enable']));
    $_POST['radio_contact'] = data_filter(trim($_POST['radio_contact']));
    $_POST['message_noti'] = data_filter(trim($_POST['message_noti']));

    $_POST['message_noti_en'] = data_filter(trim($_POST['message_noti_en']));
    $_POST['send_back_en'] = data_filter(trim($_POST['send_back_en']));
    $_POST['send_to_en'] = data_filter(trim($_POST['send_to_en']));


    if ($_POST['radio_contact'] == '1' ){
      if ($_POST['Depart_type'] == '' ){
        ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกประเภทหน่วยงาน');</script><?php
        exit();
      }
    }

    if ($_POST['add_name'] == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อกระบวนการ');</script><?php
      exit();
    }
    if ($_POST['add_day'] == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากำหนดเวลา');</script><?php
      exit();
    }

    if ($_POST['radio_section'] == 1){
        $radio_section = '1';
    }else{
        $radio_section = '2';
    }

    if ($_POST['radio_step'] == 1){
        $radio_step = '1';
    }else if ($_POST['radio_step'] == 2){
        $radio_step = '2';
    }else if ($_POST['radio_step'] == 3){
        $radio_step = '3';
    }else if ($_POST['radio_step'] == 4){
        $radio_step = '4';
    }

    if ($_POST['radio_enable'] == 1){
        $radio_enable = '1';
    }else{
        $radio_enable = '0';
    }
    $process_typ_contact = $_POST['radio_contact'];

      $sql_Process_Type = " INSERT INTO Process_Type (process_type_name,process_type_step,process_type_duration,process_type_enable,process_type_section,process_type_create_datetime
                                        ,process_type_createBy_id,process_typ_contact,process_type_message_in,process_type_message_out,dept_type,process_type_message_noti
                                        ,process_type_message_noti_en , process_type_message_in_en , process_type_message_out_en)
                            VALUES ('".$_POST['add_name']."','$radio_step','".$_POST['add_day']."','$radio_enable','$radio_section','$date_setting','$emp_id'
                                    ,'$process_typ_contact','".$_POST['send_back']."','".$_POST['send_to']."','".$_POST['Depart_type']."','".$_POST['message_noti']."'
                                    ,'".$_POST['message_noti_en']."','".$_POST['send_back_en']."','".$_POST['send_to_en']."') ";
      $query_Process_Type = $conn->query($sql_Process_Type);
       if ($query_Process_Type){
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
       }else {
         ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }
       exit();
}


if ($_POST['method']=="get_data_process"){
   include("../../config/config.php");

       $sql_select = "  SELECT *
                        FROM Process_Type where process_type_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['process_type_name']=$result_select['process_type_name'];
           $array_row['process_type_step']=$result_select['process_type_step'];
           $array_row['process_type_duration']=$result_select['process_type_duration'];
           $array_row['process_type_enable']=$result_select['process_type_enable'];
           $array_row['process_type_section']=$result_select['process_type_section'];
           $array_row['process_typ_contact']=$result_select['process_typ_contact'];
           $array_row['process_type_message_in']=$result_select['process_type_message_in'];
           $array_row['process_type_message_out']=$result_select['process_type_message_out'];
           $array_row['dept_type']=$result_select['dept_type'];
           $array_row['process_type_message_noti']=$result_select['process_type_message_noti'];
           $array_row['process_type_message_noti_en']=$result_select['process_type_message_noti_en'];
           $array_row['process_type_message_in_en']=$result_select['process_type_message_in_en'];
           $array_row['process_type_message_out_en']=$result_select['process_type_message_out_en'];


         }
       }
       echo json_encode($array_row);
       exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="save_process"){
    include("../../config/config.php");


    $_POST['radio_section'] = data_filter(trim($_POST['radio_section']));
    $_POST['radio_contact'] = data_filter(trim($_POST['radio_contact']));
    $_POST['Depart_type'] = data_filter(trim($_POST['Depart_type']));
    $_POST['edit_name'] = data_filter(trim($_POST['edit_name']));
    $_POST['add_date'] = data_filter(trim($_POST['add_date']));
    $_POST['radio_step'] = data_filter(trim($_POST['radio_step']));
    $_POST['radio_enable'] = data_filter(trim($_POST['radio_enable']));
    $_POST['send_back'] = data_filter(trim($_POST['send_back']));
    $_POST['send_to'] = data_filter(trim($_POST['send_to']));
    $_POST['id_edit'] = data_filter(trim($_POST['id_edit']));
    $_POST['message_noti'] = data_filter(trim($_POST['message_noti']));
    $_POST['message_noti_en'] = data_filter(trim($_POST['message_noti_en']));
    $_POST['send_back_en'] = data_filter(trim($_POST['send_back_en']));
    $_POST['send_to_en'] = data_filter(trim($_POST['send_to_en']));


  if ($_POST['radio_contact'] == '1' ){
    if ($_POST['Depart_type'] == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกประเภทหน่วยงาน');</script><?php
      exit();
    }
  }

  if ($_POST['edit_name'] == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อกระบวนการ');</script><?php
    exit();
  }
  if ($_POST['edit_day'] == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากำหนดเวลา');</script><?php
    exit();
  }


  if($_POST['id_edit'] == '1' || $_POST['id_edit'] == '2' ){

  }else{
    // if ($_POST['message_in'] == '' ){
    //   ?><script type="text/javascript">//alert('กรุณากรอกข้อความส่งเข้า');</script><?php
    //   exit();
    // }
    $Update = " ,  process_type_message_in = '".$_POST['message_in']."' ,  process_type_message_in_en = '".$_POST['message_in_en']."'  " ;

  }


    // if ($_POST['message_out'] == '' ){
    //   ?><script type="text/javascript">//alert('กรุณากรอกข้อความส่งออก');</script><?php
    //   exit();
    // }



if($_POST['id_edit']==1 || $_POST['id_edit'] ==2){
    $radio_section = '0';
}else{
  if ($_POST['radio_section'] == 1){
      $radio_section = '1';
  }else{
      $radio_section = '2';
  }
}

  if ($_POST['radio_step'] == 1){
      $radio_step = '1';
  }else if ($_POST['radio_step'] == 2){
      $radio_step = '2';
  }else if ($_POST['radio_step'] == 3){
      $radio_step = '3';
  }else if ($_POST['radio_step'] == 4){
      $radio_step = '4';
  }

  if ($_POST['radio_enable'] == 1){
      $radio_enable = '1';
  }else{
      $radio_enable = '0';
  }


  $process_typ_contact = $_POST['radio_contact'];
  $sql_edit = " UPDATE  Process_Type SET
                process_type_name = '".$_POST['edit_name']."',
                process_type_step = '$radio_step',
                process_type_duration =  '".$_POST['edit_day']."',
                process_type_enable =  '$radio_enable',
                process_type_section = '$radio_section',
                process_type_update_datetime = '$date_setting',
                process_type_updateBy_id = '$emp_id',
                process_typ_contact = '$process_typ_contact',
                dept_type = '".$_POST['Depart_type']."',
                process_type_message_noti = '".$_POST['message_noti']."',
                process_type_message_out = '".$_POST['message_out']."',
                process_type_message_noti_en = '".$_POST['message_noti_en']."',
                process_type_message_out_en = '".$_POST['message_out_en']."'

                $Update
                where  process_type_id = '".$_POST['id_edit']."'
                ";
   $query_edit = $conn->query($sql_edit);
     if ($query_edit){
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
     }else {
       ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
     }
     exit();

}

if ($_POST['method']=="del_process"){
   include("../../config/config.php");

   $sql_edit_pass = "UPDATE  Process_Type SET
                           process_type_status = '1'
                           where  process_type_id = '".$_POST['id_p']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
        echo '11';
    }else {
        echo "01";
    }
    exit();
}


if($_POST['method']=='chech_section'){
  include("../../config/config.php");
	?>
  <select class="selectpicker Complaint_Type"  data-width="100%" name="Complaint_Type"  id="Complaint_Type" onchange="sub_type_complaint();">
    <option value="">--- เลือกประเภทเรื่องร้องเรียน ---</option>
    <?php
    $sql_select = "SELECT compType_name,compType_id FROM Complaint_Type where compType_status = '0' AND compType_section = '".$_POST['id']."' ";
    $query_select = $conn->query($sql_select);
      while ( $re =   $query_select->fetch_assoc()) {
        ?><option value="<?=$re['compType_id']?>"><?=$re['compType_name']?></option><?php
      }
    ?>
  </select>
	<?php
	exit();
}

  if($_POST['method']=='chech_section_sub_1_1'){
    include("../../config/config.php");
    ?>
    <div class="col-md-4 ">
      <label for="recipient-name" class="control-label">ประเภทเรื่องร้องเรียน</label>
    </div>
    <div class="col-md-8 chech_section ">
    <select class="selectpicker Complaint_Type"  data-width="auto" name="Complaint_Type"  id="Complaint_Type" >
      <option value="">--- เลือกประเภทเรื่องร้องเรียน ---</option>
      <?php
      $sql_select = "SELECT compType_name,compType_id FROM Complaint_Type where compType_status = '0' AND compType_section = '".$_POST['id']."' ";
      $query_select = $conn->query($sql_select);
        while ( $re =   $query_select->fetch_assoc()) {
          ?><option value="<?=$re['compType_id']?>"><?=$re['compType_name']?></option><?php
        }
      ?>
    </select>
  </div>
    <?php
    exit();
}



if(isset($_GET["method"]) && $_GET["method"]=="getcomplaint"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getcomplaint($post);
    echo $response;
exit();
}

function getcomplaint($post){
   include("../../config/config.php");




$caseCh_arr = array();
$caseCh_sub3 = array();
$caseCh_sub2 = array();
$caseCh_sub1 = array();
if($post->text != ""){
  $sql_caseCh_sub3 = "SELECT compTypeSub2_id,compTypeSub1_id,compTypeSub2_name FROM `Complaint_Type_Sub2` WHERE compTypeSub2_status = 0 ";
  if($post->text != ""){
    $sql_caseCh_sub3 .= " AND compTypeSub2_name LIKE '%".$post->text."%' ";
  }
  $query_caseCh_sub3  = $conn->query($sql_caseCh_sub3);
  while ($re_caseCh_sub3  = $query_caseCh_sub3 ->fetch_assoc()) {
    if (!in_array($re_caseCh_sub3['compTypeSub2_id'], $caseCh_sub3)) {
      array_push($caseCh_sub3,$re_caseCh_sub3['compTypeSub2_id']);
    }
    $sql_caseCh_sub2 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compTypeSub1_status = 0 AND compTypeSub1_id =  '".$re_caseCh_sub3['compTypeSub1_id']."' ";
    $query_caseCh_sub2  = $conn->query($sql_caseCh_sub2);
    while ($re_caseCh_sub2  = $query_caseCh_sub2->fetch_assoc()) {
      if (!in_array($re_caseCh_sub2['compTypeSub1_id'], $caseCh_sub2)) {
        array_push($caseCh_sub2,$re_caseCh_sub2['compTypeSub1_id']);
      }
      $sql_caseCh_sub1 = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0 AND compType_id =  '".$re_caseCh_sub2['compType_id']."' ";
      $query_caseCh_sub1  = $conn->query($sql_caseCh_sub1);
      while ($re_caseCh_sub1  = $query_caseCh_sub1->fetch_assoc()) {
        if (!in_array($re_caseCh_sub1['compType_id'], $caseCh_sub1)) {
          array_push($caseCh_sub1,$re_caseCh_sub1['compType_id']);
        }
      }
    }
  }
}


if($post->text != ""){
  $sql_caseCh_sub2 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compTypeSub1_status = 0 ";
  if($post->text != ""){
    $sql_caseCh_sub2 .= " AND compTypeSub1_name LIKE '%".$post->text."%' ";
  }
  $query_caseCh_sub2  = $conn->query($sql_caseCh_sub2);
  while ($re_caseCh_sub2  = $query_caseCh_sub2->fetch_assoc()) {
    if (!in_array($re_caseCh_sub2['compTypeSub1_id'], $caseCh_sub2)) {
      array_push($caseCh_sub2,$re_caseCh_sub2['compTypeSub1_id']);
    }
    $sql_caseCh_sub1 = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0 AND compType_id =  '".$re_caseCh_sub2['compType_id']."' ";
    $query_caseCh_sub1  = $conn->query($sql_caseCh_sub1);
    while ($re_caseCh_sub1  = $query_caseCh_sub1->fetch_assoc()) {
      if (!in_array($re_caseCh_sub1['compType_id'], $caseCh_sub1)) {
        array_push($caseCh_sub1,$re_caseCh_sub1['compType_id']);
      }
    }
  }
}

if($post->text != ""){
  $sql_caseCh_sub1 = "SELECT * FROM `Complaint_Type` WHERE compType_status = 0 ";
  if($post->text != ""){
    $sql_caseCh_sub1 .= " AND compType_name LIKE '%".$post->text."%' ";
  }
  $query_caseCh_sub1  = $conn->query($sql_caseCh_sub1);
  while ($re_caseCh_sub1  = $query_caseCh_sub1->fetch_assoc()) {
    if (!in_array($re_caseCh_sub1['compType_id'], $caseCh_sub1)) {
      array_push($caseCh_sub1,$re_caseCh_sub1['compType_id']);
    }
  }
}

  $sql_caseCh = " SELECT compType_id,form_id,compType_name,compType_duration,compType_section  ";
  $sql_caseCh .= " FROM  Complaint_Type WHERE compType_status = '0' ";

  if(count($caseCh_sub1)!='0'){
    $caseCh_where = "";
    $caseCh_where = join(',',$caseCh_sub1);
    $sql_caseCh .= " AND compType_id in (".$caseCh_where.") ";
  }
  if($post->sort == "name"){
    $sort_col = "compType_id";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = '0';
    //  echo $sql_caseCh;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;

        $sql_ch = "SELECT compType_id  FROM  Complaint_Type_Sub1 where compType_id = '".$re['compType_id']."' AND compTypeSub1_status = '0' ";
        $query_ch = $conn->query($sql_ch);
        if($query_ch->num_rows>0){
          $from = '';

          $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non" data-toggle="modal" onclick="edit_complaint(1,'.$re['compType_id'].',0);"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_edit"></span>';

        }else{
          if($re['form_id']==0){
            $from = '<button type="button" class="btn_from click_add" data-toggle="modal"  onclick="select_formset(1,'.$re['compType_id'].',0,0,1);" >
                    <span class="btn_form">เลือกฟอร์ม</span></button>';
            $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(1,'.$re['compType_id'].',1);"></span>
                    <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(1,'.$re['compType_id'].');"></span>';
          }else{

              $sql_case_ty1 = "SELECT `compType_id` FROM `Case` WHERE `compType_id` = '".$re['compType_id']."'";
              $query_case_ty1 = $conn->query($sql_case_ty1);

              $sql_case_name = "SELECT form_name FROM `Form_Of_Comp` WHERE `form_id` = '".$re['form_id']."'";
              $query_case_name = $conn->query($sql_case_name);
              $re_ch_name = $query_case_name->fetch_assoc();
              $re_name = $re_ch_name['form_name'];

              if ($query_case_ty1->num_rows > 0){
                $from = '<span class="txt_no_form">'.$re_name.'</span>';
                $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span>
                        <span class="icon-ico-ditp-28 txt_no_edit"></span>';

              }else{
                $from = '<span  class="txt_edit" onclick="select_formset_edit(1,'.$re['compType_id'].',0,0,'.$re['form_id'].');" ><span class="txt_edit">'.$re_name.'</span>&nbsp;
                         <span class="icon-ico-ditp-10"  data-toggle="modal" ></span></span>';
                $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(1,'.$re['compType_id'].',1);"></span>
                        <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(1,'.$re['compType_id'].');"></span>';
              }
          }
        }
        $day = $re['compType_duration'];
        $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['compType_name'].'</span>';
        $caseCh_col_arr["day"] = '<span class="txt_nol">'.$re['compType_duration'].'</span>';
        $caseCh_col_arr["from"] = $from ;
        $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
        $id_ty = $re['compType_id'];

        if($re['compType_section'] == '1'){
          $type='<span class="type_general">สสบ.</span>';
        }else{
          $type ='<span class="type_law">นิติการ</span>';
        }
          $caseCh_col_arr["type"] = $type;
        array_push($caseCh_arr,$caseCh_col_arr);


        $sql_caseCh_1 = "SELECT compTypeSub1_id,form_id,compTypeSub1_name FROM Complaint_Type_Sub1 WHERE compType_id = '$id_ty' AND compTypeSub1_status = '0'  ";

      if(count($caseCh_sub2)!='0'){
        $caseCh_where = "";
        $caseCh_where = join(',',$caseCh_sub2);
        $sql_caseCh_1 .= " AND compTypeSub1_id in (".$caseCh_where.") ";
      }

        $query_edit_pass_1 = $conn->query($sql_caseCh_1);
        $num1 = $query_edit_pass_1->num_rows;
        $from = '';
        $del = '';
        while ($re_1 = $query_edit_pass_1->fetch_assoc()) {
          $idx    = $re_1['compTypeSub1_id'];


            $sql_ch = "SELECT compTypeSub1_id  FROM  Complaint_Type_Sub2 where compTypeSub1_id = '".$re_1['compTypeSub1_id']."' AND compTypeSub2_status = '0' ";
            $query_ch = $conn->query($sql_ch);
            if($query_ch->num_rows>0){
              $from = '';
              // $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
              $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(2,'.$re_1['compTypeSub1_id'].',0);"></span>
                      <span class="icon-ico-ditp-28 txt_no_edit"></span>';

            }else{
              if($re_1['form_id']==0){
                $from ='<button type="button" class="btn_from click_add" data-toggle="modal" onclick="select_formset(2,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].',0);" >
                        <span class="btn_form">เลือกฟอร์ม</span></button>';
                $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(2,'.$re_1['compTypeSub1_id'].',0);"></span>
                        <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(2,'.$re_1['compTypeSub1_id'].');"></span>';
              }else{

                $sql_case_ty2 = "SELECT `compTypeSub1_id` FROM `Case` WHERE `compTypeSub1_id` = '".$re_1['compTypeSub1_id']."'";
                $query_case_ty2 = $conn->query($sql_case_ty2);

                $sql_case_name = "SELECT form_name FROM `Form_Of_Comp` WHERE `form_id` = '".$re_1['form_id']."'";
                $query_case_name = $conn->query($sql_case_name);
                $re_ch_name = $query_case_name->fetch_assoc();
                $re_name = $re_ch_name['form_name'];

                if ($query_case_ty2->num_rows > 0){
                  $from = '<span class="txt_no_form">'.$re_name.'</span>';
                  $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span>
                          <span class="icon-ico-ditp-28 txt_no_edit"></span>';
                }else{
                  $from = '<span  class="txt_edit" onclick="select_formset_edit(2,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].',0,'.$re_1['form_id'].');"><span class="txt_edit">'.$re_name.'</span>&nbsp;
                           <span class="icon-ico-ditp-10"  data-toggle="modal"></span></span>';
                 $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(2,'.$re_1['compTypeSub1_id'].',0);"></span>
                         <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(2,'.$re_1['compTypeSub1_id'].');"></span>';
                }
              }
            }


          $caseCh_col_arr["name"] = '<span class="txt_nol padd_com1"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$re_1['compTypeSub1_name'].'</span>';
          $caseCh_col_arr["from"] = $from ;
          $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
          $caseCh_col_arr["day"] = '<span class="txt_nol_day">'.$day.'</span>';
          array_push($caseCh_arr,$caseCh_col_arr);


          $sql_caseCh_2 = "SELECT compTypeSub2_id,form_id,compTypeSub2_name FROM Complaint_Type_Sub2 WHERE compTypeSub1_id = '$idx' AND compTypeSub2_status = '0'  ";

          if(count($caseCh_sub3)!='0'){
            $caseCh_where = "";
            $caseCh_where = join(',',$caseCh_sub3);
            $sql_caseCh_2 .= " AND compTypeSub2_id in (".$caseCh_where.") ";
          }

          $query_edit_pass_2 = $conn->query($sql_caseCh_2);
          $num2 = $query_edit_pass_2->num_rows;
          while ($re_2 = $query_edit_pass_2->fetch_assoc()) {
              if($re_2['form_id']==0){
                  $from ='<button type="button" class="btn_from click_add" data-toggle="modal" onclick="select_formset(3,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].','.$re_2['compTypeSub2_id'].');">
                          <span class="btn_form">เลือกฟอร์ม</span></button>';
                  $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(3,'.$re_2['compTypeSub2_id'].',0);"></span>
                          <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(3,'.$re_2['compTypeSub2_id'].');"></span>';

              }else{

                    $sql_case_ty2 = "SELECT `compTypeSub2_id` FROM `Case` WHERE `compTypeSub2_id` = '".$re_2['compTypeSub2_id']."'";
                      $query_case_ty2 = $conn->query($sql_case_ty2);

                      $sql_case_name = "SELECT form_name FROM `Form_Of_Comp` WHERE `form_id` = '".$re_2['form_id']."'";
                      $query_case_name = $conn->query($sql_case_name);
                      $re_ch_name = $query_case_name->fetch_assoc();
                      $re_name = $re_ch_name['form_name'];

                      if ($query_case_ty2->num_rows > 0){
                        $from = '<span class="txt_no_form">'.$re_name.'</span>';
                        $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(3,'.$re_2['compTypeSub2_id'].',0);"></span>
                                  <span class="icon-ico-ditp-28 txt_no_edit"></span>';
                      }else{
                        $from =   '<span class="txt_edit" onclick="select_formset_edit(3,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].','.$re_2['compTypeSub2_id'].','.$re_2['form_id'].');" ><span class="txt_edit">'.$re_name.'</span>&nbsp;
                                  <span class="icon-ico-ditp-10"  data-toggle="modal" ></span></span>';
                        $del =    '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(3,'.$re_2['compTypeSub2_id'].',0);"></span>
                                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(3,'.$re_2['compTypeSub2_id'].');"></span>';
                      }
              }

            $caseCh_col_arr["name"] = '<span class="txt_nol padd_com2"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$re_2['compTypeSub2_name'].'</span>';
            $caseCh_col_arr["from"] = $from ;
            $caseCh_col_arr["del_edit"] = '<div class="th_user_edit_1">'.$del.'</div>';
            $caseCh_col_arr["day"] = '<span class="txt_nol_day">'.$day.'</span>';
            array_push($caseCh_arr,$caseCh_col_arr);
          }
        }
     }

     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}

if ($_POST['method']=="del_complaint"){
   include("../../config/config.php");
   if($_POST['type']==1){
      $sql = "UPDATE  Complaint_Type SET compType_status = '1' where  compType_id = '".$_POST['id_del']."'";
      $query = $conn->query($sql);

      $sql_del = "DELETE FROM `Form_Link_Complaint_Type` WHERE  compType_id = '".$_POST['id_del']."' AND compTypeSub1_id = 0 AND compTypeSub2_id = 0";
      $query_del = $conn->query($sql_del);

      if ($query && $query_del){
          echo '11';
      }else {
          echo "01";
      }

   }else if($_POST['type']==2){
      $sql = " UPDATE Complaint_Type_Sub1 SET compTypeSub1_status = '1' where  compTypeSub1_id = '".$_POST['id_del']."'";
      $query = $conn->query($sql);

      $sql_select = "SELECT * FROM `Complaint_Type_Sub1` WHERE  compTypeSub1_id = '".$_POST['id_del']."'";
      $query_select = $conn->query($sql_select);
      $row_lv2=$query_select->fetch_assoc();
      $sql_del = "DELETE FROM `Form_Link_Complaint_Type` WHERE  compType_id = '".$row_lv2['compType_id']."' AND compTypeSub1_id = '".$_POST['id_del']."' AND compTypeSub2_id = 0 ";
      $query_del = $conn->query($sql_del);

      if ($query){
          echo '11';
      }else {
          echo "01";
      }

   }else if($_POST['type']==3){
      $sql = " UPDATE Complaint_Type_Sub2 SET compTypeSub2_status = '1' where  compTypeSub2_id = '".$_POST['id_del']."'";
      $query = $conn->query($sql);

      $sql_select = "SELECT * FROM `Complaint_Type_Sub2` WHERE  compTypeSub2_id = '".$_POST['id_del']."'";
      $query_select = $conn->query($sql_select);
      $row_lv2=$query_select->fetch_assoc();

      $sql_select1 = "SELECT * FROM `Complaint_Type_Sub1` WHERE  compTypeSub1_id = '".$row_lv2['compTypeSub1_id']."'";
      $query_select1 = $conn->query($sql_select1);
      $row_lv1=$query_select1->fetch_assoc();

      $sql_del = "DELETE FROM `Form_Link_Complaint_Type` WHERE  compType_id = '".$row_lv1['compType_id']."' AND compTypeSub1_id = '".$row_lv2['compTypeSub1_id']."' AND compTypeSub2_id = '".$_POST['id_del']."'";
      $query_del = $conn->query($sql_del);

      if ($query){
          echo '11';
      }else {
          echo "01";
      }
    }else{
        echo 'error';
    }
      exit();
}



 if ($_POST['method']=="get_data_complaint"){
    include("../../config/config.php");

    if($_POST['type']==1){
      $sql_select = "SELECT compType_name , compType_duration,compType_name_en ,compType_other_flag  FROM Complaint_Type where compType_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 1 ;
          $array_row['compType_name']=$result_select['compType_name'];
          $array_row['compType_name_en']=$result_select['compType_name_en'];
          $array_row['compType_duration']=$result_select['compType_duration'];
          $array_row['compType_other_flag']=$result_select['compType_other_flag'];
        }
      }
    }else if($_POST['type']==2){
      $sql_select = "SELECT compTypeSub1_name,compTypeSub1_name_en   FROM Complaint_Type_Sub1 where compTypeSub1_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 2 ;
          $array_row['compTypeSub1_name']=$result_select['compTypeSub1_name'];
          $array_row['compTypeSub1_name_en']=$result_select['compTypeSub1_name_en'];
        }
      }
    }else if ($_POST['type']==3) {
      $sql_select = "SELECT compTypeSub2_name,compTypeSub2_name_en  FROM Complaint_Type_Sub2 where compTypeSub2_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 3 ;
          $array_row['compTypeSub2_name']=$result_select['compTypeSub2_name'];
          $array_row['compTypeSub2_name_en']=$result_select['compTypeSub2_name_en'];
        }
      }
    }
        echo json_encode($array_row);
        exit();
 }

 if(isset($_GET["method"]) && $_GET["method"]=="edit_complaint"){
     include("../../config/config.php");
     if (trim($_POST['edit_name']) == '' ){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อเรื่องร้องเรียน (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['edit_name_en']) == '' ){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อเรื่องร้องเรียน (Eng)');</script><?php
       exit();
     }
    if($_POST['type']==1){
            if (trim($_POST['edit_day']) == '' ){
              ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากำหนดเวลา');</script><?php
              exit();
            }
              $sql = "  UPDATE  Complaint_Type SET
                        compType_name = '".trim($_POST['edit_name'])."',
                        compType_name_en = '".trim($_POST['edit_name_en'])."',
                        compType_duration = '".trim($_POST['edit_day'])."',
                        compType_update_datetime = '$date_setting',
                        compType_updateBy_id ='$emp_id',
                        compType_other_flag ='".$_POST['ra_other_edit']."'
                        where  compType_id = '".$_POST['id_edit']."'
                          ";
             $query = $conn->query($sql);
               if ($query){
                 ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
               }else {
                 ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
               }
    }else if($_POST['type']==2){

             $sql = " UPDATE  Complaint_Type_Sub1 SET
                      compTypeSub1_name = '".trim($_POST['edit_name'])."',
                      compTypeSub1_name_en = '".trim($_POST['edit_name_en'])."',
                      compTypeSub1_update_datetime = '$date_setting',
                      compTypeSub1_updateBy_id ='$emp_id'
                      where  compTypeSub1_id = '".$_POST['id_edit']."'  ";
             $query = $conn->query($sql);
              if ($query){
                ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
              }else {
                ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
              }
    }else if($_POST['type']==3){
            $sql = "  UPDATE  Complaint_Type_Sub2 SET
                      compTypeSub2_name = '".trim($_POST['edit_name'])."',
                      compTypeSub2_name_en = '".trim($_POST['edit_name_en'])."',
                      compTypeSub2_update_datetime = '$date_setting',
                      compTypeSub2_updateBy_id ='$emp_id'
                      where  compTypeSub2_id = '".$_POST['id_edit']."' ";
           $query = $conn->query($sql);
             if ($query){
               ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
             }else {
               ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
             }
    }
    exit();
 }

 if(isset($_GET["method"]) && $_GET["method"]=="getform"){
     $post = array();
     $request_body = file_get_contents('php://input');
     $post = json_decode($request_body);
     $response = getform($post);
     echo $response;
 exit();
 }

 function getform($post){
    include("../../config/config.php");

    $caseCh_arr = array();
    $sql_caseCh = "SELECT form_id,form_name,form_start_date,form_end_date  ";
    $sql_caseCh .= "FROM  Form_Of_Comp WHERE form_status = '0' ";

    if($post->text != ""){
      $sql_caseCh .= "AND form_name LIKE '%".$post->text."%' ";
    }
    if($post->sort=="id"){
      $sort_col = "form_id";
    }
   if($post->sort=="name"){
     $sort_col = "form_name";
   }
   if($post->sort=="day"){
     $sort_col = "form_start_date";
   }
    $day_check = date("Y-m-d");
   if( $post->status_form == "1"){
      $sql_caseCh .= "AND form_start_date <= '$day_check' AND form_end_date >= '$day_check' ";
   }
   if( $post->status_form == "2"){
       $sql_caseCh .= "AND form_start_date < '$day_check'  AND form_end_date < '$day_check'  ";
   }

   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
  //  echo $sql_caseCh;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $caseCh_col_arr["id"] = $co_id;
        $caseCh_col_arr["name"] = '<a href="?page=form_add&id='.$re['form_id'].'&val=0"><span class="txt_nol">'.$re['form_name'].'</span></a>';
        // $day_st =$re['form_start_date'];
        // $day_sp =$re['form_end_date'];

        $day_st = date("d/m/Y" , strtotime(data_filter($re['form_start_date'])));
        $day_sp = date("d/m/Y" , strtotime(data_filter($re['form_end_date'])));


        $caseCh_col_arr["day"] = '<span class="txt_nol">'.$day_st.' - '.$day_sp.'</span>';

        $sql_ch_form = "SELECT form_id  FROM Form_Link_Complaint_Type where form_id = '".$re['form_id']."'";
        $query_ch_form = $conn->query($sql_ch_form);
        if ($query_ch_form->num_rows >0) {
          $del = '<div class="th_user_edit_from"><i class="fa fa-files-o cursor txt_no_edit_non" aria-hidden="true" onclick="copy_from('.$re['form_id'].');"></i>&nbsp;&nbsp;
                  <span class="icon-ico-ditp-10 txt_no_edit"></span>&nbsp;
                  <span class="icon-ico-ditp-28 txt_no_edit"></span></div>';

        }else {
          $del = '<div class="th_user_edit_from"><i class="fa fa-files-o cursor txt_no_edit_non" aria-hidden="true" onclick="copy_from('.$re['form_id'].');"></i>&nbsp;&nbsp;
                  <a href="?page=form_add&id='.$re['form_id'].'&val=1">
                  <span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal"> </span></a>&nbsp;
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_form('.$re['form_id'].');"></span></div>';
        }
        $caseCh_col_arr["del_edit"] = $del;
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }



 if(isset($_GET["method"]) && $_GET["method"]=="getcountry"){
     $post = array();
     $request_body = file_get_contents('php://input');
     $post = json_decode($request_body);
     $response = getcountry($post);
     echo $response;
 exit();
 }

 function getcountry($post){
    include("../../config/config.php");

    $caseCh_arr = array();
    $sql_caseCh = "SELECT id,name ,flag_32,flag_128,img_path,name_th,country_enable";
    $sql_caseCh .= " FROM Country WHERE country_status = '0'  ";

    if($post->text != ""){
      $sql_caseCh .= " AND (
                            name LIKE '%".$post->text."%'
                            or name_th LIKE '%".$post->text."%'
                            ) ";
    }
    if($post->sort==""){
      $sort_col = "id";
    }
   if($post->sort=="name"){
     $sort_col = "name";
   }
   if($post->sort=="name_th"){
     $sort_col = "name_th";
   }

   $sql_caseCh .= " ORDER BY id=162 DESC, $sort_col $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0;
    // echo $sql_caseCh;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $page = $co_id + $post->offset;
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$page.'</span>';

        if ($re['flag_32']!="" && $re['flag_128']!="" ) {
          $pic_link  = "img/flags/".$re['flag_32']."";

        }else{
          if($re['img_path']==''){
            $pic_link = "";

          }else{
            $pic_link = "../".$re['img_path'];
          }
        }
        if(!file_exists('../'.$pic_link) || $pic_link =='' ) {
          $pic = '<i class="ico-flag-pri " style="background-image: url(../setting/img/default_country.png);"></i>';
        }else{
          $pic = '<i class="ico-flag-pri " style="background-image: url(../'.$pic_link.');"></i>';
        }

        $caseCh_col_arr["pic"] = $pic;


          if($re['country_enable'] == '1'){
            $view ='<span class="icon-ico-ditp-12 view_1">';
          }else{
            $view ='<span class="icon-ico-ditp-13  view_2">';
          }
        $caseCh_col_arr["view"] = $view;

        $sql_ch = "  SELECT complnt_country_id FROM `Case` WHERE `case_priority` =  '".$re['id']."'  ";
        $query_ch = $conn->query($sql_ch);
        if($query_ch->num_rows > 0){
          $no_display = 0;
          $del =  ' <span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_country('.$re['id'].',1);"></span>
                    </span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
        }else{
          $no_display = 1;
          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_country('.$re['id'].',2);"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_country('.$re['id'].');"></span>';
        }
        $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_country('.$re['id'].',0);">'.$re['name'].'</span>';
        if($re['name_th']!=''){
          $caseCh_col_arr["name_th"] = '<span class="txt_nol cursor"  onclick="edit_country('.$re['id'].',0);">'.$re['name_th'].'</span>';
        }else {
          $caseCh_col_arr["name_th"] = '<span class="txt_nol cursor"  onclick="edit_country('.$re['id'].',0);">-</span>';
        }

        $caseCh_col_arr["del_edit"] = $del;
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }

if(isset($_GET["method"]) && $_GET["method"]=="getpriority"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getpriority($post);
    echo $response;
exit();
}

  function getpriority($post){
    global $member_cls;
     include("../../config/config.php");

     $caseCh_arr = array();
     $sql_caseCh = "SELECT casePrt_id ,casePrt_name,casePrt_section,casePrt_status,casePrt_img_name,casePrt_enable,casePrt_img_path,casePrt_color ";
     $sql_caseCh .= " FROM Case_Priority WHERE casePrt_status = '0'   ";

     if($post->text != ""){
       $sql_caseCh .= "  AND casePrt_name LIKE '%".$post->text."%' ";
     }
     if($post->sort=="id"){
       $sort_col = "casePrt_id";
     }
    if($post->sort=="name"){
      $sort_col = "casePrt_name";
    }
    if($post->sort=="type"){
      $sort_col = "casePrt_id";
    }
    if($post->status_m != ""){
      $sql_caseCh .= "  AND casePrt_section = '".$post->status_m."' ";
    }

    $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
    $query_edit_pass_all = $conn->query($sql_caseCh);
    $num = $query_edit_pass_all->num_rows;
    $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
       $query_edit_pass = $conn->query($sql_caseCh);
       $co_id = 0+$post->offset;
       while ($re = $query_edit_pass->fetch_assoc()) {
         $caseCh_col_arr = array();
         $co_id++ ;
         $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
         $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_priority('.$re['casePrt_id'].',0);">'.$re['casePrt_name'].'</span>';
         $caseCh_col_arr["color"] = '<div class="color_date" style="background: '.$re['casePrt_color'].' ;"></div>';

           if($re['casePrt_enable'] == '1'){
             $view ='<span class="icon-ico-ditp-12 view_1">';
           }else{
             $view ='<span class="icon-ico-ditp-13  view_2">';
           }
           $sql_ch = "  SELECT case_priority FROM `Case` WHERE `case_priority` =  '".$re['casePrt_id']."'  ";
           $query_ch = $conn->query($sql_ch);
           if($query_ch->num_rows > 0){
             $none = 0;
             $del =   '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_priority('.$re['casePrt_id'].',1);"></span>
                      <span class="icon-ico-ditp-28 txt_no_edit"></span>';
             $caseCh_col_arr["pic"] =' <div class="box_edit_pri"><i class="ico-flag-pri_img pic_pri" style="background-image: url(../../'.$re['casePrt_img_path'].');"></i></div><div class="padd_lef">
                                       <button class="btn_up" class="sum_edit" type="file" name="button" onclick="HandleBrowseClickxc('.$re['casePrt_id'].');">
                                       <i class="fa icon-ico-ditp-10" aria-hidden="true"></i></button></div>';
           }else{
             $none = 1;
             if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"manage_system")[2]==1){

                                         $caseCh_col_arr["pic"] ='<div class="box_edit_pri"><i class="ico-flag-pri_img pic_pri" style="background-image: url(../../'.$re['casePrt_img_path'].');"></i></div><div class="padd_lef">
                                                                  <button class="btn_up" class="sum_edit" type="file" name="button" onclick="HandleBrowseClickxc('.$re['casePrt_id'].');">
                                                                  <i class="fa icon-ico-ditp-10" aria-hidden="true"></i></button></div>';
             }else{
               $caseCh_col_arr["pic"] =' <div class="box_edit_pri"><i class="ico-flag-pri_img pic_pri" style="background-image: url(../../'.$re['casePrt_img_path'].');"></i></div><div class="padd_lef">
                                         <button class="btn_up cursor_default" class="sum_edit" type="file" name="button" >
                                         <i class="fa icon-ico-ditp-10 txt_no_edit" aria-hidden="true"></i></button></div>';


              }
             $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_priority('.$re['casePrt_id'].',2);"></span>
             <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_priority('.$re['casePrt_id'].');"></span>';
           }

          if($re['casePrt_section'] == '1'){
            $type='<span class="type_general">สสบ.</span>';
          }else{
            $type ='<span class="type_law">นิติการ</span>';
          }
          $caseCh_col_arr["type"] = $type;
          $caseCh_col_arr["view"] = $view;
          $caseCh_col_arr["del_edit"] = $del;
         array_push($caseCh_arr,$caseCh_col_arr);
       }
       $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
       return json_encode($data_array);
}


if(isset($_GET["method"]) && $_GET["method"]=="add_priority"){
      include("../../config/config.php");

    if (trim($_POST['add_name']) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อระดับ Priority');</script><?php
      exit();
    }
    if ($_FILES['pic_upload']['name']==""){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกรูป');</script><?php
      exit();
    }
    if (trim($_POST['colorpicker']) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกเฉดสี');</script><?php
      exit();
    }
        if ($_FILES['pic_upload']['name']){
          $images = $_FILES["pic_upload"]["tmp_name"];
          $image_type = $_FILES['pic_upload']['type'];
          if ($image_type=="image/jpeg"){
            ?><script type="text/javascript">parent.iziToast_func.alert("ICON (.PNG .gif) ONLY");</script><?php
            exit();
          }
          if ($image_type=="image/png"){
            $image_set_type = "png";

          }
          if ($image_type=="image/gif"){
            $image_set_type = "gif";
          }

          $size=GetimageSize($images);
          if ($size[0]!=100 || $size[1]!=100)
          {
            ?><script type="text/javascript">parent.iziToast_func.alert("Icon size (100x100)px Only");</script><?php
            exit();
          }
        }

    if ($_POST['radio_section'] == 1){
        $section = '1';
    }else{
        $section = '2';
    }
    if ($_POST['status'] == 1){
        $status = '1';
    }else{
        $status = '0';
    }

$colorpicker = data_filter(trim($_POST['colorpicker']));
$add_name = data_filter(trim($_POST['add_name']));

    $sql = " INSERT INTO Case_Priority  (casePrt_name,casePrt_section,casePrt_enable,casePrt_create_datetime,casePrt_createBy_id,casePrt_color)
            VALUES ('$add_name','$section','$status','$date_setting','$emp_id','$colorpicker') ";
     $query = $conn->query($sql);
     $last_id_priority = $conn->insert_id;
     if ($query){
       if($image_set_type != ''){

        if (!is_dir("../../data/setting")){
              mkdir("../../data/setting", 0775, true);
        }
        if (!is_dir("../../data/setting/priority")){
            mkdir("../../data/setting/priority", 0775, true);
        }
        if (!is_dir("../../data/setting/priority")){
            mkdir("../../data/setting/priority", 0775, true);
        }
        if (!is_dir("../../data/setting/priority".$last_id_priority)){
            mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
        }

        if (!is_dir("../../data/setting/priority".$last_id_priority)){
            mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
        }
        if (!is_dir("../../data/setting/priority".$last_id_priority."/l")){
            mkdir("../../data/setting/priority/".$last_id_priority."/l", 0775, true);
        }

        if (!is_dir("../../data/setting/priority".$last_id_priority."/s")){
            mkdir("../../data/setting/priority/".$last_id_priority."/s", 0775, true);
        }


      $new_images =  uniqid().'.'.$image_set_type;


      $file_size_s = "../../data/setting/priority/".$last_id_priority."/s/";
      $file_size_l = "../../data/setting/priority/".$last_id_priority."/l/";

      copy($_FILES["pic_upload"]["tmp_name"],"../../data/setting/priority/".$last_id_priority."/".$new_images);
      $images = "../../data/setting/priority/".$last_id_priority."/".$new_images;
      $images_insert = "data/setting/priority/".$last_id_priority."/s/".$new_images;


      $sql_update = "UPDATE `Case_Priority` SET `casePrt_img_name` = '".$new_images."', casePrt_img_path = '$images_insert' WHERE `casePrt_id` = '".$last_id_priority."'";
      $query_update = $conn->query($sql_update);



     $image_l_size=80;
     $image_s_size=40;

      //$size = GetimageSize($images);
      list($w, $h) = GetimageSize($images);
      $extension = $image_set_type;
      // if($extension=="jpg" || $extension=="jpeg"){
      //   $images_orig = imagecreatefromjpeg($images);
      //   $images_origs = imagecreatefromjpeg($images);
      // }

      if($extension=="png"){

        $images_orig = imagecreatefrompng($images);
        $images_origs = imagecreatefrompng($images);
      }
      if ($extension=="gif"){
        $images_orig = imagecreatefromgif($images);
        $images_origs = imagecreatefromgif($images);
      }


      //---- l size -- //
      $height=round($image_l_size*$h/$w);
      $photoX = ImagesX($images_orig);
      $photoY = ImagesY($images_orig);

      $images_fin = ImageCreateTrueColor($image_l_size, $height);
      // แก้พื้นหลังสีดำ
      imagealphablending($images_fin, false);
      imagesavealpha($images_fin, true);
      // แก้พื้นหลังสีดำ
      ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $image_l_size+1, $height+1, $photoX, $photoY);
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
      $heights=round($image_s_size*$h/$w);
      $photoXs = ImagesX($images_origs);
      $photoYs = ImagesY($images_origs);
      $images_fins = ImageCreateTrueColor($image_s_size, $heights);
      // แก้พื้นหลังสีดำ
      imagealphablending($images_fins, false);
      imagesavealpha($images_fins, true);
      // แก้พื้นหลังสีดำ
      ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $image_s_size+1, $heights+1, $photoXs, $photoYs);
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
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
     }else {
       ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
     }
     exit();
}


if($_POST['method']=='get_form'){
    include("../../config/config.php");
    $_POST['search_text'] = mysqli_real_escape_string($conn, $_POST['search_text']);
    $_POST['id_ch1'] = mysqli_real_escape_string($conn, $_POST['id_ch1']);
    $_POST['id_ch2'] = mysqli_real_escape_string($conn, $_POST['id_ch2']);
    $_POST['id_ch3'] = mysqli_real_escape_string($conn, $_POST['id_ch3']);
  	?>

    <ul id="sortable_main" class="sortable">
      <?php
      $sql_select = "SELECT frmset_name,frmset_id,frmset_type FROM Form_Set WHERE 1 ";

      if ($_POST['search_text']!=""){
         $sql_select .= " AND frmset_name LIKE '%".$_POST['search_text']."%' ";
      }
      if ($_POST['id_ch1']!=""){
         $sql_select .= " AND frmset_id  NOT IN (".$_POST['id_ch1'].") ";
      }
      if ($_POST['id_ch2']!=""){
         $sql_select .= " AND frmset_id  NOT IN (".$_POST['id_ch2'].") ";
      }
      if ($_POST['id_ch3'] != ""){
         $sql_select .= " AND frmset_id  NOT IN (".$_POST['id_ch3'].") ";
      }

      $query_select = $conn->query($sql_select);
        while ( $re =   $query_select->fetch_assoc()) {

          ?>
      <li class="ui-state-default li_form " value="<?=$re['frmset_id']?>" rel="<?php echo $re["frmset_type"] ?>">
        <input type="hidden" id="txt_id" name="type_from[]" value="<?=$re['frmset_id']?>">
        <input type="hidden" name="id_form[]" value="<?=$re['frmset_id']?>">
        <span class="span_form"><i class="fa fa-tasks" aria-hidden="true"></i>
        </span><?=$re['frmset_name']?>
      </li>
    <?php } ?>
    </ul>

  	<?php
  	exit();
  }




if(isset($_GET["method"]) && $_GET["method"]=="add_form"){
    include("../../config/config.php");

  if (trim($_POST['title_name']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อฟอร์ม');</script><?php
    exit();
  }
  if ($_POST['date_start'] == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่วันเริ่มต้นใช้งานฟอร์ม');</script><?php
    exit();
  }
  if ($_POST['date_stop'] == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่วันสิ้นสุดฟอร์ม');</script><?php
    exit();
  }

  for($i=0;$i<3;$i++){
    if (trim($_POST['part_name'][$i]) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ข้อมูลส่วนที่  <?php echo $i+'1';?> (ไทย)');</script><?php
      exit();
    }
    if (trim($_POST['part_name_en'][$i]) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ข้อมูลส่วนที่  <?php echo $i+'1';?> (Eng)');</script><?php
      exit();
    }
  }

  if (trim($_POST['check_edit']) == '' ){
    if (trim($_POST['countFormset']) < 3  ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกฟอร์ม');</script><?php
      exit();
    }
  }else{
    if (trim($_POST['countFormset']) != 0  ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกฟอร์ม');</script><?php
      exit();
    }
  }


  $title_name = data_filter($_POST['title_name']);

  $date_start = DateTime::createFromFormat('d/m/Y', data_filter(trim($_POST['date_start'])))->format('Y-m-d');
  $date_stop = DateTime::createFromFormat('d/m/Y', data_filter(trim($_POST['date_stop'])))->format('Y-m-d');

  if (trim($_POST['check_edit']) == '' ){

    $sql_form = " INSERT INTO Form_Of_Comp  (form_name,form_start_date,form_end_date,form_create_datetime,form_createBy_id)
                  VALUES ('$title_name','$date_start','$date_stop','$date_setting','$emp_id') ";
    $query_form  = $conn->query($sql_form);
    $last_id_form  = $conn->insert_id;
// exit();
    for($i=0;$i<3;$i++){

      $part_name =    data_filter($_POST["part_name"][$i]);
      $part_name_en =    data_filter($_POST["part_name_en"][$i]);
      $id_form =      data_filter($_POST["id_form"][$i]);
      $type_from =    data_filter($_POST["type_from"][$i]);

      $sql_Comp = " INSERT INTO  Field_Form_Of_Comp  (form_id,field_name,field_name_en,frmset_id,frmset_type)
                              VALUES ('$last_id_form','$part_name','$part_name_en','$id_form','$type_from')";
                              $query_Comp = $conn->query($sql_Comp);
    }


  }else{
    $sql_edit = "UPDATE Form_Of_Comp SET
                        form_name = '$title_name'
                        ,form_start_date   = '$date_start'
                        ,form_end_date = '$date_stop'
                        ,form_edit_datetime = '$date_setting'
                        ,form_updateBy_id = '$emp_id'
                        where  form_id = '".$_POST['id']."'";
    $query_edit  = $conn->query($sql_edit);


for($i=0;$i<3;$i++){

  $part_name =    data_filter($_POST["part_name"][$i]);
  $part_name_en =    data_filter($_POST["part_name_en"][$i]);
  $id_form =      data_filter($_POST["id_form"][$i]);
  $type_from =    data_filter($_POST["type_from"][$i]);



    $sql_comp = "UPDATE Field_Form_Of_Comp SET
                        field_name = '$part_name' ,
                        field_name_en = '$part_name_en' ,
                        frmset_id   = '$id_form'
                        where  form_id = '".$_POST['id']."'
                        AND frmset_type  = '$type_from' ";
    $query_comp  = $conn->query($sql_comp);

}
  }

   if ($query_Comp ||  $query_comp){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.location.href='index.php?page=form';</script><?php
   }else {
     ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();

}


  if(isset($_GET["method"]) && $_GET["method"]=="select_formset"){
      include("../../config/config.php");

    if($_POST['id_ch_day']!=''){
      ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
      exit();
    }
    if (trim($_POST['form_set']) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกฟอร์ม');</script><?php
      exit();
    }

    $form_set = data_filter($_POST["form_set"]);
    $id_add1 = data_filter($_POST["id_add1"]);
    $id_add2 = data_filter($_POST["id_add2"]);
    $id_add3 = data_filter($_POST["id_add3"]);

    if (trim($_POST['type_from']) == '1' ){

      $sql_edit_pass = "UPDATE Complaint_Type SET  form_id = '$form_set' where compType_id = '$id_add1' ";
      $query_edit_pass = $conn->query($sql_edit_pass);

    }else if(trim($_POST['type_from']) == '2' ){

      $sql_edit_pass = "UPDATE Complaint_Type_Sub1 SET form_id = '$form_set' where compTypeSub1_id = '$id_add2' ";
      $query_edit_pass = $conn->query($sql_edit_pass);

    }else if(trim($_POST['type_from']) == '3' ){

      $sql_edit_pass = "UPDATE  Complaint_Type_Sub2 SET form_id = '$form_set' where compTypeSub2_id = '$id_add3' ";
      $query_edit_pass = $conn->query($sql_edit_pass);

    }

  if($_POST['add_edit']==1){
    $sql_select = "SELECT field_id,frmset_id ,field_name,field_name_en  FROM Field_Form_Of_Comp where form_id = '$form_set'  ORDER BY field_id ASC ";
    $query_select = $conn->query($sql_select);
    if ($query_select->num_rows >0)
    {
      while($result_select = $query_select->fetch_assoc()){

        $sql_Complaint_Type = " INSERT INTO  Form_Link_Complaint_Type  (compType_id , compTypeSub1_id, compTypeSub2_id, frmset_id, frmset_name , frmset_name_en , form_id, field_id )
                                VALUES ('$id_add1','$id_add2','$id_add3','".$result_select['frmset_id']."','".$result_select['field_name']."','".$result_select['field_name_en']."', '$form_set' ,'".$result_select['field_id']."') ";
        $query_Complaint_Type = $conn->query($sql_Complaint_Type);
      }
    }
  }else if($_POST['add_edit']==2){

    $day_check = date("Y-m-d");
    $sql_select = "SELECT field_id,frmset_id ,field_name ,field_name_en  FROM Field_Form_Of_Comp where form_id = '$form_set'  ORDER BY field_id ASC ";
    $query_select = $conn->query($sql_select);
      while($result_select = $query_select->fetch_assoc()){
      $field_id[] = $result_select['field_id'];
      $frmset_id[]= $result_select['frmset_id'];
      $field_name[] = $result_select['field_name'];
      $field_name_en[] = $result_select['field_name_en'];

    }

    $sql_type = "SELECT frmCompType_id FROM Form_Link_Complaint_Type
                 where compType_id = '$id_add1' AND compTypeSub1_id = '$id_add2' AND compTypeSub2_id = '$id_add3'  ORDER BY frmCompType_id ASC ";
    $query_type = $conn->query($sql_type);
    if ($query_type->num_rows >0) {
    $co = 0;
        while($result_type = $query_type->fetch_assoc()){
                  $sql_edit_pass = "UPDATE   Form_Link_Complaint_Type
                                    SET
                                    frmset_id   = '".$frmset_id[$co]."'
                                    ,frmset_name  = '".$field_name[$co]."'
                                    ,frmset_name_en  = '".$field_name_en[$co]."'
                                    ,form_id  =  '$form_set'
                                    ,field_id  = '".$field_id[$co]."'
                                    where frmCompType_id = '".$result_type['frmCompType_id']."' ";
                                    // exit();
                  $query_edit_pass = $conn->query($sql_edit_pass);
                  $co++;
        }
      }
  }
     if ($query_edit_pass){
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
     }else {
       ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
     }
     exit();
}



if(isset($_GET["method"]) && $_GET["method"]=="copy_from"){
    include("../../config/config.php");

  if (trim($_POST['new_name']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อฟอร์ม');</script><?php
    exit();
  }
  if (trim($_POST['date_start_copy']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกระยะเวลาใช้งานฟอร์ม');</script><?php
    exit();
  }
  if (trim($_POST['date_stop_copy']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกระยะเวลาใช้งานฟอร์ม');</script><?php
    exit();
  }
    $cop_id = data_filter($_POST["cop_id"]);
    $new_name = data_filter($_POST["new_name"]);
    $date_start_copy = DateTime::createFromFormat('d/m/Y', data_filter(trim($_POST['date_start_copy'])))->format('Y-m-d');
    $date_stop_copy = DateTime::createFromFormat('d/m/Y', data_filter(trim($_POST['date_stop_copy'])))->format('Y-m-d');

        $sql_Complaint_Type = " INSERT INTO  Form_Of_Comp  (form_name,form_start_date,form_end_date,form_create_datetime,form_createBy_id)
                                VALUES ('$new_name','$date_start_copy','$date_stop_copy','$date_setting','$emp_id') ";
        $query_Complaint_Type = $conn->query($sql_Complaint_Type);
        $last_id_copy = $conn->insert_id;

        $sql_select = "SELECT frmset_type,frmset_id ,field_name  FROM Field_Form_Of_Comp where form_id = '$cop_id'  ORDER BY field_id ASC ";
        $query_select = $conn->query($sql_select);

          while($result_select = $query_select->fetch_assoc()){

            $sql_Comp = " INSERT INTO  Field_Form_Of_Comp  (form_id,field_name,frmset_id,frmset_type)
                          VALUES ('$last_id_copy','".$result_select['field_name']."','".$result_select['frmset_id']."','".$result_select['frmset_type']."')";
                          $query_Comp = $conn->query($sql_Comp);
          }
   if ($query_Comp){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
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

if ($_POST['method']=="del_form"){
     include("../../config/config.php");
     $sql_del = "UPDATE Form_Of_Comp SET form_status = '1' where  form_id = '".$_POST['id_p']."'";
      $query_del = $conn->query($sql_del);
      if ($query_del){
          echo '00';
      }else {
          echo "01";
      }
      exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="add_priority_edit_pic"  && $_FILES['pic_upload']['name'] !='' ){

          if ($_FILES['pic_upload']['name']){
            $images = $_FILES["pic_upload"]["tmp_name"];
            $image_type = $_FILES['pic_upload']['type'];
            if ($image_type=="image/jpeg"){
              ?><script type="text/javascript">parent.iziToast_func.alert("ICON (.PNG .gif) ONLY");</script><?php
              exit();
            }
            if ($image_type=="image/png"){
              $image_set_type = "png";

            }
            if ($image_type=="image/gif"){
              $image_set_type = "gif";
            }

            $size=GetimageSize($images);
            if ($size[0]!=100 || $size[1]!=100)
            {
              ?><script type="text/javascript">parent.iziToast_func.alert("Icon size (100x100)px Only");</script><?php
              exit();
            }
          }

          $last_id_priority =   data_filter($_POST["id"]);
         if($image_set_type != ''){
           deleteDirectory("../../data/setting/priority/".$last_id_priority);
          if (!is_dir("../../data/setting")){
                mkdir("../../data/setting", 0775, true);
          }
          if (!is_dir("../../data/setting/priority")){
              mkdir("../../data/setting/priority", 0775, true);
          }
          if (!is_dir("../../data/setting/priority")){
              mkdir("../../data/setting/priority", 0775, true);
          }
          if (!is_dir("../../data/setting/priority".$last_id_priority)){
              mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
          }

          if (!is_dir("../../data/setting/priority".$last_id_priority)){
              mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
          }
          if (!is_dir("../../data/setting/priority".$last_id_priority."/l")){
              mkdir("../../data/setting/priority/".$last_id_priority."/l", 0775, true);
          }

          if (!is_dir("../../data/setting/priority".$last_id_priority."/s")){
              mkdir("../../data/setting/priority/".$last_id_priority."/s", 0775, true);
          }


        $new_images =  uniqid().'.'.$image_set_type;


        $file_size_s = "../../data/setting/priority/".$last_id_priority."/s/";
        $file_size_l = "../../data/setting/priority/".$last_id_priority."/l/";

        copy($_FILES["pic_upload"]["tmp_name"],"../../data/setting/priority/".$last_id_priority."/".$new_images);
        $images = "../../data/setting/priority/".$last_id_priority."/".$new_images;
        $images_insert = "data/setting/priority/".$last_id_priority."/s/".$new_images;


      echo  $sql_update = "UPDATE `Case_Priority` SET `casePrt_img_name` = '".$new_images."', casePrt_img_path = '$images_insert' WHERE `casePrt_id` = '".$_POST['id']."'";
        $query_update = $conn->query($sql_update);

       $image_l_size=80;
       $image_s_size=40;

        //$size = GetimageSize($images);
        list($w, $h) = GetimageSize($images);
        $extension = $image_set_type;
        // if($extension=="jpg" || $extension=="jpeg"){
        //   $images_orig = imagecreatefromjpeg($images);
        //   $images_origs = imagecreatefromjpeg($images);
        // }

        if($extension=="png"){

          $images_orig = imagecreatefrompng($images);
          $images_origs = imagecreatefrompng($images);
        }
        if ($extension=="gif"){
          $images_orig = imagecreatefromgif($images);
          $images_origs = imagecreatefromgif($images);
        }


        //---- l size -- //
        $height=round($image_l_size*$h/$w);
        $photoX = ImagesX($images_orig);
        $photoY = ImagesY($images_orig);

        $images_fin = ImageCreateTrueColor($image_l_size, $height);
        // แก้พื้นหลังสีดำ
        imagealphablending($images_fin, false);
        imagesavealpha($images_fin, true);
        // แก้พื้นหลังสีดำ
        ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $image_l_size+1, $height+1, $photoX, $photoY);
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
        $heights=round($image_s_size*$h/$w);
        $photoXs = ImagesX($images_origs);
        $photoYs = ImagesY($images_origs);
        $images_fins = ImageCreateTrueColor($image_s_size, $heights);
        // แก้พื้นหลังสีดำ
        imagealphablending($images_fins, false);
        imagesavealpha($images_fins, true);
        // แก้พื้นหลังสีดำ
        ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $image_s_size+1, $heights+1, $photoXs, $photoYs);
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
      if ($query_update){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
       }else {
         ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }
       exit();

}


 if ($_POST['method']=="get_data_priority"){
    include("../../config/config.php");
        $sql_select = "SELECT * FROM Case_Priority where casePrt_id = '".$_POST['id']."'";
        $query_select = $conn->query($sql_select);
        $array_row = array();
        if ($query_select->num_rows >0)
        {
          while($result_select = $query_select->fetch_assoc())
          {
            $array_row['casePrt_name']=$result_select['casePrt_name'];
            $array_row['casePrt_section']=$result_select['casePrt_section'];
            $array_row['casePrt_color']=$result_select['casePrt_color'];
            $array_row['casePrt_enable']=$result_select['casePrt_enable'];
          }
        }
        echo json_encode($array_row);
        exit();
 }


 if(isset($_GET["method"]) && $_GET["method"]=="save_priority"){
       include("../../config/config.php");

     if (trim($_POST['edit_name']) == '' ){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาใส่ชื่อระดับ Priority');</script><?php
       exit();
     }
     if (trim($_POST['colorpicker_edit']) == '' ){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกเฉดสี');</script><?php
       exit();
     }
         if ($_FILES['priority_edit']['name']){
           $images = $_FILES["priority_edit"]["tmp_name"];
           $image_type = $_FILES['priority_edit']['type'];
           if ($image_type=="image/jpeg"){
             ?><script type="text/javascript">parent.iziToast_func.alert("ICON (.PNG .gif) ONLY");</script><?php
             exit();
           }
           if ($image_type=="image/png"){
             $image_set_type = "png";

           }
           if ($image_type=="image/gif"){
             $image_set_type = "gif";
           }

           $size=GetimageSize($images);
           if ($size[0]!=100 || $size[1]!=100)
           {
             ?><script type="text/javascript">parent.iziToast_func.alert("Icon size (100x100)px Only");</script><?php
             exit();
           }
         }

     if ($_POST['radio_section'] == 1){
         $section = '1';
     }else{
         $section = '2';
     }


   $colorpicker = data_filter(trim($_POST['colorpicker_edit']));
   $edit_name = data_filter(trim($_POST['edit_name']));
    $sql_update = " UPDATE Case_Priority
                    SET casePrt_name = '$edit_name'
                        ,casePrt_section = '$section'
                        ,casePrt_color = '$colorpicker'
                    WHERE `casePrt_id` = '".$_POST['id_edit']."' ";
    $query_update = $conn->query($sql_update);

      $last_id_priority = $_POST['id_edit'];
      if($_FILES['priority_edit']['name'] != ''){
        if($image_set_type != ''){

         if (!is_dir("../../data/setting")){
               mkdir("../../data/setting", 0775, true);
         }
         if (!is_dir("../../data/setting/priority")){
             mkdir("../../data/setting/priority", 0775, true);
         }
         if (!is_dir("../../data/setting/priority")){
             mkdir("../../data/setting/priority", 0775, true);
         }
         if (!is_dir("../../data/setting/priority".$last_id_priority)){
             mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
         }

         if (!is_dir("../../data/setting/priority/".$last_id_priority)){
             mkdir("../../data/setting/priority/".$last_id_priority, 0775, true);
         }
         if (!is_dir("../../data/setting/priority/".$last_id_priority."/l")){
             mkdir("../../data/setting/priority/".$last_id_priority."/l", 0775, true);
         }

         if (!is_dir("../../data/setting/priority/".$last_id_priority."/s")){
             mkdir("../../data/setting/priority/".$last_id_priority."/s", 0775, true);
         }


       $new_images =  uniqid().'.'.$image_set_type;


       $file_size_s = "../../data/setting/priority/".$last_id_priority."/s/";
       $file_size_l = "../../data/setting/priority/".$last_id_priority."/l/";

       copy($_FILES["priority_edit"]["tmp_name"],"../../data/setting/priority/".$last_id_priority."/".$new_images);
       $images = "../../data/setting/priority/".$last_id_priority."/".$new_images;

       $sql_update = "UPDATE `Case_Priority` SET `casePrt_img_name` = '".$new_images."', casePrt_img_path = '$images' WHERE `casePrt_id` = '".$last_id_priority."'";
       $query_update = $conn->query($sql_update);


      $image_l_size=80;
      $image_s_size=40;

       //$size = GetimageSize($images);
       list($w, $h) = GetimageSize($images);
       $extension = $image_set_type;
       // if($extension=="jpg" || $extension=="jpeg"){
       //   $images_orig = imagecreatefromjpeg($images);
       //   $images_origs = imagecreatefromjpeg($images);
       // }

       if($extension=="png"){

         $images_orig = imagecreatefrompng($images);
         $images_origs = imagecreatefrompng($images);
       }
       if ($extension=="gif"){
         $images_orig = imagecreatefromgif($images);
         $images_origs = imagecreatefromgif($images);
       }


       //---- l size -- //
       $height=round($image_l_size*$h/$w);
       $photoX = ImagesX($images_orig);
       $photoY = ImagesY($images_orig);

       $images_fin = ImageCreateTrueColor($image_l_size, $height);
       // แก้พื้นหลังสีดำ
       imagealphablending($images_fin, false);
       imagesavealpha($images_fin, true);
       // แก้พื้นหลังสีดำ
       ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $image_l_size+1, $height+1, $photoX, $photoY);
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
       $heights=round($image_s_size*$h/$w);
       $photoXs = ImagesX($images_origs);
       $photoYs = ImagesY($images_origs);
       $images_fins = ImageCreateTrueColor($image_s_size, $heights);
       // แก้พื้นหลังสีดำ
       imagealphablending($images_fins, false);
       imagesavealpha($images_fins, true);
       // แก้พื้นหลังสีดำ
       ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $image_s_size+1, $heights+1, $photoXs, $photoYs);
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
      }
      if($query_update){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
      }else {
        ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
      }
      exit();
 }




 if(isset($_GET["method"]) && $_GET["method"]=="add_country"){
       include("../../config/config.php");


       if (trim($_POST['add_name_th']) == '' ){
         ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อภาษาไทย');</script><?php
         exit();
       }
       if (trim($_POST['add_name_en']) == '' ){
         ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อภาษาอังกฤษ');</script><?php
         exit();
       }
       if (trim($_POST['continent_code']) == '' ){
         ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกทวีป');</script><?php
         exit();
       }


if($_POST['id_edit']==''){
      if ($_FILES['add_pic_countyr']['name']==""){
        ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกรูป');</script><?php
        exit();
      }
}

         if ($_FILES['add_pic_countyr']['name']){
           $images = $_FILES["add_pic_countyr"]["tmp_name"];
           $image_type = $_FILES['add_pic_countyr']['type'];
           if ($image_type=="image/jpeg"){
             ?><script type="text/javascript">parent.iziToast_func.alert("ICON (.PNG .gif) ONLY");</script><?php
             exit();
           }
           if ($image_type=="image/png"){
             $image_set_type = "png";

           }
           if ($image_type=="image/gif"){
             $image_set_type = "gif";
           }

           $size=GetimageSize($images);
           if ($size[0]!=100 || $size[1]!=100)
           {
             ?><script type="text/javascript">//alert("Icon size (100x100)px Only");</script><?php
             //exit();
           }
         }

     if ($_POST['radio_country'] == 1){
         $status = '1';
     }else{
         $status = '0';
     }

     $add_name_th = data_filter(trim($_POST['add_name_th']));
     $add_name_en = data_filter(trim($_POST['add_name_en']));
     $continent_code = data_filter(trim($_POST['continent_code']));

    if($_POST['id_edit']==''){
      $sql_chk = "SELECT * Country WHERE name='$add_name_en' ";
      $query_chk = $conn->query($sql_chk);
      $num_chk = $query_chk->num_rows;
      if($num_chk==0){
        $sql = " INSERT INTO  Country  (name_th,name,country_enable,continent_code) VALUES ('$add_name_th','$add_name_en','$status','$continent_code') ";
        $query = $conn->query($sql);
        $last_id_country = $conn->insert_id;
      }else{
        ?><script type="text/javascript">parent.iziToast_func.alert('ขื่อประเทศ มีอยู่ในระบบแล้ว <?php echo $add_name_en ?> กรุณาระบุชื่อประเทศใหม่');</script><?php
      }
    }else {
      $sql_chk = "SELECT * Country WHERE name='$add_name_en' AND id != '".$_POST['id_edit']."' ";
      $query_chk = $conn->query($sql_chk);
      $num_chk = $query_chk->num_rows;
      if($num_chk==0){
        $sql = " UPDATE Country SET name_th = '$add_name_th', name = '$add_name_en' , country_enable = '$status' , continent_code = '$continent_code' WHERE id = '".$_POST['id_edit']."' ";
        $query_up = $conn->query($sql);
        $last_id_country = $_POST['id_edit'];
      }else{
        ?><script type="text/javascript">parent.iziToast_func.alert('ขื่อประเทศ มีอยู่ในระบบแล้ว <?php echo $add_name_en ?> กรุณาระบุชื่อประเทศใหม่');</script><?php
      }
    }
      if($_FILES['add_pic_countyr']['name'] != ''){
        if($image_set_type != ''){
          $folder = 'country';
          create_case_direatory($folder,$last_id_country);

          $new_images =  uniqid().'.'.$image_set_type;

          $file_size_s = "../../data/setting/".$folder."/".$last_id_country."/s/";
          $file_size_l = "../../data/setting/".$folder."/".$last_id_country."/l/";

          copy($_FILES["add_pic_countyr"]["tmp_name"],"../../data/setting/".$folder."/".$last_id_country."/".$new_images);
          $images = "../../data/setting/".$folder."/".$last_id_country."/".$new_images;
          $images_nol =  "data/setting/".$folder."/".$last_id_country."/s/".$new_images;
          $sql_update = "UPDATE `Country` SET `img_name` = '".$new_images."', img_path = '$images_nol' WHERE `id` = '".$last_id_country."'";
          $query_update = $conn->query($sql_update);

          resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images);
      }
    }

      if($query || $query_up){
        if($query){
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        }else{
          ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        }
      }else {
        ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
      }
      exit();
 }

function create_case_direatory($folder,$last_id_country){

  deleteDirectory("../../data/setting/".$folder."/".$last_id_country);

  if (!is_dir("../../data/setting")){
        mkdir("../../data/setting", 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."")){
      mkdir("../../data/setting/".$folder."", 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."")){
      mkdir("../../data/setting/".$folder."", 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."/".$last_id_country)){
      mkdir("../../data/setting/".$folder."/".$last_id_country, 0775, true);
  }

  if (!is_dir("../../data/setting/".$folder."/".$last_id_country)){
      mkdir("../../data/setting/".$folder."/".$last_id_country, 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."/".$last_id_country."/l")){
      mkdir("../../data/setting/".$folder."/".$last_id_country."/l", 0775, true);
  }

  if (!is_dir("../../data/setting/".$folder."/".$last_id_country."/s")){
      mkdir("../../data/setting/".$folder."/".$last_id_country."/s", 0775, true);
  }
}

function resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images){
      $image_l_size=80;
      $image_s_size=40;

       //$size = GetimageSize($images);
       list($w, $h) = GetimageSize($images);
       $extension = $image_set_type;
       // if($extension=="jpg" || $extension=="jpeg"){
       //   $images_orig = imagecreatefromjpeg($images);
       //   $images_origs = imagecreatefromjpeg($images);
       // }

       if($extension=="png"){

         $images_orig = imagecreatefrompng($images);
         $images_origs = imagecreatefrompng($images);
       }
       if ($extension=="gif"){
         $images_orig = imagecreatefromgif($images);
         $images_origs = imagecreatefromgif($images);
       }


       //---- l size -- //
       $height=round($image_l_size*$h/$w);
       $photoX = ImagesX($images_orig);
       $photoY = ImagesY($images_orig);

       $images_fin = ImageCreateTrueColor($image_l_size, $height);
       // แก้พื้นหลังสีดำ
       imagealphablending($images_fin, false);
       imagesavealpha($images_fin, true);
       // แก้พื้นหลังสีดำ
       ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $image_l_size+1, $height+1, $photoX, $photoY);
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
       $heights=round($image_s_size*$h/$w);
       $photoXs = ImagesX($images_origs);
       $photoYs = ImagesY($images_origs);
       $images_fins = ImageCreateTrueColor($image_s_size, $heights);
       // แก้พื้นหลังสีดำ
       imagealphablending($images_fins, false);
       imagesavealpha($images_fins, true);
       // แก้พื้นหลังสีดำ
       ImageCopyResampled($images_fins, $images_origs, 0, 0, 0, 0, $image_s_size+1, $heights+1, $photoXs, $photoYs);
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


if ($_POST['method']=="del_priority"){
   include("../../config/config.php");

    $sql_edit_pass = "UPDATE  Case_Priority SET casePrt_status = '1' where  casePrt_id = '".$_POST['id_p']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
        echo '00';
    }else {
        echo "01";
    }
    exit();
}

if ($_POST['method']=="del_country"){
   include("../../config/config.php");

    $sql_edit_pass = "UPDATE  Country SET country_status = '1' where  id = '".$_POST['id_p']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
        echo '00';
    }else {
        echo "01";
    }
    exit();
}

if ($_POST['method']=="get_data_country"){
   include("../../config/config.php");

       $sql_select = "SELECT c.id , c.name_th,c.name,c.continent_code,c.country_enable,c.flag_128,c.flag_32,c.img_path
                      FROM Country c
                      LEFT JOIN Continents cn ON (c.continent_code=cn.code)
                      where c.id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['id']=$result_select['id'];
           $array_row['name_th']=$result_select['name_th'];
           $array_row['name']=$result_select['name'];
           $array_row['country_enable']=$result_select['country_enable'];
           $array_row['continent_code']=$result_select['continent_code'];


           if ($result_select['flag_32']!="" && $result_select['flag_128']!="" ) {
             $pic_link  = "img/flags/".$result_select['flag_32']."";

           }else{
             if($result_select['img_path']==''){
               $pic_link = "";

             }else{
               $pic_link = "../".$result_select['img_path'];
             }
           }
           if(!file_exists('../'.$pic_link) || $pic_link =='' ) {
             $pic = '<i class="ico-flag-pre hie_edit" style="background-image: url(../setting/img/default_country.png);"></i>';
           }else{
             $pic = '<i class="ico-flag-pre hie_edit"  style="background-image: url(../'.$pic_link.');"></i>';
           }
            $array_row['pic']=$pic;
            $array_row['path_view']= "../".$pic_link;
         }
       }
       echo json_encode($array_row);
       exit();
}



if(isset($_GET["method"]) && $_GET["method"]=="getholiday"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getholiday($post);
    echo $response;
exit();
}

function getholiday($post){
   include("../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT holiday_id,holiday_name,holiday_date_start,holiday_date_end,holiday_year,holiday_date_amount  ";
   $sql_caseCh .= "FROM  PublicHoliday WHERE holiday_status = '0' ";

   if($post->text != ""){
     $sql_caseCh .= "AND holiday_name LIKE '%".$post->text."%' ";
   }
   if($post->type_section != ""){
     $sql_caseCh .= "AND holiday_year = '".$post->type_section."' ";
   }
   if($post->sort=="id"){
     $sort_col = "holiday_id";
   }
  if($post->sort=="name"){
    $sort_col = "holiday_name";
  }
  if($post->sort=="date"){
    $sort_col = "holiday_date_start";
  }
  if($post->sort=="year"){
    $sort_col = "holiday_year";
  }
  if($post->sort=="day"){
    $sort_col = "holiday_date_amount";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0+$post->offset;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;

      $caseCh_col_arr["view"] = $view;

      $sql_ch = "   SELECT p.process_type_id FROM `Case` AS c
                    LEFT JOIN `Process` AS p ON c.case_id = p.case_id
                    LEFT JOIN `Process_Type` AS pt ON pt.process_type_id = p.process_type_id
                    where p.process_type_id = '".$re['process_type_id']."'  ";
      $query_ch = $conn->query($sql_ch);
      if($query_ch->num_rows > 0){
        $del =    '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal">
                  </span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
      }else{
        $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_holiday('.$re['holiday_id'].',1);"></span>
                <span class="icon-ico-ditp-28 cursor txt_no_del" onclick="ConfirmDelete()&&del_holiday('.$re['holiday_id'].');"></span>';
      }
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_holiday('.$re['holiday_id'].',0);">'.$re['holiday_name'].'</span>';

       $date_start = date("d/m/Y" , strtotime(data_filter($re['holiday_date_start'])));
       $date_stop = date("d/m/Y" , strtotime(data_filter($re['holiday_date_end'])));


       $caseCh_col_arr["date"] = '<span class="txt_nol">'.$date_start.' - '.$date_stop.'</span>';
       $caseCh_col_arr["year"] = '<span class="txt_nol">'.$re['holiday_year'].'</span>';
       $caseCh_col_arr["day"] = '<span class="txt_nol">'.$re['holiday_date_amount'].'</span>';
      $dy =  date("Y-m-d");
       if($dy < $re['holiday_date_start']){
       $caseCh_col_arr["del_edit"] = $del;
     }else{
       $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
       $caseCh_col_arr["del_edit"] = $del;
     }
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}


if(isset($_GET["method"]) && $_GET["method"]=="add_holiday"){

    include("../../config/config.php");

  if (trim($_POST['year']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกปี');</script><?php
    exit();
  }
  if (trim($_POST['add_name']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อ');</script><?php
    exit();
  }
  if (trim($_POST['date_start']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากำหนดเวลาเริ่มต้น');</script><?php
    exit();
  }
  if (trim($_POST['date_stop']) == '' ){
    ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากำหนดเวลาสิ้นสุด');</script><?php
    exit();
  }

  if ($_POST['date_start'] > $_POST['date_stop']){
    ?><script type="text/javascript">parent.iziToast_func.alert('วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด');</script><?php
    exit();
  }

  $date_start = trim($_POST['date_start']);
  $date_stop = trim($_POST['date_stop']);
  $date_start_ch = DateTime::createFromFormat('d/m/Y', data_filter($date_start))->format('Y');
  $date_stop_ch = DateTime::createFromFormat('d/m/Y', data_filter($date_stop))->format('Y');

if($_POST['year'] != $date_start_ch || $_POST['year'] != $date_stop_ch){
  ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือก ปี ค.ศ. วันเริ่มต้นและสิ้นสุด ให้ตรงกับปี ค.ศ ที่เลือกไว้ครับ');</script><?php
  exit();
}



  $date_start = DateTime::createFromFormat('d/m/Y', data_filter($date_start))->format('Y-m-d');
  $date_stop = DateTime::createFromFormat('d/m/Y', data_filter($date_stop))->format('Y-m-d');
  $date_start_in=$date_start ;
  $date_stop_in=$date_stop ;
  $date_start =  strtotime($date_start);
  $date_stop = strtotime($date_stop);



if($_POST['id_edit']!=''){
  $and_holi = " AND holiday_id != '".$_POST['id_edit']."' ";
}

    $sql_select = " SELECT * FROM `PublicHoliday` WHERE
                    (('$date_start_in' between holiday_date_start and holiday_date_end ) or
                    ('$date_stop_in' between holiday_date_start and holiday_date_end ) or
                    ('$date_start_in'  <= (holiday_date_start and '$date_stop_in'  >= holiday_date_end )))
                    $and_holi
                    AND holiday_status = '0'
                    ";

     $query_select = $conn->query($sql_select);
     $array_row = array();
     if ($query_select->num_rows >0)
     {
       ?><script type="text/javascript">parent.iziToast_func.alert('วันที่คุณเลือกมีข้อมูลในระบบแล้ว');</script><?php
       exit();
     }


  if($date_start==$date_stop){
    $holiday_date_amount = 1;
  }else{
    $sum =    $date_stop - $date_start;
    $holiday_date_amount =    $sum1 =  ($sum / 86400)+1;
  }

  $year = data_filter(trim($_POST['year']));
  $add_name = data_filter(trim($_POST['add_name']));


if($_POST['id_edit']==''){
        $sql_add_pass = "  INSERT INTO  PublicHoliday (holiday_year,holiday_name,holiday_date_start,holiday_date_end,holiday_date_amount,holiday_create_datetime,holiday_createBy_id)
                            VALUES ('$year', '$add_name','$date_start_in','$date_stop_in','$holiday_date_amount','$date_setting','$emp_id') ";
        $query_add_pass = $conn->query($sql_add_pass);

 }else{
       $sql_edit_pass = " UPDATE  PublicHoliday
                          SET   holiday_year = '$year'
                                ,holiday_name = '$add_name'
                                ,holiday_date_start = '$date_start_in'
                                ,holiday_date_end = '$date_stop_in'
                                ,holiday_date_amount = '$holiday_date_amount'
                                ,holiday_update_datetime ='$date_setting'
                                ,holiday_updateBy_id= '$emp_id'

                          where  holiday_id = '".$_POST['id_edit']."' ";
       $query_edit_pass = $conn->query($sql_edit_pass);
 }
   if ($query_add_pass || $query_edit_pass){
     if($query_add_pass){
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
     }else{
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
     }   }else {
     ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();
}

if ($_POST['method']=="get_data_holiday"){
   include("../../config/config.php");

      $sql_select = "SELECT holiday_name , holiday_date_start,holiday_date_end,holiday_year  FROM PublicHoliday where holiday_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['holiday_name']=$result_select['holiday_name'];
           $array_row['holiday_date_start']=$result_select['holiday_date_start'];
           $array_row['holiday_date_end']=$result_select['holiday_date_end'];
           $array_row['holiday_year']=$result_select['holiday_year'];
         }
       }
       echo json_encode($array_row);
       exit();
}


if ($_POST['method']=="del_holiday"){
   include("../../config/config.php");
    $sql_del = "UPDATE PublicHoliday SET holiday_status = '1' where  holiday_id = '".$_POST['id_p']."'";
    $query_del = $conn->query($sql_del);
    if ($query_del){
        echo '00';
    }else {
        echo "01";
    }
    exit();
}


if($_POST['method']=='search_frm'){
  include("../../config/config.php");


  $day_check = date("Y-m-d");
  // if($_POST['ty']==1){
  //   $sql_edit = "SELECT form_id,form_name,form_start_date,form_end_date,form_end_date FROM  Form_Of_Comp
  //                 WHERE form_start_date >=  '$day_check'
  //                 AND `form_status` = 0
  //                 or `form_name` LIKE '%".$_POST['search_frm']."%' ";
  // }else{
  $sql_edit = "SELECT form_id,form_name,form_start_date,form_end_date FROM  Form_Of_Comp
  WHERE form_start_date <=  '$day_check' AND form_end_date >= '$day_check'
  AND `form_status` = 0
  AND `form_name` LIKE '%".$_POST['search_frm']."%'
  or  form_id = '".$_POST['id_form']."'
  or  form_id = '".$_POST['ssf']."'

  ";

  // }

  $query_edit = $conn->query($sql_edit);
  if ($query_edit->num_rows >0){
    while ( $re_edit =   $query_edit->fetch_assoc()) {
      $form_id = $re_edit['form_id'];
      $form_name =  $re_edit['form_name'];
      $form_start_date = date("d/m/Y" , strtotime($re_edit['form_start_date']) );
      $form_end_date = date("d/m/Y" , strtotime($re_edit['form_end_date']) );
      ?>
      <tr>
        <th class="center">
          <?php
          $sql_ch = "SELECT form_id,form_name,form_start_date,form_end_date FROM  Form_Of_Comp
          WHERE form_start_date <=  '$day_check' AND form_end_date >= '$day_check'
          AND `form_status` = 0
          AND form_id = '$form_id'
          ";
          $query_ch = $conn->query($sql_ch);
          if ($query_ch->num_rows <1){
            $id_ch_day = $form_id;
          }else{
            $id_ch_day='';
          }
          ?>
          <input type="radio" name="form_set" id="form_set_<?=$form_id?>" value="<?=$form_id?>" <?php if($id_ch_day != ''){ echo "disabled";}?> onchange="set_val();" class="cursor"></th>
          <th><label class="txt_nol_form cursor" for="form_set_<?=$form_id?>"><?=$form_name?></label></th>
          <th>
            <label class="txt_nol_form"><?=$form_start_date." - ".$form_end_date?></label>
            <?php
            if($id_ch_day != ''){
              ?>
              <label class="txt_nol_red">(ฟอร์มที่หมดอายุการใช้งานแล้ว)</label>
              <input type="hidden" name="id_ch_day" id="id_ch_day" value="<?=$id_ch_day?>">
              <input type="hidden" name="sear_frm" id="sear_frm" value="<?=$id_ch_day?>">
              <?php
            }
            ?>
          </th>
        </tr>
        <?php
      }
    }else{
      ?><th style="text-align: center;"><label class="txt_nol_form">ไม่พบข้อมูล</label></th><?php
    }
    exit();
}


if(isset($_GET["method"]) && $_GET["method"]=="add_img_noti"){
    include("../../config/config.php");

    if($_POST['type_over']==1){
      $type_over = '1';
    }else{
      $type_over = '2';
    }

    if ($_FILES['add_pic_user']['name']){
      $images = $_FILES["add_pic_user"]["tmp_name"];
      $image_type = $_FILES['add_pic_user']['type'];

      if ($image_type=="image/png"){
        $image_set_type = "png";

      }
      if ($image_type=="image/gif"){
        $image_set_type = "gif";
      }

      $size=GetimageSize($images);
      if ($size[0]!=100 || $size[1]!=100)
      {
        ?><script type="text/javascript">parent.iziToast_func.alert("Icon size (100x100)px Only");</script><?php
        exit();
      }
    }

  if($_FILES['add_pic_user']['name'] != ''){
    if($image_set_type != ''){
      if($type_over==1){
         $folder = 'noti_main';
         $last_id_country = 1;
      }else{
          $folder = 'noti_small';
          $last_id_country = 1;
      }

     create_case_direatory($folder,$last_id_country);

     $new_images =  uniqid().'.'.$image_set_type;

     $file_size_s = "../../data/setting/".$folder."/".$last_id_country."/s/";
     $file_size_l = "../../data/setting/".$folder."/".$last_id_country."/l/";

     copy($_FILES["add_pic_user"]["tmp_name"],"../../data/setting/".$folder."/".$last_id_country."/".$new_images);
     $images = "../../data/setting/".$folder."/".$last_id_country."/".$new_images;
     $images_pat = "data/setting/".$folder."/".$last_id_country."/s/".$new_images;


    if($type_over==1){
         $sql_update = "UPDATE Setting_Info SET
                              overdueMain_alert_img_name = '".$new_images."'
                              ,overdueMain_alert_img_path = '$images_pat'
                              ,overdueMain_alert_img_ext = '$image_set_type'
                              WHERE settingInfo_id = '1' ";
         $query_update = $conn->query($sql_update);
         resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images);


    }else{

         $sql_update = "UPDATE Setting_Info SET
                              overdueSub_alert_img_name = '".$new_images."'
                              ,overdueSub_alert_img_path = '$images_pat'
                              ,overdueSub_alert_img_ext = '$image_set_type'
                              WHERE settingInfo_id = '1' ";
         $query_update = $conn->query($sql_update);
         resize_image($images,$file_size_s,$file_size_l,$image_set_type,$new_images);
       }
    }
  }


   if ($query_update){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else {
     ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();
}


if ($_GET['method']=="edit_noti"){
   include("../../config/config.php");


   if($_POST['ty_check']=='1'){
     if (trim($_POST['progress_25']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 25% (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['progress_25_en']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 25% (Eng)');</script><?php
       exit();
     }
     if (trim($_POST['progress_50']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 50% (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['progress_50_en']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 50% (Eng)');</script><?php
       exit();
     }
     if (trim($_POST['progress_75']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 75% (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['progress_75_en']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 75% (Eng)');</script><?php
       exit();
     }
     if (trim($_POST['progress_100']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 100% (ไทย)');</script><?php
       exit();
     }
     if (trim($_POST['progress_100_en']) == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 100% (Eng)');</script><?php
       exit();
     }
              $progress_status = data_filter(trim($_POST['progress_status']));
              $progress_25 = data_filter(trim($_POST['progress_25']));
              $progress_50 = data_filter(trim($_POST['progress_50']));
              $progress_75 = data_filter(trim($_POST['progress_75']));
              $progress_100 = data_filter(trim($_POST['progress_100']));
              $progress_25_en = data_filter(trim($_POST['progress_25_en']));
              $progress_50_en = data_filter(trim($_POST['progress_50_en']));
              $progress_75_en = data_filter(trim($_POST['progress_75_en']));
              $progress_100_en = data_filter(trim($_POST['progress_100_en']));
              $sql_edit_info = "UPDATE  Setting_Info SET
                                 noti_status = '$progress_status'
                                 ,noti_process25   = '$progress_25'
                                 ,noti_process50  = '$progress_50'
                                 ,noti_process75 = '$progress_75'
                                 ,noti_process100 = '$progress_100'
                                 ,noti_process25_en   = '$progress_25_en'
                                 ,noti_process50_en  = '$progress_50_en'
                                 ,noti_process75_en = '$progress_75_en'
                                 ,noti_process100_en = '$progress_100_en'
                               where  settingInfo_id = '1' ";
              $query_edit_info = $conn->query($sql_edit_info);


   }else if($_POST['ty_check']=='2'){


          $progress_message = data_filter(trim($_POST['progress_message']));
          $sql_edit_info = "  UPDATE  Setting_Info SET
                              notiMsg_status = '$progress_message'
                              where  settingInfo_id = '1' ";
          $query_edit_info = $conn->query($sql_edit_info);


    }else if($_POST['ty_check']=='3'){

          $normal_period = data_filter(trim($_POST['normal_period']));
          $normal_alert_period = data_filter(trim($_POST['normal_alert_period']));

          $sql_edit_info = "  UPDATE  Setting_Info SET
                              normal_period = '$normal_period'
                              ,normal_alert_period = '$normal_alert_period'
                              where  settingInfo_id = '1' ";
          $query_edit_info = $conn->query($sql_edit_info);

    }else if($_POST['ty_check']=='4'){

          $overdueMain_alert_period = data_filter(trim($_POST['overdueMain_alert_period']));
          $overdueSub_alert_period = data_filter(trim($_POST['overdueSub_alert_period']));

          $sql_edit_info = "  UPDATE  Setting_Info SET
                              overdueMain_alert_period = '$overdueMain_alert_period'
                              ,overdueSub_alert_period = '$overdueSub_alert_period'
                              where  settingInfo_id = '1' ";
          $query_edit_info = $conn->query($sql_edit_info);

    }else if($_POST['ty_check']=='5'){

          $recivedCase_from_app = data_filter(trim($_POST['recivedCase_from_app']));
          $recivedMsg_from_app = data_filter(trim($_POST['recivedMsg_from_app']));
          $assign_status = data_filter(trim($_POST['assign_status']));

          $sql_edit_info = "  UPDATE  Setting_Info SET
                              recivedCase_from_app = '$recivedCase_from_app'
                              ,recivedMsg_from_app = '$recivedMsg_from_app'
                              ,assign_status = '$assign_status'
                              where  settingInfo_id = '1' ";
          $query_edit_info = $conn->query($sql_edit_info);

    }
        if ($query_edit_info){
          ?><script type="text/javascript">parent.iziToast_func.alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        }else{
          ?><script type="text/javascript">parent.iziToast_func.alert('แก้ไขข้อมูลผิดพลาด');</script><?php
        }
        exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="getblacklist"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getblacklist($post);
    echo $response;
exit();

}

function getblacklist($post){
   include("../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT *  ";
   $sql_caseCh .= "FROM Case_Channel WHERE caseCh_status = '0' ";

   if($post->text != ""){
     $sql_caseCh .= "AND caseCh_name LIKE '%".$post->text."%' ";
   }
  if($post->sort=="name"){
    $sort_col = "caseCh_name";
  }
  // if($post->sort=="view"){
  //   $sort_col = "caseCh_enable";
  // }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0 ;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['caseCh_name'].'</span>';
         if($re['caseCh_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }
       $caseCh_col_arr["view"] = '<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven
      </div>
    </div>
  </div>';

       $sql_ch = "  SELECT caseCh_id FROM `Case` WHERE `case_id` =  '".$re['caseCh_id']."'  ";
       $query_ch = $conn->query($sql_ch);
       if($query_ch->num_rows > 0){
         $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';

       }else{
         $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_channel('.$re['caseCh_id'].');"></span>
                <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_channel('.$re['caseCh_id'].');"></span>';
        }
       $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}



if(isset($_POST["method"]) && $_POST["method"]=="add_blacklist"){
   include("../../config/config.php");
      for ($i=0; $i<count($_POST['id_obj']);$i++)
      {
        $sql_select = "SELECT complnt_trade_number,complnt_name FROM `Case` WHERE case_id = '".$_POST['id_obj'][$i]."' ";
        $query_select = $conn->query($sql_select);
        if ($query_select->num_rows >0)
        {
          while($result_select = $query_select->fetch_assoc())
          {
            $sql_bl = " INSERT INTO Backlist_Complnt  (complnt_trade_number,complnt_name,backlistTmp_create_datetime,backlistTmp_createBy_id)
                               VALUES ('".$result_select['complnt_trade_number']."', '".$result_select['complnt_name']."','$date_setting','$emp_id') ";
          	$query_bl = $conn->query($sql_bl);
          }
        }
      }
      if ($query_bl){
   				echo '00';
   		}else {
   				echo "01";
   		}
   		exit();
}

if(isset($_POST["method"]) && $_POST["method"]=="del_blacklist"){
   include("../../config/config.php");
      for ($i=0; $i<count($_POST['id_obj']);$i++)
      {
        $sql_select = "DELETE  FROM `Backlist_Complnt` WHERE backlist_id = '".$_POST['id_obj'][$i]."' ";
        $query_select = $conn->query($sql_select);
      }
      if ($query_bl){
   				echo '00';
   		}else {
   				echo "01";
   		}
   		exit();
}

if(isset($_POST["method"]) && $_POST["method"]=="get_data_holiday_update"){
include("../../config/config.php");
      $sql_up = "UPDATE `Setting_Info` SET `hd_setting`='".$_POST['search_text']."' WHERE settingInfo_id = 1";
      $query_up  = $conn->query($sql_up);
      if($query_up){
        echo "0";
      }else {
        echo "1";
      }
      exit();
}

if(isset($_POST["method"]) && $_POST["method"]=="get_data_company"){
include("../../config/config.php");



      $sql_up = "UPDATE `Setting_Info` SET `bl_setting`='".$_POST['search_text']."' WHERE settingInfo_id = 1";
      $query_up  = $conn->query($sql_up);

    $sql_edit = "SELECT complnt_name,complnt_trade_number,case_id,count(case_id) as count_sum FROM `Case` WHERE complnt_trade_number !='' GROUP by complnt_trade_number ASC  ";
    $query_edit = $conn->query($sql_edit);
    $color = 0;
    //if ($query_edit->num_rows>0){
      $ch = 0;
    while ( $re_edit =   $query_edit->fetch_assoc()) {
      $count_sum =  $re_edit['count_sum'];
      if(($count_sum >= $_POST['search_text'] || $_POST['search_text'] == '') && $ch == 0){
      $complnt_trade_number =  $re_edit['complnt_trade_number'];
      $sql_select = "SELECT complnt_trade_number FROM `Backlist_Complnt` where complnt_trade_number =  '$complnt_trade_number'  ";
      $query_select = $conn->query($sql_select);
      if ($query_select->num_rows<1){
        ?>
        <tr class="<?php if($color%2){ echo "tb_color"; }else{ echo  "tb_color_1"; } ?>">
          <td class="center_table" style="width: 80px;">
            <div class="checkbox checkbox-success checkbox-inline">
              <input type="checkbox" class="checkbox_black_sub checkbox_1" name="" value="<?php echo $re_edit['case_id']?>">
              <label for=""></label>
            </div>
          </td>
          <td  class="cursor cursor_click cursor<?php echo $re_edit['case_id']?>"  style="width: 100%;"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree_<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
            <div class="card">
              <div class="card-header" role="tab" id="heading">
                <h5 class="mb-0">
                  <span class="collapsed bl_txt span_bl" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo $re_edit['complnt_name'];?>
                  </span>

                  <div class="arrow_bl arrow_bl<?php echo $re_edit['case_id']?>">
                    <i class="fa fa-chevron-down up_rolate<?php echo $re_edit['case_id']?> cursor i_txt" aria-hidden="true" ></i>
                  </div>

                </h5>
              </div>
              <div id="collapseThree_<?php echo $re_edit['case_id']?>" class="collapse p_box" role="tabpanel" aria-labelledby="heading">
                <div class="card-block">
                  <?php
                  $sql_edit1 = "SELECT caseDtl_title,case_id FROM `Case` WHERE complnt_trade_number = '$complnt_trade_number'  ";
                  $query_edit1 = $conn->query($sql_edit1);
                  while($re_edit1 =   $query_edit1->fetch_assoc()) {
                    $caseDtl_title =  $re_edit1['caseDtl_title'];
                    $case_id =  $re_edit1['case_id'];
                    ?>
                    <span class="span_bl_sub">
                      <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                      Case ID <?php echo $case_id; ?> - <?php echo $caseDtl_title; ?></span><br>
                      <?php } ?>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
            <?php
            $color++;
            }
          }
        }
      /*}else{
        ?>
        <tr>
          <th class="thead_table center_table" style="width:  1%;" colspan="2">
            ไม่พบข้อมูล
          </th>
        </tr>
        <?php
      }*/

    $sql_edit = "SELECT complnt_name,complnt_trade_number,case_id,count(case_id) as count_sum FROM `Case` WHERE complnt_trade_number ='' AND complnt_name !='' GROUP by complnt_name ASC  ";
    $query_edit = $conn->query($sql_edit);
    $color = 0;
      $ch = 0;
    while ( $re_edit =   $query_edit->fetch_assoc()) {
      $count_sum =  $re_edit['count_sum'];
      if(($count_sum >= $_POST['search_text'] || $_POST['search_text'] == '') && $ch == 0){
      $complnt_trade_number =  $re_edit['complnt_trade_number'];
      $sql_select = "SELECT complnt_trade_number FROM `Backlist_Complnt` where complnt_trade_number =  '$complnt_trade_number'  ";
      $query_select = $conn->query($sql_select);
      if ($query_select->num_rows<1){
        ?>
        <tr class="<?php if($color%2){ echo "tb_color_1"; }else{ echo  "tb_color"; } ?>">
          <td class="center_table" style="width: 80px;">
            <div class="checkbox checkbox-success checkbox-inline">
              <input type="checkbox" class="checkbox_black_sub checkbox_1" name="" value="<?php echo $re_edit['case_id']?>">
              <label for=""></label>
            </div>
          </td>
          <td onclick="click_sub(<?php echo $re_edit['case_id']?>);" class="cursor cursor<?php echo $re_edit['case_id']?>"  style="width: 100%;"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree_<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
            <div class="card">
              <div class="card-header" role="tab" id="heading">
                <h5 class="mb-0">
                  <span class="collapsed bl_txt span_bl" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo $re_edit['complnt_name'];?>
                  </span>
                  <div class="arrow_bl arrow_bl<?php echo $re_edit['case_id']?>">
                    <i class="fa fa-chevron-down up_rolate<?php echo $re_edit['case_id']?> cursor i_txt" aria-hidden="true"  ></i>
                  </div>
                </h5>
              </div>
              <div id="collapseThree_<?php echo $re_edit['case_id']?>" class="collapse p_box" role="tabpanel" aria-labelledby="heading">
                <div class="card-block">
                  <?php
                  $sql_edit1 = "SELECT caseDtl_title,case_id FROM `Case` WHERE complnt_trade_number = '$complnt_trade_number'  ";
                  $query_edit1 = $conn->query($sql_edit1);
                  while($re_edit1 =   $query_edit1->fetch_assoc()) {
                    $caseDtl_title =  $re_edit1['caseDtl_title'];
                    $case_id =  $re_edit1['case_id'];
                    ?>
                    <span class="span_bl_sub">
                      <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                      Case ID <?php echo $case_id; ?> - <?php echo $caseDtl_title; ?></span><br>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <?php
            $color++;
            }
          }
        }

    exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="copy_duplicate"){
    include("../../config/config.php");

    $year_duplicate = data_filter($_POST['year_duplicate']);

    $sql_select = "SELECT  *  FROM PublicHoliday where holiday_year = '".$year_duplicate."' AND holiday_status = 0 ";
    $query_select = $conn->query($sql_select);
    $array_row = array();
    if ($query_select->num_rows >0)
    {
      ?><script type="text/javascript">parent.iziToast_func.alert('ไม่สามารถเพิ่มข้อมูลได้เนื่องจากข้อมูลปีที่จะสร้างมีในระบบแล้ว');</script><?php
      exit();

    }

    $sql_select = "SELECT  *  FROM PublicHoliday where holiday_year = '".$_POST['year']."' AND holiday_status = 0 ";
    $query_select = $conn->query($sql_select);
    $array_row = array();
    if ($query_select->num_rows >0)
    {
      while($result_select = $query_select->fetch_assoc())
      {
        $holiday_date_start = $result_select['holiday_date_start'];
        $holiday_date_end = $result_select['holiday_date_end'];

        $date_start_in = substr($holiday_date_start, 4, 10);
        $date_start_in = $year_duplicate.$date_start_in;
        $date_stop_in = substr($holiday_date_end, 4, 10);
        $date_stop_in = $year_duplicate.$date_stop_in;


        $sql_edit_pass = "  INSERT INTO  PublicHoliday (holiday_year,holiday_name,holiday_date_start,holiday_date_end,holiday_date_amount,holiday_create_datetime,holiday_createBy_id)
                            VALUES ('".$year_duplicate."', '".$result_select['holiday_name']."' , '$date_start_in','$date_stop_in','".$result_select['holiday_date_amount']."','$date_setting','$emp_id') ";
        $query_edit_pass = $conn->query($sql_edit_pass);
      }
    }
   if ($query_edit_pass){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else{
     ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="import_product"){
  // if (!is_dir("../../data/setting")){
  //       mkdir("../../data/setting", 0775, true);
  // }
  // if (!is_dir("../../data/setting/template")){
  //     mkdir("../../data/setting/template", 0775, true);
  // }
  // $AA = 'Template_product.xlsx';
  //   unlink("../../data/setting/template/". $AA);
  //
  // move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../data/setting/template/". $AA);
  //
  // exit();


  if (!is_dir("../../data/setting")){
        mkdir("../../data/setting", 0775, true);
  }
  if (!is_dir("../../data/setting/import_product")){
      mkdir("../../data/setting/import_product", 0775, true);
  }

    if($_FILES["userimport"]["size"]) {
      $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
      move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../data/setting/import_product/". $new_excel);
      $inputFileName = "../../data/setting/import_product/".$new_excel;

      ?><script type="text/javascript">top.import_product('<?= $inputFileName ?>');</script><?php
    }
    else {
       ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
      exit();
    }
}


if(isset($_GET["method"]) && $_GET["method"]=="getIncorrect_Type"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getIncorrect_Type($post);
    echo $response;
exit();

}


function getIncorrect_Type($post){
   include("../../config/config.php");

   $caseCh_arr = array();
   $sql_caseCh = "SELECT * FROM Incorrect_Type WHERE incType_status = '0' ";

   if($post->text != ""){
     $sql_caseCh .= "  AND ( incType_name LIKE '%".$post->text."%'
                             or incType_name_en LIKE '%".$post->text."%'

                           )";
   }

   if($post->status_m != ""){
     $sql_caseCh .= "AND incType_section = '$post->status_m' ";
   }
   if($post->sort=="id"){
     $sort_col = "incType_id";
   }
  if($post->sort=="name"){
    $sort_col = "incType_name_en";
  }
  if($post->sort=="name_en"){
    $sort_col = "incType_name_en";
  }
  if($post->sort=="type"){
    $sort_col = "process_type_name";
  }
  if($post->sort=="dep"){
    $sort_col = "incType_section";
  }

  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0 + $post->offset ;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_Incorrect('.$re['incType_id'].',0);">'.$re['incType_name'].'</span>';

       if($re['incType_name_en']!=''){
         $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor" onclick="edit_Incorrect('.$re['incType_id'].',0);">'.$re['incType_name_en'].'</span>';
       }else{
         $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor" onclick="edit_Incorrect('.$re['incType_id'].',0);">-</span>';
       }
      $sql_ch = "  SELECT incType_id FROM `Case_Knowledge` WHERE `incType_id` =  '".$re['incType_id']."'  ";
      $query_ch = $conn->query($sql_ch);
      if($query_ch->num_rows > 0){
        $del =  '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_Incorrect('.$re['incType_id'].',2);"></span>
                  <span class="icon-ico-ditp-28 txt_no_edit"></span>';
      }else{
        // $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_Incorrect('.$re['incType_id'].',0);">'.$re['incType_name'].'</span>';
        // $caseCh_col_arr["name_en"] = '<span class="txt_nol cursor" onclick="edit_Incorrect('.$re['incType_id'].',0);">'.$re['incType_name_en'].'</span>';
        $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_Incorrect('.$re['incType_id'].',1);"></span>
               <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_Incorrect_Type('.$re['incType_id'].');"></span>';
       }

      if($re['process_type_name']==''){
        $ty = '<span class="txt_nol">-</span>';
      }else{
        $ty = '<span class="txt_nol">'.$re['process_type_name'].'</span>';
      }

       $caseCh_col_arr["type"] = $ty;

       if($re['incType_section'] == '1'){
         $dep='<span class="type_general">สสบ.</span>';
       }else if($re['incType_section'] == '2'){
         $dep ='<span class="type_law">นิติการ</span>';
       }else{
         $dep ='<span class="txt_nol">-</span>';
       }
       $caseCh_col_arr["dep"] = $dep;


         if($re['incType_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }
       $caseCh_col_arr["view"] = $view;

       $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}




if(isset($_GET["method"]) && $_GET["method"]=="getdepartment"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = getdepartment($post);
    echo $response;
exit();

}


function getdepartment($post){
   include("../../config/config.php");

   $caseCh_arr = array();
  //  $sql_caseCh = "SELECT * FROM Department  WHERE dept_status = '0'";
   $sql_caseCh = "SELECT * FROM `Department` LEFT join Department_Type on Department.dept_type = Department_Type.deptType_id  WHERE Department.dept_status = '0'";

   if($post->text != ""){
    //  $sql_caseCh .= "AND dept_name LIKE '%".$post->text."%' ";

     $sql_caseCh .= "  AND ( dept_name LIKE '%".$post->text."%'
                             or dept_director LIKE '%".$post->text."%'
                             or dept_email LIKE '%".$post->text."%'
                             or dept_address LIKE '%".$post->text."%'
                             or deptType_name LIKE '%".$post->text."%'
                           )";

   }
   if($post->status_m != ""){
     $sql_caseCh .= " AND dept_section = '$post->status_m' ";
   }

   if($post->status_dep != ""){
     $sql_caseCh .= " AND dept_type = '$post->status_dep' ";
   }
   if($post->sort=="id"){
     $sort_col = "dept_id";
   }
  if($post->sort=="name"){
    $sort_col = "dept_name";
  }
  if($post->sort=="director"){
    $sort_col = "dept_director";
  }
  if($post->sort=="type_dep"){
    $sort_col = "deptType_name";
  }
  if($post->sort=="email"){
    $sort_col = "dept_email";
  }
  if($post->sort=="address"){
    $sort_col = "dept_address";
  }
  if($post->sort=="type"){
    $sort_col = "dept_type";
  }
  if($post->sort=="dep"){
    $sort_col = "dept_section";
  }
  if($post->sort=="affiliation"){
    $sort_col = "dept_affiliation";
  }


  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
    //  echo $sql_caseCh;
     $co_id = 0 + $post->offset ;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';

      if($re['deptType_id']!=1){
         $sql_ch = "  SELECT dept_id FROM `Process` WHERE `dept_id` =  '".$re['dept_id']."'  ";
         $query_ch = $conn->query($sql_ch);
         if($query_ch->num_rows > 0){
           $del =  '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_department('.$re['dept_id'].',2);"></span>
                   <span class="icon-ico-ditp-28 txt_no_edit"></span></div>';
         }else{
           $del = '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_department('.$re['dept_id'].',1);"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_department('.$re['dept_id'].');"></span></div>';
          }
      }else{
            $del =  '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_department('.$re['dept_id'].',2);"></span>
                    <span class="icon-ico-ditp-28 txt_no_edit"></span></div>';
      }


      $caseCh_col_arr["name"] = '<span class="txt_nol cursor" onclick="edit_department('.$re['dept_id'].',0);">'.$re['dept_name'].'</span>';
      $caseCh_col_arr["director"] = '<span class="txt_nol" >'.$re['dept_director'].'</span>';
      $caseCh_col_arr["assistant"] = '<span class="txt_nol" >'.$re['dept_assistant'].'</span>';
      $caseCh_col_arr["tel"] = '<span class="txt_nol" >'.$re['dept_tel'].'</span>';
      $caseCh_col_arr["fax"] = '<span class="txt_nol" >'.$re['dept_fax'].'</span>';
      $caseCh_col_arr["affiliation"] = '<span class="txt_nol" >'.$re['dept_affiliation'].'</span>';
      $caseCh_col_arr["email"] = '<span class="txt_nol" >'.$re['dept_email'].'</span>';

      if($re['dept_address']!=''){
        $caseCh_col_arr["address"] = '<span class="txt_nol" >'.$re['dept_address'].'</span>';
      }else{
        $caseCh_col_arr["address"] = '<span class="txt_nol" >-</span>';
      }
       $caseCh_col_arr["type_dep"] = '<span class="txt_nol" >'.$re['deptType_name'].'</span>';

      if($re['process_type_name']==''){
        $ty = '<span class="txt_nol">-</span>';
      }else{
        $ty = '<span class="txt_nol">'.$re['process_type_name'].'</span>';
      }

       $caseCh_col_arr["type"] = $ty;

       if($re['dept_section'] == '1'){
         $dep='<span class="type_general">สสบ.</span>';
       }else if($re['dept_section'] == '2'){
         $dep ='<span class="type_law">นิติการ</span>';
       }else{
         $dep ='<span class="txt_nol">-</span>';
       }
       $caseCh_col_arr["dep"] = $dep;
         if($re['dept_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }
       $caseCh_col_arr["view"] = $view;
       $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}



if(isset($_GET["method"]) && $_GET["method"]=="add_incorrect"){
 	 include("../../config/config.php");

    $radio_section = data_filter(trim($_POST['radio_section']));
    $add_name = data_filter(trim($_POST['add_name']));
    $add_name_en = data_filter(trim($_POST['add_name_en']));
    $radio_ststus = data_filter(trim($_POST['radio_ststus']));
    $id_department = data_filter(trim($_POST['id_edit']));

   if($add_name == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อประเภทความผิด (ไทย)');</script><?php
     exit();
   }
   if($add_name_en == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อประเภทความผิด (Eng)');</script><?php
     exit();
   }


   if($id_department==''){
     $sql_it= " INSERT INTO Incorrect_Type  (`incType_name`, `incType_enable`, incType_create_datetime , `incType_createBy_id`,incType_name_en,incType_other_flag)
                        VALUES ('$add_name','$radio_ststus','$date_setting','$emp_id','$add_name_en','".$_POST['ra_other']."') ";
      $query_it = $conn->query($sql_it);
   }else{

    $sql_edit_up = "UPDATE  Incorrect_Type SET
                            incType_name = '$add_name'
                            ,incType_enable   = '$radio_ststus'
                            ,incType_update_datetime = '$date_setting'
                            ,incType_updateBy_id = '$emp_id'
                            ,incType_name_en = '$add_name_en'
                            ,incType_other_flag = '".$_POST['ra_edit_other']."'
                            where  incType_id = '$id_department' ";
      $query_edit_up = $conn->query($sql_edit_up);
   }
    if($query_it || $query_edit_up ){
      if($query_it){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        exit();
      }else{
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
        exit();
      }
    }
    if (trim($_POST['form_set']) == '' ){
      ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
      exit();
    }
 }


if(isset($_GET["method"]) && $_GET["method"]=="add_department"){
 	 include("../../config/config.php");

    $radio_section = data_filter(trim($_POST['radio_section']));
    $radio_dp = data_filter(trim($_POST['radio_dp']));
    $add_name = data_filter(trim($_POST['add_name']));
    $name_short = data_filter(trim($_POST['name_short']));
    $radio_ststus = data_filter(trim($_POST['radio_ststus']));
    $id_department = data_filter(trim($_POST['id_department']));
    $Country = data_filter(trim($_POST['Country']));
    $director = data_filter(trim($_POST['director']));
    $tel = data_filter(trim($_POST['tel']));
    $email = data_filter(trim($_POST['email']));
    $assistant = data_filter(trim($_POST['assistant']));
    $select_dp = data_filter(trim($_POST['group_id']));
    $address = data_filter(trim($_POST['address']));
    $fax = data_filter(trim($_POST['fax']));
    $Continents = data_filter(trim($_POST['Continents']));
    $affiliation = data_filter(trim($_POST['affiliation']));
    $message_noti = data_filter(trim($_POST['message_noti']));
    $message_noti_en = data_filter(trim($_POST['message_noti_en']));



    if($select_dp == ''){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกเภทหน่วยงาน');</script><?php
      exit();
    }
  if($select_dp==3){
    if($Continents == ''){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกทวีป');</script><?php
      exit();
    }
    if($Country == ''){
      ?><script type="text/javascript">parent.iziToast_func.alert('กรุณาเลือกประเทศ');</script><?php
      exit();
    }
  }

   if($add_name == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อหน่วยงาน');</script><?php
     exit();
   }

   if($select_dp==1){
     if($name_short == ''){
       ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อย่อหน่วยงาน');</script><?php
       exit();
     }
   }

   if($id_department!=''){
     $and_id = " AND dept_id != '$id_department' ";
   }
   $sql_dep = "SELECT dept_name  FROM  Department where dept_name = '".$add_name."' AND dept_type = '".$select_dp."'  AND dept_status = 0  $and_id ";
   $query_dep = $conn->query($sql_dep);
   if($query_dep ->num_rows>0){
     ?><script type="text/javascript">parent.iziToast_func.alert('ชื่อหน่วยงานมีอยู่ในระบบแล้วกรุณากรอกชื่ออื่น');</script><?php
     exit();
   }
   if($director == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกชื่อผู้อำนวยการ');</script><?php
     exit();
   }

   if($tel == ''){
     ?><script type="text/javascript">parent.iziToast_func.alert('กรุณากรอกหมายเลขโทรศัพท์');</script><?php
     exit();
   }

   if($select_dp!=2){
     $affiliation = '';
   }
   if($select_dp==1){
     $address = '';
   }



   if($id_department==''){
     $sql_it= " INSERT INTO Department  (`dept_name`, `dept_section`, `dept_type`, dept_enable , `dept_create_datetime`, `dept_createBy_id`,country_id,dept_director,dept_tel,dept_email,dept_assistant,dept_address,dept_fax,dept_affiliation,dept_message_noti,dept_message_noti_en)
                        VALUES ('$add_name','$radio_section','$select_dp','$radio_ststus','$date_setting','$emp_id','$Country','$director','$tel','$email','$assistant','$address','$fax','$affiliation','$message_noti','$message_noti_en') ";
      $query_it = $conn->query($sql_it);
      $last_id_bannet  = $conn->insert_id;
      if($last_id_bannet){
        $sql_its= " INSERT INTO office_type  (`dept_id`, `office_name`, `office_name_short`, `office_status`)
                           VALUES ('$last_id_bannet','$add_name','$name_short','1') ";
         $query_its = $conn->query($sql_its);
      }

   }else{
    $sql_edit_dp = "UPDATE  office_type SET office_name = '$add_name' ,office_name_short   = '$name_short' where  dept_id = '$id_department' ";
    $query_edit_dp = $conn->query($sql_edit_dp);

    $sql_edit_up = "UPDATE  Department SET
                            dept_name = '$add_name'
                            ,dept_section   = '$radio_section'
                            ,dept_type   = '$select_dp'
                            ,dept_enable   = '$radio_ststus'
                            ,dept_update_datetime = '$date_setting'
                            ,dept_updateBy_id = '$emp_id'
                            ,country_id = '$Country'
                            ,dept_director = '$director'
                            ,dept_tel = '$tel'
                            ,dept_email = '$email'
                            ,dept_assistant = '$assistant'
                            ,dept_address = '$address'
                            ,dept_fax= '$fax'
                            ,dept_affiliation = '$affiliation'
                            ,dept_message_noti = '$message_noti'
                            ,dept_message_noti_en = '$message_noti_en'
                            where  dept_id = '$id_department' ";
      $query_edit_up = $conn->query($sql_edit_up);
   }
    if($query_it || $query_edit_up ){
      if($query_it){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
      }else{
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
      }
    }else{
      ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
    }
    exit();
 }

 if ($_POST['method']=="get_data_department"){
    include("../../config/config.php");

       $sql_select = "  SELECT * FROM `Department`
                        left join Country on Country.id=Department.country_id
                        left join Continents on Country.continent_code=Continents.code
                        left join office_type on Department.dept_id=office_type.dept_id
                        where Department.dept_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['dept_name']=$result_select['dept_name'];
           $array_row['dept_section']=$result_select['dept_section'];
           $array_row['dept_enable']=$result_select['dept_enable'];
           $array_row['dept_type']=$result_select['dept_type'];
           $array_row['country_id']=$result_select['country_id'];
           $array_row['dept_director']=$result_select['dept_director'];
           $array_row['dept_tel']=$result_select['dept_tel'];
           $array_row['dept_email']=$result_select['dept_email'];
           $array_row['dept_assistant']=$result_select['dept_assistant'];
           $array_row['code']=$result_select['code'];
           $array_row['name']=$result_select['name'];
           $array_row['dept_address']=$result_select['dept_address'];
           $array_row['dept_fax']=$result_select['dept_fax'];
           $array_row['dept_affiliation']=$result_select['dept_affiliation'];
           $array_row['dept_message_noti']=$result_select['dept_message_noti'];
           $array_row['dept_message_noti_en']=$result_select['dept_message_noti_en'];
           $array_row['name_short']=$result_select['office_name_short'];

          }
        }
        echo json_encode($array_row);
        exit();
 }


  if ($_POST['method']=="get_Incorrect_Typet"){
     include("../../config/config.php");

     		$sql_select = "SELECT *  FROM  Incorrect_Type where incType_id = '".$_POST['id']."'";
     		$query_select = $conn->query($sql_select);
     		$array_row = array();
     		if ($query_select->num_rows >0)
     		{
     			while($result_select = $query_select->fetch_assoc())
     			{
            $array_row['incType_name']=$result_select['incType_name'];
     				$array_row['incType_name_en']=$result_select['incType_name_en'];
            $array_row['incType_section']=$result_select['incType_section'];
            $array_row['incType_enable']=$result_select['incType_enable'];
     				$array_row['incType_other_flag']=$result_select['incType_other_flag'];
           }
         }
         echo json_encode($array_row);
         exit();
  }

  if ($_POST['method']=="del_department"){
    //  include("../../config/config.php");
     $sql_edit_pass = "UPDATE Department SET dept_status = '1' WHERE  dept_id = '".$_POST['del_id']."'";
      $query_edit_pass = $conn->query($sql_edit_pass);
      if ($query_edit_pass){
          echo '1';
      }else {
          echo "0";
      }
      exit();
  }


  if ($_POST['method']=="del_incorrect"){

    $sql_edit_pass = "UPDATE Incorrect_Type SET incType_status = '1' WHERE  incType_id = '".$_POST['del_id']."'";
      $query_edit_pass = $conn->query($sql_edit_pass);
      if ($query_edit_pass){
          echo '1';
      }else {
          echo "0";
      }
      exit();
  }



  if($_POST['method']=='process_contact'){
    include("../../config/config.php");

  	?>
    <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" name="group_id"  id="group_id" data-width="200px">
      <option value="">--- ประเภทกระบวนการ ---</option>
      <?php
      $sql_ch_form = "SELECT process_type_id,process_type_name  FROM Process_Type where process_type_status = 0 AND process_type_section = '".$_POST['id']."' AND process_typ_contact = 1 ORDER by process_type_name ASC";
      $query_ch_form = $conn->query($sql_ch_form);
      if ($query_ch_form->num_rows >0) {
        while ($re = $query_ch_form->fetch_assoc()) {
          ?>
          <option value="<?=$re['process_type_id']?>"><?=$re['process_type_name']?></option>
          <?php
        }
      } ?>
    </select>
  	<?php
  	exit();
  }



  if(isset($_GET["method"]) && $_GET["method"]=="getbanner"){
      $post = array();
      $request_body = file_get_contents('php://input');
      $post = json_decode($request_body);
      $response = getbanner($post);
      echo $response;
  exit();
  }

    function getbanner($post){
      global $member_cls;
       include("../../config/config.php");

       $select_max = "SELECT MAX(banner_up_dow) as max_upbown ,MIN(banner_up_dow) as min_upbown  FROM Banner WHERE  banner_status = 0 " ;
       $query_max = $conn->query($select_max);
       $result_max = $query_max->fetch_assoc();
       $max = $result_max['max_upbown'];
       $min = $result_max['min_upbown'];

       $caseCh_arr = array();
       $sql_caseCh = "SELECT * ";
       $sql_caseCh .= " FROM Banner WHERE banner_status = '0'   ";

      if($post->sort=="id"){
        $sort_col = "banner_up_dow";
      }
      if($post->sort=="type"){
        $sort_col = "banner_img_name";
      }
      if($post->status_m != ""){
        $sql_caseCh .= "  AND banner_enable = '".$post->status_m."' ";
      }

      $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
      $query_edit_pass_all = $conn->query($sql_caseCh);
      $num = $query_edit_pass_all->num_rows;
      $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
         $query_edit_pass = $conn->query($sql_caseCh);
         $co_id = 0+$post->offset;
         while ($re = $query_edit_pass->fetch_assoc()) {
           $caseCh_col_arr = array();
           $co_id++ ;
           $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
          //  $caseCh_col_arr["id"] = '<span class="txt_nol">'.$re['banner_id'].'</span>';


          $caseCh_col_arr["name"] = '<div class="center_banner"><img class="img_banner" src="../../../'.$re['banner_img_path'].'" alt="Smiley face"></div>';
           $caseCh_col_arr["ing_en"] = '<div class="center_banner"><img class="img_banner" src="../../../'.$re['banner_img_path_en'].'" alt="Smiley face"></div>';
             if($re['banner_enable'] == '1'){
               $view ='<span class="icon-ico-ditp-12 view_1">';
             }else{
               $view ='<span class="icon-ico-ditp-13  view_2">';
             }

               $del = '<div class="th_user_edit_1">
                          <span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_banner('.$re['banner_id'].');"></span>
                          <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_banner('.$re['banner_id'].');"></span>
                      </div>';



          if($max==$re['banner_up_dow']){
            $dis= "disabled" ;
          }else{
            $dis = 'onclick="Confirmupdown() && fun_up('.$re['banner_id'].','.$re['banner_up_dow'].');"';
          }
          if($min==$re['banner_up_dow']){
            $dis_min= "disabled" ;
          }else{
            $dis_min = 'onclick="Confirmupdown() && fun_down('.$re['banner_id'].','.$re['banner_up_dow'].');"';
          }

         $caseCh_col_arr["up_down"] = '<div class="btn_up_do"><button style="height: 27px;" type="button" class="btn btn-default" data-dismiss="modal"  '.$dis.' >
                                        <i style="top: 2px; position: relative; font-size: 20px;" class="fa fa-sort-asc" aria-hidden="true"></i>
                                      </button>
                                      <button style="height: 27px;"  type="button" class="btn btn-default" data-dismiss="modal" '.$dis_min.'>
                                        <i style="top: -2px; position: relative; font-size: 20px;" class="fa fa-caret-down" aria-hidden="true"></i>
                                      </button></div>';

            $caseCh_col_arr["view"] = $view;
            $caseCh_col_arr["del_edit"] = $del;
           array_push($caseCh_arr,$caseCh_col_arr);
         }
         $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
         return json_encode($data_array);
  }



function type_imp($ty){
  // global $_FILES["pic_upload"]["tmp_name"];
  // global $_FILES["pic_upload_en"]["tmp_name"];
  // echo "23";
  if ($ty==1){
    $images = $_FILES["pic_upload"]["tmp_name"];
    $image_type = $_FILES['pic_upload']['type'];
  }else{
    $images = $_FILES["pic_upload_en"]["tmp_name"];
    $image_type = $_FILES['pic_upload_en']['type'];
  }

    if ($image_type=="image/png"){
      $image_set_type = "png";
    }
    if ($image_type=="image/gif"){
      $image_set_type = "gif";
    }
    if ($image_type=="image/svg"){
      $image_set_type = "svg";
    }
    if ($image_type=="image/jpg"){
      $image_set_type = "jpg";
    }
    if ($image_type=="image/jpge"){
      $image_set_type = "jpge";
    }
    $size=GetimageSize($images);
    if ($size[0]!=1920 || $size[1]!=569){
      if($ty==1){
        ?><script type="text/javascript">parent.iziToast_func.alert("รูป (ไทย) (1920*569)px Only");</script><?php
        exit();

      }else{
        ?><script type="text/javascript">parent.iziToast_func.alert("รูป (Eng) (1920*569)px Only");</script><?php
        exit();

      }
    }
return  $image_set_type;
}

function edit_img_banner($folder,$last_id_bannet,$ty,$new_name){
  global $date_setting;
  global $emp_id;

  include("../../config/config.php");
  if($ty==1){
    $lang = "th";
  }else{
    $lang = "en";
  }
  deleteDirectory("../../data/setting/".$folder."/".$last_id_bannet."/".$lang);

  if (!is_dir("../../data/setting")){
     mkdir("../../data/setting", 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."")){
      mkdir("../../data/setting/".$folder, 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."")){
      mkdir("../../data/setting/".$folder , 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."/".$last_id_bannet)){
      mkdir("../../data/setting/".$folder."/".$last_id_bannet, 0775, true);
  }
  if (!is_dir("../../data/setting/".$folder."/".$last_id_bannet."/".$lang)){
      mkdir("../../data/setting/".$folder."/".$last_id_bannet."/".$lang, 0775, true);
  }
  if($ty==1){
    copy($_FILES["pic_upload"]["tmp_name"],"../../data/setting/".$folder."/".$last_id_bannet."/".$lang."/".$new_name);
    $images = "data/setting/".$folder."/".$last_id_bannet."/".$lang."/".$new_name;
    $up = " `banner_img_path`= '$images' ,banner_img_name = '$new_name', ";

  }else{
    copy($_FILES["pic_upload_en"]["tmp_name"],"../../data/setting/".$folder."/".$last_id_bannet."/".$lang."/".$new_name);
    $images = "data/setting/".$folder."/".$last_id_bannet."/".$lang."/".$new_name;
    $up = " `banner_img_path_en`= '$images' ,banner_img_name_en = '$new_name', ";
  }

   $sql_update = " UPDATE `Banner` SET
                      $up
                     banner_create_datetime = '$date_setting'
                     ,banner_createBy_id = '$emp_id'
                   WHERE banner_id  = $last_id_bannet ";
   $query_update = $conn->query($sql_update);
   return $query_update;
}

  if(isset($_GET["method"]) && $_GET["method"]=="add_banner"){
      // include("../../config/config.php");

      if($_POST['id_edit']==''){
        if($_FILES['pic_upload']['name']==''){
          ?><script type="text/javascript">parent.iziToast_func.alert("กรุณาเลือกรูป (ไทย)");</script><?php
          exit();
        }
        if($_FILES['pic_upload_en']['name']==''){
          ?><script type="text/javascript">parent.iziToast_func.alert("กรุณาเลือกรูป (Eng)");</script><?php
          exit();
        }
      }
       if ($_FILES['pic_upload']['name']){
         $img_th = type_imp('1');
       }
         if($_FILES['pic_upload_en']['name']){
         $img_en = type_imp('0');
       }

      $select_max = "SELECT max(banner_up_dow) as max_upbown FROM `Banner` WHERE  banner_status = 0 " ;
      $query_max = $conn->query($select_max);
      $result_max = $query_max->fetch_assoc();
      $max = $result_max['max_upbown'];
      $max = $max+1;

        $new_name =  uniqid().'.'.$img_th;
        $new_name_en =  uniqid().'.'.$img_en;

      if($_POST['id_edit']==''){
         $sql_name = "INSERT INTO `Banner`(`banner_img_name`,`banner_img_name_en`,banner_enable,banner_up_dow)
                      VALUES ('$new_name','$new_name_en','".$_POST['status']."','$max')";
         $query_name = $conn->query($sql_name);
         $last_id_bannet  = $conn->insert_id;
      }else{
         $last_id_bannet  =  $_POST['id_edit'];
         $sql_update = "UPDATE `Banner` SET
                          `banner_enable`= '".$_POST['status']."'
                        WHERE banner_id  = $last_id_bannet ";
         $query_update = $conn->query($sql_update);
       }
       $folder = 'banner';
      if($_FILES['pic_upload']['name']){
        $query_update = edit_img_banner($folder,$last_id_bannet,'1',$new_name);
      }
       if($_FILES['pic_upload_en']['name']){
        $query_update = edit_img_banner($folder,$last_id_bannet,'0',$new_name_en);
      }

     if ($query_name || $query_update){
       if($query_name){
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
       }else{
         ?><script type="text/javascript">//alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php

       }
     }else {
       ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
     }
     exit();
  }


if ($_POST['method']=="fun_up"){
   include("../../config/config.php");
    $sql_banner_update1 = " update Banner
                            set banner_up_dow = '".$_POST['level']."'
                            ,banner_update_datetime = '$date_setting'
                            ,banner_updateBy_id = '$emp_id'
                            where banner_up_dow > '".$_POST['level']."'
                            AND banner_status = 0 ORDER BY banner_up_dow ASC  LIMIT 1";
    $query_banner_update1 = $conn->query($sql_banner_update1);
    $sql_banner_update = "update Banner set
                          banner_up_dow = banner_up_dow+1
                          ,banner_update_datetime = '$date_setting'
                          ,banner_updateBy_id = '$emp_id'
                          where banner_id = '".$_POST['id']."' AND banner_status = 0 ORDER BY banner_up_dow ASC  LIMIT 1 ";
    $query_banner_update = $conn->query($sql_banner_update);


    $lv = 1 ;
    $sql_select = "SELECT * FROM `Banner` WHERE `banner_status` = 0 ORDER BY `Banner`.`banner_up_dow` ASC ";
    $query_select = $conn->query($sql_select);
      while($result_select = $query_select->fetch_assoc()){
        $sql_banner_update = "update Banner set banner_up_dow = '$lv' where banner_id = '".$result_select['banner_id']."' ";
        $query_banner_update = $conn->query($sql_banner_update);
        $lv++;
      }
    if ($query_banner_update){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}



if ($_POST['method']=="fun_down"){
   include("../../config/config.php");

   $sql_addcat1 = "SELECT * FROM Banner where banner_up_dow < ".$_POST['level']." AND banner_status = 0   order by banner_up_dow DESC  limit 1  ";
   $query_addcat1 = $conn->query($sql_addcat1);
   if ($query_addcat1->num_rows >0)
   {
     while($result_addcat1 = $query_addcat1->fetch_assoc())
     {
       $bid =	$result_addcat1['banner_id'];
       $bid_level =	$result_addcat1['banner_up_dow'];
     }
   }
   $sql_banner_update1 = "update Banner set banner_up_dow = '".$bid_level."'  where banner_id = '".$_POST['id']."' ";
   $query_banner_update1 = $conn->query($sql_banner_update1);
   if($query_banner_update1){
     $sql_banner_update2 = "update Banner set
                              banner_up_dow = ".(int)$bid_level."+1
                             ,banner_update_datetime = '$date_setting'
                             ,banner_updateBy_id = '$emp_id'
                             where banner_id = '".$bid."' ";
     $query_banner_update2 = $conn->query($sql_banner_update2);
   }

   $lv = 1 ;
   $sql_select = "SELECT * FROM `Banner` WHERE `banner_status` = 0 ORDER BY `Banner`.`banner_up_dow` ASC ";
   $query_select = $conn->query($sql_select);
     while($result_select = $query_select->fetch_assoc()){
       $sql_banner_update = "update Banner set
                              banner_up_dow = '$lv'
                              ,banner_update_datetime = '$date_setting'
                              ,banner_updateBy_id = '$emp_id'
                              where banner_id = '".$result_select['banner_id']."' ";
       $query_banner_update = $conn->query($sql_banner_update);
       $lv++;
     }

   if($query_banner_update2){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}


if ($_POST['method']=="get_data_banner"){
   include("../../config/config.php");
       $sql_select = "SELECT * FROM Banner where banner_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['banner_enable']=$result_select['banner_enable'];
           if(!file_exists('../../'.$result_select['banner_img_path']) || $result_select['banner_img_path'] =='' ) {
             $pic_link = "";
           }else{
            $pic_link = '<img  id="output" class="img_pre_banner" src="../../'.$result_select['banner_img_path'].'">';
            $pic_link_en = '<img  id="output" class="img_pre_banner" src="../../'.$result_select['banner_img_path_en'].'">';
           }
           $array_row['img_view']=$pic_link;
           $array_row['img_view_en']=$pic_link_en;
           $array_row['path_view']= "../../".$result_select['banner_img_path'];
           $array_row['path_view_en']= "../../".$result_select['banner_img_path_en'];
         }
       }
       echo json_encode($array_row);
       exit();
}

if ($_POST['method']=="del_banner"){
   include("../../config/config.php");
    $sql_edit_pass = "UPDATE  Banner SET banner_status = '1' where  banner_id = '".$_POST['id_p']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
        echo '0';
    }else {
        echo "1";
    }
    exit();
}




if(isset($_GET["method"]) && $_GET["method"]=="get_complaint_procedure"){
    $post = array();
    $request_body = file_get_contents('php://input');
    $post = json_decode($request_body);
    $response = get_complaint_procedure($post);
    echo $response;
exit();
}

function get_complaint_procedure($post){
  global $member_cls;
   include("../../config/config.php");

   $select_max = "SELECT MAX(cpp_up_dow) as max_upbown ,MIN(cpp_up_dow) as min_upbown  FROM Complaint_procedure WHERE  cpp_status = 0 " ;
   $query_max = $conn->query($select_max);
   $result_max = $query_max->fetch_assoc();
   $max = $result_max['max_upbown'];
   $min = $result_max['min_upbown'];

   $caseCh_arr = array();
   $sql_caseCh = "SELECT * ";
   $sql_caseCh .= " FROM Complaint_procedure WHERE cpp_status = '0'   ";

  if($post->sort=="id"){
    $sort_col = "cpp_up_dow";
  }
  if($post->sort=="type"){
    $sort_col = "cpp_enable";
  }
  if($post->status_m != ""){
    $sql_caseCh .= "  AND cpp_enable = '".$post->status_m."' ";
  }
  if($post->text != ""){
    $sql_caseCh .= "AND (cpp_detail LIKE '%".$post->text."%' or cpp_detail_en LIKE '%".$post->text."%') ";
  }


  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0+$post->offset;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["detail"] = '<span class="txt_nol">'.$re['cpp_detail'].'</span>';
       $caseCh_col_arr["detail_en"] = '<span class="txt_nol">'.$re['cpp_detail_en'].'</span>';

       $caseCh_col_arr["name"] = '<div class="center_cpp"><img class="img_banner" src="../../../'.$re['cpp_img_path'].'" alt="Smiley face"></div>';
         if($re['cpp_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }

           $del =   '<div class="th_user_edit_1"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_cpp('.$re['cpp_id'].');"></span>
                    <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_cpp('.$re['cpp_id'].');"></span></div>';



      if($max==$re['cpp_up_dow']){
        $dis= "disabled" ;
      }else{
        $dis = 'onclick="Confirmupdown() && fun_up_cpp('.$re['cpp_id'].','.$re['cpp_up_dow'].');"';
      }
      if($min==$re['cpp_up_dow']){
        $dis_min= "disabled" ;
      }else{
        $dis_min = 'onclick="Confirmupdown() && fun_down_cpp('.$re['cpp_id'].','.$re['cpp_up_dow'].');"';
      }

     $caseCh_col_arr["up_down"] = '<div class="btn_up_do"><button style="height: 27px;" type="button" class="btn btn-default" data-dismiss="modal"  '.$dis.' >
                                  <i style="top: 2px; position: relative; font-size: 20px;" class="fa fa-sort-asc" aria-hidden="true"></i>
                                  </button>
                                  <button style="height: 27px;"  type="button" class="btn btn-default" data-dismiss="modal" '.$dis_min.'>
                                  <i style="top: -2px; position: relative; font-size: 20px;" class="fa fa-caret-down" aria-hidden="true"></i>
                                  </button></div>';

        $caseCh_col_arr["view"] = $view;
        $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}



if(isset($_GET["method"]) && $_GET["method"]=="add_cpp"){



    if ($_FILES['pic_upload']['name']){
      $images = $_FILES["pic_upload"]["tmp_name"];
      $image_type = $_FILES['pic_upload']['type'];
      if ($image_type=="image/png"){
        $image_set_type = "png";
      }
      if ($image_type=="image/gif"){
        $image_set_type = "gif";
      }
      if ($image_type=="image/svg+xml"){
        $image_set_type = "svg";
      }
      if ($image_type=="image/jpg"){
        $image_set_type = "jpg";
      }
      if ($image_type=="image/jpeg"){
        $image_set_type = "jpeg";
      }


      $size=GetimageSize($images);
      if ($size[0]!=240 || $size[1]!=180)
      {
        ?><script type="text/javascript">parent.iziToast_func.alert("Images size (240*180)px Only");</script><?php
        exit();
      }

    }
    if($_POST['detail']==''){
      ?><script type="text/javascript">parent.iziToast_func.alert("กรุณากรอกรายละเอียด (ภาษาไทย)");</script><?php
      exit();
    }
    if($_POST['detail_en']==''){
      ?><script type="text/javascript">parent.iziToast_func.alert("กรุณากรอกรายละเอียด (ภาษาอังกฤษ)");</script><?php
      exit();
    }


    if($_POST['id_edit']==''){
      if($_FILES['pic_upload']['name']==''){
        ?><script type="text/javascript">parent.iziToast_func.alert("กรุณาเลือกรูป");</script><?php
        exit();
      }
    }

    $select_max = "SELECT max(cpp_up_dow) as max_upbown FROM `Complaint_procedure` WHERE  cpp_status = 0 " ;
    $query_max = $conn->query($select_max);
    $result_max = $query_max->fetch_assoc();
    $max = $result_max['max_upbown'];
    $max = $max+1;
     $new_name =  uniqid().'.'.$image_set_type;
      if($_POST['id_edit']==''){

         $sql_name = "INSERT INTO `Complaint_procedure`(cpp_img_name,cpp_enable,cpp_up_dow,cpp_detail,cpp_detail_en)
                        VALUES ('$new_name','".$_POST['status']."','$max','".$_POST['detail']."','".$_POST['detail_en']."' )";
         $query_name = $conn->query($sql_name);
         $last_id_bannet  = $conn->insert_id;
       }else{
           $last_id_bannet  =  $_POST['id_edit'];
           $sql_update = "UPDATE `Complaint_procedure` SET `cpp_enable`= '".$_POST['status']."' ,cpp_detail ='".$_POST['detail']."',cpp_detail_en ='".$_POST['detail_en']."'  WHERE cpp_id  = $last_id_bannet ";
           $query_update = $conn->query($sql_update);
        }
         $folder = 'complaint_procedure';

         if ($_FILES['pic_upload']['name']!=''){
           deleteDirectory("../../data/setting/".$folder."/".$last_id_bannet);
           if (!is_dir("../../data/setting")){
                 mkdir("../../data/setting", 0775, true);
           }
           if (!is_dir("../../data/setting/".$folder."")){
               mkdir("../../data/setting/".$folder."", 0775, true);
           }
           if (!is_dir("../../data/setting/".$folder."")){
               mkdir("../../data/setting/".$folder."", 0775, true);
           }
           if (!is_dir("../../data/setting/".$folder."/".$last_id_bannet)){
               mkdir("../../data/setting/".$folder."/".$last_id_bannet, 0775, true);
           }
           copy($_FILES["pic_upload"]["tmp_name"],"../../data/setting/".$folder."/".$last_id_bannet."/".$new_name);
           $images = "data/setting/".$folder."/".$last_id_bannet."/".$new_name;
            $sql_update = "UPDATE `Complaint_procedure` SET `cpp_img_path`= '$images' WHERE cpp_id  = $last_id_bannet ";
            $query_update = $conn->query($sql_update);
            }
         if ($query_name || $query_update){
           if($query_name){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else{
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.refresh_table();</script><?php
           }
         }else {
           ?><script type="text/javascript">parent.iziToast_func.alert('บันทึกข้อมูลผิดพลาด');</script><?php
         }
         exit();
}



if ($_POST['method']=="get_data_cpp"){
   include("../../config/config.php");
       $sql_select = "SELECT * FROM Complaint_procedure where cpp_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['cpp_detail']=$result_select['cpp_detail'];
           $array_row['cpp_detail_en']=$result_select['cpp_detail_en'];
           $array_row['cpp_enable']=$result_select['cpp_enable'];

           if(!file_exists('../../'.$result_select['cpp_img_path']) || $result_select['cpp_img_path'] =='' ) {
             $pic_link = "";
           }else{
               $pic_link = '<img  id="output" class="img_pre_cpp" src="../../'.$result_select['cpp_img_path'].'"></i>';
           }
           $array_row['img_view']=$pic_link;
           $array_row['path_view']= "../../".$result_select['cpp_img_path'];


         }
       }
       echo json_encode($array_row);
       exit();
}


if ($_POST['method']=="del_cpp"){
   include("../../config/config.php");
    $sql_edit_pass = "UPDATE  Complaint_procedure SET cpp_status = '1' where  cpp_id = '".$_POST['id_p']."'";
    $query_edit_pass = $conn->query($sql_edit_pass);

    $lv = 1 ;
    $sql_select = "SELECT * FROM `Complaint_procedure` WHERE `cpp_status` = 0 ORDER BY `Complaint_procedure`.`cpp_up_dow` ASC ";
    $query_select = $conn->query($sql_select);
      while($result_select = $query_select->fetch_assoc()){
        $sql_banner_update = "update Complaint_procedure set cpp_up_dow = '$lv' where cpp_id = '".$result_select['cpp_id']."' ";
        $query_banner_update = $conn->query($sql_banner_update);
        $lv++;
      }

    if ($query_edit_pass){
        echo '0';
    }else {
        echo "1";
    }
    exit();
}



if ($_POST['method']=="fun_up_cpp"){
   include("../../config/config.php");
    $sql_banner_update1 = " update Complaint_procedure set cpp_up_dow = '".$_POST['level']."'
                            where cpp_up_dow > '".$_POST['level']."' AND cpp_status = 0 ORDER BY cpp_up_dow ASC  LIMIT 1";
    $query_banner_update1 = $conn->query($sql_banner_update1);
    $sql_banner_update = "update Complaint_procedure set cpp_up_dow = cpp_up_dow+1  where cpp_id = '".$_POST['id']."' AND cpp_status = 0 ORDER BY cpp_up_dow ASC  LIMIT 1 ";
    $query_banner_update = $conn->query($sql_banner_update);


    $lv = 1 ;
    $sql_select = "SELECT * FROM `Complaint_procedure` WHERE `cpp_status` = 0 ORDER BY `Complaint_procedure`.`cpp_up_dow` ASC ";
    $query_select = $conn->query($sql_select);
      while($result_select = $query_select->fetch_assoc()){
        $sql_banner_update = "update Complaint_procedure set cpp_up_dow = '$lv' where cpp_id = '".$result_select['cpp_id']."' ";
        $query_banner_update = $conn->query($sql_banner_update);
        $lv++;
      }
    if ($query_banner_update){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}


if ($_POST['method']=="fun_down_cpp"){
   include("../../config/config.php");

   $sql_addcat1 = "SELECT * FROM Complaint_procedure where cpp_up_dow < ".$_POST['level']." AND cpp_status = 0   order by cpp_up_dow DESC  limit 1  ";
   $query_addcat1 = $conn->query($sql_addcat1);
   if ($query_addcat1->num_rows >0)
   {
     while($result_addcat1 = $query_addcat1->fetch_assoc())
     {
       $bid =	$result_addcat1['cpp_id'];
       $bid_level =	$result_addcat1['cpp_up_dow'];
     }
   }
   $sql_banner_update1 = "update Complaint_procedure set cpp_up_dow = '".$bid_level."'  where cpp_id = '".$_POST['id']."' ";
   $query_banner_update1 = $conn->query($sql_banner_update1);
   if($query_banner_update1){
     $sql_banner_update2 = "update Complaint_procedure set cpp_up_dow = ".(int)$bid_level."+1  where cpp_id = '".$bid."' ";
     $query_banner_update2 = $conn->query($sql_banner_update2);
   }

   $lv = 1 ;
   $sql_select = "SELECT * FROM `Complaint_procedure` WHERE `cpp_status` = 0 ORDER BY `Complaint_procedure`.`cpp_up_dow` ASC ";
   $query_select = $conn->query($sql_select);
     while($result_select = $query_select->fetch_assoc()){
       $sql_banner_update = "update Complaint_procedure set cpp_up_dow = '$lv' where cpp_id = '".$result_select['cpp_id']."' ";
       $query_banner_update = $conn->query($sql_banner_update);
       $lv++;
     }

   if($query_banner_update2){
        echo '1';
    }else {
        echo "0";
    }
    exit();
}



  if($_POST['method']=='select_depart'){
    include("../../config/config.php");

  	?>
    <div class="col-md-4 ">
      <label for="message-text" class="control-label">ประเทศ<label class="txt_no_remark">*</label></label>
    </div>
    <div class="col-md-8">
      <select class="selectpicker col-xs-2 chosen-select-dissearch display_block" data-live-search="true" name="Country" id="Country" data-width="100%">
        <option value="">--- เลือกประเทศ ---</option>
        <?php
        $sql_ch_form = "  SELECT id,name  FROM Country
                          where country_status = 0 AND continent_code = '".$_POST['id']."' ORDER BY id=162 DESC, name ASC";
        $query_ch_form = $conn->query($sql_ch_form);
        if ($query_ch_form->num_rows >0) {
          while ($re = $query_ch_form->fetch_assoc()) {
            ?>
            <option value="<?=$re['id']?>"><?=$re['name']?></option>
            <?php
          }
        } ?>
      </select>
    </div>
  	<?php
  	exit();
  }



  if(isset($_GET["method"]) && $_GET["method"]=="import_department"){
  //   if (!is_dir("../../data/setting")){
  //         mkdir("../../data/setting", 0775, true);
  //   }
  //   if (!is_dir("../../data/setting/template")){
  //       mkdir("../../data/setting/template", 0775, true);
  //   }
  //   $AA = 'Template_department.xlsx';
  //   unlink("../../data/setting/template/". $AA);
  //   move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../data/setting/template/". $AA);
  //
  //
  // exit();


    if (!is_dir("../../data/setting")){
          mkdir("../../data/setting", 0775, true);
    }
    if (!is_dir("../../data/setting/import_department")){
        mkdir("../../data/setting/import_department", 0775, true);
    }

      if($_FILES["userimport"]["size"]) {
        $new_excel = date('Y').date('m').date('d').date('H').date('i').date('s').mt_rand(100000,999999).".xlsx";
        move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../data/setting/import_department/". $new_excel);
        $inputFileName = "../../data/setting/import_department/".$new_excel;

        ?><script type="text/javascript">top.import_department('<?= $inputFileName ?>');</script><?php
      }
      else {
         ?><script type="text/javascript">parent.iziToast_func.alert('Plese Insert Excel File (.xlsx)');</script><?php
        exit();
      }
  }







    if(isset($_GET["method"]) && $_GET["method"]=="getloglogin"){
        $post = array();
        $request_body = file_get_contents('php://input');
        $post = json_decode($request_body);
        $response = getloglogin($post);
        echo $response;
    exit();
    }

      function getloglogin($post){
        global $member_cls;
         include("../../config/config.php");


         $caseCh_arr = array();
         $sql_caseCh = "SELECT a.log_username,a.log_datetime,c.empGroup_name,a.log_status FROM Log_Login_Employee as a
                        left JOIN Employee as b on a.log_username  = b.emp_email
                        left JOIN Employee_Group as c on c.empGroup_id  = b.empGroup_id
                        WHERE  `log_username` NOT IN ('ditp.admin@ditp.go.th', 'manager@gmail.com')
                        ";

        if($post->sort=="log_id"){
          $sort_col = "a.log_id";
        }else{
          $sort_col = "a.log_id";
        }
        if($post->sort=="2"){
          $sort_col = "a.log_username";
        }
        if($post->sort=="3"){
          $sort_col = "a.log_status";
        }
        if($post->sort=="4"){
          $sort_col = "c.empGroup_name";
        }
        if($post->sort=="5"){
          $sort_col = "a.log_datetime";
        }
        if($post->text != ""){
          $sql_caseCh .= "  AND a.log_username LIKE '%".$post->text."%' ";
        }
        if($post->status_m != ""){
          $sql_caseCh .= "  AND c.empGroup_id = '".$post->status_m."' ";
        }

        $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
        // echo $sql_caseCh;
        $query_edit_pass_all = $conn->query($sql_caseCh);
        $num = $query_edit_pass_all->num_rows;
        $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
           $query_edit_pass = $conn->query($sql_caseCh);
           $co_id = 0+$post->offset;
           while ($re = $query_edit_pass->fetch_assoc()) {
             $caseCh_col_arr = array();
             $co_id++ ;
             $caseCh_col_arr["1"] = '<span class="txt_nol">'.$co_id.'</span>';
             $caseCh_col_arr["2"] = '<span class="txt_nol">'.$re['log_username'].'</span>';
             if($re['log_status']=='1'){
               $caseCh_col_arr["3"] = '<span class="txt_nol" style=" color: #39B54A;">ล็อกอินสำเร็จ</span>';
             }else{
               $caseCh_col_arr["3"] = '<span class="txt_nol" style=" color: #F7931E;">ล็อกอินไม่สำเร็จ</span>';
             }
             $caseCh_col_arr["4"] = '<span class="txt_nol">'.$re['empGroup_name'].'</span>';
             $new_date = date("d/m/Y H:i:s", strtotime($re['log_datetime']));
             $caseCh_col_arr["5"] = '<span class="txt_nol">'.$new_date.'</span>';
             array_push($caseCh_arr,$caseCh_col_arr);
           }
           $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
           return json_encode($data_array);
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

 ?>
