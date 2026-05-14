
  <!-- วันที่เปิดเคส,วันที่รับเรื่องตามเอกสาร,เวลารวมของ Case  -->
  <?php
  $comp_type_data = $caseDtl_cls->compTypeDetail($rs_case["case"]["compType_id"]);
  ?>
  <div class="panel">
    <div class="panel-body">
      <div class="row no-gutter">
        <div class="form-group col-md-12">
          <label class="col-sm-7 col-md-12 col-lg-7 control-label text-data-green"><i class="dito-icon icon-ico-ditp-31"></i> วันที่เปิด Case</label>
          <label class="col-sm-5 col-md-12 col-lg-5 control-label text-data-green"><?php echo date('d/m/Y',strtotime($rs_case["case"]["case_open_date"])) ?></label>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-7 col-md-12 col-lg-7 control-label text-data-green"><i class="dito-icon icon-ico-ditp-32" style="font-size:20px;"></i> วันที่รับเรื่องตามเอกสาร</label>
          <label class="col-sm-5 col-md-12 col-lg-5 control-label text-data-green"><?php echo date('d/m/Y',strtotime($rs_case["case"]["case_receivedoc_date"])) ?></label>
        </div>
        <div class="form-group col-md-12">
          <label class="col-sm-7 col-md-12 col-lg-7 control-label text-data-green"><i class="dito-icon icon-ico-ditp-33"></i> เวลารวมของ Case</label>
          <label class="col-sm-5 col-md-12 col-lg-5 control-label text-data-green"><?php echo $rs_case["case"]["case_compType_duration"] ?> วัน</label>
        </div>
      </div>
      <hr style="margin:0 0 15px 0;" />
      <div class="row no-gutter">
        <div class="form-group col-md-12">
          <?php
          if($rs_case["case"]["case_notice_applnt_datetime"]==""){
            //$datatimeGen_rcvdoc = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_receivedoc_date"]." 00:00:00",date('Y-m-d H:i:s',strtotime('+1 day', time())));
            $datatimeGen_rcvdoc = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_receivedoc_date"]." 00:00:00",date('Y-m-d 00:00:00',time()));
          }else{
            $datatimeGen_rcvdoc = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_receivedoc_date"]." 00:00:00",date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_notice_applnt_datetime"])));
          }
          // if($datatimeGen_rcvdoc["days"]<0){
          //   $datatimeGen_rcvdoc["days"] = 0;
          // }
          if($datatimeGen_rcvdoc["days"]<0){
            $datatimeGen_rcvdoc["days"] = 0;
          }
          if($datatimeGen_rcvdoc["days"] > $caseLst_cls->setting_info["normal_period"]){
            $over_text_rcvdoc = "text-data-red";
          }else{
            $over_text_rcvdoc = "";
          }
          ?>
          <label class="col-sm-7 col-md-12 col-lg-7  control-label"><i class="dito-icon icon-ico-ditp-35"></i> วันที่รับเรื่องจากเอกสาร</label>
          <label class="col-sm-5 col-md-12 col-lg-5  control-label"><span class="ra-100 time-duration-text <?php echo $over_text_rcvdoc ?>"><?php echo $datatimeGen_rcvdoc["days"] ?></span> / <?php echo $caseLst_cls->setting_info["normal_period"] ?> วัน</label>
        </div>
        <div class="form-group col-md-12">
          <?php
          if($rs_case["case"]["case_opened_datetime"]==""){
            $datatimeGen_opencase["days"] = 0;
          }else{
            if($rs_case["case"]["case_status"]!=3){
              //$datatimeGen_opencase = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_opened_datetime"],date('Y-m-d H:i:s', strtotime('+1 day', time())));
              $datatimeGen_opencase = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_opened_datetime"],date('Y-m-d 00:00:00', time()));
            }else{
              $datatimeGen_opencase = $caseDtl_cls->getDateTimeData($rs_case["case"]["case_opened_datetime"],date("Y-m-d 00:00:00",strtotime($rs_case["case"]["case_close_datetime"])));
            }
            // if($datatimeGen_opencase["days"]<0){
            //   $datatimeGen_opencase["days"] = 0;
            // }
          }

          if($datatimeGen_opencase["days"]<0){
            $datatimeGen_opencase["days"] = 0;
          }
          if($datatimeGen_opencase["days"] > $rs_case["case"]["case_compType_duration"]){
            $over_text_opencase = "text-data-red";
          }else{
            $over_text_opencase = "";
          }

          ?>
          <label class="col-sm-7 col-md-12 col-lg-7 control-label"><i class="dito-icon icon-ico-ditp-36"></i> ใช้เวลาทำการ</label>
          <label class="col-sm-5 col-md-12 col-lg-5 control-label"><span class="ra-100 time-duration-text <?php echo $over_text_opencase ?>"><?php echo $datatimeGen_opencase["days"] ?></span> / <?php echo $rs_case["case"]["case_compType_duration"] ?> วัน</label>
        </div>
      </div>
    </div>
  </div>
  <!-- /วันที่เปิดเคส,วันที่รับเรื่องตามเอกสาร,เวลารวมของ Case  -->

  <?php
  $chekAssign = false;
  foreach ($rs_case["case_assign"] as $case_assign) {
    if($_SESSION["admin"]["empId"]==$case_assign["emp_id"]){
      $chekAssign = true;
    }
  }

  if($rs_case["case"]["case_status"]!=3 && ($_SESSION["admin"]["empLv"]==2 || ($_SESSION["admin"]["empLv"]!=2 && $chekAssign)) && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
  ?>
    <!-- ปุ่ม แก้ไข Case  -->
    <div class="panel">
      <div class="panel-body panel-pad-20">
        <div class="row">
          <div class="col-md-12">

              <button type="button" class="btn btn-yellow btn-lg btn-block" onclick="window.location.href='index.php?page=case_open&method=editcase&caseId=<?php echo $rs_case["case"]["case_id"] ?>'"><i class="dito-icon icon-ico-ditp-10"></i> แก้ไขเรื่องร้องเรียน</button>

          </div>
        </div>
      </div>
    </div>
    <!-- /ปุ่ม แก้ไข Case  -->
  <?php
  }
  ?>

  <!-- ปุ่ม Assign  -->
  <div class="panel">
    <div class="panel-body panel-pad-20">
      <div class="row">
        <div class="col-md-12">
          <?php
          if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
            if($rs_case["case"]["case_assign_status"]==0 && $rs_case["case"]["case_status"]==1){
              ?>
              <!-- ถ้ายังไม่มีการ Assign -->
              <button type="button" class="btn btn-success btn-success2 btn-lg btn-block" onclick="case_detail.check_before_assign('#model_assign','<?php echo $rs_case["case"]["case_id"] ?>')">Assign</button>
              <!-- /ถ้ายังไม่มีการ Assign -->
              <?php
            }else{
              ?>
              <!-- ถ้า่มีการ Assign แล้ว -->
              <button type="button" class="btn btn-yellow btn-lg btn-block" onclick="case_detail.check_before_assign('#model_assign','<?php echo $rs_case["case"]["case_id"] ?>')"><i class="dito-icon icon-ico-ditp-39"></i> Re-Assign</button>
              <!-- /ถ้า่มีการ Assign แล้ว  -->
              <?php
            }
          }
          ?>


        </div>
      </div>
    </div>
  </div>
  <!-- /ปุ่ม Assign  -->

  <!-- ปุ่ม transfer  -->
  <?php if($rs_case["case"]["case_assign_status"]==0 && $rs_case["case"]["case_status"]==1 && $_SESSION["admin"]["empPosition"] == "3"){ ?>
  <div class="panel">
    <div class="panel-body panel-pad-20">
      <div class="row">
        <div class="col-md-12">
            <button  type="button" class="btn btn-lg btn-block btn-warning" onclick="modal_transfer()">
              <i class="glyph-icon icon-exchange" aria-hidden="true"></i> โอนเรื่องร้องเรียน
            </button>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <!-- /ปุ่ม transfer  -->


  <!-- ผุ้รับผิดชอบ  -->

  <?php
  $ias = 0;
  foreach ($rs_case["case_assign"] as $case_assign) {
    ?>
    <div class="panel panel-owner" >
      <div class="panel-body panel-pad-20">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-hero col-xs-12">
              <span>ผู้รับผิดชอบ (<?php echo $ias+1 ?>)</span>
            </h3>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <ul class="chat-box">
              <li class="no-gutter">
                <div class="col-sm-2 col-md-12 col-lg-3" style="text-align:center">
                  <div class="status-badge img-circle">
                    <img src="<?php echo $case_assign["emp_img_path_s"]; ?>" alt="<?php echo $case_assign["emp_img_path_s"]; ?>" style="<?php echo $caseLst_cls->getPositionImage($case_assign["emp_img_path_s"],50) ?>">
                  </div>
                </div>
                <div class="col-md-12 col-lg-9">
                  <p class="col-xs-12 p-emp">
                    ID : <?php echo $case_assign["emp_real_id"]; ?>
                  </p>
                  <p class="col-xs-12 p-date">
                    <button class="btn btn btn-xs btn-default btn-date-small" type="button"><?php echo ($case_assign["caseAsign_create_datetime"]!=""?date('d/m/Y h:i A', strtotime($case_assign["caseAsign_create_datetime"])):"xx/xx/xxxx  xx:xx AM") ?></button>
                  </p>

                  <p class="col-xs-12 p-emp-name">
                    <?php echo $case_assign["emp_firstname"]; ?> <?php echo $case_assign["emp_lastname"]; ?>
                  </p>
                  <p class="col-xs-12 p-emp">
                    <i class="glyph-icon icon-phone"></i> <?php echo $case_assign["emp_tel"]; ?>
                  </p>
                  <p class="col-xs-12 p-emp">
                    <i class="glyph-icon icon-envelope-o"></i> <?php echo $case_assign["emp_email"]; ?>
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
    $ias++;
  }
  ?>

  <!-- /ผุ้รับผิดชอบ  -->

  <!-- Timeline  -->
  <div class="panel panel-timeline" >
    <div class="panel-body panel-pad-20">
      <div class="row">
        <div class="col-md-12">
          <h3 class="title-hero col-xs-12">
            <span>Timeline</span>
          </h3>
        </div>
      </div>
      <?php
      if(count($rs_case["case_log"])==0){
        ?>
        <div class="row">
          <div class="col-md-12">
            <ul class="chat-box">
              <li class="no-gutter" style="padding-top:0;">

                <div class="col-xs-12">
                  <p style="text-align:center; color:#ccc;">ไม่มีรายการ</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <?php
      }else{
        $ias = 0;
        foreach ($rs_case["case_log"] as $case_log) {
          ?>
          <div class="row">
            <div class="col-md-12">
              <ul class="chat-box">
                <li class="no-gutter">
                  <div class="col-sm-2 col-md-12 col-lg-3" style="text-align:center">
                    <div class="status-badge img-circle">
                      <img src="<?php echo $case_log["emp_img_path_s"]; ?>" style="<?php echo $caseLst_cls->getPositionImage($case_log["emp_img_path_s"],50) ?>" alt="<?php echo $case_log["emp_img_path_s"]; ?>">
                    </div>
                  </div>

                  <div class="col-md-12 col-lg-9">
                    <p class="col-xs-7 col-md-12 p-emp">
                      ID : <?php echo $case_log["emp_real_id"]; ?>
                    </p>
                    <p class="col-xs-7 col-md-12 p-emp">
                      ชื่อ-สกุล : <?php echo $case_log["emp_firstname"]; ?> <?php echo $case_log["emp_lastname"]; ?>
                    </p>
                    <p class="col-xs-7 col-md-12 p-emp">
                      <?php
                      if($case_log["empGroup_section"]==2){
                        $office_name = "นิติการ";
                      }else{
                        $office_name = $case_log["office_name_short"];
                      }
                      ?>
                      สำนัก : <?php echo $office_name; ?>
                    </p>
                    <p class="col-xs-5 col-md-12 p-date">
                      <?php echo ($case_log["logCase_datetime"]!=""?date('d/m/Y h:i A', strtotime($case_log["logCase_datetime"])):"xx/xx/xxxx  xx:xx AM") ?>
                    </p>

                    <p class="col-xs-12 p-message"><?php echo $case_log["logCase_text"]; ?></p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
  <!-- /Timeline  -->
