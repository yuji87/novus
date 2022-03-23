// qanda向けjavascript関数

// domain prefix
var $domainurl = '/qanda/';

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

// 簡易ダイアログ (swalライブラリ使用)
function onShow($text) {
	swal($text);
}

// ラジオボタンの選択値取得
function getRadio($prefix, $init) {
	var $value = $init;
	var radiolist =  document.getElementsByName($prefix);
	for (var i = 0; i < radiolist.length; i++) {
		if (radiolist[i].checked) {
			$value = radiolist[i].value;
			break;
		}
	}
	return $value;
}

// カンマ区切り文字列作成
function commaSeparatedText(num) {
	if (num == null || isNaN(num) || ! isNumber(num)) {
		return num;
	}
	num = new String(num).replace(/,/g, "");

	while(num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
	return num;
}

// valueは数値?
function isNumber(value) {
	return /^-{0,1}\d+$/.test(value);
}

// valueはパスワードの文字として使用可能?
function isPassword(value) {
	return /^[a-zA-Z0-9.?/-]{5,12}$/.test(value);
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

// valueは、E-MAILの文字列として適切か
function isEmailStr(value) {
	var reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
	return reg.test(value);
}

// 空文字チェック
function isEmpty(value) {
	if (! value || value == '') {
		return true;
	}
	return false;
}

// 文字のトリミング
function trimData(value) {
	return value.trim();
}

// カンマ除去
function removeComma(value) {
	return value.replace(/,/g, '');
}
