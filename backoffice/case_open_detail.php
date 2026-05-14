<link rel="stylesheet" type="text/css" href="css/case_detail.css">
<form class="form-horizontal frm_case_open_detail" name="frm_case_open_detail" enctype="multipart/form-data" method="post" action="function.php?method=save_open_case" target="iframe-data">
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
              $arr_compType_name = $caseOpn_cls->getTitleCreateCase($rdi_compType_id,$rdi_compTypeSub1,$rdi_compTypeSub2);
              if($arr_compType_name["compType_name"]!=""){
                ?>
                <a href="javascript:void(0);" class="no-underline">แบบฟอร์ม <?php echo $arr_compType_name["compType_name"] ?></a>
                <?php
              }
              if($arr_compType_name["compType_other_flag"]=="0"){
                if($arr_compType_name["compTypeSub1_name"]!=""){
                  if($arr_compType_name["compTypeSub2_name"]!=""){
                    $compTypeSub2_name = $arr_compType_name["compTypeSub2_name"];
                  }else{
                    $compTypeSub2_name = "";
                  }
                  ?>
                  <span class="glyph-icon icon-angle-right hidden-xs"></span>
                  <hr class="hidden-sm hidden-md hidden-lg" />
                  <a href="javascript:void(0);" class="no-underline"><?php echo $arr_compType_name["compTypeSub1_name"]." ".$compTypeSub2_name ?> </a>
                  <?php
                }
              }else if($arr_compType_name["compType_other_flag"]=="1"){
                ?>
                <span class="glyph-icon icon-angle-right hidden-xs"></span>
                <hr class="hidden-sm hidden-md hidden-lg" />
                <a href="javascript:void(0);" class="no-underline"><?php echo $rs_case["case"]["compType_other"] ?> </a>
                <?php
              }
              ?>

            </div>
          </div>
        </div>
        <!-- /History Menu -->

      <!-- Case Panel 1 -->
      <div class="panel"  id="panel-form-1">
        <div class="panel-body">
          <?php
          if(count($caseOpn_cls->case_channal==0)){
            $caseOpn_cls->case_channal = $caseOpn_cls->caseChannelList();
          }
          $caseCh_id = $rs_case["case"]["caseCh_id"];
          if($caseCh_id==1 || $caseCh_id==2){
            ?>
            <!-- ถ้ารับ Case มาจาก App -->
            <div class="row">
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label">ช่องทางการรับเรื่องร้องเรียน</label>
                  <div class="col-sm-6">
                    <label class="text-data"><?php echo $caseOpn_cls->case_channal[$caseCh_id]; ?></label>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="col-xs-6 control-label control-label-r">Priority</label>
                  <div class="col-xs-6">
                    <button type="button" class="btn ra-100 disabled btn-custom " style="background-color:<?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_color') ?>"><?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_name') ?></button>
                  </div>
                </div>
              </div>
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label">Case ID</label>
                  <div class="col-sm-6">
                    <label class="text-data"><?php echo sprintf('%05d', $rs_case["case"]["case_id"]); ?></label>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label control-label-r">วันที่กรอกข้อมูล</label>
                  <div class="col-sm-6">
                    <label class="text-data"><?php echo date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"])); ?></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">

                </div>
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
                  <div class="col-sm-6">
                    <?php
                      $date_open_case = '-';
                      if($rs_case["case"]["case_open_date"]){
                        $date_open_case = date('d/m/Y', strtotime($rs_case["case"]["case_open_date"]));
                      }
                    ?>
                    <label class="text-data"><?php echo $date_open_case; ?></label>
                  </div>
                </div>
              </div>
            </div>
            <!-- /ถ้ารับ Case มาจาก App -->
            <?php
          }else{
          ?>
          <!-- ถ้าสร้าง Case จาก Web -->
          <div class="row">
            <div class="col-md-12 no-gutter">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label">ช่องทางการรับเรื่องร้องเรียน</label>
                <div class="col-sm-6">
                  <label class="text-data"><?php echo $caseOpn_cls->case_channal[$rs_case["case"]["caseCh_id"]] ?></label>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label class="col-xs-6 control-label control-label-r">Priority</label>
                <div class="col-xs-6">
                  <button type="button" class="btn ra-100 disabled btn-custom " style="background-color:<?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_color') ?>"><?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_name') ?></button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 no-gutter">
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label">Case ID</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo sprintf('%05d', $rs_case["case"]["case_id"]); ?></label>
              </div>
            </div>

            <?php
            if($method_case=="editcase"){
              $case_id_val = sprintf('%05d', $rs_case["case"]["case_id"]);
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y', strtotime($rs_case["case"]["case_open_date"]));

            }else if($method_case=="re_open_case"){
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y');
            }else{
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y');
              $case_open_date = date('d/m/Y');
            }
            ?>
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label-r">วันที่รับเรื่องตามเอกสาร</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $case_receivedoc_date ?></label>
              </div>
            </div>

          </div>
          <div class="col-md-12 no-gutter border-row-inner">
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label">เลขที่เอกสารรับเรื่อง</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $rs_case["case"]["case_receivedoc_number"] ?></label>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $case_open_date ?></label>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label">แนบเอกสารรับเรื่อง</label>
              <div class="col-sm-6">
                <a href="view_file_attach.php?reciveDoc=<?php echo $rs_case["case"]["case_id"] ?>" class="btn btn-link font-black text-data">
                  <?php echo ($rs_case["case"]["case_receivedoc_file_oldname"]!=""?'<span class="glyph-icon icon-'.$caseOpn_cls->genfileIcon($rs_case["case"]["case_receivedoc_file_ext"]).'-o icon-file-attch"></span>'.
                  $rs_case["case"]["case_receivedoc_file_oldname"]:"-") ?>
                </a>
              </div>
            </div>

          </div>
          <!-- ถ้าสร้าง Case จาก Web -->
          <?php } ?>
        </div>
      </div>
      <!-- /Case Panel 1 -->

      <?php
      $no = 0;
      $formSet_html = array();
      // print_r($arr_formSetList);
      // exit();
      foreach ($arr_formSetList as  $formSetList_panel) {
        // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
        //   echo '<br>formsetId.: '.$formSetList_panel["frmset_id"].' :: '.$formSetList_panel["frmset_name"];
        // }
        array_push($formSet_html,$caseOpn_cls->setFromList_openDetailCase($formSetList_panel["frmset_id"],$formSetList_panel["frmset_name"],$no+1));
        $no++;
        // echo $formSetList_panel["frmset_id"];
      }
      ?>

      <!-- ข้อมูลส่วนที่1 | ผู้ร้องเรียน -->
      <div class="panel" id="panel-form-a">
          <?php echo $formSet_html[0]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 1 | ผู้ร้องเรียน -->

      <!-- ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->
      <div class="panel" id="panel-form-b">
          <?php echo $formSet_html[1]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->

      <!-- ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->
      <div class="panel" id="panel-form-c">
          <?php echo $formSet_html[2]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->


      <!-- เอกสารประกอบการร้องเรียน -->
      <div class="panel" id="panel-form-4">
        <div class="panel-body">
          <div class="form-group col-md-12">
            <label class="col-xs-12 col-sm-10 control-label">เอกสารประกอบการร้องเรียน</label>
            <div class="col-xs-12 col-sm-2">
              <?php
              if(count($rs_case["case_Attachfile"])>0){
                ?>
                <a class="btn btn-black btn-dl-all glyph-icon icon-download" href="view_file_attach.php?fileZip=<?php echo $rs_case["case"]["case_id"] ?>" >Download All</a>
                <?php
              }
              ?>
              </div>
            <div class="col-xs-12 col-sm-12 col-file-list">
              <?php
              if(count($rs_case["case_Attachfile"])>0){
                $i=0;
                foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
                  ?>
                  <div class="panel" id="panel_caseAttach_file_<?php echo $i ?>">
                      <div class="panel-body panel-body-list-file">
                          <ul class="list-file col-sm-12">
                          <li class="no-gutter">
                              <div class="col-xs-12 col-sm-1">
                                <i class="glyph-icon icon-<?php echo $caseOpn_cls->genfileIcon($case_Attachfile["caseAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                              </div>
                              <div class="col-xs-12 col-sm-6">
                                <p><?php echo $case_Attachfile["caseAttach_title"] ?></p>
                                <p><?php echo $case_Attachfile["caseAttach_file_oldname"] ?></p>
                              </div>

                              <div class="col-xs-12 col-sm-3">
                                <p>Date : <?php echo date('d/m/Y',strtotime($case_Attachfile["caseAttach_create_datetime"])) ?></p>
                                <?php
                                if($rs_case["case"]["applnt_type"]!=0){
                                  $name_sender = $rs_case["case_feild"]["applntOrg_name"];
                                }else{
                                  $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
                                }
                                ?>
                                <p class="text_small">Sender : <?php echo $name_sender ?></p>
                              </div>

                              <div class="col-xs-12 col-sm-2 col-btn-file">
                                <button type="button" class="btn btn-round btn-bg22 btn-edit-file" onclick="window.open('view_file_attach.php?fileadrss=<?php echo $case_Attachfile["caseAttach_id"]?>')">
                                  <i class="my-icon icon-ico-ditp-22"></i>
                                </button>
                              </div>
                          </li>
                          </ul>
                      </div>
                  </div>
                  <?php
                    $i++;
                }
              }else{
                ?>
                <div class="panel" id="panel_caseAttach_file_<?php echo $i ?>">
                    <div class="panel-body panel-body-list-file">
                        <ul class="list-file col-sm-12">
                        <li class="no-gutter" style="text-align:center;">
                            ไม่มีเอกสารประกอบการร้องเรียน
                        </li>
                        </ul>
                    </div>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- /เอกสารประกอบการร้องเรียน -->

      <div class="panel-body">
        <div class="row row-footer-btn">
          <?php
          if($rs_case["case"]["case_status"]!="0"){
            ?>
            <!-- <button type="button" class="btn btn-print glyph-icon icon-print" id="btn-print"> 
              Print
            </button> -->
            <button type="button" class="btn btn-print glyph-icon icon-print" id="printHTML2PDF">
              PrintHTML
            </button>
            <?php
          }

          $caseCh_id = $rs_case["case"]["caseCh_id"];
          if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
            if(!($caseCh_id==1 || $caseCh_id==2)){
              ?>
              <!-- ถ้ามาจาก Web -->
              <?php
              if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_lastSave_datetime"]!=""){ //สถานะเป็น New แต่ยังไม่มีวันที่ บันทึก "case_lastSave_datetime"
                ?>
                <button  type="button" class="btn btn-custom-tool btn-float-right btn-create-createcase" onclick="case_open.entSaveType('open_case')">
                  ยืนยัน
                </button>
                <?php
              }
              if($rs_case["case"]["case_status"]=="1" && $rs_case["case"]["case_lastSave_datetime"]==""){ //สถานะเป็น New และ่มีวันที่ บันทึก "case_lastSave_datetime"
                ?>
                <button type="button" class="btn btn-custom-tool btn-float-right btn-create-savecase" onclick="case_open.entSaveType('save_case')">
                  บันทึก
                </button>
                <?php
              }
              if($rs_case["case"]["case_lastSave_datetime"]==""){ //สถานะเป็น "Waiting"
                ?>
                <button type="button" class="btn btn-custom-tool btn-float-right btn-create-savecase" onclick="case_open.entSaveType('save_case')">
                  บันทึกและรับเรื่อง
                </button>
                <?php
              }
              ?>
              
              <button type="button" class="btn btn-custom-tool btn-float-right btn-create-editcase" onclick="window.location.href='index.php?page=case_open&method=editcase&caseId=<?php echo $rs_case["case"]["case_id"] ?>';">
                แก้ไขข้อมูล
              </button>
              <input type="hidden" name="case_chanel" value="1" />
              <?php
              if($rs_case["case"]["case_status"]=="1" && $_SESSION["admin"]["empPosition"] == "3"){
                ?>
                <button  type="button" class="btn btn-custom-tool btn-float-right btn-warning btn-transfer" onclick="modal_transfer()">
                  โอนเรื่องร้องเรียน
                </button>
              <?php
              }
            }else{
              ?>
              <!-- ถ้ามาจาก App -->
              <?php
              if($rs_case["case"]["case_status"]=="1"){ //สถานะเป็น "New"
                ?>
                <button type="button" class="btn btn-custom-tool btn-float-right btn-create-createcase" onclick="case_open.entSaveType('open_case')">
                  ยืนยัน
                </button>
                <?php
              }
              if($rs_case["case"]["case_lastSave_datetime"]==""){ //สถานะเป็น "Waiting"
                ?>
                <button type="button" class="btn btn-custom-tool btn-float-right btn-create-savecase" onclick="case_open.entSaveType('save_case')">
                  บันทึกและรับเรื่อง
                </button>
                <?php
              }
              ?>
              <button type="button" class="btn btn-custom-tool btn-float-right btn-create-editcase" onclick="window.location.href='index.php?page=case_open&method=editcase&caseId=<?php echo $rs_case["case"]["case_id"] ?>';">
                แก้ไขข้อมูล
              </button>
              <input type="hidden" name="case_chanel" value="2" />
              <?php
              if($rs_case["case"]["case_status"]=="1" && $_SESSION["admin"]["empPosition"] == "3"){
                ?>
                <button  type="button" class="btn btn-custom-tool btn-float-right btn-warning btn-transfer" onclick="modal_transfer()">
                  โอนเรื่องร้องเรียน
                </button>
              <?php
              }

            }
          }
          ?>


          <?php if(($rs_case["case"]["case_status"]=="0" && $_SESSION["admin"]["empSection"] == "2" ) || $rs_case["case"]["check_transfer"]=="1"){ ?>
            <button  type="button" class="btn btn-custom-tool btn-float-right btn-warning btn-transfer" onclick="modal_transfer()">
              โอนเรื่องร้องเรียน
            </button>
          <?php  }   ?>

          <input type="hidden" class="form-control" name="case_id" value="<?php echo $rs_case["case"]["case_id"]; ?>"  />
          <input type="hidden" name="typeOfSave" class="typeOfSave" value="" />

        </div>
      </div>
    </div>
  </div>
</form>

<style>
  #html_print .text-data-size16,
  #html_print .text-data,
  #html_print .title-hero span,
  #html_print #page-title span,
  #html_print .nav-history span, #html_print .nav-history a,
  #html_print #panel-form-1 .control-label{
    font-size: 13px;
  }
  #html_print .title-hero span{
    font-size: 15px;
  }
  #html_print{
    font-size: 14px;
  }
</style>


<div class="Newprint" style="font-size: 14px; display:none;">
  <div class="row" id="html_print" style="margin-left: 0px; margin-right: 0px;">
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
              $arr_compType_name = $caseOpn_cls->getTitleCreateCase($rdi_compType_id,$rdi_compTypeSub1,$rdi_compTypeSub2);
              if($arr_compType_name["compType_name"]!=""){
                ?>
                <a href="javascript:void(0);" class="no-underline">แบบฟอร์ม <?php echo $arr_compType_name["compType_name"] ?></a>
                <?php
              }
              if($arr_compType_name["compType_other_flag"]=="0"){
                if($arr_compType_name["compTypeSub1_name"]!=""){
                  if($arr_compType_name["compTypeSub2_name"]!=""){
                    $compTypeSub2_name = $arr_compType_name["compTypeSub2_name"];
                  }else{
                    $compTypeSub2_name = "";
                  }
                  ?>
                  <span class="glyph-icon icon-angle-right hidden-xs"></span>
                  <hr class="hidden-sm hidden-md hidden-lg" />
                  <a href="javascript:void(0);" class="no-underline"><?php echo $arr_compType_name["compTypeSub1_name"]." ".$compTypeSub2_name ?> </a>
                  <?php
                }
              }else if($arr_compType_name["compType_other_flag"]=="1"){
                ?>
                <span class="glyph-icon icon-angle-right hidden-xs"></span>
                <hr class="hidden-sm hidden-md hidden-lg" />
                <a href="javascript:void(0);" class="no-underline"><?php echo $rs_case["case"]["compType_other"] ?> </a>
                <?php
              }
              ?>

            </div>
          </div>
        </div>
        <!-- /History Menu -->

      <!-- Case Panel 1 -->
      <div class="panel"  id="panel-form-1">
        <div class="panel-body" id="AddclassColumn12">
          <?php
          if(count($caseOpn_cls->case_channal==0)){
            $caseOpn_cls->case_channal = $caseOpn_cls->caseChannelList();
          }
          $caseCh_id = $rs_case["case"]["caseCh_id"];
          if($caseCh_id==1 || $caseCh_id==2){
            ?>
            <!-- ถ้ารับ Case มาจาก App -->
            <div class="row">
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label">ช่องทางการรับเรื่องร้องเรียน1234</label>
                  <div class="col-sm-6">
                    <label class="text-data" style=""><?php echo $caseOpn_cls->case_channal[$caseCh_id]; ?></label>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="col-xs-6 control-label control-label-r">Priority</label>
                  <div class="col-xs-6">
                    <button type="button" class="btn ra-100 disabled btn-custom " style="background-color:<?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_color') ?>"><?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_name') ?></button>
                  </div>
                </div>
              </div>
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label">Case ID</label>
                  <div class="col-sm-6">
                    <label class="text-data"><?php echo sprintf('%05d', $rs_case["case"]["case_id"]); ?></label>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label control-label-r">วันที่กรอกข้อมูล</label>
                  <div class="col-sm-6">
                    <label class="text-data"><?php echo date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"])); ?></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12 no-gutter">
                <div class="form-group col-md-6">

                </div>
                <div class="form-group col-md-6">
                  <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
                  <div class="col-sm-6">
                    <?php
                      $date_open_case = '-';
                      if($rs_case["case"]["case_open_date"]){
                        $date_open_case = date('d/m/Y', strtotime($rs_case["case"]["case_open_date"]));
                      }
                    ?>
                    <label class="text-data"><?php echo $date_open_case; ?></label>
                  </div>
                </div>
              </div>
            </div>
            <!-- /ถ้ารับ Case มาจาก App -->
            <?php
          }else{
          ?>
          <!-- ถ้าสร้าง Case จาก Web -->
          <div class="row">
            <div class="col-md-12 no-gutter">
              <div class="form-group col-md-6">
                <label class="col-sm-6 control-label">ช่องทางการรับเรื่องร้องเรียน</label>
                <div class="col-sm-6">
                  <label class="text-data"><?php echo $caseOpn_cls->case_channal[$rs_case["case"]["caseCh_id"]] ?></label>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label class="col-xs-6 control-label control-label-r">Priority</label>
                <div class="col-xs-6">
                  <button type="button" class="btn ra-100 disabled btn-custom " style="background-color:<?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_color') ?>"><?php echo $caseOpn_cls->priorityData($rs_case["case"]["case_priority"],'casePrt_name') ?></button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 no-gutter">
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label">Case ID</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo sprintf('%05d', $rs_case["case"]["case_id"]); ?></label>
              </div>
            </div>

            <?php
            if($method_case=="editcase"){
              $case_id_val = sprintf('%05d', $rs_case["case"]["case_id"]);
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y', strtotime($rs_case["case"]["case_open_date"]));

            }else if($method_case=="re_open_case"){
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y', strtotime($rs_case["case"]["case_receivedoc_date"]));
              $case_open_date = date('d/m/Y');
            }else{
              $case_id_val = "";
              $case_receivedoc_date = date('d/m/Y');
              $case_open_date = date('d/m/Y');
            }
            ?>
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label-r">วันที่รับเรื่องตามเอกสาร</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $case_receivedoc_date ?></label>
              </div>
            </div>

          </div>
          <div class="col-md-12 no-gutter border-row-inner">
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label">เลขที่เอกสารรับเรื่อง</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $rs_case["case"]["case_receivedoc_number"] ?></label>
              </div>
            </div>
            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label-r">วันที่เปิดเคส</label>
              <div class="col-sm-6">
                <label class="text-data"><?php echo $case_open_date ?></label>
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-sm-6 control-label control-label">แนบเอกสารรับเรื่อง</label>
              <div class="col-sm-6">
                <a href="view_file_attach.php?reciveDoc=<?php echo $rs_case["case"]["case_id"] ?>" class="btn btn-link font-black text-data">
                  <?php echo ($rs_case["case"]["case_receivedoc_file_oldname"]!=""?'<span class="glyph-icon icon-'.$caseOpn_cls->genfileIcon($rs_case["case"]["case_receivedoc_file_ext"]).'-o icon-file-attch"></span>'.
                  $rs_case["case"]["case_receivedoc_file_oldname"]:"-") ?>
                </a>
              </div>
            </div>

          </div>
          <!-- ถ้าสร้าง Case จาก Web -->
          <?php } ?>
        </div>
      </div>
      <!-- /Case Panel 1 -->

      <?php
      $no = 0;
      $formSet_html = array();
      // print_r($arr_formSetList);
      // exit();
      foreach ($arr_formSetList as  $formSetList_panel) {
        // if (in_array($_SESSION['admin']['empId'], array('1', '7'))) {
        //   echo '<br>formsetId.: '.$formSetList_panel["frmset_id"].' :: '.$formSetList_panel["frmset_name"];
        // }
        array_push($formSet_html,$caseOpn_cls->setFromList_openDetailCase($formSetList_panel["frmset_id"],$formSetList_panel["frmset_name"],$no+1));
        $no++;
      }
      ?>

      <!-- ข้อมูลส่วนที่1 | ผู้ร้องเรียน -->
      <div class="panel" id="panel-form-a">
          <?php echo $formSet_html[0]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 1 | ผู้ร้องเรียน -->
      <div class="html2pdf__page-break"></div>

      <!-- ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->
      <div class="panel" id="panel-form-b">
          <?php echo $formSet_html[1]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 2 | บริษัทต่างชาติผู้ถูกร้องเรียน -->
      <div class="html2pdf__page-break"></div>

      <!-- ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->
      <div class="panel" id="panel-form-c">
          <?php echo $formSet_html[2]; ?>
      </div>
      <!-- /ข้อมูลส่วนที่ 3 | รายละเอียดเรื่องร้องเรียน -->


      <!-- เอกสารประกอบการร้องเรียน -->
      <div class="panel" id="panel-form-4">
        <div class="panel-body">
          <div class="form-group col-md-12">
            <label class="col-xs-12 col-sm-10 control-label">เอกสารประกอบการร้องเรียน</label>
            <div class="col-xs-12 col-sm-2">
              <?php
              if(count($rs_case["case_Attachfile"])>0){
                ?>
                <a class="btn btn-black btn-dl-all glyph-icon icon-download" href="view_file_attach.php?fileZip=<?php echo $rs_case["case"]["case_id"] ?>" >Download All</a>
                <?php
              }
              ?>
              </div>
            <div class="col-xs-12 col-sm-12 col-file-list">
              <?php
              if(count($rs_case["case_Attachfile"])>0){
                $i=0;
                foreach ($rs_case["case_Attachfile"] as $case_Attachfile) {
                  ?>
                  <div class="panel" id="panel_caseAttach_file_<?php echo $i ?>">
                      <div class="panel-body panel-body-list-file">
                          <ul class="list-file col-sm-12">
                          <li class="no-gutter">
                              <div class="col-xs-12 col-sm-1">
                                <i class="glyph-icon icon-<?php echo $caseOpn_cls->genfileIcon($case_Attachfile["caseAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                              </div>
                              <div class="col-xs-12 col-sm-6">
                                <p><?php echo $case_Attachfile["caseAttach_title"] ?></p>
                                <p><?php echo $case_Attachfile["caseAttach_file_oldname"] ?></p>
                              </div>

                              <div class="col-xs-12 col-sm-3">
                                <p>Date : <?php echo date('d/m/Y',strtotime($case_Attachfile["caseAttach_create_datetime"])) ?></p>
                                <?php
                                if($rs_case["case"]["applnt_type"]!=0){
                                  $name_sender = $rs_case["case_feild"]["applntOrg_name"];
                                }else{
                                  $name_sender = $rs_case["case_feild"]["applnt_firstname"]." ".$rs_case["case_feild"]["applnt_lastname"];
                                }
                                ?>
                                <p class="text_small">Sender : <?php echo $name_sender ?></p>
                              </div>

                              <div class="col-xs-12 col-sm-2 col-btn-file">
                                <button type="button" class="btn btn-round btn-bg22 btn-edit-file" onclick="window.open('view_file_attach.php?fileadrss=<?php echo $case_Attachfile["caseAttach_id"]?>')">
                                  <i class="my-icon icon-ico-ditp-22"></i>
                                </button>
                              </div>
                          </li>
                          </ul>
                      </div>
                  </div>
                  <?php
                    $i++;
                }
              }else{
                ?>
                <div class="panel" id="panel_caseAttach_file_<?php echo $i ?>">
                    <div class="panel-body panel-body-list-file">
                        <ul class="list-file col-sm-12">
                        <li class="no-gutter" style="text-align:center;">
                            ไม่มีเอกสารประกอบการร้องเรียน
                        </li>
                        </ul>
                    </div>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <button id="printHTML2PDF">123</button> -->

<?php include('template/modal_history_applnt.php'); ?>
<?php include('template/modal_history_complnt.php'); ?>
<?php include('template/modal_transfer.php'); ?>

<!-- <link rel="stylesheet" type="text/css" href="css/print.css">
<script type="text/javascript" src="js/jQuery.print.js"></script> -->

<!-- <link rel="stylesheet" type="text/css" href="css/print.min.css"> -->
<!-- <script type="text/javascript" src="js/print.min.js"></script> -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script>
  case_open = new case_open_class();
  case_detail = new case_detail_class();

  $(document).ready(function(){
    $('#AddclassColumn12 .text-data').first().parent().removeClass('col-sm-6');
    $('#AddclassColumn12 .text-data').first().parent().addClass('col-sm-12');

    var element = document.getElementById('html_print');
    var opt = {
      margin:       0,
      filename:     'AllRequest.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait'}
    };

    $('#printHTML2PDF').on('click', function(){
      var element2 = element;
      html2pdf().set(opt).from(element2).save();
    });
  });

  $(function(){
    $("#btn-print").click(function(){
      $(".body-content").print({
        	globalStyles: true,
        	mediaPrint: false,
        	stylesheet: null,
        	noPrintSelector: ".no-print",
        	iframe: true,
        	append: null,
        	prepend: null,
        	manuallyCopyFormValues: true,
        	deferred: $.Deferred(),
        	timeout: 750,
        	title: null,
        	doctype: '<!doctype html>'
    	});
    });

  });
</script>
