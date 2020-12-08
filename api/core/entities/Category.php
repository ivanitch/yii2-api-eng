<?php

namespace api\core\entities;

use core\entities\Category\Category as BaseCategory;
use yii\helpers\Url;
use yii\web\Linkable;

class Category extends BaseCategory implements Linkable
{
    public function getLinks()
    {
        return [
            'self' => $this->category(),
        ];
    }

    private function category(): string
    {
        return Url::to(['category/view', 'id' => $this->id], true);
    }
}