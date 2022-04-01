<?php
session_start();

// ファイルの読み込み
require_once '../../app/QuestionLogic.php';
require_once '../../app/UserLogic.php';

//エラーメッセージ
$err = [];

// ログインチェック処理
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}

// ボタン押下時の処理（成功でページ移動）
if(isset($_POST['a_edit_conf'])) {
    $_SESSION['a_data']['message'] = filter_input(INPUT_POST, 'a_message', FILTER_SANITIZE_SPECIAL_CHARS);
    $_SESSION['a_data']['answer_id'] = filter_input(INPUT_POST, 'answer_id', FILTER_SANITIZE_SPECIAL_CHARS);
    // エラーチェック
    if(empty($_SESSION['a_data']['message'])) {
        $err['message'] = '本文を入力してください';
    }
    if(empty($_SESSION['a_data']['answer_id'])) {
        $err['a_id'] = '返答が選択されていません';
    }
    if(count($err) === 0) {
        header('Location: aEditComp.php');
    }
} else {
    // 非ボタン押下時（通常時）の処理
    $answer_id = filter_input(INPUT_POST, 'answer_id');
    if(empty($answer_id)) {
        $err[] = '質問を選択し直してください';
    }
    if (count($err) === 0) {
        //質問を引っ張る処理
        $answer = QuestionLogic::displayOneAnswer($answer_id);
        if(!$answer){
            $err[] = '返答の読み込みに失敗しました';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../../css/top.css">
    <title>質問回答 編集</title>
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
            <li><a href="../userLogin/mypage.php">マイページ</a></li>
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
                <p class="h4">編集内容の確認</p>
                <form method="POST" action="">
                    <div>
                        <?php if(isset($err['a_id'])): ?>
                        <?php echo $err['a_id']; ?>
                        <?php endif; ?>
                    </div>
                        <div><?php if(isset($err['message'])): ?>
                        <?php echo $err['message']; ?>
                        <?php endif; ?>
                    </div>
                    <div>本文：
                        <textarea name="a_message"><?php echo $answer['message']; ?></textarea>
                    </div>
                    <input type="hidden" name="answer_id" value="<?php echo $answer_id; ?>">
                    <input type="submit" name="a_edit_conf" class="btn btn-warning mt-5 mb-5" value="編集する">
                </form>
                <button type="button" class="btn btn-outline-dark fw-bold mb-5" onclick="history.back()">戻る</button>
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
                            <a class="nav-link small" href="../question/index.php">質問</a>
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