<?php

session_start();

define('DSN', 'mysql:host=localhost;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', 'root');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once('functions.php');
