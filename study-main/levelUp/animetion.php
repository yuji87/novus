<?php
/**
* レベルアップ処理
*
* @param string|null $msg_id
* @return void
*/
protected function actionLevelUp($msg_id=null)
{
// メッセージIDの指定があれば、経験値バーのアニメーション用レスポンスをセット
if(!is_null($msg_id)){
$this->setResponse([
'param' => 100, # %
'action' => 'expbar',
], $msg_id);
}
// 現在のHPを取得
$before_hp = $this->getStats('HP');
// レベルアップ
$this->level++;
// HPの上昇値分だけ残りHPを加算(ひんし状態を除く)
if(!isset($this->sa['SaFainting'])){
$this->calRemainingHp('add', $this->getStats('HP') - $before_hp);
}
// メッセージIDを生成
$msg_id1 = $this->issueMsgId();
$msg_id2 = $this->issueMsgId();
// レベルアップアニメーション用レスポンス
$this->setResponse([
'param' => json_encode([
'level' => $this->level,
'remaining_hp' => $this->getRemainingHp(),
'remaining_hp_per' => $this->getRemainingHp('per'),
'max_hp' => $this->getStats('HP'),
]),
'action' => 'levelup',
], $msg_id1);
$this->setAutoMessage($msg_id1);
// レベルアップメッセージ
$this->setMessage($this->getNickName().'のレベルは'.$this->level.'になった！', $msg_id2);
// 現在のレベルで習得できる技があるか確認
$this->checkMove();
}