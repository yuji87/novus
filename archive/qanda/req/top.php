<?php

include_once '../act.php';

$mode = '';
if (isset($_GET['mode'])) {
	$mode = $_GET['mode'];
}

$act = new Action();
$act->begin($mode);

if ($act->member['KIND'] == 'ADMIN') {
	header('Location: ' . DOMAIN . 'req/admin/list.php');
}
else {
	header('Location: ' . DOMAIN . 'req/user/mypage.php');
}

?>
