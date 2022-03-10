<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
      
      //データベースと接続するファイルを読み込みます。
      require_once "db.php";
        
      //秘密鍵を設定するファイルを読み込みます。
      require_once 'secret.php';
        
      //アップロードしたpay.jpのライブラリから必要なファイル(init.php)を読み込みます。
      require_once 'payjp-php-master/init.php';
        
      //JavaScriptからポストされたトークンを受け取ります。
      $card_token = htmlspecialchars($_POST['card_token'], ENT_QUOTES);
        
      //管理画面で決めた、今回課金するプランのidを指定します。
      $plan_data = "s0001";
        
      //ユーザーのメールアドレスを取得します。
      //今回はユーザーのメールアドレスをセッションで保持、セッションから取得。
      $mail = $_SESSION['mail'];
        
      try {
            
          //pay.jpの管理画面に顧客データを作成します。
          Payjp\Payjp::setApiKey($secret);
          $result = Payjp\Customer::create(
              array(
                  "email" => $mail,
                  "card" => $card_token,
              )
          );
            
          //作成された顧客idを取得します。
          $resultid = $result['id'];
                
          //ユーザーをプランに加入する処理を実行。
          Payjp\Payjp::setApiKey($secret);
          $resultsub = Payjp\Subscription::create(
              array(
                  "customer" => $resultid,
                  "plan" => $plan_data
              )
          );
            
          //プランとユーザーを紐付けるidを取得
          $resultsubid = $resultsub['id'];
            
          //データベースにあるユーザーデータに、決済関連のidをまとめて保存
          $userplandata = mysqli_select_db($mysqli,'userdata');
          //今回はplanrank=プラン(s0001) planid=プラン決済id payid=顧客id registrationtime=決済時間を登録しています。
          //データベースにも予めカラムを作っておいてください。
          $userplandata = mysqli_query($mysqli,"UPDATE userdata SET planrank='$plan_data',planid='$resultsubid',payid='$resultid',registrationtime='$today' where mail = '$mail'");
            
      } catch (Exception $e) {
            
          //もしエラーがあった場合はエラーメッセージを返します。
          $miss = $getmessage = $e->getMessage();
        
      };
        
      //最後にjsonでエラーがあった場合のエラーメッセージを返します。
      header('Content-type: application/json');
      echo json_encode( $miss );
  ?>
</body>
</html>