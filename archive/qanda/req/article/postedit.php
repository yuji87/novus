<?php

include_once "../../articleact.php";

$act = new ArticleAct();
$act->begin();
$category = $act->categorymap();

$retinfo = NULL;

$articleid = 0;
$title = '';
$message = '';
$catval = 0;

$modename = '投稿';
$modenamebtn = '投稿';

if (isset($_GET['articleid'])) {
// ID指定の場合編集モード
	$modename = '編集';
	$modenamebtn = '編集反映';
	$retinfo = $act->article($_GET['articleid']);
}
if ($retinfo != NULL && $retinfo['article'] != NULL) {
	$articleid = $_GET['articleid'];
	$title = $retinfo['article']['TITLE'];
	$message = $retinfo['article']['MESSAGE'];
	$catval = $retinfo['article']['CATE_ID'];
}

?>

<div class="row m-2">
 <div class="col-sm-8">
  <div class="btn btn-primary" onClick="jumpapi('req/article/list.php')">一覧に戻る</div>
<?php
if ($articleid > 0) {
	print('<div class="btn btn-warning" onClick="onDelete();">削除</div>');
}
?>
 </div>
 <div class="col-sm-4"><?php print $act->member['NAME']; ?>さん</div>
</div>

<h5>記事<?php print $modename; ?></h5>

<div class="container-fluid">
<form method="POST" class="form-horizontal" name="qandaForm">
<div class="row m-2 form-group">
 <div class="col-sm-12">
  <input type="text" class="form-control" id="title" name="title" maxlength="64" placeholder="タイトル" value="<?php print $title; ?>" />
 </div>
</div>
<div class="row m-2 form-group" style="height:60%;">
 <div class="col-sm-6">
  <textarea class="form-control" id="message" name="message" placeholder="本文" style="overflow: hidden; overflow-wrap: break-word; height: 100%;"><?php print $message; ?></textarea>
 </div>
 <div class="col-sm-6">
  <div style="width:100%;height:100%;" id="previewmsg">
  </div>
 </div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-3">カテゴリ</div>
 <div class="col-sm-9"><select id="category" name="category" style="width:100%;" placeholder="カテゴリ">
<?php
	foreach ($category as $key => $val) {
		printf('<option value="%s">%s</option>', $key, $val);
	}
?>
 </select></div>
</div>
<div class="row m-2 form-group">
 <div class="col-sm-12 text-center">
  <input type="hidden" name="articleid" id="articleid" value="<?php print $articleid; ?>" />
  <div class="btn btn-success" onclick="onPostArticle();"><?php print $modenamebtn; ?></div>
 </div>
</div>
</form>
</div>

<script type="text/javascript">
$(function() {
	$('#message').keyup(function() {
		$('#previewmsg').html($('#message').val());
	});

	// 初期値
	$('#category').val(<?php print $catval; ?>);
	$('#previewmsg').html($('#message').val());
});
function onPostArticle() {
	if (isEmpty(document.getElementById('title').value)) {
		onShow('タイトルを入力してください');
		return;
	}
	if (isEmpty(document.getElementById('message').value)) {
		onShow('本文を入力してください');
		return;
	}

	$data = 'title=' + document.getElementById('title').value
		+ '&message=' + document.getElementById('message').value
		+ '&category=' + document.getElementById('category').value
		+ '&articleid=' + document.getElementById('articleid').value;

	// 送信
	formapiCallback('req/article/post.php', $data, function($retcode) {
		if ($retcode == 'success') {
			swal({text: '投稿しました'
			}).then(function(isConfirm) {
				jumpapi('req/article/list.php');
			});
		}
	});
}
function onDelete() {
	swal({text: '削除してもよろしいですか？', icon: 'warning', buttons: true, dangerMode: true
	}).then(function(isConfirm) {
		if (isConfirm) {
			jumpapi('req/article/delete.php?articleid=' + <?php print $articleid; ?>);
		}
	});
}
</script>

<?php
$act->end();
?>

