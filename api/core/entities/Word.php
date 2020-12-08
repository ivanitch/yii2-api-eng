<?php

namespace api\core\entities;

use core\entities\Word\Word as BaseWord;
use yii\helpers\Url;
use yii\web\Linkable;

class Word extends BaseWord implements Linkable
{
    public function getLinks()
    {
        return [
            'self' => $this->word(),
        ];
    }

    private function word(): string
    {
        return Url::to(['word/view', 'id' => $this->id], true);
    }
}