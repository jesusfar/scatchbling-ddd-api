<?php

namespace Scatchbling\Scratcher\Infrastructure\Http;

/**
 * Class Response
 * @package Scatchbling\Scratcher\Infrastructure\Http
 */
class Response
{
    private $status;
    private $body;
    private $headers;

    /**
     * Response constructor.
     * @param $status
     */
    public function __construct($status = HttpStatusCode::OK)
    {
        $this->status = $status;
    }

    /**
     * @param string $header
     * @return $this
     */
    public function withHeader(string $header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /**
     * @param $status
     * @return $this
     */
    public function withStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function withJson($data)
    {
        // TODO send JSON OPTIONS
        $this->withHeader('Content-Type: application/json');

        $this->body = json_encode($data);
        return $this;
    }

    /**
     *
     */
    public function prepare()
    {
        // Add status
        http_response_code($this->status);

        // Add Header
        if (!empty($this->headers)) {
            $this->addHeaders($this->headers);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $outPut = "";

        if ($this->body != null) {
            $outPut .= $this->body;
        }

        return $outPut;
    }

    /**
     * @param array $headers
     */
    private function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            header($header);
        }
    }
}