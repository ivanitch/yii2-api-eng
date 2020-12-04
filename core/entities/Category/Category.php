<?php

namespace core\entities\Category;
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

    public static function create($name, $icon): self
    {
        $category = new static();
        $category->name = $name;
        $category->icon = $icon;
        return $category;
    }

    public function edit($name, $icon): void
    {
        $this->name = $name;
        $this->icon = $icon;
    }
}
