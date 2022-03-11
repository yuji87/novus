<?php

// 設定ファイルの読み込み
require_once ('config.php');

function dbConnect(){
  
    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 例外
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 連想配列
        PDO::ATTR_EMULATE_PREPARES   => false,                  //SQLインジェクション対策
    ];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf-8";
    
    try {
        $pdo = new PDO ($dsn, $user, $pass, $options);
        
    } catch(PDOException $e) {
        echo 'error'. $e->getMessage();
    }
}

?>