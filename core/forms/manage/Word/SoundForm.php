<?php

namespace core\forms\manage\Word;

use yii\base\Model;
use yii\web\UploadedFile;

class SoundForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file',
                'extensions' => ['wav', 'mp3'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 512000 * 4
            ],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

    public function attributeLabels(): array
    {
        return [
            'file' => 'Sound'
        ];
    }
}