<?php
// 記事一覧表示
require_once "../../app/ArticleAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';

use Qanda\ArticleAct;
use Qanda\Token;
use Qanda\Utils;

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
if (!$page) {
  $page = 0;
}

// 初期は、全体一覧
$title = SYSTITLE;
$headertitle = '';
$searchtextrow = '';
$searchtext = filter_input(INPUT_GET, 'searchtext');

if ($searchtext != '') {
  // 検索指定時
  $searchtext =  rawurldecode($searchtext); // urldecodeをしておく
  $title = Utils::h($searchtext) . 'の検索結果';
  $headertitle = ' (' . $title . ')';
  $searchtextrow = rawurlencode(Utils::h($searchtext)); // 特殊文字を変換しておく
}

// 記事一覧
$act = new ArticleAct(0);
$retinfo = $act->articlelist($page, $searchtext);
$category = $act->categorymap();

// ログインユーザーのアイコン
$icon = $act->getMemberIcon();

// Token生成
Token::create();
?>
<div class="row m-2 pt-4 pb-2">
  <?php if (isset($_SESSION['login_user'])) : ?>
    <a href="<?php echo DOMAIN ?>/public/myPage/index.php" class="d-flex align-items-center col-sm-2 text-dark">
      <?php echo (isset($icon) ? '<img src="'. DOMAIN .'/public/top/img/'. $icon .'" class="mr-1">' : '<img src="'. DOMAIN .'/public/top/img/sample_icon.png" class="mr-1">') ?>
      <?php echo $act->getMemberName(); ?> さん
    </a>
  <?php endif; ?>
  <div class="col-sm-7 text-center">
    <input type="search" style="width:100%;" id="searcharticle" placeholder="キーワードを入力" value="<?php echo Utils::h($searchtext); ?>" />
  </div>
  <div class="d-flex align-items-center col-sm-3">
  <select class="" id="searcharticle" name="category" placeholder="カテゴリ">
    <?php
      // echo '<option></option>';
    foreach ($category as $key => $val) {
      printf('<option value="%s">%s</option>', $key, $val);
    }
    ?>
  </select>
  </div>
</div>

<h5 class="artListTitle mt-3 font-weight-bold">記事一覧 <?php echo $headertitle; ?></h5>

<?php
//全データを各投稿ごとに展開
foreach ($retinfo['articlelist'] as $art) {
  // 投稿ユーザ情報
  $user = $retinfo['usermap'][$art['USER_ID']];
  // 投稿ユーザのアイコン
  $postIcon = $retinfo['usermap'][$art['USER_ID']]['ICON'];
  // 投稿者の名前
  $username = $user["NAME"];
  // 投稿タイトル
  $title = $art['TITLE'];
  // 投稿日時
  $postdt = Utils::compatiDate($art['UPD_DATE'], 'Y/m/d H:i');
  // カテゴリ名
  $catename = $retinfo["category"][$art["CATE_ID"]];
  // いいね数
  $postlikecnt = $retinfo['postlikemap'][$art['ARTICLE_ID']] ??  0; //合体演算子

  echo '<div class="artfrm" articleid="' . $art['ARTICLE_ID'] . '">';
  echo '<a href="#" class="d-flex align-items-end">';
  echo (isset($postIcon) ? '<img src="'. DOMAIN .'/public/top/img/'. $postIcon .'" class="mr-1">' : '<img src="'. DOMAIN .'/public/top/img/sample_icon.png" class="mr-1">');
  echo '<span class="arthead ml-1">' . $username . 'さんの投稿</span>';
  echo '</a>';
  echo '<div class="arttitle">' . Utils::h($title) . '</div>';
  echo '<div class="artFootLeft">' . $postdt . '</div>';
  echo '<div class="artFootLeft badge rounded-pill border border-secondary ml-3 ">' . $catename . '</div>';
  echo '<div class="artfoot">' . "&hearts; " . $postlikecnt . '</div>';
  echo '</div>';
}

if (count($retinfo['articlelist']) == 0) {
  echo '<div class="row m-2"><div class="col-sm-12">1件も記事はありません</div></div>';
}
?>

<!-- ページネーション -->
<?php if (count($retinfo['articlelist']) > 0) : ?>
  <div class="row offset-sm-3 col-sm-9">
    <?php
    // 一番最初に戻る(page=0)
    if ($page <= 0) {
      echo '<div class="col-sm-1 text-right"><span class="btn btn-link disabled ">&lt;&lt;</span></div>';
    } else {
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", 0);
      printf('<div class="col-sm-1 text-right"><a class="btn btn-link" href="%s">&lt;&lt;</a></div>', $urlstr);
    }
    // ひとつ前に戻る(page)
    if ($page <= 0) {
      echo '<div class="col-sm-1 text-right"><span class="btn btn-link disabled ">&lt;</span></div>';
    } else {
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $page - 1);
      printf('<div class="col-sm-1 text-right"><a class="btn btn-link" href="%s">&lt;</a></div>', $urlstr);
    }
    // ページボタン
    $start = $page - 3;
    if ($start < 0) {
      $start = 0;
    }
    $end = $page + 3;
    if ($end > $retinfo['MAXPAGE']) {
      $end = $retinfo['MAXPAGE'];
    }
    for ($i = $start; $i <= $end; $i++) {
      if ($i == $page) {
        printf('<div class="col-sm-1 cur"><a class="btn btn-primary  disabled">%d</a></span></div>', $i + 1); //表示
      } else {
        $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $i);
        printf('<div class="col-sm-1"><a class="btn btn-light" href="%s">%d</a></span></div>', $urlstr, $i + 1); //表示
      }
    }
    // 次送り 一つ先
    if ($page >= $retinfo['MAXPAGE']) {
      echo '<div class="col-sm-1 text-left"><span class="btn btn-link disabled">&gt;</span></div>';
    } else {
      $nextpage = ($page + 1) >= $retinfo['MAXPAGE'] ? $retinfo['MAXPAGE'] : $page + 1;
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $nextpage);
      printf('<div class="col-sm-1 text-left"><a class="btn btn-link" href="%s">&gt;</a></div>', $urlstr);
    }
    // 次送り page=MAXPAGE
    if ($page >= $retinfo['MAXPAGE']) {
      echo '<div class="col-sm-1 text-left"><span class="btn btn-link disabled">&gt;&gt;</span></div>';
    } else {
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $retinfo['MAXPAGE']);
      printf('<div class="col-sm-1 text-left"><a class="btn btn-link" href="%s">&gt;&gt;</a></div>', $urlstr);
    }
    ?>
  </div>
<?php endif ?>


<script type="text/javascript">
  // 初期化処理
  $(function() {
    <?php
    if ($searchtextrow != '') {
      // ブラウザのタイトルを変更 (javascriptないで urldecodeする)
      echo "$('title').html(decodeURIComponent('" . $searchtextrow . "') + 'の検索結果');";
    }
    ?>
  });
  $('.artfrm').click(function() {
    // 記事をクリックした
    $articleid = $(this).attr('articleid');
    // 記事詳細へ
    jumpapi('article/detail.php?articleid=' + $articleid);
  });
  $('#searcharticle').change(function() {
    // 検索フィールド利用

    // 検索キーワード指定で、本ページ再読み込み
    var txtdata = $(this).val();
    jumpapi('article/index.php?page=' + <?php echo $page; ?> + '&searchtext=' + encodeURIComponent(txtdata));
  });
</script>

<?php
$act->end(0);
?>