<?php

session_start();

//ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/Functions.php';

//ログインしているか判定して、していなかったらログインへ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}

$login_user = $_SESSION['login_user'];

//セッションに保存データがあるかを確認
if (isset($_SESSION['commentEdit'])) {
    //セッションから情報を取得
    $comment = $_SESSION['commentEdit'];
} else {
    //セッションがなかった場合
    $comment = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css" />
    <link rel="stylesheet" type="text/css" href="../css/top.css" />
    <title>会員情報変更[comment]</title>
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
            <li><a href="../userLogin/mypage.php">MyPageに戻る</a></li>
            <li><a href="#projects">質問 履歴</a></li>
            <li><a href="#contact">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form type="hidden" action="../userLogin/logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">アカウント編集画面</h2>
                <form action="../userEdit/commentC.php" method="POST">
                    <input type="hidden" name="formcheck" value="checked">
                    <div class="list">
                        <!--ユーザーが登録した名前を表示-->
                        <div class="text">
                            <label for="comment" style="text-align:center">[comment]</label>
                            <p><input id="editdetail" type="text" name="comment" class="w-100" value="<?php echo htmlspecialchars($login_user['comment'], ENT_QUOTES, 'UTF-8'); ?>"></p>
                        </div>
                        <br><br>
                        <a href="list.php" id="back">戻る</a>
                        <p><input type="submit" value="変更"></p>
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
