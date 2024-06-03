<?php

namespace frontend\models\crawlers;


class CrawlerCategoryStructure
{
    private string $title='';
    private string $key='';
    private ?string $link='';
    private array $items=[];


    public function setTitle(?string $title,$setKeyFromName =  true): CrawlerCategoryStructure
    {
       $this->title = $title;
       if($setKeyFromName)
           $this->key = md5($title);
       return $this;
    }

    public function setLink(?string $link,$setKeyFromLink =  false): CrawlerCategoryStructure
    {
        $this->link = $link;
        if($setKeyFromLink)
            $this->key = md5($link);
        return $this;
    }

    public function pushItems(CrawlerCategoryStructure $item): CrawlerCategoryStructure
    {
        $this->items[] = $item->toArray();
        return $this;
    }

    public function getTreeField(): array
    {
        return[
            'name'=>$this->title,
            'key'=>$this->key,
        ];
    }

    public function toArray(): array
    {
        return[
            'title'=>$this->title,
            'key'=>$this->key,
            'link'=>$this->link,
            'items'=>$this->items
        ];
    }
}