<?php
    session_start();

    //ファイルの読み込み
    require_once '../classes/UserLogic.php';

    //エラーメッセージ
    $err = [];

    $name = filter_input(INPUT_POST, 'name');
    $tel = filter_input(INPUT_POST, 'tel');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    $icon = filter_input(INPUT_POST, 'icon');

    //初期値 
    // var_dump($icon);
    // $filename = array('name' => null);;
    // $tmp_path = array('tmp_path' => null);
    // $file_err = array('error' => null);
    // $filesize = array('size' => null);

    //バリデーション
    if(!$name){
        $err['name'] = '名前を入力してください';
    }
    if(!$tel){
        $err['tel'] = '電話番号を入力してください';
    }
    //正規表現
    if (!preg_match("/\A[a-z\d]{4,20}+\z/i", $password)){
        $err['password'] = 'パスワードは英数字4文字以上20文字以下にしてください';
    }
    if ($password !== $password_conf){
        $err['password_conf'] = '確認用パスワードと異なっています';
    }

    // ファイルのバリデーション
    // ファイルサイズが1MB未満か
    if (isset($_FILES['icon']) && $filesize > 1048576 || $err == 2) {
        $err['icon'] = 'ファイルサイズは1MB未満にしてください';

        // ファイル関連の取得
        $icon = $_FILES['icon'];
        $filename = basename($icon['name']);
        $tmp_path = $icon['tmp_name'];
        $filesize = $icon['size'];
        $upload_dir = 'XAMPP/htdocs/qandasite/img';

        // 拡張は画像形式か
        $allow_ext = array ('jpg', 'jpeg', 'png');
        $file_ext = pathinfo ($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            $err['icon'] = '画像ファイルを添付してください';
        }

    //エラーがなかった場合の処処理
    if (count($err) === 0) {
        if ($icon !== "" && ($icon['error'] === 0)) {
            //ユーザーを登録する
            $hasCreated = UserLogic::createUser($_POST);
            //move_uploaded_file
            move_uploaded_file( "img/" . $filename);
            $_SESSION['icon'] = $filename;
            header('Location: login_top.php');
            //既に存在しているアカウントの場合
            if(!$hasCreated) {
            $err[] = '登録に失敗しました';
            }
    } else {
         //ユーザーを登録する
         $hasCreated = UserLogic::createUser($_POST);
         //move_uploaded_file
         move_uploaded_file( "img/sample_done.jpg" . $filename);
         $_SESSION['icon'] = $filename;
         header('Location: login_top.php');
         //既に存在しているアカウントの場合
         if(!$hasCreated){
         $err[] = '登録に失敗しました';
        }
    }
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
                <br><br><a class="btn btn-secondary" href="login_form.php" role="button">ログインする</a>
            </div>
        </div>
    </div>
</body>
</html>
