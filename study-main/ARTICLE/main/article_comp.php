<?php
  session_start();
  require_once('app/Article.php');

  $title = filter_input(INPUT_POST, 'title');
  $category = filter_input(INPUT_POST, 'category');
  $contents = filter_input(INPUT_POST, 'contents');

  if (empty($error)) {
  //DBに登録
  $hasApped = Article::add($_POST);
    if(!$hasApped){
      $err[] = '登録に失敗しました';
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事投稿完了</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
  <link rel="stylesheet" href="style.css">
  <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js" defer></script>
  <script src="script.js" defer></script>
</head>
<body>

<div>投稿完了</div>
<div>以下の内容で投稿が完了しました</div>

  <h2><i class="fas fa-feather-alt"></i> *Title：<?php echo $title ?></h2>
  <div>Category：<?php echo $category ?></div>
  <h2><i class="fas fa-edit"></i> *Contents：<?php echo $contents ?></h2>

  <form method="POST" name="form1" action="display.php">
    <input type="hidden" name="question_id" value="<?php echo $data['question_id']; ?>">
    <a href="javascript:form1.submit()">詳細画面へ</a>
  </form>
<a href="../login_top.php">TOP</a>

</body>
</html>