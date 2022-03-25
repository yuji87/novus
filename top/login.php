<?php
    session_start();

    // ファイルの読み込み
    require_once '../classes/UserLogic.php';

    // エラーメッセージ
    $err = [];

    $name = filter_input(INPUT_POST, 'name');
    $tel = filter_input(INPUT_POST, 'tel');
    $password = filter_input(INPUT_POST, 'password');
    
    // バリデーション
    if(!$name = filter_input(INPUT_POST, 'name')) {
        $err['name'] = '名前を入力してください';
    }
    if(!$tel = filter_input(INPUT_POST, 'tel')) {
        $err['tel'] = '電話番号を入力してください';
    }
    if(!$password = filter_input(INPUT_POST, 'password')) {
        $err['password'] = 'パスワードを入力してください';
    }

    // エラーがあったらフォーム画面に戻す
    if (count($err)>0){
        $_SESSION = $err;
        header('Location: login_form.php');
        return;
    }

    // ログインに成功した時の処理
    $result = UserLogic::login($name, $tel, $password);
    // ログインに失敗した時の処理
    if (!$result){
        header('Location: login_form.php');
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/top.css" />
    <title>ログイン完了画面</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5 text-center">
    <div class = "container bg-white p-5">
        <div class="row align-items-start">
            <h2 class="my-3 h1">ログインが<br>完了しました</h2>
            <div class="text-center">
                <br><br><a class="btn btn-secondary" href="login_top.php" role="button">TOPページ</a>
            </div>
        </div>
    </div>
</body>
</html>