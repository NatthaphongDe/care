<?php
 include("../../config/config.php");
 $date_setting = date("Y-m-d h:i:sa");
 $emp_id = $_SESSION["admin"]["empId"];

if(isset($_GET["method"]) && $_GET["method"]=="add_channel"){
 	 include("../../config/config.php");

    $add_name = data_filter(trim($_POST['add_name']));
    $radio_ststus = data_filter(trim($_POST['radio_ststus']));
    $id_edit = data_filter(trim($_POST['id_edit']));

   if($add_name == ''){
     ?><script type="text/javascript">alert('กรุณากรอกชื่อ');</script><?php
     exit();
   }

   if($id_edit==''){
     $sql_edit_pass = " INSERT INTO Case_Channel  (caseCh_name,caseCh_enable,caseCh_create_datetime,caseCh_createBy_id)
                        VALUES ('$add_name', '$radio_ststus','$date_setting','$emp_id') ";
      $query_edit_pass = $conn->query($sql_edit_pass);
   }else{
    $sql_edit_pass = "UPDATE  Case_Channel SET
                             caseCh_name = '$add_name'
                             ,caseCh_enable   = '$radio_ststus'
                             ,caseCh_update_datetime = '$date_setting'
                             ,caseCh_updateBy_id = '$emp_id'
                             where  caseCh_id = '$id_edit' ";
      $query_edit_pass = $conn->query($sql_edit_pass);
   }
    if($query_edit_pass){
      ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
      exit();
    }
    if (trim($_POST['form_set']) == '' ){
      ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
      exit();
    }
 }


 if ($_POST['method']=="get_data_channel"){
    include("../../config/config.php");

    		$sql_select = "SELECT caseCh_name , caseCh_enable  FROM Case_Channel where caseCh_id = '".$_POST['id']."'";
    		$query_select = $conn->query($sql_select);
    		$array_row = array();
    		if ($query_select->num_rows >0)
    		{
    			while($result_select = $query_select->fetch_assoc())
    			{
    				$array_row['caseCh_name']=$result_select['caseCh_name'];
    				$array_row['caseCh_enable']=$result_select['caseCh_enable'];
          }
        }
        echo json_encode($array_row);
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
   $sql_caseCh .= "FROM Case_Channel WHERE caseCh_status = '0' ";

   if($post->text != ""){
     $sql_caseCh .= "AND caseCh_name LIKE '%".$post->text."%' ";
   }
   if($post->sort=="id"){
     $sort_col = "caseCh_id";
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
       $caseCh_col_arr["view"] = $view;

       $sql_ch = "  SELECT caseCh_id FROM `Case` WHERE `caseCh_id` =  '".$re['caseCh_id']."'  ";
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
     $sql_caseCh .= "AND prodType_name LIKE '%".$post->text."%' ";
   }
   if($post->sort=="id"){
     $sort_col = "prodType_id";
   }
  if($post->sort=="name"){
    $sort_col = "prodType_name";
  }
  $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
  $query_edit_pass_all = $conn->query($sql_caseCh);
  $num = $query_edit_pass_all->num_rows;
  $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
     $query_edit_pass = $conn->query($sql_caseCh);
     $co_id = 0;
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<a href="?page=product_detail&id_product='.$re['prodType_id'].'"><span class="txt_nol">'.$re['prodType_name'].'</span></a>';
         if($re['prodType_enable'] == '1'){
           $view ='<span class="icon-ico-ditp-12 view_1">';
         }else{
           $view ='<span class="icon-ico-ditp-13  view_2">';
         }
       $caseCh_col_arr["view"] = $view;
       $sql_ch = "  SELECT prodType_id FROM `Case` WHERE `prodType_id` =  '".$re['prodType_id']."'  ";
       $query_ch = $conn->query($sql_ch);
       if($query_ch->num_rows > 0){
         $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
       }else{
         $del = ' <span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_product('.$re['prodType_id'].');"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_product('.$re['prodType_id'].');"></span>';
        }
       $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}

if(isset($_GET["method"]) && $_GET["method"]=="add_product"){
    include("../../config/config.php");

  if (trim($_POST['add_name']) == '' ){
    ?><script type="text/javascript">alert('กรุณาใส่ชื่อประเภทสินค้า');</script><?php
    exit();
  }
  if ($_POST['radio_url_cms'] == 1){
      $prodType_enable = '1';
  }else{
      $prodType_enable = '0';
  }

    $sql_edit_pass = "  INSERT INTO Product_Type  (prodType_name,prodType_level,prodType_enable,prodType_create_datetime,prodType_createBy_id)
                        VALUES ('".trim($_POST['add_name'])."', 1, '$prodType_enable','$date_setting','$emp_id') ";
   $query_edit_pass = $conn->query($sql_edit_pass);
   if ($query_edit_pass){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else {
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();

}

if ($_POST['method']=="get_data_prouuct"){
   include("../../config/config.php");

       $sql_select = "SELECT prodType_name , prodType_enable  FROM Product_Type where prodType_id = '".$_POST['id']."'";
       $query_select = $conn->query($sql_select);
       $array_row = array();
       if ($query_select->num_rows >0)
       {
         while($result_select = $query_select->fetch_assoc())
         {
           $array_row['name']=$result_select['prodType_name'];
           $array_row['enable']=$result_select['prodType_enable'];
         }
       }
       echo json_encode($array_row);
       exit();
}

if ($_GET['method']=="save_product"){
   include("../../config/config.php");
   if (trim($_POST['edit_name']) == ''){
     ?><script type="text/javascript">alert('กรุณาใส่ชื่อประเภทสินค้า');</script><?php
     exit();
   }
   if ($_POST['radio_url_cms'] == 1){
       $prodType_status = '1';
   }else{
       $prodType_status = '0';
   }
       $sql_edit_pass = "UPDATE  Product_Type SET
                               prodType_name = '".trim($_POST['edit_name'])."'
                               ,prodType_level   = '1'
                               ,prodType_enable   = '$prodType_status'
                               ,prodType_update_datetime = '$date_setting'
                               ,prodType_updateBy_idateBy_id = '$emp_id'
                               where  prodType_id = '".$_POST['id_edit']."'";
        $query_edit_pass = $conn->query($sql_edit_pass);
        if ($query_edit_pass){
          ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        }else {
          ?><script type="text/javascript">alert('แก้ไขข้อมูลผิดพลาด');</script><?php
        }
        exit();
}


 if ($_POST['method']=="del_product"){
    include("../../config/config.php");

  $sql_select = "SELECT * FROM Product_Type where prodType_id = '".$_POST['id_p']."' and prodType_status = '0'";
  $query_select = $conn->query($sql_select);
   $array_row = array();
  if ($query_select->num_rows >0)
  {
    echo '22';
    exit();
  }
      $sql_edit_pass = "UPDATE  Product_Type SET prodType_status = '1' where  prodType_ref_id = '".$_POST['id_p']."'";
     $query_edit_pass = $conn->query($sql_edit_pass);
     if ($query_edit_pass){
         echo '11';
     }else {
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

    $caseCh_arr = array();
     $sql_caseCh = "SELECT *  ";
    $sql_caseCh .= "FROM Product_Type WHERE  prodType_ref_id =  '".$post->id_product."' AND prodType_status = '0' AND prodType_level = 2 ";

    if($post->text != ""){
      $sql_caseCh .= "and prodType_name LIKE '%".$post->text."%' ";
    }
    if($post->sort=="id"){
      $sort_col = "prodType_id";
    }
   if($post->sort=="name"){
     $sort_col = "prodType_name";
   }
   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
        $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['prodType_name'].'</span>';
          if($re['prodType_enable'] == '1'){
            $view ='<span class="icon-ico-ditp-12 view_1">';
          }else{
            $view ='<span class="icon-ico-ditp-13  view_2">';
          }
        $caseCh_col_arr["view"] = $view;

        $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_product_detail('.$re['prodType_id'].');"></span>
        <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete() && del_product_detail('.$re['prodType_id'].');"></span>';

        $caseCh_col_arr["del_edit"] = $del;
        array_push($caseCh_arr,$caseCh_col_arr);
      }
      $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
      return json_encode($data_array);
 }



 if(isset($_GET["method"]) && $_GET["method"]=="add_product_detail"){
     include("../../config/config.php");

   if (trim($_POST['add_name']) == '' ){
     ?><script type="text/javascript">alert('กรุณาใส่ชื่อ');</script><?php
     exit();
   }
   if ($_POST['radio_url_cms'] == 1){
       $prodType_status = '1';
   }else{
       $prodType_status = '0';
   }
   $sql_edit_pass = " INSERT INTO Product_Type  (prodType_name,prodType_enable,prodType_level,prodType_ref_id,prodType_create_datetime,prodType_createBy_id)
                      VALUES ('".trim($_POST['add_name'])."', '$prodType_status',2,'".$_POST['type_p']."','$date_setting','$emp_id') ";
    $query_edit_pass = $conn->query($sql_edit_pass);
    if ($query_edit_pass){
      ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
    }else {
      ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
    }
    exit();
 }

 if ($_POST['method']=="get_data_prouuct_detail"){
    include("../../config/config.php");
        $sql_select = "SELECT prodType_name , prodType_enable  FROM Product_Type where prodType_id = '".$_POST['id']."'";
        $query_select = $conn->query($sql_select);
        $array_row = array();
        if ($query_select->num_rows >0)
        {
          while($result_select = $query_select->fetch_assoc())
          {
            $array_row['name']=$result_select['prodType_name'];
            $array_row['enable']=$result_select['prodType_enable'];
          }
        }
        echo json_encode($array_row);
        exit();
 }



  if ($_GET['method']=="edit_product"){
     include("../../config/config.php");
     if (trim($_POST['edit_name']) == ''){
       ?><script type="text/javascript">alert('กรุณาใส่ชื่อประเภทสินค้า');</script><?php
       exit();
     }
     if ($_POST['radio_url_cms'] == 1){
         $prodType_status = '1';
     }else{
         $prodType_status = '0';
     }
         $sql_edit_pass = "UPDATE  Product_Type SET
                                   prodType_name = '".trim($_POST['edit_name'])."'
                                   ,prodType_level   = '2'
                                   ,prodType_enable   = '$prodType_status'
                                   ,prodType_update_datetime  = '$date_setting'
                                   ,prodType_updateBy_idateBy_id = '$emp_id'
                                 where  prodType_id = '".$_POST['id_edit']."'";
          $query_edit_pass = $conn->query($sql_edit_pass);
          if ($query_edit_pass){
            ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
          }else {
            ?><script type="text/javascript">alert('แก้ไขข้อมูลผิดพลาด');</script><?php
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
      include("../../config/config.php");

      if (trim($_POST['add_name']) == '' ){
        ?><script type="text/javascript">alert('กรุณาใส่ชื่อ');</script><?php
        exit();
      }
        if($_POST['radio_add'] == '1'){
          $radio_add = '1';
        }else{
          $radio_add = '2';
        }

      if($_POST['Complaint_Type']==0){
        if (trim($_POST['add_day']) == '' ){
          ?><script type="text/javascript">alert('กรุณากรอกระยะเวลาในการดำเนินการ');</script><?php
          exit();
        }


        $sql_insert = " INSERT INTO Complaint_Type (compType_section,compType_name,compType_duration,compType_create_datetime,compType_createBy_id)
                           VALUES ('$radio_add','".trim($_POST['add_name'])."','".trim($_POST['add_day'])."','$date_setting','$emp_id') ";
         $query_insert = $conn->query($sql_insert);
           if ($query_insert){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else {
             ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
           }


      }else if($_POST['Complaint_Type_1']==0){



        $sql_insert = " INSERT INTO Complaint_Type_Sub1 (compType_id,compTypeSub1_name,compTypeSub1_create_datetime,compTypeSub1_createBy_id)
                           VALUES ('".$_POST['Complaint_Type']."','".trim($_POST['add_name'])."','$date_setting','$emp_id') ";
         $query_insert = $conn->query($sql_insert);
           if ($query_insert){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else {
             ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
           }


      }else if($_POST['Complaint_Type_1']!=0 && $_POST['Complaint_Type_1']!='' ){

        $sql_insert = " INSERT INTO Complaint_Type_Sub2 (compTypeSub1_id,compTypeSub2_name,compTypeSub2_create_datetime,compTypeSub2_createBy_id)
                           VALUES ('".$_POST['Complaint_Type_1']."','".trim($_POST['add_name'])."','$date_setting','$emp_id') ";
         $query_insert = $conn->query($sql_insert);
           if ($query_insert){
             ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
           }else {
             ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
           }


      }
exit();

  }


  if($_POST['method']=='sub_type_complaint'){
    include("../../config/config.php");

  	?>
    <div class="row form-group">
      <div class="col-md-4 ">
        <label for="recipient-name" class="control-label">ประเภทเรื่องร้องเรียนย่อย</label>
      </div>
      <div class="col-md-8 ">
        <select class="selectpicker Complaint_Type_1"  data-width="auto" name="Complaint_Type_1"  id="Complaint_Type_1" onchange="sub_type_complaint_sub();">
          <?php
          $sql_select = "SELECT compTypeSub1_id,compTypeSub1_name FROM Complaint_Type_Sub1 where compType_id = '".$_POST['id_type']."' ";
          $query_select = $conn->query($sql_select);
          if($query_select->num_rows > 0){
            ?>  <option value="0">เลือกประเภทเรื่องร้องเรียนย่อย</option><?php
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
       $co_id = 0;
       while ($re = $query_edit_pass->fetch_assoc()) {
         $caseCh_col_arr = array();
         $co_id++ ;


           if($re['process_type_section'] == '1'){
             $type='<span class="type_general">ทั่วไป</span>';
           }else{
             $type ='<span class="type_law">นิติการ</span>';
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
          $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
        }else{
          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_process('.$re['process_type_id'].');"></span>
                <span class="icon-ico-ditp-28 cursor txt_no_del" onclick="ConfirmDelete()&&del_process('.$re['process_type_id'].');"></span>';
       }
         $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
         $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['process_type_name'].'</span>';
         $caseCh_col_arr["type"] = $type;
         $caseCh_col_arr["step"] = '<span class="txt_nol">'.$step.'</span>';
         $caseCh_col_arr["duration"] = '<span class="txt_nol">'.$re['process_type_duration'].'</span>';
         $caseCh_col_arr["del_edit"] = $del;
         array_push($caseCh_arr,$caseCh_col_arr);
       }
       $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
       return json_encode($data_array);
  }


  if(isset($_GET["method"]) && $_GET["method"]=="add_process"){
      include("../../config/config.php");

    if (trim($_POST['add_name']) == '' ){
      ?><script type="text/javascript">alert('กรุณากรอกชื่อกระบวนการย่อย');</script><?php
      exit();
    }
    if (trim($_POST['add_day']) == '' ){
      ?><script type="text/javascript">alert('กรุณากำหนดเวลา');</script><?php
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

    $sql_Process_Type = " INSERT INTO Process_Type (process_type_name,process_type_step,process_type_duration,process_type_enable,process_type_section,process_type_create_datetime,process_type_createBy_id)
                       VALUES ('".trim($_POST['add_name'])."','$radio_step','".trim($_POST['add_day'])."','$radio_enable','$radio_section','$date_setting','$emp_id') ";
     $query_Process_Type = $conn->query($sql_Process_Type);
       if ($query_Process_Type){
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
       }else {
         ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
       }

       exit();


}
if ($_POST['method']=="get_data_process"){
   include("../../config/config.php");

       $sql_select = "  SELECT process_type_name,process_type_step,process_type_duration,process_type_enable,process_type_section
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

         }
       }
       echo json_encode($array_row);
       exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="save_process"){
    include("../../config/config.php");

  if (trim($_POST['edit_name']) == '' ){
    ?><script type="text/javascript">alert('กรุณากรอกชื่อกระบวนการย่อย');</script><?php
    exit();
  }
  if (trim($_POST['edit_day']) == '' ){
    ?><script type="text/javascript">alert('กรุณากำหนดเวลา');</script><?php
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

  $sql_edit = " UPDATE  Process_Type SET
                process_type_name = '".trim($_POST['edit_name'])."',
                process_type_step = '$radio_step',
                process_type_duration =  '".trim($_POST['edit_day'])."',
                process_type_enable =  '$radio_enable',
                process_type_section = '$radio_section',
                process_type_update_datetime = '$date_setting',
                process_type_updateBy_id = '$emp_id'
                where  process_type_id = '".$_POST['id_edit']."'
                ";
   $query_edit = $conn->query($sql_edit);
     if ($query_edit){
       ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
     }else {
       ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
  <select class="selectpicker Complaint_Type"  data-width="auto" name="Complaint_Type"  id="Complaint_Type" onchange="sub_type_complaint();">
    <option value="">เลือกประเภทเรื่องร้องเรียน</option>
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
      <option value="">เลือกประเภทเรื่องร้องเรียน</option>
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

   $sql_caseCh = "SELECT compType_id,form_id,compType_name,compType_duration,compType_section  ";
   $sql_caseCh .= "FROM  Complaint_Type WHERE compType_status = '0' ";
   if($post->text != ""){
     $sql_caseCh .= "AND compType_name LIKE '%".$post->text."%' ";
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
     while ($re = $query_edit_pass->fetch_assoc()) {
       $caseCh_col_arr = array();
       $co_id++ ;

        $sql_ch = "SELECT compType_id  FROM  Complaint_Type_Sub1 where compType_id = '".$re['compType_id']."' AND compTypeSub1_status = '0' ";
        $query_ch = $conn->query($sql_ch);
        if($query_ch->num_rows>0){
          $from = '';
          $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';

        }else{
          if($re['form_id']==0){
            $from = '<button type="button" class="btn_from click_add" data-toggle="modal"  onclick="select_formset(1,'.$re['compType_id'].',0,0);" >
                    <span class="btn_form">เลือกฟอร์ม</span></button>';
            $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(1,'.$re['compType_id'].');"></span>
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
                $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';

              }else{
                $from = '<span  class="txt_edit" onclick="select_formset_edit(1,'.$re['compType_id'].',0,0,'.$re['form_id'].');" ><span class="txt_edit">'.$re_name.'</span>&nbsp;
                         <span class="icon-ico-ditp-10"  data-toggle="modal" ></span></span>';
                $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(1,'.$re['compType_id'].');"></span>
                        <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(1,'.$re['compType_id'].');"></span>';
              }
          }
        }

        $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['compType_name'].'</span>';
        // $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['compType_id'].'</span>';
        $caseCh_col_arr["day"] = '<span class="txt_nol">'.$re['compType_duration'].'</span>';
        $caseCh_col_arr["from"] = $from ;
        $caseCh_col_arr["del_edit"] = $del;
        // $caseCh_col_arr["del_edit"] = $del;
        $id_ty = $re['compType_id'];

        if($re['compType_section'] == '1'){
          $type='<span class="type_general">ทั่วไป</span>';
        }else{
          $type ='<span class="type_law">นิติการ</span>';
        }
          $caseCh_col_arr["type"] = $type;
        array_push($caseCh_arr,$caseCh_col_arr);


        $sql_caseCh_1 = "SELECT compTypeSub1_id,form_id,compTypeSub1_name FROM Complaint_Type_Sub1 WHERE compType_id = '$id_ty' AND compTypeSub1_status = '0'  ";
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
              $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';

            }else{
              if($re_1['form_id']==0){
                $from ='<button type="button" class="btn_from click_add" data-toggle="modal" onclick="select_formset(2,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].',0);" >
                        <span class="btn_form">เลือกฟอร์ม</span></button>';
                $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(2,'.$re_1['compTypeSub1_id'].');"></span>
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
                  $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
                }else{
                  $from = '<span  class="txt_edit" onclick="select_formset_edit(2,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].',0,'.$re_1['form_id'].');"><span class="txt_edit">'.$re_name.'</span>&nbsp;
                           <span class="icon-ico-ditp-10"  data-toggle="modal"></span></span>';
                 $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(2,'.$re_1['compTypeSub1_id'].');"></span>
                         <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(2,'.$re_1['compTypeSub1_id'].');"></span>';
                }
              }
            }


          $caseCh_col_arr["name"] = '<span class="txt_nol padd_com1"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$re_1['compTypeSub1_name'].'</span>';
          $caseCh_col_arr["from"] = $from ;
          $caseCh_col_arr["del_edit"] = $del;
          $caseCh_col_arr["day"] = '';
          array_push($caseCh_arr,$caseCh_col_arr);


          $sql_caseCh_2 = "SELECT compTypeSub2_id,form_id,compTypeSub2_name FROM Complaint_Type_Sub2 WHERE compTypeSub1_id = '$idx' AND compTypeSub2_status = '0'  ";
          $query_edit_pass_2 = $conn->query($sql_caseCh_2);
          $num2 = $query_edit_pass_2->num_rows;
          while ($re_2 = $query_edit_pass_2->fetch_assoc()) {
              if($re_2['form_id']==0){
                  $from ='<button type="button" class="btn_from click_add" data-toggle="modal" onclick="select_formset(3,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].','.$re_2['compTypeSub2_id'].');">
                          <span class="btn_form">เลือกฟอร์ม</span></button>';
                  $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(3,'.$re_2['compTypeSub2_id'].');"></span>
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
                        $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span>
                                <span class="icon-ico-ditp-28 txt_no_edit"></span>';
                      }else{
                        $from =   '<span class="txt_edit" onclick="select_formset_edit(3,'.$re['compType_id'].','.$re_1['compTypeSub1_id'].','.$re_2['compTypeSub2_id'].','.$re_2['form_id'].');" ><span class="txt_edit">'.$re_name.'</span>&nbsp;
                                  <span class="icon-ico-ditp-10"  data-toggle="modal" ></span></span>';
                        $del =    '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_complaint(3,'.$re_2['compTypeSub2_id'].');"></span>
                                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_complaint(3,'.$re_2['compTypeSub2_id'].');"></span>';
                      }
              }



            $caseCh_col_arr["name"] = '<span class="txt_nol padd_com2"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$re_2['compTypeSub2_name'].'</span>';
            $caseCh_col_arr["from"] = $from ;
            $caseCh_col_arr["del_edit"] = $del;
            $caseCh_col_arr["day"] = '';
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
      if ($query){
          echo '11';
      }else {
          echo "01";
      }

   }else if($_POST['type']==2){
     $sql = " UPDATE   Complaint_Type_Sub1 SET compTypeSub1_status = '1' where  compTypeSub1_id = '".$_POST['id_del']."'";
      $query = $conn->query($sql);
      if ($query){
          echo '11';
      }else {
          echo "01";
      }

   }else if($_POST['type']==3){
     $sql = " UPDATE Complaint_Type_Sub2 SET compTypeSub2_status = '1' where  compTypeSub2_id = '".$_POST['id_del']."'";
      $query = $conn->query($sql);
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
      $sql_select = "SELECT compType_name , compType_duration  FROM Complaint_Type where compType_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 1 ;
          $array_row['compType_name']=$result_select['compType_name'];
          $array_row['compType_duration']=$result_select['compType_duration'];
        }
      }
    }else if($_POST['type']==2){
      $sql_select = "SELECT compTypeSub1_name   FROM Complaint_Type_Sub1 where compTypeSub1_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 2 ;
          $array_row['compTypeSub1_name']=$result_select['compTypeSub1_name'];
        }
      }
    }else if ($_POST['type']==3) {
      $sql_select = "SELECT compTypeSub2_name   FROM Complaint_Type_Sub2 where compTypeSub2_id = '".$_POST['id_edit']."'";
      $query_select = $conn->query($sql_select);
      $array_row = array();
      if ($query_select->num_rows >0)
      {
        while($result_select = $query_select->fetch_assoc())
        {
          $array_row['type']= 3 ;
          $array_row['compTypeSub2_name']=$result_select['compTypeSub2_name'];
        }
      }
    }
        echo json_encode($array_row);
        exit();
 }

 if(isset($_GET["method"]) && $_GET["method"]=="edit_complaint"){
     include("../../config/config.php");
     if (trim($_POST['edit_name']) == '' ){
       ?><script type="text/javascript">alert('กรุณากรอกชื่อกระบวนการย่อย');</script><?php
       exit();
     }
    if($_POST['type']==1){
            if (trim($_POST['edit_day']) == '' ){
              ?><script type="text/javascript">alert('กรุณากำหนดเวลา');</script><?php
              exit();
            }
              $sql = "  UPDATE  Complaint_Type SET
                        compType_name = '".trim($_POST['edit_name'])."',
                        compType_duration = '".trim($_POST['edit_day'])."',
                        compType_update_datetime = '$date_setting',
                        compType_updateBy_id ='$emp_id'
                        where  compType_id = '".$_POST['id_edit']."'
                          ";
             $query = $conn->query($sql);
               if ($query){
                 ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
               }else {
                 ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
               }
    }else if($_POST['type']==2){

             $sql = " UPDATE  Complaint_Type_Sub1
                      SET compTypeSub1_name = '".trim($_POST['edit_name'])."',
                      compTypeSub1_update_datetime = '$date_setting',
                      compTypeSub1_updateBy_id ='$emp_id'
                      where  compTypeSub1_id = '".$_POST['id_edit']."'  ";
             $query = $conn->query($sql);
              if ($query){
                ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
              }else {
                ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
              }
    }else if($_POST['type']==3){
            $sql = "  UPDATE  Complaint_Type_Sub2
                      SET compTypeSub2_name = '".trim($_POST['edit_name'])."',
                      compTypeSub2_update_datetime = '$date_setting',
                      compTypeSub2_updateBy_id ='$emp_id'
                      where  compTypeSub2_id = '".$_POST['id_edit']."' ";
           $query = $conn->query($sql);
             if ($query){
               ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
             }else {
               ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
    $day_check =date("Y-m-d");
   if( $post->status_form == "1"){
      $sql_caseCh .= "AND form_start_date >= '$day_check' AND form_end_date >= '$day_check' ";
   }
   if( $post->status_form == "2"){
       $sql_caseCh .= "AND form_start_date < '$day_check'";
   }

   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $caseCh_col_arr["id"] = $co_id;
        $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['form_name'].'</span>';
        // $day_st =$re['form_start_date'];
        // $day_sp =$re['form_end_date'];

        $day_st = date("d/m/Y" , strtotime(data_filter($re['form_start_date'])));
        $day_sp = date("d/m/Y" , strtotime(data_filter($re['form_end_date'])));


        $caseCh_col_arr["day"] = '<span class="txt_nol">'.$day_st.' - '.$day_sp.'</span>';

        $sql_ch_form = "SELECT form_id  FROM Form_Link_Complaint_Type where form_id = '".$re['form_id']."'";
        $query_ch_form = $conn->query($sql_ch_form);
        if ($query_ch_form->num_rows >0) {
          $del = '<i class="fa fa-files-o cursor txt_no_edit_non" aria-hidden="true" onclick="copy_from('.$re['form_id'].');"></i>&nbsp;&nbsp;
                  <span class="icon-ico-ditp-10 txt_no_edit"></span>&nbsp;
                  <span class="icon-ico-ditp-28 txt_no_edit"></span>';

        }else {
          $del = ' <i class="fa fa-files-o cursor txt_no_edit_non" aria-hidden="true" onclick="copy_from('.$re['form_id'].');"></i>&nbsp;&nbsp;
                  <a href="?page=form_add&id='.$re['form_id'].'"><span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal"> </span></a>&nbsp;
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_form('.$re['form_id'].');"></span>';
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
      $sql_caseCh .= " AND name LIKE '%".$post->text."%' ";
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
   $sql_caseCh .= " ORDER BY $sort_col  $post->order ";
   $query_edit_pass_all = $conn->query($sql_caseCh);
   $num = $query_edit_pass_all->num_rows;
   $sql_caseCh .= " LIMIT $post->offset , $post->limit ";
      $query_edit_pass = $conn->query($sql_caseCh);
      $co_id = 0;
      while ($re = $query_edit_pass->fetch_assoc()) {
        $caseCh_col_arr = array();
        $co_id++ ;
        $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';

        if ($re['flag_32']!="" && $re['flag_128']!="" ) {
          $pic_link  = "../img/flags/".$re['flag_32']."";

        }else{
          $pic_link = $re['img_path'];
        }
        if(!file_exists('../../'.$pic_link) || $pic_link =='' ) {
          $pic = '<span class="txt_nol">ไม่พบรูป</span>';
        }else{
          $pic = '<i class="ico-flag-pri " style="background-image: url(../../'.$pic_link.');">';
        }

        $caseCh_col_arr["pic"] = $pic;
        $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['name'].'</span>';
        $caseCh_col_arr["name_th"] = '<span class="txt_nol">'.$re['name_th'].'</span>';

          if($re['country_enable'] == '1'){
            $view ='<span class="icon-ico-ditp-12 view_1">';
          }else{
            $view ='<span class="icon-ico-ditp-13  view_2">';
          }
        $caseCh_col_arr["view"] = $view;

        $sql_ch = "  SELECT complnt_country_id FROM `Case` WHERE `case_priority` =  '".$re['id']."'  ";
        $query_ch = $conn->query($sql_ch);
        if($query_ch->num_rows > 0){
          $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';

        }else{
          $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_country('.$re['id'].');"></span>
                  <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_country('.$re['id'].');"></span>';
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
     include("../../config/config.php");

     $caseCh_arr = array();
     $sql_caseCh = "SELECT casePrt_id ,casePrt_name,casePrt_section,casePrt_status,casePrt_img_name,casePrt_enable,casePrt_img_path ";
     $sql_caseCh .= " FROM Case_Priority WHERE casePrt_status = '0'   ";

     if($post->text != ""){
       $sql_caseCh .= "  AND casePrt_name LIKE '%".$post->text."%' ";
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
       $co_id = 0;
       while ($re = $query_edit_pass->fetch_assoc()) {
         $caseCh_col_arr = array();
         $co_id++ ;
         $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
         $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['casePrt_name'].'</span>';
           if($re['casePrt_enable'] == '1'){
             $view ='<span class="icon-ico-ditp-12 view_1">';
           }else{
             $view ='<span class="icon-ico-ditp-13  view_2">';
           }
           $sql_ch = "  SELECT case_priority FROM `Case` WHERE `case_priority` =  '".$re['casePrt_id']."'  ";
           $query_ch = $conn->query($sql_ch);
           if($query_ch->num_rows > 0){
             $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
             $caseCh_col_arr["pic"] =' <div class="box_edit_pri"><i class="ico-flag-pri pic_pri" style="background-image: url(../../'.$re['casePrt_img_path'].');"></i></div><div class="padd_lef">
                                       <button class="btn_up cursor_default" class="sum_edit" type="file" name="button" >
                                       <i class="fa fa-plus txt_no_edit" aria-hidden="true"></i></button></div>';
           }else{
             $caseCh_col_arr["pic"] =' <form method="POST" class="form_pri" action="method.php?method=add_priority_edit_pic" id="edit_pri"  enctype="multipart/form-data" target="iframe-data" >
                                       <div class="box_edit_pri"><i class="ico-flag-pri pic_pri" style="background-image: url(../../'.$re['casePrt_img_path'].');"></i></div><div class="padd_lef">
                                       <input type="file" id="browse_edit" name="pic_upload" style="display: none" onChange="loadFile_edit();" accept="image/x-png, image/gif, image/jpeg"/>
                                       <input type="hidden" name="id" value="'.$re['casePrt_id'].'" >
                                       <button class="btn_up" class="sum_edit" type="file" name="button" onclick="HandleBrowseClickxc('.$re['casePrt_id'].');">
                                       <i class="fa fa-plus" aria-hidden="true"></i></button></div></form>';
             $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_priority('.$re['casePrt_id'].');"></span>
             <span class="icon-ico-ditp-28 cursor txt_no_del"  onclick="ConfirmDelete()&&del_priority('.$re['casePrt_id'].');"></span>';
           }

          if($re['casePrt_section'] == '1'){
            $type='<span class="type_general">ทั่วไป</span>';
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
      ?><script type="text/javascript">alert('กรุณาใส่ชื่อระดับ Priority');</script><?php
      exit();
    }
    if ($_FILES['pic_upload']['name']==""){
      ?><script type="text/javascript">alert('กรุณาเลือกรูป');</script><?php
      exit();
    }
    if (trim($_POST['colorpicker']) == '' ){
      ?><script type="text/javascript">alert('กรุณาเลือกเฉดสี');</script><?php
      exit();
    }
        if ($_FILES['pic_upload']['name']){
          $images = $_FILES["pic_upload"]["tmp_name"];
          $image_type = $_FILES['pic_upload']['type'];
          if ($image_type=="image/jpeg"){
            ?><script type="text/javascript">alert("ICON (.PNG .gif) ONLY");</script><?php
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
            ?><script type="text/javascript">alert("Icon size (100x100)px Only");</script><?php
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
       ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
    ?><script type="text/javascript">alert('กรุณาใส่ชื่อฟอร์ม');</script><?php
    exit();
  }
  if ($_POST['date_start'] == '' ){
    ?><script type="text/javascript">alert('กรุณาใส่วันเริ่มต้นใช้งานฟอร์ม');</script><?php
    exit();
  }
  if ($_POST['date_stop'] == '' ){
    ?><script type="text/javascript">alert('กรุณาใส่วันสิ้นสุดฟอร์ม');</script><?php
    exit();
  }

  for($i=0;$i<3;$i++){
    if (trim($_POST['part_name'][$i]) == '' ){
      ?><script type="text/javascript">alert('กรุณาใส่ข้อมูลส่วนที่  <?php echo $i+'1';?>');</script><?php
      exit();
    }
  }
  if (trim($_POST['check_edit']) == '' ){
    if (trim($_POST['countFormset']) < 3  ){
      ?><script type="text/javascript">alert('กรุณาเลือกฟอร์ม');</script><?php
      exit();
    }
  }else{
    if (trim($_POST['countFormset']) != 0  ){
      ?><script type="text/javascript">alert('กรุณาเลือกฟอร์ม');</script><?php
      exit();
    }
  }


  $title_name = data_filter($_POST['title_name']);
  // $date_start = date("Y-m-d" , strtotime(data_filter($_POST['date_start'])));
  // $date_stop = date("Y-m-d" , strtotime(data_filter($_POST['date_stop'])));

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
      $id_form =      data_filter($_POST["id_form"][$i]);
      $type_from =    data_filter($_POST["type_from"][$i]);

      $sql_Comp = " INSERT INTO  Field_Form_Of_Comp  (form_id,field_name,frmset_id,frmset_type)
                              VALUES ('$last_id_form','$part_name','$id_form','$type_from')";
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
  $id_form =      data_filter($_POST["id_form"][$i]);
  $type_from =    data_filter($_POST["type_from"][$i]);



    $sql_comp = "UPDATE Field_Form_Of_Comp SET
                        field_name = '$part_name' , frmset_id   = '$id_form'
                        where  form_id = '".$_POST['id']."'
                        AND frmset_type  = '$type_from' ";
    $query_comp  = $conn->query($sql_comp);

}
  }

   if ($query_Comp ||  $query_comp){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.parent.location.href='index.php?page=form';</script><?php
   }else {
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
      ?><script type="text/javascript">alert('กรุณาเลือกฟอร์ม');</script><?php
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
    $sql_select = "SELECT field_id,frmset_id ,field_name  FROM Field_Form_Of_Comp where form_id = '$form_set'  ORDER BY field_id ASC ";
    $query_select = $conn->query($sql_select);
    if ($query_select->num_rows >0)
    {
      while($result_select = $query_select->fetch_assoc()){
        $sql_Complaint_Type = " INSERT INTO  Form_Link_Complaint_Type  (compType_id , compTypeSub1_id, compTypeSub2_id, frmset_id, frmset_name, form_id, field_id )
                                VALUES ('$id_add1','$id_add2','$id_add3','".$result_select['frmset_id']."','".$result_select['field_name']."', '$form_set' ,'".$result_select['field_id']."') ";
        $query_Complaint_Type = $conn->query($sql_Complaint_Type);
      }
    }
  }else if($_POST['add_edit']==2){

    $day_check = date("Y-m-d");
    // $sql_ch = "SELECT form_id,form_name,form_start_date,form_end_date FROM  Form_Of_Comp
    //               WHERE form_start_date >=  '$day_check' AND form_end_date >= '$day_check'
    //               AND `form_status` = 0
    //               AND form_id = '$form_set'
    //               ";
    // $query_ch = $conn->query($sql_ch);
    //   if ($query_ch->num_rows <1){
        ?><script type="text/javascript">//alert('แบบฟอร์มหมดอายุการใช้งานแล้วกรุณาเลือกแบบฟอร์มใหม่');</script><?php
      //  exit();
      // }

    $sql_select = "SELECT field_id,frmset_id ,field_name  FROM Field_Form_Of_Comp where form_id = '$form_set'  ORDER BY field_id ASC ";
    $query_select = $conn->query($sql_select);

      while($result_select = $query_select->fetch_assoc()){
      $field_id[] = $result_select['field_id'];
      $frmset_id[]= $result_select['frmset_id'];
      $field_name[] = $result_select['field_name'];

    }
    $sql_type = "SELECT frmCompType_id FROM Form_Link_Complaint_Type
                 where compType_id = '$id_add1' AND compTypeSub1_id = '$id_add2' AND compTypeSub2_id = '$id_add3'  ORDER BY frmCompType_id ASC ";
    $query_type = $conn->query($sql_type);
    // exit();
    if ($query_type->num_rows >0) {
    $co = 0;
        while($result_type = $query_type->fetch_assoc()){
                  $sql_edit_pass = "UPDATE   Form_Link_Complaint_Type
                                    SET
                                    frmset_id   = '".$frmset_id[$co]."'
                                    ,frmset_name  = '".$field_name[$co]."'
                                    ,form_id  =  '$form_set'
                                    ,field_id  = '".$field_id[$co]."'
                                    where frmCompType_id = '".$result_type['frmCompType_id']."' ";
                                    // exit();
                  $query_edit_pass = $conn->query($sql_edit_pass);
                  $co++;
        }
      } //else{
        // $sql_Complaint_Type = " INSERT INTO  Form_Link_Complaint_Type  (compType_id , compTypeSub1_id, compTypeSub2_id, frmset_id, frmset_name, form_id, field_id )
        //                         VALUES ('$id_add1','$id_add2','$id_add3','".$result_select['frmset_id']."','".$result_select['field_name']."', '$form_set' ,'".$result_select['field_id']."') ";
        // $query_Complaint_Type = $conn->query($sql_Complaint_Type);

    //  }
  }
     if ($query_edit_pass &&  $query_edit_pass){
       ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
     }else {
       ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
     }
     exit();
}



if(isset($_GET["method"]) && $_GET["method"]=="copy_from"){
    include("../../config/config.php");

  if (trim($_POST['new_name']) == '' ){
    ?><script type="text/javascript">alert('กรุณาใส่ชื่อฟอร์ม');</script><?php
    exit();
  }
  if (trim($_POST['date_start_copy']) == '' ){
    ?><script type="text/javascript">alert('กรุณาเลือกระยะเวลาใช้งานฟอร์ม');</script><?php
    exit();
  }
  if (trim($_POST['date_stop_copy']) == '' ){
    ?><script type="text/javascript">alert('กรุณาเลือกระยะเวลาใช้งานฟอร์ม');</script><?php
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
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
              ?><script type="text/javascript">alert("ICON (.PNG .gif) ONLY");</script><?php
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
              ?><script type="text/javascript">alert("Icon size (100x100)px Only");</script><?php
              exit();
            }
          }

          $last_id_priority =   data_filter($_POST["id"]);
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


        $sql_update = "UPDATE `Case_Priority` SET `casePrt_img_name` = '".$new_images."', casePrt_img_path = '$images_insert' WHERE `casePrt_id` = '".$_POST['id']."'";
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
         ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
       }else {
         ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
       ?><script type="text/javascript">alert('กรุณาใส่ชื่อระดับ Priority');</script><?php
       exit();
     }
     if (trim($_POST['colorpicker_edit']) == '' ){
       ?><script type="text/javascript">alert('กรุณาเลือกเฉดสี');</script><?php
       exit();
     }
         if ($_FILES['priority_edit']['name']){
           $images = $_FILES["priority_edit"]["tmp_name"];
           $image_type = $_FILES['priority_edit']['type'];
           if ($image_type=="image/jpeg"){
             ?><script type="text/javascript">alert("ICON (.PNG .gif) ONLY");</script><?php
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
             ?><script type="text/javascript">alert("Icon size (100x100)px Only");</script><?php
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



   $colorpicker = data_filter(trim($_POST['colorpicker_edit']));
   $edit_name = data_filter(trim($_POST['edit_name']));
    $sql_update = " UPDATE Case_Priority
                    SET casePrt_name = '$edit_name'
                        ,casePrt_status = '$status'
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
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
      }else {
        ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
      }
      exit();
 }




 if(isset($_GET["method"]) && $_GET["method"]=="add_country"){
       include("../../config/config.php");


       if (trim($_POST['add_name_th']) == '' ){
         ?><script type="text/javascript">alert('กรุณากรอกชื่อภาษาไทย');</script><?php
         exit();
       }
       if (trim($_POST['add_name_en']) == '' ){
         ?><script type="text/javascript">alert('กรุณากรอกชื่อภาษาอังกฤษ');</script><?php
         exit();
       }


if($_POST['id_edit']==''){
      if ($_FILES['add_pic_countyr']['name']==""){
        ?><script type="text/javascript">alert('กรุณาเลือกรูป');</script><?php
        exit();
      }
}

         if ($_FILES['add_pic_countyr']['name']){
           $images = $_FILES["add_pic_countyr"]["tmp_name"];
           $image_type = $_FILES['add_pic_countyr']['type'];
           if ($image_type=="image/jpeg"){
             ?><script type="text/javascript">alert("ICON (.PNG .gif) ONLY");</script><?php
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

    if($_POST['id_edit']==''){
      $sql = " INSERT INTO  Country  (name_th,name,country_enable) VALUES ('$add_name_th','$add_name_en','$status') ";
      $query = $conn->query($sql);
      $last_id_country = $conn->insert_id;
    }else {
        $sql = " UPDATE Country SET name_th = '$add_name_th', name = '$add_name_en' , country_enable = '$status' WHERE id = '".$_POST['id_edit']."' ";
        $query = $conn->query($sql);
        $last_id_country = $_POST['id_edit'];
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

      if($query || $sql_update){
        ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
      }else {
        ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
      }
      exit();
 }

function create_case_direatory($folder,$last_id_country){

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

       $sql_select = "SELECT id , name_th,name,country_enable  FROM Country where id = '".$_POST['id']."'";
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
     $sql_caseCh .= "AND process_type_name LIKE '%".$post->text."%' ";
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
     $co_id = 0;
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
        $del =  '<span class="icon-ico-ditp-10 txt_no_edit"  data-toggle="modal"></span><span class="icon-ico-ditp-28 txt_no_edit"></span>';
      }else{
        $del = '<span class="icon-ico-ditp-10 cursor txt_no_edit_non"  data-toggle="modal" onclick="edit_holiday('.$re['holiday_id'].');"></span>
              <span class="icon-ico-ditp-28 cursor txt_no_del" onclick="ConfirmDelete()&&del_holiday('.$re['holiday_id'].');"></span>';
      }
       $caseCh_col_arr["id"] = '<span class="txt_nol">'.$co_id.'</span>';
       $caseCh_col_arr["name"] = '<span class="txt_nol">'.$re['holiday_name'].'</span>';

       $date_start = date("d/m/Y" , strtotime(data_filter($re['holiday_date_start'])));
       $date_stop = date("d/m/Y" , strtotime(data_filter($re['holiday_date_end'])));


       $caseCh_col_arr["date"] = '<span class="txt_nol">'.$date_start.' - '.$date_stop.'</span>';
       $caseCh_col_arr["year"] = '<span class="txt_nol">'.$re['holiday_year'].'</span>';
       $caseCh_col_arr["day"] = '<span class="txt_nol">'.$re['holiday_date_amount'].'</span>';
       $caseCh_col_arr["del_edit"] = $del;
       array_push($caseCh_arr,$caseCh_col_arr);
     }
     $data_array = array('total'=>$num,'rows'=>$caseCh_arr);
     return json_encode($data_array);
}


if(isset($_GET["method"]) && $_GET["method"]=="add_holiday"){

    include("../../config/config.php");

  if (trim($_POST['year']) == '' ){
    ?><script type="text/javascript">alert('กรุณาเลือกปี');</script><?php
    exit();
  }
  if (trim($_POST['add_name']) == '' ){
    ?><script type="text/javascript">alert('กรุณากรอกชื่อ');</script><?php
    exit();
  }
  if (trim($_POST['date_start']) == '' ){
    ?><script type="text/javascript">alert('กรุณากำหนดเวลาเริ่มต้น');</script><?php
    exit();
  }
  if (trim($_POST['date_stop']) == '' ){
    ?><script type="text/javascript">alert('กรุณากำหนดเวลาสิ้นสุด');</script><?php
    exit();
  }
  if (trim($_POST['date_start']) > trim($_POST['date_stop']) ){
    ?><script type="text/javascript">alert('วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด');</script><?php
    exit();
  }




  $date_start = trim($_POST['date_start']);
  $date_stop = trim($_POST['date_stop']);
  $date_start_ch = DateTime::createFromFormat('d/m/Y', data_filter($date_start))->format('Y');
  $date_stop_ch = DateTime::createFromFormat('d/m/Y', data_filter($date_stop))->format('Y');

if($_POST['year'] != $date_start_ch || $_POST['year'] != $date_stop_ch){
  ?><script type="text/javascript">alert('กรุณาเลือก ปี ค.ศ. วันเริ่มต้นและสิ้นสุด ให้ตรงกับปี ค.ศ ที่เลือกไว้ครับ');</script><?php
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
       ?><script type="text/javascript">alert('วันที่คุณเลือกมีข้อมูลในระบบแล้ว');</script><?php
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
        $sql_edit_pass = "  INSERT INTO  PublicHoliday (holiday_year,holiday_name,holiday_date_start,holiday_date_end,holiday_date_amount,holiday_create_datetime,holiday_createBy_id)
                            VALUES ('$year', '$add_name','$date_start_in','$date_stop_in','$holiday_date_amount','$date_setting','$emp_id') ";
        $query_edit_pass = $conn->query($sql_edit_pass);

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
   if ($query_edit_pass){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else {
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
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
          <input type="radio" name="form_set" id="form_set_<?=$form_id?>" value="<?=$form_id?>" <?php if($id_ch_day != ''){ echo "disabled";}?> onchange="set_val();"></th>
          <th><label class="txt_nol_form"><?=$form_name?></label></th>
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
        ?><script type="text/javascript">alert("Icon size (100x100)px Only");</script><?php
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
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();
}


if ($_GET['method']=="edit_noti"){
   include("../../config/config.php");


   if($_POST['ty_check']=='1'){
     if (trim($_POST['progress_25']) == ''){
       ?><script type="text/javascript">alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 25%');</script><?php
       exit();
     }
     if (trim($_POST['progress_50']) == ''){
       ?><script type="text/javascript">alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 50%');</script><?php
       exit();
     }
     if (trim($_POST['progress_75']) == ''){
       ?><script type="text/javascript">alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 75%');</script><?php
       exit();
     }
     if (trim($_POST['progress_100']) == ''){
       ?><script type="text/javascript">alert('กรุณากรอกข้อมูล ความคืบหน้า (Progress) 100%');</script><?php
       exit();
     }
              $progress_status = data_filter(trim($_POST['progress_status']));
              $progress_25 = data_filter(trim($_POST['progress_25']));
              $progress_50 = data_filter(trim($_POST['progress_50']));
              $progress_75 = data_filter(trim($_POST['progress_75']));
              $progress_100 = data_filter(trim($_POST['progress_100']));
              $sql_edit_info = "UPDATE  Setting_Info SET
                                 noti_status = '$progress_status'
                                 ,noti_process25   = '$progress_25'
                                 ,noti_process50  = '$progress_50'
                                 ,noti_process75 = '$progress_75'
                                 ,noti_process100 = '$progress_100'
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
          ?><script type="text/javascript">alert('แก้ไขข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
        }else{
          ?><script type="text/javascript">alert('แก้ไขข้อมูลผิดพลาด');</script><?php
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

if(isset($_POST["method"]) && $_POST["method"]=="get_data_company"){
include("../../config/config.php");

    $sql_edit = "SELECT complnt_trade_number,case_id,count(case_id) as count_sum FROM `Case` WHERE complnt_trade_number !='' GROUP by complnt_trade_number ASC  ";
    $query_edit = $conn->query($sql_edit);
    $color = 0;
    if ($query_edit->num_rows>0){
      $ch = 0;
    while ( $re_edit =   $query_edit->fetch_assoc()) {
      $count_sum =  $re_edit['count_sum'];
      if(($count_sum == $_POST['search_text'] || $_POST['search_text'] == '') && $ch == 0){
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
          <td onclick="click_sub(<?php echo $re_edit['case_id']?>);" class="cursor"  style="width: 100%;"  data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
            <div class="card">
              <div class="card-header" role="tab" id="heading">
                <h5 class="mb-0">
                  <span class="collapsed bl_txt span_bl" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $re_edit['case_id']?>" aria-expanded="false" aria-controls="collapseThree">
                    <?php echo $complnt_trade_number;?>
                  </span>
                  <div class="arrow_bl">
                    <i class="fa fa-chevron-up up_rolate<?php echo $re_edit['case_id']?> cursor i_txt" aria-hidden="true"  onclick="click_sub(<?php echo $re_edit['case_id']?>);"></i>
                  </div>
                </h5>
              </div>
              <div id="collapseThree<?php echo $re_edit['case_id']?>" class="collapse p_box" role="tabpanel" aria-labelledby="heading">
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
      }else{
        ?>
        <tr>
          <th class="thead_table center_table" style="width:  1%;" colspan="2">
            ไม่พบข้อมูล
          </th>
        </tr>
        <?php
      }
    exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="copy_duplicate"){
    include("../../config/config.php");

    $year = data_filter($_POST['year']);

    $sql_select = "SELECT  *  FROM PublicHoliday where holiday_year = '".$_POST['year']."' AND holiday_status = 0 ";
    $query_select = $conn->query($sql_select);
    $array_row = array();
    if ($query_select->num_rows >0)
    {
      ?><script type="text/javascript">alert('ไม่สามารถเพิ่มข้อมูลได้เนื่องจากข้อมูลปีที่จะสร้างมีในระบบแล้ว');</script><?php
      exit();

    }

    echo $sql_select = "SELECT  *  FROM PublicHoliday where holiday_year = '".$_POST['copy_duplicate']."' AND holiday_status = 0 ";
    $query_select = $conn->query($sql_select);
    $array_row = array();
    if ($query_select->num_rows >0)
    {
      while($result_select = $query_select->fetch_assoc())
      {
        $holiday_date_start = $result_select['holiday_date_start'];
        $holiday_date_end = $result_select['holiday_date_end'];

        $date_start_in = substr($holiday_date_start, 4, 10);
        $date_start_in = $year.$date_start_in;
        $date_stop_in = substr($holiday_date_end, 4, 10);
        $date_stop_in = $year.$date_stop_in;


        $sql_edit_pass = "  INSERT INTO  PublicHoliday (holiday_year,holiday_name,holiday_date_start,holiday_date_end,holiday_date_amount,holiday_create_datetime,holiday_createBy_id)
                            VALUES ('".$_POST['year']."', '".$result_select['holiday_name']."' , '$date_start_in','$date_stop_in','".$result_select['holiday_date_amount']."','$date_setting','$emp_id') ";
        $query_edit_pass = $conn->query($sql_edit_pass);
      }
    }
   if ($query_edit_pass){
     ?><script type="text/javascript">alert('บันทึกข้อมูลเรียบร้อย');window.top.location.reload();</script><?php
   }else{
     ?><script type="text/javascript">alert('บันทึกข้อมูลผิดพลาด');</script><?php
   }
   exit();
}

if(isset($_GET["method"]) && $_GET["method"]=="import_product"){
//   if (!is_dir("../../data/setting")){
//         mkdir("../../data/setting", 0775, true);
//   }
//   if (!is_dir("../../data/setting/template")){
//       mkdir("../../data/setting/template", 0775, true);
//   }
//   $AA = 'Template_product.xlsx';
//   move_uploaded_file($_FILES["userimport"]["tmp_name"], "../../data/setting/template/". $AA);
//
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
       ?><script type="text/javascript">alert('Plese Insert Excel File (.xlsx)');</script><?php
      exit();
    }
}


 ?>
