<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_help_detail"><img src="images/icon_help_detail.png"></span>
    <span class="txt_hr_help_detail"><?=$txt_Help?></span>
  </div>
  <div class="row no-margin">
    <div class="col-md-12">

      <a data-toggle="collapse" href="#collapse_1" class="collapse_1" style="text-decoration: none;">
      <div class="panel panel-default help-panel">
        <div class="panel-body">
          <span class="item-help-3"><span class="help_at1">- </span>
          <?=$txt_assist?></span>
        </div>
      </div>
      </a>
      <div id="collapse_1" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="txt_hr_help">
          <?=$txt_Assistance?>
          </div>
        <div class="txt_type_help"><?=$txt_Type_petition_hr?></div>
        <div class="txt_item">1. <?=$txt_International_ex?></div>
        <div class="txt_item_sup">- <?=$txt_in_th?></div>
        <div class="txt_item_sup">- <?=$txt_Thai_entrepreneurs_ex?></div>
        <div class="txt_item">2. <?=$txt_Complaint_about?></div>
        <div class="txt_item">3. <?=$txt_Complaint_about_office?></div>
        <div class="txt_item_sup">- <?=$txt_Complaint_about_appeal?></div>
        <div class="txt_item_sup">- <?=$txt_Complaint_against?></div>
        <div class="txt_item">4. <?=$txt_Others?></div>
      </div>
    </div>

    <a data-toggle="collapse" href="#collapse_2" class="collapse_2" style="text-decoration: none;">
    <div class="panel panel-default help-panel">
      <div class="panel-body">
          <span class="item-help-3"><span class="help_at2">- </span> <?=$txt_Hpetition?></span>
      </div>
    </div>
    </a>
    <div id="collapse_2" class="panel-collapse collapse">
    <div class="panel-body">
      <div class="txt_item"><?=$txt_step1?></div>
      <div class="txt_item"><?=$txt_step2?></div>
      <div class="txt_item"><?=$txt_step3?></div>
      <div class="txt_item"><?=$txt_step4?></div>
    </div>
  </div>

  <a data-toggle="collapse" href="#collapse_3" class="collapse_3" style="text-decoration: none;">
  <div class="panel panel-default help-panel">
    <div class="panel-body">
        <span class="item-help-3"><span class="help_at3">- </span> <?=$txt_Petition_channels?></span>
    </div>
  </div>
  </a>
  <div id="collapse_3" class="panel-collapse collapse">
  <div class="panel-body">
    <div class="txt_item">1. <?=$txt_yourself?></div>
    <div class="txt_item_sup">1.1 <?=$txt_counters?></div>
    <div class="txt_item_supersup">- <?=$txt_Ratchadaphisek?></div>
    <div class="txt_item_supersup">- <?=$txt_Nonthaburi?></div>
    <div class="txt_item_sup">1.2 <?=$txt_Center_a?></div>
    <div class="txt_item_sup">1.3 <?=$txt_web?></div>
    <div class="txt_item_sup">1.4 <?=$txt_mail_DITP?></div>
    <div class="txt_item">2. <?=$txt_ThaiTrade?></div>
    <div class="txt_item_sup">2.1 <?=$txt_Overseas1?></div>
    <div class="txt_item_sup">2.2 <?=$txt_Overseas2?></div>
    <div class="txt_item">3. <?=$txt_Overseas3?></div>
    <div class="txt_item_sup">3.1 <?=$txt_Overseas4?></div>
    <div class="txt_item_sup">3.2 <?=$txt_Overseas5?></div>
    <div class="txt_item_sup">3.3 <?=$txt_Fashion?></div>
    <div class="txt_item_sup">3.4 <?=$txt_Agricultural?></div>
    <div class="txt_item_sup">3.5 <?=$txt_Logistics?></div>
    <div class="txt_item">4. <?=$txt_Foreign?></div>
    <div class="txt_item_sup">4.1 <?=$txt_Secretary?></div>
    <div class="txt_item_sup">4.2 <?=$txt_GCC?></div>
    <div class="txt_item_sup">4.3 <?=$txt_Government?></div>
    <div class="txt_item_sup">4.4 <?=$txt_ThaiPost?></div>
  </div>
</div>

<a data-toggle="collapse" href="#collapse_4" class="collapse_4" style="text-decoration: none;">
<div class="panel panel-default help-panel">
  <div class="panel-body">
      <span class="item-help-3"><span class="help_at4">- </span> <?=$txt_membership?></span>
  </div>
</div>
</a>
<div id="collapse_4" class="panel-collapse collapse">
<div class="panel-body">
  <div class="txt_hr_help"><?=$txt_Thai_entrepreneurs?></div>
</div>
</div>


    </div>
  </div>
  <!-- <form method="get" action="file_ditp/ditp_web_frontend.pdf"> -->
  <div class="row">
    <div class="col-md-12" style="text-align:center;">
      <div style="margin-top:30px;"><?=$txt_Manual?></div>
      <a href="file_ditp/ditp_web_frontend.pdf" download><button type="button" class="btn btn-load-help"><?php if($lang == "1"){ echo "ดาวน์โหลด";}elseif($lang == "2"){ echo "Download";}else{ echo "ดาวน์โหลด";}?><span class="icon_download"><img src="images/icon_download.png"></span></button></a>
    </div>
  </div>
<!-- </form> -->
</div>
<script>
$('.collapse_1').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $('.help_at1').css('display','none');
  $(this).find('div').removeClass('item-help-2');
  $(this).find('div').addClass('item-help-1');
}else{
  $('.help_at1').css('display','inline-block');
  $(this).find('div').removeClass('item-help-1');
  $(this).find('div').addClass('item-help-2');
}
});


$('.collapse_2').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $('.help_at2').css('display','none');
  $(this).find('div').removeClass('item-help-2');
  $(this).find('div').addClass('item-help-1');
}else{
  $('.help_at2').css('display','inline-block');
  $(this).find('div').removeClass('item-help-1');
  $(this).find('div').addClass('item-help-2');
}
});


$('.collapse_3').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $('.help_at3').css('display','none');
  $(this).find('div').removeClass('item-help-2');
  $(this).find('div').addClass('item-help-1');
}else{
  $('.help_at3').css('display','inline-block');
  $(this).find('div').removeClass('item-help-1');
  $(this).find('div').addClass('item-help-2');
}
});

$('.collapse_4').bind('click',function(){
var id_elm = $(this).attr('href');
if($(id_elm).hasClass('in')){
  $('.help_at4').css('display','none');
  $(this).find('div').removeClass('item-help-2');
  $(this).find('div').addClass('item-help-1');
}else{
  $('.help_at4').css('display','inline-block');
  $(this).find('div').removeClass('item-help-1');
  $(this).find('div').addClass('item-help-2');
}
});
</script>
