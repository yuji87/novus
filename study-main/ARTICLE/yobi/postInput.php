<?php require_once("post.php") ?>


<textarea id="value" class="col-8 offset-2 mt-3 auto-resize" style="padding:1vh 0" col="50" rows="15" placeholder="ここに記事を記入してください"></textarea>
<div class="row offset-2 mt-1 mb-3">
  置換
  <input type="text" id="src" value="``">
  to
  <input type="text" id="dst" value="<h1>">
  <button type="button" onclick="Replace();" class="col-1 ml-2">置換する</button>
  <input type="button" value="見出しボタン" onclick="clickBtn7()">
  <input type="submit" class="ml-5" value="送信">
</div>
<div id="preview" class="col-8 offset-2" style="border-style:solid;border-width:1px;"></div>