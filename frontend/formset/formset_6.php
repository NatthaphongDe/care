<?php
if($_GET['page'] == "invite_form"){
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon_13.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
  <a data-toggle="collapse" href="#collapse_1" class="collapse_1"><span class="icon_hide_detail_invite"></span></a>
</div>
<div id="collapse_1" class="panel-collapse collapse in">
<div class="panel-body">';


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
      <span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>
      <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
    </div>';

    $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['country_id'].'" name="applnt_country_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />
      <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="">';

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
      <input type="hidden" value="'.$re['member_comp_taxid'].'" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_comp_address'].'" name="applntOrg_address_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['prov_id_com'].'" name="applntOrg_prov_id_IdxFs_'.$formSetId.'" />
      <input type="hidden" value="'.$re['member_comp_postcode'].'" name="applntOrg_zipcode_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_phone'].'" name="applntOrg_tel_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_fax'].'" name="applntOrg_fax_IdxFs_'.$formSetId.'"  />
      <input type="hidden" value="'.$re['member_comp_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';
  }



  $formSet_html .='</div>
</div>
<input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';

$formSet_html .='</div>
</div>';
}if ($_GET['page'] == "invite_edit") {

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
        <span class="hr_invite_name">'.$re['member_fname'].'&nbsp;&nbsp;&nbsp;'.$re['member_lname'].'</span>
        <input type="hidden" value="'.$re['member_fname'].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_lname'].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
      </div>';

      $formSet_html .='<input type="hidden" value="'.$re['member_cid'].'" name="applnt_ident_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_occupation'].'" name="applnt_career_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_address'].'" name="applnt_address_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['prov_id'].'" name="applnt_prov_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_postcode'].'" name="applnt_zipcode_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_phone'].'" name="applnt_tel_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />
        <input type="hidden" class="applntOrg_show" name="applntOrg_show" value="">';

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
        <input type="hidden" value="'.$re['member_comp_taxid'].'" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_comp_address'].'" name="applntOrg_address_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['prov_id_com'].'" name="applntOrg_prov_id_IdxFs_'.$formSetId.'" />
        <input type="hidden" value="'.$re['member_comp_postcode'].'" name="applntOrg_zipcode_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_phone'].'" name="applntOrg_tel_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_sex'].'" name="applnt_gender_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_cellphone'].'" name="applnt_mobile_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_fax'].'" name="applntOrg_fax_IdxFs_'.$formSetId.'"  />
        <input type="hidden" value="'.$re['member_comp_type'].'" name="applnt_type_IdxFs_'.$formSetId.'"  />';
    }


    $formSet_html .='</div>
  </div>
  <input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';

$formSet_html .='</div>
</div>';
}
?>
