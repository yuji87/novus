<?php
// 記事一覧表示
require_once "../../app/ArticleAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';

use Novus\ArticleAct;
use Novus\Token;
use Novus\Utils;

$currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
if ($currentPage !== '') {
    $currentPage = (int)$currentPage;
    if ($currentPage <= 0) {
      $currentPage = 1;
    }
} else {
    $currentPage = 1;
}

// 初期は、全体一覧
$title = SYSTITLE;
$headertitle = '';
$searchTextrow = '';
$searchCategoryrow = '';

$searchText = filter_input(INPUT_GET, 'searchText') ?? '';
$searchCategory = filter_input(INPUT_GET, 'searchCategory') ?? '';

if ($searchText !== '') {
  // 検索指定時
  $searchText =  rawurldecode($searchText); // urldecodeをしておく
  $title = Utils::h($searchText) . 'の検索結果';
  $headertitle = ' (' . $title . ')';
  $searchTextrow = rawurlencode(Utils::h($searchText)); // 特殊文字を変換しておく
}
if ($searchCategory !== '') {
  $searchCategoryrow = rawurlencode(Utils::h($searchCategory)); // 特殊文字を変換しておく
}

// 記事一覧
$act = new ArticleAct(0);
$retInfo = $act->articleList($currentPage, $searchText, $searchCategory);

// ぺージ数が不正だった場合を考慮し、書き換える
$currentPage = $retInfo['page'];

$category = $act->categoryMap();

// ログインユーザーのアイコンと名前
if (isset($_SESSION['login_user'])) {
  $icon = $act->getMemberIcon();
  $name = $act->getMemberName();
}

// Token生成
Token::create();

$params = [];
if ($searchTextrow !== '') {
    $params[] = "searchText=$searchTextrow";
}
if ($searchCategoryrow !== '') {
    $params[] = "searchCategory=$searchCategoryrow";
}
$query = !empty($params) ? '&' . implode('&', $params) : '';
?>

<div class="row m-2 pt-4 pb-2 align-items-center">
  <?php if (isset($_SESSION['login_user'])) : ?>
    <a href="<?php echo DOMAIN ?>/public/myPage/index.php" class="d-flex align-items-center col-sm-2 text-dark">
      <?php echo (isset($icon) && !empty($icon) ? '<img src="' . DOMAIN . '/public/top/img/' . $icon . '" class="mr-1">' : '<img src="' . DOMAIN . '/public/top/img/sample_icon.png" class="mr-1">') ?>
      <span style="overflow: hidden; overflow-wrap: break-word;"><?php echo $name ?> さん</span>
    </a>
  <?php else : ?>
    <div class="col-sm-2"></div>
  <?php endif; ?>
  <div class="col-sm-7 text-center">
    <input type="search" style="width:100%;" class="search-text" placeholder="キーワードを入力" value="<?php echo Utils::h($searchText); ?>">
  </div>
  <div class="d-flex col-sm-3">
    <select class="search-category" name="category" placeholder="カテゴリ">
      <?php
      echo "<option value=''></option>";
      foreach ($category as $key => $val) {
        printf('<option value="%s"%s>%s</option>', $key, $key == $searchCategory ? ' selected' : '', $val);
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
    <div>
        <ul class="pagination justify-content-center">
        <?php
        // 一番最初に戻る(page=0)
        if ($currentPage <= 1) {
            echo '<li class="page-item page-item-nav"><span class="btn btn-link disabled">&lt;&lt;</span></li>';
        } else {
            $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN."/public/", 1, $query);
            printf('<li class="page-item page-item-nav"><a class="btn btn-link" href="%s">&lt;&lt;</a></li>', $urlstr);
        }
        // ひとつ前に戻る(page)
        if ($currentPage <= 1) {
            echo '<li class="page-item page-item-nav" style="width: 36px;"><span class="btn btn-link disabled ">&lt;</span></li>';
        } else {
            $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN."/public/", $currentPage - 1, $query);
            printf('<li class="page-item page-item-nav"><a class="btn btn-link" href="%s">&lt;</a></li>', $urlstr);
        }
        // ページボタン
        if ($currentPage <= 3) {
            $start = 1;
        } elseif ($currentPage > $retInfo['maxPage'] - 2) {
            $start = $retInfo['maxPage'] - 4;
        } else {
            $start = $currentPage - 2;
        }

        if ($start + 4 <= $retInfo['maxPage']) {
            $end = $start + 4;
        } else {
            $end = $retInfo['maxPage'];
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                printf('<li class="page-item page-item-page"><a class="btn btn-primary disabled">%d</a></span></li>', $i); //表示
            } else {
                $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN."/public/", $i, $query);
                printf('<li class="page-item page-item-page"><a class="btn btn-light" href="%s">%d</a></span></li>', $urlstr, $i); //表示
            }
        }
        // 次送り 一つ先
        if ($currentPage >= $retInfo['maxPage']) {
            echo '<li class="page-item page-item-nav"><span class="btn btn-link disabled">&gt;</span></li>';
        } else {
            $nextpage = ($currentPage + 1) >= $retInfo['maxPage'] ? $retInfo['maxPage'] : $currentPage + 1;
            $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN."/public/", $nextpage, $query);
            printf('<li class="page-item page-item-nav"><a class="btn btn-link" href="%s">&gt;</a></li>', $urlstr);
        }
        // 次送り page=maxPage
        if ($currentPage >= $retInfo['maxPage']) {
            echo '<li class="page-item page-item-nav"><span class="btn btn-link disabled">&gt;&gt;</span></li>';
        } else {
            $urlstr = sprintf("%sarticle/index.php?page=%d", DOMAIN."/public/", $retInfo['maxPage'], $query);
            printf('<li class="page-item page-item-nav"><a class="btn btn-link" href="%s">&gt;&gt;</a></li>', $urlstr);
        }
        ?>
        </ul>
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

    $('.search-text, .search-category').change(function() {
    // 検索フィールド利用

    // 検索キーワード指定で、本ページ再読み込み
    var searchText = $('.search-text').val();
    var searchCategory = $('.search-category').val();

    var params = [];
    if (searchText !== '') params.push('searchText=' + encodeURIComponent(searchText));
    if (searchCategory !== '') params.push('searchCategory=' + encodeURIComponent(searchCategory));
    var url = params.length ? '&' + params.join('&') : '';
    jumpapi('article/index.php?page=' + <?php echo $currentPage; ?> + url);
  });
</script>

<?php
$act->printFooter(0);
?>