<?php

//ファイル読み込み
require_once '../core/DBconnect.php';

class QuestionLogic
{
    /**
     * 特定ユーザーの質問を表示する
     * @param int $user_id
     * @return bool $result
     */
    public static function userQuestion()
    {
      $result = false;
      $arr = [];
      $arr[] = $_SESSION['login_user']['user_id'];                                     // user_id

      $sql = 'SELECT question_id, title, message, post_date, upd_date, name, icon FROM question_posts
              INNER JOIN users ON users.user_id = question_posts.user_id 
              WHERE users.user_id = ?
              ORDER BY question_posts.question_id DESC';

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        // return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 最新の質問を10件表示する
     * @return bool $result
     */
    public static function newQuestion()
    {
      $result = false;

      $sql = 'SELECT question_id, title, message, post_date, upd_date, name, icon FROM question_posts
              INNER JOIN users ON users.user_id = question_posts.user_id 
              ORDER BY question_posts.question_id DESC LIMIT 10';

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        // return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 質問を検索する
     * @param array $questionData
     * @return bool $result
     */
    public static function searchQuestion($questionData)
    {
      $result = false;

      $sql = 'SELECT DISTINCT question_id, title, message, post_date, upd_date, name, icon, category_name FROM question_posts
              INNER JOIN users ON users.user_id = question_posts.user_id
              INNER JOIN categories ON question_posts.cate_id = categories.cate_id
              WHERE title LIKE ?
              OR message LIKE ?
              OR category LIKE ?
              ORDER BY question_posts.question_id DESC';

      // keywordを配列に入れる
      $keyword = filter_input(INPUT_POST, 'keyword');
      $keyword = '%'.$keyword.'%';
      $arr = [];
      $arr[] = $keyword;                                     // keyword
      $arr[] = $keyword;                                     // keyword
      $arr[] = $keyword;                                     // keyword

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 質問の詳細を表示する
     * @param array $questionData
     * @return bool $result
     */
    public static function displayQuestion($questionData)
    {
      $result = false;

      $sql = 'SELECT question_id, title, message, post_date, upd_date, users.user_id, name, icon, categories.cate_id, category_name
              FROM question_posts
              INNER JOIN users ON users.user_id = question_posts.user_id
              INNER JOIN categories ON question_posts.cate_id = categories.cate_id
              WHERE question_id = ?';

      // question_idを配列に入れる
      $arr = [];
      $arr[] = $questionData['question_id'];                                     // question_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
        // return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 質問を登録する
     * @param array $questionData
     * @return bool $result
     */
    public static function createQuestion()
    {
      $result = false;

      // imageがないときに上手く動かなかったため、避難中
      $sql = 'INSERT INTO question_posts (user_id, title, message, cate_id, question_image) VALUES (?, ?, ?, ?, ?)';
      // $sql = 'INSERT INTO question_posts (user_id, title, message, cate_id) VALUES (?, ?, ?, ?)';
      // 質問データを配列に入れる
      $arr = [];
      $arr[] = $_SESSION['q_data']['user_id'];                                     // user_id
      $arr[] = $_SESSION['q_data']['title'];                                       // title
      $arr[] = $_SESSION['q_data']['message'];                                     // message
      $arr[] = $_SESSION['q_data']['category'];                                    // category
      $arr[] = $_SESSION['q_data']['question_image'];                              // question_image

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $question = $stmt->fetch();

        $_SESSION['q_data']['user_id'] = null;
        $_SESSION['q_data']['title'] = null;
        $_SESSION['q_data']['message'] = null;
        $_SESSION['q_data']['category'] = null;
        $_SESSION['q_data']['questin_image'] = null;

        return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 質問の編集
     * @param string $title
     * @param string $message
     * @param datetime $upd_time
     * @param int $cate_id
     * @param string $question_image
     * @param int $question_id
     * @return bool $result
    */

    public static function editQuestion()
    {
      $result = false;

      $upd_date = date("Y/m/d H:i:s");

      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'UPDATE question_posts SET title=?,message=?,upd_date=?,cate_id=?,question_image=? WHERE question_id = ?';

      // 編集データを配列に入れる
      $arr = [];
      $arr[] = $_SESSION['q_data']['title'];                                  // title
      $arr[] = $_SESSION['q_data']['message'];                                // message
      $arr[] = $upd_date;                                                     // upd_date
      $arr[] = $_SESSION['q_data']['category'];                               // cate_id
      $arr[] = $_SESSION['q_data']['question_image'];                         // question_image
      $arr[] = $_SESSION['q_data']['question_id'];                            // question_id
      
      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $question = $stmt->fetch();

        //SQL実行後、question_id以外の$_SESSIONの内容を消去
        $_SESSION['q_data']['title'] = null;
        $_SESSION['q_data']['message'] = null;
        $_SESSION['q_data']['category'] = null;
        $_SESSION['q_data']['questin_image'] = null;

        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }


    /**
     * 質問の削除
     * @param int $question_id
     * @return bool $result
    */

    public static function deleteQuestion($questionData)
    {
      // 質問に対して返答がついているかを検索
      $sql_search_ans = 'SELECT users.user_id, name, icon, message, answer_id, answer_date, upd_date
                        FROM question_answers
                        INNER JOIN users ON users.user_id = question_answers.user_id 
                        WHERE question_answers.question_id = ? ORDER BY question_answers.answer_id DESC';

      // question_idを配列に入れる
      $arr = [];
      $arr[] = $questionData['question_id'];                                  // question_id
      
      try {
        $stmt = connect()->prepare($sql_search_ans);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $search_ans = $stmt->fetch();
      } catch(\Exception $e) {
        return false;
      }

      // 返答がついている場合
      if(!empty($search_ans)){
        // それぞれの返答に対していいねがついているかを検索
        $sql_search_like = 'SELECT q_like_id
                            FROM question_likes
                            WHERE answer_id = ?';

        foreach($search_ans as $value){
          // answer_idを配列に入れる
          $arr = [];
          $arr[] = $value['answer_id'];                                     // answer_id
          
          try{
            $stmt = connect()->prepare($sql_search_like);
            // SQL実行
            $result = $stmt-> execute($arr);
            $search_like = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }catch(\Exception $e){
            // エラーの出力
            echo $e;
            // ログの出力
            error_log($e, 3, '../error.log');
            return $result;
          }
          // いいねがついている場合
          if(!empty($search_like)){
            // それぞれの返答に対するいいねを削除
            $sql_dlt_like = 'DELETE question_likes WHERE answer_id = ?';
            try{
              $stmt = connect()->prepare($sql_dlt_like);
              // SQL実行
              $result = $stmt-> execute($arr);
            }catch(\Exception $e){
              // エラーの出力
              echo $e;
              // ログの出力
              error_log($e, 3, '../error.log');
              return $result;
            }
          }
        }

        $sql_dlt_ans = 'DELETE FROM question_answers WHERE question_id = ?';
        // question_idを配列に入れる
        $arr = [];
        $arr[] = $questionData['question_id'];                                  // question_id

        try {
          $stmt = connect()->prepare($sql_dlt_ans);
          // SQL実行
          $stmt->execute($arr);
        } catch(\Exception $e) {
          return false;
        }
      }

      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql_dlt = 'DELETE users WHERE question_id = ?';

      try {
        $stmt = connect()->prepare($sql_dlt);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $question = $stmt->fetch();
        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }





    /**
     * 返答を表示する
     * @param array $answerData
     * @return bool $result
     */
    public static function displayAnswer($answerData)
    {
      $result = false;

      $sql = 'SELECT users.user_id, name, icon, message, answer_id, answer_date, upd_date
              FROM question_answers
              INNER JOIN users ON users.user_id = question_answers.user_id 
              WHERE question_answers.question_id = ? ORDER BY question_answers.answer_id DESC';

      // question_idを配列に入れる
      $arr = [];
      $arr[] = $answerData['question_id'];                                     // question_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        // return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 返答を登録する
     * @param array $answerData
     * @return bool $result
     */
    public static function createAnswer($answerData)
    {
      $result = false;

      $sql = 'INSERT INTO question_posts (message, user_id, question_id)VALUES (?, ?, ?)';
      // 返答データを配列に入れる
      $arr = [];
      $arr[] = $answerData['message'];                                     // message
      $arr[] = $answerData['user_id'];                                     // user_id
      $arr[] = $answerData['question_id'];                                 // question_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetch();
        return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 返答の編集
     * @param string $message
     * @param datetime $upd_time
     * @param int $answer_id
     * @return bool $result
    */

    public static function editAnswer($answerData)
    {
      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'UPDATE users SET message=?,upd_time=? WHERE answer_id = ?';

      // 編集データを配列に入れる
      $arr = [];
      $arr[] = $answerData['message'];                                      // message
      $arr[] = $answerData['upd_time'];                                     // upd_time
      $arr[] = $answerData['answer_id'];                                    // answer_id

      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $answer = $stmt->fetch();
        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }

    /**
     * 質問に紐づく返答の一斉削除
     * @param int $question_id
     * @return bool $result
    */

    public static function deleteManyAnswer($answerData)
    {
      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'DELETE FROM question_answers WHERE question_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $answerData['question_id'];                                  // question_id

      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }

    /**
     * 返答の個別削除
     * @param int $answer_id
     * @return bool $result
    */

    public static function deleteOneAnswer($answerData)
    {
      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'DELETE FROM question_answers WHERE answer_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $answerData['answer_id'];                                  // answer_id

      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }



    /**
     * 返答に紐づくいいね数を表示する
     * @param array $answerData
     * @return bool $result
     */
    public static function displayLike($likeData)
    {
      $result = false;

      $sql = 'SELECT q_like_id
              FROM question_likes
              WHERE answer_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $likeData;                                     // answer_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        // return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * いいねを登録する
     * @param array $likeData
     * @return bool $result
     */
    public static function createLike($likeData)
    {
      $result = false;

      $sql = 'INSERT INTO question_likes (user_id, answer_id)VALUES (?, ?)';
      // id情報を配列に入れる
      $arr = [];
      $arr[] = $likeData['user_id'];                                     // user_id
      $arr[] = $likeData['answer_id'];                                   // answer_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetch();
        return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * いいねのON/OFFをする
     * @param array $likeData
     * @return bool $result
     */
    public static function sqitchLike($likeData)
    {
      $result = false;

      $sql = 'UPDATE question_likes SET like_flg=? WHERE like_id = ?';
      // フラグの値(0,1)をデータを配列に入れる
      $arr = [];
      $arr[] = $likeData['like_flg'];                                  // like_flg
      $arr[] = $likeData['like_id'];                                   // like_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        return $result;
      }catch(\Exception $e){
        // エラーの出力
        echo $e;
        // ログの出力
        error_log($e, 3, '../error.log');
        return $result;
      }
    }

    /**
     * 返答に紐づくいいねの削除
     * @param int $like_id
     * @return bool $result
    */

    public static function deleteLike($likeData)
    {
      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'DELETE question_likes WHERE answer_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $likeData['answer_id'];                                  // answer_id

      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        return $result;
      } catch(\Exception $e) {
        return false;
      }
    }
}