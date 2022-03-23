<?php
try {
  $serverName = "(localDB)\\vscphpwebapps";
  $uid = "sa";
  $pwd = "**********";
  $dbname = "todolist";
  $dsn = "sqlsrv:server=" . $serverName . ";database=" . $dbname;

  $pdo = new PDO($dsn, $uid, $pwd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
  //$pdo = new PDO($dsn, $uid, $pwd);
  //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $tsql = "SELECT * from todoitems";
  $stmt = $pdo->query($tsql);
} catch (Exception $e) {
  $stmt = null;
  $pdo = null;
  header("Content-Type: text/plain; charset=UTF-8", true, 500);
  exit();
  //exit($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ToDo List</title>
</head>
<body>
  <h1>To Do List</h1>
  <ul>
    <?php foreach ($stmt as $row) {?>
      <li><?=htmlspecialchars($row["item"], ENT_QUOTES)?></li>
    <?php  }?>
    <?php
    $stmt = null;
    $pdo = null;
    ?>
  </ul>
  <p>register todo item</p>
  <form action="additem.php" method="post">
    item:
    <input name="item">
    <input type="submit" name="submit">
  </form>
</body>
</html>