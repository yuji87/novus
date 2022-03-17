<?php
    session_start();

    //ファイルの読み込み
    require_once '../classes/QuestionLogic.php';

    //error
    $err = [];

    $user_id = filter_input(INPUT_POST, 'user_id');
    $title = filter_input(INPUT_POST, 'tilte');
    $category = filter_input(INPUT_POST, 'category');
    $message = filter_input(INPUT_POST, 'message');
    $question_image = filter_input(INPUT_POST, 'question_image');
    if(!isset($question_image)){
      $question_image = "a";
    }

    if(!$title = filter_input(INPUT_POST, 'title')) {
        $err[] = '質問タイトルを入力してください';
    }
    if(!$category = filter_input(INPUT_POST, 'category')) {
        $err[] = 'カテゴリを選択してください';
    }
    if(!$message = filter_input(INPUT_POST, 'message')) {
        $err[] = '本文を入力してください';
    }

    if (count($err) === 0){
        //質問を登録する処理
        $hasCreated = QuestionLogic::createQuestion($_POST);

        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }
    }

    if (count($err) === 0){
        //最新の質問を取得する処理
        $hasCreated = QuestionLogic::newQuestion();

        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問投稿完了</title>
</head>
<body>


<div>投稿完了</div>
<div>以下の内容で投稿が完了しました</div>
  <div>題名：<?php echo $title ?></div>
  <div>カテゴリ：<?php echo $category ?></div>
  <div>本文：<?php echo $message ?></div>

  <form method="post" name="form1" action="../question_disp.php">
    <input type="hidden" name="question_id" value="<?php echo $data['question_id']; ?>">
    <a href="javascript:form1.submit()">詳細画面へ</a>
  </form>
<a href="../login_top.php">TOP</a>


<?php


?>
</body>
</html>