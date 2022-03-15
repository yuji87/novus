<?php
require_once(dirname(__FILE__)."CLASS/config.php");

class postTable
{
  public static function create($articleID, $userID, $title, $text, $cate_id, $article_image)
  {
    $dataAry = [
      'article_id' => $articleID,
      'user_id' => $userID,
      'title' => $title,
      'text' => $text,
      'post_date' => date('Y-m-d H:i:s'),
      'edit_date' => date('Y-m-d H:i:s'),
      'cate_id' => $cate_id,
      'article_image' => $article_image
    ];
    if(isset($replyto)){
        $dataAry['reply_to'] = $replyto;
    }

      $pdow = DBConnector::getPdow();
      $id = $pdow->insert('tweet',$dataAry);
      return $id;
  }

  public static function update($text,$id)
  {
    $ary = [
        'text' => $text,
        'edit_time' => date('Y-m-d H:i:s')
    ];
    $pdow = DBConnector::getPdow();
    $pdow->update('tweet',$ary,$id);
  }

    public static function delete($id)
    {
        $ary = [
            'delete_flag' => 1
        ];
        $pdow = DBConnector::getPdow();
        $pdow->update('tweet',$ary,$id);
    }

    //TODO: UserTableとほぼ重複してるので解消したい
    //
    public static function getTweet($id,$cols='*')
    {
        $sql = 'SELECT '.$cols.' FROM tweet WHERE id=:id AND delete_flag = 0';
        $data = ['id' => $id];
        $pdow = DBConnector::getPdow();
        $stmt = $pdow->queryPost($sql,$data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

}