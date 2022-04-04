<?php
session_start();

//ファイル読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/LevelLogic.php';
require_once '../../app/Functions.php';

$data = $_GET;
$user_id = filter_input(INPUT_GET, 'user_id');

// レベル表示処理
$data = LevelLogic::displayUsers($_GET);
if(!$data) {
	$err[] = '表示するレベルがありません';
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
    <link rel="stylesheet" href="../css/level_anime.css">
    <title>User Page</title>
</head>

<body>
    <!--メニュー-->
    <header>
        <div class="navtext-container">
            <div class="navtext">novus</div>
        </div>
    </header>

    <!--コンテンツ-->
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading mt-5">MY ACCOUNT</h2>
                <div class="list">
                    <!--ユーザーが登録した画像を表示-->
                    <div class="list-item">
                        <?php if($data['icon'] !== null && !empty($data['icon'])): ?> 
                            <img src="../top/img/<?php echo $data['icon']; ?>">
                        <?php else: ?>
                        <?php echo "<img src="."../top/img/sample_icon.png".">"; ?>
                        <?php endif; ?>
                    </div>
                    <!--ユーザーが登録した名前を表示-->
                    <div class="text">
                        名前：<?php echo $data['name']; ?>
                    </div>
                    <!--ユーザーの現レベルを表示-->
                    <div class="text">
                        Lv.<?php
                           if(isset($data['level'])) {
                               echo htmlspecialchars($data['level'], ENT_QUOTES, 'UTF-8'); 
                           } else {
                               echo '1';
                           } ?>
                    </div>
                    <!--ユーザーのコメントを表示-->
                    <div class="text">
                        コメント：<?php
                            if(isset($data['comment'])) {
                               echo htmlspecialchars($data['comment'], ENT_QUOTES, 'UTF-8'); 
                            } else {
                               echo 'Let us introduce yourself!';
                            } ?>
                    </div>
                    <a href="index.php" id="back">戻る</a>
                </div>
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
