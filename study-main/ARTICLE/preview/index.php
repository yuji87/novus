<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vue.js-Markdown-Editor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.4.0/marked.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js" defer></script>
    <script src="script.js" defer></script>
</head>
<body>
  <div class="container mt-5" id="app">
    <nav class="navbar">
      <h1 class="title">記事投稿</h1>
    </nav>
    <div class="columns">
      <form method="POST" action="" name="faceForm" class="column is-6" id="input-field-wrapper">
      <h2><i class="fas fa-edit"></i> Input</h2>
        <textarea class="textarea" name="inputfield" id="inputfield" v-model="input"></textarea>
        <span class="mt-5">
          <input type="button" value="# " onClick="addTF(this.value)">タイトル(文頭に配置)<br>
          <input type="button" value="## " onClick="addTF(this.value)">サブタイトル(文頭に配置)<br>
          <input type="button" value="`" onClick="addTF(this.value)">色変換(左記を左右に配置)<br>
          <input type="button" value="```" onClick="addTF(this.value)">色変換(左記を上下に配置)<br>
          <input type="button" value="- " onClick="addTF(this.value)">箇条書き(文頭に配置)<br>
          <input type="button" value="__" onClick="addTF(this.value)">太字(左記を左右に配置)<br>
          <input type="button" value="~~" onClick="addTF(this.value)">取り消し線(左記を左右に配置)<br>
          <input type="submit" class="text-center" value="送信">
        </span>
      </form>

      <div class="column is-6" id="preview-field-wrapper">
        <h2><i class="fas fa-eye"></i> Preview</h2>
        <div id="preview-field" class="content border" v-html="convertMarkdown"></div>
      </div>
    </div>

    <div class="manual offset-xs-2 col-xs-3 offset-lg-5 col-lg-3 mb-5 p-4">
      <h1 class="commandTitle text-center">コマンド一覧<h1>
      <ul>
        <li class="mt-4">『# おはよう』 → <p class="title">おはよう</p></li>
        <li class="mt-4">『## おはよう』→ <p class="subTitle">おはよう</p></li>
        <li class="mt-4">『`おはよう` 』→ <p class="color">おはよう</p></li>
        <li class="mt-4">『`````````<br>
                            おはよう<br>
                          `````````』    → <p class="bgc">おはよう</p></li>
        <li class="mt-4">『- おはよう 』  → <p class="Bullets">・おはよう</p></li>
        <li class="mt-4">『__おはよう__ 』→ <p class="bold">おはよう</p></li>
        <li class="mt-4">『~~おはよう~~ 』→ <p class="cancel">おはよう</p></li>
      </ul>
    </div>
  </div>
</body>
</html>