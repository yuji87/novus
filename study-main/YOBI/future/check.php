<?php
    
    //DBファイルを読み込む
    // require_once(dirname(__FILE__)."/core/DBconnect.php");

    //変数の初期化
    $error_message = array();
    $pdo = null;
    $option = null;
    $stmt = null;
    $res = null;
    
    
    session_start();
    
    /* 会員登録の手続き以外のアクセスを飛ばす
    if (!isset($_SESSION['join'])) {
        header('Location: http://localhost/qandasite/entry.php');
        exit();
    }  */
    
    try {
    	// $option = array(
            // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // PDO::MYSQL_ATTR_MULTI_STATEMENTS => false);
        $pdo = new PDO('mysql:charset=UTF8; dbname=qandasite; host=localhost:3306', 'root', '');

        
    } catch(PDOException $e) {
        echo 'だめ';
        // 接続エラーのときエラー内容を取得する
        $error_message[] = $e->getMessage();
    }
    
    $pdo->beginTransaction();   
    

    if (!empty($_POST)) {
        
        try {
            
            // 入力情報をデータベースに登録
            $stmt = $pdo->prepare('INSERT INTO users (name, tel, email) VALUES (:name, :tel, :email)');

            // 値をセット
            $stmt->bindValue( ':name', 'あ');
            $stmt->bindValue( ':tel', '08012345678');
            $stmt->bindValue( ':email', 'abc@gmail.com');
            
            // SQLクエリの実行
            $stmt->execute();

         
    } catch(PDOException $e) {
        // エラーが発生した時はロールバック
        echo "だめ";
        $pdo->rollBack();
    }


    // $stmt->execute(array(
        // $_SESSION['join']['name'],
        // $_SESSION['join']['tel'],
        // $_SESSION['join']['email'],
        // $hash
    // ));
 
    $stmt=null;
    header('Location: http://localhost/qandasite/entry_done.php');   // thank.phpへ移動
    
    $pdo = null;
    
    }
        // try {
            // require_once( "core/table/UsersTable.php" );
        // 入力情報をデータベースに登録
        // $id = UsersTable::createUser(array(
            // KEY_NAME => getPOST(KEY_NAME),
            // KEY_TEL => getPOST(KEY_TEL),
            // KEY_EMAIL => getPOST(KEY_EMAIL),
            // KEY_PASSWORD => getPOST(KEY_PASSWORD)
        // ));

            // unset($_SESSION['join']);   // セッションを破棄
            // header('Location: http://localhost/qandasite/entry_done.php');   // thank.phpへ移動

        // } catch (Exception $exception) {
            // dlog('signup.phpにてエラー:', $exception);
        // }

    // }
        

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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