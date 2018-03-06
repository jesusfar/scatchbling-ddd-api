<?php

namespace Scatchbling\Scratcher\Infrastructure\Http;

use Scatchbling\Scratcher\Domain\Exception\AuthorizationException;
use Scatchbling\Scratcher\Domain\Exception\DomainException;
use Scatchbling\Scratcher\Domain\Exception\EntityNotFoundException;

/**
 * Class SimpleRouter
 * @package Scatchbling\Scratcher\Infrastructure\Http
 */
class SimpleRouter implements Router
{
    const GET_METHOD = "GET";
    const POST_METHOD = "POST";
    const PUT_METHOD = "PUT";
    const DELETE_METHOD = "DELETE";

    private $routes;
    private $beforeCallbacks = [];

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function get(string $pattern, $callback)
    {
        $this->addRoute($pattern, self::GET_METHOD, $callback);
    }

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function post(string $pattern, $callback)
    {
        $this->addRoute($pattern, self::POST_METHOD, $callback);
    }

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function put(string $pattern, $callback)
    {
        $this->addRoute($pattern, self::PUT_METHOD, $callback);
    }

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function delete(string $pattern, $callback)
    {
        $this->addRoute($pattern, self::DELETE_METHOD, $callback);
    }

    /**
     * @param $callback
     * @return mixed
     */
    public function before($callback)
    {
        $this->addBeforeCallback($callback);
    }

    /**
     * Handle the request and return a response.
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        try {
            // Execute before callbacks
            foreach ($this->beforeCallbacks as $beforeCallback) {
                $this->executeBeforeCallback($beforeCallback, $request);
            }

            // Execute methods
            $method = $request->getMethod();
            $routeMatch = $this->match($method, $request->getRequestTarget());

            if ($routeMatch == null) {
                throw new HttpException("Not found", HttpStatusCode::NOT_FOUND);
            }

            $this->executeCallback($routeMatch[$method]['callback'], $request, $routeMatch[$method]['uriParams']);
        } catch (\Exception $e) {
            $this->handleException($e);
        }

    }

    /**
     * @param $method
     * @param $targetUri
     * @return null
     */
    private function match($method, $targetUri)
    {
        $routeResult = null;

        foreach ($this->routes as $routeKey => $route) {
            // Replace all curly {} braces for (\w+)
            $routeReplaced = preg_replace('/{([A-Za-z]*?)}/', '([a-z0-9\-]*)', $routeKey);
            $pattern = '/' . str_replace('/', '\/', $routeReplaced) .'/';

            // if match
            if (preg_match($pattern, $targetUri, $matches)) {
                array_shift($matches);
                if (array_key_exists($method, $route)) {
                    // add route parasm
                    $route[$method]['uriParams'] = $matches;
                    $routeResult = $route;
                }

            }
        }
        return $routeResult;
    }

    /**
     * @param $callback
     * @param $request
     * @param null $params
     */
    private function executeCallback($callback, $request, $params = null)
    {
        if (is_callable($callback)) {
            $this->handleResponse(call_user_func($callback, $request, $params));
        }
    }

    /**
     * @param $pattern
     * @param $method
     * @param $callback
     */
    private function addRoute($pattern, $method, $callback)
    {

        if (!isset($this->routes[$pattern])) {
            $this->routes[$pattern] = [
                $method => [
                    'callback' => $callback,
                ],
            ];
        } else {

            if (!isset($this->routes[$pattern][$method])) {
                $this->routes[$pattern][$method] = [
                    'callback' => $callback,
                ];
            }
        }
    }

    // TODO improve error handling

    /**
     * @param \Exception $e
     */
    private function handleException(\Exception $e)
    {
        if ($e instanceof DomainException) {
            $response = (new Response())->withStatus(HttpStatusCode::BAD_REQUEST)->withJson([
                'code' => DomainException::DOMAIN_EXCEPTION_CODE,
                'message' => $e->getMessage()
            ]);
        } elseif ($e instanceof EntityNotFoundException) {
            $response = (new Response())->withStatus(HttpStatusCode::NOT_FOUND)->withJson([
                'code' => EntityNotFoundException::ENTITY_NOT_FOUND_EXCEPTION_CODE,
                'message' => $e->getMessage()
            ]);
        } elseif ($e instanceof HttpException) {
            $response = (new Response())->withStatus($e->getCode());
        } elseif ($e instanceof AuthorizationException) {
            $response = (new Response())->withStatus(HttpStatusCode::UNAUTHORIZED)->withJson([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        $this->handleResponse($response);
    }

    /**
     * @param Response $response
     */
    private function handleResponse(Response $response)
    {
        $response->prepare();
        print $response;
        exit;
    }

    private function addBeforeCallback($callback)
    {
        $this->beforeCallbacks[] = $callback;
    }

    private function executeBeforeCallback($callback, $request, $params = [])
    {
        if (is_callable($callback)) {
            call_user_func($callback, $request, $params);
        }
    }
}