<?php

include_once "../../todoact.php";

$act = new ToDoAct();
$act->begin(1);

if (isset($_GET['todoid']) == TRUE
	&& isset($_GET['state']) == TRUE) {

	// ToDoステータス変更
	$act->changeStateToDo($_GET['todoid'], $_GET['state']);
}

// ToDo一覧へリダイレクト
header('Location: ' . DOMAIN . 'req/todo/list.php');

?>
