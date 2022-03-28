<?php

  session_start();

  //ファイルの読み込み
  require_once '../../classes/QuestionLogic.php';

  //error
  $err = [];

  $question_id = filter_input(INPUT_GET, 'question_id');
  if(!$question_id = filter_input(INPUT_GET, 'question_id')) {
    $err[] = '質問を選択し直してください';
  }
  if (count($err) === 0){
    //質問を引っ張る処理
    $question = QuestionLogic::displayQuestion($_GET);
      if(!$question){
        $err['question'] = '質問の読み込みに失敗しました';
      }
    // 質問への返答を引っ張る処理
    $answer = QuestionLogic::displayAnswer($_GET);
      if(!$answer){
        $err['answer'] = '返信の読み込みに失敗しました';
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
  <?php if(isset($err['question'])):  ?>
    <?php echo $err['question'] ?>
  <?php endif; ?>
  <!-- 質問表示 -->
  <div>質問内容</div>
    <div>題名：<?php echo $question['title'] ?></div>
    <div>カテゴリ：<?php echo $question['category_name'] ?></div>
    <div>本文：<?php echo htmlspecialchars($question['message'], \ENT_QUOTES, 'UTF-8') ?></div>
    <!-- 更新されていた場合、その日付を優先表示 -->
    <div>
    <?php if (!isset($question['upd_date'])): ?>
        投稿：<?php echo $question['post_date']  ?>
    <?php else: ?>
        更新：<?php echo $question['upd_date'] ?>
    <?php endif; ?>
    </div>
    <div>名前：<?php echo $question['name'] ?></div>
    <div>アイコン：
      <!-- アイコン設定時、アイコン表示 -->
      <?php if(!isset($question['icon'])): ?>
        <!-- 現在、アイコンからの時にPost_date表示する仮置き状態 -->
        <?php echo $question['post_date']  ?>
      <?php else: ?>
        <?php echo $question['icon'] ?>
      <?php endif; ?>
    </div>

    <!-- 質問者本人の時、編集・削除ボタン表示 -->
    <?php if($_SESSION['login_user']['user_id'] == $question['user_id']): ?>
      <form method="POST" name="question" action="question_edit.php">
        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
        <input type="submit" value="編集">
      </form>
      <form method="POST" name="question" action="question_delete.php">
        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
        <input type="submit" value="削除">
      </form>
    <?php endif; ?>

    <!-- 返答表示部分 -->
    <?php if(!empty($answer)): ?>
      <?php if(isset($err['answer'])):  ?>
        <?php echo $err['answer'] ?>
      <?php endif; ?>
      <?php foreach($answer as $value){ ?>
        <!-- いいねの検索（返答ごと） -->
        <?php $likes = QuestionLogic::displayLike($value['answer_id']); ?>
        <div>名前：<?php echo $value['name'] ?></div>
        <div>アイコン：
          <!-- 現在、アイコン空の時にanswer_dateを仮置き状態 -->
          <?php if(!isset($value['icon'])): ?>
            <?php echo $value['answer_date']  ?>
          <?php else: ?>
            <?php echo $value['icon'] ?>
          <?php endif; ?>
        </div>
        <div>本文：<?php echo htmlspecialchars($value['message'], \ENT_QUOTES, 'UTF-8') ?></div>
        <div>
          <!-- 更新されていた場合、その日付を優先表示 -->
          <?php if (!isset($value['upd_date'])): ?>
            投稿：<?php echo $value['answer_date']  ?>
          <?php else: ?>
            更新：<?php echo $value['upd_date'] ?>
          <?php endif; ?>
        </div>
        <div>いいね数：<?php echo count($likes) ?></div>
        <?php if($value['best_flg']): ?>
          <div>ベストアンサー選択されてます！！！！！</div>
        <?php endif; ?>
        <!-- 質問者本人 ＆ 返答が質問者以外の場合 -->
        <!-- ベストアンサーボタンの表示 -->
        <?php if($_SESSION['login_user']['user_id'] == $question['user_id'] && $question['best_select_flg'] == 0 && $_SESSION['login_user']['user_id'] != $value['user_id']  ): ?>
          <form method="POST" action="best_answer.php">
            <input type="hidden" name="question_id" value="<?php echo $question_id ?>">
            <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
            <input type="submit" value="ベストアンサー">
          </form>
        <?php endif; ?>

        <!-- 本人の返答に対して、返答の編集・削除ボタン表示 -->
        <?php if($_SESSION['login_user']['user_id'] == $value['user_id']): ?>
          <form method="POST" action="answer_edit.php">
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
            <input type="submit" name="a_edit" value="編集">
          </form>
          <form method="POST" action="answer_delete.php">
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
            <input type="submit" name="a_edit" value="削除">
          </form>
        <?php endif; ?>
        <div>----------------</div>
      <?php }; ?>
    <?php endif; ?>

  <!-- ベストアンサーが選択されていると新規投稿できなくなる処理 -->
  <?php if($question['best_select_flg'] == 0): ?>
    <form method="POST" action="answer_create_conf.php">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user']['user_id']; ?>">
      <input type="hidden" name="question_id" value="<?php echo $question['question_id'] ?>">
      <textarea placeholder="ここに返信を入力してください" name="a_message"></textarea>
      <input type="submit">
    </form>
  <?php endif; ?>

  <button type="button" onclick="location.href='question_search.php'">戻る</button>
</body>

