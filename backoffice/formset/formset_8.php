<?php
if($typeformset=="case_open"){
  $formSet_html = '<div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title-hero col-md-12">
            <span class="glyph-icon icon-pencil-square-o" aria-hidden="true"></span>
            ข้อมูลส่วนที่ '.$formSetNo.' | '.$formSetName.'
        </h3>
      </div>
    </div>
      <div class="form-group col-md-12">
        <label class="col-sm-2 control-label required">หัวข้อเรื่อง</label>
        <div class="col-sm-10">
          <input type="text" value="'.$rs_case["case_feild"]["caseDtl_title"].'" class="form-control" name="caseDtl_title_IdxFs_'.$formSetId.'"  />
        </div>
      </div>

      <div class="form-group col-md-12">
          <label class="col-sm-2 control-label required">ประเภทความผิด</label>
        <div class="col-sm-4">
          <select name="incType_id_IdxFs_'.$formSetId.'" class="custom-select select-product-type" >
            <option value="0">--- เลือกประเภทความผิด ---</option>';

            if(count($this->incorrect_type==0)){
              $this->incorrect_type = $this->incorrectTypeList();
            }
            foreach($this->incorrect_type as $incorrect_type){
              $formSet_html .= '<option value="'.$incorrect_type["incType_id"].'" '.($rs_case["case_feild"]["incType_id"]==$incorrect_type["incType_id"]?'selected':'').'  rel="'.$incorrect_type["incType_other_flag"].'">
                '.$incorrect_type["incType_name"].'
              </option>';
            }

          $formSet_html .= '</select>
        </div>

        <div class="col-sm-6">
        </div>
      </div>

      <div class="form-group col-md-12 prodType_other_elm" style="display:none;">
        <label class="col-sm-2 control-label required">โปรดระบุ</label>
        <div class="col-sm-4">
            <input type="text" value="'.$rs_case["case_feild"]["incType_other"].'" class="form-control" name="incType_other_IdxFs_'.$formSetId.'"  />
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-12 control-label required">ความเป็นมาของประเด็นเรื่องร้องเรียน</label>
        <div class="col-sm-12">
          <textarea name="caseDtl_derivation_IdxFs_'.$formSetId.'" rows="3" class="ckeditor form-control textarea-no-resize" id="ckeditor_caseDtl_derivation_IdxFs_'.$formSetId.'>'.$rs_case["case_feild"]["caseDtl_derivation"].'</textarea>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-4 control-label required">มูลค่าความเสียหาย (ระบุเป็นตัวเลข)</label>
        <div class="col-sm-8">
          <div class="col-xs-6 col-sm-3">
            <input type="number" value="'.$rs_case["case_feild"]["caseDtl_damage_val"].'" class="form-control" name="caseDtl_damage_val_IdxFs_'.$formSetId.'" step="0.01" min="0"  />
          </div>';

          if(count($this->case_currency)==0){
            $this->case_currency = $this->currencyList();
          }
          $formSet_html .= '<div class="col-xs-6 col-sm-2">
            <select name="curren_id_IdxFs_'.$formSetId.'" class="custom-select">';

              foreach($this->case_currency as $case_currency){
                $formSet_html .= '<option value="'.$case_currency["curren_id"].'" '.($rs_case["case_feild"]["curren_id"]==$case_currency["curren_id"]?"selected":"").'>'.$case_currency["curren_name"].'</option>';

              }
            $formSet_html .= '</select>
          </div>
        </div>
      </div>


      <div class="form-group col-md-12">
        <label class="col-sm-12 control-label">ความต้องการของผู้ร้องเรียน</label>
        <div class="col-sm-12">
          <textarea name="caseDtl_complnt_need_IdxFs_'.$formSetId.'" rows="3" class="ckeditor form-control textarea-no-resize" id="ckeditor_caseDtl_complnt_need_IdxFs_'.$formSetId.'">'.$rs_case["case_feild"]["caseDtl_complnt_need"].'</textarea>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="col-sm-12 control-label">เอกสารประกอบการร้องเรียน</label>
        <div class="col-sm-12 col-file-list panel_caseAttach_file">';

          $i=0;
          if(isset($_GET["method"]) && $_GET["method"]=="editcase"){
            foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
              if($rs_case["case"]["applnt_type"]!=0){
                $name_sender = $rs_case["case_feild"]["applntOrg_name"];
              }else{
                $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
              }
              if ($_GET['test_key' === '9876']) {
                // var_dump($caseDtl_cls);
              }
              $formSet_html .= '<div class="panel" id="panel_caseAttach_file_'.$i.'">
                  <div class="panel-body panel-body-list-file">
                      <ul class="list-file col-sm-12">
                      <li class="no-gutter">
                          <div class="col-xs-12 col-sm-1">
                            <i class="glyph-icon icon-file-'.$caseDtl_cls->genfileIcon($case_Attachfile["caseAttach_file_ext"]).'-o icon-thumb-file"></i>
                          </div>
                          <div class="col-xs-12 col-sm-6 list_file_name" >
                            <input type="text" name="caseAttach_file_name_old['.$i.']" value="'.$case_Attachfile["caseAttach_title"].'" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />
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
        <div class="col-sm-4">
          <input type="hidden" name="removeFileAttachId" class="removeFileAttachId" value="" />
          <input type="hidden" name="removeFileAttachNewId" class="removeFileAttachNewId" value="" />

          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
              <div class="form-control" data-trigger="fileinput">
                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                  <span class="fileinput-filename"></span>
              </div>
              <span class="input-group-addon btn btn-default btn-file">
                <span class="fileinput-new">Browse</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" class="caseAttach_file" name="caseAttach_file[]" multiple  accept="'.join(",",$this->file_accept).'">
              </span>
          </div>
        </div>
        <div class="col-sm-12">
          <label class="control-label text-data-light text-data-gray" style="opacity:0.5;">* สามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 5 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์</label>
        </div>
      </div>

  </div>
  <input type="hidden" name="formSetId_c" value="'.$formSetId.'" >';
}else if($typeformset=="case_open_detail"){
  $formSet_html = '<div class="panel-body">
    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">หัวข้อเรื่อง</label>
      <div class="col-sm-12">
        <label class="text-data text-data-green text-data-size16">'.$rs_case["case_feild"]["caseDtl_title"].'</label>
      </div>
    </div>';

    if(count($this->incorrect_type==0)){
      $this->incorrect_type = $this->incorrectTypeList();
    }
    foreach($this->incorrect_type as $incorrect_type_arr){
      if($incorrect_type_arr["incType_id"]==$rs_case["case_feild"]["incType_id"]){
        $incorrect_type_name= $incorrect_type_arr["incType_name"];
        $incorrect_other_flag = $incorrect_type_arr["incType_other_flag"];
      }
    }
    $formSet_html .= '<div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ประเภทความผิด</label>
      <div class="col-sm-12">
        <label class="text-data text-data-green text-data-size16">'.($incorrect_other_flag=="1"?$rs_case["case_feild"]["incType_other"]:$incorrect_type_name).'</label>
      </div>
    </div>

    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ความเป็นมาของประเด็นเรื่องร้องเรียน</label>
      <div class="col-sm-12">
        <label class="text-data text-data-green text-data-size16">
          '.$rs_case["case_feild"]["caseDtl_derivation"].'
        </label>
      </div>
    </div>';

    if(count($this->case_currency)==0){
      $this->case_currency = $this->currencyList();
    }

    $currency_arr = array();
    foreach($this->case_currency as $case_currency){
      if($case_currency["curren_id"]==$rs_case["case_feild"]["curren_id"]){
        $currency_name= $case_currency["curren_name"];
      }
    }

    $formSet_html .= '<div class="form-group col-md-12">
      <label class="col-sm-12 control-label">มูลค่าความเสียหาย (ระบุเป็นตัวเลข)</label>
      <div class="col-sm-12">
        <label class="text-data text-data-green text-data-size16">'.($rs_case["case_feild"]["caseDtl_damage_val"]!=""?number_format($rs_case["case_feild"]["caseDtl_damage_val"],2,".",",")." ".$currency_name:"").'</label>
      </div>
    </div>


    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ความต้องการของผู้ร้องเรียน</label>
      <div class="col-sm-12">
        <label class="text-data text-data-green text-data-size16">'.$rs_case["case_feild"]["caseDtl_complnt_need"].'</label>
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
  -->';
  if(count($rs_case["case_ref"])>0){
    $formSet_html .= '<div class="form-group col-md-12 line-top-border">
                        <label class="col-sm-2 control-label">Reference Case : </label>
                        <div class="col-sm-10">';
                        foreach($rs_case["case_ref"] as $rs_case_ref){
                          $formSet_html .= '<button class="btn ra-100 btn-primary btn-ref">Case ID - '.sprintf("%05d",$rs_case_ref["case_ref_id"]).'</button>';
                        }
                        $formSet_html .= '
                        </div>
                      </div>';
  }
  $formSet_html .= '</div>';
}else if($typeformset=="case_detail"){
  $formSet_html = '<div class="panel-body">
    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">หัวข้อเรื่อง</label>
      <div class="col-sm-12">
        <label class="text-data text-data-gray text-data-size16">'.$rs_case["case_feild"]["caseDtl_title"].'</label>
      </div>
    </div>';

    if(count($this->incorrect_type==0)){
      $this->incorrect_type = $this->incorrectTypeList();
    }
    foreach($this->incorrect_type as $incorrect_type_arr){
      if($incorrect_type_arr["incType_id"]==$rs_case["case_feild"]["incType_id"]){
        $incorrect_type_name= $incorrect_type_arr["incType_name"];
        $incorrect_other_flag = $incorrect_type_arr["incType_other_flag"];
      }
    }
    $formSet_html .= '<div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ประเภทความผิด</label>
      <div class="col-sm-12">
        <label class="text-data text-data-gray text-data-size16">'.($incorrect_other_flag=="1"?$rs_case["case_feild"]["incType_other"]:$incorrect_type_name).'</label>
      </div>
    </div>

    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ความเป็นมาของประเด็นเรื่องร้องเรียน</label>
      <div class="col-sm-12">
        <label class="text-data text-data-gray text-data-size16">
          '.$rs_case["case_feild"]["caseDtl_derivation"].'
        </label>
      </div>
    </div>';

    if(count($this->case_currency)==0){
      $this->case_currency = $this->currencyList();
    }

    $currency_arr = array();
    foreach($this->case_currency as $case_currency){
      if($case_currency["curren_id"]==$rs_case["case_feild"]["curren_id"]){
        $currency_name= $case_currency["curren_name"];
      }
    }

    $formSet_html .= '<div class="form-group col-md-12">
      <label class="col-sm-12 control-label">มูลค่าความเสียหาย (ระบุเป็นตัวเลข)</label>
      <div class="col-sm-12">
        <label class="text-data text-data-gray text-data-size16">'.($rs_case["case_feild"]["caseDtl_damage_val"]!=""?number_format($rs_case["case_feild"]["caseDtl_damage_val"],2,".",",")." ".$currency_name:"").'</label>
      </div>
    </div>


    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">ความต้องการของผู้ร้องเรียน</label>
      <div class="col-sm-12">
        <label class="text-data text-data-gray text-data-size16">'.$rs_case["case_feild"]["caseDtl_complnt_need"].'</label>
      </div>
    </div>

    <div class="form-group col-md-12">
      <label class="col-sm-12 control-label">เอกสารแนบทั้งหมด</label>
      <div class="col-sm-12 col-file-list">
        <div class="panel panel-border-none">';

          $i=0;
            foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
              $classLeft = "";
              if($i%2==0){
                $classLeft = "panel-body-list-file-1";
              }
              if($rs_case["case"]["applnt_type"]!=0){
                $name_sender = $rs_case["case_feild"]["applntOrg_name"];
              }else{
                $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
              }
               $formSet_html .= '<a href="view_file_attach.php?fileadrss='.$case_Attachfile["caseAttach_id"].'" target="_blank">
                   <!-- <div class="panel-body panel-body-list-file '.$classLeft.' col-xs-12 col-sm-6">
                      <div class="col-xs-1">
                        <i class="glyph-icon icon-file-'.$this->genfileIcon($case_Attachfile["caseAttach_file_ext"]).'-o icon-thumb-file"></i>
                      </div>
                      <div class="col-xs-11">
                        <p>'.$case_Attachfile["caseAttach_file_oldname"].'</p>
                      </div>
                   </div> -->

                   <div class="panel-body panel-body-list-file">
                     <ul class="list-file col-sm-12">
                        <li class="no-gutter">
                          <div class="col-xs-12 col-sm-1">
                            <i class="glyph-icon icon-file-'.$this->genfileIcon($case_Attachfile["caseAttach_file_ext"]).'-o icon-thumb-file"></i>
                          </div>
                          <div class="col-xs-12 col-sm-7 list_file_name">
                            <p>'.$case_Attachfile["caseAttach_title"].'</p>
                            <p style="color:#b3b3b3;">'.$case_Attachfile["caseAttach_file_oldname"].'</p>
                          </div>
                          <div class="col-xs-12 col-sm-4">
                            <p>Date : '.date("d/m/Y",strtotime($case_Attachfile["caseAttach_create_datetime"])).'</p>
                            <p class="text_small">Sender : asdas dasd</p>
                          </div>
                        </li>
                      </ul>
                    </div>
                 </a>';
                $i++;
            }
            $i=0;
              foreach ($rs_case["msg_Attachfile"] as $msg_Attachfile) {
                $classLeft = "";
                if($i%2==0){
                  $classLeft = "panel-body-list-file-1";
                }
                if($rs_case["case"]["applnt_type"]!=0){
                  $name_sender = $rs_case["msg_feild"]["applntOrg_name"];
                }else{
                  $name_sender = $rs_case["msg_feild"]["applnt_firstname"]." ".$rs_case["msg_feild"]["applnt_lastname"];
                }
                 $formSet_html .= '<a href="view_file_attach.php?fileadrss_msg='.$msg_Attachfile["msgBoxAttach_id"].'" target="_blank">
                     <div class="panel-body panel-body-list-file">
                       <ul class="list-file col-sm-12">
                          <li class="no-gutter">
                            <div class="col-xs-12 col-sm-1">
                              <i class="glyph-icon icon-file-'.$this->genfileIcon($msg_Attachfile["msgBoxAttach_file_ext"]).'-o icon-thumb-file"></i>
                            </div>
                            <div class="col-xs-12 col-sm-7 list_file_name">
                              <p>'.$msg_Attachfile["msgBoxAttach_title"].'</p>
                              <p style="color:#b3b3b3;">'.$msg_Attachfile["msgBoxAttach_file_oldname"].'</p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                              <p>Date : '.date("d/m/Y",strtotime($msg_Attachfile["msgBoxAttach_create_datetime"])).'</p>
                              <p class="text_small">Sender : '.$msg_Attachfile["msgBox_sender"].'</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                   </a>';
                  $i++;
              }
        $formSet_html .= '</div>
      </div>
    </div>
  </div>';
}
?>
