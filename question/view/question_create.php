<?php
    session_start();
    
    //ファイルの読み込み
    require_once '../../classes/UserLogic.php';
    require_once '../../classes/QuestionLogic.php';
    require_once '../../classes/CategoryLogic.php';


    $result = UserLogic::checkLogin();
    if(!$result) {
        $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
        header('Location: ../../top/userLogin/login_top.php');
        return;
    }


    //error
    $err = [];

    $categories = CategoryLogic::getCategory();

    if(isset($_POST['create_question'])){
        $_SESSION['q_data']['user_id'] = filter_input(INPUT_POST, 'user_id');
        $_SESSION['q_data']['title'] = filter_input(INPUT_POST, 'title');
        $_SESSION['q_data']['category'] = filter_input(INPUT_POST, 'category');
        $_SESSION['q_data']['message'] = filter_input(INPUT_POST, 'message');
        
        if(isset($_POST['question_image'])){
            $_SESSION['q_data']['question_image'] = filter_input(INPUT_POST, 'question_image');
        }else{
            $_SESSION['q_data']['question_image'] = null;
        }
        
        if(!$_SESSION['q_data']['title']) {
            $err['title'] = '質問タイトルを入力してください';
        }

        if(!$_SESSION['q_data']['category']) {
            $err['category'] = 'カテゴリを選択してください';
        }

        if(!$_SESSION['q_data']['message']) {
            $err['message'] = '本文を入力してください';
        }
        
        if (count($err) === 0){
            header('Location: question_comp.php');
        }
    }
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

<form method="POST" action="" name="q_data">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user']['user_id']; ?>">
    <div class=""style="text-align: center">
    <div>
        <?php if(isset($err['title'])): ?>
        <?php echo $err['title'] ?>
        <?php endif; ?>
    </div>
    <div>題名</div>
    <input type="text" name="title"><br>
    <div>
        <?php if(isset($err['category'])): ?>
        <?php echo $err['category'] ?>
        <?php endif; ?>
    </div>
    <div>カテゴリ</div>
    <select name="category">
        <option></option>
        <?php foreach($categories as $value){ ?>
            <option value="<?php echo $value['cate_id'] ?>"> 
                <?php echo $value['category_name'] ?>
            </option>";
        <?php } ?>
    </select>
    <br>
    <div>
        <?php if(isset($err['message'])): ?>
        <?php echo $err['message'] ?>
        <?php endif; ?>
    </div>
    <div>本文</div>
    <textarea name="message"></textarea>
    <br>
    <div>添付</div>
    <div>※jpgもしくはpng形式にてお願いいたします。</div>
        <input type="file" name="question_image" accept="image/png, image/jpeg">
    <input type="submit" name="create_question">
</form>

</body>
</html>