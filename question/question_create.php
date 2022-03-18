<?php
    session_start();
    
    require_once '../classes/UserLogic.php';
    require_once '../classes/QuestionLogic.php';

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

<div>質問したい内容を入力してください</div>
<form method="POST" action="question_comp.php">
    <input type="hidden" name="user_id" value="<?php echo "999"; ?>">
    <div class=""style="text-align: center">
        <div>題名</div>
            <input type="text" name="title" required><br>
        <div>カテゴリ</div>
            <select name="category" required>
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
        <div>※jpgもしくはpng形式にてお願いいたします。</div>
            <input type="file" name="question_image" accept="image/png, image/jpeg">
        <input type="submit" name="create_question">
    </div>
</form>


    
</body>
</html>