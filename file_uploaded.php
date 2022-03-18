<?php

$err = [];
// ファイル関連の取得
$file = $_FILES['icon'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'XAMPP/htdocs/qandasite/img';

// ファイルのバリデーション
// ファイルサイズが1MB未満か
if ($filesize > 1048576 || $file_err == 2) {
    $err[] = 'ファイルサイズは1MB未満にしてください';
}
// 拡張は画像形式か
$allow_ext = array ('jpg', 'jpeg', 'png');
$file_ext = pathinfo ($filename, PATHINFO_EXTENSION);
if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err[] = '画像ファイルを添付してください';
    echo '<br>';
}
// ファイルはあるのかどうか
if (is_uploaded_file($tmp_path)) {
    echo  $filename. 'をアップしました';
} else {
    $err[] = 'ファイルが選択されていません';
    echo '<br>';
}
?>

<a href="signup/entry_form.php">戻る</a>