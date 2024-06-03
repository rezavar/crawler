<?php

namespace frontend\models\crawlers;

use common\models\TreeMaker;
use frontend\models\categories\CategoryStructure;

class Takhfifaneh
{
    const CategoryUrl = '../files/1.html';

    function ParsCategory()
    {
        $dom = CrawlerHelper::GetClearDomFromUrl(self::CategoryUrl);
        $elements = $dom->find('.mm_columns_ul_tab li div.mm_tab_li_content');

        $list = (new CategoryStructure())->setTitle('تخفیفانه');
        foreach ($elements as $i => $element) {

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

    public function saveCategory($list)
    {
        TreeMaker::deleteAll(['CrawlerListIdRef'=>1]);
        CrawlerHelper::makeTree($list,1);
    }

}
