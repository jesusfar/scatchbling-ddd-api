<?php

use Scatchbling\Scratcher\Infrastructure\Application;
use Scatchbling\Scratcher\Infrastructure\Http\Request;
use Scatchbling\Scratcher\Infrastructure\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app->bootstrap();


// Basic routes

$app->get('/items', function (Request $request) use ($app) {
    $container = $app->getContainer();

    $result = $container['itemService']->getItems();

    return (new Response())->withJson($result);
});

$app->run();