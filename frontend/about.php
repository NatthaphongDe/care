<div class="row appeal_div_row">
  <div class="col-md-12">
    <span class="icon_about_detail"><img src="images/icon_about_detail.png"></span>
    <span class="txt_hr_about_detail"><?php if($lang == "1"){ echo "เกี่ยวกับ DITP Care";}elseif($lang == "2"){ echo "About DITP Care";}else{ echo "เกี่ยวกับ DITP Care";}?></span>

    <div class="panel panel-default about-panel" style="text-align:center; height: 380px;">
      <div class="panel-body">
          <div class="box-about-hr-txt"><img src="images/logo_about.svg"></div>
          <div class="box-about-txt">
            <?=$txt_Promotion?>
              </div>
          <div class="cartoon_about">
            <img src="images/about_cartoon_m.png" style="margin-right:20px;" class="cartoon_about_m">
            <img src="images/about_cartoon_g.png" class="cartoon_about_g">
          </div>
      </div>
    </div>

    <div class="txt_hr_about"><img src="images/icon_home_about.png"><span class="about_home">
      <?=$txt_Office_ex?>
      </span></div>
    <div class="txt_hr_about"><span class="about_home_txt"><?=$txt_Follow_ex?></span></div>
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default about-panel">
          <div class="panel-body">
              <div class="box-about-hr"><?=$txt_Bangkrasor?></div>
              <div class="box1-about-txt"><?=$txt_Bangkrasor_add?></div>
              <div class="box1-about-txt"><?=$txt_Telephone?> : 02-507-8173,02-507-7999</div>
              <div class="box1-about-txt"><?=$txt_Fax?> : 02-547-4297</div>
              <div class="box1-about-txt"><?=$txt_email?> : Ditpservicecenter@gmail.com , ditpcare@ditp.go.th</div>
              <div class="box1-about-txt"><?=$txt_Hotline?> : 1169</div>
              <div class="box1-about-txt" style="text-align:center;">
                <button class="btn btn-map-about" type="button" onclick="map_some();"><img src="images/icon_about_marker.png"> <span class="txt_map"><?=$txt_Map?></span></button></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default about-panel">
          <div class="panel-body">
              <div class="box-about-hr"><?=$txt_Ratchadaphisek?></div>
              <div class="box2-about-txt"><?=$txt_Ratchadaphisek_add?></div>
              <div class="box2-about-txt"><?=$txt_Telephone?> : 02-513-1909</div>
              <div class="box2-about-txt"><?=$txt_Fax?> : 02-511-5200</div>
              <div class="box2-about-txt"><?=$txt_email?> : tiditp@ditp.go.th</div>
              <div class="box2-about-txt"><?=$txt_Hotline?> : 1169</div>
              <div class="box1-about-txt" style="text-align:center;">
                <button class="btn btn-map-about" type="button" onclick="map_ratchadaphisek();"><img src="images/icon_about_marker.png"> <span class="txt_map"><?=$txt_Map?></span></button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function map_some(){
  window.open('https://www.google.com/maps/d/u/0/viewer?ll=13.885037300929946%2C100.48700800000006&spn=0.023622%2C0.042272&msa=0&iwloc=0004e1d66cce09b33bc93&mid=1Urvxq7GWYWsmkhMnjkFy4vNBKLY&z=15', '_blank');
}
function map_ratchadaphisek(){
  window.open('https://www.google.com/maps/d/u/0/viewer?ll=13.82612029975422%2C100.57412599999998&spn=0.023628%2C0.042272&msa=0&iwloc=0004e68ff289bca436eac&mid=1WcmTok743h6ZfAq-PW91257bJBo&z=15', '_blank');
}
</script>
