<?php
include("Todo.php");
include("controller.php");
require_once("config.php");

use TodoApp\db;
use TodoApp\Todo;

$pdo = db::getInstance();
$todo = new Todo($pdo);
?>

<!DOCTYPE HTML>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>todo list</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  </head>

  <body>
    <div class="col-md-5 p-5 rounded bg-white mx-auto mt-5">
      <form action="" class="input-group-append" method="post" autocomplete="off">
        <div class="input-group mb-3">
        <input required type="text" value="<?= isset($_GET['action']) && $_GET['action'] == 'edit' ? $_GET['todo'] : ''; ?>" name="task" class="form-control" name id="task" placeholder="write a task ...">
          <div class="input-group-append">
          <input name="<?= isset($_GET['action']) && $_GET['action'] == 'edit' ? 'updateLast' : 'addNew'; ?>" type="submit" value="<?php echo isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Edit' : 'Add'; ?>" class="btn btn-primary" />
          <input type="hidden" type="submit" value="<?= isset($_GET['action']) && $_GET['action'] == 'edit' ? $_GET['id'] : ''; ?>" name="task_id"/>
          </div>
        </div>
      </form>
      <h3 class="mt-4">やること: </h3>
      <?php $todo->show_todo(); ?>
      <br>
      <h3>終わったこと: </h3>
      <?php $todo->show_todo(1); ?>
    </div>
  </body>
</html>