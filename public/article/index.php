<?php
// 記事一覧表示
require_once "../../app/ArticleAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';

use Novus\ArticleAct;
use Novus\Token;
use Novus\Utils;

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
if (!$page) {
  $page = 0;
}

// 初期は、全体一覧
$title = SYSTITLE;
$headertitle = '';
$searchTextrow = '';
$searchText = filter_input(INPUT_GET, 'searchText');

if ($searchText != '') {
  // 検索指定時
  $searchText =  rawurldecode($searchText); // urldecodeをしておく
  $title = Utils::h($searchText) . 'の検索結果';
  $headertitle = ' (' . $title . ')';
  $searchTextrow = rawurlencode(Utils::h($searchText)); // 特殊文字を変換しておく
}

// 記事一覧
$act = new ArticleAct(0);
$retInfo = $act->articleList($page, $searchText);
$category = $act->categoryMap();

// ログインユーザーのアイコン
if (isset($_SESSION['login_user'])) {
  $icon = $act->getMemberIcon();
}
// Token生成
Token::create();
?>

<div class="row m-2 pt-4 pb-2">
  <?php if (isset($_SESSION['login_user'])) : ?>
    <a href="<?php echo DOMAIN ?>/public/userLogin/mypage.php" class="d-flex align-items-center col-sm-2 text-dark">
      <?php echo (isset($icon) && !empty($icon) ? '<img src="' . DOMAIN . '/public/top/img/' . $icon . '" class="mr-1">' : '<img src="' . DOMAIN . '/public/top/img/sample_icon.png" class="mr-1">') ?>
      <?php echo $act->getMemberName(); ?> さん
    </a>
  <?php else : ?>
    <div class="col-sm-2"></div>
  <?php endif; ?>
  <div class="col-sm-7 text-center">
    <input type="search" style="width:100%;" id="searcharticle" placeholder="キーワードを入力" value="<?php echo Utils::h($searchText); ?>">
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
foreach ($retInfo['articleList'] as $art) {
  // 投稿ユーザ情報
  $user = $retInfo['userMap'][$art['user_id']];
  // 投稿ユーザのアイコン
  $postIcon = $retInfo['userMap'][$art['user_id']]['icon'];
  // 投稿者の名前
  $username = $user["name"];
  // 投稿タイトル
  $title = $art['title'];
  // 投稿日時
  $postdt = Utils::compatiDate($art['upd_date'], 'Y/m/d H:i');
  // カテゴリ名
  $catename = $retInfo["category"][$art["cate_id"]];
  // いいね数
  $postLikeCnt = $retInfo['postLikeMap'][$art['article_id']] ??  0; //合体演算子

  echo '<div class="artfrm" article_id="' . $art['article_id'] . '">';
  echo '<div href="#" class="d-flex align-items-end">';
  echo (isset($postIcon) && !empty($postIcon) ? '<img src="' . DOMAIN . '/public/top/img/' . $postIcon . '" class="mr-1">' : '<img src="' . DOMAIN . '/public/top/img/sample_icon.png" class="mr-1">');
  echo '<span class="arthead ml-1">' . $username . 'さんの投稿</span>';
  echo '</div>';
  echo '<div class="arttitle">' . Utils::h($title) . '</div>';
  echo '<div class="artFootLeft">' . $postdt . '</div>';
  echo '<div class="artFootLeft badge rounded-pill border border-secondary ml-3 ">' . $catename . '</div>';
  echo '<div class="artfoot">' . "&hearts; " . $postLikeCnt . '</div>';
  echo '</div>';
}

if (count($retInfo['articleList']) === 0) {
  echo '<div class="row m-2"><div class="col-sm-12">1件も記事がありません</div></div>';
}
?>

<!-- ページネーション -->
<?php if (count($retInfo['articleList']) > 0) : ?>
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
    if ($end > $retInfo['maxPage']) {
      $end = $retInfo['maxPage'];
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
    if ($page >= $retInfo['maxPage']) {
      echo '<div class="col-sm-1 text-left"><span class="btn btn-link disabled">&gt;</span></div>';
    } else {
      $nextpage = ($page + 1) >= $retInfo['maxPage'] ? $retInfo['maxPage'] : $page + 1;
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $nextpage);
      printf('<div class="col-sm-1 text-left"><a class="btn btn-link" href="%s">&gt;</a></div>', $urlstr);
    }
    // 次送り page=maxPage
    if ($page >= $retInfo['maxPage']) {
      echo '<div class="col-sm-1 text-left"><span class="btn btn-link disabled">&gt;&gt;</span></div>';
    } else {
      $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN . "/public/", $retInfo['maxPage']);
      printf('<div class="col-sm-1 text-left"><a class="btn btn-link" href="%s">&gt;&gt;</a></div>', $urlstr);
    }
    ?>
  </div>
<?php endif ?>


<script type="text/javascript">
  // 初期化処理
  $(function() {
    <?php
    if ($searchTextrow != '') {
      // ブラウザのタイトルを変更 (javascriptないで urldecodeする)
      echo "$('title').html(decodeURIComponent('" . $searchTextrow . "') + 'の検索結果');";
    }
    ?>
  });
  $('.artfrm').click(function() {
    // 記事をクリックした
    $article_id = $(this).attr('article_id');
    // 記事詳細へ
    jumpapi('article/detail.php?article_id=' + $article_id);
  });
  $('#searcharticle').change(function() {
    // 検索フィールド利用

    // 検索キーワード指定で、本ページ再読み込み
    var txtdata = $(this).val();
    jumpapi('article/index.php?page=' + <?php echo $page; ?> + '&searchText=' + encodeURIComponent(txtdata));
  });
</script>

<?php
$act->end(0);
?>