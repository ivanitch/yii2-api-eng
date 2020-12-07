<?php

namespace core\forms\manage\Category;

use yii\base\Model;
use yii\web\UploadedFile;

class IconForm  extends Model
{
    public $icon;

    public function rules()
    {
        return [
            [['icon'], 'file',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 512000 * 4
            ],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->icon = UploadedFile::getInstance($this, 'icon');
            return true;
        }
        return false;
    }
}