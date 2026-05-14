function Confirmsave()
{
  var r=confirm("ยืนยันการบันทึก ? ");
   if(r==true)
   {
     document.getElementById("add_group").submit();
   }
}

function user_section() {
var id = $('#office_name').val();
if(id != 's2'){
  id = 1;
}else{
  id = 2;
}
  $.ajax({
    url: "../setting/user/method.php",
    type: "post",
    async : false,
    data: { id:id , method:"user_section" },
    success: function(result){
      // console.log(result);
      $(".box_section").html(result);
      // $(".sub_type_complaint").hide();
      $('.selectpicker').selectpicker('refresh');
    }
  });
  $('.dept_id-div').hide();
}


  $('body').on('change','#group_id_emp',function(){
    if($(this).val()==6){
      $('.dept_id-div').show();
      $('#dept_id').val('');
      $('#Ldap').prop('checked', false);
      $('.selectpicker').selectpicker('refresh');
    }else{
      $('.dept_id-div').hide();
    }
  });


  $('body').on('change','#group_id_emp_edit',function(){
    if($(this).val()==6){
      $('.dept_id-div-edit').show();
      $('#dept_id_edit').val('');
      $('#Ldap_edit').prop('checked', false);
      $('.selectpicker').selectpicker('refresh');
    }else{
      $('.dept_id-div-edit').hide();
    }
  });
  
  $('body').on('change','#s1',function(){
    if($(this).val()==6){
      $('.dept_id-div-edit').show();
      $('#dept_id_edit').val('');
      $('#Ldap_edit').prop('checked', false);
      $('.selectpicker').selectpicker('refresh');
    }else{
      $('.dept_id-div-edit').hide();
    }
  });

  $('body').on('change','#dept_id',function(){
    if($(this).val()==''){
      $('#Ldap').prop('checked', false);
    }
  });

  $('body').on('change','#dept_id_edit',function(){
    if($(this).val()==''){
      $('#Ldap_edit').prop('checked', false);

    }
  });


function user_section_edit() {
  var id_edit = $('#office_name_edit').val();
  if(id_edit != 's2'){
    id_edit = 1;
  }else{
    id_edit = 2;
  }
  $('#ch_radio').val(0);
  $.ajax({
    url: "../setting/user/method.php",
    type: "post",
    async:false,
    data: { id:id_edit , method:"user_section_edit" },
    success: function(result){
      // console.log(result);
      $(".box_section").html(result);
      // $(".sub_type_complaint").hide();
      $('.selectpicker').selectpicker('refresh');
      $('.dept_id-div-edit').hide();

    }
  });
}
function edit_emp(id,view) {
  $(".title_view").html("แก้ไขผู้ใช้");
  if(view==0){
    $("#txt_noti_1").hide();
    $("#img_not").hide();
    $(".footer_close").empty();
    $(".footer_close").html("<button type='button' class='btn btn-default' data-dismiss='modal'>ปิด</button>");
    $(".title_view").html("รายละเอียดผู้ใช้");

  }else{
    $("#txt_noti_1").show();

    $("#img_not").show();
    $(".footer_close").empty();
    $(".footer_close").html("<button type='submit' class='btn  btn_submit'>ตกลง</button><button type='button' class='btn  btn_red' data-dismiss='modal'>ยกเลิก</button>");
  }
      $('div.view_dashboard').find('input').removeAttr('checked');
      $(".modal_edit_emp").modal('show');
      $("#id_edit").val(id);
      $('.s1').hide();
      $('.s2').hide();

   	$.ajax({
   		url: "../setting/user/method.php",
      data: { id:id , method:"get_data_emp" },
   		dataType:"json",
   		type : "POST",
      async : false,
   		success: function(result){
      // console.log(JSON.stringify(result));
// console.log(result.empGroup_section);
      $('.Password-reset').hide();

      if(result.empGroup_id==6){
        $('.dept_id-div-edit').show();
        if(result.login_ldap==1){
          $('#Ldap_edit').prop('checked', true);
        }else{
          $('.Password-reset').show();

          $('#Ldap_edit').prop('checked', false);
        }
        $('#dept_id_edit').val(result.dept_id);
        $('.selectpicker').selectpicker('refresh');
      }else{

        $('#dept_id_edit').val('');
        $('.selectpicker').selectpicker('refresh');
        $('#Ldap_edit').prop('checked', false);
        $('.dept_id-div-edit').hide();
      }
      if(result.empGroup_section==1){
        // document.getElementById("radio1").checked = true;
        $('.s1').show();
        $("#s1 option[value='"+result.empGroup_id+"']").prop('selected',true);
      }else{
          // document.getElementById("radio2").checked = true;
        $('.s2').show();
        $("#s2 option[value='"+result.empGroup_id+"']").prop('selected',true);
      }

      if(result.img_view == "") {
        $(".imp_hid").show();
        $(".imp_hid_pre").hide();
      }else{
        $(".imp_hid").hide();
        $(".imp_hid_pre").show();
        $(".imp_hid_pre").html("<img class='im_pre' id='output_image_1' width='25' src="+result.img_view+" />");

        var img = new Image();
        img.src =result.img_view;
        img.onload = function(){
          $('.im_pre').attr('style', getPositionImage(this.width,this.height,128));
        }
        $('#ch_img').val(1);
      }
      $("#emp_firstname").val(result.emp_firstname);
      $("#emp_lastname").val(result.emp_lastname);
      $("#emp_tel").val(result.emp_tel);
      $("#emp_email").val(result.emp_email);
      $("#emp_real_id").val(result.emp_real_id);
      $("#username").val(result.username);
      if(result.emp_available_dashboard == '1'){
        document.getElementById("view_edit").checked = true;
      }else if(result.emp_available_dashboard == '2'){
        document.getElementById("view1_edit").checked = true;
      }
      $('#default_img').val(result.img_view);
      var office = '';
      if(result.empGroup_section==2 && result.office_id == 0){
        office = 's2';
      }else if(result.empGroup_section==1 && result.office_id == 0){
        office = 's1';
      }else {
        office = result.office_id;

      }
      $("#office_name_edit option[value='"+office+"']").prop('selected',true);
      $('.selectpicker').selectpicker('refresh');
    }
  });
  view_date(view);
}

function view_applactions(id,type_hide) {
  var type_hide  = type_hide;
   $(".modal_view_app").modal('show');

   	$.ajax({
   		url: "../setting/user/method.php",
      data: { id:id , method:"view_applactions" },
   		dataType:"json",
   		type : "POST",
   		success: function(result){

        if(result.img_view == "") {
          $(".imp_hid").show();
          $(".imp_hid_pre").hide();
        }else{
          $(".imp_hid").hide();
          $(".imp_hid_pre").show();
          $(".imp_hid_pre").html("<img class='im_pre' id='output_image_1' width='25' src="+result.img_view+" />");

          var img = new Image();
          img.src =result.img_view;
          img.onload = function(){
            $('.im_pre').attr('style', getPositionImage(this.width,this.height,128));
          }
          $('#ch_img').val(1);
        }
console.log(result.img_view);
      $('#repass_id').val(id);
      $("#v_name").html("<label for='message-text' class='control-label v_app_nol' >"+result.member_fname+"  "+result.member_lname+"</label>");
      $("#v_position").html("<label for='message-text' class='control-label v_app_nol' >"+result.member_position+"</label>");
      $("#v_address").html("<label for='message-text' class='control-label v_app_nol' >"+result.member_address+"</label>");
      if(result.member_phone==''){
        var ph = '-';
      }else{
        ph = result.member_phone ;
      }
      $("#v_tel").html("<label for='message-text' class='control-label v_app_nol' >"+ph+"</label>");
      if(result.member_cellphone==''){
        var ph_c = '-';
      }else{
        ph_c = result.member_cellphone ;
      }
      $("#v_moile").html("<label for='message-text' class='control-label v_app_nol' >"+ph_c+"</label>");

      if(type_hide==0){
        $('#check_facebook').hide();
      }else{
        $('#check_facebook').show();
        if(result.member_facebook_type==1){
          var name ='Facebook Login';
          document.getElementById('check_facebook').style.display = 'none';
        }else{
          name ='Manual Login';
          if(result.member_status_confirm==0){
            document.getElementById('check_facebook').style.display = 'none';
          }else{
            document.getElementById('check_facebook').style.display = 'block';
          }
        }
      }



      $("#v_type").html("<label for='message-text' class='control-label v_app_nol' >"+name+"</label>");
      $("#v_mail").html("<label for='message-text' class='control-label v_app_nol' >"+result.member_email+"</label>");

      if(result.member_comp_name!= null){
        $("#v_com").html("<label for='message-text' class='control-label v_app_nol' >"+result.member_comp_name+"</label>");
      }else{
        $("#v_com").html("<label for='message-text' class='control-label v_app_nol' >-</label>");

      }
      if(result.member_comp_type == 1){
        var ty = 'เป็นสมาชิกกรม';
      }else if(result.member_comp_type == 2){
           ty = 'ไม่เป็นสมาชิกกรม';
      }else{
        ty = '-';
      }
      $("#v_ty").html("<label for='message-text' class='control-label v_app_nol' >"+ty+"</label>");
    }
  });
}

function del_group(del_id,ch_user) {
  if(ch_user != '0'){

    var r=confirm("เนื่องจากมีผู้ใช้งานอยู่ในกลุ่ม ถ้าลบกลุ่มผู้ใช้แล้ว ผู้ใช้ในกลุ่มก็จะถูกลบออกจากระบบ ยืนยันการลบ ? ");
    if(r==true)
    {
      $.ajax({
        url: "../setting/user/method.php",
        type : "POST",
        data : {
          method:"del_group",
          del_id : del_id
        },
        success: function(result){
          if(result==1){
            alert('ลบข้อมูลเรียบร้อยแล้ว');
            window.location.reload();
          }else{
            iziToast_func.alert('ลบข้อมูลผิดพลาด');
          }
        }
      });
    }

  }
}
function reset_password() {
show_loading_feedback("show");
  var repass_id = $('#repass_id').val();
  $.ajax({
    url: "../setting/user/method.php",
    type : "POST",
    data : {
              method:"reset_password",
              repass_id : repass_id
            },
      success: function(result){
        console.log(JSON.stringify(result));

        if(result==1){
          show_loading_feedback("hide");
          // $('.modal_view_app').hide();
          alert('กรุณาตรวจสอบที่ Email เราได้ส่งลิงค์แก้ไขรหัสผ่านให้คุณเรียบร้อยแล้ว');
          // window.location.reload();
        }else{
          iziToast_func.alert('reset passwort ผิดพลาด');
      }
    }
  });
}

function reset_password_office() {
  console.log(1111);
  show_loading_feedback("show");
  var repass_id = $('#id_edit').val();
  console.log(repass_id);
  $.ajax({
    url: "../setting/user/method.php",
    type : "POST",
    data : {
              method:"reset_password_office",
              repass_id : repass_id
            },
      success: function(result){
        console.log(JSON.stringify(result));
        if(result==1){
          show_loading_feedback("hide");
          alert('กรุณาตรวจสอบที่ Email เราได้ส่งลิงค์แก้ไขรหัสผ่านให้คุณเรียบร้อยแล้ว');
        }else{
          iziToast_func.alert('reset passwort ผิดพลาด');
        }
    }
  });
}


function del_emp(id_p) {
  $.ajax({
    url: "../setting/user/method.php",
    type : "POST",
    data : {  method:"del_emp", id_p : id_p },
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


function getPositionImage(width,height,size){
    var ratio = (width/height); // width/height
    var css = "";
    if( ratio > 1) {
        width = (size*ratio);
        height = size;
        css = " width:auto; height:100%; margin-left:-"+((width*0.5)-(size*0.5))+"px";
    }
    else {
    width = size;
    height = (size/ratio);
      css = "height:auto; width:100%; top:0;";
    }
    return css;
  }
  function refresh_table() {
    // if(ch==1){
    //   $('.table-caseCh-list').bootstrapTable('selectPage', 1);
    //   $('.table-caseCh-list').bootstrapTable('refresh');
    //   $('.modal').modal('hide');
    //   $('.modal').modal('hide');
    // }else{
      $('.table-caseCh-list').bootstrapTable('refresh');
      $('.modal').modal('hide');
    // }
  }

  function dis_member(ty,id_me) {
    $.ajax({
      url: "../setting/user/method.php",
      type : "POST",
      data : {
        method:"dis_member",
        ty : ty,
        id_me : id_me
      },
      success: function(result){
        if(result==1){
          alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
          refresh_table();
        }else{
          iziToast_func.alert('แก้ไขข้อมูลผิดพลาด');
        }
      }
    });
  }

  function Confirmststus(callback)
  {
    var x = confirm("ยืนยันการแก้ไขข้อมูล ? ");
    if(x){
        if(typeof callback === "function"){
          callback();
        }
        return true;
    }else{
      return false;
    }

  }
