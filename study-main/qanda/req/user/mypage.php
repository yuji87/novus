<?php

include_once "../../articleact.php";

// イイねした記事情報取得
$act = new ArticleAct();
$act->begin();
$retinfo = $act->postlikeArticleList();

?>

<h5>ホーム画面</h5>
<div class="row m-2">
 <div class="col-sm-8"></div>
 <div class="col-sm-4"><?php print $act->member['NAME']; ?>さん</div>
</div>

<h5>イイねした記事 (最新<?php print LISTCOUNT_MYPAGE; ?>件)</h5>
<?php
foreach ($retinfo['articlelist'] as $art) {
    // ユーザ情報
    $user = $retinfo['usermap'][$art['USER_ID']];
    $username = ($user == NULL) ? '通りがかりの人': $user['NAME'];
    // 投稿日時
    $postdt = compatiDate($art['UPD_DATE'], 'Y年m月d日 H時');
    // 自分が投稿した記事は編集可能。他人の記事は閲覧のみ
    $mode = ($art['USER_ID'] == $act->member['USER_ID']) ? 'update': 'detail';
    // イイね数
    $postlikecnt = isset($retinfo['postlikemap'][$art['ARTICLE_ID']]) ? $retinfo['postlikemap'][$art['ARTICLE_ID']]: 0;

    echo '<div class="artfrm" articleid="' . $art['ARTICLE_ID'] . '" mode="' . $mode . '">';
    echo '<div class="arthead">' . $username . 'が' . $postdt . ' に投稿</div>';
    echo '<div class="arttitle">' . $art['TITLE'] . '</div>';
    echo '<div class="artfoot">' . $postlikecnt . 'イイね</div>';
    echo '</div>';

}
if (count($retinfo['articlelist']) == 0) {
    echo '<div class="row m-2"><div class="col-sm-12">1件も記事はありません</div></div>';
}
?>


<h5>メニュー</h5>
<div class="row m-2">
 <div class="col-sm-6">
  <a class="btn btn-link" href="<?php print DOMAIN; ?>/req/todo/list.php">ToDoリスト</a>
 </div>
 <div class="col-sm-6">
 </div>
</div>
<div class="row m-2">
 <div class="col-sm-6">
  <a class="btn btn-link" href="<?php print DOMAIN; ?>/req/article/list.php">記事リスト</a>
 </div>
 <div class="col-sm-6">
 </div>
</div>


<script type="text/javascript">
$(function() {
});
$('.artfrm').click(function() {
// 記事をクリックした

    $articleid = $(this).attr('articleid');
    $mode = $(this).attr('mode');
    if ($mode == 'update') {
    // 記事編集へ
        jumpapi('req/article/postedit.php?articleid=' + $articleid);
    }
    else {
    // 記事詳細へ
        jumpapi('req/article/detail.php?articleid=' + $articleid);
    }
});
</script>

<?php
$act->end();
?>
