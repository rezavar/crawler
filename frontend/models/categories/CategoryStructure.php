<?php

namespace frontend\models\categories;


class CategoryStructure
{
    private string $title='';
    private string $key='';
    private ?string $link='';
    private array $items=[];


    public function setTitle(?string $title,$setKeyFromName =  true): CategoryStructure
    {
       $this->title = $title;
       if($setKeyFromName)
           $this->key = md5($title);
       return $this;
    }

    public function setLink(?string $link,$setKeyFromLink =  false): CategoryStructure
    {
        $this->link = $link;
        if($setKeyFromLink)
            $this->key = md5($link);
        return $this;
    }

    public function pushItems(CategoryStructure $item): CategoryStructure
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