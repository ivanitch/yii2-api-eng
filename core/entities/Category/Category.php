<?php

namespace core\entities\Category;
use core\storage\Category\IconStorage;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 */
class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
    }

    public static function create(string $name, string $icon): self
    {
        $category = new static();
        $category->name = $name;
        $category->icon = $icon;
        return $category;
    }

    public function edit(string $name, string $icon): void
    {
        $this->name = $name;
        $this->icon = ($icon !== '') ? $icon : $this->icon;
    }

    public function getIconPath()
    {
        if ($this->icon) return IconStorage::getHostInfo() . $this->icon;
        return 'https://via.placeholder.com/100x100';
    }

    public function beforeDelete()
    {
        IconStorage::deleteIcon($this);
        return parent::beforeDelete();
    }
}
