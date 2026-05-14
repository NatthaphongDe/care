
<?php if(isset($_SESSION["appeal_detail"])) {
  session_start();
  unset($_SESSION['appeal_detail']);
  unset($_SESSION['case_id']);
  unset($_SESSION['case_user_id']);
} ?>

<div class="row div_home">

  <!-- Modal Popup -->

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body">
      <?php if ($lang == "2") { ?>
        <img src="images/Popup DITP Care.png" width="100%">
      <?php } else { ?>
        <img src="images/Popup DITP Care th.png" width="100%">
      <?php } ?>
        <!-- <img src="img/popup_close.png" width="100%"> -->
        <!-- <img src="img/DITP-Care_popup-website_1200x1200.png" width="100%"> -->
        <!-- <img src="img/dtip-x-queq_800x6000-03.jpg" width="100%"> -->
			</div>
			</div>
		</div>
	</div>

  <div id="myModalEven" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body">
        <img src="img/DITP_12 Aug.jpg" width="100%">
			</div>
			</div>
		</div>
	</div>
  

  <!-- <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body">
				<a onclick="modal_popup('view')" data-dismiss="modal" target="_blank">
        <?php if ($lang == "2") { ?>
          <img src="img/PDPA-22 Website.png" width="100%">
        <?php } else { ?>
          <img src="img/PDPA-22 Website.png" width="100%">
          <?php } ?>
        </a>
			</div>
			</div>
		</div>
	</div> -->

  <!-- <div id="myModalEven" class="modal fade" role="dialog" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body">
        <img src="img/intro_28_7.jpg" width="100%">
			</div>
			</div>
		</div>
	</div> -->
  <!---------------->

  <div id="myModal_login" class="modal fade" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body" style="      padding-bottom: 30px;  text-align: center;">
      <i class="fa fa-exclamation-triangle" aria-hidden="true" style=" color: #048F78; font-size: 120px;"></i>
        <p style="font-size: xx-large;"><?=$txt_alert_login1?></p>
        <p style="font-size: xx-large;"><?=$txt_alert_login2?></p>
        <a href="https://sso.ditp.go.th/sso/register" class="btn " style="    color: #048F78;
    background-color: transparent;
    background-image: none;
    border-color: #048F78;
    border: 3px solid;"><?=$txt_alert_login3?></a>
        <a href="https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=ssocareid&redirect_uri=https%3A%2F%2Fcare.ditp.go.th%2Fapi%2Fautologin_sso_v2.php&state=ugfjdfksg1" class="btn btn-success" style=" background-color: #048F78;  border: 3px solid #048F78;"><?=$txt_alert_login4?></a>
			</div>
			</div>
		</div>
	</div>

  <div id="myModal_loginForm" class="modal fade" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="modal_popup('close')">&times;</button>
			</div>
			<div class="modal-body" style="      padding-bottom: 30px;  text-align: center;">
      <i class="fa fa-exclamation-triangle" aria-hidden="true" style=" color: #048F78; font-size: 120px;"></i>
        <p style="font-size: xx-large;">ต้องการทำแบบสำรวจความพึงพอใจ</p>
        <p style="font-size: xx-large;"><?=$txt_alert_login2?></p>
        <a href="https://sso.ditp.go.th/sso/register" class="btn " style="    color: #048F78;
    background-color: transparent;
    background-image: none;
    border-color: #048F78;
    border: 3px solid;"><?=$txt_alert_login3?></a>
        <a href="https://sso.ditp.go.th/sso/index.php/auth?response_type=token&client_id=ssocareid&redirect_uri=https%3A%2F%2Fcare.ditp.go.th%2Fapi%2Fautologin_sso_v2.php&state=ugfjdfksg1" class="btn btn-success" style=" background-color: #048F78;  border: 3px solid #048F78;"><?=$txt_alert_login4?></a>
			</div>
			</div>
		</div>
	</div>

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <?php
    $sql = "SELECT * FROM `Banner` WHERE banner_status = 0 AND banner_enable = 1 ORDER BY banner_up_dow DESC LIMIT 0,10";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
      $num = $query->num_rows;
    ?>
   <ol class="carousel-indicators">
     <?php for ($i=0; $i<$num;$i++){?>
     <li data-target="#myCarousel" data-slide-to="<?=$i;?>" <?= ($i == 0) ? 'class="active"' : ''?>></li>
     <?php } ?>
   </ol>
   <?php
 }else { ?>
   <ol class="carousel-indicators">
     <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
   </ol>
   <?php
    }
  ?>
   <div class="carousel-inner">
     <?php
     $item = 0;
     $sql = "SELECT * FROM `Banner` WHERE banner_status = 0 AND banner_enable = 1 ORDER BY banner_up_dow DESC LIMIT 0,10";
     $query = $conn->query($sql);
     if($query->num_rows > 0){
       while ($re = $query->fetch_assoc()) {
     ?>
     <div <?= ($item == 0) ? 'class="item active"' : 'class="item"'?>>
       <?php
       if($lang == "2"){
         $pathfile = "../".$re['banner_img_path_en'];
         if(count(glob($pathfile)) > 0 && $re['banner_img_name_en'] != "") {
         ?>
         <img src="../<?=$re['banner_img_path_en'];?>" alt="Los Angeles" style="width:100%;">
         <?php }else { ?>
         <img src="images/banner.png" alt="Los Angeles" style="width:100%;">
        <?php }
       }else {
         $pathfile = "../".$re['banner_img_path'];
         if(count(glob($pathfile)) > 0 && $re['banner_img_name'] != "") {
         ?>
         <img src="../<?=$re['banner_img_path'];?>" alt="Los Angeles" style="width:100%;">
         <?php }else { ?>
         <img src="images/banner.png" alt="Los Angeles" style="width:100%;">
        <?php }
       }
       ?>
     </div>
     <?php
      $item++;
       }
     }else { ?>
       <div class="item active">
         <img src="images/banner.png" alt="Los Angeles" style="width:100%;">
       </div>
    <?php
     }
    ?>
   </div>


   <!-- Left and right controls -->
   <a class="left carousel-control" href="#myCarousel" data-slide="prev">
     <span class="glyphicon glyphicon-chevron-left"></span>
     <span class="sr-only">Previous</span>
   </a>
   <a class="right carousel-control" href="#myCarousel" data-slide="next">
     <span class="glyphicon glyphicon-chevron-right"></span>
     <span class="sr-only">Next</span>
   </a>
 </div>
</div>

<!-- <div class="row div_center_home">
  <div class="home_center_peview">
    <div class="row div_center_home_txt">
      <div class="col-md-1"></div>
      <div class="col-md-10" style="text-align:center;">
        <div class="home_center_hr">
              <?=$txt_Hpetition?>
        </div>
          <?php
        $i = 0;
        $sql = "SELECT * FROM `Complaint_procedure` WHERE cpp_enable = 1 AND cpp_status = 0 ORDER BY cpp_up_dow DESC";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
          while ($rs = $query->fetch_assoc()) {
            $modi = $i%4;
            if($i == 0 || ($i >= 4 && $modi == 0)){ ?>
              <div class="row">
              <?php
            }
            ?>


            <div class="col-md-3 center_box_col">
              <div class="center_box">
              <img src="../../<?=$rs['cpp_img_path'];?>">
              </div>
              <div class="center_box_txt">
                <div class="home_center_txt">
                  <?php
                  if($lang == "1"){
                    $cpp_detail = $rs['cpp_detail'];
                  }elseif ($lang == "2") {
                    $cpp_detail = $rs['cpp_detail_en'];
                  }else {
                    $cpp_detail = $rs['cpp_detail'];
                  }
                  echo $cpp_detail;?>
                </div>
            </div>
          </div>
          <?php
          if($i >= 3 && $modi == 3){ ?>
          </div>
            <?php
          }
          ?>

        <?php
        $i++;
          }
        }else { ?>
          <div class="row">
          <div class="col-md-3 center_box_col">
            <div class="center_box">
            <img src="images/home_center_box1.png">
            </div>
            <div class="center_box_txt">
              <div class="home_center_txt"><?=$txt_step1_ex?></div>
            </div>
          </div>
          <div class="col-md-3 center_box_col">
            <div class="center_box">
            <img src="images/home_center_box2.png" style="margin-left: -87px;">
            </div>
            <div class="center_box_txt">
              <div class="home_center_txt">
        <?=$txt_step2_ex?>
              </div>
            </div>
          </div>
          <div class="col-md-3 center_box_col">
            <div class="center_box">
            <img src="images/home_center_box3.png">
            </div>
            <div class="center_box_txt">
              <div class="home_center_txt"><?=$txt_step3_ex?></div>
            </div>
          </div>
          <div class="col-md-3 center_box_col">
            <div class="center_box">
            <img src="images/home_center_box4.png">
            </div>
            <div class="center_box_txt">
              <div class="home_center_txt"><?=$txt_step4_ex?></div>
            </div>
          </div>
      <?php
        }
        ?>
        </div>

      </div>
      <div class="col-md-1"></div>

    </div>
  </div>
</div> -->


<!-- <div class="row home_footer_peview">
  <div class="col-md-6 col-sm-6 col-xs-6 center_img_1">
      <img src="images/logo-iPhone.png">
  </div>
  <div class="col-md-3 col-sm-6 col-xs-6 center_img_2">
    <span class="ditp_care_home_txt">DITP Care Application</span><br>
    <span class="ditp_care_home_txt2"><?=$txt_download_DITP?></span><br>
    <span class="ditp_care_home_txt3"><?=$txt_download_DITP_2?></span><br>
    <img src="images/home_center_app.png">
    <img src="images/home_center_play.png">
  </div>
  <div class="col-md-3"></div>
</div> -->
</div>
<style>
  .linkpicture-1{
    position: relative;
  }
  .linkpicture-1 .Pictrue1_link1{
    position: absolute;
    top: 16%;
    left: 17%;
    content: "";
    width: 13%;
    height: 10%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link2{
    position: absolute;
    top: 17%;
    left: 37%;
    content: "";
    width: 13%;
    height: 8%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link3{
    position: absolute;
    top: 30%;
    left: 65%;
    content: "";
    width: 17%;
    height: 4%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link4{
    position: absolute;
    top: 34%;
    left: 65%;
    content: "";
    width: 15%;
    height: 4%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link5{
    position: absolute;
    top: 80%;
    left: 73%;
    content: "";
    width: 15%;
    height: 8%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link6{
    position: absolute;
    top: 56%;
    left: 73%;
    content: "";
    width: 16%;
    height: 3%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link7{
    position: absolute;
    top: 68%;
    left: 57%;
    content: "";
    width: 27%;
    height: 3%;
    background-color: transparent;
  }
  .linkpicture-1 .Pictrue1_link8{
    position: absolute;
    top: 96%;
    left: 31%;
    content: "";
    width: 27%;
    height: 3%;
    background-color: transparent;
  }
  .linkpicture-2{
    position: relative;
  }
  .linkpicture-2 .Pictrue1_link1{
    position: absolute;
    top: 84%;
    left: 55%;
    content: "";
    width: 22%;
    height: 10%;
    background-color: transparent;
  }
  .linkpicture-2 .Pictrue1_link2{
    position: absolute;
    top: 41%;
    left: 73%;
    content: "";
    width: 11%;
    height: 9%;
    background-color: transparent;
  }
  .linkpicture-3{
    position: relative;
  }
  .linkpicture-3 .Pictrue1_link1{
    position: absolute;
    top: 82%;
    left: 38%;
    content: "";
    width: 18%;
    height: 10%;
    background-color: transparent;
  }
  @media (min-width: 992px){
    .modal-lg {
        width: 700px;
    }
  }
</style>
<?php
  if($lang == 2){
    ?>
    <div style="display: flex; flex-direction: column; margin-top: 1rem;">
      <div style="text-align:center;">
        <div class="linkpicture-1">
          <a href="https://datawarehouse.dbd.go.th/juristic" class="Pictrue1_link1" target="_blank"></a>
          <a href="https://www.scamadviser.com/" class="Pictrue1_link2" target="_blank"></a>
          <a href="https://www.fit.or.th/" class="Pictrue1_link3" target="_blank"></a>
          <a href="https://www.thaichamber.org/" class="Pictrue1_link4" target="_blank"></a>
          <a href="https://www.thaitradefair.com/ExporterList/?page=ExporterList/" class="Pictrue1_link5" target="_blank"></a>
          <a href="https://www.thaitrade.com/home" class="Pictrue1_link6" target="_blank"></a>
          <a href="https://www.ditp.go.th/en/overseas-office-and-honorary-trade-advisors-hta" class="Pictrue1_link7" target="_blank"></a>
          <a href="https://www.legal500.com/c/thailand" class="Pictrue1_link8" target="_blank"></a>

          <!-- <img src="./img/banner CARE -eng-01.png" style="width: 80%; margin-bottom: 1rem;"></img> -->
          <img src="/frontend/img/ditp-with-link.jpg" style="width: 80%; margin-bottom: 1rem;"></img>
        </div>
        <!-- <div class="linkpicture-2">
          <a href="https://www.ditp.go.th/en/overseas-office-and-honorary-trade-advisors-hta" class="Pictrue1_link1" target="_blank"></a>
          //<a href="https://www.ditp.go.th/ditp_web61/foreign_office_all.php" class="Pictrue1_link1" target="_blank"></a>
          //<a href="https://www.ditp.go.th/" class="Pictrue1_link1" target="_blank"></a>
          <a href="https://www.thaitrade.com/home" class="Pictrue1_link2" target="_blank"></a>
          <img src="./img/banner CARE -eng-02.png" style="width: 80%; margin-bottom: 1rem;"></img>
        </div>
        <div class="linkpicture-3">
          <a href="https://www.legal500.com/c/thailand" class="Pictrue1_link1" target="_blank"></a>
          <img src="./img/banner CARE -eng-03.png" style="width: 80%; margin-bottom: 1rem;"></img>
        </div> -->
      </div>
    </div>
  <?php
  }else{
    include('infocare.php');
  }
?>

<div class="row div_footer_hide" style="height:300px;">
  <div class="footer_home">
    <img src="images/all_icon_DITP/icon_24.svg" style="width:35px;">
    <span class="txt_footer_home" style="font-weight: 300;"><?=$txt_Call_Centre?></span>
    <?php //if($login != ""){?>
    <div class="txt_question fm-login"><a <?php if($login != ""){ ?>
        href="?page=question"
        <?php }?>><?=$question?></a></div>
    <?php //} ?>
  </div>
</div>
<!-- <div id="my-modal-pop" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="
    background-color: #fff0;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0);
">
      <div class="modal-body" style="text-align: center;">
      <br>
      <br><br>
      <img src="../img/queen.jpg" style="margin: 0 auto;width: 80%;" alt="">
      <br>
      <br><br>
 
      <button class="btn btn-warning btn_login" style="width:135px;" data-dismiss="modal" aria-label="Close">เข้าสู่เว็บไซต์</button>
      </div>
    </div>
  </div>
</div>

<script>
  $( document ).ready(function() {
    $('#my-modal-pop').modal('show');
    var chk_lang = $('.language_status').val();
    var chk_lang_status = $('.chk_lang_status').val();
    var chk_val = $.cookie('chk_lang');
      if(chk_lang == 0){
        if(chk_lang_status == 1){
        if( chk_val == undefined){
        $('#modal_chk_lang').modal('show');
        $.cookie('chk_lang', '0', { expires: 7, path: '/frontend' });
        }
      }
      }
    });
</script> -->
<!-- <script>
  translate('th', 'en', 'กิน')
  function translate($from_lan, $to_lan, $text){
      $json = json_decode(file_get_contents('https://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . urlencode($text) . '&langpair=' . $from_lan . '|' . $to_lan));
      $translated_text = $json->responseData->translatedText;
      console.log();
      return $translated_text;
  }
</script> -->

<script>
  $( document ).ready(function() {
    //$('#myModal').modal('show');
  });
</script>