<?php
require_once('TwitterAppOAuth.php');

// Consumer Key (API Key) を設定
$consumer_key = 'qbvWpbgoHKWbYMYDRWgSm2vVh';

// Consumer Secret (API Secret) を設定
$consumer_secret = 'Ot3bCjmXkHduSrfT0QeTPzd199DR4vUEI5m9OxJNV6n15jACcT';

// アプリケーション認証実行
$connection = new TwitterAppOAuth($consumer_key, $consumer_secret);

// ツイート検索パラメータの設定、「q」は検索文字列
$params = array(
    'q' => '焼肉定食'
);

// ツイート検索実行
$tweets_obj = $connection->get('search/tweets', $params);

// オブジェクトを配列に変換
$tweets_arr = json_decode($tweets_obj, true);

// ツイートの表示
for ($i = 0; $i < count($tweets_arr['statuses']); $i++) {
  echo $tweets_arr['statuses'][$i]['text'] . "\n----------\n";
}
