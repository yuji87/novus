<?php

session_start();

define('DSN', 'mysql:host=localhost;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', 'root');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once("Utils.php");
require_once("Token.php");
require_once("Database.php");
require_once("Todo.php");

spl_autoload_register(function ($class) {
  $prefix = 'MyApp\\';

  if (strpos($class, $prefix) === 0) {
    $fileName = sprintf(__DIR__ . '/%s.php', substr($class, strlen($prefix)));

    if (file_exists($fileName)) {
      require($fileName);
    } else {
      echo 'File not found: ' . $fileName;
      exit;
    }
  }
});
