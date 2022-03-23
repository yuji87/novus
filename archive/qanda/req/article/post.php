<?php

include_once "../../articleact.php";

$act = new ArticleAct();
$act->begin(1);

if (isset($_POST['title']) == TRUE
	&& isset($_POST['message']) == TRUE
	&& isset($_POST['category']) == TRUE) {

	if (isset($_POST['articleid']) == TRUE && $_POST['articleid'] > 0) {
		$act->updatearticle($_POST['articleid'], $_POST['title'], $_POST['message'], $_POST['category']);
	}
	else {
		$act->postarticle($_POST['title'], $_POST['message'], $_POST['category']);
	}
	print 'success';
}
else {
	print 'failed';
}


?>
