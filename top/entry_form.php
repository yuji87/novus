<?php
    session_start();
    
    require_once '../classes/UserLogic.php';

    $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
    unset($_SESSION['login_err']);

    //エラーメッセージ表示
    $err = $_SESSION;
    //セッションを消す
    $_SESSION = array();
    session_destroy(); 
?>

<!--ログインフォーム-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/top.css" />
    <title>新規会員登録</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5">
    <form class="row g-3 bg-white p-2 p-md-5 shadow-sm" enctype="multipart/form-data" action="entry_done.php" method="POST">
        <h1 class="my-3">アカウント作成</h1>
            <?php if (isset($login_err)) : ?>
                <p><?php echo $login_err; ?></p>
            <?php endif; ?>
        <p class="my-3">当サービスを利用するために、次のフォームに必要事項をご記入ください。</p>
        <!--名前を記入-->
        <div class="row my-4">
            <label for="name" class="form-label font-weight-bold">*Name</label>
            <div class="md-3">
                <input type="text" class="form-control col-6" name="name">
                <!--欄の下に未記入時のエラーメッセージ表示-->
                <?php if (isset($err['name'])) : ?>
                    <p class="text-danger"><?php echo $err['name']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!--電話番号を記入-->
        <div class="row my-3">
            <label for="tel" class="form-label font-weight-bold">*Phone</label>
            <p class="small text-muted">（ハイフンなし・半角数字）</p>
            <div class="md-3">
                <input type="tel" oninput="value = value.replace(/[０-９]/g,s => 
                    String.fromCharCode(s.charCodeAt(0) - 65248)).replace(/\D/g,'');" 
                    class="form-control col-6" name="tel">
                <!--欄の下に未記入時のエラーメッセージ表示-->
                <?php if (isset($err['tel'])) : ?>
                    <p class="text-danger"><?php echo $err['tel']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!--メアドを記入-->
        <div class="row my-3">
            <label for="email" class="form-label font-weight-bold">Email</label>
            <div class="md-3">
                <input type="email" class="form-control col-6" name="email">
                <!--欄の下に未記入時のエラーメッセージ表示-->
                <?php if (isset($err['email'])) : ?>
                    <p class="text-danger"><?php echo $err['email']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!--パスワードを記入-->
        <div class="row my-3">
            <label for="password" class="form-label font-weight-bold">*Password</label>
            <p class="small text-muted">（半角英数字・4文字以上20文字以下）</p>
            <div class="md-3">
                <input type="password" class="form-control col-4" id="inputPassword8" name="password">
                <!--欄の下に未記入時のエラーメッセージ表示-->
                <?php if (isset($err['password'])) : ?>
                    <p class="text-danger"><?php echo $err['password']; ?></p>
                <?php endif; ?>
            </div>
        </div>
ssss
        <!--確認パスワードを記入-->
        <div class="row my-3">
            <label for="password_conf" class="form-label small font-weight-bold">確認：passwordを再入力してください</label>
            <div class="md-4">
                <input type="password" class="form-control col-4" id="inputPassword4" name="password_conf">
                <!--欄の下に未記入時のエラーメッセージ表示-->
                <?php if (isset($err['password_conf'])) : ?>
                    <p class="text-danger"><?php echo $err['password_conf']; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!--アイコン用の画像を選択-->
        <div class="row my-3">
            <label for="icon" class="form-label font-weight-bold">Icon</label>
                <!-- <div class="md-4" type="hidden" name="MAX_FILE_SIZE" value="1048576"> -->
                    <input type="file" class="form-control-file" accept="image/*" id="input" name="icon">
                    <!--欄の下に未記入時のエラーメッセージ表示-->
                    <?php if (isset($err['icon'])) : ?>
                        <p class="text-danger"><?php echo $err['icon']; ?></p>
                    <?php endif; ?>
                <!-- </div> -->
        </div>

        
        <!--送信ボタン-->
        <div class="col-12 my-4 text-center">
            <p><input type="submit" class="btn btn-primary" value="Sign up"></p>
            <!--entry_form.phpへ-->
            <a href = "login_form.php">ログインはこちら</a>
        </div>

    </form>
</body>
</html>