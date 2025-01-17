<?php
session_start();

// ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/QuestionLogic.php';
require_once '../../app/Functions.php';

// エラーメッセージ
$err = [];

// ログインしているか判定して、していなかったらログイン画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}
$login_user = $_SESSION['login_user'];
$question_id = filter_input(INPUT_GET, 'question_id');

// 自身が投稿した質問を表示
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
    <link rel="stylesheet" type="text/css" href="../css/question.css">
    <title>過去の質問履歴</title>
</head>

<body>
	<!--メニュー-->
    <header>
        <div class="navbar bg-dark text-white">
            <div class="navtext h2" id="headerlogo">novus</div>
            <ul class="nav justify-content-center">
			<li id="li"><a class="nav-link active small text-white" href="../userLogin/home.php">TOPページ</a></li>
			<li id="li"><a class="nav-link active small text-white" href="../userEdit/index.php">【編集】会員情報</a></li>
            <li id="li"><a class="nav-link small text-white" href="qHistory.php">【履歴】質問</a></li>
            <li id="li"><a class="nav-link small text-white" href="aHistory.php">【履歴】記事</a></li>
            <li id="li"><a class="nav-link small text-white" href="../todo/index.php">TO DO LIST</a></li>
            <li id="li"><a class="nav-link small text-white" href="<?php echo "logout.php?=user_id=".$login_user['user_id']; ?>">ログアウト</a></li>
        </ul>
        </div>
    </header>

    <div class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading mt-5">HISTORY OF QUESTION</h2>
                <div class="list">
                    <!--ユーザーが投稿した質問を表示-->
                    <div class="text">
                        <div class="fw-bold mb-4">質問履歴</div>
                        <?php if(isset($question)): ?>
                            <?php foreach($question as $value): ?>
                            <!--題名-->
                            <div class="fw-bold pb-1"><a href="qdisp.php? question_id=<?php echo $value['question_id']; ?>">題名</a></div>
                            <div><?php echo $value['title']; ?></div>
                            <!--カテゴリ-->
                            <div class="fw-bold pt-3 pb-1">カテゴリ</div>
                            <div><?php echo $value['category_name']; ?></div>
                            <!--本文-->
                            <div class="fw-bold pt-3 pb-1">本文</div>
                            <div><?php echo $value['message']; ?></div>
                            <!--日付-->
                            <?php if(!isset($value['upd_date']) && isset($value['post_date'])): ?>
                            <div class="pt-4 pb-1 small">投稿日付：<?php date('Y/m/d H:i', strtotime($value['post_date']));  ?></div>
                            <?php elseif(isset($value['upd_date'])): ?>
                            <div class="pt-4 pb-1 small">投稿日付：<?php echo date('Y/m/d H:i', strtotime($value['upd_date'])); ?></div>
                            <hr id="dot">
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- フッタ -->
    <footer class="h-10"><hr>
		<div class="footer-item text-center">
			<h4>novus</h4>
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
