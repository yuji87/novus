<?php

/**
 * Created by PhpStorm.
 * User: eceys
 * Date: 2019/03/22
 * Time: 19:24
 *
 * Q&Asite 専用のDBConnector
 * PDOを保持してDB関連処理を行う
 *
 */

// require_once( dirname(__FILE__)."/../../util/PDOWrapper.php" );

/**
 * Class DBConnector
 */
class DBConnector
{
    static protected $pdow;

    /**
     * @return PDOWrapper
     */
    public static function getPdow()
    {
        if(empty(self::$pdow)){
            self::setPdow();
        }
        return self::$pdow;
    }

    public static function setPdow($pdow=null)
    {
        if($pdow == null){
            $db_type = "mysql";	// データベースの種類
            $db_host = "localhost:3306";	// ホスト名
            $db_name = "qandasite";	// データベース名
            $dsn = $db_type.':dbname='.$db_name.';host='.$db_host.';charset=utf8';
            $user = "root";
            $password = "root";
            var_dump($dsn);
            $pdow = new PDO($dsn,$user,$password);
            
        }
        self::$pdow = $pdow;
    }
}