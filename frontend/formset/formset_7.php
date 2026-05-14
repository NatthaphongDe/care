<?php
if($_GET['page'] == "invite_form"){
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_15.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
</div>

<div class="panel-body">';


  $formSet_html .= '<div class="row div_name_office_invite">';
  if($lang == "1"){ $name_form7 = "ชื่อ-นามสกุล";}elseif($lang == "2"){ $name_form7 = "Full name";}else{ $name_form7 = "ชื่อ-นามสกุล";}
  $formSet_html .='<div class="col-md-3">'.$name_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_name" name="complnt_name_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_branch_invite">';
  if($lang == "1"){ $department_form7 = "หน่วยงาน";}elseif($lang == "2"){ $department_form7 = "Organization";}else{ $department_form7 = "หน่วยงาน";}
    $formSet_html .='<div class="col-md-3">'.$department_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_branch" name="complnt_branch_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_trade_invite">';
  if($lang == "1"){ $position_form7 = "ตำแหน่ง";}elseif($lang == "2"){ $position_form7 = "Position";}else{ $position_form7 = "ตำแหน่ง";}
    $formSet_html .='<div class="col-md-3">'.$position_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_position" name="complnt_position_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_contacts_invite">';
  if($lang == "1"){ $birthday_form7 = "วัน/เดือน/ปี เกิด";}elseif($lang == "2"){ $birthday_form7 = "Date of Birth (D/M/Y)";}else{ $birthday_form7 = "วัน/เดือน/ปี เกิด";}
    $formSet_html .='<div class="col-md-3">'.$birthday_form7.'</div>
    <div class="col-md-4">
    <div class="form-group">
      <div class="input-group date" id="datetimepicker">
        <input type="text" class="form-control complnt_birthday" id="complnt_birthday" name="complnt_birthday_IdxFs_'.$formSetId.'" />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
  </div>';
  if($lang == "1"){ $age_form7 = "อายุ";}elseif($lang == "2"){ $age_form7 = "Age";}else{ $age_form7 = "อายุ";}
  $formSet_html .='<div class="col-md-2 txt_email_invite">'.$age_form7.'</div>
  <div class="col-md-3"><input type="text" class="form-control complnt_age" name="complnt_age_IdxFs_'.$formSetId.'" /></div>
  </div>
  <div class="row div_tel_invite">';
  if($lang == "1"){ $tel_form7 = "หมายเลขโทรศัพท์ที่ติดต่อ";}elseif($lang == "2"){ $tel_form7 = "Telephone Number";}else{ $tel_form7 = "หมายเลขโทรศัพท์ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$tel_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4"><input type="text" class="form-control txt_input_tel_invite" name="complnt_contact_tel_IdxFs_'.$formSetId.'"></div>';
    if($lang == "1"){ $email_form7 = "E-mail ที่ติดต่อ";}elseif($lang == "2"){ $email_form7 = "E-mail";}else{ $email_form7 = "E-mail ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$email_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-3"><input type="email" class="form-control txt_input_email_invite" name="complnt_contact_email_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $add_form7 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $add_form7 = "Address";}else{ $add_form7 = "ที่อยู่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$add_form7.'</div>
    <div class="col-md-9"><textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="4" class="form-control complnt_contact_address"></textarea></div>
  </div>
  <input type="hidden" class="formSetId_b" name="formSetId_b" value="'.$formSetId.'" >';

$formSet_html .='</div>';
}elseif ($_GET['page'] == "invite_edit") {
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_15.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
</div>

<div class="panel-body">';

  $formSet_html .= '<div class="row div_name_office_invite">';
  if($lang == "1"){ $name_form7 = "ชื่อ-นามสกุล";}elseif($lang == "2"){ $name_form7 = "Full name";}else{ $name_form7 = "ชื่อ-นามสกุล";}
  $formSet_html .='<div class="col-md-3">'.$name_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_name" name="complnt_name_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_name'].'"></div>
  </div>
  <div class="row div_branch_invite">';
  if($lang == "1"){ $department_form7 = "หน่วยงาน";}elseif($lang == "2"){ $department_form7 = "Organization";}else{ $department_form7 = "หน่วยงาน";}
    $formSet_html .='<div class="col-md-3">'.$department_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_branch" name="complnt_branch_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_branch'].'"></div>
  </div>
  <div class="row div_trade_invite">';
  if($lang == "1"){ $position_form7 = "ตำแหน่ง";}elseif($lang == "2"){ $position_form7 = "Position";}else{ $position_form7 = "ตำแหน่ง";}
    $formSet_html .='<div class="col-md-3">'.$position_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_position" name="complnt_position_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_position'].'"></div>
  </div>
  <div class="row div_contacts_invite">';
  if($lang == "1"){ $birthday_form7 = "วัน/เดือน/ปี เกิด";}elseif($lang == "2"){ $birthday_form7 = "Date of Birth (D/M/Y)";}else{ $birthday_form7 = "วัน/เดือน/ปี เกิด";}
    $formSet_html .='<div class="col-md-3">'.$birthday_form7.'</div>
    <div class="col-md-4">
    <div class="form-group">
      <div class="input-group date" id="datetimepicker">
        <input type="text" class="form-control complnt_birthday" id="complnt_birthday" name="complnt_birthday_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_birthday'].'"/>
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar"></span>
        </span>
      </div>
    </div>
  </div>';
  if($lang == "1"){ $age_form7 = "อายุ";}elseif($lang == "2"){ $age_form7 = "Age";}else{ $age_form7 = "อายุ";}
  $formSet_html .='<div class="col-md-2 txt_email_invite">'.$age_form7.'</div>
  <div class="col-md-3"><input type="text" class="form-control complnt_age" name="complnt_age_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_age'].'"/></div>
  </div>
  <div class="row div_tel_invite">';
  if($lang == "1"){ $tel_form7 = "หมายเลขโทรศัพท์ที่ติดต่อ";}elseif($lang == "2"){ $tel_form7 = "Telephone Number";}else{ $tel_form7 = "หมายเลขโทรศัพท์ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$tel_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4"><input type="text" class="form-control txt_input_tel_invite" name="complnt_contact_tel_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_contact_tel'].'"></div>';
    if($lang == "1"){ $email_form7 = "E-mail ที่ติดต่อ";}elseif($lang == "2"){ $email_form7 = "E-mail";}else{ $email_form7 = "E-mail ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$email_form7.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-3"><input type="email" class="form-control txt_input_email_invite" name="complnt_contact_email_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_contact_email'].'"></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $add_form7 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $add_form7 = "Address";}else{ $add_form7 = "ที่อยู่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$add_form7.'</div>
    <div class="col-md-9"><textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="4" class="form-control complnt_contact_address">'.$_POST['complnt_contact_address'].'</textarea></div>
  </div>
  <input type="hidden" class="formSetId_b" name="formSetId_b" value="'.$formSetId.'" >';

$formSet_html .='</div>';
}
?>
