<!-- クラス定義用(プロパティ定義) -->
<?php
// クラスを定義
class contacts
{
  private $title; // title プロパティを定義
  private $message; // messageプロパティを定義
  private $contact_date; // contact_dateプロパティを定義

  public function __construct($title, $message, $contact_date){
    $this->title = $title;
    $this->message = $message;
    $this->contact_date = $contact_date;
  }
  
  public function gettitle(){
    return $this->title;
  }

  public function getmessage(){
    return $this->message;
  }

  public function getcontact_date(){
    return $this->contact_date;
  }

  // POSTで送信されたデータを処理するメソッド
  public function processPost(){
    //POSTで送信されたデータの処理
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      Token::validate();
      $action = filter_input(INPUT_GET, "action");
    
      //メソッド作成
      switch($action){
        case "confirm":
        $this->confirm();
        break;
      
        default;
        exit;
      }
      // header("Location:" . SITE_URL);
      header("Location: index.php");
      exit;
    }
  }

  private function confirm(){
    $title = trim(filter_input(INPUT_POST, "title"));
    if($title === ""){
      return;
    }
    $statement = $this->pdo->prepare("INSERT INTO contacts(title, message, contact_date) VALUES(:title, :message, :contact_date)");
    $statement->bindValue("title", $title, \PDO::PARAM_STR);
    $statement->execute();
  }

}

?>