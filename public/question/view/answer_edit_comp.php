<?php
    session_start();

    //ファイルの読み込み
    require_once '../../app/QuestionLogic.php';

    //error
    $err = [];

    // データの受け渡しチェック
    if (isset($_SESSION['a_data']['answer_id']) &&
        isset($_SESSION['a_data']['message'])
      ){        
      //返答を編集する処理
      $hasEditted = QuestionLogic::editAnswer();
      if(!$hasEditted){
        $err[] = '更新に失敗しました';
      }      
      //返答を取得する処理
      $hasTaken = QuestionLogic::displayOneAnswer($_SESSION['a_data']['answer_id']);
      if(!$hasTaken){
        $err[] = '返答の取り込みに失敗しました';
      }
    }

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
  <title>返答編集完了</title>
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
                <p>以下の内容で編集が完了しました</p>
                <div>本文：<?php echo $hasTaken['message'] ?></div>
                <form method="GET" name="form1" action="question_disp.php">
                    <input type="hidden" name="question_id" value="<?php echo $hasTaken['question_id']; ?>">
                    <a href="javascript:form1.submit()">詳細画面へ</a>
                </form>
                <button type="button" onclick="location.href='../../top/userLogin/login_top.php'">TOP</button>
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
</html>