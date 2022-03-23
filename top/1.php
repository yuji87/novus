<?php
//参考 http://wataame.sumomo.ne.jp/archives/3879
header("Content-Type: text/html; charset=UTF-8");
define('FILE_PATH','./img/'); //保存するパスを指定
 
if ( !empty($_FILES) ) {
  for ( $i=0; $i<count($_FILES); $i++ ) {
        echo $_FILES;
        $upfile_i = 'upfile' . $i; //i個目のファイル
        if ( is_uploaded_file($_FILES[$upfile_i]['tmp_name']) ) {
            $name = $_FILES[$upfile_i]['name'];
            $tempFile = $_FILES[$upfile_i]['tmp_name'];
            print_r($_FILES[$upfile_i]);
 
            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png');   // File extensions
            $fileParts = pathinfo($_FILES[$upfile_i]['name']);
 
            // ファイル名がアルファベットのみかをチェック
            if ( preg_match("/^([a-zA-Z0-9\.\-\_])+$/ui", $name) == "0" ) {
                // アルファベット以外を含む場合はファイル名を日時とする
                $saveFileName = date("Ymd_His", time());
            }
            else {
              echo "ファイル: $name\n";
              if ( preg_match("/\.jpg$/ui", $name) == true ) {
                  $ret = explode('.jpg', $name);
              }
                elseif ( preg_match("/\.gif$/ui", $name) == true ) {
                  $ret = explode('.gif', $name);
              }
                elseif ( preg_match("/\.png$/ui", $name) == true ) {
                  $ret = explode('.png', $name);
              }
              $saveFileName = $ret[0]; // 拡張子を除いたそのまま
            }
 
            // マイクロ秒をファイル名に付加
            $saveFileName = FILE_PATH . '[' . (microtime()*1000000) . ']' . $saveFileName;
            if ( in_array($fileParts['extension'], $fileTypes) )
            {
                if ( move_uploaded_file($_FILES[$upfile_i]["tmp_name"],
                    $saveFileName . '.' . $fileParts['extension']) )
                {
                    //chmod($saveFileName . '.' . $fileParts['extension'], 0777);
                    echo $_FILES[$upfile_i]["name"] . "をアップロードしました。\n";
                }
                else {
                    echo "アップロードエラー";
                }
            }
            else {
              echo "アップロードの対象は画像ファイル（.jpg/.gif/.png）のみです。<br>\n";
              $filename = $_FILES[$upfile_i]['name'];
              echo "ファイル: $filename";
            }
        }
        else {
            echo "アップロードエラー: ファイルがアップロードされていません。\n";
        }
    }
}
else {
  echo "アップロードエラー: FILESが空です。";
}
?>