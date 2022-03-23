<?php

include_once "../../todoact.php";

$act = new ToDoAct();
$act->begin(1);

if (isset($_POST['newtodotitle']) == TRUE
    && isset($_POST['newtododt']) == TRUE) {

    // ToDo追加
    $act->registToDo($_POST['newtodotitle'], $_POST['newtododt']);
}

// ToDo一覧へリダイレクト
header('Location: ' . DOMAIN . 'req/todo/list.php');

?>
