<?php 
session_start();

// ファイルの読み込み
require_once '../../app/UserLogic.php';
require_once '../../app/CategoryLogic.php';
require_once '../../app/QuestionLogic.php';

// エラーメッセージ
$err = [];

// ログインしているか判定
$result = UserLogic::checkLogin();

//カテゴリ処理
$categories = CategoryLogic::getCategory();

// 検索ボタン押下時、条件に合った質問を表示
if(isset($_GET['search'])) {
    $searchQuestion = QuestionLogic::searchQuestion($_GET);
    if(!$searchQuestion) {
        $err['question'] = '質問の読み込みに失敗しました';
	}
} else {  // 通常時は、新着の質問を表示する
	$newQuestion = QuestionLogic::newQuestion();
}
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
            <div class="navtext">novus</div>
        </div>
		<?php if($result): // ログインしていれば下記の表示 ?>
            <input type="checkbox" class="menu-btn" id="menu-btn" id ="modal-content">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu">
                <li class="top"><a href="../userLogin/home.php">TOPページ</a></li>
                <li><a href="../userLogin/mypage.php">マイページ</a></li>
                <li><a href="../todo/index.php">TO DO LIST</a></li>
                <li><a href="../../public/question/qHistory.php">質問 履歴</a></li>
                <li><a href="../../">記事 履歴</a></li>
                <li>
                    <form type="hidden" action="../userLogin/logout.php" method="POST">
			    	    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                    </form>
                </li>
            </ul>
        </script>
		<?php else: // 未ログインであれば下記の表示 ?>
			<input type="checkbox" class="menu-btn" id="menu-btn">
            <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
            <ul class="menu">
                <li class="top"><a href="../user/top.php">TOPページ</a></li>
                <li><a href="../../public/question/qHistory.php">記事ページ</a></li>
            </ul>
		<?php endif; ?>
    </header>

	<!--コンテンツ-->
	<div class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="col-xs-6 col-xs-offset-3 pb-3 mt-4">質問サイトへようこそ</h2>
                <a href="qcreate.php" class="text-dark">質問を投稿する</a>
                <div class="col-xs-6 col-xs-offset-3 well">
	                <!-- ②検索フォーム  -->
	                <form method="get">
	                	<div class="form-group">
	                		<input name="keyword" class="form-control mb-3" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']): '' ?>">
	                	</div>
	                	<div class="form-group">
                            <select name="category">
                                <option></option>
                                <?php foreach($categories as $category): ?>
                                    <option 
                                    value="<?php echo $category['cate_id']; ?>"
                                    <?php if(isset($_GET['category']) && $category['cate_id'] == $_GET['category']): ?>
                                        selected
                                    <?php endif; ?>> 
                                        <?php echo $category['category_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
	                	</div>
	                	<button type="submit" class="btn btn-warning mt-4" name="search">検索</button>
	                </form>
                </div>

	            <div class="col-xs-6 col-xs-offset-3">
        		    <!-- 検索ボタン押下時、取得データを表示する -->
        		    <?php if(isset($searchQuestion) && count($searchQuestion)): ?>
        			    <p class="alert alert-success"><?php echo count($searchQuestion); ?>件見つかりました。</p>
        			    <div class="fw-bold mt-2 mb-2 h5">検索結果</div>
					    <?php foreach($searchQuestion as $value): ?>
        			        <div><a href="qDisp.php? question_id=<?php echo $value['question_id']; ?>">「<?php echo htmlspecialchars($value['title']); ?>」</a></div>
					        <?php if(isset($value['icon'])): ?>
								<a name="icon" href="<?php if ($result && $value['user_id'] === $_SESSION['login_user']['user_id']) {
		    						echo '../userLogin/mypage.php'; } else {
                                    echo "../userLogin/userpage.php?user_id=".$value['user_id'] ;} ?>">
									<img src="../user/img/<?php echo $value['icon']; ?>">
								</a>
							<?php else: ?>
								<a name="icon" href="<?php if ($result && $value['user_id'] === $_SESSION['login_user']['user_id']) {
		    						echo '../userLogin/mypage.php'; } else {
                                    echo "../userLogin/userpage.php?user_id=".$value['user_id'] ;} ?>">
									<div><img src="../user/img/sample_icon.png"></div>
								</a>
							<?php endif; ?>
					        <div class="pb-3 small"><?php echo htmlspecialchars($value['name']); ?>さん</div>
					        <div>カテゴリ：<?php echo htmlspecialchars($value['category_name']); ?></div>
							<!-- 本文が50文字以上なら省略 -->
							<?php if(mb_strlen($value['message']) > 50): ?>
								<?php $limit_content = mb_substr($value['message'],0,50); ?>
								<?php echo $limit_content; ?>…
							<?php else: ?>
								<?php echo $value['message']; ?>
							<?php endif; ?>
        			        <!-- 更新されていた場合、その日付を優先表示 -->
				            <div class="small pb-4">
					            <?php if (!isset($value['upd_date'])): ?>
					            	投稿：<?php echo date('Y/m/d H:i', strtotime($value['post_date']));  ?>
					            <?php else: ?>
					            	更新：<?php echo date('Y/m/d H:i', strtotime($value['upd_date'])); ?>
					            <?php endif; ?>
                            </div>
							<hr>
			            <?php endforeach; ?>
						
                    <!--検索結果が見つからなかった時-->
		            <?php elseif (isset($searchQuestion) && count($searchQuestion) == 0): ?>
			        <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
		    
			            <!-- 通常時、新着の質問を表示 -->
		                <?php elseif(isset($newQuestion)): ?>
		                	<hr size="5"><div class="fw-bold mt-2 mb-2 h5">新着の質問</div>
		                	<?php foreach($newQuestion as $value): ?>
		                		<div><a href="qDisp.php? question_id=<?php echo $value['question_id']; ?>">「<?php echo htmlspecialchars($value['title']); ?>」</a></div>
								<?php if(isset($value['icon'])): ?>
									<a name="icon" href="<?php if ($result && $value['user_id'] === $_SESSION['login_user']['user_id']) {
		    						echo '../userLogin/mypage.php'; } else {
                                    echo "../userLogin/userpage.php?user_id=".$value['user_id'] ;} ?>">
									<img src="../user/img/<?php echo $value['icon']; ?>">
									</a>
								<?php else: ?>
									<a name="icon" href="<?php if ($result && $value['user_id'] === $_SESSION['login_user']['user_id']) {
									echo '../userLogin/mypage.php'; } else {
									echo "../userLogin/userpage.php?user_id=".$value['user_id'] ;} ?>">
									<img src="../user/img/sample_icon.png">
									</a>
								<?php endif; ?>
					    		<div class="pb-3 small"><?php echo htmlspecialchars($value['name']); ?>さん</div>
					    		<div>カテゴリ：<?php echo htmlspecialchars($value['category_name']); ?></div>
								<!-- 本文が50文字以上なら省略 -->
								<?php if(mb_strlen($value['message']) > 50): ?>
									<?php $limit_content = mb_substr($value['message'],0,50); ?>
									<?php echo $limit_content; ?>…
								<?php else: ?>
									<?php echo $value['message']; ?>
								<?php endif; ?>
								<!--投稿日時-->
								<div class="small pb-4">
									<!-- 更新されていた場合、その日付を優先表示 -->
									<?php if (!isset($value['upd_date'])): ?>
										投稿：<?php echo date('Y/m/d H:i', strtotime($value['post_date']));  ?>
									<?php else: ?>
										更新：<?php echo date('Y/m/d H:i', strtotime($value['upd_date'])); ?>
									<?php endif; ?>
								</div>
							<hr>
		                	<?php endforeach; ?>
		            <?php endif; ?>
	            </div>
				<?php if($result): // ログインの有無でリンクの変化 ?>
	            	<button type="button" class="mb-4 mt-5 btn btn-outline-dark" onclick="location.href='../userLogin/home.php'">TOP</button>
				<?php else: ?>
					<button type="button" class="mb-4 mt-5 btn btn-outline-dark" onclick="location.href='../user/top.php'">TOP</button>
				<?php endif; ?>
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
