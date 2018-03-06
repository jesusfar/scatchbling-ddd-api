<?php

use Scatchbling\Scratcher\Application\Request\CreateItemRequest;
use Scatchbling\Scratcher\Application\Request\LoginRequest;
use Scatchbling\Scratcher\Application\Request\UpdateItemRequest;
use Scatchbling\Scratcher\Infrastructure\Application;
use Scatchbling\Scratcher\Infrastructure\Http\HttpStatusCode;
use Scatchbling\Scratcher\Infrastructure\Http\Request;
use Scatchbling\Scratcher\Infrastructure\Http\Response;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app->withConfig(__DIR__ . '/../config/config.json');
$app->bootstrap();

$app->before(function (Request $request) use ($app) {

    $skipRoutes = ['/v1/authorization'];
    $container = $app->getContainer();

    if (!in_array($request->getRequestTarget(), $skipRoutes)) {
        $token = $request->getHeader('Authorization');
        $container['authorizationService']->authorization($token);
    }
});

// Routes

$app->post('/v1/authorization', function (Request $request) use ($app) {
    $container = $app->getContainer();
    $loginRequest = new LoginRequest();
    $loginRequest->setUser($request->getParam('user'));
    $loginRequest->setPassword($request->getParam('password'));

    $result = $container['authorizationService']->login($loginRequest);

    return (new Response())->withJson($result);
});

$app->get('/v1/items', function (Request $request) use ($app) {
    $container = $app->getContainer();

    $result = $container['itemService']->getItems($request->getParam('limit', '10'), $request->getParam('offset', 0));

    return (new Response())->withJson($result);
});

$app->get('/v1/items/{itemId}', function (Request $request, $uriParams) use ($app) {
    $container = $app->getContainer();

    $result = $container['itemService']->getItem($uriParams[0]);

    return (new Response())->withJson($result);
});

$app->post('/v1/items', function (Request $request) use ($app) {
    $container = $app->getContainer();

    $createItemRequest = new CreateItemRequest();
    $createItemRequest->setName($request->getParam('name', ''));
    $createItemRequest->setDescription($request->getParam('description', ''));
    $createItemRequest->setSize($request->getParam('size', ''));
    $createItemRequest->setPrice($request->getParam('price', 0));

    $result = $container['itemService']->createItem($createItemRequest);

    return (new Response(HttpStatusCode::CREATED))->withJson($result);
});

$app->put('/v1/items/{itemId}', function (Request $request, $uriParams) use ($app) {
    $container = $app->getContainer();

    $updateItemRequest = new UpdateItemRequest();
    $updateItemRequest->setItemId($uriParams[0]);
    $updateItemRequest->setName($request->getParam('name', ''));
    $updateItemRequest->setDescription($request->getParam('description', ''));
    $updateItemRequest->setSize($request->getParam('size', ''));
    $updateItemRequest->setPrice($request->getParam('price', 0));

    $result = $container['itemService']->updateItem($updateItemRequest);

    return (new Response(HttpStatusCode::OK))->withJson($result);
});

$app->delete('/v1/items/{itemId}', function (Request $request, $uriParams) use ($app) {
    $container = $app->getContainer();

    $container['itemService']->deleteItem($uriParams[0]);

    return (new Response(HttpStatusCode::NO_CONTENT));
});

$app->run();