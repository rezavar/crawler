<?php

namespace common\models;

use kartik\tree\TreeView;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "tbl_category".
 *
 * @property int $CategoryId شناسه دسته
 * @property int $CrawlerListIdRef شناسه خزنده
 * @property string $Key کلید تولید شده بر اساس نام یا لینک
 
 * @property string $Name نام دسته
 * @property string|null $Url آدرس
 * @property int $Status وضعیت
 * @property string|null $OurName نام در سایت 
 * @property string|null $OurCategoryId شناسه در سایت
 * @property int $selected انتخاب جهت بروز رسانی لینک
 * @property int|null $root شناسه روت
 * @property int $lft شناسه نود سمت چپ
 * @property int $rgt شناسه نود سمت راست
 * @property int $lvl سطح نود
 */
class Category extends  \kartik\tree\models\Tree
{
    const NewRecord = 0;
    const DeleteRecord = 1;
    const AcceptRecord = 2;


    public $icon_type=1;
    public $active=1;
    public $disabled=0;
    public $readonly=1;
    public  $visible=1;
    public  $collapsed=0;
    public  $movable_u=0;
    public  $movable_d=0;
    public  $movable_l=0;
    public  $movable_r=0;
    public  $removable=1;
    public  $removable_all=0;
    public  $child_allowed=0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_category';
    }
//
    public function behaviors() {

        $behaviors = parent::behaviors();
        $module = TreeView::module();
        $module->dataStructure["keyAttribute"] = 'CategoryId';
        $module->dataStructure["nameAttribute"] = 'Name';
        return $behaviors;

    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CrawlerListIdRef', 'Key', 'Name', 'lft', 'rgt', 'lvl'], 'required'],
            [['CrawlerListIdRef', 'Status', 'selected', 'root', 'lft', 'rgt', 'lvl'], 'integer'],
            [['Key'], 'string', 'max' => 32],
            [['Name', 'OurName'], 'string', 'max' => 250],
            [['Url'], 'string', 'max' => 500],
            [['OurCategoryId'], 'string', 'max' => 50],
            ['Status', 'default', 'value' => self::NewRecord],
            ['selected', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CategoryId' => 'شناسه دسته',
            'CrawlerListIdRef' => 'شناسه خزنده',
            'Key' => 'کلید تولید شده بر اساس نام یا لینک',
            'Name' => 'نام دسته',
            'Url' => 'آدرس',
            'Status' => 'وضعیت',
            'OurName' => 'نام در سایت ',
            'OurCategoryId' => 'شناسه در سایت',
            'selected' => 'انتخاب جهت بروز رسانی لینک',
            'root' => 'شناسه روت',
            'lft' => 'شناسه نود سمت چپ',
            'rgt' => 'شناسه نود سمت راست',
            'lvl' => 'سطح نود',
        ];
    }

    public function FillFromTmpCategory($CrawlerListId)
    {
        $TmpListCategories = CategoryTmpTree::find()->andWhere(['CrawlerListIdRef'=>$CrawlerListId])->asArray()->all();
        $TmpListCategories = array_chunk($TmpListCategories,2);
        foreach ($TmpListCategories as $TmpCategories)
            $this->BatchInsertOrUpdate($TmpCategories);
        self::updateAll([
            'Status'=>self::DeleteRecord,
            'icon'=>'minus-circle',
            'root'=>0,
            'lft'=>1,
            'rgt'=>2,
            'lvl'=>1,
        ],[
            'And',
            ["NOT IN",
                "Key",
                (new \yii\db\Query())->select("key")
                    ->from(CategoryTmpTree::tableName())
                    ->where(["=", "CrawlerListIdRef", $CrawlerListId])]
            ,[
                'CrawlerListIdRef'=>$CrawlerListId
            ]
        ]);
        self::updateAll(
            ['icon'=>'plus-circle'],
            [
                'AND',
                ['Status'=>self::NewRecord],
                ['CrawlerListIdRef'=>$CrawlerListId],
                [
                    'rgt' => new Expression('`lft`+1')
                ]
            ]
        );
        //<font-awesome-icon :icon="['fas', 'check-circle']" />
    }

    private function BatchInsertOrUpdate($TmpCategories)
    {
        $att = [
            'CrawlerListIdRef',
            'Key',
            'Name',
            'Url',
            'root',
            'lft',
            'rgt',
            'lvl'
        ];
        foreach ($TmpCategories as $i=>$category)
            $TmpCategories[$i]=[
                'CrawlerListIdRef'=>$category['CrawlerListIdRef'],
                'Key'=>$category['key'],
                'Name'=>$category['name'],
                'Url'=>$category['url'],
                'root'=>$category['root'],
                'lft'=>$category['lft'],
                'rgt'=>$category['rgt'],
                'lvl'=>$category['lvl']
            ];
        $update = ' `Name`=values(`Name`),`Url`=values(`Url`), `root`=values(`root`), `lft`=values(`lft`), `rgt`=values(`rgt`), `lvl`=values(`lvl`)';
        $sql = \Yii::$app->db->queryBuilder->batchInsert(self::tableName(), $att, $TmpCategories);
        return \Yii::$app->db->createCommand($sql . ' ON DUPLICATE KEY UPDATE ' . $update)->execute();
    }
}
