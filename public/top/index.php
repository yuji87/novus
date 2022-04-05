<?php
session_start();

// ファイルの読み込み
require_once '../../app/CategoryLogic.php';
require_once '../../app/QuestionLogic.php';

// エラーメッセージ
$err = [];

// カテゴリ処理
$categories = CategoryLogic::getCategory();

//質問を引っ張る処理
if(isset($_GET['search'])) {
    $searchQuestion = QuestionLogic::searchQuestion($_GET);
    if(!$searchQuestion) {
      $err['question'] = '質問の読み込みに失敗しました';
    } else {
  	$newQuestion = QuestionLogic::newQuestion();
    }
}

// 最新の質問を表示
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
    <link rel="stylesheet" type="text/css" href="../../public/css/top.css">
	<link rel="stylesheet" type="text/css" href="../css/mypage.css">
	<link rel="stylesheet" type="text/css" href="../css/question.css">
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <title>トップ画面</title>
</head>

<body class="p-3">
	<!-- ヘッダ -->
	<!--メニュー-->
    <header>
        <div class="navbar bg-dark text-white">
            <div class="navtext h2" id="headerlogo">novus</div>
			<ul class="nav justify-content-center">
                <li id="li"><a class="nav-link small text-white" href="../question/index.php">質問ページ</a></li>
                <li id="li"><a class="nav-link small text-white" href="../article/index.php">記事ページ</a></li>
                <li id="li"><a class="nav-link small text-white" href="../bookApi/index.php">ライブラリ</a></li>
				<li><a href="../userLogin/form.php" class="nav-link small text-white" id="logo"><i class="fa-solid fa-arrow-right-to-bracket text-white" style="padding-right:10px;"></i></a></li>
			    <li><a href="../userRegister/form.php" class="nav-link small text-white" id="logo"><i class="fa-solid fa-user-plus text-white"></i></a></li>
            </ul>
        </div>
    </header>

    <!-- コンテンツ -->
	<div id="content" class="text-center mt-2"  style="background-color:rgba(236, 235, 235, 0.945);">
		<div class="text-center pt-5">
			<h5>質問を検索</h5>
            <form method="GET">
                <div class="form-row text-center">
                    <div id="keyword" class="form-group col-row">
                        <input name="keyword" type="text" class="form-control" id="question" placeholder="キーワード" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']): '' ?>">
                    </div>
                    <br>
                    <div class="form-group col-row">
                        <label class="small">カテゴリー</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="category">
					        <option></option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category['cate_id']; ?>"
                            <?php if(isset($_GET['category']) && $category['cate_id'] == $_GET['category']): ?>
                                  selected
                            <?php endif; ?>>
						    <?php echo $category['category_name']; ?>
                            </option>
						    <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary mt-3 mb-5" name="search">検索</button>
			</form>
        </div>

		<div id="news" class="text-center">
		    <?php //③取得データを表示する ?>
	        <?php if(isset($searchQuestion) && count($searchQuestion)): ?>
		        <p class="alert alert-success"><?php echo count($searchQuestion) ?>件見つかりました。</p>
	            <!--質問表示-->
		        <?php foreach($searchQuestion as $value): ?>
			        <!--題名-->
			        <div><a href="../question/qDisp.php? question_id=<?php echo $value['question_id']; ?>">「<?php echo htmlspecialchars($value['title']); ?>」</a></div>
			        <!--アイコン-->
			        <div class="level-icon">
                        <?php if($value['icon'] !== null && !empty($value['icon'])): ?> 
                            <img src="../top/img/<?php echo $value['icon']; ?>"></a>
                        <?php else: ?>
					    	<!--アイコンをクリックするとユーザーページへ-->
					    	<a name="icon" href="<?php 
					    	//user_idをユーザーページに引き継ぐ
					    	echo "userPage.php?user_id=".$value['user_id']; ?>">
					    	<?php echo "<img src="."../top/img/sample_icon.png".">"; ?></a>
                        <?php endif; ?>
                    </div>
				    <!--ユーザー名-->
				    <div class="pb-3 small"><?php echo htmlspecialchars($value['name']); ?>さん</div>
				    <!--カテゴリ-->
				    <div>カテゴリ：<?php echo htmlspecialchars($value['category_name']); ?></div>
				    <!--本文-->
				    <div>本文：<?php echo htmlspecialchars($value['message']); ?></div>
				    <!--投稿日時-->
			        <div class="mt-1 mb-3 small"><?php echo htmlspecialchars($value['post_date']); ?></div><hr id="dot">
		    	<?php endforeach; ?>
		    <?php elseif (isset($searchQuestion) && count($searchQuestion) == 0): ?>
		    	<p class="alert alert-danger">検索対象は見つかりませんでした。</p>
			<?php endif; ?>

		    <!-- 通常時、新着の質問を表示 -->
			<hr size="4"><div class="fw-bold mb-4 h5 pt-3">新着の質問</div>
		    <?php if(!isset($searchQuestion) && isset($newQuestion)): ?>
			    <?php foreach($newQuestion as $value): ?>
				    <!--題名-->
				    <div><a href="../question/qDisp.php? question_id=<?php echo $value['question_id']; ?>">「<?php echo htmlspecialchars($value['title']); ?>」</a></div>
			        <!--アイコン-->
			        <div class="level-icon">
                        <?php if($value['icon'] !== null && !empty($value['icon'])): ?> 
                            <img src="../top/img/<?php echo $value['icon']; ?>"></a>
                        <?php else: ?>
				    		<!--アイコンをクリックするとユーザーページへ-->
				    		<a name="icon" href="<?php 
				    			//user_idをユーザーページに引き継ぐ
				    			echo "userPage.php?user_id=".$value['user_id']; ?>">
				    			<?php echo "<img src="."../top/img/sample_icon.png".">"; ?></a>
                        <?php endif; ?>
                    </div>
				    <!--ユーザー名-->
				    <div class="pb-3 small"><?php echo htmlspecialchars($value['name']); ?>さん</div>
				    <!--カテゴリ-->
				    <div>カテゴリ：<?php echo htmlspecialchars($value['category_name']); ?></div>
				    <!--本文-->
				    <div>本文：<?php echo htmlspecialchars($value['message']); ?></div>
				    <!--投稿日時-->
			        <div class="mt-1 mb-3 small"><?php echo htmlspecialchars($value['post_date']); ?></div><hr id="dot">
			    <?php endforeach; ?>
		    <?php endif; ?>
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
