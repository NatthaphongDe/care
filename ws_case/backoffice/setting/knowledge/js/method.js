function edit_knowledge(id,view) {
  if(view==0){
    $('.modal-footer').html('<button type="button" class="btn btn-default btn_can_kl" data-dismiss="modal">ปิด</button>');
  }else {
    $('.modal-footer').html('<button type="submit" class="btn  btn_submit">บันทึกข้อมูล</button><button type="button" class="btn btn-default btn_can_kl" data-dismiss="modal">ยกเลิก</button>');
  }
  $(".modal_view_app").modal('show');
  $('#id').val(id);
  $.ajax({
    url: "../setting/knowledge/method.php",
    data: { id:id , method:"edit_knowledge" },
    dataType:"json",
    type : "POST",
    async : false,
    success: function(result){
      // console.log(JSON.stringif1y(result));
      if(result.caseKnlg_status == '0'){
        document.getElementById("radio3").checked = true;
        document.getElementById("radio3").disabled = false;
      }else if(result.caseKnlg_status=='1'){
        document.getElementById("radio4").checked = true;
        document.getElementById("radio4").checked = true;
        document.getElementById("radio3").disabled = true;
      }else{
        document.getElementById("radio5").checked = true;
        document.getElementById("radio3").disabled = true;
      }

      for(name in CKEDITOR.instances)
      {
        CKEDITOR.instances[name].destroy(true);
      }
      $("#compType_name").html("<span>"+result.compType_name+"</span>");
      $('#applnt_name').val(result.applnt_name);
      $('#complnt_name').val(result.complnt_name);
      $('#caseDtl_title').val(result.caseDtl_title);
      // console.log(result.caseDtl_derivation);
      $('#caseDtl_derivation').val(result.caseDtl_derivation);
      $("#prodType_id option[value='"+result.prodType_id+"']").prop('selected',true);
      $("#mistake_up option[value='"+result.incType_id+"']").prop('selected',true);

      $('#caseDtl_damage_val').val(result.caseDtl_damage_val);
      $('#caseDtl_complnt_need').val(result.caseDtl_complnt_need);

      $( 'textarea.ckeditor').each( function() {
        CKEDITOR.replace( $(this).attr('id') );
      });

      $('#case_close_resultProcess').val(result.case_close_resultProcess);
      $("#caseClose_title").html("<span>"+result.caseClose_title+"</span>");
      $('.selectpicker').selectpicker('refresh');
    }
  });
  view_date(view);
}

function del_knowledge(id) {
  $.ajax({
    url: "../setting/knowledge/method.php",
    type : "POST",
    data : {
      method:"del_knowledge",
      id : id
    },
    success: function(result){
      if(result==1){
        alert('ลบข้อมูลสำเร็จ');
        refresh_table();
      }else {
        parent.iziToast_func.alert('ลบข้อมูลผิดพลาด');
      }
    }
  });
}

function copy_knowledge(id) {
  $.ajax({
    url: "../setting/knowledge/method.php",
    type : "POST",
    data : {
      method:"copy_knowledge",
      id : id
    },
    success: function(result){
      if(result==1){
        alert('Duplicate ข้อมูลสำเร็จ');
        refresh_table();
      }else {
        parent.iziToast_func.alert('Duplicate ข้อมูลผิดพลาด');
      }
    }
  });
}
