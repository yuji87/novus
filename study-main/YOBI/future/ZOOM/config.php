<?php
// アプリのクレデンシャルとOAuthプロセスを使用して、自分のアカウントのアクセストークンを生成
require_once 'vendor/autoload.php';
require_once "class-db.php";

define('CLIENT_ID', 'Wo9OfO9HRt2jlPoR2b6KgA');
define('CLIENT_SECRET', 'FWh9QCBSIkAHQZy3iXdbEjJMsvN1Z42a');
define('REDIRECT_URI', 'https://172c-2001-268-9875-3a62-3c2f-280d-f439-1fcb.ngrok.io/study/ZOOM/callback.php');
// define('REDIRECT_URI', 'http://localhost/study/ZOOM/callback.php');
