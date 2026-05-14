<?php

if($typeformset=="case_open"){


  $formSet_html = '<div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <h3 class="title-hero col-md-12">
              <span class="glyph-icon icon-user" aria-hidden="true"></span>
              ข้อมูลส่วนที่ '.$formSetNo.' | '.$formSetName.'
          </h3>
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label ">เลขนิติบุคคล</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_trade_number"].'" class="form-control" name="complnt_trade_number_IdxFs_'.$formSetId.'" id="complnt_trade_number_IdxFs_'.$formSetId.'"  />
          <input type="hidden" class="complnt_backlist" name="complnt_backlist_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_backlist"].'" />
        </div>
        <input id="typesub" value="'.$this->compTypeSub1.'" hidden>
        <div class="col-sm-6 div_complnt_trade_number" id="div_complnt_trade_number_10">
        </div>';
  // if (in_array($_SESSION['admin']['empId'], array('1', '7')) && $this->compTypeSub1 === '1') {
  if ($this->compTypeSub1 === '1') {
    $formSet_html .= '
        <div class="col-sm-6 flex_wrap" id="div_type1_complnt_trade_number_10">
          <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'dbd\',\'#complnt_trade_number_IdxFs_'.$formSetId.'\',\'complnt\');"><img class="check_dbd_logo" id="check_dbd_logo_IdxFs_'.$formSetId.'" src="img/btn_check_dbd_'.($rs_case["case_feild"]["complnt_valid_dbd"]!=""?$rs_case["case_feild"]["complnt_valid_dbd"]:"0").'.png" /></button>
          <button class="btn btn-default btn-image" type="button" onclick="case_open.checkWebService(\'ditp\',\'#complnt_trade_number_IdxFs_'.$formSetId.'\',\'complnt\');"><img class="check_ditp_logo" id="check_ditp_logo_IdxFs_'.$formSetId.'" src="'.($rs_case["case_feild"]["complnt_valid_ditp"]!=""?($rs_case["case_feild"]["complnt_valid_ditp"]=="1"?"img/ditp/btn-ditp-".$rs_case["case_feild"]["complnt_valid_ditp_org"]:"img/btn_check_ditp_".$rs_case["case_feild"]["complnt_valid_ditp"]):"img/btn_check_ditp_0").'.png" /></button>
          <input type="hidden" class="val_complnt_valid_dbd" name="complnt_valid_dbd_IdxFs_'.$formSetId.'" id="complnt_valid_dbd_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_valid_dbd"].'">
          <input type="hidden" class="val_complnt_valid_dbd_note" name="complnt_valid_dbd_note_IdxFs_'.$formSetId.'" id="check_dbd_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_valid_dbd_note"].'">
          <input type="hidden" class="val_complnt_valid_ditp" name="complnt_valid_ditp_IdxFs_'.$formSetId.'" id="complnt_valid_ditp_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_valid_ditp"].'">
          <input type="hidden" class="val_complnt_valid_ditp_org" name="complnt_valid_ditp_org_IdxFs_'.$formSetId.'" id="complnt_valid_ditp_org_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_valid_ditp_org"].'">
          <input type="hidden" class="val_complnt_valid_ditp_note" name="complnt_valid_ditp_note_IdxFs_'.$formSetId.'" id="check_ditp_note_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_valid_ditp_note"].'">
        </div>';
  }
  $formSet_html .= '
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">ชื่อบริษัท</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_name"].'" class="form-control complnt_name_input" name="complnt_name_IdxFs_'.$formSetId.'"  />
        </div>
        <div class="col-sm-4" id="div_complnt_name_10">
          <!-- <button class="btn btn-default btn-image btn-checkBlacklist" type="button" onclick="case_open.checkWebService(\'backlist\',\'#complnt_trade_number_IdxFs_'.$formSetId.'\');"><img id="check_backlist_logo_IdxFs_'.$formSetId.'" src="img/btn_check_backlist_'.($rs_case["case_feild"]["complnt_backlist"]!=""?$rs_case["case_feild"]["complnt_backlist"]:"0").'.png" /></button> -->
          <input type="hidden" class="complnt_backlist" name="complnt_backlist_IdxFs_'.$formSetId.'" id="complnt_backlist_IdxFs_'.$formSetId.'" value="'.$rs_case["case_feild"]["complnt_backlist"].'" />
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">ประเภทธุรกิจ</label>
        <div class="col-sm-4">
          <select class="custom-select" name="complnt_import_export_IdxFs_'.$formSetId.'">
            <option value="">
            อื่นๆ
            </option>
            <option value="1" '.($rs_case["case_feild"]["complnt_import_export"]=="1"?"selected":"").'>
              บริษัทนำเข้า
            </option>
            <option value="2" '.($rs_case["case_feild"]["complnt_import_export"]=="2"?"selected":"").'>
              บริษัทส่งออก
            </option>
          </select>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label">สาขา</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_branch"].'" class="form-control" name="complnt_branch_IdxFs_'.$formSetId.'"  />
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label">ชื่อที่ติดต่อ </label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_contact_name"].'" class="form-control" name="complnt_contact_name_IdxFs_'.$formSetId.'"  />
        </div>
        <div class="col-sm-6 div_complnt_contact_name" id="div_complnt_contact_name_10">
        </div>
       <!-- <label class="col-sm-2 control-label control-label-r required div_complnt_contact_name">หมายเลขโทรศัพท์ติดต่อ</label>
        <div class="col-sm-4 flex-container div_complnt_contact_tel">
          <div class="flex2" id="tel3">
            <input type="text" value="'.$rs_case["case_feild"]["complnt_contact_tel"].'" data-code="'.$rs_case["case_feild"]["complnt_contact_tel"].'" class="form-control tel_format input-mask phone-number-complnt" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;" name="complnt_contact_tel_IdxFs_'.$formSetId.'" />
            <input type="hidden" name="complnt_mobile_country" id="complnt_mobile_country2" value="'.$rs_case["case_feild"]["complnt_mobile_country"].'">
            <input type="hidden" name="complnt_mobile_code" id="complnt_mobile_code2" value="'.$rs_case["case_feild"]["complnt_mobile_code"].'">
          </div>
        </div>
        <div class="col-sm-6 div_complnt_contact_tel" id="div_complnt_contact_tel_10">
        </div> -->
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required div_complnt_contact_name">หมายเลขโทรศัพท์ติดต่อ</label>
        <div class="col-sm-4 flex-container div_complnt_contact_tel">
          <div class="flex2" id="tel3">
            <input type="text" value="'.$rs_case["case_feild"]["complnt_contact_tel"].'" data-code="'.$rs_case["case_feild"]["complnt_contact_tel"].'" class="form-control tel_format input-mask phone-number-complnt" data-inputmask="&apos;mask&apos;:&apos;999-999-9999&apos;" name="complnt_contact_tel_IdxFs_'.$formSetId.'" />
            <input type="hidden" name="complnt_mobile_country" id="complnt_mobile_country2" value="'.$rs_case["case_feild"]["complnt_mobile_country"].'">
            <input type="hidden" name="complnt_mobile_code" id="complnt_mobile_code2" value="'.$rs_case["case_feild"]["complnt_mobile_code"].'">
          </div>
        </div>
        <div class="col-sm-6 div_complnt_contact_tel" id="div_complnt_contact_tel_10">
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">E-mail ที่ติดต่อ</label>
        <div class="col-sm-4">
          <input type="email" value="'.$rs_case["case_feild"]["complnt_contact_email"].'" class="form-control" name="complnt_contact_email_IdxFs_'.$formSetId.'"  />
        </div>
        <div class="col-sm-6 div_complnt_contact_email" id="div_complnt_contact_email_10">
        </div>
       <!-- <label class="col-sm-2 control-label control-label-r div_complnt_contact_email">เว็บไซต์</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_web"].'" class="form-control" name="complnt_web_IdxFs_'.$formSetId.'"  />
        </div> -->
        
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label  div_complnt_contact_email">เว็บไซต์</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_web"].'" class="form-control" name="complnt_web_IdxFs_'.$formSetId.'"  />
        </div>
        
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">ที่อยู่ติดต่อ</label>
        <div class="col-sm-10">
          <textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="3" class="form-control textarea-no-resize">'.$rs_case["case_feild"]["complnt_contact_address"].'</textarea>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">ประเทศ</label>
        <div class="col-sm-4">
            <select name="complnt_country_id_IdxFs_'.$formSetId.'" class="form-control select-picker" data-live-search="true">
              <option value="" style="color:#777">
               --- เลือกประเทศ ---
              </option>
              '.$countryList_complnt_with_th.'
            </select>
        </div>

        <label class="col-sm-2 control-label control-label-r">รหัสไปรษณีย์</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_zipcode"].'" class="form-control" name="complnt_zipcode_IdxFs_'.$formSetId.'" />
        </div>
      </div>
    </div>
    <input type="hidden" name="formSetId_b" value="'.$formSetId.'" >';
}else if($typeformset=="case_open_detail"){

  $enebledRef = "";
  // if(!($caseCh_id==1 || $caseCh_id==2)){
  //   if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_lastSave_datetime"]==""){
  //     $enebledRef = "enableRef";
  //   }
  // }else{
    //if($rs_case["case"]["case_status"]=="0"){
      $enebledRef = "enableRef";
    //}
  // }
  if($rs_case["case_feild"]["complnt_country_id"] == '162') {
    if(strlen($rs_case["case_feild"]["complnt_contact_tel"]) == 10) {
      $telNo = $rs_case["case_feild"]["complnt_contact_tel"];
  
      $str1 = substr($telNo, 1, 2);
      $str2 = substr($telNo, 3, 3);
      $str3 = substr($telNo, 6);
      $telFM = $rs_case["case_feild"]["complnt_mobile_code"].$str1.'-'.$str2.'-'.$str3;
    } else {
      if($rs_case["case_feild"]["complnt_contact_tel"] != '') {
        $telFM = $rs_case["case_feild"]["complnt_mobile_code"].substr($rs_case["case_feild"]["complnt_contact_tel"],1);
      } else {
        $telFM = '-';
      }
    }
  } else {
    if($rs_case["case_feild"]["complnt_contact_tel"] != '') {
      $telFM = $rs_case["case_feild"]["complnt_mobile_code"].substr($rs_case["case_feild"]["complnt_contact_tel"],1);
    } else {
      $telFM = '-';
    }
  }

  if ($data_bw["cn"] == 3) {
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cn"] == 2){
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cn"] ==1){
    $icon_cn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cn ='';
  }
  if ($data_bw["ctn"] == 3) {
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctn"] == 2){
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctn"] ==1){
    $icon_ctn = '<div class="icon-container-wl">
                    <i class="ico-wl" ></i>
                    <span class="font-bw">'.$data_bw['count']['number']['watchlist'].'</span>
                  </div>';
  }else{
    $icon_ctn ='';
  }
  if ($data_bw["ccn"] == 3) {
    $icon_ccn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ccn"] == 2){
    $icon_ccn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ccn"] ==1){
    $icon_ccn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ccn ='';
  }
  if ($data_bw["at"] == 3) {
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["at"] == 2){
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["at"] ==1){
    $icon_at = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_at ='';
  }
  if ($data_bw["ae"] == 3) {
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ae"] == 2){
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ae"] ==1){
    $icon_ae = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ae ='';
  }
 
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
            <span>ข้อมูลผู้ถูกร้องเรียน</span>

            <a class="btn btn-round btn-border btn-alt border-black btn-link font-black btn-collape" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
                <i class="glyph-icon icon-angle-up"></i>
            </a>
        </h3>
      </div>
    </div>

    <div id="collapse2" class="collapse in '.$enebledRef.'"  aria-labelledby="headingOne">

      <div class="form-group col-sm-10">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data font-bold">'.($rs_case["case_feild"]["complnt_name"]!=""?$rs_case["case_feild"]["complnt_name"]:"-").'</label>
        '.($rs_case["case_feild"]["complnt_valid_dbd"]!=""?'<img class="ico_validate" src="img/icon_dbd_'.$rs_case["case_feild"]["complnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["complnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/ditp/icon_ditp_'.($rs_case["case_feild"]["complnt_valid_ditp"]!="2"?$rs_case["case_feild"]["complnt_valid_ditp_org"]:($rs_case["case_feild"]["complnt_valid_ditp_org"]=="non member"?"non-member":$rs_case["case_feild"]["complnt_valid_ditp"])).'.png" />':'').'
        './*($rs_case["case_feild"]["complnt_backlist"]=="1"?'<img class="ico_validate" src="img/icon_backlist_'.$rs_case["case_feild"]["complnt_backlist"].'.png" />':'')*/''.'
        '.$icon_cn.'
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'complnt\',\'#complnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_trade_number"]!=""?$rs_case["case_feild"]["complnt_trade_number"]:"-").'</label>
          '.$icon_ctn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเภทธุรกิจ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$complnt_import_export.'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">สาขา</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_branch"]!=""?$rs_case["case_feild"]["complnt_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ชื่อที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_name"]!=""?$rs_case["case_feild"]["complnt_contact_name"]:"-").'</label>
          '.$icon_ccn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_at.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail ที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_email"]!=""?$rs_case["case_feild"]["complnt_contact_email"]:"-").'</label>
          '.$icon_ae.'
          </label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_address"]!=""?$rs_case["case_feild"]["complnt_contact_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_zipcode"]!=""?$rs_case["case_feild"]["complnt_zipcode"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_country_id"]!=""?$countryList[$rs_case["case_feild"]["complnt_country_id"]]:"-").'</label>
        </div>
      </div>

      <!-- <div class="form-group col-md-12">
        <div class="col-sm-12">
          <label class="control-label text-data-light text-data-alert">
            '.($rs_case["case_feild"]["complnt_backlist"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["complnt_backlist_note"]:'').'
          </label>
        </div>
      </div> -->
    </div>';
    
      
    
  if(count($rs_case["case_ref"])>0){
    $formSet_html .= '<div class="form-group col-md-12 line-top-border panel-ref">
                        <label class="col-sm-2 control-label">Reference Case : </label>
                        <div class="col-sm-10 col_ref_case">';
                        foreach($rs_case["case_ref"] as $rs_case_ref){
                          $formSet_html .= '<button class="btn ra-100 btn-primary btn-ref btn_ref_'.$rs_case_ref["case_ref_id"].'">Case ID - '.sprintf("%05d",$rs_case_ref["case_ref_id"]).'</button>';
                        }
                        $formSet_html .= '
                        </div>
                      </div>';
  }
  $formSet_html .= '</div>';
}else if($typeformset=="case_detail"){

  if($rs_case["case_feild"]["complnt_country_id"] == '162') {
    if(strlen($rs_case["case_feild"]["complnt_contact_tel"]) == 10) {
      $telNo = $rs_case["case_feild"]["complnt_contact_tel"];
  
      $str1 = substr($telNo, 1, 2);
      $str2 = substr($telNo, 3, 3);
      $str3 = substr($telNo, 6);
      $telFM = $rs_case["case_feild"]["complnt_mobile_code"].$str1.'-'.$str2.'-'.$str3;
    } else {
      if($rs_case["case_feild"]["complnt_contact_tel"] != '') {
        $telFM = $rs_case["case_feild"]["complnt_mobile_code"].substr($rs_case["case_feild"]["complnt_contact_tel"],1);
      } else {
        $telFM = '-';
      }
    }
  } else {
    if($rs_case["case_feild"]["complnt_contact_tel"] != '') {
      $telFM = $rs_case["case_feild"]["complnt_mobile_code"].substr($rs_case["case_feild"]["complnt_contact_tel"],1);
    } else {
      $telFM = '-';
    }
  }

  if ($data_bw["cn"] == 3) {
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['watchlist'].'</span>
                </div>';
  }else if($data_bw["cn"] == 2){
    $icon_cn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["cn"] ==1){
    $icon_cn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['company']['watchlist'].'</span>
                </div>';
  }else{
    $icon_cn ='';
  }
  if ($data_bw["ctn"] == 3) {
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ctn"] == 2){
    $icon_ctn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['number']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ctn"] ==1){
    $icon_ctn = '<div class="icon-container-wl">
                    <i class="ico-wl" ></i>
                    <span class="font-bw">'.$data_bw['count']['number']['watchlist'].'</span>
                  </div>';
  }else{
    $icon_ctn ='';
  }
  if ($data_bw["ccn"] == 3) {
    $icon_ccn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ccn"] == 2){
    $icon_ccn = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ccn"] ==1){
    $icon_ccn = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['name']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ccn ='';
  }
  if ($data_bw["at"] == 3) {
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['watchlist'].'</span>
                </div>';
  }else if($data_bw["at"] == 2){
    $icon_at = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["at"] ==1){
    $icon_at = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['tel']['watchlist'].'</span>
                </div>';
  }else{
    $icon_at ='';
  }
  if ($data_bw["ae"] == 3) {
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['blacklist'].'</span>
                </div>
                <div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['watchlist'].'</span>
                </div>';
  }else if($data_bw["ae"] == 2){
    $icon_ae = '<div class="icon-container-bl">
                  <i class="ico-bl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['blacklist'].'</span>
                </div>';
  }else if( $data_bw["ae"] ==1){
    $icon_ae = '<div class="icon-container-wl">
                  <i class="ico-wl" ></i>
                  <span class="font-bw">'.$data_bw['count']['email']['watchlist'].'</span>
                </div>';
  }else{
    $icon_ae ='';
  }
  
  /* print_r($ctn);
  exit(); */
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
            <span>ข้อมูลผู้ถูกร้องเรียน</span>

            <a class="btn btn-round btn-border btn-alt border-black btn-link font-black btn-collape" data-toggle="collapse" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
                <i class="glyph-icon icon-angle-up"></i>
            </a>
        </h3>
      </div>
    </div>

    <div id="collapse2" class="collapse in '.$enebledRef.'"  aria-labelledby="headingOne">

      <div class="form-group col-sm-10">
        <span class="glyph-icon icon-building-o" aria-hidden="true"></span>
        <label class="text-data font-bold">'.($rs_case["case_feild"]["complnt_name"]!=""?$rs_case["case_feild"]["complnt_name"]:"-").'</label>
        '.($rs_case["case_feild"]["complnt_valid_dbd"]!=""?'<img class="ico_validate" src="img/icon_dbd_'.$rs_case["case_feild"]["complnt_valid_dbd"].'.png" />':'').'
        '.($rs_case["case_feild"]["complnt_valid_ditp"]!=""?'<img class="ico_validate" src="img/ditp/icon_ditp_'.($rs_case["case_feild"]["complnt_valid_ditp"]!="2"?$rs_case["case_feild"]["complnt_valid_ditp_org"]:($rs_case["case_feild"]["complnt_valid_ditp_org"]=="non member"?"non-member":$rs_case["case_feild"]["complnt_valid_ditp"])).'.png" />':'').'
        '.$icon_cn.'
        './* ($rs_case["case_feild"]["complnt_backlist"]=="1"?'<img class="ico_validate" src="img/icon_backlist_'.$rs_case["case_feild"]["complnt_backlist"].'.png" />':'') */ ''.'
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'complnt\',\'#complnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_trade_number"]!=""?$rs_case["case_feild"]["complnt_trade_number"]:"-").'</label>
          '.$icon_ctn.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเภทธุรกิจ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$complnt_import_export.'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">สาขา</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_branch"]!=""?$rs_case["case_feild"]["complnt_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ชื่อที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_name"]!=""?$rs_case["case_feild"]["complnt_contact_name"]:"-").'</label>
          '.$icon_ccn.'
          </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.$telFM.'</label>
          '.$icon_at.'
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail ที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_email"]!=""?$rs_case["case_feild"]["complnt_contact_email"]:"-").'</label>
          '.$icon_ae.'
          </label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_address"]!=""?$rs_case["case_feild"]["complnt_contact_address"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ไปรษณีย์</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_zipcode"]!=""?$rs_case["case_feild"]["complnt_zipcode"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ประเทศ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_country_id"]!=""?$countryList[$rs_case["case_feild"]["complnt_country_id"]]:"-").'</label>
        </div>
      </div>
      <!--
      <div class="form-group col-md-12">
        <div class="col-sm-12">
          <label class="control-label text-data-light text-data-alert">
            '.($rs_case["case_feild"]["complnt_backlist"]=="2"?'*หมายเหตุ : '.$rs_case["case_feild"]["complnt_backlist_note"]:'').'
          </label>
        </div>
      </div> 
      -->
    </div>';

      
    
  if(count($rs_case["case_ref"])>0){
    $formSet_html .= '<div class="form-group col-md-12 line-top-border panel-ref">
                        <label class="col-sm-2 control-label">Reference Case : </label>
                        <div class="col-sm-10 col_ref_case">';
                        foreach($rs_case["case_ref"] as $rs_case_ref){
                          $formSet_html .= '<button class="btn ra-100 btn-primary btn-ref btn_ref_'.$rs_case_ref["case_ref_id"].'">Case ID - '.sprintf("%05d",$rs_case_ref["case_ref_id"]).'</button>';
                        }
                        $formSet_html .= '
                        </div>
                      </div>';
  }
  $formSet_html .= '</div>';
}
?>
