<?php

namespace frontend\models\crawlerList;


use yii\db\IntegrityException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;


class CrawlerList extends \common\models\CrawlerList
{
    /**
     * @var $FileCategory UploadedFile
     * @var $FileProductList UploadedFile
     * @var $FileProductDetails UploadedFile
     */
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
            if ($this->validateFile($this->FileCategory,'FileCategory'))
                if ($this->validateFile($this->FileProductList,'FileProductList'))
                    if ($this->validateFile($this->FileProductDetails,'FileProductDetails'))
                        return true;
        return false;
    }

    private function getFileContent($fileName): string
    {
        $content = file_get_contents($fileName);
        $content = preg_replace('/[\t\n\r\0\x0B]/', '', $content);
        $content = preg_replace('/\s\s+/', ' ', $content);
        $content = preg_replace('/\s<+/', '<', $content);
        return preg_replace('/>\s+/', '>', $content);
    }

    private function validateFile($File,$field): bool
    {
        if (empty($File))
            return true;
        $content = $this->getFileContent($File->tempName);
        if (strpos($content, 'namespace ')) {
            $this->addError($field, 'فایل نباید namespace  داشته باشد');
            return false;
        }
        if (!strpos($content, 'class '.$field)) {
            $this->addError($field, 'نام کلاس صحیح نمی‌باشد');
            return false;
        }
        if (!strpos($content, 'public function fetch(')) {
            $this->addError($field, 'تابع fetch کامل نمی باشد');
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

    public function getDirectoryPath(): string
    {
        return '../models/crawlers/sites/_' . $this->CrawlerListId . '/';
    }
    public function getNameSpace(): string
    {
        return 'namespace frontend\models\crawlers\sites\_'.$this->CrawlerListId.";";
    }

    private function addNameSpaceToFile($fileName)
    {
        $content = $this->getFileContent($fileName);
        $newNameSpace = "<?php \r\n".$this->getNameSpace();
        $content = str_replace("<?php",$newNameSpace,$content);
        file_put_contents($fileName, $content);
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
        }
        catch (IntegrityException $e){
            $this->addError('Url', 'آدرس تکراری است');
        }
        catch (\Exception $e) {
        } catch (\Throwable $t) {
        }
        $transaction->rollBack();
        $path = $this->getDirectoryPath();
        FileHelper::removeDirectory($path);
        return false;
    }


    private function saveFiles(): bool
    {
        $dir = $this->getDirectoryPath();
        if (!is_dir($dir))
            FileHelper::createDirectory($dir, 0777);;
        if (!empty($this->FileCategory)) {
            $this->addNameSpaceToFile($this->FileCategory->tempName);
            $this->FileCategory->saveAs($dir . "/FileCategory.php");
        }
        if (!empty($this->FileProductDetails)) {
            $this->addNameSpaceToFile($this->FileProductDetails->tempName);
            $this->FileProductDetails->saveAs($dir . "/FileProductDetails.php");
        }
        if (!empty($this->FileProductList)) {
            $this->addNameSpaceToFile($this->FileProductList->tempName);
            $this->FileProductList->saveAs($dir . "/FileProductList.php");
        }
        return true;
    }

}
