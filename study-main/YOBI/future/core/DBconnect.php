<?php

/**
 * Created by PhpStorm.
 * User: eceys
 * Date: 2019/03/22
 * Time: 19:24
 *
 * hiwihi 専用のDBConnector
 * PDOWrapperを保持してDB関連処理を行う
 *
 */

// require_once( dirname(__FILE__)."/PDOWrapper.php" );


/**
 * Class DBConnector
 */

class DBconnect
{

    static protected $pdow;

    /**
     * @return PDOWrapper
     */

    public static function getPdow() {

        if(empty(self::$pdow)) {
            self::setPdow();
        }

        return self::$pdow;
    }


    public static function setPdow($pdow=null) {
        if($pdow == null) {
            $dsn = DB_TYPE.':dbname='.DB_NAME.';host='.DB_HOST.';charset=utf8';
            $user = DB_USERNAME;
            $password = DB_PASSWORD;
            echo "db1・";
            // var_dump($dsn);
            // var_dump($user);
            // var_dump($password);

            echo "db2・";
            $pdow = new PDOa($dsn,$user,$password);
            echo "db3・";
        }

        self::$pdow = $pdow;
    }
}
