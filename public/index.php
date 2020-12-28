<?php

$referer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_SCHEME'].'//'.$_SERVER['SERVER_NAME'].'/';
if (substr($referer, 0, 21) === 'http://127.0.0.1:3000' || substr($referer, 0, 21) === 'http://localhost:3000' || substr($referer, 0, 28) === 'https://school1.kitgroup.org') {
    header('Access-Control-Allow-Origin: '.substr($referer, 0, -1));
    header('Access-Control-Allow-Credentials: true');
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        header('Access-Control-Allow-Headers: Content-Type, Token');
        exit;
    }
}

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
