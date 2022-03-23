<?php

include_once "../../todoact.php";

$act = new ToDoAct();
$act->begin(1);

if (isset($_GET['todoid']) == TRUE) {

	// ToDo削除
	$act->deleteToDo($_GET['todoid']);
}

// ToDo一覧へリダイレクト
header('Location: ' . DOMAIN . 'req/todo/list.php');

?>
