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
        <label class="col-sm-2 control-label required">ชื่อ-นามสกุล </label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_name"].'" class="form-control" name="complnt_name_IdxFs_'.$formSetId.'"  />
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">หน่วยงาน</label>
        <div class="col-sm-10">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_branch"].'" class="form-control" name="complnt_branch_IdxFs_'.$formSetId.'"  />
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">ตำแหน่ง</label>
        <div class="col-sm-10">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_position"].'" class="form-control" name="complnt_position_IdxFs_'.$formSetId.'"  />
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label">เลขนิติบุคคล</label>
        <div class="col-sm-4">
          <div class="">
          <input type="text" value="'.$rs_case["case_feild"]["applntOrg_trade_number"].'" class="form-control input-mask applntOrg_trade_number" name="applntOrg_trade_number_IdxFs_'.$formSetId.'" id="applntOrg_trade_number_IdxFs_'.$formSetId.'" data-inputmask="&apos;mask&apos;:&apos;9-99999-9999-999&apos;"  />
          </div>
        </div>

        <label class="col-sm-2 control-label control-label-r">อายุ</label>
        <div class="col-sm-4">
          <input type="number" value="'.$rs_case["case_feild"]["complnt_age"].'" class="form-control" name="complnt_age_IdxFs_'.$formSetId.'"  />
        </div>
        <div class="col-sm-6"></div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">หมายเลขโทรศัพท์ติดต่อ</label>
        <div class="col-sm-4">
          <input type="number" value="'.$rs_case["case_feild"]["complnt_contact_tel"].'" class="form-control " name="complnt_contact_tel_IdxFs_'.$formSetId.'"  />
        </div>

        <label class="col-sm-2 control-label control-label-r required">E-mail ที่ติดต่อ</label>
        <div class="col-sm-4">
          <input type="email" value="'.$rs_case["case_feild"]["complnt_contact_email"].'" class="form-control" name="complnt_contact_email_IdxFs_'.$formSetId.'"  />
        </div>
        <label class="col-sm-2 control-label control-label-r ">เว็บไซต์</label>
        <div class="col-sm-4">
          <input type="text" value="'.$rs_case["case_feild"]["complnt_web"].'" class="form-control" name="complnt_web_IdxFs_'.$formSetId.'"  />
        </div>
      </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-10">
          <textarea name="complnt_contact_address_IdxFs_'.$formSetId.'" rows="3" class="form-control textarea-no-resize">'.$rs_case["case_feild"]["complnt_contact_address"].'</textarea>
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

  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
            <span>ข้อมูลผู้ถูกร้องเรียน/คู่กรณี</span>

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
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'complnt\',\'#complnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">หน่วยงาน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_branch"]!=""?$rs_case["case_feild"]["complnt_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ตำแหน่ง</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_position"]!=""?$rs_case["case_feild"]["complnt_position"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_birthday"]!=""?date('d/m/Y',strtotime($rs_case["case_feild"]["complnt_birthday"])):"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อายุ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_age"]!=""?$rs_case["case_feild"]["complnt_age"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_tel"]!=""?$rs_case["case_feild"]["complnt_contact_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail ที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_email"]!=""?$rs_case["case_feild"]["complnt_contact_email"]:"-").'</label>
        </label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_address"]!=""?$rs_case["case_feild"]["complnt_contact_address"]:"-").'</label>
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
  $formSet_html .= '</div>';
}else if($typeformset=="case_detail"){
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-xs-12">
            <span>ข้อมูลผู้ถูกร้องเรียน/คู่กรณี</span>

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
      </div>
      <div class="form-group col-sm-2">
        <button type="button" class="btn ra-100 btn-custom btn-history" onclick="case_detail.openHistory(\'complnt\',\'#complnt_ident_'.$formSetId.'\');"></button>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">หน่วยงาน</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_branch"]!=""?$rs_case["case_feild"]["complnt_branch"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ตำแหน่ง</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_position"]!=""?$rs_case["case_feild"]["complnt_position"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">วัน/เดือน/ปี เกิด</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_birthday"]!=""?date('d/m/Y',strtotime($rs_case["case_feild"]["complnt_birthday"])):"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">อายุ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_age"]!=""?$rs_case["case_feild"]["complnt_age"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">เบอร์โทรศัพท์ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_tel"]!=""?$rs_case["case_feild"]["complnt_contact_tel"]:"-").'</label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">E-Mail ที่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_email"]!=""?$rs_case["case_feild"]["complnt_contact_email"]:"-").'</label>
        </label>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label">ที่อยู่ติดต่อ</label>
        <div class="col-sm-8">
          <label class="text-data text-data-green">'.($rs_case["case_feild"]["complnt_contact_address"]!=""?$rs_case["case_feild"]["complnt_contact_address"]:"-").'</label>
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
  $formSet_html .= '</div>';
}
?>
