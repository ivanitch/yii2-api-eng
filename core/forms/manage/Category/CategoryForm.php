<?php

namespace core\forms\manage\Category;

use core\entities\Category\Category;
use core\forms\CompositeForm;
/**
 * @property IconForm $icon;
 */

class CategoryForm extends CompositeForm
{
    public $name;
    public $icon;

    private $category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->icon = new IconForm();
            $this->category = $category;
        } else {
            $this->icon = new IconForm();
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'max' => 100],
            [['name'], 'unique', 'targetClass' => Category::class, 'filter' => $this->category ? ['<>', 'id', $this->category->id] : null]
        ];
    }

    protected function internalForms(): array
    {
        return ['icon'];
    }
}