<?php
namespace frontend\models\categories;

use common\models\CategoryTmpTree;
use yii\base\Model;

class CategoriesSelectForm extends Model
{

    public $category_list;

    public function rules()
    {
        return [
            [['category_list'], 'safe'],
            [['category_list'], 'each', 'rule' => ['filter', 'filter' => 'trim']],
            [['category_list'], 'each', 'rule' => ['integer']],
        ];
    }

    public function load($data, $formName = null)
    {
        $load = parent::load($data, $formName);
        if($load && $this->category_list)
            $this->category_list = explode(',',$this->category_list);
    }

    public function save()
    {
        CategoryTmpTree::UpdateAll(['selected'=>0]);
        $this->category_list = array_chunk($this->category_list,50);
        foreach ($this->category_list as $list)
            CategoryTmpTree::UpdateAll(['selected'=>1],['in','id',$list]);
    }

}