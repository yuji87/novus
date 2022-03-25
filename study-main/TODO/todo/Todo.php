<?php 

namespace TodoApp;//PHP標準クラスには『\』をつける

class Todo
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
        case "add":
        $this->add();
        break;
        
        case "toggle":
        $this->toggle();
        break;
        
        case "delete":
        $this->delete();
        break;
        
        case "purge":
        $this->purge();
        break;
        
        default;
        exit;
      }
      // header("Location:" . SITE_URL);
      header("Location: index.php");
      exit;
    }
  }

  private function add(){
    $title = trim(filter_input(INPUT_POST, "title"));
    if($title === ""){
      return;
    }
    $statement = $this->pdo->prepare("INSERT INTO todo(title) VALUES(:title)");
    $statement->bindValue("title", $title, \PDO::PARAM_STR);
    $statement->execute();
  }

  private function toggle(){
    $id = trim(filter_input(INPUT_POST, "id"));
    if(empty($id)){
      return;
    }
    $statement = $this->pdo->prepare("UPDATE todo SET is_done = NOT is_done WHERE id=:id");
    $statement->bindValue("id", $id, \PDO::PARAM_INT);
    $statement->execute();
  }

  private function delete(){
    $id = trim(filter_input(INPUT_POST, "id"));
    if(empty($id)){
      return;
    }
    $statement = $this->pdo->prepare("DELETE FROM todo WHERE todo_id=:id");
    $statement->bindValue("id", $id, \PDO::PARAM_INT);
    $statement->execute();
  }

  private function purge(){
    $this->pdo->query("DELETE FROM todo WHERE is_done = 1"); //is_doneがtrueのものを削除
  }

  public function getAll(){
    //プロパティを使う
    $statement = $this->pdo->query("SELECT * FROM todo ORDER BY todo_id DESC");
    $todos = $statement->fetchAll();
    return $todos;
  }
}
?>