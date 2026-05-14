
<?php $statusBtn = "";
$showStatusBtn = "display:none";
if(count($case_processInit_idx[0])==0){
  $statusBtn = 'btn-countdown-time-pending';
  $statusTxt = 'In Process';
  $clock_container = "timestop";
  $timeamount = "xx วัน xx ชั่วโมง xx นาที";
  $checkComplete = '';
  $tooltip = '';
}else if($case_processInit_idx[0]["process_status"]==0){
  $showStatusBtn = "";
  if($case_processInit_idx[0]["process_over_datetime"]!="" && time()>$case_processInit_idx[0]["process_over_datetime"]){
    $statusBtn = 'btn-countdown-time-over';
    $statusTxt = 'Overdue';
    $clock_container = "clock";
    $timeamount = "xx วัน xx ชั่วโมง xx นาที";
    $checkComplete = '';
    $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[0]["process_over_note"].'"';
  }else{
    $statusBtn = 'btn-countdown-time-pending';
    $statusTxt = 'In Process';
    $clock_container = "clock";
    $timeamount = "xx วัน xx ชั่วโมง xx นาที";
    $checkComplete = '';
  }
  if($case_processInit_idx[0]["process_save_datetime_ctd"]=="0000-00-00"){
    $statusBtn = 'btn-countdown-time-pending';
    $statusTxt = 'In Process';
    $clock_container = "timestop";
    $timeamount = "00 นาที";
    $checkComplete = '';
  }
}else{
  $showStatusBtn = "";
  $time_over = $case_processInit_idx[0]["process_over_datetime"];
  if($case_processInit_idx[0]["process_status"]==1){
    $time_compare = strtotime($case_processInit_idx[0]["process_complete_datetime"]);
  }else{
    $time_compare = time();
  }
  if($time_compare>$time_over){
    $statusBtn = 'btn-countdown-time-over';
    $statusTxt = 'Overdue';
    $clock_container = "timestop";
    $checkComplete = '<i class="glyph-icon icon-check"></i>';
    $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[0]["process_over_note"].'"';
  }else{
    $statusBtn = 'btn-countdown-time-success';
    $statusTxt = 'Complete';
    $clock_container = "timestop";
    $checkComplete = '<i class="glyph-icon icon-check"></i>';
  }
  $datatimeGen = $caseDtl_cls->getDateTimeData($case_processInit_idx[0]["process_save_datetime"],$case_processInit_idx[0]["process_complete_datetime"]);

  echo $timeamount = ($datatimeGen["days"]>0?$datatimeGen["days"]." วัน ":"").($datatimeGen["hours"]>0?$datatimeGen["hours"]." ชั่วโมง ":"").($datatimeGen["minutes"]>0?$datatimeGen["minutes"]." นาที ":"");
  if($timeamount==""){
    $timeamount = "01 นาที";
  }
}
?>
<!-- กระบวนการดำเนินการ (แจ้งผู้ร้องเรียนว่าได้รับเรื่องร้องเรียนเรียบร้อยแล้ว)-->
<div class="panel panel-form-6" >
  <div class="panel-body">
    <div class="card">
      <div class="card-header col-sm-12 col-md-12" role="tab" id="heading_process_1">
        <a data-toggle="collapse" class="btn-collape-process no-gutter" href="#collapse_process_1" aria-expanded="true" aria-controls="collapse_process_1">
          <div class="col-lg-5">
            <button type="button" class="btn btn-round disabled btn-check-success"><?php echo $checkComplete ?></button>
            <button type="button" class="btn ra-100 btn-countdown-time <?php echo $statusBtn ?>" style="margin-top-3px; <?php echo $showStatusBtn ?>" rel="<?php echo $case_processInit_idx[0]["process_save_datetime_ctd"] ?>" <?php echo $tooltip ?>>
              <span><?php echo $statusTxt ?> | </span>
              <span class="<?php echo $clock_container ?>" id="clock<?php echo $case_processInit_idx[0]["process_id"] ?>"><?php echo $timeamount ?></span>
            </button>
          </div>
          <?php
          $processTypeName_init = $caseDtl_cls->caseProcessTypeList("all",$caseDtl_cls->admin_section);
          ?>
          <span class="col-xs-12 col-lg-6 span-title"><?php echo $processTypeName_init[1] ?></span>

          <i class="glyph-icon icon-angle-<?php if($case_processInit_idx[0]['process_status']!='1'){echo "up";}else{echo "down";} ?> icon-collape"></i>
        </a>
      </div>
      <?php
      if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
        ?>
        <div id="collapse_process_1" class="collapse  <?php if($case_processInit_idx[0]['process_status']!='1'){echo "in";} ?>" aria-labelledby="headingOne">
          <form class="frm_case_process" name="frm_case_process" enctype="multipart/form-data" method="post" action="/" target="iframe-data">
            <div class="card-block" id="card-block-<?php echo $case_processInit_idx[0]["process_id"] ?>">
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                  <input type="hidden" name="process_id" value="<?php echo ($case_processInit_idx[0]["process_id"]!=""?$case_processInit_idx[0]["process_id"]:"0") ?>" />
                  <input type="hidden" name="process_elm" value="collapse_process_1" />
                  <label class="control-label">แจ้งผ่านช่องทาง</label>
                </div>
              </div>
              <?php
              if($rs_case["case"]["caseCh_id"]!="1" && $rs_case["case"]["caseCh_id"]!="2"){ //-- กรณีไม่ได้สร้างเรื่องร้องเรียนจาก Web หรือ App --//
                if(count($rs_case["process_tel"][2][$case_processInit_idx[0]["process_id"]])==0){
                  ?>
                  <div class="row row_tel_proc row_proc">
                    <div class="col-lg-12">
                      <div class="form-group col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="procPropTel2" class="procPropTel procProp" value="1">
                            โทรศัพท์
                          </label>
                        </div>
                      </div>
                      <div class="form-group col-lg-5">
                      <input type="hidden" class="form-control" name="procPropTel_id_2[]"  />
                        <input type="text" class="form-control" name="procPropTel_number_2[]"  />
                      </div>
                      <div class="form-group col-lg-2">
                        <div class="input-group">
                        <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_2[]" >
                          <span class="input-group-addon input-group-addon-calendar bg-black">
                            <i class="glyph-icon icon-calendar"></i>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-lg-2">
                        <div class="input-group">
                        <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_2[]" >
                          <span class="input-group-addon bg-black">
                            <i class="glyph-icon icon-clock-o"></i>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-lg-1">
                        <a href="javascript:void(0);" class="btn-add-tel" rel="2">
                          <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <?php
                }else{
                  $i=0;
                  foreach($rs_case["process_tel"][2][$case_processInit_idx[0]["process_id"]] as $process_tel_group) {
                    ?>
                    <div class="row row_tel_proc row_proc">
                      <div class="col-lg-12">
                        <div class="form-group col-lg-2">
                          <?php
                          if($i==0){
                           ?>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="procPropTel2"  class="procPropTel procProp" value="1" <?php echo ($case_processInit_idx[0]["procPropTel2_status"]==1?"checked":"")?>>
                              โทรศัพท์
                            </label>
                          </div>
                          <?php
                          }else{
                            echo "&nbsp";
                          }
                          ?>
                        </div>
                        <div class="form-group col-lg-5">
                          <input type="hidden" class="form-control" name="procPropTel_id_2[]" value="<?php echo $process_tel_group["procPropTel_id"]?>" />
                          <input type="text" class="form-control" name="procPropTel_number_2[]" value="<?php  if($process_tel_group["procPropTel_type"]==2){ echo $process_tel_group["procPropTel_number"];} ?>"  />
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_2[]"  value="<?php if($process_tel_group["procPropTel_type"]==2){ echo (($process_tel_group["procPropTel_datetime"]!="" && $process_tel_group["procPropTel_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_tel_group["procPropTel_datetime"])):"");} ?>" >
                            <span class="input-group-addon input-group-addon-calendar bg-black">
                              <i class="glyph-icon icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_2[]"  value="<?php if($process_tel_group["procPropTel_type"]==2){ echo (($process_tel_group["procPropTel_datetime"]!="" && $process_tel_group["procPropTel_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_tel_group["procPropTel_datetime"])):"");} ?>" >
                            <span class="input-group-addon bg-black">
                              <i class="glyph-icon icon-clock-o"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-1">
                          <?php
                          if((count($rs_case["process_tel"][2][$case_processInit_idx[0]["process_id"]])>1 && $i<count($rs_case["process_tel"][2][$case_processInit_idx[0]["process_id"]])-1)){
                           ?>
                            <a href="javascript:void(0);" class="btn-rm-tel" rel="<?php echo $process_tel_group["procPropTel_id"]?>">
                              <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                            </a>
                            <?php
                          }else{
                            ?>
                             <a href="javascript:void(0);" class="btn-add-tel" rel="2">
                               <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                             </a>
                             <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                    $i++;
                  }
                }
                ?>

                <hr />

                <?php
                if(count($rs_case["process_fax"][2][$case_processInit_idx[0]["process_id"]])==0){
                  ?>
                  <div class="row  row_fax_proc row_proc">
                    <div class="col-lg-12">
                      <div class="form-group col-lg-2">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="procPropFax2" class="procPropFax procProp" value="1">
                            FAX
                          </label>
                        </div>
                      </div>
                      <div class="form-group col-lg-5">
                        <input type="hidden" class="form-control" name="procPropFax_id_2[]" />
                        <input type="text" class="form-control" name="procPropFax_number_2[]"  />
                      </div>
                      <div class="form-group col-lg-2">
                        <div class="input-group">
                        <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_2[]" >
                          <span class="input-group-addon input-group-addon-calendar bg-black">
                            <i class="glyph-icon icon-calendar"></i>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-lg-2">
                        <div class="input-group">
                        <input type="text" class="form-control bootstrap-timepicker"  name="procPropFax_time_2[]" >
                          <span class="input-group-addon bg-black">
                            <i class="glyph-icon icon-clock-o"></i>
                          </span>
                        </div>
                      </div>
                      <div class="form-group col-lg-1">
                        <a href="javascript:void(0);" class="btn-add-fax" rel="2">
                          <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <?php
                }else{
                  $i=0;
                  foreach($rs_case["process_fax"][2][$case_processInit_idx[0]["process_id"]] as $process_fax_group) {
                    ?>
                    <div class="row  row_fax_proc row_proc">
                      <div class="col-lg-12">
                        <div class="form-group col-lg-2">
                          <?php
                          if($i==0){
                           ?>
                           <div class="checkbox">
                             <label>
                               <input type="checkbox" name="procPropFax2" class="procPropFax procProp" value="1" <?php echo ($case_processInit_idx[0]["procPropFax2_status"]==1?"checked":"")?>>
                               FAX
                             </label>
                           </div>
                           <?php
                          }else{
                            echo "&nbsp";
                          }
                          ?>
                        </div>
                        <div class="form-group col-lg-5">
                          <input type="hidden" class="form-control" name="procPropFax_id_2[]" value="<?php echo $process_fax_group["procPropFax_id"]; ?>" />
                          <input type="text" class="form-control" name="procPropFax_number_2[]" value="<?php if($process_fax_group["procPropFax_type"]==2){ echo $process_fax_group["procPropFax_number"];} ?>"  />
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_2[]" value="<?php if($process_fax_group["procPropFax_type"]==2){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_fax_group["procPropFax_datetime"])):"");} ?>" >
                            <span class="input-group-addon input-group-addon-calendar bg-black">
                              <i class="glyph-icon icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-timepicker" name="procPropFax_time_2[]" value="<?php if($process_fax_group["procPropFax_type"]==2){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_fax_group["procPropFax_datetime"])):"");} ?>" >
                            <span class="input-group-addon bg-black">
                              <i class="glyph-icon icon-clock-o"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-1">
                          <?php
                          if((count($rs_case["process_fax"][2][$case_processInit_idx[0]["process_id"]])>1 && $i<count($rs_case["process_fax"][2][$case_processInit_idx[0]["process_id"]])-1)){
                           ?>
                             <a href="javascript:void(0);" class="btn-rm-fax" rel="<?php echo $process_fax_group["procPropFax_id"]?>">
                               <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                             </a>
                            <?php
                          }else{
                            ?>
                              <a href="javascript:void(0);" class="btn-add-fax" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                             <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                    $i++;
                  }
                }
                ?>
                <hr />
                <?php
                if(count($rs_case["process_email"][2][$case_processInit_idx[0]["process_id"]])==0){
                  ?>
                  <div class="row row_email_proc row_proc">
                    <div class="col-lg-12">
                      <div class="form-group col-lg-2">

                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="procPropEmail2" class="procPropEmail procProp" value="1" >
                              EMAIL
                            </label>
                          </div>
                      </div>
                      <div class="form-group col-lg-2" style="margin-bottom:0;">
                        <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>
                      </div>
                      <div class="form-group col-lg-7">
                        <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_2[]" placeholder="email@gmail.com" value="<?php echo $rs_case["case_feild"]["applnt_email"] ?>"  />
                      </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                        &nbsp
                      </div>
                      <div class="form-group col-lg-2" style="margin-bottom:0;">
                        <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>
                      </div>
                      <div class="form-group col-lg-7">
                        <input type="hidden" class="form-control" name="procPropEmail_id_2[]" />
                        <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_2[]" value="แจ้งผู้ร้องเรียนว่าได้รีบเรื่องร้องเรียนแล้ว"  />
                      </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                      </div>
                      <div class="form-group col-lg-2" style="margin-bottom:0;">
                        <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                      </div>
                      <div class="form-group col-lg-7">
                        <textarea name="procPropEmail_message_2[]" rows="3" id="ckeditor_<?php echo $case_processInit_idx[0]["process_id"] ?>_2_<?php echo $i+1 ?>" class="ckeditor form-control textarea-no-resize procPropEmail_message" placeholder="...">
                        <p>
                        ตามที่สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ ได้รับเรื่องร้องเรียนจากผู้ร้องเรียน
                        </p>
                        <p>
                        ในการนี้ สํานักสารสนเทศและการบริการการค้าระหว่างประเทศ ได้พิจารณารับเรื่องร้องเรียนแล้ว
                        </p>
                        <p>
                        ขอแสดงความนับถือ<br />
                          <?php echo $res_emp["emp_firstname"]." ".$res_emp["emp_lastname"] ?><br />
                        สํานักสารสนเทศและการบริการการค้าระหว่างประเทศ<br />
                        กรมส่งเสริมการค้าระหว่างประเทศ<br />
                        </p>
                      </textarea>
                    </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                      </div>
                      <div class="form-group col-sm-12 col-md-12 col-lg-2" style="margin-bottom:0;">
                        <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>
                      </div>
                      <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">
                        <input type="file" name="procPropEmail_file_2[]" id="procPropEmail_file_<?php echo $case_processInit_idx[0]["process_id"] ?>_2_<?php echo $i+1 ?>" class=" form-control procPropEmail_file" multiple />
                      </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                    <div class="col-lg-12 contain-email-btn1">
                      <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_2[]" value="<?php echo date("Y-m-d H:i:s"); ?>"  />
                      <div class="col-lg-8 hidden-xs hidden-sm hidden-md "></div>
                      <div class="col-lg-3">
                        <button type="button" class="btn btn-default btn-send-email" rel="2">
                          <i class="glyph-icon icon-envelope-o"></i>
                          Send
                        </button>
                      </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                  </div>
                  <?php
                }else{
                  $i=0;
                  foreach($rs_case["process_email"][2][$case_processInit_idx[0]["process_id"]] as $process_email_group) {
                    ?>
                    <?php
                    if($i>0){
                     ?>
                    <div class="col-lg-12  no-gutter">
                      <div class="col-lg-2 hidden-xs hidden-sm hidden-md ">
                        &nbsp;
                      </div>
                      <div class="col-lg-10">
                        <hr>
                      </div>
                    </div>
                    <?php
                   }
                   ?>
                    <div class="row row_email_proc row_proc">
                      <div class="col-lg-12">
                        <div class="form-group col-lg-2">
                          <?php
                          if($i==0){
                           ?>
                           <div class="checkbox">
                             <label>
                               <input type="checkbox" name="procPropEmail2" class="procPropEmail procProp" value="1" <?php echo ($case_processInit_idx[0]["procPropEmail2_status"]==1?"checked":"")?>>
                               EMAIL
                             </label>
                           </div>
                           <?php
                          }else{
                            echo "&nbsp";
                          }
                          ?>
                        </div>
                        <div class="form-group col-lg-2" style="margin-bottom:0;">
                          <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>
                        </div>
                        <div class="form-group col-lg-7">
                          <input type="hidden" class="form-control" name="procPropEmail_id_2[]" value="<?php echo $process_email_group["procPropEmail_id"] ?>" />
                          <input type="text" readonly class="form-control procPropEmail_address" name="procPropEmail_address_2[]" readonly value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_address"];} ?>"  />
                        </div>
                        <div class="col-md-1 hidden-xs hidden-sm hidden-md  ">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md  ">
                          &nbsp
                        </div>
                        <div class="form-group col-lg-2" style="margin-bottom:0;">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>
                        </div>
                        <div class="form-group col-lg-7">
                          <input type="text" readonly class="form-control procPropEmail_subject" name="procPropEmail_subject_2[]" readonly value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_subject"];} ?>"  />
                        </div>
                        <div class="col-md-1 hidden-xs hidden-sm hidden-md  ">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md  ">
                        </div>
                        <div class="form-group col-lg-2" style="margin-bottom:0;">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                        </div>
                        <div class="form-group col-lg-7">
                          <textarea name="procPropEmail_message_2[]" readonly rows="3" id="ckeditor_<?php echo $case_processInit_idx[0]["process_id"] ?>_2_<?php echo $i+1 ?>" class="ckeditor form-control textarea-no-resize procPropEmail_message" readonly ><?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_message"];} ?></textarea>
                        </div>
                        <div class="col-md-1 hidden-xs hidden-sm hidden-md  ">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md  ">
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-2 form-group-email-file" style="margin-bottom:0;">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 col-lg-7">
                          <?php
                          if(count($process_email_group["email_attach"])>0){
                            foreach ($process_email_group["email_attach"] as $email_attach) {
                              ?>
                              <a href="javascirpt:;" onclick="window.open('view_file_attach.php?mailfileadrss=<?php echo $email_attach["mailAttach_id"] ?>');">
                                <div class="panel-body panel-body-list-file" style="padding:10px;">
                                  <ul class="list-file col-sm-12">
                                      <li class="no-gutter">
                                        <div class="col-xs-12 col-sm-1" style="margin-top:10px;">
                                          <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($email_attach["mailAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                                        </div>
                                        <div class="col-xs-12 col-sm-9 list_file_name" style="margin-top:10px;" >
                                          <p><?php echo $email_attach["mailAttach_file_oldname"] ?></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-btn-file">
                                          <button type="button" class="btn btn-round btn-bg22 btn-edit-file">
                                            <i class="my-icon icon-ico-ditp-22"></i>
                                          </button>
                                        </div>
                                      </li>
                                    </ul>
                                </div>
                              </a>
                              <?php
                            }
                          }else{
                            echo '<span style="color:#ccc;">ไม่มีไฟล์แนบ</span>';
                          }
                          ?>
                        </div>
                        <div class="col-md-1 hidden-xs hidden-sm hidden-md  ">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_2[]" value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_datetime"];} ?>"  />
                        <div class="form-group col-md-4 hidden-xs hidden-sm hidden-md"></div>
                        <div class="col-xs-6 col-lg-4">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">วันที่ <?php echo date("d/m/Y",strtotime($process_email_group["procPropEmail_datetime"])) ?></label>
                        </div>
                        <div class="col-xs-6 col-lg-3">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">เวลา <?php echo date("H:i น.",strtotime($process_email_group["procPropEmail_datetime"])) ?></label>
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-7 col-lg-offset-4">
                          <?php
                          if(!(count($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]])-1)){

                            ?>
                              <a href="javascript:void(0);" class="btn-add-email" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                             <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <?php
                    $i++;
                  }
                }
                ?>
                <hr />
                <?php
                if(count($rs_case["process_mail"][2][$case_processInit_idx[0]["process_id"]])==0){
                  ?>
                  <div class="row row_tracking_proc row_proc">
                    <div class="col-lg-12">
                      <div class="form-group col-lg-2" style="margin-bottom:0px;">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="procPropMail2" class="procPropMail">

                            จดหมาย
                          </label>
                        </div>
                      </div>
                      <div class="form-group col-lg-2" style="margin-bottom:0px;">
                        <label class="control-label text-data-light text-data-size16 text-data-gray">เลขที่เอกสารออก</label>
                      </div>
                      <div class="form-group col-lg-3" style="margin-bottom:0px;">
                        <input type="hidden" class="form-control" name="procPropMail_id_2[]" />
                        <input type="text" class="form-control" name="procPropMail_number_2[]"   />
                        <input type="hidden" name="procPropMail_type_2[]" value="2" />
                      </div>
                      <div class="form-group col-lg-4" style="margin-bottom:0px;">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                              <span class="fileinput-new">Browse</span>
                              <span class="fileinput-exists">Change</span>
                              <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                            </span>
                        </div>
                      </div>
                      <div class="form-group col-lg-1" style="margin-bottom:0px;">
                      </div>

                      <div class="row">
                        <div class="col-lg-12">

                          <div class="form-group col-lg-2">
                          </div>
                          <div class="form-group col-lg-2">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>
                          </div>
                          <div class="form-group col-lg-3">
                            <input type="text" class="form-control" name="procPropMail_tracking_2[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_2[]" >
                              <span class="input-group-addon input-group-addon-calendar bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_tracking_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascritp:void(0);" class="btn-add-tracking" rel="2">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                }else{
                $i=0;
                  foreach($rs_case["process_mail"][2][$case_processInit_idx[0]["process_id"]] as $process_mail_group) {
                    if($process_mail_group["procPropMail_type"]==2){
                    ?>
                      <div class="row row_tracking_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2" style="margin-bottom:0px;">

                            <?php
                            if($i==0){
                             ?>
                             <div class="checkbox">
                               <label>
                                 <input type="checkbox" value="1" name="procPropMail2" class="procPropMail" <?php echo ($case_processInit_idx[0]["procPropMail2_status"]==1?"checked":"")?>>

                                 จดหมาย
                               </label>
                             </div>
                             <?php
                            }else{
                              echo "&nbsp";
                            }
                            ?>
                          </div>
                          <div class="form-group col-lg-2" style="margin-bottom:0px;">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">เลขที่เอกสารออก</label>
                          </div>
                          <div class="form-group col-lg-3" style="margin-bottom:0px;">
                            <input type="hidden" class="form-control" name="procPropMail_id_2[]" value="<?php echo $process_mail_group["procPropMail_id"] ?>" />
                            <input type="text" class="form-control" name="procPropMail_number_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo $process_mail_group["procPropMail_number"];} ?>" />
                            <input type="hidden" name="procPropMail_type_2[]" value="2" />
                          </div>
                          <div class="form-group form-group-file col-xs-12 <?php if($case_processInit_idx[0]["process_status"]=="0" && $process_mail_group["procPropMail_file_path"]!=""){ echo "col-lg-3 nopadding";}else{echo "col-lg-4";} ?>" style="margin-bottom:0px;">
                            <?php
                            if($process_mail_group["procPropMail_file_path"]==""){
                              ?>
                              <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                  <div class="form-control" data-trigger="fileinput">
                                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                      <span class="fileinput-filename"><?php if($process_mail_group["procPropMail_type"]==2){ echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); } ?></span>
                                  </div>
                                  <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Browse</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                                  </span>
                              </div>
                              <?php
                            }else{
                              ?>
                                 <a href="view_file_attach.php?fileprocessmail=<?php echo $process_mail_group["procPropMail_id"] ?>" target="_blank">
                                   <div class="panel-body panel-body-list-file file-process" >
                                      <div class="col-xs-2 col-md-3">
                                        <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($process_mail_group["procPropMail_file_ext"]) ?>-o icon-thumb-file"></i>
                                      </div>
                                      <div class="col-xs-10  col-md-9">
                                        <p class="shot-text"><?php echo $process_mail_group["procPropMail_file_oldname"] ?></p>
                                      </div>
                                   </div>
                                 </a>
                                 <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="display:none;" rel="col-lg-4">
                                     <div class="form-control" data-trigger="fileinput">
                                         <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                         <span class="fileinput-filename"><?php if($process_mail_group["procPropMail_type"]==2){ echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); } ?></span>
                                     </div>
                                     <span class="input-group-addon btn btn-default btn-file">
                                       <span class="fileinput-new">Browse</span>
                                       <span class="fileinput-exists">Change</span>
                                       <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                                     </span>
                                 </div>
                              <?php
                            }
                            ?>
                          </div>
                          <?php
                          if($case_processInit_idx[0]["process_status"]=="0" && $process_mail_group["procPropMail_file_path"]!=""){
                            ?>
                            <div class="col-xs-1 form-group-file-btn nopadding">
                              <button type="button" class="btn btn-edit-file-process glyph-icon icon-pencil-square-o"></button>
                            </div>
                            <?php
                          }
                          ?>
                          <div class="form-group col-lg-1" style="margin-bottom:0px;">
                          </div>

                          <div class="row">
                            <div class="col-lg-12">

                              <div class="form-group col-lg-2">
                              </div>
                              <div class="form-group col-lg-2">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>
                              </div>
                              <div class="form-group col-lg-3">
                                <input type="text" class="form-control" name="procPropMail_tracking_2[]"  value="<?php if($process_mail_group["procPropMail_type"]==2){ echo $process_mail_group["procPropMail_tracking"];} ?>"  />
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_tracking"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_mail_group["procPropMail_tracking_datetime"])):"");} ?>" >
                                  <span class="input-group-addon input-group-addon-calendar bg-black">
                                    <i class="glyph-icon icon-calendar"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_tracking_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_tracking"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_mail_group["procPropMail_tracking_datetime"])):"");} ?>" >
                                  <span class="input-group-addon bg-black">
                                    <i class="glyph-icon icon-clock-o"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-1">
                                <?php
                                if((count($rs_case["process_mail"][2][$case_processInit_idx[0]["process_id"]])>1 && $i<count($rs_case["process_mail"][2][$case_processInit_idx[0]["process_id"]])-1)){
                                 ?>
                                 <a href="javascritp:void(0);" class="btn-rm-tracking"  rel="<?php echo $process_mail_group["procPropMail_id"]?>">
                                   <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                 </a>
                                  <?php
                                }else{
                                  ?>
                                  <a href="javascritp:void(0);" class="btn-add-tracking" rel="2">
                                    <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                  </a>
                                  <?php
                                }
                                ?>
                              </div>


                            </div>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                    $i++;
                  }
                }
              }else{ //-- กรณีสร้างเรื่องร้องเรียนจาก Web หรือ App --//
                if(count($rs_case["process_app"][$case_processInit_idx[0]["process_id"]])==0){
                  ?>
                  <div class="row row_app_proc">
                    <div class="col-lg-12">
                      <div class="form-group col-md-4">

                        <input type="hidden" name="procPropApp_id[]" value="" />
                        <input type="hidden" name="procPropApp_member_id[]" value="<?php echo $rs_case["case"]["case_createBy_id"] ?>" />
                          <div class="checkbox" style="margin-top:7px;">
                            <label>

                              <input type="checkbox" name="procPropApp" class="procPropApp" value="1" checked >
                              DITP Care Application
                            </label>
                          </div>
                      </div>
                      <div class="form-group col-md-2">
                        <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                      </div>
                      <div class="form-group col-md-6">
                        <input name="procPropApp_message[]" class="form-control" value="แจ้งผู้ร้องเรียนว่าได้รับเรื่องร้องเรียนเรียบร้อยแล้ว" />
                      </div>
                      <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                      </div>
                    </div>
                  </div>
                  <?php
                }else{
                $i=0;
                  foreach($rs_case["process_app"][$case_processInit_idx[0]["process_id"]] as $process_app_group) {
                    ?>
                    <div class="row row_app_proc">
                      <div class="col-lg-12">
                        <div class="form-group col-md-4">
                          <?php
                          if($i==0){
                           ?>
                           <input type="hidden" name="procPropApp_id[]" value="<?php echo $process_app_group["procPropApp_id"] ?>" />
                           <input type="hidden" name="procPropApp_member_id[]" value="<?php echo $rs_case["case"]["case_createBy_id"] ?>" />
                           <div class="checkbox" style="margin-top:7px;">
                             <label>
                               <input type="checkbox" name="procPropApp" class="procPropApp" value="1" <?php echo ($case_processInit_idx[0]["procPropApp_status"]==1?"checked":"")?>>
                               DITP Care Application
                             </label>
                           </div>
                           <?php
                          }else{
                            echo "&nbsp";
                          }
                          ?>
                        </div>
                        <div class="form-group col-md-2">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                        </div>
                        <div class="form-group col-md-6">
                          <input name="procPropApp_message[]" class="form-control" readonly value="<?php echo $process_app_group["procPropApp_message"]; ?>" />
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <input type="hidden" class="form-control" name="procPropApp_datetime[]" value="<?php if($process_app_group["procPropApp_type"]==2){ echo $process_app_group["procPropApp_datetime"];} ?>"  />
                        <div class="form-group col-md-6 hidden-xs"></div>
                        <div class="col-xs-6 col-lg-3">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">วันที่ <?php echo date("d/m/Y",strtotime($process_app_group["procPropApp_datetime"])) ?></label>
                        </div>
                        <div class="col-xs-6 col-lg-3">
                          <label class="control-label text-data-light text-data-size16 text-data-gray">เวลา <?php echo date("H:i น.",strtotime($process_app_group["procPropApp_datetime"])) ?></label>
                        </div>
                      </div>
                    </div>
                    <?php
                    $i++;
                  }
                }
              }
              ?>
              <input type="hidden" name="process_type_id" value="1" />
              <input type="hidden" class="removeProcessTelId" name="removeProcessTelId" value="" />
              <input type="hidden" class="removeProcessFaxId" name="removeProcessFaxId" value="" />
              <input type="hidden" class="removeProcessMailId" name="removeProcessMailId" value="" />
              <input type="hidden" class="removeProcessOffcletterId" name="removeProcessOffcletterId" value="" />

                <div class="row row-footer-btn">
                  <div class="form-group col-sm-12 div-text-center">
                    <?php
                    if($case_processInit_idx[0]["process_status"]=="" && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
                      ?>
                        <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>

                      <?php
                    }
                    if($case_processInit_idx[0]["process_status"]!="" && $case_processInit_idx[0]["process_status"]==0 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
                      ?>

<div class="row">
                          <div class="col-lg-12" style="padding: unset; display:none;">
                            <div class="form-group col-lg-2" style="text-align: initial;">
                                <label class="text-data-light text-data-gray">
                                  ตรวจสอบความน่าเชื่อถือ12
                                </label>
                            </div>
                            <div class="col-lg-10" style="text-align: initial;" id="testCheck2">
                              <div class="radio-primary col-xs-12">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="1">
                                      น่าเชื่อถือ2                                </label>
                              </div>
                              <div class="radio-primary col-xs-12">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="2">
                                      ไม่น่าเชื่อถือ</label>
                              </div>

                              <div style="padding-left: 20px;display: none;" id="div_reliable">
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="1" >
                                      Watchlist                                </label>
                                </div>
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="2" >
                                      Blacklist                               </label>
                                </div>
                              </div>

                            </div>

                           
                          </div>
                        </div>
                        

                        <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>
                        <button type="button" class="btn btn-primary btn-float-center btn-close-process-list" style="margin-top:10px;">ปิดกระบวนการ</button>
                      <?php
                    }
                    ?>
                    </div>
                </div>
            </div>
          </form>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</div>
<!-- /กระบวนการดำเนินการ (แจ้งผู้ร้องเรียนว่าได้รับเรื่องร้องเรียนเรียบร้อยแล้ว)-->
<script>
  $(document).on('change', '[name="reliable"]', function(){
    var val = $(this).val();

    if(val == 2){
      $('#div_reliable').show();
    } else{
      $('#div_reliable').hide();
    }
  })
</script>


  <?php
  $statusBtn = "";
  $showStatusBtn = "display:none";
  if(count($case_processInit_idx[1])==0){
    $statusBtn = 'btn-countdown-time-pending';
    $statusTxt = 'In Process';
    $clock_container = "timestop";
    $timeamount = "xx วัน xx ชั่วโมง xx นาที";
    $checkComplete = '';
    $tooltip = '';
  }else{
    if($case_processInit_idx[1]["process_status"]==0){
      $showStatusBtn  = "";
      if($case_processInit_idx[1]["process_over_datetime"]!="" && time()>$case_processInit_idx[1]["process_over_datetime"]){
        $statusBtn = 'btn-countdown-time-over';
        $statusTxt = 'Overdue';
        $clock_container = "clock";
        $timeamount = "xx วัน xx ชั่วโมง xx นาที";
        $checkComplete = '';
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[1]["process_over_note"].'"';
      }else{
        $statusBtn = 'btn-countdown-time-pending';
        $statusTxt = 'In Process';
        $clock_container = "clock";
        $timeamount = "xx วัน xx ชั่วโมง xx นาที";
        $checkComplete = '';
      }

      if($case_processInit_idx[1]["process_save_datetime_ctd"]=="0000-00-00"){
        $statusBtn = 'btn-countdown-time-pending';
        $statusTxt = 'In Process';
        $clock_container = "timestop";
        $timeamount = "00 นาที";// (เวลาจะนับวตั้งแต่วันเวลาทำงานราชการ)
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="เวลาจะนับตั้งแต่ วัน-เวลา ทำงานราชการ"';
        $checkComplete = '';
      }
    }else{
      $showStatusBtn  = "";
      $time_over = $case_processInit_idx[1]["process_over_datetime"];
      if($case_processInit_idx[1]["process_status"]==1){
        $time_compare = strtotime($case_processInit_idx[1]["process_complete_datetime"]);
      }else{
        $time_compare = time();
      }
      if($time_compare>$time_over){
        $statusBtn = 'btn-countdown-time-over';
        $statusTxt = 'Overdue';
        $clock_container = "timestop";
        $checkComplete = '<i class="glyph-icon icon-check"></i>';
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[1]["process_over_note"].'"';
      }else{
        $statusBtn = 'btn-countdown-time-success';
        $statusTxt = 'Complete';
        $clock_container = "timestop";
        $checkComplete = '<i class="glyph-icon icon-check"></i>';
      }
      $datatimeGen = $caseDtl_cls->getDateTimeData($case_processInit_idx[1]["process_save_datetime"],$case_processInit_idx[1]["process_complete_datetime"]);
      $timeamount = ($datatimeGen["days"]>0?$datatimeGen["days"]." วัน ":"").($datatimeGen["hours"]>0?$datatimeGen["hours"]." ชั่วโมง ":"").($datatimeGen["minutes"]>0?$datatimeGen["minutes"]." นาที ":"");
      if($timeamount==""){
        $timeamount = "01 นาที";
      }
    }
  }
  ?>
<!-- กระบวนการดำเนินการ (ตั้งเรื่อง)-->
<div class="panel panel-form-6" >
  <div class="panel-body">
    <div class="card">
      <div class="card-header col-sm-12 col-md-12" role="tab" id="heading_process_2">
        <a data-toggle="collapse" class="btn-collape-process no-gutter" href="#collapse_process_2" aria-expanded="true" aria-controls="collapse_process_2">
          <div class="col-lg-5">
            <button type="button" class="btn btn-round disabled btn-check-success"><?php echo $checkComplete ?></button>
            <button type="button" class="btn ra-100 btn-countdown-time <?php echo $statusBtn ?>" style="margin-top-3px; <?php echo $showStatusBtn ?>" rel="<?php echo $case_processInit_idx[1]["process_save_datetime_ctd"] ?>" <?php echo $tooltip ?>><span><?php echo $statusTxt ?> | </span>
              <span class="<?php echo $clock_container ?>" id="clock<?php echo $case_processInit_idx[1]["process_id"] ?>"><?php echo $timeamount ?></span>
            </button>
          </div>
          <?php
          $processTypeName_init = $caseDtl_cls->caseProcessTypeList("all",$caseDtl_cls->admin_section);
          ?>
          <span class="col-xs-12 col-lg-6 span-title"><?php echo $processTypeName_init[2] ?></span>
          <i class="glyph-icon icon-angle-<?php if($case_processInit_idx[1]['process_status']!='1'){echo "up";}else{echo "down";} ?> icon-collape"></i>
        </a>
      </div>
      <?php
      if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
        ?>
        <div id="collapse_process_2" class="collapse  <?php if($case_processInit_idx[1]['process_status']!='1'){echo "in";} ?>" aria-labelledby="headingOne">
          <form class="frm_case_process" name="frm_case_process" enctype="multipart/form-data" method="post" action="/" target="iframe-data">
            <div class="card-block" id="card-block-<?php echo $case_processInit_idx[1]["process_id"] ?>">
              <?php
              $i=0;
              foreach($rs_case["process_mail"][1][$case_processInit_idx[1]["process_id"]] as $process_mail_group) {
                $process_mail_group1 = $process_mail_group;
              }
              foreach($rs_case["process_mail"][2][$case_processInit_idx[1]["process_id"]] as $process_mail_group) {
                $process_mail_group2 = $process_mail_group;
              }
              ?>
              <div class="row panel-pad-10">
                <div class="col-sm-12 panel-body-bg2">
                  <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                  <input type="hidden" name="process_id" value="<?php echo ($case_processInit_idx[1]["process_id"]!=""?$case_processInit_idx[1]["process_id"]:"0") ?>" />
                  <input type="hidden" name="process_elm" value="collapse_process_2" />
                  <div class="row">
                    <div class="form-group col-lg-2">
                        <label class="control-label text-data-light text-data-gray">
                          หมายเลขเอกสารออก
                        </label>
                        <input type="hidden" name="procPropMail_type_2[]" value="2" />
                        <input type="hidden" name="procPropMail2" class="procPropMail" value="1" />
                        </div>
                    <div class="form-group col-lg-3">
                      <input type="hidden" class="form-control" name="procPropMail_id_2[]" value="<?php echo $process_mail_group2["procPropMail_id"] ?>" />
                      <input type="text" class="form-control" name="procPropMail_number_2[]" value="<?php echo $process_mail_group2["procPropMail_number"] ?>" />
                    </div>
                    <div class="form-group form-group-file col-xs-12 <?php if($case_processInit_idx[1]["process_status"]=="0" && $process_mail_group2["procPropMail_file_path"]==""){ echo "col-lg-3";}else{echo "col-lg-2";} ?>">

                      <?php
                      if($process_mail_group2["procPropMail_file_path"]==""){
                        ?>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"><?php echo ($process_mail_group2["procPropMail_file_name"]!=""?$process_mail_group2["procPropMail_file_oldname"]:""); ?></span>
                            </div>
                            <span class="input-group-addon btn btn-default btn-file">
                              <span class="fileinput-new">Browse</span>
                              <span class="fileinput-exists">Change</span>
                              <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                            </span>
                        </div>
                        <?php
                      }else{
                        ?>
                           <a href="view_file_attach.php?fileprocessmail=<?php echo $process_mail_group2["procPropMail_id"] ?>" target="_blank">
                             <div class="panel-body panel-body-list-file file-process" >
                                <div class="col-xs-2 col-md-3">
                                  <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($process_mail_group2["procPropMail_file_ext"]) ?>-o icon-thumb-file"></i>
                                </div>
                                <div class="col-xs-10  col-md-9">
                                  <p class="shot-text"><?php echo $process_mail_group2["procPropMail_file_oldname"] ?></p>
                                </div>
                             </div>
                           </a>
                           <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="display:none;" rel="col-lg-3">
                               <div class="form-control" data-trigger="fileinput">
                                   <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                   <span class="fileinput-filename"><?php echo ($process_mail_group2["procPropMail_file_name"]!=""?$process_mail_group2["procPropMail_file_oldname"]:""); ?></span>
                               </div>
                               <span class="input-group-addon btn btn-default btn-file">
                                 <span class="fileinput-new">Browse</span>
                                 <span class="fileinput-exists">Change</span>
                                 <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                               </span>
                           </div>

                        <?php
                      }
                      ?>
                    </div>
                    <?php
                    if($case_processInit_idx[1]["process_status"]=="0" && $process_mail_group2["procPropMail_file_path"]!=""){
                      ?>
                      <div class="col-xs-1 form-group-file-btn nopadding">
                        <button type="button" class="btn btn-edit-file-process glyph-icon icon-pencil-square-o"></button>
                      </div>
                      <?php
                    }
                    ?>
                    <div class="form-group col-lg-2">
                      <div class="input-group">
                      <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_2[]" value="<?php echo (($process_mail_group2["procPropMail_datetime"]!="" && $process_mail_group2["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_mail_group2["procPropMail_datetime"])):"") ?>" >
                        <span class="input-group-addon input-group-addon-calendar bg-black">
                          <i class="glyph-icon icon-calendar"></i>
                        </span>
                      </div>
                    </div>
                    <div class="form-group col-lg-2">
                      <div class="input-group">
                      <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_2[]" value="<?php echo (($process_mail_group2["procPropMail_datetime"]!="" && $process_mail_group2["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_mail_group2["procPropMail_datetime"])):"") ?>" >
                        <span class="input-group-addon bg-black">
                          <i class="glyph-icon icon-clock-o"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group col-lg-2">
                      <label class="text-data-light text-data-gray">
                        หมายเหตุ
                      </label>
                  </div>
                  <div class="col-lg-10">
                    <textarea name="process_note" rows="3" class="form-control textarea-no-resize"><?php echo $case_processInit_idx[1]["note"] ?></textarea>
                  </div>
                </div>
              </div>
              <input type="hidden" name="process_type_id" value="2" />
              <input type="hidden" class="removeProcessTelId" name="removeProcessTelId" value="" />
              <input type="hidden" class="removeProcessFaxId" name="removeProcessFaxId" value="" />
              <input type="hidden" class="removeProcessMailId" name="removeProcessMailId" value="" />
              <input type="hidden" class="removeProcessOffcletterId" name="removeProcessOffcletterId" value="" />
              <?php
              //if($rs_case["case"]["my_case_owner"]==1){
                ?>
                <div class="row row-footer-btn">
                  <div class="form-group col-sm-12 div-text-center">
                  <?php
                  if($case_processInit_idx[1]["process_status"]=="" && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
                    ?>
                      <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>

                    <?php
                  }
                  if($case_processInit_idx[1]["process_status"]!="" && $case_processInit_idx[1]["process_status"]==0){
                    ?>

<div class="row">
                          <div class="col-lg-12" style="padding: unset; display:none;">
                            <div class="form-group col-lg-2" style="text-align: initial;">
                                <label class="text-data-light text-data-gray">
                                  ตรวจสอบความน่าเชื่อถือ
                                </label>
                            </div>
                            <div class="col-lg-10" style="text-align: initial;">
                              <div class="radio-primary col-xs-12" style="text-align: initial;">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="1" require>
                                      น่าเชื่อถือ1                                </label>
                              </div>
                              <div class="radio-primary col-xs-12">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="2" require>
                                      ไม่น่าเชื่อถือ                               </label>
                              </div>

                              <div style="padding-left: 20px;display: none;" id="div_reliable">
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="1" >
                                      Watchlist                                </label>
                                </div>
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="2" >
                                      Blacklist                               </label>
                                </div>
                              </div>
                              

                            </div>
                          </div>
                        </div>

                      <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>
                      <button type="button" class="btn btn-primary btn-float-center btn-close-process-list" style="margin-top:10px;">ปิดกระบวนการ</button>

                    <?php
                  }
                  ?>
                  </div>
                </div>
                <?php
              //}
              ?>
            </div>
          </form>
        </div>
        <?php
        }
      ?>
    </div>
  </div>
</div>
<!-- /กระบวนการดำเนินการ (ตั้งเรื่อง)-->


<!-- กระบวนการดำเนินการ (ติดต่อผู้ร้องเรียน)-->
<?php
$i=2;
for($i=2;$i<count($case_processInit_idx);$i++){
  $statusBtn = "";
  $showStatusBtn = "display:none";
  if(count($case_processInit_idx[$i])==0){
    $statusBtn = 'btn-countdown-time-pending';
    $statusTxt = 'In Process';
    $clock_container = "timestop";
    $timeamount = "xx วัน xx ชั่วโมง xx นาที";
    $checkComplete = '';
    $tooltip = '';
  }else{
    if($case_processInit_idx[$i]["process_status"]==0){
      $showStatusBtn  = "";
      if($case_processInit_idx[$i]["process_over_datetime"]!="" && time()>$case_processInit_idx[$i]["process_over_datetime"]){
        $statusBtn = 'btn-countdown-time-over';
        $statusTxt = 'Overdue';
        $clock_container = "clock";
        $timeamount = "xx วัน xx ชั่วโมง xx นาที";
        $checkComplete = '';
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[$i]["process_over_note"].'"';
      }else{
        $statusBtn = 'btn-countdown-time-pending';
        $statusTxt = 'In Process';
        $clock_container = "clock";
        $timeamount = "xx วัน xx ชั่วโมง xx นาที";
        $checkComplete = '';
      }

      if($case_processInit_idx[$i]["process_save_datetime_ctd"]=="0000-00-00"){
        $statusBtn = 'btn-countdown-time-pending';
        $statusTxt = 'In Process';
        $clock_container = "timestop";
        $timeamount = "00 นาที";// (เวลาจะนับวตั้งแต่วันเวลาทำงานราชการ)
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="เวลาจะนับตั้งแต่ วัน-เวลา ทำงานราชการ"';
        $checkComplete = '';
      }
    }else{
      $showStatusBtn  = "";
      $time_over = $case_processInit_idx[$i]["process_over_datetime"];
      if($case_processInit_idx[$i]["process_status"]==1){
        $time_compare = strtotime($case_processInit_idx[$i]["process_complete_datetime"]);
      }else{
        $time_compare = time();
      }
      if($time_compare>$time_over){
        $statusBtn = 'btn-countdown-time-over';
        $statusTxt = 'Overdue';
        $clock_container = "timestop";
        $checkComplete = '<i class="glyph-icon icon-check"></i>';
        $tooltip = 'data-toggle="tooltip" data-placement="top" data-html="true" title="'.$case_processInit_idx[$i]["process_over_note"].'"';
      }else{
        $statusBtn = 'btn-countdown-time-success';
        $statusTxt = 'Complete';
        $clock_container = "timestop";
        $checkComplete = '<i class="glyph-icon icon-check"></i>';
      }
      $datatimeGen = $caseDtl_cls->getDateTimeData($case_processInit_idx[$i]["process_save_datetime"],$case_processInit_idx[$i]["process_complete_datetime"]);
      $timeamount = ($datatimeGen["days"]>0?$datatimeGen["days"]." วัน ":"").($datatimeGen["hours"]>0?$datatimeGen["hours"]." ชั่วโมง ":"").($datatimeGen["minutes"]>0?$datatimeGen["minutes"]." นาที ":"");
      if($timeamount==""){
        $timeamount = "01 นาที";
      }
    }
  }
  ?>
  <div class="panel panel-form-6 panel-process" >
    <div class="panel-body">
      <div class="card">
        <div class="card-header col-sm-12 col-md-12" role="tab" id="heading_process_<?php echo $i+1 ?>">
          <a data-toggle="collapse" class="btn-collape-process no-gutter" href="#collapse_process_<?php echo $i+1 ?>" aria-expanded="true" aria-controls="collapse_process_<?php echo $i+1 ?>">
            <div class="col-lg-5">
              <button type="button" class="btn btn-round disabled btn-check-success"><?php echo $checkComplete ?></button>
              <button type="button" class="btn ra-100 btn-countdown-time <?php echo $statusBtn ?>" style="margin-top-3px; <?php echo $showStatusBtn ?>" rel="<?php echo $case_processInit_idx[$i]["process_save_datetime_ctd"] ?>" <?php echo $tooltip ?>><span><?php echo $statusTxt ?> | </span>
                <span class="<?php echo $clock_container ?>" id="clock<?php echo $case_processInit_idx[$i]["process_id"] ?>"><?php echo $timeamount ?></span>
              </button>
            </div>
            <span class="col-xs-12 col-lg-6 title-process span-title"><span>กระบวนการที่ <?php echo ($i-1).' - </span><span class="dnm">'.$processTypeName[$case_processInit_idx[$i]["process_type_id"]].'</span>' ?></span>
            <i class="glyph-icon icon-angle-<?php if($case_processInit_idx[$i]['process_status']=='' || ($case_processInit_idx[$i]['process_status']=='0' && $case_processInit_idx[$i]["process_id"]==$process_last_open)){echo "up";}else{echo "down";} ?> icon-collape"></i>
          </a>
        </div>
        <?php
        if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
          ?>
          <div id="collapse_process_<?php echo $i+1 ?>" class="collapse <?php if($case_processInit_idx[$i]['process_status']=='' || ($case_processInit_idx[$i]['process_status']=='0' && $case_processInit_idx[$i]["process_id"]==$process_last_open)){echo "in";} ?>" aria-labelledby="headingOne">
            <form class="frm_case_process" name="frm_case_process" enctype="multipart/form-data" method="post" action="/" target="iframe-data">
              <div class="card-block"  id="card-block-<?php echo $case_processInit_idx[$i]["process_id"] ?>">
                <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                <input type="hidden" name="process_id" value="<?php echo ($case_processInit_idx[$i]["process_id"]!=""?$case_processInit_idx[$i]["process_id"]:"0") ?>" />
                <input type="hidden" name="process_elm" value="collapse_process_<?php echo $i+1 ?>" />

                <div class="panel-body" style="padding:10px;">
                  <div class="row">
                      <label class="col-lg-4 control-label required">ประเภทกระบวนการ </label>
                      <div class="col-lg-8">
                        <!-- <?=print_r($caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section))?> -->
                          <select name="process_type_id" class="select-type-process select-picker" data-live-search="true"  data-width="100%">
                            <option value="" disabled <?php if($case_processInit_idx[$i]["process_type_id"]==""){ echo "selected"; } ?> style="color:#777">--- กรุณาเลือกประเภทกระบวนการ ---</option>
                            <?php
                            if(count($caseDtl_cls->processType==0)){ //เช็คการนำเข้าข้อมูล "ช่องทางการร้องเรียน" จากฐานข้อมูล
                              $caseDtl_cls->processType = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section);
                            }
                            $process_deptType = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section,"dept_type");
                            foreach($caseDtl_cls->processType as $key => $value){
                                ?>
                                <option value="<?php echo $key ?>" <?php if($case_processInit_idx[$i]["process_type_id"]==$key){ echo "selected"; } ?> rel="<?php echo $process_deptType[$key] ?>">
                                  <?php echo $value ?>
                                </option>
                                <?php
                            }
                            ?>
                          </select>
                      </div>
                  </div>
                </div>
                <?php
                $deptTypeList = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section,"process_type_id");
                $departmentList = $caseDtl_cls->departmentList();
                ?>
                <div class="panel-body panel-department" style="padding:10px; <?php if($case_processInit_idx[$i]["dept_id"]=="0" || $case_processInit_idx[$i]["process_type_id"]=="3" || $case_processInit_idx[$i]["process_type_id"]=="5"){ echo "display:none;"; } ?>">
                  <div class="row">
                    <input type="hidden" class="dept_id" value="<?php echo $case_processInit_idx[$i]["dept_id"] ?>" />
                    <label class="col-lg-4 control-label required">หน่วยงานที่ติดต่อ</label>
                    <div class="col-lg-8">

                      <select class="process_dept_id_demo" style="display:none;">
                        <option value="" selected rel="0" style="color:#777">--- กรุณาเลือกหน่วยงานที่ติดต่อ ---</option>
                        <?php
                        $optDept = '';
                        foreach($departmentList["ctn"] as $ctnList){
                            $optDept .= '<option data-content="<span style=\'padding-left:0px;\'>'.$ctnList["name"].'</span>" disabled rel="'.$ctnList["dept_type"].'"></option>';
                              foreach($departmentList["ct"] as $ctList){
                                if($ctList["continent_code"]==$ctnList["code"]){
                                  $optDept .= '<option data-content="<span style=\'padding-left:20px;\'><h style=\'display:none;\'>'.$ctnList["name"].'</h>'.$ctList["name"].'</span>" disabled rel="'.$ctList["dept_type"].'"></option>';
                                  foreach($departmentList["dept"] as $deptList){
                                    if($deptList["dept_type"]==$ctList["dept_type"] && $deptList["country_id"]==$ctList["id"]){

                                      $optDept .= '<option value="'.$deptList["dept_id"].'" data-content="<span style=\'padding-left:40px;\'><h style=\'display:none;\'>'.$ctnList["name"].'/'.$ctList["name"].'</h>'.$deptList["dept_name"].'</span>"  rel="'.$deptList["dept_type"].'">
                                        '.$deptList["dept_name"].'
                                      </option>';
                                    }
                                  }
                                }
                              }
                        }
                        foreach($departmentList["dept"] as $deptList){
                          if($deptList["dept_type"]!="3"){
                            $optDept .= '<option value="'.$deptList["dept_id"].'"  rel="'.$deptList["dept_type"].'">
                              '.$deptList["dept_name"].'
                            </option>';
                          }
                        }
                        echo $optDept;
                        ?>
                      </select>

                      <select name="process_dept_id" class="select-type-dept process_dept_id select-picker" data-live-search="true"  data-width="100%">
                        <option value="" rel="0" selected style="color:#777">--- กรุณาเลือกหน่วยงานผู้ติดต่อ ---</option>
                        <?php
                        $optDept = '';
                        foreach($departmentList["ctn"] as $ctnList){
                            $optDept .= '<option data-content="<span style=\'padding-left:0px;\'>'.$ctnList["name"].'</span>" disabled rel="'.$ctnList["dept_type"].'"></option>';
                              foreach($departmentList["ct"] as $ctList){
                                if($ctList["continent_code"]==$ctnList["code"]){
                                  $optDept .= '<option data-content="<span style=\'padding-left:20px;\'><h style=\'display:none;\'>'.$ctnList["name"].'</h>'.$ctList["name"].'</span>" disabled rel="'.$ctList["dept_type"].'"></option>';
                                  foreach($departmentList["dept"] as $deptList){
                                    if($deptList["dept_type"]==$ctList["dept_type"] && $deptList["country_id"]==$ctList["id"]){

                                      $optDept .= '<option value="'.$deptList["dept_id"].'" data-content="<span style=\'padding-left:40px;\'><h style=\'display:none;\'>'.$ctnList["name"].'/'.$ctList["name"].'</h>'.$deptList["dept_name"].'</span>"  rel="'.$deptList["dept_type"].'">
                                        '.$deptList["dept_name"].'
                                      </option>';
                                    }
                                  }
                                }
                              }
                        }
                        foreach($departmentList["dept"] as $deptList){
                          if($deptList["dept_type"]!="3"){
                            $optDept .= '<option value="'.$deptList["dept_id"].'"  rel="'.$deptList["dept_type"].'">
                              '.$deptList["dept_name"].'
                            </option>';
                          }

                        }
                        echo $optDept;
                        ?>
                      </select>
                    </div>
                  </div>
                  <?php
                  foreach($departmentList["dept"] as $deptList){
                    if($case_processInit_idx[$i]["dept_id"]==$deptList["dept_id"]){
                      $dept_type = $deptList["dept_type"];
                      $dept_affiliation = $deptList["dept_affiliation"];
                      $dept_director = $deptList["dept_director"];
                      $dept_assistant = $deptList["dept_assistant"];
                      $dept_tel = $deptList["dept_tel"];
                      $dept_fax = $deptList["dept_fax"];
                      $dept_email = $deptList["dept_email"];
                      $dept_address = $deptList["dept_address"];
                    }
                  }
                  ?>
                  <script>
                  $(function(){
                    $(".typeDept").hide();
                    $(".typeDept_<?php echo $dept_type ?>").show();
                  });
                  </script>
                  <div class="row no-gutter panel-department-data">
                    <div class="col-lg-12 no-gutter no-margin">
                      <div class="row typeDept typeDept_2">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray ">
                              สั่งกัด
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $dept_affiliation ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              ชื่อผู้อำนวยการ
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_director">
                              <?php echo $dept_director ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              ชื่อผู้ช่วย/ผู้ประสานงาน
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_assistant">
                              <?php echo $dept_assistant ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              หมายเลขโทรศัพท์
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_tel">
                              <?php echo $dept_tel ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              หมายเลขแฟกซ์
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_fax">
                              <?php echo $dept_fax ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              อีเมล
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_email">
                              <?php echo $dept_email ?>
                            </label>
                        </div>
                      </div>
                      <div class="row typeDept typeDept_2 typeDept_3">
                        <div class="form-group col-lg-4">
                            <label class="control-label text-data-light text-data-gray">
                              ที่อยู่
                            </label>
                        </div>
                        <div class="form-group col-lg-8">
                            <label class="control-label typeDept_text text-data-light" id="dept_address">
                              <?php echo $dept_address ?>
                            </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-lg-12 no-gutter no-margin new-dep-1" style="<?php if($case_processInit_idx[$i]["process_type_id"]!=3){ echo "display: none;";} ?>">
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          ชื่อ
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['applnt_firstname']."  ".$rs_case['case_feild']['applnt_lastname']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          E-Mail
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['applnt_email']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          เบอร์โทรศัพท์
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['applnt_tel']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          เบอร์โทรศัพท์มือถือ
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['applnt_mobile']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          ที่อยู่ติดต่อ
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['applnt_address']; ?>
                        </label>
                    </div>
                  </div>
                </div>


                <div class="col-lg-12 no-gutter no-margin new-dep-2" style="<?php if($case_processInit_idx[$i]["process_type_id"]!=5){ echo "display: none;";} ?>">
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          ชื่อบริษัท
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['complnt_name']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          ชื่อที่ติดต่อ
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['complnt_contact_name']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          E-Mail
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['complnt_contact_email']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          เบอร์โทรศัพท์
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['complnt_contact_tel']; ?>
                        </label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-lg-4">
                        <label class="control-label text-data-light text-data-gray ">
                          ที่อยู่ติดต่อ
                        </label>
                    </div>
                    <div class="form-group col-lg-8">
                        <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                          <?php echo $rs_case['case_feild']['complnt_contact_address']; ?>
                        </label>
                    </div>
                  </div>
                </div>


                <div class="row panel-pad-10 groupDocument" id="groupDocument_type_2_<?php echo $case_processInit_idx[$i]["process_id"] ?>"  style="margin-bottom:0px;" >
                  <div class="col-lg-12 panel-body-bg2">
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            หมายเลขเอกสารออก
                          </label>
                      </div>
                      <?php
                      if(count($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]])==0){
                        ?>
                        <div class="form-group col-lg-3">
                          <input type="text" class="form-control" name="procPropMail_number_2[]"  />
                        </div>
                        <div class="form-group col-lg-3">
                          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                              <div class="form-control" data-trigger="fileinput">
                                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                  <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Browse</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                              </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_2[]" >
                            <span class="input-group-addon input-group-addon-calendar bg-black">
                              <i class="glyph-icon icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_2[]" >
                            <span class="input-group-addon bg-black">
                              <i class="glyph-icon icon-clock-o"></i>
                            </span>
                          </div>
                        </div>
                        <?php
                      }else{
                        $a=0;
                        foreach($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]] as $process_mail_group) {
                          if($a==0){
                            ?>
                            <div class="form-group col-lg-3">
                              <input type="text" class="form-control" name="procPropMail_number_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo $process_mail_group["procPropMail_number"];} ?>"  />
                            </div>
                            <div class="form-group form-group-file col-xs-12 <?php if($case_processInit_idx[$i]["process_status"]=="0" && $process_mail_group["procPropMail_file_path"]!=""){ echo "col-lg-2 nopadding";}else{echo "col-lg-3";} ?> ">
                              <?php
                              if($process_mail_group["procPropMail_file_path"]==""){
                                ?>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <a href="../<?php echo $process_mail_group["mailAttach_file_path"] ?>" download>
                                          <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                          <span class="fileinput-filename"><?php echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); ?></span>
                                        </a>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                      <span class="fileinput-new">Browse</span>
                                      <span class="fileinput-exists">Change</span>
                                      <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                                    </span>
                                </div>
                                <?php
                              }else{
                                ?>
                                 <a href="view_file_attach.php?fileprocessmail=<?php echo $process_mail_group["procPropMail_id"] ?>" target="_blank">
                                   <div class="panel-body panel-body-list-file file-process" >
                                      <div class="col-xs-2 col-md-3">
                                        <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($process_mail_group2["procPropMail_file_ext"]) ?>-o icon-thumb-file"></i>
                                      </div>
                                      <div class="col-xs-10  col-md-9">
                                        <p class="shot-text"><?php echo $process_mail_group["procPropMail_file_oldname"] ?></p>
                                      </div>
                                   </div>
                                 </a>
                                 <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="display:none;" rel="col-lg-3">
                                     <div class="form-control" data-trigger="fileinput">
                                         <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                         <span class="fileinput-filename"><?php echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); ?></span>
                                     </div>
                                     <span class="input-group-addon btn btn-default btn-file">
                                       <span class="fileinput-new">Browse</span>
                                       <span class="fileinput-exists">Change</span>
                                       <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                                     </span>
                                 </div>
                                <?php
                              }
                              ?>
                            </div>
                            <?php
                            if($case_processInit_idx[$i]["process_status"]=="0" && $process_mail_group["procPropMail_file_path"]!=""){
                              ?>
                              <div class="col-xs-1 form-group-file-btn nopadding">
                                <button type="button" class="btn btn-edit-file-process glyph-icon icon-pencil-square-o"></button>
                              </div>
                              <?php
                            }
                            ?>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_datetime"]!="" && $process_mail_group["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_mail_group["procPropMail_datetime"])):"");} ?>" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_datetime"]!="" && $process_mail_group["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_mail_group["procPropMail_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <?php
                          }
                          $a++;
                        }
                      }
                      ?>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            ชื่อเรื่อง
                          </label>
                      </div>
                      <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="process_title_2" value="<?php echo $case_processInit_idx[$i]["process_title2"] ?>"  />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            ถึง
                          </label>
                      </div>
                      <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="process_to_2"  value="<?php echo $case_processInit_idx[$i]["process_to2"] ?>"   />
                      </div>
                    </div>
                    <hr />
                    <?php
                    if(count($rs_case["process_tel"][2][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_tel_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropTel2" class="procPropTel procProp" value="1">

                              <label>
                                โทรศัพท์
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropTel_id_2[]"  />
                            <input type="text" class="form-control" name="procPropTel_number_2[]" />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_2[]"  >
                              <span class="input-group-addon input-group-addon-calendar bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropTel_time_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-tel" rel="2">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_tel"][2][$case_processInit_idx[$i]["process_id"]] as $process_tel_group) {
                        ?>
                        <div class="row no-gutter row_tel_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropTel2"  class="procPropTel procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropTel2_status"]==1?"checked":"")?>>
                                <label>
                                  โทรศัพท์
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropTel_id_2[]" value="<?php echo $process_tel_group["procPropTel_id"]?>"  />
                              <input type="text" class="form-control" name="procPropTel_number_2[]" value="<?php if($process_tel_group["procPropTel_type"]==2){ echo $process_tel_group["procPropTel_number"]; } ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_2[]"  value="<?php if($process_tel_group["procPropTel_type"]==2){ echo (($process_tel_group["procPropTel_datetime"]!="" && $process_tel_group["procPropTel_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_tel_group["procPropTel_datetime"])):""); } ?>" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropTel_time_2[]" value="<?php if($process_tel_group["procPropTel_type"]==2){ echo (($process_tel_group["procPropTel_datetime"]!="" && $process_tel_group["procPropTel_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_tel_group["procPropTel_datetime"])):""); } ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_tel"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_tel"][2][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                <a href="javascript:void(0);" class="btn-rm-tel" rel="<?php echo $process_tel_group["procPropTel_id"]?>">
                                  <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                </a>
                                <?php
                              }else{
                                ?>
                                 <a href="javascript:void(0);" class="btn-add-tel" rel="2">
                                   <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                 </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                      ?>
                    <hr />
                    <?php
                    if(count($rs_case["process_fax"][2][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_fax_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropFax2" class="procPropFax procProp" value="1">

                              <label>
                                FAX
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropFax_id_2[]" />
                            <input type="text" class="form-control" name="procPropFax_number_2[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_2[]" >
                              <span class="input-group-addon input-group-addon-calendar bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropFax_time_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-fax" rel="2">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_fax"][2][$case_processInit_idx[$i]["process_id"]] as $process_fax_group) {
                        ?>
                        <div class="row no-gutter row_fax_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropFax2"  class="procPropFax procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropFax2_status"]==1?"checked":"")?>>
                                <label>
                                  FAX
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropFax_id_2[]" value="<?php echo $process_fax_group["procPropFax_id"]; ?>" />
                              <input type="text" class="form-control" name="procPropFax_number_2[]" value="<?php if($process_fax_group["procPropFax_type"]==2){ echo $process_fax_group["procPropFax_number"];} ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_2[]" value="<?php  if($process_fax_group["procPropFax_type"]==2){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_fax_group["procPropFax_datetime"])):"");} ?>" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropFax_time_2[]" value="<?php  if($process_fax_group["procPropFax_type"]==2){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_fax_group["procPropFax_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_fax"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_fax"][2][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                 <a href="javascript:void(0);" class="btn-rm-fax"  rel="<?php echo $process_fax_group["procPropFax_id"]?>">
                                   <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                 </a>
                                <?php
                              }else{
                                ?>
                                  <a href="javascript:void(0);" class="btn-add-fax" rel="2">
                                    <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                  </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                    ?>
                    <hr />
                    <?php
                    if(count($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row row_email_proc row_proc">
                        <div class="col-lg-12 no-gutter">
                          <div class="form-group col-lg-2">

                              <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropEmail2" class="procPropEmail procProp" value="1" >
                                <label>
                                  EMAIL
                                </label>
                              </div>
                          </div>
                          <div class="form-group col-lg-2" style="margin-bottom:0;">
                            <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>
                          </div>
                          <div class="form-group col-lg-7">
                            <input type="hidden" class="form-control" name="procPropEmail_id_2[]" />
                            <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_2[]" placeholder="email@gmail.com"  />
                          </div>
                          <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                          </div>
                        </div>
                        <div class="col-lg-12 no-gutter">
                          <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                            &nbsp
                          </div>
                          <div class="form-group col-lg-2" style="margin-bottom:0;">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>
                          </div>
                          <div class="form-group col-lg-7">
                            <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_2[]"  />
                          </div>
                          <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                          </div>
                        </div>
                        <div class="col-lg-12 no-gutter">
                          <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                          </div>
                          <div class="form-group col-lg-2" style="margin-bottom:0;">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                          </div>
                          <div class="form-group col-lg-7">
                            <textarea name="procPropEmail_message_2[]" rows="3" id="ckeditor_<?php echo $case_processInit_idx[$i]["process_id"] ?>_2_<?php echo $i+1 ?>" class="ckeditor form-control textarea-no-resize procPropEmail_message" placeholder="..."></textarea>
                          </div>
                          <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                          </div>
                        </div>
                        <div class="col-md-12 no-gutter">
                          <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                          </div>
                          <div class="form-group col-sm-12 col-md-12 col-lg-2 form-group-email-file" style="margin-bottom:0;">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>
                          </div>
                          <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">
                            <input type="file" name="procPropEmail_file_2[]" id="procPropEmail_file_<?php echo $case_processInit_idx[$i]["process_id"] ?>_2_<?php echo $i+1 ?>" class=" form-control procPropEmail_file" multiple />
                          </div>
                          <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                          </div>
                        </div>
                        <div class="col-lg-12 no-gutter contain-email-btn1">
                          <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_2[]" value="<?php echo date("Y-m-d H:i:s"); ?>"  />
                          <div class="col-lg-8 hidden-xs hidden-sm hidden-md "></div>
                          <div class="col-lg-3">
                            <button type="button" class="btn btn-default btn-send-email" rel="2">
                              <i class="glyph-icon icon-envelope-o"></i>
                              Send
                            </button>
                          </div>
                          <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]] as $process_email_group) {
                        ?>
                        <div class="col-lg-12  no-gutter">
                          <div class="col-md-2 hidden-xs hidden-sm hidden-md ">
                            &nbsp;
                          </div>
                          <div class="col-md-10">
                            <hr>
                          </div>
                        </div>
                        <div class="row no-gutter row_email_proc row_proc">
                          <div class="col-lg-12">

                            <div class="col-lg-12 no-gutter">
                              <div class="form-group col-lg-2">

                                  <?php
                                  if($a==0){
                                   ?>
                                  <div class="checkbox checkbox-padleft-20">
                                    <input type="checkbox" name="procPropEmail2"  class="procPropEmail procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropEmail2_status"]==1?"checked":"")?>>
                                    <label>
                                      EMAIL
                                    </label>
                                  </div>
                                  <?php
                                  }else{
                                    echo "&nbsp";
                                  }
                                  ?>
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <input type="hidden" class="form-control" name="procPropEmail_id_2[]" value="<?php echo $process_email_group["procPropEmail_id"] ?>" />
                                <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_2[]" readonly value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_address"];} ?>" placeholder="email@gmail.com"  />
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">

                              </div>

                            </div>
                            <div class="col-lg-12 no-gutter">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                                &nbsp
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_2[]" readonly value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_subject"];} ?>"  />
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-lg-12 no-gutter">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <textarea name="procPropEmail_message_2[]" rows="3" id="ckeditor_<?php echo $case_processInit_idx[$i]["process_id"] ?>_2_<?php echo $i+1 ?>" class="ckeditor form-control textarea-no-resize procPropEmail_message" readonly placeholder="..."><?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_message"];} ?></textarea>
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-md-12 no-gutter">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                              </div>
                              <div class="form-group col-sm-12 col-md-12 col-lg-2 form-group-email-file" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>
                              </div>
                              <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">
                                <?php
                                if(count($process_email_group["email_attach"])>0){
                                  foreach ($process_email_group["email_attach"] as $email_attach) {
                                    ?>
                                    <a href="javascirpt:;" onclick="window.open('view_file_attach.php?mailfileadrss=<?php echo $email_attach["mailAttach_id"] ?>');">
                                      <div class="panel-body panel-body-list-file" style="padding:10px;">
                                        <ul class="list-file col-sm-12">
                                            <li class="no-gutter">
                                              <div class="col-xs-12 col-sm-1" style="margin-top:10px;">
                                                <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($email_attach["mailAttach_file_ext"]) ?>-o icon-thumb-file"></i>
                                              </div>
                                              <div class="col-xs-12 col-sm-9 list_file_name" style="margin-top:10px;" >
                                                <p><?php echo $email_attach["mailAttach_file_oldname"] ?></p>
                                              </div>
                                              <div class="col-xs-12 col-sm-2 col-btn-file">
                                                <button type="button" class="btn btn-round btn-bg22 btn-edit-file" >
                                                  <i class="my-icon icon-ico-ditp-22"></i>
                                                </button>
                                              </div>
                                            </li>
                                          </ul>
                                      </div>
                                    </a>
                                    <?php
                                  }
                                }else{
                                  echo '<span style="color:#ccc;">ไม่มีไฟล์แนบ</span>';
                                }
                                ?>
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-lg-12 no-gutter">
                              <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_2[]" value="<?php if($process_email_group["procPropEmail_type"]==2){ echo $process_email_group["procPropEmail_datetime"];} ?>"  />
                              <div class="form-group col-md-4 hidden-xs hidden-sm hidden-md"></div>
                              <div class="col-xs-6 col-lg-4">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">วันที่ <?php echo date("d/m/Y",strtotime($process_email_group["procPropEmail_datetime"])) ?></label>
                              </div>
                              <div class="col-xs-6 col-lg-3">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">เวลา <?php echo date("H:i น.",strtotime($process_email_group["procPropEmail_datetime"])) ?></label>
                              </div>
                              <div class="col-xs-12 col-md-12 col-lg-7 col-lg-offset-4">
                                <?php
                                if(!(count($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_email"][2][$case_processInit_idx[$i]["process_id"]])-1)){

                                  ?>
                                    <a href="javascript:void(0);" class="btn-add-email" rel="2">
                                      <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                    </a>
                                   <?php
                                }
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                    ?>

                    <hr />
                    <?php
                    if(count($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_tracking_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropMail2" class="procPropMail" value="1">
                              <label>
                                จดหมาย
                              </label>
                            </div>
                          </div>

                          <div class="form-group col-lg-2">
                            <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>
                          </div>
                          <div class="form-group col-lg-3">
                            <input type="hidden" class="form-control" name="procPropMail_id_2[]" />
                            <input type="hidden" name="procPropMail_type_2[]" value="2" />
                            <input type="text" class="form-control" name="procPropMail_tracking_2[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_tracking_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-tracking" rel="2">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>

                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]] as $process_mail_group) {

                        ?>
                        <div class="row no-gutter row_tracking_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropMail2" class="procPropMail" value="1" <?php echo ($case_processInit_idx[$i]["procPropMail2_status"]==1?"checked":"")?>>

                                  <label>
                                    จดหมาย
                                  </label>
                                </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>

                            <div class="form-group col-lg-2">
                              <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>
                            </div>
                            <div class="form-group col-lg-3">
                              <input type="hidden" class="form-control" name="procPropMail_id_2[]" value="<?php echo $process_mail_group["procPropMail_id"] ?>" />
                              <input type="hidden" name="procPropMail_type_2[]" value="2" />
                              <input type="text" class="form-control" name="procPropMail_tracking_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo $process_mail_group["procPropMail_tracking"];} ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_tracking"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_mail_group["procPropMail_tracking_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_tracking_2[]" value="<?php if($process_mail_group["procPropMail_type"]==2){ echo (($process_mail_group["procPropMail_tracking"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="" && $process_mail_group["procPropMail_tracking_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_mail_group["procPropMail_tracking_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_mail"][2][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                               <a href="javascript:void(0)" class="btn-rm-tracking"  rel="<?php echo $process_mail_group["procPropMail_id"]?>">
                                 <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                               </a>
                                <?php
                              }else{
                                ?>
                                <a href="javascript:void(0)" class="btn-add-tracking" rel="2">
                                  <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                </a>
                                 <?php
                              }
                              ?>
                            </div>

                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                    ?>
                    <hr />
                    <?php
                    if(count($rs_case["process_offcletter"][2][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_offcletter_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropOffcLetter2" class="procPropOffcLetter procProp" value="1">

                              <label>
                                หนังสือราชการ
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropOffcLetter_id_2[]" />
                            <input type="text" class="form-control" name="procPropOffcLetter_number_2[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-offcletter" rel="2">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_offcletter"][2][$case_processInit_idx[$i]["process_id"]] as $process_offcletter_group) {
                        ?>
                        <div class="row no-gutter row_offcletter_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropOffcLetter2"  class="procPropOffcLetter procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropOffcLetter2_status"]==1?"checked":"")?>>

                                <label>
                                  หนังสือราชการ
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropOffcLetter_id_2[]" value="<?php echo $process_offcletter_group["procPropOffcLetter_id"] ?>" />
                              <input type="text" class="form-control" name="procPropOffcLetter_number_2[]" value="<?php if($process_offcletter_group["procPropOffcLetter_type"]==2){ echo $process_offcletter_group["procPropOffcLetter_number"];} ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_2[]" value="<?php  if($process_offcletter_group["procPropOffcLetter_type"]==2){ echo ($process_offcletter_group["procPropOffcLetter_datetime"]!=""?date('d/m/Y',strtotime($process_offcletter_group["procPropOffcLetter_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_2[]" value="<?php  if($process_offcletter_group["procPropOffcLetter_type"]==2){ echo ($process_offcletter_group["procPropOffcLetter_datetime"]!=""?date('H:i',strtotime($process_offcletter_group["procPropOffcLetter_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_offcletter"][2][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_offcletter"][2][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                 <a href="javascript:void(0);" class="btn-rm-offcletter" rel="<?php echo $process_offcletter_group["procPropOffcLetter_id"]?>">
                                   <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                 </a>
                                <?php
                              }else{
                                ?>
                                  <a href="javascript:void(0);" class="btn-add-offcletter" rel="2">
                                    <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                  </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                  ?>
                  </div>
                </div>

                <div class="row panel-pad-10 groupDocument" id="groupDocument_type_1_<?php echo $case_processInit_idx[$i]["process_id"] ?>" >
                  <div class="col-lg-12 panel-body-bg2">
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            หมายเลขเอกสารเข้า
                          </label>
                          <input type="hidden" name="procPropMail_type_1[]" value="1" />
                      </div>
                      <?php
                      if(count($rs_case["process_mail"][1][$case_processInit_idx[$i]["process_id"]])==0){
                        ?>
                        <div class="form-group col-lg-3">
                          <input type="hidden" class="form-control" name="procPropMail_id_1[]" value="" />

                          <input type="text" class="form-control" name="procPropMail_number_1[]"  />
                        </div>
                        <div class="form-group col-lg-3">
                          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                              <div class="form-control" data-trigger="fileinput">
                                  <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                  <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file">
                                <span class="fileinput-new">Browse</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" class="procPropMail_file" name="procPropMail_file_1[]">
                              </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_1[]" >
                            <span class="input-group-addon bg-black">
                              <i class="glyph-icon icon-calendar"></i>
                            </span>
                          </div>
                        </div>
                        <div class="form-group col-lg-2">
                          <div class="input-group">
                          <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_1[]" >
                            <span class="input-group-addon bg-black">
                              <i class="glyph-icon icon-clock-o"></i>
                            </span>
                          </div>
                        </div>
                        <?php
                      }else{
                        $a=0;
                        foreach($rs_case["process_mail"][1][$case_processInit_idx[$i]["process_id"]] as $process_mail_group) {
                          ?>
                          <div class="form-group col-lg-3">
                            <input type="hidden" class="form-control" name="procPropMail_id_1[]" value="<?php echo $process_mail_group["procPropMail_id"] ?>" />

                            <input type="text" class="form-control" name="procPropMail_number_1[]" value="<?php if($process_mail_group["procPropMail_type"]==1){ echo $process_mail_group["procPropMail_number"];} ?>"  />
                          </div>
                          <div class="form-group form-group-file col-xs-12 <?php if($case_processInit_idx[$i]["process_status"]=="0" && $process_mail_group["procPropMail_file_path"]!=""){ echo "col-lg-2 nopadding";}else{echo "col-lg-3";} ?>">
                            <?php
                            if($process_mail_group["procPropMail_file_path"]==""){
                              ?>
                              <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                  <div class="form-control" data-trigger="fileinput">
                                    <a href="../<?php echo $process_mail_group["procPropMail_file_path"] ?>" download>
                                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                      <span class="fileinput-filename"><?php echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); ?></span>
                                    </a>
                                  </div>
                                  <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Browse</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" class="procPropMail_file" name="procPropMail_file_1[]">
                                  </span>
                              </div>
                              <?php
                            }else{
                              ?>
                                 <a href="view_file_attach.php?fileprocessmail=<?php echo $process_mail_group["procPropMail_id"] ?>" target="_blank">
                                   <div class="panel-body panel-body-list-file file-process" >
                                      <div class="col-xs-2 col-md-3">
                                        <i class="glyph-icon icon-<?php echo $caseDtl_cls->genfileIcon($process_mail_group["procPropMail_file_ext"]) ?>-o icon-thumb-file"></i>
                                      </div>
                                      <div class="col-xs-10  col-md-9">
                                        <p class="shot-text"><?php echo $process_mail_group["procPropMail_file_oldname"] ?></p>
                                      </div>
                                   </div>
                                 </a>
                                 <div class="fileinput fileinput-new input-group" data-provides="fileinput" style="display:none;" rel="col-lg-3">
                                     <div class="form-control" data-trigger="fileinput">
                                         <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                         <span class="fileinput-filename"><?php echo ($process_mail_group["procPropMail_file_name"]!=""?$process_mail_group["procPropMail_file_oldname"]:""); ?></span>
                                     </div>
                                     <span class="input-group-addon btn btn-default btn-file">
                                       <span class="fileinput-new">Browse</span>
                                       <span class="fileinput-exists">Change</span>
                                       <input type="file" class="procPropMail_file" name="procPropMail_file_1[]">
                                     </span>
                                 </div>
                              <?php
                            }
                            ?>
                          </div>
                          <?php
                          if($case_processInit_idx[$i]["process_status"]=="0" &&  $process_mail_group["procPropMail_file_path"]!=""){
                            ?>
                            <div class="col-xs-1 form-group-file-btn nopadding">
                              <button type="button" class="btn btn-edit-file-process glyph-icon icon-pencil-square-o"></button>
                            </div>
                            <?php
                          }
                          ?>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_1[]" value="<?php if($process_mail_group["procPropMail_type"]==1){ echo (($process_mail_group["procPropMail_datetime"]!="" && $process_mail_group["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_mail_group["procPropMail_datetime"])):"");} ?>" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropMail_time_1[]" value="<?php if($process_mail_group["procPropMail_type"]==1){ echo (($process_mail_group["procPropMail_datetime"]!="" && $process_mail_group["procPropMail_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_mail_group["procPropMail_datetime"])):"");} ?>" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <?php
                          $a++;
                        }
                      }
                      ?>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            ชื่อเรื่อง
                          </label>
                      </div>
                      <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="process_title_1" value="<?php echo $case_processInit_idx[$i]["process_title1"] ?>"  />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-2">
                          <label class="control-label text-data-light text-data-gray">
                            ถึง
                          </label>
                      </div>
                      <div class="form-group col-lg-10">
                        <input type="text" class="form-control" name="process_to_1" value="<?php echo $case_processInit_idx[$i]["process_to1"] ?>"  />
                      </div>
                    </div>
                    <hr />
                    <?php
                    if(count($rs_case["process_fax"][1][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_fax_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropFax1" class="procPropFax procProp" value="1">

                              <label>
                                FAX
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropFax_id_1[]" />
                            <input type="text" class="form-control" name="procPropFax_number_1[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_1[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropFax_time_1[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-fax" rel="1">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_fax"][1][$case_processInit_idx[$i]["process_id"]] as $process_fax_group) {
                        ?>
                        <div class="row no-gutter row_fax_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropFax1"  class="procPropFax procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropFax1_status"]==1?"checked":"")?>>
                                <label>
                                  FAX
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropFax_id_1[]" value="<?php echo $process_fax_group["procPropFax_id"]; ?>" />
                              <input type="text" class="form-control" name="procPropFax_number_1[]" value="<?php if($process_fax_group["procPropFax_type"]==1){ echo $process_fax_group["procPropFax_number"]; } ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_1[]"  value="<?php if($process_fax_group["procPropFax_type"]==1){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_fax_group["procPropFax_datetime"])):""); } ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropFax_time_1[]"  value="<?php if($process_fax_group["procPropFax_type"]==1){ echo (($process_fax_group["procPropFax_datetime"]!="" && $process_fax_group["procPropFax_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_fax_group["procPropFax_datetime"])):""); } ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_fax"][1][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_fax"][1][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                 <a href="javascript:void(0);" class="btn-rm-fax" rel="<?php echo $process_fax_group["procPropFax_id"]?>">
                                   <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                 </a>
                                <?php
                              }else{
                                ?>
                                  <a href="javascript:void(0);" class="btn-add-fax" rel="1">
                                    <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                  </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>

                        <?php
                        $a++;
                      }
                    }
                    ?>
                    <hr />

                    <?php
                    if(count($rs_case["process_email"][1][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_email1_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropEmail1" class="procPropEmail procProp" value="1">
                              <label>
                                Email
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                          <input type="hidden" class="form-control" name="procPropEmail_id_1[]"  />
                            <input type="text" class="form-control" name="procPropEmail_number_1[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropEmail_date_1[]" >
                              <span class="input-group-addon input-group-addon-calendar bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker"  name="procPropEmail_time_1[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0);" class="btn-add-email1" rel="1">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_email"][1][$case_processInit_idx[$i]["process_id"]] as $process_email_group) {
                        ?>
                        <div class="row no-gutter row_email1_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">

                                <input type="checkbox" name="procPropEmail1"  class="procPropEmail procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropEmail1_status"]==1?"checked":"")?>>
                                <label>
                                  Email
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropEmail_id_1[]" value="<?php echo $process_email_group["procPropEmail_id"]?>" />
                              <input type="text" class="form-control" name="procPropEmail_number_1[]" value="<?php  if($process_email_group["procPropEmail_type"]==1){ echo $process_email_group["procPropEmail_number"];} ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropEmail_date_1[]"  value="<?php if($process_email_group["procPropEmail_type"]==1){ echo (($process_email_group["procPropEmail_datetime"]!="" && $process_email_group["procPropEmail_datetime"]!="0000-00-00 00:00:00")?date('d/m/Y',strtotime($process_email_group["procPropEmail_datetime"])):"");} ?>" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropEmail_time_1[]"  value="<?php if($process_email_group["procPropEmail_type"]==1){ echo (($process_email_group["procPropEmail_datetime"]!="" && $process_email_group["procPropEmail_datetime"]!="0000-00-00 00:00:00")?date('H:i',strtotime($process_email_group["procPropEmail_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_email"][1][$case_processInit_idx[$i]["process_id"]])>1 && $i<count($rs_case["process_email"][1][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                <a href="javascript:void(0);" class="btn-rm-email1" rel="<?php echo $process_email_group["procPropTel_id"]?>">
                                  <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                </a>
                                <?php
                              }else{
                                ?>
                                 <a href="javascript:void(0);" class="btn-add-email1" rel="1">
                                   <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                 </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                    ?>
                    <hr />
                    <div class="row no-gutter row_tracking_proc row_proc">
                      <div class="col-lg-12">
                        <div class="form-group col-lg-2">
                          <div class="checkbox checkbox-padleft-20">
                            <input type="checkbox"  name="procPropMail1" class="procPropMail" value="1" <?php echo ($case_processInit_idx[$i]["procPropMail1_status"]==1?"checked":"")?>>
                            <label>
                              จดหมาย
                            </label>
                          </div>
                        </div>

                      </div>
                    </div>
                    <hr />
                    <?php
                    if(count($rs_case["process_offcletter"][1][$case_processInit_idx[$i]["process_id"]])==0){
                      ?>
                      <div class="row no-gutter row_offcletter_proc row_proc">
                        <div class="col-lg-12">
                          <div class="form-group col-lg-2">
                            <div class="checkbox checkbox-padleft-20">
                              <input type="checkbox" name="procPropOffcLetter1" class="procPropOffcLetter procProp" value="1">

                              <label>
                                หนังสือราชการ
                              </label>
                            </div>
                          </div>
                          <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropOffcLetter_id_1[]" />
                            <input type="text" class="form-control" name="procPropOffcLetter_number_1[]"  />
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_1[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_1[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-1">
                            <a href="javascript:void(0)" class="btn-add-offcletter" rel="1">
                              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                      <?php
                    }else{
                      $a=0;
                      foreach($rs_case["process_offcletter"][1][$case_processInit_idx[$i]["process_id"]] as $process_offcletter_group) {
                        ?>
                        <div class="row no-gutter row_offcletter_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <?php
                              if($a==0){
                               ?>
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropOffcLetter1"  class="procPropOffcLetter procProp" value="1" <?php echo ($case_processInit_idx[$i]["procPropOffcLetter1_status"]==1?"checked":"")?>>

                                <label>
                                  หนังสือราชการ
                                </label>
                              </div>
                              <?php
                              }else{
                                echo "&nbsp";
                              }
                              ?>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropOffcLetter_id_1[]" value="<?php echo $process_offcletter_group["procPropOffcLetter_id"] ?>" />
                              <input type="text" class="form-control" name="procPropOffcLetter_number_1[]" value="<?php if($process_offcletter_group["procPropOffcLetter_type"]==1){ echo $process_offcletter_group["procPropOffcLetter_number"];} ?>"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_1[]" value="<?php  if($process_offcletter_group["procPropOffcLetter_type"]==1){ echo ($process_offcletter_group["procPropOffcLetter_datetime"]!=""?date('d/m/Y',strtotime($process_offcletter_group["procPropOffcLetter_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_1[]" value="<?php  if($process_offcletter_group["procPropOffcLetter_type"]==1){ echo ($process_offcletter_group["procPropOffcLetter_datetime"]!=""?date('H:i',strtotime($process_offcletter_group["procPropOffcLetter_datetime"])):"");} ?>" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <?php
                              if((count($rs_case["process_offcletter"][1][$case_processInit_idx[$i]["process_id"]])>1 && $a<count($rs_case["process_offcletter"][1][$case_processInit_idx[$i]["process_id"]])-1)){
                               ?>
                                 <a href="javascript:void(0);" class="btn-rm-offcletter"  rel="<?php echo $process_offcletter_group["procPropOffcLetter_id"]?>">
                                   <i class="ditp-icon icon-ico-ditp-20 icon-add-channel"></i>
                                 </a>
                                <?php
                              }else{
                                ?>
                                  <a href="javascript:void(0);" class="btn-add-offcletter" rel="1">
                                    <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                  </a>
                                 <?php
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <?php
                        $a++;
                      }
                    }
                    ?>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group col-lg-2">
                        <label class="text-data-light text-data-gray">
                          หมายเหตุ
                        </label>
                    </div>
                    <div class="col-lg-10">
                      <textarea name="process_note" rows="3" class="form-control textarea-no-resize"><?php echo $case_processInit_idx[$i]["note"] ?></textarea>
                    </div>
                  </div>
                </div>
                <input type="hidden" class="removeProcessTelId" name="removeProcessTelId" value="" />
                <input type="hidden" class="removeProcessFaxId" name="removeProcessFaxId" value="" />
                <input type="hidden" class="removeProcessMailId" name="removeProcessMailId" value="" />
                <input type="hidden" class="removeProcessOffcletterId" name="removeProcessOffcletterId" value="" />
                <?php
                if($rs_case["case"]["my_case_assign"]==1){
                  ?>
                  <div class="row row-footer-btn">
                    <div class="form-group col-sm-12 div-text-center">
                      <?php
                      if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"save_process")[3]==1){
                        if($case_processInit_idx[$i]["process_status"]==""){
                          ?>
                            <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>
                          <?php
                        }
                      }

                      if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"close_process")[3]==1){
                        if($case_processInit_idx[$i]["process_status"]!="" && $case_processInit_idx[$i]["process_status"]==0){
                          ?>

                          <div class="row">
                          <!-- <div class="col-lg-12" style="padding: unset;">
                            <div class="form-group col-lg-2" style="text-align: initial;">
                                <label class="text-data-light text-data-gray">
                                  ตรวจสอบความน่าเชื่อถือ
                                </label>
                            </div>
                            <div class="col-lg-10" style="text-align: initial;">
                              <div class="radio-primary col-xs-12" style="text-align: initial;">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="1">
                                      น่าเชื่อถือ3                                </label>
                              </div>
                              <div class="radio-primary col-xs-12">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable" value="2">
                                      ไม่น่าเชื่อถือ                               </label>
                              </div>

                              <div style="padding-left: 20px;display: none;" id="div_reliable">
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="1" >
                                      Watchlist                                </label>
                                </div>
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="" name="reliable_sub" value="2" >
                                      Blacklist                               </label>
                                </div>
                              </div>

                            </div>
                            
                          </div> -->
                        </div>
                            <button type="button" class="btn btn-success btn-float-center btn-save-process-list " style="margin-top:10px;">บันทึก</button>
                            <button type="button" class="btn btn-primary btn-float-center btn-close-process-list" style="margin-top:10px;">ปิดกระบวนการ</button>
                          <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>
            </form>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
  <?php
}
?>

<!-- /กระบวนการดำเนินการ (ติดต่อผู้ร้องเรียน)-->
