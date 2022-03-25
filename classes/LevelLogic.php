<?php

//ファイル読み込み
require_once '../../core/DBconnect.php';
class LevelLogic
{
/**
* 全レベルを表示
* @param void
* @return bool $result
*/
public static function levelRanking()
{
$result = false;

$sql = 'SELECT user_id, name, level, icon FROM users ORDER BY level DESC';
try{
   $stmt = connect()->prepare($sql);
   // SQL実行
   $result = $stmt-> execute();
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $data;
} catch(\Exception $e) {
   // エラーの出力
   echo $e;
   // ログの出力
   error_log($e, 3, '../error.log');
   return $result;
}
}

/**
* 上位３位のレベルを表示
* @param void
* @return bool $result
*/
public static function levelTop3()
{
$result = false;

$sql = 'SELECT user_id, name, level, icon FROM users ORDER BY level DESC LIMIT 3';
try{
   $stmt = connect()->prepare($sql);
   // SQL実行
   $result = $stmt-> execute();
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $data;
} catch(\Exception $e) {
   // エラーの出力
   echo $e;
   // ログの出力
   error_log($e, 3, '../error.log');
   return $result;
}
}
}