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


get_template_part('lib/payjp-php/init');
\Payjp\Payjp::setApiKey( 'sk_test_cd4fcf82fe5af78bb0b0c7f1');

$customer_id;//pay.jpにおける顧客ID

try {
  if ( empty($customer_id) ) {//初回
    $customer = \Payjp\Customer::create([//顧客登録
      'card' => $form['payjp-token'],
      'description' => 'メモなど'
    ]);
  }

  $charge = \Payjp\Charge::create([//課金処理
    'customer' => $customer_id,
    'amount'=> $form['amount'],
    'description' => '注文IDなど',
    'currency' => 'jpy'
  ]);

  if ( isset($charge['error']) ) {
    $this->errors[] = $charge['error']['message'];
  )

} catch (\Payjp\Error\Card $e) {
  $body = $e->getJsonBody();
  $this->errors[] = "ステータス: {$e->getHttpStatus()}";
  $this->errors[] = "タイプ: {$err['type']}";
  $this->errors[] = "コード: {$err['code']}";
  $this->errors[] = $err['message'];

} catch (\Payjp\Error\InvalidRequest $e) {
  $this->errors[] = $e->getMessage();

} catch (\Payjp\Error\Authentication $e) {
  $this->errors[] = $e->getMessage();

} catch (\Payjp\Error\ApiConnection $e) {
  $this->errors[] = $e->getMessage();

} catch (\Payjp\Error\Base $e) {
  $this->errors[] = $e->getMessage();

} catch (Exception $e) {
  $this->errors[] = $e->getMessage();

} finally {
  if ( !empty($this->errors) ) {
  )
}

//DBでいろいろやる

?>



</body>
</html>