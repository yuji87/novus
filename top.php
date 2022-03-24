<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/top.css" />
    <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
    <title>トップ画面</title>
</head>


<body class="p-3">
	<!-- ヘッダ -->
	<header>
	  <nav class="navbar navbar-expand-lg" style="background-color:rgba(55, 55, 55, 0.98);">
		<div class="container-fluid">
			<a class="avbar-brand font-weight-bold h3 text-white" href="#">Q&A SITE</a>
			<span class="navbar-text">
			<a href="top/userLogin/login_form.php"><i class="fa-solid fa-arrow-right-to-bracket text-white" style="padding-right:10px;"></i></a>
			<a href="top/userCreate/signup_form.php"><i class="fa-solid fa-user-plus text-white"></i></a>
			</span>
		</div>

		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link active small text-white" href="#">質問コーナー</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small text-white" href="#">記事コーナー</a>
			</li>
			<li class="nav-item">
				<a class="nav-link small text-white" href="#">本ライブラリ</a>
			</li>
		</ul>
	</header>
<!-- コンテンツ（中央カラム） -->
	<div id="content" class="text-center mt-2"  style="background-color:rgba(236, 235, 235, 0.945);">
		<div class="text-center">
      <br><br>
			<h5>質問を検索</h5>
              <form>
                <div class="form-row text-center">
                  <div id="keyword" class="form-group col-row">
                    <div>
                      <input type="text" class="form-control" id="question" placeholder="キーワード">
                    </div>
                  </div>
                  <br>
                  <div class="form-group col-row">
                    <label class="small">カテゴリー</label>
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
                <button type="submit" class="btn btn-primary">検索</button>
                <hr>

			</form>
        </div>

	<!--新着の記事-->
    <br>
		<div id="news" class="text-center">
			<h5>新着の質問</h5>
			<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
			<p class="font-weight-normal">投稿日時とか入れる</p>
			<hr />
		</div>
		<div id="news" class="text-center">
			<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
			<p class="font-weight-normal">投稿日時とか入れる</p>
			<hr />
		</div>
		<div id="news" class="text-center">
			<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
			<p class="font-weight-normal">投稿日時とか入れる</p>
			<hr />
		</div>
		<div id="news" class="text-center">
			<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
			<p class="font-weight-normal">投稿日時とか入れる</p>
			<hr />
		</div>
		<div id="news" class="text-center">
			<p class="font-weight-bold">質問投稿のタイトルが入るよ</p>
			<p class="font-weight-normal">投稿日時とか入れる</p>
			<hr />
		</div>
	</div>
	
	<!-- フッタ -->
	<footer class="h-10">
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
