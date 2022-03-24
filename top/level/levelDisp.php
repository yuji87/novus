<?php

session_start();
//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../classes/LevelLogic.php';
require_once '../../functions.php';
//エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userCreate/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

$data = LevelLogic::levelRanking();
if (!$data) {
    $err[] = 'レベルの取り込みに失敗しました';
}

//エラーがない場合
if(count($err) === 0) { 
        
    //ページング設定
    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }

    if ($page > 1) {
        $start = ($page * 10) - 10;
    } else {
        $start = 0;
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
                <h2 class="heading">レベルランキング</h2>
                <div class="level-list">
                    <?php foreach($data as $value): ?>
                    <!--ユーザーが登録した画像を表示-->
                    <div class="level-icon"><br>
                        <?php if (isset($value['icon'])): ?> 
                            <img src="../img/<?php echo $value['icon']; ?>">
                        <?php else: ?>
                        <?php echo "<img src="."../img/sample_icon.png".">"; ?>
                        <?php endif; ?>
                    </div>
                    <div class="text">
                        <!--名前-->
                        <?php echo $value['name']; ?>
                        <!--レベル-->
                        Lv.<?php echo $value['level']; ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </section>
 
	<!-- フッタ -->
    <!--<footer>
    <ul class="pagination">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a class="active" href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">»</a></li>
    </ul>-->
        <div class="">
            <br><br><hr>
	        <p class="text-center">Copyright (c) HTMQ All Rights Reserved.</p>
        </div>
    </footer>
    </body>
</html>

