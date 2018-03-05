<?php

namespace Scatchbling\Scratcher\Domain\Model;

/**
 * Interface ItemRepository
 * @package Scatchbling\Scratcher\Domain\Model
 */
interface ItemRepository
{
    /**
     * @param Item $item
     * @return mixed
     */
    public function save(Item $item);

    /**
     * @param Item $item
     * @return mixed
     */
    public function delete(Item $item);

    /**
     * @param ItemId $itemId
     * @return mixed
     */
    public function findById(ItemId $itemId);

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findAll(int $limit = 20, int $offset = 10);
}