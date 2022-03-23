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


require_once("../core/DBConnect.php");
require_once("../core/table/UsersTable.php");

if (!empty($_POST)) {

        //エラーが無い場合  入力されたユーザー情報をDBに登録
        try {
            // {
                $userID = 0;
                $title = $_POST['title'];
                $message = $_POST['message'];
                $category = $_POST['category'];
                $dataAry = [
                    'user_id' => $userID,
                    'title' => $title,
                    'message' => $message,
                    'post_date' => date('Y-m-d H:i:s'),
                    'upd_date' => date('Y-m-d H:i:s'),
                    'cate_id' => $category,
                ];
                echo "3・";
                // $pdow = DBConnect::getPdow();
                // $dsn = DB_TYPE.':dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8';
                $dsn = 'mysql:dbname=qanda;host=localhost;charset=utf8';
            $user = 'root';
            $password = "";
                        var_dump($dsn);
            var_dump($user);
            var_dump($password);

                echo "4・";
            // }
            $sql = 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            //ログインしてタイムラインページ表示
            Session::setLoginUserID($id);
            header('Location:http://localhost/qandasite/question/question_comp.php');
        } catch (Exception $exception) {
            // dlog('question_create.phpにてエラー:', $exception);
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
            <option>項目1</option>
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