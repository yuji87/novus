<?php
session_start();

//ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/QuestionLogic.php';
require_once '../../app/Functions.php';

// エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったらログイン画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: userLogin/form.php');
    return;
}
$login_user = $_SESSION['login_user'];
$question_id = filter_input(INPUT_GET, 'question_id');

//自身が投稿した質問を表示
$question = QuestionLogic::userQuestion();
if (!$question) {
    $err[] = 'まだ投稿した質問はありません';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/top.css">
    <title>過去の質問履歴</title>
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
            <li class="top"><a href="../userLogin/home.php">TOPページ</a></li>
            <li><a href="../userEdit/list.php">会員情報 編集</a></li>
            <li><a href="../../study-main/ARTICLE/ahistory.php">【 履歴 】質問</a></li>
            <li><a href="#contact">【 履歴 】記事</a></li>
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
                <h2 class="heading">HISTORY OF QUESTION</h2>
                <div class="list">
                    <!--ユーザーが投稿した質問を表示-->
                    <div class="text">
                        <div class="fw-bold mb-4">質問履歴</div>
                        <?php if($err > 0): ?>
                            <?php echo 'まだ投稿した質問はありません'; ?>
                        <?php endif; ?> 
                        <?php if(isset($question)): ?>
                            <?php foreach($question as $value): ?>
                            <?php var_dump($question) ?>
                            <!--題名-->
                            <div>題名：<?php echo $value['title']; ?></div>
                            <!--カテゴリ-->
                            <div>カテゴリ：<?php echo $value['category_name']; ?></div>
                            <!--本文-->
                            <div>本文：<?php echo $value['message']; ?></div>
                            <!--日付-->
                            <?php if (!isset($value['upd_date']) && isset($value['post_date'])): ?>
                            <div>日付：<?php echo $value['post_date']  ?></div>
                            <?php elseif (isset($value['upd_date'])): ?>
                            <div>日付：<?php echo $value['upd_date'] ?></div>
                            <?php endif; ?>
                            <!--名前-->
                            <div>名前：<?php echo $value['name']; ?></div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- フッタ -->
    <footer class="h-10"><hr>
		<div class="footer-item text-center">
			<h4>Q&A SITE</h4>
			<ul class="nav nav-pills nav-fill">
                <li class="nav-item">
				    <a class="nav-link small" href="../article/index.php">記事</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link small" href="index.php">質問</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link small" href="../bookApi/index.php">本検索</a>
			    </li>
			    <li class="nav-item">
			    	<a class="nav-link small" href="../contact/index.php">お問い合わせ</a>
			    </li>
			</ul>
		</div>
		<p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>
    </footer>
</body>
</html>
