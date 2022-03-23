<?php

include_once "../../articleact.php";

$act = new ArticleAct();
$act->begin(1);

if (isset($_POST['articleid']) == TRUE && $_POST['articleid'] > 0) {
    // 記事にイイね設定/解除
    $retcode = $act->postlikearticle($_POST['articleid']);

    // ajax呼び出し。 戻り値を出力
    print $retcode;
}
else {
    // ajax呼び出し。 戻り値を出力
    print 'failed';
}

?>
