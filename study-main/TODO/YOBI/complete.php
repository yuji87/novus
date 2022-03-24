<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ToDoリスト 入力ページ</title>
</head>
<body>
 	<h2>登録完了ページ</h2>
 	<div class="input-area">
	 	<p>予定タイトル</p>
 		<?php echo $_POST['todo_title'];?>
	</div>
	<div class="input-area">
	 	<p>優先度</p>
 		<?php echo $_POST['yusen'];?>
	</div>
	<div class="input-area">
	 	<p>予定種別</p>
 		<?php echo $_POST['syubetsu'];?>
	</div>
	<div class="input-area">
	 	<p>予定詳細</p>
 		<?php echo nl2br($_POST['todo_body']);?>
	</div>
</body>
</html>