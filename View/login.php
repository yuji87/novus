<?php
// ログイン画面★
require_once '../app/Action.php';

use Qanda\Action;

$act = new Action();
$act->begin_free();

$retcode = filter_input(INPUT_GET, 'retcode');

?>

<h1><?php echo SYSTITLE; ?> ログイン画面</h1>
<p>
  アカウント(E-MAIL)とパスワードを入力してください。
</p>

<div class="container-fluid">
  <form method="POST" class="form-horizontal" name="qandaForm" action="<?php echo DOMAIN . '/View/loginexec.php'; ?>">
    <div class="row m-2 form-group">
      <div class="col-sm-4">アカウント(E-MAIL)</div>
      <div class="col-sm-8"><input type="text" class="form-control" id="email" name="email" value="" maxlength="64" /></div>
    </div>
    <div class="row m-2 form-group">
      <div class="col-sm-4">パスワード</div>
      <div class="col-sm-8"><input type="password" class="form-control" id="password" name="password" maxlength="20" /></div>
    </div>
    <div class="row m-2 form-group">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <!-- submitだと javascriptによる入力チェック処理が呼ばれないので divのbtn とした
  <input type="submit" class="btn btn-success" id="btnlogin" value="ログイン" />
-->
        <div class="btn btn-success" id="btnlogin">ログイン</div>
      </div>
    </div>
  </form>
</div>

<hr />
<div class="container-fluid">
  <div class="row m-2">
    <div class="col-sm-6">はじめてのかたはコチラ</div>
    <div class="col-sm-6">
      <a class="btn btn-primary" id="btnnewgen" href="<?php echo DOMAIN; ?>/public/reg/newgen.php">新規作成</a>
    </div>
  </div>
</div>

<script type="text/javascript">
  // ログイン処理
  function sendLogin() {
    var $pwd = document.getElementById('password').value;
    if (!isPassword($pwd)) {
      onShow('パスワードに間違いがあります(5～12文字以内の半角英数字で設定)');
      return;
    }
    if (!isEmailStr(document.getElementById('email').value)) {
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
  // ログイン失敗したとき、リダイレクトして loging.phpに引数指定で呼び出されるので
  // ダイアログ表示
  echo '<script type="text/javascript">';
  echo '$(function() {';
  echo 'swal("ログインに失敗しました。\\nE-MAIL/パスワードを見直してください");';
  echo '});';
  echo '</script>';
}

$act->end(1);

?>