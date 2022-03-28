<?php

session_start();
//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../classes/ArticleLogic.php';
require_once '../../functions.php';

//エラー
$err = [];

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../../userCreate/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];
$article_id = filter_input(INPUT_GET, 'article_id');


//自身が投稿した記事を表示
$article = ArticleLogic::userArticle();
if (isset($article['title']) || isset($article['category_name']) || isset($article['message']) || isset($article['upd_date']) || isset($article['post_date']) || isset($article['name'])) {
if (!$article) {
    $err[] = 'まだ投稿した記事はありません';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/mypage.css" />
    <link rel="stylesheet" type="text/css" href="../../css/top.css" />
    <title>過去の記事履歴</title>
</head>

<body>
    <!--メニュー-->
    <header>
        <div class="navtext-container">
            <div class="navtext">Q&A SITE</div>
        </div>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="top"><a href="../../top/userLogin/login_top.php">TOPページ</a></li>
            <li><a href="../../userEdit/edit_user.php">会員情報 編集</a></li>
            <li><a href="../../question/view/qhistory.php">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">HISTORY OF ARTICLE</h2>
                <div class="list">
                    <!--ユーザーが投稿した質問を表示-->
                    <div class="text">
                        <div>記事履歴</div>
                        <div>題名：<?php echo $article['title'] ?></div>
                        <div>カテゴリ：<?php echo $article['category_name'] ?></div>
                        <div>本文：<?php echo $article['message'] ?></div>
                        <div>日付：
                          <?php if (!isset($article['upd_date'])): ?>
                            <?php echo $article['post_date']  ?>
                          <?php else: ?>
                            <?php echo $article['upd_date'] ?>
                          <?php endif; ?>
                        </div>
                        <div>名前：<?php echo $article['name'] ?></div>
                        <div>アイコン：
                          <?php if(!isset($article['icon'])): ?>
                            <?php echo $article['post_date']  ?>
                          <?php else: ?>
                            <?php echo $article['icon'] ?>
                          <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<!-- フッタ -->
    <footer>
        <div class="">
            <br><br><hr>
	        <p class="text-center">Copyright (c) HTMQ All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>