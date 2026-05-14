
function edit_contact_thai(id,ty,hide_edit) {
  document.getElementById("radio3_edit").checked = false;
  document.getElementById("radio4_edit").checked = false;

  $('.hi_ct').show();

  if(ty==1){
    $(".modal_edit_ct").modal('show');

    $(".footer_close").html("<button type='submit' class='btn  btn_submit'>บันทึกข้อมูล</button><button type='button' class='btn btn-default' data-dismiss='modal'>ยกเลิก</button>");
    $(".title_view").html("แก้ไขข้อมูลบุคคลในประเทศ");

    if(hide_edit==0){
      $(".title_view").html("รายละเอียดข้อมูลบุคคลในประเทศ");
      $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
      $('.hi_ct').hide();
    }
}else{
  $(".modal_edit_inter").modal('show');
  $(".footer_close").html("<button type='submit' class='btn  btn_submit'>บันทึกข้อมูล</button><button type='button' class='btn btn-default' data-dismiss='modal'>ยกเลิก</button>");
  $(".title_view").html("แก้ไขข้อมูลบุคคลต่างประเทศ");

  if(hide_edit==0){
    $(".title_view").html("รายละเอียดข้อมูลบุคคลต่างประเทศ");
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $('.hi_ct').hide();
  }
}




$('#id_ch').val(id);

   	$.ajax({
   		url: "../setting/Individual/method.php",
      data: { id:id , ty:ty , method:"edit_contact_thai" },
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
      $("#ct_department option[value='"+result.ct_department+"']").prop('selected',true);
      $('.selectpicker').selectpicker('refresh');

      // $("#ct_card").val(result.ct_card);
      $("#ct_card").html("<span class=''>"+result.ct_card+"</span>");
      $("#ct_firstname").val(result.ct_firstname);
      $("#ct_lastname").val(result.ct_lastname);


      if(result.ct_birthday=='0000-00-00'){
        $("#ct_birthday").val();
      }else{
        var inputDate = result.ct_birthday;
        var newDat = changeDateFormat(inputDate);
        $("#ct_birthday").val(newDat);
      }

      if(result.ct_sex == '1'){
        document.getElementById("radio3_edit").checked = true;
      }else if(result.ct_sex == '2'){
        document.getElementById("radio4_edit").checked = true;
      }

      $("#ct_career").val(result.ct_career);
      $("#ct_homephone").val(result.ct_homephone);
      $("#ct_cellphone").val(result.ct_cellphone);
      $("#ct_email").val(result.ct_email);
      $("#ct_address").val(result.ct_address);
      $("#prov_id option[value='"+result.prov_id+"']").prop('selected',true);
      if(result.ct_postcode=='0'){
        $("#ct_postcode").val();
      }else {
        $("#ct_postcode").val(result.ct_postcode);
      }
      $("#Country_id option[value='"+result.Country_id+"']").prop('selected',true);
      $('.selectpicker').selectpicker('refresh');
    }
  });
    view_date(hide_edit);
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

function import_peoplethailand(ids)  {
		$.ajax({
			url: "Individual/import_contact_thai.php",
			type: "post",
			data: {
              "excel_file": ids
            },
			success: function (result) {
		    $(".import_people_th").modal('hide');
        $('.modal_ststus').modal('show');
        $('.modal-backdrop').css('display','none');
        $('.ststus_im').html(result);
			}
		});
	}

  function del_contact_thai(ct_id) {
    $.ajax({
      url: "Individual/method.php",
      type : "POST",
      data : {
                method:"del_contact_thai",
                ct_id : ct_id
              },
        success: function(result){
          if(result==1){
            alert('ลบข้อมูลเรียบร้อยแล้ว');
            refresh_table();
          }else{
            iziToast_func.alert('ลบข้อมูลผิดพลาด');
        }
      }
    });
  }

function import_peopleinter(ids)  {
		$.ajax({
			url: "Individual/import_contact_inter.php",
			type: "post",
			data: {
              "excel_file": ids
            },
			success: function (result) {
		    $(".import_people_th").modal('hide');
        $('.modal_ststus').modal('show');
        $('.modal-backdrop').css('display','none');
        $('.ststus_im').html(result);
			}
		});
	}
