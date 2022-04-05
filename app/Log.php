<?php
namespace Novus;

require_once __DIR__ . '/../config/def.php';

use DateTime;

class Log
{
    public static function error($message)
    {
        $output = sprintf(
            "[%s] ERROR %s",
            (new DateTime())->format('Y-m-d H:i:s'),
            $message
        );

        $path = __DIR__ . '/../logs/';
        $file = 'error_' . (new DateTime())->format('Y-m-d') . '.log';

        error_log($output . PHP_EOL, 3, $path . $file);
    }
}
