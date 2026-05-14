<?php
if(!isset($_REQUEST["page"]) || (isset($_REQUEST["page"]) && $_REQUEST["page"]=="") ){
  header('Location: frontend/index.php?page=home');
}
?>
