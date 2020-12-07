<?php

namespace core\storage\Word;

use core\entities\Word\Word;
use core\storage\AbstractStorage;
use Yii;
use yii\web\UploadedFile;

class SoundStorage extends AbstractStorage
{
    const PATH = '/sound/';

    public static function getPath(): string
    {
        return Yii::$app->params['storagePath'] . self::PATH;
    }

    public static function getHostInfo(): string
    {
        return Yii::$app->params['storageHostInfo'] . self::PATH;
    }

    /**
     * @param UploadedFile $file
     * @param null $current
     * @return string
     */
    public function save(UploadedFile $file, $current = null): string
    {
        return $this->upload($file, $current);
    }

    /**
     * @param Word $model
     */
    public static function deleteSound(Word $model): void
    {
        if (($model->sound === '') || is_null(($model->sound))) return;
        SoundStorage::deleteCurrentFile($model->sound);
        $model->sound = '';
    }
}