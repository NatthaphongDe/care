<?php
include("function.php");

$ip = get_client_ip();
$datetime = date('Y-m-d H:i:s');
$xx = "\r ip=".$ip." open_page_time=".$datetime;
$fp2 = fopen('log_refresh.txt', 'a+');
fwrite($fp2,$xx);
fclose($fp2);

 ?>
 <?/*
 script
       // var page = 1;
       //
       // setTimeout(function(){
       //   switch_page();
       // }, 2000);
       //
       // function switch_page() {
       //
       //   switch (page) {
       //     case 1: document.getElementById('freame_top').src = 'text_screen.php';break;
       //     case 2: document.getElementById('freame_top').src = 'index_true.php';break;
       //     default: document.getElementById('freame_top').src = 'index_true.php';
       //   }
       //
       //   setTimeout(function(){
       //     console.log('ss='+page);
       //     if(page==1){
       //       page=2;
       //     }else{
       //       page-=1;
       //     }
       //     switch_page();
       //   }, 2000);
       //
       //
       // }
 */?>
<html>
 <head>
  <title>DITP Dashboard</title>
  <script>

    // setTimeout(function(){
    //   location.reload();
    // }, 1800000);


  </script>
  <meta http-equiv="cache-control" content="max-age=0" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
  <meta http-equiv="pragma" content="no-cache" />
 </head>
 <frameset rows="*">
   <frame id="freame_top" name="top" src="index_true.php">
   <noframes>
     <i>error to display to those who cannot see frames</i>
   </noframes>
 </frameset>
</html>
