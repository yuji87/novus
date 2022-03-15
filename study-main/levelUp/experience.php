<?php
/**
* 経験値をセット（取得）する
* @param integer $exp
* @return object
*/
public function setExp($exp)
{
if(!is_numeric($exp)){
// 入力値のチェック
$this->setMessage('数値を入力してください', 'error');
return $this;
}
// 次のレベルに必要な経験値を取得
$next_exp = $this->getReqLevelUpExp();
// 経験値を加算
$this->exp += (int)$exp;
// メッセージIDを生成
$msg_id = $this->issueMsgId();
$this->setMessage($this->getNickname().'は経験値を'.$exp.'手に入れた！', $msg_id);
// レベル上限の確認
if($this->level >= 100){
return $this;
}
if($next_exp <= $exp){ $levelup=true; /** * 次のレベルに必要な経験値を超えている場合 */ // レベルアップ処理 $this->actionLevelUp($msg_id);
  // レベルアップ処理ループ
  while($this->getReqLevelUpExp() < 0){ // メッセージIDを再生成 $msg_id=$this->issueMsgId();
    $this->setAutoMessage($msg_id);
    // レベルアップ処理
    $this->actionLevelUp($msg_id);
    }
    // 全レベルアップ処理終了後、メッセージIDを再生成
    $msg_id = $this->issueMsgId();
    $this->setEmptyMessage($msg_id);
    }
    // 経験値バーの最終アニメーション用レスポンス
    $this->setResponse([
    'param' => $this->getPerCompNexExp(),
    'action' => 'expbar',
    ], $msg_id);

    // 進化判定
    if(isset($levelup) && isset($this->evolve_level) && ($this->evolve_level <= $this->level)){
      return $this->evolve();
      }else{
      return $this;
      }
      }