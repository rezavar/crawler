<?php

namespace frontend\models;


use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


class CrawlerList extends \common\models\CrawlerList
{
    public $FileCategory;
    public $FileProductList;
    public $FileProductDetails;

    public function rules(): array
    {
        $rules = parent::rules();

        $fileRule = [
            ['FileCategory', 'FileProductList', 'FileProductDetails'],
            'file',
            'skipOnEmpty' => true,
            'extensions' => ['txt', 'php'],
            'checkExtensionByMimeType' => false,
            'mimeTypes' => ['text/plain', 'text/x-php', ''],
            'wrongMimeType' => 'فقط فایل11 php,txt قابل آپلود می باشد.',
            'maxSize' => 1024 * 10,
            'tooBig' => 'حداکثر سایز فایل 10 کیلو بایت می باشد.',
            'on' => 'update'
        ];
        array_push($rules, $fileRule);

        $fileRule['on'] = 'insert';
        $fileRule['skipOnEmpty'] = false;
        array_push($rules, $fileRule);

        return $rules;
    }

    public function setScenarioInsert()
    {
        $this->scenario = 'insert';
    }

    public function setScenarioUpdate()
    {
        $this->scenario = 'update';
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                "FileCategory" => "کدهای دسته بندی",
                "FileProductList" => "کدهای لیست محصول",
                "FileProductDetails" => "کدهای حزییات محصول ",
            ]
        );
    }

    public function load($data, $formName = null)
    {
        $load = parent::load($data, $formName);
        if ($load) {
            $this->FileCategory = UploadedFile::getInstance($this, 'FileCategory');
            $this->FileProductList = UploadedFile::getInstance($this, 'FileProductList');
            $this->FileProductDetails = UploadedFile::getInstance($this, 'FileProductDetails');
        }
        return $load;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if (parent::validate($attributeNames, $clearErrors))
            if ($this->validateFileCategory())
                if ($this->validateFileProductList())
                    if ($this->validateFileProductDetails()) {
                        return true;
                    }
        return false;
    }

    private function validateFileCategory(): bool
    {
        if (empty($this->FileCategory))
            return true;
        $content = $this->getFileContent($this->FileCategory->tempName);
        if (strpos($content, 'extend Cr') == false) {
            $this->addError('FileCategory', 'وراثت اشتباه');
            return false;
        }
        if (strpos($content, 'function ParsCategory()') == false) {
            $this->addError('FileCategory', 'تابع کامل نمیباشد');
            return false;
        }
        return true;
    }

    private function getFileContent($fileName): string
    {
        $content = file_get_contents($fileName);
        $content = preg_replace('/[\t\n\r\0\x0B]/', '', $content);
        $content = preg_replace('/\s\s+/', ' ', $content);
        $content = preg_replace('/\s<+/', '<', $content);
        return preg_replace('/>\s+/', '>', $content);
    }

    private function validateFileProductList(): bool
    {
        if (empty($this->FileProductList))
            return true;
        $content = $this->getFileContent($this->FileProductList->tempName);
        if (strpos($content, 'extend Cr') == false) {
            $this->addError('FileProductList', 'وراثت اشتباه');
            return false;
        }
        if (strpos($content, 'function ParsCategory()') == false) {
            $this->addError('FileProductList', 'تابع کامل نمیباشد');
            return false;
        }
        return true;
    }

    private function validateFileProductDetails(): bool
    {
        if (empty($this->FileProductDetails))
            return true;
        $content = $this->getFileContent($this->FileProductDetails->tempName);
        if (strpos($content, 'extend Cr') == false) {
            $this->addError('FileProductDetails', 'وراثت اشتباه');
            return false;
        }
        if (strpos($content, 'function ParsCategory()') == false) {
            $this->addError('FileProductDetails', 'تابع کامل نمیباشد');
            return false;
        }
        return true;
    }

    public function delete()
    {
        $path = $this->getDirectoryPath();
        $delete = parent::delete();
        if ($delete) {
            FileHelper::removeDirectory($path);
        }
        return $delete;
    }

    public function getDirectoryPath()
    {
        return '../models/crawlers/sites/' . $this->CrawlerListId . '/';
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (parent::save($runValidation, $attributeNames))
                if ($this->saveFiles()) {
                    $transaction->commit();
                    return true;
                }
        } catch (\Exception $e) {
        } catch (\Throwable $t) {
        }
        $transaction->rollBack();
        return false;
    }

    private function saveFiles(): bool
    {
        $dir = $this->getDirectoryPath();
        if (!is_dir($dir))
            FileHelper::createDirectory($dir, 0777);;
        if (!empty($this->FileCategory))
            $this->FileCategory->saveAs($dir . "/FileCategory.php");
        if (!empty($this->FileProductDetails))
            $this->FileProductDetails->saveAs($dir . "/FileProductDetails.php");
        if (!empty($this->FileProductList))
            $this->FileProductList->saveAs($dir . "/FileProductList.php");
        return true;
    }

}
