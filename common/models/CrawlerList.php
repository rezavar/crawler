<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_crawler_list".
 *
 * @property int $IdCrawlerList شناسه خزنده
 * @property string $Name نام خزنده
 * @property string $Url آدرس وب
 * @property string $CreateDate تاریخ ایجاد
 * @property string $UpdateDate تاریخ ویرایش
 */
class CrawlerList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_crawler_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Url'], 'required'],
            [['Name'], 'string', 'max' => 200],
            [['Url'], 'string', 'max' => 500],
            ['Url', 'url'],
            [['CreateDate', 'UpdateDate'], 'string', 'max' => 20],
            ['CreateDate', 'default', 'value' => \Yii::$app->PDate->asDatetime('now')],
            ['UpdateDate', 'default', 'value' => '']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdCrawlerList' => 'شناسه خزنده',
            'Name' => 'نام خزنده',
            'Url' => 'آدرس وب',
            'CreateDate' => 'تاریخ ایجاد',
            'UpdateDate' => 'تاریخ ویرایش',
        ];
    }
}
