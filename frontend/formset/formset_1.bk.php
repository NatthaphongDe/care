<?php
if($_GET['page'] == "invite_form"){
  $rdi_compTypeSub1 = (($_POST["rdi_compTypeSub1"] == "") ?0:$_POST["rdi_compTypeSub1"]);
  // if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  $hr_form1_txt = $res['frmset_name'.(($lang == "2")?'_en':'')];
  // if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html = '<div class="panel-heading hr_invite_panel">
                    <span><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>
                    <span class="hr_input_detail">'.$hr_form1_txt.'</span>
                      <a data-toggle="collapse" href="#collapse_1" class="collapse_1"><span class="icon_hide_detail_invite"></span></a>
                  </div>
                  <div id="collapse_1" class="panel-collapse collapse in">
                    <div class="panel-body">';

  $sql_from = "SELECT * FROM Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."'";
  $query_from = $this->dbConn->query($sql_from);
  $rel = $query_from->fetch_assoc();


  $sql_member ="SELECT 
                  m.member_fname,
                  m.member_lname,
                  m.member_cid,
                  m.member_occupation,
                  m.member_position,
                  m.member_address,
                  m.prov_id,
                  m.member_postcode,
                  m.country_id,
                  m.member_phone,
                  m.member_sex,
                  m.member_type,
                  m.member_email,
                  m.member_cellphone,
                  m.member_business,
                  mc.member_comp_name,
                  mc.member_comp_branch,
                  mc.member_comp_taxid,
                  mc.member_comp_address,
                  mc.prov_id AS prov_id_com,
                  mc.member_comp_postcode,
                  mc.country_id AS country_id_com,
                  mc.member_comp_phone,
                  mc.member_comp_fax,
                  mc.member_comp_type
                FROM Member AS m
                LEFT JOIN Member_comp AS mc ON m.member_id = mc.member_id 
                WHERE m.member_id = '".$_SESSION['member_id']."'";
  $query_member = $this->dbConn->query($sql_member);
  $re = $query_member->fetch_assoc();

  $hr_form1 = (($lang == "2")?"Petitioner":"ผู้ร้องเรียน");
  // if($lang == "1"){ $hr_form1 = "ผู้ร้องเรียน";}elseif($lang == "2"){ $hr_form1 = "Petitioner";}else{ $hr_form1 = "ผู้ร้องเรียน";}
  $formSet_html .=  '<div class="row">
                      <div class="col-md-12">
                        <div class="hr_invite">
                          <span class="icon_invite_person"><img src="images/all_icon_DITP/icon_14.svg" style="width:30px;"></span>
                          <span class="hr_invite_title">'.$hr_form1.'</span>
                        </div>
                        <!-- /.hr_invite -->
                        <div class="hr_invite_name_div">
                          <span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>
                          <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
                          <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
                        </div>';

    $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />';
if($re['country_id'] == 162){
        $formSet_html .='<input type="hidden" value="'.$re['country_id'].'" name="applnt_country_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';

}
      $formSet_html .='<input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_email'].'" name="applnt_email_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_business'].'" name="applntOrg_import_export_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
      <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="">';

if($re['country_id'] != 162 && $rel['compType_other_flag'] == 0){
  $formSet_html .='
  <div class="panel panel-default" style="margin-top: 20px;">
  <div class="panel-body">
    <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="1">
    <input type="hidden" value="1" name="applnt_type_IdxFs_'.$formSetId.'"  />
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_cn1 = "ชื่อบริษัท";}elseif($lang == "2"){ $hr_cn1 = "Company Name";}else{ $hr_cn1 = "ชื่อบริษัท";}
    $formSet_html .='<div class="col-md-3">'.$hr_cn1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-9"><input type="text" class="form-control applntOrg_name" name="applntOrg_name_IdxFs_'.$formSetId.'" /></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_branch1 = "สาขา";}elseif($lang == "2"){ $hr_branch1 = "Branch";}else{ $hr_branch1 = "สาขา";}
    $formSet_html .='<div class="col-md-3">'.$hr_branch1.'</div>
      <div class="col-md-9"><input type="text" class="form-control applntOrg_branch" name="applntOrg_branch_IdxFs_'.$formSetId.'"  /></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_po1 = "ตำแหน่ง";}elseif($lang == "2"){ $hr_po1 = "Position";}else{ $hr_po1 = "ตำแหน่ง";}
    $formSet_html .='<div class="col-md-3">'.$hr_po1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-9"><input type="text" class="form-control applntOrg_position" name="applntOrg_position_IdxFs_'.$formSetId.'"  /></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_tn1 = "เลขนิติบุคคล";}elseif($lang == "2"){ $hr_tn1 = "Business Registration Number";}else{ $hr_tn1 = "เลขนิติบุคคล";}
    $formSet_html .='<div class="col-md-3">'.$hr_tn1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-9"><input type="text" class="form-control applntOrg_trade_number" maxlength="13" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" /></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_Contact1 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $hr_Contact1 = "Address";}else{ $hr_Contact1 = "ที่อยู่ติดต่อ";}
    $formSet_html .='<div class="col-md-3">'.$hr_Contact1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-9"><textarea rows="4" class="form-control applntOrg_address" name="applntOrg_address_IdxFs_'.$formSetId.'" /></textarea></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_tel1 = "เบอร์โทรศัพท์";}elseif($lang == "2"){ $hr_tel1 = "Telephone Number";}else{ $hr_tel1 = "เบอร์โทรศัพท์";}
    $formSet_html .='<div class="col-md-3">'.$hr_tel1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-3"><input type="text" class="form-control applntOrg_tel cc" name="applntOrg_tel_IdxFs_'.$formSetId.'"  data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;"/></div>';
        if($lang == "1"){ $hr_ftel1 = "เบอร์แฟกซ์";}elseif($lang == "2"){ $hr_ftel1 = "Fax number";}else{ $hr_ftel1 = "เบอร์แฟกซ์";}
      $formSet_html .='<div class="col-md-2 applntOrg_fax_txt" style="text-align:right;">'.$hr_ftel1.'</div>
      <div class="col-md-4"><input type="text" class="form-control applntOrg_fax" name="applntOrg_fax_IdxFs_'.$formSetId.'"  /></div>
    </div>
    <div class="row div_contacts_invite">';
    if($lang == "1"){ $pov_form3 = "จังหวัด";}elseif($lang == "2"){ $pov_form3 = "Province";}else{ $pov_form3 = "จังหวัด";}
    if($lang == "1"){ $pov_form3_ex = "เลือกจังหวัด";}elseif($lang == "2"){ $pov_form3_ex = "Choose your province";}else{ $pov_form3_ex = "เลือกจังหวัด";}
      $formSet_html .='<div class="col-md-3">'.$pov_form3.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-3">
        <select name="applntOrg_prov_id_IdxFs_'.$formSetId.'" id="sel_prov_invite" class="selectpicker form-control sel_prov_invite" data-live-search="true">
        <option value="">
         --- '.$pov_form3_ex.' ---
        </option>
        '.$provinceList_pers.'
      </select>
      </div>';
      if($lang == "1"){ $zipcode_form3 = "รหัสไปรษณีย์";}elseif($lang == "2"){ $zipcode_form3 = "Postcode";}else{ $zipcode_form3 = "รหัสไปรษณีย์";}
      $formSet_html .='<div class="col-md-2 txt_email_invite">'.$zipcode_form3.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-4"><input type="text" name="applntOrg_zipcode_IdxFs_'.$formSetId.'" maxlength="5" pattern="([0-9]|[0-9]|[0-9])" class="form-control complnt_zipcode"></div>
    </div>
    <div class="row div_contacts_invite">';
      if($lang == "1"){ $hr_Country1 = "ประเทศ";}elseif($lang == "2"){ $hr_Country1 = "Country";}else{ $hr_Country1 = "ประเทศ";}
    $formSet_html .='<div class="col-md-3">'.$hr_Country1.'<span style="color:#E74C3C;">*</span></div>
      <div class="col-md-9">
      <select name="applnt_country_id_IdxFs_'.$formSetId.'" id="sel_country_invite_" class="selectpicker form-control sel_country_invite_" data-live-search="true">
      <option value="">';
      if($lang == "1"){ $chcountry_form3 = "เลือกประเทศ";}elseif($lang == "2"){ $chcountry_form3 = "Choose your country";}else{ $chcountry_form3 = "เลือกประเทศ";}
        $formSet_html .='
       --- '.$chcountry_form3.' ---
      </option>
      '.$countryList.'
      </select>
      </div>
    </div>

    </div>
    </div>';
  }else {
    if($re['member_type'] == 1){
      $formSet_html .='<div class="icon_invite_home_div">
      <span class="icon_invite_home"><img src="images/all_icon_DITP/icon_17.svg" style="width:30px;"></span>';
        if($lang == "1"){ $hr_lcom1 = "บริษัทที่จดทะเบียน";}elseif($lang == "2"){ $hr_lcom1 = "Registered company";}else{ $hr_lcom1 = "บริษัทที่จดทะเบียน";}
      $formSet_html .='<span class="hr_invite_company">'.$hr_lcom1.'</span>
      </div>
      <div class="hr_invite_company_name_div">
        <span class="hr_invite_company_name">'.$re['member_comp_name'].'</span>
      </div>
      <input type="hidden" value="'.$re['member_comp_name'].'" name="applntOrg_name_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_branch'].'" name="applntOrg_branch_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_position'].'" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_taxid'].'" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_comp_address'].'" name="applntOrg_address_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['prov_id_com'].'" name="applntOrg_prov_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_comp_postcode'].'" name="applntOrg_zipcode_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_phone'].'" name="applntOrg_tel_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_fax'].'" name="applntOrg_fax_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';
    }
  }




  $formSet_html .='</div>
</div>
<input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';

$formSet_html .='</div>
</div>';
}elseif ($_GET['page'] == "invite_edit") {

$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
  <a data-toggle="collapse" href="#collapse_1" class="collapse_1"><span class="icon_hide_detail_invite"></span></a>
</div>
<div id="collapse_1" class="panel-collapse collapse in">
<div class="panel-body">';


$sql_from = "SELECT * FROM Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."'";
$query_from = $this->dbConn->query($sql_from);
$rel = $query_from->fetch_assoc();

  $sql_member ="SELECT m.member_fname,
  m.member_lname,
  m.member_cid,
  m.member_occupation,
  m.member_position,
  m.member_address,
  m.prov_id,
  m.member_postcode,
  m.country_id,
  m.member_phone,
  m.member_sex,
  m.member_email,
  m.member_type,
  m.member_business,
  m.member_cellphone,
  mc.member_comp_name,
  mc.member_comp_branch,
  mc.member_comp_taxid,
  mc.member_comp_address,
  mc.prov_id AS prov_id_com,
  mc.member_comp_postcode,
  mc.country_id AS country_id_com,
  mc.member_comp_phone,
  mc.member_comp_fax,
  mc.member_comp_type
  FROM Member AS m
  LEFT JOIN Member_comp AS mc ON m.member_id = mc.member_id
  WHERE m.member_id = '".$_SESSION['member_id']."'";
  $query_member = $this->dbConn->query($sql_member);
  $re = $query_member->fetch_assoc();
  $formSet_html .= '<div class="row">
    <div class="col-md-12">
      <div class="hr_invite">
        <span class="icon_invite_person"><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>';
          if($lang == "1"){ $hr_form1 = "ผู้ร้องเรียน";}elseif($lang == "2"){ $hr_form1 = "Petitioner";}else{ $hr_form1 = "ผู้ร้องเรียน";}
        $formSet_html .='<span class="hr_invite_title">'.$hr_form1.'</span>
      </div>
      <div class="hr_invite_name_div">
        <span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>
        <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
      </div>';

      $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />';
if($re['country_id'] == 162){
          $formSet_html .='<input type="hidden" value="'.$re['country_id'].'" name="applnt_country_id_IdxFs_'.$formSetId.'" />
          <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';

}
        $formSet_html .='<input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_email'].'" name="applnt_email_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_business'].'" name="applntOrg_import_export_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
        <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="">
        <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />';

  if($re['country_id'] != 162 && $rel['compType_other_flag'] == 0){
    $formSet_html .='
    <div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-body">
      <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="1">
      <input type="hidden" value="1" name="applnt_type_IdxFs_'.$formSetId.'"  />
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_cn1 = "ชื่อบริษัท";}elseif($lang == "2"){ $hr_cn1 = "Company Name";}else{ $hr_cn1 = "ชื่อบริษัท";}
      $formSet_html .='<div class="col-md-3">'.$hr_cn1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-9"><input type="text" class="form-control applntOrg_name" name="applntOrg_name_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_name'].'" /></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_branch1 = "สาขา";}elseif($lang == "2"){ $hr_branch1 = "Branch";}else{ $hr_branch1 = "สาขา";}
      $formSet_html .='<div class="col-md-3">'.$hr_branch1.'</div>
        <div class="col-md-9"><input type="text" class="form-control applntOrg_branch" name="applntOrg_branch_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_branch'].'"  /></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_po1 = "ตำแหน่ง";}elseif($lang == "2"){ $hr_po1 = "Position";}else{ $hr_po1 = "ตำแหน่ง";}
      $formSet_html .='<div class="col-md-3">'.$hr_po1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-9"><input type="text" class="form-control applntOrg_position" name="applntOrg_position_IdxFs_'.$formSetId.'"  /></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_tn1 = "เลขนิติบุคคล";}elseif($lang == "2"){ $hr_tn1 = "Business Registration Number";}else{ $hr_tn1 = "เลขนิติบุคคล";}
      $formSet_html .='<div class="col-md-3">'.$hr_tn1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-9"><input type="text" class="form-control applntOrg_trade_number" maxlength="13" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_trade_number'].'" /></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_Contact1 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $hr_Contact1 = "Address";}else{ $hr_Contact1 = "ที่อยู่ติดต่อ";}
      $formSet_html .='<div class="col-md-3">'.$hr_Contact1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-9"><textarea rows="4" class="form-control applntOrg_address" name="applntOrg_address_IdxFs_'.$formSetId.'" />'.$_POST['applntOrg_address'].'</textarea></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_tel1 = "เบอร์โทรศัพท์";}elseif($lang == "2"){ $hr_tel1 = "Telephone Number";}else{ $hr_tel1 = "เบอร์โทรศัพท์";}
      $formSet_html .='<div class="col-md-3">'.$hr_tel1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-3"><input type="text" class="form-control applntOrg_tel xx" name="applntOrg_tel_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_tel'].'" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;"/></div>';
          if($lang == "1"){ $hr_ftel1 = "เบอร์แฟกซ์";}elseif($lang == "2"){ $hr_ftel1 = "Fax number";}else{ $hr_ftel1 = "เบอร์แฟกซ์";}
        $formSet_html .='<div class="col-md-2 applntOrg_fax_txt" style="text-align:right;">'.$hr_ftel1.'</div>
        <div class="col-md-4"><input type="text" class="form-control applntOrg_fax" name="applntOrg_fax_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_fax'].'" /></div>
      </div>
      <div class="row div_contacts_invite">';
      if($lang == "1"){ $pov_form3 = "จังหวัด";}elseif($lang == "2"){ $pov_form3 = "Province";}else{ $pov_form3 = "จังหวัด";}
      if($lang == "1"){ $pov_form3_ex = "เลือกจังหวัด";}elseif($lang == "2"){ $pov_form3_ex = "Choose your province";}else{ $pov_form3_ex = "เลือกจังหวัด";}
        $formSet_html .='<div class="col-md-3">'.$pov_form3.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-3">
          <select name="applntOrg_prov_id_IdxFs_'.$formSetId.'" id="sel_prov_invite" class="selectpicker form-control sel_prov_invite" data-live-search="true">
          <option value="">
           --- '.$pov_form3_ex.' ---
          </option>';
            $sql = "select * from Province";
            $query = $this->dbConn->query($sql);
            if($query->num_rows > 0){
              while ($rs = $query->fetch_assoc()) {
                if($lang == "1"){
                  $prov_name = $rs["prov_name"];
                }elseif ($lang == "2") {
                  $prov_name = $rs["prov_name_eng"];
                }else {
                  $prov_name = $rs["prov_name"];
                }
        $formSet_html .= '<option value="'.$rs['prov_id'].'" '.($_POST["applntOrg_prov_id"]==$rs['prov_id']?'selected':'').'>'.$prov_name.'</option>';
                }
            }
        $formSet_html .= '</select>
        </div>';
        if($lang == "1"){ $zipcode_form3 = "รหัสไปรษณีย์";}elseif($lang == "2"){ $zipcode_form3 = "Postcode";}else{ $zipcode_form3 = "รหัสไปรษณีย์";}
        $formSet_html .='<div class="col-md-2 txt_email_invite">'.$zipcode_form3.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-4"><input type="text" name="applntOrg_zipcode_IdxFs_'.$formSetId.'" maxlength="5" pattern="([0-9]|[0-9]|[0-9])" class="form-control complnt_zipcode" value="'.$_POST['applntOrg_zipcode'].'"></div>
      </div>
      <div class="row div_contacts_invite">';
        if($lang == "1"){ $hr_Country1 = "ประเทศ";}elseif($lang == "2"){ $hr_Country1 = "Country";}else{ $hr_Country1 = "ประเทศ";}
      $formSet_html .='<div class="col-md-3">'.$hr_Country1.'<span style="color:#E74C3C;">*</span></div>
        <div class="col-md-9">
        <select name="applnt_country_id_IdxFs_'.$formSetId.'" id="sel_country_invite" class="selectpicker form-control sel_country_invite_" data-live-search="true">
        <option value="">';
        if($lang == "1"){ $chcountry_form3 = "เลือกประเทศ";}elseif($lang == "2"){ $chcountry_form3 = "Choose your country";}else{ $chcountry_form3 = "เลือกประเทศ";}
          $formSet_html .='
         --- '.$chcountry_form3.' ---
        </option>';
          $sql = "select * from Country WHERE id = '162'";
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
      $formSet_html .= '<option value="'.$rs['id'].'" '.($_POST["applnt_country_id"]==$rs['id']?'selected':'').'>'.$name.'</option>';
              }
          }
      $formSet_html .= '</select>
        </div>
      </div>

      </div>
      </div>';
    }else {
      if($re['member_type'] == 1){
        $formSet_html .='<div class="icon_invite_home_div">
        <span class="icon_invite_home"><img src="images/all_icon_DITP/icon_17.svg" style="width:30px;"></span>';
          if($lang == "1"){ $hr_lcom1 = "บริษัทที่จดทะเบียน";}elseif($lang == "2"){ $hr_lcom1 = "Registered company";}else{ $hr_lcom1 = "บริษัทที่จดทะเบียน";}
        $formSet_html .='<span class="hr_invite_company">'.$hr_lcom1.'</span>
        </div>
        <div class="hr_invite_company_name_div">
          <span class="hr_invite_company_name">'.$re['member_comp_name'].'</span>
        </div>
        <input type="hidden" value="'.$re['member_comp_name'].'" name="applntOrg_name_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_branch'].'" name="applntOrg_branch_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_position'].'" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_taxid'].'" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_comp_address'].'" name="applntOrg_address_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['prov_id_com'].'" name="applntOrg_prov_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_comp_postcode'].'" name="applntOrg_zipcode_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_phone'].'" name="applntOrg_tel_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_fax'].'" name="applntOrg_fax_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';
      }
    }




    $formSet_html .='</div>
  </div>
  <input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';

$formSet_html .='</div>
</div>';
}
?>
