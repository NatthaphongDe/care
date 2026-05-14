function case_class() {

    //--ฟังกชั่นเปลี่ยนสีพื้นหลัง header --//
    this.gen_header_color = function() {
        var bgColor = new Array('#1b5e20', '#2e7d32', '#388e3c', '#43a047', '#4caf50', '#7cb342', '#8bc34a', '#9ccc65', '#aed581');
        var ibg = 0;
        $('.card-header').each(function() {
            if (ibg < bgColor.length) {
                $(this).css('background', bgColor[ibg]);
            } else {
                $(this).css('background', bgColor[8]);
            }
            ibg++;
        });
    }

    this.closeWindow = function() {
        window.close();
    }



}


//-- ใช้กับส่วนของ หน้า Open Case --//
function case_open_class() {

    //-- สือทอด คลาส case_class --//
    this.case_class = new case_class();


    $('.btn-collape').bind('click', function() {
        var id_elm = $(this).attr('href');
        if ($(id_elm).hasClass('in')) {
            $(this).find('i').removeClass('icon-angle-up');
            $(this).find('i').addClass('icon-angle-down');
        } else {
            $(this).find('i').removeClass('icon-angle-down');
            $(this).find('i').addClass('icon-angle-up');
        }
    });

    //--ฟังกชั่นเช็คข้อมูลผ่าน Webservice --//
    this.checkWebService = function(type, id, frmType) {
      frmSetSplit = id.split("_IdxFs_");
      var frmSet = frmSetSplit[1];
      if (type == "people") {
          var url = 'template/modal_check_people.php?frmType=' + frmType + '&frmSet=' + frmSet + '&textId=' + $(id).val();
          url = encodeURI(url);
          window.open(url);
      } else if (type == "dbd") {
          var url = 'template/modal_check_dbd.php?frmType=' + frmType + '&frmSet=' + frmSet + '&textId=' + $(id).val(); //+'&textName='+$('input[name="applntOrg_name_IdxFs_'+frmSet+'"]').val()
          url = encodeURI(url);
          window.open(url);
      } else if (type == "ditp") {
          var url = 'template/modal_check_ditp.php?frmType=' + frmType + '&frmSet=' + frmSet + '&textId=' + $(id).val(); //+'&textName='+$('input[name="applntOrg_name_IdxFs_'+frmSet+'"]').val()
          url = encodeURI(url);
          window.open(url);
      } else if (type == "backlist") {
          var url = 'template/modal_check_blacklist.php?frmSet=' + frmSet + ''; //&textId=' + $(id).val() + '&textCName='+$('input[name="complnt_name_IdxFs_'+frmSet+'"]').val() + '&textName='+$('input[name="complnt_contact_name_IdxFs_'+frmSet+'"]').val()
          url = encodeURI(url);
          window.open(url);

          // $.ajax({
          //     url: "function.php?method=check_backlist",
          //     method: "POST",
          //     data: { complnt_trade_number: $('input[name="complnt_trade_number_IdxFs_' + frmSet + '"]').val(), complnt_name: $('input[name="complnt_name_IdxFs_' + frmSet + '"]').val() },
          //     async: false,
          //     success: function(result) {
          //         //$(".btn-checkBlacklist").removeAttr("onClick");
          //         $('input[name="complnt_backlist_IdxFs_' + frmSet + '"]').val(result);
          //         $(".btn-checkBlacklist img").attr("src", "img/btn_check_backlist_" + result + ".png");
          //     }
          // });
      }
    }

    //-- ฟังก์ชั่น เปิด popup เลือกข้อมูล ก่อนเปิดเคส--//
    this.openCase = function(id_elm, id) {
        if ($("#index_page_type").val() == "setting") {
            $("#frm-modal-create-case").attr("action", "../function.php?method=createcase_init");
            $("#frm-modal-create-case .index_page_type_modal").val("setting");
        } else {
            $("#frm-modal-create-case").attr("action", "function.php?method=createcase_init");
            $("#frm-modal-create-case .index_page_type_modal").val("");
        }
        $(id_elm).modal('show');
    }

    this.removeFileAttachId = new Array();
    this.remove_file = function(id, val_rm) {
        $("#" + id).remove();
        this.removeFileAttachId.push(val_rm);
        $(".removeFileAttachId").val(this.removeFileAttachId);


    }

    this.removeFileAttachNewId = new Array();
    this.remove_file_new = function(id, val_rm) {
        $("#" + id).remove();
        this.removeFileAttachNewId.push(val_rm);
        $(".removeFileAttachNewId").val(this.removeFileAttachNewId);
    }

    //-- ฟังก์ชั่น เลือกไม่มีข้อมูลผู้ร้องเรียน--//
    this.change_nodata = function(id, frmId) {
        if ($("#" + id).prop("checked") == true) {
            $("#panel-form-a").find("input").prop('disabled', true);
            $("#panel-form-a").find("select").prop('disabled', true);
            $("#panel-form-a").find("select").parents('.selector').css('opacity', '0.65');


            $("#panel-form-a").find("textarea").prop('disabled', true);
            $("#" + id).prop('disabled', false);
            $("input[name='formSetId_a']").prop('disabled', false);
            $(".select-picker").selectpicker("refresh");

            $('#inlineCheckbox_chkType_IdxFs_' + frmId).prop('checked', true);
            $('#inlineCheckbox_chkType_IdxFs_' + frmId).parents(".form-group").addClass('checked');
            case_open.chkHasCompany('inlineCheckbox_chkType_IdxFs_' + frmId, frmId);

        } else {
            $("#panel-form-a").find("input").prop('disabled', false);
            $("#panel-form-a").find("select").prop('disabled', false);
            $("#panel-form-a").find("select").parents('.selector').css('opacity', '');

            $("#panel-form-a").find("button").prop('disabled', false);
            $("#panel-form-a").find("button").css('opacity', '');

            $("#panel-form-a").find("textarea").prop('disabled', false);
            $("#" + id).prop('disabled', false);
            $("input[name='formSetId_a']").prop('disabled', false);
            $(".select-picker").selectpicker("refresh");

        }
    }

    //-- ฟังก์ชั่น เปิด-ปิด ข้อมูล ตัวแทนบริษัท--//
    this.chkHasCompany = function(thisElm, id_elm) {
      $(".applnt_type_IdxFs_" + id_elm).prop("disabled", true);
      $(".applnt_type_IdxFs_" + id_elm).parents(".selector").addClass("disabled");

      $("#form_group_personal_" + id_elm).find('input').prop('disabled', true);

        if ($("#" + thisElm).is(':checked') == true) {
            console.log('11');
            if ($("#form_group_company_" + id_elm).css("display") == "none") {
                $("#form_group_company_" + id_elm).slideToggle();
            }
            if (($("#form_group_personal_" + id_elm).is(':visible')||false) === true) {
                $("#form_group_personal_" + id_elm).slideToggle(300);
            }

            $(".applnt_type_IdxFs_" + id_elm).eq(0).prop("disabled", false);
            $(".applnt_type_IdxFs_" + id_elm).eq(0).parents(".selector").removeClass("disabled");

            $("#form_group_company_" + id_elm).find('input, select, textarea, button').prop('disabled', false);
            $("#form_group_company_" + id_elm).find(".selector").removeClass("disabled");
            $("#form_group_company_" + id_elm).find(".selector, button").css({ "opacity": "1" });

            // $("#" + thisElm).prop('disabled', false);
            $(".select-picker").selectpicker("refresh");
        } else {
            console.log('22');
            if ($("#form_group_company_" + id_elm).css("display") != "none") {
                $("#form_group_company_" + id_elm).slideToggle();
            }
            if (($("#form_group_personal_" + id_elm).is(':visible')||false) === true) {
                $("#form_group_personal_" + id_elm).slideToggle(300);
            }

            $(".applnt_type_IdxFs_" + id_elm).prop("disabled", true);
            $(".applnt_type_IdxFs_" + id_elm).parents(".selector").addClass("disabled");

            $("#form_group_company_" + id_elm).find('input, select, textarea, button').prop('disabled', true);
            $("#form_group_company_" + id_elm).find(".selector").addClass("disabled");
            $("#form_group_company_" + id_elm).find(".selector, button").css({ "opacity": "1" });

            // $("#" + thisElm).prop('disabled', false);
            $(".select-picker").selectpicker("refresh");
        }
    }

    //-- ฟังก์ชั่น เปิด-ปิด ข้อมูล บุคคลธรรมดา--//
    this.chkHasPersonal = function(thisElm, id_elm) {
      $(".applnt_type_IdxFs_" + id_elm).prop("disabled", true);
      $(".applnt_type_IdxFs_" + id_elm).parents(".selector").addClass("disabled");
      // Reset ตัวแทนบริษัท
      $("#form_group_company_" + id_elm).find('input, select, textarea, button').prop('disabled', true);
      $("#form_group_company_" + id_elm).find(".selector").addClass("disabled");
      $("#form_group_company_" + id_elm).find(".selector, button").css({ "opacity": "1" });


      if ($("#" + thisElm).is(':checked') == true) {
        console.log('11');
        if (($("#form_group_personal_" + id_elm).is(':visible')||false) === false) {
            $("#form_group_personal_" + id_elm).slideToggle(300);
        }
        if (($("#form_group_company_" + id_elm).is(':visible')||false) === true) {
            $("#form_group_company_" + id_elm).slideToggle(300);
        }
        $(".applnt_type_IdxFs_" + id_elm).eq(1).prop("disabled", false);
        $(".applnt_type_IdxFs_" + id_elm).eq(1).parents(".selector").removeClass("disabled");
        
        $("#form_group_personal_" + id_elm).find('input').prop('disabled', false);

        // $("#" + thisElm).prop('disabled', false);
        $(".select-picker").selectpicker("refresh");

      } else {
        console.log('22');
        if (($("#form_group_personal_" + id_elm).is(':visible')||false) === true) {
            $("#form_group_personal_" + id_elm).slideToggle(300);
        }
        if (($("#form_group_company_" + id_elm).is(':visible')||false) === true) {
            $("#form_group_company_" + id_elm).slideToggle(300);
        }
        $(".applnt_type_IdxFs_" + id_elm).eq(1).prop("disabled", true);
        $(".applnt_type_IdxFs_" + id_elm).eq(1).parents(".selector").addClass("disabled");

        $("#form_group_personal_" + id_elm).find('input').prop('disabled', true);

        $("#" + thisElm).prop('disabled', false);
        $(".select-picker").selectpicker("refresh");
      }
    }

    //-- ฟังก์ชั่น เซฟข้อมูล ว่าจะต้องการตั้งเรื่อง หรือ เซฟเคส--//
    this.entSaveType = function(type) {
        $(".typeOfSave").val(type);

        if (type == 'save_case') {
            bootbox.confirm({
                size: "large",
                message: "กรุณายืนยันการบันทึกรับเรื่องร้องเรียน",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> ยกเลิก'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> บันทึก'
                    }
                },
                callback: function(result) {
                    /* result is a boolean; true = OK, false = Cancel*/
                    if (result) {
                        show_loading_feedback('show');
                        $(".frm_case_open_detail").submit();
                    }
                }
            });
        } else {

            $(".frm_case_open_detail").submit();
        }
    }


    var $request;
    this.submit_case = function(form, form_this, ignore_file) {

        show_loading_feedback("show");

        /* get some values from elements on the page: */

        // console.log(formData);

        var $submit = form.find('button[type="submit"]');
        var url = form.attr("action");
        var $request;
        /* Send the data using ajax post */
        var jqXHR_custom = []
        jqXHR_custom["status"] = 200;
        /* Disable the button. */
        $submit.attr("disabled", true);
        console.log(url);
        if (ignore_file == true) {
            var formData = form.serialize();
        } else {
            var formData = new FormData(form_this);
            // console.log(5);
        }

        // $request = $.ajax({
        //     url: url,
        //     data: formData,
        //     type: "POST",
        //     dataType: "json",
        //     async: false,
        //     // timeout: 20000,
        //     cache: false,
        //     contentType: false,
        //     processData: false,
        //     success: function(data) {

        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {

        //     }
        // });

        setTimeout(function() {

            if (ignore_file == true) {
                var formData = form.serialize();
            } else {
                var formData = new FormData(form_this);
                // console.log(5);
            }
            console.log(formData);
            $request = $.ajax({
                url: url,
                data: formData,
                type: "POST",
                dataType: "json",
                async: false,
                // timeout: 20000,
                cache: false,
                contentType: false,
                processData: false,
                // xhr: function()
                // {
                //     var xhr = new window.XMLHttpRequest();
                //     var started_at = new Date();
                //     xhr.upload.addEventListener( 'progress', function( e )
                //     {
                //         if( e.lengthComputable )
                //         {
                //             // Append progress percentage.
                //             var loaded = e.loaded;
                //             var total = e.total;
                //
                //             // Time Remaining
                //             var seconds_elapsed =   ( new Date().getTime() - started_at.getTime() )/1000;
                //             var bytes_per_second =  seconds_elapsed ? loaded / seconds_elapsed : 0 ;
                //             var Kbytes_per_second = bytes_per_second / 1000 ;
                //             var remaining_bytes =   total - loaded;
                //             var seconds_remaining = seconds_elapsed ? remaining_bytes / bytes_per_second : 'calculating' ;
                //
                //
                //             var timeout = 20;
                //             if(seconds_remaining>timeout){
                //                 jqXHR_custom["status"]=0;
                //             }
                //         }
                //     }, false );
                //     return xhr;
                // },
                success: function(data) {
                    console.log(data);
                    //console.log(jqXHR_custom);
                    //if(jqXHR_custom.status!=0){
                    if (data.status_response == "00") {
                        show_loading_feedback("hide");
                        iziToast_func.success('ระบบบันทึกเรื่องร้องเรียนเรียบร้อยแล้ว', function() {
                            window.location.href = "index.php?page=case_open_detail&caseId=" + data.last_case_id;
                        });
                    } else if (data.status_response == "01") {
                        show_loading_feedback("hide");
                        iziToast_func.alert("บันทึกเรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง");
                        /* Enable the button. */
                        $submit.attr("disabled", false);

                    } else if (data.status_response == "02") {
                        show_loading_feedback("hide");
                        if (data.status_response_text == 'กรุณากรอกข้อมูลบริษัท หรือเลือกยื่นในนามบุคคลธรรมดา') {
                            console.log('qqq');
                            $('#model_chkType_IdxFs').modal('show');
                        } else {
                            iziToast_func.alert(data.status_response_text);
                        }

                        $('[name="' + data.field_focus + '"]').focus();
                        /* Enable the button. */
                        $submit.attr("disabled", false);
                    }
                    // }else{
                    //    show_loading_feedback("hide");
                    //   iziToast_func.confirm("ขออภัยเนื่องจากอินเตอร์เน็ตของท่านขัดข้อง อาจทำให้ไฟล์แนบของท่านไม่สามารถอัพโหลดเข้าระบบได้ ท่านต้องการบันทึกเรื่องร้องเรียนหรือไม่?","บันทึก","ไม่บันทึก"
                    //   ,function(){
                    //     if ($request != null){
                    //         $request.abort();
                    //         $request = null;
                    //         console.log($request);
                    //     }
                    //     case_open.submit_case(form,form_this,true);
                    //   }
                    //   ,function(){
                    //     /* Enable the button. */
                    //     $submit.attr("disabled", false);
                    //   });
                    // }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    show_loading_feedback("hide");
                    console.log(jqXHR);
                    if (jqXHR.status == 0) {
                        iziToast_func.confirm("ขออภัยเนื่องจากอินเตอร์เน็ตของท่านขัดข้อง อาจทำให้ไฟล์แนบของท่านไม่สามารถอัพโหลดเข้าระบบได้ ท่านต้องการบันทึกเรื่องร้องเรียนหรือไม่?", "บันทึก", "ไม่บันทึก", function() {
                            case_open.submit_case(form, form_this, true);
                        }, function() {
                            /* Enable the button. */
                            $submit.attr("disabled", false);
                        });
                    } else {
                        iziToast_func.alert("ขออภัย เนื่องจากระบบเกิดข้อผิดพลาด กรุณาลองใหม่ภายหลัง");
                        /* Enable the button. */
                        $submit.attr("disabled", false);
                    }
                }
            });
        }, 500);
    }


}

//-- ใช้กับส่วนของ หน้า Case Detail --//
function case_detail_class() {

    //-- สือทอด คลาส case_class --//
    this.case_class = new case_class();

    //-- Event แสดง-ซ่อน เนื้แหากระบวนการ --//
    $(document).delegate('.btn-collape-process', 'click', function() {
        var id_elm = $(this).attr('href');
        if ($(id_elm).hasClass('in')) {
            $(this).find('.icon-collape').removeClass('icon-angle-up').addClass('icon-angle-down');
        } else {
            $(this).find('.icon-collape').removeClass('icon-angle-down').addClass('icon-angle-up');
        }
        setTimeout(function() {
            auto_resize_menu();
        }, 500);
    });




    $(document).delegate('select.select-type-process', 'change', function(event) {
        var $panelform6 = $(this).parents('.panel-form-6');
        // console.log($panelform6);
        if ($(this).val() != "") {
            //console.log($(this).val());
            if ($panelform6.find('.dnm').length == 0) {
                $panelform6.find('.title-process').append(' - <span class="dnm"></span>');
            }
            var text_title = $panelform6.find('select.select-type-process option[value="' + $(this).val() + '"]').text();
            $panelform6.find('.dnm').text(text_title);
            var deptType = $(this).find("option[value='" + $(this).val() + "']").attr("rel");
            var deptTypex = $(this).find("option[value='" + $(this).val() + "']").attr("value");

            if (deptType != "0") {
                if (deptTypex == 3 || deptTypex == 5) {
                    if (deptTypex == 3) {
                        $panelform6.find(".new-dep-1").show();
                        $panelform6.find(".new-dep-2").hide();
                    } else {
                        $panelform6.find(".new-dep-2").show();
                        $panelform6.find(".new-dep-1").hide();
                    }
                    $panelform6.find(".panel-department").hide();

                } else {
                    $panelform6.find(".new-dep-1").hide();
                    $panelform6.find(".new-dep-2").hide();

                    $panelform6.find(".panel-department").show();
                    $panelform6.find("select.process_dept_id_demo").find("option").each(function(index, el) {
                        $panelform6.find("select.process_dept_id").html($panelform6.find("select.process_dept_id_demo").html());
                    });
                    $panelform6.find("select.process_dept_id").find("option").each(function(index, el) {
                        if ($(this).attr("rel") != deptType && $(this).attr("rel") != 0) {
                            $(this).remove();
                        }
                    });
                    $panelform6.find("select.process_dept_id").find("option[value='']").prop("selected", true);
                    $('select.select-picker').selectpicker('refresh');
                    $panelform6.find('.selector').hide();

                }
            } else {
                $panelform6.find(".panel-department").hide();
            }
            $(".typeDept").hide();
        } else {
            $panelform6.find(".panel-department").hide();
            $panelform6.find(".new-dep-1").hide();
            $panelform6.find(".new-dep-2").hide();
        }
        setTimeout(function() {
            auto_resize_menu();
        }, 500);
    });



    $(document).delegate('select.process_dept_id', 'change', function(event) {
        var $panelform6 = $(this).parents('.panel-form-6');
        var dept_id = $(this).val();
        //console.log(dept_id);
        var dept_type = "";
        $.ajax({
            url: "function.php?method=get_detpartment_data",
            data: null,
            type: 'post',
            async: false,
            dataType: "json",
            success: function(data_res) {
                $.each(data_res.dept, function(index, el) {
                    if (el.dept_id == dept_id) {
                        dept_type = el.dept_type;
                        $panelform6.find("#dept_affiliation").html(el.dept_affiliation);
                        $panelform6.find("#dept_director").html(el.dept_director);
                        $panelform6.find("#dept_assistant").html(el.dept_assistant);
                        $panelform6.find("#dept_tel").html(el.dept_tel);
                        $panelform6.find("#dept_fax").html(el.dept_fax);
                        $panelform6.find("#dept_email").html(el.dept_email);
                        $panelform6.find("#dept_address").html(el.dept_address);

                    }
                });
                $(".typeDept").hide();
                $(".typeDept_" + dept_type).show();
            }
        });
        auto_resize_menu();
    });




    //-- ยืนยัน การเช็ค --//
    $('.btn-open-model-confirm').click(function() {
        $('#model_check').modal('hide');
        $('#model_comfirm_check').modal('show');
    });

    //-- เมื่อติ๊กรายการ History--//

    $(".chkRef_complnt").click(function() {


        var html_elm = '<div class="form-group col-md-12 line-top-border panel-ref">\
                  <label class="col-sm-2 control-label">Reference Case : </label>\
                  <div class="col-sm-10 col_ref_case" >\
                  </div>\
                </div>';
        if ($(this).prop("checked") == true) {
            if ($(".panel-ref").length == 0) {
                $("#collapse2.enableRef").append(html_elm);
            }
            $('.col_ref_case').append('<button class="btn ra-100 btn-primary btn-ref btn_ref_' + $(this).val() + '">Case ID ' + $(this).val() + '</button><input type="hidden" name="case_ref[]" value="' + $(this).val() + '" class="btn_ref_' + $(this).val() + '" />');
        } else {
            $('.btn_ref_' + $(this).val()).remove();
            if ($(".btn_ref").length == 0) {
                $(".panel-ref").remove();
            }
        }
    });

    //-- เมื่อติ๊ก .btn-send-email1--//
    $(document).delegate('.btn-send-email', 'click', function() {
        $this_elm = $(this);
        show_loading_feedback('show');
        //show_loading_feedback('show',null,function(){
        var subject = $this_elm.parents('.row_email_proc').find('.procPropEmail_subject').val();
        var country_id = $this_elm.parents('.row_email_proc').find('.country_id').val();
        var message = CKEDITOR.instances[$this_elm.parents('.row_email_proc').find('.procPropEmail_message').attr("id")].getData();
        var fileName = $this_elm.parents('.row_email_proc').find('.procPropEmail_file').attr("name");
        var fileId = $this_elm.parents('.row_email_proc').find('.procPropEmail_file').attr("id");
        var to_email_demo = $this_elm.parents('.row_email_proc').find('.procPropEmail_address').val();
        var to_email_arr = to_email_demo.split(",");
        var to_email_list = new Array();
        var contain_file_html = '';
        
        
        for (var i = 0; i < to_email_arr.length; i++) {
            to_email_list.push(to_email_arr[i].trim());
        }
        var to_email = JSON.stringify(to_email_list);
        var to_name = JSON.stringify(to_email_list);

        var data;
        var data_send = new FormData();
        var count_fileattach = 0;
        $.each($("#" + fileId)[0].files, function(i, file) {

            count_fileattach = count_fileattach + 1;

            data_send.append('fileattach' + i, file);
            data_send.append('fileattach_name' + i, file.name);


            contain_file_html += '<a href="javascirpt:;" onclick="window.open(\'view_file_attach.php?mailfileadrss=' + file.name + '\')" >\
            <div class="panel-body panel-body-list-file" style="padding:10px;">\
                <input type="hidden" name="procPropEmail_id[]" value="">\
                <input type="hidden" name="mailFile[]" value="' + file.name + '">\
                  <ul class="list-file col-sm-12">\
                    <li class="no-gutter">\
                        <div class="col-xs-12 col-sm-1" style="margin-top:10px;">\
                          <i class="glyph-icon icon-file-o icon-thumb-file"></i>\
                        </div>\
                        <div class="col-xs-12 col-sm-9 list_file_name" style="margin-top:10px;" >\
                          <p>' + file.name + '</p>\
                        </div>\
                        <div class="col-xs-12 col-sm-2 col-btn-file">\
                          <button type="button" class="btn btn-round btn-bg22 btn-edit-file">\
                            <i class="my-icon icon-ico-ditp-22"></i>\
                          </button>\
                        </div>\
                    </li>\
                  </ul>\
              </div>\
            </a>';
        });
        if (count_fileattach == 0) {
            contain_file_html = 'ไม่มีไฟล์แนบ';
        }
        data_send.append('count_fileattach', count_fileattach);
        data_send.append('to_email', to_email);
        data_send.append('to_name', to_name);
        data_send.append('subject', subject);
        data_send.append('message', message);
        data_send.append('country_id', country_id);
        $.ajax({
            url: "function.php?method=send_email",
            data: data_send,
            type: 'post',
            dataType: "json",
            contentType: false,
            processData: false,
            async: false,
            success: function(data_res) {
                console.log(data_res);
                data = data_res;
                if (data.status_response == "00") {} else if (data.status_response == "01") {
                    iziToast_func.alert('ขออภัย...ไม่สามารถส่งอีเมลได้');
                } else if (data.status_response == "02") {
                    iziToast_func.alert(data.status_response_text);
                }
            }
        });
        var myfunc = setInterval(function() {
            if (data.status_response == "00") {
                var type = $this_elm.attr("rel");
                $this_elm.parents('.row_email_proc').find('.procPropEmail_address').prop("readonly", true);
                $this_elm.parents('.row_email_proc').find('.procPropEmail_subject').prop("readonly", true);
                $this_elm.parents('.row_email_proc').find('.procPropEmail_message').prop("readonly", true);
                CKEDITOR.instances[$this_elm.parents('.row_email_proc').find('.procPropEmail_message').attr("id")].setReadOnly(true);
                var contain_btn_html = '<div class="col-lg-12 contain-email-btn2">\
                                      <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_' + type + '[]" value=""  />\
                                      <div class="form-group col-md-4 hidden-xs hidden-sm hidden-md"></div>\
                                      <div class="col-xs-6 col-lg-4">\
                                        <label class="control-label text-data-light text-data-size16 text-data-gray procPropEmail_date"></label>\
                                      </div>\
                                      <div class="col-xs-6 col-lg-3">\
                                        <label class="control-label text-data-light text-data-size16 text-data-gray procPropEmail_time"></label>\
                                      </div>\
                                      <div class="col-xs-12 col-md-12 col-lg-7 col-lg-offset-4">\
                                        <a href="javascript:void(0);" class="btn-add-email" rel="' + type + '">\
                                          <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
                                        </a>\
                                      </div>\
                                    </div>';
                var dateTime = new Date(data.datetime);
                var date_sent = moment(dateTime).format('MM/DD/YYYY');
                var time_sent = moment(dateTime).format('HH:mm น.');

                $this_elm.parents('.row_email_proc').find('.contain-email-file').html(contain_file_html);
                $this_elm.parents('.row_email_proc').find('.contain-email-btn1').after(contain_btn_html);
                $this_elm.parents('.row_email_proc').find('.contain-email-btn2').find(".procPropEmail_datetime").val(data.datetime);

                $this_elm.parents('.row_email_proc').find('.contain-email-btn2').find('.procPropEmail_date').html("วันที่ " + date_sent);
                $this_elm.parents('.row_email_proc').find('.contain-email-btn2').find('.procPropEmail_time').html("เวลา " + time_sent);

                $this_elm.parents('.row_email_proc').find('.contain-email-btn1').remove();

                show_loading_feedback('hide');
                iziToast_func.success('ส่งอีเมลเรียบร้อยแล้ว...กรุณากดปุ่มบันทึก');
            }
            clearInterval(myfunc);
        }, 3000);
        //});


    });

    $(document).delegate('.btn-assign-case', 'click', function() {
        show_loading_feedback('show');
        $('.frm_case_assign').submit();
    });

    //-- เมื่อติ๊ก .btn-add-email--//
    $(document).delegate('.btn-add-email', 'click', function() {
        var d = new Date();
        var datestring = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes();
        var type = $(this).attr('rel');
        var id_card = $(this).parents(".card-block").attr("id");
        id_card = id_card.split("-");
        id_card = id_card[3];
        if ($(this).parents('.groupDocument').length > 0) {
            var num_email_elm = $(this).parents(".card-block").find(".row_email_proc").length;
            var elmOutter = '.groupDocument';
            var channel_html = '<div class="col-lg-12  no-gutter">\
                            <div class="col-md-2 hidden-xs hidden-sm ">\
                              &nbsp\
                            </div>\
                            <div class="col-md-10">\
                              <hr />\
                            </div>\
                          </div>\
                          <div class="row no-gutter row_email_proc row_proc">\
                          <div class="col-lg-12">\
                            <div class="col-md-12 no-gutter">\
                              <div class="form-group col-lg-2">\
                                &nbsp\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <input type="hidden" class="form-control" name="procPropEmail_id_' + type + '[]" />\
                                <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_' + type + '[]" placeholder="email@gmail.com"  />\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-md-12 no-gutter">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_' + type + '[]"  />\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-md-12 no-gutter">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <textarea name="procPropEmail_message_' + type + '[]" rows="3" id="ckeditor_' + id_card + '_' + type + '_' + (num_email_elm + 1) + '" class="ckeditor form-control textarea-no-resize procPropEmail_message" placeholder="..."></textarea>\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-md-12 no-gutter">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>\
                              </div>\
                              <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">\
                                <input type="file" name="procPropEmail_file_' + type + '[]" id="procPropEmail_file_' + id_card + '_' + type + '_' + (num_email_elm + 1) + '" class=" form-control procPropEmail_file" multiple />\
                              </div>\
                              <div class="col-md-1 hidden-xs hidden-sm ">\
                              </div>\
                            </div>\
                            <div class="col-md-12 no-gutter contain-email-btn1">\
                              <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_' + type + '[]" value=""  />\
                              <div class="col-md-9 col-lg-8 hidden-xs hidden-sm "></div>\
                              <div class="col-md-3 ">\
                                <button type="button" class="btn btn-default btn-send-email" rel="' + type + '">\
                                  <i class="glyph-icon icon-envelope-o"></i>\
                                  Send\
                                </button>\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                          </div>\
                        </div>';
        } else {
            var elmOutter = '.card-block';
            var channel_html = '<div class="col-lg-12  no-gutter">\
                            <div class="col-md-2 hidden-xs hidden-sm ">\
                              &nbsp\
                            </div>\
                            <div class="col-md-10">\
                              <hr />\
                            </div>\
                          </div>\
                          <div class="row row_email_proc row_proc">\
                            <div class="col-lg-12">\
                              <div class="form-group col-lg-2">\
                                &nbsp\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <input type="hidden" class="form-control" name="procPropEmail_id_' + type + '[]" />\
                                <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_' + type + '[]" placeholder="email@gmail.com"  />\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-lg-12">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                                &nbsp\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_' + type + '[]"  />\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-lg-12">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>\
                              </div>\
                              <div class="form-group col-lg-7">\
                                <textarea name="procPropEmail_message_' + type + '[]" rows="3" id="ckeditor_' + id_card + '_' + type + '_' + (num_email_elm + 1) + '" class="ckeditor form-control textarea-no-resize procPropEmail_message" placeholder="..."></textarea>\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                            <div class="col-md-12">\
                              <div class="form-group col-lg-2 hidden-xs hidden-sm hidden-md">\
                              </div>\
                              <div class="form-group col-lg-2" style="margin-bottom:0;>\
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>\
                              </div>\
                              <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">\
                                <input type="file" name="procPropEmail_file_' + type + '[]" id="procPropEmail_file_' + id_card + '_' + type + '_' + (num_email_elm + 1) + '" class=" form-control procPropEmail_file" multiple />\
                              </div>\
                              <div class="col-md-1 hidden-xs hidden-sm ">\
                              </div>\
                            </div>\
                            <div class="col-lg-12 contain-email-btn1">\
                              <input type="hidden" class="form-control" name="procPropEmail_datetime_' + type + '[]" value=""  />\
                              <div class="col-md-9 col-lg-8 hidden-xs hidden-sm"></div>\
                              <div class="col-md-3">\
                                <button type="button" class="btn btn-default btn-send-email" rel="' + type + '">\
                                  <i class="glyph-icon icon-envelope-o"></i>\
                                  Send\
                                </button>\
                              </div>\
                              <div class="form-group col-md-1 hidden-xs hidden-sm  hidden-md ">\
                              </div>\
                            </div>\
                          </div>';

        }

        var count_ch = $(this).parents(elmOutter).find('.row_email_proc').length;
        $(this).parents(elmOutter).find('.row_email_proc').last().after(channel_html);

        CKEDITOR.replace($(this).parents(elmOutter).find('.row_email_proc').find('.ckeditor').last().attr('id'));

        var idx = 0;
        var processObjId = $(this).parents('.row_email_proc').find('input[name="procPropMail_id_' + type + '[]"]').val();
        $(this).parents(elmOutter).find('.row_email_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-email').addClass('btn-rm-email').removeClass('btn-add-email').attr('rel', processObjId);
                $(this).find('.icon-add-channel').remove();
            }
            idx++;
        });

        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });
        auto_resize_menu();

    });


    //-- เมื่อติ๊ก .btn-add-tel--//
    $(document).delegate('.btn-add-tel', 'click', function() {
        var type = $(this).attr('rel');
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var channel_html = '<div class="row no-gutter row_tel_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-5">\
            <input type="hidden" class="form-control" name="procPropTel_id_' + type + '[]" />\
            <input type="text" class="form-control" name="procPropTel_number_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control  bootstrap-datepicker-process" readonly name="procPropTel_date_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-tel" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        } else {
            var elmOutter = '.card-block';
            var channel_html = '<div class="row row_tel_proc row_proc">\
                          <div class="col-lg-12">\
                            <div class="form-group col-lg-2">\
                              &nbsp\
                            </div>\
                            <div class="form-group col-lg-5">\
                              <input type="hidden" class="form-control" name="procPropTel_id_' + type + '[]" />\
                              <input type="text" class="form-control" name="procPropTel_number_' + type + '[]"  />\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-calendar"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-clock-o"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-1">\
                              <a href="javascript:void(0);" class="btn-add-tel" rel="' + type + '">\
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
                              </a>\
                            </div>\
                          </div>\
                        </div>';
        }
        var count_ch = $(this).parents(elmOutter).find('.row_tel_proc').length;

        $(this).parents(elmOutter).find('.row_tel_proc').last().after(channel_html);

        var idx = 0;
        var processObjId = $(this).parents('.row_tel_proc').find('input[name="procPropTel_id_' + type + '[]"]').val();
        $(this).parents(elmOutter).find('.row_tel_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-tel').addClass('btn-rm-tel').removeClass('btn-add-tel').attr('rel', processObjId);
                $(this).find('.icon-add-channel').addClass('icon-ico-ditp-20').removeClass('icon-ico-ditp-21');
            }
            idx++;
        });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });

        auto_resize_menu();

    });

    $(document).delegate('.btn-rm-tel', 'click', function() {
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var elmOutterId = $(this).parents('.groupDocument').attr('id');
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var elmOutterId = "";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        }
        var id_process = $(this).attr('rel');
        if (id_process != undefined) {
            case_detail.remove_process_obj('Tel', elmCardBockId, id_process);
        }
        var checked = "";
        if ($(this).parents('.row_tel_proc').find('input[name="procPropTel"]').prop("checked") == true) {
            checked = "checked";
        }
        var nameOld = $(this).parents(elmOutter).find('.procPropTel').attr("name");
        if ($(this).parents(elmOutter).find('.procPropTel').prop("checked") == true) {
            checked = "checked";
        }
        $(this).parents('.row_tel_proc').remove();
        var count_ch = $(this).parents(elmOutter).find('input[name="' + nameOld + '"].').length;
        if (count_ch == 0) {
            if (elmOutter == '.groupDocument') {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropTel procProp" ' + checked + '>\
                        <label>\
                          โทรศัพท์\
                        </label>\
                      </div>';
            } else {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                        <label>\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropTel procProp" ' + checked + '>\
                          โทรศัพท์\
                        </label>\
                      </div>';
            }
            if (elmOutterId != "") {
                $("#" + elmOutterId).find('.row_tel_proc').find('.form-group').first().html(htmlGen);
            } else {
                $(elmOutter).find('.row_tel_proc').find('.form-group').first().html(htmlGen);
            }
        }
    });

    //-- เมื่อติ๊ก .btn-add-fax--//
    $(document).delegate('.btn-add-fax', 'click', function() {
        var type = $(this).attr('rel');
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var channel_html = '<div class="row no-gutter row_fax_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-5">\
            <input type="hidden" class="form-control" name="procPropFax_id_' + type + '[]" />\
            <input type="text" class="form-control" name="procPropFax_number_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control  bootstrap-datepicker-process" readonly  name="procPropFax_date_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker"   name="procPropFax_time_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-fax" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var channel_html = '<div class="row row_fax_proc row_proc">\
                          <div class="col-lg-12">\
                            <div class="form-group col-lg-2">\
                              &nbsp\
                            </div>\
                            <div class="form-group col-lg-5">\
                              <input type="hidden" class="form-control" name="procPropFax_id_' + type + '[]" />\
                              <input type="text" class="form-control" name="procPropFax_number_' + type + '[]"  />\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-calendar"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropFax_time_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-clock-o"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-1">\
                              <a href="javascript:void(0);" class="btn-add-fax" rel="' + type + '">\
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
                              </a>\
                            </div>\
                          </div>\
                        </div>';
        }
        var count_ch = $(this).parents(elmOutter).find('.row_fax_proc').length;

        $(this).parents(elmOutter).find('.row_fax_proc').last().after(channel_html);

        var idx = 0;
        $(this).parents(elmOutter).find('.row_fax_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-fax').addClass('btn-rm-fax').removeClass('btn-add-fax');
                $(this).find('.icon-add-channel').addClass('icon-ico-ditp-20').removeClass('icon-ico-ditp-21');
            }
            idx++;
        });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });

        auto_resize_menu();

    });

    $(document).delegate('.btn-rm-fax', 'click', function() {
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var elmOutterId = $(this).parents('.groupDocument').attr('id');
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var elmOutterId = "";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        }
        var id_process = $(this).attr('rel');
        if (id_process != undefined) {
            case_detail.remove_process_obj('Fax', elmCardBockId, id_process);
        }
        var checked = "";
        if ($(this).parents('.row_fax_proc').find('input[name="procPropFax"]').prop("checked") == true) {
            checked = "checked";
        }

        var nameOld = $(this).parents(elmOutter).find('.procPropFax').attr("name");
        if ($(this).parents(elmOutter).find('.procPropFax').prop("checked") == true) {
            checked = "checked";
        }
        $(this).parents('.row_fax_proc').remove();
        var count_ch = $(this).parents('.card-block').find('input[name="' + nameOld + '"]').length;
        if (count_ch == 0) {
            if (elmOutter == '.groupDocument') {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropFax procProp" ' + checked + '>\
                        <label>\
                          FAX\
                        </label>\
                      </div>';
            } else {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                        <label>\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropFax procProp" ' + checked + '>\
                          FAX\
                        </label>\
                      </div>';
            }
            if (elmOutterId != "") {
                $("#" + elmOutterId).find('.row_fax_proc').find('.form-group').first().html(htmlGen);
            } else {
                $(elmOutter).find('.row_fax_proc').find('.form-group').first().html(htmlGen);
            }
        }
        auto_resize_menu();
    });

    //-- เมื่อติ๊ก .btn-add-email1--//
    $(document).delegate('.btn-add-email1', 'click', function() {
        var type = $(this).attr('rel');
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var channel_html = '<div class="row no-gutter row_email1_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-5">\
            <input type="hidden" class="form-control" name="procPropEmail_id_' + type + '[]" />\
            <input type="text" class="form-control" name="procPropEmail_number_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control  bootstrap-datepicker-process" readonly name="procPropEmail_date_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker"  name="procPropEmail_time_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-email1" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        } else {
            var elmOutter = '.card-block';
            var channel_html = '<div class="row row_email1_proc">\
                          <div class="col-lg-12">\
                            <div class="form-group col-lg-2">\
                              &nbsp\
                            </div>\
                            <div class="form-group col-lg-5">\
                              <input type="hidden" class="form-control" name="procPropEmail_id_' + type + '[]" />\
                              <input type="text" class="form-control" name="procPropEmail_number_' + type + '[]"  />\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropEmail_date_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-calendar"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-2">\
                              <div class="input-group">\
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropEmail_time_' + type + '[]" >\
                                <span class="input-group-addon bg-black">\
                                  <i class="glyph-icon icon-clock-o"></i>\
                                </span>\
                              </div>\
                            </div>\
                            <div class="form-group col-lg-1">\
                              <a href="javascript:void(0);" class="btn-add-email1" rel="' + type + '">\
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
                              </a>\
                            </div>\
                          </div>\
                        </div>';
        }
        var count_ch = $(this).parents(elmOutter).find('.row_email1_proc').length;

        $(this).parents(elmOutter).find('.row_email1_proc').last().after(channel_html);

        var idx = 0;
        var processObjId = $(this).parents('.row_email1_proc').find('input[name="procPropTel_id_' + type + '[]"]').val();
        $(this).parents(elmOutter).find('.row_email1_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-email1').addClass('btn-rm-tel').removeClass('btn-add-email1').attr('rel', processObjId);
                $(this).find('.icon-add-channel').addClass('icon-ico-ditp-20').removeClass('icon-ico-ditp-21');
            }
            idx++;
        });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });

        auto_resize_menu();

    });

    $(document).delegate('.btn-rm-email1', 'click', function() {
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var elmOutterId = $(this).parents('.groupDocument').attr('id');
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var elmOutterId = "";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        }
        var id_process = $(this).attr('rel');
        if (id_process != undefined) {
            case_detail.remove_process_obj('Email', elmCardBockId, id_process);
        }
        var checked = "";
        if ($(this).parents('.row_email1_proc').find('input[name="procPropEmail"]').prop("checked") == true) {
            checked = "checked";
        }
        var nameOld = $(this).parents(elmOutter).find('.procPropEmail').attr("name");
        if ($(this).parents(elmOutter).find('.procPropEmail').prop("checked") == true) {
            checked = "checked";
        }
        $(this).parents('.row_email1_proc').remove();
        var count_ch = $(this).parents(elmOutter).find('input[name="' + nameOld + '"].').length;
        if (count_ch == 0) {
            if (elmOutter == '.groupDocument') {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropEmail procProp" ' + checked + '>\
                        <label>\
                          Email\
                        </label>\
                      </div>';
            } else {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                        <label>\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropEmail procProp" ' + checked + '>\
                          Email\
                        </label>\
                      </div>';
            }
            if (elmOutterId != "") {
                $("#" + elmOutterId).find('.row_email1_proc').find('.form-group').first().html(htmlGen);
            } else {
                $(elmOutter).find('.row_email1_proc').find('.form-group').first().html(htmlGen);
            }
        }

        auto_resize_menu();

    });

    //-- เมื่อติ๊ก .btn-add-tracking--//
    $(document).delegate('.btn-add-tracking', 'click', function() {
        var type = $(this).attr('rel');
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var channel_html = '<div class="row no-gutter row_tracking_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-2">\
            <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>\
          </div>\
          <div class="form-group col-lg-3">\
            <input type="hidden" class="form-control" name="procPropMail_id_' + type + '[]" />\
            <input type="hidden" name="procPropMail_type' + type + '[]" value="' + type + '" />\
            <input type="text" class="form-control" name="procPropMail_tracking_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control  bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_' + type + '[]"  >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_tracking_' + type + '[]"  >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-tracking" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var channel_html = '<div class="row row_tracking_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2" style="margin-bottom:0px;">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-2" style="margin-bottom:0px;">\
            <label class="control-label text-data-light text-data-size16 text-data-gray">เลขที่เอกสารออก</label>\
          </div>\
          <div class="form-group col-lg-3" style="margin-bottom:0px;">\
            <input type="hidden" class="form-control" name="procPropMail_id_' + type + '[]"  />\
            <input type="text" class="form-control" name="procPropMail_number_' + type + '[]"  />\
            <input type="hidden" name="procPropMail_type_' + type + '[]" value="2" />\
          </div>\
          <div class="form-group col-lg-4" style="margin-bottom:0px;">\
            <div class="fileinput fileinput-new input-group" data-provides="fileinput">\
                <div class="form-control" data-trigger="fileinput">\
                    <i class="glyphicon glyphicon-file fileinput-exists"></i>\
                    <span class="fileinput-filename"></span>\
                </div>\
                <span class="input-group-addon btn btn-default btn-file">\
                  <span class="fileinput-new">Browse</span>\
                  <span class="fileinput-exists">Change</span>\
                  <input type="file" class="procPropMail_file" name="procPropMail_file_' + type + '[]">\
                </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1" style="margin-bottom:0px;">\
          </div>\
          <div class="row">\
            <div class="col-lg-12">\
              <div class="form-group col-lg-2">\
              </div>\
              <div class="form-group col-lg-2">\
                <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>\
              </div>\
              <div class="form-group col-lg-3">\
                <input type="text" class="form-control" name="procPropMail_tracking_' + type + '[]"  />\
              </div>\
              <div class="form-group col-lg-2">\
                <div class="input-group">\
                <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_' + type + '[]" >\
                  <span class="input-group-addon bg-black">\
                    <i class="glyph-icon icon-calendar"></i>\
                  </span>\
                </div>\
              </div>\
              <div class="form-group col-lg-2">\
                <div class="input-group">\
                <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_' + type + '[]" >\
                  <span class="input-group-addon bg-black">\
                    <i class="glyph-icon icon-clock-o"></i>\
                  </span>\
                </div>\
              </div>\
              <div class="form-group col-lg-1">\
                <a href="javascritp:void(0);" class="btn-add-tracking" rel="' + type + '">\
                  <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
                </a>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>';
        }
        var count_ch = $(this).parents(elmOutter).find('.row_tracking_proc').length;

        $(this).parents(elmOutter).find('.row_tracking_proc').last().after(channel_html);

        var idx = 0;
        $(this).parents(elmOutter).find('.row_tracking_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-tracking').addClass('btn-rm-tracking').removeClass('btn-add-tracking');
                $(this).find('.icon-add-channel').addClass('icon-ico-ditp-20').removeClass('icon-ico-ditp-21');
            }
            idx++;
        });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });

        auto_resize_menu();

    });

    $(document).delegate('.btn-rm-tracking', 'click', function() {
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var elmOutterId = $(this).parents('.groupDocument').attr('id');
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var elmOutterId = "";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        }
        var id_process = $(this).attr('rel');
        if (id_process != undefined) {
            case_detail.remove_process_obj('Mail', elmCardBockId, id_process);
        }
        var checked = "";
        if ($(this).parents('.row_tracking_proc').find('input[name="procPropMail"]').prop("checked") == true) {
            checked = "checked";
        }

        var nameOld = $(this).parents(elmOutter).find('.procPropMail').attr("name");
        if ($(this).parents(elmOutter).find('.procPropMail').prop("checked") == true) {
            checked = "checked";
        }
        $(this).parents('.row_tracking_proc').remove();
        var count_ch = $(this).parents('.card-block').find('input[name="' + nameOld + '"]').length;

        if (count_ch == 0) {
            if (elmOutter == '.groupDocument') {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropMail procProp" ' + checked + '>\
                        <label>\
                          จดหมาย\
                        </label>\
                      </div>';
            } else {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                        <label>\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropMail procProp" ' + checked + '>\
                          จดหมาย\
                        </label>\
                      </div>';
            }
            if (elmOutterId != "") {
                $("#" + elmOutterId).find('.row_tracking_proc').find('.form-group').first().html(htmlGen);
            } else {
                $(elmOutter).find('.row_tracking_proc').find('.form-group').first().html(htmlGen);
            }
        }
        auto_resize_menu();
    });

    //-- เมื่อติ๊ก .btn-add-offcletter--//
    $(document).delegate('.btn-add-offcletter', 'click', function() {
        var type = $(this).attr('rel');
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var channel_html = '<div class="row no-gutter row_offcletter_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-5">\
            <input type="hidden" class="form-control" name="procPropOffcLetter_id_' + type + '[]" />\
            <input type="text" class="form-control" name="procPropOffcLetter_number_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-offcletter" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var channel_html = '<div class="row no-gutter row_offcletter_proc row_proc">\
        <div class="col-lg-12">\
          <div class="form-group col-lg-2">\
            &nbsp\
          </div>\
          <div class="form-group col-lg-5">\
            <input type="hidden" class="form-control" name="procPropOffcLetter_id_' + type + '[]" />\
            <input type="text" class="form-control" name="procPropOffcLetter_number_' + type + '[]"  />\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-calendar"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-2">\
            <div class="input-group">\
            <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_' + type + '[]" >\
              <span class="input-group-addon bg-black">\
                <i class="glyph-icon icon-clock-o"></i>\
              </span>\
            </div>\
          </div>\
          <div class="form-group col-lg-1">\
            <a href="javascript:void(0)" class="btn-add-offcletter" rel="' + type + '">\
              <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>\
            </a>\
          </div>\
        </div>\
      </div>';
        }
        var count_ch = $(this).parents(elmOutter).find('.row_offcletter_proc').length;

        $(this).parents(elmOutter).find('.row_offcletter_proc').last().after(channel_html);

        var idx = 0;
        $(this).parents(elmOutter).find('.row_offcletter_proc').each(function() {
            if (idx < count_ch) {
                $(this).find('.btn-add-offcletter').addClass('btn-rm-offcletter').removeClass('btn-add-offcletter');
                $(this).find('.icon-add-channel').addClass('icon-ico-ditp-20').removeClass('icon-ico-ditp-21');
            }
            idx++;
        });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker({ format: 'dd/mm/yyyy', autoclose: true, startDate: new Date() });
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').datepicker("setDate", new Date());
        var d = new Date();
        var h = d.getHours();
        h = ('00' + h).slice(-2);
        var i = d.getMinutes();
        i = ('00' + i).slice(-2);
        $(this).parents(elmOutter).find('.bootstrap-datepicker-process').val(h + ":" + i + ":00");
        $(this).parents(elmOutter).find('.bootstrap-timepicker').datetimepicker({ format: 'LT' });
        // $(this).parents(elmOutter).find('.bootstrap-timepicker').timepicker({
        //   'step': 15,
        //   'timeFormat': 'H:i',
        //   'forceRoundTime': true
        // });
        auto_resize_menu();

    });

    $(document).delegate('.btn-rm-offcletter', 'click', function() {
        if ($(this).parents('.groupDocument').length > 0) {
            var elmOutter = '.groupDocument';
            var elmOutterId = $(this).parents('.groupDocument').attr('id');
            var checkbox_padleft_20 = "checkbox-padleft-20";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        } else {
            var elmOutter = '.card-block';
            var checkbox_padleft_20 = "";
            var elmOutterId = "";
            var elmCardBockId = $(this).parents('.card-block').attr('id');
        }
        var id_process = $(this).attr('rel');
        if (id_process != undefined) {
            case_detail.remove_process_obj('Offcletter', elmCardBockId, id_process);
        }

        var checked = "";
        if ($(this).parents('.row_offcletter_proc').find('input[name="procPropOffcLetter"]').prop("checked") == true) {
            checked = "checked";
        }

        var nameOld = $(this).parents(elmOutter).find('.procPropOffcLetter').attr("name");
        if ($(this).parents(elmOutter).find('.procPropOffcLetter').prop("checked") == true) {
            checked = "checked";
        }
        $(this).parents('.row_offcletter_proc').remove();
        var count_ch = $(this).parents('.card-block').find('input[name="' + nameOld + '"]').length;
        if (count_ch == 0) {
            if (elmOutter == '.groupDocument') {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropOffcLetter procProp" ' + checked + '>\
                        <label>\
                          หนังสือราชการ\
                        </label>\
                      </div>';
            } else {
                var htmlGen = '<div class="checkbox ' + checkbox_padleft_20 + '">\
                        <label>\
                          <input type="checkbox" value="1" name="' + nameOld + '" class="procPropOffcLetter procProp" ' + checked + '>\
                          หนังสือราชการ\
                        </label>\
                      </div>';
            }
            if (elmOutterId != "") {
                $("#" + elmOutterId).find('.row_offcletter_proc').find('.form-group').first().html(htmlGen);
            } else {
                $(elmOutter).find('.row_offcletter_proc').find('.form-group').first().html(htmlGen);
            }
        }
        auto_resize_menu();
    });


    //ลบ Process แจ้งแบบต่างๆ
    this.arr_rm = new Array();
    this.remove_process_obj = function(type, elmCardBockId, val_rm) {
        this.arr_rm[type] = new Array();
        this.arr_rm[type][elmCardBockId] = new Array();
        var val_rm_old = $("#" + elmCardBockId + " .removeProcess" + type + "Id").val();
        var val_rm_old_split = val_rm_old.split(",");

        for (var i = 0; i < val_rm_old_split.length; i++) {
            if (val_rm_old_split[i]) {
                this.arr_rm[type][elmCardBockId].push(val_rm_old_split[i]);
            }
        }
        if (val_rm != undefined && this.arr_rm[type][elmCardBockId].indexOf(val_rm) == -1) {
            this.arr_rm[type][elmCardBockId].push(val_rm);
            $("#" + elmCardBockId + " .removeProcess" + type + "Id").val(this.arr_rm[type][elmCardBockId]);
        }

    }
    $(document).delegate('.card-block input.form-control', 'keyup', function(event) {
        $(this).parents('.row_proc').find(".procProp").prop("checked", true);
    });

    //-- เมื่อคลิ๊กบันทึกกระบวนการ--//
    $(document).delegate('.btn-save-process-list', 'click', function(event) {
        $this = $(this);
        bootbox.confirm({
            size: "large",
            message: "ท่านต้องการบันทึกกระบวนการหรือไม่?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> บันทึก'
                }
            },
            callback: function(result) {
                /* result is a boolean; true = OK, false = Cancel*/
                if (result) {
                    $this.parents('form').attr("action", "function.php?method=save_process");
                    show_loading_feedback('show');
                    $this.parents('form').submit();
                }
            }
        })
    });

    $(document).delegate('.btn-cancle-process-list', 'click', function(event) {
        $(this).parents(".panel-process").remove();
        var i = 1;
        $(".panel-process").each(function() {
            var num_dmn = $(this).find(".title-process").find(".dnm").length;
            if (num_dmn > 0) {
                var dnm = $(this).find(".title-process").find(".dnm").html();
            } else {
                var dnm = "";
            }
            $(this).find(".title-process").attr("rel", "กระบวนการที่ " + i);
            $(this).find(".title-process").html("กระบวนการที่ " + i + " " + dnm);
            i++;
        });
    });


    $(document).delegate('.btn-edit-file-process', 'click', function(event) {
        $(this).parents(".form-group").hide();
        $(this).parents(".card-block").find(".form-group-file").find("a").hide();
        $(this).parents(".card-block").find(".form-group-file").attr("class", "form-group form-group-file col-xs-11 " + $(this).parents(".card-block").find(".fileinput-new").attr("rel"));
        $(this).parents(".card-block").find(".fileinput-new").show();
        $(this).parents(".card-block").find(".form-group-file-btn").remove();
    });

    //-- ฟังก์ชั่น เปิด popup history--//
    this.openHistory = function(type, id) {
        if (type == "applnt") {
            $('#model_history_applnt').modal('show');
        } else if (type == "applnt_org") {
            $('#model_history_applnt_org').modal('show');
        } else if (type == "complnt") {
            $('#model_history_complnt').modal('show');
        }
    }

    //-- ฟังก์ชั่น เปิด popup Assign--//
    this.openAssign = function(id_elm, id) {
        $(id_elm).modal('show');
    }

    //ส่วนแนบเอกสารรับเรื่อง
    $(document).delegate(".procPropMail_file", "change", function(event) {
        var old_file_name = $(this).val();
        old_file_name = old_file_name.replace("C:\\fakepath\\", "")
        $(this).parents(".fileinput").find(".fileinput-filename").text(old_file_name);
    });



    this.add_emp_assign = function(emp_id, callback) {
        $.ajax({
            url: "function.php?method=emp_get_detail",
            data: { "emp_id": emp_id },
            type: 'post',
            dataType: "json",
            async: false,
            success: function(data) {
                if ($('.panel-emp-' + data.emp_real_id).length == 0) {
                    var num = $('.panel-emp-assign-list').length + 1;
                    var html_emp_list = '<div class="panel-body panel-body-outer-bg2 panel-emp-assign  panel-emp-assign-list panel-emp-' + data.emp_real_id + '" style="padding:10px;">\
                                <div class="col-xs-12 no-gutter" style="padding:0;">\
                                  <label class="col-xs-12 text-data-size16">ผู้รับผิดชอบ (' + num + ')</label>\
                                </div>\
                                <input type="hidden" name="emp_id_assign[]" value="' + data.emp_id + '" />\
                                <div class="col-xs-12 panel-body-bg2 no-gutter">\
                                  <button type="button" class="close close-emp-assign" onclick="case_detail.remove_assign(\'panel-emp-' + data.emp_real_id + '\',\'' + data.emp_id + '\')">\
                                      <i class="ditp-icon icon-ico-ditp-20"></i>\
                                  </button>\
                                  <ul class="chat-box">\
                                    <li class="no-gutter col-xs-11">\
                                      <div class="col-xs-2">\
                                        <div class="status-badge img-circle">\
                                          <img src="' + data.emp_img_path_assign + '" alt="' + data.emp_img_path_assign + '" style="' + getPositionImage(data.emp_img_path_assign, 50) + '">\
                                        </div>\
                                      </div>\
                                      <div class="col-xs-10">\
                                        <p class="col-xs-12 p-emp">\
                                          ID : ' + data.emp_real_id + '\
                                        </p>\
                                        <p class="col-xs-12 p-emp-name">\
                                          ' + data.emp_firstname + ' ' + data.emp_lastname + '\
                                        </p>\
                                        <p class="col-xs-6 p-emp">\
                                          <i class="glyph-icon icon-phone"></i> ' + data.emp_tel + '\
                                        </p>\
                                        <p class="col-xs-6 p-emp">\
                                          <i class="glyph-icon icon-envelope-o"></i> ' + data.emp_email + '\
                                        </p>\
                                      </div>\
                                    </li>\
                                  </ul>\
                                </div>\
                              </div>';
                    console.log(html_emp_list);
                    $('#add-emp-assign').append(html_emp_list);

                }

                callback();
            }
        });
    }

    this.check_before_assign = function(id_elm, id) {
        $.ajax({
            url: "function.php?method=chk_assign",
            data: { "case_id": id },
            type: 'post',
            success: function(data) {
                if (data == "00") {
                    case_detail.openAssign(id_elm);
                } else if (data == "01") {
                    iziToast_func.alert('ขออภัย...ไม่สามารถ Assign ได้ เนื่องจากยังไม่ถึงกระบวนการที่สามารถ Assign ได้ \r\nกรุณาบันทึก และปิดกระบวนการให้ครบถ้วน');
                } else if (data == "02") {
                    iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ Assign เนื่องจากระดับผู้จัดการเท่านั่นที่มีสิทธิ์ Assign');
                } else if (data == "03") {
                    case_detail.openAssign(id_elm);
                    // iziToast_func.alert('ขออภัย...ไม่สามารถ Assign ได้ เนื่องจากข้อร้องเรียนถูกยุติแล้ว');
                }
            }
        });

    }

    this.removeAssignId = new Array();
    this.remove_assign = function(id, val_rm) {
        $("." + id).remove();
        this.removeAssignId.push(val_rm);
        $(".removeAssignId").val(this.removeAssignId);
    }

}

//-- ใช้กับส่วนของ หน้า Case Close --//
function case_close_class() {

    //-- สือทอด คลาส case_class --//
    this.case_class = new case_class();

    //-- ฟังก์ชั่น เปิด popup close case--//
    this.openCloseCase = function(id_elm, id, case_id) {
        $.ajax({
            url: "function.php?method=chk_close_process",
            data: { "case_id": case_id },
            type: 'post',
            success: function(data) {
                if (data == "00") {
                    $(id_elm).modal('show');
                } else if (data == "01") {
                    iziToast_func.alert('ขออภัย...กรุณาปิดกระบวนการทั้งหมด ก่อนยุติข้อร้องเรียน !');
                }
            }
        });
    }

    //-- ฟังก์ชั่น เปิด popup dis KPI--//
    this.openDiscreditCase = function(id_elm, id, type) {
        if (type == "window_parent") {
            $(id_elm, window.parent.document).modal("show");
        } else {
            $(id_elm).modal('show');
        }
    }

    //-- ฟังก์ชั่น Re-Open--//
    this.reOpenCase = function(case_ref_id) {
        bootbox.confirm({
            size: "large",
            message: "ท่านต้องการ Re-Open เรื่องร้องเรียนหรือไม่?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ตกลง'
                }
            },
            callback: function(result) {
                /* result is a boolean; true = OK, false = Cancel*/
                if (result) {
                    window.location.href = "index.php?page=case_open&method=re_open_case&caseRefId=" + case_ref_id;
                } else {
                    event.preventDefault();
                }
            }
        })

    }

    //-- ฟังก์ชั่น ส่งไปยังองค์ความรู้เรื่องร้องเรียน--//
    this.openKnowledgeCase = function(case_id) {
        $this = $(this);
        bootbox.confirm({
            size: "large",
            message: "ท่านต้องการส่งไปยังองค์ความรู้เรื่องร้องเรียน?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> บันทึก'
                }
            },
            callback: function(result) {
                /* result is a boolean; true = OK, false = Cancel*/
                if (result) {
                    show_loading_feedback('show');
                    $.ajax({
                        url: "function.php?method=save_to_knowledge",
                        data: { "case_id": case_id },
                        type: 'post',
                        dataType: "json",
                        async: false,
                        success: function(data) {
                            show_loading_feedback('hide');
                            if (data.status_response == "00") {
                                iziToast_func.success('ระบบส่งไปยังองค์ความรู้เรื่องร้องเรียนเรียบร้อยแล้ว');
                                window.parent.location.href = "index.php?page=case_detail&caseId=" + data.case_id;
                            } else if (data.status_response == "01") {
                                iziToast_func.alert('ระบบส่งไปยังองค์ความรู้เรื่องร้องเรียนเกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                            } else if (data.status_response == "02") {
                                iziToast_func.alert(data.status_response_text);
                            } else if (data.status_response == "03") {
                                iziToast_func.alert('ขออภัย...ท่านไม่มีสิทธิ์ใช้งานส่วนนี้');
                            }
                        }
                    });
                } else {}
            }
        })
    }

}

//-- ใช้กับส่วนของ หน้า Case List --//
function case_list_class() {

    this.case_class = new case_class();

}

function alert_box(message, type) {
    if (type == "window_parent") {
        $("#modal_alert .modal-message", window.parent.document).text(message);
        $("#modal_alert", window.parent.document).modal({ // wire up the actual modal functionality and show the dialog
            "backdrop": "static",
            "keyboard": true,
            "show": true // ensure the modal is shown immediately
        });
        $("#modal_alert", window.parent.document).modal("show");

        $("#modal_alert", window.parent.document).on("show", function() { // wire up the OK button to dismiss the modal when shown
            $("#modal_alert a.btn").on("click", function(e) {
                $("#modal_alert").modal('hide'); // dismiss the dialog
            });
        });
        $("#modal_alert", window.parent.document).on("hide", function() { // remove the event listeners when the dialog is dismissed
            $("#modal_alert a.btn").off("click");
        });

        $("#modal_alert", window.parent.document).on("hidden", function() { // remove the actual elements from the DOM when fully hidden
            //$("#modal_alert").remove();
        });
    } else {
        $("#modal_alert .modal-message").text(message);
        $("#modal_alert").modal({ // wire up the actual modal functionality and show the dialog
            "backdrop": "static",
            "keyboard": true,
            "show": true // ensure the modal is shown immediately
        });

        $("#modal_alert").on("show", function() { // wire up the OK button to dismiss the modal when shown
            $("#modal_alert a.btn").on("click", function(e) {
                $("#modal_alert").modal('hide'); // dismiss the dialog
            });
        });
        $("#modal_alert").on("hide", function() { // remove the event listeners when the dialog is dismissed
            $("#modal_alert a.btn").off("click");
        });

        $("#modal_alert").on("hidden", function() { // remove the actual elements from the DOM when fully hidden
            //$("#modal_alert").remove();
        });
    }
}

function show_loading_feedback(type, window_parent, callback) {
    if (type == "show") {
        if (window_parent == "window_parent") {
            $('#loading_feedback', window.parent.document).fadeIn(400, "linear");
        } else {
            $('#loading_feedback').fadeIn(400, "linear");
        }
    } else if (type == "hide") {
        if (window_parent == "window_parent") {
            $('#loading_feedback', window.parent.document).fadeOut(400, "linear");
        } else {
            $('#loading_feedback').fadeOut(400, "linear");
        }
    }
    if (typeof callback == "function") {
        callback();
    }
}

function closeOvlBootobox(window_parent) {
    if (window_parent == "window_parent") {
        $(".bootbox", window.parent.document).on("hidden.bs.modal", function() {
            $('body', window.parent.document).addClass('modal-open');
        });
    } else {
        $(".bootbox").on("hidden.bs.modal", function() {
            $('body').addClass('modal-open');
        });
    }
}

function modal_transfer() {
    $('#modal_chk_transfer').modal('show');
}

function saveTransfer_Log(case_id, office_id) {
    console.log(office_id);
    $('.modal-backdrop.in').show();
    bootbox.confirm({
        message: "ต้องการเปลี่ยนสำนัก หรือไม่ ?",
        buttons: {
            confirm: {
                label: 'ยืนยัน',
                className: 'btn-success'
            },
            cancel: {
                label: 'ยกเลิก',
                className: 'btn-danger'
            }
        },
        callback: function(result) {
            if (result == true) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    async: false,
                    responseType: "json",
                    data: {
                        "case_id": case_id,
                        "office": $('select[name="office_type"]').val(),
                        "transfer_detail": $('textarea[name="note_detail"]').val(),
                        "method": "saveTransfer_Log"
                    },

                    success: function(res) {
                        if (res.check_error == '03') {
                            iziToast_func.success('ระบบได้โอนเรื่องร้องเรียนไปยังสำนักที่ท่านต้องการเรียบร้อยแล้ว', function() {
                                // if(office_id!=0){
                                //   window.location.href = '?page=case_list';
                                // }else{
                                window.location.reload();
                                // }
                            });
                        } else if (res.check_error == '00') {
                            iziToast_func.alert('ขออภัย...ไม่พบเรื่องร้องเรียนนี้อยู่ในระบบ', function() {
                                $('.modal-backdrop.in').hide();
                            });
                        } else if (res.check_error == '01') {
                            iziToast_func.alert('ขออภัย...กรุณาเลือกสำนักที่ท่านต้องการโอนให้', function() {
                                $('.modal-backdrop.in').hide();
                            });
                        } else if (res.check_error == '02') {
                            iziToast_func.alert('ขออภัย...กรุณาระบุรายละเอียดการโอนเรื่องร้องเรียน', function() {
                                $('.modal-backdrop.in').hide();
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);

                    }
                });
            } else {
                // console.log(2222);
                // $('.modal-backdrop.in').hide();
                setTimeout(function() { $('body').addClass('modal-open'); }, 500);

            }
        }
    });
}

function set_officeType(selectObject) {
    var value_prod = selectObject.value;
    var rel = $(".select-product-type option:selected").attr("rel");

    //if(value_prod != "0"){
    $.ajax({
        url: 'function.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            "value_prod": value_prod,
            "method": "set_officeType"
        },

        success: function(res) {
            // if(rel == '0'){
            //   $('.office_type_elm').show();
            // }else {
            //   $('.office_type_elm').hide();
            // }
            $('.office_type select').val(res.chkType);
            $(".select-picker").selectpicker("refresh");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
    //}
    // else {
    //   $('.office_type_elm').hide();
    //   $('.office_type_elm_other').hide();
    // }
}

function set_officeType_ofReport(selectObject) {
    var value_prod = selectObject.value;

    $.ajax({
        url: 'function.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
            "value_prod": value_prod,
            "method": "set_officeType"
        },

        success: function(res) {
            $('.office_type_elm select').val(res.chkType);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
    $(".selectpicker").selectpicker("refresh");

}

function set_prodType_ofReport(selectObject) {
    var value_office = selectObject.value;
    $.ajax({
        url: 'function.php',
        type: 'POST',
        async: false,
        data: {
            "value_office": value_office,
            "method": "set_prodType"
        },

        success: function(res) {
            $('.elm_prodType').html(res);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);

        }
    });
    $(".selectpicker").selectpicker("refresh");

}