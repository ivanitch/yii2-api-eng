<?php

namespace core\storage\Word;

use core\entities\Word\Word;
use core\storage\AbstractStorage;
use core\storage\ResizeInterface;
use yii\imagine\Image;
use yii\web\UploadedFile;
use Yii;

class ImageStorage extends AbstractStorage implements ResizeInterface
{
    const PATH = '/word/';

    static public function getPath(): string
    {
        return Yii::$app->params['storagePath'] . self::PATH;
    }

    static public function getHostInfo(): string
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
        $name = $this->upload($file, $current);
        $path = self::getPath();
        self::resize($path . $name);
        return $name;
    }

    public static function resize($file): void
    {
        Image::resize($file, 300, 200)
            ->save($file, ['quality' => 80]);
    }

    public static function deleteImage(Word $model): void
    {
        if (($model->image === '') || is_null(($model->image))) return;
        ImageStorage::deleteCurrentFile($model->image);
        $model->image = '';
    }
}