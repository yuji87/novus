<?php

include_once "../../def.php";
include_once "../../act.php";

// ベースクラス
$act = new Action();
$act->begin_free();

// エラーメッセージ
$errorMessage = '';
if (isset($_GET['errid']) == TRUE) {
    if ($_GET['errid'] == 1) {
        $errorMessage = "既にそのアカウントは使用されています";
    }
    else if ($_GET['errid'] == 2) {
        $errorMessage = "システムエラー";
    }
}

// 画面に表示するため特殊文字をエスケープする
$viewName = "";
if (isset($_GET['name']) == TRUE) {
    $viewName = htmlspecialchars($_GET['name'], ENT_QUOTES);
}
?>

<script type="text/javascript">
// 作成ボタンを押した
function onNewAccount() {
    // 入力値チェック
    var $pwd = document.getElementById('password').value;
    var $chkpwd = document.getElementById('chkpassword').value;

    if ($pwd != $chkpwd) {
        onShow('パスワードが一致しません');
        return;
    }
    if (! isPassword($pwd)) {
        onShow('パスワードに間違いがあります(5～12文字以内の半角英数字で設定)<br/>パスワード:' + $pwd);
        return;
    }
    if (! isStrLen(document.getElementById('name').value, 2, 64)) {
        onShow('ニックネームに間違いがあります');
        return;
    }
    if (! isEmailStr(document.getElementById('email').value)) {
        onShow('E-Mailアドレスに間違いがあります');
        return;
    }

    // 送信
    document.qandaForm.submit();
}
</script>

<h3>アカウント登録</h3>

<div class="container-fluid">
<form method="post" class="form-horizontal" name="qandaForm" action="<?php print DOMAIN . '/req/reg/newgenexec.php'; ?>">
<div class="row m-2 form-group">
 <div class="col-sm-4">E-MAIL(アカウント名)</div>
 <div class="col-sm-8"><input type="text" id="email" name="email" value="" style="" /></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-4">パスワード</div>
 <div class="col-sm-8"><input type="password" id="password" name="password" value="" /></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-4">パスワード(確認のためもう一度)</div>
 <div class="col-sm-8"><input type="password" id="chkpassword" value="" /></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-4">ニックネーム</div>
 <div class="col-sm-8"><input type="text" id="name" name="name" value="<?php printf($viewName); ?>" /></div>
</div>
</form>
</div>

<div class="row m-2">
 <div class="col-sm-12 text-center">
  <div class="col-sm-6 btn btn-primary" onClick="onNewAccount()">作成</div>
 </div>
</div>
<div class="row m-2">
 <div class="col-sm-12 text-center">
  <a class="col-sm-6 btn btn-link" href="<?php print DOMAIN; ?>/req/top.php">戻る</a>
 </div>
</div>

<script type="text/javascript">
<?php
if ($errorMessage != '') {
    print "$(function() {swal('" . $errorMessage . "');})";
}
?>
</script>

<?php
$act->end(1);
?>
