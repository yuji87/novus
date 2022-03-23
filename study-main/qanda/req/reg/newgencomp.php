<?php

include_once "../../def.php";
include_once "../../act.php";

// ベースクラス
$act = new Action();
$act->begin_free();

?>

<div>アカウントを作成しました!</div>
<p>
<?php print SYSTITLE; ?>ご利用ありがとうございます。<br/>
アカウントの登録が完了しました。<br/>


<div class="row m-2">
 <a class="btn btn-primary" href="<?php print DOMAIN; ?>/req/top.php"><i class="fas fa-phone-alt fa-position-left"></i>ログイン画面へ</a>
</div>

<?php
$act->end(1);
?>
