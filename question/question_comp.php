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
// hiwihi引用部分1

require_once(dirname(__FILE__)."/../DBConnector.php");
class QuestionTable
{
    public static function create($userID,$title,$message,$category,$questionImage) :int
    {
        $dataAry = [
          'user_id' => $userID,
          'title' => $title,
          'message' => $message,
          'post_date' => date('Y-m-d H:i:s'),
          'upd_date' => date('Y-m-d H:i:s')
          'cate_id' => $category,
          'question_image' => $questionImage
        ];
        $pdow = DBConnector::getPdow();
        $id = $pdow->insert('question_posts',$dataAry);
        return $id;
    }

// hiwihi引用部分2
    function insert($tableName, $valueAry){
$valueAry = array('user_id', 'title', 'message', 'post_date', 'cate_id', 'question_image');
$rowName = implode(',',array_keys($valueAry));
$pps = ':'.implode(',:',array_keys($valueAry));; //prepared-statements

$sql = 'INSERT INTO '.$tableName.'('.$rowName.') VALUES('.$pps.')';
  //ここで変数の定義をしている？ 
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