<?php
// トップページ
require_once '../app/Action.php';
use Qanda\Action;

$mode = filter_input(INPUT_GET, 'mode', FILTER_VALIDATE_INT);

// セッションがない場合は、 begin呼び出し時に、さらに ログインページへリダイレクト
$act = new Action();
$act->begin($mode);

// 基本的にマイページへリダイレクトさせる。
header('Location: ' . DOMAIN . '/public/article/mypage.php');

