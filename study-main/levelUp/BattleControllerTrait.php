<?php
 
/**
 * バトルコントローラー用トレイト
 */
trait BattleControllerTrait
{
 
    /**
    * ポケモン情報の引き継ぎ
    *
    * @param Pokemon::export:array $pokemon
    * @return void
    */
    protected function takeOverPokemon($pokemon)
    {
        $class = $pokemon['class_name'];
        $this->pokemon = new $class($pokemon);
        // ランク（バトルステータス）の引き継ぎ
        if(isset($_SESSION['__data']['rank'])){
            $this->pokemon
            ->setRank($_SESSION['__data']['rank']['pokemon']);
        }
        // 状態変化の引き継ぎ
        if(isset($_SESSION['__data']['sc'])){
            $this->pokemon
            ->setSc($_SESSION['__data']['sc']['pokemon']);
        }
        // 前ターンの状態をプロパティに格納
        $this->before['friend'] = clone $this->pokemon;
    }
 
    /**
    * 相手ポケモンの引き継ぎ
    *
    * @param Pokemon::export:array $enemy
    * @return void
    */
    protected function takeOverEnemy($enemy)
    {
        if(!empty($enemy)){
            $this->enemy = new $enemy['class_name']($enemy);
            // 前ターンの状態をプロパティに格納
            $this->before['enemy'] = clone $this->enemy;
        }
        // ランク（バトルステータス）の引き継ぎ
        if(isset($_SESSION['__data']['rank'])){
            $this->enemy
            ->setRank($_SESSION['__data']['rank']['enemy']);
        }
        // 状態変化の引き継ぎ
        if(isset($_SESSION['__data']['sc'])){
            $this->enemy
            ->setSc($_SESSION['__data']['sc']['enemy']);
        }
    }