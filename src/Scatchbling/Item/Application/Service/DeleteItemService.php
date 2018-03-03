<?php

namespace Scatchbling\Item\Application\Service;


use Scatchbling\Item\Domain\Exception\EntityNotFoundException;
use Scatchbling\Item\Domain\Model\ItemRepository;

class DeleteItemService implements Service
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
     * @throws EntityNotFoundException
     */
    public function execute($request)
    {
        $item = $this->itemRepository->findById($request->getItemId());

        if ($item == null) {
            throw new EntityNotFoundException("Item does not exist.");
        }

        $this->itemRepository->delete($item);
    }
}