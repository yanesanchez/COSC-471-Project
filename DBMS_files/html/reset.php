<?php

ob_start();
session_start();
session_destroy();
header("Location: screen2.php"); 
exit;

//$_SESSION['user_id'] = '';
//$_SESSION['temp_id'] = '';
//$_SESSION['cart_id'] = false;
//$_SESSION['valid'] = false;



?>