<?php

include_once '../act.php';

$act = new Action();
$msg = $act->logout();

$act->begin_free();

echo $msg;
?>

<div class="container-fluid">
 <div class="row m-2">
  <div class="col-sm-4"></div>
  <div class="col-sm-8">
   <a class="btn btn-success" id="btnnewgen" href="<?php print DOMAIN; ?>/req/top.php">トップページへ</a>
  </div>
 </div>
</div>

<hr/>

<?php
$act->end(1);
?>
