<?php

include_once "../../articleact.php";

$act = new ArticleAct();
$act->begin(1);

if (isset($_GET['articleid']) == TRUE && $_GET['articleid'] > 0) {
	// 記事削除
	$act->deletearticle($_GET['articleid']);
}

// 記事一覧へリダイレクト
header('Location: ' . DOMAIN . 'req/article/list.php');

?>
