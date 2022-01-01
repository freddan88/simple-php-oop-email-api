<?php

declare(strict_types=1);

class Security {

    static function getRemoteDomain()
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

    static function validateRemoteDomain($currentDomain, $allowedDomains)
    {
        header('Access-Control-Allow-Origin: ' . $currentDomain);
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: POST");
        if (in_array($currentDomain, $allowedDomains)) {
            return true;
        } else {
            return false;
        }
    }
}