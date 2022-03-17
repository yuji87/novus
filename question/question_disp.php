<?php
    session_start();

    //ファイルの読み込み
    require_once 'classes/QuestionLogic.php';

    //error
    $err = [];

    $question_id = filter_input(INPUT_POST, 'question_id');

    if(!$question_id = filter_input(INPUT_POST, 'question_id')) {
      $err[] = '質問を選択してください。';
    }

    if (count($err) === 0){
      //質問を表示する処理
      $hasDisplayed = QuestionLogic::displayQuestion($_POST);

      if(!$hasDisplayed){
          $err[] = '接続に失敗しました。';
      }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>質問詳細</title>
</head>

<body>

<div>題名：<?php echo ?></div>
<div>本文：<?php echo ?></div>
<div>投稿日時：<?php echo ?></div>
<div>ユーザー：<?php echo ?></div>

<form>
  <input type="hidden" name="question_id" value="<?php echo $question_id ?>">
  <a>編集</a>
  <a>削除</a>

</form>

</body>