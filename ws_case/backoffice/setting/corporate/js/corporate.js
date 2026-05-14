
function edit_corporate(id,ty,hide_edit) {
  if(ty==1){
    $(".edit_corporate_thai").modal('show');
    $(".footer_close").html("<button type='submit' class='btn  btn_submit'>บันทึกข้อมูล</button><button type='button' class='btn btn-default' data-dismiss='modal'>ยกเลิก</button>");
    $(".title_view").html("แก้ไขนิติบุคคลในประเทศไทย");
    if(hide_edit==0){
      $(".title_view").html("รายละเอียดนิติบุคคลในประเทศไทย");
      $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    }
  }else{
      $(".modal_corporate_inter").modal('show');
      $(".footer_close").html("<button type='submit' class='btn  btn_submit'>บันทึกข้อมูล</button><button type='button' class='btn btn-default' data-dismiss='modal'>ยกเลิก</button>");
      $(".title_view").html("แก้ไขนิติบุคคลในต่างประเทศ");
      if(hide_edit==0){
        $(".title_view").html("รายละเอียดนิติบุคคลในต่างประเทศ");
        $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
      }
  }

  $('#id_ch').val(id);

   	$.ajax({
   		url: "../setting/corporate/method.php",
      data: { id:id , ty:ty , method:"corporate" },
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
      $("#branch").val(result.cpr_branch);
      $("#telephone").val(result.cpr_telephone);
      $("#fax").val(result.cpr_fax);
      $("#email").val(result.cpr_email);
      $("#address").val(result.cpr_address);
      $("#prov option[value='"+result.prov_id+"']").prop('selected',true);
      $("#zipcode").val(result.cpr_zipcode);
      $("#contactfname").val(result.cpr_contact_person);

        if(ty==1){
          $("#ct_card").html("<span class=''>"+result.cpr_numbertrade+"</span>");
          $("#companyname").val(result.cpr_companyname);
            if(result.cpr_department == '1'){
              document.getElementById("radio3_edit").checked = true;
            }else{
              document.getElementById("radio4_edit").checked = true;
            }
        }else{
          $("#ct_card").html("<span class=''>"+result.cpr_companyname+"</span>");
          $("#numbertrade").val(result.cpr_numbertrade );
        }
        $("#Country option[value='"+result.Country_id+"']").prop('selected',true);
        $("#business_type option[value='"+result.cpr_type_import_export+"']").prop('selected',true);
        $('.selectpicker').selectpicker('refresh');
    }
  });
  view_date(hide_edit);
}



function del_corporate(cpr_id) {
  $.ajax({
    url: "../setting/corporate/method.php",
    type : "POST",
    data : {
              method:"del_corporate",
              cpr_id : cpr_id
            },
      success: function(result){
        if(result==1){
          iziToast_func.success('ลบข้อมูลสำเร็จ');
          refresh_table();
      }else {
        iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}


function import_corporate_thai(id)  {
	$.ajax({
		url: "corporate/import_corporate_thai.php",
		type: "post",
		data: {
            "excel_file": id
          },
		success: function (result) {
	    $(".import_people_th").modal('hide');
      $('.modal_ststus').modal('show');
      $('.modal-backdrop').css('display','none');
      $('.ststus_im').html(result);
		}
	});
}

function import_corporate_inter(id)  {
	$.ajax({
		url: "corporate/import_corporate_inter.php",
		type: "post",
		data: {
            "excel_file": id
          },
		success: function (result) {
	    $(".import_people_th").modal('hide');
      $('.modal_ststus').modal('show');
      $('.modal-backdrop').css('display','none');
      $('.ststus_im').html(result);
		}
	});
}
