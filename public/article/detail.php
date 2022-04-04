<?php
// 記事一覧表示
require_once "../../app/ArticleAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';
require_once "../../app/VendorUtils.php";

use Novus\ArticleAct;
use Novus\Token;
use Novus\Utils;
use Novus\VendorUtils;

$act = new ArticleAct();
$act->begin();
Token::create(); //Token生成

$retInfo = NULL;
$article_id = filter_input(INPUT_GET, "article_id", FILTER_VALIDATE_INT);

if ($article_id) {
  // 記事詳細情報取得
  $retInfo = $act->article($article_id);
}
if ($retInfo == NULL) {
  // 記事がない場合は、記事一覧へリダイレクト
  header("Location: " . DOMAIN . "/public/article/index.php");
  exit;
}

$category = $act->categoryMap();
// カテゴリ名
$catename = $retInfo["category"][$retInfo["article"]["cate_id"]];

// 投稿日時
$postdt = Utils::compatiDate($retInfo["article"]["upd_date"], "Y/m/d H:i");

// 投稿内容
$message = $retInfo['article']['message'];
$message = VendorUtils::markDown($message); // マークダウンの変換
$message = Utils::trimHtmlTag($message); // 一部タグを許容、他は変換
$message = Utils::compatiStr($message); // 改行を <br/>
?>

<!-- ここから本文 -->
<h5 class="artListTitle mt-3 font-weight-bold">記事詳細</h5>
<!-- 投稿者名といいね数 -->
<div class="row m-2">
  <?php if(isset($_SESSION['login_user']['user_id']) && $_SESSION['login_user']['user_id'] === $retInfo["article"]["user_id"]): ?>
    <a href="<?php echo DOMAIN ?>/public/userLogin/mypage.php" class="d-flex align-items-center col-sm-9 text-dark">
      <?php echo (isset($icon) ? '<img src="'. DOMAIN .'/public/user/img/'. $icon .'" class="mr-1">' : '<img src="'. DOMAIN .'/public/user/img/sample_icon.png" class="mr-1">') ?>
      <?php echo $act->getMemberName(); ?> さん
    </a>
  <?php else: ?>
    <a href="<?php echo DOMAIN ?>/public/userLogin/userpage.php?user_id=<?php echo $retInfo["article"]["user_id"] ?>" class="d-flex align-items-center col-sm-9 text-dark">
      <?php echo (isset($retInfo["user"]["icon"]) ? '<img src="'. DOMAIN .'/public/user/img/'. $retInfo["user"]["icon"] .'" class="mr-1">' : '<img src="'. DOMAIN .'/public/user/img/sample_icon.png" class="mr-1">'); ?>
      <?php echo $retInfo["user"]["name"]; ?>さんの投稿
    </a>
  <?php endif ?> 
  <div class="d-flex align-items-center col-sm-2 mt-2">
    <?php
    if (isset($_SESSION['login_user']) && $retInfo["article"]["user_id"] != $act->getMemberId()) {
      if ($retInfo["postLike"] == NULL || $retInfo["postLike"]["like_flg"] == 0) {
        // いいねボタン押下で、いいねにする
        print('<a class="btn btn-warning like" id="btnlike">いいね</a>');
      } else {
        // いいね済み。ボタン押下で、いいねを解除
        print('<a class="btn btn-warning active liked" id="btnlike">いいね</a>');
      }
    }
    ?>
  <span class="ml-3">&hearts; <span id="postLikeCnt"><?php echo $retInfo["postLikeCnt"]; ?></span></span>
  </div>
</div>

<!-- タイトルと本文 -->
<div class="container-fluid">
  <!-- タイトル -->
  <div class="row m-2 form-group" style="height:55vh;">
    <div class="col-sm-12" style="word-break:break-all;">
      <h2 class="artDetailTitle"><?php echo Utils::h($retInfo['article']['title']); ?></h2>
      <span class="artDetailContents" id="preview"><?php echo $message; ?></span>
    </div>
  </div>
  <!-- カテゴリバッジ -->
  <div class="row m-2 form-group">
    <div class="catename col-sm-1">
      <div class="badge rounded-pill bg-danger p-2">
        <?php echo $catename; ?>
      </div>
    </div>
    <div class="col-sm1-11"></div>
  </div>
  <!-- 日付 -->
  <div class="row m-2 form-group">
    <div class="artFootLeft col-sm-2"><?php echo $postdt; ?></div>
    <div class="artFootLeft col-sm-10"></div>
  </div>
</div>

<hr>
<div class="row m-2">
  <div class="col-sm-6">
    <?php if (isset($_SESSION['login_user'])) : ?>
      <a class="btn btn-success m-2" href="<?php echo DOMAIN; ?>/public/userLogin/home.php">ホーム画面へ</a>
    <?php else : ?>
      <a class="btn btn-success m-2" href="<?php echo DOMAIN; ?>/public/user/top.php">ホーム画面へ</a>
    <?php endif ?>
  </div>
  <div class="col-sm-6">
    <a class="btn btn-primary m-2" href="<?php echo DOMAIN; ?>/public/article/index.php">一覧に戻る</a>
    <?php
    if (isset($_SESSION['login_user']) && $retInfo["article"]["user_id"] == $act->getMemberId()) {
      // 自分が投稿した記事
      printf(
        '<a class="btn btn-primary m-2" href="%sarticle/postedit.php?article_id=%d">編集する</a>',
        DOMAIN . "/public/",
        $article_id
      );
      print('<div class="btn btn-primary m-2" id="btndelete">削除する</div>');
    }
    ?>
  </div>
</div>

<script type="text/javascript">
  // いいねボタンを押したとき
  function onPostLike() {
    // ボタンを一時的に無効にする
    const $btnlike = $('#btnlike').off().removeClass('active');

    // 送信(ajax)
    var $data = 'article_id=' + <?php echo $_GET['article_id']; ?> + '&token=<?php echo $_SESSION["token"]; ?>';
    formapiCallback('article/process/postLike.php', $data, function($result) {

      const $postLikeCnt = $('#postLikeCnt');
      const cnt = parseInt($postLikeCnt.html());

      // ボタンを戻す
      $btnlike.click(onPostLike);

      // 画面に反映
      if ($result == 'likeset') {
        // いいねにした
        $btnlike.addClass('active');
        $btnlike.html('いいね');
        $postLikeCnt.html(cnt + 1);
      } else {
        // いいね解除。ボタンを再いいねできるようにする。
        $btnlike.html('いいね');
        $postLikeCnt.html(cnt > 0 ? cnt - 1 : 0); //三項演算子 → 条件式 ? true式1 : false式2
      }
    });
  }
  // 削除ボタンを押した
  function onDelete() {
    swal({
      text: '削除してもよろしいですか？',
      icon: 'warning',
      buttons: true,
      dangerMode: true
    }).then(function(isConfirm) {
      if (isConfirm) {

        var $data = 'article_id=' + <?php echo $article_id; ?> +
          '&token=<?php echo $_SESSION["token"]; ?>';

        formapiCallback('article/process/delete.php', $data, function($retcode) {
          // 投稿一覧画面へ
          jumpapi('article/index.php');
        });
      }
    });
  }
  // 初期化
  $(function() {
    // ボタン
    $('#btnlike').click(onPostLike);
    $('#btndelete').click(onDelete);

  });
</script>

<?php
$act->end(1);
?>