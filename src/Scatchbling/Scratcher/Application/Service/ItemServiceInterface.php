<?php

namespace Scatchbling\Scratcher\Application\Service;


use Scatchbling\Scratcher\Application\Request\CreateItemRequest;
use Scatchbling\Scratcher\Application\Request\UpdateItemRequest;

/**
 * Interface ItemServiceInterface
 * @package Scatchbling\Scratcher\Application\Service
 */
interface ItemServiceInterface
{

    /**
     * @param CreateItemRequest $request
     * @return mixed
     */
    public function createItem(CreateItemRequest $request);

    /**
     * @param UpdateItemRequest $request
     * @return mixed
     */
    public function updateItem(UpdateItemRequest $request);

    /**
     * @param string $itemId
     * @return mixed
     */
    public function getItem(string $itemId);

    /**
     * @param string $limit
     * @param string $offset
     * @return mixed
     */
    public function getItems(string $limit = "20", string $offset = "10");

    /**
     * @param string $itemId
     * @return mixed
     */
    public function deleteItem(string $itemId);
}