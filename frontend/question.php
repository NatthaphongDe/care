<iframe name="question_iframe" style="display:none;"></iframe>
<form method="post" id="question" action="function_php/function_index.php?method=question" enctype="multipart/form-data" target="question_iframe">
  <input type="hidden" name="lang_question" value="<?php if($lang != ""){ echo $lang;}else{ echo "1";}?>">
<div class="row appeal_div_row">
  <div class="col-md-12">
    <div class="panel panel-default appeal_panel">
      <div class="panel-heading hr_info_panel">
        <span class="txt_info"><?=$question?></span>
      </div>
      <div class="panel-body" style="padding:30px 0px 40px 40px;">
          <?php
            include('../config/config.php');
            $question_txt = array();
            $sql = "SELECT * FROM `Feedback_Frontend_Question`";
            $query = $conn->query($sql);
            $i = 1;
            if($lang == '2'){
              $otherText = "Please specify...";
            }else {
              $otherText = "โปรดระบุ...";
            }
            while ($res = $query->fetch_assoc()) {
              if($lang == '2'){
                $feedbackTitle = $res['feedback_q_title_en'];
              }else {
                $feedbackTitle = $res['feedback_q_title'];
              }
              ?>
              <div class="row">
                <input type="hidden" name="hid_questionID[]" value="<?=$res['feedback_q_id']?>">
                <div class="col-md-12" style="font-size:18px;"> <?=$i?>. <?=$feedbackTitle?> <?php if($res['feedback_q_chk'] == '1'){ echo "<span style='color:red;'>*</span>";}?></div>
              </div>
          <?php
            if($res['feedback_q_type'] == '1'){ ?>
              <div class="row" style="margin-top:10px;margin-bottom:40px;">
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="answers_question_<?=$res['feedback_q_id']?>">
                  </div>
                <div class="col-md-6"></div>
              </div>
          <?php }elseif ($res['feedback_q_type'] == '2') { ?>
            <div class="row" style="margin-top:10px;margin-bottom:40px;">

                <?php
                $sql_choice = "SELECT * FROM `Feedback_Frontend_Choice` WHERE feedback_q_id = '".$res['feedback_q_id']."' ";
                $query_choice = $conn->query($sql_choice);
                $ic = 1;
                while ($res_choice = $query_choice->fetch_assoc()) {
                  if($lang == '2'){
                    $feedbackChoice = $res_choice['feedback_c_text_en'];
                  }else {
                    $feedbackChoice = $res_choice['feedback_c_text'];
                  }
                  ?>
                  <div class="col-md-2 radio_flex">
                    <input type="radio" class="radio_class" value="<?=$feedbackChoice?>" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_<?=$res['feedback_q_id']?>_<?=$ic?>">
                    <label class="txt_class" for="rd_question_<?=$res['feedback_q_id']?>_<?=$ic?>"> <?=$feedbackChoice?></label>
                  </div>

                  <?php
                  $ic++;
                }
                ?>
            </div>
          <?php }elseif ($res['feedback_q_type'] == '4') { ?>
            <div class="row" style="margin-top:10px;margin-bottom:40px;">

                <?php
                $sql_choice = "SELECT * FROM `Feedback_Frontend_Choice` WHERE feedback_q_id = '".$res['feedback_q_id']."' ";
                $query_choice = $conn->query($sql_choice);
                $ic = 1;
                while ($res_choice = $query_choice->fetch_assoc()) {
                  if($lang == '2'){
                    $feedbackChoice = $res_choice['feedback_c_text_en'];
                  }else {
                    $feedbackChoice = $res_choice['feedback_c_text'];
                  }
                  ?>
                  <div class="col-md-5 radio_flex">
                    <input type="radio" class="radio_class" value="<?=$feedbackChoice?>" name="answers_question_<?=$res['feedback_q_id']?>" id="rd_question_<?=$res['feedback_q_id']?>_<?=$ic?>">
                    <label class="txt_class" for="rd_question_<?=$res['feedback_q_id']?>_<?=$ic?>">
                      <?=$feedbackChoice?>
                      <input type="text" value="" name="other_answers_question_<?=$res['feedback_q_id']?>" id="other_question_<?=$res['feedback_q_id']?>_<?=$ic?>" placeholder="<?php echo $otherText ?>" style="margin-left:5px;<?php if($res_choice['feedback_c_other_flag']=="1"){ ?>display:inline-flex;<?php }else{ ?>display:none;<?php }?> ">
                    </label>
                  </div>

                  <?php
                  $ic++;
                }
                ?>
            </div>
          <?php }else { ?>
            <div class="row" style="margin-top:10px;margin-bottom:40px;">
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


          <div class="row" style="margin-top:10px;">
            <div class="col-md-12">
              <button type="button" class="btn btn-success" onclick="submitForm_question()"><?=$txt_ok?></button>
            </div>
          </div>
        </div>
    </div> <!-- รายละเอียดเรื่องร้องเรียน -->
  </div>
</div>
</form>
<script>
function submitForm_question() {
  var lang = $('.language_hidden').val();
  $('#wait_process').css('display','block');
  if(lang == "2"){
    var txt = "Would you like to confirm your usage query?";
  }else {
    var txt = "ท่านต้องการยืนยันแบบสอบถามการใช้งานของท่านหรือไม่ ?";
  }
  bootbox.confirm({
message: txt,
buttons: {
    confirm: {
        label: 'Yes',
        className: 'btn-success'
    },
    cancel: {
        label: 'No',
        className: 'btn-danger'
    }
},
callback: function (result) {
    if(result == true){
      $("#question").submit();
      $('#wait_process').css('display','none');
    }else {
      $('#wait_process').css('display','none');
    }
}
});
}
</script>

<style>
  .txt_class{
    padding-left: 10px;
    font-weight: 100;
    margin-bottom: 0; 
    margin-top: 5px;
  }
  .radio_class {
    width: 25px;
  }
  .radio_flex {
    display: flex;
    align-items: center;
  }
</style>
