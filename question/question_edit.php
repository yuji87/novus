<?php
    session_start();

    //ファイルの読み込み
    require_once '../classes/QuestionLogic.php';
    require_once '../classes/UserLogic.php';

    $result = UserLogic::checkLogin();
    if($result) {
    header('Location: login_top.html');
    return;
    }

    //error
    $err = [];

    $question_id = filter_input(INPUT_GET, 'question_id');
    if(!$question_id = filter_input(INPUT_GET, 'question_id')) {
      $err[] = '質問を選択し直してください';
  }

  if (count($err) === 0){
    //質問を引っ張る処理
    $question = QuestionLogic::displayQuestion($_POST);
    if(!$question){
        $err[] = '質問の読み込みに失敗しました';
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問編集</title>
</head>
<body>

<div>質問内容</div>
<form method="POST" action="">
  <div>題名：<input type="text" name="title" value="<?php echo $question['title'] ?>" required></div>
  <div>カテゴリ： 
    <select name="category" value="<?php echo $question['cate_id'] ?>" required>
      <option></option>
      <option value="1">項目1</option>
      <?php foreach($categories as $value){
          echo "<option value=".$value['cate_id'] .">" .$value['categpry_name'] ."</option>";
      } ?>
    </select>
    <?php echo $question['category_name'] ?></div>
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

  
    
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
      <input type="hidden" name="question_id" value="<?php echo $question['question_id'] ?>">
      <textarea placeholder="ここに返信を入力してください" name="a_message"></textarea>
      <input type="submit">
    </form>