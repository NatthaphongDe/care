var fileTumbnail="";
function readURL_thumbnail(input,callback) {

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        fileTumbnail = e.target.result;
        if(typeof callback === "function"){
        callback(fileTumbnail);
        }
      }

      reader.readAsDataURL(input.files[0]);
  }
}


$(document).delegate(".btn_file_agentoffice","click",function(){
  $(".upload_file").click();
  });
$(document).delegate(".box_file_agentperson","click",function(){
  $(".upload_file_person").click();
  });
$(document).delegate(".box_file_agentoffice","click",function(){
  $(".upload_file").click();
  });
$(document).delegate(".btn_file_agentperson","click",function(){
  $(".upload_file_person").click();
  });

$(document).delegate(".upload_file","change",function(){
  $('.box_file_agentoffice').val(this.files[0].name);
  readURL_thumbnail(this,function(pathfile){
    $('#register_img').attr('src', pathfile);
    var image = new Image();
    image.src = pathfile;
    image.onload = function() {
      $('#register_img').attr('style', getPositionImage(this.width,this.height,48));
    }
    });
  });

  $(document).delegate(".upload_file_person","change",function(){
    $('.box_file_agentperson').val(this.files[0].name);
    readURL_thumbnail(this,function(pathfile){
      $('#register_img').attr('src', pathfile);
      var image = new Image();
      image.src = pathfile;
      image.onload = function() {
        $('#register_img').attr('style', getPositionImage(this.width,this.height,48));
      }
      });
    });
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

    $( document ).ready(function() {

      $('.upload_file').change(function(){
        readURL_thumbnail(this);
      });
      $('.upload_file_person').change(function(){
        readURL_thumbnail(this);
      });

    });
$(document).delegate(".member_comp","click",function(){
  var lang = $('.lang').val();
  var status = $('.status_login').val();
  var fb_id = $('.fb_id').val();
  var fb_name = $('.fb_name').val();
  var chkpass = $(".box_password_agentoffice").val();
  var re = new RegExp(/^(?=.*\d)(?=.*[0-9a-zA-Z]).{8,}$/);
  var str = $(".box_fix_person_agentoffice").val();
  var rel = /_/g;
  var rex = /-/g;
  var res = str.replace(rel, "");
  var resx = res.replace(rex, "");
  var n = resx.length;
  if(status == "0"){
      if(re.test(chkpass) == true){
        if(n == 10){
    if($(".box_password_agentoffice").val() == $(".box_re_password_agentoffice").val()){
       if ($(".box_name_agentoffice").val() == "") {
         if(lang == "2"){
           bootbox.alert('Please fill in Company name');
         }else {
           bootbox.alert('กรุณากรอก ชื่อบริษัทที่จดทะเบียน');
         }

      }else if ($(".box_trade_agentoffice").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Business Registration Number');
        }else {
          bootbox.alert('กรุณากรอก หมายเลขทะเบียนการค้า');
        }

      }else if ($(".box_address_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Address');
        }else {
        bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
        }

      }else if ($(".box_code_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Postcode');
        }else {
        bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
        }

      }else if ($(".box_tel_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Telephone number');
        }else {
        bootbox.alert('กรุณากรอก เบอร์โทรศัพท์');
        }

      }else if ($(".box_nameperson_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in First name');
        }else {
        bootbox.alert('กรุณากรอก ชื่อ');
        }

      }else if ($(".box_lastnameperson_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Last name');
        }else {
        bootbox.alert('กรุณากรอก นามสกุล');
        }

      }else if ($(".box_cardnumber_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in 13-digit Population Identification Code');
        }else {
        bootbox.alert('กรุณากรอก เลขบัตรประชาชน');
        }

      }else if ($(".box_position_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Position');
        }else {
        bootbox.alert('กรุณากรอก ตำแหน่ง');
        }

      }else if ($(".box_address_person_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Address');
        }else {
        bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
        }

      }else if ($(".box_code_person_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Postcode');
        }else {
        bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
        }

      }else if ($(".box_email_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in E-mail');
        }else {
        bootbox.alert('กรุณากรอก E-mail');
        }

      }else if ($(".box_password_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Password');
        }else {
        bootbox.alert('กรุณากรอก รหัสผ่าน');
        }

      }else if ($(".box_re_password_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Please verify your password');
        }else {
        bootbox.alert('กรุณากรอก ยืนยันรหัสผ่าน');
        }

      }else if ($("#sel_country_person_office").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please choose Country');
        }else {
        bootbox.alert('กรุณาเลือก ประเทศ');
        }

      }else if ($("#sel_country_office").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please choose Country');
        }else {
        bootbox.alert('กรุณาเลือก ประเทศ');
        }

      }else {
        $('#wait_process').css('display','block');
        setTimeout(function(){
        var form_data = new FormData();
            form_data.append('file', fileTumbnail);
            form_data.append('box_name_agentoffice', $(".box_name_agentoffice").val());
            form_data.append('box_branch_agentoffice', $(".box_branch_agentoffice").val());
            form_data.append('box_trade_agentoffice', $(".box_trade_agentoffice").val());
            form_data.append('box_address_agentoffice', $(".box_address_agentoffice").val());
            if($("#sel_city_office").val() != ""){
              form_data.append('sel_city_office', $("#sel_city_office").val());
            }else {
              form_data.append('sel_city_office', $(".sel_city_office_txt").val());
            }
            form_data.append('box_code_agentoffice', $(".box_code_agentoffice").val());
            form_data.append('sel_country_office', $("#sel_country_office").val());
            form_data.append('box_tel_agentoffice', $(".box_tel_agentoffice").val());
            form_data.append('box_fix_agentoffice', $(".box_fix_agentoffice").val());
            form_data.append('department_members', $('input[name=department_members]:checked', '#member_com').val());
            form_data.append('box_nameperson_agentoffice', $(".box_nameperson_agentoffice").val());
            form_data.append('box_lastnameperson_agentoffice', $(".box_lastnameperson_agentoffice").val());
            form_data.append('box_cardnumber_agentoffice', $(".box_cardnumber_agentoffice").val());
            form_data.append('box_position_agentoffice', $(".box_position_agentoffice").val());
            form_data.append('box_address_person_agentoffice', $(".box_address_person_agentoffice").val());
            if($("#sel_city_person_office").val() != ""){
              form_data.append('sel_city_person_office', $("#sel_city_person_office").val());
            }else {
              form_data.append('sel_city_person_office', $(".sel_city_person_office_txt").val());
            }
            form_data.append('box_code_person_agentoffice', $(".box_code_person_agentoffice").val());
            form_data.append('sel_country_person_office', $("#sel_country_person_office").val());
            form_data.append('box_tel_person_agentoffice', $(".box_tel_person_agentoffice").val());
            form_data.append('box_fix_person_agentoffice', $(".box_fix_person_agentoffice").val());
            form_data.append('office_sex', $('input[name=sex]:checked', '#member_com').val());
            form_data.append('box_email_agentoffice', $(".box_email_agentoffice").val());
            form_data.append('box_password_agentoffice', $(".box_password_agentoffice").val());
            form_data.append('status', status);
            form_data.append('g-recaptcha-response', $("textarea[name='g-recaptcha-response']").val());
            form_data.append('method', "register_member_com");


              $.ajax({
                  url: 'function_php/function_member.php',
                  type: 'POST',
                  enctype: 'multipart/form-data',
                  async: false,
                  processData: false,
                  contentType: false,
                  responseType: "json",
                  data: form_data,
                success: function(res) {
                  if(res.email_chk_mem == "00"){
                    if(lang == "2"){
                      bootbox.alert('This e-mail is already in the system, please check.',function(){
                        $('#wait_process').css('display','none');
                      });
                    }else {
                      bootbox.alert('E-mail นี้มีอยู่ในระบบแล้วกรุณาตรวจสอบ',function(){
                        $('#wait_process').css('display','none');
                      });
                    }

                  }else if (res.email_chk_mem == "01") {
                    if(res.chk_mail == "00"){
                    if(lang == "2"){
                      bootbox.alert('Registered successfully Please confirm your Email subscription.',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }else {
                      bootbox.alert('ลงทะเบียนเรียบร้อย กรุณายืนยันการสมัครสมาชิกทาง E-mail ของท่าน',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }
                  }

                  }else if (res.email_chk_mem == "02") {
                    if(lang == "2"){
                      bootbox.alert('Please specify Captcha to prove the person. If you are not Robot or spam',function(){
                        $('#wait_process').css('display','none');
                      });
                    }else {
                      bootbox.alert('กรุณาระบุ Capcha เพือพิสูจน์บุคคล หากท่านไม่ใช่ หุ่นยนต์หรือสแปม',function(){
                        $('#wait_process').css('display','none');
                      });
                    }

                  }else if (res.email_chk_mem == "03") {
                    if(lang == "2"){
                      bootbox.alert('Please specify correct Captcha.',function(){
                        $('#wait_process').css('display','none');
                      });
                    }else {
                      bootbox.alert('กรุณาระบุ Capcha ให้ถูกต้อง',function(){
                        $('#wait_process').css('display','none');
                      });
                    }

                  }else {
                    bootbox.alert('ERROR !',function(){
                      $('#wait_process').css('display','none');
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR, textStatus, errorThrown);

                }
              });
            }, 1000);
          }
          }else{
            if(lang == "2"){
            bootbox.alert('Please fill in "Password" and "Please verify your password" Match');
            }else {
            bootbox.alert('กรุณากรอกช่อง "รหัสผ่าน" และช่อง "ยืนยันรหัสผ่าน" ให้ตรงกัน');
            }

          }
        }else {
          if(lang == "2"){
          bootbox.alert('Please fill in Mobile telephone number to complete.');
          }else {
          bootbox.alert('กรุณากรอกช่อง เบอร์โทรศัพท์มือถือ ให้ครบถ้วน');
          }

        }
      }else {
        if(lang == "2"){
      bootbox.alert('must contain alphanumeric A-Z, a-z, 0-9, with at least 8 digits in length');
        }else {
      bootbox.alert('รหัสผ่านต้องมี A-Z,a-z และ 0-9 อย่างน้อย 1 ตัว และมีอย่างน้อย 8 หลัก');
        }

    }
  }else {
    if(n == 10){
    if ($(".box_name_agentoffice").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Company name');
      }else {
        bootbox.alert('กรุณากรอก ชื่อบริษัทที่จดทะเบียน');
      }

      }else if ($(".box_trade_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Business Registration Number');
        }else {
        bootbox.alert('กรุณากรอก หมายเลขทะเบียนการค้า');
        }

      }else if ($(".box_address_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Address');
        }else {
        bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
        }

      }else if ($(".box_code_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Postcode');
        }else {
        bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
        }

      }else if ($(".box_tel_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Telephone number');
        }else {
        bootbox.alert('กรุณากรอก เบอร์โทรศัพท์');
        }

      }else if ($(".box_nameperson_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in First name');
        }else {
        bootbox.alert('กรุณากรอก ชื่อ');
        }

      }else if ($(".box_lastnameperson_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Last name');
        }else {
        bootbox.alert('กรุณากรอก นามสกุล');
        }

      }else if ($(".box_cardnumber_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in 13-digit Population Identification Code');
        }else {
        bootbox.alert('กรุณากรอก เลขบัตรประชาชน');
        }

      }else if ($(".box_position_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Position');
        }else {
        bootbox.alert('กรุณากรอก ตำแหน่ง');
        }

      }else if ($(".box_address_person_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in Address');
        }else {
        bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
        }

      }else if ($(".box_code_person_agentoffice").val() == "") {
        if(lang == "2"){
      bootbox.alert('Please fill in Postcode');
        }else {
      bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
        }

      }else if ($(".box_email_agentoffice").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please fill in E-mail');
        }else {
        bootbox.alert('กรุณากรอก E-mail');
        }

      }else if ($("#sel_country_person_office").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please choose Country');
        }else {
        bootbox.alert('กรุณาเลือก ประเทศ');
        }

      }else if ($("#sel_country_office").val() == "") {
        if(lang == "2"){
        bootbox.alert('Please choose Country');
        }else {
        bootbox.alert('กรุณาเลือก ประเทศ');
        }

      }else {
        $('#wait_process').css('display','block');
        var form_data = new FormData();
            form_data.append('file', fileTumbnail);
            form_data.append('file_fb', $('.img_f').val());
            form_data.append('box_name_agentoffice', $(".box_name_agentoffice").val());
            form_data.append('box_branch_agentoffice', $(".box_branch_agentoffice").val());
            form_data.append('box_trade_agentoffice', $(".box_trade_agentoffice").val());
            form_data.append('box_address_agentoffice', $(".box_address_agentoffice").val());
            if($("#sel_city_office").val() != ""){
              form_data.append('sel_city_office', $("#sel_city_office").val());
            }else {
              form_data.append('sel_city_office', $(".sel_city_office_txt").val());
            }
            form_data.append('box_code_agentoffice', $(".box_code_agentoffice").val());
            form_data.append('sel_country_office', $("#sel_country_office").val());
            form_data.append('box_tel_agentoffice', $(".box_tel_agentoffice").val());
            form_data.append('box_fix_agentoffice', $(".box_fix_agentoffice").val());
            form_data.append('department_members', $('input[name=department_members]:checked', '#member_com').val());
            form_data.append('box_nameperson_agentoffice', $(".box_nameperson_agentoffice").val());
            form_data.append('box_lastnameperson_agentoffice', $(".box_lastnameperson_agentoffice").val());
            form_data.append('box_cardnumber_agentoffice', $(".box_cardnumber_agentoffice").val());
            form_data.append('box_position_agentoffice', $(".box_position_agentoffice").val());
            form_data.append('box_address_person_agentoffice', $(".box_address_person_agentoffice").val());
            if($("#sel_city_person_office").val() != ""){
              form_data.append('sel_city_person_office', $("#sel_city_person_office").val());
            }else {
              form_data.append('sel_city_person_office', $(".sel_city_person_office_txt").val());
            }
            form_data.append('box_code_person_agentoffice', $(".box_code_person_agentoffice").val());
            form_data.append('sel_country_person_office', $("#sel_country_person_office").val());
            form_data.append('box_tel_person_agentoffice', $(".box_tel_person_agentoffice").val());
            form_data.append('box_fix_person_agentoffice', $(".box_fix_person_agentoffice").val());
            form_data.append('office_sex', $('input[name=sex]:checked', '#member_com').val());
            form_data.append('box_email_agentoffice', $(".box_email_agentoffice").val());
            form_data.append('fb_id', fb_id);
            form_data.append('fb_name', fb_name);
            form_data.append('status', status);
            form_data.append('method', "register_member_com");


              $.ajax({
                  url: 'function_php/function_member.php',
                  type: 'POST',
                  enctype: 'multipart/form-data',
                  async: false,
                  processData: false,
                  contentType: false,
                  responseType: "json",
                  data: form_data,
                success: function(res) {
                  if(res.email_chk_mem == "00"){
                    if(lang == "2"){
                      bootbox.alert('This e-mail is already in the system, please check.',function(){
                        $('#wait_process').css('display','none');
                      });
                    }else {
                      bootbox.alert('E-mail นี้มีอยู่ในระบบแล้วกรุณาตรวจสอบ',function(){
                        $('#wait_process').css('display','none');
                      });
                    }

                  }else if (res.email_chk_mem == "01") {
                    if(lang == "2"){
                      bootbox.alert('Registered successfully',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }else {
                      bootbox.alert('ลงทะเบียนเรียบร้อย',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }

                  }else {
                    bootbox.alert('ERROR !',function(){
                      $('#wait_process').css('display','none');
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR, textStatus, errorThrown);

                }
              });
            }
      }else {
        if(lang == "2"){
        bootbox.alert('Please fill in Mobile telephone number to complete.');
        }else {
        bootbox.alert('กรุณากรอกช่อง เบอร์โทรศัพท์มือถือ ให้ครบถ้วน');
        }

      }
    }
});



$(document).delegate(".btn_member","click",function(){
  var lang = $('.lang').val();
  var status = $('.status_login').val();
  var fb_id = $('.fb_id').val();
  var fb_name = $('.fb_name').val();
  var chkpass = $(".box_password_agentperson").val();



  var re = new RegExp(/^(?=.*\d)(?=.*[0-9a-zA-Z]).{8,}$/);
  var str = $(".box_fix_person_agentperson").val();
  var rel = /_/g;
  var rex = /-/g;
  var res = str.replace(rel, "");
  var resx = res.replace(rex, "");
  var n = resx.length;
  if(status == "0"){
    if(re.test(chkpass) == true){

      
      if(n == 10){
    if($(".box_password_agentperson").val() == $(".box_re_password_agentperson").val()){
      if ($(".box_nameperson_agentperson").val() == "") {
        if(lang == "2"){
            bootbox.alert('Please fill in First name');
        }else {
            bootbox.alert('กรุณากรอก ชื่อ');
        }
      }else if ($(".box_lastnameperson_agentperson").val() == "") {
        if(lang == "2"){
            bootbox.alert('Please fill in Last name');
        }else {
            bootbox.alert('กรุณากรอก นามสกุล');
        }
      }else if ($(".box_cardnumber_agentoffice").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in 13-digit Population Identification Code');
        }else {
          bootbox.alert('กรุณากรอก เลขบัตรประชาชน');
        }

      }else if ($(".box_position_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Occupation');
        }else {
          bootbox.alert('กรุณากรอก อาชีพ');
        }

      }else if ($(".box_address_person_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Address');
        }else {
          bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
        }

      }else if ($(".box_code_person_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Postcode');
        }else {
          bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
        }

      }else if ($(".box_tel_person_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Telephone number');
        }else {
          bootbox.alert('กรุณากรอก เบอร์โทรศัพท์');
        }

      }else if ($(".box_email_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in E-mail');
        }else {
          bootbox.alert('กรุณากรอก E-mail');
        }

      }else if ($(".box_password_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Password');
        }else {
          bootbox.alert('กรุณากรอก รหัสผ่าน');
        }

      }else if ($(".box_re_password_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Please verify your password');
        }else {
          bootbox.alert('กรุณากรอก ยืนยันรหัสผ่าน');
        }

      }else if ($(".box_fix_person_agentperson").val() == "") {
        if(lang == "2"){
          bootbox.alert('Please fill in Mobile telephone number');
        }else {
          bootbox.alert('กรุณากรอก เบอร์โทรศัพท์มือถือ');
        }

      }else {
        $('#wait_process').css('display','block');
        setTimeout(function(){
          var form_data = new FormData();
              form_data.append('file', fileTumbnail);
              form_data.append('box_nameperson_agentperson', $(".box_nameperson_agentperson").val());
              form_data.append('box_lastnameperson_agentperson', $(".box_lastnameperson_agentperson").val());
              form_data.append('box_cardnumber_agentoffice', $(".box_cardnumber_agentoffice").val());
              form_data.append('box_position_agentperson', $(".box_position_agentperson").val());
              form_data.append('box_address_person_agentperson', $(".box_address_person_agentperson").val());
              if($("#sel_city_person_person").val() != ""){
                form_data.append('sel_city_person_person', $("#sel_city_person_person").val());
              }else {
                form_data.append('sel_city_person_person', $(".sel_city_person_person_txt").val());
              }
              form_data.append('box_code_person_agentperson', $(".box_code_person_agentperson").val());
              form_data.append('sel_country_person_person', $("#sel_country_person_person").val());
              form_data.append('box_tel_person_agentperson', $(".box_tel_person_agentperson").val());
              form_data.append('box_fix_person_agentperson', $(".box_fix_person_agentperson").val());
              form_data.append('sex_person', $('input[name=sex_person]:checked', '#member').val());
              form_data.append('box_email_agentperson', $(".box_email_agentperson").val());
              form_data.append('box_password_agentperson', $(".box_password_agentperson").val());
              form_data.append('status', status);
              form_data.append('g-recaptcha-response', $("textarea[name='g-recaptcha-response']").val());
              form_data.append('method', "register_member");


                $.ajax({
                    url: 'function_php/function_member.php',
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    async: false,
                    processData: false,
                    contentType: false,
                    responseType: "json",
                    data: form_data,
                  success: function(res) {
                    if(res.email_chk_mem == "00"){
                      if(lang == "2"){
                        bootbox.alert('This e-mail is already in the system, please check.',function(){
                          $('#wait_process').css('display','none');
                        });
                      }else {
                        bootbox.alert('E-mail นี้มีอยู่ในระบบแล้วกรุณาตรวจสอบ',function(){
                          $('#wait_process').css('display','none');
                        });
                      }

                    }else if (res.email_chk_mem == "01") {
                      if(res.chk_mail == "00"){
                        if(lang == "2"){
                          bootbox.alert('Registered successfully Please confirm your Email subscription.',function(){
                            window.location.href = '/frontend/index.php?page=home&lang='+lang;
                          });
                        }else {
                          bootbox.alert('ลงทะเบียนเรียบร้อย กรุณายืนยันการสมัครสมาชิกทาง E-mail ของท่าน',function(){
                            window.location.href = '/frontend/index.php?page=home&lang='+lang;
                          });
                        }
                      }

                    }else if (res.email_chk_mem == "02") {
                      if(lang == "2"){
                        bootbox.alert('Please specify Captcha to prove the person. If you are not Robot or spam',function(){
                          $('#wait_process').css('display','none');
                        });
                      }else {
                        bootbox.alert('กรุณาระบุ Capcha เพือพิสูจน์บุคคล หากท่านไม่ใช่ หุ่นยนต์หรือสแปม',function(){
                          $('#wait_process').css('display','none');
                        });
                      }

                    }else if (res.email_chk_mem == "03") {
                      if(lang == "2"){
                        bootbox.alert('Please specify correct Captcha.',function(){
                          $('#wait_process').css('display','none');
                        });
                      }else {
                        bootbox.alert('กรุณาระบุ Capcha ให้ถูกต้อง',function(){
                          $('#wait_process').css('display','none');
                        });
                      }

                    }else {
                      bootbox.alert('ERROR !',function(){
                        $('#wait_process').css('display','none');
                      });
                    }


                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);

                  }
                });
        }, 1000);

            }
          }else{
            if(lang == "2"){
              bootbox.alert('Please fill in "Password" and "Please verify your password" Match');
            }else {
              bootbox.alert('กรุณากรอกช่อง "รหัสผ่าน" และช่อง "ยืนยันรหัสผ่าน" ให้ตรงกัน');
            }

        }
      }else {
        if(lang == "2"){
          bootbox.alert('Please fill in Mobile telephone number to complete.');
        }else {
          bootbox.alert('กรุณากรอกช่อง เบอร์โทรศัพท์มือถือ ให้ครบถ้วน');
        }

      }
      }else {
        if(lang == "2"){
          bootbox.alert('must contain alphanumeric A-Z, a-z, 0-9, with at least 8 digits in length');
        }else {
          bootbox.alert('รหัสผ่านต้องมี A-Z,a-z และ 0-9 อย่างน้อย 1 ตัว และมีอย่างน้อย 8 หลัก');
        }
}

  }else {
    if(n == 10){
    if ($(".box_nameperson_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in First name');
      }else {
        bootbox.alert('กรุณากรอก ชื่อ');
      }

    }else if ($(".box_lastnameperson_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Last name');
      }else {
        bootbox.alert('กรุณากรอก นามสกุล');
      }

    }else if ($(".box_cardnumber_agentoffice").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in 13-digit Population Identification Code');
      }else {
        bootbox.alert('กรุณากรอก เลขบัตรประชาชน');
      }

    }else if ($(".box_position_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Occupation');
      }else {
        bootbox.alert('กรุณากรอก อาชีพ');
      }

    }else if ($(".box_address_person_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Address');
      }else {
        bootbox.alert('กรุณากรอก ที่อยู่ติดต่อ');
      }

    }else if ($(".box_code_person_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Postcode');
      }else {
        bootbox.alert('กรุณากรอก รหัสไปรษณีย์');
      }

    }else if ($(".box_tel_person_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Telephone number');
      }else {
        bootbox.alert('กรุณากรอก เบอร์โทรศัพท์');
      }

    }else if ($(".box_email_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in E-mail');
      }else {
        bootbox.alert('กรุณากรอก E-mail');
      }

    }else if ($(".box_fix_person_agentperson").val() == "") {
      if(lang == "2"){
        bootbox.alert('Please fill in Mobile telephone number');
      }else {
        bootbox.alert('กรุณากรอก เบอร์โทรศัพท์มือถือ');
      }

      }else {
        $('#wait_process').css('display','block');
        var form_data = new FormData();
            form_data.append('file', fileTumbnail);
            form_data.append('file_fb', $('.img_f').val());
            form_data.append('box_nameperson_agentperson', $(".box_nameperson_agentperson").val());
            form_data.append('box_lastnameperson_agentperson', $(".box_lastnameperson_agentperson").val());
            form_data.append('box_cardnumber_agentoffice', $(".box_cardnumber_agentoffice").val());
            form_data.append('box_position_agentperson', $(".box_position_agentperson").val());
            form_data.append('box_address_person_agentperson', $(".box_address_person_agentperson").val());
            if($("#sel_city_person_person").val() != ""){
              form_data.append('sel_city_person_person', $("#sel_city_person_person").val());
            }else {
              form_data.append('sel_city_person_person', $(".sel_city_person_person_txt").val());
            }
            form_data.append('box_code_person_agentperson', $(".box_code_person_agentperson").val());
            form_data.append('sel_country_person_person', $("#sel_country_person_person").val());
            form_data.append('box_tel_person_agentperson', $(".box_tel_person_agentperson").val());
            form_data.append('box_fix_person_agentperson', $(".box_fix_person_agentperson").val());
            form_data.append('sex_person', $('input[name=sex_person]:checked', '#member').val());
            form_data.append('box_email_agentperson', $(".box_email_agentperson").val());
            form_data.append('fb_id', fb_id);
            form_data.append('fb_name', fb_name);
            form_data.append('status', status);
            // form_data.append('g-recaptcha-response', $("textarea[name='g-recaptcha-response']").val());
            form_data.append('method', "register_member");
              $.ajax({
                  url: 'function_php/function_member.php',
                  type: 'POST',
                  enctype: 'multipart/form-data',
                  async: false,
                  processData: false,
                  contentType: false,
                  responseType: "json",
                  data: form_data,
                success: function(res) {
                  // console.log(res);
                  if(res.email_chk_mem == "00"){
                    if(lang == "2"){
                      bootbox.alert('This e-mail is already in the system, please check.',function(){
                        $('#wait_process').css('display','none');
                      });
                    }else {
                      bootbox.alert('E-mail นี้มีอยู่ในระบบแล้วกรุณาตรวจสอบ',function(){
                        $('#wait_process').css('display','none');
                      });
                    }

                  }else if (res.email_chk_mem == "01") {
                    if(lang == "2"){
                      bootbox.alert('Registered successfully',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }else {
                      bootbox.alert('ลงทะเบียนเรียบร้อย',function(){
                        window.location.href = '/frontend/index.php?page=home&lang='+lang;
                      });
                    }

                  }else {
                    bootbox.alert('ERROR !',function(){
                      $('#wait_process').css('display','none');
                    });
                  }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR, textStatus, errorThrown);

                }
              });
            }
  }else {
    if(lang == "2"){
      bootbox.alert('Please fill in Mobile telephone number to complete.');
    }else {
      bootbox.alert('กรุณากรอกช่อง เบอร์โทรศัพท์มือถือ ให้ครบถ้วน');
    }

  }
}

});



function chk_department_members(type_radio){
  if(type_radio == 1){
    document.getElementById("department_members_1").checked = true;
    document.getElementById("department_members_2").checked = false;
  }else {
    document.getElementById("department_members_1").checked = false;
    document.getElementById("department_members_2").checked = true;
  }
}

function chk_sex(type_radio){
  if(type_radio == 1){
    document.getElementById("sex_1").checked = true;
    document.getElementById("sex_2").checked = false;
  }else {
    document.getElementById("sex_1").checked = false;
    document.getElementById("sex_2").checked = true;
  }
}

function chk_sex_person(type_radio){
  if(type_radio == 1){
    document.getElementById("sex_person_1").checked = true;
    document.getElementById("sex_person_2").checked = false;
  }else {
    document.getElementById("sex_person_1").checked = false;
    document.getElementById("sex_person_2").checked = true;
  }
}

$(document).delegate(".sel_country_office","click",function(){
  var sel_country_office = document.getElementById('sel_country_office').selectedOptions[0].text;
    if(sel_country_office != "Thailand"){
      $('.sel_city_office').hide();
      $('.div_office_code').css('text-align','left');
    }else {
      $("#sel_city_office").prop('disabled', false);
      $('.sel_city_office').show();
      $('.div_office_code').css('text-align','right');
      $('.selectpicker').selectpicker('refresh');
    }
  });

  $(document).delegate(".sel_country_person_office","click",function(){
    var sel_country_person_office = document.getElementById('sel_country_person_office').selectedOptions[0].text;
      if(sel_country_person_office != "Thailand"){
        $('.sel_city_person_office').hide();
        $('.div_office_code_po').css('text-align','left');
      }else {
        $("#sel_city_person_office").prop('disabled', false);
        $('.sel_city_person_office').show();
        $('.div_office_code_po').css('text-align','right');
        $('.selectpicker').selectpicker('refresh');
      }
    });

    $(document).delegate(".sel_country_person_person","click",function(){
      var sel_country_person_person = document.getElementById('sel_country_person_person').selectedOptions[0].text;
        if(sel_country_person_person != "Thailand"){
          $('.sel_city_person_person').hide();
          $('.div_office_code').css('text-align','left');
        }else {
          $("#sel_city_person_person").prop('disabled', false);
          $('.sel_city_person_person').show();
          $('.div_office_code').css('text-align','right');
          $('.selectpicker').selectpicker('refresh');
        }
      });
