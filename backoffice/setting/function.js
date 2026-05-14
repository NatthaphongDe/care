function ConfirmDelete()
{
  var x = confirm("ยืนยันการลบข้อมูล ? ");
  if (x)
      return true;
  else
    return false;
}
function Confirmupdown()
{
  var x = confirm("ยืนยันการเปลี่ยนลำดับ? ");
  if (x)
      return true;
  else
    return false;
}

function Confirm_password() {
  var x = confirm("ยืนยันการขอรหัสผ่าน ? ");
  if (x)
      return true;
  else
    return false;
}

function edit_channel(id_channel,id_del) {


  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขช่องทางการรับเรื่องร้องเรียน");

  if(id_del==0){
    $('.channel_hide').show();
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดช่องทางการรับเรื่องร้องเรียน");
  }else if(id_del==1){
    $('.channel_hide').hide();
  }else{
    $('.channel_hide').show();
  }

  $('#id_channel').val()
   $(".bs-example-modal-lg_edit").modal('show');
   $("#id_edit").val(id_channel);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_channel&id="+id_channel,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
   		// 	alert(JSON.stringify(result));
   			$("#edit_name").val(result.caseCh_name);
   			if(result.caseCh_enable == '0'){
   				document.getElementById("ch2_edit").checked = true;
   			}else{
   				document.getElementById("ch1_edit").checked = true;
   			}
        if(result.caseCh_section == '1'){
          document.getElementById("ch1_section").checked = true;
        }else{
          document.getElementById("ch2_section").checked = true;
        }
   		}
   	});
    view_date(id_del);
}

function changestatus_chanel(val, ch_id) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"changestatus_chanel",
              change_id : ch_id,
              change_val : val,
            },
      success: function(result){
        console.log(result);
        // console..card-block(result);
        if(result==11){
          iziToast_func.success('เปลี่ยนสถานะเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('เปลี่ยนสถานะผิดพลาด');
      }
    }
  });
}

function del_channel(del_id) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_channel",
              del_id : del_id
            },
      success: function(result){
        // console..card-block(result);
        if(result==11){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}

function del_product(id_p) {
  // console.log(id_p);
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_product",
              id_p : id_p
            },
      success: function(result){
        if(result==11){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}


function edit_product(id,type_del) {
      $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
      $(".title_view").html("แก้ไขประเภทสินค้า");

    if(type_del == 0){
      $('.product_del_none').css('display','block');
      $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
      $(".title_view").html("รายละเอียดประเภทสินค้า");
    }else if(type_del==1){
      $('.product_del_none').css('display','none');
    }else{
      $('.product_del_none').css('display','block');
    }
   $(".edit_product").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_prouuct&id="+id,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
        $("#edit_name").val(result.name);
     		$("#edit_name_en").val(result.name_en);
   			if(result.enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
   			}
        if(result.prodType_other_flag==1){
          document.getElementById("ra_edit_oth1").checked = true;
        }else if(result.prodType_other_flag==0){
          document.getElementById("ra_edit_oth2").checked = true;
        }else{
          document.getElementById("ra_edit_oth1").checked = false;
          document.getElementById("ra_edit_oth2").checked = false;

        }
        //$(".office_name option[value='"+result.office_id+"']").prop("selected",true);

   		}
   	});
    view_date(type_del);
}


function edit_product_detail(id,type_del) {
  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขประเภทสินค้า");
  if(type_del == 0){
    document.getElementById("product_del_none").style.display = "block";
    // $('.product_del_none').show();
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดประเภทสินค้า");
  }else if(type_del==1){
    // $('.product_del_none').hide();
    document.getElementById("product_del_none").style.display = "none";
  }else{
    // $('.product_del_none').show();
    document.getElementById("product_del_none").style.display = "block";
  }
   $(".edit_product").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_prouuct_detail&id="+id,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
   		// 	alert(JSON.stringify(result));
        $("#edit_name").val(result.name);
   			$("#edit_name_en").val(result.name_en);
   			if(result.enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
   			}
        if(result.level==2|| result.level==3){
          $('#office').val('');
          $(".office_name option[value='"+result.office_id+"']").prop("selected",true);
        }
   		}

   	});
    view_date(type_del);
}


function del_product_detail(id_p) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_product_detail",
              id_p : id_p
            },
      success: function(result){
        if(result==11){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}
function sub_type_complaint() {
  var id_type =   $('#Complaint_Type').val();
  if(id_type==0){
    $('#sub_type_complaint').hide();
    $('.hid_day').show();
    exit();
  }else {
      $('#sub_type_complaint').show();
      $('.hid_day').hide();
  }
      $.ajax({
        url: "method.php",
        type: "post",
        async:false,
        data: { id_type:id_type , method:"sub_type_complaint" },
        success: function(result){
          // console.log(result);
          $("#sub_type_complaint").html(result);
          $('.selectpicker').selectpicker('refresh');
        }
      });
}


function view_date(hide_edit) {
  if(hide_edit==0){
    document.getElementById("view_date").disabled = true;
    var nodes = document.getElementById("view_date").getElementsByTagName('*');
    for(var i = 0; i < nodes.length; i++){
      nodes[i].disabled = true;
    }
    $("#view_date").find(".hidden_field").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).attr("type","text");
      $(this).removeClass("hidden_field");
    });
    $("#view_date").find("input[type='text']").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).after('<label class="show_val control-label">'+text_label+'</label>');
      $(this).attr("type","hidden");
      $(this).addClass("hidden_field");
    });

    $("#view_date").find(".hidden_field_textarea").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).parent().find(".hidden_field_textarea").show();
      $(this).removeClass("hidden_field_textarea");
    });
    $("#view_date").find("textarea").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).after('<label class="show_val control-label">'+text_label+'</label>');
      $(this).hide();
      $(this).addClass("hidden_field_textarea");
    });

    $("#view_date").find(".hidden_field_email").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).attr("type","email");
      $(this).removeClass("hidden_field_email");
    });
    $("#view_date").find("input[type='email']").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).after('<label class="show_val control-label">'+text_label+'</label>');
      $(this).attr("type","hidden");
      $(this).addClass("hidden_field_email");
    });
  }else{
    document.getElementById("view_date").disabled = true;
    var nodes = document.getElementById("view_date").getElementsByTagName('*');
    for(var i = 0; i < nodes.length; i++){
      nodes[i].disabled = false;
    }
    $("#view_date").find(".hidden_field").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).attr("type","text");
      $(this).removeClass("hidden_field");
    });
    $("#view_date").find(".hidden_field_textarea").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).parent().find(".hidden_field_textarea").show();
      $(this).removeClass("hidden_field_textarea");
    });
    $("#view_date").find(".hidden_field_email").each(function(index, el) {
      var text_label  = $(this).val();
      // console.log(text_label);
      $(this).parent().find(".show_val").remove();
      $(this).attr("type","email");
      $(this).removeClass("hidden_field_email");
    });
  }
  $('.selectpicker').selectpicker('refresh');
}


function edit_process(id,hide_edit) {

    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
    $(".title_view").html("แก้ไขประเภทกระบวนการ");

    if(hide_edit==0){
      $('.hide_edit').show();
      $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
      $(".title_view").html("รายละเอียดกระบวนการ");
    }else if(hide_edit==1){
      $('.hide_edit').show();
    }else{
      $('.hide_edit').hide();
    }


   $(".edit_product").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_process&id="+id,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
   		// 	alert(JSON.stringify(result));

   			$("#edit_name").val(result.process_type_name);
        $("#edit_day").val(result.process_type_duration);
        $("#message_in").val(result.process_type_message_in);
        $("#message_out").val(result.process_type_message_out);
        $("#message_noti").val(result.process_type_message_noti);
        $("#message_in_en").val(result.process_type_message_in_en);
        $("#message_out_en").val(result.process_type_message_out_en);
        $("#message_noti_en").val(result.process_type_message_noti_en);
        if(id==1 || id==2){
          $('.hide_back').hide();
          $('.b1').hide();
            $('.b2').show();
        }else{
          $('.hide_back').show();
          $('.b1').show();
          $('.b2').hide();

        }
        if(result.process_typ_contact == '1'){
          $('.hide_depart').show();
   				document.getElementById("contact_edit_1").checked = true;
          $("#Depart_type option[value='"+result.dept_type+"']").prop('selected',true);
   			}else{
          $('.hide_depart').hide();
          document.getElementById("contact_edit_2").checked = true;
   			}
        if(hide_edit==2){
          $('.hide_depart').hide();
        }else {
          if(result.process_typ_contact == '1'){
            $('.hide_depart').show();
          }else{
            $('.hide_depart').hide();
          }
        }

   			if(result.process_type_section == '1'){
   				document.getElementById("ch1_section_edit").checked = true;
   			}else{
          document.getElementById("ch2_section_edit").checked = true;
   			}
        if(result.process_type_step == '1'){
   				document.getElementById("ch1_step_edit").checked = true;
   			}else if (result.process_type_step == '2'){
          document.getElementById("ch2_step_edit").checked = true;
        }else if (result.process_type_step == '3'){
          document.getElementById("ch3_step_edit").checked = true;
        }else if (result.process_type_step == '4'){
          document.getElementById("ch4_step_edit").checked = true;
        }
        if(result.process_type_enable == '1'){
   				document.getElementById("ch1_enable_edit").checked = true;
   			}else{
          document.getElementById("ch2_enable_edit").checked = true;
   			}

   		}
   	});
    view_date(hide_edit);
}

function del_process(id_p) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_process",
              id_p : id_p
            },
      success: function(result){
        if(result==11){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}

function chech_section(id) {
  $('.hid_day').show();
  $.ajax({
    url: "method.php",
    type: "post",
    async:false,
    data: { id:id , method:"chech_section" },
    success: function(result){
      // console.log(result);
      $(".chech_section").html(result);
      $(".sub_type_complaint").hide();
      $('.selectpicker').selectpicker('refresh');
    }
  });
}


function edit_complaint(type,id_edit,none) {
  $('.edit_complaint').modal();
  if(type!=1){
    $('.hid_day').hide();
  }else{
    $('.hid_day').show();
  }
  if(none==0){
    $('.hid_day').hide();
  }else{
    $('.hid_day').show();
  }

    $.ajax({
      url: "method.php",
      data : {
                method : "get_data_complaint",
                type : type,
                id_edit : id_edit
              },
      dataType:"json",
      type : "POST",
        success: function(result){
          $("#edit_name").val('');
          $("#edit_name_en").val('');

          if(result.type==1){
              $("#edit_name").val(result.compType_name);
              $("#edit_name_en").val(result.compType_name_en);
              $("#edit_day").val(result.compType_duration);

              if(result.compType_other_flag == '1'){
                document.getElementById("ra_edit_oth1").checked = true;
              }else if(result.compType_other_flag == '0'){
                document.getElementById("ra_edit_oth2").checked = true;
              }else {
                document.getElementById("ra_edit_oth2").checked = false;
                document.getElementById("ra_edit_oth1").checked = false;
              }

              $("#id_edit").val(id_edit);
              $("#type").val(type);
          }else if(result.type==2){
            $("#edit_name").val(result.compTypeSub1_name);
              $("#edit_name_en").val(result.compTypeSub1_name_en);
              $("#id_edit").val(id_edit);
              $("#type").val(type);
          }else if(result.type==3){
              $("#edit_name").val(result.compTypeSub2_name);
              $("#edit_name_en").val(result.compTypeSub2_name_en);
              $("#id_edit").val(id_edit);
              $("#type").val(type);
          }
        }
    });

}

function del_complaint(type,id_del) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_complaint",
              type : type,
              id_del : id_del
            },
      success: function(result){
        // console.log(result);
        if(result==11){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });

}
function get_form() {
  $(".grt_form").html('');
  var search_text = $('#search_text').val();
  if(search_text==''){
    search_text ='';
  }
var id_ch1 =   $('#id_ch1').val();
var id_ch2 =   $('#id_ch2').val();
var id_ch3 =   $('#id_ch3').val();

    $.ajax({
      url: "method.php",
      type: "post",
      async:false,
      data: { search_text:search_text ,
              method:"get_form" ,
              id_ch1 : id_ch1 ,
              id_ch2 : id_ch2 ,
              id_ch3 : id_ch3
            },
      success: function(result){
        $(".grt_form").html(result);
      }
    });
    $( "#sortable_main" ).sortable({
       connectWith: ["#sortable1","#sortable2","#sortable3"],
       receive: function(event, ui) {
         countSetForm--;
         $("input[name='countFormset']").val(countSetForm);
         var id_ch = $(ui.item).attr("value");
         var id = $(ui.item).attr("rel");
         if(id==1){
             $('#id_ch1').val('');
         }else if(id==2){
             $('#id_ch2').val('');
         }else if(id=3){
             $('#id_ch3').val('');
         }
       }

    });

}


function select_formset(type_from,id1,id2,id3) {
    $("#type_from").val(type_from);
    $("#id_add1").val(id1);
    $("#id_add2").val(id2);
    $("#id_add3").val(id3);
    $("#add_edit").val(1);


    var search_frm = $("#search_frm").val();
      $.ajax({
        url: "method.php",
        type: "post",
        async:false,
        data: { search_frm:search_frm , method:"search_frm" , id_form : '' ,ty:'1' },
        success: function(result){
          $(".border_table").html(result);
          $(".modal_select_from").modal('show');
        }
      });
}

function select_formset_edit(type_from,id1,id2,id3,id_form) {
    $(".modal_select_from").modal('show');
    $("#type_from").val(type_from);
    $("#id_add1").val(id1);
    $("#id_add2").val(id2);
    $("#id_add3").val(id3);
    $("#add_edit").val(2);
    $("#id_form").val(id_form);



    var search_frm =    $("#search_frm").val();
      $.ajax({
        url: "method.php",
        type: "post",
        async:false,
        data: { search_frm:search_frm , method:"search_frm" , id_form : id_form ,ty:'1' },
        success: function(result){
          // alert(JSON.stringify(result));
          $(".border_table").html(result);
          $(".modal_select_from").modal('show');
          document.getElementById("form_set_"+id_form).checked = true;
        }
      });
}

function copy_from(id) {
   $(".copy_from").modal('show');
   $("#cop_id").val(id);
}

function del_form(id_p) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_form",
              id_p : id_p
            },
      success: function(result){
        if(result==00){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}


function edit_priority(id,hide_edit) {
  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไข Priority");
  if(hide_edit==0){
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียด Priority");
    $('.hide_edit').show();
  }else if(hide_edit==1){
    $('.hide_edit').hide();
  }else{
    $('.hide_edit').show();
  }
   $(".modal_edit_priority").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_priority&id="+id,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
   			$("#edit_name").val(result.casePrt_name);
        $('.color_edit').minicolors('value', result.casePrt_color);
   			if(result.casePrt_section == '1'){
   				document.getElementById("ch1_section_edit").checked = true;
   			}else{
          document.getElementById("ch2_section_edit").checked = true;
   			}
        if(result.casePrt_enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
   			}
   		}
   	});
    view_date(hide_edit);
}


function edit_country(id,id_edit) {
  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขข้อมูลประเทศ");
  $('.box_impo').show();
  if(id_edit==0){
    document.getElementById("none_country").style.display = "block";
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดประเทศ");
    $('.box_impo').hide();
  }else if(id_edit==1){
    document.getElementById('none_country').style.display='none';
  }else{
    document.getElementById("none_country").style.display = "block";
  }
   $(".edit_country").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_country&id="+id,
   		dataType:"json",
      async: false,
   		type : "POST",
   		success: function(result){
        // console.log(result.pic);
   		// 	alert(JSON.stringify(result));
      $(".pre_edit").html(result.pic);

   			$("#edit_name_th").val(result.name_th);
        $("#edit_name_en").val(result.name);
   			if(result.country_enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
        }
        $(".continent_code_edit option[value='"+result.continent_code+"']").prop("selected",true);
        $('#default_img').val(result.path_view);
        $('.edit_pre_hide').hide();
        $('.pre_edit').show();

   		}
   	});
    view_date(id_edit);
}



function del_priority(id_p) {
  // console.log(id_p);
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_priority",
              id_p : id_p
            },
      success: function(result){
        // console.log(result);
        if(result==00){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}



function del_country(id_p) {
  // console.log(id_p);
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"del_country",
              id_p : id_p
            },
      success: function(result){
        // console.log(result);
        if(result==00){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}


function edit_holiday(id,type_del) {


  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขวันหยุดราชการ");
  if(type_del == 0){
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดวันหยุดราชการ");
    $('.hide_show').hide();
  }else {
    $('.hide_show').show();
  }




   $(".edit_holiday").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_holiday&id="+id,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
        var inputDate_start = result.holiday_date_start;
        var newDat_start = changeDateFormat(inputDate_start);
        var inputDate_end = result.holiday_date_end;
        var newDate_end = changeDateFormat(inputDate_end);

   			$("#edit_name").val(result.holiday_name);
        $("#date_start_edit").val(newDat_start);
        $("#date_stop_edit").val(newDate_end);
        $("#year option[value='"+result.holiday_year+"']").prop('selected',true);
        $('.selectpicker').selectpicker('refresh');
   		}
   	});
    view_date(type_del);
}


function changeDateFormat(inputDate){  // expects Y-m-d
   var splitDate = inputDate.split('-');
   if(splitDate.count == 0){
       return null;
   }
     var year = splitDate[0];
     var month = splitDate[1];
     var day = splitDate[2];
     return day + '/' + month + '/' + year;
}


function del_holiday(id_p) {
  // console.log(id_p);
  $.ajax({
    url: "method.php",
    type : "POST",
    data : { method:"del_holiday", id_p : id_p },
      success: function(result){
        if(result==00){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
        }
    }
  });
}


function search_frm_keypress(e) {
      if ( e.keyCode == 13 ) {
        var search_frm =    $("#search_frm").val();
        var ss= $("#sear_frm").val();
        if(typeof ss === 'undefined'){
          ss = '';
        }
        var id_form = $("#id_form").val();
          $.ajax({
            url: "method.php",
            type: "post",
            async:false,
            data: { search_frm:search_frm , method:"search_frm" , ssf : ss },
            success: function(result){
              // alert(JSON.stringify(result));
              $("#get_select").html(result);
              document.getElementById("form_set_"+id_form).checked = true;
            }
          });
      }
}



function search_frm_load_edit() {



}



function add_blacklist(){
  var anyBoxesChecked = false;
  $('.checkbox_black_sub').each(function() {
    if ($(this).is(":checked")) {
      anyBoxesChecked = true;
    }
  });

  if (anyBoxesChecked == false) {
    iziToast_func.alert('Please select at least one checkbox');
    return false;
  }

  var chked = new Array();
  $(".checkbox_black_sub").each(function(){
    if($(this).prop('checked')==true){
      chked.push($(this).val());
      // console.log(chked.push($(this).val()));
    }
  });
  $.ajax({
    url: "method.php",
    data : {
              method:"add_blacklist",
              id_obj : chked
            },
    type : "POST",
    success: function(result){
      	// alert(JSON.stringify(result));
        // console.log(result);
      if(result='00'){
        iziToast_func.alert('บันทึก Blacklist สำเร็จ')

        location.reload();
      }else {
        iziToast_func.alert('ไม่สามารถเพิ่มข้อมูล Blacklist ได้')
      }
    }
  });
}

function del_blacklist(){
  var anyBoxesChecked = false;
  $('.checkbox_black_sub_del').each(function() {
    if ($(this).is(":checked")) {
      anyBoxesChecked = true;
    }
  });

  if (anyBoxesChecked == false) {
    iziToast_func.alert('Please select at least one checkbox');
    return false;
  }

  var chked = new Array();
  $(".checkbox_black_sub_del").each(function(){
    if($(this).prop('checked')==true){
      chked.push($(this).val());
      // console.log(chked.push($(this).val()));
    }
  });
  $.ajax({
    url: "method.php",
    data : {
              method:"del_blacklist",
              id_obj : chked
            },
    type : "POST",
    success: function(result){
      	// alert(JSON.stringify(result));
        // console.log(result);
      if(result='00'){
          iziToast_func.alert('ยกเลิก Blacklist สำเร็จ')
        location.reload();
      }else {
       iziToast_func.alert('ไม่สามารถลบข้อมูลได้')
      }
    }
  });
}

function get_data_company() {

    var search_text = $('#search_text').val();
// console.log(search_text);

    $.ajax({
      url: "method.php",
      type: "post",
      async:false,
      data: { search_text:search_text , method:"get_data_company" },
      success: function(result){
// console.log(JSON.stringify(result));
        $(".get_data_company").html(result);
      }
    });

}

function btn_duplicate() {
var type_section = $('#type_section').val();
$('#copy_duplicate').val(type_section);
    var sendbtn = document.getElementById('duplicate');
    // when unchecked or checked, run the function
    if(type_section==''){
       sendbtn.disabled = true;
    } else {
       sendbtn.disabled = false ;
    }
}
// function lader_ding() {
// show_loading_feedback("show");
// }
function import_product(ids)  {
  show_loading_feedback("show");
		$.ajax({
			url: "import_product.php",
			type: "post",
			data: {
              "excel_file": ids
            },
			success: function (result) {
        show_loading_feedback("hide");
		    $(".import_product").modal('hide');
        $('.modal_add_porduct_ststus').modal('show');
        $('.modal-backdrop').css('display','none');
        $('.ststus_im').html(result);
			}
		});
	}



function set_val(){
    $('#id_ch_day').val('');
}

  function get_data_holiday_update() {

      var search_text = $('#search_hd').val();
      $.ajax({
        url: "method.php",
        type: "post",
        async:false,
        data: { search_text:search_text , method:"get_data_holiday_update" },
        success: function(result){
          if(result==0){
            iziToast_func.success('บันทึกข้อมูลสำเร็จ');
            // window.location.reload();
          }else{
           iziToast_func.alert('บันทึกข้อมูลผิดพลาด');

          }
        }
      });
  }

function chkNumber(ele) {
	var vchar = String.fromCharCode(event.keyCode);
	if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
	ele.onKeyPress=vchar;
}



function edit_department(id_department,edit) {
  $("#continents_edit").val('default');
  $("#Country").val('default');
  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขประเภทหน่วยงาน");
  $('div.edit_department').find('input').removeAttr('checked');
  if(edit==0){
    document.getElementById("none_edit_dp1").style.display = "block";
    document.getElementById("none_edit_dp2").style.display = "block";
    document.getElementById("none_edit_dp3").style.display = "block";
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดหน่วยงาน");
  }else if(edit==1){
    document.getElementById("none_edit_dp1").style.display = "block";
    document.getElementById("none_edit_dp2").style.display = "block";
    document.getElementById("none_edit_dp3").style.display = "block";
  }else{
    document.getElementById("none_edit_dp1").style.display = "none";
    document.getElementById("none_edit_dp2").style.display = "none";
    document.getElementById("none_edit_dp3").style.display = "none";
  }
   $(".edit_department").modal('show');
   $('#id_department').val(id_department);

   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_department&id="+id_department,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
        if(result.dept_type==3){
          $('.continents_hide').show();
          $('.box_country').show();
        }else{
          $('.continents_hide').hide();
          $('.box_country').hide();
          $("#continents_edit").val('default');
          $("#Country").val('default');
        }

        if(result.dept_type==2){
          $('.affiliation_edit').show();

        }else{
          $('.affiliation_edit').hide();

        }
        if(result.dept_type==1){
          $('.address_hide_edit').hide();
          $('.add_name_short_edit').show();
        }else{
          $('.address_hide_edit').show();
          $('.add_name_short_edit').hide();
        }
        // console.log(result);
        $("#add_name").val(result.dept_name);
        $("#director").val(result.dept_director);
        $("#tel").val(result.dept_tel);
        $("#email").val(result.dept_email);
        $("#assistant").val(result.dept_assistant);
        $("#address").val(result.dept_address);
        $("#fax").val(result.dept_fax);
        $("#affiliation").val(result.dept_affiliation);
        $("#message_noti").val(result.dept_message_noti);
        $("#message_noti_en").val(result.dept_message_noti_en);
        $("#add_name_short_edit").val(result.name_short);

        if(result.dept_section == '1'){
          document.getElementById("radio_section1_edit").checked = true;
        }else if(result.dept_section == '2'){
          document.getElementById("radio_section2_edit").checked = true;
        }else{
          document.getElementById("radio_section2_edit").checked = false;
          document.getElementById("radio_section1_edit").checked = false;
        }
        $("#group_id option[value='"+result.dept_type+"']").prop('selected',true);

        if(result.dept_enable == '1'){
          document.getElementById("radio_ststus_edit1").checked = true;
         }else if(result.dept_enable == '2'){
          document.getElementById("radio_ststus_edit2").checked = true;
        }
          $("#continents_edit option[value='"+result.code+"']").prop('selected',true);
          $("#Country option[value='"+result.country_id+"']").prop('selected',true);
   		}
   	});
    view_date(edit);
}


function edit_Incorrect(id_department,edit) {

  $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button><button type='submit' class='btn  btn_submit'>ตกลง</button>");
  $(".title_view").html("แก้ไขประเภทความผิด");
  $('div.channel_hide').find('input').removeAttr('checked');
  if(edit==0){
    $('.channel_hide').css('display','block');
    $(".title_view").html("รายละเอียดประเภทความผิด");
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
  }else if(edit==1){
    $('.channel_hide').css('display','block');
  }else{
    $('.channel_hide').css('display','none');
  }
   $(".bs-example-modal-lg_edit").modal('show');
   $('#id_edit').val(id_department);


   	$.ajax({
   		url: "method.php",
   		data : "method=get_Incorrect_Typet&id="+id_department,
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
        $("#edit_name").val(result.incType_name);
   			$("#edit_name_en").val(result.incType_name_en);
        if(result.incType_enable == '1'){
          document.getElementById("ch1_edit").checked = true;
        }else{
          document.getElementById("ch2_edit").checked = true;
        }

        if(result.incType_other_flag == '1'){
          document.getElementById("ra_edit_oth1").checked = true;
        }else if(result.incType_other_flag == '0'){
          document.getElementById("ra_edit_oth2").checked = true;
        }else{
          document.getElementById("ra_edit_oth1").checked = false;
          document.getElementById("ra_edit_oth2").checked = false;
        }
   		}
   	});
    view_date(edit);
}

  function del_department(del_id) {
    $.ajax({
      url: "method.php",
      type : "POST",
      data : {
                method:"del_department",
                del_id : del_id
              },
        success: function(result){
          if(result==1){
            iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
            refresh_table();
          }else{
            iziToast_func.alert('ลบข้อมูลผิดพลาด');
        }
      }
    });
  }


  function del_Incorrect_Type(del_id) {
    $.ajax({
      url: "method.php",
      type : "POST",
      data : {
                method:"del_incorrect",
                del_id : del_id
              },
        success: function(result){
          // console.log(result);
          if(result==1){
            iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
            refresh_table();
          }else{
            iziToast_func.alert('ลบข้อมูลผิดพลาด');
        }
      }
    });
  }


  function process_contact(id) {
    $('#ch_radio').val(0);
    $.ajax({
      url: "method.php",
      type: "post",
      async:false,
      data: { id:id , method:"process_contact" },
      success: function(result){
        $(".contact").html(result);
        $('.selectpicker').selectpicker('refresh');
      }
    });
  }
function ch_section(id) {
  if(id == 1){
    // console.log(1);
    $('.incType_2').hide();
    $('.incType_1').show();
  }else{
    // console.log(2);
    $('.incType_1').hide();
    $('.incType_2').show();
  }
  $('.selectpicker').selectpicker('refresh');


}

function Checkemail(str){
  var Email=/^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z0-9]{2,5})$/
  if(!document.getElementById(str).value.match(Email)){
   iziToast_func.alert('รูปแบบ Email ไม่ถูกต้อง');
    document.getElementById(str).focus();
    $('#Email').val('');
    $('#ct_email').val('');
    return false;
  }
}

function fun_up(id,level) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"fun_up",
              id : id ,
              level : level
            },
      success: function(result){
        if(result==1){
          iziToast_func.success('บันทึกข้อมูลเรียบร้อย');
          refresh_table();
        }else{
          iziToast_func.alert('บันทึกข้อมูลผิดพลาด');
      }
    }
  });
}


function fun_down(id,level) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"fun_down",
              id : id,
              level : level
            },
      success: function(result){
        if(result==1){
          iziToast_func.success('บันทึกข้อมูลเรียบร้อย');
          refresh_table();
        }else{
          iziToast_func.alert('บันทึกข้อมูลผิดพลาด');
      }
    }
  });
}



function edit_banner(id) {
   $(".edit_banner").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_banner&id="+id,
   		dataType:"json",
   		type : "POST",
   		success: function(result){
        $('#filename_edit').val('');
   			if(result.banner_enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
   			}
        if(result.img_view!=''){
          $('.pre_edit').show();
          $('.pre_edit').html(result.img_view);
          $('.pre_edit_en').html(result.img_view_en);
        }else{
          $('.pre_edit').hide();
        }
        $('#default_img').val(result.path_view);
        $('#default_img_en').val(result.path_view_en);
        $('#filename_edit').val('');
        $('#filename_edit_en').val('');


   		}
   	});
}


function del_banner(id_p) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : { method:"del_banner", id_p : id_p },
      success: function(result){
        if(result==0){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}

function edit_cpp(id) {
   $(".edit_cpp").modal('show');
   $("#id_edit").val(id);
   	$.ajax({
   		url: "method.php",
   		data : "method=get_data_cpp&id="+id,
   		dataType:"json",
   		type : "POST",
   		success: function(result){
        $('#detail').val(result.cpp_detail);
        $('#detail_en').val(result.cpp_detail_en);
   			if(result.cpp_enable == '1'){
   				document.getElementById("ch1_edit").checked = true;
   			}else{
          document.getElementById("ch2_edit").checked = true;
   			}
        if(result.img_view!=''){
          $('.pre_edit').show();
          $('.pre_edit').html(result.img_view);
        }else{
          $('.pre_edit').hide();
        }
          $('#default_img').val(result.path_view);
   		}
   	});
}

function del_cpp(id_p) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {  method:"del_cpp", id_p : id_p },
      success: function(result){
        if(result==0){
          iziToast_func.success('ลบข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}



function fun_up_cpp(id,level) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
              method:"fun_up_cpp",
              id : id ,
              level : level
            },
      success: function(result){
          // console.log(result);
        if(result==1){
          iziToast_func.success('บันทึกข้อมูลเรียบร้อย');
          refresh_table();
        }else{
          iziToast_func.alert('บันทึกข้อมูลผิดพลาด');
      }
    }
  });
}


function fun_down_cpp(id,level) {
  $.ajax({
    url: "method.php",
    type : "POST",
    data : {
      method:"fun_down_cpp",
      id : id,
      level : level
    },
    success: function(result){
      if(result==1){
        iziToast_func.success('บันทึกข้อมูลเรียบร้อย');
        refresh_table();
      }else{
        iziToast_func.alert('บันทึกข้อมูลผิดพลาด');
      }
    }
  });
}


function hide_depart(hide) {
  // console.log(hide);
  if(hide==1){
    $('.hide_depart').show();
  }else{
    $('.hide_depart').hide();
  }

}



function Continents_select(check) {
  var id = $('#continents_id').val();
  if(check!=2){
  if(id == ''){
    $('.box_country').hide();
  }else{
    $('.box_country').show();
  }
}else{
   id = $('#continents_edit').val();
   if(id == ''){
     $('.box_country').hide();
   }else{
     $('.box_country').show();
   }
}

      $.ajax({
        url: "method.php",
        type: "post",
        async:false,
        data: { id:id , method:"select_depart" },
        success: function(result){
          $(".box_country").html(result);
          $('.selectpicker').selectpicker('refresh');
        }
      });
}

function depa_type(ch) {
  var id  = $('#select_dp').val();
  if(ch==1){
    if(id!=3){
      $('.none_dp').hide();
    }else{
      $('.none_dp').show();
    }
    if(id==2){
      $('.affiliation').show();
    }else{
      $('.affiliation').hide();
    }
    if(id==1){
      $('.address_hide').hide();
      $('.add_name_short').show();
    }else{
      $('.address_hide').show();
      $('.add_name_short').hide();
    }
  }else{
    id = $('#group_id').val();
    $('.continents_hide').show();
    if(id==3){
      $('.continents_hide').show();
    }else {
      $('.continents_hide').hide();
      $('.box_country').hide();
    }
    if(id==2){
      $('.affiliation_edit').show();
    }else{
      $('.affiliation_edit').hide();
    }
    if(id==1){
      $('.address_hide_edit').hide();
    }else{
      $('.address_hide_edit').show();
    }
  }
}


function import_department(ids)  {
  show_loading_feedback("show");
		$.ajax({
			url: "import_department.php",
			type: "post",
			data: {
              "excel_file": ids
            },
			success: function (result) {
        show_loading_feedback("hide");
		    $(".import_department").modal('hide');
        $('.modal_department_ststus').modal('show');
        $('.modal-backdrop').css('display','none');
        $('.ststus_im').html(result);
			}
		});
}


function isThaichar(str,obj){
  var isThai=true;
  var orgi_text="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var chk_text=str.split("");
  chk_text.filter(function(s){
    if(orgi_text.indexOf(s)!=-1){
      // console.log(s);
      //isThai=false;
      str=str.replace(s,'');
    }
  });
  // console.log(str);
  return str; // ถ้าเป็น true แสดงว่าเป็นไืทยทั้งหมด*/
}

function isThaichar_en(str,obj){
  var isThai=true;
  // var orgi_text=" zxcvbnm,./asdfghjkl;'qwertyuiop[]1234567890-=";
  var orgi_text="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";

  var chk_text=str.split("");
  chk_text.filter(function(s){
    if(orgi_text.indexOf(s)!=-1){
      //isThai=false;
      str=str.replace(s,'');
    }
  });
  // console.log(str);
  return str; // ถ้าเป็น true แสดงว่าเป็นไืทยทั้งหมด*/
}
