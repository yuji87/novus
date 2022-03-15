<?php //DB接続で値をinsert

    //ファイルの読み込み
    require_once('core/DBconnect.php');
    require_once('core/AppController.php');

    //POSTで受信した情報をデータベースに登録
    if(!empty($_POST['check'])){
        try{
            $sql = '
                    INSERT INTO users{
                        name,
                        tel,
                        email
                    )
                    VALUES(
                        :name,
                        :tel,
                        :email
                    )
                    ';

        //追加
        $obj = new AppController();
        $obj->insert_users($sql,  $_POST['name'], $_POST['tel'], $_POST['email']);

        print "<p>ログイン成功</p>";

        header('location: enrty_done.php' .$_SERVER["HTTP_REFERER"]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    

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

<body class="h-100 bg-secondary p-4 p-md-5">
    <form action="" method="POST" class="row g-3 bg-white p-2 p-md-5 shadow-sm">
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
            <p><span class="fas fa-angle-double-right"></span> <span name="name" class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
        </div>
        <div class="control">
            <p>Phone</p>
            <p><span class="fas fa-angle-double-right"></span> <span name="tel" class="check-info"><?php echo htmlspecialchars($_SESSION['join']['tel'], ENT_QUOTES); ?></span></p>
        </div>
        <div class="control">
            <p>Email</p>
            <p><span class="fas fa-angle-double-right"></span> <span name="email" class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
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