<?php
    session_start();

    //ファイルの読み込み
    require_once '../classes/QuestionLogic.php';

    //error
    $err = [];

    if (isset($_SESSION['q_data']['user_id']) &&
      isset($_SESSION['q_data']['title']) &&
      isset($_SESSION['q_data']['category']) &&
      isset($_SESSION['q_data']['message'])
      ){
        $title = $_SESSION['q_data']['title'];
        $category = $_SESSION['q_data']['category'];
        $message = $_SESSION['q_data']['message'];

        //質問を登録する処理
        $hasCreated = QuestionLogic::createQuestion();

        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }
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

  <form method="GET" name="form1" action="question_disp.php">
    <input type="hidden" name="question_id" value="<?php echo $hasCreated[0]['question_id']; ?>">
    <a href="javascript:form1.submit()">詳細画面へ</a>
  </form>
<a href="../login_top.php">TOP</a>


<?php


?>
</body>
</html>