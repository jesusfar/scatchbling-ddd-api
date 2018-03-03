<?php

namespace Scatchbling\Item\Application\Request;


/**
 * Class ItemRequest
 * @package Scatchbling\Item\Application\Request
 */
class ItemRequest
{
    private $name;
    private $description;
    private $size;
    private $price;

    /**
     * CreateItemRequest constructor.
     * @param $name
     * @param $description
     * @param $size
     * @param $price
     */
    public function __construct($name, $description, $size, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->size = $size;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}