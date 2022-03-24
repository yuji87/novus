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

// 下記オートリサイズ
$(function () {
  $('textarea.auto-resize')
    .on('change keyup keydown paste cut', function () {
      if ($(this).outerHeight() > this.scrollHeight) {
        $(this).height() + 1;
      }
      while ($(this).outerHeight() < this.scrollHeight) {
        $(this).height($(this).height() + 1)
      }
    });
});

// 下記HTML生成ボタン
function clickBtn7() {
  document.getElementById("value").value = " `` ";
}