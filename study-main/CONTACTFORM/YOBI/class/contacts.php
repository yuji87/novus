<?php 

namespace contactsApp;//PHP標準クラスには『\』をつける

class contacts
{
  private $pdo;//プロパティとして保持(他のメソッドで使う)

  public function __construct($pdo)
  {
    $this->pdo = $pdo; //プロパティに代入
    Token::create(); //トークンの作成、検証 → POSTで送信するときに使う
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

  // public function getAll(){
  //   //プロパティを使う
  //   $statement = $this->pdo->query("SELECT * FROM contacts ORDER BY contacts_id DESC");
  //   $contactss = $statement->fetchAll();
  //   return $contactss;
  // }
}
?>