<?php

namespace Scatchbling\Item\Domain\Exception;


class DomainException extends \Exception
{
    const DOMAIN_EXCEPTION_CODE = 400;

    /**
     * DomainException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, self::DOMAIN_EXCEPTION_CODE);
    }
}