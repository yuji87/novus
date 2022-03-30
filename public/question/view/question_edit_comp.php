<?php

  session_start();

  //ファイルの読み込み
  require_once '../../app/QuestionLogic.php';
  require_once '../../app/UserLogic.php';

  // ログインチェック
  $result = UserLogic::checkLogin();
  if(!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../../top/userLogin/login_top.php');
    return;
  }

  //error
  $err = [];

  // データ受け渡しチェック
  if (isset($_SESSION['q_data']['title']) &&
    isset($_SESSION['q_data']['category']) &&
    isset($_SESSION['q_data']['message']) &&
    isset($_SESSION['q_data']['question_id'])
    ){
      //質問を登録する処理
      $question = QuestionLogic::editQuestion();
        if(!$question){
          $err[] = '変更の保存に失敗しました';
        }
    }
  // 質問IDから質問内容を取り込む処理
  $data = QuestionLogic::displayQuestion($_SESSION['q_data']);
    if(!$data){
      $err[] = '変更の保存に失敗しました';
    }
  $title = $data['title'];
  $category = $data['category_name'];
  $message = $data['message'];
  $question_id = $_SESSION['q_data']['question_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../../public/CSS/mypage.css" />
  <link rel="stylesheet" type="text/css" href="../../public/CSS/top.css" />
  <link rel="stylesheet" type="text/css" href="../../public/CSS/question.css" />
  <title>質問削除</title>
</head>

<body>
  	<!--メニュー-->
	  <header>
        <div class="navtext-container">
            <div class="navtext">Q&A SITE</div>
        </div>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="top"><a href="../../top/userLogin/login_top.php">TOP Page</a></li>
            <li><a href="../userEdit/edit_user.php">My Page</a></li>
            <li><a href="#">TO DO LIST</a></li>
            <li><a href="../../question/view/qhistory.php">質問 履歴</a></li>
            <li><a href="../../">記事 履歴</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
	  <section class="wrapper">
        <div class="container">
            <div class="content">
                <p class="h4 pb-3 mt-3">編集完了</p>
                <p>以下の内容で保存しました</p>
                <div>題名：<?php echo $title ?></div>
                <div>カテゴリー：<?php echo $category ?></div>
                <div>本文：<?php echo $message ?></div>
                <form method="GET" action="question_disp.php">
                    <input type="hidden" name= "question_id" value="<?php echo $question_id ?>">
                    <input type="submit" value="質問へ">
                </form>
                <button type="button" onclick="">TOP</button>
            </div>
        </div>
    </section>

    <!-- フッタ -->
    <footer class="h-10"><hr>
		    <div class="footer-item text-center">
		    	  <h4>Q&A SITE</h4>
		    	  <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
		    			  <a class="nav-link small" href="#">記事</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">質問</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">本検索</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">お問い合わせ</a>
		    		</li>
		    	</ul>
		    </div>
		  <p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>
	</footer>
</body>

