<?php

    use application\model\Item;

    class ItemTest extends PHPUnit_Framework_TestCase
    {
        public function testGetSetTitle()
        {
            $mock = new Item();
            $value  = uniqid();

            $mock->setTitle($value);

            $this->assertEquals($mock->getTitle(), $value);
        }

        public function testGetSetSize()
        {
            $mock = new Item();
            $value  = rand(1, 100);

            $mock->setSize($value);

            $this->assertEquals($mock->getSize(), $value);
        }

        public function testGetSetDescription()
        {
            $mock = new Item();
            $value  = uniqid();

            $mock->setDescription($value);

            $this->assertEquals($mock->getDescription(), $value);
        }

        public function testGetSetUnitPrice()
        {
            $mock = new Item();
            $value  = uniqid();

            $mock->setUnitPrice($value);

            $this->assertEquals($mock->getUnitPrice(), $value);
        }

        public function testGetObjectAsArrayReturnsArray()
        {
            $mock = new Item();
            $arrayMock = $mock->getObjectAsArray();

            $this->assertTrue(is_array($arrayMock));
        }
    }