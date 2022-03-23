<?php 

require_once("config.php");

//db, Article, Utilsクラスが出てきたらMyAppTodoが入るようにする
use ArticleApp\db;
use ArticleApp\Article;
use ArticleApp\Utils;

$pdo = db::getInstance();

$Article = new Article($pdo); //todoクラスのインスタンスを作成
$Article->processPost(); // POSTで送信されたデータを処理するメソッド
$todos = $Article->getAll(); //todoを表示するために配列を取得するメソッド
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>









</body>
</html>