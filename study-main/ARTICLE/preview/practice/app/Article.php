<?php

namespace ArticleApp;

class Article
{
  private $pdo;//プロパティとして保持(他のメソッドで使う)

  public function __construct($pdo)
  {
    $this->pdo = $pdo; //プロパティに代入
    Token::create(); //トークンの作成、検証 → POSTで送信するときに使う
  }

  /**
   * 記事を登録する
   * @param array $Data
   * @return bool $result
   */
  public static function add($Data)
  {
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      Token::validate();
      
      $err = [];
      $result = false;
      $user_id = filter_input(INPUT_POST, 'user_id');
      $title = filter_input(INPUT_POST, 'title');
      $category = filter_input(INPUT_POST, 'category');
      $contents = filter_input(INPUT_POST, 'contents');
      // $image = filter_input(INPUT_POST, 'image');
      
      $array = array(' ', '　', "\r\n", "\r", "\n", "\t");
      $space = str_replace($array, '', $contents);
      
      if (trim($title) === "") {
        $err["title"] = "blank";
      } elseif (mb_strlen($title) > 500) {
        $err["title"] = "exceed";
      }
      if($category === "0"){
        $err["category"] = "blank";
      }
      if (trim($contents) === "" || $space === "") {
        $err["contents"] = "blank";
      } elseif (mb_strlen($contents) > 5000) {
        $err["contents"] = "exceed";
      }
      if (count($err) === 0) {
        $arr = [];
        $arr[] = $Data[$user_id];
        $arr[] = $Data[$title];
        $arr[] = $Data[$category];
        $arr[] = $Data[$contents];
        // $arr[] = $Data['image'];
        try{
          $sql = "INSERT INTO question_posts (user_id, title, category, contents) VALUES (?, ?, ?, ?)";
          $stmt = connect()->prepare($sql);
          $stmt->bindValue("user_id" , $user_id , \PDO::PARAM_INT);
          $stmt->bindValue("title"   , $title   , \PDO::PARAM_STR);
          $stmt->bindValue("category", $category, \PDO::PARAM_STR);
          $stmt->bindValue("contents", $contents, \PDO::PARAM_STR);
          $stmt->execute($arr);
          $stmt->fetch();
          // return $result;
        }catch(\Exception $e){
          // エラーの出力
          echo $e;
          // ログの出力
          error_log($e, 3, '../error.log');
          return $result;
        }
      }
    }
  }
}