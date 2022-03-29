function postJump(files){
    //ファイルをupload.phpに送信
    var formdata = new FormData();
    $.each(files, function(i, file){
          formdata.append('upfile' + i, file);
      });
    // 送信
    $.ajax({
      type: 'POST',
      url : '../1.php',
      data: formdata,
      processData: false, // jQueryがデータを処理しないように設定
      contentType: false, // jQueryがcontentTypeを設定しないように設定
    }).done(function(responseData, status, jqXHR)
    {
        console.log(responseData);
    }).fail(function(responseError, status, errorThrown)
    {
        console.log(responseError);
    });
  }
   
  (function() {
      var elDrop = document.getElementById('dropzone');
      var elFiles = document.getElementById('files');
   
      elDrop.addEventListener('dragover', function(event) {
              event.preventDefault();
              event.dataTransfer.dropEffect = 'copy';
      });
   
      elDrop.addEventListener('drop', function(event) {
              //ドロップ時にファイルをアップロード
              event.preventDefault();
              var files = event.dataTransfer.files;
              showFiles(files);
              postJump(files);
      });
   
      document.addEventListener('click', function(event) {
          var elTarget = event.target;
          if (elTarget.tagName === 'IMG') {
              var src = elTarget.src;
            //クリックしたら別ウィンドウで画像を開く
              var w = window.open('about:blank');
              var d = w.document;
              d.open();
              d.write('<img src="' + src + '" />');
              d.close();
          }
      });
   
      function showFiles(files) {
      //アップロードされたファイルの情報を表示
          for (var i=0, l=files.length; i<l; i++) {
                  var file = files[i];
                  var elFile = buildElFile(file);
                  elFiles.appendChild(elFile);
          }
      }
   
      function buildElFile(file) {
              var elFile = document.createElement('li');
              var text = file.name + ' (' + file.type + ',' + file.size + 'bytes)';
              elFile.appendChild(document.createTextNode(text));
              if (file.type.indexOf('image/') === 0) {
                  var elImage = document.createElement('img');
                  elImage.src = "";
                  elFile.appendChild(elImage);
                  attachImage(file, elImage);
              }
              return elFile;
      }
   
      function attachImage(file, elImage) {
          var reader = new FileReader();
          reader.onload = function(event) {
              var src = event.target.result;
              elImage.src = src;
              elImage.setAttribute('title', file.name);
          };
          reader.readAsDataURL(file);
      }
  })();