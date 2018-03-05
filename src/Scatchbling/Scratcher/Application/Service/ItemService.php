<?php

namespace Scatchbling\Scratcher\Application\Service;


use Scatchbling\Scratcher\Application\Request\CreateItemRequest;
use Scatchbling\Scratcher\Application\Request\UpdateItemRequest;
use Scatchbling\Scratcher\Domain\Exception\EntityNotFoundException;
use Scatchbling\Scratcher\Domain\Model\Item;
use Scatchbling\Scratcher\Domain\Model\ItemId;
use Scatchbling\Scratcher\Domain\Model\ItemRepository;

class ItemService implements ItemServiceInterface
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
     * @param CreateItemRequest $request
     * @return mixed
     * @throws \Scatchbling\Scratcher\Domain\Exception\DomainException
     */
    public function createItem(CreateItemRequest $request)
    {
        $item = new Item(
            new ItemId(),
            $request->getName(),
            $request->getDescription(),
            $request->getSize(),
            floatval($request->getPrice())
        );

        $this->itemRepository->save($item);

        return $this->transformToResponse($item);
    }

    /**
     * @param UpdateItemRequest $request
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function updateItem(UpdateItemRequest $request)
    {
        $item = $this->itemRepository->findById(new ItemId($request->getItemId()));

        if ($item == null) {
            throw new EntityNotFoundException("Scratcher does not exist.");
        }

        $item->setName($request->getName());
        $item->setDescription($request->getDescription());
        $item->setSize($request->getSize());
        $item->setPrice($request->getPrice());

        $this->itemRepository->save($item, true);

        return $this->transformToResponse($item);
    }

    /**
     * @param string $itemId
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function getItem(string $itemId)
    {
        $item = $this->itemRepository->findById(new ItemId($itemId));

        if ($item == null) {
            throw new EntityNotFoundException("Scratcher does not exist.");
        }

        return $this->transformToResponse($item);
    }

    /**
     * @param string $limit
     * @param string $offset
     * @return mixed
     */
    public function getItems(string $limit = "20", string $offset = "0")
    {

        $itemCollection = $this->itemRepository->findAll($limit, $offset);

        $collectionResult = [];
        foreach ($itemCollection as $item) {
            $collectionResult[] = $this->transformToResponse($item);
        }
        return $collectionResult;
    }

    /**
     * @param string $itemId
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function deleteItem(string $itemId)
    {
        $item = $this->itemRepository->findById(new ItemId($itemId));

        if ($item == null) {
            throw new EntityNotFoundException("Scratcher does not exist.");
        }

        $this->itemRepository->delete($item);
    }

    private function transformToResponse(Item $item)
    {
        return [
            'item_id' => $item->getId()->getId(),
            'item_name' => $item->getName(),
            'item_description' => $item->getDescription(),
            'item_size' => $item->getSize(),
            'item_price' => $item->getPrice(),
        ];
    }
}