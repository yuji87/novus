<?php
//名前空間
namespace contactsApp;
aaaa
class Utils
{
//クラスから直接呼び出せるようにしておく
public static function h($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

}