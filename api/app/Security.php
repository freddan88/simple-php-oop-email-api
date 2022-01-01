<?php

declare(strict_types=1);

class Security {

    static function getRemoteOrigin()
    {
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            return $_SERVER['HTTP_ORIGIN'];
        }
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            return $_SERVER['HTTP_REFERER'];
        }
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return '';
    }

    static function validateRemoteOrigin($currentOrigin, $allowedOrigins)
    {
        header('Access-Control-Allow-Origin: ' . $currentOrigin);
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST");
        if (in_array($currentOrigin, $allowedOrigins)) {
            return true;
        } else {
            return false;
        }
    }
}