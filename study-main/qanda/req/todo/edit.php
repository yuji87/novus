<?php

include_once "../../todoact.php";

$act = new ToDoAct();
$act->begin(1);

if (isset($_POST['edittodoid']) == TRUE
    && isset($_POST['edittodotitle']) == TRUE
    && isset($_POST['edittododt']) == TRUE) {

    // ToDo編集
    $act->editToDo($_POST['edittodoid'], $_POST['edittodotitle'], $_POST['edittododt']);
}

// ToDo一覧へリダイレクト
header('Location: ' . DOMAIN . 'req/todo/list.php');

?>
