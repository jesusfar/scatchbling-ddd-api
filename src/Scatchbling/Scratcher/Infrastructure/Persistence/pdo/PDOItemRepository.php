<?php

namespace Scatchbling\Scratcher\Infrastructure\Persistence\pdo;


use Scatchbling\Scratcher\Domain\Model\Item;
use Scatchbling\Scratcher\Domain\Model\ItemId;
use Scatchbling\Scratcher\Domain\Model\ItemRepository;

/**
 * Class PDOItemRepository
 * @package Scatchbling\Scratcher\Infrastructure\Persistence\pdo
 */
class PDOItemRepository extends PDORepository implements ItemRepository
{
    /**
     * PDOItemRepository constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }


    /**
     * @param Item $item
     * @param bool $isUpdate
     * @return mixed
     */
    public function save(Item $item, bool $isUpdate = false)
    {
        if ($isUpdate) {
            $sql = <<<EOQ
UPDATE items 
SET item_name = :itemName, item_description = :itemDescription, item_size = :itemSize, item_cost = :itemCost
WHERE item_id = :itemId
EOQ;

        } else {
            $sql = <<<EOQ
INSERT INTO items(item_id, item_name, item_description, item_size, item_cost) 
VALUES (:itemId, :itemName, :itemDescription, :itemSize, :itemCost)
EOQ;
        }

        $args = [
            ':itemId' => $item->getId(),
            ':itemName' => $item->getName(),
            ':itemDescription' => $item->getDescription(),
            ':itemSize' => $item->getSize(),
            ':itemCost' => $item->getPrice()
        ];

        return $this->execute($sql, $args);
    }

    /**
     * @param Item $item
     * @return mixed
     */
    public function delete(Item $item)
    {
        $sql = <<<EOQ
DELETE FROM items WHERE item_id = :itemId
EOQ;
        $this->execute($sql, [':itemId' => $item->getId()]);
    }

    /**
     * @param ItemId $itemId
     * @return mixed
     * @throws \Scatchbling\Scratcher\Domain\Exception\DomainException
     */
    public function findById(ItemId $itemId)
    {
        $sql = <<<EOQ
SELECT * FROM items WHERE item_id = :itemId
EOQ;
        $rows = $this->query($sql, [':itemId' => $itemId->getId()]);

        if (count($rows) == 1) {
            return $this->buildItem($rows[0]);
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     * @throws \Scatchbling\Scratcher\Domain\Exception\DomainException
     */
    public function findAll(int $limit = 20, int $offset = 0)
    {
        $collection = [];
        $sql = <<<EOQ
SELECT * FROM items LIMIT $limit OFFSET $offset
EOQ;
        $rows = $this->query($sql, []);

        foreach ($rows as $row) {
            $collection[] = $this->buildItem($row);
        }

        return $collection;
    }

    /**
     * @param array $data
     * @return Item
     * @throws \Scatchbling\Scratcher\Domain\Exception\DomainException
     */
    private function buildItem(array $data)
    {
        $item = new Item(
            new ItemId($data['item_id']),
            $data['item_name'],
            $data['item_description'],
            $data['item_size'],
            $data['item_cost']
        );
        return $item;
    }
}