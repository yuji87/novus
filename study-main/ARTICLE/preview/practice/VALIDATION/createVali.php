<?php
$error = [];
$user_id = filter_input(INPUT_POST, 'user_id');
$title = filter_input(INPUT_POST, 'title');
$category = filter_input(INPUT_POST, 'category');
$contents = filter_input(INPUT_POST, 'contents');
$image = filter_input(INPUT_POST, 'image');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  $array = array(' ', '　', "\r\n", "\r", "\n", "\t");
  $space = str_replace($array, '', $contents);

  if (trim($title) === "") {
    $error["title"] = "blank";
  } elseif (mb_strlen($title) > 500) {
    $error["title"] = "exceed";
  }
  if($category === "0"){
    $error["category"] = "blank";
  }
  if (trim($contents) === "" || $space === "") {
    $error["contents"] = "blank";
  } elseif (mb_strlen($contents) > 5000) {
    $error["contents"] = "exceed";
  }
  if (empty($error)) {
    $_SESSION["form"] = $form; //配列のデータを渡すため
    header("Location: article_comp.php"); //POSTの内容をクリア&ページ移動
    exit();
  }
}
