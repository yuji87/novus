<?php
session_start();
// connect DB
require_once '../classes/UserLogic.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="edit_confirm.php" method="post" enctype="multipart/form-data">
        <input type="file" name="icon">
        <button type="submit" name ="submit">UPLOAD</button>
    </form>

<!DOCTYPE HTML>
    <style type="text/css">
      #dropzone {
        background-color: #ddd; min-height: 160px;
      }
      #dropzone.dropover {
        background-color: #ddd; color: #aaa;
      }
      #files:empty::before { color: #ccc; }
      #files img {
        max-height: 128px; max-width: 128px;
      }
    </style>
    <meta charset="UTF-8">
    <title>ファイルのアップロードのサンプル</title>
  </head>
  <body>
 
    <h3>ファイルのアップロードのサンプル</h3>
 
    <div id="dropzone" effectAllowed="move">ここにファイルをドロップ</div>
    <ul id="files"></ul>
    <script src="uploadimg.js"></script>
    <script src="dropfile.js"></script>
</html>
</body>
</html>