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
if (isset($_SESSION['iconEdit'])) {
    //セッションから情報を取得
    $icon = $_SESSION['iconEdit'];
} else {
    //セッションがなかった場合
    $name = array();
}

//エラーメッセージ表示
$err = $_SESSION;
//セッションを消す
// $_SESSION = array();
// session_destroy(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="../../css/mypage.css" /> -->
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
                <form action="../editConfirm/iconConfirm.php" method="POST"  enctype="multipart/form-data">
                    <input type="hidden" name="formcheck" value="checked">
                    <div class="list">
                        <!--アイコン用の画像を選択-->
                        <div class="row my-3">
                            <label for="icon" class="form-label font-weight-bold">Icon</label>
                            <div class="md-4" type="hidden" name="MAX_FILE_SIZE" value="1048576">
                                <input type="file" class="form-control-file" accept="image/*" id="input" name="icon" value="<?php $icon ?>">
                                <!--欄の下に未記入時のエラーメッセージ表示-->
                                <?php if (isset($err['icon'])) : ?>
                                    <p class="text-danger"><?php echo $err['icon']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <br><br>
                        <button type="submit" class="btn-edit-check">変更</button>
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