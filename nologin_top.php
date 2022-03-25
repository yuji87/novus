<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/top.css" />
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <title>CSS learning</title>
</head>


<body class="bg-white p-4 p-md-5">
	<!-- ヘッダ -->
	<header>
	  <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="avbar-brand font-weight-bold h3" href="#">Q&A SITE</a>
			<span class="navbar-text">
				<a href="top/login_form.php" class= "col-md-2 small">Login</a>
				<a href="top/entry_form.php" class= "col-md-2 small">Signup</a>
			</span>
		</div>

		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link active small" href="#">質問コーナー</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small" href="#">記事コーナー</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small" href="#">本コーナー</a>
			</li>
		</ul>
	</header>
<!-- コンテンツ（中央カラム） -->
	<div id="content" class="text-center">
		<div class="text-center">
      <br><br>
			<h5>質問を検索する</h5>
              <form>
                <div class="form-row text-center">
                  <div id="keyword" class="form-group col-row">
                    <label for="inputEmail4">キーワード</label>
                    <div>
                      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                  </div>
                  <br>
                  <div class="form-group col-row">
                    <label for="inputPassword4">ジャンル</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                      <option selected>Choose...</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                  </div>
                </div>
              </form>
                <br>
                <button type="submit" class="btn btn-primary">Search</button>
                <hr>

			</form>
        </div>

		<!-- ニュース（中央カラム） -->
    <br>
		<div id="news" class="text-center">
			<h4>新着の質問</h4>
			<h5>質問投稿のタイトルが入るよ</h5>
			<p>
			ここに質問投稿が入るよ
			</p>
			<p>投稿日時とか入れる</p>
			<hr />
		</div>

	</div>

	
	<!-- フッタ -->
	<p class="text-center">Copyright (c) HTMQ All Rights Reserved.</p></div>

</div>
</body>
</html>
