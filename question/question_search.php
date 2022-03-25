<?php 

session_start();

//ファイルの読み込み
  require_once '../classes/CategoryLogic.php';
  require_once '../classes/QuestionLogic.php';

//error
$err = [];

$categories = CategoryLogic::getCategory();

  //質問を引っ張る処理
if(isset($_GET['search'])){
  $searchQuestion = QuestionLogic::searchQuestion($_GET);
  if(!$searchQuestion){
    $err['question'] = '質問の読み込みに失敗しました';
  }
}


?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>質問検索</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>
<h1 class="col-xs-6 col-xs-offset-3">質問 検索</h1>
<div class="col-xs-6 col-xs-offset-3 well">

	<?php //②検索フォーム ?>
	<form method="get">
		<div class="form-group">
			<input name="keyword" class="form-control" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>">
		</div>
		<div class="form-group">
      <select name="category">
        <option></option>
        <?php foreach($categories as $value){ ?>
          <option 
            value="<?php echo $value['cate_id'] ?>"
            <?php if(isset($_GET['category']) && $value['cate_id'] == $_GET['category']) : ?>
              selected
            <?php endif; ?>
          > 
            <?php echo $value['category_name'] ?>
          </option>
        <?php } ?>
      </select>
		</div>
		<button type="submit" class="btn btn-default" name="search">検索</button>
	</form>

</div>
<div class="col-xs-6 col-xs-offset-3">
	<?php //③取得データを表示する ?>
	<?php if(isset($searchQuestion) && count($searchQuestion)): ?>
		<p class="alert alert-success"><?php echo count($searchQuestion) ?>件見つかりました。</p>
	
				<?php foreach($searchQuestion as $value): ?>
						<div><a href="question_disp.php? question_id=<?php echo $value['question_id']?>">題名：<?php echo htmlspecialchars($value['title']) ?></a></div>
						<div>カテゴリ：<?php echo htmlspecialchars($value['category_name']) ?></div>
						<div>本文：<?php echo htmlspecialchars($value['message']) ?></div>
						<div>名前：<?php echo htmlspecialchars($value['name']) ?></div>
						<div><?php echo htmlspecialchars($value['icon']) ?></div>
						<div>日時：<?php echo htmlspecialchars($value['post_date']) ?></div>
				<?php endforeach; ?>
	<?php else: ?>
		<p class="alert alert-danger">検索対象は見つかりませんでした。</p>
	<?php endif; ?>

</div>
</body>
</html>
