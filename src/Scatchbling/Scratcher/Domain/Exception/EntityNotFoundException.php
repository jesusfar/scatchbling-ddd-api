<?php

namespace Scatchbling\Scratcher\Domain\Exception;


class EntityNotFoundException extends \Exception
{
    const ENTITY_NOT_FOUND_EXCEPTION_CODE = 404;

    /**
     * DomainException constructor.
     * @param string $message
     */
    public function __construct(string $message = "")
    {
        parent::__construct($message, self::ENTITY_NOT_FOUND_EXCEPTION_CODE);
    }
}