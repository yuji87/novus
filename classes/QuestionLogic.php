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

      $sql = 'SELECT question_id, title, message, post_date, upd_date, name, icon, category_name FROM question_posts
              INNER JOIN users ON users.user_id = question_posts.user_id
              INNER JOIN categories ON categories.cate_id = question_posts.cate_id
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

      $where = [];
      // categoryが選択されている場合、検索条件に追加する
      if(!empty($questionData['category'])){
        $where[] = "question_posts.cate_id = ".$questionData['category'];
      }
      // keywordが入力されている場合、検索条件に追加する
      if(!empty($questionData['keyword'])){
        $where[] = "(title LIKE '%{$questionData['keyword']}%'
                    OR message LIKE '%{$questionData['keyword']}%'
                    OR category_name LIKE '%{$questionData['keyword']}%')";
      }
      if($where){
        $whereSql = implode(' AND ', $where);
        $sql = 'SELECT DISTINCT question_id, title, message, post_date, upd_date, name, icon, category_name FROM question_posts
                INNER JOIN users ON users.user_id = question_posts.user_id
                INNER JOIN categories ON question_posts.cate_id = categories.cate_id
                WHERE ' . $whereSql ;
      }else{
        $sql = 'SELECT DISTINCT question_id, title, message, post_date, upd_date, name, icon, category_name FROM question_posts
                INNER JOIN users ON users.user_id = question_posts.user_id
                INNER JOIN categories ON question_posts.cate_id = categories.cate_id
                ORDER BY question_posts.question_id DESC';
      }

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
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

      $sql = 'INSERT INTO question_posts (user_id, title, message, cate_id, question_image) VALUES (?, ?, ?, ?, ?)';
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

    // 本メソッドの論理構成
    // 質問に返答、返答にいいねがあると、外部キー制約で消去不可能
    // １：質問に対して返答の有無を検索（無い場合、５へ）
    // ２：返答に対していいねの有無を検索（無い場合、４へ）
    // ３：いいねを消去
    // ４：返答を消去
    // ５：質問を消去

    public static function deleteQuestion($questionData)
    {
      $result = false;
      // 削除前に、質問に対して返答がついているかを検索
      $sql_search_ans = 'SELECT users.user_id, name, icon, message, answer_id, answer_date, upd_date
                        FROM question_answers
                        INNER JOIN users ON users.user_id = question_answers.user_id 
                        WHERE question_answers.question_id = ?';
      // question_idを配列に入れる
      $arr = [];
      $arr[] = $questionData;                                  // question_id
      
      try {
        $stmt = connect()->prepare($sql_search_ans);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $search_ans = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch(\Exception $e) {
        return false;
      }
      
      // 返答がついている場合
      if(!empty($search_ans)){
        $result = false;
        // それぞれの返答に対していいねがついているかを検索
        $sql_search_like = 'SELECT q_like_id
                            FROM question_likes
                            WHERE answer_id = ?';

        // 返答ごとに検索を行うため、foreachを使用
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
            $result = false;
            // それぞれの返答に対するいいねを削除
            $sql_dlt_like = 'DELETE FROM question_likes WHERE answer_id = ?';
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

        // 質問に紐づく返答を消去
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

      // 質問を消去
      $sql_dlt = 'DELETE FROM question_posts WHERE question_id = ?';
      
      try {
        $stmt = connect()->prepare($sql_dlt);
        $arr = [];
        $arr[] = $questionData['question_id']; 
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
     * 返答を個別表示する
     * @param array $answerData
     * @return bool $result
     */
    public static function displayOneAnswer($answerData)
    {
      $result = false;

      $sql = 'SELECT * FROM question_answers
              WHERE question_answers.answer_id = ?';

      // question_idを配列に入れる
      $arr = [];
      $arr[] = $answerData;                                     // question_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetch();
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
     * 返答を一覧表示する
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

    public static function createAnswer()
    {
      $result = false;

      $sql = 'INSERT INTO question_answers (message, user_id, question_id)VALUES (?, ?, ?)';
      // 返答データを配列に入れる
      $arr = [];
      $arr[] = $_SESSION['a_data']['message'];                                     // message
      $arr[] = 999;                                     // user_id(仮置き)
      // $arr[] = $_SESSION['a_data']['user_id'];                                     // user_id
      $arr[] = $_SESSION['a_data']['question_id'];                                 // question_id

      try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        $data = $stmt->fetch();


        $_SESSION['a_data']['message'] = null;
        $_SESSION['a_data']['user_id'] = null;
        // $_SESSION['a_data']['question_id'] = null;

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


    public static function editAnswer()
    {
      $result = false;

      $upd_date = date("Y/m/d H:i:s");
      // SQLの準備
      // SQLの実行
      // SQLの結果を返す
      $sql = 'UPDATE question_answers SET message=?,upd_date=? WHERE answer_id = ?';
      
      // 編集データを配列に入れる
      $arr = [];
      $arr[] = $_SESSION['a_data']['message'];                              // message
      $arr[] = $upd_date;                                                   // upd_time
      $arr[] = $_SESSION['a_data']['answer_id'];                            // answer_id

      try {
        $stmt = connect()->prepare($sql);
        // SQL実行
        $stmt->execute($arr);
        // SQLの結果を返す
        $answer = $stmt->fetch();


        $_SESSION['a_data']['message'] = null;
        // $_SESSION['a_data']['answer_id'] = null;

        return $answer;
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

      $result = false;

      // 返答に対していいねがついているかを検索
      $sql_search_like = 'SELECT q_like_id
                          FROM question_likes
                          WHERE answer_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $answerData;  

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
        $result = false;
        // それぞれの返答に対するいいねを削除
        $sql_dlt_like = 'DELETE FROM question_likes WHERE answer_id = ?';
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

      // 返答の消去
      $sql = 'DELETE FROM question_answers WHERE answer_id = ?';

      // answer_idを配列に入れる
      $arr = [];
      $arr[] = $answerData;                                  // answer_id

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