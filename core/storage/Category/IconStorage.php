<?php

namespace core\storage\Category;

use core\entities\Category\Category;
use core\storage\AbstractStorage;
use core\storage\ResizeInterface;
use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

class IconStorage extends AbstractStorage implements ResizeInterface
{
    const PATH = '/category/';

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
        $name = $this->upload($file, $current);
        $path = self::getPath();
        self::resize($path . $name);
        return $name;
    }

    public static function resize($file): void
    {
        Image::resize($file, 200, 200)
            ->save($file, ['quality' => 80]);
    }


    public static function deleteIcon(Category $category)
    {
        if (is_null($category->icon) || ($category->icon === '')) return;
        self::deleteCurrentFile($category->icon);
        $category->icon = '';
    }
}