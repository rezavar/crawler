<?php

namespace frontend\models\crawlers;

use common\models\TreeMaker;
use frontend\models\crawlerList\CrawlerList;
use frontend\models\crawlers\sites\FileCategory;
use yii\helpers\ArrayHelper;

class CrawlerSites
{
    public function UpdateCategoriesOfSites($crawlerListId=null)
    {
        $siteUrls = CrawlerList::find()
            ->select(['CrawlerListId','Url','Name'])
            ->andWhere(['Status'=>CrawlerList::Enable]);

        if(!empty($crawlerListId))
            $siteUrls = $siteUrls->andWhere(['CrawlerListId'=>$crawlerListId]);

        $siteUrls = $siteUrls->all();

        foreach ($siteUrls as $siteUrl){
            $id = $siteUrl->CrawlerListId;
            $class = '\frontend\models\crawlers\sites\_'.$id.'\FileCategory';
            $crawl = \Yii::createObject($class);
            $list = $crawl->fetch($siteUrl->Url,$siteUrl->Name);
            TreeMaker::deleteAll(['CrawlerListIdRef'=>$id]);
            CrawlerHelper::makeTree($list,$id);
        }

        return true;

    }

}