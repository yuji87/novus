<?php
require_once('src/Exception.php');
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;

// 送信ボタンを押したとき
if (isset($_SESSION['token']) && (!$token || !$_SESSION['token'] || !$_SESSION['email'] && isset($_SESSION['email']))) {
  $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
  $_SESSION     = array();
  $mode         = 'input';
} else if (isset($_SESSION['token']) && ($token != $_SESSION['token'])) {
  $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
  $_SESSION     = array();
  $mode         = 'input';
} else {

  /** メールの送信テスト */
  if (isset($_SESSION['email'])){
    // メーラーインスタンス作成
    $mailer = new PHPMailer();

    /// 文字コード
    $mailer->CharSet = 'UTF-8';
    $mailer->Encoding = '7bit';

    /// SMTPサーバーを利用
    $mailer->IsSMTP();
    $mailer->SMTPAuth = true;
    /// SMTPサーバー
    $mailer->Host = 'smtp.gmail.com';
    /// 送信元のユーザー名
    $mailer->Username = 'qqandaa3@gmail.com';
    /// 送信元のパスワード
    $mailer->Password = 'hmronmgpclrpuhtb';
    /// ポート番号
    $mailer->Port = 587;

    /// 送信元メルアド
    $mailer->From = 'sssm6387@gmail.com';
    /// 送信者名
    $mailer->FromName = 'QandAsupport';

    /// 送信先アドレス
    $mailer->addAddress($_SESSION['email']);
    /// メール件名
    $mailer->Subject = 'お問い合わせありがとうございます';
    /// メール本文
    $mailer->Body =
    "お問い合わせを受け付けました。\r\n
    担当よりご連絡致しますので、今しばらくお待ちください。\r\n
    ※このメールはシステムからの自動返信です。\r\n
    -----------------------------------------------\r\n
    ▼お問い合わせ内容▼\r\n
    お名前: " . $_SESSION['name'] . "\r\n
    メールアドレス: " . $_SESSION['email'] . "\r\n
    お問い合わせ内容:\r\n
    ".preg_replace('/\r\n|\r|\n/', '\r\n', $_SESSION['message']);

    /// メール送信
    $result = $mailer->send();

    if($result) {
      echo 
      "<h2 class='text-center mt-5'>
        送信しました。<br>
        <a href='contactForm.php'>
          トップへ戻る
        </a><br>
        お問い合わせありがとうございました。<br>
        ※設定頂いたメールアドレスに自動応答メッセージが届いているかご確認ください。<br>
        届いていない場合は、サポートチームからのメールが受信できない可能性があります。<br>
      </h2>";
    } else {
      echo
      "<h2 class='text-center mt-5'>
        送信に失敗しました。<br>
        <a href='contactForm.php'>
          トップへ戻る
        </a><br>
      </h2>";
      /// エラー内容全出力
      // var_export($mailer->ErrorInfo);
    }
  } else {
    echo 
    "<h2 class='text-center mt-5'>
      送信に失敗しました。<br>
      <a href='contactForm.php'>
        トップへ戻る
      </a><br>
    </h2>";
  }

  $_SESSION = array();
  $mode     = 'send';
}





