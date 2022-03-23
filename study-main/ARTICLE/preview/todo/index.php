<?php 

require_once("config.php");

//db, Todo, Utilsクラスが出てきたらMyAppTodoが入るようにする
use TodoApp\db;
use TodoApp\Todo;
use TodoApp\Utils;

$pdo = db::getInstance();

$todo = new Todo($pdo); //todoクラスのインスタンスを作成
$todo->processPost(); // POSTで送信されたデータを処理するメソッド
$todos = $todo->getAll(); //todoを表示するために配列を取得するメソッド
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>todo</title>
</head>

<body>
  <main>
    <header>
      <h1>todos</h1>
      <form method="POST" action="?action=purge">
        <span class="delete">一括削除</span>
        <input type="hidden" name="token" value="<?= Utils::h($_SESSION["token"])?>">
      </form>
    </header>

    <!-- ここで新規投稿 -->
    <form method="POST" action="?action=add">
      <input type="text" name="title" placeholder="新しいtodo">
      <input type="hidden" name="token" value="<?= Utils::h($_SESSION["token"])?>">
    </form>

    <ul>
      <?php foreach($todos as $todo): ?>
        <li>
          <form method="POST" action="?action=toggle">
            <!-- 条件演算子 is_doneが true→checked, false→空文字列 -->
            <input type="checkbox" <?= $todo->is_done ? 'checked':' ';  ?>>
            <input type="hidden" name="id" value="<?= Utils::h($todo->id) ?>">
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION["token"])?>">
          </form>

          <span class="<?= $todo->is_done ? 'done' : ' ' ?>">
            <?= Utils::h($todo->title) ?>
          </span>

          <form method="POST" action="?action=delete" class="delete-form">
            <span class="delete"> x </span>
            <input type="hidden" name="id" value="<?= Utils::h($todo->id) ?>">
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION["token"])?>">
          </form>
        </li>
      <?php endforeach ?>
    </ul>
  </main>
</body>
</html>
