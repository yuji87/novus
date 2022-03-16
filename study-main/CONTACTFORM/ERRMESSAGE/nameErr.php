

<?php if (isset($errmessage["name"]) && $errmessage["name"] === "blank") : ?>
  <p class="ellMessage">何も入力されていません</p>
<?php endif ?>
<?php if (isset($errmessage["name"]) && $errmessage["name"] === "exceed") : ?>
  <p class="ellMessage">名前は50文字以内にしてください</p>
<?php endif ?>