<?php

session_start();
//ファイル読み込み
require_once '../classes/UserLogic.php';

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
// if (!$result) {
    // $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    // header('Location: userCreate/signup_form.php');
    // return;
// }

if (isset($name) || isset($tel) || isset($email) || isset($password) || isset($icon) || isset($comment) ) {

$name = $_SESSION['edit']['name'];
$tel = $_SESSION['edit']['tel'];
$email = $_SESSION['edit']['email'];
$password = $_SESSION['edit']['password'];
$icon = $_SESSION['edit']['icon'];
$comment = $_SESSION['edit']['comment'];

// unset($_SESSION['edit']);         // セッションを破棄
// header('Location: mypage.php');   // mypage.phpへ移動
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css" />
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
            <li><a href="mypage.php">MyPageに戻る</a></li>
            <li><a href="#projects">質問 履歴</a></li>
            <li><a href="#contact">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form action="../logout.php" method="POST">
                    <input type="submit" name="logout" value="ログアウト">
                </form>
            </li>
        </ul>
    </header>



    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">確認画面</h2>
                <div class="list">
                    <!--ユーザーが登録した画像を表示-->
                    <div class="list-item">
                        <span name="name" class="check-info">
                        <?php echo htmlspecialchars($_SESSION['edit']['icon'], ENT_QUOTES); ?>
                    </span>
                    </div>
                    <!--ユーザーが登録した名前を表示-->
                    <div class="text">
                        <label for="name">Name :</label>
                        <?php echo htmlspecialchars($_SESSION['edit']['name'], ENT_QUOTES); ?>
                    </div>
                    <!--ユーザーが登録した電話番号を表示-->
                    <div class="text">
                        <label for="tel">Tel :</label>
                        <?php echo htmlspecialchars($_SESSION['edit']['tel'], ENT_QUOTES); ?>
                    </div>
                    <!--ユーザーが登録したメールアドレスを表示-->
                    <div class="text">
                        <label for="email">Email :</label>
                        <?php echo htmlspecialchars($_SESSION['edit']['email'], ENT_QUOTES); ?>
                    </div>   
                    <!--パスワード入力（非表示）-->
                    <div class="text">
                        <label for="password">Password :</label>
                        <?php echo htmlspecialchars($_SESSION['edit']['password'], ENT_QUOTES); ?>
                    </div>
                    <!--コメント-->  
                    <div class="text">
                        <label for="comment">comment :</label>
                        <?php echo htmlspecialchars($_SESSION['edit']['comment'], ENT_QUOTES); ?>
                    </div>
                    <br><br>
                    <button><a class="btn-confirm" href = "edit_confirm.php">確認する</a></button>
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
