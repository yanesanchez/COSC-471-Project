<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$user = 'yanelisa_root';
$password = 'cosc-471';
$host = 'localhost';
$name = 'yanelisa_3b-bookstore2';


$pdo = new PDO("mysql:host=$host;dbname=$name", "$user", "$password")
OR die('Could not connect to MySQL: ' .
        mysqli_connect_error());

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>