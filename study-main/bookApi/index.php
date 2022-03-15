<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>HTML Previewer</title>
  <meta name="description" content="テキストエリアに入力した HTML を即座にプレビュー表示します。HTML entered in the textarea is previewed quickly.">
  <meta name="author" content="Mtk Fujiu.jp">
</head>

<body>
  <textarea id="value" style="width:100%;height:200px;">&lt;span style=&quot;white-space:pre;&quot;&gt;Enter HTML here


&lt;/span&gt;</textarea>
  置換
  <input type="text" id="src">
  to
  <input type="text" id="dst">
  <button type="button" onclick="Replace();">置換する</button>
  <br>
  <button type="button" onclick="SaveAs();">保存する</button>
  <a href="#" download="yourhtml.html" id="saveas" onclick="SaveAs();" style="visibility:hidden;"></a>
  <div id="preview" style="border-style:solid;border-width:1px;"></div>
  <script>
    var preValue = "";
    var valueElement = document.getElementById("value");
    var previewElement = document.getElementById("preview");

    function Update() {
      var value = valueElement.value;
      if (preValue != value) {
        previewElement.innerHTML = value;
        preValue = value;
      }
      setTimeout("Update()", 100);
    }
    Update();

    function Replace() {
      var src = document.getElementById("src").value;
      var dst = document.getElementById("dst").value;
      var value = valueElement.value;
      valueElement.value = value.replace(new RegExp(src, "g"), dst);
    }

    function SaveAs() {
      var value = valueElement.value;
      var saveasElement = document.getElementById("saveas");
      var blob = new Blob([value], {
        "type": "text/plain"
      });
      if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(blob, saveasElement.getAttribute("download"));
      } else {
        saveasElement.href = window.URL.createObjectURL(blob);
        saveasElement.click();
      }
    }
  </script>
</body>

</html>