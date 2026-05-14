<?php
include('../class/case.class.php');
$caseOpn_cls = new case_open();
$member = $caseOpn_cls->memberData($rs_case["case"]["case_createBy_id"]);
$country_name = $caseOpn_cls->CountryData_List($member[0]['country_id']);
?>
    <!-- <pre>
      <?php print_r($country_name)?>
    </pre> -->
<?php

// echo json_encode($rs_case["case_feild"]["applnt_mobile"]);

if($member[0]['member_type'] == '0'){
  $position = $member[0]['member_occupation'];
  $txt_positon = 'อาชีพ';
}
else{
  $position = $member[0]['member_position'];
  $txt_positon = 'ตำแหน่ง6666';
}

if($typeformset=="case_open"){
  $formSet_html = '
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-sm-12 no-gutter" style="border-bottom:1px solid #e6e6e6;margin-bottom:20px;">

          <h3 class="title-hero col-sm-6" style="border-bottom:none; margin-bottom:0;">
              <span class="glyph-icon icon-user" aria-hidden="true"></span>
              ข้อมูลส่วนที่ '.$formSetNo.' | '.$formSetName.'
          </h3>
          <div class="title-hero panel-nav-right col-sm-6" style="border-bottom:none; margin-bottom:0;">
            
          </div>

        </div>
      </div>
    </div>';
    // if (in_array($_SESSION['admin']['empId'], array('1', '7')) === FALSE) {
    // $formSet_html .= '
    // <div class="form-group col-md-12">
    //   <label class="col-sm-2 control-label">เลขบัตรประชาชน</label>
    //   <div class="col-sm-4">
    //     <input type="text" value="'.$rs_case["case_feild"]["applnt_ident"].'" class="form-control input-mask" name="applnt_ident_IdxFs_'.$formSetId.'" id="applnt_ident_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-99-9&apos;"  />
    //     <input type="hidden" name="applnt_ident_valid_IdxFs_'.$formSetId.'" id="applnt_ident_valid_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid"].'">
    //     <input type="hidden" name="applnt_ident_valid_note_IdxFs_'.$formSetId.'" id="check_people_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid_note"].'">
    //   </div>
    // </div>
    // <div class="form-group col-md-12">
    //   <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
    //   <div class="col-sm-4">
    //     <select class="custom-select" name="applnt_title_IdxFs_'.$formSetId.'">
    //       <option value="" >
    //         --- เลือกคำนำหน้าชื่อ ---
    //       </option>
    //       <option value="Mr." '.($rs_case["case_feild"]["applnt_title"]=='Mr.'?'selected':'').'> Mr. </option>
    //       <option value="Mrs." '.($rs_case["case_feild"]["applnt_title"]=='Mrs.'?'selected':'').'> Mrs. </option>
    //       <option value="Ms." '.($rs_case["case_feild"]["applnt_title"]=='Ms.'?'selected':'').'> Ms. </option>
    //     </select>
    //   </div>
    // </div>
    // <div class="form-group col-md-12">
    //   <label class="col-sm-2 control-label required">ชื่อ</label>
    //   <div class="col-sm-10">
    //     <input type="text" value="'.$rs_case["case_feild"]["applnt_firstname"].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'" data-toggle="tooltip" data-placement="bottom" data-html="true" title=""  />
    //   </div>
    // </div>
    // <div class="form-group col-md-12">
    //   <label class="col-sm-2 control-label required">นามสกุล</label>
    //   <div class="col-sm-10">
    //     <input type="text" value="'.$rs_case["case_feild"]["applnt_lastname"].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
    //   </div>
    // </div>';
    // } 
    // else {
      $formSet_html .= '
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label">เลขบัตรประชาชน</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_ident"].'" class="form-control input-mask" name="applnt_ident_IdxFs_'.$formSetId.'" id="applnt_ident_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-99-9&apos;"  />
        <input type="hidden" name="applnt_ident_valid_IdxFs_'.$formSetId.'" id="applnt_ident_valid_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid"].'">
        <input type="hidden" name="applnt_ident_valid_note_IdxFs_'.$formSetId.'" id="check_people_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid_note"].'">
      </div>
      <div class="col-sm-6 applnt_ident" id="div_applnt_ident_1">
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
      <div class="col-sm-4">
        <select class="custom-select" name="applnt_title_IdxFs_'.$formSetId.'">
          <option value="" >
            --- เลือกคำนำหน้าชื่อ ---
          </option>
          <option value="Mr." '.($rs_case["case_feild"]["applnt_title"]=='Mr.'?'selected':'').'> Mr. </option>
          <option value="Mrs." '.($rs_case["case_feild"]["applnt_title"]=='Mrs.'?'selected':'').'> Mrs. </option>
          <option value="Ms." '.($rs_case["case_feild"]["applnt_title"]=='Ms.'?'selected':'').'> Ms. </option>
        </select>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">ชื่อ</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_firstname"].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'" data-toggle="tooltip" data-placement="bottom" data-html="true" title=""  />
      </div>
      <label class="col-sm-2 control-label control-label-r required">นามสกุล</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_lastname"].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
      </div>
    </div>';
    // }
    $formSet_html .= '
    <div class="form-group col-md-12">
      
      <label class="col-sm-2 control-label">ประเภทธุรกิจ</label>
      <div class="col-sm-4">


      <select class="custom-select" name="applnt_import_export_IdxFs_'.$formSetId.'">
      <option value="">
        อื่นๆ
      </option>
      <option value="1" '.($rs_case["case_feild"]["applnt_import_export"]=="1"?"selected":"").'>
        บริษัทนำเข้า
      </option>
      <option value="2" '.($rs_case["case_feild"]["applnt_import_export"]=="2"?"selected":"").'>
        บริษัทส่งออก
      </option>
    </select>
      </div>
    </div>';
  // if (in_array($_SESSION['admin']['empId'], array('1', '7')) === FALSE) {
  //   $formSet_html .= '
  //   <div class="form-group col-md-12">
  //     <label class="col-sm-2 control-label">ตำแหน่ง</label>
  //     <div class="col-sm-4">
  //       <input type="text" value="'.$rs_case["case_feild"]["applntOrg_position"].'"  class="form-control" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
  //     </div>
  //     <label class="col-sm-2 control-label control-label-r required">E-Mail</label>
  //     <div class="col-sm-4">
  //       <input type="email" value="'.$rs_case["case_feild"]["applnt_email"].'" class="form-control" name="applnt_email_IdxFs_'.$formSetId.'"  />
  //     </div>
  //   </div>
  //   <div class="form-group col-md-12">
  //     <label class="col-sm-2 control-label required">เบอร์บริษัท/ที่ทำงาน</label>
  //     <div class="col-sm-4">
  //       <input type="number" value="'.$rs_case["case_feild"]["applnt_tel"].'" class="form-control tel_format tel_format" name="applnt_tel_IdxFs_'.$formSetId.'"  />
  //     </div>
  //     <label class="col-sm-2 control-label control-label-r required">เบอร์โทรศัพท์มือถือ</label>
  //     <div class="col-sm-4">
  //     <div id="tel1"> 
  //       <input type="text" value="'.$rs_case["case_feild"]["applnt_mobile"].'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'" class="form-control input-mask phone-number" name="applnt_mobile_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;"  />
  //       <input type="hidden" name="applnt_mobile_country">
  //       <input type="hidden" name="applnt_mobile_code">
  //     </div>
  //     </div>
  //   </div>';
  // }
  // else if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
    $formSet_html .= '
    <div class="form-group col-md-12">
      <!-- applnt_email_IdxFs_{form_id} -->
      <label class="col-sm-2 control-label required">E-Mail</label>
      <div class="col-sm-4">
        <input type="email" value="'.$rs_case["case_feild"]["applnt_email"].'" class="form-control" name="applnt_email_IdxFs_'.$formSetId.'" />
      </div>
      <div class="col-sm-6 applnt_email" id="div_applnt_email_1">
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">เบอร์โทรศัพท์มือถือ</label>
      <div class="col-sm-4 flex-container">
        <div class="flex2" id="tel1">
          <input type="number" value="'.($rs_case["case_feild"]["applnt_tel"]!=""?$rs_case["case_feild"]["applnt_tel"]:$rs_case["case_feild"]["applnt_mobile"]).'" data-code="'.$rs_case["case_feild"]["applnt_mobile_country"].'"  class="form-control input-mask phone-number-info" name="applnt_mobile_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;" />
          <input type="hidden" name="applnt_mobile_country" value="'.$rs_case["case_feild"]["applnt_mobile_country"].'">
          <input type="hidden" name="applnt_mobile_code" value="'.$rs_case["case_feild"]["applnt_mobile_code"].'">
        </div>
      </div>
       <div class="col-sm-6 applnt_mobile" id="div_applnt_mobile_1">
      </div>
    </div>';
  // }
  $formSet_html .= '
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">ที่อยู่ติดต่อ</label>
      <div class="col-sm-10">
        <textarea name="applnt_address_IdxFs_'.$formSetId.'" rows="3" class="form-control textarea-no-resize">'.$rs_case["case_feild"]["applnt_address"].'</textarea>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">จังหวัด</label>
      <div class="col-sm-4">
          <select name="applnt_prov_id_IdxFs_'.$formSetId.'" class="form-control select-picker" data-live-search="true">
            <option value="" style="color:#777">
             --- เลือกจังหวัด ---
            </option>
            '.$provinceList_pers.'
          </select>
      </div>
      <label class="col-sm-2 control-label control-label-r ">รหัสไปรษณีย์</label>
      
      
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_zipcode"].'" class="form-control input-mask" name="applnt_zipcode_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;99999&apos;"  />
         
      </div>
    </div>
    <input type="hidden" name="applnt_country_id_IdxFs_'.$formSetId.'" value="162" />
  </div>
  <div class="panel-body panel-body-outer-bg2">
    <div class="col-md-12 panel-body-bg2 no-gutter">
      <div class="form-group col-md-12 no-gutter">
        <div class="col-sm-6">
          <div class="checkbox checkbox-primary">
            <label>
              <input value="1" type="checkbox" id="inlineCheckbox_chkType_IdxFs_'.$formSetId.'" class="custom-checkbox checkbox-company" name="applnt_chkType_IdxFs_'.$formSetId.'" onclick="case_open.chkHasCompany(this.id,\''.$formSetId.'\');" '.(( !empty($rs_case["case"]["applnt_type"]) && $rs_case["case"]["applnt_type"] == '1' )?'checked="checked"':'').' >
              <select class="select-complnt-type custom-select applnt_type_IdxFs_'.$formSetId.'" name="applnt_type_IdxFs_'.$formSetId.'" '.(( ( empty($rs_case["case"]["applnt_type"]) || $rs_case["case"]["applnt_type"] != '1' ) )?'disabled="disabled"':'').'>
                <option data-rel="บริษัท" value="1">เป็นตัวแทนบริษัท</option>
                <!-- <option data-rel="องค์กร" value="2" '.($rs_case["case_feild"]["applnt_type"]==2?'selected':'').'>เป็นตัวแทนองค์กร</option> -->
              </select>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group-inner no-gutter " id="form_group_company_'.$formSetId.'" '.(( empty($rs_case["case"]["applnt_type"]) || $rs_case["case"]["applnt_type"] != 1 )?'style="display:none"':'').'>
        <h3 class="title-hero col-md-12">
            <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
            <span class="applnt_type_change">'.(( empty($rs_case["case"]["applnt_type"]) || $rs_case["case"]["applnt_type"] == 1 ) ?'ข้อมูลบริษัท':'ข้อมูลองค์กร').'</span>
        </h3>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label">เลขนิติบุคคล</label>
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_trade_number"].'" class="form-control applntOrg_trade_number" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" id="applntOrg_trade_number_IdxFs_'.$formSetId.'" " />
          </div>
          <div class="col-sm-6 applntOrg_trade_number" id="div_applntOrg_trade_number_1" >
            <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'dbd\',\'#form_group_company_'.$formSetId.' #applntOrg_trade_number_IdxFs_'.$formSetId.'\',\'applnt\');"><img class="check_dbd_logo" id="check_dbd_logo_IdxFs_'.$formSetId.'" src="img/new_logo_dbd/btn_check_dbd_'.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?$rs_case["case_feild"]["applnt_valid_dbd"]:"0").'.png" /></button>
            <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'ditp\',\'#form_group_company_'.$formSetId.' #applntOrg_trade_number_IdxFs_'.$formSetId.'\',\'applnt\');"><img class="check_ditp_logo" id="check_ditp_logo_IdxFs_'.$formSetId.'" src="'.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?($rs_case["case_feild"]["applnt_valid_ditp"]=="1"?"img/logo_ditp/btn-ditp-".$rs_case["case_feild"]["applnt_valid_ditp_org"]:"img/logo_ditp/btn_check_ditp_".$rs_case["case_feild"]["applnt_valid_ditp"]):"img/logo_ditp/btn_check_ditp_0").'.png" /></button>
            <input type="hidden" class="val_applnt_valid_dbd" name="applnt_valid_dbd_IdxFs_'.$formSetId.'" id="applnt_valid_dbd_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_dbd"].'">
            <input type="hidden" class="val_applnt_valid_dbd_note" name="applnt_valid_dbd_note_IdxFs_'.$formSetId.'" id="check_dbd_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_dbd_note"].'">
            <input type="hidden" class="val_applnt_valid_ditp" name="applnt_valid_ditp_IdxFs_'.$formSetId.'" id="applnt_valid_ditp_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp"].'">
            <input type="hidden" class="val_applnt_valid_ditp_org" name="applnt_valid_ditp_org_IdxFs_'.$formSetId.'" id="applnt_valid_ditp_org_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp_org"].'">
            <input type="hidden" class="val_applnt_valid_ditp_note" name="applnt_valid_ditp_note_IdxFs_'.$formSetId.'" id="check_ditp_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp_note"].'">
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">ชื่อบริษัทที่จดทะเบียน</label>
          <div class="col-sm-6">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_name"].'" class="form-control" name="applntOrg_name_IdxFs_'.$formSetId.'"  />
          </div>
          <div class="col-sm-4 applntOrg_name" id="div_applntOrg_name_1">
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">ประเภทธุรกิจ</label>
          <div class="col-sm-4">
            <select class="custom-select" name="applntOrg_import_export_IdxFs_'.$formSetId.'">
              <option value="">
                อื่นๆ
              </option>
              <option value="1" '.($rs_case["case_feild"]["applntOrg_import_export"]=="1"?"selected":"").'>
                บริษัทนำเข้า
              </option>
              <option value="2" '.($rs_case["case_feild"]["applntOrg_import_export"]=="2"?"selected":"").'>
                บริษัทส่งออก
              </option>
            </select>
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label">สาขา</label>
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_branch"].'"  class="form-control" name="applntOrg_branch_IdxFs_'.$formSetId.'"  />
          </div>
          <label class="col-sm-2 control-label control-label-r">ตำแหน่ง </label>
          <div class="col-sm-4">
            <input type="text" value=""  class="form-control" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">เบอร์โทรศัพท์</label>
          <div class="col-sm-4 flex-container">
            <div class="flex2" id="tel2">
              <input type="number" value="'.$rs_case["case_feild"]["applntOrg_tel"].'" data-code="'.$rs_case["case_feild"]["applntOrg_mobile_country"].'"  class="form-control input-mask phone-number" name="applntOrg_tel_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;" />
              <input type="hidden" name="applntOrg_mobile_country" value="'.$rs_case["case_feild"]["applntOrg_mobile_country"].'">
              <input type="hidden" name="applntOrg_mobile_code" value="'.$rs_case["case_feild"]["applntOrg_mobile_code"].'">
            </div>
          </div>
          <div class="col-sm-6 applntOrg_tel" id="div_applntOrg_tel_1">
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label ">เว็บไซต์</label>
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_web"].'"  class="form-control" name="applntOrg_web_IdxFs_'.$formSetId.'"  />
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">ที่อยู่ติดต่อ</label>
          <div class="col-sm-10">
            <textarea name="applntOrg_address_IdxFs_'.$formSetId.'" rows="3" class="form-control textarea-no-resize">'.$rs_case["case_feild"]["applntOrg_address"].'</textarea>
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">จังหวัด</label>
          <div class="col-sm-4">
              <select name="applntOrg_prov_id_IdxFs_'.$formSetId.'" class="form-control select-picker" data-live-search="true">
                <option value="" style="color:#777">
                 --- เลือกจังหวัด ---
                </option>
                '.$provinceList_org.'
              </select>
          </div>
          <label class="col-sm-2 control-label control-label-r ">รหัสไปรษณีย์</label>
           
          
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_zipcode"].'" class="form-control input-mask" name="applntOrg_zipcode_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;99999&apos;"  />
          </div>
        </div>
      </div>

      <div class="form-group col-md-12 no-gutter">
        <div class="col-sm-6">
          <div class="checkbox checkbox-primary">
            <label>
              <input value="2" type="checkbox"  id="zinlineCheckbox_chkType_IdxFs_'.$formSetId.'" name="applnt_chkType_IdxFs_'.$formSetId.'" class="custom-checkbox checkbox-company" onclick="case_open.chkHasPersonal(this.id,\''.$formSetId.'\');" '.(( !empty($rs_case["case"]["applnt_type"]) && $rs_case["case"]["applnt_type"] == '2' )?'checked="checked"':'').'>
              <select class="select-complnt-type custom-select applnt_type_IdxFs_'.$formSetId.'" name="applnt_type_IdxFs_'.$formSetId.'" '.(( empty($rs_case["case"]["applnt_type"]) || $rs_case["case"]["applnt_type"] != '2' )?'disabled="disabled"':'').'>
                <option data-rel="บริษัท" value="2" >ยื่นเรื่องในนามบุคคลธรรมดา</option>
              </select>
            </label>
            <p style="color: red;">(หากท่านเลือกยื่นเรื่องในนามบุคคลธรรมดา กระบวนการตรวจสอบจะใช้เวลานานกว่าปกติ)</p> 
          </div>
        </div>
      </div>';
  // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
    $formSet_html .= '
      <div class="form-group-inner no-gutter " id="form_group_personal_'.$formSetId.'" '.(( empty($rs_case["case"]["applnt_type"]) || $rs_case["case"]["applnt_type"] != '2' )?'style="display:none"':'').'>
        <h3 class="title-hero col-md-12">
            <span class="glyph-icon icon-user" aria-hidden="true"></span>
            ข้อมูลบุคคล
        </h3>
        <div class="form-group col-md-12">
          <!-- applntOrg_position_IdxFs_{form_id} -->
          <label class="col-sm-2 control-label">อาชีพ</label>
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applnt_career"].'"  class="form-control" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
          </div>
        </div>
      </div>';
  // }
          
  $formSet_html .= '
    </div>
  </div>
  <input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';
}else if($typeformset=="case_open_detail"){

  if(strlen($rs_case["case_feild"]["applnt_tel"]) == 10 || strlen($rs_case["case_feild"]["applnt_mobile_code"]) == 10) {
    if($rs_case["case_feild"]["applnt_tel"] != '') {
      $telNo = $rs_case["case_feild"]["applnt_tel"];
    } else {
      $telNo = $rs_case["case_feild"]["applnt_mobile_code"];
    }
    $str1 = substr($telNo, 1, 2);
    $str2 = substr($telNo, 3, 3);
    $str3 = substr($telNo, 6);
    $telFM = $rs_case["case_feild"]["applnt_mobile_code"].$str1.'-'.$str2.'-'.$str3;
  } else {
    if($rs_case["case_feild"]["applnt_tel"] != '') {
      $telFM = $rs_case["case_feild"]["applnt_mobile_code"].substr($rs_case["case_feild"]["applnt_tel"],1);
    } else {
      $telFM = $rs_case["case_feild"]["applnt_mobile_code"].substr($rs_case["case_feild"]["applnt_mobile"],1);
    }
  }

  if ($data_bw["cnt"] == 3) {
    $icon_cnt = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cnt"] == 2){
    $icon_cnt = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cnt"] ==1){
    $icon_cnt = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cnt ='';
  }
  if ($data_bw["ae"] == 3) {
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ae"] == 2){
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ae"] ==1){
    $icon_ae = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ae ='';
  }
  if ($data_bw["at"] == 3) {
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["at"] == 2){
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["at"] ==1){
    $icon_at = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_at ='';
  }
  
  if ($data_bw["ctn"] == 3) {
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctn"] == 2){
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctn"] ==1){
    $icon_ctn = '<div class="icon-container-wl">
                    <i class="ico-wl" ></i>
                    <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['watchlist'].'</span>
                  </div>';
  }else{
    $icon_ctn ='';
  }
  
  if ($data_bw["cn"] == 3) {
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cn"] == 2){
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cn"] ==1){
    $icon_cn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cn ='';
  }
  
  if ($data_bw["ctp"] == 3) {
    $icon_ctp = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctp"] == 2){
    $icon_ctp = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctp"] ==1){
    $icon_ctp = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ctp ='';
  }

  if ($data_bw["fl"] == 3) {
    $icon_fl = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['watchlist'].'</span>
                </div>';
  }else if($data_bw["fl"] == 2){
    $icon_fl = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["fl"] ==1){
    $icon_fl = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['watchlist'].'</span>
                </div>';
  }else{
    $icon_fl ='';
  }
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
            <span>ข้อมูลผู้ร้องเรียน</span>
            <a class="btn btn-round btn-border btn-alt border-black btn-link font-black btn-collape" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                <i class="glyph-icon icon-angle-up"></i>
            </a>
        </h3>
      </div>
    </div>

    <div id="collapse1" class="collapse in"  aria-labelledby="headingOne">
      <div class="form-group col-sm-10">
        <span class="glyph-icon icon-user" aria-hidden="true"></span>
        <label class="text-data font-bold">'.$rs_case["case_feild"]["applnt_title"].' '.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'</label>
        '.$icon_fl.'
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขบัตรประชาชน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'</label>
          '.($rs_case["case_feild"]["applnt_ident_valid"]=="1"?'<img class="ico_validate" src="img/icon_people_1.png" />':'').'
          '.$icon_cnt.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_email"]!=""?$rs_case["case_feild"]["applnt_email"]:"-").'</label>
          '.$icon_ae.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์มือถือ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_at.'
        </div>
      </div>
      

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_address"]!=""?$rs_case["case_feild"]["applnt_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_zipcode"]!=""?$rs_case["case_feild"]["applnt_zipcode"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_country_id"]!=""?$countryList[$rs_case["case_feild"]["applnt_country_id"]]:"-").'</label>
        </div>
      </div>';

    if($rs_case["case_feild"]["applnt_type"] == 1){

      if(strlen($rs_case["case_feild"]["applntOrg_tel"]) == 10) {
        $telNo = $rs_case["case_feild"]["applntOrg_tel"];

        $str1 = substr($telNo, 1, 2);
        $str2 = substr($telNo, 3, 3);
        $str3 = substr($telNo, 6);
        $telFM = $rs_case["case_feild"]["applntOrg_mobile_code"].$str1.'-'.$str2.'-'.$str3;
      } else {
        if($rs_case["case_feild"]["applntOrg_tel"] != '') {
          $telFM = $rs_case["case_feild"]["applntOrg_mobile_code"].substr($rs_case["case_feild"]["applntOrg_tel"],1);
        } else {
          $telFM = '-';
        }
      }

      $formSet_html .= '<!-- เป็นตัวแทนบริษัท -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data">เป็นตัวแทนบริษัท</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.($rs_case["case_feild"]["applnt_valid_ditp"]!="2"?$rs_case["case_feild"]["applnt_valid_ditp_org"]:($rs_case["case_feild"]["applnt_valid_ditp_org"]=="non member"?"non-member":$rs_case["case_feild"]["applnt_valid_ditp"])).'.png" />':'').'

      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_trade_number"]!=""?$rs_case["case_feild"]["applntOrg_trade_number"]:"-").'</label>
          '.$icon_ctn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ชื่อบริษัทที่จดทะเบียน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_name"]!=""?$rs_case["case_feild"]["applntOrg_name"]:"-").'</label>
          '.$icon_cn.'  
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเภทธุรกิจ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$applntOrg_import_export.'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">สาขา</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_branch"]!=""?$rs_case["case_feild"]["applntOrg_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ตำแหน่ง</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_position"]!=""?$rs_case["case_feild"]["applntOrg_position"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_ctp.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เว็บไซต์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_web"]!=""?$rs_case["case_feild"]["applntOrg_web"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_address"]!=""?$rs_case["case_feild"]["applntOrg_address"]:"-").'</label>
        </div>
      </div>

      <!--<div class="form-group col-md-12">-->
      <!--<label class="col-sm-4 control-label">จังหวัด</label>-->
      <!--<div class="col-sm-8">-->
      <!--<label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applntOrg_prov_id"]]:"-").'</label>-->
      <!--</div>-->
      <!--</div>-->

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_country_id"]!=""?$countryList[$rs_case["case_feild"]["applnt_country_id"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_zipcode"]!=""?$rs_case["case_feild"]["applntOrg_zipcode"]:"-").'</label>
        </div>
      </div>

      <!-- /เป็นตัวแทนบริษัท -->
      ';
    }
    // else if (in_array($_SESSION['admin']['empId'], array('1', '7')) && $rs_case["case_feild"]["applnt_type"] == 2) {
    else if ($rs_case["case_feild"]["applnt_type"] == 2) {
      $formSet_html .= '<!-- ยื่นในนามบุคคลธรรมดา -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-user" aria-hidden="true"></span>
        <label class="text-data">ยื่นในนามบุคคลธรรมดา</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.$rs_case["case_feild"]["applnt_valid_ditp"].'.png" />':'').'
      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>
        
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อาชีพ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_career"]!=""?$rs_case["case_feild"]["applnt_career"]:"-").'</label>
        </div>
      </div>';
    }
    $formSet_html .= '
    </div>
    <!--
    <div class="form-group col-md-12">
      <div class="col-sm-12">
        <label class="control-label text-data-light text-data-alert">
          '.($rs_case["case_feild"]["applnt_valid_dbd"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_dbd_note"]:'').'<br />
          '.($rs_case["case_feild"]["applnt_valid_ditp"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_ditp_note"]:'').'<br />

        </label>
      </div>
    </div>
    -->

  </div>';
}else if($typeformset=="case_detail"){

  if(strlen($rs_case["case_feild"]["applnt_tel"]) == 10 || strlen($rs_case["case_feild"]["applnt_mobile_code"]) == 10) {
    if($rs_case["case_feild"]["applnt_tel"] != '') {
      $telNo = $rs_case["case_feild"]["applnt_tel"];
    } else {
      $telNo = $rs_case["case_feild"]["applnt_mobile_code"];
    }
    $str1 = substr($telNo, 1, 2);
    $str2 = substr($telNo, 3, 3);
    $str3 = substr($telNo, 6);
    $telFM = $rs_case["case_feild"]["applnt_mobile_code"].$str1.'-'.$str2.'-'.$str3;
  } else {
    if($rs_case["case_feild"]["applnt_tel"] != '') {
      $telFM = $rs_case["case_feild"]["applnt_mobile_code"].substr($rs_case["case_feild"]["applnt_tel"],1);
    } else {
      $telFM = $rs_case["case_feild"]["applnt_mobile_code"].substr($rs_case["case_feild"]["applnt_mobile"],1);
    }
  }

  if ($data_bw["cnt"] == 3) {
    $icon_cnt = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cnt"] == 2){
    $icon_cnt = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cnt"] ==1){
    $icon_cnt = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_ident']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cnt ='';
  }
  if ($data_bw["ae"] == 3) {
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ae"] == 2){
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ae"] ==1){
    $icon_ae = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_email']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ae ='';
  }
  if ($data_bw["at"] == 3) {
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["at"] == 2){
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["at"] ==1){
    $icon_at = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_at ='';
  }
  
  if ($data_bw["ctn"] == 3) {
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctn"] == 2){
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctn"] ==1){
    $icon_ctn = '<div class="icon-container-wl">
                    <i class="ico-wl" ></i>
                    <span class="font-bw">'.$data_bw['count']['applntOrg_trade_number']['watchlist'].'</span>
                  </div>';
  }else{
    $icon_ctn ='';
  }
  
  if ($data_bw["cn"] == 3) {
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cn"] == 2){
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cn"] ==1){
    $icon_cn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_name']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cn ='';
  }
  
  if ($data_bw["ctp"] == 3) {
    $icon_ctp = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctp"] == 2){
    $icon_ctp = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctp"] ==1){
    $icon_ctp = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applntOrg_tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ctp ='';
  }

  if ($data_bw["fl"] == 3) {
    $icon_fl = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['watchlist'].'</span>
                </div>';
  }else if($data_bw["fl"] == 2){
    $icon_fl = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["fl"] ==1){
    $icon_fl = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['applnt_firstname']['watchlist'].'</span>
                </div>';
  }else{
    $icon_fl ='';
  }
  
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
          <span>ข้อมูลผู้ร้องเรียน</span>

          <a class="btn btn-round btn-border btn-alt border-black btn-link font-black btn-collape" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
            <i class="glyph-icon icon-angle-up"></i>
          </a>
        </h3>
      </div>
    </div>

    <div id="collapse1" class="collapse in"  aria-labelledby="headingOne">
      <div class="form-group col-sm-10">
        <span class="glyph-icon icon-user" aria-hidden="true"></span>
        <label class="text-data font-bold">'.$rs_case["case_feild"]["applnt_title"].' '.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'</label>
        <input type="hidden" id="applnt_name_1" value="'.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'" />
        '.($rs_case["case_feild"]["applnt_ident_valid"]=="1"?'<img class="ico_validate" src="img/icon_people_1.png" />':'').'
        '.$icon_fl.'
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history"  onclick="case_detail.openHistory(\'applnt\',\'#applnt_ident_'.$formSetNo.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขบัตรประชาชน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'</label>
          <input type="hidden" id="applnt_ident_'.$formSetNo.'" value="'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'" />
          '.$icon_ctp.'
        </div>
      </div>
      
      <!--
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด </label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_birthday"]!=""?date('d/m/Y',strtotime($rs_case["case_feild"]["applnt_birthday"])):"-").'</label>
        </div>
      </div>
      -->

      <!--
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เพศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_gender"]!=""?$this->gender[$rs_case["case_feild"]["applnt_gender"]]:"-").'</label>
        </div>
      </div>
      -->

      '.
      // ((in_array($_SESSION['admin']['empId'], array('1', '7')))?'<!-- ':'')
      '<!-- '
      .'
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ตำแหน่ง4444</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_position"]!=""?$rs_case["case_feild"]["applntOrg_position"]:"-").'</label>
        </div>
      </div>
      '.
      // ((in_array($_SESSION['admin']['empId'], array('1', '7')))?' -->':'')
      ' -->'
      .'

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_email"]!=""?$rs_case["case_feild"]["applnt_email"]:"-").'</label>
          '.$icon_ae.'
        </div>
      </div>

      '.
      // ((in_array($_SESSION['admin']['empId'], array('1', '7')))?'<!-- ':'')
      '<!-- '
      .'
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์บริษัท/ที่ทำงาน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_tel"]!=""?$rs_case["case_feild"]["applnt_tel"]:"-").'</label>
        </div>
      </div>
      '.
      // ((in_array($_SESSION['admin']['empId'], array('1', '7')))?' -->':'')
      ' -->'
      .'

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์มือถือ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_at.'
        </div>
      </div>

      <!--
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">'.($txt_positon).'</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($position).'</label>  
        </div>
      </div>
      -->

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_address"]!=""?$rs_case["case_feild"]["applnt_address"]:"-").'</label>
        </div>
      </div>

      <!--<div class="form-group col-md-12">-->
      <!--<label class="col-sm-4 control-label">จังหวัด</label>-->
      <!--<div class="col-sm-8">-->
      <!--<label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applnt_prov_id"]]:"-").'</label>-->
      <!--</div>-->
      <!--</div>-->

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_zipcode"]!=""?$rs_case["case_feild"]["applnt_zipcode"]:"-").'</label>
        </div>
      </div>
      
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($country_name[0]['name']).'</label>
        </div>
      </div>';

    if($rs_case["case_feild"]["applnt_type"] == 1){

      if(strlen($rs_case["case_feild"]["applntOrg_tel"]) == 10) {
        $telNo = $rs_case["case_feild"]["applntOrg_tel"];

        $str1 = substr($telNo, 1, 2);
        $str2 = substr($telNo, 3, 3);
        $str3 = substr($telNo, 6);
        $telFM = $rs_case["case_feild"]["applntOrg_mobile_code"].$str1.'-'.$str2.'-'.$str3;
      } else {
        if($rs_case["case_feild"]["applntOrg_tel"] != '') {
          $telFM = $rs_case["case_feild"]["applntOrg_mobile_code"].substr($rs_case["case_feild"]["applntOrg_tel"],1);
        } else {
          $telFM = '-';
        }
      }

      $formSet_html .= '<!-- เป็นตัวแทนบริษัท -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data">เป็นตัวแทนบริษัท</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.($rs_case["case_feild"]["applnt_valid_ditp"]!="2"?$rs_case["case_feild"]["applnt_valid_ditp_org"]:($rs_case["case_feild"]["applnt_valid_ditp_org"]=="non member"?"non-member":$rs_case["case_feild"]["applnt_valid_ditp"])).'.png" />':'').'
      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_trade_number"]!=""?$rs_case["case_feild"]["applntOrg_trade_number"]:"-").'</label>
          '.$icon_ctn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ชื่อบริษัทที่จดทะเบียน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_name"]!=""?$rs_case["case_feild"]["applntOrg_name"]:"-").'</label>
          '.$icon_cn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเภทธุรกิจ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$applntOrg_import_export.'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">สาขา</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_branch"]!=""?$rs_case["case_feild"]["applntOrg_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ตำแหน่ง</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_position"]!=""?$rs_case["case_feild"]["applntOrg_position"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_ctp.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เว็บไซต์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_web"]!=""?$rs_case["case_feild"]["applntOrg_web"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_address"]!=""?$rs_case["case_feild"]["applntOrg_address"]:"-").'</label>
        </div>
      </div>

      <!--<div class="form-group col-md-12">-->
      <!--<label class="col-sm-4 control-label">จังหวัด</label>-->
      <!--<div class="col-sm-8">-->
      <!--<label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applntOrg_prov_id"]]:"-").'</label>-->
      <!--</div>-->
      <!--</div>-->

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_country_id"]!=""?$countryList[$rs_case["case_feild"]["applnt_country_id"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_zipcode"]!=""?$rs_case["case_feild"]["applntOrg_zipcode"]:"-").'</label>
        </div>
      </div>
      <!-- /เป็นตัวแทนบริษัท -->
      ';
    }
    // else if (in_array($_SESSION['admin']['empId'], array('1', '7')) && $rs_case["case_feild"]["applnt_type"] == 2) {
    else if ($rs_case["case_feild"]["applnt_type"] == 2) {
      $formSet_html .= '<!-- ยื่นในนามบุคคลธรรมดา -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-user" aria-hidden="true"></span>
        <label class="text-data">ยื่นในนามบุคคลธรรมดา</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.$rs_case["case_feild"]["applnt_valid_ditp"].'.png" />':'').'
      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>
    
      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อาชีพ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_career"]!=""?$rs_case["case_feild"]["applnt_career"]:"-").'</label>
        </div>
      </div>';
    }
    $formSet_html .= '
    </div>
    <!--
    <div class="form-group col-md-12">
      <div class="col-sm-12">
        <label class="control-label text-data-light text-data-alert">
          '.($rs_case["case_feild"]["applnt_valid_dbd"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_dbd_note"]:'').'<br />
          '.($rs_case["case_feild"]["applnt_valid_ditp"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_ditp_note"]:'').'<br />

        </label>
      </div>
    </div>
    -->

  </div>';
}
?>
