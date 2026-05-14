<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/Newpanel.css">
<?php
if ($lang == 1) {
  $lang_01 = 'เป็นตัวแทนบริษัท';
  $lang_02 = 'ข้อมูลบริษัท';
  $lang_03 = 'เลขนิติบุคคล';
  $lang_04 = 'ชื่อบริษัทที่จดทะเบียน';
  $lang_05 = 'ประเภทธุรกิจ';
  $lang_06 = 'สาขา';
  $lang_07 = 'เบอร์โทรศัพท์';
  $lang_08 = 'ที่อยู่ติดต่อ';
  $lang_09 = 'ประเทศ';
  $lang_10 = 'ตำแหน่ง';
  $lang_11 = 'เว็บไซต์';
  $lang_12 = 'รหัสไปรษณีย์';
  $lang_13 = 'อื่นๆ';
  $lang_14 = 'บริษัทนำเข้า';
  $lang_15 = 'บริษัทส่งออก';
  $lang_16 = '--- เลือกประเทศ ---';
  $lang_17 = 'ยื่นเรื่องในนามบุคคลธรรมดา';
  $lang_18 = 'ข้อมูลบุคคล';
  $lang_19 = 'อาชีพ';
  $lang_20 = '(หากท่านเลือกยื่นเรื่องในนามบุคคลธรรมดา กระบวนการตรวจสอบจะใช้เวลานานกว่าปกติ)';
  $lang_21 = 'ชื่อ';
  $lang_22 = 'นามสกุล';
  $lang_23 = 'เลขบัตรประชาชน';
  $lang_24 = 'ตำแหน่ง';
  $lang_25 = 'ที่อยู่';
  $lang_26 = 'อีเมล';
} else {
  $lang_01 = 'As Company Representative';
  $lang_02 = 'Company Details';
  $lang_03 = 'Company Registration Number';
  $lang_04 = 'Company Name';
  $lang_05 = 'Type of Business';
  $lang_06 = 'Branch';
  $lang_07 = 'Telephone Number';
  $lang_08 = 'Company Address';
  $lang_09 = 'Country';
  $lang_10 = 'Position';
  $lang_11 = 'Website';
  $lang_12 = 'Post Code';
  $lang_13 = 'Other';
  $lang_14 = 'Import company';
  $lang_15 = 'Export company';
  $lang_16 = '--- Select country ---';
  $lang_17 = 'As Individual';
  $lang_18 = 'Personal Information';
  $lang_19 = 'Profession';
  $lang_20 = '(Submitting a petition as an individual is subject to more investigation and/or reconciliation time)';
  $lang_21 = 'Name';
  $lang_22 = 'Surname';
  $lang_23 = 'National ID';
  $lang_24 = 'Position';
  $lang_25 = 'Address';
  $lang_26 = 'E-mail';
}

if($_GET['page'] == "invite_form"){
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}
  // $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND frmset_id = '$formSetId'";
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
m.member_cellphone,
m.member_type,
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
mc.member_comp_type,
m.tel_code,
m.tel_country_code
FROM Member AS m
LEFT JOIN Member_comp AS mc ON m.member_id = mc.member_id
WHERE m.member_id = '".$_SESSION['member_id']."'";
$query_member = $this->dbConn->query($sql_member);
$re = $query_member->fetch_assoc();

if($re['country_id'] == 162) {
  $telcode = '';
} else {
  $sql_ct = "SELECT * FROM Country WHERE id = '".$re['country_id']."'";
  $query_ct = $this->dbConn->query($sql_ct);
  $rel_ct = $query_ct->fetch_assoc();
  $telcode = substr($rel_ct['flag_32'],0, 2);
  // print_r($telcode);
}

// if($re['member_type'] == 1){
//   if($lang == 1)
//     $lang_24 = 'ตำแหน่ง';
//   else
//     $lang_24 = 'Position';
//   $member_position = $re['member_position'];
// }else{
//   if($lang == 1)
//     $lang_24 = 'อาชีพ';
//   else
//     $lang_24 = 'Occupation';
//   $member_position = $re['member_occupation'];  
// }

$formSet_html .= '<div class="row">
  <div class="col-md-12">
  <div class="hr_invite">
    <span class="icon_invite_person"><img src="images/all_icon_DITP/icon_14.svg" style="width:30px;"></span>';
      if($lang == "1"){ $hr_form1 = "ผู้ร้องเรียน";}elseif($lang == "2"){ $hr_form1 = "Claimant";}else{ $hr_form1 = "ผู้ร้องเรียน";}
    $formSet_html .='<span class="hr_invite_title">'.$hr_form1.'</span>
  </div>
    <div class="hr_invite_name_div">
      <!--<span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>-->
      <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
    </div>';

    $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />';
      $formSet_html .='<input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_email'].'" name="applnt_email_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_business'].'" name="applntOrg_import_export_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['country_id'].'" name="applnt_country_id_IdxFs_'.$formSetId.'"  />';

      if($re['member_type'] == 0){
        $formSet_html .= '
        <div class="Newpanel-header">
          <div class="row">
              <div class="collapse in" id="multiCollapse">
              <input type="hidden" name="appint_personinfo[]" value='.$_SESSION['member_id'].'>
              <input type="hidden" name="appint_personinfo[]" value='.$re['member_type'].'>
                <div class="card card-body">
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px;">
                    <div class="col-sm-2">
                      '.$lang_21.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_fname'].' readonly="readonly">
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_22.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_lname'].' readonly="readonly">
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_23.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_cid'].' readonly="readonly">
                    </div>
                    
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_07.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container">
                        <div class="flex2" id="tel1"> ';

                        if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}

                        $formSet_html .=
                          '<input type="text" value="'.$re['member_phone'].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"   class="form-control phone-number-info" name="appint_personinfo[]" '.$ctrycode.'  onkeypress="onlynum_validate(event)" />
                          <input type="hidden" name="applnt_mobile_country" value="'.$telcode.'">
                          <input type="hidden" name="applnt_mobile_code" value="'.$re['tel_code'].'">
                        </div>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_26.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_email'].'>
                    </div>
                  </div>
                  <div class="row flexcenternew" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_25.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10" style="padding-left: 11px;">
                      <textarea rows="4" class="form-control" name="appint_personinfo[]">'.$re['member_address'].'</textarea>
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_09.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <select class="selectpicker person_country" style="width:100%;" data-live-search="true" name="appint_personinfo[]" id="person_country">
                          <option value="0">'.$lang_16.'</option>
                          '.$countryList3.'
                      </select>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_12.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">';
                    if($_POST["rdi_compTypeSub1"] == 2){$zcode = 'maxlength="5" onkeypress="onlynum_validate(event)"';}
                    $formSet_html .= '
                    <input type="text" class="form-control" name="appint_personinfo[]" '.$zcode.' value='.$re['member_postcode'].'> 
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>';

        $formSet_html .=
        '<div class="Newpanel-body" id="Newpanel-value" data-id="1">
          <input type="hidden" id="appint_personType" name="personType" value="">
          <div class="form-check">
            <div class="flexcenter">
              <input class="form-check-input Checkboxagent" type="checkbox" value="1"  name="appint_personType[]" id="CheckboxagentDefault">
              <label class="form-check-label" for="CheckboxagentDefault">
                  ' . $lang_01 . '
              </label>
              </div>
              <div class="collapse in" id="collapseagent">
              <div class="card card-body">
                  <div class="card-header flexcenter">
                    <i class="bi bi-building fa-2x"></i>
                    <span>' . $lang_02 . '</span>
                    </div>
                  <div class="Underlineborder">
                  </div>
                  <div class="card-content">
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_03 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="" name="appint_personinfo1[]" onkeypress="onlynum_validate(event)"> 
                      </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_04 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="" name="appint_personinfo1[]"> 
                      </div>
                  </div>
                  <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_05 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-2 flexcenter">
                      <select class="custom-select" id="appint_personcomtype" name="appint_personinfo1[]" onchange="showOther()">
                        <option value="0">' . $lang_13 . '</option>
                        <option value="1">' . $lang_14 . '</option>
                        <option value="2">' . $lang_15 . '</option>
                      </select>
                    </div>
                    <div class="col-sm-4" id="appint_personinfo13">
                      <input type="text" class="form-control"  name="appint_personinfo13" />
                    </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_06 . '
                      </div>
                      <div class="col-sm-4" style="margin-left: 3px;">
                        <input type="text" class="form-control" value="" name="appint_personinfo1[]"> 
                      </div>
                      <div class="col-sm-2 textend">
                      ' . $lang_24 . '
                      </div>
                      <div class="col-sm-4" style="margin-left: 3px;">
                        <input type="text" class="form-control" value="" name="appint_personinfo1[]"> 
                      </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_07 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4 flex-container" style="margin-left: 3px;">
                        <div class="flex2" id="tel1"> ';

                        if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}

                        $formSet_html .=
                          '<input type="text" value="'.$rs_case["case_feild"]["applnt_mobile"].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"   class="form-control phone-number" name="appint_personinfo1[]" '.$ctrycode.'  onkeypress="onlynum_validate(event)" />
                          <input type="hidden" name="applntOrg_mobile_country" value="">
                          <input type="hidden" name="applntOrg_mobile_code" value="">
                        </div>
                      </div>
                      <div class="col-sm-2 textend">
                        ' . $lang_11 . '
                      </div>
                      <div class="col-sm-4" style="margin-left: 3px;">
                        <input type="text" class="form-control" value="" name="appint_personinfo1[]"> 
                      </div>
                  </div>
                  <div class="row flexcenternew">
                      <div class="col-sm-2">
                        ' . $lang_08 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                          <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]"></textarea>
                      </div>
                  </div>
                  <div class="row flexcenter"">
                      <div class="col-sm-2">
                        ' . $lang_09 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4">
                      <select class="selectpicker country_newpanel" style="width:100%;" data-live-search="true" name="appint_personinfo1[]" id="country_newpanel">
                          <option value="0">' . $lang_16 . '</option>';

                          if($_POST["rdi_compTypeSub1"] == 1){$ctryList = $countryList3;} else {$ctryList = $countryList;}

                          $formSet_html .= ' ' . $ctryList . '
                      </select>
                    <input type="hidden" name="appIntOrg_countryname" id="appIntOrg_countryname" value="">
                  </div>
                      <div class="col-sm-2 textend">
                        ' . $lang_12 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4">';
                      if($_POST["rdi_compTypeSub1"] == 2){$zcode = 'maxlength="5" onkeypress="onlynum_validate(event)"';}
                      $formSet_html .= '
                      <input type="text" class="form-control" value="" '.$zcode.' name="appint_personinfo1[]">  
                      </div>
                  </div>
                  </div>
              </div>
              </div>
          </div>
          <div class="form-check">
              <div class="flexcenter">
              <input class="form-check-input Checkboxperson" type="checkbox" value="2" name="appint_personType[]">
              <label class="form-check-label" for="CheckboxpersonDefault">
                ' . $lang_17 . '
              </label>
              </div>
              <div class="collapse" id="collapseperson">
              <div class="card card-body">
                  <div class="card-header flexcenter">
                  <i class="bi bi-person-fill fa-2x"></i>
                  <span>' . $lang_18 . '</span>
                  </div>
                  <div class="Underlineborder"></div>
                  <div class="card-content">
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_19 . '
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="corporatenumber"  name="appint_personinfo2[]"> 
                      </div>
                  </div>
                  </div>
                  <span style="margin-bottom: 5px; color: red;">' . $lang_20 . '</span>
              </div>
              </div>
          </div>
        </div>';
      }else{
        $hr_lcom1 = (($lang == '2')?'Registered company':'บริษัทที่จดทะเบียน');
        $formSet_html .= '
        <div class="icon_invite_home_div">
          <span class="icon_invite_home"><img src="images/all_icon_DITP/icon_17.svg" style="width:30px;"></span>
          <span class="hr_invite_company">'.$hr_lcom1.'</span>
        </div>
        <div class="hr_invite_company_name_div">
          <span class="hr_invite_company_name">'.$re['member_comp_name'].'</span>
        </div>
        <div class="Newpanel-header">
          <div class="row">
              <div class="collapse in" id="multiCollapse">
              <input type="hidden" name="appint_personinfo[]" value='.$_SESSION['member_id'].'>
              <input type="hidden" name="appint_personinfo[]" value='.$re['member_type'].'>
                <div class="card card-body">
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px;">
                    <div class="col-sm-2">
                      '.$lang_21.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_fname'].'>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_22.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_lname'].'>
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_23.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">';
                    if($_POST["rdi_compTypeSub1"] == 2){$cid = 'maxlength="13"';}
                    $formSet_html .= '
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_cid'].' '.$cid .' onkeypress="onlynum_validate(event)">
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_07.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container" >
                        <div class="flex2" id="tel1"> ';

                      if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}

                      $formSet_html .=
                        '<input type="text" value="'.$re['member_phone'].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"   class="form-control phone-number-info" name="appint_personinfo[]" '.$ctrycode.'  onkeypress="onlynum_validate(event)" />
                        <input type="hidden" name="applnt_mobile_country" value="'.$telcode.'">
                        <input type="hidden" name="applnt_mobile_code" value="'.$re['tel_code'].'">
                      </div>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_26.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" value='.$re['member_email'].'>
                    </div>
                  </div>
                  <div class="row flexcenternew" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_25.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10" style="padding-left: 11px;">
                      <textarea rows="4" class="form-control" name="appint_personinfo[]">'.$re['member_address'].'</textarea>
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_09.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <select class="selectpicker person_country" style="width:100%;" data-live-search="true" name="appint_personinfo[]" id="person_country">
                          <option value="0">'.$lang_16.'</option>
                          '.$countryList3.'
                      </select>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_12.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">';
                    if($_POST["rdi_compTypeSub1"] == 2){$zcode = 'maxlength="5" onkeypress="onlynum_validate(event)"';}
                    $formSet_html .= '
                      <input type="text" class="form-control" name="appint_personinfo[]" '.$zcode.' value='.$re['member_postcode'].'> 
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>';

        $formSet_html .=
          '<div class="Newpanel-body" id="Newpanel-value" data-id="1">
            <input type="hidden" id="appint_personType" name="personType" value="">
            <div class="form-check">
              <div class="flexcenter">
              <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxagentDefault" name="appint_personType[]">
              <label class="form-check-label" for="CheckboxagentDefault">
                  ' . $lang_01 . '
              </label>
              </div>
              <div class="collapse in" id="collapseagent">
              <div class="card card-body">
                  <div class="card-header flexcenter">
                    <i class="bi bi-building fa-2x"></i>
                    <span>' . $lang_02 . '</span>
                    </div>
                  <div class="Underlineborder">
                  </div>
                  <div class="card-content">
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_03 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_taxid'] . '" readonly="readonly"> 
                      </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_04 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_name'] . '" readonly="readonly"> 
                      </div>
                  </div>
                  <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_05 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-2 flexcenter">
                      <select class="custom-select " id="appint_personcomtype" name="appint_personinfo1[]" onchange="showOther()">
                        <option value="0" '.($re['member_business']=="0"?"selected":"").'>' . $lang_13 . '</option>
                        <option value="1" '.($re['member_business']=="1"?"selected":"").'>' . $lang_14 . '</option>
                        <option value="2" '.($re['member_business']=="2"?"selected":"").'>' . $lang_15 . '</option>
                        
                      </select>
                    </div>
                    <div class="col-sm-4" id="appint_personinfo13" '.($re['member_business']!="0"?"style='display:none'":"").'>
                      <input type="text" class="form-control"  name="appint_personinfo13"  />
                    </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_06 . '
                      </div>
                      <div class="col-sm-4" style="margin-left: 3px;">
                        <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_branch'] . '" > 
                      </div>
                      <div class="col-sm-2 textend">
                        ' . $lang_24 . '
                      </div>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_position'] . '" >
                      </div>
                  </div>
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_07 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4 flex-container" style="margin-left: 3px;">
                        <div class="flex2" id="tel1">';
                        if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}
                        $formSet_html .= '
                          <input type="text" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number" name="appint_personinfo1[]"  value="' . $re['member_comp_phone'] . '" '.$ctrycode.' onkeypress="onlynum_validate(event)"  />
                          <input type="hidden" name="applntOrg_mobile_country" value="'.$telcode.'">
                          <input type="hidden" name="applntOrg_mobile_code" value="'.$re['tel_code'].'">
                        </div>
                      </div>
                      <div class="col-sm-2 textend">
                        ' . $lang_11 . '
                      </div>
                      <div class="col-sm-4" style="margin-left: 3px;">
                        <input type="text" class="form-control" name="appint_personinfo1[]" value="" > 
                      </div>
                  </div>
                  <div class="row flexcenternew">
                      <div class="col-sm-2">
                        ' . $lang_08 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-10">
                          <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" >' . $re['member_comp_address'] . '</textarea>
                      </div>
                  </div>
                  <div class="row flexcenter"">
                      <div class="col-sm-2">
                        ' . $lang_09 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4">
                      <select class="selectpicker person_country" style="width:100%;" data-live-search="true" name="appint_personinfo1[]" id="person_country">
                          <option value="0">' . $lang_16 . '</option>';

                          if($_POST["rdi_compTypeSub1"] == 1){$ctryList = $countryList3;} else {$ctryList = $countryList;}

                          $formSet_html .= ' ' . $ctryList . '
                      </select>
                    <input type="hidden" name="appIntOrg_countryname" id="appIntOrg_countryname" value="">
                    </div>
                      <div class="col-sm-2 textend">
                        ' . $lang_12 . '<span style="color:#E74C3C;">*</span>
                      </div>
                      <div class="col-sm-4">';
                      if($_POST["rdi_compTypeSub1"] == 2){$zcode = 'maxlength="5" onkeypress="onlynum_validate(event)"';}
                      $formSet_html .= '
                      <input type="text" class="form-control" name="appint_personinfo1[]" '.$zcode .'  value="' . $re['member_comp_postcode'] . '" > 
                      </div>
                  </div>
                  </div>
              </div>
              </div>
          </div>
          <div class="form-check">
              <div class="flexcenter">
              <input class="form-check-input Checkboxperson" type="checkbox" value="2" id="CheckboxpersonDefault" name="appint_personType[]">
              <label class="form-check-label" for="CheckboxpersonDefault">
                ' . $lang_17 . '
              </label>
              </div>
              <div class="collapse" id="collapseperson">
              <div class="card card-body">
                  <div class="card-header flexcenter">
                  <i class="bi bi-person-fill fa-2x"></i>
                  <span>' . $lang_18 . '</span>
                  </div>
                  <div class="Underlineborder"></div>
                  <div class="card-content">
                  <div class="row flexcenter">
                      <div class="col-sm-2">
                        ' . $lang_19 . '
                      </div>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="corporatenumber" name="appint_personinfo2[]"> 
                      </div>
                  </div>
                  </div>
                  <span style="margin-bottom: 5px; color: red;">' . $lang_20 . '</span>
              </div>
              </div>
          </div>
        </div>';
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
  m.member_type,
  m.member_email,
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
      <span class="icon_invite_person"><img src="images/all_icon_DITP/icon_14.svg" style="width:30px;"></span>';
        if($lang == "1"){ $hr_form1 = "ผู้ร้องเรียน";}elseif($lang == "2"){ $hr_form1 = "Petitioner";}else{ $hr_form1 = "ผู้ร้องเรียน";}
      $formSet_html .='<span class="hr_invite_title">'.$hr_form1.'</span>
    </div>
      <div class="hr_invite_name_div">
        <!--<span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>-->
        <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
      </div>';

      if ($re['member_type'] == 0) {
        $formSet_html .= '
        <div class="Newpanel-header">
          <div class="row">
              <div class="collapse in" id="multiCollapse">
              <input type="hidden" name="appint_personinfo[]" value="">
              <input type="hidden" name="appint_personinfo[]" value="">
                <div class="card card-body">
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px;">
                    <div class="col-sm-2">
                      '.$lang_21.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" readonly="readonly">
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_22.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" readonly="readonly">
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_23.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" readonly="readonly">
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_07.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container">
                      <div class="flex2" id="tel1">';
                      if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}
                      $formSet_html .= '
                        <input type="text" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number-info" name="appint_personinfo[]" '.$ctrycode.' onkeypress="onlynum_validate(event)"  />
                        <input type="hidden" name="applnt_mobile_country" value="">
                        <input type="hidden" name="applnt_mobile_code" value="">
                      </div>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_26.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]">
                    </div>
                  </div>
                  <div class="row flexcenternew" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_25.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10" style="padding-left: 11px;">
                      <textarea rows="4" class="form-control" name="appint_personinfo[]"></textarea>
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_09.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <select class="selectpicker person_country" style="width:100%;" data-live-search="true" name="appint_personinfo[]" id="person_country">
                          <option value="0">'.$lang_16.'</option>
                          '.$countryList3.'
                      </select>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_12.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="appint_personinfo[]" onkeypress="onlynum_validate(event)"> 
                    </div>
                  </div>
                </div>
                <div style="display:none" id="appintpersoninfo"></div>
              </div>
          </div>
        </div>';
        $formSet_html .=
        '<div class="Newpanel-body" id="Newpanel-value" data-id="1">
          <input type="hidden" id="appint_personType" name="personType" value="">
          <div class="form-check">
            <div class="flexcenter">
            <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxagentDefault" name="appint_personType[]">
            <label class="form-check-label" for="CheckboxagentDefault">
                ' . $lang_01 . '
            </label>
            </div>
            <div class="collapse" id="collapseagent">
            <div class="card card-body">
                <div class="card-header flexcenter">
                  <i class="bi bi-building fa-2x"></i>
                  <span>' . $lang_02 . '</span>
                  </div>
                <div class="Underlineborder">
                </div>
                <div class="card-content">
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_03 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_taxid'] . '" > 
                    </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_04 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_name'] . '"> 
                    </div>
                </div>
                <div class="row flexcenter">
                  <div class="col-sm-2">
                    ' . $lang_05 . '<span style="color:#E74C3C;">*</span>
                  </div>
                  <div class="col-sm-2 flexcenter">
                    <select class="custom-select " id="appint_personcomtype" name="appint_personinfo1[]" onchange="showOther()">
                      <option value="0">' . $lang_13 . '</option>
                      <option value="1">' . $lang_14 . '</option>
                      <option value="2">' . $lang_15 . '</option>
                    </select>
                  </div>
                  <div class="col-sm-4" id="appint_personinfo13">
                    <input type="text" class="form-control"  name="appint_personinfo13"  />
                  </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_06 . '
                    </div>
                    <div class="col-sm-4" style="margin-left: 3px;">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_branch'] . '" > 
                    </div>
                    <div class="col-sm-2 textend">
                      ' . $lang_24 . '
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_position'] . '" >
                    </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_07 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container" style="margin-left: 3px;">
                        <div class="flex2" id="tel1">';
                      if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}
                      $formSet_html .= '
                        <input type="text" value="'.$rs_case["case_feild"]["applnt_mobile"].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number" name="appint_personinfo1[]"  value="' . $re['member_comp_phone'] . '" '.$ctrycode.' onkeypress="onlynum_validate(event)"  />
                        <input type="hidden" name="applntOrg_mobile_country" value="">
                        <input type="hidden" name="applntOrg_mobile_code" value="">
                      </div>
                    </div>
                    <div class="col-sm-2 textend">
                      ' . $lang_11 . '
                    </div>
                    <div class="col-sm-4" style="margin-left: 3px;">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="" > 
                    </div>
                </div>
                <div class="row flexcenternew">
                    <div class="col-sm-2">
                      ' . $lang_08 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                        <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" >' . $re['member_comp_address'] . '</textarea>
                    </div>
                </div>
                <div class="row flexcenter"">
                  <div class="col-sm-2">
                    ' . $lang_09 . '<span style="color:#E74C3C;">*</span>
                  </div>
                  <div class="col-sm-4">
                    <select class="selectpicker country_newpanel" style="width:100%;" data-live-search="true" name="appint_personinfo1[]" id="country_newpanel">
                        <option value="0">' . $lang_16 . '</option>
                        ' . $countryList3 . '
                    </select>
                    <input type="hidden" name="appIntOrg_countryname" id="appIntOrg_countryname" value="">
                  </div>
                  <div class="col-sm-2 textend">
                    ' . $lang_12 . '<span style="color:#E74C3C;">*</span>
                  </div>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" maxlength="5" name="appint_personinfo1[]" value="' . $re['member_comp_postcode'] . '" > 
                  </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="form-check">
            <div class="flexcenter">
            <input class="form-check-input Checkboxperson" type="checkbox" value="2" id="CheckboxpersonDefault" name="appint_personType[]">
            <label class="form-check-label" for="CheckboxpersonDefault">
              ' . $lang_17 . '
            </label>
            </div>
            <div class="collapse" id="collapseperson">
            <div class="card card-body">
                <div class="card-header flexcenter">
                <i class="bi bi-person-fill fa-2x"></i>
                <span>' . $lang_18 . '</span>
                </div>
                <div class="Underlineborder"></div>
                <div class="card-content">
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_19 . '
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="corporatenumber" name="appint_personinfo2[]"> 
                    </div>
                </div>
                </div>
                <span style="margin-bottom: 5px; color: red;">' . $lang_20 . '</span>
            </div>
            </div>
        </div>
      </div>';
      }else{
        $formSet_html .= '
        <div class="Newpanel-header">
          <div class="row">
              <div class="collapse in" id="multiCollapse">
              <input type="hidden" name="appint_personinfo[]" value="">
              <input type="hidden" name="appint_personinfo[]" value="">
                <div class="card card-body">
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px;">
                    <div class="col-sm-2">
                      '.$lang_21.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]">
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_22.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]" >
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_23.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]">
                    </div>
            
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_07.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container">
                        <div class="flex2" id="tel1">';
                      if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}
                      $formSet_html .= '
                        <input type="text" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number-info" name="appint_personinfo[]" '.$ctrycode.' onkeypress="onlynum_validate(event)"  />
                        <input type="hidden" name="applnt_mobile_country" value="">
                        <input type="hidden" name="applnt_mobile_code" value="">
                      </div>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_26.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="" name="appint_personinfo[]">
                    </div>
                  </div>
                  <div class="row flexcenternew" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_25.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10" style="padding-left: 11px;">
                      <textarea rows="4" class="form-control" name="appint_personinfo[]"></textarea>
                    </div>
                  </div>
                  <div class="row flexcenter" style="margin-left:0px; margin-right:0px; margin-top: 8px;">
                    <div class="col-sm-2">
                      '.$lang_09.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <select class="selectpicker person_country" style="width:100%;" data-live-search="true" name="appint_personinfo[]" id="person_country">
                          <option value="0">'.$lang_16.'</option>
                          '.$countryList3.'
                      </select>
                    </div>
                    <div class="col-sm-2 text-center">
                      '.$lang_12.'<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="appint_personinfo[]" onkeypress="onlynum_validate(event)"> 
                    </div>
                  </div>
                </div>
                <div style="display:none" id="appintpersoninfo"></div>
              </div>
          </div>
        </div>';
        $formSet_html .=
        '<div class="Newpanel-body" id="Newpanel-value" data-id="1">
          <input type="hidden" id="appint_personType" name="personType" value="">
          <div class="form-check">
            <div class="flexcenter">
            <input class="form-check-input Checkboxagent" type="checkbox" value="1" id="CheckboxagentDefault" name="appint_personType[]">
            <label class="form-check-label" for="CheckboxagentDefault">
                ' . $lang_01 . '
            </label>
            </div>
            <div class="collapse" id="collapseagent">
            <div class="card card-body">
                <div class="card-header flexcenter">
                  <i class="bi bi-building fa-2x"></i>
                  <span>' . $lang_02 . '</span>
                  </div>
                <div class="Underlineborder">
                </div>
                <div class="card-content">
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_03 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_taxid'] . '" readonly="readonly"> 
                    </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_04 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_name'] . '" readonly="readonly"> 
                    </div>
                </div>
                <div class="row flexcenter">
                  <div class="col-sm-2">
                    ' . $lang_05 . '<span style="color:#E74C3C;">*</span>
                  </div>
                  <div class="col-sm-2 flexcenter">
                    <select class="custom-select " id="appint_personcomtype" name="appint_personinfo1[]" onchange="showOther()">
                      <option value="0">' . $lang_13 . '</option>
                      <option value="1">' . $lang_14 . '</option>
                      <option value="2">' . $lang_15 . '</option>
                    </select>
                  </div>
                  <div class="col-sm-4" id="appint_personinfo13">
                    <input type="text" class="form-control"  name="appint_personinfo13"  />
                  </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_06 . '
                    </div>
                    <div class="col-sm-4" style="margin-left: 3px;">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_comp_branch'] . '" > 
                    </div>
                    <div class="col-sm-2 textend">
                      ' . $lang_24 . '
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="' . $re['member_position'] . '" >
                    </div>
                </div>
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_07 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4 flex-container" style="margin-left: 3px;">
                        <div class="flex2" id="tel1">';
                      if($_POST["rdi_compTypeSub1"] == 2){$ctrycode = 'maxlength="10"';}
                      $formSet_html .= '
                        <input type="text" value="'.$rs_case["case_feild"]["applnt_mobile"].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control phone-number" name="appint_personinfo1[]"  value="' . $re['member_comp_phone'] . '" '.$ctrycode.' onkeypress="onlynum_validate(event)"  />
                        <input type="hidden" name="applntOrg_mobile_country" value="">
                        <input type="hidden" name="applntOrg_mobile_code" value="">
                      </div>
                    </div>
                    <div class="col-sm-2 textend">
                      ' . $lang_11 . '
                    </div>
                    <div class="col-sm-4" style="margin-left: 3px;">
                      <input type="text" class="form-control" name="appint_personinfo1[]" value="" > 
                    </div>
                </div>
                <div class="row flexcenternew">
                    <div class="col-sm-2">
                      ' . $lang_08 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-10">
                        <textarea rows="4" class="form-control applntOrg_address" name="appint_personinfo1[]" >' . $re['member_comp_address'] . '</textarea>
                    </div>
                </div>
                <div class="row flexcenter"">
                    <div class="col-sm-2">
                      ' . $lang_09 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                    <select class="selectpicker country_newpanel" style="width:100%;" data-live-search="true" name="appint_personinfo1[]" id="country_newpanel">
                        <option value="0">' . $lang_16 . '</option>
                        ' . $countryList3 . '
                    </select>
                    <input type="hidden" name="appIntOrg_countryname" id="appIntOrg_countryname" value="">
                    </div>
                    <div class="col-sm-2 textend">
                      ' . $lang_12 . '<span style="color:#E74C3C;">*</span>
                    </div>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" maxlength="5" name="appint_personinfo1[]" value="' . $re['member_comp_postcode'] . '" > 
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="form-check">
            <div class="flexcenter">
            <input class="form-check-input Checkboxperson" type="checkbox" value="2" id="CheckboxpersonDefault" name="appint_personType[]">
            <label class="form-check-label" for="CheckboxpersonDefault">
              ' . $lang_17 . '
            </label>
            </div>
            <div class="collapse" id="collapseperson">
            <div class="card card-body">
                <div class="card-header flexcenter">
                <i class="bi bi-person-fill fa-2x"></i>
                <span>' . $lang_18 . '</span>
                </div>
                <div class="Underlineborder"></div>
                <div class="card-content">
                <div class="row flexcenter">
                    <div class="col-sm-2">
                      ' . $lang_19 . '
                    </div>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="corporatenumber" name="appint_personinfo2[]"> 
                    </div>
                </div>
                </div>
                <span style="margin-bottom: 5px; color: red;">' . $lang_20 . '</span>
            </div>
            </div>
        </div>
      </div>';
      }

      // if($_POST['rdi_compTypeSub1'] == 1){
      //   $formSet_html .=
      //   '<div class="Newpanel-body" id="Newpanel-value" data-id="1">
      //     <div class="form-check">
      //         <div class="flexcenter">
      //         <input class="form-check-input Checkboxagent" type="checkbox" value="" id="CheckboxagentDefault">
      //         <label class="form-check-label" for="CheckboxagentDefault">
      //             '.$lang_01.'
      //         </label>
      //         </div>
      //         <div class="collapse" id="collapseagent">
      //         <div class="card card-body">
      //             <div class="card-header flexcenter">
      //               <i class="bi bi-building fa-2x"></i>
      //               <span>'.$lang_02.'</span>
      //               </div>
      //             <div class="Underlineborder">
      //             </div>
      //             <div class="card-content">
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_03.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-10">
      //                   <input type="text" class="form-control" id="corporatenumber" name="Represent_value[]"> 
      //                 </div>
      //             </div>
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_04.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-10">
      //                   <input type="text" class="form-control" name="Represent_value[]"> 
      //                 </div>
      //             </div>
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_05.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-10 flexcenter">
      //                     <select class="form-select form-select-lg mb-3" id="selecttype_comp" name="Represent_value[]">
      //                         <option value="0" selected>'.$lang_13.'</option>
      //                         <option value="1">'.$lang_14.'</option>
      //                         <option value="2">'.$lang_15.'</option>
      //                     </select>
      //                     <input class="" type="text" id="inputtype_comp" name="Represent_value[]">
      //                 </div>
      //             </div>
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_06.'
      //                 </div>
      //                 <div class="col-sm-4" style="margin-left: 3px;">
      //                   <input type="text" class="form-control" name="Represent_value[]"> 
      //                 </div>
      //                 <div class="col-sm-2">
      //                   '.$lang_07.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-4" style="margin-left: 3px;">
      //                   <input type="text" class="form-control" name="Represent_value[]"> 
      //                 </div>
      //             </div>
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_11.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-10">
      //                   <input type="text" class="form-control" name="Represent_value[]"> 
      //                 </div>
      //             </div>
      //             <div class="row flexcenternew">
      //                 <div class="col-sm-2">
      //                   '.$lang_08.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-10">
      //                     <textarea rows="4" class="form-control applntOrg_address" name="Represent_value[]"></textarea>
      //                 </div>
      //             </div>
      //             <div class="row flexcenter"">
      //                 <div class="col-sm-2">
      //                   '.$lang_09.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-4" style="margin-left: 3px;">
      //                   <select class="selectpicker country_newpanel" style="width:100%;" data-live-search="true" name="applnt_countryid_idx">
      //                       <option value="0">'.$lang_16.'</option>
      //                       '.$countryList2.'
      //                   </select>
      //                 </div>
      //                 <div class="col-sm-2 textend">
      //                   '.$lang_12.'<span style="color:#E74C3C;">*</span>
      //                 </div>
      //                 <div class="col-sm-4">
      //                   <input type="text" class="form-control" name="Represent_value[]" onkeypress="onlynum_validate(event)"> 
      //                 </div>
      //             </div>
      //             </div>
      //         </div>
      //         </div>
      //     </div>
      //     <div class="form-check">
      //         <div class="flexcenter">
      //         <input class="form-check-input Checkboxperson" type="checkbox" value="" id="CheckboxpersonDefault">
      //         <label class="form-check-label" for="CheckboxpersonDefault">
      //           '.$lang_17.'
      //         </label>
      //         </div>
      //         <div class="collapse" id="collapseperson">
      //         <div class="card card-body">
      //             <div class="card-header flexcenter">
      //             <i class="bi bi-person-fill fa-2x"></i>
      //             <span>'.$lang_18.'</span>
      //             </div>
      //             <div class="Underlineborder"></div>
      //             <div class="card-content">
      //             <div class="row flexcenter">
      //                 <div class="col-sm-2">
      //                   '.$lang_19.'
      //                 </div>
      //                 <div class="col-sm-10">
      //                   <input type="text" class="form-control" id="corporatenumber" name="Natural_person[]"> 
      //                 </div>
      //             </div>
      //             </div>
      //             <span style="margin-bottom: 5px; color: red;">'.$lang_20.'</span>
      //         </div>
      //         </div>
      //     </div>
      //   </div>';
      // }
    

      $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />';
        $formSet_html .='<input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_email'].'" name="applnt_email_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_business'].'" name="applntOrg_import_export_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />';

  // if($rel['compType_other_flag'] == 1){
  //   $formSet_html .='
  //   <div class="panel panel-default" style="margin-top: 20px;">
  //   <div class="panel-body">
  //     <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="2">
  //     <input type="hidden" value="1" name="applnt_type_IdxFs_'.$formSetId.'"  />
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $cn_form2 = "ชื่อบริษัท";}elseif($lang == "2"){ $cn_form2 = "Company Name";}else{ $cn_form2 = "ชื่อบริษัท";}
  //     $formSet_html .='<div class="col-md-3">'.$cn_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-9"><input type="text" class="form-control applntOrg_name" name="applntOrg_name_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_name'].'" /></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $branch_form2 = "สาขา";}elseif($lang == "2"){ $branch_form2 = "Branch";}else{ $branch_form2 = "สาขา";}
  //     $formSet_html .='<div class="col-md-3">'.$branch_form2.'</div>
  //       <div class="col-md-9"><input type="text" class="form-control applntOrg_branch" name="applntOrg_branch_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_branch'].'"  /></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $position_form2 = "ตำแหน่ง";}elseif($lang == "2"){ $position_form2 = "Position";}else{ $position_form2 = "ตำแหน่ง";}
  //     $formSet_html .='<div class="col-md-3">'.$position_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-9"><input type="text" class="form-control applntOrg_position" name="applntOrg_position_IdxFs_'.$formSetId.'"  /></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //       if($lang == "1"){ $hr_tn2 = "หมายเลขทะเบียนการค้า";}elseif($lang == "2"){ $hr_tn2 = "Business Registration Number";}else{ $hr_tn2 = "หมายเลขทะเบียนการค้า";}
  //     $formSet_html .='<div class="col-md-3">'.$hr_tn2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-9"><input type="text" class="form-control applntOrg_trade_number" maxlength="13" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_trade_number'].'" /></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $address_form2 = "ที่อยู่ติดต่อ";}elseif($lang == "2"){ $address_form2 = "Address";}else{ $address_form2 = "ที่อยู่ติดต่อ";}
  //       $formSet_html .='<div class="col-md-3">'.$address_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-9"><textarea rows="4" class="form-control applntOrg_address" name="applntOrg_address_IdxFs_'.$formSetId.'" />'.$_POST['applntOrg_address'].'</textarea></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $tel_form2 = "เบอร์โทรศัพท์";}elseif($lang == "2"){ $tel_form2 = "Telephone Number";}else{ $tel_form2 = "เบอร์โทรศัพท์";}
  //       $formSet_html .='<div class="col-md-3">'.$tel_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-3"><input type="text" class="form-control applntOrg_tel" name="applntOrg_tel_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_tel'].'" /></div>';
  //     if($lang == "1"){ $fax_form2 = "เบอร์แฟกซ์";}elseif($lang == "2"){ $fax_form2 = "Fax number";}else{ $fax_form2 = "เบอร์แฟกซ์";}
  //       $formSet_html .='<div class="col-md-2 applntOrg_fax_txt" style="text-align:right;">'.$fax_form2.'</div>
  //       <div class="col-md-4"><input type="text" class="form-control applntOrg_fax" name="applntOrg_fax_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_fax'].'" /></div>
  //     </div>
  //     <div class="row div_contacts_invite">';
  //     if($lang == "1"){ $country_form2 = "ประเทศ";}elseif($lang == "2"){ $country_form2 = "Country";}else{ $country_form2 = "ประเทศ";}
  //       $formSet_html .='<div class="col-md-3">'.$country_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-9">
  //       <select name="applnt_country_id_IdxFs_'.$formSetId.'" id="sel_country_invite" class="selectpicker form-control sel_country_invite_" data-live-search="true" onchange="chk_country();">
  //       <option value="">';
  //       if($lang == "1"){ $chcountry_form3 = "เลือกประเทศ";}elseif($lang == "2"){ $chcountry_form3 = "Choose your country";}else{ $chcountry_form3 = "เลือกประเทศ";}
  //         $formSet_html .='
  //        --- '.$chcountry_form3.' ---
  //       </option>';
  //         $sql = "select * from Country ORDER BY name";
  //         $query = $this->dbConn->query($sql);
  //         if($query->num_rows > 0){
  //           while ($rs = $query->fetch_assoc()) {
  //             if($lang == "1"){
  //               $name = $rs['name'];
  //             }elseif ($lang == "2") {
  //               $name = $rs['name'];
  //             }else {
  //               $name = $rs['name'];
  //             }
  //     $formSet_html .= '<option value="'.$rs['id'].'" '.($_POST["applnt_country_id"]==$rs['id']?'selected':'').'>'.$name.'</option>';
  //             }
  //         }
  //     $formSet_html .= '</select>
  //       </div>';
  //     if($lang == "1"){ $zipcode_form2 = "รหัสไปรษณีย์";}elseif($lang == "2"){ $zipcode_form2 = "Postcode";}else{ $zipcode_form2 = "รหัสไปรษณีย์";}
  //       $formSet_html .='<div class="col-md-2 applntOrg_zipcode_txt"  style="text-align: right;">'.$zipcode_form2.'<span style="color:#E74C3C;">*</span></div>
  //       <div class="col-md-4"><input type="text" class="form-control applntOrg_zipcode" maxlength="5" pattern="([0-9]|[0-9]|[0-9])" name="applntOrg_zipcode_IdxFs_'.$formSetId.'" value="'.$_POST['applntOrg_zipcode'].'" /></div>
  //     </div>
  //     </div>
  //     </div>';
  //   }

$formSet_html .='</div>
</div>
<input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';
$formSet_html .='</div>
</div>';
}
?>
