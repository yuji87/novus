<?php
    
    //DBファイルを読み込む
    require("./dbconnect.php");
    
    session_start();
    
    /* 会員登録の手続き以外のアクセスを飛ばす
    if (!isset($_SESSION['join'])) {
        header('Location: http://localhost/qandasite/bootstrap-5.0.2-dist/entry.php');
        exit();
    }  */
    
    
    if (!empty($_POST['check'])) {
        // パスワードを暗号化
        $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
    
        // 入力情報をデータベースに登録
        $statement = $db->prepare("INSERT INTO users SET name=?, tel=?, email=?, password=?");
        $statement->execute(array(
            $_SESSION['join']['name'],
            $_SESSION['join']['tel'],
            $_SESSION['join']['email'],
            $hash
        ));
    
        unset($_SESSION['join']);   // セッションを破棄
        header('Location: http://localhost/qandasite/bootstrap-5.0.2-dist/entry_done.php');   // thank.phpへ移動
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootstrapのCSS読み込み -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- BootstrapのJS読み込み -->
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>会員登録確認画面</title>
</head>

<body>
    <div class="container bg-secondary p-5">
        <div class="row align-items-start">
        <form action="" method="POST" class="col g-3 bg-white p-2  p-md-5 shadow-sm">
            <input type="hidden" name="check" value="checked">
            <h1 class="my-3 h1">入力情報の確認</h1>
            <p class="my-2">ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
            <p class="my-1">登録情報は後から変更することもできます。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
            <hr>
        
        <div class="align-items-center">
            <div class="control">
                <p>Name</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>Phone</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['tel'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>Email</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
            </div>
            
            <br>
            <div class="col-4 bg-secondary">
                <a href="entry.php" class="back-btn text-white">変更する</a>
            </div>
            <button type="submit" class="my-2 btn next-btn bg-warning text-black">登録する</button>
            <div class="clear"></div>
        </div>
        </form>
        </div>
    </div>
</body>
</html>