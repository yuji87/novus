<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>質問投稿完了</title>
</head>
<body>

<?php
// hiwihhihi引用部分
  //   function insert($tableName, $valueAry){
  //     $rowName = implode(',',array_keys($valueAry));
  //     $pps = ':'.implode(',:',array_keys($valueAry));; //prepared-statements

  //     $sql = 'INSERT INTO '.$tableName.'('.$rowName.') VALUES('.$pps.')';
  //     $data = array_combine(explode(',',$pps),array_values($valueAry));
  //     $this->queryPost($sql,$data);
  //     return $this->pdo->lastInsertId();
  // }

$valueAry = array('user_id', 'title', 'message', 'post_date', 'cate_id', 'question_image');
$rowName = implode(',',array_keys($valueAry));
$pps = ':'.implode(',:',array_keys($valueAry));; //prepared-statements

$sql = 'INSERT INTO '.$tableName.'('.$rowName.') VALUES('.$pps.')';
$data = array_combine(explode(',',$pps),array_values($valueAry));
$this->queryPost($sql,$data);
return $this->pdo->lastInsertId();
?>

<div>投稿完了</div>
<br>
<div>あなたの質問は以下の内容で投稿されました</div>
<?php



echo "題名<br>";
echo $_POST['title'];
echo "カテゴリ：".$_POST['category'] ."<br>";
echo "本文<br>";
echo $_POST['message'];

?>
</body>
</html>