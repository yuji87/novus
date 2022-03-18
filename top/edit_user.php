<?php

session_start();

//ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: entry_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

$_SESSION['edit'] = $_POST;
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

                    <div class="list">
                        <!--ユーザーが編集した画像を表示-->
                        <div class="list-item">
                        <?php var_dump(1); ?>
                        <form action = "edit_confirm.php" method="POST">
                        
                        
                            <?php if (isset($login_user['icon'])): ?> 
                                <img src="<?php h($login_user['icon']); ?>">
                            <?php else: ?>
                            <?php echo "<img src="."img/sample_icon.png".">"; ?>
                            <?php endif; ?> 
                            
                        </div>
                         
                        <!--ユーザーが登録した名前を表示-->
                        <div class="text">
                            <label for="name" style="float:left; padding-left:30px; padding-bottom:10px;">Name :</label>
                            <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($login_user['name'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <!--ユーザーが登録した電話番号を表示-->
                        <div class="text">
                            <label for="tel" style="float:left; padding-left:30px; padding-bottom:10px;">Tel :</label>
                            <input id="tel" type="text" name="tel" value="<?php echo htmlspecialchars($login_user['tel'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <!--ユーザーが登録したメールアドレスを表示-->
                        <div class="text">
                            <label for="email" style="float:left; padding-left:30px; padding-bottom:10px;">Email :</label>
                            <input id="email" type="email" name="email" value="<?php 
                                if(isset($login_user['email'])) {echo htmlspecialchars($login_user['email'], ENT_QUOTES,'UTF-8');
                                } else { echo ''; }?>">
                        </div>   
                        <!--パスワード入力（非表示）--> 
                        <div class="text">
                            <label for="password" style="float:left; padding-left:30px; padding-bottom:10px;">Password :</label>
                            <input id="password" type="text" name="password" value="＊＊＊＊＊＊">
                            <p style="color:#dc3545; font-size:8px;">セキュリティ保護のため表示していません</p>
                        </div>
                        <!--パスワード再入力（非表示）-->  
                        <div class="text">
                            <label for="password_conf" style="float:left; padding-left:30px; padding-bottom:10px;">Password :</label>
                            <input id="password_conf" type="text" name="password_conf" value="もう一度入力してください">
                        </div>
                        <!--アイコン用の画像を選択-->
                        <div class="text">
                            <label for="password" style="float:left; padding-left:30px; padding-bottom:10px;">Icon :</label>
                            <div class="md-4" type="hidden" name="MAX_FILE_SIZE" value="1048576">
                                <br><input type="file" class="form-control-file" accept="image/*" id="input" name="icon">
                            </div>
                        </div>
                        <!--コメント入力--> 
                        <div class="text">
                            <label for="comment" style="float:left; padding-left:30px; padding-bottom:10px;">comment :</label>
                            <input id="comment" type="text" name="comment" value="<?php 
                                if(isset($login_user['comment'])) {echo htmlspecialchars($login_user['comment'], ENT_QUOTES,'UTF-8');
                                } else { echo 'Let us introduce yourself!'; }?>">
                        </div>
                        <br><br>
                        <button type="submit" class="btn-edit-check">確認する</button>
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
