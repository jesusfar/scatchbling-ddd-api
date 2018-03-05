<?php

namespace Scatchbling\Scratcher\Infrastructure\Http;


class HttpException extends \Exception
{
    /**
     * HttpException constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }
}