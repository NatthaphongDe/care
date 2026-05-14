<?php

ini_set('max_execution_time', 0);
if (isset($_GET["method"]) && $_GET["method"] == "editcase") {
  $type_method = "update_case";
} else {
  $type_method = "save_case";
}
?>
<form class="form-horizontal frm_case_open" name="frm_case_open" id="frm_case_open" enctype="multipart/form-data" method="post" action="function.php?method=<?php echo $type_method ?>">
  <div class="row">
    <div class="col-md-12">
      <div id="page-title">
        <span class="glyph-icon icon-inbox icon-title-text" aria-hidden="true">
          เรื่องร้องเรียนทั้งหมด
        </span>
      </div>
      <!-- History Menu -->
      <div class="panel" id="panel-his-menu">
        <div class="panel-body">
          <div class="nav-history">
            <?php
            $arr_compType_name = $caseOpn_cls->getTitleCreateCase($rdi_compType_id, $rdi_compTypeSub1, $rdi_compTypeSub2);

            // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
            //   var_dump($arr_compType_name);
            // }
            if ($arr_compType_name["compType_name"] != "") {
            ?>
              <a href="javascript:void(0);" class="no-underline">แบบฟอร์ม <?php echo $arr_compType_name["compType_name"] ?></a>
              <?php
            }
            if ($compType_other_flag == 0) {
              if ($arr_compType_name["compTypeSub1_name"] != "") {
                if ($arr_compType_name["compTypeSub2_name"] != "") {
                  $compTypeSub2_name = $arr_compType_name["compTypeSub2_name"];
                } else {
                  $compTypeSub2_name = "";
                }
              ?>
                <span class="glyph-icon icon-angle-right hidden-xs"></span>
                <div class="border-row-inner hidden-sm hidden-md hidden-lg" style="float:left; width:100%; margin-top:15px;"></div>
                <a href="javascript:void(0);" class="no-underline"><?php echo $arr_compType_name["compTypeSub1_name"] . " " . $compTypeSub2_name ?> </a>
              <?php
              }
            } else if ($compType_other_flag == "1") {
              ?>
              <span class="glyph-icon icon-angle-right hidden-xs"></span>
              <div class="border-row-inner hidden-sm hidden-md hidden-lg" style="float:left; width:100%; margin-top:15px;"></div>
              <a href="javascript:void(0);" class="no-underline"><?php echo $compType_other ?> </a>
            <?php
            }
            ?>

            <a class="" href="javascript:void(0);" onclick="case_open.openCase('#model_edit_case')" title="">
              <i class="ditp-icon icon-ico-ditp-10 icon-case-create"></i>
            </a>

          </div>
        </div>
      </div>
      <!-- /History Menu -->

      <!-- Case Panel 1 -->
      <div class="panel" id="panel-form-1">
        <div class="panel-body">
          <?php
          $caseCh_id = $rs_case["case"]["caseCh_id"];
          if (isset($_GET["method"]) && ($_GET["method"] == "editcase" && ($caseCh_id == 1 || $caseCh_id == 2))) {
            //--  ถ้ารับ Case มาจาก App --//

            if (count($caseOpn_cls->case_channal == 0)) {
              $caseOpn_cls->case_channal = $caseOpn_cls->caseChannelList();
            }
          ?>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label required">ช่องทางการรับเรื่องร้องเรียน</label>
                <div class="col-sm-6">

                  <select name="caseCh_id" class="form-control select-picker custom-select-select-picker" data-live-search="true">
                    <<option value="">--- กรุณาเลือกช่องทาง ---</option>
                      <?php
                      function getChannalCase($lv, $ref_id, $ref_name)
                      {
                        global $caseLst_cls;
                        global $rs_case;
                        $i = 0;
                        foreach ($caseLst_cls->caseChannelListMutiLv($lv, $ref_id) as $case_channal) {
                          if ($case_channal["caseCh_type"] != 1) {
                            $disabled = '';
                            $txtColor = '';
                            if ($lv == 1) {
                              $option .= '<optgroup>';
                              $disabled = 'disabled';
                              $txtColor = 'color:#333 !important;';
                            }
                            if ($case_channal["num_sub"] > 0) {
                              $disabled = 'disabled';
                              $txtColor = 'color:#333 !important;';
                            } else {
                              $disabled = '';
                              $txtColor = '';
                            }
                            if ($lv > 1) {
                              $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
                            } else {
                              $arrow = '';
                            }
                            $ref_name_real = $ref_name . "/" . $case_channal["caseCh_name"];
                            $option .= '<option ' . $disabled . ' ' . ($rs_case["case"]["caseCh_id"] == $case_channal["caseCh_id"] ? 'selected' : '') . ' value="' . $case_channal["caseCh_id"] . '" rel="' . $case_channal["prodType_other_flag"] . '"
                        style="' . $txtColor . '" rel="' . $case_channal["caseCh_level"] . '" data-content="<span style=\'padding-left:' . (20 * ($lv - 1)) . 'px\'>' . $arrow . '<h style=\'display:none;\'>' . $ref_name_real . '</h>' . $case_channal["caseCh_name"] . '</span>" >
                                    ' . $case_channal["caseCh_name"] . '
                                  </option>';
                            if ($case_channal["caseCh_sublist"] > 0) {
                              $n_lv = $lv + 1;
                              $option .= getChannalCase($n_lv, $case_channal["caseCh_id"], $ref_name_real);
                            }
                            if ($lv == 1) {
                              $option .= '</optgroup>';
                            }
                            $i++;
                          }
                        }
                        return $option;
                      }
                      echo getChannalCase(1, null, null);
                      ?>

                  </select>
                  <?php
                  //print_r($caseLst_cls->caseChannelListMutiLv(1,null));
                  ?>
                </div>
              </div>


              <?php
              $comp_type = $caseLst_cls->compTypeDetail($rdi_compType_id);
              ?>
              <div class="form-group col-md-6">
                <label class="col-xs-6 control-label control-label-r required">Priority</label>
                <div class="col-xs-6 select-priority">
                  <select name="case_priority" class="custom-select">
                    <?php
                    if (count($caseOpn_cls->priority_selct == 0)) {
                      $caseOpn_cls->priority_selct = $caseOpn_cls->prioritySelectList(null, $comp_type["compType_section"]);
                    }
                    foreach ($caseOpn_cls->priority_selct as $key => $value) {
                    ?>
                      <option value="<?php echo $key ?>" <?php if ($rs_case["case"]["case_priority"] == $key) { ?>selected<?php } ?>>
                        <?php echo $value ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">

                <?php
                if ($_GET["method"] == "createcase") {
                ?>
                  <input type="hidden" class="form-control" name="case_id" value="" readonly />
                <?php
                } else {
                ?>
                  <label class="col-sm-6 control-label">Case ID</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="case_id" value="<?php echo sprintf('%05d', $rs_case["case"]["case_id"]); ?>" readonly />
                  </div>
                <?php
                }
                ?>

              </div>

              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label-r">วันที่กรอกข้อมูล</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-mask" value="<?php echo date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"])); ?>" name="case_receivedoc_date" data-inputmask="&apos;mask&apos;:&apos;99/99/9999&apos;" readonly />
                </div>
              </div>

            </div>
            <div class="row">
              <div class="form-group col-md-6">

              </div>
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-mask" name="case_open_date" value="<?php echo ($rs_case["case"]["case_open_date"] != "" ? date('d/m/Y', strtotime($rs_case["case"]["case_open_date"])) : date('d/m/Y')); ?>" data-inputmask="&apos;mask&apos;:&apos;99/99/9999&apos;" readonly />
                </div>
              </div>

            </div>
            <input type="hidden" name="caseCh_type" value="1" />
          <?php
            //-- /ถ้ารับ Case มาจาก App --//
          } else {
            //-- ถ้าสร้าง Case เอง --//
            if ($method_case == "editcase") {
              $case_id_val = sprintf('%05d', $rs_case["case"]["case_id"]);
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y', strtotime($rs_case["case"]["case_open_date"]));
            } else if ($method_case == "re_open_case") {
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y');
            } else {
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y');
              $case_open_date = date('d/m/Y');
            }
          ?>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label required">ช่องทางการรับเรื่องร้องเรียน</label>
                <div class="col-sm-6">

                  <select name="caseCh_id" class="form-control select-picker custom-select-select-picker" data-live-search="true">
                    <<option value="">--- กรุณาเลือกช่องทาง ---</option>
                      <?php
                      function getChannalCase($lv, $ref_id, $ref_name)
                      {
                        global $caseLst_cls;
                        global $rs_case;
                        $i = 0;
                        foreach ($caseLst_cls->caseChannelListMutiLv($lv, $ref_id) as $case_channal) {
                          if ($case_channal["caseCh_type"] != 1) {
                            $disabled = '';
                            $txtColor = '';
                            if ($lv == 1) {
                              $option .= '<optgroup>';
                              $disabled = 'disabled';
                              $txtColor = 'color:#333 !important;';
                            }
                            if ($case_channal["num_sub"] > 0) {
                              $disabled = 'disabled';
                              $txtColor = 'color:#333 !important;';
                            } else {
                              $disabled = '';
                              $txtColor = '';
                            }
                            if ($lv > 1) {
                              $arrow = '<i class=\'ditp-icon icon-ico-ditp-43\'></i>';
                            } else {
                              $arrow = '';
                            }
                            $ref_name_real = $ref_name . "/" . $case_channal["caseCh_name"];
                            $option .= '<option ' . $disabled . ' ' . ($rs_case["case"]["caseCh_id"] == $case_channal["caseCh_id"] ? 'selected' : '') . ' value="' . $case_channal["caseCh_id"] . '" rel="' . $case_channal["prodType_other_flag"] . '"
                        style="' . $txtColor . '" rel="' . $case_channal["caseCh_level"] . '" data-content="<span style=\'padding-left:' . (20 * ($lv - 1)) . 'px\'>' . $arrow . '<h style=\'display:none;\'>' . $ref_name_real . '</h>' . $case_channal["caseCh_name"] . '</span>" >
                                    ' . $case_channal["caseCh_name"] . '
                                  </option>';
                            if ($case_channal["caseCh_sublist"] > 0) {
                              $n_lv = $lv + 1;
                              $option .= getChannalCase($n_lv, $case_channal["caseCh_id"], $ref_name_real);
                            }
                            if ($lv == 1) {
                              $option .= '</optgroup>';
                            }
                            $i++;
                          }
                        }
                        return $option;
                      }
                      echo getChannalCase(1, null, null);
                      ?>

                  </select>
                  <?php
                  //print_r($caseLst_cls->caseChannelListMutiLv(1,null));
                  ?>
                </div>
              </div>
              <?php
              $comp_type = $caseLst_cls->compTypeDetail($rdi_compType_id);
              ?>
              <div class="form-group col-md-6">
                <label class="col-xs-6 control-label control-label-r required">Priority</label>
                <div class="col-xs-6 select-priority">
                  <select name="case_priority" class="custom-select">
                    <?php
                    if (count($caseLst_cls->priority_selct == 0)) {
                      $caseLst_cls->priority_selct = $caseLst_cls->prioritySelectList(null, $comp_type["compType_section"]);
                    }
                    foreach ($caseLst_cls->priority_selct as $key => $value) {
                    ?>
                      <option value="<?php echo $key ?>" <?php if ($rs_case["case"]["case_priority"] == $key) { ?>selected<?php } ?>>
                        <?php echo $value ?>
                      </option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <?php
                if ($_GET["method"] == "createcase") {
                ?>
                  <input type="hidden" class="form-control" name="case_id" value="" readonly />
                <?php
                } else {
                ?>
                  <label class="col-sm-6 control-label">Case ID</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="case_id" value="<?php echo $case_id_val; ?>" readonly />
                  </div>
                <?php
                }
                ?>


              </div>
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label-r">วันที่รับเรื่องตามเอกสาร</label>
                <div class="col-sm-6">
                  <!-- <input type="text" class="form-control" readonly  /> -->

                  <div class="input-group">
                    <input type="text" class="form-control bootstrap-datepicker-receive input-mask" name="case_receivedoc_date" value="<?php echo $case_receivedoc_date; ?>" data-inputmask="&apos;mask&apos;:&apos;99/99/9999&apos;">
                    <span class="input-group-addon input-group-addon-calendar bg-black">
                      <i class="glyph-icon icon-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>

            </div>
            <div class="row border-row-inner">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label">เลขที่เอกสารรับเรื่อง</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="case_receivedoc_number" value="<?php echo $rs_case["case"]["case_receivedoc_number"] ?>" />
                </div>
              </div>
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-mask" name="case_open_date" value="<?php echo $case_open_date; ?>" data-inputmask="&apos;mask&apos;:&apos;99/99/9999&apos;" readonly />
                </div>
              </div>

            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label control-label">แนบเอกสารรับเรื่อง</label>
                <div class="col-sm-6">
                  <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                      <span class="fileinput-filename"><?php echo $rs_case["case"]["case_receivedoc_file_oldname"] ?></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                      <span class="fileinput-new">Browse</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="case_receivedoc_file" class="case_receivedoc_file" accept="<?php echo join(",", $caseOpn_cls->file_accept) ?>">
                    </span>
                  </div>
                </div>
              </div>

            </div>
            <input type="hidden" name="caseCh_type" value="2" />
            <!-- ถ้าสร้าง Case จาก Web -->
          <?php
          }
          ?>
        </div>
      </div>
      <!-- /Case Panel 1 -->

      <?php
      $no = 0;
      $formSet_html = array();
      foreach ($arr_formSetList as  $formSetList_panel) {
        // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
        //   echo '<br>formSetList.:: '.$formSetList_panel["frmset_id"].' --> '.$formSetList_panel["frmset_name"];
        // }
        array_push($formSet_html, $caseOpn_cls->setFromList($formSetList_panel["frmset_id"], $formSetList_panel["frmset_name"], $no + 1));
        $no++;
      ?>
        <input type="text" name="frmset_id[]" value="<?php echo $formSetList_panel["frmset_id"]; ?>" hidden>
      <?php
         //echo $formSetList_panel["frmset_id"];
      }
      //ผู้ร้องเรียนต่างประเทศ 
      //ข้อ 1-2 | 2 3 5
      //ข้อ 3-4 | 9 10 11
      //ผู้ร้องเรียนในประเทศ
      //ข้อ 1-2 | 1 4 5
      //ข้อ 3-4 | 9 10 11
      // echo json_encode($arr_formSetList);
      ?>

      <!-- ข้อมูลส่วนที่ 1 | ผู้ร้องเรียน -->
      <div class="panel panel-form-2" id="panel-form-a">
        <?php echo $formSet_html[0]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 1 | ผู้ร้องเรียน -->

      <!-- ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->
      <div class="panel panel-form-2" id="panel-form-b">
        <?php echo $formSet_html[1]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->

      <!-- ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->
      <div class="panel" id="panel-form-c">
        <?php echo $formSet_html[2]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->

      <div class="panel-body">
        <div class="row row-footer-btn div-text-center">

          <?php
          if (!(isset($_GET["method"]) && $_GET["method"] == "createcase")) {
            //--  ถ้ารับ Case มาจาก App --//
          ?>
            <button type="submit" class="btn btn-custom-tool btn-create-savecase btn-center" name="type_save" value="2">
              บันทึกข้อมูล
            </button>
            <!-- <button class="btn btn-custom-tool btn-create-savecase btn-center" name="type_save" value="2">
            บันทึกข้อมูล
          </button> -->
          <?php
          } else {
            //--  ถ้าสร้างจากระบบหลังบ้าน --//
          ?>
            <button class="btn btn-custom-tool" style="background: #a9a9a9;" type="button" onclick="check_blacklist_watchlist(this);">
              Check Blacklist
            </button>
            <button type="submit" class="btn btn-custom-tool btn-create-savecase " name="type_save" value="1">
              บันทึก
            </button>
          <?php
          }
          ?>


        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="model_chkType_IdxFs" tabindex="-1" role="dialog" aria-labelledby="model_comfirm_check_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="ditp-icon icon-ico-ditp-20"></i>
          </button>
          <h4 class="modal-title">กรุณากรอกข้อมูลบริษัท หรือเลือกยื่นในนามบุคคลธรรมดา</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div>
                <button type="button" class="btn btn-success btn-success-final btn_applnt_chkType" data-val="1">เป็นตัวแทนบริษัท</button>
              </div>
              <div style="margin-top: 15px;">
                <button type="button" class="btn btn-success btn-success-final btn_applnt_chkType" data-val="2">ยื่นในนามบุคคลธรรมดา</button>
                <p style="color: red;">(หากท่านเลือกยื่นเรื่องในนามบุคคลธรรมดา กระบวนการตรวจสอบจะใช้เวลานานกว่าปกติ)</p>
              </div>

            </div>
          </div>
        </div>
        <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-success-final"  data-dismiss="modal" aria-label="Close">ปิด</button>
              </div> -->
      </div>
    </div>
  </div>


  <input type="hidden" name="method_type" value="<?php echo $_GET["method"]; ?>" />
  <input type="hidden" name="compType_id" value="<?php echo $rdi_compType_id ?>" />
  <input type="hidden" name="compTypeSub1_id" value="<?php echo $rdi_compTypeSub1 ?>" />
  <input type="hidden" name="compTypeSub2_id" value="<?php echo $rdi_compTypeSub2 ?>" />
  <input type="hidden" name="compType_other" value="<?php echo $compType_other ?>" />
  <input type="hidden" name="compType_other_flag" value="<?php echo $compType_other_flag ?>" />

</form>


<?php include('template/modal_edit_case.php'); ?>


<script type="text/javascript" src="assets/widgets/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="assets/widgets/input-mask/inputmask.js"></script>

<script src="assets/intlTelInput/js/intlTelInput.js"></script>
<script type="text/javascript">
  var id_elm = $("input[name='formSetId_a']").val();
  var thisElm = 'inlineCheckbox_chkType_IdxFs_' + $("input[name='formSetId_a']").val();

  var arr = $("input[name='compTypeSub1_id']").val();
  var mtd = $("input[name='method_type']").val();


   



  if (mtd == 'editcase') {
    if (arr == '1') {
      
      var phone_number_info = document.querySelector(".phone-number-info");
      var intPhoneInfo = window.intlTelInput(phone_number_info, {
        // excludeCountries: ["th"],
        initialCountry: $("input[name='applnt_mobile_country']").val()
      });
      $('.phone-number-info').removeAttr('data-inputmask');

      var phone_number = document.querySelector(".phone-number");
      var intPhone = window.intlTelInput(phone_number, {
        // excludeCountries: ["th"],
        initialCountry: $("input[name='applntOrg_mobile_country']").val()
      });
      $('.phone-number').removeAttr('data-inputmask');

      var phone_number_complnt = document.querySelector(".phone-number-complnt");
      var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
        onlyCountries: ["th"],
        initialCountry: $("input[name='complnt_mobile_country']").val()
      });
    } else {
      
      var phone_number_info = document.querySelector(".phone-number-info");
      var intPhoneInfo = window.intlTelInput(phone_number_info, {
        onlyCountries: ["th"],
        initialCountry: $("input[name='applnt_mobile_country']").val()
      });
      
      var phone_number = document.querySelector(".phone-number");
      var intPhone = window.intlTelInput(phone_number, {
        onlyCountries: ["th"],
        initialCountry: $("input[name='applntOrg_mobile_country']").val()
      });
      
      var phone_number_complnt = document.querySelector(".phone-number-complnt");

      var initialCountry = $("input[name='complnt_mobile_country']").val() || "us";
      
      var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
        //excludeCountries: ["th"],
        initialCountry: initialCountry
      });
      $('.phone-number-complnt').removeAttr('data-inputmask');
     
    }
  } else {
    if (arr == '1') {
      var phone_number_info = document.querySelector(".phone-number-info");
      var intPhoneInfo = window.intlTelInput(phone_number_info, {
        //excludeCountries: ["th"],
        initialCountry: "auto"
      });
      $('.phone-number-info').removeAttr('data-inputmask');

      var phone_number = document.querySelector(".phone-number");
      var intPhone = window.intlTelInput(phone_number, {
        //excludeCountries: ["th"],
        initialCountry: "auto"
      });
      $('.phone-number').removeAttr('data-inputmask');

      var phone_number_complnt = document.querySelector(".phone-number-complnt");
      var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
        onlyCountries: ["th"],
      });
    } else {
      var phone_number_info = document.querySelector(".phone-number-info");
      var intPhoneInfo = window.intlTelInput(phone_number_info, {
        onlyCountries: ["th"],
      });

      var phone_number = document.querySelector(".phone-number");
      var intPhone = window.intlTelInput(phone_number, {
        onlyCountries: ["th"],
      });

      var phone_number_complnt = document.querySelector(".phone-number-complnt");
      var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
        //excludeCountries: ["th"],
        initialCountry: "auto"
      });
      $('.phone-number-complnt').removeAttr('data-inputmask');
    }
  }


  // if(arr[0]['frmset_name'] == "ผู้ร้องเรียนในต่างประเทศ"){
  //   var phone_number = document.querySelector(".phone-number");
  //   var intPhone = window.intlTelInput(phone_number, {
  //     excludeCountries: ["th"],
  //     initialCountry: "auto"
  //   });
  //   $('.phone-number').removeAttr('data-inputmask');
  // }else{
  //   var phone_number = document.querySelector(".phone-number");
  //   var intPhone = window.intlTelInput(phone_number, {
  //     onlyCountries: ["th"],
  //   });
  // }

  // if(arr[1]['frmset_name'] == "ผู้ถูกร้องเรียนในไทย"){
  //   var phone_number_complnt = document.querySelector(".phone-number-complnt");
  //   var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
  //     onlyCountries: ["th"],
  //   });
  // }else{
  //   var phone_number_complnt = document.querySelector(".phone-number-complnt");
  //   var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
  //     excludeCountries: ["th"],
  //     initialCountry: "auto"
  //   });
  // }

  $(document).on('click', '.btn_applnt_chkType', function() {
    var val = $(this).data('val');

    if (val == 1) {
      $("#" + thisElm).prop('checked', true);
      $("#" + thisElm).parent().addClass('checked');
      $("#" + thisElm).focus();
      $("#form_group_company_" + id_elm).slideToggle();
      case_open.chkHasCompany(thisElm, id_elm);
    } else {
      $("#zinlineCheckbox_chkType_IdxFs_" + id_elm).prop('checked', true);
      $("#zinlineCheckbox_chkType_IdxFs_" + id_elm).parent().addClass('checked');
      $("#zinlineCheckbox_chkType_IdxFs_" + id_elm).focus();
      $("#form_group_personal_" + id_elm).slideToggle();
      case_open.chkHasPersonal('zinlineCheckbox_chkType_IdxFs_' + id_elm, id_elm);
    }

    $('#model_chkType_IdxFs').modal('hide');
  })

  $(document).on('change', '#zinlineCheckbox_chkType_IdxFs_' + id_elm, function() {
    $("#" + thisElm).prop('checked', false);
    $("#" + thisElm).parent().removeClass('checked');
  })

  $(document).on('change', '#inlineCheckbox_chkType_IdxFs_' + id_elm, function() {
    $("#zinlineCheckbox_chkType_IdxFs_" + id_elm).prop('checked', false);
    $("#zinlineCheckbox_chkType_IdxFs_" + id_elm).parent().removeClass('checked');
  })

  $('input[data-inputmask]').inputmask();

  // var phone_number_code = $('.phone-number').data('code');
  // if(phone_number_code == ''){
  //   phone_number_code = 'th';
  // }

  // var phone_number = document.querySelector(".phone-number");
  // var intPhone = window.intlTelInput(phone_number, {
  //   initialCountry: phone_number_code,
  // });

  phone_number_info.addEventListener("countrychange", function() {
    var countryData = intPhoneInfo.getSelectedCountryData();
    var dialCode = (countryData.dialCode || '').toString().trim();
    var isThai = ((dialCode === '66') ? true : false);
    $('.phone-number-info').inputmask(((isThai) ? {
      mask: '999-999-9999'
    } : 'remove'));
  });

  phone_number.addEventListener("countrychange", function() {
    var countryData = intPhone.getSelectedCountryData();
    var dialCode = (countryData.dialCode || '').toString().trim();
    var isThai = ((dialCode === '66') ? true : false);
    $('.phone-number').inputmask(((isThai) ? {
      mask: '999-999-9999'
    } : 'remove'));
  });

  // var phone_number_complnt_code = $('.phone-number-complnt').data('code');
  // if(phone_number_complnt_code == ''){
  //   phone_number_complnt_code = 'th';
  // }

  // var phone_number_complnt = document.querySelector(".phone-number-complnt");
  // var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
  //   initialCountry: phone_number_complnt,
  // });

  phone_number_complnt.addEventListener("countrychange", function() {
    var countryData = intPhoneCmp.getSelectedCountryData();
    var dialCode = (countryData.dialCode || '').toString().trim();
    var isThai = ((dialCode === '66') ? true : false);
    $('.phone-number-complnt').inputmask(((isThai) ? {
      mask: '999-999-9999'
    } : 'remove'));
  });

  case_open = new case_open_class();

  CKEDITOR.config.toolbar = [
    ['Styles', 'Format', 'Font', 'FontSize'],

    ['Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Undo', 'Redo', '-', 'Cut', 'Copy', 'Paste', 'Find', 'Replace', '-', 'Outdent', 'Indent', '-', 'Print'],

    ['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
    ['TextColor', 'BGColor', 'Source'],
    ['Link','Unlink']
  ];

  for (name in CKEDITOR.instances) {
    CKEDITOR.instances[name].destroy(true);
  }

  $('textarea.ckeditor').each(function() {
    CKEDITOR.replace($(this).attr('id'));
  });

  $(document).ready(function() {
    
    
    if (arr == 2) {
      $("#tel1").find(".iti__dial-code").css('display', 'none');
      $("#tel2").find(".iti__dial-code").css('display', 'none');
    } else {
      $("#tel3").find(".iti__dial-code").css('display', 'none');
    }

    setTimeout(function() {
      auto_resize_menu();
    }, 3000);


    $(".tel_format").keypress(function(e) {
      //if the letter is not digit then display error and don't type anything
      if (e.which != 8 && e.which != 0 && String.fromCharCode(e.which) != '-' && (e.which < 48 || e.which > 57)) {
        //display error message
        return false;
      }
    });

    $('form#frm_case_open').submit(function(event) {
      /* stop form from submitting normally */
      $(`input[name="applnt_mobile_country"]`).val($(`#tel1`).find(`.iti__active`).attr("data-country-code"));
      $(`input[name="applnt_mobile_code"]`).val($(`#tel1`).find(`.iti__active`).find('.iti__dial-code').html());

      $(`input[name="applntOrg_mobile_country"]`).val($(`#tel2`).find(`.iti__active`).attr("data-country-code"));
      $(`input[name="applntOrg_mobile_code"]`).val($(`#tel2`).find(`.iti__active`).find('.iti__dial-code').html());

      $(`input[name="complnt_mobile_country"]`).val($(`#tel3`).find(`.iti__active`).attr("data-country-code"));
      $(`input[name="complnt_mobile_code"]`).val($(`#tel3`).find(`.iti__active`).find('.iti__dial-code').html());
      
      event.preventDefault();
      case_open.submit_case($(this), this);
    });

    $('.select-picker').selectpicker();

    $(".select-complnt-type").change(function(event) {
      var rel_text = $(".select-complnt-type option[value='" + $(this).val() + "']").attr("data-rel");
      $(".complnt_type_change").text("ข้อมูล" + rel_text);
    });

    if ($(".applnt_status").prop("checked") == true) {
      $("#panel-form-a").find("input").prop('disabled', true);
      $("#panel-form-a").find("select").prop('disabled', true);

      $("#panel-form-a").find("textarea").prop('disabled', true);
      $(".applnt_status").prop('disabled', false);
      $("input[name='formSetId_a']").prop('disabled', false);
      $(".select-picker").selectpicker("refresh");

    } else {
      $("#panel-form-a").find("input").prop('disabled', false);
      $("#panel-form-a").find("select").prop('disabled', false);

      $("#panel-form-a").find("textarea").prop('disabled', false);
      $(".applnt_status").prop('disabled', false);
      $("input[name='formSetId_a']").prop('disabled', false);
      $(".select-picker").selectpicker("refresh");
    }

  });

  /* Input masks */
  $(function() {


    $(".input-mask").inputmask();

    //ส่วนแนบเอกสารรับเรื่อง
    $(".case_receivedoc_file").bind("change", function(event) {
      var old_file_name = $(this).val();
      old_file_name = old_file_name.replace("C:\\fakepath\\", "")
      $(this).parents(".fileinput").find(".fileinput-filename").text(old_file_name);
    });

    // Multiple images preview in browser
    var filePreview = function(input, file_name, callback) {
      if (input) {

        var reader = new FileReader();

        reader.onload = function(event) {
          var file_tmp = event.target.result;
          if (typeof callback === "function") {
            callback(file_tmp, file_name);
          }
        }

        reader.readAsDataURL(input);
      }
    };

    $(".caseAttach_file").bind("change", function(event) {
      var file_attach = $(this)[0].files;

      <?php
      if ($_GET["method"] == "createcase") {
      ?>
        $(".panel_caseAttach_file .caseAttach_file_new").remove();
      <?php
      } else {
      ?>
        $(".panel_caseAttach_file .caseAttach_file_new").remove();
      <?php

      }
      ?>
      $(this).parents(".fileinput").find(".fileinput-filename").text('');


      var count_file = $(".panel-body-list-file").length;

      if (file_attach.length <= 20) {
        var file_attach_length = file_attach.length;

        var idx = 0;
        <?php
        if ($_GET["method"] == "createcase") {
        ?>
          $(".panel-body-list-file").remove();
        <?php
        }
        ?>

        var alert_num = 0;
        var file_name_alert = new Array();
        for (i = 0; i < file_attach_length; i++) {
          if (i > 0) {
            var file_name_only = file_attach[i].name;
            var file_name = ", " + file_attach[i].name;
          } else {
            var file_name_only = file_attach[i].name;
            var file_name = file_attach[i].name;
          }

          if (file_attach[i].size > 10485760) {
            file_name_alert.push(file_attach[i].name);
            alert_num++;
          }

          $(this).parents(".fileinput").find(".fileinput-filename").append(file_name);

          <?php
          if ($rs_case["case"]["applnt_type"] != 0) {
            if ($rs_case["case_feild"]["applntOrg_name"] != "") {
              $name_sender = $rs_case["case_feild"]["applnt_firstname"] . " " . $rs_case["case_feild"]["applnt_lastname"];
            } else {
              $name_sender = $rs_case["case_feild"]["applntOrg_name"];
            }
          } else {
            $name_sender = $rs_case["case_feild"]["applnt_firstname"] . " " . $rs_case["case_feild"]["applnt_lastname"];
          }
          ?>

          // <input type="hidden" name="filePreview" id="filePreview'+idx+'" value="'+filePreviewTmp+'" />\
          var file_view = filePreview(this.files[i], file_name_only, function(filePreviewTmp, filename) {
            if (idx < 20) {
              var elm_panel_id = "caseAttach_file_new_" + idx;
              var elm_panel = "caseAttach_file_new";
              var gen_html = '<div class="panel ' + elm_panel + '" id="' + elm_panel_id + '" >\
                              <div class="panel-body panel-body-list-file">\
                                  <ul class="list-file col-sm-12">\
                                  <li class="no-gutter">\
                                    <div class="col-xs-12 col-sm-1">\
                                      <i class="glyph-icon icon-file-o icon-thumb-file"></i>\
                                    </div>\
                                    <div class="col-xs-12 col-sm-6 list_file_name">\
                                      <input type="text" name="caseAttach_file_name[' + idx + ']" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />\
                                      <p>' + filename + '</p>\
                                      <input type="hidden" name="caseAttach_file_id[' + idx + ']" />\
                                      <input type="hidden" name="new_fileadrss" id="new_fileadrss' + idx + '" value="' + filename + '" />\
                                    </div>\
                                    <div class="col-xs-12 col-sm-3">\
                                      <p>Date : <?php echo date('d/m/Y') ?></p>\
                                      <p class="text_small">Sender : <?php echo $name_sender ?></p>\
                                    </div>\
                                    <div class="col-xs-12 col-sm-2 col-btn-file">\
                                      <button type="button" class="btn btn-round btn-bg22 btn-edit-file previewFileAttach" >\
                                        <a href="' + filePreviewTmp + '" download>\
                                          <i class="my-icon icon-ico-ditp-22"></i>\
                                        </a>\
                                      </button>\
                                      <button type="button" class="btn btn-round btn-danger btn-del-file" onclick="case_open.remove_file_new(\'' + elm_panel_id + '\',\'' + idx + '\');">\
                                        <i class="my-icon icon-ico-ditp-28"></i>\
                                      </button>\
                                    </div>\
                                  </li>\
                                  </ul>\
                              </div>\
                          </div>';
              $(".panel_caseAttach_file").append(gen_html);
            }
            idx++;

          });

        }
        if (alert_num > 0) {
          iziToast_func.alert("ขออภัย...ไฟล์เอกสาร " + file_name_alert.join(" , ") + " มีขนาดใหญ่เกินไป กรุณาอัพโหลดไฟล์เอกสารขนาดไม่เกิน 10 MB !", function() {
            $(".caseAttach_file").val('');
            $(".fileinput-filename").text('');
            $(".caseAttach_file_new").remove();
          });
        }
        setTimeout(function() {
          auto_resize_menu();
        }, 500);

      } else {
        var file_attach_length = 20;
        iziToast_func.alert("ขออภัย...ท่านสามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 20 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์");
        event.preventDefault();
      }


    });

    $(document).delegate(".applntOrg_trade_number", "keyup paste", function(e) {
      $(this).parents(".form-group").find(".check_dbd_logo").attr("src", "img/new_logo_dbd/btn_check_dbd_0.png");
      $(this).parents(".form-group").find(".check_ditp_logo").attr("src", "img/logo_ditp/btn_check_ditp_0.png");
      $(this).parents(".form-group").find(".val_applnt_valid_dbd").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_dbd_note").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp_org").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp_note").val('');

    });

    $(document).delegate(".complnt_trade_number", "keyup paste", function(e) {
      $(this).parents(".form-group").find(".check_dbd_logo").attr("src", "img/new_logo_dbd/btn_check_dbd_0.png");
      $(this).parents(".form-group").find(".check_ditp_logo").attr("src", "img/logo_ditp/btn_check_ditp_0.png");
      $(this).parents(".form-group").find(".val_applnt_valid_dbd").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_dbd_note").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp_org").val('');
      $(this).parents(".form-group").find(".val_applnt_valid_ditp_note").val('');

    });

    $(document).delegate(".complnt_name_input", "propertychange change keyup paste input", function(e) {
      $(this).parents(".panel-body").find(".complnt_backlist").val('');
      $(this).parents(".panel-body").find(".btn-checkBlacklist").find("img").attr("src", "img/btn_check_backlist_0.png");
    });

    if ($('.checkbox-company[value="1"]').is(":checked") == true) {
      var compChkTypeId = $('.checkbox-company[value="1"]').attr('id');
      var formTypeId = compChkTypeId.split('_IdxFs_').pop();
      case_open.chkHasCompany(compChkTypeId, formTypeId);
      // $(".checkbox-company").parents('.panel-body-bg2').find('input').prop('disabled',false);
      // $(".checkbox-company").parents('.panel-body-bg2').find('button').prop('disabled',false);
      // $(".checkbox-company").parents('.panel-body-bg2').find('select').prop('disabled',false);
      // $(".checkbox-company").parents('.panel-body-bg2').find('textarea').prop('disabled',false);
      // $(".checkbox-company").prop('disabled',false);
      // $(".select-picker").selectpicker("refresh");
      // $(".checkbox-company").parents(".form-group-inner").show();
    } else if ($('.checkbox-company[value="2"]').is(":checked") == true) {
      // $(".checkbox-company").parents('.panel-body-bg2').find('input').prop('disabled',true);
      // $(".checkbox-company").parents('.panel-body-bg2').find('button').prop('disabled',true);
      // $(".checkbox-company").parents('.panel-body-bg2').find('select').prop('disabled',true);
      // $(".checkbox-company").parents('.panel-body-bg2').find('textarea').prop('disabled',true);
      // $(".checkbox-company").prop('disabled',false);

      // $(".select-picker").selectpicker("refresh");
      // $(".checkbox-company").parents(".panel-body-bg2").find(".form-group-inner").hide();

      var compChkTypeId = $('.checkbox-company[value="2"]').attr('id');
      var formTypeId = compChkTypeId.split('_IdxFs_').pop();
      case_open.chkHasPersonal(compChkTypeId, formTypeId);
    }

    $('.select-product-type').bind("change", function(event) {
      var prodTypeId = $(this).val();
      var prodTypeId_other_flag = $('select.select-product-type option[value="' + prodTypeId + '"]').attr("rel");
      if (prodTypeId_other_flag == 0) {
        $(".prodType_other_elm").hide();
      } else if (prodTypeId_other_flag == 1) {
        $(".prodType_other_elm").show();
      }
    });

    // $('form[name="frm_case_open"]').submit(function(event)
    //  {
    //
    //     //  posting.done(function( data )
    //     //  {
    //     //      /* Disable the button. */
    //     //      $submit.attr("disabled", true);
    //      //
    //     //      if(data.status_response=="00"){
    //     //    		 show_loading_feedback("hide");
    //     //        iziToast_func.success('ระบบบันทึกเรื่องร้องเรียนเรียบร้อยแล้ว',function(){
    //     //        window.location.href="index.php?page=case_open_detail&caseId=data.last_case_id";
    //     //    		});
    //     //      }else if(data.status_response=="01"){
    //     //    		 show_loading_feedback("hide");
    //     //        iziToast_func.alert("บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
    //     //        /* Enable the button. */
    //     //        $submit.attr("disabled", false);
    //      //
    //     //      }else if(data.status_response=="02"){
    //     //    		show_loading_feedback("hide");
    //     //    		iziToast_func.alert(data.status_response_text);
    //     //       /* Enable the button. */
    //     //       $submit.attr("disabled", false);
    //     //    	}
    //     //  });
    // });


  });
</script>
<script type="text/javascript">
  function check_blacklist_watchlist(event) {
  show_loading_feedback("show");
  const form = document.getElementById('frm_case_open');
  const formData = new FormData(form);
  /* console.log(formData); */
  for (var i = 0; i <= 10; i++) {
    var img_blacklist = document.createElement("img");
    img_blacklist.style.maxWidth = "110px";
    img_blacklist.className = "ico_validate";
    img_blacklist.src = "assets/images/icons/blacklist.png";

    var img_watchlist = document.createElement("img");
    img_watchlist.style.maxWidth = "110px"; 
    img_watchlist.className = "ico_validate"; 
    img_watchlist.src = "assets/images/icons/watchlist.png";

    var blacklistVariableName = "img_blacklist_" + i;
    var watchlistVariableName = "img_watchlist_" + i;

    window[blacklistVariableName] = img_blacklist;
    window[watchlistVariableName] = img_watchlist;
    
  }
  
  var type = document.getElementById('typesub')?.value;
  
  
  if(type == 2){
    var elements = document.querySelectorAll('div.col-sm-4.div_complnt_trade_number');
    for (var i = 0; i < elements.length; i++) {
      elements[i].className = 'div_col-sm-4 div_complnt_trade_number';
    }
  }
  
  

  setTimeout(function() {
    
    $.ajax({
      url: "function.php?method=get_check_blacklist_watchlist",
      data: formData,
      type: "POST",
      dataType: "json",
      async: false,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        const length_count = Object.keys(data.count).length;
        for (let index = 0; index < length_count; index++) {
          
          var bl = document.createElement('div');
          var wl = document.createElement('div');

          bl.classList.add('icon-container-bl');
          wl.classList.add('icon-container-wl');
          
          var iconblacklist = "icon_blacklist_" + index;
          var iconwatchlist = "icon_watchlist_" + index;

          window[iconblacklist] = bl;
          window[iconwatchlist] = wl;
          
          
        }

        
        icon_blacklist_0.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.company.blacklist +'</span>';
        icon_watchlist_0.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.company.watchlist +'</span>';

        icon_blacklist_1.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.number.blacklist +'</span>';
        icon_watchlist_1.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.number.watchlist +'</span>';

        icon_blacklist_2.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.name.blacklist +'</span>';
        icon_watchlist_2.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.name.watchlist +'</span>';

        icon_blacklist_3.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.tel.blacklist +'</span>';
        icon_watchlist_3.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.tel.watchlist +'</span>';

        icon_blacklist_4.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.email.blacklist +'</span>';
        icon_watchlist_4.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.email.watchlist +'</span>';

        icon_blacklist_5.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.ai_number.blacklist +'</span>';
        icon_watchlist_5.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.ai_number.watchlist +'</span>';

        icon_blacklist_6.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.a_email.blacklist +'</span>';
        icon_watchlist_6.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.a_email.watchlist +'</span>';

        icon_blacklist_7.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.am_tel.blacklist +'</span>';
        icon_watchlist_7.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.am_tel.watchlist +'</span>';

        icon_blacklist_8.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.a_number.blacklist +'</span>';
        icon_watchlist_8.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.a_number.watchlist +'</span>';

        icon_blacklist_9.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.a_company.blacklist +'</span>';
        icon_watchlist_9.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.a_company.watchlist +'</span>';

        icon_blacklist_10.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.a_tel.blacklist +'</span>';
        icon_watchlist_10.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.a_tel.watchlist +'</span>';

        icon_blacklist_11.innerHTML = '<i class="ico-bl"></i><span class="font-bw">'+data.count.a_fl.blacklist +'</span>';
        icon_watchlist_11.innerHTML = '<i class="ico-wl"></i><span class="font-bw">'+data.count.a_fl.watchlist +'</span>';

        

        const div_icon_wl = document.querySelectorAll('.icon-container-wl');
        const div_icon_bl = document.querySelectorAll('.icon-container-bl');
        
        if (div_icon_wl.length != 0) {
          div_icon_wl.forEach(divElement => {
            divElement.remove();
          });
        }
        if (div_icon_bl.length != 0) {
          div_icon_bl.forEach(divElement => {
            divElement.remove();
          });
        }
        if(type == 2){
          var ctn_2 = document.getElementById('div_complnt_trade_number_'+data['frmset_b']);
        }else if(type == 1){
          var ctn_2 = document.getElementById('div_type1_complnt_trade_number_'+data['frmset_b']);
        }
        const cn = document.getElementById('div_complnt_name_'+data['frmset_b']);
        var ccn = document.getElementById('div_complnt_contact_name_'+data['frmset_b']);
        var cct = document.getElementById('div_complnt_contact_tel_'+data['frmset_b']);
        var cce = document.getElementById('div_complnt_contact_email_'+data['frmset_b']);

        var ai = document.getElementById('div_applnt_ident_'+data['frmset_a']);
        var ae = document.getElementById('div_applnt_email_'+data['frmset_a']);
        var am = document.getElementById('div_applnt_mobile_'+data['frmset_a']);
        var atn = document.getElementById('div_applntOrg_trade_number_'+data['frmset_a']);
        var an = document.getElementById('div_applntOrg_name_'+data['frmset_a']);
        var at = document.getElementById('div_applntOrg_tel_'+data['frmset_a']);
        var fl = document.getElementById('div_applnt_firstname_'+data['frmset_a']);

        

        if(type == 2){
          if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] != 0){
            if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 3){
              ctn_2.appendChild(icon_blacklist_1);
              ctn_2.appendChild(icon_watchlist_1);
            }else if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 2){
              ctn_2.appendChild(icon_blacklist_1);
            }else if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 1){
              ctn_2.appendChild(icon_watchlist_1);
            }
          }
        }else if(type == 1){
          if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] != 0){
            if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 3){
              ctn_2.appendChild(icon_blacklist_1);
              ctn_2.appendChild(icon_watchlist_1);
            }else if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 2){
              ctn_2.appendChild(icon_blacklist_1);
            }else if(data['complnt_trade_number_IdxFs_'+data['frmset_b']] == 1){
              ctn_2.appendChild(icon_watchlist_1);
            }
          }
        }

        if(data['complnt_name_IdxFs_'+data['frmset_b']] != 0){
          if(data['complnt_name_IdxFs_'+data['frmset_b']] == 3){
            cn.appendChild(icon_blacklist_0);
            cn.appendChild(icon_watchlist_0);
          }else if(data['complnt_name_IdxFs_'+data['frmset_b']] == 2){
            cn.appendChild(icon_blacklist_0);
          }else if(data['complnt_name_IdxFs_'+data['frmset_b']] == 1){
            cn.appendChild(icon_watchlist_0);
          }
        }

        if(data['complnt_contact_name_IdxFs_'+data['frmset_b']] != 0){
          if(data['complnt_contact_name_IdxFs_'+data['frmset_b']] == 3){
            ccn.appendChild(icon_blacklist_2);
            ccn.appendChild(icon_watchlist_2);
          }else if(data['complnt_contact_name_IdxFs_'+data['frmset_b']] == 2){
            ccn.appendChild(icon_blacklist_2);
          }else if(data['complnt_contact_name_IdxFs_'+data['frmset_b']] == 1){
            ccn.appendChild(icon_watchlist_2);
          }
        }

        if(data['complnt_contact_tel_IdxFs_'+data['frmset_b']] != 0){
          if(data['complnt_contact_tel_IdxFs_'+data['frmset_b']] == 3){
            cct.appendChild(icon_blacklist_3);
            cct.appendChild(icon_watchlist_3);
          }else if(data['complnt_contact_tel_IdxFs_'+data['frmset_b']] == 2){
            cct.appendChild(icon_blacklist_3);
          }else if(data['complnt_contact_tel_IdxFs_'+data['frmset_b']] == 1){
            cct.appendChild(icon_watchlist_3);
          }
        }

        if(data['complnt_contact_email_IdxFs_'+data['frmset_b']] != 0){
          if(data['complnt_contact_email_IdxFs_'+data['frmset_b']] == 3){
            cce.appendChild(icon_blacklist_4);
            cce.appendChild(icon_watchlist_4);
          }else if(data['complnt_contact_email_IdxFs_'+data['frmset_b']] == 2){
            cce.appendChild(icon_blacklist_4);
          }else if(data['complnt_contact_email_IdxFs_'+data['frmset_b']] == 1){
            cce.appendChild(icon_watchlist_4);
          }
        }

        if(data['applnt_ident_IdxFs_'+data['frmset_a']] != 0){
          if(data['applnt_ident_IdxFs_'+data['frmset_a']] == 3){
            ai.appendChild(icon_blacklist_5);
            ai.appendChild(icon_watchlist_5);
          }else if(data['applnt_ident_IdxFs_'+data['frmset_a']] == 2){
            ai.appendChild(icon_blacklist_5);
          }else if(data['applnt_ident_IdxFs_'+data['frmset_a']] == 1){
            ai.appendChild(icon_watchlist_5);
          }
        }

        if(data['applnt_firstname_IdxFs_'+data['frmset_a']] != 0){
          if(data['applnt_firstname_IdxFs_'+data['frmset_a']] == 3){
            fl.appendChild(icon_blacklist_11);
            fl.appendChild(icon_watchlist_11);
          }else if(data['applnt_firstname_IdxFs_'+data['frmset_a']] == 2){
            fl.appendChild(icon_blacklist_11);
          }else if(data['applnt_firstname_IdxFs_'+data['frmset_a']] == 1){
            fl.appendChild(icon_watchlist_11);
          }
        }

        if(data['applnt_email_IdxFs_'+data['frmset_a']] != 0){
          if(data['applnt_email_IdxFs_'+data['frmset_a']] == 3){
            ae.appendChild(icon_blacklist_6);
            ae.appendChild(icon_watchlist_6);
          }else if(data['applnt_email_IdxFs_'+data['frmset_a']] == 2){
            ae.appendChild(icon_blacklist_6);
          }else if(data['applnt_email_IdxFs_'+data['frmset_a']] == 1){
            ae.appendChild(icon_watchlist_6);
          }
        }

        if(data['applnt_mobile_IdxFs_'+data['frmset_a']] != 0){
          if(data['applnt_mobile_IdxFs_'+data['frmset_a']] == 3){
            am.appendChild(icon_blacklist_7);
            am.appendChild(icon_watchlist_7);
          }else if(data['applnt_mobile_IdxFs_'+data['frmset_a']] == 2){
            am.appendChild(icon_blacklist_7);
          }else if(data['applnt_mobile_IdxFs_'+data['frmset_a']] == 1){
            am.appendChild(icon_watchlist_7);
          }
        }

        if(data['applntOrg_trade_number_IdxFs_'+data['frmset_a']] != 0){
          if(data['applntOrg_trade_number_IdxFs_'+data['frmset_a']] == 3){
            atn.appendChild(icon_blacklist_8);
            atn.appendChild(icon_watchlist_8);
          }else if(data['applntOrg_trade_number_IdxFs_'+data['frmset_a']] == 2){
            atn.appendChild(icon_blacklist_8);
          }else if(data['applntOrg_trade_number_IdxFs_'+data['frmset_a']] == 1){
            atn.appendChild(icon_watchlist_8);
          }
        }

        if(data['applntOrg_name_IdxFs_'+data['frmset_a']] != 0){
          if(data['applntOrg_name_IdxFs_'+data['frmset_a']] == 3){
            an.appendChild(icon_blacklist_9);
            an.appendChild(icon_watchlist_9);
          }else if(data['applntOrg_name_IdxFs_'+data['frmset_a']] == 2){
            an.appendChild(icon_blacklist_9);
          }else if(data['applntOrg_name_IdxFs_'+data['frmset_a']] == 1){
            an.appendChild(icon_watchlist_9);
          }
        }

        if(data['applntOrg_tel_IdxFs_'+data['frmset_a']] != 0){
          if(data['applntOrg_tel_IdxFs_'+data['frmset_a']] == 3){
            at.appendChild(icon_blacklist_10);
            at.appendChild(icon_watchlist_10);
          }else if(data['applntOrg_tel_IdxFs_'+data['frmset_a']] == 2){
            at.appendChild(icon_blacklist_10);
          }else if(data['applntOrg_tel_IdxFs_'+data['frmset_a']] == 1){
            at.appendChild(icon_watchlist_10);
          }
        }

        show_loading_feedback("hide");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        show_loading_feedback("hide");
      }
    });
  }, 500);
}
</script>

<style>
  .form-control[disabled],
  fieldset[disabled] .form-control,
  input[disabled],
  select[disabled],
  .custom-select[disabled],
  textarea[disabled],
  .selector.disabled,
  .selector.disabled .glyph-icon {
    background: #eee !important;
  }

  .iti--allow-dropdown {
    width: 100%;
  }

  .ico-wl{
  float: right;
  height: 27px;
  width: 27px;
  margin-left: 5px;
  background-image: url(assets/images/icons/watchlist.svg);
  background-repeat: no-repeat;
  background-position: center center;
  background-size: contain;
}
.ico-bl{
  float: right;
  height: 27px;
  width: 20px;
  margin-left: 6px;
  background-image: url(assets/images/icons/blacklist.svg);
  background-repeat: no-repeat;
  background-position: center center;
  background-size: contain;
}
.icon-container-bl {
  display: inline-flex;
  align-items: center;
  padding: 4px;
  background-color: #bd2231;
  border-radius: 7px;
  max-width: 100px;
  min-width: 60px;
  height: 30px;
  margin-right: 5px;
}
.icon-container-wl {
  display: inline-flex;
  align-items: center;
  padding: 4px;
  background-color: #eb8d2a;
  border-radius: 7px;
  max-width: 100px;
  min-width: 60px;
  height: 30px;
  margin-right: 5px;
}
.font-bw{
  margin-left: 5px;
  font-size: 16px;
  color: #fff;
}
.btn-image{
  padding: 0px 8px 0px 0px;
}
.flex_wrap{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
</style>