<?php 

namespace TodoApp;//PHP標準クラスには『\』をつける

class Todo 
{
  private $pdo;//プロパティとして保持(他のメソッドで使う)

  public function __construct($pdo)
  {
    $this->pdo = $pdo; //プロパティに代入
    // Token::create(); //トークンの作成、検証 → POSTで送信するときに使う
  }

  // POSTで送信されたデータを処理するメソッド
  public function processPost(){

    //POSTで送信されたデータの処理
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      Token::validate();

      $action = filter_input(INPUT_GET, "action");
      $id = filter_input(INPUT_GET, "id");
      $task = filter_input(INPUT_POST, "task");
      $id = filter_input(INPUT_POST, "task_id");

      if( isset($_POST['updateLast']) ){
        $this->update_todo( $id, $task );
      }

      switch(isset($action) && $action){
        case 'delete':
        $this->delete_todo( $id );
        break;

        case 'Return':
        $this->return_todo( $id );
        break;
        
        case 'Done':
        $this->done_todo( $id );
        break;
        
        default;
        exit;
      }
      header("Location: index.php");
      exit;
    }
  }
  /**
  * 追加
  */
  public function add($task) 
  {
    $date = time();
    $statement = $this->pdo->prepare("INSERT INTO todo( todo, date, done) VALUES ( '$task', '$date', '0')");
    $statement->fetchAll (PDO::FETCH_ASSOC);
    $statement->execute();
  }

  /**
  * 削除
  * @param int $id
  */
  public function delete_todo($id)
  {
    $statement = $this->pdo->prepare("DELETE FROM todo WHERE id = :id");
    $statement->bindValue($id, \PDO::PARAM_INT);
    $statement->execute();
  }

  /**
  * 変更
  * @param int $id
  * @param string $task
  */
  public function update_todo($id, $task)
  {
    $task = $_POST['task'];
    $data = [ 'todo' => $task ];
    $where = [ 'id' => $id ];
    $this->update_sql_query($data, $where);
  }

  /**
  * 完了
  * @param int $id
  */
  public function done_todo($id)
  {
    $now = time();
    $data = [ 'done' => 1, 'date' => $now ];
    $where = [ 'id' => $id ];
    $this->update_sql_query($data, $where);
  }

  /**
  * 戻す
  * @param int $id
  */
  public function return_todo($id)
  {
    $now = time();
    $data = [ 'done' => 0, 'date' => $now ];
    $where = [ 'id' => $id ];
    $this->update_sql_query($data, $where);
  }

  /**
  * Sql query and run for todo update
  * @param array $data
  * @param array $where
  * @param string $table
  */
  public function update_sql_query($data, $where, $table='todo') 
  {
    $cols = [];
    foreach($data as $key=>$val) {
        $cols[] = $table.".$key = '$val'";
    }

    $wheres = [];
    foreach($where as $key=>$val) {
      $wheres[] = $table.".$key = '$val'";
    }

    $query = "UPDATE $table SET " . implode(', ', $cols) . " WHERE " . implode(', ', $wheres);
    $this->run_query($query);
  }

  /**
  * Run sql query and header to home
  * @param string $query
  */
  private function run_query($query) 
  {
    mysqli_query($this->db, $query);
    $this->redirect($_SERVER['REQUEST_URI']);
  }

  /**
  * Select todo
  * @param string $done
  */
  private function select_todo($done=0)
  {
    $query = "SELECT * FROM todo WHERE todo.done='$done' ORDER BY `date` ASC";
    $run_select = $this->run_query_return($query);

    if(!$run_select) {
      echo '<h1>Please follow intro.php file instructions ...</h1>';
      exit;
    }

    return $run_select;
  }

  /**
  * Show todo
  * @param string $done
  */
  public function show_todo($done=0) 
  {
    $todos = $this->select_todo($done);
    
    echo '<table class="table table-striped">';
      echo '<thead>';
        echo '<tr>';
          echo '<th scope="col">#</th>';
          echo '<th scope="col">task</th>';
          echo '<th scope="col">Date</th>';
          echo '<th scope="col">Actions</th>';
        echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
          $num = 1;
          while( $row = mysqli_fetch_array($todos) ):
            echo '<tr>';
              echo '<th scope="row">'.$num.'</th>';
              echo '<td>'.$row["todo"].'</td>';
              echo '<td>'.date('m/d/Y', $row["date"]).'</td>';
              echo '<td>';
                $name = ($done==0) ? 'Done': 'Return';
                echo '<a href="?id='.$row["id"].'&action='.$name.'">'.$name.'</a>';
                echo ' &nbsp;<a href="?id='.$row["id"].'&action=edit&todo='.$row["todo"].'" class="text-success">Edit</a>';
                echo ' <a class="text-danger mx-2 d-inline-block" href="?id='.$row["id"].'&action=delete">Delete</a>';
              echo '</td>';
            echo '</tr>';
            $num++;
          endwhile;
        echo '</tbody>';
      echo '</table>';
  }
  
  /**
  * Run sql query and return result
  * @param string $query
  */
  private function run_query_return($query) 
  {
    return mysqli_query($this->db, $query);
  }

  /**
  * Root url
  * @param string $query
  */
  private function root_url() 
  {
    $protocol = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
    $url = $_SERVER['REQUEST_URI'];
    $parts = explode('/',$url);
    $dir = $_SERVER['SERVER_NAME'];
    for ($i = 0; $i < count($parts) - 1; $i++) {
      $dir .= $parts[$i] . "/";
    }
    return $protocol.$dir;
  }

  /**
	 * Redirect to home.
	 * @param string $url optional
	 */
	public function redirect() 
  {
		header('Location: '.$this->root_url());
    exit;
	}
}

