<?php

//include_once "config_net.php";
include_once "config_local.php";

// 定数
define("VERSION", "1.0.0");
define("SYSTITLE", "Qanda");
define("DOMAIN", "/qanda/");

define("LISTCOUNT", 5);
define("LISTCOUNT_MYPAGE", 5);

// htmlで行表示対応の文字列作成
function compatiStr($str) {
    return str_replace("\n", "<br/>", $str);
}
// ランダムな文字列作成
function randstr($length = 24) {
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
}
// 日時の文字列作成
function compatiDate($date, $format = "Y-m-d H:i") {
    if (! $date) {
        return '';
    }
    return date($format, strtotime($date));
}
// EMAIL送信
function sendEmail($email, $subject, $msg) {
    if (LOCAL == "1") {
    // email認証を省略
        return true;
    }

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $heads = sprintf("From: %s", GMEMAIL);
    return mb_send_mail($email, $subject, $msg, $heads);
}
// 現在、期間内の時間か？
function isSpanOver($tgtstrdt, $spanhour)
{
    if ($tgtstrdt == NULL) {
        return TRUE;
    }

    $tgtdt = strtotime($tgtstrdt);
    $nowdt = strtotime("now");
    $spandiff = $nowdt - $tgtdt;
    $daydiff = $spanhour * 60 * 60;
//print $spandiff . ':' . $daydiff;
    if ($spandiff >= $daydiff) {
        return TRUE;
    }
    else {
        return FALSE;
    }
}
// 現在の時刻から $addday日後の日時の文字列を作成
function addDay($addday, $format = 0) {
    $tgtdt = strtotime($addday . 'day');
    if ($format == 0) {
        return date('Y-m-d 00:00', $tgtdt);
    }
    else {
        return date('Y-m-d 23:59', $tgtdt);
    }
}

?>
