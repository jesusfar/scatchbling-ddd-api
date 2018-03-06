<?php

namespace Scatchbling\Scratcher\Infrastructure\Http;

/**
 * Class Request
 * @package Scatchbling\Scratcher\Infrastructure\Http
 */
class Request
{

    private static $instance = null;
    private $method = null;
    private $uri = null;
    private $queryParameters = null;
    private $body = null;
    private $headers = null;

    /**
     * Request constructor.
     */
    private function __construct()
    {
        $this->loadMethod();
        $this->loadUri();
        $this->loadBody();
        $this->loadHeaders();
    }

    /**
     * @return null|Request
     */
    public static function fromEnvironment()
    {
        if (self::$instance == null) {
            return new self();
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getUri() : array
    {
        return $this->uri;
    }

    public function getHeader(string $key)
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * @return string
     */
    public function getRequestTarget() : string
    {
        if ($this->uri == null) {
            return "/";
        }

        return $this->uri['path'];
    }

    /**
     * @return null
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getQueryParam($key, $default = null)
    {
        $queryParams = $this->getQueryParameters();

        if (isset($queryParams[$key])) {
            return $queryParams[$key];
        }

        return $default;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return $this
     */
    private function loadMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? null;

        return $this;
    }

    /**
     *
     */
    private function loadUri()
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? null;

        if ($requestUri !== null) {
            $this->uri = parse_url($requestUri);

            if (isset($this->uri['query'])) {
                parse_str($this->uri['query'], $this->queryParameters);
            }
        }
    }

    private function loadHeaders()
    {
        $this->headers = getallheaders();
    }

    /**
     *
     */
    private function loadBody()
    {
        $this->body = file_get_contents('php://input');
    }

    /**
     * @return array|mixed
     */
    public function getParseBody()
    {
        if ($this->body == null) {
            return [];
        }

        return json_decode($this->body, TRUE);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getParam(string $key, $default = null)
    {
        $param = $default;
        $bodyParams = $this->getParseBody();
        $queryParams = $this->getQueryParameters();

        if (is_array($bodyParams) && isset($bodyParams[$key])) {
            $param = $bodyParams[$key];
        } elseif (isset($queryParams[$key])) {
            $param = $queryParams[$key];
        }

        return $param;
    }

}