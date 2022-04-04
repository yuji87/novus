<?php
session_start();

//ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/QuestionLogic.php';
require_once '../../app/LevelLogic.php';
require_once '../../app/functions.php';

//エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったらログイン画面へ移す
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = '再度ログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//上位３位のレベルを表示
$level = LevelLogic::levelTop3();
$paging = LevelLogic::levelRanking();
if(!$level) {
	$err[] = '表示するレベルがありません';
}

//最新の質問を表示
$newQuestion = QuestionLogic::newQuestion();
if(!$newQuestion) {
	$err['question'] = '質問の読み込みに失敗しました';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/top.css">
    <link rel="stylesheet" type="text/css" href="../css/a.css">
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <title>トップ画面</title>
</head>

<body>
	<!--メニュー-->
    <header>
        <div class="navbar bg-dark text-white">
            <div class="navtext h2" id="title">novus</div>
            <ul class="nav justify-content-center">
            <li class="nav-item"><form type="hidden" action="mypage.php" method="POST" name="mypage">
				    <a class="nav-link small text-white" href="../myPage/index.php">マイページ</a>
				    <input type="hidden">
                </form>
            </li>
			<li id="li"><a class="nav-link active small text-white" href="../question/index.php">質問ページ</a></li>
            <li id="li"><a class="nav-link small text-white" href="../article/index.php">記事ページ</a></li>
            <li id="li"><a class="nav-link small text-white" href="../bookApi/index.php">ライブラリ</a></li>
            <li id="li"><a class="nav-link small text-white" href="../todo/index.php">TO DO LIST</a></li>
            <li id="li"><a class="nav-link small text-white" href="<?php echo "logout.php?=user_id=".$login_user['user_id']; ?>">ログアウト</a></li>
        </ul>
        </div>
    </header>

	<div class="wrapper">
	    <div class="container">
	        <div class="text-center">
				<!--レベル上位３人を出す-->
                <div class="form-row text-center">
                    <div id="title">
		    		    <h2 class="heading" id="rankingtitle">レベルランキング TOP3</h2>
		    			<?php foreach($level as $value): ?>
                        <!--ユーザーが登録した画像を表示-->
                        <div class="level-icon"><br>
                            <?php if($value['icon'] !== null && !empty($value['icon'])): ?> 
		    					<!--画像をクリックすると、自分のアイコンならmypage,他人ならuserpageに遷移-->
		    					<a name="icon" href="<?php if ($value['user_id'] === $_SESSION['login_user']['user_id']) {
		    						echo 'mypage.php'; } else {
                                    echo "userPage.php?user_id=".$value['user_id'] ;} ?>">
                                <img src="../top/img/<?php echo $value['icon']; ?>"></a>
                            <?php else: ?>
		    					<!--上記と同じ処理-->
		    					<!-- <form type="hidden" name="userpage" action="-->
		    					<a name="icon" href="<?php if ($value['user_id'] === $_SESSION['login_user']['user_id']) { 
		    						echo 'mypage.php'; } else {
									//user_idをユーザーページに引き継ぐ
		    						echo "userPage.php?user_id=".$value['user_id'] ;} ?>">
		    						<?php echo "<img src="."../top/img/sample_icon.png".">"; ?></a>
		    					    <!-- <input id="imginput" type="submit" value=""></form> -->
                            <?php endif; ?>
                        </div>
                        <div class="text">
                            <!--名前とレベル-->
		        			<?php echo $value['name']; ?>
                            Lv.<?php echo $value['level']; ?>
                        </div>
                        <?php endforeach ?>
		        		<a class="small mb-5" href="../level/list.php">ランキング詳細<i class="fa-solid fa-arrow-right"></i></a><hr size="5">
		        	</div>
                </div>

			    <!-- 通常時、新着の質問を表示 -->
		        <?php if(isset($newQuestion)): ?>
		        	<div class="fw-bold mb-4 h5 pt-3">新着の質問</div>
		        	<?php foreach($newQuestion as $value): ?>
						<!--題名-->
						<div><a href="qisp.php? question_id=<?php echo $value['question_id']?>">「<?php echo htmlspecialchars($value['title']) ?>」</a></div>
					    <!--アイコン-->
					    <div class="level-icon">
                            <?php if($value['icon'] !== null && !empty($value['icon'])): ?> 
		    					<!--画像をクリックすると、自分のアイコンならmypage,他人ならuserpageに遷移-->
		    					<a name="icon" href="<?php if($value['user_id'] === $_SESSION['login_user']['user_id']) {
		    						echo 'mypage.php'; } else {
                                    echo "userpage.php?user_id=".$value['user_id'] ;} ?>">
                                <img src="../top/img/<?php echo $value['icon']; ?>"></a>
                            <?php else: ?>
		    					<!--上記と同じ処理-->
		    					<!-- <form type="hidden" name="userpage" action="-->
		    					<a name="icon" href="<?php if($value['user_id'] === $_SESSION['login_user']['user_id']) { 
		    						echo 'mypage.php'; } else {
									//user_idをユーザーページに引き継ぐ
		    						echo "userpage.php?user_id=".$value['user_id'] ;} ?>">
		    						<?php echo "<img src="."../top/img/sample_icon.png".">"; ?></a>
		    					    <!-- <input id="imginput" type="submit" value=""></form> -->
                            <?php endif; ?>
                        </div>
						<!--ユーザー名-->
						<div class="pb-3 small"><?php echo htmlspecialchars($value['name']) ?>さん</div>
		        		<!--カテゴリ-->
						<div>カテゴリ：<?php echo htmlspecialchars($value['category_name']) ?></div>
		        		<!--本文：50文字以上だと省略-->
						<?php if(mb_strlen($value['message']) > 10): ?>
							<?php $limit_content = mb_substr($value['message'],0,10); ?>
							<?php echo $limit_content; ?>…
						<?php else: ?>
							<?php echo $value['message']; ?>
						<?php endif; ?>
		        		<!--投稿日時-->
		        	    <div class="mt-1 mb-3 small"><?php echo htmlspecialchars($value['post_date']) ?></div><hr id="dot">
		        	<?php endforeach; ?>
		        <?php endif; ?>
			</div>
		</div>
	</div>
	
    <!-- フッタ -->
    <footer class="h-10"><hr>
		<div class="footer-item text-center">
			<h3>novus</h3>
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
