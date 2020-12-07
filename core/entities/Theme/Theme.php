<?php

namespace core\entities\Theme;

use core\entities\Category\Category;
use core\entities\Level\Level;
use core\storage\Theme\ImageStorage;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%theme}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $level_id
 * @property string $name
 * @property string $image
 *
 * @property Category $category
 * @property Level $level
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%theme}}';
    }

    public static function create(int $category_id, int $level_id, string $name, string $image): self
    {
        $theme = new static();
        $theme->category_id = $category_id;
        $theme->level_id = $level_id;
        $theme->name = $name;
        $theme->image = $image;
        return $theme;
    }

    public function edit(int $category_id, int $level_id, string $name, string $image): void
    {
        $this->category_id = $category_id;
        $this->level_id = $level_id;
        $this->name = $name;
        $this->image = ($image !== '') ? $image : $this->image;
    }

    public function getImagePath()
    {
        if ($this->image) return $this->storage()->getHostInfo() . $this->image;
        return 'https://via.placeholder.com/100x100';
    }

    public function deleteImage(): bool
    {
        if (!is_null($this->image) || $this->image !== '') {
            $this->storage()->deleteCurrentFile($this->image);
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    private function storage(): ImageStorage
    {
        return new ImageStorage();
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLevel(): ActiveQuery
    {
        return $this->hasOne(Level::class, ['id' => 'level_id']);
    }
}
