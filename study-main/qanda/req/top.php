<?php

include_once '../act.php';

$mode = '';
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

$act = new Action();
$act->begin($mode);

header('Location: ' . DOMAIN . 'req/user/mypage.php');

?>