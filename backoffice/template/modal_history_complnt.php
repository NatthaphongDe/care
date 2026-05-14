
  <div class="modal fade" id="model_history_complnt" tabindex="-1" role="dialog" aria-labelledby="model_history_applnt_label" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                      <i class="ditp-icon icon-ico-ditp-20"></i>
                  </button>
                  <h4 class="modal-title">Check History</h4>
              </div>
              <div class="modal-body" style="padding-bottom:0px;">
                <div class="row">
                  <div class="col-md-12">
                    <ul class="history-box">
                      <?php
                      if(count($rs_caseRef_complnt)==0){
                        ?>
                        <li style="width:100%; text-align:center;">
                          <label class="text-data text-data-green">ไม่มีข้อมูล History</label>
                        </li>
                        <?php
                      }else{
                        foreach ($rs_caseRef_complnt as $rs_caseRef) {
                          if($_GET["page"]=="case_detail"){
                            ?>
                            <li style="width:100%;">
                              <div class="checkbox checkbox-primary">
                                <div class="col-xs-12">
                                  <label class="text-data text-data-green disPoint">Case ID <?php echo sprintf("%05d",$rs_caseRef["case"]["case_id"]); ?></label>
                                  <label class="text-data disPoint"><?php echo $rs_caseRef["case"]["caseDtl_title"] ?></label>
                                </div>
                                <div class="col-xs-12">
                                <label class="text-data text-data-size12 text-data-gray disPoint">
                                  <?php echo ($rs_caseRef["case_field"]["applntOrg_name"]!=""?$rs_caseRef["case_field"]["applntOrg_name"]:"<font style=\"color:red\">ไม่มีข้อมูลชื่อผู้ร้องเรียน</font>") ?>
                                  <span class="glyph-icon icon-angle-right"></span>
                                  <?php echo ($rs_caseRef["case_field"]["complnt_name"]!=""?$rs_caseRef["case_field"]["complnt_name"]:"<font style=\"color:red\">ไม่มีข้อมูลชื่อผู้ถูกร้องเรียน</font>") ?>
                                </label>
                              </div>
                              </div>
                            </li>
                            <?php
                          }else{
                            ?>
                            <li>
                              <div class="checkbox checkbox-primary">
                                <div class="col-xs-1">
                                  <label>
                                  <input type="checkbox" id="chkRef_complnt_<?php echo $rs_caseRef["case"]["case_id"] ?>" value="<?php echo sprintf("%05d",$rs_caseRef["case"]["case_id"]); ?>" class="custom-checkbox chkRef_complnt">
                                </label>
                                </div>
                                <div class="col-xs-11">
                                  <label class="text-data text-data-green disPoint">Case ID <?php echo sprintf("%05d",$rs_caseRef["case"]["case_id"]); ?></label>
                                  <label class="text-data disPoint"><?php echo $rs_caseRef["case"]["caseDtl_title"] ?></label>
                                </div>
                                <div class="col-xs-1">
                                </div>
                                <div class="col-xs-11">
                                <label class="text-data text-data-size12 text-data-gray disPoint">
                                  <?php echo ($rs_caseRef["case_field"]["applntOrg_name"]!=""?$rs_caseRef["case_field"]["applntOrg_name"]:"<font style=\"color:red\">ไม่มีข้อมูลชื่อผู้ร้องเรียน</font>") ?>
                                  <span class="glyph-icon icon-angle-right"></span>
                                  <?php echo ($rs_caseRef["case_field"]["complnt_name"]!=""?$rs_caseRef["case_field"]["complnt_name"]:"<font style=\"color:red\">ไม่มีข้อมูลชื่อผู้ถูกร้องเรียน</font>") ?>
                                </label>
                              </div>
                              </div>
                            </li>
                            <?php
                          }
                        }
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">ตกลง</button>
              </div>
          </div>
      </div>
  </div>
