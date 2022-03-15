<?php
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