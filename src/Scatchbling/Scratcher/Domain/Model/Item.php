<?php

namespace Scatchbling\Scratcher\Domain\Model;

use Scatchbling\Scratcher\Domain\Exception\DomainException;

/**
 * Class Scratcher
 * @package Scatchbling\Scratcher\Domain\Model
 */
class Item
{
    /**
     * SIZE_S
     */
    const SIZE_S = "S";
    /**
     * SIZE_M
     */
    const SIZE_M = "M";
    /**
     * SIZE_L
     */
    const SIZE_L = "L";
    /**
     * SIZE_XL
     */
    const SIZE_XL = "XL";

    /**
     * SIZES_MAP
     */
    const SIZES_MAP = [
        self::SIZE_S => self::SIZE_S,
        self::SIZE_M => self::SIZE_M,
        self::SIZE_L => self::SIZE_L,
        self::SIZE_XL => self::SIZE_XL,
    ];

    /**
     * Max length of name.
     */
    const MAX_LENGTH_NAME = 50;
    /**
     * Max length of description.
     */
    const MAX_LENGTH_DESCRIPTION = 1000;

    /**
     * @var ItemId
     */
    private $id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $size;
    /**
     * @var
     */
    private $price;

    /**
     * Scratcher constructor.
     * @param ItemId $itemId
     * @param string $name
     * @param string $description
     * @param string $size
     * @param float $price
     * @throws DomainException
     */
    public function __construct(ItemId $itemId, string $name, string $description, string $size, float $price)
    {
        $this->id = $itemId;
        $this->setName($name);
        $this->setDescription($description);
        $this->setSize($size);
        $this->setPrice($price);
    }

    /**
     * @return ItemId
     */
    public function getId(): ItemId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $name
     * @throws DomainException
     */
    public function setName(string $name)
    {
        if (empty($name)) {
            throw new DomainException("Name param is empty.");
        }
        if (strlen($name) > self::MAX_LENGTH_NAME) {
            throw new DomainException("Name param is too long.");
        }
        $this->name = $name;
    }

    /**
     * @param string $description
     * @throws DomainException
     */
    public function setDescription(string $description)
    {
        if (strlen($description) > self::MAX_LENGTH_DESCRIPTION) {
            throw new DomainException("Description param is too long");
        }
        $this->description = $description;
    }

    /**
     * @param string $size
     * @throws DomainException
     */
    public function setSize(string $size)
    {
        if (empty($size)) {
            throw new DomainException("Size param is empty.");
        }

        $sizes = explode(",", $size);
        foreach ($sizes as $value) {
            if (!array_key_exists($value, self::SIZES_MAP)) {
                throw new DomainException(sprintf("Size %s is not valid.", $value));
            }
        }

        $this->size = $size;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }
}