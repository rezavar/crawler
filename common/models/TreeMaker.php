<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

class TreeMaker extends \kartik\tree\models\Tree
{
    public static function tableName()
    {
        return 'tbl_tree';
    }

    public function rules()
    {
        return [
            [['root','lft','rgt','lvl','crawlerListIdRef'], 'integer'],
            [['root','lft','rgt','lvl','crawlerListIdRef'], 'integer'],
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