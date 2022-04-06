

var $domainurl = '/novus/public/';


// $urlへリダイレクト
function jumpapi($url) {
	location.href = $domainurl + $url;
}

// ajaxで post送信
function formapiCallback($url, $data, $callback) {
console.log('url=' + $url);
console.log($data);
	$.ajax({
		type: 'POST',
		url: $domainurl + $url,
		data: $data,
		success: function(strtext) {
console.log(strtext);
			$callback(strtext);
		}
	});
}

// swalライブラリ
function onShow($text) {
	swal($text);
}

// 文字長さチェック
function isStrLen(value, minval, maxval) {
	var $len = value.length;
	if ($len < minval) {
		return false;
	}
	if ($len > maxval) {
		return false;
	}
	return true;
}

const textareaInt = document.getElementById('textarea');
var submitInt = document.getElementById('submit');
var errorMessage = document.getElementById('error');

textareaInt.addEventListener('input', (e) => {
  if (e.target.value.length > 140) {
    submitInt.disabled = true;
    // errorMessage.classList.remove('errorOver');
    submitInt.style.opacity = '0.1';
  };
  if (e.target.value.length <= 140) {
    submitInt.disabled = false;
    errorMessage.classList.add('errorOver');
    submitInt.style.opacity = '0.5';
  };
});

  //指定された最大文字数を満たしているかを検証する関数（満たしていない場合は true を返す）
  var isTooLong = function ($elem) {
    //対象のクラス名
    var className = "maxlength";
    //data-maxlength 属性から最大文字数を取得
    var maxlength = Number($elem.data(className));
    //エラーを表示する span 要素がすでに存在すれば取得（存在しなければ null が返る）
    var $errorSpan = $elem
      .parent()
      .find("." + errorClassName + "." + className);

    var val = $elem.val().trim();
    if (val !== "") {
      //サロゲートペアを考慮した文字数を取得
      var valueLength = getValueLength($elem.val());
      //値がdata-maxlengthで指定された最大文字数より大きい場合はエラーを表示してtrueを返す
      if (valueLength > maxlength) {
        if ($errorSpan.length === 0) {
          addError($elem, className, maxlength + "文字以内で入力ください");
        }
        return true;
      } else {
        if ($errorSpan.length !== 0) {
          $errorSpan.remove();
        }
        return false;
      }
    } else if (val === "" && $errorSpan.length !== 0) {
      $errorSpan.remove();
    }
  };



// 空文字チェック
function isEmpty(value) {
	if (! value || value == '') {
		return true;
	}
	return false;
}

// javascriptでhtmlspecialchars
function htmlspecialstrars(str) { 
	str = str.replace(/&/g,"&amp;") ;
	str = str.replace(/"/g,"&quot;") ;
	str = str.replace(/'/g,"&#039;") ;
	str = str.replace(/</g,"&lt;") ;
	str = str.replace(/>/g,"&gt;") ;
	return str ;
}
// javascriptで特殊タグ除去(一部タグとして許容する)
function trimHtmlTag($str) {
	// 全体タグを無効化
	$str = $str.replace(/</g,"&lt;") ;
	$str = $str.replace(/>/g,"&gt;") ;

	// 許容するタグを戻す
	$str = $str.replace(/&lt;h1&gt;/g, '<h1>');
	$str = $str.replace(/&lt;\/h1&gt;/g, '</h1>');
	$str = $str.replace(/&lt;h2&gt;/g, '<h2>');
	$str = $str.replace(/&lt;\/h2&gt;/g, '</h2>');
	$str = $str.replace(/&lt;h3&gt;/g, '<h3>');
	$str = $str.replace(/&lt;\/h3&gt;/g, '</h3>');
	$str = $str.replace(/&lt;h4&gt;/g, '<h4>');
	$str = $str.replace(/&lt;\/h4&gt;/g, '</h4>');
	$str = $str.replace(/&lt;h5&gt;/g, '<h5>');
	$str = $str.replace(/&lt;\/h5&gt;/g, '</h5>');
	$str = $str.replace(/&lt;b&gt;/g, '<b>');
	$str = $str.replace(/&lt;\/b&gt;/g, '</b>');
	$str = $str.replace(/&lt;p&gt;/g, '<p>');
	$str = $str.replace(/&lt;\/p&gt;/g, '</p>');
	$str = $str.replace(/&lt;u&gt;/g, '<u>');
	$str = $str.replace(/&lt;\/u&gt;/g, '</u>');
	$str = $str.replace(/&lt;br&gt;/g, '<br>');
	$str = $str.replace(/&lt;br\/&gt;/g, '<br/>');
	$str = $str.replace(/&lt;ul&gt;/g, '<ul>');
	$str = $str.replace(/&lt;\/ul&gt;/g, '</ul>');
	$str = $str.replace(/&lt;ul&gt;/g, '<li>');
	$str = $str.replace(/&lt;\/ul&gt;/g, '</li>');
	$str = $str.replace(/&lt;img(.*)&gt;/g, '<img$1>');
	return $str;
}
