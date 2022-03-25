<?php 
session_start();
$self_url = $_SERVER["PHP_SELF"];

if(isset($_POST["username"]) && isset($_POST["pwd"]) && $_POST["username"] === "test" && $_POST["pwd"] === "pwd"){
  $_SESSION["todo"] = [
    "name" => $_POST["username"],
    "pwd" => $_POST["pwd"]
  ];
}
var_dump($_POST["username"]);
var_dump($_POST["pwd"]);
var_dump($_SESSION["todos"]);

if(!empty($_SESSION["todo"])){
  echo "<br>ログインできてる<br>";
} else{
  echo "<br>ログインできてない<br>";
}
echo "<a href='login.php'>戻る</a>";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/style.css">
  <title>todo</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous" defer></script>
  <script src="https://code.jquery.com/jquery-3.1.0.js" defer></script>
  <script src="JS/post.js" defer></script>
</head>

<main>
  <div class="container text-center mt-5">
    <ul>
      <?php
       for($i = 0; $i < count($_SESSION["todos"]) ; $i++): 
       ?>
      <li>
        <form method="POST" action="<?php echo $self_url ?>">
          <input type="hidden" name="id" value="<?php echo $i ?>"> <!-- どのアイテムが選択されるか -->
          <input type="text" name="title" value="<?php echo $_SESSION["todos"][$i] ?>">
          <input type="submit" name="type" value="追加">
          <input type="submit" name="type" value="削除">
        </form>
      </li>
      <?php 
      endfor 
      ?>
    </ul>
    <?php
      // ↓ 受け取るロジック ↓
      if(isset($_POST["type"])){
        if($POST["type"] === "create"){
          $_SESSION["todos"][] = $_POST["title"]; //配列に対して要素を追加する
          echo "新しいタスク[{$_POST["title"]}]が追加されました";
        } elseif($POST["type"] === "update"){
          $id = $_POST["id"];
          $_SESSION["todos"][$_POST["id"]] = $_POST["title"];
          echo "タスク[{$_POST["title"]}]の名前が変更されました";
        } elseif($_POST["type"] === "delete"){
          array_splice($_SESSION["todos"], $_POST["id"], 1); //ひとつ削除
          echo "タスク[{$_POST["title"]}]が削除されました";
        }
      }
      if(empty($_SESSION["todos"])){
        $_SESSION["todos"] = [];
        echo "タスクを入力してください";
        die();
      }
    ?>

  </div>
</main>