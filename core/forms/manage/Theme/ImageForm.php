<?php

namespace core\forms\manage\Theme;

use yii\base\Model;
use yii\web\UploadedFile;

class ImageForm extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 512000 * 4
            ],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->image = UploadedFile::getInstance($this, 'image');
            return true;
        }
        return false;
    }
}