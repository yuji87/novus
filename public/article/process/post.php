<?php
// 記事投稿/編集反映処理
require_once "../../../app/ArticleAct.php";
require_once "../../../app/Token.php";
require_once "../../../app/Utils.php";

use Novus\ArticleAct;
use Novus\Token;
use Novus\Utils;

$act = new ArticleAct();
$act->begin(1);

// ログインチェック
$act->checkLogin();

// トークンチェック
Token::validate();

$title = filter_input(INPUT_POST, "title");
$message = filter_input(INPUT_POST, "message");
$category = filter_input(INPUT_POST, "category", FILTER_SANITIZE_NUMBER_INT);

$title = Utils::mbtrim($title);
$message = Utils::mbtrim($message);

// 各種チェック
if (! Utils::isStrLen($title, 150)) {
    echo "failed-title"; //failed-titleを持たせてjsで表示
    exit;
}
elseif (! Utils::isStrLen($message, 1500)) {
    echo "failed-message"; //failed-messageを持たせてjsで表示
    exit;
}
elseif (! $act->isCategory($category)) {
    echo "failed-category"; //failed-categoryを持たせてjsで表示
    exit;
}

$userId = $act->getMemberId();
$article_id = filter_input(INPUT_POST, "article_id", FILTER_SANITIZE_NUMBER_INT);
if (!$article_id) { 
    // 記事IDがなければ新規投稿
    $act->create($title, $message, $category);
    // 経験値を加算する処理
    $act->addEXP($userId, 20);
} else {
    // 記事IDがあれば編集処理
    $act->update($article_id, $title, $message, $category);
}

// ajax呼び出し。 戻り値を出力
echo "success";