<?php

include_once '../act.php';

$act = new Action();
$act->begin_free();

$retcode = '';
if (isset($_GET['retcode']) == TRUE) {
	$retcode = $_GET['retcode'];
}

?>

<h1><?php print SYSTITLE; ?> ログイン画面</h1>
<p>
アカウント(E-MAIL)とパスワードを入力してください。
</p>

<div class="container-fluid">
<form method="POST" class="form-horizontal" name="qandaForm" action="<?php print DOMAIN . '/req/loginexec.php'; ?>">
<div class="row m-2 form-group">
 <div class="col-sm-4">アカウント(E-MAIL)</div>
 <div class="col-sm-8"><input type="text" class="form-control" id="email" name="email" value="" maxlength="64" /></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-4">パスワード</div>
 <div class="col-sm-8"><input type="password" class="form-control" id="password" name="password" maxlength="20"  /></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-6"></div>
 <div class="col-sm-6">
  <div class="btn btn-success" id="btnlogin">ログイン</div>
 </div>
</div>
</form>
</div>

<hr/>
<div class="container-fluid">
 <div class="row m-2">
  <div class="col-sm-6">はじめてのかたはコチラ</div>
  <div class="col-sm-6">
   <div class="btn btn-primary" id="btnnewgen" onclick="jumpapi('req/reg/newgen.php')">新規作成</div>
  </div>
 </div>
</div>

<script type="text/javascript">
function sendLogin() {
	var $pwd = document.getElementById('password').value;
	if (! isPassword($pwd)) {
		onShow('パスワードに間違いがあります(5～12文字以内の半角英数字で設定)<br/>パスワード:' + $pwd);
		return;
	}
	if (! isEmailStr(document.getElementById('email').value)) {
		onShow('E-Mailアドレスに間違いがあります');
		return;
	}

	// 送信
	document.qandaForm.submit();
}
$('#btnlogin').click(sendLogin);
</script>

<?php
if ($retcode != '') {

print<<<EOF
<script type="text/javascript">
$(function() {
	swal("ログインに失敗しました。\\nE-MAIL/パスワードを見直してください");
});
</script>
EOF;
}

$act->end(1);

?>
