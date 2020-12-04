<?php

namespace core\forms\manage\Category;

use core\entities\Category\Category;
use yii\base\Model;

class CategoryForm extends Model
{
    public $name;
    public $icon;

    private $category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->icon = $category->icon;
            $this->category = $category;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'max' => 100],
            ['icon', 'string', 'max' => 120],
            [['name'], 'unique', 'targetClass' => Category::class, 'filter' => $this->category ? ['<>', 'id', $this->category->id] : null]
        ];
    }
}