<?php

include_once '../act.php';

$act = new Action();
$act->begin_free(1);

$retcode = '';
if (isset($_POST['email']) == TRUE
    && isset($_POST['password']) == TRUE) {
    $retcode = $act->login($_POST['email'], $_POST['password']);
    switch ($retcode) {
        case  'SUCCESS':
            header('Location: ' . DOMAIN . 'req/user/mypage.php');
            exit;
        default:
            break;
    }
}

header('Location: ' .DOMAIN . 'req/login.php?retcode='. $retcode);
exit;

?>
