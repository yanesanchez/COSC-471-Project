<?php

ob_start();
session_start();
$_SESSION['cart_id'] = '';
session_destroy();
header("Location: screen2.php"); 
exit;

//$_SESSION['user_id'] = '';
//$_SESSION['temp_id'] = '';
//$_SESSION['cart_id'] = false;
//$_SESSION['valid'] = false;



?>