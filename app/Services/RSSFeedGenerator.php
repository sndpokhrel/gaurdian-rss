<?php

namespace App\Services;

use SimpleXMLElement;
use DOMDocument;

class RSSFeedGenerator
{
    public static function create(array $articles, string $section): string
    {
        $rss = new SimpleXMLElement('<rss version="2.0"></rss>');

        $channel = $rss->addChild('channel');
        $channel->addChild('language', 'en');
        $channel->addChild('title', "The Guardian - $section");
        $channel->addChild('link', 'https://www.theguardian.com');

        $channel->addChild('description', "Latest articles in $section");
        

        foreach ($articles as $article) {
            $item = $channel->addChild('item');

            $item->addChild('title', htmlspecialchars_decode($article['webTitle']));
            $item->addChild('link', $article['webUrl']);

            $item->addChild('description', htmlspecialchars_decode($article['fields']['trailText'] ?? 'No description available'));

            $item->addChild('pubDate', date(DATE_RSS, strtotime($article['webPublicationDate'] ?? '')));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');


        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        $dom->loadXML($rss->asXML());

        return $dom->saveXML();
    }
}
