<?php
session_start();

// ファイルの読み込み
require_once '../../app/QuestionLogic.php';
require_once '../../app/CategoryLogic.php';
require_once '../../app/UserLogic.php';

// エラーメッセージ
$err = [];

// ログインチェック
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}

$question_id = filter_input(INPUT_POST, 'question_id', FILTER_SANITIZE_SPECIAL_CHARS);
if(!$question_id == filter_input(INPUT_POST, 'question_id', FILTER_SANITIZE_SPECIAL_CHARS)) {
    $err[] = '質問を選択し直してください';
}
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/top.css">
    <link rel="stylesheet" type="text/css" href="../css/question.css">
    <title>質問削除</title>
</head>

<body>
    <!--メニュー-->
    <header>
        <div class="navtext-container">
            <div class="navtext">novus</div>
        </div>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="top"><a href="../userLogin/home.php">TOPページ</a></li>
            <li><a href="../myPage/index.php">マイページ</a></li>
            <li><a href="../todo/index.php">TO DO LIST</a></li>
            <li>
                <form type="hidden" action="../userLogin/logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <p class="h4 pb-3 mt-3">削除完了</p>
                <p>削除が成功しました</p>
                <button type="button" onclick="location.href='../userLogin/home.php'">TOP</button>
                <button type="button" onclick="location.href='index.php'">質問へ</button>
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

