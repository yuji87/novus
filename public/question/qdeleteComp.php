<?php
  session_start();

  //ファイルの読み込み
  require_once '../../classes/QuestionLogic.php';
  require_once '../../classes/CategoryLogic.php';
  require_once '../../classes/UserLogic.php';

  // ログインチェック
  $result = UserLogic::checkLogin();
  if(!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../../userLogin/form.php');
    return;
  }
  
  //error
  $err = [];

  $question_id = filter_input(INPUT_POST, 'question_id');
  if(!$question_id == filter_input(INPUT_POST, 'question_id', FILTER_SANITIZE_SPECIAL_CHARS)) {
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
  <button type="button" onclick="location.href='../../userLogin/home.php'">TOP</button>
  <button type="button" onclick="location.href='top.php'">質問TOPへ</button>
</body>