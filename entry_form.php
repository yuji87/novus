<?php
    session_start();
    
    require_once 'classes/UserLogic.php';

    $result = UserLogic::checkLogin();
    if($result) {
    header('Location: login_top.html');
    return;
    }
    
    $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
    unset($_SESSION['login_err']);
?>

<!--ログインフォーム-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>新規会員登録</title>
</head>

<body class="h-100 bg-secondary p-4 p-md-5">
    <?php if (isset($login_err)) : ?>
        <p><?php echo $login_err; ?></p>
    <?php endif; ?>
    <form class="row g-3 bg-white p-2 p-md-5 shadow-sm" action="entry_done.php" method="POST">
        <h1 class="my-3">アカウント作成</h1>
            <p class="my-2">当サービスを利用するために、次のフォームに必要事項をご記入ください。</p>
            <!--名前を記入-->
            <div class="row my-4">
                <label for="name" class="form-label">*Name</label>
                <div class="md-3">
                    <input type="text" class="form-control col-6" name="name" required>
                    <!--名前の未入力チェック-->
                    <?php //if (!empty($error["name"]) && $error['name'] === 'blank'): ?>
                        <!-- <p class="error text-danger">＊名前を入力してください</p> -->
                    <?php //endif ?> 
                </div>
            </div>
            <!--電話番号を記入-->
            <div class="row my-4">
                <label for="tel" class="form-label">*Phone</label>
                <div class="md-3">
                    <input type="text" class="form-control col-6" name="tel" required>
                    <!--電話番号の未入力チェック-->
                    <?php //if (!empty($error["tel"]) && $error['tel'] === 'blank'): ?>
                        <!-- <p class="error text-danger">＊電話番号を入力してください</p> -->
                    <!--電話番号の重複防止-->
                    <?php //elseif (!empty($error["tel"]) && $error['tel'] === 'duplicate'): ?>
                        <!-- <p class="error">＊この電話番号はすでに登録済みです</p> -->
                    <?php //endif ?>
                </div>
            </div>
            <!--メアドを記入-->
            <div class="row my-4">
                <label for="email" class="form-label">Email</label>
                <div class="md-3">
                    <input type="email" class="form-control col-6" name="email" required>
                </div>
            </div>
            <!--パスワードを記入-->
            <div class="row my-4">
                <label for="password" class="form-label">*Password</label>
                <div class="md-3">
                   <input type="password" class="form-control col-4" id="inputPassword8" name="password" required>
                </div>
            </div>

            <!--確認パスワードを記入-->
            <div class="row my-4">
                <label for="password_conf" class="form-label">確認:passwordを入力してください</label>
                <div class="md-3">
                   <input type="password" class="form-control col-4" id="inputPassword8" name="password_conf" required>
                </div>
            </div>

        <div class="col-12 my-4">
            <<input type="submit" class="btn btn-primary" value="Sign up">
        </div>
    </form>
</body>
</html>