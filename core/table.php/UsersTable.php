<?php

//require_once ("core/db/record/User.php");
require_once(dirname(__FILE__)."/../dbconnect.php");

class UsersTable {

    public static function createUser($argary): int {
        $ary = array(
            'name' => $argary[KEY_NAME],
            'tel' => $argary[KEY_TEL],
            'password' => password_hash($argary[KEY_PASSWORD], PASSWORD_DEFAULT),
            'email' => $argary[KEY_EMAIL],
            'icon' => $argary[KEY_ICON],
            'tw-user' => $argary[KEY_TWUSER],
            'q-disp-flg' => $argary[KEY_QDISPFLG],
            'level' => $argary[KEY_LEVEL],
            'exp' => $argary[KEY_EXP],
            'comment' => $argary[KEY_COMMENT],
        );

        $pdow = DBConnector::getPdow();
        $id = $pdow->insert('users',$ary);
        return $id;
        //dlog('$createdUserAry: ',$createdUserAry);
    }
    
    static public function updateUser($argary,$id) {
        $ary = $argary;
        $pdow = DBConnector::getPdow();
        $pdow->update('users',$ary,$id);
    }

    static private function exist($rowName,$val):bool {
        $sql = 'SELECT count(*) FROM users WHERE '.$rowName.'=:r AND q-disp-flg = 0';
        $data = ['r' => $val];
        $pdow = DBConnector::getPdow();
        $stmt = $pdow->queryPost($sql,$data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_shift($result) != 0;
    }

    //電話番号で重複チェック
    static public function existTel($tel):bool {
        return self::exist(KEY_TEL,$tel);
    }

    static public function getUser($id, $col='*') {
        $sql = 'SELECT '.$col.' FROM users WHERE id=:id AND q-disp_flg = 0';
        $data = ['id' => $id];
        $pdow = DBConnector::getPdow();
        $stmt = $pdow->queryPost($sql,$data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    static public function getUserPropety($id, $propety,$defaultReturn ='') {
        $result = self::getUser($id,$propety);
        return isset($result[$propety]) ? $result[$propety] : $defaultReturn;
    }
    
    static public function getUserNameByID($id):string {
        return self::getUserPropety($id,KEY_NAME,'(名無し)');
    }

    static public function getUserTelByID($id):string {
        return self::getUserPropety($id,KEY_TEL);
    }

    static public function getUserEmailByID($id):string {
        return self::getUserPropety($id,KEY_EMAIL);
    }

    static public function getUserTwuserByID($id):string {
        return self::getUserPropety($id,KEY_TWUSER);
    }

    static public function getUserLevelByID($id):string {
        return self::getUserPropety($id,KEY_LEVEL);
    }

    static public function getUserExpByID($id):string {
        return self::getUserPropety($id,KEY_EXP);
    }

    static public function getUserCommentByID($id):string {
        return self::getUserPropety($id,KEY_COMMENT);
    }

    static public function getUserIconByID($id):string {
        $defaultPath = '';  //ここにアイコンのパスを書く  
        $path = self::getUserPropety($id,KEY_ICON,$defaultPath);
        if($path != $defaultPath){
            $path = 'uploads/'.$path;
        }
        return $path;
    }

    public static function getAllUserList($limit=1000,$cols='*') {
        $sql = 'SELECT '.$cols.' FROM users WHERE q-disp-flg = 0 LIMIT '.$limit;
        $pdow = DBConnector::getPdow();

        try {

            $stmt = $pdow->queryPost($sql);
            if(!$stmt){ return null;}
            $result = $stmt->fetchAll();
            return $result;

        } catch (Error $exception) {
            echo 'エラーが発生しました<br>'.$exception;

        }
        return null;
    }

}