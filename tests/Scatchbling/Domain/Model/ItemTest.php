<?php

namespace Scatchbling\Domain\Model;

/**
 * Class ItemTest
 * @package Scatchbling\Domain\Model
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @test
     * @group item
     * @dataProvider dataItemProvider
     * @param $name
     * @param $description
     * @param $size
     * @param $price
     * @throws \Scatchbling\Domain\Exception\DomainException
     */
    public function constructNewItem($name, $description, $size, $price) {
        $item = new Item($name, $description, $size, $price);

        $this->assertNotNull($item);
        $this->assertNotNull($item->getId());
        $this->assertEquals($name, $item->getName());
        $this->assertEquals($description, $item->getDescription());
        $this->assertEquals($size, $item->getSize());
        $this->assertEquals($price, $item->getPrice());
    }

    /**
     * dataItemProvider
     * @return array
     */
    public function dataItemProvider() {
        $testCase1 = [
            "The Itcher",
            "Scratch any itch",
            "XL",
            27.00
        ];

        $testCase2 = [
            "The Blinger",
            "Diamonds",
            "L",
            343.00
        ];

        $testCase3 = [
            "Glitz and Gold",
            "Gold handle and fancy emeralds make this shine",
            "XL,L,M,S",
            4343.00
        ];

        return [
          $testCase1, $testCase2, $testCase3,
        ];
    }


    /**
     * @dataProvider invalidDataItemProvider
     * @expectedException \Scatchbling\Domain\Exception\DomainException
     * @param $name
     * @param $description
     * @param $size
     * @param $price
     * @throws \Scatchbling\Domain\Exception\DomainException
     */
    public function constructNewItemThrowsDomainException($name, $description, $size, $price) {
        $item = new Item($name, $description, $size, $price);
    }

    /**
     * @return array
     */
    public function invalidDataItemProvider() {
        $testCase1 = [
            "Invalid",
            "Invalid size",
            "XXXXL",
            27.00
        ];

        $testCase2 = [
            "",
            "Empty name",
            "L",
            343.00
        ];

        $testCase3 = [
            "Glitz and Gold",
            "Empty size",
            "",
            4343.00
        ];

        return [
            $testCase1, $testCase2, $testCase3,
        ];
    }
}
