<?php
require_once "../../app/ArticleAct.php";
require_once '../../app/Token.php';
require_once "../../app/Utils.php";

use Novus\ArticleAct;
use Novus\Token;
use Novus\Utils;

// 記事投稿/編集
$act = new ArticleAct();
$act->begin();
$category = $act->categoryMap();

// Token生成
Token::create();

//ログインチェック
$act->checkLogin();

$retInfo = NULL;

$article_id = 0;
$title = '';
$message = '';
$catval = 0;

// 初期は新規投稿モード
$modename = '投稿';
$modenamebtn = '投稿';

$article_id = filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT);
if ($article_id) {
  // ID指定の場合編集モードにする
  $modename = '編集画面';
  $modenamebtn = '編集反映';
  $retInfo = $act->article($article_id);
}

if ($retInfo != NULL && $retInfo['article'] != NULL) {
  // 編集モード時の、パラメータ設定
  $article_id = $_GET['article_id'];
  $title = Utils::h($retInfo['article']['title']);
  $message = Utils::h($retInfo['article']['message']);
  $catval = $retInfo['article']['cate_id'];
}
?>

<h5 class="artListTitle mt-3 font-weight-bold">記事<?php echo $modename; ?></h5>
<div class="container-fluid">
  <form method="POST" class="form-horizontal" name="NovusForm">
    <div class="row m-2 form-group">
      <div class="col-sm-12">
        <input type="text" class="form-control" id="title" name="title" maxlength="64" placeholder="タイトル" value="<?php echo $title; ?>">
      </div>
    </div>
    <div class="row m-2 form-group" style="height:55vh">
      <!-- 入力欄 -->
      <div class="col-sm-6">
        <textarea class="form-control" id="message" name="message" placeholder="本文" style="overflow: hidden; overflow-wrap: break-word; height: 100%; overflow:scroll; overflow-x: hidden; height:450px"><?php echo $message; ?></textarea>
      </div>
      <!-- プレビュー表示欄 -->
      <div class="col-sm-6">
        <div class="artpreview artContents" id="previewmsg" style="overflow:scroll; overflow-x: hidden; height:450px;"></div>
      </div>
    </div>
    <div class="row m-2 form-group">
      <div class="col-sm-3">カテゴリ</div>
      <div class="col-sm-9">
        <select id="category" name="category" style="width:100%;" placeholder="カテゴリ">
          <?php
          foreach ($category as $key => $val) {
            printf('<option value="%s">%s</option>', $key, $val);
          }
          ?>
        </select>
      </div>
    </div>
    <div class="row m-2 form-group">
      <div class="col-sm-12 text-center">
        <input type="hidden" name="article_id" id="article_id" value="<?php echo $article_id; ?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
        <div class="btn btn-success" onclick="onPostArticle();"><?php echo $modenamebtn; ?></div>
      </div>
      <div class="col-sm-12 text-right">
        <?php
        if ($article_id > 0) {
          echo ('<div class="btn btn-warning" onClick="onDelete();">削除</div>');
        }
        ?>
        <a class="btn btn-primary" href="<?php echo DOMAIN; ?>/public/article/index.php">一覧に戻る</a>
        <div class="open btn btn-primary">説明</div>
        <div class="modal">
          <div class="modal_bg"></div>
          <div class="modal_window">
            <div class="modal_title text-center">
              <h3 class="mt-4 mb-4" style="font-weight: bold;">利用方法</h3>
            </div>
            <div class="text-center">
              # おはよう → <span style="font-size:2.5rem; font-weight:500; line-height:1.2;">おはよう</span><br>
              ## おはよう → <span style="font-size:2rem; font-weight:500; line-height:1.2;">おはよう</span><br>
              ### おはよう → <span style="font-size:1.75rem; font-weight:500; line-height:1.2;">おはよう</span><br><br>
              - おはよう → <span>・おはよう</span><br><br>
              ~~おはよう~~ → <del>おはよう</del><br><br>
              `おはよう` → <span style="color:red;">おはよう</span>
            </div>
            <div class="close btn btn-danger mt-3 mr-3">CLOSE</div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  // 初期化
  $(function() {
    $('#message').keyup(function() {
      // 本文にキーが入力された
      // プレビュー画面に文字列を反映
      setupPreview();
    });
    // 初期値
    $('#category').val(<?php echo $catval; ?>);
    setupPreview();
  });

  // プレビュー画面に文字列を反映
  function setupPreview() {
    //    var text = htmlspecialchars($('#message').val()); // タグ全部無効
    var text = $('#message').val();
    text = trimHtmlTag(text); // 一部タグを許容
    text = marked(text); // マークアップ文字置き換え
    text = text.replace(/\n/g, '<br>'); // 改行
    $('#previewmsg').html(text);
  }
  // 投稿 or 編集反映ボタンを押した
  function onPostArticle() {
    if (!isStrLen(document.getElementById('title').value, 1, <?php echo TITLE_LENGTH; ?>)) {
      onShow('タイトルを見直してください');
      return;
    }
    if (!isStrLen(document.getElementById('message').value, 1, <?php echo MESSAGE_LENGTH; ?>)) {
      onShow('本文を見直してください');
      return;
    }

    var $data = 'title=' + encodeURIComponent(document.getElementById('title').value) +
      '&message=' + encodeURIComponent(document.getElementById('message').value) +
      '&category=' + document.getElementById('category').value +
      '&article_id=' + document.getElementById('article_id').value +
      '&token=<?php echo $_SESSION["token"]; ?>';

    // 送信(ajax)
    formapiCallback('article/process/post.php', $data, function($retcode) { //ファイルの中身を読み込む
      // 送信完了後の処理
      if ($retcode == 'success') {
        swal({
          text: '投稿しました'
        }).then(function(isConfirm) {
          var $article_id = $('#article_id').val();
          // 記事詳細へ戻す                                
          jumpapi('article/detail.php?article_id=' + $article_id);
        });
      }
      switch ($retcode) {
        case 'failed-title':
          onShow('タイトルは150文字以内で入力してください');
          break;
        case 'failed-message':
          onShow('本文は1500文字以内で入力してください');
          break;
        case 'failed-category':
          onShow('カテゴリが入力されていません');
          break;
        default:
          break;
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

  $(function() {
    $(".open").click(function() {
      $(".modal").fadeIn();
    });
    $(".close").click(function() {
      $(".modal").fadeOut();
    });
    $(".modal_bg").click(function() {
      $(".modal").fadeOut();
    });
  });
</script>

<?php
$act->printFooter(1);
?>