<?php

namespace api\core\entities;

use core\entities\Theme\Theme as BaseTheme;
use yii\helpers\Url;
use yii\web\Linkable;

class Theme extends BaseTheme implements Linkable
{
    public function getLinks()
    {
        return [
            'self' => $this->theme(),
        ];
    }

    private function theme(): string
    {
        return Url::to(['theme/view', 'id' => $this->id], true);
    }

    public function fields()
    {
        return [
            'id',
            'category_id',
            'level_id',
            'name',
            'image',
            'words_count' => function (Theme $theme) {
                return $theme->getWordsCount();
            },
            'words' => function (Theme $theme) {
                return $theme->words;
            },
        ];
    }
}