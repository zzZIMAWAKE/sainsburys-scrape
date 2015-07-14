<?php

class Parser
{
    public static function getItems($html)
    {
        var_dump($html);
        foreach($html->find('div.product') as $product) {
            $item['title']     = $product->find('div.productInfo h3 a', 0)->plaintext;
            $item['intro']    = $product->find('div.intro', 0)->plaintext;
            $item['details'] = $product->find('div.details', 0)->plaintext;
            $products[] = $item;
        }
        $items = $html->find('div.product');
        var_dump($items);
    }
}