<?php
session_start();

// ファイルの読み込み
require_once '../../app/QuestionLogic.php';
require_once '../../app/UserLogic.php';

// エラーメッセージ
$err = [];

// ログインチェック
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../../userLogin/home.php');
    return;
}

// データ受け渡しチェック
if (isset($_SESSION['q_data']['title']) &&
    isset($_SESSION['q_data']['category']) &&
    isset($_SESSION['q_data']['message']) &&
    isset($_SESSION['q_data']['question_id'])
) {
    //質問を登録する処理
    $question = QuestionLogic::editQuestion();
    if(!$question){
        $err[] = '変更の保存に失敗しました';
    }
}

// 質問IDから質問内容を取り込む処理
$data = QuestionLogic::displayQuestion($_SESSION['q_data']);
if(!$data) {
    $err[] = '変更の保存に失敗しました';
}
$title = $data['title'];
$category = $data['category_name'];
$message = $data['message'];
$question_id = $_SESSION['q_data']['question_id'];
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>質問</title>
<link rel="stylesheet" href="style.css">
<script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="../css/mypage.css">
<link rel="stylesheet" type="text/css" href="../css/top.css">
<link rel="stylesheet" type="text/css" href="../css/question.css">
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
            <li class="top"><a href="../../userLogin/home.php">TOP Page</a></li>
            <li><a href="../userLogin/mrpage.php">My Page</a></li>
            <li><a href="../todo/index.php">TO DO LIST</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
	  		            <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
	  <section class="wrapper">
        <div class="container">
            <div class="content">
                <p class="h4 pb-3 mt-3">編集完了</p>
                <p>以下の内容で保存しました</p>
                <!--題名-->
                <div class="fw-bold pb-1">題名</div>
                <div><?php echo $title ?></div>
                <!--カテゴリー-->
                <div class="fw-bold pt-3 pb-1">カテゴリ</div>
                <div><?php echo $category ?></div>
                <!--本文-->
                <div class="fw-bold pt-3 pb-1">本文</div>
                <div><?php echo $message ?></div>
                <form method="GET" action="qdisp.php">
                    <input type="hidden" name= "question_id" value="<?php echo $question_id ?>">
                    <input type="submit" value="質問へ">
                </form>
                <button type="button" onclick="">TOP</button>
            </div>
        </div>
    </section>

    <!-- フッタ -->
    <footer class="h-10"><hr>
		    <div class="footer-item text-center">
		    	  <h4>Q&A SITE</h4>
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


