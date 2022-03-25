<?php
session_start();

//ファイル読み込み
require_once '../../classes/UserLogic.php';
require_once '../../classes/LevelLogic.php';
require_once '../../functions.php';
$err = [];

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userCreate/signup_form.php');
    return;
}

//上位３位のレベルを表示
$level = LevelLogic::levelTop3();
$paging = LevelLogic::levelRanking();
if (!$level) {
	$err[] = '表示するレベルがありません';
}

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/top.css" />
    <link rel="stylesheet" type="text/css" href="../../css/mypage.css" />
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <title>トップ画面</title>
</head>


<body class="p-3">
    <!--ヘッダ-->
	<header>
	  <nav class="navbar navbar-expand-lg" style="background-color:rgba(55, 55, 55, 0.98);">
		<div class="pt-2">
			<a class="avbar-brand font-weight-bold h3 text-white" href="login_top.php">Q&A SITE</a>
			<span class="navbar-text">
			    <form type="hidden" action="mypage.php" method="POST" name="mypage">
				    <a class="nav-link small text-white" href="mypage.php">MyPage</a>
				    <input type="hidden" class="nav-link small text-white">
                </form>
			</span>
		</div>
        <!--各ページへのLink-->
		<ul class="nav nav-fill" >
			<li class="nav-item">
				<a class="nav-link active small text-white" href="#">質問</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small text-white" href="#">記事</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small text-white" href="#">本Page</a>
			</li>
		</ul>
	</header>

	<div id="content" class="text-center mt-2" style="background-color:rgba(236, 235, 235, 0.945);">
	    <form type="hidden" name="userpage" action="<?php if ($value['user_id'] === $_SESSION['login_user']['user_id']) {
			echo 'mypage.php'; } else {
			echo 'userpage.php';} ?>">
			<input type="hidden" name="formcheck" value="checked">
	    <!--レベル上位３人を出す-->
	    <div class="text-center">
            <div class="form-row text-center">
                <div id="title">
				<h2 class="heading mt-2">レベルランキング TOP3</h2>
					<?php foreach($level as $value): ?>
                    <!--ユーザーが登録した画像を表示-->
                    <div class="level-icon"><br>
                        <?php if (isset($value['icon'])): ?> 
							<!--画像をクリックすると、自分のアイコンならmypage,他人ならuserpageに遷移-->
							<a name="icon" href="<?php if ($value['user_id'] === $_SESSION['login_user']['user_id']) {
								echo 'mypage.php'; } else {
                                echo "userpage.php?user_id=".$value['user_id'] ;} ?>">
                            <img src="../img/<?php echo $value['icon']; ?>"></a>
                        <?php else: ?>
							<!--上記と同じ処理-->
							<!-- <form type="hidden" name="userpage" action="-->
							<a name="icon" href="<?php if ($value['user_id'] === $_SESSION['login_user']['user_id']) { 
								echo 'mypage.php'; } else {
								echo "userpage.php?user_id=".$value['user_id'] ;} ?>">
								<?php echo "<img src="."../img/sample_icon.png".">"; ?></a>
							    <!-- <input id="imginput" type="submit" value=""></form> -->
                        <?php endif; ?>
                    </div>

                    <div class="text">
                        <!--名前とレベル-->
						<?php echo $value['name']; ?>
                        Lv.<?php echo $value['level']; ?>
                    </div>
                    <?php endforeach ?>
					<a class="small" href="../level/levelDisp.php">ランキング詳細<i class="fa-solid fa-arrow-right"></i></a>
				</div>
            </div>
            <hr>
        </div>
	    <!--新着の記事-->
	    <div id="news" class="text-center">
	    	<h5>新着の質問</h5>
	    	<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
	    	<p class="font-weight-normal">投稿日時とか入れる</p>
	    	<hr />
	    </div>
	    <div id="news" class="text-center">
	    	<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
	    	<p class="font-weight-normal">投稿日時とか入れる</p>
	    	<hr />
	    </div>
	    <div id="news" class="text-center">
	    	<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
	    	<p class="font-weight-normal">投稿日時とか入れる</p>
	    	<hr />
	    </div>
	    <div id="news" class="text-center">
	    	<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
	    	<p class="font-weight-normal">投稿日時とか入れる</p>
	    	<hr />
	    </div>
	    <div id="news" class="text-center">
	    	<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
	    	<p class="font-weight-normal">投稿日時とか入れる</p>
	    	<hr />
	    </div>
	</div>
	
	    <!-- フッタ -->
	    <footer class="h-10">
	    	<div class="footer-item text-center">
	    		<h4>Q&A SITE</h4>
	    		<ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
	    				<a class="nav-link small" href="#">記事</a>
	    			</li>
	    			<li class="nav-item">
	    				<a class="nav-link small" href="#">質問</a>
	    			</li>
	    			<li class="nav-item">
	    				<a class="nav-link small" href="#">本検索</a>
	    			</li>
	    			<li class="nav-item">
	    				<a class="nav-link small" href="#">お問い合わせ</a>
	    			</li>
	    		</ul>
	    	</div>
	    	<p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>
	    </footer>
</body>
</html>
