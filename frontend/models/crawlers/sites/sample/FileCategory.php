<?php

namespace frontend\models\crawlers\sites\_14;

use frontend\models\categories\CategoryStructure;
use frontend\models\crawlers\CrawlerHelper;


class FileCategory
{
    public function fetch($url,$name):?array
    {
        $dom = CrawlerHelper::GetClearDomFromUrl($url);
        $elements = $dom->find('.mm_columns_ul_tab li div.mm_tab_li_content');

        $list = (new CategoryStructure())->setTitle($name);
        foreach ($elements as $element) {

            $mainCategory = $element->find('.mm_tab_toggle_title a')->text;
            $mainCategory = (new CategoryStructure())->setTitle($mainCategory);
            $categories = $element->nextSibling()->find('.mm_block_type_category');
            foreach ($categories as $category) {
                $categoryLink = $category->find('h4 a');
                if (!count($categoryLink))
                    $categoryLink = $category->find('h4');

                $categoryLink = (new CategoryStructure())
                    ->setTitle($categoryLink->text)
                    ->setLink($categoryLink->getAttribute('href'));
                $subCategories = $category->find('.ets_mm_categories a');
                foreach ($subCategories as $subCategory) {
                    $link = $subCategory->getAttribute('href');
                    if (empty($link))
                        continue;
                    $subCategory = (new CategoryStructure())
                        ->setTitle($subCategory->text, false)
                        ->setLink($link, true);
                    $categoryLink->pushItems($subCategory );
                }
                $mainCategory->pushItems($categoryLink);
            }
            $list->pushItems($mainCategory);
        }
        return $list->toArray();
    }
}