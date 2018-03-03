<?php

namespace Scatchbling\Item\Infrastructure\persistence\pdo;


use Scatchbling\Item\Domain\Model\Item;
use Scatchbling\Item\Domain\Model\ItemId;
use Scatchbling\Item\Domain\Model\ItemRepository;

/**
 * Class PDOItemRepository
 * @package Scatchbling\Item\Infrastructure\persistence\pdo
 */
class PDOItemRepository extends PDORepository implements ItemRepository
{

    /**
     * @param Item $item
     * @return mixed
     */
    public function save(Item $item)
    {
        $sql = <<<EOQ
INSERT INTO items(item_id, item_name, item_description, item_size, item_cost) 
VALUES (:itemId, :itemName, :itemDescription, :itemSize, :itemCost)
EOQ;

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
DELETE FROM items WHERE item_id == :itemId
EOQ;
        return $this->execute($sql, [':itemId' => $item->getId()]);
    }

    /**
     * @param ItemId $itemId
     * @return mixed
     */
    public function findById(ItemId $itemId)
    {
        $sql = <<<EOQ
SELECT * FROM items WHERE item_id == :itemId
EOQ;
        $rows = $this->query($sql, [':itemId' => $itemId->getId()]);

        return $this->buildItem($rows[0]);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function findAll(int $limit = 20, int $offset = 10)
    {
        $collection = [];
        $sql = <<<EOQ
SELECT * FROM items LIMIT :limit OFFSET :offset
EOQ;
        $rows = $this->query($sql, [
            ':limit' => $limit,
            ':offset' => $offset,
        ]);

        foreach ($rows as $row) {
            $collection[] = $this->buildItem($row);
        }

        return $collection;
    }

    /**
     * @param array $item
     * @return Item
     * @throws \Scatchbling\Item\Domain\Exception\DomainException
     */
    private function buildItem(array $item)
    {
        return new Item();
    }
}