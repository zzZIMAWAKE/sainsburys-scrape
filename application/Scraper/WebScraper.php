<?php

    namespace application\scraper;

    use Goutte\Client;
    use application\model\Item;

    class WebScraper
    {
        protected $crawler;
        protected $client;

        public function __construct($url = null)
        {
            if ($url === null) {
                throw new \Exception('No URL provided');
            }

            $this->url     = $url;
            $this->client  = $this->getClient();
            $this->crawler = $this->getRequest();
        }

        public function getItems()
        {
            $items = [];

            $items['results'] = $this->crawler->filter('.product')->each(
                function ($node) {
                    $item = new Item();

                    //Set title
                    $item->setTitle($this->getItemTitle($node));

                    //Prepare and set price
                    $item->setUnitPrice($this->getItemUnitPrice($node));

                    //Prepare and set Description
                    $itemLink = $node->filter('.productInfo h3 a')->link();
                    $itemPage = $this->client->click($itemLink);

                    $item->setDescription($this->getItemDescription($itemPage));

                    //Prepare and set size
                    $item->setSize($this->getPageSize($itemPage));

                    return $item->getObjectAsArray();
                }
            );

            $items['total'] = $this->getItemsTotal($items);

            return $items;
        }

        public function getPageSize($url)
        {
            return round(strlen($url->text()) / 1024) . "kb";
        }

        public function getItemsTotal($items) 
        {
            $total = 0;

            foreach ($items['results'] as $item) {
                $total += $item['unitPrice'];
            }

            return number_format($total, 2);
        }

        public function getItemDescription($itemPage)
        {
            return trim($itemPage->filter('.productText')->text());
        }

        public function getItemTitle($node)
        {
            return trim($node->filter('.productInfo h3 a')->text());
        }

        public function getItemUnitPrice($node)
        {
            $priceStr = explode('/', $node->filter('.pricePerUnit')->text())[0];
            $price = (float) substr(trim($priceStr), 2);

            return number_format($price,2);
        }

        private function getClient()
        {
            return new Client();
        }

        private function getRequest()
        {
            return $this->client->request('GET', $this->url);
        }
    }