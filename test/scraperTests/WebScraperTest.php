<?php

    class WebScraperTest extends PHPUnit_Framework_TestCase
    {
        public function testConstructorThrowsExceptionIfNoUrlProvided()
        {
            $expected = 'No URL provided';

            try {
                new application\scraper\WebScraper();
            }
            catch (\Exception $e) {
                $this->assertEquals($e->getMessage(), $expected);
            }
        }

        public function testGetPageSizeIsSetByLengthOfString()
        {
            $urlMock =
                $this->getMockBuilder('\stdClass')
                     ->disableOriginalConstructor()
                     ->setMethods(['text'])
                     ->getMock();

            $webScraperMock =
                $this->getMockBuilder('application\scraper\WebScraper')
                     ->disableOriginalConstructor()
                     ->setMethods(null)
                     ->getMock();

            $urlTextMock = uniqid();

            $expectedOutput = round(strlen($urlTextMock) / 1024) . "kb";

            $urlMock->expects($this->once())
                    ->method('text')
                    ->will($this->returnValue($urlTextMock));

            $webScraperMock->getPageSize($urlMock);
        }

        public function testGetItemDescription()
        {
            $webScraperMock =
                $this->getMockBuilder('application\scraper\WebScraper')
                     ->disableOriginalConstructor()
                     ->setMethods(null)
                     ->getMock();

            $itemPageMock =
                $this->getMockBuilder('\stdClass')
                     ->disableOriginalConstructor()
                     ->setMethods(['text', 'filter'])
                     ->getMock();

            $itemPageMock->expects($this->once())
                         ->method('text')
                         ->will($this->returnValue(''));

            $itemPageMock->expects($this->once())
                         ->method('filter')
                         ->with('.productText')
                         ->willReturnSelf();

            $webScraperMock->getItemDescription($itemPageMock);
        }

        public function testGetItemTitle()
        {
            $webScraperMock =
                $this->getMockBuilder('application\scraper\WebScraper')
                     ->disableOriginalConstructor()
                     ->setMethods(null)
                     ->getMock();

            $itemPageMock =
                $this->getMockBuilder('\stdClass')
                     ->disableOriginalConstructor()
                     ->setMethods(['text', 'filter'])
                     ->getMock();

            $itemPageMock->expects($this->once())
                         ->method('text')
                         ->will($this->returnValue(''));

            $itemPageMock->expects($this->once())
                         ->method('filter')
                         ->with('.productInfo h3 a')
                         ->willReturnSelf();

            $webScraperMock->getItemTitle($itemPageMock);
        }

        public function testGetUnitPrice()
        {
            $webScraperMock =
                $this->getMockBuilder('application\scraper\WebScraper')
                     ->disableOriginalConstructor()
                     ->setMethods(null)
                     ->getMock();

            $itemPageMock =
                $this->getMockBuilder('\stdClass')
                     ->disableOriginalConstructor()
                     ->setMethods(['text', 'filter'])
                     ->getMock();

            $itemPageMock->expects($this->once())
                         ->method('text')
                         ->will($this->returnValue('£150/asdjahsda'));

            $itemPageMock->expects($this->once())
                         ->method('filter')
                         ->with('.pricePerUnit')
                         ->willReturnSelf();

            $result = $webScraperMock->getItemUnitPrice($itemPageMock);

            $this->assertEquals($result, '150.00');
        }
    }