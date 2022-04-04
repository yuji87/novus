<?php
namespace Novus;

require_once "Action.php";
require_once "Utils.php";


// データ更新系
define("INSERT_CONTACT", "INSERT INTO contacts(name, email, title, contents) VALUES(:name, :email, :title, :contents)");

class ContactAct extends Action
{
  function __construct($mode = -1) {
    if ($mode >= 0) {
      $this->begin($mode);
    }
  }

  // 入力内容送信
  function create($name, $email, $title, $contents)
  {
    // 登録
    $stmt = $this->conn->prepare(INSERT_CONTACT);
    $stmt->bindValue("name", $name, \PDO::PARAM_STR);
    $stmt->bindValue("email", $email, \PDO::PARAM_STR);
    $stmt->bindValue("title", $title, \PDO::PARAM_STR);
    $stmt->bindValue("contents", $contents, \PDO::PARAM_STR);
    $stmt->execute();
  }

  // ページ表示がないファイルは、mode=1で呼ぶ
  //footer
  function end($mode = 0) {
    if ($mode == 0) {
      echo '<hr/>';
      echo '<div class="row m-2">';
        if(isset($_SESSION['login_user'])){
          echo '<div class="col-sm-8">';
            echo '<a class="btn btn-success m-2" href="' . DOMAIN . '/public/userLogin/home.php">ホーム画面へ</a>';
          echo '</div>';
        }else{
          echo '<div class="col-sm-8">';
            echo '<a class="btn btn-success m-2" href="' . DOMAIN . '/public/user/top.php">ホーム画面へ</a>';
          echo '</div>';
        }
      echo '</div>';
    }
    echo '</div>';
    echo '<footer class="h-10">';
    echo '<div class="footer-item text-center">';
    echo '<h4>novus</h4>';
    echo '<ul class="nav nav-pills nav-fill">';
    echo '<li class="nav-item">';
    echo '<a class="nav-link small" href="../article/index.php">記事</a>';
    echo '</li>';
    echo '<li class="nav-item">';
    echo '<a class="nav-link small" href="../question/index.php">質問</a>';
    echo '</li>';
    echo '<li class="nav-item">';
    echo '<a class="nav-link small" href="../bookApi/index.php">本検索</a>';
    echo '</li>';
    echo '<li class="nav-item">';
    echo '<a class="nav-link small" href="../contact/index.php">お問い合わせ</a>';
    echo '</li>';
    echo '</ul>';
    echo '</div>';
    echo '<p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>';
    echo '</footer>';
    echo '</body>';
    echo '</html>';
  }

  // head,bodyまで出力する
  function printHeader() {
    echo '<!DOCTYPE html>';
    echo '<html lang="ja">';
    echo '<head>';
    echo '<meta charset=UTF-8" http-equiv="Content-Type">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta name="format-detection" content="telephone=no">';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">';
    echo '<link href="' . DOMAIN . '/public/css/contact.css" rel="stylesheet">';
    echo '<link href="' . DOMAIN . '/public/css/novus.css" rel="stylesheet">';
    echo '<script src="' . DOMAIN . '/public/contact/js/script.js" defer></script>';
    echo '<title>' . SYSTITLE . '</title>';
    echo '</head>';
    echo '<body><div class="container">';
  }
}
