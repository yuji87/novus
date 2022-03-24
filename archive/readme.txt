〇配置位置
xampp/htdocs直下に、qandaを配置してください。
(xampp/htdocs/qanda)

※ 位置を変更する場合、以下の２ファイルの値を変更してください。
qanda/js/qapi.js の $domainurl
qanda/def.php の DOMAIN

〇アクセス URL
https://localhost/qanda/req/top.php

〇データベース
・ddl ですが、いくつかのカラムに default設定をしたり
インデックスを張っています。
ddl/ddl.txt

・接続情報は以下のファイルの値を変更してください。
qanda/config_local.php の
URL    DB名 (現在 qanda)
USER   DBアカウント (現在 root)
PASS   DBパスワード (現在 パスワードなし)

