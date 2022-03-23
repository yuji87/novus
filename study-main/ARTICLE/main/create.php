<?php require_once("VALIDATION/createVali.php") ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>記事投稿</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
  <link rel="stylesheet" href="CSS/style.css">
  <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js" defer></script>
  <script src="JS/script.js" defer></script>
</head>

<body>
  <div class="container mt-5" id="app">
    <nav class="navbar">
      <h1 class="title">記事投稿</h1>
    </nav>

    <div class="columns">
      <form method="POST" action="" class="column is-6" id="input-field-wrapper" name="faceForm">
        <input type="hidden" name="user_id" value="<?php echo "1"; ?>">

        <h2><i class="fas fa-feather-alt"></i> *Title</h2>
        <input type="text" name="title" class="mb-3">
        <select name="category" style="padding:0.5px; margin-top:0.1px" required>
          <option value="0">*Category</option>
          <option value="1" name="1">数学</option>
          <option value="2" name="2">英語</option>
        </select>

        <h2><i class="fas fa-edit"></i> *Contents</h2>
        <textarea class="textarea" name="contents" id="inputfield" v-model="input"></textarea>

        <label for="file_photo">
          <input type="file" name="image" size="35" onchange="previewImage(this);" id="file_photo" accept='image/*' style="display:none;">
          <span class="filecheck border">ファイルを選択</span><br>
        </label>
        <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="48" height="48" style="max-width:3vw;">

        <input type="submit" class="text-center" value="送信">
      </form>

      <span class="column is-6" id="preview-field-wrapper">
        <h2><i class="fas fa-eye"></i> Preview</h2>
        <div id="preview-field" class="content border" v-html="convertMarkdown"></div>
      </span>
    </div>

    <div class="text-center mt-5">
      <?php if (isset($error["title"]) && $error["title"] === "blank") : ?>
        <p class="error">何も入力されていません</p>
      <?php endif ?>
      <?php if (isset($error["title"]) && $error["title"] === "exceed") : ?>
        <p class="error" id="error">500文字以内で入力してください</p>
      <?php endif ?>
      <?php if (isset($error["category"]) && $error["category"] === "blank") : ?>
        <p class="error col-12">カテゴリを選択してください</p>
      <?php endif ?>
      <?php if (isset($error["contents"]) && $error["contents"] === "blank") : ?>
        <p class="error">何も入力されていません</p>
      <?php endif ?>
      <?php if (isset($error["contents"]) && $error["contents"] === "exceed") : ?>
        <p class="error" id="error">5000文字以内で入力してください</p>
      <?php endif ?>
    </div>

    <span class="mt-4 column">
      <input type="button" value="# " onClick="addTF(this.value)">タイトル(文頭に配置)<br>
      <input type="button" value="## " onClick="addTF(this.value)">サブタイトル(文頭に配置)<br>
      <input type="button" value="`" onClick="addTF(this.value)">色変換(左記を左右に配置)<br>
      <input type="button" value="```" onClick="addTF(this.value)">色変換(左記を上下に配置)<br>
      <input type="button" value="- " onClick="addTF(this.value)">箇条書き(文頭に配置)<br>
      <input type="button" value="__" onClick="addTF(this.value)">太字(左記を左右に配置)<br>
      <input type="button" value="~~" onClick="addTF(this.value)">取り消し線(左記を左右に配置)<br>
    </span>

    <div class="manual offset-5 mb-5">
      <button id="modalOpen" class="button commandTitle">コマンド一覧<buttton>
          <div id="easyModal" class="modal">
            <div class="modal-content">
              <div class="modal-header">
                <span class="modalClose">×</span>
              </div>
              <div class="modal-body">
                <ul>
                  <li class="mt-4">『# おはよう』 → <p class="title">おはよう</p>
                  </li>
                  <li class="mt-4">『## おはよう』→ <p class="subTitle">おはよう</p>
                  </li>
                  <li class="mt-4">『`おはよう` 』→ <p class="color">おはよう</p>
                  </li>
                  <li class="mt-4">『`````````<br>
                    おはよう<br>
                    `````````』 → <p class="bgc">おはよう</p>
                  </li>
                  <li class="mt-4">『- おはよう 』 → <p class="Bullets">・おはよう</p>
                  </li>
                  <li class="mt-4">『__おはよう__ 』→ <p class="bold">おはよう</p>
                  </li>
                  <li class="mt-4">『~~おはよう~~ 』→ <p class="cancel">おはよう</p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
    </div>
  </div>
</body>

</html>