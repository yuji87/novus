<?php

//ファイルの読み込み
require_once('core/DBconnect.php');
require_once('core/AppController.php');


    //POSTで受信した情報をデータベースに登録
    if(!empty($_POST['check'])){
        try{
            $sql = '
                    INSERT INTO users{
                        name,
                        tel,
                        email
                    )
                    VALUES(
                        :name,
                        :tel,
                        :email
                    )
                    ';
        //追加
        $obj = new AppController();
        $obj->insert_users($sql, $_POST['name'], $_POST['tel'], $_POST['email']);

        header('location: enrty_done.php' .$_SERVER["HTTP_REFERER"]);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    