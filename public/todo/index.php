<?php
require_once "../../app/TodoAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';

use Novus\TodoAct;
use Novus\Token;
use Novus\Utils;

// ToDo一覧取得
$act = new ToDoAct();
$retInfo = $act->begin();
$retInfo = $act->get();

//ログインチェック
$act->checkLogin();

// Token生成
Token::create();

// 7日後（リマインドの日付の初期値に使用）
$remainddt = Utils::addDay(7, 1);

// エラーコード
$errid = filter_input(INPUT_GET, 'errid');

$icon = $act->getMemberIcon();
?>

<div class="row m-2">
  <div class="col-sm-8"></div>
  <?php if (isset($_SESSION['login_user'])): ?>
    <a href="<?php echo DOMAIN ?>/public/mypage/index.php" class="d-flex align-items-center col-sm-4 text-dark">
      <?php echo (isset($icon) ? '<img src="' . DOMAIN . '/public/top/img/' . $icon . '" class="mr-1">' : '<img src="' . DOMAIN . '/public/top/img/sample_icon.png" class="mr-1">') ?>
      <?php echo $act->getMemberName(); ?> さん
    </a>
  <?php endif; ?>
</div>

<h5>Todo</h5>
<form method="POST" class="form-horizontal" name="addForm" action="<?php echo DOMAIN . '/public/todo/process/add.php'; ?>">
  <div class="row m-2">
    <div class="col-sm-6">
      <input type="text" class="form-control" id="newTodoTitle" name="newTodoTitle" value="" maxlength="64">
    </div>
    <div class="col-sm-3">
      <input type="text" class="form-control dateTimePickerForm" id="newTodoDt" name="newTodoDt" maxlength="16" value="<?php echo $remainddt; ?>">
    </div>
    <div class="col-sm-3">
      <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
      <div class="btn btn-primary" onClick="onAddToDo();">追加</div>
    </div>
  </div>
</form>

<h5>やること:</h5>
<table class="table table-striped" style="overflow: hidden; overflow-wrap: break-word;">
  <tr>
    <th style="width: 5%">#</th>
    <th style="width: 45%">Task</th>
    <th style="width: 20%">DeadLine</th>
    <th style="width: 30%">Actions</th>
  </tr>
  <?php
  $idx = 1;
  foreach ($retInfo['activeList'] as $active) {
    $escapetitle = Utils::h($active['title']);
    echo '<tr><td>' . $idx . '</td><td style="word-break: break-all;">' . $escapetitle . '</td><td>' . Utils::dayFormat($active['remind_date']) . '</td><td>';
    echo '<span class="btn btn-link done" todoid="' . $active['todo_id'] . '">Done</span>';
    echo '<span class="btn btn-link edit" todoid="' . $active['todo_id'] . '" todoTitle="' . $escapetitle
      . '" tododt="' . Utils::dayFormat($active['remind_date']) . '">Edit</span>';
    echo '<span class="btn btn-link delete" todoid="' . $active['todo_id'] . '">Delete</span>';
    echo '</td></tr>';
    $idx++;
  }
  if (count($retInfo['activeList']) == 0) {
    echo '<tr><td colspan="4" class="text-center">1件もありません</td></tr>';
  }
  ?>
</table>

<h5>終わったこと:</h5>
<table class="table table-striped">
  <tr>
    <th style="width: 5%">#</th>
    <th style="width: 45%">Task</th>
    <th style="width: 20%">DeadLine</th>
    <th style="width: 30%">Actions</th>
  </tr>
  <?php

  $idx = 1;
  foreach ($retInfo['finList'] as $fin) {
    $escapetitle = Utils::h($fin['title']);
    echo '<tr><td>' . $idx . '</td><td>' . $escapetitle
      . '</td><td>' . Utils::dayFormat($fin['remind_date']) . '</td><td>';
    echo '<span class="btn btn-link return" todoid="' . $fin['todo_id'] . '">Return</span>';
    echo '<span class="btn btn-link edit" todoid="' . $fin['todo_id'] . '" todoTitle="' . $escapetitle
      . '" tododt="' . Utils::dayFormat($fin['remind_date']) . '">Edit</span>';
    echo '<span class="btn btn-link delete" todoid="' . $fin['todo_id'] . '">Delete</span>';
    echo '</td></tr>';
    $idx++;
  }
  if (count($retInfo['finList']) == 0) {
    echo '<tr><td colspan="4" class="text-center">1件もありません</td></tr>';
  }
  ?>
</table>


<!-- 編集ダイアログ  -->
<div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <form method="POST" class="form-horizontal" name="NovusEditForm" action="<?php echo DOMAIN . '/public/todo/process/edit.php'; ?>">
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
              <input type="text" class="form-control" id="edittodotitle" name="edittodotitle" value="" maxlength="64">
            </div>
            <div class="col-sm-4">
              <input type="text" class="form-control dateTimePickerForm" id="edittododt" name="edittododt" maxlength="16" value="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-primary" id="updateToDo">更新</button>
          <input type="hidden" id="edittodoid" name="edittodoid" value="">
          <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
        </div>
      </div>
    </div>
  </form>
</div>
<!-- /編集ダイアログ  -->

<script type="text/javascript">
  // ToDo追加ボタンを押した
  function onAddToDo() {
    var $newTodoTitle = document.getElementById('newTodoTitle').value;
    if (isEmpty($newTodoTitle)) {
      onShow('何も入力されていません');
      return;
    }
    // 送信
    document.addForm.submit();
  }

  // Editボタンを押したとき
  function onEdit() {
    // 編集前の値を取得
    var todoid = $(this).attr('todoid');
    var title = $(this).attr('todoTitle');
    var tododt = $(this).attr('tododt');

    // エディットに設定
    $('#edittodotitle').val(title);
    $('#edittododt').val(tododt);
    $('#edittodoid').val(todoid);

    // 編集モーダル表示(ブートストラップ)
    $('#demoNormalModal').modal('show');

    // 編集が確定したとき
    $('#updateToDo').off().click(function() {
      var $edittodotitle = document.getElementById('edittodotitle').value;
      if (isEmpty($edittodotitle)) {
        onShow('何も入力されていません');
        return;
      }

      // 送信
      document.NovusEditForm.submit();
    });
  }

  // 削除ボタンを押した
  function onDelete() {
    var todoid = $(this).attr('todoid');
    swal({
      text: '削除してもよろしいですか？',
      icon: 'warning',
      buttons: true,
      dangerMode: true
    }).then(function(isConfirm) {
      if (isConfirm) {
        var $data = 'todoid=' + todoid + '&token=<?php echo $_SESSION["token"]; ?>';
        // ajax呼び出し
        formapiCallback('todo/process/delete.php', $data, function(result) {
          // 一覧を再読み込み
          jumpapi('todo/index.php');
        });
      }
    });
  }

  // ステータス更新(done)
  function toggleFinish() {
    var todoid = $(this).attr('todoid');
    var $data = 'state=finish&todoid=' + todoid + '&token=<?php echo $_SESSION["token"]; ?>';
    // ajax呼び出し
    formapiCallback('todo/process/toggle.php', $data, function(result) {
      // 一覧を再読み込み
      jumpapi('todo/index.php');
    });
  }
  // ステータス更新(return)
  function toggleActive() {
    var todoid = $(this).attr('todoid');
    var $data = 'state=active&todoid=' + todoid + '&token=<?php echo $_SESSION["token"]; ?>';
    // ajax呼び出し
    formapiCallback('todo/process/toggle.php', $data, function(result) {
      // 一覧を再読み込み
      jumpapi('todo/index.php');
    });
  }

  // 初期化処理
  $(function() {
    // 日付フィールドの初期化
    $('.dateTimePickerForm').datetimepicker({
      formatTime: 'H:i',
      formatDate: 'd.m.Y',
      language: 'ja'
    });

    // ボタン/リンク
    $('.btn.btn-link.done').click(toggleFinish);
    $('.btn.btn-link.return').click(toggleActive);
    $('.btn.btn-link.edit').click(onEdit);
    $('.btn.btn-link.delete').click(onDelete);

    <?php
    if ($errid) {
      // 更新に失敗したとき、リダイレクトして todo/index.phpに引数指定で呼び出されるので
      // ダイアログ表示
      if ($errid == 'invalidtitle') {
        echo 'swal("100文字以内で入力してください");';
      } else if ($errid == 'invalidformatdt') {
        echo 'swal("リマインドの日付に誤りがあります");';
      }
    }
    ?>

  });
</script>

<?php
$act->printFooter();
?>