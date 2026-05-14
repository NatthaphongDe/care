<div class="modal fade" id="model_process_overdue" tabindex="-1" role="dialog" aria-labelledby="model_process_overdue_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal frm_process_overdue" name="frm_process_overdue" enctype="multipart/form-data" method="post" action="function.php?method=note_process_overdue" target="iframe-data">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                </button>
                <h4 class="modal-title">ระบุสาเหตุกระบวนเกินเวลาที่กำหนด</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <label class="control-label" style="margin-bottom:10px;">เนื่องจาก กระบวนการ <span class="proc_over_title_txt"><?php echo $proc_overdue_title ?></span> เกินกำหนดเวลา <span class="proc_over_duration_txt">60</span> วัน กรุณาระบุสาเหตุการเกินกำหนดเวลาที่กำหนด </label>
                </div>
                <div class="col-md-12">
                  <textarea name="note_overdue" id="note_people_check" rows="3" class="form-control textarea-no-resize"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="process_id" value="<?php echo $proc_id ?>" />
                <button type="submit" class="btn btn-success btn-success-final" onclick="">บักทึก</button>
            </div>
        </div>
      </form>
    </div>
</div>
