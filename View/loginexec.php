<?php

// loginexec��
require_once '../app/Action.php';

use Qanda\Action;

$act = new Action();
$act->begin_free(1);

$retcode = '';
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if ( $email && $password ) {
  $retcode = $act->login($email, $password);
  switch ($retcode) {
    case  'SUCCESS':
      header('Location: ' . DOMAIN . '/View/article/mypage.php');
      exit;
    default:
      break;
  }
}

header('Location: ' . DOMAIN . '/View/login.php?retcode=' . $retcode);
exit;
