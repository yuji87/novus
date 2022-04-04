<?php

session_start();
//ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/LevelLogic.php';
require_once '../../app/Functions.php';
//エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = '再ログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//レベル情報の取得
$data = LevelLogic::getLevel();
$paging = LevelLogic::levelRanking();
if(!$data || !$paging) {
    $err[] = 'レベルの取り込みに失敗しました';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/top.css">
    <title>レベルランキング詳細</title>
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
            <li><a href="../userEdit/index.php">会員情報 編集</a></li>
            <li><a href="../../myPage/qHistory.php">【履歴】質問</a></li>
            <li><a href="../myPage/aHistory.php">【履歴】記事</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading mt-5">レベルランキング</h2>
                <div class="level-list">
                    <?php foreach($data as $value): ?>
                    <!--ユーザー登録画像の表示-->
                    <div class="level-icon"><br>
                        <!--画像をクリック、自分ならmypageに遷移-->
                        <?php if($value['icon'] !== null && !empty($value['icon'])): ?> 
							<a name="icon" href="<?php if($value['user_id'] === $_SESSION['login_user']['user_id']) {
								echo '../myPage/index.php'; } else {
                                echo "../myPage/userPage.php?user_id=".$value['user_id'] ;} ?>">
                            <img src="../top/img/<?php echo $value['icon']; ?>"></a>
                        <!--画像をクリック、他人ならuserpageに遷移-->
                        <?php else: ?>
							<a name="icon" href="<?php if($value['user_id'] === $_SESSION['login_user']['user_id']) { 
								echo '../myPage/index.php'; } else {
								echo "../myPage/userPage.php?user_id=".$value['user_id'] ;} ?>">
								<?php echo "<img src="."../top/img/sample_icon.png".">"; ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="text">
                        <!--名前の表示-->
                        <?php echo $value['name']; ?>
                        <!--レベルの表示-->
                        Lv.<?php echo $value['level']; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

	<!-- フッタ -->
    <footer> 
        <ul class="pagination">
            <li class="page">
                <?php for($x=1; $x <= $paging ; $x++) { ?>
	            <a href="?page=<?php echo $x ?>"><?php echo $x; ?></a>
                <?php } // forの終わり ?>
            </li>
        </ul>
		<div class="footer-item text-center"><hr>
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

