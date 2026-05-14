<div class="modal fade" id="model_close_process" tabindex="-1" role="dialog" aria-labelledby="model_close_process_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal frm_close_process" name="frm_close_process" enctype="multipart/form-data" method="post" action="function.php?method=note_close_process" target="iframe-data">
            <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
            <input type="hidden" name="process_id" value="0" />
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ditp-icon icon-ico-ditp-20"></i>
                </button>
                <h4 class="modal-title">หมายเหตุ</h4>
            </div>
            <div class="modal-body">
              <div class="row">
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
