<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_crawler_list".
 *
 * @property int $CrawlerListId شناسه خزنده
 * @property string $CrawlerListKey شناسه لینک
 * @property string $Name نام خزنده
 * @property string $Url آدرس وب
 * @property string $CreateDate تاریخ ایجاد
 * @property int $Status تاریخ ویرایش
 */
class CrawlerList extends \yii\db\ActiveRecord
{
    const Disable = 0;
    const Enable = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_crawler_list';
    }

    public static function Status_Str($Status): string
    {
        if ($Status == self::Enable)
            return 'فعال';
        if ($Status == self::Disable)
            return 'غیر‌فعال';
        return $Status . '';
    }

    public static function Status_Arr(): array
    {
        return [
            self::Enable => 'فعال',
            self::Disable => 'غیر‌فعال'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Url'], 'required'],
            ['Status', 'integer'],
            [['Name'], 'string', 'max' => 200,'min'=>5],
            [['Url'], 'string', 'max' => 500,'min'=>6],
            ['Url', 'url'],
            ['Url', 'filter', 'filter' => 'trim'],
            ['Url', 'filter', 'filter' => fn($value) => rtrim($value,'/')],
            [['CreateDate'], 'string', 'max' => 20],
            ['CreateDate', 'default', 'value' => \Yii::$app->PDate->asDatetime('now')],
            ['Status', 'default', 'value' => self::Disable],
            ['CrawlerListKey', 'filter', 'filter' => function () {
                return md5($this->Url);
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CrawlerListId' => 'شناسه خزنده',
            'CrawlerListKey' => 'شناسه لینک',
            'Name' => 'نام خزنده',
            'Url' => 'آدرس وب',
            'CreateDate' => 'تاریخ ایجاد',
            'Status' => 'وضعیت'
        ];
    }
}
