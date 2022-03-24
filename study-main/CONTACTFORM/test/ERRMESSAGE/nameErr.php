

<?php if (isset($error["name"]) && $error["name"] === "blank") : ?>
  <p class="ellMessage">何も入力されていません</p>
<?php endif ?>
<?php if (isset($error["name"]) && $error["name"] === "exceed") : ?>
  <p class="ellMessage">名前は50文字以内にしてください</p>
<?php endif ?>