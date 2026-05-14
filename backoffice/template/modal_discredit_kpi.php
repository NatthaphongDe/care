
  <div class="modal fade" id="model_discredit_kpi" tabindex="-1" role="dialog" aria-labelledby="model_assign_label" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal frm_case_assign" name="frm_case_assign" enctype="multipart/form-data" method="post" action="function.php?method=dis_kpi_case" target="iframe-data">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                      <i class="ditp-icon icon-ico-ditp-20"></i>
                  </button>
                  <h4 class="modal-title">Discreate KPI</h4>
              </div>
              <div class="modal-body">


                  <?php
                  $ias = 0;
                  foreach ($rs_case["case_assign"] as $case_assign) {
                    ?>
                    <div class="panel-body panel-body-outer-bg2 panel-emp-assign" style="padding:10px;">
                      <div class="radio-primary col-xs-1 radio-discredit">
                          <label>
                              <input type="radio" id="rdi_emp_<?php echo $case_assign["emp_real_id"] ?>" value="<?php echo $case_assign["emp_id"] ?>" name="emp_id_assign" class="custom-radio">
                          </label>
                      </div>
                      <div class="col-xs-11 panel-body-bg2 no-gutter">
                        <ul class="chat-box">
                          <li class="no-gutter">
                            <div class="col-xs-12 no-gutter">
                                <label class="col-sm-6 text-data-size16">ผู้รับผิดชอบ (<?php echo $ias+1 ?>)</label>
                            </div>
                            <div class="col-xs-2">
                              <div class="status-badge img-circle">
                                <img src="<?php echo $case_assign["emp_img_path_s"]; ?>" alt="<?php echo $case_assign["emp_img_path_s"]; ?>" style="<?php echo $caseLst_cls->getPositionImage($case_assign["emp_img_path_s"],50) ?>">
                              </div>
                            </div>
                            <div class="col-xs-10">
                              <p class="col-xs-7 p-emp">
                                ID : <?php echo $case_assign["emp_real_id"] ?>
                              </p>
                              <p class="col-xs-5 p-date">
                                <button class="btn btn btn-xs btn-default btn-date-small" type="button"><?php echo ($case_assign["caseAsign_create_datetime"]!=""?date('d/m/Y h:i A', strtotime($case_assign["caseAsign_create_datetime"])):"xx/xx/xxxx  xx:xx AM") ?></button>
                              </p>

                              <p class="col-xs-12 p-emp-name">
                                <?php echo $case_assign["emp_firstname"]; ?> <?php echo $case_assign["emp_lastname"]; ?>
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
              <div class="modal-footer">
                <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                <button type="submit" class="btn btn-success">ตกลง</button>
              </div>
            </form>
          </div>
      </div>
  </div>

<style>
</style>
