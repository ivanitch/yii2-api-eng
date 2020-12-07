<?php

namespace core\storage\Theme;

use core\entities\Theme\Theme;
use core\storage\AbstractStorage;
use core\storage\ResizeInterface;
use yii\imagine\Image;
use yii\web\UploadedFile;
use Yii;

class ImageStorage extends AbstractStorage implements ResizeInterface
{
    const PATH = '/theme/';

    public static function getPath(): string
    {
        return Yii::$app->params['storagePath'] . self::PATH;
    }

    public static function getHostInfo(): string
    {
        return Yii::$app->params['storageHostInfo'] . self::PATH;
    }

    public static function resize($file): void
    {
        Image::resize($file, 300, 200)
            ->save($file, ['quality' => 80]);
    }

    public function save(UploadedFile $file, $current = null): string
    {
        $name = $this->upload($file, $current);
        $path = self::getPath();
        self::resize($path . $name);
        return $name;
    }

    public static function deleteImage(Theme $model)
    {
        if (is_null($model->image) || ($model->image === '')) return;
        self::deleteCurrentFile($model->image);
        $model->image = '';
    }
}