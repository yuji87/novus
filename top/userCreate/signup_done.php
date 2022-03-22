<?php
    // session_start();

    //ファイルの読み込み
    // require_once '../classes/UserLogic.php';

    //エラーメッセージ
    $err = [];
    // if (isset($name) || isset($tel) || isset($email) || isset($password)) {

    
        // $_SESSION['signUp'] = array($_POST['name'], $_POST['tel'], $_POST['email'], $_POST['password']);
    
    /*if(isset($_FILES['icon'])) {
        // ファイル関連の取得
        $icon = $_FILES['icon'];
        $filename = basename($icon['name']);
        $tmp_path = $icon['tmp_name'];
        $filesize = $icon['size'];
        //ファイル名を使用して保存先ディレクトリを指定 
        //basename()でファイルシステムトラバーサル攻撃を防ぐ
        $save = 'img/' . basename($_FILES['icon']['name']);

        // 拡張は画像形式か
        $allow_ext = array ('jpg', 'jpeg', 'png');
        $file_ext = pathinfo ($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            $err['icon'] = '画像ファイルを添付してください';
        }

        if (count($err) === 0) {
        //move_uploaded_fileで、一時ファイルを保存先ディレクトリに移動させる
        move_uploaded_file($_FILES['icon']['tmp_name'], $save);
        }
    } */

    //エラーがなかった場合の処処理
    // if (count($err) === 0 && (!empty($_POST['check']))) {
        //ユーザーを登録する
        // $hasCreated = UserLogic::createUser($_POST);
        // header('Location: signup_done.php');
        //既に存在しているアカウントの場合
        // if(!$hasCreated){
        // $err[] = '登録に失敗しました';
        // }
    // }
    // }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/top.css" />
    <title>会員登録完了画面</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5">
    <div class = "container bg-white p-5 text-center small">
        <!--エラーが発生した場合、メッセージと戻る画面を作成-->
        <?php if (count($err) > 0) :?>
            <?php foreach($err as $e) :?>
                <p><?php echo $e ?></p>
                <?php endforeach ?>
                <div class="text-center">
                    <br><br><a class="btn btn-secondary" href="signup_form.php" role="button">登録画面に戻る</a>
                </div>
        <?php else :?>
        <div class="row align-items-start">
            <h1 class="my-3 h1">会員登録が<br>完了しました</h1>
            <!--TOPページへ-->
            <div class="text-center">
                <br><br><a class="btn btn-secondary" href="../userLogin/login_form.php" role="button">ログインする</a>
            </div>
        <?php endif ?>
        </div>
    </div>
</body>
</html>
