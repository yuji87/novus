/**
* メッセージアクション
* @param now element
* @return Promise
**/
var actionMsgBox = function (now) {
  return new Promise(async (resolve, reject) => {
    // 最終メッセージかどうか確認
    if ((now.length === 0) || now.hasClass('last-message')) {
      await doLastMsg();
    } else {
      // メッセージにアクションがセットされていれば実行
      switch (now.data('action')) {
        // ==============================================
        // HPバーの処理 =================================
        //
        case 'hpbar':
          await doAnimateHpBar(
            now.data('target'),
            now.data('param')
          );
          break;
        // ==============================================
        // 経験値バーの処理 =============================
        //
        case 'expbar':
          await doAnimateExpBar(
            now.data('param')
          );
          break;

          --省略

          // ==============================================
          // 経験値バーの処理 =============================
          //
          /**
          * 経験値バーのアニメーションを実行
          * @param mixed param
          * @return Promise
          **/
          var doAnimateExpBar = function (param) {
            return new Promise((resolve, reject) => {
              var expbar = $("#expbar");
              // EXPの現在の値を変更
              expbar.attr('aria-valuenow', param);
              // 経験値バーの長さを100%にする
              expbar.animate({
                width: param + "%"
              }, {
                duration: 500,
                easing: 'easeOutQuad',
                complete: function () {
                  // 処理完了(css変更のズレがあるため0.5秒後にresolveを返却)
                  setTimeout(function () {
                    resolve();
                  }, 500);
                }
              });
            });
          }