<?php

declare(strict_types=1);

require_once('./controllers/Security.php');
require_once('./controllers/Response.php');

$configuration = parse_ini_file("config.ini", true);

$allowedDomains = $configuration['security']['allowed_domains'];

$httpStatuses = $configuration['http_codes'];

$allowedKey = $configuration['security']['api_key'];

$currentDomain = Security::getRemoteDomain();

if (!Security::validateRemoteDomain($currentDomain, $allowedDomains)) {
    Response::error($httpStatuses[403], $currentDomain);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') Response::error($httpStatuses[405]);

if (empty($_POST['apikey'])) Response::error($httpStatuses[400]);

if ($_POST['apikey'] !== $allowedKey) Response::error($httpStatuses[400]);

$req = $_SERVER['REQUEST_URI'];
$req = trim($req, '/');
$req = parse_url($req, PHP_URL_PATH);

require_once('./controllers/Email.php');

if($req === 'email') {
    $email = new Email($_POST);
    if ($email->validate()) $email->send();
} else {
    Response::error($httpStatuses[400]);
}