<?php
session_start();
// session_regenerate_id(true);

define("DSN", "mysql:host=localhost; dbname=qanda; charset=utf8mb4");
define("DB_USER", "root");
define("DB_PASS", "root");
// define("SITE_URL", "http://". $_SERVER["HTTP_HOST"]);

// require_once("Utils.php");
// require_once("Token.php");
require_once("db.php");
// require_once("contact.php");


  