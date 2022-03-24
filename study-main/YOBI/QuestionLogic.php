<?php

//ファイル読み込み
require_once 'core/DBconnect.php';

class QuestionLogic
{
    /**
     * ユーザーを登録する
     * @param array $questionData
     * @return bool $result
     */
    public static function createQuestion($questionData)
    {
      $result = false;

      $sql = 'INSERT INTO users (name, tel, email, password) VALUES (?, ?, ?, ?)';
      // ユーザーデータを配列に入れる
      $arr = [];
      $arr[] = $userData['name'];                                      // name
      $arr[] = $userData['tel'];                                       // tel
      $arr[] = $userData['email'];                                     // email
      $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT); // password