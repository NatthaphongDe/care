<?php
$sql = "SELECT * FROM Member WHERE member_id = '" . $_SESSION['member_id'] . "'";
$query = $conn->query($sql);
$rl = $query->fetch_assoc();
// print_r($_SESSION['member_id']);

?>
<style>
  [type="radio"] {
    width: unset;
    height: unset;
  }
</style>
<input type="hidden" value="" class="member_condition">
<?php $case_cls->comp_type = $case_cls->compTypeList(); ?>
<!-- แยก สสบ กับ นิติการ -->
<?php $case_cls->comp_type_new = $case_cls->compTypeList_2($_GET['type']); ?>
<div class="row invite_div_row">
  <div class="col-md-12">
    <input type="hidden" name="status_chk" class="status_chk" value="">
    <div>
      <span class="icon_sound_invite"><img src="images/all_icon_DITP/icon_4.svg" style="width:30px;"></span>
      <span class="hr_invite_txt"><?= $_GET['type'] == 1 ? $txt_Start_petition : $txt_Start_petition_2 ?></span>
    </div>

    <form method="post" action="?page=invite_form" id="chk_invite_step1" enctype="multipart/form-data">
      <div class="invite_step1">
        <input type="hidden" class="chk_confirm" value="">
        <div class="panel panel-default panel_datetime">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-7 date_invite"><span class="txt_date_invite"><?= $txt_Date ?> : <?php echo date('d/m/Y', time()); ?></span></div>
            <div class="col-md-6 col-sm-6 col-xs-5 time_invite"><span class="txt_time_invite"><?= $txt_Time ?> : <?php echo date('H:i', time()); ?></span></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="row">
            <div class="col-md-12">
              <div class="hr_invite_xl">
                <span class="hr_invite_title"><?= $txt_choose_petitions ?></span>
              </div>
              <div class="select_invite" style="margin-bottom: 15px;">

                <input type="hidden" name="rdi_compTypeSub1" id="chk_invite_step1">
                <select name="new_type_1" class="selectpicker form-control select_invite_box slct_comp_type slct_compTypeSub1">
                    <!-- <option value="">
                      --- เลือกประเภทเรื่องร้องเรียน ---
                    </option> -->
                <?php
                foreach($case_cls->comp_type as $comp_type_list){
                  if(count($comp_type_list["compTypeSub1_list"])>0){
                    ?>
                    
                    <?php
                    if($rl['country_id'] == 162){
                      foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                        if($compTypeSub1_list["compTypeSub1_id"] == 2){
                          ?>
                            <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" >
                                <?php
                                  if ($lang == "1") {
                                    echo $compTypeSub1_list["compTypeSub1_name"];
                                  } elseif ($lang == "2") {
                                    echo $compTypeSub1_list["compTypeSub1_name_en"];
                                  } else {
                                    echo $compTypeSub1_list["compTypeSub1_name"];
                                  } 
                                ?>
                            </option>
                          <?php 
                        }
                      }
                    }else{
                      foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                        if($compTypeSub1_list["compTypeSub1_id"] == 1){
                          ?>
                            <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" >
                                <?php
                                  if ($lang == "1") {
                                    echo $compTypeSub1_list["compTypeSub1_name"];
                                  } elseif ($lang == "2") {
                                    echo $compTypeSub1_list["compTypeSub1_name_en"];
                                  } else {
                                    echo $compTypeSub1_list["compTypeSub1_name"];
                                  } 
                                ?>
                            </option>
                          <?php 
                        }
                      }
                    }
                      // foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                      //   if($compTypeSub1_list["compTypeSub1_id"] != 3 && $compTypeSub1_list["compTypeSub1_id"] != 4){
                          ?>
                            <!-- <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" >
                              <?php echo $compTypeSub1_list["compTypeSub1_name"] ?>
                            </option> -->
                          <?php
                      //   }
                      // }
                      ?>
                    <?php
                  }
                } ?>
                </select>


              </div>
              <div class="radio_invite">

                <div class="form-group col-md-12 div_compTypeSub1ByCompType" id="div_compTypeSub1ByCompType_<?php echo $comp_type_list["compType_id"] ?>"  style="margin-bottom:10px; padding-left: 5px;">
                  <input type="hidden" name="rdi_compType_id" id="rdi_compType_id">
                  <?php 
                  foreach($case_cls->comp_type as $comp_type_list){
                  if(count($comp_type_list["compTypeSub1_list"])>0){
                      foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                        if(count($compTypeSub1_list["compTypeSub2_list"])>0){
                          ?>
                              <?php
                              foreach($compTypeSub1_list["compTypeSub2_list"] as $compTypeSub2_list){
                                if($compTypeSub2_list["compTypeSub2_id"] == 9){
                                ?>
                                <div class="radio-primary col-xs-12">
                                  <label class="text-data-light">
                                      <input type="radio" class="rdi_compTypeSub1" id="compType_id_create_<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" name="new_type_2" value="<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" >
                                      <?php
                                        if ($lang == "1") {
                                          echo $compTypeSub2_list["compTypeSub2_name"];
                                        } elseif ($lang == "2") {
                                          echo $compTypeSub2_list["compTypeSub2_name_en"];
                                        } else {
                                          echo $compTypeSub2_list["compTypeSub2_name"];
                                        } 
                                      ?>
                                  </label>
                              </div>
                                <?php
                                }
                              }
                              ?>
                          <?php
                        }
                      }
                  }
                }
                    foreach($case_cls->comp_type as $comp_type_list){
                      if($comp_type_list["compType_id"] != 2 && $comp_type_list["compType_id"] != 3 && $comp_type_list["compType_id"] != 5){
                      ?>
                      <div class="radio-primary col-xs-12">
                                <label class="text-data-light">
                                    <input type="radio" class="rdi_compTypeSub1" id="compType_id_create_<?php echo $comp_type_list["compType_id"] ?>" name="new_type_2" value="<?php echo $comp_type_list["compType_id"] ?>" >
                                    <?php
                                        if ($lang == "1") {
                                          echo $comp_type_list["compType_name"];
                                        } elseif ($lang == "2") {
                                          echo $comp_type_list["compType_name_en"];
                                        } else {
                                          echo $comp_type_list["compType_name"];
                                        } 
                                      ?>
                                </label>
                            </div>
                    <?php } }  ?>

                  

                  </div>
              </div>
            </div>
            <div class="form-group col-md-12 div_compTypeSub1ByCompType_other" style="display:none; margin-bottom: 0px;">
              <div class="panel panel-default panel_invite_orter">
                <div class="panel-body">
                  <div class="col-xs-12">
                    <span class="col-xs-2">
                    <?php
                      if ($lang == "1") {
                        echo 'โปรดระบุ';
                      } elseif ($lang == "2") {
                        echo 'Please specify';
                      } else {
                        echo 'โปรดระบุ';
                      } 
                    ?>
                    
                  </span>
                    <div class="col-xs-6">
                      <input type="text" class="form-control compType_other_txt" name="compType_other_txt" value="" style="color:#048f78;" />
                      <input type="hidden" name="compType_other_flag" value="0" />

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php
          foreach ($case_cls->comp_type as $comp_type_list) {
            if (count($comp_type_list["compTypeSub1_list"]) > 0) {
              foreach ($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list) {
                if (count($compTypeSub1_list["compTypeSub2_list"]) > 0) {
          ?>
                  <div class="panel panel-default panel_invite_box" id="panel_invite_box_<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" style="display:none;">
                  
                    <div class="row">
                      <div class="col-md-12">
                        <div class="radio_sub_invite">
                          
                          <div class="panel-body panel-body-outer-bg2 panel-emp-assign div_compTypeSub2BycompTypeSub1" id="div_compTypeSub2BycompTypeSub1_<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" style="padding: 0px;">
                          <input type="hidden" name="rdi_compTypeSub2" id="chk_invite_step1">  
                            <div class="col-md-12 panel-body-bg2" style="padding-left: 0px;">
                              <?php
                              $s = 1;
                              foreach ($compTypeSub1_list["compTypeSub2_list"] as $compTypeSub2_list) {
                                if($s != 3) {

                              ?>
                                <div class="radio-primary col-xs-12">
                                  <input type="radio" class="rdi_compTypeSub2" id="compType2_id_create_<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" name="new_type_3" value="<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>">
                                  <label class="text-data-light" for="compType2_id_create_<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" style="margin-bottom: 8px;">
                                    <?php
                                    if ($lang == "1") {
                                      echo $compTypeSub2_list["compTypeSub2_name"];
                                    } elseif ($lang == "2") {
                                      echo $compTypeSub2_list["compTypeSub2_name_en"];
                                    } else {
                                      echo $compTypeSub2_list["compTypeSub2_name"];
                                    } ?>
                                  </label>
                                </div>
                              <?php
                                }
                                $s++;
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
          <?php
                }
              }
            }
          }
          ?>

        </div>

        <div class="btn-div">
          <?php
          $submit_text = "ตกลง";
          if ($lang == "1") {
            $submit_text = "ตกลง";
          } else if ($lang == "2") {
            $submit_text = "Submit";
          }
          ?>
          <button class="btn btn-warning form-control btn-chk-invite" type="button" id="btn-Test"><?=$submit_text;?></button>
        </div>
      </div> <!-- invite step1 -->
    </form>
  </div>
</div>


<form method="post" action="#" id="chk_invite_modal" enctype="multipart/form-data">
  <div class="modal fade" id="modal_chk_invite" tabindex="-1" role="dialog" aria-labelledby="modal_chk_invite">
    <div class="modal-dialog " id="modal_chk_invite_size" role="document" style="width:750px">
      <div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
        <div class="modal-header">
          <div class="modal-title add-group-modal-title">
            <div class="close_modal"><img src="images/btn-exit.png" onclick="close_modal_invite();"></div>
          </div>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="box-add-modal-group">
              <div class="hr_modal"><?= $txt_IMPORTANT ?></div>
              <div class="panel panel-default panel_detail panel_detail_invite_chk">
                <div class="row">
                  <div class="col-md-12 detail_invite">
                    <?php if ($_GET['type'] == 1 || !isset($_GET['type'])) { ?>
                      <div class="txt_detail_invite">1. <?= $txt_Trade_Promotion ?> </div>
                      <div class="txt_detail_invite">2. <?= $txt_petitioner_takes ?> </div>
                      <div class="txt_detail_invite">3. <?= $txt_response_after ?> </div>
                      <div class="txt_detail_invite">4. <?= $txt_Call_Centre ?> </div>
                      <div class="txt_detail_invite">5. <?= $txt_strongly ?> </div>
                      <div class="txt_detail_invite">6. <?= $txt_conflict ?> </div>
                    <?php } else {  ?>
                      <div class="txt_detail_invite"><?= $txt_understand_2 ?> </div>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="radio_chk_invite_detail">
                <label class="checkbox-inline"><input type="checkbox" name="chk_invite_detail" id="chk_invite_detail" value="1"><span class="chk_invite_detail">
                    <?= $txt_understand ?></span></label>
                <!-- <label class="checkbox-inline"><input type="checkbox" name="chk_invite_detail[]" value="2" ><span class="chk_invite_detail">การนำความเท็จมาแจ้งถือเป็นความผิด</span></label> -->
              </div>

              <div class="div-chk-detail">
                <button class="btn btn-warning form-control btn-chk-detail" name="btn-chk-detail" type="button" onclick="show_modal(1);"><?= $txt_Agree ?></button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" id="modal-footer-invite"></div>
      </div>
    </div>
  </div>
</form>

<script>
  function close_modal_invite() {

    window.location.href = '/frontend/index.php?page=home';
  }
  $(document).ready(function() {
    var country_id = <?php echo $rl['country_id']?>;
    if(country_id == 162){
      $('[name="rdi_compTypeSub1"]').val(2);
    }
    else{
      $('[name="rdi_compTypeSub1"]').val(1);
    }

    $(document).on('click', '#btn-Test', function(){
      // console.log($('[name="rdi_compType_id"]').val()); //1 //1 //6 //4
      // console.log($('[name="rdi_compTypeSub1"]').val()); //1 //1 //1 //1
      // console.log($('[name="rdi_compTypeSub2"]').val()); //9 //'' //'' //''
      // console.log($('[name="compType_other_txt"]').val()); //'' //'' //'' //'dsa'
    });

    var member_condition = $('.member_condition').val();
    if (member_condition != 2) {
      show_modal(0);
    }

    $('.slct_compTypeSub1').bind("change",function(event) {
      var compTypeSub1 = $(this).val();
      if(compTypeSub1 != ''){
        $('.div_compTypeSub1ByCompType').show();
        $('[name="rdi_compTypeSub1"]').val(compTypeSub1)
      }
    })

    $('.rdi_compTypeSub1').bind("click",function(event) {
      var compTypeSub1Id = $(this).val();
      $(".div_compTypeSub2BycompTypeSub1").hide();
      $("#div_compTypeSub2BycompTypeSub1_"+compTypeSub1Id).show();

      if(compTypeSub1Id == 4) {
        $(".div_compTypeSub1ByCompType_other").show();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(1);
      } else{
        $(".div_compTypeSub1ByCompType_other").hide();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);
      }
      // console.log(compTypeSub1Id);
      if(compTypeSub1Id == 9){
        $('[name="rdi_compTypeSub2"]').val(9)
        $('[name="rdi_compType_id"]').val(1)
      } else{
        $('[name="rdi_compType_id"]').val(compTypeSub1Id)
        $('[name="rdi_compTypeSub2"]').val('')
      }

      if(compTypeSub1Id == 6){
        $('[name="rdi_compTypeSub2"]').val(9)
      }

      
      $(".rdi_compTypeSub2").prop('checked',false);
    });

    $('.rdi_compTypeSub2').bind("click",function(event) {
      var compTypeSub2Id = $(this).val();
      $('[name="rdi_compTypeSub2"]').val(compTypeSub2Id)
    })
    

    $('.new_type_3').bind("click",function(event) {
      var new_type_3 = $(this).val();
      $('[name="rdi_compTypeSub2"]').val(new_type_3)
    })
  });

  $(document).ready(function() {

    // $(".div_compTypeSub1ByCompType_other").show();

    $('.slct_comp_type').bind("change", function(event) {
      var compTypeId = $(this).val();
      var compTypeId_other_flag = $('.slct_comp_type option[value="' + compTypeId + '"]').attr("rel");
      if (compTypeId_other_flag == 0) {
        $(".div_compTypeSub1ByCompType").css("display", "none");
        $(".panel_invite_box").css("display", "none");
        $("#div_compTypeSub1ByCompType_" + compTypeId).show();
        $('.select_invite').css("margin-bottom", "0px");
        $('div.div_compTypeSub1ByCompType').find('input').removeAttr('checked');
        $('div.div_compTypeSub2BycompTypeSub1').find('input').removeAttr('checked');
        $(".div_compTypeSub1ByCompType_other").hide();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);
      } else if (compTypeId_other_flag == 1) {
        $(".div_compTypeSub1ByCompType").css("display", "none");
        $(".panel_invite_box").css("display", "none");
        $("#div_compTypeSub1ByCompType_" + compTypeId).hide();
        $('.select_invite').css("margin-bottom", "0px");
        $('div.div_compTypeSub1ByCompType').find('input').removeAttr('checked');
        $('div.div_compTypeSub2BycompTypeSub1').find('input').removeAttr('checked');
        $(".div_compTypeSub1ByCompType_other").show();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);
      }
    });

    $('.rdi_compTypeSub1').bind("click", function(event) {
      var compTypeSub1Id = $(this).val();
      $(".panel_invite_box").css("display", "none");
      $("#panel_invite_box_" + compTypeSub1Id).show();
    });
  });
</script>