<?php

namespace Scatchbling\Domain\Model;

use Ramsey\Uuid\Uuid;

/**
 * Class ItemId
 * @package Scatchbling\Domain\Model
 */
class ItemId
{
    private $id;

    /**
     * ItemId constructor.
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
     * @param ItemId $id
     * @return bool
     */
    public function equals(ItemId $id) {
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