<?php
    session_start();

    //ファイルの読み込み
    require_once 'classes/UserLogic.php';

    //エラーメッセージ
    $err = [];

    $name = filter_input(INPUT_POST, 'name');
    $tel = filter_input(INPUT_POST, 'tel');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    $icon = filter_input(INPUT_POST, 'icon');

    //バリデーション
    if(!$name = filter_input(INPUT_POST, 'name')){
        $err['name'] = '名前を入力してください';
    }
    if(!$tel = filter_input(INPUT_POST, 'tel')){
        $err['tel'] = '電話番号を入力してください';
    }
    if(!$email = filter_input(INPUT_POST, 'email')){
        $err['email'] = 'メールアドレスを入力してください';
    }
    $password = filter_input(INPUT_POST, 'password');
    //正規表現
    if (!preg_match("/\A[a-z\d]{4,20}+\z/i", $password)){
        $err['password'] = 'パスワードは英数字4文字以上20文字以下にしてください';
    }
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    if ($password !== $password_conf){
        $err['password_conf'] = '確認用パスワードと異なっています';
    }
    if(!$icon = filter_input(INPUT_POST, 'icon')){
        $err['icon'] = 'アイコン用の画像を選択してください';
    }

    // エラーがあったらフォーム画面に戻す
    if (count($err)>0){
        $_SESSION = $err;
        header('Location: entry_form.php');
        return;
    }
    
    //エラーがなかった場合の処処理
    if (count($err) === 0){
        //ユーザーを登録する
        $hasCreated = UserLogic::createUser($_POST);
        //既に存在しているアカウントの場合
        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/top.css" />
    <title>会員登録完了画面</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5">
    <div class = "container bg-white p-5 text-center small">
        <?php if (count($err) > 0) :?>
            <?php foreach($err as $e) :?>
                <p><?php echo $e ?></p>
            <?php endforeach ?>
        <?php else :?>
        <div class="row align-items-start">
            <h1 class="my-3 h1">会員登録が<br>完了しました</h1>
        <?php endif ?>
            <!--TOPページへ-->
            <div class="text-center">
                <br><br><a class="btn btn-secondary" href="login_top.html" role="button">TOPページ</a>
            </div>
        </div>
    </div>
</body>
</html>
