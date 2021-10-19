<?php

error_reporting(-1);
ini_set('display_errors', 'On');

DEFINE(DB_USER, 'root');
DEFINE(DB_PASSWORD, 'r00t1');
DEFINE(DB_HOST, 'localhost');
DEFINE(DB_NAME, 'bookstore');


$dbc = mysqli_connect('root', 'r00t1', DB_HOST, 'bookstore', 3306)
OR die('Could not connect to MySQL: ' .
        mysqli_connect_error());
?>