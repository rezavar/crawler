<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

class CategoryTmpTree extends \kartik\tree\models\Tree
{
    public $icon_type=1;
    public $active=1;
    public $selected=0;
    public $disabled=0;
    public $readonly=1;
    public  $visible=1;
    public  $collapsed=0;
    public  $movable_u=0;
    public  $movable_d=0;
    public  $movable_l=0;
    public  $movable_r=0;
    public  $removable=0;
    public  $removable_all=0;
    public  $child_allowed=0;
    public  $icon=null;

    public static function tableName()
    {
        return 'tbl_tmp_category';
    }

    public function rules()
    {
        return [
            [['root','lft','rgt','lvl','CrawlerListIdRef'], 'integer'],
            [['root','lft','rgt','lvl','CrawlerListIdRef'], 'integer'],
            [['icon_type','active','selected','disabled','readonly','visible','collapsed'], 'integer'],
            [['movable_u','movable_d','movable_l','movable_r','removable','removable_all','child_allowed'], 'integer'],
            [['key','name','icon'], 'string'],
            [['key'], 'string', 'max' => 32, 'tooLong' => 'حداکثر 32 کاراکتر میتوانید وارد کنید.'],
            [['name'], 'string', 'max' => 100, 'tooLong' => 'حداکثر 100 کاراکتر میتوانید وارد کنید.'],
            [['icon'], 'string', 'max' => 150, 'tooLong' => 'حداکثر 150 کاراکتر میتوانید وارد کنید.'],
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'root',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'lvl',
            ],
        ];
    }
}