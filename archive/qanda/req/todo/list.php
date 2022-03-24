<?php

include_once "../../todoact.php";

// ToDo一覧取得
$act = new ToDoAct();
$act->begin();
$retinfo = $act->todlist();

// 7日後（リマインドの日付の初期値に使用）
$remainddt = addDay(7);

?>

<div class="row m-2">
 <div class="col-sm-8"></div>
 <div class="col-sm-4"><?php print $act->member['NAME']; ?>さん</div>
</div>

<h5>ToDo新規</h5>
<form method="POST" class="form-horizontal" name="qandaAddForm" action="<?php print DOMAIN . '/req/todo/add.php'; ?>">
<div class="row m-2">
 <div class="col-sm-6">
  <input type="text" class="form-control" id="newtodotitle" name="newtodotitle" value="" maxlength="64" />
 </div>
 <div class="col-sm-3">
  <input type="text" class="form-control dateTimePickerForm" id="newtododt" name="newtododt" maxlength="16" value="<?php print $remainddt; ?>" />
 </div>
 <div class="col-sm-3">
  <div class="btn btn-primary" onClick="onAddToDo();">ToDoリスト</div>
 </div>
</div>
</form>

<h5>やること:</h5>
<table class="table table-striped">
<tr><th style="width: 5%">#</th><th style="width: 45%">Task</th><th style="width: 20%">Date</th><th style="width: 30%">Actions</th></tr>
<?php
$idx = 1;
foreach ($retinfo['activelist'] as $active) {

print<<<EOF
<tr><td>{$idx}</td><td>{$active['TITLE']}</td><td>{$active['REMIND_DATE']}</td><td>
 <span class="btn btn-link done" todoid="{$active['TODO_ID']}">Done</span>
 <span class="btn btn-link edit" todoid="{$active['TODO_ID']}" todotitle="{$active['TITLE']}" tododt="{$active['REMIND_DATE']}">Edit</span>
 <span class="btn btn-link delete" todoid="{$active['TODO_ID']}">Delete</span>
</td></tr>
EOF;
	$idx++;
}
if (count($retinfo['activelist']) == 0) {
	print('<tr><td colspan="4">1件もありません</td></tr>');
}
?>
</table>

<h5>終わったこと:</h5>
<table class="table table-striped">
<tr><th style="width: 5%">#</th><th style="width: 45%">Task</th><th style="width: 20%">Date</th><th style="width: 30%">Actions</th></tr>
<?php

$idx = 1;
foreach ($retinfo['finlist'] as $fin) {

print<<<EOF
<tr><td>{$idx}</td><td>{$fin['TITLE']}</td><td>{$fin['REMIND_DATE']}</td><td>
 <span class="btn btn-link return" todoid="{$fin['TODO_ID']}">Return</span>
 <span class="btn btn-link edit" todoid="{$fin['TODO_ID']}" todotitle="{$fin['TITLE']}" tododt="{$fin['REMIND_DATE']}">Edit</span>
 <span class="btn btn-link delete" todoid="{$fin['TODO_ID']}">Delete</span>
</td></tr>
EOF;
	$idx++;
}
if (count($retinfo['finlist']) == 0) {
	print('<tr><td colspan="4">1件もありません</td></tr>');
}
?>
</table>

<!-- 編集ダイアログ  -->
<div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
<form method="POST" class="form-horizontal" name="qandaEditForm" action="<?php print DOMAIN . '/req/todo/edit.php'; ?>">
 <div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="demoModalTitle">ToDo編集</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <div class="modal-body">
    <div class="row m-2">
     <div class="col-sm-8">
      <input type="text" class="form-control" id="edittodotitle" name="edittodotitle" value="" maxlength="64" />
     </div>
     <div class="col-sm-4">
       <input type="text" class="form-control dateTimePickerForm" id="edittododt" name="edittododt" maxlength="16" value="" />
     </div>
    </div>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
    <button type="button" class="btn btn-primary" id="updateToDo">更新</button>
    <input type="hidden" id="edittodoid" name="edittodoid" value="" />
   </div>
  </div>
 </div>
</form>
</div>
<!-- /編集ダイアログ  -->

<script type="text/javascript">
// ToDo追加ボタンを押した
function onAddToDo() {
	var $newtodotitle = document.getElementById('newtodotitle').value;
	if (isEmpty($newtodotitle)) {
		onShow('ToDoを入力してください');
		return;
	}
	// 送信
	document.qandaAddForm.submit();
}

// Editボタンを押した
function onEditToDo() {
	// 編集前の値
	var todoid = $(this).attr('todoid');
	var title = $(this).attr('todotitle');
	var tododt = $(this).attr('tododt');

	// エディットに設定
	$('#edittodotitle').val(title);
	$('#edittododt').val(tododt);
	$('#edittodoid').val(todoid);

	// 編集ダイアログ表示
	$('#demoNormalModal').modal('show');

	// 編集確定した
	$('#updateToDo').unbind().click(function() {
		// 送信
		document.qandaEditForm.submit();
	});
}

// 削除ボタンを押した
function onDeleteToDo() {
	var todoid = $(this).attr('todoid');
	swal({text: '削除してもよろしいですか？', icon: 'warning', buttons: true, dangerMode: true
	}).then(function(isConfirm) {
		if (isConfirm) {
			jumpapi('req/todo/delete.php?todoid=' + todoid);
		}
	});
}

// ステータス更新(done)
function onChangeStateFinish() {
	var todoid = $(this).attr('todoid');
	jumpapi('req/todo/changestate.php?state=finish&todoid=' + todoid);
}
// ステータス更新(return)
function onChangeStateActive() {
	var todoid = $(this).attr('todoid');
	jumpapi('req/todo/changestate.php?state=active&todoid=' + todoid);
}

// 初期化処理
$(function () {
	// 日付フィールドの初期化
	$('.dateTimePickerForm').datetimepicker({
		formatTime:'H:i',
		formatDate:'d.m.Y',
		language : 'ja'
	});

	// ボタン/リンク
	$('.btn.btn-link.done').click(onChangeStateFinish);
	$('.btn.btn-link.return').click(onChangeStateActive);
	$('.btn.btn-link.edit').click(onEditToDo);
	$('.btn.btn-link.delete').click(onDeleteToDo);
});
</script>

<?php
$act->end();
?>
