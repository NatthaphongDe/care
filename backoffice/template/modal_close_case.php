<?php
if(count($caseDtl_cls->closeType==0)){ //เช็คการนำเข้าข้อมูล "ช่องทางการร้องเรียน" จากฐานข้อมูล
  $caseDtl_cls->closeType = $caseDtl_cls->caseCloseList();
}
?>
<div class="modal fade" id="model_close_case" tabindex="-1" role="dialog" aria-labelledby="model_close_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal frm_case_close" name="frm_case_close" id="frm_case_close" enctype="multipart/form-data" method="post" action="function.php?method=close_case" target="iframe-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                </button>
                <h4 class="modal-title">ยุติข้อร้องเรียน และแจ้งผลการดำเนินงาน</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <label class="col-xs-12  text-data-size16 control-label-closecase">สถานะการยุติข้อร้องเรียน</label>
                  <div class="col-xs-12 col-radio-closecase">
                    <?php
                    foreach($caseDtl_cls->closeType as $key => $value){
                        ?>
                        <div class=" radio-primary">
                            <label>
                                <input type="radio" id="closeCaseType<?php echo $key ?>" value="<?php echo $key ?>" name="caseClose_id" class="">
                                <?php echo $value ?>
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label class="col-xs-12 text-data-size16 control-label-note">ผลการดำเนินงาน</label>
                  <div class="col-xs-12">
                    <textarea name="case_close_resultProcess" rows="3" class="form-control textarea-no-resize"></textarea>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-12">
                  <label class="col-xs-12 text-data-size16 control-label-closecase">ตรวจสอบความน่าเชื่อถือ</label>
                  <div class="col-xs-12 col-radio-closecase">
                    <div class="radio-primary" id="radio_checkwhiteblack">
                      <label class="text-data-lights">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="0">
                          ไม่มีสถานะ                               
                      </label>
                      <br>
                      <label class="text-data-light">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="1">
                          เฝ้าระวัง (Watchlist)                               
                      </label>
                      <br>
                      <label class="text-data-light">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="2">
                          แบล็คลิส (Backlist)                           
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label class="col-xs-12 text-data-size16 control-label-closecase">ต้องการส่งอีเมลถึงผู้ร้องเรียนหรือไม่</label>
                  <div class="col-xs-12 col-radio-closecase">
                    <div class="radio-primary" id="radio_sendEmail">
                      <label class="text-data-lights">
                        <input type="radio" class="" id="" name="caseClose_sendEmail" value="0">
                          ต้องการ                        
                      </label>
                      <br>
                      <label class="text-data-lights">
                        <input type="radio" class="" id="" name="caseClose_sendEmail" value="1">
                          ไม่ต้องการ                            
                      </label>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                <button type="submit" class="btn btn-success">ตกลง</button>
            </div>
          </form>
        </div>
    </div>
</div>

<div class="modal fade" id="model_edit_close_case" tabindex="-1" role="dialog" aria-labelledby="model_close_label" aria-hidden="true">
    <div class="modal-dialog">
         <div class="modal-content">
          <form class="form-horizontal frm_case_close" name="frm_case_close" id="frm_edit_case_close" enctype="multipart/form-data" method="post" action="function.php?method=edit_close_case" target="iframe-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                </button>
                <h4 class="modal-title">แก้ไข ผลการดำเนินงาน</h4>
            </div>
            <div class="modal-body">
              

              <div class="row">
                <div class="col-md-12">
                  <label class="col-xs-12 text-data-size16 control-label-note">ผลการดำเนินงาน</label>
                  <div class="col-xs-12">
                    <textarea name="case_close_resultProcess" rows="3" class="form-control textarea-no-resize"><?php echo $rs_case["case"]["case_close_resultProcess"] ?></textarea>
                  </div>
                </div>
              </div>
              <!-- <?php var_dump($_SESSION["admin"]["empId"] == 114)  ?> -->
              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-12">
                  <label class="col-xs-12 text-data-size16 control-label-closecase">ตรวจสอบความน่าเชื่อถือ</label>
                  <div class="col-xs-12 col-radio-closecase">
                    <div class="radio-primary" id="radio_checkwhiteblack">
                      <label class="text-data-lights">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="0" <?php echo ($rs_case["case"]["reliable"] == 0  ? 'checked':'')?>>
                          ไม่มีสถานะ                               
                      </label>
                      <br>
                      <label class="text-data-light">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="1" <?php echo ($rs_case["case"]["reliable"] == 1  ? 'checked':'')?>>
                          เฝ้าระวัง (Watchlist)                               
                      </label>
                      <br>
                      <label class="text-data-light">
                        <input type="radio" class="" id="" name="caseClose_reliable" value="2" <?php echo ($rs_case["case"]["reliable"] == 2  ? 'checked':'')?>>
                          แบล็คลิส (Backlist)                           
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                <button type="submit" class="btn btn-success">ตกลง</button>
            </div>
          </form>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $('#radio_checkwhiteblack input[type=radio]').on('click', function(){
      $('#radio_checkwhiteblack input[type=radio]').not(this).prop('checked', false);
    });
  });

  $('#frm_case_close').on('submit', function(e) {
    e.preventDefault(); // ป้องกันการส่งทันที

    // แสดง loader ก่อน
    $('#loading_feedback').fadeIn(200, "linear");

    // หน่วงเวลานิดหน่อยให้เบราว์เซอร์วาด loader ก่อนเปลี่ยนหน้า
    setTimeout(() => {
        e.target.submit(); // ส่งฟอร์มจริง
    }, 200); // 0.2 วินาที พอให้ loader โผล่ทัน
  });

  $('#frm_edit_case_close').on('submit', function(e) {
    e.preventDefault(); // ป้องกันการส่งทันที

    // แสดง loader ก่อน
    $('#loading_feedback').fadeIn(200, "linear");

    // หน่วงเวลานิดหน่อยให้เบราว์เซอร์วาด loader ก่อนเปลี่ยนหน้า
    setTimeout(() => {
        e.target.submit(); // ส่งฟอร์มจริง
    }, 200); // 0.2 วินาที พอให้ loader โผล่ทัน
  });
</script>
