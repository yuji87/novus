<?php
session_start();
require_once '../../classes/UserLogic.php';

if (!$logout = filter_input(INPUT_POST, 'logout')) {
    exit ('不正なリクエストです');
}

//ログイン可否を判定、セッションが切れていたらログインを促すメッセージ
$result = UserLogic::checkLogin();
if (!$result) {
    exit ('セッションが切れているので、再ログインをして下さい');
    
}

//ログアウトをする
UserLogic::logout();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/top.css" />
    <title>ログアウト画面</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5 text-center">
    <div class = "container bg-white p-5">
        <div class="row align-items-start">
            <h2 class="my-3 h1">ログアウト完了</h2>
            <p>ログアウトが完了しました</p>
            <div class="text-center">
                <br><br><a class="btn btn-secondary" href="../../top.php" role="button">TOPページ</a>
            </div>
        </div>
    </div>
</body>
</html>