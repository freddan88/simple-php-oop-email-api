<?php

declare(strict_types=1);

require_once('./app/Response.php');

$configuration = parse_ini_file("config.ini", true);

$httpStatuses = $configuration['http_codes'];
$apiStatus = (int)$configuration['api']['enabled'];

if (!$apiStatus) Response::error($httpStatuses[503]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') Response::error($httpStatuses[405]);

$allowedOrigins = $configuration['security']['allowed_origins'];

$allowedKey = $configuration['security']['api_key'];

require_once('./app/Security.php');

$currentOrigin = Security::getRemoteOrigin();

if (!Security::validateRemoteOrigin($currentOrigin, $allowedOrigins)) {
    Response::error($httpStatuses[403], $currentOrigin);
}

if (empty($_POST['apikey'])) Response::error($httpStatuses[400]);

if ($_POST['apikey'] !== $allowedKey) Response::error($httpStatuses[403]);

$req = $_SERVER['REQUEST_URI'];
$req = parse_url($req, PHP_URL_PATH);
$req = explode("/", $req);
$req = end($req);

require_once('./app/Email.php');

if ($req === 'email') {
    $email = new Email($_POST);
    if ($email->validate()) $email->send();
} else {
    Response::error($httpStatuses[501]);
}