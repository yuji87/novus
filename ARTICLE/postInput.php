<?php require_once("post.php") ?>

<!--ツイート投稿欄-->
<form method="POST" action="">
  <div class="container">
    <div class="row">
      <input type="text" name="" class="offset-0 col-12 mt-4" placeholder="ここに記事のタイトルを入力してください(メインタイトル)">

      <input type="text" name="" class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12 mt-5" placeholder="見出し">
      <textarea class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12" rows="4" name="" maxlength="140" placeholder="内容を入力してください"></textarea>

      <span class="switch none" id="result">
        <input type="text" name="" class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12 mt-1" placeholder="見出し">
        <textarea class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12" rows="4" name=""  maxlength="140" placeholder="内容を入力してください"></textarea>
      </span>

      <span class="switch none" id="result">
        <input type="text" name="" class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12 mt-1" placeholder="見出し">
        <textarea class="offset-sm-4 offset-md-1 offset-lg-0 col-sm-4 col-md-10 col-lg-12" rows="4" name=""  maxlength="140" placeholder="内容を入力してください"></textarea>
      </span>

      <input type="button" id="btn_count_up" class="offset-4 col-3 mt-4 p-3 rounded-circle btn_count_up" value="入力欄を生成するよ" onClick="count();"></input>
      <!-- <input type="button" id="btn_count_up" class="offset-4 col-3 mt-4 p-3 rounded-circle btn_count_up" value="入力欄を生成するよ"></input> -->

    </div>
    <button class="offset-3 col-6 mt-5 rounded">投稿</button>
  </div>
</form>
