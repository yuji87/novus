<?php

include_once 'def.php';

// ユーザー情報取得系
define("QUERY_MEMBER", "SELECT USER_ID,NAME,TEL,NAME,PASSWORD,EMAIL,ICON,TW_USER,Q_DISP_FLG,LEVEL,EXP,COMMENT,PRE_LEVEL,PRE_EXP FROM users WHERE user_id=:user_id");
define("QUERY_MEMBER_REF", "SELECT USER_ID,NAME,TEL,NAME,PASSWORD,EMAIL,ICON,TW_USER,Q_DISP_FLG,LEVEL,EXP,COMMENT,PRE_LEVEL,PRE_EXP FROM users WHERE USER_ID=:user_id");
define("QUERY_MEMBER_EMAIL", "SELECT USER_ID,NAME,TEL,NAME,PASSWORD,EMAIL,ICON,TW_USER,Q_DISP_FLG,LEVEL,EXP,COMMENT,PRE_LEVEL,PRE_EXP FROM users WHERE EMAIL=:email");
define("QUERY_MEMBERLIST_IDS", "SELECT USER_ID,NAME,TEL,NAME,PASSWORD,EMAIL,ICON,TW_USER,Q_DISP_FLG,LEVEL,EXP,COMMENT,PRE_LEVEL,PRE_EXP FROM users WHERE USER_ID IN (%s)");

// ユーザー情報更新系
define("INSERT_MEMBER", "INSERT INTO users (NAME,PASSWORD,EMAIL) VALUES (:name, :password, :email)");

// ベースクラス
class Action
{
    var $conn;
    var $member;
    var $device;

    // ページ読み出し処理(各ページの初期時に呼び出す)
    // セッションがない場合は、トップページへリダイレクトさせる
    // ページ表示不要のリクエストは,mode=1にして呼ぶ。
    function begin($mode = 0) {
        session_start();

        // Cookie
        if (isset($_SESSION["USER_ID"]) == FALSE) {
            // LOGIN PAGEへ
            header('Location: ' . DOMAIN . 'req/login.php');
            exit;
        }
        $userid = $_SESSION["USER_ID"];

        // DB接続
        try {
            $this->conn = new PDO(URL, USER, PASS);
        } catch (PDOException $e) {
            printf("failed. dbconn1");
            return;
        }

        // 文字コード
//        $this->conn->query('utf8');

        // ユーザー情報
        $handle = $this->conn->prepare(QUERY_MEMBER);
        $handle->bindValue(':user_id', $userid);
        $result = $handle->execute();
        $this->member = $result ? $handle->fetch(PDO::FETCH_ASSOC): NULL;

        // デバイス判定
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($ua, 'iPhone') !== false) {
            $this->device = 'iPhone';
        } else if (strpos($ua, 'iPod') !== false) {
            $this->device = 'iPod';
        } else if (strpos($ua, 'Android') !== false) {
            $this->device = 'Android';
        } else {
            $this->device = 'PC';
        }

        if ($mode == 0) {
        // header,include,bodyまで出力
            $this->printHeader();
        }
    }

    // ページ読み出し処理(各ページの初期時に呼び出す)
    // セッション不要のページ(ログインページなど)はコチラを使用。
    // ページ表示不要のリクエストは,mode=1にして呼ぶ。
    function begin_free($mode = 0) {
        // DBサーチ
        try {
            $this->conn = new PDO(URL, USER, PASS);
        } catch (PDOException $e) {
            printf("failed. dbconn1");
            return;
        }

        // 文字コード
//        $this->conn->query('utf8');

        if ($mode == 0) {
        // header,include,bodyまで出力
            $this->printHeader();
        }
    }

    // ログイン中か判定
    function isLogin() {
        return isset($_SESSION["USER_ID"]);
    }

    // ログイン処理
    function login($email, $password) {
        session_start();

        // DB接続
        try {
            $this->conn = new PDO(URL, USER, PASS);
        } catch (PDOException $e) {
            printf("failed. dbconn1");
            return;
        }

        // 文字コード
//        $this->conn->query('utf8');

        // emailから user情報取得
        $handle = $this->conn->prepare(QUERY_MEMBER_EMAIL);
        $handle->bindValue(':email', $email);
        $result = $handle->execute();
        $this->member = $result ? $handle->fetch(PDO::FETCH_ASSOC): NULL;
        if (! $this->member) {
            return 'AUTHERROR';
        }

        // パスワード比較 (パスワードは md5で暗号化して格納されていることを想定)
//print '@@' . md5($password) . ':' . $this->member['PASSWORD'];
        if (md5($password) == $this->member['PASSWORD']) {
        // 認証成功

            // セッションIDを新規に発行する
            session_regenerate_id(TRUE);
            $_SESSION['USER_ID'] = $this->member['USER_ID'];
            return 'SUCCESS';
        } else {
            return 'AUTHERROR';
        }
    }

    // ログアウト処理
    function logout() {
        session_start();

        if (isset($_SESSION['USER_ID']) == TRUE) {
            $errorMessage = "ログアウトしました。";
        } else {
            $errorMessage = "セッションがタイムアウトしました。";
        }

        // セッション変数のクリア
        $_SESSION = array();

        // クッキーの破棄
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"],
                $params["domain"], $params["secure"], $params["httponly"]);
        }

        // セッションクリア
        @session_destroy();

        return $errorMessage;
    }
    // userIdからユーザ情報を取得
    function memberref($userid) {
        $handle = $this->conn->prepare(QUERY_MEMBER_REF);
        $handle->bindValue(':user_id', $userid);
        $result = $handle->execute();
        if (! $result) {
            return NULL;
        }
        $member = $handle->fetch(PDO::FETCH_ASSOC);
        return $member;
    }
    // emailからユーザ情報を取得
    function memberrefemail($email) {
        $handle = $this->conn->prepare(QUERY_MEMBER_EMAIL);
        $handle->bindValue(':email', $email);
        $result = $handle->execute();
        if (! $result) {
            return NULL;
        }
        $member = $handle->fetch(PDO::FETCH_ASSOC);
        return $member;
    }
    // 特定の連想配列から、IDを取り出して、ユーザ情報のマップを作成
    // 戻り値は user-id とユーザ情報の連想配列。
    function membermap($users, $idkey) {
        $members = array();
        if (count($users) == 0) {
            return $members;
        }

        // where句の作成
        $ids = array();
        $dupmap = array();
        foreach ($users as $user) {
            if (isset($dupmap[$user[$idkey]])) {
                continue;
            }
            $dupmap[$user[$idkey]] = 1;
            $ids[] = $user[$idkey];
        }
        $inClause = substr(str_repeat(',?', count($ids)), 1);

        // メンバー情報取得
        $handle = $this->conn->prepare(sprintf(QUERY_MEMBERLIST_IDS, $inClause));
        $result = $handle->execute($ids);
        if ($result) {
            while ($mem = $handle->fetch(PDO::FETCH_ASSOC)) {
                $members[$mem['USER_ID']] = $mem;
            }
        }

        return $members;
    }
    // ユーザ情報を登録
    function regist($email, $name, $password) {
        // 登録
        $handle = $this->conn->prepare(INSERT_MEMBER);
        $handle->bindValue(':name', $name);
        $handle->bindValue(':email', $email);
        $handle->bindValue(':password', $password);
        $handle->execute();
        return true;
    }
    // ページの終了処理。
    // footerを出力
    // ページ表示不要のリクエストは,mode=1にして呼ぶ。
    function end($mode = 0) {
        $domain = DOMAIN;

        if ($mode == 0) {
        // フッダー出力

            echo '<hr/>';
            echo '<div class="row m-2">';
            echo '<a class="btn btn-warning m-2" href="' . DOMAIN . '/req/logout.php">ログアウト</a>';
            echo '<a class="btn btn-success m-2" href="' . DOMAIN . '/req/user/mypage.php">ホーム画面へ</a>';
            echo '</div>';
        }

        echo '</div></body>';
        echo '</html>';
    }
    // header,include,bodyまで出力する
    // SEO対策、javascript/cssを追加する場合は、コチラへ追加する。
    function printHeader() {
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">';

        echo '<link rel="stylesheet" type="text/css" href="' . DOMAIN . 'img/qanda.css?ver=' . VERSION . '" />';
        echo '<link rel="stylesheet" type="text/css" href="' . DOMAIN . 'img/jquery.datetimepicker.css" media="screen" />';
        echo '<link rel="stylesheet" type="text/css" href="' . DOMAIN . 'img/bootstrap-4.4.1.css">';

        echo '<script src="' . DOMAIN . 'js/jquery-3.1.1.js"></script>';
        echo '<script src="' . DOMAIN . 'js/jquery.datetimepicker.full.js"></script>';
        echo '<script src="' . DOMAIN . 'js/qapi.js?ver={$version}"></script>';
        echo '<script src="' . DOMAIN . 'js/bootstrap-4.4.1.js"></script>';
        echo '<script src= "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>';

        echo '<title>' . SYSTITLE . '</title>';
        echo '</head>';
        echo '<body><div class="container">';
    }
}

?>
