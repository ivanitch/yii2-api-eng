<?php

namespace core\storage;

use yii\web\UploadedFile;

abstract class AbstractStorage
{
    /**
     * @var $file UploadedFile
     */
    protected $file;

    abstract static public function getPath(): string;
    abstract static public function getHostInfo(): string;
    abstract public function save(UploadedFile $file, $current = null): string;

    public static function deleteCurrentFile($current)
    {
        if ($current && self::fileExists($current)) {
            unlink(static::getPath() . $current);
        }
    }

    public function upload($file, $current = null): string
    {
        $this->file = $file;
        if (!is_null($current)) self::deleteCurrentFile($current);
        return $this->prepareFile();
    }

    protected function prepareFile(): string
    {
        $name = self::generateFileName();
        $path = $this->getPath();
        $this->createDir($path);
        $this->file->saveAs($path . $name);
        return $name;
    }

    private static function fileExists($file): bool
    {
        $file = $file ? static::getPath() . $file : null;
        return file_exists($file);
    }

    private function generateFileName(): string
    {
        do {
            $name = substr(md5(microtime() . rand(0, 1000)), 0, 32);
            $file = strtolower($name .'.'.$this->file->extension);
        } while (file_exists($file));
        return $file;
    }

    private function createDir($path): void
    {
        if (is_dir($path)) return;
        mkdir($path, 0777, true);
    }
}