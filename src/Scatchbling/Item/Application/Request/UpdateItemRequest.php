<?php

namespace Scatchbling\Item\Application\Request;


/**
 * Class UpdateItemRequest
 * @package Scatchbling\Item\Application\Request
 */
class UpdateItemRequest extends ItemRequest
{
    private $itemId;

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param mixed $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }


}