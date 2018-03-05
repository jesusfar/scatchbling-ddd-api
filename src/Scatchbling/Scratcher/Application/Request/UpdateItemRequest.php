<?php

namespace Scatchbling\Scratcher\Application\Request;


/**
 * Class UpdateItemRequest
 * @package Scatchbling\Scratcher\Application\Request.old
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