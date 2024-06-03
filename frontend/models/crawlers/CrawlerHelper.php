<?php

namespace frontend\models\crawlers;

use common\models\TreeMaker;
use PHPHtmlParser\Dom;

class CrawlerHelper
{

    public static function GetClearDomFromUrl($Url): Dom
    {

        $dom = new Dom();
        $dom->loadFromFile($Url, [
            'whitespaceTextNode' => false,
            'removeDoubleSpace' => true
        ]);
        $text = $dom->innerHtml;

        $text = preg_replace("/&#?[a-z0-9]+;/i", "", $text);
        $text = str_replace(['<br />', '<hr />', '<b>', '</b>', '<strong>', '</strong>'], "", $text);
        $pattern = "/<[^\/>][^>]*><\/[^>]+>/";
        $text = preg_replace($pattern, '', $text);
        $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = preg_replace('/\s<+/', '<', $text);
        $text = preg_replace('/>\s+/', '>', $text);
        return $dom->loadStr($text);

    }

    public static function makeTree($node, $crawlerListIdRef, $tree = null)
    {
        if (empty($node))
            return;

        $name = $node['title'];
        $key = @$node['key'] ?? '';
        $leaf = new TreeMaker(['name' => $name, 'crawlerListIdRef' => $crawlerListIdRef, 'key' => $key]);
        if (empty($tree))
            $leaf->makeRoot();
        else
            $leaf->appendTo($tree);

        if (!empty($node['items']))
            foreach ($node['items'] as $item)
                self::makeTree($item, $crawlerListIdRef, $leaf);
    }

}