<?php

namespace Scatchbling\Scratcher\Domain\Exception;


/**
 * Class AuthorizationException
 * @package Scatchbling\Scratcher\Domain\Exception
 */
class AuthorizationException extends \Exception
{
    /**
     *
     */
    const AUTHORIZATION_EXCEPTION_CODE = 401;

    /**
     * AuthorizationException constructor.
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, self::AUTHORIZATION_EXCEPTION_CODE);
    }
}