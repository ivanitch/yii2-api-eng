<?php

namespace core\forms\manage\Theme;

use core\entities\Category\Category;
use core\entities\Level\Level;
use core\entities\Theme\Theme;
use core\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property ImageForm $image;
 */

class ThemeForm extends CompositeForm
{
    public $category_id;
    public $level_id;
    public $name;

    private $theme;

    public function __construct(Theme $theme = null, $config = [])
    {
        if ($theme) {
            $this->category_id = $theme->category;
            $this->level_id = $theme->level;
            $this->name = $theme->name;
            $this->image = new ImageForm();
            $this->theme = $theme;
        } else {
            $this->image = new ImageForm();
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['category_id', 'level_id', 'name'], 'required'],
            ['name', 'string', 'max' => 100],
            [['category_id', 'level_id'], 'integer'],
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function levelsList(): array
    {
        return ArrayHelper::map(Level::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['image'];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
            'level_id' => 'level',
        ];
    }
}