<?php
require_once("config.php");
$pdo = db::getInstance();

$mode = 'input';

$error      = [];
$errmessage = [];

$back    = filter_input(INPUT_POST, "back");
$confirm = filter_input(INPUT_POST, "confirm");
$name    = filter_input(INPUT_POST, "name");
$email   = filter_input(INPUT_POST, "email");
$message = filter_input(INPUT_POST, "message");
$send    = filter_input(INPUT_POST, "send");
$token   = filter_input(INPUT_POST, "token");

if (isset($back) && $back) { //戻るボタンが押されたとき
  // 何もしない
} else if (isset($confirm) && $confirm) { //confirmで送られてきた時
  require_once("PROCESS/confirmProcess.php");
} else if (isset($send) && $send) { //sendで送られてきた時
  require_once("PROCESS/sendProcess.php");
} else {
  $_SESSION['name']     = "";
  $_SESSION['email']    = "";
  $_SESSION['message']  = "";
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../CSS/contactForm.css">
  <title>お問い合わせフォーム</title>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
</head>

<body>
  <main class="">
    <!-- $modeがinputを持つ時は下記を表示 -->
    <?php if ($mode === 'input') : ?>
      <?php
      if ($errmessage) {
        echo '<div class="text-center" role="alert">';
        echo implode('<br>', $errmessage);
        echo '</div>';
      }
      ?>

      <h1 class="text-center mt-5">
        お問い合わせ
      </h1>
      <form action="./contactForm.php" method="post" id="form" class="mt-3 text-center" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo $_SESSION['name'] ?>" class="mt-2" placeholder="name"><br>
        <?php require_once("ERRMESSAGE/nameErr.php") ?>

        <input type="email" name="email" value="<?php echo $_SESSION['email'] ?>" class="mt-2" placeholder="E-MAIL"><br>
        <?php require_once("ERRMESSAGE/emailErr.php") ?>

        <textarea type="text" name="message" class="mt-2" placeholder="MESSAGE" cols="50" rows="10" maxlength="1000"><?php echo $_SESSION['message'] ?></textarea><br>
        <?php require_once("ERRMESSAGE/messageErr.php") ?>

        <input type="submit" name="confirm" value="送信内容を確認" class="mt-1">
      </form>

      <!-- $modeがconfirmを持つ時は下記を表示 -->
    <?php elseif ($mode === 'confirm') : ?>

      <!-- 確認画面 -->
      <h1 class="text-center mt-5">
        内容の確認
      </h1>
      <form action="./contactForm.php" method="post" class="mt-3" style="font-size:1.5em; font-weight:bold">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <div class="col-sm-4 offset-sm-2 col-md-3 offset-md-3 col-lg-4 offset-lg-5">
          <div class="mt-2">NAME：<?php echo $_SESSION['name'] ?></div>
          <div class="mt-2">email：<?php echo $_SESSION['email'] ?></div>
          <div class="mt-2">content：<?php echo nl2br($_SESSION['message']) ?></div>
        </div>
        <div class="mt-3 text-center">
          <input id="submit" type="submit" name="back" class="mr-1" value="戻る">
          <input id="submit" type="submit" name="send" class="ml-1" value="送信">
        </div>
      </form>

      <!-- $modeがsendを持つ時は下記を表示 -->
    <?php else : ?>

      <!-- 送信完了 or 失敗 -->

    <?php endif ?>


  </main>
</body>