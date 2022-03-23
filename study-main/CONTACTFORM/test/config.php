<?php
session_start();
session_regenerate_id(true); //セッションハイジャック対策
header('X-Frame-Options: DENY'); //クリックジャッキング対策

define("DSN", "mysql:host=localhost; dbname=qanda; charset=utf8mb4");
define("DB_USER", "root");
define("DB_PASS", "");

require_once("db.php");
