<?php

session_start();
//ファイル読み込み
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: top/entry_form.php');
    return;
}

$login_user = $_SESSION['login_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/top.css" />
    <title>CSS learning</title>
</head>


<body class="bg-white p-4 p-md-5">
	<!-- ヘッダ -->
	<header>
	  <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="avbar-brand font-weight-bold h3" href="login_top.php">Q&A SITE</a>
			<span class="navbar-text">
				<a href="login.php" class= "col-md-2 small">LogIn</a>
				<a href="entry_form.php" class= "col-md-2 small">SignIn</a>
			</span>
		</div>
	</header>

		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link active small" href="question/question_create.php">質問Page</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small" href="../../public/article/home.php">記事Page</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small" href="#">本Page</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small" href="mypage.php">MyPage</a>
			</li>
		</ul>

    <!-- コンテンツ（中央カラム） -->
	<div id="content" class="text-center">
		<div class="text-center">
            <br><br>
			<h5>質問を検索する</h5>
            <form>
                <div class="form-row text-center">
                    <div id="keyword" class="form-group col-row">
                        <label for="inputEmail4">キーワード</label>
                        <div>
                            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                    </div>
                    <br>
                    <div class="form-group col-row">
                        <label for="inputPassword4">カテゴリー</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                            <option selected>Choose...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">検索</button>
                <hr>
			</form>
        </div>
        <!-- 質問の検索結果（中央カラム） -->
        <br>
		<div id="news" class="text-center">
			<h4>新着の</h4>
			<h5>質問投稿のタイトルが入るよ</h5>
			<p>ここに質問投稿が入るよ</p>
			<p>投稿日時とか入れる</p>
			<hr />
		</div>
	</div>

	<!-- フッタ -->
	<p class="text-center">Copyright (c) HTMQ All Rights Reserved.</p>
</body>
</html>
