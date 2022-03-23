<?php

include_once "../../articleact.php";

$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$title = SYSTITLE;
$headertitle = '';
$searchtext = '';
if (isset($_GET['searchtext']) && $_GET['searchtext'] != '') {
// 検索指定時

    $searchtext = $_GET['searchtext'];
    $title = $searchtext . 'の検索結果';
    $headertitle = ' (' . $title . ')';
}

// 記事一覧
$act = new ArticleAct();
$act->begin();
$retinfo = $act->articlelist($page, $searchtext);

?>

<div class="row m-2">
 <div class="col-sm-2">
  <a class="btn btn-primary" href="<?php print DOMAIN; ?>/req/article/postedit.php">投稿する</a>
 </div>
 <div class="col-sm-7">
  <input type="search" style="width:100%;" id="searcharticle" placeholder="キーワードを入力" value="<?php print $searchtext; ?>" />
 </div>
 <div class="col-sm-3"><?php print $act->member['NAME']; ?>さん</div>
</div>

<h5>記事一覧 <?php print $headertitle; ?></h5>

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

    echo '<div class="artfrm" articleid="' . $art['ARTICLE_ID'] . '" mode="' . $mode .'">';
    echo '<div class="arthead">' . $username . 'が' . $postdt . 'に投稿</div>';
    echo '<div class="arttitle">' . $art['TITLE'] . '</div>';
    echo '<div class="artfoot">' . $postlikecnt . 'イイね</div>';
    echo '</div>';
}
if (count($retinfo['articlelist']) == 0) {
    echo '<div class="row m-2"><div class="col-sm-12">1件も記事はありません</div></div>';
}

// ページセクション
echo '<div class="row m-2">';
// 前送り
if ($page <= 0) {
    echo '<div class="col-sm-4 text-right"><span class="btn btn-link disabled ">← 前</span></div>';
} else {
    $urlstr = sprintf("%s/req/article/list.php?page=%d", DOMAIN, $page - 1);
    printf('<div class="col-sm-4 text-right"><a class="btn btn-link" href="%s">← 前</a></div>', $urlstr);
}
// ページとページ数
printf('<div class="col-sm-4 text-center"><span style="line-height:2.0rem;">%d / %d</span></div>',
    ($page + 1), ($retinfo['MAXPAGE'] + 1));
// 次送り
if ($page >= $retinfo['MAXPAGE']) {
    echo '<div class="col-sm-4 text-left"><span class="btn btn-link disabled">次 →</span></div>';
} else {
    $urlstr = sprintf("%s/req/article/list.php?page=%d", DOMAIN, $page + 1);
    printf('<div class="col-sm-4 text-left"><a class="btn btn-link" href="%s">次 →</a></div>', $urlstr);
}
echo '</div>';

?>

<script type="text/javascript">
// 初期化処理
$(function() {
    // ブラウザのタイトルを変更
    $('title').html('<?php print $title; ?>')
});
$('.artfrm').click(function() {
// 記事をクリックした
    $articleid = $(this).attr('articleid');
    $mode = $(this).attr('mode');
    if ($mode == 'update') {
    // 記事編集へ
        jumpapi('req/article/postedit.php?articleid=' + $articleid);
    } else {
    // 記事詳細へ
        jumpapi('req/article/detail.php?articleid=' + $articleid);
    }
});
$('#searcharticle').change(function() {
// 検索フィールド利用

    // 検索キーワード指定で、本ページ再読み込み
    var txtdata = $(this).val();
    jumpapi('req/article/list.php?page=' + <?php print $page; ?> + '&searchtext=' + txtdata);
});
</script>

<?php
$act->end();
?>

