<?php
// ToDo追加処理
require_once "../../../app/TodoAct.php";
require_once '../../../app/Token.php';
require_once '../../../app/Utils.php';

use Novus\TodoAct;
use Novus\Token;
use Novus\Utils;

$act = new ToDoAct();
$act->begin(1);

// ログインチェック
$act->checkLogin();

// トークンチェック
Token::validate();

$newTodoTitle = filter_input(INPUT_POST, 'newTodoTitle');
$newTodoDt = filter_input(INPUT_POST, 'newTodoDt');

$newTodoTitle = Utils::mbtrim($newTodoTitle);

if (!Utils::isStrLen($newTodoTitle, 100)) {
  // 100文字以上を入力されたとき
  header('Location: ' . DOMAIN . '/public/todo/index.php?errid=invalidtitle');
  exit;
}

if (!Utils::checkDatetimeFormat($newTodoDt)) {
  // 日付フォーマットが違うとき
  header('Location: ' . DOMAIN . '/public/todo/index.php?errid=invalidformatdt');
  exit;
}



// $_POST = Utils::checkInput($_POST);
// $newTodoTitle = trim(filter_input(INPUT_POST, 'newTodoTitle'));
// $NovusEditForm = trim(filter_input(INPUT_POST, 'NovusEditForm'));
// $error = [];

// // 各種チェック
// if (! Utils::mbtrim($newTodoTitle, 0)) {
//   echo "failed-null"; //failed-titleを持たせてjsで表示
//   exit;
// }
// elseif (! Utils::isStrLen($newTodoTitle, 10)) {
//   echo "failed-length"; //failed-messageを持たせてjsで表示
//   exit;
// }

// //値の検証（入力内容が条件を満たさない場合はエラーメッセージを配列 $error に設定）
// if ($newTodoTitle == trim('')) {
//     $error['newTodoTitle'] = '*何も入力されていません';
// //制御文字でないことと文字数をチェック
// } elseif (preg_match('/\A[[:^cntrl:]]{1,30}\z/u', $newTodoTitle) == 0) {
//     $error['newTodoTitle'] = '*タイトルは30文字以内でお願いします';
// }

// if ($NovusEditForm == '') {
//     $error['NovusEditForm'] = '*何も入力されていません';
// } elseif (preg_match('/\A[[:^cntrl:]]{1,200}\z/u', $NovusEditForm) == 0) {
//     $error['NovusEditForm'] = '*タイトルは30文字以内でお願いします';
// }

// ToDo追加
$act->add($newTodoTitle, $newTodoDt);

// ToDo一覧へリダイレクト
header('Location: ' . DOMAIN . '/public/todo/index.php');

