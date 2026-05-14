
<div class="modal fade" id="model_assign" tabindex="-1" role="dialog" aria-labelledby="model_assign_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal frm_case_assign" name="frm_case_assign" enctype="multipart/form-data" method="post" action="function.php?method=assign_case" target="iframe-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                </button>
                <h4 class="modal-title">Assign</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="col-xs-12 div-text-center panel-check-assign">
                        <button type="button" class="btn btn-check-assign" onclick="window.location.href='index.php?page=dashboard/dashboard';">ตรวจสอบสถานะพนักงาน</button>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12" style="padding:15px 10px;">
                    <label class="col-xs-12 col-sm-3 control-label text-data-size16">เพิ่มผู้รับผิดชอบ</label>
                    <div class="col-xs-12 col-sm-9">
                        <input type="text" class="form-control input-mask" name="emp_id" id="emp_assign_search" value="" data-inputmask="'mask':'9999999'">
                    </div>
                  </div>
                </div>
                <div class="panel-body" id="add-emp-assign" style="padding:0px;">
                  <?php
                  $ias = 0;
                  foreach ($rs_case["case_assign"] as $case_assign) {
                    ?>
                    <div class="panel-body panel-body-outer-bg2 panel-emp-assign  panel-emp-assign-list panel-emp-<?php echo $case_assign["emp_real_id"] ?>" style="padding:10px;">
                      <div class="col-xs-12 no-gutter" style="padding:0;">
                          <label class="col-xs-12 text-data-size16">ผู้รับผิดชอบ (<?php echo $ias+1 ?>)</label>
                      </div>
                      <input type="hidden" name="emp_id_assign[]" value="<?php echo $case_assign["emp_id"] ?>" />
                      <div class="col-xs-12 panel-body-bg2 no-gutter">
                        <button type="button" class="close close-emp-assign" onclick="case_detail.remove_assign('panel-emp-<?php echo $case_assign["emp_real_id"] ?>','<?php echo $case_assign["caseAsign_id"] ?>')" >
                            <i class="ditp-icon icon-ico-ditp-20"></i>
                        </button>
                        <ul class="chat-box">
                          <li class="no-gutter col-xs-11">
                            <div class="col-xs-2">
                              <div class="status-badge img-circle">
                                <img src="<?php echo $case_assign["emp_img_path_s"]; ?>" alt="<?php echo $case_assign["emp_img_path_s"]; ?>" style="<?php echo $caseLst_cls->getPositionImage($case_assign["emp_img_path_s"],50) ?>">
                              </div>
                            </div>
                            <div class="col-xs-10">
                              <p class="col-xs-12 p-emp">
                                ID : <?php echo $case_assign["emp_real_id"] ?>
                              </p>

                              <p class="col-xs-12 p-emp-name">
                                <?php echo $case_assign["emp_firstname"]; ?> <?php echo $case_assign["emp_lastname"]; ?>
                              </p>
                              <p class="col-xs-6 p-emp">
                                <i class="glyph-icon icon-phone"></i> <?php echo $case_assign["emp_tel"]; ?>
                              </p>
                              <p class="col-xs-6 p-emp">
                                <i class="glyph-icon icon-envelope-o"></i> <?php echo $case_assign["emp_email"]; ?>
                              </p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <?php
                    $ias++;
                  }
                  ?>
                </div>



                <div class="row">
                  <div class="col-xs-12">
                    <label class="col-xs-12 control-label text-data-size16 control-label-note">หมายเหตุ</label>
                    <div class="col-xs-12">
                      <textarea name="assign_note" rows="3" class="form-control textarea-no-resize"><?php echo $rs_case["case"]["case_opened_note"] ?></textarea>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">

                <input type="hidden" name="removeAssignId" class="removeAssignId" value="" />
                <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                <button type="button" class="btn btn-success btn-assign-case" >ตกลง</button>
            </div>
          </form>
      </div>
    </div>
</div>
