<?php

session_start();

//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../functions.php';

//ログインしているか判定して、していなかったらログインへ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userCreate/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//セッションに保存データがあるかを確認
if (isset($_SESSION['commentEdit'])) {
    //セッションから情報を取得
    $name = $_SESSION['commentEdit'];
} else {
    //セッションがなかった場合
    $name = array();
}

//エラーメッセージ表示
$err = $_SESSION;

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
            <li class="top"><a href="../userLogin/login_top.php">TOPページ</a></li>
            <li><a href="../userLogin/mypage.php">MyPageに戻る</a></li>
            <li><a href="#projects">質問 履歴</a></li>
            <li><a href="#contact">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form action="../login/logout.php" method="POST">
                    <input type="submit" name="logout" value="ログアウト">
                </form>
            </li>
        </ul>
    </header>

    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">アカウント編集画面</h2>
                <form action="../editConfirm/commentConfirm.php" method="POST">
                    <input type="hidden" name="formcheck" value="checked">
                    <div class="list">
                        <!--ユーザーが登録した名前を表示-->
                        <div class="text">
                            <label for="comment" style="float:left; padding-left:30px; padding-bottom:10px;">Comment :</label>
                            <input id="comment" type="text" name="comment" value="<?php echo htmlspecialchars($login_user['comment'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <br><br>
                        <input type="submit" value="変更">
                    </div>
                </form>
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
