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
   <div class="btn btn-success" id="btnnewgen" onclick="jumpapi('req/top.php')">トップページへ</div>
  </div>
 </div>
</div>

<hr/>

<?php
$act->end(1);
?>
