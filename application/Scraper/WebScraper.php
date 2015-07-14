<?php

use Goutte\Client;

class WebScraper
{
    protected $crawler;
    protected $client;

    public function __construct($url = null)
    {
        if ($url === null) {
            throw new Exception('No URL provided');
        }

        $this->client = new Client();
        $this->crawler = $this->client->request('GET', $url);
    }

    public function getItems()
    {
        $items = [];

        $items[] = $this->crawler->filter('.product')->each(
            function ($node) {
                $item = new Item();
                $item->setTitle(trim(
                    $node->filter('.productInfo h3 a')->text()
                ));

                $price = explode('/', $node->filter('.pricePerUnit')->text())[0];
                $item->setUnitPrice(
                    (float) substr(trim($price), 2)
                ));

                $itemLink = $node->filter('.productInfo h3 a')->link();
                $itemPage = $this->client->click($itemLink);

                $item->setDescription(trim(
                    $itemPage->filter('.productText')->text()
                ));

                $pageSize = $this->getPageSize($itemPage);
                $item->setSize($pageSize);

                return $item;
            }
        );

        return $items;
    }

    function getPageSize($url) {
        return round(strlen($url->text()) / 1024) . "kb" ;
    }

}