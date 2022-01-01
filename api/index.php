<?php

declare(strict_types=1);

require_once('./app/Security.php');
require_once('./app/Response.php');

$configuration = parse_ini_file("config.ini", true);

$allowedOrigins = $configuration['security']['allowed_origins'];

$httpStatuses = $configuration['http_codes'];

$allowedKey = $configuration['security']['api_key'];

$currentOrigin = Security::getRemoteOrigin();

if (!Security::validateRemoteOrigin($currentOrigin, $allowedOrigins)) {
    Response::error($httpStatuses[403], $currentOrigin);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') Response::error($httpStatuses[405]);

if (empty($_POST['apikey'])) Response::error($httpStatuses[400]);

if ($_POST['apikey'] !== $allowedKey) Response::error($httpStatuses[403]);

$req = $_SERVER['REQUEST_URI'];
$req = trim($req, '/');
$req = parse_url($req, PHP_URL_PATH);

require_once('./app/Email.php');

if ($req === 'email') {
    $email = new Email($_POST);
    if ($email->validate()) $email->send();
} else {
    Response::error($httpStatuses[400]);
}