<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$user = 'root';
$password = '123';
$host = 'localhost';
# Ben's DB
// $name = 'BOOKSTORE';
# Yaneli's DB
$name = 'yanelisa_3b-bookstore';


$pdo = new PDO("mysql:host=$host;dbname=$name", "$user", "$password")
OR die('Could not connect to MySQL: ' .
        mysqli_connect_error());

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>