<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript" src="https://js.pay.jp/v1/"></script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body> 

        <!--エラーがあった時はこちらに表示-->
<div class="missArea cardmiss"></div>
  
  <!--以下、クレジットカード入力フォーム-->
  <dl>
      <dt>カード番号</dt>
      <dd><input type="text" name="card_number" placeholder="カード番号)4242424242424242"></dd>
      <dt>有効期限</dt>
      <dd><input type="number" name="card_exp_month" placeholder="月)12">/<input type="number" name="card_exp_year" placeholder="年)21"></dd>
      <dt>カード確認コード(CVC)</dt>
      <dd><input type="text" name="card_cvc" placeholder="CVC)123"></dd>
      <dt>お名前</dt>
      <dd><input type="text" name="card_name" placeholder="名前)TARO SASAKI"></dd>
  </dl>
  <button class="publishBtn" >登録する</button>
  <div style="padding-top:40px;">
  <div>テスト用カード番号は<a href="https://pay.jp/docs/testcard" target="_blank">こちら</a>から<br>
  カード番号以外の情報は、グレーの文字通りご入力ください。<br>
  実際に決済はされません。</div>
  </div>




<hr>


<script>
  
//公開鍵を設定
Payjp.setPublicKey("pk_test_dcca1acafd2ff2bc22e9e428");
  
//publishBtn(buttonを押した時に以下の処理スタート)
$(".publishBtn").click(function(){
      
    //一旦エラーエリアの内容をリセット(何も無い場合は変化なし)。
    $(".missArea").empty();
      
    //有効期限の年を取得
    //年を4桁すべて入力してもらうと手間がかります。
    //よって、2019の場合、19だけ入力してもらい、20はここで付け足す。
    var cvcdata = "20" + document.querySelector('input[name="card_exp_year"]').value;
      
    //他の項目もすべて取得
    var card = {
        number: document.querySelector('input[name="card_number"]').value,
        cvc: document.querySelector('input[name="card_cvc"]').value,
        exp_month: document.querySelector('input[name="card_exp_month"]').value,
        exp_year: cvcdata,
        name: document.querySelector('input[name="card_name"]').value
    };
      
    //pay.jpに送るため情報を暗号化(トークン化)
    Payjp.createToken(card, function(status, response) {
          
        //statusが200の場合はトークン化に問題無し。決済へ進む
        if (status == 200) {
              
            //トークンを取得
            var card_token = response.id;
              
            //ajaxで決済処理用のphpにトークンを送信
            $.ajax({
                type: 'POST',
                dataType:'json',
                url:'functions/pay.php',
                data:{
                    card_token:card_token,
                },
                success:function(data) {
                    if(data){
                        //決済処理に問題があった場合、エラーを表示。
                        $(".cardmiss").append(""+data+"");
                    }else{
                        //決済処理が成功した場合、決済顔料画面へ。
                        location.href = "success.php";
                    };
                },
                error:function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
              
        } else {
              
            //フォームの時点で入力内容にエラーがあった場合。
            var error_messege = response.error.message;
            $(".cardmiss").append("入力内容にエラーがあるようです。再度、ご確認の上、ご登録をお願い致します。");
              
        };
    });
});
</script>

</body>
</html>