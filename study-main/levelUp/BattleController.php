<?php
// バトル用コントローラー
class BattleController extends Controller
{

use BattleControllerTrait;

// ・・・

/**
* 前ターンのポケモンの状態
* @var array
*/
protected $before = [
'friend' => null,
'enemy' => null,
];
}