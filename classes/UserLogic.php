<?php

//ファイル読み込み
require_once 'core/DBconnect.php';

class UserLogic
{
    /**
     * ユーザーを登録する
     * @param array $userData
     * @return bool $result
     */
    public static function createUser($userData)
    {
        $result = false;

        $sql = 'INSERT INTO users (name, tel, email, password, icon) VALUES (?, ?, ?, ?, ?)';
        // ユーザーデータを配列に入れる
        $arr = [];
        $arr[] = $userData['name'];                                      // name
        $arr[] = $userData['tel'];                                       // tel
        $arr[] = $userData['email'];                                     // email
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT); // password
        $arr[] = $userData['icon'];                                      // icon

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
    * ログイン処理
    * @param string $name
    * @param string $tel
    * @param string $password
    * @return bool $result
    */

    public static function login($name, $tel, $password)
    {
    // 結果
    $result = false;
    // ユーザをtelから検索して取得
    $user = self::getUserByTel($tel);
    
    if (!$user){
      $_SESSION['msg'] = '電話番号が一致しません。';
      return $result;
    }

    //　パスワードの照会
    if (password_verify($password, $user['password'])){
      //ログイン成功
      //ハイジャック対策
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }
    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
    }
    

    /**
     * ログイン
     * telからユーザを取得
     * @param string $tel
     * @return array|bool $user|false
    */

    public static function getUserBytel($tel)
    {
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'SELECT * FROM users WHERE tel = ?';

    // telを配列に入れる
    $arr = [];
    $arr[] = $tel;

    try {
      $stmt = connect()->prepare($sql);
      // SQL実行
      $stmt->execute($arr);
      // SQLの結果を返す
      $user = $stmt->fetch();
      return $user;
    } catch(\Exception $e) {
      return false;
    }
  }


  /**
   * ログインチェック
   * @param void
   * @return bool $result
   */

    public static function checkLogin()
    {
    $result = false;
    
    // セッションにログインユーザが入っていなかったらfalse
    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
      return $result = true;
    }
    return $result;
  } 

    /**
    * ログアウト処理
    */
    /*
    public static function logout()
    {
    $_SESSION = array();
    session_destroy();
  } */

}
