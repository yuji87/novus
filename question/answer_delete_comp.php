<?php
  session_start();

  //ファイルの読み込み
  require_once '../classes/QuestionLogic.php';
  require_once '../classes/CategoryLogic.php';
  require_once '../classes/UserLogic.php';

  $result = UserLogic::checkLogin();
  if($result) {
  header('Location: login_top.html');
  return;
  }

  $categories = CategoryLogic::getCategory();

  //error
  $err = [];

  $question_id = filter_input(INPUT_POST, 'question_id');
  if(!$question_id == filter_input(INPUT_POST, 'question_id')) {
    $err[] = '質問を選択し直してください';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問を削除しました</title>
</head>
<body>

<div>削除が成功しました</div>
<button type="button" onclick="location.href='../top/login_top.php'">TOP</button>
<button type="button" onclick="history.back()">戻る</button>