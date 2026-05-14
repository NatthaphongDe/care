<?php
if($typeformset=="case_open"){
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-sm-12 no-gutter" style="border-bottom:1px solid #e6e6e6;margin-bottom:20px;">

          <h3 class="title-hero col-sm-6" style="border-bottom:none; margin-bottom:0;">
              <span class="glyph-icon icon-user" aria-hidden="true"></span>
              ข้อมูลส่วนที่ '.$formSetNo.' | '.$formSetName.'
          </h3>
          <div class="title-hero panel-nav-right col-sm-6" style="border-bottom:none; margin-bottom:0;">
            <div class="checkbox checkbox-primary" id="empty-data-panel2">
                <label>
                    <input type="checkbox" value="1" '.($rs_case["case_feild"]["applnt_status"]==1?'checked':'').' name="applnt_status_IdxFs_'.$formSetId.'" id="inlineCheckbox_nodata_IdxFs_'.$formSetId.'" class="custom-checkbox applnt_status" onclick="case_open.change_nodata(this.id,'.$formSetId.');" '.$selected_applnt_status.' />
                    ไม่เปิดเผยข้อมูล
                </label>
                <span class="required">* ในกรณีที่ไม่ต้องการเปิดเผยรายชื่อ</span>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label">เลขบัตรประชาชน</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_ident"].'" class="form-control input-mask" name="applnt_ident_IdxFs_'.$formSetId.'" id="applnt_ident_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-99-9&apos;"  />
        <input type="hidden" name="applnt_ident_valid_IdxFs_'.$formSetId.'" id="applnt_ident_valid_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid"].'">
        <input type="hidden" name="applnt_ident_valid_note_IdxFs_'.$formSetId.'" id="check_people_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_ident_valid_note"].'">
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
      <div class="col-sm-10">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_firstname"].'" class="form-control" name="applnt_firstname_IdxFs_'.$formSetId.'" data-toggle="tooltip" data-placement="bottom" data-html="true" title=""  />
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">นามสกุล</label>
      <div class="col-sm-10">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_lastname"].'" class="form-control" name="applnt_lastname_IdxFs_'.$formSetId.'"  />
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label">วัน/เดือน/ปี เกิด</label>
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" value="'.$applnt_birthday.'" class="form-control bootstrap-datepicker-bday input-mask" name="applnt_birthday_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;99/99/9999&apos;">
          <span class="input-group-addon input-group-addon-calendar bg-black">
            <i class="glyph-icon icon-calendar"></i>
          </span>
        </div>
      </div>
      <label class="col-sm-2 control-label control-label-r ">เพศ</label>
      <div class="col-sm-4">

        <select class="custom-select" name="applnt_gender_IdxFs_'.$formSetId.'">
          <option value=""  '.($rs_case["case_feild"]["applnt_gender"]!="m" && $rs_case["case_feild"]["applnt_gender"]!="f"?"selected":"").'>
            --- เลือกเพศ ---
          </option>
          <option value="m" '.($rs_case["case_feild"]["applnt_gender"]=="m"?"selected":"").'>
            ชาย
          </option>
          <option value="f" '.($rs_case["case_feild"]["applnt_gender"]=="f"?"selected":"").'>
            หญิง
          </option>
        </select>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label">อาชีพ</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_career"].'" class="form-control" name="applnt_career_IdxFs_'.$formSetId.'"  />
      </div>
      <label class="col-sm-2 control-label control-label-r required">E-Mail</label>
      <div class="col-sm-4">
        <input type="email" value="'.$rs_case["case_feild"]["applnt_email"].'" class="form-control" name="applnt_email_IdxFs_'.$formSetId.'"  />
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">เบอร์โทรศัพท์</label>
      <div class="col-sm-4">
        <input type="number" value="'.$rs_case["case_feild"]["applnt_tel"].'" class="form-control tel_format tel_format" name="applnt_tel_IdxFs_'.$formSetId.'"  />
      </div>
      <label class="col-sm-2 control-label control-label-r required">เบอร์โทรศัพท์มือถือ</label>
      <div class="col-sm-4">
        <input type="text" value="'.$rs_case["case_feild"]["applnt_mobile"].'" class="form-control input-mask" name="applnt_mobile_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;"  />
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">ที่อยู่ติดต่อ</label>
      <div class="col-sm-10">
        <textarea name="applnt_address_IdxFs_'.$formSetId.'" rows="3" class="form-control textarea-no-resize">'.$rs_case["case_feild"]["applnt_address"].'</textarea>
      </div>
    </div>
    <div class="form-group col-md-12">
      <label class="col-sm-2 control-label required">จังหวัด</label>
      <div class="col-sm-4">
          <select name="applnt_prov_id_IdxFs_'.$formSetId.'" class="select-picker" data-live-search="true">
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
              <input value="1" type="checkbox" '.($rs_case["case_feild"]["applnt_type"]!=0?'checked':'').' id="inlineCheckbox_chkType_IdxFs_'.$formSetId.'" class="custom-checkbox checkbox-company" name="applnt_chkType_IdxFs_'.$formSetId.'" onclick="case_open.chkHasCompany(this.id,\''.$formSetId.'\');" >
              <select class="select-complnt-type custom-select applnt_type_IdxFs_'.$formSetId.'" name="applnt_type_IdxFs_'.$formSetId.'" '.($rs_case["case"]["applnt_type"]==0?'disabled':'').'>
                <option data-rel="บริษัท" value="1" '.($rs_case["case_feild"]["applnt_type"]=="" || $rs_case["case_feild"]["applnt_type"]==1 ?'selected':'').'>เป็นตัวแทนบริษัท</option>
                <!-- <option data-rel="องค์กร" value="2" '.($rs_case["case_feild"]["applnt_type"]==2?'selected':'').'>เป็นตัวแทนองค์กร</option> -->
              </select>
            </label>
          </div>
        </div>
      </div>
      <div class="form-group-inner no-gutter " id="form_group_company_'.$formSetId.'" '.($rs_case["case"]["applnt_type"]==0?'style="display:none"':'').'>
        <h3 class="title-hero col-md-12">
            <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
            <span class="applnt_type_change">'.($rs_case["case_feild"]["applnt_type"]=="" || $rs_case["case_feild"]["applnt_type"]==1 ?'ข้อมูลบริษัท':'ข้อมูลองค์กร').'</span>
        </h3>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label">หมายเลขทะเบียนการค้า</label>
          <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_trade_number"].'" class="form-control input-mask applntOrg_trade_number" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" id="applntOrg_trade_number_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-999&apos;"  />
          </div>
          <div class="col-sm-6">
            <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'dbd\',\'#applntOrg_trade_number_IdxFs_'.$formSetId.'\',\'complnt\');"><img class="check_dbd_logo" id="check_dbd_logo_IdxFs_'.$formSetId.'" src="img/new_logo_dbd/_'.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?$rs_case["case_feild"]["applnt_valid_dbd"]:"0").'.png" /></button>
            <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'ditp\',\'#applntOrg_trade_number_IdxFs_'.$formSetId.'\',\'complnt\');"><img class="check_ditp_logo" id="check_ditp_logo_IdxFs_'.$formSetId.'" src="img/logo_ditp/btn_check_ditp_'.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?$rs_case["case_feild"]["applnt_valid_ditp"]:"0").'.png" /></button>
            <input type="hidden" class="val_applnt_valid_dbd" name="applnt_valid_dbd_IdxFs_'.$formSetId.'" id="applnt_valid_dbd_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_dbd"].'">
            <input type="hidden" class="val_applnt_valid_dbd_note" name="applnt_valid_dbd_note_IdxFs_'.$formSetId.'" id="check_dbd_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_dbd_note"].'">
            <input type="hidden" class="val_applnt_valid_ditp" name="applnt_valid_ditp_IdxFs_'.$formSetId.'" id="applnt_valid_ditp_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp"].'">
            <input type="hidden" class="val_applnt_valid_ditp_org" name="applnt_valid_ditp_org_IdxFs_'.$formSetId.'" id="applnt_valid_ditp_org_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp_org"].'">
            <input type="hidden" class="val_applnt_valid_ditp_note" name="applnt_valid_ditp_note_IdxFs_'.$formSetId.'" id="check_ditp_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["applnt_valid_ditp_note"].'">
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">ชื่อบริษัทที่จดทะเบียน</label>
          <div class="col-sm-10">
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_name"].'" class="form-control" name="applntOrg_name_IdxFs_'.$formSetId.'"  />
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
            <input type="text" value="'.$rs_case["case_feild"]["applntOrg_position"].'"  class="form-control" name="applntOrg_position_IdxFs_'.$formSetId.'"  />
          </div>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">เบอร์โทรศัพท์</label>
          <div class="col-sm-4">
            <input type="number" value="'.$rs_case["case_feild"]["applntOrg_tel"].'"  class="form-control tel_format" name="applntOrg_tel_IdxFs_'.$formSetId.'"  />
          </div>
          <label class="col-sm-2 control-label control-label-r">เบอร์แฟกซ์</label>
          <div class="col-sm-4">
            <input type="number" value="'.$rs_case["case_feild"]["applntOrg_fax"].'"  class="form-control" name="applntOrg_fax_IdxFs_'.$formSetId.'"  />
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
              <select name="applntOrg_prov_id_IdxFs_'.$formSetId.'" class="select-picker" data-live-search="true">
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
    </div>
  </div>
  <input type="hidden" name="formSetId_a" value="'.$formSetId.'" >';
}else if($typeformset=="case_open_detail"){

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
        <label class="text-data">'.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'</label>
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขบัตรประชาชน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'</label>
          '.($rs_case["case_feild"]["applnt_ident_valid"]=="1"?'<img class="ico_validate" src="img/icon_people_1.png" />':'').'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_birthday"]!=""?date('d/m/Y',strtotime($rs_case["case_feild"]["applnt_birthday"])):"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เพศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_gender"]!=""?$this->gender[$rs_case["case_feild"]["applnt_gender"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อาชีพ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_career"]!=""?$rs_case["case_feild"]["applnt_career"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_email"]!=""?$rs_case["case_feild"]["applnt_email"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_tel"]!=""?$rs_case["case_feild"]["applnt_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์มือถือ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_mobile"]!=""?$rs_case["case_feild"]["applnt_mobile"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_address"]!=""?$rs_case["case_feild"]["applnt_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applnt_prov_id"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_zipcode"]!=""?$rs_case["case_feild"]["applnt_zipcode"]:"-").'</label>
        </div>
      </div>';

    if($rs_case["case_feild"]["applnt_type"]!=0){
      $formSet_html .= '<!-- เป็นตัวแทนบริษัท -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data">'.($rs_case["case_feild"]["applntOrg_name"]!=""?$rs_case["case_feild"]["applntOrg_name"]:"-").'</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.($rs_case["case_feild"]["applnt_valid_ditp_org"]!=""?$rs_case["case_feild"]["applnt_valid_ditp_org"]:$rs_case["case_feild"]["applnt_valid_ditp"]).'.png" />':'').'
      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">หมายเลขทะเบียนการค้า</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_trade_number"]!=""?$rs_case["case_feild"]["applntOrg_trade_number"]:"-").'</label>
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
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_tel"]!=""?$rs_case["case_feild"]["applntOrg_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์แฟกซ์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_fax"]!=""?$rs_case["case_feild"]["applntOrg_fax"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_address"]!=""?$rs_case["case_feild"]["applntOrg_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applntOrg_prov_id"]]:"-").'</label>
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
    $formSet_html .= '</div>
    <div class="form-group col-md-12">
      <div class="col-sm-12">
        <label class="control-label text-data-light text-data-alert">
          '.($rs_case["case_feild"]["applnt_valid_dbd"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_dbd_note"]:'').'<br />
          '.($rs_case["case_feild"]["applnt_valid_ditp"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_ditp_note"]:'').'<br />

        </label>
      </div>
    </div>

  </div>';
}else if($typeformset=="case_detail"){
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
        <label class="text-data">'.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'</label>
        <input type="hidden" id="applnt_name_1" value="'.(!($rs_case["case_feild"]["applnt_firstname"]=="" && $rs_case["case_feild"]["applnt_lastname"]=="")?$rs_case["case_feild"]["applnt_firstname"].' '.$rs_case["case_feild"]["applnt_lastname"]:"-").'" />
        '.($rs_case["case_feild"]["applnt_ident_valid"]=="1"?'<img class="ico_validate" src="img/icon_people_1.png" />':'').'
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history"  onclick="case_detail.openHistory(\'applnt\',\'#applnt_ident_'.$formSetNo.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขบัตรประชาชน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'</label>
          <input type="hidden" id="applnt_ident_'.$formSetNo.'" value="'.($rs_case["case_feild"]["applnt_ident"]!=""?$rs_case["case_feild"]["applnt_ident"]:"-").'" />
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_birthday"]!=""?date('d/m/Y',strtotime($rs_case["case_feild"]["applnt_birthday"])):"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เพศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_gender"]!=""?$this->gender[$rs_case["case_feild"]["applnt_gender"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อาชีพ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_career"]!=""?$rs_case["case_feild"]["applnt_career"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_email"]!=""?$rs_case["case_feild"]["applnt_email"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_tel"]!=""?$rs_case["case_feild"]["applnt_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์มือถือ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_mobile"]!=""?$rs_case["case_feild"]["applnt_mobile"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_address"]!=""?$rs_case["case_feild"]["applnt_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applnt_prov_id"]]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์ </label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applnt_zipcode"]!=""?$rs_case["case_feild"]["applnt_zipcode"]:"-").'</label>
        </div>
      </div>';

    if($rs_case["case_feild"]["applnt_type"]!=0){
      $formSet_html .= '<!-- เป็นตัวแทนบริษัท -->
      <div class="form-group col-sm-10 line-top-border">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data">'.($rs_case["case_feild"]["applntOrg_name"]!=""?$rs_case["case_feild"]["applntOrg_name"]:"-").'</label>
        '.($rs_case["case_feild"]["applnt_valid_dbd"]!=""?'<img class="ico_validate ico_dbd" src="img/new_logo_dbd/icon_dbd_'.$rs_case["case_feild"]["applnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["applnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/logo_ditp/icon_ditp_'.($rs_case["case_feild"]["applnt_valid_ditp_org"]!=""?$rs_case["case_feild"]["applnt_valid_ditp_org"]:$rs_case["case_feild"]["applnt_valid_ditp"]).'.png" />':'').'
      </div>
      <div class="form-group col-sm-2 line-top-border">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'applnt_org\',\'#applnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">หมายเลขทะเบียนการค้า</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_trade_number"]!=""?$rs_case["case_feild"]["applntOrg_trade_number"]:"-").'</label>
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
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_tel"]!=""?$rs_case["case_feild"]["applntOrg_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์แฟกซ์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_fax"]!=""?$rs_case["case_feild"]["applntOrg_fax"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_address"]!=""?$rs_case["case_feild"]["applntOrg_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">จังหวัด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["applntOrg_prov_id"]!=""?$provinceList[$rs_case["case_feild"]["applntOrg_prov_id"]]:"-").'</label>
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
    $formSet_html .= '</div>
    <div class="form-group col-md-12">
      <div class="col-sm-12">
        <label class="control-label text-data-light text-data-alert">
          '.($rs_case["case_feild"]["applnt_valid_dbd"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_dbd_note"]:'').'<br />
          '.($rs_case["case_feild"]["applnt_valid_ditp"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["applnt_valid_ditp_note"]:'').'<br />

        </label>
      </div>
    </div>

  </div>';
}
?>
