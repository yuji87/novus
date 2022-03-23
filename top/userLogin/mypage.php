<?php

session_start();
//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../functions.php';

$name = filter_input(INPUT_POST, 'name');
$icon = filter_input(INPUT_GET, 'icon');

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: userCreate/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//画像が入っていたら表示
$showicon = UserLogic::showIcon();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/mypage.css" />
    <title>My Page</title>
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
            <li class="top"><a href="login_top.php">TOPページ</a></li>
            <li><a href="../userEdit/edit_user.php">会員情報 編集</a></li>
            <li><a href="../../question/qhistory.php">質問 履歴</a></li>
            <li><a href="../../">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form action="logout.php" method="POST">
                    <input type="submit" name="logout" value="ログアウト">
                </form>
            </li>
        </ul>
    </header>



    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">MY ACCOUNT</h2>
                <div class="list">
                    <!--ユーザーが登録した画像を表示-->
                    <div class="list-item">
                        <?php if (isset($login_user['icon'])): ?> 
                            <img src="../img/<?php echo $login_user['icon']; ?>">
                        <?php else: ?>
                        <?php echo "<img src="."../img/sample_icon.png".">"; ?>
                        <?php endif; ?>
                    </div>
                    <!--ユーザーが登録した名前を表示-->
                    <div class="text">
                        名前：<?php echo htmlspecialchars($login_user['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <!--ユーザーの現レベルを表示-->
                    <div class="text">
                        Lv.<?php
                           if (isset($login_user['level'])) {
                               echo htmlspecialchars($login_user['level'], ENT_QUOTES, 'UTF-8'); 
                           } else {
                               echo '1';
                           } ?>
                    </div>
                    <div class="text">
                        コメント：<?php
                            if (isset($login_user['comment'])) {
                               echo htmlspecialchars($login_user['comment'], ENT_QUOTES, 'UTF-8'); 
                            } else {
                               echo 'Let us introduce yourself!';
                            } ?>
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
