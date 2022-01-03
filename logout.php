<?php
// session'un başlatılması
session_start();
 
// session değişkenlerinin boşaltılması
$_SESSION = array();
 
// session'un yok edilmesi
session_destroy();
 
// login sayfasına yeniden yönlendirilmesi
header("location: login.php");
exit;
?>