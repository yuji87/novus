<?php
  session_start();

  //ファイルの読み込み
  require_once '../classes/QuestionLogic.php';

  //error
  $err = [];

  $question_id = filter_input(INPUT_GET, 'question_id');

  if(!$question_id = filter_input(INPUT_GET, 'question_id')) {
    $err[] = '質問を選択し直してください';
  }

  if (count($err) === 0){
    //質問を引っ張る処理
    $question = QuestionLogic::displayQuestion($_GET);
    $answer = QuestionLogic::displayAnswer($_GET);

    if(!$question){
        $err[] = '質問の読み込みに失敗しました';
    }
    if(!$answer){
        $err[] = '返信の読み込みに失敗しました';
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問表示</title>
</head>
<body>

<div>質問内容</div>
  <div>題名：<?php echo $question['title'] ?></div>
  <div>カテゴリ：<?php echo $question['category_name'] ?></div>
  <div>本文：<?php echo $question['message'] ?></div>
  <div>日付：
    <?php if (!isset($question['upd_date'])): ?>
      <?php echo $question['post_date']  ?>
    <?php else: ?>
      <?php echo $question['upd_date'] ?>
    <?php endif; ?>
  </div>
  <div>名前：<?php echo $question['name'] ?></div>
  <div>アイコン：
    <?php if(!isset($question['icon'])): ?>
      <?php echo $question['post_date']  ?>
    <?php else: ?>
      <?php echo $question['icon'] ?>
    <?php endif; ?>
  </div>

  <?php //if($_SESSION['id'] == $question['user_id']): ?>
    <form method="POST" name="question" action="question_edit.php">
      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
      <input type="submit" value="編集">
    </form>
    <form method="POST" name="question" action="question_edit.php">
      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
      <input type="submit" value="削除">
    </form>
  <?php //endif; ?>
    
  <?php if(isset($answer)): ?>
    <?php foreach($answer as $value){ ?>
      <?php $likes = QuestionLogic::displayLike($value['answer_id']); ?>
      <div>名前：<?php echo $value['name'] ?></div>
      <div>アイコン：
        <?php if(!isset($value['icon'])): ?>
          <?php echo $value['answer_date']  ?>
        <?php else: ?>
          <?php echo $value['icon'] ?>
        <?php endif; ?>
      </div>
      <div>本文：<?php echo $value['message'] ?></div>
      <div>
        <?php if (!isset($value['upd_date'])): ?>
          投稿：<?php echo $value['answer_date']  ?>
        <?php else: ?>
          更新：<?php echo $value['upd_date'] ?>
        <?php endif; ?>
      </div>
      <div>いいね数：<?php echo count($likes) ?></div>
      <?php if($_SESSION['id'] == $value['user_id']): ?>
        <form method="POST">
          <input type="hidden" name="answer" value="<?php $question['question_id'] ?>">
          <a href="../answer_edit.php" onclick="document.a_form.submit();">編集</a>
          <a href="../answer_delete.php" onclick="document.a_form.submit();">削除</a>
        </form>
      <?php endif; ?>
      <div>----------------</div>
    <?php }; ?>
  <?php endif; ?>

<form method="POST" action="answer_create.php">
  <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
  <input type="hidden" name="question_id" value="<?php echo $question['question_id'] ?>">
  <textarea placeholder="ここに返信を入力してください" name="a_message"></textarea>
  <input type="submit">
</form>