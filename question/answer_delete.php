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

  $answer_id = filter_input(INPUT_POST, 'answer_id');
  if(empty($answer_id)) {
    $err[] = '質問を選択し直してください';
  }

  if (count($err) === 0){
    //質問を引っ張る処理
    $answer = QuestionLogic::displayOneAnswer($_POST['answer_id']);
    if(empty($answer)){
        $err[] = '質問の読み込みに失敗しました';
    }
  }

  if(isset($_POST['a_dlt_conf'])){
    if(!$_SESSION['a_data']['answer_id']) {
        $err['a_id'] = '返答が選択されていません';
    }

    $dlt = QuestionLogic::deleteOneAnswer($_POST['answer_id']);
    if(empty($dlt)){
      $err[] = '返答の削除に失敗しました';
    }

    if (count($err) === 0){
        header('Location: answer_delete_comp.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>返答削除</title>
</head>
<body>

<div>返答内容</div>
<form method="POST" action="">
<div>
  <?php if(isset($err['a_id'])): ?>
  <?php echo $err['a_id'] ?>
  <?php endif; ?>
</div>
  <div><?php if(isset($err['message'])): ?>
    <?php echo $err['message'] ?>
    <?php endif; ?>
  </div>
  <div>本文：<?php echo $answer['message'] ?></div>
  <input type="hidden" name="answer_id" value="<?php echo $answer_id ?>">
  <input type="submit" name="a_dlt_conf">
</form>
<button type="button" onclick="history.back()">戻る</button>