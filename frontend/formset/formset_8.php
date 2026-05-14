<?php
if($_GET['page'] == "invite_form"){
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon-18.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
</div>

<div class="panel-body">';


  $formSet_html .= '<div class="row div_complaint_invite">';
  if($lang == "1"){ $top_form5 = "หัวข้อเรื่องร้องเรียน";}elseif($lang == "2"){ $top_form5 = "Petition topic";}else{ $top_form5 = "หัวข้อเรื่องร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$top_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control caseDtl_title" name="caseDtl_title_IdxFs_'.$formSetId.'"></div>
  </div>
  <div class="row div_category_invite">';
  if($lang == "1"){ $Category_form5 = "ประเภทความผิด";}elseif($lang == "2"){ $Category_form5 = "Type of complaint";}else{ $Category_form5 = "ประเภทความผิด";}
    $formSet_html .='<div class="col-md-3">'.$Category_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
      <select name="incType_id_IdxFs_'.$formSetId.'" id="sel_category_invite" class="selectpicker form-control sel_category_invite" onchange="chk_prod();">
      <option value="">';
      if($lang == "1"){ $Chft_form5 = "เลือกประเภทความผิด";}elseif($lang == "2"){ $Chft_form5 = "Please choose type of complaint";}else{ $Chft_form5 = "เลือกประเภทความผิด";}
        $formSet_html .='--- '.$Chft_form5.' ---</option>';

        $sql = "SELECT * FROM `Incorrect_Type`";
        $query = $this->dbConn->query($sql);
        if($query->num_rows > 0){
          while ($re = $query->fetch_assoc()) {
            if($lang == "2"){
              $incType_name = $re["incType_name_en"];
            }else {
              $incType_name = $re["incType_name"];
            }
        $formSet_html .= '<option value="'.$re["incType_id"].'" rel="'.$re["incType_other_flag"].'">'.$incType_name.'</option>';
      }
    }

    $formSet_html .= '</select>
    </div>
  </div>
  <div class="row div_category_invite" id="prodType_other" style="display:none;">';
  if($lang == "1"){ $top_form5s = "โปรดระบุ";}elseif($lang == "2"){ $top_form5s = "Please specify";}else{ $top_form5s = "โปรดระบุ";}
    $formSet_html .='<div class="col-md-3">'.$top_form5s.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4"><input type="text" class="form-control prodType_other" name="incType_other_IdxFs_'.$formSetId.'" value="'.$_POST['incType_other'].'"></div>
    </div>
  <div class="row div_history_invite">';
  if($lang == "1"){ $hoc_form5 = "ความเป็นมาของประเด็นเรื่องร้องเรียน";}elseif($lang == "2"){ $hoc_form5 = "Background information of the petition";}else{ $hoc_form5 = "ความเป็นมาของประเด็นเรื่องร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$hoc_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="caseDtl_derivation_IdxFs_'.$formSetId.'" rows="4" class="form-control caseDtl_derivation"></textarea></div>
  </div>
  <div class="row div_charge_invite">';
  if($lang == "1"){ $dv_form5 = "มูลค่าความเสียหาย (ระบุเป็นตัวเลข)";}elseif($lang == "2"){ $dv_form5 = "Damage (in number and unit)";}else{ $dv_form5 = "มูลค่าความเสียหาย (ระบุเป็นตัวเลข)";}
    $formSet_html .='<div class="col-md-3">'.$dv_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
      <input type="number" name="caseDtl_damage_val_IdxFs_'.$formSetId.'" class="form-control txt_input_charge_invite" value="0">';
      if(count($this->case_currency)==0){
        $this->case_currency = $this->currencyList();
      }
      $formSet_html .='<select name="curren_id_IdxFs_'.$formSetId.'" class=" selectpicker form-control sel_charge_invite">';
      foreach($this->case_currency as $case_currency){
        $formSet_html .= '<option value="'.$case_currency["curren_id"].'">'.$case_currency["curren_name"].'</option>';
      }
      $formSet_html .= '</select>
    </div>
  </div>
  <div class="row div_demand_invite">';
  if($lang == "1"){ $cn_form5 = "ความต้องการของผู้ร้องเรียน";}elseif($lang == "2"){ $cn_form5 = "Petitioner’s requirement";}else{ $cn_form5 = "ความต้องการของผู้ร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$cn_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="caseDtl_complnt_need_IdxFs_'.$formSetId.'" rows="4" class="form-control caseDtl_complnt_need"></textarea></div>
  </div>
  <div class="row div_file_invite">';
  if($lang == "1"){ $acd_form5 = "แนบเอกสารประกอบการร้องเรียน";}elseif($lang == "2"){ $acd_form5 = "Attached documentation for petition";}else{ $acd_form5 = "แนบเอกสารประกอบการร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$acd_form5.'</div>
    <div class="col-md-9 fileinput">
    <span class="fileinput-filename" id="fileinput-filename" style="display:none;"></span>
    <input type="hidden" class="fileinput_file" name="fileinput_file">
    <input type="hidden" class="fileinput_file_remove" name="fileinput_file_remove">
    <input type="file" class="form-control file_box" name="file_invite[]" multiple><button type="button" class="btn btn-default btn_browse_file">Browse</button>';
    if($lang == "1"){ $acda_form5 = "สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์";}elseif($lang == "2"){ $acda_form5 = "5 files maximum per turn, with file size limit of 50 mb each";}else{ $acda_form5 = "สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์";}
    $formSet_html .='<div class="txt_comment_file">* '.$acda_form5.'</div>
    </div>
      <div class="col-md-3"></div>
    <div class="col-md-9 panel_caseAttach_file">';

              $i=0;
              if(isset($_GET["method"]) && $_GET["method"]=="editcase"){
                foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
                  if($rs_case["case"]["applnt_type"]!=0){
                    $name_sender = $rs_case["case_feild"]["applntOrg_name"];
                  }else{
                    $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
                  }
                  $formSet_html .= '<div class="panel" id="panel_caseAttach_file_'.$i.'">
                      <div class="panel-body panel-body-list-file">
                          <ul class="list-file col-sm-12">
                          <li class="no-gutter">
                              <div class="col-xs-12 col-sm-1">
                                <i class="glyph-icon icon-file-pdf-o icon-thumb-file"></i>
                              </div>
                              <div class="col-xs-12 col-sm-6 list_file_name" >
                                <input type="text" name="caseAttach_file_name['.$i.']" value="'.$case_Attachfile["caseAttach_title"].'" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />
                                <input type="hidden" name="caseAttach_file_id['.$i.']" value="'.$case_Attachfile["caseAttach_id"].'"  />
                                <p>'.$case_Attachfile["caseAttach_file_oldname"].'</p>
                              </div>
                              <div class="col-xs-12 col-sm-3">
                                <p>Date : '.date('d/m/Y',strtotime($case_Attachfile["caseAttach_create_datetime"])).'</p>
                                <p class="text_small">Sender : '.$name_sender.'</p>
                              </div>
                              <div class="col-xs-12 col-sm-2 col-btn-file">
                                <button type="button" class="btn btn-round btn-bg22 btn-edit-file" onclick="window.open(\'view_file_attach.php?fileadrss='.$case_Attachfile["caseAttach_id"].'\')">
                                  <i class="my-icon icon-ico-ditp-22"></i>
                                </button>
                                <button type="button" class="btn btn-round btn-danger btn-del-file" onclick="case_open.remove_file(\'panel_caseAttach_file_'.$i.'\','.$case_Attachfile["caseAttach_id"].');">
                                  <i class="my-icon icon-ico-ditp-28"></i>
                                </button>
                              </div>
                          </li>
                          </ul>
                      </div>
                  </div>';
                    $i++;
                }
              }
      $formSet_html .= '</div>
    </div>
  <input type="hidden" name="formSetId_c" value="'.$formSetId.'" >';

$formSet_html .='</div>';
}elseif ($_GET['page'] == "invite_edit") {
$formSet_html = '<div class="panel-heading hr_invite_panel">
  <span><img src="images/all_icon_DITP/icon-18.svg" style="width:30px;"></span>';
  if($_POST["rdi_compTypeSub1"] == ""){ $rdi_compTypeSub1 = 0;}else{ $rdi_compTypeSub1 = $_POST["rdi_compTypeSub1"];}

  $sql_namefrom = "SELECT * FROM Form_Link_Complaint_Type WHERE compType_id = '".$_POST["rdi_compType_id"]."' AND compTypeSub1_id = '".$rdi_compTypeSub1."'  AND frmset_id = '$formSetId'";
  $query_namefrom = $this->dbConn->query($sql_namefrom);
  $res = $query_namefrom->fetch_assoc();
  if($lang == "1"){ $hr_form1_txt = $res['frmset_name'];}elseif($lang == "2"){ $hr_form1_txt = $res['frmset_name_en'];}else{ $hr_form1_txt = $res['frmset_name'];}
  $formSet_html .='<span class="hr_input_detail">'.$hr_form1_txt.'</span>
</div>

<div class="panel-body">';

  $formSet_html .= '<div class="row div_complaint_invite">';
  if($lang == "1"){ $top_form5 = "หัวข้อเรื่องร้องเรียน";}elseif($lang == "2"){ $top_form5 = "Petition topic";}else{ $top_form5 = "หัวข้อเรื่องร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$top_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><input type="text" class="form-control caseDtl_title" name="caseDtl_title_IdxFs_'.$formSetId.'" value="'.$_POST['caseDtl_title'].'"></div>
  </div>
  <div class="row div_category_invite">';
  if($lang == "1"){ $Category_form5 = "ประเภทความผิด";}elseif($lang == "2"){ $Category_form5 = "Type of complaint";}else{ $Category_form5 = "ประเภทความผิด";}
    $formSet_html .='<div class="col-md-3">'.$Category_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
      <select name="incType_id_IdxFs_'.$formSetId.'" id="sel_category_invite" class="selectpicker form-control sel_category_invite" onchange="chk_prod();">
      <option value="">';
      if($lang == "1"){ $Chft_form5 = "เลือกประเภทความผิด";}elseif($lang == "2"){ $Chft_form5 = "Please choose type of complaint";}else{ $Chft_form5 = "เลือกประเภทความผิด";}
        $formSet_html .='--- '.$Chft_form5.' ---</option>';

      $sql = "SELECT * FROM `Incorrect_Type`";
      $query = $this->dbConn->query($sql);
      if($query->num_rows > 0){
        while ($re = $query->fetch_assoc()) {
          if($lang == "2"){
            $incType_name = $re["incType_name_en"];
          }else {
            $incType_name = $re["incType_name"];
          }
      $formSet_html .= '<option value="'.$re["incType_id"].'" '.($_POST["incType_id"]==$re["incType_id"]?'selected':'').' rel="'.$re["incType_other_flag"].'">'.$incType_name.'</option>';
        }
      }
    $formSet_html .= '</select>
    </div>
  </div>
  <div class="row div_category_invite" id="prodType_other" style="display:none;">';
  if($lang == "1"){ $top_form5s = "โปรดระบุ";}elseif($lang == "2"){ $top_form5s = "Please specify";}else{ $top_form5s = "โปรดระบุ";}
    $formSet_html .='<div class="col-md-3">'.$top_form5s.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-4"><input type="text" class="form-control prodType_other" name="incType_other_IdxFs_'.$formSetId.'" value="'.$_POST['incType_other'].'"></div>
    </div>
  <div class="row div_history_invite">';
  if($lang == "1"){ $hoc_form5 = "ความเป็นมาของประเด็นเรื่องร้องเรียน";}elseif($lang == "2"){ $hoc_form5 = "Background information of the petition";}else{ $hoc_form5 = "ความเป็นมาของประเด็นเรื่องร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$hoc_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="caseDtl_derivation_IdxFs_'.$formSetId.'" rows="4" class="form-control caseDtl_derivation">'.$_POST['caseDtl_derivation'].'</textarea></div>
  </div>
  <div class="row div_charge_invite">';
  if($lang == "1"){ $dv_form5 = "มูลค่าความเสียหาย (ระบุเป็นตัวเลข)";}elseif($lang == "2"){ $dv_form5 = "Damage (in number and unit)";}else{ $dv_form5 = "มูลค่าความเสียหาย (ระบุเป็นตัวเลข)";}
    $formSet_html .='<div class="col-md-3">'.$dv_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9">
      <input type="number" name="caseDtl_damage_val_IdxFs_'.$formSetId.'" class="form-control txt_input_charge_invite" value="'.$_POST['caseDtl_damage_val'].'">';
      if(count($this->case_currency)==0){
        $this->case_currency = $this->currencyList();
      }
      $formSet_html .='<select name="curren_id_IdxFs_'.$formSetId.'" class=" selectpicker form-control sel_charge_invite">';
      foreach($this->case_currency as $case_currency){
        $formSet_html .= '<option value="'.$case_currency["curren_id"].'" '.($_POST["curren_id"]==$case_currency["curren_id"]?'selected':'').'>'.$case_currency["curren_name"].'</option>';
      }
      $formSet_html .= '</select>
    </div>
  </div>
  <div class="row div_demand_invite">';
  if($lang == "1"){ $cn_form5 = "ความต้องการของผู้ร้องเรียน";}elseif($lang == "2"){ $cn_form5 = "Petitioner’s requirement";}else{ $cn_form5 = "ความต้องการของผู้ร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$cn_form5.'<span style="color:#E74C3C;">*</span></div>
    <div class="col-md-9"><textarea name="caseDtl_complnt_need_IdxFs_'.$formSetId.'" rows="4" class="form-control caseDtl_complnt_need">'.$_POST['caseDtl_complnt_need'].'</textarea></div>
  </div>
  <div class="row div_file_invite">';
  if($lang == "1"){ $acd_form5 = "แนบเอกสารประกอบการร้องเรียน";}elseif($lang == "2"){ $acd_form5 = "Attached documentation for petition";}else{ $acd_form5 = "แนบเอกสารประกอบการร้องเรียน";}
    $formSet_html .='<div class="col-md-3">'.$acd_form5.'</div>
    <div class="col-md-9 fileinput">
    <span class="fileinput-filename" id="fileinput-filename" style="display:none;"></span>
    <input type="hidden" class="fileinput_file" name="fileinput_file" value="'.$_POST['fileinput_file'].'">
    <input type="hidden" class="fileinput_file_remove" name="fileinput_file_remove">
    <input type="file" class="form-control file_box" name="file_invite[]" multiple><button type="button" class="btn btn-default btn_browse_file">Browse</button>';
    if($lang == "1"){ $acda_form5 = "สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์";}elseif($lang == "2"){ $acda_form5 = "5 files maximum per turn, with file size limit of 50 mb each";}else{ $acda_form5 = "สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์";}

    $formSet_html .='<div class="txt_comment_file">* '.$acda_form5.'</div>
    </div>
      <div class="col-md-3"></div>
    <div class="col-md-9 panel_caseAttach_file">';
    $sn = "";
    $i = 0;
    $a= 0;
    $value_name_arr = array();
    foreach ($_POST['caseAttach_file_name'] as $value_name) {
    $value_name_arr[$a] = $value_name;
    $a++;
    }
    foreach (glob("../data/case_attach_tmp/".$_SESSION['member_id']."/*.*") as $sn) {
      $sn_ex = explode("/",$sn);
      $sn_type = explode(".",$sn_ex[4]);
              $formSet_html .='<div class="panel-body panel-body-list-file" id="panel_caseAttach_file_'.$i.'" style="margin-top: 20px;">
                            <ul class="list-file col-sm-12">
                            <li class="no-gutter">
                                <div class="col-xs-12 col-sm-1">';
                                if($sn_type[1] == "jpeg" || $sn_type[1] == "jpg" || $sn_type[1] == "png"){
                $formSet_html .='<i class="fa fa-file-image-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }elseif ($sn_type[1] == "pdf") {
                $formSet_html .='<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:45px;"></i>';
                                 }elseif ($sn_type[1] == "docx") {
                $formSet_html .='<i class="fa fa-file-word-o" aria-hidden="true" style="font-size:45px;"></i>';
                                  }elseif ($sn_type[1] == "ppt") {
                $formSet_html .='<i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size:45px;"></i>';
                                  }elseif ($sn_type[1] == "xlsx" || $sn_type[1] == "xls") {
                $formSet_html .='<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:45px;"></i>';
                                    }
                $formSet_html .='</div>
                                <div class="col-xs-12 col-sm-6 list_file_name" >
                                  <input type="text" name="caseAttach_file_name['.$i.']" value="'.$value_name_arr[$i].'" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />
                                  <p>'.$sn_type[0].".".$sn_type[1].'</p>
                                  <input type="hidden" name="new_fileadrss[]" id="new_fileadrss'.$i.'" value="'.$sn_type[0].".".$sn_type[1].'" />
                                </div>
                                <div class="col-xs-12 col-sm-3">
                                  <p>Date : '.date('d/m/Y').'</p>
                                </div>
                                <div class="col-xs-12 col-sm-2 col-btn-file" style="text-align:right;">
                                <span class="icon_del"><a onclick="del_file_invite_edit('.$i.');"><img src="images/icon_delete.png" style="margin-top:18px;"></a></span>
                                </div>
                            </li>
                            </ul>
                    </div>';
                    $i++;
            }


      $formSet_html .= '</div>
    </div>
  <input type="hidden" name="formSetId_c" value="'.$formSetId.'" >';

$formSet_html .='</div>';
}
?>
