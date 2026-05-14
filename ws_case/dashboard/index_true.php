<?php include("../config/config.php"); ?>
<?php include("function.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta content="width=1920, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=1920">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Dashboard DITP</title>



    <!-- piegage -->
    <!-- <link rel="stylesheet" type="text/css" href="css/assets/widgets/charts/piegage/piegage.css">
    <script type="text/javascript" src="css/assets/widgets/charts/piegage/piegage.js"></script> -->

    <link rel="stylesheet" type="text/css" href="css/assets/helpers/colors.css">
    <!-- progressbar -->
    <link rel="stylesheet" type="text/css" href="css/assets/widgets/progressbar/progressbar.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">

    <!-- iziToast -->
    <link rel="stylesheet" type="text/css" href="css/iziToast.min.css">

    <!-- JS Core -->
    <script type="text/javascript" src="css/assets/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="css/assets/js-core/jquery-ui-widget.js"></script>

    <!-- iziToast -->
    <script type="text/javascript" src="js/iziToast.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
  </head>
  <?php
  $mod_row = 0;

  $sql_office = "SELECT * FROM `office_type` order by office_id asc ";
  $query_office = $conn->query($sql_office);
  if($query_office->num_rows>0){
    while ($result_office = $query_office->fetch_assoc()){

      $sql = "SELECT * FROM `Employee` a
              LEFT JOIN `Employee_Group` b on (a.empGroup_id=b.empGroup_id)
              WHERE b.empGroup_section = '1'
              AND b.empGroup_level = '0'
              AND b.empGroup_id != '9'
              AND a.emp_available_dashboard = '1'
              AND a.emp_status = '0'
              AND a.office_id = '$result_office[office_id]'
               ";
      $query = $conn->query($sql);
      $row = $query->num_rows;
      if($row>0){
        $mod_row++;
        $rop_mod = 1;
        for ($i=0; $i < $row; $i++) {
          // echo "<br>rop_mod=".$rop_mod;
          if($rop_mod==6){
            $mod_row++;
            $rop_mod=0;
          }
          $rop_mod++;
        }
      }

    }
  }
   ?>
   <input type="hidden" id="mod_row" value="<?php echo $mod_row; ?>">
  <script type="text/javascript"> 
    var timer_1;
    var timer_2;
    var timer_loadpage;
    var numx;
    var max_rop_refresh = 0;

  function check_net(){
    $.ajax({
      type: "POST",
      url: "page_checknet.php",
      success:function(){
        // location.reload();
        if(max_rop_refresh==20){
          location.reload();
        }else{
          load_page();
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        show_toast();
      }
    });
  }

  function show_toast() {
    iziToast.warning({
    title: 'แจ้งเตือน ',
    message: 'ระบบไม่สามารถแสดงข้อมูลต่อไปได้ เนื่องจากสัญญาณอินเตอร์เน็ตของท่านขัดข้อง กรุณารอสักครู่...',
    position: 'center',
    titleSize: '24',
    titleLineHeight: '20',
    messageLineHeight: '50',
    messageSize: '20',
    timeout: 10000,
    layout: 2,
    onClosing: function () { check_net(); }
    });
  }

  function get_page(num) {
    max_rop_refresh++;
    clearTimeout(timer_1);
    clearTimeout(timer_2);
    clearTimeout(timer_loadpage);
    if(num==4){
      numx=4;
    }else{
      numx=1;
    }
    $.ajax({
      type: "POST",
      url: "page_"+numx+".php",
      data: {"numpage":num},
      beforeSend: function () {
        $('#wait_process').show();
        $("body").animate({opacity: '0',});
        $('#show_page').html("");
      },
      complete: function () {
        $('#wait_process').hide();
      },
      success: function(response){
        // console.log(response);
        // $('#show_page').empty();
        // $('#show_page').html(response);
        setTimeout(function(){
          $('#show_page').html(response);
        }, 400);

      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("There was an error in the ajax call: ["+textStatus+"] ["+errorThrown+"]");
        $("body").animate({opacity: '1',});
        // $('#wait_process').hide();
      }
    });
  }

  function show_div() {
    $("body").animate({opacity: '1',});
  }

  document.onkeydown = function (e) {
    // alert(e.key);
      switch (e.key) {
          case '1':
              // up arrow
              num_page = 1;
              check_net();
              break;
          case '2':
              num_page = 2;
              check_net();
              break;
          case '3':
              num_page = 3;
              check_net();
              break;
          case '4':
              num_page = 4;
              check_net();
      }
  };


  // load page
    var mod_row = $('#mod_row').val();
    var rop_time = 0 ;
    if(mod_row!=0){
      for (var i = 0; i < mod_row; i++) {
        rop_time = rop_time+20000;
      }
    }
    var num_page=1;
    <?php if (get_client_ip()=="118.172.251.124-"){ ?>
    get_page(4);
    <?php }else{ ?>
    load_page();
    <?php } ?>
    function load_page() {
      get_page(num_page);
      num_page++;
      if(num_page==5){
        timer_loadpage = setTimeout(function(){
          num_page=1;
          check_net();
          // load_page();
        }, rop_time);
      }else{
        timer_loadpage = setTimeout(function(){
          check_net();
          // load_page();
        }, 20000);
      }
    }
    // load page
  </script> 

  <body>
    <img src="image/db_top.png" class="img_top">

      <div id="show_page"></div>

    <?/*
    <div id="wait_process" style="background: black;display:none;">
      <div class="wait" style="background: rgba(0 ,0 ,0 ,0.5);position: fixed;top: 0;right: 0;bottom: 0;left: 0;z-index: 1050;overflow: hidden;-webkit-overflow-scrolling: touch;outline: 0;">
        <div class="" style="text-align: center;font-size: 20px;position: absolute;left: 50%;top: 50%;border-radius: 5px;margin-left: -133px;background: #fff;width: 250px;height: 58px;">
          <img src="image/loading.gif" alt="" style="position: relative;top: 10px;right: 21px;"> กรุณารอสักครู่..
          <div class="" style="font-size:16px;padding-left:50px;">
            ระบบกำลังดึงข้อมูล
          </div>
        </div>
      </div>
    </div>
    */?>

    <div id="wait_process" style="background: black;display:none;">
      <div class="wait" style="background: rgba(0 ,0 ,0 ,0.5);position: fixed;top: 34%;right: 43%;bottom: 45%;left: 45%;z-index: 1050;overflow: hidden;border-radius: 20px;-webkit-overflow-scrolling: touch;outline: 0;">
        <div class="" style="text-align: center;font-size: 20px;position: absolute;left: 81%;top: 25%;border-radius: 5px;margin-left: -133px;width: 250px;height: 58px;">
          <div class="loader"></div>
        </div>
      </div>
    </div>

  <script src="js/highcharts.js"></script>
  <script src="js/exporting.js"></script>
  <!-- Bootstrap Progress Bar -->
  <script type="text/javascript" src="css/assets/widgets/progressbar/progressbar.js"></script>
  <script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>
  </body>
</html>
