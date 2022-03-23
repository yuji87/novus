new Vue ({
  el: '#app',// #appを指定
  data: {
    input: ''// v-model="input"でtextareaと双方向データバインディング
  },
  computed: {
    convertMarkdown: function() {
      // v-html="convertMarkdown"が付与されている要素（エレメント）とバイディング
      // 入力されたデータをHTMLに変換して表示
      return marked(this.input);
    }
  }
})

//ボタン入力
function addTF(str)
{
document.faceForm.inputfield.value += str;
}

//モーダルウインドウ
const buttonOpen = document.getElementById('modalOpen');
const modal = document.getElementById('easyModal');
const buttonClose = document.getElementsByClassName('modalClose')[0];
//ボタンがクリックされた時
buttonOpen.addEventListener('click', modalOpen);
function modalOpen() {
  modal.style.display = 'block';
};

//バツ印がクリックされた時
buttonClose.addEventListener('click', modalClose);
function modalClose() {
  modal.style.display = 'none';
};

//モーダルコンテンツ以外がクリックされた時
addEventListener('click', outsideClose);
function outsideClose(e) {
  if (e.target == modal) {
    modal.style.display = 'none';
  };
};

// ■ ==================== input type=fileのimg表示 ============================ ■
//JavaScript の File API でidからファイルの内容を読み込む
//JavaScriptのFileReaderオブジェクトで画像を読む→データURLを取得しimgでプレビュー
function previewImage(obj)
{
	var fileReader = new FileReader();
  fileReader.onload = (function () { // FileReaderをロード
    document.getElementById('preview').src = fileReader.result; //選択された画像ファイルをreadAsDataURLで読み込み
	});
  fileReader.readAsDataURL(obj.files[0]); //読み込みが完了したらimgタグのsrcにセット
}