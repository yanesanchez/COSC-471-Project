<?php

ob_start();
session_start();
session_destroy();
header("Location: screen2.php"); 
exit;
?>