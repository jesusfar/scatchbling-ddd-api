<?php

namespace Scatchbling\Item\Application\Service;


use Scatchbling\Item\Domain\Model\Item;
use Scatchbling\Item\Domain\Model\ItemId;
use Scatchbling\Item\Domain\Model\ItemRepository;

/**
 * Class CreateItemService
 * @package Scatchbling\Item\Application\Service
 */
class CreateItemService implements Service
{

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * CreateItemService constructor.
     * @param $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }


    /**
     * @param $request
     * @return mixed
     * @throws \Scatchbling\Item\Domain\Exception\DomainException
     */
    public function execute($request)
    {
        $item = new Item(
            new ItemId(),
            $request->getName(),
            $request->getDescription(),
            $request->getSize(),
            $request->getPrice()
        );

        $this->itemRepository->save($item);

        return $item;
    }
}