<?php
class Todo {
    private $title;
    private $content;
    private $flg;

    public function __construct ($row) {
        $this->title = $row["title"];
        $this->content = $row["content"];
        $this->flg = 1;
    }

    //現在の自分のtodoリストを取得(flg == 1)
    static public function get_todo () {
        global $pdo;
        $query = $pdo->query ("select * from todolist where flg = 1");
        $lists = $query->fetchAll (PDO::FETCH_ASSOC);
        return $lists;
    }

    //終了した自分のtodoリストを取得(flg == 0)
    static public function end_todo () {
        global $pdo;
        $query = $pdo->query ("select * from todolist where flg = 0");
        $lists = $query->fetchAll (PDO::FETCH_ASSOC);
        return $lists;
    }

    //リストを追加
    static public function insert ($list) {
        global $pdo;
        $prepare = $pdo->prepare ("insert into todolist value ('', :content, :flg)");
        $prepare->bindValue (":content", $list->content);
        $prepare->bindValue (":flg", $list->flg);
        $prepare->execute ();
    }

    //終了したリストの削除
    static public function delete ($id) {
        global $pdo;
        $prepare = $pdo->prepare ("delete from todolist where id = :id");
        $prepare->bindValue (':id', (int) $id);
        $prepare->execute ();
    }

    //flgの変更
    static public function update ($id) {
      global $pdo;
      $query = $pdo->prepare ("update todolist set flg = 0 where id = :id");
      $query->bindValue (":id", (int) $id);
      $query->execute ();
    }

    /**
    * Done todo
    * @author mohammad
    * @param int $id
    */
    public function done_todo($id)
    {
      $now = time();

      $data = [ 'flg' => 1, 'date' => $now ];
      $where = [ 'id' => $id ];

      $this->update_sql_query($data, $where, );
    }

    public function return_todo($id)
    {
      $now = time();
  
      $data = [ 'flg' => 0, 'date' => $now ];
      $where = [ 'id' => $id ];
  
      $this->update_sql_query($data, $where);
    }
}

//DBとの接続
try {
    $pdo = new PDO (
        'mysql:host=localhost; dbname=todo; charset=utf8',
        'root',
        'root',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false 
        ]
    );
} catch (PDOException $e) {
    exit ($e->getMessage ());
};

//($_POST['title']が入力されていたらリストに追加
if (isset ($_POST['title'])) {
    $list = new todo ($_POST);
    $list->insert ($list);
    header ('Location: index.php');
};

//$_POST['id']が1のときの0に変更、0のときは削除
if (isset ($_POST['id'])) {
    if ($_POST['flg'] === '1') {
        todo::update ($_POST['id']);
    } else {
        todo::delete ($_POST['id']);
    };  
    header ('Location: index.php');
};

?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel='stylesheet' href='index.css'>
</head>
<body>
    <ul class='ul'>
        <li>これからやること</li>
        <?php 
            $lists = todo::get_todo ();
            foreach ($lists as $list) {
        ?>
            <li class='todo'><?php echo htmlspecialchars ($list['title']) ." " .htmlspecialchars ($list['content']); ?></li>
            <li>
                <form method='POST'>
                    <input type='hidden' value='<?php echo $list['id']; ?>' name='id'>
                    <input type='hidden' value='<?php echo $list['flg']; ?>' name='flg'>
                    <input type='submit' value='終了' class='todo_button'>
                    <input type='submit' value='編集' class='todo_button'>
                    <input type='submit' value='削除' class='todo_button'>
                </form>
            </li>
        <?php
            };
        ?>
    </ul>

    <ul class='ul'>
        <li>もうやったこと</li>
        <?php 
            $lists = todo::end_todo ();
            foreach ($lists as $list) {
        ?>
            <li class='todo'><?php echo htmlspecialchars ($list['title']) ." " .htmlspecialchars ($list['content']); ?></li>
            <li>
                <form method='POST' action="">
                    <input type='hidden' value='<?php echo $list['id']; ?>' name='id'>
                    <input type='hidden' value='<?php echo $list['flg']; ?>' name='flg'>
                    <input type='submit' value='削除' class='todo_button'>
                </form>
            </li>
        <?php
            };
        ?>
    </ul>

    <form method="POST" class='form'>
        <textarea placeholder="内容を入力してね" name='content' class='content'></textarea>
        <input type="submit" value="追加" class='todo_button'>
    </form>
</body>
</html> 