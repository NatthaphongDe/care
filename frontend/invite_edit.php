
  <?php 
  if($_POST['Org_Allvalue'] == null || $_POST['Org_Allvalue'] == ''){
    $passed_array = unserialize($_POST['Appint_personedit']);
    // print_r($passed_array);
  }else{
    $passed_array = unserialize($_POST['Org_Allvalue']);
    // print_r($passed_array);
  }
  ?>

<div class="row invite_div_row">
  <div class="col-md-12">
    <input type="hidden" name="status_chk" class="status_chk" value="">
    <span class="icon_sound_invite"><img src="images/all_icon_DITP/icon_4.svg" style="width:30px;"></span>
    <span><?=$txt_Start_petition?></span>
<form method="post" action="?page=invite_detail" id="chk_invite_step2" enctype="multipart/form-data">
  <input type="hidden" name="rdi_compType_id" value="<?php echo $_POST["rdi_compType_id"]?>">
  <input type="hidden" name="rdi_compTypeSub1" value="<?php echo $_POST["rdi_compTypeSub1"]?>">
  <input type="hidden" name="rdi_compTypeSub2" value="<?php echo $_POST["rdi_compTypeSub2"]?>">
  <input type="hidden" name="compType_other_txt" value="<?php echo $_POST["compType_other_txt"]?>">
  <input type="hidden" id="appIntOrg_selectagenORposition" name="applntOrg_nameSelect" value="<?php echo $passed_array['applntOrg_nameSelect']?>"></input>
  <input type="hidden" id="appIntOrg_countryname" name="applntOrg_country" value="<?php echo $passed_array['applntOrg_country']?>"></input>
<div class="invite_step2">
  <?php
  $caseOpn_cls = new case_open();

  $rdi_compType_id = mysqli_real_escape_string($conn,$_POST["rdi_compType_id"]);
  $rdi_compTypeSub1 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub1"]);
  $rdi_compTypeSub2 = mysqli_real_escape_string($conn,$_POST["rdi_compTypeSub2"]);

  // echo $rdi_compType_id . " " . $rdi_compTypeSub1 . " " . $rdi_compTypeSub2;

  if($rdi_compType_id == 6 || $rdi_compType_id == 4){
    $caseOpn_cls->compTypeSub1 = 0;
  }else{
    $caseOpn_cls->compTypeSub1 = $rdi_compTypeSub1;
  }
  $caseOpn_cls->compType_id = $rdi_compType_id;
  $caseOpn_cls->compTypeSub2 = $rdi_compTypeSub2;
  $arr_formSetList = $caseOpn_cls->genFromSetForCompType();

  $no = 0;
  $formSet_html = array();
  foreach ($arr_formSetList as  $formSetList_panel) {
    array_push($formSet_html,$caseOpn_cls->setFromList($formSetList_panel["frmset_id"],$formSetList_panel["frmset_name"],$no+1));
    $no++;
    // echo $formSetList_panel["frmset_id"];
  }
?>
  <div class="panel panel-default panel_datetime">
    <div class="row">
      <div class="col-md-12 form_invite">
        <div class="hr_form_invite"><?=$txt_Formula?>
          <?php
          $sql = "SELECT * FROM `Complaint_Type` WHERE compType_id='".$_POST["rdi_compType_id"]."'";
          $query = $conn->query($sql);
          $re = $query->fetch_assoc();
          if($lang == "1"){ echo $re['compType_name'];}elseif($lang == "2"){ echo $re['compType_name_en'];}else{ echo $re['compType_name'];}
          ?>
      </div>
        <div class="txt_hr_form_invite">
        <?php
        $sql_t1 = "SELECT * FROM `Complaint_Type_Sub1` WHERE compTypeSub1_id='".$_POST["rdi_compTypeSub1"]."'";
        $query_t1 = $conn->query($sql_t1);
        $re1 = $query_t1->fetch_assoc();
        if($lang == "1"){ echo $re1['compTypeSub1_name'];}elseif($lang == "2"){ echo $re1['compTypeSub1_name_en'];}else{ echo $re1['compTypeSub1_name'];}
        ?>&nbsp;
        <?php
        $sql_t2 = "SELECT * FROM `Complaint_Type_Sub2` WHERE compTypeSub2_id='".$_POST["rdi_compTypeSub2"]."'";
        $query_t2 = $conn->query($sql_t2);
        $re2 = $query_t2->fetch_assoc();
        if($lang == "1"){ echo $re2['compTypeSub2_name'];}elseif($lang == "2"){ echo $re2['compTypeSub2_name_en'];}else{ echo $re2['compTypeSub2_name'];}
        ?>
      </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">

      <?php echo $formSet_html[0]; ?>

</div>

  <div class="panel panel-default">

      <?php echo $formSet_html[1]; ?>

  </div>

  <div class="panel panel-default">

      <?php echo $formSet_html[2]; ?>

  </div>

  <div class="btn-div">
  <!-- <button class="btn btn-warning form-control btn-chk-invite-edit" type="button" onclick="btnchkinviteedit();"><?php if($lang == "1"){ echo "ตกลง";}elseif($lang == "2"){ echo "Submit";}else{ echo "ตกลง";}?></button> -->
  <button class="btn btn-warning form-control btn-chk-invite-edit" type="button"><?php if($lang == "1"){ echo "ตกลง";}elseif($lang == "2"){ echo "Submit";}else{ echo "ตกลง";}?></button>
  </div>
</div> <!-- invite_step2 -->
</form>
</div>
</div>

<script src="assets/intlTelInput/js/intlTelInput.js"></script>
<script>

$( document ).ready(function() {
  chk_prod();

  $('.btn-chk-invite-edit').on('click', function(){
    if(Check_Personinfo() != 0){
      btnchkinviteedit();
    }
  })
});

function showOther() {
    var vall = $('#appint_personcomtype').val();
    if(vall == '') {
      $("#appint_personinfo13").show();
    } else {
      $("#appint_personinfo13").hide();
    }
  
  }

$(".complnt_zipcode").keyup(function() {
    $(".complnt_zipcode").val(this.value.match(/[0-9]*/));
});
$(".complnt_zipcode_ex").keyup(function() {
    $(".complnt_zipcode_ex").val(this.value.match(/[0-9]*/));
});
$(".applntOrg_zipcode").keyup(function() {
    $(".applntOrg_zipcode").val(this.value.match(/[0-9]*/));
});
function chk_prod(){
  var chk_prod_val = $('#sel_category_invite').val();
  var chk_prod = $('#sel_category_invite option[value="'+chk_prod_val+'"]').attr("rel");
  if(chk_prod == 1){
    $('#prodType_other').show();
  }else {
    $('#prodType_other').hide();
    $('.prodType_other').val('');
  }
}
// Multiple images preview in browser
    var filePreview = function(input,file_name_only,type_file_input,callback) {
        if (input) {

            //var filesAmount = input.files.length;

            //for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                  var file_tmp = event.target.result;
                  if(typeof callback === "function"){
                  callback(file_tmp,file_name_only,type_file_input);
                }
                }

                reader.readAsDataURL(input);
            //}
        }
    };

    function del_file_invite_edit(panel_id){
      $("#panel_caseAttach_file_"+panel_id).remove();
      if($('.fileinput_file_remove').val() != ""){
        var file_remove = $('.fileinput_file_remove').val();
        var new_remove = ","+panel_id;
        $(".fileinput_file_remove").val(file_remove+new_remove);
      }else {
        $(".fileinput_file_remove").val(panel_id);
      }
    }

    function del_file_invite(panel_id){
     $("#caseAttach_file_new_"+panel_id).remove();
     if($('.fileinput_file_remove').val() != ""){
       var file_remove = $('.fileinput_file_remove').val();
       var new_remove = ","+panel_id;
       $(".fileinput_file_remove").val(file_remove+new_remove);
     }else {
       $(".fileinput_file_remove").val(panel_id);
     }
    }

    function onlynum_validate(evt) {
      var theEvent = evt || window.event;

      // Handle paste
      if (theEvent.type === 'paste') {
          key = event.clipboardData.getData('text/plain');
      } else {
      // Handle key press
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode(key);
      }
      var regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
    }


    var arr = <?php echo json_encode($_POST);?>;
  if(arr['rdi_compTypeSub1'] == '1'){
    var phone_number_info = document.querySelector(".phone-number-info");
    var intPhoneInfo = window.intlTelInput(phone_number_info, {
      // excludeCountries: ["th"],
      initialCountry: $("[name='applnt_mobile_country']").val()
    });

    var phone_number = document.querySelector(".phone-number");
    var intPhone = window.intlTelInput(phone_number, {
      // excludeCountries: ["th"],
      initialCountry: $("[name='applntOrg_mobile_country']").val()
    });

    phone_number.addEventListener("countrychange",function() {
      var ctry = intPhone.getSelectedCountryData().iso2
      var code = intPhone.getSelectedCountryData().dialCode
      $("[name='applntOrg_mobile_country']").val(ctry);
      $("[name='applntOrg_mobile_code']").val(code);
      console.log(code , ctry);
    });
    // $('.phone-number').removeAttr('data-inputmask');

    var phone_number_complnt = document.querySelector(".phone-number-complnt");
    var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
      onlyCountries: ["th"],
      initialCountry: "th"
    });
  }else{
    var phone_number_info = document.querySelector(".phone-number-info");
    var intPhoneInfo = window.intlTelInput(phone_number_info, {
      onlyCountries: ["th"],
      initialCountry: "th"
    });

    var phone_number = document.querySelector(".phone-number");
    var intPhone = window.intlTelInput(phone_number, {
      onlyCountries: ["th"],
      initialCountry: "th"
    });

    var phone_number_complnt = document.querySelector(".phone-number-complnt");
    var intPhoneCmp = window.intlTelInput(phone_number_complnt, {
      excludeCountries: ["th"],
      autoHideDialCode:true,
      initialCountry: $("[name='complnt_mobile_country']").val()
    })

    phone_number_complnt.addEventListener("countrychange",function() {
      var ctry = intPhoneCmp.getSelectedCountryData().iso2
      var code = intPhoneCmp.getSelectedCountryData().dialCode
      $("[name='complnt_mobile_country']").val(ctry);
      $("[name='complnt_mobile_code']").val(code);
      console.log(code , ctry);
    });
  }

$( document ).ready(function() {

//ส่วนอัพโหลดเอกสารประกอบการร้องเรียน


  $(".file_box").bind("click",function(event){
    $(this).val('');
  });
  $(".file_box").bind("change",function(event){
    var file_attach = $(this)[0].files;

    <?php
    if($_GET["page"]=="invite_form"){
     ?>
      $(".panel_caseAttach_file .file_box").remove();
      <?php
    }else{
      ?>
       $(".panel_caseAttach_file .caseAttach_file_new").remove();
       <?php
    }
    ?>
    $(this).parents(".fileinput").find(".fileinput-filename").text('');
    $(this).parents(".fileinput").find(".fileinput_file").val('');
    $(".fileinput_file_remove").val('');

    var count_file = $(".panel-body-list-file").length;
    if(file_attach.length<=20){
      var file_attach_length = file_attach.length;
    }else{
      var file_attach_length = 20;
      bootbox.alert("ขออภัย...ท่านสามารถเลือกไฟล์ได้ ไม่เกินครั้งละ 20 ไฟล์ และขนาดต้องไม่เกิน 10 MB ต่อไฟล์");
    }
    var idx = 0;
    <?php
    if($_GET["page"]=="invite_form"){
     ?>
     $(".panel .caseAttach_file_new").remove();
      <?php
    }
    ?>
    var alert_num = 0;
    var file_name_alert  = new Array();
    for (i=0; i < file_attach_length; i++) {
      if(i>0){
        var file_name_only = file_attach[i].name;
        var file_name = file_name+", "+file_attach[i].name;

        var file_type_only = file_attach[i].type;
        var file_type = ", "+file_attach[i].type;
      }else{
        var file_name_only = file_attach[i].name;
        var file_name = file_attach[i].name;

        var file_type_only = file_attach[i].type;
        var file_type = file_attach[i].type;
      }
      $(this).parents(".fileinput").find(".fileinput-filename").append(file_name);
      $(this).parents(".fileinput").find(".fileinput_file").val(file_name);

      if(file_attach[i].size>10485760){
        file_name_alert.push(file_attach[i].name);
        alert_num++;
      }

var type_file = file_type_only.split('/');
var type_file_input = type_file[1];
      var file_view = filePreview(this.files[i],file_name_only,type_file_input,function(file_tmp,file_name_only_tmp,type_file_input_xr){
        if(idx<20){

          var elm_panel_id = "caseAttach_file_new_"+idx;
          var elm_panel = "caseAttach_file_new";
          var gen_html = '<div class="panel '+elm_panel+'" id="'+elm_panel_id+'" style="margin-top:20px;">\
                          <div class="panel-body panel-body-list-file">\
                              <ul class="list-file col-sm-12">\
                              <li class="no-gutter">\
                                <div class="col-xs-12 col-sm-1">\
                                <input type="hidden" name="type_file_xr[]" value="'+type_file_input_xr+'">';
                                if(type_file_input_xr == "pdf"){
                                gen_html +='<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "jpeg" || type_file_input_xr == "jpg" || type_file_input_xr == "png") {
                                  gen_html +='<i class="fa fa-file-image-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "docx") {
                                  gen_html +='<i class="fa fa-file-word-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "ppt") {
                                  gen_html +='<i class="fa fa-file-powerpoint-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }else if (type_file_input_xr == "xlsx" || type_file_input_xr == "xls") {
                                  gen_html +='<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:45px;"></i>';
                                }
                                gen_html +='</div>\
                                <div class="col-xs-12 col-sm-6 list_file_name">\
                                  <input type="text" name="caseAttach_file_name[]" id="caseAttach_file_name'+idx+'" class="form-control" placeholder="กรุณาระบุหัวข้อของไฟล์แนบ" required />\
                                  <p>'+file_name_only_tmp+'</p>\
                                  <input type="hidden" name="caseAttach_file_id[]" />\
                                  <input type="hidden" name="new_fileadrss[]" id="new_fileadrss'+idx+'" value="'+file_name_only_tmp+'" />\
                                </div>\
                                <div class="col-xs-12 col-sm-3">\
                                  <p>Date : <?php echo date('d/m/Y') ?></p>\
                                </div>\
                                <div class="col-xs-12 col-sm-2 col-btn-file" style="text-align:right;">\
                                <span class="icon_del"><a onclick="del_file_invite('+idx+');"><img src="images/icon_delete.png" style="margin-top:18px;"></a></span>\
                                </div>\
                              </li>\
                              </ul>\
                          </div>\
                      </div>';
            $(".panel_caseAttach_file").append(gen_html);
        }
        idx++;

      });

    }

    if(alert_num>0){
              bootbox.alert("ขออภัย...ไฟล์เอกสาร "+file_name_alert.join(" , ")+" มีขนาดใหญ่เกินไป กรุณาอัพโหลดไฟล์เอกสารขนาดไม่เกิน 10 MB !",function(){
                $(".fileinput_file").val('');
                $(".fileinput-filename").text('');
                $(".caseAttach_file_new").remove();
              });
            }

  });

  $('#selecttype_comp').on('change', function(){
    if($(this).val() == 0){
      $('#inputtype_comp').css('display', 'flex');
    }else{
      $('#inputtype_comp').css('display', 'none');
      $('#inputtype_comp').val('');
    }
  });

  

  var appint_infoperson = <?php echo json_encode($passed_array['appint_personinfo'])?>;
  var appint_infoperson2 = <?php echo json_encode($passed_array['appint_personinfo2'])?>;
  $.each(appint_infoperson, function(index, value){
    $('[name="appint_personinfo[]"]:eq('+ index +')').val(appint_infoperson[index]);
  });
  
  
  var nameSelect = "<?php echo $_POST['applnt_type']?>";
    console.log(nameSelect);
  if(nameSelect == "1"){
    $('#CheckboxagentDefault').attr('checked', true);
    $('#collapseagent').addClass('in');
    var Represent = <?php echo json_encode($passed_array['appint_personinfo1'])?>;
    var comptype = '<?php echo $_POST['appint_personinfo13']?>';
    var selectbool = true;
    $('[name="appint_personinfo13"]').val(comptype);
    $.each(Represent, function(index, value){
      if(index == 2){
        $('#appint_personcomtype option[value='+ Represent[index] +']').attr('selected', true);
        if(Represent[index] != 0){
          $('#appint_personinfo13').css('display', 'none');
        }
        
      }else{
        $('[name="appint_personinfo1[]"]:eq('+ index +')').val(Represent[index]);
      }
    })

    var Country_id = "<?php echo $passed_array['applnt_countryid_idx']?>";
    $('.country_newpanel option[value='+ parseInt(Country_id) +']').attr('selected', true);
  }else if(nameSelect == "2"){
    $('#CheckboxpersonDefault').attr('checked', true);
    $('#collapseperson').addClass('in');
    var Natural = <?php echo json_encode($passed_array['appint_personinfo2'])?>;
    console.log(Natural);
    $('[name="appint_personinfo2[]"]').val(Natural);
  }

  $('.Newpanel-body input[type="checkbox"]').on('change', function() {
    $('.Newpanel-body input[type="checkbox"]').not(this).prop('checked', false);
    if($(this).is(":checked") == false && $(this).not(this).is(":checked") == false)
      $(this).prop('checked', true);
    else{
      if($(this).parent().parent().find('.collapse').hasClass('in'))
        $(this).parent().parent().find('.collapse').removeClass('in')
      else
        $(this).parent().parent().find('.collapse').addClass('in')
      if($('.Newpanel-body input[type="checkbox"]').not(this).parent().parent().find('.collapse').hasClass('in'))
        $('.Newpanel-body input[type="checkbox"]').not(this).parent().parent().find('.collapse').removeClass('in')
      }
  });

  $('#up_square').on('click', function(){
    if($('#multiCollapse').hasClass('in')){
      $('.Newpanel-header').css('height', '60px');
      $('#multiCollapse').removeClass('in');
      $(this).addClass('bi-caret-down-square-fill');
      $(this).removeClass('bi-caret-up-square');
    }else{
      $('.Newpanel-header').css('height', 'auto');
      $('#multiCollapse').addClass('in');
      $(this).addClass('bi-caret-up-square');
      $(this).removeClass('bi-caret-down-square-fill');
    }
  })


  

  // $('[name=Represent_value]').val();

  });
</script>
<style>
.icon-ico-ditp-43{
  display: inline-block;
  position: relative;
  top: -2px;
}
.bootstrap-select.btn-group .dropdown-menu li a.opt{
  padding-left: 5px;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option span{
  padding-left: 0px !important;
}
.btn .txt{
  margin-left: 0px !important;
  top: 1px;
  padding-left: 5px !important;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option .icon-ico-ditp-43{
  display: none;
}
</style>
