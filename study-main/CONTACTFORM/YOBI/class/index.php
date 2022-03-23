<?php 

require_once("config.php");

//db, contacts, Utilsクラスが出てきたらcontactsAppが入るようにする
use contactsApp\db;
use contactsApp\contacts;
use contactsApp\Utils;

$pdo = db::getInstance();

$contacts = new contacts($pdo); //contactsクラスのインスタンスを作成
$contacts->processPost(); // POSTで送信されたデータを処理するメソッド
// $contactss = $contacts->getAll(); //contactsを表示するために配列を取得するメソッド
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>

<body>
  <main>

    <!-- ここで入力 -->
    <form method="POST" action="?action=confirm">
      <input id="name" type="text" name="fullname" value="" class="" placeholder="NAME"><br>
      <input id="email" type="email" name="email" value="" class="" placeholder="E-MAIL"><br>
      <textarea id="message" type="text" name="message" placeholder="MESSAGE"></textarea><br>
      <input id="submit" type="submit" name="confirm" value="送信内容を確認" class="">
      <input type="hidden" name="token" value="<?= Utils::h($_SESSION["token"])?>">
    </form>

  </main>
</body>
</html>
