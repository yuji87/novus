
<?php if (isset($error["email"]) && $error["email"] === "blank") : ?>
  <p class="ellMessage">何も入力されていません</p>
<?php endif ?>
<?php if (isset($error["email"]) && $error["email"] === "exceed") : ?>
  <p class="ellMessage">お問い合わせ内容は1000文字以内にしてください</p>
<?php endif ?>
<?php if (isset($error["email"]) && $error["email"] === "Illegal") : ?>
  <p class="ellMessage">メールアドレスが不正です</p>
<?php endif ?>