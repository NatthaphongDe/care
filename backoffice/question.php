
<i class="ditp-icon icon-ico-ditp-27"></i>
<span class="txt_hr_question">แบบสอบถาม</span>
<form method="post" id="question" action="function_question.php?method=question" enctype="multipart/form-data" target="iframe-data">
<div class="row" style="padding-top:15px;">
  <div class="col-md-12">
    <div class="panel panel-default appeal_panel">
      <div class="panel-body" style="padding:30px 0px 40px 40px;">
        <?php
          include('../config/config.php');
          $question_txt = array();
          $sql = "SELECT * FROM `Feedback_Backend_Question`";
          $query = $conn->query($sql);
          $i = 1;
          while ($res = $query->fetch_assoc()) { ?>
            <div class="row">
              <input type="hidden" name="hid_questionID[]" value="<?=$res['feedback_q_id']?>">
              <div class="col-md-12" style="font-size:18px;"> <?=$i?>. <?=$res['feedback_q_title']?> <?php if($res['feedback_q_chk'] == '1'){ echo "<span style='color:red;'>*</span>";}?></div>
            </div>
        <?php
          if($res['feedback_q_type'] == '1'){ ?>
            <div class="row" style="margin-top:20px;margin-bottom:40px;">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="answers_question_<?=$res['feedback_q_id']?>">
                </div>
              <div class="col-md-6"></div>
            </div>
        <?php }elseif ($res['feedback_q_type'] == '2') { ?>
          <div class="row" style="margin-top:20px;margin-bottom:40px;">

              <div class="col-md-3"><input type="radio" value="ดีมาก" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_1_<?=$res['feedback_q_id']?>">
                <label class="txt_class" for="rd_question_1_<?=$res['feedback_q_id']?>"> ดีมาก</label></div>
              <div class="col-md-3"><input type="radio" value="ดี" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_2_<?=$res['feedback_q_id']?>">
                <label class="txt_class" for="rd_question_2_<?=$res['feedback_q_id']?>"> ดี</label></div>
              <div class="col-md-3"><input type="radio" value="พอใช้" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_3_<?=$res['feedback_q_id']?>">
                <label class="txt_class" for="rd_question_3_<?=$res['feedback_q_id']?>"> พอใช้</label></div>
              <div class="col-md-3"><input type="radio" value="ควรปรับปรุง" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_4_<?=$res['feedback_q_id']?>">
                <label class="txt_class" for="rd_question_4_<?=$res['feedback_q_id']?>"> ควรปรับปรุง</label></div>

          </div>
        <?php }else { ?>
          <div class="row" style="margin-top:20px;margin-bottom:40px;">
              <div class="col-md-6">
                <textarea rows="8" class="form-control" name="answers_question_<?=$res['feedback_q_id']?>"></textarea>
              </div>
            <div class="col-md-6"></div>
          </div>
        <?php
          }
          $i++;
        }
        ?>


        <div class="row" style="margin-top:20px;">
          <div class="col-md-12">
            <button type="button" class="btn btn-success" onclick="submitForm_question()">ตกลง</button>
          </div>
        </div>
      </div>
    </div> <!-- รายละเอียดเรื่องร้องเรียน -->
  </div>
</div>
</form>
<script>
function submitForm_question() {
  bootbox.confirm({
message: "ท่านต้องการยืนยันแบบสอบถามการใช้งานของท่านหรือไม่ ?",
buttons: {
    confirm: {
        label: 'บันทึก',
        className: 'btn-success'
    },
    cancel: {
        label: 'ยกเลิก',
        className: 'btn-danger'
    }
},
callback: function (result) {
    if(result == true){
      $("#question").submit();
    }
}
});
}
</script>
<style>
.txt_hr_question{
  font-family: 'kanitregular';
  font-weight: normal;
  font-style: normal;
  font-size: 18px;
  color: #004D40;
}
</style>
