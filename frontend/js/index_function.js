var fileTumbnail = "";

function readURL_thumbnail(input, callback) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            fileTumbnail = e.target.result;
            if (typeof callback === "function") {
                callback(fileTumbnail);
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

var file_tmp_list = [];
$(document).ready(function() {

    var filePreview_new = function(input, callback) {
        if (input) {

            var reader = new FileReader();

            reader.onload = function(event) {
                var file_tmp = event.target.result;
                if (typeof callback === "function") {
                    callback(file_tmp);
                }
            }

            reader.readAsDataURL(input);
        }

    }

    $('.file_box').change(function() {
        var file_attach = $(this)[0].files;
        var file_attach_length = file_attach.length;
        for (i = 0; i < file_attach_length; i++) {
            var fileview = filePreview_new(this.files[i], function(file_tmp) {
                file_tmp_list.push(file_tmp);
            });
        }
    });

});

$(document).delegate(".btn_browse_file", "click", function() {
    $(".file_box").click();
});



$(document).delegate(".file_profile", "change", function() {
    $('.name_file_edit').val(this.files[0].name);
    readURL_thumbnail(this, function(pathfile) {
        $('.img_profile_edit').attr('src', pathfile);
        var image = new Image();
        image.src = pathfile;
        image.onload = function() {
            $('.img_profile_edit').attr('style', getPositionImage(this.width, this.height, 120));
        }

        // $('.img_profile_edit').css('background-image', 'url(' + pathfile + ')');
    });
});


function getPositionImage(width, height, size) {
    var ratio = (width / height); // width/height
    var css = "";
    if (ratio > 1) {
        width = (size * ratio);
        height = size;
        css = " width:auto; height:100%; margin-left:-" + ((width * 0.5) - (size * 0.5)) + "px";
    } else {
        width = size;
        height = (size / ratio);
        css = "height:auto; width:100%; top:0;";
    }
    return css;
}

function count_checkcorporation_clicked(){
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        dataType: "json",
        async: true,
        data: {
            method: "count_checkcorporation_clicked",
            // member_id: member_id,
        },
        success: function(data) {
            console.log(data);

        },
        error: function(err) {
            console.log({
                error: err
            });

        }
    });
}



function show_modal(type) {
    if (type == 1) {
        $('#modal_chk_invite').modal('hide');
    } else {
        $('#modal_chk_invite').modal('show');
    }
}
$(document).delegate(".btn-chk-detail", "click", function() {
    var lang = $('.language_hidden').val();
    if (lang == 2) {
        var txt = "Please choose accept condition";
    } else {
        var txt = "กรุณาเลือกทราบและยอมรับเงื่อนไข";
    }
    var chk_conf = false;
    $('#chk_invite_detail').each(function() {
        if ($(this).is(":checked")) {
            chk_conf = true;
        }
    });
    if (chk_conf == true) {
        var chk_invite_con = $("input[name='chk_invite_detail']:checked").val();
        $('.chk_confirm').val(chk_invite_con);
    } else {
        bootbox.alert(txt, function() {
            window.location.reload();
        });
    }

});

$(document).delegate(".btn-chk-invite", "click", function() {
    var lang = $('.language_hidden').val();
    var chk_radio_step = $('#rdi_compType_id').val();
    var compType_other_txt = $('.compType_other_txt').val();
    // var chk_radio_step1 = $('input[name=rdi_compTypeSub1]:checked', '#chk_invite_step1').val();
    // var chk_radio_step2 = $('input[name=rdi_compTypeSub2]:checked', '#chk_invite_step1').val();

    var chk_radio_step1 = $('input[name=rdi_compTypeSub1]', '#chk_invite_step1').val();
    var chk_radio_step2 = $('input[name=rdi_compTypeSub2]', '#chk_invite_step1').val();

    if ($('.chk_confirm').val() == "") {
        if (lang == "2") {
            bootbox.alert("Please agree to the terms and conditions before creating petition", function() {
                window.location.reload();
            });
        } else {
            bootbox.alert("กรุณายอมรับเงื่อนไขก่อนตั้งเรื่องร้องเรียน", function() {
                window.location.reload();
            });
        }
        // location.reload();
    } else {
        $('#wait_process').css('display', 'block');
        $.ajax({
            url: 'function_php/function_index.php',
            type: 'POST',
            async: false,
            responseType: "json",
            data: {
                'chk_radio_step': chk_radio_step,
                'compType_other_txt': compType_other_txt,
                'chk_radio_step1': chk_radio_step1,
                'chk_radio_step2': chk_radio_step2,
                'method': "chk_invite_step"
            },
            success: function(res) {
                if (res.in_chk == "00") {
                    $("#chk_invite_step1").submit();
                } else if (res.in_chk == "02") {
                    $("#chk_invite_step1").submit();
                } else if (res.in_chk == "03") {
                    if (lang == "2") {
                        bootbox.alert("Please specify", function() {
                            $('#wait_process').css('display', 'none');
                        });
                    } else {
                        bootbox.alert("กรุณาระบุให้ครบถ้วน", function() {
                            $('#wait_process').css('display', 'none');
                        });
                    }
                } else {
                    if (lang == "2") {
                        bootbox.alert("Please select the type of complaint", function() {
                            $('#wait_process').css('display', 'none');
                        });
                    } else {
                        bootbox.alert("กรุณาเลืกประเภทเรื่องร้องเรียน", function() {
                            $('#wait_process').css('display', 'none');
                        });
                    }

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }


});

function validateForm(x) {
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
        return false;
    } else {
        return true;
    }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function bootbox_person(txt, index){
    bootbox.confirm(txt, function() {
        $('#wait_process').css('display', 'none');
        setTimeout(function() {
            $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
        }, 500);
    });
}

function bootbox_person1(txt, index){
    bootbox.confirm(txt, function() {
        $('#wait_process').css('display', 'none');
        setTimeout(function() {
            if(index == 13) {
                $('input[name="appint_personinfo13"]').focus();
            } else {
                $("[name='appint_personinfo1[]']:eq(" + (index) + ")").focus();
            }
        }, 500);
    });
}

function bootbox_Represent(txt, index){
    bootbox.confirm(txt, function() {
        $('#wait_process').css('display', 'none');
        setTimeout(function() {
            $("[name='Represent_value[]']:eq(" + index + ")").focus();
        }, 500);
    });
}

function Alert_valEmptyPerson(index_empty){
        if(index_empty == 0)
        bootbox_person("กรุณากรอกชื่อ", index_empty)
    else if(index_empty == 1)
        bootbox_person("กรุณากรอกนามสกุล", index_empty)
    else if(index_empty == 2)
        bootbox_person("กรุณากรอกเลขบัตรประชาชน", index_empty)
    else if(index_empty == 3)
        bootbox_person("กรุณากรอกเบอร์โทรศัพท์", index_empty)
    else if(index_empty == 4)
        bootbox_person("กรุณากรอกอีเมล", index_empty)
    else if(index_empty == 5)
        bootbox_person("กรุณากรอกที่อยู่", index_empty)
    else if(index_empty == 7)
        bootbox_person("กรุณากรอกรหัสไปรษณีย์", index_empty) 
    else if(index_empty == 15)
        bootbox_person("กรุณาเลือก รหัสประเทศ", index_empty)    
}

function Alert_valEmptyPerson1(index_empty, type){
    if(type == 2){
        bootbox.confirm("กรุณากรอกอาชีพในการยืนเรื่องนามบุคคลธรรมดา", function() {
            $('#wait_process').css('display', 'none');
            setTimeout(function() {
                $("[name='appint_personinfo2[]']").focus();
            }, 500);
        });
    } else {
        // console.log(index_empty);
        if(index_empty == 0)
            bootbox_person1("กรุณากรอกเลขนิติบุคคล", index_empty);
        else if(index_empty == 1)
            bootbox_person1("กรุณากรอกชื่อบริษัทที่จดทะเบียน", index_empty);
        else if(index_empty == 4)
            bootbox_person1("กรุณากรอกตำแหน่ง", index_empty);
        else if(index_empty == 5)
            bootbox_person1("กรุณากรอกเบอร์โทรศัพท์ให้ครบ 10 หลัก", index_empty);
        else if(index_empty == 6)
            bootbox_person1("กรุณากรอกเว็บไซต์", index_empty);
        else if(index_empty == 7)
            bootbox_person1("กรุณากรอกที่อยู่ติดต่อ", index_empty);
        else if(index_empty == 8)
            bootbox_person1("กรุณากรอกประเทศ", index_empty);
        else if(index_empty == 9)
            bootbox_person1("กรุณากรอกรหัสไปรษณีย์", index_empty);
        else if(index_empty == 13)
            bootbox_person1("กรุณากรอกประเภทธุรกิจ", index_empty);
        else if(index_empty == 91)
            bootbox_person1("กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก", 9);
        else if(index_empty == 15)
            bootbox_person("กรุณาเลือก รหัสประเทศ", index_empty);   
    }
    
}

function Checkvalue_Represent(value){
    var valid = true;
    var index_empty;
    $.each(value, function(index, propval) {
        if(propval == ''){
            member_type = $('#member_type').val();
            if(member_type != 1) {
                if(index == 3 || index == 4 || index == 6){

                }else{
                    $("[name='Represent_value[]']:eq(" + index + ")").focus();
                    index_empty = index;
                    return valid = false;
                }
            }
        }
    })
    if(valid == false){
        Alert_valEmpty(index_empty, 1)
    }
    return valid;
}

function Alert_valEmpty(index_empty, select){
    if(select == 2){
        bootbox.confirm("กรุณาเลือกอาชีพในการยืนเรื่องนามบุคคลธรรมดา", function() {
            $('#wait_process').css('display', 'none');
            setTimeout(function() {
                $("[name='appint_personinfo2[]']").focus();
            }, 500);
        });
    }
    else{
        // console.log(index_empty);
        if(index_empty == 0)
            bootbox_Represent("กรุณากรอกเลขนิติบุคคล", index_empty);
        else if(index_empty == 1)
            bootbox_Represent("กรุณากรอกชื่อบริษัทที่จดทะเบียน", index_empty);
        else if(index_empty == 3)
            bootbox_Represent("กรุณากรอกประเภทธุรกิจ", index_empty);
        else if(index_empty == 5)
            bootbox_Represent("กรุณากรอกเบอร์โทรศัพท์", index_empty);
        else if(index_empty == 6)
            bootbox_Represent("กรุณากรอกเว็บไซต์", index_empty);
        else if(index_empty == 7)
            bootbox_Represent("กรุณากรอกที่อยู่ติดต่อ", index_empty);
        else if(index_empty == 8)
            bootbox_Represent("กรุณากรอกรหัสไปรษณีย์", index_empty);
    }
}

function Checkvalue_Natural(value){
    var valid = true;
    var index_empty;
    $.each(value, function(index, propval) {
        // if(propval == ''){
        //     $("[name='appint_personinfo2[]']").focus();
        //     index_empty = index;
        //     return valid = false;
        // }
    })
    if(valid == false){
        Alert_valEmpty(index_empty, 2)
    }
    console.log(valid);
    return valid;
}

function Check_Personinfo(){
    var values = $("[name='appint_personinfo[]']").map(function(){
        return $(this).val();
    }).get();
    values.splice(0, 2);

    var type = '';
    $('[name="appint_personType[]"]').each(function() {
        var sThisVal = (this.checked ? $(this).val() : "");
        if (sThisVal != '') {
            type = sThisVal;
        }
    })

    var values1 = $("[name='appint_personinfo1[]']").map(function(){
        return $(this).val();
    }).get();

    var valid = true;
    var valid1 = true;
    var index_empty;

    // console.log(values1);

    var country = '';
    $.each(values, function(index, value){
        if(index == 6) {
            country = value;
        }
    })
    $.each(values, function(index, value){
        if(index == 2){
            if(country == 162) {
                if(value.length != 13) {
                    $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                    bootbox_person("กรุณากรอกเลขบัตรประชาชนให้ครบ 13 หลัก", index)    
                    return valid = false;
                }
            }
        } else if(index == 3){
            if(country == 162) {
                if(value.length != 10) {
                    $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                    bootbox_person("กรุณากรอกเบอร์โทรศัพท์ให้ครบ 10 หลัก", index)    
                    return valid = false;
                }
            }

            var ctry3 = intPhoneInfo.getSelectedCountryData().iso2
            var code3 = intPhoneInfo.getSelectedCountryData().dialCode

            if(!ctry3) {
                index_empty = 15;
                return valid = false;
            } else {
                $("[name='applnt_mobile_country']").val(ctry3.toUpperCase());
                $("[name='applnt_mobile_code']").val('+'+code3);
            }

        } else if(index == 4){
            if(validateEmail(value) == false){
                $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                index_empty = index;
                return valid = false;
            }
        } else if(index == 6) {
            country = value;
        } else  if(index == 7) {
            if(country == 162) {
                if(value.length != 5) {
                    $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                    bootbox_person("กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก", index)    
                    return valid = false;
                }
            } else {
                if(value == '') {
                    $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                    bootbox_person("กรุณากรอกรหัสไปรษณีย์", index)    
                    return valid = false;
                }
            }
            
        } else{
            if(value == ''){
                $("[name='appint_personinfo[]']:eq(" + (index + 2) + ")").focus();
                index_empty = index;
                return valid = false;
            }
        }
    })

    if(valid == false){
        Alert_valEmptyPerson(index_empty);
        return 0;
    }
    

    var valuec = '';
    var country = '';

    

    if(type == 1) {
        $('#appint_personType').val(1);
        member_type = $("[name='rdi_compTypeSub1']").val();

        $.each(values1, function(index, value){
            if(index == 8) {
                country = value;
            }
        })
        $.each(values1, function(index, value){
            // console.log(value);
            if(index == 2) {
                if(value == 0) {
                    valuec = $('input[name="appint_personinfo13"]').val();
                    if(valuec == '') {
                        // bootbox_person1("กรุณากรอกประเภทธุรกิจ", 13) 
                        index_empty = 13;
                        return valid1 = false;
                    }
                } 
            } else if(index == 5) {
                if(country == 162) {
                    if(value.length != 10) {
                        // bootbox_person1("กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก", index)    
                        index_empty = index;
                        return valid1 = false;
                    }
                }
                var ctry = intPhone.getSelectedCountryData().iso2
                var code = intPhone.getSelectedCountryData().dialCode
    
                if(!ctry) {
                    index_empty = 15;
                    return valid1 = false;
                } else {
                    $("[name='applntOrg_mobile_country']").val(ctry.toUpperCase());
                    $("[name='applntOrg_mobile_code']").val('+'+code);
                }

                
            } else if(index == 8) {
                country = value;
                if(country == 0) {
                    index_empty = index;
                    return valid1 = false;
                }
            } else if(index == 9) {
                if(country == 162) {
                    if(value.length != 5) {
                        // bootbox_person1("กรุณากรอกรหัสไปรษณีย์ให้ครบ 5 หลัก", index)    
                        index_empty = 91;
                        return valid1 = false;
                    }
                } else {
                    if(value == '') {
                        // bootbox_person1("กรุณากรอกรหัสไปรษณีย์", index)    
                        index_empty = 9;
                        return valid1 = false;
                    }
                }
                
            } else if (index == 3 || index == 4 || index == 6) {
                
            } else {
                if(value == ''){
                    index_empty = index;
                    return valid1 = false;
                }
            }
        })
        
        
        
    } else {
        $('#appint_personType').val(2);
        // value = $('input[name="appint_personinfo2[]"]').val();
        // // console.log(value);
        // if(value == '') {
        //     index_empty = 1;
        //     valid1 = false;
        // }
    }

    if(valid1 == false) {
        // console.log(type);
        Alert_valEmptyPerson1(index_empty, type);
        return 0;
    } 

    

    
}

function Newbtn_submit(){
    var rdicompType = $("input[name='rdi_compTypeSub1']").val();
    if(rdicompType == 1){
        if($('#CheckboxagentDefault').prop('checked') == true){
            var values = $("[name='appint_personinfo1[]']").map(function(){
                return $(this).val();
            }).get();

            if($('#selecttype_comp option:selected').val() != 0)
                values[3] = $('#selecttype_comp option:selected').text();
        
            var country_id = $('.country_newpanel option:selected').val();
            if(country_id == 0){
                bootbox.confirm("กรุณาเลือกประเทศ", function() {
                    $('#wait_process').css('display', 'none');
                    setTimeout(function() {
                        $('.country_newpanel .btn.dropdown-toggle').focus();
                    }, 500);
                });
                return false;
            }
            else{
                var country = $('.selectpicker.country_newpanel').parent().find('.btn.dropdown-toggle').attr('title');
                if(!country_id) {
                    var country_id = $('.person_country option:selected').val();
                }
                if(!country) {
                    var country = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
                }
                values.push(country_id);
                values.push(country);
                if(Checkvalue_Represent(values) == false){
                    return false;
                }else{
                    $('#appIntOrg_selectagenORposition').val(1);
                    $('#appIntOrg_countryname').val(country);
                    var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
                    $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
                    return values;
                }
            }
        }else{
            var values = $("input[name='appint_personinfo2[]']").map(function(){return $(this).val();}).get();
            if(Checkvalue_Natural(values) == false){
                return false;
            }else{
                $('#appIntOrg_selectagenORposition').val(2);
                var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
                $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
                return true;
            }
        }
    }
    else{
        var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
        $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
        return true;
    }
}

function Newbtn_editsubmit(){
    var rdicompType = $("input[name='rdi_compTypeSub1']").val();
    if(rdicompType == 1){
        if($('#CheckboxagentDefault').prop('checked') == true){
            var values = $("[name='Represent_value[]']").map(function(){
                return $(this).val();
            }).get();

            if($('#selecttype_comp option:selected').val() != 0)
                values[3] = $('#selecttype_comp option:selected').text();
        
            var country_id = $('.country_newpanel option:selected').val();
            if(country_id == 0){
                bootbox.confirm("กรุณาเลือกประเทศ", function() {
                    $('#wait_process').css('display', 'none');
                    setTimeout(function() {
                        $('.country_newpanel .btn.dropdown-toggle').focus();
                    }, 500);
                });
                return false;
            }
            else{
                var country = $('.selectpicker.country_newpanel').parent().find('.btn.dropdown-toggle').attr('title');
                values.push(country_id);
                values.push(country);
                $('[name="appIntOrg_countryname"]').val(country);
                if(Checkvalue_Represent(values) == false){
                    return false;
                }else{
                    $('#appIntOrg_selectagenORposition').val(1);
                    var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
                    $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
                    return values;
                }
            }
        }else{
            var values = $("input[name='appint_personinfo2[]']").map(function(){return $(this).val();}).get();
            // console.log(rdicompType);
            if(Checkvalue_Natural(values) == false){
                return false;
            }else{
                $('#appIntOrg_selectagenORposition').val(2);
                var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
                $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
                return true;
            }
        }
    }
    else{
        var appinfoperson = $('.selectpicker.person_country').parent().find('.btn.dropdown-toggle').attr('title');
        $('#appintpersoninfo').append(`<input type="text" class="form-control" id="" name="appint_personinfo[]" value="${appinfoperson}">`);
        return true;
    }
}

function btnchkinvitestep2(status_upload) {
    var lang = $('.language_hidden').val();
    var formSetId_a = $("input[name='formSetId_a']").val();
    var formSetId_b = $("input[name='formSetId_b']").val();
    var formSetId_c = $("input[name='formSetId_c']").val();

    var email = $("input[name='complnt_contact_email_IdxFs_" + formSetId_b + "']").val();
    var chkmail = true;
    if (email != "") {
        chkmail = validateEmail(email);
    }

    var ctry = intPhoneCmp.getSelectedCountryData().iso2
    var code = intPhoneCmp.getSelectedCountryData().dialCode

    if(!ctry) {
        ctry = '';
    } else {
        $("[name='complnt_mobile_country']").val(ctry.toUpperCase());
        $("[name='complnt_mobile_code']").val('+'+code);
    }

    if(!ctry) {
        ctry = '';
    }

    ///from1
    var form_data = new FormData();
    if (status_upload != true) {
        $.each($('input[type=file]')[0].files, function(i, file) {
            form_data.append('file[]', file);
        });

        $('input[name="caseAttach_file_name[]"]').each(function() {
            form_data.append('caseAttach_file_name[]', $(this).val());
        });
    }
    form_data.append('fileinput_file_remove', $("input[name='fileinput_file_remove").val());

    // form_data.append('applntOrg_name', $("input[name='applntOrg_name_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_position', $("input[name='applntOrg_position_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_trade_number', $("input[name='applntOrg_trade_number_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_address', $("textarea[name='applntOrg_address_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_tel', $("input[name='applntOrg_tel_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_zipcode', $("input[name='applntOrg_zipcode_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applnt_country_id', $("select[name='applnt_country_id_IdxFs_" + formSetId_a + "']").val());

    ///endfrom1
    ///from2
    form_data.append('complnt_name', $("input[name='complnt_name_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_import_export', $("select[name='complnt_import_export_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_contact_address', $("textarea[name='complnt_contact_address_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_prov_id', $("select[name='complnt_prov_id_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_country_id', $("select[name='complnt_country_id_IdxFs_" + formSetId_b + "']").val());

    form_data.append('complnt_branch', $("input[name='complnt_branch_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_position', $("input[name='complnt_position_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_zipcode', $("input[name='complnt_zipcode_IdxFs_" + formSetId_b + "']").val());
    ///endfrom2
    ///from3
    form_data.append('caseDtl_title', $("input[name='caseDtl_title_IdxFs_" + formSetId_c + "']").val());
    form_data.append('prodType_id', $("select[name='prodType_id_IdxFs_" + formSetId_c + "']").val());
    form_data.append('incType_id', $("select[name='incType_id_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_derivation', $("textarea[name='caseDtl_derivation_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_damage_val', $("input[name='caseDtl_damage_val_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_complnt_need', $("textarea[name='caseDtl_complnt_need_IdxFs_" + formSetId_c + "']").val());
    ///endfrom3

    //files


    //endfiles

    form_data.append('formSetId_a', formSetId_a);
    form_data.append('formSetId_b', formSetId_b);
    form_data.append('formSetId_c', formSetId_c);
    form_data.append('applntOrg_show', $('.applntOrg_show').val());
    form_data.append('rdi_compTypeSub1', $("input[name='rdi_compTypeSub1']").val());
    form_data.append('method', "chk_invite_txt");

    form_data.append('complnt_contact_tel_IdxFs_', $("input[name='complnt_contact_tel_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_contact_email_IdxFs_', $("input[name='complnt_contact_email_IdxFs_" + formSetId_b + "']").val());

    form_data.append('phone-number-complnt', ctry);


    var Newresult = Newbtn_submit();

    if (chkmail == false) {
        if (lang == 2) {
            var txt_mail = "Please check the format of your email correctly.";
        } else {
            var txt_mail = "กรุณาตรวจสอบรูปแบบอีเมล์ของท่านให้ถูกต้อง";
        }
        bootbox.alert(txt_mail);
    }else if(Newresult == false){
        return false;
    }else {
        $('#wait_process').css('display', 'block');
        $.ajax({
            url: 'function_php/function_index.php',
            type: 'POST',
            enctype: 'multipart/form-data',
            // timeout: 20000,
            cache: false,
            processData: false,
            contentType: false,
            responseType: "json",
            data: form_data,
            success: function(res) {
                // console.log(res);
                $('#wait_process').css('display', 'none');

                var txt = "";
                if (lang == 2) {
                    if (res.in_chk_file == "caseAttach_file_name") {
                        txt = "Please fill in File Name";
                    }

                    if (formSetId_b == 7) {
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Full name";
                        } else if (res.in_chk_error == "complnt_branch_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Organization";
                        } else if (res.in_chk_error == "complnt_position_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Position";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petition topic";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of goods";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Background information of the petition";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "You have not determined the value of the damage. Do you want to change the value of the damage?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petitioner’s requirement";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of complaint";
                        }
                    } else {
                        // if (res.in_chk_error == "applntOrg_name_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Company Name";
                        // } else if (res.in_chk_error == "applntOrg_position_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Position";
                        // } else if (res.in_chk_error == "applntOrg_trade_number_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Business Registration Number";
                        // } else if (res.in_chk_error == "applntOrg_address_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Address";
                        // } else if (res.in_chk_error == "applntOrg_tel_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Telephone Number";
                        // } else if (res.in_chk_error == "applntOrg_zipcode_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Postcode";
                        // } else if (res.in_chk_error == "applnt_country_id_IdxFs_" + formSetId_a) {
                        //     txt = "Please choose Country";
                        // } 
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Defendant’s company name";
                        } else if (res.in_chk_error == "complnt_import_export_IdxFs_" + formSetId_b) {
                            txt = "Please choose Type of business";
                        } else if (res.in_chk_error == "complnt_contact_address_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Address";
                        } else if (res.in_chk_error == "complnt_prov_id_IdxFs_" + formSetId_b) {
                            txt = "Please choose Province";
                        } else if (res.in_chk_error == "complnt_country_id_IdxFs_" + formSetId_b) {
                            txt = "Please choose Country";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petition topic";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of goods";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Background information of the petition";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "You have not determined the value of the damage. Do you want to change the value of the damage?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petitioner’s requirement";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of complaint";
                        } else if (res.in_chk_error == "complnt_contact_tel_IdxFs_" + formSetId_b) {
                            txt = "Please enter your phone number.";
                        } else if (res.in_chk_error == "complnt_contact_email_IdxFs_" + formSetId_b) {
                            txt = "Please fill email";
                        }
                    }

                } else {
                    if (res.in_chk_file == "caseAttach_file_name") {
                        txt = "กรุณากรอก ชื่อไฟล์เอกสาร";
                    }
                    if (formSetId_b == 7) {
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ชื่อ-นามสกุล";
                        } else if (res.in_chk_error == "complnt_branch_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก หน่วยงาน";
                        } else if (res.in_chk_error == "complnt_position_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ตำแหน่ง";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก หัวข้อเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทสินค้า";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความเป็นมาของประเด็นเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "ท่านยังไม่ได้กำหนดมูลค่าความเสียหายท่านต้องการเปลี่ยนแปลงมูลค่าความเสียหายหรือไม่ ?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความต้องการของผู้ร้องเรียน";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทความผิด";
                        }
                    } else {
                        // if (res.in_chk_error == "applntOrg_name_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ชื่อบริษัท";
                        // } else if (res.in_chk_error == "applntOrg_position_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ตำแหน่ง";
                        // } else if (res.in_chk_error == "applntOrg_trade_number_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก เลขนิติบุคคล";
                        // } else if (res.in_chk_error == "applntOrg_address_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ที่อยู่ติดต่อ";
                        // } else if (res.in_chk_error == "applntOrg_tel_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก เบอร์โทรศัพท์";
                        // } else if (res.in_chk_error == "applntOrg_zipcode_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก รหัสไปรษณีย์";
                        // } else if (res.in_chk_error == "applnt_country_id_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณาเลือก ประเทศ";
                        // } 
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ชื่อบริษัทที่ต้องการร้องเรียน";
                        } else if (res.in_chk_error == "complnt_import_export_IdxFs_" + formSetId_b) {
                            txt = "กรุณาเลือก ประเภทธุรกิจ";
                        } else if (res.in_chk_error == "complnt_contact_address_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ที่อยู่ติดต่อ";
                        } else if (res.in_chk_error == "complnt_prov_id_IdxFs_" + formSetId_b) {
                            txt = "กรุณาเลือก จังหวัด";
                        } else if (res.in_chk_error == "complnt_country_id_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ประเทศ";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก หัวข้อเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทสินค้า";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความเป็นมาของประเด็นเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "ท่านยังไม่ได้กำหนดมูลค่าความเสียหายท่านต้องการเปลี่ยนแปลงมูลค่าความเสียหายหรือไม่ ?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความต้องการของผู้ร้องเรียน";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทความผิด";
                        } else if (res.in_chk_error == "complnt_contact_tel_IdxFs_" + formSetId_b) {
                            if (res.in_chk_error1 == "telth") {
                                txt = "กรุณากรอก หมายเลขโทรศัพท์ที่ติดต่อให้ครบ 10 หลัก";
                            } else if (res.in_chk_error1 == "telen") {
                                txt = "กรุณากรอก หมายเลขโทรศัพท์ที่ติดต่อ";
                            } else if(res.in_chk_error1 == "telcode") {
                                txt = "กรุณาเลือก รหัสประเทศ";
                            }
                        } else if (res.in_chk_error == "complnt_contact_email_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก E-mail ที่ติดต่อ";
                        } else if (res.in_chk_error == "complnt_zipcode_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก รหัสไปรษณีย์ให้ครบ 5 หลัก";
                        }  else if (res.in_chk_error == "caseAttach_file_name" + res.in_chk_error1) {
                            txt = "กรุณากรอก หัวข้อของไฟล์แนบ";
                        } else if (res.in_chk_error == "file_invite"){
                            txt = "ประเภทไฟล์ไม่ถูกต้อง";
                        }
                    }
                }
                if (res.in_chk == "01") {

                    var in_chk_error = res.in_chk_error;
                    bootbox.alert(txt, function() {
                        setTimeout(function() {
                            $("[name='" + in_chk_error + "']").focus();
                        }, 500);
                    });


                } else if (res.in_chk == "02") {
                    bootbox.confirm(txt, function(result) {
                        if (result) {
                            $('#wait_process').css('display', 'none');
                            var in_chk_error = res.in_chk_error;
                            setTimeout(function() {
                                $("[name='" + in_chk_error + "']").focus();
                            }, 500);
                        } else {
                            $("#chk_invite_step2").submit();
                            $('#wait_process').css('display', 'none');

                        }
                    });
                } else if (res.in_chk == "05") {
                    var in_chk_error = res.in_chk_error;
                    bootbox.alert(txt, function() {
                        setTimeout(function() {
                            $("#" + in_chk_error).focus();
                        }, 500);
                    });
                } else {
                    $("#chk_invite_step2").submit();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);

                if (jqXHR.status == 0) {
                    bootbox.confirm("ขออภัยเนื่องจากอินเตอร์เน็ตของท่านขัดข้อง อาจทำให้ไฟล์แนบของท่านไม่สามารถอัพโหลดเข้าระบบได้ ท่านต้องการบันทึกเรื่องร้องเรียนหรือไม่?", function(result) {
                        if (result) {
                            btnchkinvitestep2(true);
                            $('#wait_process').css('display', 'none');
                        } else {
                            $('#wait_process').css('display', 'none');
                        }
                    });
                } else {
                    bootbox.alert("ขออภัย เนื่องจากระบบเกิดข้อผิดพลาด กรุณาลองใหม่ภายหลัง", function() {
                        $('#wait_process').css('display', 'none');
                    });
                }
            }
        });

    }
}



function btnchkinviteedit(status_upload) {
    var lang = $('.language_hidden').val();
    var formSetId_a = $("input[name='formSetId_a']").val();
    var formSetId_b = $("input[name='formSetId_b']").val();
    var formSetId_c = $("input[name='formSetId_c']").val();
    var email = $("input[name='complnt_contact_email_IdxFs_" + formSetId_b + "']").val();
    var chkmail = true;
    if (email != "") {
        chkmail = validateEmail(email);
    }

    // console.log(lang);
    ///from1
    var form_data = new FormData();
    if (status_upload != true) {
        $.each($('input[type=file]')[0].files, function(i, file) {
            form_data.append('file[]', file);
        });

        $('input[name="caseAttach_file_name[]"]').each(function() {
            form_data.append('caseAttach_file_name[]', $(this).val());
        });
    }
    form_data.append('fileinput_file_remove', $("input[name='fileinput_file_remove").val());
    // form_data.append('applntOrg_name', $("input[name='applntOrg_name_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_position', $("input[name='applntOrg_position_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_trade_number', $("input[name='applntOrg_trade_number_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_address', $("textarea[name='applntOrg_address_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_tel', $("input[name='applntOrg_tel_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applntOrg_zipcode', $("input[name='applntOrg_zipcode_IdxFs_" + formSetId_a + "']").val());
    // form_data.append('applnt_country_id', $("select[name='applnt_country_id_IdxFs_" + formSetId_a + "']").val());
    ///endfrom1
    ///from2
    form_data.append('complnt_name', $("input[name='complnt_name_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_import_export', $("select[name='complnt_import_export_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_contact_address', $("textarea[name='complnt_contact_address_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_prov_id', $("select[name='complnt_prov_id_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_country_id', $("select[name='complnt_country_id_IdxFs_" + formSetId_b + "']").val());

    form_data.append('complnt_branch', $("input[name='complnt_branch_IdxFs_" + formSetId_b + "']").val());
    form_data.append('complnt_position', $("input[name='complnt_position_IdxFs_" + formSetId_b + "']").val());
    ///endfrom2
    ///from3
    form_data.append('caseDtl_title', $("input[name='caseDtl_title_IdxFs_" + formSetId_c + "']").val());
    form_data.append('prodType_id', $("select[name='prodType_id_IdxFs_" + formSetId_c + "']").val());
    form_data.append('incType_id', $("select[name='incType_id_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_derivation', $("textarea[name='caseDtl_derivation_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_damage_val', $("input[name='caseDtl_damage_val_IdxFs_" + formSetId_c + "']").val());
    form_data.append('caseDtl_complnt_need', $("textarea[name='caseDtl_complnt_need_IdxFs_" + formSetId_c + "']").val());
    ///endfrom3


    form_data.append('formSetId_a', formSetId_a);
    form_data.append('formSetId_b', formSetId_b);
    form_data.append('formSetId_c', formSetId_c);
    form_data.append('applntOrg_show', $('.applntOrg_show').val());
    form_data.append('method', "chk_invite_txt_edit");

    var Newresult = Newbtn_editsubmit();

    if (chkmail == false) {
        if (lang == 2) {
            var txt_mail = "Please check the format of your email correctly.";
        } else {
            var txt_mail = "กรุณาตรวจสอบรูปแบบอีเมล์ของท่านให้ถูกต้อง";
        }
        bootbox.alert(txt_mail);
    }else if(Newresult == false){
        return false;
    } else {
        $('#wait_process').css('display', 'block');
        $.ajax({
            url: 'function_php/function_index.php',
            type: 'POST',
            enctype: 'multipart/form-data',
            timeout: 20000,
            cache: false,
            processData: false,
            contentType: false,
            responseType: "json",
            data: form_data,
            success: function(res) {

                var txt = "";
                if (lang == 2) {

                    if (res.in_chk_file == "caseAttach_file_name") {
                        txt = "Please fill in File Name";
                    }
                    if (formSetId_b == 7) {
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Full name";
                        } else if (res.in_chk_error == "complnt_branch_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Organization";
                        } else if (res.in_chk_error == "complnt_position_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Position";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petition topic";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of goods";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Background information of the petition";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "You have not determined the value of the damage. Do you want to change the value of the damage?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petitioner’s requirement";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of complaint";
                        }
                    } else {
                        // if (res.in_chk_error == "applntOrg_name_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Company Name";
                        // } else if (res.in_chk_error == "applntOrg_position_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Position";
                        // } else if (res.in_chk_error == "applntOrg_trade_number_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Business Registration Number";
                        // } else if (res.in_chk_error == "applntOrg_address_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Address";
                        // } else if (res.in_chk_error == "applntOrg_tel_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Telephone Number";
                        // } else if (res.in_chk_error == "applntOrg_zipcode_IdxFs_" + formSetId_a) {
                        //     txt = "Please fill in Postcode";
                        // } else if (res.in_chk_error == "applnt_country_id_IdxFs_" + formSetId_a) {
                        //     txt = "Please choose Country";
                        // } 
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Defendant’s company name";
                        } else if (res.in_chk_error == "complnt_import_export_IdxFs_" + formSetId_b) {
                            txt = "Please choose Type of business";
                        } else if (res.in_chk_error == "complnt_contact_address_IdxFs_" + formSetId_b) {
                            txt = "Please fill in Address";
                        } else if (res.in_chk_error == "complnt_prov_id_IdxFs_" + formSetId_b) {
                            txt = "Please choose Province";
                        } else if (res.in_chk_error == "complnt_country_id_IdxFs_" + formSetId_b) {
                            txt = "Please choose Country";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petition topic";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of goods";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Background information of the petition";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "You have not determined the value of the damage. Do you want to change the value of the damage?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "Please fill in Petitioner’s requirement";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "Please choose Type of complaint";
                        }
                    }

                } else {
                    if (res.in_chk_file == "caseAttach_file_name") {
                        txt = "กรุณากรอก ชื่อไฟล์เอกสาร";
                    }
                    if (formSetId_b == 7) {
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ชื่อ-นามสกุล";
                        } else if (res.in_chk_error == "complnt_branch_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก หน่วยงาน";
                        } else if (res.in_chk_error == "complnt_position_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ตำแหน่ง";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก หัวข้อเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทสินค้า";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความเป็นมาของประเด็นเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "ท่านยังไม่ได้กำหนดมูลค่าความเสียหายท่านต้องการเปลี่ยนแปลงมูลค่าความเสียหายหรือไม่ ?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความต้องการของผู้ร้องเรียน";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทความผิด";
                        }
                    } else {
                        // if (res.in_chk_error == "applntOrg_name_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ชื่อบริษัท";
                        // } else if (res.in_chk_error == "applntOrg_position_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ตำแหน่ง";
                        // } else if (res.in_chk_error == "applntOrg_trade_number_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก เลขนิติบุคคล";
                        // } else if (res.in_chk_error == "applntOrg_address_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก ที่อยู่ติดต่อ";
                        // } else if (res.in_chk_error == "applntOrg_tel_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก เบอร์โทรศัพท์";
                        // } else if (res.in_chk_error == "applntOrg_zipcode_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณากรอก รหัสไปรษณีย์";
                        // } else if (res.in_chk_error == "applnt_country_id_IdxFs_" + formSetId_a) {
                        //     txt = "กรุณาเลือก ประเทศ";
                        // }
                        if (res.in_chk_error == "complnt_name_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ชื่อบริษัทที่ต้องการร้องเรียน";
                        } else if (res.in_chk_error == "complnt_import_export_IdxFs_" + formSetId_b) {
                            txt = "กรุณาเลือก ประเภทธุรกิจ";
                        } else if (res.in_chk_error == "complnt_contact_address_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ที่อยู่ติดต่อ";
                        } else if (res.in_chk_error == "complnt_prov_id_IdxFs_" + formSetId_b) {
                            txt = "กรุณาเลือก จังหวัด";
                        } else if (res.in_chk_error == "complnt_country_id_IdxFs_" + formSetId_b) {
                            txt = "กรุณากรอก ประเทศ";
                        } else if (res.in_chk_error == "caseDtl_title_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก หัวข้อเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "prodType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทสินค้า";
                        } else if (res.in_chk_error == "caseDtl_derivation_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความเป็นมาของประเด็นเรื่องร้องเรียน";
                        } else if (res.in_chk_error == "caseDtl_damage_val_IdxFs_" + formSetId_c) {
                            txt = "ท่านยังไม่ได้กำหนดมูลค่าความเสียหายท่านต้องการเปลี่ยนแปลงมูลค่าความเสียหายหรือไม่ ?";
                        } else if (res.in_chk_error == "caseDtl_complnt_need_IdxFs_" + formSetId_c) {
                            txt = "กรุณากรอก ความต้องการของผู้ร้องเรียน";
                        } else if (res.in_chk_error == "incType_id_IdxFs_" + formSetId_c) {
                            txt = "กรุณาเลือก ประเภทความผิด";
                        } else if (res.in_chk_error == "file_invite"){
                            txt = "ประเภทไฟล์ไม่ถูกต้อง";
                        }
                    }
                }
                // console.log(txt, res.in_chk_error);
                $('#wait_process').css('display', 'none');
                if (res.in_chk == "01") {
                    var in_chk_error = res.in_chk_error;
                    bootbox.alert(txt, function() {
                        setTimeout(function() {
                            $("[name='" + in_chk_error + "']").focus();
                        }, 500);
                    });


                } else if (res.in_chk == "02") {
                    bootbox.confirm(txt, function(result) {
                        if (result) {
                            $('#wait_process').css('display', 'none');
                            var in_chk_error = res.in_chk_error;
                            setTimeout(function() {
                                $("[name='" + in_chk_error + "']").focus();
                            }, 500);
                        } else {
                            $("#chk_invite_step2").submit();
                            $('#wait_process').css('display', 'none');
                        }
                    });
                } else if (res.in_chk == "05") {
                    var in_chk_error = res.in_chk_error;
                    bootbox.alert(txt, function() {
                        setTimeout(function() {
                            $("#" + in_chk_error).focus();
                        }, 500);
                    });
                } else {

                    $("#chk_invite_step2").submit();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);

                if (jqXHR.status == 0) {
                    bootbox.confirm("ขออภัยเนื่องจากอินเตอร์เน็ตของท่านขัดข้อง อาจทำให้ไฟล์แนบของท่านไม่สามารถอัพโหลดเข้าระบบได้ ท่านต้องการไปขั้นตอนต่อไปหรือไม่?", function(result) {
                        if (result) {
                            btnchkinviteedit(true);
                            $('#wait_process').css('display', 'none');
                        } else {
                            $('#wait_process').css('display', 'none');
                        }
                    });
                } else {
                    bootbox.alert("ขออภัย เนื่องจากระบบเกิดข้อผิดพลาด กรุณาลองใหม่ภายหลัง", function() {
                        $('#wait_process').css('display', 'none');
                    });
                }

            }
        });
    }
}



function submit_case(form, form_this, ignore_file) {

    if (ignore_file == true) {
        var formData = $('#chk_invite_step3').serialize();
    } else {
        var formData = $('#chk_invite_step3').serialize();
    }
    var $submit = form.find('button[type="submit"]');
    // console.log(formData);
    $submit.attr("disabled", true);
    $.ajax({
        url: "function_php/function_index.php?method=create_invite",
        type: "POST",
        dataType: "json",
        timeout: 20000,
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function(data) {

            if (data.status_response == "00") {
                bootbox.alert('ระบบบันทึกเรื่องร้องเรียนเรียบร้อยแล้ว', function() {
                    window.location.href = "index.php?page=appeal";
                });
            } else if (data.status_response == "01") {
                bootbox.alert("บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง", function() {
                    $submit.attr("disabled", false);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);

            if (jqXHR.status == 0) {
                bootbox.confirm("ขออภัยเนื่องจากอินเตอร์เน็ตของท่านขัดข้อง อาจทำให้ไฟล์แนบของท่านไม่สามารถอัพโหลดเข้าระบบได้ ท่านต้องการไปขั้นตอนต่อไปหรือไม่?", function(result) {
                    if (result) {
                        submit_case(form, form_this, true);
                    } else {
                        $submit.attr("disabled", false);
                    }
                });
            } else {
                bootbox.alert("ขออภัย เนื่องจากระบบเกิดข้อผิดพลาด กรุณาลองใหม่ภายหลัง");
                $submit.attr("disabled", false);
            }
        }
    });
}

function submitForm(action, target) {
    // $('#wait_process').css('display', 'block');
    var form = document.getElementById('chk_invite_step3');
    $form = $('#chk_invite_step3');
    form.action = action;
    if (target == 2) {
        form.target = 'chk_invite';
        form.submit();
    } else {
        form.target = '';
        form.submit();
    }
}

// $(function(){
//   $( "#chk_invite_step3" ).submit(function( event ) {
//       var lang = $('.language_hidden').val();
//       if(lang == "2"){
//         var ArlogIn = "Confirm the petition?";
//       }else {
//         var ArlogIn = "ยืนยันบันทึกการแจ้งเรื่อง ?";
//       }
//     event.preventDefault();
//       bootbox.confirm(ArlogIn, function(result) {
//           if (result) {
//             submit_case($(this),this);
//           }
//       });
//   });
// });


function register_modal(status) {
    $('#modal_chk_register').modal('show');
    $('.status_login').val(status);
}

function login_modal() {
    $('#modal_chk_login').modal('show');
}

function open_modal_register(status) {
    $('#modal_chk_login').modal('hide');
    $('#modal_chk_register').modal('show');
    $('.status_login').val(status);
}

function sel_status_appeal() {
    $('.appeal_center').hide();
    var e = document.getElementById("sel_status_appeal");
    var strUser = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'appeal.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            chk_status: strUser,
            method: "filter_appeal"
        },
        success: function(res) {
            $('.appeal_center_filter').html(res);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function search_appeal_enter(e) {
    if (e.keyCode == 13) {
        $('.appeal_center').hide();
        var txt_search = $('.search_text').val();
        var e = document.getElementById("sel_status_appeal");
        var strUser = e.options[e.selectedIndex].value;
        $.ajax({
            url: 'appeal.php',
            type: 'POST',
            async: false,
            responseType: "json",
            data: {
                chk_status: strUser,
                txt_search: txt_search,
                method: "filter_appeal_search"
            },
            success: function(res) {
                $('.appeal_center_filter').html(res);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function search_appeal() {
    $('.appeal_center').hide();
    var txt_search = $('.search_text').val();
    var e = document.getElementById("sel_status_appeal");
    var strUser = e.options[e.selectedIndex].value;
    $.ajax({
        url: 'appeal.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            chk_status: strUser,
            txt_search: txt_search,
            method: "filter_appeal_search"
        },
        success: function(res) {
            $('.appeal_center_filter').html(res);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function search_appeal_enter_all(e) {
    if (e.keyCode == 13) {
        $('.appeal_center').hide();
        var txt_search = $('.search_text').val();
        var strUser = $('.get_status').val();
        $.ajax({
            url: 'all_appeal.php',
            type: 'POST',
            async: false,
            responseType: "json",
            data: {
                chk_status: strUser,
                txt_search: txt_search,
                method: "filter_appeal"
            },
            success: function(res) {
                $('.appeal_center_filter').html(res);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function search_appeal_all() {
    $('.appeal_center').hide();
    var txt_search = $('.search_text').val();
    var strUser = $('.get_status').val();
    $.ajax({
        url: 'all_appeal.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            chk_status: strUser,
            txt_search: txt_search,
            method: "filter_appeal"
        },
        success: function(res) {
            $('.appeal_center_filter').html(res);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function show_modal_profile() {

    $('#modal_profile').modal('show');
    $('.img_profile_edit').attr('src', $('.pathfile_profile').val());
    var image = new Image();
    image.src = $('.pathfile_profile').val();
    image.onload = function() {
            console.log('this.width');
            $('.img_profile_edit').attr('style', getPositionImage(this.width, this.height, 120));
        }
        // $('.img_profile_edit').css('background-image', 'url(' + $('.pathfile_profile').val() + ')');
}

function click_edit_img_profile() {
    $(".file_profile").click();
}

$(document).delegate(".edit_profile_modal", "click", function() {
    $(`input[name="tel_country_code"]`).val($(`#tel1`).find(`.iti__active`).attr("data-country-code"));
    $(`input[name="tel_code"]`).val($(`#tel1`).find(`.iti__active`).find('.iti__dial-code').html());
    var lang = $('.language_hidden').val();
    if (lang == "2") {
        var Companyname = "Please fill in Company name";
        var Branch = "Please fill in Branch";
        var Business = "Please fill in Business Registration Number";
        var Typebusiness = "Please choose Type of business";
        var Telephone = "Please fill in Telephone number";
        var Address = "Please fill in Address";
        var Country = "Please choose Country";
        var Postcode = "Please fill in Postcode";
        var fname = "Please fill in First name";
        var lname = "Please fill in Last names";
        var Code = "Please fill in 13-digit Population Identification Code";
        var sex = "Please choose Gender";
        var position = "Please fill in Position'";
        var Mtelephone = "Please fill in Mobile telephone number";
        var Csubmit = "Are you sure you want to make changes";
        var Occ = "Please fill in Occupation";
    } else {
        var Companyname = "กรุณากรอก ชื่อบริษัท";
        var Branch = "กรุณากรอก สาขา";
        var Business = "กรุณากรอก เลขนิติบุคคล";
        var Typebusiness = "กรุณาเลือก ประเภทธุรกิจ";
        var Telephone = "กรุณากรอก เบอร์โทรศัพท์";
        var Address = "กรุณากรอก ที่อยู่ติดต่อ";
        var Country = "กรุณาเลือก ประเทศ";
        var Postcode = "กรุณากรอก รหัสไปรษณีย์";
        var fname = "กรุณากรอก ชื่อ";
        var lname = "กรุณากรอก นามสกุล";
        var Code = "กรุณากรอก เลขบัตรประชาชนให้ครบ";
        var sex = "กรุณาเลือก เพศ";
        var position = "กรุณากรอก ตำแหน่ง'";
        var Mtelephone = "กรุณากรอก เบอร์โทรศัพท์มือถือให้ครบ";
        var Csubmit = "ยืนยันการแก้ไขข้อมูลหรือไม่";
        var Occ = "กรุณากรอก อาชีพ";
    }
    if ($('.member_type').val() == "1") {
        if ($('.member_comp_name').val() == "") {
            bootbox.alert(Companyname, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_comp_branch').val() == "") {
            bootbox.alert(Branch, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_comp_taxid').val() == "") {
            bootbox.alert(Business, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#sel_business_person_office').val() == "") {
            bootbox.alert(Typebusiness, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_comp_phone').val() == "") {
            bootbox.alert(Telephone, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_comp_address').val() == "") {
            bootbox.alert(Address, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#country_id_com').val() == "") {
            bootbox.alert(Country, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_comp_postcode').val() == "") {
            bootbox.alert(Postcode, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.name_profile').val() == "") {
            bootbox.alert(fname, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.lastname_profile').val() == "") {
            bootbox.alert(lname, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_cid').val().length != 13) {
            bootbox.alert(Code, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#sex').val() == "") {
            bootbox.alert(sex, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_position').val() == "") {
            bootbox.alert(position, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_phone').val().length != 10) {
            bootbox.alert(Mtelephone, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_address').val() == "") {
            bootbox.alert(Address, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#country_id').val() == "") {
            bootbox.alert(Country, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_postcode').val() == "") {
            bootbox.alert(Postcode, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else {
            bootbox.confirm({
                message: Csubmit,
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
                callback: function(result) {
                    if (result == true) {
                        $('#wait_process').css('display', 'block');
                        var form_data = new FormData();
                        form_data.append('file', fileTumbnail);
                        form_data.append('member_type', $(".member_type").val());
                        form_data.append('name_profile', $(".name_profile").val());
                        form_data.append('lastname_profile', $(".lastname_profile").val());
                        form_data.append('member_cid', $(".member_cid").val());
                        form_data.append('sex', $("#sex").val());
                        form_data.append('member_position', $(".member_position").val());
                        form_data.append('member_occupation', $(".member_occupation").val());
                        form_data.append('member_phone', $(".member_phone").val());
                        form_data.append('member_cellphone', $(".member_cellphone").val());
                        form_data.append('member_address', $(".member_address").val());
                        form_data.append('country_id', $("#country_id").val());
                        form_data.append('prov_id', $("#prov_id").val());
                        form_data.append('member_postcode', $(".member_postcode").val());

                        form_data.append('member_comp_name', $(".member_comp_name").val());
                        form_data.append('member_comp_branch', $(".member_comp_branch").val());
                        form_data.append('member_comp_taxid', $(".member_comp_taxid").val());
                        form_data.append('member_comp_phone', $(".member_comp_phone").val());
                        form_data.append('member_comp_fax', $(".member_comp_fax").val());
                        form_data.append('member_comp_address', $(".member_comp_address").val());
                        form_data.append('country_id_com', $("#country_id_com").val());
                        form_data.append('prov_id_com', $("#prov_id_com").val());
                        form_data.append('member_comp_postcode', $(".member_comp_postcode").val());
                        form_data.append('method', "edit_profile_modal");
                        form_data.append('tel_country_code', $(`input[name="tel_country_code"]`).val());
                        form_data.append('tel_code', $(`input[name="tel_code"]`).val());
                        $.ajax({
                            url: 'function_php/function_index.php',
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            async: false,
                            processData: false,
                            contentType: false,
                            responseType: "json",
                            data: form_data,
                            success: function(res) {
                                $("#modal_profile_form").submit();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR, textStatus, errorThrown);
                            }
                        });
                    } else {
                        $(".bootbox-confirm").on("hidden.bs.modal", function() {
                            $('body').addClass('modal-open');
                        });
                    }
                }
            });
        }

    } else {

        if ($('.name_profile').val() == "") {
            bootbox.alert(fname, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.lastname_profile').val() == "") {
            bootbox.alert(lname, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_cid').val().length != 13) {
            bootbox.alert(Code, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#sex').val() == "") {
            bootbox.alert(sex, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_occupation').val() == "") {
            bootbox.alert(Occ, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_phone').val().length != 10) {
            bootbox.alert(Mtelephone, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_address').val() == "") {
            bootbox.alert(Address, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('#country_id').val() == "") {
            bootbox.alert(Country, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else if ($('.member_postcode').val() == "") {
            bootbox.alert(Postcode, function() {
                $(".bootbox-alert").on("hidden.bs.modal", function() {
                    $('body').addClass('modal-open');
                });
            });
        } else {

            bootbox.confirm({
                message: Csubmit,
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
                callback: function(result) {
                    if (result == true) {
                        $('#wait_process').css('display', 'block');
                        var form_data = new FormData();
                        form_data.append('file', fileTumbnail);
                        form_data.append('member_type', $(".member_type").val());
                        form_data.append('name_profile', $(".name_profile").val());
                        form_data.append('lastname_profile', $(".lastname_profile").val());
                        form_data.append('member_cid', $(".member_cid").val());
                        form_data.append('sex', $("#sex").val());
                        form_data.append('member_position', $(".member_position").val());
                        form_data.append('member_occupation', $(".member_occupation").val());
                        form_data.append('member_phone', $(".member_phone").val());
                        form_data.append('member_cellphone', $(".member_cellphone").val());
                        form_data.append('member_address', $(".member_address").val());
                        form_data.append('country_id', $("#country_id").val());
                        form_data.append('prov_id', $("#prov_id").val());
                        form_data.append('member_postcode', $(".member_postcode").val());
                        form_data.append('method', "edit_profile_modal");
                        form_data.append('tel_country_code', $(`input[name="tel_country_code"]`).val());
                        form_data.append('tel_code', $(`input[name="tel_code"]`).val());
                        $.ajax({
                            url: 'function_php/function_index.php',
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            async: false,
                            processData: false,
                            contentType: false,
                            responseType: "json",
                            data: form_data,
                            success: function(res) {
                                $("#modal_profile_form").submit();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR, textStatus, errorThrown);

                            }
                        });
                    } else {
                        $(".bootbox-confirm").on("hidden.bs.modal", function() {
                            $('body').addClass('modal-open');
                        });
                    }
                }
            });
        }
    }

});

$(document).delegate(".country_id_com", "click", function() {
    var country_id_com = document.getElementById('country_id_com').selectedOptions[0].text;
    if (country_id_com != "Thailand") {
        $('.prov_id_com').hide();
        $('#prov_id_com').val('');
    } else {
        $('.prov_id_com').show();
    }
});

$(document).delegate(".country_id", "click", function() {
    var country_id = document.getElementById('country_id').selectedOptions[0].text;
    if (country_id != "Thailand") {
        $('.prov_id').hide();
        $('#prov_id').val('');
    } else {
        $('.prov_id').show();
    }
});

function show_modal_repassword() {
    $('#modal_chk_repassword').modal('show');
}

$(document).delegate(".edit_password_modal", "click", function() {
    var lang = $('.language_hidden').val();
    var password = $('.txt_password').val();
    var newpassword = $('.txt_newpassword').val();
    var newpassword_con = $('.txt_newpassword_con').val();
    if (lang == "2") {
        var passAr = "Please type corresponding password";
        var CpassAr = "Are you sure you want to make changes?";
        var Chkpass = "must contain alphanumeric A-Z, a-z, 0-9, with at least 8 digits in length";
        var sukpass = "Password has been changed";
        var flpass = "You have typed wrong original password";
    } else {
        var passAr = "กรุณากรอกข้อมูลให้ตรงกัน";
        var CpassAr = "ยืนยันการแก้ไขข้อมูลหรือไม่ ?";
        var Chkpass = "รหัสผ่านต้องมี A-Z,a-z และ 0-9 อย่างน้อย 1 ตัว และมีอย่างน้อย 8 หลัก";
        var sukpass = "เปลี่ยนรหัสผ่านเรียบร้อย";
        var flpass = "รหัสผ่านเดิมไม่ถูกต้อง";
    }
    var re = new RegExp(/^(?=.*\d)(?=.*[0-9a-zA-Z]).{8,}$/);
    if (re.test(newpassword) == true) {
        if (newpassword != newpassword_con) {
            bootbox.alert(passAr);
        } else {

            bootbox.confirm({
                message: CpassAr,
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
                callback: function(result) {
                    if (result == true) {
                        $('#wait_process').css('display', 'block');
                        $.ajax({
                            url: 'function_php/function_index.php',
                            type: 'POST',
                            async: false,
                            responseType: "json",
                            data: {
                                'password': password,
                                'newpassword': newpassword,
                                'newpassword_con': newpassword_con,
                                "method": "repassword"
                            },
                            success: function(res) {
                                if (res.pass_chk == "00") {
                                    bootbox.alert(sukpass);
                                    window.location.href = '/frontend/index.php?page=profile';
                                } else {
                                    bootbox.alert(flpass, function() {
                                        $('#wait_process').css('display', 'none');
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR, textStatus, errorThrown);

                            }
                        });
                    }
                }
            });
        }
    } else {
        bootbox.alert(Chkpass);
    }

});


function logout() {
    var lang = $('.language_hidden').val();
    if (lang == "2") {
        var Arlog = "Are you sure you want to quit?";
    } else {
        var Arlog = "ยืนยันการออกจากระบบ ?";
    }
    bootbox.confirm({
        message: Arlog,
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
        callback: function(result) {
            if (result == true) {
                window.location.href = "https://sso.ditp.go.th/auth/clientLogout?callback=https://care.ditp.go.th/frontend/logout.php";
                //window.location.href = 'logout.php';
            }
        }
    });
}


// function update_noti_bell(){
//   $.ajax({
//       url: 'function_php/function_index.php',
//       type: 'POST',
//       async: false,
//       responseType: "json",
//       data: {
//         "method":"update_noti_bell"
//       },
//     success: function(res) {
//
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//       console.log(jqXHR, textStatus, errorThrown);
//
//     }
//   });
// }

function read_mesBox(msgBox_id) {
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            'msgBox_id': msgBox_id,
            "method": "read_mesBox"
        },
        success: function(res) {
            $('#fa_circle_' + msgBox_id).remove();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
}

function update_noti_letter() {
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            "method": "update_noti_letter"
        },
        success: function(res) {

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
}

function del_msgBox(id) {
    var lang = $('.language_hidden').val();
    if (lang == "2") {
        var ArlogIn = "Will you delete the message?";
    } else {
        var ArlogIn = "คุณจะลบข้อความหรือไม่ ?";
    }
    bootbox.confirm({
        message: ArlogIn,
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
        callback: function(result) {
            if (result == true) {
                $.ajax({
                    url: 'function_php/function_index.php',
                    type: 'POST',
                    async: false,
                    responseType: "json",
                    data: {
                        'msgBox_id': id,
                        "method": "del_msgBox"
                    },
                    success: function(res) {
                        window.location.href = '/frontend/index.php?page=letter';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);

                    }
                });
            }
        }
    });
}

function del_msgnoti(id) {
    var lang = $('.language_hidden').val();
    if (lang == "2") {
        var ArlogIn = "Do you want to delete the notification?";
    } else {
        var ArlogIn = "คุณจะลบการแจ้งเตือนหรือไม่ ?";
    }
    bootbox.confirm({
        message: "คุณจะลบการแจ้งเตือนหรือไม่ ?",
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
        callback: function(result) {
            if (result == true) {
                $.ajax({
                    url: 'function_php/function_index.php',
                    type: 'POST',
                    async: false,
                    responseType: "json",
                    data: {
                        'msgNotiApp_id': id,
                        "method": "del_msgnoti"
                    },
                    success: function(res) {
                        window.location.href = '/frontend/index.php?page=bell';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);

                    }
                });
            }
        }
    });
}
$(document).delegate(".btn_forgot_password", "click", function() {

    $('#wait_process_mail').css('display', 'block');
    setTimeout(function() { set_time_mail(); }, 1000);

});

function set_time_mail() {
    var email = $('.forgot_email').val();
    var lang = $('.language_hidden').val();
    if (lang == "2") {
        var Armail = "The system will send you the password correct link to your e-mail.";
        var Armail_x = "E-mail is not in the system.";
        var Armail_z = "Your Email did not confirm your subscription.";
    } else {
        var Armail = "ระบบทำการส่งลิ้งค์แก้ไขรหัสผ่านให้ท่านทาง E-mail ของคุณเรียบร้อยแล้ว";
        var Armail_x = "E-mail ไม่มีอยู่ในระบบ";
        var Armail_z = "E-mail ของท่านไม่ได้ยืนยันการสมัครสมาชิก";
    }
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            'email': email,
            "method": "forgot_password"
        },
        success: function(res) {
            if (res.chk_mail == "00") {
                bootbox.alert(Armail, function() {
                    $('#wait_process_mail').css('display', 'none');
                    $('#modal_forgot_password').modal('hide');
                });
            } else if (res.chk_mail == "02") {
                bootbox.alert(Armail_z, function() {
                    $('#wait_process_mail').css('display', 'none');
                });
            } else {
                bootbox.alert(Armail_x, function() {
                    $('#wait_process_mail').css('display', 'none');
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
}
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function language_select(type) {
    var lang = $('.language_hidden').val();
    var lang_sess = $('.language_sess').val();
    var ck_id = $('.ck_id').val();
    if (lang_sess == "") {
        $('.language_hidden').val(type);

        var blog = getUrlParameter('page');
        if (blog == "info_detail") {
            window.location.href = '/frontend/index.php?page=' + blog + '&ck_id=' + ck_id + '&lang=' + type + '';
        } else {
            window.location.href = '/frontend/index.php?page=' + blog + '&lang=' + type + '';
        }
    } else {
        $.ajax({
            url: 'function_php/function_index.php',
            type: 'POST',
            async: false,
            responseType: "json",
            data: {
                'type': type,
                "method": "language_select"
            },
            success: function(res) {
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);

            }
        });
    }
}

function toggleMenu() {
    var menuBox = document.getElementById('menu-box');
    if (menuBox.style.display == "block") { // if is menuBox displayed, hide it
        menuBox.style.display = "none";
    } else { // if is menuBox hidden, display it
        menuBox.style.display = "block";
    }
}

function chk_div_category() {
    var lang = $('.language_hidden').val();
    $.ajax({
        url: 'function_php/function_index.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            "lang": lang,
            "method": "chk_div_category"
        },

        success: function(res) {
            $('.div_category_2').html(res);

            // setTimeout(function(){

            $('.div_category_1').hide();
            $('.div_category_2').css('display', 'inline-block');
            $('.selectpicker').selectpicker('refresh');
            // }, 1000);


        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
}