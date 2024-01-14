<?php

require_once 'vendor/autoload.php';
require_once 'service.php';

use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Server;

// Set the URI for the service
$port = getenv('PORT') ?: 5054;
$uri = 'http://localhost:' . $port . '/SheetMusicAPI.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Return the wsdl file to the browser

    if (! isset($_GET['wsdl'])) {
        header('HTTP/1.1 400 Client Error');
        exit;
    }

    $autoDiscover = new AutoDiscover();
    $autoDiscover->setUri($uri)
        ->setServiceName('SheetMusicAPI')
        ->setClass('SoapService');

    $wsdl = $autoDiscover->generate();

    header('Content-Type: application/xml');
    header('Content-Disposition: inline; filename="your_service.wsdl"');

    echo $wsdl->toXml();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 400 Client Error');
    return;
}

$server = new Server(Null, [
    'uri' => $uri
]);

$server
    ->setUri($uri)
    ->setClass('SoapService');

$server->handle();
exit;