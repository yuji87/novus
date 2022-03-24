<?php

namespace PHPMailer\PHPMailer;

class Exception extends \Exception
{
    //エラーメッセージを整形して出力
    public function errorMessage()
    {
        return '<strong>' . htmlspecialchars($this->getMessage(), ENT_COMPAT | ENT_HTML401) . "</strong><br />\n";
    }
}
