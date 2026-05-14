<?php
session_start();
// session_destroy();
unset($_SESSION['member_id']);
unset($_SESSION['member_type']);
unset($_SESSION['chk_lang']);
unset($_SESSION['lang']);
unset($_SESSION['member_login_type']);
setcookie('chk_lang', null, -1, '/frontend');
?>
<script>
window.location = '/frontend/index.php?page=home';
</script>
