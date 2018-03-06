<?php

namespace Scatchbling\Scratcher\Domain\Model;

use Ramsey\Uuid\Uuid;

/**
 * Class SessionId
 * @package Scatchbling\Scratcher\Domain\Model
 */
class SessionId
{
    private $id;

    /**
     * SessionId constructor.
     * @param $id
     */
    public function __construct($id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param SessionId $id
     * @return bool
     */
    public function equals(SessionId $id) {
        if ($this->id === $id.$this->getId()) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getId();
    }


}