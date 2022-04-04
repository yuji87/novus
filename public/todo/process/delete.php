<?php
// ToDo削除
require_once "../../../app/TodoAct.php";
require_once '../../../app/Token.php';

use Novus\TodoAct;
use Novus\Token;

$act = new ToDoAct();
$act->begin(1);

// ログインチェック
$act->checkLogin();

// トークンチェック
Token::validate();

$todoid = filter_input(INPUT_POST, 'todoid', FILTER_VALIDATE_INT);

// ToDo削除
$act->delete($todoid);

// ajax呼び出し。 戻り値を出力
echo 'success';
