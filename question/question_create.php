<?php
    session_start();
    
    require_once '../classes/UserLogic.php';

    $result = UserLogic::checkLogin();
    if($result) {
    header('Location: login_top.html');
    return;
    }
    
    $login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
    unset($_SESSION['login_err']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>質問投稿ページ</title>
</head>
<body>
    
<?php

// DB接続情報の記載
$dsn = "mysql:host=localhost; dbname=01; charset=utf8;";
$username = "root";
$password = "";
try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

// require_once("../core/DBConnect.php");
// require_once("../core/table/UsersTable.php");


if (!empty($_POST)) {

        //エラーが無い場合  入力されたユーザー情報をDBに登録
        try {
            // {
                $userID = 0;
                $title = $_POST['title'];
                $message = $_POST['message'];
                $category = $_POST['category'];

                $post_date = date('Y-m-d H:i:s');
                $upd_date = date('Y-m-d H:i:s');
                var_dump($_POST['title']);
                var_dump($_POST['message']);
                var_dump($_POST['category']);
                // $dataAry = [
                //     'user_id' => $userID,
                //     'title' => $title,
                //     'message' => $message,
                //     'post_date' => date('Y-m-d H:i:s'),
                //     'upd_date' => date('Y-m-d H:i:s'),
                //     'cate_id' => $category,
                // ];
                echo "3・";

                $sql = 'INSERT INTO question_posts(user_id, title, message, post_date, upd_date, cate_id) VALUES(:uid, :title, :message, :post_date, :upd_date, :cate_id)';
        $stmt = $dbh->prepare($sql);
        // bindValueで投稿内容の準備
        $stmt->bindValue(':uid', 1);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':post_date', $post_date);
        $stmt->bindValue(':upd_date', $upd_date);
        $stmt->bindValue(':cate_id', 1);

        // }
        // $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        echo "4・";
            $post = $stmt->fetch();

            //ログインしてタイムラインページ表示
            // Session::setLoginUserID($id);
            header('Location:http://localhost/qandasite/question/question_comp.php');
        } catch (Exception $exception) {
            dlog('question_create.phpにてエラー:', $exception);

            echo "5・";
        }

    }
// }

?>


<div>質問したい内容を入力してください</div>

<form method="POST" action="">
    <div class=""style="text-align: center">
        <div>題名</div>
        <input type="text" name="title" required>
        <br>

        <div>カテゴリ</div>
        <select name="category" required >
            <option></option>

            <option value="1">項目1</option>

            <?php foreach($categories as $value){
                echo "<option value=".$value['cate_id'] .">" .$value['categpry_name'] ."</option>";
            } ?>
        </select>

        <br>
        <div>本文</div>
        <textarea required name="message"></textarea>
        <br>
        <div>添付</div>
        <div></div>
        <input type="submit" name="create_question">
    </div>
</form>

<?php


?>

    
</body>
</html>