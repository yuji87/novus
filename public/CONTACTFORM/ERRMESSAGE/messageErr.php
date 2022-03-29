

<?php if (isset($error["message"]) && $error["message"] === "blank") : ?>
  <p class="ellMessage">何も入力されていません</p>
<?php endif ?>
<?php if (isset($error["message"]) && $error["message"] === "exceed") : ?>
  <p class="ellMessage">お問い合わせ内容は1000文字以内にしてください</p>
<?php endif ?>