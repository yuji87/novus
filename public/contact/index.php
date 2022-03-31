<?php 
require_once "../../app/ContactAct.php";
require_once '../../app/Token.php';
require_once '../../app/Utils.php';
require_once 'process/functions.php';

use Qanda\ContactAct;
use Qanda\Token;
use Qanda\Utils;

$act = new ContactAct(0);
Token::create();


//セッションを開始
// session_start();
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id(TRUE);
//エスケープ処理やデータチェックを行う関数のファイルの読み込み

//NULL 合体演算子を使ってセッション変数を初期化
$name = $_SESSION['name'] ?? NULL;
$email = $_SESSION['email'] ?? NULL;
$email_check = $_SESSION['email_check'] ?? NULL;
$tel = $_SESSION['tel'] ??  NULL;
$title = $_SESSION['title'] ?? NULL;
$contents = $_SESSION['contents'] ?? NULL;
$error = $_SESSION['error'] ?? NULL;

//個々のエラーを NULL で初期化
$error_name = $error['name'] ?? NULL;
$error_email = $error['email'] ?? NULL;
$error_email_check = $error['email_check'] ?? NULL;
$error_tel = $error['tel'] ?? NULL;
$error_subject = $error['title'] ?? NULL;
$error_body = $error['contents'] ?? NULL;

//CSRF対策の固定トークンを生成
if (!isset($_SESSION['ticket'])) {
  //セッション変数にトークンを代入
  $_SESSION['ticket'] = bin2hex(random_bytes(32));
}
//トークンを変数に代入
$ticket = $_SESSION['ticket'];

$result = Utils::checkLogin();
if (!$result) {
    header("Location:" .DOMAIN."/top/userLogin/login_top.php");
    return;
}
?>

<body>
  <div class="container">
    <h1 class="mt-5 text-center fw-bold fs-2">お問い合わせフォーム</h1>
    <form id="form" class="validationForm mt-4" method="post" action="confirm.php" novalidate>
      <div class="offset-3">
        <div class="form-group">
          <label for="name">*お名前
            <span class="error-php"><?php echo Utils::h($error_name) ?></span>
          </label>
          <input type="text" class="required maxlength form-control" data-maxlength="30" id="name" name="name" placeholder="name" data-error-required="何も入力されていません" value="<?php echo (isset($_SESSION['login_user']) ? h($act->getMemberName()) : h($name)); ?>">
        </div>
        <div class="form-group">
          <label for="email">*Email
            <span class="error-php"><?php echo Utils::h($error_email) ?></span>
          </label>
          <input type="email" class="required pattern form-control" data-pattern="email" id="email" name="email" placeholder="email" data-error-required="何も入力されていません" data-error-pattern="形式が正しくありません" value="<?php echo (isset($_SESSION['login_user']) ? h($act->getMemberEmail()) : h($email)); ?>">
        </div>
        <div class="form-group">
          <label for="email_check">*Email（確認用）
            <span class="error-php"><?php echo Utils::h($error_email_check) ?></span>
          </label>
          <input type="email" class="form-control equal-to required" data-equal-to="email" data-error-equal-to="メールアドレスが異なります" data-error-required="入力は必須です" id="email_check" name="email_check" placeholder="check email" value="<?php echo h($email_check) ?>">
        </div>
        <div class="form-group">
          <label for="title">*タイトル
            <span class="error-php"><?php echo Utils::h($error_subject) ?></span>
          </label>
          <input type="text" class="required maxlength form-control" data-maxlength="100" id="subject" name="title" placeholder="title" data-error-required="入力は必須です" value="<?php echo h($title) ?>">
        </div>
        <div class="form-group">
          <label for="contents">*お問い合わせ内容
            <span class="error-php"><?php echo Utils::h($error_body) ?></span>
          </label>
          <textarea class="required maxlength showCount form-control" data-maxlength="1000" id="contents" name="contents" placeholder="contents" rows="3"><?php echo h($contents) ?></textarea>
        </div>
      </div>
      <div class="text-center">
        <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
        <input type="hidden" name="ticket" value="<?php echo h($ticket) ?>">
        <button name="submitted" type="submit" class="btn btn-primary text-center">送信</button>
      </div>
    </form>

  <!-- 検証用 JavaScript の読み込み-->
  <script src="formValidation.js"></script>

<?php
$act->end(0);
?>