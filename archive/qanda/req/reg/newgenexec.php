<?php

include_once "../../def.php";
include_once "../../act.php";

$act = new Action();
$act->begin_free(1);

$errid = 2;
if (isset($_POST['email']) == TRUE
	&& isset($_POST['password']) == TRUE
	&& isset($_POST['name']) == TRUE) {

	$email = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];

	// email重複していているか?
	$result = $act->memberrefemail($email);
	if (! $result) {
		// OK
		$regstart = TRUE;
	}
	else {

		// 既に登録済み
		$regstart = FALSE;
		$errid = 1;
	}

	if ($regstart == TRUE) {

		try {
			$act->conn->beginTransaction();

			// 登録
			$act->regist($email, $name, md5($password));

			$act->conn->commit();
		}
		catch (Exception $e) {
			$act->conn->rollback();
		}
	}

	if ($regstart == TRUE) {

		// 完了画面へ
		header('Location: ' . DOMAIN . 'req/reg/newgencomp.php');
		exit;
	}
}

// エラーで作成画面に戻る
header('Location: ' . DOMAIN . 'req/reg/newgen.php?errid=' . $errid);

?>

