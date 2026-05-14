
<?php
if(count($caseLst_cls->comp_type==0)){
  $caseLst_cls->comp_type = $caseLst_cls->compTypeList(null,$caseLst_cls->admin_section);
}
?>
  <div class="modal fade" id="model_create_case" tabindex="-1" role="dialog" aria-labelledby="model_assign_label" aria-hidden="true">
    <form name="frm-modal-create-case" id="frm-modal-create-case" method="post" action="function.php?method=createcase_init" target="iframe-data">
      <input type='hidden' class="index_page_type_modal" name='index_page_type' value='setting' />
      <input type="text" hidden name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                      <i class="ditp-icon icon-ico-ditp-20"></i>
                  </button>
                  <h4 class="modal-title">ตั้งเรื่องร้องเรียน</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label class="col-xs-12 control-label text-data-size16 div_comp_type">เลือกประเภทเรื่องร้องเรียน</label>
                    <div class="col-xs-12">
                        
                        <?php if(empty($_GET['test'])){ ?>
                          <input type="hidden" name="rdi_compTypeSub1" >
                          <select name="new_type_1" class="custom-select select-black select-light slct_compTypeSub1">
                        <option value="">
                          --- เลือกประเภทเรื่องร้องเรียน ---
                        </option>
                    <?php
                    foreach($caseLst_cls->comp_type as $comp_type_list){
                      if(count($comp_type_list["compTypeSub1_list"])>0){
                        ?>
                        
                        <?php
                          foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                            if($_SESSION["admin"]["empPosition"] == 6 && $compTypeSub1_list["compTypeSub1_id"] ==2){
                              continue;
                            }
                            ?>
                            <option value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" >
                            <?php echo $compTypeSub1_list["compTypeSub1_name"] ?>
                            </option>
                            <?php
                          }
                          ?>
                        <?php
                      }
                    } ?>
                    </select>
                   <?php 
                  } else { ?>

                        <select name="rdi_compType_id" class="custom-select select-black select-light slct_comp_type">
                        <option value="">
                          --- เลือกประเภทเรื่องร้องเรียน ---
                        </option>

                        <?php
                        if($_SESSION["admin"]["empPosition"] == 6){
                          foreach($caseLst_cls->comp_type as $comp_type_list){ 
                            if($comp_type_list["compType_id"] == 1){
                            ?>
                            <option value="<?php echo $comp_type_list["compType_id"] ?>" rel="<?php echo $comp_type_list["compType_other_flag"] ?>">
                              <?php echo $comp_type_list["compType_name"] ?>
                            </option>
                            <?php
                          } }
                        } else {
                          foreach($caseLst_cls->comp_type as $comp_type_list){
                            ?>
                            <option value="<?php echo $comp_type_list["compType_id"] ?>" rel="<?php echo $comp_type_list["compType_other_flag"] ?>">
                              <?php echo $comp_type_list["compType_name"] ?>
                            </option>
                            <?php
                          }
                        } ?>
                        </select>
                        <?php  } ?>

                  

                      
                    </div>
                  </div>

                  <?php if(empty($_GET['test'])){ ?>
                  <div class="form-group col-md-12 div_compTypeSub1ByCompType" id="div_compTypeSub1ByCompType_<?php echo $comp_type_list["compType_id"] ?>"  style="margin-bottom:0px; display:none;">
                  <input type="hidden" name="rdi_compType_id" >
                  <?php 
                  foreach($caseLst_cls->comp_type as $comp_type_list){
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
                                      <?php echo $compTypeSub2_list["compTypeSub2_name"] ?>
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
                ?>
                  
                  <?php
                  if($_SESSION["admin"]["empPosition"] == 6){
                    foreach($caseLst_cls->comp_type as $comp_type_list){ 
                      if($comp_type_list["compType_id"] == 1){
                      ?>
                      <div class="radio-primary col-xs-12">
                                <label class="text-data-light">
                                    <input type="radio" class="rdi_compTypeSub1" id="compType_id_create_<?php echo $comp_type_list["compType_id"] ?>" name="new_type_2" value="<?php echo $comp_type_list["compType_id"] ?>" >
                                    <?php echo $comp_type_list["compType_name"] ?>
                                </label>
                            </div>
                      <?php
                    } }
                  } else {
                    foreach($caseLst_cls->comp_type as $comp_type_list){
                      ?>
                      <div class="radio-primary col-xs-12">
                                <label class="text-data-light">
                                    <input type="radio" class="rdi_compTypeSub1" id="compType_id_create_<?php echo $comp_type_list["compType_id"] ?>" name="new_type_2" value="<?php echo $comp_type_list["compType_id"] ?>" >
                                    <?php echo $comp_type_list["compType_name"] ?>
                                </label>
                            </div>
                      <?php
                    }
                  } ?>

                  

                  </div>

                  

                  <?php } else { ?>

                    <?php
                    foreach($caseLst_cls->comp_type as $comp_type_list){
                      if(count($comp_type_list["compTypeSub1_list"])>0){
                        ?>
                        <div class="form-group col-md-12 div_compTypeSub1ByCompType" id="div_compTypeSub1ByCompType_<?php echo $comp_type_list["compType_id"] ?>"  style="margin-bottom:0px; display:none;">
                        <?php
                          foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                            if($_SESSION["admin"]["empPosition"] == 6 && $compTypeSub1_list["compTypeSub1_id"] ==2){
                              continue;
                            }
                            ?>
                            <div class="radio-primary col-xs-12">
                                <label class="text-data-light">
                                    <input type="radio" class="rdi_compTypeSub1" id="compType_id_create_<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" name="rdi_compTypeSub1" value="<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" >
                                    <?php echo $compTypeSub1_list["compTypeSub1_name"] ?>
                                </label>
                            </div>
                            <?php
                          }
                          ?>
                        </div>
                        <?php
                      }
                    }
                    ?>
                     <?php } ?>
                  <div class="form-group col-md-12 div_compTypeSub1ByCompType_other" style="display:none;">
                    <div class="col-xs-12" style="">
                      <label class="col-xs-2 control-label">โปรดระบุ</label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" name="compType_other" value="" style="color:#048f78;" />
                        <input type="hidden" name="compType_other_flag" value="0" />

                      </div>
                    </div>
                  </div>

                </div>

                <?php
                foreach($caseLst_cls->comp_type as $comp_type_list){
                  if(count($comp_type_list["compTypeSub1_list"])>0){
                      foreach($comp_type_list["compTypeSub1_list"] as $compTypeSub1_list){
                        if(count($compTypeSub1_list["compTypeSub2_list"])>0){
                          ?>
                          <div class="panel-body panel-body-outer-bg2 panel-emp-assign div_compTypeSub2BycompTypeSub1" id="div_compTypeSub2BycompTypeSub1_<?php echo $compTypeSub1_list["compTypeSub1_id"] ?>" style="margin-left:20px; padding:0px 10px 10px 10px; display:none;">
                          <input type="hidden" name="rdi_compTypeSub2" >
                            <div class="col-md-12 panel-body-bg2">
                              <div class="col-xs-12">
                                  <label class="text-data-size16">
                                      เลือกกรณีการร้องเรียนที่เกิดขึ้น
                                  </label>
                              </div>

                              <?php
                              foreach($compTypeSub1_list["compTypeSub2_list"] as $compTypeSub2_list){
                                if($compTypeSub2_list["compTypeSub2_id"] != 9){
                                ?>
                                <div class="radio-primary col-xs-12">
                                    <label class="text-data-light">
                                        <input type="radio" class="rdi_compTypeSub2" id="compType_id_create_<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" name="new_type_3" value="<?php echo $compTypeSub2_list["compTypeSub2_id"] ?>" >
                                        <?php echo $compTypeSub2_list["compTypeSub2_name"] ?>
                                    </label>
                                </div>
                                <?php
                                }
                              }
                              ?>
                            </div>
                          </div>
                          <?php
                        }
                      }
                  }
                }
                ?>


              </div>
              <div class="modal-footer" style="text-align:center">
                  <button type="submit" class="btn btn-success">ตกลง</button>
              </div>
          </div>
      </div>
    </form>
  </div>

<script>
$(document).ready(function() {
    $('.slct_comp_type').bind("change",function(event) {
      var compTypeId = $(this).val();
      var compTypeId_other_flag = $('.slct_comp_type option[value="'+compTypeId+'"]').attr("rel");
      if(compTypeId_other_flag==0){
        $(".div_compTypeSub1ByCompType").hide();
        $(".div_compTypeSub2BycompTypeSub1").hide();
        $("#div_compTypeSub1ByCompType_"+compTypeId).show();
        $(".rdi_compTypeSub1").prop('checked',false);
        $(".rdi_compTypeSub2").prop('checked',false);
        $(".div_compTypeSub1ByCompType_other").hide();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);
      }else if(compTypeId_other_flag==1){
        $(".div_compTypeSub1ByCompType").hide();
        $(".div_compTypeSub2BycompTypeSub1").hide();
        $("#div_compTypeSub1ByCompType_"+compTypeId).hide();
        $(".rdi_compTypeSub1").prop('checked',false);
        $(".rdi_compTypeSub2").prop('checked',false);
        $(".div_compTypeSub1ByCompType_other").show();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(1);
      }
    });
    
    $('.slct_compTypeSub1').bind("change",function(event) {
      $('.div_compTypeSub1ByCompType').slideUp(300);

      $(".div_compTypeSub2BycompTypeSub1").hide();
      $('.div_compTypeSub2BycompTypeSub1').find('input[type="radio"]').prop('checked', false);

      $('.rdi_compTypeSub1').prop('checked', false);
      $('input[name="compType_other"]').val('');
      $(".div_compTypeSub1ByCompType_other").hide();
      $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);

      var compTypeSub1 = $(this).val();
      if(compTypeSub1 != ''){
        $('.div_compTypeSub1ByCompType').slideDown(300);
        $('[name="rdi_compTypeSub1"]').val(compTypeSub1)
      }
    })

    $('.rdi_compTypeSub1').bind("click",function(event) {
      var compTypeSub1Id = $(this).val();

      $('[name="rdi_compType_id"]').val('');
      $('[name="rdi_compTypeSub2"]').val('');

      $(".div_compTypeSub2BycompTypeSub1").hide();
      $('.div_compTypeSub2BycompTypeSub1').find('input[type="radio"]').prop('checked', false);
      $("#div_compTypeSub2BycompTypeSub1_"+compTypeSub1Id).show();

      $('input[name="compType_other"]').val('');

      if(compTypeSub1Id == 4) {
        $(".div_compTypeSub1ByCompType_other").show();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(1);
      } else{
        $(".div_compTypeSub1ByCompType_other").hide();
        $(".div_compTypeSub1ByCompType_other input[name='compType_other_flag']").val(0);
      }

      if(compTypeSub1Id == 9){
        $('[name="rdi_compTypeSub2"]').val(9)
        $('[name="rdi_compType_id"]').val(1)
      } else{
        $('[name="rdi_compType_id"]').val(compTypeSub1Id)
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
</script>
<style>
#model_create_case *{
  text-align: left;
}
</style>
