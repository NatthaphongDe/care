<?php
if($_GET['page'] == "invite_form"){
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_15.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  // $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
</div>

<div class="panel-body">';


  $formSet_html .= '<div class="row div_name_office_invite">';
  if($lang == "1"){ $acn_form4 = "ชื่อบริษัทที่ต้องการร้องเรียน";}elseif($lang == "2"){ $acn_form4 = "Respondent’s Company Name";}else{ $acn_form4 = "ชื่อบริษัทที่ต้องการร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$acn_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_name" name="complnt_name_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_branch_invite">';
  if($lang == "1"){ $branch_form4 = "สาขา";}elseif($lang == "2"){ $branch_form4 = "Branch";}else{ $branch_form4 = "สาขา";}
    $formSet_html .='<div class="col-md-3">'.$branch_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_branch" name="complnt_branch_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_trade_invite">';
  if($lang == "1"){ $tn_form4 = "เลขนิติบุคคล (ถ้าทราบ)";}elseif($lang == "2"){ $tn_form4 = "Company Registration Number (if applicable)";}else{ $tn_form4 = "เลขนิติบุคคล (ถ้าทราบ)";}
    $formSet_html .='<div class="col-md-3">'.$tn_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_trade_number" maxlength="13" name="complnt_trade_number_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_contacts_invite">';
  if($lang == "1"){ $contact_form4 = "ชื่อผู้ติดต่อ";}elseif($lang == "2"){ $contact_form4 = "Contact Person";}else{ $contact_form4 = "ชื่อผู้ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$contact_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_contact_name" name="complnt_contact_name_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_tel_invite">';
  if($lang == "1"){ $tel_form4 = "หมายเลขโทรศัพท์ที่ติดต่อ";}elseif($lang == "2"){ $tel_form4 = "Telephone Number";}else{ $tel_form4 = "หมายเลขโทรศัพท์ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$tel_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-sm-4 flex-container">
    <div class="flex2" id="tel2">';
      if($_POST["rdi_compTypeSub1"] == 1){$ctrycode = 'maxlength="10"';}
      $formSet_html .= '
      <input type="text" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number-complnt txt_input_tel_invite" name="complnt_contact_tel_IdxFs_'.$formSetId.'" '.$ctrycode.' onkeypress="onlynum_validate(event)" />
      <input type="hidden" name="complnt_mobile_country" value="" >
      <input type="hidden" name="complnt_mobile_code" value="">
    </div></div>';
    if($lang == "1"){ $email_form4 = "E-mail ที่ติดต่อ";}elseif($lang == "2"){ $email_form4 = "E-mail";}else{ $email_form4 = "E-mail ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$email_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-3"><input type="email" class="form-control txt_input_email_invite" name="complnt_contact_email_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $bs_form3 = "ประเภทธุรกิจ";}elseif($lang == "2"){ $bs_form3 = "Type of Business";}else{ $bs_form3 = "ประเภทธุรกิจ";}
    $formSet_html .='<div class="col-md-3">'.$bs_form3.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
    <select name="complnt_import_export_IdxFs_'.$formSetId.'" id="sel_import_export" class="selectpicker form-control sel_import_export">
          <option value="">';
          if($lang == "1"){ $chbc_form3 = "เลือกประเภทธุรกิจ";}elseif($lang == "2"){ $chbc_form3 = "Choose your Type of Business";}else{ $chbc_form3 = "เลือกประเภทธุรกิจ";}
          if($lang == "1"){
            $business1 = "อื่นๆ";
            $business2 = "นำเข้า";
            $business3 = "ส่งออก";
          }elseif ($lang == "2") {
            $business1 = "Other";
            $business2 = "Import";
            $business3 = "Export";
          }else {
            $business1 = "อื่นๆ";
            $business2 = "นำเข้า";
            $business3 = "ส่งออก";
          }
            $formSet_html .='
           --- '.$chbc_form3.' ---
          </option>
          <option value="0">'.$business1.'</option>
          <option value="1">'.$business2.'</option>
          <option value="2">'.$business3.'</option>
        </select></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $add_form4 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $add_form4 = "Address";}else{ $add_form4 = "ที่อยู่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$add_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="4" class="form-control complnt_contact_address"></textarea></div>
  </div>
  <div class="row div_country_invite">';
    if($lang == "1"){ $country_form4 = "ประเทศ";}elseif($lang == "2"){ $country_form4 = "Country";}else{ $country_form4 = "ประเทศ";}
    $formSet_html .='<div class="col-md-3">'.$country_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4">
      <select name="complnt_country_id_IdxFs_'.$formSetId.'" id="sel_country_invite" class="selectpicker form-control sel_country_invite" data-live-search="true" ;">
      <option value="">';
      if($lang == "1"){ $chcountry_form3 = "เลือกประเทศ";}elseif($lang == "2"){ $chcountry_form3 = "Choose your country";}else{ $chcountry_form3 = "เลือกประเทศ";}
        $formSet_html .='
       --- '.$chcountry_form3.' ---
      </option>
      ';
      if($_POST["rdi_compTypeSub1"] == 1){$ctryList = $countryList; $zcode = 'maxlength="5" onkeypress="onlynum_validate(event)"';} else {$ctryList = $countryList3; }
      $formSet_html .=''.$ctryList.'</select>
    </div>';
    if($lang == "1"){ $zipcode_form4 = "รหัสไปรษณีย์";}elseif($lang == "2"){ $zipcode_form4 = "Post Code";}else{ $zipcode_form4 = "รหัสไปรษณีย์";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$zipcode_form4.'</div>
    <div class="col-md-3"><input type="text" '.$zcode .' name="complnt_zipcode_IdxFs_'.$formSetId.'"  class="form-control "></div>
  </div>
  <input type="hidden" class="formSetId_b"  name="formSetId_b" value="'.$formSetId.'" >';

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
  if($lang == "1"){ $acn_form4 = "ชื่อบริษัทที่ต้องการร้องเรียน";}elseif($lang == "2"){ $acn_form4 = "Respondent’s Company Name";}else{ $acn_form4 = "ชื่อบริษัทที่ต้องการร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$acn_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control complnt_name" name="complnt_name_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_name'].'"></div>
  </div>
  <div class="row div_branch_invite">';
  if($lang == "1"){ $branch_form4 = "สาขา";}elseif($lang == "2"){ $branch_form4 = "Branch";}else{ $branch_form4 = "สาขา";}
    $formSet_html .='<div class="col-md-3">'.$branch_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_branch" name="complnt_branch_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_branch'].'"></div>
  </div>
  <div class="row div_trade_invite">';
  if($lang == "1"){ $tn_form4 = "เลขนิติบุคคล (ถ้าทราบ)";}elseif($lang == "2"){ $tn_form4 = "Company Registration Number (if applicable)";}else{ $tn_form4 = "เลขนิติบุคคล (ถ้าทราบ)";}
    $formSet_html .='<div class="col-md-3">'.$tn_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_trade_number" maxlength="13" name="complnt_trade_number_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_trade_number'].'"></div>
  </div>
  <div class="row div_contacts_invite">';
  if($lang == "1"){ $contact_form4 = "ชื่อผู้ติดต่อ";}elseif($lang == "2"){ $contact_form4 = "Contact Person";}else{ $contact_form4 = "ชื่อผู้ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$contact_form4.'</div>
    <div class="col-md-9"><input type="text" class="form-control complnt_contact_name" name="complnt_contact_name_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_contact_name'].'"></div>
  </div>
  <div class="row div_tel_invite">';
  if($lang == "1"){ $tel_form4 = "หมายเลขโทรศัพท์ที่ติดต่อ";}elseif($lang == "2"){ $tel_form4 = "Telephone Number";}else{ $tel_form4 = "หมายเลขโทรศัพท์ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$tel_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-sm-4 flex-container">
    <div class="flex2" id="tel2">
    <input type="text" value="'.$_POST['complnt_contact_tel'].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number-complnt txt_input_tel_invite" name="complnt_contact_tel_IdxFs_'.$formSetId.'"  maxlength="10" onkeypress="onlynum_validate(event)"  />
    <input type="hidden" name="complnt_mobile_country" value="'.$_POST['complnt_mobile_country'].'">
    <input type="hidden" name="complnt_mobile_code" value="'.$_POST['complnt_mobile_code'].'">
  </div></div>';
    if($lang == "1"){ $email_form4 = "E-mail ที่ติดต่อ";}elseif($lang == "2"){ $email_form4 = "E-mail";}else{ $email_form4 = "E-mail ที่ติดต่อ";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$email_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-3"><input type="email" class="form-control txt_input_email_invite" name="complnt_contact_email_IdxFs_'.$formSetId.'" value="'.$_POST['complnt_contact_email'].'"></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $bs_form3 = "ประเภทธุรกิจ";}elseif($lang == "2"){ $bs_form3 = "Type of Business";}else{ $bs_form3 = "ประเภทธุรกิจ";}
    $formSet_html .='<div class="col-md-3">'.$bs_form3.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
    <select name="complnt_import_export_IdxFs_'.$formSetId.'" id="sel_import_export" class="selectpicker form-control sel_import_export">
          <option value="">';
          if($lang == "1"){ $chbc_form3 = "เลือกประเภทธุรกิจ";}elseif($lang == "2"){ $chbc_form3 = "Choose your Type of Business";}else{ $chbc_form3 = "เลือกประเภทธุรกิจ";}
          if($lang == "1"){
            $business1 = "อื่นๆ";
            $business2 = "นำเข้า";
            $business3 = "ส่งออก";
          }elseif ($lang == "2") {
            $business1 = "Other";
            $business2 = "Import";
            $business3 = "Export";
          }else {
            $business1 = "อื่นๆ";
            $business2 = "นำเข้า";
            $business3 = "ส่งออก";
          }
            $formSet_html .='
           --- '.$chbc_form3.' ---
          </option>
          <option value="0"  '.($_POST["complnt_import_export"]=="0"?'selected':'').'>'.$business1.'</option>
          <option value="1"  '.($_POST["complnt_import_export"]=="1"?'selected':'').'>'.$business2.'</option>
          <option value="2"  '.($_POST["complnt_import_export"]=="2"?'selected':'').'>'.$business3.'</option>
        </select></div>
  </div>
  <div class="row div_address_invite">';
  if($lang == "1"){ $add_form4 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $add_form4 = "Address";}else{ $add_form4 = "ที่อยู่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$add_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="4" class="form-control complnt_contact_address">'.$_POST['complnt_contact_address'].'</textarea></div>
  </div>
  <div class="row div_country_invite">';
    if($lang == "1"){ $country_form4 = "ประเทศ";}elseif($lang == "2"){ $country_form4 = "Country";}else{ $country_form4 = "ประเทศ";}
    $formSet_html .='<div class="col-md-3">'.$country_form4.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4">
      <select name="complnt_country_id_IdxFs_'.$formSetId.'" id="sel_country_invite" class="selectpicker form-control sel_country_invite" data-live-search="true" onchange="chk_country_ex();">
      <option value="">';
      if($lang == "1"){ $chcountry_form3 = "เลือกประเทศ";}elseif($lang == "2"){ $chcountry_form3 = "Choose your country";}else{ $chcountry_form3 = "เลือกประเทศ";}
        $formSet_html .='
       --- '.$chcountry_form3.' ---
      </option>';
        $sql = "select * from Country ORDER BY name";
        $query = $this->dbConn->query($sql);
        if($query->num_rows > 0){
          while ($rs = $query->fetch_assoc()) {
            if($lang == "1"){
              $name = $rs['name'];
            }elseif ($lang == "2") {
              $name = $rs['name'];
            }else {
              $name = $rs['name'];
            }
    $formSet_html .= '<option value="'.$rs['id'].'" '.($_POST["complnt_country_id"]==$rs['id']?'selected':'').'>'.$name.'</option>';
            }
        }
    $formSet_html .= '</select></div>';
    if($lang == "1"){ $zipcode_form4 = "รหัสไปรษณีย์";}elseif($lang == "2"){ $zipcode_form4 = "Post Code";}else{ $zipcode_form4 = "รหัสไปรษณีย์";}
    $formSet_html .='<div class="col-md-2 txt_email_invite">'.$zipcode_form4.'</div>
    <div class="col-md-3"><input type="text" maxlength="5" pattern="([0-9]|[0-9]|[0-9])" name="complnt_zipcode_IdxFs_'.$formSetId.'" maxlength="5" class="form-control complnt_zipcode_ex" value="'.$_POST['complnt_zipcode'].'"></div>
  </div>

  <input type="hidden" name="formSetId_b" value="'.$formSetId.'" >';

$formSet_html .='</div>';
}
?>
