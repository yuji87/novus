<?php

session_start();

//ファイルの読み込み
require_once '../classes/QuestionLogic.php';

 //最新の質問を取得する処理
 $hasCreated = QuestionLogic::newQuestion();

 foreach($hasCreated as $value){
   echo $value['question_id'];
   echo $value['title'];
   echo "<br>";
 }