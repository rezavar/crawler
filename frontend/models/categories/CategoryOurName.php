<?php

namespace frontend\models\categories;

use common\models\Category;
use yii\base\Model;

class CategoryOurName extends Model
{
    public $CategoryId;
    public $OurName;
    public $OurCategoryId;
    public $selected;

    public function rules()
    {
        return [
            [['OurName', 'OurCategoryId','CategoryId','selected'], 'safe'],
            [['OurName', 'OurCategoryId','CategoryId'], 'filter','filter'=>'trim'],
            [['OurName'], 'string', 'max' => 250],
            [['OurCategoryId'], 'string', 'max' => 50],
            [['CategoryId','selected'],'integer'],
            ['selected', 'default', 'value' => 0],
            ['selected', 'filter', 'filter' => fn($value)=>boolval($value)],
        ];
    }

    public function formName(): string
    {
        return (new Category())->formName();
    }

    public function saveOurName()
    {
        if((empty($this->OurName) || empty($this->OurCategoryId) )&& $this->selected){
            \Yii::$app->session->setFlash('error','وارد کردن نام و آی دی اجباری است.');
            return false;
        }

        $category = Category::findOne($this->CategoryId);
        $category->selected = $this->selected?1:0;
        $category->OurCategoryId = $this->OurCategoryId;
        $category->OurName = $this->OurName;
        if(!empty($this->OurName) && !empty($this->OurCategoryId)) {
            $category->Status = Category::AcceptRecord;
        }
        if($category->Status == Category::AcceptRecord)
            $category->icon= 'check-circle';
        elseif ($category->Status== Category::NewRecord)
            $category->icon = 'plus-circle';
        return $category->save();
    }
}