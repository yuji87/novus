<?php
session_start();
$mode = 'input';
$errmessage = array();
if (isset($_POST['back']) && $_POST['back']) {
    // 何もしない
} else if (isset($_POST['confirm']) && $_POST['confirm']) {
    // 確認画面
    if (!$_POST['fullname']) {
        $errmessage[] = "<div class='ellMessage'>名前を入力してください</div>";
    } else if (mb_strlen($_POST['fullname']) > 50) {
        $errmessage[] = "<div class='ellMessage'>名前は50文字以内にしてください</div>";
    }
    $_SESSION['fullname']    = htmlspecialchars($_POST['fullname'], ENT_QUOTES);

    if (!$_POST['email']) {
        $errmessage[] = "<div class='ellMessage'>Eメールを入力してください</div>";
    } else if (mb_strlen($_POST['email']) > 100) {
        $errmessage[] = "<div class='ellMessage'>Eメールは100文字以内にしてください</div>";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errmessage[] = "<div class='ellMessage'>メールアドレスが不正です</div>";
    }
    $_SESSION['email']    = htmlspecialchars($_POST['email'], ENT_QUOTES);

    if (!$_POST['message']) {
        $errmessage[] = "<div class='ellMessage'>お問い合わせ内容を入力してください</div>";
    } else if (mb_strlen($_POST['message']) > 500) {
        $errmessage[] = "<div class='ellMessage'>お問い合わせ内容は500文字以内にしてください</div>";
    }
    $_SESSION['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);

    if ($errmessage) {
        $mode = 'input';
    } else {
        //   $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)); // php5のとき
        $token = bin2hex(random_bytes(32));                                   // php7以降
        $_SESSION['token']  = $token;
        $mode = 'confirm';
    }
} else if (isset($_POST['send']) && $_POST['send']) {
    // 送信ボタンを押したとき
    if (!$_POST['token'] || !$_SESSION['token'] || !$_SESSION['email']) {
        $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
        $_SESSION     = array();
        $mode         = 'input';
    } else if ($_POST['token'] != $_SESSION['token']) {
        $errmessage[] = '<div class="ellMessage">不正な処理が行われました</div>';
        $_SESSION     = array();
        $mode         = 'input';
    } else {
        $sender = "DatingTokyoSupport";
        $message =
            "お問い合わせを受け付けました。\r\n"
            ."担当よりご連絡致しますので今しばらくお待ちくださいませ。\r\n"
            ."※このメールはシステムからの自動返信です。\r\n"
            ."\r\n"
            ."▼お問い合わせ内容▼\r\n"
        ."-----------------------------------------------\r\n"
            . "名前: " . $_SESSION['fullname'] . "\r\n"
            . "email: " . $_SESSION['email'] . "\r\n"
            . "お問い合わせ内容:\r\n"
            . preg_replace("/\r\n|\r|\n/", "\r\n", $_SESSION['message']);

        $addHeader = "From:" . mb_encode_mimeheader($sender)  . "support@dating-tokyo.com\r\n";
        mail($_SESSION['email'], '【DatingTokyo】お問い合わせありがとうございます', $message);
        mail('support@dating-tokyo.com', '【DatingTokyo】お問い合わせありがとうございます', $message);
        $_SESSION = array();
        $mode     = 'send';
    }
} else {
    $_SESSION['fullname'] = "";
    $_SESSION['email']    = "";
    $_SESSION['message']  = "";
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T0FN5M6YL6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-T0FN5M6YL6');
    </script>
    <!--ページに関する情報-->
    <meta charset="UTF-8">
    <meta name="msapplication-square70x70logo" content="/site-tile-70x70.png">
    <meta name="msapplication-square150x150logo" content="/site-tile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/site-tile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/site-tile-310x310.png">
    <meta name="msapplication-TileColor" content="#0078d7">
    <meta name="keywords" content="キーワード">
    <meta name="description" content="コンテンツの説明">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--①文字コードの指定-->
    <title>Dating Tokyo</title>
    <!--②ページタイトルの指定-->
    <!-- <link rel="stylesheet" href="https://cdnjs/cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
    <link rel="shortcut icon" href="/link/img.jpg/favicon.ico">
    <link rel="icon" href="link/img.jpg/favicon.ico">
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="36x36" href="/android-chrome-36x36.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/android-chrome-48x48.png">
    <link rel="icon" type="image/png" sizes="72x72" href="/android-chrome-72x72.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/android-chrome-96x96.png">
    <link rel="icon" type="image/png" sizes="128x128" href="/android-chrome-128x128.png">
    <link rel="icon" type="image/png" sizes="144x144" href="/android-chrome-144x144.png">
    <link rel="icon" type="image/png" sizes="152x152" href="/android-chrome-152x152.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="256x256" href="/android-chrome-256x256.png">
    <link rel="icon" type="image/png" sizes="384x384" href="/android-chrome-384x384.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="36x36" href="/icon-36x36.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/icon-48x48.png">
    <link rel="icon" type="image/png" sizes="72x72" href="/icon-72x72.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/icon-96x96.png">
    <link rel="icon" type="image/png" sizes="128x128" href="/icon-128x128.png">
    <link rel="icon" type="image/png" sizes="144x144" href="/icon-144x144.png">
    <link rel="icon" type="image/png" sizes="152x152" href="/icon-152x152.png">
    <link rel="icon" type="image/png" sizes="160x160" href="/icon-160x160.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="196x196" href="/icon-196x196.png">
    <link rel="icon" type="image/png" sizes="256x256" href="/icon-256x256.png">
    <link rel="icon" type="image/png" sizes="384x384" href="/icon-384x384.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icon-512x512.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icon-16x16.png">
    <link rel="icon" type="image/png" sizes="24x24" href="/icon-24x24.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icon-32x32.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="/your-path-to-fontawesome/css/all.css">
    <link rel="stylesheet" href="/link/contactForm/contactForm.css">
    <!-- <link rel="stylesheet" href="responsive.css"> -->
    <!--load all styles -->
    <!--③CSSの読み込み-->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script> -->
    <script src="https://kit.fontawesome.com/3f20c0ff36.js" crossorigin="anonymous" defer></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script> -->
    <!-- <script src="script.js" defer></script> -->
</head>

<body>
    <!--実際に表示したい内容-->
    <header>

        <div class="header-logo">
            <a href="/index.html">Dating Tokyo</a>
        </div>

        <ul class="header-list">
            <li class="menu-item a">
                <a href="/link/search.html" style="display:inline;" class="">
                    <span class="search text">条件で探す</span>
                </a>
            </li>
            <li class="menu-item b">
                <a href="/link/picture.html" style="display:inline;" class="">
                    <span class="picture text">写真で探す</span>
                </a>
            </li>
            <li class="menu-item c">
                <a href="/link/map.html" style="display:inline;" class="" rel="noopener noreferrer">
                    <span class="map text">地図で探す</span>
                </a>
            </li>
        </ul>

    </header>
    <main>
        <?php if ($mode == 'input') {
            // 入力画面 
            if ($errmessage) {
                echo '<div class="alert alert-danger" role="alert">';
                echo implode('<br>', $errmessage);
                echo '</div>';
            }
        ?>
            <h1 class="formTitle">
                お問い合わせ
            </h1>
            <form action="./contactForm.php" method="post" id="form" class="topBefore" enctype="multipart/form-data">
                <input id="name" type="text" name="fullname" value="<?php echo $_SESSION['fullname'] ?>" class="inputForm" placeholder="NAME"><br>
                <input id="email" type="email" name="email" value="<?php echo $_SESSION['email'] ?>" class="inputForm" placeholder="E-MAIL"><br>
                <textarea id="message" type="text" name="message" placeholder="MESSAGE"><?php echo $_SESSION['message'] ?></textarea><br>
                <input id="submit" type="submit" name="confirm" value="送信内容を確認" class="submit" />
            </form>
            <!-- -------------- action属性   → 入力されたデータの受け渡し場所のURLを指定        -------------- -->
            <!-- -------------- method属性   → データの処理方法を指定                          -------------- -->
            <!-- -------------- inputタグ    → 入力ができるフィールドを作成するための役割       -------------- -->
            <!-- -------------- name属性     → データに名前を付けてプログラムに分かりやすくする  -------------- -->
            <!-- -------------- textareaタグ → 複数行の入力が可能                              -------------- -->
        <?php } else if ($mode == 'confirm') { ?>
            <!-- 確認画面 -->
            <h1 class="formTitle">
                内容の確認
            </h1>
            <form action="./contactForm.php" method="post" class="topBefore">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <div class="formCheck">
                    <div class="formCheckName">NAME：<?php echo $_SESSION['fullname'] ?></div>
                    <div class="formCheckEmail">email：<?php echo $_SESSION['email'] ?></div>
                    <div class="formCheckMessage">content：<?php echo nl2br($_SESSION['message']) ?></div>
                </div>
                <div class="formCheckButton">
                    <input id="submit" type="submit" name="back" class="submit" value="戻る" />
                    <input id="submit" type="submit" name="send" class="submit" value="送信" />
                </div>
            </form>
        <?php } else { ?>
            <!-- 完了画面 -->
            <h2 class="formFinish">
                送信しました。<br>
                お問い合わせありがとうございました。<br>
                ※設定頂いたメールアドレスに自動応答メッセージが届いているかご確認ください。<br>
                届いていない場合は、サポートチームからのメールが受信できない場合があります。<br>
            </h2>
        <?php } ?>


    </main>
    <footer>
        <div class="footer-logo">Dating Tokyo</div>
        <div class="footer-list">
            <ul>
                <li><a href="/link/termsOfService/termsOfService.html" class="termsOfService">利用規約</a></li>
                <li><a href="/link/contactForm/contactForm.php" class="contactForm">お問い合わせ</a></li>
            </ul>
        </div>
    </footer>
</body>


</html>