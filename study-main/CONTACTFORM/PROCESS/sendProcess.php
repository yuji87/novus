<?php

  // 送信ボタンを押したとき
  if ( !$token || !$_SESSION['token'] || !$_SESSION['email'] && isset($_SESSION['email'])) {
    $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
    $_SESSION     = array();
    $mode         = 'input';
  } else if ($token != $_SESSION['token']) {
    $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
    $_SESSION     = array();
    $mode         = 'input';
  } else {

    $sender = "QandAsupport";
    $message =
      "お問い合わせを受け付けました。\r\n"
      . "担当よりご連絡致しますので今しばらくお待ちくださいませ。\r\n"
      . "※このメールはシステムからの自動返信です。\r\n"
      . "\r\n"
      . "▼お問い合わせ内容▼\r\n"
      . "-----------------------------------------------\r\n"
      . "名前: " . $_SESSION['name'] . "\r\n"
      . "email: " . $_SESSION['email'] . "\r\n"
      . "お問い合わせ内容:\r\n"
      . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);

      if (mb_send_mail('ixciron@yahoo.co.jp', 'TEST SUBJECT', 'TEST BODY')) {
        echo '送信完了';
        } else {
        echo '送信失敗';
        }
    // $addHeader = "From:" . mb_encode_mimeheader($sender)  . "Yuji.Matsunaga@kusurinomadoguchi.co.jp\r\n";
    // mail($_SESSION['email'], '【QandA】お問い合わせありがとうございます', $message);
    // mail('Yuji.Matsunaga@kusurinomadoguchi.co.jp', '【QandA】お問い合わせありがとうございます', $message);
    $_SESSION = array();
    $mode     = 'send';
  }



?>