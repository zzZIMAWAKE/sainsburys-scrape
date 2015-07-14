<?php

use Sunra\PhpSimple\HtmlDomParser;

class WebScraper
{
    public static function getData($url) {
        return HtmlDomParser::str_get_html($url);
    }
}