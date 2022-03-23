<?php

include_once "../../articleact.php";

// 記事詳細表示
$act = new ArticleAct();
$act->begin();

$retinfo = NULL;
if (isset($_GET['articleid'])) {
    // 記事詳細情報取得
    $retinfo = $act->article($_GET['articleid']);
}
if ($retinfo == NULL) {
    header('Location: ' . DOMAIN . 'req/article/list.php');
    exit;
}

// カテゴリ名
$catename = $retinfo['category'][$retinfo['article']['CATE_ID']];

// 投稿日時
$postdt = compatiDate($retinfo['article']['UPD_DATE'], 'Y年m月d日 H時');

?>

<div class="row m-2">
 <div class="col-sm-8">
  <a class="btn btn-primary" href="<?php print DOMAIN; ?>/req/article/list.php">一覧に戻る</a>
<?php
if ($retinfo['article']['USER_ID'] != $act->member['USER_ID']) {
    if ($retinfo['postlike'] == NULL || $retinfo['postlike']['LIKE_FLG'] == 0) {
    // イイねボタン押下で、イイねにする
        print('<a class="btn btn-primary" id="btnlike">イイね</a>');
    } else {
    // イイね済み。ボタン押下で、イイねを解除
        print('<a class="btn btn-primary active" id="btnlike">イイね[済]</a>');
    }
}
?>
 </div>
 <div class="col-sm-4"><?php print $act->member['NAME']; ?>さん</div>
</div>

<hr/>
<div class="row m-2">
 <div class="col-sm-8"><?php print $retinfo['user']['NAME'];?>さん (<?php print $postdt; ?> 投稿)</div>
 <div class="col-sm-4"><span id="postlikecnt"><?php print $retinfo['postlikecnt']; ?></span> イイね</div>
</div>

<h5><?php print $retinfo['article']['TITLE']; ?></h5>

<div class="container-fluid">
 <div class="row m-2 form-group" style="height:60%;"><div class="col-sm-12">
 <?php print $retinfo['article']['MESSAGE']; ?>
 </div></div>
 <div class="row m-2 form-group">
  <div class="col-sm-3">カテゴリ</div>
  <div class="col-sm-9"><?php print $catename; ?></div>
 </div>
</div>

<script type="text/javascript">
// イイねボタンを押した
function onPostLike() {
    // ボタンを一時的に無効にする
    var $btnlike = $('#btnlike').unbind().removeClass('active');

    // 送信(ajax)
    var $data = 'articleid=' + <?php print $_GET['articleid']; ?>;
    formapiCallback('req/article/postlike.php', $data, function($result) {
    // 送信結果の処理

        var $postlikecnt = $('#postlikecnt');
        var cnt = parseInt($postlikecnt.html());

        // ボタンを戻す
        $btnlike.click(onPostLike);

        // 画面に反映
        if ($result == 'likeset') {
        // イイねにした
            $btnlike.addClass('active');
            $btnlike.html('イイね[済]');
            $postlikecnt.html(cnt + 1);
        } else {
        // イイね解除。ボタンを再イイねできるようにする。
            $btnlike.html('イイね');
            $postlikecnt.html(cnt > 0 ? cnt - 1: 0);
        }
    });
}
$('#btnlike').click(onPostLike);
</script>

<?php
$act->end();
?>
