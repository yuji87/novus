<?php

//ファイル読み込み
require_once '../core/DBconnect.php';

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
    } catch(\Exception $e) {
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
    if (password_verify($password, $user['password'])) {
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
     * iconのアップロード処理
     */
    
    public static function file_upload()
    {
    
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
    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['user_id'] > 0) {
      return $result = true;
    }
    return $result;
    } 

    /**
    * ログアウト処理
    */
    public static function logout()
    {
    $_SESSION = array();
    session_destroy();
    } 

    
    /**
     * ユーザー情報編集
     * @param string $name
     * @param string $tel
     * @param string $email
     * @param string $password
     * @param string $icon
     * @param string $tw-user
     * @param string $comment
     * @return bool $result
     */
    
    public static function editUser($userData)
    {
    $result = false;
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'UPDATE users SET name=?, tel=?, email=?, password=?, icon=?) WHERE user_id=?';
    // ユーザーデータを配列に入れる
    $arr = [];
    $arr[] = $name;                                      // name
    $arr[] = $tel;                                       // tel
    $arr[] = $email;                                     // email
    $arr[] = password_hash($password, PASSWORD_DEFAULT); // password
    $arr[] = $icon;                                      // icon
    $arr[] = $userData['comment'];                       //comment
    try{
        $stmt = connect()->prepare($sql);
        // SQL実行
        $result = $stmt-> execute($arr);
        return $result;
    } catch(\Exception $e) {
        // エラーの出力
        echo $e;
    }
    }
}

public static function plusEXP($user_id, $plus_exp)
    {
    $result = false;
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql_sel = 'SELECT level, exp FROM users WHERE user_id=?';
    // ユーザーIDを配列に入れる
    $arr = [];
    $arr[] = $user_id;                       //user_id
    try{
        $stmt = connect()->prepare($sql_sel);
        // SQL実行
        $data = $stmt-> execute($arr);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(\Exception $e) {
        // エラーの出力
        echo $e;
    }

    // SELECT文で取得した経験値とレベルを定義
    $exp = $data['exp'];
    $level = $data['level'];

    // 経験値を付与
    $new_exp = $exp + $plus_exp;
    // 経験値を付与した上でのレベルの計算
      // 経験値を100で割り（小数点切捨）、レベルの初期値である１を足す
    $new_level = floor($new_exp / 100) + 1;

    // 取得したレベルと新しいレベルの比較
    if($level < $new_level){ // 新しいレベルが取得レベルより高い場合
      // 経験値とレベルを更新するSQLの定義
      $sql_upd = 'UPDATE users SET exp=?, level=? WHERE user_id=?';   
      $arr = [];
      $arr[] = $new_exp;                                   //new_exp
      $arr[] = $new_level;                                 //new_level
      $arr[] = $userData['user_id'];                       //user_id
    }else{// 新しいレベルが取得レベルと同じ場合
      // 経験値だけを更新するSQLの定義
      $sql_upd = 'UPDATE users SET exp=? WHERE user_id=?';   
      $arr = [];
      $arr[] = $new_exp;                                   //new_exp
      $arr[] = $userData['user_id'];                       //user_id

    try{
      $stmt = connect()->prepare($sql_upd);
      // SQL実行
      $data = $stmt-> execute($arr);
      return $result;
    } catch(\Exception $e) {
      // エラーの出力
      echo $e;
    }


    }
  }
