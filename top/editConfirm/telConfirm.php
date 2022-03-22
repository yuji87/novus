<?php

session_start();

//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../functions.php';

//エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったらログインへ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userCreate/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

if (!empty($_POST['formcheck'])) {
    
    $_SESSION['telEdit'] = $_POST['tel'];

    $name = filter_input(INPUT_POST, 'tel');

    //バリデーション
    if(!$_SESSION['nameEdit']){
        $err['tel'] = '名前を入力してください';
    }
}

//エラーがなかった場合の処処理
if (count($err) === 0 && (isset($_POST['check']))) {
    
    //ユーザーを登録する
    $userEdit = UserLogic::editUserTel($_SESSION);
    header('Location: editDone.php');
    //既に存在しているアカウントの場合
    if(!$userEdit){
    $err[] = '更新に失敗しました';
    }
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
                <form action="" method="POST">
                <input type="hidden" name="check" value="checked">
                <h1 class="my-3 h1" style="text-align:center;">入力情報の確認</h1>
        <p class="my-2" style="text-align:center;">ご入力内容に変更が必要な場合は、下記の<br>ボタンを押して、変更を行ってください。</p>
        <?php if (!empty($err) && $err === "err"): ?>
            <p class="err">＊会員情報更新に失敗しました。</p>
        <?php endif ?>
                    <div class="list">
                        <!--ユーザーが登録した名前を表示-->
                        <div class="text">
                            <label for="name" style="float:left; padding-left:30px; padding-bottom:10px;">Tel :</label>
                            <span name="name" class="check-info"><?php echo htmlspecialchars($_SESSION['telEdit'], ENT_QUOTES, 'UTF-8'); ?></span>
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
