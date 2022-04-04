<?php
namespace Novus;

require_once "Action.php";
require_once "Utils.php";

// 記事/いいね関連クラス
class BookApiAct extends Action
{
  function __construct($mode = -1) {
    if ($mode >= 0) {
      $this->begin($mode);
    }
  }

  // ページ表示がないファイルは、mode=1で呼ぶ
  //footer
  function end($mode = 0) {
    if ($mode == 0) {
      // echo '<hr/>';
      echo '<div class="row m-2">';
        if(isset($_SESSION['login_user'])){
          echo '<div class="col-sm-1"></div>';
          echo '<div class="col-sm-11">';
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
    echo '<hr><footer class="h-10">';
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

  // head,body開始タグ
  function printHeader() {
    echo '<!DOCTYPE html>';
    echo '<html lang="ja">';
    echo '<head>';
    echo '<meta charset=UTF-8" http-equiv="Content-Type">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<meta name="format-detection" content="telephone=no">';
    echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">';
    echo '<link rel="stylesheet" href="' . DOMAIN . '/public/css/bookApi.css">';
    // echo '<link rel="stylesheet" href="' . DOMAIN . '/public/css/novus.css">';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>';
    echo '<script src= "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>';
    echo '<script src="' . DOMAIN . '/public/bookApi/js/script.js" defer></script>';
    echo '<script src="' . DOMAIN . '/public/JS/qapi.js" defer></script>';
    echo '<title>' . SYSTITLE . '</title>';
    echo '</head>';
    echo '<body><div class="container">';
  }
}
