

<div class="row info_div_row">
  <div class="col-md-12">
    <span class="icon_hr_info"><img src="images/all_icon_DITP/icon_8.svg" style="width:30px;" class="icon_info"></span>
    <span class="txt_hr_info"><?=$txt_UserManual?></span>

    <div class="info_center">
      <div class="panel panel-default appeal_panel">
        <div class="panel-body  download_outter_area">
            <div class="row">
              <div class="col-xs-12">
                <span><?php echo $txt_UserManual_download_des ?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <a href="file_ditp/ditp_web_frontend_2018.pdf" download>
                  <i class="fa fa-download ico_download" aria-hidden="true">
                    <span>Download</span>
                  </i>
                </a>
              </div>
            </div>
        </div>
      </div>
    </div>

    </div>
  </div>
  <input type="hidden" class="start_numpage" value="0">
  <input type="hidden" class="end_numpage" value="5">
</div>

<script>
  function search_info(start,end,page,id){
    if(id == "1"){
      currentPage = page;
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }else {
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }
    var search_text = $('.search_text').val();
    var lang = $('.language_hidden').val();
    var el = document.getElementById("sel_hr_info");
    var strUserl = el.options[el.selectedIndex].value;
    var strUserl_ex = strUserl.split(',');
    var ex = document.getElementById("sel_cat_info");
    var type_val = ex.options[ex.selectedIndex].value;
    if(strUserl_ex[1] == "2"){
      var e = document.getElementById("sel_Incorrect_info");
      var strUser = e.options[e.selectedIndex].value;
    }else {
      if(type_val == "2"){
        var e = document.getElementById("sel_Incorrect_info");
        var strUser = e.options[e.selectedIndex].value;
      }else {
        var e = document.getElementById("sel_category_info_ex");
        var strUser = e.options[e.selectedIndex].value;
      }

    }
    if(strUserl_ex[1] == "2"){
      $('#sel_cat_info option[value="2"]').attr("selected",true);
      $('#sel_cat_info option[value="1"]').attr("selected",false);
      $('#sel_cat_info option[value="1"]').attr("disabled",true);
      $('#sel_cat_info option[value="2"]').attr("disabled",false);
      $('.col-category-1').hide();
      $('.col-category-2').show();
      $('.div_category_3').css('display','inline-block');
      $('.selectpicker').selectpicker('refresh');
    }else if(strUserl_ex[1] == "1"){
      $('#sel_cat_info option[value="1"]').attr("selected",true);
      $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('#sel_cat_info option[value="2"]').attr("disabled",true);
      $('#sel_cat_info option[value="1"]').attr("disabled",false);
      $('.col-category-1').show();
      $('.col-category-2').hide();
      $('.div_category_3').css('display','none');
      $('.selectpicker').selectpicker('refresh');
    }else {
      // $('#sel_cat_info option[value="1"]').attr("selected",true);
      // $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('#sel_cat_info option[value="2"]').attr("disabled",false);
      $('#sel_cat_info option[value="1"]').attr("disabled",false);
      // $('.col-category-1').show();
      // $('.col-category-2').hide();
      // $('.div_category_3').css('display','none');
      $('.selectpicker').selectpicker('refresh');
    }

      // var type_val = $('#sel_cat_info').val();

      console.log(strUserl_ex[1]);
    $.ajax({
        url: 'info.php',
        type: 'POST',
        async: false,
        responseType: "json",
        data: {
          'search_text':search_text,
          'sel_hr_info':strUserl_ex[0],
          'sel_category_info':strUser,
          'start_page':start,
          'end_page':end,
          'currentPage':currentPage,
          'numpage':numpage,
          'lang':lang,
          'page':page,
          'type':strUserl_ex[1],
          'type_val':type_val,
          "method":"search_info"
        },
      success: function(res) {
        $('.info_search').html(res);
        $('.info_center').hide();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);

      }
    });
  }

  function search_info_enter(e,start,end,page,id){
    if(id == "1"){
      currentPage = page;
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }else {
      $('.start_numpage').val(start);
      $('.end_numpage').val(end);
    }
    var lang = $('.language_hidden').val();
    var search_text = $('.search_text').val();
    var el = document.getElementById("sel_hr_info");
    var strUserl = el.options[el.selectedIndex].value;
    var strUserl_ex = strUserl.split(',');

    var ex = document.getElementById("sel_cat_info");
    var type_val = ex.options[ex.selectedIndex].value;
    // var type_val = $('#sel_cat_info').val();
    if(strUserl_ex[1] == "2"){
      var elx = document.getElementById("sel_Incorrect_info");
      var strUser = elx.options[elx.selectedIndex].value;
    }else {
      if(type_val == "2"){
        var elx = document.getElementById("sel_Incorrect_info");
        var strUser = elx.options[elx.selectedIndex].value;
      }else {
        var elx = document.getElementById("sel_category_info_ex");
        var strUser = elx.options[elx.selectedIndex].value;
      }

    }

    if(e.keyCode == 13){
      $.ajax({
          url: 'info.php',
          type: 'POST',
          async: false,
          responseType: "json",
          data: {
            'search_text':search_text,
            'sel_hr_info':strUserl_ex[0],
            'sel_category_info':strUser,
            'start_page':start,
            'end_page':end,
            'currentPage':currentPage,
            'numpage':numpage,
            'lang':lang,
            'type':strUserl_ex[1],
            'type_val':type_val,
            "method":"search_info"
          },
        success: function(res) {
          $('.info_search').html(res);
          $('.info_center').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR, textStatus, errorThrown);

        }
      });
    }
  }

  function search_info_type(){
    var type = $('#sel_cat_info').val();
    if(type == "2"){
      $('.col-category-1').hide();
      $('.col-category-2').show();
      $('.div_category_3').css('display','inline-block');
      $('#sel_Incorrect_info').val('0').trigger('change');
      // $('#sel_cat_info option[value="2"]').attr("selected",true);
      // $('#sel_cat_info option[value="1"]').attr("selected",false);
      $('.selectpicker').selectpicker('refresh');
    }else {
      $('.col-category-1').show();
      $('.col-category-2').hide();
      $('.div_category_3').css('display','none');
      $('#sel_category_info_ex').val('0').trigger('change');
      // $('#sel_cat_info option[value="1"]').attr("selected",true);
      // $('#sel_cat_info option[value="2"]').attr("selected",false);
      $('.selectpicker').selectpicker('refresh');
    }
  }

  var currentPage=1;
  var numpage = 0;
  function btnnextpage(idbtn)
  {
    var start = $('.start_numpage').val();
    var end = $('.end_numpage').val();
  	currentPage= (idbtn=='2') ? currentPage + 1 : currentPage - 1;
    numpage= (idbtn=='2') ?  + 5 :  - 5;
    var start_page = parseInt(start)+(numpage);
    var end_page = parseInt(end)+(numpage);
  	search_info(start_page,end_page,null,2);

  }

  $( document ).ready(function() {
    chk_div_category();
  });
</script>
<style>
.icon-ico-ditp-43{
  display: inline-block;
  position: relative;
  top: -2px;
}
.sel_category_info > .btn .txt{
  margin-left: 0px !important;
  top: 1px;
  padding-left: 5px !important;
}
.bootstrap-select.btn-group .dropdown-menu li a.opt{
  padding-left: 5px;
}
.bootstrap-select.btn-group .dropdown-toggle .filter-option .icon-ico-ditp-43{
  display: none;
}
.dropdown-menu>li>a{
  padding: 1px 20px !important;
}
</style>
