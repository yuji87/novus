<?php
// 記事投稿/編集反映処理
require_once "../../../app/ArticleAct.php";
require_once '../../../app/Token.php';
require_once '../../../app/Utils.php';

use Qanda\ArticleAct;
use Qanda\Token;
use Qanda\Utils;

$act = new ArticleAct();
$act->begin(1);

// トークンチェック
Token::validate();

$title = filter_input(INPUT_POST, 'title');
$message = filter_input(INPUT_POST, 'message');
$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

$title = Utils::mbtrim($title);
$message = Utils::mbtrim($message);

// 各種チェック
if (! Utils::isStrLen($title, 128)) {
    echo 'failed-title';
    exit;
}
else if (! Utils::isStrLen($message, 10240)) {
    echo 'failed-message';
    exit;
}
else if (! $act->isCategory($category)) {
    echo 'failed-category';
    exit;
}


$articleid = filter_input(INPUT_POST, 'articleid', FILTER_SANITIZE_NUMBER_INT);
if (! $articleid) {
// 記事新規登録処理
    $act->postarticle($title, $message, $category);
} else {
// 記事編集反映処理
    $act->updatearticle($articleid, $title, $message, $category);
}

// ログインチェック
$result = Utils::checkLogin();
if (!$result) {
    header('Location: ../../top/userLogin/login_top.php');
    return;
}


// ajax呼び出し。 戻り値を出力
echo 'success';
