<?php

    class ItemListControllerTest extends PHPUnit_Framework_TestCase
    {
        public function testGetItemJsonCallsTheCorrectMethods()
        {
            $webScraperMock = 
                $this->getMockBuilder('application\scraper\WebScraper')
                     ->disableOriginalConstructor()
                     ->setMethods(['getItems'])
                     ->getMock();

            $controllerMock = 
                $this->getMockBuilder('application\controller\ItemListController')
                     ->setMethods(['printJson', 'getWebScraper'])
                     ->getMock();

            $controllerMock->expects($this->once())
                           ->method('getWebScraper')
                           ->will($this->returnValue($webScraperMock));

            $webScraperMock->expects($this->once())
                           ->method('getItems')
                           ->will($this->returnValue([]));

            $controllerMock->expects($this->once())
                           ->method('printJson')
                           ->with(json_encode([], JSON_PRETTY_PRINT))
                           ->will($this->returnValue(true));

            $controllerMock->getItemJson();
        }
    }